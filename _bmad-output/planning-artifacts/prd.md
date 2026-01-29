c---
stepsCompleted:
  - step-01-init
  - step-02-discovery
  - step-03-success
  - step-04-journeys
  - step-05-domain
  - step-06-innovation
  - step-07-project-type
  - step-08-scoping
  - step-09-functional
  - step-10-nonfunctional
  - step-11-polish
inputDocuments:
  - product-brief-mcop-quest-2026-01-28.md
  - mcop_quest_system_rules_formulas_v_0.md
  - mcop_quest_wireframe_definition_v_0.md
  - prd_mcop_quest_gamification_dashboard.md
workflowType: 'prd'
classification:
  projectType: Web Application / Dashboard
  domain: Enterprise Productivity / Gamification
  complexity: Medium
  projectContext: Greenfield
---

# Product Requirements Document - mcop-quest

**Author:** Master
**Date:** 2026-01-28

## Success Criteria

### User Success

*   **Daily Bond (Login Rate):** 80% ของทีมงาน Login เข้ามาดู Hero Dashboard หรือ World Map อย่างน้อยวันละ 1 ครั้ง
*   **Instant Gratification (Lag Time):** ระยะเวลาเฉลี่ยจากงานเสร็จจริง (Code Merged) ถึงเวลาอัปเดตสถานะในเกม ต้อง **< 2 ชั่วโมง**
*   **Scout Value:** ทีม Dev เข้ามาอ่าน Detail/Criteria ใน Task Card **ก่อน** เริ่มทำงาน (วัดจาก View Count/Click Rate)

### Business Success

*   **Visibility:** ลดเวลาที่ใช้ในการทำรายงานสถานะโปรเจกต์ (Status Report) ลง 50%
*   **Map Quality:** 90% ของ Epic/Flow มี Requirement ครบถ้วน (Map Revealed) ก่อนเข้า Sprint
*   **Morale:** ทีมเห็นความก้าวหน้าสม่ำเสมอ ลดความรู้สึก "ทำงานฟรี"

### Technical Success

*   **Stability:** Sync Engine ทำงานถูกต้อง 100% ข้อมูลในเกมตรงกับ Sheet เสมอ (Single Source of Truth)

### Measurable Outcomes

*   **Fog Cleared:** > 95% ของ Tasks มีคำอธิบายและ AC ครบถ้วน
*   **Damage Velocity:** อัตราการลด HP ของบอสมีความสม่ำเสมอต่อ Sprint
*   **Respawn Rate:** < 10% (จำนวน Task ใหม่ที่ถูกสร้างทดแทน Task เดิมที่ทำผิดเพราะ Req ไม่ชัด)

## Product Scope

### MVP - Minimum Viable Product

*   **Core Logic:**
    *   **Sync Engine (One-Way):** ระบบดึงข้อมูลจาก Google Sheets อัตโนมัติ (Read-only) ห้ามมีการแก้ไขข้อมูล Task ในเกม เด็ดขาด - ไม่มี Manual Sync Button (Auto-Sync ทุก 1 นาที)
    *   **Entity Mapping:**
        - System → City (เมือง)
        - Flow → Commander (หัวหน้าหน่วย) - **มี 6 HP Bars: Design, AC, API, FE/App, Testing, UAT**
        - Task → Minion (สมุน) - **แยก 3 ประเภท: UI-tasks, API-tasks, FE-tasks**
        - Bug → **Demon Reinforcements (กองหนุนจากราชาปีศาจ)** - มาจากประตูมิติ, ไม่รู้จำนวน/เวลา, ฆ่าแล้วไม่ได้ reward
*   **Visualization:**
    *   **Tri-View:** Hero Task Board (รายคน), World Map (ภาพรวม), Scout/Team Camp (ปาร์ตี้)
    *   **Fog of War:** แสดง Effect หมอกบังพื้นที่ Epic ที่ Req ไม่ครบ
*   **Gamification:**
    *   HP บอสลดลงตาม Task ที่ Done
    *   Role System: Warrior/Mage (Dev), Scout (BA), Blacksmith (UX)

### Growth Features (Post-MVP)

*   **Two-Way Sync:** เขียนข้อมูลกลับไปยัง Google Sheets
*   **Start-Stop Timer:** ระบบจับเวลาทำงานจริง
*   **Mobile Support:** ปรับปรุง Responsive ให้ดียิ่งขึ้น

