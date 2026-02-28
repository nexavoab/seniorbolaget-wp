<?php
/**
 * Title: Hero – Startsida
 * Slug: seniorbolaget/hero
 * Categories: seniorbolaget, banner, featured
 * Description: Full-bleed hero med bakgrundsbild, gradient overlay och CTA
 * Viewport Width: 1440
 */
?>
<!-- wp:html -->
<div style="position:relative;min-height:92vh;display:flex;align-items:center;background-image:url('https://staging.seniorbolaget.se/wp-content/uploads/2026/02/hero_main.jpg');background-size:cover;background-position:center top;overflow:hidden;">

  <!-- Gradient overlay -->
  <div style="position:absolute;inset:0;background:linear-gradient(110deg,rgba(0,0,0,0.72) 0%,rgba(0,0,0,0.45) 55%,rgba(0,0,0,0.15) 100%);"></div>

  <!-- Content -->
  <div style="position:relative;z-index:2;max-width:760px;padding:clamp(60px,10vw,120px) clamp(24px,5vw,80px);">

    <!-- Social proof badge -->
    <a href="https://www.reco.se/seniorbolaget" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.3);border-radius:50px;padding:8px 18px;margin-bottom:28px;color:#fff;font-size:0.875rem;font-family:Inter,sans-serif;font-weight:500;text-decoration:none;transition:background 0.2s;">
      ⭐⭐⭐⭐⭐ &nbsp;4.8/5 baserat på 500+ omdömen · Reco.se Rekommenderad
    </a>

    <!-- H1 -->
    <h1 style="font-family:Rubik,sans-serif;font-size:clamp(2.5rem,5.5vw,4rem);font-weight:800;color:#fff;line-height:1.1;margin:0 0 24px;">
      Hushållsnära tjänster av<br>
      <span style="color:#FF6B6B;">erfarna seniorer</span>
    </h1>

    <!-- Subtext -->
    <p style="font-family:Inter,sans-serif;font-size:clamp(1.0625rem,1.5vw,1.25rem);color:rgba(255,255,255,0.92);line-height:1.7;margin:0 0 36px;max-width:580px;">
      Städning, trädgård, målning &amp; snickeri — med RUT/ROT-avdrag direkt på fakturan. Alltid erfarna 55+ med omtanke och kvalitet.
    </p>

    <!-- CTAs -->
    <div style="display:flex;gap:16px;flex-wrap:wrap;align-items:center;margin-bottom:36px;">
      <a href="/intresseanmalan" style="display:inline-flex;align-items:center;gap:8px;background:#C91C22;color:#fff;font-family:Rubik,sans-serif;font-size:1.0625rem;font-weight:700;padding:17px 36px;border-radius:50px;text-decoration:none;box-shadow:0 4px 24px rgba(201,28,34,0.5);transition:transform 0.2s;">
        Boka hjälp idag →
      </a>
      <a href="/jobba-med-oss" style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1.5px solid rgba(255,255,255,0.5);color:#fff;font-family:Rubik,sans-serif;font-size:1rem;font-weight:600;padding:16px 28px;border-radius:50px;text-decoration:none;">
        👴 Jobba som senior
      </a>
    </div>

    <!-- Micro-copy -->
    <p style="font-family:Inter,sans-serif;font-size:0.875rem;color:rgba(255,255,255,0.75);margin:0 0 16px;">
      ✓ Svar inom 24h &nbsp;·&nbsp; ✓ Inga bindningstider &nbsp;·&nbsp; ✓ RUT-avdrag direkt på fakturan
    </p>

    <!-- Secondary CTA for job seekers -->
    <div style="margin-top:0;margin-bottom:32px;">
      <a href="/jobba-med-oss/" style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,0.85);font-family:Inter,sans-serif;font-size:0.9375rem;font-weight:500;text-decoration:none;border-bottom:1px solid rgba(255,255,255,0.4);padding-bottom:2px;transition:color .15s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.85)'">
        👴 Är du senior och vill jobba? →
      </a>
    </div>

    <!-- Stats -->
    <div style="display:flex;gap:24px;flex-wrap:wrap;">
      <div style="text-align:left;">
        <div style="font-family:Rubik,sans-serif;font-size:1.75rem;font-weight:800;color:#fff;line-height:1;">010-175 19 00</div>
        <div style="font-family:Inter,sans-serif;font-size:0.8125rem;color:rgba(255,255,255,0.7);margin-top:2px;">Ring oss direkt</div>
      </div>
      <div style="width:1px;background:rgba(255,255,255,0.2);margin:4px 0;"></div>
      <div style="text-align:left;">
        <div style="font-family:Rubik,sans-serif;font-size:1.75rem;font-weight:800;color:#fff;line-height:1;">98%</div>
        <div style="font-family:Inter,sans-serif;font-size:0.8125rem;color:rgba(255,255,255,0.7);margin-top:2px;">Nöjda kunder</div>
      </div>
      <div style="width:1px;background:rgba(255,255,255,0.2);margin:4px 0;"></div>
      <div style="text-align:left;">
        <div style="font-family:Rubik,sans-serif;font-size:1.75rem;font-weight:800;color:#fff;line-height:1;">26</div>
        <div style="font-family:Inter,sans-serif;font-size:0.8125rem;color:rgba(255,255,255,0.7);margin-top:2px;">Orter i Sverige</div>
      </div>
    </div>

  </div>
</div>
<!-- /wp:html -->
