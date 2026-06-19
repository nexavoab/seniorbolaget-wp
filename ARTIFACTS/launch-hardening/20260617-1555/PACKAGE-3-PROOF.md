# Paket 3 Proof - Content + SEO

Datum: 2026-06-18
Branch: `codex/launch-hardening-20260617-1555`

## Scope i denna korning

Autonomt genomfort:

- `LH-P2-009`: lade till en source-level 404-sokmodul med korrekta svenska tecken:
  - `Söka istället?`
  - `Sök på sajten`
  - `Besök någon av våra populära sidor`
  - `Hemstädning`
  - `Företag`
  - `Vardagshjälp`
- Lade till `scripts/verify-content-seo.mjs` som regression/lint for 404-teckenkodning och sokmodul.

Inte genomfort i denna del:

- Markdown-tabeller i live guideartiklar (`LH-P1-005`), eftersom källan i denna branch inte innehaller artiklarnas råa markdown-tabell; tidigare WPCode/design cleanup har en runtime-konverterare.
- Em dash/` ,` bred copy-stadning (`LH-P2-007`, `LH-P2-008`), eftersom manga traffar ar i genererade ortsbios och overlappar beslutskansliga fakta/voice.
- Canonical/noindex-policy (`LH-P2-004`), eftersom staging/prod SEO-beslut fortfarande saknas.

## RED

Kommando:

```powershell
node scripts\verify-content-seo.mjs
```

Resultat fore fix: `FAIL`.

Verifieraren hittade att `wp/seniorbolaget-theme/templates/404.html` saknade:

- `Söka istället?`
- `Sök på sajten`
- `Besök någon av våra populära sidor`
- `Hemstädning`
- `Företag`
- `Vardagshjälp`
- `<!-- wp:search`

## GREEN

Kommandon:

```powershell
node scripts\verify-content-seo.mjs
node --check scripts\verify-content-seo.mjs
node scripts\verify-conversion-a11y.mjs
node scripts\verify-launch-trust.mjs
git diff --check
```

Resultat:

- `verify-content-seo`: `PASS`.
- `node --check`: `PASS`.
- `verify-conversion-a11y`: `PASS`.
- `verify-launch-trust`: `PASS`.
- `git diff --check`: exit 0, endast Git line-ending-varning om LF/CRLF.

## Live gate kvar

Efter deploy till staging ska dessa gates koras innan raden kan markeras fullt `Verified`:

- Syntetisk 404 URL ska returnera HTTP 404.
- Screenshot/DOM-text ska visa korrekt å/ä/ö i sokmodul och populara lankar.
- Keyboard smoke ska kontrollera att sokfalt och lankar ar fokuserbara.

## Rollback

Git rollback:

```powershell
git revert <package-3-commit-sha>
```

Ingen WordPress/WPCode/staging/cache/databasandring gjordes i denna korning.

