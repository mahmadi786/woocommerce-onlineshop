<?php
$hq_header_banner = get_theme_mod('hq_header_banner', 'frontpage');
?><header class="site-header" role="banner">
    <div class="logo-nav">
        <div class="site-branding">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } elseif ($site_name = get_bloginfo('name')) {
                ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php esc_attr_e('Home', 'marmot-restaurants'); ?>" rel="home">
                        <?php echo esc_html($site_name); ?>
                    </a>
                </h1>
                <p class="site-description">
                    <?php
                    if ($tagline = get_bloginfo('description', 'display')) {
                        echo esc_html($tagline);
                    }
                    ?>
                </p>
            <?php } ?>
        </div>
        <nav class="site-navigation" role="navigation">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'primary-menu'));
            } else {
                wp_page_menu(
                        array(
                            'before' => '<ul id="menu-primary-items" class="primary-menu">',
                            'after' => '</ul>',
                        )
                );
            }
            ?>
        </nav>
    </div>
    <?php
    if (
            ('frontpage' === $hq_header_banner && is_front_page()) ||
            'entire-site' === $hq_header_banner
    ) {
        wp_enqueue_style('dashicons');
        ?> 
        <div class="header-banner">
            <div class="inner">
                <span class="dashicons dashicons-star-empty"></span>
                <h1><?php echo esc_html(get_theme_mod('hq_header_banner_heading_text')); ?></h1>
                <p><?php echo esc_html(get_theme_mod('hq_header_banner_text')); ?></p>
                <a href="<?php echo esc_attr(get_theme_mod('hq_header_banner_button_url')); ?>"><?php echo esc_html(get_theme_mod('hq_header_banner_button_text')); ?></a>
            </div>
        </div>
        <style type="text/css" rel="header-image">
    <?php
    $url = get_theme_mod('header_image', get_theme_support('custom-header', 'default-image'));
    if ('remove-header' === $url) {
        $url = '';
    }
    if (is_random_header_image()) {
        $url = get_random_header_image();
    }
    ?>
            .site-header .header-banner {
                text-align: center;
                padding: 150px 0;
                display: block;
    <?php if ($url) { ?>
                    background-image: url( <?php echo esc_url(set_url_scheme($url)); ?>);
                    background-position: center top;
                    background-repeat: no-repeat;
                    background-size: cover;
    <?php } ?>
            }
            .header-banner span,
            .header-banner h1,
            .header-banner p {
                color: <?php echo esc_attr(get_header_textcolor()); ?>;
            }
        </style>
        <?php
    }
    ?>
</header>
