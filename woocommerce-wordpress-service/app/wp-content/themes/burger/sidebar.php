<div class="kt-sidebar">
    <?php if (!dynamic_sidebar( 'sidebar' )): ?>
        <div class="pre-widget">
            <h3><?php _e('Widgetized Sidebar', 'burger'); ?></h3>
            <p><?php _e('This panel is active and ready for you to add 
            some widgets via the WP Admin', 'burger'); ?></p>
        </div>
    <?php endif; ?>
</div>