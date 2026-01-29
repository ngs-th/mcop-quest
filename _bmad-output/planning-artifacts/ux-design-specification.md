---
stepsCompleted: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
lastStep: 14
inputDocuments:
  - product-brief-mcop-quest-2026-01-28.md
  - prd.md
  - architecture.md
  - mcop_quest_wireframe_definition_v_0.md
  - mcop_quest_system_rules_formulas_v_0.md
workflowType: 'ux-design'
project_name: 'mcop-quest'
user_name: 'Master'
date: '2026-01-29'
completedAt: '2026-01-29'
status: 'complete'
---

# UX Design Specification - mcop-quest

**Author:** Master
**Date:** 2026-01-29

---

<!-- UX design content will be appended sequentially through collaborative workflow steps -->

## Executive Summary

### Project Vision

MCOP Quest เป็น Internal Gamification Dashboard ที่แปลงข้อมูล Project Management บน Google Sheets ให้กลายเป็นประสบการณ์เกม RPG ยุค 90 โดยใช้ **Semantic Gamification Mapping** — ไม่ใช่แค่ใส่แต้ม แต่เปลี่ยนบริบททั้งหมดให้กลายเป็นโลกเกมแฟนตาซีที่ "การทำงานคือการผจญภัย"

ปัญหาหลักที่แก้: ทีมพัฒนาซอฟต์แวร์ **ขาด Big Picture Visibility** และ **ขาด Engagement** — อัปเดต Google Sheets เป็นแค่ "ภาระงานเอกสาร" ไม่ใช่ความภูมิใจ

**Entity Mapping:**

| จริง (Real) | เกม (Game Metaphor) |
|--------------|---------------------|
| System / Epic | City (เมือง) + City Boss |
| Flow / Story | Commander (หัวหน้าหน่วย) |
| Task | Minion (สมุน) |

### Target Users

| Role | Game Class | หน้าที่ | ปัญหา/ความต้องการ |
|------|-----------|----------|---------------------|
| Backend/Frontend Dev | Warrior/Mage | ลงแรง Coding | อยากเห็น Instant Gratification เมื่องานเสร็จ |
| Business Analyst / PO | Scout | สำรวจ Requirement | ต้องการให้ทีมเห็นความสำคัญของการ Clear Path |
| UX Designer | Blacksmith | สร้าง Asset/UI | งานคือ Equipment ที่ Block/Unblock Dev flow |
| Project Manager | Guild Master | ดูภาพรวม | ต้องข้อมูลสรุปสวยๆ สำหรับ Present ผู้บริหาร |

### Key Design Challenges

**1. Fairness & Visibility for Support Roles**

- ทีม BU/UX **ไม่ได้ลด HP Boss** แต่ให้ Support Buff
- จะทำอย่างไรให้พวกเขา "เห็นผล" และ "รู้สึกมีคุณค่า" เท่ากับ Warrior?

**2. Flow-Level Equipment Blocking**

- **Critical Rule:** ถ้า UX/UI (Equipment) ยังไม่พร้อม → Commander (Flow) ถูก Block
- Visual: Commander ต้องมี icon "ยังต่อสู้ไม่ได้ - อุปกรณ์ไม่ครบ"
- Unblocking: UX/UI Ready → Block หายทันที (Real-time)

**3. Multi-Role Information Architecture**

- 4 Classes ที่ต่างกันมาก — จะสร้าง UI ที่ "พอดี" กับทุกคน?
- Balance ระหว่าง Game Immersion กับ Professional Dashboard

### Design Opportunities

**1. Emotional Feedback Loop**

- Animation "Damage Hit" → สร้างความรู้สึก "ฟิน" ทันทีที่งานเสร็จ
- Sound/FX เมื่อ Boss Down → สร้างความภูมิใจร่วมกัน

**2. Smart Visibility Control**

- Fog of War = Visual Metaphor สำหรับ "Incomplete Requirements"
- Real-time Sync ทำให้ทุกคนเห็น "Same Truth" กัน

**3. Role-Specific Value Display**

- Warrior View: เน้น Damage Output, Kill Count
- Scout View: เน้น Fog Cleared, Path Revealed
- Blacksmith View: เน้น Equipment Delivered, Commander Unblocked

---

## Core User Experience

### Defining Experience

MCOP Quest เป็น **Read-Only Gamification Dashboard** ที่ออกแบบมาเพื่อให้ **"Situation Awareness with Minimal Friction"** — ผู้ใช้เปิดมาแล้วเห็นภาพรวมของโปรเจกต์ทันที โดยไม่ต้องทำอะไรเพิ่ม (Zero-Input Dashboard)

**Core Loop:**

```
เปิด Dashboard → เห็น "เราอยู่ตรงนี้" (World Map)
    ↓
เช็คสถานะภาพรวม → รู้ว่า "ทีมเราเป็นอย่างไร" (Team View)
    ↓
ดู Task ตัวเอง → รู้ว่า "ฉันต้องทำอะไร" (Personal View)
    ↓
(เมื่องานเสร็จจาก Sheet) → เห็น Progress ตัวเองก้าวหน้า
    ↓
วนกลับไปเช็คใหม่ 🔄
```

### Platform Strategy

**Multi-Device, Single Experience:**

| Scenario | Device | Primary Pattern | Key Requirement |
|----------|--------|-----------------|-----------------|
| Dev ทั่วไป | Mobile (375px+) | Thumb Zone Navigation | Quick Check < 5 วินาที |
| Dev ขณะทำงาน | Desktop (จอที่ 2) | Passive Monitoring | Glanceable, Non-intrusive |
| PM Present | Tablet (iPad) | Presentation Mode | Clean, Executable View |
| ทุก Scenario | - | Seamless Sync | ข้อมูลตรงกันทุก Device |

**Mobile-First Navigation:**
- **Mobile:** Bottom Tab Bar (Personal | Team | World | Shop)
- **Desktop:** Sidebar แสดงทุก View พร้อมกัน (Glanceable)

**Responsive Behavior:**
- Mobile: Single View, Stack Navigation
- Tablet: 2-Column Split View (แสดง Map + Detail ควบคู่)
- Desktop: 3-Column Dashboard (Personal + Team + World)

### Effortless Interactions

**1. Navigation Effortlessness**
- **Mobile:** Bottom Tab Bar — 1 Tap สลับ View
- **Desktop:** Sidebar — 1 Click เข้าถึงทุก View
- **Breadcrumb:** อยู่ไหนของโลกเกม (City → Commander → Minion)

**2. Task Detail Access**
- **Pattern:** Card → Detail Page (2 Taps/Clicks)
- **Alternative:** Click Minion บน Map → Detail Page (Deep Link)
- **Constraint:** ไม่เกิน 2 Interactions ถึงข้อมูล Requirement

**3. Real-Time Sync Awareness**
- รู้ได้ทันทีว่า "ข้อมูลอัปเดตแล้ว" (Visual Feedback)
- Last Sync Timestamp แสดงอยู่เสมอ
- Manual Sync Button สำหรับ "ต้องการข้อมูลล่าสุดทันที"

### Critical Success Moments

**Priority Order (จากสูงไปต่ำ):**

**1. "เราอยู่ตรงนี้" Moment (World Map Clarity)**
- User เปิดมา → เห็น World Map → รู้ทันทีว่า:
  - โปรเจกต์ถึงไหนแล้ว (กี่เมืองผ่านแล้ว)
  - ตอนนี้กำลังต่อสู้ที่ไหน (เมือง/บอสปัจจุบัน)
  - อะไรคือหัวใจสำคัญ (Fog areas, High HP bosses)

**2. "ได้รับรางวัลทันที" Moment (Instant Reward)**
- Task Done (จาก Sheet Sync) → เห็นทันที:
  - Level/EXP ขยับขึ้น
  - Gold เพิ่มขึ้น (พร้อม Animation)
  - รู้สึก "งานนี้มีค่า"

**3. "ตัวละครพัฒนา" Moment (Character Progress)**
- เห็น Equipment เปลี่ยน → รู้สึก "โตขึ้น"
- เห็น Level ขึ้น → รู้สึก "เก่งขึ้น"
- เห็น Gold เพิ่ม → รู้สึก "รวยขึ้น"

**4. "ฉันรู้ว่าต้องทำอะไร" Moment (Task Clarity)**
- เปิด Personal View → เห็น Task List:
  - อะไรคือ Minion ที่ต้องกำจัด
  - อะไรคือ Support Work ที่ต้องทำ
  - อะไร Block อยู่ (Equipment missing)

### Experience Principles

**1. "Glanceability First" Principle**

> ทุกหน้าจอต้องสามารถเข้าใจได้ภายใน **5 วินาที** แรก

- World Map: เห็น "ที่ไหน" ทันที
- Team View: เห็น "สถานะอย่างไร" ทันที
- Personal View: เห็น "ต้องทำอะไร" ทันที

**2. "Zero-Input, Maximum-Output" Principle**

> User ไม่ต้องกระทำใดๆ — ระบบทำงานเองหมด

- ไม่มีปุ่ม Update Status
- ไม่ต้อง Refresh — Sync อัตโนมัติ
- User แค่ "รับชม" และ "รู้สึก"

**3. "Device-Agnostic Consistency" Principle**

> ประสบการณ์เดียวกันทุก Device — แต่ Optimize ตาม Context

- Mobile: Quick Check (Thumb Zone)
- Desktop: Passive Monitor (Glanceable Sidebar)
- Tablet: Presentation (Clean View)

