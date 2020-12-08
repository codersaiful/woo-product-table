<?php
$wpt_single_action = false;
if( $table_type == 'advance_table'){

    woocommerce_template_single_add_to_cart();

}else{
    $variation_in_action = false;
    if( 'variable' == $product_type && is_array( $table_column_keywords ) && count( $table_column_keywords ) > 1 ){
        foreach( $table_column_keywords as $wpt_key => $wpt_val ){
            $variation_in_action = isset( $column_settings[$wpt_key]['items'] ) && in_array( 'variations', $column_settings[$wpt_key]['items'] ) ? true : false;
            if($variation_in_action){
                break;
            }
            
        }
    }
    //var_dump($variation_in_action);
    //var_dump($keyword,$table_column_keywords);
    if( 'variable' == $product_type && !$variation_in_action && !in_array( 'variations', $table_column_keywords) ){
        
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
        
        
        /**
         * 
        // Enqueue variation scripts.
		wp_enqueue_script( 'wc-add-to-cart-variation' );

		// Get Available variations?
		$get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

//		// Load the template.
//		wc_get_template(
//			'single-product/add-to-cart/variable.php',
//			array(
//				'available_variations' => $get_variations ? $product->get_available_variations() : false,
//				'attributes'           => $product->get_variation_attributes(),
//				'selected_attributes'  => $product->get_default_attributes(),
//			)
//		);
         */
    }

    $ajax_action_final = ( $product_type == 'grouped' || $product_type == 'external' ? 'no_ajax_action ' : $ajax_action . ' ' );//$ajax_action;
    $add_to_cart_url =  $product->add_to_cart_url();
    if( $product_type == 'variable' ){
        $add_to_cart_url = '?add-to-cart=' .  $data['id'];
    }
    $target = '_self';
    if( $ajax_action !== 'ajax_active ' ){
        $add_to_cart_url = get_the_permalink( $id ) . '?from=wpt';
        $target = '_blank';
    }
    /*else{
        $add_to_cart_url =  $product->add_to_cart_url();//'?add-to-cart=' .  $data['id'];//( $ajax_action == 'no_ajax_action' ? '?add-to-cart=' .  $data['id'] : '?add-to-cart=' .  $data['id'] );// '?add-to-cart=' .  $data['id'];
    }
     * 
     */
    $add_to_cart_url = apply_filters( 'wpto_add_to_cart_url', $add_to_cart_url, $settings, $column_settings, $table_ID, $product );
    
    
    $add_to_cart_text_final = ( $product_type == 'grouped' || $product_type == 'external' || $add_to_cart_text == ' ' ? $product->add_to_cart_text() : $add_to_cart_text );//'?add-to-cart=' .  $data['id']; //home_url() .  
    $add_to_cart_text_final = apply_filters( 'wpto_add_to_cart_text', $add_to_cart_text_final, $settings, $column_settings, $table_ID, $product );
    
    echo apply_filters('woocommerce_loop_add_to_cart_link', 
            sprintf('<a rel="nofollow" data-add_to_cart_url="%s" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s" target="%s">%s</a>', 
                    esc_attr( $add_to_cart_url ),
                    esc_url( $add_to_cart_url ), 
                    esc_attr( $default_quantity ), //1 here was 1 before 2.8
                    esc_attr($product->get_id()), 
                    esc_attr($product->get_sku()), 
                    esc_attr( $ajax_action_final . ( $row_class ? 'wpt_variation_product single_add_to_cart_button button alt disabled wc-variation-selection-needed wpt_woo_add_cart_button' : 'button wpt_woo_add_cart_button ' . $stock_status_class ) ), //ajax_add_to_cart  //|| !$data['price']
                    esc_html( $target ),
                    esc_html( $add_to_cart_text_final )
            ), $product,false,false);
}