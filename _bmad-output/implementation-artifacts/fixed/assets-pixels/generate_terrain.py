#!/usr/bin/env python3
"""Generate pixel art terrain assets for MCOP Quest"""
from PIL import Image, ImageDraw
import os

def create_noise_pattern(width, height, base_color, noise_intensity=20):
    """Create textured noise pattern"""
    img = Image.new('RGBA', (width, height), base_color)
    pixels = img.load()
    import random
    random.seed(42)  # Consistent pattern
    for y in range(height):
        for x in range(width):
            r, g, b, a = pixels[x, y]
            noise = random.randint(-noise_intensity, noise_intensity)
            pixels[x, y] = (
                max(0, min(255, r + noise)),
                max(0, min(255, g + noise)),
                max(0, min(255, b + noise)),
                a
            )
    return img

def create_water_tile():
    """Create water tile with waves"""
    img = Image.new('RGBA', (64, 64), (64, 164, 223, 255))
    draw = ImageDraw.Draw(img)
    # Add wave patterns
    for y in range(8, 64, 16):
        for x in range(0, 64, 8):
            draw.line([(x, y), (x+4, y)], fill=(100, 200, 255, 180), width=2)
    return img

def create_grass_tile():
    """Create grass tile"""
    base = create_noise_pattern(64, 64, (76, 175, 80, 255), 25)
    draw = ImageDraw.Draw(base)
    # Add grass details
    for i in range(20):
        x, y = (i * 7) % 60 + 2, (i * 13) % 60 + 2
        draw.line([(x, y), (x, y-3)], fill=(100, 200, 100, 255), width=1)
    return base

def create_mountain():
    """Create isometric mountain"""
    img = Image.new('RGBA', (128, 96), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Mountain base (isometric diamond)
    base_points = [(64, 48), (112, 72), (64, 96), (16, 72)]
    draw.polygon(base_points, fill=(120, 120, 120, 255))

    # Left face (shadow)
    left_face = [(64, 48), (16, 72), (64, 96), (64, 48)]
    draw.polygon(left_face, fill=(100, 100, 100, 255))

    # Right face (light)
    right_face = [(64, 48), (112, 72), (64, 96), (64, 48)]
    draw.polygon(right_face, fill=(140, 140, 140, 255))

    # Peak (snow)
    peak_points = [(64, 16), (80, 48), (64, 56), (48, 48)]
    draw.polygon(peak_points, fill=(255, 255, 255, 255))

    # Left peak face
    left_peak = [(64, 16), (48, 48), (64, 56)]
    draw.polygon(left_peak, fill=(220, 220, 220, 255))

    # Right peak face
    right_peak = [(64, 16), (80, 48), (64, 56)]
    draw.polygon(right_peak, fill=(255, 255, 255, 255))

    return img

def create_island():
    """Create small island with crystals"""
    img = Image.new('RGBA', (96, 64), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Island base
    draw.ellipse([8, 24, 88, 56], fill=(139, 195, 74, 255))
    draw.ellipse([12, 20, 84, 52], fill=(76, 175, 80, 255))

    # Crystals
    crystals = [(30, 15), (50, 10), (70, 18)]
    for x, y in crystals:
        # Crystal glow
        draw.ellipse([x-8, y-4, x+8, y+12], fill=(0, 255, 255, 100))
        # Crystal body
        draw.polygon([(x, y), (x-4, y+12), (x, y+16), (x+4, y+12)], fill=(0, 200, 255, 255))

    return img

def create_bridge():
    """Create wooden bridge"""
    img = Image.new('RGBA', (96, 32), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Bridge planks
    for x in range(4, 92, 12):
        draw.rectangle([x, 8, x+8, 24], fill=(160, 110, 60, 255))
        # Nails
        draw.ellipse([x+2, 10, x+4, 12], fill=(100, 70, 40, 255))
        draw.ellipse([x+4, 20, x+6, 22], fill=(100, 70, 40, 255))

    # Bridge rails
    draw.rectangle([0, 4, 96, 8], fill=(140, 90, 50, 255))
    draw.rectangle([0, 24, 96, 28], fill=(140, 90, 50, 255))

    return img

def main():
    os.makedirs('terrain', exist_ok=True)

    create_water_tile().save('terrain/water.png')
    create_grass_tile().save('terrain/grass.png')
    create_mountain().save('terrain/mountain.png')
    create_island().save('terrain/island.png')
    create_bridge().save('terrain/bridge.png')

    print("Terrain assets generated!")

if __name__ == '__main__':
    main()
