# CLAUDE.md — seniorbolaget-wp

Framer → WordPress-migrering för seniorbolaget.se.
Orkestratorn (Roberta/Sonnet) delegerar allt kodningsarbete till Opus-agenter.
Gemini verifierar visuellt. Wasim godkänner via PR.

---

## Nuläge (2026-02-26)

| Sida | Status | Betyg |
|------|--------|-------|
| Startsida | ✅ Mergad (PR #1) | — |
| Hemstädning | ✅ Mergad (PR #2) | 8.5/10 |
| Trädgård, Målning, Snickeri | 🔍 PR #3 (In Review) | 7-8/10 |
| 26 stadssidor v3 | 🚧 Byggs nu (WAS-42) | — |
| Info-sidor (om oss, kontakt, etc.) | ⏳ Nästa | — |

---

## Infrastruktur

```
Repo:     nexavoab/seniorbolaget-wp
Lokal:    /home/exedev/seniorbolaget-wp/
Branch:   feat/tjanstesidor-batch (PR #3 öppen)
WP-ENV:   http://localhost:8888 (Docker)
```

### Docker-kommandon
```bash
# Deploy tema (patterns-mappen separat — hela temat ger EOF-fel)
docker cp wp/seniorbolaget-theme/patterns/. \
  cd86134e880f720743ac9376d8403e15-wordpress-1:/var/www/html/wp-content/themes/seniorbolaget-theme/patterns/

docker cp wp/seniorbolaget-theme/functions.php \
  cd86134e880f720743ac9376d8403e15-wordpress-1:/var/www/html/wp-content/themes/seniorbolaget-theme/functions.php

docker exec cd86134e880f720743ac9376d8403e15-cli-1 wp cache flush --allow-root
```

### WP Media IDs
| ID | Fil | Används |
|----|-----|---------|
| 53 | hero.jpg | Stadssidor hero (kvinna + dammsugare) |
| 54 | cta-image.png | CTA-band |
| 56–62 | Tjänstebilder | Service-sidor |

---

## Pipeline

```
1. compare.py          → Playwright screenshots original + WP staging
2. Gemini-scoring      → gemini -m gemini-2.5-flash --yolo -p "..." @bild.jpg
3. ≥9/10               → PR → Wasim godkänner → merge
4. <9/10               → Opus fixar → loop
```

### Gemini-kommando (ALLTID denna struktur)
```bash
cd /home/exedev/seniorbolaget-wp

# Komprimera bild ALLTID innan (undviker SIGTERM)
.venv/bin/python3 -c "
from PIL import Image
img = Image.open('comparison/{slug}.png')
img.resize((1200, int(img.height*1200/img.width))).save('comparison/{slug}_small.jpg','JPEG',quality=75)
"

# Kör Gemini
gemini -m gemini-2.5-flash --yolo -p "
ANALYSERA ENBART BILDEN. Inga verktyg.
@comparison/{slug}_small.jpg
[Utvärderingsprompt]
TOTALBETYG: X/10
" 2>&1 | tee comparison/eval_{slug}.md
```

---

## Arkitektur — Block Theme

```
wp/seniorbolaget-theme/
  functions.php          # Pattern-registrering (seniorbolaget_register_stad_patterns)
  theme.json             # Design tokens
  templates/
    front-page.html      # Startsida
    page-tjanst.html     # Tjänstesidor (hemstäd, trädgård, etc.)
    page-stad.html       # Stadssidor → wp:post-content
    page.html            # Generisk sida
  patterns/
    hero.php             # Startsida-hero
    hemstad-page.php     # Hemstädning-tjänstesida
    stad-*.php           # 26 stadssidor (genererade av generate_stad_pages.py)
  inc/
    feature-flags.php    # SENIORBOLAGET_FEATURE_POSTNUMMER = false
```

### Stadssidor — generate_stad_pages.py
```bash
# Regenerera alla 26
.venv/bin/python3 generate_stad_pages.py

# Deploy patterns
docker cp wp/seniorbolaget-theme/patterns/. \
  cd86134e880f720743ac9376d8403e15-wordpress-1:/var/www/html/wp-content/themes/seniorbolaget-theme/patterns/
```

CITY_DATA innehåller per stad: name, bio, story[], quote, since_year, customers, areas[], testimonials[]

---

## Brand & Design

| Token | Värde |
|-------|-------|
| Primär röd | `#C91C22` |
| Ljusrosa | `#FFF4F2` |
| Varm off-white | `#FAFAF8` |
| Textgrå | `#1F2937` |
| Sekundär grå | `#6B7280` |
| Pill-knappar | `border-radius: 50px` |
| Rubrikfont | Rubik |
| Brödtext | Inter |

**Aldrig:** emojis i UI, markdown-tabeller i WhatsApp/Discord, framerusercontent-bilder i produktion.

---

## Kritiska Regler

### Git
```bash
# ALDRIG detta (orsakade mass-deletion):
git add -A

# ALLTID specifika filer:
git add wp/seniorbolaget-theme/patterns/stad-*.php generate_stad_pages.py
git commit -m "feat: beskrivning (WAS-XX)"
```

### Scraping
- **ALDRIG** urllib/requests — Framer renderar via JS
- Alltid Playwright med `wait_for_load_state('networkidle')`

### WordPress Pattern-registrering
- Auto-scan funkar INTE för `stad-*` patterns — registreras manuellt via `seniorbolaget_register_stad_patterns()` i functions.php
- `get_page_by_path()` hittar INTE barn-sidor med enkelt slug — använd `get_posts(post_name__in=[...])`
- docker cp hela tema-mappen → EOF-fel — kopiera undermappar separat

### Gemini
- Komprimera bilder ALLTID (PIL → JPEG max 1200px quality=75) — annars SIGTERM
- `--yolo` flagga krävs — annars fastnar Gemini i agentic mode
- OAuth credentials: `~/.gemini/oauth_creds.json`

---

## Linear — Aktiva Issues

| Issue | Titel | Status |
|-------|-------|--------|
| WAS-17 | Stavfel 'Helsingsborg' | Todo |
| WAS-18 | B2B template-text | Todo |
| WAS-19 | 18 bilder saknar alt-text | Todo |
| WAS-20 | Bilder på framerusercontent | Todo |
| WAS-21 | Copyright-år 2025 | Todo |
| WAS-30 | Migrera service+stadssidor | In Review (PR #3) |
| WAS-37 | Postnummerfält (feature flag) | In Progress |
| WAS-41 | Gemini 360° — alla 26 städer | Backlog |
| WAS-42 | Stadssidor v3 — franchisetagarfokus | In Progress |

**Team ID:** `5c3a01a5-e813-42fc-9ca8-4fba7b07788d`
**API-nyckel:** `$LINEAR_API_KEY` (miljövariabel — se ~/.bashrc)
