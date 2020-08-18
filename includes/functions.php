<?php
/*************
 * WPT
 * MAIN MODULE
 */

if( !function_exists( 'wpt_column_setting_for_tax_cf' ) ){
    
    /**
     * Using @Hook Filter wpto_column_settings
     * That Filter are situated in two place. In main function and another in shortcode_row_generator function.
     * To identity Old ShortCode system, such: cf_ [prefix] and tax_ [prefix] of custom field and taxonomy column
     * 
     * @param type $column_settings
     * @param type $table_ID
     * @param type $enabled_column_array
     * @return Array $column_settings Array, which is most important for Each Column and Items.
     */
    function wpt_column_setting_for_tax_cf( $column_settings, $table_ID, $enabled_column_array ){
        if(is_array( $enabled_column_array ) && count( $enabled_column_array ) > 0 ){
            foreach($enabled_column_array as $enbl_col=>$val){
                if( substr($enbl_col, 0,3) == 'cf_' ){
                    $column_settings[$enbl_col]['type'] = 'custom_field';
                    $column_settings[$enbl_col]['type_name'] = 'Custom Field';
                    $column_settings[$enbl_col]['older'] = true;
                }
                if( substr($enbl_col, 0,4) == 'tax_' ){
                    $column_settings[$enbl_col]['type'] = 'taxonomy';
                    $column_settings[$enbl_col]['type_name'] = 'Taxonomy';
                    $column_settings[$enbl_col]['older'] = true;
                }
                
            }
        }
        return $column_settings;
    }
}
add_filter( 'wpto_column_settings', 'wpt_column_setting_for_tax_cf', 10, 3 );

if( !function_exists( 'wpt_detect_current_device' ) ){
    function wpt_detect_current_device(){
        $device = 'desktop';
        $mobile_detect = new Mobile_Detect();
        $is_tablet = $mobile_detect->isTablet();
        $is_mobile = $mobile_detect->isMobile();
        if( $is_tablet ){
            $device = 'tablet';
        }elseif( $is_mobile ){
            $device = 'mobile';
        }elseif( $is_tablet && !$is_mobile ){
            $device = 'mobile';
        }
        return $device;
    }
}

if( !function_exists( 'wpt_device_wise_table_col' ) ){
    /**
     * Generate $enabled_column_array based on Device 
     * for Responsive Table.
     * We have added Responsive Tab inbside Admin of WPT plugin by Action: wpto_admin_tab_array inside admin/functions.php
     * 
     * In this function, we will also use Mobile_Detect() Class, which already included in main plugin file.
     * 
     * Need responsive tab's data, which is in table meta. Where us need table ID for table wise REsponsive
     * such: get_post_meta(POST_ID, keyword_of_meta, true);
     * 
     * @since 6.0.28
     * @param type $enabled_column_array
     * @return Array
     */
    function wpt_device_wise_table_col($enabled_column_array, $table_ID){
       $device = wpt_detect_current_device();
       $device = apply_filters( 'wpto_curent_deteted_device', $device, $enabled_column_array, $table_ID );
       if( !$device ){
           return $enabled_column_array;
       }
       $responsive_meta = get_post_meta( $table_ID, 'responsive', true );

       if( isset( $responsive_meta[$device] ) && is_array( $responsive_meta[$device] ) && count( $responsive_meta[$device] ) > 0 ){
           return $responsive_meta[$device];
       }
       return $enabled_column_array;
   }
}
/**
 * Availabvle Variable in this Filters is:
 * $enabled_column_array, $table_ID, $atts, $column_settings, $column_array
 * Perpose is: Change/Edit/Customize to Enabled Column Array
 */
add_filter( 'wpto_enabled_column_array', 'wpt_device_wise_table_col',10, 2 );


