<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CR_Tags_Admin_Menu' ) ):

	require_once 'class-cr-tags-list-table.php';

	class CR_Tags_Admin_Menu {
		/**
		* @var string The slug identifying this menu
		*/
		protected $menu_slug;
		private $tags_table;
		/**
		* Constructor
		*
		* @since 3.137
		*/
		public function __construct() {
			$this->menu_slug = 'cr-tags';
			add_action( 'admin_menu', array( $this, 'register_tags_menu' ), 11 );
			add_action( 'add_meta_boxes', array( $this, 'add_tags_meta_box' ), 10, 2 );
			add_action( 'admin_enqueue_scripts', array( $this, 'include_css_js' ) );
			add_action( 'edit_comment', array( $this, 'save_tags' ), 10, 2 );
			add_action( 'wp_ajax_add-cr-tag', array( $this, 'wp_ajax_add_cr_tag' ) );
		}

		/**
		* Register the Tags submenu
		*
		* @since 3.137
		*/
		public function register_tags_menu() {
			add_submenu_page(
				'cr-reviews',
				__( 'Review Tagging', 'customer-reviews-woocommerce' ),
				__( 'Review Tagging', 'customer-reviews-woocommerce' ),
				'manage_options',
				$this->menu_slug,
				array( $this, 'display_tags_page' )
			);
		}

		public function add_tags_meta_box( $post_type, $comment ) {
			if ( 'comment' === $post_type ) {
				$rating = get_comment_meta( $comment->comment_ID, 'rating', true );

				if($rating) {
					add_meta_box(
						'cr_tags_meta_box',
						__( 'Tags', 'customer-reviews-woocommerce' ),
						array($this, 'render_meta_box'),
						$post_type,
						'normal',
						'default'
					);
				}
			}
		}

		/**
		* Render Meta Box
		*
		* @since 3.137
		*
		* @param WP_Comment $comment
		*/
		public function render_meta_box( $comment ) {

			$terms = get_terms( array(
				'taxonomy' => 'cr_tag',
				'hide_empty' => false
			));

			$review_tags = wp_get_object_terms($comment->comment_ID, 'cr_tag');

			$tag_ids = array_map(function($item){
				return $item->term_id;
			}, $review_tags);
			?>
			<div class="cr-tags">
				<select class="cr_tags" multiple="multiple" name="cr_tags[]">
					<?php foreach($terms as $term) : ?>
						<option value="<?php echo $term->slug;?>"<?php if(in_array($term->term_id, $tag_ids)) echo ' selected="selected"'; ?>><?php echo $term->name; ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<?php
		}

		public function save_tags($comment_ID){
			$terms = isset( $_POST['cr_tags'] ) ? (array) $_POST['cr_tags'] : array();

			$res = wp_set_object_terms( $comment_ID, $terms, 'cr_tag' );
		}

		public function include_css_js( $hook ) {
			if( $hook === "comment.php" ) {
				wp_enqueue_style( 'ivole_select2_admin_css', plugins_url( 'css/select2.min.css', dirname( dirname( __FILE__ ) ) ) );
				wp_enqueue_script( 'ivole_select2_admin_js', plugins_url( 'js/select2.min.js', dirname( dirname( __FILE__ ) ) ) );
				wp_enqueue_script( 'cr-admin-tags', plugins_url( 'js/admin-tags.js', dirname( dirname( __FILE__ ) ) ) );
			}
		}

		public function display_tags_page() {
			$this->tags_table = new CR_Tags_List_Table( [ 'screen' => get_current_screen() ] );
			$wp_list_table = $this->tags_table;
			$cr_tags_menu_slug = $this->menu_slug;
			require_once 'cr-tags-page.php';
		}

		public function wp_ajax_add_cr_tag() {
			check_ajax_referer( 'add-tag', '_wpnonce_add-tag' );
			$taxonomy = ! empty( $_POST['taxonomy'] ) ? $_POST['taxonomy'] : 'post_tag';
			$tax      = get_taxonomy( $taxonomy );

			if ( ! current_user_can( $tax->cap->edit_terms ) ) {
				wp_die( -1 );
			}

			$x = new WP_Ajax_Response();

			$tag = wp_insert_term( $_POST['tag-name'], $taxonomy, $_POST );

			if ( $tag && ! is_wp_error( $tag ) ) {
				$tag = get_term( $tag['term_id'], $taxonomy );
			}

			if ( ! $tag || is_wp_error( $tag ) ) {
				$message = __( 'An error has occurred. Please reload the page and try again.', 'customer-reviews-woocommerce' );

				if ( is_wp_error( $tag ) && $tag->get_error_message() ) {
					$message = $tag->get_error_message();
				}

				$x->add(
					array(
						'what' => 'taxonomy',
						'data' => new WP_Error( 'error', $message ),
					)
				);
				$x->send();
			}

			$wp_list_table = new CR_Tags_List_Table( array( 'screen' => $_POST['screen'] ) );

			$level     = 0;
			$noparents = '';

			if ( is_taxonomy_hierarchical( $taxonomy ) ) {
				$level = count( get_ancestors( $tag->term_id, $taxonomy, 'taxonomy' ) );
				ob_start();
				$wp_list_table->single_row( $tag, $level );
				$noparents = ob_get_clean();
			}

			ob_start();
			$wp_list_table->single_row( $tag );
			$parents = ob_get_clean();

			$x->add(
				array(
					'what'         => 'taxonomy',
					'supplemental' => compact( 'parents', 'noparents' ),
				)
			);

			$x->add(
				array(
					'what'         => 'term',
					'position'     => $level,
					'supplemental' => (array) $tag,
				)
			);

			$x->send();
		}

	}

endif;
