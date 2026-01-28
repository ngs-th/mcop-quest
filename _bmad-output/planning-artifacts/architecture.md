---
stepsCompleted: [1, 2, 3, 4, 5, 6, 7, 8]
inputDocuments:
  - product-brief-mcop-quest-2026-01-28.md
  - prd.md
  - mcop_quest_system_rules_formulas_v_0.md
  - mcop_quest_wireframe_definition_v_0.md
  - prd_mcop_quest_gamification_dashboard.md
workflowType: 'architecture'
project_name: 'mcop-quest'
user_name: 'Master'
date: '2026-01-29'
lastStep: 8
status: 'complete'
completedAt: '2026-01-29'
---

# Architecture Decision Document

_This document builds collaboratively through step-by-step discovery. Sections are appended as we work through each architectural decision together._

## Project Context Analysis

### Requirements Overview

**Functional Requirements:**
- **Gamification Engine:** Transforms project management entities into game entities (System->City, Epic->Boss, Task->Minion) with complex interaction rules.
- **Sync Mechanism:** One-way synchronization from Google Sheets to Local Database (MySQL) with a 1-minute interval requirement.
- **Role-Based Views:** Strict separation between Personal View (Self-focus), Team View (Squad status), and World Map (Global status).
- **Economic System:** Dual currency system (Gold for cosmetics, Gem for real incentives) with immutable recording requirements.
- **Battle Logic:** Specific rules for HP reduction (Dev tasks only) vs Support Buffs (Business/UX tasks).
- **Bug System:** Event-driven bug spawning from sheet data with penalty logic (No rewards policy).

**Non-Functional Requirements:**
- **Performance:** Mobile-first dashboard loading < 2 seconds; Sync completion < 30 seconds.
- **Reliability:** System must degrade gracefully if Google API is unavailable (Cache usage).
- **Consistency:** Gem (Financial) records must be immutable and audit-proof.
- **Usability:** Responsive design support down to mobile size (375px).

**Scale & Complexity:**
- **Primary Domain:** Web Application / Interactive Dashboard (Laravel + Livewire)
- **Complexity Level:** Medium – High on logical complexity (formulas/rules), Medium on technical scale (single tenant start).
- **Estimated Architectural Components:** ~10-12 core components (Sync Engine, Game State Calculator, Auth Manager, View Composer, etc.)

### Technical Constraints & Dependencies

- **Framework:** Laravel 10+ (PHP 8.2+)
- **Frontend:** **Livewire 4** + Alpine.js
    - *Note:* We will use Livewire 4's new features like Single-File Components and Islands for better performance and organization.
- **Database:** MySQL 8.0 / MariaDB
- **External API:** Google Sheets API (Read-only scope preferred)
- **Deployment:** Internal Server / Cloud (Single Tenant initially)

### Cross-Cutting Concerns Identified

- **Synchronization Strategy:** Ensuring data consistency between external source (Sheet) and internal state (DB) without race conditions.
- **Game Mathematics:** Centralized formula management to ensure identical calculation across Sync, API, and UI layers.
- **Audit Logging:** Tracing all state changes related to Gem rewards and Bug penalties.
- **Visibility Control:** enforcing rule-based data visibility at the query/service level, not just UI hiding.

## Starter Template Evaluation

### Primary Technology Domain

**Web Application (Laravel Stack)** based on project requirements and `prd.md` specifications.

### Starter Options Considered

1.  **Laravel Jetstream (Livewire)**
    *   **Pros:** Includes Team management, API support (Sanctum), and 2FA out of the box.
    *   **Cons:** "Teams" feature is designed for multi-tenancy (isolation), whereas MCOP Quest requires a shared "World View" with loose team groupings. Customizing Jetstream's team logic to fit the "Guild" model might be harder than building custom. Steeper learning curve.

2.  **Laravel Breeze (Livewire)**
    *   **Pros:** Minimal, lightweight, and unopinionated. Perfect foundation for building custom game logic and role management (Role-Based Views) without fighting pre-built tenant isolation.
    *   **Cons:** Need to implement specific "Guild" logic and Google OAuth manually (via Socialite).

### Selected Starter: Laravel Breeze (Livewire 4)

