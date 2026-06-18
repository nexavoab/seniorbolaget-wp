# Rollbackplan

Grundprincip: varje fixpaket ska kunna backas utan databasdestruktion och utan produktionsandring. Ingen staging-admin/WPCode/content-andring far goras utan fore-bevis.

## Stop conditions

Stoppa direkt och gor ingen fortsatt deploy om nagot av detta intraffar:

- Det saknas fore-kopia/revision/export for den yta som ska andras.
- WordPress admin visar ovantat miljo/domannamn eller produktionsdomän.
- En verifiering efter fix misslyckas tva ganger: fixa en gang, om samma gate faller igen ska paketcommiten revertas och arbetet pausas.
- Staging skiljer sig fran GitHub-koden pa ett satt som gor root cause oklar och rollbackvagen osaker.
- Fakta saknas for recensioner, telefonnummer, statistik, SEO-prodpolicy, HSTS eller CSP-riskacceptans.
- En andring skulle krava destruktiv DB-operation.

## Git source rollback

Galler theme/source-fixar i worktree.

1. Gor sma commits per fixpaket.
2. Spara commit-SHA i paketets bevisfil.
3. Vid rollback:

```powershell
git revert <commit-sha>
git status --short
```

4. Kor paketets verifiering igen.
5. Om revert skapar konflikt: stoppa, dokumentera konflikt och fraga innan manuell losning.

## WPCode rollback

Galler staging-only CSS/JS/PHP-snippets eller header/footer-injektioner.

Fore andring:

- Exportera/kopiera aktuell WPCode-snippet eller Sidhuvud/Sidfot-falt till artefakt.
- Dokumentera snippet/block-id, titel, status, plats och exakt fore-innehall.
- Ta screenshot eller JSON/text dump som visar att kopian ar tagen.

Rollback:

1. Oppna WordPress admin pa staging.
2. Kontrollera att domanen ar `staging.seniorbolaget.se`.
3. Gå till WPCode/Kodblock eller WPCode Sidhuvud och sidfot.
4. Aterstall fore-kopian exakt, eller toggla av den nya snippet som dokumenterats.
5. Spara.
6. Rensa One.com Performance Cache.
7. Kor relevant post-check: sitemap/status, runtime console, screenshots och content-lint.

Kanda tidigare staging-rollbackar:

- Visual hotfix: ta bort block mellan `SENIORBOLAGET STAGING VISUAL HOTFIX START 2026-06-16` och `SENIORBOLAGET STAGING VISUAL HOTFIX END 2026-06-16`.
- Sitemap hotfix: WPCode snippet ID `1734`, `SB staging sitemap hotfix - exclude deleted status drafts`, togglas inaktiv eller raderas efter godkand rollback.

## Staging File Manager rollback

Galler direkt staging-only andringar i `seniorbolaget.se/staging/wp-content/themes/seniorbolaget-theme/functions.php` via One.com File Manager.

Fore-kopia for 2026-06-18 finns i:

`ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-before.php`

Rollback:

1. Oppna One.com File Manager for staging-theme `functions.php`.
2. Kontrollera att sokvagen innehaller `/staging/wp-content/themes/seniorbolaget-theme/functions.php`.
3. Ersatt filen med fore-kopian ovan, eller ta bort markerade hotfix-block:
   - `SENIORBOLAGET STAGING CITY CONTACT HOTFIX START 2026-06-18` till `END`.
   - `SENIORBOLAGET STAGING LAUNCH TRUST HOTFIX START 2026-06-18` till `END`.
   - `SENIORBOLAGET STAGING NEUTRAL CITY IMAGES HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v8.php` om bara neutralbildspatchen ska backas.
   - `SENIORBOLAGET STAGING CONVERSION A11Y HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v9.php` om bara logo/formlabel-patchen ska backas.
   - `SENIORBOLAGET STAGING CARE CONTEXT COPY HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v10.php` om bara care-context-patchen ska backas.
   - `SENIORBOLAGET STAGING 404 SWEDISH COPY HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v11.php` om bara 404-patchen ska backas.
   - `SENIORBOLAGET STAGING CONTENT SEO CLEANUP HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v12.php` om bara content SEO cleanup-patchen ska backas.
   - `SENIORBOLAGET STAGING CTA FOCUS HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v14.php` om bara CTA-focus-patchen ska backas.
   - `SENIORBOLAGET STAGING FAB HANDLER HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v15.php` om bara FAB-handler-patchen ska backas.
   - `SENIORBOLAGET STAGING FOOTER LINK AFFORDANCE HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v16.php` om bara footer-link-patchen ska backas.
   - `SENIORBOLAGET STAGING FOOTER CONTRAST HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v17.php` om bara footer-contrast-patchen ska backas.
   - `SENIORBOLAGET STAGING MOBILE FOOTER LAYOUT HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v18.php` om bara mobile-footer-patchen ska backas.
   - `SENIORBOLAGET STAGING DECORATIVE EMOJI POLICY HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v19.php` om bara forsta emoji-patchen ska backas.
   - `SENIORBOLAGET STAGING DECORATIVE EMOJI POLICY V21 HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v20.php` om bara v21 ska backas.
   - `SENIORBOLAGET STAGING DECORATIVE EMOJI POLICY V22 HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v21.php` om bara v22 ska backas.
   - `SENIORBOLAGET STAGING NEUTRAL CITY IMAGES V23 HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v22.php` om bara v23 ska backas.
   - `SENIORBOLAGET STAGING CONTENT WORDING V24 HOTFIX START 2026-06-18` till `END`, eller aterstall `functions-after-v23.php` om bara v24 ska backas.
