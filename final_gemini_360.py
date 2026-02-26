#!/usr/bin/env python3
"""
Final Gemini 360° — Benchmarkar ALLA sidor mot Hemfrid/Helpling.
Mål: ≥9/10 (45/50 poäng) på samtliga sidor.
Kör EFTER att alla agenter rapporterat klart.
"""
import asyncio, subprocess, json, re
from pathlib import Path
from PIL import Image

BASE_URL = "http://localhost:8888"
COMP = Path("comparison")
COMP.mkdir(exist_ok=True)

# Alla sidor att evaluera
PAGES = [
    # (slug, display_name, url)
    ("startsida",        "Startsidan",          "/"),
    ("hemstad",          "Hemstädning",          "/privat/hemstad/"),
    ("tradgard",         "Trädgård",             "/privat/tradgard/"),
    ("malning",          "Målning & tapetsering","/privat/malning-tapetsering/"),
    ("snickeri",         "Snickeri",             "/privat/snickeri/"),
    ("goteborg",         "Göteborg (stadssida)", "/har-finns-vi/goteborg-sv/"),
    ("boras",            "Borås (stadssida)",    "/har-finns-vi/boras/"),
    ("sundsvall",        "Sundsvall (stadssida)","/har-finns-vi/sundsvall/"),
    ("om-oss",           "Om oss",               "/om-oss/"),
    ("jobba-med-oss",    "Jobba med oss",        "/jobba-med-oss/"),
    ("bli-franchisere",  "Bli franchisetagare",  "/bli-franchisetagare/"),
    ("intresse",         "Intresseanmälan",      "/intresse-anmalan/"),
    ("kontakt",          "Kontakt",              "/kontakt/"),
]

# Resterar 23 stadssidor (testar 5 representativa + alla om tid finns)
STAD_SAMPLE = [
    ("helsingborg", "Helsingborg", "/har-finns-vi/helsingborg/"),
    ("malmoe",      "Malmö",       "/har-finns-vi/malmo/"),  # om den finns
    ("karlstad",    "Karlstad",    "/har-finns-vi/karlstad/"),
    ("orebro",      "Örebro",      "/har-finns-vi/orebro/"),
    ("varberg",     "Varberg",     "/har-finns-vi/varberg/"),
]

BENCHMARK_PROMPT = """ANALYSERA ENBART BILDEN. Inga verktyg. Inga webbläsare.

@comparison/{slug}_eval.jpg

Du utvärderar sidan "{page_name}" (Seniorbolaget — hemtjänst, målgrupp 65+).
Benchmarka mot branschledarna Hemfrid.se och Helpling.se.

BEDÖM 10 KRITERIER (1-5 poäng varje, max 50 totalt):
1. VÄRDEERBJUDANDE: Klart, relevant och emotionellt tilltalande?
2. CTA-TYDLIGHET: Enkel och framträdande Call-to-Action?
3. VISUELL TROVÄRDIGHET: Professionell, pålitlig design?
4. ANVÄNDARVÄNLIGHET: Lättnavigerad, logisk struktur?
5. FÖRTROENDESIGNALER: Recensioner, garantier, certifikat, lokalt ankare?
6. TJÄNSTEPRESENTATION: Tydlig med kundnytta i fokus?
7. MÅLGRUPPSANPASSNING: Tilltalar 65+ specifikt (ton, typsnitt, bilder)?
8. USP: Unikt säljargument som skiljer från Hemfrid/Helpling?
9. MINIMAL DISTRAKTION: Fri från onödiga element?
10. SNABB ÖVERSIKT: Förstår man sidan på 5 sekunder?

FORMAT:
1. Värdeerbjudande: X/5
2. CTA-tydlighet: X/5
...
10. Snabb översikt: X/5

TOTALT: XX/50
BETYG: X.X/10

STARKASTE PUNKTER: (2 konkreta)
VIKTIGASTE FIX: (max 2 om under 45/50)
VS HEMFRID: Vad gör vi bättre? Vad gör de bättre?"""

