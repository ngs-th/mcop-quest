# MCOP Quest - Tech Stack

## Backend
- **Framework:** Laravel 12.x (PHP 8.2+)
- **Authentication:** Laravel Breeze + Google OAuth2 (via `google/apiclient`)
- **Frontend Components:** Livewire 4.0 + Volt 1.7
- **Database:** SQLite (development), MySQL/PostgreSQL (production ready)
- **Queue:** Database/Sync (configurable)

## Frontend
- **Build Tool:** Vite 7.x
- **CSS Framework:** Tailwind CSS 3.x + @tailwindcss/forms
- **Styling:** PostCSS + Autoprefixer
- **HTTP Client:** Axios

## Testing
- **Framework:** Pest PHP 4.3
- **Laravel Plugin:** pestphp/pest-plugin-laravel 4.0

## Code Quality
- **Linter:** Laravel Pint 1.24
- **Editor Config:** .editorconfig

## Key Directories
- `app/Livewire/` - Livewire components (Pages, Components, Forms, Actions)
- `app/Services/Game/` - Game logic services
- `app/Services/Sync/` - Data synchronization services
- `app/Console/Commands/` - Artisan commands (SyncQuestData)
- `resources/views/` - Blade templates
- `docs/` - PRD, wireframes, CSV data files
