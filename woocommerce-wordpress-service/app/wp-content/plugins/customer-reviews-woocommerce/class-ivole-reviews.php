<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( ABSPATH . 'wp-admin/includes/media.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/image.php' );

if ( ! class_exists( 'Ivole_Reviews' ) ) :

	require_once( 'class-ivole-email.php' );
	require_once( 'class-cr-custom-questions.php' );
	require_once( __DIR__ . '/includes/qna/class-cr-qna.php' );

	class Ivole_Reviews {

		private $limit_file_size = 5000000;
		private $limit_file_count = 3;
		private $ivrating = 'ivrating';
		private $ivole_reviews_verified = 'no';
		private $ivole_form_geolocation = 'no';
		private $ivole_reviews_histogram = 'no';
		private $ivole_ajax_reviews = 'no';
		private $disable_lightbox = false;
		protected $lang;

		public function __construct() {
			$this->limit_file_count = get_option( 'ivole_attach_image_quantity', 3 );
			$this->limit_file_size = 1024 * 1024 * get_option( 'ivole_attach_image_size', 5 );
			$this->lang = CR_Trust_Badge::get_badge_language();
			$this->disable_lightbox = 'yes' === get_option( 'ivole_disable_lightbox', 'no' ) ? true : false;
			$this->ivole_reviews_histogram = get_option( 'ivole_reviews_histogram', 'no' );
			$this->ivole_ajax_reviews = get_option( 'ivole_ajax_reviews', 'no' );

			add_action( 'wp_enqueue_scripts', array( $this, 'cr_style_1' ) );
			if( 'yes' === get_option( 'ivole_attach_image', 'no' ) ) {
				add_action( 'woocommerce_product_review_comment_form_args', array( $this, 'custom_fields_attachment' ) );
				add_filter( 'wp_insert_comment', array( $this, 'save_review_image' ) );
				add_action( 'wp_ajax_cr_upload_local_images_frontend', array( $this, 'new_ajax_upload' ) );
				add_action( 'wp_ajax_nopriv_cr_upload_local_images_frontend', array( $this, 'new_ajax_upload' ) );
				add_action( 'wp_ajax_cr_delete_local_images_frontend', array( $this, 'new_ajax_delete' ) );
				add_action( 'wp_ajax_nopriv_cr_delete_local_images_frontend', array( $this, 'new_ajax_delete' ) );
			}
			if( 'yes' === get_option( 'ivole_form_attach_media', 'no' ) || 'yes' == get_option( 'ivole_attach_image', 'no' ) ) {
				if( 'yes' === $this->ivole_ajax_reviews ) {
					add_filter( 'cr_reviews_array', array( $this, 'display_review_image_ajax' ) );
					add_action( 'cr_reviews_customer_images', array( $this, 'display_review_images_top' ) );
				} else {
					add_filter( 'comments_array', array( $this, 'display_review_image' ), 12 );
				}
			}
			if( self::is_captcha_enabled() ) {
				if( is_user_logged_in() ) {
					add_action( 'woocommerce_product_review_comment_form_args', array( $this, 'custom_fields_captcha' ) );
				} else {
					add_action( 'comment_form_after_fields', array( $this, 'custom_fields_captcha2' ) );
				}
				add_filter( 'preprocess_comment', array( $this, 'validate_captcha' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'cr_style_2' ), 11 );
			}
			if( 'yes' === $this->ivole_reviews_histogram || 'yes' === get_option( 'ivole_reviews_shortcode', 'no' ) ) {
				add_action( 'init', array( $this, 'add_query_var' ), 20 );
			}
			if( 'yes' === $this->ivole_reviews_histogram || 'yes' === $this->ivole_ajax_reviews ) {
				add_filter( 'comments_template', array( $this, 'load_custom_comments_template' ), 100 );
			}
			if( 'yes' === $this->ivole_reviews_histogram ) {
				add_action( 'ivole_reviews_summary', array( $this, 'show_summary_table' ), 10, 2 );
				add_filter( 'comments_template_query_args', array( $this, 'filter_comments2' ), 20);
				add_filter( 'comments_array', array( $this, 'include_review_replies' ), 11, 2 );
			}
			if( 'yes' === get_option( 'ivole_reviews_voting', 'no' ) ) {
				add_action( 'wp_ajax_ivole_vote_review', array( $this, 'vote_review_registered' ) );
				add_action( 'wp_ajax_nopriv_ivole_vote_review', array( $this, 'vote_review_unregistered' ) );
				add_action( 'cr_reviews_sorting', array( $this, 'show_sorting_ui' ), 10, 2 );

				if ( ( version_compare( WC()->version, "2.2.11", ">=" ) ) && ( version_compare( WC()->version, "2.5", "<" ) )  ) {
					add_filter( 'wc_get_template', array( $this, 'compatibility_reviews'), 10, 5 );
					add_action( 'ivole_woocommerce_review_after_comment_text', array( $this, 'display_voting_buttons' ), 10 );
				} elseif ( ( version_compare( WC()->version, "2.5", ">=" ) ) ) {
					add_action( 'woocommerce_review_after_comment_text', array( $this, 'display_voting_buttons' ), 10 );
				}
			} else {
				// voting is disabled but we still might need to display UI for adding new reviews
				add_action( 'cr_reviews_sorting', array( $this, 'show_sorting_ui_2' ), 10, 2 );
			}
			$this->ivole_reviews_verified = get_option( 'ivole_reviews_verified', 'no' );
			$this->ivole_form_geolocation = get_option( 'ivole_form_geolocation', 'no' );
			if( 'yes' === $this->ivole_reviews_verified || 'yes' === $this->ivole_form_geolocation ) {
				if ( ( version_compare( WC()->version, "2.2.11", ">=" ) ) && ( version_compare( WC()->version, "2.5", "<" ) )  ) {
					add_filter( 'wc_get_template', array( $this, 'compatibility_reviews'), 10, 5 );
					add_action( 'ivole_woocommerce_review_before_comment_text', array( $this, 'display_verified_badge' ), 10 );
				} elseif ( ( version_compare( WC()->version, "2.5", ">=" ) ) ) {
					add_action( 'woocommerce_review_before_comment_text', array( $this, 'display_verified_badge' ), 10 );
				}
			}
			if( 'yes' === $this->ivole_reviews_verified && 'yes' === get_option( 'ivole_trust_badge_floating', 'no' ) && ! is_admin() ) {
				new CR_Floating_Trust_Badge();
			}
			add_action( 'woocommerce_review_before_comment_text', array( $this, 'display_custom_questions' ), 11 );
			add_action( 'woocommerce_review_meta', array( $this, 'cusrev_review_meta' ), 9, 1 );
			if( !current_theme_supports( 'wc-product-gallery-lightbox' ) && !$this->disable_lightbox ) {
				add_action( 'wp_footer', array( $this, 'woocommerce_photoswipe' ) );
			}
			add_action( 'woocommerce_review_before_comment_text', array( $this, 'display_featured' ), 9 );
		}
		public function custom_fields_attachment( $comment_form ) {
			$post_id = get_the_ID();
			$html_field_attachment = '<div class="cr-upload-local-images"><div class="cr-upload-images-preview"></div>';
			$html_field_attachment .= '<label for="review_image" class="cr-upload-images-status">';
			$html_field_attachment .= sprintf( __( 'Upload up to %d images for your review (GIF, PNG, JPG, JPEG):', 'customer-reviews-woocommerce' ), $this->limit_file_count );
			$html_field_attachment .= '</label><input type="file" accept="image/*" multiple="multiple" name="review_image_';
			$html_field_attachment .= $post_id . '[]" id="cr_review_image" data-nonce="' . wp_create_nonce( 'cr-upload-images-frontend' );
			$html_field_attachment .= '" data-postid="' . $post_id . '" />';
			$html_field_attachment .= '</div>';
			$comment_form['comment_field'] .= apply_filters( 'ivole_custom_fields_attachment2', $html_field_attachment );
			$comment_form = apply_filters( 'ivole_custom_fields_attachment', $comment_form );
			return $comment_form;
		}
		public function custom_fields_captcha( $comment_form ) {
			$site_key = self::captcha_site_key();
			$comment_form['comment_field'] .= '<div style="clear:both;"></div><div class="cr-recaptcha'
				. (CR_Qna::is_captcha_enabled() ? '' : ' g-recaptcha')
				. '" data-sitekey="' . $site_key . '"></div>';
			return $comment_form;
		}
		public function custom_fields_captcha2() {
			$site_key = self::captcha_site_key();
			echo '<div style="clear:both;"></div>';
			echo '<div class="cr-recaptcha' . (CR_Qna::is_captcha_enabled() ? '' : ' g-recaptcha') .
				'" data-sitekey="' . $site_key . '"></div>';
		}
		public function save_review_image( $comment_id ) {
			if( isset( $_POST['cr-upload-images-ids'] ) && is_array( $_POST['cr-upload-images-ids'] ) ) {
				$nFiles = count( $_POST['cr-upload-images-ids'] );
				// check count of files
				if( $nFiles > $this->limit_file_count ) {
					echo sprintf( __( 'Error: You tried to upload too many files. The maximum number of files that you can upload is %d.', 'customer-reviews-woocommerce' ), $this->limit_file_count );
					echo '<br/>' . sprintf( __( 'Go back to: %s', 'customer-reviews-woocommerce' ), '<a href="' . get_permalink( $post_id ) . '">' . get_the_title( $post_id ) . '</a>' );
					die;
				}
				foreach ($_POST['cr-upload-images-ids'] as $image) {
					$image_decoded = json_decode( stripslashes( $image ), true );
					if( $image_decoded && is_array( $image_decoded ) ) {
						if( isset( $image_decoded["id"] ) && $image_decoded["id"] ) {
							if( isset( $image_decoded["key"] ) && $image_decoded["key"] ) {
								$attachmentId = intval( $image_decoded["id"] );
								if( 'attachment' === get_post_type( $attachmentId ) ) {
									if( $image_decoded["key"] === get_post_meta( $attachmentId, 'cr-upload-temp-key', true ) ) {
										add_comment_meta( $comment_id, 'ivole_review_image2', $attachmentId );
										delete_post_meta( $attachmentId, 'cr-upload-temp-key' );
									}
								}
							}
						}
					}
				}
			}
		}
		private function is_valid_file_type( $type ) {
			$type = strtolower( trim ( $type ) );
			return  $type == 'png' || $type == 'gif' || $type == 'jpg' || $type == 'jpeg';
		}
		public function display_review_image( $comments ) {
			if( count( $comments ) > 0 ) {
				//check WooCommerce version because PhotoSwipe lightbox is only supported in version 3.0+
				$class_a = 'ivole-comment-a-old';
				if ( ( version_compare( WC()->version, "3.0", ">=" ) ) ) {
					$class_a = 'ivole-comment-a';
				}
				foreach( $comments as $comment ) {
					$pics = get_comment_meta( $comment->comment_ID, 'ivole_review_image' );
					$pics_local = get_comment_meta( $comment->comment_ID, 'ivole_review_image2' );
					$pics_v = get_comment_meta( $comment->comment_ID, 'ivole_review_video' );
					$pics_n = count( $pics );
					$pics_local_n = count( $pics_local );
					$pics_v_n = count( $pics_v );
					if( $pics_n > 0 || $pics_v_n > 0 || 0 < $pics_local_n ) {
						if( 0 < $pics_n || 0 < $pics_local_n ) {
							$comment->comment_content .= '<p class="cr-comment-image-text">' . __( 'Uploaded image(s):', 'customer-reviews-woocommerce' ) . '</p>';
							$comment->comment_content .= '<div class="iv-comment-images">';
							$k = 1;
							if( 0 < $pics_n ) {
								for( $i = 0; $i < $pics_n; $i++ ) {
									$comment->comment_content .= '<div class="iv-comment-image">';
									$comment->comment_content .= '<a href="' . $pics[$i]['url'] . '" class="' . $class_a . '" rel="nofollow"><img src="' .
									$pics[$i]['url'] . '" alt="' . sprintf( __( 'Image #%1$d from ', 'customer-reviews-woocommerce' ), $k ) .
									$comment->comment_author . '" loading="lazy"></a>';
									$comment->comment_content .= '</div>';
									$k++;
								}
							}
							if( 0 < $pics_local_n ) {
								$temp_comment_content_flag = false;
								$temp_comment_content = '';
								for( $i = 0; $i < $pics_local_n; $i++ ) {
									$attachmentUrl = wp_get_attachment_image_url( $pics_local[$i], apply_filters( 'cr_reviews_image_size', 'large' ) );
									if( $attachmentUrl ) {
										$temp_comment_content_flag = true;
										$temp_comment_content .= '<div class="iv-comment-image">';
										$temp_comment_content .= '<a href="' . $attachmentUrl . '" class="' . $class_a . '"><img src="' .
										$attachmentUrl . '" alt="' . sprintf( __( 'Image #%1$d from ', 'customer-reviews-woocommerce' ), $k ) .
										$comment->comment_author . '" loading="lazy"></a>';
										$temp_comment_content .= '</div>';
										$k++;
									}
								}
								if( $temp_comment_content_flag ) {
									$comment->comment_content .= $temp_comment_content;
								}
							}
							$comment->comment_content .= '<div style="clear:both;"></div></div>';
						}
						if( $pics_v_n > 0 ) {
							$comment->comment_content .= '<p class="cr-comment-video-text">' . __( 'Uploaded video(s):', 'customer-reviews-woocommerce' ) . '</p>';
							$comment->comment_content .= '<div id="iv-comment-videos-id" class="iv-comment-videos">';
							for( $i = 0; $i < $pics_v_n; $i ++) {
								$comment->comment_content .= '<div id="iv-comment-video-id-' . ($i + 1) . '" class="iv-comment-video">';
								$comment->comment_content .= '<video preload="metadata" class="ivole-video-a" ';
								$comment->comment_content .= 'src="' . $pics_v[$i]['url'];
								$comment->comment_content .= '" alt="' . sprintf( __( 'Video #%1$d from ', 'customer-reviews-woocommerce' ), $i + 1 ) .
								$comment->comment_author . '"></video>';
								$comment->comment_content .= '<img class="iv-comment-video-icon" src="' . plugin_dir_url( __FILE__ ) . 'img/video.svg">';
								$comment->comment_content .= '</div>';
							}
							$comment->comment_content .= '<div style="clear:both;"></div></div>';
						}
					}
				}
			}
			return $comments;
		}
		public function display_review_image_ajax( $reviews ) {
			$comments = $reviews[0];
			$all_pics = array();
			if( count( $comments ) > 0 ) {
				//check WooCommerce version because PhotoSwipe lightbox is only supported in version 3.0+
				$class_a = 'ivole-comment-a-old';
				if ( ( version_compare( WC()->version, "3.0", ">=" ) ) ) {
					$class_a = 'ivole-comment-a';
				}
				foreach( $comments as $comment ) {
					$pics = get_comment_meta( $comment->comment_ID, 'ivole_review_image' );
					$pics_local = get_comment_meta( $comment->comment_ID, 'ivole_review_image2' );
					$pics_v = get_comment_meta( $comment->comment_ID, 'ivole_review_video' );
					$pics_n = count( $pics );
					$pics_local_n = count( $pics_local );
					$pics_v_n = count( $pics_v );
					if( $pics_n > 0 || $pics_v_n > 0 || 0 < $pics_local_n ) {
						if( 0 < $pics_n || 0 < $pics_local_n ) {
							$comment->comment_content .= '<p class="cr-comment-image-text">' . __( 'Uploaded image(s):', 'customer-reviews-woocommerce' ) . '</p>';
							$comment->comment_content .= '<div class="iv-comment-images">';
							$k = 1;
							if( $pics_n > 0 ) {
								for( $i = 0; $i < $pics_n; $i ++) {
									$all_pics[] = array( array( 'type' => 'url', 'value' => $pics[$i]['url'] ), $comment );
									$comment->comment_content .= '<div class="iv-comment-image">';
									$comment->comment_content .= '<a href="' . $pics[$i]['url'] . '" class="' . $class_a . '" rel="nofollow"><img src="' .
									$pics[$i]['url'] . '" alt="' . sprintf( __( 'Image #%1$d from ', 'customer-reviews-woocommerce' ), $k ) .
									$comment->comment_author . '" loading="lazy"></a>';
									$comment->comment_content .= '</div>';
									$k++;
								}
							}
							if( 0 < $pics_local_n ) {
								$temp_comment_content_flag = false;
								$temp_comment_content = '';
								for( $i = 0; $i < $pics_local_n; $i ++) {
									$all_pics[] = array( array( 'type' => 'attachment_id', 'value' => $pics_local[$i] ), $comment );
									$attachmentUrl = wp_get_attachment_image_url( $pics_local[$i], apply_filters( 'cr_ajaxreviews_image_size', 'large' ) );
									if( $attachmentUrl ) {
										$temp_comment_content_flag = true;
										$temp_comment_content .= '<div class="iv-comment-image">';
										$temp_comment_content .= '<a href="' . $attachmentUrl . '" class="' . $class_a . '"><img src="' .
										$attachmentUrl . '" alt="' . sprintf( __( 'Image #%1$d from ', 'customer-reviews-woocommerce' ), $k ) .
										$comment->comment_author . '" loading="lazy"></a>';
										$temp_comment_content .= '</div>';
										$k++;
									}
								}
								if( $temp_comment_content_flag ) {
									$comment->comment_content .= $temp_comment_content;
								}
							}
							$comment->comment_content .= '<div style="clear:both;"></div></div>';
						}
						if( $pics_v_n > 0 ) {
							$comment->comment_content .= '<p class="cr-comment-video-text">' . __( 'Uploaded video(s):', 'customer-reviews-woocommerce' ) . '</p>';
							$comment->comment_content .= '<div id="iv-comment-videos-id" class="iv-comment-videos">';
							for( $i = 0; $i < $pics_v_n; $i ++) {
								$all_pics[] = array( array( 'type' => 'video', 'value' => $pics_v[$i]['url'] ), $comment );
								$comment->comment_content .= '<div id="iv-comment-video-id-' . ($i + 1) . '" class="iv-comment-video">';
								$comment->comment_content .= '<video preload="metadata" class="ivole-video-a" ';
								$comment->comment_content .= 'src="' . $pics_v[$i]['url'];
								$comment->comment_content .= '" alt="' . sprintf( __( 'Video #%1$d from ', 'customer-reviews-woocommerce' ), $i + 1 ) .
								$comment->comment_author . '"></video>';
								$comment->comment_content .= '<img class="iv-comment-video-icon" src="' . plugin_dir_url( __FILE__ ) . 'img/video.svg">';
								$comment->comment_content .= '</div>';
							}
							$comment->comment_content .= '<div style="clear:both;"></div></div>';
						}
					}
				}
			}
			return array( $comments, $all_pics );
		}
		// include replies to reviews when filtering by number of stars
		public function include_review_replies( $comments, $post_id ){
			$comments_flat = array();
			foreach ( $comments as $comment ) {
				$comments_flat[]  = $comment;
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
						$comments_flat[] = $comment_child;
					}
				}
			}
			return $comments_flat;
		}
		public function display_voting_buttons( $comment ) {
			if( 0 === intval( $comment->comment_parent ) ) {
				$votes = $this->get_votes( $comment->comment_ID );
				$prompt = __( 'Was this review helpful to you?', 'customer-reviews-woocommerce' );
				if( $votes['total'] > 0 ) {
					$prompt = sprintf( __( '%d out of %d people found this helpful. Was this review helpful to you?', 'customer-reviews-woocommerce' ), $votes['upvotes'], $votes['total'] );
				}
				if( is_array( $votes ) ) {
					echo '<span class="ivole-voting-cont"><span class="ivole-reviewvoting-' . $comment->comment_ID . '">';
					echo $prompt . '</span>';

					echo '<span class="ivole-declarative">';
					echo '<a class="ivole-a-button" href="#" data-vote="'. $comment->comment_ID .'" data-upvote="1">';
					echo '<div class="ivole-vote-button">';
					echo __( 'Yes', 'customer-reviews-woocommerce' );
					echo '</div></a></span>';

					echo '<span class="ivole-declarative">';
					echo '<a class="ivole-a-button" href="#" data-vote="' . $comment->comment_ID . '" data-upvote="0">';
					echo '<div class="ivole-vote-button">';
					echo __( 'No', 'customer-reviews-woocommerce' );
					echo '</div></a></span>';

					echo '</span>';
				}
			}
		}
		public function cr_style_1() {
			if( is_product() ) {
				if( !current_theme_supports( 'wc-product-gallery-lightbox' ) && !$this->disable_lightbox ) {
					wp_enqueue_script( 'photoswipe-ui-default' );
					wp_enqueue_style( 'photoswipe-default-skin' );
				}
				wp_register_style( 'ivole-frontend-css', plugins_url( '/css/frontend.css', __FILE__ ), array(), null, 'all' );
				wp_register_script( 'ivole-frontend-js', plugins_url( '/js/frontend.js', __FILE__ ), array(), null, true );
				wp_enqueue_style( 'ivole-frontend-css' );
				wp_localize_script( 'ivole-frontend-js', 'ajax_object',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'ajax_nonce' => wp_create_nonce('ivole-review-vote'),
					'text_processing' => __( 'Processing...', 'customer-reviews-woocommerce' ),
					'text_thankyou' => __( 'Thank you for your feedback!', 'customer-reviews-woocommerce' ),
					'text_error1' => __( 'An error occurred with submission of your feedback. Please refresh the page and try again.', 'customer-reviews-woocommerce' ),
					'text_error2' => __( 'An error occurred with submission of your feedback. Please report it to the website administrator.', 'customer-reviews-woocommerce' ),
					'ivole_recaptcha' => self::is_captcha_enabled() ? 1 : 0,
					'ivole_disable_lightbox' => ( $this->disable_lightbox ? 1 : 0 ),
					'ivole_allow_empty_comment' => ( apply_filters( 'allow_empty_comment', false ) ? 1 : 0 ),
					'ivole_allow_empty_comment_alert' => __( 'Please type your review text', 'customer-reviews-woocommerce' ),
					'cr_upload_initial' => sprintf( __( 'Upload up to %d images for your review (GIF, PNG, JPG, JPEG):', 'customer-reviews-woocommerce' ), $this->limit_file_count ),
					'cr_upload_error_file_type' => __( 'Error: accepted file types are PNG, JPG, JPEG, GIF', 'customer-reviews-woocommerce' ),
					'cr_upload_error_too_many' => sprintf( __( 'Error: You tried to upload too many files. The maximum number of files that can be uploaded is %d.', 'customer-reviews-woocommerce' ), $this->limit_file_count ),
					'cr_upload_error_file_size' => __( 'Error: the file(s) is too large', 'customer-reviews-woocommerce' ),
					'cr_images_upload_limit' => $this->limit_file_count,
					'cr_images_upload_max_size' => $this->limit_file_size
				)
			);
			wp_enqueue_script( 'ivole-frontend-js' );
			wp_enqueue_style( 'dashicons' );
		}
	}
	public function cr_style_2() {
		if ( is_product() ) {
			if ( CR_Qna::is_captcha_enabled() ) {
				$script_file_basename = 'reviews-qa-captcha';
				$script_id = 'cr-' . $script_file_basename;
				wp_register_script(
					$script_id,
					plugins_url( 'js/' . $script_file_basename . '.js', __FILE__ ),
					array(),
					'4.9',
					true
				);
				wp_localize_script( $script_id, 'crReviewsQaCaptchaConfig', array(
					'v2Sitekey' => self::captcha_site_key(),
				) );
				wp_enqueue_script( $script_id );
			} else {
				wp_register_script( 'cr-recaptcha', 'https://www.google.com/recaptcha/api.js?hl=' . $this->lang, array(), null, true );
				wp_enqueue_script( 'cr-recaptcha' );
			}
		}
	}
	public function validate_captcha( $commentdata ) {
		if( is_admin() && current_user_can( 'edit_posts' ) ) {
			return $commentdata;
		}
		if( 'cr_qna' !== $commentdata['comment_type'] ) {
			if( get_post_type( $commentdata['comment_post_ID'] ) === 'product' ) {
				if( !$this->ping_captcha() ) {
					wp_die( __( 'reCAPTCHA vertification failed and your review cannot be saved.', 'customer-reviews-woocommerce' ), __( 'Add Review Error', 'customer-reviews-woocommerce' ), array( 'back_link' => true ) );
				}
			}
		}
		return $commentdata;
	}
	private function ping_captcha( $recaptcha = null ) {
		if( !$recaptcha && isset( $_POST['g-recaptcha-response'] ) ) {
			$recaptcha = $_POST['g-recaptcha-response'];
		}
		if( $recaptcha ) {
			$secret_key = get_option( 'ivole_captcha_secret_key', '' );
			$response = json_decode( wp_remote_retrieve_body( wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array( 'body' => array( 'secret' => $secret_key, 'response' => $recaptcha ) ) ) ), true );
			if( $response["success"] )
			{
				return true;
			}
		}
		return false;
	}
	public function load_custom_comments_template( $template ) {
		if ( get_post_type() !== 'product' ) {
			return $template;
		}
		$plugin_folder = 'customer-reviews-woocommerce';
		$check_dirs = array(
			trailingslashit( get_stylesheet_directory() ) . $plugin_folder,
			trailingslashit( get_template_directory() ) . $plugin_folder
		);
		$template_file_name = 'ivole-single-product-reviews.php';
		if( 'yes' === $this->ivole_ajax_reviews ) {
			$template_file_name = 'cr-ajax-product-reviews.php';
		}
		foreach ( $check_dirs as $dir ) {
			if ( file_exists( trailingslashit( $dir ) . $template_file_name ) ) {
				return trailingslashit( $dir ) . $template_file_name;
			}
		}
		return wc_locate_template( $template_file_name, '', plugin_dir_path ( __FILE__ ) . '/templates/' );
	}
	public function show_summary_table( $product_id, $is_ajax = false ) {
		$tab_reviews = apply_filters( 'cr_productpage_reviews_tab', '#tab-reviews' );
		$all = $this->count_ratings( $product_id, 0 );
		if( $all > 0 ) {
			$five = (float)$this->count_ratings( $product_id, 5 );
			$five_percent = floor( $five / $all * 100 );
			$five_rounding = $five / $all * 100 - $five_percent;
			$four = (float)$this->count_ratings( $product_id, 4 );
			$four_percent = floor( $four / $all * 100 );
			$four_rounding = $four / $all * 100 - $four_percent;
			$three = (float)$this->count_ratings( $product_id, 3 );
			$three_percent = floor( $three / $all * 100 );
			$three_rounding = $three / $all * 100 - $three_percent;
			$two = (float)$this->count_ratings( $product_id, 2 );
			$two_percent = floor( $two / $all * 100 );
			$two_rounding = $two / $all * 100 - $two_percent;
			$one = (float)$this->count_ratings( $product_id, 1 );
			$one_percent = floor( $one / $all * 100 );
			$one_rounding = $one / $all * 100 - $one_percent;
			$hundred = $five_percent + $four_percent + $three_percent + $two_percent + $one_percent;
			// if( $hundred < 100 ) {
			// 	$to_distribute = 100 - $hundred;
			// 	$roundings = array( '5' => $five_rounding, '4' => $four_rounding, '3' => $three_rounding, '2' => $two_rounding, '1' => $one_rounding );
			// 	arsort($roundings);
			// 	error_log( print_r( $roundings, true ) );
			// }
			$average = 0;
			$product = wc_get_product( $product_id );
			if( $product ) {
				$average = $product->get_average_rating();
			}
			$output = '';
			$output .= '<div class="cr-summaryBox-wrap">';
			$output .= '<div class="cr-overall-rating-wrap">';
			$output .= '<div class="cr-average-rating"><span>' . number_format_i18n( $average, 1 ) . '</span></div>';
			$output .= '<div class="cr-average-rating-stars">'. wc_get_rating_html( $average ) .'</div>';
			$output .= '<div class="cr-total-rating-count">' . sprintf( _n( 'Based on %s review', 'Based on %s reviews', $all, 'customer-reviews-woocommerce' ), number_format_i18n( $all ) ) . '</div>';
			$output .= '</div>';
			if( $is_ajax ) {
				$nonce = wp_create_nonce( "cr_product_reviews_filter_" . $product_id );
				$output .= '<div class="ivole-summaryBox cr-summaryBox-ajax" data-nonce="' . $nonce . '">';
			} else {
				$output .= '<div class="ivole-summaryBox">';
			}
			$output .= '<table id="ivole-histogramTable">';
			$output .= '<tbody>';
			$output .= '<tr class="ivole-histogramRow">';
			if( $five > 0 ) {
				$output .= '<td class="ivole-histogramCell1"><a class="ivole-histogram-a" data-rating="5" href="' . esc_url( add_query_arg( $this->ivrating, 5, get_permalink( $product_id ) ) ) . $tab_reviews . '" title="' . __( '5 star', 'customer-reviews-woocommerce' ) . '">' . __( '5 star', 'customer-reviews-woocommerce' ) . '</a></td>';
				$output .= '<td class="ivole-histogramCell2"><a class="ivole-histogram-a" data-rating="5" href="' . esc_url( add_query_arg( $this->ivrating, 5, get_permalink( $product_id ) ) ) . $tab_reviews . '"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $five_percent . '%"></div></div></a></td>';
				$output .= '<td class="ivole-histogramCell3"><a class="ivole-histogram-a" data-rating="5" href="' . esc_url( add_query_arg( $this->ivrating, 5, get_permalink( $product_id ) ) ) . $tab_reviews . '">' . (string)$five_percent . '%</a></td>';
			} else {
				$output .= '<td class="ivole-histogramCell1">' . __( '5 star', 'customer-reviews-woocommerce' ) . '</td>';
				$output .= '<td class="ivole-histogramCell2"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $five_percent . '%"></div></div></td>';
				$output .= '<td class="ivole-histogramCell3">' . (string)$five_percent . '%</td>';
			}
			$output .= '</tr>';
			$output .= '<tr class="ivole-histogramRow">';
			if( $four > 0 ) {
				$output .= '<td class="ivole-histogramCell1"><a class="ivole-histogram-a" data-rating="4" href="' . esc_url( add_query_arg( $this->ivrating, 4, get_permalink( $product_id ) ) ) . $tab_reviews . '" title="' . __( '4 star', 'customer-reviews-woocommerce' ) . '">' . __( '4 star', 'customer-reviews-woocommerce' ) . '</a></td>';
				$output .= '<td class="ivole-histogramCell2"><a class="ivole-histogram-a" data-rating="4" href="' . esc_url( add_query_arg( $this->ivrating, 4, get_permalink( $product_id ) ) ) . $tab_reviews . '"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $four_percent . '%"></div></div></a></td>';
				$output .= '<td class="ivole-histogramCell3"><a class="ivole-histogram-a" data-rating="4" href="' . esc_url( add_query_arg( $this->ivrating, 4, get_permalink( $product_id ) ) ) . $tab_reviews . '">' . (string)$four_percent . '%</a></td>';
			} else {
				$output .= '<td class="ivole-histogramCell1">' . __( '4 star', 'customer-reviews-woocommerce' ) . '</td>';
				$output .= '<td class="ivole-histogramCell2"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $four_percent . '%"></div></div></td>';
				$output .= '<td class="ivole-histogramCell3">' . (string)$four_percent . '%</td>';
			}
			$output .= '</tr>';
			$output .= '<tr class="ivole-histogramRow">';
			if( $three > 0 ) {
				$output .= '<td class="ivole-histogramCell1"><a class="ivole-histogram-a" data-rating="3" href="' . esc_url( add_query_arg( $this->ivrating, 3, get_permalink( $product_id ) ) ) . $tab_reviews . '" title="' . __( '3 star', 'customer-reviews-woocommerce' ) . '">' . __( '3 star', 'customer-reviews-woocommerce' ) . '</a></td>';
				$output .= '<td class="ivole-histogramCell2"><a class="ivole-histogram-a" data-rating="3" href="' . esc_url( add_query_arg( $this->ivrating, 3, get_permalink( $product_id ) ) ) . $tab_reviews . '"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $three_percent . '%"></div></div></a></td>';
				$output .= '<td class="ivole-histogramCell3"><a class="ivole-histogram-a" data-rating="3" href="' . esc_url( add_query_arg( $this->ivrating, 3, get_permalink( $product_id ) ) ) . $tab_reviews . '">' . (string)$three_percent . '%</a></td>';
			} else {
				$output .= '<td class="ivole-histogramCell1">' . __( '3 star', 'customer-reviews-woocommerce' ) . '</td>';
				$output .= '<td class="ivole-histogramCell2"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $three_percent . '%"></div></div></td>';
				$output .= '<td class="ivole-histogramCell3">' . (string)$three_percent . '%</td>';
			}
			$output .= '</tr>';
			$output .= '<tr class="ivole-histogramRow">';
			if( $two > 0 ) {
				$output .= '<td class="ivole-histogramCell1"><a class="ivole-histogram-a" data-rating="2" href="' . esc_url( add_query_arg( $this->ivrating, 2, get_permalink( $product_id ) ) ) . $tab_reviews . '" title="' . __( '2 star', 'customer-reviews-woocommerce' ) . '">' . __( '2 star', 'customer-reviews-woocommerce' ) . '</a></td>';
				$output .= '<td class="ivole-histogramCell2"><a class="ivole-histogram-a" data-rating="2" href="' . esc_url( add_query_arg( $this->ivrating, 2, get_permalink( $product_id ) ) ) . $tab_reviews . '"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $two_percent . '%"></div></div></a></td>';
				$output .= '<td class="ivole-histogramCell3"><a class="ivole-histogram-a" data-rating="2" href="' . esc_url( add_query_arg( $this->ivrating, 2, get_permalink( $product_id ) ) ) . $tab_reviews . '">' . (string)$two_percent . '%</a></td>';
			} else {
				$output .= '<td class="ivole-histogramCell1">' . __( '2 star', 'customer-reviews-woocommerce' ) . '</td>';
				$output .= '<td class="ivole-histogramCell2"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $two_percent . '%"></div></div></td>';
				$output .= '<td class="ivole-histogramCell3">' . (string)$two_percent . '%</td>';
			}
			$output .= '</tr>';
			$output .= '<tr class="ivole-histogramRow">';
			if( $one > 0 ) {
				$output .= '<td class="ivole-histogramCell1"><a class="ivole-histogram-a" data-rating="1" href="' . esc_url( add_query_arg( $this->ivrating, 1, get_permalink( $product_id ) ) ) . $tab_reviews . '" title="' . __( '1 star', 'customer-reviews-woocommerce' ) . '">' . __( '1 star', 'customer-reviews-woocommerce' ) . '</a></td>';
				$output .= '<td class="ivole-histogramCell2"><a class="ivole-histogram-a" data-rating="1" href="' . esc_url( add_query_arg( $this->ivrating, 1, get_permalink( $product_id ) ) ) . $tab_reviews . '"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $one_percent . '%"></div></div></a></td>';
				$output .= '<td class="ivole-histogramCell3"><a class="ivole-histogram-a" data-rating="1" href="' . esc_url( add_query_arg( $this->ivrating, 1, get_permalink( $product_id ) ) ) . $tab_reviews . '">' . (string)$one_percent . '%</a></td>';
			} else {
				$output .= '<td class="ivole-histogramCell1">' . __( '1 star', 'customer-reviews-woocommerce' ) . '</td>';
				$output .= '<td class="ivole-histogramCell2"><div class="ivole-meter"><div class="ivole-meter-bar" style="width: ' . $one_percent . '%"></div></div></td>';
				$output .= '<td class="ivole-histogramCell3">' . (string)$one_percent . '%</td>';
			}
			$output .= '</tr>';
			$output .= '</tbody>';
			$output .= '</table>';
			$output .= '</div>';
			if( 'yes' !== get_option( 'ivole_reviews_nobranding', 'yes' ) ) {
				$output .= '<div class="cr-credits-div">';
				$output .= 'Powered by <a href="https://wordpress.org/plugins/customer-reviews-woocommerce/" target="_blank" rel="noopener noreferrer">Customer Reviews plugin</a>';
				$output .= '</div>';
			}
			if( get_query_var( $this->ivrating ) ) {
				$rating = intval( get_query_var( $this->ivrating ) );
				if( $rating > 0 && $rating <= 5 ) {
					$filtered_comments = sprintf( esc_html( _n( 'Showing %1$d of %2$d review (%3$d star). ', 'Showing %1$d of %2$d reviews (%3$d star). ', $all, 'customer-reviews-woocommerce'  ) ), $this->count_ratings( $product_id, $rating ), $all, $rating );
					$all_comments = sprintf( esc_html( _n( 'See all %d review', 'See all %d reviews', $all, 'customer-reviews-woocommerce'  ) ), $all );
					$output .= '<div class="cr-count-filtered-reviews">' . $filtered_comments . '<a class="ivole-seeAllReviews" href="' . esc_url( get_permalink( $product_id ) ) . $tab_reviews . '">' . $all_comments . '</a></div>';
				}
			}
			$output .= '</div>';
			echo $output;
		}
	}
	private function count_ratings( $product_id, $rating ) {
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
	public function add_query_var() {
		global $wp;
		$wp->add_query_var( $this->ivrating );
	}
	public function filter_comments2( $comment_args ) {
		global $post;
		if( get_post_type() === 'product' ) {
			if( get_query_var( $this->ivrating ) ) {
				$rating = intval( get_query_var( $this->ivrating ) );
				if( $rating > 0 && $rating <= 5 ) {
					$comment_args['meta_query'][] = array(
						'key' => 'rating',
						'value'   => $rating,
						'compare' => '=',
						'type'    => 'numeric'
					);
					$page = (int) get_query_var( 'cpage' );
					if ( $page ) {
						$comment_args['offset'] = ( $page - 1 ) * $comment_args['number'];
					} elseif ( 'oldest' === get_option( 'default_comments_page' ) ) {
						$comment_args['offset'] = 0;
					} else {
						// If fetching the first page of 'newest', we need a top-level comment count.
						$top_level_query = new WP_Comment_Query();
						$top_level_args  = array(
							'count'   => true,
							'orderby' => false,
							'post_id' => $post->ID,
							'status'  => 'approve',
							'meta_query' => $comment_args['meta_query']
						);

						if ( $comment_args['hierarchical'] ) {
							$top_level_args['parent'] = 0;
						}

						if ( isset( $comment_args['include_unapproved'] ) ) {
							$top_level_args['include_unapproved'] = $comment_args['include_unapproved'];
						}

						$top_level_count = $top_level_query->query( $top_level_args );
						if( isset( $comment_args['number'] ) && $comment_args['number'] > 0 ) {
							$comment_args['offset'] = ( ceil( $top_level_count / $comment_args['number'] ) - 1 ) * $comment_args['number'];
						} else {
							$comment_args['offset'] = 0;
						}
					}
				}
			}
		}
		return $comment_args;
	}
	public function vote_review_registered() {
		if( !check_ajax_referer( 'ivole-review-vote', 'security', false ) ) {
			wp_send_json( array( 'code' => 3 ) );
		}

		$comment_id = intval( $_POST['reviewID'] );
		$upvote = intval( $_POST['upvote'] );
		$registered_upvoters = get_comment_meta( $comment_id, 'ivole_review_reg_upvoters', true );
		$registered_downvoters = get_comment_meta( $comment_id, 'ivole_review_reg_downvoters', true );
		$current_user = get_current_user_id();
		// check if this registered user has already upvoted this review
		if( !empty( $registered_upvoters ) ) {
			$registered_upvoters = maybe_unserialize( $registered_upvoters );
			if( is_array( $registered_upvoters ) ) {
				$registered_upvoters_count = count( $registered_upvoters );
				$index_upvoters = -1;
				for($i = 0; $i < $registered_upvoters_count; $i++ ) {
					if( $current_user === $registered_upvoters[$i] ) {
						if( 0 < $upvote ) {
							// upvote request, exit because this user has already upvoted this review earlier
							wp_send_json( array( 'code' => 1 ) );
						} else {
							// downvote request, remove the upvote
							$index_upvoters = $i;
							break;
						}
					}
				}
				if( 0 <= $index_upvoters ) {
					array_splice( $registered_upvoters, $index_upvoters, 1 );
				}
			} else {
				$registered_upvoters = array();
			}
		} else {
			$registered_upvoters = array();
		}
		// check if this registered user has already downvoted this review
		if( !empty( $registered_downvoters ) ) {
			$registered_downvoters = maybe_unserialize( $registered_downvoters );
			if( is_array( $registered_downvoters ) ) {
				$registered_downvoters_count = count( $registered_downvoters );
				$index_downvoters = -1;
				for($i = 0; $i < $registered_downvoters_count; $i++ ) {
					if( $current_user === $registered_downvoters[$i] ) {
						if( 0 < $upvote ) {
							// upvote request, remove the downvote
							$index_downvoters = $i;
							break;
						} else {
							// downvote request, exit because this user has already downvoted this review earlier
							wp_send_json( array( 'code' => 2 ) );
						}
					}
				}
				if( 0 <= $index_downvoters ) {
					array_splice( $registered_downvoters, $index_downvoters, 1 );
				}
			} else {
				$registered_downvoters = array();
			}
		} else {
			$registered_downvoters = array();
		}

		//update arrays of registered upvoters and downvoters
		if( 0 < $upvote ) {
			$registered_upvoters[] = $current_user;
		} else {
			$registered_downvoters[] = $current_user;
		}

		update_comment_meta( $comment_id, 'ivole_review_reg_upvoters', $registered_upvoters );
		update_comment_meta( $comment_id, 'ivole_review_reg_downvoters', $registered_downvoters );
		$this->send_votes( $comment_id );
		// compatibility with W3 Total Cache plugin
		// clear DB cache to make sure that count of upvotes is immediately updated
		if( function_exists( 'w3tc_dbcache_flush' ) ) {
			w3tc_dbcache_flush();
		}
		wp_send_json( array( 'code' => 0 ) );
	}

	public function vote_review_unregistered() {
		if( !check_ajax_referer( 'ivole-review-vote', 'security', false ) ) {
			wp_send_json( array( 'code' => 3 ) );
		}
		//error_log('vote_review_unregistered, ip:' . $_SERVER['REMOTE_ADDR'] );
		$ip = $_SERVER['REMOTE_ADDR'];
		$comment_id = intval( $_POST['reviewID'] );
		$upvote = intval( $_POST['upvote'] );

		// check (via cookie) if this unregistered user has already upvoted this review
		if( isset( $_COOKIE['ivole_review_upvote'] ) ) {
			$upcomment_ids = json_decode( $_COOKIE['ivole_review_upvote'], true );
			if( is_array( $upcomment_ids ) ) {
				$upcomment_ids_count = count( $upcomment_ids );
				$index_upvoters = -1;
				for( $i = 0; $i < $upcomment_ids_count; $i++ ) {
					if( $comment_id === $upcomment_ids[$i] ) {
						if( 0 < $upvote ) {
							// upvote request, exit because this user has already upvoted this review earlier
							wp_send_json( array( 'code' => 1 ) );
						} else {
							// downvote request, remove the upvote
							$index_upvoters = $i;
							break;
						}
					}
				}
				if( 0 <= $index_upvoters ) {
					array_splice( $upcomment_ids, $index_upvoters, 1 );
				}
			} else {
				$upcomment_ids = array();
			}
		} else {
			$upcomment_ids = array();
		}

		// check (via cookie) if this unregistered user has already downvoted this review
		if( isset( $_COOKIE['ivole_review_downvote'] ) ) {
			$downcomment_ids = json_decode( $_COOKIE['ivole_review_downvote'], true );
			if( is_array( $downcomment_ids ) ) {
				$downcomment_ids_count = count( $downcomment_ids );
				$index_downvoters = -1;
				for( $i = 0; $i < $downcomment_ids_count; $i++ ) {
					if( $comment_id === $downcomment_ids[$i] ) {
						if( 0 < $upvote ) {
							// upvote request, remove the downvote
							$index_downvoters = $i;
							break;
						} else {
							// downvote request, exit because this user has already downvoted this review earlier
							wp_send_json( array( 'code' => 2 ) );
						}
					}
				}
				if( 0 <= $index_downvoters ) {
					array_splice( $downcomment_ids, $index_downvoters, 1 );
				}
			} else {
				$downcomment_ids = array();
			}
		} else {
			$downcomment_ids = array();
		}

		$unregistered_upvoters = get_comment_meta( $comment_id, 'ivole_review_unreg_upvoters', true );
		$unregistered_downvoters = get_comment_meta( $comment_id, 'ivole_review_unreg_downvoters', true );

		// check if this unregistered user has already upvoted this review
		if( !empty( $unregistered_upvoters ) ) {
			$unregistered_upvoters = maybe_unserialize( $unregistered_upvoters );
			if( is_array( $unregistered_upvoters ) ) {
				$unregistered_upvoters_count = count( $unregistered_upvoters );
				$index_upvoters = -1;
				for($i = 0; $i < $unregistered_upvoters_count; $i++ ) {
					if( $ip === $unregistered_upvoters[$i] ) {
						if( 0 < $upvote ) {
							// upvote request, exit because this user has already upvoted this review earlier
							wp_send_json( array( 'code' => 1 ) );
						} else {
							// downvote request, remove the upvote
							$index_upvoters = $i;
							break;
						}
					}
				}
				if( 0 <= $index_upvoters ) {
					array_splice( $unregistered_upvoters, $index_upvoters, 1 );
				}
			} else {
				$unregistered_upvoters = array();
			}
		} else {
			$unregistered_upvoters = array();
		}

		// check if this unregistered user has already downvoted this review
		if( !empty( $unregistered_downvoters ) ) {
			$unregistered_downvoters = maybe_unserialize( $unregistered_downvoters );
			if( is_array( $unregistered_downvoters ) ) {
				$unregistered_downvoters_count = count( $unregistered_downvoters );
				$index_downvoters = -1;
				for($i = 0; $i < $unregistered_downvoters_count; $i++ ) {
					if( $ip === $unregistered_downvoters[$i] ) {
						if( 0 < $upvote ) {
							// upvote request, remove the downvote
							$index_downvoters = $i;
							break;
						} else {
							// downvote request, exit because this user has already downvoted this review earlier
							wp_send_json( array( 'code' => 2 ) );
						}
					}
				}
				if( 0 <= $index_downvoters ) {
					array_splice( $unregistered_downvoters, $index_downvoters, 1 );
				}
			} else {
				$unregistered_downvoters = array();
			}
		} else {
			$unregistered_downvoters = array();
		}

		//update cookie arrays of unregistered upvoters and downvoters
		if( 0 < $upvote ) {
			$upcomment_ids[] = $comment_id;
			$unregistered_upvoters[] = $ip;
		} else {
			$downcomment_ids[] = $comment_id;
			$unregistered_downvoters[] = $ip;
		}
		setcookie( 'ivole_review_upvote', json_encode( $upcomment_ids ), time() + 365*24*60*60, COOKIEPATH, COOKIE_DOMAIN );
		setcookie( 'ivole_review_downvote', json_encode( $downcomment_ids ), time() + 365*24*60*60, COOKIEPATH, COOKIE_DOMAIN );
		update_comment_meta( $comment_id, 'ivole_review_unreg_upvoters', $unregistered_upvoters );
		update_comment_meta( $comment_id, 'ivole_review_unreg_downvoters', $unregistered_downvoters );
		$this->send_votes( $comment_id );
		// compatibility with W3 Total Cache plugin
		// clear DB cache to make sure that count of upvotes is immediately updated
		if( function_exists( 'w3tc_dbcache_flush' ) ) {
			w3tc_dbcache_flush();
		}
		wp_send_json( array( 'code' => 0 ) );
	}
	public function get_votes( $comment_id ) {
		$r_upvotes = 0;
		$r_downvotes = 0;
		$u_upvotes = 0;
		$u_downvotes = 0;
		$registered_upvoters = get_comment_meta( $comment_id, 'ivole_review_reg_upvoters', true );
		$registered_downvoters = get_comment_meta( $comment_id, 'ivole_review_reg_downvoters', true );
		$unregistered_upvoters = get_comment_meta( $comment_id, 'ivole_review_unreg_upvoters', true );
		$unregistered_downvoters = get_comment_meta( $comment_id, 'ivole_review_unreg_downvoters', true );

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

		$votes = array(
			'upvotes' => $r_upvotes + $u_upvotes,
			'downvotes' => $r_downvotes + $u_downvotes,
			'total' => $r_upvotes + $r_downvotes + $u_upvotes + $u_downvotes
		);
		return $votes;
	}
	public function send_votes( $comment_id ) {
		$comment = get_comment( $comment_id );
		if( $comment ) {
			$votes = $this->get_votes( $comment_id );
			update_comment_meta( $comment_id, 'ivole_review_votes', $votes['upvotes'] - $votes['downvotes'] );
			$product_id = $comment->comment_post_ID;
			//clear WP Super Cache after voting
			if( function_exists( 'wpsc_delete_post_cache' ) ) {
				wpsc_delete_post_cache( $product_id );
			}
			//clear W3TC after voting
			if( function_exists( 'w3tc_flush_post' ) ) {
				w3tc_flush_post( $product_id );
			}
			if( Ivole::is_curl_installed() ) {
				$order_id = get_comment_meta( $comment_id, 'ivole_order', true );
				if( '' !== $order_id ) {
					$secret_key = get_post_meta( $order_id, 'ivole_secret_key', true );
					if( '' !== $secret_key ) {
						$data = array(
							'token' => '164592f60fbf658711d47b2f55a1bbba',
							'secretKey' => $secret_key,
							'shop' => array( 'domain' => Ivole_Email::get_blogurl(),
							'orderId' => $order_id,
							'productId' => $product_id ),
							'upvotes' => $votes['upvotes'],
							'downvotes' => $votes['total'] - $votes['upvotes']
						);
						$api_url = 'https://z4jhozi8lc.execute-api.us-east-1.amazonaws.com/v1/review-vote';
						$data_string = json_encode( $data );
						$ch = curl_init();
						curl_setopt( $ch, CURLOPT_URL, $api_url );
						curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
						curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_string );
						curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
							'Content-Type: application/json',
							'Content-Length: ' . strlen( $data_string ) )
						);
						$result = curl_exec( $ch );
					}
				}
			}
		}
	}
	public function compatibility_reviews( $located, $template_name, $args, $template_path, $default_path ) {
		if( 'single-product/review.php' === $template_name ) {
			$replacement_path = plugin_dir_path( __FILE__ ) . 'templates/review-compat.php';
			if( is_file( $replacement_path ) ) {
				$located = $replacement_path;
				//error_log( print_r( $replacement_path, true ) );
			}
		}
		return $located;
	}
	public function display_verified_badge( $comment ) {
		if( 0 === intval( $comment->comment_parent ) ) {
			$output = '';
			// trust badges are enabled, so check if a badge should be shown for the review
			if( 'yes' === $this->ivole_reviews_verified ) {
				$product_id = $comment->comment_post_ID;
				$order_id = get_comment_meta( $comment->comment_ID, 'ivole_order', true );
				// WPML integration
				if ( has_filter( 'wpml_object_id' ) ) {
					$wpml_def_language = apply_filters( 'wpml_default_language', null );
					$original_product_id = apply_filters( 'wpml_object_id', $product_id, 'product', true, $wpml_def_language );
					$product_id = $original_product_id;
				}
				if( '' !== $order_id ) {
					// prepare language suffix to insert into cusrev.com link
					$l_suffix = '';
					$site_lang = '';
					if( 'en' !== $this->lang ) {
						$l_suffix = '-' . $this->lang;
						$site_lang = $this->lang . '/';
					}
					//
					$output = '<img src="' . untrailingslashit( plugin_dir_url( __FILE__ ) );
					$output .= '/img/shield-20.png" alt="' . __( 'Verified review', 'customer-reviews-woocommerce' ) . '" class="ivole-verified-badge-icon">';
					$output .= '<span class="ivole-verified-badge-text">';
					$output .= __( 'Verified review', 'customer-reviews-woocommerce' );
					// URL is different for product reviews and shop reviews. Need to check if this is a shop review.
					$shop_page_id = wc_get_page_id( 'shop' );
					if( intval( $shop_page_id ) === intval( $product_id ) ) {
						$output .= ' - <a href="https://www.cusrev.com/' . $site_lang . 'reviews/' . get_option( 'ivole_reviews_verified_page', Ivole_Email::get_blogdomain() ) . '/s/r-' . $order_id;
					} else {
						$output .= ' - <a href="https://www.cusrev.com/' . $site_lang . 'reviews/' . get_option( 'ivole_reviews_verified_page', Ivole_Email::get_blogdomain() ) . '/p/p-' . $product_id . '/r-' . $order_id;
					}
					$output .= '" title="" target="_blank" rel="nofollow noopener">';
					$output .= __( 'view original', 'customer-reviews-woocommerce' ) . '</a>';
					$output .= '<img src="' . untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/img/external-link.png" alt="' . __( 'External link', 'customer-reviews-woocommerce' ) . '" class="ivole-verified-badge-ext-icon"></span>';
				}
			}
			// geolocation is enabled, so check if country/region should be shown for the review
			if( 'yes' === $this->ivole_form_geolocation ) {
				$country = get_comment_meta( $comment->comment_ID, 'ivole_country', true );
				if( is_array( $country ) && 2 === count( $country  ) ) {
					$country_string = '';
					if( isset( $country['code'] ) ) {
						if( strlen( $output ) > 0 ) {
							$output .= '<span class="ivole-review-country-space">&emsp;|&emsp;</span>';
						}
						$output .= '<img src="https://www.cusrev.com/flags/' . $country['code'] . '.svg" class="ivole-review-country-icon" alt="' . $country['code'] . '">';
						if( isset( $country['desc'] ) ) {
							$output .= '<span class="ivole-review-country-text">' . $country['desc'] . '</span>';
						}
					}
				}
			}
			// if there is something to print, print it
			if( strlen( $output ) > 0 ) {
				echo '<p class="ivole-verified-badge">' . $output . '</p>';
			}
		}
	}

	public function display_featured( $comment ) {
		if( 0 === intval( $comment->comment_parent ) ) {
			if( 0 < $comment->comment_karma ) {
				// display 'featured' badge
				$output = __( 'Featured Review', 'customer-reviews-woocommerce' );
				echo '<p class="cr-featured-badge"><span>' . $output . '</span></p>';
			}
		}
	}

	public function display_custom_questions( $comment ) {
		if( 0 === intval( $comment->comment_parent ) ) {
			$custom_questions = new CR_Custom_Questions();
			$custom_questions->read_questions( $comment->comment_ID );
			$custom_questions->output_questions( true );
		}
	}

	public function cusrev_review_meta( $comment ) {
		$template = wc_locate_template(
			'review-meta.php',
			'customer-reviews-woocommerce',
			'templates/'
		);
		include( $template );
		remove_action( 'woocommerce_review_meta', 'woocommerce_review_display_meta', 10 );
	}

	public function show_sorting_ui( $product_id, $new_reviews_allowed ) {
		$nonce_sort = wp_create_nonce( "cr_product_reviews_sort_" . $product_id );
		?>
		<div class="cr-ajax-reviews-sort-div">
			<select id="cr-ajax-reviews-sort" data-nonce="<?php echo $nonce_sort; ?>">
				<option value="recent" <?php if( 'recent' === CR_Ajax_Reviews::get_sort() ) { echo 'selected="selected"'; } ?>>
					<?php echo __( 'Most Recent', 'customer-reviews-woocommerce' ); ?>
				</option>
				<option value="helpful" <?php if( 'helpful' === CR_Ajax_Reviews::get_sort() ) { echo 'selected="selected"'; } ?>>
					<?php echo __( 'Most Helpful', 'customer-reviews-woocommerce' ); ?>
				</option>
			</select>
			<?php if( $new_reviews_allowed ) : ?>
				<button class="cr-ajax-reviews-add-review" type="button"><?php echo __( 'Add a review', 'woocommerce' ); ?></button>
			<?php endif; ?>
		</div>
		<?php
	}

	public function show_sorting_ui_2( $product_id, $new_reviews_allowed ) {
		if( !$new_reviews_allowed ) {
			return;
		}
		?>
		<div class="cr-ajax-reviews-sort-div">
			<button class="cr-ajax-reviews-add-review" type="button"><?php echo __( 'Add a review', 'woocommerce' ); ?></button>
		</div>
		<?php
	}

	public function display_review_images_top( $reviews ) {
		$pics = $reviews[1];
		$count = count( $pics );
		$pics_prepared = array();
		for( $i = 0; $i < $count; $i ++) {
			if( $pics[$i][0]['type'] === 'url' ) {
				$pics_prepared[] = array( $pics[$i][0]['value'], $pics[$i][1] );
			} elseif( $pics[$i][0]['type'] === 'attachment_id' ) {
				//$attUrl = wp_get_attachment_url( $pics[$i][0]['value'] );
				$attUrl = wp_get_attachment_image_url( $pics[$i][0]['value'], apply_filters( 'cr_topreviews_image_size', 'large' ) );
				if( $attUrl ) {
					$pics_prepared[] = array( $attUrl, $pics[$i][1] );
				}
			} elseif( $pics[$i][0]['type'] === 'video' ) {
				// to do - video handling
			}
		}
		$count = count( $pics_prepared );
		if( $count > 0 ) :
			wp_enqueue_script( 'cr-reviews-slider' );
			wp_enqueue_style( 'ivole-reviews-grid' );
			?>
			<div class="cr-ajax-reviews-cus-images-div">
				<p class="cr-ajax-reviews-cus-images-title"><?php echo __( 'Customer Images', 'customer-reviews-woocommerce' ); ?></p>
				<div class="cr-ajax-reviews-cus-images-div2">
					<?php
					// show the first five or less pictures only
					$max_count_top = apply_filters( 'cr_topreviews_max_count', 5 );
					$count_top = $count > $max_count_top - 1 ? $max_count_top : $count;
					for( $i = 0; $i < $count_top; $i ++) {
						$output = '';
						$output .= '<div class="iv-comment-image-top">';
						$output .= '<img data-slide="' . $i . '" src="' .
						$pics_prepared[$i][0] . '" alt="' . sprintf( __( 'Image #%1$d from ', 'customer-reviews-woocommerce' ), $i + 1 ) .
						$pics_prepared[$i][1]->comment_author . '" loading="lazy">';
						$output .= '</div>';
						echo $output;
					}
					$nav_slides_to_show = $count > 2 ? 3 : $count;
					$main_slider_settings = array(
						'slidesToShow' => 1,
						'slidesToScroll' => 1,
						'arrows' => false,
						'fade' => true,
						'asNavFor' => '.cr-ajax-reviews-cus-images-slider-nav'
					);
					$nav_slider_settings = array(
						'slidesToShow' => $nav_slides_to_show,
						'slidesToScroll' => 1,
						'centerMode' => true,
						'dots' => true,
						'focusOnSelect' => true,
						'asNavFor' => '.cr-ajax-reviews-cus-images-slider-main',
						'respondTo' => 'min',
						'responsive' => array(
							array(
								'breakpoint' => 600,
								'settings' => array(
									'centerMode' => true,
									'centerPadding' => '30px',
									'slidesToShow' => $nav_slides_to_show
								)
							),
							array(
								'breakpoint' => 415,
								'settings' => array(
									'centerMode' => true,
									'centerPadding' => '35px',
									'slidesToShow' => $nav_slides_to_show
								)
							),
							array(
								'breakpoint' => 320,
								'settings' => array(
									'centerMode' => true,
									'centerPadding' => '40px',
									'slidesToShow' => $nav_slides_to_show
								)
							)
						)
					);
					?>
				</div>
			</div>
			<div class="cr-ajax-reviews-cus-images-modal-cont">
				<div class="cr-ajax-reviews-cus-images-modal">
					<div class="cr-ajax-reviews-cus-images-hdr">
						<button class="cr-ajax-reviews-cus-images-close">
							<span class="dashicons dashicons-no"></span>
						</button>
					</div>
					<div class="cr-ajax-reviews-cus-images-slider-main cr-reviews-slider" data-slick='<?php echo wp_json_encode( $main_slider_settings ); ?>'>
						<?php
						$voting_enabled = 'yes' === get_option( 'ivole_reviews_voting', 'no' ) ? true : false;
						for( $i = 0; $i < $count; $i ++) {
							$ratingr = intval( get_comment_meta( $pics_prepared[$i][1]->comment_ID, 'rating', true ) );
							$output = '';
							$output .= '<div class="cr-ajax-reviews-slide-main"><div class="cr-ajax-reviews-slide-main-flex">';
							$output .= '<img src="' .
							$pics_prepared[$i][0] . '" alt="' . sprintf( __( 'Image #%1$d from ', 'customer-reviews-woocommerce' ), $i + 1 ) .
							$pics_prepared[$i][1]->comment_author . '" loading="lazy">';
							$output .= '<div class="cr-ajax-reviews-slide-main-comment">';
							$output .= wc_get_rating_html( $ratingr );
							$output .= '<p><strong class="woocommerce-review__author">' . esc_html( $pics_prepared[$i][1]->comment_author ) .'</strong></p>';
							$output .= '<time class="woocommerce-review__published-date" datetime="' . esc_attr( mysql2date( 'c', $pics_prepared[$i][1]->comment_date ) ) . '">' . esc_html( mysql2date( wc_date_format(), $pics_prepared[$i][1]->comment_date ) ) . '</time>';
							$output .= '<p>' . get_comment_text( $pics_prepared[$i][1]->comment_ID ) . '</p>';
							if( $voting_enabled ) {
								ob_start();
								$this->display_voting_buttons( $pics_prepared[$i][1] );
								$vote_output = ob_get_contents();
								ob_end_clean();
								$output .= "<div class='cr-vote'>" . $vote_output . "</div>";
							}
							$output .= '</div></div></div>';
							echo $output;
						}
						?>
					</div>
					<div class="cr-ajax-reviews-cus-images-slider-nav cr-reviews-slider" data-slick='<?php echo wp_json_encode( $nav_slider_settings ); ?>'>
						<?php
						for( $i = 0; $i < $count; $i ++) {
							$output = '';
							$output .= '<div class="cr-ajax-reviews-slide-nav">';
							$output .= '<img src="' .
							$pics_prepared[$i][0] . '" alt="' . sprintf( __( 'Image #%1$d from ', 'customer-reviews-woocommerce' ), $i + 1 ) .
							$pics_prepared[$i][1]->comment_author . '">';
							$output .= '</div>';
							echo $output;
						}
						?>
					</div>
				</div>
			</div>
			<?php
		endif;
	}

	public function woocommerce_photoswipe() {
		if( is_product() ) {
			wc_get_template( 'single-product/photoswipe.php' );
		}
	}

	private static function is_captcha_enabled() {
		return 'yes' === get_option( 'ivole_enable_captcha', 'no' );
	}

	private static function captcha_site_key() {
		return get_option( 'ivole_captcha_site_key', '' );
	}

	public function new_ajax_upload() {
		$return = array(
			'code' => 100,
			'message' => ''
		);
		if( check_ajax_referer( 'cr-upload-images-frontend', 'cr_nonce', false ) ) {
			// check captcha
			if( self::is_captcha_enabled() ) {
				$captcha_is_wrong = true;
				if( isset( $_POST['cr_captcha'] ) && $_POST['cr_captcha'] ) {
					if( $this->ping_captcha( strval( $_POST['cr_captcha'] ) ) ) {
						$captcha_is_wrong = false;
					}
				}
				if( $captcha_is_wrong ) {
					$return['code'] = 504;
					$return['message'] = __( 'Error: please solve the CAPTCHA before uploading files', 'customer-reviews-woocommerce' );
					wp_send_json( $return );
					return;
				}
			}
			if( isset( $_FILES ) && is_array( $_FILES ) && 0 < count( $_FILES ) ) {
				// check the file size
				if ( $this->limit_file_size < $_FILES['cr_file']['size'] ) {
					$return['code'] = 501;
					$return['message'] = __( 'Error: the file(s) is too large', 'customer-reviews-woocommerce' );
					wp_send_json( $return );
					return;
				}
				// check the file type
				$file_name_parts = explode( '.', $_FILES['cr_file']['name'] );
				$file_ext = $file_name_parts[ count( $file_name_parts ) - 1 ];
				if( ! $this->is_valid_file_type( $file_ext ) ) {
					$return['code'] = 502;
					$return['message'] = __( 'Error: accepted file types are PNG, JPG, JPEG, GIF', 'customer-reviews-woocommerce' );
					wp_send_json( $return );
					return;
				}
				// upload the file
				$post_id = $_POST['cr_postid'] ? $_POST['cr_postid'] : 0;
				$attachmentId = media_handle_upload( 'cr_file', $post_id );
				if( !is_wp_error( $attachmentId ) ) {
					$upload_key = bin2hex( openssl_random_pseudo_bytes( 10 ) );
					if( false !== update_post_meta( $attachmentId, 'cr-upload-temp-key', $upload_key ) ) {
						$return['attachment'] = array(
							'id' => $attachmentId,
							'key' => $upload_key,
							'nonce' => wp_create_nonce( 'cr-upload-images-delete' )
						);
					} else {
						$return['code'] = 503;
						$return['message'] = $_FILES['cr_file']['name'] . ': could not update the upload key.';
					}
				} else {
					$return['code'] = $attachmentId->get_error_code();
					$return['message'] = $attachmentId->get_error_message();
				}
				$return['code'] = 200;
				$return['message'] = 'OK';
			}
		} else {
			$return['code'] = 500;
			$return['message'] = 'Error: nonce validation failed. Please refresh the page and try again.';
		}
		wp_send_json( $return );
	}

	public function new_ajax_delete() {
		$return = array(
			'code' => 100,
			'message' => '',
			'class' => ''
		);
		if( check_ajax_referer( 'cr-upload-images-delete', 'cr_nonce', false ) ) {
			if( isset( $_POST['image'] ) && $_POST['image'] ) {
				$image_decoded = json_decode( stripslashes( $_POST['image'] ), true );
				if( $image_decoded && is_array( $image_decoded ) ) {
					if( isset( $image_decoded["id"] ) && $image_decoded["id"] ) {
						if( isset( $image_decoded["key"] ) && $image_decoded["key"] ) {
							$attachmentId = intval( $image_decoded["id"] );
							if( 'attachment' === get_post_type( $attachmentId ) ) {
								if( $image_decoded["key"] === get_post_meta( $attachmentId, 'cr-upload-temp-key', true ) ) {
									if( wp_delete_attachment( $attachmentId, true ) ) {
										$return['code'] = 200;
										$return['message'] = 'OK';
										$return['class'] = $_POST['class'];
									} else {
										$return['code'] = 507;
										$return['message'] = 'Error: could not delete the image.';
									}
								} else {
									$return['code'] = 506;
									$return['message'] = 'Error: meta key does not match.';
								}
							} else {
								$return['code'] = 505;
								$return['message'] = 'Error: id does not belong to an attachment.';
							}
						} else {
							$return['code'] = 504;
							$return['message'] = 'Error: image key is not set.';
						}
					} else {
						$return['code'] = 503;
						$return['message'] = 'Error: image id is not set.';
					}
				} else {
					$return['code'] = 502;
					$return['message'] = 'Error: JSON decoding problem.';
				}
			} else {
				$return['code'] = 501;
				$return['message'] = 'Error: no image to delete.';
			}
		} else {
			$return['code'] = 500;
			$return['message'] = 'Error: nonce validation failed.';
		}
		wp_send_json( $return );
	}
}

endif;
