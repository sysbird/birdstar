<?php
/*
The template for displaying Archive pages
*/
get_header(); ?>

<div class="container">
	<div id="main">
		<div id="content">

		<header class="content-header">
			<h1 class="content-title"><?php
				if(is_category()) {
					printf(__('Category Archives: %s', 'birdsnap'), single_cat_title('', false));
				}
				elseif( is_tag() ) {
					printf(__('Tag Archives: %s', 'birdsnap'), single_tag_title('', false) );
				}
				elseif (is_day()) {
					printf(__('Daily Archives: %s', 'birdsnap'), get_post_time(get_option('date_format')));
				}
				elseif (is_month()) {
					printf(__('Monthly Archives: %s', 'birdsnap'), get_post_time(__('F, Y', 'birdsnap')));
				}
				elseif (is_year()) {
					printf(__('Yearly Archives: %s', 'birdsnap'), get_post_time(__('Y', 'birdsnap')));
				}
				elseif (is_author()) {
					printf(__('Author Archives: %s', 'birdsnap'), get_the_author_meta('display_name', get_query_var('author')) );
				}
				elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
					_e('Blog Archives', 'birdsnap');
				}
			?></h1>
		</header>

		<?php if (have_posts()) : ?>
			<ul class="article">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>
			</ul>
			<div class="tablenav"><?php BirdSNAP::the_pagenation(); ?></div>
		<?php else: ?>
			<p><?php _e( 'Sorry, no posts matched your criteria.', 'birdsnap' ); ?></p>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #main -->

	<?php get_sidebar('left'); ?>

</div><!-- .container -->

<?php get_footer(); ?>
