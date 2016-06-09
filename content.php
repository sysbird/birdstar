<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.0
 */
?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdfield' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	</header>
	<footer class="entry-meta">
		<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( get_option( 'date_format' ) ); ?></time>
		<?php if ( comments_open() ) : ?>
			<span class="icon comment"><?php comments_number('0', '1', '%'); ?></span>
		<?php endif; ?>
	</footer>
	<?php the_post_thumbnail( 'medium' ); ?>

	<div class="entry-content">

	<?php if( is_singular() ): ?>
		<?php the_content(); ?>
	<?php else: ?>
		<?php the_excerpt(); ?>
	<?php endif; ?>

	<?php wp_link_pages( array(
		'before'		=> '<div class="page-links">' . __( 'Pages:', 'birdstar' ),
		'after'			=> '</div>',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>'
		) ); ?>
	</div>

</li>
