<?php
$wpt_nonce = wp_create_nonce( 'add-request-quote-' . $data['id'] );
$default_quantity = apply_filters( 'woocommerce_quantity_input_min', 1, $product );
$quote_class = 'enabled';
if( $product->get_type() == 'variable' ){
    $quote_class = 'variations_button disabled';
}
$Add_to_Quote = $config_value['yith_add_to_quote_text'];//'Add to Quote';
$data_message = '{"text":"'. $Add_to_Quote .'","adding":"' . $config_value['yith_add_to_quote_adding'] . '","added":"' . $config_value['yith_add_to_quote_added'] . '"}';
$c_product_id = $data['id'];

//echo do_shortcode( '[yith_ywraq_button_quote product="' . $c_product_id . '"]' );
$q_final_class = "{$quote_class} yith_request_temp_{$temp_number}_id_{$data['id']} wpt_yith_add_to_quote_request wpt_add-request-quote-button";
?>

<div class="yith-ywraq-add-to-quote add-to-quote-<?php echo esc_attr( $c_product_id ); ?>">
    <div class="yith-ywraq-add-button show <?php echo esc_attr( $q_final_class ); ?>" style="display:block">
        <a href="#" class="add-request-quote-button button" data-product_id="<?php echo esc_attr( $c_product_id ); ?>" data-wp_nonce="<?php echo esc_attr( $wpt_nonce ); ?>">
        <?php echo esc_html( $Add_to_Quote ); ?>
        </a>
        <img src="<?php echo esc_url( plugins_url( '/yith-woocommerce-request-a-quote/assets/images/wpspin_light.gif' ) ); ?>" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden">
    </div>
</div>