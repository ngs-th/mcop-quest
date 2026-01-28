---
stepsCompleted: [1, 2, 3, 4, 5]
inputDocuments:
  - prd_mcop_quest_gamification_dashboard.md
  - mcop_quest_system_rules_formulas_v_0.md
  - mcop_quest_wireframe_definition_v_0.md
date: 2026-01-28
author: Master
---

# Product Brief: mcop-quest


## Executive Summary

**MCOP Quest** คือ Internal Gamification Dashboard ที่มีเป้าหมายในการเปลี่ยนข้อมูลการพัฒนาโปรเจกต์ที่น่าเบื่อบน Google Sheets ให้กลายเป็นประสบการณ์เกม RPG ยุค 90 ที่สนุกและจับต้องได้

ในขณะที่เครื่องมือจัดการโปรเจกต์ทั่วไป (เช่น Google Sheets) ทำหน้าที่เก็บข้อมูลได้ดีเยี่ยม แต่กลับล้มเหลวในการสื่อสาร "ภาพรวม" (Big Picture) และ "ทิศทาง" (Direction) ให้กับสมาชิกในทีม ทำให้ทีมงานรู้สึกเหมือนทำงานไปวันๆ โดยไม่เห็นจุดหมาย MCOP Quest เข้ามาแก้ปัญหานี้โดยการครอบ Layer ของ "โลกเกมแฟนตาซี" ทับลงบนข้อมูลจริง ทำให้ Progress ของงานกลายเป็นพลังชีวิตของบอส และความสำเร็จของทีมกลายเป็นชัยชนะที่ทุกคนมองเห็นร่วมกัน

---

## Core Vision

### Problem Statement (ปัญหาหลัก)
สมาชิกในทีมพัฒนา MCOP ขาดการมองเห็นภาพรวม (Big Picture Visibility) และทิศทางของโปรเจกต์ เนื่องจากข้อมูลสถานะงานถูกฝังอยู่ใต้มหาสมุทรของตารางและตัวเลขใน Google Sheets ทำให้เกิดความรู้สึกหลงทาง (Disconnection) และไม่รู้ว่างานที่ทำอยู่ส่งผลต่อความสำเร็จของภาพใหญ่อย่างไร

### Problem Impact (ผลกระทบ)
- **Lack of Direction:** ทีมงานโฟกัสแค่ Task ตรงหน้า แต่ไม่รู้ว่า "ตอนนี้เราอยู่จุดไหน" และ "กำลังจะไปที่ไหน"
- **Low Engagement:** การอัปเดตสถานะงานกลายเป็นภาระงานเอกสารที่น่าเบื่อ แทนที่จะเป็นความภูมิใจ
- **Siloed Awareness:** ต่างคนต่างทำงานของตัวเอง โดยไม่เห็นสถานะหรือความช่วยเหลือที่เพื่อนร่วมทีมต้องการ

### Why Existing Solutions Fall Short (ทำไมเครื่องมือเดิมไม่ตอบโจทย์)
- **Google Sheets:** ดีเลิศด้าน Data Entry และ Logic แต่แย่มากด้าน Visualization และ Motivation มันคือ Database ไม่ใช่ Dashboard และมันต้องการ "การตีความ" สูงมากเพื่อที่จะเข้าใจสถานะภาพรวม
- **Standard Dashboards (Jira/Trello):** ให้ข้อมูลสถานะ แต่ขาด "อารมณ์ร่วม" (Emotional Engagement) และความสนุก

### Proposed Solution (ทางออกของเรา)
**MCOP Quest** เปลี่ยน Interface จาก "ตารางสูตรคูณ" เป็น "เกม RPG":
- **Metaphor Mapping:** แปลง System เป็น "เมือง", Epic/Flow เป็น "บอส", และ Task เป็น "สมุน" (Minion)
- **Visual Feedback:** HP ของบอสลดลงจริงๆ เมื่อ Coding เสร็จ ทำให้เห็น Progress แบบ Real-time
- **Role-Based:** ให้ Team Member สวมบทบาท Hero (Warrior, Mage, Crafter) เพื่อสร้าง Identity และความสำคัญในทีม

### Key Differentiators (จุดเด่นที่แตกต่าง)
- **Data-Driven Game State:** เกมไม่ได้แยกจากงาน; "งานจริง = เกมจริง" ไม่มีการเมคข้อมูล
- **Emotional UX:** ใช้ความรู้สึก "อยากเอาชนะบอส" มาขับเคลื่อน Productivity แทนที่จะเป็นแค่ Deadline
- **Config-First Framework:** ออกแบบมาเพื่อให้เป็น Framework ที่ Reusable สำหรับโปรเจกต์ในอนาคตได้ทันที


## Target Users

### Primary Users

