# Staging Security, Cookie and Landmark Proof V32

Date: 2026-06-18

Scope:

- `LH-P2-003` cookie first impression
- `LH-P2-005` HSTS production policy
- `LH-P2-006` CSP worker warning
- `LH-P2-012` landmark/main structure
- runtime console regression from deferred WordPress i18n dependencies

## Deploy

Live staging file:

`seniorbolaget.se/staging/wp-content/themes/seniorbolaget-theme/functions.php`

File Manager package:

- `filemanager-functions-deploy-20260618-0925/functions-after-v32.php`
- readback: `filemanager-functions-deploy-20260618-0925/functions-editor-after-v32-readback.php`

Readback hash:

`bfbaaefbe9188de25b91da12afdd8ecece2fa5c6c21ddf79dc2650bae183bbd3`

Cache purge:

- Varnish purge URL returned `200`
- CDN purge URL returned `200`

## HTTP and DOM sample

Sample URLs after deploy:

- `/`
- `/intresseanmalan/`
- `/priser/`
- `/har-finns-vi/amal/`

All sampled URLs returned `200`.

Observed on all sampled URLs:

- `main=1`
- `header=1`
- `footer=1`
- outer `header.wp-block-template-part` and `footer.wp-block-template-part` demoted
- CSP contains `worker-src 'self' blob:`
- Complianz first-impression CSS block present
- `wp-hooks-js` and `wp-i18n-js` no longer render with `defer`
- HSTS remains absent on staging by policy

## Runtime console

Fresh browser runtime proof:

`console-runtime-v32.json`

Result:

- fresh warning/error log count: `0`
- CSP/worker/blob/mixed-content/failed-load count: `0`
- `wp is not defined` count: `0`

Script order proof:

- `wp-hooks-js`: `defer=false`
- `wp-i18n-js`: `defer=false`
- `wp-i18n-js-after`: inline after dependencies
- `elementor-common-js-translations`: inline after `wp-i18n`

## Cookie first impression

Proof files:

- `rendered-cookie-csp-landmark-v31.json`
- `screenshot-cookie-v31-mobile-390x844.png`
- `screenshot-cookie-v31-desktop-1280x900.png`

The verifier browser already had a consent state, so the banner was hidden during screenshots. The rendered style check confirms the active first-visit placement rules:

- mobile `390x844`: fixed bottom panel, `left=12px`, `right=12px`, `bottom=12px`, `transform=none`
- desktop `1280x900`: fixed bottom-right, `right=32px`, `bottom=32px`, `transform=none`

## Lighthouse lab data

Final v32 mobile Lighthouse JSON:

- `lighthouse-home-mobile-v32.json`
- `lighthouse-interest-mobile-v32.json`
- `lighthouse-prices-mobile-v32.json`

Results:

| Page | Score | FCP | LCP | TBT | CLS | Speed Index |
| --- | ---: | ---: | ---: | ---: | ---: | ---: |
| Home | 0.86 | 2133 ms | 3333 ms | 216 ms | 0.016 | 2577 ms |
| Intresseanmalan | 0.78 | 2782 ms | 3596 ms | 323 ms | 0.004 | 3371 ms |
| Priser | 0.94 | 2165 ms | 2470 ms | 130 ms | 0.000 | 2165 ms |

This is lab data and can vary run to run. Compared with the initial v1 baseline, CLS is materially improved on home and intresseanmalan.

## Gates after V32

Passed:

- `node scripts\verify-a11y-css.mjs`
- `node scripts\verify-conversion-a11y.mjs`
- `node scripts\verify-content-style.mjs`
- `node scripts\verify-launch-trust.mjs`
- `node scripts\verify-internal-links.mjs`
- `node --check wp\seniorbolaget-theme\js\sb-design-cleanup.js`
- `node scripts\quality-gate-staging-crawl.mjs` -> 75/75 direct 200
- `git diff --check` -> no errors, CRLF warnings only

## Rollback

Rollback options:

1. Restore `functions-after-v31.php` to roll back only the v32 i18n script-order block.
2. Restore `functions-after-v30.php` to roll back the v31/v32 security, cookie and landmark package.
3. Clear One.com/WordPress cache.
4. Re-run HTTP header, landmark, console and 75-URL crawl checks.

Production was not changed.
