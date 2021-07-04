<?php
/**
 * Theme Functions.
 */

add_action( 'wp_enqueue_scripts', 'lz_food_recipee_enqueue_scripts' );
function lz_food_recipee_enqueue_scripts() {
	wp_enqueue_style( 'bootstrap-css', esc_url(get_template_directory_uri()).'/assets/css/bootstrap.css' );
	$parent_style = 'lzrestaurant-basic-style'; // Style handle of parent theme.
	wp_enqueue_style( $parent_style, esc_url(get_template_directory_uri()) . '/style.css' );
	wp_enqueue_style( 'lz-food-recipee-basic-style', get_stylesheet_uri(), array( $parent_style ) );
	wp_enqueue_style( 'lz-food-recipee-font', lz_food_recipee_fonts_url(), array() );
}

add_action( 'init', 'lz_food_recipee_remove_parent_function'); 
function lz_food_recipee_remove_parent_function() { 
	remove_action( 'admin_notices', 'lzrestaurant_activation_notice' ); 
	remove_action( 'admin_menu', 'lzrestaurant_gettingstarted' ); 
}

// Customizer Section
function lz_food_recipee_customizer ( $wp_customize ) {
	$wp_customize->add_section('lz_food_recipee_service',array(
		'title'	=> __('Restaurant Menu','lz-food-recipee'),
		'panel' => 'lzrestaurant_panel_id',
	));

	$wp_customize->add_setting('lz_food_recipee_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('lz_food_recipee_title',array(
		'label'	=> __('Section Title','lz-food-recipee'),
		'section'	=> 'lz_food_recipee_service',
		'setting'	=> 'lz_food_recipee_title',
		'type'		=> 'text'
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_pst[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_pst[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('lz_food_recipee_category_setting',array(
		'default'	=> 'select',
		'sanitize_callback' => 'lz_food_recipee_sanitize_choices',
	));
	$wp_customize->add_control('lz_food_recipee_category_setting',array(
		'type'    => 'select',
		'choices' => $cat_pst,
		'label' => __('Select Category to display Post','lz-food-recipee'),
		'section' => 'lz_food_recipee_service',
	));
}
add_action( 'customize_register', 'lz_food_recipee_customizer' );

function lz_food_recipee_fonts_url(){
	$font_url = '';
	$font_family = array();
	$font_family[] = 'Kaushan Script';
	$font_family[] = 'Oswald:200,300,400,500,600,700';

	$query_args = array(
		'family'	=> rawurlencode(implode('|',$font_family)),
	);
	$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
	return $font_url;
}

/*radio button sanitization*/
function lz_food_recipee_sanitize_choices( $input, $setting ) {
    global $wp_customize; 
    $control = $wp_customize->get_control( $setting->id ); 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

define('LZ_FOOD_RECIPEE_CREDIT',__('https://www.luzuk.com/themes/free-wordpress-recipe-theme/','lz-food-recipee'));

if ( ! function_exists( 'lz_food_recipee_credit' ) ) {
	function lz_food_recipee_credit(){
		echo "<a href=".esc_url(LZ_FOOD_RECIPEE_CREDIT)." target='_blank' >". esc_html__('Recipe WordPress Theme','lz-food-recipee') ."</a>";
	}
}

// Customizer Pro
require_once( ABSPATH . WPINC . '/class-wp-customize-section.php' );

class LZ_Food_Recipee_Customize_Section_Pro extends WP_Customize_Section {
	public $type = 'lz-food-recipee';
	public $pro_text = '';
	public $pro_url = '';
	public function json() {
		$json = parent::json();
		$json['pro_text'] = $this->pro_text;
		$json['pro_url']  = esc_url( $this->pro_url );
		return $json;
	}
	protected function render_template() { ?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title">
				{{ data.title }}
				<# if ( data.pro_text && data.pro_url ) { #>
					<a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
				<# } #>
			</h3>
		</li>
	<?php }
}

final class LZ_Food_Recipee_Customize {
	public static function get_instance() {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}
		return $instance;
	}
	private function __construct() {}
	private function setup_actions() {
		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );
		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}
	public function sections( $manager ) {
		// Register custom section types.
		$manager->register_section_type( 'LZ_Food_Recipee_Customize_Section_Pro' );
		// Register sections.
		$manager->add_section( new LZ_Food_Recipee_Customize_Section_Pro( $manager, 'lz_food_recipee',
		array(
			'priority'   => 1,
			'title'    => esc_html__( 'Food Recipe Pro', 'lz-food-recipee' ),
			'pro_text' => esc_html__( 'Go Pro', 'lz-food-recipee' ),
			'pro_url'  => esc_url('https://www.luzuk.com/product/wordpress-recipe-theme/'),
		) ) );
	}
	public function enqueue_control_scripts() {
		wp_enqueue_script( 'lz-food-recipee-customize-controls', get_stylesheet_directory_uri() . '/js/child-customize-controls.js', array( 'customize-controls' ) );
		wp_enqueue_style( 'lz-food-recipee-customize-controls', get_stylesheet_directory_uri() . '/css/child-customize-controls.css' );
	}
}
LZ_Food_Recipee_Customize::get_instance();