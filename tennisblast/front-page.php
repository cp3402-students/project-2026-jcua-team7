<?php
/**
 * The front page template
 *
 * Displays the homepage with hero, page content, and court booking CTA.
 * All content is managed through WordPress — hero via Customizer,
 * body content via the page editor.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tennisblast
 */

get_header();

$hero_tagline     = get_theme_mod( 'tennisblast_hero_tagline' );
$hero_subtitle    = get_theme_mod( 'tennisblast_hero_subtitle' );
$hero_button_text = get_theme_mod( 'tennisblast_hero_button_text', __( 'Get Started', 'tennisblast' ) );
$hero_image       = get_theme_mod( 'tennisblast_hero_image' );
$booking_url      = get_theme_mod( 'tennisblast_booking_url' );
?>

<main id="primary" class="site-main">

	<?php /* Hero Section */ ?>
	<section class="hero<?php echo $hero_image ? ' hero--has-image' : ''; ?>"
		<?php if ( $hero_image ) : ?>
			style="background-image: url('<?php echo esc_url( $hero_image ); ?>');"
		<?php endif; ?>>

		<div class="hero-overlay" aria-hidden="true"></div>

		<div class="hero-content">
			<?php if ( $hero_tagline ) : ?>
				<h1 class="hero-tagline"><?php echo esc_html( $hero_tagline ); ?></h1>
			<?php endif; ?>

			<?php if ( $hero_subtitle ) : ?>
				<p class="hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
			<?php endif; ?>

			<?php if ( $booking_url ) : ?>
				<a href="<?php echo esc_url( $booking_url ); ?>"
					class="btn-hero"
					target="_blank"
					rel="noopener noreferrer">
					<?php echo esc_html( $hero_button_text ); ?>
				</a>
			<?php endif; ?>
		</div><!-- .hero-content -->

	</section><!-- .hero -->

	<?php /* Page content — coaches, about text, etc. added via WordPress editor */ ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php if ( get_the_content() ) : ?>
			<section class="home-content">
				<div class="home-content-inner">
					<?php the_content(); ?>
				</div>
			</section>
		<?php endif; ?>
	<?php endwhile; endif; ?>

	<?php /* Court Booking CTA Strip */ ?>
	<?php if ( $booking_url ) : ?>
		<section class="cta-strip">
			<div class="cta-strip-inner">
				<div class="cta-strip-text">
					<h2 class="cta-strip-heading"><?php esc_html_e( 'Ready to Play?', 'tennisblast' ); ?></h2>
					<p><?php esc_html_e( 'Only 10 courts available · 24/7 booking', 'tennisblast' ); ?></p>
				</div>
				<a href="<?php echo esc_url( $booking_url ); ?>"
					class="btn-cta"
					target="_blank"
					rel="noopener noreferrer">
					<?php esc_html_e( 'Hire a Court Now', 'tennisblast' ); ?>
				</a>
			</div><!-- .cta-strip-inner -->
		</section><!-- .cta-strip -->
	<?php endif; ?>

</main><!-- #primary -->

<?php get_footer(); ?>
