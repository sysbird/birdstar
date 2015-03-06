<?php
/*
The Template for displaying all single posts.
*/
get_header(); ?>

<div id="content">
	<div class="container">

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content">

				<div class="entry-attachment">
					<div class="attachment">
<?php

	$post                = get_post();
	$attachment_size     = apply_filters( 'birdsnap', array( 930, 930 ) );
	$next_attachment_url = wp_get_attachment_url();
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);

?>

						<?php if ( has_excerpt() ) : ?>
							<div class="wp-caption">
								<?php the_excerpt(); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'birdsnap' ), 'after' => '</div>' ) ); ?>

			</div>

			<footer class="entry-meta">
				<span class="postdate" datetime="<?php echo get_the_time('Y-m-d') ?>"><?php echo get_post_time( get_option( 'date_format' ) ); ?></span>
				<span class="icon author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>
				<span class="parent-post-link"><a href="<?php echo get_permalink( $post->post_parent ); ?>" rel="gallery"><?php echo get_the_title( $post->post_parent ); ?></a></span>
			</footer>

			<?php comments_template(); ?>
		</article>

		<nav id="nav-below">
			<span class="nav-previous"><?php next_image_link( false, __( 'Next Image' , 'birdsnap' ) ); ?></span>
			<span class="nav-next"><?php previous_image_link( false, __( 'Previous Image' , 'birdsnap' ) ); ?></span>
		</nav>

	<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>
