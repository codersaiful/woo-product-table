<?php

namespace WOO_PRODUCT_TABLE;

defined('ABSPATH') || exit;

/**
 * Autoloader: All class will call from here by AutoLoader
 *
 * @author Saiful Islam<codersaiful@gmail.com>
 * @since 3.2.4.1
 * @package Woo Product Table
 * @link https://www.php.net/manual/en/language.oop5.autoload.php Autoloader Function
 */
class Autoloader {
    

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
        spl_autoload_register([ __CLASS__ , 'autoload' ]);
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
    private static function autoload( $class ) {
        
        if (0 !== strpos( $class, __NAMESPACE__ ) ) {
            return;
        }


        $filename = strtolower(
                preg_replace(
                        ['/\b' . __NAMESPACE__ . '\\\/', '/_/', '/\\\/'], ['', '-', DIRECTORY_SEPARATOR], $class
                )
        );

        
        $_dir = str_replace( '\\', '/', dirname( __FILE__ ) . '/' );
        $_filename = $_dir . $filename . '.php';
        $_filename = realpath( $_filename );

        if ( is_readable( $_filename ) ) {
            require_once $_filename;
        }

    }

}

Autoloader::run();