<?php

if( defined( 'YITH_YWRAQ_PREMIUM' ) && function_exists( 'yith_ywraq_render_button' ) ){

    if ( ! wp_script_is( 'enqueued', 'yith_ywraq_frontend' ) ) {
        wp_enqueue_style( 'yith_ywraq_frontend' );
    }
    $atts = array( 'product' => $id );
    $args = shortcode_atts(
        array(
            'product' => false,
            'label'   => get_option( 'ywraq_show_btn_link_text', __( 'Add to quote', 'yith-woocommerce-request-a-quote' ) ),
            'style'   => ( get_option( 'ywraq_show_btn_link' ) === 'button' ) ? 'button' : 'ywraq-link',
            'colors'  => get_option(
                'ywraq_add_to_quote_button_color',
                array(
                    'bg_color'       => '#0066b4',
                    'bg_color_hover' => '#044a80',
                    'color'          => '#ffffff',
                    'color_hover'    => '#ffffff',
                )
            ),
            'icon'    => 0,

        ),
        $atts
    );

    if ( 'button' === $args['style'] ) {
        if ( isset( $atts['bg_color'] ) ) {
            $args['colors']['bg_color'] = $atts['bg_color'];
        }
        if ( isset( $atts['bg_color_hover'] ) ) {
            $args['colors']['bg_color_hover'] = $atts['bg_color_hover'];
        }
        if ( isset( $atts['color'] ) ) {
            $args['colors']['color'] = $atts['color'];
        }

        if ( isset( $atts['color_hover'] ) ) {
            $args['colors']['color_hover'] = $atts['color_hover'];
        }
    }    
    yith_ywraq_render_button( $args['product'], $args );

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
