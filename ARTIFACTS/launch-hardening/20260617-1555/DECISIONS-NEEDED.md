# Decisions Needed

Inga av dessa far gissas. Om beslut saknas ska motsvarande MASTERLIST-rad vara `Needs decision` eller `Blocked`.

## Recensioner och omdomen

- Finns verifierade kundrecensioner som far publiceras med namn/ort?
- Om nej: ska hela recensionsmodulen pa startsidan doljas?
- Ska ortssidors lokala femstjarniga omdomen doljas tills verifierade recensioner finns?
- Finns juridiskt/gdpr-godkand kallastruktur for recensioner och citat?

Berorda rader: `LH-P0-001`, `LH-P1-007`.

## Ortstelefonnummer och e-post

- Ar `070-441 25 72` ett avsiktligt centralnummer for 24 orter, eller felaktig data?
- Ska "Din lokala kontakt i [ort]" visas om numret ar centralt?
- Finns korrekt telefon/e-post per franchisetagare/ort?
- Om korrekt data saknas: ska telefon/e-post eller lokal kontaktmodul doljas?

Berord rad: `LH-P1-008`.

## Statistik och trust claims

- Vilka siffror ar verifierade for `2 000+ seniorer`, `10 000+ nojda kunder`, `18+ ar`, `4.9`, `50+ foretagskunder`, `300+`, `120+`?
- Ska statsektioner doljas dar sanna siffror saknas?
- Vilka siffror ska galla pa foretagssidan, startsidan och ortssidorna?

Berord rad: `LH-P1-010`.

## Ortsbilder

- Finns godkanda franchisetagarbilder per ort?
- Vilka orter saknar bild?
- Om bild saknas: ska modulen doljas, ersattas av neutral godkand bild, eller visas utan bild?
- Far "bild kommer snart" nagonsin visas publikt? Rekommendation: nej.

Berord rad: `LH-P1-006`.

## CTA/hjalppanel-policy

- Ska global "Boka hjalp"-CTA vara enda flytande default-element?
- Pa vilka sidor ska bottenpanelen kunna oppnas: alla, inte formulär, inte 404, inte checkout-liknande floden?
- Ska panelen vara helt dold for tangentbordsfokus nar den ar stangd?

Berord rad: `LH-P1-002`.

## SEO-policy staging/prod

- Staging: ska `noindex,nofollow` vara kvar? Rekommendation: ja.
- Produktion: ska `noindex,nofollow` tas bort vid DNS/launch?
- Canonical: ska prod-canonical alltid peka pa `https://seniorbolaget.se/...`?
- Ska staging ha self-canonical, ingen canonical, eller canonical till prod? Beslut kravs innan implementation.

Berord rad: `LH-P2-004`.

## HSTS/CSP-prodpolicy

- Ska HSTS sattas i produktion, och med vilken `max-age`? Rekommation efter verifierad HTTPS: borja konservativt, inte preload forsta gangen.
- Ska staging ha samma HSTS som prod?
- Ska CSP fortsatta tillata `unsafe-inline`/`unsafe-eval` kortsiktigt?
- Ska `worker-src blob:` tillatas om worker-kallan ar legitim, eller ska worker-kallan tas bort?

Berorda rader: `LH-P2-005`, `LH-P2-006`.

## Ikon- och emoji-policy

- Ska site-wide UI anvanda ett enhetligt ikonbibliotek/stroke-system?
- Far emoji anvandas i tjanstelistor, ortssidor eller B2B-ytor?
- Ska B2B ha en tydligt mer aterhallen visuell variant?

Berorda rader: `LH-P2-013`, `LH-P3-004`.

## Analytics/samtycke

- Ska Google Analytics vara aktivt pa staging?
- Vilken consent-kategori ska GA tillhora i Complianz?
- Ska GA vara helt blockerat fore aktivt samtycke? Rekommendation: ja, om statistik-cookies anvands.

Berord rad: `LH-P3-006`.

