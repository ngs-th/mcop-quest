# MCOP Quest - Page Specifications

**สรุปรายละเอียดหน้า UI ทั้งหมดจาก Prototype v2 สำหรับเพิ่มเข้า PRD**

**Version:** 2.0
**Date:** 2026-02-03
**Total Pages:** 9 pages
**Theme:** Fantasy RPG / Medieval Adventure

---

## Table of Contents

1. [Global Design System](#global-design-system)
2. [Hero Dashboard Page](#1-hero-dashboard-page)
3. [Team Camp Page](#2-team-camp-page)
4. [World Map Page](#3-world-map-page)
5. [City Detail Page](#4-city-detail-page)
6. [Commander Detail Page](#5-commander-detail-page)
7. [Activity Log Page](#6-activity-log-page)
8. [Shop Page](#7-shop-page)
9. [Login Page](#8-login-page)
10. [Components Reference](#9-components-reference-page)

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

### 6 HP Bar System (Development Stages)

| Stage | Color | Hex | Icon | Description |
|-------|-------|-----|------|-------------|
| Design | Orange | `#E67E22` | 📐 | UI/UX Design phase |
| AC | Blue | `#3498DB` | 📋 | Acceptance Criteria |
| API | Purple | `#9B59B6` | ⚙️ | Backend/API development |
| FE/App | Teal | `#1ABC9C` | 💻 | Frontend/App development |
| Testing | Yellow | `#F1C40F` | 🧪 | QA/Testing phase |
| UAT | Green | `#2ECC71` | ✅ | User Acceptance Testing |

### Typography

| Element | Font | Size | Weight |
|---------|------|------|--------|
| Headers | Cinzel | 18-48px | 400/700 |
| Body | Crimson Text | 13-16px | 400/600 |
| Labels | Crimson Text | 11-12px | 600 |
| Buttons | Cinzel | 12-14px | 600 |

### Bottom Navigation (All Pages)

- **Position**: Fixed at bottom
- **Items**: 4 items - Hero (⚔️), Team (👥), World (🗺️), Shop (🛒)
- **Active State**: Gold color (`#d4a853`) with top indicator bar
- **Background**: Gradient from `#2c1810` to `#1a0f0a`
- **Border Top**: 3px solid `#8b6914`

---

## 1. Hero Dashboard Page

### Page Purpose
หน้าแดชบอร์ดหลักของผู้เล่น แสดงข้อมูลสถานะตัวละคร สถิติ อุปกรณ์ และกิจกรรมล่าสุด

### Layout Structure

```
┌─────────────────────────────────────┐
│ Header                              │
│ [⚔️ Hero]              🪙 2,450 💎15│
├─────────────────────────────────────┤
│ Character Card + Equipment Grid     │
│ ┌──────────┬──────────────────────┐ │
│ │          │ [H][C][W][B][L][B]   │ │
│ │  Avatar  │ Head Chest Weapon    │ │
│ │  Lv.12   │ Boot Leg Boot        │ │
│ │ Warrior  │                      │ │
│ │ XP Bar   │ Durability indicators│ │
│ └──────────┴──────────────────────┘ │
├─────────────────────────────────────┤
│ Stats Grid (3 columns)              │
│ ┌─────────┬─────────┬─────────┐     │
│ │Victories│  Gold   │  Gems   │     │
│ │   24    │  2,450  │   15    │     │
│ └─────────┴─────────┴─────────┘     │
├─────────────────────────────────────┤
│ Battle Scene                        │
│ [Hero]~~~~⚔️~~~~[Monster Lv.3]      │
│ "Defeat 5 more tasks to level up!"  │
├─────────────────────────────────────┤
│ Damage Contribution Chart           │
│ ▓▓▓▓▓░░░░ Design 45%                │
│ ▓▓▓░░░░░░░ API 25%                  │
│ ▓▓▓░░░░░░░ FE 20%                   │
│ ▓░░░░░░░░░ Testing 10%              │
├─────────────────────────────────────┤
│ Active Tasks (3 tasks)              │
│ ⚔️ API Integration - 80%            │
│ 🧪 Write test cases - 60%           │
│ 📋 Review requirements - 30%        │
├─────────────────────────────────────┤
│ Recent Activity                     │
│ • Completed "Login Flow" +100 XP    │
│ • Earned "Bug Hunter" badge         │
│ • Purchased Basic Helmet            │
├─────────────────────────────────────┤
│ Bottom Navigation                   │
│ [Hero] [Team] [World] [Shop]        │
└─────────────────────────────────────┘
```

### Component Specifications

#### Character Card
- **Avatar**: 120x120px, rounded-full, border-4 gold
- **Level Badge**: "Lv. 12" - amber background, Cinzel font
- **Class**: "Warrior" - amber-400, text-sm
- **XP Bar**:
  - Container: 200px width, 16px height
  - Track: `#1a0f0a` background
  - Fill: Gold gradient (85% width)
  - Glow animation: 2s infinite

#### Equipment Grid (6 Slots)
| Slot | Position | Icon |
|------|----------|------|
| Head | Top-left | 🪖 |
| Chest | Top-center | 👕 |
| Weapon | Top-right | ⚔️ |
| Boots | Bottom-left | 👢 |
| Legs | Bottom-center | 🦵 |
| Boots | Bottom-right | 👢 |

- **Slot Size**: 48x48px
- **Border**: 2px `#5c4018`, rounded-lg
- **Equipped**: Gold border with glow
- **Empty**: Dashed border, 30% opacity

#### Stats Grid
- **Container**: 3 columns, gap-4
- **Card**: Gradient background, 2px border, rounded-xl
- **Icon**: 24x24px pixel art
- **Label**: 12px uppercase, Cinzel
- **Value**: 24px bold, color-coded

#### Battle Scene
- **Background**: Linear gradient dark with overlay
- **Hero Side**: Character avatar with idle animation
- **Monster Side**: Monster pixel art (Lv. 1-5)
- **VS Badge**: "VS" in diamond shape, gold border
- **Motivational Text**: 14px italic, amber-300

#### Damage Contribution Chart
- **Type**: Horizontal stacked bar chart
- **Categories**: Design, API, FE, Testing
- **Colors**: Match HP bar system
- **Labels**: Percentage + category name

#### Active Tasks List
- **Max Items**: 3-5 tasks
- **Item Layout**: Icon + Title + Progress bar
- **Progress Bar**: Category-colored, 8px height
- **Status**: Percentage indicator

#### Recent Activity
- **Max Items**: 4-5 activities
- **Format**: Icon + Description + Time
- **Types**: Task complete, Badge earned, Purchase, Level up

---

## 2. Team Camp Page

### Page Purpose
หน้าแสดงข้อมูลทีมทั้งหมด สมาชิกในทีม สถานะการต่อสู้ และอุปกรณ์ของทีม

### Layout Structure

```
┌─────────────────────────────────────┐
│ Header                              │
│ [👥 Team Camp]         🪙 2,450 💎15│
├─────────────────────────────────────┤
│ Team Selector                       │
│ ┌─────────────────────────────────┐ │
│ │ ▼ MCOP Guild          [members] │ │
│ └─────────────────────────────────┘ │
├─────────────────────────────────────┤
│ Guild Stats                         │
│ ┌─────────┬─────────┬─────────┐     │
│ │ Members │ Active  │  Guild  │     │
│ │    5    │ Battles │  Level  │     │
│ │         │    3    │    8    │     │
│ └─────────┴─────────┴─────────┘     │
├─────────────────────────────────────┤
│ Sprint Progress                     │
│ Sprint 12: User Management ───── 75%│
│ ████████████████████░░░░ Jan 15-30  │
├─────────────────────────────────────┤
│ Battle Status                       │
│ ┌─────────────────────────────────┐ │
│ │ ⚔️ 3 Active Battles             │ │
│ │ ● Login Flow (Ken) 75%          │ │
│ │ ● Member API (Ton) 40%          │ │
│ │ ● Dashboard UI (May) 90%        │ │
│ └─────────────────────────────────┘ │
├─────────────────────────────────────┤
│ Team Members Grid                   │
│ ┌────────┐ ┌────────┐ ┌────────┐   │
│ │ [K]    │ │ [T]    │ │ [M]    │   │
│ │  Ken   │ │  Ton   │ │  May   │   │
│ │Warrior │ │  Mage  │ │Scout   │   │
│ │ Lv.12  │ │ Lv.10  │ │ Lv.8   │   │
│ └────────┘ └────────┘ └────────┘   │
├─────────────────────────────────────┤
│ Team Equipment Overview             │
│ Warriors: 2  Mages: 1  Healers: 1   │
│ [Equipment distribution chart]      │
├─────────────────────────────────────┤
│ Bottom Navigation                   │
│ [Hero] [Team] [World] [Shop]        │
└─────────────────────────────────────┘
```

### Component Specifications

#### Team Selector Dropdown
- **Style**: Full-width, gradient background
- **Border**: 2px gold, rounded-xl
- **Icon**: Building/team icon
- **Team Name**: Cinzel font, bold
- **Member Count**: Badge with user icon

#### Guild Stats (3 Boxes)
| Stat | Icon | Description |
|------|------|-------------|
| Members | 👥 | Total team members |
| Active Battles | ⚔️ | Current active flows |
| Guild Level | 🏰 | Team level/stature |

#### Sprint Progress Bar
- **Container**: Full-width card
- **Sprint Name**: Cinzel 16px
- **Progress Bar**: 16px height, gold gradient fill
- **Percentage**: Text right-aligned
- **Date Range**: Text-sm below bar

#### Battle Status Section
- **Header**: "⚔️ X Active Battles" with count badge
- **Battle Items**:
  - Status dot (color by progress)
  - Flow name
  - Assignee avatar
  - Progress percentage

#### Team Member Cards
- **Size**: ~120px width
- **Avatar**: 60x60px with class-colored border
- **Name**: 14px bold
- **Class**: 12px with class icon
- **Level**: Badge format
- **Hover Effect**: Scale 1.02, shadow increase

#### Team Equipment Overview
- **Class Distribution**: Count per class
- **Chart Type**: Horizontal bar or pie chart
- **Classes**: Warrior, Mage, Blacksmith, Scout, Healer, Guild Master

---

## 3. World Map Page

### Page Purpose
แผนที่โลกแบบโต้ตอบ แสดงเมือง/โปรเจกต์ทั้งหมด สถานะการยึดครอง และการควบคุมกล้อง

### Layout Structure

```
┌─────────────────────────────────────┐
│ Header                              │
│ [🗺️ World Map]                    ℹ️│
├─────────────────────────────────────┤
│                                     │
│     ┌───────────────────┐           │
│     │                   │           │
│     │   CANVAS 2D MAP   │ ◄── Drag  │
│     │   40x30 Tiles     │     to    │
│     │                   │     Pan   │
│     │  [🏰]─[🏯]─[🏰]   │           │
│     │   │    │    │     │           │
│     │  [🏛️]─[🏰]─[🏰]   │           │
│     │                   │           │
│     └───────────────────┘           │
│                                     │
│ [+] [-]        🧭 MINIMAP    [?]    │
│ Zoom           ┌───┐          Help  │
│ Controls       │ ▓ │               │
│                └───┘               │
├─────────────────────────────────────┤
│ Legend                              │
│ 🏰 Castle   🏯 Tower   🏛️ Bastion  │
│ 🧪 Lab      🏪 Market  🏢 Fortress │
├─────────────────────────────────────┤
│ Bottom Navigation                   │
│ [Hero] [Team] [World] [Shop]        │
└─────────────────────────────────────┘
```

### Canvas 2D Map Specifications

#### Technical Details
- **Technology**: HTML5 Canvas 2D API
- **Grid Size**: 40 tiles wide × 30 tiles high
- **Tile Size**: 128×128 pixels
- **Map Dimensions**: 5120×3840 pixels
- **Animation**: requestAnimationFrame (60fps)

#### Tile System
| Tile Type | Asset | Description |
|-----------|-------|-------------|
| Grass Base | grass_base.png | Default ground |
| Grass Var 1 | grass_01.png | Decoration 1 |
| Grass Var 2 | grass_02.png | Decoration 2 |
| Dirt | dirt_base.png | Paths/roads |
| Stone | stone_01.png | Rocky areas |
| Water | water_base.png | Lakes/rivers |

#### Location Markers (8 Cities)
| ID | Name | Type | Icon | Position |
|----|------|------|------|----------|
| member_city | Member City | Castle | 🏰 | Center-left |
| task_tower | Task Tower | Tower | 🏯 | Top-right |
| bug_bastion | Bug Bastion | Bastion | 🏛️ | Bottom-left |
| analytics_lab | Analytics Lab | Lab | 🧪 | Right |
| community_commons | Community Commons | Market | 🏪 | Bottom-right |
| payment_fortress | Payment Fortress | Fortress | 🏢 | Top-center |
| product_city | Product City | Castle | 🏰 | Center |
| notification_tower | Notification Tower | Bell Tower | 🔔 | Top-left |

#### Camera Controls
| Control | Action | Input |
|---------|--------|-------|
| Pan | Move view | Mouse drag / Touch swipe |
| Zoom In | Scale up | Scroll up / Pinch in |
| Zoom Out | Scale down | Scroll down / Pinch out |
| Reset | Center map | Double-click |

#### Mini-map
- **Position**: Bottom-right corner
- **Size**: 150x150px
- **Features**:
  - Overview of entire map
  - Viewport rectangle indicator
  - Location dots
  - Click to jump to location

#### Location Modal (on click)
```
┌─────────────────────────────┐
│ 🏰 Member City              │
│ System: User Management     │
├─────────────────────────────┤
│ Progress: 75% ████████░░░   │
│ Commanders: 3 (2 defeated)  │
│ Status: In Battle ⚔️        │
├─────────────────────────────┤
│ [View City Details]         │
└─────────────────────────────┘
```

---

## 4. City Detail Page

### Page Purpose
หน้าแสดงรายละเอียดของเมือง (โปรเจกต์/ระบบ) รวมถึงสถานะบอส คอมมานเดอร์ (โฟลว์) และเบิร์ก (บั๊ก)

### Layout Structure

```
┌─────────────────────────────────────┐
│ Header                              │
│ [← Back] 🏰 Member City   🪙 💎     │
├─────────────────────────────────────┤
│ City Boss Card                      │
│ ┌──────┬──────────────────────────┐ │
│ │      │ 👑 King of Members       │ │
│ │🏰    │ City Boss • System Module│ │
│ │Img   │ Overall: 75% ████████░░░ │ │
│ │      │ 2/3 Commanders Defeated  │ │
│ └──────┴──────────────────────────┘ │
├─────────────────────────────────────┤
│ Stats Grid (4 columns)              │
│ ┌─────┬─────┬─────┬─────┐           │
│ │Flows│Tasks│Bugs │Prog │           │
│ │  3  │ 12  │  2  │ 75% │           │
│ └─────┴─────┴─────┴─────┘           │
├─────────────────────────────────────┤
│ ⚔️ Commanders (3)                   │
│ ┌─────────────────────────────────┐ │
│ │ [👤] Flow: Login          63%   │ │
│ │      📐░░░ 📋░░░ ⚙️███ 💻░░░    │ │
│ │      In Battle | Assignees: K,T │ │
│ ├─────────────────────────────────┤ │
│ │ [💀] Flow: Registration  100%   │ │
│ │      ✓ Defeated                 │ │
│ ├─────────────────────────────────┤ │
│ │ [🔒] Flow: Profile        0%    │ │
│ │      🔒 Blocked: Needs API      │ │
│ └─────────────────────────────────┘ │
├─────────────────────────────────────┤
│ 📋 Active Tasks                     │
│ ┌─────────────────────────────────┐ │
│ │Task      │Flow   │Stage │Status │ │
│ ├─────────────────────────────────┤ │
│ │Login API │Login  │API   │Doing  │ │
│ │UI Design │Login  │Design│Done   │ │
│ └─────────────────────────────────┘ │
├─────────────────────────────────────┤
│ 👹 Demon Portal (2 Active)          │
│ ┌─────────────────────────────────┐ │
│ │ 🌀 Portal is open!              │ │
│ │                                 │ │
│ │ 👹 Null pointer - Critical      │ │
│ │ 👹 CSS issue - Major            │ │
│ └─────────────────────────────────┘ │
├─────────────────────────────────────┤
│ Bottom Info Bar                     │
│ Location: Member City | Tasks: 12   │
├─────────────────────────────────────┤
│ Bottom Navigation                   │
│ [Hero] [Team] [World] [Shop]        │
└─────────────────────────────────────┘
```

### Component Specifications

#### City Boss Section
- **Layout**: Flexbox - image left, info right
- **Castle Image**: 192x192px, pixel art
- **Title**: "👑 King of {System}" - Cinzel 3xl
- **Health Bar**: 24px height, category-colored
- **Status Badge**: "In Battle" / "Defeated" / "Blocked"

#### Commander Cards (3 States)

**Active State:**
- Border: 3px solid `#f0ad4e` (orange)
- Shadow: 0 0 15px rgba(240, 173, 78, 0.3)
- 6 HP Bars in 2-column grid
- Assignee tags visible

**Defeated State:**
- Border: 3px solid `#4cae4c` (green)
- Opacity: 0.85
- Character: Grayscale filter
- Skull overlay icon
- 6 HP Bars in 3-column grid (compact)

**Blocked State:**
- Border: 3px solid `#d9534f` (red)
- Character: Silhouette (brightness 0)
- Lock overlay icon
- Block reason banner (red background)

#### 6 HP Bars Display
- **Layout**: 2 columns (active/blocked) or 3 columns (defeated)
- **Bar Height**: h-2 (8px) for active, h-1.5 (6px) for defeated
- **Gap**: gap-3 or gap-2
- **Icons**: Stage-specific emoji icons

#### Tasks Table
- **Header**: Gradient background, Cinzel font
- **Columns**: Task, Flow, Stage, Assignee, Status
- **Stage Badges**: Colored by category (Design=Orange, etc.)
- **Status Badges**: Active (orange), Defeated (green), Blocked (red)

#### Demon Portal Section
- **Background**: Red-tinted gradient
- **Portal Animation**: 360° rotation, 10s, infinite
- **Warning**: Red banner with warning icon
- **Bug Cards**: Icon + Title + Severity badge

---

## 5. Commander Detail Page

### Page Purpose
หน้าแสดงรายละเอียดของ Flow (Commander) รวมถึงสถานะการต่อสู้ Tasks (Minions) และทีมที่รับผิดชอบ

### Layout Structure

```
┌─────────────────────────────────────┐
│ Header                              │
│ [←] Flow: Login           [● Live]  │
│ 🗺️ World → 🏰 Member → ⚔️ Login    │
├─────────────────────────────────────┤
│ Commander Card                      │
│ ┌────┬───────────────┬────┐         │
│ │⚔️  │ Login         │63% │         │
│ │    │ In Battle     │    │         │
│ └────┴───────────────┴────┘         │
├─────────────────────────────────────┤
│ ⚔️ Battle Status                    │
│ ┌─────────────────────────────────┐ │
│ │ 📐 Design     100% ✓ [████]     │ │
│ │ 📋 AC         100% ✓ [████]     │ │
│ │ ⚙️ API         80%   [███░]     │ │
│ │ 💻 FE/App      50%   [██░░]     │ │
│ │ 🧪 Testing      0%   [░░░░]     │ │
│ │ ✅ UAT          0%   [░░░░]     │ │
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

#### Commander Card
- **Border**: 3px solid `#8b6914`, border-radius: 20px
- **Icon**: 80x80px, 3px gold border, 16px radius
- **Name**: Cinzel 24px, `#f4e8d0`
- **Status Badge**:
  - In Battle: Orange `#f39c12`
  - Defeated: Green `#2ecc71`
  - Preparing: Gray `#7f8c8d`
- **Overall Progress**: Cinzel 32px, `#d4a853`

#### HP Bars (6 Categories)
- **Track Height**: 10px
- **Track Background**: `#1a0f0a`
- **Track Border**: 1px `#5c4018`
- **Fill**: Category color with gradient
- **Completion Check**: ✓ when 100%

#### Minion (Task) Items
- **Background**: `rgba(0, 0, 0, 0.2)`
- **Border Left**: 4px colored by status
- **Border Radius**: 10px
- **Padding**: 12px 15px
- **Icon**: 24px (type-specific)
- **Name**: 15px, strikethrough when done
- **Type Badge**: UI/API/FE with category colors
- **Assignee Avatar**: 20x20px circle

#### Minion Filter Tabs
- **Options**: All, UI, API, FE
- **Style**: Pill buttons
- **Active**: Gold background

#### Team Members
- **Avatar**: 36x36px with class gradient
- **Name**: 14px, `#f4e8d0`
- **Role**: 11px, `#8b6914`

#### System Information
- **Layout**: Two-column
- **Label**: 13px, `#8b6914`
- **Value**: 14px, `#f4e8d0`

---

## 6. Activity Log Page

### Page Purpose
แสดงประวัติกิจกรรมทั้งหมดของผู้เล่นและทีม เรียงตามเวลา พร้อมตัวกรองและการค้นหา

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
- **Background**: `rgba(0, 0, 0, 0.3)`
- **Border**: 2px `#5c4018`, focus: `#d4a853`
- **Border Radius**: 25px
- **Padding**: 8px 16px
- **Icon**: 16px, color `#8b6918`

#### Date Filters
- **Style**: Pills
- **Padding**: 6px 14px
- **Border**: 1px `#5c4018`
- **Border Radius**: 20px
- **Active**: Gold gradient background

#### Category Tabs
| Category | Icon | Color |
|----------|------|-------|
| All | ⭐ | Gold `#d4a853` |
| Combat | ⚔️ | Red `#e74c3c` |
| Exploration | 🗺️ | Blue `#3498db` |
| Social | 👥 | Purple `#9b59b6` |
| Achievement | 🏆 | Yellow `#f1c40f` |
| System | ⚙️ | Gray `#95a5a6` |

#### Stats Summary
- **Events Count**: Total events
- **Today's Count**: Events today
- **Total XP**: XP gained in period

#### Timeline
- **Line**: 2px gradient from gold to brown
- **Dot**: 14px circle with category color
- **Card**: Border-left 4px with category color
- **Hover**: translateX(5px), border color change

#### Activity Card
- **Icon**: 44x44px, rounded 12px, category colored
- **Title**: Cinzel 15px
- **Subtitle**: 13px, `#8b6914`
- **Time**: 12px, `#5c4018`
- **Description**: 14px, `#a08060`
- **Rewards**: Pill badges

#### Reward Badges
| Type | Background | Border | Text |
|------|------------|--------|------|
| XP | `rgba(243, 156, 18, 0.15)` | `#f39c12` | `#f39c12` |
| Gold | `rgba(241, 196, 15, 0.15)` | `#f1c40f` | `#f1c40f` |
| Gem | `rgba(52, 152, 219, 0.15)` | `#3498db` | `#3498db` |
| Item | `rgba(46, 204, 113, 0.15)` | `#2ecc71` | `#2ecc71` |
| Buff | `rgba(155, 89, 182, 0.15)` | `#9b59b6` | `#9b59b6` |

---

## 7. Shop Page

### Page Purpose
ร้านค้าสำหรับซื้อไอเทมตกแต่ง บูสต์ และสกิน โดยใช้ Gold และ Gems

### Layout Structure

```
┌─────────────────────────────────────┐
│ Header                              │
│ 🛒 Shop                   🪙 2,450  │
│ Buy cosmetics with Gold    💎 15    │
├─────────────────────────────────────┤
│ Info Banners                        │
│ ┌─────────────────────────────────┐ │
│ │ 💡 Cosmetic Only                │ │
│ │ Items are purely cosmetic...    │ │
│ └─────────────────────────────────┘ │
│ ┌─────────────────────────────────┐ │
│ │ 💎 Gem = Real Incentive         │ │
│ │ Gems earned by defeating...     │ │
│ └─────────────────────────────────┘ │
├─────────────────────────────────────┤
│ Category Tabs                       │
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
│ [Hero] [Team] [World] [Shop]        │
└─────────────────────────────────────┘
```

### Component Specifications

#### Currency Display
- **Background**: `rgba(0, 0, 0, 0.3)`
- **Border**: 1px `#5c4018`
- **Border Radius**: 20px
- **Padding**: 6px 12px
- **Gold**: Color `#d4a853`
- **Gems**: Color `#3498db`

#### Info Banners
- **Border**: 2px with theme color
- **Border Radius**: 16px
- **Padding**: 15px
- **Icon**: 24px
- **Title**: Cinzel 14px
- **Description**: 13px

#### Category Tabs
- **Padding**: 10px 20px
- **Border**: 2px `#5c4018`
- **Border Radius**: 25px
- **Active**: Gold gradient, dark text

#### Item Cards

**Structure:**
- **Background**: Gradient `#3d2418` to `#2c1810`
- **Border**: 2px with rarity color
- **Border Radius**: 16px
- **Padding**: 15px

**Rarity Levels:**
| Rarity | Border | Badge |
|--------|--------|-------|
| Common | `#7f8c8d` | `#7f8c8d` |
| Rare | `#3498db` | `#3498db` |
| Epic | `#9b59b6` | `#9b59b6` |
| Legendary | `#d4a853` | Gold gradient |

**Item States:**
- **Owned**: Green border `#2ecc71`, "Owned" button
- **Locked**: Opacity 0.6, grayscale, lock icon
- **Available**: Buy button with gold gradient

#### Buy Button
- **Background**: Gold gradient
- **Border Radius**: 10px
- **Padding**: 10px
- **Font**: Cinzel 12px
- **Hover**: Scale 1.02, glow shadow

---

## 8. Login Page

### Page Purpose
หน้าเข้าสู่ระบบ พร้อม Google Sign-in, Email/Password และ Demo Access

### Layout Structure

```
┌─────────────────────────────────────┐
│ [← Back to Portal]                  │
│                                     │
│    ╔═══════════════════════╗        │
│    ║ ◆ ◆ ◆  ◆ ◆ ◆  ◆ ◆ ◆ ║        │
│    ║                       ║        │
│    ║       ┌─────────┐     ║        │
│    ║       │  Logo   │     ║        │
│    ║       │   SVG   │     ║        │
│    ║       └─────────┘     ║        │
│    ║                       ║        │
│    ║     MCOP QUEST        ║        │
│    ║  Enter the Realm...   ║        │
│    ║                       ║        │
│    ║  ┌─────────────────┐  ║        │
│    ║  │ ◆ ◆ ◆  Enter    │  ║        │
│    ║  │    Sign in...   │  ║        │
│    ║  │                 │  ║        │
│    ║  │ [Continue with  │  ║        │
│    ║  │      Google]    │  ║        │
│    ║  │                 │  ║        │
│    ║  │    ─ or ─       │  ║        │
│    ║  │                 │  ║        │
│    ║  │ EMAIL ADDRESS   │  ║        │
│    ║  │ ┌─────────────┐ │  ║        │
│    ║  │ │hero@mcop... │ │  ║        │
│    ║  │ └─────────────┘ │  ║        │
│    ║  │                 │  ║        │
│    ║  │ PASSWORD        │  ║        │
│    ║  │ ┌─────────────┐ │  ║        │
│    ║  │ │••••••••    │ │  ║        │
│    ║  │ └─────────────┘ │  ║        │
│    ║  │                 │  ║        │
│    ║  │ [ ] Remember me │  ║        │
│    ║  │                 │  ║        │
│    ║  │ [ENTER THE      │  ║        │
│    ║  │      QUEST]     │  ║        │
│    ║  │                 │  ║        │
│    ║  │ ─ Quick Access ─│  ║        │
│    ║  │ [Ken]   [May]   │  ║        │
│    ║  └─────────────────┘  ║        │
│    ╚═══════════════════════╝        │
│                                     │
│   [🗺️]    [⚔️]    [🎁]             │
│  World   Battle   Rewards           │
│                                     │
│  By signing in, you agree...        │
│  © 2026 MCOP Quest                  │
└─────────────────────────────────────┘
```

### Component Specifications

#### Corner Decorations
- **Size**: 150x150px fixed corners
- **Border**: 4px solid gold
- **Border Radius**: 0 0 100% 0 (varies by corner)
- **Opacity**: 0.6

#### Logo Section
- **Icon**: 100x100px, floating animation
- **Title**: Cinzel 48px, gold with text shadow
- **Subtitle**: 18px, italic, gold

#### Login Card
- **Background**: Gradient `#4a2e1f` to `#3d2418`
- **Border**: 3px `#8b6914`
- **Border Radius**: 20px
- **Padding**: 40px
- **Max Width**: 450px
- **Decorative diamonds**: ◆ at top

#### Google Button
- **Background**: White gradient
- **Border**: 2px `#d4a853`
- **Border Radius**: 8px
- **Padding**: 14px 20px
- **Shimmer effect**: On hover

#### Form Inputs
- **Background**: `#1a0f0a`
- **Border**: 2px `#5c4018`, focus: `#d4a853`
- **Border Radius**: 8px
- **Padding**: 14px 16px
- **Label**: 14px uppercase, `#d4a853`

#### Submit Button
- **Background**: Gold gradient
- **Border**: 2px `#8b6914`
- **Border Radius**: 8px
- **Padding**: 16px
- **Font**: Cinzel 16px uppercase
- **Shadow and hover lift**: Effect

#### Demo Buttons (Quick Access)
- **Background**: Transparent
- **Border**: 2px `#5c4018`
- **Border Radius**: 8px
- **Padding**: 10px 20px
- **Content**: Avatar SVG + name + class

#### Feature Highlights
- **Icon**: 40x40px
- **Text**: 12px uppercase, `#8b6914`

#### Welcome Modal (on first login)
- **Overlay**: `rgba(0, 0, 0, 0.8)` with blur
- **Content**: Same card style with gold border
- **Hero Preview**: Avatar with class
- **Starting Gifts**: Badges showing initial items
- **Button**: "Start Your Journey"

---

## 9. Components Reference Page

### Page Purpose
หน้าอ้างอิง UI Components ทั้งหมดในระบบ สำหรับนักพัฒนาและการทดสอบ

### Component Categories

#### 1. HP Bars (6 Types)
```
┌─────────────────────────────────────┐
│ 📐 Design    [████████░░] 80%       │
│ 📋 AC        [████████░░] 80%       │
│ ⚙️ API       [█████░░░░░] 50%       │
│ 💻 FE        [████░░░░░░] 40%       │
│ 🧪 Testing   [██░░░░░░░░] 20%       │
│ ✅ UAT       [░░░░░░░░░░]  0%       │
└─────────────────────────────────────┘
```

#### 2. Status Badges
| Badge | Background | Border | Text |
|-------|------------|--------|------|
| In Battle | `rgba(231, 76, 60, 0.15)` | `#e74c3c` | `#e74c3c` |
| Defeated | `rgba(46, 204, 113, 0.15)` | `#2ecc71` | `#2ecc71` |
| Blocked | `rgba(149, 165, 166, 0.15)` | `#95a5a6` | `#95a5a6` |
| Pending | `rgba(243, 156, 18, 0.15)` | `#f39c12` | `#f39c12` |
| Ready | `rgba(52, 152, 219, 0.15)` | `#3498db` | `#3498db` |

#### 3. Minion Cards (Task Types)
| Type | Icon | Background | Border |
|------|------|------------|--------|
| UI | 🎨 | `rgba(230, 126, 34, 0.15)` | `#e67e22` |
| API | ⚙️ | `rgba(155, 89, 182, 0.15)` | `#9b59b6` |
| FE | 💻 | `rgba(26, 188, 156, 0.15)` | `#1abc9c` |

#### 4. Buttons
| Variant | Background | Border | Text |
|---------|------------|--------|------|
| Primary | Gold gradient | `#d4a853` | `#1a0f0a` |
| Secondary | Transparent | `#8b6918` | `#d4a853` |
| Danger | `rgba(231, 76, 60, 0.15)` | `#e74c3c` | `#e74c3c` |
| Disabled | `rgba(127, 140, 141, 0.15)` | `#5c4018` | `#5c4018` |

#### 5. Toast Notifications
| Type | Background | Border | Icon |
|------|------------|--------|------|
| Success | `rgba(46, 204, 113, 0.1)` | `#2ecc71` | ✅ |
| Warning | `rgba(243, 156, 18, 0.1)` | `#f39c12` | ⚠️ |
| Error | `rgba(231, 76, 60, 0.1)` | `#e74c3c` | ❌ |
| Info | `rgba(52, 152, 219, 0.1)` | `#3498db` | ℹ️ |

#### 6. Currency Display
- **Gold**: 🪙 Icon + amber color `#d4a853`
- **Gems**: 💎 Icon + blue color `#3498db`

#### 7. XP Bar
- **Container**: Gradient background, 2px border
- **Track**: 16px height, `#1a0f0a`
- **Fill**: Gold gradient, animated glow
- **Level Badge**: Gold gradient pill

#### 8. Character Classes
| Class | Icon | Color | Role |
|-------|------|-------|------|
| Warrior | ⚔️ | `#e74c3c` | Backend Dev |
| Mage | 🧙 | `#9b59b6` | Frontend Dev |
| Blacksmith | 🔨 | `#e67e22` | UX/UI Designer |
| Scout | 🔍 | `#3498db` | Business Analyst |
| Healer | 💊 | `#2ecc71` | QA Engineer |
| Guild Master | 👑 | `#f1c40f` | Project Manager |

---

## Implementation Notes

### Responsive Breakpoints

| Breakpoint | Width | Changes |
|------------|-------|---------|
| Mobile | < 600px | Single column, stacked layouts, simplified navigation |
| Tablet | 600-800px | 2 columns where applicable |
| Desktop | > 800px | Full layouts, max-width containers |

### Animation Guidelines

| Element | Duration | Effect |
|---------|----------|--------|
| Card hover | 0.3s | translateY(-2px), shadow increase |
| Border transitions | 0.3s | Color change |
| Button hover | 0.2s | Scale 1.02, box-shadow glow |
| Progress bars | 0.5s | Width transition |
| Toast slide-in | 0.3s | Ease out |
| Portal swirl | 10s | 360° rotation infinite |
| Commander idle | 2.5s | Float up/down |

### Accessibility Requirements

- **Focus states**: Gold border with box-shadow
- **Color contrast**: Minimum 4.5:1 for text
- **Touch targets**: Minimum 44x44px
- **Status indicators**: Color + icon + text
- **Reduced motion**: Respect prefers-reduced-motion

---

## File Reference

### Prototype Files
- `hero-v2.html` - Hero Dashboard
- `team-v2.html` - Team Camp
- `world-map-v2.html` - World Map (Canvas 2D)
- `city-v2.html` - City Detail
- `commander-v2.html` - Commander Detail
- `activity-log-v2.html` - Activity Log
- `shop-v2.html` - Shop
- `login-v2.html` - Login
- `components-v2.html` - Components Reference

### Asset Directories
- `assets-v2/` - Character and monster pixel art
- `assets-pixels/ui/` - UI icons (coin, gem, arrows)
- `assets-pixels/characters/` - Character class avatars
- `images/map/tiles/` - Map tile textures
- `images/map/structures/` - Map location structures
