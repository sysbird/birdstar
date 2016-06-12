<?php
/**
 * The Template for displaying custom posts the maker.
 *
 * @package WordPress
 * @subpackage BirdSTAR
 * @since BirdSTAR 1.0
 */
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
get_header(); ?>

<div id="content" class="site-content">
	<div class="container">
		<div id="primary" class="content-area">

		<?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="page-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>

			<?php if(1 == $paged ): ?>
				<?php the_content(); ?>
			<?php endif; ?>

			<?php $posts_per_page = get_option( 'posts_per_page' );
				$offset = $posts_per_page * ( $paged -1 );
				$args = array(
					'posts_per_page'	=> $posts_per_page,
					'offset'			=> $offset,
					'post_type'		=> 'post',
					'post_status'		=> 'publish',
					'meta_query'		=> array(
						array(
							'key' => 'maker',
							'value' => $post->ID,
							'compare' => 'LIKE'
						)
					)
				);

				$the_query = new WP_Query($args);
				if ( $the_query->have_posts() ) :
			?>
					<ul class="list">
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
							<?php get_template_part( 'content', 'archive' ); ?>
						<?php endwhile; ?>
					</ul>

					<?php $birdstar_pagination = get_the_posts_pagination( array(
							'mid_size'	=> 3,
							'screen_reader_text'	=> 'pagination',
						) );

						$birdstar_pagination = str_replace( '<h2 class="screen-reader-text">pagination</h2>', '', $birdstar_pagination );
						echo $birdstar_pagination; ?>

			<?php endif;
				wp_reset_postdata();
			?>

	</article>

<?php endwhile; ?>

		</div><!-- /primary -->

		<?php get_sidebar(); ?>

	</div>
</div><!-- /content -->

<?php get_footer(); ?>
