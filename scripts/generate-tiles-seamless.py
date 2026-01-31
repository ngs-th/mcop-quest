#!/usr/bin/env python3
"""
Generate truly seamless tiles without any frames or borders
"""

import os
import sys
import time
import base64
from pathlib import Path

PROJECT_ID = os.getenv('GOOGLE_CLOUD_PROJECT', 'gen-lang-client-0173677651')
LOCATION = os.getenv('GOOGLE_CLOUD_LOCATION', 'asia-southeast1')
OUTPUT_DIR = Path('/Users/ngs/Herd/mcop-quest/public/images/map/tiles')

def get_access_token() -> str:
    import subprocess
    result = subprocess.run(
        ['gcloud', 'auth', 'print-access-token'],
        capture_output=True, text=True
    )
    if result.returncode != 0:
        print("❌ Failed to get access token")
        sys.exit(1)
    return result.stdout.strip()

def generate_tile(prompt: str, output_filename: str) -> bool:
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
            return generate_tile(prompt, output_filename)

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

# Seamless tiles without any frames or borders
TILES = [
    # Pure grass - seamless, no frame, no border
    {
        "name": "grass_01",
        "prompt": "2D game texture tile, top-down view, seamless grass field, lush green color, hand-painted cartoon style, 128x128 pixels, tileable no edges no frame no border, continuous pattern"
    },
    {
        "name": "grass_02",
        "prompt": "2D game texture tile, top-down view, seamless meadow grass with small flowers, green and yellow accents, hand-painted cartoon style, 128x128 pixels, tileable no edges no frame, continuous"
    },
    {
        "name": "grass_03",
        "prompt": "2D game texture tile, top-down view, seamless wild grass texture, various green shades, hand-painted cartoon style, 128x128 pixels, tileable no edges no border, continuous pattern"
    },

    # Dirt/soil - seamless
    {
        "name": "dirt_01",
        "prompt": "2D game texture tile, top-down view, seamless brown dirt ground, earth soil texture, warm brown colors, hand-painted cartoon style, 128x128 pixels, tileable no edges no frame"
    },
    {
        "name": "dirt_02",
        "prompt": "2D game texture tile, top-down view, seamless path dirt, trodden ground texture, orange-brown colors, hand-painted cartoon style, 128x128 pixels, tileable no edges no border"
    },
    {
        "name": "dirt_03",
        "prompt": "2D game texture tile, top-down view, seamless dry cracked earth, parched soil texture, brown and tan colors, hand-painted cartoon style, 128x128 pixels, tileable no edges"
    },

    # Water - seamless
    {
        "name": "water_01",
        "prompt": "2D game texture tile, top-down view, seamless blue water surface, gentle ripples, clear blue colors, hand-painted cartoon style, 128x128 pixels, tileable no edges no frame"
    },
    {
        "name": "water_02",
        "prompt": "2D game texture tile, top-down view, seamless deep blue water, ocean lake surface, rich blue colors, hand-painted cartoon style, 128x128 pixels, tileable no edges no border"
    },

    # Stone/pavement
    {
        "name": "stone_01",
        "prompt": "2D game texture tile, top-down view, seamless gray stone pavement, cobblestone floor texture, gray and beige, hand-painted cartoon style, 128x128 pixels, tileable no edges"
    },
]

def main():
    print("=" * 60)
    print("🎨 Seamless Tiles Generator (No Frames)")
    print("=" * 60)
    print(f"📁 Output: {OUTPUT_DIR}")
    print()

    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

    success_count = 0
    total = len(TILES)

    for i, tile in enumerate(TILES, 1):
        print(f"[{i}/{total}] 🎨 {tile['name']}.png")

        if generate_tile(tile['prompt'], f"{tile['name']}.png"):
            success_count += 1

        if i < total:
            time.sleep(5)

    print()
    print("=" * 60)
    print(f"✅ Success: {success_count}/{total}")

    if success_count == total:
        print("🎉 All tiles generated!")

if __name__ == '__main__':
    main()
