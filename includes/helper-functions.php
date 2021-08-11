<?php
if( !function_exists( 'wpt_ajax_paginate_links_load' ) ){
    /**
     * Loading paginate lins for product table
     * for ajax
     * 
     * @return String it will render paginate link
     */
    function wpt_ajax_paginate_links_load(){

        $filter_args = array(
            'action' => FILTER_SANITIZE_STRING,
            'load_type' => FILTER_SANITIZE_STRING,
            'temp_number' => FILTER_SANITIZE_NUMBER_INT,
            'pageNumber' => FILTER_SANITIZE_NUMBER_INT,
            'targetTableArgs' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'directkey' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'texonomies' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            
            'custom_field' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            
        );
        
        $data = filter_input_array(INPUT_POST,$filter_args);
        $data = array_filter( $data );
        
        $targetTableArgs = ( isset( $data['targetTableArgs'] ) ? $data['targetTableArgs'] : false );
        $temp_number = ( isset( $data['temp_number'] ) ? absint( $data['temp_number'] ) : false );   
        $directkey = ( isset( $data['directkey'] ) && is_array( $data['directkey'] ) ? $data['directkey'] : false ); //Already Filterized
        $texonomies = ( isset( $data['texonomies'] ) && is_array( $data['texonomies']) ? $data['texonomies'] : false );//Already Filterized
        $custom_field = ( isset( $data['custom_field'] ) && is_array( $data['custom_field']) ? $data['custom_field'] : false );//Already Filterized
        $pageNumber = ( isset( $data['pageNumber'] ) && $data['pageNumber'] > 0 ? absint( $data['pageNumber'] ) : 1 );
        $load_type = ( isset( $data['load_type'] ) && $data['load_type'] == 'current_page' ? true : false );

        $args = $targetTableArgs['args'];
        $args['wpt_query_type'] = 'search';//Added on 6.0.3 - 12.6.2020
        ###global $wpdb;
        ###var_dump($wpdb['last_query']);
        ###echo '<pre>';
        ###print_r($wpdb['last_query']);
        ###echo '</pre>';
        
        $table_ID = $args['table_ID'];
        $search_from = get_post_meta( $table_ID, 'search_n_filter', true );

        $search_from = isset( $search_from['search_from'] ) && is_array( $search_from['search_from'] ) && count( $search_from['search_from'] ) > 0 ? $search_from['search_from'] : false;

        $search_key = isset( $directkey['s'] ) && !empty( $directkey['s'] ) ? sanitize_text_field( $directkey['s'] ) : "";

        
        if( !$load_type ){
            
            $args['wpt_custom_search'] = $search_key; //XSS OK //Already sanitized as text field
            $args['s'] = $search_key; //XSS OK //Already sanitized as text field

        if( !empty($search_key) && $search_from){
            $args['wpt_custom_search'] = $search_key;//XSS OK
            $args['s'] = false;
        }elseif(!empty($search_key) && !$search_from){
            $args['wpt_custom_search'] = false;
            $args['s'] = $search_key; //XSS OK
        }
            //$args['orderby'] = ( isset( $directkey['orderby'] ) ? $directkey['orderby'] : false );
            //$args['order'] = ( isset( $directkey['order'] ) ? $directkey['order'] : false );
            /**
             * Texonomy Handle
             */
            /*
            //unset($args['tax_query']);
            if( is_array( $texonomies ) && count( $texonomies ) > 0 ){
                foreach( $texonomies as $texonomie_key => $texonomie ){
                    if(is_array( $texonomie ) && count( $texonomie ) > 0 ){
                        $args['tax_query'][] = array(
                            'taxonomy' => $texonomie_key,
                            'field' => 'id',
                            'terms' => $texonomie,
                            'operator' => 'IN'
                        );
                    }
                }
            }
            $args['tax_query']['relation'] = 'AND';

            */

            /*
              //unset($args['meta_query']);
            if( is_array( $custom_field ) && count( $custom_field ) > 0 ){
                foreach( $custom_field as $custom_field_key => $custom_field_value ){
                    if(is_array( $texonomie ) && count( $texonomie ) > 0 ){
                        $args['meta_query'][] = array(
                            'key' => $custom_field_key,
                            'value' => $custom_field_value,
                        );
                    }
                }
                $args['meta_query']['relation'] ='AND';
            }
            */
        }

        /**
         * Page Number Hander
         */
        /**
         * All Var Already filtered/sanitized
         * using filter_var_array and sanitize_text_field
         * 
         * @since 2.9.1
         */
        $args['paged']   = $pageNumber;
        $table_column_keywords  = $targetTableArgs['wpt_table_column_keywords'];
        $sort                       = $args['order'];
        $wpt_permitted_td           = $targetTableArgs['wpt_permitted_td'];
        $add_to_cart_text           = $targetTableArgs['wpt_add_to_cart_text'];

        $texonomy_key               = isset( $targetTableArgs['texonomy_key'] ) ? $targetTableArgs['texonomy_key'] : false;
        $customfield_key            = isset( $targetTableArgs['customfield_key'] ) && is_array( $targetTableArgs['customfield_key'] ) ? $targetTableArgs['customfield_key'] : false;
        $filter_keywords            = $targetTableArgs['filter_key'];
        $filter_box                 = $targetTableArgs['filter_box'];
        $description_type           = $targetTableArgs['description_type'];
        $ajax_action                = $targetTableArgs['ajax_action'];
        $table_type           = $targetTableArgs['table_type'];


        $checkbox                 = $targetTableArgs['checkbox'];

        
        /**
         * For Search, we will remove post per page
         * and will set unlimited 
         * 
         * I have checked it based on search key
         */
        if( ! empty( $search_key ) && $search_from ){
            $args['posts_per_page'] = '-1';
        }else{
            $conditions = get_post_meta( $table_ID, 'conditions', true );
            $args['posts_per_page'] = (int) $conditions['posts_per_page'];
        }
        
        $table_row_generator_array = array(
            'args'                      => $args,
            'wpt_table_column_keywords' => $table_column_keywords,
            'wpt_product_short'         => $sort,
            'wpt_permitted_td'          => $wpt_permitted_td,
            'wpt_add_to_cart_text'      => $add_to_cart_text,
            'temp_number'               => $temp_number,
            'texonomy_key'              => $texonomy_key,
            'customfield_key'           => $customfield_key,
            'filter_key'                => $filter_keywords,
            'filter_box'                => $filter_box,
            'description_type'          => $description_type,
            'ajax_action'               => $ajax_action,
            'table_type'            => $table_type, //$table_type           = $targetTableArgs['table_type'];
            'checkbox'            => $checkbox, 
        );
        echo '<mypagi myjson="'. esc_attr( wp_json_encode( $table_row_generator_array ) ) .'">'. wpt_paginate_links( $args ) . '</mypagi>';
        die();
    }
}
add_action( 'wp_ajax_wpt_ajax_paginate_links_load', 'wpt_ajax_paginate_links_load' );
add_action( 'wp_ajax_nopriv_wpt_ajax_paginate_links_load', 'wpt_ajax_paginate_links_load' );

