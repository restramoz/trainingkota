# Skill: trainingkota-public-routing

## Context
Triggered when defining or modifying public-facing routes, slugs, and URL structures.

## Implementation Steps
1. **Route Definition**: Use `routes/web.php` with clear naming conventions.
2. **Slug Handling**: Implement Route Model Binding using `slug` instead of `id`.
3. **Fallback**: Implement 404 handling for missing slugs.
4. **Verification**: Run `php artisan route:list` to ensure no collisions.

## Constraints
- Ensure geographic context (cities) is preserved in URLs.
- No hardcoded paths in Blade views; use `route()` helper.
