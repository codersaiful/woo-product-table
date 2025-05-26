<?php
global $product;
$wpt_single_price = false;

$wpt_single_price .= '<span class="wpt_product_price">';
$wpt_single_price .= $product->get_price_html(); //Here was woocommerce_template_loop_price() at version 1.0
$wpt_single_price .= '</span>';

echo wp_kses_post( $wpt_single_price );
