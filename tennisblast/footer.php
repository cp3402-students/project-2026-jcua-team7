<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tennisblast
 */

$tennisblast_phone       = get_theme_mod( 'tennisblast_phone' );
$tennisblast_email       = get_theme_mod( 'tennisblast_email' );
$tennisblast_facebook    = get_theme_mod( 'tennisblast_facebook_url' );
$tennisblast_booking_url = get_theme_mod( 'tennisblast_booking_url' );
?>

	<footer id="colophon" class="site-footer">
		<div class="footer-inner">

			<!-- Column 1: Branding -->
			<div class="footer-col footer-brand">
				<?php if ( has_custom_logo() ) : ?>
					<div class="footer-logo"><?php the_custom_logo(); ?></div>
				<?php else : ?>
					<p class="footer-site-name"><?php bloginfo( 'name' ); ?></p>
				<?php endif; ?>
				<p class="footer-tagline"><?php bloginfo( 'description' ); ?></p>
				<?php if ( $tennisblast_facebook ) : ?>
					<a href="<?php echo esc_url( $tennisblast_facebook ); ?>" class="footer-social" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Follow us on Facebook', 'tennisblast' ); ?>
					</a>
				<?php endif; ?>
			</div><!-- .footer-brand -->

			<!-- Column 2: Quick Links -->
			<div class="footer-col footer-links">
				<h3 class="footer-heading"><?php esc_html_e( 'Quick Links', 'tennisblast' ); ?></h3>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-2',
						'menu_id'        => 'footer-menu',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
				?>
			</div><!-- .footer-links -->

			<!-- Column 3: Contact -->
			<div class="footer-col footer-contact">
				<h3 class="footer-heading"><?php esc_html_e( 'Contact Us', 'tennisblast' ); ?></h3>
				<ul class="footer-contact-list">
					<?php if ( $tennisblast_phone ) : ?>
						<li>
							<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $tennisblast_phone ) ); ?>">
								<?php echo esc_html( $tennisblast_phone ); ?>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( $tennisblast_email ) : ?>
						<li>
							<a href="mailto:<?php echo esc_attr( $tennisblast_email ); ?>">
								<?php echo esc_html( $tennisblast_email ); ?>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( $tennisblast_booking_url ) : ?>
						<li>
							<a href="<?php echo esc_url( $tennisblast_booking_url ); ?>" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'Book a Court Online', 'tennisblast' ); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div><!-- .footer-contact -->

		</div><!-- .footer-inner -->

		<div class="footer-bottom">
			<div class="footer-bottom-inner">
				<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'tennisblast' ); ?></p>
			</div>
		</div><!-- .footer-bottom -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
