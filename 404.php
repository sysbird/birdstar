<?php
/*
The template for displaying 404 pages (Not Found).
*/
get_header(); ?>

<div class="container">
	<div id="main">
		<div id="content">

		<article class="hentry">

	<header class="entry-header">
		<h1 class="entry-title"><?php _e('Error 404 - Not Found', 'birdstar'); ?></h1>
	</header>

	<div class="entry-content">
		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'birdstar' ); ?></p>
	</div>

		</article>

		</div><!-- #content -->
	</div><!-- #main -->

	<?php get_sidebar('left'); ?>

</div><!-- .container -->

<?php get_footer(); ?>
