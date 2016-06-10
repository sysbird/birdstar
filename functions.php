<?php
/**
 * The template functions and definitions
 *
 * @package WordPress
 * @subpackage BirdSTAR
 * @since BirdSTAR 1.0
 */
//////////////////////////////////////////
// Set the content width based on the theme's design and stylesheet.
function birdstar_content_width() {
	global $content_width;
	$content_width = 930;
}
add_action( 'template_redirect', 'birdstar_content_width' );

//////////////////////////////////////////
// Set Widgets
function birdstar_widgets_init() {

	register_sidebar( array (
		'name'			=> __( 'Widget Area for sidebar', 'birdstar' ),
		'id'			=> 'widget-area-sidebar',
		'description'		=> __( 'Widget Area for sidebar', 'birdstar' ),
		'before_widget'	=> '<div class="widget">',
		'after_widget'		=> '</div>',
		'before_title'		=> '<h3>',
		'after_title'		=> '</h3>',
		) );

	register_sidebar( array (
		'name'			=> __( 'Widget Area for footer', 'birdstar' ),
		'id'			=> 'widget-area-footer',
		'description'		=> __( 'Widget Area for footer', 'birdstar' ),
		'before_widget'	=> '<div class="widget">',
		'after_widget'		=> '</div>',
		'before_title'		=> '<h3>',
		'after_title'		=> '</h3>',
		) );
}
add_action( 'widgets_init', 'birdstar_widgets_init' );

//////////////////////////////////////////////////////
// Theme Initialize
function birdstar_init() {

	$labels = array(
		'name'		=> 'メーカー',
		'all_items'	=> 'メーカーの一覧',
	);

	$args = array(
		'labels'		=> $labels,
		'public'		=> true,       // 公開するかどうが
		'show_ui'		=> true,       // メニューに表示するかどうか
		'menu_position'	=> 5,          // メニューの表示位置
		'has_archive'	=> true,       // アーカイブページの作成
		'rewrite'		=> true,
		'supports'		=> array( 'title', 'custom-fields' )
	);
	register_post_type( 'maker', $args );
}
add_action( 'init', 'birdstar_init', 0 );

//////////////////////////////////////////////////////
// Header markup
function birdstar_wrapper_class() {

	$birdstar_class = 'wrapper';

	if( get_theme_mod( 'birdstar_fixedheader', true ) ){
		$birdstar_class .= ' fixed-header';
	}

	if( get_theme_mod( 'birdstar_parallax', true ) ){
		$birdstar_class .= ' parallax';
	}

	if ( 'blank' == get_header_textcolor() ) {
		$birdstar_class .= ' no-title';
	}

	if ( !has_nav_menu( 'primary' ) ) {
		$birdstar_class .= ' no-nav-menu';
	}

	echo 'class="' .$birdstar_class .'"';
}

//////////////////////////////////////////////////////
// Copyright Year
function birdstar_get_copyright_year() {

	$birdstar_copyright_year = date("Y");

	$birdstar_first_year = $birdstar_copyright_year;
	$args = array(
		'numberposts'	=> 1,
		'orderby'	=> 'post_date',
		'order'		=> 'ASC',
	);
	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		$birdstar_first_year = mysql2date( 'Y', $post->post_date, true );
	}

	if( $birdstar_copyright_year <> $birdstar_first_year ){
		$birdstar_copyright_year = $birdstar_first_year .' - ' .$birdstar_copyright_year;
	}

	return $birdstar_copyright_year;
}

//////////////////////////////////////////////////////
// Header Style
function birdstar_header_style() {
}

//////////////////////////////////////////////////////
// Setup Theme
function birdstar_setup() {

	// Set languages
	load_theme_textdomain( 'birdstar', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Set feed
	add_theme_support( 'automatic-feed-links' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-image'		=> '',
		'default-color'		=> 'FFF',
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Navigation Menu', 'birdstar' ),
	) );

	// Add support for custom headers.
	$custom_header_support = array(
		// Text color and image (empty to use none).
		'default-text-color'	=> 'FFF',
		'default-image'		=> '%s/images/header.jpg',

		// Set height and width, with a maximum value for the width.
		'height'			=> 900,
		'width'			=> 1280,
		'max-width'		=> 900,

		// Random image rotation off by default.
		'random-default'	=> true,

		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'	=> 'birdstar_header_style',
	);

	// Add support for title tag.
	add_theme_support( 'title-tag' );

	// Add support for custom headers.
	add_theme_support( 'custom-header', $custom_header_support );

	register_default_headers( array(
		'birdstar'		=> array(
		'url'			=> '%s/images/header.jpg',
		'thumbnail_url'		=> '%s/images/header-thumbnail.jpg',
		'description'		=> 'birdstar'
		)
	) );

	// Add support for news content.
	add_theme_support( 'news-content', array(
		'news_content_filter'	=> 'birdstar_get_news_posts',
		'max_posts'		=> 5,
	) );
}
add_action( 'after_setup_theme', 'birdstar_setup' );