#### 1. "The Implementers" (Backend & Frontend Developers)
*   **Role in Game:** Warrior (Frontline) / Mage (Backline DPS)
*   **Context:** เป็นกลุ่มที่ลงแรงทำงานจริงในแต่ละวัน (Execution heavy)
*   **Problem Experience (Current):** มองการอัปเดต Google Sheet เป็น "ภาระทางธุรการ" (Admin Chore) ทำไปแกนๆ ให้จบๆ ไม่รู้สึกถึงความเชื่อมโยงว่าการเปลี่ยน Status 'Done' ครั้งหนึ่งมันมีความหมายต่อภาพรวมอย่างไร
*   **Success Vision:** ต้องการ **Instant Gratification** คือความรู้สึกชนะทันทีที่งานเสร็จ อยากเห็นผลลัพธ์ที่จับต้องได้ว่า "Code ของฉันเพิ่งสร้าง Damage มหาศาลใส่บอสไป"

#### 2. "The Scout" (Business Analyst / PO)
*   **Role in Game:** Scout (Reconnaissance Unit)
*   **Context:** ผู้ลาดตระเวนสำรวจพื้นที่หน้างาน (Client/Stakeholder) เพื่อนำข้อมูล (Requirement) มาทำแผนที่ให้ทีม
*   **Problem Experience (Current):** อาจยังไม่เห็นความสำคัญของการ "ส่งมอบแผนที่ที่ชัดเจน" ทำให้ทีม Dev ต้องเดินเข้าสู่ **Fog of War** (ความไม่รู้) หรือเจอกับสถานการณ์ **Boss Enrage** (Requirement เปลี่ยนกลางคัน บอสกลายร่าง เลือดเด้ง) ซึ่งสร้างความเสียหายทางจิตใจให้ทีมมหาศาล
*   **Success Vision:** ต้องการ **Impact Awareness** ตระหนักว่าการ "Clear Path" (ถางทาง/สรุป Req) ของตน มีค่ายิ่งกว่าการตีบอสเอง เพราะช่วยให้เพื่อนร่วมทีมรู้เป้าหมาย รู้จำนวนศัตรู และไม่เดินสะดุดขาตัวเอง

### User Journey

#### 1. Discovery & Awakening (The Aha! Moment)
*   **Scenario:** สมาชิกทีมล็อกอินเข้ามาครั้งแรก
*   **Action:** เปิดดู **World Map Project View**
*   **Feeling:** จากเดิมที่เห็นแค่ Row ใน Google Sheet เปลี่ยนเป็นเห็น "แผนที่โลก" ที่ระบุพิกัดชัดเจน "เฮ้ย! เราอยู่กลางเมืองนี้เองเหรอ" และ "เหลืออีก 2 เมืองถึงจะจบเกม" -> **เกิด "Situation Awareness" (การรู้เท่าทันสถานการณ์)** ทันที

#### 2. The Daily Grind (Core Loop)
*   **Scenario:** Dev ทำงานเสร็จ 1 Task (Damage Dealt)
*   **Action:** เปลี่ยน Status เป็น Done ในระบบ (หรือ Sync มา) -> หน้าจอแสดง Animation "Damage Hit" ใส่บอส HP บอสลดลง
*   **Feeling:** **"Satisfaction" (ความฟิน)** รู้สึกว่าแรงที่ลงไปมีความหมาย สัมผัสถึงความคืบหน้าแบบ Real-time และ "ชนะ" ในระดับวัน

#### 3. Strategic Realization (Scout Mission)
*   **Scenario:** Business Team เห็นแผนที่ในเกมยังมืดดำ (Fog of War) ใน Epic ถัดไป
*   **Action:** รีบออกไปสำรวจ (Meeting ลูกค้า/สรุป Req) เพื่อนำข้อมูลมาเปิดแมพ (Create Stories/Tasks) ให้ทีมเห็นจำนวน Minion และบอส
*   **Feeling:** **"Accountability" (ความรับผิดชอบ)** รู้สึกว่าตนเองเป็นกุญแจสำคัญที่ทำให้ทีม "มองเห็น" และเดินหน้าต่อได้ ไม่ใช่แค่คนสั่งงานลอยๆ

## Success Metrics

### User Success Metrics (วัดความ "อิน")
*   **Daily Bond (Login Rate):** 80% ของทีมงาน Login เข้ามาดูหน้า **Hero Dashboard** หรือ **World Map** อย่างน้อยวันละ 1 ครั้ง (แสดงว่าเขาแคร์ Status ของตัวเอง)
*   **Instant Gratification (Lag Time):** ระยะเวลาเฉลี่ยจากงานเสร็จจริง (Code Merged) ถึงเวลาอัปเดตสถานะในเกม ต้อง **< 2 ชั่วโมง** (แสดงความกระตือรือร้นที่จะเห็น Damage Output)
*   **Scout Value:** ทีม Dev เข้ามาอ่าน Detail/Criteria ใน Task Card **ก่อน** เริ่มทำงาน (วัดจาก View Count/Click Rate ใน Task Detail) แสดงว่าแผนที่ที่ Scout ทำไว้มีประโยชน์จริง

