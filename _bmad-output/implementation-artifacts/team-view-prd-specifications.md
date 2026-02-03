# Team View Page - PRD Specifications

**Source:** `team-v2.html` prototype
**Extracted:** 2026-02-03
**Page:** Team View / Guild Overview

---

## 1. Header Section

### Layout & Structure
- **Position:** Sticky header at top of page
- **Background:** Gradient from `#2c1810` to `#1a0f0a`
- **Border:** 3px solid `#8b6914` at bottom
- **Shadow:** Box shadow `0 4px 20px rgba(0, 0, 0, 0.5)`
- **Padding:** 15px 20px
- **Max-width:** 800px centered

### Elements

#### Title Block (Left)
| Element | Value | Styling |
|---------|-------|---------|
| Main Title | "Team View" | Font: Cinzel, 20px, Color: `#d4a853` |
| Subtitle | Current team name | Font: Crimson Text, 12px, Color: `#8b6914` |

#### Team Selector Dropdown (Right)
| Element | Specification |
|---------|---------------|
| Button Style | Flex container with icon + text + chevron |
| Background | Gradient `145deg, #3d2418` to `#2c1810` |
| Border | 2px solid `#8b6914`, border-radius: 12px |
| Padding | 10px 16px |
| Font | Cinzel, 14px, Color: `#f4e8d0` |
| Hover State | Border color changes to `#d4a853`, glow effect |

**Dropdown Menu:**
- Position: Absolute, right-aligned, below button
- Background: Same gradient as button
- Border: 2px solid `#8b6914`, border-radius: 12px
- Min-width: 200px
- Shadow: `0 10px 30px rgba(0, 0, 0, 0.5)`

**Team Option Items:**
- Layout: Flex with icon (20px) + name + checkmark for active
- Padding: 12px 16px
- Separator: 1px border-bottom `#5c4018`
- Hover: Background `rgba(212, 168, 83, 0.1)`
- Active: Background `rgba(212, 168, 83, 0.2)`, text color `#d4a853`

**Team Data Structure:**
```javascript
{
  id: string,      // 'mcop', 'phoenix', 'dragon'
  name: string,    // 'MCOP Guild', 'Phoenix Squad', 'Dragon Team'
  icon: string     // '🏰', '🔥', '🐉'
}
```

---

## 2. Guild Members Section

### Layout & Structure
- **Container:** Section card with gradient background
- **Background:** Gradient `145deg, #3d2418` to `#2c1810`
- **Border:** 2px solid `#8b6914`, border-radius: 16px
- **Padding:** 20px
- **Shadow:** Inset shadow `0 0 30px rgba(0, 0, 0, 0.3)`

### Section Title
- **Icon:** 👥
- **Text:** "Guild Members"
- **Counter:** Member count displayed as "X Heroes" (right-aligned)
- **Font:** Cinzel, 18px, Color: `#d4a853`
- **Divider:** Gradient line extending from title

### Members Grid
- **Layout:** 3-column CSS Grid
- **Gap:** 15px (10px on mobile)
- **Instruction Text:** "Tap avatar to view equipment & skills" (centered, 12px, `#5c4018`)

### Member Card

#### Visual Structure
| Element | Specification |
|---------|---------------|
| Layout | Centered text, cursor: pointer |
| Avatar Container | 70px x 70px (60px mobile), circular |
| Avatar Border | 3px solid (dynamic color from member data) |
| Avatar Background | 20% opacity of member color |
| Avatar Font Size | 32px (28px mobile) |
| Hover Effect | Transform translateY(-3px), avatar glow |

#### Task Badge
- **Position:** Absolute, top: -5px, right: -5px
- **Size:** 22px x 22px circular
- **Background:** `#c0392b`
- **Text:** White, 11px, bold
- **Border:** 2px solid `#2c1810`
- **Display:** Only when doing + pending > 0

#### Member Info
| Element | Styling |
|---------|---------|
| Name | Cinzel, 13px, `#f4e8d0` |
| Level/Role | 11px, dynamic color from member data |
| Format | "Lv.X RoleName" |

#### Task Pills
- **Layout:** Flex row, centered, 4px gap
- **Doing Pill:**
  - Background: `rgba(243, 156, 18, 0.2)`
  - Border: 1px solid `#f39c12`
  - Text: `#f39c12`, 10px, format "X⚔️"
