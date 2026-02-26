#!/usr/bin/env python3
"""
compare.py — tar fullpage screenshots av original + WP staging
Sparar till comparison/ för Gemini-analys
"""
import asyncio
import os
import json
from pathlib import Path
from playwright.async_api import async_playwright

ORIGINAL_URL = "https://seniorbolaget.se"
STAGING_URL = "http://localhost:8888"
OUT_DIR = Path("comparison")
OUT_DIR.mkdir(exist_ok=True)

PAGES = [
    {"slug": "index",           "original": "/",                    "staging": "/"},
    {"slug": "hemstad",         "original": "/privat/hemstad",      "staging": "/privat/hemstad/"},
    {"slug": "tradgard",        "original": "/privat/tradgard",     "staging": "/privat/tradgard/"},
    {"slug": "malning",         "original": "/privat/malning",      "staging": "/privat/malning-tapetsering/"},
    {"slug": "snickeri",        "original": "/privat/snickeri",     "staging": "/privat/snickeri/"},
    {"slug": "om-oss",          "original": "/om-oss",              "staging": "/om-oss/"},
    {"slug": "kontakt",         "original": "/kontakt",             "staging": "/kontakt/"},
]

async def screenshot_page(page, url, out_path):
    print(f"  → {url}")
    await page.goto(url, wait_until="networkidle", timeout=30000)
    await page.wait_for_timeout(2000)
    # Scroll igenom för att trigga lazy-load
    await page.evaluate("window.scrollTo(0, document.body.scrollHeight)")
    await page.wait_for_timeout(1000)
    await page.evaluate("window.scrollTo(0, 0)")
    await page.wait_for_timeout(500)
    await page.screenshot(path=str(out_path), full_page=True)
    print(f"  ✓ Sparad: {out_path} ({os.path.getsize(out_path)//1024}KB)")

async def main():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        
        for page_def in PAGES:
            slug = page_def["slug"]
            print(f"\n[{slug}]")
            
            # Original
            orig_path = OUT_DIR / f"{slug}_original.png"
            ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
            orig_page = await ctx.new_page()
            await screenshot_page(orig_page, ORIGINAL_URL + page_def["original"], orig_path)
            await ctx.close()
            
            # WP Staging
            staging_path = OUT_DIR / f"{slug}_staging.png"
            ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
            staging_page = await ctx.new_page()
            await screenshot_page(staging_page, STAGING_URL + page_def["staging"], staging_path)
            await ctx.close()

        await browser.close()

    print("\n✅ Klart! Bilder i comparison/")
    files = list(OUT_DIR.glob("*.png"))
    for f in sorted(files):
        print(f"  {f.name}: {f.stat().st_size//1024}KB")

if __name__ == "__main__":
    import sys
    # Kör specifik slug: python compare.py hemstad
    if len(sys.argv) > 1:
        slug_filter = sys.argv[1]
        PAGES[:] = [p for p in PAGES if p["slug"] == slug_filter]
        if not PAGES:
            print(f"❌ Slug '{slug_filter}' finns inte. Tillgängliga: {[p['slug'] for p in PAGES]}")
            sys.exit(1)
    asyncio.run(main())
