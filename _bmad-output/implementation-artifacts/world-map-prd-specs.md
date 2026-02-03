# MCOP Quest - World Map PRD Specifications

## Document Information
- **Source**: `world-map-v2.html`
- **Generated**: 2026-02-03
- **Purpose**: Extract detailed UI/UX specifications for Product Requirements Document

---

## 1. Header Section

### Layout & Styling
- **Position**: Sticky header at top (z-index: 100)
- **Background**: Gradient from `#2c1810` to `#1a0f0a`
- **Border**: 3px solid `#8b6914` at bottom
- **Shadow**: `0 4px 20px rgba(0, 0, 0, 0.5)`
- **Max Width**: 1400px, centered

### Elements
| Element | Content | Styling |
|---------|---------|---------|
| Title | "MCOP Quest" | Font: Cinzel, 3xl (mobile: 2xl), Color: `#fbbf24` (amber-400), Text shadow: `2px 2px 4px rgba(0,0,0,0.5)` |
| Coin Counter | Coin icon + "2,450" | Background: gradient `#3d2418` to `#2c1810`, Border: 2px `#8b6914`, Rounded: 8px |
| Diamond Counter | Diamond icon + "15" | Same as coin counter, Color: cyan-400/cyan-200 |

### Icons
- Coin: `\u{1FA99}` (coin emoji)
- Diamond: `\u{1F48E}` (gem emoji)

---

## 2. Canvas Map Area

### Container Specifications
- **Height**: `calc(100vh - 220px)`, minimum 500px
- **Background**: Gradient from `#1a3320` to `#2d5016`
- **Frame**: Golden border with border-image gradient (gold tones)
- **Overflow**: Hidden

### Canvas Element
- **ID**: `game-map`
- **Cursor**: `grab` (default), `grabbing` (on drag)
- **Full Size**: Fills container

### Grid Configuration
| Property | Value |
|----------|-------|
| Grid Size | 40 columns x 30 rows |
| Tile Size | 128px |
| Total Map Width | 5,120px (40 * 128) |
| Total Map Height | 3,840px (30 * 128) |

### Terrain Rendering
- **Grass Colors**: `['#2d5016', '#3d6b26', '#1a4010']` (deterministic based on position)
- **Texture**: Subtle dark overlay on every 5th tile
- **Grid Overlay**: Very subtle white lines at 3% opacity

### Cities/Locations (8 Total)

| ID | Name (EN) | Name (TH) | Position (x, y) | Type | Health | Status |
|----|-----------|-----------|-----------------|------|--------|--------|
| member_city | Member City | เมืองสมาชิก | (1536, 1024) | castle | 100/100 | full |
| task_tower | Task Tower | หอคอยภารกิจ | (2560, 640) | tower | 75/100 | stable |
| bug_bastion | Bug Bastion | ป้อมบั๊ก | (3840, 1280) | bastion | 45/100 | medium |
| alchemy_lab | Analytics Lab | ห้องแล็บวิเคราะห์ | (1792, 2048) | lab | 85/100 | stable |
| community_commons | Community Commons | ลานชุมชน | (1024, 2816) | market | 90/100 | full |
| payment_fortress | Payment Fortress | ป้อมการเงิน | (3200, 2560) | fortress | 20/100 | low |
| product_city | Product City | เมืองสินค้า | (512, 512) | merchant | 80/100 | stable |
| notification_tower | Notification Tower | หอสัญญาณ | (4224, 512) | bell_tower | 95/100 | full |

### Location Types & Icons
| Type | Icon (Unicode) | Icon Char |
|------|----------------|-----------|
| castle | `\u{1F3F0}` | 🏰 |
| tower | `\u{1F3EF}` | 🏯 |
| bastion | `\u{1F6E1}` | 🛡 |
| lab | `\u{2697}` | ⚗ |
| market | `\u{1F3ED}` | 🏭 |
| fortress | `\u{1F3DB}` | 🏛 |
| merchant | `\u{1F4B0}` | 💰 |
| bell_tower | `\u{1F514}` | 🔔 |