async def screenshot(browser, slug, name, url):
    png = COMP / f"{slug}_raw.png"
    jpg = COMP / f"{slug}_eval.jpg"
    try:
        page = await browser.new_page()
        await page.goto(f"{BASE_URL}{url}", wait_until="networkidle", timeout=25000)
        await page.wait_for_timeout(2000)
        await page.screenshot(path=str(png), full_page=True)
        img = Image.open(png)
        r = img.resize((1200, int(img.height * 1200 / img.width)), Image.LANCZOS)
        r.save(jpg, "JPEG", quality=75)
        kb = jpg.stat().st_size // 1024
        print(f"  📸 {name}: {kb}KB ({img.height}px)")
        await page.close()
        return True
    except Exception as e:
        print(f"  ❌ {name}: {e}")
        return False

def score(slug, name):
    jpg = COMP / f"{slug}_eval.jpg"
    if not jpg.exists():
        return None, "Ingen bild"

    prompt = BENCHMARK_PROMPT.format(slug=slug, page_name=name)
    try:
        r = subprocess.run(
            ["gemini", "-m", "gemini-2.5-flash", "--yolo", "-p", prompt],
            capture_output=True, text=True, timeout=120,
            cwd="/home/exedev/seniorbolaget-wp"
        )
        output = r.stdout
        # Extrahera TOTALT: XX/50
        m = re.search(r'TOTALT:\s*(\d+)/50', output)
        total = int(m.group(1)) if m else None
        # Extrahera BETYG: X.X/10
        m2 = re.search(r'BETYG:\s*([\d.]+)/10', output)
        rating = float(m2.group(1)) if m2 else (total / 5 if total else None)
        (COMP / f"eval_{slug}_360.md").write_text(f"# 360° Eval: {name}\n\n{output}")
        return rating, output
    except Exception as e:
        return None, str(e)

async def main():
    import sys
    quick = "quick" in sys.argv

    print("=" * 60)
    print("Seniorbolaget — Gemini 360° Branschbenchmark")
    print("Referens: Hemfrid.se, Helpling.se")
    print("=" * 60)

    pages = PAGES + (STAD_SAMPLE if not quick else [])

    print(f"\n📸 Screenshots ({len(pages)} sidor)...")
    from playwright.async_api import async_playwright
    async with async_playwright() as pw:
        b = await pw.chromium.launch()
        ctx = await b.new_context(viewport={"width": 1440, "height": 900})
        for i in range(0, len(pages), 3):
            batch = pages[i:i+3]
            await asyncio.gather(*[screenshot(ctx, s, n, u) for s, n, u in batch])
        await b.close()

    print(f"\n🤖 Gemini benchmark-scoring...")
    results = []
    for slug, name, _ in pages:
        print(f"  🔍 {name}...", end="", flush=True)
        rating, _ = score(slug, name)
        status = "✅" if rating and rating >= 9 else ("⚠️" if rating and rating >= 7 else "❌")
        print(f" {status} {rating}/10")
        results.append({"page": name, "slug": slug, "rating": rating})

    # Rapport
    print("\n" + "=" * 60)
    print("FINAL RAPPORT")
    print("=" * 60)

    passed = [r for r in results if r["rating"] and r["rating"] >= 9]
    fix = [r for r in results if not r["rating"] or r["rating"] < 9]

    print(f"\n✅ Godkända (≥9/10): {len(passed)}/{len(results)}")
    for r in sorted(passed, key=lambda x: x["rating"] or 0, reverse=True):
        print(f"   {r['page']}: {r['rating']}/10")

    if fix:
        print(f"\n⚠️  Behöver fix: {len(fix)}")
        for r in fix:
            print(f"   {r['page']}: {r['rating']}/10")

    summary = {
        "benchmark": "Hemfrid.se + Helpling.se",
        "target": "≥9/10",
        "total_pages": len(results),
        "passed": len(passed),
        "needs_fix": len(fix),
        "all_pass": len(fix) == 0,
        "results": results
    }
    (COMP / "final_360_summary.json").write_text(
        json.dumps(summary, ensure_ascii=False, indent=2)
    )

    if not fix:
        print(f"\n🎉 GODKÄNT — alla {len(results)} sidor ≥9/10 mot branschbenchmark!")
    else:
        print(f"\n⚠️  {len(fix)} sidor under 9/10 — se comparison/eval_*_360.md")

    return not fix

if __name__ == "__main__":
    asyncio.run(main())
