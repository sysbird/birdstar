<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.0
 */
get_header(); ?>

<div id="content" class="site-content">
	<div class="container">
		<div id="primary" class="content-area">

		<?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'content', get_post_format() ); ?>
		<?php comments_template( '', true ); ?>
	</article>

	<?php if( is_single() && !is_singular( 'maker' ) ): ?>
		<nav id="nav-below">
			<span class="nav-next"><?php next_post_link('%link', '%title'); ?></span>
			<span class="nav-previous"><?php previous_post_link('%link', '%title'); ?></span>
		</nav>
	<?php endif; ?>

<?php endwhile; ?>

		</div><!-- /primary -->

		<?php get_sidebar(); ?>

	</div>
</div><!-- /content -->

<?php get_footer(); ?>
