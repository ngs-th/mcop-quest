# MCOP Quest - Code Style & Conventions

## PHP Conventions
- **Standard:** Laravel Pint (follows PSR-12)
- **Namespace:** `App\` prefix for all application code
- **Class Names:** PascalCase
- **Method Names:** camelCase
- **Property Names:** camelCase (prefer snake_case for database columns)
- **Type Hints:** Use strict typing where possible (PHP 8.2+)

## Database Conventions
- **Table Names:** plural, snake_case
- **Model Names:** singular, PascalCase
- **Migration Names:** descriptive with timestamp prefix
- **Foreign Keys:** `{table}_id` format

## Livewire Conventions
- **Component Classes:** PascalCase, stored in `app/Livewire/`
- **Component Views:** kebab-case, stored in `resources/views/livewire/`
- **Pages:** `app/Livewire/Pages/` with corresponding views
- **Forms:** `app/Livewire/Forms/` for form objects

## CSS/Tailwind Conventions
- **Utility First:** Prefer Tailwind utilities over custom CSS
- **Custom Classes:** Use when utilities become unwieldy
- **Color Scheme:** Follow project color palette (retro 90s RPG theme)

## File Organization
```
app/
├── Console/Commands/     # Artisan commands
├── Http/Controllers/     # HTTP controllers (minimal usage with Livewire)
├── Livewire/
│   ├── Actions/          # Livewire actions (Logout, etc.)
│   ├── Components/       # Reusable components
│   ├── Forms/            # Form objects
│   └── Pages/            # Page components
├── Models/               # Eloquent models
├── Services/
│   ├── Game/             # Game logic (RiskService, GameService)
│   └── Sync/             # Data sync (CsvImportService, GoogleSheetService)
└── View/Components/      # Blade components
```
