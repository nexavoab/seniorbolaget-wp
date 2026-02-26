<?php
/**
 * Title: Kristianstad - Stadssida
 * Slug: seniorbolaget/stad-kristianstad-page
 * Categories: seniorbolaget, services
 * Description: Franchisetagarfokuserad landningssida för Kristianstad
 * Viewport Width: 1440
 */
?>

<!-- ========================================
     SEKTION 1: FRANCHISETAGARE-HERO
     ======================================== -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FFF4F2"},"spacing":{"padding":{"top":"60px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"},"margin":{"top":"0"}}},"layout":{"type":"constrained","contentSize":"1100px"}} -->
<div class="wp-block-group alignfull" style="background-color:#FFF4F2;margin-top:0;padding-top:60px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

<!-- wp:html -->
<div class="franchisee-hero" style="display:flex;gap:48px;align-items:center;flex-wrap:wrap;">
  
  <!-- FOTO (placeholder eller riktig bild) -->
  <div class="franchisee-photo" style="flex:0 0 auto;">
    <div style="width:280px;height:280px;border-radius:50%;background:linear-gradient(145deg,#FFF4F2 0%,#FFE8E4 50%,#FFD6D0 100%);border:4px solid rgba(201,28,34,0.15);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;flex-shrink:0;box-shadow:0 8px 32px rgba(201,28,34,0.08),inset 0 2px 8px rgba(255,255,255,0.8);">
      <svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="rgba(201,28,34,0.35)" stroke-width="1">
        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
      </svg>
      <div style="display:flex;align-items:center;gap:6px;background:rgba(201,28,34,0.08);border-radius:50px;padding:6px 14px;">
        <div style="width:6px;height:6px;background:#C91C22;border-radius:50%;"></div>
        <span style="font-family:Inter,sans-serif;font-size:0.75rem;font-weight:600;color:#C91C22;letter-spacing:0.05em;">LOKAL KONTAKT</span>
      </div>
    </div>
  </div>

  <!-- TEXT-INNEHÅLL -->
  <div style="flex:1;min-width:280px;">
    
    <!-- Namn -->
    <h1 style="font-family:Rubik,sans-serif;font-size:clamp(2rem,5vw,2.75rem);font-weight:700;color:#1F2937;margin:0 0 8px;line-height:1.2;">
      Peter Lindquist
    </h1>
    
    <!-- Roll + stad + år -->
    <p style="font-family:Inter,sans-serif;font-size:1rem;color:#6B7280;margin:0 0 20px;">
      Franchisetagare · Kristianstad · Sedan 2020
    </p>
    
    <!-- Personlig välkomsthälsning -->
    <p style="font-family:Inter,sans-serif;font-size:1.125rem;color:#374151;line-height:1.7;margin:0 0 28px;max-width:520px;">
      Välkommen! Jag är Peter och driver Seniorbolaget i Kristianstad. Vi hjälper dig med allt från städning till trädgård — alltid med omtanke och kvalitet.
    </p>
    
    <!-- TELEFON — extra stort -->
    <a href="tel:0704412572" style="display:inline-flex;align-items:center;gap:10px;font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#C91C22;text-decoration:none;margin-bottom:12px;">
      📞 0704-41 25 72
    </a>
    
    <!-- Sekundär: Mail-knapp -->
    <div style="margin-bottom:24px;">
      <a href="mailto:peter.lindquist@seniorbolaget.se" style="display:inline-flex;align-items:center;gap:8px;font-family:Inter,sans-serif;font-size:0.9375rem;color:#6B7280;text-decoration:none;">
        ✉ Skicka mail till Peter
      </a>
    </div>
    
    <!-- Trust badges -->
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
      <span style="display:inline-flex;align-items:center;gap:6px;font-family:Inter,sans-serif;font-size:0.875rem;color:#16a34a;font-weight:500;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        Verifierad partner
      </span>
      <span style="display:inline-flex;align-items:center;gap:6px;font-family:Inter,sans-serif;font-size:0.875rem;color:#16a34a;font-weight:500;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        Svarar inom 4h
      </span>
    </div>
    
    <!-- Personlig garanti -->
    <div style="margin-top:16px;padding:12px 16px;background:#F0FDF4;border-radius:10px;display:flex;align-items:flex-start;gap:10px;max-width:520px;">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" style="flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
      <p style="font-family:Inter,sans-serif;font-size:0.8125rem;color:#15803d;margin:0;line-height:1.5;"><strong>Min personliga garanti:</strong> Är du inte 100% nöjd så åtgärdar vi det utan extra kostnad. Det är mitt löfte.</p>
    </div>
    
  </div>