**Rationale for Selection:**
We selected **Laravel Breeze (Livewire 4)** because MCOP Quest is a **Single-Tenant** application with a unique "Shared World" requirement. The strict data isolation in Jetstream's Team model would conflict with the "Global World Map" requirement. Breeze provides the essential Auth scaffolding (which we can extend with Socialite for Google Login) and a clean slate for Livewire components, allowing us to build the custom "Class/Guild" system exactly as specified in the Rulebook.

**Initialization Command:**

```bash
# Initialize Laravel 12 (or latest) in current directory
composer create-project laravel/laravel .

# Install Breeze
composer require laravel/breeze --dev

# Install Breeze with Livewire stack, Dark mode support, and Pest testing
# NOTE: Ensure Livewire 4 is installed via composer.json adjustment if starter uses v3 by default
php artisan breeze:install livewire --dark --pest
```

**Architectural Decisions Provided by Starter:**

**Language & Runtime:**
- **PHP 8.2+** / **Laravel 12.x**
- **Strict Typing** enabled by default in new Laravel versions.

**Styling Solution:**
- **Tailwind CSS** (Standard in Breeze) - aligned with the requirement for "Premium Design" and "Dark Mode".
- **PostCSS** / **Vite** for build pipeline.

**Build Tooling:**
- **Vite** for hot module replacement (HMR) and optimized frontend assets.

**Testing Framework:**
- **Pest PHP** - specified for its expressive syntax, making it easier to write tests for Game Formulas and Rules.

**Code Organization:**
- **Livewire Components:**
    - Livewire 4 introduces distinct `components/` vs `pages/` mental model.
    - We will leverage **Single-File Components** for small UI widgets to reduce file clutter.
- **Service Layer:** Will need to be added manually (e.g., `app/Services/GameEngine`) for the Sync and Rule logic.

**Development Experience:**
- **Alpine.js** included automatically via Breeze (Livewire stack) for lightweight interaction.
- **Dumps & Debugging** standard Laravel tools.
- **Livewire 4 Enhancements:** Use `<x-island>` for heavy widgets (e.g., Leaderboard) to isolate performance cost.

**Note:** Project initialization using this command should be the first implementation story.

## Core Architectural Decisions

### Decision Priority Analysis

**Critical Decisions (Block Implementation):**
- Data Modeling Strategy: Loose Coupling (Entity Separation)
- Sync Engine Architecture: Laravel Scheduler (Cron)
- Game State Calculation: Domain Events
- Integration Library: revolution/laravel-google-sheets

**Important Decisions (Shape Architecture):**
- Domain Entity Mapping: Project(Demon King) -> System(City) -> Flow(Boss) -> Task(Minion)
- Audit Logging Strategy for Gem Currency
- Frontend State Management (Alpine.js Stores vs Livewire Properties)

**Deferred Decisions (Post-MVP):**
- Multi-tenancy / Multi-guild architecture
- Advanced animation engine selection

### Data Architecture

**Database Schema Strategy: Loose Coupling (Selected)**
- **Decision:** Separate `game_entities` tables from `project_management` tables.
- **Rationale:** We chose **Loose Coupling (Option B)** to maintain clean architecture.
    - `projects`, `epics` (mapped from system), `flows` (mapped from flow), `tasks` store the raw management data.
    - `game_cities`, `game_bosses`, `game_minions` store the RPG stats (HP, Level, etc.).
    - Use Polymorphic Relationships or direct Foreign Keys to link them.
    - **Entity Mapping Correction (Standard Agile -> MCOP Context -> Game Entity):**
        - **Project Data Table:** `projects` -> **Game Entity:** Demon King (Global Threat)
        - **Project Data Table:** `epics` (derived from Sheet 'System') -> **Game Entity:** City AND City Boss (The main boss of the system)
        - **Project Data Table:** `stories` (derived from Sheet 'Flow') -> **Game Entity:** Unit Commander / Lieutenant (Sub-boss governing a flow)
        - **Project Data Table:** `tasks` (derived from Sheet 'Task') -> **Game Entity:** Minion (The enemies to defeat)
- **Affects:** Database Schema, Eloquent Models.

### Authentication & Security

