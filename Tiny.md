TINYMCE AGENT BUILD — LARAVEL 11 + BLADE

TRAININGKOTA.MY.ID

You are modifying an existing Laravel 11 application called TrainingKota.

Your task is to integrate TinyMCE Cloud Editor into the existing Laravel Blade Article Create/Edit forms.

---

1. CRITICAL PROJECT CONTEXT

This is NOT a React project.

This is NOT a Vue project.

This is NOT a standalone Vite application.

The application uses:

- Laravel 11
- PHP
- Blade templates
- Vite for asset bundling
- Existing Laravel controllers/routes/models
- Existing Article CRUD
- Existing TrainingKota admin UI
- Existing TrainingKota dark UI design

TinyMCE must be integrated into the existing Laravel/Blade architecture.

DO NOT convert the project to React, Vue, Next.js, Nuxt, or another frontend framework.

DO NOT rebuild the Article CRUD.

DO NOT replace the existing Laravel architecture.

---

2. PRIMARY OBJECTIVE

Implement TinyMCE Cloud Editor for the existing Article content field.

The TinyMCE integration must work on:

1. Article Create page
2. Article Edit page

The existing article content must:

- load into TinyMCE when editing
- remain editable
- submit correctly through the existing Laravel form
- persist to the existing database field
- display correctly on the Article frontend page

Use the existing article field/database structure.

DO NOT rename the existing database column unless absolutely required.

DO NOT create a second content system.

---

3. TINYMCE API KEY

A TinyMCE API key already exists.

DO NOT ask the developer to create another API key.

Use the provided TinyMCE API key through the project's appropriate configuration/environment mechanism.

Preferred approach:

- Keep secrets/configuration out of hardcoded application logic where practical.
- If the current project already has an environment/config convention, follow that convention.
- Do not expose unrelated secrets.
- Do not commit private credentials into source control.

If TinyMCE Cloud requires the API key in the frontend initialization, use the appropriate TinyMCE Cloud integration mechanism.

Do not invent an API key.

If the existing API key is already configured somewhere in the project, reuse it.

---

4. IMPORTANT: PRESERVE EXISTING UI

The TrainingKota UI is already substantially finished.

The following areas are considered LOCKED:

- Homepage
- Kota pages
- Kecamatan pages
- Pelatihan/service pages
- FAQ
- Q&A
- Article frontend layout
- Existing admin sidebar
- Existing admin navigation
- Existing responsive behavior
- Existing dark theme
- Existing typography
- Existing spacing system
- Existing buttons
- Existing cards
- Existing Alpine.js components

DO NOT redesign these areas.

DO NOT introduce a new design system.

DO NOT replace Tailwind configuration.

DO NOT globally modify typography.

DO NOT globally modify colors.

DO NOT modify unrelated layouts.

Only make changes required for the Article editor integration.

---

5. ARTICLE FORM REQUIREMENTS

Find the existing Article Create and Article Edit forms.

Identify the current content textarea/editor field.

Use that existing field as the TinyMCE target.

Example concept:

<textarea id="content" name="content">
    ...
</textarea>

The exact existing field name must be detected from the project.

DO NOT assume the field is named "content" if the project uses another name.

Preserve:

- "name"
- "id"
- Laravel validation
- "old(...)"
- existing model value
- existing form action
- existing method
- CSRF
- validation error handling

---

6. TINYMCE INITIALIZATION

Initialize TinyMCE only on pages where the Article editor exists.

Do NOT initialize TinyMCE globally on every page.

Use a reliable selector based on the existing Article form.

Example:

tinymce.init({
    selector: '#content',
    ...
});

But first inspect the actual Blade markup and use the correct selector.

The initialization must be safe if the editor is not present.

Example logic:

if (document.querySelector('#content')) {
    tinymce.init({
        ...
    });
}

Do not create duplicate TinyMCE instances.

If the script can execute more than once, ensure the editor is not initialized repeatedly.

---

7. LARAVEL + BLADE COMPATIBILITY

The implementation must respect Blade.

Do not use React JSX.

Do not use Vue SFC.

Do not create a Node-only editor application.

Vite may be used for JavaScript assets because Laravel already uses Vite.

However:

TinyMCE integration must remain compatible with the current Laravel Blade rendering model.

The final implementation should work with:

Laravel
    ↓
Blade
    ↓
Existing Article Form
    ↓
TinyMCE Cloud
    ↓
Textarea/Form submission
    ↓
Laravel Controller
    ↓
