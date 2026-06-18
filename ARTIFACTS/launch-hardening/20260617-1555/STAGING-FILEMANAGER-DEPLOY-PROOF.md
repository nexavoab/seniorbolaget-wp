# Staging File Manager Deploy Proof

Date: 2026-06-18

## Scope

Staging only: `https://staging.seniorbolaget.se`.

No production changes were made.

## Deployment method

Deployed a marked staging-only footer runtime patch through One.com File Manager by editing:

`seniorbolaget.se/staging/wp-content/themes/seniorbolaget-theme/functions.php`

The patch is guarded by host:

`staging.seniorbolaget.se`

and path:

`/har-finns-vi/{city}/`

Marker:

`SENIORBOLAGET STAGING CITY CONTACT HOTFIX START 2026-06-18`

## Rollback

Rollback file captured before deploy:

`ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-before.php`

Rollback methods:

1. Restore `functions-before.php` over `seniorbolaget.se/staging/wp-content/themes/seniorbolaget-theme/functions.php` in One.com File Manager.
2. Or remove the marked block from `SENIORBOLAGET STAGING CITY CONTACT HOTFIX START 2026-06-18` through `SENIORBOLAGET STAGING CITY CONTACT HOTFIX END 2026-06-18`.
3. Clear WordPress/One.com staging cache and CDN cache.

## Local deploy artifacts

- Before file: `filemanager-functions-deploy-20260618-0925/functions-before.php`
- After file: `filemanager-functions-deploy-20260618-0925/functions-after.php`
- Typed editor verification: `filemanager-functions-deploy-20260618-0925/functions-editor-typed-verification.php`
- Server readback before successful save: `filemanager-functions-deploy-20260618-0925/functions-server-after-readback.php`
- Payload: `filemanager-functions-deploy-20260618-0925/city-contact-payload.json`

## Verification

Cache cleared through WordPress admin:

- `purge_varnish_cache=1`
- `purge_varnish_cache=cdn`

Raw HTML checks after deploy:

- Eskilstuna: status 200, patch marker present, `Ann-Sofi`, `0721-511 815` present.
- Torsby: status 200, patch marker present, `Runar`, `054-560 160` present.
- Home: status 200, no fatal/parse error, no city patch marker.

Rendered browser checks after script execution:

| Page | Expected rendered name | Expected rendered phone | Old phone rendered? | Tel links |
| --- | --- | --- | --- | --- |
| Eskilstuna | `Ann-Sofi Persson` | `0721-511 815` | No | `tel:0721511815`, central footer `tel:0101751900` |
| Torsby | `Runar Skoglund` | `054-560 160` | No | `tel:054560160`, central footer `tel:0101751900` |

Rendered checks confirmed:

- `#seniorbolaget-staging-city-contact-hotfix-20260618` exists on city pages.
- `document.documentElement.dataset.sbCityContactHotfix` is `applied`.
- Old shared phone `070-441 25 72` is not present in rendered city page text for the sampled pages.
