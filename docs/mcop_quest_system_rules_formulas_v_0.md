# MCOP Quest – System Rules & Formulas v0.1

> เป้าหมายเอกสารนี้: ทำให้กติกา/สูตรคำนวณ “คมพอเขียนโค้ดได้” และ “ยุติธรรมต่อทีม” โดยเฉพาะ BU/UX ที่ไม่ทำให้ HP บอสลด

---

## 1. Core Rule Locks (ห้ามเปลี่ยน)

### 1.1 Boss HP Reduction
- **HP บอสลดได้จากงาน BE/FE เท่านั้น**
- งาน BU/UX **ไม่ลด HP** แต่ให้ผลเป็น **Support Buff / Modifier** ต่อการสู้บอส (เพิ่ม damage efficiency, เพิ่ม gem bonus, ลด penalty ฯลฯ)

### 1.2 Views
- Personal view แสดงเฉพาะ task ของตน
- World/City view แสดงภาพรวม/สรุป ไม่เน้นรายคน

---

## 2. Canonical Definitions

### 2.1 Entities
- **City (System)**: กลุ่มของ Flows
- **Boss (Flow)**: หน่วยหลักของความคืบหน้าในเมือง
- **Minion (Task)**: หน่วยงานย่อย แบ่งเป็น Damage vs Support
- **Bug Event**: เหตุการณ์สุ่ม/คาดเดาไม่ได้ สร้างแรงกดดันและให้ Gem

### 2.2 Task Types
- **Damage Task**: `ownerTeam ∈ {BE, FE}`
- **Support Task**: `ownerTeam ∈ {Business, UX}`

---

## 3. Boss HP Model (Flow Progress)

### 3.1 HP Representation
- แนะนำให้ใช้ **Normalized HP** ระหว่าง `0..1` เพื่อให้ UI/สูตรง่าย
  - `bossHP = 1.0` = ยังไม่เริ่ม
  - `bossHP = 0.0` = เคลียร์

### 3.2 Damage Completion Ratio
ให้คำนวณเฉพาะ “damage tasks” ภายใต้ Flow เดียวกัน:

- `D_total = Σ weight(t)` สำหรับทุก damage task
- `D_done  = Σ weight(t)` สำหรับ damage task ที่ status = done

**Damage Completion**
- `D_ratio = clamp(D_done / max(D_total, ε), 0, 1)`

**Boss HP (พื้นฐาน)**
- `bossHP_base = 1 - D_ratio`

> ความหมาย: เคลียร์งาน BE/FE ครบ → HP เหลือ 0

### 3.3 Task Weighting (แนะนำเพื่อกัน bias)
ถ้าไม่มี effort/estimate ใน sheet ให้เริ่มแบบง่าย:
- `weight(t) = 1` ทุกงาน

ถ้ามี field แนว complexity/points ในอนาคต:
- `weight(t) = points` (หรือ map เป็น 1/2/3)

**Scope Guard**: Phase 1 เริ่มด้วย weight=1 ก่อน แล้วค่อยเพิ่ม

---

## 4. Support System (BU/UX) – Buff / Modifier

> เป้าหมาย: ให้ทีม support “เห็นผล” ชัดเจน โดยไม่ต้องลด HP ด้วยตัวเอง

### 4.1 Support Buff Types (เลือกใช้ใน Phase 1 แบบ Low-risk)

#### A) Damage Efficiency Buff (แสดงผลใน City View)
Support completion ทำให้ **ดาเมจจาก BE/FE ‘คุ้มค่า’ ขึ้น** ในเชิงการเล่าเรื่อง/ตัวเลข (แต่ไม่เปลี่ยน HP model พื้นฐานจนซับซ้อน)

- คำนวณ `S_ratio` จาก support tasks (BU/UX) ภายใต้ Flow:
  - `S_total = Σ weight(t)` ของ support tasks
  - `S_done  = Σ weight(t)` ของ support tasks done
  - `S_ratio = clamp(S_done / max(S_total, ε), 0, 1)`

- แปลงเป็น **Buff Tier** (เพื่อทำให้ UX/UI เห็นเป็นขั้น ๆ):
  - Tier 0: `S_ratio < 0.25`
  - Tier 1: `0.25 ≤ S_ratio < 0.5`
  - Tier 2: `0.5 ≤ S_ratio < 0.75`
  - Tier 3: `S_ratio ≥ 0.75`

