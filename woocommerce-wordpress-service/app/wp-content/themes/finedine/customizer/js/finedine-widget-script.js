$(document).ready(function () {
    function change_block_type() {
        $('.cfa-sample,.feature-sample').hide();
        var block = $('.block-type');
        block.each(function () {
            if (this.value == "cfa") {
                $(this).parent().parent().find('.feature-wid').hide();
                $(this).parent().parent().find('.feature-sample').hide();
                $(this).parent().parent().find('.cfa-wid').show();
                $(this).parent().parent().find('.cfa-sample').show();
            }
            if (this.value == "featured") {
                $(this).parent().parent().find('.feature-wid').show();
                $(this).parent().parent().find('.feature-sample').show();
                $(this).parent().parent().find('.cfa-wid').hide();
                $(this).parent().parent().find('.cfa-sample').hide();
            }
        });
    }

    $(document).on('click', '.widget-top', function () {
        change_block_type();
    });
    $(document).on('hover', '.wp-full-overlay-sidebar-content', function () {
        change_block_type();
    });

    $(document).on('change', '.block-type', function () {
        var block_active_val = jQuery(this).val();
        if (this.value == "cfa") {
            $(this).parent().parent().find('.feature-wid').hide();
            $(this).parent().parent().find('.feature-sample').hide();
            $(this).parent().parent().find('.cfa-wid').show();
            $(this).parent().parent().find('.cfa-sample').show();
        }
        if (this.value == "featured") {
            $(this).parent().parent().find('.feature-wid').show();
            $(this).parent().parent().find('.feature-sample').show();
            $(this).parent().parent().find('.cfa-wid').hide();
            $(this).parent().parent().find('.cfa-sample').hide();
        }
    });
});  		
   