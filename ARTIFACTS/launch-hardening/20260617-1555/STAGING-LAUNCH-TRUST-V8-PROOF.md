# Staging Launch Trust V8 Proof

Datum: 2026-06-18
Miljo: `https://staging.seniorbolaget.se`
Deploy-yta: One.com File Manager, `seniorbolaget.se/staging/wp-content/themes/seniorbolaget-theme/functions.php`

## Beslut som implementerats

- Recensioner lamnas kvar pa staging och byts precis fore launch.
- `4.9`/snittbetyg tas bort fran hela staging-renderingen.
- `300+` ersatts pa ortssidor med `Tusentals nojda kunder sedan 2008`.
- `8 ar i branschen` ersatts med `Sedan 2008 i branschen`.
- `/foretag/` far aterhallen B2B-ikonstil; sidans egna emoji ersatts med SVG-ikonpresentation.

## Deployment

- Fore-kopia/rollbackbas: `filemanager-functions-deploy-20260618-0925/functions-before.php`
- Slutlig uppladdad fil: `filemanager-functions-deploy-20260618-0925/functions-after-v8.php`
- File Manager visade sparad staging-sokvag: `https://seniorbolaget.se/staging/wp-content/themes/seniorbolaget-theme/functions.php`
- Cache/CDN rensad via WordPress admin efter deploy.

## Verifiering

- `rendered-launch-trust-v8.json`
  - Åmål och Torsby: inga `4.9`, inga `snittbetyg`, inga `300+`, inga `8 ar i branschen`.
  - Åmål och Torsby: `Tusentals nojda kunder sedan 2008`, `24h svarstid`, `Sedan 2008 i branschen`.
  - `/foretag/`: B2B-sidans egna emoji `🏢`, `🏗`, `👔`, `📄`, `📉`, `🎓`, `⚡` finns inte kvar i renderad text.
- `rendered-city-launch-trust-fullscan-v8.json`
  - 26/26 ortssidor passerade.
- `node scripts\quality-gate-staging-crawl.mjs https://staging.seniorbolaget.se/sitemap_index.xml 75 ARTIFACTS/launch-hardening/20260617-1555 250`
  - 75/75 URL:er returnerade direkt 200.
- `node scripts\verify-launch-trust.mjs`
  - Passed.
- `node scripts\verify-conversion-a11y.mjs`
  - Passed.
- `node scripts\verify-content-seo.mjs`
  - Passed.
- `git diff --check`
  - Passed.

## Rollback

1. Aterstall `functions-before.php` via One.com File Manager, eller ta bort blocket
   `SENIORBOLAGET STAGING LAUNCH TRUST HOTFIX START 2026-06-18` till `END`.
2. Rensa One.com Performance Cache/CDN.
3. Kontrollera ortssidor, `/foretag/`, startsida och 75-URL crawl.