### Roads (Connecting Cities)
8 road segments connecting the cities in a network pattern:
1. (4,4) to (12,8)
2. (12,8) to (14,16)
3. (14,16) to (8,22)
4. (12,8) to (20,5)
5. (20,5) to (30,10)
6. (30,10) to (25,20)
7. (8,22) to (25,20)
8. (20,5) to (33,4)

**Road Styling**:
- Color: `#8b7355`
- Width: 8px * zoom level
- Line cap/join: Round

### Health Status Color Coding
| Status | Health Range | Color | Hex |
|--------|--------------|-------|-----|
| Full | 90-100% | Green | `#2ecc71` |
| Stable | 60-89% | Blue | `#3498db` |
| Medium | 30-59% | Yellow | `#f1c40f` |
| Low | <30% | Red | `#e74c3c` |
| Fog of War | N/A | Gray | `#95a5a6` |

### Location Visual Elements
Each location displays:
1. **Pulse Glow** (if current location): Animated green glow with sin wave opacity
2. **Marker Circle**: Colored circle based on health status
3. **Gold Border**: 3px * zoom level
4. **Inner Highlight**: White semi-circle for 3D effect
5. **Type Icon**: Centered emoji
6. **Label**: City name below marker (Cinzel font, white with black outline)
7. **Health Bar**: 40px width bar showing health percentage

---

## 3. Minimap (Top Left)

### Container Specifications
- **Position**: Absolute, top: 16px, left: 16px
- **Size**: 180px x 140px (mobile: 140px x 110px)
- **Z-Index**: 20
- **Background**: Gradient `#3d2418` to `#2c1810`
- **Border**: 2px solid `#8b6914`, border-radius: 12px
- **Padding**: 10px (mobile: 8px)

### Title
- Text: "World Overview"
- Font: Cinzel, 11px
- Color: `#d4a853`
- Text align: Center
- Margin bottom: 6px

### Canvas
- **ID**: `minimap`
- **Internal Size**: 160px x 100px
- **Background**: `#1a3320`
- **Border**: 1px solid `#5c4018`, border-radius: 6px

