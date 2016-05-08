<?php
/*
birdstar functions and definitions.
*/
function birdstar_setup() {
	if ( !class_exists( 'BirdSTAR' ) ) {
		class BirdSTAR extends BirdSTARFunctions {
			public function __construct() {
				parent::__construct();
			}
		}
	}
	$BirdSTAR = new BirdSTAR();
}
add_action( 'after_setup_theme', 'birdstar_setup', 99999 );

//////////////////////////////////////////
// Set the content width based on the theme's design and stylesheet.
class BirdSTARFunctions {

	//////////////////////////////////////////////////////
	// __construct
	public function __construct() {
		global $content_width;
		if ( !isset( $content_width ) ) $content_width = 930;

		$this->setup();
		add_action( 'template_redirect', array( $this, 'content_width' )  );
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'the_scripts' ) );
		add_filter( 'wp_title', array( $this, 'the_title' ) );
		add_action( 'customize_register', array( $this, 'customize' ) );
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) ); 
		add_filter( 'shortcode_atts_gallery', array( $this, 'gallery_atts' ), 10, 3 );
		add_filter( 'use_default_gallery_style', '__return_false' );
		add_action( 'init', array( $this, 'my_custom_post_type' ), 0 );
		add_action( 'pre_get_posts', array( $this, 'archive_query' ) );
		add_shortcode( 'birdmagazine_yearly', array( $this, 'birdmagazine_yearly' ) );
	}

	//////////////////////////////////////////////////////
	// Setup Theme
	protected function setup() {

		// Set languages
		load_theme_textdomain( 'birdstar', get_template_directory() . '/languages' );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Set feed
		add_theme_support( 'automatic-feed-links' );

		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );

		/*
		 * This theme supports all available post formats by default.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
		) );

		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', array(
			'default-color' => null,
			'default-image' => '',
			'default-color' => 'FFF',
			'wp-head-callback' => 'BirdSTAR::custom_background_cb',
		) );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Navigation Menu', 'birdstar' ),
		) );


		// Add support for custom headers.
		$custom_header_support = array(
			// Text color and image (empty to use none).
			'default-text-color'     => 'ff4a5d',
			'default-image'          => '',

			// Set height and width, with a maximum value for the width.
			'height'                 => 200,
			'width'                  => 1280,
			'max-width'              => 1280,
			'default-image'          => '%s/images/header.jpg',

			// Random image rotation off by default.
			'random-default'         => true,

			// Callbacks for styling the header and the admin preview.
			'wp-head-callback' => 'BirdSTAR::header_style',
			'admin-head-callback' => 'BirdSTAR::admin_header_style',
			'admin-preview-callback' => 'BirdSTAR::admin_header_image'
		);

		add_theme_support( 'custom-header', $custom_header_support );

		register_default_headers( array(
			'birdstar' => array(
				'url' => '%s/images/header.jpg',
				'thumbnail_url' => '%s/images/header-thumbnail.jpg',
				'description' => 'birdstar'
			)
		) );
	}

	//////////////////////////////////////////
	// Set the content width based on the theme's design and stylesheet.
	public function content_width() {
		global $content_width;
		$content_width = 930;
	}

	//////////////////////////////////////////
	// Set Widgets
	public function widgets_init() {

		register_sidebar( array (
			'name' => __( 'Widget Area for right-sidebar', 'birdstar' ),
			'id' => 'widget-area-sidebar',
			'description' => __( 'Widget Area for right-sidebar', 'birdstar' ),
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
			) );

		register_sidebar( array (
			'name' => __( 'Widget Area for footer', 'birdstar' ),
			'id' => 'widget-area-footer',
			'description' => __( 'Widget Area for footer', 'birdstar' ),
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
			) );
	}

	//////////////////////////////////////////////////////
	// Header markup
	public function wrapper_class($birdstar_class) {

		if ( 'blank' == get_header_textcolor() ) {
			$birdstar_class .= ' no-title';
		}

		echo 'class="' .$birdstar_class .'"';
	}

	//////////////////////////////////////////////////////
	// Pagenation
	public function the_pagenation() {

		global $wp_rewrite;
		global $wp_query;
		global $paged;

		$birdstar_paginate_base = get_pagenum_link( 1 );
		if ( strpos($birdstar_paginate_base, '?' ) || ! $wp_rewrite->using_permalinks() ) {
			$birdstar_paginate_format = '';
			$birdstar_paginate_base = add_query_arg( 'paged', '%#%' );
		} else {
			$birdstar_paginate_format = ( substr( $birdstar_paginate_base, -1 ,1 ) == '/' ? '' : '/' ) .
			user_trailingslashit( 'page/%#%/', 'paged' );;
			$birdstar_paginate_base .= '%_%';
		}
		echo paginate_links( array(
			'base' => $birdstar_paginate_base,
			'format' => $birdstar_paginate_format,
			'total' => $wp_query->max_num_pages,
			'mid_size' => 3,
			'current' => ( $paged ? $paged : 1 ),
		));

	    $posts_per_page = intval(get_query_var('posts_per_page'));
	    $current_page = $paged ? $paged : 1;
		$start = 1;
		if(1 < $paged){
			$start = ($paged - 1) * $posts_per_page + 1;
		}

		$end = $posts_per_page * $current_page;
		if($current_page == $wp_query->max_num_pages){
			$end = $wp_query->found_posts;
		}

	    echo sprintf('<div class="postsnumber">%d ～ %d 件目を表示 (全 %d件)</div>', $start, $end, $wp_query->found_posts);
	}

	//////////////////////////////////////////////////////
	// Copyright Year
	public function get_copyright_year() {

		$birdstar_copyright_year = date("Y");

		$birdstar_first_year = $birdstar_copyright_year;
		$args = array(
			'numberposts' => 1,
			'orderby'     => 'post_date',
			'order'       => 'ASC',
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
	public function header_style() {

		//Theme Option
		$birdstar_accent_color = get_theme_mod( 'accent_color', '#ff4a5d' );
		$birdstar_text_color = get_theme_mod( 'text_color', '#333' );
		$birdstar_link_color = get_theme_mod( 'link_color', '#1c4bbe' );
		$birdstar_widget_color = get_theme_mod( 'widget_color', '#E5E5E5' );
		$birdstar_header_color = get_header_textcolor();

	?>

	<style type="text/css">


	</style>

	<?php 

	}

	//////////////////////////////////////////////////////
	// Admin Header Style
	public function birdstar_admin_header_style() {
	?>

	<style type="text/css">

	</style>

	<?php

	} 

	//////////////////////////////////////////////////////
	// Admin Header Image
	public function birdstar_admin_header_image() {

		$style = '';
		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) ){
			$style = ' style="display:none;"';
		}

		$header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<div id="headerimage">
				<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
			</div>
		<?php endif; ?>

		<div id="birdstar_header">
			<div id="site-title"><a <?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></div>
			<div id="site-description" <?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		</div>

		<?php
	}

	//////////////////////////////////////////////////////
	// Document Title
	public function the_title( $title ) {
		global $page, $paged;

		$title .= get_bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );

		if ( $site_description && ( is_home() || is_front_page() ) )
			$title .= " | $site_description";

		if ( $paged >= 2 || $page >= 2 )
			$title .= ' | ' . sprintf( __( 'Page %s', 'birdstar' ), max( $paged, $page ) );

		return $title;
	}

	//////////////////////////////////////////////////////
	// Enqueue Scripts
	public function the_scripts() {

		if ( is_singular() && comments_open() && get_option('thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script( 'jquery-masonry' );
		wp_enqueue_script( 'birdstar', get_template_directory_uri() .'/js/birdstar.js', 'jquery', '1.00' );
		wp_enqueue_style( 'birdstar', get_stylesheet_uri() );

		if ( strtoupper( get_locale() ) == 'JA' ) {
			wp_enqueue_style( 'birdstar_ja', get_template_directory_uri().'/css/ja.css' );
		}
	}

	//////////////////////////////////////////////////////
	// Theme Customizer
	public function customize($wp_customize) {
	 
		$wp_customize->add_section( 'birdstar_customize', array(
			'title'=> __( 'Birdstar Options', 'birdstar' ),
			'priority'	=> 999,
		) );

		// Accent Color
		$wp_customize->add_setting( 'accent_color', array(
			'default' => '#ff4a5d',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
			'label' => __( 'Accent Color', 'birdstar' ),
			'section'=> 'birdstar_customize',
			'settings' => 'accent_color',
		) ) );

		// Text Color
		$wp_customize->add_setting( 'text_color', array(
			'default' => '#333',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
			'label' => __( 'Text Color', 'birdstar' ),
			'section'=> 'birdstar_customize',
			'settings' => 'text_color',
		) ) );

		// Link Color
		$wp_customize->add_setting( 'link_color', array(
			'default' => '#1c4bbe',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
			'label' => __( 'Link Color', 'birdstar' ),
			'section'=> 'birdstar_customize',
			'settings' => 'link_color',
		) ) );

		// Widget Area Background Color
		$wp_customize->add_setting( 'widget_color', array(
			'default' => '#E5E5E5',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'widget_color', array(
			'label' => __( 'Widget BackgroundColor', 'birdstar' ),
			'section'=> 'birdstar_customize',
			'settings' => 'widget_color',
		) ) );

		// Display Copyright
		$wp_customize->add_setting( 'copyright', array(
			'default'  => 'true',
			'type'     => 'theme_mod',
		) );

		$wp_customize->add_control( 'copyright', array(
			'label'		=> __( 'Display Copyright', 'birdstar' ),
			'section'  => 'birdstar_customize',
			'type'     => 'checkbox',
			'settings' => 'copyright',
		) );

		// Display Credit
		$wp_customize->add_setting( 'credit', array(
			'default'  => 'true',
			'type'     => 'theme_mod',
		) );

		$wp_customize->add_control( 'credit', array(
			'label'		=> __( 'Display Credit', 'birdstar' ),
			'section'  => 'birdstar_customize',
			'type'     => 'checkbox',
			'settings' => 'credit',
		) );
	}

	//////////////////////////////////////////////////////
	// Excerpt More
	public function excerpt_more( $more ) { 
		return '... <a href="'. esc_url( get_permalink() ) . '" class="more-link">' .__( 'Continue reading', 'birdstar' ) . '</a>';
	}

	//////////////////////////////////////////////////////
	// Removing the default gallery style
	public function gallery_atts( $out, $pairs, $atts ) {

		$atts = shortcode_atts( array( 'size' => 'medium', ), $atts );
		$out['size'] = $atts['size'];

		return $out;
	}

	//////////////////////////////////////////////////////
	// Custom Background callback
	public function custom_background_cb() {
		// $background is the saved custom image, or the default image.
		$background = set_url_scheme( get_background_image() );

		// $color is the saved custom color.
		// A default has to be specified in style.css. It will not be printed here.
		$color = get_background_color();

		if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
			$color = false;
		}

		if ( ! $background && ! $color )
			return;

		$style = $color ? "background-color: #$color;" : '';

		if ( $background ) {
			$image = " background-image: url('$background');";

			$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
			if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
				$repeat = 'repeat';
			$repeat = " background-repeat: $repeat;";

			$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
			if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
				$position = 'left';
			$position = " background-position: top $position;";

			$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
			if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
				$attachment = 'scroll';
			$attachment = " background-attachment: $attachment;";

			$style .= $image . $repeat . $position . $attachment;
		}
	?>
	<style type="text/css" id="custom-background-css">
	body.custom-background .wrapper { <?php echo trim( $style ); ?> }
	</style>
	<?php
	}

	//////////////////////////////////////////////////////
	// maker the custom post type
	function my_custom_post_type() {

	    $labels = array(
	        'name'                => 'お菓子メーカー',
	        'all_items'           => 'お菓子メーカーの一覧',
	    );

	    $args = array(
	        'labels'              => $labels,
	        'public'              => true,       // 公開するかどうが
	        'show_ui'             => true,       // メニューに表示するかどうか
	        'menu_position'       => 5,          // メニューの表示位置
	        'has_archive'         => true,       // アーカイブページの作成
	        'rewrite'             => true,
	        'supports'            => array( 'title', 'custom-fields' )
	    );
	    register_post_type( 'maker', $args );
	}

	//////////////////////////////////////////////////////
	// cateory type
	public function the_categorytype() {

		$categorytype = array( "snack" => "スナック", "chocolate" => "チョコ", "cookie" => "洋菓子", "candy" => "飴など", "senbei" => "和風" );

		// category
		foreach( ( get_the_category( $post->ID ) ) as $cat ) {
			$cat_parent = get_category( $cat->parent );
			if( "type" == $cat_parent->slug ){
				echo '<div class="category-type"><a href="' .get_category_link( $cat->cat_ID ) .'">' .$categorytype[$cat->slug] .'</a></div>';
				break;
			}
		}

	}

	//////////////////////////////////////////////////////
	// Archive Number
	function archive_query( $query ) {
		if ( !is_admin() && $query->is_main_query() && $query->is_archive() ){
			$query->set( 'posts_per_page', '30' );

			if(is_post_type_archive('maker') ){
				$query->set( 'orderby', 'meta_value' );
				$query->set( 'meta_key', 'furigana' );
				$query->set( 'order', 'ASC' );
			}

		}
	}

	//////////////////////////////////////////////////////
	// maker price
	function the_okashidata() {

		$my_posts = get_field('maker', $post->ID);
		if( $my_posts && is_array($my_posts)):
			foreach( $my_posts as $p) :
			?>
				<a href="<?php echo get_permalink($p); ?>"><?php echo get_the_title($p); ?></a>
					<?php $price = get_field('price', $post->ID);
						if(!empty($price)){
							echo ' ', $price .'円';
						}
					?>
			<?php
			endforeach;
		endif;
	}

	//////////////////////////////////////////
	// display maker
	function the_okashimaker($ID) {

		$maker = birdSTAR::get_okashimaker($ID);
		if(!empty($maker)){
			echo '<span class="maker">' .$maker .'</span>';
		}
	}

	//////////////////////////////////////////
	// get maker
	function get_okashimaker($ID) {



		$my_posts = get_field('maker', $ID);
		if( $my_posts && is_array($my_posts)):
			foreach( $my_posts as $p) :
				return get_the_title($p);
			endforeach;
			wp_reset_postdata();
		endif;
	}

	//////////////////////////////////////////////////////
	// Show Posts Images
	function the_images($id) {

		$html = '';
		$attachments = get_children(array('post_parent' => $id, 'post_type' => 'attachment', 'post_mime_type' => 'image'));
		$thumbnail_id = get_post_meta($id, "_thumbnail_id", true);
	    if (is_array($attachments) ){
			foreach($attachments as $attachment){
				if($thumbnail_id <> $attachment->ID){
					$thumbnail = wp_get_attachment_url(intval($attachment->ID));
					$html .= '<img src="' .$thumbnail .'" alt="写真">';
				}
			}
		}

		if(!empty($html)){
			$html = '<div class="photos">' .$html .'</div>' ."\r\n";
			echo $html;
		}
	}

	//////////////////////////////////////////////////////
	// Category title
	function get_category_title() {

		$title = '';
	
		if(is_category()) {
			$title = sprintf( '「%s」に関するお菓子', single_cat_title( '', false ) );
		}
		elseif( is_tag() ) {
			$title = sprintf( '「%s」に関するお菓子', single_tag_title( '', false ) );
		}
		elseif (is_day()) {
			$title = sprintf( '%sのお菓子', get_post_time( get_option( 'date_format' ) ) );
		}
		elseif (is_month()) {
			$title = sprintf( '%sのお菓子', get_post_time( __( 'F, Y', 'birdstar' ) ) );
		}
		elseif (is_year()) {
			$title = sprintf( '%sのお菓子', get_post_time( __( 'Y', 'birdstar' ) ) );
		}
		elseif (is_author()) {
			$title = sprintf( '%sが食べたお菓子', get_the_author_meta('display_name', get_query_var('author')) );
		}
		elseif (is_post_type_archive()) {
			$post_type = get_post_type_object( get_query_var( 'post_type' ) );
			echo $post_type->label;
		}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
			$title = __('Blog Archives', 'birdstar');
		}
		
		return $title;
	}

	//////////////////////////////////////////////////////
	// Yearly Archive
	function birdmagazine_yearly ( $atts ) {

		$output = '';

		$home = home_url( '/' );
		$year = date("Y");

		for($y = $year; $y >=1996; $y--){

$output .= <<<EOD
			<li><a href="$home/$y">{$y}年</a></li>
EOD;
		}

		if( $output ) {
			$output = '<ul class="archive">' . $output . '</ul>';
		}

		return $output;
	}
}

//////////////////////////////////////////
// SinglePage Comment callback
function birdstar_the_comments( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;

?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

	<?php if( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ):
		$birstips_url    = get_comment_author_url();
		$birstips_author = get_comment_author();
	 ?> 

		<div class="posted"><strong><?php _e( 'Pingback', 'birdstar' ); ?> : </strong><a href="<?php echo $birstips_url; ?>" target="_blank" class="web"><?php echo $birstips_author ?></a><?php edit_comment_link( __('(Edit)', 'birdstar'), ' ' ); ?></div>

	<?php else: ?>

		<div class="comment_meta">
			<?php echo get_avatar( $comment, 40 ); ?>
			<span class="author"><?php comment_author(); ?></span>
			<span class="postdate"><?php echo get_comment_time(get_option('date_format') .' ' .get_option('time_format')); ?></span><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'birdstar' ); ?></em>
		<?php endif; ?>

		<div class="comment_text">
			<?php comment_text(); ?>

			<?php $birdstar_web = get_comment_author_url(); ?>
			<?php if(!empty($birdstar_web)): ?>
				<p class="web"><a href="<?php echo $birdstar_web; ?>" target="_blank"><?php echo $birdstar_web; ?></a></p>
			<?php endif; ?>
		</div>

	<?php endif; ?>
<?php
	// no "</li>" conform WORDPRESS
}

//////////////////////////////////////////////////////
// Widget Recent Posts
class birdstar_relation_posts extends WP_Widget {
	function birdstar_relation_posts() {
    	parent::WP_Widget(false, $name = '関連するお菓子');
    }
    function widget($args, $instance) {

		if(!is_single() || 'post' != get_post_type()){
			return;
		}

        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );

		$tags = '';
		$posttags = get_the_tags();
		foreach($posttags as $tag) {
			if(!empty($tags)){
				$tags .= ',';
			}
			$tags .= $tag->name;
			break;
		}

		$html = '';
		// 検索パラメータを設定
		$param = array( 'showposts' => 10, 'post_type' => 'post', 'exclude' =>get_the_ID() ,'tag' => $tags, 'orderby' => 'rand' );

		// WordPressのループ処理
		$myposts = get_posts($param);
		foreach($myposts as $post){

		    setup_postdata($post);  // 1件の投稿

		    // タイトル
		    $ti = get_the_title($post->ID);

		    // パーマリンク    
		    $ur = get_permalink($post->ID);

		    // アイキャッチ
			$th =  get_the_post_thumbnail($post->ID, 'thumbnail');

			// カテゴリー
			$type = '';
			foreach((get_the_category($post->ID)) as $cat) {
				$cat_parent = get_category($cat->parent);
				if("type" == $cat_parent->slug){
					$type = $cat->category_nicename;
					break;
				}
			}

			$html .= '<li class="category-' .$type .'"><a href="' .$ur .'">' .$th .'<strong>' .$ti .'</strong></a></li>';
		}

		if(!empty($html)){
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
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['body'] = trim($new_instance['body']);
        return $instance;
    }
    function form($instance) {
        $title = esc_attr($instance['title']);
        $body = esc_attr($instance['body']);
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>">
          <?php _e('タイトル:'); ?>
          </label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("birdstar_relation_posts");'));


//////////////////////////////////////////////////////
// Widget Yaerly
class birdstar_yaerly_widgets extends WP_Widget {
	function birdstar_yaerly_widgets() {
    	parent::WP_Widget(false, $name = '年代別お菓子');
    }
    function widget($args, $instance) {

		if(!is_year()){
			return;
		}

        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );

		$output = '';

		if(!empty($html)){
			$html = '<ul class="yearly">' .$html .'</ul>';
		}

		$home = home_url( '/' );
		$year = date("Y");

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
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['body'] = trim($new_instance['body']);
        return $instance;
    }
    function form($instance) {
        $title = esc_attr($instance['title']);
        $body = esc_attr($instance['body']);
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>">
          <?php _e('タイトル:'); ?>
          </label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("birdstar_yaerly_widgets");'));
