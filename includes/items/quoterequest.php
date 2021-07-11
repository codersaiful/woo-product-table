<?php

if( defined( 'YITH_YWRAQ_PREMIUM' ) ){
    echo do_shortcode( '[yith_ywraq_button_quote product="' . $id . '"]' );
    return;
}
$wpt_nonce = wp_create_nonce( 'add-request-quote-' . $data['id'] );
$default_quantity = apply_filters( 'woocommerce_quantity_input_min', 1, $product );
$quote_class = 'enabled';
if( $product->get_type() == 'variable' ){
    $quote_class = 'variations_button disabled';
}

$c_product_id = $data['id'];
$Add_to_Quote = $config_value['yith_add_to_quote_text'];//'Add to Quote';
$data_message = '{"text":"'. $Add_to_Quote .'","adding":"' . $config_value['yith_add_to_quote_adding'] . '","added":"' . $config_value['yith_add_to_quote_added'] . '"}';

$q_final_class = "{$quote_class} yith_request_temp_{$temp_number}_id_{$data['id']} wpt_yith_add_to_quote_request wpt_add-request-quote-button";

?>
<a data-yith_browse_list='<?php echo esc_attr( $config_value['yith_browse_list'] ); ?>' 
   data-response_msg='' 
   data-msg='<?php echo esc_attr( $data_message ); ?>' 
   data-wp_nonce='<?php echo esc_attr( $wpt_nonce ); ?>' 
   data-quote_data='' 
   data-variation='' 
   data-variation_id='' 
   data-product_id='<?php echo esc_attr( $data['id'] ); ?>' 
   class='<?php echo esc_attr( "{$quote_class} yith_request_temp_{$temp_number}_id_{$data['id']} wpt_yith_add_to_quote_request wpt_add-request-quote-button button" ); ?>' 
   href='#' 
   data-quantity='<?php echo esc_attr( $default_quantity ); ?>' 
   data-selector='<?php echo esc_attr( "yith_request_temp_{$temp_number}_id_{$data['id']}" ); ?>'>
   <?php echo esc_html( $Add_to_Quote ); ?>
</a>
