<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage BirdSTAR
 * @since BirdSTAR 1.0
 */
?>
	<footer class="site-footer">
		<section class="widget-area">
			<div class="container">
				<?php dynamic_sidebar( 'widget-area-footer' ); ?>
			</div>
		</section>

		<div class="container">
			<div class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ) ; ?>"><strong><?php bloginfo(); ?></strong></a>

				<?php printf(__( 'Copyright &copy; %s All Rights Reserved.', 'birdstar' ), birdstar_get_copyright_year() ); ?>
			</div>
		</div>
		<p id="back-top"><a href="#top"><span><?php _e( 'Go Top', 'birdstar' ); ?></span></a></p>
	</footer>

</div><!-- wrapper -->

<?php wp_footer(); ?>

</body>
</html>