### Vision (Future)

*   **Guild War:** ระบบแข่งกันระหว่างทีมย่อย
*   **Boss Raid Event:** อีเวนต์พิเศษที่ต้องรุมตีพร้อมกันในเวลาจำกัด (Release Day)
*   **Marketplace:** ระบบแลกเปลี่ยน Item ระหว่างผู้เล่น

## User Journeys

### 1. Journey of "Warrior Ken" (Backend Developer)
*   **Persona:** Ken, Senior Backend Dev ผู้เบื่อหน่ายกับการกรอก Google Sheets ตอนสิ้นวัน
*   **Goal:** อยากเห็นผลงานของตัวเองมีความหมาย เมื่อทำงานเสร็จแล้วอยากเห็นผลกระทบทันที
*   **Opening Scene:** Ken ทำงาน Coding ฟีเจอร์ "User Auth" เสร็จตอน 17:30 น. เขาเปิด Google Sheets → API-tasks tab → เปลี่ยน Status เป็น "6 - Done" แล้วปิด Sheets กลับไปทำงานต่อ
*   **Rising Action (Auto-Sync):** ระบบ MCOP Quest ดึงข้อมูลอัตโนมัติทุก 1 นาที Ken เปิด MCOP Quest บนมือถือ → เห็น World Map → คลิกเข้า City "ระบบสมาชิก" → เห็น Commander "Flow: Login" มี **6 HP Bars** โดย API HP Bar เพิ่มขึ้นจากงานที่เขาเพิ่งทำเสร็จ
*   **Climax (The Hit):** Animation แสดง Damage Number เด้งขึ้น "+50 DMG" ที่ Commander! **API HP Bar** เต็ม 100% แล้ว → Commander รอแค่ FE/Testing/UAT Ken เห็นว่างานเขามีผลจริง ได้ Gold +50, XP +100
*   **Resolution:** Ken ยิ้มมุมปาก รู้สึกว่าวันนี้เขามีส่วนในการ Clear Commander เขาแชร์ Screenshot หน้าจอไปใน Telegram กลุ่มทีมว่า "API Done! รอ FE แล้วไป Testing!" ก่อนปิดคอมกลับบ้านด้วยความฟิน

### 2. Journey of "Scout Sarah" (Business Analyst)
*   **Persona:** Sarah, BA ผู้ต้องรับแรงกดดันจากลูกค้าและต้องแปล Req ให้ทีมเข้าใจ
*   **Goal:** ต้องการให้ทีมเห็นภาพ Requirement ชัดเจนก่อนเริ่มงาน และไม่อยากตอบคำถามซ้ำๆ
*   **Opening Scene:** เช้าวันจันทร์ Sarah เปิด MCOP Quest → World Map → ดูพื้นที่ "City: Payment Gateway" ที่กำลังจะเข้า Sprint หน้า เธอเห็นพื้นที่นั้นปกคลุมด้วย **Fog of War** (หมอกหนาทึบ) แสดงว่า Req ยังไม่พร้อม → เห็น Commander หลายตัวมี **AC HP Bar** ยังแดงอยู่
*   **Rising Action (The Clearing):** Sarah รีบเปิด Google Sheets → Flows tab → เติม AC column และ Definition of Done ที่ขาดไป → กด Save
*   **Climax (Map Revealed - Auto-Sync 1 min):** ภายใน 1 นาที หน้าจอ MCOP Quest อัพเดทอัตโนมัติ Effect ลมพัดหมอกจางหายไป Commander แสดง **AC HP Bar** เป็นสีเขียว พร้อมขึ้น status "Ready for Battle" → ทีมเห็น Pipeline ชัดเจน (Design ✓ → AC ✓ → รอ API)
*   **Resolution:** ทีม Dev เดินมาดูจอแล้วบอกว่า "โห Payment มี Commander 3 ตัวเลยเหรอ ดีนะเห็นก่อน จะได้เตรียมอาวุธถูก" Sarah ถอนหายใจโล่งอกที่ทีมเห็นภาพเดียวกัน → Telegram แจ้ง "Payment City Fog Cleared!"

