<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CR_Reviews_Grid' ) ) {

	/**
	* Class for reviews grid shortcode and block.
	*/
	final class CR_Reviews_Grid {

		private static $sort_order_by;
		private static $sort_order;
		private $min_chars;
		private $attributes;
		private $ivrating = 'ivrating';

		/**
		* Constructor.
		*
		* @since 3.61
		*/
		public function __construct() {
			$this->register_shortcode();
			add_action( 'init', array( 'CR_Reviews_Grid', 'cr_register_blocks_script' ) );
			add_action( 'init', array( $this, 'register_block' ) );
			add_action( 'enqueue_block_assets', array( 'CR_Reviews_Grid', 'cr_enqueue_block_scripts' ) );
			add_action( 'admin_print_footer_scripts', array( $this, 'maybe_print_wc_settings' ) );
			add_action( 'wp_ajax_ivole_fetch_product_categories', array( $this, 'fetch_product_categories' ) );
			add_action( 'wp_ajax_ivole_fetch_products', array( $this, 'fetch_products' ) );
			add_action( 'wp_ajax_cr_fetch_product_tags', array( $this, 'fetch_product_tags' ) );
			add_action( 'wp_ajax_ivole_show_more_grid_reviews', array( $this, 'show_more_reviews' ) );
			add_action( 'wp_ajax_nopriv_ivole_show_more_grid_reviews', array( $this, 'show_more_reviews' ) );
		}

		/**
		* Add the cusrev_reviews_grid shortcode.
		*
		* @since 3.61
		*/
		public function register_shortcode() {
			add_shortcode( 'cusrev_reviews_grid', array( $this, 'render_reviews_grid_shortcode' ) );
		}

		/**
		* Register the reviews-grid.
		*
		* @since 3.61
		*/
		public function register_block() {
			// Only register the block if the WP is at least 5.0, or gutenberg is installed.
			if ( function_exists( 'register_block_type' ) ) {
				register_block_type( 'ivole/cusrev-reviews-grid', array(
					'editor_script' => 'ivole-wc-components',

					'editor_style'  => 'ivole-wc-components',

					'attributes' => array(
						'count' => array(
							'type' => 'number',
							'default' => 3,
							'minimum' => 1,
							'maximum' => 6
						),
						'show_products' => array(
							'type' => 'boolean',
							'default' => true
						),
						'product_links' => array(
							'type' => 'boolean',
							'default' => true
						),
						'sort_by' => array(
							'type' => 'string',
							'enum' => array( 'date', 'rating' ),
							'default' => 'date'
						),
						'sort' => array(
							'type' => 'string',
							'enum' => array( 'ASC', 'DESC', 'RAND' ),
							'default' => 'DESC'
						),
						'categories' => array(
							'type' => 'array',
							'default' => array(),
							'items' => array(
								'type' => 'integer',
								'minimum' => 1
							)
						),
						'products' => array(
							'type' => 'array',
							'default' => array(),
							'items' => array(
								'type' => 'integer',
								'minimum' => 1
							)
						),
						'product_tags' => array(
							'type' => 'array',
							'default' => array(),
							'items' => array(
								'type' => 'string',
								'minimum' => 1
							)
						),
						'color_ex_brdr' => array(
							'type' => 'string',
							'default' => '#ebebeb'
						),
						'color_brdr' => array(
							'type' => 'string',
							'default' => '#ebebeb'
						),
						'color_ex_bcrd' => array(
							'type' => 'string',
							'default' => ''
						),
						'color_bcrd' => array(
							'type' => 'string',
							'default' => '#fbfbfb'
						),
						'color_pr_bcrd' => array(
							'type' => 'string',
							'default' => '#f2f2f2'
						),
						'color_stars' => array(
							'type' => 'string',
							'default' => '#6bba70'
						),
						'shop_reviews' => array(
							'type' => 'boolean',
							'default' => false
						),
						'count_shop_reviews' => array(
							'type' => 'number',
							'default' => 1,
							'minimum' => 0,
							'maximum' => 3
						),
						'inactive_products' => array(
							'type' => 'boolean',
							'default' => false
						),
						'avatars' => array(
							'type' => 'boolean',
							'default' => true
						),
						'show_more' => array(
							'type' => 'number',
							'default' => 0,
							'minimum' => 0,
							'maximum' => 10
						),
						'min_chars' => array(
							'type' => 'number',
							'default' => 0,
							'minimum' => 0,
							'maximum' => 9999
						),
						'show_summary_bar' => array(
							'type' => 'boolean',
							'default' => false
						),
					),

					'render_callback' => array( $this, 'render_reviews_grid' )
				) );
			}
		}

		/**
		* Returns the review grid markup.
		*
		* @since 3.61
		*
		* @param array $attributes Block attributes.
		*
		* @return string
		*/
		public function render_reviews_grid( $attributes ) {
			$this->attributes = $attributes;

			if( !isset( $attributes['count_total'] ) ) {
				$attributes['count_total'] = 0;
			}
			// count_total is used for "Show more" button
			// count_total is the combined maximum number of reviews that we would like to display after click on "Show more"
			if( 0 < $attributes['count_total'] ) {
				if( 0 < $attributes['count'] ) {
					$attributes['count'] = $attributes['count_total'];
				}
				if( 0 < $attributes['count_shop_reviews'] ) {
					$attributes['count_shop_reviews'] = $attributes['count_total'];
				}
			}
			$max_reviews = $attributes['count'];
			$order_by = $attributes['sort_by'] === 'date' ? 'comment_date_gmt' : 'rating';
			$order = $attributes['sort'];
			$inactive_products = $attributes['inactive_products'];
			$avatars = $attributes['avatars'];
			$show_more = $attributes['show_more'];
			$offset = isset($attributes['offset'])?$attributes['offset']:0;
			$shop_offset = isset($attributes['shop_offset'])?$attributes['shop_offset']:0;
			$max_shop_reviews = 0;
			$show_products = $attributes['show_products'];
			$product_links = $attributes['product_links'];

			$post_ids = $attributes['products'];
			//add products if product tags are selected
			if( !empty( $attributes['product_tags'] ) ) {
				$tagged_products = CR_Reviews_Slider::cr_products_by_tags( $attributes['product_tags'] );
				$post_ids = array_merge( $post_ids, $tagged_products );
			}
			if ( count( $attributes['categories'] ) > 0 ) {
				$post_ids = get_posts(
					array(
						'post_type' => 'product',
						'posts_per_page' => -1,
						'fields' => 'ids',
						'post__in' => $attributes['products'],
						'tax_query' => array(
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'term_id',
								'terms'    => $attributes['categories']
							),
						)
					)
				);
			}

			$args = array(
				'status'      => 'approve',
				'post_type'   => 'product',
				'meta_key'    => 'rating',
				'orderby'     => $order_by,
				'post__in'    => $post_ids,
				'offset'      => $offset
			);

			if( !$inactive_products ) {
				$args['post_status'] = 'publish';
			}

			if( get_query_var( $this->ivrating ) ) {
				$rating = intval( get_query_var( $this->ivrating ) );
				if( $rating > 0 && $rating <= 5 ) {
					$args['meta_query']['relation'] = 'AND';
					$args['meta_query'][] = array(
						'key' => 'rating',
						'value'   => $rating,
						'compare' => '=',
						'type'    => 'numeric'
					);
				}
			}

			$reviews = [];
			// Query needs to be modified if min_chars constraints are set
			if ( ! empty( $attributes['min_chars'] ) ) {
				$this->min_chars = $attributes['min_chars'];
				add_filter( 'comments_clauses', array( $this, 'min_chars_comments_clauses' ) );
			}
			if( 'RAND' === $order ) {
				$all_product_reviews = get_comments( $args );
				$count_all_product_reviews = count( $all_product_reviews );
				$max_reviews = ( $count_all_product_reviews < $max_reviews ) ? $count_all_product_reviews : $max_reviews;
				$random_keys = array_rand( $all_product_reviews, $max_reviews );
				if( is_array( $random_keys ) ) {
					for( $i = 0; $i < $max_reviews; $i++ ) {
						$reviews[] = $all_product_reviews[$random_keys[$i]];
					}
				} else {
					$reviews[] = $all_product_reviews[$random_keys];
				}
			} else {
				if( 0 < $max_reviews ) {
					$args['order'] = $order;
					$args['number'] = $max_reviews;
					$reviews = get_comments( $args );
				}
			}

			$shop_page_id = wc_get_page_id( 'shop' );
			if( true === $attributes['shop_reviews'] ) {
				$max_shop_reviews = $attributes['count_shop_reviews'];
				if( $shop_page_id > 0 && $max_shop_reviews > 0 ) {
					$args_s = array(
						'status'      => 'approve',
						'post_status' => 'publish',
						'post_id'			=> $shop_page_id,
						'meta_key'    => 'rating',
						'orderby'     => $order_by,
						'offset'      => $shop_offset
					);

					if( get_query_var( $this->ivrating ) ) {
						$rating = intval( get_query_var( $this->ivrating ) );
						if( $rating > 0 && $rating <= 5 ) {
							$args_s['meta_query'][] = array(
								'key' => 'rating',
								'value'   => $rating,
								'compare' => '=',
								'type'    => 'numeric'
							);
						}
					}

					$shop_reviews = [];
					if( 'RAND' === $order ) {
						$all_shop_reviews = get_comments( $args_s );
						$count_all_shop_reviews = count( $all_shop_reviews );
						if( 0 < $count_all_shop_reviews ) {
							$max_shop_reviews = ( $count_all_shop_reviews < $max_shop_reviews ) ? $count_all_shop_reviews : $max_shop_reviews;
							$random_keys = array_rand( $all_shop_reviews, $max_shop_reviews );
							if( is_array( $random_keys ) ) {
								for( $i = 0; $i < $max_shop_reviews; $i++ ) {
									$shop_reviews[] = $all_shop_reviews[$random_keys[$i]];
								}
							} else {
								$shop_reviews[] = $all_shop_reviews[$random_keys];
							}
						}
					} else {
						if( 0 < $max_shop_reviews ) {
							$args_s['order'] = $order;
							$args_s['number'] = $max_shop_reviews;
							$shop_reviews = get_comments( $args_s );
						}
					}

					if( is_array( $reviews ) && is_array( $shop_reviews ) ) {
						$reviews = array_merge( $reviews, $shop_reviews );
						CR_Reviews_Grid::$sort_order_by = $order_by;
						CR_Reviews_Grid::$sort_order = $order;
						usort( $reviews, array( "CR_Reviews_Grid", "compare_dates_sort" ) );
					}
				}
			}
			remove_filter( 'comments_clauses', array( $this, 'min_chars_comments_clauses' ) );

			$num_reviews = count( $reviews );

			// make sure that we do not return more reviews than necessary
			if( 0 < $attributes['count_total'] ) {
				if( $num_reviews > $attributes['count_total'] ) {
					$reviews_temp = array();
					while( count( $reviews_temp ) < $attributes['count_total'] ) {
						$randomKey = mt_rand( 0, $num_reviews-1 );
						$reviews_temp[] = $reviews[$randomKey];
					}
					$reviews = $reviews_temp;
				}
			}

			if ( $num_reviews < 1 ) {
				return __( 'No reviews to show', 'customer-reviews-woocommerce' );
			}

			$cr_verified_label = get_option( 'ivole_verified_owner', '' );
			if( $cr_verified_label ) {
				$verified_text = '(' . esc_attr( $cr_verified_label ) . ')';
			} else {
				$verified_text = '(' . esc_attr__( 'verified owner', 'customer-reviews-woocommerce' ) . ')';
			}

			$verified_reviews_enabled = false;
			if ( 'yes' === get_option( 'ivole_reviews_verified', 'no' ) ) {
				$verified_reviews_enabled = true;
			}
			$country_enabled = ('yes' === get_option( 'ivole_form_geolocation', 'no' ) ? true : false);

			$badge_link = 'https://www.cusrev.com/reviews/' . get_option( 'ivole_reviews_verified_page', Ivole_Email::get_blogdomain() ) . '/p/p-%s/r-%s';
			$badge = '<p class="ivole-verified-badge"><img src="' . plugins_url( '/img/shield-20.png', dirname( dirname( __FILE__ ) ) ) . '" alt="' . __( 'Verified review', 'customer-reviews-woocommerce' ) . '" class="ivole-verified-badge-icon">';
			$badge .= '<span class="ivole-verified-badge-text">';
			$badge .= __( 'Verified review', 'customer-reviews-woocommerce' );
			$badge .= ' - <a href="' . $badge_link . '" title="" target="_blank" rel="nofollow noopener">' . __( 'view original', 'customer-reviews-woocommerce' ) . '</a>';
			$badge .= '</span></p>';

			$badge_link_sr = 'https://www.cusrev.com/reviews/' . get_option( 'ivole_reviews_verified_page', Ivole_Email::get_blogdomain() ) . '/s/r-%s';
			$badge_sr = '<p class="ivole-verified-badge"><img src="' . plugins_url( '/img/shield-20.png', dirname( dirname( __FILE__ ) ) ) . '" alt="' . __( 'Verified review', 'customer-reviews-woocommerce' ) . '" class="ivole-verified-badge-icon">';
			$badge_sr .= '<span class="ivole-verified-badge-text">';
			$badge_sr .= __( 'Verified review', 'customer-reviews-woocommerce' );
			$badge_sr .= ' - <a href="' . $badge_link_sr . '" title="" target="_blank" rel="nofollow noopener">' . __( 'view original', 'customer-reviews-woocommerce' ) . '</a>';
			$badge_sr .= '</span></p>';

			$section_style = "border-color:" . $attributes['color_ex_brdr'] . ";";
			if ( ! empty( $attributes['color_ex_bcrd'] ) ) {
				$section_style .= "background-color:" . $attributes['color_ex_bcrd'] . ";";
			}
			$card_style = "border-color:" . $attributes['color_brdr'] . ";";
			$card_style .= "background-color:" . $attributes['color_bcrd'] . ";";
			$product_style = "background-color:" . $attributes['color_pr_bcrd'] . ";";
			$stars_style = "color:" . $attributes['color_stars'] . ";";

			$id = uniqid( 'ivole-reviews-grid-' );

			// show summary bar
			$summary_bar = '';
			if ( $attributes['show_summary_bar'] ) {
				if( !empty($args_s) ) $summary_bar = $this->show_summary_table( $args, $args_s );
				else $summary_bar = $this->show_summary_table( $args );
			}

			$template = wc_locate_template(
				'reviews-grid.php',
				'customer-reviews-woocommerce',
				dirname( dirname( dirname( __FILE__ ) ) ) . '/templates/'
			);

			ob_start();
			include( $template );
			return ob_get_clean();
		}

		public function render_reviews_grid_shortcode( $attributes ) {
			$shortcode_enabled = get_option( 'ivole_reviews_shortcode', 'no' );
			if( $shortcode_enabled === 'no' ) {
				return;
			} else {
				// Convert shortcode attributes to block attributes
				$attributes = shortcode_atts( array(
					'count' => 3,
					'show_products' => true,
					'product_links' => true,
					'sort_by' => 'date',
					'sort' => 'DESC',
					'categories' => array(),
					'products' => array(),
					'color_ex_brdr' => '#ebebeb',
					'color_brdr' => '#ebebeb',
					'color_ex_bcrd' => '',
					'color_bcrd' => '#fbfbfb',
					'color_pr_bcrd' => '#f2f2f2',
					'color_stars' => '#6bba70',
					'shop_reviews' => 'false',
					'count_shop_reviews' => 1,
					'inactive_products' => 'false',
					'avatars' => true,
					'show_more' => 0,
					'offset' => 0,
					'shop_offset' => 0,
					'count_total' => 0,
					'product_tags' => [],
					'min_chars' => 0,
					'show_summary_bar' => 'false',
				), $attributes, 'cusrev_reviews_grid' );

				$attributes['count'] = absint( $attributes['count'] );
				$attributes['show_products'] = ( $attributes['show_products'] !== 'false' && boolval( $attributes['count'] ) );
				$attributes['product_links'] = ( $attributes['product_links'] !== 'false' );
				$attributes['shop_reviews'] = ( $attributes['shop_reviews'] !== 'false' && boolval( $attributes['count_shop_reviews'] ) );
				$attributes['count_shop_reviews'] = absint( $attributes['count_shop_reviews'] );
				$attributes['inactive_products'] = ( $attributes['inactive_products'] === 'true' );
				$attributes['avatars'] = ( $attributes['avatars'] !== 'false' );
				$attributes['show_more'] = absint( $attributes['show_more'] );
				$attributes['count_total'] = absint( $attributes['count_total'] );
				$attributes['min_chars'] = intval( $attributes['min_chars'] );
				$attributes['show_summary_bar'] = ( $attributes['show_summary_bar'] === 'true' );
				if( $attributes['min_chars'] < 0 ) {
					$attributes['min_chars'] = 0;
				}

				if ( ! is_array( $attributes['categories'] ) ) {
					$attributes['categories'] = array_filter( array_map( 'trim', explode( ',', $attributes['categories'] ) ) );
				}

				if ( ! is_array( $attributes['products'] ) ) {
					$attributes['products'] = array_filter( array_map( 'trim', explode( ',', $attributes['products'] ) ) );
				}

				if( ! empty($attributes['product_tags'] ) ) {
					$attributes['product_tags'] = array_filter( array_map( 'trim', explode( ',', $attributes['product_tags'] ) ) );
				}

				return $this->render_reviews_grid( $attributes );
			}
		}

		/**
		* When displaying the block editor, check for WooCommerce support then set
		* an action to print wc data.
		*
		* @since 3.61
		*/
		public function maybe_print_wc_settings() {
			if ( ! function_exists( 'wc_get_theme_support' ) ) {
				return;
			}

			add_action( 'admin_print_footer_scripts', array( $this, 'print_settings' ), 1 );
		}

		/**
		* Print JS variables to the editor page with WC data.
		*
		* @since 3.61
		*/
		public function print_settings() {
			global $wp_locale;

			$code = get_woocommerce_currency();

			// NOTE: wcSettings is not used directly, it's only for @woocommerce/components
			//
			// Settings and variables can be passed here for access in the app.
			// Will need `wcAdminAssetUrl` if the ImageAsset component is used.
			// Will need `dataEndpoints.countries` if Search component is used with 'country' type.
			// Will need `orderStatuses` if the OrderStatus component is used.
			// Deliberately excluding: `embedBreadcrumbs`, `trackingEnabled`.
			$settings = array(
				'adminUrl'      => admin_url(),
				'wcAssetUrl'    => plugins_url( 'assets/', WC_PLUGIN_FILE ),
				'siteLocale'    => esc_attr( get_bloginfo( 'language' ) ),
				'currency'      => array(
					'code'      => $code,
					'precision' => wc_get_price_decimals(),
					'symbol'    => get_woocommerce_currency_symbol( $code ),
					'position'  => get_option( 'woocommerce_currency_pos' ),
				),
				'stockStatuses' => wc_get_product_stock_status_options(),
				'siteTitle'     => get_bloginfo( 'name' ),
				'dataEndpoints' => array(),
				'l10n'          => array(
					'userLocale'    => get_user_locale(),
					'weekdaysShort' => array_values( $wp_locale->weekday_abbrev ),
				),
			);

			// Global settings used in each block.
			$block_settings = array(
				'min_columns'       => wc_get_theme_support( 'product_grid::min_columns', 1 ),
				'max_columns'       => wc_get_theme_support( 'product_grid::max_columns', 6 ),
				'default_columns'   => wc_get_default_products_per_row(),
				'min_rows'          => wc_get_theme_support( 'product_grid::min_rows', 1 ),
				'max_rows'          => wc_get_theme_support( 'product_grid::max_rows', 6 ),
				'default_rows'      => wc_get_default_product_rows_per_page(),
				'placeholderImgSrc' => wc_placeholder_img_src(),
				'min_height'        => wc_get_theme_support( 'featured_block::min_height', 500 ),
				'default_height'    => wc_get_theme_support( 'featured_block::default_height', 500 ),
			);

			?>
			<script type="text/javascript">
			var wcSettings = wcSettings || <?php echo wp_json_encode( $settings ); ?>;
			var wc_product_block_data = <?php echo wp_json_encode( $block_settings ); ?>;
			</script>
			<?php
		}

		/**
		* Fetch the product categories for use by the reviews grid block settings.
		*
		* @since 3.61
		*/
		public function fetch_product_categories() {
			$prepared_args = array(
				'exclude'    => [],
				'include'    => [],
				'order'      => 'asc',
				'orderby'    => 'name',
				'product'    => null,
				'hide_empty' => false,
				'number'     => 100,
				'offset'     => 0
			);

			$query_result = get_terms( 'product_cat', $prepared_args );

			$response = array();
			foreach ( $query_result as $term ) {
				$response[] = array(
					'id'     => (int) $term->term_id,
					'name'   => $term->name,
					'slug'   => $term->slug,
					'parent' => (int) $term->parent,
					'count'  => (int) $term->count
				);
			}

			wp_send_json( $response, 200 );
		}

		/**
		* Fetch the products for use by the reviews grid block settings.
		*
		* @since 3.61
		*/
		public function fetch_products() {
			$query_args = array(
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'post_type'      => 'product',
				'orderby'        => 'date ID'
			);

			$query = new WP_Query();
			$products = $query->query( $query_args );
			$products = array_map( 'wc_get_product', $products );

			$response = array();
			foreach ( $products as $product ) {
				$response[] = array(
					'id'   => $product->get_id(),
					'name' => $product->get_name(),
					'slug' => $product->get_slug()
				);
			}

			wp_send_json( $response );
		}

		/**
		* Fetch the product tags for use by the reviews block settings.
		*
		* @since 4.6
		*/
		public function fetch_product_tags() {
			$args = array(
				'order'      => 'asc',
				'orderby'    => 'name',
				'hide_empty' => false,
			);

			$terms = get_terms( 'product_tag', $args );

			$response = [];
			foreach ( $terms as $term ) {
				$response[] = array(
					'id'     => (int) $term->term_id,
					'name'   => $term->name,
					'slug'   => $term->slug,
				);
			}

			wp_send_json( $response, 200 );
		}

		public static function cr_register_blocks_script() {
			wp_register_script(
				'ivole-blocks',
				plugins_url( 'js/blocks.js', dirname( dirname( __FILE__ ) ) ),
				array( 'wp-element', 'wp-i18n', 'wp-data', 'wp-blocks', 'wp-components', 'wp-editor', 'lodash', 'ivole-wc-components' ),
				'3.61',
				true
			);

			wp_register_script(
				'ivole-wc-components',
				plugins_url( 'js/wc-components.js', dirname( dirname( __FILE__ ) ) ),
				array(
					'wp-components',
					'wp-data',
					'wp-element',
					'wp-hooks',
					'wp-i18n',
					'wp-keycodes'
				),
				'3.61',
				true
			);

			wp_register_style(
				'ivole-wc-components',
				plugins_url( 'css/wc-components.css', dirname( dirname( __FILE__ ) ) ),
				array(),
				'3.61'
			);

			wp_register_style(
				'ivole-reviews-grid',
				plugins_url( 'css/reviews-grid.css', dirname( dirname( __FILE__ ) ) ),
				array(),
				'3.61'
			);

			wp_register_script(
				'ivole-frontend-js',
				plugins_url('/js/frontend.js', dirname( dirname( __FILE__ ) ) ),
				array(),
				null,
				true
			);
		}

		public static function cr_enqueue_block_scripts() {
			global $current_screen;

			wp_register_style( 'ivole-frontend-css', plugins_url( '/css/frontend.css', dirname( dirname( __FILE__ ) ) ), array(), '4.12', 'all' );
			wp_enqueue_style( 'ivole-frontend-css' );

			if ( ( $current_screen instanceof WP_Screen ) && $current_screen->is_block_editor() ) {
				wp_enqueue_script( 'ivole-blocks' );
			}

			wp_enqueue_style( 'ivole-reviews-grid' );
			wp_localize_script( 'ivole-frontend-js', 'ajax_object',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				)
			);
			wp_enqueue_script( 'ivole-frontend-js' );
		}

		private static function compare_dates_sort( $a, $b ) {
			if( 'rating' === CR_Reviews_Grid::$sort_order_by ) {
				$rating1 = intval( get_comment_meta( $a->comment_ID, 'rating', true ) );
				$rating2 = intval( get_comment_meta( $b->comment_ID, 'rating', true ) );
				if( 'ASC' === CR_Reviews_Grid::$sort_order ) {
					return $rating1 - $rating2;
				} elseif( 'RAND' === CR_Reviews_Grid::$sort_order ) {
					return rand( -1, 1 );
				} else {
					return $rating2 - $rating1;
				}
			} else {
				$datetime1 = strtotime( $a->comment_date );
				$datetime2 = strtotime( $b->comment_date );
				if( 'ASC' === CR_Reviews_Grid::$sort_order ) {
					return $datetime1 - $datetime2;
				}  elseif( 'RAND' === CR_Reviews_Grid::$sort_order ) {
					return rand( -1, 1 );
				} else {
					return $datetime2 - $datetime1;
				}
			}
		}

		public function show_more_reviews() {
			$response = array();
			$attributes = array();
			if( isset( $_POST['attributes'] ) && is_array( $_POST['attributes'] ) ) $attributes = $_POST['attributes'];
			if( isset( $_POST['rating'] ) ) {
				$rating = intval( $_POST['rating'] );
				if( 0 < $rating && 5 >= $rating ) {
					set_query_var( $this->ivrating, $rating );
				}
			}

			//Sanitization
			foreach($attributes as $key => $val) {

				switch($key){
					case 'avatars':
					case 'inactive_products':
					case 'product_links':
					case 'shop_reviews':
					case 'show_products':
					$val = $val === "true" ? "true" : "false";
					break;
					case 'categories':
					case 'products':
					$new_val = array();
					if(is_array($val) && count($val)){
						foreach ($val as $item){
							$new_val[] = absint($item);
						}
						$val = $new_val;
					}
					break;
					case 'count':
					case 'count_shop_reviews':
					case 'offset':
					case 'shop_offset':
					case 'show_more':
					$val = absint($val);
					break;
					case 'sort':
					$allowed = array( 'ASC', 'DESC', 'RAND' );
					if(!in_array($val, $allowed)) $val = 'DESC';
					break;
					case 'sort_by':
					$allowed = array( 'date', 'rating' );
					if(!in_array($val, $allowed)) $val = 'date';
					break;
					default:
					$val = sanitize_text_field( $val );
				}

				$attributes[$key] = $val;
			}

			$attributes['count_total'] = $attributes['show_more'];
			$response['html'] = $html = $this->render_reviews_grid_shortcode( $attributes );

			wp_send_json( $response );
		}

		public function min_chars_comments_clauses( $clauses ) {
			global $wpdb;

			$clauses['where'] .= " AND CHAR_LENGTH({$wpdb->comments}.comment_content) >= " . $this->min_chars;

			return $clauses;
		}

		private function show_summary_table( $args, $args_shop = array() ){
			$all = $this->count_ratings( 0, $args, $args_shop );
			$output = '';
			if ($all > 0) {
				$five = (float)$this->count_ratings( 5, $args, $args_shop );
				$five_percent = floor($five / $all * 100);
				$five_rounding = $five / $all * 100 - $five_percent;
				$four = (float)$this->count_ratings( 4, $args, $args_shop );
				$four_percent = floor($four / $all * 100);
				$four_rounding = $four / $all * 100 - $four_percent;
				$three = (float)$this->count_ratings( 3, $args, $args_shop );
				$three_percent = floor($three / $all * 100);
				$three_rounding = $three / $all * 100 - $three_percent;
				$two = (float)$this->count_ratings( 2, $args, $args_shop );
				$two_percent = floor($two / $all * 100);
				$two_rounding = $two / $all * 100 - $two_percent;
				$one = (float)$this->count_ratings( 1, $args, $args_shop );
				$one_percent = floor($one / $all * 100);
				$one_rounding = $one / $all * 100 - $one_percent;
				$hundred = $five_percent + $four_percent + $three_percent + $two_percent + $one_percent;
				if( $hundred < 100 ) {
					$to_distribute = 100 - $hundred;
					$roundings = array( '5' => $five_rounding, '4' => $four_rounding, '3' => $three_rounding, '2' => $two_rounding, '1' => $one_rounding );
					arsort($roundings);
					$roundings = array_filter( $roundings, function( $value ) {
						return $value > 0;
					} );
					while( $to_distribute > 0 && count( $roundings ) > 0 ) {
						foreach( $roundings as $key => $value ) {
							if( $to_distribute > 0 ) {
								switch( $key ) {
									case 5:
										$five_percent++;
										break;
									case 4:
										$four_percent++;
										break;
									case 3:
										$three_percent++;
										break;
									case 2:
										$two_percent++;
										break;
									case 1:
										$one_percent++;
										break;
									default:
										break;
								}
								$to_distribute--;
							} else {
								break;
							}
						}
					}
				}
				$average = ( 5 * $five + 4 * $four + 3 * $three + 2 * $two + 1 * $one ) / $all;
				$output .= '<div class="cr-summaryBox-wrap">';
				$output .= '<div class="cr-overall-rating-wrap">';
				$output .= '<div class="cr-average-rating"><span>' . number_format_i18n( $average, 1 ) . '</span></div>';
				$output .= '<div class="cr-average-rating-stars"><div class="crstar-rating"><span style="width:'.($average / 5 * 100).'%;"></span></div></div>';
				$output .= '<div class="cr-total-rating-count">' . sprintf( _n( 'Based on %s review', 'Based on %s reviews', $all, 'customer-reviews-woocommerce' ), number_format_i18n( $all ) ) . '</div>';
				$output .= '</div>';
				if( 0 < $this->attributes['show_more'] ) {
					$output .= '<div class="ivole-summaryBox cr-grid-reviews-ajax">';
				} else {
					$output .= '<div class="ivole-summaryBox">';
				}
				$output .= '<table id="ivole-histogramTable">';
				$output .= '<tbody>';
				$output .= '<tr class="ivole-histogramRow">';
				// five
				if( $five > 0 ) {
					$output .= '<td class="ivole-histogramCell1"><a class="cr-histogram-a" data-rating="5" href="' . esc_url( add_query_arg( $this->ivrating, 5 ) ) . '" title="' . __( '5 star', 'customer-reviews-woocommerce' ) . '">' . __( '5 star', 'customer-reviews-woocommerce' ) . '</a></td>';
					$output .= '<td class="ivole-histogramCell2"><a class="cr-histogram-a" data-rating="5" href="' . esc_url( add_query_arg( $this->ivrating, 5 ) ) . '"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $five_percent . '%"></div></div></a></td>';
					$output .= '<td class="ivole-histogramCell3"><a class="cr-histogram-a" data-rating="5" href="' . esc_url( add_query_arg( $this->ivrating, 5 ) ) . '">' . (string)$five_percent . '%</a></td>';
				} else {
					$output .= '<td class="ivole-histogramCell1">' . __('5 star', 'customer-reviews-woocommerce') . '</td>';
					$output .= '<td class="ivole-histogramCell2"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $five_percent . '%"></div></div></td>';
					$output .= '<td class="ivole-histogramCell3">' . (string)$five_percent . '%</td>';
				}

				$output .= '</tr>';
				$output .= '<tr class="ivole-histogramRow">';
				// four
				if( $four > 0 ) {
					$output .= '<td class="ivole-histogramCell1"><a class="cr-histogram-a" data-rating="4" href="' . esc_url( add_query_arg( $this->ivrating, 4 ) ) . '" title="' . __( '4 star', 'customer-reviews-woocommerce' ) . '">' . __( '4 star', 'customer-reviews-woocommerce' ) . '</a></td>';
					$output .= '<td class="ivole-histogramCell2"><a class="cr-histogram-a" data-rating="4" href="' . esc_url( add_query_arg( $this->ivrating, 4 ) ) . '"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $four_percent . '%"></div></div></a></td>';
					$output .= '<td class="ivole-histogramCell3"><a class="cr-histogram-a" data-rating="4" href="' . esc_url( add_query_arg( $this->ivrating, 4 ) ) . '">' . (string)$four_percent . '%</a></td>';
				} else {
					$output .= '<td class="ivole-histogramCell1">' . __('4 star', 'customer-reviews-woocommerce') . '</td>';
					$output .= '<td class="ivole-histogramCell2"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $four_percent . '%"></div></div></td>';
					$output .= '<td class="ivole-histogramCell3">' . (string)$four_percent . '%</td>';
				}

				$output .= '</tr>';
				$output .= '<tr class="ivole-histogramRow">';
				// three
				if( $three > 0 ) {
					$output .= '<td class="ivole-histogramCell1"><a class="cr-histogram-a" data-rating="3" href="' . esc_url( add_query_arg( $this->ivrating, 3 ) ) . '" title="' . __( '3 star', 'customer-reviews-woocommerce' ) . '">' . __( '3 star', 'customer-reviews-woocommerce' ) . '</a></td>';
					$output .= '<td class="ivole-histogramCell2"><a class="cr-histogram-a" data-rating="3" href="' . esc_url( add_query_arg( $this->ivrating, 3 ) ) . '"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $three_percent . '%"></div></div></a></td>';
					$output .= '<td class="ivole-histogramCell3"><a class="cr-histogram-a" data-rating="3" href="' . esc_url( add_query_arg( $this->ivrating, 3 ) ) . '">' . (string)$three_percent . '%</a></td>';
				} else {
					$output .= '<td class="ivole-histogramCell1">' . __('3 star', 'customer-reviews-woocommerce') . '</td>';
					$output .= '<td class="ivole-histogramCell2"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $three_percent . '%"></div></div></td>';
					$output .= '<td class="ivole-histogramCell3">' . (string)$three_percent . '%</td>';
				}

				$output .= '</tr>';
				$output .= '<tr class="ivole-histogramRow">';
				// two
				if( $two > 0 ) {
					$output .= '<td class="ivole-histogramCell1"><a class="cr-histogram-a" data-rating="2" href="' . esc_url( add_query_arg( $this->ivrating, 2 ) ) . '" title="' . __( '2 star', 'customer-reviews-woocommerce' ) . '">' . __( '2 star', 'customer-reviews-woocommerce' ) . '</a></td>';
					$output .= '<td class="ivole-histogramCell2"><a class="cr-histogram-a" data-rating="2" href="' . esc_url( add_query_arg( $this->ivrating, 2 ) ) . '"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $two_percent . '%"></div></div></a></td>';
					$output .= '<td class="ivole-histogramCell3"><a class="cr-histogram-a" data-rating="2" href="' . esc_url( add_query_arg( $this->ivrating, 2 ) ) . '">' . (string)$two_percent . '%</a></td>';
				} else {
					$output .= '<td class="ivole-histogramCell1">' . __('2 star', 'customer-reviews-woocommerce') . '</td>';
					$output .= '<td class="ivole-histogramCell2"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $two_percent . '%"></div></div></td>';
					$output .= '<td class="ivole-histogramCell3">' . (string)$two_percent . '%</td>';
				}

				$output .= '</tr>';
				$output .= '<tr class="ivole-histogramRow">';
				// one
				if( $one > 0 ) {
					$output .= '<td class="ivole-histogramCell1"><a class="cr-histogram-a" data-rating="1" href="' . esc_url( add_query_arg( $this->ivrating, 1 ) ) . '" title="' . __( '1 star', 'customer-reviews-woocommerce' ) . '">' . __( '1 star', 'customer-reviews-woocommerce' ) . '</a></td>';
					$output .= '<td class="ivole-histogramCell2"><a class="cr-histogram-a" data-rating="1" href="' . esc_url( add_query_arg( $this->ivrating, 1 ) ) . '"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $one_percent . '%"></div></div></a></td>';
					$output .= '<td class="ivole-histogramCell3"><a class="cr-histogram-a" data-rating="1" href="' . esc_url( add_query_arg( $this->ivrating, 1 ) ) . '">' . (string)$one_percent . '%</a></td>';
				} else {
					$output .= '<td class="ivole-histogramCell1">' . __('1 star', 'customer-reviews-woocommerce') . '</td>';
					$output .= '<td class="ivole-histogramCell2"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $one_percent . '%"></div></div></td>';
					$output .= '<td class="ivole-histogramCell3">' . (string)$one_percent . '%</td>';
				}

				$output .= '</tr>';
				$output .= '</tbody>';
				$output .= '</table>';
				$output .= '</div>';
				if ('yes' !== get_option('ivole_reviews_nobranding', 'yes')) {
					$output .= '<div class="cr-credits-div">';
					$output .= 'Powered by <a href="https://wordpress.org/plugins/customer-reviews-woocommerce/" target="_blank">Customer Reviews plugin</a>';
					$output .= '</div>';
				}
				if (get_query_var($this->ivrating)) {
					$rating = intval(get_query_var($this->ivrating));
					if ($rating > 0 && $rating <= 5) {
						$filtered_comments = sprintf(esc_html(_n('Showing %1$d of %2$d review (%3$d star). ', 'Showing %1$d of %2$d reviews (%3$d star). ', $all, 'customer-reviews-woocommerce')), $this->count_ratings( $rating, $args, $args_shop), $all, $rating);
						$all_comments = sprintf(esc_html(_n('See all %d review', 'See all %d reviews', $all, 'customer-reviews-woocommerce')), $all);
						$output .= '<div class="cr-count-filtered-reviews">' . $filtered_comments . '<a class="ivole-seeAllReviews" href="' . esc_url( get_permalink() ) . '">' . $all_comments . '</a></div>';
					}
				} else {
					$output .= '<div class="cr-count-filtered-reviews"></div>';
				}
				$output .= '</div>';
			}

			return $output;
		}

		private function count_ratings( $rating, $args, $args_shop = array() ){
			$args['count'] = true;
			$args['type__not_in'] = 'cr_qna';
			unset($args['meta_query']);

			if ($rating > 0) {
				$args['meta_query'][] = array(
					'key' => 'rating',
					'value'   => $rating,
					'compare' => '=',
					'type'    => 'numeric'
				);
			}

			if ( ! empty( $this->min_chars ) ) {
				add_filter( 'comments_clauses', array( $this, 'min_chars_comments_clauses' ) );
			}
			$count = get_comments( $args );

			if( !empty( $args_shop ) ){
				$args_shop['count'] = true;
				$args_shop['type__not_in'] = 'cr_qna';
				unset($args_shop['meta_query']);

				if ($rating > 0) {
					$args_shop['meta_query'][] = array(
						'key' => 'rating',
						'value'   => $rating,
						'compare' => '=',
						'type'    => 'numeric'
					);
				}

				$count_shop = get_comments($args_shop);
				$count = $count + $count_shop;
			}
			remove_filter( 'comments_clauses', array( $this, 'min_chars_comments_clauses' ) );

			return $count;
		}

	}

}