Article Model
    ↓
Database

---

8. CONTENT SUBMISSION

Ensure TinyMCE content is submitted with the Laravel form.

TinyMCE normally synchronizes editor content with the underlying textarea, but verify this behavior.

If necessary, explicitly synchronize content before form submission.

Example:

form.addEventListener('submit', function () {
    tinymce.triggerSave();
});

Do not blindly add this if TinyMCE already handles the submission correctly.

Verify the actual behavior.

The Laravel controller must receive the HTML content.

---

9. EDIT PAGE CONTENT

This is critical.

On Article Edit:

Existing content must appear inside TinyMCE.

Do not lose existing HTML.

For example:

<textarea name="content" id="content">{{ old('content', $article->content) }}</textarea>

Use the project's existing Blade implementation instead of blindly replacing it.

If the project already uses:

{!! old('content', $article->content) !!}

or another mechanism, inspect it carefully.

Prevent HTML from being incorrectly escaped or corrupted.

---

10. VALIDATION ERROR / OLD INPUT

If Laravel validation fails:

old(...)

content must remain available.

The TinyMCE editor must display the old submitted content instead of becoming empty.

Test:

1. Open Create Article
2. Enter content
3. Trigger validation failure
4. Return to form
5. Verify TinyMCE still contains the submitted content

Also test Edit Article.

---

11. TINYMCE FEATURES

Configure TinyMCE as a practical article editor.

The editor should support normal article-writing needs.

Recommended functionality:

- Bold
- Italic
- Underline
- Strikethrough
- Headings
- Paragraph
- Blockquote
- Ordered list
- Unordered list
- Links
- Image
- Table
- Code/preformatted content
- Horizontal rule
- Undo
- Redo
- Clear formatting
- Alignment
- Search/replace if available
- Fullscreen if available
- Source/code view if available in the selected configuration

Do not enable unnecessary enterprise-only functionality.

Respect the current TinyMCE plan/API configuration.

If a plugin or feature requires a paid license and is unavailable, do not create a broken configuration.

Use only features compatible with the current TinyMCE Cloud/free configuration.

---

12. TOOLBAR

Create a clean toolbar suitable for TrainingKota article authors.

Prefer a practical toolbar instead of an enormous toolbar.

Example structure:

undo redo |
blocks |
bold italic underline |
alignleft aligncenter alignright |
bullist numlist |
link image table |
blockquote |
removeformat |
code fullscreen

Adjust according to the actual TinyMCE version and available plugins.

Do not use deprecated plugin names.

Use the syntax appropriate for the installed/current TinyMCE version.

---

13. CONTENT STYLING

The editor must be comfortable for writing Indonesian educational/business articles.

Support:

- H2
- H3
- H4
- paragraphs
- lists
- links
- images
- tables
- blockquotes
- code/preformatted blocks when needed

Do not allow the editor to completely break the TrainingKota visual system.

Use content CSS appropriate for the editor.

If TinyMCE supports "content_css", "content_style", or equivalent, use the least invasive approach.

The editor should visually fit the TrainingKota dark admin interface.

---

14. DARK MODE

TrainingKota uses a dark visual design.

TinyMCE should visually fit the existing dark admin UI where practical.

Do not globally force the entire website into a different theme.

Only style the TinyMCE editor area.

If TinyMCE's supported skin/content configuration allows a dark appearance, use the appropriate configuration.

If the current TinyMCE plan/version does not provide a required dark skin, create a minimal local editor styling solution rather than modifying the entire application's theme.

---

15. RESPONSIVE BEHAVIOR

The editor must work on:

- desktop
- tablet
- mobile

This project is heavily used from mobile development environments, so avoid layouts that overflow horizontally.

The toolbar should remain usable on small screens.

Use TinyMCE's supported responsive behavior.

Do not add a fixed width that breaks the existing form.

---

16. IMAGE HANDLING

First inspect the existing Laravel Article system.

Determine whether the project already has:

- image upload
- media storage
- public storage
- article featured images
- existing upload endpoints

DO NOT invent a second image-storage architecture.

If TinyMCE image insertion can work using the existing infrastructure, integrate with it.

If the project does NOT currently have an article-image upload endpoint:

DO NOT create a complicated backend upload system unless it is explicitly required.

At minimum, support inserting images by URL if that is compatible with the current TinyMCE configuration.

Do not upload images to arbitrary third-party services without explicit project requirements.

---

17. SECURITY

This is a Laravel application.

Article content contains HTML.

