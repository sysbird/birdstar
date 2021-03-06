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

<?php if (have_posts()) : ?>

		<article class="hentry">

			<header class="page-header">
				<h1 class="page-title">地域限定お菓子</h1>
			</header>

<?php
$html = '';
$cat_area = get_category_by_slug("area");
$categories = get_categories('child_of=' .$cat_area->cat_ID ."&orderby=ID");
foreach($categories as $cat){
	$url_category =  get_category_link($cat->cat_ID);

	echo '<h2 class="area-title"><a href="' .$url_category ,'">' .$cat->cat_name .'限定 (' ,$cat->count .'件)</a></h2>';
	echo '<ul class="list">';
	query_posts('&category_name="' .$cat->slug .'&showposts=5"');
	while (have_posts()) : the_post();
		get_template_part( 'content', 'archive' );
	endwhile;

	echo '</ul>';
	echo '<p><a href="' .$url_category .'" class="more-link">' .$cat->cat_name .'限定のお菓子をもっと見る</a></p>';
}

?>

<?php else: ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.', 'birdstar' ); ?></p><?php endif; ?>

		</article>
		</div><!-- /primary -->

		<?php get_sidebar(); ?>

	</div>
</div><!-- /content -->

<?php get_footer(); ?>
