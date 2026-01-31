/**
 * MapRenderer - Kingdom Rush Style Tile Map Renderer
 * Canvas 2D-based with viewport culling
 */
import Camera from './Camera.js';
import Location from './Location.js';

class MapRenderer {
    constructor(canvas, mapData, tilesetImages, structureImages) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.mapData = mapData;
        this.tileSize = mapData.tileSize || 128;

        // Images
        this.tileset = tilesetImages;
        this.structures = structureImages;

        // Camera
        this.camera = new Camera(canvas.width, canvas.height);

        // Locations
        this.locations = (mapData.locations || []).map(l => new Location(l));
        this.hoveredLocation = null;
        this.selectedLocation = null;

        // Tile layers
        this.layers = mapData.layers || [];

        // Animation
        this.lastTime = 0;
        this.isRunning = false;

        // Input state
        this.isDragging = false;
        this.lastMouseX = 0;
        this.lastMouseY = 0;

        // Callbacks
        this.onLocationClick = null;
        this.onLocationHover = null;

        // Bind methods
        this.handleMouseDown = this.handleMouseDown.bind(this);
        this.handleMouseMove = this.handleMouseMove.bind(this);
        this.handleMouseUp = this.handleMouseUp.bind(this);
        this.handleWheel = this.handleWheel.bind(this);
        this.handleTouchStart = this.handleTouchStart.bind(this);
        this.handleTouchMove = this.handleTouchMove.bind(this);
        this.handleTouchEnd = this.handleTouchEnd.bind(this);

        // Setup events
        this.setupEventListeners();

