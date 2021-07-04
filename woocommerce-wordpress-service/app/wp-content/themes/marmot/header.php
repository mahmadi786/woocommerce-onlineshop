<?php
/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="<?php echo esc_attr(get_theme_mod('hq_appearance_mobile_browsers_color')) ?>" />
        <?php
        if (is_singular() && pings_open()) {
            echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
        }
        wp_head();
        ?>
    </head>

    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <div id="main-wrapper">
            <a class="skip-link screen-reader-text" href="#content">Skip to content</a>
            <?php do_action('hqt/primary_container/before'); ?>
            <div id="primary">
                <?php do_action('hqt/content_container/before'); ?>
                <div id="content" class="<?php echo esc_attr(apply_filters('hqt/main_content/css_class', 'site-content')) ?>">
                    <?php do_action('hqt/main_content/before'); ?>