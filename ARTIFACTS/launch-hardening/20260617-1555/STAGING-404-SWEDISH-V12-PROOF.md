# Staging 404 Swedish Copy v12 Proof

Datum: 2026-06-18
Miljo: `https://staging.seniorbolaget.se`
Scope: 404-sida, svensk text med å/ä/ö.

## Andring

- Source: `wp/seniorbolaget-theme/js/sb-design-cleanup.js`
- Staging hotfix: `SENIORBOLAGET STAGING 404 SWEDISH COPY HOTFIX START 2026-06-18`
- Deployfil: `filemanager-functions-deploy-20260618-0925/functions-after-v12.php`
- Rollback: aterstall `functions-after-v11.php` eller ta bort markerat 404-hotfix-block; rensa One.com Performance Cache/CDN.

## Live-verifiering

URL:

`https://staging.seniorbolaget.se/den-har-sidan-finns-inte-aaaoe-20260618-v12/?sb-content-v12=1781776973329`

Bevis:

- `filemanager-functions-deploy-20260618-0925/rendered-404-swedish-v12.json`
- `filemanager-functions-deploy-20260618-0925/screenshots-404-v12/404-mobile-390x844.png`
- `filemanager-functions-deploy-20260618-0925/screenshots-404-v12/404-desktop-1280x900.png`

Resultat:

- `badHits`: `[]`
- `swedish404Hotfix`: `applied`
- Svenska termer verifierade i renderad DOM: `söka istället`, `Sök`, `besök någon`, `våra populära`, `Hemstädning`, `Företag`, `Vardagshjälp`

Observerat runtime-brus:

- Två befintliga admin/Elementor-översättningsfel i inloggat läge: `ReferenceError: wp is not defined` från `wp-i18n-js-after` och `elementor-common-js-translations`.
- Ingen träff kopplad till v12-hotfixen.

## Quality gates

Korda efter deploy:

- `node --check wp\seniorbolaget-theme\js\sb-design-cleanup.js`: pass
- `node scripts\verify-content-seo.mjs`: pass
- `node scripts\verify-content-style.mjs`: pass
- `node scripts\verify-launch-trust.mjs`: pass
- `node scripts\verify-conversion-a11y.mjs`: pass
- `node scripts\verify-city-contacts.mjs`: pass
- `node scripts\quality-gate-staging-crawl.mjs`: pass, 75/75 direct 200
- `git diff --check`: pass med endast CRLF-varning for JS-filen

## Status

- `LH-P2-009`: Verified
