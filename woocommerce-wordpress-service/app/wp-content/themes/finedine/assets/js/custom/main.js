/**
 * Created by finedinedev on 1/12/17.
 */
jQuery(document).ready(function ($) {
    $('.slideout-menu-toggle').on('click', function (event) {
        event.preventDefault();
        var slideoutMenu = $('.slide-out');
        var slideoutMenutoggle = $('.slideout-menu-toggle');
        var slideoutMenuWidth = $('.slide-out').outerWidth();

        slideoutMenu.toggleClass("open");

        if (slideoutMenu.hasClass("open")) {
            slideoutMenu.animate({
                left: "0px"
            }, 350);

            slideoutMenutoggle.animate({
                left: "208px"
            }, 350);
            $('.slideout-menu-toggle').addClass('hide-on');
            $("body").addClass("mobile-menu-active");
        } else {
            slideoutMenu.animate({
                left: -slideoutMenuWidth
            }, 350, function () {
                $('.slideout-menu-toggle').removeClass('hide-on');
                $("body").removeClass("mobile-menu-active");
            });

            slideoutMenutoggle.animate({
                left: "4px"
            }, 350);

        }
    });


    $(document).mouseup(function (e) {
        var container = $('.site-header');
        var slideoutMenu = $('.slide-out');
        var slideoutMenutoggle = $('.slideout-menu-toggle');
        var slideoutMenuWidth = $('.slide-out').outerWidth();

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            slideoutMenu.removeClass("open");
            slideoutMenu.animate({
                left: -slideoutMenuWidth
            }, 350, function () {
                $('.slideout-menu-toggle').removeClass('hide-on');
            });

            slideoutMenutoggle.animate({
                left: "4px"
            }, 350);

        }
    });

    if ($('.review-slider').length > 0) {
        $('.review-slider').owlCarousel({
            autoplay: true,
            items: 1,
            loop: true,
            nav: true,
            dots: false,
            pause: 6000,
            smartSpeed: 500,
            mouseDrag: false,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut'
        });
    }

    /* Equal Height */
    equalheight = function (container) {

        var currentTallest = 0,
            currentRowStart = 0,
            rowDivs = new Array(),
            $el,
            topPosition = 0;
        $(container).each(function () {

            $el = $(this);
            $($el).height('auto')
            topPostion = $el.position().top;

            if (currentRowStart != topPostion) {
                for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                    rowDivs[currentDiv].height(currentTallest);
                }
                rowDivs.length = 0; // empty the array
                currentRowStart = topPostion;
                currentTallest = $el.height();
                rowDivs.push($el);
            } else {
                rowDivs.push($el);
                currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
            }
            for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
        });
    }

    $(window).load(function () {
        equalheight('.equal-col');
    });


    $(window).resize(function () {
        equalheight('.equal-col');
    });

    if ($(window).width() >= 768) {
        $('.smooth-scroll').smoothScroll({
            speed: 700,
            easing: 'swing',
            offset: -51
        });
    } else {
        $('.smooth-scroll').smoothScroll({
            speed: 700,
            easing: 'swing',
            offset: -51
        });

    }

    /* Auto Hide Nav below 1200 */
    if ($(window).width() <= 1200) {
        $('.slide-out').removeClass("open");
        $('.slideout-menu-toggle').removeClass('hide-on');

    }

    /**
     * Navigation
     */
    if ($('.page_item_has_children').length > 0) {
        $('.main-navigation li.page_item_has_children > .sub-menu').before('<button class="sub-menu-toggle"><span class="screen-reader-text">Show sub menu</span></button>');
        $('.sub-menu-toggle').click(function (e) {
            // Prevent default behaviour
            e.preventDefault();

            if ($(this).hasClass('menu-open')) {
                $(this).parent('li.page_item_has_children').children('ul').slideToggle('fast');
                $(this).parent('li.page_item_has_children').removeClass('active');
                $('.main-navigation ul li').removeClass('inactive');
                $(this).toggleClass('menu-open');
            } else {
                $('.main-navigation ul li').addClass('inactive');
                $('.main-navigation ul li').removeClass('active');
                $(this).removeClass('menu-open');
                $(this).parent('li.page_item_has_children').children('ul').slideUp('fast');
                $(this).parent('li.page_item_has_children').children('ul').slideToggle('fast');
                $(this).parent('li.page_item_has_children').removeClass('inactive');
                $(this).parent('li.page_item_has_children').addClass('active');
                $(this).toggleClass('menu-open');
            }
        });
    }

    /**
     * Fallback for menu
     */
    if ($('.menu-item-has-children ').length > 0) {
        $('.main-navigation li.menu-item-has-children > .sub-menu').before('<button class="sub-menu-toggle"><span class="screen-reader-text">Show sub menu</span></button>');
        $('.sub-menu-toggle').click(function (e) {
            // Prevent default behaviour
            e.preventDefault();
            if ($(this).hasClass('menu-open')) {

                $(this).parent('li.menu-item-has-children').children('ul').slideToggle('fast');
                $(this).parent('li.menu-item-has-children').removeClass('active');
                $('.main-navigation ul li').removeClass('inactive');
                $(this).toggleClass('menu-open');
            } else {
                $('.main-navigation ul li').addClass('inactive');
                $('.main-navigation ul li').removeClass('active');
                $(this).removeClass('menu-open');
                $(this).parent('li.menu-item-has-children').children('ul').slideUp('fast');
                $(this).parent('li.menu-item-has-children').children('ul').slideToggle('fast');
                $(this).parent('li.menu-item-has-children').removeClass('inactive');
                $(this).parent('li.menu-item-has-children').addClass('active');
                $(this).toggleClass('menu-open');

            }
        });
    }

    /**
     * Height of Primary Navigation
     */
    /* Height of Primary Navigation below 1200 */
    if ($(window).width() >= 1200) {
        var slideoutHeight = $('.slide-out').outerHeight();
        var logoSectionHeight = $('.site-branding').outerHeight();
        var otherElementHeight = logoSectionHeight + 335;
        var navHeight = slideoutHeight - otherElementHeight;
        $('#site-navigation').css({"height": navHeight + "px"});
    }
    $(window).resize(function () {
        /* Height of Primary Navigation below 1200 */
        if ($(window).width() >= 1200) {
            var slideoutHeight = $('.slide-out').outerHeight();
            var logoSectionHeight = $('.site-branding').outerHeight();
            var otherElementHeight = logoSectionHeight + 335;
            var navHeight = slideoutHeight - otherElementHeight;
            $('#site-navigation').css({"height": navHeight + "px"});
        }
    });


    /**
     * WOW Js
     */
    new WOW().init();

    /* Custom scroll on menu */
    jQuery('.scrollbar-inner').scrollbar();

});

// End ready function