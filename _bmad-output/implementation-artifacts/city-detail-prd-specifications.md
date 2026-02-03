# City Detail Page - PRD Specifications

## Overview
The City Detail page displays comprehensive information about a project "city" including its boss status, commanders (flows), active tasks, and bugs. The design follows a fantasy RPG aesthetic with parchment textures, golden frames, and pixel art elements.

---

## 1. Header Section

### Layout
- **Structure**: Flexbox row with three sections: left (back button + breadcrumb), center (city title), right (currency)
- **Positioning**: Fixed at top of content area, `mb-4` margin bottom
- **Responsive**: Stacks on mobile with reduced font sizes

### Components

#### Back to Map Button
- **Style**: Gradient background (`#4a4035` to `#2d2820`), 2px gold border
- **Icon**: Left arrow SVG (24x24)
- **Text**: "Back to Map" in Cinzel font
- **Hover Effect**: Translate X -3px, enhanced shadow
- **Link**: `world-map-v2.html`

#### Breadcrumb
- **Parent Label**: "World Map" in amber-600, text-sm
- **Current Title**: 
  - Icon: Castle emoji (🏰)
  - Text: "{City Name}" (e.g., "Member City System")
  - Font: Cinzel, 4xl, bold
  - Color: amber-400 with text shadow

#### Currency Display
- **Container**: Two resource counters side by side with gap-4
- **Gold Counter**:
  - Icon: Coin pixel art (24x24)
  - Value: "2,450" in amber-300, text-xl
- **Gems Counter**:
  - Icon: Gem pixel art (24x24)
  - Value: "15" in cyan-300, text-xl

---

## 2. City Boss Section

### Layout
- **Container**: Full-width card with gradient background (amber-100/50 to amber-50/30)
- **Border**: 4px amber-600/50 border, rounded-xl
- **Padding**: p-6
- **Structure**: Flexbox row - image left (flex-shrink-0), info right (flex-1)

### Visual Elements

#### Castle Image
- **Size**: 192x192px (w-48 h-48)
- **Style**: Pixel art rendering, drop-shadow-2xl
- **Source**: `assets-v2/castle.png`
- **Shadow**: Absolute positioned ellipse below for depth effect

#### Boss Information
- **Name**: "👑 King of {System}" (e.g., "King of Members")
  - Font: Cinzel, 3xl, bold
  - Color: amber-800
- **Subtitle**: "City Boss • System Module"
  - Color: amber-700, text-lg

#### Health Display
- **Overall Percentage**: 
  - Value: 75% (example)
  - Style: text-3xl, bold, amber-600
  - Label: "Overall Health" text-sm, amber-700
- **Main HP Bar**:
  - Container: health-bar-bg class (dark background, 2px border)
  - Height: h-6 (24px)
  - Fill: health-medium gradient (orange)
  - Width: Dynamic based on percentage
  - Border radius: rounded-lg

#### Status Information
- **Commanders Defeated**: "2/3 Commanders Defeated" in amber-800
- **Status Badge**:
  - Active: "⚔️ In Battle" - orange background, amber text
  - Defeated: "✓ Defeated" - green background, green text
  - Blocked: "🔒 Blocked" - red background, red text

---

## 3. Stats Panel

### Layout
- **Structure**: CSS Grid, 4 columns (`grid-cols-4`)
- **Gap**: gap-4
- **Margin**: mb-6

### Stat Boxes (4 boxes)
Each box follows this structure:
- **Background**: Gradient from `#2c2416` to `#1a1510`
- **Border**: 2px solid gold (`var(--border-gold)`)
- **Border Radius**: 8px
- **Padding**: 12px 16px
- **Text Align**: Center

#### Stats Displayed
1. **FLOWS**
   - Label: amber-400, xs, Cinzel font
   - Value: "3", amber-200, 2xl, bold

2. **TASKS**
   - Label: amber-400, xs, Cinzel font
   - Value: "12", amber-200, 2xl, bold