if( !function_exists( 'wpt_device_wise_class' ) ){
    /**
     * Add Device Wise Class
     * using Following Filter:
     * apply_filters( 'wpto_wrapper_tag_class_arr', $wrapper_class_arr, $table_ID, $args, $column_settings, $enabled_column_array, $column_array );
     * 
     * @since 6.0.28
     * @param type $enabled_column_array
     * @return Array
     */
    function wpt_device_wise_class( $wrapper_class_arr ){
       $device = wpt_detect_current_device();
       $wrapper_class_arr[] = 'wpt_device_' . $device;
       
       return $wrapper_class_arr;
   }
}
/**
 * Availabvle Variable in this Filters is:
 * $enabled_column_array, $table_ID, $atts, $column_settings, $column_array
 * Perpose is: Change/Edit/Customize to Enabled Column Array
 */
add_filter( 'wpto_wrapper_tag_class_arr', 'wpt_device_wise_class');
add_filter( 'body_class', 'wpt_device_wise_class' );


if( !function_exists( 'wpt_checkbox_validation' ) ){
    /**
     * Checkbox Enable Disable
     * using Following Filter:
     * $checkbox_validation = apply_filters( 'wpto_checkbox_validation', false, $enabled_column_array,$column_settings, $table_ID, $atts );
     * 
     * @since 6.0.28
     * @param type $enabled_column_array
     * @return Array
     */
    function wpt_checkbox_validation( $bool, $enabled_column_array,$column_settings ){
        $arrrrr = array();
        if( !is_array( $enabled_column_array ) || !is_array( $column_settings ) ) return false;
        
        
        if( isset( $enabled_column_array['check'] ) ){
            return true;
        }
        
        foreach( $column_settings as $key => $e_stng ){
            if( isset( $e_stng['items'] ) && is_array( $e_stng['items'] ) && in_array( 'check', $e_stng['items'] ) ) return true;
        }

        return $bool;
   }
}
add_filter( 'wpto_checkbox_validation', 'wpt_checkbox_validation', 10, 3);

if( !function_exists( 'wpt_product_title_column_add' ) ){
    
    function wpt_product_title_column_add( $column_settings ){
        $title_variation = isset( $column_settings['title_variation']) ? $column_settings['title_variation'] : false;
        $description_off =  isset( $column_settings['description_off'] ) ? $column_settings['description_off'] : 'on';
        $description_off = $description_off == 'off' ? 'checked="checked"' : '';
       ?>
        <div class="description_off_wrapper">
            <label for="description_off"><input title="Disable Deactivate Description from Title Column" name="column_settings[description_off]" id="description_off" class="description_off" type="checkbox" value="off" <?php echo $description_off; ?>> Disable Description</label>
        </div>
        <div class="title_variation">
            <label for="link"><input type="radio" id="link" name="column_settings[title_variation]" value="link" <?php echo !$title_variation || $title_variation == 'link' ? 'checked' : ''; ?>> Link Enable</label>
            <label for="nolink"><input type="radio" id="nolink" name="column_settings[title_variation]" value="nolink" <?php echo $title_variation == 'nolink' ? 'checked' : ''; ?>> Link Disable</label>
            <label for="yith" class="tooltip"><input type="radio" id="yith" name="column_settings[title_variation]" value="yith" <?php echo $title_variation == 'yith' ? 'checked' : ''; ?>> Link Disable + Quick View<span class="tooltip-hover down-arrow">You have to install <a href="https://wordpress.org/plugins/yith-woocommerce-quick-view/" target="_blank">YITH WooCommerce Quick View</a></span></label>
        </div>        
        
        
       <?php
   }
}
add_action( 'wpto_column_setting_form_product_title', 'wpt_product_title_column_add' );

