 jQuery(function($){
    if($('.hero-slider').length > 0){
        $('.hero-slider').owlCarousel({
            autoplay : true,
            items : 1,
            loop : true,
            nav: false,
            dots : true,
            pause : 6000,
            //animateOut: 'slideOutDown',
            animateOut: finedine_hero_slider.hero_slider_animation,
            mouseDrag  : false
        });
    }
 });
