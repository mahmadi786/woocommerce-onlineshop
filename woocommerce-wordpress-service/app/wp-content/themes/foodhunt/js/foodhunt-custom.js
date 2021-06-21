jQuery( document ).ready( function () {

	// Slider Setting
	if ( typeof jQuery.fn.bxSlider !== 'undefined' && typeof foodhunt_slider_value !== 'undefined' ) {

		/* global foodhunt_slider_value */
		var slider_controls = ( '1' === foodhunt_slider_value.slider_controls ? false : true );
		var slider_pager = ( '1' === foodhunt_slider_value.slider_pager ? false : true );

		jQuery( '#home-slider .bxslider' ).bxSlider( {
			auto: true,
			mode: 'fade',
			caption: true,
			controls: slider_controls,
			pager: slider_pager,
			prevText: '<i class="fa fa-angle-left"> </i>',
			nextText: '<i class="fa fa-angle-right"> </i>',
			onSliderLoad: function () {
				jQuery( '#home-slider .bxslider' ).css( 'visibility', 'visible' );
			}
		} );
	}

	//Ticker Setting
	if ( typeof jQuery.fn.ticker !== 'undefined' ) {
		jQuery( '.header-ticker' ).ticker();
	}

	jQuery( window ).on( 'load', function () {
		jQuery( '.header-ticker > div' ).css( 'visibility', 'visible' );
	} );

	jQuery( '.mobile-menu-wrapper .menu-toggle' ).click( function () {
		jQuery( '.mobile-menu-wrapper .menu' ).slideToggle( 'slow' );
	} );

	jQuery( '.mobile-menu-wrapper .menu-item-has-children,.mobile-menu-wrapper .page_item_has_children' ).append( '<span class="sub-toggle"> <i class="fa fa-angle-right"></i> </span>' );

	jQuery( '.mobile-menu-wrapper .sub-toggle' ).click( function () {
		jQuery( this ).parent( '.page_item_has_children,.menu-item-has-children' ).children( 'ul.sub-menu,ul.children' ).first().slideToggle( '1000' );
		jQuery( this ).children( '.fa-angle-right' ).first().toggleClass( 'fa-angle-down' );
	} );

	// scroll up setting
	jQuery( ".scrollup" ).hide();
	jQuery( function () {
		jQuery( window ).scroll( function () {
			if ( jQuery( this ).scrollTop() > 800 ) {
				jQuery( '.scrollup' ).fadeIn();
			} else {
				jQuery( '.scrollup' ).fadeOut();
			}
		} );
		jQuery( '.scrollup' ).click( function () {
			jQuery( 'body,html' ).animate( {
				scrollTop: 0
			}, 1400 );
			return false;
		} );
	} );

	// Parallax Setting
	if ( typeof jQuery.fn.parallax !== 'undefined' ) {
		jQuery( window ).on( 'load', function () {
			var width = Math.max( window.innerWidth, document.documentElement.clientWidth );

			if ( width && width > 768 ) {
				jQuery( '.section-wrapper-with-bg-image' ).each( function () {
					jQuery( this ).parallax( 'center', 0.6, true );
				} );
			}
		} );
	}

	var width = Math.max( window.innerWidth, document.documentElement.clientWidth );

	if ( width && width <= 768 ) {
		jQuery( '.home-search' ).insertAfter( '.menu-toggle' );
	}

	//search popup
	jQuery( '.search-icon' ).click( function () {
		jQuery( '.search-box' ).addClass( 'active' );
		jQuery( '#page' ).css( {
			'filter': 'blur(8px)',
			'-webkit-filter': 'blur(8px)',
			'-moz-filter': 'blur(8px)'
		} );

		// focus after some time to fix conflict with toggleClass
		setTimeout(function() {
			document.getElementsByClassName( 'search-box active' )[0].getElementsByTagName( 'input' )[0].focus();
		}, 200);
	} );

	// Close search form
	var closeSearchForm = function () {
		jQuery( '.search-box' ).removeClass( 'active' );
		jQuery( '#page' ).css( {
			'filter': 'blur(0px)',
			'-webkit-filter': 'blur(0px)',
			'-moz-filter': 'blur(0px)'
		} );

	};

	// on close me button
	jQuery( '.search-form-wrapper .close' ).click( closeSearchForm ); // hide on close me click

	// on esc key
	document.addEventListener( 'keyup', function ( e ) {
		if ( document.querySelectorAll( '.search-box.active' ).length > 0 && e.keyCode === 27 ) {
			closeSearchForm();
		}
	} );

	//stikcy menu
	var previousScroll = 0, headerOrgOffset = jQuery( '.bottom-header' ).offset().top;

	jQuery( window ).scroll( function () {
		var currentScroll = jQuery( this ).scrollTop();
		if ( currentScroll > headerOrgOffset ) {
			if ( currentScroll > previousScroll ) {
				jQuery( '.bottom-header' ).addClass( 'nav-up' );
			} else {
				jQuery( '.bottom-header' ).addClass( 'nav-down' );
				jQuery( '.bottom-header' ).removeClass( 'nav-up' );
			}
		} else {
			jQuery( '.bottom-header' ).removeClass( 'nav-down' );
		}
		previousScroll = currentScroll;
	} );
} );

// Show Submenu on click on touch enabled deviced
( function () {
	var container;
	container = document.getElementById( 'site-navigation' );

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function ( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function ( e ) {
				var menuItem = this.parentNode, i;

				if ( !menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[ i ] ) {
							continue;
						}
						menuItem.parentNode.children[ i ].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[ i ].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
} )();

jQuery( document ).ready( function () {


	/**
	 * Sets or removes .focus class on an element.
	 */
	var toggleFocus = function () {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {
			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	};

	var addFocus = function ( nav, index  ) {
		var menu, links, i, len;

		if ( ! nav ) {
			return;
		}

		menu = nav.getElementsByTagName( 'ul' )[0];

		// Get all the link elements within the menu.
		links = menu.getElementsByTagName( 'a' );

		// Each time a menu link is focused or blurred, toggle focus.
		for ( i = 0, len = links.length; i < len; i++ ) {
			links[i].addEventListener( 'focus', toggleFocus, true );
			links[i].addEventListener( 'blur', toggleFocus, true );
		}

	};

	var navs = document.getElementsByClassName( 'main-navigation' );

	for ( var i = 0; i <= navs.length; i++ ) {
		addFocus( navs[i], i );
	}

} );
