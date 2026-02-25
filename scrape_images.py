#!/usr/bin/env python3
"""
scrape_images.py — Laddar ner alla bilder från seniorbolaget.se
Sparar till scraped/images/ för import till WP
"""
import asyncio, re, os, hashlib
from pathlib import Path
from urllib.parse import urljoin, urlparse
from playwright.async_api import async_playwright

BASE_URL = "https://seniorbolaget.se"
OUT_DIR = Path("scraped/images")
OUT_DIR.mkdir(parents=True, exist_ok=True)

async def scrape_images():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
        page = await ctx.new_page()

        downloaded = []
        
        await page.goto(BASE_URL, wait_until="networkidle", timeout=30000)
        await page.wait_for_timeout(3000)
        
        # Scroll för att ladda lazy images
        for _ in range(5):
            await page.evaluate("window.scrollBy(0, 800)")
            await page.wait_for_timeout(500)
        await page.evaluate("window.scrollTo(0, 0)")

        # Hämta alla img-src och bakgrundsbilder
        images = await page.evaluate("""() => {
            const imgs = [];
            // Standard img-taggar
            document.querySelectorAll('img').forEach(img => {
                if (img.src && !img.src.startsWith('data:')) imgs.push({url: img.src, alt: img.alt || '', type: 'img'});
                if (img.srcset) {
                    img.srcset.split(',').forEach(s => {
                        const url = s.trim().split(' ')[0];
                        if (url && !url.startsWith('data:')) imgs.push({url, alt: img.alt || '', type: 'srcset'});
                    });
                }
            });
            // CSS bakgrundsbilder
            document.querySelectorAll('*').forEach(el => {
                const bg = window.getComputedStyle(el).backgroundImage;
                if (bg && bg !== 'none' && bg.includes('url')) {
                    const match = bg.match(/url\\(['"]?([^'"\\)]+)['"]?\\)/);
                    if (match && !match[1].startsWith('data:')) imgs.push({url: match[1], alt: '', type: 'bg'});
                }
            });
            return imgs;
        }""")

        print(f"Hittade {len(images)} bild-URLs")
        
        seen = set()
        for img in images:
            url = img['url']
            if url in seen: continue
            seen.add(url)
            
            # Skippa ikoner och SVG under 500px
            if url.endswith('.svg') and 'logo' not in url.lower():
                continue
                
            full_url = url if url.startswith('http') else urljoin(BASE_URL, url)
            
            try:
                # Ladda ner via Playwright context
                response = await ctx.request.get(full_url)
                if response.status == 200:
                    content = await response.body()
                    if len(content) < 5000:  # Skip tiny images (icons)
                        continue
                    
                    # Filnamn baserat på URL
                    parsed = urlparse(full_url)
                    filename = Path(parsed.path).name
                    if not filename or '.' not in filename:
                        ext = 'jpg'
                        h = hashlib.md5(full_url.encode()).hexdigest()[:8]
                        filename = f"img_{h}.{ext}"
                    
                    out_path = OUT_DIR / filename
                    # Hantera duplikat
                    if out_path.exists():
                        h = hashlib.md5(full_url.encode()).hexdigest()[:6]
                        out_path = OUT_DIR / f"{out_path.stem}_{h}{out_path.suffix}"
                    
                    out_path.write_bytes(content)
                    size_kb = len(content) // 1024
                    print(f"  ✓ {filename} ({size_kb}KB) — {img['type']}")
                    downloaded.append({"file": str(out_path), "url": full_url, "alt": img['alt'], "size_kb": size_kb})
            except Exception as e:
                print(f"  ✗ {full_url[:60]}: {e}")

        await browser.close()

    print(f"\n✅ Nedladdade {len(downloaded)} bilder till {OUT_DIR}/")
    
    # Spara manifest
    import json
    manifest = OUT_DIR / "manifest.json"
    manifest.write_text(json.dumps(downloaded, indent=2, ensure_ascii=False))
    print(f"Manifest: {manifest}")
    
    return downloaded

if __name__ == "__main__":
    asyncio.run(scrape_images())
