# Launch Hardening Proof Summary

Date: 2026-06-18

Staging:

`https://staging.seniorbolaget.se`

Production:

Not changed.

## Current deploy

Staging is updated through One.com File Manager to:

`filemanager-functions-deploy-20260618-0925/functions-after-v32.php`

Verified readback:

`filemanager-functions-deploy-20260618-0925/functions-editor-after-v32-readback.php`

Readback SHA256:

`bfbaaefbe9188de25b91da12afdd8ecece2fa5c6c21ddf79dc2650bae183bbd3`

## Masterlist status

`MASTERLIST.md` status after v32:

- `Verified=30`
- `Needs decision=2`
- `Ready=0`
- `Blocked=0`

The two remaining decisions are review/testimonial-related and intentionally left until just before launch per user decision.

## Proof files

- `STAGING-FILEMANAGER-DEPLOY-PROOF.md`
- `PACKAGE-2-PROOF.md`
- `PACKAGE-2-A11Y-CSS-PROOF.md`
- `PACKAGE-3-INTERNAL-LINKS-PROOF.md`
- `STAGING-NEUTRAL-CITY-IMAGES-PROOF.md`
- `STAGING-EMOJI-POLICY-V22-PROOF.md`
- `STAGING-CONTENT-WORDING-V24-PROOF.md`
- `STAGING-PERFORMANCE-FONTS-CLS-V30-PROOF.md`
- `STAGING-SECURITY-COOKIE-LANDMARK-V32-PROOF.md`
- `STAGING-HEADERS-TTFB-V1-PROOF.md`

## Final gates

Passed after v32:

- `node scripts\verify-a11y-css.mjs`
- `node scripts\verify-conversion-a11y.mjs`
- `node scripts\verify-content-style.mjs`
- `node scripts\verify-launch-trust.mjs`
- `node scripts\verify-internal-links.mjs`
- `node --check wp\seniorbolaget-theme\js\sb-design-cleanup.js`
- `node scripts\quality-gate-staging-crawl.mjs` -> 75/75 direct 200
- fresh browser console sample -> 0 warnings/errors after timestamp filter
- sample live HTML -> `main=1`, `header=1`, `footer=1`
- sample live CSP -> `worker-src 'self' blob:`
- sample WordPress i18n scripts -> `wp-hooks-js` and `wp-i18n-js` are not deferred
- `git diff --check` -> no errors, CRLF warnings only

Final Lighthouse lab data is stored in:

- `lighthouse-home-mobile-v32.json`
- `lighthouse-interest-mobile-v32.json`
- `lighthouse-prices-mobile-v32.json`

## Remaining launch actions

- Before public launch: replace or hide unverified reviews/testimonials.
- At production launch: remove noindex/nofollow and set canonical policy on production.
- At production launch: enable HSTS only after HTTPS verification, conservatively and without preload on first rollout.
- Verify production cache/headers after DNS/live switch.

## Rollback

Use `ROLLBACK.md`.

Fast rollback for the latest staging deploy:

1. Restore `functions-after-v31.php` to roll back only v32 i18n script-order.
2. Restore `functions-after-v30.php` to roll back v31/v32 security, cookie, landmark and i18n package.
3. Clear One.com/WordPress cache.
4. Re-run HTTP, console, crawl and screenshot checks.
