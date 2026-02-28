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
    overflow-x: hidden;
    overflow-y: auto;
    box-sizing: border-box;
    position: relative;
    padding: 48px 40px 40px;
    animation: sb-modal-in 0.3s cubic-bezier(0.16,1,0.3,1) both;
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
.sb-modal-rut {
    display: inline-block;
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
    box-shadow: 0 4px 20px rgba(201,28,34,0.35);
    transition: transform 0.2s, box-shadow 0.2s;
}
.sb-modal-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(201,28,34,0.45);
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
    .sb-modal { padding: 40px 24px 32px; }
}
</style>

<?php
$services = [
    [
        'icon'  => '🧹',
        'name'  => 'Hemstädning',
        'rut'   => 'RUT-avdrag — du betalar 50%',
        'desc'  => 'Regelbunden eller engångsstädning, alltid utförd av en erfaren senior. Vi tar med utrustning och rengöringsmedel. Noggrannt, pålitligt och med omtanke — du märker skillnaden direkt. Med RUT-avdraget betalar du bara hälften av arbetskostnaden, vi sköter resten mot Skatteverket.',
        'slug'  => 'hemstadning',
    ],
    [
        'icon'  => '🌿',
        'name'  => 'Trädgård',
        'rut'   => 'RUT-avdrag — du betalar 50%',
        'desc'  => 'Gräsklippning, häckklippning, ogräsrensning, plantering och snöskottning. En senior med gröna fingrar och känsla för detaljer tar hand om din utomhusmiljö — så du kan njuta av trädgården istället för att arbeta i den. RUT-avdrag gäller.',
        'slug'  => 'tradgard',
    ],
    [
        'icon'  => '🎨',
        'name'  => 'Målning & tapetsering',
        'rut'   => 'ROT-avdrag — du betalar 70%',
        'desc'  => 'Inomhus- och utomhusmålning, tapetsering och ytbehandling. Våra hantverkare har decennier av erfarenhet och gör jobbet rätt från börja — noggrant förarbete, rena linjer och städigt efterarbete. ROT-avdraget ger dig 30% direkt på fakturan.',
        'slug'  => 'malning',
    ],
    [
        'icon'  => '🔨',
        'name'  => 'Snickeri',
        'rut'   => 'ROT-avdrag — du betalar 70%',
        'desc'  => 'Från att sätta upp hyllor och fixa dörrhandtag till större snickeriarbeten och renoveringar. Erfarna hantverkare med lång erfarenhet och känsla för detaljer. ROT-avdrag gäller — du betalar 70% av arbetskostnaden.',
        'slug'  => 'snickeri',
    ],
];
?>

<section class="sb-svc-section">
    <h2>Våra tjänster</h2>
    <p class="sb-svc-sub">Erfarna seniorer som utför vardagsarbeten med omsorg och precision</p>

    <div class="sb-svc-grid">
        <?php foreach ($services as $i => $s): ?>
        <div class="sb-svc-card"
             tabindex="0"
             role="button"
             aria-haspopup="dialog"
             data-modal="svc-<?php echo $i; ?>">
            <span class="sb-svc-icon"><?php echo $s['icon']; ?></span>
            <p class="sb-svc-name"><?php echo esc_html($s['name']); ?></p>
            <span class="sb-svc-plus" aria-hidden="true">+</span>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Backdrop + modaler -->
<div class="sb-modal-backdrop" id="sbModalBackdrop" role="dialog" aria-modal="true" aria-label="Tjänst">
    <?php foreach ($services as $i => $s): ?>
    <div class="sb-modal" id="svc-<?php echo $i; ?>" style="display:none;">
        <button class="sb-modal-close" aria-label="Stäng">&#x2715;</button>
        <span class="sb-modal-icon"><?php echo $s['icon']; ?></span>
        <h3><?php echo esc_html($s['name']); ?></h3>
        <span class="sb-modal-rut"><?php echo esc_html($s['rut']); ?></span>
        <p><?php echo esc_html($s['desc']); ?></p>
        <a class="sb-modal-cta" href="/intresseanmalan/?service=<?php echo $s['slug']; ?>">
            Boka <?php echo esc_html($s['name']); ?> →
        </a>
        <p class="sb-modal-micro">✓ Kostnadsfritt · ✓ Utan bindning · ✓ Svar inom 24h</p>
    </div>
    <?php endforeach; ?>
</div>

<script>
(function() {
    var backdrop = document.getElementById('sbModalBackdrop');
    var current  = null;

    function openModal(id) {
        var modal = document.getElementById(id);
        if (!modal) return;
        if (current) current.style.display = 'none';
        modal.style.display = 'block';
        // Restart animation
        modal.style.animation = 'none';
        modal.offsetHeight;
        modal.style.animation = '';
        current = modal;
        backdrop.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        backdrop.classList.remove('open');
        if (current) current.style.display = 'none';
        current = null;
        document.body.style.overflow = '';
    }

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