**4. "Emotional Feedback Loop" Principle**

> ทุกการเปลี่ยนแปลงต้องมี Feedback — สร้าง "ฟิน" จาก Progress

- EXP/Gold เพิ่ม → Animation
- Boss HP ลด → Damage Number
- Equipment เปลี่ยน → Visual Update

**5. "Progress Transparency" Principle**

> Character Progress Display Priority:
> ```
> Equipment (C) > Level/EXP (A) > Gold (B) > Stats (D)
> ```

- Equipment: "ฉันสวมใส่อะไรอยู่" — Visual Identity สำคัญสุด
- Level: "ฉันเก่งแค่ไหน" — Growth Indicator
- Gold: "ฉันซื้ออะไรได้" — Purchasing Power
- Stats: "ฉันทำอะไรมาแล้ว" — Achievement Log

---

## Desired Emotional Response

### Primary Emotional Goals

**1. Delight (First Impression)**

> "โห้! นี่สวยมาก แตกต่างจาก Sheets ชัดเจนเลย"

User เปิด mcop-quest ครั้งแรก → รู้สึก **ประหลาดใจ** กับความแตกต่างจาก Google Sheets

- **Visual:** World Map ที่สวยงามและเป็นระบบ
- **Contrast:** จากตารางมหาศาล → กลายเป็นโลกแฟนตาซี
- **Emotion:** "Wow! นี่จริงไหม? เจ๋งดี"

**2. Relief (Task Completion)**

> "โล่ย! สะสางงานนี้"

เมื่อ Task ยากๆ เสร็จสิ้นลง → User รู้สึก **โล่งใจ** ที่ทำได้สำเร็จ

- **Trigger:** Task Status เปลี่ยน → Done
- **Visual:** Minion ตาย, Commander บาดเจ็บ
- **Emotion:** "เหนื่อยแต่พอแล้ว ทำไปได้"

**3. Purpose (Meaningful Work)**

> "แรงของฉันมีความหมาย"

เมื่อเห็น HP บอสลดลง → User รู้สึกว่า **งานของตนส่งผล**

- **Trigger:** Damage Number เด้งขึ้น
- **Visual:** Boss HP Bar ลดลงอย่างชัดเจน
- **Emotion:** "โค้ดชิ้นนี้มีค่า มันช่วยทีมจริงๆ"

**4. Triumph (Victory)**

> "ในที่สุดก็เอาชนะมันได้!"

เมื่อ Boss ตาย → User รู้สึก **ชนะ** และภูมิใจ

- **Trigger:** Boss HP = 0
- **Visual:** Boss สลายไป, Loot Box หล่นลง
- **Emotion:** "เราทำได้! Epic นี้จบแล้ว!"

### Emotional Journey Mapping

**Stage 1: Discovery (First Open)**

```
Before: "อีกหนึ่ง Sheet เบื่อ"
    ↓
Open mcop-quest → "โห้! นี่สวยมาก" (Delight)
    ↓
Explore → "เข้าใจทันที ไม่งง" (Clarity)
```

**Stage 2: Core Experience (Daily Usage)**

```
เปิดดู → "เราอยู่ตรงนี้" (Orientation)
    ↓
ทำงานไป → Monitor สถานะแบบ Passive (Calm)
    ↓
Task Done → "โล่ย!" (Relief)
```

**Stage 3: Achievement (Task/Boss Complete)**

```
Task Done → "โล่ย! สะสางงานนี้" (Relief)
    ↓
เห็น Damage → "แรงฉันมีความหมาย" (Purpose)
    ↓
Boss ตาย → "เอาชนะแล้ว!" (Triumph)
```

**Stage 4: Return (Next Day)**

```
กลับมาเปิด → "เฮ้ย อัปเดตแล้ว" (Trust)
    ↓
ดู Progress ตัวเอง → "โตขึ้นนะ" (Growth)
    ↓
เริ่มวันใหม่ (Loop)
```

### Micro-Emotions

**Positive Micro-Emotions to Cultivate:**

| Emotion | Trigger | UX Implication |
|---------|---------|----------------|
| **Confidence** | เห็นภาพรวมชัดเจน | Glanceable Design |
| **Trust** | ข้อมูล Sync ตรงเสมอ | Real-time Sync Indicator |
| **Excitement** | เห็น Progress ตัวเอง | Level/EXP Animation |
| **Accomplishment** | Task Complete | Damage Number, Minion Death |
| **Delight** | เห็น Visual ครั้งแรก | High-Quality Art Direction |
| **Belonging** | เห็นทีมก้าวหน้าด้วยกัน | Team View Progress |

**Negative Micro-Emotions to Avoid (Nightmares):**

| Emotion | Prevent by | Anti-Pattern |
|---------|-----------|--------------|
| **Confusion** | Clear Navigation, Glanceability | Hidden Menus, Complex Flows |
| **Distrust** | Sheet Data Alignment | Desync, Stale Data |
| **Frustration** | Fast Load, Smooth Animation | Lag, Janky UX |
| **Anxiety** | No-Shame Design | Leaderboards, Public Shaming |
| **Isolation** | Shared World View | Siloed Information |

### Design Implications

**1. Creating "Delight" (First Impression)**

| UX Choice | Emotional Impact |
|-----------|------------------|
| High-Quality Visual Design | "นี่สวยมาก" |
| Clear Map Metaphor | "เข้าใจทันที" |
| Smooth Animations | "รู้สึกพรีเมียม" |
| Color Consistency | "ดูมีระบบ" |

**2. Creating "Relief" (Task Completion)**

| UX Choice | Emotional Impact |
|-----------|------------------|
| Minion Death Animation | "จบแล้ว โล่ย" |
| Task Card Dim/Gray Out | "เคลียร์แล้ว" |
| Satisfying "Pop" Sound | "ปิดคดี" |
| Visual Strike-through | "ผ่านไปแล้ว" |

**3. Creating "Purpose" (Meaningful Work)**

| UX Choice | Emotional Impact |
|-----------|------------------|
| Damage Number เด้งชัดเจน | "แรงฉันมีค่า" |
| Boss HP Bar ลดลง | "ส่งผลจริง" |
| Party Contribution | "ทีมรู้ว่าฉันทำ" |
| Support Tier Indicator | "Buff ของฉันช่วย" |

**4. Creating "Triumph" (Victory)**

| UX Choice | Emotional Impact |
|-----------|------------------|
| Boss Death Animation | "ชนะแล้ว!" |
| Screen Shake / FX | "เจ๋งมาก" |
| Loot Box Drop | "ได้รางวัล" |
| Epic Complete Banner | "สำเร็จแล้ว" |

### Emotional Design Principles

**1. "Delight First" Principle**

> First Impression is Lasting Impression — ลงทุนที่ Visual Quality ตั้งแต่ First Screen

- Hero Section: World Map ต้องสวยงาม
- Animation: Smooth, Polished
- Color Palette: Cohesive, Premium

**2. "Relief via Feedback" Principle**

> Task Done ต้องรู้สึก "โล่ย" ทันที — ไม่ต้องเดา

- Visual: Minion หายไป, Card จางลง
- Audio: "Pop" / "Ding" ที่ Satisfying
- Haptic: (Mobile) Vibrate เบาๆ

**3. "Purpose via Visibility" Principle**

> แสดงให้เห็นว่า "งานฉันส่งผล" — ไม่ใช่หายไปเงียบๆ

- Damage Number: แสดงบน Boss Card
- Contribution: Party DPS / Support Stats
- Progress: "ฉันทำไปแล้วกี่ %"

**4. "Triumph via Celebration" Principle**

> Boss Down ต้องฉลอง — ไม่ใช่แค่ "Status: Done"

- Big Animation: Boss สลาย / ระเบิด
- Loot Box: Visual Reward
- Screenshot Moment: UI สวยงาม Share ได้

**5. "No Shame, No Blame" Principle**

> ห้ามสร้างความรู้สึก "ฉันแย่กว่าคนอื่น"

- ไม่มี Leaderboard ประจาน
- ไม่แสดง Comparison รายบุคคล
- เน้น Team Success > Individual Comparison

---

## UX Pattern Analysis & Inspiration

### Inspiring Products Analysis

**1. Habitica (RPG Task Management)**

**ความคล้ายกัน:** Habitica = Tasks กลายเป็น RPG, mcop-quest = Projects กลายเป็น RPG

**สิ่งที่เรียนรู้:**
- **Task → Reward Loop ที่ชัดเจน:** ทำ Habit → ได้ Gold/XP → ซื้อ Equipment → ตัวละครโตขึ้น
- **Character Avatar:** 2D Sprite ที่ดูน่ารัก Chibi Style
- **Party System:** แสดง Party Members พร้อม HP/Level
- **Quest Board:** Daily Tasks แสดงเป็น Quest List

**นำไปปรับใช้กับ mcop-quest:**
- Task (Minion) → Complete → ได้ Gold/EXP → Level ขึ้น
- Personal Dashboard แสดง Character Avatar พร้อม Equipment
- Team View แสดง Party Members
- World Map = Quest Board ขนาดใหญ่

**2. Duolingo (Gamification Learning)**

**จุดเด่น:**
- **XP Bar + Level Up Animation:** ชัดเจนว่าใกล้ Level ขนาดไหน
- **Streak Counter:** ทำต่อเนื่องกี่วันแล้ว
- **Notifications:** "Continue Streak" ดังจี๊ด แต่ไม่รบกวน
- **Humor:** Duo the Owl ตลก ทำให้ไม่น่าเบื่อ