//////////////////////////////////////////////////////
// Filter main query at home
function birdstar_home_query( $query ) {

	if ( $query->is_main_query() && ( $query->is_archive() || $query->is_search() ) ) {
		$query->set( 'posts_per_page', 3 );
	}
}
add_action( 'pre_get_posts', 'birdstar_home_query' );

//////////////////////////////////////////////////////
// Enqueue Scripts
function birdstar_scripts() {

	wp_enqueue_script( 'birdstar-html5', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.7.3' );
	wp_script_add_data( 'birdstar-html5', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'jquery-masonry' );
	wp_enqueue_script( 'jquerytile', get_template_directory_uri() .'/js/jquery.tile.js', 'jquery', '20140801' );
	wp_enqueue_script( 'birdstar', get_template_directory_uri() .'/js/birdstar.js', 'jquery', '1.08' );
	wp_enqueue_style( 'birdstar-google-font', '//fonts.googleapis.com/css?family=Open+Sans:400normal', false, null, 'all' );
	wp_enqueue_style( 'birdstar', get_stylesheet_uri() );

	if ( strtoupper( get_locale() ) == 'JA' ) {
		wp_enqueue_style( 'birdstar_ja', get_template_directory_uri().'/css/ja.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'birdstar_scripts' );

//////////////////////////////////////////////////////
// Theme Customizer
function birdstar_customize($wp_customize) {
}
add_action( 'customize_register', 'birdstar_customize' );

//////////////////////////////////////////////////////
// Santize a checkbox
function birdstar_sanitize_checkbox( $input ) {

	if ( $input == true ) {
		return true;
	} else {
		return false;
	}
}

//////////////////////////////////////////////////////
// Excerpt More
function birdstar_excerpt_more($more) {
	return '<span class="more-link">' .__( 'Continue reading', 'birdstar' ) . '</span>';
}
add_filter('excerpt_more', 'birdstar_excerpt_more');

//////////////////////////////////////////////////////
// Removing the default gallery style
function birdstar_gallery_atts( $out, $pairs, $atts ) {

	$atts = shortcode_atts( array( 'size' => 'medium', ), $atts );
	$out['size'] = $atts['size'];

	return $out;
}
add_filter( 'shortcode_atts_gallery', 'birdstar_gallery_atts', 10, 3 );
add_filter( 'use_default_gallery_style', '__return_false' );

//////////////////////////////////////////////////////
// thumbnail
function birdstar_post_image_html( $html, $post_id, $post_image_id ) {

	if(!is_single()){
		$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' .$html .'</a>';
	}

	$html = '<div class="entry-eyecatch">' .$html .'</div>';

	return $html;
}
add_filter( 'post_thumbnail_html', 'birdstar_post_image_html', 10, 3 );

//////////////////////////////////////////
//  display maker
function  birdstar_the_maker($ID, $before, $after, $link = true ) {

	$my_posts = get_field('maker', $ID);
	if( $my_posts && is_array($my_posts)):
		foreach( $my_posts as $p) :

			echo $before;
			if( $link ){
				echo '<a href="' .get_the_permalink($p->ID) .'">';
			}

			echo get_the_title($p->ID);

			if( $link ){
				echo '</a>';
			}
			echo $after;

			return;
		endforeach;
		wp_reset_postdata();
	endif;
}

//////////////////////////////////////////
//  Show price
function  birdstar_the_price( $ID, $before, $after ) {

	$price = get_field( 'price', $ID );
	if( !empty( $price ) ){
		echo $before .$price .$after;
	}
}

//////////////////////////////////////////////////////
// entry footer
function birdstar_the_entry_footer() {

	echo '<dl>';
	echo '<dt>投稿日</dt><dd><time class="postdate" datetime="' .get_the_time( 'Y-m-d' ) .'">' .get_post_time( get_option( 'date_format' ) ) .'</time></dd>';
	echo '<dt>種類</dt><dd>';
	the_category(', ');
	echo  '</dd>';
	the_tags('<dt>キーワード</dt><dd>', ', ', '</dd>');
	birdstar_the_maker( get_the_ID(), '<dt>メーカー</dt><dd>', '</dd>' );
	birdstar_the_price( get_the_ID(), '<dt>価格</dt><dd>', ' 円</dd>' );
	echo '</dl>';
}

//////////////////////////////////////////////////////
// Show attachment photos exept eyecatch
function  birdstar_the_post_images( $ID ) {

	$html = '';
	$attachments = get_children( array('post_parent' => $ID, 'post_type' => 'attachment', 'post_mime_type' => 'image' ));
	$thumbnail_id = get_post_meta( $ID, "_thumbnail_id", true );
	if( is_array( $attachments ) ){
		foreach( $attachments as $attachment ){
			if( $thumbnail_id <> $attachment->ID ){
				$thumbnail = wp_get_attachment_url( intval( $attachment->ID ));
				$html .= '<img src="' .$thumbnail .'" alt="写真">';
			}
		}
	}

	if( !empty( $html ) ){
		$html = '<div class="photos">' .$html .'</div>' ."\r\n";
		echo $html;
	}
}

//////////////////////////////////////////////////////
// Widget Recent Posts
class birdstar_relation_posts extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = '関連する記事' );
	}

	function widget( $args, $instance ) {

		if( !is_single() || 'post' != get_post_type() ){
			return;
		}

		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		$tags = '';
		$posttags = get_the_tags();
		if( $posttags ){
			foreach( $posttags as $tag ) {
				if( !empty($tags ) ){
					$tags .= ',';
				}
				$tags .= $tag->name;
				break;
			}
		}

		$html = '';
		// 検索パラメータを設定
		$param = array( 'showposts' => 10, 'post_type' => 'post', 'exclude' =>get_the_ID() ,'tag' => $tags, 'orderby' => 'rand' );

		// WordPressのループ処理
		$myposts = get_posts( $param );
		foreach( $myposts as $post ){

		    setup_postdata( $post );  // 1件の投稿

		    // タイトル
		    $ti = get_the_title( $post->ID );

		    // パーマリンク
		    $ur = get_permalink( $post->ID );

		    // アイキャッチ
			$th =  get_the_post_thumbnail( $post->ID, 'thumbnail' );

			// カテゴリー
			$type = '';
			foreach( ( get_the_category( $post->ID ) ) as $cat ) {
				if( $cat->parent ){
					$cat_parent = get_category( $cat->parent );
					if( "type" == $cat_parent->slug ){
						$type = $cat->category_nicename;
						break;
					}
				}
			}

			$html .= '<li class="category-' .$type .'"><a href="' .$ur .'">' .$th .'<strong>' .$ti .'</strong></a></li>';
		}

		if( !empty($html ) ){
			$html = '<ul class="recent">' .$html .'</ul>';
		}

    	?>
        <div class="widget">
            <?php if ( $title ) ?>
        	<?php echo $before_title . $title . $after_title; ?>
			<?php echo $html; ?>
        </div>
        <?php
    }

    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['body'] = trim( $new_instance['body'] );
        return $instance;
    }

    function form($instance) {
        $title = esc_attr( $instance['title'] );
        $body = esc_attr( $instance['body'] );
        ?>
        <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>">
          <?php _e( 'タイトル:' ); ?>
          </label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php
    }
}
add_action( 'widgets_init', create_function( '', 'register_widget( "birdstar_relation_posts" );' ) );


