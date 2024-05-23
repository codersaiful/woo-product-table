<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;
echo do_shortcode("[Product_Table_Empty id='2671' name='Music Table']");

// do_action('wp_head');

// echo do_shortcode("[Product_Table id='2671' name='Shop Page table']");

// /**
//  * Hook: woocommerce_after_main_content.
//  *
//  * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
//  */
// // do_action( 'woocommerce_after_main_content' );


// do_action('wp_footer');