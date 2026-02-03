# Hero Dashboard Page - PRD Specifications

## Overview
The Hero Dashboard serves as the central hub for players to view their hero's status, active battles, tasks, equipment, and recent activities. This page follows a fantasy RPG aesthetic with a dark brown color palette and gold accents.

---

## 1. Page Structure

### 1.1 Header
**Position:** Sticky top header, full width
**Background:** Linear gradient from `#2c1810` to `#1a0f0a`
**Border:** 3px solid `#8b6914` at bottom
**Shadow:** `0 4px 20px rgba(0, 0, 0, 0.5)`
**Z-Index:** 100

**Content Layout (max-width: 800px, centered):**
- **Left Side:**
  - Title: "Hero Dashboard" (font: Cinzel, 20px, color: `#d4a853`)
  - Subtitle: "{HeroName} - {Class}" (font: 12px, color: `#8b6914`, margin-top: 2px)

- **Right Side - Currency Display:**
  - Flex container with gap: 15px
  - Two currency items:
    1. **Gold:** Icon (🪙) + Value (e.g., "2,450")
    2. **Gems:** Icon (💎) + Value (e.g., "15")
  - Currency item styling:
    - Background: `rgba(0, 0, 0, 0.3)`
    - Padding: 6px 12px
    - Border-radius: 20px
    - Border: 1px solid `#5c4018`
    - Icon size: 16px
    - Value: font-weight 600, color `#d4a853`

### 1.2 Main Content Container
**Max-width:** 800px, centered
**Padding:** 20px
**Bottom padding:** 80px (to account for bottom navigation)

### 1.3 Background
**Base:** Linear gradient 135deg from `#1a0f0a` through `#2c1810` to `#1a0f0a`
**Overlay Pattern:**
- Radial gradient at 20% 30%: `rgba(212, 168, 83, 0.08)`
- Radial gradient at 80% 70%: `rgba(192, 57, 43, 0.05)`
- SVG pattern: Cross/plus symbols at 2% opacity in gold

---

## 2. Hero Card Section

### 2.1 Container Styling
**Background:** Linear gradient 145deg from `#4a2e1f` to `#3d2418`
**Border:** 3px solid `#8b6914`, border-radius: 20px
**Padding:** 25px
**Margin-bottom:** 25px
**Box-shadow:**
- Inset: `0 0 30px rgba(0, 0, 0, 0.4)`
- Drop: `0 10px 30px rgba(0, 0, 0, 0.5)`
**Decorative Element:** Diamond symbol (◆) centered at top, positioned -12px from top, gold color (`#d4a853`), background matches card

### 2.2 Hero Header Layout
**Display:** Flex, gap: 20px, align-items: center
**Margin-bottom:** 20px

#### Hero Avatar
**Size:** 100px x 100px (80px on mobile)
**Background:** Linear gradient 145deg from `#3d2418` to `#2c1810`
**Border:** 3px solid `#d4a853`, border-radius: 50%
**Box-shadow:** `0 0 20px rgba(212, 168, 83, 0.3)`
**Content:** Hero class icon (emoji), font-size: 50px (40px on mobile)
**Animated Border:**
- Pseudo-element with 2px dashed `#8b6914` border
- Positioned -6px from edge (inset)
- Animation: rotate 20s linear infinite

#### Level Badge
**Position:** Absolute, bottom: -5px, right: -5px
**Background:** `#d4a853`
**Color:** `#1a0f0a`
**Font:** 12px, bold
**Padding:** 4px 10px
**Border-radius:** 20px
**Border:** 2px solid `#2c1810`

### 2.3 Hero Info
**Flex:** 1 (takes remaining space)

- **Hero Name:**
  - Font: Cinzel, 28px (22px on mobile)
  - Color: `#f4e8d0`
  - Margin-bottom: 5px

- **Hero Class:**
  - Font: 16px
  - Color: `#9b59b6` (purple)
  - Format: "{classIcon} {ClassName} ({Role})"
  - Example: "⚔️ Warrior (Backend Dev)"
  - Margin-bottom: 15px

### 2.4 XP Bar Section
**Margin-top:** 15px

