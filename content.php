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
		<h2 class="entry-title">

		<?php if(!is_singular()): ?>
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdfield' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
		<?php endif ?>

		<?php the_title(); ?>

		<?php if(!is_singular()): ?>
			</a>
		<?php endif ?>

		</h2>
	</header>

	<?php if( !is_singular() ): ?>
		<footer class="entry-meta">
			<time class="postdate" datetime="<?php the_time( 'Y-m-d' ) ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
			<?php if ( comments_open() ) : ?>
				<span class="icon comment"><?php comments_number('0', '1', '%'); ?></span>
			<?php endif; ?>
		</footer>
	<?php endif; ?>

	<?php the_post_thumbnail( 'medium' ); ?>

	<div class="entry-content">

	<?php the_content(); ?>

	<?php if( is_home() ): ?>
		<div class="more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'Continue reading', 'birdstar' ); ?></a></div>
	<?php endif; ?>

	<?php if( is_single() && !is_singular( 'maker' ) ): ?>
		<footer class="entry-footer">
			<?php birdstar_the_entry_footer(); ?>
		</footer><!-- .entry-footer -->

		<?php birdstar_the_post_images( get_the_ID() ); ?>
	<?php endif; ?>

	<?php wp_link_pages( array(
		'before'		=> '<div class="page-links">' . __( 'Pages:', 'birdstar' ),
		'after'			=> '</div>',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>'
		) ); ?>
	</div>

</li>
