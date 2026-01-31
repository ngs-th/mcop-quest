#!/usr/bin/env python3
"""
Google Cloud Vertex AI Image Generator for MCOP Quest Assets
Uses Imagen model for high-quality image generation
"""

import os
import sys
import time
import json
import base64
from pathlib import Path
from typing import Optional

# Try to import google cloud libraries
try:
    from google.cloud import aiplatform
    from google.protobuf import json_format
    from google.protobuf.struct_pb2 import Value
    HAS_VERTEX = True
except ImportError:
    HAS_VERTEX = False

# Asset definitions for MCOP Quest
ASSETS = {
    "castle.png": {
        "prompt": "A majestic medieval fantasy castle with red rooftops, stone walls, surrounded by lush green trees. Isometric pixel art RPG style, detailed fantasy game asset, warm colors with brown brick and green foliage. Clean pixel art aesthetic, 16-bit SNES style.",
    },
    "task_tower.png": {
        "prompt": "A tall wizard tower with spiral stairs and glowing blue magical light at the top. Isometric pixel art RPG style, gray stone with blue magical glow, fantasy game asset. Detailed pixel art, 16-bit SNES style.",
    },
    "bug_bastion.png": {
        "prompt": "A mystical forest dungeon entrance with giant twisted trees, overgrown vines, dark green foliage, and mysterious fog. Isometric pixel art RPG style, deep forest greens and earthy browns, fantasy game asset. 16-bit SNES style.",
    },
    "alchemy_lab.png": {
        "prompt": "A magical alchemy laboratory with floating purple crystals and glowing magical apparatus. Isometric pixel art RPG style, purple and blue magical lighting, fantasy game asset. Detailed pixel art, 16-bit SNES style.",
    },
    "community_commons.png": {
        "prompt": "A vibrant marketplace town square with colorful tents, stalls, and warm lighting. Isometric pixel art RPG style, warm oranges and yellows, lively atmosphere, fantasy game asset. 16-bit SNES style.",
    },
    "payment_fortress.png": {
        "prompt": "A dark ominous fortress with storm clouds, lightning strikes, volcanic rocks, and lava cracks. Isometric pixel art RPG style, dark blacks with fiery reds and oranges, dangerous atmosphere. 16-bit SNES style.",
    }
}


def check_vertex_sdk():
    """Check if Vertex AI SDK is installed"""
    if not HAS_VERTEX:
        print("❌ Error: Google Cloud Vertex AI SDK not installed!")
        print("\nInstall with:")
        print("  pip install google-cloud-aiplatform")
        print("\nOr:")
        print("  pip install google-cloud-aiplatform protobuf")
        sys.exit(1)


def get_gcp_config():
    """Get GCP configuration from environment"""
    project_id = os.environ.get("GOOGLE_CLOUD_PROJECT")
    location = os.environ.get("GOOGLE_CLOUD_LOCATION", "us-central1")

    if not project_id:
        print("❌ Error: GOOGLE_CLOUD_PROJECT not set!")
        print("\nSet with:")
        print("  export GOOGLE_CLOUD_PROJECT='your-project-id'")
        print("  export GOOGLE_CLOUD_LOCATION='us-central1'")
        sys.exit(1)

    # Check for credentials
    credentials = os.environ.get("GOOGLE_APPLICATION_CREDENTIALS")
    if not credentials:
        print("⚠️  Warning: GOOGLE_APPLICATION_CREDENTIALS not set")
        print("Make sure you're authenticated with:")
        print("  gcloud auth application-default login")
        print("Or set the service account key:")
        print("  export GOOGLE_APPLICATION_CREDENTIALS='/path/to/key.json'")

    return project_id, location