**Authentication Method:**
- Keep Breeze default (Session-based) + **Laravel Socialite** for Google OAuth.
- **Strict Domain Whitelist:** Middleware to reject logins from non-authorized email domains.

**Gem Currency Security:**
- **Immutable Ledger Pattern:** `gem_transactions` table will be insert-only.
- No `update` allowed on transaction rows. Current balance is calculated via aggregation or caching a snapshot.

### API & Communication Patterns

**Sync Engine Architecture: Laravel Scheduler (Selected)**
- **Decision:** **Laravel Scheduler (Option A)** with `everyMinute()` and `withoutOverlapping()`.
- **Rationale:** Standard, reliable, and easy to control rate limits. We avoid the security complexity of Webhooks for this internal tool.
- **Library:** `revolution/laravel-google-sheets` (Verified compatible with Laravel 12).

**Game State Calculation: Domain Events (Selected)**
- **Decision:** **Domain Events (Option A)**.
- **Rationale:** Decouples the "Sync" logic from the "Game" logic.
    - When Sync updates a Task -> Fire `events.task_updated`.
    - Listener `CalculateBossDamage` runs -> Updates Unit Commander & City Boss HP.
    - Listener `DistributeGold` runs -> Updates User Wallet.
- **Testing:** This makes testing game formulas much easier (Unit Test the Listeners).

### Logic Mapping Clarification
**Standard Agile vs. MCOP Context:**
To ensure code maintainability and standard naming conventions while respecting the specific data source structure:
- **Standard DB Naming:** We will use standard Agile terms (`epics`, `stories`, `tasks`) in the database schema.
- **Data Source Mapping:**
  - Sheet `System` column -> maps to DB `epics` table -> represents **City & City Boss** in Game.
  - Sheet `Flow` column -> maps to DB `stories` table -> represents **Unit Commander (Lieutenant)** in Game.
  - Sheet `Task` column -> maps to DB `tasks` table -> represents **Minion** in Game.

### Decision Impact Analysis

**Implementation Sequence:**
1.  **Project Init:** Laravel Breeze + Socialite + Revolution/Google-Sheets.
2.  **Data Layer:** Create Schema with Loose Coupling Strategy (Separate Project vs Game tables).
3.  **Sync Engine:** Build the Scheduler to pull System/Flow/Task data.
4.  **Game Core:** Implement Domain Events for calculating HP/Rewards.
5.  **UI Construction:** Livewire Components for Dashboard/Map.

**Cross-Component Dependencies:**
- The **Sync Engine** is the heart. If it fails, the game stops. It needs robust error handling.
- **Game Logic** depends entirely on the accuracy of the **Entity Mapping**. We must ensure `Flow` correctly maps to `Boss` ID.

## Implementation Patterns & Consistency Rules

### Pattern Categories Defined

**Critical Conflict Points Identified:**
5 areas (Naming, Structure, API Format, Event Communication, Strict Typing) where AI agents could make different choices.

### 1. Mandatory Strict Typing & DTO Pattern

**Type Safety Enforcement:**
To ensure robust Game Logic and prevent "magic array" bugs, all agents MUST follow these rules:

- **Strict Types:** Every PHP file must start with `declare(strict_types=1);`.
- **DTOs for Data Transfer:** NEVER pass associative arrays (e.g., `['hp' => 100]`) between Services. Use named DTOs.
    - *Example:* `Game\DTOs\DamageResult` instead of `array`.
- **Return Types:** All methods MUST declare return types. Use `void` if nothing returns.

**DTO Example:**

```php
namespace App\Game\DTOs;

final readonly class BossDamageResult
{
    public function __construct(
        public int $damageDealt,
        public int $remainingHp,
        public bool $isDefeated,
        public array $droppedLoots = []
    ) {}
}
```

### 2. Naming Patterns

**Database Naming Conventions:**
- **Tables:** `snake_case` plural (e.g., `game_enemies`, `gem_transactions`).
- **PK:** `id` (Auto-increment BigInt).
- **FK:** `singular_id` (e.g., `user_id`, `quest_id`).
- **Boolean:** `is_active`, `has_reward`.

