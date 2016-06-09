jQuery(function() {

	jQuery( window ).load(function() {

	});

	// Navigation for mobile
	jQuery( "#small-menu" ).click( function(){
		jQuery( "#menu-primary-items" ).slideToggle();
		jQuery( this ).toggleClass( "current" );
	});

	// Windows Scroll
	var totop = jQuery( '#back-top' );
	totop.hide();
	jQuery( window ).scroll(function () {
		// back to pagetop
		var scrollTop = parseInt( jQuery( this ).scrollTop() );
		if ( scrollTop > 800 ) totop.fadeIn(); else totop.fadeOut();
	});

	totop.click( function () {
		// back to pagetop
		jQuery( 'body, html' ).animate( { scrollTop: 0 }, 500 ); return false;
	});
});
