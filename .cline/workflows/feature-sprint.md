# Feature Sprint Workflow

## Objective
Implement a new feature from design/spec to verification.

## Process
1. **Analysis**: Inspect existing models, controllers, and routes.
2. **Planning**: Define DB changes (additive), Route additions, and UI requirements.
3. **Implementation**:
   - Create/Update Migrations (Additive only).
   - Implement Model logic.
   - Create Controller methods.
   - Create Blade views using `@extends('admin.layout')` for CMS.
4. **Verification**: 
   - Run `php artisan route:list` to verify routing.
   - Test functionality via browser/tool.
5. **Cleanup**: Remove temporary debug logs.
