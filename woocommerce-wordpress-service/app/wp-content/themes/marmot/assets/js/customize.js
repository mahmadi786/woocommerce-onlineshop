/* global wp, jQuery */

(function ($, api) {
    $(document).ready(function () {
        // Navigate to customizer section
        $('a[data-focus-section]').on('click', function (e) {
            if (api.section($(this).data('focus-section'))) {
                e.preventDefault();
                api.section($(this).data('focus-section')).focus();
                return false;
            }
        });
        // Navigate to customizer control
        $('a[data-focus-control]').on('click', function (e) {
            if (api.control($(this).data('focus-control'))) {
                e.preventDefault();
                api.control($(this).data('focus-control')).focus();
                return false;
            }
        });
        /*
        api.control('_hqt_theme_customizable_mode').setting.bind(function (active) {
            console.log(active)
        });
         */
    });
}(jQuery, wp.customize));
