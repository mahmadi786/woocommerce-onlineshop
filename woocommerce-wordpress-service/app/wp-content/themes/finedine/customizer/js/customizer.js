/**customize-control**/
(function () {
    wp.customize.bind('ready', function () {

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
			


