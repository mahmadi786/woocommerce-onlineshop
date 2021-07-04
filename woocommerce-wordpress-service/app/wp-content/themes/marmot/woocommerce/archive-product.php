<?php

/**
 * Render Shop Archive
 */
defined('ABSPATH') || exit;

use function Marmot\display_elementor_template;

if (\Marmot\Marmot::is_full_customization_mode()) {

    get_header('shop');

    $tpl = 'noeltmp';
    $templateLoaded = 0;
    if (is_shop()) { // Load shop home
        // TODO template for first page
        $rawtpl = get_theme_mod('hq_woocommerce_general_list_layout');
        if (!empty($rawtpl) && $rawtpl != 'default') {
            $tpl = $rawtpl;
            $templateLoaded = 1;
        }
    } elseif (is_tax()) { // By taxonomy
        global $wp_query;
        $wterm = $wp_query->get_queried_object();
        $rawtpl = \HQLib\get_term_meta($wterm->term_id, 'archive_template');
        if (!empty($rawtpl) && $rawtpl != 'default') {
            $tpl = $rawtpl;
            $templateLoaded = 1;
        }
    }

    if (!$templateLoaded) { // Load archive if other are empty
        $rawtpl = get_theme_mod('hq_product_archive_layout');
        if (!empty($rawtpl) && $rawtpl != 'default') {
            $tpl = $rawtpl;
        }
    }

    if ($tpl != 'noeltmp') {
        display_elementor_template($tpl);
    } else {
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo \Marmot\set_elementor_template_message('archive', 'product');
    }

    get_footer('shop');
} else { // No templates version
    wc_get_template('archive-product.php', null, WC()->plugin_path() . '/templates/');
}