**Code Naming Conventions:**
- **Classes:** `PascalCase` (e.g., `QuestService`).
- **Methods/Variables:** `camelCase` (e.g., `calculateReward`, `$currentUser`).
- **Livewire Components:**
    - Class: `App\Livewire\Quest\QuestList`
    - View: `resources/views/livewire/quest/quest-list.blade.php`
    - Tag: `<livewire:quest.quest-list />`

### 3. Structure Patterns

**Project Organization:**

- **Game Logic:** `app/Services/Game/*` (Pure logic, no HTTP).
- **Sync Logic:** `app/Services/Sync/*` (Google Sheets integration).
- **DTOs:** `app/Game/DTOs/*` (Shared data structures).
- **Events:** `app/Events/Game/*`.
- **Livewire Pages:** `app/Livewire/Pages/*` (Full screens).
- **Livewire Components:** `app/Livewire/Components/*` (Reusable UI widgets).

### 4. Communication Patterns (Event-Driven)

**Event System:**
- **Trigger:** Service Layer triggers events (NOT Controllers).
- **Naming:** `VerbObject` or `ObjectVerb`? -> **ObjectVerbPastTense**
    - *Good:* `TaskCompleted`, `BossDefeated`, `GemRewarded`.
    - *Bad:* `CompleteTask`, `UserGetGem`.

**State Management:**
- **Frontend:** Use Livewire properties for UI state.
- **Backend:** Database is the Single Source of Truth.
- **Session:** Minimal usage (Flash messages only).

### 5. Process Patterns

**Sync Process:**
1.  **Scheduler** calls `SyncService`.
2.  `SyncService` fetches Sheet Data.
3.  **Hash Check:** Compare `md5(row_content)` with DB.
4.  **If Changed:** Update DB -> `Event::dispatch(new RowUpdated($data))`.
5.  **Listeners** calculate game impact.

**Error Handling:**
- **Game Exceptions:** `App\Exceptions\Game\InsufficientGemException`.
- **UI Feedback:** Catch exceptions in Livewire -> `session()->flash('error', $e->getMessage())`.

### 6. Livewire Component Architecture

**Smart Components (`App\Livewire\Pages`):**
- **Mental Model:** "Controllers" of the frontend.
- **Responsibilities:**
  - Route handlers (Full Page Components).
  - Fetches initial data (Data Providers).
  - Orchestrates Events (Listens to `GameUpdated`).
- **Forbidden:** No complex HTML/CSS here. Delegate to Blade Components or Dump Components.
- **Example:** `HeroDashboardPage`, `WorldMapPage`.

**Dumb Components (`App\Livewire\Components` or Blade Components):**
- **Mental Model:** "Pure Functions" of UI.
- **Responsibilities:**
  - Receive `@props` / public properties.
  - Render UI (HP Bars, Cards, Lists).
  - Emit events up (e.g., `wire:click="$dispatch('attack')" `).
- **State:** Stateless or strictly local transient state (Alpine.js).
- **Logic:** Minimal. Only formatting logic allowed.
- **Example:** `HealthBar`, `TaskCard`, `Badge`.

**Data Flow:**
1. **Smart Page** fetches `User::find($id)` -> pass to **Dumb Component** `<x-hero-card :hero="$user" />`.
2. **Dumb Component** clicks button -> executes `$dispatch('hero-attack')`.
3. **Smart Page** listens `#[On('hero-attack')]` -> calls `GameService::attack()`.

### Enforcement Guidelines

**All AI Agents MUST:**
- Use `declare(strict_types=1)`.
- Use DTOs for multi-value returns.
- Write Unit Tests for all Game Logic.
- **Strictly separate** Logic (Service) from Presentation (Livewire).

**Verification:**
- Run `phpstan analyse` to check types.
- Run `pest` to verify logic.

## Project Structure & Boundaries

### Complete Project Directory Structure

