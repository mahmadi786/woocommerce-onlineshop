<?php
//about theme info
add_action( 'admin_menu', 'food_restaurant_gettingstarted' );
function food_restaurant_gettingstarted() {    	
	add_theme_page( esc_html__('Get Started', 'food-restaurant'), esc_html__('Get Started', 'food-restaurant'), 'edit_theme_options', 'food_restaurant_guide', 'food_restaurant_mostrar_guide');   
}

// Add a Custom CSS file to WP Admin Area
function food_restaurant_admin_theme_style() {
   wp_enqueue_style('custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getting-started/getting-started.css');
}
add_action('admin_enqueue_scripts', 'food_restaurant_admin_theme_style');

//guidline for about theme
function food_restaurant_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'food-restaurant' );
?>

<div class="wrapper-info">
	<div class="top-section">
	    <div class="col-left">
	    	<h2><?php esc_html_e( 'Welcome to Food Restaurant Theme', 'food-restaurant' ); ?></h2>
	    	<span class="version">Version: <?php echo esc_html($theme['Version']);?></span>
	    	<p><?php esc_html_e('We have developed a versatile, free Food Restaurant WordPress Theme. It can be used for multipurpose food businesses such as cafe, hotels, barbecues,fast food restaurants, pizzerias.Likewise, it is useful for bloggers,food critics,cakes shops,restaurants businesses and much more.Food Restaurant  WordPress Theme is an interactive and ecommerce compatible theme. It has got pages featuring Call to Action Button (CTA) showed over attractive banners. It has different personalization options that enable you to improve testimonial section and blogs. Amazing features and design will bring more traffic towards the theme. Which assures your business growth. More traffic and viewers mean a greater probability of getting sales. A theme with its engaging highlights and outline is what we are offering you right now.','food-restaurant'); ?></p>	    	
	    </div>
	    <div class="col-right">
	    	<div class="logo">
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/screenshot.png" alt="" />
			</div>
	    </div>
	    <div class="info-link">
			<a href="<?php echo esc_url( FOOD_RESTAURANT_FREE_THEME_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'food-restaurant' ); ?></a>
			<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customizing', 'food-restaurant'); ?></a>
			<a href="<?php echo esc_url( FOOD_RESTAURANT_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'food-restaurant'); ?></a>
			<a href="<?php echo esc_url( FOOD_RESTAURANT_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'food-restaurant'); ?></a>
			<a class="get-pro" href="<?php echo esc_url( FOOD_RESTAURANT_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Get Pro', 'food-restaurant'); ?></a>
		</div>
	</div>

	<div class="accordain-sec">
		<div class="block">
		  	<input type="radio" name="city" id="cityA" checked />   
		  	<label for="cityA"><span><?php esc_html_e( 'Visit to our amazing Premium Theme', 'food-restaurant' ); ?></span><span class="dashicons dashicons-arrow-down"></span></label>
		  	<div class="info1">
			  	<h3><?php esc_html_e( 'Premium Theme Information', 'food-restaurant' ); ?></h3>
			  	<hr class="hr-accr">
			  	<div class="sec-left-inner">
			  		<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/Logical-theme-responsive.png" alt="" />
			  		<p class="lite-para"><?php esc_html_e('The Food Restaurant WordPress Theme is a mobile-friendly WordPress theme which can be used for multipurpose food businesses such as restaurants, cafe, coffee shops, hotels, food joints, barbecues, grill houses, fast food restaurants, pizzerias, etc. Also, It is helpful for the bloggers, food critics, bakers to make websites for bakery, cakes shop, eatery, Chinese dishes, cuisines, recipes, hospitality business and much more. This theme has pages featuring the Call to Action Button displayed over the attractive banners. It has various personalization options that help you make the sections better such as the testimonial section, blog, etc. It Made using optimized codes, this user-friendly and professional theme offers faster page load time and an amazing user experience.','food-restaurant'); ?></p>

					<div class="info-link-top">
						<a href="<?php echo esc_url( FOOD_RESTAURANT_BUY_NOW ); ?>" target="_blank"> <?php esc_html_e( 'Buy Now', 'food-restaurant' ); ?></a>
						<a href="<?php echo esc_url( FOOD_RESTAURANT_LIVE_DEMO ); ?>" target="_blank"> <?php esc_html_e( 'Live Demo', 'food-restaurant' ); ?></a>
						<a href="<?php echo esc_url( FOOD_RESTAURANT_PRO_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Pro Documentation', 'food-restaurant' ); ?></a>
					</div>
					
			  	</div>
		  	</div>
		</div>
		<div class="block">
		  	<input type="radio" name="city" id="cityB"/>
		  	<label for="cityB"><span><?php esc_html_e( 'Theme Features', 'food-restaurant' ); ?></span><span class="dashicons dashicons-arrow-down"></span></label>
		  	<div class="info2">
			    <h3><?php esc_html_e( 'Lite Theme v/s Premium Theme', 'food-restaurant' ); ?></h3>
			  	<hr class="hr-accr">
			  	<div class="table-image">
					<table class="tablebox">
						<thead>
							<tr>
								<th></th>
								<th><?php esc_html_e('Free Themes', 'food-restaurant'); ?></th>
								<th><?php esc_html_e('Premium Themes', 'food-restaurant'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php esc_html_e('Theme Customization', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Responsive Design', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Logo Upload', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Social Media Links', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Slider Settings', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Number of Slides', 'food-restaurant'); ?></td>
								<td class="table-img"><?php esc_html_e('4', 'food-restaurant'); ?></td>
								<td class="table-img"><?php esc_html_e('Unlimited', 'food-restaurant'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Template Pages', 'food-restaurant'); ?></td>
								<td class="table-img"><?php esc_html_e('3', 'food-restaurant'); ?></td>
								<td class="table-img"><?php esc_html_e('6', 'food-restaurant'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Home Page Template', 'food-restaurant'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'food-restaurant'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'food-restaurant'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Contact us Page Template', 'food-restaurant'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('1', 'food-restaurant'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Blog Templates & Layout', 'food-restaurant'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('3(Full width/Left/Right Sidebar)', 'food-restaurant'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Page Templates & Layout', 'food-restaurant'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('2(Left/Right Sidebar)', 'food-restaurant'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Full Documentation', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Latest WordPress Compatibility', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Woo-Commerce Compatibility', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Support 3rd Party Plugins', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Secure and Optimized Code', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Exclusive Functionalities', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Section Enable / Disable', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Google Font Choices', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Gallery', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Simple & Mega Menu Option', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Support to add custom CSS / JS ', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Shortcodes', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Custom Background, Colors, Header, Logo & Menu', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Premium Membership', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Budget Friendly Value', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Priority Error Fixing', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Custom Feature Addition', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('All Access Theme Pass', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Seamless Customer Support', 'food-restaurant'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no-alt"></span></td>
								<td class="table-img"><span class="dashicons dashicons-yes"></span></td>
							</tr>
							<tr>
								<td></td>
								<td class="table-img"></td>
								<td class="update-link"><a href="<?php echo esc_url( FOOD_RESTAURANT_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade to Pro', 'food-restaurant'); ?></a></td>
							</tr>
						</tbody>
					</table>
				</div>
		 	</div>
		</div>
	</div>
</div>
<?php } ?>