Do not blindly disable all security protections.

Inspect how article content is currently sanitized and rendered.

Do not introduce:

- arbitrary server-side file execution
- unsafe upload handling
- unrestricted filesystem access
- XSS vulnerabilities
- unsafe iframe injection
- arbitrary JavaScript execution

Do not add:

allow_html_injection = true

or equivalent dangerous configuration simply to make the editor work.

Preserve the existing application's security model.

---

18. FRONTEND ARTICLE COMPATIBILITY

The existing Article frontend already renders article content.

The TinyMCE-generated HTML should remain compatible with it.

Pay particular attention to:

<h2>
<h3>
<p>
<ul>
<ol>
<li>
<a>
<img>
<table>
<blockquote>
<pre>
<code>

Do not modify the Article frontend renderer unless required.

Do not redesign the Article page.

---

19. VITE REQUIREMENTS

Inspect the existing:

package.json
vite.config.*
resources/js/
resources/css/

before making changes.

Do not blindly install unnecessary npm packages.

TinyMCE Cloud can be loaded using its supported Cloud script/API approach.

Do not install a React-specific TinyMCE integration.

Do not install Vue-specific TinyMCE integration.

Do not replace the existing Vite configuration.

If JavaScript needs to be added:

Prefer an existing project JS entrypoint.

Example:

resources/js/app.js

or the project's existing equivalent.

Follow the current project structure.

---

20. DEPENDENCY RULE

Before installing anything:

1. Inspect package.json.
2. Inspect existing dependencies.
3. Determine whether TinyMCE is already installed.
4. Determine whether the project already loads TinyMCE.
5. Avoid duplicate dependencies.

Do not run unnecessary:

npm install

with unrelated packages.

Do not upgrade Laravel.

Do not upgrade PHP.

Do not upgrade Node.

Do not upgrade Tailwind.

Do not change unrelated package versions.

---

21. BLADE LAYOUT

Inspect the Article Create/Edit Blade templates and their parent layouts.

Determine whether scripts are loaded using:

@vite(...)

or:

@stack('scripts')

or another existing mechanism.

Follow the existing architecture.

If the project already provides:

@push('scripts')

use that rather than introducing a new layout architecture.

Do not duplicate TinyMCE scripts across multiple templates if a shared solution is cleaner.

---

22. API KEY HANDLING

The TinyMCE API key already exists.

Use the provided key.

Do not replace it.

Do not create placeholder text such as:

YOUR_API_KEY

in the final implementation.

If the key is stored in ".env", follow Laravel's appropriate environment/configuration pattern.

Remember:

Vite environment variables exposed to the browser are not secrets.

The TinyMCE Cloud API key is intended for client-side use, but server secrets must remain server-side.

Do not expose unrelated credentials.

---

23. DO NOT TOUCH THESE

Unless absolutely necessary, do not modify:

app/Models/
app/Http/Controllers/
routes/
database/
resources/views/
resources/css/
tailwind.config.*
vite.config.*
package.json
composer.json

Only modify files directly related to the Article editor integration.

If a controller modification is required, make the smallest possible change.

If the existing Article controller already accepts and saves HTML content correctly, DO NOT modify it.

---

24. EXISTING ARTICLE CRUD MUST REMAIN FUNCTIONAL

Verify:

CREATE

Open Create Article
↓
TinyMCE loads
↓
Write article
↓
Submit
↓
Laravel validation
↓
Article saved
↓
Frontend displays content

EDIT

Open Edit Article
↓
Existing content appears in TinyMCE
↓
Modify content
↓
Submit
↓
Laravel updates article
↓
Frontend displays updated content

VALIDATION FAILURE

Submit invalid form
↓
Laravel redirects back
↓
old input preserved
↓
TinyMCE displays old content

---

25. ALPINE.JS COMPATIBILITY

TrainingKota already uses Alpine.js in several UI components.

Do not replace Alpine.js.

Do not initialize TinyMCE in a way that breaks Alpine components.

If the Article form exists inside an Alpine component, inspect the component before initialization.

If required, initialize TinyMCE after Alpine has rendered the relevant DOM.

Do not globally interfere with Alpine.

---

26. TURBO / PJAX / SPA-LIKE NAVIGATION

Inspect whether the current TrainingKota admin uses:

- Turbo
- Livewire
- HTMX
- PJAX
- Alpine navigation
- normal full-page navigation

Do not assume.

If normal Laravel Blade navigation is used, implement the simple initialization.