### 3. Journey of "Blacksmith Ton" (UX Designer)
*   **Persona:** Ton, UX Designer ผู้สร้าง Asset และ Flow หน้าจอ
*   **Goal:** ต้องการส่งมอบ Design Asset ให้ Dev โดยไม่หลุดธีม และอยากรู้สึกเป็นส่วนหนึ่งของการต่อสู้
*   **Opening Scene:** Ton ออกแบบหน้าจอ Login เสร็จแล้ว แต่รู้สึกว่าถ้าเป็นแค่ไฟล์ Figma วางแปะไว้ Dev อาจจะงง
*   **Rising Action (Crafting):** Ton เปิด Google Sheets → UI-tasks tab → หา Task ที่ Assign ให้ตัวเอง → Paste Figma Link ในช่อง Description → เปลี่ยน Status เป็น "6 - Done"
*   **Climax (Weapon Forged - Auto-Sync 1 min):** ภายใน 1 นาที MCOP Quest อัพเดทอัตโนมัติ → Commander "Flow: Login" แสดง **Design HP Bar** เต็ม 100% → Telegram แจ้ง Ken ว่า "Equipment Ready! Design for Login is complete" → Ken เปิด Task ใน MCOP Quest เห็นไอคอน "ดาบติดไฟ" (Design Ready) พร้อม Link ไป Figma
*   **Resolution:** Ton รู้สึกว่างาน Design ของเขาคืออาวุธสำคัญที่ช่วยให้เพื่อนตีบอสเข้า ไม่ใช่แค่รูปวาดสวยๆ → เห็น **Design HP Bar** ขึ้นทุกครั้งที่ทำ task เสร็จ

### 4. Journey of "Guild Master Om" (Project Manager/Admin)
*   **Persona:** Om, PM ผู้ต้องคอยตอบคำถามผู้บริหารว่า "โปรเจกต์ถึงไหนแล้ว"
*   **Goal:** ต้องการข้อมูลสรุปที่ดูง่าย เพื่อนำไป Present ผู้บริหารโดยไม่ต้องทำ Slide ใหม่
*   **Opening Scene:** ผู้บริหารเดินมาถามหน้างานว่า "Payment Gateway จะเสร็จทันสิ้นเดือนไหม?"
*   **Rising Action (The Oracle View):** แทนที่จะเปิด Excel ตาลาย Om เปิด MCOP Quest บน iPad โชว์หน้า **World Map** ให้ผู้บริหารดู → ข้อมูล Fresh เพราะ Auto-Sync ทุก 1 นาที
*   **Climax (6 HP Bars):** Om คลิกเข้า Payment City → เห็น Commander Cards แต่ละตัวมี **6 HP Bars** → ชี้ให้ผู้บริหารดู "Flow: Login ตอนนี้ Design ✓ AC ✓ API 80% FE 50% Testing 0% UAT 0% — รอ FE อีก 2 Tasks แล้วไป Testing ครับ" → เห็นว่า Commander 2 ตัวมี **Demon Portal** (Bug) อยู่ 3 ตัวที่ต้องจัดการ
*   **Resolution:** ผู้บริหารพยักหน้าเข้าใจทันที "อ๋อ เห็นภาพเลย เห็น Pipeline ชัดเจน งั้นลุยต่อ" Om รอดตายจากการทำ Report ด่วน

### Journey Requirements Summary

1.  **Immersive Feedback System:** ต้องมี Animation, Sound Effect, และ Visual Feedback ที่ตอบสนองทันที (สำหรับ Ken)
2.  **Smart Sync & Trigger:** ระบบต้อง Detect การเปลี่ยนแปลงใน Sheet แล้วอัปเดต Fog of War ทันที (สำหรับ Sarah)
3.  **Asset Management Integration:** ช่องทางแนบ Link/File ที่สื่อสารว่าเป็น "Item ช่วยเหลือ" ไม่ใช่แค่ Link ธรรมดา (สำหรับ Ton)
4.  **Presentation Mode:** หน้า World Map ต้องสวยและ Clean พอที่จะโชว์ Stakeholder ได้เลยโดยไม่ต้องจัดหน้าใหม่ (สำหรับ Om)

## Domain-Specific Requirements

### Psychological Safety & Ethics (Gamification Code of Conduct)
*   **No Shame Mechanics:** ห้ามมี Leaderboard ที่ประจานคนรั้งท้าย หรือแสดงข้อมูลเชิงลบรายบุคคลในที่สาธารณะ
*   **Opt-in Privacy:** ผู้ใช้สามารถเลือกซ่อน Status บางอย่างที่ไม่เกี่ยวกับเวลางานหลักได้ (ถ้ามีในอนาคต)
*   **Collaborative > Competitive:** เน้นการร่วมมือกันตีบอส (Co-op) มากกว่าการแข่งกันเอง (PvP) เพื่อลดความขัดแย้งในทีม