if( !function_exists( 'wpt_ajax_table_row_load' ) ){
    /**
     * Table Load by ajax Query before on Tables Top
     * 
     * @since 1.9
     */
    function wpt_ajax_table_row_load(){

        $filter_args = array(
            'action' => FILTER_SANITIZE_STRING,
            'load_type' => FILTER_SANITIZE_STRING,
            'temp_number' => FILTER_SANITIZE_NUMBER_INT,
            'pageNumber' => FILTER_SANITIZE_NUMBER_INT,
            'targetTableArgs' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'directkey' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'texonomies' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            
            'custom_field' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            
        );
        
        $data = filter_input_array(INPUT_POST,$filter_args);
        $data = array_filter( $data );
        
        $targetTableArgs = ( isset( $data['targetTableArgs'] ) && is_array( $data['targetTableArgs'] ) ? $data['targetTableArgs'] : false );
        $temp_number = ( isset( $data['temp_number'] ) ? absint( $data['temp_number'] ) : false );
        $directkey = ( isset( $data['directkey'] ) && is_array( $data['directkey'] ) ? $data['directkey'] : false );
        $texonomies = ( isset( $data['texonomies'] ) && is_array( $data['texonomies'] ) ? $data['texonomies'] : false );
        $custom_field = ( isset( $data['custom_field'] ) && is_array( $data['custom_field'] ) ? $data['custom_field'] : false );
        $pageNumber = ( isset( $data['pageNumber'] ) && $data['pageNumber'] > 0 ? absint( $data['pageNumber'] ) : 1 );
        $load_type = ( isset( $data['load_type'] ) && $data['load_type'] == 'current_page' ? true : false );

        $args = $targetTableArgs['args'];
        $args['wpt_query_type'] = 'search';//Added on 6.0.3 - 12.6.2020

        $table_ID = $args['table_ID'];
        $search_from = get_post_meta( $table_ID, 'search_n_filter', true );
        $search_from = isset($search_from['search_from']) && is_array( $search_from['search_from'] ) && count( $search_from['search_from'] ) > 0 ? $search_from['search_from'] : false;

        $search_key = isset( $directkey['s'] ) && !empty( $directkey['s'] ) ? sanitize_text_field( $directkey['s'] ) : "";
    
        
        if( !$load_type ){

        
        $args['wpt_custom_search'] = $search_key; //XSS ok
        $args['s'] = $search_key; //XSS ok

        if( !empty($search_key) && $search_from){
            $args['wpt_custom_search'] = $search_key; //XSS ok
            $args['s'] = false;
        }elseif(!empty($search_key) && !$search_from){
            $args['wpt_custom_search'] = false;
            $args['s'] = $search_key; //XSS ok
        }


        //var_dump($search_from);
        //var_dump($args);


            //$args['orderby'] = ( isset( $directkey['orderby'] ) ? $directkey['orderby'] : false );
            //$args['order'] = ( isset( $directkey['order'] ) ? $directkey['order'] : false );
            //$args['custom_field'] = ( isset( $directkey['custom_field'] ) ? $directkey['custom_field'] : false );
            /**
             * Texonomy Handle
             */
            //unset($args['tax_query']);
            /*
            if( is_array( $texonomies ) && count( $texonomies ) > 0 ){
                foreach( $texonomies as $texonomie_key => $texonomie ){
                    if(is_array( $texonomie ) && count( $texonomie ) > 0 ){
                        $args['tax_query'][] = array(
                            'taxonomy' => $texonomie_key,
                            'field' => 'id',
                            'terms' => $texonomie,
                            'operator' => 'IN'
                        );
                    }
                }
            }
            */
            //$args['tax_query']['relation'] = 'AND';


            /*
              //unset($args['meta_query']);
            if( is_array( $custom_field ) && count( $custom_field ) > 0 ){
                foreach( $custom_field as $custom_field_key => $custom_field_value ){
                    if(is_array( $custom_field ) && count( $custom_field ) > 0 ){
                        $args['meta_query'][] = array(
                            'key' => $custom_field_key,
                            'value' => $custom_field_value,
                        );
                    }
                }
                $args['meta_query']['relation'] ='AND';
            }
            */


        }
        
        if( !empty( $directkey ) && isset( $directkey['orderby'] ) && isset( $directkey['order'] ) ){
            $args['orderby'] = sanitize_text_field( $directkey['orderby'] );
            $args['order'] = sanitize_text_field( $directkey['order'] );
        }
        
        /**
         * Page Number Hander
         */
        /**
         * All var already filtered
         * using filter_var_array and sanitize_text_field
         */
        $args['paged']   = $pageNumber;
        $table_column_keywords  = $targetTableArgs['wpt_table_column_keywords'];
        $sort                       = $args['order'];
        $wpt_permitted_td           = $targetTableArgs['wpt_permitted_td'];
        $add_to_cart_text           = $targetTableArgs['wpt_add_to_cart_text'];
        $texonomy_key               = isset( $targetTableArgs['texonomy_key'] ) ? $targetTableArgs['texonomy_key'] : false;
        $customfield_key            = isset( $targetTableArgs['customfield_key'] ) && is_array( $targetTableArgs['customfield_key'] ) ? $targetTableArgs['customfield_key'] : false;
        $filter_keywords            = $targetTableArgs['filter_key'];
        $filter_box                 = $targetTableArgs['filter_box'];
        $description_type           = $targetTableArgs['description_type'];
        $ajax_action                = $targetTableArgs['ajax_action'];
        $table_type           = $targetTableArgs['table_type'];
        $checkbox                 = $targetTableArgs['checkbox'];

        /**
         * For Search, we will remove post per page
         * and will set unlimited 
         * 
         * I have checked it based on search key
         */

        if( ! empty( $search_key ) && $search_from ){
            $args['posts_per_page'] = '-1';
        }else{
            $conditions = get_post_meta( $args['table_ID'], 'conditions', true );
            $args['posts_per_page'] = (int) $conditions['posts_per_page'];
        }
   
        $table_row_generator_array = array(
            'args'                      => $args,
            'wpt_table_column_keywords' => $table_column_keywords,
            'wpt_product_short'         => $sort,
            'wpt_permitted_td'          => $wpt_permitted_td,
            'wpt_add_to_cart_text'      => $add_to_cart_text,
            'temp_number'               => $temp_number,
            'texonomy_key'              => $texonomy_key,
            'customfield_key'           => $customfield_key,
            'filter_key'                => $filter_keywords,
            'filter_box'                => $filter_box,
            'description_type'          => $description_type,
            'ajax_action'               => $ajax_action,
            'table_type'            => $table_type,
            'checkbox'            => $checkbox, 
            //'custom_field'            => $custom_field,
        );

        echo wpt_table_row_generator( $table_row_generator_array );

        die();
    }
}
add_action( 'wp_ajax_wpt_query_table_load_by_args', 'wpt_ajax_table_row_load' );
add_action( 'wp_ajax_nopriv_wpt_query_table_load_by_args', 'wpt_ajax_table_row_load' );

