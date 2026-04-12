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
- **CSS:** Mobile-first. Custom properties (CSS variables) defined in `:root` in `style.css` under the `/* Design Tokens */` section — use these for all colours, never hardcode hex values in component rules.
- **SCSS:** Source files in `sass/`. Compiled output is `style.css`. Variables are in `sass/abstracts/variables/`. Do not edit `style.css` structure sections directly — edit the relevant SCSS partial and recompile.
- **JavaScript:** Vanilla JS only. Scripts registered in `functions.php` via `wp_enqueue_scripts`. Navigation toggle is in `js/navigation.js`.
- **Template tags:** Custom template tag functions live in `inc/template-tags.php`.
- **No hard-coded content:** All text, IDs, and URLs are pulled from WordPress or theme mods — never written directly into template files.

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
| Mobile-first CSS | Primary audience is parents searching for kids' activities on phones |
| No page builder (no Elementor/Nicepage) | Assignment requirement; keeps theme fully portable and reusable |
| Dark forest green `#1b4d1b` as primary colour | Directly from the "TENNIS BLAST" logo wordmark — ensures brand consistency |
| Lime green `#6cc44a` as accent | Taken from the logo swoosh gradient highlight |
| Red `#c0392b` for CTA buttons | Taken from the Head Coach shirt and brand signage starburst — creates strong contrast against green and draws the eye to primary actions |
| Gold `#f5c518` as highlight colour | Taken from the yellow/gold burst background on the client's physical signage |
| Near-black green `#0f2410` for header and footer | Dark version of the primary green — keeps header/footer on-brand without using a generic navy or black |
| All content via WordPress, not templates | Theme reusability requirement — enables markers to test with Theme Unit Test Data |
| Hero image and booking URL via Customizer | Keeps site-specific config out of code; a new site using this theme can set its own hero |

## Non-Obvious Behaviour

- The homepage hero image, tagline, subtitle, button text, and court booking URL are all set via **Appearance → Customize → Homepage Settings** — they are not in the page editor.
- Navigation menus must be assigned after theme activation: **Appearance → Menus** — assign "Primary Navigation" to the Header location and "Footer Links" to the Footer location.
- The footer logo is rendered with `filter: brightness(0) invert(1)` in CSS so the dark green logo appears white on the dark footer background — do not replace the logo file with a white version.
- The `front-page.php` template is only used when a static front page is set in **Settings → Reading → Your homepage displays → A static page**. Without this setting, WordPress falls back to `index.php`.
- Red (`--color-cta`) is intentionally reserved for primary action buttons only — do not use it for decorative elements, as it would dilute its attention-drawing effect.

## Theme Test Data

To verify reusability, test the theme using the [WordPress Theme Unit Test data](https://codex.wordpress.org/Theme_Unit_Test):

1. Download the XML from the link above.
2. Import via Tools → Import → WordPress.
3. Check that all standard post types, page templates, and edge cases render correctly.
