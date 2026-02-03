#!/usr/bin/env python3
"""Generate pixel art structure/building assets for MCOP Quest"""

import os

from PIL import Image, ImageDraw


def create_main_castle():
    """Create main castle (Member City System Module)"""
    img = Image.new("RGBA", (160, 140), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Base platform
    base_points = [(80, 80), (140, 110), (80, 140), (20, 110)]
    draw.polygon(base_points, fill=(100, 100, 110, 255))

    # Main keep
    keep_base = [(80, 50), (110, 65), (80, 80), (50, 65)]
    draw.polygon(keep_base, fill=(140, 140, 150, 255))
    draw.polygon([(80, 50), (50, 65), (80, 80)], fill=(120, 120, 130, 255))
    draw.polygon([(80, 50), (110, 65), (80, 80)], fill=(160, 160, 170, 255))

    # Keep roof
    draw.polygon([(80, 35), (95, 50), (80, 58), (65, 50)], fill=(66, 133, 244, 255))

    # Left tower
    draw.polygon([(50, 55), (35, 72), (50, 79), (65, 72)], fill=(130, 130, 140, 255))
    draw.polygon([(50, 45), (60, 55), (50, 62), (40, 55)], fill=(200, 80, 80, 255))

    # Right tower
    draw.polygon([(110, 55), (95, 72), (110, 79), (125, 72)], fill=(140, 140, 150, 255))
    draw.polygon([(110, 45), (120, 55), (110, 62), (100, 55)], fill=(200, 80, 80, 255))

    # Gate
    draw.arc([65, 70, 95, 100], start=0, end=180, fill=(60, 60, 70, 255), width=3)

    # Flags
    for fx, fy in [(50, 40), (110, 40), (80, 30)]:
        draw.line([(fx, fy), (fx, fy - 15)], fill=(180, 140, 80, 255), width=2)
        draw.polygon(
            [(fx, fy - 15), (fx + 12, fy - 10), (fx, fy - 5)], fill=(66, 133, 244, 255)
        )

    return img


def create_task_tower():
    """Create floating Task Tower"""
    img = Image.new("RGBA", (128, 160), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Floating island base
    island_points = [(64, 120), (110, 140), (64, 160), (18, 140)]
    draw.polygon(island_points, fill=(139, 110, 75, 255))

    # Energy beam
    draw.polygon([(60, 118), (68, 118), (66, 90), (62, 90)], fill=(100, 200, 255, 100))

    # Tower
    draw.polygon([(64, 70), (90, 82), (64, 95), (38, 82)], fill=(160, 130, 100, 255))
    draw.polygon([(64, 50), (85, 60), (64, 70), (43, 60)], fill=(170, 140, 110, 255))
    draw.polygon([(64, 35), (80, 43), (64, 50), (48, 43)], fill=(150, 120, 90, 255))

    # Roof
    draw.polygon([(64, 25), (75, 35), (64, 42), (53, 35)], fill=(100, 80, 60, 255))

    # Crystal
    draw.polygon([(64, 15), (68, 25), (64, 30), (60, 25)], fill=(0, 200, 255, 255))

    return img


def create_alchemy_lab():
    """Create Analytics Alchemy Lab"""
    img = Image.new("RGBA", (120, 120), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Base
    draw.polygon([(60, 70), (100, 90), (60, 110), (20, 90)], fill=(100, 100, 120, 255))

    # Magic circle
    draw.ellipse([30, 75, 90, 105], outline=(150, 100, 255, 150), width=2)

    # Building
    draw.polygon([(60, 50), (85, 62), (60, 75), (35, 62)], fill=(80, 80, 120, 255))

    # Windows
    for wx, wy in [(50, 58), (60, 62), (70, 58)]:
        draw.rectangle([wx - 3, wy - 4, wx + 3, wy + 4], fill=(150, 200, 255, 255))

    # Floating book
    draw.polygon([(75, 35), (95, 40), (90, 50), (70, 45)], fill=(139, 90, 43, 255))

    return img


def create_payment_fortress():
    """Create dark Payment Fortress"""
    img = Image.new("RGBA", (140, 160), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Storm cloud
    draw.polygon([(70, 120), (120, 140), (70, 160), (20, 140)], fill=(60, 60, 80, 255))

    # Lightning
    draw.polygon([(70, 100), (75, 120), (70, 130), (65, 120)], fill=(255, 200, 50, 200))

    # Fortress
    draw.polygon([(70, 60), (100, 75), (70, 90), (40, 75)], fill=(40, 40, 50, 255))

    # Towers
    for tx, ty in [(50, 45), (90, 45)]:
        draw.polygon(
            [(tx, ty), (tx + 8, ty + 10), (tx, ty + 15), (tx - 8, ty + 10)],
            fill=(35, 35, 45, 255),
        )

    # Keep
    draw.polygon([(70, 30), (78, 40), (70, 45), (62, 40)], fill=(60, 20, 20, 255))

    # Warning skull
    draw.ellipse([65, 65, 75, 75], fill=(255, 255, 255, 255))

    return img


def create_community_commons():
    """Create Community Commons - camp area"""
    img = Image.new("RGBA", (120, 100), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Ground
    draw.polygon([(60, 50), (100, 70), (60, 90), (20, 70)], fill=(210, 180, 140, 255))

    # Main tent
    draw.polygon([(60, 45), (80, 55), (60, 65), (40, 55)], fill=(210, 130, 80, 255))
    draw.polygon([(60, 30), (75, 45), (60, 52), (45, 45)], fill=(240, 160, 110, 255))

    # Small tents
    for tx, ty in [(35, 60), (85, 60)]:
        draw.polygon(
            [(tx, ty), (tx + 10, ty + 8), (tx, ty + 12), (tx - 10, ty + 8)],
            fill=(200, 140, 90, 255),
        )

    # Campfire
    draw.polygon([(60, 70), (65, 80), (60, 85), (55, 80)], fill=(255, 100, 50, 200))

    return img


def create_bug_bastion():
    """Create Bug Bastion - forest fort"""
    img = Image.new("RGBA", (128, 120), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Forest ground
    draw.polygon([(64, 60), (108, 82), (64, 104), (20, 82)], fill=(76, 140, 74, 255))

    # Trees
    for tx, ty in [(40, 50), (90, 55), (55, 40)]:
        draw.polygon(
            [(tx, ty - 20), (tx + 20, ty), (tx, ty + 10), (tx - 20, ty)],
            fill=(76, 175, 80, 255),
        )

    # Fort
    draw.polygon([(64, 55), (84, 65), (64, 75), (44, 65)], fill=(139, 110, 75, 255))

    return img


def main():
    os.makedirs("structures", exist_ok=True)

    create_main_castle().save("structures/main_castle.png")
    create_task_tower().save("structures/task_tower.png")
    create_alchemy_lab().save("structures/alchemy_lab.png")
    create_payment_fortress().save("structures/payment_fortress.png")
    create_community_commons().save("structures/community_commons.png")
    create_bug_bastion().save("structures/bug_bastion.png")

    print("Structure assets generated!")


if __name__ == "__main__":
    main()
