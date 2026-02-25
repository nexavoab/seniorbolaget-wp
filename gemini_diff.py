#!/usr/bin/env python3
"""
gemini_diff.py — Gemini visuell diff: original vs WP staging
Output: comparison/diff_report.md
"""
import os, sys
from pathlib import Path
from google import genai
from google.genai import types

API_KEY = "AIzaSyA9M25q6GccWMH1RRtjQr5avWJ49FHhbSY"
client = genai.Client(api_key=API_KEY)

def load_image(path):
    mime = "image/png" if str(path).endswith(".png") else "image/jpeg"
    with open(path, "rb") as f:
        return types.Part.from_bytes(data=f.read(), mime_type=mime)

def run_diff(slug="index"):
    orig = Path(f"comparison/{slug}_original.png")
    staging = Path(f"comparison/{slug}_staging.png")

    if not orig.exists() or not staging.exists():
        print(f"❌ Bilder saknas: {orig}, {staging}")
        sys.exit(1)

    print(f"🔍 Analyserar {slug}...")

    prompt = f"""Du är expert på webdesign, CSS och konverteringsoptimering (CRO).

Jag migrerar seniorbolaget.se (hemtjänster av erfarna seniorer) från Framer till WordPress.
Webbplatsens mål: maximera leads (bokningsförfrågningar).

BILD 1 = ORIGINAL (Framer, seniorbolaget.se/{slug})
BILD 2 = WP STAGING (localhost:8888, vårt WordPress-tema)

Gör en EXAKT visuell diff. Var tekniskt precis.

## KRITISKA KONVERTERINGSSKILLNADER
(saker som direkt påverkar leads/bokningar)

## VISUELLA EXAKTA SKILLNADER
Format: `Element: Original=[värde] → WP=[värde]`
Exempel:
- Hero-bakgrund: Original=bild(senior-skottar-snö) → WP=vit bakgrund
- H1 storlek: Original=64px → WP=48px  
- Primärknapp färg: Original=#CE2828 → WP=#b71c1c
- Sektionspadding: Original=120px → WP=64px

## SAKNADE ELEMENT (finns i original, saknas i WP)
Lista varje element som saknas.

## CSS/THEME-FIXES (kopierbara)
Exakta värden att ändra i theme.json och style.css:
```json
// theme.json ändringar
```
```css
/* style.css ändringar */
```

## BETYG
X/10 och kort motivering.

Var specifik med pixelvärden, hex-koder och CSS-egenskaper."""

    img1 = load_image(orig)
    img2 = load_image(staging)

    response = client.models.generate_content(
        model="gemini-2.5-flash",
        contents=[prompt, img1, img2]
    )

    report = response.text
    out = Path(f"comparison/diff_report_{slug}.md")
    out.write_text(report)
    print(f"✅ Rapport sparad: {out}")
    print("\n" + "="*60)
    print(report)
    return report

if __name__ == "__main__":
    slug = sys.argv[1] if len(sys.argv) > 1 else "index"
    run_diff(slug)
