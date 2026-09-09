# Verify Release Workflow

## Objective
Ensure the implementation meets all core rules before final commit.

## Checklist
- [ ] **Database**: No `migrate:fresh` used. No protected records deleted.
- [ ] **Hardcoding**: No dummy phone numbers. All CMS data is in DB.
- [ ] **UI**: Admin pages use `@extends('admin.layout')` and the specified dark mode palette.
- [ ] **AI Logic**: AI content is set to `status = 'draft'`.
- [ ] **Routing**: `php artisan route:list` shows no conflicts.
- [ ] **CTA**: `config('contact.phone')` is used for all contact points.
- [ ] **Context**: City/Geography context is preserved.
