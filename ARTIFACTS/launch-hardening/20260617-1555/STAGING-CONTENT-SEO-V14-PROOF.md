# Staging Content + SEO v14 Proof

Datum: 2026-06-18
Miljo: `https://staging.seniorbolaget.se`
Scope: prisguide-tabell, synlig typografi, kontakt-rubrik, staging noindex och care-context-rest.

## Andring

- Source: `wp/seniorbolaget-theme/js/sb-design-cleanup.js`
- Staging hotfix: `SENIORBOLAGET STAGING CONTENT SEO CLEANUP HOTFIX START 2026-06-18`
- Deployfil: `filemanager-functions-deploy-20260618-0925/functions-after-v14.php`
- Rollback: aterstall `functions-after-v12.php` eller ta bort markerat content SEO cleanup-block; rensa One.com Performance Cache/CDN.

## Live-verifiering

Bevis:

- `filemanager-functions-deploy-20260618-0925/rendered-content-seo-v14.json`
- `filemanager-functions-deploy-20260618-0925/screenshots-content-v14/price-guide-table-desktop-1280x900.png`
- `filemanager-functions-deploy-20260618-0925/screenshots-content-v14/kontakt-heading-desktop-1280x900.png`
- `filemanager-functions-deploy-20260618-0925/screenshots-content-v14/amal-typography-mobile-390x844.png`

Sample-sidor:

- Prisguide `vad-kostar-hemstadning-2026-priser-per-stad`
- `/priser/`
- `/kontakt/`
- `/`
- `/har-finns-vi/amal/`
- `/har-finns-vi/orebro/`

Resultat:

- `rawMarkdownPipeFailures`: `[]`
- `emDashFailures`: `[]`
- `spaceBeforeCommaFailures`: `[]`
- `contactDuplicateFailures`: `[]`
- `forbiddenCareFailures`: `[]`
- `noindexMissing`: `[]`
- Prisguide har `tableCount=1` och `priceTableCount=1`.
- Kontakt visar en huvudrubrik `Hur kan vi hjälpa dig?` och sekundarrubrik `Välj vad du behöver hjälp med`.

## Quality gates

Korda efter deploy:

- `node --check wp\seniorbolaget-theme\js\sb-design-cleanup.js`: pass
- `node scripts\verify-content-seo.mjs`: pass
- `node scripts\verify-content-style.mjs`: pass
- `node scripts\verify-internal-links.mjs`: pass
- `node scripts\verify-launch-trust.mjs`: pass
- `node scripts\quality-gate-staging-crawl.mjs`: pass, 75/75 direct 200

## Status

- `LH-P1-005`: Verified
- `LH-P2-004`: Verified for staging policy
- `LH-P2-007`: Verified
- `LH-P2-008`: Verified
- `LH-P2-010`: Verified