if( !function_exists( 'wpt_thumbnails_column_add' ) ){
    
    function wpt_thumbnails_column_add( $column_settings ){
        $thumb_variation = isset( $column_settings['thumb_variation']) ? $column_settings['thumb_variation'] : false;
       ?>
        <div class="thumb_variation">
            <label for="popup"><input type="radio" id="popup" name="column_settings[thumb_variation]" value="popup" <?php echo !$thumb_variation || $thumb_variation == 'popup' ? 'checked' : ''; ?>> Default Popup</label>
            <label for="no_action"><input type="radio" id="no_action" name="column_settings[thumb_variation]" value="no_action" <?php echo $thumb_variation == 'no_action' ? 'checked' : ''; ?>> No Action</label>
            <label for="url"><input type="radio" id="url" name="column_settings[thumb_variation]" value="url" <?php echo $thumb_variation == 'url' ? 'checked' : ''; ?>> Product Link</label>
            <label for="quick_view" class="tooltip"><input type="radio" id="quick_view" name="column_settings[thumb_variation]" value="quick_view" <?php echo $thumb_variation == 'quick_view' ? 'checked' : ''; ?>> Quick View<span class="tooltip-hover down-arrow">You have to install <a href="https://wordpress.org/plugins/yith-woocommerce-quick-view/" target="_blank">YITH WooCommerce Quick View</a></span></label>
        </div>
        
       <?php
   }
}
add_action( 'wpto_column_setting_form_thumbnails', 'wpt_thumbnails_column_add' );



if( !function_exists( 'wpt_column_tag_for_all' ) ){
    function wpt_column_tag_for_all($keyword, $column_settings, $columns_array){
        $input_one = isset( $column_settings[$keyword]['input_one'] ) ? $column_settings[$keyword]['input_one'] : false;
        $tag_value = isset( $column_settings[$keyword]['tag'] ) ? $column_settings[$keyword]['tag'] : false;
        $tags = array(
            '' => 'No Tag',
            'section' => 'Section',
            'h1' => 'Heading 1',
            'h2' => 'Heading 2',
            'h3' => 'Heading 3',
            'h4' => 'Heading 4',
            'h5' => 'Heading 5',
            'h6' => 'Heading 6',
            'p' => 'Paragraph',
            'b' => 'Bold',
            'strong' => 'Strong',
            'span' => 'Span',
            'div' => 'Div',
        );
        ?>
        <div class="column_tag_for_all">
            <label>Select wrapper tag</label>
            <select class="ua_select" name="column_settings[<?php echo $keyword; ?>][tag]">    
            <?php
            foreach($tags as $tag => $tag_name){
                $seleced = $tag_value == $tag ? 'selected' : false;
                echo "<option value='{$tag}' $seleced>$tag_name</option>";
            }
            ?>
            </select>
        </div>
        <!-- <input name="column_settings[<?php echo $keyword; ?>][input_one]" value='<?php echo esc_attr( $input_one ); ?>'> -->
        <?php
    }
}

add_action( 'wpto_column_setting_form', 'wpt_column_tag_for_all', 10, 3 );

if( !function_exists( 'wpt_column_add_extra_items' ) ){
    function wpt_column_add_extra_items( $keyword, $column_settings, $columns_array, $post ){

        unset( $columns_array[$keyword] );
        //unset( $columns_array['check'] );
        unset( $columns_array['blank'] );
        /**
         * Items actually Checked Items
         */
        $items = isset( $column_settings[$keyword]['items'] ) ? $column_settings[$keyword]['items'] : array();
        $items = array_filter( $items );
        
        /**
         * @Hook Filter: wpto_inside_thecked_item_arr
         * Available Args: $items, $keyword, $column_settings, $columns_array, $post
         * To add Any Items for [Select multiple inner items]
         * Remember: It's only for Admin Product Table Edit. and data will debend on Save Only
         */
        $items = apply_filters( 'wpto_inside_thecked_item_arr', $items, $keyword, $column_settings, $columns_array );
        if( is_array( $items ) && count( $items ) > 0 ){
            
            //array_merge(array_flip($items),$columns_array)
            $columns_array = array_merge(array_flip($items),$columns_array);
        }
        ?>
        <div class="column_add_extra_items">
        <label>Select multiple inner items:</label>    
        <div class="checkbox_parent parent_<?php echo esc_attr( $keyword ); ?>">


            <?php
            $items_columns = $columns_array;
            $items_columns = apply_filters( 'wpto_inside_item_arr', $items_columns, $keyword, $column_settings, $post );
            $items_columns = apply_filters( 'wpto_inside_item_arr_' . $keyword, $items_columns, $column_settings, $post );
            foreach($items_columns as $key => $key_val){
                $seleced = in_array( $key,$items ) ? 'checked' : false;
                //var_dump($key, $keyword);
                $unique_id = $keyword . '_' . $key;
                echo '<div class="each_checkbox each_checkbox_' . $key . '">';
                echo "<input "
                . "id='{$unique_id}' "
                . "type='checkbox' "
                . "name='column_settings[{$keyword}][items][]' "
                . "value='{$key}' $seleced/><label for='{$unique_id}'>$key_val <small>($key)</small></label>";
                echo '</div>';
            }
            ?>
            </div>
        <p>All Items are move able. And Settings of item will come from main column. which can be inactive as Table Column.</p>
        </div>
        <?php
    }
}

