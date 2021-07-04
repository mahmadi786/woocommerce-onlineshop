<?php

namespace Marmot\Elementor;

defined('ABSPATH') || exit;

use Elementor\Plugin;

class Templates_Types_Manager {

    /**
     * Doctypes list
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    private $docs_types = [];

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
        // Priority 11 - to Overwrite Elementor Kit
        add_action('elementor/documents/register', [$this, 'register_documents'], 11);
    }

    /**
     * Register special marmot documents
     * 
     * @since 1.0.0
     */
    public function register_documents() {
        $this->docs_types = [
            'header' => Documents\Header::get_class_full_name(),
            'footer' => Documents\Footer::get_class_full_name(),
            'single' => Documents\Single::get_class_full_name(),
            'archive' => Documents\Archive::get_class_full_name(),
            'archive-post' => Documents\ArchivePost::get_class_full_name(),
            // Overwrite Elementor Kit
            'kit' => Documents\Kit::get_class_full_name(),
        ];

        foreach ($this->docs_types as $type => $class_name) {
            Plugin::$instance->documents->register_document_type($type, $class_name);
        }
    }

}
