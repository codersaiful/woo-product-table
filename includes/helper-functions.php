<?php

if( ! function_exists( 'wpt_ajax_add_to_cart' ) ){

    /**
     * Adding Item by Ajax. This Function is not for using to any others whee.
     * But we will use this function for Ajax
     * 
     * @since 1.0.4
     * @date 28.04.2018 (D.M.Y)
     * @updated 04.05.2018
     */
    function wpt_ajax_add_to_cart() {

        $data = filter_input_array( INPUT_POST );
        
        $data = array_filter( $data );
        
        $product_id     = ( isset($data['product_id']) && !empty( $data['product_id']) ? absint( $data['product_id'] ) : false );
        $quantity       = ( isset($data['quantity']) && !empty( $data['quantity']) && is_numeric($data['quantity']) ? sanitize_text_field( $data['quantity'] ) : 1 );
        $variation_id   = ( isset($data['variation_id']) && !empty( $data['variation_id']) ? absint( $data['variation_id'] ) : false );
        $variation      = ( isset($data['variation']) && !empty( $data['variation']) ? sanitize_text_field( $data['variation'] ) : false );
        $custom_message = ( isset($data['wpt_custom_message']) && !empty( $data['wpt_custom_message']) ? sanitize_text_field( $data['wpt_custom_message'] ) : false );
        $additinal_json = ( isset($data['additional_json']) && !empty( $data['additional_json']) ? $data['additional_json'] : false );

        $cart_item_data = array(); //Set default value array

        if( $custom_message && !empty( $custom_message ) ){
            $custom_message = esc_html( $custom_message );

            /**
             * Custom Message for Product Adding
             * 
             * @since 1.9
             */
            $cart_item_data[ 'wpt_custom_message' ] = $custom_message;
                // below statement make sure every add to cart action as unique line item
            $cart_item_data['unique_key'] = md5( $product_id . $variation_id . '_' .$custom_message );
        }

        $cart_item_data = apply_filters('wpto_cart_meta_by_additional_json', $cart_item_data, $additinal_json, $product_id, $data);

        wpt_adding_to_cart( $product_id, $quantity, $variation_id, $variation, $cart_item_data );
        // var_dump( $product_id, $quantity, $variation_id, $variation, $cart_item_data );
        
        die();
    }
}
add_action( 'wp_ajax_wpt_ajax_add_to_cart', 'wpt_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_wpt_ajax_add_to_cart', 'wpt_ajax_add_to_cart' );

if( ! function_exists( 'wpt_fragment_refresh' ) ){

    /**
     * NEED TO DELETE IT AFTER CHECK FROM CUSTOM JS
     * Getting refresh for fragments
     * 
     * @Since 3.7
     */
    function wpt_fragment_refresh(){

        WC_AJAX::get_refreshed_fragments();
        die();
    }
}
add_action( 'wp_ajax_wpt_fragment_refresh', 'wpt_fragment_refresh' );
add_action( 'wp_ajax_nopriv_wpt_fragment_refresh', 'wpt_fragment_refresh' );


if( ! function_exists( 'wpt_fragment_empty_cart' ) ){

    /**
     * Getting refresh for fragments
     * 
     * @Since 3.7
     */
    function wpt_fragment_empty_cart(){

        global $woocommerce;
        $woocommerce->cart->empty_cart();
        WC_AJAX::get_refreshed_fragments();
        die();
    }
}
add_action( 'wp_ajax_wpt_fragment_empty_cart', 'wpt_fragment_empty_cart' );
add_action( 'wp_ajax_nopriv_wpt_fragment_empty_cart', 'wpt_fragment_empty_cart' );


if( ! function_exists( 'wpt_ajax_multiple_add_to_cart' ) ){

    /**
     * To use in Action Hook for Ajax
     * for Multiple product adding to cart by One click
     * 
     * @since 1.0.4
     * @version 1.0.4
     * @date 3.5.2018
     * return Void
     */
    function wpt_ajax_multiple_add_to_cart() {

        $data = filter_input_array(INPUT_POST);
        $data = array_filter( $data );
        
        $products = false;
        if ( isset( $data['products'] ) && is_array( $data['products'] ) ) {
            $products = $data['products'];
        }
        
        wpt_adding_to_cart_multiple_items( $products );

        die();
    }
}
add_action( 'wp_ajax_wpt_ajax_mulitple_add_to_cart', 'wpt_ajax_multiple_add_to_cart' );
add_action( 'wp_ajax_nopriv_wpt_ajax_mulitple_add_to_cart', 'wpt_ajax_multiple_add_to_cart' );