- **XP Header:**
  - Display: flex, justify-content: space-between
  - Font-size: 14px
  - Margin-bottom: 8px
  - Label: "EXPERIENCE" (uppercase, letter-spacing: 0.1em, color: `#8b6914`)
  - Value: "{currentXP} / {maxXP} XP" (color: `#d4a853`)

- **XP Bar Container:**
  - Height: 12px
  - Background: `#1a0f0a`
  - Border: 2px solid `#5c4018`
  - Border-radius: 6px
  - Overflow: hidden

- **XP Fill:**
  - Height: 100%
  - Background: Linear gradient 90deg from `#d4a853` to `#f4d03f`
  - Border-radius: 4px
  - Shine effect: Pseudo-element with gradient from white 30% opacity to transparent, height 40%

### 2.5 Stats Grid
**Display:** Grid, 3 columns (1 column on mobile)
**Gap:** 15px
**Margin-top:** 20px
**Padding-top:** 20px
**Border-top:** 1px solid `#5c4018`

**Stat Item:**
- Text-align: center
- Padding: 15px
- Background: `rgba(0, 0, 0, 0.2)`
- Border-radius: 12px
- Border: 1px solid `#5c4018`

**Stat Value:**
- Font: Cinzel, 24px
- Color: `#d4a853`
- Margin-bottom: 5px

**Stat Label:**
- Font-size: 12px
- Color: `#8b6914`
- Text-transform: uppercase
- Letter-spacing: 0.1em

**Stats Displayed:**
1. Victories (count)
2. Gold (amount)
3. Gems (amount)

---

## 3. Battle Scene Section

### 3.1 Container Styling
**Background:** Linear gradient 145deg from `#3d2418` to `#2c1810`
**Border:** 2px solid `#c0392b` (red)
**Border-radius:** 16px
**Padding:** 20px
**Margin-bottom:** 25px

### 3.2 Battle Header
**Display:** Flex, align-items: center
**Gap:** 10px
**Margin-bottom:** 15px
**Color:** `#e74c3c`

- **Icon:** ⚔️
- **Title:** "Currently Fighting" (font: Cinzel, 16px)
- **Count Badge:** "{n} Minions"
  - Background: `rgba(192, 57, 43, 0.2)`
  - Padding: 4px 10px
  - Border-radius: 20px
  - Font-size: 12px
  - Margin-left: auto

### 3.3 Battle Arena
**Background:** Linear gradient 180deg from `#1a0f0a` to `#0d0705`
**Border-radius:** 12px
**Padding:** 20px
**Display:** Flex, justify-content: space-between, align-items: center
**Min-height:** 120px
**Border:** 1px solid `#5c4018`

#### Hero Side
- Text-align: center
- Hero mini avatar: 50px emoji
- Animation: float 2s ease-in-out infinite

#### VS Divider
- Font-size: 24px
- Color: `#8b6914`

#### Monster Side
**Display:** Flex, gap: 10px (column on mobile)

**Monster Item:**
- Text-align: center
- Animation: shake 2s ease-in-out infinite (staggered: 0s, 0.3s, 0.6s)

**Shake Animation Keyframes:**
```
0%, 100% { transform: translateX(0); }
25% { transform: translateX(-3px) rotate(-2deg); }
75% { transform: translateX(3px) rotate(2deg); }
```

**Monster Icon:** 40px emoji (👾)
**Monster Type:** 10px, color `#9b59b6` (API, FE, etc.)

---

## 4. Active Tasks Section

### 4.1 Container Styling
**Background:** Linear gradient 145deg from `#3d2418` to `#2c1810`
**Border:** 2px solid `#8b6914`
**Border-radius:** 16px
**Padding:** 20px
**Margin-bottom:** 25px

### 4.2 Section Title
**Font:** Cinzel, 20px
**Color:** `#d4a853`
**Margin-bottom:** 15px
**Display:** Flex, align-items: center, gap: 10px
**Divider:** After pseudo-element with gradient from `#8b6914` to transparent

### 4.3 Task List
**Display:** Flex, flex-direction: column
**Gap:** 10px

