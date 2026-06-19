# Staging deploy status

Date: 2026-06-19

## Current status

Live staging is updated through staging-only One.com File Manager patches up to `functions-after-v34.php`.

Current verified live scope:

- city contact rendering
- launch trust copy/stat cleanup
- neutral city images, no public `kommer snart`
- v23 neutral replacements for verified broken `franchisee_*` city images
- logo/form labels
- care-context copy cleanup
- 404 Swedish copy
- content/SEO cleanup for markdown table, punctuation and staging noindex sample
- content wording cleanup for visible `lösning`/snickeri regression
- font request cleanup, logo dimensions and mobile CLS reservation
- CSP `worker-src`, cookie first-impression placement, landmark normalization and WordPress i18n script-order cleanup
- staging form test routing to `wasim.bitar@seniorbolaget.se` and repaired `/kontakt/` tab form handler
- CTA/FAB focus behavior
- footer link affordance, contrast and mobile stacking
- decorative emoji/icon-prefix policy across home, company, interest, contact and city pages

Latest proofs:

- `PROOFS-LAUNCH-HARDENING.md`
- `STAGING-EMOJI-POLICY-V22-PROOF.md`
- `STAGING-NEUTRAL-CITY-IMAGES-PROOF.md`
- `STAGING-CONTENT-WORDING-V24-PROOF.md`
- `STAGING-PERFORMANCE-FONTS-CLS-V30-PROOF.md`
- `STAGING-SECURITY-COOKIE-LANDMARK-V32-PROOF.md`
- `STAGING-FORM-TEST-V34-PROOF.md`
- `STAGING-HEADERS-TTFB-V1-PROOF.md`
- `STAGING-UX-A11Y-V19-PROOF.md`

Latest crawl: `STAGING-CRAWL-75.md`, 75/75 direct 200.

## Earlier city-contact context

Initial read-only checks against staging showed old city contact content still present:

| URL | Expected source change | Live staging status |
| --- | --- | --- |
| `https://staging.seniorbolaget.se/har-finns-vi/eskilstuna/` | `Ann-Sofi Persson`, `0721-511 815` | Not present; old shared phone is still present |
| `https://staging.seniorbolaget.se/har-finns-vi/torsby/` | `Runar Skoglund`, `054-560 160` | Not present; old shared phone is still present |
| `https://staging.seniorbolaget.se/har-finns-vi/orebro/` | City contact source cleanup from production evidence | Old shared phone is still present |

## Prepared for deploy

- Source branch pushed: `origin/codex/launch-hardening-20260617-1555`
- Latest source commit: `737c48c fix: update city contact details from production`
- Deploy package built locally:
  `ARTIFACTS/launch-hardening/20260617-1555/deploy-ready-20260618-085332/seniorbolaget-theme-launch-hardening.zip`

The zip contains the WordPress theme folder `seniorbolaget-theme/` and includes updated city pattern files such as:

- `seniorbolaget-theme/patterns/stad-eskilstuna-page.php`
- `seniorbolaget-theme/patterns/stad-torsby-page.php`
- `seniorbolaget-theme/patterns/stad-orebro-page.php`

## Deployed staging patch

Because the city pages are saved WordPress page content, uploading only the theme source is not sufficient to update the visible city contact details. The applied staging fix is a marked `wp_footer` runtime patch in:

`seniorbolaget.se/staging/wp-content/themes/seniorbolaget-theme/functions.php`

Deploy proof:

`ARTIFACTS/launch-hardening/20260617-1555/STAGING-FILEMANAGER-DEPLOY-PROOF.md`

2026-06-18 09:32: patch v2 deployed after a full rendered city scan found three edge cases. V2 full rendered scan passed 26/26 city pages.

## Blocker

Resolved: user logged in through One.com/WP admin and One.com File Manager was used for staging-only deployment.

The repo still does not contain a staging deployment workflow, staging WP-CLI alias, or documented SFTP/hosting deploy command. The live staging update was performed manually through One.com File Manager with local before/after artifacts.

## Safe deployment path

Before updating live staging:

1. Log in to WordPress admin for `staging.seniorbolaget.se`, or provide the documented staging deploy path.
2. Capture rollback proof before changing staging:
   - current active theme name/version,
   - current theme export or hosting file backup,
   - any relevant WPCode/footer snippet before-copy,
   - cache state and cache clear path.
3. Upload or deploy the verified theme package to staging only.
4. Clear staging cache.
5. Re-run the staging verification gates and update `MASTERLIST.md`.

## Rollback

If the theme package is deployed and staging fails post-checks:

1. Restore the previously captured active theme files/export, or re-upload the previous theme package.
2. Restore any WPCode/footer snippet from its before-copy if it was changed.
3. Clear One.com/WordPress cache.
4. Re-run the same URL checks to confirm old staging state is restored.
