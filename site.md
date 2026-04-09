# Site Maintenance Guide

This document is for someone familiar with WordPress who is maintaining the **Tennis Blast Kalynda Chase** website. It covers how to manage content specific to this site's structure.

## Accessing the Site

- **Production Admin:** [URL]/wp-admin
- **Login:** Use your own WordPress user account. Contact [team member] to create or reset an account.

## Content Structure

### Pages vs Posts

| Type | Used For |
|------|----------|
| Pages | Static content: Home, About, Contact, Services |
| Posts | [If used — e.g., News/Blog updates] |

This site does not use a blog. Do not publish posts — they will appear in unexpected locations.

### Site Pages

Based on the client's existing site (kctennisblast.com.au):

| Page | Purpose | Notes |
|------|---------|-------|
| Home | Landing page with hero, coach intro, and CTAs | Hero tagline: "BELIEVE - LEARN - ACHIEVE - SUCCEED" |
| Classes | Hot Shots, Squad Training, Private Classes, Tournament Travel | |
| Social Tennis | Social fixtures schedule and court hire info | Includes fixtures image |
| Contact | Contact form + court booking link | Links to play.tennis.com.au |

> Update this table as pages are confirmed with the client.

### Navigation Menus

The site uses the following menus, managed under **Appearance → Menus**:

| Menu | Location |
|------|----------|
| Primary Navigation | Header |
| Footer Links | Footer |

To add a page to the navigation: go to Appearance → Menus, select the menu, add the page, and save.

## Adding and Editing Content

### Editing a Page

1. Go to Pages → All Pages.
2. Click the page title to open the editor.
3. Edit content using the WordPress block editor.
4. Click **Update** to publish changes immediately.

### Adding Images

- Upload images via the Media Library or directly in the block editor.
- Use descriptive Alt Text for all images.
- Recommended image sizes: [e.g., Hero: 1920×800px, thumbnails: 800×600px]
- All images must be licensed for commercial use. [Describe your approved sources — e.g., Unsplash, client-supplied only]

### Featured Images

Pages that display a featured image (e.g., [page name]) require a Featured Image set in the right sidebar of the editor.

## Plugins

| Plugin | Purpose | How to Use |
|--------|---------|-----------|
| [Plugin name] | [e.g., Contact form] | [Brief instructions or link to site.md section] |
| [Plugin name] | [e.g., SEO] | [Brief instructions] |

> Do not install additional plugins without consulting the development team.

## Categories and Taxonomy

[If posts/categories are used:]

Posts are organised by the following categories:

| Category | Description |
|----------|-------------|
| [Category] | [Description] |

To assign a category: open the post editor and select a category in the right sidebar under **Categories**.

[If not used:]
Categories are not used on this site.

## Theme Customizer

Some site-wide settings are managed via **Appearance → Customize**:

| Setting | Location in Customizer |
|---------|----------------------|
| Site logo | Site Identity |
| Hero image | [Section name, if applicable] |
| [Other settings] | [Location] |

## What Not to Change

- Do not modify **Appearance → Theme File Editor** — all theme edits go through the development workflow described in `deployment.md`.
- Do not update WordPress core or plugins without first testing on staging.
- Do not delete or rename pages that are linked in menus — update the menu first.