**Task Item:**
- Display: flex, align-items: center
- Gap: 12px
- Padding: 12px 15px
- Background: `rgba(0, 0, 0, 0.2)`
- Border-radius: 10px
- Border: 1px solid `#5c4018`
- Transition: all 0.3s ease
- Hover: border-color `#d4a853`, background `rgba(212, 168, 83, 0.05)`

**Task Icon:** 20px emoji

**Task Info:**
- Flex: 1
- Name: 15px, color `#f4e8d0`, margin-bottom: 2px
- Meta: 12px, color `#8b6914` (Format: "Flow: {flowName}")

**Task Status Badge:**
- Padding: 4px 12px
- Border-radius: 20px
- Font-size: 11px
- Font-weight: 600
- Text-transform: uppercase

**Status Types:**
- **Doing:** Background `rgba(243, 156, 18, 0.2)`, color `#f39c12`, border 1px solid `#f39c12`
- **Pending:** Background `rgba(127, 140, 141, 0.2)`, color `#7f8c8d`, border 1px solid `#7f8c8d`

---

## 5. Equipment Section

### 5.1 Container Styling
**Background:** Linear gradient 145deg from `#3d2418` to `#2c1810`
**Border:** 2px solid `#8b6914`
**Border-radius:** 16px
**Padding:** 20px
**Margin-bottom:** 25px

### 5.2 Section Title
Same styling as Active Tasks section title with 🛡️ icon

### 5.3 Equipment Grid
**Display:** Grid, 3 columns (2 columns on mobile)
**Gap:** 15px

**Equipment Slot:**
- Aspect-ratio: 1
- Background: `rgba(0, 0, 0, 0.3)`
- Border: 2px solid `#5c4018` (or `#8b6914` when occupied)
- Border-radius: 12px
- Display: flex, flex-direction: column, align-items: center, justify-content: center
- Cursor: pointer
- Transition: all 0.3s ease
- Hover: border-color `#d4a853`, box-shadow `0 0 15px rgba(212, 168, 83, 0.2)`

**Occupied State:**
- Border-color: `#8b6914`
- Background: `rgba(212, 168, 83, 0.05)`

**Slot Content:**
- Icon: 28px emoji
- Label: 10px, color `#8b6914`, uppercase
- Item Name: 11px, color `#2ecc71` (only when occupied)

**Slot Positions (6 slots):**
1. Head (🪖)
2. L.Hand (🛡️)
3. Body (🛡️)
4. R.Hand (⚔️)
5. Legs (👖)
6. Feet (👢)

---

## 6. Damage Contribution Chart

### 6.1 Container Styling
**Background:** Linear gradient 145deg from `#3d2418` to `#2c1810`
**Border:** 2px solid `#8b6914`
**Border-radius:** 16px
**Padding:** 20px
**Margin-bottom:** 25px

### 6.2 Section Title
Same styling with 📊 icon

### 6.3 Chart Bar
**Margin-bottom:** 15px

**Bar Container:**
- Height: 24px
- Background: `#1a0f0a`
- Border: 2px solid `#5c4018`
- Border-radius: 12px
- Overflow: hidden
- Display: flex

**Chart Segments:**
- Height: 100%
- Transition: all 0.3s ease
- Hover: opacity 0.9

**Segment Types & Colors:**
| Type | Color | Example Width |
|------|-------|---------------|
| Design | `#E67E22` (Orange) | 5% |
| AC | `#3498DB` (Blue) | 5% |
| API | `#9B59B6` (Purple) | 70% |
| FE | `#1ABC9C` (Teal) | 15% |
| Testing | `#F1C40F` (Yellow) | 5% |

### 6.4 Legend
**Display:** Flex, flex-wrap
**Gap:** 12px
**Justify-content:** center

**Legend Item:**
- Display: flex, align-items: center
- Gap: 6px
- Font-size: 12px

**Legend Dot:**
- Width/Height: 10px
- Border-radius: 50%
- Colors match chart segments

**Legend Label:** Color `#8b6914`
**Legend Value:** Color `#d4a853`, font-weight 600

---

## 7. Recent Activity Section

### 7.1 Container Styling
**Background:** Linear gradient 145deg from `#3d2418` to `#2c1810`
**Border:** 2px solid `#8b6914`
**Border-radius:** 16px
**Padding:** 20px
**Margin-bottom:** 25px

