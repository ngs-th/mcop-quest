#!/usr/bin/env python3
"""
Generate single large map background (5120x3840) instead of tiles
"""

import os
import sys
import time
import base64
from pathlib import Path

PROJECT_ID = os.getenv('GOOGLE_CLOUD_PROJECT', 'gen-lang-client-0173677651')
LOCATION = os.getenv('GOOGLE_CLOUD_LOCATION', 'asia-southeast1')
OUTPUT_DIR = Path('/Users/ngs/Herd/mcop-quest/public/images/map')

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

def generate_image(prompt, output_filename):
    url = f"https://{LOCATION}-aiplatform.googleapis.com/v1/projects/{PROJECT_ID}/locations/{LOCATION}/publishers/google/models/imagen-3.0-generate-002:predict"

    headers = {
        "Authorization": f"Bearer {get_access_token()}",
        "Content-Type": "application/json"
    }

    payload = {
        "instances": [{"prompt": prompt}],
        "parameters": {
            "sampleCount": 1,
            "aspectRatio": "4:3",  # 5120x3840 is 4:3 ratio
            "personGeneration": "dont_allow",
            "safetySetting": "block_some"
        }
    }

    import requests
    try:
        response = requests.post(url, headers=headers, json=payload, timeout=180)

        if response.status_code == 429:
            print("   ⏳ Quota exceeded, waiting 60s...")
            time.sleep(60)
            return generate_image(prompt, output_filename)

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
    print("🗺️  Map Background Generator")
    print("=" * 60)
    print(f"📁 Output: {OUTPUT_DIR}")
    print()

    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

    # Generate single large map background
    prompt = """Hand-painted fantasy game world map, top-down birdseye view,
    large seamless terrain 5120x3840 pixels, lush green grasslands with patches of brown dirt paths,
    blue rivers winding through, small lakes, hand-painted cartoon style, warm saturated colors,
    continuous texture no visible seams, fantasy kingdom landscape, no buildings, no text"""

    print("🎨 Generating map background...")
    print("   This may take a few minutes...")
    print()

    if generate_image(prompt, "background.png"):
        print()
        print("🎉 Map background generated!")
        print()
        print("⚠️  Note: Image will need to be resized to 5120x3840")
        print("   The AI generates at a lower resolution, we upscale.")
    else:
        print("❌ Failed to generate background")

if __name__ == '__main__':
    main()
