<?php

namespace Marmot\Parts;

defined('ABSPATH') || exit;

/**
 * Theme Blog part
 * 
 * @since 1.0.0
 */
class Blog {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Blog 
     */
    private static $_instance;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Blog
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
        self::$_instance = &$this;

        add_filter('excerpt_length', [$this, 'excerpt_length']);
    }

    public function excerpt_length($length) {
        return empty(get_theme_mod('hq_blog_home_excerpt_length')) ? $length : get_theme_mod('hq_blog_home_excerpt_length');
    }

}
