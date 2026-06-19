# Staging Neutral City Images Proof

Datum: 2026-06-18
Scope: staging only, `https://staging.seniorbolaget.se/har-finns-vi/`

## Beslut

Anvandaren beslutade 2026-06-18 att saknade/placeholder-bilder ska ersattas med neutrala bilder. Publik `bild kommer snart` ska inte visas.

## Andring

- Source: `wp/seniorbolaget-theme/js/sb-design-cleanup.js` ersatter image placeholders vars `alt`, `src` eller `srcset` innehaller `bild kommer snart`, `foto kommer`, `foto uppdateras` eller `uppdateras snart`.
- Staging deploy: One.com File Manager uppdaterad med `functions-after-v9.php`.
- Nytt staging-only block: `SENIORBOLAGET STAGING NEUTRAL CITY IMAGES HOTFIX START 2026-06-18`.
- Rollback: aterstall `functions-after-v8.php`, eller ta bort neutral city images hotfix-blocket och rensa cache.

## Fore-fynd

`rendered-city-neutral-images-before-v9.json`:

- 26 ortssidor scannade.
- 4 sidor hade placeholderbilder: `amal`, `eskilstuna`, `goteborg`, `karlstad`.
- Totalt 12 bilder med `alt="Bild kommer snart"` och SVG-source med `bild kommer snart`.

## Efter-verifiering

`rendered-city-neutral-images-v9.json`:

- 26/26 ortssidor passerade.
- 0 gamla `Bild kommer snart`-bilder.
- 0 synlig `kommer snart`/`bild kommer snart`-text.
- 12 neutrala ersattningsbilder renderade.
- Tidigare hotfixar kvar: `sbCityContactHotfix=applied` och `sbLaunchTrustHotfix=applied`.
- `4.9`/snittbetyg, `300+`, `Hundratals`, `8 ar i branschen` fortsatt borta i ortsscan.

## Ny efter-verifiering v19

Efter anvandarnoteringen om att `kommer snart` fortfarande syntes nagonstans kordes ett nytt live-svep efter v19-deploy och cache clear.

`rendered-city-neutral-images-v19.json`:

- 26/26 ortssidor passerade.
- `totalBadImgs=0`.
- `pagesWithComingSoonText=[]`.
- 12 neutrala ersattningsbilder renderade.
- Ingen `kommer snart`-traff i synlig text, `alt`, `src`, `currentSrc` eller `srcset`.

## Ny efter-verifiering v23

Efter ytterligare anvandarnotering om neutrala bilder scannades ortssidorna igen. v22b visade att sju orter fortfarande hade trasiga `franchisee_*`-bilder med 0x0 dimensioner:

- `laholm`
- `landskrona`
- `nassjo`
- `sundsvall`
- `torsby`
- `trelleborg`
- `trollhattan`

v23 lagger ett staging-only neutralbildsblock ovanpa tidigare patchar och ersatter dessa verifierat trasiga filnamn med samma neutrala SVG-bildsystem.

`rendered-city-neutral-images-v23-focused.json`:

- 26/26 ortssidor passerade.
- `totalCityImageIssues=0`.
- `pagesWithComingSoonText=[]`.
- Inga kvarvarande placeholder-/coming-soon-/missing-bildnamn i ortsbildsscope.
- Inga kvarvarande `franchisee_*`-bilder med 0x0 dimensioner i ortsbildsscope.

Staging snapshot:

- `filemanager-functions-deploy-20260618-0925/functions-after-v23.php`
- Nytt block: `SENIORBOLAGET STAGING NEUTRAL CITY IMAGES V23 HOTFIX START 2026-06-18`.
- Rollback for v23: aterstall `functions-after-v22.php` eller ta bort v23-blocket och rensa cache.

## Screenshots

- `filemanager-functions-deploy-20260618-0925/screenshots-neutral-v9/amal-mobile-390x844.png`
- `filemanager-functions-deploy-20260618-0925/screenshots-neutral-v9/amal-desktop-1280x900.png`
- `filemanager-functions-deploy-20260618-0925/screenshots-neutral-v18/amal-neutral-mobile-390x844.png`

## Commands

```powershell
node --check wp\seniorbolaget-theme\js\sb-design-cleanup.js
node scripts\verify-launch-trust.mjs
node scripts\quality-gate-staging-crawl.mjs
node scripts\verify-city-contacts.mjs
node scripts\verify-content-seo.mjs
node scripts\verify-content-style.mjs
git diff --check
```

Resultat:

- JS syntax: pass.
- Launch trust lint: pass.
- Staging crawl: 75 URLs direct 200.
- City contact lint: pass.
- Content/SEO lint: pass.
- Content style lint: pass.
- `git diff --check`: pass, med endast befintlig Git-varning om LF -> CRLF for `sb-design-cleanup.js`.
- `php -l` kunde inte koras lokalt eftersom PHP CLI saknas i miljön.