**นำไปปรับใช้กับ mcop-quest:**
- XP Bar: แสดงชัดเจนว่าใกล้ Level ขนาดไหน
- Level Up Animation: เป็นจุด Highlight ของวัน
- Notifications: แจ้งเตือน Task Done แบบไม่น่ารำคาญ
- Humor: RPG Theme สนุกๆ แต่ไม่ต้องตลกจนเกินไป

**3. Ragnarok / MapleStory (Classic MMORPG)**

**จุดเด่น:**
- **2D Pixel Art Graphics:** สไตล์ Retro ที่ Classic
- **Chibi Proportions:** Head ใหญ่, Body เล็ก — น่ารัก
- **HP/MP Bar:** วางมุมบนซ้าย — Standard Position
- **Equipment Window:** Grid Layout ชัดเจน
- **Damage Numbers:** เด้งเหนือหัวมอน

**นำไปปรับใช้กับ mcop-quest:**
- **Visual Style:** 2D Pixel Art / Chibi Style
- **Character Proportions:** Chibi (Head:Body = 1:2)
- **HP Bar Position:** มุมบนซ้าย (หรือบนหัวมุมซ้าย)
- **Equipment Display:** Grid Layout
- **Damage Feedback:** Numbers เด้งเหนือหัวตัวละคร

**4. Trello (Kanban PM)**

**จุดเด่น:**
- **Card-based Layout:** Tasks เป็น Cards
- **Board View:** ดูภาพรวมทั้ง Board ได้ทันที
- **Labels/Tags:** สีชัดเจนแยกประเภท
- **Drag-and-Drop:** ย้าย Status ง่าย (mcop-quest ไม่ใช้)

**นำไปปรับใช้กับ mcop-quest:**
- **Task Cards:** Tasks เป็น Cards แสดงใน Personal View
- **World Map = Board:** ดูภาพรวมทั้ง Project ได้ทันที
- **Tags:** Damage (BE/FE) vs Support (BU/UX) แยกสีชัดเจน

### Transferable UX Patterns

**Navigation Patterns:**

| Pattern | Source | Apply to mcop-quest |
|---------|--------|-------------------|
| Bottom Tab Bar | Twitter/Mobile Apps | Mobile: 4 Main Views |
| Sidebar | Notion/Desktop Apps | Desktop: Show all Views |
| Breadcrumb | E-commerce | City → Commander → Minion |

**Interaction Patterns:**

| Pattern | Source | Apply to mcop-quest |
|---------|--------|-------------------|
| Card → Detail (2 Taps) | Trello | Task Access Pattern |
| Tap Minion → Detail | RPG Games | Deep Link from Map |
| Pull to Refresh | Twitter Apps | Manual Sync Button |

**Visual Patterns:**

| Pattern | Source | Apply to mcop-quest |
|---------|--------|-------------------|
| Chibi Avatar | Ragnarok/MapleStory | Character Sprite |
| HP Bar Top-Left | Classic RPG | Boss HP Position |
| Damage Numbers | RPG Games | Feedback Animation |
| XP Bar with Progress | Duolingo | Level Up Visual |

### Anti-Patterns to Avoid

**1. Hidden Progress (Jira Pattern)**
- ❌ ต้อง Click เข้าไปดูทีละ Task ถึงจะรู้สถานะ
- ✅ mcop-quest: World Map แสดงภาพรวมทันที

**2. Complex Navigation (Old PM Tools)**
- ❌ เมนูซ้อนเมนู หาทางไม่เจอ
- ✅ mcop-quest: 3 Views เท่านั้น (Personal/Team/World)

**3. Shaming Leaderboard (Habitica League)**
- ❌ แสดง Ranking คนรั้งท้าย
- ✅ mcop-quest: No-Shame Design, Team Success Focus

**4. Boring Task List (Google Sheets)**
- ❌ ตารางเปล่าๆ ไม่มีชีวิต
- ✅ mcop-quest: Gamified Metaphor, Visual Delight

### Design Inspiration Strategy

**What to Adopt:**

- **Habitica's Task → Reward Loop:** เพราะตรงกับ Core Concept ที่สุด
- **Duolingo's XP Bar:** Clear Progress Visualization
- **Ragnarok's Chibi Style:** 2D Pixel Art ที่ Classic
- **Trello's Card Layout:** Clear Task Organization

**What to Adapt:**

- **Duolingo's Notifications:** ปรับเป็น "Task Done" Alert แบบไม่รบกวน
- **RPG HP Bar Position:** ปรับให้เหมาะกับ Dashboard Layout
- **Board View Concept:** ปรับ Trello Board → World Map Metaphor

**What to Avoid:**

- **Leaderboards:** ขัดกับ No-Shame Principle
- **Drag-and-Drop Task Management:** ไม่มีใน mcop-quest (Read-only)
- **Complex Social Features:** ไม่จำเป็นสำหรับ Internal Team

---

## Design System Foundation

### Design System Choice

**Selected: Tailwind CSS + Custom Game Components**

**Core Stack:**
- **CSS Framework:** Tailwind CSS (Utility-First)
- **Component Framework:** Livewire 4 + Alpine.js
- **Build Tool:** Vite (HMR + Optimized Assets)
- **Icons:** Heroicons (UI) + Custom RPG Icons (Game Elements)

**Visual Style Decision:**
- **Art Style:** Modern Vector Art (SVG) แต่ Proportions Chibi
- **Color Source:** Ragnarok/MapleStory Color Palettes
- **Character Proportions:** Chibi (Head:Body = 1:2)

### Rationale for Selection

**1. Tailwind CSS - Why Perfect for mcop-quest:**

| Reason | Explanation |
|--------|-------------|
| **Utility-First** | ปรับแต่งง่าย ไม่ต้องเขียน Custom CSS |
| **Dark Mode Built-in** | `dark:` prefix รองรับความต้องการ Dark Mode |
| **Responsive by Default** | Mobile First ทำง่ายด้วย Breakpoint Classes |
| **Small Bundle Size** | เหมาะกับ Performance (< 2s Load Time) |
| **Laravel Integration** | Standard ใน Breeze Stack |

**2. Modern Vector Art (Chibi Proportions):**

| Reason | Explanation |
|--------|-------------|
| **Scalability** | SVG ขยายไม่แตกตอน Resize |
| **Performance** | เบากว่า Bitmap Sprites |
| **Modern Look** | ดู Premium แต่ยังความน่ารัก Chibi |
| **Animation-Friendly** | CSS Animations ทำได้ง่าย |

**3. Custom Components for Game Elements:**

| Reason | Explanation |
|--------|-------------|
| **Unique Identity** | ไม่ดูเหมือน Dashboard ทั่วไป |
| **Game-Specific Needs** | HP Bar, Damage Numbers, XP Bar ต้อง Custom |
| **Flexibility** | ปรับแต่งได้ตาม Gameplay Requirements |

### Implementation Approach

**Phase 1: Foundation (Setup)**
```bash
# 1. Install Laravel Breeze with Tailwind
php artisan breeze:install livewire --dark --pest

# 2. Configure Tailwind for Custom Colors
# Edit tailwind.config.js
```

**Phase 2: Design Tokens Definition**

```javascript
// tailwind.config.js - Custom Colors from Ragnarok/MapleStory
module.exports = {
  theme: {
    extend: {
      colors: {
        // RPG-Inspired Palette
        'hp-red': '#E74C3C',      // HP Bar
        'mp-blue': '#3498DB',     // MP Bar (if needed)
        'xp-gold': '#F1C40F',     // XP Bar
        'gold': '#FFD700',        // Gold Currency
        'gem-purple': '#9B59B6',  // Gem Currency
        'fog-gray': '#95A5A6',    // Fog of War
        'grass-green': '#27AE60', // Safe Zone
        'danger-red': '#C0392B',  // Danger/Blocked
      }
    }
  }
}
```

**Phase 3: Component Architecture**

```
resources/views/
├── components/          # Blade Components (UI)
│   ├── buttons/          # Standard UI Buttons
│   ├── cards/            # Task/Minion Cards
│   └── badges/           # Status Badges
├── livewire/
│   ├── components/       # Dumb Components (Stateless)
│   │   ├── HealthBar.php
│   │   ├── XPBar.php
│   │   └── DamageNumber.php
│   └── pages/            # Smart Components (Stateful)
│       ├── HeroDashboard.php
│       ├── TeamView.php
│       └── WorldMap.php
└── game/                 # Custom Game Components
    ├── boss-card.blade.php
    ├── minion-card.blade.php
    └── equipment-grid.blade.php
```

### Customization Strategy

**1. Color Palette Customization**

**Source Colors from Ragnarok/MapleStory:**

| Usage | Color | Hex | Tailwind Class |
|-------|-------|-----|---------------|
| HP Bar (High) | Green | `#2ECC71` | `bg-hp-high` |
| HP Bar (Medium) | Yellow | `#F1C40F` | `bg-hp-medium` |
| HP Bar (Low) | Red | `#E74C3C` | `bg-hp-low` |
| XP Bar | Gold | `#F39C12` | `bg-xp` |
| Gold Currency | Bright Gold | `#FFD700` | `text-gold` |
| Fog of War | Gray | `#BDC3C7` | `bg-fog` |
| Damage Task | Orange | `#E67E22` | `bg-damage` |
| Support Task | Blue | `#3498DB` | `bg-support` |

