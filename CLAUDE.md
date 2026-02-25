# CLAUDE.md — seniorbolaget-wp

Automatiserad Framer → WordPress-migrering för seniorbolaget.se.
Pipeline: Playwright scrape → visuell diff (Gemini) → WordPress block theme → staging → Wasim godkänner.

## Quick Start

```bash
# Lokal WordPress (Docker via wp-env)
npm run env:start     # Starta lokal WP på port 8888
npm run env:stop      # Stoppa
wp-cli ...            # WP CLI mot lokal instans

# Scraping
python3 scrape.py     # Playwright-scraper (renderar JS, tar screenshots)

# Bygg tema-zip
cd wp && zip -r ../seniorbolaget-theme.zip seniorbolaget-theme/
```

**Git branch-policy:** Base på `main`, PR → `main`. Wasim godkänner alltid.

## Stack & Verktyg

- **Scraper:** Playwright (Python) — renderar Framer/JS, tar fullpage-screenshots, extraherar computed styles
- **Visuell diff:** Gemini 3.1 Pro Preview — jämför screenshots, rapporterar avvikelser
- **WordPress:** Block theme (FSE) + WXR-import + wp-env (lokal Docker)
- **Kodningsagent:** Claude Opus 4.5 i tmux-session
- **Analysagent:** Gemini 3.1 Pro i tmux-session

## Projektstruktur

```
seniorbolaget-wp/
  scrape.py              # Playwright-scraper (ALDRIG urllib — måste rendera JS)
  generate_wxr.py        # Genererar WordPress XML (WXR) från scrapad data
  seniorbolaget.wordpress.xml  # WXR-importfil
  scraped/               # Scrapad data per sida (JSON + screenshots)
    ├── home.json
    ├── home.png          # Fullpage screenshot för visuell diff
    └── ...
  wp/
    seniorbolaget-theme/ # WordPress block theme
      style.css          # Tema-metadata + bas-CSS
      theme.json         # Design tokens (FÄRGER, typsnitt, spacing)
      functions.php      # PHP-funktioner
      templates/         # Block templates (index, front-page, page, etc.)
      parts/             # Template parts (header, footer)
      patterns/          # Block patterns (hero, tjänster, steg, etc.)
  seniorbolaget-theme.zip  # Zippad version för WP-import
```

## Pipeline — Automatiserat flöde

```
1. scrape.py (Playwright)
   → scraped/{sida}.json   (text, färger, fonter, bilder)
   → scraped/{sida}.png    (fullpage screenshot)

2. Gemini 3.1 Pro (tmux: gemini/diff)
   → jämför scraped/*.png med WP staging screenshots
   → diff-rapport: exakta avvikelser med CSS-förslag

3. Claude Opus (tmux: wp/fix)
   → läser diff-rapport → uppdaterar theme.json + CSS + patterns

4. wp-env (lokal Docker)
   → testar tema lokalt, tar nya screenshots

5. Loop: Gemini verifierar → Opus fixar → tills godkänt

6. PR → Wasim granskar → merge → deploy
```

## Kritiska regler

### Scraping
- **ALDRIG urllib eller requests för att scrapa** — Framer renderar via JS, vi får bara skalet
- Alltid Playwright med `await page.wait_for_load_state('networkidle')`
- Ta alltid fullpage screenshot + extrahera `window.getComputedStyle` för färger

### Färger
- Extrahera alltid via `window.getComputedStyle` i Playwright — inte från raw HTML/CSS
- Verifiera mot Gemini visuell analys innan theme.json uppdateras

### WordPress tema
- Alla designvärden i `theme.json` — aldrig hardkodade i CSS
- Block patterns för alla återkommande sektioner
- Testa alltid lokalt med wp-env innan PR

## Tmux-sessioner för detta projekt

```bash
# Scraper (Playwright)
tmux new-session -d -s "scrape/seniorbolaget" -c "/path/to/repo" \
  "claude --model claude-opus-4-5 --dangerously-skip-permissions"

# Visuell diff (Gemini)
tmux new-session -d -s "gemini/diff" -c "/path/to/repo" \
  "GEMINI_API_KEY=$GEMINI_API_KEY gemini --model gemini-3.1-pro-preview --yolo"

# WP-fixes (Opus)
tmux new-session -d -s "wp/fix" -c "/path/to/repo" \
  "claude --model claude-opus-4-5 --dangerously-skip-permissions"
```

## Uppdelningsregler

- En plan med fler än 3 filer MÅSTE köras med "manually approve edits"
- Innan du tar bort ett block >50 rader: lista vad som BEHÅLLS vs TAS BORT, fråga
- Vid refaktorering: EN fil i taget. Commita. Gå vidare.
- Om en plan har fler än 5 steg: dela upp i max 3 steg per körning
- Blanda aldrig "ta bort" och "flytta" i samma edit
