#!/usr/bin/env bash
# setup.sh — Provision the local WordPress site.
# Run once after `docker compose up -d`.

set -e

PROJECT_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
SQL_FILE="$PROJECT_ROOT/tennisblast-local.sql"
WP_CLI_URL="https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar"

cd "$PROJECT_ROOT"

echo "→ Checking containers are running..."
WP_CONTAINER="$(docker compose ps -q wordpress)"
DB_CONTAINER="$(docker compose ps -q db)"
if [ -z "$WP_CONTAINER" ] || [ -z "$DB_CONTAINER" ]; then
  echo "  Containers not found. Run: docker compose up -d"
  exit 1
fi

echo "→ Waiting for WordPress to be ready..."
until docker compose exec -T wordpress curl -s -o /dev/null http://localhost/wp-login.php 2>/dev/null; do
  sleep 2
done

echo "→ Importing database..."
docker compose exec -T db mysql -u wordpress -pwordpress wordpress < "$SQL_FILE"

echo "→ Downloading WP-CLI..."
curl -sfo wp-cli.phar "$WP_CLI_URL"
chmod +x wp-cli.phar
docker cp wp-cli.phar "$WP_CONTAINER":/var/www/html/wp-cli.phar
rm -f wp-cli.phar

WP="docker compose exec -T wordpress php /var/www/html/wp-cli.phar --allow-root"

echo "→ Installing WordPress core..."
$WP core install \
  --url="http://localhost:8080" \
  --title="Tennis Blast" \
  --admin_user="admin" \
  --admin_password="password" \
  --admin_email="admin@localhost.local" \
  --skip-email 2>/dev/null || true

echo "→ Ensuring admin account..."
if $WP user get admin > /dev/null 2>&1; then
  $WP user update admin --user_pass="password" --user_email="admin@localhost.local"
else
  $WP user create admin admin@localhost.local --user_pass="password" --role=administrator
fi

echo "→ Activating theme..."
$WP theme activate tennisblast

echo "→ Setting up nav menus..."
$WP eval '
$primary_menu = wp_get_nav_menu_object("Primary");
$footer_menu  = wp_get_nav_menu_object("Footer");
$primary = $primary_menu ? $primary_menu->term_id : wp_create_nav_menu("Primary");
$footer  = $footer_menu  ? $footer_menu->term_id  : wp_create_nav_menu("Footer");
$existing_items = wp_get_nav_menu_items($primary);
if ($existing_items) {
  foreach ($existing_items as $item) { wp_delete_post($item->ID, true); }
}
$ordered_slugs = ["home", "classes", "social-tennis", "contact"];
$position = 1;
foreach ($ordered_slugs as $slug) {
  $page = get_page_by_path($slug);
  if (!$page) { continue; }
  wp_update_nav_menu_item($primary, 0, [
    "menu-item-title"     => $page->post_title,
    "menu-item-object"    => "page",
    "menu-item-object-id" => $page->ID,
    "menu-item-type"      => "post_type",
    "menu-item-status"    => "publish",
    "menu-item-position"  => $position,
  ]);
  $position++;
}
$locations = get_theme_mod("nav_menu_locations", []);
$locations["menu-1"] = $primary;
$locations["menu-2"] = $footer;
set_theme_mod("nav_menu_locations", $locations);
' || true

echo ""
echo "✓ Setup complete!"
echo "  Site:  http://localhost:8080"
echo "  Admin: http://localhost:8080/wp-admin"
echo "  User:  admin / password"
