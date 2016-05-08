<?php
/*
The Template for displaying all single posts.
*/
get_header(); ?>


<div class="container">
	<div id="main" class="archive">
		<div id="content">
			<?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


	<header class="content-header">
		<h1 class="content-title">「<?php the_title(); ?>」のお菓子</h1>
	</header>

	<?php

	$html = '';
	// 検索パラメータを設定
	$param = array( 'showposts' => -1,
					'post_type' => 'post',
					'meta_query' => array(
						array(
							'key' => 'maker',
							'value' => $post->ID,
							'compare' => 'LIKE'
						)
					));

	// WordPressのループ処理
	$myposts = get_posts($param);
	foreach($myposts as $post){

	    setup_postdata($post);  // 1件の投稿

	    // タイトル
	    $ti = get_the_title($post->ID);

	    // パーマリンク    
	    $ur = get_permalink($post->ID);

		$html .= '<li><a href="' .$ur .'">' .$ti .'</a></li>';
	}

	if(!empty($html)){
		$html = '<ul class="archive">' .$html .'</ul>';
		echo $html;
	}

	?>

	<div class="tablenav"><?php BirdSTAR::the_pagenation(); ?></div>

<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #main -->

	<?php get_sidebar('left'); ?>

</div><!-- .container -->

<?php get_footer(); ?>
