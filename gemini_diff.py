#!/usr/bin/env python3
"""
gemini_diff.py — Visuell diff med retry-logik
Försöker 3.1 Pro → fallback till 2.5 Flash
"""
import os, sys, time, subprocess
from pathlib import Path

MODELS = [
    "gemini-3.1-pro-preview",  # Bäst — försöker först
    "gemini-2.5-flash",         # Fallback vid hög last
]

def run_diff(slug="index", force_model=None):
    orig   = Path(f"comparison/{slug}_original.png")
    staging = Path(f"comparison/{slug}_staging.png")

    if not orig.exists() or not staging.exists():
        print(f"❌ Bilder saknas: {orig}, {staging}")
        sys.exit(1)

    prompt = f"""Du är expert på webdesign, CSS och konverteringsoptimering (CRO).
Jag migrerar seniorbolaget.se från Framer till WordPress. Målet är max leads/bokningar.

Filen @{orig} är ORIGINAL (Framer).
Filen @{staging} är WP STAGING.

Gör en EXAKT visuell diff:

## 1. KRITISKA KONVERTERINGSSKILLNADER
(direkt påverkan på leads/bokningar)

## 2. EXAKTA VISUELLA SKILLNADER
Format: Element: Original=[värde] → WP=[värde]
Inkludera: hex-färger, px-storlekar, font-weight, border-radius, padding

## 3. SAKNADE ELEMENT
Vad finns i original men saknas i WP?

## 4. KONKRETA FIXES
```css
/* Kopierbara CSS-fixes */
```
```json
// theme.json-ändringar
```

## 5. BETYG X/10
Och 3 konkreta saker att fixa för att gå upp ett steg.

Var tekniskt precis med hex-koder och pixelvärden."""

    models = [force_model] if force_model else MODELS

    for model in models:
        print(f"🔍 Kör diff med {model}...")
        cmd = ["gemini", "-m", model, "-p", prompt]
        
        result = subprocess.run(cmd, capture_output=True, text=True, timeout=180)
        
        if result.returncode == 0 and result.stdout.strip():
            out = Path(f"comparison/diff_report_{slug}.md")
            out.write_text(f"# Gemini Diff — {slug}\nModell: {model}\n\n{result.stdout}")
            print(f"✅ Rapport sparad: {out} (modell: {model})")
            print(result.stdout)
            return result.stdout
        else:
            err = result.stderr or result.stdout
            if "high demand" in err.lower() or "unavailable" in err.lower() or "503" in err:
                print(f"⚠️  {model} är överbelastad — försöker nästa modell...")
                time.sleep(5)
            else:
                print(f"❌ Fel med {model}: {err[:200]}")
                time.sleep(5)

    print("❌ Alla modeller misslyckades")
    sys.exit(1)

if __name__ == "__main__":
    slug = sys.argv[1] if len(sys.argv) > 1 else "index"
    force = sys.argv[2] if len(sys.argv) > 2 else None
    run_diff(slug, force)
