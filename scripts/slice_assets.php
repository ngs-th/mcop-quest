<?php

// Load the master sprite sheet (Detected as JPEG)
$sourcePath = 'public/images/master-iso-sprites.png';
$source = imagecreatefromjpeg($sourcePath); // Use JPEG loader

if (!$source) {
    die("Failed to load image");
}

// Function to crop, make transparent, and save
function cropAndSave($source, $x, $y, $w, $h, $name) {
    $dest = imagecreatetruecolor($w, $h);
    
    // Fill with transparent color first
    imagealphablending($dest, false);
    imagesavealpha($dest, true);
    $transparent = imagecolorallocatealpha($dest, 0, 0, 0, 127);
    imagefilledrectangle($dest, 0, 0, $w, $h, $transparent);
    
    // Copy
    imagecopy($dest, $source, 0, 0, $x, $y, $w, $h);
    
    // REMOVE WHITE BACKGROUND (Chroma Key)
    // Scan pixels and convert near-white to transparent
    for ($px = 0; $px < $w; $px++) {
        for ($py = 0; $py < $h; $py++) {
            $rgb = imagecolorat($dest, $px, $py);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            
            // Threshold for "White" (e.g., > 240)
            if ($r > 240 && $g > 240 && $b > 240) {
                imagesetpixel($dest, $px, $py, $transparent);
            }
        }
    }
    
    // Save
    if (!is_dir('public/images/assets_v5')) mkdir('public/images/assets_v5', 0777, true);
    imagepng($dest, "public/images/assets_v5/{$name}.png");
    echo "Saved {$name}.png\n";
    imagedestroy($dest);
}

// Coordinates (Re-adjusted for visually estimated 1024x1024 layout)
// Castle: Top Cluster
cropAndSave($source, 150, 0, 700, 500, 'castle_citadel');

// Market: Mid Left
cropAndSave($source, 80, 480, 280, 250, 'market_stall');

// Tower: Mid Right
cropAndSave($source, 720, 420, 180, 360, 'tower_magic');

// Grass: Bot Left
cropAndSave($source, 40, 750, 220, 200, 'tile_grass');

// Water: Bot Center
cropAndSave($source, 270, 750, 220, 220, 'tile_water');

// Tree: Bot Right
cropAndSave($source, 600, 730, 150, 200, 'tree_pine');

// Rock: Far Bot Right
cropAndSave($source, 780, 800, 180, 150, 'rock_moss');

echo "Slicing Complete.";
