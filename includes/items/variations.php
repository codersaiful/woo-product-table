<?php
//echo "<div data-temp_number='{$temp_number}' class='{$row_class} wpt_variations wpt_variation_" . $data['id'] . "' data-quantity='1' data-product_id='" . $data['id'] . "' data-product_variations = '" . esc_attr( $data_product_variations ) . "'> ";
//echo $variation_html;
//echo "</div>";

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