#!/usr/bin/env python3
"""Generate pixel art UI assets for MCOP Quest"""

import os

from PIL import Image, ImageDraw


def create_health_bar_full():
    """Create green full health bar"""
    img = Image.new("RGBA", (120, 20), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Background
    draw.rounded_rectangle([0, 0, 120, 20], radius=4, fill=(60, 60, 60, 255))
    # Fill
    draw.rounded_rectangle([2, 2, 118, 18], radius=3, fill=(76, 175, 80, 255))
    # Highlight
    draw.line([(4, 4), (116, 4)], fill=(129, 199, 132, 255), width=2)

    return img


def create_health_bar_stable():
    """Create blue stable health bar"""
    img = Image.new("RGBA", (120, 20), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    draw.rounded_rectangle([0, 0, 120, 20], radius=4, fill=(60, 60, 60, 255))
    draw.rounded_rectangle([2, 2, 118, 18], radius=3, fill=(66, 133, 244, 255))
    draw.line([(4, 4), (116, 4)], fill=(100, 180, 255, 255), width=2)

    return img


def create_health_bar_medium():
    """Create yellow medium health bar"""
    img = Image.new("RGBA", (120, 20), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    draw.rounded_rectangle([0, 0, 120, 20], radius=4, fill=(60, 60, 60, 255))
    draw.rounded_rectangle([2, 2, 80, 18], radius=3, fill=(255, 193, 7, 255))
    draw.line([(4, 4), (78, 4)], fill=(255, 220, 100, 255), width=2)

    return img


def create_health_bar_low():
    """Create red low health bar"""
    img = Image.new("RGBA", (120, 20), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    draw.rounded_rectangle([0, 0, 120, 20], radius=4, fill=(60, 60, 60, 255))
    draw.rounded_rectangle([2, 2, 40, 18], radius=3, fill=(244, 67, 54, 255))
    draw.line([(4, 4), (38, 4)], fill=(255, 120, 110, 255), width=2)

    return img


def create_banner(label_width=140):
    """Create location banner"""
    img = Image.new("RGBA", (label_width, 32), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Banner background
    points = [
        (10, 0),
        (label_width - 10, 0),
        (label_width, 16),
        (label_width - 10, 32),
        (10, 32),
        (0, 16),
    ]
    draw.polygon(points, fill=(100, 80, 60, 230))

    # Border
    draw.polygon(points, outline=(180, 160, 100, 255), width=2)

    # Decorative corners
    draw.ellipse([2, 12, 10, 20], fill=(200, 180, 120, 255))
    draw.ellipse([label_width - 10, 12, label_width - 2, 20], fill=(200, 180, 120, 255))

    return img


def create_compass():
    """Create compass rose"""
    img = Image.new("RGBA", (80, 80), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Outer ring
    draw.ellipse([0, 0, 80, 80], fill=(200, 180, 140, 255))
    draw.ellipse([4, 4, 76, 76], fill=(240, 230, 200, 255))

    # Cardinal directions
    draw.polygon([(40, 8), (44, 36), (40, 40), (36, 36)], fill=(200, 50, 50, 255))  # N
    draw.polygon([(40, 72), (36, 44), (40, 40), (44, 44)], fill=(50, 50, 200, 255))  # S
    draw.polygon([(72, 40), (44, 44), (40, 40), (44, 36)], fill=(50, 50, 50, 255))  # E
    draw.polygon([(8, 40), (36, 36), (40, 40), (36, 44)], fill=(50, 50, 50, 255))  # W

    # Center
    draw.ellipse([36, 36, 44, 44], fill=(100, 100, 100, 255))

    return img


def create_ui_frame():
    """Create golden UI frame/border"""
    img = Image.new("RGBA", (64, 64), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Frame border
    draw.rectangle([0, 0, 63, 63], outline=(200, 180, 100, 255), width=4)
    # Corner decorations
    for x, y in [(0, 0), (56, 0), (0, 56), (56, 56)]:
        draw.rectangle([x, y, x + 8, y + 8], fill=(220, 200, 120, 255))

    return img


def create_gem_icon():
    """Create gem/diamond icon"""
    img = Image.new("RGBA", (32, 32), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Diamond shape
    draw.polygon([(16, 2), (28, 12), (16, 30), (4, 12)], fill=(0, 200, 255, 255))
    draw.polygon([(16, 2), (16, 12), (4, 12)], fill=(100, 220, 255, 255))
    draw.polygon([(16, 2), (28, 12), (16, 12)], fill=(0, 180, 230, 255))

    return img


def create_coin_icon():
    """Create gold coin icon"""
    img = Image.new("RGBA", (32, 32), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Coin body
    draw.ellipse([2, 2, 30, 30], fill=(255, 193, 7, 255))
    draw.ellipse([4, 4, 28, 28], fill=(255, 214, 79, 255))
    # Inner detail
    draw.ellipse([10, 10, 22, 22], fill=(255, 193, 7, 255))

    return img


def create_arrow(direction="right"):
    """Create directional arrow"""
    img = Image.new("RGBA", (32, 32), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    if direction == "right":
        draw.polygon([(4, 8), (24, 16), (4, 24)], fill=(100, 200, 100, 255))
    elif direction == "left":
        draw.polygon([(28, 8), (8, 16), (28, 24)], fill=(100, 200, 100, 255))
    elif direction == "down":
        draw.polygon([(8, 4), (24, 4), (16, 28)], fill=(100, 200, 255, 255))
    elif direction == "up":
        draw.polygon([(8, 28), (24, 28), (16, 4)], fill=(255, 200, 100, 255))

    return img


def create_warning_icon():
    """Create warning/skull icon"""
    img = Image.new("RGBA", (48, 48), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Background
    draw.rectangle([0, 0, 48, 48], fill=(60, 60, 60, 255))
    draw.rectangle([2, 2, 46, 46], fill=(40, 40, 40, 255))

    # Skull
    draw.ellipse([12, 8, 36, 32], fill=(255, 255, 255, 255))
    # Eyes
    draw.ellipse([17, 16, 23, 22], fill=(0, 0, 0, 255))
    draw.ellipse([25, 16, 31, 22], fill=(0, 0, 0, 255))
    # Crossbones
    draw.line([(8, 36), (40, 36)], fill=(255, 100, 100, 255), width=3)
    draw.line([(24, 28), (24, 44)], fill=(255, 100, 100, 255), width=3)

    return img


def main():
    os.makedirs("ui", exist_ok=True)

    create_health_bar_full().save("ui/health_full.png")
    create_health_bar_stable().save("ui/health_stable.png")
    create_health_bar_medium().save("ui/health_medium.png")
    create_health_bar_low().save("ui/health_low.png")
    create_banner(160).save("ui/banner.png")
    create_compass().save("ui/compass.png")
    create_ui_frame().save("ui/frame.png")
    create_gem_icon().save("ui/gem.png")
    create_coin_icon().save("ui/coin.png")
    create_arrow("right").save("ui/arrow_right.png")
    create_arrow("left").save("ui/arrow_left.png")
    create_arrow("down").save("ui/arrow_down.png")
    create_arrow("up").save("ui/arrow_up.png")
    create_warning_icon().save("ui/warning.png")

    print("UI assets generated!")


if __name__ == "__main__":
    main()
