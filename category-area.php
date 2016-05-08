<?php
/*
The template for displaying Category-Area pages.
*/
get_header(); ?>


<div class="container">
	<div id="main">
		<div id="content">
			<?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?>

<?php if (have_posts()) : ?>

		<header class="content-header">
			<h1 class="content-title"><?php echo birdSTAR::get_category_title(); ?></h1>
		</header>

<?php
$html = '';
$cat_area = get_category_by_slug("area");

$categories = get_categories('child_of=' .$cat_area->cat_ID ."&orderby=ID");
foreach($categories as $cat){
	$url_category =  get_category_link($cat->cat_ID);


	echo '<h2 class="area-title"><a href="' .$url_category ,'">' .$cat->cat_name .'限定 (' ,$cat->count .'件)</a></h2>';
	echo '<ul class="archive">';
	query_posts('&category_name="' .$cat->slug .'&showposts=5"');
	while (have_posts()) : the_post();
		$url = get_permalink();
		$title = get_the_title();
		echo '<li><a href="' .$url .'"><h3 class="entry-title">' .$title .'</h3>';
		birdSTAR::the_okashimaker( get_the_ID() );
		echo '</li>';

	endwhile;

echo '</ul>';
echo '<p><a href="' .$url_category .'" class="more-link">' .$cat->cat_name .'限定のお菓子をもっと見る</a></p>';

}

?>


<?php else: ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.', 'birdstar' ); ?></p><?php endif; ?>

		</div><!-- #content -->
	</div><!-- #main -->

	<?php get_sidebar('left'); ?>

</div><!-- .container -->

<?php get_footer(); ?>
