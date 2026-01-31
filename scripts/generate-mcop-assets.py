#!/usr/bin/env python3
"""
Replicate API Image Generator for MCOP Quest Assets
Uses flux-pixel-art model for consistent RPG pixel art style
"""

import os
import sys
import time
import json
import requests
from pathlib import Path
from typing import Optional

# Model configuration
# Using black-forest-labs/flux-schnell (fast and cheap)
MODEL_VERSION = "c846a69991daf4c0e5d016514849d14ee5b2e6846ce6b9d6f21369e564cfe51e"  # flux-schnell
BASE_URL = "https://api.replicate.com/v1"

# Asset definitions for MCOP Quest
ASSETS = {
    "castle.png": {
        "prompt": "A majestic medieval castle with red rooftops, stone walls, surrounded by green trees. Pixel art RPG style, isometric view, detailed fantasy game asset, warm colors, brown brick with green foliage",
        "width": 512,
        "height": 512
    },
    "task_tower.png": {
        "prompt": "A tall wizard tower with spiral stairs, glowing blue magical light at the top. Pixel art RPG style, isometric view, gray stone with blue magical glow, fantasy game asset",
        "width": 512,
        "height": 512
    },
    "bug_bastion.png": {
        "prompt": "A mystical forest dungeon entrance with giant twisted trees, overgrown vines, dark green foliage, mysterious fog. Pixel art RPG style, isometric view, deep forest greens and earthy browns",
        "width": 512,
        "height": 512
    },
    "alchemy_lab.png": {
        "prompt": "A magical alchemy laboratory with floating purple crystals, glowing magical apparatus. Pixel art RPG style, isometric view, purple and blue magical lighting, fantasy game asset",
        "width": 512,
        "height": 512
    },
    "community_commons.png": {
        "prompt": "A vibrant marketplace town square with colorful tents, stalls, warm lighting, lively atmosphere. Pixel art RPG style, isometric view, warm oranges and yellows, cheerful fantasy game asset",
        "width": 512,
        "height": 512
    },
    "payment_fortress.png": {
        "prompt": "A dark ominous fortress with storm clouds, lightning, volcanic rocks, lava cracks. Pixel art RPG style, isometric view, dark blacks with fiery reds and oranges, dangerous atmosphere",
        "width": 512,
        "height": 512
    }
}


def get_api_token() -> str:
    """Get Replicate API token from environment"""
    token = os.environ.get("REPLICATE_API_TOKEN")
    if not token:
        print("❌ Error: REPLICATE_API_TOKEN not set!")
        print("\nGet your token from: https://replicate.com/account/api-tokens")
        print("Then run: export REPLICATE_API_TOKEN='your_token_here'")
        sys.exit(1)
    return token


def create_prediction(api_token: str, prompt: str, width: int, height: int) -> dict:
    """Create a new prediction on Replicate"""
    headers = {
        "Authorization": f"Token {api_token}",
        "Content-Type": "application/json"
    }

    data = {
        "version": MODEL_VERSION,
        "input": {
            "prompt": f"pixel art RPG style: {prompt}",
            "aspect_ratio": "1:1",
            "output_format": "png",
            "output_quality": 100,
            "num_inference_steps": 4,
            "go_fast": True
        }
    }

    response = requests.post(
        f"{BASE_URL}/predictions",
        headers=headers,
        json=data
    )

    if response.status_code != 201:
        print(f"❌ Failed to create prediction: {response.text}")
        raise Exception(f"API Error: {response.status_code}")

    return response.json()


def poll_prediction(api_token: str, prediction_id: str, max_attempts: int = 60) -> dict:
    """Poll for prediction completion"""
    headers = {"Authorization": f"Token {api_token}"}

    for attempt in range(max_attempts):
        response = requests.get(
            f"{BASE_URL}/predictions/{prediction_id}",
            headers=headers
        )

        result = response.json()
        status = result.get("status")

        if status == "succeeded":
            return result
        elif status == "failed":
            raise Exception(f"Prediction failed: {result.get('error')}")

        if attempt % 5 == 0:
            print(f"   ⏳ Still generating... ({attempt}/{max_attempts})")

        time.sleep(2)

    raise Exception("Prediction timed out")


def download_image(url: str, output_path: Path) -> None:
    """Download image from URL to file"""
    response = requests.get(url, stream=True)
    response.raise_for_status()

    with open(output_path, "wb") as f:
        for chunk in response.iter_content(chunk_size=8192):
            f.write(chunk)


def generate_asset(api_token: str, name: str, config: dict, output_dir: Path) -> bool:
    """Generate a single asset"""
    print(f"\n🎨 Generating: {name}")
    print(f"   Prompt: {config['prompt'][:60]}...")

    try:
        # Create prediction
        prediction = create_prediction(
            api_token,
            config["prompt"],
            config["width"],
            config["height"]
        )

        prediction_id = prediction["id"]
        print(f"   📝 Prediction ID: {prediction_id}")

        # Poll for completion
        result = poll_prediction(api_token, prediction_id)

        # Get output URL (flux-pixel-art returns a single URL)
        output_url = result.get("output")
        if isinstance(output_url, list):
            output_url = output_url[0]

        if not output_url:
            print(f"   ❌ No output URL in result")
            return False

        # Download image
        output_path = output_dir / name
        download_image(output_url, output_path)

        # Get file info
        file_size = output_path.stat().st_size / 1024  # KB
        print(f"   ✅ Saved: {output_path}")
        print(f"   📊 Size: {file_size:.1f} KB")

        return True

    except Exception as e:
        print(f"   ❌ Error: {e}")
        return False


def main():
    """Main entry point"""
    import argparse

    parser = argparse.ArgumentParser(
        description="Generate MCOP Quest assets using Replicate API"
    )
    parser.add_argument(
        "--output-dir",
        default="_bmad-output/prototypes/mcop-quest/v2/assets-v2",
        help="Output directory for generated images"
    )
    parser.add_argument(
        "--asset",
        choices=list(ASSETS.keys()),
        help="Generate specific asset only"
    )
    parser.add_argument(
        "--delay",
        type=int,
        default=0,
        help="Delay between generations (seconds)"
    )

    args = parser.parse_args()

    # Setup
    api_token = get_api_token()
    output_dir = Path(args.output_dir)
    output_dir.mkdir(parents=True, exist_ok=True)

    print("=" * 60)
    print("🎮 MCOP Quest Asset Generator (Replicate API)")
    print("=" * 60)
    print(f"📁 Output: {output_dir.absolute()}")
    print(f"🤖 Model: flux-pixel-art")

    # Select assets to generate
    assets_to_generate = {args.asset: ASSETS[args.asset]} if args.asset else ASSETS

    # Generate assets
    success_count = 0
    fail_count = 0

    for name, config in assets_to_generate.items():
        if generate_asset(api_token, name, config, output_dir):
            success_count += 1
        else:
            fail_count += 1

        # Delay between requests
        if args.delay > 0 and name != list(assets_to_generate.keys())[-1]:
            print(f"   ⏱️  Waiting {args.delay}s...")
            time.sleep(args.delay)

    # Summary
    print("\n" + "=" * 60)
    print("📊 Generation Summary")
    print("=" * 60)
    print(f"✅ Success: {success_count}")
    print(f"❌ Failed: {fail_count}")

    if fail_count == 0:
        print("\n🎉 All assets generated successfully!")
    else:
        print(f"\n⚠️  {fail_count} asset(s) failed. Check logs above.")
        sys.exit(1)


if __name__ == "__main__":
    main()
