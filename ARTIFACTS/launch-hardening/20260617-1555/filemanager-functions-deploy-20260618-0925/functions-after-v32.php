<?php
/**
 * Seniorbolaget theme functions
 *
 * @package Seniorbolaget
 * @version 1.0.0
 */

define( 'SENIORBOLAGET_VERSION', '1.0.0' );

/**
 * 301 Redirects for missing/renamed pages.
 */
add_action( 'init', function () {
	$uri = $_SERVER['REQUEST_URI'] ?? '';

	if ( $uri === '/franchise/' || $uri === '/franchise' ) {
		wp_redirect( '/bli-franchisetagare/', 301 );
		exit;
	}

	if ( strpos( $uri, '/foretagstjanster' ) === 0 ) {
		wp_redirect( '/brf/', 301 );
		exit;
	}

	if ( strpos( $uri, '/malning-och-tapetsering' ) === 0 ) {
		wp_redirect( '/snickeri/', 301 );
		exit;
	}

	if ( strpos( $uri, '/omsorg' ) === 0 ) {
		wp_redirect( '/hemstadning/', 301 );
		exit;
	}
} );

/**
 * One-time setup: create Integritetspolicy and Cookiepolicy pages.
 * Runs once after theme deploy, then marks itself done via option.
 */
add_action( 'init', function () {
	if ( get_option( 'sb_pages_created_v1' ) ) {
		return;
	}

	$pages = array(
		array(
			'post_title'   => 'Integritetspolicy',
			'post_name'    => 'integritetspolicy',
			'post_content' => '<h1>Integritetspolicy</h1><p>Seniorbolaget AB värnar om din personliga integritet.</p><h2>Personuppgiftsansvarig</h2><p>Seniorbolaget AB är personuppgiftsansvarig för behandlingen av dina personuppgifter.</p><h2>Vilka uppgifter samlar vi in?</h2><ul><li>Namn och kontaktuppgifter (vid förfrågan)</li><li>E-postadress (vid nyhetsbrev)</li><li>IP-adress (automatiskt via webbserver)</li></ul><h2>Varför behandlar vi dina uppgifter?</h2><p>Vi behandlar dina personuppgifter för att kunna hantera dina förfrågningar och leverera våra tjänster.</p><h2>Dina rättigheter</h2><p>Enligt GDPR har du rätt att begära tillgång till, rättelse av eller radering av dina personuppgifter. Kontakta oss på info@seniorbolaget.se.</p><h2>Kontakt</h2><p>Seniorbolaget AB<br>E-post: info@seniorbolaget.se</p>',
			'post_status'  => 'publish',
			'post_type'    => 'page',
		),
		array(
			'post_title'   => 'Cookiepolicy',
			'post_name'    => 'cookies',
			'post_content' => '<h1>Cookiepolicy</h1><p>Seniorbolaget.se använder cookies för att förbättra din upplevelse.</p><h2>Vad är cookies?</h2><p>Cookies är små textfiler som lagras på din enhet när du besöker vår webbplats.</p><h2>Vilka cookies använder vi?</h2><ul><li><strong>Nödvändiga cookies:</strong> Krävs för att webbplatsen ska fungera korrekt.</li><li><strong>Analytiska cookies:</strong> Hjälper oss förstå hur besökare använder webbplatsen (Google Analytics).</li><li><strong>Marknadsföringscookies:</strong> Används för att visa relevanta annonser.</li></ul><h2>Hantera cookies</h2><p>Du kan när som helst ändra dina cookie-inställningar via din webbläsares inställningar eller via vår cookiebanner.</p><h2>Kontakt</h2><p>Frågor? Kontakta oss på info@seniorbolaget.se.</p>',
			'post_status'  => 'publish',
			'post_type'    => 'page',
		),
	);

	foreach ( $pages as $page ) {
		$existing = get_page_by_path( $page['post_name'], OBJECT, 'page' );
		if ( ! $existing ) {
			wp_insert_post( $page );
		}
	}

	update_option( 'sb_pages_created_v1', true );
} );

/**
 * WAS-170: One-time setup — create Användarvillkor page.
 */
add_action( 'init', function () {
	if ( get_option( 'sb_pages_created_v2' ) ) {
		return;
	}

	$pages = array(
		array(
			'post_title'   => 'Användarvillkor',
			'post_name'    => 'anvandarvillkor',
			'post_content' => '<h1>Användarvillkor</h1><p>Dessa användarvillkor gäller för användning av Seniorbolaget ABs webbplats och tjänster.</p><h2>Tjänstebeskrivning</h2><p>Seniorbolaget AB erbjuder hushållsnära tjänster utförda av erfarna seniorer.</p><h2>Boknings- och betalningsvillkor</h2><p>Bokning sker via webbformulär eller telefon. Betalning sker efter utfört arbete.</p><h2>Ansvarsbegränsning</h2><p>Seniorbolaget AB ansvarar för korrekt utförda tjänster enligt avtalad specifikation.</p><h2>Ändringar och avbokning</h2><p>Avbokning ska ske senast 24 timmar innan bokad tid. Vid senare avbokning kan en avgift tillkomma.</p><h2>Kontakt</h2><p>Seniorbolaget AB<br>E-post: info@seniorbolaget.se</p>',
			'post_status'  => 'publish',
			'post_type'    => 'page',
		),
	);

	foreach ( $pages as $page ) {
		$existing = get_page_by_path( $page['post_name'], OBJECT, 'page' );
		if ( ! $existing ) {
			wp_insert_post( $page );
		}
	}

	update_option( 'sb_pages_created_v2', true );
} );

/**
 * Theme setup.
 */
function seniorbolaget_setup() {
	load_theme_textdomain( 'seniorbolaget', get_template_directory() . '/languages' );

	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primär meny', 'seniorbolaget' ),
			'footer'  => __( 'Sidfots-meny', 'seniorbolaget' ),
		)
	);
}
add_action( 'after_setup_theme', 'seniorbolaget_setup' );

/**
 * Enqueue scripts and styles.
 */
