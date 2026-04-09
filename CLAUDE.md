# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

CP3402 Group Assignment — custom WordPress theme for **Tennis Blast Kalynda Chase** (kctennisblast.com.au), a tennis coaching program in North Queensland. Repo contains the WordPress theme only; core is not tracked.

- GitHub: https://github.com/cp3402-students/project-2026-jcua-team7
- Trello: https://trello.com/b/69bfd3fe/cp3402-2026-1-project

## Repository Structure

```
/
├── README.md           # Project overview and links
├── deployment.md       # Workflow and deployment instructions
├── theme.md            # Theme developer documentation
├── site.md             # Site maintainer documentation
├── docker-compose.yml  # Local dev environment (WordPress + MySQL + phpMyAdmin)
├── .env.example        # Environment variable template (copy to .env, never commit)
├── .gitignore
├── Project.html        # Assignment submission template (fill in before submitting)
├── docs/
│   ├── assignment-brief.pdf
│   └── client-content/ # Client-supplied text, images, and logos
└── tennisblast/        # The WordPress theme (built from Underscores _s)
```

## Local Dev Commands

```bash
# Start environment (WordPress at localhost:8080, phpMyAdmin at localhost:8081)
docker compose up -d

# Stop environment
docker compose down

# Stop and wipe all data (fresh install)
docker compose down -v

# View logs
docker compose logs -f wordpress
```

Theme files in `tennisblast/` are live-mounted into the container — edits appear immediately without restarting Docker.

## Theme: tennisblast

Built from [Underscores (_s)](https://underscores.me/). Theme slug: `tennisblast`. Text domain: `tennisblast`.

**Key rules:**
- No hard-coded URLs, IDs, or client-specific content in templates — everything managed through WordPress
- All scripts/styles registered in `functions.php` via `wp_enqueue_scripts` — no `<link>` or `<script>` in templates
- Use `get_template_part()` for reusable partials in `template-parts/`
- Custom functions prefixed `tennisblast_` (e.g., `tennisblast_setup()`)
- WordPress PHP Coding Standards — tabs for indentation

## Workflow

Local → Staging → Production via GitHub Flow (feature branches → PR to `main`). See `deployment.md`.

## Site Pages (from client content)
- **Home** — hero with tagline "BELIEVE - LEARN - ACHIEVE - SUCCEED", coaches section, CTAs
- **Classes** — Hot Shots (kids), Squad Training, Private Classes, Tournament Travel
- **Social Tennis** — fixtures schedule, court hire info
- **Contact** — form + link to play.tennis.com.au booking
