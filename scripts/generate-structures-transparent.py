#!/usr/bin/env python3
"""
Generate structure assets with transparent backgrounds
No ground/background included - just the building
"""

import os
import sys
import time
import base64
from pathlib import Path

PROJECT_ID = os.getenv('GOOGLE_CLOUD_PROJECT', 'gen-lang-client-0173677651')
LOCATION = os.getenv('GOOGLE_CLOUD_LOCATION', 'asia-southeast1')
OUTPUT_DIR = Path('/Users/ngs/Herd/mcop-quest/public/images/map/structures')

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

def generate_structure(prompt: str, output_filename: str) -> bool:
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
            return generate_structure(prompt, output_filename)

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

# Structure definitions - transparent background, no ground included
STRUCTURES = [
    {
        "name": "castle",
        "prompt": "2D game building asset, top-down view, medieval fantasy castle with red rooftops and stone walls, towers with blue banners, floating on transparent background, hand-painted cartoon style, 256x256 pixels, isolated building only no ground no grass"
    },
    {
        "name": "tower",
        "prompt": "2D game building asset, top-down view, wizard magic tower with spiral staircase, glowing blue crystal top, stone construction, floating on transparent background, hand-painted cartoon style, 256x256 pixels, isolated building only"
    },
    {
        "name": "bastion",
        "prompt": "2D game building asset, top-down view, dark ominous fortress, haunted castle with twisted trees attached, glowing green mist, floating on transparent background, hand-painted cartoon style, 256x256 pixels, isolated building"
    },
    {
        "name": "lab",
        "prompt": "2D game building asset, top-down view, magical alchemy laboratory with floating purple crystals, bubbling cauldrons, wizard observatory dome, floating on transparent background, hand-painted cartoon style, 256x256 pixels, isolated building"
    },
    {
        "name": "market",
        "prompt": "2D game building asset, top-down view, medieval marketplace with colorful tents and stalls, merchant stands with awnings, barrels and crates, floating on transparent background, hand-painted cartoon style, 256x256 pixels, isolated building"
    },
    {
        "name": "fortress",
        "prompt": "2D game building asset, top-down view, dark volcanic fortress with black spires, lava and fire effects, storm clouds and lightning, floating on transparent background, hand-painted cartoon style, 256x256 pixels, isolated building"
    },
    {
        "name": "merchant",
        "prompt": "2D game building asset, top-down view, busy trading post with wooden buildings, hanging signs, gold coins and treasure chests, floating on transparent background, hand-painted cartoon style, 256x256 pixels, isolated building"
    },
    {
        "name": "bell_tower",
        "prompt": "2D game building asset, top-down view, tall stone bell tower with large bronze bell, signal flags, watchtower design with balcony, floating on transparent background, hand-painted cartoon style, 256x256 pixels, isolated building"
    }
]

def main():
    print("=" * 60)
    print("🏰 Structures with Transparent Background")
    print("=" * 60)
    print(f"📁 Output: {OUTPUT_DIR}")
    print()

    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

    success_count = 0
    total = len(STRUCTURES)

    for i, structure in enumerate(STRUCTURES, 1):
        print(f"[{i}/{total}] 🏰 {structure['name']}.png")

        if generate_structure(structure['prompt'], f"{structure['name']}.png"):
            success_count += 1

        if i < total:
            time.sleep(8)

    print()
    print("=" * 60)
    print(f"✅ Success: {success_count}/{total}")

    if success_count == total:
        print("🎉 All structures generated!")

if __name__ == '__main__':
    main()