3. **BUGS**
   - Label: amber-400, xs, Cinzel font
   - Value: "2", red-400, 2xl, bold

4. **PROGRESS**
   - Label: amber-400, xs, Cinzel font
   - Value: "75%", green-400, 2xl, bold

---

## 4. Commanders Section

### Layout
- **Header**: H3 with sword icon (⚔️) and count
- **List**: Vertical stack with space-y-4
- **Cards**: Full-width clickable cards linking to commander detail

### Commander Card Structure

#### Card States
1. **Active** (`commander-card active`)
   - Border: 3px solid #f0ad4e (orange)
   - Shadow: 0 0 15px rgba(240, 173, 78, 0.3)
   
2. **Defeated** (`commander-card defeated`)
   - Border: 3px solid #4cae4c (green)
   - Opacity: 0.85
   - Character: Grayscale filter
   
3. **Blocked** (`commander-card blocked`)
   - Border: 3px solid #d9534f (red)
   - Character: Silhouette (brightness 0)

#### Card Content

**Header Row**:
- **Character SVG**: 60x75px, animated idle (commander-idle class)
  - Active: Full color with idle animation
  - Defeated: Grayscale + skull overlay
  - Blocked: Silhouette + lock overlay
- **Name**: "Flow: {FlowName}" in Cinzel, xl, bold
- **Status Badge**: Active/Defeated/Blocked with appropriate styling
- **Overall Percentage**: Large number (3xl, bold) with "Overall" label

**6 HP Bars Grid**:
- **Layout**: 2 columns on active/blocked, 3 columns on defeated
- **Gap**: gap-3 (active/blocked), gap-2 (defeated)
- **Bar Height**: h-2 (active/blocked), h-1.5 (defeated)

**HP Bar Types** (with color coding):
| Stage | Icon | Color Variable | Color Code |
|-------|------|----------------|------------|
| Design | 📐 | --hp-design | #E67E22 (Orange) |
| AC | 📋 | --hp-ac | #3498DB (Blue) |
| API | ⚙️ | --hp-api | #9B59B6 (Purple) |
| FE | 💻 | --hp-fe | #1ABC9C (Teal) |
| Testing | 🧪 | --hp-testing | #F1C40F (Yellow) |
| UAT | ✅ | --hp-uat | #2ECC71 (Green) |

**Assignees** (Active commanders only):
- Label: "Assignees:"
- Tags: Pill-shaped with amber-200/50 background, amber-400/50 border
- Example: Ken, Ton, May

**Block Reason** (Blocked commanders only):
- Container: Red background (red-100/50), red border
- Icon: Warning triangle (⚠️)
- Text: "Blocked: {Reason}"

---

## 5. Active Tasks Table

### Layout
- **Header**: H3 with document icon (📋)
- **Container**: Gradient background, rounded-xl, border
- **Table**: Full width with custom styling

### Table Structure

