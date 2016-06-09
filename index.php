<?php
/**
 * The main template file
 *
 * @package WordPress
 * @subpackage BirdSTAR
 * @since BirdSTAR 1.0
 */
get_header(); ?>

<div id="content" class="site-content">
	<div class="container">
		<div id="primary" class="content-area">
			<ul class="article">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>
			</ul>

			<?php $birdstar_pagination = get_the_posts_pagination( array(
					'mid_size'	=> 3,
					'screen_reader_text'	=> 'pagination',
				) );

			$birdfield_pagination = str_replace( '<h2 class="screen-reader-text">pagination</h2>', '', $birdstar_pagination );
			echo $birdstar_pagination; ?>

		</div><!-- /primary -->

		<?php get_sidebar(); ?>

	</div>
</div><!-- /content -->

<?php get_footer(); ?>
