<?php
/*
The Template for displaying all single posts.
*/
get_header(); ?>

<div class="container">
	<div id="main">
		<div id="content">
			<?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'content', get_post_format() ); ?>
		<div id="rakuten"></div>
		<?php comments_template( '', true ); ?>
	</article>

	<nav id="nav-below">
		<span class="nav-next"><?php next_post_link('%link', '%title'); ?></span>
		<span class="nav-previous"><?php previous_post_link('%link', '%title'); ?></span>
	</nav>

<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #main -->

	<?php get_sidebar('left'); ?>

</div><!-- .container -->

<?php get_footer(); ?>