### 7.2 Section Title
Same styling with 📜 icon
**Optional Badge:** "This Week" - positioned right
- Font-size: 11px
- Background: `rgba(0, 0, 0, 0.3)`
- Color: `#8b6914`
- Padding: 4px 10px
- Border-radius: 20px
- Margin-left: auto

### 7.3 Activity List
**Display:** Flex, flex-direction: column
**Gap:** 15px

**Activity Item:**
- Display: flex
- Gap: 12px
- Align-items: flex-start

**Activity Icon Container:**
- Width/Height: 44px
- Border-radius: 50%
- Display: flex, align-items: center, justify-content: center
- Font-size: 20px
- Flex-shrink: 0

**Icon Types:**
- **Victory:** Background `rgba(46, 204, 113, 0.15)`, border `rgba(46, 204, 113, 0.3)`
- **Level Up:** Background `rgba(212, 168, 83, 0.15)`, border `rgba(212, 168, 83, 0.3)`
- **Defeat:** Background `rgba(155, 89, 182, 0.15)`, border `rgba(155, 89, 182, 0.3)`

**Activity Content:**
- Flex: 1

**Activity Text:**
- Color: `#f4e8d0`
- Font-size: 14px
- Margin-bottom: 3px

**Activity Highlight Classes:**
- `.api` - Color `#9B59B6`
- `.gold` - Color `#d4a853`
- `.success` - Color `#2ecc71`

**Activity Meta:**
- Color: `#8b6914`
- Font-size: 12px

**Activity Types:**
1. **Victory:** "Defeated Minion: {highlighted task}"
2. **Level Up:** "Level Up! {highlighted level}"
3. **Commander Defeated:** "Commander Defeated: {highlighted flow}"

---

## 8. Bottom Navigation

### 8.1 Container Styling
**Position:** Fixed, bottom: 0
**Width:** 100%
**Background:** Linear gradient 180deg from `#2c1810` to `#1a0f0a`
**Border-top:** 3px solid `#8b6914`
**Box-shadow:** `0 -4px 20px rgba(0, 0, 0, 0.5)`
**Z-index:** 100

### 8.2 Navigation Content
**Max-width:** 800px, centered
**Display:** Flex, justify-content: space-around
**Padding:** 10px 0

### 8.3 Navigation Items
**Display:** Flex, flex-direction: column
**Align-items:** center
**Gap:** 5px
**Padding:** 8px 20px
**Color:** `#5c4018` (inactive), `#d4a853` (active/hover)
**Text-decoration:** none
**Transition:** all 0.3s ease
**Position:** relative

**Active State Indicator:**
- Pseudo-element before
- Position: absolute, top: -13px
- Width: 40px, height: 3px
- Background: `#d4a853`
- Box-shadow: `0 0 10px rgba(212, 168, 83, 0.5)`

**Navigation Icon:** 24px
**Navigation Label:** 11px, font-weight 600

**Navigation Items (4 total):**
1. **Hero** - Icon: ⚔️, Link: hero-v2.html
2. **Team** - Icon: 👥, Link: team-v2.html
3. **World** - Icon: 🗺️, Link: world-map-v2.html
4. **Shop** - Icon: 🛒, Link: shop-v2.html

---

## 9. Typography

### 9.1 Font Families
- **Headers:** 'Cinzel', serif
- **Body:** 'Crimson Text', Georgia, serif

### 9.2 Google Fonts Import
```html
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
```

### 9.3 Font Sizes
| Element | Size | Weight |
|---------|------|--------|
| Page Title | 20px | 400/700 |
| Hero Name | 28px | 400 |
| Section Title | 20px | 400 |
| Stat Value | 24px | 400 |
| Body Text | 14-16px | 400/600 |
| Labels | 10-12px | 400 |
| Badges | 11px | 600 |

---

## 10. Color Palette

### 10.1 Primary Colors
| Name | Hex | Usage |
|------|-----|-------|
| Dark Brown | `#1a0f0a` | Background base |
| Medium Brown | `#2c1810` | Card backgrounds, headers |
| Light Brown | `#3d2418` | Card gradients |
| Lighter Brown | `#4a2e1f` | Card highlights |