if( !function_exists( 'wpt_ajax_add_to_cart' ) ){
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
        $custom_message = ( isset($data['custom_message']) && !empty( $data['custom_message']) ? sanitize_text_field( $data['custom_message'] ) : false );

        //$string_for_var = '_var' . implode('_', $variation) . '_';

        $cart_item_data = array(); //Set default value array

        if( $custom_message && !empty( $custom_message ) ){
            $custom_message = esc_html( $custom_message );
            /**
             * Custom Message for Product Adding
             * 
             * @since 1.9
             */
            $cart_item_data[ 'wpt_custom_message' ] = $custom_message; //XSS ok
                // below statement make sure every add to cart action as unique line item
            $cart_item_data['unique_key'] = md5( $product_id . $variation_id . '_' .$custom_message );
        }

        wpt_adding_to_cart( $product_id, $quantity, $variation_id, $variation, $cart_item_data );
        wpt_fragment_refresh();
        die();
    }
}
add_action( 'wp_ajax_wpt_ajax_add_to_cart', 'wpt_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_wpt_ajax_add_to_cart', 'wpt_ajax_add_to_cart' );

if( !function_exists( 'wpt_fragment_refresh' ) ){
    /**
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

if( !function_exists( 'wpt_variation_image_load' ) ){
    /**
     * Getting Image URL and with info for variation images
     * 
     * @Since 3.7
     */
    function wpt_variation_image_load(){
        $variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : false;
        if( $variation_id ){
            $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $variation_id ), 'full', false );   
            echo esc_url( $img_src[0] ) . ' ' . esc_html( $img_src[1] );
        }

        die();
    }
}
add_action( 'wp_ajax_wpt_variation_image_load', 'wpt_variation_image_load' );
add_action( 'wp_ajax_nopriv_wpt_variation_image_load', 'wpt_variation_image_load' );