**2. Chibi Character Guidelines**

**Proportions:**
```
Head : Body = 1 : 2
Head Width : Body Width = 1 : 1.5
Height (Total) = 64px (Standard)
```

**Expression Style:**
- **Happy:** งานเสร็จ, Level Up
- **Neutral:** ปกติ
- **Sad/Injured:** Task Blocked, Equipment Missing
- **Victory:** Boss Down

**3. Custom Game Components**

**Boss Card Component:**
```
┌─────────────────────────────┐
│  [Boss Avatar]  Boss Name     │
│  ████████░░░░  HP 45/100      │
│  [Equipment Icons]              │
│  [Damage Dealt This Week]       │
└─────────────────────────────┘
```

**Minion Card Component:**
```
┌─────────────────────────────┐
│  [Task Icon]  Task Title      │
│  [Tag: Damage/Support]         │
│  Status: Doing/Done/Blocked    │
└─────────────────────────────┘
```

**HP Bar Component:**
```
████████░░░░ 45/100
  Green    Red  (Gradient)
```

**XP Bar Component:**
```
████████████░░ 850/1000 XP
  Blue         Yellow (Gradient)
```

**Damage Number Animation:**
```
Floating Number (scale up + fade out)
+500
```

**4. Responsiveness Strategy**

**Mobile (375px+):**
- Single Column Layout
- Bottom Tab Navigation
- Stacked Cards
- Simplified Animations

**Tablet (768px+):**
- 2-Column Split View
- Map + Detail Side-by-Side

**Desktop (1024px+):**
- 3-Column Dashboard
- Sidebar Navigation
- Full Animations

**5. Animation Strategy**

**Using Alpine.js + Tailwind:**

```javascript
// Damage Number Animation
<x-damage-number
  :damage="damageAmount"
  x-transition:enter="transition ease-out duration-500"
  x-transition:enter-start="transform scale-50 opacity-0"
  x-transition:enter-end="transform scale-150 opacity-100"
/>
```

**Performance Considerations:**
- Use CSS Transforms (GPU-accelerated)
- Avoid Layout Thrashing
- Lazy Load World Map Images
- Debounce Sync Updates

---

## 2. Core User Experience (Deep Dive)

### 2.1 Defining Experience

**"Open → See → Understand Immediately"**

MCOP Quest เป็น **Zero-Input Read-Only Dashboard** ที่ถ่ายทอดสถานะโปรเจกต์ผ่าน World Map Metaphor — User แค่เปิดมาและ "เห็นภาพรวมทันที" โดยไม่ต้อง Search, Filter, หรือ Click ไปมา

**Core Statement ที่ User จะบอกเพื่อน:**
> "นี่คือ Dashboard ที่เปิดมาแล้วเห็นว่าโปรเจกต์เราอยู่ตรงไหน — เหมือนดูแผนที่โลกในเกม RPG"

**Defining Interaction:**
- **Tinder:** "Swipe Right to Match"
- **Snapchat:** "Photo Disappears"
- **Spotify:** "Play Any Song Instantly"
- **MCOP Quest:** "Open → See World Map → Understand Project Status"

### 2.2 User Mental Model

**Mental Model ปัจจุบัน (Current Solutions):**

| Tool | User Mental Model | Pain Points |
|------|-------------------|-------------|
| **Google Sheets** | "ตารางข้อมูลที่ต้องค้นหา" | Search, Filter, Scroll ไม่จบ |
| **Jira/Linear** | "List ของ Issues ที่ต้อง Click เข้าไปดู" | ต้อง Click ทีละตัว |
| **Trello** | "Board ของ Cards ที่ Move ไปมา" | ต้อง Drag & Drop |

**Mental Model ใหม่ (MCOP Quest):**
> "โปรเจกต์คือโลกแฟนตาซี — เปิดแผนที่แล้วรู้ว่าอยู่ตรงไหน"

**User Expectations:**
1. **Big Picture First:** "อยากรู้ว่าโปรเจกต์ถึงไหนแล้ว" (World Map)
2. **Drill Down On-Demand:** "ถ้าอยากรู้ละเอียด ค่อย Click" (City → Commander → Minion)
3. **Passive Monitoring:** "ไม่ต้องทำอะไร — แค่ดู" (Zero-Input)

**Current Solutions Analysis:**
- **สิ่งที่ User เกลียด:** Hidden Information, Complex Navigation, Laggy Updates
- **สิ่งที่ User รัก:** Real-time Sync, Visual Feedback, Glanceable Design
- **Workarounds ที่ User ใช้:** Filter แยกหน้า, Screenshot ส่งทีม, Bookmark Dashboard

### 2.3 Success Criteria

**"This Just Works" Criteria:**

| Criterion | Success Indicator | Validation Method |
|-----------|-------------------|-------------------|
| **Instant Understanding** | User รู้ภาพรวมภายใน 5 วินาที | Time-to-Understanding Test |
| **Zero Confusion** | ไม่ต้องอ่าน Help / Manual | First-Time User Walkthrough |
| **Single Glance** | ดูครั้งเดียวแล้วพอ — ไม่ต้อง Refresh | Passive Usage Frequency |
| **Effortless Access** | ไม่เกิน 2 Click/Tap ถึงข้อมูล | Click-Depth Analysis |

**When Do Users Feel "Smart"?**
- เห็น World Map → "โอ้ เราผ่านมา 3 เมืองแล้ว" (Accomplishment)
- เห็น Damage Number → "โค้ดชิ้นนี้โหดมาก" (Impact)
- เห็น Boss HP ลด → "ทีมเราแกร่ง" (Belonging)

**Feedback ที่บอกว่า "ทำถูกทาง":**
- Animation เล่นสวย → "ระบบทำงาน"
- Damage Number เด้ง → "งานสำเร็จ"
- Level Up Animation → "โตขึ้นแล้ว"

**Performance Expectations:**
| Metric | Target | Why |
|--------|--------|-----|
| First Load | < 2s | ไม่ให้เบื่อรอ |
| Sync Update | Real-time / < 30s | ข้อมูลล่าสุด |
| Animation FPS | 60 FPS | Smooth Experience |
| Tap Response | < 100ms | ไม่รู้สึก Lag |

### 2.4 Novel UX Patterns

**Pattern Analysis:**

| Aspect | Pattern Type | Rationale |
|--------|--------------|-----------|
| **Core Metaphor** | **Novel** | World Map สำหรับ Project Dashboard ไม่เคยมี |
| **Navigation** | **Established** | Bottom Tab Bar (Mobile) / Sidebar (Desktop) |
| **Task Access** | **Established** | Card → Detail (2 Taps) |
| **Game Feedback** | **Novel** | Damage Numbers บน Dashboard |
| **Read-Only** | **Novel** | Zero-Input Game Dashboard |

**Novel Pattern 1: World Map as Project Metaphor**

**สิ่งที่ต่าง:**
- ปกติ Dashboard ใช้ Charts / Tables
- MCOP Quest ใช้ "Cities" แทน "Epics" และ "Fog" แทน "Incomplete Requirements"

**การสอน User:**
- **First-Time Onboarding:** "City = Epic ของโปรเจกต์"
- **Visual Metaphor:** เห็นเมืองที่ Clear = เห็น Requirements ชัด
- **Fog of War:** สีเทา = ยังไม่มี Requirements

**Familiar Metaphors:**
- "Boss HP" = ความคืบหน้า Epic
- "Minions" = Tasks ที่ต้องทำ
- "Equipment" = UX/UI Assets

**Novel Pattern 2: Real-Time Game Feedback on Dashboard**

**สิ่งที่ต่าง:**
- ปกติ PM Dashboard ไม่มี Animation / Sound
- MCOP Quest มี Damage Numbers, Boss Death FX

**การสอน User:**
- **Context Clue:** เห็นตัวเลขเด้ง → "Task นี้เสร็จแล้ว"
- **Immediate Gratification:** ไม่ต้องเดา — Visual บอกทุกอย่าง

**Established Pattern: Bottom Tab Bar + Sidebar**

**สิ่งที่ใช้:**
- **Mobile:** Bottom Tab Bar (เหมือน Twitter, Duolingo)
- **Desktop:** Sidebar (เหมือน Notion, Slack)

**สิ่งที่ปรับให้ Unique:**
- Tab Labels: "Hero" | "Team" | "World" | "Shop" (Game Metaphor)
- Icons: Custom RPG Icons ไม่ใช่ Standard UI Icons

### 2.5 Experience Mechanics

**Mechanics Breakdown สำหรับ "Open → See → Understand":**

#### 1. Initiation (เริ่มต้น)

**How User Starts:**
- **Mobile:** Tap App Icon → Splash Screen → World Map
- **Desktop:** Click Bookmark / Type URL → World Map

**Triggers ที่ชวนให้เปิด:**
- **Push Notification:** "Boss HP ลดลง 50%!" (ระวังไม่รบกวน)
- **Email Digest:** "Daily Progress Summary" (Morning Routine)
- **Browser Extension:** "1-Click Open mcop-quest"

**First Impression:**
```
Splash Screen (Loading)
    ↓
World Map Reveals (Animation)
    ↓
User Thinks: "โห้! สวยมาก และเข้าใจทันที"
```

#### 2. Interaction (การโต้ตอบ)

**What User Actually Does:**

