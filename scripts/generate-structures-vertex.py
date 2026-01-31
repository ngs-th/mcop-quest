#!/usr/bin/env python3
"""
Generate Kingdom Rush style structure assets using Google Vertex AI (Imagen 3)
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
OUTPUT_DIR = Path('/Users/ngs/Herd/mcop-quest/public/images/map/structures')

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

def generate_structure(
    prompt: str,
    output_filename: str,
    size: int = 256
) -> bool:
    """Generate a structure using Vertex AI Imagen 3"""

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
            return generate_structure(prompt, output_filename, size)

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

# Structure definitions
STRUCTURES = [
    {
        "id": "member_city",
        "name": "Member City",
        "filename": "castle.png",
        "prompt": "Hand-painted 2D game structure, top-down view, majestic medieval castle with red rooftops and stone walls, multiple towers with blue banners, surrounded by green grass, Kingdom Rush cartoon fantasy style, warm saturated colors, bold outlines, 256x256 pixels, game art, isolated on transparent background"
    },
    {
        "id": "task_tower",
        "name": "Task Tower",
        "filename": "tower.png",
        "prompt": "Hand-painted 2D game structure, top-down view, tall wizard tower with spiral staircase, glowing blue magical crystal at top, stone construction with moss, Kingdom Rush cartoon fantasy style, warm saturated colors, bold outlines, 256x256 pixels, game art, isolated on transparent background"
    },
    {
        "id": "bug_bastion",
        "name": "Bug Bastion",
        "filename": "bastion.png",
        "prompt": "Hand-painted 2D game structure, top-down view, dark ominous fortress in haunted forest, giant twisted trees surrounding, glowing green mist, stone dungeon entrance, Kingdom Rush cartoon fantasy style, dark purple and green colors, bold outlines, 256x256 pixels, game art, isolated on transparent background"
    },
    {
        "id": "alchemy_lab",
        "name": "Analytics Alchemy Lab",
        "filename": "lab.png",
        "prompt": "Hand-painted 2D game structure, top-down view, magical alchemy laboratory with floating purple crystals, bubbling cauldrons, mystical energy effects, wizard tower with observatory dome, Kingdom Rush cartoon fantasy style, purple and gold colors, bold outlines, 256x256 pixels, game art, isolated on transparent background"
    },
    {
        "id": "community_commons",
        "name": "Community Commons",
        "filename": "market.png",
        "prompt": "Hand-painted 2D game structure, top-down view, vibrant medieval marketplace with colorful tents and stalls, merchant stands with awnings, barrels and crates, warm sunlight, Kingdom Rush cartoon fantasy style, warm orange and yellow colors, bold outlines, 256x256 pixels, game art, isolated on transparent background"
    },
    {
        "id": "payment_fortress",
        "name": "Payment Fortress",
        "filename": "fortress.png",
        "prompt": "Hand-painted 2D game structure, top-down view, dark volcanic fortress with black spires, surrounded by lava flows and fire, storm clouds above with lightning, molten rock, Kingdom Rush cartoon fantasy style, dark red orange and black colors, bold outlines, 256x256 pixels, game art, isolated on transparent background"
    },
    {
        "id": "product_city",
        "name": "Product City",
        "filename": "merchant.png",
        "prompt": "Hand-painted 2D game structure, top-down view, busy merchant trading post with wooden buildings, hanging signs, gold coins and treasure chests, merchant stalls, Kingdom Rush cartoon fantasy style, warm brown and gold colors, bold outlines, 256x256 pixels, game art, isolated on transparent background"
    },
    {
        "id": "notification_tower",
        "name": "Notification Tower",
        "filename": "bell_tower.png",
        "prompt": "Hand-painted 2D game structure, top-down view, tall stone bell tower with large bronze bell, signal flags, watchtower design with wooden balcony, Kingdom Rush cartoon fantasy style, warm stone colors, bold outlines, 256x256 pixels, game art, isolated on transparent background"
    }
]

def main():
    print("=" * 60)
    print("🏰 Kingdom Rush Structure Generator")
    print("=" * 60)
    print(f"📁 Output: {OUTPUT_DIR}")
    print(f"☁️  Project: {PROJECT_ID}")
    print(f"📍 Location: {LOCATION}")
    print()

    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

    success_count = 0
    total = len(STRUCTURES)

    for i, structure in enumerate(STRUCTURES, 1):
        print(f"[{i}/{total}] 🏰 Generating: {structure['name']}")
        print(f"       File: {structure['filename']}")

        if generate_structure(structure['prompt'], structure['filename']):
            success_count += 1

        # Delay to avoid quota issues
        if i < total:
            time.sleep(8)

    print()
    print("=" * 60)
    print("📊 Generation Summary")
    print("=" * 60)
    print(f"✅ Success: {success_count}/{total}")
    print(f"❌ Failed: {total - success_count}")

    if success_count == total:
        print("\n🎉 All structures generated successfully!")
    else:
        print(f"\n⚠️  {total - success_count} structure(s) failed. Re-run to retry.")

if __name__ == '__main__':
    main()
