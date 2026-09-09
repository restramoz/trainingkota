# Pre-Commit Verification Hook

## Objective
Final gate before committing changes to ensure zero regressions in core rules.

## Final Audit
- [ ] **No Fresh Migrations**: Confirmed no `migrate:fresh` used.
- [ ] **No Hardcoding**: Confirmed no dummy data in views.
- [ ] **Admin Layout**: All new CMS views follow the layout and theme.
- [ ] **AI Status**: No AI content was auto-published.
- [ ] **DB Integrity**: No records in `cities`, `services`, or `locations` were deleted.
- [ ] **Routing**: Routes are verified and functional.
