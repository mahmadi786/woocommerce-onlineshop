<?php

namespace Marmot;

defined('ABSPATH') || exit;

class Admin_Notifications {

    /**
     * Admin_Notifications Instance
     * @var Admin_Notifications 
     */
    private static $_instance = null;

    /**
     * 
     * @since 1.0.0
     * 
     * @return Admin_Notifications
     */
    public static function instance() {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Admin_Notifications Constructor
     */
    private function __construct() {
        // Prevent double init from different plugins
        if (did_action('hq/notices/init')) {
            return;
        }
        do_action('hq/notices/init');

        add_action('admin_notices', [$this, 'admin_notices']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        add_action('wp_ajax_hq_notices_dismiss', [$this, 'ajax_hq_notices_dismiss']);
    }

    public function ajax_hq_notices_dismiss() {
        check_ajax_referer('hq-lib', '_ajax_nonce');

        if (!empty($_GET['notice_id'])) {
            $key = sanitize_key($_GET['notice_id']);
            self::dismiss_notice($key);
            wp_die('Dissmissed');
        }
    }

    public static function dismiss_notice($notice_key) {
        update_option("hq_notices_dismissed_{$notice_key}", time());
    }

    public function admin_enqueue_scripts() {
        global $hq_notices;
        
        // Do not include script if no notices
        if (empty($hq_notices)) {
            return;
        }
        
        wp_register_script('hq-notices', '', ['jquery'], '', true);
        wp_enqueue_script('hq-notices');
        wp_add_inline_script(
                'hq-notices',
                "(function( $ ) {
                    $( function() {
                        $( '.hq-notice' ).on( 'click', '.notice-dismiss', function( event, el ) {
                            var notice = $(this).parent('.notice.is-dismissible');
                            var dismiss_url = notice.attr('data-dismiss-url');
                            console.log(dismiss_url)
                            if ( dismiss_url ) {
                                $.get( dismiss_url );
                            }
                        });
                    } );
                })( jQuery );"
        );
    }

    /**
     * Print Notices
     * @global array $hq_notices
     */
    public function admin_notices() {
        global $hq_notices;

        foreach ($hq_notices as $notice_name => $notice) {
            if ($notice['dismiss']) {
                $option = get_option("hq_notices_dismissed_$notice_name", 0);
                if (empty($notice['dismiss_expire'])) {
                    if ($option) { // never show again
                        continue;
                    }
                } else {
                    if ($option && $option + $notice['dismiss_expire'] > time()) { // show only after dismiss_expire
                        continue;
                    }
                }
            }

            // phpcs:disable
            echo '<div id="setting-error-hq-' . $notice_name . '" ' .
            'class="notice hq-notice notice-' . $notice['type'] .
            ($notice['dismiss'] ?
                    ' is-dismissible" data-dismiss-url="' . esc_url(add_query_arg(['action' => 'hq_notices_dismiss', 'notice_id' => $notice_name, '_ajax_nonce' => wp_create_nonce('hq-lib')], admin_url('admin-ajax.php'))) :
                    '') . '">' .
            $notice['message'] .
            '</div>';
            // phpcs:enable
            unset($hq_notices[$notice_name]);
        }
    }

    /**
     * Add new notice to $hq_notices
     * Notice Types
     *      error – error message displayed with a red border
     *      warning – warning message displayed with a yellow border
     *      success – success message displayed with a green border
     *      info – info message displayed with a blue border
     * @global array $hq_notices
     * @param string $notice_key
     * @param string $type
     * @param string $message
     * @param boolean $dismiss
     * @param int $dismiss_expire
     */
    public function add_notice($notice_key, $type, $message, $dismiss = 1, $dismiss_expire = 0) {
        global $hq_notices;

        if (!is_array($hq_notices)) {
            $hq_notices = [];
        }

        $hq_notices[$notice_key] = [
            'type' => $type,
            'message' => $message,
            'dismiss' => $dismiss,
            'dismiss_expire' => $dismiss_expire,
        ];
    }

}
