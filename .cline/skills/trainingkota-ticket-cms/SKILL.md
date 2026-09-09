# Skill: trainingkota-ticket-cms

## Context
Triggered when implementing the support ticket system or inquiry management.

## Implementation Steps
1. **Ticket Flow**: Implement Submit -> Assign -> Resolve workflow.
2. **Admin View**: Create a ticket dashboard in `admin.layout`.
3. **Notifications**: Implement email/system notifications for status changes.
4. **Data Safety**: Ensure user data is handled securely.

## Constraints
- No hardcoded status options; use a DB table or Enum.
- Admin views must be dark mode.
