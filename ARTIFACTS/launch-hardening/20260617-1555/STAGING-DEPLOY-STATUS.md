# Staging deploy status

Date: 2026-06-18

## Current status

Live staging is not updated with the launch-hardening source changes yet.

Read-only checks against staging showed old city contact content still present:

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

## Blocker

`https://staging.seniorbolaget.se/wp-admin/` redirects to the WordPress login page. There is no authenticated admin session available in the in-app browser.

The repo does not contain a staging deployment workflow, staging WP-CLI alias, or documented SFTP/hosting deploy command. Previous staging changes in the project documentation were made manually through WordPress admin/WPCode and One.com cache clearing.

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
