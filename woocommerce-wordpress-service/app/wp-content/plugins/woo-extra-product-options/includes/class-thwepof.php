<?php
/**
 * Woo Extra Product Options Settings
 *
 * @author   ThemeHiGH
 * @category Admin
 */

if(!defined('ABSPATH')){ exit; }

if(!class_exists('THWEPOF')) :
class THWEPOF {
	protected static $_instance = null;
	public $wepof_admin = null;
	public $wepof_public = null;

	public function __construct() {
		$required_classes = apply_filters('th_wepof_require_class', array(
			'common' => array(
				'includes/model/rules/class-wepof-condition.php',
				'includes/model/rules/class-wepof-condition-set.php',
				'includes/model/rules/class-wepof-rule.php',
				'includes/model/rules/class-wepof-rule-set.php',
				'includes/model/fields/class-wepof-field.php',
				'includes/model/fields/class-wepof-field-inputtext.php',
				'includes/model/fields/class-wepof-field-hidden.php',
				'includes/model/fields/class-wepof-field-number.php',
				'includes/model/fields/class-wepof-field-tel.php',
				'includes/model/fields/class-wepof-field-password.php',
				'includes/model/fields/class-wepof-field-textarea.php',
				'includes/model/fields/class-wepof-field-select.php',
				'includes/model/fields/class-wepof-field-checkbox.php',
				'includes/model/fields/class-wepof-field-checkboxgroup.php',
				'includes/model/fields/class-wepof-field-radio.php',
				'includes/model/fields/class-wepof-field-datepicker.php',
				'includes/model/fields/class-wepof-field-colorpicker.php',
				'includes/model/fields/class-wepof-field-heading.php',
				'includes/model/fields/class-wepof-field-paragraph.php',
				'includes/model/class-wepof-section.php',

				'includes/utils/class-thwepof-utils.php',
				'includes/utils/class-thwepof-utils-field.php',
				'includes/utils/class-thwepof-utils-section.php',
				'includes/class-thwepof-data.php',

				/*'classes/fe/rules/class-wepof-condition.php',
				'classes/fe/rules/class-wepof-condition-set.php',
				'classes/fe/rules/class-wepof-rule.php',
				'classes/fe/rules/class-wepof-rule-set.php',
				'classes/fe/fields/class-wepof-field.php',
				'classes/fe/fields/class-wepof-field-inputtext.php',
				'classes/fe/fields/class-wepof-field-hidden.php',
				'classes/fe/fields/class-wepof-field-number.php',
				'classes/fe/fields/class-wepof-field-tel.php',
				'classes/fe/fields/class-wepof-field-password.php',
				'classes/fe/fields/class-wepof-field-textarea.php',
				'classes/fe/fields/class-wepof-field-select.php',
				'classes/fe/fields/class-wepof-field-checkbox.php',
				'classes/fe/fields/class-wepof-field-checkboxgroup.php',
				'classes/fe/fields/class-wepof-field-radio.php',
				'classes/fe/fields/class-wepof-field-datepicker.php',
				'classes/fe/fields/class-wepof-field-colorpicker.php',
				'classes/fe/fields/class-wepof-field-heading.php',
				'classes/fe/fields/class-wepof-field-paragraph.php',
				'classes/fe/class-wepof-section.php',
				'classes/fe/class-wepof-utils.php',
				'classes/fe/class-wepof-utils-field.php',
				'classes/fe/class-wepof-utils-section.php',
				'classes/fe/class-wepof-data.php',*/
			),
			'admin' => array(
				'admin/class-thwepof-admin-form.php',
				'admin/class-thwepof-admin-form-section.php',
				'admin/class-thwepof-admin-form-field.php',

				'admin/class-thwepof-admin-settings.php',
				'admin/class-thwepof-admin-settings-general.php',
				'admin/class-thwepof-admin-settings-advanced.php',
				'admin/class-thwepof-admin-settings-pro.php',

				//'classes/class-wepof-settings-page.php',
				//'classes/fe/class-wepof-product-options-settings.php',
				//'classes/fe/class-thwepof-admin-settings-advanced.php',
			),
			'public' => array(
				'public/class-thwepof-public.php',
				//'classes/fe/class-wepof-product-options-frontend.php',
			),
		));

		$this->include_required( $required_classes );
		$this->may_copy_older_version_settings();

		add_action('admin_menu', array($this, 'admin_menu'));
		add_filter('woocommerce_screen_ids', array($this, 'add_screen_id'));
		add_filter('plugin_action_links_'.THWEPOF_BASE_NAME, array($this, 'add_settings_link'));
		add_action('upgrader_process_complete', array($this, 'may_copy_older_version_settings'));

		add_action('wp_ajax_dismiss_thwepof_review_request_notice', array($this, 'dismiss_thwepof_review_request_notice'));
		add_action('wp_ajax_skip_thwepof_review_request_notice', array($this, 'skip_thwepof_review_request_notice'));

		$this->init();
	}

