<?php
/**
 * Seniorbolaget theme functions
 *
 * @package Seniorbolaget
 * @version 1.0.0
 */

define( 'SENIORBOLAGET_VERSION', '1.0.0' );

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
}

/**
 * Wizard CSS för intresseanmälan
 */
function seniorbolaget_wizard_css() {
	// Temporärt: ladda alltid för debugging
	?>
	<style id="seniorbolaget-wizard-css">
	/* Hard reset for WP layout conflicts - break out completely */
	.entry-content .wizard-container{all:initial!important;display:block!important;font-family:Inter,-apple-system,BlinkMacSystemFont,sans-serif!important;background:#FAFAF8!important;min-height:80vh!important;padding:0!important;width:100vw!important;max-width:none!important;margin:0!important;margin-left:calc(50% - 50vw)!important;box-sizing:border-box!important}
	.wizard-container *,.wizard-container *::before,.wizard-container *::after{box-sizing:border-box!important}
	.wizard-container .wizard-inner{display:block!important;max-width:640px!important;width:100%!important;margin:0 auto!important;padding:32px 24px 60px!important}
	.wizard-header{text-align:center!important;margin-bottom:32px!important;display:block!important;width:100%!important;max-width:100%!important}
	.wizard-title{font-family:Rubik,sans-serif!important;font-size:clamp(1.5rem,4vw,2rem)!important;font-weight:700!important;color:#1F2937!important;margin:0 0 8px!important;line-height:1.2!important;text-align:center!important;width:100%!important;max-width:100%!important}
	.wizard-subtitle{font-size:1rem!important;color:#6B7280!important;margin:0!important;text-align:center!important;width:100%!important;max-width:100%!important}
	
	/* ===== FÖRBÄTTRAD STEPPER (med stegnamn) ===== */
	.stepper{margin-bottom:32px!important;width:100%!important}
	.stepper-steps{display:flex!important;justify-content:center!important;align-items:flex-start!important;gap:0!important;margin-bottom:12px!important}
	.stepper-step{display:flex!important;flex-direction:column!important;align-items:center!important;gap:8px!important;min-width:60px!important}
	.stepper-dot{width:14px!important;height:14px!important;border-radius:50%!important;background:#e5e7eb!important;transition:all .3s!important;border:2px solid transparent!important}
	.stepper-step.active .stepper-dot{background:#C91C22!important;border-color:#C91C22!important;box-shadow:0 0 0 4px rgba(201,28,34,0.15)!important}
	.stepper-step.completed .stepper-dot{background:#C91C22!important;border-color:#C91C22!important}
	.stepper-name{font-size:12px!important;color:#9CA3AF!important;font-weight:500!important;text-align:center!important;transition:color .3s!important}
	.stepper-step.active .stepper-name,.stepper-step.completed .stepper-name{color:#1F2937!important;font-weight:600!important}
	.stepper-line{flex:1!important;height:2px!important;background:#e5e7eb!important;margin:7px 8px 0!important;max-width:40px!important;transition:background .3s!important}
	.stepper-line.completed{background:#C91C22!important}
	.step-counter{text-align:center!important;font-size:14px!important;color:#6B7280!important;margin:0!important;font-weight:500!important}
	@media(max-width:480px){
		.stepper-step{min-width:50px!important}
		.stepper-name{font-size:11px!important}
		.stepper-line{max-width:24px!important;margin:7px 4px 0!important}
	}
	
	/* ===== TILLBAKA-KNAPP (pill med ikon) ===== */
	.back-btn{display:inline-flex!important;align-items:center!important;gap:8px!important;color:#4B5563!important;font-size:.9375rem!important;font-weight:600!important;background:#fff!important;border:2px solid #e5e7eb!important;border-radius:50px!important;cursor:pointer!important;padding:10px 20px!important;margin-bottom:20px!important;transition:all .2s!important}
	.back-btn:hover{border-color:#C91C22!important;color:#C91C22!important;background:#FFF4F2!important}
	.back-icon{font-size:1rem!important;line-height:1!important}
	
	/* ===== SERVICE CARDS (med pil + checkmark) ===== */
	.service-cards{display:grid!important;grid-template-columns:1fr!important;gap:16px!important;width:100%!important;max-width:100%!important}
	.service-card{display:flex!important;flex-direction:row!important;align-items:center!important;gap:16px!important;padding:20px 24px!important;background:#fff!important;border:2px solid #e5e7eb!important;border-radius:16px!important;cursor:pointer!important;transition:all .2s ease!important;min-height:80px!important;width:100%!important;max-width:100%!important;position:relative!important}
	.service-card:hover{border-color:#C91C22!important;background:#FFF4F2!important;transform:translateY(-2px)!important;box-shadow:0 8px 24px -8px rgba(201,28,34,0.15)!important}
	.service-card.selected{border-color:#C91C22!important;background:#FFF4F2!important;border-width:3px!important}
	.service-icon{font-size:2rem!important;width:48px!important;text-align:center!important;flex-shrink:0!important}
	.service-info{flex:1!important;text-align:left!important}
	.service-name{font-family:Rubik,sans-serif!important;font-size:1.125rem!important;font-weight:600!important;color:#1F2937!important;margin:0 0 4px!important;text-align:left!important}
	.service-desc{font-size:.875rem!important;color:#6B7280!important;margin:0!important;text-align:left!important}
	.service-indicator{position:relative!important;width:32px!important;height:32px!important;flex-shrink:0!important;display:flex!important;align-items:center!important;justify-content:center!important}
	.service-arrow{font-size:1.25rem!important;color:#9CA3AF!important;transition:transform .2s, color .2s, opacity .2s!important;position:absolute!important}
	.service-arrow.hidden{opacity:0!important;transform:translateX(8px)!important}
	.service-card:hover .service-arrow:not(.hidden){color:#C91C22!important;transform:translateX(4px)!important}
	.service-check{display:flex!important;align-items:center!important;justify-content:center!important;width:28px!important;height:28px!important;background:#C91C22!important;color:#fff!important;border-radius:50%!important;font-size:1rem!important;font-weight:bold!important;opacity:0!important;transform:scale(0.5)!important;transition:opacity .2s, transform .2s!important;position:absolute!important}
	.service-check.visible{opacity:1!important;transform:scale(1)!important}
	.city-search{width:100%;padding:14px 18px;border:2px solid #e5e7eb;border-radius:50px;font-size:1rem;margin-bottom:16px;background:#fff;box-sizing:border-box}
	.city-search:focus{outline:none;border-color:#C91C22}
	.city-list{display:grid;gap:8px;max-height:400px;overflow-y:auto;padding:4px}
	.city-item{padding:16px 20px;background:#fff;border:2px solid #e5e7eb;border-radius:12px;cursor:pointer;font-size:1rem;font-weight:500;color:#1F2937;transition:all .2s}
	.city-item:hover,.city-item.selected{border-color:#C91C22;background:#FFF4F2}
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
				contactMethod: 'ring',
				gdprConsent: false
			},
			
			init() {
				this.filteredCities = this.cities;
			},
			
			selectService(service) {
				this.formData.service = service;
				this.step = 2;
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
			
			canProceedStep3() {
				if (this.formData.service === 'hemstadning') {
					return this.formData.area && this.formData.frequency;
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
                <button class="back-btn" @click="step = 1" type="button">← Tillbaka</button>
                <div class="wizard-header">
                    <h1 class="wizard-title">Var finns du?</h1>
                    <p class="wizard-subtitle">Välj din ort</p>
                </div>
                <input type="text" class="city-search" placeholder="Sök ort..." x-model="citySearch" @input="filterCities()">
                <div class="city-list" x-html="renderCities()"></div>
            </div>
            
            <div x-show="step === 3" x-transition>
                <button class="back-btn" @click="step = 2" type="button">← Tillbaka</button>
                <div class="wizard-header">
                    <h1 class="wizard-title">Berätta mer om uppdraget</h1>
                    <p class="wizard-subtitle" x-text="getServiceName()"></p>
                </div>
                
                <div x-show="formData.service === 'hemstadning'">
                    <div class="form-group">
                        <label class="form-label">Bostadsyta (kvm)</label>
                        <input type="number" class="form-input" placeholder="T.ex. 85" x-model="formData.area" min="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hur ofta vill du ha städning?</label>
                        <div class="radio-group">
                            <label class="radio-option" :class="{ 'selected': formData.frequency === 'varannan' }">
                                <input type="radio" name="frequency" value="varannan" x-model="formData.frequency">
                                <span class="option-label">Varannan vecka</span>
                                <span class="option-badge">⭐ Populär</span>
                            </label>
                            <label class="radio-option" :class="{ 'selected': formData.frequency === 'varfjarde' }">
                                <input type="radio" name="frequency" value="varfjarde" x-model="formData.frequency">
                                <span class="option-label">Var fjärde vecka</span>
                            </label>
                            <label class="radio-option" :class="{ 'selected': formData.frequency === 'engangsstadning' }">
                                <input type="radio" name="frequency" value="engangsstadning" x-model="formData.frequency">
                                <span class="option-label">Engångsstädning</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Husdjur hemma?</label>
                        <div class="radio-group" style="flex-direction: row; gap: 16px;">
                            <label class="radio-option" style="flex: 1;" :class="{ 'selected': formData.pets === 'ja' }">
                                <input type="radio" name="pets" value="ja" x-model="formData.pets">
                                <span class="option-label">Ja</span>
                            </label>
                            <label class="radio-option" style="flex: 1;" :class="{ 'selected': formData.pets === 'nej' }">
                                <input type="radio" name="pets" value="nej" x-model="formData.pets">
                                <span class="option-label">Nej</span>
                            </label>
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
                <button class="next-btn" @click="step = 4" :disabled="!canProceedStep3()" type="button">Nästa steg →</button>
            </div>
            
            <div x-show="step === 4" x-transition>
                <button class="back-btn" @click="step = 3" type="button">← Tillbaka</button>
                <div class="wizard-header">
                    <h1 class="wizard-title">Dina uppgifter</h1>
                    <p class="wizard-subtitle">Så vi kan kontakta dig</p>
                </div>
                <div x-show="errorMsg" class="error-msg" x-text="errorMsg"></div>
                <div class="form-group">
                    <label class="form-label">Förnamn</label>
                    <input type="text" class="form-input" placeholder="Ditt förnamn" x-model="formData.name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Telefonnummer</label>
                    <input type="tel" class="form-input" placeholder="070-123 45 67" x-model="formData.phone" required>
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
            
            <div class="trust-bar" x-show="step < 5">
                <span class="trust-item"><span class="trust-check">✓</span> Svar inom 24h</span>
                <span class="trust-item"><span class="trust-check">✓</span> Kostnadsfri offert</span>
                <span class="trust-item"><span class="trust-check">✓</span> Inga bindningstider</span>
            </div>
            <div class="phone-banner" x-show="step < 5">Föredrar du att ringa? <a href="tel:0101751900">010-175 19 00</a></div>
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



// ===== INTENTIONS BAR (WAS-68) — inline script approach =====
function sb_add_intentions_bar() {
    $html = '<style>
.sb-bar{position:fixed;bottom:0;left:0;right:0;z-index:9999;display:flex;justify-content:center;background:transparent;border-top:none;box-shadow:none;padding:16px 16px 20px;transform:translateY(100%);transition:transform .4s cubic-bezier(.16,1,.3,1);}
.sb-bar.show{transform:translateY(0);}
.sb-bar-inner{display:flex;gap:10px;align-items:center;flex-wrap:wrap;justify-content:center;max-width:600px;width:100%;}
.sb-btn{position:relative;overflow:hidden;display:inline-flex;align-items:center;padding:12px 22px;border-radius:50px;font-family:Rubik,sans-serif;font-size:.9375rem;font-weight:600;text-decoration:none;border:1.5px solid transparent;white-space:nowrap;transition:box-shadow .3s,border-color .3s;box-shadow:0 4px 16px rgba(0,0,0,0.22);}
.sb-btn-t,.sb-btn-f{display:inline-flex;align-items:center;gap:6px;}
.sb-btn-t{position:relative;z-index:1;transition:transform .3s,opacity .3s;}
.sb-btn-f{position:absolute;inset:0;justify-content:center;transform:translateY(100%);transition:transform .3s;border-radius:inherit;}
.sb-btn:hover .sb-btn-t{transform:translateY(-150%);opacity:0;}
.sb-btn:hover .sb-btn-f{transform:translateY(0);}
.sb-btn-r{background:#C91C22;color:#fff;}
.sb-btn-r .sb-btn-f{background:#a01018;color:#fff;}
.sb-btn-r:hover{box-shadow:0 4px 20px rgba(201,28,34,.35);}
.sb-btn-o{background:transparent;color:#1F2937;border-color:#e5e7eb;}
.sb-btn-o .sb-btn-f{background:#1F2937;color:#fff;}
.sb-btn-o:hover{border-color:#1F2937;}
.sb-x{background:none;border:none;cursor:pointer;color:#9CA3AF;font-size:1.25rem;padding:4px 8px;}
body{padding-bottom:76px!important;}
</style>
<div class="sb-bar" id="sbBar">
<div class="sb-bar-inner">
<a href="/intresseanmalan/" class="sb-btn sb-btn-r"><span class="sb-btn-t">🧹 Boka hjälp</span><span class="sb-btn-f">🧹 Boka hjälp</span></a>
<a href="/jobba-med-oss/" class="sb-btn sb-btn-o"><span class="sb-btn-t">👴 Jobba hos oss</span><span class="sb-btn-f">👴 Jobba hos oss</span></a>
<a href="/bli-franchisetagare/" class="sb-btn sb-btn-o"><span class="sb-btn-t">🏢 Hör av dig</span><span class="sb-btn-f">🏢 Hör av dig</span></a>
<button class="sb-x" onclick="document.getElementById(\'sbBar\').style.transform=\'translateY(100%)\';document.body.style.paddingBottom=\'0\';sessionStorage.setItem(\'sb_x\',1)">×</button>
</div></div>
<script>if(!sessionStorage.getItem(\'sb_x\')){var b=document.getElementById(\'sbBar\'),s=0;function sh(){if(s)return;s=1;b.classList.add(\'show\');}setTimeout(sh,4000);window.addEventListener(\'scroll\',function(){if(scrollY>300)sh();},{passive:true});}</script>';
    echo $html;
}
add_action( 'wp_footer', 'sb_add_intentions_bar', 100 );



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