### Technical Constraints & Security
*   **Read-Only Integration (MVP):** ระบบต้องขอสิทธิ์ Google Sheets เพียงแค่ `drive.file` หรือ `spreadsheets.readonly` เท่านั้น เพื่อป้องกันอุบัติเหตุข้อมูลหาย
*   **Access Control:** ผู้มีสิทธิ์เข้าถึง Dashboard ต้องเป็น Email ภายใต้ Domain องค์กรเท่านั้น

### Integration Integrity
*   **Sync Reliability:** หาก Sync หลุดหรือข้อมูลไม่ตรง ต้องมีการแจ้งเตือน Admin ทันที (Alert System)
*   **Data Structure Resilience:** ระบบต้องทนทานต่อการเปลี่ยนชื่อ Column หรือการย้าย Tab ใน Sheet เล็กน้อยได้ โดยไม่ Crash

### Risks & Mitigations
*   **Risk:** พนักงาน "ปั๊มเวล" โดยการซอย Task ถี่ๆ เพื่อเอา XP
    *   **Mitigation:** กำหนดให้ XP คำนวณตาม Story Points หรือ Difficulty Level ที่ตกลงกันใน Sprint Planning ไม่ใช่จำนวน Task
*   **Risk:** Google Sheets API Rate Limit เต็ม
    *   **Mitigation:** ใช้ Caching Layer หรือตั้งเวลา Sync เป็น Interval (เช่น ทุก 15 นาที) แทน Real-time 100%

## Innovation & Novel Patterns

### Detected Innovation Areas

*   **Semantic Gamification Mapping:** ไม่ใช่แค่การแปะ Points/Badges แต่เป็นการ *แปลงสภาพ (Transmute)* งานเอกสารที่น่าเบื่อให้เป็นบริบท RPG ที่สมบูรณ์ (Ex: System -> City, Epic -> Boss, Task -> Minion) ทำให้เกิด "Immersion" ในการทำงาน
*   **Tangible "Fog of War":** การ Visualize ปัญหา abstract อย่าง "Incomplete Requirements" ให้กลายเป็นอุปสรรคทางกายภาพในเกม (หมอก) ทำให้ทีม Business เห็นผลกระทบของการไม่เคลียร์ Req ทันทีโดยไม่ต้องอธิบาย
*   **Cross-Role Inclusion:** ให้ความสำคัญกับ Non-Coder Roles (BA เป็น Scout, UX เป็น Blacksmith) ในฐานะ Class อาชีพที่จำเป็นต่อการ Raid บอส แก้ปัญหาความรู้สึก "คนละทีม" ระหว่าง Tech กับ Business

### Market Context & Competitive Landscape

*   **Current State:** เครื่องมือ Gamification ส่วนใหญ่ (Habitatica, Jira plugins) เน้นที่ Individual Habit หรือแค่ Leaderboard ธรรมดา ขาดการเชื่อมโยงกับ "เนื้องานจริง" ในระดับโครงสร้างโปรเจกต์
*   **Differentiation:** MCOP Quest เชื่อมโยง Logical Structure ของ Software Project เข้ากับ Game World Structure ทำให้ "การทำงานคือการเดินเกม" ไม่ใช่แค่ทำงานเพื่อแลกแต้ม

### Validation Approach

*   **Psychological A/B Test:** สังเกตพฤติกรรมการอัปเดตงาน เปรียบเทียบระหว่างช่วงใช้ Sheet (ก่อนหน้า) กับช่วงใช้ Quest ว่าความถี่ (Frequency) และความเร็ว (Lag Time) ในการอัปเดตเปลี่ยนไปหรือไม่
*   **"Fog Clearing" Rate:** วัดเวลาเฉลี่ยที่พื้นที่สีเทา (Unclear Req) หายไปหลังจากระบบแจ้งเตือนด้วย Fog of War

### Risk Mitigation

*   **Gimmick Fatigue:** นวัตกรรมอาจจะตื่นเต้นแค่ช่วงแรก
    *   *Mitigation:* ออกแบบ Season Update และ Event พิเศษ (Boss Raid) เพื่อดึงความสนใจกลับมาเป็นระยะ

