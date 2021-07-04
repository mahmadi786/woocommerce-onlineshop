<?php

if (! defined('ABSPATH')) {
	exit;
}

if (! class_exists('CR_All_Reviews')) :

	class CR_All_Reviews
	{

		/**
		* @var array holds the current shorcode attributes
		*/
		private $shortcode_atts;
		private $shop_page_id;
		private $ivrating = 'ivrating';

		public function __construct() {
			$this->register_shortcode();
			$this->shop_page_id = wc_get_page_id( 'shop' );
			add_action( 'wp_enqueue_scripts', array( $this, 'cr_style_1' ) );
			add_action( 'wp_ajax_cr_show_more_all_reviews', array( $this, 'show_more_reviews' ) );
			add_action( 'wp_ajax_nopriv_cr_show_more_all_reviews', array( $this, 'show_more_reviews' ) );
		}

		public function register_shortcode() {
			add_shortcode( 'cusrev_all_reviews', array( $this, 'render_all_reviews_shortcode' ) );
		}

		private function fill_attributes( $attributes ) {
			$defaults = array(
				'sort' => 'desc',
				'sort_by' => 'date',
				'per_page' => 10,
				'number' => -1,
				'show_summary_bar' => 'true',
				'show_pictures' => 'false',
				'show_products' => 'true',
				'categories' => [],
				'products' => [],
				'shop_reviews' => 'true',
				'number_shop_reviews' => -1,
				'inactive_products' => 'false',
				'show_replies' => 'false',
				'product_tags' => [],
				'show_more' => 0,
				'min_chars' => 0,
			);

			if ( isset( $attributes['categories'] ) && !is_array( $attributes['categories'] ) ) {
				$categories = str_replace( ' ', '', $attributes['categories'] );
				$categories = explode( ',', $categories );
				$categories = array_filter( $categories, 'is_numeric' );
				$categories = array_map( 'intval', $categories );

				$attributes['categories'] = $categories;
			}

			if ( isset( $attributes['products'] ) && !is_array($attributes['products']) ) {
				$products = str_replace( ' ', '', $attributes['products'] );
				$products = explode( ',', $products );
				$products = array_filter( $products, 'is_numeric' );
				$products = array_map( 'intval', $products );

				$attributes['products'] = $products;
			}

			if( ! empty( $attributes['product_tags'] ) && !is_array( $attributes['product_tags'] ) ) {
				$attributes['product_tags'] = array_filter( array_map( 'trim', explode( ',', $attributes['product_tags'] ) ) );
				$tagged_products = CR_Reviews_Slider::cr_products_by_tags( $attributes['product_tags'] );
				$attributes['products'] = array_merge( $attributes['products'], $tagged_products );
			}

			$this->shortcode_atts = shortcode_atts( $defaults, $attributes );
			$this->shortcode_atts['show_summary_bar'] = $this->shortcode_atts['show_summary_bar'] === 'true' ? true : false;
			$this->shortcode_atts['show_pictures'] = $this->shortcode_atts['show_pictures'] === 'true' ? true : false;
			$this->shortcode_atts['show_products'] = $this->shortcode_atts['show_products'] === 'true' ? true : false;
			$this->shortcode_atts['shop_reviews'] = $this->shortcode_atts['shop_reviews'] === 'true' ? true : false;
			$this->shortcode_atts['inactive_products'] = $this->shortcode_atts['inactive_products'] === 'true' ? true : false;
			$this->shortcode_atts['show_replies'] = $this->shortcode_atts['show_replies'] === 'true' ? true : false;
			$this->shortcode_atts['sort'] = strtolower( $this->shortcode_atts['sort'] );
			$this->shortcode_atts['sort_by'] = strtolower( $this->shortcode_atts['sort_by'] );
			$this->shortcode_atts['show_more'] = absint( $this->shortcode_atts['show_more'] );
			if( !empty( $this->shortcode_atts['show_more'] ) ) {
				$this->shortcode_atts['per_page'] = $this->shortcode_atts['show_more'];
			}
			$this->shortcode_atts['min_chars'] = intval( $this->shortcode_atts['min_chars'] );
			if( $this->shortcode_atts['min_chars'] < 0 ) {
				$this->shortcode_atts['min_chars'] = 0;
			}
		}

		public function render_all_reviews_shortcode( $attributes ) {
			$this->fill_attributes( $attributes );
			return $this->display_reviews();
		}

		public function get_reviews() {

			$comments = array();

			$number = $this->shortcode_atts['number'] == -1 ? null : intval( $this->shortcode_atts['number'] );
			if( 0 < $number || null === $number ) {
				$args = array(
					'number'      => $number,
					'status'      => 'approve',
					'post_type'   => 'product',
					'orderby'     => 'comment_date_gmt',
					'order'       => $this->shortcode_atts['sort'],
					'post__in'    => $this->shortcode_atts['products'],
					'type__not_in' => 'cr_qna'
				);

				if( $this->shortcode_atts['sort_by'] === 'helpful' ) {
					$args['meta_query'] = array(
						array(
							'relation' => 'OR',
							array(
								'key' => 'ivole_review_votes',
								'type' => 'NUMERIC',
								'compare' => 'NOT EXISTS'
							),
							array(
								'key' => 'ivole_review_votes',
								'type' => 'NUMERIC',
								'compare' => 'EXISTS'
							)
						)
					);

					$args['orderby'] = array(
						'meta_value_num',
						'comment_date_gmt'
					);
				}

				if( !$this->shortcode_atts['inactive_products'] ) {
					$args['post_status'] = 'publish';
				}

				$filtered_by_rating = false;
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
						$filtered_by_rating = true;
					}
				}
				// if display of replies is disabled and there is no filter by rating,
				// apply an additional condition to show only comments with rating meta fields only
				if( !$this->shortcode_atts['show_replies'] && !$filtered_by_rating ) {
					$args['meta_query']['relation'] = 'AND';
					$args['meta_query'][] = array(
						'key' => 'rating',
						'compare' => 'EXISTS',
						'type' => 'numeric'
					);
				}

				// Query needs to be modified if min_chars constraints are set
				if ( ! empty( $this->shortcode_atts['min_chars'] ) ) {
					add_filter( 'comments_clauses', array( $this, 'min_chars_comments_clauses' ) );
				}
				// Query needs to be modified if category constraints are set
				if ( ! empty( $this->shortcode_atts['categories'] ) ) {
					add_filter( 'comments_clauses', array( $this, 'modify_comments_clauses' ) );
				}
				$comments = get_comments($args);
				remove_filter( 'comments_clauses', array( $this, 'modify_comments_clauses' ) );
				remove_filter( 'comments_clauses', array( $this, 'min_chars_comments_clauses' ) );

				if( true === $this->shortcode_atts['show_products'] ) {
					foreach( $comments as $comment ) {
						//add links to products
						$prod_temp = new WC_Product( $comment->comment_post_ID );
						if( method_exists( $prod_temp, 'get_status' ) && 'publish' == $prod_temp->get_status() ){
							$q_name = $prod_temp->get_title();
							//qTranslate integration
							if( function_exists( 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage' ) ) {
								$q_name = qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage( $q_name );
							}
							$q_name = strip_tags( $q_name );
							$image = wp_get_attachment_image_url( $prod_temp->get_image_id(), apply_filters( 'cr_allreviews_image_size', 'woocommerce_gallery_thumbnail' ), false );
							$permalink = $prod_temp->get_permalink();
							$comment->comment_content .= '<p class="iv-comment-product">';
							if( $image ) {
								if( $permalink ) {
									$comment->comment_content .= '<a class="iv-comment-product-a" href="' . $permalink . '" title="' . $q_name . '">';
								}
								$comment->comment_content .= '<img class="iv-comment-product-img" src="' . $image . '" alt="' . $q_name . '"/>';
								if( $permalink ) {
									$comment->comment_content .= '</a>';
								}
							}
							if( $permalink ) {
								$comment->comment_content .= '<a href="' . $permalink . '" title="' . $q_name . '">';
							}
							$comment->comment_content .= $q_name . '</p>';
							if( $permalink ) {
								$comment->comment_content .= '</a>';
							}
						}
					}
				}

				$show_pictures = $this->shortcode_atts['show_pictures'];
				if( 'yes' === get_option( 'ivole_attach_image', 'no' ) && true === $show_pictures ) {
					//check WooCommerce version because PhotoSwipe lightbox is only supported in version 3.0+
					$class_a = 'ivole-comment-a-old';
					if ( ( version_compare( WC()->version, "3.0", ">=" ) ) ) {
						$class_a = 'ivole-comment-a';
					}
					foreach( $comments as $comment ) {
						//add pictures uploaded by customers
						$pics = get_comment_meta( $comment->comment_ID, 'ivole_review_image' );
						$pics_n = count( $pics );
						if( $pics_n > 0 ) {
							$comment->comment_content .= '<p class="cr-comment-image-text">' . __( 'Uploaded image(s):', 'customer-reviews-woocommerce' ) . '</p>';
							$comment->comment_content .= '<div class="iv-comment-images">';
							for( $i = 0; $i < $pics_n; $i ++) {
								$comment->comment_content .= '<div class="iv-comment-image">';
								$comment->comment_content .= '<a href="' . $pics[$i]['url'] . '" class="' . $class_a . '"><img src="' .
								$pics[$i]['url'] . '" alt="' . sprintf( __( 'Image #%1$d from ', 'customer-reviews-woocommerce' ), $i + 1 ) .
								$comment->comment_author . '" /></a>';
								$comment->comment_content .= '</div>';
							}
							$comment->comment_content .= '<div style="clear:both;"></div></div>';
						} else {
							//new implementation of storing pictures in comments meta
							$pics = get_comment_meta( $comment->comment_ID, 'ivole_review_image2' );
							$pics_n = count( $pics );
							if( $pics_n > 0 ) {
								$temp_comment_content_flag = false;
								$temp_comment_content = '<p class="cr-comment-image-text">' . __( 'Uploaded image(s):', 'customer-reviews-woocommerce' ) . '</p>';
								$temp_comment_content .= '<div class="iv-comment-images">';
								for( $i = 0; $i < $pics_n; $i ++) {
									$attachmentUrl = wp_get_attachment_url( $pics[$i] );
									if( $attachmentUrl ) {
										$temp_comment_content_flag = true;
										$temp_comment_content .= '<div class="iv-comment-image">';
										$temp_comment_content .= '<a href="' . $attachmentUrl . '" class="' . $class_a . '"><img src="' .
										$attachmentUrl . '" alt="' . sprintf( __( 'Image #%1$d from ', 'customer-reviews-woocommerce' ), $i + 1 ) .
										$comment->comment_author . '" /></a>';
										$temp_comment_content .= '</div>';
									}
								}
								$temp_comment_content .= '<div style="clear:both;"></div></div>';
								if( $temp_comment_content_flag ) {
									$comment->comment_content .= $temp_comment_content;
								}
							}
						}
					}
				}
			}

			if( true === $this->shortcode_atts['shop_reviews'] ) {
				$number_sr = $this->shortcode_atts['number_shop_reviews'] == -1 ? null : intval( $this->shortcode_atts['number_shop_reviews'] );
				if( 0 < $number_sr || null === $number_sr ) {
					if( $this->shop_page_id > 0 ) {
						$args = array(
							'number'      => $number_sr,
							'status'      => 'approve',
							'post_status' => 'publish',
							'post_id'     => $this->shop_page_id,
							'orderby'     => 'comment_date_gmt',
							'order'       => $this->shortcode_atts['sort'],
							'type__not_in' => 'cr_qna'
						);
						if( !$this->shortcode_atts['show_replies'] ) {
							$args['meta_key'] = 'rating';
						}
						if( get_query_var( $this->ivrating ) ) {
							$rating = intval( get_query_var( $this->ivrating ) );
							if( $rating > 0 && $rating <= 5 ) {
								$args['meta_query'][] = array(
									'key' => 'rating',
									'value'   => $rating,
									'compare' => '=',
									'type'    => 'numeric'
								);
							}
						}
						$comments_sr = get_comments($args);
						if( is_array( $comments ) && is_array( $comments_sr ) ) {
							$comments = array_merge( $comments, $comments_sr );
							$sort = $this->shortcode_atts['sort'];
							// sorting by helpfulness rating
							if( $this->shortcode_atts['sort_by'] === "helpful" ){
								usort( $comments, array($this, "sort_by_helpful"));
							} else {
								// sorting by date
								usort( $comments, function($a, $b) use ($sort) {
									if( $this->shortcode_atts['sort'] === 'asc' ) {
										return strtotime( $a->comment_date ) - strtotime( $b->comment_date );
									} else {
										return strtotime( $b->comment_date ) - strtotime( $a->comment_date );
									}
								});
							}
						}
					}
				}
			}

			//include review replies after application of filters
			if( get_query_var( $this->ivrating ) && $this->shortcode_atts['show_replies'] ) {
				$comments = $this->include_review_replies( $comments );
			}

			return $comments;
		}

		public function display_reviews() {
			global $paged;

			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else { $paged = 1; }
			$page = $paged ? $paged : 1;

			$per_page = $this->shortcode_atts['per_page'];

			if( 0  == $per_page ) {
				$per_page = 10;
			}

			$return = '<div id="cr_all_reviews_shortcode" class="cr-all-reviews-shortcode" data-attributes="' . wc_esc_json( wp_json_encode( $this->shortcode_atts ) ) . '">';

			// show summary bar
			if ($this->shortcode_atts['show_summary_bar']) {
				$return .= $this->show_summary_table();
			}

			$comments = $this->get_reviews();

			$return .= '<ol class="commentlist">';
			add_filter( 'woocommerce_product_get_rating_html', array( $this, 'replace_star_class' ), 10, 3 );
			$return .= wp_list_comments( apply_filters('ivole_product_review_list_args', array(
				'callback' => 'woocommerce_comments',
				'page'  => $page,
				'per_page' => $per_page,
				'reverse_top_level' => false,
				'echo' => false
			)), $comments );
			remove_filter( 'woocommerce_product_get_rating_html', array( $this, 'replace_star_class' ), 10 );
			$return .= '</ol>';

			if ( $this->shortcode_atts['show_more'] == 0 ) {
				$big = 999999999; // need an unlikely integer
				$pages = ceil(count($comments) / $per_page);
				$args = array(
					'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
					'format' => '?paged=%#%',
					'total' => $pages,
					'current' => $page,
					'show_all' => false,
					'end_size' => 1,
					'mid_size' => 2,
					'prev_next' => true,
					'prev_text' => __('&laquo;'),
					'next_text' => __('&raquo;'),
					'type' => 'plain'
				);

				// echo the pagination
				$return .= '<div class="cr-all-reviews-pagination">';
				$return .= paginate_links($args);
				$return .= '</div>';
			} else{
				$return .= '<button id="cr-show-more-all-reviews" class="ivole-show-more-button" type="button" data-page="1">';
				$return .=  __( 'Show more', 'customer-reviews-woocommerce' );
				$return .= '</button>';
				$return .= '<span id="cr-show-more-review-spinner" style="display:none;"></span>';
			}

			$return .= '</div>';

			return $return;
		}

		public function show_more_reviews() {
			$attributes = array();
			$filter_note = '';
			$rating = 0;
			if( isset( $_POST['attributes'] ) && is_array( $_POST['attributes'] ) ) {
				$attributes = $_POST['attributes'];
			}
			$this->fill_attributes($attributes);
			if( isset( $_POST['rating'] ) ) {
				$rating = intval( $_POST['rating'] );
				if( 0 < $rating && 5 >= $rating ) {
					set_query_var( $this->ivrating, $rating );
					$all = $this->count_ratings(0);
					$filtered_comments = sprintf( esc_html( _n( 'Showing %1$d of %2$d review (%3$d star). ', 'Showing %1$d of %2$d reviews (%3$d star). ', $all, 'customer-reviews-woocommerce' ) ), $this->count_ratings( $rating ), $all, $rating );
					$all_comments = sprintf( esc_html( _n( 'See all %d review', 'See all %d reviews', $all, 'customer-reviews-woocommerce' ) ), $all );
					$filter_note = '<div id="cr-ajax-reviews-fil-sta"><span>' . $filtered_comments . '</span><a class="ivole-seeAllReviews" data-rating="0" href="' . esc_url( get_permalink() ) . '">' . $all_comments . '</a></div>';
				}
			}

			$page = intval( $_POST['page'] ) + 1;
			$html = "";
			$comments = $this->get_reviews();

			add_filter( 'woocommerce_product_get_rating_html', array( $this, 'replace_star_class' ), 10, 3 );
			$html .= wp_list_comments( apply_filters( 'ivole_product_review_list_args', array(
				'callback' => 'woocommerce_comments',
				'page'  => $page,
				'per_page' => $this->shortcode_atts['show_more'],
				'reverse_top_level' => false,
				'echo' => false
			) ), $comments );
			remove_filter( 'woocommerce_product_get_rating_html', array( $this, 'replace_star_class' ), 10 );

			$count_pages = ceil( $this->count_ratings( $rating ) / $this->shortcode_atts['show_more'] );
			$last_page = false;
			if( $count_pages <= $page ) {
				$last_page = true;
			}

			wp_send_json( array(
				'page' => $page,
				'html' => $html,
				'filter_note' => $filter_note,
				'last_page' => $last_page
			) );
		}

		private function sort_by_helpful($a, $b) {
			$a_meta = get_comment_meta( $a->comment_ID, 'ivole_review_votes', true );
			$b_meta = get_comment_meta( $b->comment_ID, 'ivole_review_votes', true );

			$a_meta = $a_meta ? $a_meta : 0;
			$b_meta = $b_meta ? $b_meta : 0;

			// sort by dates if there is no helpful votes
			if( 0 === $a_meta && 0 === $b_meta ) {
				$a_meta = strtotime( $a->comment_date );
				$b_meta = strtotime( $b->comment_date );
			}

			if( $this->shortcode_atts['sort'] === 'asc' ) {
				return $a_meta - $b_meta;
			} else {
				return $b_meta - $a_meta;
			}
		}

		private function enqueue_wc_script( $handle, $path = '', $deps = array( 'jquery' ), $version = WC_VERSION, $in_footer = true ) {
			if ( ! wp_script_is( $handle, 'registered' ) ) {
				wp_register_script( $handle, $path, $deps, $version, $in_footer );
			}
			if( ! wp_script_is( $handle ) ) {
				wp_enqueue_script( $handle );
			}
		}

		private function enqueue_wc_style( $handle, $path = '', $deps = array(), $version = WC_VERSION, $media = 'all', $has_rtl = false ) {
			if ( ! wp_style_is( $handle, 'registered' ) ) {
				wp_register_style( $handle, $path, $deps, $version, $media );
			}
			if( ! wp_style_is( $handle ) ) {
				wp_enqueue_style( $handle );
			}
		}

		public function cr_style_1()
		{
			if( is_singular() && !is_product() ) {
				$disable_lightbox = 'yes' === get_option( 'ivole_disable_lightbox', 'no' ) ? true : false;
				// Load gallery scripts on product pages only if supported.
				if ( 'yes' === get_option( 'ivole_attach_image', 'no' ) || 'yes' === get_option( 'ivole_form_attach_media', 'no' ) ) {
					if ( !$disable_lightbox ) {
						$this->enqueue_wc_script( 'photoswipe-ui-default' );
						$this->enqueue_wc_style( 'photoswipe-default-skin' );
						add_action( 'wp_footer', array( $this, 'woocommerce_photoswipe' ) );
					}
				}

				wp_register_style( 'ivole-frontend-css', plugins_url('/css/frontend.css', dirname( dirname( __FILE__ ) ) ), array(), null, 'all' );
				wp_register_script( 'ivole-frontend-js', plugins_url('/js/frontend.js', dirname( dirname( __FILE__) ) ), array(), null, true );
				wp_enqueue_style( 'ivole-frontend-css' );
				wp_localize_script(
					'ivole-frontend-js',
					'ajax_object',
					array(
						'ajax_url' => admin_url( 'admin-ajax.php' ),
						'ajax_nonce' => wp_create_nonce( 'ivole-review-vote' ),
						'text_processing' => __( 'Processing...', 'customer-reviews-woocommerce' ),
						'text_thankyou' => __( 'Thank you for your feedback!', 'customer-reviews-woocommerce' ),
						'text_error1' => __( 'An error occurred with submission of your feedback. Please refresh the page and try again.', 'customer-reviews-woocommerce' ),
						'text_error2' => __( 'An error occurred with submission of your feedback. Please report it to the website administrator.', 'customer-reviews-woocommerce' ),
						'ivole_disable_lightbox' => ( $disable_lightbox ? 1 : 0 )
					)
				);
				wp_enqueue_script( 'ivole-frontend-js' );
			}
		}

		private function count_ratings( $rating )
		{
			$number = $this->shortcode_atts['number'] == -1 ? null : $this->shortcode_atts['number'];
			$args = array(
				'number'      => $number,
				'post_status' => 'publish',
				'post_type'   => 'product' ,
				'status' => 'approve',
				'parent' => 0,
				'count' => true,
				'post__in' => $this->shortcode_atts['products'],
				'type__not_in' => 'cr_qna'
			);
			if ($rating > 0) {
				$args['meta_query'][] = array(
					'key' => 'rating',
					'value'   => $rating,
					'compare' => '=',
					'type'    => 'numeric'
				);
			}
			// Query needs to be modified if min_chars constraints are set
			if ( ! empty( $this->shortcode_atts['min_chars'] ) ) {
				add_filter( 'comments_clauses', array( $this, 'min_chars_comments_clauses' ) );
			}
			// Query needs to be modified if category constraints are set
			if ( ! empty( $this->shortcode_atts['categories'] ) ) {
				add_filter( 'comments_clauses', array( $this, 'modify_comments_clauses' ) );
			}
			$count = get_comments($args);
			remove_filter( 'comments_clauses', array( $this, 'modify_comments_clauses' ) );
			remove_filter( 'comments_clauses', array( $this, 'min_chars_comments_clauses' ) );

			if( true === $this->shortcode_atts['shop_reviews'] ) {
				$number_sr = $this->shortcode_atts['number_shop_reviews'] == -1 ? null : $this->shortcode_atts['number_shop_reviews'];
				if( $this->shop_page_id > 0 ) {
					$args = array(
						'number'      => $number_sr,
						'status'      => 'approve',
						'post_status' => 'publish',
						'post_id'     => $this->shop_page_id,
						'meta_key'    => 'rating',
						'count'       => true,
						'type__not_in' => 'cr_qna'
					);
					if ($rating > 0) {
						$args['meta_query'][] = array(
							'key' => 'rating',
							'value'   => $rating,
							'compare' => '=',
							'type'    => 'numeric'
						);
					}
					// Query needs to be modified if min_chars constraints are set
					if ( ! empty( $this->shortcode_atts['min_chars'] ) ) {
						add_filter( 'comments_clauses', array( $this, 'min_chars_comments_clauses' ) );
					}
					$count_sr = get_comments($args);
					remove_filter( 'comments_clauses', array( $this, 'min_chars_comments_clauses' ) );

					$count = $count + $count_sr;
				}
			}

			return $count;
		}

		public function show_summary_table()
		{
			$all = $this->count_ratings(0);
			if ($all > 0) {
				$five = (float)$this->count_ratings(5);
				$five_percent = floor($five / $all * 100);
				$five_rounding = $five / $all * 100 - $five_percent;
				$four = (float)$this->count_ratings(4);
				$four_percent = floor($four / $all * 100);
				$four_rounding = $four / $all * 100 - $four_percent;
				$three = (float)$this->count_ratings(3);
				$three_percent = floor($three / $all * 100);
				$three_rounding = $three / $all * 100 - $three_percent;
				$two = (float)$this->count_ratings(2);
				$two_percent = floor($two / $all * 100);
				$two_rounding = $two / $all * 100 - $two_percent;
				$one = (float)$this->count_ratings(1);
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
				$output = '';
				$output .= '<div class="cr-summaryBox-wrap">';
				$output .= '<div class="cr-overall-rating-wrap">';
				$output .= '<div class="cr-average-rating"><span>' . number_format_i18n( $average, 1 ) . '</span></div>';
				$output .= '<div class="cr-average-rating-stars">'. wc_get_rating_html( $average ) .'</div>';
				$output .= '<div class="cr-total-rating-count">' . sprintf( _n( 'Based on %s review', 'Based on %s reviews', $all, 'customer-reviews-woocommerce' ), number_format_i18n( $all ) ) . '</div>';
				$output .= '</div>';
				if( 0 < $this->shortcode_atts['show_more'] ) {
					$output .= '<div class="ivole-summaryBox cr-all-reviews-ajax">';
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
						$filtered_comments = sprintf(esc_html(_n('Showing %1$d of %2$d review (%3$d star). ', 'Showing %1$d of %2$d reviews (%3$d star). ', $all, 'customer-reviews-woocommerce')), $this->count_ratings($rating), $all, $rating);
						$all_comments = sprintf(esc_html(_n('See all %d review', 'See all %d reviews', $all, 'customer-reviews-woocommerce')), $all);
						$output .= '<div class="cr-count-filtered-reviews">' . $filtered_comments . '<a class="ivole-seeAllReviews" href="' . esc_url( get_permalink() ) . '">' . $all_comments . '</a></div>';
					}
				}
				$output .= '</div>';
				return $output;
			}
		}

		/**
		* Modify the comments query to constrain results to the provided categories
		*/
		public function modify_comments_clauses( $clauses ) {
			global $wpdb;

			$terms = get_terms( array(
				'taxonomy' => 'product_cat',
				'include'  => $this->shortcode_atts['categories'],
				'fields'   => 'tt_ids'
			) );

			if ( is_array( $terms ) && count( $terms ) > 0 ) {
				$clauses['join'] .= " LEFT JOIN {$wpdb->term_relationships} ON {$wpdb->comments}.comment_post_ID = {$wpdb->term_relationships}.object_id";
				$clauses['where'] .= " AND {$wpdb->term_relationships}.term_taxonomy_id IN(" . implode( ',', $terms ) . ")";
			}

			return $clauses;
		}

		public function min_chars_comments_clauses( $clauses ) {
			global $wpdb;

			$clauses['where'] .= " AND CHAR_LENGTH({$wpdb->comments}.comment_content) >= " . $this->shortcode_atts['min_chars'];

			return $clauses;
		}

		private function include_review_replies( $comments ) {
			$comments_w_replies = array();
			foreach ( $comments as $comment ) {
				$comments_w_replies[]  = $comment;
				$args = array(
					'parent' => $comment->comment_ID,
					'format' => 'flat',
					'status' => 'approve',
					'orderby' => 'comment_date'
				);
				$comment_children = get_comments( $args );
				foreach ( $comment_children as $comment_child ) {
					$reply_already_exist = false;
					foreach( $comments as $comment_flat ) {
						if( $comment_flat->comment_ID === $comment_child->comment_ID ) {
							$reply_already_exist = true;
						}
					}
					if( !$reply_already_exist ) {
						$comments_w_replies[] = $comment_child;
					}
				}
			}
			return $comments_w_replies;
		}

		public function replace_star_class( $html, $rating, $count ) {
			$html = str_replace( 'star-rating', 'crstar-rating', $html );
			return $html;
		}

		public function woocommerce_photoswipe() {
			wc_get_template( 'single-product/photoswipe.php' );
		}
	}

endif;
