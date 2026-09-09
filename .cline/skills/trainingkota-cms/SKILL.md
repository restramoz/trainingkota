# Skill: trainingkota-cms

## Context
Triggered when creating, modifying, or managing CMS modules for TrainingKota.

## Implementation Steps
1. **Audit**: Check `database/migrations` for existing structures.
2. **CRUD Logic**: Implement standard Laravel Controller CRUD.
3. **UI Standard**: Apply `admin.layout` and dark mode CSS.
4. **Data Safety**: Ensure no hardcoded strings for services/cities.
5. **Verification**: Test the full lifecycle (Create -> Read -> Update -> Delete).

## Constraints
- Forbidden to use hardcoded data.
- Admin views must be dark mode.
- No `migrate:fresh`.
