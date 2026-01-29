#!/usr/bin/env python3
"""Generate LARGE pixel art terrain assets for MCOP Quest"""

import os
import random

from PIL import Image, ImageDraw


def create_water_tile():
    """Create water tile with waves - LARGE"""
    img = Image.new("RGBA", (128, 128), (64, 164, 223, 255))
    draw = ImageDraw.Draw(img)
    # Add wave patterns
    for y in range(16, 128, 32):
        for x in range(0, 128, 16):
            draw.line([(x, y), (x + 8, y)], fill=(100, 200, 255, 180), width=3)
    return img


def create_grass_tile():
    """Create grass tile - LARGE"""
    img = Image.new("RGBA", (128, 128), (76, 175, 80, 255))
    draw = ImageDraw.Draw(img)
    # Add grass details
    for i in range(40):
        x = random.randint(4, 124)
        y = random.randint(4, 124)
        draw.line([(x, y), (x, y - 6)], fill=(100, 200, 100, 255), width=2)
    return img


def create_mountain():
    """Create isometric mountain - LARGE"""
    img = Image.new("RGBA", (256, 192), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Mountain base (isometric diamond)
    base_points = [(128, 96), (224, 144), (128, 192), (32, 144)]
    draw.polygon(base_points, fill=(120, 120, 120, 255))

    # Left face (shadow)
    left_face = [(128, 96), (32, 144), (128, 192), (128, 96)]
    draw.polygon(left_face, fill=(100, 100, 100, 255))

    # Right face (light)
    right_face = [(128, 96), (224, 144), (128, 192), (128, 96)]
    draw.polygon(right_face, fill=(140, 140, 140, 255))

    # Peak (snow)
    peak_points = [(128, 32), (160, 96), (128, 112), (96, 96)]
    draw.polygon(peak_points, fill=(255, 255, 255, 255))

    # Left peak face
    left_peak = [(128, 32), (96, 96), (128, 112)]
    draw.polygon(left_peak, fill=(220, 220, 220, 255))

    # Right peak face
    right_peak = [(128, 32), (160, 96), (128, 112)]
    draw.polygon(right_peak, fill=(255, 255, 255, 255))

    return img


def create_island():
    """Create small island with crystals - LARGE"""
    img = Image.new("RGBA", (192, 128), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Island base
    draw.ellipse([16, 48, 176, 112], fill=(139, 195, 74, 255))
    draw.ellipse([24, 40, 168, 104], fill=(76, 175, 80, 255))

    # Crystals (larger)
    crystals = [(60, 30), (100, 20), (140, 36)]
    for x, y in crystals:
        # Crystal glow
        draw.ellipse([x - 16, y - 8, x + 16, y + 24], fill=(0, 255, 255, 100))
        # Crystal body
        draw.polygon(
            [(x, y), (x - 8, y + 24), (x, y + 32), (x + 8, y + 24)],
            fill=(0, 200, 255, 255),
        )
        draw.polygon([(x, y), (x - 8, y + 24), (x, y + 32)], fill=(0, 160, 200, 255))

    return img


def create_bridge():
    """Create wooden bridge - LARGE"""
    img = Image.new("RGBA", (192, 64), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Bridge planks
    for x in range(8, 184, 24):
        draw.rectangle([x, 16, x + 16, 48], fill=(160, 110, 60, 255))
        # Nails
        draw.ellipse([x + 4, 20, x + 8, 24], fill=(100, 70, 40, 255))
        draw.ellipse([x + 8, 40, x + 12, 44], fill=(100, 70, 40, 255))

    # Bridge rails
    draw.rectangle([0, 8, 192, 16], fill=(140, 90, 50, 255))
    draw.rectangle([0, 48, 192, 56], fill=(140, 90, 50, 255))

    return img


def main():
    random.seed(42)  # Consistent pattern
    os.makedirs("terrain", exist_ok=True)

    create_water_tile().save("terrain/water.png")
    create_grass_tile().save("terrain/grass.png")
    create_mountain().save("terrain/mountain.png")
    create_island().save("terrain/island.png")
    create_bridge().save("terrain/bridge.png")

    print("LARGE Terrain assets generated!")


if __name__ == "__main__":
    main()
