#!/usr/bin/env python3
"""
Generera WXR (WordPress eXtended RSS) från skrapat innehåll.
Importeras via WordPress → Tools → Import → WordPress.
"""
import json, os, re
from datetime import datetime
from xml.sax.saxutils import escape

SCRAPED = os.path.join(os.path.dirname(__file__), "scraped")
OUT = os.path.join(os.path.dirname(__file__), "seniorbolaget.wordpress.xml")
SITE_URL = "https://seniorbolaget.se"
NOW = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

# ── Sidstruktur: (slug, titel, parent_slug, post_type, kategori) ──────────────
PAGES = [
    # Startsida
    ("/",                               "Hem",                          None,           "page", None),
    # Privat
    ("/privat",                         "Privat",                       None,           "page", None),
    ("/privat/hemstad",                 "Hemstäd",                      "/privat",      "page", None),
    ("/privat/malning",                 "Målning & tapetsering",        "/privat",      "page", None),
    ("/privat/snickeri",                "Snickeri",                     "/privat",      "page", None),
    ("/privat/tradgard",                "Trädgård",                     "/privat",      "page", None),
    # Företag
    ("/foretag",                        "Företag",                      None,           "page", None),
    ("/foretag/bemanning",              "Bemanning",                    "/foretag",     "page", None),
    ("/foretag/for-brfer",              "För bostadsrättsföreningar",   "/foretag",     "page", None),
    ("/foretag/foretagstjanster",       "Företagstjänster",             "/foretag",     "page", None),
    # Här finns vi
    ("/har-finns-vi",                   "Här finns vi",                 None,           "page", None),
    ("/har-finns-vi/amal",              "Åmål",                         "/har-finns-vi","page", None),
    ("/har-finns-vi/boras",             "Borås",                        "/har-finns-vi","page", None),
    ("/har-finns-vi/eskilstuna",        "Eskilstuna",                   "/har-finns-vi","page", None),
    ("/har-finns-vi/falkenberg",        "Falkenberg",                   "/har-finns-vi","page", None),
    ("/har-finns-vi/goteborg-sv",       "Göteborg",                     "/har-finns-vi","page", None),
    ("/har-finns-vi/halmstad",          "Halmstad",                     "/har-finns-vi","page", None),
    ("/har-finns-vi/helsingborg",       "Helsingborg",                  "/har-finns-vi","page", None),
    ("/har-finns-vi/jonkoping",         "Jönköping",                    "/har-finns-vi","page", None),
    ("/har-finns-vi/karlstad",          "Karlstad",                     "/har-finns-vi","page", None),
    ("/har-finns-vi/kristianstad",      "Kristianstad",                 "/har-finns-vi","page", None),
    ("/har-finns-vi/kungalv",           "Kungälv",                      "/har-finns-vi","page", None),
    ("/har-finns-vi/kungsbacka",        "Kungsbacka",                   "/har-finns-vi","page", None),
    ("/har-finns-vi/laholm-bastad",     "Laholm / Båstad",              "/har-finns-vi","page", None),
    ("/har-finns-vi/landskrona",        "Landskrona",                   "/har-finns-vi","page", None),
    ("/har-finns-vi/lerum-partille",    "Lerum / Partille",             "/har-finns-vi","page", None),
    ("/har-finns-vi/molndal-harryda",   "Mölndal / Härryda",            "/har-finns-vi","page", None),
    ("/har-finns-vi/nassjo",            "Nässjö",                       "/har-finns-vi","page", None),
    ("/har-finns-vi/orebro",            "Örebro",                       "/har-finns-vi","page", None),
    ("/har-finns-vi/skovde",            "Skövde",                       "/har-finns-vi","page", None),
    ("/har-finns-vi/stenungsund",       "Stenungsund",                  "/har-finns-vi","page", None),
    ("/har-finns-vi/sundsvall",         "Sundsvall",                    "/har-finns-vi","page", None),
    ("/har-finns-vi/torsby",            "Torsby",                       "/har-finns-vi","page", None),
    ("/har-finns-vi/trelleborg",        "Trelleborg",                   "/har-finns-vi","page", None),
    ("/har-finns-vi/trollhattan",       "Trollhättan",                  "/har-finns-vi","page", None),
    ("/har-finns-vi/ulricehamn",        "Ulricehamn",                   "/har-finns-vi","page", None),
    ("/har-finns-vi/varberg",           "Varberg",                      "/har-finns-vi","page", None),
    # Övrigt
    ("/bli-franchisetagare",            "Bli franchisetagare",          None,           "page", None),
    ("/jobba-med-oss",                  "Jobba med oss",                None,           "page", None),
    ("/om-oss",                         "Om oss",                       None,           "page", None),
    ("/kontakt",                        "Kontakt",                      None,           "page", None),
    ("/intresse-anmalan",               "Uppdragsförfrågan",            None,           "page", None),
    ("/tack",                           "Tack!",                        None,           "page", None),
]

