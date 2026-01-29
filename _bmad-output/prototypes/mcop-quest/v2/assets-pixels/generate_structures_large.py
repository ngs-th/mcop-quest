#!/usr/bin/env python3
"""Generate LARGE pixel art structure/building assets for MCOP Quest"""

import os

from PIL import Image, ImageDraw


def create_main_castle():
    """Create main castle (Member City System Module) - LARGE"""
    img = Image.new("RGBA", (320, 280), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Base platform (isometric diamond)
    base_points = [(160, 160), (280, 220), (160, 280), (40, 220)]
    draw.polygon(base_points, fill=(100, 100, 110, 255))

    # Main keep (center tower)
    keep_base = [(160, 100), (220, 130), (160, 160), (100, 130)]
    draw.polygon(keep_base, fill=(140, 140, 150, 255))
    draw.polygon([(160, 100), (100, 130), (160, 160)], fill=(120, 120, 130, 255))
    draw.polygon([(160, 100), (220, 130), (160, 160)], fill=(160, 160, 170, 255))

    # Keep roof (blue)
    draw.polygon(
        [(160, 70), (190, 100), (160, 116), (130, 100)], fill=(66, 133, 244, 255)
    )
    draw.polygon([(160, 70), (130, 100), (160, 116)], fill=(50, 110, 220, 255))

    # Left tower
    draw.polygon(
        [(100, 110), (70, 144), (100, 158), (130, 144)], fill=(130, 130, 140, 255)
    )
    draw.polygon(
        [(100, 90), (120, 110), (100, 124), (80, 110)], fill=(200, 80, 80, 255)
    )

    # Right tower
    draw.polygon(
        [(220, 110), (190, 144), (220, 158), (250, 144)], fill=(140, 140, 150, 255)
    )
    draw.polygon(
        [(220, 90), (240, 110), (220, 124), (200, 110)], fill=(200, 80, 80, 255)
    )

    # Gate arch
    draw.arc([130, 140, 190, 200], start=0, end=180, fill=(60, 60, 70, 255), width=4)

    # Flags on towers
    for fx, fy in [(100, 80), (220, 80), (160, 60)]:
        draw.line([(fx, fy), (fx, fy - 30)], fill=(180, 140, 80, 255), width=3)
        draw.polygon(
            [(fx, fy - 30), (fx + 24, fy - 20), (fx, fy - 10)], fill=(66, 133, 244, 255)
        )

    # Windows on keep
    for wx in [130, 160, 190]:
        draw.rectangle([wx - 5, 125, wx + 5, 145], fill=(100, 150, 200, 255))

    return img


def create_task_tower():
    """Create floating Task Tower - LARGE"""
    img = Image.new("RGBA", (256, 320), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Floating island base
    island_points = [(128, 240), (220, 280), (128, 320), (36, 280)]
    draw.polygon(island_points, fill=(139, 110, 75, 255))
    draw.polygon([(128, 240), (36, 280), (128, 320)], fill=(120, 95, 65, 255))
    draw.polygon([(128, 240), (220, 280), (128, 320)], fill=(160, 130, 90, 255))

    # Grass on island
    draw.ellipse([60, 250, 196, 310], fill=(100, 160, 80, 255))

    # Energy beam (glowing)
    for i, alpha in enumerate([150, 100, 50]):
        offset = i * 8
        draw.polygon(
            [
                (120 - offset, 238),
                (136 + offset, 238),
                (132 + offset, 180),
                (124 - offset, 180),
            ],
            fill=(100, 200, 255, alpha),
        )

    # Tower base
    draw.polygon(
        [(128, 140), (180, 164), (128, 190), (76, 164)], fill=(160, 130, 100, 255)
    )
    draw.polygon([(128, 140), (76, 164), (128, 190)], fill=(140, 110, 80, 255))
    draw.polygon([(128, 140), (180, 164), (128, 190)], fill=(180, 150, 120, 255))

    # Tower mid section
    draw.polygon(
        [(128, 100), (170, 120), (128, 140), (86, 120)], fill=(170, 140, 110, 255)
    )

    # Tower top
    draw.polygon([(128, 70), (160, 86), (128, 100), (96, 86)], fill=(150, 120, 90, 255))

    # Roof
    draw.polygon([(128, 50), (150, 70), (128, 84), (106, 70)], fill=(100, 80, 60, 255))

    # Crystal on top (glowing)
    draw.polygon([(128, 30), (136, 50), (128, 60), (120, 50)], fill=(0, 200, 255, 255))
    draw.polygon([(128, 30), (128, 60), (120, 50)], fill=(0, 160, 200, 255))

    # Crystal glow
    draw.ellipse([100, 20, 156, 70], outline=(0, 200, 255, 100), width=2)

    return img


def create_alchemy_lab():
    """Create Analytics Alchemy Lab - LARGE"""
    img = Image.new("RGBA", (240, 240), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Base platform with magic circle
    base_points = [(120, 140), (200, 180), (120, 220), (40, 180)]
    draw.polygon(base_points, fill=(100, 100, 120, 255))

    # Magic circle glow
    draw.ellipse([60, 150, 180, 210], outline=(150, 100, 255, 200), width=3)
    draw.ellipse([80, 160, 160, 200], outline=(200, 150, 255, 150), width=2)
    # Magic symbols
    draw.line([(120, 155), (120, 205)], fill=(200, 150, 255, 100), width=2)
    draw.line([(70, 180), (170, 180)], fill=(200, 150, 255, 100), width=2)

    # Main building - modern tower
    b_base = [(120, 100), (170, 124), (120, 150), (70, 124)]
    draw.polygon(b_base, fill=(80, 80, 120, 255))
    draw.polygon([(120, 100), (70, 124), (120, 150)], fill=(60, 60, 100, 255))
    draw.polygon([(120, 100), (170, 124), (120, 150)], fill=(100, 100, 140, 255))

    # Building windows (glowing blue)
    for wx, wy in [(100, 116), (120, 124), (140, 116)]:
        draw.rectangle([wx - 6, wy - 8, wx + 6, wy + 8], fill=(150, 200, 255, 255))
        draw.rectangle([wx - 3, wy - 5, wx + 3, wy + 5], fill=(200, 230, 255, 255))

    # Floating book
    book_points = [(150, 70), (190, 80), (180, 100), (140, 90)]
    draw.polygon(book_points, fill=(139, 90, 43, 255))
    draw.polygon([(150, 70), (170, 74), (160, 80)], fill=(255, 255, 200, 255))
    draw.line([(140, 85), (180, 95)], fill=(100, 60, 40, 255), width=2)

    # Magic particles around book
    for px, py in [(130, 60), (200, 70), (160, 50)]:
        draw.ellipse([px - 4, py - 4, px + 4, py + 4], fill=(200, 150, 255, 200))

    return img


def create_payment_fortress():
    """Create dark Payment Fortress with storm - LARGE"""
    img = Image.new("RGBA", (280, 320), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Storm cloud base (dark)
    cloud_points = [(140, 240), (240, 280), (140, 320), (40, 280)]
    draw.polygon(cloud_points, fill=(60, 60, 80, 255))
    draw.polygon([(140, 240), (40, 280), (140, 320)], fill=(50, 50, 70, 255))
    draw.polygon([(140, 240), (240, 280), (140, 320)], fill=(70, 70, 90, 255))

    # Lightning effects
    draw.polygon(
        [(140, 200), (150, 240), (140, 260), (130, 240)], fill=(255, 200, 50, 220)
    )
    draw.polygon(
        [(100, 180), (110, 220), (100, 230), (90, 220)], fill=(200, 150, 255, 180)
    )
    draw.polygon(
        [(180, 190), (190, 230), (180, 240), (170, 230)], fill=(255, 100, 100, 180)
    )

    # Dark fortress base
    f_base = [(140, 120), (200, 150), (140, 180), (80, 150)]
    draw.polygon(f_base, fill=(40, 40, 50, 255))
    draw.polygon([(140, 120), (80, 150), (140, 180)], fill=(30, 30, 40, 255))
    draw.polygon([(140, 120), (200, 150), (140, 180)], fill=(50, 50, 60, 255))

    # Towers (darker)
    for tx, ty in [(100, 90), (180, 90)]:
        draw.polygon(
            [(tx, ty), (tx + 16, ty + 20), (tx, ty + 30), (tx - 16, ty + 20)],
            fill=(35, 35, 45, 255),
        )
        draw.polygon(
            [(tx, ty - 10), (tx + 10, ty), (tx, ty + 6), (tx - 10, ty)],
            fill=(200, 50, 50, 255),
        )
        # Tower windows (glowing red)
        draw.ellipse([tx - 4, ty + 10, tx + 4, ty + 18], fill=(255, 80, 80, 255))

    # Main keep (taller)
    draw.polygon([(140, 80), (170, 96), (140, 110), (110, 96)], fill=(45, 45, 55, 255))
    draw.polygon([(140, 60), (156, 80), (140, 90), (124, 80)], fill=(60, 20, 20, 255))

    # Warning skull
    draw.ellipse([130, 130, 150, 150], fill=(255, 255, 255, 255))
    draw.ellipse([134, 136, 138, 140], fill=(0, 0, 0, 255))
    draw.ellipse([142, 136, 146, 140], fill=(0, 0, 0, 255))
    draw.rectangle([138, 142, 142, 146], fill=(0, 0, 0, 255))

    return img


def create_community_commons():
    """Create Community Commons - camp area - LARGE"""
    img = Image.new("RGBA", (240, 200), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Ground area
    ground_points = [(120, 100), (200, 140), (120, 180), (40, 140)]
    draw.polygon(ground_points, fill=(210, 180, 140, 255))
    draw.polygon([(120, 100), (40, 140), (120, 180)], fill=(190, 160, 120, 255))
    draw.polygon([(120, 100), (200, 140), (120, 180)], fill=(230, 200, 160, 255))

    # Main tent (large)
    tent_base = [(120, 90), (160, 110), (120, 130), (80, 110)]
    draw.polygon(tent_base, fill=(210, 130, 80, 255))
    draw.polygon([(120, 90), (80, 110), (120, 130)], fill=(190, 110, 60, 255))
    draw.polygon([(120, 90), (160, 110), (120, 130)], fill=(230, 150, 100, 255))
    # Tent roof
    draw.polygon(
        [(120, 60), (150, 90), (120, 104), (90, 90)], fill=(240, 160, 110, 255)
    )

    # Small tents
    for tx, ty in [(70, 120), (170, 120)]:
        draw.polygon(
            [(tx, ty), (tx + 20, ty + 16), (tx, ty + 24), (tx - 20, ty + 16)],
            fill=(200, 140, 90, 255),
        )
        draw.polygon(
            [(tx, ty - 10), (tx + 14, ty), (tx, ty + 10), (tx - 14, ty)],
            fill=(220, 160, 110, 255),
        )

    # Campfire
    draw.polygon(
        [(120, 140), (130, 160), (120, 170), (110, 160)], fill=(255, 100, 50, 220)
    )
    draw.polygon(
        [(120, 150), (126, 164), (120, 176), (114, 164)], fill=(255, 200, 50, 200)
    )
    # Fire glow
    draw.ellipse([100, 130, 140, 180], outline=(255, 150, 50, 100), width=2)

    return img


def create_bug_bastion():
    """Create Bug Bastion - forest fort - LARGE"""
    img = Image.new("RGBA", (256, 240), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Forest ground
    ground_points = [(128, 120), (216, 164), (128, 208), (40, 164)]
    draw.polygon(ground_points, fill=(76, 140, 74, 255))
    draw.polygon([(128, 120), (40, 164), (128, 208)], fill=(56, 120, 54, 255))
    draw.polygon([(128, 120), (216, 164), (128, 208)], fill=(96, 160, 94, 255))

    # Trees (larger)
    for tx, ty in [(80, 100), (176, 110), (110, 80)]:
        # Tree trunk
        draw.polygon(
            [(tx, ty + 40), (tx + 12, ty + 40), (tx + 12, ty), (tx, ty)],
            fill=(101, 67, 33, 255),
        )
        # Tree leaves (isometric cone layers)
        for layer, color in [
            (0, (76, 175, 80, 255)),
            (-15, (56, 142, 60, 255)),
            (-30, (76, 175, 80, 255)),
        ]:
            ly = ty + layer
            draw.polygon(
                [(tx, ly - 20), (tx + 40, ly), (tx, ly + 20), (tx - 40, ly)], fill=color
            )

    # Wooden fort
    fort_base = [(128, 110), (168, 130), (128, 150), (88, 130)]
    draw.polygon(fort_base, fill=(139, 110, 75, 255))

    # Palisade walls
    for px in range(100, 156, 16):
        draw.rectangle([px, 120, px + 8, 144], fill=(160, 130, 90, 255))
        draw.polygon(
            [(px, 116), (px + 4, 108), (px + 8, 116)], fill=(140, 110, 70, 255)
        )

    return img


def main():
    os.makedirs("structures", exist_ok=True)

    create_main_castle().save("structures/main_castle.png")
    create_task_tower().save("structures/task_tower.png")
    create_alchemy_lab().save("structures/alchemy_lab.png")
    create_payment_fortress().save("structures/payment_fortress.png")
    create_community_commons().save("structures/community_commons.png")
    create_bug_bastion().save("structures/bug_bastion.png")

    print("LARGE Structure assets generated!")


if __name__ == "__main__":
    main()
