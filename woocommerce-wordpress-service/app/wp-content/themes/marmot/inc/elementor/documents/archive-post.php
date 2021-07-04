<?php

namespace Marmot\Elementor\Documents;

defined('ABSPATH') || exit;

use Elementor\Core\DocumentTypes\Post;
use Elementor\Modules\Library\Documents\Library_Document;

/**
 * 
 * @since 1.0.0
 */
class ArchivePost extends Library_Document {

    /**
     * 
     * @since 1.0.0
     */
    public static function get_properties() {
        $properties = parent::get_properties();

        $properties['location'] = 'archive-post';
        $properties['support_kit'] = true;

        return $properties;
    }

    /**
     * 
     * @since 1.0.0
     */
    public function get_name() {
        return 'archive-post';
    }

    /**
     * 
     * @since 1.0.0
     */
    public static function get_title() {
        return __('Archive Post', 'marmot');
    }

    /**
     * 
     * @since 1.0.0
     */
    public function get_css_wrapper_selector() {
        return '.elementor-archive-post-' . $this->get_main_id();
    }

    /**
     * 
     * @since 1.0.0
     */
    protected function _register_controls() {
        parent::_register_controls();

        Post::register_style_controls($this);
    }

}
