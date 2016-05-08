<?php
/*
The template for displaying Archive pages
*/
get_header(); ?>

<div class="container">
	<div id="main">
		<div id="content">
		<?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?>

		<header class="content-header">
			<h1 class="content-title"><?php echo birdSTAR::get_category_title(); ?></h1>
		</header>

		<?php if (have_posts()) : ?>
			<ul class="archive">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>
			</ul>
			<div class="tablenav"><?php BirdSTAR::the_pagenation(); ?></div>
		<?php else: ?>
			<p><?php _e( 'Sorry, no posts matched your criteria.', 'birdstar' ); ?></p>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #main -->

	<?php get_sidebar('left'); ?>

</div><!-- .container -->

<?php get_footer(); ?>