if( ! function_exists( 'wpt_adding_to_cart' ) ){

    /**
     * Adding Item to cart by Using WooCommerce WC() Static Object
     * WC()->cart->add_to_cart(); Need few Perameters
     * Normally we tried to Check Each/All Action, When Adding
     * 
     * @param Int $product_id
     * @param Int $quantity
     * @param Int $variation_id
     * @param Array $variation
     * @return Void
     */
    function wpt_adding_to_cart( $product_id = 0, $quantity = 1, $variation_id = 0, $variation = array(), $cart_item_data = array() ){

        $cart_item_data = apply_filters('wpto_adding_time_cart_meta', $cart_item_data, $product_id, $quantity, $variation_id);
        $validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation, $cart_item_data );     
        if( $validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation, $cart_item_data ) ){
            $config_value = get_option( WPT_OPTION_KEY );
            if( $config_value['popup_notice'] == '1' ){
                wc_add_notice( '"' . get_the_title( $product_id ) . '" ' . $config_value['add2cart_all_added_text']);
            }

            return true;
        }

        return;
    }
}

if( ! function_exists( 'wpt_print_notice' ) ){
    
    /**
     * Getting notice by ajax, Control this function from custom.js file
     * 
     * @since 3.8
     * @return type data
     */
    function wpt_print_notice(){

        wc_print_notices();
        die();
    }
}
add_action('wp_ajax_wpt_print_notice', 'wpt_print_notice');
add_action('wp_ajax_nopriv_wpt_print_notice', 'wpt_print_notice');

if( ! function_exists( 'wpt_adding_to_cart_multiple_items' ) ){

    /**
     * Adding Multiple product to Cart by One click. So we used an Array
     * Array's each Item has indivisual Array with product_id,variation_id,quantity,variations's array
     * 
     * @param Array $products Product's Array which will use for adding to cart
     * @return Void
     */
    function wpt_adding_to_cart_multiple_items( $products = false ){

        if ( $products && is_array( $products ) ){
            $serial = 0;
            foreach ( $products as $product ) {
                $product_id = ( isset($product['product_id']) && !empty( $product['product_id'] ) ? absint( $product['product_id'] ) : false );
                $quantity = ( isset($product['quantity']) && !empty( $product['quantity'] ) && is_numeric( $product['quantity'] ) ? sanitize_text_field( $product['quantity'] ) : 1 );
                $variation_id = ( isset($product['variation_id']) && !empty( $product['variation_id'] ) ? absint( $product['variation_id'] ) : false );
                $variation = ( isset($product['variation']) && !empty( $product['variation'] ) ? $product['variation'] : false );

                //Added at @Since 1.9
                $custom_message = ( isset($product['wpt_custom_message']) && !empty( $product['wpt_custom_message'] ) ? $product['wpt_custom_message'] : false );
                $additinal_json = ( isset($product['additional_json']) && !empty( $product['additional_json']) ? $product['additional_json'] : false );

                //Added at @Since 1.9
                $cart_item_data = false; //Set default value false, if found Custom message, than it will generate true

                if( $custom_message ){
                    //Added at 2.1
                    $string_for_var = '_var' . $variation && is_array( $variation ) ? implode( '_', $variation ) : $product_id  . '_'; //implode( '_', $variation )

                    $custom_message = esc_html( $custom_message );

                    /**
                     * Custom Message for Product Adding
                     * 
                     * @since 1.9
                     */
                    $cart_item_data[ 'wpt_custom_message' ] = $custom_message; //XSS ok
                        // below statement make sure every add to cart action as unique line item
                    $cart_item_data['unique_key'] = md5( $product_id . $string_for_var . '_' .$custom_message );
                }

                $cart_item_data = apply_filters('wpto_cart_meta_by_additional_json', $cart_item_data, $additinal_json, $product_id, $product);

                wpt_adding_to_cart( $product_id, $quantity, $variation_id, $variation, $cart_item_data );
                $serial++;
            }
            
            if( $serial > 0 ){

                return null;

            }
        }
    }
}

if( ! function_exists( 'wpt_add_custom_message_field' ) ){

    /**
     * Adding Custom Mesage Field in Single Product Page
     * By Default: Disable, if you need, you can active it by enable action under this function
     * 
     * @since 1.9
     * @date 7.6.2018 d.m.y
     */
    function wpt_add_custom_message_field() {
        $status = apply_filters( 'wpt_message_box_in_single_product', true );
        if( ! $status ) return;
        $message = apply_filters( 'wpt_message_box_label_product_page', esc_html__( 'Message', 'woo-product-table' )  );
        global $product;
        $product_id = $product->get_id();
        // var_dump($product->get_id());
        ?>
        <table class="variations wpt-message-box-table" cellspacing="0">
              <tbody>
                  <tr>
                  <td class="label"><label for="custom_message_for<?php echo esc_attr( $product_id ); ?>"><?php echo esc_attr( $message ); ?></label></td>
                  <td class="value">
                      <input id="custom_message_for<?php echo esc_attr( $product_id ); ?>" 
                      class='wpt_custom_message message message_<?php echo esc_attr( $product_id ); ?>'
                      type="text" name="wpt_custom_message" 
                      placeholder="<?php echo esc_attr( $message ); ?>" />                      
                  </td>
              </tr>                               
              </tbody>
          </table>
        <?php
    }
}
/**
 * If you want to show this Field even in Single Product Page,
 * You have to add the following Action Hook.
 * You can use Code Snipet plugin to activate this action
 * or add on theme's functions.php file
 * 
 * Uses:
 * add_action( 'woocommerce_before_add_to_cart_quantity', 'wpt_add_custom_message_field' );
 */