BLOG_POSTS = [
    ("/blog/10-essential-tips-for-a-home-construction",
        "Måla huset så att det håller", "2024-08-04"),
    ("/blog/7-essential-factors-for-choosing-the-right-builder",
        "Måla inomhus, proffsens hemligheter", "2024-07-03"),
    ("/blog/designing-your-dream-home-a-comprehensive-step-by-step-guide",
        "Bygg trallen som ett proffs: steg för steg", "2024-07-02"),
    ("/blog/innovations-shaping-the-future-of-sustainable-construction",
        "Så murar du hållbart och snyggt som yrkesfolk", "2024-07-01"),
    ("/blog/sustainable-building-practices-how-to-build-an-eco-friendly-home",
        "Allt från finsnickeri till tomater", "2024-07-04"),
    ("/blog/top-trends-in-modern-home-construction-what-to-expect-in-2024",
        "En grusgång för gudarna", "2024-07-06"),
]

def slug_from_url(url):
    """Konvertera URL till WP-slug."""
    s = url.strip("/").split("/")[-1]
    return s or "home"

def read_scraped(url):
    """Läs skrapat innehåll för en URL."""
    fname = url.strip("/").replace("/", "__")
    fname = re.sub(r'[^\w\-_]', '_', fname) or "index"
    fpath = os.path.join(SCRAPED, fname + ".md")
    if os.path.exists(fpath):
        with open(fpath) as f:
            content = f.read()
        # Ta bort första 2 raderna (Page: ... och Title: ...)
        lines = content.split("\n")
        body = "\n".join(lines[3:]).strip()
        # Konvertera markdown-rubriker till enkel text för WP-content
        body = re.sub(r'^#{1,6}\s+', '', body, flags=re.MULTILINE)
        return body
    return ""

def md_to_wp_blocks(text, page_slug=""):
    """Konvertera skrapat text till WordPress block-content."""
    if not text.strip():
        return ""

    lines = text.strip().split("\n")
    blocks = []
    para_buffer = []

    def flush_para():
        nonlocal para_buffer
        if para_buffer:
            t = " ".join(l for l in para_buffer if l.strip())
            if t.strip():
                blocks.append(f'<!-- wp:paragraph -->\n<p>{escape(t.strip())}</p>\n<!-- /wp:paragraph -->')
            para_buffer = []

    for line in lines:
        line = line.strip()
        if not line:
            flush_para()
        elif line.startswith("# "):
            flush_para()
            blocks.append(f'<!-- wp:heading {{"level":2}} -->\n<h2 class="wp-block-heading">{escape(line[2:])}</h2>\n<!-- /wp:heading -->')
        elif line.startswith("## "):
            flush_para()
            blocks.append(f'<!-- wp:heading {{"level":3}} -->\n<h3 class="wp-block-heading">{escape(line[3:])}</h3>\n<!-- /wp:heading -->')
        elif line.startswith("### "):
            flush_para()
            blocks.append(f'<!-- wp:heading {{"level":4}} -->\n<h4 class="wp-block-heading">{escape(line[4:])}</h4>\n<!-- /wp:heading -->')
        elif line.startswith("#### "):
            flush_para()
            blocks.append(f'<!-- wp:heading {{"level":5}} -->\n<h5 class="wp-block-heading">{escape(line[5:])}</h5>\n<!-- /wp:heading -->')
        else:
            # Hoppa över footerdata, nav-items etc.
            skip = any(line.startswith(x) for x in [
                "Privat", "Företag", "Här finns vi", "Franchise", "Jobba med oss",
                "Om oss", "Kontakta oss", "Kontakt", "Snabblänkar", "Hem",
                "Städ", "Bemanning", "Måleri", "010-175", "info@seniorbolaget",
                "Box 2069", "Copyright", "Buy Template", "Unlock for",
                "All-Access", "Free Solar", "Snickeri", "Trädgård"
            ])
            if not skip and len(line) > 3:
                para_buffer.append(line)

    flush_para()
    return "\n\n".join(blocks)

# ── Bygg ID-mappning ──────────────────────────────────────────────────────────
url_to_id = {}
post_id = 1

for url, title, parent, ptype, cat in PAGES:
    url_to_id[url] = post_id
    post_id += 1

blog_ids = {}
for url, title, date in BLOG_POSTS:
    blog_ids[url] = post_id
    post_id += 1

