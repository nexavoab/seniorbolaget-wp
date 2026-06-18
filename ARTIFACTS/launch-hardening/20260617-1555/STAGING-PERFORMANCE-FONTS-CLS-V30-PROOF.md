# Staging Performance, Fonts and CLS V30 Proof

Date: 2026-06-18
Scope: staging only, no production changes.

## Deploy

Live staging `functions.php` was updated through One.com File Manager to `functions-after-v30.php`.

Readback proof:

- Before v25: `filemanager-functions-deploy-20260618-0925/functions-editor-before-v25.php`
- v25 readback hash matched target: `247b6fdd16f8e9463a944ba06cc30f1c09a78d05d2607be5234a107d70921404`
- v26 readback hash matched target: `4c845dd5664dced6ced88e9e54444bbd5beba1bd9d03b87557fe663a84adbc9c`
- v27 readback hash matched target: `811431a24bca9e27b53481bab07d71e3dac32c2cfffc488fbbf7606fa822554d`
- v28 readback hash matched target: `1437ddb3e247dd831911cb14c586e7aacf971616989e18245a385e37e75aa2b7`
- v29 readback hash matched target: `5d1ed1cc5b50bbffc27ad7e9d6a8b722ea6f65659ae36e78ca14c23605ca96a5`
- v30 readback hash matched target: `1a6edcc4db24adffd0c6f81ad6a5bee102ec45db498b387a9807895dca8fa22e`

Cache clear:

- Varnish purge URL returned HTTP 200.
- CDN purge URL returned HTTP 200.

## What Changed

- Removed frontend Google Font payloads: `seniorbolaget-fonts`, `elementor-gf-roboto`, `elementor-gf-robotoslab`.
- Removed staging-only manual Google Fonts preconnect/preload/font-face output from rendered HTML.
- Added explicit header/footer logo dimensions.
- Reserved mobile hero height on the home page.
- Reserved mobile wizard height and kept `x-cloak` wizard space allocated with `visibility:hidden` instead of layout-collapsing `display:none`.

## Lighthouse Mobile Lab Data

Lighthouse is lab data, not field data.

| Page | Baseline score | Baseline LCP | Baseline CLS | V30 score | V30 LCP | V30 CLS |
| --- | ---: | ---: | ---: | ---: | ---: | ---: |
| Home | 0.56 | 5219 ms | 0.228 | 0.85 | 3290 ms | 0.122 |
| Intresseanmalan | 0.40 | 4930 ms | 0.917 | 0.88 | 3343 ms | 0.000 |
| Priser | 0.75 | 4163 ms | 0.000 | 0.95 | 2441 ms | 0.000 |

Raw files:

- `lighthouse-home-mobile-v1.json`
- `lighthouse-interest-mobile-v1.json`
- `lighthouse-prices-mobile-v1.json`
- `lighthouse-home-mobile-v30.json`
- `lighthouse-interest-mobile-v30.json`
- `lighthouse-prices-mobile-v30.json`

Residual risk:

- Home mobile CLS is improved but still 0.122 in this Lighthouse run. Root cause is isolated to the home hero content block. Further reduction likely needs source/content cleanup of the Elementor/WP hero markup rather than another broad staging hotfix.

## Runtime Sample

`runtime-technical-sample-v30.json`:

- 3/3 sample URLs returned 200.
- `MixedContentLinks=0`.
- `GoogleFontRefs=0`.
- `FontHandles=0`.
- staging `X-Robots-Tag: noindex, nofollow` remains.

Header sample:

- CSP exists but remains broad and does not include a dedicated `worker-src`.
- HSTS is still not enabled on staging; production HSTS remains a launch policy item.

## Regression Gates

Passed after v30:

- `node scripts\verify-a11y-css.mjs`
- `node scripts\verify-conversion-a11y.mjs`
- `node scripts\verify-content-style.mjs`
- `node scripts\verify-launch-trust.mjs`
- `node scripts\quality-gate-staging-crawl.mjs` with 75/75 direct 200
- `node --check wp\seniorbolaget-theme\js\sb-design-cleanup.js`
- `git diff --check`

## Rollback

Fast rollback:

1. Restore `filemanager-functions-deploy-20260618-0925/functions-after-v29.php` to remove only v30.
2. Restore `functions-after-v28.php` to remove v29 and v30 CLS reservation.
3. Restore `functions-after-v24.php` to remove all font/logo/CLS changes from this package.
4. Clear Varnish/CDN cache.
5. Re-run the same Lighthouse/runtime/crawl sample.