If dynamic navigation is used, ensure TinyMCE instances are cleaned up properly before the page is replaced.

Do not introduce a SPA framework.

---

27. CODE QUALITY

The implementation must be:

- minimal
- maintainable
- Laravel-compatible
- Blade-compatible
- responsive
- accessible
- secure
- easy to debug

Use clear variable names.

Avoid unnecessary abstraction.

Avoid duplicated initialization code.

Avoid giant inline scripts if an existing JS module is appropriate.

---

28. DEBUGGING

After implementation, inspect for:

- JavaScript console errors
- TinyMCE initialization errors
- invalid plugin names
- invalid toolbar items
- API key errors
- CSP errors
- Vite build errors
- Blade syntax errors
- duplicate editor initialization
- form submission problems
- content escaping problems

If TinyMCE fails to load, identify the actual cause instead of masking the error.

---

29. REQUIRED TESTS

Run the appropriate project checks.

At minimum:

php artisan optimize:clear

Then:

npm run build

If project tests are available, run the relevant tests.

Do not alter unrelated failures.

If "npm run build" fails because of an existing unrelated problem, identify it clearly.

Do not hide failures.

---

30. BROWSER VERIFICATION

Verify these scenarios:

Test A — Create Article

- Open Article Create
- Editor appears
- Toolbar works
- Type formatted content
- Add heading
- Add list
- Add link
- Submit
- Confirm database content saved
- Confirm frontend content renders

Test B — Edit Article

- Open existing Article
- Existing HTML appears
- Modify text
- Add formatting
- Save
- Confirm updated content

Test C — Validation

- Submit invalid Article
- Return to form
- Confirm TinyMCE content is preserved

Test D — Mobile

Check editor on narrow viewport.

Confirm:

- no horizontal page overflow
- toolbar usable
- content area usable
- submit button remains accessible

---

31. AGENT SAFETY LOCK

THIS IS EXTREMELY IMPORTANT.

You are working inside an existing production-oriented Laravel project.

Before changing anything:

1. Inspect the existing implementation.
2. Understand the current architecture.
3. Make the smallest necessary change.
4. Preserve existing functionality.
5. Do not refactor unrelated code.

NEVER:

- migrate Laravel to React
- migrate Blade to Vue
- replace Tailwind
- replace Alpine.js
- rewrite Article CRUD
- rewrite admin layout
- rewrite Article frontend
- change database schema unnecessarily
- rename Article fields
- remove existing routes
- remove existing controllers
- remove existing CSS
- replace existing Vite architecture
- install unnecessary packages
- upgrade unrelated dependencies
- delete existing functionality
- modify Kota/Kecamatan functionality
- modify Pelatihan functionality
- modify FAQ/Q&A functionality

If something is already working, LEAVE IT ALONE.

---

32. CHANGE SCOPE

The expected scope is:

ARTICLE CREATE
ARTICLE EDIT
       ↓
TINYMCE CLOUD
       ↓
EXISTING LARAVEL FORM
       ↓
EXISTING ARTICLE DATABASE
       ↓
EXISTING ARTICLE FRONTEND

Nothing else.

---

33. FINAL REPORT

When implementation is complete, provide a concise report containing:

Files changed

List every file changed.

What changed

Explain the TinyMCE integration.

Dependencies

List any dependency added.

If none were added, explicitly state:

No new npm/composer dependency required.

API Key

Confirm the existing TinyMCE API key configuration was reused.

Do NOT print the actual API key.

Article Create

State whether Create works.

Article Edit

State whether Edit works.

Validation

State whether old content is preserved after validation failure.

Build

Report:

npm run build

result.

Laravel

Report:

php artisan optimize:clear

result.

Unrelated changes

Confirm whether any unrelated project areas were modified.

---

34. FINAL SUCCESS CRITERIA

The task is considered complete only when:

- TinyMCE loads on Article Create.
- TinyMCE loads on Article Edit.
- Existing Article content loads correctly.
- TinyMCE content submits through Laravel.
- HTML content is saved correctly.
- Validation errors preserve content.
- Article frontend renders the generated HTML correctly.
- Mobile layout remains usable.
- Existing TrainingKota UI remains unchanged outside the Article editor.
- No React/Vue migration occurs.
- No unnecessary dependency is introduced.
- "npm run build" succeeds or any pre-existing unrelated failure is clearly reported.
- Laravel cache/configuration is cleared successfully.
- No API key is exposed in the final report.

FINAL RULE:

Inspect first. Modify minimally. Preserve everything that already works.