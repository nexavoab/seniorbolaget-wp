# Staging Conversion + A11y v10 Proof

Datum: 2026-06-18
Scope: staging only

## Andring

- Source: `wp/seniorbolaget-theme/js/sb-design-cleanup.js`
  - Satter saknad `href="/"` och `aria-label="Seniorbolaget startsida"` pa `a.sb-logo`.
  - Kopplar injicerade kontaktformulars `input[name="sb_gdpr"]` till label/aria.
  - Markerar honeypot `input[name="sb_website"]` som `aria-hidden` och `tabindex=-1`.
- Staging deploy: One.com File Manager uppdaterad med `functions-after-v10.php`.
- Nytt staging-only block: `SENIORBOLAGET STAGING CONVERSION A11Y HOTFIX START 2026-06-18`.
- Rollback: aterstall `functions-after-v9.php`, eller ta bort conversion a11y hotfix-blocket och rensa cache.

## Live-verifiering

`rendered-conversion-a11y-v10.json`:

- 4/4 sample-sidor passerade: `/`, `/intresseanmalan/`, `/kontakt/`, `/har-finns-vi/amal/`.
- `.sb-logo` har `href="/"`, `alt="Seniorbolaget"` och `aria-label="Seniorbolaget startsida"`.
- `/kontakt/`: 0 synliga formularlabel-issues; synlig `sb_gdpr` ar label-kopplad.
- `sbConversionA11yHotfix=applied` pa alla sample-sidor.

Regression:

- `rendered-city-neutral-images-v10-regression.json`: 26/26 ortssidor passerade, 0 gamla `Bild kommer snart`-bilder, 12 neutrala ersattningsbilder kvar.

## Commands

```powershell
node --check wp\seniorbolaget-theme\js\sb-design-cleanup.js
node scripts\verify-conversion-a11y.mjs
node scripts\verify-a11y-css.mjs
node scripts\verify-launch-trust.mjs
node scripts\quality-gate-staging-crawl.mjs
git diff --check
```

Resultat:

- JS syntax: pass.
- Conversion accessibility lint: pass.
- A11y CSS lint: pass.
- Launch trust lint: pass.
- Staging crawl: 75 URLs direct 200.
- `git diff --check`: pass, med endast befintlig Git-varning om LF -> CRLF for `sb-design-cleanup.js`.
- `php -l` kunde inte koras lokalt eftersom PHP CLI saknas i miljön.