</div>

<style>
@media(max-width:768px){
  .franchisee-hero { flex-direction:column!important;text-align:center; }
  .franchisee-photo { margin:0 auto; }
  .franchisee-hero div:last-child { align-items:center; }
}
</style>
<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- ========================================
     SEKTION 2: PERSONLIG BERÄTTELSE
     ======================================== -->
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}},"layout":{"type":"constrained","contentSize":"720px"}} -->
<div class="wp-block-group alignfull" style="padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"clamp(1.5rem,4vw,2rem)","fontWeight":"700"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"2rem"}}}} -->
  <h2 class="wp-block-heading" style="color:#1F2937;font-size:clamp(1.5rem,4vw,2rem);font-weight:700;margin-bottom:2rem">Varför Peter valde Seniorbolaget</h2>
  <!-- /wp:heading -->

  <!-- wp:html -->
  <div style="margin-bottom:2rem;">
    <p style="font-family:Inter,sans-serif;font-size:1rem;line-height:1.8;color:#374151;margin:0 0 1rem;">20 år i servicebranschen här i Kristianstad lärde mig vem som levererar och vem som bara pratar. När jag startade Seniorbolaget 2020 visste jag precis vilka jag skulle ringa.</p>
<p style="font-family:Inter,sans-serif;font-size:1rem;line-height:1.8;color:#374151;margin:0 0 1rem;">Inom tre månader hade jag ett team av de bästa hantverkarna i nordöstra Skåne. Idag har vi 245 nöjda kunder från Åhus sandstränder till Degebergas kullar.</p>
<p style="font-family:Inter,sans-serif;font-size:1rem;line-height:1.8;color:#374151;margin:0 0 1rem;">Skåningar är kräsna — och det ska vi vara. När fru Svensson vid Heliga Trefaldighetskyrkan berättar för sina väninnor om oss, då vet jag att vi gör rätt.</p>
  </div>
  
  <!-- Citat -->
  <blockquote style="border-left:4px solid #C91C22;padding:16px 0 16px 24px;margin:0;background:#FAFAF8;border-radius:0 12px 12px 0;">
    <p style="font-family:Inter,sans-serif;font-size:1.125rem;font-style:italic;color:#374151;line-height:1.7;margin:0;">
      "Skåne förtjänar bästa service — och det är precis vad vi levererar."
    </p>
    <footer style="font-family:Rubik,sans-serif;font-size:0.875rem;color:#6B7280;margin-top:12px;">
      — Peter Lindquist, Kristianstad
    </footer>
  </blockquote>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- ========================================
     SEKTION 3: SERVICEOMRÅDE + TILLGÄNGLIGHET
     ======================================== -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FAFAF8"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}},"layout":{"type":"constrained","contentSize":"1000px"}} -->