### 10.2 Accent Colors
| Name | Hex | Usage |
|------|-----|-------|
| Gold Primary | `#d4a853` | Primary accent, titles, values |
| Gold Dark | `#8b6914` | Borders, secondary text |
| Gold Medium | `#5c4018` | Subtle borders, dividers |
| Cream | `#f4e8d0` | Primary text |

### 10.3 Semantic Colors
| Name | Hex | Usage |
|------|-----|-------|
| Red | `#c0392b` | Battle borders, danger |
| Red Light | `#e74c3c` | Battle text |
| Purple | `#9b59b6` | Class text, API highlights |
| Green | `#2ecc71` | Equipment names, success |
| Orange | `#f39c12` | Doing status |
| Gray | `#7f8c8d` | Pending status |

### 10.4 Chart Colors
| Type | Hex |
|------|-----|
| Design | `#E67E22` |
| AC | `#3498DB` |
| API | `#9B59B6` |
| FE | `#1ABC9C` |
| Testing | `#F1C40F` |

---

## 11. Responsive Breakpoints

### 11.1 Mobile (< 600px)
- Hero header: flex-direction column, text-align center
- Hero avatar: 80px
- Hero name: 22px
- Stats grid: 1 column
- Equipment grid: 2 columns
- Monster side: flex-direction column

### 11.2 Tablet/Desktop (>= 600px)
- Hero header: flex-direction row
- Hero avatar: 100px
- Hero name: 28px
- Stats grid: 3 columns
- Equipment grid: 3 columns
- Monster side: flex-direction row

---

## 12. Animations

### 12.1 Rotate Animation (Avatar Border)
```css
@keyframes rotate {
    to { transform: rotate(360deg); }
}
/* Duration: 20s, linear, infinite */
```

### 12.2 Float Animation (Hero Mini)
```css
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
/* Duration: 2s, ease-in-out, infinite */
```

### 12.3 Shake Animation (Monsters)
```css
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-3px) rotate(-2deg); }
    75% { transform: translateX(3px) rotate(2deg); }
}
/* Duration: 2s, ease-in-out, infinite */
/* Staggered delays: 0s, 0.3s, 0.6s */
```

---

## 13. Component Dependencies

### 13.1 External Libraries
- **Alpine.js** (v3.x): For reactive data binding
  - CDN: `https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js`
  - Load with `defer` attribute

### 13.2 CSS Dependencies
- **fantasy-theme.css**: External theme stylesheet

---

## 14. Data Structure

### 14.1 Hero Object
```javascript
{
    name: String,
    class: String,
    classIcon: String,
    role: String,
    level: Number,
    xp: {
        current: Number,
        max: Number
    },
    stats: {
        victories: Number,
        gold: Number,
        gems: Number
    }
}
```

### 14.2 Battle Object
```javascript
{
    status: String, // "fighting", "idle", etc.
    monsterCount: Number,
    monsters: [
        {
            icon: String,
            type: String // "API", "FE", etc.
        }
    ]
}
```

### 14.3 Task Object
```javascript
{
    id: Number,
    icon: String,
    name: String,
    flow: String,
    status: String // "doing", "pending"
}
```

### 14.4 Equipment Object
```javascript
{
    slot: String, // "head", "l.hand", "body", "r.hand", "legs", "feet"
    icon: String,
    label: String,
    itemName: String,
    occupied: Boolean
}
```

### 14.5 Contribution Data
```javascript
{
    design: Number, // percentage
    ac: Number,
    api: Number,
    fe: Number,
    testing: Number
}
```

### 14.6 Activity Object
```javascript
{
    id: Number,
    type: String, // "victory", "levelup", "defeat"
    icon: String,
    text: String,
    highlight: {
        text: String,
        class: String // "api", "gold", "success"
    },
    meta: String,
    timestamp: String
}
```

---

## 15. File Structure

```
/bmad-output/implementation-artifacts/fixed/
├── hero-v2.html          # Main hero dashboard page
├── css/
│   └── fantasy-theme.css # Shared theme styles
└── js/
    └── (Alpine.js via CDN)
```

---

*Document Version: 1.0*
*Last Updated: 2026-02-03*
*Based on: hero-v2.html prototype*
