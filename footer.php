<?php
/*
The template for displaying the footer.
*/
?>
	<footer id="footer">
		<hr class="jagged top">
		<section id="widget-area">
			<div class="container">
				<?php dynamic_sidebar( 'widget-area-footer' ); ?>
			</div>
		</section>
		<hr class="jagged bottom">

		<div class="container">
			<div class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ) ; ?>"><strong><?php bloginfo(); ?></strong></a><br>

				<?php if( get_theme_mod( 'copyright', 'true' ) ): ?>
					<?php printf(__( 'Copyright &copy; %s All Rights Reserved.', 'birdsnap' ), BirdSNAP::get_copyright_year() ); ?>
				<?php endif; ?>

				<?php if( get_theme_mod( 'credit', 'true' ) ): ?>
					<br>
					<span class="generator"><a href="<?php echo esc_url('http://wordpress.org/'); ?>" target="_blank"><?php _e( 'Proudly powered by WordPress', 'birdsnap' ); ?></a></span>
				<?php printf(__( 'BirdSNAP theme by %sSysbird%s', 'birdsnap' ), '<a href="' .esc_url('https://profiles.wordpress.org/sysbird/') .'" target="_blank">', '</a>' ); ?>
				<?php endif; ?>
			</div>
		</div>
		<p id="back-top"><a href="#top"><span><?php _e( 'Go Top', 'birdsnap'); ?></span></a></p>
	</footer>

</div><!-- wrapper -->

<?php wp_footer(); ?>

</body>
</html>