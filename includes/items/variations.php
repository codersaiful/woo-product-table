<?php

/**
 * Variation HTML is handled by new file
 * we have followed woocommerce default code
 * 
 * @since 2.7.8
 */
$variation_html_file = WPT_BASE_DIR . 'includes/variation_html.php';
if( is_file( $variation_html_file ) ){
    include $variation_html_file;
}