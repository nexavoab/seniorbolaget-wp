# Package 3 Internal Links Proof

Timestamp: 2026-06-18
Branch: `codex/launch-hardening-20260617-1555`
Scope: source-only SEO normalization for internal theme links.

## Changed

- Normalized internal `href="/path"` links in theme patterns/templates/parts to `href="/path/"`.
- Normalized WordPress block comment `"url":"/path"` values in theme parts to `"url":"/path/"`.
- Added `scripts/verify-internal-links.mjs` to block new internal source links that would trigger unnecessary trailing-slash redirects.

## Verification

RED before fix:
- `node scripts\verify-internal-links.mjs`
- Exit: 1
- Output: `Internal link lint failed`
- Sample: `/kontakt`, `/intresse-anmalan`, `/har-finns-vi/goteborg`, `/privat/hemstad`, `/tjanster/hemstad`.

GREEN after fix:
- `node scripts\verify-internal-links.mjs`
- Exit: 0
- Output: `Internal link lint passed`

Regression checks:
- `node --check scripts\verify-internal-links.mjs` -> exit 0
- `node scripts\verify-content-style.mjs` -> `Content style lint passed`
- `node scripts\verify-content-seo.mjs` -> `Content/SEO lint passed`
- `node scripts\verify-launch-trust.mjs` -> `Launch trust lint passed`
- `node scripts\verify-conversion-a11y.mjs` -> `Conversion accessibility lint passed`
- `node scripts\verify-a11y-css.mjs` -> `A11y CSS lint passed`
- `git diff --check` -> exit 0; warning only: selected theme files LF will be replaced by CRLF next time Git touches them.

## Remaining Live Gates

- Deploy to staging only after backup/snapshot and rollback path are confirmed.
- Run link crawl against staging and confirm normalized internal links do not create avoidable 301s.

## Live Update 2026-06-18

Live gate is now complete:

- `node scripts\verify-internal-links.mjs` -> `Internal link lint passed`
- `node scripts\quality-gate-staging-crawl.mjs` -> `Staging crawl passed: 75 URLs returned direct 200 responses`
- Evidence: `STAGING-CRAWL-75.md` and `staging-crawl-75.json`

`LH-P3-001` is marked `Verified` in `MASTERLIST.md`.

## Rollback

- Source rollback: `git revert <package-commit-sha>`.
- If already deployed to WordPress/staging: restore prior theme version or redeploy previous commit, then clear caches.