## Web/SaaS Specific Requirements

### Project-Type Overview
**MCOP Quest** เป็น Internal Web Application (Single Tenant) ที่เน้นการแสดงผล Dashboard และ Gamification สำหรับทีมภายในองค์กร

### Technical Architecture Considerations
*   **Backend:** Laravel 10+ (ใช้ PHP 8.2+) ตามมาตรฐานองค์กร
*   **Frontend Logic:** Livewire 3 (เพื่อความรวดเร็วในการพัฒนาและ SEO Friendly)
*   **Game Engine (Frontend):** **Phaser.js** หรือ **Excalibur.js** สำหรับส่วน World Map และ Battle Scene เพื่อรองรับ Animation และ Interactive ที่ซับซ้อน (แยก Micro-frontend ในจุดที่ต้องใช้กราฟิกหนัก)
*   **Database:** MySQL 8.0 / MariaDB (เน้น Relational Data สำหรับ Game Logic)
*   **Hosting:** Deploy บน Internal Server หรือ Cloud (ระบุภายหลัง)

### Tenant Model
*   **Single-Tenant (Internal Use Only):** ระบบออกแบบมาเพื่อใช้ภายใน MCOP Team เท่านั้น ไม่รองรับการขายเป็น SaaS ให้คนนอกในเฟสนี้
*   **Multi-Branch Capability:** รองรับการขยายให้ Team ย่อยอื่นๆ (Guilds) ในอนาคต โดยใช้ Database ก้อนเดียวกันแต่แยก Guild ID

### Permission Model (RBAC)
| Role | Access Level |
| :--- | :--- |
| **Admin (Guild Master)** | Full Access + Config System + Manage Users |
| **Scout (BA/PO)** | Create/Edit Quests + View All Maps + Fog Control |
| **Warrior/Mage (Dev)** | View Maps + Update Task Status (Own Tasks) + Claim Rewards |
| **Blacksmith (UX)** | View Maps + Upload Assets + Update Design Tasks |
| **Guest (Observer)** | View World Map Only (Presentation Mode) |

### Integration Requirements
1.  **Google Sheets Integration (Core):**
    *   Read-only access via Google Drive API / Sheets API
    *   Trigger: Manual Sync Button & Scheduled Job (every 15 mins)
2.  **Telegram Notification (Secondary):**
    *   แจ้งเตือนเมื่อ Commander Down (Flow Completed - 6 HP Bars = 100%)
    *   แจ้งเตือนเมื่อ Fog Cleared (New Req Ready)
    *   แจ้งเตือนเมื่อ Demon Portal Opened (Bug ใหม่)

### Platform & Device Support
*   **Mobile First Strategy:** ออกแบบ UI/UX ให้ใช้งานบนมือถือเป็นหลัก (Responsive Web) เพื่อให้ Dev/Admin เช็คสถานะหรือกดตีบอสระหว่างเดินทางได้สะดวก
*   **Desktop:** ขยาย Layout เมื่อเปิดบนจอใหญ่ให้เห็น World Map กว้างขึ้นเสมือน Game Console

## Project Scoping & Phased Development

### MVP Strategy & Philosophy
**MVP Approach:** **"Engagement-First MVP"**
เน้นการใช้งานจริงที่ "สนุก" กว่าเดิม (Better UX than Sheets) ภายใต้ข้อจำกัดทางเทคนิคที่ยั่งยืน (Sustainable Tech Stack)

**Key Decisions:**
*   **Tech Stack:** Laravel + Livewire + Alpine.js (No Phaser.js) เพื่อความรวดเร็วและดูแลง่าย
*   **Data Flow:** One-Way Sync from Sheets (Read-only) + Local DB for Game Items

### MVP Feature Set (Phase 1: The Awakening)
**Target:** ใช้งานภายใน MCOP Context (Internal Team)

**Core User Journeys Supported:**
*   **Warrior Ken:** ดู Task ตัวเองบนมือถือและ Update Status (Manual Sync)
*   **Scout Sarah:** เช็ค Fog of War (Requirement Readiness)
*   **Guild Master Om:** เปิด World Map พรีเซนต์งานผู้บริหาร

