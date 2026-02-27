#!/usr/bin/env python3
"""Take full-page screenshots of all 26 city pages."""

import asyncio
from pathlib import Path
from PIL import Image
from playwright.async_api import async_playwright

BASE_URL = "http://localhost:8888"
OUTPUT_DIR = Path(__file__).parent

CITIES = {
    "amal": "/har-finns-vi/amal",
    "boras": "/har-finns-vi/boras",
    "eskilstuna": "/har-finns-vi/eskilstuna",
    "falkenberg": "/har-finns-vi/falkenberg",
    "goteborg": "/har-finns-vi/goteborg-sv",
    "halmstad": "/har-finns-vi/halmstad",
    "helsingborg": "/har-finns-vi/helsingborg",
    "jonkoping": "/har-finns-vi/jonkoping",
    "karlstad": "/har-finns-vi/karlstad",
    "kristianstad": "/har-finns-vi/kristianstad",
    "kungalv": "/har-finns-vi/kungalv",
    "kungsbacka": "/har-finns-vi/kungsbacka",
    "laholm": "/har-finns-vi/laholm-bastad",
    "landskrona": "/har-finns-vi/landskrona",
    "lerum": "/har-finns-vi/lerum-partille",
    "molndal": "/har-finns-vi/molndal-harryda",
    "nassjo": "/har-finns-vi/nassjo",
    "orebro": "/har-finns-vi/orebro",
    "skovde": "/har-finns-vi/skovde",
    "stenungsund": "/har-finns-vi/stenungsund",
    "sundsvall": "/har-finns-vi/sundsvall",
    "torsby": "/har-finns-vi/torsby",
    "trelleborg": "/har-finns-vi/trelleborg",
    "trollhattan": "/har-finns-vi/trollhattan",
    "ulricehamn": "/har-finns-vi/ulricehamn",
    "varberg": "/har-finns-vi/varberg",
}

async def take_screenshot(page, slug: str, path: str) -> bool:
    """Take a screenshot of a city page."""
    url = f"{BASE_URL}{path}"
    output_png = OUTPUT_DIR / f"{slug}_staging.png"
    output_jpg = OUTPUT_DIR / f"{slug}_staging_small.jpg"
    
    try:
        print(f"📸 {slug}: {url}")
        await page.goto(url, wait_until="networkidle", timeout=30000)
        await page.wait_for_timeout(1000)  # Extra wait for lazy-loaded content
        
        # Take full-page screenshot
        await page.screenshot(path=str(output_png), full_page=True)
        
        # Compress to JPG, max 1200px wide, quality 75
        with Image.open(output_png) as img:
            # Calculate new height maintaining aspect ratio
            if img.width > 1200:
                ratio = 1200 / img.width
                new_size = (1200, int(img.height * ratio))
                img = img.resize(new_size, Image.LANCZOS)
            
            # Convert to RGB (required for JPEG)
            if img.mode in ('RGBA', 'P'):
                img = img.convert('RGB')
            
            img.save(output_jpg, 'JPEG', quality=75, optimize=True)
        
        # Remove PNG to save space
        output_png.unlink()
        
        print(f"   ✅ Saved: {output_jpg.name}")
        return True
        
    except Exception as e:
        print(f"   ❌ Failed: {e}")
        return False

async def main():
    OUTPUT_DIR.mkdir(exist_ok=True)
    
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        context = await browser.new_context(
            viewport={"width": 1280, "height": 800},
            device_scale_factor=1
        )
        page = await context.new_page()
        
        results = {"success": [], "failed": []}
        
        for slug, path in CITIES.items():
            success = await take_screenshot(page, slug, path)
            if success:
                results["success"].append(slug)
            else:
                results["failed"].append(slug)
        
        await browser.close()
    
    print(f"\n📊 Results: {len(results['success'])}/26 successful")
    if results["failed"]:
        print(f"❌ Failed: {', '.join(results['failed'])}")
    
    return results

if __name__ == "__main__":
    asyncio.run(main())
