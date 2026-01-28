# PRD – MCOP Quest

## 1. Overview
**Codename:** MCOP Quest  
**Product Type:** Internal Gamification Dashboard (RPG Theme)  
**Platform:** Browser-based, Mobile-first  
**Auth:** Google Login (OAuth2)

### Objective
Transform MCOP project development data into a retro 90s Hero RPG experience that motivates teams, visualizes progress clearly, and serves as a reusable framework for future games.

---

## 2. Vision & Principles
- **Data-driven truth:** Game state must reflect real project data.
- **Visible progress:** Users understand project health at a glance.
- **Config-first design:** No hardcoded project logic.
- **Reusable framework:** All core systems must be reusable across future games.

---

## 3. Core Metaphor Mapping
| Project Concept | Game Concept |
|-----------------|-------------|
| System | City |
| Epic / Flow | Boss |
| Story | Boss Phase |
| Task | Minion |
| Bug | Demon Reinforcement |
| Project Completion | Demon King Defeated |

---

## 4. User Roles & Teams
- **Business Team:** Support / Item Crafter
- **UX/UI Team:** Equipment Crafter
- **Backend Team:** Mage / Ranger (Backline DPS)
- **Frontend Team:** Warrior / Tank (Frontline)

Roles are visual/identity-based only; no combat mechanics.

---

## 5. Core Gameplay Loop
1. Sync data from Google Sheets
2. Normalize data into game entities
3. Render world map and city views
4. User views progress, threats, and rewards
5. Task status changes update game state
6. Rewards update hero profile and progression

---

## 6. Game Structure & Navigation

### View Model Overview
ระบบแบ่งมุมมองการใช้งานออกเป็น 3 ระดับชัดเจน เพื่อไม่ให้ภาพในหัวคลาดกันตั้งแต่ต้น

1. **Personal View (ฉันทำอะไรอยู่)**
2. **Team View (ทีมฉันเป็นอย่างไร)**
3. **World / Project View (ภาพรวมทั้งหมดของ MCOP)**

ทุกหน้าจอจะต้องตอบได้อย่างน้อย 1 ข้อจาก 3 ข้อนี้

---

### Screen List (Phase 1 – Wireframe Scope)

#### 1. Login / Profile Screen
**User ทำอะไรได้บ้าง**
- Login ด้วย Google Account
- ระบบสร้าง/โหลด Hero Profile อัตโนมัติ

**มุมมอง**: Personal (Entry point)

---

#### 2. Hero Dashboard (Personal View)
**เป้าหมายหน้าจอ**: ตอบคำถามว่า *"วันนี้ฉันควรโฟกัสอะไร"*

**แสดงผล**
- Hero Avatar + Level
- EXP / Coin / Gem
- Task ที่ assigned ให้ตัวเอง (Minions ใต้ตัว)
- Task ที่เรากำลัง block ทีมอื่น (ถ้ามี)

**User Actions**
- คลิกดูรายละเอียด task
- ดู reward ที่จะได้ถ้าปิดงาน

---

#### 3. Team Camp (Team View)
**เป้าหมายหน้าจอ**: เห็นสภาพทีมแบบไม่ต้องอ่านรายงาน

**แสดงผล**
- Team Avatar (Business / UX / BE / FE)
- สมาชิกในทีม + level
- Task ของทีม (รวม)
- Contribution ต่อ Boss / City

**User Actions**
- Drill down ไปดู task รายคน
- เปรียบเทียบ contribution (visual only)

---

#### 4. World Map (Project View)
**เป้าหมายหน้าจอ**: ภาพรวมทั้งหมดของ MCOP

**แสดงผล**
- เมืองทั้งหมด (System)
- สถานะเมือง (Boss alive / dead)
- Bug alert ที่ active

**User Actions**
- เข้า City View
- ดู % ความคืบหน้าแต่ละระบบ

---

#### 5. City View (Epic / Flow View)
**เป้าหมายหน้าจอ**: ทำให้ Epic/Flow จับต้องได้

**แสดงผล**
- Boss (Flow)
- HP Boss = % งานที่เหลือ
- Minions = Tasks (UI/FE/API)
- Deadline / Business Value

**User Actions**
- ดู task list
- ดูผลกระทบทาง Gem ถ้าเสร็จเร็ว/ช้า

---

#### 6. Reward Shop (Personal)
**เป้าหมายหน้าจอ**: Reward ต้อง "เห็นผล" ทางสายตา

**แสดงผล**
- Cosmetic items
- Equipment tier (lock ตาม level)

**User Actions**
- ซื้อของ
- เปลี่ยน appearance (ไม่กระทบ logic)

---

#### 7. Activity Log (Shared View)
**เป้าหมายหน้าจอ**: ความโปร่งใส + narrative

**แสดงผล**
- ใครปิด task อะไร เมื่อไร
- Bug spawn / cleared
- Boss defeated

**User Actions**
- Filter ตาม team / system / เวลา

---

### Wireframe Rule (Lock for Phase 1)
- ทุกหน้าจอ = Read-heavy, Action-light
- ไม่มี drag / animation ซับซ้อน
- ทุก component ต้อง map กลับไปที่ data จริง

---


## 7. Data Model (Canonical)
### Task (Minion)
- id
- source (UI / FE / API)
- system
- flowId
- action
- status (todo / doing / done / blocked)
- ownerTeam
- urgent

### Flow (Boss)
- id
- system
- name
- businessValue
- dueDate
- completionDate

---

## 8. Progression & KPI System
- **Task Completed:** EXP + Coin
- **Bug Appears:** Gem reward
- **Flow Completed:** Gem × Business Value × Time Modifier

Gem values are recorded immutably for future incentive conversion.

---

## 9. Authentication & Security
- Google OAuth2 login only
- Email domain allowlist
- One user = one hero profile

---

## 10. Non-Goals (Phase 1)
- No real-time combat
- No multiplayer interaction
- No real-money payout
- No advanced animation or physics

---

## 11. Success Criteria
- Users log in via Google and see real project progress
- Task updates reflect immediately in game state
- Framework reusable for at least two future games

---

## 12. Future Phases (Out of Scope)
- Advanced animation systems
- Monetization
- External integrations beyond Google Sheets

