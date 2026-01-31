#!/usr/bin/env python3
"""
Generate truly seamless grass tile - uniform texture without internal patterns
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
    print("🌱 True Seamless Grass Generator")
    print("=" * 60)

    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

    # Generate uniform seamless grass without any internal grid
    tiles = [
        {
            "name": "grass_uniform",
            "prompt": "Uniform grass texture tile, top-down view, completely seamless, lush green color, soft noise texture, NO grid, NO squares, NO patterns, NO borders, continuous homogeneous grass surface, hand-painted style, 128x128 pixels"
        },
        {
            "name": "dirt_uniform",
            "prompt": "Uniform dirt ground texture tile, top-down view, completely seamless, warm brown color, soft sandy texture, NO grid, NO squares, NO patterns, NO borders, continuous homogeneous soil surface, hand-painted style, 128x128 pixels"
        },
        {
            "name": "water_uniform",
            "prompt": "Uniform water surface texture tile, top-down view, completely seamless, clear blue color, soft ripples, NO grid, NO squares, NO patterns, NO borders, continuous homogeneous water surface, hand-painted style, 128x128 pixels"
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
    print(f"✅ Generated: {success}/{len(tiles)}")

if __name__ == '__main__':
    main()
