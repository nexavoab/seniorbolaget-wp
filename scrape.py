#!/usr/bin/env python3
"""
Scrape all pages from seniorbolaget.se using Playwright for JS-rendered content.
Framer sites require full browser rendering - urllib/requests won't work.
"""
import asyncio
import json
import os
import re
from playwright.async_api import async_playwright, TimeoutError as PlaywrightTimeout

BASE_URL = "https://www.seniorbolaget.se"
OUT_DIR = os.path.join(os.path.dirname(__file__), "scraped")
os.makedirs(OUT_DIR, exist_ok=True)

PAGES = [
    "/",
    "/privat",
    "/privat/hemstad",
    "/privat/malning",
    "/privat/snickeri",
    "/privat/tradgard",
    "/företag",
    "/företag/bemanning",
    "/företag/for-brfer",
    "/företag/foretagstjanster",
    "/har-finns-vi",
    "/bli-franchisetagare",
    "/jobba-med-oss",
    "/om-oss",
    "/kontakt",
    "/intresse-anmalan",
    "/blog/10-essential-tips-for-a-home-construction",
    "/blog/7-essential-factors-for-choosing-the-right-builder",
    "/blog/designing-your-dream-home-a-comprehensive-step-by-step-guide",
    "/blog/innovations-shaping-the-future-of-sustainable-construction",
    "/blog/sustainable-building-practices-how-to-build-an-eco-friendly-home",
    "/blog/top-trends-in-modern-home-construction-what-to-expect-in-2024",
    "/våra-projekt/asian-heights",
    "/våra-projekt/foyez-lake-view",
    "/våra-projekt/hill-community",
    "/våra-projekt/jackson-tower",
    "/våra-projekt/liamson-tower",
]

# Location pages
LOCATIONS = [
    "amal", "boras", "eskilstuna", "falkenberg", "goteborg-sv", "halmstad",
    "helsingborg", "jonkoping", "karlstad", "kristianstad", "kungalv", "kungsbacka",
    "laholm-bastad", "landskrona", "lerum-partille", "molndal-harryda", "nassjo",
    "orebro", "skovde", "stenungsund", "sundsvall", "torsby", "trelleborg",
    "trollhattan", "ulricehamn", "varberg"
]
for loc in LOCATIONS:
    PAGES.append(f"/har-finns-vi/{loc}")


def slug(url: str) -> str:
    """Convert URL path to safe filename slug."""
    s = url.strip("/").replace("/", "__")
    s = re.sub(r'[^\w\-_]', '_', s)
    return s or "index"


# JavaScript to extract styles and content from the rendered page
EXTRACT_JS = r"""
() => {
    const result = {
        title: document.title,
        styles: {},
        sectionBackgrounds: [],
        textContent: [],
        images: []
    };
    
    // Extract computed styles for key elements
    const styleTargets = ['body', 'h1', 'h2', 'h3', 'p', 'button', 'a'];
    for (const selector of styleTargets) {
        const elements = document.querySelectorAll(selector);
        if (elements.length > 0) {
            const el = elements[0];
            const style = window.getComputedStyle(el);
            result.styles[selector] = {
                'background-color': style.backgroundColor,
                'color': style.color,
                'font-family': style.fontFamily,
                'font-size': style.fontSize
            };
        }
    }
    
    // Find unique background colors on section/div elements
    const bgColors = new Set();
    document.querySelectorAll('section, div').forEach(el => {
        const style = window.getComputedStyle(el);
        const bg = style.backgroundColor;
        // Only include non-transparent colors
        if (bg && bg !== 'rgba(0, 0, 0, 0)' && bg !== 'transparent') {
            bgColors.add(bg);
        }
    });
    result.sectionBackgrounds = Array.from(bgColors);
    
    // Extract structured text content
    const textSelectors = [
        { selector: 'h1', type: 'heading1' },
        { selector: 'h2', type: 'heading2' },
        { selector: 'h3', type: 'heading3' },
        { selector: 'h4', type: 'heading4' },
        { selector: 'p', type: 'paragraph' },
        { selector: 'li', type: 'listitem' },
        { selector: 'span', type: 'span' },
        { selector: 'button', type: 'button' },
        { selector: 'a', type: 'link' }
    ];
    
    const seenText = new Set();
    for (const { selector, type } of textSelectors) {
        document.querySelectorAll(selector).forEach(el => {
            // Check if element is visible
            const style = window.getComputedStyle(el);
            if (style.display === 'none' || style.visibility === 'hidden' || style.opacity === '0') {
                return;
            }
            
            // Get direct text content (not from children)
            let text = '';
            for (const node of el.childNodes) {
                if (node.nodeType === Node.TEXT_NODE) {
                    text += node.textContent;
                }
            }
            text = text.trim();
            
            // Also get full text for headings
            if (type.startsWith('heading') && !text) {
                text = el.textContent.trim();
            }
            
            if (text && text.length > 1 && !seenText.has(text)) {
                seenText.add(text);
                result.textContent.push({
                    type: type,
                    text: text,
                    tag: selector.toUpperCase()
                });
            }
        });
    }
    
    // Extract all images
    document.querySelectorAll('img').forEach(img => {
        const src = img.src || img.dataset.src || '';
        const alt = img.alt || '';
        if (src) {
            result.images.push({ src, alt });
        }
    });
    
    // Also find background images
    document.querySelectorAll('*').forEach(el => {
        const style = window.getComputedStyle(el);
        const bgImage = style.backgroundImage;
        if (bgImage && bgImage !== 'none') {
            const urlMatch = bgImage.match(/url\(["']?(.+?)["']?\)/);
            if (urlMatch && urlMatch[1]) {
                result.images.push({ src: urlMatch[1], alt: 'background-image' });
            }
        }
    });
    
    return result;
}
"""


