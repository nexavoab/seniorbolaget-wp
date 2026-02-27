<?php
/**
 * Title: Intresseanmälan - Wizard
 * Slug: seniorbolaget/intresse-anmalan-page
 * Categories: seniorbolaget, info
 * Description: 4-stegs lead-gen wizard för tjänsteförfrågningar
 * Viewport Width: 1440
 */
?>

<!-- wp:html {"align":"full"} -->
<div class="wizard-container" x-data="wizardApp()" x-cloak>
    <div class="wizard-inner">
        
        <!-- Progress dots - simplified without x-for -->
        <div class="progress-dots">
            <div class="progress-dot" :class="{ 'active': step === 1, 'completed': step > 1 }"></div>
            <div class="progress-dot" :class="{ 'active': step === 2, 'completed': step > 2 }"></div>
            <div class="progress-dot" :class="{ 'active': step === 3, 'completed': step > 3 }"></div>
            <div class="progress-dot" :class="{ 'active': step === 4, 'completed': step > 4 }"></div>
        </div>
        <p class="step-label" x-show="step < 5">Steg <span x-text="step"></span> av 4</p>
        
        <!-- STEP 1: Choose service -->
        <div x-show="step === 1" x-transition>
            <div class="wizard-header">
                <h1 class="wizard-title">Vad behöver du hjälp med?</h1>
                <p class="wizard-subtitle">Välj en tjänst nedan</p>
            </div>
            
            <div class="service-cards">
                <div class="service-card" @click="selectService('hemstadning')" :class="{ 'selected': formData.service === 'hemstadning' }">
                    <span class="service-icon">🧹</span>
                    <div class="service-info">
                        <p class="service-name">Hemstädning</p>
                        <p class="service-desc">Regelbunden eller engångsstädning</p>
                    </div>
                </div>
                <div class="service-card" @click="selectService('tradgard')" :class="{ 'selected': formData.service === 'tradgard' }">
                    <span class="service-icon">🌿</span>
                    <div class="service-info">
                        <p class="service-name">Trädgård</p>
                        <p class="service-desc">Gräsklippning, häck, ogräs och mer</p>
                    </div>
                </div>
                <div class="service-card" @click="selectService('snickeri')" :class="{ 'selected': formData.service === 'snickeri' }">
                    <span class="service-icon">🔨</span>
                    <div class="service-info">
                        <p class="service-name">Snickeri</p>
                        <p class="service-desc">Allt från hyllor till större projekt</p>
                    </div>
                </div>
                <div class="service-card" @click="selectService('malning')" :class="{ 'selected': formData.service === 'malning' }">
                    <span class="service-icon">🎨</span>
                    <div class="service-info">
                        <p class="service-name">Målning</p>
                        <p class="service-desc">Inomhus och utomhus</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- STEP 2: Choose city -->
        <div x-show="step === 2" x-transition>
            <button class="back-btn" @click="step = 1" type="button">← Tillbaka</button>
            
            <div class="wizard-header">
                <h1 class="wizard-title">Var finns du?</h1>
                <p class="wizard-subtitle">Välj din ort</p>
            </div>
            
            <input type="text" class="city-search" placeholder="Sök ort..." x-model="citySearch" @input="filterCities()">
            
            <div class="city-list" x-html="renderCities()"></div>
        </div>
        
        <!-- STEP 3: Service details (dynamic) -->
        <div x-show="step === 3" x-transition>
            <button class="back-btn" @click="step = 2" type="button">← Tillbaka</button>
            
            <div class="wizard-header">
                <h1 class="wizard-title">Berätta mer om uppdraget</h1>
                <p class="wizard-subtitle" x-text="getServiceName()"></p>
            </div>
            
            <!-- Hemstädning fields -->
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
            
            <!-- Trädgård fields -->
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
            
            <!-- Snickeri/Målning fields -->
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
        
        <!-- STEP 4: Contact info -->
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
                <label for="gdpr" class="gdpr-text">
                    Jag godkänner att Seniorbolaget kontaktar mig och lagrar mina uppgifter enligt deras <a href="/integritetspolicy" target="_blank">integritetspolicy</a>.
                </label>
            </div>
            
            <button class="submit-btn" @click="submitForm()" :disabled="!canSubmit() || isSubmitting" type="button">
                <span x-show="isSubmitting" class="spinner"></span>
                <span x-text="isSubmitting ? 'Skickar...' : 'Skicka förfrågan →'"></span>
            </button>
        </div>
        
        <!-- STEP 5: Thank you -->
        <div x-show="step === 5" x-transition>
            <div class="thank-you">
                <div class="thank-icon">✓</div>
                <h2 class="thank-title">Tack för din förfrågan!</h2>
                <p class="thank-text">Vi har tagit emot dina uppgifter och återkommer inom 24 timmar.</p>
                
                <div class="thank-summary">
                    <div class="summary-row">
                        <span class="summary-label">Tjänst</span>
                        <span class="summary-value" x-text="getServiceName()"></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Ort</span>
                        <span class="summary-value" x-text="getCityName()"></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Namn</span>
                        <span class="summary-value" x-text="formData.name"></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Telefon</span>
                        <span class="summary-value" x-text="formData.phone"></span>
                    </div>
                </div>
                
                <a href="/" style="display:inline-block;padding:14px 28px;background:#C91C22;color:#fff;border-radius:50px;font-weight:600;text-decoration:none;">
                    Tillbaka till startsidan
                </a>
            </div>
        </div>
        
        <!-- Trust bar (visible on steps 1-4) -->
        <div class="trust-bar" x-show="step < 5">
            <span class="trust-item"><span class="trust-check">✓</span> Svar inom 24h</span>
            <span class="trust-item"><span class="trust-check">✓</span> Kostnadsfri offert</span>
            <span class="trust-item"><span class="trust-check">✓</span> Inga bindningstider</span>
        </div>
        
        <!-- Phone banner (visible on steps 1-4) -->
        <div class="phone-banner" x-show="step < 5">
            Föredrar du att ringa? <a href="tel:0101751900">010-175 19 00</a>
        </div>
        
    </div>
</div>
<!-- /wp:html -->
