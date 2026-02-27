# Testguide — Seniorbolaget WP Staging
**URL:** http://localhost:8888

## Checklista för Wasim

### ✅ Klara sidor (PR #1 + #2 mergade)
| Sida | URL | Vad titta på |
|------|-----|-------------|
| Startsida | / | Hero, tjänstkort, stats, CTA |
| Hemstädning | /privat/hemstad/ | Bento-grid, RUT-info, sticky CTA |

### 🔍 PR #3 (feat/tjanstesidor-batch) — väntar på merge

**Tjänstesidor:**
| Sida | URL |
|------|-----|
| Trädgård | /privat/tradgard/ |
| Målning | /privat/malning-tapetsering/ |
| Snickeri | /privat/snickeri/ |

**26 Stadssidor (v3 — franchisetagare som hero):**
| Stad | URL |
|------|-----|
| Göteborg | /har-finns-vi/goteborg-sv/ |
| Borås | /har-finns-vi/boras/ |
| Helsingborg | /har-finns-vi/helsingborg/ |
| Sundsvall | /har-finns-vi/sundsvall/ |
| (alla 26 under /har-finns-vi/) | |

**Info-sidor:**
| Sida | URL |
|------|-----|
| Om oss | /om-oss/ |
| Jobba med oss | /jobba-med-oss/ |
| Bli franchisetagare | /bli-franchisetagare/ |
| Intresseanmälan | /intresse-anmalan/ |
| Kontakt | /kontakt/ |

---

## Vad du letar efter

### Stadssidor — ny franchisetagarstruktur
- [ ] Franchisetagarens namn + "Aktiv sedan X" syns above the fold
- [ ] Personlig berättelse (3 stycken) läsbar och varm i ton
- [ ] Foto-platshållare ser designad ut (kamera-ikon, "Foto uppdateras snart")
- [ ] Telefonnummer direkt klickbart
- [ ] Täckningsområden visas som chips
- [ ] Recensioner refererar rätt stad (ingen korsreferens)
- [ ] Tjänster visas som enkla chips längst ner (ej dominerande)

### Om oss
- [ ] Henriks berättelse från 2008 är med
- [ ] Personlig och autentisk ton (ej marknadsspråk)
- [ ] Stats-band med nyckeltal

### Intresseanmälan
- [ ] Formuläret är visuellt komplett
- [ ] Alla 26 städer i dropdown
- [ ] Tydlig CTA och trust-signaler

---

## Nästa steg efter din granskning
1. **Merge PR #3** (alla sidor ovanfor redo)
2. **Foton på franchisetagarna** — ladda upp i WP Media → koppla till stadssidorna
3. **Blogg-mall** (WAS-46) — 3 SEO-artiklar
4. **Cloudflare tunnel** för externlänk till staging

---

## Gemini-betyg (benchmarkat mot Hemfrid + Helpling)
| Sida | Betyg | Status |
|------|-------|--------|
| Startsida | — | Pending 360° |
| Hemstädning | 8.5/10 | Pending 360° |
| Göteborg (v1) | 9.2/10 | ✅ |
| Stadssidor v3 | Pending | Kör nu |
| Info-sidor | Pending | Kör nu |

*360° benchmark körs automatiskt när alla sidor är byggda*
