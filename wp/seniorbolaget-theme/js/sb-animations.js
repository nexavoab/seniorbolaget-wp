/**
 * Seniorbolaget — Scroll Animations (anime.js v3)
 * Syfte: Trygghet, trovärdighet, storytelling, konversion
 */
(function() {
  'use strict';

  // Vänta tills DOM + anime.js är redo
  document.addEventListener('DOMContentLoaded', init);

  function init() {
    if (typeof anime === 'undefined') return;

    setupHeroEntrance();
    setupScrollReveal();
    setupStatsCounter();
    setupThreeStepsStagger();
    setupFaqAnimation();
  }

  /* ============================================================
   * 1. HERO — Sekventiellt inträde (badge → H1 → p → CTAs)
   * Syfte: Första intrycket är lugnt och välkomnande, inte statiskt
   * ============================================================ */
  function setupHeroEntrance() {
    var heroSection = document.querySelector('.sb-hero-section, [class*="hero"]');
    if (!heroSection) return;

    var badge    = heroSection.querySelector('a[href*="reco"]');
    var h1       = heroSection.querySelector('h1');
    var subtitle = heroSection.querySelector('p');
    var ctaWrap  = heroSection.querySelector('.sb-hero-ctas, div:has(> a[href*="intresse"])');

    var targets = [badge, h1, subtitle, ctaWrap].filter(Boolean);
    if (!targets.length) return;

    targets.forEach(function(el) { el.style.opacity = '0'; });

    anime.timeline({ easing: 'easeOutExpo' })
      .add({ targets: badge,    opacity: [0,1], translateY: [-12,0], duration: 500 }, 200)
      .add({ targets: h1,       opacity: [0,1], translateY: [24,0],  duration: 700 }, 400)
      .add({ targets: subtitle, opacity: [0,1], translateY: [16,0],  duration: 600 }, 700)
      .add({ targets: ctaWrap,  opacity: [0,1], translateY: [16,0],  duration: 600 }, 950);
  }

  /* ============================================================
   * 2. SCROLL REVEAL — Sektioner fadear mjukt in
   * Syfte: Guidar ögat, ger känslan av att sidan "presenterar sig"
   * ============================================================ */
  function setupScrollReveal() {
    var selectors = [
      '.sb-bento-card',
      '.testimonial-card',
      '.wp-block-group.alignfull',
      '.sb-cta-section',
      'section'
    ].join(', ');

    var elements = Array.from(document.querySelectorAll(selectors));
    // Filtrera bort hero och element som redan animerats
    elements = elements.filter(function(el) {
      return !el.closest('[class*="hero"]') && !el.dataset.animated;
    });

    if (!elements.length) return;

    // Sätt startläge
    elements.forEach(function(el) {
      el.style.opacity = '0';
      el.style.transform = 'translateY(28px)';
      el.dataset.animated = 'pending';
    });

    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        anime({
          targets: el,
          opacity: [0, 1],
          translateY: [28, 0],
          duration: 700,
          easing: 'easeOutExpo'
        });
        el.dataset.animated = 'done';
        observer.unobserve(el);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    elements.forEach(function(el) { observer.observe(el); });
  }

  /* ============================================================
   * 3. STATS COUNTER — Siffror räknar upp när synliga
   * Syfte: "2 000+" som räknar upp = dramatisk trovärdighet
   * ============================================================ */
  function setupStatsCounter() {
    // Hitta alla h3 i stats-bandet med siffror
    var statEls = Array.from(document.querySelectorAll('.wp-block-group.alignfull h3')).filter(function(el) {
      return /\d/.test(el.textContent);
    });

    if (!statEls.length) return;

    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        var rawText = el.textContent.trim();
        var numMatch = rawText.match(/[\d\s]+/);
        if (!numMatch) return;
        var target = parseInt(numMatch[0].replace(/\s/g, ''), 10);
        var suffix = rawText.replace(/[\d\s]/g, '').trim();
        var obj = { val: 0 };

        anime({
          targets: obj,
          val: target,
          duration: 1800,
          easing: 'easeOutExpo',
          round: 1,
          update: function() {
            var formatted = obj.val >= 1000
              ? Math.round(obj.val).toLocaleString('sv-SE').replace(',', ' ')
              : Math.round(obj.val);
            el.textContent = formatted + suffix;
          }
        });
        observer.unobserve(el);
      });
    }, { threshold: 0.5 });

    statEls.forEach(function(el) { observer.observe(el); });
  }

  /* ============================================================
   * 4. TRE STEG — Sekventiell stagger (1 → 2 → 3)
   * Syfte: Visar processen som en resa, inte bara en lista
   * ============================================================ */
  function setupThreeStepsStagger() {
    // Tre steg-sektionen — hitta kolumnerna
    var stepsSection = Array.from(document.querySelectorAll('.wp-block-group.alignfull')).find(function(el) {
      return el.textContent.includes('tre steg') || el.textContent.includes('Så enkelt');
    });

    if (!stepsSection) return;

    var columns = stepsSection.querySelectorAll('.wp-block-column');
    if (columns.length < 2) return;

    columns.forEach(function(col) {
      col.style.opacity = '0';
      col.style.transform = 'translateY(32px)';
    });

    var triggered = false;
    var observer = new IntersectionObserver(function(entries) {
      if (triggered) return;
      entries.forEach(function(entry) {
        if (!entry.isIntersecting) return;
        triggered = true;
        anime({
          targets: columns,
          opacity: [0, 1],
          translateY: [32, 0],
          duration: 700,
          delay: anime.stagger(200),
          easing: 'easeOutExpo'
        });
        observer.disconnect();
      });
    }, { threshold: 0.2 });

    observer.observe(stepsSection);
  }

  /* ============================================================
   * 5. FAQ — Smooth expand/collapse på <details>
   * Syfte: Inget abrupt hackande — lugn, trygg känsla
   * ============================================================ */
  function setupFaqAnimation() {
    var details = document.querySelectorAll('details');
    if (!details.length) return;

    details.forEach(function(detail) {
      var summary = detail.querySelector('summary');
      var plusIcon = summary ? summary.querySelector('span') : null;
      var content = detail.querySelector('p');
      if (!content) return;

      // Nollställ höjd för animering
      content.style.overflow = 'hidden';
      content.style.marginTop = '0';

      summary.addEventListener('click', function(e) {
        e.preventDefault();
        var isOpen = detail.hasAttribute('open');

        if (!isOpen) {
          // Öppna
          detail.setAttribute('open', '');
          content.style.height = '0';
          content.style.opacity = '0';
          var targetHeight = content.scrollHeight + 'px';

          anime({
            targets: content,
            height: [0, targetHeight],
            opacity: [0, 1],
            marginTop: [0, 12],
            duration: 350,
            easing: 'easeOutQuad',
            complete: function() { content.style.height = 'auto'; }
          });
          if (plusIcon) anime({ targets: plusIcon, rotate: 45, duration: 300, easing: 'easeOutQuad' });
        } else {
          // Stäng
          content.style.height = content.scrollHeight + 'px';
          anime({
            targets: content,
            height: 0,
            opacity: 0,
            marginTop: 0,
            duration: 300,
            easing: 'easeInQuad',
            complete: function() { detail.removeAttribute('open'); content.style.height = ''; }
          });
          if (plusIcon) anime({ targets: plusIcon, rotate: 0, duration: 300, easing: 'easeOutQuad' });
        }
      });
    });
  }

})();
