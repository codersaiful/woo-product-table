<?php

$wpt_single_action = false;
if( $table_type == 'advance_table'){
    if ($product_type != 'variation') {
        woocommerce_template_single_add_to_cart();
    }else{
        woocommerce_template_loop_add_to_cart();
    }
}else{
    $variation_in_action = false;
    $table_column_keywords = is_array( $table_column_keywords ) ? $table_column_keywords : array();
    if( 'variable' == $product_type && count( $table_column_keywords ) > 1 ){
        foreach( $table_column_keywords as $wpt_key => $wpt_val ){
            $variation_in_action = isset( $column_settings[$wpt_key]['items'] ) && in_array( 'variations', $column_settings[$wpt_key]['items'] ) ? true : false;
            if($variation_in_action){
                break;
            }
        }
    }
    
    if( 'variable' == $product_type && !$variation_in_action && ! in_array( 'variations', $table_column_keywords) ){
        
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
        
        
        
    }

    $ajax_action_final = ( $product_type == 'grouped' || $product_type == 'external' ? 'no_ajax_action ' : $ajax_action . ' ' );//$ajax_action;
    $add_to_cart_url =  $product->add_to_cart_url();
    
    if( $product_type == 'variable' ){
        $add_to_cart_url = '?add-to-cart=' .  $data['id'];
    }
    
    $target = '_self';
    
    if( $ajax_action !== 'ajax_active ' && !$product_type == 'external'){
        $add_to_cart_url = get_the_permalink( $id ) . '?from=wpt';
        // $target = '_blank';
    }
    /*else{
        $add_to_cart_url =  $product->add_to_cart_url();//'?add-to-cart=' .  $data['id'];//( $ajax_action == 'no_ajax_action' ? '?add-to-cart=' .  $data['id'] : '?add-to-cart=' .  $data['id'] );// '?add-to-cart=' .  $data['id'];
    }
     * 
     */

    $add_to_cart_url = apply_filters( 'wpto_add_to_cart_url', $add_to_cart_url, $settings, $column_settings, $table_ID, $product );
    
    
    $add_to_cart_text_final = ( $product_type == 'grouped' || $product_type == 'external' || $add_to_cart_text == ' ' ? $product->add_to_cart_text() : $add_to_cart_text );//'?add-to-cart=' .  $data['id']; //home_url() .  
    $add_to_cart_text_final = apply_filters( 'wpto_add_to_cart_text', $add_to_cart_text_final, $settings, $column_settings, $table_ID, $product );
    
    if( $product->is_sold_individually() && 0 < wpt_matched_cart_items( $product->get_id() )){


        echo apply_filters( 'wpt_view_cart_link', 
            sprintf( '<a href="%s" class="%s" title="%s">%s</a>',
                esc_url( wc_get_cart_url() ),
                esc_attr( 'added_to_cart wc-forward' ),
                __( 'View Cart', 'woo-product-table' ),
                __( 'View Cart', 'woo-product-table' )
            ), $product, false, false );
    }else{
        echo apply_filters( 'woocommerce_loop_add_to_cart_link',
            sprintf('<a rel="nofollow" data-add_to_cart_url="%s" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s" target="%s">%s</a>', 
                    esc_attr( $add_to_cart_url ),
                    esc_url( $add_to_cart_url ), 
                    esc_attr( $default_quantity ), //1 here was 1 before 2.8
                    esc_attr($product->get_id()), 
                    esc_attr($product->get_sku()), 
                    esc_attr( $ajax_action_final . ( $row_class ? 'wpt_variation_product single_add_to_cart_button button alt disabled wc-variation-selection-needed wpt_woo_add_cart_button' : 'button wpt_woo_add_cart_button ' . $stock_status_class ) ), //ajax_add_to_cart  //|| !$data['price']
                    esc_attr( $target ),
                    esc_html__( $add_to_cart_text_final, 'woo-product-table' )
            ), $product,false,false);
        }
}