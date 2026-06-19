# Package 1 City Contacts Proof

Timestamp: 2026-06-18
Branch: `codex/launch-hardening-20260617-1555`
Scope: source-only launch-trust fix for local city phone, email, and contact-person data.

## Source Of Truth

- Public production crawl: `https://www.seniorbolaget.se/har-finns-vi`
- Evidence files:
  - `PROD-CITY-CONTACTS.md`
  - `PROD-CITY-CONTACTS.json`
- User approval: user answered `kor` after being told production contact data could be used as the source for patching city pages.

## Changed

- Updated local city pattern files under `wp/seniorbolaget-theme/patterns/stad-*-page.php`.
- Replaced generic `0704412572` / `0704-41 25 72` phone links and visible phone text with production city-specific primary phone numbers.
- Updated `mailto:` links and visible emails to production city-specific local emails.
- Updated mismatched contact-person names where production differed from source, including Eskilstuna and Torsby.
- For `Laholm / Båstad`, visible copy now includes both local emails from production; button mailto uses the first local email.
- Added `scripts/verify-city-contacts.mjs` to compare city source files against `PROD-CITY-CONTACTS.json`.

## Verification

RED before fix:
- `node scripts\verify-city-contacts.mjs`
- Exit: 1
- Output: `City contact lint failed`
- Sample failures: Borås, Eskilstuna, Karlstad, Torsby, Örebro had missing/mismatched local phones; Eskilstuna and Torsby had mismatched local emails.
- Follow-up RED after adding contact-person assertions: Eskilstuna and Torsby had mismatched contact-person names.

GREEN after fix:
- `node scripts\verify-city-contacts.mjs`
- Exit: 0
- Output: `City contact lint passed`

Regression checks:
- `node --check scripts\verify-city-contacts.mjs` -> exit 0
- `node scripts\verify-internal-links.mjs` -> `Internal link lint passed`
- `node scripts\verify-content-style.mjs` -> `Content style lint passed`
- `node scripts\verify-content-seo.mjs` -> `Content/SEO lint passed`
- `node scripts\verify-launch-trust.mjs` -> `Launch trust lint passed`
- `node scripts\verify-conversion-a11y.mjs` -> `Conversion accessibility lint passed`
- `node scripts\verify-a11y-css.mjs` -> `A11y CSS lint passed`
- `git diff --check` -> exit 0

## Remaining Live Gates

- Deploy to staging only after backup/snapshot and rollback path are confirmed.
- Run DOM/text scan on all city pages after deploy.
- Manually spot-check local contact cards on mobile and desktop.

## Rollback

- Source rollback: `git revert <package-commit-sha>`.
- If already deployed to WordPress/staging: restore prior theme version or redeploy previous commit, then clear caches.
