<?php
$wpt_nonce = wp_create_nonce( 'add-request-quote-' . $data['id'] );
$default_quantity = apply_filters( 'woocommerce_quantity_input_min', 1, $product );
$quote_class = 'enabled';
if( $product->get_type() == 'variable' ){
    $quote_class = 'variations_button disabled';
}
$Add_to_Quote = $config_value['yith_add_to_quote_text'];//'Add to Quote';
$data_message = '{"text":"'. $Add_to_Quote .'","adding":"' . $config_value['yith_add_to_quote_adding'] . '","added":"' . $config_value['yith_add_to_quote_added'] . '"}';
echo "<a data-yith_browse_list='{$config_value['yith_browse_list']}' data-response_msg='' data-msg='{$data_message}' data-wp_nonce='{$wpt_nonce}' data-quote_data='' data-variation='' data-variation_id='' data-product_id='{$data['id']}' class='{$quote_class} yith_request_temp_{$temp_number}_id_{$data['id']} wpt_yith_add_to_quote_request wpt_add-request-quote-button button' href='#' data-quantity='{$default_quantity}' data-selector='yith_request_temp_{$temp_number}_id_{$data['id']}'>{$Add_to_Quote}</a>";