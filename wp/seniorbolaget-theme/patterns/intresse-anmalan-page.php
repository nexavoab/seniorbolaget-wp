<?php
/**
 * Title: Intresseanmälan - Konverteringssida
 * Slug: seniorbolaget/intresse-anmalan-page
 * Categories: seniorbolaget, info
 * Description: Huvudsida för att skicka förfrågan om tjänster
 * Viewport Width: 1440
 */
?>

<!-- HERO SECTION (kompakt) -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FFF4F2"},"spacing":{"padding":{"top":"60px","bottom":"60px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group alignfull" style="background-color:#FFF4F2;margin-top:0;padding-top:60px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:60px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontWeight":"700","lineHeight":"1.1","fontSize":"clamp(1.75rem, 4vw, 2.5rem)"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
	<h1 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.75rem, 4vw, 2.5rem);font-weight:700;line-height:1.1;margin-bottom:1rem">Berätta vad du behöver hjälp med</h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.125rem","lineHeight":"1.6"},"color":{"text":"#4B5563"},"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
	<p class="has-text-align-center" style="color:#4B5563;font-size:1.125rem;line-height:1.6;margin-bottom:1.5rem">Våra seniorer finns i hela Sverige, redo att hjälpa dig.</p>
	<!-- /wp:paragraph -->

	<!-- wp:html -->
	<div style="display:flex;justify-content:center;gap:24px;flex-wrap:wrap;font-family:Inter,sans-serif;font-size:0.9375rem;color:#1F2937;">
		<span style="display:flex;align-items:center;gap:6px;">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
			Svar inom 24h
		</span>
		<span style="display:flex;align-items:center;gap:6px;">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
			Ingen bindningstid
		</span>
		<span style="display:flex;align-items:center;gap:6px;">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
			RUT/ROT direkt
		</span>
	</div>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- FORMULÄR-SEKTION -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FFFFFF"},"spacing":{"padding":{"top":"60px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group alignfull" style="background-color:#FFFFFF;margin-top:0;padding-top:60px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:html -->
	<?php
	/**
	 * FEATURE FLAG: Formuläret är UI-only.
	 * Backend-integration krävs för att faktiskt skicka förfrågningar.
	 * Implementera via Contact Form 7, Gravity Forms eller custom REST endpoint.
	 */
	?>
	<form class="seniorbolaget-form" style="display:flex;flex-direction:column;gap:24px;" onsubmit="event.preventDefault(); alert('Formuläret kräver backend-integration för att fungera.');">
		
		<!-- Välj stad -->
		<div style="display:flex;flex-direction:column;gap:8px;">
			<label for="stad" style="font-family:Rubik,sans-serif;font-size:0.9375rem;font-weight:600;color:#1F2937;">Var vill du ha hjälp?</label>
			<select id="stad" name="stad" required style="padding:14px 18px;border:2px solid #e5e7eb;border-radius:50px;font-size:1rem;font-family:Inter,sans-serif;color:#1F2937;background:#fff;cursor:pointer;appearance:none;background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%236B7280%22 stroke-width=%222%22><polyline points=%226 9 12 15 18 9%22/></svg>');background-repeat:no-repeat;background-position:right 16px center;">
				<option value="">Välj stad...</option>
				<option value="boras">Borås</option>
				<option value="eskilstuna">Eskilstuna</option>
				<option value="falkenberg">Falkenberg</option>
				<option value="goteborg">Göteborg</option>
				<option value="halmstad">Halmstad</option>
				<option value="helsingborg">Helsingborg</option>
				<option value="jonkoping">Jönköping</option>
				<option value="karlstad">Karlstad</option>
				<option value="kristianstad">Kristianstad</option>
				<option value="kungsbacka">Kungsbacka</option>
				<option value="kungalv">Kungälv</option>
				<option value="laholm-bastad">Laholm / Båstad</option>
				<option value="landskrona">Landskrona</option>
				<option value="lerum-partille">Lerum / Partille</option>
				<option value="nassjo">Nässjö</option>
				<option value="skovde">Skövde</option>
				<option value="stenungsund">Stenungsund</option>
				<option value="sundsvall">Sundsvall</option>
				<option value="torsby">Torsby</option>
				<option value="trelleborg">Trelleborg</option>
				<option value="trollhattan">Trollhättan</option>
				<option value="ulricehamn">Ulricehamn</option>
				<option value="varberg">Varberg</option>
				<option value="amal">Åmål</option>
				<option value="orebro">Örebro</option>
			</select>
		</div>
		
		<!-- Välj tjänst -->
		<div style="display:flex;flex-direction:column;gap:8px;">
			<label for="tjanst" style="font-family:Rubik,sans-serif;font-size:0.9375rem;font-weight:600;color:#1F2937;">Vad vill du ha hjälp med?</label>
			<select id="tjanst" name="tjanst" required style="padding:14px 18px;border:2px solid #e5e7eb;border-radius:50px;font-size:1rem;font-family:Inter,sans-serif;color:#1F2937;background:#fff;cursor:pointer;appearance:none;background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%236B7280%22 stroke-width=%222%22><polyline points=%226 9 12 15 18 9%22/></svg>');background-repeat:no-repeat;background-position:right 16px center;">
				<option value="">Välj tjänst...</option>
				<option value="hemstadning">Hemstädning</option>
				<option value="tradgard">Trädgård</option>
				<option value="malning">Målning / tapetsering</option>
				<option value="snickeri">Snickeri</option>
				<option value="ovrigt">Övrigt</option>
			</select>
		</div>
		
		<!-- Namn -->
		<div style="display:flex;flex-direction:column;gap:8px;">
			<label for="namn" style="font-family:Rubik,sans-serif;font-size:0.9375rem;font-weight:600;color:#1F2937;">Ditt namn</label>
			<input type="text" id="namn" name="namn" required placeholder="För- och efternamn" style="padding:14px 18px;border:2px solid #e5e7eb;border-radius:50px;font-size:1rem;font-family:Inter,sans-serif;color:#1F2937;">
		</div>
		
		<!-- Telefon -->
		<div style="display:flex;flex-direction:column;gap:8px;">
			<label for="telefon" style="font-family:Rubik,sans-serif;font-size:0.9375rem;font-weight:600;color:#1F2937;">Telefonnummer</label>
			<input type="tel" id="telefon" name="telefon" required placeholder="070-123 45 67" style="padding:14px 18px;border:2px solid #e5e7eb;border-radius:50px;font-size:1rem;font-family:Inter,sans-serif;color:#1F2937;">
		</div>
		
		<!-- E-post -->
		<div style="display:flex;flex-direction:column;gap:8px;">
			<label for="epost" style="font-family:Rubik,sans-serif;font-size:0.9375rem;font-weight:600;color:#1F2937;">E-post</label>
			<input type="email" id="epost" name="epost" required placeholder="din@email.se" style="padding:14px 18px;border:2px solid #e5e7eb;border-radius:50px;font-size:1rem;font-family:Inter,sans-serif;color:#1F2937;">
		</div>
		
		<!-- Meddelande -->
		<div style="display:flex;flex-direction:column;gap:8px;">
			<label for="meddelande" style="font-family:Rubik,sans-serif;font-size:0.9375rem;font-weight:600;color:#1F2937;">Meddelande <span style="font-weight:400;color:#6B7280;">(valfritt)</span></label>
			<textarea id="meddelande" name="meddelande" rows="4" placeholder="Beskriv gärna vad du behöver hjälp med..." style="padding:14px 18px;border:2px solid #e5e7eb;border-radius:20px;font-size:1rem;font-family:Inter,sans-serif;color:#1F2937;resize:vertical;"></textarea>
		</div>
		
		<!-- Submit -->
		<button type="submit" style="padding:16px 32px;background:#C91C22;color:#fff;border:none;border-radius:50px;font-size:1.125rem;font-weight:700;font-family:Rubik,sans-serif;cursor:pointer;margin-top:8px;transition:background 0.2s;">
			Skicka förfrågan
		</button>
		
		<p style="text-align:center;font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;">
			Vi svarar alltid inom 24 timmar.
		</p>
		
	</form>
	
	<style>
	.seniorbolaget-form input:focus,
	.seniorbolaget-form select:focus,
	.seniorbolaget-form textarea:focus {
		outline: none;
		border-color: #C91C22;
	}
	.seniorbolaget-form button:hover {
		background: #a01519;
	}
	</style>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- TRUST SEKTION -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FAFAF8"},"spacing":{"padding":{"top":"60px","bottom":"60px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="background-color:#FAFAF8;margin-top:0;padding-top:60px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:60px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:html -->
	<div style="display:flex;justify-content:center;gap:48px;flex-wrap:wrap;max-width:900px;margin:0 auto;">
		<div style="text-align:center;">
			<div style="display:flex;align-items:center;justify-content:center;gap:4px;margin-bottom:8px;">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
				<span style="font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#1F2937;">4,8/5</span>
			</div>
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;">Snittbetyg</p>
		</div>
		<div style="text-align:center;">
			<p style="font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#1F2937;margin:0 0 8px;">500+</p>
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;">Nöjda kunder</p>
		</div>
		<div style="text-align:center;">
			<div style="display:flex;align-items:center;justify-content:center;gap:6px;margin-bottom:8px;">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
				<span style="font-family:Rubik,sans-serif;font-size:1rem;font-weight:700;color:#1F2937;">Reco.se</span>
			</div>
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;">Rekommenderad</p>
		</div>
		<div style="text-align:center;">
			<p style="font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#1F2937;margin:0 0 8px;">26</p>
			<p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;">Städer i Sverige</p>
		</div>
	</div>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- KONTAKT-ALTERNATIV -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FFFFFF"},"spacing":{"padding":{"top":"60px","bottom":"60px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group alignfull" style="background-color:#FFFFFF;margin-top:0;padding-top:60px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:60px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontWeight":"600","fontSize":"1.25rem"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
	<h3 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:1.25rem;font-weight:600;margin-bottom:1.5rem">Föredrar du att ringa eller mejla?</h3>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
		<a href="tel:0101751900" style="display:inline-flex;align-items:center;gap:10px;background:#C91C22;color:#fff;border-radius:50px;padding:14px 28px;font-weight:600;font-size:1rem;font-family:Rubik,sans-serif;text-decoration:none;">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.68A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/></svg>
			010-175 19 00
		</a>
		<a href="mailto:info@seniorbolaget.se" style="display:inline-flex;align-items:center;gap:10px;background:#fff;color:#C91C22;border:2px solid #C91C22;border-radius:50px;padding:14px 28px;font-weight:600;font-size:1rem;font-family:Rubik,sans-serif;text-decoration:none;">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
			info@seniorbolaget.se
		</a>
	</div>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->
