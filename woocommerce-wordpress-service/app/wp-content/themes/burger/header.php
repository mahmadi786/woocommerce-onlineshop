<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php wp_title('|',true,'right'); ?></title>    
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php if(of_get_option('favicon_upload','')): ?>
        <link rel="icon" href="<?php if(of_get_option('favicon_upload','')): echo esc_url(of_get_option('favicon_upload','')); endif; ?>" type="image/x-icon">
    <?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="kt-top-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="kt-top-address">
                <div class="row">
                    <?php if(of_get_option('burger_address')): ?>
                        <div class="col-md-offset-6 col-md-3 col-sm-6 col-xs-12">
                            <!-- Top Area Address -->
                            <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                            <span><?php echo sanitize_text_field(of_get_option('burger_address')); ?></span>
                            
                        </div>
                    <?php endif ; ?>
                    <?php if(of_get_option('burger_phone')): ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <!-- Top Area  Telephone -->
                       
                        <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                        <span>
                        <?php echo sanitize_text_field(of_get_option('burger_phone')); ?></span>
                    </div>
                    <?php endif; ?>
                </div>    
                </div>
            </div>
        </div>
    </div>
</div><!--#kt-top-area ends here -->
<div id="kt-header-area">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h1 id="kt-logo">
                   <a href="<?php echo esc_url(home_url('/'));?>"><?php bloginfo('name'); ?></a>
                </h1>
                <h3 id="kt-sublogo">
                    <?php bloginfo('description'); ?>
                </h3>
            </div>
            <div class="col-md-8" id="kt-main-nav">
            <?php $menu_args = array('theme_location'=>'primary',
                                     'container'=>false,
                                     'menu_class'=>'main-menu');
                wp_nav_menu($menu_args);
            ?>
            </div>
        </div>
    </div>
</div>
<!-- Header Image -->
<?php if (get_header_image() != ''): ?>
<div id="kt-header-image">
    <img class="img-responsive" src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />    
</div>
<?php endif; ?>
<div class="kt-stripes text-center">
<?php if(is_category()): 
        echo '<h3>';
        single_cat_title();
        echo '</h3>'; 
      elseif(is_tag()):
        echo '<h3>';
        single_tag_title();
        echo '</h3>';
      elseif(is_search()):
        echo '<h3>'.__('Search Results','burger');
      endif;  
      ?>
</div>