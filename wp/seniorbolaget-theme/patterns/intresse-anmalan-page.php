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
        
        <!-- NEW: Progress stepper with labels and values -->
        <div class="wiz-stepper" x-show="step < 5">
            <div class="wiz-step" :class="{ active: step === 1, completed: step > 1 }">
                <div class="wiz-step-circle" x-text="getStepNum(1)"></div>
                <div class="wiz-step-label">Tjänst</div>
                <div class="wiz-step-value" x-text="getStepVal(1)"></div>
            </div>
            <div class="wiz-step-line" :class="{ completed: step > 1 }"></div>
            <div class="wiz-step" :class="{ active: step === 2, completed: step > 2 }">
                <div class="wiz-step-circle" x-text="getStepNum(2)"></div>
                <div class="wiz-step-label">Ort</div>
                <div class="wiz-step-value" x-text="getStepVal(2)"></div>
            </div>
            <div class="wiz-step-line" :class="{ completed: step > 2 }"></div>
            <div class="wiz-step" :class="{ active: step === 3, completed: step > 3 }">
                <div class="wiz-step-circle" x-text="getStepNum(3)"></div>
                <div class="wiz-step-label">Detaljer</div>
                <div class="wiz-step-value"></div>
            </div>
            <div class="wiz-step-line" :class="{ completed: step > 3 }"></div>
            <div class="wiz-step" :class="{ active: step === 4, completed: step > 4 }">
                <div class="wiz-step-circle" x-text="getStepNum(4)"></div>
                <div class="wiz-step-label">Kontakt</div>
                <div class="wiz-step-value"></div>
            </div>
        </div>
        
        <!-- STEP 1: Choose service — NEW 2×2 visual grid -->
        <div x-show="step === 1" x-transition>
            <div class="wizard-header">
                <h1 class="wizard-title">Vad behöver du hjälp med?</h1>
                <p class="wizard-subtitle">Välj en tjänst nedan</p>
            </div>
            
            <div class="svc-grid">
                <div class="svc-card" @click="selectService('hemstadning')" :class="{ 'selected': formData.service === 'hemstadning' }">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="40" cy="40" r="38" fill="#FFF4F2"/>
                            <path d="M30 22 L30 50 M30 50 L24 56 M30 50 L36 56 M30 50 L30 56 M44 30 L44 58 M44 58 L50 58 L56 40 L50 40 L50 30 L38 30 L38 40 L44 40" stroke="#C91C22" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="svc-card-name">Hemstädning</div>
                    <div class="svc-card-desc">Regelbunden eller engångsstädning med RUT-avdrag</div>
                    <div class="svc-card-check">✓</div>
                </div>
                
                <div class="svc-card" @click="selectService('tradgard')" :class="{ 'selected': formData.service === 'tradgard' }">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="40" cy="40" r="38" fill="#F0FDF4"/>
                            <path d="M40 20 C40 20 28 32 28 44 C28 51 33 56 40 56 C47 56 52 51 52 44 C52 32 40 20 40 20Z" fill="#22C55E" opacity="0.3" stroke="#16A34A" stroke-width="2"/>
                            <path d="M40 56 L40 68" stroke="#92400E" stroke-width="3" stroke-linecap="round"/>
                            <path d="M33 48 C36 44 40 46 40 46 C40 46 40 42 44 40" stroke="#16A34A" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="svc-card-name">Trädgård</div>
                    <div class="svc-card-desc">Gräsklippning, häck, ogräs och mer</div>
                    <div class="svc-card-check">✓</div>
                </div>
                
                <div class="svc-card" @click="selectService('snickeri')" :class="{ 'selected': formData.service === 'snickeri' }">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="40" cy="40" r="38" fill="#FFFBEB"/>
                            <rect x="26" y="24" width="28" height="16" rx="4" fill="#D97706" stroke="#92400E" stroke-width="1.5"/>
                            <path d="M40 40 L34 60" stroke="#78350F" stroke-width="4" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="svc-card-name">Snickeri</div>
                    <div class="svc-card-desc">Allt från hyllor till större projekt</div>
                    <div class="svc-card-check">✓</div>
                </div>
                
                <div class="svc-card" @click="selectService('malning')" :class="{ 'selected': formData.service === 'malning' }">
                    <div class="svc-card-icon">
                        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="40" cy="40" r="38" fill="#EEF2FF"/>
                            <rect x="22" y="28" width="32" height="18" rx="4" fill="#6366F1" stroke="#4338CA" stroke-width="1.5"/>
                            <rect x="30" y="32" width="16" height="10" rx="2" fill="#E0E7FF"/>
                            <path d="M42 46 L42 58 L50 58" stroke="#4338CA" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="svc-card-name">Målning</div>
                    <div class="svc-card-desc">Inomhus och utomhus målning</div>
                    <div class="svc-card-check">✓</div>
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
            
            <div style="position:relative;margin-bottom:16px;">
                <span style="position:absolute;left:18px;top:50%;transform:translateY(-50%);font-size:1.1rem;color:#9CA3AF;pointer-events:none;">🔍</span>
                <input type="text" class="city-search" style="padding-left:48px;" placeholder="Sök ort..." x-model="citySearch" @input="filterCities()">
            </div>
            
            <div class="city-list" x-html="renderCities()"></div>
            
            <p style="text-align:center;font-size:0.875rem;color:#6B7280;margin-top:20px;">
                Hittar du inte din ort? Ring <a href="tel:0101751900" style="color:#C91C22;font-weight:600;text-decoration:none;">010-175 19 00</a>
            </p>
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
                <h1 class="wizard-title">Sista steget!</h1>
                <p class="wizard-subtitle">Vi kontaktar dig inom 2h</p>
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
            
            <div style="display:flex;justify-content:center;align-items:center;gap:12px;flex-wrap:wrap;margin-top:20px;font-size:0.8125rem;color:#6B7280;">
                <span>🔒 Säker hantering</span>
                <span style="color:#e5e7eb;">|</span>
                <span>✓ Kostnadsfri offert</span>
                <span style="color:#e5e7eb;">|</span>
                <span>✓ Svar inom 2h</span>
            </div>
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
