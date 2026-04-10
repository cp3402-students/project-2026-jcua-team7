<?php
/**
 * The header for the Tennis Blast theme
 *
 * Displays the <head> section, site branding, and primary navigation.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tennisblast
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'tennisblast' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="header-inner">

			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) :
					the_custom_logo();
				else :
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-text" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				<?php endif; ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'tennisblast' ); ?>">

				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'tennisblast' ); ?></span>
					<span class="menu-icon" aria-hidden="true">&#9776;</span>
				</button>

				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'container'      => 'ul',
					)
				);
				?>

				<?php
				$booking_url = get_theme_mod( 'tennisblast_booking_url' );
				if ( $booking_url ) :
					?>
					<a href="<?php echo esc_url( $booking_url ); ?>" class="btn-book-court" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Book a Court', 'tennisblast' ); ?>
					</a>
				<?php endif; ?>

			</nav><!-- #site-navigation -->

		</div><!-- .header-inner -->
	</header><!-- #masthead -->
