<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package lz-food-recipee
 */
?>
        </div>
        <footer id="colophon" class="site-footer" role="contentinfo">
            <div class="container">
                <aside class="widget-area" role="complementary">
                    <div class="row">
                        <?php
                        if ( is_active_sidebar( 'footer-1' ) ) { ?>
                            <div class="widget-column footer-widget-1 col-lg-3 col-md-3">
                                <?php dynamic_sidebar( 'footer-1' ); ?>
                            </div>
                        <?php }
                        if ( is_active_sidebar( 'footer-2' ) ) { ?>
                            <div class="widget-column footer-widget-2 col-lg-3 col-md-3">
                                <?php dynamic_sidebar( 'footer-2' ); ?>
                            </div>
                        <?php } ?>
                        <?php
                        if ( is_active_sidebar( 'footer-3' ) ) { ?>
                            <div class="widget-column footer-widget-3 col-lg-3 col-md-3">
                                <?php dynamic_sidebar( 'footer-3' ); ?>
                            </div>
                        <?php }
                        if ( is_active_sidebar( 'footer-4' ) ) { ?>
                            <div class="widget-column footer-widget-4 col-lg-3 col-md-3">
                                <?php dynamic_sidebar( 'footer-4' ); ?>
                            </div>
                        <?php } ?>
                    </div>  
                </aside>
            </div>
            <div class="copyright">
                <div class="container">
                    <div class="site-info">
                        <p><?php lz_food_recipee_credit(); ?> <?php echo esc_html(get_theme_mod('lzrestaurant_footer_copy',__('By Luzuk','lz-food-recipee'))); ?> </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<?php wp_footer(); ?>

</body>
</html>