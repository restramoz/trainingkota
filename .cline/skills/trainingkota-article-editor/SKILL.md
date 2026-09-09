# Skill: trainingkota-article-editor

## Context
Triggered when implementing the AI-assisted article editor or manual article management.

## Implementation Steps
1. **Draft Logic**: Ensure all AI-generated content is saved as `status = 'draft'`.
2. **Editor UI**: Implement a rich text editor compatible with `admin.layout`.
3. **Review Flow**: Create an admin interface for reviewing and publishing drafts.
4. **DB Integration**: Ensure articles are linked to correct categories and authors.

## Constraints
- AI content MUST NOT auto-publish.
- Strictly follow the `status` field logic.
