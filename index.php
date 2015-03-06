<?php
/*
The main template file.
*/
get_header(); ?>

<div class="container">
	<div id="main">
		<div id="content">

			<ul class="article">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>
			</ul>
			<div class="tablenav"><?php BirdSNAP::the_pagenation(); ?></div>

		</div><!-- #content -->
	</div><!-- #main -->

	<?php get_sidebar('left'); ?>

</div><!-- .container -->

<?php get_footer(); ?>
