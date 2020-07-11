<?php


            /**
             * Define Serial Number for Each Row
             * 
             * @since 1.0
             */
            if ( isset( $wpt_permitted_td['product_id'] ) ) {
                $wpt_each_row['product_id'] = "<td class='wpt_for_product_desc wpt_product_id'> {$id} </td>";
            }
            
            /**
             * Define Serial Number for Each Row
             * 
             * @since 1.0
             */
            if ( isset( $wpt_permitted_td['serial_number'] ) ) {
                $wpt_each_row['serial_number'] = "<td class='wpt_serial_number'> $wpt_table_row_serial </td>";
            }
            
            $variable_class = $product_type.'_product';//$product->get_type();

            /**
             * Define Custom Message to send Customer
             * 
             * @since 1.9
             * @date: 7/6/2018 d/m/y
             */
            if ( isset( $wpt_permitted_td['Message'] ) ) {
                $wpt_each_row['Message'] = "<td  class='wpt_Message'><input type='text' class='message message_{$temp_number}' id='message' placeholder='" . $config_value['type_your_message'] . "'></td>";
                //$wpt_each_row['Message'] = "<td  class='wpt_Message'><input type='text' class='message message_{$temp_number}' id='message' placeholder='" . __('Type your Message.') . "'></td>";
            }
             
            /**
             * Define Weight for Each Row
             * 
             * @since 1.0.4
             * @date: 5/5/2018
             */
            if ( isset( $wpt_permitted_td['weight'] ) ) {
                $wpt_each_row['weight'] = "<td data-weight_backup='" . $data['weight'] . "' data-weight='" . $data['weight'] . "' class='wpt_for_product_desc wpt_weight {$variable_class}'> " . $data['weight'] . " </td>";
            }
               
            /**
             * Define Length for Each Row
             * 
             * @since 1.0.4
             * @date: 5/5/2018
             */
            if ( isset( $wpt_permitted_td['length'] ) ) {
                $wpt_each_row['length'] = "<td data-length='" . $data['length'] . "' class='wpt_for_product_desc wpt_length {$variable_class}'> " . $data['length'] . " </td>";
            }
                
            /**
             * Define width for Each Row
             * 
             * @since 1.0.4
             * @date: 5/5/2018
             */
            if ( isset( $wpt_permitted_td['width'] ) ) {
                $wpt_each_row['width'] = "<td data-width='" . $data['width'] . "' class='wpt_for_product_desc wpt_width {$variable_class}'> " . $data['width'] . " </td>";
            }
                
            /**
             * Define height for Each Row
             * 
             * @since 1.0.4
             * @date: 5/5/2018
             */
            if ( isset( $wpt_permitted_td['height'] ) ) {
                $wpt_each_row['height'] = "<td data-height='" . $data['height'] . "' class='wpt_for_product_desc wpt_height {$variable_class}'> " . $data['height'] . " </td>";
            }
            
            /**
             * Added version 3.1
             * 
             * @since 3.1
             */
            if ( isset( $wpt_permitted_td['quick'] ) ) {
                $wpt_each_row['quick'] = '<td class="wpt_for_product_action wpt_quick"><a href="#" class="button yith-wcqv-button" data-product_id="' . $data['id'] . '">' . $config_value['quick_view_btn_text'] . '</a></td>';
                //<a href="#" class="button yith-wcqv-button" data-product_id="' . $data['id'] . '">Quick</a>
            }
                
            /**
             * Define Stock Status for Each Product
             * 
             * @since 1.0.4
             * @date 28/04/2018
             */
            if ( isset( $wpt_permitted_td['stock'] ) ) {
                $stock_status_message = $stock_status_message = $config_value['table_out_of_stock'];
                if( $data['stock_status'] == 'instock' ){
                   $stock_status_message =  $data['stock_quantity'] . ' ' . $config_value['table_in_stock']; 
                }elseif( $data['stock_status'] == 'onbackorder' ){
                    $stock_status_message = $config_value['table_on_back_order'];//'On Back Order';
                }
                $wpt_each_row['stock'] = "<td class='wpt_stock wpt_for_product_action'> <span class='{$data['stock_status']}'>" . $stock_status_message . " </span></td>";
            }
               
            /**
             * Product Title Display with Condition
             *  valign="middle"
             */
            if ( isset( $wpt_permitted_td['thumbnails'] ) ) {
                $wpt_single_thumbnails = false;
                $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full', false );   
                $img_attr = $img_src ? " data-url='{$img_src[0]}' data-width='{$img_src[1]}' data-height='{$img_src[2]}' " : '';
                
                $thumbs_img = woocommerce_get_product_thumbnail( array( $config_value['thumbs_image_size'], $config_value['thumbs_image_size'] ) );
                
                if($thumb_variation == 'quick_view'){              
                    $thumb_variation = 'quick_view yith-wcqv-button';
                }elseif($thumb_variation == 'url'){
                    $thumbs_img = "<a href='" . esc_url(get_the_permalink()) . "' target='{$config_value['product_link_target']}'>" . $thumbs_img . '</a>';
                }

                $wpt_single_thumbnails .= "<td valign='middle' class='wpt_for_thumbs_desc wpt_thumbnails wpt_thumbnails_" . esc_attr( $thumb_variation ) . "' data-product_id=" . $data['id'] . " {$img_attr}>";
                $wpt_single_thumbnails .= $thumbs_img;
                $wpt_single_thumbnails .= "</td>";
                
                $wpt_each_row['thumbnails'] = $wpt_single_thumbnails;
                
            }
            
            /**
             * Product Title Display with Condition
             */
            if ( isset( $wpt_permitted_td['product_title'] ) ) {
                $wpt_single_product_title = false;
                $wpt_single_product_title .= "<td class='wpt_product_title'>";
                if($title_variation == 'link'){
                    $wpt_single_product_title .= "<a class='wpt_product_title_in_td' target='{$config_value['product_link_target']}' href='" . esc_url(get_the_permalink()) . "'>" . get_the_title() . "</a>";
                } elseif($title_variation == 'nolink'){
                    $wpt_single_product_title .= "<span class='wpt_product_title_in_td'>" . get_the_title() . "</span>";
                } elseif($title_variation == 'yith'){
                    $wpt_single_product_title .= "<a class='wpt_product_title_in_td yith-wcqv-button' data-product_id=" . $data['id'] . " href='#'>" . get_the_title() . "</a>";
                }elseif( $config_value['disable_product_link'] == '0' ){
                    $wpt_single_product_title .= "<a class='wpt_product_title_in_td' target='{$config_value['product_link_target']}' href='" . esc_url(get_the_permalink()) . "'>" . get_the_title() . "</a>";
                }else{
                    $wpt_single_product_title .= "<span class='wpt_product_title_in_td'>" . get_the_title() . "</span>";
                }
                
                
                $desc = $data[$description_type];

                //$desc_attr = strip_tags($desc);
                $wpt_single_product_title .= $description_on && $description_on == 'yes' && $desc ? "<div class='product_description'>" .  do_shortcode( $desc ) . "</div>" : '';
                
                
                $wpt_single_product_title .= "</td>";
                $wpt_each_row['product_title'] = $wpt_single_product_title;
            }


            /**
             * Product Category Display with Condition
             */
            if ( isset( $wpt_permitted_td['category'] ) ) {
                $wpt_single_category = false;
  
                $wpt_cotegory_col = wc_get_product_category_list( $data['id'] );
                $wpt_single_category .= "<td class='wpt_for_product_desc wpt_category'>";
                $wpt_single_category .= $wpt_cotegory_col;
                $wpt_single_category .= "</td>";

                $wpt_each_row['category'] = $wpt_single_category;
            }

            /**
             * Product Tags Display with Condition
             */
            if ( isset( $wpt_permitted_td['tags'] ) ) {
                $wpt_single_tags = false;
                $wpt_tag_col = wc_get_product_tag_list( $data['id'] );
                $wpt_single_tags .= "<td class='wpt_for_product_desc wpt_tags'>";
                $wpt_single_tags .= $wpt_tag_col;
                $wpt_single_tags .= "</td>";
                $wpt_each_row['tags'] = $wpt_single_tags;
            }

            /**
             * Product SKU Dispaly
             */
            if ( isset( $wpt_permitted_td['sku'] ) ) {
                $wpt_each_row['sku'] = "<td data-sku='" . $product->get_sku() . "' class='wpt_sku wpt_for_product_desc'><p class='wpt_sku_text'>" . $product->get_sku() . "</p></td>";
            }

            /**
             * Product Rating Dispaly
             */
            if ( isset( $wpt_permitted_td['rating'] ) ) {
            //Add here @version 1.0.4
            $wpt_average = $data['average_rating'];
            $wpt_product_rating = '<div class="star-rating" title="' . sprintf(__('Rated %s out of 5', 'woocommerce'), $wpt_average) . '"><span style="width:' . ( ( $wpt_average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">' . $wpt_average . '</strong> ' . __('out of 5', 'woocommerce') . '</span></div>';
                $wpt_each_row['rating'] = "<td class='wpt_for_product_desc wpt_rating woocommerce'><p class='wpt_rating_p'>" . $wpt_product_rating . "</p></td>";
            }

            /**
             * Display Price
             */
            if ( isset( $wpt_permitted_td['price'] ) ) {
                $wpt_single_price = false;
                $wpt_single_price .= "<td class='wpt_for_product_action wpt_price'  id='price_value_id_" . $data['id'] . "' data-price_html='" . esc_attr( $product->get_price_html() ) . "'> ";
                $wpt_single_price .= '<span class="wpt_product_price">';
                $wpt_single_price .= $product->get_price_html(); //Here was woocommerce_template_loop_price() at version 1.0
                $wpt_single_price .= '</span>';
                $wpt_single_price .= " </td>";

                $wpt_each_row['price'] = $wpt_single_price;
            }
            
            $default_quantity = apply_filters( 'woocommerce_quantity_input_min', 1, $product );
            /**
             * Display Quantity for WooCommerce Product Loop
             * $current_config_value['default_quantity']
             */
            if ( isset( $wpt_permitted_td['quantity'] ) ) {
                $wpt_single_quantity = false;
                $wpt_single_quantity .= "<td class='wpt_for_product_action wpt_quantity' data-product_id='" . $data['id'] . "'> ";
                $wpt_single_quantity .= woocommerce_quantity_input( array( 
                                                                    'input_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
                                                                    'max_value'   => apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
                                                                    'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
                                                                    'step'        => apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
                                                                ) , $product, false ); //Here was only woocommerce_quantity_input() at version 1.0
                $wpt_single_quantity .= " </td>";
                $wpt_each_row['quantity'] = $wpt_single_quantity; 
            }
            
            $enable_disable = ( ( $table_type == 'normal_table' && $product_type == 'grouped' ) || $product_type == 'variable' || $product_type == 'external' || ( $data['stock_status'] != 'instock' && $data['stock_status'] != 'onbackorder' ) ? 'disabled' : 'enabled' );
            $check_class_arr = array(
                $enable_disable,
                'wpt_tabel_checkbox',
                'wpt_td_checkbox',
                "wpt_check_temp_{$temp_number}_pr_" . $data['id'],
                "wpt_check_{$temp_number}",
                "wpt_inside_check_{$temp_number}",
            );
            $check_class = implode(" ", $check_class_arr);
            /**
             * Display Quantity for WooCommerce Product Loop
             */
            if ( isset( $wpt_permitted_td['check'] ) ) {
                $wpt_single_check = false;
                $wpt_single_check .= "<td class='wpt_check' data-product_id='" . $data['id'] . "'> ";
                $wpt_single_check .= "<input "
                        . "data-product_type='" . $product->get_type() . "' "
                        . "id='check_id_{$temp_number}_" . $data['id'] . "' "
                        . "data-temp_number='{$temp_number}' "
                        . "data-product_id='" . $data['id'] . "' "
                        . "class='" . esc_attr( $check_class ) . "'"
                        . "type='checkbox' "
                        . "value='0'"
                        . ( $checkbox == 'wpt_checked_table' && $enable_disable == 'enabled' ? " checked='checked'" : "" )
                        . ">"
                        . "<label for='check_id_{$temp_number}_" . $data['id'] . "'></label>";
                $wpt_single_check .= " </td>";
                $wpt_each_row['check'] = $wpt_single_check;
            }   
                
            /**
             * For Variable Product
             * 
             */
            $row_class = $data_product_variations = $variation_html = $wpt_varitions_col = $variable_for_total = false;
            $quote_class = 'enabled';

            if( $product->get_type() == 'variable' ){
                /**
                 * $variable_for_total variable will use in Total colum. So we need just True false information
                 */
                $variable_for_total = true;
                $row_class = 'data_product_variations woocommerce-variation-add-to-cart variations_button woocommerce-variation-add-to-cart-disabled';
                $quote_class = 'variations_button disabled';
                $variable = new WC_Product_Variable( $data['id'] );
                
                $available_variations = $variable->get_available_variations();
                $data_product_variations = htmlspecialchars( wp_json_encode( $available_variations ) );
                
                
                $attributes = $variable->get_variation_attributes();
                $default_attributes = $variable->get_default_attributes(); //Added at 3.9.0
                $variation_html = wpt_variations_attribute_to_select( $attributes, $data['id'], $default_attributes, $temp_number );                 
            }
            
            
            
            /**
             * It should Place here, Because here will be use $variable_for_total
             * Define Total for Each Product
             * 
             * @since 1.5
             * @date 12/05/2018 d/m/y
             */
            
            if ( isset( $wpt_permitted_td['total'] ) ) {
                $price_decimal_separator = wc_get_price_decimal_separator(); //For Decimal Deparator
                $thousand_separator = wc_get_price_thousand_separator();
                $number_of_decimal = wc_get_price_decimals();
                $founded_price = !empty($data['price'] ) && is_numeric($data['price']) ? $data['price'] : 0;
                $wpt_display_total = $founded_price * $default_quantity;
                
                //$wpt_each_row['total'] = "<td data-number_of_decimal='" . esc_attr( $number_of_decimal ) . "' data-thousand_separator='" . esc_attr( $thousand_separator ) . "' data-price_decimal_separator='" . esc_attr( $price_decimal_separator ) . "' data-price='" . $data['price'] . "' data-currency='" . esc_attr( get_woocommerce_currency_symbol() ) . "' class='wpt_total " . ( $variable_for_total || !$data['price'] ? 'total_variaion' : 'total_general' ) . "'><strong>" . ( !$variable_for_total ? get_woocommerce_currency_symbol() . number_format( $wpt_display_total, $number_of_decimal, $price_decimal_separator, $thousand_separator ) : false ) . "</strong></td>";
                $priceFormat = wpt_price_formatter();
                $newPrice = '';
                switch($priceFormat){
                    case 'left':
                        $newPrice = get_woocommerce_currency_symbol() . number_format( $wpt_display_total, $number_of_decimal, $price_decimal_separator, $thousand_separator);
                        break;
                    case 'left-space':
                        $newPrice = get_woocommerce_currency_symbol() . ' ' . number_format( $wpt_display_total, $number_of_decimal, $price_decimal_separator, $thousand_separator);
                        break;
                    case 'right':
                        $newPrice = number_format( $wpt_display_total, $number_of_decimal, $price_decimal_separator, $thousand_separator) . get_woocommerce_currency_symbol();
                        break;
                    case 'right-space':
                        $newPrice = number_format( $wpt_display_total, $number_of_decimal, $price_decimal_separator, $thousand_separator) . ' ' . get_woocommerce_currency_symbol();
                        break;
                        
            }
                $wpt_each_row['total'] = "<td data-number_of_decimal='" . esc_attr( $number_of_decimal ) . "' "
                        . "data-thousand_separator='" . esc_attr( $thousand_separator ) . "' "
                        . "data-price_decimal_separator='" . esc_attr( $price_decimal_separator ) . "' "
                        . "data-price='" . $data['price'] . "' "
                        . "data-currency='" . esc_attr( get_woocommerce_currency_symbol() ) . "' "
                        . "data-price_format='". esc_attr($priceFormat) ."' "
                        . "class='wpt_total " . ( $variable_for_total || !$data['price'] ? 'total_variaion' : 'total_general' ) . "'>"
                        . "<strong>" . ( !$variable_for_total ? $newPrice : false ) . "</strong></td>";

                
            }

            //Out_of_stock class Variable
            $stock_status = $data['stock_status'];
            $stock_status_class = ( $stock_status == 'onbackorder' || $stock_status == 'instock' ? 'add_to_cart_button' : $stock_status . '_add_to_cart_button disabled' );

            /**
             * For WishList
             * @since 2.6
             */
            if ( isset( $wpt_permitted_td['wishlist'] ) ) {
                $wpt_wishlist = false;
                $wpt_wishlist .= "<td class='wpt_for_product_action wpt_wishlist'  data-product_id='" . $data['id'] . "'> ";
                $wpt_wishlist .= do_shortcode( '[yith_wcwl_add_to_wishlist product_id='. $data['id'] .' icon="'. (get_option( 'yith_wcwl_add_to_wishlist_icon' ) != '' && get_option( 'yith_wcwl_use_button' ) == 'yes' ? get_option( 'yith_wcwl_add_to_wishlist_icon' ) : 'fa-heart') .'"]' );
                $wpt_wishlist .= "</td>";
                $wpt_each_row['wishlist'] = $wpt_wishlist;
            }    
              
            /**
             * For Quote Request
             * @since 2.6
             */
            if ( isset( $wpt_permitted_td['quoterequest'] ) ) {
                $wpt_nonce = wp_create_nonce( 'add-request-quote-' . $data['id'] );
                //wpt_for_product_action
                $wpt_quoterequest = false;
                $wpt_quoterequest .= "<td class='wpt_for_product_action wpt_quoterequest yith_request_temp_{$temp_number}_id_{$data['id']}_td'  data-product_id='" . $data['id'] . "'> ";
                $Add_to_Quote = $config_value['yith_add_to_quote_text'];//'Add to Quote';
                $data_message = '{"text":"'. $Add_to_Quote .'","adding":"' . $config_value['yith_add_to_quote_adding'] . '","added":"' . $config_value['yith_add_to_quote_added'] . '"}';
                $wpt_quoterequest .= "<a data-yith_browse_list='{$config_value['yith_browse_list']}' data-response_msg='' data-msg='{$data_message}' data-wp_nonce='{$wpt_nonce}' data-quote_data='' data-variation='' data-variation_id='' data-product_id='{$data['id']}' class='{$quote_class} yith_request_temp_{$temp_number}_id_{$data['id']} wpt_yith_add_to_quote_request wpt_add-request-quote-button button' href='#' data-quantity='{$default_quantity}' data-selector='yith_request_temp_{$temp_number}_id_{$data['id']}'>{$Add_to_Quote}</a>";
                $wpt_quoterequest .= "</td>";

                $wpt_each_row['quoterequest'] = $wpt_quoterequest;
            }   
            
            /**
             * To display Product's Publish Date
             * 
             * @since 3.7
             * @date 10.11.2018 d.m.y
             */
            if ( isset( $wpt_permitted_td['date'] ) ) {
                $wpt_date = false;
                $wpt_date .= "<td class='wpt_for_product_desc wpt_date'> ";
                $wpt_date .= get_the_date();
        
                $wpt_date .= "</td>";
                $wpt_each_row['date'] = $wpt_date;
            }  
             
            /**
             * To display Product's Publish Modified Date
             * 
             * @since 3.7
             * @date 10.11.2018 d.m.y
             */
            if ( isset( $wpt_permitted_td['modified_date'] ) ) {
                $date_modified = $data['date_modified'];
                $wpt_modified_date = false;
                $wpt_modified_date .= "<td class='wpt_for_product_desc wpt_modified_date'> ";
                $wpt_modified_date .= $date_modified->date( get_option( 'date_format' ) );
                $wpt_modified_date .= "</td>";
                $wpt_each_row['modified_date'] = $wpt_modified_date;
            }  
            
            if ( isset( $wpt_permitted_td['attribute'] ) ) {
                $wpt_attribute = false;
                $variable = new WC_Product_Variable($id);
                $attributes = $variable->get_attributes();  
                
                $wpt_attribute .= "<td class='wpt_for_product_desc wpt_attribute'> ";
                $wpt_attribute .= wpt_additions_data_attribute( $attributes );
                $wpt_attribute .= "</td> ";
                $wpt_each_row['attribute'] = $wpt_attribute;
            }
            if ( isset( $wpt_permitted_td['variations'] ) ) {
                $wpt_variations = false;$wpt_varitions_col = true;
                $wpt_variations .= "<td data-temp_number='{$temp_number}' class='{$row_class} wpt_variations wpt_variation_" . $data['id'] . "' data-quantity='1' data-product_id='" . $data['id'] . "' data-product_variations = '" . esc_attr( $data_product_variations ) . "'> ";
                $wpt_variations .= $variation_html;
                $wpt_variations .= "</td>";
                $wpt_each_row['variations'] = $wpt_variations;
            }
            
            
            /**
             * Display Add-To-Cart Button
             */
            if ( isset( $wpt_permitted_td['action'] ) ) {
                $wpt_single_action = false;
                $wpt_single_action .= "<td data-temp_number='{$temp_number}' class='{$row_class} wpt_action wpt_variation_" . $data['id'] . "' data-quantity='1' data-product_id='" . $data['id'] . "' data-product_variations = '" . esc_attr( $data_product_variations ) . "'> ";
                /***************/
                if( $table_type == 'advance_table'){
                    ob_start();
                    woocommerce_template_single_add_to_cart();

                    $wpt_single_action .= ob_get_clean();
                }else{
                    if( !$wpt_varitions_col ){
                        $wpt_single_action .= $variation_html;
                        ob_start();
                        do_action('wpt_action_variation',$product);
                        $wpt_single_action .= ob_get_clean();
                    }

                    $ajax_action_final = ( $product_type == 'grouped' || $product_type == 'external' ? 'no_ajax_action ' : $ajax_action . ' ' );//$ajax_action;
                    if( $product_type == 'grouped' || $product_type == 'external' ){
                        $add_to_cart_url = $product->add_to_cart_url();
                    }else{
                        $add_to_cart_url = '?add-to-cart=' .  $data['id'];//( $ajax_action == 'no_ajax_action' ? '?add-to-cart=' .  $data['id'] : '?add-to-cart=' .  $data['id'] );// '?add-to-cart=' .  $data['id'];
                    }

                    $add_to_cart_text_final = ( $product_type == 'grouped' || $product_type == 'external' || $add_to_cart_text == ' ' ? $product->add_to_cart_text() : $add_to_cart_text );//'?add-to-cart=' .  $data['id']; //home_url() .  
                    $wpt_single_action .= apply_filters('woocommerce_loop_add_to_cart_link', 
                            sprintf('<a rel="nofollow" data-add_to_cart_url="%s" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>', 
                                    esc_attr( $add_to_cart_url ),
                                    esc_url( $add_to_cart_url ), 
                                    esc_attr( $default_quantity ), //1 here was 1 before 2.8
                                    esc_attr($product->get_id()), 
                                    esc_attr($product->get_sku()), 
                                    esc_attr( $ajax_action_final . ( $row_class ? 'wpt_variation_product single_add_to_cart_button button alt disabled wc-variation-selection-needed wpt_woo_add_cart_button' : 'button wpt_woo_add_cart_button ' . $stock_status_class ) ), //ajax_add_to_cart  //|| !$data['price']
                                    esc_html( $add_to_cart_text_final )
                            ), $product,false,false);
                }

                $wpt_single_action .= " </td>";
                $wpt_each_row['action'] = $wpt_single_action;
            }
