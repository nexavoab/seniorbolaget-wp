# Package 3 Content Style Proof

Timestamp: 2026-06-18
Branch: `codex/launch-hardening-20260617-1555`
Scope: source-only content style normalization for visible theme copy.

## Changed

- Replaced visible em dash characters in theme patterns/templates/parts with regular hyphen phrasing.
- Normalized accidental ` ,` spacing where found by the same source lint.
- Added `scripts/verify-content-style.mjs` to block visible em dash and ` ,` regressions in theme source.

## Verification

RED before fix:
- `node scripts\verify-content-style.mjs`
- Exit: 1
- Output: `Content style lint failed`
- Sample: `franchise-page.php`, `hemstad-page.php`, `jobba-med-oss-page.php`, city pages, and more.

GREEN after fix:
- `node scripts\verify-content-style.mjs`
- Exit: 0
- Output: `Content style lint passed`

Regression checks:
- `node --check scripts\verify-content-style.mjs` -> exit 0
- `node scripts\verify-content-seo.mjs` -> `Content/SEO lint passed`
- `node scripts\verify-launch-trust.mjs` -> `Launch trust lint passed`
- `node scripts\verify-conversion-a11y.mjs` -> `Conversion accessibility lint passed`
- `node scripts\verify-a11y-css.mjs` -> `A11y CSS lint passed`

## Remaining Live Gates

- Deploy to staging only after backup/snapshot and rollback path are confirmed.
- Run DOM/text sitemap content-lint against staging.
- Capture screenshot spot checks for affected city/service pages.

## Rollback

- Source rollback: `git revert <package-commit-sha>`.
- If already deployed to WordPress/staging: restore prior theme version or redeploy previous commit, then clear caches.
