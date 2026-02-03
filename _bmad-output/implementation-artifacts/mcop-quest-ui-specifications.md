# MCOP Quest UI Specifications

**Project:** MCOP Quest - Gamified Project Management Platform
**Version:** v2
**Date:** 2026-02-03
**Theme:** Fantasy RPG / Medieval Adventure

---

## Table of Contents

1. [Global Design System](#global-design-system)
2. [Commander Detail Page](#commander-detail-page)
3. [Activity Log Page](#activity-log-page)
4. [Shop Page](#shop-page)
5. [Login Page](#login-page)
6. [Components Reference](#components-reference)

---

## Global Design System

### Color Palette

| Name | Hex | Usage |
|------|-----|-------|
| Background Primary | `#1a0f0a` | Page background |
| Background Card | `#3d2418` / `#2c1810` | Card backgrounds |
| Border Default | `#5c4018` | Default borders |
| Border Accent | `#8b6914` | Elevated borders |
| Accent Gold | `#d4a853` | Primary accent, highlights |
| Text Primary | `#f4e8d0` | Main text color |
| Text Secondary | `#8b6914` | Labels, meta text |

### HP Bar Colors (6 Categories)

| Category | Hex | Gradient |
|----------|-----|----------|
| Design | `#E67E22` | `#E67E22` to `#d35400` |
| AC (Acceptance Criteria) | `#3498DB` | `#3498DB` to `#2980b9` |
| API | `#9B59B6` | `#9B59B6` to `#8e44ad` |
| FE/App | `#1ABC9C` | `#1ABC9C` to `#16a085` |
| Testing | `#F1C40F` | `#F1C40F` to `#d4a853` |
| UAT | `#2ECC71` | `#2ECC71` to `#27ae60` |

### Status Colors

| Status | Color | Usage |
|--------|-------|-------|
| Done/Success | `#2ecc71` | Completed tasks |
| In Progress | `#f39c12` | Active tasks |
| Pending | `#7f8c8d` | Waiting tasks |
| Blocked | `#e74c3c` | Blocked/Error states |
| Ready | `#3498db` | Available actions |

### Typography

| Element | Font | Size | Weight |
|---------|------|------|--------|
| Headers | Cinzel | 18-24px | 400/700 |
| Body | Crimson Text | 13-16px | 400/600 |
| Labels | Crimson Text | 11-12px | 600 |
| Buttons | Cinzel | 12-14px | 600 |

### Common Components

#### Bottom Navigation
- Fixed at bottom
- 4 items: Hero, Team, World, Shop
- Active state: Gold color with top indicator bar
- Icon size: 24px
- Label size: 11px

#### Card Styling
- Background: Linear gradient `#3d2418` to `#2c1810`
- Border: 2px solid `#5c4018` or `#8b6914`
- Border radius: 12px-16px
- Box shadow: `0 10px 30px rgba(0, 0, 0, 0.5)`

---

## Commander Detail Page

### Page Purpose
Display detailed information about a specific Flow (Commander), including its battle status, associated tasks (minions), team assignments, and system information.

### Layout Structure

```
┌─────────────────────────────────────┐
│ Header                              │
│ [Back] Flow: Login          [Sync]  │
│ 🗺️ World → 🏰 Member → ⚔️ Login    │
├─────────────────────────────────────┤
│ Commander Card                      │
│ ┌──────┬───────────────────┬──────┐ │
│ │ Icon │ Name + Status     │ 63%  │ │
│ │ ⚔️   │ In Battle         │Overall│
│ └──────┴───────────────────┴──────┘ │
│                                     │
│ ⚔️ Battle Status (HP by Category)   │
│ ┌─────────────────────────────────┐ │
│ │ 📐 Design      100% ✓ [████]    │ │
│ │ 📋 AC          100% ✓ [████]    │ │
│ │ ⚙️ API         80%    [███░]    │ │
│ │ 💻 FE/App      50%    [██░░]    │ │
│ │ 🧪 Testing     0%     [░░░░]    │ │
│ │ ✅ UAT         0%     [░░░░]    │ │
│ └─────────────────────────────────┘ │
├─────────────────────────────────────┤
│ 👾 Minions (11 Tasks) ───────────   │
│ [All] [UI] [API] [FE]               │
│                                     │
│ 📐 Design / UI Tasks (2/2 Done)     │
│ ┌─────────────────────────────────┐ │
│ │ 🎨 Wireframe Login Screen       │ │
│ │    UI • [T] Ton          ✓ Done │ │
│ └─────────────────────────────────┘ │
│                                     │
│ ⚙️ API Tasks (4/5 Done)             │
│ ┌─────────────────────────────────┐ │
│ │ ⚙️ POST /api/auth/login         │ │
│ │    API • [K] Ken         ✓ Done │ │
│ │ ⚙️ JWT Token refresh            │ │
│ │    API • [K] Ken         Doing  │ │
│ └─────────────────────────────────┘ │
├─────────────────────────────────────┤
│ 👥 Team Assigned ────────────────   │
│ ┌───────┬───────┬───────┐           │
│ │ [K]   │ [T]   │ [M]   │           │
│ │ Ken   │ Ton   │ May   │           │
│ │ API   │ UI    │ FE    │           │
│ └───────┴───────┴───────┘           │
├─────────────────────────────────────┤
│ ℹ️ System Information ───────────   │
│ System: Member System               │
│ Flow ID: FLOW-001                   │
│ Created: 2026-01-15                 │
│ Last Updated: 2026-01-30 14:30      │
│ Priority: High                      │
├─────────────────────────────────────┤
│ Bottom Navigation                   │
│ [Hero] [Team] [World] [Shop]        │
└─────────────────────────────────────┘
```

### Component Specifications

#### Header
- Back button: 40x40px, border radius 10px
- Title: Cinzel 20px, color `#d4a853`
- Breadcrumb: 12px, color `#8b6914`
- Sync status: Pill with green dot, 12px

#### Commander Card
- Border: 3px solid `#8b6914`
- Border radius: 20px
- Icon: 80x80px, border 3px `#d4a853`, border radius 16px
- Name: Cinzel 24px, color `#f4e8d0`
- Status badge: Pill with icon, colored by status
  - In Battle: Orange `#f39c12`
  - Defeated: Green `#2ecc71`
  - Preparing: Gray `#7f8c8d`
- Overall progress: Cinzel 32px, color `#d4a853`

#### HP Bars (6 Categories)
- Track height: 10px
- Track background: `#1a0f0a`
- Track border: 1px `#5c4018`
- Border radius: 5px
- Fill: Category color with gradient
- Label: 14px with icon
- Value: 13px, colored by status (done/in-progress/pending)
- Meta: 11px, color `#8b6914`

#### Minion Items
- Background: `rgba(0, 0, 0, 0.2)`
- Border left: 4px colored by status
- Border radius: 10px
- Padding: 12px 15px
- Icon: 24px
- Name: 15px, strikethrough when done
- Type badge: UI/API/FE with category colors
- Assignee avatar: 20x20px circle
- Status badge: Pill with border

#### Team Members
- Avatar: 36x36px circle with class gradient
- Name: 14px, color `#f4e8d0`
- Role: 11px, color `#8b6914`

#### System Info
- Two-column layout
- Label: 13px, color `#8b6914`
- Value: 14px, color `#f4e8d0`
- Row border bottom: 1px `#5c4018`

---

## Activity Log Page

### Page Purpose
Display a chronological feed of all project activities, events, and achievements with filtering and search capabilities.

### Layout Structure

```
┌─────────────────────────────────────┐
│ Header                              │
│ 📜 Activity Log           [● Live]  │
│ Quest Chronicle & Events            │
├─────────────────────────────────────┤
│ Filter Section (Sticky)             │
│ ┌─────────────────────────────────┐ │
│ │ 🔍 Search activities...     [✕] │ │
│ └─────────────────────────────────┘ │
│ [All Time] [Today] [Week] [Month]   │
│                                     │
│ [All] [Combat] [Exploration] [Social]
│ [Achievement] [System]              │
│                                     │
│ Events: 15 | Today: 6 | XP: 1,200   │
├─────────────────────────────────────┤
│ Timeline                            │
│                                     │
│ ─────── Today ───────               │
│ ● ┌─────────────────────────────┐   │
│   │ ⚔️ Task Completed           │   │
│   │ JWT Token refresh mechanism │   │
│   │ 2 hours ago                 │   │
│   │ Ken defeated the API Minion │   │
│   │ ⭐ +100 XP  🪙 +50 Gold      │   │
│   │ [K] Ken        QA Team      │   │
│   └─────────────────────────────┘   │
│                                     │
│ ● ┌─────────────────────────────┐   │
│   │ 👹 Demon Spawned!           │   │
│   │ Critical Bug Reported       │   │
│   │ 3 hours ago                 │   │
│   │ New bug discovered...       │   │
│   │ 💎 +1 Gem (Bug Hunter)      │   │
│   │ [N] Nat (QA)   QA Team      │   │
│   └─────────────────────────────┘   │
│                                     │
│ ─────── Yesterday ───────           │
│ ● ┌─────────────────────────────┐   │
│   │ 💀 Commander Defeated!      │   │
│   │ Flow: Registration          │   │
│   │ 6 hours ago                 │   │
│   │ All minions defeated!       │   │
│   │ ⭐ +500 XP  💎 +5 Gems       │   │
│   │ [👥] Team      MCOP Guild   │   │
│   └─────────────────────────────┘   │
│                                     │
│ [📜 Load More History]              │
├─────────────────────────────────────┤
│ Bottom Navigation                   │
└─────────────────────────────────────┘
```

### Component Specifications

#### Search Box
- Background: `rgba(0, 0, 0, 0.3)`
- Border: 2px `#5c4018`, focus: `#d4a853`
- Border radius: 25px
- Padding: 8px 16px
- Icon: 16px, color `#8b6918`

#### Date Filters
- Pills: 6px 14px padding
- Border: 1px `#5c4018`
- Border radius: 20px
- Active: Gold gradient background

#### Category Tabs
- Icons with labels
- Active state with category color:
  - All: Gold `#d4a853`
  - Combat: Red `#e74c3c`
  - Exploration: Blue `#3498db`
  - Social: Purple `#9b59b6`
  - Achievement: Yellow `#f1c40f`
  - System: Gray `#95a5a6`

#### Stats Summary
- Events count
- Today's count
- Total XP gained

#### Timeline
- Left line: 2px gradient from gold to brown
- Dot: 14px circle with category color
- Card: Border left 4px with category color
- Card hover: translateX(5px), border color change

#### Activity Card
- Icon: 44x44px, rounded 12px, category colored
- Title: Cinzel 15px
- Subtitle: 13px, color `#8b6914`
- Time: 12px, color `#5c4018`
- Description: 14px, color `#a08060`
- Rewards: Pill badges (XP, Gold, Gem, Item, Buff)
- Actor: Avatar 28px, name color `#d4a853`

#### Reward Badges
| Type | Background | Border | Text |
|------|------------|--------|------|
| XP | `rgba(243, 156, 18, 0.15)` | `#f39c12` | `#f39c12` |
| Gold | `rgba(241, 196, 15, 0.15)` | `#f1c40f` | `#f1c40f` |
| Gem | `rgba(52, 152, 219, 0.15)` | `#3498db` | `#3498db` |
| Item | `rgba(46, 204, 113, 0.15)` | `#2ecc71` | `#2ecc71` |
| Buff | `rgba(155, 89, 182, 0.15)` | `#9b59b6` | `#9b59b6` |

---

## Shop Page

### Page Purpose
Allow users to purchase cosmetic items, boosts, and skins using in-game currency (Gold and Gems).

### Layout Structure

```
┌─────────────────────────────────────┐
│ Header                              │
│ 🛒 Shop                   🪙 2,450  │
│ Buy cosmetics with Gold    💎 15    │
├─────────────────────────────────────┤
│ 💡 Cosmetic Only                    │
│ Items are purely cosmetic...        │
│                                     │
│ 💎 Gem = Real Incentive             │
│ Gems earned by defeating Commanders │
│ can be exchanged for real rewards!  │
├─────────────────────────────────────┤
│ [All] [Boosts] [Skins] [Items]      │
├─────────────────────────────────────┤
│ Shop Grid (2-3 columns)             │
│ ┌─────────┐ ┌─────────┐ ┌─────────┐ │
│ │[COMMON] │ │[RARE]   │ │[EPIC]   │ │
│ │   🪖    │ │   ⛑️    │ │   🎩    │ │
│ │ Basic   │ │ Warrior │ │ Wizard  │ │
│ │ Helmet  │ │ Helm    │ │ Hat     │ │
│ │         │ │         │ │         │ │
│ │ Starter │ │ Lv. 5   │ │ Lv. 10  │ │
│ │         │ │         │ │         │ │
│ │🪙 Free  │ │🪙 500   │ │🪙 1,200 │ │
│ │[Owned]  │ │ [Buy]   │ │ [Buy]   │ │
│ └─────────┘ └─────────┘ └─────────┘ │
│                                     │
│ ┌─────────┐ ┌─────────┐             │
│ │[LEGEND] │ │[RARE]   │             │
│ │   👑    │ │   📈    │             │
│ │ Royal   │ │ XP      │             │
│ │ Crown   │ │ Boost   │             │
│ │         │ │         │             │
│ │ Lv. 20  │ │ Lv. 1   │             │
│ │         │ │         │             │
│ │🪙 5,000 │ │💎 5     │             │
│ │[Locked] │ │ [Buy]   │             │
│ └─────────┘ └─────────┘             │
├─────────────────────────────────────┤
│ 📜 Recent Purchases                 │
│ ┌─────────────────────────────────┐ │
│ │ 🪖 Basic Helmet   Free (Starter)│ │
│ │ 🗡️ Basic Sword    Free (Starter)│ │
│ │ 🛡️ Wooden Shield  Free (Starter)│ │
│ └─────────────────────────────────┘ │
├─────────────────────────────────────┤
│ Bottom Navigation                   │
└─────────────────────────────────────┘
```

### Component Specifications

#### Currency Display
- Background: `rgba(0, 0, 0, 0.3)`
- Border: 1px `#5c4018`
- Border radius: 20px
- Padding: 6px 12px
- Gold: Color `#d4a853`
- Gems: Color `#3498db`

#### Info Banners
- Border: 2px with theme color
- Border radius: 16px
- Padding: 15px
- Icon: 24px
- Title: Cinzel 14px
- Description: 13px

#### Category Tabs
- Padding: 10px 20px
- Border: 2px `#5c4018`
- Border radius: 25px
- Active: Gold gradient, dark text

#### Item Cards
- Background: Gradient `#3d2418` to `#2c1810`
- Border: 2px with rarity color
- Border radius: 16px
- Padding: 15px
- Rarity badge: Top right corner

#### Rarity Levels
| Rarity | Border | Badge Background |
|--------|--------|------------------|
| Common | `#7f8c8d` | `#7f8c8d` |
| Rare | `#3498db` | `#3498db` |
| Epic | `#9b59b6` | `#9b59b6` |
| Legendary | `#d4a853` | Gold gradient |

#### Item States
- Owned: Green border `#2ecc71`, "Owned" button
- Locked: Opacity 0.6, grayscale, lock icon with level requirement
- Available: Buy button with gold gradient

#### Buy Button
- Background: Gold gradient
- Border radius: 10px
- Padding: 10px
- Font: Cinzel 12px
- Hover: Scale 1.02, glow shadow

#### Purchase History
- Card with border
- Item rows with icon, name, price
- Empty state: "No purchases yet"

---

## Login Page

### Page Purpose
User authentication entry point with Google Sign-in, email/password login, and demo access.

### Layout Structure

```
┌─────────────────────────────────────┐
│ [← Back to Portal]                  │
│                                     │
│         ┌─────────┐                 │
│         │  Logo   │                 │
│         │  SVG    │                 │
│         └─────────┘                 │
│      MCOP QUEST                     │
│   Enter the Realm of Adventure      │
│                                     │
│  ┌─────────────────────────────┐    │
│  │ ◆ ◆ ◆  Enter the Realm      │    │
│  │      Sign in to begin...    │    │
│  │                             │    │
│  │ [Continue with Google]      │    │
│  │                             │    │
│  │ ─────── or ───────          │    │
│  │                             │    │
│  │ EMAIL ADDRESS               │    │
│  │ ┌─────────────────────┐     │    │
│  │ │ hero@mcop.quest     │     │    │
│  │ └─────────────────────┘     │    │
│  │                             │    │
│  │ PASSWORD                    │    │
│  │ ┌─────────────────────┐     │    │
│  │ │ ••••••••            │     │    │
│  │ └─────────────────────┘     │    │
│  │                             │    │
│  │ [☑] Remember me  Forgot?    │    │
│  │                             │    │
│  │ [  ENTER THE QUEST  ]       │    │
│  │                             │    │
│  │ ───── Quick Access ─────    │    │
│  │ [Ken (Warrior)] [May (Mage)]│    │
│  └─────────────────────────────┘    │
│                                     │
│    [🗺️]    [⚔️]    [🎁]             │
│   World   Battle   Rewards          │
│                                     │
│  By signing in, you agree to...     │
│  © 2026 MCOP Quest                  │
└─────────────────────────────────────┘
```

### Component Specifications

#### Corner Decorations
- 150x150px fixed corners
- 4px solid gold border
- Border radius: 0 0 100% 0 (varies by corner)
- Opacity: 0.6

#### Logo Section
- Icon: 100x100px, floating animation
- Title: Cinzel 48px, gold with text shadow
- Subtitle: 18px, italic, gold

#### Login Card
- Background: Gradient `#4a2e1f` to `#3d2418`
- Border: 3px `#8b6914`
- Border radius: 20px
- Padding: 40px
- Max width: 450px
- Decorative diamonds at top

#### Google Button
- Background: White gradient
- Border: 2px `#d4a853`
- Border radius: 8px
- Padding: 14px 20px
- Shimmer effect on hover

#### Form Inputs
- Background: `#1a0f0a`
- Border: 2px `#5c4018`, focus: `#d4a853`
- Border radius: 8px
- Padding: 14px 16px
- Label: 14px uppercase, color `#d4a853`

#### Submit Button
- Background: Gold gradient
- Border: 2px `#8b6914`
- Border radius: 8px
- Padding: 16px
- Font: Cinzel 16px uppercase
- Shadow and hover lift effect

#### Demo Buttons
- Background: Transparent
- Border: 2px `#5c4018`
- Border radius: 8px
- Padding: 10px 20px
- Avatar SVG + name

#### Feature Highlights
- Icon: 40x40px
- Text: 12px uppercase, color `#8b6914`

#### Welcome Modal
- Overlay: `rgba(0, 0, 0, 0.8)` with blur
- Content: Same card style with gold border
- Hero preview with avatar
- Starting gifts badges
- "Start Your Journey" button

---

## Components Reference

### Buttons

| Variant | Background | Border | Text |
|---------|------------|--------|------|
| Primary | Gold gradient | `#d4a853` | `#1a0f0a` |
| Secondary | Transparent | `#8b6918` | `#d4a853` |
| Danger | `rgba(231, 76, 60, 0.15)` | `#e74c3c` | `#e74c3c` |
| Disabled | `rgba(127, 140, 141, 0.15)` | `#5c4018` | `#5c4018` |

### Status Badges

| Badge | Background | Border | Text |
|-------|------------|--------|------|
| In Battle | `rgba(231, 76, 60, 0.15)` | `#e74c3c` | `#e74c3c` |
| Defeated | `rgba(46, 204, 113, 0.15)` | `#2ecc71` | `#2ecc71` |
| Blocked | `rgba(149, 165, 166, 0.15)` | `#95a5a6` | `#95a5a6` |
| Pending | `rgba(243, 156, 18, 0.15)` | `#f39c12` | `#f39c12` |
| Ready | `rgba(52, 152, 219, 0.15)` | `#3498db` | `#3498db` |

### Toast Notifications

| Type | Background | Border | Icon |
|------|------------|--------|------|
| Success | `rgba(46, 204, 113, 0.1)` | `#2ecc71` | ✅ |
| Warning | `rgba(243, 156, 18, 0.1)` | `#f39c12` | ⚠️ |
| Error | `rgba(231, 76, 60, 0.1)` | `#e74c3c` | ❌ |
| Info | `rgba(52, 152, 219, 0.1)` | `#3498db` | ℹ️ |

### Character Classes

| Class | Icon | Color | Role |
|-------|------|-------|------|
| Warrior | ⚔️ | `#e74c3c` | Backend Dev |
| Mage | 🧙 | `#9b59b6` | Frontend Dev |
| Blacksmith | 🔨 | `#e67e22` | UX/UI Designer |
| Scout | 🔍 | `#3498db` | Business Analyst |
| Healer | 💊 | `#2ecc71` | QA Engineer |
| Guild Master | 👑 | `#f1c40f` | Project Manager |

### Minion Type Icons

| Type | Icon | Background | Border |
|------|------|------------|--------|
| UI | 🎨 | `rgba(230, 126, 34, 0.15)` | `#e67e22` |
| API | ⚙️ | `rgba(155, 89, 182, 0.15)` | `#9b59b6` |
| FE | 💻 | `rgba(26, 188, 156, 0.15)` | `#1abc9c` |

### XP Bar

- Container: Gradient background, 2px border
- Track: 16px height, `#1a0f0a`
- Fill: Gold gradient, 85% default
- Glow animation: 2s infinite
- Level badge: Gold gradient pill

---

## Implementation Notes

### Responsive Breakpoints
- Mobile: < 600px (single column, stacked layouts)
- Tablet: 600px - 800px (2 columns where applicable)
- Desktop: > 800px (full layouts, max-width containers)

### Animation Guidelines
- Card hover: 0.3s ease, translateY(-2px to -3px)
- Border transitions: 0.3s ease
- Button hover: Scale 1.02, box-shadow glow
- Progress bars: 0.5s ease width transition
- Toast slide-in: 0.3s ease

### Accessibility
- Focus states: Gold border with box-shadow
- Color contrast: Text on dark backgrounds
- Interactive elements: Minimum 44px touch targets
- Status indicators: Color + icon + text

### File Locations
- Commander Detail: `/fixed/commander-v2.html`
- Activity Log: `/fixed/activity-log-v2.html`
- Shop: `/fixed/shop-v2.html`
- Login: `/fixed/login-v2.html`
- Components: `/fixed/components-v2.html`
