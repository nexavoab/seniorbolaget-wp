#!/bin/bash
# Starta WordPress lokalt med seniorbolaget-tema och allt innehåll
# Kör: bash launch-wp.sh
set -e

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
THEME_DIR="$DIR/wp/seniorbolaget-theme"
WXR_FILE="$DIR/seniorbolaget.wordpress.xml"
BLUEPRINT="$DIR/.blueprint-generated.json"

echo "🚀 Startar Seniorbolaget WordPress..."
echo ""

# Kontrollera Node.js
if ! command -v node &>/dev/null; then
  echo "❌ Node.js saknas. Installera: https://nodejs.org"; exit 1
fi
NODE_VER=$(node -e "process.stdout.write(process.version.slice(1).split('.')[0])")
if [ "$NODE_VER" -lt 20 ]; then
  echo "❌ Node.js 20+ krävs (du har v$NODE_VER)"; exit 1
fi
echo "✅ Node $(node -v)"

# Generera blueprint med inbäddad WXR
python3 - <<PYEOF
import json

with open("$WXR_FILE", 'r', encoding='utf-8') as f:
    wxr_content = f.read()

blueprint = {
    "\$schema": "https://playground.wordpress.net/blueprint-schema.json",
    "landingPage": "/wp-admin/",
    "login": True,
    "preferredVersions": {"php": "8.2", "wp": "6.7"},
    "steps": [
        {
            "step": "importWxr",
            "file": {
                "resource": "literal",
                "name": "seniorbolaget.wordpress.xml",
                "contents": wxr_content
            }
        },
        {"step": "wp-cli", "command": "wp option update blogname Seniorbolaget"},
        {"step": "wp-cli", "command": "wp option update show_on_front page"},
        {"step": "wp-cli", "command": "wp rewrite structure /%postname%/ --hard"}
    ]
}

with open("$BLUEPRINT", 'w', encoding='utf-8') as f:
    json.dump(blueprint, f, ensure_ascii=False, indent=2)

print("✅ Blueprint genererad")
PYEOF

echo ""
echo "🌐 WordPress startar på http://localhost:9400"
echo "   Admin: http://localhost:9400/wp-admin/"
echo "   Inloggning: admin / password"
echo ""
echo "   Efter start — gå till:"
echo "   Inställningar → Läsning → Statisk sida → välj 'Hem'"
echo ""
echo "   Tryck Ctrl+C för att stoppa"
echo ""

# Kör wp-playground med tema-mount och blueprint
npx --yes @wp-playground/cli@latest server \
  --mount="$THEME_DIR:/wordpress/wp-content/themes/seniorbolaget-theme" \
  --blueprint="$BLUEPRINT" \
  --blueprint-may-read-adjacent-files \
  --port=9400