<div class="wp-block-group alignfull" style="background-color:#FAFAF8;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"clamp(1.5rem,4vw,2rem)","fontWeight":"700"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"3rem"}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.5rem,4vw,2rem);font-weight:700;margin-bottom:3rem">Var Peter finns</h2>
  <!-- /wp:heading -->

  <!-- wp:html -->
  <div class="service-area-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:start;">
    
    <!-- Vänster: Områden -->
    <div>
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2">
          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
          <circle cx="12" cy="10" r="3"/>
        </svg>
        <h3 style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;margin:0;">Täcker området</h3>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <span style="background:#fff;color:#374151;border-radius:50px;padding:6px 14px;font-size:0.875rem;font-family:Inter,sans-serif;border:1px solid #e5e7eb;">Kristianstad</span>
            <span style="background:#fff;color:#374151;border-radius:50px;padding:6px 14px;font-size:0.875rem;font-family:Inter,sans-serif;border:1px solid #e5e7eb;">Åhus</span>
            <span style="background:#fff;color:#374151;border-radius:50px;padding:6px 14px;font-size:0.875rem;font-family:Inter,sans-serif;border:1px solid #e5e7eb;">Degeberga</span>
            <span style="background:#fff;color:#374151;border-radius:50px;padding:6px 14px;font-size:0.875rem;font-family:Inter,sans-serif;border:1px solid #e5e7eb;">Tollarp</span>
      </div>
    </div>
    
    <!-- Höger: Stats -->
    <div>
      <h3 style="font-family:Rubik,sans-serif;font-size:1.125rem;font-weight:600;color:#1F2937;margin:0 0 20px;">Tillgänglighet</h3>
      
      <div style="display:flex;flex-direction:column;gap:16px;">
        <div style="display:flex;align-items:center;gap:12px;">
          <div style="width:40px;height:40px;background:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <span style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#374151;">Svarar normalt inom 4 timmar på vardagar</span>
        </div>
        
        <div style="display:flex;align-items:center;gap:12px;">
          <div style="width:40px;height:40px;background:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
          </div>
          <span style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#374151;"><strong style="color:#C91C22;">245+</strong> nöjda kunder</span>
        </div>
        
        <div style="display:flex;align-items:center;gap:12px;">
          <div style="width:40px;height:40px;background:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </div>
          <span style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#374151;">Aktiv sedan <strong style="color:#C91C22;">2020</strong></span>
        </div>
      </div>
    </div>
    
  </div>
  
  <style>
  @media(max-width:700px){
    .service-area-grid { grid-template-columns:1fr!important; }
  }
  </style>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- ========================================
     SEKTION 4: KUNDRECENSIONER
     ======================================== -->
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}},"layout":{"type":"constrained","contentSize":"1100px"}} -->
<div class="wp-block-group alignfull" style="padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"clamp(1.5rem,4vw,2rem)","fontWeight":"700"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"0.75rem"}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.5rem,4vw,2rem);font-weight:700;margin-bottom:0.75rem">Vad Peters kunder säger</h2>
  <!-- /wp:heading -->
  
  <!-- wp:paragraph {"align":"center","style":{"color":{"text":"#6B7280"},"typography":{"fontSize":"1rem"},"spacing":{"margin":{"bottom":"3rem"}}}} -->
  <p class="has-text-align-center" style="color:#6B7280;font-size:1rem;margin-bottom:3rem">Äkta recensioner från nöjda kunder i Kristianstad-området.</p>
  <!-- /wp:paragraph -->

  <!-- wp:html -->
  <div class="testimonials-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
    
        <div style="background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
          <div style="display:flex;gap:2px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
          <p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#374151;line-height:1.7;margin:16px 0;font-style:italic;">"Johan är guld värd! Alltid pålitlig och noggrann med städningen."</p>
          <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
            <p style="font-family:Rubik,sans-serif;font-weight:600;font-size:0.875rem;color:#1F2937;margin:0;">Eivor Svensson, Kristianstad</p>
            <span style="background:#FFF4F2;color:#C91C22;font-size:0.75rem;font-weight:600;padding:4px 10px;border-radius:50px;font-family:Inter,sans-serif;">Hemstädning</span>
          </div>
        </div>
        <div style="background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
          <div style="display:flex;gap:2px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
          <p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#374151;line-height:1.7;margin:16px 0;font-style:italic;">"Målningen av sommarstugan blev fantastisk. Stort tack!"</p>
          <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
            <p style="font-family:Rubik,sans-serif;font-weight:600;font-size:0.875rem;color:#1F2937;margin:0;">Bengt Persson, Åhus</p>
            <span style="background:#FFF4F2;color:#C91C22;font-size:0.75rem;font-weight:600;padding:4px 10px;border-radius:50px;font-family:Inter,sans-serif;">Målning</span>
          </div>
        </div>
        <div style="background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
          <div style="display:flex;gap:2px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
          <p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#374151;line-height:1.7;margin:16px 0;font-style:italic;">"Trädgårdstjänsten är ovärderlig. De sköter allt åt mig."</p>
          <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
            <p style="font-family:Rubik,sans-serif;font-weight:600;font-size:0.875rem;color:#1F2937;margin:0;">Greta Andersson, Degeberga</p>
            <span style="background:#FFF4F2;color:#C91C22;font-size:0.75rem;font-weight:600;padding:4px 10px;border-radius:50px;font-family:Inter,sans-serif;">Trädgård</span>
          </div>
        </div>
  </div>
  
  <style>
  @media(max-width:900px){
    .testimonials-grid { grid-template-columns:1fr!important; }
  }
  </style>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- ========================================
     SEKTION 5: TJÄNSTER (sekundärt)
     ======================================== -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#FAFAF8"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}},"layout":{"type":"constrained","contentSize":"800px"}} -->
