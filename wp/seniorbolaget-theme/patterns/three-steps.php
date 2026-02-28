<?php
/**
 * Title: Vår process i tre steg
 * Slug: seniorbolaget/three-steps
 * Categories: seniorbolaget
 * Viewport Width: 1280
 */
?>
<!-- wp:html -->
<style>
    :root {
        --sb-red: #C91C22;
        --sb-dark-text: #1F2937;
        --sb-section-bg: #FAFAF8;
        --sb-card-bg: #FFFFFF;
        --sb-warm-accent: #FFF0EC;
        --sb-text-muted: #6B7280;
    }

    /* General reset and base styles */
    .sb-process-section {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        background-color: var(--sb-section-bg);
        padding: 64px 20px;
        color: var(--sb-dark-text);
        position: relative;
        overflow: hidden; /* Ensure overflow for card animations */
    }

    .sb-process-container {
        max-width: 1200px;
        margin: 0 auto;
        text-align: center;
        position: relative;
    }

    .sb-process-header .sb-subheading {
        color: var(--sb-red);
        font-size: 0.8rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 8px;
        display: block;
    }

    .sb-process-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-top: 0;
        margin-bottom: 48px;
        line-height: 1.2;
    }

    .sb-card-grid {
        display: flex;
        flex-direction: column;
        gap: 32px;
        position: relative;
        z-index: 10; /* Ensure cards are above the line */
        justify-content: center;
        align-items: center;
    }

    @media (min-width: 768px) {
        .sb-card-grid {
            flex-direction: row;
        }
    }


    .sb-step-card {
        background-color: var(--sb-card-bg);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 40px 24px;
        max-width: 360px;
        width: 100%;
        text-align: center;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: opacity 0.8s cubic-bezier(0.16,1,0.3,1), transform 0.8s cubic-bezier(0.16,1,0.3,1), box-shadow 0.3s ease;
        opacity: 0;
        transform: translateY(32px);
    }

    .sb-step-card.sb-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .sb-step-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 48px rgba(0, 0, 0, 0.12);
    }

    .sb-step-badge {
        background-color: var(--sb-red);
        color: var(--sb-card-bg);
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        font-size: 1.5rem;
        position: absolute;
        top: -24px; /* Half of height to center on top edge */
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .sb-step-card h3 {
        color: var(--sb-dark-text);
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 24px;
        margin-bottom: 16px;
    }

    .sb-step-card p {
        color: var(--sb-text-muted);
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* SVG Base Styles */
    .sb-svg-illustration {
        margin-bottom: 24px;
        width: 100%;
        display: block;
    }
    .sb-svg-illustration svg {
        width: 100%;
        height: 180px;
        display: block;
    }
    .sb-svg-illustration path,
    .sb-svg-illustration line,
    .sb-svg-illustration circle,
    .sb-svg-illustration rect,
    .sb-svg-illustration polyline {
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none; /* Default fill */
        stroke: var(--sb-dark-text); /* Default stroke */
    }
    .sb-svg-illustration .sb-skin { fill: #FDDBB4; stroke: var(--sb-dark-text); }
    .sb-svg-illustration .sb-red { stroke: var(--sb-red); fill: var(--sb-red); }
    .sb-svg-illustration .sb-dark { stroke: var(--sb-dark-text); }
    .sb-svg-illustration .sb-accent { fill: var(--sb-warm-accent); stroke: var(--sb-warm-accent); }
    .sb-svg-illustration .sb-card-fill { fill: var(--sb-card-bg); }
    .sb-svg-illustration .sb-text-muted { stroke: var(--sb-text-muted); fill: var(--sb-text-muted); }
    .sb-svg-illustration .sb-no-fill { fill: none; }

    /* Keyframe Animations for SVGs */

    /* Step 1: Wave Pulse */
    @keyframes wavePulse {
        0% { opacity: 0.3; }
        50% { opacity: 1; }
        100% { opacity: 0.3; }
    }
    #step1-waves path:nth-child(1) { animation: wavePulse 2s infinite ease-in-out; }
    #step1-waves path:nth-child(2) { animation: wavePulse 2s infinite ease-in-out 0.4s; }
    #step1-waves path:nth-child(3) { animation: wavePulse 2s infinite ease-in-out 0.8s; }

    /* Step 2: Heart Beat */
    @keyframes heartBeat {
        0% { transform: scale(1); }
        50% { transform: scale(1.15); }
        100% { transform: scale(1); }
    }
    .sb-step-card.sb-visible #step2-heart.animate {
        animation: heartBeat 1.5s infinite ease-in-out;
        transform-origin: center center;
    }

    /* Step 3: Float Heart */
    @keyframes floatHeart {
        0% { transform: translateY(0) scale(0.8); opacity: 0.8; }
        100% { transform: translateY(-40px) scale(1.2); opacity: 0; }
    }
    #step3-hearts .sb-heart-float:nth-child(1) { animation: floatHeart 3s infinite ease-out; }
    #step3-hearts .sb-heart-float:nth-child(2) { animation: floatHeart 3s infinite ease-out 1s; }
    #step3-hearts .sb-heart-float:nth-child(3) { animation: floatHeart 3s infinite ease-out 2s; }
</style>

<section class="sb-process-section">
    <div class="sb-process-container">
        <div class="sb-process-header">
            <span class="sb-subheading">SÅ ENKELT FUNGERAR DET</span>
            <h2>Vår process i tre steg</h2>
        </div>

        <div class="sb-card-grid">


            <!-- Card 1: Vi lyssnar på dina behov -->
            <div class="sb-step-card" data-step="1">
                <div class="sb-step-badge">1</div>
                <div class="sb-svg-illustration">
                    <svg viewBox="0 0 200 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Woman -->
                        <path class="sb-skin" d="M100 80C100 80 120 70 120 50C120 30 100 20 80 20C60 20 40 30 40 50C40 70 60 80 60 80" stroke="var(--sb-dark-text)"/>
                        <circle class="sb-dark" cx="70" cy="40" r="2"/>
                        <circle class="sb-dark" cx="90" cy="40" r="2"/>
                        <path class="sb-dark" d="M80 60C80 60 75 65 85 65" stroke="var(--sb-dark-text)"/>
                        <path class="sb-dark" d="M60 80L50 110" stroke="var(--sb-dark-text)"/>
                        <path class="sb-dark" d="M100 80L110 110" stroke="var(--sb-dark-text)"/>
                        <rect class="sb-skin" x="40" y="80" width="80" height="30" rx="15" stroke="var(--sb-dark-text)"/>
                        <path class="sb-dark" d="M50 110C50 110 40 120 40 130C40 140 50 140 60 140C70 140 80 140 90 140C100 140 110 140 120 140C130 140 140 130 140 120C140 110 130 100 120 100" stroke="var(--sb-dark-text)"/>
                        <path class="sb-dark" d="M120 110L110 140" stroke="var(--sb-dark-text)"/>
                        <path class="sb-dark" d="M40 130L30 160" stroke="var(--sb-dark-text)"/>
                        <path class="sb-dark" d="M130 130L140 160" stroke="var(--sb-dark-text)"/>
                        <rect class="sb-dark" x="20" y="150" width="120" height="20" rx="10"/>

                        <!-- Tea cup -->
                        <path class="sb-dark" d="M160 120C160 120 150 130 140 130L130 130C120 130 110 120 110 120V110C110 100 120 90 130 90H140C150 90 160 100 160 110V120Z"/>
                        <path class="sb-dark" d="M160 115C160 115 170 110 170 100C170 90 160 85 155 85"/>
                        
                        <!-- Speech waves -->
                        <g id="step1-waves">
                            <path class="sb-dark" d="M125 45C135 40 145 40 155 45" stroke-dasharray="2 2" stroke-opacity="0.3"/>
                            <path class="sb-dark" d="M125 55C135 50 145 50 155 55" stroke-dasharray="2 2" stroke-opacity="0.3"/>
                            <path class="sb-dark" d="M125 65C135 60 145 60 155 65" stroke-dasharray="2 2" stroke-opacity="0.3"/>
                        </g>
                    </svg>
                </div>
                <h3>Vi lyssnar på dina behov</h3>
                <p>Berätta för oss vad du behöver hjälp med, så skräddarsyr vi en lösning som passar dig perfekt.</p>
            </div>

            <!-- Card 2: Vi matchar rätt senior -->
            <div class="sb-step-card" data-step="2">
                <div class="sb-step-badge">2</div>
                <div class="sb-svg-illustration">
                    <svg viewBox="0 0 200 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Left person (older) -->
                        <circle class="sb-skin" cx="60" cy="60" r="20" stroke="var(--sb-dark-text)"/>
                        <path class="sb-dark" d="M60 80V120M40 100L60 120L80 100"/>
                        <path class="sb-dark" d="M50 120L40 160M70 120L80 160"/>
                        
                        <!-- Right person (younger) -->
                        <circle class="sb-skin" cx="140" cy="65" r="18" stroke="var(--sb-dark-text)"/>
                        <path class="sb-dark" d="M140 83V115M125 95L140 115L155 95"/>
                        <path class="sb-dark" d="M130 115L120 155M150 115L160 155"/>

                        <!-- Connecting line -->
                        <line class="sb-dark" x1="80" y1="95" x2="120" y2="98" stroke-dasharray="5 5"/>

                        <!-- Heart -->
                        <g id="step2-heart">
                            <path class="sb-red" fill="var(--sb-red)" d="M100 85 C90 75 70 75 70 95 C70 115 90 125 100 135 C110 125 130 115 130 95 C130 75 110 75 100 85Z" stroke="var(--sb-red)"/>
                        </g>
                    </svg>
                </div>
                <h3>Vi matchar rätt senior</h3>
                <p>Vi hittar den senior som bäst matchar dina önskemål och behov, både kompetensmässigt och personligt.</p>
            </div>

            <!-- Card 3: Hjälpen är igång -->
            <div class="sb-step-card" data-step="3">
                <div class="sb-step-badge">3</div>
                <div class="sb-svg-illustration">
                    <svg viewBox="0 0 200 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Older person with apron -->
                        <circle class="sb-skin" cx="60" cy="50" r="15" stroke="var(--sb-dark-text)"/>
                        <path class="sb-dark" d="M60 65V100M40 80L60 100L80 80"/>
                        <path class="sb-dark" d="M50 100L40 140M70 100L80 140"/>
                        <rect class="sb-red" x="45" y="70" width="30" height="30" rx="5" fill="var(--sb-red)"/>
                        <path class="sb-dark" d="M45 80H75M45 90H75"/>

                        <!-- Younger person -->
                        <circle class="sb-skin" cx="120" cy="70" r="12" stroke="var(--sb-dark-text)"/>
                        <path class="sb-dark" d="M120 82V110M110 95L120 110L130 95"/>
                        <path class="sb-dark" d="M115 110L110 135M125 110L130 135"/>
                        
                        <!-- Sun -->
                        <circle class="sb-warm-accent" cx="170" cy="30" r="20" fill="var(--sb-warm-accent)" stroke="var(--sb-dark-text)"/>
                        <line class="sb-dark" x1="170" y1="10" x2="170" y2="50"/>
                        <line class="sb-dark" x1="150" y1="30" x2="190" y2="30"/>
                        <line class="sb-dark" x1="156" y1="16" x2="184" y2="44"/>
                        <line class="sb-dark" x1="184" y1="16" x2="156" y2="44"/>

                        <!-- Floating hearts -->
                        <g id="step3-hearts">
                            <path class="sb-red sb-heart-float sb-no-fill" fill="var(--sb-red)" d="M100 50 C95 45 85 45 85 55 C85 65 95 70 100 75 C105 70 115 65 115 55 C115 45 105 45 100 50Z" style="transform-origin: center;"/>
                            <path class="sb-red sb-heart-float sb-no-fill" fill="var(--sb-red)" d="M130 60 C125 55 115 55 115 65 C115 75 125 80 130 85 C135 80 145 75 145 65 C145 55 135 55 130 60Z" style="transform-origin: center;"/>
                            <path class="sb-red sb-heart-float sb-no-fill" fill="var(--sb-red)" d="M90 70 C85 65 75 65 75 75 C75 85 85 90 90 95 C95 90 105 85 105 75 C105 65 95 65 90 70Z" style="transform-origin: center;"/>
                        </g>
                    </svg>
                </div>
                <h3>Hjälpen är igång</h3>
                <p>Njut av den extra tid och avlastning som våra erfarna seniorer bidrar med i ditt hem eller företag.</p>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.sb-step-card');

        if (cards.length === 0) {
            return;
        }

        const options = {
            root: null, // viewport
            rootMargin: '0px',
            threshold: 0.1 // 10% of the target element is visible
        };

        let delay = 0;
        const staggerDelay = 220; // ms

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const card = entry.target;
                    const step = parseInt(card.dataset.step, 10); // Use parseInt with radix

                    setTimeout(() => {
                        card.classList.add('sb-visible');
                        if (step === 2) {
                            const heart = card.querySelector('#step2-heart');
                            if (heart) {
                                heart.classList.add('animate');
                            }
                        }
                    }, delay);
                    delay += staggerDelay;
                    observer.unobserve(card); // Stop observing once visible
                }
            });
        }, options);

        cards.forEach(card => {
            observer.observe(card);
        });
    });
</script>
<!-- /wp:html -->