4. Spara.
5. Rensa One.com Performance Cache/CDN.
6. Kor post-check pa ortssidor, `/foretag/`, startsidan, neutralbildsscan och 75-URL crawl.

## WordPress content rollback

Galler sidor, inlagg, Rank Math metadata, blockinnehall, ortsdata som finns i WP.

Fore andring:

- Exportera sidan/inlagget eller hela relevant content via WordPress export om omfattningen ar stor.
- Spara revision-ID/timestamp och screenshot av revisionslistan.
- Kopiera fore-innehall for block/meta som ska andras.

Rollback:

1. Oppna aktuell sida/inlagg i staging admin.
2. Anvand WordPress Revisions och aterstall fore-revisionen, eller klistra tillbaka fore-kopian.
3. Aterstall Rank Math/SEO-falt fran fore-kopia om metadata andrades.
4. Spara.
5. Rensa cache.
6. Kor relevant URL-screenshot, DOM/content-lint och sitemap/status check.

## Cache rollback/clear

Efter varje staging-andring:

1. Rensa One.com Performance Cache.
2. Om WP/plugin-cache finns: rensa den.
3. Gor hard reload/ny browser context for verifiering.
4. Dokumentera cache-clear med screenshot eller admintext om mojligt.

## Rollback per fixpaket

### Paket 1: Launch Trust

Ytor: recensioner, hemtjanst/omsorg-copy, statistik, ortsbilder, telefon/e-post.

Rollback:

- Git: revert av theme/pattern/CITY_DATA-commit.
- WordPress content: revision/export fore andring.
- SEO metadata: Rank Math fore-kopia for og:title/canonical/meta.
- WPCode: fore-kopia om fixen ar staging-only snippet.
- File Manager: ta bort `SENIORBOLAGET STAGING CARE CONTEXT COPY HOTFIX` eller aterstall `functions-after-v10.php`.

### Paket 2: Conversion + Accessibility

Ytor: logo-lank, form labels, kontrast, hjalppanel/CTA.

Rollback:

- Git revert for header/template/CSS/JS.
- WPCode fore-kopia for staging-only CSS/JS.
- File Manager: ta bort `SENIORBOLAGET STAGING CONVERSION A11Y HOTFIX` eller aterstall `functions-after-v9.php`.
- File Manager: ta bort `SENIORBOLAGET STAGING CTA FOCUS HOTFIX` eller aterstall `functions-after-v14.php`.
- File Manager: ta bort `SENIORBOLAGET STAGING FAB HANDLER HOTFIX` eller aterstall `functions-after-v15.php`.
- File Manager: ta bort `SENIORBOLAGET STAGING FOOTER LINK AFFORDANCE HOTFIX` eller aterstall `functions-after-v16.php`.
- File Manager: ta bort `SENIORBOLAGET STAGING FOOTER CONTRAST HOTFIX` eller aterstall `functions-after-v17.php`.
- File Manager: ta bort `SENIORBOLAGET STAGING MOBILE FOOTER LAYOUT HOTFIX` eller aterstall `functions-after-v18.php`.
- Om plugin-installning for formular/CTA andras: screenshot/export fore och restore efter.
- File Manager: ta bort `SENIORBOLAGET STAGING DECORATIVE EMOJI POLICY V22 HOTFIX` eller aterstall `functions-after-v21.php`.

### Paket 3: Content + SEO

Ytor: markdown-tabell, 404 å/ä/ö, em dash/stilregler, canonical/noindex.

Rollback:

- WP revisions/export for artiklar och sidor.
- Git revert for templates/import/generator.
- File Manager: ta bort `SENIORBOLAGET STAGING 404 SWEDISH COPY HOTFIX` eller aterstall `functions-after-v11.php`.
- File Manager: ta bort `SENIORBOLAGET STAGING CONTENT SEO CLEANUP HOTFIX` eller aterstall `functions-after-v12.php`.
- File Manager: ta bort `SENIORBOLAGET STAGING NEUTRAL CITY IMAGES V23 HOTFIX` eller aterstall `functions-after-v22.php` for senaste neutralbildspasset.
- File Manager: ta bort `SENIORBOLAGET STAGING CONTENT WORDING V24 HOTFIX` eller aterstall `functions-after-v23.php` for senaste wording-passet.
- SEO-plugin fore-kopia for canonical/noindex.

### Paket 4: Mobile + Performance + Security Light

Ytor: mobil footer, CLS/LCP, CSP-worker, HSTS.

Rollback:

- Git revert for CSS/JS/templates.
- WPCode/header-snippet fore-kopia.
- File Manager: ta bort `SENIORBOLAGET STAGING MOBILE FOOTER LAYOUT HOTFIX` eller aterstall `functions-after-v18.php`.
- Hosting/server-header rollback bara efter dokumenterad fore-konfiguration.
- HSTS ska inte aktiveras med preload i denna fas; prod-beslut kravs innan deploy.
