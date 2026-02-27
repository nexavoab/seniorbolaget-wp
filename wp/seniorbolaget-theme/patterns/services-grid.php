<?php
/**
 * Title: Tjänster – Bento Grid
 * Slug: seniorbolaget/services-grid
 * Categories: seniorbolaget, services
 * Description: Magic bento-grid med glow-effekt för tjänstesektionen
 * Viewport Width: 1440
 */
?>
<!-- wp:html -->
<style>
.sb-services-section {
  padding: 80px clamp(24px,5vw,80px);
  background: #FAFAF8;
  text-align: center;
}
.sb-services-title {
  font-family: Rubik, sans-serif;
  font-size: clamp(1.75rem,3vw,2.5rem);
  font-weight: 700;
  color: #1F2937;
  margin: 0 0 12px;
}
.sb-services-sub {
  font-family: Inter, sans-serif;
  font-size: 1.125rem;
  color: #6B7280;
  margin: 0 0 48px;
}

/* Bento grid */
.sb-card-grid {
  display: grid;
  gap: 12px;
  max-width: 1100px;
  margin: 0 auto;
  font-size: clamp(1rem, 0.9rem + 0.3vw, 1.25rem);
}
@media (min-width: 600px) {
  .sb-card-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 1024px) {
  .sb-card-grid { grid-template-columns: repeat(4, 1fr); }
  .sb-card-grid .sb-bento-card:nth-child(3) { grid-column: span 2; grid-row: span 2; }
  .sb-card-grid .sb-bento-card:nth-child(4) { grid-column: 1 / span 2; grid-row: 2 / span 2; }
  .sb-card-grid .sb-bento-card:nth-child(6) { grid-column: 4; grid-row: 3; }
}

/* Card base */
.sb-bento-card {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 200px;
  padding: 1.5em;
  border-radius: 20px;
  border: 1px solid #e5e7eb;
  background: #ffffff;
  overflow: hidden;
  text-decoration: none;
  color: #1F2937;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
  --glow-x: 50%;
  --glow-y: 50%;
  --glow-intensity: 0;
  --glow-radius: 220px;
}
.sb-bento-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 32px rgba(201,28,34,0.12);
  border-color: rgba(201,28,34,0.25);
}

/* Glow border effect */
.sb-bento-card::after {
  content: '';
  position: absolute;
  inset: 0;
  padding: 1px;
  background: radial-gradient(
    var(--glow-radius) circle at var(--glow-x) var(--glow-y),
    rgba(201,28,34,calc(var(--glow-intensity)*0.9)) 0%,
    rgba(201,28,34,calc(var(--glow-intensity)*0.4)) 30%,
    transparent 65%
  );
  border-radius: inherit;
  -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  -webkit-mask-composite: xor;
  mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  mask-composite: exclude;
  pointer-events: none;
  z-index: 1;
}

/* Card content */
.sb-card-icon {
  font-size: 2.25em;
  line-height: 1;
  margin-bottom: 0.5em;
}
.sb-card-title {
  font-family: Rubik, sans-serif;
  font-size: 1.1em;
  font-weight: 700;
  color: #1F2937;
  margin: 0 0 0.4em;
}
.sb-card-desc {
  font-family: Inter, sans-serif;
  font-size: 0.875em;
  color: #6B7280;
  line-height: 1.5;
  margin: 0;
  flex: 1;
}
.sb-card-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  margin-top: 1em;
  font-family: Rubik, sans-serif;
  font-size: 0.875em;
  font-weight: 600;
  color: #C91C22;
  text-decoration: none;
}
.sb-card-link::after { content: '→'; transition: transform 0.2s; }
.sb-bento-card:hover .sb-card-link::after { transform: translateX(4px); }

/* Large card (3rd) special styling */
.sb-bento-card--large .sb-card-icon { font-size: 3em; }
.sb-bento-card--large .sb-card-title { font-size: 1.4em; }
.sb-bento-card--large .sb-card-desc { font-size: 1em; }

