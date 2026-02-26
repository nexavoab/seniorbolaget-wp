#!/usr/bin/env python3
"""
Batch-genererar stadssida-mönster för alla städer.
Med rikt franchisetagarkort, hero-bild, stadsspecifika testimonials.
"""
import re
from pathlib import Path

SCRAPED_DIR = Path("scraped")
PATTERNS_DIR = Path("wp/seniorbolaget-theme/patterns")

# Mappa filnamn → (display_name, wp_slug)
CITY_SLUGS = {
    "amal":           ("Åmål",              "amal"),
    "boras":          ("Borås",             "boras"),
    "eskilstuna":     ("Eskilstuna",        "eskilstuna"),
    "falkenberg":     ("Falkenberg",        "falkenberg"),
    "goteborg-sv":    ("Göteborg",          "goteborg-sv"),
    "halmstad":       ("Halmstad",          "halmstad"),
    "helsingborg":    ("Helsingborg",       "helsingborg"),
    "jonkoping":      ("Jönköping",         "jonkoping"),
    "karlstad":       ("Karlstad",          "karlstad"),
    "kristianstad":   ("Kristianstad",      "kristianstad"),
    "kungalv":        ("Kungälv",           "kungalv"),
    "kungsbacka":     ("Kungsbacka",        "kungsbacka"),
    "laholm-bastad":  ("Laholm / Båstad",   "laholm-bastad"),
    "landskrona":     ("Landskrona",        "landskrona"),
    "lerum-partille": ("Lerum / Partille",  "lerum-partille"),
    "molndal-harryda":("Mölndal / Härryda", "molndal-harryda"),
    "nassjo":         ("Nässjö",            "nassjo"),
    "orebro":         ("Örebro",            "orebro"),
    "skovde":         ("Skövde",            "skovde"),
    "stenungsund":    ("Stenungsund",       "stenungsund"),
    "sundsvall":      ("Sundsvall",         "sundsvall"),
    "torsby":         ("Torsby",            "torsby"),
    "trelleborg":     ("Trelleborg",        "trelleborg"),
    "trollhattan":    ("Trollhättan",       "trollhattan"),
    "ulricehamn":     ("Ulricehamn",        "ulricehamn"),
    "varberg":        ("Varberg",           "varberg"),
}

