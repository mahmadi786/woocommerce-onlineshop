/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ( $ ) {
		// Site title
		wp.customize( 'blogname', function ( value ) {
			value.bind( function ( to ) {
				$( '#site-title a' ).text( to );
			} );
		} );

		// Site description.
		wp.customize( 'blogdescription', function ( value ) {
			value.bind( function ( to ) {
				$( '#site-description' ).text( to );
			} );
		} );

		// Primary color option
		wp.customize( 'foodhunt_primary_color', function ( value ) {
			value.bind( function ( primaryColor ) {
				// Store internal style for primary color
				var primaryColorStyle = '<style id="foodhunt-internal-primary-color"> .blog-btn,.blog-grid .entry-btn .btn:hover,' +
				'.blog-grid .entry-thumbnail a,.blog-grid .more-link .entry-btn:hover,.blog-img,.chef-content-wrapper,.comment-list .comment-body,' +
				'.contact-map,.header-titlebar-wrapper,.page-header,.single-blog .entry-thumbnail a,.sub-toggle{border-color:' + primaryColor + '}' +
				'#cancel-comment-reply-link,#cancel-comment-reply-link:before,#secondary .entry-title a,#secondary .widget a:hover,' +
				'.blog-grid .byline:hover a,.blog-grid .byline:hover i,.blog-grid .cat-links:hover a,.blog-grid .cat-links:hover i,' +
				'.blog-grid .comments-link:hover a,.blog-grid .comments-link:hover i,.blog-grid .entry-btn .btn:hover,.blog-grid .entry-month-year:hover i,' +
				'.blog-grid .entry-month-year:hover span,.blog-grid .more-link .entry-btn:hover,.comment-author .fn .url:hover,.contact-title,' +
				'.logged-in-as a,.single-blog .byline:hover a,.single-blog .byline:hover i,.single-blog .cat-links:hover a,.single-blog .cat-links:hover i,' +
				'.single-blog .comments-link:hover a,.single-blog .comments-link:hover i,.single-blog .entry-month-year:hover i,' +
				'.single-blog .entry-month-year:hover span,.ticker-title,a,.num-404{color:' + primaryColor + '}' +
				'#secondary .widget-title span::after,#top-footer .widget-title span::after,.about-btn,.blog-grid .entry-title,.contact-icon,' +
				'.single-blog .entry-title,.sub-toggle,.scrollup,.search-form-wrapper .close,.search-form-wrapper .search-submit,.widget_search .search-form button{background:' + primaryColor + '}</style>';

				// Remove previously create internal style and add new one.
				$( 'head #foodhunt-internal-primary-color' ).remove();
				$( 'head' ).append( primaryColorStyle );
			}
			);
		} );
	})( jQuery );
