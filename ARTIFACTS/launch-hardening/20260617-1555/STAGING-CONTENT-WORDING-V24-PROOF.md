# Staging Content Wording V24 Proof

Datum: 2026-06-18
Scope: staging only, rendered copy sample for home, `/snickeri/`, `/priser/`, `/foretag/`.

## Fynd

Live staging hade kvar synliga formuleringar med `lösning` i CTA/snickeri-copy, plus en trasig mening pa `/snickeri/`:

- `Bygg- och montering av hyllsystem, garderober och anpassada lösningar.`
- `Varje uppdrag är unikt. Vi anpassar lösningen efter dig.`
- `Berätta för oss vad du behöver hjälp med, så hittar rätt lösning vi en lösning som passar dig perfekt.`

## Andring

- Source: `wp/seniorbolaget-theme/patterns/snickeri-page.php` byter snickeritext till `anpassade snickeriarbeten` och `Vi anpassar arbetet efter dig.`
- Source: `wp/seniorbolaget-theme/js/sb-design-cleanup.js` lagger till `repairContentWording()`.
- Staging deploy: One.com File Manager uppdaterad med `functions-after-v24.php`.
- Nytt block: `SENIORBOLAGET STAGING CONTENT WORDING V24 HOTFIX START 2026-06-18`.
- Rollback: aterstall `functions-after-v23.php`, eller ta bort v24-blocket och rensa cache.

## Verifiering

`rendered-content-wording-v24.json`:

- 4/4 sample passerade.
- `failed=0`.
- 0 traeffar for de daliga formuleringarna.
- 0 traeffar for `omsorg`, `hemtjänst`, `ledsagning`, `vård` i sample.

Regression gates:

```powershell
node --check wp\seniorbolaget-theme\js\sb-design-cleanup.js
node scripts\verify-content-style.mjs
node scripts\verify-launch-trust.mjs
node scripts\quality-gate-staging-crawl.mjs
```

Resultat:

- JS syntax: pass.
- Content style lint: pass.
- Launch trust lint: pass.
- Staging crawl: 75 URLs direct 200.
- `php -l` kunde inte koras lokalt eftersom PHP CLI saknas i miljön.
