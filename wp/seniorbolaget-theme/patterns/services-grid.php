<?php
/**
 * Title: Tjänster – Kort med modal
 * Slug: seniorbolaget/services-grid
 * Categories: seniorbolaget, services
 * Description: Tjänstekort med klickbar modal — ikon, förklaring, boka-CTA
 * Viewport Width: 1440
 */
?>
<!-- wp:html -->
<style>
/* ── Sektion ─────────────────────────────────────────────── */
.sb-svc-section {
    padding: 80px clamp(24px,5vw,80px);
    background: #FAFAF8;
    text-align: center;
}
.sb-svc-section h2 {
    font-family: Rubik, sans-serif;
    font-size: clamp(1.75rem,3vw,2.5rem);
    font-weight: 700;
    color: #1F2937;
    margin: 0 0 12px;
}
.sb-svc-sub {
    font-family: Inter, sans-serif;
    font-size: 1.125rem;
    color: #6B7280;
    margin: 0 0 48px;
}

/* ── Grid ────────────────────────────────────────────────── */
.sb-svc-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    max-width: 1100px;
    margin: 0 auto;
}
@media (min-width: 768px) {
    .sb-svc-grid { grid-template-columns: repeat(4, 1fr); }
}

/* ── Kort ────────────────────────────────────────────────── */
.sb-svc-card {
    position: relative;
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #E5E7EB;
    padding: 32px 20px 20px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    transition: box-shadow 0.25s ease, transform 0.25s ease, border-color 0.25s ease;
    text-align: center;
    outline: none;
}
.sb-svc-card:hover,
.sb-svc-card:focus {
    box-shadow: 0 12px 40px -8px rgba(0,0,0,0.12);
    transform: translateY(-4px);
    border-color: #C91C22;
}
.sb-svc-icon {
    font-size: 3rem;
    line-height: 1;
    display: block;
}
.sb-svc-name {
    font-family: Rubik, sans-serif;
    font-size: 1rem;
    font-weight: 700;
    color: #1F2937;
    margin: 0;
    line-height: 1.3;
}
.sb-svc-plus {
    position: absolute;
    bottom: 14px;
    right: 14px;
    width: 32px;
    height: 32px;
    background: #F3F4F6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 300;
    color: #6B7280;
    transition: background 0.2s, color 0.2s;
    line-height: 1;
}
.sb-svc-card:hover .sb-svc-plus {
    background: #C91C22;
    color: #fff;
}

/* ── Tabs ────────────────────────────────────────────────── */
.sb-tab-container {
    display: inline-flex;
    border-bottom: 1px solid #E5E7EB;
    margin-bottom: 40px;
    gap: 0;
}
.sb-tab-button {
    padding: 12px 32px;
    font-family: Inter, sans-serif;
    font-size: 0.9375rem;
    cursor: pointer;
    border: none;
    background: transparent;
    transition: 0.2s ease;
    color: #4B5563;
    font-weight: 500;
    white-space: nowrap; /* Prevent wrapping for tab names */
    position: relative;
    top: 1px; /* Align border with container's bottom border */
}
.sb-tab-button:hover {
    color: #1F2937;
    background: #F3F4F6;
    border-radius: 6px 6px 0 0;
}
.sb-tab-button.active {
    background: #ffffff;
    border-bottom: 2px solid #C91C22;
    font-weight: 700;
    color: #1F2937;
}

/* ── Backdrop ────────────────────────────────────────────── */
.sb-modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(4px);
    z-index: 9000;
    align-items: center;
    justify-content: center;
    padding: 24px;
}
.sb-modal-backdrop.open {
    display: flex;
}

