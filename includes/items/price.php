<?php
$wpt_single_price = false;
//$wpt_single_price .= "<td class='wpt_for_product_action wpt_price'  id='price_value_id_" . $data['id'] . "' data-price_html='" . esc_attr( $product->get_price_html() ) . "'> ";
$wpt_single_price .= '<span class="wpt_product_price">';
$wpt_single_price .= $product->get_price_html(); //Here was woocommerce_template_loop_price() at version 1.0
$wpt_single_price .= '</span>';
//$wpt_single_price .= " </td>";
//var_dump($product->get_price());
echo $wpt_single_price;
