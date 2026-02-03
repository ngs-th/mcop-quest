#!/usr/bin/env python3
"""Generate LARGE pixel art character assets for MCOP Quest"""

from PIL import Image, ImageDraw
import os


def create_warrior():
    """Create chibi warrior character - LARGE"""
    img = Image.new("RGBA", (128, 128), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Body
    draw.ellipse([40, 56, 88, 104], fill=(100, 100, 120, 255))

    # Head
    draw.ellipse([36, 16, 92, 72], fill=(255, 200, 150, 255))

    # Hair
    draw.arc([36, 8, 92, 48], start=0, end=180, fill=(139, 90, 43, 255), width=12)

    # Helmet
    draw.arc([32, 4, 96, 40], start=0, end=180, fill=(180, 180, 190, 255), width=8)

    # Eyes
    draw.ellipse([48, 40, 56, 48], fill=(0, 0, 0, 255))
    draw.ellipse([72, 40, 80, 48], fill=(0, 0, 0, 255))

    # Sword
    draw.rectangle([96, 40, 104, 100], fill=(200, 200, 210, 255))
    draw.rectangle([88, 64, 112, 72], fill=(139, 90, 43, 255))

    # Shield
    draw.ellipse([16, 64, 40, 96], fill=(100, 100, 120, 255))
    draw.ellipse([22, 70, 34, 90], fill=(150, 150, 160, 255))

    return img


def create_mage():
    """Create chibi mage character - LARGE"""
    img = Image.new("RGBA", (128, 128), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Robe
    draw.polygon([(64, 56), (96, 112), (64, 120), (32, 112)], fill=(100, 50, 150, 255))

    # Head
    draw.ellipse([36, 16, 92, 72], fill=(255, 200, 150, 255))

    # Wizard hat
    draw.polygon([(64, 8), (88, 40), (64, 32), (40, 40)], fill=(80, 40, 120, 255))
    draw.ellipse([32, 32, 96, 48], fill=(100, 60, 150, 255))

    # Eyes
    draw.ellipse([48, 44, 56, 52], fill=(0, 0, 0, 255))
    draw.ellipse([72, 44, 80, 52], fill=(0, 0, 0, 255))

    # Staff
    draw.line([(104, 32), (104, 112)], fill=(139, 90, 43, 255), width=6)
    draw.ellipse([96, 20, 112, 36], fill=(0, 200, 255, 255))

    return img


def create_archer():
    """Create chibi archer character - LARGE"""
    img = Image.new("RGBA", (128, 128), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Body
    draw.ellipse([40, 56, 88, 104], fill=(80, 120, 80, 255))

    # Head
    draw.ellipse([36, 16, 92, 72], fill=(255, 200, 150, 255))

    # Hood
    draw.arc([32, 4, 96, 48], start=0, end=180, fill=(60, 100, 60, 255), width=12)

    # Eyes
    draw.ellipse([48, 40, 56, 48], fill=(0, 0, 0, 255))
    draw.ellipse([72, 40, 80, 48], fill=(0, 0, 0, 255))

    # Bow
    draw.arc([80, 32, 120, 96], start=270, end=90, fill=(139, 90, 43, 255), width=6)
    draw.line([(100, 32), (100, 96)], fill=(200, 200, 200, 255), width=2)

    return img


def create_healer():
    """Create chibi healer character - LARGE"""
    img = Image.new("RGBA", (128, 128), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Robe
    draw.polygon([(64, 56), (92, 112), (64, 120), (36, 112)], fill=(255, 255, 220, 255))

    # Head
    draw.ellipse([36, 16, 92, 72], fill=(255, 200, 150, 255))

    # Halo
    draw.ellipse([32, 4, 96, 24], outline=(255, 215, 0, 255), width=4)

    # Eyes
    draw.ellipse([48, 40, 56, 48], fill=(0, 0, 0, 255))
    draw.ellipse([72, 40, 80, 48], fill=(0, 0, 0, 255))

    # Staff with cross
    draw.line([(104, 32), (104, 112)], fill=(255, 215, 0, 255), width=6)
    draw.line([(96, 44), (112, 44)], fill=(255, 215, 0, 255), width=4)

    return img


def create_party_group():
    """Create party of 4 characters together - LARGE"""
    img = Image.new("RGBA", (192, 128), (0, 0, 0, 0))

    warrior = create_warrior().resize((80, 80), Image.NEAREST)
    mage = create_mage().resize((80, 80), Image.NEAREST)
    archer = create_archer().resize((80, 80), Image.NEAREST)
    healer = create_healer().resize((80, 80), Image.NEAREST)

    img.paste(warrior, (0, 40), warrior)
    img.paste(mage, (56, 32), mage)
    img.paste(archer, (112, 40), archer)
    img.paste(healer, (56, 0), healer)

    return img


def create_small_char():
    """Create small map character - LARGE"""
    img = Image.new("RGBA", (48, 48), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Simple chibi body
    draw.ellipse([12, 12, 36, 36], fill=(100, 100, 120, 255))
    draw.ellipse([14, 4, 34, 20], fill=(255, 200, 150, 255))

    return img


def main():
    os.makedirs("characters", exist_ok=True)

    create_warrior().save("characters/warrior.png")
    create_mage().save("characters/mage.png")
    create_archer().save("characters/archer.png")
    create_healer().save("characters/healer.png")
    create_party_group().save("characters/party.png")
    create_small_char().save("characters/map_char.png")

    print("LARGE Character assets generated!")
    print("LARGE Character assets generated!")

if __name__ == '__main__':
    main()
