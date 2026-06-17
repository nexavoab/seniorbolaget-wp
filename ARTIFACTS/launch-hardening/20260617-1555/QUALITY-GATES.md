# Quality Gates

Denna fil ar en korbar/checkbar sammanstallning av gates som maste vara definierade fore fix. Exakta scripts kan ateranvandas fran tidigare artifact-korning eller skapas i kommande implementation, men resultaten ska sparas under samma launch-hardening-artefakttrad.

## Gate 1: 75-URL sitemap crawl

Acceptans:

- `sitemap_index.xml` ar 200.
- Alla sitemap-URL:er ar 200.
- Inga oavsiktliga 404.
- Inga redirect loops.
- Tidigare `status-draft*`-URL:er ar inte tillbaka.

Bevis:

- URL-lista, statuskod, final URL, redirect count.
- Sammanfattning: antal URL, antal 200, antal 3xx, antal 4xx/5xx.

## Gate 2: Content-lint

Acceptans:

- Inga publika exempelrecensioner eller "innan lansering"-texter.
- Inga fiktiva namn i recensionsmoduler om recensioner inte ar verifierade.
- Felaktig hemtjanst/omsorg/ledsagning-kontext borta enligt policy.
- Inga synliga `bild kommer snart` om beslutet ar dolj/ersatt.
- Inga råa markdown-tabeller.
- Inga em dash eller ` ,` dar stilregeln galler.
- 404 har korrekt å/ä/ö.

Bevis:

- DOM/text scan over sitemap.
- Stickprov screenshots for P0/P1-sidor.

## Gate 3: axe accessibility sample

Sample:

- `/`
- `/intresseanmalan/`
- `/kontakt/`
- `/har-finns-vi/`
- `vad-kostar-hemstadning-2026-priser-per-stad`
- syntetisk 404

Acceptans:

- Inga nya critical/serious.
- Formlabels/GDPR-label fixade.
- P1-kontrast fixad i berorda komponenter.
- Link-in-text-block fixad eller dokumenterad.

## Gate 4: Lighthouse sample

Sample:

- Home mobile + desktop.
- `/intresseanmalan/` mobile.
- Prisguide mobile.

Acceptans:

- Labbdata redovisas med datum, viewport och throttling.
- LCP/CLS-regressioner forklaras eller fixas.
- Det ska tydligt framga att detta inte ar faltdata/Core Web Vitals fran riktiga anvandare.

## Gate 5: Playwright screenshots

Viewports:

- 360x740
- 390x844
- 768x1024
- 1280x900

Sidor:

- `/`
- `/intresseanmalan/`
- `/kontakt/`
- `/har-finns-vi/`
- minst tva ortssidor, t.ex. Goteborg och Orebro
- `/priser/`
- prisguide
- syntetisk 404

Acceptans:

- Ingen overlap/klipp i header/footer/CTA/form/cookie.
- P0/P1-innehall ser launch-safe ut.
- Screenshots sparas med tydliga filnamn.

## Gate 6: Keyboard smoke

Floden:

- Header och logo.
- Desktopnav och mobilmeny.
- Formulär pa `/intresseanmalan/` eller `/kontakt/`.
- Cookie-modal.
- Hjalppanel/flytande CTA.

Acceptans:

- Fokusordning ar begriplig.
- Stangda paneler ar inte fokuserbara.
- Escape/stang-knappar fungerar dar relevant.
- Submit-flode kan navigeras utan mus.

## Gate 7: Runtime technical sample

Sample:

- Home.
- Foretag.
- Intresseanmalan.
- Har finns vi.
- Prisguide.
- 404.

Acceptans:

- Inga ovantade console errors.
- Inga failed requests pa site-resurser.
- Inget mixed content.
- Headers dokumenterade: CSP, XFO, XCTO, Referrer-Policy, Permissions-Policy, HSTS.
- noindex/canonical-policy kontrollerad mot beslut.

