<?php
/**
 * The template for displaying archive pages
 *
 * @package WordPress
 * @subpackage BirdSTAR
 * @since BirdSTAR 1.0
 */
get_header(); ?>

<div id="content" class="site-content">
	<div class="container">
		<div id="primary" class="content-area">

		<?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?>

		<article class="hentry">
			<header class="page-header">
				<h1 class="page-title"><?php
					if(is_category()) {
						printf(__( 'Category Archives: %s', 'birdstar' ), single_cat_title( '', false ) );
					}
					elseif( is_tag() ) {
						printf( __( 'Tag Archives: %s', 'birdstar' ), single_tag_title('', false) );
					}
					elseif (is_day()) {
						printf( __( 'Daily Archives: %s', 'birdstar' ), get_post_time( get_option( 'date_format' ) ) );
					}
					elseif (is_month()) {
						printf( __( 'Monthly Archives: %s', 'birdstar' ), get_post_time( __('F, Y', 'birdstar' ) ) );
					}
					elseif (is_year()) {
						printf( __( 'Yearly Archives: %s', 'birdstar' ), get_post_time( __( 'Y', 'birdstar' ) ) );
					}
					elseif (is_author()) {
						printf(__('Author Archives: %s', 'birdstar' ), get_the_author_meta( 'display_name', get_query_var( 'author' ) ) );
					}
					elseif (is_author()) {
						$title = sprintf( '%sが投稿した記事', get_the_author_meta('display_name', get_query_var('author')) );
					}
					elseif (is_post_type_archive()) {
						$post_type = get_post_type_object( get_query_var( 'post_type' ) );
						echo $post_type->label;
					}
					elseif ( isset($_GET['paged'] ) && !empty($_GET['paged'] ) ) {
						_e( 'Blog Archives', 'birdstar' );
					}
				?></h1>
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
				<p><?php _e( 'Sorry, no posts matched your criteria.', 'birdstar' ); ?></p>
			<?php endif; ?>
		</article>

		</div><!-- /primary -->

		<?php get_sidebar(); ?>

	</div>
</div><!-- /content -->

<?php get_footer(); ?>
