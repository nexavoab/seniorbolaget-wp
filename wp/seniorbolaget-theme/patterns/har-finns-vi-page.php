<?php
/**
 * Title: Här finns vi - Ortöversikt
 * Slug: seniorbolaget/har-finns-vi-page
 * Categories: seniorbolaget
 * Description: Översikt över alla 26 orter med franchisetagare
 * Viewport Width: 1440
 */
?>

<!-- wp:html -->
<style>
.team-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 20px;
  padding: 60px clamp(24px,5vw,80px);
  background: #FAFAF8;
}
@media (max-width: 1024px) { .team-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 640px) { .team-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; } }

.team-card {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  aspect-ratio: 4/5;
  cursor: pointer;
  background: #e5e7eb;
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.5s ease, transform 0.5s ease;
}
.team-card.visible { opacity: 1; transform: translateY(0); }
.team-card img {
  width: 100%; height: 100%;
  object-fit: cover; object-position: center top;
  transition: transform 0.5s ease;
}
.team-card:hover img { transform: scale(1.08); }
.team-card-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0) 50%);
  transition: background 0.3s;
}
.team-card:hover .team-card-overlay {
  background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.1) 60%);
}
.team-card-info {
  position: absolute; bottom: 0; left: 0; right: 0;
  padding: 20px 16px 16px;
  color: #fff;
}
.team-card-city {
  font-family: Rubik, sans-serif;
  font-size: 1rem; font-weight: 700;
  margin: 0 0 2px;
}
.team-card-name {
  font-family: Inter, sans-serif;
  font-size: 0.8125rem; color: rgba(255,255,255,0.8);
  margin: 0;
}
.team-card-arrow {
  position: absolute; top: 12px; right: 12px;
  background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,0.3);
  border-radius: 50%; width: 32px; height: 32px;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 0.875rem;
  opacity: 0; transform: translateY(-4px);
  transition: opacity 0.3s, transform 0.3s;
}
.team-card:hover .team-card-arrow { opacity: 1; transform: translateY(0); }
</style>

<!-- Hero section -->
<div style="background:linear-gradient(135deg,rgba(0,0,0,0.65) 0%,rgba(0,0,0,0.35) 100%),url('https://staging.seniorbolaget.se/wp-content/uploads/2026/02/hero_main.jpg') center/cover;min-height:50vh;display:flex;align-items:center;padding:clamp(40px,8vw,100px) clamp(24px,5vw,80px);">
  <div style="max-width:720px;">
    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.3);border-radius:50px;padding:8px 16px;margin-bottom:24px;color:#fff;font-size:0.875rem;font-family:Inter,sans-serif;">
      📍 26 orter i Sverige
    </div>
    <h1 style="font-family:Rubik,sans-serif;font-size:clamp(2.25rem,5vw,3.5rem);font-weight:800;color:#fff;line-height:1.15;margin:0 0 16px;">Här finns vi</h1>
    <p style="font-family:Inter,sans-serif;font-size:1.125rem;color:rgba(255,255,255,0.9);margin:0;">Hitta din lokala franchisetagare — personlig service nära dig</p>
  </div>
</div>