**การแสดงผล**
- City View แสดง “Support Aura” รอบบอสตาม Tier
- Boss Card แสดงว่า “Support พร้อมแค่ไหน”

> หมายเหตุ: Phase 1 แนะนำให้ buff นี้ **เป็น visual + multiplier เฉพาะ reward** ก่อน ยังไม่ไปแตะ HP calculus โดยตรง

#### B) Reward Buff (แนะนำเป็น default)
Support completion เพิ่ม Gem Bonus เมื่อเคลียร์ Flow:
- `supportBonus = 1 + (supportBonusMax * S_ratio)`
- ค่าแนะนำเริ่มต้น: `supportBonusMax = 0.25` (โบนัสสูงสุด +25%)

#### C) Penalty Shield (สำหรับงานช้า)
Support completion ลด penalty เมื่อเสร็จช้า:
- `latePenaltyScale = 1 - (lateShieldMax * S_ratio)`
- ค่าแนะนำ: `lateShieldMax = 0.3`

> ผลลัพธ์: BU/UX ช่วย “ลดความเสียหาย” จากความล่าช้าได้

---

## 5. Rewards & Economy

### 5.1 EXP / Coin (Task)
**Task done → ได้ EXP และ Coin**

แนะนำสูตรเริ่มต้น (เรียบง่าย):
- `exp = expBase[source] * teamExpMultiplier[ownerTeam]`
- `coin = coinBase[source]`

ค่าตั้งต้นแนะนำ:
- `expBase`: UI=10, FE=12, API=12 (หรือทุก source = 10)
- `teamExpMultiplier`: ทุกทีม=1.0 (Phase 1 เพื่อกัน drama)
- `coinBase`: ทุก source = 5

> Phase 1 ควร “แฟร์” ก่อน แล้วค่อยปรับสมดุลภายหลัง

### 5.2 Gem (Bug)
- Bug spawn → Gem fixed
- `gem_bug = 1` (เริ่มต้น)

### 5.3 Gem (Flow/Boss Clear)
ให้กำหนด:
- `BV = businessValue` ของ Flow (จำนวนเต็ม 1..10 หรือ 10..100)
- `gemBase = gemBasePerBV * BV`

**Time Modifier**
ให้ define:
- `Δ = days(completionDate - dueDate)`
  - ถ้าเสร็จก่อนกำหนด → Δ < 0
  - ตรงเวลา → Δ = 0
  - ช้า → Δ > 0

แนะนำโมเดล piecewise ที่เข้าใจง่าย:
- Early bonus:
  - `earlyBonus = min(earlyMax, earlyRate * abs(min(Δ,0)))`
- Late penalty:
  - `latePenalty = min(lateMax, lateRate * max(Δ,0))`

ตัวอย่างค่าตั้งต้น:
- `earlyRate = 0.02` ต่อวัน (2% ต่อวัน)
- `earlyMax = 0.2` (โบนัสสูงสุด +20%)
- `lateRate  = 0.03` ต่อวัน (3% ต่อวัน)
- `lateMax  = 0.3` (หักสูงสุด -30%)

**Time Modifier Final**
- `timeModifier = (1 + earlyBonus - latePenalty)`

**Apply Support Buff**
- `gem_flow = gemBase * timeModifier * supportBonus`

**Gem Ledger Rule**
- บันทึกทุกครั้งที่คำนวณ gem_flow เป็นรายการ immutable:
  - flowId, computedAt, gemAmount, BV, Δ, modifiers

---

## 6. Bug System (Event Model)

> เป้าหมาย: สะท้อนความจริงของงานให้มากที่สุด — **Bug ไม่ใช่เหตุการณ์สุ่ม แต่เป็นสิ่งที่เกิดขึ้นทุกวันจากข้อมูลจริง** และเป็น “ต้นทุน/บทลงโทษ” ในตัวเอง

### 6.1 Bug Source of Truth (Locked)
- Bug **ไม่ spawn แบบสุ่ม**
- Bug ถูกสร้างจาก **Google Sheet: Bug / Issue Log** โดยตรง
- ระบบทำหน้าที่:
  - ดึงข้อมูล bug รายวัน
  - แปลง bug → Demon Reinforcement

---