- **Pending Pill:**
  - Background: `rgba(127, 140, 141, 0.2)`
  - Border: 1px solid `#7f8c8d`
  - Text: `#7f8c8d`, 10px, format "X📋"

#### Member Data Structure
```javascript
{
  id: string,
  name: string,
  icon: string,           // Emoji avatar
  role: string,           // 'Warrior', 'Mage', 'Healer', etc.
  color: string,          // Hex color code
  level: number,
  class: string,          // Display class with emoji
  tasks: {
    doing: number,
    pending: number,
    done: number
  },
  activeTasks: Array<{ name: string, type: string }>
}
```

---

## 3. Guild Progress Section

### Layout & Structure
- Same section card styling as Guild Members
- Title: "📊 Guild Progress This Sprint"

### Stats Grid
- **Layout:** 3-column grid (1-column on mobile)
- **Gap:** 15px (10px mobile)

#### Stat Box
| Element | Specification |
|---------|---------------|
| Background | `rgba(0, 0, 0, 0.2)` |
| Border | 1px solid `#5c4018`, border-radius: 12px |
| Padding | 15px |
| Text Align | Center |

#### Stat Values
| Stat | Color Class | Display |
|------|-------------|---------|
| Overall Progress | `.success` (`#2ecc71`) | Percentage with % |
| Tasks Done | `.warning` (`#f39c12`) | Number |
| Commanders | `.info` (`#9b59b6`) | Number |

**Stat Label:** 11px, `#8b6914`, uppercase, letter-spacing: 0.1em

### Sprint Progress Bar

#### Header
- **Layout:** Flex, space-between
- **Label:** "Sprint Progress" (13px, `#8b6914`)
- **Value:** "Day X/Y" (13px, `#f39c12`, font-weight: 600)

#### Progress Bar
- **Container Height:** 12px
- **Background:** `#1a0f0a`
- **Border:** 2px solid `#5c4018`, border-radius: 6px
- **Overflow:** hidden

#### Progress Fill
- **Background:** Gradient `90deg, #f39c12` to `#2ecc71`
- **Border-radius:** 4px
- **Transition:** width 0.5s ease

#### Team Progress Data Structure
```javascript
{
  progress: number,      // Percentage (0-100)
  tasksDone: number,
  commanders: number
}
```

---

## 4. Battle Status Section

### Layout & Structure
- **Container:** Special battle card styling
- **Background:** Same gradient as section cards
- **Border:** 2px solid `#c0392b` (red accent)
- **Border-radius:** 16px
- **Padding:** 20px

### Battle Header
- **Layout:** Flex row with gap: 10px
- **Icon:** ⚔️
- **Title:** "Battle Status" (Cinzel, 16px, `#e74c3c`)
- **Counter Badge:**
  - Background: `rgba(192, 57, 43, 0.2)`
  - Border: 1px solid `#c0392b`
  - Border-radius: 20px
  - Padding: 4px 12px
  - Text: "X Active Battles"
  - Position: margin-left: auto

### Battle Member Card
- **Background:** `rgba(0, 0, 0, 0.3)`
- **Border:** 1px solid `#5c4018`, border-radius: 12px
- **Padding:** 15px
- **Margin-bottom:** 12px
- **Display:** Only for members with tasks.doing > 0

#### Battle Member Header
- **Layout:** Flex row, align-items: center, gap: 12px

| Element | Specification |
|---------|---------------|
| Avatar | 40px circular, colored border/background |
| Name | Cinzel, 14px, `#f4e8d0` |
| Meta | 11px, `#8b6914`, "Fighting X monster(s)" |
| Status Badge | "⚔️ In Battle" - amber styling |

#### Battle Arena
- **Background:** Gradient `180deg, #1a0f0a` to `#0d0705`
- **Border:** 1px solid `#5c4018`, border-radius: 10px
- **Padding:** 15px
- **Min-height:** 80px
- **Layout:** Flex, space-between, center aligned
- **VS Text:** 18px, `#8b6914`

**Hero Side:**
- Large avatar (36px) with float animation
- Animation: `float 2s ease-in-out infinite`

**Monster Side:**
- Flex row, gap: 8px
- Max 3 monsters displayed
- "+X" indicator for additional monsters

**Monster Display:**
| Element | Specification |
|---------|---------------|
| Icon | 28px emoji per task type |
| Type Label | 9px, `#9b59b6` |
| Animation | Shake animation with staggered delays |

