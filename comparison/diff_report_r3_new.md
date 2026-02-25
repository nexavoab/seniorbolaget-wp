🔍 Kör diff med gemini-3.1-pro-preview...
✅ Rapport sparad: comparison/diff_report_index.md (modell: gemini-3.1-pro-preview)
Här är en systematisk analys och kirurgisk uppgradering av WP-implementationen. Huvudfokus ligger på att eliminera element som skadar tryggheten (som emojis) och återinföra den professionella, varumärkesbyggande designen från Framer-originalet.

### 1. Hero (`hero.php`)
**Problem:** Användningen av emojis (📞, ⭐, 📍) i trust-badges förstör det seriösa intrycket för en äldre, skeptisk målgrupp. Emojis signalerar oseriös massproduktion snarare än ett pålitligt hemtjänstföretag.
**Fil:** `wp/seniorbolaget-theme/patterns/hero.php`
**Hitta:**
```html
			<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|lg"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left","gap":"var:preset|spacing|lg"}} -->
			<div class="wp-block-group" style="margin-top:3rem;display:flex;flex-wrap:wrap;justify-content:flex-start;gap:2rem">
				<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
				<p style="font-weight:600;font-size:0.9rem">📞 010-175 19 00</p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
				<p style="font-weight:600;font-size:0.9rem">⭐ 98% nöjda kunder</p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
				<p style="font-weight:600;font-size:0.9rem">📍 20+ orter i Sverige</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"13px"},"color":{"text":"#6B7280"}}} -->
			<p style="text-align:center;font-size:13px;color:#6B7280;margin-top:8px;">
			⭐ <strong>4.8/5</strong> baserat på 500+ omdömen &nbsp;•&nbsp; 
			<span style="color:var(--wp--preset--color--rod);font-weight:600;">Reco.se Rekommenderad</span>
			</p>
			<!-- /wp:paragraph -->
```
**Ersätt med:**
```html
			<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|lg"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left","gap":"var:preset|spacing|lg"}} -->
			<div class="wp-block-group" style="margin-top:3rem;display:flex;flex-wrap:wrap;justify-content:flex-start;gap:2rem">
				<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"8px"}}} -->
				<div class="wp-block-group">
					<!-- wp:html -->
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--wp--preset--color--rod)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
					<!-- /wp:html -->
					<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
					<p style="font-weight:600;font-size:0.9rem;margin:0;">010-175 19 00</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"8px"}}} -->
				<div class="wp-block-group">
					<!-- wp:html -->
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--wp--preset--color--rod)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
					<!-- /wp:html -->
					<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
					<p style="font-weight:600;font-size:0.9rem;margin:0;">98% nöjda kunder</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"8px"}}} -->
				<div class="wp-block-group">
					<!-- wp:html -->
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--wp--preset--color--rod)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
					<!-- /wp:html -->
					<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
					<p style="font-weight:600;font-size:0.9rem;margin:0;">20+ orter i Sverige</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->

			<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"13px"},"color":{"text":"#6B7280"}}} -->
			<p style="text-align:center;font-size:13px;color:#6B7280;margin-top:8px;">
			<strong>4.8/5</strong> baserat på 500+ omdömen &nbsp;•&nbsp; 
			<span style="color:var(--wp--preset--color--rod);font-weight:600;">Reco.se Rekommenderad</span>
			</p>
			<!-- /wp:paragraph -->
```
**Motivering:** Ren, strukturerad typografi med konsekventa vectorikoner signalerar trygghet och professionalism, långt bort från spam-känslan emojis ger.

---

### 2. Tjänstegrid (`services-grid.php`)
**Problem:** Återigen användning av emojis (🧹, 🌿, 🖌️, 🔨). Detta sänker premiumkänslan markant och gör att grid-sektionen ser billig ut.
**Fil:** `wp/seniorbolaget-theme/patterns/services-grid.php`
**Hitta (Hemstäd):**
```html
				<!-- wp:paragraph {"style":{"typography":{"fontSize":"48px"},"spacing":{"margin":{"bottom":"16px"}}}} -->
				<p style="font-size:48px;margin-bottom:16px">🧹</p>
				<!-- /wp:paragraph -->
```
**Ersätt med:**
```html
				<!-- wp:html -->
				<div style="margin-bottom:16px;color:var(--wp--preset--color--rod);">
					<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
				</div>
				<!-- /wp:html -->
```

**Hitta (Trädgård):**
```html
				<!-- wp:paragraph {"style":{"typography":{"fontSize":"48px"},"spacing":{"margin":{"bottom":"16px"}}}} -->
				<p style="font-size:48px;margin-bottom:16px">🌿</p>
				<!-- /wp:paragraph -->
```
**Ersätt med:**
```html
				<!-- wp:html -->
				<div style="margin-bottom:16px;color:var(--wp--preset--color--rod);">
					<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22v-7l-3-3"></path><path d="M12 15l3-3"></path><path d="M19 4c-2-1-4-1-6 1S9 9 9 11c0 2 1 3 2 4s3 2 5 2 4-1 5-3-1-4-3-5-4-5z"></path><path d="M5 4c2-1 4-1 6 1s4 3 4 5c0 2-1 3-2 4s-3 2-5 2-4-1-5-3 1-4 3-5 4-5z"></path></svg>
				</div>
				<!-- /wp:html -->
```

**Hitta (Målning & tapetsering):**
```html
				<!-- wp:paragraph {"style":{"typography":{"fontSize":"48px"},"spacing":{"margin":{"bottom":"16px"}}}} -->
				<p style="font-size:48px;margin-bottom:16px">🖌️</p>
				<!-- /wp:paragraph -->
```
**Ersätt med:**
```html
				<!-- wp:html -->
				<div style="margin-bottom:16px;color:var(--wp--preset--color--rod);">
					<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>
				</div>
				<!-- /wp:html -->
```