```text
mcop-quest/
├── app/
│   ├── Actions/Game/           # Single Action Classes (Optional optimization)
│   ├── Console/Commands/       # Cron Commands (SyncSheets)
│   ├── Events/Game/            # Domain Events (BossDamaged, TaskCompleted)
│   ├── Exceptions/Game/        # Custom Exceptions (InsufficientFunds)
│   ├── Game/DTOs/              # Data Transfer Objects (Strict Typed)
│   │   ├── DamageResult.php
│   │   └── SyncResult.php
│   ├── Listeners/Game/         # Event Listeners (UpdateBossHP)
│   ├── Livewire/
│   │   ├── Components/         # Dumb Components (HealthBar, TaskCard)
│   │   └── Pages/              # Smart Components (Dashboard, WorldMap)
│   ├── Models/
│   │   ├── Core/               # Project, Epic, Story, Task (Management Data)
│   │   └── Game/               # GameCity, GameBoss, GameMinion (RPG Data)
│   ├── Services/
│   │   ├── Game/               # Game Mechanics (Calculator, Rules)
│   │   └── Sync/               # Google Sheets Logic
│   └── View/Components/        # Blade Components (Layouts, Atomic UI)
├── database/
│   ├── migrations/             # DB Schema
│   └── seeders/                # Initial Game Data
├── resources/
│   ├── css/                    # Tailwind CSS
│   └── views/
│       └── livewire/           # Component Views
        └── components/         # Blade Component Views
├── tests/
│   ├── Feature/Game/           # Logic Tests
│   └── Feature/Livewire/       # UI Interaction Tests
└── routes/
    ├── web.php                 # Web Routes (Auth guarded)
    └── console.php             # Scheduler Definitions
```

### Architectural Boundaries

**API Boundaries:**
- **Google Sheets API:** External boundary, accessed heavily via `SyncService` based on `revolution/laravel-google-sheets`.
- **Internal APIs:** No public API exposed initially.
- **Frontend-Backend:** Tightly coupled via Livewire, but logically separated by `GameService`.

**Component Boundaries:**
- **Smart Components (Pages):** Responsible for Data Fetching & Event Orchestration.
- **Dumb Components:** Responsible for Rendering & Event Emitting (Stateless).
- **Islands:** used for high-cost widgets (Leaderboards) to decouple them from main thread.

**Service Boundaries:**
- **GameService:** The ONLY place where Game Rules & Formulas live.
- **SyncService:** The ONLY place that talks to Google Sheets.
- **Models:** Should be distinct (Core vs Game) to allow replatforming of Core Data source later without breaking Game Logic.

**Data Boundaries:**
- **Core Models:** Read-only mostly (updated via Sync).
- **Game Models:** Read/Write heavily (updated via Game Logic).
- **Audit Logs:** Insert-only (Gem Transactions).

### Requirements to Structure Mapping

**Feature/Epic Mapping:**
- **Gamification Engine:** `app/Services/Game/GameEngine.php`
- **Sync Mechanism:** `app/Console/Commands/SyncSheetsCommand.php` & `app/Services/Sync/`
- **Role Integration:** `app/Http/Middleware/CheckRole.php` (if needed) or via Policy.
- **Economic System:** `app/Models/Game/GemTransaction.php`

**Cross-Cutting Concerns:**
- **Auth:** `app/Http/Controllers/Auth` (Breeze) + Socialite.
- **Logging:** `storage/logs/game.log` (Custom channel for Game Events).

### Integration Points

**Internal Communication:**
- **Sync -> Game:** Via `Domain Events` (`TaskCreated` event).
- **Frontend -> Game:** Via `Livewire Actions` calling `GameService`.
- **Game -> Frontend:** Via `Livewire Events` (`#[On('game-updated')]`) or Polling.

**External Integrations:**
- **Google Sheets:** Polling every 1 minute via Scheduler.
- **Google OAuth:** Login flow.

**Data Flow:**
1.  **Sync:** Sheet -> SyncService -> CoreModels -> Event -> GameService -> GameModels.
2.  **Action:** User Click -> Livewire -> GameService -> GameModels -> Event -> UI Refresh.

### File Organization Patterns

**Configuration Files:**
- `config/game.php`: Game rules constants (XP rates, Gold rates).
- `config/services.php`: Google API definitions.

**Source Organization:**
- Domain-Driven-Design lite: Grouping by `Game` and `Sync` domains within standard Laravel folders.

**Test Organization:**
- `tests/Feature/Game`: Testing the Math & Rules.
- `tests/Feature/Sync`: Testing the Sheet parsing (mocked).

