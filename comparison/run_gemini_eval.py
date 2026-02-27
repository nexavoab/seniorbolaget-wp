#!/usr/bin/env python3
"""Run Gemini evaluation on all city page screenshots."""

import subprocess
import re
import json
from pathlib import Path

COMPARISON_DIR = Path(__file__).parent

CITIES = {
    "amal": "Åmål",
    "boras": "Borås",
    "eskilstuna": "Eskilstuna",
    "falkenberg": "Falkenberg",
    "goteborg": "Göteborg",
    "halmstad": "Halmstad",
    "helsingborg": "Helsingborg",
    "jonkoping": "Jönköping",
    "karlstad": "Karlstad",
    "kristianstad": "Kristianstad",
    "kungalv": "Kungälv",
    "kungsbacka": "Kungsbacka",
    "laholm": "Laholm/Båstad",
    "landskrona": "Landskrona",
    "lerum": "Lerum/Partille",
    "molndal": "Mölndal/Härryda",
    "nassjo": "Nässjö",
    "orebro": "Örebro",
    "skovde": "Skövde",
    "stenungsund": "Stenungsund",
    "sundsvall": "Sundsvall",
    "torsby": "Torsby",
    "trelleborg": "Trelleborg",
    "trollhattan": "Trollhättan",
    "ulricehamn": "Ulricehamn",
    "varberg": "Varberg",
}

def run_gemini_eval(slug: str, city_name: str) -> tuple[str, float | None]:
    """Run Gemini evaluation for a single city."""
    image_path = COMPARISON_DIR / f"{slug}_staging_small.jpg"
    output_path = COMPARISON_DIR / f"eval_{slug}_batch.md"
    
    if not image_path.exists():
        return f"Image not found: {image_path}", None
    
    prompt = f"""ANALYSERA ENBART BILDEN. Inga verktyg.

@{image_path}

SEO-sida för hemtjänster i {city_name} (Seniorbolaget). Målgrupp: 65+.

Utvärdera (1-10):
1. VISUELL HIERARKI
2. FÖRTROENDE
3. LOKAL RELEVANS
4. KONVERTERING
5. MOBILKÄNSLA

TOTALBETYG: X/10"""

    try:
        result = subprocess.run(
            ["gemini", "-m", "gemini-2.5-flash", "--yolo", "-p", prompt],
            capture_output=True,
            text=True,
            timeout=120,
            cwd=str(COMPARISON_DIR)
        )
        
        output = result.stdout + result.stderr
        
        # Save the full response
        with open(output_path, "w") as f:
            f.write(f"# Gemini Evaluation: {city_name}\n\n")
            f.write(output)
        
        # Extract score using regex
        score_match = re.search(r'TOTALBETYG[:\s]+(\d+(?:\.\d+)?)\s*/\s*10', output, re.IGNORECASE)
        if not score_match:
            # Try alternative patterns
            score_match = re.search(r'(\d+(?:\.\d+)?)\s*/\s*10', output)
        
        score = float(score_match.group(1)) if score_match else None
        
        return output, score
        
    except subprocess.TimeoutExpired:
        return "Timeout after 120s", None
    except Exception as e:
        return f"Error: {e}", None

def main():
    results = {"passed": 0, "failed": [], "scores": {}}
    report_lines = ["# Gemini 360° — Alla 26 stadssidor\n"]
    report_lines.append("| Stad | Betyg | Status |")
    report_lines.append("|------|-------|--------|")
    
    for slug, city_name in CITIES.items():
        print(f"🔍 Evaluating {city_name} ({slug})...")
        output, score = run_gemini_eval(slug, city_name)
        
        results["scores"][slug] = score
        
        if score is not None:
            status = "✅" if score >= 9.0 else "⚠️"
            if score >= 9.0:
                results["passed"] += 1
            else:
                results["failed"].append({"slug": slug, "city": city_name, "score": score})
            report_lines.append(f"| {city_name} | {score}/10 | {status} |")
            print(f"   → {score}/10 {status}")
        else:
            results["failed"].append({"slug": slug, "city": city_name, "score": None, "error": "No score extracted"})
            report_lines.append(f"| {city_name} | N/A | ❌ |")
            print(f"   → Failed to extract score")
    
    # Add summary
    scores = [s for s in results["scores"].values() if s is not None]
    report_lines.append("\n## Sammanfattning")
    report_lines.append(f"- **Godkända (≥9/10):** {results['passed']}/26")
    report_lines.append(f"- **Behöver fix (<9/10):** {len([f for f in results['failed'] if f.get('score') and f['score'] < 9])}")
    if scores:
        report_lines.append(f"- **Lägsta betyg:** {min(scores)}/10")
        report_lines.append(f"- **Högsta betyg:** {max(scores)}/10")
        report_lines.append(f"- **Genomsnitt:** {sum(scores)/len(scores):.1f}/10")
    
    if results["failed"]:
        report_lines.append("\n## Städer under 9/10")
        for f in results["failed"]:
            if f.get("score") and f["score"] < 9:
                report_lines.append(f"- **{f['city']}**: {f['score']}/10")
    
    # Write report
    report_path = COMPARISON_DIR / "batch_eval_report.md"
    with open(report_path, "w") as f:
        f.write("\n".join(report_lines))
    
    # Write JSON summary
    json_path = COMPARISON_DIR / "eval_summary.json"
    with open(json_path, "w") as f:
        json.dump(results, f, indent=2)
    
    print(f"\n📊 Done! {results['passed']}/26 passed (≥9/10)")
    print(f"📄 Report: {report_path}")
    print(f"📄 JSON: {json_path}")

if __name__ == "__main__":
    main()
