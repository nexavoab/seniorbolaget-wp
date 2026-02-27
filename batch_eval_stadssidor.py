#!/usr/bin/env python3
"""
Gemini 360° utvärdering av alla 26 stadssidor.
Screenshots → komprimering → Gemini scoring → rapport.
Mål: ≥9/10 på samtliga.
"""
import asyncio, subprocess, json, re, sys
from pathlib import Path
from PIL import Image

BASE_URL = "http://localhost:8888"
COMP_DIR = Path("comparison")
COMP_DIR.mkdir(exist_ok=True)

CITIES = [
    ("amal",           "Åmål",             "/har-finns-vi/amal"),
    ("boras",          "Borås",            "/har-finns-vi/boras"),
    ("eskilstuna",     "Eskilstuna",       "/har-finns-vi/eskilstuna"),
    ("falkenberg",     "Falkenberg",       "/har-finns-vi/falkenberg"),
    ("goteborg",       "Göteborg",         "/har-finns-vi/goteborg-sv"),
    ("halmstad",       "Halmstad",         "/har-finns-vi/halmstad"),
    ("helsingborg",    "Helsingborg",      "/har-finns-vi/helsingborg"),
    ("jonkoping",      "Jönköping",        "/har-finns-vi/jonkoping"),
    ("karlstad",       "Karlstad",         "/har-finns-vi/karlstad"),
    ("kristianstad",   "Kristianstad",     "/har-finns-vi/kristianstad"),
    ("kungalv",        "Kungälv",          "/har-finns-vi/kungalv"),
    ("kungsbacka",     "Kungsbacka",       "/har-finns-vi/kungsbacka"),
    ("laholm",         "Laholm/Båstad",    "/har-finns-vi/laholm-bastad"),
    ("landskrona",     "Landskrona",       "/har-finns-vi/landskrona"),
    ("lerum",          "Lerum/Partille",   "/har-finns-vi/lerum-partille"),
    ("molndal",        "Mölndal/Härryda",  "/har-finns-vi/molndal-harryda"),
    ("nassjo",         "Nässjö",           "/har-finns-vi/nassjo"),
    ("orebro",         "Örebro",           "/har-finns-vi/orebro"),
    ("skovde",         "Skövde",           "/har-finns-vi/skovde"),
    ("stenungsund",    "Stenungsund",      "/har-finns-vi/stenungsund"),
    ("sundsvall",      "Sundsvall",        "/har-finns-vi/sundsvall"),
    ("torsby",         "Torsby",           "/har-finns-vi/torsby"),
    ("trelleborg",     "Trelleborg",       "/har-finns-vi/trelleborg"),
    ("trollhattan",    "Trollhättan",      "/har-finns-vi/trollhattan"),
    ("ulricehamn",     "Ulricehamn",       "/har-finns-vi/ulricehamn"),
    ("varberg",        "Varberg",          "/har-finns-vi/varberg"),
]

async def screenshot_city(browser, slug, name, url):
    out_png = COMP_DIR / f"{slug}_staging.png"
    out_jpg = COMP_DIR / f"{slug}_staging_small.jpg"
    
    try:
        page = await browser.new_page()
        page.set_default_timeout(20000)
        await page.goto(f"{BASE_URL}{url}", wait_until="networkidle")
        await page.wait_for_timeout(1500)
        await page.evaluate("window.scrollTo(0,document.body.scrollHeight)")
        await page.wait_for_timeout(600)
        await page.evaluate("window.scrollTo(0,0)")
        await page.wait_for_timeout(400)
        await page.screenshot(path=str(out_png), full_page=True)
        await page.close()
        
        # Komprimera
        img = Image.open(out_png)
        if img.width > 1200:
            img = img.resize((1200, int(img.height * 1200 / img.width)), Image.LANCZOS)
        img.save(out_jpg, "JPEG", quality=75)
        size_kb = out_jpg.stat().st_size // 1024
        height = img.height
        print(f"  📸 {name}: {size_kb}KB ({height}px)")
        return True
    except Exception as e:
        print(f"  ❌ {name}: {e}")
        return False

