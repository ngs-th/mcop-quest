#!/usr/bin/env python3
"""
Fix tile edges by cropping the borders to make them seamless
"""
from pathlib import Path
from PIL import Image

def crop_tile_edges(image_path, output_path, crop_amount=8):
    """Crop edges from a tile to remove borders"""
    with Image.open(image_path) as img:
        width, height = img.size
        # Crop from all sides
        left = crop_amount
        top = crop_amount
        right = width - crop_amount
        bottom = height - crop_amount

        cropped = img.crop((left, top, right, bottom))

        # Resize back to 128x128 using high quality resampling
        resized = cropped.resize((128, 128), Image.Resampling.LANCZOS)

        resized.save(output_path, 'PNG')
        return True

def main():
    tiles_dir = Path('/Users/ngs/Herd/mcop-quest/public/images/map/tiles')
    print("🔧 Fixing tile edges...")
    print(f"📁 Directory: {tiles_dir}")
    print()

    # Process all tile images
    tiles = list(tiles_dir.glob('*.png'))
    fixed_count = 0

    for tile_path in tiles:
        try:
            # Backup original (optional - skip for now)
            # backup_path = tile_path.with_suffix('.png.backup')
            # tile_path.rename(backup_path)

            # Crop and overwrite
            if crop_tile_edges(tile_path, tile_path):
                print(f"  ✅ Fixed: {tile_path.name}")
                fixed_count += 1

        except Exception as e:
            print(f"  ❌ Failed: {tile_path.name} - {e}")

    print()
    print(f"📊 Summary: {fixed_count}/{len(tiles)} tiles fixed")

    # Also fix structures - crop to center portion
    print()
    print("🔧 Fixing structure edges...")
    structures_dir = Path('/Users/ngs/Herd/mcop-quest/public/images/map/structures')
    structures = list(structures_dir.glob('*.png'))
    fixed_structures = 0

    for struct_path in structures:
        try:
            with Image.open(struct_path) as img:
                width, height = img.size
                # Crop more from structures (16px)
                crop = 16
                left = crop
                top = crop
                right = width - crop
                bottom = height - crop

                cropped = img.crop((left, top, right, bottom))
                resized = cropped.resize((256, 256), Image.Resampling.LANCZOS)
                resized.save(struct_path, 'PNG')

                print(f"  ✅ Fixed: {struct_path.name}")
                fixed_structures += 1

        except Exception as e:
            print(f"  ❌ Failed: {struct_path.name} - {e}")

    print()
    print(f"📊 Summary: {fixed_structures}/{len(structures)} structures fixed")

if __name__ == '__main__':
    main()
