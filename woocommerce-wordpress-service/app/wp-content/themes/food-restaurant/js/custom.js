jQuery(function($){
	"use strict";
	jQuery('.main-menu-navigation > ul').superfish({
		delay:       500,                            
		animation:   {opacity:'show',height:'show'},  
		speed:       'fast'                        
	});
});

function food_restaurant_resmenu_open() {
	window.food_restaurant_mobileMenu=true;
	jQuery(".sidebar").addClass('menubar');
}
function food_restaurant_resmenu_close() {
	window.food_restaurant_mobileMenu=false;
	jQuery(".sidebar").removeClass('menubar');
}

jQuery(document).ready(function () {

	window.food_restaurant_currentfocus=null;
  	food_restaurant_checkfocusdElement();
	var food_restaurant_body = document.querySelector('body');
	food_restaurant_body.addEventListener('keyup', food_restaurant_check_tab_press);
	var food_restaurant_gotoHome = false;
	var food_restaurant_gotoClose = false;
	window.food_restaurant_mobileMenu=false;
 	function food_restaurant_checkfocusdElement(){
	 	if(window.food_restaurant_currentfocus=document.activeElement.className){
		 	window.food_restaurant_currentfocus=document.activeElement.className;
	 	}
 	}
	function food_restaurant_check_tab_press(e) {
		"use strict";
		// pick passed event or global event object if passed one is empty
		e = e || event;
		var activeElement;

		if(window.innerWidth < 999){
			if (e.keyCode == 9) {
				if(window.food_restaurant_mobileMenu){
					if (!e.shiftKey) {
						if(food_restaurant_gotoHome) {
							jQuery( ".main-menu-navigation ul:first li:first a:first-child" ).focus();
						}
					}
					if (jQuery("a.closebtn.responsive-menu").is(":focus")) {
						food_restaurant_gotoHome = true;
					} else {
						food_restaurant_gotoHome = false;
					}

			}else{

					if(window.food_restaurant_currentfocus=="resToggle"){
						jQuery( "" ).focus();
					}
				}
			}
		}
		if (e.shiftKey && e.keyCode == 9) {
			if(window.innerWidth < 999){
				if(window.food_restaurant_currentfocus=="header-search"){
					jQuery(".resToggle").focus();
				}else{
					if(window.food_restaurant_mobileMenu){
						if(food_restaurant_gotoClose){
							jQuery("a.closebtn.responsive-menu").focus();
						}
						if (jQuery( ".main-menu-navigation ul:first li:first a:first-child" ).is(":focus")) {
							food_restaurant_gotoClose = true;
						} else {
							food_restaurant_gotoClose = false;
					}
				
				}else{

					if(window.food_restaurant_mobileMenu){
					}
				}

				}
			}
		}
	 	food_restaurant_checkfocusdElement();
	}

});

(function( $ ) {

	$(window).scroll(function(){
		var sticky = $('.sticky-menubox'),
		scroll = $(window).scrollTop();

		if (scroll >= 100) sticky.addClass('fixed-menubox');
		else sticky.removeClass('fixed-menubox');
	});

})( jQuery );