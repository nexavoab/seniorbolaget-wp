#!/usr/bin/env python3
"""
Batch-genererar stadssida-mönster för alla städer från scrapade filer.
Läser kontaktpersoner från scraped/har-finns-vi__*.md
"""
import re, os
from pathlib import Path

SCRAPED_DIR = Path("scraped")
PATTERNS_DIR = Path("wp/seniorbolaget-theme/patterns")

# Mappa filnamn → WP-slug (matchar befintliga WP-sidor)
CITY_SLUGS = {
    "amal":         ("Åmål",             "amal"),
    "boras":        ("Borås",            "boras"),
    "eskilstuna":   ("Eskilstuna",       "eskilstuna"),
    "falkenberg":   ("Falkenberg",       "falkenberg"),
    "goteborg-sv":  ("Göteborg",         "goteborg-sv"),
    "halmstad":     ("Halmstad",         "halmstad"),
    "helsingborg":  ("Helsingborg",      "helsingborg"),
    "jonkoping":    ("Jönköping",        "jonkoping"),
    "karlstad":     ("Karlstad",         "karlstad"),
    "kristianstad": ("Kristianstad",     "kristianstad"),
    "kungalv":      ("Kungälv",          "kungalv"),
    "kungsbacka":   ("Kungsbacka",       "kungsbacka"),
    "laholm-bastad":("Laholm / Båstad",  "laholm-bastad"),
    "landskrona":   ("Landskrona",       "landskrona"),
    "lerum-partille":("Lerum / Partille","lerum-partille"),
    "molndal-harryda":("Mölndal / Härryda","molndal-harryda"),
    "nassjo":       ("Nässjö",           "nassjo"),
    "orebro":       ("Örebro",           "orebro"),
    "skovde":       ("Skövde",           "skovde"),
    "stenungsund":  ("Stenungsund",      "stenungsund"),
    "sundsvall":    ("Sundsvall",        "sundsvall"),
    "torsby":       ("Torsby",           "torsby"),
    "trelleborg":   ("Trelleborg",       "trelleborg"),
    "trollhattan":  ("Trollhättan",      "trollhattan"),
    "ulricehamn":   ("Ulricehamn",       "ulricehamn"),
    "varberg":      ("Varberg",          "varberg"),
}

def parse_contact(md_text):
    lines = md_text.splitlines()
    name = phone = email = ""
    for i, line in enumerate(lines):
        if line.startswith("####") and not name:
            name = line.replace("####", "").strip()
        if re.match(r'^07\d{2}-?\d{2}\s?\d{2}\s?\d{2}$', line.strip()) and not phone:
            phone = line.strip()
        if "@seniorbolaget.se" in line and not email:
            email = line.strip()
    return name, phone, email

def phone_tel(phone):
    return re.sub(r'[-\s]', '', phone)

