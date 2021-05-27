( function( $ ) {

	$( document ).ready(function($){

	    // Trigger mobile menu.
	    $('#mobile-trigger').sidr({
			timing: 'ease-in-out',
			speed: 500,
			source: '#mob-menu',
			name: 'sidr-main'
	    });

		// Fix footer widget.
		if ( $( '#footer-widgets' ).length > 0 ) {
			var footerWidgetHeight = $( '#footer-widgets' ).height();
			$( '#footer-widgets' ).height( footerWidgetHeight );
			$( '#footer-widgets .first-col.footer-widget-area' ).height( footerWidgetHeight - 25 );
		}

		// Implement go to top.
		$( window ).scroll(function(){
			if ($( this ).scrollTop() > 100) {
				$( '#btn-scrollup' ).fadeIn();
			} else {
				$( '#btn-scrollup' ).fadeOut();
			}
		});

		$( '#btn-scrollup' ).click(function(){
			$( 'html, body' ).animate( { scrollTop: 0 }, 600 );
			return false;
		});

	});

} )( jQuery );
