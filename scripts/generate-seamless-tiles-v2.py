#!/usr/bin/env python3
"""
Generate truly seamless tiles v2 - No grid patterns, uniform textures
"""

import os
import sys
import time
import base64
from pathlib import Path

PROJECT_ID = os.getenv('GOOGLE_CLOUD_PROJECT', 'gen-lang-client-0173677651')
LOCATION = os.getenv('GOOGLE_CLOUD_LOCATION', 'asia-southeast1')
OUTPUT_DIR = Path('/Users/ngs/Herd/mcop-quest/public/images/map/tiles')

def get_access_token():
    import subprocess
    result = subprocess.run(
        ['gcloud', 'auth', 'print-access-token'],
        capture_output=True, text=True
    )
    if result.returncode != 0:
        print("❌ Failed to get access token")
        sys.exit(1)
    return result.stdout.strip()

def generate_tile(prompt, output_filename):
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
            print("   ⏳ Quota exceeded, waiting 60s...")
            time.sleep(60)
            return generate_tile(prompt, output_filename)

        response.raise_for_status()
        data = response.json()

        if 'predictions' in data and data['predictions']:
            image_base64 = data['predictions'][0].get('bytesBase64Encoded')
            if image_base64:
                output_path = OUTPUT_DIR / output_filename
                with open(output_path, 'wb') as f:
                    f.write(base64.b64decode(image_base64))
                size_kb = output_path.stat().st_size / 1024
                print(f"   ✅ Saved: {output_filename} ({size_kb:.1f} KB)")
                return True

        print("   ❌ No image in response")
        return False

    except Exception as e:
        print(f"   ❌ Error: {e}")
        return False

def main():
    print("=" * 60)
    print("🌱 Seamless Tiles V2 Generator - No Grid Patterns")
    print("=" * 60)

    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

    # Generate tiles with uniform textures - NO grid patterns
    tiles = [
        {
            "name": "grass_base",
            "prompt": "Seamless grass texture tile, top-down view, uniform light green color, soft natural variation like hand-painted watercolor, absolutely NO grid pattern, NO squares, NO borders, continuous homogeneous grass surface, subtle color noise only, fantasy game art style, 128x128 pixels"
        },
        {
            "name": "grass_01",
            "prompt": "Seamless grass texture tile, top-down view, medium green color with tiny scattered grass blades and small flowers, NO grid pattern, NO repeating squares, NO borders, organic natural distribution, soft hand-painted style, 128x128 pixels"
        },
        {
            "name": "grass_02",
            "prompt": "Seamless grass texture tile, top-down view, lush darker green with scattered small rocks and pebbles, NO grid pattern, NO squares, organic random placement, hand-painted fantasy style, 128x128 pixels"
        },
        {
            "name": "grass_03",
            "prompt": "Seamless grass texture tile, top-down view, meadow green with wildflowers scattered naturally, NO grid pattern, NO repeating pattern, flowers placed organically, soft artistic style, 128x128 pixels"
        },
        {
            "name": "dirt_base",
            "prompt": "Seamless dirt ground texture tile, top-down view, warm brown earth color, uniform sandy texture, NO grid pattern, NO squares, NO borders, continuous soil surface with subtle color variation, hand-painted style, 128x128 pixels"
        },
        {
            "name": "stone_01",
            "prompt": "Seamless cobblestone path texture tile, top-down view, gray stones arranged naturally with grass between, NO grid pattern, irregular organic stone placement, hand-painted fantasy style, 128x128 pixels"
        },
        {
            "name": "water_base",
            "prompt": "Seamless water surface texture tile, top-down view, clear blue with soft ripples, NO grid pattern, NO squares, NO borders, continuous water surface, gentle wave texture, hand-painted style, 128x128 pixels"
        },
    ]

    success = 0
    for i, tile in enumerate(tiles, 1):
        print(f"[{i}/{len(tiles)}] 🎨 {tile['name']}.png")
        if generate_tile(tile['prompt'], f"{tile['name']}.png"):
            success += 1
        if i < len(tiles):
            time.sleep(5)

    print()
    print("=" * 60)
    print(f"✅ Generated: {success}/{len(tiles)} tiles")
    print("=" * 60)

if __name__ == '__main__':
    main()
