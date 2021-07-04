<footer id="site-footer" class="site-footer" role="contentinfo">
    <div class="section-inner">

        <div class="footer-credits">

            <p class="footer-copyright">&copy;
                <?php
                echo esc_html(date_i18n(
                                /* translators: Copyright date format, see https://www.php.net/date */
                                _x('Y', 'copyright date format', 'marmot')
                ));
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
            </p>

            <p class="powered-by-wordpress">
                <a href="<?php echo esc_url(__('https://wordpress.org/', 'marmot')); ?>">
                    <?php echo esc_html_x('Powered by WordPress', 'no elementor footer', 'marmot'); ?>
                </a>
            </p>

        </div>

    </div>
</footer>