def generate_pattern(file_key, city_name, wp_slug, name, phone, email):
    slug = f"seniorbolaget/stad-{wp_slug}-page"
    tel = phone_tel(phone) if phone else "0101751900"
    contact_name = name or "Kontaktperson"
    contact_phone = phone or "010-175 19 00"
    contact_email = email or "info@seniorbolaget.se"
    initials = "".join(w[0].upper() for w in contact_name.split()[:2]) if contact_name else "KB"

    return f'''<?php
/**
 * Title: {city_name} - Stadssida
 * Slug: {slug}
 * Categories: seniorbolaget, services
 * Description: SEO-landningssida för {city_name}
 * Viewport Width: 1440
 */
?>

<!-- wp:group {{"align":"full","style":{{"color":{{"background":"#FFF4F2"}},"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}},"margin":{{"top":"0"}}}}}},"layout":{{"type":"constrained"}}}} -->
<div class="wp-block-group alignfull" style="background-color:#FFF4F2;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:group {{"align":"wide","layout":{{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}}}} -->
  <div class="wp-block-group alignwide">

    <!-- wp:group {{"style":{{"spacing":{{"blockGap":"0"}}}},"layout":{{"type":"constrained","contentSize":"580px"}}}} -->
    <div class="wp-block-group">

      <!-- wp:paragraph {{"style":{{"typography":{{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"0.75rem"}},"color":{{"text":"#6B7280"}},"spacing":{{"margin":{{"bottom":"0.5rem"}}}}}}}} -->
      <p style="color:#6B7280;font-size:0.75rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:0.5rem">Här finns vi · {city_name}</p>
      <!-- /wp:paragraph -->

      <!-- wp:heading {{"level":1,"style":{{"typography":{{"fontSize":"clamp(2rem, 5vw, 3rem)","fontWeight":"700","lineHeight":"1.1"}},"color":{{"text":"#1F2937"}},"spacing":{{"margin":{{"bottom":"1rem"}}}}}}}} -->
      <h1 class="wp-block-heading" style="color:#1F2937;font-size:clamp(2rem, 5vw, 3rem);font-weight:700;line-height:1.1;margin-bottom:1rem">Hemtjänster i {city_name} av erfarna seniorer</h1>
      <!-- /wp:heading -->

      <!-- wp:paragraph {{"style":{{"typography":{{"fontSize":"1.125rem","lineHeight":"1.7"}},"color":{{"text":"#4B5563"}},"spacing":{{"margin":{{"bottom":"2rem"}}}}}}}} -->
      <p style="color:#4B5563;font-size:1.125rem;line-height:1.7;margin-bottom:2rem">Seniorbolaget finns i {city_name} med erfarna och pålitliga seniorer. Vi hjälper dig med hemstädning, trädgård, målning och snickeri — alltid med omtanke och kvalitet.</p>
      <!-- /wp:paragraph -->

      <!-- wp:buttons -->
      <div class="wp-block-buttons">
        <!-- wp:button {{"backgroundColor":"rod","textColor":"vit","style":{{"border":{{"radius":"50px"}},"spacing":{{"padding":{{"top":"0.875rem","bottom":"0.875rem","left":"2rem","right":"2rem"}}}},"typography":{{"fontWeight":"600","fontSize":"1rem"}}}}}} -->
        <div class="wp-block-button"><a class="wp-block-button__link has-vit-color has-rod-background-color has-text-color has-background wp-element-button" href="/intresse-anmalan" style="border-radius:50px;padding:0.875rem 2rem;font-weight:600;font-size:1rem;">Boka hjälp i {city_name}</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->

      <!-- wp:paragraph {{"style":{{"typography":{{"fontSize":"0.875rem"}},"color":{{"text":"#6B7280"}},"spacing":{{"margin":{{"top":"0.75rem"}}}}}}}} -->
      <p style="font-size:0.875rem;color:#6B7280;margin-top:0.75rem;">✓ Lokalt i {city_name} &nbsp;·&nbsp; ✓ Svar inom 24h &nbsp;·&nbsp; ✓ Inga bindningstider</p>
      <!-- /wp:paragraph -->

      <!-- wp:html -->
      <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:1.25rem;">
        <div style="display:inline-flex;align-items:center;gap:8px;background:#fff;border:1.5px solid #e5e7eb;border-radius:50px;padding:8px 16px;font-size:0.875rem;font-weight:600;color:#1F2937;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <span>4,8/5 · 500+ omdömen</span>
        </div>
        <div style="display:inline-flex;align-items:center;gap:8px;background:#fff;border:1.5px solid #e5e7eb;border-radius:50px;padding:8px 16px;font-size:0.875rem;font-weight:600;color:#1F2937;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Reco.se rekommenderad</span>
        </div>
      </div>
      <!-- /wp:html -->

    </div>
    <!-- /wp:group -->

  </div>
  <!-- /wp:group -->

</div>
<!-- /wp:group -->

<!-- wp:group {{"align":"full","style":{{"color":{{"background":"#FAFAF8"}},"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}}}}},"layout":{{"type":"constrained"}}}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#FAFAF8;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {{"textAlign":"center","level":2,"style":{{"typography":{{"fontSize":"clamp(1.75rem,4vw,2.5rem)","fontWeight":"700"}},"color":{{"text":"#1F2937"}},"spacing":{{"margin":{{"bottom":"0.75rem"}}}}}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.75rem,4vw,2.5rem);font-weight:700;margin-bottom:0.75rem">Vad kan vi hjälpa dig med i {city_name}?</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph {{"align":"center","style":{{"color":{{"text":"#6B7280"}},"typography":{{"fontSize":"1.125rem"}},"spacing":{{"margin":{{"bottom":"3rem"}}}}}}}} -->
  <p class="has-text-align-center" style="color:#6B7280;font-size:1.125rem;margin-bottom:3rem">Välj den tjänst du behöver — vi matchar dig med rätt senior i {city_name}.</p>
  <!-- /wp:paragraph -->

  <!-- wp:html -->
  <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;max-width:900px;margin:0 auto;">
    <a href="/privat/hemstad" style="display:flex;flex-direction:column;gap:12px;background:#fff;border-radius:20px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,0.06);text-decoration:none;border:1.5px solid #f3f4f6;transition:transform 0.2s,box-shadow 0.2s;">
      <div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      </div>
      <p style="font-family:Rubik,sans-serif;font-weight:700;font-size:1.1rem;color:#1F2937;margin:0;">Hemstädning</p>
      <p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;line-height:1.5;">Regelbunden eller engångsstädning. RUT-avdrag — du betalar bara 50%.</p>
      <span style="font-family:Rubik,sans-serif;font-size:0.875rem;font-weight:600;color:#C91C22;">Läs mer →</span>
    </a>
    <a href="/privat/tradgard" style="display:flex;flex-direction:column;gap:12px;background:#fff;border-radius:20px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,0.06);text-decoration:none;border:1.5px solid #f3f4f6;">
      <div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M12 22V12M12 12C12 7 7 2 2 2s0 10 10 10zM12 12c0-5 5-10 10-10s0 10-10 10z"/></svg>
      </div>
      <p style="font-family:Rubik,sans-serif;font-weight:700;font-size:1.1rem;color:#1F2937;margin:0;">Trädgård</p>
      <p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;line-height:1.5;">Gräsklippning, plantering, beskärning. RUT-avdrag gäller.</p>
      <span style="font-family:Rubik,sans-serif;font-size:0.875rem;font-weight:600;color:#C91C22;">Läs mer →</span>
    </a>
    <a href="/privat/malning-tapetsering" style="display:flex;flex-direction:column;gap:12px;background:#fff;border-radius:20px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,0.06);text-decoration:none;border:1.5px solid #f3f4f6;">
      <div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M18 6H5a2 2 0 00-2 2v3a2 2 0 002 2h13l4-3.5L18 6zM12 13v8M12 13H5"/></svg>
      </div>
      <p style="font-family:Rubik,sans-serif;font-weight:700;font-size:1.1rem;color:#1F2937;margin:0;">Målning & tapetsering</p>
      <p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;line-height:1.5;">Inomhus och fasad. ROT-avdrag — du betalar 70%.</p>
      <span style="font-family:Rubik,sans-serif;font-size:0.875rem;font-weight:600;color:#C91C22;">Läs mer →</span>
    </a>
    <a href="/privat/snickeri" style="display:flex;flex-direction:column;gap:12px;background:#fff;border-radius:20px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,0.06);text-decoration:none;border:1.5px solid #f3f4f6;">
      <div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
      </div>
      <p style="font-family:Rubik,sans-serif;font-weight:700;font-size:1.1rem;color:#1F2937;margin:0;">Snickeri</p>
      <p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;line-height:1.5;">Hyllor, dörrar, renovering. ROT-avdrag gäller.</p>
      <span style="font-family:Rubik,sans-serif;font-size:0.875rem;font-weight:600;color:#C91C22;">Läs mer →</span>
    </a>
  </div>
  <style>@media(max-width:600px){{.stad-tj{{grid-template-columns:1fr!important}}}}</style>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->

<!-- wp:group {{"align":"full","style":{{"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}}}}},"layout":{{"type":"constrained","contentSize":"640px"}}}} -->
<div class="wp-block-group alignfull" style="padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {{"textAlign":"center","level":2,"style":{{"typography":{{"fontSize":"clamp(1.75rem,4vw,2.25rem)","fontWeight":"700"}},"color":{{"text":"#1F2937"}},"spacing":{{"margin":{{"bottom":"2rem"}}}}}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.75rem,4vw,2.25rem);font-weight:700;margin-bottom:2rem">Din lokala kontakt i {city_name}</h2>
  <!-- /wp:heading -->

  <!-- wp:html -->
  <div style="background:#FFF4F2;border-radius:24px;padding:40px;max-width:520px;margin:0 auto;text-align:center;">
    <div style="width:72px;height:72px;background:#C91C22;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#fff;">{initials}</div>
    <p style="font-family:Rubik,sans-serif;font-weight:700;font-size:1.25rem;color:#1F2937;margin:0 0 4px;">{contact_name}</p>
    <p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#6B7280;margin:0 0 20px;">Ansvarig {city_name}</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
      <a href="tel:{tel}" style="display:inline-flex;align-items:center;gap:8px;background:#C91C22;color:#fff;border-radius:50px;padding:12px 24px;font-family:Rubik,sans-serif;font-weight:600;font-size:0.9375rem;text-decoration:none;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.4 1.13 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
        {contact_phone}
      </a>
      <a href="mailto:{contact_email}" style="display:inline-flex;align-items:center;gap:8px;background:#fff;color:#C91C22;border:2px solid #C91C22;border-radius:50px;padding:12px 24px;font-family:Rubik,sans-serif;font-weight:600;font-size:0.9375rem;text-decoration:none;">Skicka mail</a>
    </div>
  </div>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->

<!-- wp:pattern {{"slug":"seniorbolaget/testimonials"}} /-->

<!-- wp:pattern {{"slug":"seniorbolaget/three-steps"}} /-->

<!-- wp:group {{"align":"full","style":{{"spacing":{{"padding":{{"top":"100px","bottom":"100px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}}},"color":{{"background":"#4A5568"}}}},"layout":{{"type":"constrained","contentSize":"700px"}}}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#4A5568;padding-top:100px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:100px;padding-left:clamp(24px, 5vw, 80px)">
  <!-- wp:heading {{"textAlign":"center","level":2,"style":{{"typography":{{"fontSize":"clamp(1.75rem,4vw,2.5rem)","fontWeight":"700"}},"color":{{"text":"#ffffff"}},"spacing":{{"margin":{{"bottom":"1rem"}}}}}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#fff;font-size:clamp(1.75rem,4vw,2.5rem);font-weight:700;margin-bottom:1rem">Boka hemtjänst i {city_name} idag</h2>
  <!-- /wp:heading -->
  <!-- wp:paragraph {{"align":"center","style":{{"color":{{"text":"rgba(255,255,255,0.85)"}},"typography":{{"fontSize":"1.125rem"}},"spacing":{{"margin":{{"bottom":"2.5rem"}}}}}}}} -->
  <p class="has-text-align-center" style="color:rgba(255,255,255,0.85);font-size:1.125rem;margin-bottom:2.5rem">Vi matchar dig med rätt senior — lokalt i {city_name} och alltid med omtanke.</p>
  <!-- /wp:paragraph -->
  <!-- wp:buttons {{"layout":{{"type":"flex","justifyContent":"center"}}}} -->
  <div class="wp-block-buttons">
    <!-- wp:button {{"backgroundColor":"rod","textColor":"vit","style":{{"border":{{"radius":"50px"}},"spacing":{{"padding":{{"top":"1rem","bottom":"1rem","left":"2.5rem","right":"2.5rem"}}}},"typography":{{"fontSize":"1.125rem","fontWeight":"700"}}}}}} -->
    <div class="wp-block-button"><a class="wp-block-button__link has-vit-color has-rod-background-color has-text-color has-background wp-element-button" href="/intresse-anmalan" style="border-radius:50px;padding:1rem 2.5rem;font-size:1.125rem;font-weight:700;">Boka hjälp i {city_name}</a></div>
    <!-- /wp:button -->
  </div>
  <!-- /wp:buttons -->
  <!-- wp:paragraph {{"align":"center","style":{{"color":{{"text":"rgba(255,255,255,0.6)"}},"typography":{{"fontSize":"0.875rem"}},"spacing":{{"margin":{{"top":"1rem"}}}}}}}} -->
  <p class="has-text-align-center" style="color:rgba(255,255,255,0.6);font-size:0.875rem;margin-top:1rem;">✓ Svar inom 24h &nbsp;·&nbsp; ✓ Inga bindningstider &nbsp;·&nbsp; ✓ Lokalt i {city_name}</p>
  <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="seniorbolaget-sticky-cta">
  <a href="/intresse-anmalan">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    Boka i {city_name}
  </a>
</div>
<!-- /wp:html -->
'''

def main():
    generated = []
    for file_key, (city_name, wp_slug) in CITY_SLUGS.items():
        md_file = SCRAPED_DIR / f"har-finns-vi__{file_key}.md"
        if not md_file.exists():
            print(f"⚠️  Saknar: {md_file}")
            continue

        md_text = md_file.read_text(encoding="utf-8")
        name, phone, email = parse_contact(md_text)

        # Skip Göteborg — redan skapad manuellt
        if file_key == "goteborg-sv":
            print(f"↷ Hoppar {city_name} (redan skapad)")
            continue

        content = generate_pattern(file_key, city_name, wp_slug, name, phone, email)
        out_file = PATTERNS_DIR / f"stad-{wp_slug}-page.php"
        out_file.write_text(content, encoding="utf-8")
        generated.append((city_name, wp_slug, name, phone))
        print(f"✅ {city_name} ({wp_slug}) — {name or 'ingen kontakt'}")

    print(f"\n✅ Genererade {len(generated)} stadssidor")
    return generated

if __name__ == "__main__":
    main()