/* RUT badge card */
.sb-bento-card--accent {
  background: linear-gradient(135deg, #C91C22 0%, #a01018 100%);
  border-color: transparent;
  color: #fff;
}
.sb-bento-card--accent .sb-card-title,
.sb-bento-card--accent .sb-card-desc { color: rgba(255,255,255,0.92); }
.sb-bento-card--accent .sb-card-link { color: #fff; }
.sb-bento-card--accent:hover { box-shadow: 0 8px 32px rgba(201,28,34,0.4); border-color: transparent; }
</style>

<section class="sb-services-section">
  <h2 class="sb-services-title">Våra tjänster</h2>
  <p class="sb-services-sub">Erfarna seniorer som utför vardagsarbeten med omsorg och precision</p>

  <div class="sb-card-grid" id="sbCardGrid">

    <!-- 1. Hemstädning -->
    <a href="/hemstadning/" class="sb-bento-card">
      <div>
        <div class="sb-card-icon">🧹</div>
        <p class="sb-card-title">Hemstädning</p>
        <p class="sb-card-desc">Regelbunden eller engångsstädning. Noggrant och tillförlitligt av erfarna seniorer.</p>
      </div>
      <span class="sb-card-link">Läs mer</span>
    </a>

    <!-- 2. Trädgård -->
    <a href="/tradgard/" class="sb-bento-card">
      <div>
        <div class="sb-card-icon">🌿</div>
        <p class="sb-card-title">Trädgård</p>
        <p class="sb-card-desc">Klippning, plantering, snöskottning och trädgårdsskötsel. Njut av din uteplats.</p>
      </div>
      <span class="sb-card-link">Läs mer</span>
    </a>

    <!-- 3. Målning — STOR (span 2×2) -->
    <a href="/malning/" class="sb-bento-card sb-bento-card--large">
      <div>
        <div class="sb-card-icon">🖌️</div>
        <p class="sb-card-title">Målning & tapetsering</p>
        <p class="sb-card-desc">Inomhus- och utomhusmålning, tapetsering och ytbehandling. Proffs som gör jobbet rätt från början — med ROT-avdrag.</p>
      </div>
      <span class="sb-card-link">Läs mer</span>
    </a>

    <!-- 4. Snickeri — BRED (span 2 cols × 2 rows) -->
    <a href="/snickeri/" class="sb-bento-card sb-bento-card--large">
      <div>
        <div class="sb-card-icon">🔨</div>
        <p class="sb-card-title">Snickeri</p>
        <p class="sb-card-desc">Allt från hyllor och dörrar till större byggprojekt. Hantverkare med lång erfarenhet och känsla för detaljer.</p>
      </div>
      <span class="sb-card-link">Läs mer</span>
    </a>

    <!-- 5. RUT/ROT badge -->
    <a href="/intresseanmalan/" class="sb-bento-card sb-bento-card--accent">
      <div>
        <div class="sb-card-icon">💰</div>
        <p class="sb-card-title">RUT 50% · ROT 30%</p>
        <p class="sb-card-desc">RUT-avdrag: du betalar 50%. ROT-avdrag: du betalar 70%. Vi hanterar avdragen direkt med Skatteverket.</p>
      </div>
      <span class="sb-card-link">Boka nu</span>
    </a>

    <!-- 6. Alla orter -->
    <a href="/har-finns-vi/" class="sb-bento-card">
      <div>
        <div class="sb-card-icon">📍</div>
        <p class="sb-card-title">26 orter</p>
        <p class="sb-card-desc">Hitta din lokala franchisetagare.</p>
      </div>
      <span class="sb-card-link">Se alla</span>
    </a>

  </div>
</section>

<script>
(function() {
  const cards = document.querySelectorAll('#sbCardGrid .sb-bento-card');
  cards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = ((e.clientX - rect.left) / rect.width) * 100;
      const y = ((e.clientY - rect.top) / rect.height) * 100;
      card.style.setProperty('--glow-x', x + '%');
      card.style.setProperty('--glow-y', y + '%');
      card.style.setProperty('--glow-intensity', '1');
    });
    card.addEventListener('mouseleave', () => {
      card.style.setProperty('--glow-intensity', '0');
    });
  });
})();
</script>
<!-- /wp:html -->
