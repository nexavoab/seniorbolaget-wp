#!/usr/bin/env python3
"""
Scrape all pages from seniorbolaget.se and save content to markdown files.
"""
import json, time, re, os
from urllib.request import urlopen, Request
from urllib.error import URLError
from html.parser import HTMLParser

BASE_URL = "https://www.seniorbolaget.se"
OUT_DIR = os.path.join(os.path.dirname(__file__), "scraped")
os.makedirs(OUT_DIR, exist_ok=True)

PAGES = [
    "/",
    "/privat",
    "/privat/hemstad",
    "/privat/malning",
    "/privat/snickeri",
    "/privat/tradgard",
    "/företag",
    "/företag/bemanning",
    "/företag/for-brfer",
    "/företag/foretagstjanster",
    "/har-finns-vi",
    "/bli-franchisetagare",
    "/jobba-med-oss",
    "/om-oss",
    "/kontakt",
    "/intresse-anmalan",
    "/blog/10-essential-tips-for-a-home-construction",
    "/blog/7-essential-factors-for-choosing-the-right-builder",
    "/blog/designing-your-dream-home-a-comprehensive-step-by-step-guide",
    "/blog/innovations-shaping-the-future-of-sustainable-construction",
    "/blog/sustainable-building-practices-how-to-build-an-eco-friendly-home",
    "/blog/top-trends-in-modern-home-construction-what-to-expect-in-2024",
    "/våra-projekt/asian-heights",
    "/våra-projekt/foyez-lake-view",
    "/våra-projekt/hill-community",
    "/våra-projekt/jackson-tower",
    "/våra-projekt/liamson-tower",
]

# Location pages
LOCATIONS = [
    "amal","boras","eskilstuna","falkenberg","goteborg-sv","halmstad",
    "helsingborg","jonkoping","karlstad","kristianstad","kungalv","kungsbacka",
    "laholm-bastad","landskrona","lerum-partille","molndal-harryda","nassjo",
    "orebro","skovde","stenungsund","sundsvall","torsby","trelleborg",
    "trollhattan","ulricehamn","varberg"
]
for loc in LOCATIONS:
    PAGES.append(f"/har-finns-vi/{loc}")


def slug(url):
    s = url.strip("/").replace("/", "__")
    s = re.sub(r'[^\w\-_]', '_', s)
    return s or "index"


def fetch_text(url):
    req = Request(url, headers={"User-Agent": "Mozilla/5.0 (compatible; SeniorBot/1.0)"})
    try:
        with urlopen(req, timeout=10) as r:
            return r.read().decode("utf-8", errors="replace")
    except Exception as e:
        return f"ERROR: {e}"


class TextExtractor(HTMLParser):
    def __init__(self):
        super().__init__()
        self.skip_tags = {'script','style','noscript','svg','head'}
        self.heading_tags = {'h1','h2','h3','h4','h5','h6'}
        self._skip = 0
        self._cur_tag = None
        self.chunks = []
        self.title = ""
        self._in_title = False

    def handle_starttag(self, tag, attrs):
        if tag in self.skip_tags:
            self._skip += 1
        if tag == 'title':
            self._in_title = True
        self._cur_tag = tag

    def handle_endtag(self, tag):
        if tag in self.skip_tags and self._skip > 0:
            self._skip -= 1
        if tag == 'title':
            self._in_title = False
        if tag in self.heading_tags:
            self.chunks.append("")  # blank line after headings

    def handle_data(self, data):
        if self._skip > 0:
            return
        d = data.strip()
        if not d:
            return
        if self._in_title:
            self.title = d
            return
        prefix = ""
        if self._cur_tag == 'h1': prefix = "# "
        elif self._cur_tag == 'h2': prefix = "## "
        elif self._cur_tag == 'h3': prefix = "### "
        elif self._cur_tag == 'h4': prefix = "#### "
        elif self._cur_tag in ('h5','h6'): prefix = "##### "
        self.chunks.append(f"{prefix}{d}")


results = {}

for i, page in enumerate(PAGES, 1):
    url = BASE_URL + page
    print(f"[{i}/{len(PAGES)}] {url}")
    html = fetch_text(url)
    
    if html.startswith("ERROR:"):
        results[page] = {"error": html}
        continue

    parser = TextExtractor()
    parser.feed(html)
    
    # Deduplicate chunks
    seen = set()
    unique = []
    for c in parser.chunks:
        if c not in seen:
            seen.add(c)
            unique.append(c)
    
    text = "\n".join(unique).strip()
    
    # Save to file
    fname = slug(page) + ".md"
    fpath = os.path.join(OUT_DIR, fname)
    with open(fpath, "w") as f:
        f.write(f"# Page: {page}\n")
        f.write(f"Title: {parser.title}\n\n")
        f.write(text)
    
    results[page] = {"title": parser.title, "file": fname, "chars": len(text)}
    time.sleep(0.3)

# Summary
with open(os.path.join(OUT_DIR, "_summary.json"), "w") as f:
    json.dump(results, f, ensure_ascii=False, indent=2)

print(f"\n✅ Done! Scraped {len(results)} pages → {OUT_DIR}")