        // Initial render
        this.resize(canvas.width, canvas.height);
    }

    /**
     * Setup input event listeners
     */
    setupEventListeners() {
        // Mouse
        this.canvas.addEventListener('mousedown', this.handleMouseDown);
        this.canvas.addEventListener('mousemove', this.handleMouseMove);
        this.canvas.addEventListener('mouseup', this.handleMouseUp);
        this.canvas.addEventListener('mouseleave', this.handleMouseUp);
        this.canvas.addEventListener('wheel', this.handleWheel, { passive: false });

        // Touch
        this.canvas.addEventListener('touchstart', this.handleTouchStart, { passive: false });
        this.canvas.addEventListener('touchmove', this.handleTouchMove, { passive: false });
        this.canvas.addEventListener('touchend', this.handleTouchEnd);
    }

    /**
     * Remove event listeners
     */
    destroy() {
        this.canvas.removeEventListener('mousedown', this.handleMouseDown);
        this.canvas.removeEventListener('mousemove', this.handleMouseMove);
        this.canvas.removeEventListener('mouseup', this.handleMouseUp);
        this.canvas.removeEventListener('mouseleave', this.handleMouseUp);
        this.canvas.removeEventListener('wheel', this.handleWheel);
        this.canvas.removeEventListener('touchstart', this.handleTouchStart);
        this.canvas.removeEventListener('touchmove', this.handleTouchMove);
        this.canvas.removeEventListener('touchend', this.handleTouchEnd);
        this.isRunning = false;
    }

    /**
     * Start render loop
     */
    start() {
        this.isRunning = true;
        this.lastTime = performance.now();
        requestAnimationFrame((t) => this.loop(t));
    }

    /**
     * Stop render loop
     */
    stop() {
        this.isRunning = false;
    }

    /**
     * Main render loop
     */
    loop(timestamp) {
        if (!this.isRunning) return;

        const deltaTime = (timestamp - this.lastTime) / 1000;
        this.lastTime = timestamp;

        this.update(deltaTime);
        this.render();

        requestAnimationFrame((t) => this.loop(t));
    }

    /**
     * Update logic
     */
    update(deltaTime) {
        // Update locations
        for (const location of this.locations) {
            location.update(deltaTime);
        }
    }

    /**
     * Render the map
     */
    render() {
        const ctx = this.ctx;
        const { width, height } = this.canvas;

        // Clear canvas
        ctx.fillStyle = '#1a1510';
        ctx.fillRect(0, 0, width, height);

        // Apply camera transform
        ctx.save();
        this.camera.applyTransform(ctx);

        // Get visible tile range
        const visible = this.camera.getVisibleTiles(this.tileSize);

        // Render tile layers
        for (const layer of this.layers) {
            this.renderLayer(ctx, layer, visible);
        }

        // Render locations
        for (const location of this.locations) {
            const image = this.structures[location.type];
            location.draw(ctx, image, this.lastTime);
        }

        ctx.restore();
    }

    /**
     * Render a single layer with viewport culling
     */
    renderLayer(ctx, layer, visible) {
        const { startCol, endCol, startRow, endRow } = visible;
        const mapWidth = this.mapData.width;
        const mapHeight = this.mapData.height;

        // Clamp to map bounds
        const colStart = Math.max(0, startCol);
        const colEnd = Math.min(mapWidth, endCol);
        const rowStart = Math.max(0, startRow);
        const rowEnd = Math.min(mapHeight, endRow);

        // Disable image smoothing to prevent edge artifacts
        ctx.imageSmoothingEnabled = false;

        for (let row = rowStart; row < rowEnd; row++) {
            for (let col = colStart; col < colEnd; col++) {
                const tileIndex = layer.data[row * mapWidth + col];
                if (tileIndex === 0) continue; // Empty tile

                const tile = this.tileset[tileIndex];
                if (tile && tile.complete) {
                    // Draw tile with slight overlap to prevent gaps
                    const x = Math.floor(col * this.tileSize);
                    const y = Math.floor(row * this.tileSize);
                    ctx.drawImage(
                        tile,
                        x,
                        y,
                        this.tileSize + 1,
                        this.tileSize + 1
                    );
                }
            }
        }

        // Re-enable smoothing for other elements
        ctx.imageSmoothingEnabled = true;
    }

    /**
     * Handle mouse down
     */
    handleMouseDown(e) {
        e.preventDefault();
        this.isDragging = true;
        this.lastMouseX = e.offsetX;
        this.lastMouseY = e.offsetY;

        // Check for location click
        const worldPos = this.camera.screenToWorld(e.offsetX, e.offsetY);
        const clickedLocation = this.locations.find(l => l.hitTest(worldPos.x, worldPos.y));

        if (clickedLocation) {
            this.selectedLocation = clickedLocation;
            if (this.onLocationClick) {
                this.onLocationClick(clickedLocation);
            }
        }
    }

    /**
     * Handle mouse move
     */
    handleMouseMove(e) {
        const worldPos = this.camera.screenToWorld(e.offsetX, e.offsetY);

        // Check hover
        const hoveredLocation = this.locations.find(l => l.hitTest(worldPos.x, worldPos.y));

        if (hoveredLocation !== this.hoveredLocation) {
            if (this.hoveredLocation) this.hoveredLocation.setHovered(false);
            if (hoveredLocation) hoveredLocation.setHovered(true);
            this.hoveredLocation = hoveredLocation;

            if (this.onLocationHover) {
                this.onLocationHover(hoveredLocation);
            }

            this.canvas.style.cursor = hoveredLocation ? 'pointer' : 'grab';
        }

        // Handle pan
        if (this.isDragging) {
            const deltaX = e.offsetX - this.lastMouseX;
            const deltaY = e.offsetY - this.lastMouseY;
            this.camera.pan(deltaX, deltaY);
            this.lastMouseX = e.offsetX;
            this.lastMouseY = e.offsetY;
            this.canvas.style.cursor = 'grabbing';
        }
    }

    /**
     * Handle mouse up
     */
    handleMouseUp(e) {
        this.isDragging = false;
        this.canvas.style.cursor = this.hoveredLocation ? 'pointer' : 'grab';
    }

    /**
     * Handle wheel (zoom)
     */
    handleWheel(e) {
        e.preventDefault();
        const zoomFactor = e.deltaY > 0 ? 0.9 : 1.1;
        const newZoom = this.camera.zoom * zoomFactor;
        this.camera.zoomToward(newZoom, e.offsetX, e.offsetY);
    }

    /**
     * Handle touch start
     */
    handleTouchStart(e) {
        if (e.touches.length === 1) {
            const touch = e.touches[0];
            const rect = this.canvas.getBoundingClientRect();
            this.isDragging = true;
            this.lastMouseX = touch.clientX - rect.left;
            this.lastMouseY = touch.clientY - rect.top;
        }
    }

    /**
     * Handle touch move
     */
    handleTouchMove(e) {
        e.preventDefault();
        if (e.touches.length === 1 && this.isDragging) {
            const touch = e.touches[0];
            const rect = this.canvas.getBoundingClientRect();
            const x = touch.clientX - rect.left;
            const y = touch.clientY - rect.top;
            const deltaX = x - this.lastMouseX;
            const deltaY = y - this.lastMouseY;
            this.camera.pan(deltaX, deltaY);
            this.lastMouseX = x;
            this.lastMouseY = y;
        }
    }

    /**
     * Handle touch end
     */
    handleTouchEnd(e) {
        this.isDragging = false;
    }

    /**
     * Zoom in/out
     */
    zoomIn() {
        this.camera.zoomIn();
    }

    zoomOut() {
        this.camera.zoomOut();
    }

    /**
     * Resize canvas
     */
    resize(width, height) {
        this.canvas.width = width;
        this.canvas.height = height;
        this.camera.resize(width, height);
    }

    /**
     * Update location data (from backend)
     */
    updateLocations(locationsData) {
        for (const data of locationsData) {
            const location = this.locations.find(l => l.id === data.id);
            if (location) {
                location.health = data.health;
                location.maxHealth = data.maxHealth;
                location.status = data.status;
                location.isFoggy = data.isFoggy;
            }
        }
    }
}

export default MapRenderer;
