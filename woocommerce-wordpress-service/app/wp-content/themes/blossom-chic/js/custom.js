jQuery(document).ready(function($){    
    
    var rtl, mrtl, slider_auto;
    
    if( blossom_chic_data.rtl == '1' ){
        rtl = true;
        mrtl = false;
    }else{
        rtl = false;
        mrtl = true;
    }

    if( blossom_chic_data.auto == '1' ){
        slider_auto = true;
    }else{
        slider_auto = false;
    }

    //banner layout two
    $('.slider-layout-two').owlCarousel({
        loop       : true,
        nav        : true,
        items      : 1,
        dots       : false,
        autoplay   : slider_auto,
        rtl        : rtl,
        animateOut : blossom_chic_data.animation,
        responsive : {
            1200: {
                margin: 130,
                stagePadding: 215
            },
            1025: {
                margin: 50,
                stagePadding: 85
            },
            768: {
                margin: 5,
                stagePadding: 85
            },
            0: {
                margin: 10,
                stagePadding: 30
            }
        }
    });  
});