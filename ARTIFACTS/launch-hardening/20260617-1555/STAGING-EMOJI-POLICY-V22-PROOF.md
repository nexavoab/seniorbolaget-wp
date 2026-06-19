# Staging Emoji Policy V22 Proof

Datum: 2026-06-18
Scope: staging only, home, `/foretag/`, `/intresseanmalan/`, `/kontakt/` och 26 ortssidor.

## Beslut

Anvandaren beslutade 2026-06-18 att emojis/ikoner ska vara konsekventa och att B2B/foretag inte ska ha felaktiga dekorativa emoji-prefix. Trustmarkeringar som checkmarks och stjarnrader lamnas ororda.

## Rotorsak

v20 tog bort emoji-prefix i utvalda komponenter men missade kontakt- och ortstexter. v21 korde bredare traversering men riktade sig mot `main`, medan live staging har vissa ortsblock direkt under `.wp-site-blocks`.

## Andring

- Source: `wp/seniorbolaget-theme/js/sb-design-cleanup.js` kor `normalizeDecorativeEmojiText()` pa `.wp-site-blocks`, `main`, CTA-paneler, footer och body.
- Staging deploy: One.com File Manager uppdaterad med `functions-after-v22.php`.
- Nytt block: `SENIORBOLAGET STAGING DECORATIVE EMOJI POLICY V22 HOTFIX START 2026-06-18`.
- Rollback: aterstall `functions-after-v21.php`, eller ta bort v22-blocket och rensa cache.

## Verifiering

`rendered-visible-emoji-scan-before-v20.json`:

- Fore-scan hittade fargade emoji-prefix pa home/foretag/intresse/Åmål.

`rendered-visible-emoji-scan-v20.json`:

- 30 sidor scannade.
- 3 passerade, 27 failade.
- Failures var framfor allt kontaktens `📞` och orternas `📍`, `🧹`, `🌿`, `🔨`.

`rendered-visible-emoji-scan-v21.json`:

- 30 sidor scannade.
- 3 passerade, 27 failade.
- Root cause: staging-content lag inte i `main`.

`rendered-visible-emoji-scan-v22.json`:

- 30/30 sidor passerade.
- `failed=0`.
- v22 hotfix markerad som applied pa alla scannade sidor.
- Inga synliga dekorativa emoji-prefix: `📍`, `📞`, `🏢`, `👴`, `🧹`, `🌿`, `🔨`, `🎨`, `🖌`, `⭐`.

## Commands

```powershell
node --check wp\seniorbolaget-theme\js\sb-design-cleanup.js
node scripts\verify-a11y-css.mjs
node scripts\verify-conversion-a11y.mjs
node scripts\quality-gate-staging-crawl.mjs
```

Resultat:

- JS syntax: pass.
- A11y CSS lint: pass.
- Conversion accessibility lint: pass.
- Staging crawl: 75 URLs direct 200.
- `php -l` kunde inte koras lokalt eftersom PHP CLI saknas i miljön.