add_action( 'wpto_column_setting_form', 'wpt_column_add_extra_items', 10, 4 );

if( !function_exists( 'wpt_add_extra_inside_items' ) ){
    function wpt_add_extra_inside_items( $columns_array ){
        //wpto_inside_item_arr
        $columns_array['menu_order'] = "Menu Order";
        //$columns_array['menu_order'] = "Menu Order";
        return $columns_array;
    }
}

add_filter( 'wpto_inside_item_arr', 'wpt_add_extra_inside_items' ); //$items,$keyword, $column_settings, $columns_array, $post

if( !function_exists( 'wpt_get_config_value' ) ){
    /**
     * getting Config value. If get config value from post, then it will receive from post, Otherwise, will take data from Configuration value.
     * 
     * @param type $table_ID Mainly post ID of wpt_product_table. That means: its post id of product table
     * @return type Array
     */
    function wpt_get_config_value( $table_ID ){
        $config_value = $temp_config_value = get_option( 'wpt_configure_options' );
        $config = get_post_meta( $table_ID, 'config', true );
        if( !empty( $config ) && is_array( $config ) ){
            $config_value = array_merge( $config_value, $config );
        }
        $config_value = apply_filters( 'wpto_get_config_value', $config_value, $table_ID );
        /*
        $config_value['footer_cart'] = $temp_config_value['footer_cart'];
        $config_value['footer_cart_size'] = $temp_config_value['footer_cart_size'];
        $config_value['footer_possition'] = $temp_config_value['footer_possition'];
        $config_value['footer_bg_color'] = $temp_config_value['footer_bg_color'];
        //$config_value['thumbs_lightbox'] = $temp_config_value['thumbs_lightbox'];
        $config_value['disable_cat_tag_link'] = $temp_config_value['disable_cat_tag_link'];
        */
        return $config_value;
    }
}
// Hook into Woocommerce when adding a product to the cart
add_filter( 'woocommerce_add_to_cart_fragments', 'wpt_per_item_fragment', 999 , 1 );

if( !function_exists( 'wpt_per_item_fragment' ) ) {
	function wpt_per_item_fragment($fragments)
	{
		ob_start();
                $Cart = WC()->cart->cart_contents;
                $product_response = false;
                if( is_array( $Cart ) && count( $Cart ) > 0 ){
                    foreach($Cart as $perItem){
                        //var_dump($perItem);
                        $pr_id = (String) $perItem['product_id'];
                        $pr_value = (String) $perItem['quantity'];
                        $product_response[$pr_id] = (String)  (isset( $product_response[$pr_id] ) ? $product_response[$pr_id] + $pr_value : $pr_value);
                    }
                }

                if( is_array( $product_response ) && count( $product_response ) > 0 ){
                    foreach( $product_response as $key=>$value ){
                        $pr_id = (String) $key;
                        $pr_value = (String) $value;
                        $fragments["span.wpt_ccount.wpt_ccount_$pr_id"] = "<span class='wpt_ccount wpt_ccount_$pr_id'>$pr_value</span>";
                    }
                }
                $fragments['.wpt-footer-cart-wrapper>a'] = '<a href="' . wc_get_cart_url() . '">' . WC()->cart->get_cart_subtotal() . '</a>';
		echo wp_json_encode($product_response);
		
		$fragments["wpt_per_product"] = ob_get_clean();
                //WC_AJAX::get_refreshed_fragments();
		return $fragments;
	}
}



