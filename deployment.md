# Deployment

This document describes the development and deployment workflow for the Tennis Blast Kalynda Chase project. A new team member should be able to follow these instructions from scratch, get an identical local site, make a change, and push it through all three environments.

## Environments

| Environment | Purpose                  | URL                               |
| ----------- | ------------------------ | --------------------------------- |
| Local       | Active development       | <http://localhost:8080>           |
| Staging     | Review before going live | [URL: fill in once AWS is set up] |
| Production  | Live public site         | [URL: fill in once AWS is set up] |

Changes flow in one direction: **Local → Staging → Production**. Never edit files directly on staging or production.

---

## Workflow Convention

We use **GitHub Flow**: short-lived feature branches, pull request reviews, and a linear promotion path through staging to production.

### Branching Strategy

| Branch      | Deploys to     | Purpose                                       |
| ----------- | -------------- | --------------------------------------------- |
| `feature/*` | Local only     | All new work, one branch per issue            |
| `docs/*`    | Local only     | Documentation-only changes                    |
| `staging`   | Staging server | Integration and team review before going live |
| `main`      | Production     | Live public site, only merged from `staging`  |

**Rules:**

- Never commit directly to `staging` or `main`
- All new work starts as a `feature/` branch off `staging`
- Every PR requires at least one teammate approval before merging. No self-merges.

### Why GitHub Flow

We evaluated several approaches before settling on GitHub Flow:

| Approach                                          | Why we did not choose it                                                                                                  |
| ------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------- |
| Direct push to `staging`                          | No review step; easy to break shared environments; individual contributions are not visible                               |
| Trunk-based development                           | Requires mature CI/CD infrastructure; high risk for a team working across a shared codebase                               |
| Gitflow (`develop`, `release`, `hotfix` branches) | Too heavyweight for a four-person team; the extra branches add process without meaningful benefit at this scale           |
| **GitHub Flow (chosen)**                          | Lightweight, clear review step, all contributions visible in PR history, well-suited to our team size and release cadence |

---

## Local Environment Setup

