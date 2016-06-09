<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage BirdSTAR
 * @since BirdSTAR 1.0
 */
get_header(); ?>

<div id="content" class="site-content">
	<div class="container">
		<div id="primary" class="content-area">

		<article class="hentry">

	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Error 404 - Not Found', 'birdstar' ); ?></h1>
	</header>

	<div class="entry-content">
		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'birdstar' ); ?></p>
	</div>

		</article>

		</div><!-- /primary -->

		<?php get_sidebar(); ?>

	</div>
</div><!-- /content -->

<?php get_footer(); ?>