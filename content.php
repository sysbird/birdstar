<?php
/*
The default template for displaying content. Used for both single and index/page/archive/search.
*/
?>

<?php if(is_singular()): // Display Excerpts for Single/Page ?>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>

	<?php if(is_single()): // Only Display Excerpts for Single ?>
		<div class="entry-meta">
			<span class="postdate" datetime="<?php echo get_the_time('Y-m-d') ?>"><?php echo get_post_time( get_option( 'date_format' ) ); ?></span>
		</div>
		<?php if( has_post_thumbnail() ): ?>
			<div class="entry-eyecatch">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdstar' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<?php the_post_thumbnail( 'large' ); ?>
				</a>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array(
			'before'		=> '<div class="page-links">' . __( 'Pages:', 'birdstar' ),
			'after'			=> '</div>',
			'link_before'	=> '<span>',
			'link_after'	=> '</span>'
			) ); ?>
	</div>

	<?php if(is_single()): // Only Display Excerpts for Single ?>
		<footer class="entry-footer">
			<div class="maker"><?php BirdSTAR::the_okashidata() ?></div>
			<div class="category"><?php the_category(' ') ?></div>
			<?php the_tags('<div class="tag">', ' ', '</div>') ?>
			<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
		</footer>
		<?php birdSTAR::the_images(get_the_ID()); ?>
	<?php endif; ?>

	<?php elseif(is_home()): // Display Excerpts for Home ?>
		<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdstar' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</header>

		<?php if('post' == get_post_type()): ?>
			<footer class="entry-meta">
				<span class="postdate" datetime="<?php echo get_the_time('Y-m-d') ?>"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdstar' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo get_post_time( get_option( 'date_format' ) ); ?></a></span>
				<?php if ( comments_open() ) : ?>
					<span class="icon comment"><?php comments_number('0', '1', '%'); ?></span>
				<?php endif; ?>
			</footer>
		<?php endif; ?>

		<?php if( has_post_thumbnail() ): ?>
			<div class="entry-eyecatch">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdstar' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<?php the_post_thumbnail( 'large' ); ?>
				</a>
				<em><?php BirdSTAR::the_okashidata() ?></em>
				<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
				<?php BirdSTAR::the_categorytype(); ?>
			</div>
		<?php endif; ?>

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array(
				'before'		=> '<div class="page-links">' . __( 'Pages:', 'birdstar' ),
				'after'			=> '</div>',
				'link_before'	=> '<span>',
				'link_after'	=> '</span>'
				) ); ?>
		<p><a href="<? the_permalink(); ?>" class="more-link"><?php _e( 'Continue reading', 'birdstar' ); ?></a></p>
		</div>

		</li>

	<?php else: // Display Excerpts for Search, Archive ?>
		<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdstar' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">

			<h2 class="entry-title"><?php the_title(); ?></h2>

				<?php if('post' == get_post_type()): ?>
					<?php birdSTAR::the_okashimaker(get_the_ID()); ?>
				<?php endif; ?>
			</a>
		</li>
<?php endif; ?>