| Action | Input | System Response |
|--------|-------|-----------------|
| **Open App** | Tap Icon | Show World Map (0 frictions) |
| **Check Status** | Glance at Map | See Cities, Boss HP, Fog |
| **View Details** | Tap City | Show Commander List |
| **View Task** | Tap Minion | Show Task Detail |
| **Refresh Data** | Pull to Refresh | Sync from Sheets |

**Controls และ Inputs:**
- **Primary:** Tap / Click (Single-touch)
- **Secondary:** Pull to Refresh (Manual Sync)
- **Gesture:** None (Keep it Simple)

**System Response:**
- **Immediate:** Animation เล่นทันที (< 100ms)
- **Feedback:** Visual ชัดเจน (Damage Numbers, HP Updates)
- **Error Handling:** Sync Failed → Show "Last Sync: 5 mins ago"

#### 3. Feedback (การตอบสนอง)

**สิ่งที่บอก User ว่า "ทำถูก":**

| Scenario | Feedback | User Feeling |
|----------|----------|--------------|
| **App Open** | World Map Loads Smoothly | "ระบบทำงาน" |
| **Sync Complete** | "Updated just now" + Icon | "ข้อมูลล่าสุด" |
| **Task Done** | Damage Number เด้ง | "งานนี้เสร็จแล้ว" |
| **Boss Down** | Big Animation + Loot Box | "เราชนะแล้ว!" |
| **Level Up** | Character Grows + Sound | "ฉันโตขึ้น" |

**Error Cases:**
- **Sync Failed:** Show Warning Icon + "Tap to retry"
- **Network Off:** Show "Offline Mode" + Cached Data
- **Data Empty:** Show "No Tasks Yet" + Motivational Message

#### 4. Completion (การจบ)

**How User Knows They're Done:**
- **Passive Usage:** ไม่มี "Done" state — User แค่ Monitor
- **Session End:** User ปิด App เมื่อได้ข้อมูลที่ต้องการ

**Successful Outcome:**
- **Goal Achieved:** User รู้ว่า "โปรเจกต์อยู่ตรงไหน"
- **Time Spent:** < 30 วินาทีต่อ Session (Quick Check)
- **Satisfaction:** "โอเค รู้แล้ว ทำงานต่อ" (Return to Work)

**What's Next:**
- **Immediate:** กลับไปทำงาน (Coding, Requirement, etc.)
- **Later:** กลับมาเปิด mcop-quest อีกครั้ง (Loop)
- **Long-term:** เห็น Progress สะสม (Level Up, Equipment)

**Completion Mechanics:**
```
Quick Check Flow (Most Common):
Open mcop-quest → Glance at Map → Close App (Total: < 30s)

Deep Dive Flow (Sometimes):
Open → Tap City → Tap Commander → Read Minion Detail → Close (Total: < 2m)
```

---

## Visual Design Foundation

### Color System

**Color Philosophy:**
> "Cool & Calm foundation with RPG semantic accents — สร้างความรู้สึกมั่นคง สงบ แต่เต็มไปด้วยชีวิตจาก Game Elements"

**Primary Palette (Cool & Calm):**

| Usage | Color Name | Hex | Tailwind Class | Semantic Meaning |
|-------|-----------|-----|---------------|-----------------|
| **Primary Blue** | Sky Blue | `#3498DB` | `bg-primary` | ความมั่นคง, ความน่าเชื่อถือ, Professional |
| **Success Green** | Emerald | `#2ECC71` | `bg-success` | ความสำเร็จ, ความปลอดภัย, Safe Zone |
| **Teal Accent** | Teal | `#1ABC9C` | `bg-accent` | ความสดใส, ความหลากหลาย, Freshness |
| **Neutral Dark** | Charcoal | `#2C3E50` | `bg-dark` | ความรุนแรง, Serious, Text |
| **Neutral Light** | Silver | `#ECF0F1` | `bg-light` | ความสะอาด, Clean, Background |

**RPG Semantic Colors (จาก Ragnarok/MapleStory):**

| Game Element | Color Name | Hex | Tailwind Class | Usage Context |
|-------------|-----------|-----|---------------|---------------|
| **HP High** | Green | `#2ECC71` | `bg-hp-high` | Boss HP > 50% |
| **HP Medium** | Yellow | `#F1C40F` | `bg-hp-medium` | Boss HP 20-50% |
| **HP Low** | Red | `#E74C3C` | `bg-hp-low` | Boss HP < 20% (Critical!) |
| **XP Bar** | Gold | `#F39C12` | `bg-xp` | Character Progress |
| **Gold Currency** | Bright Gold | `#FFD700` | `text-gold` | Money Display |
| **Gem Currency** | Purple | `#9B59B6` | `text-gem` | Premium Currency |
| **Fog of War** | Gray | `#95A5A6` | `bg-fog` | Incomplete Areas |
| **Grass/Safe** | Forest Green | `#27AE60` | `bg-safe` | Completed Cities |
| **Damage Task** | Orange | `#E67E22` | `bg-damage` | BE/FE Tasks |
| **Support Task** | Blue | `#3498DB` | `bg-support` | BU/UX Tasks |
| **Blocked** | Crimson | `#C0392B` | `bg-blocked` | Equipment Missing |

**Dark Mode Support:**

| Element | Light Mode | Dark Mode |
|---------|-----------|-----------|
| **Background** | `#ECF0F1` (Silver) | `#1A1A2E` (Dark Blue) |
| **Card Background** | `#FFFFFF` (White) | `#16213E` (Dark Slate) |
| **Text Primary** | `#2C3E50` (Charcoal) | `#ECF0F1` (Silver) |
| **Text Secondary** | `#7F8C8D` (Gray) | `#95A5A6` (Light Gray) |
| **Border** | `#BDC3C7` (Light Gray) | `#34495E` (Dark Gray) |

**Accessibility Compliance:**

| Combination | Contrast Ratio | WCAG Level | Status |
|-------------|----------------|------------|--------|
| Primary Blue on White | 4.5:1 | AA | ✅ Pass |
| HP High on White | 4.5:1 | AA | ✅ Pass |
| HP Low on White | 7:1 | AAA | ✅ Pass |
| Gold on Dark | 3:1 | A | ⚠️ Large Text Only |
| Text on Primary Blue | 7:1 | AAA | ✅ Pass |

### Typography System

**Font Strategy:**
> "Classic RPG headings + Modern readable body — สร้างบรรยากาศ Fantasy แต่ยังอ่านง่ายบน Mobile"

**Primary Font (Headings): Cinzel**

```
Font Family: Cinzel (Google Fonts)
Style: Classic Roman Serif
Vibe: Epic, Fantasy, Medieval
Weights: 400 (Regular), 700 (Bold)
```

**Usage:**
- **H1** (32px): Page Titles — "World Map", "Hero Dashboard"
- **H2** (24px): Section Headers — "Your Equipment", "Active Quests"
- **H3** (18px): Card Titles — "Boss Name", "Minion Task"
- **Display** (48px): Epic Complete, Level Up (Special Occasions)

**Secondary Font (Body): Inter**

```
Font Family: Inter (Variable Font)
Style: Modern Sans-serif
Vibe: Clean, Professional, Readable
Weights: 400 (Regular), 500 (Medium), 600 (Semi-bold)
```

**Usage:**
- **Body** (14px): Task descriptions, Requirements, Meta info
- **Caption** (12px): Timestamps, Status labels, Small text
- **Button** (14px, Medium 500): CTAs, Navigation labels

**Type Scale:**

| Level | Size | Line Height | Weight | Font Family | Usage |
|-------|------|-------------|--------|-------------|-------|
| **Display** | 48px | 1.2 | 700 | Cinzel | Level Up, Victory |
| **H1** | 32px | 1.3 | 700 | Cinzel | Page Titles |
| **H2** | 24px | 1.3 | 700 | Cinzel | Section Headers |
| **H3** | 18px | 1.4 | 600 | Inter | Card Titles |
| **Body** | 14px | 1.5 | 400 | Inter | Content |
| **Caption** | 12px | 1.4 | 400 | Inter | Meta info |
| **Button** | 14px | 1.0 | 500 | Inter | CTAs |

**Font Loading Strategy:**

```html
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
```

**Fallback Chain:**
```css
font-family: 'Cinzel', 'Georgia', serif; /* Headings */
font-family: 'Inter', 'Helvetica Neue', sans-serif; /* Body */
```

### Spacing & Layout Foundation

**Spacing Philosophy:**
> "Balanced density — ไม่แน่นเกินไป ไม่ว่างเกินไป เหมาะกับ Dashboard"

**Base Unit: 4px (Tailwind Default)**

**Spacing Scale:**

| Token | Value | Tailwind Class | Usage |
|-------|-------|---------------|-------|
| **xs** | 4px | `p-1` | Icon padding, tight gaps |
| **sm** | 8px | `p-2` | Small gaps, button padding |
| **md** | 12px | `p-3` | Card padding (mobile), element gaps |
| **lg** | 16px | `p-4` | Card padding (default), section spacing |
| **xl** | 20px | `p-5` | Page margin (mobile) |
| **2xl** | 24px | `p-6` | Section gaps, card padding (desktop) |
| **3xl** | 32px | `p-8` | Large sections |
| **4xl** | 40px | `p-10` | Page margin (desktop) |
| **5xl** | 48px | `p-12` | Hero sections |

**Component Spacing Standards:**

| Component | Padding | Margin Between |
|-----------|---------|----------------|
| **Mobile Card** | 16px (all sides) | 12px |
| **Desktop Card** | 24px (all sides) | 16px |
| **Button** | 8px vertical, 16px horizontal | - |
| **Page Header** | 20px (mobile), 40px (desktop) | - |
| **Section Gap** | - | 24px |
| **List Item** | 12px vertical | - |

