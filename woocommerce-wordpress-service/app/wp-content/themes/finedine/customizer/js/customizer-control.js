/**customize-control**/
(function () {
    wp.customize.bind('ready', function () {

        // Only show the color hue control when there's a custom color scheme.
        wp.customize('colorscheme', function (setting) {
            wp.customize.control('colorscheme_hue', function (control) {
                var visibility = function () {
                    if ('custom' === setting.get()) {
                        control.container.slideDown(180);
                    } else {
                        control.container.slideUp(180);
                    }
                };

                visibility();
                setting.bind(visibility);
            });
        });

        // Detect when the front page sections section is expanded (or closed) so we can adjust the preview accordingly.
        wp.customize.section('theme_options', function (section) {
            section.expanded.bind(function (isExpanding) {

                // Value of isExpanding will = true if you're entering the section, false if you're leaving it.
                wp.customize.previewer.send('section-highlight', {expanded: isExpanding});
            });
        });
    });
})(jQuery);

jQuery(document).ready(function () {

    /* === Checkbox Multiple Control === */

    jQuery('.customize-control-checkbox-multiple input[type="checkbox"]').on('change', function () {

            checkbox_values = jQuery(this).parents('.customize-control').find('input[type="checkbox"]:checked').map(
                function () {
                    return this.value;
                }
            ).get().join(',');

            jQuery(this).parents('.customize-control').find('input[type="hidden"]').val(checkbox_values).trigger('change');
        }
    );

});


// jQuery( document ).ready




















