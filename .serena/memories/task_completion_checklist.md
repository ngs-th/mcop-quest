# MCOP Quest - Task Completion Checklist

When completing a task, ensure the following:

## Code Quality
- [ ] Code follows Laravel Pint standards (run `./vendor/bin/pint`)
- [ ] No syntax errors or warnings
- [ ] Proper type hints used where applicable
- [ ] Meaningful variable and method names

## Testing
- [ ] Existing tests still pass (`composer run test`)
- [ ] New features have corresponding tests (Pest PHP)
- [ ] Edge cases are covered

## Database
- [ ] Migrations are reversible
- [ ] Seeders updated if needed
- [ ] No breaking changes to existing data

## Livewire Components
- [ ] Component renders without errors
- [ ] Actions work as expected
- [ ] Validation rules are in place
- [ ] Proper error handling

## Frontend
- [ ] Responsive design works on mobile
- [ ] No console errors
- [ ] Assets compile successfully (`npm run build`)

## Documentation
- [ ] Complex logic is documented
- [ ] PRD/Architecture updated if needed
- [ ] API changes documented

## Before Commit
- [ ] `.env` changes not committed (use `.env.example`)
- [ ] No debug code left in place
- [ ] Commit message is descriptive