# ── Generera XML ──────────────────────────────────────────────────────────────
def item_xml(post_id, title, slug, content, post_type, parent_id, date, status="publish", categories=None):
    cats_xml = ""
    if categories:
        for cat in categories:
            safe = escape(cat)
            slug_c = re.sub(r'[^a-z0-9-]', '-', cat.lower())
            cats_xml += f'<category domain="category" nicename="{slug_c}"><![CDATA[{safe}]]></category>\n\t\t'

    return f"""
	<item>
		<title><![CDATA[{title}]]></title>
		<link>{SITE_URL}/{slug}/</link>
		<pubDate>{date}</pubDate>
		<dc:creator><![CDATA[admin]]></dc:creator>
		<guid isPermaLink="false">{SITE_URL}/?p={post_id}</guid>
		<description></description>
		<content:encoded><![CDATA[{content}]]></content:encoded>
		<excerpt:encoded><![CDATA[]]></excerpt:encoded>
		<wp:post_id>{post_id}</wp:post_id>
		<wp:post_date><![CDATA[{date}]]></wp:post_date>
		<wp:post_date_gmt><![CDATA[{date}]]></wp:post_date_gmt>
		<wp:comment_status><![CDATA[closed]]></wp:comment_status>
		<wp:ping_status><![CDATA[closed]]></wp:ping_status>
		<wp:post_name><![CDATA[{slug}]]></wp:post_name>
		<wp:status><![CDATA[{status}]]></wp:status>
		<wp:post_parent>{parent_id}</wp:post_parent>
		<wp:menu_order>0</wp:menu_order>
		<wp:post_type><![CDATA[{post_type}]]></wp:post_type>
		<wp:post_password><![CDATA[]]></wp:post_password>
		<wp:is_sticky>0</wp:is_sticky>
		{cats_xml}
	</item>"""

items = []

# Sidor
for url, title, parent_url, ptype, cat in PAGES:
    pid = url_to_id[url]
    parent_id = url_to_id.get(parent_url, 0) if parent_url else 0
    slug = slug_from_url(url)
    if url == "/":
        slug = "home-page"

    raw = read_scraped(url)
    # För startsidan: använd front-page pattern
    if url == "/":
        content = '<!-- wp:pattern {"slug":"seniorbolaget/hero"} /-->\n<!-- wp:pattern {"slug":"seniorbolaget/services-grid"} /-->\n<!-- wp:pattern {"slug":"seniorbolaget/three-steps"} /-->\n<!-- wp:pattern {"slug":"seniorbolaget/testimonials"} /-->\n<!-- wp:pattern {"slug":"seniorbolaget/stats-band"} /-->\n<!-- wp:pattern {"slug":"seniorbolaget/cta-band"} /-->'
    else:
        content = md_to_wp_blocks(raw, slug)

    items.append(item_xml(pid, title, slug, content, ptype, parent_id, NOW))

# Blogg-inlägg
for url, title, date in BLOG_POSTS:
    pid = blog_ids[url]
    slug = slug_from_url(url)
    raw = read_scraped(url)
    content = md_to_wp_blocks(raw, slug)
    date_fmt = f"{date} 09:00:00"
    items.append(item_xml(pid, title, slug, content, "post", 0, date_fmt, categories=["Blogg"]))

xml = f"""<?xml version="1.0" encoding="UTF-8" ?>
<!-- This is a WordPress eXtended RSS file generated by OpenClaw migration tool -->
<!-- It contains information about your site's posts, pages, comments, categories, and other content -->
<!-- You may use this file to transfer that content from one site to another -->
<!-- To import this information into a WordPress site follow these steps: -->
<!-- 1. Log in to that site as an administrator -->
<!-- 2. Go to Tools: Import in the WordPress admin panel -->
<!-- 3. Install the "WordPress" importer from the list -->
<!-- 4. Activate & Run Importer -->
<!-- 5. Upload this file using the form provided on that page -->

<rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/1.2/"
>
<channel>
	<title>Seniorbolaget</title>
	<link>{SITE_URL}</link>
	<description>Låt våra rutinerade seniorer göra jobbet!</description>
	<pubDate>{NOW}</pubDate>
	<language>sv</language>
	<wp:wxr_version>1.2</wp:wxr_version>
	<wp:base_site_url>{SITE_URL}</wp:base_site_url>
	<wp:base_blog_url>{SITE_URL}</wp:base_blog_url>

	<wp:author>
		<wp:author_id>1</wp:author_id>
		<wp:author_login><![CDATA[admin]]></wp:author_login>
		<wp:author_email><![CDATA[info@seniorbolaget.se]]></wp:author_email>
		<wp:author_display_name><![CDATA[Seniorbolaget]]></wp:author_display_name>
		<wp:author_first_name><![CDATA[Senior]]></wp:author_first_name>
		<wp:author_last_name><![CDATA[Bolaget]]></wp:author_last_name>
	</wp:author>

	<wp:category>
		<wp:term_id>1</wp:term_id>
		<wp:category_nicename><![CDATA[blogg]]></wp:category_nicename>
		<wp:category_parent><![CDATA[]]></wp:category_parent>
		<wp:cat_name><![CDATA[Blogg]]></wp:cat_name>
	</wp:category>

{"".join(items)}

</channel>
</rss>"""

with open(OUT, "w", encoding="utf-8") as f:
    f.write(xml)

pages_count = len(PAGES)
posts_count = len(BLOG_POSTS)
print(f"✅ WXR genererad: {OUT}")
print(f"   Sidor: {pages_count} (inkl. {sum(1 for _,_,p,_,_ in PAGES if p == '/har-finns-vi')} ortssidor)")
print(f"   Blogg: {posts_count} inlägg")
print(f"   Totalt: {pages_count + posts_count} items")
print(f"\nImportera via: WordPress → Verktyg → Importera → WordPress")
