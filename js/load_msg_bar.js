jQuery(document).ready(function($) {

	//Header Sale Bar Cookie
	$('#close_header_sale').click(function() {
		document.cookie = 'showmessagebar=false';
	});
	
	//move bar to top of page
	$('body').prepend($('.mint-themes-promo-bar'));
	
	//hide promo bar when clicked
	$( '.mint-themes-promo-bar .close a' ).click(function(e) {
		e.preventDefault();

		$( '.mint-themes-promo-bar' ).slideUp( 'fast' );
	});

});

