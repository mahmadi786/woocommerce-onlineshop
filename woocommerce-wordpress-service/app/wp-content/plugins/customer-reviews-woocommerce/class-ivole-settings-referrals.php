<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Ivole_Referrals_Settings' ) ):

class Ivole_Referrals_Settings {

    /**
     * @var Ivole_Referrals_Settings The instance of the trust badges admin menu
     */
    protected $settings_menu;

    /**
     * @var string The slug of this tab
     */
    protected $tab;

    /**
     * @var array The fields for this tab
     */
    protected $settings;

    public function __construct( $settings_menu ) {
        $this->settings_menu = $settings_menu;
        $this->tab = 'referrals';

        add_filter( 'ivole_settings_tabs', array( $this, 'register_tab' ) );
        add_action( 'ivole_settings_display_' . $this->tab, array( $this, 'display' ) );
        add_action( 'ivole_save_settings_' . $this->tab, array( $this, 'save' ) );
    }

    public function register_tab( $tabs ) {
        $tabs[$this->tab] = __( 'Referral Program', 'customer-reviews-woocommerce' );
        return $tabs;
    }

    public function display() {
        $this->init_settings();
        WC_Admin_Settings::output_fields( $this->settings );
    }

    public function save() {
        $this->init_settings();
        WC_Admin_Settings::save_fields( $this->settings );
    }

    protected function init_settings() {
        $this->settings = array(
            array(
                'title' => __( 'Referral Program', 'customer-reviews-woocommerce' ),
                'type'  => 'title',
                'desc'  => '<p>' . sprintf( __( 'Referral marketing is one of the most cost-effective ways to acquire new customers. It is based on the idea that your current customers will spread the word about your store and bring in (or refer) new customers. The problem is that it is not easy for them to do so. We help your customers to spread the word by showing their public reviews to other customers at %1$scusrev.com%2$s.', 'customer-reviews-woocommerce' ), '<a href="https://www.cusrev.com" target="_blank" rel="noopener noreferrer">', '</a>' ) . '</p><p>' . sprintf( __( 'Tracking of referrals requires: (1) %1$sTrust Badges%2$s option has to be enabled, (2) a valid %3$slicense key%4$s (Free or Pro) has to be provided.', 'customer-reviews-woocommerce' ), '<a href="' . admin_url( 'admin.php?page=ivole-reviews-settings&tab=trust_badges' ) . '">', '</a>', '<a href="' . admin_url( 'admin.php?page=ivole-reviews-settings&tab=license-key' ) . '">', '</a>' ) . '</p>',
                'id'    => 'ivole_options'
            ),
            array(
                'title'   => __( 'Track Customer Referrals', 'customer-reviews-woocommerce' ),
                'desc'    => sprintf( __( 'Enable this option to track orders placed by customers who were referred to your store from %1$scusrev.com%2$s. Tracking is implemented via a 30-day cookie created by the plugin for customers who are referred to your store.', 'customer-reviews-woocommerce' ), '<a href="https://www.cusrev.com" target="_blank" rel="noopener noreferrer">', '</a>' ),
                'id'      => 'ivole_referrals_tracking',
                'default' => 'no',
                'type'    => 'checkbox'
            ),
            array(
                'type' => 'sectionend',
                'id'   => 'ivole_options'
            )
        );
    }

    public function is_this_tab() {
        return $this->settings_menu->is_this_page() && ( $this->settings_menu->get_current_tab() === $this->tab );
    }

}

endif;