/* ── Modal ───────────────────────────────────────────────── */
.sb-modal {
    background: #fff;
    border-radius: 24px;
    max-width: 560px;
    width: 100%;
    max-height: 90vh;
    box-sizing: border-box;
    position: relative;
    display: none;
    flex-direction: column;
    overflow: hidden;
    animation: sb-modal-in 0.3s cubic-bezier(0.16,1,0.3,1) both;
}
/* Inre scrollbar-behållare — innehållet scrollar, stäng-knappen sitter kvar */
.sb-modal-content {
    overflow-y: auto;
    overflow-x: hidden;
    padding: 48px 40px 56px;
    width: 100%;
    box-sizing: border-box;
}
@keyframes sb-modal-in {
    from { opacity: 0; transform: translateY(24px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0)    scale(1); }
}
.sb-modal-close {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 36px;
    height: 36px;
    background: #F3F4F6;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 1.1rem;
    color: #6B7280;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
    line-height: 1;
    z-index: 10;
}
.sb-modal-close:hover { background: #E5E7EB; }

.sb-modal-icon {
    font-size: 4rem;
    display: block;
    text-align: center;
    margin-bottom: 20px;
}
.sb-modal h3 {
    font-family: Rubik, sans-serif;
    font-size: 1.75rem;
    font-weight: 700;
    color: #1F2937;
    margin: 0 0 16px;
    text-align: center;
}
.sb-modal-badge { /* Renamed from sb-modal-rut for general use */
    display: inline-block;
    max-width: 100%;
    white-space: normal;
    word-break: break-word;
    background: #FFF0EC;
    color: #C91C22;
    font-family: Inter, sans-serif;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 50px;
    margin-bottom: 20px;
}
.sb-modal p {
    font-family: Inter, sans-serif;
    font-size: 1rem;
    line-height: 1.75;
    color: #4B5563;
    margin: 0 0 32px;
    text-align: left;
}
.sb-modal-cta {
    display: block;
    width: 100%;
    background: #C91C22;
    color: #fff;
    font-family: Rubik, sans-serif;
    font-size: 1.0625rem;
    font-weight: 700;
    text-align: center;
    padding: 16px 24px;
    border-radius: 50px;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: transform 0.2s, box-shadow 0.2s;
}
.sb-modal-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.20);
}
.sb-modal-micro {
    font-family: Inter, sans-serif;
    font-size: 0.8125rem;
    color: #9CA3AF;
    text-align: center;
    margin: 12px 0 0;
    white-space: normal;
    word-break: break-word;
}

@media (max-width: 600px) {
    .sb-modal-content { padding: 40px 24px 32px; }
}
</style>

<?php
$privat_services = [
    [
        'icon'  => '🧹',
        'name'  => 'Hemstädning',
        'badge'   => 'RUT-avdrag — du betalar 50%',
        'desc'  => 'Regelbunden eller engångsstädning, alltid utförd av en erfaren senior. Vi tar med utrustning och rengöringsmedel. Noggrannt, pålitligt och med omtanke — du märker skillnaden direkt. Med RUT-avdraget betalar du bara hälften av arbetskostnaden, vi sköter resten mot Skatteverket.',
        'slug'  => 'hemstadning',
        'cta_link' => '/intresseanmalan/?service=hemstadning',
    ],
    [
        'icon'  => '🌿',
        'name'  => 'Trädgård',
        'badge'   => 'RUT-avdrag — du betalar 50%',
        'desc'  => 'Gräsklippning, häckklippning, ogräsrensning, plantering och snöskottning. En senior med gröna fingrar och känsla för detaljer tar hand om din utomhusmiljö — så du kan njuta av trädgården istället för att arbeta i den. RUT-avdrag gäller.',
        'slug'  => 'tradgard',
        'cta_link' => '/intresseanmalan/?service=tradgard',
    ],
    [
        'icon'  => '🎨',
        'name'  => 'Målning & tapetsering',
        'badge'   => 'ROT-avdrag — du betalar 70%',
        'desc'  => 'Inomhus- och utomhusmålning, tapetsering och ytbehandling. Våra hantverkare har decennier av erfarenhet och gör jobbet rätt från börja — noggrant förarbete, rena linjer och städigt efterarbete. ROT-avdraget ger dig 30% direkt på fakturan.',
        'slug'  => 'malning',
        'cta_link' => '/intresseanmalan/?service=malning',
    ],
    [
        'icon'  => '🔨',
        'name'  => 'Snickeri',
        'badge'   => 'ROT-avdrag — du betalar 70%',
        'desc'  => 'Från att sätta upp hyllor och fixa dörrhandtag till större snickeriarbeten och renoveringar. Erfarna hantverkare med lång erfarenhet och känsla för detaljer. ROT-avdrag gäller — du betalar 70% av arbetskostnaden.',
        'slug'  => 'snickeri',
        'cta_link' => '/intresseanmalan/?service=snickeri',
    ],
];

