<?php
/**
 * Title: Jobba med oss - Infosida
 * Slug: seniorbolaget/jobba-med-oss-page
 * Categories: seniorbolaget, info
 * Description: Rekryteringssida för seniorer som vill jobba med Seniorbolaget
 * Viewport Width: 1440
 */
?>

<!-- HERO SECTION -->
<!-- wp:html -->
<div style="position:relative;min-height:85vh;display:flex;align-items:center;background-image:url('https://staging.seniorbolaget.se/wp-content/uploads/2026/02/work_senior.jpg');background-size:cover;background-position:center;overflow:hidden;">
  <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,0.65) 0%,rgba(0,0,0,0.35) 100%);"></div>
  <div style="position:relative;z-index:2;max-width:720px;padding:clamp(40px,8vw,100px) clamp(24px,5vw,80px);">
    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.3);border-radius:50px;padding:8px 16px;margin-bottom:24px;color:#fff;font-size:0.875rem;font-family:Inter,sans-serif;">
      ⭐⭐⭐⭐⭐ Tusentals nöjda kunder i Sverige
    </div>
    <h1 style="font-family:Rubik,sans-serif;font-size:clamp(2.25rem,5vw,3.5rem);font-weight:800;color:#fff;line-height:1.15;margin:0 0 20px;">Gör skillnad — jobba som senior</h1>
    <p style="font-family:Inter,sans-serif;font-size:clamp(1rem,1.5vw,1.25rem);color:rgba(255,255,255,0.9);line-height:1.7;margin:0 0 32px;max-width:560px;">Använd din erfarenhet, bestäm dina tider och tjäna extra — vi matchar dig med rätt uppdrag</p>
    <div style="margin-bottom:32px;">
      <a href="/intresseanmalan" style="display:inline-flex;align-items:center;gap:8px;background:#C91C22;color:#fff;font-family:Rubik,sans-serif;font-size:1.0625rem;font-weight:700;padding:16px 32px;border-radius:50px;text-decoration:none;box-shadow:0 4px 20px rgba(201,28,34,0.4);">Ansök här →</a>
    </div>
    <div style="display:flex;gap:12px;flex-wrap:wrap;">
      <span style="background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.3);color:#fff;font-family:Inter,sans-serif;font-size:0.8125rem;padding:6px 14px;border-radius:50px;">✓ Flexibla tider</span>
      <span style="background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.3);color:#fff;font-family:Inter,sans-serif;font-size:0.8125rem;padding:6px 14px;border-radius:50px;">✓ Välj dina uppdrag</span>
      <span style="background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.3);color:#fff;font-family:Inter,sans-serif;font-size:0.8125rem;padding:6px 14px;border-radius:50px;">✓ Erfarna kollegor</span>
    </div>
  </div>
</div>
<!-- /wp:html -->


