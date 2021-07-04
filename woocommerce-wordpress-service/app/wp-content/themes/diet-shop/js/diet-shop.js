// js Document

    // Project:        Ttulsi - Health Supplement and Landing Page HTML.
    // Version:        1.0
    // Last change:    18/04/2019.


(function($) {
    "use strict";
    
    
    $(document).on ('ready', function (){
        
        // -------------------- Navigation Scroll
       
		$("#sticky-header").sticky({topSpacing:0});
        // ------------------------- Mobile Dropdown Submenu
        if($(".navbar").length) {
			
          $('.diet-shop-main-menu li.menu-item-has-children').append(function () {
            return '<i class="icon fa fa-angle-down"></i>';
          });
          $('.diet-shop-main-menu li.menu-item-has-children .icon').on('click', function () {
			$(this).toggleClass('fa-angle-up');
            $(this).parent('li').children('ul').eq(0).slideToggle();
          });
        }


        // -------------------- Remove Placeholder When Focus Or Click
        $("input,textarea").each( function(){
            $(this).data('holder',$(this).attr('placeholder'));
            $(this).on('focusin', function() {
                $(this).attr('placeholder','');
            });
            $(this).on('focusout', function() {
                $(this).attr('placeholder',$(this).data('holder'));
            });     
        });
        


        // -------------------- From Bottom to Top Button
        //Check to see if the window is top if not then display button
        $(window).on('scroll', function (){
          if ($(this).scrollTop() > 200) {
            $('.scroll-top').fadeIn();
          } else {
            $('.scroll-top').fadeOut();
          }
        });


        //---------------------- Click event to scroll to top
        $('.scroll-top').on('click', function() {
          $('html, body').animate({scrollTop : 0},1500);
          return false;
        });


     
        // Activate scrollspy to add active class to navbar items on scroll
        $('body').scrollspy({
          target: 'body',
          offset: 20
        });
          
		  // Keybord use
		 if( $('.diet-shop-main-menu li > a').length ){
			$( ".diet-shop-main-menu li > a" ).keyup(function() {
				
				$(this).parent('li').prev('li').removeClass('opened');	
				
				if( $(this).parents('li.menu-item-has-children').length ){
				
					$(this).parent('li').addClass('opened');
				}
				
			});
		} 
		$( ".theme-main-header .navbar-toggler" ).keyup(function() {
			
			$('.navbar-collapse.collapse').addClass('show');
		});
		
		$('.inner-banner,.content-area-wrap,.post-meta a,.entry-heading a ').on('keydown', function(event) {
			$('.diet-shop-main-menu li').removeClass('opened');
			$('.navbar-collapse.collapse').removeClass('show');
		});
		
		if( $('.gallery-media.wp-block-gallery ul').length ){
			$('.gallery-media.wp-block-gallery ul').owlCarousel({
				loop:true,
				margin:10,
				nav:false,
				responsive:{
					0:{
						items:1
					},
					600:{
						items:1
					},
					1000:{
						items:1
					}
				}
			});
		}
        
    });

  /*  
    $(window).on ('load', function (){ // makes sure the whole site is loaded

        // -------------------- Site Preloader
        $('#ctn-preloader').fadeOut(); // will first fade out the loading animation
        $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
        $('body').delay(350).css({'overflow':'visible'});


    });*/
    
})(jQuery);