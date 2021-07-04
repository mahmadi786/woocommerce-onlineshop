<?php
//about theme info
add_action( 'admin_menu', 'lzrestaurant_gettingstarted' );
function lzrestaurant_gettingstarted() {    	
	add_theme_page( esc_html__('About Theme', 'lzrestaurant'), esc_html__('About Theme', 'lzrestaurant'), 'edit_theme_options', 'lzrestaurant_guide', 'lzrestaurant_mostrar_guide');   
}

// Add a Custom CSS file to WP Admin Area
function lzrestaurant_admin_theme_style() {
   wp_enqueue_style('custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getting-started/getting-started.css');
}
add_action('admin_enqueue_scripts', 'lzrestaurant_admin_theme_style');

//guidline for about theme
function lzrestaurant_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'lzrestaurant' );

?>

<div class="wrapper-info">
	<div class="col-left">
		<div class="intro">
			<h3><?php esc_html_e( 'Welcome to LZ Restaurant WordPress Theme', 'lzrestaurant' ); ?> <span>Version: <?php echo esc_html($theme['Version']);?></span></h3>
		</div>
		<div class="started">
			<hr>
			<div class="free-doc">
				<div class="lz-4">
					<h4><?php esc_html_e( 'Start Customizing', 'lzrestaurant' ); ?></h4>
					<ul>
						<span><?php esc_html_e( 'Go to', 'lzrestaurant' ); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customizer', 'lzrestaurant' ); ?> </a> <?php esc_html_e( 'and start customizing your website', 'lzrestaurant' ); ?></span>
					</ul>
				</div>
				<div class="lz-4">
					<h4><?php esc_html_e( 'Support', 'lzrestaurant' ); ?></h4>
					<ul>
						<span><?php esc_html_e( 'Send your query to our', 'lzrestaurant' ); ?> <a href="<?php echo esc_url( LZRESTAURANT_SUPPORT ); ?>" target="_blank"> <?php esc_html_e( 'Support', 'lzrestaurant' ); ?></a></span>
					</ul>
				</div>
			</div>
			<p><?php esc_html_e( 'LZ Restaurant is a multipurpose WordPress theme developed especially for websites that deal with coffee, cafe, cakes, bakery, cuisine, recipe, fast food, Chinese dishes, and other eatery businesses. This is the must-have theme for food critics and bloggers to establish beautiful websites for bakery, barbecues, hotel, food joint, Italian restaurants, lodge, and grill houses. The clean restaurant theme is purely mobile responsive supporting all screen size devices. The theme is so user-friendly and easily customizable that even if you arent a professional developer, you can work on it. You get ample of personalization options to modify the theme into your choice of look and appearance. The theme has an elegant banner thereby allowing you to feature your business in the best manner on the homepage itself. The testimonial section makes it more alluring as it displays the feedback given by people who have visited your WordPress website. Furthermore, the Call to action (CTA) button drives in abundance of clicks giving a boost in lead generation. The restaurant theme is highly interactive with a number of pages to display stunning meals! The different shortcodes keep you away from indulging in the source code. The social media integration removes the need to have additional social media plugins. The SEO friendly nature of the theme guarantees to bring your site on top of search engines. Built on Bootstrap, using optimized codes, the theme is clean and extremely lightweight. Launch your very own entirely functional WP restaurant website with this amazing theme now!', 'lzrestaurant')?></p>
			<hr>			
			<div class="col-left-inner">
				<h3><?php esc_html_e( 'Get started with Free Restuarant Theme', 'lzrestaurant' ); ?></h3>
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/customizer-image.png" alt="" />
			</div>
		</div>
	</div>
	<div class="col-right">
		<div class="col-left-area">
			<h3><?php esc_html_e('Premium Theme Information', 'lzrestaurant'); ?></h3>
			<hr>
		</div>
		<div class="centerbold">
			<a href="<?php echo esc_url( LZRESTAURANT_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'lzrestaurant'); ?></a>
			<a href="<?php echo esc_url( LZRESTAURANT_BUY_NOW ); ?>"><?php esc_html_e('Buy Pro', 'lzrestaurant'); ?></a>
			<a href="<?php echo esc_url( LZRESTAURANT_PRO_DOCS ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'lzrestaurant'); ?></a>
			<hr class="secondhr">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/lz-restaurant.jpg" alt="" />	
		</div>
		<h3><?php esc_html_e( 'PREMIUM THEME FEATURES', 'lzrestaurant'); ?></h3>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon01.png" alt="" />
			<h4><?php esc_html_e( 'Banner Slider', 'lzrestaurant'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon02.png" alt="" />
			<h4><?php esc_html_e( 'Theme Options', 'lzrestaurant'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon03.png" alt="" />
			<h4><?php esc_html_e( 'Custom Innerpage Banner', 'lzrestaurant'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon04.png" alt="" />
			<h4><?php esc_html_e( 'Custom Colors and Images', 'lzrestaurant'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon05.png" alt="" />
			<h4><?php esc_html_e( 'Fully Responsive', 'lzrestaurant'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon06.png" alt="" />
			<h4><?php esc_html_e( 'Hide/Show Sections', 'lzrestaurant'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon07.png" alt="" />
			<h4><?php esc_html_e( 'Woocommerce Support', 'lzrestaurant'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon08.png" alt="" />
			<h4><?php esc_html_e( 'Limit to display number of Posts', 'lzrestaurant'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon09.png" alt="" />
			<h4><?php esc_html_e( 'Multiple Page Templates', 'lzrestaurant'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon10.png" alt="" />
			<h4><?php esc_html_e( 'Custom Read More link', 'lzrestaurant'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon11.png" alt="" />
			<h4><?php esc_html_e( 'Code written with WordPress standard', 'lzrestaurant'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon12.png" alt="" />
			<h4><?php esc_html_e( '100% Multi language', 'lzrestaurant'); ?></h4>
		</div>
	</div>
</div>
<?php } ?>