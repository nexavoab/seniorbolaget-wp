# Paket 2 Proof - Conversion + Accessibility

Datum: 2026-06-18
Branch: `codex/launch-hardening-20260617-1555`

## Scope i denna korning

Autonomt genomfort:

- `LH-P1-001`: explicit `isLinkHome: true` pa WordPress `site-logo` i header-kallan.
- `LH-P1-004`: kopplade synliga/screen-reader labels till text/number/tel/textarea-falt i bada intresseanmalan-kallorna:
  - `wp/seniorbolaget-theme/patterns/intresse-anmalan-page.php`
  - `wp/seniorbolaget-theme/templates/page-intresse-anmalan.php`
- Lade till `scripts/verify-conversion-a11y.mjs` som source-level regression/lint.

Inte genomfort i denna del:

- Kontrastpass (`LH-P1-003`), eftersom det kraver bredare visuell kontroll.
- Hjalppanel/CTA-policy (`LH-P1-002`), eftersom den fortfarande kraver beslut.
- Live staging axe/click/keyboard, eftersom inga staging/WPCode/content/deploy-andringar gjordes.

## RED

Kommando:

```powershell
node scripts\verify-conversion-a11y.mjs
```

Resultat fore fix: `FAIL`.

Verifieraren hittade:

- Header saknade explicit `"isLinkHome":true`.
- `patterns/intresse-anmalan-page.php` saknade `for`/`id`-kopplingar for city search, area, notes, description, name och phone.
- `templates/page-intresse-anmalan.php` saknade motsvarande `for`/`id`-kopplingar.

## GREEN

Kommandon:

```powershell
node scripts\verify-conversion-a11y.mjs
node --check scripts\verify-conversion-a11y.mjs
node scripts\verify-launch-trust.mjs
git diff --check
```

Resultat:

- `verify-conversion-a11y`: `PASS`.
- `node --check`: `PASS`.
- `verify-launch-trust`: `PASS`.
- `git diff --check`: exit 0, endast Git line-ending-varningar om LF/CRLF.

## Live gate kvar

Efter deploy till staging ska dessa gates koras innan raderna kan markeras fullt `Verified`:

- Playwright logo-click pa desktop och mobil.
- axe sample pa `/intresseanmalan/` och `/kontakt/`.
- Keyboard smoke for header, mobilmeny och formulär.

## Live update 2026-06-18 v19

Staging deployades via One.com File Manager med rollbackbara block upp till `functions-after-v19.php`.

Verifierat nu:

- `LH-P1-001`: fortsatt Verified fran `rendered-conversion-a11y-v10.json`.
- `LH-P1-002`: Verified. `rendered-cta-focus-v16.json` visar stangd CTA/FAB utan fokusbara dolda lankar och oppen FAB med korrekt `aria-hidden=false`.
- `LH-P1-003`: Verified for P1 kontrast/link scope. `rendered-a11y-css-v19.json` visar 4/4 sample utan footer contrast/link failures. Bred axe/landmark-review ligger kvar i `LH-P2-012`.
- `LH-P1-004`: fortsatt Verified fran `rendered-conversion-a11y-v10.json`.
- `LH-P2-001`: Verified. `rendered-footer-mobile-layout-v19.json` visar mobil footer wrapper som `grid`, 1 kolumn och `overflowingCount=0`.
- `LH-P2-002`: Verified. `rendered-a11y-css-v19.json` visar `linkFailurePages=[]`.

Bevis:

- `STAGING-UX-A11Y-V19-PROOF.md`
- `filemanager-functions-deploy-20260618-0925/rendered-a11y-css-v19.json`
- `filemanager-functions-deploy-20260618-0925/rendered-footer-mobile-layout-v19.json`
- `filemanager-functions-deploy-20260618-0925/screenshots-ux-v18/footer-home-bottom-mobile-v19-390x844.png`
- `filemanager-functions-deploy-20260618-0925/screenshots-ux-v18/footer-kontakt-bottom-desktop-1280x900.png`

## Rollback

Git rollback:

```powershell
git revert <package-2-commit-sha>
```

Ingen WordPress/WPCode/staging/cache/databasandring gjordes i denna korning.
