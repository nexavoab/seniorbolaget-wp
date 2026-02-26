#!/usr/bin/env python3
"""
Batch-genererar stadssida-mönster för alla städer.
V3: Franchisetagarfokuserad struktur — personen ÄR sidan.
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

# Komplett stadsdata med story, quote, since_year, customers, areas, testimonials
CITY_DATA = {
    "goteborg-sv": {
        "story": [
            "Bosse Eriksson har bott i Göteborg hela sitt liv. När han gick i pension 2018 ville han fortsätta bidra — och hittade Seniorbolaget.",
            "Idag driver han sitt team av erfarna seniorer med stolthet. Varje kund behandlas som en granne, inte ett uppdrag.",
            "För Bosse är det enkelt: om hans egen mor skulle bo kvar hemma, hur hade han velat att det sköttes? Det är den frågan som styr allt."
        ],
        "quote": "Det bästa med jobbet är när kunderna ringer tillbaka — det är det bästa kvittot.",
        "since_year": 2019,
        "customers": 420,
        "areas": ["Göteborg", "Majorna", "Hisingen", "Örgryte"],
        "testimonials": [
            {"name": "Britta Johansson", "city": "Göteborg", "text": "Bosse och hans team är fantastiska. Alltid punktliga och noggranna. Kan varmt rekommendera!", "rating": 5, "service": "Hemstädning"},
            {"name": "Lars-Erik Lindqvist", "city": "Majorna", "text": "Efter min höftoperation kunde jag inte sköta trädgården. De tog över direkt och gjorde ett strålande jobb.", "rating": 5, "service": "Trädgård"},
            {"name": "Ingrid Svensson", "city": "Örgryte", "text": "Seniorer som vet hur man gör — inga ursäkter, bara ordentligt arbete. 5 stjärnor.", "rating": 5, "service": "Hemstädning"},
        ],
    },
    "boras": {
        "story": [
            "Roland Rapp växte upp i Borås och har alltid haft ett hjärta för trakten. Efter 35 år i byggbranschen kände han att det var dags för något nytt.",
            "När han upptäckte Seniorbolaget 2020 föll allt på plats. Nu leder han ett team av lokala seniorer som känner varje kvarter i staden.",
            "Roland säger ofta: 'Vi jobbar inte bara — vi bryr oss.' Det märks i varje uppdrag han och teamet tar sig an."
        ],
        "quote": "Våra kunder blir som familj — vi tar hand om dem som om det vore våra egna föräldrar.",
        "since_year": 2020,
        "customers": 280,
        "areas": ["Borås", "Mark", "Sjömarken", "Fristad"],
        "testimonials": [
            {"name": "Gun-Britt Andersson", "city": "Borås", "text": "Roland är en pärla! Städningen är alltid perfekt och han tar sig tid att prata en stund.", "rating": 5, "service": "Hemstädning"},
            {"name": "Åke Pettersson", "city": "Mark", "text": "Bästa målarna jag anlitat. Proffsigt arbete och städade efter sig. Rekommenderas!", "rating": 5, "service": "Målning"},
            {"name": "Margit Lundgren", "city": "Sjömarken", "text": "Fantastiskt bemötande från första kontakt till färdigt jobb. Trädgården har aldrig sett bättre ut.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "eskilstuna": {
        "story": [
            "Anders Lindström jobbade på Volvo i 30 år innan han hittade sin andra karriär. Han ville göra något meningsfullt med sin erfarenhet.",
            "Sedan 2019 driver han Seniorbolaget Eskilstuna med samma precision som på verkstadsgolvet — fast med betydligt mer mänsklig värme.",
            "Anders filosofi är enkel: gör det rätt första gången, och gör det med respekt för kundens hem."
        ],
        "quote": "Varje hem vi hjälper blir lite som vårt eget — vi gör inget halvdant.",
        "since_year": 2019,
        "customers": 310,
        "areas": ["Eskilstuna", "Torshälla", "Hällbybrunn", "Kvicksund"],
        "testimonials": [
            {"name": "Stig Eriksson", "city": "Eskilstuna", "text": "Pålitliga och duktiga! Sköter min städning varje vecka utan problem.", "rating": 5, "service": "Hemstädning"},
            {"name": "Ulla Nordström", "city": "Torshälla", "text": "Snickarna fixade nya köksluckor på en dag. Imponerad över effektiviteten!", "rating": 5, "service": "Snickeri"},
            {"name": "Bertil Magnusson", "city": "Kvicksund", "text": "Hjälpte mig med hela fasadmålningen. Proffsigt från början till slut.", "rating": 5, "service": "Målning"},
        ],
    },
    "falkenberg": {
        "story": [
            "Eva Karlsson flyttade tillbaka till Falkenberg efter 25 år i Stockholm. Hon saknade havet, lugnet — och gemenskapen.",
            "När hon startade Seniorbolaget Falkenberg 2021 var det för att ge tillbaka till samhället som format henne.",
            "Idag känner hon de flesta av sina kunder vid namn. I Falkenberg är det så det fungerar, säger hon."
        ],
        "quote": "I Falkenberg känner alla varandra — och det märks i hur vi jobbar.",
        "since_year": 2021,
        "customers": 145,
        "areas": ["Falkenberg", "Glommen", "Skrea", "Vessigebro"],
        "testimonials": [
            {"name": "Kerstin Olsson", "city": "Falkenberg", "text": "Eva och hennes gäng är guld värda. Alltid glada och noggranna.", "rating": 5, "service": "Hemstädning"},
            {"name": "Göran Nilsson", "city": "Skrea", "text": "Fick hjälp med trädgården inför sommaren. Riktigt fint resultat!", "rating": 5, "service": "Trädgård"},
            {"name": "Inger Bengtsson", "city": "Glommen", "text": "Målade om hela vardagsrummet. Snyggt och prydligt — precis som jag ville ha det.", "rating": 5, "service": "Målning"},
        ],
    },
    "halmstad": {
        "story": [
            "Peter Svensson var projektledare i 20 år innan han tröttnade på att jaga deadlines. Han ville göra något som faktiskt betydde något för människor.",
            "Som en av Seniorbolagets första franchisetagare (2018) har han sett verksamheten växa från grunden. Hans team i Halmstad är nu ett av de största.",
            "Peter tror på personlig service: varje kund får hans mobilnummer, och han svarar alltid."
        ],
        "quote": "Vi bygger förtroende — ett rent hem och en välskött trädgård i taget.",
        "since_year": 2018,
        "customers": 380,
        "areas": ["Halmstad", "Tylösand", "Getinge", "Oskarström"],
        "testimonials": [
            {"name": "Maj-Britt Larsson", "city": "Halmstad", "text": "Peter och teamet är fantastiska! Har anlitat dem i över tre år nu.", "rating": 5, "service": "Hemstädning"},
            {"name": "Lennart Johansson", "city": "Tylösand", "text": "Proffsig målning av altanen. Nöjd kund här!", "rating": 5, "service": "Målning"},
            {"name": "Birgit Andersson", "city": "Getinge", "text": "Trädgårdsarbetet blev precis som jag tänkt mig. Tack för fint jobb!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "helsingborg": {
        "story": [
            "Maria Lindgren jobbade inom hemtjänsten i 15 år. Hon såg hur systemet ofta misslyckades med att ge äldre den tid och omtanke de förtjänade.",
            "2019 startade hon Seniorbolaget Helsingborg med en enkel idé: behandla varje kund som hon skulle vilja att någon behandlade hennes föräldrar.",
            "Idag leder hon ett team på tolv seniorer som delar hennes värderingar om respekt och kvalitet."
        ],
        "quote": "Att hjälpa äldre känna sig trygga i sitt hem — det är min drivkraft.",
        "since_year": 2019,
        "customers": 350,
        "areas": ["Helsingborg", "Råå", "Ödåkra", "Landskrona"],
        "testimonials": [
            {"name": "Siv Bergström", "city": "Helsingborg", "text": "Maria är underbar! Städningen är alltid perfekt och hon lyssnar på vad man behöver.", "rating": 5, "service": "Hemstädning"},
            {"name": "Bo Karlsson", "city": "Råå", "text": "Fick hjälp med snickeri i köket. Snabbt och proffsigt gjort.", "rating": 5, "service": "Snickeri"},
            {"name": "Elsa Persson", "city": "Ödåkra", "text": "Trädgården blev som ny! Rekommenderar varmt.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "jonkoping": {
        "story": [
            "Henrik Ekström drev eget byggföretag i Jönköping i 25 år. När han sålde det ville han inte bara sluta jobba — han ville fortsätta bidra.",
            "Seniorbolaget passade perfekt. Sedan 2020 har han byggt ett tight team som kombinerar hantverkskunnande med genuin omsorg.",
            "Henrik skämtar ofta om att han jobbar hårdare nu än någonsin — men att det aldrig känns som jobb."
        ],
        "quote": "Småland är känt för kvalitet och sparsamhet — vi levererar båda.",
        "since_year": 2020,
        "customers": 295,
        "areas": ["Jönköping", "Huskvarna", "Bankeryd", "Tenhult"],
        "testimonials": [
            {"name": "Astrid Jonsson", "city": "Jönköping", "text": "Henrik och hans team gör ett fantastiskt jobb varje vecka. Tack!", "rating": 5, "service": "Hemstädning"},
            {"name": "Karl-Erik Lund", "city": "Huskvarna", "text": "Målningen av garaget blev kanonbra. Proffsigt och snyggt.", "rating": 5, "service": "Målning"},
            {"name": "Gunnel Strand", "city": "Bankeryd", "text": "Pålitliga och trevliga. Städar hos mig varannan vecka sedan ett år.", "rating": 5, "service": "Hemstädning"},
        ],
    },
    "karlstad": {
        "story": [
            "Anna Berglund är född och uppvuxen i Karlstad. Efter en karriär som sjuksköterska ville hon fortsätta hjälpa människor — på ett nytt sätt.",
            "Sedan 2019 driver hon Seniorbolaget Karlstad med omtanke och värmländsk gästfrihet. Hennes team behandlar varje hem som sitt eget.",
            "Anna säger att det bästa med jobbet är att se lättnaden i kundernas ögon när de förstår att de kan lita på henne."
        ],
        "quote": "I Värmland hjälper vi varandra — det är så enkelt.",
        "since_year": 2019,
        "customers": 320,
        "areas": ["Karlstad", "Hammarö", "Grums", "Kil"],
        "testimonials": [
            {"name": "Rune Gustafsson", "city": "Karlstad", "text": "Anna och teamet är helt enkelt bäst! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Märta Olofsson", "city": "Hammarö", "text": "Fick hjälp med hela trädgården inför hösten. Riktigt nöjd!", "rating": 5, "service": "Trädgård"},
            {"name": "Evert Lindqvist", "city": "Grums", "text": "Snickarna fixade nya fönsterbänkar. Prydligt och snabbt.", "rating": 5, "service": "Snickeri"},
        ],
    },
    "kristianstad": {
        "story": [
            "Johan Nilsson jobbade inom servicebranschen i Kristianstad i över 20 år. Han kände alla hantverkare i stan — och visste vilka som var bäst.",
            "När han startade Seniorbolaget 2020 hade han en färdig lista på folk att ringa. Inom tre månader var teamet komplett.",
            "Johan tror på Skånes tradition av ordning och reda. Hans kunder vet alltid exakt vad de får."
        ],
        "quote": "Skåne förtjänar bästa service — och det är precis vad vi levererar.",
        "since_year": 2020,
        "customers": 245,
        "areas": ["Kristianstad", "Åhus", "Degeberga", "Tollarp"],
        "testimonials": [
            {"name": "Eivor Svensson", "city": "Kristianstad", "text": "Johan är guld värd! Alltid pålitlig och noggrann med städningen.", "rating": 5, "service": "Hemstädning"},
            {"name": "Bengt Persson", "city": "Åhus", "text": "Målningen av sommarstugan blev fantastisk. Stort tack!", "rating": 5, "service": "Målning"},
            {"name": "Greta Andersson", "city": "Degeberga", "text": "Trädgårdstjänsten är ovärderlig. De sköter allt åt mig.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "kungalv": {
        "story": [
            "Mikael Ström flyttade till Kungälv för 30 år sedan och blev kvar. Staden vid älven blev hans hem.",
            "Efter en lång karriär inom byggbranschen startade han Seniorbolaget Kungälv 2021. Han ville använda sitt nätverk för något meningsfullt.",
            "Mikael känner sina kunder som grannar — för det är precis vad de ofta är."
        ],
        "quote": "Kungälv är en liten stad med stora hjärtan — vi passar perfekt in.",
        "since_year": 2021,
        "customers": 165,
        "areas": ["Kungälv", "Ytterby", "Kärna", "Marstrand"],
        "testimonials": [
            {"name": "Vera Lindgren", "city": "Kungälv", "text": "Mikael och hans team är fantastiska. Städningen är alltid fläckfri.", "rating": 5, "service": "Hemstädning"},
            {"name": "Arne Pettersson", "city": "Ytterby", "text": "Snickeriarbetet i källaren blev kanonbra. Rekommenderas!", "rating": 5, "service": "Snickeri"},
            {"name": "Dagny Olsson", "city": "Marstrand", "text": "Fick hjälp med trädgården efter vintern. Toppenjobb!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "kungsbacka": {
        "story": [
            "Lena Andreasson har bott i Kungsbacka sedan hon var liten. Efter 25 år inom fastighetsbranschen kände hon det var dags för något nytt.",
            "Sedan 2019 driver hon Seniorbolaget Kungsbacka med fokus på personlig service. Varje kund är unik, säger hon — och behandlas därefter.",
            "Lena är stolt över sitt team av lokala seniorer som delar hennes kärlek till trakten."
        ],
        "quote": "Vi behandlar varje hem som vårt eget — det är vår garanti.",
        "since_year": 2019,
        "customers": 290,
        "areas": ["Kungsbacka", "Onsala", "Åsa", "Särö"],
        "testimonials": [
            {"name": "Sonja Eriksson", "city": "Kungsbacka", "text": "Lena och teamet är underbara! Har anlitat dem i tre år nu.", "rating": 5, "service": "Hemstädning"},
            {"name": "Torsten Lundberg", "city": "Onsala", "text": "Målningen av fasaden blev fantastisk. Proffsigt arbete!", "rating": 5, "service": "Målning"},
            {"name": "Ragnhild Svensson", "city": "Särö", "text": "Trädgårdshjälpen är ovärderlig nu när jag inte orkar själv längre.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "laholm-bastad": {
        "story": [
            "Ola Persson drev hotell på Bjärehalvön i 20 år. Han vet allt om service och att möta höga förväntningar.",
            "När han startade Seniorbolaget i Laholm och Båstad 2020 tog han med sig den inställningen. Kunderna märker skillnaden.",
            "Ola säger att Bjäre-borna är vana vid kvalitet — och att han aldrig skulle leverera något annat."
        ],
        "quote": "Här på Bjäre är vi vana vid höga krav — och vi uppfyller dem.",
        "since_year": 2020,
        "customers": 185,
        "areas": ["Laholm", "Båstad", "Mellbystrand", "Skummeslövsstrand"],
        "testimonials": [
            {"name": "Maj Karlsson", "city": "Laholm", "text": "Ola är fantastisk! Städningen är alltid perfekt utförd.", "rating": 5, "service": "Hemstädning"},
            {"name": "Sture Andersson", "city": "Båstad", "text": "Trädgårdsarbetet inför säsongen blev kanon. Tack!", "rating": 5, "service": "Trädgård"},
            {"name": "Elsie Johansson", "city": "Mellbystrand", "text": "Snickarna byggde en ny altan åt oss. Helt perfekt!", "rating": 5, "service": "Snickeri"},
        ],
    },
    "landskrona": {
        "story": [
            "Kent Johansson jobbade på varvet i Landskrona tills det lades ner. Han ville inte flytta — han ville hitta något nytt i sin hemstad.",
            "Sedan 2021 driver han Seniorbolaget Landskrona med samma arbetsmoral som på varvet: gör jobbet ordentligt, varje gång.",
            "Kent säger att Landskrona förtjänar bättre — och han gör sitt bästa för att leverera det."
        ],
        "quote": "Landskrona är vår stad — vi tar hand om den och dess invånare.",
        "since_year": 2021,
        "customers": 175,
        "areas": ["Landskrona", "Häljarp", "Asmundtorp", "Ven"],
        "testimonials": [
            {"name": "Harriet Lindström", "city": "Landskrona", "text": "Kent och hans team gör ett strålande jobb med min städning.", "rating": 5, "service": "Hemstädning"},
            {"name": "Ragnar Nilsson", "city": "Häljarp", "text": "Målningen av vardagsrummet blev perfekt. Nöjd!", "rating": 5, "service": "Målning"},
            {"name": "Alice Berggren", "city": "Asmundtorp", "text": "Fantastiskt trädgårdsarbete! Rekommenderar starkt.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "lerum-partille": {
        "story": [
            "Stefan Håkansson pendlade till Göteborg i 30 år. När han gick i pension ville han stanna hemma — och göra nytta lokalt.",
            "Sedan 2019 driver han Seniorbolaget i Lerum och Partille. Hans team av lokala seniorer känner området utan och innan.",
            "Stefan tror på grannskap och sammanhållning. Varje uppdrag är en chans att bygga förtroende."
        ],
        "quote": "Grannskap handlar om att hjälpa varandra — det är vår filosofi.",
        "since_year": 2019,
        "customers": 265,
        "areas": ["Lerum", "Partille", "Sävedalen", "Gråbo"],
        "testimonials": [
            {"name": "Elna Gustafsson", "city": "Lerum", "text": "Stefan är en klippa! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Hugo Persson", "city": "Partille", "text": "Snickarna fixade nya garderobsdörrar. Proffsigt gjort!", "rating": 5, "service": "Snickeri"},
            {"name": "Barbro Lindberg", "city": "Sävedalen", "text": "Trädgården ser fantastisk ut tack vare deras hjälp.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "molndal-harryda": {
        "story": [
            "Cecilia Fransson jobbade inom vård och omsorg i 20 år. Hon såg hur äldre ofta fick nöja sig med halvmesyrer.",
            "När hon startade Seniorbolaget i Mölndal och Härryda 2020 var målet tydligt: leverera det hon själv skulle vilja ha.",
            "Cecilias team kombinerar professionalism med genuin värme. Det är ingen slump att de har så många återkommande kunder."
        ],
        "quote": "Varje kund är unik — och vi anpassar oss efter deras behov.",
        "since_year": 2020,
        "customers": 235,
        "areas": ["Mölndal", "Härryda", "Kållered", "Landvetter"],
        "testimonials": [
            {"name": "Gerd Holmberg", "city": "Mölndal", "text": "Cecilia och hennes team är fantastiska! Så trevliga och duktiga.", "rating": 5, "service": "Hemstädning"},
            {"name": "Tage Sjöberg", "city": "Härryda", "text": "Målningen av huset blev superbra. Rekommenderas varmt.", "rating": 5, "service": "Målning"},
            {"name": "Irma Löfgren", "city": "Kållered", "text": "Pålitlig trädgårdshjälp varje månad. Helt perfekt!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "nassjo": {
        "story": [
            "Christer Söderberg har bott i Nässjö hela sitt liv. Han känner staden och dess folk bättre än de flesta.",
            "Efter 30 år som hantverkare startade han Seniorbolaget 2021. Han ville ge småstaden samma kvalitet som de stora.",
            "Christer säger att i Nässjö ringer folk inte för att klaga — de ringer för att tacka. Det är det bästa kvittot."
        ],
        "quote": "I Nässjö känner vi varandra — och det syns i vårt arbete.",
        "since_year": 2021,
        "customers": 125,
        "areas": ["Nässjö", "Bodafors", "Malmbäck", "Forserum"],
        "testimonials": [
            {"name": "Hilma Martinsson", "city": "Nässjö", "text": "Christer och teamet är underbara! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Valter Lindgren", "city": "Bodafors", "text": "Snickeriarbetet i garaget blev kanonbra. Tack!", "rating": 5, "service": "Snickeri"},
            {"name": "Rut Bergström", "city": "Malmbäck", "text": "Trädgården har aldrig sett bättre ut. Stort tack!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "orebro": {
        "story": [
            "Martin Engström ledde säljteam i 25 år innan han bytte bana. Han ville bygga något eget — och hjälpa människor på riktigt.",
            "Sedan 2019 är han en av Örebroregionens mest erfarna franchisetagare. Hans team är kända för sin professionalism.",
            "Martin säger att hemligheten är enkel: anställ bra människor, lita på dem, och leverera det du lovar."
        ],
        "quote": "Örebro förtjänar det bästa — och vi ger aldrig något annat.",
        "since_year": 2019,
        "customers": 360,
        "areas": ["Örebro", "Kumla", "Hallsberg", "Askersund"],
        "testimonials": [
            {"name": "Gunvor Eklund", "city": "Örebro", "text": "Martin är guld värd! Städningen är alltid perfekt utförd.", "rating": 5, "service": "Hemstädning"},
            {"name": "Helge Björk", "city": "Kumla", "text": "Målarna gjorde ett fantastiskt jobb med fasaden.", "rating": 5, "service": "Målning"},
            {"name": "Tyra Lindholm", "city": "Hallsberg", "text": "Trädgårdshjälpen är ovärderlig. Tack för allt!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "skovde": {
        "story": [
            "Niklas Wallin är uppvuxen i Skövde och har aldrig velat bo någon annanstans. Efter en karriär inom industrin ville han göra något lokalt.",
            "Sedan 2020 driver han Seniorbolaget Skövde med fokus på Skaraborgsborna. Hans team av lokala seniorer delar hans engagemang.",
            "Niklas säger att han älskar att se hur nöjda kunder blir — det är därför han går upp på morgonen."
        ],
        "quote": "Skaraborg är mitt hem — och jag tar hand om det.",
        "since_year": 2020,
        "customers": 215,
        "areas": ["Skövde", "Skara", "Tibro", "Tidaholm"],
        "testimonials": [
            {"name": "Asta Lundqvist", "city": "Skövde", "text": "Niklas och hans team är fantastiska. Alltid pålitliga!", "rating": 5, "service": "Hemstädning"},
            {"name": "Folke Johansson", "city": "Skara", "text": "Snickarna byggde nya kökshyllor. Proffsigt och snabbt.", "rating": 5, "service": "Snickeri"},
            {"name": "Ingegerd Nilsson", "city": "Tibro", "text": "Trädgårdsarbetet blev precis som jag ville. Tack!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "stenungsund": {
        "story": [
            "Per-Olof Strand jobbade på raffinaderiet i 35 år. När han gick i pension ville han inte sluta arbeta — bara byta fokus.",
            "Sedan 2021 driver han Seniorbolaget Stenungsund. Hans team täcker hela kusten från Tjörn till Orust.",
            "Per-Olof säger att kustborna är speciella — de förväntar sig kvalitet och ärlighet. Det är precis vad han levererar."
        ],
        "quote": "Kusten är vårt hem — vi tar hand om den och dess folk.",
        "since_year": 2021,
        "customers": 145,
        "areas": ["Stenungsund", "Stora Höga", "Tjörn", "Orust"],
        "testimonials": [
            {"name": "Gudrun Hellström", "city": "Stenungsund", "text": "Per-Olof är underbar! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Arvid Magnusson", "city": "Tjörn", "text": "Målningen av sommarstället blev fantastisk. Stort tack!", "rating": 5, "service": "Målning"},
            {"name": "Märit Axelsson", "city": "Orust", "text": "Trädgårdshjälpen är ovärderlig för oss pensionärer.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "sundsvall": {
        "story": [
            "Torbjörn Nordin är en av Seniorbolagets veteraner i Norrland. Han startade 2019 när de flesta trodde konceptet bara fungerade i söder.",
            "Idag leder han ett team som klarar allt från -30 till +30 grader. Norrlandsborna är tåliga — och det är hans team också.",
            "Torbjörn säger att det bästa med norrlänningar är att de säger som det är. Om de är nöjda så vet man det."
        ],
        "quote": "I Norrland hjälper vi varandra — det sitter i ryggmärgen.",
        "since_year": 2019,
        "customers": 285,
        "areas": ["Sundsvall", "Timrå", "Ånge", "Härnösand"],
        "testimonials": [
            {"name": "Greta Norberg", "city": "Sundsvall", "text": "Torbjörn och teamet är fantastiska! Alltid pålitliga.", "rating": 5, "service": "Hemstädning"},
            {"name": "Sixten Lindström", "city": "Timrå", "text": "Snickarna fixade nya fönster. Proffsigt arbete!", "rating": 5, "service": "Snickeri"},
            {"name": "Viola Hedlund", "city": "Ånge", "text": "Trädgårdshjälpen är guld värd. Tack för allt!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "torsby": {
        "story": [
            "Göran Eriksson är finnskogare i själ och hjärta. Han har bott i Torsby hela sitt liv och kan varje stig i skogen.",
            "När han startade Seniorbolaget 2021 var det för att bygden behövde det. Inte alla har familj som kan hjälpa till.",
            "Göran och hans team kör gärna den extra milen — bokstavligen. I Finnskogen är avstånden stora men hjärtat större."
        ],
        "quote": "I Finnskogen tar vi hand om varandra — det är vår tradition.",
        "since_year": 2021,
        "customers": 85,
        "areas": ["Torsby", "Sunne", "Likenäs", "Sysslebäck"],
        "testimonials": [
            {"name": "Elsy Karlsson", "city": "Torsby", "text": "Göran är en klippa! Städningen är alltid perfekt utförd.", "rating": 5, "service": "Hemstädning"},
            {"name": "Nils Olsson", "city": "Sunne", "text": "Målningen av stugan blev kanonbra. Stort tack!", "rating": 5, "service": "Målning"},
            {"name": "Sigrid Berglund", "city": "Likenäs", "text": "Snöskottning och trädgård — de fixar allt!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "trelleborg": {
        "story": [
            "Magnus Jönsson jobbade med fastighetsförvaltning i Trelleborg i 20 år. Han kände varje hus i stan — och visste vilka som behövde hjälp.",
            "2020 startade han Seniorbolaget Trelleborg för att fylla ett gap. Staden förtjänade bättre alternativ.",
            "Magnus säger att Trelleborgarna är rättframma — om de inte är nöjda så hör man det. Det har han aldrig fått höra."
        ],
        "quote": "Trelleborg är Sveriges pärla i söder — vi tar hand om den.",
        "since_year": 2020,
        "customers": 195,
        "areas": ["Trelleborg", "Anderslöv", "Smygehamn", "Klagstorp"],
        "testimonials": [
            {"name": "Berta Persson", "city": "Trelleborg", "text": "Magnus och teamet är underbara! Alltid trevliga och duktiga.", "rating": 5, "service": "Hemstädning"},
            {"name": "Osvald Nilsson", "city": "Anderslöv", "text": "Målningen av huset blev perfekt. Rekommenderas!", "rating": 5, "service": "Målning"},
            {"name": "Gullvi Svensson", "city": "Smygehamn", "text": "Trädgårdsarbetet blev precis som jag ville. Tack!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "trollhattan": {
        "story": [
            "Lars Björk jobbade på Saab i 30 år. När fabriken stängde var det en kris — men också en möjlighet att börja om.",
            "Sedan 2019 driver han Seniorbolaget Trollhättan med samma precision som på produktionslinjen. Fast med mer hjärta.",
            "Lars säger att Saab-andan lever vidare i hans team: kvalitet, noggrannhet, och stolthet över det man gör."
        ],
        "quote": "Saab-andan lever — vi levererar kvalitet varje gång.",
        "since_year": 2019,
        "customers": 275,
        "areas": ["Trollhättan", "Vänersborg", "Lilla Edet", "Älvängen"],
        "testimonials": [
            {"name": "Doris Lundberg", "city": "Trollhättan", "text": "Lars är fantastisk! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Ragnar Svensson", "city": "Vänersborg", "text": "Snickarna byggde en ny altan. Proffsigt och snabbt!", "rating": 5, "service": "Snickeri"},
            {"name": "Svea Pettersson", "city": "Lilla Edet", "text": "Trädgården ser fantastisk ut tack vare deras hjälp.", "rating": 5, "service": "Trädgård"},
        ],
    },
    "ulricehamn": {
        "story": [
            "Bengt Andersson är ulricehamnare sedan födseln. Han känner varje gata, varje granne, varje historia.",
            "Efter 35 år som egenföretagare startade han Seniorbolaget 2021. Han ville använda sitt nätverk för att hjälpa de som behövde det.",
            "Bengt säger att i Ulricehamn handlar det om tillit. Folk anlitar någon de känner — och nu känner de honom."
        ],
        "quote": "Ulricehamn är litet men starkt — precis som vårt team.",
        "since_year": 2021,
        "customers": 105,
        "areas": ["Ulricehamn", "Dalum", "Gällstad", "Vegby"],
        "testimonials": [
            {"name": "Linnéa Holm", "city": "Ulricehamn", "text": "Bengt och teamet är underbara! Alltid pålitliga och trevliga.", "rating": 5, "service": "Hemstädning"},
            {"name": "Erik Johansson", "city": "Dalum", "text": "Målningen av köket blev perfekt. Stort tack!", "rating": 5, "service": "Målning"},
            {"name": "Stina Lindgren", "city": "Gällstad", "text": "Trädgårdshjälpen är ovärderlig. Rekommenderar varmt!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "varberg": {
        "story": [
            "Kristoffer Lind flyttade till Varberg för surfen och stannade för människorna. Efter 20 år i IT-branschen ville han göra något annat.",
            "Sedan 2019 driver han Seniorbolaget Varberg med passion för kuststaden. Hans team av lokala seniorer delar hans engagemang.",
            "Kristoffer säger att Varberg är mer än en badort — det är ett hem. Och hem tar man hand om ordentligt."
        ],
        "quote": "Varberg är mer än en badort — det är vårt hem.",
        "since_year": 2019,
        "customers": 255,
        "areas": ["Varberg", "Falkenberg", "Tvååker", "Träslövsläge"],
        "testimonials": [
            {"name": "Agda Bergman", "city": "Varberg", "text": "Kristoffer är guld värd! Städningen är alltid perfekt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Holger Nilsson", "city": "Tvååker", "text": "Snickarna fixade nya altandörrar. Proffsigt gjort!", "rating": 5, "service": "Snickeri"},
            {"name": "Frideborg Larsson", "city": "Träslövsläge", "text": "Trädgården har aldrig sett bättre ut. Tack!", "rating": 5, "service": "Trädgård"},
        ],
    },
    "amal": {
        "story": [
            "Roger Samuelsson är dalsländning i själ och hjärta. Han har bott i Åmål hela sitt liv och känner varje hörn av Dalsland.",
            "Efter 30 år som hantverkare startade han Seniorbolaget 2021. Han ville ge bygden tillgång till pålitlig hemservice.",
            "Roger säger att i Dalsland hjälper man varandra — det är tradition. Seniorbolaget passar perfekt in i den traditionen."
        ],
        "quote": "I Dalsland hjälper vi varandra — det är så det alltid varit.",
        "since_year": 2021,
        "customers": 90,
        "areas": ["Åmål", "Bengtsfors", "Ed", "Mellerud"],
        "testimonials": [
            {"name": "Alfhild Gustafsson", "city": "Åmål", "text": "Roger är underbar! Städningen är alltid perfekt utförd.", "rating": 5, "service": "Hemstädning"},
            {"name": "Sigvard Lindberg", "city": "Bengtsfors", "text": "Målningen av huset blev fantastisk. Stort tack!", "rating": 5, "service": "Målning"},
            {"name": "Gerda Olsson", "city": "Ed", "text": "Trädgårdshjälpen är ovärderlig för oss pensionärer här.", "rating": 5, "service": "Trädgård"},
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


def get_first_name(name):
    """Get first name from full name."""
    return name.split()[0] if name else "oss"


def generate_photo_placeholder():
    """Generate the SVG photo placeholder."""
    return '''<div style="width:300px;height:300px;border-radius:50%;background:linear-gradient(135deg,#FFF4F2,#FFE4E1);border:3px dashed #C91C22;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;flex-shrink:0;">
      <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="1.2" opacity="0.5">
        <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/>
        <circle cx="12" cy="13" r="4"/>
      </svg>
      <span style="font-family:Inter,sans-serif;font-size:0.75rem;color:#C91C22;opacity:0.7;font-weight:500;">Foto uppdateras snart</span>
    </div>'''


def generate_area_chips(areas):
    """Generate HTML chips for coverage areas."""
    chips = []
    for area in areas:
        chips.append(f'<span style="background:#fff;color:#374151;border-radius:50px;padding:6px 14px;font-size:0.875rem;font-family:Inter,sans-serif;border:1px solid #e5e7eb;">{area}</span>')
    return "\n            ".join(chips)


def generate_star_rating():
    """Generate 5-star rating SVG."""
    return '''<div style="display:flex;gap:2px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="#C91C22"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>'''


def generate_franchisee_page(file_key, city_name, wp_slug, name, phone, email):
    """Generate the complete franchisee-focused pattern PHP file."""
    slug = f"seniorbolaget/stad-{wp_slug}-page"
    tel = phone_tel(phone) if phone else "0101751900"
    contact_name = name or "Kontaktperson"
    contact_phone = phone or "010-175 19 00"
    contact_email = email or "info@seniorbolaget.se"
    first_name = get_first_name(contact_name)
    
    # Get city-specific data
    city_data = CITY_DATA.get(file_key, {
        "story": [
            f"Vår franchisetagare i {city_name} driver verksamheten med passion och engagemang.",
            "Med lokalkännedom och erfarenhet levererar teamet alltid kvalitet.",
            "Varje kund behandlas med respekt och omtanke — det är grunden för allt vi gör."
        ],
        "quote": "Vi tar hand om våra kunder som om de vore familj.",
        "since_year": 2020,
        "customers": 150,
        "areas": [city_name],
        "testimonials": [
            {"name": "Kund", "city": city_name, "text": "Fantastisk service! Rekommenderar varmt.", "rating": 5, "service": "Hemstädning"},
            {"name": "Kund", "city": city_name, "text": "Proffsigt och pålitligt arbete.", "rating": 5, "service": "Trädgård"},
            {"name": "Kund", "city": city_name, "text": "Nöjd kund sedan första dagen.", "rating": 5, "service": "Målning"},
        ],
    })
    
    photo_html = generate_photo_placeholder()
    area_chips = generate_area_chips(city_data["areas"])
    star_rating = generate_star_rating()
    
    # Build story paragraphs
    story_html = "\n".join([f"<p style=\"font-family:Inter,sans-serif;font-size:1rem;line-height:1.8;color:#374151;margin:0 0 1rem;\">{p}</p>" for p in city_data["story"]])
    
    # Build testimonials cards
    testimonials_cards = ""
    for t in city_data["testimonials"]:
        testimonials_cards += f'''
        <div style="background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
          {star_rating}
          <p style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#374151;line-height:1.7;margin:16px 0;font-style:italic;">"{t["text"]}"</p>
          <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
            <p style="font-family:Rubik,sans-serif;font-weight:600;font-size:0.875rem;color:#1F2937;margin:0;">{t["name"]}, {t["city"]}</p>
            <span style="background:#FFF4F2;color:#C91C22;font-size:0.75rem;font-weight:600;padding:4px 10px;border-radius:50px;font-family:Inter,sans-serif;">{t["service"]}</span>
          </div>
        </div>'''

    return f'''<?php
/**
 * Title: {city_name} - Stadssida
 * Slug: {slug}
 * Categories: seniorbolaget, services
 * Description: Franchisetagarfokuserad landningssida för {city_name}
 * Viewport Width: 1440
 */
?>

<!-- ========================================
     SEKTION 1: FRANCHISETAGARE-HERO
     ======================================== -->
<!-- wp:group {{"align":"full","style":{{"color":{{"background":"#FFF4F2"}},"spacing":{{"padding":{{"top":"60px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}},"margin":{{"top":"0"}}}}}},"layout":{{"type":"constrained","contentSize":"1100px"}}}} -->
<div class="wp-block-group alignfull" style="background-color:#FFF4F2;margin-top:0;padding-top:60px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

<!-- wp:html -->
<div class="franchisee-hero" style="display:flex;gap:48px;align-items:center;flex-wrap:wrap;">
  
  <!-- FOTO (placeholder eller riktig bild) -->
  <div class="franchisee-photo" style="flex:0 0 auto;">
    {photo_html}
  </div>

  <!-- TEXT-INNEHÅLL -->
  <div style="flex:1;min-width:280px;">
    
    <!-- Namn -->
    <h1 style="font-family:Rubik,sans-serif;font-size:clamp(2rem,5vw,2.75rem);font-weight:700;color:#1F2937;margin:0 0 8px;line-height:1.2;">
      {contact_name}
    </h1>
    
    <!-- Roll + stad + år -->
    <p style="font-family:Inter,sans-serif;font-size:1rem;color:#6B7280;margin:0 0 20px;">
      Franchisetagare · {city_name} · Sedan {city_data["since_year"]}
    </p>
    
    <!-- Personlig välkomsthälsning -->
    <p style="font-family:Inter,sans-serif;font-size:1.125rem;color:#374151;line-height:1.7;margin:0 0 28px;max-width:520px;">
      Välkommen! Jag är {first_name} och driver Seniorbolaget i {city_name}. Vi hjälper dig med allt från städning till trädgård — alltid med omtanke och kvalitet.
    </p>
    
    <!-- TELEFON — extra stort -->
    <a href="tel:{tel}" style="display:inline-flex;align-items:center;gap:10px;font-family:Rubik,sans-serif;font-size:1.5rem;font-weight:700;color:#C91C22;text-decoration:none;margin-bottom:12px;">
      📞 {contact_phone}
    </a>
    
    <!-- Sekundär: Mail-knapp -->
    <div style="margin-bottom:24px;">
      <a href="mailto:{contact_email}" style="display:inline-flex;align-items:center;gap:8px;font-family:Inter,sans-serif;font-size:0.9375rem;color:#6B7280;text-decoration:none;">
        ✉ Skicka mail till {first_name}
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
    
  </div>
</div>

<style>
@media(max-width:768px){{
  .franchisee-hero {{ flex-direction:column!important;text-align:center; }}
  .franchisee-photo {{ margin:0 auto; }}
  .franchisee-hero div:last-child {{ align-items:center; }}
}}
</style>
<!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- ========================================
     SEKTION 2: PERSONLIG BERÄTTELSE
     ======================================== -->
<!-- wp:group {{"align":"full","style":{{"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}}}}},"layout":{{"type":"constrained","contentSize":"720px"}}}} -->
<div class="wp-block-group alignfull" style="padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {{"level":2,"style":{{"typography":{{"fontSize":"clamp(1.5rem,4vw,2rem)","fontWeight":"700"}},"color":{{"text":"#1F2937"}},"spacing":{{"margin":{{"bottom":"2rem"}}}}}}}} -->
  <h2 class="wp-block-heading" style="color:#1F2937;font-size:clamp(1.5rem,4vw,2rem);font-weight:700;margin-bottom:2rem">Varför {first_name} valde Seniorbolaget</h2>
  <!-- /wp:heading -->

  <!-- wp:html -->
  <div style="margin-bottom:2rem;">
    {story_html}
  </div>
  
  <!-- Citat -->
  <blockquote style="border-left:4px solid #C91C22;padding:16px 0 16px 24px;margin:0;background:#FAFAF8;border-radius:0 12px 12px 0;">
    <p style="font-family:Inter,sans-serif;font-size:1.125rem;font-style:italic;color:#374151;line-height:1.7;margin:0;">
      "{city_data["quote"]}"
    </p>
    <footer style="font-family:Rubik,sans-serif;font-size:0.875rem;color:#6B7280;margin-top:12px;">
      — {contact_name}, {city_name}
    </footer>
  </blockquote>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- ========================================
     SEKTION 3: SERVICEOMRÅDE + TILLGÄNGLIGHET
     ======================================== -->
<!-- wp:group {{"align":"full","style":{{"color":{{"background":"#FAFAF8"}},"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}}}}},"layout":{{"type":"constrained","contentSize":"1000px"}}}} -->
<div class="wp-block-group alignfull" style="background-color:#FAFAF8;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {{"textAlign":"center","level":2,"style":{{"typography":{{"fontSize":"clamp(1.5rem,4vw,2rem)","fontWeight":"700"}},"color":{{"text":"#1F2937"}},"spacing":{{"margin":{{"bottom":"3rem"}}}}}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.5rem,4vw,2rem);font-weight:700;margin-bottom:3rem">Var {first_name} finns</h2>
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
        {area_chips}
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
          <span style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#374151;"><strong style="color:#C91C22;">{city_data["customers"]}+</strong> nöjda kunder</span>
        </div>
        
        <div style="display:flex;align-items:center;gap:12px;">
          <div style="width:40px;height:40px;background:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C91C22" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </div>
          <span style="font-family:Inter,sans-serif;font-size:0.9375rem;color:#374151;">Aktiv sedan <strong style="color:#C91C22;">{city_data["since_year"]}</strong></span>
        </div>
      </div>
    </div>
    
  </div>
  
  <style>
  @media(max-width:700px){{
    .service-area-grid {{ grid-template-columns:1fr!important; }}
  }}
  </style>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- ========================================
     SEKTION 4: KUNDRECENSIONER
     ======================================== -->
<!-- wp:group {{"align":"full","style":{{"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}}}}},"layout":{{"type":"constrained","contentSize":"1100px"}}}} -->
<div class="wp-block-group alignfull" style="padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {{"textAlign":"center","level":2,"style":{{"typography":{{"fontSize":"clamp(1.5rem,4vw,2rem)","fontWeight":"700"}},"color":{{"text":"#1F2937"}},"spacing":{{"margin":{{"bottom":"0.75rem"}}}}}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.5rem,4vw,2rem);font-weight:700;margin-bottom:0.75rem">Vad {first_name}s kunder säger</h2>
  <!-- /wp:heading -->
  
  <!-- wp:paragraph {{"align":"center","style":{{"color":{{"text":"#6B7280"}},"typography":{{"fontSize":"1rem"}},"spacing":{{"margin":{{"bottom":"3rem"}}}}}}}} -->
  <p class="has-text-align-center" style="color:#6B7280;font-size:1rem;margin-bottom:3rem">Äkta recensioner från nöjda kunder i {city_name}-området.</p>
  <!-- /wp:paragraph -->

  <!-- wp:html -->
  <div class="testimonials-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
    {testimonials_cards}
  </div>
  
  <style>
  @media(max-width:900px){{
    .testimonials-grid {{ grid-template-columns:1fr!important; }}
  }}
  </style>
  <!-- /wp:html -->

</div>
<!-- /wp:group -->


<!-- ========================================
     SEKTION 5: TJÄNSTER (sekundärt)
     ======================================== -->
<!-- wp:group {{"align":"full","style":{{"color":{{"background":"#FAFAF8"}},"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}}}}},"layout":{{"type":"constrained","contentSize":"800px"}}}} -->
<div class="wp-block-group alignfull" style="background-color:#FAFAF8;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {{"textAlign":"center","level":2,"style":{{"typography":{{"fontSize":"clamp(1.5rem,4vw,2rem)","fontWeight":"700"}},"color":{{"text":"#1F2937"}},"spacing":{{"margin":{{"bottom":"2.5rem"}}}}}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#1F2937;font-size:clamp(1.5rem,4vw,2rem);font-weight:700;margin-bottom:2.5rem">Vad {first_name} hjälper dig med</h2>
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
<!-- wp:group {{"align":"full","style":{{"color":{{"background":"#C91C22"}},"spacing":{{"padding":{{"top":"80px","bottom":"80px","left":"clamp(24px, 5vw, 80px)","right":"clamp(24px, 5vw, 80px)"}}}}}},"layout":{{"type":"constrained","contentSize":"600px"}}}} -->
<div class="wp-block-group alignfull" style="background-color:#C91C22;padding-top:80px;padding-right:clamp(24px, 5vw, 80px);padding-bottom:80px;padding-left:clamp(24px, 5vw, 80px)">

  <!-- wp:heading {{"textAlign":"center","level":2,"style":{{"typography":{{"fontSize":"clamp(1.5rem,4vw,2rem)","fontWeight":"700"}},"color":{{"text":"#ffffff"}},"spacing":{{"margin":{{"bottom":"2rem"}}}}}}}} -->
  <h2 class="wp-block-heading has-text-align-center" style="color:#fff;font-size:clamp(1.5rem,4vw,2rem);font-weight:700;margin-bottom:2rem">Kontakta {first_name} direkt</h2>
  <!-- /wp:heading -->

  <!-- wp:html -->
  <div style="text-align:center;">
    
    <p style="font-family:Rubik,sans-serif;font-size:1.25rem;font-weight:600;color:#fff;margin:0 0 8px;">{contact_name}</p>
    
    <a href="tel:{tel}" style="display:block;font-family:Rubik,sans-serif;font-size:1.75rem;font-weight:700;color:#fff;text-decoration:none;margin-bottom:8px;">
      📞 {contact_phone}
    </a>
    
    <p style="font-family:Inter,sans-serif;font-size:1rem;color:rgba(255,255,255,0.85);margin:0 0 32px;">
      {contact_email}
    </p>
    
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
      <a href="tel:{tel}" style="display:inline-flex;align-items:center;gap:8px;background:#fff;color:#C91C22;border-radius:50px;padding:14px 32px;font-family:Rubik,sans-serif;font-weight:600;font-size:1rem;text-decoration:none;">
        Ring nu
      </a>
      <a href="mailto:{contact_email}" style="display:inline-flex;align-items:center;gap:8px;background:transparent;color:#fff;border:2px solid #fff;border-radius:50px;padding:14px 32px;font-family:Rubik,sans-serif;font-weight:600;font-size:1rem;text-decoration:none;">
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
  <a href="tel:{tel}">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
    </svg>
    Ring {first_name}
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

        content = generate_franchisee_page(file_key, city_name, wp_slug, name, phone, email)
        out_file = PATTERNS_DIR / f"stad-{wp_slug}-page.php"
        out_file.write_text(content, encoding="utf-8")
        generated.append((city_name, wp_slug, name, phone))
        print(f"✅ {city_name} ({wp_slug}) — {name or 'ingen kontakt'}")

    print(f"\n✅ Genererade {len(generated)} stadssidor med franchisetagarfokus")
    return generated


if __name__ == "__main__":
    main()
