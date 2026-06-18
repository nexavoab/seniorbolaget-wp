# Package 2 A11y CSS Proof

Timestamp: 2026-06-18
Branch: `codex/launch-hardening-20260617-1555`
Scope: source-only theme CSS hardening for accessible link affordance and red-background contrast.

## Changed

- Added source CSS rules so content links, footer links, and service-card read-more links keep a visible underline even when blocks contain inline `text-decoration:none`.
- Added source CSS rules for text on `has-rod-background-color` sections to use white text.
- Added `scripts/verify-a11y-css.mjs` as a rollbackable source precheck.

## Verification

RED before fix:
- `node scripts\verify-a11y-css.mjs`
- Exit: 1
- Failed on missing content link affordance, underline override, and red-background text rule.

GREEN after fix:
- `node scripts\verify-a11y-css.mjs`
- Exit: 0
- Output: `A11y CSS lint passed`

Regression checks:
- `node --check scripts\verify-a11y-css.mjs` -> exit 0
- `node scripts\verify-conversion-a11y.mjs` -> `Conversion accessibility lint passed`
- `node scripts\verify-content-seo.mjs` -> `Content/SEO lint passed`
- `node scripts\verify-launch-trust.mjs` -> `Launch trust lint passed`
- `git diff --check` -> exit 0; warning only: CSS LF will be replaced by CRLF next time Git touches it.

## Remaining Live Gates

- Deploy to staging only after backup/snapshot and rollback path are confirmed.
- Run axe sample on staging.
- Run manual contrast checks on red cards/stat/footer/form.
- Capture responsive screenshots for affected pages.

## Rollback

- Source rollback: `git revert <package-commit-sha>`.
- If already deployed to WordPress/staging: restore prior theme version or redeploy previous commit, then clear caches.
