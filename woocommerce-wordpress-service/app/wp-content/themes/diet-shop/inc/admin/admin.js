/* global ajaxurl, futurioNUX */
( function( wp, $ ) {
	'use strict';

	if ( ! wp ) {
		return;
	}

	$( function() {
		// Dismiss notice
		$( document ).on( 'click', '.sf-notice-nux .notice-dismiss', function() {
			
			$.ajax({
				type:     'POST',
				url:      ajaxurl,
				data:     { nonce: diet_shop_nux.nonce, action: 'diet_shop_dismiss_notice' },
				dataType: 'json'
			});
		});
		
		
	});
  
  
})( window.wp, jQuery );