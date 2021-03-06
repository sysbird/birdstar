<?php
/**
 * The template for displaying search form.
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.0
 */
?>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <div><label class="screen-reader-text" for="s">Search for:</label>
        <input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="s" placeholder="<?php _e('Search...', 'birdstar') ?>">
        <input type="submit" id="searchsubmit" value="&#xf002;">
    </div>
</form>