# Deployment

This document describes our development and deployment workflow. A new team member should be able to follow these instructions from scratch, make a change, and push it through all three environments.

## Environments

| Environment | Purpose | URL |
|-------------|---------|-----|
| Local | Active development | http://localhost:8080 |
| Staging | Review before going live | [URL — fill in] |
| Production | Live public site | [URL — fill in] |

Changes flow: **Local → Staging → Production**. Never edit files directly on staging or production.

## Workflow Summary

We use GitHub Flow: all changes happen on a feature branch, reviewed via pull request, merged to `main`. Deployments to staging and production are triggered from `main`.

---

## Local Environment Setup

**Requirements:** [Docker Desktop](https://www.docker.com/products/docker-desktop/) installed and running.

1. Clone the repository:
   ```bash
   git clone https://github.com/cp3402-students/project-2026-jcua-team7.git
   cd project-2026-jcua-team7
   ```

2. Copy the environment file:
   ```bash
   cp .env.example .env
   ```
   The defaults in `.env` work as-is for local development. Do not commit `.env`.

3. Start the containers:
   ```bash
   docker compose up -d
   ```

4. Open http://localhost:8080 and complete the WordPress installation (takes ~30 seconds on first run).
   - Site title: Tennis Blast
   - Create an admin username and password of your choice (local only)

5. In WordPress Admin → Appearance → Themes, activate **Tennis Blast**.

6. Import the site content: go to Tools → Import → WordPress, and import `docs/client-content/tennis-blast-content.docx` [or the XML export once one exists].

7. Assign menus under Appearance → Menus if they are not set automatically.

**phpMyAdmin** is available at http://localhost:8081 (user: `wordpress`, password: `wordpress`).

To stop the environment:
```bash
docker compose down
```

To stop and delete all data (fresh install):
```bash
docker compose down -v
```

---

## Making and Committing Changes

All theme files live in `tennisblast/`. WordPress core is not in this repo.

1. Create a branch:
   ```bash
   git checkout -b feature/short-description
   ```

2. Edit files in `tennisblast/`. Changes appear immediately at http://localhost:8080 — no restart needed.

3. Test your changes (see [Testing](#testing)).

4. Stage and commit with a clear, imperative-mood message:
   ```bash
   git add tennisblast/
   git commit -m "Add hero banner template to front-page.php"
   ```

5. Push and open a pull request to `main`:
   ```bash
   git push origin feature/short-description
   ```

6. Get at least one team member to review the PR before merging.

---

## Testing

Before pushing to staging, verify:

- [ ] Theme activates without errors on a clean WordPress install (`docker compose down -v && docker compose up -d`)
- [ ] All pages render correctly at http://localhost:8080
- [ ] No PHP errors or warnings in the browser (debug mode is on by default in Docker)
- [ ] Responsive layout works at mobile (375px), tablet (768px), and desktop (1280px)
- [ ] No hard-coded URLs, IDs, or client-specific text in template files
- [ ] Theme Unit Test Data passes (see `theme.md` for instructions)

---

## Deployment to Staging

[Describe your chosen deployment method once the staging server is set up — e.g., FTP, SSH rsync, or a plugin like WP Pusher]

Example steps (update once decided):
1. Merge your PR to `main`.
2. Deploy the `tennisblast/` theme folder to the staging server's `wp-content/themes/` directory.
3. Verify the change at the staging URL.
4. Post confirmation in the team Slack/Discord channel.

---

## Deployment to Production

Production deploys only after the team has reviewed and approved the staging version.

1. Confirm staging approval in the team channel.
2. Deploy to production using the same method as staging, pointing at the production server.
3. Verify the live site.
4. Post confirmation in the team channel.

---

## Project Management Integration

- Project board: https://trello.com/b/69bfd3fe/cp3402-2026-1-project
- Before starting any task, move the Trello card to **In Progress** and assign yourself.
- Reference the card in your PR description.
- Move the card to **Done** when the change is live on staging.

## Communication

Team communication happens in [Slack channel / Discord — fill in link]. Post updates when you start a branch, open a PR, or deploy to staging or production.