	public static function instance() {
		if(is_null(self::$_instance)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	protected function include_required( $required_classes ) {
		if(!function_exists('is_plugin_active')) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		foreach($required_classes as $section => $classes ) {
			foreach( $classes as $class ){
				if('common' == $section  || ('public' == $section && !is_admin() || ( defined('DOING_AJAX') && DOING_AJAX) )
					|| ('admin' == $section && is_admin()) && file_exists( THWEPOF_PATH . $class )){
					require_once( THWEPOF_PATH . $class );
				}
			}
		}
	}

	public function init() {
		$wepo_data = THWEPOF_Data::instance();
		add_action('wp_ajax_thwepof_load_products', array($wepo_data, 'load_products_ajax'));
    	add_action('wp_ajax_nopriv_thwepof_load_products', array($wepo_data, 'load_products_ajax'));

		if(!is_admin() || (defined( 'DOING_AJAX' ) && DOING_AJAX)){
			$this->wepof_public = new THWEPOF_Public();
		}else if(is_admin()){
			$this->wepof_admin = THWEPOF_Admin_Settings_General::instance();
		}

		//$this->may_copy_older_version_settings();
	}

	public function admin_menu() {
		$capability = THWEPOF_Utils::wepo_capability();
		$this->screen_id = add_submenu_page('edit.php?post_type=product', __('WooCommerce Extra Product Option', 'woo-extra-product-options'),
		__('Extra Product Option', 'woo-extra-product-options'), $capability, 'thwepof_extra_product_options', array($this, 'output_settings'));

		add_action('admin_print_scripts-'. $this->screen_id, array($this, 'enqueue_admin_scripts'));
	}

	public function add_screen_id($ids){
		$ids[] = 'product_page_thwepof_extra_product_options';
		$ids[] = strtolower(__('Product', 'woocommerce')) .'_page_thwepof_extra_product_options';
		return $ids;
	}

	public function add_settings_link($links) {
		$settings_link = '<a href="'.esc_url(admin_url('edit.php?post_type=product&page=thwepof_extra_product_options')).'">'. __('Settings') .'</a>';
		array_unshift($links, $settings_link);
		$premium_link = '<a href="https://www.themehigh.com/product/woocommerce-extra-product-options?utm_source=free&utm_medium=plugin_action_link&utm_campaign=wepo_upgrade_link" style="color:green; font-weight:bold" target="_blank">'. __('Get Pro') .'</a>';
		array_push($links, $premium_link);
		return $links;
	}

	public function output_settings() {
		// echo '<div class="wrap">';
		// echo '<h2></h2>';
		//$this->output_old_settings_copy_message();
		$tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general_settings';

		echo '<div class="thwepof-wrap">';
		if($tab === 'advanced_settings'){			
			$advanced_settings = THWEPOF_Admin_Settings_Advanced::instance();	
			$advanced_settings->render_page();			
		}elseif($tab === 'pro'){
			$pro_details = THWEPOF_Admin_Settings_Pro::instance();	
			$pro_details->render_page();
		}else{
			$general_settings = THWEPOF_Admin_Settings_General::instance();
			$general_settings->render_page();
		}
		echo '</div">';
		// echo '</div>';
	}

	public function enqueue_admin_scripts() {
		$debug_mode = apply_filters('thwepof_debug_mode', false);
		$suffix = $debug_mode ? '' : '.min';

		wp_enqueue_style (array('woocommerce_admin_styles', 'jquery-ui-style'));
		wp_enqueue_style ('thwepof-admin-style', THWEPOF_URL.'admin/assets/css/thwepof-admin'. $suffix .'.css', THWEPOF_VERSION);
		wp_enqueue_script('thwepof-admin-script', THWEPOF_URL.'admin/assets/js/thwepof-admin'. $suffix .'.js',
		array('jquery', 'jquery-ui-sortable', 'jquery-tiptip', 'wc-enhanced-select', 'selectWoo'), THWEPOF_VERSION, false);

		$wepof_var = array(
			'load_product_nonce'	=> wp_create_nonce('wepof-load-products'),
		);
		wp_localize_script('thwepof-admin-script', 'thwepof_admin_var', $wepof_var);
	}

	public function output_old_settings_copy_message(){
		$new_settings = THWEPOF_Utils::get_sections();
		if($new_settings){
			return;
		}

		$custom_fields = get_option('thwepof_custom_product_fields');

		if(is_array($custom_fields) && !empty($custom_fields)){
			if(isset($_POST['may_copy_settings']))
				$result = $this->may_copy_older_version_settings();

			?>
			<form method="post" action="">
				<p>Copy older version settings <input type="submit" name="may_copy_settings" value="Copy Settings" /></p>
	        </form>
			<?php
		}
	}

	public function may_copy_older_version_settings(){
		$new_settings = THWEPOF_Utils::get_sections();
		if($new_settings){
			return;
		}

		$custom_fields = get_option('thwepof_custom_product_fields');
		if(is_array($custom_fields) && !empty($custom_fields)){
			$fields_before = isset($custom_fields['woo_before_add_to_cart_button']) ? $custom_fields['woo_before_add_to_cart_button'] : false;
			$fields_after = isset($custom_fields['woo_after_add_to_cart_button']) ? $custom_fields['woo_after_add_to_cart_button'] : false;

			$section_before = THWEPOF_Utils_Section::prepare_default_section();
			$section_after = THWEPOF_Utils_Section::prepare_default_section();

			if(is_array($fields_before)){
				foreach($fields_before as $key => $field){
					$section_before = THWEPOF_Utils_Section::add_field($section_before, $field);
				}
			}

			if(is_array($fields_after)){
				foreach($fields_after as $key => $field){
					$section_after = THWEPOF_Utils_Section::add_field($section_after, $field);
				}
			}

			$result1 = $result2 = false;

			if(THWEPOF_Utils_Section::has_fields($section_after)){
				if(THWEPOF_Utils_Section::has_fields($section_before)){
					$section_before->set_property('id', 'default');
					$section_before->set_property('name', 'default');
					$section_before->set_property('title', 'Section 1');

					$section_after->set_property('id', 'section_2');
					$section_after->set_property('name', 'section_2');
					$section_after->set_property('title', 'Section 2');

					$result1 = THWEPOF_Utils::update_section($section_before);
				}else{
					$result1 = true;
				}
				$section_after->set_property('position', 'woo_after_add_to_cart_button');
				$result2 = THWEPOF_Utils::update_section($section_after);

			}else if(THWEPOF_Utils_Section::has_fields($section_before)){
				$result1 = THWEPOF_Utils::update_section($section_before);
				$result2 = true;
			}

			if($result1 && $result2){
				update_option('thwepof_custom_product_fields_bkp', $custom_fields);
				delete_option('thwepof_custom_product_fields');
			}
		}
	}

	public function dismiss_thwepof_review_request_notice(){
		if(! check_ajax_referer( 'thwepof_review_request_notice', 'security' )){
			die();
		}
		set_transient('thwepof_review_request_notice_dismissed', true, apply_filters('thwepof_dismissed_review_request_notice_lifespan', 1 * YEAR_IN_SECONDS));
	}

	public function skip_thwepof_review_request_notice(){
		if(! check_ajax_referer( 'thwepof_review_request_notice', 'security' )){
			die();
		}
		set_transient('thwepof_skip_review_request_notice', true, apply_filters('thwepof_skip_review_request_notice_lifespan', 1 * DAY_IN_SECONDS));
	}

}
endif;
