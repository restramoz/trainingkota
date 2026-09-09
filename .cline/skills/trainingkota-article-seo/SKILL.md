# Skill: trainingkota-article-seo

## Context
Triggered when implementing SEO optimization for articles, including meta tags, slugs, and keyword analysis.

## Implementation Steps
1. **Schema**: Ensure `articles` table has `meta_title`, `meta_description`, and `slug`.
2. **Automation**: Implement slug generation from titles.
3. **Validation**: Ensure SEO fields are provided before publishing.
4. **UI**: Add SEO configuration section in the article editor.

## Constraints
- No hardcoded slugs.
- Slugs must be unique and URL-friendly.
