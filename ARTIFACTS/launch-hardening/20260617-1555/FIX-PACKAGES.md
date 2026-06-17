# Fixpaketplan

Mål: genomfora Plan B i sma, rollbackbara paket efter att fas 1 godkants. Varje paket ska ha egen commit, bevisfil och uppdaterad `MASTERLIST.md`.

## Kvalitetsramverk

- WCAG 2.2 AA och W3C/WAI Easy Checks for tillganglighet.
- NN/g 10 usability heuristics for UX.
- Google Core Web Vitals: Lighthouse/PageSpeed ar labbdata; faltdata ska inte utlovas utan Search Console/CrUX.
- Google SEO Starter Guide for crawlbarhet, canonical, metadata och lankstruktur.
- OWASP WSTG light for headers, mixed content, consent/tracking och runtime errors.
- WordPress Theme Handbook, revisions och backups for rollbackbarhet.
- GitHub PR/status-check discipline: sma commits, PR, verifiering fore merge.

## Paket 1: Launch Trust

Syfte: ta bort publika launch-risker som underminerar fortroende.

Ingar:

- `LH-P0-001`: exempelrecensioner/innan-lansering-text.
- `LH-P1-006`: ortsbilder och "bild kommer snart".
- `LH-P1-007`: overifierade ortsomdomen.
- `LH-P1-008`: ortstelefonnummer/e-post.
- `LH-P1-009`: hemtjanst/omsorg-fel i `/priser/` och social metadata.
- `LH-P1-010`: statistikansprak.

Autonomt mojligt:

- Ta bort/fixa hemtjanst/omsorg-copy enligt känd policy, om root cause finns i theme/source eller content med revision.

Krav pa beslut innan fix:

- Recensioner: verifierade omdomen eller dold modul.
- Ortsbilder: riktiga bilder eller dold/neutral modul.
- Telefon/e-post per ort.
- Sanna statistiksiffror eller beslut att dolja.

Acceptans:

- Inga publika exempelrecensioner.
- Ingen felaktig hemtjanst/omsorg-kontext utom godkand avgransning pa `/vardagshjalp/`.
- Inga statclaims utan godkand faktalista.
- Inga "bild kommer snart" eller overifierade lokala omdomen publikt.

Verifiering:

- Content-lint over sitemap for forbjudna launch-texter.
- DOM/text scan pa startsida, `/priser/`, `/foretag/`, `/har-finns-vi/`, alla ortssidor.
- Screenshots 360x740, 390x844, 768x1024, 1280x900 for home, `/har-finns-vi/`, Goteborg, Orebro, `/priser/`.
- WP revision/export eller Git commit-SHA sparad innan/efter.

Rollback:

- Se `ROLLBACK.md`, Paket 1.

## Paket 2: Conversion + Accessibility

Syfte: gora kritiska floden klickbara, tydliga och WCAG-sakrare.

Ingar:

- `LH-P1-001`: logo hem-lank.
- `LH-P1-002`: hjalppanel/CTA-policy.
- `LH-P1-003`: kontrast enligt WCAG AA.
- `LH-P1-004`: form labels/GDPR-label.
- `LH-P2-001`: mobil footer om den blockerar conversion/a11y.
- `LH-P2-002`: lankar som bara skiljs med farg.

Autonomt mojligt:

- Logo hem-lank.
- Form labels/GDPR-labels.
- Kontrastfixar pa tydligt identifierade komponenter.
- Link-underlines/icke-fargmarkor.
- Mobil footer layout om rotorsaken ar CSS/theme source.

Krav pa beslut innan fix:

- Exakt CTA/hjalppanel-policy.

Acceptans:

- Logo klickar hem pa desktop och mobil.
- Formulärfält har labels och fungerar med tangentbord.
- Inga nya axe critical/serious; P1-kontrast/formlabels fixade i sample.
- CTA/panel default beter sig enligt godkand policy.

Verifiering:

- axe sample home, `/intresseanmalan/`, `/kontakt/`, guide.
- Keyboard smoke: header, mobilmeny, formulär, cookie-modal, hjälppanel/CTA.
- Screenshots 360/390/768/1280 for P1-sidor.

Rollback:

- Se `ROLLBACK.md`, Paket 2.

## Paket 3: Content + SEO