def gemini_score(slug, name):
    jpg = COMP_DIR / f"{slug}_staging_small.jpg"
    if not jpg.exists():
        return None, "Ingen bild"
    
    prompt = f"""ANALYSERA ENBART BILDEN. Inga verktyg. Inget webbläsare.

@comparison/{slug}_staging_small.jpg

Du utvärderar en SEO-landningssida för hemtjänster i {name} (Seniorbolaget).
Målgrupp: äldre 65+ och deras familjer. Fokus: förtroende, lokal närvaro, konvertering.

Utvärdera dessa 5 dimensioner (1-10 varje):
1. VISUELL HIERARKI: Tydlig rubrik, scannbar layout, rätt fokus
2. FÖRTROENDE: Foto/avatar på franchisetagare, bio, omdömen, verifieringsbadge
3. LOKAL RELEVANS: Stadsspecifik copy, täckningsområden, lokal kontakt
4. KONVERTERING: CTA-tydlighet, friktion, urgency
5. MOBILKÄNSLA: Responsivt, touch-vänligt, snabbt läsbart

SVAGHETER: (max 3 konkreta punkter)
QUICK WINS: (max 2 fixes om betyg <9)
TOTALBETYG: X/10"""
    
    result = subprocess.run(
        ["gemini", "-m", "gemini-2.5-flash", "--yolo", "-p", prompt],
        capture_output=True, text=True, timeout=240,
        cwd="/home/exedev/seniorbolaget-wp"
    )
    output = result.stdout + result.stderr
    
    # Extrahera betyg
    match = re.search(r'TOTALBETYG[:\s]*(\d+(?:\.\d+)?)/10', output, re.IGNORECASE)
    if not match:
        match = re.search(r'(\d+(?:\.\d+)?)/10', output)
    score = float(match.group(1)) if match else None
    
    # Spara rapport
    report_file = COMP_DIR / f"eval_{slug}.md"
    report_file.write_text(f"# Gemini eval: {name}\n\n{output}", encoding="utf-8")
    
    return score, output

async def main():
    from playwright.async_api import async_playwright
    
    print("=" * 60)
    print("Seniorbolaget — Gemini 360° stadssida-utvärdering")
    print("=" * 60)
    
    # STEG 1: Screenshots
    mode = sys.argv[1] if len(sys.argv) > 1 else "all"
    cities_to_eval = CITIES
    if mode == "quick":
        # Snabb läge: bara 5 representativa städer
        cities_to_eval = [c for c in CITIES if c[0] in ("goteborg","boras","sundsvall","helsingborg","amal")]
        print(f"\nSNABBLÄGE: 5 representativa städer")
    
    print(f"\n📸 Tar screenshots av {len(cities_to_eval)} städer...")
    async with async_playwright() as pw:
        browser = await pw.chromium.launch()
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
        
        # Batch i grupper om 4
        for i in range(0, len(cities_to_eval), 4):
            batch = cities_to_eval[i:i+4]
            tasks = [screenshot_city(ctx, slug, name, url) for slug, name, url in batch]
            await asyncio.gather(*tasks)
        
        await browser.close()
    
    # STEG 2: Gemini scoring
    print(f"\n🤖 Kör Gemini-scoring...")
    results = []
    
    for slug, name, url in cities_to_eval:
        jpg = COMP_DIR / f"{slug}_staging_small.jpg"
        if not jpg.exists():
            print(f"  ⚠️  {name}: saknar bild, hoppar")
            continue
        
        print(f"  🔍 Utvärderar {name}...", end="", flush=True)
        output_path = COMP_DIR / f"eval_{slug}_batch.md"
        if output_path.exists() and output_path.stat().st_size > 100:
            with open(output_path) as f:
                existing = f.read()
            import re as _re
            m = _re.search(r"TOTALBETYG.*?(\d+\.?\d*)/10", existing)
            if m:
                score = float(m.group(1))
                print(f" ⏭️  {score}/10 (cached)")
                results.append({"city": name, "slug": slug, "score": score})
                continue
        score, output = gemini_score(slug, name)
        
        status = "✅" if score and score >= 9 else ("⚠️" if score and score >= 7 else "❌")
        print(f" {status} {score}/10")
        results.append({"city": name, "slug": slug, "score": score})
    
    # STEG 3: Rapport
    print("\n" + "=" * 60)
    print("RESULTAT")
    print("=" * 60)
    
    passed = [r for r in results if r["score"] and r["score"] >= 9]
    needs_fix = [r for r in results if not r["score"] or r["score"] < 9]
    
    print(f"\n✅ Godkända (≥9/10): {len(passed)}/{len(results)}")
    for r in passed:
        print(f"   {r['city']}: {r['score']}/10")
    
    if needs_fix:
        print(f"\n⚠️  Behöver fix (<9/10): {len(needs_fix)}")
        for r in needs_fix:
            print(f"   {r['city']}: {r['score']}/10")
    
    # Spara JSON
    summary = {
        "total": len(results),
        "passed": len(passed),
        "needs_fix": len(needs_fix),
        "all_pass": len(needs_fix) == 0,
        "results": results
    }
    (COMP_DIR / "eval_summary.json").write_text(json.dumps(summary, ensure_ascii=False, indent=2))
    
    if len(needs_fix) == 0:
        print(f"\n🎉 GODKÄNT — alla {len(results)} städer ≥9/10!")
    else:
        print(f"\n⚠️  {len(needs_fix)} städer under 9/10 — se comparison/eval_*.md för fixes")
    
    return len(needs_fix) == 0

if __name__ == "__main__":
    asyncio.run(main())
