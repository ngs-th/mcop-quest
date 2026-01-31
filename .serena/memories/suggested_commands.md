# MCOP Quest - Suggested Commands

## Development Server
```bash
# Start all development services (concurrently)
composer run dev

# Or run individually
php artisan serve          # Laravel server
npm run dev                # Vite dev server
php artisan queue:listen   # Queue worker
php artisan pail           # Log tailing
```

## Build & Deployment
```bash
# Install dependencies
composer install
npm install

# Build for production
npm run build

# Full setup (fresh install)
composer run setup
```

## Database
```bash
# Run migrations
php artisan migrate

# Fresh migrate with seeding
php artisan migrate:fresh --seed

# Run specific migration
php artisan migrate --path=database/migrations/2026_01_29_034524_create_flows_table.php
```

## Testing
```bash
# Run all tests
composer run test
# OR
php artisan test

# Run specific test suite
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature

# Run with Pest directly
./vendor/bin/pest
```

## Code Quality
```bash
# Run Laravel Pint (lint & fix)
./vendor/bin/pint

# Check only (no fix)
./vendor/bin/pint --test
```

## Artisan Commands (Custom)
```bash
# Sync quest data from Google Sheets
php artisan quest:sync

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## Utility Commands
```bash
# Check Laravel version
php artisan --version

# List all routes
php artisan route:list

# Tinker (interactive shell)
php artisan tinker

# Generate application key
php artisan key:generate
```

## Git Commands
```bash
# Standard git workflow
git status
git add <files>
git commit -m "message"
git push

# Check recent commits
git log --oneline -10
```
