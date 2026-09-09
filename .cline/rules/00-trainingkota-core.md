# TRAININGKOTA CORE RULES

## 1. EXECUTION & COMMAND RULES (CRITICAL)
- **NO POWERSHELL -replace or PIPING for file edits**: Always use native `write_to_file` or `replace_in_file` tools.
- **Atomic Tasks**: 1 Task = 1 Atomic Objective. Do not work on more than one large file/module per turn.
- **Laravel Verification**: Always run `php artisan route:list` or verify PHP syntax after modifying `routes/web.php` or Controllers.
- **No Brute Force**: If errors occur twice consecutively, STOP and ask for clarification.

## 2. DATABASE & DATA SAFETY
- **No Structural Changes**: Forbidden to delete or change existing table structures without explicit instruction.
- **Protected Records**: DO NOT delete existing records in `cities` (212), `services` (62), and `locations`.
- **Backups**: SQLite backups and `database/trainingkota.sql` MUST NOT be deleted.
- **No Fabricated Data**: Do not create local statistical data, map coordinates, or fake addresses. All facts must come from the DB.
- **Migration Safety**: No `php artisan migrate:fresh` or `migrate:refresh` on shared/production-like environments. Use additive migrations.

## 3. CTA & CONTACT
- **Official Phone**: Must use `config('contact.phone')` which points to `08118500177`.
- **No Hardcoding**: Hardcoding dummy phone numbers (e.g., `08123456789`) in Blade views is strictly forbidden.

## 4. CONTENT & AI RULES
- **AI-Generated Content**: Must NEVER be auto-published. All AI content must be saved with `status = 'draft'`.
- **Manual Review**: Only human authors/admins can review and publish content.

## 5. DESIGN & UI STANDARDS
- **Admin Layout**: All Admin CMS pages must use `@extends('admin.layout')`.
- **Admin Theme (Dark Mode)**:
  - Main Background: `bg-[#070D18]`
  - Card/Container: `bg-[#0E1726]`
  - Border: `border-[#1E293B]`
  - Text: `text-[#F1F5F9]`

## 6. DOMAIN SPECIFIC RULES
- **Pelatihan**: Ensure schedules are DB-driven.
- **Jasa**: Ensure service categories align with `services` table.
- **Kajian**: Maintain academic/theological rigor and link to appropriate categories.
- **Geography**: Preserve city context in all geographic routes and content.

## 7. GENERAL ARCHITECTURE
- **Laravel 11 Standards**: Follow official Laravel 11 directory structure and coding patterns.
- **Database as Source of Truth**: Cities, services, articles, maps, and schedules must always be fetched from the database.
