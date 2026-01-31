#!/usr/bin/env python3
"""
Together AI Image Generator for MCOP Quest Assets
Uses free tier (starts with $5 credit)
"""

import os
import sys
import time
import requests
from pathlib import Path

BASE_URL = "https://api.together.xyz/v1/images/generations"

# Together AI supports many models
MODEL = "black-forest-labs/FLUX.1-schnell"  # Fast and good quality

# Asset definitions
ASSETS = {
    "castle.png": {
        "prompt": "pixel art RPG style, 16-bit SNES style, majestic medieval castle with red rooftops and stone walls surrounded by green trees, fantasy game asset, isometric view, detailed pixel art, warm colors, transparent background concept",
    },
    "task_tower.png": {
        "prompt": "pixel art RPG style, 16-bit SNES style, tall wizard tower with spiral stairs and glowing blue magical light at the top, fantasy game asset, isometric view, gray stone with blue magical glow",
    },
    "bug_bastion.png": {
        "prompt": "pixel art RPG style, 16-bit SNES style, mystical forest dungeon entrance with giant twisted trees and overgrown vines, dark green foliage, mysterious fog atmosphere, fantasy game asset, isometric view",
    },
    "alchemy_lab.png": {
        "prompt": "pixel art RPG style, 16-bit SNES style, magical alchemy laboratory with floating purple crystals and glowing magical apparatus, fantasy game asset, isometric view, purple and blue magical lighting",
    },
    "community_commons.png": {
        "prompt": "pixel art RPG style, 16-bit SNES style, vibrant marketplace town square with colorful tents and stalls, warm lighting, lively atmosphere, fantasy game asset, isometric view, warm oranges and yellows",
    },
    "payment_fortress.png": {
        "prompt": "pixel art RPG style, 16-bit SNES style, dark ominous fortress with storm clouds and lightning, volcanic rocks with lava cracks, fantasy game asset, isometric view, dark blacks with fiery reds and oranges",
    }
}


def get_api_token() -> str:
    """Get Together AI API token from environment"""
    token = os.environ.get("TOGETHER_API_KEY")
    if not token:
        print("❌ Error: TOGETHER_API_KEY not set!")
        print("\n1. Go to: https://api.together.xyz/")
        print("2. Sign up (free, starts with $5 credit)")
        print("3. Get your API key from settings")
        print("4. Run: export TOGETHER_API_KEY='your_key_here'")
        sys.exit(1)
    return token


def generate_image(api_key: str, prompt: str) -> bytes:
    """Generate image using Together AI API"""

    headers = {
        "Authorization": f"Bearer {api_key}",
        "Content-Type": "application/json"
    }

    payload = {
        "model": MODEL,
        "prompt": prompt,
        "width": 512,
        "height": 512,
        "steps": 4,
        "n": 1,
        "response_format": "b64_json"
    }

    response = requests.post(BASE_URL, headers=headers, json=payload, timeout=60)

    if response.status_code != 200:
        raise Exception(f"API Error {response.status_code}: {response.text}")

    result = response.json()

    # Get base64 image data
    if "data" in result and len(result["data"]) > 0:
        import base64
        b64_data = result["data"][0]["b64_json"]
        return base64.b64decode(b64_data)
    else:
        raise Exception(f"Unexpected response format: {result}")


def generate_asset(api_key: str, name: str, config: dict, output_dir: Path) -> bool:
    """Generate a single asset"""
    print(f"\n🎨 Generating: {name}")
    print(f"   Prompt: {config['prompt'][:60]}...")

    try:
        image_data = generate_image(api_key, config["prompt"])

        output_path = output_dir / name
        with open(output_path, "wb") as f:
            f.write(image_data)

        file_size = output_path.stat().st_size / 1024
        print(f"   ✅ Saved: {output_path}")
        print(f"   📊 Size: {file_size:.1f} KB")

        return True

    except Exception as e:
        print(f"   ❌ Error: {e}")
        return False


def main():
    import argparse

    parser = argparse.ArgumentParser(
        description="Generate MCOP Quest assets using Together AI"
    )
    parser.add_argument(
        "--output-dir",
        default="_bmad-output/prototypes/mcop-quest/v2/assets-v2",
        help="Output directory"
    )
    parser.add_argument(
        "--asset",
        choices=list(ASSETS.keys()),
        help="Generate specific asset only"
    )
    parser.add_argument(
        "--delay",
        type=int,
        default=3,
        help="Delay between generations (seconds)"
    )

    args = parser.parse_args()

    api_key = get_api_token()
    output_dir = Path(args.output_dir)
    output_dir.mkdir(parents=True, exist_ok=True)

    print("=" * 60)
    print("🎮 MCOP Quest Asset Generator (Together AI)")
    print("=" * 60)
    print(f"📁 Output: {output_dir.absolute()}")
    print(f"🤖 Model: {MODEL}")

    assets_to_generate = {args.asset: ASSETS[args.asset]} if args.asset else ASSETS

    success_count = 0
    fail_count = 0

    for name, config in assets_to_generate.items():
        if generate_asset(api_key, name, config, output_dir):
            success_count += 1
        else:
            fail_count += 1

        if args.delay > 0 and name != list(assets_to_generate.keys())[-1]:
            print(f"   ⏱️  Waiting {args.delay}s...")
            time.sleep(args.delay)

    print("\n" + "=" * 60)
    print("📊 Generation Summary")
    print("=" * 60)
    print(f"✅ Success: {success_count}")
    print(f"❌ Failed: {fail_count}")

    if fail_count == 0:
        print("\n🎉 All assets generated successfully!")
    else:
        print(f"\n⚠️  {fail_count} asset(s) failed.")
        sys.exit(1)


if __name__ == "__main__":
    main()