<!-- JOBBANSÖKAN WIZARD (WAS-74 + WAS-84 redesign) -->
<!-- wp:html -->
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
        selectService(val) { this.formData.service = val; setTimeout(() => this.step = 3, 300); },
        selectExperience(val) { this.formData.experience = val; setTimeout(() => this.step = 4, 300); },
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
<div class="wizard-container" x-data="jobWizardApp()" x-cloak>
    <div class="wizard-inner">
        
        <!-- Stepper (samma som intresseanmälan) -->
        <div class="wiz-stepper" x-show="step < 5">
            <div class="wiz-step" :class="{ active: step === 1, completed: step > 1 }">
                <div class="wiz-step-circle" x-text="step > 1 ? '✓' : '1'"></div>
                <div class="wiz-step-label">Stad</div>
                <div class="wiz-step-value" x-text="step > 1 ? getCityName() : ''"></div>
            </div>
            <div class="wiz-step-line" :class="{ completed: step > 1 }"></div>
            <div class="wiz-step" :class="{ active: step === 2, completed: step > 2 }">
                <div class="wiz-step-circle" x-text="step > 2 ? '✓' : '2'"></div>
                <div class="wiz-step-label">Tjänst</div>
                <div class="wiz-step-value" x-text="step > 2 ? getServiceName() : ''"></div>
            </div>
            <div class="wiz-step-line" :class="{ completed: step > 2 }"></div>
            <div class="wiz-step" :class="{ active: step === 3, completed: step > 3 }">
                <div class="wiz-step-circle" x-text="step > 3 ? '✓' : '3'"></div>
                <div class="wiz-step-label">Erfarenhet</div>
                <div class="wiz-step-value"></div>
            </div>
            <div class="wiz-step-line" :class="{ completed: step > 3 }"></div>
            <div class="wiz-step" :class="{ active: step === 4, completed: step > 4 }">
                <div class="wiz-step-circle" x-text="step > 4 ? '✓' : '4'"></div>
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
                        @click="formData.city = city.value; step = 2;"
                        x-text="city.name">
                    </div>
                </template>
            </div>
        </div>
        
        <!-- STEG 2: Välj tjänst (svc-grid med SVG-ikoner) -->
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
                <!-- Flera tjänster -->
                <div class="svc-card" @click="selectService('flera')" :class="{ selected: formData.service === 'flera' }" style="grid-column: span 2;">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="38" fill="#F8FAFC"/>
                            <circle cx="27" cy="35" r="8" fill="#94A3B8" opacity="0.6"/>
                            <circle cx="40" cy="28" r="8" fill="#64748B" opacity="0.8"/>
                            <circle cx="53" cy="35" r="8" fill="#94A3B8" opacity="0.6"/>
                            <circle cx="40" cy="48" r="10" fill="#C91C22" opacity="0.9"/>
                            <text x="40" y="53" text-anchor="middle" fill="white" font-size="14" font-family="sans-serif">+</text>
                        </svg>
                    </div>
                    <div class="svc-card-name">Flera tjänster</div>
                    <div class="svc-card-desc">Jag kan hjälpa med mer än en sak</div>
                    <div class="svc-card-check">✓</div>
                </div>
            </div>
        </div>
        
        <!-- STEG 3: Erfarenhet (svc-grid med 3 kort) -->
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
        <div class="trust-section" x-show="step < 4">
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
<!-- /wp:html -->