$foretag_services = [
    [
        'icon'  => '🏢',
        'name'  => 'Kontorsservice',
        'badge'   => 'Företagsavtal',
        'desc'  => 'Regelbunden städning och service för kontor och arbetsplatser. Erfarna seniorer som är pålitliga, diskreta och noggranna. Avtalas månadsvis.',
        'slug'  => 'foretag-kontorsservice',
        'cta_link' => '/foretag/?service=foretag-kontorsservice',
    ],
    [
        'icon'  => '🌳',
        'name'  => 'Fastighetsskötsel',
        'badge'   => 'Företagsavtal',
        'desc'  => 'Löpande skötsel av fastigheter, utemiljöer och gemensamma ytor. Vi tar hand om det praktiska så era hyresgäster trivs.',
        'slug'  => 'foretag-fastighetsskotsel',
        'cta_link' => '/foretag/?service=foretag-fastighetsskotsel',
    ],
    [
        'icon'  => '🔧',
        'name'  => 'Underhållsservice',
        'badge'   => 'Företagsavtal',
        'desc'  => 'Löpande småreparationer, montering och underhåll. En senior hantverkare på plats när ni behöver — utan att anlita en heltidsvakt.',
        'slug'  => 'foretag-underhallsservice',
        'cta_link' => '/foretag/?service=foretag-underhallsservice',
    ],
    [
        'icon'  => '📦',
        'name'  => 'Lager & logistik',
        'badge'   => 'Företagsavtal',
        'desc'  => 'Plockning, packning och enklare lagerarbete utfört av erfarna seniorer med hög noggrannhet och låg frånvaro.',
        'slug'  => 'foretag-lager-logistik',
        'cta_link' => '/foretag/?service=foretag-lager-logistik',
    ],
];

$brf_services = [
    [
        'icon'  => '🏢',
        'name'  => 'Fastighetsskötsel',
        'badge'   => 'BRF-avtal',
        'desc'  => 'Löpande fastighetsskötsel för bostadsrättsföreningar. Vi tar hand om gemensamma ytor, entréer och utemiljöer med noggrannhet och omtanke.',
        'slug'  => 'brf-fastighetsskotsel',
        'cta_link' => '/brf/?service=brf-fastighetsskotsel',
    ],
    [
        'icon'  => '🧹',
        'name'  => 'Trappstädning',
        'badge'   => 'BRF-avtal',
        'desc'  => 'Regelbunden städning av trapphus, entréer och gemensamma utrymmen. Erfarna seniorer som håller hög standard vecka efter vecka.',
        'slug'  => 'brf-trappstadning',
        'cta_link' => '/brf/?service=brf-trappstadning',
    ],
    [
        'icon'  => '❄️',
        'name'  => 'Snöröjning',
        'badge'   => 'BRF-avtal',
        'desc'  => 'Pålitlig snöröjning och sandning för bostadsrättsföreningar. Vi säkerställer säkra gångvägar och parkeringar under hela vintern.',
        'slug'  => 'brf-snorojning',
        'cta_link' => '/brf/?service=brf-snorojning',
    ],
    [
        'icon'  => '🌿',
        'name'  => 'Trädgårdsskötsel',
        'badge'   => 'BRF-avtal',
        'desc'  => 'Skötsel av föreningens grönytor, rabatter och planteringar. Gräsklippning, beskärning och säsongsanpassad trädgårdsvård.',
        'slug'  => 'brf-tradgardsskotsel',
        'cta_link' => '/brf/?service=brf-tradgardsskotsel',
    ],
];

// Combine all services for modal generation
$all_services = [];
foreach ($privat_services as $i => $s) {
    $s['modal_id'] = 'svc-privat-' . $i;
    $all_services[] = $s;
}
foreach ($foretag_services as $i => $s) {
    $s['modal_id'] = 'svc-foretag-' . $i;
    $all_services[] = $s;
}
foreach ($brf_services as $i => $s) {
    $s['modal_id'] = 'svc-brf-' . $i;
    $all_services[] = $s;
}
?>

<section class="sb-svc-section">
    <h2>Våra tjänster</h2>
    <p class="sb-svc-sub">Erfarna seniorer som utför vardagsarbeten med omsorg och precision</p>

    <div class="sb-tab-container">
        <button class="sb-tab-button active" data-category="privat">Privat</button>
        <button class="sb-tab-button" data-category="foretag">Företag</button>
        <button class="sb-tab-button" data-category="brf">BRF</button>
    </div>

    <div id="sb-privat-grid" class="sb-svc-grid sb-svc-category">
        <?php foreach ($privat_services as $i => $s): ?>
        <div class="sb-svc-card"
             tabindex="0"
             role="button"
             aria-haspopup="dialog"
             data-modal="svc-privat-<?php echo $i; ?>">
            <span class="sb-svc-icon"><?php echo $s['icon']; ?></span>
            <p class="sb-svc-name"><?php echo esc_html($s['name']); ?></p>
            <span class="sb-svc-plus" aria-hidden="true">+</span>
        </div>
        <?php endforeach; ?>
    </div>

    <div id="sb-foretag-grid" class="sb-svc-grid sb-svc-category" style="display: none;">
        <?php foreach ($foretag_services as $i => $s): ?>
        <div class="sb-svc-card"
             tabindex="0"
             role="button"
             aria-haspopup="dialog"
             data-modal="svc-foretag-<?php echo $i; ?>">
            <span class="sb-svc-icon"><?php echo $s['icon']; ?></span>
            <p class="sb-svc-name"><?php echo esc_html($s['name']); ?></p>
            <span class="sb-svc-plus" aria-hidden="true">+</span>
        </div>
        <?php endforeach; ?>
    </div>

    <div id="sb-brf-grid" class="sb-svc-grid sb-svc-category" style="display: none;">
        <?php foreach ($brf_services as $i => $s): ?>
        <div class="sb-svc-card"
             tabindex="0"
             role="button"
             aria-haspopup="dialog"
             data-modal="svc-brf-<?php echo $i; ?>">
            <span class="sb-svc-icon"><?php echo $s['icon']; ?></span>
            <p class="sb-svc-name"><?php echo esc_html($s['name']); ?></p>
            <span class="sb-svc-plus" aria-hidden="true">+</span>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Backdrop + modaler -->