### 6.2 Bug Entity Definition
Bug หนึ่งรายการใน sheet = Demon Reinforcement 1 ตัว

แนะนำ field ขั้นต่ำ:
- bugId
- system / city
- severity (low / medium / high)
- detectedDate
- status (open / fixed)

---

### 6.3 Bug Impact Rules (No Reward)

#### A) World / City View (Pressure)
- Bug แสดงเป็น Demon Icon รอบเมือง
- จำนวน/ความรุนแรงของ bug = ระดับแรงกดดันของเมือง

#### B) No-Reward Policy (Locked)
- เมื่อ bug เกิด: **ไม่ให้ Gem / Coin / EXP**
- เมื่อ bug ถูกแก้: **ไม่ให้ Gem / Coin / EXP**

> เหตุผล: Bug เป็นสิ่งไม่พึงประสงค์อยู่แล้ว จึงต้อง “มีแต่เสียกับเสีย” เพื่อสะท้อนความจริง

#### C) Penalty Model (Phase 1 – Simple, Audit-friendly)
Bug ส่งผลเสียในรูปแบบ **Penalty Multiplier** ต่อรางวัลของเมือง/Flow ที่เกี่ยวข้อง

1) คำนวณ Bug Pressure ของเมือง/Flow
- `P = Σ severityWeight(bug)` ของ bug ที่ status=open
- ค่าน้ำหนักแนะนำเริ่มต้น: low=1, medium=2, high=3

2) คำนวณ Penalty
- `bugPenalty = max(1 - bugPenaltyRate * P, bugPenaltyMin)`

ค่าตั้งต้นแนะนำ:
- `bugPenaltyRate = 0.03` (3% ต่อ 1 pressure)
- `bugPenaltyMin = 0.7` (หักไม่เกิน 30%)

3) นำไปใช้กับรางวัลระดับ Flow (Locked: กระทบเฉพาะ Gem)
- `gem_flow_final = gem_flow * bugPenalty`
- **ไม่กระทบ** Coin/EXP จาก task และไม่กระทบรางวัลอื่นใน Phase 1

---

### 6.4 Anti-Exploit Rule
- ห้ามมี mechanic ใด ๆ ที่จูงใจให้เกิด bug มากขึ้น
- bug ไม่มีรางวัลใด ๆ ทั้งตอนเกิดและตอนแก้

---

## 7. Anti-Toxicity & Fairness Guards

### 7.1 No Team Shaming by Default
- World view แสดง team contribution แบบ “soft” (icons/tier) ไม่ใช่ ranking 1..4

### 7.2 Support Visibility Must Be High
- ทุก Flow ต้องแสดง support tier และผลต่อ reward ชัดเจน
- Personal view ของ BU/UX ต้องเห็นว่า task ของฉันเพิ่ม bonus อะไร

### 7.3 Avoid Perverse Incentives
- อย่าให้การ “สร้าง bug” ได้กำไร
- Gem จาก bug ต้องต่ำกว่า gem จาก flow อย่างมีนัยสำคัญ

---

## 8. Acceptance Criteria (Formula Level)

- HP บอสเปลี่ยนแปลง **เฉพาะ** เมื่อ BE/FE task done เปลี่ยน
- BU/UX task done ส่งผลต่อ:
  - supportTier เปลี่ยน
  - gem_flow เปลี่ยน (ผ่าน supportBonus/lateShield)
- สูตรคำนวณสามารถ reproduce ได้จาก log (audit-friendly)
- ทุกค่าใช้ config ปรับได้ ไม่ hardcode

---

## 9. Configuration Knobs (ควรอยู่ใน config)
- expBase, coinBase
- gem_bug
- gemBasePerBV
- earlyRate, earlyMax, lateRate, lateMax
- supportBonusMax, lateShieldMax
- bug spawn params

---

## 10. Recommendation (Phase 1 Defaults)
เพื่อให้เริ่มได้เร็วและลดการถกเถียง:
- weight(t)=1
- teamExpMultiplier = 1.0 ทุกทีม
- supportBonusMax = 0.25
- earlyRate=0.02, earlyMax=0.2
- lateRate=0.03, lateMax=0.3
- bug daily spawn p=0.15

> หลังมีข้อมูลจริง 2–4 สัปดาห์ ค่อย tune knobs ด้วยข้อมูล ไม่ใช่ความรู้สึก