**Grid System:**

**Mobile (Single Column):**
```
┌─────────────────┐
│   Full Width    │
└─────────────────┘
Columns: 1
Gutter: 0
Margin: 20px
```

**Tablet (2-Column Split):**
```
┌──────────┬──────────┐
│  Map     │ Detail   │
│  (60%)   │ (40%)    │
└──────────┴──────────┘
Columns: 2
Gutter: 16px
Margin: 24px
```

**Desktop (3-Column Dashboard):**
```
┌────┬──────────┬────┐
│Nav │ Content  │Shop│
│    │          │    │
└────┴──────────┴────┘
Columns: 12 (Grid)
- Sidebar: 2 cols
- Main: 8 cols
- Shop: 2 cols
Gutter: 24px
Margin: 40px
```

**Layout Density Strategy:**

| Screen Type | Content Density | Rationale |
|-------------|-----------------|-----------|
| **Mobile** | Airy (More whitespace) | Thumb zone accuracy |
| **Tablet** | Balanced | Presentation mode |
| **Desktop** | Dense (More info) | Passive monitoring |

**Breakpoints:**

| Breakpoint | Min Width | Max Width | Target Device |
|------------|-----------|-----------|---------------|
| **sm** | 640px | - | Large phones, small tablets |
| **md** | 768px | - | Tablets (iPad) |
| **lg** | 1024px | - | Small laptops, large tablets |
| **xl** | 1280px | - | Desktops |
| **2xl** | 1536px | - | Large monitors |

**Z-Index Layers:**

```javascript
// Elevation System
z-index: {
  'base': 0,           // Normal content
  'dropdown': 10,      // Dropdown menus
  'sticky': 20,        // Sticky headers
  'fixed': 30,         // Fixed sidebars
  'modal-backdrop': 40, // Modal backgrounds
  'modal': 50,         // Modal content
  'popover': 60,       // Tooltips, popovers
  'notification': 70,  // Toast notifications
}
```

### Accessibility Considerations

**Mobile-First Accessibility:**

| Requirement | Implementation | Status |
|-------------|----------------|--------|
| **Minimum Tap Target** | 44x44px (iOS), 48x48px (Android) | ✅ Enforced |
| **Minimum Font Size** | 14px body, 12px caption (large enough) | ✅ Enforced |
| **Touch Spacing** | 8px minimum between tap targets | ✅ Enforced |
| **Contrast Ratio** | 4.5:1 minimum (AA compliance) | ✅ Enforced |

**Color Blindness Considerations:**

| Technique | Implementation |
|-----------|----------------|
| **Double Encoding** | Color + Icon for status (e.g., Red + ❌ for blocked) |
| **Pattern** | Fog of War uses texture + gray color |
| **Text Labels** | HP bars show percentage text |

**Visual Hierarchy:**

```
Level 1 (Most Important): Cinzel H1 (32px, Bold)
    ↓
Level 2: Cinzel H2 (24px, Bold)
    ↓
Level 3: Inter H3 (18px, Semi-bold)
    ↓
Level 4: Inter Body (14px, Regular)
    ↓
Level 5: Inter Caption (12px, Regular)
```

**Focus States (Keyboard Navigation):**

```css
/* Tailwind Focus Styles */
.focus-ring:focus {
  outline: 2px solid #3498DB; /* Primary Blue */
  outline-offset: 2px;
  border-radius: 4px;
}
```

**Reduced Motion Support:**

```css
@media (prefers-reduced-motion: reduce) {
  /* Respect user's motion preferences */
  * {
    animation-duration: 0.01ms !important;
    transition-duration: 0.01ms !important;
  }
}
```

**Screen Reader Optimization:**

- **Semantic HTML:** Use `<nav>`, `<main>`, `<article>`, `<section>`
- **ARIA Labels:** Custom RPG icons have `aria-label`
- **Live Regions:** Damage numbers use `aria-live="polite"`
- **Alt Text:** All character/boss images have descriptive alt text

---

## Design Direction Decision

### Design Directions Explored

สำรวจ 6 Design Directions ผ่าน HTML Interactive Showcase ที่ `ux-design-directions.html`:

| Direction | ชื่อ | สไตล์ | ผลการตัดสินใจ |
|-----------|------|--------|------------------|
| **1** | Classic RPG Dashboard | Game UI เต็มรูปแบบ, HP Bars, Damage Numbers | ✅ **เลือกใช้** |
| **2** | Clean Minimal Game | Modern + RPG hints, Card-based | ❌ ไม่เหมาะ — ดูธรรมดาเหมือน Todo List |
| **3** | Map-First Exploration | Interactive World Map, Floating Cards | ✅ **เลือกใช้** |
| **4** | Stats-Heavy Dashboard | Analytics style, Metrics-focused | ❌ ไม่เหมาะ — ดูเหมือน Dashboard ธรรมดา |
| **5** | Character-Centric RPG | Avatar focus, Equipment slots | ✅ **เลือกใช้** |
| **6** | Tactical Map Interface | Strategy game UI, Dark mode | (ไม่ได้ประเมิน) |

**การวิเคราะห์ความชอบ/ไม่ชอบ:**
- **ชอบ:** Direction 1, 3, 5 — มี Heavy RPG Elements, Game UI เต็มรูปแบบ
- **ไม่ชอบ:** Direction 2, 4 — เน้น Minimal/Stats, ดูเป็น Dashboard ธรรมดาไม่ใช่เกม

### Chosen Direction

**Direction 1 + 3 + 5 Hybrid — "Classic RPG Core with Map-First Navigation"**

**หลักการ:**
> "Game First, Dashboard Second" — MCOP Quest ไม่ใช่ Dashboard ที่มี Game elements เป็นแค่ decoration แต่เป็น **Game RPG เต็มตัว** ที่โชว์ Project Status

**สาเหตุผลที่เลือกผสม 3 Directions:**
- แต่ละ Direction มี **Tab/หน้าเด่นของตัวเองแยกกัน** ไม่ซ้ำซ้อน
- สามารถรวมกันได้อย่างลงตัวผ่าน Navigation System

### Design Rationale

**"Game First, Dashboard Second"**

MCOP Quest ถูกออกแบบมาเพื่อเป็น **Game RPG เต็มตัว** ที่มี Dashboard functionality ซ่อนทับอยู่ — ไม่ใช่ในทางกลับ

**หลักการออกแบบหลัก:**

1. **Heavy RPG Elements**
   - HP Bars แสดงความคืบหน้า Boss
   - Damage Numbers เด้งเมื่อ Task เสร็จ
   - Character Avatar แสดง Level, Equipment
   - Level Up animations, Sound effects
   - RPG Icons และ Visual Language

2. **Interactive World Map**
   - Tap เพื่อสำรวจ Cities/Epics
   - Fog of War แสดง Areas ที่ยังไม่มี Requirements
   - Boss HP แสดงความคืบหน้า Epic
   - Path lines เชื่อมโยงระหว่าง Epics

3. **Character Progression**
   - Avatar display พร้อม Equipment slots
   - Level/XP bars แสดงความก้าวหน้า
   - Gold/Gem currencies แสดงผลงาน
   - Stats แสดงความสำเร็จสะสม

4. **Bottom Tab Bar Navigation**
   - **Mobile:** Bottom Tab Bar (Hero | Team | World | Shop)
   - **Desktop:** Sidebar แสดงทุก View พร้อมกัน

**สิ่งที่หลีกเลี่ยงอย่างเด็ดขาด:**
- ❌ Minimal/Stats-only UI — ไม่ใช่ Todo List หรือ Analytics Dashboard
- ❌ Subtle Game Elements — ไม่ใช้ hints แต่เป็น Full Game UI
- ❌ Corporate Dashboard aesthetics — ไม่ใช่ Professional/Minimal style

### Tab Navigation Structure

| Tab | Layout หลัก | Direction ฐาน | หน้าที่ใช้ |
|-----|-------------|----------------|-------------|
| **🏠 Hero** | Character Avatar (5) + Level/XP/Stats (1) | 5 + 1 | Hero Dashboard |
| **👥 Team** | Party View + Team Stats (1) | 1 | Team View |
| **🗺️ World** | Full Interactive Map (3) | 3 | World Map |
| **🛒 Shop** | Currency + Items (1) | 1 | Reward Shop |

**การแบ่งหน้าที่ชัดเจน:**

**Hero Tab (Direction 5 + 1):**
- Character Avatar (large, centered)
- Equipment slots grid
- Level/XP progress bar
- Stats: Gold, Gems, Kills
- Active tasks list

**Team Tab (Direction 1):**
- Party members list
- Team stats/progress
- Team DPS per role
- Contribution visualization

**World Tab (Direction 3):**
- Full-screen interactive World Map
- City nodes with Boss HP
- Fog of War for incomplete areas
- Path lines between cities
- Tap to drill down

**Shop Tab (Direction 1):**
- Currency display (Gold, Gems)
- Items/Cosmetics catalog
- Purchase history
- Equipment upgrades

### Implementation Approach

**Phase 1: Foundation (Direction 1 — Classic RPG)**
```
- HP Bar component
- Damage Number animation
- Stats Grid component
- Bottom Tab Bar navigation
```

**Phase 2: Character System (Direction 5)**
```
- Character Avatar component
- Equipment Grid component
- Level/XP Bar component
- Character Stats display
```

