#!/usr/bin/env python3
"""
Generate seamless tileset using Google Vertex AI (Imagen 3)
No white backgrounds, no "kingdom rush" text
"""

import os
import sys
import json
import time
import base64
from pathlib import Path
from typing import Optional

# Configuration
PROJECT_ID = os.getenv('GOOGLE_CLOUD_PROJECT', 'gen-lang-client-0173677651')
LOCATION = os.getenv('GOOGLE_CLOUD_LOCATION', 'asia-southeast1')
OUTPUT_DIR = Path('/Users/ngs/Herd/mcop-quest/public/images/map/tiles')

def get_access_token() -> str:
    """Get Google Cloud access token"""
    import subprocess
    result = subprocess.run(
        ['gcloud', 'auth', 'print-access-token'],
        capture_output=True, text=True
    )
    if result.returncode != 0:
        print("❌ Failed to get access token. Run: gcloud auth application-default login")
        sys.exit(1)
    return result.stdout.strip()

def generate_tile(
    prompt: str,
    output_filename: str,
    size: int = 128
) -> bool:
    """Generate a single tile using Vertex AI Imagen 3"""

    url = f"https://{LOCATION}-aiplatform.googleapis.com/v1/projects/{PROJECT_ID}/locations/{LOCATION}/publishers/google/models/imagen-3.0-generate-002:predict"

    headers = {
        "Authorization": f"Bearer {get_access_token()}",
        "Content-Type": "application/json"
    }

    payload = {
        "instances": [{"prompt": prompt}],
        "parameters": {
            "sampleCount": 1,
            "aspectRatio": "1:1",
            "personGeneration": "dont_allow",
            "safetySetting": "block_some"
        }
    }

    import requests
    try:
        response = requests.post(url, headers=headers, json=payload, timeout=120)

        if response.status_code == 429:
            print(f"   ⏳ Quota exceeded, waiting 60s...")
            time.sleep(60)
            return generate_tile(prompt, output_filename, size)

        response.raise_for_status()
        data = response.json()

        if 'predictions' in data and len(data['predictions']) > 0:
            image_base64 = data['predictions'][0].get('bytesBase64Encoded')
            if image_base64:
                output_path = OUTPUT_DIR / output_filename
                with open(output_path, 'wb') as f:
                    f.write(base64.b64decode(image_base64))
                size_kb = output_path.stat().st_size / 1024
                print(f"   ✅ Saved: {output_filename} ({size_kb:.1f} KB)")
                return True

        print(f"   ❌ No image in response")
        return False

    except Exception as e:
        print(f"   ❌ Error: {e}")
        return False

