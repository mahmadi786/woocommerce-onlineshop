<?php

/**
 * Render Product
 */
defined('ABSPATH') || exit;

use function Marmot\display_elementor_template;

if (\Marmot\Marmot::is_full_customization_mode()) {

    get_header('shop');

    $tpl = \HQLib\get_post_meta(null, 'woocommerce_product_template');
    if (!empty($tpl) && $tpl != 'default') {
        display_elementor_template($tpl);
    } else {
        $tpl = get_theme_mod('hq_product_single_layout');
        if (!empty($tpl) && $tpl != 'noeltmp') {
            display_elementor_template($tpl);
        } else {
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo \Marmot\set_elementor_template_message('single', 'product');
        }
    }

    get_footer('shop');
} else { // No templates version
    wc_get_template('single-product.php', null, WC()->plugin_path() . '/templates/');
}