<div class="sb-modal-backdrop" id="sbModalBackdrop" role="dialog" aria-modal="true" aria-label="Tjänst">
    <?php foreach ($all_services as $s): ?>
    <div class="sb-modal" id="<?php echo $s['modal_id']; ?>">
        <button class="sb-modal-close" aria-label="Stäng">&#x2715;</button>
        <div class="sb-modal-content">
            <span class="sb-modal-icon"><?php echo $s['icon']; ?></span>
            <h3><?php echo esc_html($s['name']); ?></h3>
            <span class="sb-modal-badge"><?php echo esc_html($s['badge']); ?></span>
            <p><?php echo esc_html($s['desc']); ?></p>
            <a class="sb-modal-cta" href="<?php echo esc_url($s['cta_link']); ?>">
                Boka <?php echo esc_html($s['name']); ?> →
            </a>
            <p class="sb-modal-micro">✓ Kostnadsfritt · ✓ Utan bindning · ✓ Svar inom 24h</p>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
(function() {
    var backdrop = document.getElementById('sbModalBackdrop');
    var currentModal = null;
    var currentActiveTabButton = null;

    function openModal(id) {
        if (!id) return;
        // Göm alla modaler i backdropen
        backdrop.querySelectorAll('.sb-modal').forEach(function(m) {
            m.style.display = 'none';
        });
        var modal = document.getElementById(id);
        if (!modal) return;
        // Visa med flex så column-layouten håller ihop
        modal.style.display = 'flex';
        // Restart animation
        modal.style.animation = 'none';
        modal.offsetHeight; // Trigger reflow
        modal.style.animation = '';
        currentModal = modal;
        backdrop.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        backdrop.classList.remove('open');
        if (currentModal) currentModal.style.display = 'none';
        currentModal = null;
        document.body.style.overflow = '';
    }

    function openTab(category) {
        // Hide all service grids
        document.querySelectorAll('.sb-svc-category').forEach(function(grid) {
            grid.style.display = 'none';
        });

        // Deactivate all tab buttons
        document.querySelectorAll('.sb-tab-button').forEach(function(button) {
            button.classList.remove('active');
        });

        // Show the selected grid
        var selectedGrid = document.getElementById('sb-' + category + '-grid');
        if (selectedGrid) {
            selectedGrid.style.display = 'grid'; // Assuming grid display for .sb-svc-grid
        }

        // Activate the selected tab button
        var selectedTabButton = document.querySelector('.sb-tab-button[data-category="' + category + '"]');
        if (selectedTabButton) {
            selectedTabButton.classList.add('active');
            currentActiveTabButton = selectedTabButton;
        }
    }

    // Initial load: Open 'privat' tab
    openTab('privat');

    // Attach event listeners for tab buttons
    document.querySelectorAll('.sb-tab-button').forEach(function(button) {
        button.addEventListener('click', function() {
            openTab(button.dataset.category);
        });
    });

    // Öppna vid klick på kort
    document.querySelectorAll('.sb-svc-card').forEach(function(card) {
        card.addEventListener('click', function() {
            openModal(card.dataset.modal);
        });
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openModal(card.dataset.modal);
            }
        });
    });

    // Stäng via X-knapp
    backdrop.querySelectorAll('.sb-modal-close').forEach(function(btn) {
        btn.addEventListener('click', closeModal);
    });

    // Stäng via backdrop-klick
    backdrop.addEventListener('click', function(e) {
        if (e.target === backdrop) closeModal();
    });

    // Stäng via Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
})();
</script>
<!-- /wp:html -->