if( ! function_exists( 'wpt_custom_message_validation' ) ){

    /**
     * To set Validation, I mean: Required.
     * By Default: Disable, if you need, you can active it by enable action under this function
     * 
     * @since 1.9
     * @return boolean
     */
    function wpt_custom_message_validation() { 

        if ( isset( $_REQUEST['wpt_custom_message'] ) && empty( $_REQUEST['wpt_custom_message'] ) ) {
            $short_mesg_warning = __( 'Please enter Short Message', 'woo-product-table' );
            $short_mesg_warning = apply_filters( 'wpto_short_message_warning', $short_mesg_warning );
            wc_add_notice( $short_mesg_warning, 'error' );
            return false;
        }
        return true;
    }
}


if( ! function_exists( 'wpt_save_custom_message_field' ) ){

    /**
     * Saving Custom Message Data here
     * 
     * @param type $cart_item_data
     * @param type $product_id
     * @return string
     */
    function wpt_save_custom_message_field( $cart_item_data, $product_id ) {
        
        if( isset( $_REQUEST['wpt_custom_message'] ) && ! empty( $_REQUEST['wpt_custom_message'] ) ) {
            $generated_message = isset( $_REQUEST['wpt_custom_message'] ) ? sanitize_text_field( $_REQUEST['wpt_custom_message'] ) : '';
            $cart_item_data[ 'wpt_custom_message' ] =  $generated_message;
            /* below statement make sure every add to cart action as unique line item */
            $cart_item_data['unique_key'] = $product_id . '_' . $generated_message;
        }
        return $cart_item_data;
    }
}
add_action( 'woocommerce_add_cart_item_data', 'wpt_save_custom_message_field', 10, 2 );


if( ! function_exists( 'wpt_render_meta_on_cart_and_checkout' ) ){
    /**
     * For Displaying custom Message in WooCommerce Cart
     * Need Woo 2.4.2 or updates
     * 
     * @param type $cart_data
     * @param type $cart_item
     * @return Array
     */
    function wpt_render_meta_on_cart_and_checkout( $cart_data, $cart_item = null ) {

        $custom_items = array();
        /* Woo 2.4.2 updates */
        if( !empty( $cart_data ) ) {
            $custom_items = $cart_data;
        }
        if( isset( $cart_item['wpt_custom_message'] ) ) {
            $msg_label = __( 'Message', 'woo-product-table' );
            $args['cart_data'] = $cart_data;
            $args['cart_item'] = $cart_item;
            $msg_label = apply_filters( 'wpto_shortmessage_string',$msg_label, $args );
            $custom_items[] = array( "name" => $msg_label, "value" => $cart_item['wpt_custom_message'] );
        }
        return $custom_items;
    }
}
add_filter( 'woocommerce_get_item_data', 'wpt_render_meta_on_cart_and_checkout', 10, 2 );

if( ! function_exists( 'wpt_order_meta_handler' ) ){

    /**
     * Adding Customer Message to Order
     * 
     * @param type $item_id Session ID of Item's
     * @param type $item Value's Array of Customer message
     * @param type $order_id
     * 
     * @since 1.9 6.6.2018 d.m.y
     * @fixed 8.2.2021 d.m.y fixed to this date
     * @return Void This Function will add Customer Custom Message to Order
     */
    function wpt_order_meta_handler( $item_id, $item, $order_id ) {

        if( ! property_exists( $item, 'legacy_values' ) ) return;
        $values = $item->legacy_values;
        $wpt_custom_message = isset( $values['wpt_custom_message'] ) && !empty( $values['wpt_custom_message'] ) ? $values['wpt_custom_message'] : false;
        if( $wpt_custom_message ) {
            $msg_label = __( 'Message', 'woo-product-table' );
            $args['item_id'] = $item_id;
            $args['values'] = $values;
            $args['item'] = $item;
            $args['cart_item_key'] = $order_id;
            $msg_label = apply_filters( 'wpto_shortmessage_string', $msg_label, $args );
            $unique = md5( $order_id . '_' . $wpt_custom_message);
            wc_add_order_item_meta( $item_id, $msg_label, $wpt_custom_message, $unique );
        }
    }
}
add_action( 'woocommerce_new_order_item', 'wpt_order_meta_handler', 1, 3 );