if( !function_exists( 'wpt_paginate_links' ) ){
    /**
     * Generate paginated links based on Args.
     * 
     * @param type $args Args of WP_Query's
     * @return type String
     */
    function wpt_paginate_links( $args = false ){
        $html = false;
        if( $args ){
            $product_loop = new WP_Query($args);
            $big = 99999999;
            $paginate = paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => apply_filters( 'wpto_pagination_format', '?paged=%#%', $args ),
                'mid_size'  =>  3,
                'prev_next' =>  false,
                'current' => max( 1, $args['paged'] ),
                'total' => $product_loop->max_num_pages
            ));
            $html .= $paginate; 
        }
        return $html;
    }
}

if( !function_exists( 'wpt_pagination_by_args' ) ){
    /**
     * Generate full pagination based on Args.
     * 
     * @param type $args Args of WP_Query's
     * @return type String
     */
    function wpt_pagination_by_args( $args = false, $temp_number = false ){
        $html = false;
        if( $args ){
            $html .= "<div class='wpt_table_pagination' data-temp_number='{$temp_number}'>";
            $paginate = wpt_paginate_links( $args );
            $html .= $paginate; 
            $html .= "</div>";
        }
        return $html;
    }
}

if( !function_exists( 'wpt_additions_data_attribute' ) ){
    /**
     * Generate Product's Attribute
     * 
     * @global type $product Default global product variable, it will only work inside loop
     * @param type $attributes Array
     * @return string 
     */
    function wpt_additions_data_attribute( $attributes = false ){
        global $product;
        $html = false;
        if( $attributes && is_array( $attributes ) && count( $attributes ) > 0 ){
            foreach ( $attributes as $attribute ) :
            $html .= "<div class='wpt_each_attribute_wrapper'>";
                $html .= "<label>" . wc_attribute_label( $attribute->get_name() ) . "</label>";

                $values = array();

                if ( $attribute->is_taxonomy() ) {
                        $attribute_taxonomy = $attribute->get_taxonomy_object();
                        $attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

                        foreach ( $attribute_values as $attribute_value ) {
                                $value_name = esc_html( $attribute_value->name );

                                if ( $attribute_taxonomy->attribute_public ) {
                                        $values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
                                } else {
                                        $values[] = $value_name;
                                }
                        }
                } else {
                        $values = $attribute->get_options();

                        foreach ( $values as &$value ) {
                                $value = make_clickable( esc_html( $value ) );
                        }
                }

            $html .= apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

            $html .= '</div>';
            endforeach;
        }
        return $html;
    }
}

if( !function_exists( 'wpt_check_sortOrder' ) ){
    /**
     * Checking Value for Select option tag
     * Used in shortcode.php file actually
     * 
     * @param type $got_value
     * @param type $this_value
     * @return type String
     */
    function wpt_check_sortOrder( $got_value = false, $this_value = 'nothing' ){
        return $got_value == $this_value ? 'selected' : ''; 
    }
}

if( !function_exists( 'wpt_default_columns_array' ) ){
    /**
     * To get Final Columns List as Array, where will unavailable default disable_column
     * 
     * @return Array 
     */
    function wpt_default_columns_array(){
        $column_array = WPT_Product_Table::$columns_array;
        /**
         * To this disable array, Only available keywords of Column Keyword Array
         * 
         */
        $disable_column_keyword = WPT_Product_Table::$colums_disable_array;
        foreach( $disable_column_keyword as $value ){
            unset( $column_array[$value] );
        }
        return $column_array;
    }
}

if( !function_exists( 'wpt_default_columns_keys_array' ) ){
    /**
     * We used this function to get default keywords array from default columns array
     * 
     * @return Array Only Keys of Column Array
     * @since 3.6
     */
    function wpt_default_columns_keys_array(){
        return array_keys( wpt_default_columns_array() );
    }
}