<!-- Team grid -->
<div class="team-grid" id="teamGrid">
  <a href="/amal/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_amal.jpg" alt="Monica Lindstrand, Åmål" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Åmål</p>
      <p class="team-card-name">Monica Lindstrand</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/boras/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_boras.jpg" alt="Roland Rapp, Borås" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Borås</p>
      <p class="team-card-name">Roland Rapp</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/eskilstuna/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_eskilstuna.jpg" alt="Isa Gemmel, Eskilstuna" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Eskilstuna</p>
      <p class="team-card-name">Isa Gemmel</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/falkenberg/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_falkenberg.jpg" alt="Stefan Nilsson, Falkenberg" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Falkenberg</p>
      <p class="team-card-name">Stefan Nilsson</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/goteborg/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_goteborg-sv.jpg" alt="Bosse Eriksson, Göteborg" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Göteborg</p>
      <p class="team-card-name">Bosse Eriksson</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/halmstad/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_halmstad.jpg" alt="Jenny Skogh, Halmstad" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Halmstad</p>
      <p class="team-card-name">Jenny Skogh</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/helsingborg/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_helsingborg.jpg" alt="Milliana Rosén, Helsingborg" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Helsingborg</p>
      <p class="team-card-name">Milliana Rosén</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/jonkoping/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_jonkoping.jpg" alt="Roland Rapp, Jönköping" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Jönköping</p>
      <p class="team-card-name">Roland Rapp</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/karlstad/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_karlstad.jpg" alt="Runar Skoglund, Karlstad" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Karlstad</p>
      <p class="team-card-name">Runar Skoglund</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/kristianstad/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_kristianstad.jpg" alt="Peter Lindquist, Kristianstad" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Kristianstad</p>
      <p class="team-card-name">Peter Lindquist</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/kungsbacka/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_kungsbacka.jpg" alt="Janette Rosén, Kungsbacka" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Kungsbacka</p>
      <p class="team-card-name">Janette Rosén</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/kungalv/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_kungalv.jpg" alt="Michael Adielson, Kungälv" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Kungälv</p>
      <p class="team-card-name">Michael Adielson</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/laholm/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_laholm-bastad.jpg" alt="Jenny Skogh, Laholm/Båstad" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Laholm/Båstad</p>
      <p class="team-card-name">Jenny Skogh</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/landskrona/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_landskrona.jpg" alt="Milliana Rosén, Landskrona" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Landskrona</p>
      <p class="team-card-name">Milliana Rosén</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/lerum/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_lerum-partille.jpg" alt="Jens Hendar, Lerum/Partille" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Lerum/Partille</p>
      <p class="team-card-name">Jens Hendar</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/molndal/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_molndal-harryda.jpg" alt="Håkan Viklund, Mölndal" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Mölndal</p>
      <p class="team-card-name">Håkan Viklund</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/nassjo/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_nassjo.jpg" alt="Lennart Ljungdahl, Nässjö" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Nässjö</p>
      <p class="team-card-name">Lennart Ljungdahl</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/orebro/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_orebro.jpg" alt="Andreas Persson, Örebro" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Örebro</p>
      <p class="team-card-name">Andreas Persson</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/skovde/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_skovde.jpg" alt="Susanne Kinell, Skövde" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Skövde</p>
      <p class="team-card-name">Susanne Kinell</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/stenungsund/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_stenungsund.jpg" alt="Mikael Styrmark, Stenungsund" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Stenungsund</p>
      <p class="team-card-name">Mikael Styrmark</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/sundsvall/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_sundsvall.jpg" alt="Eva Skog, Sundsvall" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Sundsvall</p>
      <p class="team-card-name">Eva Skog</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/torsby/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_torsby.jpg" alt="Rolf Nilsson, Torsby" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Torsby</p>
      <p class="team-card-name">Rolf Nilsson</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/trelleborg/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_trelleborg.jpg" alt="Peter Lindquist, Trelleborg" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Trelleborg</p>
      <p class="team-card-name">Peter Lindquist</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/trollhattan/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_trollhattan.jpg" alt="Ejvar Bolander, Trollhättan" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Trollhättan</p>
      <p class="team-card-name">Ejvar Bolander</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/ulricehamn/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_ulricehamn.jpg" alt="Ann-Sofie Käll, Ulricehamn" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Ulricehamn</p>
      <p class="team-card-name">Ann-Sofie Käll</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
  <a href="/varberg/" class="team-card" style="text-decoration:none;">
    <img src="https://staging.seniorbolaget.se/wp-content/uploads/2026/02/franchisee_varberg.jpg" alt="Stefan Nilsson, Varberg" loading="lazy"/>
    <div class="team-card-overlay"></div>
    <div class="team-card-info">
      <p class="team-card-city">Varberg</p>
      <p class="team-card-name">Stefan Nilsson</p>
    </div>
    <div class="team-card-arrow">→</div>
  </a>
</div>

<!-- Scroll animation -->
<script>
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry, i) => {
    if (entry.isIntersecting) {
      setTimeout(() => entry.target.classList.add('visible'), i * 60);
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.1 });
document.querySelectorAll('.team-card').forEach(card => observer.observe(card));
</script>

<!-- CTA sektion -->
<div style="background:#fff;padding:60px clamp(24px,5vw,80px);text-align:center;border-top:1px solid #f3f4f6;">
  <h2 style="font-family:Rubik,sans-serif;font-size:1.75rem;font-weight:700;color:#1F2937;margin:0 0 12px;">Finns vi inte i din stad än?</h2>
  <p style="font-family:Inter,sans-serif;color:#6B7280;margin:0 0 24px;">Vi expanderar ständigt — bli franchisetagare och ta din region.</p>
  <a href="/bli-franchisetagare/" style="display:inline-flex;align-items:center;gap:8px;background:#C91C22;color:#fff;font-family:Rubik,sans-serif;font-weight:700;padding:14px 32px;border-radius:50px;text-decoration:none;">
    Hör av dig →
  </a>
</div>
<!-- /wp:html -->
