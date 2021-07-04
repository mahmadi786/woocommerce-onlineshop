<?php

namespace Marmot\Parts;

defined('ABSPATH') || exit;

/**
 * Woocommerce extras
 * 
 * @since 1.0.0
 */
class Woocommerce {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Woocommerce 
     */
    private static $_instance;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Woocommerce
     */
    public static function instance() {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Class constructor
     *
     * @since 1.0.0
     */
    private function __construct() {
        // Turn on Catalog Mode if enabled
        add_filter('woocommerce_is_purchasable', [$this, 'woocommerce_is_purchasable']);

        if (!\Marmot\Marmot::is_full_customization_mode()) {
            add_action('woocommerce_before_shop_loop', [$this, 'woocommerce_before_shop_loop'], 50);
            add_action('woocommerce_before_shop_loop_item', [$this, 'woocommerce_before_shop_loop_item'], 5);
            add_action('woocommerce_after_shop_loop_item', [$this, 'woocommerce_after_shop_loop_item'], 15);
            add_filter('loop_shop_columns', [$this, 'loop_columns'], 100);

            add_action('woocommerce_before_single_product_summary', [$this, 'woocommerce_before_single_product_summary'], 5);
            add_action('woocommerce_after_single_product_summary', [$this, 'woocommerce_after_single_product_summary'], 28);
        }
    }

    /**
     * Turn on catalog mode filter
     * 
     * @since 1.0.0
     * 
     * @param boolean $purchasable
     * @return boolean
     */
    public function woocommerce_is_purchasable($purchasable) {
        if (get_theme_mod('hq_woocommerce_general_catalog_mode')) {
            return false;
        }
        return $purchasable;
    }

    /**
     * Add clearfix element
     */
    public function woocommerce_before_shop_loop() {
        echo '<div class="clearfix"></div>';
    }

    /**
     * Open wrap element
     * 
     * @since 1.0.0
     */
    public function woocommerce_before_shop_loop_item() {
        echo '<div class="product-item-box">';
    }

    /**
     * Close wrap element
     * 
     * @since 1.0.0
     */
    public function woocommerce_after_shop_loop_item() {
        echo '</div>';
    }

    /**
     * Open wrap element
     * 
     * @since 1.0.0
     */
    public function woocommerce_before_single_product_summary() {
        echo '<div class="content-box __product">';
    }

    /**
     * Close wrap element
     * 
     * @since 1.0.0
     */
    public function woocommerce_after_single_product_summary() {
        echo '</div>';
    }

    /**
     * Change number or products per row
     * 
     * @return int
     */
    public function loop_columns() {
        return 3; // 3 products per row
    }

}
