# Staging Care Context v11 Proof

Datum: 2026-06-18
Scope: staging only

## Andring

- Source copy i theme patterns/generator bytt fran vard-/hemtjanstfraser till hushallsnara formuleringar.
- Source cleanup: `wp/seniorbolaget-theme/js/sb-design-cleanup.js` sanerar exakta publika riskfraser i renderad DOM.
- Staging deploy: One.com File Manager uppdaterad med `functions-after-v11.php`.
- Nytt staging-only block: `SENIORBOLAGET STAGING CARE CONTEXT COPY HOTFIX START 2026-06-18`.
- Rollback: aterstall `functions-after-v10.php`, eller ta bort care-context hotfix-blocket och rensa cache.

## Fore-fynd

Live-scan fore v11 hittade 4 publika traffar:

- `/priser/`: `Omsorg • Privat hemtjanst • Ledsagning`
- `/`: `omsorg och precision`

Ortsbios i live staging var redan sanerade, men source-patterns/generator inneholl fortfarande nagra vard-/hemtjanstfraser och ar uppdaterade.

## Efter-verifiering

`rendered-care-context-v11.json`:

- 7/7 sample-sidor passerade: `/`, `/priser/`, `/hemstadning/`, Helsingborg, Kungsbacka, Molndal, Nassjo.
- 0 traffar for `hemtjanst`, `privat hemtjanst`, `ledsagning`, `omsorg och precision`, `vard och omsorg`, `hjalpa med medicin`.
- `sbCareContextCopyHotfix=applied` pa alla sample-sidor.

## Commands

```powershell
node --check wp\seniorbolaget-theme\js\sb-design-cleanup.js
node scripts\verify-launch-trust.mjs
node scripts\verify-content-style.mjs
node scripts\verify-content-seo.mjs
node scripts\quality-gate-staging-crawl.mjs
git diff --check
```

Resultat:

- JS syntax: pass.
- Launch trust lint: pass.
- Content style lint: pass.
- Content/SEO lint: pass.
- Staging crawl: 75 URLs direct 200.
- `git diff --check`: pass, med endast befintliga Git-varningar om LF -> CRLF.
- `php -l` kunde inte koras lokalt eftersom PHP CLI saknas i miljön.
