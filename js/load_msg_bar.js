jQuery(document).ready(function($) {

	//Header Sale Bar Cookie
	$('#close_header_sale').click(function() {
		document.cookie = 'showmessagebar=false';
	});
	
	//move bar to top of page
	$('body').prepend($('.moveplugins-promo-bar'));
	
	//hide promo bar when clicked
	$( '.moveplugins-promo-bar .close a' ).click(function(e) {
		e.preventDefault();

		$( '.moveplugins-promo-bar' ).slideUp( 'fast' );
	});

});