if( !function_exists( 'wpt_default_columns_values_array' ) ){
    /**
     * We used this function to get default values array from default columns array
     * 
     * @return Array Only values of Column Array
     * @since 3.6
     */
    function wpt_default_columns_values_array(){
        return array_values( wpt_default_columns_array() );
    }
}


if( !function_exists( 'wpt_taxonomy_column_generator' ) ){
    /**
     * Taxonomy column generator
     * clue is: tax_
     * 
     * @param type $item_key
     * @return String
     */
    function wpt_taxonomy_column_generator( $item_key ){
        $key = 'tax_';
        $len = strlen( $key );
        $check_key = substr( $item_key, 0, $len );
        if( $check_key == $key ){
            return $item_key;
        }
    }
}

if( !function_exists( 'wpt_customfileds_column_generator' ) ){
    /**
     * Custom Fields column generator
     * clue is: cf_
     * 
     * @param type $item_key
     * @return String
     */
    function wpt_customfileds_column_generator( $item_key ){
        $key = 'cf_';
        $len = strlen( $key );
        $check_key = substr( $item_key, 0, $len );
        if( $check_key == $key ){
            return $item_key;
        }
    }
}

if( !function_exists( 'wpt_limit_words' ) ){
    /**
     * Making new String/description based on word Limit.
     * 
     * @param String $string
     * @param Integer $word_limit
     * @return String
     */
    function wpt_limit_words( $string = '', $word_limit = 10 ){
        $words = explode( " ",$string );

        $output = implode( " ",array_splice( $words,0,$word_limit ) );
        if( count( $words ) > $word_limit ){
           $output .= $output . '...'; 
        }
        return $output;
    }
}

if( !function_exists( 'wpt_explode_string_to_array' ) ){
    /**
     * Go generate as Array from 
     * 
     * @param Array $string Obviously should be an Array, Otherwise, it will generate false.
     * @param Array $default_array Actually if not fount a real String, and if we want to return and default value, than we can set here. 
     * @return Array This function will generate comman string to Array
     */
    function wpt_explode_string_to_array( $string,$default_array = false ) {
        $final_array = false;
        if ( $string && is_string( $string ) ) {
            $string = rtrim( $string, ', ' );
            $final_array = explode( ',', $string );
        } else {
            if( is_array( $default_array ) ){
            $final_array = $default_array;
            }
        }
        return $final_array;
    }
}

if( !function_exists( 'wpt_generate_each_row_data' ) ){
    /**
     * Generate each row data for product table. This function will only use for once place.
     * I mean: in shortcode.php file normally.
     * But if anybody want to use any others where, you have to know about $table_column_keywords and $wpt_each_row
     * both should be Array, Although I didn't used condition for $wpt_each_row Array to this function. 
     * So used: based on your own risk.
     * 
     * @param Array $table_column_keywords
     * @param Array $wpt_each_row
     * @return String_Variable
     */
    function wpt_generate_each_row_data($table_column_keywords = false, $wpt_each_row = false) {
        $final_row_data = false;
        if ( is_array( $table_column_keywords ) && count( $table_column_keywords ) > 0) {
            foreach ( $table_column_keywords as $each_keyword ) {
                $final_row_data .= ( isset( $wpt_each_row[$each_keyword] ) ? $wpt_each_row[$each_keyword] : false );
            }
        }
        return $final_row_data;
    }
}

if( !function_exists( 'wpt_define_permitted_td_array' ) ){
    /**Generaed a Array for $wpt_permitted_td 
     * We will use this array to confirm display Table body's TD inside of Table
     * 
     * @since 1.0.4
     * @date 27/04/2018
     * @param Array $table_column_keywords
     * @return Array/False
     */
    function wpt_define_permitted_td_array( $table_column_keywords = false ){

        $wpt_permitted_td = false;
        if( $table_column_keywords && is_array( $table_column_keywords ) && count( $table_column_keywords ) > 0 ){
            foreach( $table_column_keywords as $each_keyword ){
                $wpt_permitted_td[$each_keyword] = true;
            }
        }
        return $wpt_permitted_td;
    }
}