<div class="wp-block-group alignfull" style="background-color:#FAFAF8;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"clamp(1.5rem,4vw,2rem)","fontWeight":"700"},"color":{"text":"#1F2937"},"spacing":{"margin":{"bottom":"2.5rem"}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.5rem,4vw,2rem);font-weight:700;margin-bottom:2.5rem">Vad Peter hjälper dig med</h2>
  <!-- /wp:heading -->

  <!-- wp:html -->
  <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;">
    <a href="/privat/hemstad" style="background:#fff;border:1.5px solid #e5e7eb;border-radius:50px;padding:12px 24px;font-family:Inter,sans-serif;font-size:0.9375rem;font-weight:500;color:#374151;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:border-color 0.2s;">
      🏠 Hemstädning (RUT 50%)
    </a>
    <a href="/privat/tradgard" style="background:#fff;border:1.5px solid #e5e7eb;border-radius:50px;padding:12px 24px;font-family:Inter,sans-serif;font-size:0.9375rem;font-weight:500;color:#374151;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:border-color 0.2s;">
      🌿 Trädgård (RUT)
    </a>
    <a href="/privat/malning-tapetsering" style="background:#fff;border:1.5px solid #e5e7eb;border-radius:50px;padding:12px 24px;font-family:Inter,sans-serif;font-size:0.9375rem;font-weight:500;color:#374151;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:border-color 0.2s;">
      🖌 Målning (ROT 30%)
    </a>
    <a href="/privat/snickeri" style="background:#fff;border:1.5px solid #e5e7eb;border-radius:50px;padding:12px 24px;font-family:Inter,sans-serif;font-size:0.9375rem;font-weight:500;color:#374151;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:border-color 0.2s;">
      🔨 Snickeri (ROT)
    </a>
  </div>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- ========================================
     SEKTION 6: KONTAKT (röd bakgrund)
     ======================================== -->
<!-- wp:group {"align":"full","style":{"color":{"background":"#C91C22"},"spacing":{"padding":{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}},"layout":{"type":"constrained","contentSize":"600px"}} -->
<div class="wp-block-group alignfull" style="background-color:#C91C22;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"clamp(1.5rem,4vw,2rem)","fontWeight":"700"},"color":{"text":"#ffffff"},"spacing":{"margin":{"bottom":"2rem"}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#fff;font-size:clamp(1.5rem,4vw,2rem);font-weight:700;margin-bottom:2rem">Kontakta Peter direkt</h2>
  <!-- /wp:heading -->

  <!-- wp:html -->
  <div style="text-align:center;">
    
    <p style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:600;color:#fff;margin:0 0 8px;">Peter Lindquist</p>
    
    <a href="tel:0704412572" style="display:block;font-family:Rubik,sans-serif;font-size:1.75rem;font-weight:700;color:#fff;text-decoration:none;margin-bottom:8px;">
      📞 0704-41 25 72
    </a>
    
    <p style="font-family:Inter,sans-serif;font-size:1rem;color:rgba(255,255,255,0.85);margin:0 0 32px;">
      peter.lindquist@seniorbolaget.se
    </p>
    
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
      <a href="tel:0704412572" style="display:inline-flex;align-items:center;gap:8px;background:#fff;color:#C91C22;border-radius:50px;padding:14px 32px;font-family:Rubik,sans-serif;font-weight:600;font-size:1rem;text-decoration:none;">
        Ring nu
      </a>
      <a href="mailto:peter.lindquist@seniorbolaget.se" style="display:inline-flex;align-items:center;gap:8px;background:transparent;color:#fff;border:2px solid #fff;border-radius:50px;padding:14px 32px;font-family:Rubik,sans-serif;font-weight:600;font-size:1rem;text-decoration:none;">
        Skicka meddelande
      </a>
    </div>
    
  </div>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- ========================================
     SEKTION 7: STICKY CTA
     ======================================== -->
<!-- wp:html -->
<div class="seniorbolaget-sticky-cta">
  <a href="tel:0704412572">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
    </svg>
    Ring Peter
  </a>
</div>
<!-- /wp:html -->
