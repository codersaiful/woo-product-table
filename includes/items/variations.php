<?php
if ( $product->get_type() == 'variation' ) {
    $variation = wc_get_product( $id );
    if(method_exists($variation, 'get_attribute_summary')){
    echo wp_kses_post( "<strong class='wpt-product-variation-name wpt-pvn-{$id}'>{$variation->get_attribute_summary()}</strong>" );
    }
    return;
}
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