<!-- VI SÖKER NU SECTION (NYTT) -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#C91C22"},"spacing":{"padding":{"top":"40px","bottom":"40px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="background-color:#C91C22;margin-top:0;padding-top:40px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:40px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:html -->
	<div style="text-align:center;">
		<p style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:700;color:#fff;margin:0 0 16px;">🔥 Vi söker just nu seniorer i:</p>
		<div style="display:flex;flex-wrap:wrap;justify-content:center;gap:10px;">
			<span style="background:rgba(255,255,255,0.2);border-radius:50px;padding:8px 18px;font-family:Inter,sans-serif;font-size:1rem;font-weight:600;color:#fff;">Göteborg</span>
			<span style="background:rgba(255,255,255,0.2);border-radius:50px;padding:8px 18px;font-family:Inter,sans-serif;font-size:1rem;font-weight:600;color:#fff;">Malmö</span>
			<span style="background:rgba(255,255,255,0.2);border-radius:50px;padding:8px 18px;font-family:Inter,sans-serif;font-size:1rem;font-weight:600;color:#fff;">Helsingborg</span>
			<span style="background:rgba(255,255,255,0.2);border-radius:50px;padding:8px 18px;font-family:Inter,sans-serif;font-size:1rem;font-weight:600;color:#fff;">Jönköping</span>
			<span style="background:rgba(255,255,255,0.2);border-radius:50px;padding:8px 18px;font-family:Inter,sans-serif;font-size:1rem;font-weight:600;color:#fff;">Örebro</span>
			<span style="background:rgba(255,255,255,0.2);border-radius:50px;padding:8px 18px;font-family:Inter,sans-serif;font-size:1rem;font-weight:600;color:#fff;">+ 21 fler orter</span>
		</div>
	</div>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- LÖN SECTION (NYTT) -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FFFFFF"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="background-color:#FFFFFF;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700","fontSize":"2rem"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:2rem;font-weight:700;margin-bottom:1rem">Vad tjänar jag?</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#4B5563"},"typography":{"fontSize":"1.25rem"},"spacing":{"margin":{"bottom":"3rem"}}}} -->
	<p class="has-text-align-center" style="color:#4B5563;font-size:1.25rem;margin-bottom:3rem">Timlön med semesterersättning — ett bra tillskott till pensionen.</p>
	<!-- /wp:paragraph -->

	<!-- wp:html -->
	<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:800px;margin:0 auto;">
		<div style="background:#FAFAF8;border-radius:16px;padding:32px;text-align:center;">
			<p style="font-family:Inter,sans-serif;font-size:1rem;color:#6B7280;margin:0 0 8px;">Städning & trädgård</p>
			<p style="font-family:Rubik,sans-serif;font-size:2.25rem;font-weight:700;color:#1F2937;margin:0;">130 kr</p>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#6B7280;margin:8px 0 0;">per timme inkl. semester</p>
		</div>
		<div style="background:#FFF4F2;border:2px solid #C91C22;border-radius:16px;padding:32px;text-align:center;">
			<p style="font-family:Inter,sans-serif;font-size:1rem;color:#6B7280;margin:0 0 8px;">Hantverk (ROT)</p>
			<p style="font-family:Rubik,sans-serif;font-size:2.25rem;font-weight:700;color:#C91C22;margin:0;">160 kr</p>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#6B7280;margin:8px 0 0;">per timme inkl. semester</p>
		</div>
		<div style="background:#FAFAF8;border-radius:16px;padding:32px;text-align:center;">
			<p style="font-family:Inter,sans-serif;font-size:1rem;color:#6B7280;margin:0 0 8px;">Specialuppdrag</p>
			<p style="font-family:Rubik,sans-serif;font-size:2.25rem;font-weight:700;color:#1F2937;margin:0;">Enligt avtal</p>
			<p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#6B7280;margin:8px 0 0;">beroende på kompetens</p>
		</div>
	</div>
	<p style="text-align:center;font-family:Inter,sans-serif;font-size:0.9375rem;color:#6B7280;margin:24px 0 0;">Du väljer själv hur mycket du vill jobba — ingen minsta arbetstid.</p>
	<style>
	@media (max-width: 768px) {
		div[style*="grid-template-columns:repeat(3,1fr)"] { grid-template-columns: 1fr !important; }
	}
	</style>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- FÖRDELAR SECTION -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FAFAF8"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="background-color:#FAFAF8;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700","fontSize":"2rem"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"3rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:2rem;font-weight:700;margin-bottom:3rem">Fördelarna med att jobba hos oss</h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:1000px;margin:0 auto;">
		<div style="background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.04);">
			<div style="width:56px;height:56px;background:#FFF4F2;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:600;color:#1F2937;margin:0 0 10px;">Alltid försäkrad</h3>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:0;line-height:1.6;">Du och det uppdrag du utför är alltid försäkrat, vilket ger dig extra trygghet.</p>
		</div>
		<div style="background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.04);">
			<div style="width:56px;height:56px;background:#FFF4F2;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:600;color:#1F2937;margin:0 0 10px;">Du bestämmer</h3>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:0;line-height:1.6;">Välj själv vilka uppdrag du vill ta, när du vill jobba och hur mycket.</p>
		</div>
		<div style="background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.04);">
			<div style="width:56px;height:56px;background:#FFF4F2;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:600;color:#1F2937;margin:0 0 10px;">Socialt umgänge</h3>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:0;line-height:1.6;">Träffa kunder och kollegor. Det sociala är en stor del av det roliga.</p>
		</div>
		<div style="background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.04);">
			<div style="width:56px;height:56px;background:#FFF4F2;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:600;color:#1F2937;margin:0 0 10px;">Extra inkomst</h3>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:0;line-height:1.6;">Du får timlön med semesterersättning — ett bra tillskott till pensionen.</p>
		</div>
		<div style="background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.04);">
			<div style="width:56px;height:56px;background:#FFF4F2;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:600;color:#1F2937;margin:0 0 10px;">Meningsfullt</h3>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:0;line-height:1.6;">Gör skillnad i någons vardag. Ditt arbete underlättar livet för våra kunder.</p>
		</div>
		<div style="background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.04);">
			<div style="width:56px;height:56px;background:#FFF4F2;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:600;color:#1F2937;margin:0 0 10px;">Nära hemmet</h3>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:0;line-height:1.6;">Jobba lokalt. Vi finns på 26 orter runt om i Sverige.</p>
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


