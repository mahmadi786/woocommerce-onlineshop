<?php

namespace Marmot;

defined('ABSPATH') || exit;

/**
 * Marmot autoloader.
 *
 * Marmot autoloader handler class is responsible for loading the different
 * classes needed to run the plugin.
 *
 * @since 1.0.0
 */
class Autoloader {

    /**
     * Classes map.
     *
     * Maps classes to file names.
     *
     * @since 1.0.0
     * @access private
     * @static
     *
     * @var array Classes
     */
    private static $classes_map;

    /**
     * Classes aliases.
     *
     * Maps classes to aliases.
     *
     * @since 1.0.0
     * @access private
     * @static
     *
     * @var array Classes aliases.
     */
    private static $classes_aliases;

    /**
     * Run autoloader.
     *
     * Register a function as `__autoload()` implementation.
     *
     * @since 1.0.0
     * @access public
     * @static
     */
    public static function run() {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    /**
     * Load class.
     *
     * For a given class name, require the class file.
     *
     * @since 1.0.0
     * @access private
     * @static
     *
     * @param string $relative_class_name Class name.
     */
    private static function load_class($relative_class_name) {
        $filename = strtolower(
                preg_replace(
                        ['/([a-z])([A-Z])/', '/_/', '/\\\/'],
                        ['$1-$2', '-', DIRECTORY_SEPARATOR],
                        $relative_class_name
                )
        );

        $filename = MARMOT_THEME_DIR . 'inc/' . $filename . '.php';

        if (is_readable($filename)) {
            // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
            require_once $filename;
        }
    }

    /**
     * Autoload.
     *
     * For a given class, check if it exist and load it.
     *
     * @since 1.0.0
     * @access private
     * @static
     *
     * @param string $class Class name.
     */
    private static function autoload($class) {
        if (0 !== strpos($class, __NAMESPACE__ . '\\')) {
            return;
        }

        $relative_class_name = preg_replace('/^' . __NAMESPACE__ . '\\\/', '', $class);

        $final_class_name = __NAMESPACE__ . '\\' . $relative_class_name;

        if (!class_exists($final_class_name)) {
            self::load_class($relative_class_name);
        }
    }

}
