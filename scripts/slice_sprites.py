import cv2
import numpy as np
import os

def slice_sprites(source_path, output_dir):
    # Load image
    img = cv2.imread(source_path, cv2.IMREAD_UNCHANGED)
    
    # Check if image has alpha
    if img.shape[2] == 3:
        # If no alpha, assume white background -> transparent
        gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        _, alpha = cv2.threshold(gray, 240, 255, cv2.THRESH_BINARY_INV)
        b, g, r = cv2.split(img)
        img = cv2.merge([b, g, r, alpha])
    
    # Extract Alpha channel for contour detection
    alpha_channel = img[:, :, 3]
    
    # Find contours
    contours, _ = cv2.findContours(alpha_channel, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    
    if not os.path.exists(output_dir):
        os.makedirs(output_dir)

    print(f"Found {len(contours)} objects.")
    
    saved_count = 0
    for i, cnt in enumerate(contours):
        x, y, w, h = cv2.boundingRect(cnt)
        
        # Filter noise (too small)
        if w < 50 or h < 50:
            continue
            
        # Crop
        crop = img[y:y+h, x:x+w]
        
        # Save
        filename = f"asset_{saved_count:02d}.png"
        cv2.imwrite(os.path.join(output_dir, filename), crop)
        print(f"Saved {filename} ({w}x{h})")
        saved_count += 1

if __name__ == "__main__":
    slice_sprites(
        "public/images/master-iso-sprites.png",
        "public/images/assets_v5"
    )
