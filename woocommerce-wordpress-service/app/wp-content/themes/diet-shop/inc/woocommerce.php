<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Diet_Shop
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function diet_shop_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'diet_shop_woocommerce_setup' );

/**
 * Disable necessary hook of woocomerce.
 *
 * @return void
 */
add_filter( 'woocommerce_show_page_title', '__return_false' );

remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb',20 );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function diet_shop_woocommerce_scripts() {
	$dietshop = wp_get_theme();
	wp_enqueue_style( 'diet-shop-woocommerce-style', get_template_directory_uri() . '/woocommerce.css' );

	$font_path   = esc_url( WC()->plugin_url() ) . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'diet-shop-woocommerce-style', $inline_font );
	
	wp_enqueue_script( 'customselect',get_theme_file_uri( '/js/customselect.js' ) , array(), $dietshop->get('Version'), true );
	wp_enqueue_script( 'diet-shop-woocommerce',get_theme_file_uri( '/js/woocommerce.js' ) , array(), $dietshop->get('Version'), true );
	
	
}
add_action( 'wp_enqueue_scripts', 'diet_shop_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function diet_shop_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'diet_shop_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function diet_shop_woocommerce_products_per_page() {
	return 6;
}
add_filter( 'loop_shop_per_page', 'diet_shop_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function diet_shop_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'diet_shop_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function diet_shop_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'diet_shop_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function diet_shop_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'diet_shop_woocommerce_related_products_args' );

if ( ! function_exists( 'diet_shop_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function diet_shop_woocommerce_product_columns_wrapper() {
		$columns = diet_shop_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'diet_shop_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'diet_shop_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function diet_shop_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'diet_shop_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'diet_shop_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function diet_shop_woocommerce_wrapper_before() {
		do_action( 'diet_shop_container_before' );
	}
}
add_action( 'woocommerce_before_main_content', 'diet_shop_woocommerce_wrapper_before' );

if ( ! function_exists( 'diet_shop_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function diet_shop_woocommerce_wrapper_after() {
		do_action( 'diet_shop_container_after' );
	}
}
add_action( 'woocommerce_after_main_content', 'diet_shop_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'diet_shop_woocommerce_header_cart' ) ) {
			diet_shop_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'diet_shop_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function diet_shop_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		diet_shop_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'diet_shop_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'diet_shop_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function diet_shop_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'diet-shop' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'diet-shop' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'diet_shop_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function diet_shop_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php diet_shop_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

/*
ALL HERE FOR WOOCOMERCE LOOP
*/

if ( ! function_exists( 'diet_shop_product_loop_before' ) ) {
	/**
	 * Before loop Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return $html
	 */
	function diet_shop_product_loop_before() {
		echo '<div class="product-wrap">';
	}
}
add_action( 'woocommerce_before_shop_loop_item', 'diet_shop_product_loop_before',5 );

if ( ! function_exists( 'diet_shop_product_loop_after' ) ) {
	/**
	 * After loop Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return $html
	 */
	function diet_shop_product_loop_after() {
		
	
		echo '</div>';
	}
	add_action( 'woocommerce_after_shop_loop_item', 'diet_shop_product_loop_after',999 );
}


remove_action( 'woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10);
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5);
remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash',10);
	remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail',10);	


if ( ! function_exists( 'diet_shop_loop_item_title_before' ) ) {
	
	/**
	 * After loop Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return $html
	 */
	function diet_shop_loop_item_title_before() {
		echo '<div class="product-img">';
	}
	add_action( 'woocommerce_before_shop_loop_item_title', 'diet_shop_loop_item_title_before',5 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open',10);
}

	

if ( ! function_exists( 'diet_shop_loop_item_title_after' ) ) {
	
	/**
	 * After loop Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return $html
	 */
	function diet_shop_loop_item_title_after() {
		echo '</div>';
	}
	add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail',20);
	add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_link_close',30);
	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash',40 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'diet_shop_loop_item_title_after',50 );
}

if ( ! function_exists( 'diet_shop_template_loop_add_to_cart_before' ) ) {
	
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price',10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart',10 );
	/**
	 * After loop Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return $html
	 */
	function diet_shop_template_loop_add_to_cart_before() {
		echo '<ul class="button-group clearfix">';
	}
	add_action( 'woocommerce_after_shop_loop_item','diet_shop_template_loop_add_to_cart_before',5);
	add_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_price',10);
}

if ( ! function_exists( 'diet_shop_template_loop_add_to_cart_after' ) ) {
	/**
	 * After loop Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return $html
	 */
	function diet_shop_template_loop_add_to_cart_after() {
		echo '</ul>';
	}
	add_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',20);
	add_action( 'woocommerce_after_shop_loop_item','diet_shop_template_loop_add_to_cart_after',30);
	
}


remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_title',5);



/**
* Hook: woocommerce_single_product_summary.
*
* @hooked woocommerce_template_single_title - 5
* @hooked woocommerce_template_single_rating - 10
* @hooked woocommerce_template_single_price - 10
* @hooked woocommerce_template_single_excerpt - 20
* @hooked woocommerce_template_single_add_to_cart - 30
* @hooked woocommerce_template_single_meta - 40
* @hooked woocommerce_template_single_sharing - 50
* @hooked WC_Structured_Data::generate_product_data() - 60
*/

remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_title',5);
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_price',10);

//do_action( 'woocommerce_single_product_summary' );






if ( ! function_exists( 'diet_shop_before_quantity_input_field' ) ) {
	/**
	 * before quantity.
	 *
	 *
	 * @return $html
	 */
	function diet_shop_before_quantity_input_field() {
		echo '<button type="button" class="plus"><i class="fa fa-plus" aria-hidden="true"></i></button>';
	}
	add_action( 'woocommerce_before_quantity_input_field','diet_shop_before_quantity_input_field',10);
	
	
}

if ( ! function_exists( 'diet_shop_after_quantity_input_field' ) ) {
	/**
	 * after quantity.
	 *
	 *
	 * @return $html
	 */
	function diet_shop_after_quantity_input_field() {
		echo '<button type="button" class="minus"><i class="fa fa-minus" aria-hidden="true"></i></button>';
	}
	add_action( 'woocommerce_after_quantity_input_field','diet_shop_after_quantity_input_field',10);
	
	
}