**Monster Type Mapping:**
```javascript
{
  'API': '👾',
  'FE': '👹',
  'UI': '🦇',
  'AC': '👻',
  'Testing': '🕷️',
  'UAT': '🍄'
}
```

#### Task List Mini
- **Border-top:** 1px solid `#5c4018`
- **Margin-top:** 10px
- **Padding-top:** 10px

**Task Mini Item:**
- Layout: Flex row, gap: 8px
- Padding: 4px 0
- Font-size: 12px

**Task Type Icons:**
| Type | Background | Text Color | Display |
|------|------------|------------|---------|
| API | `rgba(155, 89, 182, 0.3)` | `#9b59b6` | First letter |
| FE | `rgba(26, 188, 156, 0.3)` | `#1abc9c` | First letter |
| UI | `rgba(230, 126, 34, 0.3)` | `#e67e22` | First letter |
| AC | `rgba(52, 152, 219, 0.3)` | `#3498db` | First letter |
| Testing | `rgba(241, 196, 15, 0.3)` | `#f1c40f` | First letter |

### Resting Members Section
- **Border-top:** 1px solid `#5c4018`
- **Margin-top:** 10px
- **Padding:** 15px
- **Text-align:** Center

**Resting Label:** 11px, `#5c4018`, "Members at rest:"

**Resting List:**
- Layout: Flex, centered, wrap, gap: 8px

**Resting Member Badge:**
- Background: `rgba(0, 0, 0, 0.3)`
- Border-radius: 20px
- Padding: 4px 10px
- Font-size: 11px
- Contains: Icon + Name + Green checkmark

---

## 5. Team Equipment Overview Section

### Layout & Structure
- Same section card styling
- Title: "🛡️ Team Equipment Overview"

### Skills Grid
- **Layout:** 3-column grid (2-column on mobile)
- **Gap:** 12px

### Skill Card (Class Count)
| Element | Specification |
|---------|---------------|
| Background | `rgba(0, 0, 0, 0.3)` |
| Border | 2px solid `#5c4018`, border-radius: 12px |
| Padding | 15px 10px |
| Text-align | Center |
| Hover | Border color `#d4a853`, translateY(-2px) |

**Card Content:**
| Element | Styling |
|---------|---------|
| Icon | 28px emoji |
| Class Name | 11px, `#8b6914`, uppercase, letter-spacing: 0.05em |
| Count | Cinzel, 14px, `#d4a853` |

**Class Types:**
| Class | Icon |
|-------|------|
| Warriors | ⚔️ |
| Mages | 🧙 |
| Healers | 💊 |
| Scouts | 🔍 |
| Smiths | 🔨 |
| Leaders | 👑 |

---

## 6. Member Detail Modal

### Layout & Structure
- **Overlay:** Fixed, inset: 0, background `rgba(0, 0, 0, 0.8)`
- **Z-index:** 300
- **Content Container:**
  - Max-width: 400px
  - Max-height: 80vh
  - Overflow-y: auto
  - Background: Same gradient as cards
  - Border: 3px solid `#d4a853`
  - Border-radius: 20px

### Modal Header
- **Layout:** Flex, space-between, align-items: center
- **Padding:** 20px
- **Border-bottom:** 1px solid `#5c4018`
- **Title:** Cinzel, 18px, `#d4a853` (member name)
- **Close Button:** X symbol, 24px, `#8b6914` (hover: `#d4a853`)

### Modal Body
- **Padding:** 20px

#### Avatar Section
- **Size:** 100px circular
- **Border:** 4px solid `#d4a853`
- **Background:** 20% opacity of member color
- **Font-size:** 50px
- **Margin:** 0 auto 20px

#### Member Info
- **Class:** Cinzel, 16px, `#f4e8d0`
- **Level:** 12px, `#8b6914`, "Level X"
- **Text-align:** Center

#### Task Stats Grid
- **Layout:** 3-column grid, gap: 10px
- **Margin-bottom:** 20px

**Stat Box:**
- Background: `rgba(0, 0, 0, 0.3)`
- Border: 1px solid `#5c4018`, border-radius: 10px
- Padding: 12px
- Text-align: center

**Stat Values:**
| Stat | Color |
|------|-------|
| Doing | `#f39c12` |
| Pending | `#3498db` |
| Done | `#2ecc71` |

