/**
 * Camera - Zoom and Pan handling for Kingdom Rush Map
 */
class Camera {
    constructor(canvasWidth, canvasHeight) {
        // Map dimensions (40x30 tiles @ 128px)
        this.mapWidth = 5120;
        this.mapHeight = 3840;
        // Viewport dimensions
        this.viewportWidth = canvasWidth;
        this.viewportHeight = canvasHeight;

        // Camera position (center of viewport in world coords)
        // Start at member_city location instead of map center for better UX
        this.x = 1536;
        this.y = 1024;

        // Zoom settings
        this.zoom = 1;
        this.minZoom = 0.5;
        this.maxZoom = 2.0;
        this.zoomStep = 0.1;

        // Pan bounds (keep camera within map)
        this.padding = 200;
    }

    /**
     * Zoom toward a specific point (e.g., mouse cursor)
     */
    zoomToward(newZoom, screenX, screenY) {
        // Clamp zoom level
        newZoom = Math.max(this.minZoom, Math.min(this.maxZoom, newZoom));

        if (newZoom === this.zoom) return;

        // Convert screen point to world before zoom
        const worldBefore = this.screenToWorld(screenX, screenY);

        // Apply zoom
        this.zoom = newZoom;

        // Convert same world point to screen after zoom
        const screenAfter = this.worldToScreen(worldBefore.x, worldBefore.y);

        // Adjust camera to keep world point under same screen position
        this.x += (screenX - screenAfter.x) / this.zoom;
        this.y += (screenY - screenAfter.y) / this.zoom;

        this.clampPosition();
    }

    /**
     * Zoom in/out by step
     */
    zoomIn() {
        this.zoomToward(this.zoom + this.zoomStep, this.viewportWidth / 2, this.viewportHeight / 2);
    }

    zoomOut() {
        this.zoomToward(this.zoom - this.zoomStep, this.viewportWidth / 2, this.viewportHeight / 2);
    }

    /**
     * Pan camera by delta
     */
    pan(deltaX, deltaY) {
        this.x -= deltaX / this.zoom;
        this.y -= deltaY / this.zoom;
        this.clampPosition();
    }

    /**
     * Keep camera within map bounds
     */
    clampPosition() {
        const halfViewportW = (this.viewportWidth / 2) / this.zoom;
        const halfViewportH = (this.viewportHeight / 2) / this.zoom;

        this.x = Math.max(halfViewportW - this.padding,
                   Math.min(this.mapWidth - halfViewportW + this.padding, this.x));
        this.y = Math.max(halfViewportH - this.padding,
                   Math.min(this.mapHeight - halfViewportH + this.padding, this.y));
    }

    /**
     * Convert screen coordinates to world coordinates
     */
    screenToWorld(screenX, screenY) {
        const centerX = this.viewportWidth / 2;
        const centerY = this.viewportHeight / 2;

        return {
            x: this.x + (screenX - centerX) / this.zoom,
            y: this.y + (screenY - centerY) / this.zoom
        };
    }

    /**
     * Convert world coordinates to screen coordinates
     */
    worldToScreen(worldX, worldY) {
        const centerX = this.viewportWidth / 2;
        const centerY = this.viewportHeight / 2;

        return {
            x: centerX + (worldX - this.x) * this.zoom,
            y: centerY + (worldY - this.y) * this.zoom
        };
    }

    /**
     * Apply camera transform to canvas context
     */
    applyTransform(ctx) {
        const centerX = this.viewportWidth / 2;
        const centerY = this.viewportHeight / 2;

        ctx.translate(centerX, centerY);
        ctx.scale(this.zoom, this.zoom);
        ctx.translate(-this.x, -this.y);
    }

    /**
     * Get visible tile range (for viewport culling)
     */
    getVisibleTiles(tileSize) {
        const topLeft = this.screenToWorld(0, 0);
        const bottomRight = this.screenToWorld(this.viewportWidth, this.viewportHeight);

        return {
            startCol: Math.floor(topLeft.x / tileSize),
            endCol: Math.ceil(bottomRight.x / tileSize),
            startRow: Math.floor(topLeft.y / tileSize),
            endRow: Math.ceil(bottomRight.y / tileSize)
        };
    }

    /**
     * Resize camera when canvas changes
     */
    resize(width, height) {
        this.viewportWidth = width;
        this.viewportHeight = height;
        this.clampPosition();
    }
}

export default Camera;