**Hitta (Snickeri):**
```html
				<!-- wp:paragraph {"style":{"typography":{"fontSize":"48px"},"spacing":{"margin":{"bottom":"16px"}}}} -->
				<p style="font-size:48px;margin-bottom:16px">🔨</p>
				<!-- /wp:paragraph -->
```
**Ersätt med:**
```html
				<!-- wp:html -->
				<div style="margin-bottom:16px;color:var(--wp--preset--color--rod);">
					<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
				</div>
				<!-- /wp:html -->
```
**Motivering:** Ersätter lekfullhet med auktoritet. Ikonerna är nu i varumärkets färg och skapar en sammanhållen, modern grid.

---

### 3. Testimonials Typografi och Stjärnor (`testimonials.php`)
**Problem:** Emoji-stjärnor minskar trovärdigheten. Namnen saknar varumärkets röda signaturfärg som fanns i Framer-originalet, vilket gör hierarkin platt.
**Fil:** `wp/seniorbolaget-theme/patterns/testimonials.php`

**Hitta (*Duplicera bytet för alla 3 kundkort i filen*):**
```html
				<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.5rem"},"color":{"text":"var:preset|color|rod"},"spacing":{"margin":{"bottom":"16px"}}}} -->
				<p class="has-rod-color has-text-color" style="font-size:1.5rem;margin-bottom:16px">⭐⭐⭐⭐⭐</p>
				<!-- /wp:paragraph -->
```
**Ersätt med:**
```html
				<!-- wp:html -->
				<div style="color:var(--wp--preset--color--rod);margin-bottom:16px;display:flex;gap:4px;">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
				</div>
				<!-- /wp:html -->
```

**Hitta (Kund 1):**
```html
					<!-- wp:paragraph {"style":{"typography":{"fontWeight":"700","fontSize":"0.9rem"},"color":{"text":"#1F2937"},"spacing":{"margin":{"left":"12px"}}}} -->
					<p style="color:#1F2937;font-weight:700;font-size:0.9rem;margin-left:12px">Maria, 38 år — Malmö (fastighetsbolag)</p>
					<!-- /wp:paragraph -->
```
**Ersätt med:**
```html
					<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"},"style":{"spacing":{"blockGap":"2px","margin":{"left":"12px"}}}} -->
					<div class="wp-block-group" style="margin-left:12px">
						<!-- wp:paragraph {"style":{"typography":{"fontWeight":"700","fontSize":"0.95rem"},"color":{"text":"var:preset|color|rod"}}} -->
						<p class="has-rod-color has-text-color" style="font-weight:700;font-size:0.95rem;margin:0;">Maria, 38 år</p>
						<!-- /wp:paragraph -->
						<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.85rem"},"color":{"text":"#6B7280"}}} -->
						<p style="color:#6B7280;font-size:0.85rem;margin:0;">Malmö (fastighetsbolag)</p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->
```
*(Gör motsvarande uppdelning av namn och ort för "Björn, 44 år" och "Anna, 52 år" för konsekvent layout).*

**Motivering:** Att splitta upp namn och titel/ort på två rader förbättrar läsbarheten dramatiskt. Den röda färgen återknyter till originalets visuella hierarki.

---

### 4. Global CSS (`style.css`)
**Problem:** Box-shadow på korten (`0 4px 24px -4px`) känns lite "smutsig" och gör att korten ser tunga ut. Originalet hade en mycket renare estetik.
**Fil:** `wp/seniorbolaget-theme/style.css`
**Hitta:**
```css
/* ===== PREMIUM BOX SHADOWS ===== */
.wp-block-group.testimonial-card,
.wp-block-group.service-card {
    box-shadow: 0 4px 24px -4px rgba(0,0,0,0.06) !important;
    border: none !important;
}
```
**Ersätt med:**
```css
/* ===== PREMIUM BOX SHADOWS ===== */
.wp-block-group.testimonial-card,
.wp-block-group.service-card {
    box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05) !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
}
```
**Motivering:** En tunn, knappt synlig border tillsammans med en mjukare och djupare drop-shadow lyfter designen till en modern app-känsla (vilket skapar undermedveten trygghet).

---

## BETYG: 8.5/10

WP-implementationen var strukturellt fantastisk och layouten (särskilt den nya Hero-sektionen och Bento-griden för tjänster) överträffar originalets röriga struktur. De ovanstående patcharna tar designen från "WP block theme" till en "modern premium app".

**Topp 3 prioriteringar för nästa runda:**
1. **Navigationshuvud:** Inkludera telefonnumret direkt i headern så det alltid är synligt (vitalt för äldre).
2. **Hero Image:** Säkerställ att bilden (`hero.jpg`) är högupplöst och maskad med mjuk border-radius (vilket CSS:en stöder) så den inte känns instoppad i en låda.
3. **Fotnot/Footer:** Lägg till "Vi gör det direkt" emblemet från Framer-originalet i footern; grafiska badges stänger konverteringen då de inger auktoritet.

**Vad är bra och ska behållas:**
- Den responsiva mobila "Floating CTA":n är ett genidrag för konvertering.
- Den tvåspaltiga Hero-lösningen (till skillnad från originalets centrerade rörighet) är överlägsen för att snabbt guida ögat.
- Stats-bandet (2000+ seniorer) ger utmärkt social proof precis innan sista säljpitch.

