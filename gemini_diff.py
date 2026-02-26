#!/usr/bin/env python3
"""
gemini_diff.py — Visuell diff + kodpatcher med retry-logik
Försöker 3.1 Pro → fallback till 2.5 Flash
"""
import os, sys, time, subprocess
from pathlib import Path

MODELS = [
    "gemini-3.1-pro-preview",  # Bäst — försöker först
    "gemini-2.5-flash",         # Fallback vid hög last
]

THEME_ROOT = Path("wp/seniorbolaget-theme")

def load_source_files():
    """Läser in källkodsfiler som ska skickas till Gemini."""
    files = {
        "style.css":              THEME_ROOT / "style.css",
        "theme.json":             THEME_ROOT / "theme.json",
        "hero.php":               THEME_ROOT / "patterns/hero.php",
        "testimonials.php":       THEME_ROOT / "patterns/testimonials.php",
        "three-steps.php":        THEME_ROOT / "patterns/three-steps.php",
        "services-grid.php":      THEME_ROOT / "patterns/services-grid.php",
        "stats-band.php":         THEME_ROOT / "patterns/stats-band.php",
        "cta-band.php":           THEME_ROOT / "patterns/cta-band.php",
    }
    out = {}
    for name, path in files.items():
        if path.exists():
            out[name] = path.read_text(encoding="utf-8")
        else:
            out[name] = f"(fil saknas: {path})"
    return out

def load_page_source(slug):
    """Läser källkodsfil för en specifik sida."""
    pattern_map = {
        "hemstad":  "hemstad-page.php",
        "tradgard": "tradgard-page.php",
        "malning":  "malning-page.php",
        "snickeri": "snickeri-page.php",
        "om-oss":   "om-oss-page.php",
        "kontakt":  "kontakt-page.php",
    }
    fname = pattern_map.get(slug)
    if fname:
        path = THEME_ROOT / f"patterns/{fname}"
        if path.exists():
            return f"=== {fname} ===\n{path.read_text(encoding='utf-8')}"
    return "(sidans källkod saknas ännu)"