#### XP Bar
- **Label:** "Experience" (12px, `#8b6914`)
- **Value:** "X / Y XP" (12px, `#d4a853`)
- **Uses same progress bar component as sprint progress**

#### Equipment Section
- **Title:** "Equipment" (Cinzel, 14px, `#d4a853`)
- **Margin:** 20px 0 12px

**Equipment Grid:**
- Layout: 3-column grid, gap: 10px

**Equipment Slot:**
- Aspect-ratio: 1
- Background: `rgba(0, 0, 0, 0.3)`
- Border: 2px solid `#5c4018`, border-radius: 10px
- Padding: 8px
- Flex column, centered

**Slot Content:**
| Element | Styling |
|---------|---------|
| Icon | 24px |
| Slot Label | 9px, `#5c4018`, uppercase |
| Item Name | 10px, `#2ecc71`, centered |

**Equipment Slots:**
- head
- body
- weapon
- offhand
- legs
- feet

#### Combat Stats Section
- **Title:** "Combat Stats" (Cinzel, 14px, `#d4a853`)
- **Margin:** 20px 0 12px

**Stats Grid:** 2-column

| Stat | Color |
|------|-------|
| Kills | `#e74c3c` |
| Gold | `#d4a853` |

#### Full Member Data Structure
```javascript
{
  id: string,
  name: string,
  icon: string,
  role: string,
  color: string,
  level: number,
  xp: number,
  xpMax: number,
  kills: number,
  gold: number,
  class: string,
  tasks: { doing: number, pending: number, done: number },
  activeTasks: Array<{ name: string, type: string }>,
  equipment: {
    head: { icon: string, name: string },
    body: { icon: string, name: string },
    weapon: { icon: string, name: string },
    offhand: { icon: string, name: string },
    legs: { icon: string, name: string },
    feet: { icon: string, name: string }
  }
}
```

---

## 7. Bottom Navigation

### Layout & Structure
- **Position:** Fixed bottom
- **Background:** Gradient `180deg, #2c1810` to `#1a0f0a`
- **Border-top:** 3px solid `#8b6914`
- **Shadow:** `0 -4px 20px rgba(0, 0, 0, 0.5)`
- **Z-index:** 100

### Navigation Items
- **Layout:** Flex, space-around
- **Max-width:** 800px centered
- **Padding:** 10px 0

### Nav Item
| State | Styling |
|-------|---------|
| Default | Color: `#5c4018` |
| Active/Hover | Color: `#d4a853` |
| Active Indicator | 40px x 3px line above, `#d4a853` with glow |

**Nav Item Content:**
| Element | Specification |
|---------|---------------|
| Icon | 24px (20px mobile) |
| Label | 11px, font-weight: 600 |
| Padding | 8px 20px (15px mobile) |

### Navigation Links
| Route | Icon | Label | Active On |
|-------|------|-------|-----------|
| hero-v2.html | ⚔️ | Hero | Team/Hero page |
| team-v2.html | 👥 | Team | Team page |
| world-map-v2.html | 🗺️ | World | World page |
| shop-v2.html | 🛒 | Shop | Shop page |

---

## 8. Responsive Breakpoints

### Mobile (< 600px)

| Element | Change |
|---------|--------|
| Members Grid | 3 columns, 10px gap |
| Member Avatar | 60px, 28px font |
| Stats Grid | 1 column, 10px gap |
| Skills Grid | 2 columns |
| Monster Side | Wrap, max-width: 120px, right-aligned |
| Nav Items | 15px horizontal padding |
| Nav Icons | 20px |

---

## 9. Color Palette

### Primary Colors
| Name | Hex | Usage |
|------|-----|-------|
| Gold Primary | `#d4a853` | Titles, accents, active states |
| Gold Dark | `#8b6914` | Borders, secondary text |
| Gold Muted | `#5c4018` | Subtle borders, tertiary text |

### Background Colors
| Name | Hex | Usage |
|------|-----|-------|
| Dark Primary | `#1a0f0a` | Page background |
| Dark Secondary | `#2c1810` | Card backgrounds |
| Dark Tertiary | `#3d2418` | Card gradients, elevated surfaces |

