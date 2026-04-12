# Theme Developer Guide

This document explains the custom WordPress theme to a developer taking over or contributing to the project.

## Overview

**Theme name:** Tennis Blast (`tennisblast`)
**Based on:** [Underscores (_s)](https://underscores.me/) starter theme
**WordPress version:** 6.7+
**Text domain:** `tennisblast`

The theme was built from Underscores (_s) and customised for Tennis Blast Kalynda Chase. It is designed to be reusable — it contains no hard-coded site-specific content. All client text and media is managed through WordPress content.

## Installing the Theme

1. Zip the `tennisblast/` folder.
2. In WordPress Admin, go to Appearance → Themes → Add New → Upload Theme.
3. Upload the zip and activate.

The theme requires no plugins to function. Optional recommended plugins: [list if any].

## Key Files and Structure

```
tennisblast/
├── style.css               # Theme header and base styles (required by WordPress)
├── style-rtl.css           # RTL stylesheet (from _s, kept for standards compliance)
├── functions.php           # Theme setup, enqueue scripts/styles, custom functions
├── index.php               # Fallback template
├── header.php              # Site header and navigation
├── footer.php              # Site footer
├── front-page.php          # Homepage template (create this — takes priority over index.php)
├── page.php                # Default page template
├── single.php              # Single post template
├── archive.php             # Archive template
├── search.php              # Search results template
├── 404.php                 # 404 page
├── comments.php            # Comments template
├── sidebar.php             # Sidebar (currently registered, can remove if unused)
├── template-parts/         # Reusable partials (loop in these via get_template_part)
│   ├── content.php         # Post content partial
│   ├── content-none.php    # No results partial
│   ├── content-page.php    # Page content partial
│   └── content-search.php  # Search result partial
├── inc/                    # PHP includes (loaded by functions.php)
│   ├── customizer.php      # Theme Customizer settings
│   ├── template-functions.php
│   └── template-tags.php   # Custom template tag functions
├── sass/                   # SCSS source files
│   ├── style.scss          # Main entry point
│   └── ...
└── js/
    ├── customizer.js
    └── navigation.js       # Mobile navigation toggle
```

> Update this as new templates and partials are added.

## Conventions

- **PHP:** Follows [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/). Tabs for indentation.
- **CSS:** [Describe your approach — e.g., BEM naming, mobile-first, SCSS]
- **JavaScript:** [Vanilla JS / jQuery — describe approach and where scripts are registered]
- **Template tags:** Custom template tags live in `inc/template-tags.php`.
- **No hard-coded content:** All text, IDs, and URLs are pulled from WordPress or defined via constants/options.

## Adding a New Template

1. Create `template-[name].php` in the theme root.
2. Add the template comment header:
   ```php
   <?php
   /**
    * Template Name: [Name]
    */
   ```
3. Use `get_header()`, `get_footer()`, and `get_template_part()` to compose the template.
4. Assign the template to a page in WordPress Admin → Page Attributes.

## Enqueueing Scripts and Styles

All scripts and styles are registered in `functions.php` using `wp_enqueue_scripts`. Do not use `<link>` or `<script>` tags directly in templates.

## Design Decisions

| Decision | Rationale |
|----------|-----------|
| [e.g., Mobile-first CSS] | [e.g., Majority of client's audience is on mobile] |
| [e.g., No page builder] | [Assignment requirement; keeps theme portable] |
| [Add decisions as the project progresses] | |

## Design Decisions

We used green colours to match the tennis theme.
Simple fonts are used for readability.
The layout is clean and easy for users to navigate.
## Non-Obvious Behaviour

- [e.g., The homepage hero image is set via the Customizer under "Homepage Settings"]
- [e.g., Navigation menus must be assigned in Appearance → Menus after theme activation]
- [Add notes here as you discover them]

## Theme Test Data

To verify reusability, test the theme using the [WordPress Theme Unit Test data](https://codex.wordpress.org/Theme_Unit_Test):

1. Download the XML from the link above.
2. Import via Tools → Import → WordPress.
3. Check that all standard post types, page templates, and edge cases render correctly.
