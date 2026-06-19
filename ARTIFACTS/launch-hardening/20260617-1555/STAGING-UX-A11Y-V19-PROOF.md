# Staging UX + Accessibility v19 Proof

Datum: 2026-06-18
Miljo: `https://staging.seniorbolaget.se`
Deploy-yta: One.com File Manager, `seniorbolaget.se/staging/wp-content/themes/seniorbolaget-theme/functions.php`

## Andringar

- `SENIORBOLAGET STAGING CTA FOCUS HOTFIX START 2026-06-18`
- `SENIORBOLAGET STAGING FAB HANDLER HOTFIX START 2026-06-18`
- `SENIORBOLAGET STAGING FOOTER LINK AFFORDANCE HOTFIX START 2026-06-18`
- `SENIORBOLAGET STAGING FOOTER CONTRAST HOTFIX START 2026-06-18`
- `SENIORBOLAGET STAGING MOBILE FOOTER LAYOUT HOTFIX START 2026-06-18`

Slutlig deployfil: `filemanager-functions-deploy-20260618-0925/functions-after-v19.php`

Rollback: aterstall `functions-after-v18.php` for bara mobile-footer-layout, eller ta bort markerat block. For tidigare delar: `functions-after-v14.php` till `functions-after-v17.php` enligt `ROLLBACK.md`.

## File Manager-bevis

- v18 editor-readback fore save: exakt match, `173974` tecken, v17 + v18-markorer fanns.
- v19 editor-readback fore save: exakt match, `176378` tecken, v18 + v19-markorer fanns.
- One.com visade `Sparad` efter v19, andrad `12:49`, och korrekt staging-sokvag.
- Cache rensad via WP admin for Performance Cache och CDN.

PHP CLI finns inte lokalt (`php` saknas i PATH), sa PHP-syntax kunde inte lintas med `php -l`. Detta kompenserades med exakt editor-copy-readback fore save och live-verifiering efter cache clear.

## Live-verifiering

Bevisfiler:

- `filemanager-functions-deploy-20260618-0925/rendered-cta-focus-v16.json`
- `filemanager-functions-deploy-20260618-0925/rendered-ux-a11y-v16.json`
- `filemanager-functions-deploy-20260618-0925/rendered-cookie-consent-v15.json`
- `filemanager-functions-deploy-20260618-0925/rendered-a11y-css-v19.json`
- `filemanager-functions-deploy-20260618-0925/rendered-footer-mobile-layout-v19.json`
- `filemanager-functions-deploy-20260618-0925/rendered-city-neutral-images-v19.json`

Resultat:

- CTA/FAB stangd state: `aria-hidden=true`, fokusbara lankar/knappar har `tabindex=-1`.
- FAB oppen state: menu `aria-hidden=false`, knapp `aria-expanded=true`, lankar fokusbara.
- UX/a11y regression sample: 12/12 utan hidden-focusable failures.
- Footer kontrast/lank gate: 4/4 sample, `linkFailurePages=[]`, `contrastFailurePages=[]`.
- Mobil footer 390px: hotfix-style finns, `.sb-footer-col-links-wrapper` renderas som `grid`, `overflowingCount=0`.
- Ortssidor/neutralbilder: 26/26, `totalBadImgs=0`, inga `kommer snart` i text/alt/src.
- Analytics consent sample: `analyticsCookies=[]` fore aktivt samtycke i rensad staging-session.

Screenshots:

- `filemanager-functions-deploy-20260618-0925/screenshots-ux-v18/footer-home-bottom-mobile-v19-390x844.png`
- `filemanager-functions-deploy-20260618-0925/screenshots-ux-v18/footer-kontakt-bottom-desktop-1280x900.png`
- `filemanager-functions-deploy-20260618-0925/screenshots-neutral-v18/amal-neutral-mobile-390x844.png`

## Quality gates

Korda efter v19:

- `node --check wp\seniorbolaget-theme\js\sb-design-cleanup.js`: pass
- `node scripts\verify-a11y-css.mjs`: pass
- `node scripts\verify-conversion-a11y.mjs`: pass
- `node scripts\verify-content-seo.mjs`: pass
- `node scripts\verify-content-style.mjs`: pass
- `node scripts\verify-launch-trust.mjs`: pass
- `node scripts\verify-internal-links.mjs`: pass
- `node scripts\quality-gate-staging-crawl.mjs`: pass, 75/75 direct 200
- `git diff --check`: exit 0, endast LF/CRLF-varningar fran Git

## Status

- `LH-P1-002`: Verified
- `LH-P1-003`: Verified for P1 contrast/link scope; bred axe/landmark-review kvar i `LH-P2-012`
- `LH-P1-006`: Verified pa ny v19 ortsscan
- `LH-P2-001`: Verified
- `LH-P2-002`: Verified
- `LH-P3-001`: Verified
- `LH-P3-006`: Verified for clean-cookie analytics sample