### Semantic Colors
| Name | Hex | Usage |
|------|-----|-------|
| Success | `#2ecc71` | Progress, completed tasks |
| Warning | `#f39c12` | Doing tasks, amber accents |
| Info | `#9b59b6` | Commanders, API tasks |
| Danger | `#c0392b` | Battle card borders, kills |
| Text Primary | `#f4e8d0` | Body text |

### Member Class Colors
| Class | Color |
|-------|-------|
| Warrior | `#9B59B6` (Purple) |
| Mage | `#1ABC9C` (Teal) |
| Smith | `#E67E22` (Orange) |
| Scout | `#3498DB` (Blue) |
| Healer | `#F1C40F` (Yellow) |
| Leader | `#f1c40f` (Gold) |

---

## 10. Typography

### Font Families
| Family | Usage |
|--------|-------|
| Cinzel | Headers, titles, stats, fantasy-themed text |
| Crimson Text | Body text, descriptions |

### Type Scale
| Element | Size | Weight | Family |
|---------|------|--------|--------|
| Page Title | 20px | 400/700 | Cinzel |
| Section Title | 18px | 400 | Cinzel |
| Card Title | 16px | 400 | Cinzel |
| Stat Value | 28px | 700 | Cinzel |
| Modal Title | 18px | 400 | Cinzel |
| Body Text | 12-14px | 400 | Crimson Text |
| Labels | 9-11px | 600 | Crimson Text |

---

## 11. Animations & Transitions

### Hover Effects
| Element | Effect | Duration |
|---------|--------|----------|
| Member Card | translateY(-3px) | 0.2s |
| Member Avatar | Box-shadow glow | 0.3s |
| Skill Card | translateY(-2px), border color | 0.3s |
| Nav Item | Color transition | 0.3s |

### Continuous Animations
| Element | Animation | Duration |
|---------|-----------|----------|
| Hero Mini | Float (up/down) | 2s infinite |
| Monster Icons | Shake | 2s infinite, staggered |

### Modal Animations
| State | Effect | Duration |
|-------|--------|----------|
| Open | Opacity 0→1, scale 0.9→1 | 0.3s |
| Close | Opacity 1→0, scale 1→0.9 | 0.3s |

### Progress Bar
| Action | Effect | Duration |
|--------|--------|----------|
| Load | Width transition | 0.5s ease |

---

## 12. Interactions & Behaviors

### Team Selector
- Click dropdown button to toggle menu
- Click outside to close
- Click team option to switch team
- Active team shows checkmark

### Member Cards
- Click to open member modal
- Hover shows lift effect and glow

### Modal
- Click overlay or X to close
- Escape key support (recommended)
- Scrollable if content exceeds viewport

### Navigation
- Click to navigate to page
- Active page shows indicator line

---

## 13. Data Requirements

### Team Data
```javascript
Team: {
  id: string,
  name: string,
  icon: string,
  progress: number,      // 0-100
  tasksDone: number,
  commanders: number,
  members: Member[]
}
```

### Member Data
```javascript
Member: {
  id: string,
  name: string,
  icon: string,          // Emoji
  role: string,          // Class role
  color: string,         // Hex color
  level: number,
  xp: number,
  xpMax: number,
  kills: number,
  gold: number,
  class: string,         // Display string
  tasks: {
    doing: number,
    pending: number,
    done: number
  },
  activeTasks: Task[],
  equipment: Equipment
}
```

### Task Data
```javascript
Task: {
  name: string,
  type: 'API' | 'FE' | 'UI' | 'AC' | 'Testing' | 'UAT'
}
```

### Equipment Data
```javascript
Equipment: {
  head: { icon: string, name: string },
  body: { icon: string, name: string },
  weapon: { icon: string, name: string },
  offhand: { icon: string, name: string },
  legs: { icon: string, name: string },
  feet: { icon: string, name: string }
}
```

---

## 14. Implementation Notes

### Framework Considerations
- Built with Alpine.js in prototype
- Modal state managed via `x-data`
- Team switching is reactive
- Member selection for modal

### Performance
- Use CSS transforms for animations (GPU accelerated)
- Lazy load member modal content
- Consider virtual scrolling for large teams

### Accessibility
- Add aria-labels to interactive elements
- Ensure keyboard navigation for modal
- Color contrast meets WCAG standards
- Focus trap in modal when open

### Mobile Considerations
- Touch-friendly tap targets (min 44px)
- Bottom nav accounts for safe areas
- Horizontal scroll prevention on body
