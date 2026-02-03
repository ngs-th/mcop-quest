/**
 * Kingdom Rush Map - Main Entry Point
 */
import MapRenderer from './MapRenderer.js?v=2';
import Camera from './Camera.js?v=2';
import Location from './Location.js?v=2';

// Make available globally for debugging
window.KingdomRushMap = { MapRenderer, Camera, Location };

/**
 * Initialize the map
 */
async function initMap(canvasId, mapData, options = {}) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) {
        console.error(`Canvas #${canvasId} not found`);
        return null;
    }

    // Set canvas size
    const container = canvas.parentElement;
    canvas.width = container.clientWidth;
    canvas.height = container.clientHeight;

    // Load tileset images
    const tilesetImages = await loadTileset(mapData.tileset || {});

    // Load structure images
    const structureImages = await loadStructures(mapData.locations || []);

    // Create renderer
    const renderer = new MapRenderer(
        canvas,
        mapData,
        tilesetImages,
        structureImages
    );

    // Setup callbacks
    if (options.onLocationClick) {
        renderer.onLocationClick = options.onLocationClick;
    }
    if (options.onLocationHover) {
        renderer.onLocationHover = options.onLocationHover;
    }

    // Handle resize
    window.addEventListener('resize', () => {
        canvas.width = container.clientWidth;
        canvas.height = container.clientHeight;
        renderer.resize(canvas.width, canvas.height);
    });

    // Start rendering
    renderer.start();

    // Expose renderer for debugging if requested
    if (options.exposeRenderer) {
        options.exposeRenderer(renderer);
    }

    return renderer;
}

/**
 * Load tileset images
 */
async function loadTileset(tilesetConfig) {
    const images = {};
    const basePath = '/public/images/map/tiles/';

    // Default tile mapping - use base tiles (uniform, no patterns)
    const tileMapping = {
        1: 'grass_base.png',
        2: 'grass_01.png',
        3: 'grass_02.png',
        4: 'grass_03.png',
        5: 'dirt_base.png',
        6: 'stone_01.png',
        7: 'water_base.png',
    };

    for (const [id, filename] of Object.entries(tileMapping)) {
        images[id] = await loadImage(basePath + filename);
    }

    return images;
}

/**
 * Load structure images
 */
async function loadStructures(locations) {
    const images = {};
    const basePath = '/public/images/map/structures/';

    const structureMapping = {
        'castle': 'castle.png',
        'tower': 'tower.png',
        'bastion': 'bastion.png',
        'lab': 'lab.png',
        'market': 'market.png',
        'fortress': 'fortress.png',
        'merchant': 'merchant.png',
        'bell_tower': 'bell_tower.png',
    };

    for (const [type, filename] of Object.entries(structureMapping)) {
        images[type] = await loadImage(basePath + filename);
    }

    return images;
}

/**
 * Load a single image
 */
function loadImage(src) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve(img);
        img.onerror = () => {
            console.warn(`Failed to load image: ${src}`);
            resolve(null);
        };
        img.src = src;
    });
}

// Export
export { initMap, loadTileset, loadStructures, loadImage };
export default initMap;
