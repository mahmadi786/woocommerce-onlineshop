<?php

namespace Marmot;

defined('ABSPATH') || exit;

/**
 * Pods
 * 
 * Makes Marmot fully compatible with Pods plugin for custom post types and fields
 * 
 * @since 1.0.0
 */
class Pods {

    /**
     * Gets post types by type post_type on taxonomy
     * 
     * @since 1.0.0
     * 
     * @param string $type
     * @return array
     */
    public static function get_custom_post_types($type = 'post_type', $cache = true) {

        if (!function_exists('pods')) {
            return [];
        }

        if (!$cache || false == $post_types = get_transient('hqt_pods_' . $type)) {
            $all_pods = pods_api()->load_pods([
                'table_info' => false,
                'fields' => false,
            ]);

            $post_types = [];

            foreach ($all_pods as $group) {

                if ($type != $group['type']) {
                    continue;
                }

                $post_types[$group['name']] = ucfirst($group['name']);
            }

            set_transient('hqt_pods_' . $type, $post_types, DAY_IN_SECONDS);
        }

        return $post_types;
    }

}
