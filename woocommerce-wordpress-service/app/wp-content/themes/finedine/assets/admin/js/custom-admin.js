(function ($) {
    //"use strict";
    jQuery(document).ready(function ($) {

        //check the active badge

        $(document).on('click', '.badge-plugins-show,.badge-static-show', function () {
            var classlist = $(this).attr('class');
            var classlist_with_show = classlist.replace("show", "hide");
            var classlist_with_show_visi = classlist_with_show.replace("visibility", "hidden");
            var data_id = $(this).attr('data-id');

            $(this).removeClass(classlist).addClass(classlist_with_show_visi);
            var badge_count = jQuery('.action-required-tab .dashicons-visibility ').length;
            $('.update-badge').text(badge_count);

            if (badge_count == 0) {
                $('.update-badge').addClass('opacity-zero');
                $('.sm-badge').addClass('opacity-zero');
            } else {
                $('.update-badge').removeClass('opacity-zero');
                $('.sm-badge').removeClass('opacity-zero');
            }

            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    action: 'finedine_update_recommended_badge',
                    data_id: data_id,
                },
                success: function (response) {
                }
            });

        });
        $(document).on('click', '.badge-plugins-hide,.badge-static-hide', function () {
            var classlist = $(this).attr('class');
            var classlist_with_show = classlist.replace("hide", "show");
            var classlist_with_show_visi = classlist_with_show.replace("hidden", "visibility");
            var data_id = $(this).attr('data-id');

            $(this).removeClass(classlist).addClass(classlist_with_show_visi);
            var badge_count = jQuery('.action-required-tab .dashicons-visibility ').length;
            $('.update-badge').text(badge_count);

            if (badge_count == 0) {
                $('.update-badge').addClass('opacity-zero');
                $('.sm-badge').addClass('opacity-zero');
            } else {
                $('.update-badge').removeClass('opacity-zero');
                $('.sm-badge').removeClass('opacity-zero');
            }

            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    action: 'finedine_update_recommended_badge',
                    data_id: data_id,
                },
                success: function (response) {
                }
            });

        });
    });
})(jQuery);
