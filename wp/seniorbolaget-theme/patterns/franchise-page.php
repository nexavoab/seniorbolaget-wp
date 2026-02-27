<?php
/**
 * Title: Bli franchisetagare - Infosida
 * Slug: seniorbolaget/franchise-page
 * Categories: seniorbolaget, info
 * Description: Information för potentiella franchisetagare
 * Viewport Width: 1440
 */
?>

<!-- CSS för att dölja dubbel sidtitel + förbättrad styling -->
<!-- wp:html -->
<style>
/* Dölj dubbel sidtitel */
.page-id-98 .wp-block-post-title,
.page-id-98 .entry-header,
body.page-id-98 main > h1.wp-block-post-title {
    display: none !important;
}
/* Förbättrade nyckeltal-badges */
.franchise-stat {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.franchise-stat:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(201,28,34,0.15);
}
</style>
<!-- /wp:html -->

<!-- HERO SECTION — full-width cover med overlay -->
<!-- wp:cover {"url":"https://staging.seniorbolaget.se/wp-content/uploads/2026/02/cta-image.png","id":54,"dimRatio":60,"overlayColor":"dark","minHeight":580,"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px","left":"0","right":"0"}}}} -->
<div class="wp-block-cover alignfull" style="min-height:580px;padding-top:80px;padding-bottom:80px;padding-left:0;padding-right:0;">
	<span aria-hidden="true" class="wp-block-cover__background has-background-dim" style="background:linear-gradient(105deg,rgba(31,41,55,0.75) 0%,rgba(31,41,55,0.45) 100%);"></span>
	<img class="wp-block-cover__image-background wp-image-54" alt="Bli franchisetagare" src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/cta-image.png" data-object-fit="cover" style="object-position:center;"/>
	<div class="wp-block-cover__inner-container" style="max-width:760px;padding:0 clamp(24px,6vw,120px);">

		<!-- wp:html -->
		<div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.3);border-radius:50px;padding:8px 16px;margin-bottom:20px;font-family:Inter,sans-serif;font-size:0.875rem;color:#fff;">
			<span style="color:#facc15;">★★★★★</span>
			<span style="font-weight:600;">15+ framgångsrika franchisetagare i Sverige</span>
		</div>
		<!-- /wp:html -->

		<!-- wp:heading {"level":1,"textColor":"white","style":{"typography":{"fontSize":"clamp(2.5rem,5vw,3.75rem)","lineHeight":"1.1","fontWeight":"700"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
		<h1 class="wp-block-heading has-white-color has-text-color" style="font-size:clamp(2.5rem,5vw,3.75rem);line-height:1.1;font-weight:700;margin-bottom:1rem;text-shadow:0 2px 8px rgba(0,0,0,0.3);">Starta eget med Seniorbolaget — trygghet och frihet</h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"textColor":"white","style":{"typography":{"fontSize":"1.125rem","lineHeight":"1.7"},"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
		<p class="has-white-color has-text-color" style="font-size:1.125rem;line-height:1.7;margin-bottom:1.5rem;opacity:0.9;text-shadow:0 1px 4px rgba(0,0,0,0.3);">Etablerad affärsmodell, starkt varumärke och fullt stöd. Gör skillnad för människor i din region — på dina villkor.</p>
		<!-- /wp:paragraph -->

		<!-- wp:html -->
		<!-- CTA FIRST — ovanför fold -->
		<div style="display:flex;flex-wrap:wrap;align-items:center;gap:16px;margin-bottom:28px;">
			<a href="#franchise-form" style="display:inline-flex;align-items:center;gap:8px;background:#C91C22;color:#fff;font-family:Rubik,sans-serif;font-weight:700;font-size:1.125rem;padding:16px 36px;border-radius:50px;text-decoration:none;box-shadow:0 6px 24px rgba(0,0,0,0.4);">
				Boka kostnadsfritt informationsmöte →
			</a>
		</div>
		<p style="font-size:0.875rem;color:rgba(255,255,255,0.8);margin-bottom:28px;">✓ Kostnadsfritt &nbsp;·&nbsp; ✓ Ingen bindning &nbsp;·&nbsp; ✓ Svar inom 24h</p>
		<!-- Nyckeltal under CTA -->
		<div style="display:flex;flex-wrap:wrap;gap:16px;">
			<div style="background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.25);border-radius:16px;padding:14px 22px;text-align:center;">
				<div style="font-family:Rubik,sans-serif;font-size:1.875rem;font-weight:800;color:#fff;line-height:1;text-shadow:0 2px 4px rgba(0,0,0,0.2);">15+</div>
				<div style="font-size:0.8125rem;color:rgba(255,255,255,0.8);margin-top:4px;">Franchisetagare</div>
			</div>
			<div style="background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.25);border-radius:16px;padding:14px 22px;text-align:center;">
				<div style="font-family:Rubik,sans-serif;font-size:1.875rem;font-weight:800;color:#fff;line-height:1;text-shadow:0 2px 4px rgba(0,0,0,0.2);">26</div>
				<div style="font-size:0.8125rem;color:rgba(255,255,255,0.8);margin-top:4px;">Orter i Sverige</div>
			</div>
			<div style="background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.25);border-radius:16px;padding:14px 22px;text-align:center;">
				<div style="font-family:Rubik,sans-serif;font-size:1.875rem;font-weight:800;color:#fff;line-height:1;text-shadow:0 2px 4px rgba(0,0,0,0.2);">2008</div>
				<div style="font-size:0.8125rem;color:rgba(255,255,255,0.8);margin-top:4px;">Grundat</div>
			</div>
		</div>
		<!-- /wp:html -->

	</div>
</div>
<!-- /wp:cover -->


<!-- INTÄKTSPOTENTIAL SECTION (NYTT) -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#C91C22"},"spacing":{"padding":{"top":"60px","bottom":"60px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="background-color:#C91C22;margin-top:0;padding-top:60px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:60px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700","fontSize":"clamp(1.5rem, 3vw, 2rem)"},"color":{"text":"#ffffff"},"spacing":{"margin":{"bottom":"2rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#ffffff;font-size:clamp(1.5rem, 3vw, 2rem);font-weight:700;margin-bottom:2rem">Uppskattad intäktspotential</h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:900px;margin:0 auto;">
		<div style="background:rgba(255,255,255,0.15);border-radius:16px;padding:28px;text-align:center;">
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:rgba(255,255,255,0.8);margin:0 0 8px;">Med 10 kunder</p>
			<p style="font-family:Rubik,sans-serif;font-size:2rem;font-weight:700;color:#fff;margin:0;">~400 000 kr/år</p>
			<p style="font-family:Inter,sans-serif;font-size:0.8125rem;color:rgba(255,255,255,0.7);margin:8px 0 0;">Första året</p>
		</div>
		<div style="background:rgba(255,255,255,0.25);border-radius:16px;padding:28px;text-align:center;border:2px solid #fff;">
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:rgba(255,255,255,0.9);margin:0 0 8px;">Med 25 kunder</p>
			<p style="font-family:Rubik,sans-serif;font-size:2.25rem;font-weight:700;color:#fff;margin:0;">~850 000 kr/år</p>
			<p style="font-family:Inter,sans-serif;font-size:0.8125rem;color:rgba(255,255,255,0.8);margin:8px 0 0;">Vanligast efter 2 år</p>
		</div>
		<div style="background:rgba(255,255,255,0.15);border-radius:16px;padding:28px;text-align:center;">
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:rgba(255,255,255,0.8);margin:0 0 8px;">Med 50+ kunder</p>
			<p style="font-family:Rubik,sans-serif;font-size:2rem;font-weight:700;color:#fff;margin:0;">1,5+ mkr/år</p>
			<p style="font-family:Inter,sans-serif;font-size:0.8125rem;color:rgba(255,255,255,0.7);margin:8px 0 0;">Etablerad franchise</p>
		</div>
	</div>
	<p style="text-align:center;font-family:Inter,sans-serif;font-size:0.8125rem;color:rgba(255,255,255,0.7);margin:20px 0 0;">* Uppskattade siffror baserade på genomsnittlig omsättning. Faktiska resultat varierar beroende på region och engagemang.</p>
	<style>
	@media (max-width: 768px) {
		div[style*="grid-template-columns:repeat(3,1fr)"] { grid-template-columns: 1fr !important; }
	}
	</style>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- VAD DU FÅR SECTION -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FFFFFF"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="background-color:#FFFFFF;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"3rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-weight:700;margin-bottom:3rem">Vad du får som franchisetagare</h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:1000px;margin:0 auto;">
		<div style="background:#FAFAF8;border-radius:16px;padding:28px;">
			<div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Färdig affärsmodell</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#4B5563;margin:0;line-height:1.6;">Beprövade rutiner för drift och kundhantering som redan visat sig fungera.</p>
		</div>
		<div style="background:#FAFAF8;border-radius:16px;padding:28px;">
			<div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Marknadsföringsstöd</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#4B5563;margin:0;line-height:1.6;">Mallar, kampanjer och material som hjälper dig att snabbt synas lokalt.</p>
		</div>
		<div style="background:#FAFAF8;border-radius:16px;padding:28px;">
			<div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Admin-support</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#4B5563;margin:0;line-height:1.6;">Hjälp med fakturering, bokföring, avtal och rapportering.</p>
		</div>
		<div style="background:#FAFAF8;border-radius:16px;padding:28px;">
			<div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Utbildning</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#4B5563;margin:0;line-height:1.6;">Introduktion och löpande kurser för att säkerställa hög kvalitet.</p>
		</div>
		<div style="background:#FAFAF8;border-radius:16px;padding:28px;">
			<div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Digitala system</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#4B5563;margin:0;line-height:1.6;">Planering, kundregister och uppdragsrapportering i ett smidigt verktyg.</p>
		</div>
		<div style="background:#FAFAF8;border-radius:16px;padding:28px;">
			<div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Personlig mentor</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#4B5563;margin:0;line-height:1.6;">Rådgivning från erfarna franchisetagare och det centrala kontoret.</p>
		</div>
	</div>
	<style>
	@media (max-width: 768px) {
		div[style*="grid-template-columns:repeat(3,1fr)"] { grid-template-columns: repeat(2, 1fr) !important; }
	}
	@media (max-width: 480px) {
		div[style*="grid-template-columns:repeat(3,1fr)"] { grid-template-columns: 1fr !important; }
	}
	</style>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- TESTIMONIALS SECTION (NYTT) -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FAFAF8"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="background-color:#FAFAF8;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-weight:700;margin-bottom:1rem">Våra franchisetagare berättar</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#4B5563"},"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"bottom":"3rem"}}}} -->
	<p class="has-text-align-center" style="color:#4B5563;font-size:1.125rem;margin-bottom:3rem">Hör från dem som redan tagit steget.</p>
	<!-- /wp:paragraph -->

	<!-- wp:html -->
	<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:32px;max-width:900px;margin:0 auto;">
		<div style="background:#fff;border-radius:16px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,0.06);">
			<div style="display:flex;gap:4px;margin-bottom:16px;">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="#facc15"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="#facc15"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="#facc15"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="#facc15"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="#facc15"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
			</div>
			<p style="font-family:Inter,sans-serif;font-size:1rem;color:#4B5563;line-height:1.7;margin:0 0 20px;font-style:italic;">"Efter 30 år i industrin ville jag göra något meningsfullt. Med Seniorbolaget driver jag nu ett företag som verkligen hjälper människor — och jag får bra stöd hela vägen."</p>
			<div style="display:flex;align-items:center;gap:12px;">
				<div style="width:48px;height:48px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;">
					<span style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#fff;">LE</span>
				</div>
				<div>
					<p style="font-family:Rubik,sans-serif;font-size:0.9375rem;font-weight:600;color:#1F2937;margin:0;">Lars E.</p>
					<p style="font-family:Inter,sans-serif;font-size:0.8125rem;color:#6B7280;margin:0;">Franchisetagare sedan 2022, Jönköping</p>
				</div>
			</div>
		</div>
		<div style="background:#fff;border-radius:16px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,0.06);">
			<div style="display:flex;gap:4px;margin-bottom:16px;">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="#facc15"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="#facc15"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="#facc15"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="#facc15"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="#facc15"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
			</div>
			<p style="font-family:Inter,sans-serif;font-size:1rem;color:#4B5563;line-height:1.7;margin:0 0 20px;font-style:italic;">"Jag var skeptisk till franchise först, men supporten från centrala kontoret är fantastisk. Nu omsätter vi över en miljon per år och har 15 seniorer i teamet."</p>
			<div style="display:flex;align-items:center;gap:12px;">
				<div style="width:48px;height:48px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;">
					<span style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#fff;">AK</span>
				</div>
				<div>
					<p style="font-family:Rubik,sans-serif;font-size:0.9375rem;font-weight:600;color:#1F2937;margin:0;">Anna K.</p>
					<p style="font-family:Inter,sans-serif;font-size:0.8125rem;color:#6B7280;margin:0;">Franchisetagare sedan 2021, Göteborg</p>
				</div>
			</div>
		</div>
	</div>
	<style>
	@media (max-width: 768px) {
		div[style*="grid-template-columns:repeat(2,1fr)"] { grid-template-columns: 1fr !important; }
	}
	</style>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- PROCESSEN SECTION (förbättrad) -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FFFFFF"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="background-color:#FFFFFF;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-weight:700;margin-bottom:1rem">Så enkelt kommer du igång</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#4B5563"},"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"bottom":"3rem"}}}} -->
	<p class="has-text-align-center" style="color:#4B5563;font-size:1.125rem;margin-bottom:3rem">Från första kontakt till igång på 2–3 månader.</p>
	<!-- /wp:paragraph -->

	<!-- wp:html -->
	<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;max-width:1000px;margin:0 auto;position:relative;">
		<!-- Linje mellan stegen -->
		<div style="position:absolute;top:32px;left:calc(12.5% + 32px);right:calc(12.5% + 32px);height:2px;background:#e5e7eb;z-index:0;display:none;"></div>
		
		<div style="text-align:center;position:relative;z-index:1;">
			<div style="width:64px;height:64px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
				<span style="font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#fff;">1</span>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Kontakta oss</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#4B5563;margin:0;line-height:1.5;">Kostnadsfritt möte — ingen förpliktelse.</p>
		</div>
		<div style="text-align:center;position:relative;z-index:1;">
			<div style="width:64px;height:64px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
				<span style="font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#fff;">2</span>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Affärsplan</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#4B5563;margin:0;line-height:1.5;">Vi hjälper dig ta fram plan och skriver avtal.</p>
		</div>
		<div style="text-align:center;position:relative;z-index:1;">
			<div style="width:64px;height:64px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
				<span style="font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#fff;">3</span>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Utbildning</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#4B5563;margin:0;line-height:1.5;">Grundlig onboarding och praktisk träning.</p>
		</div>
		<div style="text-align:center;position:relative;z-index:1;">
			<div style="width:64px;height:64px;background:#16a34a;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Öppna!</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#4B5563;margin:0;line-height:1.5;">Du startar din franchise och tar emot kunder.</p>
		</div>
	</div>
	<style>
	@media (max-width: 768px) {
		div[style*="grid-template-columns:repeat(4,1fr)"] { grid-template-columns: repeat(2, 1fr) !important; }
	}
	</style>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- FÖR VEMS SKULL SECTION -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FAFAF8"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="background-color:#FAFAF8;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-weight:700;margin-bottom:1rem">Är det rätt för dig?</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#4B5563"},"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"bottom":"3rem"}}}} -->
	<p class="has-text-align-center" style="color:#4B5563;font-size:1.125rem;margin-bottom:3rem">Att vara franchisetagare hos Seniorbolaget handlar inte bara om att driva företag – det handlar om att göra skillnad i samhället.</p>
	<!-- /wp:paragraph -->

	<!-- wp:html -->
	<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:900px;margin:0 auto;">
		<div style="background:#fff;border-radius:16px;padding:28px;text-align:center;box-shadow:0 2px 16px rgba(0,0,0,0.06);">
			<div style="width:64px;height:64px;background:#FFF4F2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Ledarerfarenhet</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#4B5563;margin:0;line-height:1.5;">Du som har erfarenhet av att leda och organisera.</p>
		</div>
		<div style="background:#fff;border-radius:16px;padding:28px;text-align:center;box-shadow:0 2px 16px rgba(0,0,0,0.06);">
			<div style="width:64px;height:64px;background:#FFF4F2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Göra skillnad</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#4B5563;margin:0;line-height:1.5;">Du som vill bidra till samhället lokalt.</p>
		</div>
		<div style="background:#fff;border-radius:16px;padding:28px;text-align:center;box-shadow:0 2px 16px rgba(0,0,0,0.06);">
			<div style="width:64px;height:64px;background:#FFF4F2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#1F2937;margin:0 0 8px;">Frihet & stabilitet</h3>
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#4B5563;margin:0;line-height:1.5;">Du som vill ha stabil inkomst med flexibilitet.</p>
		</div>
	</div>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- FAQ SECTION -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FFFFFF"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group alignfull" style="background-color:#FFFFFF;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"3rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-weight:700;margin-bottom:3rem">Vanliga frågor</h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div style="display:flex;flex-direction:column;gap:16px;">
		<details style="background:#FAFAF8;border-radius:12px;padding:20px 24px;cursor:pointer;">
			<summary style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#1F2937;list-style:none;display:flex;justify-content:space-between;align-items:center;">
				Vad kostar det att bli franchisetagare?
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
			</summary>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#4B5563;margin:16px 0 0;line-height:1.6;">Kostnaden varierar beroende på region och omfattning. Kontakta oss för ett kostnadsfritt informationsmöte där vi går igenom allt i detalj.</p>
		</details>
		<details style="background:#FAFAF8;border-radius:12px;padding:20px 24px;cursor:pointer;">
			<summary style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#1F2937;list-style:none;display:flex;justify-content:space-between;align-items:center;">
				Behöver jag branscherfarenhet?
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
			</summary>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#4B5563;margin:16px 0 0;line-height:1.6;">Nej, du behöver inte ha branscherfarenhet. Vi ger dig all utbildning och support du behöver. Det viktigaste är att du har ledarerfarenhet och vill göra skillnad.</p>
		</details>
		<details style="background:#FAFAF8;border-radius:12px;padding:20px 24px;cursor:pointer;">
			<summary style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#1F2937;list-style:none;display:flex;justify-content:space-between;align-items:center;">
				Hur stor är min region?
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
			</summary>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#4B5563;margin:16px 0 0;line-height:1.6;">Regionens storlek bestäms i dialog med dig och baseras på befolkningsunderlag och marknadspotential. Du får exklusiv rätt till ditt område.</p>
		</details>
		<details style="background:#FAFAF8;border-radius:12px;padding:20px 24px;cursor:pointer;">
			<summary style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;color:#1F2937;list-style:none;display:flex;justify-content:space-between;align-items:center;">
				Hur snabbt kan jag starta?
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
			</summary>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#4B5563;margin:16px 0 0;line-height:1.6;">Från första kontakt till igång tar det vanligtvis 2-3 månader, beroende på utbildning och förberedelser.</p>
		</details>
	</div>
	<style>
	details summary::-webkit-details-marker { display: none; }
	details[open] summary svg { transform: rotate(180deg); }
	</style>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- VD-CITAT SECTION -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#1F2937"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained","contentSize":"800px"}} -->
<div class="wp-block-group alignfull" style="background-color:#1F2937;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:html -->
	<div style="display:flex;align-items:center;gap:32px;flex-wrap:wrap;justify-content:center;">
		<img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/henrik_ceo.jpg" alt="Henrik Bergeld VD Seniorbolaget" style="width:120px;height:150px;object-fit:cover;object-position:center top;border-radius:16px;flex-shrink:0;" loading="lazy"/>
		<div style="flex:1;min-width:280px;">
			<blockquote style="margin:0;padding:0;">
				<p style="font-family:Inter,sans-serif;font-size:1.375rem;font-style:italic;color:#fff;line-height:1.6;margin:0 0 16px;">"Som franchisetagare hos Seniorbolaget får du chansen att driva eget, men aldrig ensam. Gör skillnad varje dag."</p>
				<cite style="font-family:Rubik,sans-serif;font-size:1rem;color:rgba(255,255,255,0.8);font-style:normal;font-weight:600;">— Henrik Bergeld, VD Seniorbolaget</cite>
			</blockquote>
		</div>
	</div>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- CTA SECTION -->
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"100px","bottom":"100px"}},"color":{"background":"#C91C22"}},"layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#C91C22;padding-top:100px;padding-bottom:100px;">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"clamp(1.75rem,4vw,2.5rem)","fontWeight":"700"},"color":{"text":"#ffffff"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#fff;font-size:clamp(1.75rem,4vw,2.5rem);font-weight:700;margin-bottom:1rem;">Ta första steget — kostnadsfritt informationsmöte</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","style":{"color":{"text":"rgba(255,255,255,0.9)"},"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
	<p class="has-text-align-center" style="color:rgba(255,255,255,0.9);font-size:1.125rem;margin-bottom:1rem;">💰 Låg startinvestering · Diskutera villkoren i ett kostnadsfritt möte</p>
	<!-- /wp:paragraph -->

	<!-- wp:paragraph {"align":"center","style":{"color":{"text":"rgba(255,255,255,0.9)"},"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"bottom":"2.5rem"}}}} -->
	<p class="has-text-align-center" style="color:rgba(255,255,255,0.9);font-size:1.125rem;margin-bottom:2.5rem;">Fyll i intresseanmälan → Vi ringer inom 24h → Kostnadsfritt möte</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"vit","textColor":"rod","style":{"border":{"radius":"50px"},"spacing":{"padding":{"top":"1rem","bottom":"1rem","left":"2.5rem","right":"2.5rem"}},"typography":{"fontSize":"1.125rem","fontWeight":"700"}}} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-rod-color has-vit-background-color has-text-color has-background wp-element-button" href="#franchise-form" id="franchise-form" style="border-radius:50px;padding:1rem 2.5rem;font-size:1.125rem;font-weight:700;">Boka informationsmöte</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

</div>
<!-- /wp:group -->

<!-- STICKY CTA-KNAPP -->
<!-- wp:html -->
<div style="position:fixed;bottom:90px;right:28px;z-index:10001;">
	<a href="#franchise-form" style="display:inline-flex;align-items:center;gap:8px;background:#C91C22;color:#fff;font-family:Rubik,sans-serif;font-weight:700;font-size:1rem;padding:14px 24px;border-radius:50px;text-decoration:none;box-shadow:0 4px 20px rgba(201,28,34,0.4);transition:transform 0.2s,box-shadow 0.2s;" onmouseover="this.style.transform='scale(1.05)';this.style.boxShadow='0 6px 24px rgba(201,28,34,0.5)';" onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 20px rgba(201,28,34,0.4)';">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
		Boka informationsmöte
	</a>
</div>
<style>
@media (max-width: 640px) {
	div[style*="position:fixed;bottom:20px;right:20px"] {
		left: 20px;
		right: 20px;
		text-align: center;
	}
	div[style*="position:fixed;bottom:20px;right:20px"] a {
		width: 100%;
		justify-content: center;
	}
}
</style>
<!-- /wp:html -->
