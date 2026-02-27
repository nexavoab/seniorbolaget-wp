#!/bin/bash
# Evaluate all 26 city pages with Gemini

cd /home/exedev/seniorbolaget-wp/comparison

declare -A CITIES=(
    ["amal"]="Åmål"
    ["boras"]="Borås"
    ["eskilstuna"]="Eskilstuna"
    ["falkenberg"]="Falkenberg"
    ["goteborg"]="Göteborg"
    ["halmstad"]="Halmstad"
    ["helsingborg"]="Helsingborg"
    ["jonkoping"]="Jönköping"
    ["karlstad"]="Karlstad"
    ["kristianstad"]="Kristianstad"
    ["kungalv"]="Kungälv"
    ["kungsbacka"]="Kungsbacka"
    ["laholm"]="Laholm/Båstad"
    ["landskrona"]="Landskrona"
    ["lerum"]="Lerum/Partille"
    ["molndal"]="Mölndal/Härryda"
    ["nassjo"]="Nässjö"
    ["orebro"]="Örebro"
    ["skovde"]="Skövde"
    ["stenungsund"]="Stenungsund"
    ["sundsvall"]="Sundsvall"
    ["torsby"]="Torsby"
    ["trelleborg"]="Trelleborg"
    ["trollhattan"]="Trollhättan"
    ["ulricehamn"]="Ulricehamn"
    ["varberg"]="Varberg"
)

# Results file
echo "" > scores.txt

for slug in "${!CITIES[@]}"; do
    city="${CITIES[$slug]}"
    echo "🔍 Evaluating $city ($slug)..."
    
    PROMPT="ANALYSERA ENBART BILDEN. Inga verktyg.

@${slug}_staging_small.jpg

SEO-sida för hemtjänster i ${city} (Seniorbolaget). Målgrupp: 65+.

Utvärdera (1-10):
1. VISUELL HIERARKI
2. FÖRTROENDE
3. LOKAL RELEVANS
4. KONVERTERING
5. MOBILKÄNSLA

TOTALBETYG: X/10"

    OUTPUT=$(timeout 120 gemini -m gemini-2.5-flash --yolo -p "$PROMPT" 2>&1)
    
    # Save full output
    echo "# Gemini Evaluation: $city" > "eval_${slug}_batch.md"
    echo "" >> "eval_${slug}_batch.md"
    echo "$OUTPUT" >> "eval_${slug}_batch.md"
    
    # Extract score
    SCORE=$(echo "$OUTPUT" | grep -oP 'TOTALBETYG[:\s]+\K[\d.]+(?=/10)' | tail -1)
    
    if [ -z "$SCORE" ]; then
        SCORE=$(echo "$OUTPUT" | grep -oP '[\d.]+(?=/10)' | tail -1)
    fi
    
    if [ -n "$SCORE" ]; then
        echo "$slug:$SCORE" >> scores.txt
        echo "   → $SCORE/10"
    else
        echo "$slug:ERROR" >> scores.txt
        echo "   → Failed to extract score"
    fi
done

echo ""
echo "📊 All evaluations complete!"
cat scores.txt
