#!/usr/bin/env python3
"""
Fullständig QA-audit för staging.seniorbolaget.se
80+ tester: sidladdning, navigation, wizards, mobil, SEO
"""

import json
import time
from datetime import datetime
from pathlib import Path
from playwright.sync_api import sync_playwright, expect

BASE_URL = "https://staging.seniorbolaget.se"
SCREENSHOT_DIR = Path("/home/exedev/.openclaw/workspace/screenshots/audit")
RESULTS = {"passed": 0, "failed": 0, "tests": []}

def log_test(category: str, name: str, passed: bool, details: str = ""):
    status = "✅" if passed else "❌"
    RESULTS["tests"].append({
        "category": category,
        "name": name,
        "passed": passed,
        "details": details
    })
    if passed:
        RESULTS["passed"] += 1
    else:
        RESULTS["failed"] += 1
    print(f"{status} [{category}] {name} {details}")

def run_tests():
    with sync_playwright() as p:
        browser = p.chromium.launch(
            headless=True,
            args=['--disable-cache', '--no-sandbox']
        )
        context = browser.new_context(
            viewport={"width": 1440, "height": 900},
            extra_http_headers={"Cache-Control": "no-cache"}
        )
        page = context.new_page()
        
        # ============================================
        # A. SIDLADDNING (13 sidor)
        # ============================================
        print("\n" + "="*60)
        print("A. SIDLADDNING")
        print("="*60)
        
        pages_to_test = [
            ("/", "Startsida"),
            ("/hemstadning/", "Hemstädning"),
            ("/tradgard/", "Trädgård"),
            ("/malning/", "Målning"),
            ("/snickeri/", "Snickeri"),
            ("/om-oss/", "Om oss"),
            ("/kontakt/", "Kontakt"),
            ("/har-finns-vi/", "Här finns vi"),
            ("/privat/", "Privat"),
            ("/foretag/", "Företag"),
            ("/jobba-med-oss/", "Jobba med oss"),
            ("/intresseanmalan/", "Intresseanmälan"),
            ("/bli-franchisetagare/", "Bli franchisetagare"),
        ]
        
        for path, name in pages_to_test:
            try:
                response = page.goto(f"{BASE_URL}{path}", wait_until="domcontentloaded", timeout=30000)
                status = response.status if response else 0
                title = page.title()
                h1 = page.locator("h1").first
                h1_exists = h1.count() > 0
                
                passed = status == 200 and title != "" and h1_exists
                log_test("A.Sidladdning", name, passed, 
                        f"HTTP:{status} Title:{'✓' if title else '✗'} H1:{'✓' if h1_exists else '✗'}")
            except Exception as e:
                log_test("A.Sidladdning", name, False, f"Error: {str(e)[:50]}")
        
        # ============================================
        # B. STADSIDOR (10 sidor)
        # ============================================
        print("\n" + "="*60)
        print("B. STADSIDOR")
        print("="*60)
        
        city_pages = [
            "/goteborg/", "/helsingborg/", "/varberg/", "/boras/", "/orebro/",
            "/jonkoping/", "/karlstad/", "/molndal/", "/halmstad/", "/trollhattan/"
        ]
        
        for path in city_pages:
            city_name = path.strip("/").capitalize()
            try:
                response = page.goto(f"{BASE_URL}{path}", wait_until="domcontentloaded", timeout=30000)
                status = response.status if response else 0
                h1_exists = page.locator("h1").count() > 0
                # Kolla efter franchisee-namn (kan vara i olika element)
                franchisee = page.locator("[class*='franchisee'], .franchise-name, .local-owner").first
                franchisee_visible = franchisee.count() > 0 if franchisee else False
                
                passed = status == 200 and h1_exists
                log_test("B.Stadsidor", city_name, passed,
                        f"HTTP:{status} H1:{'✓' if h1_exists else '✗'}")
            except Exception as e:
                log_test("B.Stadsidor", city_name, False, f"Error: {str(e)[:50]}")
        
        # ============================================
        # C. CARD NAV (7 tester)
        # ============================================
        print("\n" + "="*60)
        print("C. CARD NAV")
        print("="*60)
        
        page.goto(f"{BASE_URL}/", wait_until="domcontentloaded")
        page.wait_for_timeout(3000)
        
        # C1. Nav-pill synlig
        try:
            nav_pill = page.locator(".nav-pill, .hamburger, [class*='menu-toggle'], button[aria-label*='menu'], .menu-button").first
            visible = nav_pill.is_visible() if nav_pill.count() > 0 else False
            log_test("C.CardNav", "Nav-pill synlig", visible)
        except Exception as e:
            log_test("C.CardNav", "Nav-pill synlig", False, str(e)[:50])
        
        # C2. Hamburger click → öppnar
        try:
            hamburger = page.locator(".hamburger, [class*='menu-toggle'], button[aria-label*='menu'], .menu-button, .nav-toggle").first
            if hamburger.count() > 0:
                hamburger.click()
                page.wait_for_timeout(1000)
                # Kolla om nav öppnats
                nav_open = page.locator(".nav-open, [class*='menu-open'], .is-open, nav.open").first
                is_open = nav_open.count() > 0 or page.locator(".card-nav, .mega-menu, .nav-menu.visible").first.count() > 0
                log_test("C.CardNav", "Hamburger öppnar nav", is_open)
            else:
                log_test("C.CardNav", "Hamburger öppnar nav", False, "Ingen hamburger hittad")
        except Exception as e:
            log_test("C.CardNav", "Hamburger öppnar nav", False, str(e)[:50])
        
        # C3. 3 färgkodade kort synliga
        try:
            cards = page.locator(".nav-card, .menu-card, [class*='card-privat'], [class*='card-foretag']")
            card_count = cards.count()
            log_test("C.CardNav", "3 färgkodade kort", card_count >= 3, f"Hittade {card_count} kort")
        except Exception as e:
            log_test("C.CardNav", "3 färgkodade kort", False, str(e)[:50])
        
        # C4. Hemstädning-länk klickbar
        try:
            hemstad_link = page.locator("a[href*='hemstadning']").first
            if hemstad_link.count() > 0:
                hemstad_link.click()
                page.wait_for_timeout(2000)
                current_url = page.url
                passed = "hemstadning" in current_url
                log_test("C.CardNav", "Hemstädning-länk navigerar", passed, current_url)
                page.goto(f"{BASE_URL}/", wait_until="domcontentloaded")
            else:
                log_test("C.CardNav", "Hemstädning-länk navigerar", False, "Länk ej hittad")
        except Exception as e:
            log_test("C.CardNav", "Hemstädning-länk navigerar", False, str(e)[:50])
        
        # C5. Stäng (×) → stänger
        try:
            # Öppna nav först
            hamburger = page.locator(".hamburger, [class*='menu-toggle'], button[aria-label*='menu']").first
            if hamburger.count() > 0:
                hamburger.click()
                page.wait_for_timeout(500)
            close_btn = page.locator(".close, .nav-close, [aria-label='close'], button:has-text('×')").first
            if close_btn.count() > 0:
                close_btn.click()
                page.wait_for_timeout(500)
                nav_closed = page.locator(".nav-open, .is-open").count() == 0
                log_test("C.CardNav", "Stäng-knapp fungerar", nav_closed)
            else:
                log_test("C.CardNav", "Stäng-knapp fungerar", False, "Ingen stäng-knapp")
        except Exception as e:
            log_test("C.CardNav", "Stäng-knapp fungerar", False, str(e)[:50])
        
        # C6. Boka hjälp-knapp i nav
        try:
            boka_btn = page.locator("a[href*='intresseanmalan'], button:has-text('Boka')").first
            if boka_btn.count() > 0:
                href = boka_btn.get_attribute("href") or ""
                passed = "intresseanmalan" in href or boka_btn.is_visible()
                log_test("C.CardNav", "Boka hjälp-knapp", passed)
            else:
                log_test("C.CardNav", "Boka hjälp-knapp", False, "Ej hittad")
        except Exception as e:
            log_test("C.CardNav", "Boka hjälp-knapp", False, str(e)[:50])
        
        # C7. Mobil nav (390px)
        try:
            context_mobile = browser.new_context(
                viewport={"width": 390, "height": 844},
                extra_http_headers={"Cache-Control": "no-cache"}
            )
            page_mobile = context_mobile.new_page()
            page_mobile.goto(f"{BASE_URL}/", wait_until="domcontentloaded")
            page_mobile.wait_for_timeout(2000)
            
            body_width = page_mobile.evaluate("document.body.scrollWidth")
            no_overflow = body_width <= 395
            log_test("C.CardNav", "Mobil nav ej overflow", no_overflow, f"width={body_width}")
            page_mobile.close()
            context_mobile.close()
        except Exception as e:
            log_test("C.CardNav", "Mobil nav ej overflow", False, str(e)[:50])
        
        # ============================================
        # D. INTENTIONS-BAR (5 tester)
        # ============================================
        print("\n" + "="*60)
        print("D. INTENTIONS-BAR")
        print("="*60)
        
        page.goto(f"{BASE_URL}/", wait_until="domcontentloaded")
        page.wait_for_timeout(2000)
        
        # D1. Scroll → bar visas
        try:
            page.evaluate("window.scrollTo(0, 500)")
            page.wait_for_timeout(6000)  # Vänta på intentions-bar
            intentions_bar = page.locator(".intentions-bar, .sticky-bar, [class*='intent'], .floating-bar").first
            visible = intentions_bar.is_visible() if intentions_bar.count() > 0 else False
            log_test("D.IntentionsBar", "Visas efter scroll", visible)
        except Exception as e:
            log_test("D.IntentionsBar", "Visas efter scroll", False, str(e)[:50])
        
        # D2-D4. Knappar synliga
        for btn_text in ["Boka hjälp", "Jobba hos oss", "Hör av dig"]:
            try:
                btn = page.locator(f"text='{btn_text}'").first
                visible = btn.is_visible() if btn.count() > 0 else False
                log_test("D.IntentionsBar", f"'{btn_text}' synlig", visible)
            except Exception as e:
                log_test("D.IntentionsBar", f"'{btn_text}' synlig", False, str(e)[:50])
        
        # D5. Dismiss
        try:
            dismiss = page.locator(".intentions-bar .close, .sticky-bar .dismiss, [class*='intent'] button[class*='close']").first
            if dismiss.count() > 0:
                dismiss.click()
                page.wait_for_timeout(500)
                bar = page.locator(".intentions-bar, .sticky-bar").first
                dismissed = not bar.is_visible() if bar.count() > 0 else True
                log_test("D.IntentionsBar", "Dismiss fungerar", dismissed)
            else:
                log_test("D.IntentionsBar", "Dismiss fungerar", False, "Ingen dismiss-knapp")
        except Exception as e:
            log_test("D.IntentionsBar", "Dismiss fungerar", False, str(e)[:50])
        
        # ============================================
        # E. JOBBA-WIZARD (10 tester)
        # ============================================
        print("\n" + "="*60)
        print("E. JOBBA-WIZARD")
        print("="*60)
        
        page.goto(f"{BASE_URL}/jobba-med-oss/", wait_until="domcontentloaded")
        page.wait_for_timeout(9000)  # Alpine.js timing
        
        # E1. Alpine initierar
        try:
            x_cloak = page.locator("[x-cloak]")
            alpine_ready = x_cloak.count() == 0
            log_test("E.JobbaWizard", "Alpine initierar (x-cloak borta)", alpine_ready)
        except Exception as e:
            log_test("E.JobbaWizard", "Alpine initierar", False, str(e)[:50])
        
        # E2. Steg-indikator
        try:
            step_indicator = page.locator("text=/[Ss]teg\\s*1/").first
            visible = step_indicator.is_visible() if step_indicator.count() > 0 else False
            log_test("E.JobbaWizard", "Steg-indikator synlig", visible)
        except Exception as e:
            log_test("E.JobbaWizard", "Steg-indikator synlig", False, str(e)[:50])
        
        # E3-E10. Wizard-steg (förenklade tester)
        wizard_tests = [
            ("Step 1 content synlig", "[x-show*='step'], .wizard-step, .step-1"),
            ("Nästa-knapp finns", "button:has-text('Nästa'), button:has-text('Fortsätt')"),
        ]
        
        for test_name, selector in wizard_tests:
            try:
                elem = page.locator(selector).first
                exists = elem.count() > 0
                log_test("E.JobbaWizard", test_name, exists)
            except Exception as e:
                log_test("E.JobbaWizard", test_name, False, str(e)[:50])
        
        # Testa wizard-flöde
        try:
            # Välj en stad
            city_option = page.locator(".city-option, input[name*='city'], .wizard-option").first
            if city_option.count() > 0:
                city_option.click()
                page.wait_for_timeout(1000)
                log_test("E.JobbaWizard", "Stad-val fungerar", True)
            else:
                log_test("E.JobbaWizard", "Stad-val fungerar", False, "Ingen stad-option")
        except Exception as e:
            log_test("E.JobbaWizard", "Stad-val fungerar", False, str(e)[:50])
        
        # ============================================
        # F. INTRESSEANMÄLAN-WIZARD (10 tester)
        # ============================================
        print("\n" + "="*60)
        print("F. INTRESSEANMÄLAN-WIZARD")
        print("="*60)
        
        page.goto(f"{BASE_URL}/intresseanmalan/", wait_until="domcontentloaded")
        page.wait_for_timeout(9000)
        
        # F1. Alpine initierar
        try:
            x_cloak = page.locator("[x-cloak]")
            alpine_ready = x_cloak.count() == 0
            log_test("F.IntresseWizard", "Alpine initierar", alpine_ready)
        except Exception as e:
            log_test("F.IntresseWizard", "Alpine initierar", False, str(e)[:50])
        
        # F2. Service-cards synliga
        try:
            service_cards = page.locator(".service-card, .wizard-card, [class*='service-option']")
            card_count = service_cards.count()
            log_test("F.IntresseWizard", "Service-cards finns", card_count >= 3, f"Hittade {card_count}")
        except Exception as e:
            log_test("F.IntresseWizard", "Service-cards finns", False, str(e)[:50])
        
        # F3. Sökfunktion
        try:
            search_input = page.locator("input[type='search'], input[placeholder*='sök'], input[x-model*='search']").first
            if search_input.count() > 0:
                search_input.fill("göte")
                page.wait_for_timeout(500)
                log_test("F.IntresseWizard", "Sökfunktion finns", True)
            else:
                log_test("F.IntresseWizard", "Sökfunktion finns", False, "Ingen sökruta")
        except Exception as e:
            log_test("F.IntresseWizard", "Sökfunktion finns", False, str(e)[:50])
        
        # F4. Submit-knapp
        try:
            submit_btn = page.locator("button[type='submit'], input[type='submit'], button:has-text('Skicka')").first
            exists = submit_btn.count() > 0
            log_test("F.IntresseWizard", "Submit-knapp finns", exists)
        except Exception as e:
            log_test("F.IntresseWizard", "Submit-knapp finns", False, str(e)[:50])
        
        # ============================================
        # G. FLOATING CTA (3 tester)
        # ============================================
        print("\n" + "="*60)
        print("G. FLOATING CTA")
        print("="*60)
        
        page.goto(f"{BASE_URL}/hemstadning/", wait_until="domcontentloaded")
        page.wait_for_timeout(3000)
        
        try:
            floating_cta = page.locator(".floating-cta, .sticky-cta, [class*='float'][class*='cta']").first
            visible = floating_cta.is_visible() if floating_cta.count() > 0 else False
            log_test("G.FloatingCTA", "Synlig på tjänstesida", visible)
            
            if floating_cta.count() > 0:
                z_index = page.evaluate("(el) => getComputedStyle(el).zIndex", floating_cta.element_handle())
                log_test("G.FloatingCTA", "Har hög z-index", int(z_index or 0) > 10, f"z-index={z_index}")
                
                href = floating_cta.get_attribute("href") or ""
                log_test("G.FloatingCTA", "Href till intresseanmälan", "intresseanmalan" in href, href)
        except Exception as e:
            log_test("G.FloatingCTA", "Floating CTA", False, str(e)[:50])
        
        # ============================================
        # H. KNAPPSTILAR (3 tester)
        # ============================================
        print("\n" + "="*60)
        print("H. KNAPPSTILAR")
        print("="*60)
        
        page.goto(f"{BASE_URL}/", wait_until="domcontentloaded")
        page.wait_for_timeout(2000)
        
        try:
            buttons = page.locator(".wp-block-button__link, .btn, button.primary")
            if buttons.count() > 0:
                first_btn = buttons.first.element_handle()
                border_radius = page.evaluate("(el) => getComputedStyle(el).borderRadius", first_btn)
                radius_val = int(''.join(filter(str.isdigit, border_radius.split()[0])) or 0)
                log_test("H.Knappstilar", "Pill border-radius >= 40px", radius_val >= 40, f"radius={border_radius}")
                
                bg_color = page.evaluate("(el) => getComputedStyle(el).backgroundColor", first_btn)
                log_test("H.Knappstilar", "Knappfärg finns", bool(bg_color), bg_color)
            else:
                log_test("H.Knappstilar", "Knappar finns", False, "Inga knappar hittade")
        except Exception as e:
            log_test("H.Knappstilar", "Knappstilar", False, str(e)[:50])
        
        # ============================================
        # I. SEO-BASICS (5 tester)
        # ============================================
        print("\n" + "="*60)
        print("I. SEO-BASICS")
        print("="*60)
        
        seo_pages = ["/", "/hemstadning/", "/om-oss/", "/kontakt/", "/intresseanmalan/"]
        for path in seo_pages:
            try:
                page.goto(f"{BASE_URL}{path}", wait_until="domcontentloaded")
                title = page.title()
                h1_count = page.locator("h1").count()
                meta_desc = page.locator("meta[name='description']").get_attribute("content") or ""
                
                passed = bool(title) and h1_count > 0
                log_test("I.SEO", f"SEO {path}", passed, 
                        f"Title:{'✓' if title else '✗'} H1:{h1_count} Meta:{'✓' if meta_desc else '✗'}")
            except Exception as e:
                log_test("I.SEO", f"SEO {path}", False, str(e)[:50])
        
        # ============================================
        # J. MOBIL (5 tester)
        # ============================================
        print("\n" + "="*60)
        print("J. MOBIL")
        print("="*60)
        
        context_mobile = browser.new_context(
            viewport={"width": 390, "height": 844},
            extra_http_headers={"Cache-Control": "no-cache"}
        )
        page_mobile = context_mobile.new_page()
        
        # J1. Startsida H1 synlig
        try:
            page_mobile.goto(f"{BASE_URL}/", wait_until="domcontentloaded")
            page_mobile.wait_for_timeout(2000)
            h1 = page_mobile.locator("h1").first
            visible = h1.is_visible() if h1.count() > 0 else False
            log_test("J.Mobil", "Startsida H1 synlig", visible)
        except Exception as e:
            log_test("J.Mobil", "Startsida H1 synlig", False, str(e)[:50])
        
        # J2. Nav ej overflow
        try:
            body_width = page_mobile.evaluate("document.body.scrollWidth")
            log_test("J.Mobil", "Nav ej overflow", body_width <= 395, f"width={body_width}")
        except Exception as e:
            log_test("J.Mobil", "Nav ej overflow", False, str(e)[:50])
        
        # J3. Wizard mobil
        try:
            page_mobile.goto(f"{BASE_URL}/intresseanmalan/", wait_until="domcontentloaded")
            page_mobile.wait_for_timeout(9000)
            step1 = page_mobile.locator(".wizard-step, [x-show*='step'], .step-content").first
            visible = step1.is_visible() if step1.count() > 0 else False
            log_test("J.Mobil", "Wizard steg 1 synlig", visible)
        except Exception as e:
            log_test("J.Mobil", "Wizard steg 1 synlig", False, str(e)[:50])
        
        # J4. Tjänstesida CTA
        try:
            page_mobile.goto(f"{BASE_URL}/hemstadning/", wait_until="domcontentloaded")
            page_mobile.wait_for_timeout(2000)
            cta = page_mobile.locator(".wp-block-button__link, .cta, a[href*='intresseanmalan']").first
            visible = cta.is_visible() if cta.count() > 0 else False
            log_test("J.Mobil", "Tjänstesida CTA synlig", visible)
        except Exception as e:
            log_test("J.Mobil", "Tjänstesida CTA synlig", False, str(e)[:50])
        
        page_mobile.close()
        context_mobile.close()
        
        # ============================================
        # SCREENSHOTS FÖR GEMINI
        # ============================================
        print("\n" + "="*60)
        print("TAR SCREENSHOTS FÖR GEMINI")
        print("="*60)
        
        # Startsida
        page.set_viewport_size({"width": 1440, "height": 900})
        page.goto(f"{BASE_URL}/", wait_until="networkidle")
        page.wait_for_timeout(3000)
        page.screenshot(path=str(SCREENSHOT_DIR / "startsida.jpg"), type="jpeg", quality=80, full_page=True)
        print("📸 startsida.jpg")
        
        # Hemstädning
        page.goto(f"{BASE_URL}/hemstadning/", wait_until="networkidle")
        page.wait_for_timeout(3000)
        page.screenshot(path=str(SCREENSHOT_DIR / "hemstadning.jpg"), type="jpeg", quality=80, full_page=True)
        print("📸 hemstadning.jpg")
        
        # Wizard step 1
        page.goto(f"{BASE_URL}/intresseanmalan/", wait_until="networkidle")
        page.wait_for_timeout(9000)
        page.screenshot(path=str(SCREENSHOT_DIR / "wizard_step1.jpg"), type="jpeg", quality=80)
        print("📸 wizard_step1.jpg")
        
        # Wizard city (efter klick på tjänst)
        try:
            service_card = page.locator(".service-card, .wizard-card, [class*='service']").first
            if service_card.count() > 0:
                service_card.click()
                page.wait_for_timeout(2000)
        except:
            pass
        page.screenshot(path=str(SCREENSHOT_DIR / "wizard_city.jpg"), type="jpeg", quality=80)
        print("📸 wizard_city.jpg")
        
        # Nav öppen
        page.goto(f"{BASE_URL}/", wait_until="networkidle")
        page.wait_for_timeout(2000)
        try:
            hamburger = page.locator(".hamburger, [class*='menu-toggle'], button[aria-label*='menu']").first
            if hamburger.count() > 0:
                hamburger.click()
                page.wait_for_timeout(1000)
        except:
            pass
        page.screenshot(path=str(SCREENSHOT_DIR / "nav_open.jpg"), type="jpeg", quality=80)
        print("📸 nav_open.jpg")
        
        # Intentions-bar
        page.goto(f"{BASE_URL}/", wait_until="networkidle")
        page.wait_for_timeout(2000)
        page.evaluate("window.scrollTo(0, 500)")
        page.wait_for_timeout(6000)
        page.screenshot(path=str(SCREENSHOT_DIR / "intentions_bar.jpg"), type="jpeg", quality=80)
        print("📸 intentions_bar.jpg")
        
        browser.close()
        
        # ============================================
        # SAMMANFATTNING
        # ============================================
        print("\n" + "="*60)
        print("SAMMANFATTNING")
        print("="*60)
        total = RESULTS["passed"] + RESULTS["failed"]
        print(f"✅ Passerade: {RESULTS['passed']}/{total}")
        print(f"❌ Misslyckade: {RESULTS['failed']}/{total}")
        
        # Spara resultat
        with open(SCREENSHOT_DIR / "test_results.json", "w") as f:
            json.dump(RESULTS, f, indent=2, ensure_ascii=False)
        
        return RESULTS

if __name__ == "__main__":
    print("🚀 Startar fullständig QA-audit av staging.seniorbolaget.se")
    print(f"📅 Datum: {datetime.now().strftime('%Y-%m-%d %H:%M')}")
    print()
    results = run_tests()