def generate_image_vertex(project_id: str, location: str, prompt: str) -> bytes:
    """Generate image using Vertex AI Imagen"""

    # Initialize Vertex AI
    aiplatform.init(project=project_id, location=location)

    # Get the model
    model = aiplatform.ImageGenerationModel.from_pretrained("imagegeneration@006")

    # Generate image
    response = model.generate_images(
        prompt=prompt,
        number_of_images=1,
        aspect_ratio="1:1",
        safety_filter_level="block_some",
        person_generation="allow_adult",
    )

    # Get image bytes
    if response and len(response.images) > 0:
        image = response.images[0]
        # Image is already bytes
        if hasattr(image, '_as_base64_string'):
            return base64.b64decode(image._as_base64_string())
        elif hasattr(image, '_image_bytes'):
            return image._image_bytes
        else:
            # Try to get raw bytes
            return image._raw_image
    else:
        raise Exception("No image generated")


def generate_asset(project_id: str, location: str, name: str, config: dict, output_dir: Path) -> bool:
    """Generate a single asset"""
    print(f"\n🎨 Generating: {name}")
    print(f"   Prompt: {config['prompt'][:60]}...")

    try:
        image_data = generate_image_vertex(project_id, location, config["prompt"])

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


def generate_with_rest_api(project_id: str, location: str, prompt: str) -> bytes:
    """Alternative: Use REST API directly"""
    import requests

    # Get access token
    import subprocess
    result = subprocess.run(
        ["gcloud", "auth", "print-access-token"],
        capture_output=True,
        text=True
    )

    if result.returncode != 0:
        raise Exception("Failed to get access token. Run: gcloud auth login")

    access_token = result.stdout.strip()

    url = f"https://{location}-aiplatform.googleapis.com/v1/projects/{project_id}/locations/{location}/publishers/google/models/imagen-3.0-generate-002:predict"

    headers = {
        "Authorization": f"Bearer {access_token}",
        "Content-Type": "application/json"
    }

    payload = {
        "instances": [
            {
                "prompt": prompt
            }
        ],
        "parameters": {
            "sampleCount": 1,
            "aspectRatio": "1:1",
            "personGeneration": "dont_allow",
            "safetySetting": "block_some"
        }
    }

    response = requests.post(url, headers=headers, json=payload)

    if response.status_code != 200:
        raise Exception(f"API Error {response.status_code}: {response.text}")

    result = response.json()

    # Extract base64 image
    if "predictions" in result and len(result["predictions"]) > 0:
        image_b64 = result["predictions"][0].get("bytesBase64Encoded")
        if image_b64:
            return base64.b64decode(image_b64)

    raise Exception(f"Unexpected response: {result}")


def main():
    import argparse

    parser = argparse.ArgumentParser(
        description="Generate MCOP Quest assets using Google Cloud Vertex AI"
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
        default=2,
        help="Delay between generations (seconds)"
    )
    parser.add_argument(
        "--use-rest",
        action="store_true",
        help="Use REST API instead of Python SDK"
    )

    args = parser.parse_args()

    # Setup
    if not args.use_rest:
        check_vertex_sdk()

    project_id, location = get_gcp_config()
    output_dir = Path(args.output_dir)
    output_dir.mkdir(parents=True, exist_ok=True)

    print("=" * 60)
    print("🎮 MCOP Quest Asset Generator (Google Cloud Vertex AI)")
    print("=" * 60)
    print(f"📁 Output: {output_dir.absolute()}")
    print(f"☁️  Project: {project_id}")
    print(f"📍 Location: {location}")
    print(f"🔧 Method: {'REST API' if args.use_rest else 'Python SDK'}")

    assets_to_generate = {args.asset: ASSETS[args.asset]} if args.asset else ASSETS

    success_count = 0
    fail_count = 0

    for name, config in assets_to_generate.items():
        if args.use_rest:
            # Use REST API
            try:
                print(f"\n🎨 Generating: {name}")
                print(f"   Prompt: {config['prompt'][:60]}...")

                image_data = generate_with_rest_api(project_id, location, config["prompt"])

                output_path = output_dir / name
                with open(output_path, "wb") as f:
                    f.write(image_data)

                file_size = output_path.stat().st_size / 1024
                print(f"   ✅ Saved: {output_path}")
                print(f"   📊 Size: {file_size:.1f} KB")
                success_count += 1

            except Exception as e:
                print(f"   ❌ Error: {e}")
                fail_count += 1
        else:
            # Use Python SDK
            if generate_asset(project_id, location, name, config, output_dir):
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