async def scrape_page(page, url: str, page_path: str, retries: int = 2) -> dict:
    """Scrape a single page with retry logic."""
    slug_name = slug(page_path)
    
    for attempt in range(retries + 1):
        try:
            print(f"  Attempt {attempt + 1}/{retries + 1}...")
            
            # Navigate and wait for network idle (JS fully loaded)
            await page.goto(url, wait_until='networkidle', timeout=60000)
            
            # Extra wait for any late JS rendering
            await page.wait_for_timeout(2000)

            # Scrolla igenom sidan för att trigga Framers scroll-animationer
            # och lazy-load av innehåll (intersection observer)
            await page.evaluate("""
                async () => {
                    const height = document.body.scrollHeight;
                    const step = 300;
                    for (let y = 0; y < height; y += step) {
                        window.scrollTo(0, y);
                        await new Promise(r => setTimeout(r, 80));
                    }
                    window.scrollTo(0, 0);
                    await new Promise(r => setTimeout(r, 1000));
                }
            """)
            
            # Take full-page screenshot
            screenshot_path = os.path.join(OUT_DIR, f"{slug_name}.png")
            await page.screenshot(path=screenshot_path, full_page=True)
            print(f"  📸 Screenshot saved: {slug_name}.png")
            
            # Extract data via JavaScript
            data = await page.evaluate(EXTRACT_JS)
            data['url'] = url
            data['path'] = page_path
            data['slug'] = slug_name
            
            # Save JSON
            json_path = os.path.join(OUT_DIR, f"{slug_name}.json")
            with open(json_path, 'w', encoding='utf-8') as f:
                json.dump(data, f, ensure_ascii=False, indent=2)
            print(f"  📄 Data saved: {slug_name}.json")
            
            return {
                'success': True,
                'slug': slug_name,
                'title': data.get('title', ''),
                'textCount': len(data.get('textContent', [])),
                'imageCount': len(data.get('images', [])),
                'styleCount': len(data.get('styles', {})),
                'sectionBgCount': len(data.get('sectionBackgrounds', []))
            }
            
        except PlaywrightTimeout as e:
            print(f"  ⚠️ Timeout on attempt {attempt + 1}: {e}")
            if attempt == retries:
                return {'success': False, 'slug': slug_name, 'error': f'Timeout: {e}'}
        except Exception as e:
            print(f"  ⚠️ Error on attempt {attempt + 1}: {e}")
            if attempt == retries:
                return {'success': False, 'slug': slug_name, 'error': str(e)}
    
    return {'success': False, 'slug': slug_name, 'error': 'Unknown error'}


async def main():
    print(f"🚀 Starting Playwright scraper for {len(PAGES)} pages...")
    print(f"📁 Output directory: {OUT_DIR}\n")
    
    results = {}
    
    async with async_playwright() as p:
        # Launch headless Chromium
        browser = await p.chromium.launch(headless=True)
        context = await browser.new_context(
            viewport={'width': 1920, 'height': 1080},
            user_agent='Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        )
        page = await context.new_page()
        
        for i, page_path in enumerate(PAGES, 1):
            url = BASE_URL + page_path
            print(f"\n[{i}/{len(PAGES)}] {url}")
            
            result = await scrape_page(page, url, page_path)
            results[page_path] = result
            
            if result['success']:
                print(f"  ✅ Success: {result['textCount']} text elements, {result['imageCount']} images")
            else:
                print(f"  ❌ Failed: {result.get('error', 'Unknown')}")
        
        await browser.close()
    
    # Save summary
    summary_path = os.path.join(OUT_DIR, "_summary.json")
    with open(summary_path, 'w', encoding='utf-8') as f:
        json.dump(results, f, ensure_ascii=False, indent=2)
    
    # Print final stats
    success_count = sum(1 for r in results.values() if r.get('success'))
    print(f"\n{'='*50}")
    print(f"✅ Done! Scraped {success_count}/{len(PAGES)} pages successfully")
    print(f"📁 Output: {OUT_DIR}")
    print(f"📊 Summary: {summary_path}")


if __name__ == '__main__':
    asyncio.run(main())