# Tile definitions - seamless, no white backgrounds, no "kingdom rush" text
TILES = [
    # Base terrain tiles - seamless hand-painted style
    {
        "name": "grass_01",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, lush green grass meadow texture, warm saturated green colors, cartoon fantasy game art style, bold outlines, 128x128 pixels, tileable seamless texture, no text no watermark"
    },
    {
        "name": "grass_02",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, green meadow grass with tiny flowers scattered, warm saturated colors, cartoon fantasy game art style, bold outlines, 128x128 pixels, tileable seamless texture, no text"
    },
    {
        "name": "grass_03",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, wild tall grass field texture, warm saturated green colors, cartoon fantasy game art style, bold outlines, 128x128 pixels, tileable seamless texture, no text"
    },
    {
        "name": "dirt_01",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, warm brown dirt soil ground texture, earth tones, cartoon fantasy game art style, bold outlines, 128x128 pixels, tileable seamless texture, no text no watermark"
    },
    {
        "name": "dirt_02",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, trodden dirt path ground texture, warm brown orange colors, cartoon fantasy game art style, bold outlines, 128x128 pixels, tileable seamless texture, no text"
    },
    {
        "name": "dirt_03",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, dry cracked earth soil, warm saturated brown colors, cartoon fantasy game art style, bold outlines, 128x128 pixels, tileable seamless texture, no text"
    },
    {
        "name": "water_01",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, clear blue water with gentle wave patterns, saturated blue colors, cartoon fantasy game art style, bold outlines, 128x128 pixels, tileable seamless texture, no text no watermark"
    },
    {
        "name": "water_02",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, deep blue river water surface, rich blue colors, cartoon fantasy game art style, bold outlines, 128x128 pixels, tileable seamless texture, no text"
    },
    {
        "name": "stone_01",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, gray stone pavement cobblestone texture, warm gray beige colors, cartoon fantasy game art style, bold outlines, 128x128 pixels, tileable seamless texture, no text"
    },

    # Road tiles - dirt paths on grass
    {
        "name": "road_straight_h",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, horizontal dirt road path cutting through green grass, warm brown path on lush green grass, cartoon fantasy game art style, bold outlines, 128x128 pixels, seamless edges, no text"
    },
    {
        "name": "road_straight_v",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, vertical dirt road path cutting through green grass, warm brown path on lush green grass, cartoon fantasy game art style, bold outlines, 128x128 pixels, seamless edges, no text"
    },
    {
        "name": "road_corner_ne",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, curved dirt road corner northeast turn through green grass, warm brown curved path, cartoon fantasy game art style, bold outlines, 128x128 pixels, seamless edges, no text"
    },
    {
        "name": "road_corner_nw",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, curved dirt road corner northwest turn through green grass, warm brown curved path, cartoon fantasy game art style, bold outlines, 128x128 pixels, seamless edges, no text"
    },
    {
        "name": "road_intersection",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, dirt road four-way crossroads intersection through green grass, warm brown cross pattern on green grass, cartoon fantasy game art style, bold outlines, 128x128 pixels, seamless edges, no text"
    },

    # Transition tiles - grass to dirt
    {
        "name": "trans_grass_dirt_n",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, transition tile grass on bottom half dirt on top half, seamless horizontal blend, warm brown and green colors, cartoon fantasy game art style, 128x128 pixels, no text"
    },
    {
        "name": "trans_grass_dirt_s",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, transition tile grass on top half dirt on bottom half, seamless horizontal blend, warm brown and green colors, cartoon fantasy game art style, 128x128 pixels, no text"
    },
    {
        "name": "trans_grass_dirt_e",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, transition tile grass on left half dirt on right half, seamless vertical blend, warm brown and green colors, cartoon fantasy game art style, 128x128 pixels, no text"
    },
    {
        "name": "trans_grass_dirt_w",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, transition tile grass on right half dirt on left half, seamless vertical blend, warm brown and green colors, cartoon fantasy game art style, 128x128 pixels, no text"
    },

    # Water transitions - grass to water
    {
        "name": "trans_grass_water_n",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, shoreline transition grass on bottom water on top, seamless blend green to blue, cartoon fantasy game art style, 128x128 pixels, no text"
    },
    {
        "name": "trans_grass_water_s",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, shoreline transition grass on top water on bottom, seamless blend green to blue, cartoon fantasy game art style, 128x128 pixels, no text"
    },
    {
        "name": "trans_grass_water_e",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, shoreline transition grass on left water on right, seamless blend green to blue, cartoon fantasy game art style, 128x128 pixels, no text"
    },
    {
        "name": "trans_grass_water_w",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, shoreline transition grass on right water on left, seamless blend green to blue, cartoon fantasy game art style, 128x128 pixels, no text"
    },

    # Decoration tiles
    {
        "name": "deco_rock_01",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, gray rocks and boulders scattered on grass, cartoon fantasy game art style, bold outlines, 128x128 pixels, transparent corners fade to grass, no text"
    },
    {
        "name": "deco_tree_01",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, small green pine trees and bushes on grass, cartoon fantasy game art style, bold outlines, 128x128 pixels, transparent corners fade to grass, no text"
    },
    {
        "name": "deco_flowers",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, colorful wildflowers red yellow purple on grass, cartoon fantasy game art style, bold outlines, 128x128 pixels, transparent corners fade to grass, no text"
    },
    {
        "name": "deco_grass_tuft",
        "prompt": "Hand-painted 2D game tile, top-down birdseye view, tall grass tufts and reeds on grass, cartoon fantasy game art style, bold outlines, 128x128 pixels, transparent corners fade to grass, no text"
    },
]

def main():
    print("=" * 60)
    print("🎨 Seamless Tileset Generator v2")
    print("=" * 60)
    print(f"📁 Output: {OUTPUT_DIR}")
    print(f"☁️  Project: {PROJECT_ID}")
    print(f"📍 Location: {LOCATION}")
    print()

    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

    success_count = 0
    total = len(TILES)

    for i, tile in enumerate(TILES, 1):
        print(f"[{i}/{total}] 🎨 Generating: {tile['name']}.png")
        print(f"       Prompt: {tile['prompt'][:80]}...")

        if generate_tile(tile['prompt'], f"{tile['name']}.png"):
            success_count += 1

        # Delay to avoid quota issues
        if i < total:
            time.sleep(5)

    print()
    print("=" * 60)
    print("📊 Generation Summary")
    print("=" * 60)
    print(f"✅ Success: {success_count}/{total}")
    print(f"❌ Failed: {total - success_count}")

    if success_count == total:
        print("\n🎉 All tiles generated successfully!")
    else:
        print(f"\n⚠️  {total - success_count} tile(s) failed. Re-run script to retry.")

if __name__ == '__main__':
    main()
