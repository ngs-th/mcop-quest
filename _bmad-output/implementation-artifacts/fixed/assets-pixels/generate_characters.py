#!/usr/bin/env python3
"""Generate pixel art character assets for MCOP Quest"""

import os

from PIL import Image, ImageDraw


def create_warrior():
    """Create chibi warrior character"""
    img = Image.new("RGBA", (64, 64), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Body
    draw.ellipse([20, 28, 44, 52], fill=(100, 100, 120, 255))

    # Head
    draw.ellipse([18, 8, 46, 36], fill=(255, 200, 150, 255))

    # Hair
    draw.arc([18, 4, 46, 24], start=0, end=180, fill=(139, 90, 43, 255), width=6)

    # Helmet
    draw.arc([16, 2, 48, 20], start=0, end=180, fill=(180, 180, 190, 255), width=4)

    # Eyes
    draw.ellipse([24, 20, 28, 24], fill=(0, 0, 0, 255))
    draw.ellipse([36, 20, 40, 24], fill=(0, 0, 0, 255))

    # Sword
    draw.rectangle([48, 20, 52, 50], fill=(200, 200, 210, 255))
    draw.rectangle([44, 32, 56, 36], fill=(139, 90, 43, 255))

    # Shield
    draw.ellipse([8, 32, 20, 48], fill=(100, 100, 120, 255))
    draw.ellipse([11, 35, 17, 45], fill=(150, 150, 160, 255))

    return img


def create_mage():
    """Create chibi mage character"""
    img = Image.new("RGBA", (64, 64), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Robe
    draw.polygon([(32, 28), (48, 56), (32, 60), (16, 56)], fill=(100, 50, 150, 255))

    # Head
    draw.ellipse([18, 8, 46, 36], fill=(255, 200, 150, 255))

    # Wizard hat
    draw.polygon([(32, 4), (44, 20), (32, 16), (20, 20)], fill=(80, 40, 120, 255))
    draw.ellipse([16, 16, 48, 24], fill=(100, 60, 150, 255))

    # Eyes
    draw.ellipse([24, 22, 28, 26], fill=(0, 0, 0, 255))
    draw.ellipse([36, 22, 40, 26], fill=(0, 0, 0, 255))

    # Staff
    draw.line([(52, 16), (52, 56)], fill=(139, 90, 43, 255), width=3)
    draw.ellipse([48, 10, 56, 18], fill=(0, 200, 255, 255))

    return img


def create_archer():
    """Create chibi archer character"""
    img = Image.new("RGBA", (64, 64), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Body
    draw.ellipse([20, 28, 44, 52], fill=(80, 120, 80, 255))

    # Head
    draw.ellipse([18, 8, 46, 36], fill=(255, 200, 150, 255))

    # Hood
    draw.arc([16, 2, 48, 24], start=0, end=180, fill=(60, 100, 60, 255), width=6)

    # Eyes
    draw.ellipse([24, 20, 28, 24], fill=(0, 0, 0, 255))
    draw.ellipse([36, 20, 40, 24], fill=(0, 0, 0, 255))

    # Bow
    draw.arc([40, 16, 60, 48], start=270, end=90, fill=(139, 90, 43, 255), width=3)
    draw.line([(50, 16), (50, 48)], fill=(200, 200, 200, 255), width=1)

    return img


def create_healer():
    """Create chibi healer character"""
    img = Image.new("RGBA", (64, 64), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Robe
    draw.polygon([(32, 28), (46, 56), (32, 60), (18, 56)], fill=(255, 255, 220, 255))

    # Head
    draw.ellipse([18, 8, 46, 36], fill=(255, 200, 150, 255))

    # Halo
    draw.ellipse([16, 2, 48, 12], outline=(255, 215, 0, 255), width=2)

    # Eyes
    draw.ellipse([24, 20, 28, 24], fill=(0, 0, 0, 255))
    draw.ellipse([36, 20, 40, 24], fill=(0, 0, 0, 255))

    # Staff with cross
    draw.line([(52, 16), (52, 56)], fill=(255, 215, 0, 255), width=3)
    draw.line([(48, 22), (56, 22)], fill=(255, 215, 0, 255), width=2)

    return img


def create_party_group():
    """Create party of 4 characters together"""
    img = Image.new("RGBA", (96, 64), (0, 0, 0, 0))

    warrior = create_warrior().resize((40, 40), Image.NEAREST)
    mage = create_mage().resize((40, 40), Image.NEAREST)
    archer = create_archer().resize((40, 40), Image.NEAREST)
    healer = create_healer().resize((40, 40), Image.NEAREST)

    img.paste(warrior, (0, 20), warrior)
    img.paste(mage, (28, 16), mage)
    img.paste(archer, (56, 20), archer)
    img.paste(healer, (28, 0), healer)

    return img


def create_small_char():
    """Create small map character"""
    img = Image.new("RGBA", (24, 24), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Simple chibi body
    draw.ellipse([6, 6, 18, 18], fill=(100, 100, 120, 255))
    draw.ellipse([7, 2, 17, 10], fill=(255, 200, 150, 255))

    return img


def main():
    os.makedirs("characters", exist_ok=True)

    create_warrior().save("characters/warrior.png")
    create_mage().save("characters/mage.png")
    create_archer().save("characters/archer.png")
    create_healer().save("characters/healer.png")
    create_party_group().save("characters/party.png")
    create_small_char().save("characters/map_char.png")

    print("Character assets generated!")


if __name__ == "__main__":
    main()
