#!/usr/bin/env python3
"""
Remove backgrounds from structure images using rembg
"""
from pathlib import Path
from rembg import remove
from PIL import Image

def main():
    structures_dir = Path('/Users/ngs/Herd/mcop-quest/public/images/map/structures')
    print("=" * 60)
    print("🎨 Structure Background Remover (rembg)")
    print("=" * 60)
    print(f"📁 Directory: {structures_dir}")
    print()

    # Process all structure images
    structures = list(structures_dir.glob('*.png'))
    success_count = 0

    for struct_path in structures:
        try:
            print(f"🔧 Processing: {struct_path.name}")

            # Load image
            with open(struct_path, 'rb') as f:
                input_data = f.read()

            # Remove background
            output_data = remove(input_data)

            # Save back
            with open(struct_path, 'wb') as f:
                f.write(output_data)

            print(f"   ✅ Background removed")
            success_count += 1

        except Exception as e:
            print(f"   ❌ Failed: {e}")

    print()
    print("=" * 60)
    print(f"📊 Summary: {success_count}/{len(structures)} structures processed")
    print("=" * 60)

    if success_count == len(structures):
        print("🎉 All structures now have transparent backgrounds!")

if __name__ == '__main__':
    main()
