<div class="kt-stripes"></div>
<?php if(is_active_sidebar('footer-sidebar-1') && is_active_sidebar('footer-sidebar-2')): ?>
<footer id="kt-footer">
        <div class="container">
        <div class="row">
        <?php $burger_fsn = esc_html(of_get_option('footer_sidebars_number','1')); 
              if($burger_fsn == 1):
        ?>
               <div class="col-md-12 kt-sidebar">
                    <?php if (!dynamic_sidebar( 'footer-sidebar-1')): ?>
                        <div class="pre-widget">
                            <h3><?php _e('Widgetized Sidebar', 'burger'); ?></h3>
                            <p><?php _e('This panel is active and ready for you to add 
                            some widgets via the WP Admin', 'burger'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>    
        <?php elseif($burger_fsn == 2): ?>
                <div class="col-md-6 kt-sidebar">
                    <?php if (!dynamic_sidebar( 'footer-sidebar-1')): ?>
                        <div class="pre-widget">
                            <h3><?php _e('Widgetized Sidebar', 'burger'); ?></h3>
                            <p><?php _e('This panel is active and ready for you to add 
                            some widgets via the WP Admin', 'burger'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 kt-sidebar">
                    <?php if (!dynamic_sidebar( 'footer-sidebar-2')): ?>
                        <div class="pre-widget">
                            <h3><?php _e('Widgetized Sidebar', 'burger'); ?></h3>
                            <p><?php _e('This panel is active and ready for you to add 
                            some widgets via the WP Admin', 'burger'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
        <?php else: ?>
               <div class="col-md-12 kt-sidebar">
                    <?php if (!dynamic_sidebar( 'footer-sidebar-1')): ?>
                        <div class="pre-widget">
                            <h3><?php _e('Widgetized Sidebar', 'burger'); ?></h3>
                            <p><?php _e('This panel is active and ready for you to add 
                            some widgets via the WP Admin', 'burger'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>    
        <?php endif ;?>    
        </div>
    </div>
</footer>
<?php endif; ?>
    <div id="kt-copyright">
        <div class="container">    
            <div class="row">
                <div class="col-md-12">
                        <p><a rel="nofollow" href="<?php echo esc_url( __( 'http://www.ketchupthemes.com/burger-theme', 'burger')); ?>">
                        <?php printf( __( 'burger', 'burger' )); ?></a>, 
                        <?php echo __('&copy;','burger'); ?>
                        <?php echo date('Y'); ?>
                        <?php bloginfo('name'); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php wp_footer();?>
</body>
</html>