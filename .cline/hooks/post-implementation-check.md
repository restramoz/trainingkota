# Post-Implementation Check Hook

## Objective
Verify that the implementation adheres to the project's strict operational foundation.

## Verification Steps
1. **UI Check**:
   - Does the Admin page use `@extends('admin.layout')`?
   - Is the dark mode palette (`#070D18`, `#0E1726`, `#1E293B`, `#F1F5F9`) applied?
2. **Logic Check**:
   - Is all CMS data fetched from the DB?
   - Is the CTA phone number sourced from `config('contact.phone')`?
   - Is AI content saved as `draft`?
3. **System Check**:
   - Run `php artisan route:list`. Are there any errors or unexpected routes?
   - Check for any accidental hardcoded dummy data.