**Must-Have Capabilities:**
*   **Hero Task Board (Mobile):** UI แบบ Card List ที่สวยงาม เน้นการแสดงผล Status
*   **Auto-Sync (No Manual Button):** ระบบดึงข้อมูลจาก Sheets อัตโนมัติทุก 1 นาที — **ไม่มีปุ่ม Sync** เพราะต้องการให้ระบบทำงานเองโดยไม่ต้องกังวล
*   **Basic World Map:** แสดง System (City) → Flow (Commander with 6 HP Bars) → Task (Minion) ในรูปแบบแผนที่
*   **Shop & Inventory:** ระบบซื้อของแต่งตัว (Avatar/Theme) โดยใช้ Local Currency (XP/Gold) ที่ได้จากงาน
*   **Fog Visualization:** แสดงพื้นที่สีเทาทับ Flow ที่ Requirement ไม่ครบ (AC HP Bar ยังไม่เต็ม)

### Post-MVP Features

**Phase 2 (Guild Wars):**
*   **Multi-Guild System:** รองรับหลายทีม (Branch)
*   **Asset Forge:** ระบบแนบลิงก์ Figma/Design Assets (Blacksmith Role)
*   **Slack Integration:** แจ้งเตือน Boss Down / Fog Alert

**Phase 3 (Expansion):**
*   **Marketplace:** แลกเปลี่ยนของระหว่างผู้เล่น
*   **Boss Raid Event:** Real-time Co-op Event (Optional)
*   **Cross-Project Dependency Map:** แผนที่โยงความสัมพันธ์ระหว่างโปรเจกต์

### Risk Mitigation Strategy

*   **Technical Risks (Legacy Device Performance):**
    *   *Mitigation:* ใช้ Livewire + Alpine.js แทน JS Game Engine หนักๆ เพื่อให้ทำงานลื่นไหลบนมือถือทุกรุ่น
*   **Market Risks (Sync Delay Frustration):**
    *   *Mitigation:* ใช้ปุ่ม **Manual Sync** ให้ User กดเองเมื่อต้องการข้อมูลล่าสุด แทนการรอรอบ Auto Sync
*   **Resource Risks (Over-engineering):**
    *   *Mitigation:* ตัด Feature ที่ซับซ้อน (Real-time Battle, Physics) ออกใน MVP เน้นแค่ Decoration & Status Display

## Functional Requirements

### Authentication & User Management
*   **FR-AUTH-01:** ระบบต้องรองรับการเข้าสู่ระบบผ่านอีเมลองค์กร (Google OAuth)
*   **FR-AUTH-02:** ระบบต้องกำหนดอาชีพ (Class) ให้ผู้ใช้ตามกลุ่มงาน Assigned
*   **FR-AUTH-03:** ผู้ใช้ต้องสามารถดูสถานะ: XP, Level, **Gold (ใช้ซื้อของ)** และ **Gem (สะสมแลกเงินจริง)**

### Data Synchronization & Architecture
*   **FR-SYNC-01:** (Backend) ระบบต้องดึงข้อมูลจาก Google Sheet โดยอัตโนมัติทุกๆ **1 นาที** และบันทึกลง Database
*   **FR-SYNC-02:** (Performance) API สำหรับ Frontend ต้องมี Cache ระยะเวลา **10 วินาที**
*   **FR-SYNC-03:** (Entity Mapping)
    *   Project $\rightarrow$ Demon King (ราชาปีศาจ)
    *   System $\rightarrow$ City (เมือง)
    *   Flow $\rightarrow$ Commander (หัวหน้าหน่วย) — **มี 6 HP Bars: Design, AC, API, FE/App, Testing, UAT**
    *   Task $\rightarrow$ Minion (สมุน) — **แยก 3 ประเภทตาม Sheet: UI-tasks, API-tasks, FE-tasks**
    *   Bug $\rightarrow$ **Demon Reinforcements (กองหนุนจากราชาปีศาจ)** — มาจากประตูมิติ, ไม่รู้จำนวน/เวลาที่จะปรากฏ

### Battle Visualization & Feedback Loop (6 HP Bars System)
*   **FR-BATTLE-01:** แสดง Animation **ถูก Minion รุมโจมตี** ตามจำนวน Task สถานะ "Doing" ของผู้ใช้
*   **FR-BATTLE-02:** เมื่อ Task เสร็จ (UI/API/FE) $\rightarrow$ Minion ตาย + **HP Bar ที่เกี่ยวข้องของ Commander เพิ่มขึ้น**
    *   UI-task Done $\rightarrow$ **Design HP Bar** เพิ่ม
    *   API-task Done $\rightarrow$ **API HP Bar** เพิ่ม
    *   FE-task Done $\rightarrow$ **FE/App HP Bar** เพิ่ม
