<?php
/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tennisblast
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php while ( have_posts() ) : the_post(); ?>

		<header class="page-hero<?php echo has_post_thumbnail() ? ' page-hero--has-image' : ''; ?>"
			<?php if ( has_post_thumbnail() ) : ?>
				style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( null, 'full' ) ); ?>');"
			<?php endif; ?>>
			<div class="page-hero-overlay" aria-hidden="true"></div>
			<div class="page-hero-content">
				<h1 class="page-hero-title"><?php the_title(); ?></h1>
			</div>
		</header><!-- .page-hero -->

		<div class="page-content-wrap">
			<div class="page-content-inner">
				<?php get_template_part( 'template-parts/content', 'page' ); ?>
			</div>
		</div>

	<?php endwhile; ?>

</main><!-- #primary -->

<?php get_footer(); ?>
