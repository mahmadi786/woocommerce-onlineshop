<?php

namespace Marmot;

defined('ABSPATH') || exit;

/**
 * LayerSlider
 * 
 * LayerSlider integration
 * 
 * @since 1.0.0
 */
class Layerslider {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Layerslider 
     */
    private static $_instance = null;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Layerslider
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
        if (function_exists('layerslider_set_as_theme')) {
            layerslider_set_as_theme();
        }
        if (function_exists('layerslider_hide_promotions')) {
            layerslider_hide_promotions();
        }
    }

}