def run_diff_page(slug, force_model=None):
    """
    Tre-lagers diff för undersidor:
    1. Framer-originalet → innehållsreferens
    2. Vår låsta startsida → designreferens
    3. Ny WP-sida → det som ska förbättras
    """
    orig      = Path(f"comparison/{slug}_original.png")
    staging   = Path(f"comparison/{slug}_staging.png")
    home_ref  = Path("comparison/index_staging.png")  # låst designreferens

    missing = [str(p) for p in [orig, staging, home_ref] if not p.exists()]
    if missing:
        print(f"❌ Bilder saknas: {', '.join(missing)}")
        sys.exit(1)

    page_source  = load_page_source(slug)
    sources      = load_source_files()
    css_source   = sources.get("style.css", "")
    theme_source = sources.get("theme.json", "")

    prompt = f"""Du är en senior WordPress-utvecklare och UX-designer.

Jag bygger tjänstesidor för seniorbolaget.se (hemtjänster — städning, trädgård, hantverk).
Varje sida ska: (1) matcha Framer-originalets innehåll, (2) följa vår låsta designstandard från startsidan.

---
## TRE BILDER — tre olika roller

**Bild 1 @{orig}** = FRAMER-ORIGINALET
→ Innehållsreferens: vad sidan ska kommunicera, vilka sektioner som ska finnas

**Bild 2 @{home_ref}** = VÅR LÅSTA STARTSIDA (designstandard)
→ Designreferens: färger, typografi, kortformat, spacing, knappar, ikoner
→ ALLA nya sidor ska se ut som att de hör ihop med denna sida

**Bild 3 @{staging}** = NY WP-SIDA (ska förbättras)
→ Det vi just byggt — jämförs mot bägge ovanstående

---
## KÄLLKOD

=== Sidans mönster ===
{page_source}

=== style.css (utdrag) ===
{css_source[:3000]}

=== theme.json (utdrag) ===
{theme_source[:1000]}

---
## UPPDRAG — metodiskt uppifrån och ned

### 1. INNEHÅLLSGAP (vs Framer-originalet)
Vad finns i Framer-sidan som saknas i vår WP-version?

### 2. DESIGNINKONSISTENS (vs startsidan)
Var bryter den nya sidan mot vår etablerade designstandard?
- Färger, typsnitt, spacing, kortformat, knappar — exakt vad avviker?

### 3. KOD-PATCHER
För varje problem — exakt patch:

### [Sektion] Problem: [beskrivning]
**Fil:** `[filnamn]`
**Hitta:**
```
[exakt kod att hitta]
```
**Ersätt med:**
```
[ny kod]
```
**Motivering:** [kort förklaring]

### 4. TRYGGHETSGRANSKNING
Gå igenom sidan ur en 65-årig skeptisk internetanvändares ögon.
Vad skapar osäkerhet? Vad stärker förtroendet?

---
## DESIGNSTANDARD (från startsidan)
- Röd: #C91C22 | Ljusrosa bg: #FFF4F2 | Off-white: #FAFAF8
- Knappar: border-radius 50px, padding 14px 32px
- Rubriker: Rubik bold | Brödtext: Inter
- Kort: border-radius 16px, subtle shadow
- Inga emojis — SVG-ikoner i varumärkesfärg
- Sektionsluft: 100px desktop, 64px mobil

---
## BETYG: X/10

**Topp 3 att fixa:**
1. [kritisk]
2. [viktig]
3. [förbättring]

Var kirurgisk. Ge kopierbar kod."""

    models = [force_model] if force_model else MODELS
    for model in models:
        print(f"🔍 Kör diff (3-lagers) med {model}...")
        cmd = ["gemini", "-m", model, "-p", prompt]
        result = subprocess.run(cmd, capture_output=True, text=True, timeout=300)
        if result.returncode == 0 and result.stdout.strip():
            out = Path(f"comparison/diff_report_{slug}.md")
            out.write_text(f"# Gemini Diff — {slug}\nModell: {model}\n\n{result.stdout}")
            print(f"✅ Rapport sparad: {out}")
            print(result.stdout)
            return result.stdout
        else:
            err = result.stderr or result.stdout
            if any(x in err.lower() for x in ["high demand", "unavailable", "503", "overloaded"]):
                print(f"⚠️  {model} överbelastad — försöker nästa...")
                time.sleep(5)
            else:
                print(f"❌ Fel: {err[:300]}")
                time.sleep(5)
    print("❌ Alla modeller misslyckades")
    sys.exit(1)

