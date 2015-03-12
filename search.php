<?php
/*
The template for displaying Search Results pages.
*/
get_header(); ?>

<div class="container">
	<div id="main">
		<div id="content">

		<header class="content-header">
		<h1 class="content-title"><?php printf(__('Search Results: %s', 'birdstar'), esc_html($s) ); ?></h1>
		</header>

		<?php if (have_posts()) : ?>

			<ul class="article">
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
			</ul>
			<div class="tablenav"><?php BirdSTAR::the_pagenation(); ?></div>

		<?php else: ?>
			<p><?php printf(__('Sorry, no posts matched &#8216;%s&#8217;', 'birdstar'), esc_html($s) ); ?>
		<?php endif; ?>
	
		</div><!-- #content -->
	</div><!-- #main -->

	<?php get_sidebar('left'); ?>

</div><!-- .container -->

<?php get_footer(); ?>