//////////////////////////////////////////////////////
// Widget Yaerly
class birdstar_yaerly_widgets extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = '年代別記事' );
	}

	function widget( $args, $instance ) {

		if( !is_year() ){
			return;
		}

		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		$output = '';

		if( !empty( $html ) ){
			$html = '<ul class="yearly">' .$html .'</ul>';
		}

		$home = home_url( '/' );
		$year = date( "Y" );

		for($y = $year; $y >=1996; $y--){
$output .= <<<EOD
	<li><a href="$home/$y">{$y}年</a></li>
EOD;
		}

		if( $output ) {
			$output = '<ul class="yearly">' . $output . '</ul>';
		}

    	?>
        <div class="widget">
            <?php if ( $title ) ?>
        	<?php echo $before_title . $title . $after_title; ?>
			<?php echo $output; ?>
        </div>
        <?php
    }

    function update($new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['body'] = trim( $new_instance['body'] );
	        return $instance;
    }

    function form($instance) {
        $title = esc_attr( $instance['title'] );
        $body = esc_attr( $instance['body'] );
        ?>
        <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>">
          <?php _e( 'タイトル:' ); ?>
          </label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php
    }
}
add_action( 'widgets_init', create_function( '', 'register_widget( "birdstar_yaerly_widgets" );' ) );