if( !function_exists( 'wpt_array_to_option_atrribute' ) ){
    /**
     * Generating <options>VAriation Atribute</option> for Product Variation
     * CAn be removed later.
     * 
     * @param type $current_single_attribute
     * @return string
     */
    function wpt_array_to_option_atrribute( $current_single_attribute = false ){
        $html = '<option value>'.esc_html__( 'None', 'wpt_pro' ).'</option>';
        if( is_array( $current_single_attribute ) && count( $current_single_attribute ) ){
            foreach( $current_single_attribute as $wpt_pr_attributes ){
            $html .= "<option value='{$wpt_pr_attributes}'>" . ucwords( $wpt_pr_attributes ) . "</option>";
            }
        }
        return $html;
    }
}

if( !function_exists( 'wpt_variations_attribute_to_select' ) ){
    /**
     * For Variable product, Variation's attribute will generate to select tag
     * 
     * @param Array $attributes
     * @param Int $product_id
     * @param Int $temp_number
     * @return string HTML Select tag will generate from Attribute
     */
    function wpt_variations_attribute_to_select( $attributes , $product_id = false, $default_attributes = false, $temp_number = false ){
        $html = false;
        $html .= "<div class='wpt_varition_section' data-product_id='{$product_id}'  data-temp_number='{$temp_number}'>";
        foreach( $attributes as $attribute_key_name=>$options ){

            $label = wc_attribute_label( $attribute_key_name );
            $attribute_name = wc_variation_attribute_name( $attribute_key_name );
            $only_attribute = str_replace( 'attribute_', '', $attribute_name);
            $default_value = !isset( $default_attributes[$only_attribute] ) ? false : $default_attributes[$only_attribute]; //Set in 3.9.0

                    // Get an array of attributes
                    $attr_array = get_the_terms( $product_id, $only_attribute);
            $html .= "<select data-product_id='{$product_id}' data-attribute_name='{$attribute_name}' placeholder='{$label}'>";
            $html .= "<option value='0'>" . $label . "</option>";
            foreach( $options as $option ){
                            // Get the name of the current attribute
                            $attr_name = $option;
                            foreach( $attr_array as $attr ){
                                    if ( isset( $attr->slug ) && $option == $attr->slug) { $attr_name = $attr->name; }
                            }

                $html .= "<option value='" . esc_attr( $option ) . "' " . ( $default_value == $option ? 'selected' : '' ) . ">" . $attr_name . "</option>";
            }
            $html .= "</select>";

        }
        $html .= "<div class='wpt_message wpt_message_{$product_id}'></div>";
        $html .= '</div>';

        return $html;
    }
}


if( !function_exists( 'wpt_get_value_with_woocommerce_unit' ) ){
    /**
     * Getting unit amount with unint sign. Suppose: Kg, inc, cm etc
     * woocommerce has default wp_options for weight,height etc's unit.
     * Example: for weight, woocommerce_weight_unit
     * 
     * @param string $target_unit Such as: weight, height, lenght, width
     * @param int $value Can be any number. It also can be floating point number. Normally decimal
     * @return string If get unit and value is gater than o, than it will generate string, otheriwse false
     */
    function wpt_get_value_with_woocommerce_unit( $target_unit, $value ){
        $get_unit = get_option( 'woocommerce_' . $target_unit . '_unit' );
        return ( is_numeric( $value ) && $value > 0 ? $value . ' ' . $get_unit : false );
    }
}

if( !function_exists( 'wpt_adding_body_class' ) ){
    /**
     * Adding wpt_'s class at body tag, when Table will show.
     * Only for frontEnd
     * 
     * @global type $post
     * @global type $shortCodeText
     * @param type $class
     * @return string
     */
    function wpt_adding_body_class( $class ) {
        global $post,$shortCodeText;

        if( isset($post->post_content) && has_shortcode( $post->post_content, $shortCodeText ) ) {
            $class[] = 'wpt_table_body';
            $class[] = 'woocommerce';
        }
        return $class;
    }
}
add_filter( 'body_class', 'wpt_adding_body_class' );