**Requirement:** [Docker Desktop](https://www.docker.com/products/docker-desktop/) installed and running.

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
   - Imports `tennisblast-local.sql` (all pages, content, and theme settings)
   - Installs WordPress core with shared credentials (`admin` / `password`)
   - Activates the `tennisblast` theme
   - Sets up navigation menus

4. Open <http://localhost:8080>. You should see the full Tennis Blast site.
   Log in at <http://localhost:8080/wp-admin> with username `admin` and password `password`.

> **Media files** are tracked in `content/uploads/` and mounted automatically by Docker Compose. No manual upload step needed.

**phpMyAdmin** is available at <http://localhost:8081> (user: `wordpress`, password: `wordpress`).

### Stopping and restarting

```bash
# Stop containers (data is preserved)
docker compose down

# Start again: no setup needed, data persists in Docker volumes
docker compose up -d

# Full reset (wipes all data and re-provisions from scratch)
docker compose down -v && docker compose up -d && bash bin/setup.sh
```

---

## The Development Loop

Task tracking and code changes are part of the same process. The steps below cover both together in order.

### 1. Pick a task on Trello

Open the [Trello board](https://trello.com/b/69bfd3fe/cp3402-2026-1-project) and choose a card from the Backlog that is not already assigned to someone. Assign yourself to the card and move it to **In Progress**.

### 2. Open a GitHub Issue

Open a GitHub Issue for the task. Assign it to yourself and apply a relevant label (`theme`, `docs`, `content`, `bug`). Note the issue number on the Trello card so the two stay linked.

### 3. Branch off `staging`

```bash
git checkout staging
git pull origin staging
git checkout -b feature/short-description
```

Use a short, descriptive name that reflects the issue (e.g. `feature/hero-banner`, `feature/contact-page`).

### 4. Make changes locally

All theme files live in `tennisblast/`. Changes appear live at <http://localhost:8080> without restarting Docker.

Commit regularly as you work. Small, focused commits are easier to review and easier to revert than one large commit at the end.

### 5. Write clear commit messages

Use the imperative mood. Describe what the commit does, not what you did.

```text
# Good
Add hero banner section to front-page.php
Fix mobile nav overflow on small screens
Update deployment.md with staging deploy steps

# Bad
updated stuff
fix
WIP
```

### 6. Export the database if content changed

If you added images, edited pages, or changed menus in WordPress, export the database and commit it:

```bash
docker compose exec db \
  mysqldump -u wordpress -pwordpress wordpress \
  --ignore-table=wordpress.wp_users \
  --ignore-table=wordpress.wp_usermeta \
  > tennisblast-local.sql
git add tennisblast-local.sql content/uploads/
git commit -m "Export database with updated content"
```

### 7. Open a pull request into `staging`

```bash
git push origin feature/short-description
```

Open a PR on GitHub from your branch into `staging`. In the PR description:

- Reference the issue: `Closes #12`
- Describe what changed and why
- Note anything specific the reviewer should check

Move the Trello card to **In Review**.

### 8. Review and approve

Assign at least one teammate as a reviewer. Reviewers should check:

- The change works on their local environment
- No hard-coded URLs, IDs, or client-specific content in templates
- Code follows WordPress coding standards (tabs for indentation, `tennisblast_` function prefix)
- Commit messages are clear and descriptive

### 9. Merge and verify on staging

Once approved, merge the PR into `staging`. Deploy to the staging server (see [Deployment to Staging](#deployment-to-staging)) and confirm the change looks correct there.

Move the Trello card to **Done**.

### 10. Promote to production

When the team is satisfied with staging, open a PR from `staging` into `main`. Get team sign-off, merge, and deploy to production.

---

## Testing Checklist

Before opening a PR, verify:

- [ ] Theme activates without errors on a clean install
- [ ] All pages render correctly at <http://localhost:8080>
- [ ] No PHP errors or warnings in the browser (debug mode is on in Docker)
- [ ] Responsive layout works at mobile (375px), tablet (768px), and desktop (1280px)
- [ ] No hard-coded URLs, IDs, or client-specific text in template files

---

## Deployment to Staging

[Fill in once AWS Lightsail is set up]

Planned approach:

1. Merge the feature PR into `staging`.
2. SSH into the staging server and pull the latest theme files.
3. Import `tennisblast-local.sql` into the staging database.
4. Run `wp search-replace 'http://localhost:8080' 'https://staging-url'` to fix URLs.
5. Verify the change at the staging URL.

---

## Deployment to Production

Production deploys only after the full team has reviewed and approved the staging version.

1. Confirm staging approval in the team channel.
2. Open a PR from `staging` into `main` and get sign-off.
3. Repeat the staging deploy steps pointing at the production server.
4. Verify the live site.

---

## Project Management

We use Trello to plan and track all work: <https://trello.com/b/69bfd3fe/cp3402-2026-1-project>

### Card Lifecycle

| Column      | Meaning                                |
| ----------- | -------------------------------------- |
| Backlog     | Tasks available to be picked up        |
| In Progress | Actively being worked on               |
| In Review   | PR open, waiting for teammate approval |
| Done        | Merged to `staging` and verified there |

### Workflow

1. **Pick a task.** Browse the Backlog column and choose a card that is not already assigned to someone.
2. **Assign yourself.** Add yourself as a member on the card before starting work.
3. **Move the card to In Progress.** Open a GitHub Issue for the task and note the issue number on the Trello card.
4. **Do the work.** Follow the development loop above, referencing the GitHub Issue in your PR (`Closes #12`).
5. **Move the card to In Review** when your PR is open and a reviewer has been assigned.
6. **Move the card to Done** once the PR has been reviewed, approved, merged to `staging`, and verified there.

A task is not complete until it has been reviewed and approved by at least one teammate. Merging your own PR without review is not permitted.
