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

	if ( ( $query->is_archive() || $query->is_search() ) && $query->is_main_query() ) {
		$query->set( 'posts_per_page', 12 );
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