function seniorbolaget_scripts() {
	// Inter från Google Fonts
	wp_enqueue_style(
		'seniorbolaget-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// Tema-stilar
	wp_enqueue_style(
		'seniorbolaget-style',
		get_stylesheet_uri(),
		array( 'seniorbolaget-fonts' ),
		SENIORBOLAGET_VERSION
	);

	// Alpine.js laddas via seniorbolaget_alpine_direct()

	// Anime.js v3 (scroll-animationer)
	wp_enqueue_script(
		'animejs',
		'https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js',
		array(),
		'3.2.1',
		true
	);

	// Seniorbolaget scroll-animationer
	wp_enqueue_script(
		'sb-animations',
		get_template_directory_uri() . '/js/sb-animations.js',
		array( 'animejs' ),
		SENIORBOLAGET_VERSION,
		true
	);
}

/**
 * Wizard CSS för intresseanmälan (WAS-87: fullscreen)
 */
function seniorbolaget_wizard_css() {
	// Temporärt: ladda alltid för debugging
	?>
	<style id="seniorbolaget-wizard-css">
	/* ===== WAS-90: CSS Variables ===== */
	:root{--sb-nav-height:90px;--sb-bottom-bar:110px}
	/* ===== WAS-87: FULLSCREEN WIZARD ===== */
	.wizard-container{all:initial!important;display:flex!important;flex-direction:column!important;min-height:100vh!important;height:auto!important;padding-top:0!important;padding-bottom:32px!important;box-sizing:border-box!important;width:100vw!important;max-width:none!important;margin:0!important;margin-left:calc(50% - 50vw)!important;background:#FAFAF8!important;font-family:Inter,-apple-system,BlinkMacSystemFont,sans-serif!important;overflow:visible!important}
	.wizard-container *,.wizard-container *::before,.wizard-container *::after{box-sizing:border-box!important}
	.wizard-container .wizard-inner{display:flex!important;flex-direction:column!important;flex:1!important;min-height:0!important;max-width:960px!important;width:100%!important;margin:0 auto!important;padding:16px 32px 0!important;background:transparent!important;border-radius:0!important;box-shadow:none!important}
	/* Stepper compact */
	.wizard-container .wiz-stepper{display:flex!important;flex-direction:row!important;align-items:flex-start!important;justify-content:center!important;gap:0!important;flex-shrink:0!important;margin-bottom:12px!important;padding:0 8px!important}
	/* Wizard title compact */
	.wizard-container .wizard-title{font-size:clamp(1.25rem,2.5vw,1.75rem)!important;margin-bottom:4px!important}
	.wizard-container .wizard-subtitle{font-size:0.9375rem!important;margin-bottom:12px!important}
	.wizard-container .wizard-header{margin-bottom:16px!important}
	/* svc-grid + service-cards fills remaining space (2×2 grid) */
	.wizard-container .svc-grid,.wizard-container .service-cards{display:grid!important;grid-template-columns:repeat(2,1fr)!important;grid-template-rows:repeat(2,1fr)!important;gap:14px!important;flex:1!important;min-height:0!important;width:100%!important}
	/* svc-card + service-card fills cell */
	.wizard-container .svc-card,.wizard-container .service-card{height:100%!important;min-height:0!important;display:flex!important;flex-direction:column!important;justify-content:center!important;align-items:center!important;padding:24px 16px!important;border-radius:16px!important;background:#fff!important;border:2px solid #e5e7eb!important;cursor:pointer!important;transition:all 0.2s ease!important;animation:sb-card-in 0.5s ease both!important;text-align:center!important}
	.wizard-container .svc-card.active,.wizard-container .svc-card:hover,.wizard-container .service-card.active,.wizard-container .service-card:hover{border-color:#C91C22!important;background:#FFF4F2!important;transform:scale(1.02)!important}
	.wizard-container .svc-card.selected,.wizard-container .service-card.selected{border-color:#C91C22!important;background:#FFF4F2!important;border-width:3px!important;transform:scale(1.02)!important}
	/* Service-card inner elements centered */
	.wizard-container .service-card .service-icon{font-size:2.5rem!important;margin-bottom:12px!important;width:auto!important}
	.wizard-container .service-card .service-info{text-align:center!important;flex:none!important}
	.wizard-container .service-card .service-name{text-align:center!important;font-size:1.125rem!important;margin-bottom:4px!important}
	.wizard-container .service-card .service-desc{text-align:center!important;font-size:0.875rem!important}
	/* Staggered animation */
	@keyframes sb-card-in{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
	.wizard-container .svc-card:nth-child(1),.wizard-container .service-card:nth-child(1){animation-delay:0.05s!important}
	.wizard-container .svc-card:nth-child(2),.wizard-container .service-card:nth-child(2){animation-delay:0.12s!important}
	.wizard-container .svc-card:nth-child(3),.wizard-container .service-card:nth-child(3){animation-delay:0.19s!important}
	.wizard-container .svc-card:nth-child(4),.wizard-container .service-card:nth-child(4){animation-delay:0.26s!important}
	/* Buttons sticky at bottom */
	.wizard-container .next-btn,.wizard-container .back-btn{flex-shrink:0!important;margin-top:12px!important}
	/* Mobile */
	@media(max-width:768px){
		.wizard-container{height:auto!important;min-height:calc(100vh - 100px)!important;overflow-y:auto!important;padding-top:0!important}
		.wizard-container .wizard-inner{padding:12px 16px 0!important}
		.wizard-container .svc-grid,.wizard-container .service-cards{grid-template-rows:auto!important;flex:none!important}
		.wizard-container .service-card{flex-direction:column!important}
	}
	.wizard-header{text-align:center!important;margin-bottom:32px!important;display:block!important;width:100%!important;max-width:100%!important}
	.wizard-title{font-family:Rubik,sans-serif!important;font-size:clamp(1.5rem,4vw,2rem)!important;font-weight:700!important;color:#1F2937!important;margin:0 0 8px!important;line-height:1.2!important;text-align:center!important;width:100%!important;max-width:100%!important}
	.wizard-subtitle{font-size:1rem!important;color:#6B7280!important;margin:0!important;text-align:center!important;width:100%!important;max-width:100%!important}
	
	/* ===== NEW WIZARD STEPPER (horizontal with labels + values) ===== */
	.wiz-stepper{display:flex!important;justify-content:center!important;align-items:flex-start!important;gap:0!important;margin-bottom:36px!important;padding:0 8px!important}
	.wiz-step{display:flex!important;flex-direction:column!important;align-items:center!important;gap:6px!important;min-width:70px!important;position:relative!important}
	.wiz-step-circle{width:36px!important;height:36px!important;border-radius:50%!important;border:2px solid #e5e7eb!important;background:#fff!important;color:#9CA3AF!important;display:flex!important;align-items:center!important;justify-content:center!important;font-size:14px!important;font-weight:600!important;transition:all .3s ease!important}
	.wiz-step.active .wiz-step-circle{background:#C91C22!important;border-color:#C91C22!important;color:#fff!important;box-shadow:0 0 0 4px rgba(201,28,34,0.15)!important}
	.wiz-step.completed .wiz-step-circle{background:#C91C22!important;border-color:#C91C22!important;color:#fff!important}
	.wiz-step-label{font-size:12px!important;color:#9CA3AF!important;font-weight:500!important;text-align:center!important;transition:color .3s!important}
	.wiz-step.active .wiz-step-label,.wiz-step.completed .wiz-step-label{color:#1F2937!important;font-weight:600!important}
	.wiz-step-value{font-size:11px!important;color:#C91C22!important;font-weight:600!important;text-align:center!important;max-width:80px!important;overflow:hidden!important;text-overflow:ellipsis!important;white-space:nowrap!important;height:14px!important}
	.wiz-step-line{flex:1!important;height:2px!important;background:#e5e7eb!important;margin:17px 8px 0!important;max-width:50px!important;transition:background .3s!important}
	.wiz-step-line.completed{background:#C91C22!important}
	@media(max-width:480px){
		.wiz-step{min-width:55px!important}
		.wiz-step-circle{width:32px!important;height:32px!important;font-size:12px!important}
		.wiz-step-label{font-size:11px!important}
		.wiz-step-line{max-width:30px!important;margin:15px 4px 0!important}
	}
	
	/* ===== TILLBAKA-KNAPP (pill med ikon) ===== */
	.back-btn{display:inline-flex!important;align-items:center!important;gap:8px!important;color:#4B5563!important;font-size:.9375rem!important;font-weight:600!important;background:#fff!important;border:2px solid #e5e7eb!important;border-radius:50px!important;cursor:pointer!important;padding:10px 20px!important;margin-bottom:20px!important;transition:all .2s!important}
	.back-btn:hover{border-color:#C91C22!important;color:#C91C22!important;background:#FFF4F2!important}
	.back-icon{font-size:1rem!important;line-height:1!important}
	
	/* ===== SERVICE CARDS — 2×2 VISUAL GRID ===== */
	.svc-grid{display:grid!important;grid-template-columns:1fr 1fr!important;gap:16px!important;width:100%!important}
	.svc-card{position:relative!important;padding:28px 20px 24px!important;background:#fff!important;border:2px solid #F3F4F6!important;border-radius:16px!important;cursor:pointer!important;text-align:center!important;transition:all .2s cubic-bezier(.34,1.56,.64,1)!important;box-shadow:0 2px 8px rgba(0,0,0,0.04)!important}
	.svc-card:hover{border-color:#C91C22!important;transform:translateY(-4px) scale(1.02)!important;box-shadow:0 12px 32px rgba(201,28,34,0.12)!important}
	.svc-card.selected{border-color:#C91C22!important;border-width:3px!important;background:#FFF4F2!important;transform:translateY(-2px)!important;box-shadow:0 8px 24px rgba(201,28,34,0.2)!important}
	.svc-card-icon{width:80px!important;height:80px!important;margin:0 auto 16px!important;font-size:3rem!important;display:flex!important;align-items:center!important;justify-content:center!important;line-height:1!important}
	.svc-card-icon svg{width:100%!important;height:100%!important}
	.svc-card-name{font-family:Rubik,sans-serif!important;font-weight:700!important;font-size:18px!important;color:#1F2937!important;margin-bottom:6px!important}
	.svc-card-desc{font-size:13px!important;color:#6B7280!important;line-height:1.4!important}
	.svc-card-check{position:absolute!important;top:12px!important;right:12px!important;width:28px!important;height:28px!important;background:#C91C22!important;color:#fff!important;border-radius:50%!important;display:flex!important;align-items:center!important;justify-content:center!important;font-size:14px!important;font-weight:bold!important;opacity:0!important;transform:scale(0)!important;transition:all .25s cubic-bezier(.34,1.56,.64,1)!important}
	.svc-card.selected .svc-card-check{opacity:1!important;transform:scale(1)!important}
	@media(max-width:500px){
		.svc-grid{grid-template-columns:1fr 1fr!important;gap:12px!important}
		.svc-card{padding:20px 12px 16px!important}
		.svc-card-icon{width:60px!important;height:60px!important;font-size:2.5rem!important;margin-bottom:12px!important}
		.svc-card-name{font-size:15px!important}
		.svc-card-desc{font-size:12px!important}
	}
	
	/* Legacy service-cards (fallback, hidden if svc-grid exists) */
	.service-cards{display:grid!important;grid-template-columns:1fr!important;gap:16px!important;width:100%!important;max-width:100%!important}
	.service-card{display:flex!important;flex-direction:row!important;align-items:center!important;gap:16px!important;padding:20px 24px!important;background:#fff!important;border:2px solid #e5e7eb!important;border-radius:16px!important;cursor:pointer!important;transition:all .2s ease!important;min-height:80px!important;width:100%!important;max-width:100%!important;position:relative!important}
	.service-card:hover{border-color:#C91C22!important;background:#FFF4F2!important;transform:translateY(-2px)!important;box-shadow:0 8px 24px -8px rgba(201,28,34,0.15)!important}
	.service-card.selected{border-color:#C91C22!important;background:#FFF4F2!important;border-width:3px!important}
	.service-icon{font-size:2rem!important;width:48px!important;text-align:center!important;flex-shrink:0!important}
	.service-info{flex:1!important;text-align:left!important}
	.service-name{font-family:Rubik,sans-serif!important;font-size:1.125rem!important;font-weight:600!important;color:#1F2937!important;margin:0 0 4px!important;text-align:left!important}
	.service-desc{font-size:.875rem!important;color:#6B7280!important;margin:0!important;text-align:left!important}
	.city-search{width:100%;padding:14px 18px;border:2px solid #e5e7eb;border-radius:50px;font-size:1rem;margin-bottom:16px;background:#fff;box-sizing:border-box}
	.city-search:focus{outline:none;border-color:#C91C22}
	.city-list{display:flex;flex-wrap:wrap;gap:8px;padding:4px 0;max-height:320px;overflow-y:auto}
	.city-item{padding:9px 18px;background:#fff;border:1.5px solid #e5e7eb;border-radius:50px;cursor:pointer;font-size:0.92rem;font-weight:500;color:#1F2937;transition:all .15s;white-space:nowrap}
	.city-item:hover{border-color:#C91C22;color:#C91C22;transform:scale(1.03)}.city-item.selected{border-color:#C91C22;background:#C91C22;color:#fff}
	.city-list::-webkit-scrollbar{width:4px;height:4px}.city-list::-webkit-scrollbar-thumb{background:#e5e7eb;border-radius:99px}
	.form-group{margin-bottom:20px}
	.form-label{display:block;font-family:Rubik,sans-serif;font-size:.9375rem;font-weight:600;color:#1F2937;margin-bottom:8px}
	.form-label-optional{font-weight:400;color:#6B7280}
	.form-input{width:100%;padding:14px 18px;border:2px solid #e5e7eb;border-radius:50px;font-size:1rem;font-family:Inter,sans-serif;color:#1F2937;background:#fff;box-sizing:border-box}
	.form-input:focus{outline:none;border-color:#C91C22}
	.form-textarea{border-radius:16px;resize:vertical;min-height:100px}
	.radio-group,.checkbox-group{display:flex;flex-direction:column;gap:12px}
	.radio-option,.checkbox-option{display:flex;align-items:center;gap:12px;padding:16px 20px;background:#fff;border:2px solid #e5e7eb;border-radius:12px;cursor:pointer;transition:all .2s}
	.radio-option:hover,.checkbox-option:hover,.radio-option.selected,.checkbox-option.selected{border-color:#C91C22;background:#FFF4F2}
	.radio-option input,.checkbox-option input{width:20px;height:20px;accent-color:#C91C22;cursor:pointer}
	.option-label{flex:1;font-size:1rem;color:#1F2937}
	.option-badge{background:#C91C22;color:#fff;font-size:.75rem;font-weight:600;padding:4px 10px;border-radius:50px}
	.checkbox-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
	@media(max-width:500px){.checkbox-grid{grid-template-columns:1fr}}
	.submit-btn{width:100%;padding:18px 32px;background:#C91C22;color:#fff;border:none;border-radius:50px;font-size:1.125rem;font-weight:700;font-family:Rubik,sans-serif;cursor:pointer;transition:background .2s;margin-top:16px}
	.submit-btn:hover:not(:disabled){background:#a01519}
	.submit-btn:disabled{background:#ccc;cursor:not-allowed}
	.next-btn{width:100%;padding:16px 32px;background:#C91C22;color:#fff;border:none;border-radius:50px;font-size:1rem;font-weight:600;font-family:Rubik,sans-serif;cursor:pointer;transition:background .2s;margin-top:24px}
	.next-btn:hover:not(:disabled){background:#a01519}
	.next-btn:disabled{background:#ccc;cursor:not-allowed}
	.gdpr-check{display:flex;align-items:flex-start;gap:12px;padding:16px;background:#FFF4F2;border-radius:12px;margin-top:20px}
	.gdpr-check input{width:22px;height:22px;accent-color:#C91C22;margin-top:2px;flex-shrink:0}
	.gdpr-text{font-size:.875rem;color:#4B5563;line-height:1.5}
	.gdpr-text a{color:#C91C22}
	/* ===== TRUST SECTION (visas alltid, även mobil) ===== */
	.trust-section{margin-top:32px!important;padding-top:24px!important;border-top:1px solid #e5e7eb!important;width:100%!important}
	.trust-bar{display:flex!important;flex-direction:row!important;justify-content:center!important;align-items:center!important;gap:20px!important;flex-wrap:wrap!important;width:100%!important;max-width:100%!important;margin-bottom:16px!important}
	.trust-item{display:inline-flex!important;flex-direction:row!important;align-items:center!important;gap:6px!important;font-size:.875rem!important;color:#4B5563!important;white-space:nowrap!important}
	.trust-check{color:#C91C22!important;font-weight:bold!important;font-size:1rem!important}
	.phone-banner{text-align:center!important;padding:16px 20px!important;background:#fff!important;border-radius:50px!important;font-size:1rem!important;color:#4B5563!important;width:100%!important;max-width:100%!important;display:flex!important;align-items:center!important;justify-content:center!important;gap:8px!important;box-shadow:0 2px 8px rgba(0,0,0,0.05)!important}
	.phone-label{color:#6B7280!important;font-weight:500!important}
	.phone-banner a{color:#C91C22!important;font-weight:700!important;text-decoration:none!important;font-size:1.125rem!important}
	.phone-banner a:hover{text-decoration:underline!important}
	@media(max-width:480px){
		.trust-bar{flex-direction:column!important;gap:10px!important;align-items:center!important}
		.trust-item{font-size:.8125rem!important}
		.phone-banner{flex-direction:column!important;gap:4px!important;padding:14px 16px!important}
		.phone-banner a{font-size:1.25rem!important}
	}
	.thank-you{text-align:center;padding:48px 24px;background:#fff;border-radius:20px}
	.thank-icon{width:80px;height:80px;background:#d4edda;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:2.5rem}
	.thank-title{font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#1F2937;margin:0 0 12px}
	.thank-text{font-size:1rem;color:#6B7280;margin:0 0 24px;line-height:1.6}
	.thank-summary{background:#FAFAF8;border-radius:12px;padding:20px;text-align:left;margin-bottom:24px}
	.summary-row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e5e7eb;font-size:.9375rem}
	.summary-row:last-child{border-bottom:none}
	.summary-label{color:#6B7280}
	.summary-value{color:#1F2937;font-weight:500}
	.spinner{display:inline-block;width:20px;height:20px;border:3px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin .8s linear infinite;margin-right:8px}
	@keyframes spin{to{transform:rotate(360deg)}}
	.error-msg{background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;font-size:.875rem;margin-bottom:16px}
	[x-cloak]{display:none!important}
	</style>
	<?php
}
add_action( 'wp_head', 'seniorbolaget_wizard_css' );

/**
 * Load Alpine.js directly in footer for intresseanmälan
 */
function seniorbolaget_alpine_direct() {
	$alpine_url = get_template_directory_uri() . '/alpine.min.js';
	echo '<script defer src="' . esc_url($alpine_url) . '"></script>' . "\n";
}
add_action( 'wp_footer', 'seniorbolaget_alpine_direct', 99 );

// WAS-90: Wizard-sidor får body-klass is-wizard-page
function sb_wizard_body_class( $classes ) {
    global $post;
    if ( $post && in_array( $post->post_name, ['intresseanmalan', 'jobba-med-oss', 'bli-franchisetagare'] ) ) {
        $classes[] = 'is-wizard-page';
    }
    return $classes;
}
add_filter( 'body_class', 'sb_wizard_body_class' );

/**
 * Wizard JS för intresseanmälan
 */
function seniorbolaget_wizard_js() {
	// Temporärt: ladda alltid för debugging
	?>
	<script>
	function wizardApp() {
		return {
			step: 1,
			citySearch: '',
			isSubmitting: false,
			errorMsg: '',
			
			cities: [
				{ name: 'Åmål', value: 'amal' },
				{ name: 'Borås', value: 'boras' },
				{ name: 'Eskilstuna', value: 'eskilstuna' },
				{ name: 'Falkenberg', value: 'falkenberg' },
				{ name: 'Göteborg', value: 'goteborg' },
				{ name: 'Halmstad', value: 'halmstad' },
				{ name: 'Helsingborg', value: 'helsingborg' },
				{ name: 'Jönköping', value: 'jonkoping' },
				{ name: 'Karlstad', value: 'karlstad' },
				{ name: 'Kristianstad', value: 'kristianstad' },
				{ name: 'Kungälv', value: 'kungalv' },
				{ name: 'Kungsbacka', value: 'kungsbacka' },
				{ name: 'Laholm/Båstad', value: 'laholm-bastad' },
				{ name: 'Landskrona', value: 'landskrona' },
				{ name: 'Lerum/Partille', value: 'lerum-partille' },
				{ name: 'Mölndal/Härryda', value: 'molndal-harryda' },
				{ name: 'Nässjö', value: 'nassjo' },
				{ name: 'Örebro', value: 'orebro' },
				{ name: 'Skövde', value: 'skovde' },
				{ name: 'Stenungsund', value: 'stenungsund' },
				{ name: 'Sundsvall', value: 'sundsvall' },
				{ name: 'Torsby', value: 'torsby' },
				{ name: 'Trelleborg', value: 'trelleborg' },
				{ name: 'Trollhättan', value: 'trollhattan' },
				{ name: 'Ulricehamn', value: 'ulricehamn' },
				{ name: 'Varberg', value: 'varberg' }
			],
			filteredCities: [],
			
			gardenTasks: [
				{ label: 'Gräsklippning', value: 'grasklippning' },
				{ label: 'Häckklippning', value: 'hackklippning' },
				{ label: 'Ogräsrensning', value: 'ograsrensning' },
				{ label: 'Beskärning', value: 'beskarning' },
				{ label: 'Snöskottning', value: 'snoskottning' },
				{ label: 'Övrigt', value: 'ovrigt' }
			],
			
			formData: {
				service: '',
				city: '',
				area: '',
				frequency: '',
				pets: '',
				gardenServices: [],
				description: '',
				timeline: '',
				notes: '',
				name: '',
				phone: '',
				email: '',
				address: '',
				contactMethod: 'ring',
				gdprConsent: false
			},
			
			init() {
				this.filteredCities = this.cities;
			},
			
			resetCardAnimations() {
				this.$nextTick(() => {
					document.querySelectorAll('.wizard-container .svc-card, .wizard-container .city-item, .wizard-container .service-card').forEach(el => {
						el.style.animation = 'none';
						el.offsetHeight; // force reflow
						el.style.animation = null;
					});
				});
			},
			
			// WAS-88: Alias for animation reset
			resetAnims() {
				this.resetCardAnimations();
			},
			
			goToStep(n) {
				this.step = n;
				this.resetCardAnimations();
			},
			
			selectService(service) {
				this.formData.service = service;
				// Brief delay to show selection animation before advancing
				setTimeout(() => { this.step = 2; this.resetCardAnimations(); }, 300);
			},
			
			filterCities() {
				const search = this.citySearch.toLowerCase();
				this.filteredCities = this.cities.filter(c => 
					c.name.toLowerCase().includes(search)
				);
			},
			
			selectCity(city) {
				this.formData.city = city.value;
				this.step = 3;
				this.resetCardAnimations();
			},
			
			renderCities() {
				return this.filteredCities.map(city => {
					const selected = this.formData.city === city.value ? 'selected' : '';
					return `<div class="city-item ${selected}" @click="selectCity({name:'${city.name}',value:'${city.value}'})">${city.name}</div>`;
				}).join('');
			},
			
			renderGardenTasks() {
				return this.gardenTasks.map(task => {
					const checked = this.formData.gardenServices.includes(task.value);
					const selected = checked ? 'selected' : '';
					return `<label class="checkbox-option ${selected}" @click.prevent="toggleGardenService('${task.value}')">
						<input type="checkbox" value="${task.value}" ${checked ? 'checked' : ''}>
						<span class="option-label">${task.label}</span>
					</label>`;
				}).join('');
			},
			
			toggleGardenService(value) {
				const idx = this.formData.gardenServices.indexOf(value);
				if (idx > -1) {
					this.formData.gardenServices.splice(idx, 1);
				} else {
					this.formData.gardenServices.push(value);
				}
			},
			
			getServiceName() {
				const names = {
					'hemstadning': 'Hemstädning',
					'tradgard': 'Trädgård',
					'snickeri': 'Snickeri',
					'malning': 'Målning'
				};
				return names[this.formData.service] || '';
			},
			
			getCityName() {
				const city = this.cities.find(c => c.value === this.formData.city);
				return city ? city.name : '';
			},
			
			getStepNum(n) {
				return this.step > n ? '\u2713' : String(n);
			},
			
			getStepVal(n) {
				if (this.step <= n) return '';
				if (n === 1) return this.getServiceName();
				if (n === 2) return this.getCityName();
				return '';
			},
			
			canProceedStep3() {
				if (this.formData.service === 'hemstadning') {
					return this.formData.area && this.formData.frequency && this.formData.pets;
				}
				if (this.formData.service === 'tradgard') {
					return this.formData.gardenServices.length > 0;
				}
				if (this.formData.service === 'snickeri' || this.formData.service === 'malning') {
					return this.formData.description && this.formData.timeline;
				}
				return false;
			},
			
			canSubmit() {
				return this.formData.name && 
					   this.formData.phone && 
					   this.formData.email && 
					   this.formData.address && 
					   this.formData.contactMethod && 
					   this.formData.gdprConsent;
			},
			
			async submitForm() {
				if (!this.canSubmit()) return;
				
				this.isSubmitting = true;
				this.errorMsg = '';
				
				const data = new FormData();
				data.append('action', 'seniorbolaget_wizard');
				data.append('service', this.formData.service);
				data.append('city', this.formData.city);
				data.append('name', this.formData.name);
				data.append('phone', this.formData.phone);
				data.append('email', this.formData.email);
				data.append('address', this.formData.address);
				data.append('contact_method', this.formData.contactMethod);
				
				if (this.formData.service === 'hemstadning') {
					data.append('area', this.formData.area);
					data.append('frequency', this.formData.frequency);
					data.append('pets', this.formData.pets);
				}
				if (this.formData.service === 'tradgard') {
					data.append('garden_services', this.formData.gardenServices.join(', '));
				}
				if (this.formData.service === 'snickeri' || this.formData.service === 'malning') {
					data.append('description', this.formData.description);
					data.append('timeline', this.formData.timeline);
				}
				data.append('notes', this.formData.notes);
				
				try {
					const response = await fetch('/wp-admin/admin-ajax.php', {
						method: 'POST',
						body: data
					});
					const result = await response.json();
					
					if (result.success) {
						this.step = 5;
						this.resetAnims();
					} else {
						this.errorMsg = result.data?.message || 'Något gick fel. Försök igen eller ring oss.';
					}
				} catch (error) {
					this.errorMsg = 'Kunde inte skicka förfrågan. Kontrollera din internetanslutning.';
				}
				
				this.isSubmitting = false;
			}
		}
	}
	</script>
	<?php
}
add_action( 'wp_head', 'seniorbolaget_wizard_js', 99 );

/**
 * Shortcode för intresseanmälan wizard
 */
function seniorbolaget_wizard_shortcode() {
    ob_start();
    ?>
    <div class="wizard-container" x-data="wizardApp()" x-cloak>
        <div class="wizard-inner">
            <div class="progress-dots">
                <div class="progress-dot" :class="{ 'active': step === 1, 'completed': step > 1 }"></div>
                <div class="progress-dot" :class="{ 'active': step === 2, 'completed': step > 2 }"></div>
                <div class="progress-dot" :class="{ 'active': step === 3, 'completed': step > 3 }"></div>
                <div class="progress-dot" :class="{ 'active': step === 4, 'completed': step > 4 }"></div>
            </div>
            <p class="step-label" x-show="step < 5">Steg <span x-text="step"></span> av 4</p>
            
            <div class="trust-bar" x-show="step < 5">
                <span class="trust-item"><span class="trust-check">✓</span> Svar inom 24h</span>
                <span class="trust-item"><span class="trust-check">✓</span> Kostnadsfri offert</span>
                <span class="trust-item"><span class="trust-check">✓</span> Inga bindningstider</span>
            </div>
            <div class="phone-banner" x-show="step < 5">Föredrar du att ringa? <a href="tel:0101751900">010-175 19 00</a></div>
            
            <div x-show="step === 1" x-transition>
                <div class="wizard-header">
                    <h1 class="wizard-title">Vad behöver du hjälp med?</h1>
                    <p class="wizard-subtitle">Välj en tjänst nedan</p>
                </div>
                <div class="service-cards">
                    <div class="service-card" @click="selectService('hemstadning')" :class="{ 'selected': formData.service === 'hemstadning' }">
                        <span class="service-icon">🧹</span>
                        <div class="service-info"><p class="service-name">Hemstädning</p><p class="service-desc">Regelbunden eller engångsstädning</p></div>
                    </div>
                    <div class="service-card" @click="selectService('tradgard')" :class="{ 'selected': formData.service === 'tradgard' }">
                        <span class="service-icon">🌿</span>
                        <div class="service-info"><p class="service-name">Trädgård</p><p class="service-desc">Gräsklippning, häck, ogräs och mer</p></div>
                    </div>
                    <div class="service-card" @click="selectService('snickeri')" :class="{ 'selected': formData.service === 'snickeri' }">
                        <span class="service-icon">🔨</span>
                        <div class="service-info"><p class="service-name">Snickeri</p><p class="service-desc">Allt från hyllor till större projekt</p></div>
                    </div>
                    <div class="service-card" @click="selectService('malning')" :class="{ 'selected': formData.service === 'malning' }">
                        <span class="service-icon">🎨</span>
                        <div class="service-info"><p class="service-name">Målning</p><p class="service-desc">Inomhus och utomhus</p></div>
                    </div>
                </div>
            </div>
            
            <div x-show="step === 2" x-transition>
                <button class="back-btn" @click="goToStep(1)" type="button">← Tillbaka</button>
                <div class="wizard-header">
                    <h1 class="wizard-title">Var finns du?</h1>
                    <p class="wizard-subtitle">Välj din ort</p>
                </div>
                <input type="text" class="city-search" placeholder="Sök ort..." x-model="citySearch" @input="filterCities()">
                <div class="city-list" x-html="renderCities()"></div>
            </div>
            
            <div x-show="step === 3" x-transition>
                <button class="back-btn" @click="goToStep(2)" type="button">← Tillbaka</button>
                <div class="wizard-header">
                    <h1 class="wizard-title">Berätta mer om uppdraget</h1>
                    <p class="wizard-subtitle" x-text="getServiceName()"></p>
                </div>
                
                <div x-show="formData.service === 'hemstadning'">
                    <!-- Bostadsyta -->
                    <div style="margin-bottom:32px;">
                        <h3 style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:700;color:#1F2937;margin:0 0 16px;">Bostadsyta (kvm)</h3>
                        <div class="svc-grid">
                            <div class="svc-card" :class="{selected: formData.area === 'under50'}" @click="formData.area = 'under50'">
                                <div class="svc-card-icon" style="width:48px;height:48px;font-size:2.5rem;display:flex;align-items:center;justify-content:center;">🏠</div>
                                <div class="svc-card-name">Under 50 kvm</div>
                                <div class="svc-card-check">✓</div>
                            </div>
                            <div class="svc-card" :class="{selected: formData.area === '50-80'}" @click="formData.area = '50-80'">
                                <div class="svc-card-icon" style="width:48px;height:48px;font-size:2.5rem;display:flex;align-items:center;justify-content:center;">🏡</div>
                                <div class="svc-card-name">50–80 kvm</div>
                                <div class="svc-card-check">✓</div>
                            </div>
                            <div class="svc-card" :class="{selected: formData.area === '80-120'}" @click="formData.area = '80-120'">
                                <div class="svc-card-icon" style="width:48px;height:48px;font-size:2.5rem;display:flex;align-items:center;justify-content:center;">🏘️</div>
                                <div class="svc-card-name">80–120 kvm</div>
                                <div class="svc-card-check">✓</div>
                            </div>
                            <div class="svc-card" :class="{selected: formData.area === 'over120'}" @click="formData.area = 'over120'">
                                <div class="svc-card-icon" style="width:48px;height:48px;font-size:2.5rem;display:flex;align-items:center;justify-content:center;">🏰</div>
                                <div class="svc-card-name">Över 120 kvm</div>
                                <div class="svc-card-check">✓</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hur ofta städning -->
                    <div style="margin-bottom:32px;">
                        <h3 style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:700;color:#1F2937;margin:0 0 16px;">Hur ofta vill du ha städning?</h3>
                        <div class="svc-grid">
                            <div class="svc-card" :class="{selected: formData.frequency === 'varannan'}" @click="formData.frequency = 'varannan'">
                                <div class="svc-card-icon" style="width:48px;height:48px;font-size:2.5rem;display:flex;align-items:center;justify-content:center;">🔄</div>
                                <div class="svc-card-name">Varannan vecka</div>
                                <div class="svc-card-desc" style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                    <span style="background:#C91C22;color:#fff;font-size:0.6875rem;font-weight:700;padding:2px 8px;border-radius:50px;">★ Populär</span>
                                </div>
                                <div class="svc-card-check">✓</div>
                            </div>
                            <div class="svc-card" :class="{selected: formData.frequency === 'varfjarde'}" @click="formData.frequency = 'varfjarde'">
                                <div class="svc-card-icon" style="width:48px;height:48px;font-size:2.5rem;display:flex;align-items:center;justify-content:center;">📅</div>
                                <div class="svc-card-name">Var fjärde vecka</div>
                                <div class="svc-card-check">✓</div>
                            </div>
                            <div class="svc-card" :class="{selected: formData.frequency === 'engangsstadning'}" @click="formData.frequency = 'engangsstadning'">
                                <div class="svc-card-icon" style="width:48px;height:48px;font-size:2.5rem;display:flex;align-items:center;justify-content:center;">1️⃣</div>
                                <div class="svc-card-name">Engångsstädning</div>
                                <div class="svc-card-check">✓</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Husdjur hemma -->
                    <div style="margin-bottom:32px;">
                        <h3 style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:700;color:#1F2937;margin:0 0 16px;">Husdjur hemma?</h3>
                        <div class="svc-grid" style="grid-template-columns:1fr 1fr;">
                            <div class="svc-card" :class="{selected: formData.pets === 'ja'}" @click="formData.pets = 'ja'">
                                <div class="svc-card-icon" style="width:48px;height:48px;font-size:2.5rem;display:flex;align-items:center;justify-content:center;">🐾</div>
                                <div class="svc-card-name">Ja</div>
                                <div class="svc-card-check">✓</div>
                            </div>
                            <div class="svc-card" :class="{selected: formData.pets === 'nej'}" @click="formData.pets = 'nej'">
                                <div class="svc-card-icon" style="width:48px;height:48px;font-size:2.5rem;display:flex;align-items:center;justify-content:center;">✨</div>
                                <div class="svc-card-name">Nej</div>
                                <div class="svc-card-check">✓</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Övrigt <span class="form-label-optional">(valfritt)</span></label>
                        <textarea class="form-input form-textarea" placeholder="Något mer vi bör veta?" x-model="formData.notes"></textarea>
                    </div>
                </div>
                
                <div x-show="formData.service === 'tradgard'">
                    <div class="form-group">
                        <label class="form-label">Vad behöver du hjälp med?</label>
                        <div class="checkbox-grid" x-html="renderGardenTasks()"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Övrigt <span class="form-label-optional">(valfritt)</span></label>
                        <textarea class="form-input form-textarea" placeholder="Beskriv gärna mer om din trädgård..." x-model="formData.notes"></textarea>
                    </div>
                </div>
                
                <div x-show="formData.service === 'snickeri' || formData.service === 'malning'">
                    <div class="form-group">
                        <label class="form-label">Beskriv uppdraget</label>
                        <textarea class="form-input form-textarea" placeholder="Vad behöver göras?" x-model="formData.description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">När vill du ha det gjort?</label>
                        <div class="radio-group">
                            <label class="radio-option" :class="{ 'selected': formData.timeline === 'snarast' }">
                                <input type="radio" name="timeline" value="snarast" x-model="formData.timeline">
                                <span class="option-label">Snarast</span>
                            </label>
                            <label class="radio-option" :class="{ 'selected': formData.timeline === 'manad' }">
                                <input type="radio" name="timeline" value="manad" x-model="formData.timeline">
                                <span class="option-label">Inom en månad</span>
                            </label>
                            <label class="radio-option" :class="{ 'selected': formData.timeline === 'flexibel' }">
                                <input type="radio" name="timeline" value="flexibel" x-model="formData.timeline">
                                <span class="option-label">Flexibel</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Övrigt <span class="form-label-optional">(valfritt)</span></label>
                        <textarea class="form-input form-textarea" placeholder="Något mer vi bör veta?" x-model="formData.notes"></textarea>
                    </div>
                </div>
                <button class="next-btn" @click="goToStep(4)" :disabled="!canProceedStep3()" type="button">Nästa steg →</button>
            </div>
            
            <div x-show="step === 4" x-transition>
                <button class="back-btn" @click="goToStep(3)" type="button">← Tillbaka</button>
                <div class="wizard-header">
                    <h1 class="wizard-title">Dina uppgifter</h1>
                    <p class="wizard-subtitle">Så vi kan kontakta dig</p>
                </div>
                <div x-show="errorMsg" class="error-msg" x-text="errorMsg"></div>
                <div class="form-group">
                    <label class="form-label">Förnamn <span style="color:#C91C22;font-weight:700;">*</span></label>
                    <input type="text" class="form-input" placeholder="Ditt förnamn" x-model="formData.name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Telefonnummer <span style="color:#C91C22;font-weight:700;">*</span></label>
                    <input type="tel" class="form-input" placeholder="070-123 45 67" x-model="formData.phone" required>
                </div>
                <div class="form-group">
                    <label class="form-label">E-postadress <span style="color:#C91C22;font-weight:700;">*</span></label>
                    <input type="email" class="form-input" placeholder="din@email.se" x-model="formData.email" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Adress <span style="color:#C91C22;font-weight:700;">*</span></label>
                    <input type="text" class="form-input" placeholder="Gatuadress, stad" x-model="formData.address" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Hur vill du bli kontaktad?</label>
                    <div class="radio-group" style="flex-direction: row; gap: 16px;">
                        <label class="radio-option" style="flex: 1;" :class="{ 'selected': formData.contactMethod === 'ring' }">
                            <input type="radio" name="contact" value="ring" x-model="formData.contactMethod">
                            <span class="option-label">📞 Ring mig</span>
                        </label>
                        <label class="radio-option" style="flex: 1;" :class="{ 'selected': formData.contactMethod === 'sms' }">
                            <input type="radio" name="contact" value="sms" x-model="formData.contactMethod">
                            <span class="option-label">💬 Skicka SMS</span>
                        </label>
                    </div>
                </div>
                <div class="gdpr-check">
                    <input type="checkbox" id="gdpr" x-model="formData.gdprConsent">
                    <label for="gdpr" class="gdpr-text">Jag godkänner att Seniorbolaget kontaktar mig och lagrar mina uppgifter enligt deras <a href="/integritetspolicy" target="_blank">integritetspolicy</a>.</label>
                </div>
                <button class="submit-btn" @click="submitForm()" :disabled="!canSubmit() || isSubmitting" type="button">
                    <span x-show="isSubmitting" class="spinner"></span>
                    <span x-text="isSubmitting ? 'Skickar...' : 'Skicka förfrågan →'"></span>
                </button>
            </div>
            
            <div x-show="step === 5" x-transition>
                <div class="thank-you">
                    <div class="thank-icon">✓</div>
                    <h2 class="thank-title">Tack för din förfrågan!</h2>
                    <p class="thank-text">Vi har tagit emot dina uppgifter och återkommer inom 24 timmar.</p>
                    <div class="thank-summary">
                        <div class="summary-row"><span class="summary-label">Tjänst</span><span class="summary-value" x-text="getServiceName()"></span></div>
                        <div class="summary-row"><span class="summary-label">Ort</span><span class="summary-value" x-text="getCityName()"></span></div>
                        <div class="summary-row"><span class="summary-label">Namn</span><span class="summary-value" x-text="formData.name"></span></div>
                        <div class="summary-row"><span class="summary-label">Telefon</span><span class="summary-value" x-text="formData.phone"></span></div>
                    </div>
                    <a href="/" style="display:inline-block;padding:14px 28px;background:#C91C22;color:#fff;border-radius:50px;font-weight:600;text-decoration:none;">Tillbaka till startsidan</a>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('seniorbolaget_wizard', 'seniorbolaget_wizard_shortcode');

// Prevent wpautop from breaking wizard HTML
remove_filter('the_content', 'wpautop');
add_filter('the_content', 'seniorbolaget_conditional_wpautop');
function seniorbolaget_conditional_wpautop($content) {
    if (is_page('intresse-anmalan') || is_page(99)) {
        return $content; // Skip wpautop on wizard page
    }
    return wpautop($content);
}
add_action( 'wp_enqueue_scripts', 'seniorbolaget_scripts' );

/**
 * Enqueue editor styles.
 */
function seniorbolaget_editor_styles() {
	add_editor_style( 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap' );
}
add_action( 'after_setup_theme', 'seniorbolaget_editor_styles' );

/**
 * Block patterns kategori.
 */
function seniorbolaget_register_pattern_categories() {
	register_block_pattern_category(
		'seniorbolaget',
		array( 'label' => __( 'Seniorbolaget', 'seniorbolaget' ) )
	);
}
add_action( 'init', 'seniorbolaget_register_pattern_categories' );

// Feature flags
require_once get_template_directory() . '/inc/feature-flags.php';

// Manuell registrering av stadssida-mönster (bypass auto-scan)
function seniorbolaget_register_stad_patterns() {
    $pattern_dir = get_template_directory() . '/patterns/';
    $stad_patterns = glob($pattern_dir . 'stad-*.php');
    foreach ($stad_patterns as $file) {
        $headers = get_file_data($file, array(
            'title'       => 'Title',
            'slug'        => 'Slug',
            'description' => 'Description',
            'categories'  => 'Categories',
        ));
        if (empty($headers['slug'])) continue;
        ob_start();
        include $file;
        $content = ob_get_clean();
        register_block_pattern($headers['slug'], array(
            'title'       => $headers['title'],
            'description' => $headers['description'],
            'categories'  => array_map('trim', explode(',', $headers['categories'])),
            'content'     => $content,
        ));
    }
}
add_action('init', 'seniorbolaget_register_stad_patterns', 20);

// Manuell registrering av info-sidor (om oss, jobba, franchise, etc.)
function seniorbolaget_register_info_patterns() {
    $pattern_dir = get_template_directory() . '/patterns/';
    $info_patterns = array(
        'om-oss-page.php',
        'jobba-med-oss-page.php',
        'franchise-page.php',
        'intresse-anmalan-page.php',
        'kontakt-page.php',
    );
    foreach ($info_patterns as $filename) {
        $file = $pattern_dir . $filename;
        if (!file_exists($file)) continue;
        $headers = get_file_data($file, array(
            'title'       => 'Title',
            'slug'        => 'Slug',
            'description' => 'Description',
            'categories'  => 'Categories',
        ));
        if (empty($headers['slug'])) continue;
        ob_start();
        include $file;
        $content = ob_get_clean();
        register_block_pattern($headers['slug'], array(
            'title'       => $headers['title'],
            'description' => $headers['description'],
            'categories'  => array_map('trim', explode(',', $headers['categories'])),
            'content'     => $content,
        ));
    }
}
add_action('init', 'seniorbolaget_register_info_patterns', 20);

/**
 * AJAX handler för intresseanmälan-wizard
 */
add_action('wp_ajax_seniorbolaget_wizard', 'seniorbolaget_wizard_submit');
add_action('wp_ajax_nopriv_seniorbolaget_wizard', 'seniorbolaget_wizard_submit');

function seniorbolaget_wizard_submit() {
    // Sanitize all inputs
    $service = sanitize_text_field($_POST['service'] ?? '');
    $city = sanitize_text_field($_POST['city'] ?? '');
    $name = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $contact_method = sanitize_text_field($_POST['contact_method'] ?? '');
    $notes = sanitize_textarea_field($_POST['notes'] ?? '');
    
    // Service-specific fields
    $area = sanitize_text_field($_POST['area'] ?? '');
    $frequency = sanitize_text_field($_POST['frequency'] ?? '');
    $pets = sanitize_text_field($_POST['pets'] ?? '');
    $garden_services = sanitize_text_field($_POST['garden_services'] ?? '');
    $description = sanitize_textarea_field($_POST['description'] ?? '');
    $timeline = sanitize_text_field($_POST['timeline'] ?? '');
    
    // Validate required fields
    if (empty($service) || empty($city) || empty($name) || empty($phone)) {
        wp_send_json_error(['message' => 'Vänligen fyll i alla obligatoriska fält.']);
        return;
    }
    
    // Map service names
    $service_names = [
        'hemstadning' => 'Hemstädning',
        'tradgard' => 'Trädgård',
        'snickeri' => 'Snickeri',
        'malning' => 'Målning'
    ];
    $service_name = $service_names[$service] ?? $service;
    
    // Map frequency
    $frequency_names = [
        'varannan' => 'Varannan vecka',
        'varfjarde' => 'Var fjärde vecka',
        'engangsstadning' => 'Engångsstädning'
    ];
    $frequency_name = $frequency_names[$frequency] ?? $frequency;
    
    // Map timeline
    $timeline_names = [
        'snarast' => 'Snarast',
        'manad' => 'Inom en månad',
        'flexibel' => 'Flexibel'
    ];
    $timeline_name = $timeline_names[$timeline] ?? $timeline;
    
    // Contact method
    $contact_text = ($contact_method === 'ring') ? 'Ring mig' : 'Skicka SMS';
    
    // Build email body
    $body = "NY FÖRFRÅGAN FRÅN INTRESSEANMÄLAN\n";
    $body .= "================================\n\n";
    $body .= "Tjänst: {$service_name}\n";
    $body .= "Ort: {$city}\n\n";
    
    $body .= "KONTAKTUPPGIFTER\n";
    $body .= "----------------\n";
    $body .= "Namn: {$name}\n";
    $body .= "Telefon: {$phone}\n";
    $body .= "Kontaktsätt: {$contact_text}\n\n";
    
    $body .= "UPPDRAGSDETALJER\n";
    $body .= "----------------\n";
    
    if ($service === 'hemstadning') {
        $body .= "Bostadsyta: {$area} kvm\n";
        $body .= "Städfrekvens: {$frequency_name}\n";
        $body .= "Husdjur: " . ($pets === 'ja' ? 'Ja' : 'Nej') . "\n";
    } elseif ($service === 'tradgard') {
        $body .= "Tjänster: {$garden_services}\n";
    } elseif ($service === 'snickeri' || $service === 'malning') {
        $body .= "Beskrivning: {$description}\n";
        $body .= "Tidsram: {$timeline_name}\n";
    }
    
    if (!empty($notes)) {
        $body .= "\nÖvrigt: {$notes}\n";
    }
    
    $body .= "\n--------------------------------\n";
    $body .= "Skickat från intresseanmälan-wizard\n";
    $body .= "Tidpunkt: " . current_time('Y-m-d H:i:s') . "\n";
    
    // Email headers
    $to = 'info@seniorbolaget.se';
    $subject = "[Ny förfrågan] {$service_name} - {$city}";
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: Seniorbolaget <no-reply@seniorbolaget.se>'
    ];
    
    // Send email
    $sent = wp_mail($to, $subject, $body, $headers);
    
    if ($sent) {
        wp_send_json_success(['message' => 'Förfrågan skickad!']);
    } else {
        // Log error for debugging
        error_log('Seniorbolaget wizard: Failed to send email for ' . $name . ' (' . $phone . ')');
        wp_send_json_error(['message' => 'Kunde inte skicka förfrågan. Ring oss på 010-175 19 00.']);
    }
}



// ===== JOBBANSÖKAN WIZARD CSS (WAS-74) =====
function seniorbolaget_job_wizard_css() {
    ?>
    <style id="seniorbolaget-job-wizard-css">
    /* Job Wizard Container */
    .job-wizard-container[x-cloak]{display:none!important}
    .job-wizard-container{display:block!important;font-family:Inter,-apple-system,BlinkMacSystemFont,sans-serif!important;background:#FFF4F2!important;padding:60px 24px!important;width:100vw!important;max-width:none!important;margin:0!important;margin-left:calc(50% - 50vw)!important;box-sizing:border-box!important}
    .job-wizard-container *,.job-wizard-container *::before,.job-wizard-container *::after{box-sizing:border-box!important}
    .job-wizard-inner{display:block!important;max-width:560px!important;width:100%!important;margin:0 auto!important;padding:0!important}
    
    /* Header */
    .job-wizard-header{text-align:center!important;margin-bottom:28px!important}
    .job-wizard-title{font-family:Rubik,sans-serif!important;font-size:clamp(1.5rem,4vw,2rem)!important;font-weight:700!important;color:#1F2937!important;margin:0 0 8px!important;line-height:1.2!important}
    .job-wizard-subtitle{font-size:1rem!important;color:#6B7280!important;margin:0!important}
    
    /* Stepper */
    .job-stepper{margin-bottom:32px!important}
    .job-stepper-steps{display:flex!important;justify-content:center!important;align-items:flex-start!important;gap:0!important;margin-bottom:12px!important}
    .job-stepper-step{display:flex!important;flex-direction:column!important;align-items:center!important;gap:8px!important;min-width:60px!important}
    .job-stepper-dot{width:14px!important;height:14px!important;border-radius:50%!important;background:#e5e7eb!important;transition:all .3s!important;border:2px solid transparent!important}
    .job-stepper-step.active .job-stepper-dot{background:#C91C22!important;border-color:#C91C22!important;box-shadow:0 0 0 4px rgba(201,28,34,0.15)!important}
    .job-stepper-step.completed .job-stepper-dot{background:#C91C22!important;border-color:#C91C22!important}
    .job-stepper-name{font-size:12px!important;color:#9CA3AF!important;font-weight:500!important;text-align:center!important;transition:color .3s!important}
    .job-stepper-step.active .job-stepper-name,.job-stepper-step.completed .job-stepper-name{color:#1F2937!important;font-weight:600!important}
    .job-stepper-line{flex:1!important;height:2px!important;background:#e5e7eb!important;margin:7px 8px 0!important;max-width:40px!important;transition:background .3s!important}
    .job-stepper-line.completed{background:#C91C22!important}
    .job-step-counter{text-align:center!important;font-size:14px!important;color:#6B7280!important;margin:0!important;font-weight:500!important}
    
    /* Back button */
    .job-back-btn{display:inline-flex!important;align-items:center!important;gap:8px!important;color:#4B5563!important;font-size:.9375rem!important;font-weight:600!important;background:#fff!important;border:2px solid #e5e7eb!important;border-radius:50px!important;cursor:pointer!important;padding:10px 20px!important;margin-bottom:20px!important;transition:all .2s!important}
    .job-back-btn:hover{border-color:#C91C22!important;color:#C91C22!important;background:#fff!important}
    
    /* City Select */
    .job-city-select{margin-bottom:24px!important}
    .job-select-input{width:100%!important;padding:16px 20px!important;border:2px solid #e5e7eb!important;border-radius:50px!important;font-size:1rem!important;font-family:Inter,sans-serif!important;color:#1F2937!important;background:#fff!important;cursor:pointer!important;appearance:none!important;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E")!important;background-repeat:no-repeat!important;background-position:right 16px center!important;background-size:20px!important}
    .job-select-input:focus{outline:none!important;border-color:#C91C22!important}
    
    /* Service Cards */
    .job-service-cards{display:grid!important;grid-template-columns:1fr!important;gap:12px!important}
    .job-service-card{display:flex!important;align-items:center!important;gap:16px!important;padding:18px 22px!important;background:#fff!important;border:2px solid #e5e7eb!important;border-radius:16px!important;cursor:pointer!important;transition:all .2s!important}
    .job-service-card:hover{border-color:#C91C22!important;transform:translateY(-2px)!important;box-shadow:0 8px 24px -8px rgba(201,28,34,0.15)!important}
    .job-service-card.selected{border-color:#C91C22!important;background:#fff!important;border-width:3px!important}
    .job-service-icon{font-size:1.75rem!important;width:44px!important;text-align:center!important;flex-shrink:0!important}
    .job-service-info{flex:1!important}
    .job-service-name{font-family:Rubik,sans-serif!important;font-size:1.0625rem!important;font-weight:600!important;color:#1F2937!important;margin:0 0 2px!important}
    .job-service-desc{font-size:.8125rem!important;color:#6B7280!important;margin:0!important}
    
    /* Experience Cards */
    .job-experience-cards{display:grid!important;grid-template-columns:repeat(3,1fr)!important;gap:16px!important}
    .job-exp-card{display:flex!important;flex-direction:column!important;align-items:center!important;justify-content:center!important;padding:28px 20px!important;background:#fff!important;border:2px solid #e5e7eb!important;border-radius:16px!important;cursor:pointer!important;transition:all .2s!important}
    .job-exp-card:hover{border-color:#C91C22!important;transform:translateY(-2px)!important;box-shadow:0 8px 24px -8px rgba(201,28,34,0.15)!important}
    .job-exp-card.selected{border-color:#C91C22!important;background:#fff!important;border-width:3px!important}
    .job-exp-years{font-family:Rubik,sans-serif!important;font-size:2rem!important;font-weight:700!important;color:#C91C22!important;line-height:1!important}
    .job-exp-label{font-size:.875rem!important;color:#6B7280!important;margin-top:4px!important}
    
    /* Form inputs */
    .job-form-group{margin-bottom:18px!important}
    .job-form-label{display:block!important;font-family:Rubik,sans-serif!important;font-size:.9375rem!important;font-weight:600!important;color:#1F2937!important;margin-bottom:8px!important}
    .job-form-input{width:100%!important;padding:14px 18px!important;border:2px solid #e5e7eb!important;border-radius:50px!important;font-size:1rem!important;font-family:Inter,sans-serif!important;color:#1F2937!important;background:#fff!important}
    .job-form-input:focus{outline:none!important;border-color:#C91C22!important}
    
    /* GDPR */
    .job-gdpr-check{display:flex!important;align-items:flex-start!important;gap:12px!important;padding:16px!important;background:#fff!important;border-radius:12px!important;margin-top:20px!important}
    .job-gdpr-check input{width:22px!important;height:22px!important;accent-color:#C91C22!important;margin-top:2px!important;flex-shrink:0!important}
    .job-gdpr-text{font-size:.875rem!important;color:#4B5563!important;line-height:1.5!important}
    .job-gdpr-text a{color:#C91C22!important}
    
    /* Submit button */
    .job-submit-btn{width:100%!important;padding:18px 32px!important;background:#C91C22!important;color:#fff!important;border:none!important;border-radius:50px!important;font-size:1.125rem!important;font-weight:700!important;font-family:Rubik,sans-serif!important;cursor:pointer!important;transition:background .2s!important;margin-top:16px!important;display:flex!important;align-items:center!important;justify-content:center!important;gap:8px!important}
    .job-submit-btn:hover:not(:disabled){background:#a01519!important}
    .job-submit-btn:disabled{background:#ccc!important;cursor:not-allowed!important}
    
    /* Error */
    .job-error-msg{background:#fee2e2!important;color:#991b1b!important;padding:12px 16px!important;border-radius:8px!important;font-size:.875rem!important;margin-bottom:16px!important}
    
    /* Thank you */
    .job-thank-you{text-align:center!important;padding:40px 24px!important;background:#fff!important;border-radius:20px!important}
    .job-thank-icon{width:80px!important;height:80px!important;background:#d4edda!important;border-radius:50%!important;display:flex!important;align-items:center!important;justify-content:center!important;margin:0 auto 24px!important;font-size:2.5rem!important;color:#155724!important}
    .job-thank-title{font-family:Rubik,sans-serif!important;font-size:1.5rem!important;font-weight:700!important;color:#1F2937!important;margin:0 0 12px!important}
    .job-thank-text{font-size:1rem!important;color:#6B7280!important;margin:0 0 24px!important;line-height:1.6!important}
    .job-thank-summary{background:#FAFAF8!important;border-radius:12px!important;padding:20px!important;text-align:left!important;margin-bottom:24px!important}
    .job-summary-row{display:flex!important;justify-content:space-between!important;padding:8px 0!important;border-bottom:1px solid #e5e7eb!important;font-size:.9375rem!important}
    .job-summary-row:last-child{border-bottom:none!important}
    .job-summary-label{color:#6B7280!important}
    .job-summary-value{color:#1F2937!important;font-weight:500!important}
    .job-back-home-btn{display:inline-block!important;padding:14px 28px!important;background:#C91C22!important;color:#fff!important;border-radius:50px!important;font-weight:600!important;text-decoration:none!important}
    .job-back-home-btn:hover{background:#a01519!important}
    
    /* Trust bar */
    .job-trust-bar{display:flex!important;justify-content:center!important;gap:20px!important;flex-wrap:wrap!important;margin-top:32px!important;padding-top:24px!important;border-top:1px solid rgba(201,28,34,0.15)!important}
    .job-trust-item{display:inline-flex!important;align-items:center!important;gap:6px!important;font-size:.875rem!important;color:#4B5563!important}
    .job-trust-check{color:#C91C22!important;font-weight:bold!important}
    .job-phone-banner{text-align:center!important;padding:16px!important;font-size:1rem!important;color:#4B5563!important;margin-top:16px!important}
    .job-phone-banner a{color:#C91C22!important;font-weight:700!important;text-decoration:none!important}
    
    /* Spinner */
    .job-spinner{display:inline-block!important;width:20px!important;height:20px!important;border:3px solid #fff!important;border-top-color:transparent!important;border-radius:50%!important;animation:jobspin .8s linear infinite!important}
    @keyframes jobspin{to{transform:rotate(360deg)}}
    
    /* Responsive */
    @media(max-width:480px){
        .job-stepper-step{min-width:50px!important}
        .job-stepper-name{font-size:11px!important}
        .job-stepper-line{max-width:20px!important;margin:7px 4px 0!important}
        .job-experience-cards{grid-template-columns:1fr!important}
        .job-exp-card{flex-direction:row!important;justify-content:flex-start!important;gap:12px!important;padding:20px 24px!important}
        .job-trust-bar{flex-direction:column!important;gap:10px!important;align-items:center!important}
    }
    </style>
    <?php
}
add_action('wp_head', 'seniorbolaget_job_wizard_css');

// ===== JOBBANSÖKAN WIZARD JS (WAS-74) =====
function seniorbolaget_job_wizard_js() {
    ?>
    <script>
    window.jobWizardApp = function() {
        return {
            step: 1,
            isSubmitting: false,
            errorMsg: '',
            
            cities: [
                { name: 'Åmål', value: 'amal' },
                { name: 'Borås', value: 'boras' },
                { name: 'Eskilstuna', value: 'eskilstuna' },
                { name: 'Falkenberg', value: 'falkenberg' },
                { name: 'Göteborg', value: 'goteborg' },
                { name: 'Halmstad', value: 'halmstad' },
                { name: 'Helsingborg', value: 'helsingborg' },
                { name: 'Jönköping', value: 'jonkoping' },
                { name: 'Karlstad', value: 'karlstad' },
                { name: 'Kristianstad', value: 'kristianstad' },
                { name: 'Kungsbacka', value: 'kungsbacka' },
                { name: 'Kungälv', value: 'kungalv' },
                { name: 'Laholm/Båstad', value: 'laholm-bastad' },
                { name: 'Landskrona', value: 'landskrona' },
                { name: 'Lerum/Partille', value: 'lerum-partille' },
                { name: 'Mölndal/Härryda', value: 'molndal-harryda' },
                { name: 'Nässjö', value: 'nassjo' },
                { name: 'Örebro', value: 'orebro' },
                { name: 'Skövde', value: 'skovde' },
                { name: 'Stenungsund', value: 'stenungsund' },
                { name: 'Sundsvall', value: 'sundsvall' },
                { name: 'Torsby', value: 'torsby' },
                { name: 'Trelleborg', value: 'trelleborg' },
                { name: 'Trollhättan', value: 'trollhattan' },
                { name: 'Ulricehamn', value: 'ulricehamn' },
                { name: 'Varberg', value: 'varberg' }
            ],
            
            formData: {
                city: '',
                service: '',
                experience: '',
                name: '',
                phone: '',
                email: '',
                gdprConsent: false
            },
            
            selectService(service) {
                this.formData.service = service;
                this.step = 3;
            },
            
            selectExperience(exp) {
                this.formData.experience = exp;
                this.step = 4;
            },
            
            getServiceName() {
                const names = {
                    'stadning': 'Städning',
                    'tradgard': 'Trädgård',
                    'snickeri': 'Snickeri',
                    'malning': 'Målning',
                    'flera': 'Flera tjänster'
                };
                return names[this.formData.service] || '';
            },
            
            getCityName() {
                const city = this.cities.find(c => c.value === this.formData.city);
                return city ? city.name : '';
            },
            
            canSubmit() {
                return this.formData.name && 
                       this.formData.phone && 
                       this.formData.email && 
                       this.formData.gdprConsent;
            },
            
            async submitForm() {
                if (!this.canSubmit()) return;
                
                this.isSubmitting = true;
                this.errorMsg = '';
                
                const data = new FormData();
                data.append('action', 'sb_job_application');
                data.append('city', this.formData.city);
                data.append('service', this.formData.service);
                data.append('experience', this.formData.experience);
                data.append('name', this.formData.name);
                data.append('phone', this.formData.phone);
                data.append('email', this.formData.email);
                
                try {
                    const response = await fetch('/wp-admin/admin-ajax.php', {
                        method: 'POST',
                        body: data
                    });
                    const result = await response.json();
                    
                    if (result.success) {
                        this.step = 5;
                    } else {
                        this.errorMsg = result.data?.message || 'Något gick fel. Försök igen eller ring oss.';
                    }
                } catch (error) {
                    this.errorMsg = 'Kunde inte skicka ansökan. Kontrollera din internetanslutning.';
                }
                
                this.isSubmitting = false;
            }
        }
    }
    </script>
    <?php
}
add_action('wp_head', 'seniorbolaget_job_wizard_js', 99);

// ===== JOBBANSÖKAN AJAX HANDLER (WAS-74) =====
add_action('wp_ajax_sb_job_application', 'sb_job_application_handler');
add_action('wp_ajax_nopriv_sb_job_application', 'sb_job_application_handler');

function sb_job_application_handler() {
    $city = sanitize_text_field($_POST['city'] ?? '');
    $service = sanitize_text_field($_POST['service'] ?? '');
    $experience = sanitize_text_field($_POST['experience'] ?? '');
    $name = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    
    if (empty($city) || empty($service) || empty($experience) || empty($name) || empty($phone) || empty($email)) {
        wp_send_json_error(['message' => 'Vänligen fyll i alla fält.']);
        return;
    }
    
    // Map values to readable names
    $service_names = [
        'stadning' => 'Städning',
        'tradgard' => 'Trädgård',
        'snickeri' => 'Snickeri',
        'malning' => 'Målning',
        'flera' => 'Flera tjänster'
    ];
    $service_name = $service_names[$service] ?? $service;
    
    $city_names = [
        'amal' => 'Åmål', 'boras' => 'Borås', 'eskilstuna' => 'Eskilstuna',
        'falkenberg' => 'Falkenberg', 'goteborg' => 'Göteborg', 'halmstad' => 'Halmstad',
        'helsingborg' => 'Helsingborg', 'jonkoping' => 'Jönköping', 'karlstad' => 'Karlstad',
        'kristianstad' => 'Kristianstad', 'kungsbacka' => 'Kungsbacka', 'kungalv' => 'Kungälv',
        'laholm-bastad' => 'Laholm/Båstad', 'landskrona' => 'Landskrona',
        'lerum-partille' => 'Lerum/Partille', 'molndal-harryda' => 'Mölndal/Härryda',
        'nassjo' => 'Nässjö', 'orebro' => 'Örebro', 'skovde' => 'Skövde',
        'stenungsund' => 'Stenungsund', 'sundsvall' => 'Sundsvall', 'torsby' => 'Torsby',
        'trelleborg' => 'Trelleborg', 'trollhattan' => 'Trollhättan',
        'ulricehamn' => 'Ulricehamn', 'varberg' => 'Varberg'
    ];
    $city_name = $city_names[$city] ?? $city;
    
    // Build email
    $body = "NY JOBBANSÖKAN FRÅN JOBBA MED OSS\n";
    $body .= "==================================\n\n";
    $body .= "SÖKANDE\n";
    $body .= "-------\n";
    $body .= "Namn: {$name}\n";
    $body .= "Telefon: {$phone}\n";
    $body .= "E-post: {$email}\n\n";
    $body .= "UPPGIFTER\n";
    $body .= "---------\n";
    $body .= "Stad: {$city_name}\n";
    $body .= "Tjänst: {$service_name}\n";
    $body .= "Erfarenhet: {$experience} år\n\n";
    $body .= "--------------------------------\n";
    $body .= "Skickat från jobbansökan-wizard\n";
    $body .= "Tidpunkt: " . current_time('Y-m-d H:i:s') . "\n";
    
    $to = 'info@seniorbolaget.se';
    $subject = "[Jobbansökan] {$name} - {$city_name} ({$service_name})";
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: Seniorbolaget <no-reply@seniorbolaget.se>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    ];
    
    $sent = wp_mail($to, $subject, $body, $headers);
    
    if ($sent) {
        wp_send_json_success(['message' => 'Ansökan skickad!']);
    } else {
        error_log('Seniorbolaget job wizard: Failed to send email for ' . $name . ' (' . $email . ')');
        wp_send_json_error(['message' => 'Kunde inte skicka ansökan. Ring oss på 010-175 19 00.']);
    }
}

// ===== INTENTIONS BAR (WAS-68) — inline script approach =====
function sb_add_fab() {
    echo '<style>
#sb-fab{position:fixed !important;bottom:24px !important;right:24px !important;z-index:99999 !important;display:flex !important;flex-direction:column;align-items:flex-end;gap:10px;}
#sb-fab-menu{display:flex;flex-direction:column;gap:8px;align-items:flex-end;opacity:0;transform:translateY(12px);transition:opacity .25s,transform .3s cubic-bezier(.16,1,.3,1);pointer-events:none;}
#sb-fab-menu.open{opacity:1;transform:translateY(0);pointer-events:all;}
.sb-fab-opt{display:inline-flex;align-items:center;gap:8px;padding:12px 22px;border-radius:50px;font-family:Rubik,sans-serif;font-size:.9375rem;font-weight:600;text-decoration:none;white-space:nowrap;box-shadow:0 4px 16px rgba(0,0,0,0.18);transition:transform .15s,box-shadow .15s;}
.sb-fab-opt:hover{transform:translateY(-2px);box-shadow:0 6px 22px rgba(0,0,0,0.25);}
.sb-fab-opt-r{background:#C91C22;color:#fff;}
.sb-fab-opt-o{background:#fff;color:#1F2937;border:1.5px solid #e5e7eb;}
#sb-fab-btn{display:inline-flex;align-items:center;gap:8px;background:#C91C22;color:#fff;font-family:Rubik,sans-serif;font-size:1rem;font-weight:700;padding:14px 26px;border-radius:50px;border:none;cursor:pointer;box-shadow:0 4px 24px rgba(201,28,34,.5);transition:transform .15s,box-shadow .15s,background .2s;}
#sb-fab-btn:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(201,28,34,.55);}
#sb-fab-btn.open{background:#1F2937;box-shadow:0 4px 20px rgba(0,0,0,.3);}
#sb-fab-btn.on-red{background:#fff;color:#C91C22;box-shadow:0 4px 24px rgba(0,0,0,.2);}
#sb-fab-btn.on-red:hover{box-shadow:0 8px 28px rgba(0,0,0,.28);}
#sb-fab-btn.on-red svg{stroke:#C91C22;}
@media(max-width:480px){#sb-fab{bottom:16px;right:16px;}.sb-fab-opt,#sb-fab-btn{font-size:.875rem;padding:11px 18px;}}
/* Fix WAS-175: Ge mobilt innehåll utrymme under FAB */
@media(max-width:768px){main,.wp-block-group.alignfull:last-of-type,.entry-content{padding-bottom:80px !important;}}
</style>
<div id="sb-fab" style="display:flex!important;position:fixed!important;bottom:24px;right:24px;z-index:99999;flex-direction:column;align-items:flex-end;gap:10px;">
  <div id="sb-fab-menu">
    <a href="/bli-franchisetagare/" class="sb-fab-opt sb-fab-opt-o">🏢 Bli franchisetagare</a>
    <a href="/jobba-med-oss/" class="sb-fab-opt sb-fab-opt-o">👴 Jobba hos oss</a>
    <a href="/intresseanmalan/" class="sb-fab-opt sb-fab-opt-r">🧹 Boka hjälp</a>
  </div>
  <button id="sb-fab-btn" onclick="sbFab()" aria-expanded="false" aria-label="Öppna meny">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.89 9.11a19.79 19.79 0 01-3.07-8.67A2 2 0 012.81 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 9.91a16 16 0 006.11 6.11l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
    Boka hjälp
  </button>
</div>
<script>
(function(){
  var CLOSE_SVG=\'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Stäng\';
  var OPEN_SVG=\'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.89 9.11a19.79 19.79 0 01-3.07-8.67A2 2 0 012.81 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 9.91a16 16 0 006.11 6.11l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg> Boka hjälp\';
  function sbFab(){
    var m=document.getElementById("sb-fab-menu"),b=document.getElementById("sb-fab-btn");
    var o=m.classList.toggle("open");
    b.classList.toggle("open",o);
    b.setAttribute("aria-expanded",o);
    b.innerHTML=o?CLOSE_SVG:OPEN_SVG;
  }
  window.sbFab=sbFab;

  // Byt FAB till vit när den rullar över röda sektioner
  function sbFabColorCheck(){
    var btn=document.getElementById("sb-fab-btn");
    if(!btn||btn.classList.contains("open"))return;
    var r=btn.getBoundingClientRect();
    var cx=r.left+r.width/2, cy=r.top+r.height/2;
    btn.style.visibility="hidden";
    var el=document.elementFromPoint(cx,cy);
    btn.style.visibility="";
    if(!el)return;
    var cur=el;
    while(cur&&cur!==document.body){
      var bg=window.getComputedStyle(cur).backgroundColor;
      if(bg&&bg!=="rgba(0, 0, 0, 0)"&&bg!=="transparent"){
        var m=bg.match(/\d+/g);
        var isRed=m&&parseInt(m[0])>160&&parseInt(m[1])<60&&parseInt(m[2])<60;
        btn.classList.toggle("on-red",!!isRed);
        return;
      }
      cur=cur.parentElement;
    }
    btn.classList.remove("on-red");
  }
  window.addEventListener("scroll",sbFabColorCheck,{passive:true});
  window.addEventListener("resize",sbFabColorCheck,{passive:true});
  document.addEventListener("DOMContentLoaded",sbFabColorCheck);
  setTimeout(sbFabColorCheck,300);

  document.addEventListener("click",function(e){
    var fab=document.getElementById("sb-fab");
    if(fab&&!fab.contains(e.target)){
      var m=document.getElementById("sb-fab-menu"),b=document.getElementById("sb-fab-btn");
      if(m.classList.contains("open")){
        m.classList.remove("open");b.classList.remove("open");
        b.setAttribute("aria-expanded","false");b.innerHTML=OPEN_SVG;
      }
    }
  });
})();
</script>';
}
add_action( 'wp_footer', 'sb_add_fab', 100 );



// ===== GLOBAL BUTTON SLIDE-REVEAL (WAS-71) =====
function sb_global_button_animation() {
    ?>
<style>
/* ButtonCreativeTop — global slide-reveal */
.wp-block-button__link {
    position: relative !important;
    overflow: hidden !important;
    isolation: isolate !important;
}
.wp-block-button__link .sb-btn-label {
    display: block;
    transition: transform 0.32s cubic-bezier(.16,1,.3,1), opacity 0.32s ease;
    will-change: transform;
}
.wp-block-button__link:hover .sb-btn-label {
    transform: translateY(-130%);
    opacity: 0;
}
.wp-block-button__link .sb-btn-fill {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: translateY(110%);
    transition: transform 0.32s cubic-bezier(.16,1,.3,1);
    background: rgba(0,0,0,0.18);
    border-radius: inherit;
    will-change: transform;
}
.wp-block-button__link:hover .sb-btn-fill {
    transform: translateY(0);
}
</style>
<script>
(function(){
    var done = false;
    function wrapBtns() {
        if(done) return; done = true;
        document.querySelectorAll('.wp-block-button__link').forEach(function(btn) {
            if(btn.querySelector('.sb-btn-label')) return;
            var label = btn.textContent.trim();
            btn.innerHTML =
                '<span class="sb-btn-label">' + label + '</span>' +
                '<span class="sb-btn-fill" aria-hidden="true">' + label + '</span>';
        });
    }
    if(document.readyState !== 'loading') { wrapBtns(); }
    else { document.addEventListener('DOMContentLoaded', wrapBtns); }
})();
</script>
<?php
}
add_action('wp_footer', 'sb_global_button_animation', 99);


// ===== FIX WPTEXTURIZE MANGLING ALPINE.JS ATTRIBUTES =====
// Moved to WAS-200 template_redirect ob_start (combined with lazy loading)


// ===== WAS-82: Stadssidor mobil overflow fix =====
function sb_overflow_fix() {
    echo '<style>
    @media (max-width: 600px) {
        body { overflow-x: hidden !important; }
        .wp-block-group, section, article, .wp-block-html { max-width: 100vw !important; box-sizing: border-box !important; }
        /* Hero bottom flex-rad */
        div[style*="justify-content:space-between"][style*="flex-wrap:wrap"] {
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        /* Badge-rader */
        div[style*="display:flex"][style*="gap:12px"] {
            flex-wrap: wrap !important;
            max-width: 100% !important;
        }
    }
    </style>';
}
add_action('wp_head', 'sb_overflow_fix', 5);

// ===== SITE TITLE =====
add_theme_support('title-tag');
add_filter('pre_get_document_title', function($title) {
    $site_name = get_bloginfo('name', 'display');
    $page_title = is_front_page() ? $site_name : (get_the_title() . ' — ' . $site_name);
    return $page_title ?: $site_name;
}, 20);


// ===== WAS-54: SEO META TITLES & DESCRIPTIONS =====
function sb_seo_meta() {
    global $post;
    
    // Handle front page specially (may not have $post or may be posts page)
    if (is_front_page()) {
        add_filter('pre_get_document_title', function() { return 'Seniorbolaget — Hushållsnära tjänster av erfarna seniorer'; }, 25);
        echo '<meta name="description" content="Boka hemstädning, trädgård, snickeri och målning av erfarna seniorer. RUT-avdrag direkt. Svar inom 2h. Verifierade franchisetagare nära dig.">' . "\n";
        echo '<meta property="og:title" content="Seniorbolaget — Hushållsnära tjänster av erfarna seniorer">' . "\n";
        echo '<meta property="og:description" content="Boka hemstädning, trädgård, snickeri och målning av erfarna seniorer. RUT-avdrag direkt. Svar inom 2h. Verifierade franchisetagare nära dig.">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta name="robots" content="index, follow">' . "\n";
        // WAS-188: og:image på startsidan (hero_main, media ID 10)
        $hero_url = wp_get_attachment_url(10);
        if ($hero_url) {
            echo '<meta property="og:image" content="' . esc_url($hero_url) . '" />' . "\n";
            echo '<meta property="og:image:width" content="1200" />' . "\n";
            echo '<meta property="og:image:height" content="630" />' . "\n";
        }
        return;
    }
    
    if (!is_singular() || !$post) return;
    
    $slug = $post->post_name;
    
    $seo = [
        // Huvudsidor (correct slugs from WP database)
        'hemstadning' => ['Hemstädning med RUT-avdrag — Seniorbolaget', 'Professionell hemstädning utförd av erfarna seniorer. RUT-avdrag ger dig 50% rabatt. Boka idag — svar inom 24h.'], // WAS-145/179/211
        'hemstad' => ['Hemstädning med RUT-avdrag — Seniorbolaget', 'Boka hemstädning av erfarna seniorer. Du betalar bara 50% efter RUT-avdrag. Regelbunden eller engångsstädning. Svar inom 2h.'],
        'tradgard' => ['Trädgårdshjälp av erfarna seniorer — Seniorbolaget', 'Gräsklippning, häck, ogräs och trädgårdsskötsel. Erfarna seniorer nära dig. RUT-avdrag. Boka idag.'],
        'malning-tapetsering' => ['Målning inomhus & utomhus — Seniorbolaget', 'Professionell målning av erfarna hantverkare. Inomhus och utomhus. ROT-avdrag. Kostnadsfri offert.'],
        'snickeri' => ['Snickeri & byggtjänster — Seniorbolaget', 'Erfarna snickare för allt från hyllor till renoveringar. ROT-avdrag. Kostnadsfri offert. Svar inom 2h.'],
        'privat' => ['Hushållsnära tjänster för privatpersoner — Seniorbolaget', 'Hushållsnära tjänster av erfarna seniorer. RUT/ROT-avdrag. Verifierade franchisetagare. Boka idag.'],
        'foretag' => ['Företagstjänster & B2B — Seniorbolaget', 'Pålitlig bemanning, städning och underhåll för företag och BRF. Erfarna seniorer. Faktura 30 dagar.'],
        'om-oss' => ['Om Seniorbolaget — Erfarna seniorer gör skillnad', 'Vi matchar erfarna seniorer med hushåll och företag som behöver pålitlig hjälp. Läs om vår historia och vision.'],
        'jobba-med-oss' => ['Jobba med Seniorbolaget, meningsfullt arbete för seniorer', 'Älskar du att hjälpa andra? Jobba som personal för hushållsnära tjänster med Seniorbolaget. Flexibla tider, bra betalt, meningsfullt.'],
        'bli-franchisetagare' => ['Bli franchisetagare, starta eget med Seniorbolaget', 'Starta din egen verksamhet under Seniorbolaget-varumärket. Beprövat koncept, stöd och utbildning ingår. Kostnadsfritt informationsmöte.'],
        'har-finns-vi' => ['Hitta Seniorbolaget nära dig, 26 orter i Sverige', 'Seniorbolaget finns i 26 städer. Hitta din lokala franchisetagare och boka hushållsnära tjänster direkt.'],
        'kontakt' => ['Kontakta Seniorbolaget, ring eller boka online', 'Ring oss på 010-175 19 00 eller skicka en förfrågan. Vi svarar inom 24 h på vardagar.'],
        'intresse-anmalan' => ['Boka hushållsnära tjänster, Seniorbolaget', 'Välj tjänst, ort och kontaktuppgifter. Vi återkommer inom 24 h med offert. Kostnadsfritt och utan förbindelser.'],
    ];
    
    // Stadssidor — generera dynamiskt (correct slugs from WP database)
    $city_names = [
        'amal'=>'Åmål','boras'=>'Borås','eskilstuna'=>'Eskilstuna',
        'falkenberg'=>'Falkenberg','goteborg'=>'Göteborg','halmstad'=>'Halmstad',
        'helsingborg'=>'Helsingborg','jonkoping'=>'Jönköping','karlstad'=>'Karlstad',
        'kristianstad'=>'Kristianstad','kungsbacka'=>'Kungsbacka','kungalv'=>'Kungälv',
        'laholm-bastad'=>'Laholm/Båstad','landskrona'=>'Landskrona','lerum-partille'=>'Lerum/Partille',
        'molndal-harryda'=>'Mölndal/Härryda','nassjo'=>'Nässjö','orebro'=>'Örebro',
        'skovde'=>'Skövde','stenungsund'=>'Stenungsund','sundsvall'=>'Sundsvall',
        'torsby'=>'Torsby','trelleborg'=>'Trelleborg','trollhattan'=>'Trollhättan',
        'ulricehamn'=>'Ulricehamn','varberg'=>'Varberg',
    ];
    
    foreach ($city_names as $city_slug => $city_name) {
        $seo[$city_slug] = [
            "Hushållsnära tjänster i {$city_name} — Seniorbolaget",
            "Boka hemstädning, trädgård eller snickeri i {$city_name} av erfarna seniorer. Lokal franchisetagare nära dig. RUT-avdrag. Svar inom 2h."
        ];
    }
    
    if (!isset($seo[$slug])) return;
    [$title, $desc] = $seo[$slug];
    
    // Override title
    add_filter('pre_get_document_title', function() use ($title) { return $title; }, 25);
    
    // Lägg till meta description
    echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta name="robots" content="index, follow">' . "\n";
}
add_action('wp_head', 'sb_seo_meta', 1);


// ===== WAS-55: SCHEMA MARKUP — LocalBusiness + Service + FAQ =====
function sb_schema_markup() {
    global $post;
    if (!is_singular() || !$post) return;
    $slug = $post->post_name;
    $current_url = get_permalink();
    
    // Organization/LocalBusiness schema (alla sidor)
    $org_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'Seniorbolaget',
        'description' => 'Hushållsnära tjänster utförda av erfarna seniorer',
        'url' => 'https://seniorbolaget.se',
        'telephone' => '+46101751900',
        'email' => 'info@seniorbolaget.se',
        'address' => [ // WAS-190
            '@type' => 'PostalAddress',
            'addressLocality' => 'Sverige',
            'addressCountry' => 'SE',
        ],
        'areaServed' => [
            '@type' => 'Country',
            'name' => 'Sweden',
        ],
        'priceRange' => '$$',
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => 'Hushållsnära tjänster',
            'itemListElement' => [
                ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>'Hemstädning']],
                ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>'Trädgård']],
                ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>'Snickeri']],
                ['@type'=>'Offer','itemOffered'=>['@type'=>'Service','name'=>'Målning']],
            ]
        ],
        'sameAs' => ['https://seniorbolaget.se'],
    ];
    echo '<script type="application/ld+json">' . json_encode($org_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    
    // Service schema per tjänstesida (correct slugs from WP database)
    $service_schemas = [
        'hemstad'            => ['name'=>'Hemstädning','description'=>'Professionell hemstädning av erfarna seniorer med RUT-avdrag'],
        'tradgard'           => ['name'=>'Trädgård','description'=>'Trädgårdshjälp av erfarna seniorer — gräsklippning, häck och mer'],
        'malning-tapetsering'=> ['name'=>'Målning','description'=>'Inomhus och utomhus målning av erfarna hantverkare'],
        'snickeri'           => ['name'=>'Snickeri','description'=>'Snickeri och byggtjänster av erfarna hantverkare'],
    ];
    
    if (isset($service_schemas[$slug])) {
        $s = $service_schemas[$slug];
        $service_schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $s['name'],
            'description' => $s['description'],
            'url' => $current_url,
            'provider' => ['@type'=>'Organization','name'=>'Seniorbolaget'],
            'areaServed' => ['@type'=>'Country','name'=>'Sweden'],
            'offers' => ['@type'=>'Offer','availability'=>'https://schema.org/InStock'],
        ];
        echo '<script type="application/ld+json">' . json_encode($service_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
    
    // Startsida — FAQ schema
    if ($slug === 'hem' || is_front_page()) {
        $faq_schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                ['@type'=>'Question','name'=>'Vad är RUT-avdrag?','acceptedAnswer'=>['@type'=>'Answer','text'=>'RUT-avdrag är ett skatteavdrag för hushållstjänster. Du betalar bara 50% av arbetskostnaden, resten drar Seniorbolaget av direkt mot Skatteverket.']],
                ['@type'=>'Question','name'=>'Hur snabbt kan ni komma?','acceptedAnswer'=>['@type'=>'Answer','text'=>'Vi svarar på förfrågningar inom 2h och kan ofta boka tid redan samma vecka.']],
                ['@type'=>'Question','name'=>'Vilka städer finns ni i?','acceptedAnswer'=>['@type'=>'Answer','text'=>'Seniorbolaget finns i 26 städer i Sverige, från Sundsvall i norr till Trelleborg i söder.']],
                ['@type'=>'Question','name'=>'Vem utför jobbet?','acceptedAnswer'=>['@type'=>'Answer','text'=>'Alla uppdrag utförs av erfarna seniorer som är anställda och försäkrade via Seniorbolaget.']],
            ]
        ];
        echo '<script type="application/ld+json">' . json_encode($faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}
add_action('wp_head', 'sb_schema_markup', 2);


// ===== WAS-56: INTERN LÄNKNING — stadssidor ↔ tjänstesidor =====
function sb_internal_links() {
    global $post;
    if (!is_singular() || !$post) return;
    $slug = $post->post_name;
    
    // Alla stadsslugs (correct from WP database)
    $all_city_slugs = ['amal','boras','eskilstuna','falkenberg','goteborg','halmstad','helsingborg','jonkoping','karlstad','kristianstad','kungsbacka','kungalv','laholm-bastad','landskrona','lerum-partille','molndal-harryda','nassjo','orebro','skovde','stenungsund','sundsvall','torsby','trelleborg','trollhattan','ulricehamn','varberg'];
    // Correct service slugs from WP database
    $service_slugs = ['hemstad','tradgard','snickeri','malning-tapetsering'];
    
    // På stadssidor: länka till tjänstesidor
    if (in_array($slug, $all_city_slugs)) {
        $city_name = get_the_title();
        $services = [
            ['hemstad','🧹','Hemstädning'],
            ['tradgard','🌿','Trädgård'],
            ['snickeri','🔨','Snickeri'],
            ['malning-tapetsering','🎨','Målning'],
        ];
        echo '<div style="background:#F9FAFB;padding:48px clamp(24px,5vw,80px);text-align:center;">
            <h2 style="font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#1F2937;margin-bottom:8px;">Våra tjänster</h2>
            <p style="color:#6B7280;margin-bottom:32px;font-family:Inter,sans-serif;">Välj tjänst — vi levererar till ' . esc_html($city_name) . '</p>
            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">';
        foreach ($services as $svc) {
            $s_slug = $svc[0];
            $icon = $svc[1];
            $name = $svc[2];
            echo '<a href="/' . esc_attr($s_slug) . '/" style="display:flex;align-items:center;gap:8px;padding:14px 24px;background:#fff;border:2px solid #e5e7eb;border-radius:50px;text-decoration:none;color:#1F2937;font-family:Inter,sans-serif;font-weight:600;transition:all .2s;" onmouseover="this.style.borderColor=\'#C91C22\';this.style.color=\'#C91C22\'" onmouseout="this.style.borderColor=\'#e5e7eb\';this.style.color=\'#1F2937\'">' . $icon . ' ' . esc_html($name) . '</a>';
        }
        echo '</div></div>';
    }
    
    // På tjänstesidor: länka till 6 populäraste städer
    if (in_array($slug, $service_slugs)) {
        $cities = [
            ['goteborg','Göteborg'],['helsingborg','Helsingborg'],['varberg','Varberg'],
            ['boras','Borås'],['orebro','Örebro'],['halmstad','Halmstad'],
        ];
        $service_name = get_the_title();
        echo '<div style="background:#FFF4F2;padding:48px clamp(24px,5vw,80px);text-align:center;">
            <h2 style="font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#1F2937;margin-bottom:8px;">Välj din ort</h2>
            <p style="color:#6B7280;margin-bottom:32px;font-family:Inter,sans-serif;">' . esc_html($service_name) . ' finns i hela Sverige</p>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-bottom:16px;">';
        foreach ($cities as $city) {
            $c_slug = $city[0];
            $c_name = $city[1];
            echo '<a href="/' . esc_attr($c_slug) . '/" style="padding:10px 20px;background:#fff;border:1.5px solid #e5e7eb;border-radius:50px;text-decoration:none;color:#1F2937;font-family:Inter,sans-serif;font-size:0.9375rem;font-weight:500;transition:all .15s;" onmouseover="this.style.borderColor=\'#C91C22\';this.style.color=\'#C91C22\'" onmouseout="this.style.borderColor=\'#e5e7eb\';this.style.color=\'#1F2937\'">' . esc_html($c_name) . '</a>';
        }
        echo '</div>
            <a href="/har-finns-vi/" style="font-family:Inter,sans-serif;font-size:0.875rem;color:#C91C22;font-weight:600;text-decoration:none;">Se alla 26 orter →</a>
            </div>';
    }
}
add_action('wp_footer', 'sb_internal_links', 95);

// WAS-58: RUT/ROT-avdrag badge above the fold på tjänstesidor
function sb_rut_rot_badge() {
    if (!is_singular()) return;
    $slug = get_post_field('post_name', get_the_ID());
    $rut_slugs = ['hemstadning','tradgard'];
    $rot_slugs  = ['malning','snickeri'];
    if (!in_array($slug, array_merge($rut_slugs, $rot_slugs))) return;
    $label = in_array($slug, $rut_slugs) ? 'RUT-AVDRAG' : 'ROT-AVDRAG';
    ?>
    <script>
    (function() {
        function injectBadge() {
            var h1 = document.querySelector('h1');
            if (!h1 || document.querySelector('.sb-rut-badge')) return;
            var badge = document.createElement('div');
            badge.className = 'sb-rut-badge';
            badge.style.cssText = 'display:inline-flex;align-items:center;gap:10px;background:rgba(201,28,34,0.08);border:1.5px solid rgba(201,28,34,0.25);border-radius:50px;padding:8px 18px;margin:12px 0 4px;flex-wrap:wrap;';
            badge.innerHTML = '<span style="background:#C91C22;color:#fff;font-family:Rubik,sans-serif;font-size:0.75rem;font-weight:700;padding:4px 10px;border-radius:50px;letter-spacing:.5px;"><?php echo $label; ?></span><span style="font-family:Inter,sans-serif;font-size:0.9375rem;font-weight:600;color:#1F2937;">Du betalar bara 50% — resten drar vi av direkt</span>';
            h1.insertAdjacentElement('afterend', badge);
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', injectBadge);
        } else {
            injectBadge();
        }
    })();
    </script>
    <?php
}
add_action('wp_head', 'sb_rut_rot_badge', 5);

/**
 * Jobba-wizard via wp_footer (WAS-84 fix: flyttad från pattern för att undvika &gt; encoding)
 */
function sb_jobba_wizard() {
    if (!is_page('jobba-med-oss')) return;
    ?>
<style>
/* Hide old inline wizard (without id) and show new one */
.wizard-container:not(#jobba-wizard-rendered) { display: none !important; }
#jobba-wizard-rendered { display: flex !important; }
</style>
<script>
function jobWizardApp() {
    return ({
        step: 1,
        isSubmitting: false,
        errorMsg: '',
        citySearch: '',
        filteredJobCities: [],
        formData: {
            city: '', service: '', experience: '',
            name: '', phone: '', email: '', gdprConsent: false
        },
        // Helper functions to avoid > < in HTML attributes
        stepIcon(n) { return this.step > n ? '✓' : String(n); },
        stepDone(n) { return this.step > n; },
        stepBelow(n) { return this.step < n; },
        stepVal(n) { 
            if (this.step <= n) return '';
            if (n === 1) return this.getCityName();
            if (n === 2) return this.getServiceName();
            return '';
        },
        init() {
            this.filteredJobCities = this.cities;
        },
        filterJobCities() {
            const q = this.citySearch.toLowerCase();
            this.filteredJobCities = q 
                ? this.cities.filter(c => c.name.toLowerCase().includes(q))
                : this.cities;
        },
        cities: [
            {value:'amal',name:'Åmål'},{value:'boras',name:'Borås'},
            {value:'eskilstuna',name:'Eskilstuna'},{value:'falkenberg',name:'Falkenberg'},
            {value:'goteborg',name:'Göteborg'},{value:'halmstad',name:'Halmstad'},
            {value:'helsingborg',name:'Helsingborg'},{value:'jonkoping',name:'Jönköping'},
            {value:'karlstad',name:'Karlstad'},{value:'kristianstad',name:'Kristianstad'},
            {value:'kungsbacka',name:'Kungsbacka'},{value:'kungalv',name:'Kungälv'},
            {value:'laholm',name:'Laholm/Båstad'},{value:'landskrona',name:'Landskrona'},
            {value:'lerum',name:'Lerum/Partille'},{value:'molndal',name:'Mölndal/Härryda'},
            {value:'nassjo',name:'Nässjö'},{value:'orebro',name:'Örebro'},
            {value:'skovde',name:'Skövde'},{value:'stenungsund',name:'Stenungsund'},
            {value:'sundsvall',name:'Sundsvall'},{value:'torsby',name:'Torsby'},
            {value:'trelleborg',name:'Trelleborg'},{value:'trollhattan',name:'Trollhättan'},
            {value:'ulricehamn',name:'Ulricehamn'},{value:'varberg',name:'Varberg'}
        ],
        selectCity(val) { this.formData.city = val; setTimeout(() => this.step = 2, 200); },
        selectService(val) { this.formData.service = val; setTimeout(() => this.step = 3, 200); },
        selectExperience(val) { this.formData.experience = val; setTimeout(() => this.step = 4, 200); },
        getCityName() { return this.cities.find(c => c.value === this.formData.city)?.name || this.formData.city; },
        getServiceName() {
            const services = {'stadning':'Städning','tradgard':'Trädgård','snickeri':'Snickeri','malning':'Målning','flera':'Flera tjänster'};
            return services[this.formData.service] || this.formData.service;
        },
        getExperienceName() {
            const exp = {'nybörjare':'Ny i branschen','erfaren':'Erfaren (1–5 år)','veteran':'Veteran (5+ år)'};
            return exp[this.formData.experience] || this.formData.experience;
        },
        canSubmit() {
            return this.formData.name && this.formData.phone &&
                   this.formData.email && this.formData.gdprConsent;
        },
        submitForm() {
            if (!this.canSubmit()) { this.errorMsg = 'Fyll i alla fält och godkänn villkoren.'; return; }
            this.isSubmitting = true;
            this.errorMsg = '';
            fetch('/wp-admin/admin-post.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({
                    action: 'sb_job_application',
                    ...this.formData
                })
            }).then(() => {
                this.step = 5;
                this.isSubmitting = false;
            }).catch(() => {
                this.errorMsg = 'Något gick fel. Försök igen eller ring oss.';
                this.isSubmitting = false;
            });
        }
    });
}
</script>
<div id="jobba-wizard-rendered" class="wizard-container" x-data="jobWizardApp()" x-cloak>
    <div class="wizard-inner">
        
        <!-- Stepper (fixed: using helper functions) -->
        <div class="wiz-stepper" x-show="stepBelow(5)">
            <div class="wiz-step" :class="{ active: step === 1, completed: stepDone(1) }">
                <div class="wiz-step-circle" x-text="stepIcon(1)"></div>
                <div class="wiz-step-label">Stad</div>
                <div class="wiz-step-value" x-text="stepVal(1)"></div>
            </div>
            <div class="wiz-step-line" :class="{ completed: stepDone(1) }"></div>
            <div class="wiz-step" :class="{ active: step === 2, completed: stepDone(2) }">
                <div class="wiz-step-circle" x-text="stepIcon(2)"></div>
                <div class="wiz-step-label">Tjänst</div>
                <div class="wiz-step-value" x-text="stepVal(2)"></div>
            </div>
            <div class="wiz-step-line" :class="{ completed: stepDone(2) }"></div>
            <div class="wiz-step" :class="{ active: step === 3, completed: stepDone(3) }">
                <div class="wiz-step-circle" x-text="stepIcon(3)"></div>
                <div class="wiz-step-label">Erfarenhet</div>
                <div class="wiz-step-value"></div>
            </div>
            <div class="wiz-step-line" :class="{ completed: stepDone(3) }"></div>
            <div class="wiz-step" :class="{ active: step === 4, completed: stepDone(4) }">
                <div class="wiz-step-circle" x-text="stepIcon(4)"></div>
                <div class="wiz-step-label">Kontakt</div>
                <div class="wiz-step-value"></div>
            </div>
        </div>
        
        <!-- STEG 1: Välj stad -->
        <div x-show="step === 1" x-transition>
            <div class="wizard-header">
                <h2 class="wizard-title">Var vill du jobba?</h2>
                <p class="wizard-subtitle">Välj den ort som passar dig bäst</p>
            </div>
            
            <input type="text" x-model="citySearch" @input="filterJobCities()"
                placeholder="🔍 Sök stad..." class="city-search">
            <div class="city-list">
                <template x-for="city in filteredJobCities" :key="city.value">
                    <div class="city-item"
                        :class="{ selected: formData.city === city.value }"
                        @click="selectCity(city.value)"
                        x-text="city.name">
                    </div>
                </template>
            </div>
        </div>
        
        <!-- STEG 2: Välj tjänst -->
        <div x-show="step === 2" x-transition>
            <button class="back-btn" @click="step = 1" type="button"><span class="back-icon">←</span> Tillbaka</button>
            
            <div class="wizard-header">
                <h2 class="wizard-title">Vad kan du hjälpa med?</h2>
                <p class="wizard-subtitle">Välj den tjänst du vill jobba med</p>
            </div>
            
            <div class="svc-grid">
                <!-- Städning -->
                <div class="svc-card" @click="selectService('stadning')" :class="{ selected: formData.service === 'stadning' }">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="38" fill="#FFF4F2"/>
                            <rect x="36" y="20" width="8" height="36" rx="2" fill="#C91C22"/>
                            <ellipse cx="40" cy="58" rx="14" ry="6" fill="#C91C22" opacity="0.6"/>
                            <path d="M28 58 Q40 50 52 58" stroke="#C91C22" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <div class="svc-card-name">Städning</div>
                    <div class="svc-card-desc">Hemstädning och liknande</div>
                    <div class="svc-card-check">✓</div>
                </div>
                <!-- Trädgård -->
                <div class="svc-card" @click="selectService('tradgard')" :class="{ selected: formData.service === 'tradgard' }">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="38" fill="#F0FDF4"/>
                            <path d="M40 55 L40 35" stroke="#16A34A" stroke-width="3" stroke-linecap="round"/>
                            <ellipse cx="40" cy="28" rx="12" ry="10" fill="#16A34A"/>
                            <path d="M32 50 Q28 42 35 38" stroke="#16A34A" stroke-width="2" fill="none"/>
                            <path d="M48 50 Q52 42 45 38" stroke="#16A34A" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <div class="svc-card-name">Trädgård</div>
                    <div class="svc-card-desc">Gräsklippning, häck, ogräs</div>
                    <div class="svc-card-check">✓</div>
                </div>
                <!-- Snickeri -->
                <div class="svc-card" @click="selectService('snickeri')" :class="{ selected: formData.service === 'snickeri' }">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="38" fill="#FFFBEB"/>
                            <rect x="35" y="22" width="10" height="32" rx="2" fill="#D97706"/>
                            <rect x="28" y="18" width="24" height="8" rx="2" fill="#92400E"/>
                        </svg>
                    </div>
                    <div class="svc-card-name">Snickeri</div>
                    <div class="svc-card-desc">Reparationer och bygge</div>
                    <div class="svc-card-check">✓</div>
                </div>
                <!-- Målning -->
                <div class="svc-card" @click="selectService('malning')" :class="{ selected: formData.service === 'malning' }">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="38" fill="#EEF2FF"/>
                            <rect x="32" y="25" width="16" height="24" rx="3" fill="#6366F1"/>
                            <rect x="38" y="49" width="4" height="12" fill="#6366F1"/>
                            <rect x="30" y="20" width="20" height="8" rx="2" fill="#4F46E5"/>
                        </svg>
                    </div>
                    <div class="svc-card-name">Målning</div>
                    <div class="svc-card-desc">Invändigt och utvändigt</div>
                    <div class="svc-card-check">✓</div>
                </div>
            </div>
        </div>
        
        <!-- STEG 3: Erfarenhet -->
        <div x-show="step === 3" x-transition>
            <button class="back-btn" @click="step = 2" type="button"><span class="back-icon">←</span> Tillbaka</button>
            
            <div class="wizard-header">
                <h2 class="wizard-title">Hur lång erfarenhet har du?</h2>
                <p class="wizard-subtitle">Din erfarenhet inom <span x-text="getServiceName()"></span></p>
            </div>
            
            <div class="svc-grid" style="grid-template-columns: repeat(3, 1fr);">
                <!-- Ny i branschen -->
                <div class="svc-card" @click="selectExperience('nybörjare')" :class="{ selected: formData.experience === 'nybörjare' }">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="38" fill="#F0FDF4"/>
                            <path d="M25 55 Q40 30 55 55" stroke="#16A34A" stroke-width="3" fill="none"/>
                            <text x="40" y="42" text-anchor="middle" font-size="22" fill="#16A34A">★</text>
                        </svg>
                    </div>
                    <div class="svc-card-name">Ny i branschen</div>
                    <div class="svc-card-desc">Under 1 år</div>
                    <div class="svc-card-check">✓</div>
                </div>
                <!-- Erfaren -->
                <div class="svc-card" @click="selectExperience('erfaren')" :class="{ selected: formData.experience === 'erfaren' }">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="38" fill="#FFFBEB"/>
                            <text x="40" y="48" text-anchor="middle" font-size="20" fill="#D97706">★★★</text>
                        </svg>
                    </div>
                    <div class="svc-card-name">Erfaren</div>
                    <div class="svc-card-desc">1–5 år</div>
                    <div class="svc-card-check">✓</div>
                </div>
                <!-- Veteran -->
                <div class="svc-card" @click="selectExperience('veteran')" :class="{ selected: formData.experience === 'veteran' }">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="38" fill="#FFF4F2"/>
                            <circle cx="40" cy="36" r="14" fill="#C91C22" opacity="0.15" stroke="#C91C22" stroke-width="2"/>
                            <text x="40" y="41" text-anchor="middle" font-size="18" fill="#C91C22">★</text>
                            <rect x="35" y="50" width="10" height="14" rx="2" fill="#C91C22" opacity="0.6"/>
                        </svg>
                    </div>
                    <div class="svc-card-name">Veteran</div>
                    <div class="svc-card-desc">5+ år</div>
                    <div class="svc-card-check">✓</div>
                </div>
            </div>
        </div>
        
        <!-- STEG 4: Kontaktuppgifter -->
        <div x-show="step === 4" x-transition>
            <button class="back-btn" @click="step = 3" type="button"><span class="back-icon">←</span> Tillbaka</button>
            
            <div class="wizard-header">
                <h2 class="wizard-title">Dina kontaktuppgifter</h2>
                <p class="wizard-subtitle">Så vi kan höra av oss till dig</p>
            </div>
            
            <div x-show="errorMsg" class="error-msg" x-text="errorMsg"></div>
            
            <div class="form-group">
                <label class="form-label">Namn</label>
                <input type="text" class="form-input" placeholder="Ditt namn" x-model="formData.name" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Telefon</label>
                <input type="tel" class="form-input" placeholder="070-123 45 67" x-model="formData.phone" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">E-post</label>
                <input type="email" class="form-input" placeholder="din@email.se" x-model="formData.email" required>
            </div>
            
            <div class="gdpr-check">
                <input type="checkbox" id="job-gdpr" x-model="formData.gdprConsent">
                <label for="job-gdpr" class="gdpr-text">
                    Jag godkänner att Seniorbolaget kontaktar mig och lagrar mina uppgifter enligt deras <a href="/integritetspolicy" target="_blank">integritetspolicy</a>.
                </label>
            </div>
            
            <button class="submit-btn" @click="submitForm()" :disabled="!canSubmit() || isSubmitting" type="button">
                <span x-show="isSubmitting" class="spinner"></span>
                <span x-text="isSubmitting ? 'Skickar...' : 'Skicka ansökan →'"></span>
            </button>
            
            <div class="trust-bar" style="margin-top:24px;">
                <span class="trust-item"><span class="trust-check">✓</span> Flexibla tider</span>
                <span class="trust-item"><span class="trust-check">✓</span> Inga krav</span>
                <span class="trust-item"><span class="trust-check">✓</span> Du bestämmer</span>
            </div>
        </div>
        
        <!-- STEG 5: Tack -->
        <div x-show="step === 5" x-transition>
            <div class="thank-you">
                <div class="thank-icon">✓</div>
                <h2 class="thank-title">Tack för din ansökan!</h2>
                <p class="thank-text">Vi har tagit emot din ansökan och återkommer inom kort.</p>
                
                <div class="thank-summary">
                    <div class="summary-row">
                        <span class="summary-label">Stad</span>
                        <span class="summary-value" x-text="getCityName()"></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Tjänst</span>
                        <span class="summary-value" x-text="getServiceName()"></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Erfarenhet</span>
                        <span class="summary-value" x-text="getExperienceName()"></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Namn</span>
                        <span class="summary-value" x-text="formData.name"></span>
                    </div>
                </div>
                
                <a href="/" style="display:inline-block;margin-top:16px;color:#C91C22;font-weight:600;text-decoration:none;">← Tillbaka till startsidan</a>
            </div>
        </div>
        
        <!-- Trust + telefon -->
        <div class="trust-section" x-show="stepBelow(4)">
            <div class="trust-bar">
                <span class="trust-item"><span class="trust-check">✓</span> Flexibla tider</span>
                <span class="trust-item"><span class="trust-check">✓</span> Inga krav</span>
                <span class="trust-item"><span class="trust-check">✓</span> Du bestämmer</span>
            </div>
            <div class="phone-banner">
                <span class="phone-label">Hellre ringa?</span>
                <a href="tel:0101751900">010-175 19 00</a>
            </div>
        </div>
        
    </div>
</div>
<script>
// Mount the wizard into the placeholder div
document.addEventListener('DOMContentLoaded', function() {
    var mount = document.getElementById('jobba-wizard-mount');
    var wizard = document.getElementById('jobba-wizard-rendered');
    if (mount && wizard) {
        mount.appendChild(wizard);
    }
});
</script>
    <?php
}
add_action('wp_footer', 'sb_jobba_wizard', 10);


// ===== WAS-140: Ta bort X-Powered-By header så tidigt som möjligt =====
add_action('init', function() {
    header_remove('X-Powered-By');
}, 1);

// ===== WAS-137/166: HTTP SECURITY HEADERS =====
add_action('send_headers', function() {
    if (!is_admin()) {
        header_remove('X-Powered-By');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-Content-Type-Options: nosniff');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
        // CSP — permissiv för nu (stramas åt successivt)
        header("Content-Security-Policy: default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval'; img-src 'self' https: data:; font-src 'self' https: data:");
    }
});


// ===== WAS-198: DEFER JAVASCRIPT =====
add_filter('script_loader_tag', function($tag, $handle, $src) {
    // Defer alla scripts utom kritiska
    $no_defer = ['jquery', 'jquery-core', 'jquery-migrate'];
    if (!in_array($handle, $no_defer) && !is_admin()) {
        // Undvik att dubbeldefera (t.ex. alpinejs som redan har defer)
        if (strpos($tag, ' defer') === false) {
            return str_replace(' src=', ' defer src=', $tag);
        }
    }
    return $tag;
}, 10, 3);


// ===== WAS-200: LAZY LOADING PÅ BILDER =====
add_filter('wp_lazy_loading_enabled', '__return_true');

// Lägg till loading=lazy på alla img-taggar via output buffer
add_action('template_redirect', function() {
    ob_start(function($html) {
        // Återställ Alpine.js-attribut (befintlig fix)
        $html = preg_replace('/}&#8221;/', '}"', $html);
        $html = preg_replace('/}&#8220;/', '}"', $html);
        // Lazy loading — lägg till på bilder som saknar loading-attribut
        $html = preg_replace(
            '/<img(?![^>]*loading=)([^>]*?)>/i',
            '<img loading="lazy"$1>',
            $html
        );
        return $html;
    });
});


// ===== WAS-201: GOOGLE FONTS — preconnect + dns-prefetch =====
// Fonten laddas via wp_enqueue_style (extern URL) — lägg till preconnect för bättre prestanda
add_action('wp_head', function() {
    if ( ($_SERVER['HTTP_HOST'] ?? '') === 'staging.seniorbolaget.se' ) {
        return;
    }
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>' . "\n";
    echo '<link rel="dns-prefetch" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1);


// ===== WAS-203: AKTIV MENYMARKERING =====
add_filter('nav_menu_css_class', function($classes, $item, $args, $depth) {
    if ($item->current || $item->current_item_ancestor || $item->current_item_parent) {
        $classes[] = 'is-active';
    }
    return $classes;
}, 10, 4);

add_filter('nav_menu_link_attributes', function($atts, $item, $args, $depth) {
    if ($item->current) {
        $atts['aria-current'] = 'page';
    }
    return $atts;
}, 10, 4);

// CSS för aktiv menymarkering
add_action('wp_head', function() {
    echo '<style>
/* WAS-203: Aktiv menymarkering */
.wp-block-navigation-item.is-active > a,
.wp-block-navigation-item[aria-current="page"] > a,
nav .is-active > a {
    color: #C91C22 !important;
    font-weight: 600;
}
</style>' . "\n";
}, 50);


// ===== WAS-144/171: Aktivera WordPress core XML-sitemap =====
add_filter('wp_sitemaps_enabled', '__return_true');


// ===== WAS-147/172: robots.txt — lägg till Sitemap-direktiv =====
add_filter('robots_txt', function($output) {
    $output .= "\nSitemap: https://seniorbolaget.se/wp-sitemap.xml\n";
    return $output;
}, 10, 2);


// ===== WAS-138/167: Dölj WordPress-version =====
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');
add_filter('style_loader_src', function($src) {
    return remove_query_arg('ver', $src);
}, 9999);
add_filter('script_loader_src', function($src) {
    return remove_query_arg('ver', $src);
}, 9999);


// ===== WAS-207/208: Favicon — använd logotyp (media ID 78) =====
add_action('wp_head', function() {
    $logo_url = wp_get_attachment_url(78);
    if ($logo_url) {
        echo '<link rel="icon" type="image/jpeg" href="' . esc_url($logo_url) . '">' . "\n";
        echo '<link rel="apple-touch-icon" href="' . esc_url($logo_url) . '">' . "\n";
    }
}, 1);


// ===== WAS-113: Fix wptexturize Alpine.js encoding =====
add_action('template_redirect', function() {
    ob_start(function($html) {
        // Lista över Alpine-attribut som behöver fixas
        $alpine_attrs = ['x-text', 'x-show', 'x-bind', 'x-if', 'x-for', ':class', '@click', '@change', 'x-init', 'x-data'];
        
        foreach ($alpine_attrs as $attr) {
            // Fix &gt; (>) operator
            $html = preg_replace('/' . preg_quote($attr, '/') . '="([^"]*?)&gt;([^"]*?)"/s', $attr . '="$1>$2"', $html);
            // Fix &lt; (<) operator
            $html = preg_replace('/' . preg_quote($attr, '/') . '="([^"]*?)&lt;([^"]*?)"/s', $attr . '="$1<$2"', $html);
            // Fix &#8221; (curly quote) — wptexturize
            $html = preg_replace('/' . preg_quote($attr, '/') . '="([^"]*?)&#8221;/s', $attr . '="$1"', $html);
            // Fix &amp; (&)
            $html = preg_replace('/' . preg_quote($attr, '/') . '="([^"]*?)&amp;&amp;([^"]*?)"/s', $attr . '="$1&&$2"', $html);
        }
        
        return $html;
    });
}, 1);


// ===== WAS-139: Blockera direkt åtkomst till känsliga filer =====
add_action('init', function() {
    if (isset($_SERVER['REQUEST_URI'])) {
        $blocked = ['/wp-config.php', '/wp-config.php.bak', '/.env'];
        $uri = strtolower(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if (in_array($uri, $blocked)) {
            http_response_code(403);
            die('Forbidden');
        }
    }
}, 1);


// ===== WAS-130: Sticky header-CTA vid scroll saknas på mobil =====
add_action('wp_footer', function() {
    ?>
    <style>
    @media (max-width: 768px) {
        #sb-sticky-header-cta {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #fff;
            padding: 8px 16px;
            display: none;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            z-index: 9998;
            border-bottom: 1px solid #E5E7EB;
        }
        #sb-sticky-header-cta.visible {
            display: flex;
        }
        #sb-sticky-header-cta .logo {
            font-size: 14px;
            font-weight: 700;
            color: #1F2937;
        }
        #sb-sticky-header-cta .cta-btn {
            background: #C91C22;
            color: #fff;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
        }
    }
    </style>
    <div id="sb-sticky-header-cta">
        <span class="logo">Seniorbolaget</span>
        <a href="/intresseanmalan/" class="cta-btn">Boka hjälp &rarr;</a>
    </div>
    <script>
    (function() {
        var bar = document.getElementById('sb-sticky-header-cta');
        if (!bar) return;
        var hero = document.querySelector('.wp-block-cover, .sb-hero-section');
        window.addEventListener('scroll', function() {
            if (hero && window.scrollY > hero.offsetHeight) {
                bar.classList.add('visible');
            } else {
                bar.classList.remove('visible');
            }
        }, {passive: true});
    })();
    </script>
    <?php
}, 25);


// ===== WAS-206: Breadcrumbs på undersidor =====
add_action('wp_body_open', function() {
    if (is_front_page() || is_home()) return;

    $breadcrumbs  = '<nav class="sb-breadcrumbs" aria-label="Brödsmulor">';
    $breadcrumbs .= '<ol itemscope itemtype="https://schema.org/BreadcrumbList">';
    $breadcrumbs .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    $breadcrumbs .= '<a itemprop="item" href="' . esc_url(home_url()) . '"><span itemprop="name">Hem</span></a>';
    $breadcrumbs .= '<meta itemprop="position" content="1" />';
    $breadcrumbs .= '</li>';

    if (!is_front_page()) {
        $breadcrumbs .= '<li class="separator" aria-hidden="true">&rsaquo;</li>';
        $breadcrumbs .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $breadcrumbs .= '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
        $breadcrumbs .= '<meta itemprop="position" content="2" />';
        $breadcrumbs .= '</li>';
    }

    $breadcrumbs .= '</ol></nav>';
    echo $breadcrumbs;
});


// ===== WAS-142: WordPress REST API — begränsa exponering =====
add_filter('rest_authentication_errors', function($result) {
    if (!is_user_logged_in()) {
        $request_uri = $_SERVER['REQUEST_URI'] ?? '';
        $sensitive_endpoints = ['/wp-json/wp/v2/users', '/wp-json/wp/v2/settings'];
        foreach ($sensitive_endpoints as $endpoint) {
            if (strpos($request_uri, $endpoint) !== false) {
                return new WP_Error('rest_not_logged_in', 'Du måste vara inloggad.', ['status' => 401]);
            }
        }
    }
    return $result;
});


// ===== WAS-146/194/199: WebP-bilder — serva WebP om tillgängligt =====
add_action('init', function() {
    if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false) {
        add_filter('wp_get_attachment_url', function($url) {
            $webp_url  = preg_replace('/\.(jpe?g|png)$/i', '.webp', $url);
            $webp_path = str_replace(WP_CONTENT_URL, WP_CONTENT_DIR, $webp_url);
            if (file_exists($webp_path)) {
                return $webp_url;
            }
            return $url;
        });
    }
});


// ===== WAS-195: srcset — säkerställ content_width =====
add_action('after_setup_theme', function() {
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}, 5);

add_filter('wp_calculate_image_sizes', function($sizes, $size, $image_src, $image_meta, $attachment_id) {
    return $sizes; // WordPress hanterar srcset automatiskt
}, 10, 5);


// ===== WAS-SEO: Block search engine indexing on staging =====
add_action('send_headers', function() {
    if (str_contains($_SERVER['HTTP_HOST'] ?? '', 'staging')) {
        header('X-Robots-Tag: noindex, nofollow');
    }
});


// ===== WAS-102: Header gap fix — blockGap + admin-bar =====
// style.css är CDN-cachad, DB åsidosätter header.html — denna hook laddas ALLTID
add_action('wp_head', function() {
    echo '<style id="was-102-gap-fix">
/* WAS-102 ROOT CAUSE: header.wp-block-template-part har backdrop-filter+position:sticky
   som skapar ett nytt containing block — sb-header (position:fixed) fastnar vid Y=70.
   Nollställ wrapper-stilarna; sb-header sköter allt visuellt. */
header.wp-block-template-part {
    position: static !important;
    top: auto !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
    background: transparent !important;
    box-shadow: none !important;
    z-index: auto !important;
}

/* WAS-102: WordPress blockGap (margin-block-start:2rem) skapar 32px gap under headern */
.wp-site-blocks > *:nth-child(2) {
    margin-top: 0 !important;
    margin-block-start: 0 !important;
}
/* Admin-bar fix */
html.admin-bar .sb-header { top: 32px !important; }
html.admin-bar .wp-site-blocks { padding-top: calc(70px + 32px) !important; }
html.admin-bar .wp-site-blocks > *:nth-child(2) { margin-block-start: 0 !important; }
@media screen and (max-width: 782px) {
  html.admin-bar .sb-header { top: 46px !important; }
  html.admin-bar .wp-site-blocks { padding-top: calc(70px + 46px) !important; }
}
</style>';
}, 99);


/**
 * WAS-103: Block-library responsive CSS patch.
 * Elementor strips the external wp-block-library stylesheet.
 * These rules restore responsive column stacking and button styling.
 */
add_action( 'wp_head', function() {
    echo '<style id="was-103-block-library-patch">
/* WAS-103: Responsive columns - stack on mobile */
@media (max-width: 781px) {
    .wp-block-columns:not(.is-not-stacked-on-mobile) { flex-wrap: wrap !important; }
    .wp-block-columns:not(.is-not-stacked-on-mobile) > .wp-block-column { flex-basis: 100% !important; }
}
/* WAS-103: Button base styling */
.wp-block-button__link { display: inline-block; padding: 0.8em 1.5em; text-decoration: none; cursor: pointer; }
</style>';
}, 100 );

/**
 * SENIORBOLAGET STAGING CITY CONTACT HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-before.php
 * or remove this block, then clear staging cache.
 * Scope: staging city pages only. Production is not changed.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}

	$path = parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH );
	if ( ! is_string( $path ) || ! preg_match( '#^/har-finns-vi/([^/]+)/?$#', $path, $matches ) ) {
		return;
	}

	$contacts = json_decode( '{"boras":{"city":"Borås","label":"Borås","name":"Roland Rapp","phone":"0721-511 834","tel":"tel:0721511834","emails":["roland.rapp@seniorbolaget.se"]},"eskilstuna":{"city":"Eskilstuna","label":"Eskilstuna","name":"Ann-Sofi Persson","phone":"0721-511 815","tel":"tel:0721511815","emails":["ann-sofi.persson@seniorbolaget.se"]},"falkenberg":{"city":"Falkenberg","label":"Falkenberg","name":"Stefan Nilsson","phone":"0721-511 827","tel":"tel:0721511827","emails":["stefan.nilsson@seniorbolaget.se"]},"goteborg":{"city":"Göteborg SV","label":"Göteborg","name":"Bosse Eriksson","phone":"0704-41 25 72","tel":"tel:0704412572","emails":["bosse.eriksson@seniorbolaget.se"]},"halmstad":{"city":"Halmstad","label":"Halmstad","name":"Jenny Skogh","phone":"0707-25 24 47","tel":"tel:0707252447","emails":["halmstad@seniorbolaget.se"]},"helsingborg":{"city":"Helsingborg","label":"Helsingborg","name":"Milliana Rosén","phone":"0721-511 805","tel":"tel:0721511805","emails":["milliana.rosen@seniorbolaget.se"]},"jonkoping":{"city":"Jönköping","label":"Jönköping","name":"Roland Rapp","phone":"0721-511 834","tel":"tel:0721511834","emails":["roland.rapp@seniorbolaget.se"]},"karlstad":{"city":"Karlstad","label":"Karlstad","name":"Runar Skoglund","phone":"054-560 160","tel":"tel:054560160","emails":["karlstad@seniorbolaget.se"]},"kristianstad":{"city":"Kristianstad","label":"Kristianstad","name":"Peter Lindquist","phone":"0720-61 95 21","tel":"tel:0720619521","emails":["peter.lindquist@seniorbolaget.se"]},"kungsbacka":{"city":"Kungsbacka","label":"Kungsbacka","name":"Janette Rosén","phone":"0721-511 825","tel":"tel:0721511825","emails":["janette.rosen@seniorbolaget.se"]},"kungalv":{"city":"Kungälv","label":"Kungälv","name":"Michael Adielson","phone":"0721-511 814","tel":"tel:0721511814","emails":["mikael.adielson@seniorbolaget.se"]},"laholm":{"city":"Laholm / Båstad","label":"Laholm","name":"Jenny Skogh","phone":"0707-25 24 47","tel":"tel:0707252447","emails":["laholm@seniorbolaget.se","bastad@seniorbolaget.se"]},"landskrona":{"city":"Landskrona","label":"Landskrona","name":"Milliana Rosén","phone":"0721-511 805","tel":"tel:0721511805","emails":["milliana.rosen@seniorbolaget.se"]},"lerum":{"city":"Lerum / Partille","label":"Lerum","name":"Jens Hendar","phone":"0707-25 23 72","tel":"tel:0707252372","emails":["jens.hendar@seniorbolaget.se"]},"molndal":{"city":"Mölndal / Härryda","label":"Mölndal","name":"Håkan Viklund","phone":"0707-58 13 91","tel":"tel:0707581391","emails":["hakan.viklund@seniorbolaget.se"]},"nassjo":{"city":"Nässjö","label":"Nässjö","name":"Lennart Ljungdahl","phone":"0721-511 829","tel":"tel:0721511829","emails":["lennart.ljungdahl@seniorbolaget.se"]},"orebro":{"city":"Örebro","label":"Örebro","name":"Andreas Persson","phone":"0721-511 817","tel":"tel:0721511817","emails":["andreas.persson@seniorbolaget.se"]},"skovde":{"city":"Skövde","label":"Skövde","name":"Susanne Kinell","phone":"0720-61 95 09","tel":"tel:0720619509","emails":["susanne.kinell@seniorbolaget.se"]},"stenungsund":{"city":"Stenungsund","label":"Stenungsund","name":"Mikael Styrmark","phone":"0736-247 356","tel":"tel:0736247356","emails":["mikael.styrmark@seniorbolaget.se"]},"sundsvall":{"city":"Sundsvall","label":"Sundsvall","name":"Eva Skog","phone":"0721-511 806","tel":"tel:0721511806","emails":["eva.skog@seniorbolaget.se"]},"torsby":{"city":"Torsby","label":"Torsby","name":"Runar Skoglund","phone":"054-560 160","tel":"tel:054560160","emails":["karlstad@seniorbolaget.se"]},"trelleborg":{"city":"Trelleborg","label":"Trelleborg","name":"Peter Lindquist","phone":"0721-511 826","tel":"tel:0721511826","emails":["peter.lindquist@seniorbolaget.se"]},"trollhattan":{"city":"Trollhättan","label":"Trollhättan","name":"Ejvar Bolander","phone":"0720-61 95 20","tel":"tel:0720619520","emails":["ejvar.bolander@seniorbolaget.se"]},"ulricehamn":{"city":"Ulricehamn","label":"Ulricehamn","name":"Ann-Sofie Käll","phone":"0720-61 95 16","tel":"tel:0720619516","emails":["annsofie.kall@seniorbolaget.se"]},"varberg":{"city":"Varberg","label":"Varberg","name":"Stefan Nilsson","phone":"0721-511 827","tel":"tel:0721511827","emails":["stefan.nilsson@seniorbolaget.se"]},"amal":{"city":"Åmål","label":"Åmål","name":"Monica Lindstrand","phone":"0721-511 812","tel":"tel:0721511812","emails":["monica.lindstrand@seniorbolaget.se"]}}', true );
	$slug = sanitize_key( $matches[1] );
	if ( empty( $contacts[ $slug ] ) || ! is_array( $contacts[ $slug ] ) ) {
		return;
	}

	$contact = $contacts[ $slug ];
	?>
	<script id="seniorbolaget-staging-city-contact-hotfix-20260618">
	(function (contact) {
		'use strict';
		var oldPhonePattern = /070[-\s]?441[-\s]?25[-\s]?72/g;
		var visiblePhonePattern = /(?:\+46|0)[0-9][0-9\-\s]{5,}[0-9]/g;

		function escapeRegExp(value) {
			return String(value).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
		}

		function cityLabels() {
			var labels = [];
			if (contact.label) labels.push(String(contact.label));
			if (contact.city) {
				labels.push(String(contact.city));
				if (String(contact.city).indexOf(' / ') > -1) labels.push(String(contact.city).split(' / ')[0]);
			}
			return labels.filter(function (value, index, array) { return value && array.indexOf(value) === index; });
		}

		function replaceTextNode(node) {
			var value = node.nodeValue || '';
			var next = value.replace(oldPhonePattern, contact.phone);
			cityLabels().forEach(function (label) {
				next = next.replace(new RegExp('Franchisetagare i ' + escapeRegExp(label), 'g'), contact.name);
			});
			if (next !== value) node.nodeValue = next;
		}

		function normalizeContactLinkText(link) {
			var href = link.getAttribute('href') || '';
			if (href !== contact.tel) return;
			var label = link.textContent || '';
			if (/\d/.test(label)) {
				link.textContent = label.replace(visiblePhonePattern, contact.phone);
			}
		}

		function patchLinks(root) {
			root.querySelectorAll('a[href^="tel:"]').forEach(function (link) {
				var href = link.getAttribute('href') || '';
				var label = link.textContent || '';
				oldPhonePattern.lastIndex = 0;
				var hasOldPhone = /070[-\s]?441[-\s]?25[-\s]?72|0704412572/.test(href) || oldPhonePattern.test(label);
				oldPhonePattern.lastIndex = 0;
				if (hasOldPhone) {
					link.setAttribute('href', contact.tel);
					link.textContent = label.replace(oldPhonePattern, contact.phone);
				}
				normalizeContactLinkText(link);
			});
		}

		function patchStructuredData() {
			document.querySelectorAll('script[type="application/ld+json"]').forEach(function (script) {
				try {
					var data = JSON.parse(script.textContent);
					if (data && data['@type'] === 'LocalBusiness') {
						data.telephone = contact.phone;
						if (contact.emails && contact.emails[0]) data.email = contact.emails.join(', ');
						script.textContent = JSON.stringify(data);
					}
				} catch (err) {}
			});
		}

		function run() {
			var roots = Array.prototype.slice.call(document.querySelectorAll('main, article, .entry-content, .wp-block-post-content, .wp-site-blocks'));
			if (!roots.length) roots = [document.body];
			roots.forEach(function (root) {
				patchLinks(root);
				var walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, {
					acceptNode: function (node) {
						var parent = node.parentElement;
						if (!parent || parent.closest('script, style, noscript, svg, footer, header, nav')) return NodeFilter.FILTER_REJECT;
						return /070[-\s]?441[-\s]?25[-\s]?72|Franchisetagare i /.test(node.nodeValue || '') ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
					}
				});
				var nodes = [];
				while (walker.nextNode()) nodes.push(walker.currentNode);
				nodes.forEach(replaceTextNode);
				patchLinks(root);
			});
			patchStructuredData();
			document.documentElement.dataset.sbCityContactHotfix = 'applied';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', run);
		} else {
			run();
		}
		window.addEventListener('load', run);
	})(<?php echo wp_json_encode( $contact ); ?>);
	</script>
	<?php
}, 1000 );
// SENIORBOLAGET STAGING CITY CONTACT HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING LAUNCH TRUST HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-before.php
 * or remove this block, then clear staging cache.
 * Scope: staging only. Production is not changed.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<style id="seniorbolaget-staging-launch-trust-hotfix-css-20260618">
	.sb-b2b-icon-replacement {
		display: inline-flex;
		width: 44px;
		height: 44px;
		align-items: center;
		justify-content: center;
		border-radius: 12px;
		background: #FFF4F2;
		color: #C91C22;
	}
	.sb-b2b-icon-replacement svg {
		display: block;
		width: 24px;
		height: 24px;
		fill: none;
		stroke: currentColor;
		stroke-width: 2;
		stroke-linecap: round;
		stroke-linejoin: round;
	}
	</style>
	<script id="seniorbolaget-staging-launch-trust-hotfix-20260618">
	(function () {
		'use strict';

		function textOf(element) {
			return (element.innerText || element.textContent || '').replace(/\s+/g, ' ').trim();
		}

		function addHiddenFlag(element) {
			if (!element || element.dataset.sbRatingHidden === 'true') return;
			element.dataset.sbRatingHidden = 'true';
			element.style.display = 'none';
		}

		function hideRatingClaims(root) {
			Array.prototype.slice.call(root.querySelectorAll('*')).forEach(function (element) {
				var text = textOf(element);
				if (!text || !/(^|\s)4[\.,]9|snittbetyg/i.test(text)) return;
				if (element.closest('script, style, noscript, svg, header, footer, nav')) return;
				if (text.length > 48) return;
				if (/(300\+|Hundratals|Tusentals|Nöjda kunder|120\+|24h|franchisetagare)/i.test(text)) return;
				addHiddenFlag(element);
			});
		}

		function patchTrustText(root) {
			Array.prototype.slice.call(root.querySelectorAll('*')).forEach(function (element) {
				if (element.closest('script, style, noscript, svg, header, footer, nav')) return;
				var text = textOf(element);
				if (!text || text.length > 80) return;
				if (/^300\+$/.test(text)) {
					element.textContent = 'Tusentals';
				} else if (/^nöjda kunder i\s+/i.test(text)) {
					element.textContent = 'nöjda kunder sedan 2008';
				} else if (/^8\s+år$/i.test(text)) {
					element.textContent = 'Sedan 2008';
				} else if (/^8\s+år\s+i\s+branschen$/i.test(text)) {
					element.textContent = 'Sedan 2008 i branschen';
				} else if (/^300\+\s+nöjda kunder i\s+/i.test(text) && !/(24h|svarstid|8\s+år|branschen)/i.test(text)) {
					element.textContent = 'Tusentals nöjda kunder sedan 2008';
				}
			});
		}

		function b2bSvg(kind) {
			var icons = {
				'🏢': '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M9 21v-6h6v6"/><path d="M8 7h.01M12 7h.01M16 7h.01M8 11h.01M12 11h.01M16 11h.01"/></svg>',
				'🏗️': '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 21h18"/><path d="M6 21V8l6-4 6 4v13"/><path d="M6 12h12"/><path d="M10 21v-5h4v5"/></svg>',
				'🏗': '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 21h18"/><path d="M6 21V8l6-4 6 4v13"/><path d="M6 12h12"/><path d="M10 21v-5h4v5"/></svg>',
				'👔': '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="7" r="4"/><path d="M5 21a7 7 0 0 1 14 0"/><path d="M10 14l2 7 2-7"/></svg>',
				'📄': '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8M8 17h6"/></svg>',
				'📉': '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3v18h18"/><path d="M7 8l4 4 4-4 5 5"/><path d="M16 13h4v-4"/></svg>',
				'🎓': '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 2 9 2 12 0v-5"/><path d="M22 10v6"/></svg>',
				'⚡': '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13 2L4 14h7l-1 8 10-14h-7l0-6z"/></svg>'
			};
			return icons[kind] || icons['🏢'];
		}

		function patchB2BIcons(root) {
			var path = window.location.pathname || '';
			if (!/^\/foretag\/?$/.test(path)) return;
			var emojis = ['🏢', '🏗️', '🏗', '👔', '📄', '📉', '🎓', '⚡'];
			var walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, {
				acceptNode: function (node) {
					var parent = node.parentElement;
					if (!parent || parent.closest('script, style, noscript, svg, header, footer, nav, .sb-fab')) return NodeFilter.FILTER_REJECT;
					return emojis.some(function (emoji) { return (node.nodeValue || '').indexOf(emoji) !== -1; }) ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
				}
			});
			var nodes = [];
			while (walker.nextNode()) nodes.push(walker.currentNode);
			nodes.forEach(function (node) {
				var value = node.nodeValue || '';
				var emoji = emojis.find(function (candidate) { return value.indexOf(candidate) !== -1; });
				if (!emoji || !node.parentElement) return;
				if (value.trim() === emoji) {
					var span = document.createElement('span');
					span.className = 'sb-b2b-icon-replacement';
					span.setAttribute('aria-hidden', 'true');
					span.innerHTML = b2bSvg(emoji);
					node.parentElement.replaceChild(span, node);
				} else {
					node.nodeValue = value.replace(emoji, '').replace(/\s{2,}/g, ' ');
				}
			});
		}

		function run() {
			var root = document.body;
			if (!root) return;
			hideRatingClaims(root);
			patchTrustText(root);
			patchB2BIcons(root);
			document.documentElement.dataset.sbLaunchTrustHotfix = 'applied';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', run);
		} else {
			run();
		}
		window.addEventListener('load', run);
	})();
	</script>
	<?php
}, 1001 );
// SENIORBOLAGET STAGING LAUNCH TRUST HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING NEUTRAL CITY IMAGES HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v8.php
 * or remove this block, then clear staging cache.
 * Scope: staging location pages only. Production is not changed.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}

	$path = parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH );
	if ( ! is_string( $path ) || ! preg_match( '#^/har-finns-vi(?:/|$)#', $path ) ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-neutral-city-images-hotfix-20260618">
	(function () {
		function decodeImageValue(value) {
			try {
				return decodeURIComponent(String(value || ''));
			} catch (error) {
				return String(value || '');
			}
		}

		function buildNeutralServiceSvg(variant) {
			var accent = ['#C91C22', '#3F7D4F', '#D18A24'][variant % 3];
			var foreground = [
				'<path d="M72 162l78-62 78 62" fill="none" stroke="#C91C22" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/>',
				'<rect x="92" y="156" width="116" height="74" rx="10" fill="#ffffff" stroke="#E6D8CB" stroke-width="4"/>',
				'<rect x="136" y="184" width="28" height="46" rx="4" fill="#EFE2D7"/>',
				'<circle cx="286" cy="166" r="33" fill="#E7F1E6" stroke="#BFD7BD" stroke-width="4"/>',
				'<path d="M286 137v90M256 168c23 3 43-5 60-24M258 190c24 1 44-5 62-22" fill="none" stroke="#3F7D4F" stroke-width="5" stroke-linecap="round"/>'
			];

			if (variant % 3 === 1) {
				foreground = [
					'<path d="M92 212c34-62 68-88 104-78 32 9 45 43 30 78H92z" fill="#E7F1E6" stroke="#BFD7BD" stroke-width="4"/>',
					'<path d="M128 204c22-38 52-58 90-62M158 218c-2-44 12-78 42-104" fill="none" stroke="#3F7D4F" stroke-width="7" stroke-linecap="round"/>',
					'<rect x="246" y="134" width="72" height="88" rx="14" fill="#ffffff" stroke="#E6D8CB" stroke-width="4"/>',
					'<path d="M262 178h40M282 158v40" stroke="#C91C22" stroke-width="8" stroke-linecap="round"/>'
				];
			} else if (variant % 3 === 2) {
				foreground = [
					'<rect x="82" y="146" width="116" height="78" rx="12" fill="#ffffff" stroke="#E6D8CB" stroke-width="4"/>',
					'<path d="M110 178h58M110 200h42" stroke="#C91C22" stroke-width="8" stroke-linecap="round"/>',
					'<path d="M248 122l54 54M302 122l-54 54" stroke="#D18A24" stroke-width="12" stroke-linecap="round"/>',
					'<circle cx="275" cy="199" r="28" fill="#E7F1E6" stroke="#BFD7BD" stroke-width="4"/>',
					'<path d="M261 199l10 10 22-24" fill="none" stroke="#3F7D4F" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>'
				];
			}

			return [
				'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300" preserveAspectRatio="xMidYMid slice" role="img" aria-label="Seniorbolaget">',
				'<rect width="400" height="300" fill="#FAF7F2"/>',
				'<circle cx="338" cy="58" r="72" fill="' + accent + '" opacity="0.10"/>',
				'<circle cx="62" cy="252" r="92" fill="#EFE7DC" opacity="0.72"/>',
				'<path d="M0 242c46-16 82-17 130-4 63 17 116 15 178-7 39-14 70-17 92-12v81H0z" fill="#F0E8DD"/>',
				foreground.join(''),
				'</svg>'
			].join('');
		}

		function neutralServiceImageSrc(index) {
			return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(buildNeutralServiceSvg(index));
		}

		function imageNeedsReplacement(image) {
			var haystack = [
				image.getAttribute('alt') || '',
				decodeImageValue(image.getAttribute('src') || ''),
				decodeImageValue(image.getAttribute('srcset') || '')
			].join(' ');

			return /(bild\s+kommer\s+snart|foto\s+(kommer|uppdateras)|uppdateras\s+snart)/i.test(haystack);
		}

		function patch(root) {
			var scope = root && root.querySelectorAll ? root : document;
			var replacements = 0;
			Array.prototype.slice.call(scope.querySelectorAll('img')).forEach(function (image) {
				if (!imageNeedsReplacement(image)) return;
				image.src = neutralServiceImageSrc(replacements);
				image.alt = 'Seniorbolaget, hushållsnära tjänster';
				image.removeAttribute('srcset');
				image.classList.add('sb-neutral-service-image');
				image.setAttribute('data-sb-neutral-service-image', 'true');
				replacements += 1;
			});

			if (replacements > 0) {
				document.documentElement.dataset.sbNeutralCityImagesHotfix = 'applied';
			} else if (!document.documentElement.dataset.sbNeutralCityImagesHotfix) {
				document.documentElement.dataset.sbNeutralCityImagesHotfix = 'ready';
			}
		}

		function run() {
			if (!document.body) return;
			patch(document);
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', run);
		} else {
			run();
		}
		window.addEventListener('load', run);

		if (window.MutationObserver) {
			new MutationObserver(function (mutations) {
				mutations.forEach(function (mutation) {
					Array.prototype.slice.call(mutation.addedNodes || []).forEach(function (node) {
						if (node && node.nodeType === 1) patch(node);
					});
				});
			}).observe(document.documentElement, { childList: true, subtree: true });
		}
	})();
	</script>
	<?php
}, 1002 );
// SENIORBOLAGET STAGING NEUTRAL CITY IMAGES HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING CONVERSION A11Y HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v9.php
 * or remove this block, then clear staging cache.
 * Scope: staging DOM repair for logo home link and injected contact form labels. Production is not changed.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-conversion-a11y-hotfix-20260618">
	(function () {
		function repairLogoHomeLinks() {
			Array.prototype.slice.call(document.querySelectorAll('a.sb-logo')).forEach(function (link) {
				if (!link.getAttribute('href')) {
					link.setAttribute('href', '/');
				}
				if (!link.getAttribute('aria-label')) {
					link.setAttribute('aria-label', 'Seniorbolaget startsida');
				}
			});
		}

		function repairInjectedContactFormLabels() {
			Array.prototype.slice.call(document.querySelectorAll('input[type="checkbox"][name="sb_gdpr"]')).forEach(function (input, index) {
				if (input.closest('label')) return;

				var id = input.getAttribute('id') || 'sb-gdpr-consent-' + index;
				input.setAttribute('id', id);

				var sibling = input.nextElementSibling;
				if (sibling && sibling.tagName && sibling.tagName.toLowerCase() === 'span') {
					var replacement = document.createElement('label');
					replacement.setAttribute('for', id);
					replacement.className = sibling.className || '';
					replacement.setAttribute('style', sibling.getAttribute('style') || 'font-size:13px;line-height:1.4;color:#555;');
					while (sibling.firstChild) replacement.appendChild(sibling.firstChild);
					sibling.parentNode.replaceChild(replacement, sibling);
					return;
				}

				if (!input.getAttribute('aria-label')) {
					input.setAttribute('aria-label', 'Jag godkänner behandling av personuppgifter');
				}
			});

			Array.prototype.slice.call(document.querySelectorAll('input[name="sb_website"]')).forEach(function (input) {
				input.setAttribute('tabindex', '-1');
				input.setAttribute('aria-hidden', 'true');
				if (input.parentElement) {
					input.parentElement.setAttribute('aria-hidden', 'true');
				}
			});
		}

		function run() {
			if (!document.body) return;
			repairLogoHomeLinks();
			repairInjectedContactFormLabels();
			document.documentElement.dataset.sbConversionA11yHotfix = 'applied';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', run);
		} else {
			run();
		}
		window.addEventListener('load', run);

		if (window.MutationObserver) {
			new MutationObserver(function () {
				run();
			}).observe(document.documentElement, { childList: true, subtree: true });
		}
	})();
	</script>
	<?php
}, 1003 );
// SENIORBOLAGET STAGING CONVERSION A11Y HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING CARE CONTEXT COPY HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v10.php
 * or remove this block, then clear staging cache.
 * Scope: staging rendered copy only; removes healthcare/home-care wording from public launch pages. Production is not changed.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-care-context-copy-hotfix-20260618">
	(function () {
		function repairCareContextCopy() {
			if (!document.body || !document.createTreeWalker || !window.NodeFilter) return;

			var replacements = [
				[/Privat hemtjänst/g, 'Hemnära stöd'],
				[/Ledsagning/g, 'Praktisk hjälp'],
				[/Omsorg • Hemnära stöd • Praktisk hjälp/g, 'Vardagshjälp • Hemnära stöd • Praktisk hjälp'],
				[/omsorg och precision/g, 'omtanke och noggrannhet'],
				[/med omsorg och precision/g, 'med omtanke och noggrannhet'],
				[/vård och omsorg/g, 'service och kundnära arbete'],
				[/hjälpa med medicin/g, 'hjälpa med praktiska vardagsbestyr']
			];

			var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
				acceptNode: function (node) {
					var parent = node.parentElement;
					if (!parent || parent.closest('script, style, noscript, svg, #wpadminbar')) return NodeFilter.FILTER_REJECT;
					return /(Privat hemtjänst|Ledsagning|omsorg och precision|vård och omsorg|hjälpa med medicin)/i.test(node.nodeValue || '') ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
				}
			});
			var nodes = [];
			while (walker.nextNode()) nodes.push(walker.currentNode);

			nodes.forEach(function (node) {
				var value = node.nodeValue || '';
				replacements.forEach(function (pair) {
					value = value.replace(pair[0], pair[1]);
				});
				node.nodeValue = value;
			});

			document.documentElement.dataset.sbCareContextCopyHotfix = 'applied';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', repairCareContextCopy);
		} else {
			repairCareContextCopy();
		}
		window.addEventListener('load', repairCareContextCopy);

		if (window.MutationObserver) {
			new MutationObserver(function () {
				repairCareContextCopy();
			}).observe(document.documentElement, { childList: true, subtree: true });
		}
	})();
	</script>
	<?php
}, 1004 );
// SENIORBOLAGET STAGING CARE CONTEXT COPY HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING 404 SWEDISH COPY HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v11.php
 * or remove this block, then clear staging cache.
 * Scope: staging 404 pages only; fixes ASCII-only Swedish copy. Production is not changed.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host || ! is_404() ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-404-swedish-copy-hotfix-20260618">
	(function () {
		function repair404SwedishText() {
			if (!document.body || !document.createTreeWalker || !window.NodeFilter) return;

			var replacements = [
				[/soka istallet/g, 'söka istället'],
				[/Sok/g, 'Sök'],
				[/besok nagon/g, 'besök någon'],
				[/vara populara/g, 'våra populära'],
				[/Hemstadning/g, 'Hemstädning'],
				[/Foretag/g, 'Företag'],
				[/Vardagshjalp/g, 'Vardagshjälp'],
				[/Tillbaka til /g, 'Tillbaka till ']
			];

			var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
				acceptNode: function (node) {
					var parent = node.parentElement;
					if (!parent || parent.closest('script, style, noscript, svg, #wpadminbar')) return NodeFilter.FILTER_REJECT;
					return /(soka istallet|Sok|besok nagon|vara populara|Hemstadning|Foretag|Vardagshjalp|Tillbaka til )/.test(node.nodeValue || '') ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
				}
			});
			var nodes = [];
			while (walker.nextNode()) nodes.push(walker.currentNode);

			nodes.forEach(function (node) {
				var value = node.nodeValue || '';
				replacements.forEach(function (pair) {
					value = value.replace(pair[0], pair[1]);
				});
				node.nodeValue = value;
			});

			document.documentElement.dataset.sb404SwedishCopyHotfix = 'applied';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', repair404SwedishText);
		} else {
			repair404SwedishText();
		}
		window.addEventListener('load', repair404SwedishText);
	})();
	</script>
	<?php
}, 1005 );
// SENIORBOLAGET STAGING 404 SWEDISH COPY HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING CONTENT SEO CLEANUP HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v12.php
 * or remove this block, then clear staging cache.
 * Scope: staging rendered content cleanup for raw price markdown table, style punctuation, contact duplicate heading and care-context heading. Production is not changed.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-content-seo-cleanup-hotfix-20260618">
	(function () {
		'use strict';

		function textOf(element) {
			return (element && element.textContent ? element.textContent : '').replace(/\s+/g, ' ').trim();
		}

		function splitMarkdownTableLine(line) {
			return String(line || '')
				.trim()
				.replace(/^\|/, '')
				.replace(/\|$/, '')
				.split('|')
				.map(function (cell) { return cell.trim(); });
		}

		function isMarkdownTableLine(line) {
			return /^\s*\|.+\|\s*$/.test(String(line || ''));
		}

		function isMarkdownSeparatorLine(line) {
			return /^\s*\|?\s*:?[-—–]{2,}:?\s*(?:\|\s*:?[-—–]{2,}:?\s*)+\|?\s*$/.test(String(line || ''));
		}

		function markdownLinesFromParagraph(paragraph) {
			return paragraph.innerHTML
				.replace(/<br\s*\/?>/gi, '\n')
				.replace(/&nbsp;/gi, ' ')
				.split(/\n+/)
				.map(function (line) {
					var scratch = document.createElement('textarea');
					scratch.innerHTML = line;
					return scratch.value.replace(/\s+/g, ' ').trim();
				})
				.filter(isMarkdownTableLine);
		}

		function insertPriceTable(paragraph, headers, rowLines, consumedParagraphs) {
			var wrapper = document.createElement('div');
			wrapper.className = 'sb-price-table';
			wrapper.setAttribute('data-sb-content-cleanup-table', 'true');

			var table = document.createElement('table');
			var thead = document.createElement('thead');
			var headRow = document.createElement('tr');
			headers.forEach(function (header) {
				var th = document.createElement('th');
				th.textContent = header;
				headRow.appendChild(th);
			});
			thead.appendChild(headRow);
			table.appendChild(thead);

			var tbody = document.createElement('tbody');
			rowLines.forEach(function (line) {
				var cells = splitMarkdownTableLine(line);
				if (cells.length !== headers.length) return;
				var tr = document.createElement('tr');
				cells.forEach(function (cell) {
					var td = document.createElement('td');
					td.textContent = cell;
					tr.appendChild(td);
				});
				tbody.appendChild(tr);
			});

			if (!tbody.children.length) return false;
			table.appendChild(tbody);
			wrapper.appendChild(table);
			paragraph.parentNode.insertBefore(wrapper, paragraph);
			consumedParagraphs.forEach(function (node) {
				node.setAttribute('data-sb-price-table-converted', 'true');
				node.remove();
			});
			return true;
		}

		function convertPriceMarkdownTables() {
			var converted = 0;
			Array.prototype.slice.call(document.querySelectorAll('p')).forEach(function (paragraph) {
				if (paragraph.getAttribute('data-sb-price-table-converted') === 'true') return;

				var lines = markdownLinesFromParagraph(paragraph);
				if (!lines.length || !/^\|\s*Stad\s*\|\s*Timpris/i.test(lines[0])) return;

				var headers = splitMarkdownTableLine(lines[0]);
				if (headers.length < 2) return;

				var consumedParagraphs = [paragraph];
				var rowLines = lines.slice(1).filter(function (line) {
					return !isMarkdownSeparatorLine(line);
				});
				var current = paragraph.nextElementSibling;

				while (current && current.tagName && current.tagName.toLowerCase() === 'p') {
					var currentLines = markdownLinesFromParagraph(current);
					if (!currentLines.length) {
						if (rowLines.length) break;
						current = current.nextElementSibling;
						continue;
					}

					consumedParagraphs.push(current);
					currentLines.forEach(function (line) {
						if (!isMarkdownSeparatorLine(line)) rowLines.push(line);
					});
					current = current.nextElementSibling;
				}

				if (!rowLines.length) return;
				if (insertPriceTable(paragraph, headers, rowLines, consumedParagraphs)) converted += 1;
			});
			return converted;
		}

		function replaceTextNodes(replacements, matcher) {
			if (!document.body || !document.createTreeWalker || !window.NodeFilter) return 0;
			var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
				acceptNode: function (node) {
					var parent = node.parentElement;
					if (!parent || parent.closest('script, style, noscript, svg, #wpadminbar')) return NodeFilter.FILTER_REJECT;
					return matcher(node.nodeValue || '') ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
				}
			});
			var nodes = [];
			while (walker.nextNode()) nodes.push(walker.currentNode);

			nodes.forEach(function (node) {
				var value = node.nodeValue || '';
				replacements.forEach(function (pair) {
					value = value.replace(pair[0], pair[1]);
				});
				node.nodeValue = value;
			});
			return nodes.length;
		}

		function repairCareContextCopy() {
			return replaceTextNodes([
				[/Privat hemtjänst/g, 'Hemnära stöd'],
				[/Ledsagning/g, 'Praktisk hjälp'],
				[/^Omsorg$/g, 'Vardagshjälp'],
				[/Omsorg • Hemnära stöd • Praktisk hjälp/g, 'Vardagshjälp • Hemnära stöd • Praktisk hjälp'],
				[/omsorg och precision/g, 'omtanke och noggrannhet'],
				[/med omsorg och precision/g, 'med omtanke och noggrannhet'],
				[/vård och omsorg/g, 'service och kundnära arbete'],
				[/hjälpa med medicin/g, 'hjälpa med praktiska vardagsbestyr']
			], function (value) {
				return /(Privat hemtjänst|Ledsagning|^Omsorg$|Omsorg • Hemnära stöd • Praktisk hjälp|omsorg och precision|vård och omsorg|hjälpa med medicin)/i.test(String(value || '').trim());
			});
		}

		function repairVisibleContentTypography() {
			return replaceTextNodes([
				[/^\s*—\s*$/g, ''],
				[/\s+—\s+/g, ' '],
				[/\s+,/g, ',']
			], function (value) {
				return /(—|\s,)/.test(value || '');
			});
		}

		function repairContactDuplicateHeading() {
			if (!/\/kontakt\/?$/i.test(window.location.pathname || '')) return 0;
			var repaired = 0;
			Array.prototype.slice.call(document.querySelectorAll('main h2, .wp-site-blocks h2')).forEach(function (heading) {
				if (textOf(heading) !== 'Hur kan vi hjälpa dig?') return;
				heading.textContent = 'Välj vad du behöver hjälp med';
				heading.setAttribute('data-sb-contact-heading-repaired', 'true');
				repaired += 1;
			});
			return repaired;
		}

		function run() {
			if (!document.body) return;
			var convertedTables = convertPriceMarkdownTables();
			var careNodes = repairCareContextCopy();
			var typographyNodes = repairVisibleContentTypography();
			var contactHeadings = repairContactDuplicateHeading();

			document.documentElement.dataset.sbContentSeoCleanupHotfix = 'applied';
			document.documentElement.dataset.sbContentSeoCleanupCounts = [
				'tables:' + convertedTables,
				'care:' + careNodes,
				'typography:' + typographyNodes,
				'contact:' + contactHeadings
			].join(',');
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', run);
		} else {
			run();
		}
		window.addEventListener('load', run);
	})();
	</script>
	<?php
}, 1006 );
// SENIORBOLAGET STAGING CONTENT SEO CLEANUP HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING CTA FOCUS HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v14.php
 * or remove this block, then clear staging cache.
 * Scope: staging focus management for closed helper/CTA panels. Production is not changed.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-cta-focus-hotfix-20260618">
	(function () {
		'use strict';

		function setFocusableState(container, enabled) {
			Array.prototype.slice.call(container.querySelectorAll('a, button, input, select, textarea, [tabindex]')).forEach(function (control) {
				if (!control.hasAttribute('data-sb-original-tabindex')) {
					control.setAttribute('data-sb-original-tabindex', control.getAttribute('tabindex') || '');
				}

				if (enabled) {
					var original = control.getAttribute('data-sb-original-tabindex') || '';
					if (original) control.setAttribute('tabindex', original);
					else control.removeAttribute('tabindex');
				} else {
					control.setAttribute('tabindex', '-1');
				}
			});
		}

		function elementIntersectsViewport(element) {
			var style = window.getComputedStyle(element);
			var rect = element.getBoundingClientRect();
			return style.display !== 'none' &&
				style.visibility !== 'hidden' &&
				Number(style.opacity || 1) !== 0 &&
				rect.width > 0 &&
				rect.height > 0 &&
				rect.bottom > 0 &&
				rect.top < window.innerHeight - 4 &&
				rect.right > 0 &&
				rect.left < window.innerWidth;
		}

		function repairCtaFocusState() {
			Array.prototype.slice.call(document.querySelectorAll('#sb-bs-panel, .sb-bs-panel')).forEach(function (panel) {
				var open = elementIntersectsViewport(panel);
				panel.setAttribute('aria-hidden', open ? 'false' : 'true');
				setFocusableState(panel, open);
			});

			Array.prototype.slice.call(document.querySelectorAll('#sb-fab-menu')).forEach(function (menu) {
				var open = menu.classList.contains('open');
				menu.setAttribute('aria-hidden', open ? 'false' : 'true');
				setFocusableState(menu, open);
			});

			document.documentElement.dataset.sbCtaFocusHotfix = 'applied';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', repairCtaFocusState);
		} else {
			repairCtaFocusState();
		}
		window.addEventListener('load', repairCtaFocusState);
		window.addEventListener('resize', repairCtaFocusState);
		document.addEventListener('click', function () {
			window.setTimeout(repairCtaFocusState, 0);
		});
	})();
	</script>
	<?php
}, 1007 );
// SENIORBOLAGET STAGING CTA FOCUS HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING FAB HANDLER HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v15.php
 * or remove this block, then clear staging cache.
 * Scope: staging helper/FAB menu handler fallback. Production is not changed.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-fab-handler-hotfix-20260618">
	(function () {
		'use strict';

		function setFocusableState(container, enabled) {
			Array.prototype.slice.call(container.querySelectorAll('a, button, input, select, textarea, [tabindex]')).forEach(function (control) {
				if (!control.hasAttribute('data-sb-original-tabindex')) {
					control.setAttribute('data-sb-original-tabindex', control.getAttribute('tabindex') || '');
				}

				if (enabled) {
					var original = control.getAttribute('data-sb-original-tabindex') || '';
					if (original) control.setAttribute('tabindex', original);
					else control.removeAttribute('tabindex');
				} else {
					control.setAttribute('tabindex', '-1');
				}
			});
		}

		function installFabHandler() {
			var menu = document.getElementById('sb-fab-menu');
			var button = document.getElementById('sb-fab-btn');
			if (!menu || !button) return;

			window.sbFab = function () {
				var open = !menu.classList.contains('open');
				menu.classList.toggle('open', open);
				button.classList.toggle('open', open);
				button.setAttribute('aria-expanded', open ? 'true' : 'false');
				menu.setAttribute('aria-hidden', open ? 'false' : 'true');
				setFocusableState(menu, open);
				document.documentElement.dataset.sbFabHandlerHotfix = 'applied';
			};
			window.sbFab.__sbRepaired = true;

			if (!button.getAttribute('onclick') && button.getAttribute('data-sb-fab-click-repaired') !== 'true') {
				button.addEventListener('click', function (event) {
					event.preventDefault();
					window.sbFab();
				});
				button.setAttribute('data-sb-fab-click-repaired', 'true');
			}

			menu.setAttribute('aria-hidden', menu.classList.contains('open') ? 'false' : 'true');
			setFocusableState(menu, menu.classList.contains('open'));
			document.documentElement.dataset.sbFabHandlerHotfix = 'ready';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', installFabHandler);
		} else {
			installFabHandler();
		}
		window.addEventListener('load', installFabHandler);
	})();
	</script>
	<?php
}, 1008 );
// SENIORBOLAGET STAGING FAB HANDLER HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING FOOTER LINK AFFORDANCE HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v16.php
 * or remove this block, then clear staging cache.
 * Scope: staging visible non-color affordance for footer links. Production is not changed.
 */
add_action( 'wp_head', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<style id="seniorbolaget-staging-footer-link-affordance-hotfix-20260618">
		footer a:not(.wp-block-button__link),
		.sb-footer a {
			text-decoration-line: underline !important;
			text-decoration-style: solid !important;
			text-decoration-thickness: 1px !important;
			text-underline-offset: 0.18em !important;
		}
	</style>
	<?php
}, 1009 );
// SENIORBOLAGET STAGING FOOTER LINK AFFORDANCE HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING FOOTER CONTRAST HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v17.php
 * or remove this block, then clear staging cache.
 * Scope: staging footer contrast for the live WordPress template part. Production is not changed.
 */
add_action( 'wp_head', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<style id="seniorbolaget-staging-footer-contrast-hotfix-20260618">
		footer.wp-block-template-part,
		.sb-footer {
			background: #1F2937 !important;
		}

		footer.wp-block-template-part,
		footer.wp-block-template-part *,
		.sb-footer,
		.sb-footer * {
			opacity: 1 !important;
		}

		footer.wp-block-template-part p,
		footer.wp-block-template-part a,
		footer.wp-block-template-part span,
		footer.wp-block-template-part li,
		.sb-footer p,
		.sb-footer a,
		.sb-footer span,
		.sb-footer li {
			color: #FFFFFF !important;
		}
	</style>
	<?php
}, 1010 );
// SENIORBOLAGET STAGING FOOTER CONTRAST HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING MOBILE FOOTER LAYOUT HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v18.php
 * or remove this block, then clear staging cache.
 * Scope: staging mobile footer wrapping/stacking for the live footer markup. Production is not changed.
 */
add_action( 'wp_head', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<style id="seniorbolaget-staging-mobile-footer-layout-hotfix-20260618">
		@media (max-width: 700px) {
			footer.wp-block-template-part,
			footer.wp-block-template-part .sb-footer {
				overflow-x: clip !important;
			}

			footer.wp-block-template-part .sb-footer {
				box-sizing: border-box !important;
				margin-left: 0 !important;
				margin-right: 0 !important;
				max-width: 100% !important;
				padding-left: 16px !important;
				padding-right: 16px !important;
				width: 100% !important;
			}

			footer.wp-block-template-part .sb-footer-inner,
			footer.wp-block-template-part .sb-footer-grid,
			footer.wp-block-template-part .sb-footer-bottom,
			footer.wp-block-template-part .sb-footer-col-brand,
			footer.wp-block-template-part .sb-footer-col-links-wrapper {
				box-sizing: border-box !important;
				max-width: 100% !important;
				min-width: 0 !important;
				width: 100% !important;
			}

			footer.wp-block-template-part .sb-footer-grid,
			footer.wp-block-template-part .sb-footer-col-links-wrapper {
				display: grid !important;
				gap: 24px !important;
				grid-template-columns: minmax(0, 1fr) !important;
			}

			footer.wp-block-template-part .sb-footer-col-links-wrapper > *,
			footer.wp-block-template-part .sb-footer-bottom > * {
				box-sizing: border-box !important;
				min-width: 0 !important;
				width: 100% !important;
			}

			footer.wp-block-template-part .sb-footer-bottom {
				align-items: flex-start !important;
				display: flex !important;
				flex-direction: column !important;
				gap: 12px !important;
			}

			footer.wp-block-template-part .sb-footer a,
			footer.wp-block-template-part .sb-footer p,
			footer.wp-block-template-part .sb-footer span,
			footer.wp-block-template-part .sb-footer li {
				overflow-wrap: anywhere !important;
			}
		}
	</style>
	<?php
}, 1011 );
// SENIORBOLAGET STAGING MOBILE FOOTER LAYOUT HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING DECORATIVE EMOJI POLICY HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v19.php
 * or remove this block, then clear staging cache.
 * Scope: staging visible text consistency. Keeps trust checkmarks/star ratings, removes colorful decorative emoji prefixes.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-decorative-emoji-policy-hotfix-20260618">
	(function () {
		var selectors = [
			'#sb-fab-menu a',
			'.sb-fab-opt',
			'.option-badge',
			'.option-label',
			'.service-icon',
			'.service-card a',
			'main a',
			'main span',
			'main p',
			'main h1',
			'main h2',
			'main h3'
		].join(',');
		var decorative = /^(?:\s|&nbsp;)*(?:📍|📞|🏢|👴|🧹|🌿|🔨|🖌️|🖌|⭐)\s*/;

		function normalizeDecorativeEmojiText() {
			Array.prototype.slice.call(document.querySelectorAll(selectors)).forEach(function (element) {
				Array.prototype.slice.call(element.childNodes).forEach(function (node) {
					if (node.nodeType !== 3 || !decorative.test(node.nodeValue || '')) return;
					node.nodeValue = node.nodeValue.replace(decorative, '');
				});
			});
			document.documentElement.dataset.sbDecorativeEmojiPolicyHotfix = 'applied';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', normalizeDecorativeEmojiText);
		} else {
			normalizeDecorativeEmojiText();
		}
		window.addEventListener('load', normalizeDecorativeEmojiText);
	})();
	</script>
	<?php
}, 1012 );
// SENIORBOLAGET STAGING DECORATIVE EMOJI POLICY HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING DECORATIVE EMOJI POLICY V21 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v20.php
 * or remove this block, then clear staging cache.
 * Scope: broader staging traversal for colorful decorative emoji prefixes in main/CTA/footer text.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-decorative-emoji-policy-v21-hotfix-20260618">
	(function () {
		var decorative = /^(?:\s|&nbsp;)*(?:📍|📞|🏢|👴|🧹|🌿|🔨|🖌️|🖌|⭐)\s*/;

		function cleanNode(node) {
			if (!node) return;
			if (node.nodeType === 3) {
				if (decorative.test(node.nodeValue || '')) {
					node.nodeValue = node.nodeValue.replace(decorative, '');
				}
				return;
			}
			if (node.nodeType !== 1 || /script|style|noscript/i.test(node.tagName || '')) return;
			Array.prototype.slice.call(node.childNodes).forEach(cleanNode);
		}

		function normalizeDecorativeEmojiTextV21() {
			[
				document.querySelector('main'),
				document.getElementById('sb-fab-menu'),
				document.getElementById('sb-bs-panel'),
				document.querySelector('.sb-bs-panel'),
				document.querySelector('footer')
			].forEach(cleanNode);
			document.documentElement.dataset.sbDecorativeEmojiPolicyV21Hotfix = 'applied';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', normalizeDecorativeEmojiTextV21);
		} else {
			normalizeDecorativeEmojiTextV21();
		}
		window.addEventListener('load', normalizeDecorativeEmojiTextV21);
	})();
	</script>
	<?php
}, 1013 );
// SENIORBOLAGET STAGING DECORATIVE EMOJI POLICY V21 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING DECORATIVE EMOJI POLICY V22 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v21.php
 * or remove this block, then clear staging cache.
 * Scope: broad staging traversal for colorful decorative emoji prefixes in full site-block tree.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-decorative-emoji-policy-v22-hotfix-20260618">
	(function () {
		var decorative = /^(?:\s|&nbsp;)*(?:📍|📞|🏢|👴|🧹|🌿|🔨|🎨|🖌️|🖌|⭐)\s*/;

		function cleanNode(node) {
			if (!node) return;
			if (node.nodeType === 3) {
				if (decorative.test(node.nodeValue || '')) {
					node.nodeValue = node.nodeValue.replace(decorative, '');
				}
				return;
			}
			if (node.nodeType !== 1 || /script|style|noscript/i.test(node.tagName || '')) return;
			Array.prototype.slice.call(node.childNodes).forEach(cleanNode);
		}

		function normalizeDecorativeEmojiTextV22() {
			[
				document.querySelector('.wp-site-blocks'),
				document.querySelector('main'),
				document.getElementById('sb-fab-menu'),
				document.getElementById('sb-bs-panel'),
				document.querySelector('.sb-bs-panel'),
				document.querySelector('footer'),
				document.body
			].forEach(cleanNode);
			document.documentElement.dataset.sbDecorativeEmojiPolicyV22Hotfix = 'applied';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', normalizeDecorativeEmojiTextV22);
		} else {
			normalizeDecorativeEmojiTextV22();
		}
		window.addEventListener('load', normalizeDecorativeEmojiTextV22);
	})();
	</script>
	<?php
}, 1014 );
// SENIORBOLAGET STAGING DECORATIVE EMOJI POLICY V22 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING NEUTRAL CITY IMAGES V23 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v22.php
 * or remove this block, then clear staging cache.
 * Scope: replace verified broken franchisee image files with neutral staging-safe SVGs.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}

	$path = parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH );
	if ( ! is_string( $path ) || ! preg_match( '#^/har-finns-vi(?:/|$)#', $path ) ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-neutral-city-images-v23-hotfix-20260618">
	(function () {
		function decodeImageValue(value) {
			try {
				return decodeURIComponent(String(value || ''));
			} catch (error) {
				return String(value || '');
			}
		}

		function buildNeutralServiceSvg(variant) {
			var accent = ['#C91C22', '#3F7D4F', '#D18A24'][variant % 3];
			var foreground = [
				'<path d="M72 162l78-62 78 62" fill="none" stroke="#C91C22" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/>',
				'<rect x="92" y="156" width="116" height="74" rx="10" fill="#ffffff" stroke="#E6D8CB" stroke-width="4"/>',
				'<rect x="136" y="184" width="28" height="46" rx="4" fill="#EFE2D7"/>',
				'<circle cx="286" cy="166" r="33" fill="#E7F1E6" stroke="#BFD7BD" stroke-width="4"/>',
				'<path d="M286 137v90M256 168c23 3 43-5 60-24M258 190c24 1 44-5 62-22" fill="none" stroke="#3F7D4F" stroke-width="5" stroke-linecap="round"/>'
			];

			if (variant % 3 === 1) {
				foreground = [
					'<path d="M92 212c34-62 68-88 104-78 32 9 45 43 30 78H92z" fill="#E7F1E6" stroke="#BFD7BD" stroke-width="4"/>',
					'<path d="M128 204c22-38 52-58 90-62M158 218c-2-44 12-78 42-104" fill="none" stroke="#3F7D4F" stroke-width="7" stroke-linecap="round"/>',
					'<rect x="246" y="134" width="72" height="88" rx="14" fill="#ffffff" stroke="#E6D8CB" stroke-width="4"/>',
					'<path d="M262 178h40M282 158v40" stroke="#C91C22" stroke-width="8" stroke-linecap="round"/>'
				];
			} else if (variant % 3 === 2) {
				foreground = [
					'<rect x="82" y="146" width="116" height="78" rx="12" fill="#ffffff" stroke="#E6D8CB" stroke-width="4"/>',
					'<path d="M110 178h58M110 200h42" stroke="#C91C22" stroke-width="8" stroke-linecap="round"/>',
					'<path d="M248 122l54 54M302 122l-54 54" stroke="#D18A24" stroke-width="12" stroke-linecap="round"/>',
					'<circle cx="275" cy="199" r="28" fill="#E7F1E6" stroke="#BFD7BD" stroke-width="4"/>',
					'<path d="M261 199l10 10 22-24" fill="none" stroke="#3F7D4F" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>'
				];
			}

			return [
				'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300" preserveAspectRatio="xMidYMid slice" role="img" aria-label="Seniorbolaget">',
				'<rect width="400" height="300" fill="#FAF7F2"/>',
				'<circle cx="338" cy="58" r="72" fill="' + accent + '" opacity="0.10"/>',
				'<circle cx="62" cy="252" r="92" fill="#EFE7DC" opacity="0.72"/>',
				'<path d="M0 242c46-16 82-17 130-4 63 17 116 15 178-7 39-14 70-17 92-12v81H0z" fill="#F0E8DD"/>',
				foreground.join(''),
				'</svg>'
			].join('');
		}

		function neutralServiceImageSrc(index) {
			return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(buildNeutralServiceSvg(index));
		}

		function imageNeedsReplacement(image) {
			var haystack = [
				image.getAttribute('alt') || '',
				decodeImageValue(image.getAttribute('src') || ''),
				decodeImageValue(image.getAttribute('srcset') || '')
			].join(' ');

			return /(bild\s+kommer\s+snart|foto\s+(kommer|uppdateras)|uppdateras\s+snart)/i.test(haystack)
				|| /franchisee_(laholm-bastad|landskrona|nassjo|sundsvall|torsby|trelleborg|trollhattan)/i.test(haystack);
		}

		function replaceImage(image, index) {
			image.src = neutralServiceImageSrc(index);
			image.alt = 'Seniorbolaget, hushållsnära tjänster';
			image.removeAttribute('srcset');
			image.removeAttribute('sizes');
			image.classList.add('sb-neutral-service-image');
			image.setAttribute('data-sb-neutral-service-image', 'true');
		}

		function patch(root) {
			var scope = root && root.querySelectorAll ? root : document;
			var replacements = 0;
			Array.prototype.slice.call(scope.querySelectorAll('img')).forEach(function (image) {
				if (image.getAttribute('data-sb-neutral-service-image') === 'true') return;
				if (!imageNeedsReplacement(image)) return;
				replaceImage(image, replacements);
				replacements += 1;
			});

			if (replacements > 0) {
				document.documentElement.dataset.sbNeutralCityImagesV23Hotfix = 'applied';
			} else if (!document.documentElement.dataset.sbNeutralCityImagesV23Hotfix) {
				document.documentElement.dataset.sbNeutralCityImagesV23Hotfix = 'ready';
			}
		}

		function run() {
			if (!document.body) return;
			patch(document);
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', run);
		} else {
			run();
		}
		window.addEventListener('load', run);
		window.setTimeout(run, 1500);

		if (window.MutationObserver) {
			new MutationObserver(function (mutations) {
				mutations.forEach(function (mutation) {
					Array.prototype.slice.call(mutation.addedNodes || []).forEach(function (node) {
						if (node && node.nodeType === 1) patch(node);
					});
				});
			}).observe(document.documentElement, { childList: true, subtree: true });
		}
	})();
	</script>
	<?php
}, 1015 );
// SENIORBOLAGET STAGING NEUTRAL CITY IMAGES V23 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING CONTENT WORDING V24 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v23.php
 * or remove this block, then clear staging cache.
 * Scope: fix visible wording regressions around "lösning" copy on staging.
 */
add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-content-wording-v24-hotfix-20260618">
	(function () {
		function repairContentWordingV24() {
			if (!document.body || !document.createTreeWalker || !window.NodeFilter) return;

			var replacements = [
				[/skräddarsydda lösningar/g, 'anpassade snickeriarbeten'],
				[/anpassada lösningar/g, 'anpassade snickeriarbeten'],
				[/Vi anpassar lösningen efter dig\./g, 'Vi anpassar arbetet efter dig.'],
				[/så hittar rätt lösning vi en lösning som passar dig perfekt\./g, 'så hittar vi rätt tjänst för ditt uppdrag.'],
				[/så hittar vi rätt lösning som passar dig\./g, 'så hittar vi rätt tjänst som passar dig.']
			];

			var matcher = /(skräddarsydda lösningar|anpassada lösningar|Vi anpassar lösningen efter dig\.|så hittar rätt lösning vi en lösning som passar dig perfekt\.|så hittar vi rätt lösning som passar dig\.)/;
			var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
				acceptNode: function (node) {
					var parent = node.parentElement;
					if (!parent || parent.closest('script, style, noscript, svg, #wpadminbar')) return NodeFilter.FILTER_REJECT;
					return matcher.test(node.nodeValue || '') ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
				}
			});
			var nodes = [];
			while (walker.nextNode()) nodes.push(walker.currentNode);

			nodes.forEach(function (node) {
				var value = node.nodeValue || '';
				replacements.forEach(function (pair) {
					value = value.replace(pair[0], pair[1]);
				});
				node.nodeValue = value;
			});

			document.documentElement.dataset.sbContentWordingV24Hotfix = nodes.length ? 'applied' : 'ready';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', repairContentWordingV24);
		} else {
			repairContentWordingV24();
		}
		window.addEventListener('load', repairContentWordingV24);
	})();
	</script>
	<?php
}, 1016 );
// SENIORBOLAGET STAGING CONTENT WORDING V24 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING FONT PERFORMANCE V25 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v24.php
 * or remove this block, then clear staging cache.
 * Scope: remove unused Google Font payloads on staging frontend only.
 */
function seniorbolaget_staging_dequeue_unused_google_fonts_v25() {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}

	$font_handles = array(
		'seniorbolaget-fonts',
		'elementor-gf-roboto',
		'elementor-gf-robotoslab',
	);

	foreach ( $font_handles as $handle ) {
		wp_dequeue_style( $handle );
		wp_deregister_style( $handle );
	}
}
add_action( 'wp_enqueue_scripts', 'seniorbolaget_staging_dequeue_unused_google_fonts_v25', 1000 );
// SENIORBOLAGET STAGING FONT PERFORMANCE V25 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING LOGO DIMENSIONS V25 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v24.php
 * or remove these two blocks, then clear staging cache.
 * Scope: reserve header/footer logo dimensions to reduce mobile CLS on staging.
 */
add_action( 'wp_head', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<style id="seniorbolaget-staging-logo-dimensions-v25-hotfix-20260618">
	.sb-logo img{aspect-ratio:175/56!important;display:block!important;height:56px!important;max-width:175px!important;object-fit:contain!important;width:175px!important}
	.sb-footer-logo{aspect-ratio:149/36!important;display:block!important;height:36px!important;max-width:190px!important;object-fit:contain!important;width:149px!important}
	</style>
	<?php
}, 7 );

add_action( 'wp_footer', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<script id="seniorbolaget-staging-logo-dimensions-v25-hotfix-20260618">
	(function () {
		function applyLogoDimensionsV25() {
			var headerLogo = document.querySelector('a.sb-logo img');
			var headerSrc = headerLogo ? (headerLogo.currentSrc || headerLogo.getAttribute('src') || '') : '';

			Array.prototype.slice.call(document.querySelectorAll('a.sb-logo img')).forEach(function (image) {
				image.setAttribute('width', '175');
				image.setAttribute('height', '56');
				image.setAttribute('loading', 'eager');
				image.setAttribute('fetchpriority', 'high');
				image.setAttribute('decoding', 'async');
			});

			Array.prototype.slice.call(document.querySelectorAll('img.sb-footer-logo')).forEach(function (image) {
				if (!image.getAttribute('src') && headerSrc) {
					image.setAttribute('src', headerSrc);
				}
				image.setAttribute('width', '149');
				image.setAttribute('height', '36');
				image.setAttribute('decoding', 'async');
			});

			document.documentElement.dataset.sbLogoDimensionsV25Hotfix = 'applied';
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', applyLogoDimensionsV25);
		} else {
			applyLogoDimensionsV25();
		}
		window.addEventListener('load', applyLogoDimensionsV25);
	})();
	</script>
	<?php
}, 1017 );
// SENIORBOLAGET STAGING LOGO DIMENSIONS V25 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING LATE FONT CLEANUP V26 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v25.php
 * or remove this block, then clear staging cache.
 * Scope: remove late Elementor Google Font links, resource hints and font preloads on staging frontend.
 */
function seniorbolaget_staging_unused_google_font_handles_v26() {
	return array(
		'seniorbolaget-fonts',
		'elementor-gf-roboto',
		'elementor-gf-robotoslab',
	);
}

function seniorbolaget_staging_is_google_font_url_v26( $url ) {
	$url = is_array( $url ) && isset( $url['href'] ) ? $url['href'] : $url;

	return is_string( $url ) && (
		false !== strpos( $url, 'fonts.googleapis.com' )
		|| false !== strpos( $url, 'fonts.gstatic.com' )
	);
}

function seniorbolaget_staging_dequeue_unused_google_fonts_late_v26() {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}

	foreach ( seniorbolaget_staging_unused_google_font_handles_v26() as $handle ) {
		wp_dequeue_style( $handle );
		wp_deregister_style( $handle );
	}
}
add_action( 'wp_print_styles', 'seniorbolaget_staging_dequeue_unused_google_fonts_late_v26', 1000 );

function seniorbolaget_staging_remove_unused_google_font_styles_v26( $html, $handle ) {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return $html;
	}

	if ( in_array( $handle, seniorbolaget_staging_unused_google_font_handles_v26(), true ) ) {
		return '';
	}

	return $html;
}
add_filter( 'style_loader_tag', 'seniorbolaget_staging_remove_unused_google_font_styles_v26', 100, 2 );

function seniorbolaget_staging_remove_google_font_resource_hints_v26( $urls, $relation_type ) {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host || ! in_array( $relation_type, array( 'dns-prefetch', 'preconnect' ), true ) ) {
		return $urls;
	}

	return array_values( array_filter( $urls, function ( $url ) {
		return ! seniorbolaget_staging_is_google_font_url_v26( $url );
	} ) );
}
add_filter( 'wp_resource_hints', 'seniorbolaget_staging_remove_google_font_resource_hints_v26', 100, 2 );

function seniorbolaget_staging_remove_google_font_preloads_v26( $preloads ) {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return $preloads;
	}

	return array_values( array_filter( $preloads, function ( $preload ) {
		return ! seniorbolaget_staging_is_google_font_url_v26( $preload );
	} ) );
}
add_filter( 'wp_preload_resources', 'seniorbolaget_staging_remove_google_font_preloads_v26', 100 );
// SENIORBOLAGET STAGING LATE FONT CLEANUP V26 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING GOOGLE FONT LINK STRIP V28 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v27.php
 * or remove this block and the WAS-201 staging guard, then clear staging cache.
 * Scope: remove remaining manually printed Google Fonts resource hints/preloads on staging HTML.
 */
add_action( 'template_redirect', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host || is_admin() ) {
		return;
	}

	ob_start( function ( $html ) {
		if ( false === strpos( $html, 'fonts.googleapis.com' ) && false === strpos( $html, 'fonts.gstatic.com' ) ) {
			return $html;
		}

		$html = preg_replace( '/<link\b(?=[^>]*(?:fonts\.googleapis\.com|fonts\.gstatic\.com))[^>]*>\s*/i', '', $html );
		$html = preg_replace( '/@font-face\s*\{[^{}]*fonts\.gstatic\.com[^{}]*\}\s*/i', '', $html );

		return $html;
	} );
}, 0 );
// SENIORBOLAGET STAGING GOOGLE FONT LINK STRIP V28 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING MOBILE CLS RESERVATION V30 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v29.php
 * or remove this block, then clear staging cache.
 * Scope: reserve mobile hero/wizard height early to reduce lab CLS on staging.
 */
add_action( 'wp_head', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<style id="seniorbolaget-staging-mobile-cls-reservation-v30-hotfix-20260618">
	@media (max-width:700px){
		body.home .sb-hero-section{min-height:672px!important}
		body.home .sb-hero-section>div{min-height:672px!important;transform:none!important}
		body.home .sb-hero-section *,body.is-wizard-page .wizard-container *{animation-duration:.001ms!important;transition-duration:.001ms!important}
		body.is-wizard-page .wizard-container{min-height:1000px!important}
		body.is-wizard-page .wizard-container[x-cloak]{display:block!important;visibility:hidden!important}
	}
	</style>
	<?php
}, 6 );
// SENIORBOLAGET STAGING MOBILE CLS RESERVATION V30 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING SECURITY/CSP V31 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v30.php
 * or remove this block, then clear staging cache.
 * Scope: add an explicit worker-src for WordPress emoji/blob workers on staging.
 */
add_action( 'send_headers', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host || headers_sent() ) {
		return;
	}

	header_remove( 'Content-Security-Policy' );
	header( "Content-Security-Policy: default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval'; img-src 'self' https: data:; font-src 'self' https: data:; worker-src 'self' blob:; child-src 'self' blob:" );
}, 999 );
// SENIORBOLAGET STAGING SECURITY/CSP V31 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING COOKIE FIRST IMPRESSION V31 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v30.php
 * or remove this block, then clear staging cache.
 * Scope: keep Complianz consent visible but move it out of the hero center on first visit.
 */
add_action( 'wp_head', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host ) {
		return;
	}
	?>
	<style id="seniorbolaget-staging-cookie-first-impression-v31-hotfix-20260618">
	.cmplz-cookiebanner.banner-1{bottom:clamp(16px,3vw,32px)!important;box-shadow:0 18px 50px rgba(17,24,39,.18)!important;left:auto!important;max-height:min(560px,calc(100vh - 32px))!important;max-width:calc(100vw - 32px)!important;right:clamp(16px,3vw,32px)!important;top:auto!important;transform:none!important;width:min(526px,calc(100vw - 32px))!important}
	.cmplz-cookiebanner.banner-1 .cmplz-body{max-height:min(300px,42vh)!important}
	@media (max-width:700px){
		.cmplz-cookiebanner.banner-1{bottom:12px!important;grid-gap:8px!important;left:12px!important;max-height:46vh!important;max-width:none!important;padding:12px 14px!important;right:12px!important;width:auto!important}
		.cmplz-cookiebanner.banner-1 .cmplz-header{grid-template-columns:1fr auto!important}
		.cmplz-cookiebanner.banner-1 .cmplz-title{grid-column-start:1!important;justify-self:start!important}
		.cmplz-cookiebanner.banner-1 .cmplz-close{grid-column-start:2!important}
		.cmplz-cookiebanner.banner-1 .cmplz-body{max-height:18vh!important;min-width:0!important}
		.cmplz-cookiebanner.banner-1 .cmplz-buttons{gap:8px!important}
		.cmplz-cookiebanner.banner-1 .cmplz-btn{min-height:44px!important}
	}
	</style>
	<?php
}, 1000 );
// SENIORBOLAGET STAGING COOKIE FIRST IMPRESSION V31 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING LANDMARK NORMALIZATION V31 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v30.php
 * or remove this block, then clear staging cache.
 * Scope: demote outer WordPress template-part wrapper landmarks and add a main wrapper when the rendered page has none.
 */
function seniorbolaget_staging_demote_outer_template_part_v31( $html, $tag, $class_name, $close_marker = '', $open_prefix = '' ) {
	$open = '<' . $tag . ' class="wp-block-template-part">';
	$pos  = stripos( $html, $open );
	if ( false === $pos ) {
		return $html;
	}

	$replacement = $open_prefix . '<div class="wp-block-template-part ' . $class_name . '" data-sb-original-landmark="' . $tag . '">';
	$html        = substr_replace( $html, $replacement, $pos, strlen( $open ) );
	$depth       = 1;
	$pattern     = '/<\/?' . preg_quote( $tag, '/' ) . '\b[^>]*>/i';

	if ( ! preg_match_all( $pattern, $html, $matches, PREG_OFFSET_CAPTURE, $pos + strlen( $replacement ) ) ) {
		return $html;
	}

	foreach ( $matches[0] as $match ) {
		$token = $match[0];
		$index = $match[1];

		if ( 0 === stripos( $token, '</' . $tag ) ) {
			$depth--;
		} else {
			$depth++;
		}

		if ( 0 === $depth ) {
			return substr_replace( $html, '</div>' . $close_marker, $index, strlen( $token ) );
		}
	}

	return $html;
}

function seniorbolaget_staging_add_main_wrapper_v31( $html ) {
	$start_marker = '<!-- sb-main-start-v31 -->';
	$end_marker   = '<!-- sb-main-end-v31 -->';
	$start        = strpos( $html, $start_marker );
	$end          = strpos( $html, $end_marker );

	if ( false === $start || false === $end || $end <= $start ) {
		return $html;
	}

	$between_start = $start + strlen( $start_marker );
	$between       = substr( $html, $between_start, $end - $between_start );

	if ( false !== stripos( $between, '<main' ) ) {
		return str_replace( array( $start_marker, $end_marker ), '', $html );
	}

	$html = substr_replace( $html, '<main id="main" class="site-main sb-staging-main-hotfix-v31">', $start, strlen( $start_marker ) );
	$end  = strpos( $html, $end_marker, $start );
	if ( false !== $end ) {
		$html = substr_replace( $html, '</main>', $end, strlen( $end_marker ) );
	}

	return $html;
}

add_action( 'template_redirect', function () {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host || is_admin() ) {
		return;
	}

	ob_start( function ( $html ) {
		if ( false === strpos( $html, 'wp-block-template-part' ) ) {
			return $html;
		}

		$html = seniorbolaget_staging_demote_outer_template_part_v31(
			$html,
			'header',
			'sb-template-part-header-v31',
			'<!-- sb-main-start-v31 -->'
		);
		$html = seniorbolaget_staging_demote_outer_template_part_v31(
			$html,
			'footer',
			'sb-template-part-footer-v31',
			'',
			'<!-- sb-main-end-v31 -->'
		);

		return seniorbolaget_staging_add_main_wrapper_v31( $html );
	} );
}, 1 );
// SENIORBOLAGET STAGING LANDMARK NORMALIZATION V31 HOTFIX END 2026-06-18

/**
 * SENIORBOLAGET STAGING WP I18N SCRIPT ORDER V32 HOTFIX START 2026-06-18
 * Rollback: restore ARTIFACTS/launch-hardening/20260617-1555/filemanager-functions-deploy-20260618-0925/functions-after-v31.php
 * or remove this block, then clear staging cache.
 * Scope: keep WordPress inline i18n bootstrap dependencies synchronous while preserving broader staging defer behavior.
 */
function seniorbolaget_staging_keep_wp_i18n_dependencies_sync_v32( $tag, $handle, $src ) {
	$host = $_SERVER['HTTP_HOST'] ?? '';
	if ( 'staging.seniorbolaget.se' !== $host || is_admin() ) {
		return $tag;
	}

	if ( ! in_array( $handle, array( 'wp-hooks', 'wp-i18n' ), true ) ) {
		return $tag;
	}

	return preg_replace( '/\sdefer(?:=(["\'])defer\1)?/i', '', $tag );
}
add_filter( 'script_loader_tag', 'seniorbolaget_staging_keep_wp_i18n_dependencies_sync_v32', 1000, 3 );
// SENIORBOLAGET STAGING WP I18N SCRIPT ORDER V32 HOTFIX END 2026-06-18
