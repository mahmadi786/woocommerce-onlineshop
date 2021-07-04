<?php

if (! defined('ABSPATH')) {
	exit;
}

if (! class_exists('CR_Ajax_Reviews')) :

	class CR_Ajax_Reviews
	{
		private static $per_page = 2;
		private static $sort = 'recent';
		private static $rating = 0;
		private static $search = '';
		private static $tags = array();

		public function __construct()
		{
			self::$per_page = get_option( 'ivole_ajax_reviews_per_page', 5 );
			self::$sort = get_option( 'ivole_ajax_reviews_sort', 'recent' );
			add_action( 'wp_ajax_cr_show_more_reviews', array( 'CR_Ajax_Reviews', 'show_more_reviews' ) );
			add_action( 'wp_ajax_nopriv_cr_show_more_reviews', array( 'CR_Ajax_Reviews', 'show_more_reviews' ) );
			add_action( 'wp_ajax_cr_sort_reviews', array( 'CR_Ajax_Reviews', 'sort_reviews' ) );
			add_action( 'wp_ajax_nopriv_cr_sort_reviews', array( 'CR_Ajax_Reviews', 'sort_reviews' ) );
			add_action( 'wp_ajax_cr_filter_reviews', array( 'CR_Ajax_Reviews', 'filter_reviews' ) );
			add_action( 'wp_ajax_nopriv_cr_filter_reviews', array( 'CR_Ajax_Reviews', 'filter_reviews' ) );
			add_action( 'init', array( 'CR_Ajax_Reviews', 'register_slider_script' ) );
			add_action( 'cr_reviews_search', array( 'CR_Ajax_Reviews', 'display_search_ui' ) );
		}

		public static function get_reviews( $product_id ) {
			// different queries depending on sorting
			if( 'helpful' === self::$sort ) {
				// most helpful reviews first
				$args = array(
					'post_id' => $product_id,
					'status' => 'approve',
					'meta_query' => array(
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
					),
					'orderby' => array(
						'meta_value_num',
						'comment_date_gmt'
					),
					'order' => 'DESC'
				);
			} else {
				// most recent reviews first
				$args = array(
					'post_id' => $product_id,
					'status' => 'approve',
					'orderby' => 'comment_date_gmt',
					'order' => 'DESC'
				);
			}
			// filter by rating
			$args['meta_query']['relation'] = 'AND';
			if( 1 <= self::$rating && 5 >= self::$rating ) {
				$args['meta_query'][] = array(
					'key' => 'rating',
					'compare' => '=',
					'value' => self::$rating,
					'type' => 'NUMERIC'
				);
			} else {
				$args['meta_query'][] = array(
					'key' => 'rating',
					'compare' => 'EXISTS',
					'type' => 'NUMERIC'
				);
			}
			// search
			$args['search'] = self::$search;
			// tags
			if( 0 < count( self::$tags ) ) {
				$reviews_by_tags = get_objects_in_term( self::$tags, 'cr_tag' );
				if( $reviews_by_tags && !is_wp_error( $reviews_by_tags ) && is_array( $reviews_by_tags ) && 0 < count( $reviews_by_tags ) ) {
					$args['comment__in'] = $reviews_by_tags;
				}
			}
			// exclude qna
			$args['type__not_in'] = 'cr_qna';

			// get the reviews based on the prepared query
			$reviews_tmp = get_comments( $args );

			// get the featured reviews based on the prepared query
			$args['meta_query'][] = array(
				'key' => 'ivole_featured',
				'compare' => '>',
				'value' => '0',
				'type' => 'NUMERIC'
			);
			$featured_reviews_tmp = get_comments( $args );

			// remove featured reviews from the main array of the reviews while preserving their order
			if( 0 < count( $featured_reviews_tmp ) ) {
				$reviews = array();
				$featured_reviews = array();
				foreach ($reviews_tmp as $review_key => $review) {
					$is_featured = false;
					if( 0 < count( $featured_reviews_tmp ) ) {
						foreach ($featured_reviews_tmp as $featured_review_key => $featured_review) {
							if( $review->comment_ID === $featured_review->comment_ID ) {
								unset( $featured_reviews_tmp[$featured_review_key] );
								$review->comment_karma = 1;
								$featured_reviews[] = $review;
								$is_featured = true;
								break;
							}
						}
					}
					if( !$is_featured ) {
						$review->comment_karma = 0;
						$reviews[] = $review;
					}
				}
				// add the featured reviews back to the main array of reviews
				$reviews =  array_merge( $featured_reviews, $reviews );
			} else {
				$reviews = $reviews_tmp;
			}

			// replies are not counted against the number of reviews per page
			$top_level_reviews_count = count( $reviews );

			// add replies to reviews
			$replies = array();
			foreach ($reviews as $review) {
				$replies_temp = $review->get_children( array(
					'format' => 'flat',
					'status' => 'approve',
					'hierarchical' => 'flat'
				) );
				$replies = $replies + $replies_temp;
			}
			$reviews = array_merge( $reviews, $replies );

			//highlight search results
			if( !empty( self::$search ) ) {
				$highlight = self::$search;
				$reviews = array_map( function( $item ) use( $highlight ) {
					$item->comment_content = preg_replace( '/(' . $highlight . ')/iu', '<span class="cr-search-highlight">\0</span>', $item->comment_content );
					return $item;
				}, $reviews);
			}

			return array(
				'reviews' => apply_filters( 'cr_reviews_array', array( $reviews, array() ), $product_id ),
				'reviews_count' => $top_level_reviews_count
			);
		}

		public static function show_more_reviews() {
			$html = '';
			$page = 0;
			$last_page = false;
			if( isset( $_POST['productID'] ) ) {
				check_ajax_referer( 'cr_product_reviews_' . $_POST['productID'], 'security' );
				if( isset( $_POST['page'] ) ) {
					if( isset( $_POST['sort'] ) && ( 'recent' === $_POST['sort'] || 'helpful' === $_POST['sort'] ) ) {
						self::$sort = $_POST['sort'];
					}
					if( isset( $_POST['rating'] ) && ( 0 <= $_POST['rating'] && 6 > $_POST['rating'] ) ) {
						self::$rating = $_POST['rating'];
					}
					//search
					if( !empty( trim( $_POST['search'] ) ) ) {
						self::$search = sanitize_text_field( trim( $_POST['search'] ) );
					}
					//tags
					if( isset( $_POST['tags'] ) && is_array( $_POST['tags'] ) && count( $_POST['tags'] ) > 0 ) {
						self::$tags = array_map( 'intval', $_POST['tags'] );
					}
					$page = intval( $_POST['page'] ) + 1;
					$get_reviews = CR_Ajax_Reviews::get_reviews( $_POST['productID'] );
					$more_reviews = wp_list_comments( apply_filters(
						'woocommerce_product_review_list_args',
						array(
							'callback' => 'woocommerce_comments',
							'reverse_top_level' => false,
							'per_page' => self::$per_page,
							'page' => $page,
							'echo' => false )
						),
						$get_reviews['reviews'][0]
					);
					$html = $more_reviews;
					$count_pages = ceil( $get_reviews['reviews_count'] / self::$per_page );
					if( $count_pages <= $page ) {
						$last_page = true;
					}
				}
			}
			wp_send_json( array(
				'page' => $page,
				'html' => $html,
				'last_page' => $last_page )
			);
		}

		public static function get_per_page() {
			return self::$per_page;
		}

		public static function get_sort() {
			return self::$sort;
		}

		public static function sort_reviews() {
			$html = '';
			$page = 0;
			$last_page = false;
			if( isset( $_POST['productID'] ) ) {
				check_ajax_referer( 'cr_product_reviews_sort_' . $_POST['productID'], 'security' );
				if( isset( $_POST['sort'] ) ) {
					if( 'recent' === $_POST['sort'] || 'helpful' === $_POST['sort'] ) {
						self::$sort = $_POST['sort'];
						if( isset( $_POST['rating'] ) && ( 0 <= $_POST['rating'] && 6 > $_POST['rating'] ) ) {
							self::$rating = $_POST['rating'];
						}
						$get_reviews = CR_Ajax_Reviews::get_reviews( $_POST['productID'] );
						$more_reviews = wp_list_comments( apply_filters(
							'woocommerce_product_review_list_args',
							array(
								'callback' => 'woocommerce_comments',
								'reverse_top_level' => false,
								'per_page' => self::$per_page,
								'page' => 1,
								'echo' => false )
							),
							$get_reviews['reviews'][0]
						);
						$html = $more_reviews;
						$page = 1;
						if( $get_reviews['reviews_count'] <= self::$per_page ) {
							$last_page = true;
						}
					}
				}
			}
			wp_send_json( array(
				'page' => $page,
				'html' => $html,
				'last_page' => $last_page )
			);
		}

		public static function filter_reviews() {
			$html = '';
			$page = 0;
			$last_page = false;
			$filter_note = '';
			if( isset( $_POST['productID'] ) ) {
				check_ajax_referer( 'cr_product_reviews_filter_' . $_POST['productID'], 'security' );
				if( isset( $_POST['rating'] ) ) {
					if( 0 <= $_POST['rating'] && 6 > $_POST['rating'] ) {
						self::$rating = $_POST['rating'];
						if( isset( $_POST['sort'] ) && ( 'recent' === $_POST['sort'] || 'helpful' === $_POST['sort'] ) ) {
							self::$sort = $_POST['sort'];
						}
						$get_reviews = CR_Ajax_Reviews::get_reviews( $_POST['productID'] );
						$more_reviews = wp_list_comments( apply_filters(
							'woocommerce_product_review_list_args',
							array(
								'callback' => 'woocommerce_comments',
								'reverse_top_level' => false,
								'per_page' => self::$per_page,
								'page' => 1,
								'echo' => false )
							),
							$get_reviews['reviews'][0]
						);
						$html = $more_reviews;
						$page = 1;
						if( $get_reviews['reviews_count'] <= self::$per_page ) {
							$last_page = true;
						}
						if( 0 < self::$rating ) {
							$all = CR_Ajax_Reviews::count_ratings( $_POST['productID'], 0 );
							/* translators: %1$d is the displayed counts of reviews, %2$d is the total count of reviews, %3$d is the star rating of reviews */
							$filtered_comments = sprintf( esc_html( _n( 'Showing %1$d of %2$d review (%3$d star). ', 'Showing %1$d of %2$d reviews (%3$d star). ', $all, 'customer-reviews-woocommerce' ) ), CR_Ajax_Reviews::count_ratings( $_POST['productID'], self::$rating ), $all, self::$rating );
							/* translators: $d is the number of reviews */
							$all_comments = sprintf( esc_html( _n( 'See all %d review', 'See all %d reviews', $all, 'customer-reviews-woocommerce' ) ), $all );
							$filter_note = '<div id="cr-ajax-reviews-fil-sta"><span>' . $filtered_comments . '</span><a class="ivole-seeAllReviews" data-rating="0" href="' . esc_url( get_permalink( $_POST['productID'] ) ) . '#tab-reviews">' . $all_comments . '</a></div>';
						}
					}
				}
			}
			wp_send_json( array(
				'page' => $page,
				'html' => $html,
				'filter_note' => $filter_note,
				'last_page' => $last_page )
			);
		}

		public static function count_ratings( $product_id, $rating ) {
			$args = array(
				'post_id' => $product_id,
				'status' => 'approve',
				'parent' => 0,
				'count' => true
			);
			if( 0 === $rating ) {
				$args['meta_query'][] = array(
					'key' => 'rating',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'numeric'
				);
			} else if( $rating > 0 ){
				$args['meta_query'][] = array(
					'key' => 'rating',
					'value'   => $rating,
					'compare' => '=',
					'type'    => 'numeric'
				);
			}
			return get_comments( $args );
		}

		public static function update_reviews_meta() {
			$batch_size = 100;
			$args = array(
				'post_type' => 'product',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'ivole_review_votes',
						'compare' => 'NOT EXISTS'
					),
					array(
						'relation' => 'OR',
						array(
							'key' => 'ivole_review_reg_upvoters',
							'compare' => 'EXISTS'
						),
						array(
							'key' => 'ivole_review_reg_downvoters',
							'compare' => 'EXISTS'
						),
						array(
							'key' => 'ivole_review_unreg_upvoters',
							'compare' => 'EXISTS'
						),
						array(
							'key' => 'ivole_review_unreg_downvoters',
							'compare' => 'EXISTS'
						)
					)
				),
				'number' => $batch_size
			);
			$reviews = get_comments( $args );
			if( 0 < count( $reviews ) ) {
				// flag to show a message that reviews are being updated
				update_option( 'ivole_update_votes_meta', true );
				// loop through and update votes meta data in reviews
				foreach ($reviews as $review) {
					$r_upvotes = 0;
					$r_downvotes = 0;
					$u_upvotes = 0;
					$u_downvotes = 0;
					$registered_upvoters = get_comment_meta( $review->comment_ID, 'ivole_review_reg_upvoters', true );
					$registered_downvoters = get_comment_meta( $review->comment_ID, 'ivole_review_reg_downvoters', true );
					$unregistered_upvoters = get_comment_meta( $review->comment_ID, 'ivole_review_unreg_upvoters', true );
					$unregistered_downvoters = get_comment_meta( $review->comment_ID, 'ivole_review_unreg_downvoters', true );

					if( !empty( $registered_upvoters ) ) {
						$registered_upvoters = maybe_unserialize( $registered_upvoters );
						if( is_array( $registered_upvoters ) ) {
							$r_upvotes = count( $registered_upvoters );
						}
					}
					if( !empty( $registered_downvoters ) ) {
						$registered_downvoters = maybe_unserialize( $registered_downvoters );
						if( is_array( $registered_downvoters ) ) {
							$r_downvotes = count( $registered_downvoters );
						}
					}
					if( !empty( $unregistered_upvoters ) ) {
						$unregistered_upvoters = maybe_unserialize( $unregistered_upvoters );
						if( is_array( $unregistered_upvoters ) ) {
							$u_upvotes = count( $unregistered_upvoters );
						}
					}
					if( !empty( $unregistered_downvoters ) ) {
						$unregistered_downvoters = maybe_unserialize( $unregistered_downvoters );
						if( is_array( $unregistered_downvoters ) ) {
							$u_downvotes = count( $unregistered_downvoters );
						}
					}

					$votes = $r_upvotes + $u_upvotes - $r_downvotes - $u_downvotes;
					update_comment_meta( $review->comment_ID, 'ivole_review_votes', $votes );
				}
				return false;
			} else {
				// no more reviews to update, so remove the flag
				delete_option( 'ivole_update_votes_meta' );
				return true;
			}
		}

		public static function register_slider_script() {
			wp_register_script(
				'cr-reviews-slider',
				plugins_url( 'js/slick.min.js', dirname( dirname( __FILE__ ) ) ),
				array( 'jquery' ),
				'3.119',
				true
			);
			wp_register_style(
				'ivole-reviews-grid',
				plugins_url( 'css/reviews-grid.css', dirname( dirname( __FILE__ ) ) ),
				array(),
				'3.61'
			);
		}

		public static function display_search_ui( $reviews ) {
			if( apply_filters( 'cr_ajaxreviews_show_search', true ) ) :
				?>
				<div class="cr-ajax-search">
					<div>
						<input class="cr-input-text" type="text" placeholder="<?php echo __( 'Search customer reviews', 'customer-reviews-woocommerce' ); ?>">
						<span class="cr-clear-input">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-circle-fill" fill="#868686" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
							</svg>
						</span>
					</div>
					<button type="button" class="cr-button-search"><?php echo __( 'Search', 'customer-reviews-woocommerce' ); ?></button>
				</div>
				<?php
			endif;
			$all_tags = array();
			foreach ($reviews[0] as $review) {
				$review_tags = wp_get_object_terms( $review->comment_ID, 'cr_tag' );
				if( $review_tags && !is_wp_error( $review_tags ) ) {
					$all_tags = array_merge( $all_tags, $review_tags );
				}
			}
			$output = '';
			if( 0 < count( $all_tags ) ) {
				$unique_tags = array();
				foreach ($all_tags as $tag) {
					$tag_exists = false;
					foreach ($unique_tags as $utag) {
						if( $utag->term_id === $tag->term_id ) {
							$tag_exists = true;
							break;
						}
					}
					if( !$tag_exists ) {
						$unique_tags[] = $tag;
						$output .= '<span class="cr-tags-filter cr-tag cr-tag-' . $tag->term_id . '" data-crtagid="' . $tag->term_id . '">' . esc_html( $tag->name ) . '</span> ';
					}
				}
			}
			echo '<div class="cr-review-tags-filter">' . $output . '</div>';
		}

	}

endif;