**Phase 3: World Map (Direction 3)**
```
- Interactive World Map component
- City nodes with Boss HP
- Fog of War overlay
- Path lines SVG
- Tap-to-explore interaction
```

**Phase 4: Integration**
```
- Tab navigation system
- Cross-tab state management
- Animation coordination
- Real-time sync handling
```

---

## Component Strategy

### Design System Components

**Available from Tailwind CSS + Alpine.js:**
- Buttons, Cards, Badges (utility classes)
- Navigation components (Tab bars, Sidebars)
- Modals and Tooltips (Alpine.js)
- Basic Progress Bars (foundation for HP/XP)
- Transitions and Animations (Alpine.js)
- Grid/Flexbox layouts
- Dark Mode support (`dark:` prefix)

**Gap Analysis:**
MCOP Quest ต้องการ Custom Components สำหรับ RPG elements ที่ไม่มีใน Standard libraries:
- 6 HP Bars per Commander (Design, AC, API, FE/App, Testing, UAT)
- Commander Card with complex state
- World Map with interactive nodes
- Demon Portal for Bug visualization
- Damage Number animations
- Character Avatar with equipment slots

### Custom Components

#### Commander Card

แสดง Flow (Commander) พร้อม 6 HP Bars ความคืบหน้าแต่ละ Phase

**Anatomy:**
```
┌─────────────────────────────────────┐
│ [Avatar]  Commander Name       [%] │
├─────────────────────────────────────┤
│ 📐 Design    ████████░░░░  80%     │
│ 📋 AC        ████████████ 100% ✓   │
│ ⚙️ API       ██████░░░░░░  60%     │
│ 💻 FE/App    ████░░░░░░░░  40%     │
│ 🧪 Testing   ░░░░░░░░░░░░   0%     │
│ ✅ UAT       ░░░░░░░░░░░░   0%     │
├─────────────────────────────────────┤
│ [Equipment Icons]  🔓 Ready        │
└─────────────────────────────────────┘
```

**States:** default, blocked, in-progress, defeated
**Variants:** compact (mobile), expanded (full), mini (map icon)

**Accessibility:**
- `role="article"` with `aria-label="Commander: [Name]"`
- HP bars have `role="progressbar"` with `aria-valuenow`
- Blocked state announced via `aria-live`

#### HP Bar (6 Types)

แสดงความคืบหน้าของแต่ละ Phase พร้อม Color-coded ตาม Type

| Type | Color | Hex | Icon |
|------|-------|-----|------|
| Design | Orange | `#E67E22` | 📐 |
| AC | Blue | `#3498DB` | 📋 |
| API | Purple | `#9B59B6` | ⚙️ |
| FE/App | Teal | `#1ABC9C` | 💻 |
| Testing | Yellow | `#F1C40F` | 🧪 |
| UAT | Green | `#2ECC71` | ✅ |

**States:** empty (0%), in-progress (1-99%), complete (100%)

#### Minion Card

แสดง Task (Minion) พร้อม Type badge และ Status

**Anatomy:**
```
┌─────────────────────────────────┐
│ [🎨] Wireframe Login Screen    │
│ [UI Task]  [Ton]  [Doing]      │
└─────────────────────────────────┘
```

**Types:** UI (🎨), API (⚙️), FE (💻)
**States:** pending, doing, done, blocked

#### Demon Portal

แสดง Bug Portal — "กองหนุนจากราชาปีศาจ" ที่มาจากประตูมิติ

**Anatomy:**
```
┌─────────────────────────────────┐
│   👹 ประตูมิติปีศาจ            │
│   ~~~~~~~~~~~~                  │
│   [Swirling Portal Animation]   │
│   ~~~~~~~~~~~~                  │
│                                 │
│   ⚠️ กองหนุนจากราชาปีศาจ        │
│   ฆ่าแล้วไม่ได้ XP/Gold/Gem     │
│                                 │
│   [Bug Card 1]                  │
│   [Bug Card 2]                  │
└─────────────────────────────────┘
```

**States:** dormant, active, chaos
**Accessibility:** `aria-label="Demon Portal: [count] active bugs"`

#### World Map

Interactive Map แสดง Overview ของ Project เป็น Fantasy World

**Content:**
- City Nodes (Systems/Epics)
- Path Lines เชื่อม Cities
- Fog of War (incomplete areas)
- Current Battle indicator

**Interaction:** Tap City → Navigate to Commander List

**States:**
- City `completed` — Green glow, checkmark
- City `in-progress` — Yellow glow, battle icon
- City `locked` — Fog overlay, dimmed
- City `next` — Pulsing indicator

#### Character Avatar

Chibi Avatar พร้อม 6 Equipment Slots และ Class indicator

**Anatomy:**
```
┌─────────────────────┐
│     [Head Slot]     │
│  [L.Hand][Body][R.Hand]  │
│     [Leg Slot]      │
│     [Foot Slot]     │
│                     │
│   ⚔️ Warrior Lv.15   │
└─────────────────────┘
```

**Classes:** Warrior (Dev), Scout (BA/QA), Blacksmith (UX), Guildmaster (PM)

#### XP Bar & Damage Number

**XP Bar:**
```
Lv.15 ████████████░░░░ 850/1000 XP
```
**States:** normal, gaining (animated), level-up (celebration)

**Damage Number:**
- Float up + fade animation
- Variants: normal (yellow), critical (red + "CRIT!"), support (blue + "BUFF")
- Animation: `scale-50 → scale-150 → scale-100`, `opacity: 0 → 1 → 0`, `translate-y: 0 → -50px`

### Component Implementation Strategy

**Build Approach:**

| Component | Technology | Rationale |
|-----------|------------|-----------|
| HP Bar | Blade Component | Simple, reusable, no complex state |
| Minion Card | Blade Component | Reusable, simple state |
| XP Bar | Blade Component | Animated progress display |
| Commander Card | Livewire Component | Real-time sync, complex state |
| Demon Portal | Livewire Component | Animation + dynamic content |
| World Map | Livewire + Alpine.js | Interactive, real-time updates |
| Character Avatar | Blade Component | SVG + Equipment slots |
| Damage Number | Alpine.js only | Pure animation, no server state |

**Component Architecture:**
```
resources/views/
├── components/                    # Blade Components
│   ├── game/
│   │   ├── hp-bar.blade.php       # Single HP Bar
│   │   ├── minion-card.blade.php
│   │   ├── xp-bar.blade.php
│   │   ├── damage-number.blade.php
│   │   └── character-avatar.blade.php
│   └── ui/
│       ├── bottom-tab-bar.blade.php
│       └── currency-display.blade.php
├── livewire/
│   ├── components/                # Livewire Components
│   │   ├── commander-card.blade.php
│   │   ├── demon-portal.blade.php
│   │   └── city-node.blade.php
│   └── pages/
│       ├── world-map.blade.php
│       ├── hero-dashboard.blade.php
│       ├── team-view.blade.php
│       └── shop.blade.php
```

### Implementation Roadmap

**Phase 1 — Core Components (Critical Path):**

| Component | Needed For | Priority |
|-----------|-----------|----------|
| HP Bar | Commander Card, All Views | 🔴 P0 |
| Commander Card | City Detail, Team View | 🔴 P0 |
| City Node | World Map | 🔴 P0 |
| World Map | Main Navigation | 🔴 P0 |
| Bottom Tab Bar | Navigation | 🔴 P0 |

**Phase 2 — Battle System Components:**

| Component | Needed For | Priority |
|-----------|-----------|----------|
| Minion Card | Commander Detail | 🟠 P1 |
| Demon Portal | Guildmaster View | 🟠 P1 |
| Damage Number | Feedback Animation | 🟠 P1 |
| XP Bar | Hero Dashboard | 🟠 P1 |

**Phase 3 — Character & Enhancement:**

| Component | Needed For | Priority |
|-----------|-----------|----------|
| Character Avatar | Hero Dashboard | 🟡 P2 |
| Equipment Grid | Hero Dashboard | 🟡 P2 |
| Currency Display | Shop, Hero Dashboard | 🟡 P2 |
| Level Up Animation | Celebration | 🟡 P2 |
| Boss Defeated Animation | Victory Moment | 🟡 P2 |

---

## UX Consistency Patterns

### Navigation Patterns

**Tab Bar (Mobile):**

| Tab | Icon | Label | Active State |
|-----|------|-------|--------------|
| Hero | ⚔️ | Hero | Gold underline + Icon fill |
| Team | 👥 | Team | Gold underline + Icon fill |
| World | 🗺️ | World | Gold underline + Icon fill |
| Shop | 🛒 | Shop | Gold underline + Icon fill |

**Behavior:**
- Single tap → Switch view
- Active tab → Scroll to top (if already on tab)
- Badge indicator สำหรับ notifications

**Accessibility:**
- `role="tablist"` สำหรับ container
- `role="tab"` สำหรับแต่ละ tab
- `aria-selected="true"` สำหรับ active tab
- Tab ด้วย Keyboard → Arrow keys

**Drill-Down Navigation:**
```
World Map → City → Commander → Minions
```

**Breadcrumb Pattern:**
```
🗺️ World > 🏰 ระบบสมาชิก > ⚔️ Flow: Login
```

**Sidebar (Desktop):**
- Persistent left sidebar
- States: default, hover (highlight), active (gold accent)

### Feedback Patterns

**Game Event Feedback:**

