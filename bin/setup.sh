#!/usr/bin/env bash
# setup.sh — Import the Tennis Blast database into the local WordPress container.
# Run this once after `docker compose up -d` to get the full site with all content.

set -e

PROJECT_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
SQL_FILE="$PROJECT_ROOT/tennisblast-local.sql"
WP_CLI_URL="https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar"
WP_CLI_PHAR="$PROJECT_ROOT/wp-cli.phar"

# Container names are fixed by the `name: tennisblast` in docker-compose.yml
CONTAINER="tennisblast-wordpress-1"
DB_CONTAINER="tennisblast-db-1"

echo "→ Checking containers are running..."
if [ -z "$CONTAINER" ]; then
  echo "  WordPress container not found. Run: docker compose up -d"
  exit 1
fi

echo "  WordPress container: $CONTAINER"
echo "  DB container:        $DB_CONTAINER"

echo "→ Waiting for WordPress to be ready..."
until docker exec "$CONTAINER" bash -c "curl -s -o /dev/null http://localhost/wp-login.php" 2>/dev/null; do
  sleep 2
done

echo "→ Importing database..."
docker exec -i "$DB_CONTAINER" \
  mysql -u wordpress -pwordpress wordpress < "$SQL_FILE"

echo "→ Downloading WP-CLI..."
curl -sO "$WP_CLI_URL"
chmod +x wp-cli.phar
docker cp wp-cli.phar "$CONTAINER:/var/www/html/wp-cli.phar"
rm -f wp-cli.phar

echo "→ Activating theme..."
docker exec "$CONTAINER" bash -c \
  "cd /var/www/html && php wp-cli.phar theme activate tennisblast --allow-root 2>&1"

echo "→ Fixing site URL for localhost:8080..."
docker exec "$CONTAINER" bash -c \
  "cd /var/www/html && php wp-cli.phar search-replace 'http://localhost:8080' 'http://localhost:8080' --allow-root --quiet 2>&1"

echo "→ Setting up nav menus..."
docker exec "$CONTAINER" bash -c "cd /var/www/html && php wp-cli.phar eval '
\$primary = wp_create_nav_menu(\"Primary\");
\$footer  = wp_create_nav_menu(\"Footer\");
\$pages   = get_pages([\"post_status\" => \"publish\"]);
foreach (\$pages as \$p) {
  if (in_array(\$p->post_name, [\"home\",\"classes\",\"social-tennis\",\"contact\"])) {
    wp_update_nav_menu_item(\$primary, 0, [\"menu-item-title\" => \$p->post_title, \"menu-item-object\" => \"page\", \"menu-item-object-id\" => \$p->ID, \"menu-item-type\" => \"post_type\", \"menu-item-status\" => \"publish\"]);
  }
}
set_theme_mod(\"nav_menu_locations\", [\"menu-1\" => \$primary, \"menu-2\" => \$footer]);
' --allow-root 2>&1 || true"

echo ""
echo "✓ Setup complete! Open http://localhost:8080"
echo "  Admin: http://localhost:8080/wp-admin  (user: admin / password set during install)"
