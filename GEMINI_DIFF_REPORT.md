# Gemini Visuell Diff — Framer vs WordPress
Datum: 2026-02-25

## Betyg: 3/10

## KRITISKA BRISTER (måste fixas)

1. **Hero-bild saknas** — originalet har bakgrundsbild (snöskottning). WP har vit bakgrund → svagaste above-the-fold
2. **4 sektioner saknas helt:**
   - "Mer än hjälp i hemmet" (med bild inomhus)
   - "Vad kan vi underlätta för dig redan idag" (bild takarbete + nyckeltal)
   - Servicekategorikort med BILDER (inte emoji)
   - Team-sektionen (bild på team + Annika Hoff-citat)
3. **Header**: mörk i WP → ska vara VIT med skugga
4. **Logotyp**: saknar röd prick efter "Seniorbolaget"

## VISUELLA SKILLNADER

- **Typsnitt rubriker**: originalet använder SERIF (Playfair Display eller liknande), WP använder sans-serif (Rubik)
- **Process-steg**: originalet = vit siffra i röd cirkel, WP = röd siffra utan cirkel
- **Röd färg**: original ~#CE2828, WP #b71c1c (lite mörkare/kallare)
- **Bilder saknas** i praktiskt taget ALLA sektioner

## CSS-FIXES (konkreta)

Se full rapport för komplett CSS. Viktigaste:
```css
/* Header vit */
.site-header { background-color: #ffffff; }

/* Process-steg: röd cirkel */
.step-number {
  background: #CE2828; color: #fff;
  border-radius: 50%; width: 70px; height: 70px;
  display: flex; align-items: center; justify-content: center;
}

/* Logotyp röd prick */
.site-title::after {
  content: ''; background: #CE2828;
  border-radius: 50%; width: 8px; height: 8px;
}
```

## ÅTGÄRDSPLAN (prioritetsordning)

1. Ladda ner hero-bild från Framer → lägg till i hero-pattern
2. Bygga saknade sektioner (servicekort med bilder, team)
3. Fixa header → vit bakgrund
4. Lägg till serif-typsnitt för rubriker
5. Fixa process-steg → röda cirklar
