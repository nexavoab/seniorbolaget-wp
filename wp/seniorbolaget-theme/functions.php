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
#sb-fab{position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;align-items:flex-end;gap:10px;}
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
</style>
<div id="sb-fab">
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
        add_filter('pre_get_document_title', function() { return 'Seniorbolaget — Hushållsnära tjänster av erfarna seniorer 55+'; }, 25);
        echo '<meta name="description" content="Boka hemstädning, trädgård, snickeri och målning av erfarna seniorer. RUT-avdrag direkt. Svar inom 2h. Verifierade franchisetagare nära dig.">' . "\n";
        echo '<meta property="og:title" content="Seniorbolaget — Hushållsnära tjänster av erfarna seniorer 55+">' . "\n";
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
        'hemstad' => ['Hemstädning med RUT-avdrag — Seniorbolaget', 'Boka hemstädning av erfarna seniorer 55+. Du betalar bara 50% efter RUT-avdrag. Regelbunden eller engångsstädning. Svar inom 2h.'],
        'tradgard' => ['Trädgårdshjälp av erfarna seniorer — Seniorbolaget', 'Gräsklippning, häck, ogräs och trädgårdsskötsel. Erfarna seniorer 55+ nära dig. RUT-avdrag. Boka idag.'],
        'malning-tapetsering' => ['Målning inomhus & utomhus — Seniorbolaget', 'Professionell målning av erfarna hantverkare 55+. Inomhus och utomhus. ROT-avdrag. Kostnadsfri offert.'],
        'snickeri' => ['Snickeri & byggtjänster — Seniorbolaget', 'Erfarna snickare 55+ för allt från hyllor till renoveringar. ROT-avdrag. Kostnadsfri offert. Svar inom 2h.'],
        'privat' => ['Hushållsnära tjänster för privatpersoner — Seniorbolaget', 'Hushållsnära tjänster av erfarna seniorer. RUT/ROT-avdrag. Verifierade franchisetagare. Boka idag.'],
        'foretag' => ['Företagstjänster & B2B — Seniorbolaget', 'Pålitlig bemanning, städning och underhåll för företag och BRF. Erfarna seniorer 55+. Faktura 30 dagar.'],
        'om-oss' => ['Om Seniorbolaget — Erfarna seniorer gör skillnad', 'Vi matchar erfarna seniorer 55+ med hushåll och företag som behöver pålitlig hjälp. Läs om vår historia och vision.'],
        'jobba-med-oss' => ['Jobba hos Seniorbolaget — Meningsfullt arbete för seniorer 55+', 'Älskar du att hjälpa andra? Jobba som hemtjänstpersonal hos Seniorbolaget. Flexibla tider, bra betalt, meningsfullt.'],
        'bli-franchisetagare' => ['Bli franchisetagare — Starta eget med Seniorbolaget', 'Starta din egen verksamhet under Seniorbolaget-varumärket. Beprövat koncept, stöd och utbildning ingår. Kostnadsfritt informationsmöte.'],
        'har-finns-vi' => ['Hitta Seniorbolaget nära dig — 26 orter i Sverige', 'Seniorbolaget finns i 26 städer. Hitta din lokala franchisetagare och boka hemtjänst direkt.'],
        'kontakt' => ['Kontakta Seniorbolaget — Ring eller boka online', 'Ring oss på 010-175 19 00 eller skicka en förfrågan. Vi svarar inom 2h på vardagar.'],
        'intresse-anmalan' => ['Boka hemtjänst — Seniorbolaget', 'Välj tjänst, ort och kontaktuppgifter. Vi återkommer inom 2h med offert. Kostnadsfritt och utan förbindelser.'],
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
            "Boka hemstädning, trädgård eller snickeri i {$city_name} av erfarna seniorer 55+. Lokal franchisetagare nära dig. RUT-avdrag. Svar inom 2h."
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
        'description' => 'Hushållsnära tjänster utförda av erfarna seniorer 55+',
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
        'hemstad'            => ['name'=>'Hemstädning','description'=>'Professionell hemstädning av erfarna seniorer 55+ med RUT-avdrag'],
        'tradgard'           => ['name'=>'Trädgård','description'=>'Trädgårdshjälp av erfarna seniorer — gräsklippning, häck och mer'],
        'malning-tapetsering'=> ['name'=>'Målning','description'=>'Inomhus och utomhus målning av erfarna hantverkare 55+'],
        'snickeri'           => ['name'=>'Snickeri','description'=>'Snickeri och byggtjänster av erfarna hantverkare 55+'],
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
                ['@type'=>'Question','name'=>'Vem utför jobbet?','acceptedAnswer'=>['@type'=>'Answer','text'=>'Alla uppdrag utförs av erfarna seniorer 55+ som är anställda och försäkrade via Seniorbolaget.']],
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


// ===== WAS-137/166: HTTP SECURITY HEADERS =====
add_action('send_headers', function() {
    if (!is_admin()) {
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
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>' . "\n";
    echo '<link rel="dns-prefetch" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1);


// ===== WAS-202: BACK-TO-TOP KNAPP =====
add_action('wp_footer', function() {
    ?>
    <button id="sb-back-to-top" aria-label="Tillbaka till toppen" style="
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #C91C22;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 20px;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    ">↑</button>
    <script>
    (function() {
        var btn = document.getElementById('sb-back-to-top');
        window.addEventListener('scroll', function() {
            btn.style.display = window.scrollY > 400 ? 'flex' : 'none';
        }, {passive: true});
        btn.addEventListener('click', function() {
            window.scrollTo({top: 0, behavior: 'smooth'});
        });
    })();
    </script>
    <?php
}, 101);


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