if( !function_exists( 'wpt_ajax_multiple_add_to_cart' ) ){
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

if( !function_exists( 'wpt_adding_to_cart' ) ){
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

        $validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation, $cart_item_data );     
        if( $validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation, $cart_item_data ) ){
            $config_value = get_option( 'wpt_configure_options' );
            if( $config_value['popup_notice'] == '1' ){
                wc_add_notice( '"' . get_the_title( $product_id ) . '" ' . $config_value['add2cart_all_added_text']);
            }
            return true;
        }
        return;
    }
}

if( !function_exists( 'wpt_print_notice' ) ){
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

if( !function_exists( 'wpt_adding_to_cart_multiple_items' ) ){
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
                $custom_message = ( isset($product['custom_message']) && !empty( $product['custom_message'] ) ? $product['custom_message'] : false );



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
                wpt_adding_to_cart( $product_id, $quantity, $variation_id, $variation, $cart_item_data );
                $serial++;
            }
            wpt_fragment_refresh(); 
            if( $serial > 0 ){
                return false;
            }
        }
    }
}

if( !function_exists( 'wpt_add_custom_message_field' ) ){
    /**
     * Adding Custom Mesage Field in Single Product Page
     * By Default: Disable, if you need, you can active it by enable action under this function
     * 
     * @since 1.9
     * @date 7.6.2018 d.m.y
     */
    function wpt_add_custom_message_field() {
        echo '<table class="variations" cellspacing="0">
              <tbody>
                  <tr>
                  <td class="label"><label for="custom_message">'.esc_html__( 'Message', 'wpt_pro' ).'</label></td>
                  <td class="value">
                      <input id="custom_message" type="text" name="wpt_custom_message" placeholder="'.esc_attr__( 'Short Message for Order', 'wpt_pro' ).'" />                      
                  </td>
              </tr>                               
              </tbody>
          </table>';
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


if( !function_exists( 'wpt_custom_message_validation' ) ){
    /**
     * To set Validation, I mean: Required.
     * By Default: Disable, if you need, you can active it by enable action under this function
     * 
     * @since 1.9
     * @return boolean
     */
    function wpt_custom_message_validation() { 

        if ( isset( $_REQUEST['wpt_custom_message'] ) && empty( $_REQUEST['wpt_custom_message'] ) ) {
            $short_mesg_warning = __( 'Please enter Short Message', 'wpt_pro' );
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
        
        if( isset( $_REQUEST['wpt_custom_message'] ) ) {
            $generated_message = esc_html( $_REQUEST['wpt_custom_message'] );
            $cart_item_data[ 'wpt_custom_message' ] =  $generated_message; //XSS ok
            /* below statement make sure every add to cart action as unique line item */
            $cart_item_data['unique_key'] = $product_id . '_' . $generated_message;//md5( microtime().rand() );
        }
        return $cart_item_data;
    }
}
add_action( 'woocommerce_add_cart_item_data', 'wpt_save_custom_message_field', 10, 2 );


if( !function_exists( 'wpt_render_meta_on_cart_and_checkout' ) ){
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
            $msg_label = __( 'Message', 'wpt_pro' );
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
        $values = $item->legacy_values;
        $wpt_custom_message = isset( $values['wpt_custom_message'] ) && !empty( $values['wpt_custom_message'] ) ? $values['wpt_custom_message'] : false;
        if( $wpt_custom_message ) {
            $msg_label = __( 'Message', 'wpt_pro' );
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