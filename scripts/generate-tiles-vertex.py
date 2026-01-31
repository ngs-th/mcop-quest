#!/usr/bin/env python3
"""
Generate Kingdom Rush style tileset using Google Vertex AI (Imagen 3)
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

# Tile definitions with prompts
TILES = [
    # Base terrain tiles
    {
        "name": "grass_01",
        "prompt": "Hand-painted 2D game tile, top-down view, lush green grass terrain, Kingdom Rush style, warm saturated colors, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, seamless edges, single tile isolated on white background, game art"
    },
    {
        "name": "grass_02",
        "prompt": "Hand-painted 2D game tile, top-down view, green meadow grass with small flowers, Kingdom Rush style, warm saturated colors, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, seamless edges, single tile isolated on white background"
    },
    {
        "name": "grass_03",
        "prompt": "Hand-painted 2D game tile, top-down view, wild grass field with tall blades, Kingdom Rush style, warm saturated green colors, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, seamless edges, single tile isolated on white"
    },
    {
        "name": "dirt_01",
        "prompt": "Hand-painted 2D game tile, top-down view, warm brown dirt ground, Kingdom Rush style, warm saturated earth tones, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, seamless edges, single tile isolated on white background"
    },
    {
        "name": "dirt_02",
        "prompt": "Hand-painted 2D game tile, top-down view, trodden dirt path texture, Kingdom Rush style, warm brown orange colors, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, seamless edges, single tile isolated on white"
    },
    {
        "name": "dirt_03",
        "prompt": "Hand-painted 2D game tile, top-down view, dry earth cracked soil, Kingdom Rush style, warm saturated brown colors, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, seamless edges, single tile isolated on white"
    },
    {
        "name": "water_01",
        "prompt": "Hand-painted 2D game tile, top-down view, clear blue water with subtle wave patterns, Kingdom Rush style, saturated blue colors, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, seamless edges, single tile isolated on white"
    },
    {
        "name": "water_02",
        "prompt": "Hand-painted 2D game tile, top-down view, deep blue river water, Kingdom Rush style, rich blue colors, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, seamless edges, single tile isolated on white"
    },
    {
        "name": "stone_01",
        "prompt": "Hand-painted 2D game tile, top-down view, gray stone pavement, Kingdom Rush style, warm gray colors, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, seamless edges, single tile isolated on white"
    },

    # Road tiles
    {
        "name": "road_straight_h",
        "prompt": "Hand-painted 2D game tile, top-down view, horizontal dirt road path through grass, Kingdom Rush style, warm brown path on green grass, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, seamless edges"
    },
    {
        "name": "road_straight_v",
        "prompt": "Hand-painted 2D game tile, top-down view, vertical dirt road path through grass, Kingdom Rush style, warm brown path on green grass, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, seamless edges"
    },
    {
        "name": "road_corner_ne",
        "prompt": "Hand-painted 2D game tile, top-down view, dirt road corner turning from north to east, Kingdom Rush style, warm brown curved path on green grass, cartoon fantasy aesthetic, bold outlines, 128x128 pixels"
    },
    {
        "name": "road_corner_nw",
        "prompt": "Hand-painted 2D game tile, top-down view, dirt road corner turning from north to west, Kingdom Rush style, warm brown curved path on green grass, cartoon fantasy aesthetic, bold outlines, 128x128 pixels"
    },
    {
        "name": "road_intersection",
        "prompt": "Hand-painted 2D game tile, top-down view, dirt road four-way intersection, Kingdom Rush style, warm brown crossroads on green grass, cartoon fantasy aesthetic, bold outlines, 128x128 pixels"
    },

    # Transition tiles (simplified set)
    {
        "name": "trans_grass_dirt_n",
        "prompt": "Hand-painted 2D game tile, top-down view, grass on south half, dirt on north half, seamless horizontal transition, Kingdom Rush style, cartoon fantasy aesthetic, bold outlines, 128x128 pixels"
    },
    {
        "name": "trans_grass_dirt_s",
        "prompt": "Hand-painted 2D game tile, top-down view, grass on north half, dirt on south half, seamless horizontal transition, Kingdom Rush style, cartoon fantasy aesthetic, bold outlines, 128x128 pixels"
    },
    {
        "name": "trans_grass_dirt_e",
        "prompt": "Hand-painted 2D game tile, top-down view, grass on west half, dirt on east half, seamless vertical transition, Kingdom Rush style, cartoon fantasy aesthetic, bold outlines, 128x128 pixels"
    },
    {
        "name": "trans_grass_dirt_w",
        "prompt": "Hand-painted 2D game tile, top-down view, grass on east half, dirt on west half, seamless vertical transition, Kingdom Rush style, cartoon fantasy aesthetic, bold outlines, 128x128 pixels"
    },
    {
        "name": "trans_grass_water_n",
        "prompt": "Hand-painted 2D game tile, top-down view, grass on south half, water shoreline on north half, seamless transition, Kingdom Rush style, cartoon fantasy aesthetic, bold outlines, 128x128 pixels"
    },
    {
        "name": "trans_grass_water_s",
        "prompt": "Hand-painted 2D game tile, top-down view, grass on north half, water shoreline on south half, seamless transition, Kingdom Rush style, cartoon fantasy aesthetic, bold outlines, 128x128 pixels"
    },

    # Decoration tiles
    {
        "name": "deco_rock_01",
        "prompt": "Hand-painted 2D game tile, top-down view, gray rocks and boulders on grass, Kingdom Rush style, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, single tile isolated on white"
    },
    {
        "name": "deco_tree_01",
        "prompt": "Hand-painted 2D game tile, top-down view, small green trees and bushes on grass, Kingdom Rush style, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, single tile isolated on white"
    },
    {
        "name": "deco_flowers",
        "prompt": "Hand-painted 2D game tile, top-down view, colorful wildflowers on grass, Kingdom Rush style, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, single tile isolated on white"
    },
    {
        "name": "deco_grass_tuft",
        "prompt": "Hand-painted 2D game tile, top-down view, tall grass tufts and reeds, Kingdom Rush style, cartoon fantasy aesthetic, bold outlines, 128x128 pixels, single tile isolated on white"
    },
]

def main():
    print("=" * 60)
    print("🎨 Kingdom Rush Tileset Generator")
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