### Business Objectives (วัดผลลัพธ์องค์กร)
*   **Visibility:** ลดเวลาที่ใช้ในการทำรายงานสถานะโปรเจกต์ (Status Report) ลง 50% เพราะทุกคนเห็นภาพเดียวกันจาก World Map แล้ว
*   **Map Quality:** 90% ของ Epic/Flow ต้องมี Requirement ครบถ้วน (Map Revealed) ก่อนเข้า Sprint (ลด Fog of War)
*   **Morale:** ทีมเห็นความก้าวหน้าของโปรเจกต์สม่ำเสมอ ลดความรู้สึก "ทำงานฟรี" หรือ "เดินวนในอ่าง"

### Key Performance Indicators (KPIs)
| Metric | Target (Month 3) | Measurement Method |
| :--- | :--- | :--- |
| **Fog Cleared** | > 95% Tasks with full description | % of Tasks with valid AC & Description |
| **Damage Velocity** | Consistent damage per sprint | Total Boss HP reduced per week |
| **Respawn Rate** | < 10% (Low is good) | จำนวน Task ใหม่ที่ถูกสร้างทดแทน Task เดิมที่ทำผิด (สะท้อน Bad Req) |

## MVP Scope

### Core Features (Must-Haves)
1.  **Sync Engine (One-Way):** ระบบดึงข้อมูลจาก Google Sheets อัตโนมัติ (Read-only) เพื่อประกัน Single Source of Truth ห้ามมีการแก้ไขข้อมูล Task ในเกม เด็ดขาด
2.  **Tri-View Visualization:**
    *   **Hero Task Board:** แสดง Task รายบุคคล และ Effect "Damage Dealt" เมื่อสถานะเป็น Done
    *   **World Map:** แสดง System (เมือง), Epic/Boss, และ Progress Bar (HP)
    *   **Scout/Team Camp:** แสดงรายชื่อปาร์ตี้และ Status ภาพรวม
3.  **Entity Mapping Strategy (MCOP Context):**
    *   **System = City:** เขตแดนหลักของระบบงาน
    *   **Epic = City Boss:** บอสประจำเมืองที่ต้องล้มให้ได้ (1 System ~ 1 Big Boss)
    *   **Story/Flow = Lieutenant:** หัวหน้าหน่วยย่อยที่คุม Flow งาน
    *   **Task = Minion:** ลูกสมุนที่ทีมต้องจัดการเพื่อเปิดทาง
4.  **Fog of War System:**
    *   **Visual Logic:** แสดง Effect หมอก/เมฆบังพื้นที่ Epic ที่ Requirement ไม่ครบ (Missing Criteria in Sheet)
    *   **Behavior:** ผู้เล่นคลิกดู Detail ไม่ได้ หรือเห็นเป็นเครื่องหมายคำถาม (?)
5.  **Basic Gamification & Roles:**
    *   **Warrior/Mage (Devs):** ผู้ทำ Damage ใส่บอส
    *   **Scout (Business):** ผู้เปิดแผนที่ (Fog Clearing)
    *   **Blacksmith (UX):** ผู้สร้าง Unit/Asset (ตีบวกอาวุธให้ Dev)

### Out of Scope for MVP (Phase 1)
*   **Two-Way Sync:** ไม่มีการเขียนข้อมูลกลับไป Google Sheets
*   **Real-time Multiplayer:** ไม่เห็นเพื่อนเดินไปมาในแมพ
*   **Mobile Native App:** Web Responsive Only
*   **Monetization/Shop:** ซื้อของแต่งตัวได้ (Cosmetic) แต่ไม่มี Microtransaction จ่ายตังค์จริง

### MVP Success Criteria
*   **User Adoption:** 100% ของทีม MCOP เข้ามาเช็ค Status ผ่านเกมแทน Sheet ภายใน 1 เดือน
*   **Fog Reduction:** ทีม Business (Scout) สามารถเคลียร์ Fog of War (Requirement Complete) ได้ก่อนเริ่ม Sprint ถัดไป
*   **Stability:** Sync Engine ทำงานถูกต้อง 100% ข้อมูลในเกมตรงกับ Sheet เสมอ

### Future Vision
*   **Season 2:** เพิ่มระบบ "Guild War" (แข่งกันระหว่างทีมย่อย)
*   **Boss Raid Event:** บอสพิเศษที่ต้องรุมตีพร้อมกันในเวลาจำกัด (ใช้สำหรับช่วง UAT/Release Day)
*   **Marketplace:** ระบบแลกเปลี่ยน Item ระหว่างผู้เล่น
