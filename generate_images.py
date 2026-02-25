#!/usr/bin/env python3
"""
Generera tjänstebilder med Gemini Imagen.
"""
import os, sys, time
from pathlib import Path
from google import genai
from google.genai import types

API_KEY = os.environ.get("GEMINI_API_KEY", "AIzaSyA9M25q6GccWMH1RRtjQr5avWJ49FHhbSY")
client = genai.Client(api_key=API_KEY)

OUTPUT_DIR = Path("scraped/images")
OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

SERVICES = [
    {
        "slug": "service-hemstad",
        "prompt": "Professional photo of a happy elderly Swedish woman cleaning a bright, cozy apartment living room. Natural warm light, trustworthy home service, clean modern interior, real photo style, no text.",
    },
    {
        "slug": "service-tradgard",
        "prompt": "Professional photo of a cheerful elderly man gardening in a beautiful Swedish garden, trimming hedges or planting flowers, warm summer light, trustworthy home service, real photo style, no text.",
    },
    {
        "slug": "service-malning",
        "prompt": "Professional photo of a skilled elderly craftsman painting a wall in a bright Swedish apartment, fresh white paint, clean work, trustworthy home service feel, real photo style, no text.",
    },
    {
        "slug": "service-snickeri",
        "prompt": "Professional photo of an experienced elderly carpenter doing woodwork or fixing furniture in a Swedish home, workshop detail, craftsmanship, trustworthy home service, real photo style, no text.",
    },
]

def generate(service):
    out = OUTPUT_DIR / f"{service['slug']}.png"
    if out.exists():
        print(f"⏭  {service['slug']} finns redan — hoppar över")
        return out

    print(f"🎨 Genererar {service['slug']}...")
    try:
        response = client.models.generate_images(
            model="imagen-3.0-generate-002",
            prompt=service["prompt"],
            config=types.GenerateImagesConfig(
                number_of_images=1,
                aspect_ratio="16:9",
                safety_filter_level="block_only_high",
                person_generation="allow_adult",
            ),
        )
        img = response.generated_images[0]
        out.write_bytes(img.image.image_bytes)
        print(f"✅ Sparad: {out} ({out.stat().st_size // 1024}KB)")
        return out
    except Exception as e:
        print(f"❌ Fel för {service['slug']}: {e}")
        return None

if __name__ == "__main__":
    results = []
    for svc in SERVICES:
        path = generate(svc)
        results.append((svc["slug"], path))
        time.sleep(2)  # rate limit

    print("\n📋 Resultat:")
    for slug, path in results:
        status = "✅" if path and path.exists() else "❌"
        print(f"  {status} {slug}: {path}")