### Development Workflow Integration

**Development Server Structure:**
- `npm run dev` (Vite) + `php artisan serve`.

**Build Process Structure:**
- `npm run build` generates optimized assets.

**Deployment Structure:**
- Standard Laravel Deployment (Nginx/Apache + PHP-FPM + Supervisor for Queue/Cron).

## Architecture Validation Results

### Coherence Validation ✅

**Decision Compatibility:**
- **Laravel 12 & Livewire 4:** Fully compatible. Livewire 4's new features (Islands) directly support the performance requirement for heavy dashboards.
- **Breeze Starter:** Provides the necessary lightweight base for our custom Role/Guild implementation without the overhead of Jetstream's Teams.
- **Sync Strategy:** The Scheduler approach avoids the complexity of Webhooks while ensuring the 1-minute interval requirement is met reliably on a single-tenant server.

**Pattern Consistency:**
- **Strict Typing & DTOs:** Ensures that the complex Game Data passing between Sync and Game layers remains robust and debuggable.
- **Event-Driven Arch:** Perfectly decouples the "Project Data" (Sheet Sync) from the "Game Reaction" (Battle Logic), preventing spaghetti code.

**Structure Alignment:**
- The proposed directory structure (`app/Game`, `app/Services/Sync`) physically enforces the logical boundaries we defined.

### Requirements Coverage Validation ✅

**Epic/Feature Coverage:**
- **Gamification:** Covered by `Game/Models` and `GameService`.
- **Sync:** Covered by `Console/Commands` and `SyncService`.
- **Dashboard:** Covered by `Livewire/Pages`.
- **Economics:** Covered by `GemTransaction` and Immutable Ledger pattern.

**Functional Requirements Coverage:**
- **Mappings:** The explicit `System->City`, `Flow->Boss` mapping is architecturally supported via the Schema Strategy.
- **Feedback/Animation:** While not fully detailed in code yet, the `Livewire Events` pattern provides the necessary triggers for frontend animations.

**Non-Functional Requirements Coverage:**
- **Performance:** Addressed via `Islands` implementation proposal for heavy widgets.
- **Reliability:** Cache layer in Sync Service addresses API availability.
- **Consistency:** Immutable Ledger guarantees financial data integrity.

### Implementation Readiness Validation ✅

**Decision Completeness:**
- Technology Stack: **FINAL** (Laravel 12, Livewire 4, MySQL).
- Patterns: **FINAL** (Strict Types, DTOs, Event-Driven).

**Structure Completeness:**
- Project Skeleton: **DEFINED**.
- File locations for all core logic: **MAPPED**.

**Pattern Completeness:**
- Communication flow (Sync -> Event -> Game -> UI) is clearly defined.

### Gap Analysis Results

**Priority 3 (Nice-to-Have / Implementation Details):**
- **Specific Animation Library:** We haven't picked a specific JS library for animations (e.g., GSAP vs Alpine transition), but strictly standard `Alpine` is sufficient for MVP.
- **Formula Implementation:** The exact math formulas need to be transcribed from the Rulebook to `GameRules.php` during the first Dev Story.

### Architecture Readiness Assessment

**Overall Status:** READY FOR IMPLEMENTATION

**Confidence Level:** HIGH

**Key Strengths:**
1.  **Clean Separation:** The "Loose Coupling" data strategy protects the game logic from changes in the Project Management structure (Google Sheets).
2.  **Modern Stack:** Using Livewire 4 ensures we are on the cutting edge of performance and DX.
3.  **Resilience:** The Event-Driven nature allows the game to react asynchronously to data changes, preventing sync timeouts.

### Implementation Handoff

**AI Agent Guidelines:**
- **Strict Types:** `declare(strict_types=1);` is NOT optional.
- **No Logic in Controllers:** All math/rules MUST go to `GameService`.
- **Livewire 4:** Use `#[On]` attributes for events and `<x-island>` for heavy components.

**First Implementation Priority:**
Initialize the Project Skeleton and install dependencies.
```bash
composer create-project laravel/laravel mcop-quest
cd mcop-quest
composer require laravel/breeze revolution/laravel-google-sheets --dev
php artisan breeze:install livewire --dark --pest
```
