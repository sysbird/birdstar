<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage BirdSTAR
 * @since BirdSTAR 1.0
 */
?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdfield' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><span><?php the_title(); ?></span>
	<?php birdstar_the_maker( get_the_ID(), '<em>', '</em>', false ); ?>
	</a>
</li>