*   **FR-BATTLE-03:** เมื่อ Flow เสร็จ (6 HP Bars = 100% ทั้งหมด) $\rightarrow$ Commander ตาย (Big Effect) + **HP City Boss ลดลง**
*   **FR-BATTLE-04:** เมื่อ System เสร็จ $\rightarrow$ City Boss ตาย (Huge Effect) + **HP Demon King ลดลง**
*   **FR-BATTLE-05:** ผู้ใช้ทุกคนต้องเห็น Global Effect (ข้อ 3, 4) พร้อมกันตามสถานะ Global DB
*   **FR-BATTLE-06:** **Demon Portal:** เมื่อมี Bug ใหม่ใน Bugs Sheet $\rightarrow$ แสดง "ประตูมิติเปิด" Animation + แจ้ง Telegram "Demon Reinforcements Arrived!"

### Rewards System (Incentive Logic)
*   **FR-REWARD-01:** **Gold Reward:** เมื่อ Task (Non-Bug) เสร็จ ผู้ทำได้ Gold เข้าตัว
*   **FR-REWARD-02:** **Gem Reward (Incentive):** เมื่อ Flow (Boss) ถูกกำจัด ผู้เกี่ยวข้องได้รับ Gem ตามสูตร `Base Gem x Business Value x Time Modifier`
*   **FR-REWARD-03:** **No Bug Reward (Demon Reinforcements):** Bug คือ **กองหนุนจากราชาปีศาจ** ที่มาจากประตูมิติ — การเคลียร์ Bug (Fixed) **ไม่ได้รับรางวัลใดๆ** (No XP, No Gold, No Gem) เพราะเป็นการกำจัดสิ่งที่ไม่ควรมีตั้งแต่แรก
*   **FR-REWARD-04:** Gem Record ต้องถูกบันทึกแบบ **Immutable** (แก้ไขไม่ได้) เพื่อใช้คำนวณ Incentive

### Shop & Inventory (Cosmetic Only)
*   **FR-SHOP-01:** การซื้อไอเทมใช้ **Gold เท่านั้น** (ห้ามใช้ Gem)
*   **FR-SHOP-02:** ไอเทมมีเงื่อนไข **Level Requirement** ในการซื้อ/สวมใส่
*   **FR-SHOP-03:** ไอเทมทุกชิ้นมีผลเพียงความสวยงาม (Cosmetic Only) ไม่มีผลต่อค่าพลัง

## Non-Functional Requirements

### Performance (ประสิทธิภาพ)
*   **NFR-PERF-01:** **Sync Latency:** กระบวนการดึงข้อมูลจาก Google Sheet จนถึง Database ต้องใช้เวลาไม่เกิน **30 วินาที** ต่อรอบ
*   **NFR-PERF-02:** **Dashboard Load Time:** หน้า Hero Task Board บนมือถือต้องพร้อมใช้งานภายใน **2 วินาที**
*   **NFR-PERF-03:** **Battle Effect:** Animation ต้องแสดงผลลื่นไหล (30-60 FPS) บนมือถือระดับกลาง

### Reliability & Availability (ความน่าเชื่อถือ)
*   **NFR-REL-01:** **Sync Resilience:** หาก Google API ล่ม ระบบต้องไม่ Crash และแสดงข้อมูล Cached
*   **NFR-REL-02:** **Data Integrity:** ข้อมูล "Gem" ต้องถูกต้อง 100% ห้ามสูญหาย

### Security (ความปลอดภัย)
*   **NFR-SEC-01:** **Access Control:** ระบบต้องตรวจสอบสิทธิ์เข้าใช้งานผ่าน **Whitelist Emails** ที่กำหนดไว้ใน Config (รองรับทั้งอีเมลองค์กรและ Gmail ภายนอกที่ได้รับอนุญาต)
*   **NFR-SEC-02:** **Audit Trail:** บันทึก Log การแก้ไขค่าสำคัญและ Gem Transaction

### Usability & UX (การใช้งาน)
*   **NFR-UX-01:** **Mobile Responsiveness:** รองรับหน้าจอมือถือเล็กสุด 375px
*   **NFR-UX-02:** **No Shame Design:** ห้ามแสดง Ranking ประจานคนทำงานช้า



