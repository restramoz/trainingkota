# CMS CRUD Workflow

## Objective
Establish or modify a Content Management System (CMS) module.

## Process
1. **DB Schema**: Identify necessary tables. Ensure no existing records in `cities`, `services`, or `locations` are touched.
2. **Controller Implementation**:
   - `index()`: List records with pagination.
   - `create()`/`store()`: Form and validation.
   - `edit()`/`update()`: Modification.
   - `destroy()`: Soft deletes preferred.
3. **View Implementation**:
   - Use `@extends('admin.layout')`.
   - Implement dark mode styles (`bg-[#070D18]`, etc.).
   - No hardcoded data; all fields must be dynamic.
4. **Validation**:
   - Enforce strict Request validation.
   - Ensure AI content is saved as `draft`.
5. **Verification**: Verify CRUD operations in the browser.