Syfte: stada innehall, artiklar och SEO-risker utan att gissa prod-policy.

Ingar:

- `LH-P1-005`: rå markdown-tabell och listor.
- `LH-P2-004`: canonical/noindex-policy staging/prod.
- `LH-P2-007`: em dash/stilregler.
- `LH-P2-008`: ` ,`-typografi.
- `LH-P2-009`: 404 å/ä/ö.
- `LH-P2-010`: kontakt-dubblett.
- `LH-P3-001`: trailing slash.
- `LH-P3-002`: breadcrumbs.
- `LH-P3-003`: hero-duplicering verifiering.
- `LH-P3-005`: ordlista.

Autonomt mojligt:

- Markdown-tabell/listsemantik om artikelinnehall kan revideras/aterstallas.
- 404-svenska tecken.
- Em dash och ` ,`-lint.
- Kontakt-dubblett.
- Trailing slash-interna lankar.
- Hero-duplicering verifiering.

Krav pa beslut innan fix:

- Staging/prod SEO-policy for noindex/canonical.

Acceptans:

- Inga råa markdown-tabeller syns.
- 404 ar korrekt svensk.
- Inga em dash/` ,` enligt lint i relevanta sidor.
- SEO-policy dokumenterad innan noindex/canonical andras.

Verifiering:

- 75-URL crawl: alla 200, inga oavsiktliga 404 eller redirect loops.
- Content-lint for markdown, em dash, ` ,`, forbidden launch words.
- Lighthouse SEO sample redovisas som labbdata.

Rollback:

- Se `ROLLBACK.md`, Paket 3.

## Paket 4: Mobile + Performance + Security Light

Syfte: sakerstalla mobil, Core Web Vitals-labb, runtime och security light.

Ingar:

- `LH-P1-011`: mobil LCP/CLS home + intresseanmalan.
- `LH-P2-001`: mobil footer om inte fixad i Paket 2.
- `LH-P2-003`: cookie first impression.
- `LH-P2-005`: HSTS prod-beslut.
- `LH-P2-006`: CSP-worker-varning.
- `LH-P2-011`: fontoverhead.
- `LH-P2-012`: landmarks/heading-semantik.
- `LH-P3-006`: GA pre-consent verifiering.
- `LH-P3-007`: cache/TTFB verifiering.

Autonomt mojligt:

- CSP-worker root cause investigation.
- Font-request reduction om theme source ar tydlig.
- Landmark/heading template cleanup om risk lag.
- Mobil footer/cookie presentation efter policy.
- Lighthouse/Playwright verification.

Krav pa beslut innan fix:

- HSTS-prodpolicy.
- CSP-riskacceptans om worker kraver `blob:`.
- Analytics/consent-policy for GA.

Acceptans:

- Lighthouse labbdata for home, intresseanmalan, guide ar dokumenterad before/after.
- CLS/LCP-root cause ar fixad eller dokumenterad med blockering.
- Runtime sample: inga nya console errors, failed requests, mixed content.
- Security headers-policy ar dokumenterad; inga chansade prodheaders.

Verifiering:

- Playwright screenshots 360x740, 390x844, 768x1024, 1280x900.
- Lighthouse sample: home, intresseanmalan, guide.
- Runtime technical sample: console errors, failed requests, mixed content, headers.
- Ren browser context for consent/cookies.

Rollback:

- Se `ROLLBACK.md`, Paket 4.

## Global quality gates fore merge

- 75-URL sitemap crawl: alla 200, inga oavsiktliga 404 eller redirect loops.
- Content-lint: inga forbjudna launch-texter, inga publika exempelrecensioner, felaktig hemtjanst-kontext borta.
- axe sample: inga nya critical/serious; P1-kontrast/formlabels fixade.
- Lighthouse sample: home, intresseanmalan, guide; labbdata redovisas med datum och viewport.
- Playwright screenshots: 360x740, 390x844, 768x1024, 1280x900 for P0/P1-sidor.
- Keyboard smoke: header, mobilmeny, formulär, cookie-modal, hjälppanel/CTA.
- Runtime technical sample: console errors, failed requests, mixed content, headers.
- Rollbackbevis finns for varje staging/WPCode/content-andring.
- Ingen merge utan grona gates eller dokumenterade blockerade beslut.

