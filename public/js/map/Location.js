/**
 * Location - Interactive location on the map
 */
class Location {
    constructor(data) {
        this.id = data.id;
        this.name = data.name;
        this.nameTh = data.nameTh || data.name;
        this.x = data.x;
        this.y = data.y;
        this.type = data.type;
        this.health = data.health || 100;
        this.maxHealth = data.maxHealth || 100;
        this.status = data.status || 'full';
        this.isFoggy = data.isFoggy || false;

        // Visual properties
        this.width = 256;
        this.height = 256;
        this.hitRadius = 128;

        // Animation
        this.hoverScale = 1;
        this.targetScale = 1;
        this.pulsePhase = Math.random() * Math.PI * 2;
    }

    /**
     * Update animation
     */
    update(deltaTime) {
        // Smooth scale transition
        const scaleSpeed = 5 * deltaTime;
        this.hoverScale += (this.targetScale - this.hoverScale) * scaleSpeed;

        // Pulse animation for low health
        if (this.health < 30) {
            this.pulsePhase += deltaTime * 3;
        }
    }

    /**
     * Check if point hits this location
     */
    hitTest(worldX, worldY) {
        const dx = worldX - (this.x + this.width / 2);
        const dy = worldY - (this.y + this.height / 2);
        return Math.sqrt(dx * dx + dy * dy) < this.hitRadius;
    }

    /**
     * Get status color
     */
    getStatusColor() {
        if (this.isFoggy) return '#95a5a6';
        if (this.health >= 90) return '#2ecc71';
        if (this.health >= 60) return '#3498db';
        if (this.health >= 30) return '#f1c40f';
        return '#e74c3c';
    }

    /**
     * Get status label
     */
    getStatusLabel() {
        if (this.isFoggy) return 'FOG OF WAR';
        if (this.health >= 90) return 'FULL';
        if (this.health >= 60) return 'STABLE';
        if (this.health >= 30) return 'MEDIUM';
        return 'LOW';
    }

    /**
     * Draw location
     */
    draw(ctx, image, time) {
        const centerX = this.x + this.width / 2;
        const centerY = this.y + this.height / 2;

        ctx.save();

        // Apply hover/pulse scale
        let scale = this.hoverScale;
        if (this.health < 30) {
            scale *= 1 + Math.sin(this.pulsePhase) * 0.05;
        }

        ctx.translate(centerX, centerY);
        ctx.scale(scale, scale);

        // Draw shadow
        ctx.fillStyle = 'rgba(0, 0, 0, 0.3)';
        ctx.beginPath();
        ctx.ellipse(0, 60, 80, 30, 0, 0, Math.PI * 2);
        ctx.fill();

        // Draw structure image
        if (image && image.complete) {
            ctx.drawImage(
                image,
                -this.width / 2,
                -this.height / 2,
                this.width,
                this.height
            );
        } else {
            // Fallback: draw colored rectangle
            ctx.fillStyle = this.getStatusColor();
            ctx.fillRect(-this.width / 2, -this.height / 2, this.width, this.height);
        }

        // Draw fog overlay
        if (this.isFoggy) {
            ctx.fillStyle = 'rgba(100, 100, 100, 0.6)';
            ctx.fillRect(-this.width / 2, -this.height / 2, this.width, this.height);
        }

        ctx.restore();

        // Draw health bar (above structure)
        this.drawHealthBar(ctx, centerX, this.y - 20);

        // Draw label
        this.drawLabel(ctx, centerX, this.y + this.height + 10);
    }

    /**
     * Draw health bar
     */
    drawHealthBar(ctx, x, y) {
        const width = 140;
        const height = 18;
        const x1 = x - width / 2;

        // Background
        ctx.fillStyle = '#2c2416';
        ctx.fillRect(x1, y, width, height);

        // Border
        ctx.strokeStyle = '#c9a227';
        ctx.lineWidth = 2;
        ctx.strokeRect(x1, y, width, height);

        // Health fill
        const healthPercent = this.health / this.maxHealth;
        ctx.fillStyle = this.getStatusColor();
        ctx.fillRect(x1 + 2, y + 2, (width - 4) * healthPercent, height - 4);
    }

    /**
     * Draw location label
     */
    drawLabel(ctx, x, y) {
        const text = this.name.toUpperCase();
        ctx.font = 'bold 16px Cinzel, serif';
        ctx.textAlign = 'center';

        // Text shadow
        ctx.fillStyle = 'rgba(0, 0, 0, 0.8)';
        ctx.fillText(text, x + 2, y + 2);

        // Text
        ctx.fillStyle = '#f1c40f';
        ctx.fillText(text, x, y);

        // Status
        ctx.font = '12px VT323, monospace';
        ctx.fillStyle = this.getStatusColor();
        ctx.fillText(`HEALTH: ${this.getStatusLabel()}`, x, y + 18);
    }

    /**
     * Set hover state
     */
    setHovered(hovered) {
        this.targetScale = hovered ? 1.1 : 1;
    }
}

export default Location;
