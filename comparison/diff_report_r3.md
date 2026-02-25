Loaded cached credentials.
Här är en exakt och teknisk visuell diff-analys mellan Originalet (Framer) och WP Staging, fokuserad på CRO och designprecision.

## 1. KRITISKA KONVERTERINGSSKILLNADER

*   **Avsaknad av "Human Face" (Trust-killer):** I hemtjänstbranschen är personligt förtroende allt. Originalet möter besökaren med en varm, leende senior ("hero image") och avslutar starkt med en "superhjälte"-senior i botten-CTA:n. WP Staging saknar helt bilder på människor, vilket gör sidan kall och drastiskt sänker den emotionella konverteringsgraden.
*   **Strukturell CRO-förbättring i WP:** WP Staging har lagt till extremt starka konverteringselement som Originalet saknade: "Trust bar" (telefon, 98% nöjda kunder), en tydlig tjänstegrid (ikoner + Läs mer), en trestegsprocess ("Så enkelt fungerar det") samt trust-stjärnor i recensionerna. Detta är en massiv arkitektonisk uppgradering för leads-generering.
*   **Hero Copy & Kontrast:** Originalet ("Vi gör vardagen lite enklare") är emotionellt drivet, med röd rubrik och röd ingress på vit bakgrund. WP Staging ("Hemtjänster av erfarna seniorer...") är extremt SEO/CRO-optimerat, men den grå ingressen mot den ljusrosa bakgrunden ger sämre läsbarhet och kontrast jämfört med Originalets röda text.
*   **Botten-CTA (Design vs Fullbredd):** Originalet ramar in avslutet i en tydlig, rundad "box" som drar blicken till sig (tillsammans med bilden). WP Staging använder ett fullbreddsband som känns generiskt och platt, vilket minskar sannolikheten för klick ("Få tiden tillbaka, vi fixar det!").

## 2. EXAKTA VISUELLA SKILLNADER (Element: Original=[värde] → WP=[värde], hex, px)

*   **Header Logotyp:** Original = Grafisk bild ("Seniorbolaget - för alla åldrar -") → WP = Text (`font-weight: 700; color: #000000`).
*   **Header Navigation:** Original = Platta länkar, inkluderar "Jobba med oss" → WP = Dropdowns (pilar synliga på Privat/Företag), saknar "Jobba med oss".
*   **Header CTA:** Original = "Kontakta oss" → WP = "Boka hjälp". Båda har röd outline (`border: 1px solid var(--wp--preset--color--rod); border-radius: 50px`).
*   **Hero Bakgrund:** Original = Vit (`#FFFFFF`) → WP = Ljusrosa/beige (`var(--wp--preset--color--ljus-rosa-beige)`).
*   **Hero Ingress (Textfärg):** Original = Röd → WP = Grå (`var(--wp--preset--color--textgra)`).
*   **Testimonials (Kortdesign):** Original = Rent textkort, namn i röd text, ort i svart under → WP = Tillagda 5 stjärnor (`#EAB308`), kursiv recensionstext, namn och ort på samma rad (Röd text).
*   **Botten CTA (Rubrik):** Original = "...vi fixar **resten**" → WP = "...vi fixar **det!**".
*   **Botten CTA (Layout):** Original = Inramad box (`border-radius: ~24px`), grafiskt mönster i bakgrunden → WP = Fullbreddssektion (`width: 100%; border-radius: 0px`), enfärgad grå/blå.
*   **Footer Logotyp & Badge:** Original = Vit bildlogga + "VI GÖR DET DIREKT" bild → WP = Plain text "Seniorbolaget".

## 3. SAKNADE ELEMENT

*   **Grafisk Varumärkeslogotyp:** Både i header och footer.
*   **Alla fotografier på människor:** Den leende kvinnan med dammsugaren (Hero), snöskottningsbilden, och superhjältekvinnan i den nedre CTA-sektionen.
*   **"VI GÖR DET DIREKT"-stämpeln:** Saknas helt i WP-footern.
*   **Koncentriskt grafiskt mönster:** Saknas i bakgrunden på den nedre CTA-sektionen.
*   **Sociala Medier-ikoner:** WP har enbart en ren textlänk ("Instagram →") i footern, originalet har grafiska ikoner (FB, IG).
*   **Menyvalet "Jobba med oss":** Saknas i WP Stagings header-navigation.

## 4. KONKRETA FIXES (CSS + theme.json)

För att snabbt integrera Originalets varumärkeskänsla i WP Stagings starka struktur:

**1. Återställ logotyper i Site Editor:**
*   Byt ut `core/site-title` mot `core/site-logo` i både Header och Footer. Ladda upp original-SVG/PNG.

**2. CTA Band Layout (Få tiden tillbaka):**
Uppdatera mönstret för `cta-band` så att det blir en rundad box med bild som överlappar:
```html
<!-- theme.json: Lägg till stöd för att begränsa bredd och rundade hörn på Group-block -->
<!-- I editorn/koden för CTA-blocket: -->
<div class="wp-block-group alignwide" style="background-color:#4A5568; border-radius:24px; overflow:hidden; position:relative;">
  <div class="wp-block-columns">
    <!-- Vänster: Text + Knapp -->
    <!-- Höger: Bild på superhjältekvinnan med absolut position/negativ margin för att poppa ut -->
  </div>
</div>
```

**3. Hero Image Injection:**
Uppdatera `hero.php` till en tvåkolumnslayout (50/50) för desktop.
```html
<div class="wp-block-columns alignwide">
  <div class="wp-block-column" style="flex-basis:50%">
    <!-- Nuvarande textinnehåll (H1, p, buttons) -->
  </div>
  <div class="wp-block-column" style="flex-basis:50%">
    <!-- core/image med den leende senioren, eventuellt med CSS mask-image för organisk form -->
    <img src="path-to-smiling-senior.jpg" style="border-radius:24px;" alt="Glad senior som städar" />
  </div>
</div>
```

**4. Footer Socials & Badge:**
Lägg till ett `core/image` block bredvid logotypen i footern för "VI GÖR DET DIREKT"-stämpeln och ersätt textlänken med `core/social-links` för att få tillbaka rätt ikoner.

## 5. BETYG OCH NÄSTA STEG

**Betyg: 7/10**
Rent strukturellt, informationsmässigt och ur ett renodlat CRO-perspektiv är WP Staging faktiskt *bättre* än originalet (tjänstekorten, processen, stjärnorna och stats-bandet är lysande tillägg för max leads). Men det faller platt på avsaknaden av visuell varumärkesidentitet och mänsklig värme.

**3 saker för nästa steg (för att nå 10/10):**

1.  **Injicera Mänskligt Förtroende (Kritiskt):** Lägg omedelbart in fotografierna på seniorerna (Hero och Botten-CTA). Du säljer trygghet i hemmet – besökarna *måste* se vem som kommer hem till dem.
2.  **Rätta till Varumärkes-DNA:** Byt ut alla textloggor mot de riktiga grafiska bildlogotyperna, och säkerställ att "VI GÖR DET DIREKT"-stämpeln implementeras i footern.
3.  **Skulptera CTA-sektionen:** Designa om botten-CTA:n från ett platt fullbreddsband till Originalets avgränsade, rundade "box" med grafiskt mönster. En isolerad, utmärkande form drar ögat mycket mer effektivt inför det slutgiltiga konverteringsbeslutet.