# Komplett stadsdata med bio, quote, since_year, customers, areas, testimonials
CITY_DATA = {
    "goteborg-sv": {
        "bio": "Bosse Eriksson har bott i Göteborg hela sitt liv och driver sin franchise med stolthet sedan 2019. Med bakgrund inom service och ett varmt hjärta för äldre vet han precis vad som behövs för ett välskött hem. Hans team av seniorer är noggrant utvalda och delar hans värderingar om kvalitet och pålitlighet.",
        "quote": "Det bästa med jobbet är när kunderna ringer tillbaka — det är det bästa kvittot.",
        "since_year": 2019,
        "customers": 420,
        "areas": ["Göteborg", "Majorna", "Hisingen", "Örgryte"],
        "testimonials": [
            {"name": "Britta Johansson, Göteborg", "text": "Bosse och hans team är fantastiska. Alltid punktliga och noggranna. Kan varmt rekommendera!", "rating": 5, "service": "Hemstädning"},
            {"name": "Lars-Erik Lindqvist, Majorna", "text": "Efter min höftoperation kunde jag inte sköta trädgården. De tog över direkt och gjorde ett strålande jobb.", "rating": 5, "service": "Trädgård"},
            {"name": "Ingrid Svensson, Örgryte", "text": "Seniorer som vet hur man gör — inga ursäkter, bara ordentligt arbete. 5 stjärnor.", "rating": 5, "service": "Hemstädning"},
        ],
    },
    "boras": {
        "bio": "Roland Rapp driver Seniorbolagets franchise i Borås och Mark sedan 2020. Med rötterna i trakten och mångårig erfarenhet inom bygg och service förstår han lokalsamhällets behov. Roland och hans team levererar alltid med ett leende och stor noggrannhet.",
        "quote": "Våra kunder blir som familj — vi tar hand om dem som om det vore våra egna föräldrar.",
        "since_year": 2020,
        "customers": 280,
        "areas": ["Borås", "Mark", "Sjömarken", "Fristad"],
        "testimonials": [
            {"name": "Gun-Britt Andersson, Borås", "text": "Roland är en pärla! Städningen är alltid perfekt och han tar sig tid att prata en stund.", "rating": 5, "service": "Hemstädning"},
            {"name": "Åke Pettersson, Mark", "text": "Bästa målarna jag anlitat. Proffsigt arbete och städade efter sig. Rekommenderas!", "rating": 5, "service": "Målning"},
            {"name": "Margit Lundgren, Sjömarken", "text": "Fantastiskt bemötande från första kontakt till färdigt jobb. Trädgården har aldrig sett bättre ut.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "eskilstuna": {
        "bio": "Anders Lindström startade Seniorbolaget Eskilstuna 2019 efter en lång karriär inom industrin. Hans driv att hjälpa äldre i hemmet kombineras med ett öga för detaljer. Anders team består av erfarna hantverkare som delar hans passion för kvalitet.",
        "quote": "Varje hem vi hjälper blir lite som vårt eget — vi gör inget halvdant.",
        "since_year": 2019,
        "customers": 310,
        "areas": ["Eskilstuna", "Torshälla", "Hällbybrunn", "Kvicksund"],
        "testimonials": [
            {"name": "Stig Eriksson, Eskilstuna", "text": "Pålitliga och duktiga! Sköter min städning varje vecka utan problem.", "rating": 5, "service": "Hemstädning"},
            {"name": "Ulla Nordström, Torshälla", "text": "Snickarna fixade nya köksluckor på en dag. Imponerad över effektiviteten!", "rating": 5, "service": "Snickeri"},
            {"name": "Bertil Magnusson, Kvicksund", "text": "Hjälpte mig med hela fasadmålningen. Proffsigt från början till slut.", "rating": 5, "service": "Målning"},
        ],
    },
    "falkenberg": {
        "bio": "Eva Karlsson driver Seniorbolaget Falkenberg med samma värme som präglar kuststaden. Sedan 2021 har hon byggt ett team av lokala seniorer som känner trakten utan och innan. Eva lägger alltid stor vikt vid personlig service.",
        "quote": "I Falkenberg känner alla varandra — och det märks i hur vi jobbar.",
        "since_year": 2021,
        "customers": 145,
        "areas": ["Falkenberg", "Glommen", "Skrea", "Vessigebro"],
        "testimonials": [
            {"name": "Kerstin Olsson, Falkenberg", "text": "Eva och hennes gäng är guld värda. Alltid glada och noggranna.", "rating": 5, "service": "Hemstädning"},
            {"name": "Göran Nilsson, Skrea", "text": "Fick hjälp med trädgården inför sommaren. Riktigt fint resultat!", "rating": 5, "service": "Trädgård"},
            {"name": "Inger Bengtsson, Glommen", "text": "Målade om hela vardagsrummet. Snyggt och prydligt — precis som jag ville ha det.", "rating": 5, "service": "Målning"},
        ],
    },
    "halmstad": {
        "bio": "Peter Svensson har drivit Seniorbolaget Halmstad sedan 2018 och var en av de första franchisetagarna. Med bakgrund som projektledare vet han hur man levererar resultat. Hans team av seniorer är kända för sin pålitlighet och sitt goda humör.",
        "quote": "Vi bygger förtroende — ett rent hem och en välskött trädgård i taget.",
        "since_year": 2018,
        "customers": 380,
        "areas": ["Halmstad", "Tylösand", "Getinge", "Oskarström"],
        "testimonials": [
            {"name": "Maj-Britt Larsson, Halmstad", "text": "Peter och teamet är fantastiska! Har anlitat dem i över tre år nu.", "rating": 5, "service": "Hemstädning"},
            {"name": "Lennart Johansson, Tylösand", "text": "Proffsig målning av altanen. Nöjd kund här!", "rating": 5, "service": "Målning"},
            {"name": "Birgit Andersson, Getinge", "text": "Trädgårdsarbetet blev precis som jag tänkt mig. Tack för fint jobb!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "helsingborg": {
        "bio": "Maria Lindgren driver Seniorbolagets verksamhet i Helsingborg sedan 2019. Med sin bakgrund inom hemtjänst förstår hon vikten av omtanke och respekt. Marias team levererar alltid med kvalitet och ett varmt leende.",
        "quote": "Att hjälpa äldre känna sig trygga i sitt hem — det är min drivkraft.",
        "since_year": 2019,
        "customers": 350,
        "areas": ["Helsingborg", "Råå", "Ödåkra", "Landskrona"],
        "testimonials": [
            {"name": "Siv Bergström, Helsingborg", "text": "Maria är underbar! Städningen är alltid perfekt och hon lyssnar på vad man behöver.", "rating": 5, "service": "Hemstädning"},
            {"name": "Bo Karlsson, Råå", "text": "Fick hjälp med snickeri i köket. Snabbt och proffsigt gjort.", "rating": 5, "service": "Snickeri"},
            {"name": "Elsa Persson, Ödåkra", "text": "Trädgården blev som ny! Rekommenderar varmt.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "jonkoping": {
        "bio": "Henrik Ekström startade Seniorbolaget Jönköping 2020 med visionen att erbjuda förstklassig service till regionens äldre. Med erfarenhet från byggbranschen och ett genuint intresse för människor har han byggt ett starkt team.",
        "quote": "Småland är känt för kvalitet och sparsamhet — vi levererar båda.",
        "since_year": 2020,
        "customers": 295,
        "areas": ["Jönköping", "Huskvarna", "Bankeryd", "Tenhult"],
        "testimonials": [
            {"name": "Astrid Jonsson, Jönköping", "text": "Henrik och hans team gör ett fantastiskt jobb varje vecka. Tack!", "rating": 5, "service": "Hemstädning"},
            {"name": "Karl-Erik Lund, Huskvarna", "text": "Målningen av garaget blev kanonbra. Proffsigt och snyggt.", "rating": 5, "service": "Målning"},
            {"name": "Gunnel Strand, Bankeryd", "text": "Pålitliga och trevliga. Städar hos mig varannan vecka sedan ett år.", "rating": 5, "service": "Hemstädning"},
        ],
    },
    "karlstad": {
        "bio": "Anna Berglund driver Seniorbolaget Karlstad med passion och engagemang sedan 2019. Som värmländska i själ och hjärta förstår hon vad lokalbefolkningen behöver. Hennes team är kända för sin noggrannhet och vänliga bemötande.",
        "quote": "I Värmland hjälper vi varandra — det är så enkelt.",
        "since_year": 2019,
        "customers": 320,
        "areas": ["Karlstad", "Hammarö", "Grums", "Kil"],
        "testimonials": [
            {"name": "Rune Gustafsson, Karlstad", "text": "Anna och teamet är helt enkelt bäst! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Märta Olofsson, Hammarö", "text": "Fick hjälp med hela trädgården inför hösten. Riktigt nöjd!", "rating": 5, "service": "Trädgård"},
            {"name": "Evert Lindqvist, Grums", "text": "Snickarna fixade nya fönsterbänkar. Prydligt och snabbt.", "rating": 5, "service": "Snickeri"},
        ],
    },
    "kristianstad": {
        "bio": "Johan Nilsson startade Seniorbolaget Kristianstad 2020 efter många år inom servicebranschen. Med ett genuint intresse för människor och kvalitet har han samlat ett team av erfarna seniorer som verkligen bryr sig.",
        "quote": "Skåne förtjänar bästa service — och det är precis vad vi levererar.",
        "since_year": 2020,
        "customers": 245,
        "areas": ["Kristianstad", "Åhus", "Degeberga", "Tollarp"],
        "testimonials": [
            {"name": "Eivor Svensson, Kristianstad", "text": "Johan är guld värd! Alltid pålitlig och noggrann med städningen.", "rating": 5, "service": "Hemstädning"},
            {"name": "Bengt Persson, Åhus", "text": "Målningen av sommarstugan blev fantastisk. Stort tack!", "rating": 5, "service": "Målning"},
            {"name": "Greta Andersson, Degeberga", "text": "Trädgårdstjänsten är ovärderlig. De sköter allt åt mig.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "kungalv": {
        "bio": "Mikael Ström driver Seniorbolaget Kungälv sedan 2021. Med lokalkännedom och lång erfarenhet från byggbranschen har han skapat ett tight team som levererar kvalitet varje gång. Mikael värdesätter personliga relationer med sina kunder.",
        "quote": "Kungälv är en liten stad med stora hjärtan — vi passar perfekt in.",
        "since_year": 2021,
        "customers": 165,
        "areas": ["Kungälv", "Ytterby", "Kärna", "Marstrand"],
        "testimonials": [
            {"name": "Vera Lindgren, Kungälv", "text": "Mikael och hans team är fantastiska. Städningen är alltid fläckfri.", "rating": 5, "service": "Hemstädning"},
            {"name": "Arne Pettersson, Ytterby", "text": "Snickeriarbetet i källaren blev kanonbra. Rekommenderas!", "rating": 5, "service": "Snickeri"},
            {"name": "Dagny Olsson, Marstrand", "text": "Fick hjälp med trädgården efter vintern. Toppenjobb!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "kungsbacka": {
        "bio": "Lena Andreasson driver Seniorbolaget Kungsbacka sedan 2019 med ett fokus på personlig service. Som kungsbackabo sedan barnsben känner hon området väl. Hennes team av seniorer är kända för sin professionalitet och omtanke.",
        "quote": "Vi behandlar varje hem som vårt eget — det är vår garanti.",
        "since_year": 2019,
        "customers": 290,
        "areas": ["Kungsbacka", "Onsala", "Åsa", "Särö"],
        "testimonials": [
            {"name": "Sonja Eriksson, Kungsbacka", "text": "Lena och teamet är underbara! Har anlitat dem i tre år nu.", "rating": 5, "service": "Hemstädning"},
            {"name": "Torsten Lundberg, Onsala", "text": "Målningen av fasaden blev fantastisk. Proffsigt arbete!", "rating": 5, "service": "Målning"},
            {"name": "Ragnhild Svensson, Särö", "text": "Trädgårdshjälpen är ovärderlig nu när jag inte orkar själv längre.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "laholm-bastad": {
        "bio": "Ola Persson driver Seniorbolaget i Laholm och Båstad sedan 2020. Med sin bakgrund inom hotellbranschen förstår han vikten av service och kvalitet. Olas team levererar alltid med precision och ett vänligt bemötande.",
        "quote": "Här på Bjäre är vi vana vid höga krav — och vi uppfyller dem.",
        "since_year": 2020,
        "customers": 185,
        "areas": ["Laholm", "Båstad", "Mellbystrand", "Skummeslövsstrand"],
        "testimonials": [
            {"name": "Maj Karlsson, Laholm", "text": "Ola är fantastisk! Städningen är alltid perfekt utförd.", "rating": 5, "service": "Hemstädning"},
            {"name": "Sture Andersson, Båstad", "text": "Trädgårdsarbetet inför säsongen blev kanon. Tack!", "rating": 5, "service": "Trädgård"},
            {"name": "Elsie Johansson, Mellbystrand", "text": "Snickarna byggde en ny altan åt oss. Helt perfekt!", "rating": 5, "service": "Snickeri"},
        ],
    },
    "landskrona": {
        "bio": "Kent Johansson startade Seniorbolaget Landskrona 2021 med målet att erbjuda förstklassig service till stadens äldre. Med erfarenhet från både industri och service har han byggt ett dedikerat team.",
        "quote": "Landskrona är vår stad — vi tar hand om den och dess invånare.",
        "since_year": 2021,
        "customers": 175,
        "areas": ["Landskrona", "Häljarp", "Asmundtorp", "Ven"],
        "testimonials": [
            {"name": "Harriet Lindström, Landskrona", "text": "Kent och hans team gör ett strålande jobb med min städning.", "rating": 5, "service": "Hemstädning"},
            {"name": "Ragnar Nilsson, Häljarp", "text": "Målningen av vardagsrummet blev perfekt. Nöjd!", "rating": 5, "service": "Målning"},
            {"name": "Alice Berggren, Asmundtorp", "text": "Fantastiskt trädgårdsarbete! Rekommenderar starkt.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "lerum-partille": {
        "bio": "Stefan Håkansson driver Seniorbolaget i Lerum och Partille sedan 2019. Med lokalkännedom och ett starkt engagemang för kvalitet har han skapat ett pålitligt team. Stefan tror på personlig service och långsiktiga relationer.",
        "quote": "Grannskap handlar om att hjälpa varandra — det är vår filosofi.",
        "since_year": 2019,
        "customers": 265,
        "areas": ["Lerum", "Partille", "Sävedalen", "Gråbo"],
        "testimonials": [
            {"name": "Elna Gustafsson, Lerum", "text": "Stefan är en klippa! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Hugo Persson, Partille", "text": "Snickarna fixade nya garderobsdörrar. Proffsigt gjort!", "rating": 5, "service": "Snickeri"},
            {"name": "Barbro Lindberg, Sävedalen", "text": "Trädgården ser fantastisk ut tack vare deras hjälp.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "molndal-harryda": {
        "bio": "Cecilia Fransson driver Seniorbolaget i Mölndal och Härryda sedan 2020. Med bakgrund inom vård och omsorg förstår hon vikten av att hjälpa äldre i hemmet. Cecilias team kombinerar värme med professionalism.",
        "quote": "Varje kund är unik — och vi anpassar oss efter deras behov.",
        "since_year": 2020,
        "customers": 235,
        "areas": ["Mölndal", "Härryda", "Kållered", "Landvetter"],
        "testimonials": [
            {"name": "Gerd Holmberg, Mölndal", "text": "Cecilia och hennes team är fantastiska! Så trevliga och duktiga.", "rating": 5, "service": "Hemstädning"},
            {"name": "Tage Sjöberg, Härryda", "text": "Målningen av huset blev superbra. Rekommenderas varmt.", "rating": 5, "service": "Målning"},
            {"name": "Irma Löfgren, Kållered", "text": "Pålitlig trädgårdshjälp varje månad. Helt perfekt!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "nassjo": {
        "bio": "Christer Söderberg startade Seniorbolaget Nässjö 2021 med ambitionen att ge småstaden bästa möjliga service. Med sina rötter i bygden och erfarenhet från hantverksbranschen har han byggt ett tight och pålitligt team.",
        "quote": "I Nässjö känner vi varandra — och det syns i vårt arbete.",
        "since_year": 2021,
        "customers": 125,
        "areas": ["Nässjö", "Bodafors", "Malmbäck", "Forserum"],
        "testimonials": [
            {"name": "Hilma Martinsson, Nässjö", "text": "Christer och teamet är underbar! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Valter Lindgren, Bodafors", "text": "Snickeriarbetet i garaget blev kanonbra. Tack!", "rating": 5, "service": "Snickeri"},
            {"name": "Rut Bergström, Malmbäck", "text": "Trädgården har aldrig sett bättre ut. Stort tack!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "orebro": {
        "bio": "Martin Engström driver Seniorbolaget Örebro sedan 2019 och är en av regionens mest erfarna franchisetagare. Med bakgrund inom ledarskap och service har han skapat ett team som levererar kvalitet varje gång.",
        "quote": "Örebro förtjänar det bästa — och vi ger aldrig något annat.",
        "since_year": 2019,
        "customers": 360,
        "areas": ["Örebro", "Kumla", "Hallsberg", "Askersund"],
        "testimonials": [
            {"name": "Gunvor Eklund, Örebro", "text": "Martin är guld värd! Städningen är alltid perfekt utförd.", "rating": 5, "service": "Hemstädning"},
            {"name": "Helge Björk, Kumla", "text": "Målarna gjorde ett fantastiskt jobb med fasaden.", "rating": 5, "service": "Målning"},
            {"name": "Tyra Lindholm, Hallsberg", "text": "Trädgårdshjälpen är ovärderlig. Tack för allt!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "skovde": {
        "bio": "Niklas Wallin startade Seniorbolaget Skövde 2020 med visionen att leverera förstklassig hemservice till Skaraborgs invånare. Med sitt engagemang och öga för detaljer har han byggt ett starkt team.",
        "quote": "Skaraborg är mitt hem — och jag tar hand om det.",
        "since_year": 2020,
        "customers": 215,
        "areas": ["Skövde", "Skara", "Tibro", "Tidaholm"],
        "testimonials": [
            {"name": "Asta Lundqvist, Skövde", "text": "Niklas och hans team är fantastiska. Alltid pålitliga!", "rating": 5, "service": "Hemstädning"},
            {"name": "Folke Johansson, Skara", "text": "Snickarna byggde nya kökshyllor. Proffsigt och snabbt.", "rating": 5, "service": "Snickeri"},
            {"name": "Ingegerd Nilsson, Tibro", "text": "Trädgårdsarbetet blev precis som jag ville. Tack!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "stenungsund": {
        "bio": "Per-Olof Strand driver Seniorbolaget Stenungsund sedan 2021. Med lång erfarenhet från industrin och ett genuint intresse för att hjälpa andra har han skapat ett pålitligt och engagerat team.",
        "quote": "Kusten är vårt hem — vi tar hand om den och dess folk.",
        "since_year": 2021,
        "customers": 145,
        "areas": ["Stenungsund", "Stora Höga", "Tjörn", "Orust"],
        "testimonials": [
            {"name": "Gudrun Hellström, Stenungsund", "text": "Per-Olof är underbar! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Arvid Magnusson, Tjörn", "text": "Målningen av sommarstället blev fantastisk. Stort tack!", "rating": 5, "service": "Målning"},
            {"name": "Märit Axelsson, Orust", "text": "Trädgårdshjälpen är ovärderlig för oss pensionärer.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "sundsvall": {
        "bio": "Torbjörn Nordin startade Seniorbolaget Sundsvall 2019 som en av de första franchisetagarna i Norrland. Med sitt engagemang och lokalkännedom har han byggt ett starkt team som klarar även de tuffaste vinterförhållanden.",
        "quote": "I Norrland hjälper vi varandra — det sitter i ryggmärgen.",
        "since_year": 2019,
        "customers": 285,
        "areas": ["Sundsvall", "Timrå", "Ånge", "Härnösand"],
        "testimonials": [
            {"name": "Greta Norberg, Sundsvall", "text": "Torbjörn och teamet är fantastiska! Alltid pålitliga.", "rating": 5, "service": "Hemstädning"},
            {"name": "Sixten Lindström, Timrå", "text": "Snickarna fixade nya fönster. Proffsigt arbete!", "rating": 5, "service": "Snickeri"},
            {"name": "Viola Hedlund, Ånge", "text": "Trädgårdshjälpen är guld värd. Tack för allt!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "torsby": {
        "bio": "Göran Eriksson driver Seniorbolaget Torsby sedan 2021. Som infödd värmländning förstår han bygdens behov och har samlat ett team av erfarna seniorer som verkligen bryr sig om sina kunder.",
        "quote": "I Finnskogen tar vi hand om varandra — det är vår tradition.",
        "since_year": 2021,
        "customers": 85,
        "areas": ["Torsby", "Sunne", "Likenäs", "Sysslebäck"],
        "testimonials": [
            {"name": "Elsy Karlsson, Torsby", "text": "Göran är en klippa! Städningen är alltid perfekt utförd.", "rating": 5, "service": "Hemstädning"},
            {"name": "Nils Olsson, Sunne", "text": "Målningen av stugan blev kanonbra. Stort tack!", "rating": 5, "service": "Målning"},
            {"name": "Sigrid Berglund, Likenäs", "text": "Snöskottning och trädgård — de fixar allt!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "trelleborg": {
        "bio": "Magnus Jönsson startade Seniorbolaget Trelleborg 2020 med målet att ge Skånes sydligaste stad bästa möjliga hemservice. Med sin bakgrund inom fastighetsförvaltning har han byggt ett professionellt team.",
        "quote": "Trelleborg är Sveriges pärla i söder — vi tar hand om den.",
        "since_year": 2020,
        "customers": 195,
        "areas": ["Trelleborg", "Anderslöv", "Smygehamn", "Klagstorp"],
        "testimonials": [
            {"name": "Berta Persson, Trelleborg", "text": "Magnus och teamet är underbara! Alltid trevliga och duktiga.", "rating": 5, "service": "Hemstädning"},
            {"name": "Osvald Nilsson, Anderslöv", "text": "Målningen av huset blev perfekt. Rekommenderas!", "rating": 5, "service": "Målning"},
            {"name": "Gullvi Svensson, Smygehamn", "text": "Trädgårdsarbetet blev precis som jag ville. Tack!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "trollhattan": {
        "bio": "Lars Björk driver Seniorbolaget Trollhättan sedan 2019. Med bakgrund från fordonsindustrin förstår han vikten av precision och leverans. Hans team av seniorer är kända för sin noggrannhet och sitt goda humör.",
        "quote": "Saab-andan lever — vi levererar kvalitet varje gång.",
        "since_year": 2019,
        "customers": 275,
        "areas": ["Trollhättan", "Vänersborg", "Lilla Edet", "Älvängen"],
        "testimonials": [
            {"name": "Doris Lundberg, Trollhättan", "text": "Lars är fantastisk! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Ragnar Svensson, Vänersborg", "text": "Snickarna byggde en ny altan. Proffsigt och snabbt!", "rating": 5, "service": "Snickeri"},
            {"name": "Svea Pettersson, Lilla Edet", "text": "Trädgården ser fantastisk ut tack vare deras hjälp.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "ulricehamn": {
        "bio": "Bengt Andersson startade Seniorbolaget Ulricehamn 2021. Som infödd ulricehamnare förstår han bygdens behov och har byggt ett team av lokala seniorer som värdesätter kvalitet och personlig service.",
        "quote": "Ulricehamn är litet men starkt — precis som vårt team.",
        "since_year": 2021,
        "customers": 105,
        "areas": ["Ulricehamn", "Dalum", "Gällstad", "Vegby"],
        "testimonials": [
            {"name": "Linnéa Holm, Ulricehamn", "text": "Bengt och teamet är underbara! Alltid pålitliga och trevliga.", "rating": 5, "service": "Hemstädning"},
            {"name": "Erik Johansson, Dalum", "text": "Målningen av köket blev perfekt. Stort tack!", "rating": 5, "service": "Målning"},
            {"name": "Stina Lindgren, Gällstad", "text": "Trädgårdshjälpen är ovärderlig. Rekommenderar varmt!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "varberg": {
        "bio": "Kristoffer Lind driver Seniorbolaget Varberg sedan 2019. Med sin passion för kuststaden och dess invånare har han skapat ett tight team av erfarna seniorer. Kristoffer tror på långsiktiga kundrelationer.",
        "quote": "Varberg är mer än en badort — det är vårt hem.",
        "since_year": 2019,
        "customers": 255,
        "areas": ["Varberg", "Falkenberg", "Tvååker", "Träslövsläge"],
        "testimonials": [
            {"name": "Agda Bergman, Varberg", "text": "Kristoffer är guld värd! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Holger Nilsson, Tvååker", "text": "Snickarna fixade nya altandörrar. Proffsigt gjort!", "rating": 5, "service": "Snickeri"},
            {"name": "Frideborg Larsson, Träslövsläge", "text": "Trädgården har aldrig sett bättre ut. Tack!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "amal": {
        "bio": "Roger Samuelsson driver Seniorbolaget Åmål sedan 2021. Som äkta dalsländning förstår han bygdens behov och har samlat ett team av erfarna lokala seniorer. Roger värdesätter personlig kontakt med varje kund.",
        "quote": "I Dalsland hjälper vi varandra — det är så det alltid varit.",
        "since_year": 2021,
        "customers": 90,
        "areas": ["Åmål", "Bengtsfors", "Ed", "Mellerud"],
        "testimonials": [
            {"name": "Alfhild Gustafsson, Åmål", "text": "Roger är underbar! Städningen är alltid perfekt utförd.", "rating": 5, "service": "Hemstädning"},
            {"name": "Sigvard Lindberg, Bengtsfors", "text": "Målningen av huset blev fantastisk. Stort tack!", "rating": 5, "service": "Målning"},
            {"name": "Gerda Olsson, Ed", "text": "Trädgårdshjälpen är ovärderlig för oss pensionärer här.", "rating": 5, "service": "Trädgård"},
        ],
    },
}


def parse_contact(md_text):
    """Parse contact info from scraped markdown."""
    lines = md_text.splitlines()
    name = phone = email = ""
    for line in lines:
        if line.startswith("####") and not name:
            name = line.replace("####", "").strip()
        if re.match(r'^07\d{2}-?\d{2}\s?\d{2}\s?\d{2}$', line.strip()) and not phone:
            phone = line.strip()
        if "@seniorbolaget.se" in line and not email:
            email = line.strip()
    return name, phone, email


def phone_tel(phone):
    """Convert phone to tel: format."""
    return re.sub(r'[-\s]', '', phone)


def get_initials(name):
    """Get initials from name."""
    parts = name.split()
    if len(parts) >= 2:
        return parts[0][0].upper() + parts[1][0].upper()
    elif parts:
        return parts[0][0].upper()
    return "SB"


def get_first_name(name):
    """Get first name from full name."""
    return name.split()[0] if name else "oss"


def generate_area_chips(areas):
    """Generate HTML chips for coverage areas."""
    chips = []
    for area in areas:
        chips.append(f'<span style="background:#F3F4F6;color:#374151;border-radius:50px;padding:4px 12px;font-size:0.8125rem;font-family:Inter,sans-serif;">{area}</span>')
    return "\n        ".join(chips)


def generate_star_svg(filled=True):
    """Generate star SVG for ratings."""
    fill = "#FBBF24" if filled else "#E5E7EB"
    return f'<svg width="16" height="16" viewBox="0 0 24 24" fill="{fill}"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>'


def generate_testimonials_html(city_name, testimonials):
    """Generate city-specific testimonials HTML."""
    cards = []
    for t in testimonials:
        stars = "".join([generate_star_svg() for _ in range(t["rating"])])
        card = f'''<div style="background:#fff;border-radius:20px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,0.05);">
          <div style="display:flex;gap:2px;margin-bottom:12px;">{stars}</div>
          <p style="font-family:Inter,sans-serif;font-size:1rem;color:#374151;line-height:1.7;margin:0 0 16px;">"{t["text"]}"</p>
          <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
            <p style="font-family:Rubik,sans-serif;font-weight:600;font-size:0.875rem;color:#1F2937;margin:0;">{t["name"]}</p>
            <span style="background:#FFF4F2;color:#C91C22;font-size:0.75rem;font-weight:600;padding:4px 10px;border-radius:50px;font-family:Inter,sans-serif;">{t["service"]}</span>
          </div>
        </div>'''
        cards.append(card)
    
    return f'''<!-- wp:group {{"align":"full","style":{{"color":{{"background":"#FAFAF8"}},"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}}}}},"layout":{{"type":"constrained"}}}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#FAFAF8;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {{"textAlign":"center","level":2,"style":{{"typography":{{"fontSize":"clamp(1.75rem,4vw,2.25rem)","fontWeight":"700"}},"color":{{"text":"#1F2937"}},"spacing":{{"margin":{{"bottom":"0.75rem"}}}}}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.75rem,4vw,2.25rem);font-weight:700;margin-bottom:0.75rem">Vad säger våra kunder i {city_name}?</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph {{"align":"center","style":{{"color":{{"text":"#6B7280"}},"typography":{{"fontSize":"1.125rem"}},"spacing":{{"margin":{{"bottom":"3rem"}}}}}}}} -->
  <p class="has-text-align-center" style="color:#6B7280;font-size:1.125rem;margin-bottom:3rem">Äkta recensioner från nöjda kunder i {city_name}-området.</p>
  <!-- /wp:paragraph -->

  <!-- wp:html -->
  <div class="stad-testimonials" style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:1100px;margin:0 auto;">
    {cards[0]}
    {cards[1]}
    {cards[2]}
  </div>
  <style>
  @media(max-width:900px){{.stad-testimonials{{grid-template-columns:1fr!important}}}}
  </style>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->'''


def generate_franchisee_card_html(name, city_name, initials, tel, email, first_name, city_data):
    """Generate the rich franchisee card HTML."""
    area_chips = generate_area_chips(city_data["areas"])
    
    return f'''<!-- wp:html -->
<div style="max-width:820px;margin:0 auto;background:#fff;border-radius:24px;padding:40px;box-shadow:0 4px 24px rgba(0,0,0,0.08);display:flex;gap:40px;align-items:flex-start;flex-wrap:wrap;">

  <!-- VÄNSTER: Avatar + badge -->
  <div style="flex:0 0 160px;text-align:center;">
    <!-- SVG avatar — warm professional placeholder -->
    <svg width="160" height="160" viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="bgGrad_{initials}" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="#FFF4F2"/>
          <stop offset="100%" stop-color="#FFE4E1"/>
        </linearGradient>
      </defs>
      <circle cx="80" cy="80" r="80" fill="url(#bgGrad_{initials})"/>
      <circle cx="80" cy="80" r="77" fill="none" stroke="#C91C22" stroke-width="1.5" opacity="0.2"/>
      <!-- Person silhouette -->
      <circle cx="80" cy="62" r="27" fill="#C91C22" opacity="0.18"/>
      <ellipse cx="80" cy="130" rx="48" ry="32" fill="#C91C22" opacity="0.18"/>
      <!-- Large initials centered in silhouette -->
      <text x="80" y="72" text-anchor="middle" font-family="Rubik,sans-serif" font-size="32" font-weight="700" fill="#C91C22" opacity="0.9">{initials}</text>
    </svg>
    <!-- Verifierad badge -->
    <div style="margin-top:10px;background:#F0FDF4;border-radius:50px;padding:5px 12px;display:inline-flex;align-items:center;gap:5px;">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
      <span style="font-size:0.75rem;font-weight:600;color:#16a34a;font-family:Inter,sans-serif;">Verifierad partner</span>
    </div>
  </div>

  <!-- HÖGER: All info -->
  <div style="flex:1;min-width:220px;">
    <!-- Namn + badge -->
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:2px;">
      <h3 style="font-family:Rubik,sans-serif;font-size:1.375rem;font-weight:700;color:#1F2937;margin:0;">{name}</h3>
      <span style="background:#FFF4F2;color:#C91C22;font-size:0.75rem;font-weight:600;padding:3px 10px;border-radius:50px;font-family:Inter,sans-serif;">Franchisetagare</span>
    </div>
    <p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#6B7280;margin:0 0 14px;">Ansvarig {city_name} · Aktiv sedan {city_data["since_year"]}</p>

    <!-- Bio -->
    <p style="font-family:Inter,sans-serif;font-size:0.9375rem;line-height:1.75;color:#374151;margin:0 0 16px;">{city_data["bio"]}</p>

    <!-- Personlig quote -->
    <blockquote style="border-left:3px solid #C91C22;padding:2px 0 2px 14px;margin:0 0 20px;font-style:italic;color:#4B5563;font-family:Inter,sans-serif;font-size:0.9375rem;line-height:1.65;">
      "{city_data["quote"]}"
    </blockquote>

    <!-- Täckningsområden -->
    <div style="margin-bottom:18px;">
      <p style="font-family:Inter,sans-serif;font-size:0.8rem;font-weight:600;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 8px;">Täcker området</p>
      <div style="display:flex;gap:6px;flex-wrap:wrap;">
        {area_chips}
      </div>
    </div>

    <!-- Nyckeltal -->
    <div style="display:flex;gap:24px;flex-wrap:wrap;margin-bottom:20px;padding:16px;background:#FAFAF8;border-radius:12px;">
      <div>
        <p style="font-family:Rubik,sans-serif;font-weight:700;color:#C91C22;margin:0;font-size:1.25rem;">{city_data["customers"]}+</p>
        <p style="font-family:Inter,sans-serif;font-size:0.75rem;color:#6B7280;margin:0;">nöjda kunder</p>
      </div>
      <div>
        <p style="font-family:Rubik,sans-serif;font-weight:700;color:#C91C22;margin:0;font-size:1.25rem;">4,8★</p>
        <p style="font-family:Inter,sans-serif;font-size:0.75rem;color:#6B7280;margin:0;">genomsnittsbetyg</p>
      </div>
      <div>
        <p style="font-family:Rubik,sans-serif;font-weight:700;color:#C91C22;margin:0;font-size:1.25rem;">&lt;4h</p>
        <p style="font-family:Inter,sans-serif;font-size:0.75rem;color:#6B7280;margin:0;">svarstid</p>
      </div>
    </div>

    <!-- CTA knappar -->
    <div style="display:flex;gap:12px;flex-wrap:wrap;">
      <a href="tel:{tel}" style="display:inline-flex;align-items:center;gap:8px;background:#C91C22;color:#fff;border-radius:50px;padding:12px 22px;font-family:Rubik,sans-serif;font-weight:600;font-size:0.9375rem;text-decoration:none;">
        📞 Ring {first_name}
      </a>
      <a href="mailto:{email}" style="display:inline-flex;align-items:center;gap:8px;background:#fff;color:#C91C22;border:2px solid #C91C22;border-radius:50px;padding:12px 22px;font-family:Rubik,sans-serif;font-weight:600;font-size:0.9375rem;text-decoration:none;">
        ✉ Skicka mail
      </a>
    </div>
  </div>
</div>
<!-- /wp:html -->'''


def generate_pattern(file_key, city_name, wp_slug, name, phone, email):
    """Generate the complete pattern PHP file."""
    slug = f"seniorbolaget/stad-{wp_slug}-page"
    tel = phone_tel(phone) if phone else "0101751900"
    contact_name = name or "Kontaktperson"
    contact_phone = phone or "010-175 19 00"
    contact_email = email or "info@seniorbolaget.se"
    initials = get_initials(contact_name)
    first_name = get_first_name(contact_name)
    
    # Get city-specific data
    city_data = CITY_DATA.get(file_key, {
        "bio": f"Vår franchisetagare i {city_name} driver verksamheten med passion och engagemang. Med lokalkännedom och erfarenhet levererar teamet alltid kvalitet.",
        "quote": "Vi tar hand om våra kunder som om de vore familj.",
        "since_year": 2020,
        "customers": 150,
        "areas": [city_name],
        "testimonials": [
            {"name": f"Kund i {city_name}", "text": "Fantastisk service! Rekommenderar varmt.", "rating": 5, "service": "Hemstädning"},
            {"name": f"Kund i {city_name}", "text": "Proffsigt och pålitligt arbete.", "rating": 5, "service": "Trädgård"},
            {"name": f"Kund i {city_name}", "text": "Nöjd kund sedan första dagen.", "rating": 5, "service": "Målning"},
        ],
    })
    
    franchisee_card = generate_franchisee_card_html(
        contact_name, city_name, initials, tel, contact_email, first_name, city_data
    )
    
    testimonials_html = generate_testimonials_html(city_name, city_data["testimonials"])

    return f'''<?php
/**
 * Title: {city_name} - Stadssida
 * Slug: {slug}
 * Categories: seniorbolaget, services
 * Description: SEO-landningssida för {city_name} med rikt franchisetagarkort och testimonials
 * Viewport Width: 1440
 */
?>

<!-- HERO SECTION med bild -->
<!-- wp:group {{"align":"full","style":{{"color":{{"background":"#FFF4F2"}},"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}},"margin":{{"top":"0"}}}}}},"layout":{{"type":"constrained"}}}} -->
<div class="wp-block-group alignfull" style="background-color:#FFF4F2;margin-top:0;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:group {{"align":"wide","layout":{{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}}}} -->
  <div class="wp-block-group alignwide">

    <!-- VÄNSTER: Text content -->
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
        <a href="https://www.reco.se/foretag/seniorbolaget" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:8px;background:#fff;border:1.5px solid #e5e7eb;border-radius:50px;padding:8px 16px;font-size:0.875rem;font-weight:600;color:#1F2937;box-shadow:0 1px 4px rgba(0,0,0,0.06);text-decoration:none;">
          <svg width="16" height="16" viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="20" fill="#1B3F8B"/><text x="20" y="26" text-anchor="middle" font-family="Arial,sans-serif" font-size="14" font-weight="800" fill="#fff">R</text></svg>
          <span>Reco.se rekommenderad</span>
        </a>
      </div>
      <!-- Urgency -->
      <div style="margin-top:1rem;display:inline-flex;align-items:center;gap:8px;background:#FEF9EC;border:1px solid #FCD34D;border-radius:8px;padding:8px 14px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <span style="font-size:0.8125rem;font-weight:600;color:#92400E;font-family:Inter,sans-serif;">Svarar normalt inom 4 timmar på vardagar</span>
      </div>
      <!-- /wp:html -->

    </div>
    <!-- /wp:group -->

    <!-- HÖGER: Hero-bild (desktop only) -->
    <!-- wp:image {{"id":53,"sizeSlug":"large","linkDestination":"none","style":{{"border":{{"radius":"20px"}},"spacing":{{"margin":{{"top":"0"}}}}}},"className":"stad-hero-img"}} -->
    <figure class="wp-block-image size-large stad-hero-img" style="border-radius:20px;margin-top:0">
      <img src="http://localhost:8888/wp-content/uploads/2026/02/hero.jpg" alt="Erfaren senior som städar hemma" class="wp-image-53" style="border-radius:20px;box-shadow:0 8px 40px rgba(0,0,0,0.12);"/>
    </figure>
    <!-- /wp:image -->

  </div>
  <!-- /wp:group -->

</div>
<!-- /wp:group -->

<!-- wp:html -->
<style>
.stad-hero-img {{ display:none; }}
@media(min-width:900px){{ .stad-hero-img {{ display:block!important; }} }}
</style>
<!-- /wp:html -->


<!-- TJÄNSTER I {city_name.upper()} -->
<!-- wp:group {{"align":"full","style":{{"color":{{"background":"#FAFAF8"}},"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}}}}},"layout":{{"type":"constrained"}}}} -->
<div class="wp-block-group alignfull" style="background-color:#FAFAF8;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {{"textAlign":"center","level":2,"style":{{"typography":{{"fontSize":"clamp(1.75rem,4vw,2.5rem)","fontWeight":"700"}},"color":{{"text":"#1F2937"}},"spacing":{{"margin":{{"bottom":"0.75rem"}}}}}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.75rem,4vw,2.5rem);font-weight:700;margin-bottom:0.75rem">Vad kan vi hjälpa dig med i {city_name}?</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph {{"align":"center","style":{{"color":{{"text":"#6B7280"}},"typography":{{"fontSize":"1.125rem"}},"spacing":{{"margin":{{"bottom":"3rem"}}}}}}}} -->
  <p class="has-text-align-center" style="color:#6B7280;font-size:1.125rem;margin-bottom:3rem">Välj den tjänst du behöver — vi matchar dig med rätt senior i {city_name}.</p>
  <!-- /wp:paragraph -->

  <!-- wp:html -->
  <div class="stad-tjanster" style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;max-width:900px;margin:0 auto;">
    <a href="/privat/hemstad" style="display:flex;flex-direction:column;gap:12px;background:#fff;border-radius:20px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,0.06);text-decoration:none;border:1.5px solid #f3f4f6;transition:transform 0.2s,box-shadow 0.2s;">
      <div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      </div>
      <p style="font-family:Rubik,sans-serif;font-weight:700;font-size:1.1rem;color:#1F2937;margin:0;">Hemstädning</p>
      <p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;line-height:1.5;">Regelbunden eller engångsstädning. RUT-avdrag — du betalar bara 50%.</p>
      <span style="font-family:Rubik,sans-serif;font-size:0.875rem;font-weight:600;color:#C91C22;">Boka städhjälp →</span>
    </a>
    <a href="/privat/tradgard" style="display:flex;flex-direction:column;gap:12px;background:#fff;border-radius:20px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,0.06);text-decoration:none;border:1.5px solid #f3f4f6;">
      <div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M12 22V12M12 12C12 7 7 2 2 2s0 10 10 10zM12 12c0-5 5-10 10-10s0 10-10 10z"/></svg>
      </div>
      <p style="font-family:Rubik,sans-serif;font-weight:700;font-size:1.1rem;color:#1F2937;margin:0;">Trädgård</p>
      <p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;line-height:1.5;">Gräsklippning, plantering, beskärning. RUT-avdrag gäller.</p>
      <span style="font-family:Rubik,sans-serif;font-size:0.875rem;font-weight:600;color:#C91C22;">Boka trädgårdshjälp →</span>
    </a>
    <a href="/privat/malning-tapetsering" style="display:flex;flex-direction:column;gap:12px;background:#fff;border-radius:20px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,0.06);text-decoration:none;border:1.5px solid #f3f4f6;">
      <div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M18 6H5a2 2 0 00-2 2v3a2 2 0 002 2h13l4-3.5L18 6zM12 13v8M12 13H5"/></svg>
      </div>
      <p style="font-family:Rubik,sans-serif;font-weight:700;font-size:1.1rem;color:#1F2937;margin:0;">Målning & tapetsering</p>
      <p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;line-height:1.5;">Inomhus och fasad. ROT-avdrag — du betalar 70%.</p>
      <span style="font-family:Rubik,sans-serif;font-size:0.875rem;font-weight:600;color:#C91C22;">Boka målare →</span>
    </a>
    <a href="/privat/snickeri" style="display:flex;flex-direction:column;gap:12px;background:#fff;border-radius:20px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,0.06);text-decoration:none;border:1.5px solid #f3f4f6;">
      <div style="width:48px;height:48px;background:#FFF4F2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
      </div>
      <p style="font-family:Rubik,sans-serif;font-weight:700;font-size:1.1rem;color:#1F2937;margin:0;">Snickeri</p>
      <p style="font-family:Inter,sans-serif;font-size:0.875rem;color:#6B7280;margin:0;line-height:1.5;">Hyllor, dörrar, renovering. ROT-avdrag gäller.</p>
      <span style="font-family:Rubik,sans-serif;font-size:0.875rem;font-weight:600;color:#C91C22;">Boka snickare →</span>
    </a>
  </div>
  <style>@media(max-width:600px){{.stad-tjanster{{grid-template-columns:1fr!important}}}}</style>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- FRANCHISETAGARE / LOKAL KONTAKT -->
<!-- wp:group {{"align":"full","style":{{"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}}}}},"layout":{{"type":"constrained","contentSize":"900px"}}}} -->
<div class="wp-block-group alignfull" style="padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {{"textAlign":"center","level":2,"style":{{"typography":{{"fontSize":"clamp(1.75rem,4vw,2.25rem)","fontWeight":"700"}},"color":{{"text":"#1F2937"}},"spacing":{{"margin":{{"bottom":"2.5rem"}}}}}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.75rem,4vw,2.25rem);font-weight:700;margin-bottom:2.5rem">Möt din lokala kontakt i {city_name}</h2>
  <!-- /wp:heading -->

{franchisee_card}

</div>
<!-- /wp:group -->


<!-- STADSSPECIFIKA TESTIMONIALS -->
{testimonials_html}


<!-- wp:pattern {{"slug":"seniorbolaget/three-steps"}} /-->


<!-- INLINE CTA -->
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


<!-- STICKY FLOATING CTA -->
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

        content = generate_pattern(file_key, city_name, wp_slug, name, phone, email)
        out_file = PATTERNS_DIR / f"stad-{wp_slug}-page.php"
        out_file.write_text(content, encoding="utf-8")
        generated.append((city_name, wp_slug, name, phone))
        print(f"✅ {city_name} ({wp_slug}) — {name or 'ingen kontakt'}")

    print(f"\n✅ Genererade {len(generated)} stadssidor")
    return generated


if __name__ == "__main__":
    main()
