/**
 * Theme functions file.
 */
(function ($) {

    var Marmot = {
        init: function () {
            Marmot.animateScroll();
            Marmot.tabKeyNavigationSupport();
        },
        animateScroll: function () {
            // Internal links - smooth scroll
            $('a[href*="#"]:not([href="#"]):not(.hq-noscroll):not(.wc-tabs a)').click(function () {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        // http://api.jquery.com/animate/
                        $('html, body').animate({
                            scrollTop: target.offset().top - 50
                        }, 500);
                        return false;
                    }
                }
            });

            // Use empty links in menu - prevent scroll to top
            $('a[href="#"]').click(function (e) {
                e.preventDefault();
            });
        },
        tabKeyNavigationSupport: function () {
            var links, i, len,
                    menu = document.querySelector('.site-navigation');

            if (!menu) {
                return false;
            }

            links = menu.getElementsByTagName('a');

            // Each time a menu link is focused or blurred, toggle focus.
            for (i = 0, len = links.length; i < len; i++) {
                links[i].addEventListener('focus', toggleFocus, true);
                links[i].addEventListener('blur', toggleFocus, true);
            }

            //Sets or removes the .focus class on an element.
            function toggleFocus() {
                var self = this;

                // Move up through the ancestors of the current link until we hit .primary-menu.
                while (-1 === self.className.indexOf('primary-menu')) {
                    // On li elements toggle the class .focus.
                    if ('li' === self.tagName.toLowerCase()) {
                        self.classList.toggle('focus');
                    }
                    self = self.parentElement;
                }
            }
        }
    };

    $(document).ready(function () {
        Marmot.init();
    });
})(jQuery);