<!-- HUR DET FUNKAR SECTION -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FFFFFF"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="background-color:#FFFFFF;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700","fontSize":"2rem"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"3rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:2rem;font-weight:700;margin-bottom:3rem">Hur det funkar</h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div style="display:flex;gap:32px;max-width:900px;margin:0 auto;justify-content:center;flex-wrap:wrap;">
		<div style="flex:1;min-width:200px;max-width:280px;text-align:center;">
			<div style="width:72px;height:72px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
				<span style="font-family:Rubik,sans-serif;font-size:1.75rem;font-weight:700;color:#fff;">1</span>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:600;color:#1F2937;margin:0 0 10px;">Anmäl intresse</h3>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:0;line-height:1.6;">Kontakta oss via formuläret eller ring. Berätta om dig själv och vad du vill jobba med.</p>
		</div>
		<div style="flex:1;min-width:200px;max-width:280px;text-align:center;">
			<div style="width:72px;height:72px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
				<span style="font-family:Rubik,sans-serif;font-size:1.75rem;font-weight:700;color:#fff;">2</span>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:600;color:#1F2937;margin:0 0 10px;">Intervju</h3>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:0;line-height:1.6;">Du blir kallad till en intervju med din lokala franchisetagare. Vi går igenom din kompetens.</p>
		</div>
		<div style="flex:1;min-width:200px;max-width:280px;text-align:center;">
			<div style="width:72px;height:72px;background:#16a34a;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
				<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
			</div>
			<h3 style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:600;color:#1F2937;margin:0 0 10px;">Börja jobba!</h3>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:0;line-height:1.6;">Vi matchar din kompetens mot våra uppdrag. Du väljer själv vilka du vill ta.</p>
		</div>
	</div>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- FAQ SECTION (NYTT) -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FAFAF8"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group alignfull" style="background-color:#FAFAF8;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700","fontSize":"2rem"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"3rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:2rem;font-weight:700;margin-bottom:3rem">Vanliga frågor från seniorer</h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div style="display:flex;flex-direction:column;gap:16px;">
		<details style="background:#fff;border-radius:12px;padding:22px 26px;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,0.04);" open>
			<summary style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;list-style:none;display:flex;justify-content:space-between;align-items:center;">
				Måste jag vara pensionär?
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
			</summary>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:18px 0 0;line-height:1.7;">Nej, men vi söker främst seniorer 55+. Vi värdesätter livserfarenhet och yrkesbakgrund — inte exakt ålder.</p>
		</details>
		<details style="background:#fff;border-radius:12px;padding:22px 26px;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
			<summary style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;list-style:none;display:flex;justify-content:space-between;align-items:center;">
				Hur mycket måste jag jobba?
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
			</summary>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:18px 0 0;line-height:1.7;">Det finns ingen minsta arbetstid. Du väljer själv vilka uppdrag du tackar ja till, och hur ofta du vill jobba.</p>
		</details>
		<details style="background:#fff;border-radius:12px;padding:22px 26px;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
			<summary style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;list-style:none;display:flex;justify-content:space-between;align-items:center;">
				Vad händer om jag blir sjuk eller vill åka bort?
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
			</summary>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:18px 0 0;line-height:1.7;">Inga problem. Vi matchar alltid med andra seniorer om du behöver pausa. Du är inte bunden till fasta tider.</p>
		</details>
		<details style="background:#fff;border-radius:12px;padding:22px 26px;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
			<summary style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;list-style:none;display:flex;justify-content:space-between;align-items:center;">
				Behöver jag egen bil?
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
			</summary>
			<p style="font-family:Inter,sans-serif;font-size:1.0625rem;color:#4B5563;margin:18px 0 0;line-height:1.7;">Körkort och tillgång till bil är en fördel, men inte alltid ett krav. Det beror på uppdragens karaktär och var du bor.</p>
		</details>
	</div>
	<style>
	details summary::-webkit-details-marker { display: none; }
	details[open] summary svg { transform: rotate(180deg); }
	</style>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- KRAV SECTION -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FFFFFF"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group alignfull" style="background-color:#FFFFFF;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700","fontSize":"2rem"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"2rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:2rem;font-weight:700;margin-bottom:2rem">Vad vi söker</h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div style="background:#FAFAF8;border-radius:16px;padding:36px;max-width:500px;margin:0 auto;">
		<ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:18px;">
			<li style="display:flex;align-items:center;gap:14px;">
				<div style="width:28px;height:28px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
				</div>
				<span style="font-family:Inter,sans-serif;font-size:1.125rem;color:#1F2937;">Svenska i tal och skrift</span>
			</li>
			<li style="display:flex;align-items:center;gap:14px;">
				<div style="width:28px;height:28px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
				</div>
				<span style="font-family:Inter,sans-serif;font-size:1.125rem;color:#1F2937;">Körkort (fördel, ej krav)</span>
			</li>
			<li style="display:flex;align-items:center;gap:14px;">
				<div style="width:28px;height:28px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
				</div>
				<span style="font-family:Inter,sans-serif;font-size:1.125rem;color:#1F2937;">Serviceinriktad och noggrann</span>
			</li>
			<li style="display:flex;align-items:center;gap:14px;">
				<div style="width:28px;height:28px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
				</div>
				<span style="font-family:Inter,sans-serif;font-size:1.125rem;color:#1F2937;">Senior/pensionär 55+</span>
			</li>
		</ul>
	</div>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- CTA SECTION -->
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"100px","bottom":"100px"}},"color":{"background":"#C91C22"}},"layout":{"type":"constrained","contentSize":"700px"}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#C91C22;padding-top:100px;padding-bottom:100px;">

	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"clamp(1.75rem,4vw,2.5rem)","fontWeight":"700"},"color":{"text":"#ffffff"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#fff;font-size:clamp(1.75rem,4vw,2.5rem);font-weight:700;margin-bottom:1rem;">Ta steget — anmäl ditt intresse idag</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","style":{"color":{"text":"rgba(255,255,255,0.9)"},"typography":{"fontSize":"1.25rem"},"spacing":{"margin":{"bottom":"2.5rem"}}}} -->
	<p class="has-text-align-center" style="color:rgba(255,255,255,0.9);font-size:1.25rem;margin-bottom:2.5rem;">Välkommen till Seniorbolaget! Vi skulle bli glada om du valde att arbeta med oss.</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"vit","textColor":"rod","style":{"border":{"radius":"50px"},"spacing":{"padding":{"top":"1rem","bottom":"1rem","left":"2.5rem","right":"2.5rem"}},"typography":{"fontSize":"1.25rem","fontWeight":"700"}}} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-rod-color has-vit-background-color has-text-color has-background wp-element-button" href="/intresseanmalan/" style="border-radius:50px;padding:1rem 2.5rem;font-size:1.25rem;font-weight:700;">Anmäl intresse</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

	<!-- wp:paragraph {"align":"center","style":{"color":{"text":"rgba(255,255,255,0.8)"},"typography":{"fontSize":"1rem"},"spacing":{"margin":{"top":"1.5rem"}}}} -->
	<p class="has-text-align-center" style="color:rgba(255,255,255,0.8);font-size:1rem;margin-top:1.5rem;">Eller ring oss på 010-175 19 00 — så berättar vi mer.</p>
	<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
