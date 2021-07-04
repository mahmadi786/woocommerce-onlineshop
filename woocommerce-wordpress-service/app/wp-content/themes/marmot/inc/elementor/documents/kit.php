<?php

namespace Marmot\Elementor\Documents;

defined('ABSPATH') || exit;

use Elementor\Core\Kits\Documents\Kit as Elementor_Kit;

/**
 * Extends Elementor Kit
 * 
 * @since 1.0.0
 */
class Kit extends Elementor_Kit {

    /**
     * @var \Elementor\Core\Kits\Documents\Tabs\Tab_Base[]
     */
    private $tabs;

    public function __construct(array $data = []) {
        parent::__construct($data);

        $this->tabs = [
            'global-colors' => new \Elementor\Core\Kits\Documents\Tabs\Global_Colors($this),
            'global-typography' => new \Elementor\Core\Kits\Documents\Tabs\Global_Typography($this),
            'theme-style-typography' => new \Elementor\Core\Kits\Documents\Tabs\Theme_Style_Typography($this),
            'theme-style-buttons' => new Tabs\Theme_Style_Buttons($this), // HQ Theme Style Buttons
            'theme-style-images' => new \Elementor\Core\Kits\Documents\Tabs\Theme_Style_Images($this),
            'theme-style-form-fields' => new Tabs\Theme_Style_Form_Fields($this), // HQ Theme Style Form Fields
            'settings-site-identity' => new \Elementor\Core\Kits\Documents\Tabs\Settings_Site_Identity($this),
            'settings-background' => new \Elementor\Core\Kits\Documents\Tabs\Settings_Background($this),
            'settings-layout' => new \Elementor\Core\Kits\Documents\Tabs\Settings_Layout($this),
            'settings-lightbox' => new \Elementor\Core\Kits\Documents\Tabs\Settings_Lightbox($this),
            'settings-custom-css' => new \Elementor\Core\Kits\Documents\Tabs\Settings_Custom_CSS($this),
        ];
    }

    public function save($data) {
        $saved = parent::save($data);

        if ($saved) {
            foreach ($this->tabs as $tab) {
                $tab->on_save($data);
            }
        }

        return $saved;
    }

    /**
     * @since 2.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->register_document_controls();

        foreach ($this->tabs as $tab) {
            $tab->register_controls();
        }
    }

}
