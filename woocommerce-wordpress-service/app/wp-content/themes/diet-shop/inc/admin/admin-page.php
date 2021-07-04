<?php
/**
 * Futurio admin notify
 *
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Diet_Shop_Notify_Admin' ) ) :

	/**
	 * The Futurio admin notify
	 */
	class Diet_Shop_Notify_Admin {
		
		/**
		* The single instance of the class
		*
		* @var ATA_WC_Variation_Swatches_Admin
		*/
		protected $theme_name;	
		/**
		* The single instance of the class
		*
		* @var ATA_WC_Variation_Swatches_Admin
		*/
		protected $pro_url;	
		/**
		 * Setup class.
		 *
		 */
		public function __construct() {
			$this->theme_name =  apply_filters( 'diet_shop_theme_name', 'Diet-Shop ');
			$this->pro_url =  apply_filters( 'diet_shop_pro_url', 'https://athemeart.com/downloads/dietshop-wordpress-gym-theme/');
			
			add_action( 'admin_menu', array( $this, 'admin_menu',5 ) );
			
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			
			add_action( 'admin_notices', array( $this, 'admin_notices' ), 99 );
			
			add_action( 'wp_ajax_diet_shop_dismiss_notice', array( $this, 'dismiss_nux' ) );
			
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action('after_switch_theme', array( $this, 'diet_shop_setup_options' ) );
		}
		public function diet_shop_setup_options(){
			
			set_theme_mod( 'diet_shop_admin_notice_dismissed', false );
		}
		/**
		 * Enqueue scripts.
		 *
		 */
		public function enqueue_scripts() {
			global $wp_customize;

			if ( isset( $wp_customize ) ) {
				return;
			}
			
			wp_enqueue_style( 'diet-shop-admin', get_template_directory_uri() . '/inc/admin/admin.css', '', '1' );

			wp_enqueue_script( 'diet-shop-admin', get_template_directory_uri() . '/inc/admin/admin.js', array( 'jquery', 'updates' ), '1', 'all' );

			$diet_shop_notify = array(
				'nonce' => wp_create_nonce( 'diet_shop_notice_dismiss' )
			);

			wp_localize_script( 'diet-shop-admin', 'diet_shop_nux', $diet_shop_notify );
		}

		/**
		 * Output admin notices.
		 *
		 */
		public function admin_notices() {
			global $pagenow;
			
			
			if ( ( 'themes.php' != $pagenow ) || get_theme_mod( 'diet_shop_admin_notice_dismissed' ) ) {
				return;
			}
			?>

			<div class="notice notice-info sf-notice-nux is-dismissible">
				
				<?php if (current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) ) : ?>
				<div class="dp-notice-content">
					
                    <p><?php echo esc_html__( 'Thank you for choosing Diet-Shop Theme! To take full advantage of all the features this theme has to offer number of plugins, please install and activate all plugins.', 'diet-shop' ); ?></p>
                    
                    <a href="<?php echo esc_url( admin_url( 'themes.php?page=welcome' ) ); ?>">
                    <?php esc_html_e( 'Getting Started', 'diet-shop' ); ?>
                    </a>|
                    <a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>"><?php esc_html_e( 'Begin installing plugins', 'diet-shop' ); ?></a>
                   
				</div>
                
                <?php endif; ?>
			</div>
			<?php
		}

		/**
		 * AJAX dismiss notice.
		 *
		 * @since 2.2.0
		 */
		public function dismiss_nux() {
			$nonce = !empty( $_POST[ 'nonce' ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'nonce' ] ) ) : false;

			if ( !$nonce || !wp_verify_nonce( $nonce, 'diet_shop_notice_dismiss' ) || !current_user_can( 'manage_options' ) ) {
				die();
			}
			if ( isset( $_POST['action'] ) &&  $_POST['action'] != 'diet_shop_dismiss_notice' ) {
				die();
			}
			set_theme_mod( 'diet_shop_admin_notice_dismissed', true );
		}
		
		
		
		
	
		
	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		
		$page = add_theme_page( esc_attr__( 'Getting Started', 'diet-shop' ) , 
		esc_attr__( 'Getting Started', 'diet-shop' ), 
		'activate_plugins', 
		'welcome', array( $this, 'welcome_screen' ) );
		
	}
	
	/**
	 * Welcome screen page.
	 */
	public function welcome_screen() {
	?>
    <div class="bcf-header">
        <h1><?php echo esc_html( $this->theme_name );?></h1>
        <a class="bcf-upgrade" target="_blank" href="<?php echo esc_url( $this->pro_url );?>">
        	<?php esc_html_e( ' Upgrade Now ', 'diet-shop' );?>
        </a>
        <div class="clearfix"></div>
    </div>
    <div class="bcf-row-container">
    	<div class="bcf-row">
        	<div class="bcf-col-3">
                <div class="bcf-box">
                	<div class="bcf-box-top"><?php echo esc_html__('Theme Customizer', 'diet-shop');?></div>
                   
                    <div class="bcf-box-content">
                    	<p><?php echo esc_html__('All Theme Options are available via Customize screen.', 'diet-shop');?></p>
                         <p> <a href="<?php echo esc_url( admin_url( 'customize.php' ) );?>" class="button action-btn"> <?php echo  esc_html__( 'Customize', 'diet-shop' );?> </a> </p>
                    </div>
                </div>
            </div>
            <div class="bcf-col-3">
                <div class="bcf-box">
                	<div class="bcf-box-top"><?php echo esc_html__('Ready to import sites', 'diet-shop');?></div>
                
                    <div class="bcf-box-content">
                    
                    	<p><?php echo esc_html__('Import your favorite site with one click and start your project in style!', 'diet-shop');?></p>
                        
                        
                        <?php if ( is_plugin_active( 'athemeart-theme-helper/athemeart-theme-helper.php' ) ) : ?>
                        
                         <p> <a href="<?php echo esc_url( admin_url( 'themes.php?page=pt-one-click-demo-import') );?>" class="button action-btn"> <?php echo  esc_html__( 'See Library', 'diet-shop' );?> </a> </p>
                         
                        <?php else : ?>
                        
                        
                        <a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) );?>" class="button action-btn"> <?php echo  esc_html__( 'Begin installing plugins', 'diet-shop' );?> </a> 
                        
                        <?php endif;?>
                        
                        
                    </div>
                </div>
            </div>
            
                        
            <div class="bcf-col-3">
                <div class="bcf-box">
                	<div class="bcf-box-top"><?php echo esc_html__('Got theme support question?', 'diet-shop');?></div>
                   
                    <div class="bcf-box-content">
                         
                      <p><?php esc_html_e( 'We provide easy to follow guidelines, Documentation to help you get your site up and running..', 'diet-shop' ) ?></p>
						<p><a target="_blank" href="<?php echo esc_url( 'https://athemeart.com/support/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Support', 'diet-shop' ); ?></a></p>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
       
        <div class="bcf-row">
        
       		<div class="bcf-col-3" style="width:62%;">
                <div class="bcf-box">
                	<div class="bcf-box-top"><?php echo esc_html__( 'Changelog', 'diet-shop' );?></div>
                  
                    <div class="bcf-box-content">
                          <code class="cd-box-content cd-modules">
                          <?php
                          global $wp_filesystem;
                          $changelog_file = apply_filters( 'athemeart_changelog_file', get_template_directory() . '/readme.txt' );
                            if ( $changelog_file && is_readable( $changelog_file ) ) {
                                    WP_Filesystem();
                                    $changelog = $wp_filesystem->get_contents( $changelog_file );
                                    $changelog_list = $this->parse_changelog( $changelog );
                
                                    echo wp_kses_post( $changelog_list );
                                }
                          ?>
                          </code>
                    </div>
                </div>
            </div>
            
            <div class="bcf-col-3">
                <div class="bcf-box">
                	<div class="bcf-box-top"><?php echo esc_html__('Need more features?', 'diet-shop');?></div>
                   
                    <div class="bcf-box-content">
                    	<p><?php echo esc_html__('Get the Pro version for more stunning elements, demos and Theme options.', 'diet-shop');?></p>
                         <p> <a target="_blank" href="<?php echo esc_url( $this->pro_url );?>" class="button action-btn"> <?php echo  esc_html__( 'Upgrade to PRO Version ', 'diet-shop' );?> </a> </p>
                    </div>
                </div>
            </div>
            
            
        <div class="clearfix"></div>
        </div>
        
        
        
    </div>
    <?php
	}
	
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}

		return wp_kses_post( $changelog );
	}
	}

	endif;

return new Diet_Shop_Notify_Admin();



