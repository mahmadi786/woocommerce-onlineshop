<?php
/**
 * Hooks for prebuilt layout in site origin panels.
 *
 * @package Restaurantz
 */

function restaurantz_prebuilt_home_page( $layouts ) {

	$layouts['restaurantz-home-page'] = array(
		'name'        => __( 'Restaurantz Home', 'restaurantz' ),
		'description' => __( 'Prebuilt Layout for Home page', 'restaurantz' ),
		'screenshot'  => get_template_directory_uri() . '/images/builder-layout-home.jpg',

		  'widgets' =>
		  array(
		    0 =>
		    array(
		      'frames' =>
		      array(
		        0 =>
		        array(
		          'content' => '<h2 style="text-align: center;"></h2>
		<h2 style="text-align: center;">' . __( 'Welcome to Restaurantz', 'restaurantz' ) . '</h2>
		<p style="text-align: center;">' . __( 'Description for first slide goes here.', 'restaurantz' ) . '</p>
		<p style="text-align: center;">[buttons]</p>',
		          'content_selected_editor' => 'html',
		          'buttons' =>
		          array(
		            0 =>
		            array(
		              'button' =>
		              array(
		                'text' => __( 'Online Order', 'restaurantz' ),
		                'url' => '#',
		                'new_window' => true,
		                'button_icon' =>
		                array(
		                  'icon_selected' => 'fontawesome-tty',
		                  'icon_color' => '#ffffff',
		                  'icon' => 0,
		                  'so_field_container_state' => 'open',
		                ),
		                'design' =>
		                array(
		                  'align' => 'center',
		                  'theme' => 'atom',
		                  'button_color' => '#f9a400',
		                  'text_color' => '#ffffff',
		                  'hover' => true,
		                  'font_size' => '1.45',
		                  'rounding' => '0',
		                  'padding' => '1',
		                  'so_field_container_state' => 'open',
		                ),
		                'attributes' =>
		                array(
		                  'id' => '',
		                  'title' => '',
		                  'onclick' => '',
		                  'so_field_container_state' => 'closed',
		                ),
		              ),
		            ),
		          ),
		          'background' =>
		          array(
		            'image' => 0,
		            'image_fallback' => 'http://demo.wenthemes.com/restaurantz-pro/wp-content/uploads/sites/13/2016/02/wine-622116_1920.jpg',
		            'opacity' => 100,
		            'color' => '#333333',
		            'url' => '#',
		            'new_window' => true,
		            'so_field_container_state' => 'open',
		            'videos' =>
		            array(),
		          ),
		        ),
		        1 =>
		        array(
		          'content' => '<h2 style="text-align: center;"></h2>
		<h2 style="text-align: center;">' . __( 'Delicious Food Items', 'restaurantz' ) . '</h2>
		<p style="text-align: center;">' . __( 'Description for second slide goes here.', 'restaurantz' ) . '</p>
		<p style="text-align: center;">[buttons]</p>',
		          'content_selected_editor' => 'html',
		          'buttons' =>
		          array(
		            0 =>
		            array(
		              'button' =>
		              array(
		                'text' => __( 'Online Order', 'restaurantz' ),
		                'url' => '#',
		                'new_window' => true,
		                'button_icon' =>
		                array(
		                  'icon_selected' => 'fontawesome-cart-plus',
		                  'icon_color' => '#ffffff',
		                  'icon' => 0,
		                  'so_field_container_state' => 'open',
		                ),
		                'design' =>
		                array(
		                  'align' => 'center',
		                  'theme' => 'atom',
		                  'button_color' => '#f9a400',
		                  'text_color' => '#ffffff',
		                  'hover' => true,
		                  'font_size' => '1.45',
		                  'rounding' => '0',
		                  'padding' => '1',
		                  'so_field_container_state' => 'open',
		                ),
		                'attributes' =>
		                array(
		                  'id' => '',
		                  'title' => '',
		                  'onclick' => '',
		                  'so_field_container_state' => 'closed',
		                ),
		              ),
		            ),
		          ),
		          'background' =>
		          array(
		            'image' => 0,
		            'image_fallback' => 'http://demo.wenthemes.com/restaurantz-pro/wp-content/uploads/sites/13/2016/02/abendbrot-939435_1920.jpg',
		            'opacity' => 100,
		            'color' => '#333333',
		            'url' => '#',
		            'new_window' => true,
		            'so_field_container_state' => 'open',
		            'videos' =>
		            array(),
		          ),
		        ),
		        2 =>
		        array(
		          'content' => '<h2 style="text-align: center;"></h2>
		<h2 style="text-align: center;">' . __( 'Peaceful Environment', 'restaurantz' ) . '</h2>
		<p style="text-align: center;">' . __( 'Description for third slide goes here.', 'restaurantz' ) . '</p>
		<p style="text-align: center;">[buttons]</p>',
		          'content_selected_editor' => 'html',
		          'buttons' =>
		          array(
		            0 =>
		            array(
		              'button' =>
		              array(
		                'text' => __( 'Book A Table', 'restaurantz' ),
		                'url' => '#',
		                'new_window' => true,
		                'button_icon' =>
		                array(
		                  'icon_selected' => 'fontawesome-expeditedssl',
		                  'icon_color' => '#ffffff',
		                  'icon' => 0,
		                  'so_field_container_state' => 'open',
		                ),
		                'design' =>
		                array(
		                  'align' => 'center',
		                  'theme' => 'flat',
		                  'button_color' => '#f9a400',
		                  'text_color' => '#ffffff',
		                  'hover' => true,
		                  'font_size' => '1.45',
		                  'rounding' => '0',
		                  'padding' => '1',
		                  'so_field_container_state' => 'open',
		                ),
		                'attributes' =>
		                array(
		                  'id' => '',
		                  'title' => '',
		                  'onclick' => '',
		                  'so_field_container_state' => 'closed',
		                ),
		              ),
		            ),
		          ),
		          'background' =>
		          array(
		            'image' => 0,
		            'image_fallback' => 'http://demo.wenthemes.com/restaurantz-pro/wp-content/uploads/sites/13/2016/02/st-826687_1280.jpg',
		            'opacity' => 100,
		            'color' => '#333333',
		            'url' => '#',
		            'new_window' => true,
		            'so_field_container_state' => 'closed',
		            'videos' =>
		            array(),
		          ),
		        ),
		      ),
		      'controls' =>
		      array(
		        'speed' => 800,
		        'timeout' => 8000,
		        'nav_color_hex' => '#FFFFFF',
		        'nav_style' => 'thin',
		        'nav_size' => 25,
		        'so_field_container_state' => 'closed',
		      ),
		      'design' =>
		      array(
		        'height' => '700px',
		        'height_unit' => 'px',
		        'padding' => '250px',
		        'padding_unit' => 'px',
		        'extra_top_padding' => '0px',
		        'extra_top_padding_unit' => 'px',
		        'padding_sides' => '150px',
		        'padding_sides_unit' => 'px',
		        'width' => '1280px',
		        'width_unit' => 'px',
		        'heading_font' => '',
		        'heading_color' => '#FFFFFF',
		        'heading_size' => '38px',
		        'heading_size_unit' => 'px',
		        'heading_shadow' => 50,
		        'text_size' => '16px',
		        'text_size_unit' => 'px',
		        'text_color' => '#F6F6F6',
		        'so_field_container_state' => 'closed',
		      ),
		      '_sow_form_id' => '56bd8264ab836',
		      'panels_info' =>
		      array(
		        'class' => 'SiteOrigin_Widget_Hero_Widget',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 0,
		        'id' => 0,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    1 =>
		    array(
		      'primary_title' => __( 'About Us', 'restaurantz' ),
		      'secondary_title' => '',
		      'title_content' => __( 'This is Restaurantz: Title widget. Description about your company goes here.', 'restaurantz' ),
		      'align' => 'center',
		      'settings' =>
		      array(
		        'color_primary_title' => '#7f390a',
		        'color_secondary_title' => '#7f390a',
		        'color_title_content' => '#313131',
		        'so_field_container_state' => 'open',
		      ),
		      '_sow_form_id' => '569dcdfdd5e3c',
		      'panels_info' =>
		      array(
		        'class' => 'Restaurantz_Title_Subtitle_Widget',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 0,
		        'id' => 1,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    2 =>
		    array(
		      'title' => __( 'Special Dishes', 'restaurantz' ),
		      'sub_title' => '',
		      'dishes_post_id' => 'post_type=_all&post__in=29,27,36,31&date_query={"after":"","before":""}&orderby=post__in&order=DESC&posts_per_page=&sticky=&additional=',
		      'dishes_custom_ids' => '',
		      'settings' =>
		      array(
		        'per_row' => '4',
		        'featured_image' => 'restaurantz-food-thumb',
		        'excerpt_settings' =>
		        array(
		          'excerpt_length' => 20,
		          'so_field_container_state' => 'open',
		          'disable_excerpt' => false,
		        ),
		        'so_field_container_state' => 'open',
		      ),
		      '_sow_form_id' => '56badfd40bafc',
		      'panels_info' =>
		      array(
		        'class' => 'Restaurantz_Special_Dishes_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 0,
		        'id' => 2,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    3 =>
		    array(
		      'title' => __( 'Welcome to the our Restaurantz', 'restaurantz' ),
		      'sub_title' => __( 'This is Restaurantz: CTA widget. You can add description and button in this widget. You can easily customize Button text, link and design.', 'restaurantz' ),
		      'button' =>
		      array(
		        'text' => __( 'Download', 'restaurantz' ),
		        'url' => '#',
		        'new_window' => true,
		        'button_icon' =>
		        array(
		          'icon_selected' => 'fontawesome-download',
		          'icon_color' => '#ffffff',
		          'icon' => 0,
		          'so_field_container_state' => 'open',
		        ),
		        'design' =>
		        array(
		          'theme' => 'atom',
		          'button_color' => '#f9a400',
		          'text_color' => '#ffffff',
		          'hover' => true,
		          'font_size' => '1.45',
		          'rounding' => '0',
		          'padding' => '1',
		          'so_field_container_state' => 'open',
		        ),
		        'attributes' =>
		        array(
		          'id' => '',
		          'title' => '',
		          'onclick' => '',
		          'so_field_container_state' => 'closed',
		        ),
		      ),
		      'settings' =>
		      array(
		        'color_widget_title' => '#fff',
		        'color_widget_sub_title' => '#fff',
		        'color_icon_hover' => '#fff',
		        'color_button_hover' => '#fff',
		        'color_button_background_hover' => '#f9a400',
		        'so_field_container_state' => 'closed',
		      ),
		      '_sow_form_id' => '56b198531910b',
		      'panels_info' =>
		      array(
		        'class' => 'Restaurantz_Cta_Widget',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 0,
		        'id' => 3,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    4 =>
		    array(
		      'primary_title' => __( 'Our Services', 'restaurantz' ),
		      'secondary_title' => '',
		      'title_content' => '',
		      'align' => 'center',
		      'settings' =>
		      array(
		        'color_primary_title' => '#7f390a',
		        'color_secondary_title' => '#313131',
		        'color_title_content' => '#313131',
		        'so_field_container_state' => 'closed',
		      ),
		      '_sow_form_id' => '56a89a110513a',
		      'panels_info' =>
		      array(
		        'class' => 'Restaurantz_Title_Subtitle_Widget',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 0,
		        'id' => 4,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    5 =>
		    array(
		      'features' =>
		      array(
		        0 =>
		        array(
		          'container_color' => '#ffb73d',
		          'icon' => 'fontawesome-star',
		          'icon_color' => '#ffffff',
		          'icon_image' => 0,
		          'title' => __( 'Breakfast', 'restaurantz' ),
		          'text' => __( 'Description for first section goes here.', 'restaurantz' ),
		          'more_text' => __( 'Read More', 'restaurantz' ),
		          'more_url' => '#',
		        ),
		        1 =>
		        array(
		          'container_color' => '#ffb73d',
		          'icon' => 'fontawesome-trophy',
		          'icon_color' => '#ffffff',
		          'icon_image' => 0,
		          'title' => __( 'Lunch', 'restaurantz' ),
		          'text' => __( 'Description for second section goes here.', 'restaurantz' ),
		          'more_text' => __( 'Read More', 'restaurantz' ),
		          'more_url' => '#',
		        ),
		        2 =>
		        array(
		          'container_color' => '#ffb73d',
		          'icon' => 'fontawesome-beer',
		          'icon_color' => '#ffffff',
		          'icon_image' => 0,
		          'title' => __( 'Dinner', 'restaurantz' ),
		          'text' => __( 'Description for third section goes here.', 'restaurantz' ),
		          'more_text' => __( 'Read More', 'restaurantz' ),
		          'more_url' => '#',
		        ),
		        3 =>
		        array(
		          'container_color' => '#ffb73d',
		          'icon' => 'fontawesome-cutlery',
		          'icon_color' => '#ffffff',
		          'icon_image' => 0,
		          'title' => __( 'Catering', 'restaurantz' ),
		          'text' => __( 'Description for fourth section goes here.', 'restaurantz' ),
		          'more_text' => __( 'Read More', 'restaurantz' ),
		          'more_url' => '#',
		        ),
		      ),
		      'fonts' =>
		      array(
		        'title_options' =>
		        array(
		          'font' => 'default',
		          'size' => '25px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'open',
		        ),
		        'text_options' =>
		        array(
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'open',
		        ),
		        'more_text_options' =>
		        array(
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'open',
		        ),
		        'so_field_container_state' => 'closed',
		      ),
		      'container_shape' => 'round',
		      'container_size' => '80px',
		      'container_size_unit' => 'px',
		      'icon_size' => '30px',
		      'icon_size_unit' => 'px',
		      'per_row' => 4,
		      'responsive' => true,
		      'title_link' => true,
		      'icon_link' => true,
		      'new_window' => true,
		      '_sow_form_id' => '56a884a6c2322',
		      'panels_info' =>
		      array(
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 0,
		        'id' => 5,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    6 =>
		    array(
		      'primary_title' => __( 'Our Story', 'restaurantz' ),
		      'secondary_title' => '',
		      'title_content' => '',
		      'align' => 'center',
		      '_sow_form_id' => '572ab879bbec3',
		      'panels_info' =>
		      array(
		        'class' => 'Restaurantz_Title_Subtitle_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 1,
		        'id' => 6,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    7 =>
		    array(
		      'image' => 0,
		      'image_fallback' => 'http://demo.wenthemes.com/restaurantz/wp-content/uploads/sites/18/2016/05/food-878445_1920-1024x683.jpg',
		      'size' => 'full',
		      'align' => 'default',
		      'title' => '',
		      'title_position' => 'hidden',
		      'alt' => '',
		      'url' => '',
		      'bound' => true,
		      '_sow_form_id' => '572aaf1fe0a56',
		      'new_window' => false,
		      'full_width' => false,
		      'panels_info' =>
		      array(
		        'class' => 'SiteOrigin_Widget_Image_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 1,
		        'id' => 7,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    8 =>
		    array(
		      'title' => __( 'Reservation', 'restaurantz' ),
		      'text' => __( 'Replace this widget with Open Table widget.', 'restaurantz' ),
		      'filter' => true,
		      'panels_info' =>
		      array(
		        'class' => 'WP_Widget_Text',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 3,
		        'id' => 8,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    9 =>
		    array(
		      'title' => __( 'Latest News', 'restaurantz' ),
		      'sub_title' => '',
		      'posts' => 'post_type=post&date_query={"after":"","before":""}&orderby=post__in&order=DESC&posts_per_page=4&sticky=&additional=',
		      'settings' =>
		      array(
		        'post_column' => '4',
		        'featured_image' => 'medium',
		        'excerpt_length' => 20,
		        'more_text' => 'Read more',
		        'disable_comment' => true,
		        'so_field_container_state' => 'open',
		        'disable_date' => false,
		        'disable_excerpt' => false,
		        'disable_more_text' => false,
		      ),
		      '_sow_form_id' => '56b07fea22508',
		      'panels_info' =>
		      array(
		        'class' => 'Restaurantz_Latest_News_Widget',
		        'grid' => 6,
		        'cell' => 0,
		        'id' => 9,
		        'style' =>
		        array(
		          'padding' => '0px',
		          'background_image_attachment' => false,
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    10 =>
		    array(
		      'image' => 0,
		      'image_fallback' => 'http://demo.wenthemes.com/restaurantz/wp-content/uploads/sites/18/2016/05/gmap.jpg',
		      'size' => 'full',
		      'align' => 'default',
		      'title' => '',
		      'title_position' => 'hidden',
		      'alt' => '',
		      'url' => '',
		      'bound' => true,
		      '_sow_form_id' => '56d54bdd4d3a5',
		      'new_window' => false,
		      'full_width' => false,
		      'panels_info' =>
		      array(
		        'class' => 'SiteOrigin_Widget_Image_Widget',
		        'raw' => false,
		        'grid' => 7,
		        'cell' => 0,
		        'id' => 10,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    11 =>
		    array(
		      'primary_title' => __( 'Our Story', 'restaurantz' ),
		      'secondary_title' => __( 'Tagline regarding your story.', 'restaurantz' ),
		      'title_content' => __( 'Description about your story goes here. How you started? Who were there in the start? How you were able to grow?', 'restaurantz' ),
		      'align' => 'center',
		      '_sow_form_id' => '56d54bf97fdc2',
		      'panels_info' =>
		      array(
		        'class' => 'Restaurantz_Title_Subtitle_Widget',
		        'raw' => false,
		        'grid' => 7,
		        'cell' => 1,
		        'id' => 11,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    12 =>
		    array(
		      'title' => __( 'Our Restaurantz Team', 'restaurantz' ),
		      'sub_title' => __( 'Tagline for team widget', 'restaurantz' ),
		      'members' =>
		      array(
		        0 =>
		        array(
		          'full_name' => __( 'Mr. Micle Jack', 'restaurantz' ),
		          'position' => __( 'Manager', 'restaurantz' ),
		          'profile_picture' => 0,
		          'profile_picture_fallback' => 'http://demo.wenthemes.com/restaurantz/wp-content/uploads/sites/18/2016/05/team3.png',
		        ),
		        1 =>
		        array(
		          'full_name' => __( 'Mr. Micle Jack', 'restaurantz' ),
		          'position' => __( 'Manager', 'restaurantz' ),
		          'profile_picture' => 0,
		          'profile_picture_fallback' => 'http://demo.wenthemes.com/restaurantz/wp-content/uploads/sites/18/2016/05/team2.png',
		        ),
		        2 =>
		        array(
		          'full_name' => __( 'Mr. Micle Jack', 'restaurantz' ),
		          'position' => __( 'Manager', 'restaurantz' ),
		          'profile_picture' => 0,
		          'profile_picture_fallback' => 'http://demo.wenthemes.com/restaurantz/wp-content/uploads/sites/18/2016/05/team.png',
		        ),
		        3 =>
		        array(
		          'full_name' => __( 'Mr. Micle Jack', 'restaurantz' ),
		          'position' => __( 'Manager', 'restaurantz' ),
		          'profile_picture' => 0,
		          'profile_picture_fallback' => 'http://demo.wenthemes.com/restaurantz/wp-content/uploads/sites/18/2016/05/team3.png',
		        ),
		      ),
		      'per_row' => '4',
		      '_sow_form_id' => '56a70819eed30',
		      'panels_info' =>
		      array(
		        'class' => 'Restaurantz_Team_Widget',
		        'raw' => false,
		        'grid' => 8,
		        'cell' => 0,
		        'id' => 12,
		        'style' =>
		        array(
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' =>
		  array(
		    0 =>
		    array(
		      'cells' => 1,
		      'style' =>
		      array(
		        'row_stretch' => 'full-stretched',
		        'background_display' => 'tile',
		      ),
		    ),
		    1 =>
		    array(
		      'cells' => 1,
		      'style' =>
		      array(
		        'padding' => '80px',
		        'row_stretch' => 'full',
		        'background' => '#fef9f5',
		        'background_image_attachment' => 22,
		        'background_display' => 'cover',
		      ),
		    ),
		    2 =>
		    array(
		      'cells' => 1,
		      'style' =>
		      array(
		        'padding' => '80px',
		        'row_stretch' => 'full',
		        'background_display' => 'cover',
		      ),
		    ),
		    3 =>
		    array(
		      'cells' => 1,
		      'style' =>
		      array(
		        'padding' => '80px',
		        'row_stretch' => 'full',
		        'background' => '#fef9f5',
		        'background_display' => 'parallax',
		      ),
		    ),
		    4 =>
		    array(
		      'cells' => 1,
		      'style' =>
		      array(
		        'padding' => '80px',
		        'row_stretch' => 'full',
		        'background_display' => 'parallax',
		      ),
		    ),
		    5 =>
		    array(
		      'cells' => 5,
		      'style' =>
		      array(
		        'padding' => '80px',
		        'row_stretch' => 'full',
		        'background' => '#fef9f5',
		        'background_display' => 'cover',
		      ),
		    ),
		    6 =>
		    array(
		      'cells' => 1,
		      'style' =>
		      array(
		        'padding' => '80px',
		        'row_stretch' => 'full',
		        'background' => '#ffffff',
		        'background_display' => 'tile',
		      ),
		    ),
		    7 =>
		    array(
		      'cells' => 2,
		      'style' =>
		      array(
		        'padding' => '80px',
		        'row_stretch' => 'full',
		        'background' => '#fef9f5',
		        'background_display' => 'tile',
		      ),
		    ),
		    8 =>
		    array(
		      'cells' => 1,
		      'style' =>
		      array(
		        'padding' => '80px',
		        'row_stretch' => 'full',
		        'background_display' => 'parallax-original',
		      ),
		    ),
		  ),
		  'grid_cells' =>
		  array(
		    0 =>
		    array(
		      'grid' => 0,
		      'weight' => 1,
		    ),
		    1 =>
		    array(
		      'grid' => 1,
		      'weight' => 1,
		    ),
		    2 =>
		    array(
		      'grid' => 2,
		      'weight' => 1,
		    ),
		    3 =>
		    array(
		      'grid' => 3,
		      'weight' => 1,
		    ),
		    4 =>
		    array(
		      'grid' => 4,
		      'weight' => 1,
		    ),
		    5 =>
		    array(
		      'grid' => 5,
		      'weight' => 0.059719438877756187,
		    ),
		    6 =>
		    array(
		      'grid' => 5,
		      'weight' => 0.40941883767535125,
		    ),
		    7 =>
		    array(
		      'grid' => 5,
		      'weight' => 0.039679358717435123,
		    ),
		    8 =>
		    array(
		      'grid' => 5,
		      'weight' => 0.43146292585170132,
		    ),
		    9 =>
		    array(
		      'grid' => 5,
		      'weight' => 0.059719438877756187,
		    ),
		    10 =>
		    array(
		      'grid' => 6,
		      'weight' => 1,
		    ),
		    11 =>
		    array(
		      'grid' => 7,
		      'weight' => 0.5,
		    ),
		    12 =>
		    array(
		      'grid' => 7,
		      'weight' => 0.5,
		    ),
		    13 =>
		    array(
		      'grid' => 8,
		      'weight' => 1,
		    ),
		  ),

	);

	return $layouts;

}

add_filter( 'siteorigin_panels_prebuilt_layouts', 'restaurantz_prebuilt_home_page' );
