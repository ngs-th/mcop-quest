#!/usr/bin/env python3
"""
Hugging Face Inference API Image Generator for MCOP Quest Assets
Uses free tier models for pixel art generation
"""

import os
import sys
import time
import json
import requests
from pathlib import Path
from typing import Optional

BASE_URL = "https://api-inference.huggingface.co/models"

# Free models that work well for game assets
MODELS = {
    "pixel-art": "ioclab/ioc-controlnet-pxs",
    "sdxl": "stabilityai/stable-diffusion-xl-base-1.0",
    "animagine": "cagliostrolab/animagine-xl-3.1",
}

# Asset definitions for MCOP Quest
ASSETS = {
    "castle.png": {
        "prompt": "pixel art, 16-bit SNES style, majestic medieval castle with red rooftops, stone walls, surrounded by green trees, fantasy RPG game asset, isometric view, detailed, warm colors, brown brick with green foliage",
        "negative": "3d render, realistic, blurry, low quality, modern, photorealistic"
    },
    "task_tower.png": {
        "prompt": "pixel art, 16-bit SNES style, tall wizard tower with spiral stairs, glowing blue magical light at the top, fantasy RPG game asset, isometric view, gray stone with blue magical glow",
        "negative": "3d render, realistic, blurry, low quality, modern, photorealistic"
    },
    "bug_bastion.png": {
        "prompt": "pixel art, 16-bit SNES style, mystical forest dungeon entrance with giant twisted trees, overgrown vines, dark green foliage, mysterious fog, fantasy RPG game asset, isometric view, deep forest greens",
        "negative": "3d render, realistic, blurry, low quality, bright, cheerful"
    },
    "alchemy_lab.png": {
        "prompt": "pixel art, 16-bit SNES style, magical alchemy laboratory with floating purple crystals, glowing magical apparatus, fantasy RPG game asset, isometric view, purple and blue magical lighting",
        "negative": "3d render, realistic, blurry, low quality, modern, photorealistic"
    },
    "community_commons.png": {
        "prompt": "pixel art, 16-bit SNES style, vibrant marketplace town square with colorful tents, stalls, warm lighting, lively atmosphere, fantasy RPG game asset, isometric view, warm oranges and yellows",
        "negative": "3d render, realistic, blurry, low quality, dark, gloomy"
    },
    "payment_fortress.png": {
        "prompt": "pixel art, 16-bit SNES style, dark ominous fortress with storm clouds, lightning, volcanic rocks, lava cracks, fantasy RPG game asset, isometric view, dark blacks with fiery reds and oranges",
        "negative": "3d render, realistic, blurry, low quality, bright, cheerful, modern"
    }
}


def get_api_token() -> str:
    """Get Hugging Face API token from environment"""
    token = os.environ.get("HF_API_TOKEN")
    if not token:
        print("❌ Error: HF_API_TOKEN not set!")
        print("\nGet your token from: https://huggingface.co/settings/tokens")
        print("Then run: export HF_API_TOKEN='your_token_here'")
        sys.exit(1)
    return token


def generate_image_hf(api_token: str, prompt: str, negative_prompt: str = "",
                      model: str = "stabilityai/stable-diffusion-xl-base-1.0") -> bytes:
    """Generate image using Hugging Face Inference API"""

    headers = {
        "Authorization": f"Bearer {api_token}",
        "Content-Type": "application/json"
    }

    # Payload for text-to-image
    payload = {
        "inputs": prompt,
        "parameters": {
            "negative_prompt": negative_prompt,
            "num_inference_steps": 30,
            "guidance_scale": 7.5,
            "width": 512,
            "height": 512
        }
    }

    # Try primary model first
    url = f"{BASE_URL}/{model}"
    response = requests.post(url, headers=headers, json=payload, timeout=120)

    # If model is loading, wait and retry
    if response.status_code == 503:
        print("   ⏳ Model is loading, waiting...")
        time.sleep(20)
        response = requests.post(url, headers=headers, json=payload, timeout=120)

    if response.status_code == 200:
        return response.content
    else:
        raise Exception(f"API Error {response.status_code}: {response.text}")


def generate_asset(api_token: str, name: str, config: dict, output_dir: Path,
                   model: str = "stabilityai/stable-diffusion-xl-base-1.0") -> bool:
    """Generate a single asset"""
    print(f"\n🎨 Generating: {name}")
    print(f"   Prompt: {config['prompt'][:60]}...")

    try:
        # Generate image
        image_data = generate_image_hf(
            api_token,
            config["prompt"],
            config.get("negative", ""),
            model
        )

        # Save image
        output_path = output_dir / name
        with open(output_path, "wb") as f:
            f.write(image_data)

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
        description="Generate MCOP Quest assets using Hugging Face API"
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
        default=5,
        help="Delay between generations (seconds)"
    )
    parser.add_argument(
        "--model",
        choices=list(MODELS.keys()),
        default="animagine",
        help="Model to use for generation"
    )

    args = parser.parse_args()

    # Setup
    api_token = get_api_token()
    output_dir = Path(args.output_dir)
    output_dir.mkdir(parents=True, exist_ok=True)

    model_name = MODELS[args.model]

    print("=" * 60)
    print("🎮 MCOP Quest Asset Generator (Hugging Face API)")
    print("=" * 60)
    print(f"📁 Output: {output_dir.absolute()}")
    print(f"🤖 Model: {args.model} ({model_name})")

    # Select assets to generate
    assets_to_generate = {args.asset: ASSETS[args.asset]} if args.asset else ASSETS

    # Generate assets
    success_count = 0
    fail_count = 0

    for name, config in assets_to_generate.items():
        if generate_asset(api_token, name, config, output_dir, model_name):
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