### Minimap Content
1. **Roads**: Brown lines (#8b7355), 2px width
2. **Location Dots**: 8px circles (12px for current), colored by health
3. **Current Location Glow**: Green glow effect
4. **Viewport Rectangle**: Gold border (#f1c40f) showing visible area

---

## 4. Legend Panel (Top Right)

### Container Specifications
- **Position**: Absolute, top: 16px, right: 16px
- **Z-Index**: 20
- **Min Width**: 160px
- **Background**: Gradient with 95% opacity (`rgba(61, 36, 24, 0.95)` to `rgba(44, 24, 16, 0.95)`)
- **Border**: 2px solid `#8b6914`, border-radius: 12px
- **Padding**: 12px 16px

### Title
- Text: "📍 Location Status"
- Font: Cinzel, 12px
- Color: `#d4a853`
- Text align: Center
- Border bottom: 1px solid `#5c4018`
- Padding bottom: 6px

### Legend Items (6 Total)

| Status | Dot Color | Text |
|--------|-----------|------|
| You Are Here | `#2ecc71` with glow | "You Are Here" |
| Full Health | `#2ecc71` | "Full Health (90%+)" |
| Stable | `#3498db` | "Stable (60-89%)" |
| Medium | `#f1c40f` | "Medium (30-59%)" |
| Low | `#e74c3c` | "Low (<30%)" |
| Fog of War | `#95a5a6` | "Fog of War" |

### Legend Dot Styling
- Size: 12px x 12px
- Border radius: 50%
- Border: 2px solid `#f1c40f`
- Current location has box-shadow glow

### Responsive Behavior
- **Mobile (< 768px)**: Hidden (`display: none`)

---

## 5. Zoom Controls (Bottom Right)

### Container Specifications
- **Position**: Absolute, bottom: 20px, right: 20px
- **Z-Index**: 20
- **Layout**: Flex column, gap: 8px

### Buttons
| Button | Icon | Action |
|--------|------|--------|
| Zoom In | + | Increase zoom by 1.3x |
| Zoom Out | − | Decrease zoom by 1.3x |

### Button Styling
- **Size**: 44px x 44px (mobile: 40px x 40px)
- **Background**: Gradient `#3d2418` to `#2c1810`
- **Border**: 2px solid `#8b6914`, border-radius: 8px
- **Font**: Cinzel, 24px, bold
- **Color**: `#d4a853`
- **Hover**: Lighter gradient, gold border, scale(1.05)

### Camera/Zoom Configuration
| Property | Value |
|----------|-------|
| Initial Zoom | 0.6 |
| Min Zoom | 0.3 |
| Max Zoom | 2.0 |
| Zoom Factor (buttons) | 1.3 |
| Zoom Factor (scroll) | 0.9 / 1.1 |

---

## 6. Status Bar (Bottom)

### Container Specifications
- **Background**: Gradient `#2c1810` to `#1a0f0a`
- **Border Top**: 2px solid `#8b6914`
- **Padding**: 12px 20px
- **Layout**: Flex, space-between, wrap
- **Gap**: 10px

### Left Section
| Element | Content | Styling |
|---------|---------|---------|
| Location Label | "Location: " | Color: `#fde68a` (amber-200) |
| Current Location | Dynamic | Color: white, font-weight: bold |
| Separator | " | " | Color: `#b45309` (amber-700) |
| Tasks Label | "Active Tasks: " | Color: `#fde68a` |
| Task Count | "5" | Color: `#4ade80` (green-400), font-weight: bold |

### Right Section
- **Text**: "Drag to pan • Scroll to zoom • Click locations"
- **Color**: `#fbbf24` (amber-400)
- **Font Size**: 14px (text-sm)
- **Dynamic**: Updates to show hovered location info

---

## 7. Interactions

### Drag to Pan
- **Trigger**: Mouse down + move / Touch start + move
- **Behavior**: Map pans following cursor/finger
- **Cursor**: Changes from `grab` to `grabbing`

### Scroll to Zoom
- **Trigger**: Mouse wheel
- **Behavior**: Zoom in/out towards mouse position
- **Prevention**: `e.preventDefault()` to stop page scroll

### Click Location
- **Trigger**: Click on location marker
- **Behavior**: Opens location detail modal
- **Hover Detection**: 40px radius from location center
- **Cursor**: Changes to `pointer` on hover

### Minimap Click (Future Enhancement)
- **Expected Behavior**: Click on minimap to jump viewport to that location

### Touch Support
- Single finger drag for panning
- `preventDefault()` on touchmove to prevent page scroll

---

## 8. Location Modal

### Container Specifications
- **Position**: Fixed, inset: 0
- **Background**: `rgba(0, 0, 0, 0.8)` (overlay)
- **Display**: Flex, centered
- **Z-Index**: 100
- **Padding**: 20px

### Modal Content
- **Max Width**: 400px
- **Width**: 100%
- **Background**: Gradient `#3d2418` to `#2c1810`
- **Border**: 3px solid `#8b6914`, border-radius: 16px
- **Padding**: 24px
- **Shadow**: `0 20px 60px rgba(0, 0, 0, 0.5)`

### Modal Title
- **ID**: `modal-title`
- **Font**: Cinzel, 24px
- **Color**: `#d4a853`
- **Text Align**: Center
- **Margin Bottom**: 16px

### Modal Info Content
Dynamic HTML structure:
```html
<p><strong>Thai Name:</strong> {nameTh}</p>
<p><strong>Health:</strong> {health}/{maxHealth} [YOU ARE HERE badge]</p>
<p><strong>Status:</strong> <span class="health-indicator {statusClass}">{statusText}</span></p>
<p><strong>Type:</strong> {TYPE}</p>
<!-- Warning if foggy -->
```

### Health Indicator Classes
| Class | Background | Text Color |
|-------|------------|------------|
| health-full | `rgba(46, 204, 113, 0.2)` | `#2ecc71` |
| health-stable | `rgba(52, 152, 219, 0.2)` | `#3498db` |
| health-medium | `rgba(241, 196, 15, 0.2)` | `#f1c40f` |
| health-low | `rgba(231, 76, 60, 0.2)` | `#e74c3c` |
| health-foggy | `rgba(149, 165, 166, 0.2)` | `#95a5a6` |

### Close Button
- **Text**: "Close"
- **Width**: 100%
- **Margin Top**: 20px
- **Background**: Gradient `#8b6914` to `#6b5010`
- **Border**: 2px solid `#d4a853`
- **Color**: `#f4e8d0`
- **Padding**: 12px
- **Border Radius**: 8px
- **Font**: Cinzel, 16px

### Close Triggers
1. Click "Close" button
2. Click outside modal (overlay)

---

## 9. Loading Overlay

### Container Specifications
- **Position**: Absolute, inset: 0
- **Background**: `#1a1510`
- **Z-Index**: 50
- **Display**: Flex column, centered
- **Transition**: Opacity 0.5s

### Spinner
- **Size**: 60px x 60px
- **Border**: 4px solid `#d4a853`, top transparent
- **Border Radius**: 50%
- **Animation**: Spin 1s linear infinite

### Loading Text
- Text: "Loading Kingdom..."
- Color: `#fbbf24` (amber-400)
- Font: Cinzel, 20px (text-xl)
- Margin Top: 16px

### Hide Animation
- Class: `hidden`
- Opacity: 0
- Pointer Events: none
- Trigger: 800ms after init

---

## 10. Bottom Navigation

### Container Specifications
- **Position**: Fixed, bottom: 0, left: 0, right: 0
- **Z-Index**: 100
- **Background**: Gradient `#2c1810` to `#1a0f0a`
- **Border Top**: 3px solid `#8b6914`
- **Shadow**: `0 -4px 20px rgba(0, 0, 0, 0.5)`

### Nav Content
- **Max Width**: 800px, centered
- **Layout**: Flex, space-around
- **Padding**: 10px 0

### Navigation Items (4 Total)

| Route | Icon | Label | Active |
|-------|------|-------|--------|
| hero-v2.html | ⚔️ | Hero | No |
| team-v2.html | 👥 | Team | No |
| world-map-v2.html | 🗺️ | World | Yes |
| shop-v2.html | 🛒 | Shop | No |

### Nav Item Styling
- **Layout**: Flex column, centered
- **Gap**: 5px
- **Padding**: 8px 20px
- **Color (inactive)**: `#5c4018`
- **Color (active/hover)**: `#d4a853`
- **Transition**: All 0.3s ease

### Active Indicator
- Gold top border: 3px height, 40px width
- Box shadow glow
- Position: -13px from top

### Icons
- **Size**: 24px
- **Font**: System emoji

### Labels
- **Font**: Cinzel, 11px
- **Font Weight**: 600

---

## 11. Color Palette

### Primary Colors
| Name | Hex | Usage |
|------|-----|-------|
| Background Dark | `#1a0f0a` | Page background |
| Background Medium | `#2c1810` | Header, panels |
| Background Light | `#3d2418` | Elevated elements |
| Gold Primary | `#d4a853` | Text highlights, borders |
| Gold Border | `#8b6914` | Borders, accents |
| Parchment | `#f4e8d0` | Primary text |
| Amber Light | `#fde68a` | Labels |

### Status Colors
| Status | Hex | RGBA Background |
|--------|-----|-----------------|
| Full/Current | `#2ecc71` | `rgba(46, 204, 113, 0.2)` |
| Stable | `#3498db` | `rgba(52, 152, 219, 0.2)` |
| Medium | `#f1c40f` | `rgba(241, 196, 15, 0.2)` |
| Low | `#e74c3c` | `rgba(231, 76, 60, 0.2)` |
| Foggy | `#95a5a6` | `rgba(149, 165, 166, 0.2)` |

### Map Colors
| Element | Hex |
|---------|-----|
| Grass Dark | `#1a4010` |
| Grass Medium | `#2d5016` |
| Grass Light | `#3d6b26` |
| Road | `#8b7355` |
| Water/Deep | `#1a3320` |

---

## 12. Typography

### Font Families
| Usage | Font | Fallback |
|-------|------|----------|
| Headings/Titles | Cinzel | serif |
| Body Text | Crimson Text | Georgia, serif |
| Monospace/Numbers | VT323 | monospace |

### Font Sizes
| Element | Size | Notes |
|---------|------|-------|
| Page Title | 2.25rem (3xl) | Mobile: 1.5rem (2xl) |
| Modal Title | 24px | |
| Resource Counter | 20px (xl) | |
| Status Bar | 14px (sm) | |
| Legend Title | 12px | |
| Nav Label | 11px | |
| Minimap Title | 11px | |

---

## 13. Responsive Breakpoints

### Desktop (> 768px)
- Full layout with all panels visible
- Header: 4xl title
- Minimap: 180px x 140px
- Zoom buttons: 44px

### Tablet/Mobile (<= 768px)
- Legend panel: Hidden
- Minimap: 140px x 110px
- Zoom buttons: 40px
- Zoom controls: bottom: 100px (above nav)
- Compass: 44px

### Small Mobile (<= 480px)
- Header title: 24px
- Resource counter: Smaller padding (6px 10px), 14px font

---

## 14. Animation Specifications

### Current Location Pulse
```javascript
const pulse = Math.sin(this.time * 3) * 0.3 + 0.7;
// Inner glow: rgba(46, 204, 113, ${0.4 * pulse})
// Outer glow: rgba(46, 204, 113, ${0.2 * pulse})
```
- Frequency: 3 cycles per second
- Opacity range: 0.4 to 0.7 (inner), 0.2 to 0.5 (outer)

### Loading Spinner
- Animation: `spin 1s linear infinite`
- Transform: rotate(360deg)

### Hover Effects
- Zoom buttons: scale(1.05), border color change
- Nav items: Color transition 0.3s
- Modal: Fade in via opacity

---

## 15. JavaScript API

### MapRenderer Class
```javascript
class MapRenderer {
  constructor(canvasId, mapData, options)

  // Methods
  zoomIn()        // Zoom by 1.3x
  zoomOut()       // Zoom by 1/1.3x
  resize()        // Handle window resize

  // Options callbacks
  onLocationClick(location)  // Called on location click
  onLocationHover(location)  // Called on location hover
}
```

### Map Data Structure
```javascript
{
  width: 40,           // Grid columns
  height: 30,          // Grid rows
  tileSize: 128,       // Pixels per tile
  locations: [...],    // Array of location objects
  roads: [...]         // Array of road segments
}
```

### Location Object
```javascript
{
  id: string,          // Unique identifier
  name: string,        // English name
  nameTh: string,      // Thai name
  x: number,           // World X position (pixels)
  y: number,           // World Y position (pixels)
  type: string,        // Location type (castle, tower, etc.)
  health: number,      // Current health
  maxHealth: number,   // Maximum health
  status: string,      // Status string
  isFoggy: boolean,    // Fog of war state
  isCurrent: boolean   // Is current location
}
```

---

## 16. Accessibility Considerations

### Current Implementation
- Semantic HTML structure
- ARIA labels not explicitly implemented
- Color contrast: Gold on dark backgrounds passes WCAG AA
- Interactive elements have hover/focus states

### Recommendations
- Add `aria-label` to zoom buttons
- Add `role="dialog"` to modal
- Implement keyboard navigation for locations
- Add `aria-live` for status bar updates
- Ensure focus trap in modal

---

## 17. Performance Considerations

### Optimizations Implemented
- RequestAnimationFrame for render loop
- Canvas-based rendering (GPU accelerated)
- Deterministic terrain generation (no random calls)
- Efficient viewport culling (only render visible tiles)
- Passive event listeners where possible

### Map Size
- Total tiles: 1,200 (40 x 30)
- Tile size: 128px
- World dimensions: 5,120 x 3,840 pixels
- Locations: 8
- Roads: 8 segments

---

*End of Specifications Document*
