# Deployment

This document describes our development and deployment workflow. A new team member should be able to follow these instructions from scratch, get an identical local site, make a change, and push it through all three environments.

## Environments

| Environment | Purpose | URL |
|-------------|---------|-----|
| Local | Active development | http://localhost:8080 |
| Staging | Review before going live | http://209.38.23.24:8080 |
| Production | Live public site | http://170.64.239.20:8080 |

Changes flow: **Local → Staging → Production**. Never edit files directly on staging or production.

| Branch     | Deploys to     | Purpose                                        |
| ---------- | -------------- | ---------------------------------------------- |
| `feature/*`| Local only     | Active development — each dev works here       |
| `staging`  | Staging server | Integration and review before going live       |
| `main`     | Production     | Live public site — only merged from `staging`  |

**Rules:**

- Never commit directly to `staging` or `main`
- All new work starts as a `feature/` branch off `staging`
- Open a PR from your feature branch into `staging` for team review
- Once staging is verified, open a PR from `staging` into `main` to go live

---

## Local Environment Setup

**Requirements:** [Docker Desktop](https://www.docker.com/products/docker-desktop/) installed and running.

### First-time setup

1. Clone the repository:
   ```bash
   git clone https://github.com/cp3402-students/project-2026-jcua-team7.git
   cd project-2026-jcua-team7
   ```

2. Start the containers:
   ```bash
   docker compose up -d
   ```

3. Run the setup script:
   ```bash
   bash bin/setup.sh
   ```
   This script:
   - Waits for WordPress to be ready
   - Imports `tennisblast-local.sql` (all pages, content, theme settings)
   - Installs WordPress core with shared credentials (`admin` / `password`)
   - Activates the `tennisblast` theme
   - Sets up navigation menus

4. Open http://localhost:8080 — you should see the full Tennis Blast site.
   Log in at http://localhost:8080/wp-admin with username `admin` and password `password`.

> **Media files** are tracked in `content/uploads/` and mounted automatically by Docker Compose. No manual upload step needed.

**phpMyAdmin** is available at http://localhost:8081 (user: `wordpress`, password: `wordpress`).

### Stopping and restarting

```bash
# Stop containers (data is preserved)
docker compose down

# Start again — no setup needed, data persists in Docker volumes
docker compose up -d

# Full reset (wipes all data and re-provisions from scratch)
docker compose down -v && docker compose up -d && bash bin/setup.sh
```

---

## Making and Committing Changes

All theme files live in `tennisblast/`. Changes appear live at http://localhost:8080 without restarting Docker.

1. Create a branch:
   ```bash
   git checkout -b feature/short-description
   ```

2. Edit files in `tennisblast/`. Save and refresh the browser to see changes.

3. If you upload new images or change WordPress content (pages, menus, theme mods), export the database and commit it:
   ```bash
   docker compose exec db \
     mysqldump -u wordpress -pwordpress wordpress \
     --ignore-table=wordpress.wp_users \
     --ignore-table=wordpress.wp_usermeta \
     > tennisblast-local.sql
   git add tennisblast-local.sql content/uploads/
   git commit -m "Update database export with new content"
   ```

4. Commit theme file changes:
   ```bash
   git add tennisblast/
   git commit -m "Add hero banner to front-page.php"
   ```

5. Push and open a pull request to `staging`:
   ```bash
   git push origin feature/short-description
   ```

6. Get at least one team member to review the PR before merging.

---

## Testing

Before pushing to staging, verify:

- [ ] Theme activates without errors on a clean install
- [ ] All pages render correctly at http://localhost:8080
- [ ] No PHP errors or warnings in the browser (debug mode is on in Docker)
- [ ] Responsive layout works at mobile (375px), tablet (768px), and desktop (1280px)
- [ ] No hard-coded URLs, IDs, or client-specific text in template files

---

## Deployment to Staging

[Fill in once AWS Lightsail is set up]

Planned approach:
1. Merge PR to `main`.
2. SSH into the staging server and pull the latest theme files.
3. Import `tennisblast-local.sql` on the staging database.
4. Run `wp search-replace 'http://localhost:8080' 'https://staging-url'` to fix URLs.
5. Verify the change at the staging URL.

---

## Deployment to Production

Production deploys only after the team has reviewed and approved the staging version.

1. Confirm staging approval in the team channel.
2. Repeat the staging deploy steps pointing at the production server.
3. Verify the live site.

---

## Project Management

- Project board: https://trello.com/b/69bfd3fe/cp3402-2026-1-project
- Before starting any task, move the Trello card to **In Progress** and assign yourself.
- Reference the Trello card in your PR description.
- Move the card to **Done** when the change is live on staging.