#### Header Row
- **Background**: Gradient from `#4a4035` to `#2d2820`
- **Text Color**: amber-200 (#e8d478)
- **Font**: Cinzel, 12px
- **Padding**: 10px
- **Columns**: Task, Flow, Stage, Assignee, Status

#### Data Rows
- **Text Color**: amber-900
- **Border Bottom**: 1px solid rgba(74, 64, 53, 0.3)
- **Hover**: Background rgba(201, 162, 39, 0.1)

#### Stage Badges
- **Design**: Orange background (bg-orange-200)
- **AC**: Blue background (bg-blue-200)
- **API**: Purple background (bg-purple-200)
- **FE**: Teal background (bg-teal-200)

#### Status Badges
- **In Progress**: status-active class (orange)
- **Complete**: status-defeated class (green)
- **Blocked**: status-blocked class (red)

---

## 6. Demon Portal Section

### Layout
- **Header**: H3 with demon icon (👹), red-700 color, "2 Active" badge
- **Container**: demon-portal class (red-tinted gradient background)
- **Padding**: p-6

### Visual Elements

#### Portal Animation
- **Icon**: Swirl emoji (🌀) with animate-portal class
- **Animation**: 360deg rotation over 10s, linear, infinite
- **Size**: text-6xl
- **Label**: "Portal is open!" in red-600, bold

#### Warning Message
- **Background**: Red-100/50 with red border
- **Border Radius**: rounded-lg
- **Padding**: p-4
- **Primary Text**: "⚠️ Reinforcements from the Demon King" - red-700, bold
- **Secondary Text**: "Killing these yields no XP/Gold/Gems" - red-600, small

#### Bug Cards
Each bug card contains:
- **Icon**: Demon emoji (👹), text-3xl
- **Title**: Bug description, font-bold, amber-900
- **Reporter**: "Reported by: {Source}", text-sm, amber-700
- **Severity Badge**:
  - Critical: Red background (bg-red-200), red-700 text
  - Major: Amber background (bg-amber-200), amber-700 text

---

## 7. Bottom Info Bar

### Layout
- **Position**: Below main game frame
- **Structure**: Flexbox row, space-between
- **Background**: Gradient from amber-900/60 via amber-800/40 to amber-900/60
- **Border**: amber-700/50 border, rounded-lg
- **Padding**: px-6 py-4
- **Margin**: mt-4

### Left Side - Statistics
- **Location**: "Location: {City Name}" - amber-200 label, white value (bold)
- **Separator**: amber-600 pipe character (|)
- **Active Tasks**: "Active Tasks: {count}" - green-400 value
- **Bugs**: "Bugs: {count}" - red-400 value

### Right Side - Hint
- **Text**: "Select a commander to view details" in amber-300
- **Icon**: Arrow right pixel art (24x24), 60% opacity

---

## 8. Bottom Navigation

### Layout
- **Position**: Fixed at bottom of viewport
- **Structure**: Flexbox row, space-around
- **Max Width**: 800px centered
- **Background**: Gradient from `#2c1810` to `#1a0f0a`
- **Border Top**: 3px solid `#8b6914`
- **Shadow**: 0 -4px 20px rgba(0, 0, 0, 0.5)
- **Z-Index**: 100

### Navigation Items (5 items)
Each item:
- **Layout**: Flex column, centered
- **Padding**: 8px 20px
- **Color**: #5c4018 (inactive)
- **Icon Size**: 24px
- **Label**: 11px, Cinzel font, font-weight 600

#### Navigation Links
1. **Hero** (⚔️) → `hero-v2.html`
2. **Team** (👥) → `team-v2.html`
3. **World** (🗺️) → `world-map-v2.html`
4. **Shop** (🛒) → `shop-v2.html`

---

## CSS Variables Reference

```css
:root {
    --bg-parchment: #e8dcc0;
    --bg-parchment-dark: #d4c8a8;
    --border-gold: #c9a227;
    --text-dark: #2c2416;
    --hp-design: #E67E22;
    --hp-ac: #3498DB;
    --hp-api: #9B59B6;
    --hp-fe: #1ABC9C;
    --hp-testing: #F1C40F;
    --hp-uat: #2ECC71;
}
```

---

## Animation Specifications

| Animation | Duration | Type | Description |
|-----------|----------|------|-------------|
| commander-idle | 2.5s | ease-in-out infinite | Float up/down 3px |
| portal-swirl | 10s | linear infinite | 360deg rotation |
| card-hover | 0.2s | ease | Translate Y -2px, shadow |
| back-btn hover | 0.2s | ease | Translate X -3px |

---

## Responsive Breakpoints

| Breakpoint | Changes |
|------------|---------|
| Mobile (< 768px) | Reduced font sizes, 2-column HP bars become stacked, simplified commander cards |

---

## File References

- **Prototype**: `_bmad-output/implementation-artifacts/fixed/city-v2.html`
- **Castle Asset**: `assets-v2/castle.png`
- **Coin Icon**: `assets-pixels/ui/coin.png`
- **Gem Icon**: `assets-pixels/ui/gem.png`
- **Arrow Icon**: `assets-pixels/ui/arrow_right.png`
