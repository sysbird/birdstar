<?php
/**
 * The template for displaying search results pages.
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
			<h1 class="entry-title"><?php printf( __( 'Search Results: %s', 'birdstar' ), esc_html( $s ) ); ?></h1>
			</header>

			<?php if ( have_posts() ) : ?>

				<ul class="list">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'archive' ); ?>
					<?php endwhile; ?>
				</ul>

				<?php $birdstar_pagination = get_the_posts_pagination( array(
						'mid_size'	=> 3,
						'screen_reader_text'	=> 'pagination',
					) );

					$birdstar_pagination = str_replace( '<h2 class="screen-reader-text">pagination</h2>', '', $birdstar_pagination );
					echo $birdstar_pagination; ?>

			<?php else: ?>
				<p><?php printf( __( 'Sorry, no posts matched &#8216;%s&#8217;', 'birdstar' ), esc_html( $s ) ); ?>
			<?php endif; ?>

		</article>

		</div><!-- /primary -->

		<?php get_sidebar(); ?>

	</div>
</div><!-- /content -->

<?php get_footer(); ?>