def run_diff(slug="index", force_model=None):
    orig    = Path(f"comparison/{slug}_original.png")
    staging = Path(f"comparison/{slug}_staging.png")

    if not orig.exists() or not staging.exists():
        print(f"❌ Bilder saknas: {orig}, {staging}")
        sys.exit(1)

    sources = load_source_files()
    sources_block = "\n\n".join(
        f"=== {name} ===\n{content}" for name, content in sources.items()
    )

    prompt = f"""Du är en senior webbutvecklare och UX-designer specialiserad på konverteringsoptimering och modern webbdesign.

Jag migrerar seniorbolaget.se (hemtjänster med erfarna seniorer — städning, trädgård, hantverk) från Framer till WordPress.
Målet är: 90%+ visuell likhet med originalet, moderniserat, och maximal trygghet för användaren.

---
## BILDER
- @{orig} = ORIGINALET (Framer-versionen, sanningen)
- @{staging} = WP STAGING (nuläget, ska förbättras)

---
## KÄLLKOD (aktuell WP-implementation)
{sources_block}

---
## UPPDRAG — jobba metodiskt UPPIFRÅN OCH NED

Gå igenom sidan sektion för sektion i ordningen de visas:
1. Header / Navigation
2. Hero (hero.php)
3. Testimonials (testimonials.php)
4. Tre steg (three-steps.php)
5. Tjänstegrid (services-grid.php)
6. Statistikband (stats-band.php)
7. CTA-band (cta-band.php)
8. Footer

För VARJE sektion — notera:
- Exakta skillnader (px, hex-värden, font-weight, border-radius, spacing, layout)
- Vad som skapar eller förstör TRYGGHET för användaren (ett äldre målgrupp som är skeptisk till internet)
- Möjligheter till modernisering som höjer kvalitetskänslan

---
## FORMAT FÖR DINA FIXES

För varje problem du hittar, ge en KONKRET PATCH i detta format:

### [Sektion] Problem: [kort beskrivning]
**Fil:** `[filnamn]`
**Hitta:**
```
[exakt sträng att söka efter i filen]
```
**Ersätt med:**
```
[ny kod]
```
**Motivering:** [varför detta ökar trygghet/konvertering/visuell likhet]

---
## DESIGNPRINCIPER ATT FÖLJA

**Trygghet (VIKTIGAST):**
- Tydliga kontaktuppgifter högt upp (telefonnummer synligt)
- Certifieringar, omdömen, RUT-info nära CTA
- Inga konstiga animationer eller flashiga effekter
- Läsbar text, hög kontrast
- Mänskliga foton (inte stock-foton)
- Tydlig process (steg för steg)

**Modernisering:**
- Subtle shadows (inte platta, inte dramatiska)
- Mjuka border-radius (16–24px på kort, 50px på knappar)
- Generös whitespace
- Konsekvent typografisk hierarki
- Hover-effekter som bekräftar interaktivitet

**Varumärke:**
- Primär röd: #C91C22
- Ljus rosa bakgrund: #FFF4F2
- Mörkgrå text: #1F2937 (rubriker), #4B5563 (brödtext), #6B7280 (sekundär)
- Knappar: pill-form (border-radius: 50px), padding 14px 32px
- Typsnitt: Rubik (rubriker), Inter (brödtext)

---
## SLUTBETYG

Avsluta med:

## BETYG: X/10

**Topp 3 prioriteringar för nästa runda:**
1. [mest kritiska — specificera exakt vad och hur]
2. [näst viktigaste]
3. [tredje]

**Vad är bra och ska behållas:**
- [lista]

Var kirurgiskt precis. Skriv faktisk kod som kan kopieras rakt in. Inga vaga råd."""

    models = [force_model] if force_model else MODELS

    for model in models:
        print(f"🔍 Kör diff med {model}...")
        cmd = ["gemini", "-m", model, "-p", prompt]

        result = subprocess.run(cmd, capture_output=True, text=True, timeout=300)

        if result.returncode == 0 and result.stdout.strip():
            out = Path(f"comparison/diff_report_{slug}.md")
            out.write_text(f"# Gemini Diff — {slug}\nModell: {model}\n\n{result.stdout}")
            print(f"✅ Rapport sparad: {out} (modell: {model})")
            print(result.stdout)
            return result.stdout
        else:
            err = result.stderr or result.stdout
            if any(x in err.lower() for x in ["high demand", "unavailable", "503", "overloaded"]):
                print(f"⚠️  {model} är överbelastad — försöker nästa modell...")
                time.sleep(5)
            else:
                print(f"❌ Fel med {model}: {err[:300]}")
                time.sleep(5)

    print("❌ Alla modeller misslyckades")
    sys.exit(1)

if __name__ == "__main__":
    slug  = sys.argv[1] if len(sys.argv) > 1 else "index"
    force = sys.argv[2] if len(sys.argv) > 2 else None

    if slug == "index":
        run_diff(slug, force)          # Startsida: original vs staging
    else:
        run_diff_page(slug, force)     # Undersida: original + startsida + ny sida
