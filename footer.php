<?php
/*
The template for displaying the footer.
*/
?>
	<footer id="footer">
		<section id="widget-area">
			<div class="container">
				<?php dynamic_sidebar( 'widget-area-footer' ); ?>
			</div>
		</section>

		<div class="container">
			<div class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ) ; ?>"><strong><?php bloginfo(); ?></strong></a><br>

				<?php if( get_theme_mod( 'copyright', 'true' ) ): ?>
					<?php printf(__( 'Copyright &copy; %s All Rights Reserved.', 'birdstar' ), BirdSTAR::get_copyright_year() ); ?>
				<?php endif; ?>

				<?php if( get_theme_mod( 'credit', 'true' ) ): ?>
					<br>
					<span class="generator"><a href="<?php echo esc_url('http://wordpress.org/'); ?>" target="_blank"><?php _e( 'Proudly powered by WordPress', 'birdstar' ); ?></a></span>
				<?php printf(__( 'BirdSTAR theme by %sSysbird%s', 'birdstar' ), '<a href="' .esc_url('https://profiles.wordpress.org/sysbird/') .'" target="_blank">', '</a>' ); ?>
				<?php endif; ?>
			</div>
		</div>
		<p id="back-top"><a href="#top"><span><?php _e( 'Go Top', 'birdstar'); ?></span></a></p>
	</footer>

</div><!-- wrapper -->

<?php wp_footer(); ?>

</body>
</html>