| Event | Visual | Duration |
|-------|--------|----------|
| Task Done | Damage Number (+50) | 800ms |
| HP Update | Bar fill animation | 500ms |
| Commander Defeated | Explosion + Confetti | 1500ms |
| Level Up | Flash + Badge | 2000ms |
| Sync Complete | ✅ pulse | 300ms |
| Demon Portal | Swirl animation | 1000ms |

**Sync Status:**

| Status | Visual | Location |
|--------|--------|----------|
| Syncing | 🔄 Spinning icon | Header/Footer |
| Synced | "Updated 30s ago" | Footer |
| Stale (>5 min) | ⚠️ Warning badge | Header |
| Offline | 📴 Offline banner | Top of screen |

**Notification Toast:**

| Type | Color | Icon | Dismiss |
|------|-------|------|---------|
| Success | Green `#2ECC71` | ✅ | Auto 3s |
| Warning | Yellow `#F1C40F` | ⚠️ | Auto 5s |
| Error | Red `#E74C3C` | ❌ | Manual |
| Info | Blue `#3498DB` | ℹ️ | Auto 3s |

**Position:** Bottom center (mobile), Top right (desktop)

**Damage Number Animation:**
```css
0%:   scale(0.5), opacity(0), translateY(0)
50%:  scale(1.5), opacity(1), translateY(-20px)
100%: scale(1.0), opacity(0), translateY(-50px)
Duration: 800ms, Easing: ease-out
```

**Variants:**
- Normal: Yellow `#F1C40F`, "+50"
- Critical: Red `#E74C3C`, larger, "CRIT! +100"
- Support: Blue `#3498DB`, "BUFF ✨"

### State Patterns

**Loading States:**

| Context | Pattern | Timing |
|---------|---------|--------|
| Page Load | Skeleton UI | Show after 300ms |
| Component Load | Spinner inside card | Immediate |
| World Map | Fog shimmer effect | Continuous |
| Data Refresh | Subtle pulse | During sync |

**Empty States:**

| Context | Visual | Message |
|---------|--------|---------|
| No Tasks | Sleeping character | "ไม่มี Minion ให้ต่อสู้ — พักผ่อนก่อนนะ" |
| No Cities | Empty map + compass | "ยังไม่มี City — รอข้อมูลจาก Sheets" |
| No Team | Campfire alone | "ยังไม่มีเพื่อนร่วมทีม" |
| Shop Empty | Merchant shrugging | "สินค้าหมดชั่วคราว" |

**Pattern:** Character illustration + Friendly message + (Optional) Action hint

**Error States:**

| Type | Visual | Recovery |
|------|--------|----------|
| Network Error | Cloud with X | "ลองใหม่" button |
| Sync Failed | Warning triangle | Auto-retry + Manual retry |
| Data Missing | Question mark | Contact admin |
| Permission Denied | Lock icon | Login redirect |

**Offline Mode:**
- Show cached data
- Disable "real-time" features
- Stale indicator on all HP bars
- Auto-reconnect when online

### Game-Specific Patterns

**HP Bar Update:**
```
Before: ████████░░░░ 60%
After:  ██████████░░ 80%
Animation: Fill from left, 500ms ease-out
```

**Threshold Colors:**
- 100%: Green `#2ECC71` ✓
- 50-99%: Yellow `#F1C40F`
- 1-49%: Orange `#E67E22`
- 0%: Gray `#95A5A6`

**Commander Defeated Sequence:**
1. All 6 HP Bars = 100%
2. Screen shake (subtle)
3. Commander card glows
4. "DEFEATED!" banner
5. Confetti particles
6. Loot box drop
7. XP/Gold reward display
- Duration: 2000ms total

**Demon Portal Pattern:**
1. Bug detected in Sheets
2. Portal swirl animation starts
3. Red glow around affected City
4. 👹 icon on Commander card
5. Telegram notification sent

**Level Up Sequence:**
1. XP Bar fills to 100%
2. Screen flash (gold)
3. "LEVEL UP!" text scales
4. Character celebrates
5. New level badge
6. Stats update +1

### Button Patterns (Minimal - Read-Only App)

| Type | Usage | Style |
|------|-------|-------|
| Primary | "ดูรายละเอียด" | Gold bg, Dark text |
| Secondary | "ปิด", "ย้อนกลับ" | Gold border, Transparent |
| Ghost | Nav links | Text only, underline hover |
| Danger | "ออกจากระบบ" | Red bg (rare) |

**States:**
- `default` — Normal
- `hover` — Brightness +10%, shadow
- `active` — Scale 0.98, darker
- `disabled` — Opacity 50%, no pointer

---

## Responsive Design & Accessibility

### Responsive Strategy

**Mobile-First Approach:**

MCOP Quest ใช้ Mobile-First Strategy เพราะ Use Case หลักคือ Dev เช็คสถานะระหว่างทำงาน/เดินทาง

| Device | Width | Layout | Navigation |
|--------|-------|--------|------------|
| **Mobile** | 375px+ | Single column, stacked | Bottom Tab Bar |
| **Tablet** | 768px+ | 2-Column (60/40) | Side Tab Rail |
| **Desktop** | 1024px+ | 3-Column Dashboard | Persistent Sidebar |

**Mobile (375px+):**
- Bottom Tab Bar (Hero/Team/World/Shop)
- HP Bars collapsed by default, tap to expand
- Touch targets 48x48px minimum
- Progressive disclosure for content

**Tablet (768px+):**
- 2-Column Split: Map (60%) + Detail (40%)
- Side Tab Rail navigation
- Presentation Mode สำหรับ PM

**Desktop (1024px+):**
- 3-Column: Sidebar (200px) + Main + Shop Panel (240px)
- Persistent left sidebar
- Monitor Mode (passive viewing)

### Breakpoint Strategy

**Tailwind CSS Breakpoints (Standard):**

| Breakpoint | Min Width | Usage |
|------------|-----------|-------|
| `default` | 0px | Base mobile styles |
| `sm` | 640px | Large phones |
| `md` | 768px | Tablets |
| `lg` | 1024px | Small laptops |
| `xl` | 1280px | Desktops |
| `2xl` | 1536px | Large monitors |

**Implementation:**
```css
/* Mobile-first approach */
.commander-card { /* Base styles */ }

@screen md { .commander-card { /* Tablet */ } }
@screen lg { .commander-card { /* Desktop */ } }
```

### Accessibility Strategy

**Target: WCAG 2.1 Level AA**

| Requirement | Implementation | Status |
|-------------|----------------|--------|
| **Color Contrast** | 4.5:1 (normal), 3:1 (large) | ✅ |
| **Touch Targets** | 48x48px minimum | ✅ |
| **Keyboard Navigation** | Full tab support | ✅ |
| **Screen Reader** | ARIA labels on all components | ✅ |
| **Reduced Motion** | Respect `prefers-reduced-motion` | ✅ |

**Color Blindness Support:**
- Double Encoding: Color + Icon (e.g., Red + ❌ for blocked)
- HP Bars show percentage text, not just color
- All status have text labels

**Keyboard Navigation:**

| Key | Action |
|-----|--------|
| Arrow Left/Right | Navigate tabs |
| Enter/Space | Activate/Select |
| Arrow Up/Down | Navigate cards |
| Escape | Close modal |
| Tab | Skip navigation |

**Screen Reader Support:**

| Component | ARIA Implementation |
|-----------|-------------------|
| Tab Bar | `role="tablist"`, `role="tab"` |
| HP Bar | `role="progressbar"`, `aria-valuenow` |
| Commander Card | `role="article"`, `aria-label` |
| Notifications | `aria-live="polite"` |
| Damage Number | `aria-live="assertive"` |

**Focus States:**
```css
:focus-visible {
  outline: 2px solid #3498DB;
  outline-offset: 2px;
  border-radius: 4px;
}
```

**Reduced Motion:**
```css
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    transition-duration: 0.01ms !important;
  }
}
```

### Testing Strategy

**Responsive Testing:**

| Test Type | Tools | Frequency |
|-----------|-------|-----------|
| Browser DevTools | Chrome/Firefox | Every PR |
| Physical Devices | iPhone SE, iPad, Desktop | Weekly |
| Cross-Browser | BrowserStack | Pre-release |

**Target Devices:**
- iPhone SE (375px) — Minimum
- iPhone 14 (390px) — Common
- iPad (768px) — Tablet
- MacBook (1280px) — Laptop
- 27" Monitor (2560px) — Desktop

**Accessibility Testing:**

| Test Type | Tools | Target |
|-----------|-------|--------|
| Automated | axe DevTools, Lighthouse | Score > 90 |
| Screen Reader | VoiceOver | Full navigation |
| Keyboard | Manual | All interactive elements |
| Color | WebAIM Contrast Checker | 4.5:1 ratio |

### Implementation Guidelines

**Responsive Development:**
- Use relative units (rem, %, vw)
- Mobile-first media queries
- Test touch targets (48x48px)
- Optimize images with srcset

**Accessibility Development:**
- Semantic HTML (`<nav>`, `<main>`, `<article>`)
- ARIA labels on custom components
- Skip link to main content
- Focus management for modals
- High contrast mode support

**Code Example:**
```html
<!-- Accessible HP Bar -->
<div role="progressbar"
     aria-label="Design progress"
     aria-valuenow="80"
     aria-valuemin="0"
     aria-valuemax="100">
  <span class="sr-only">Design: 80% complete</span>
  <div class="fill" style="width: 80%"></div>
</div>
```

---
