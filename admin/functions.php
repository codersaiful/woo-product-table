<?php



if( !function_exists( 'wpt_admin_body_class' ) ){
    /**
     * set class for Admin Body tag
     * 
     * @param type $classes
     * @return String
     */
    function wpt_admin_body_class( $class_string ){
        global $current_screen;
        $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
        if( strpos( $s_id, 'wpt_product_table') !== false ){
            return $class_string . ' wpt_admin_body ';
        }
        return $class_string;
    }
}
add_filter( 'admin_body_class', 'wpt_admin_body_class', 999 );

if( !function_exists( 'wpt_selected' ) ){
    
    /**
     * actually for Select Option
     * Inside Config Tab or Inside Configuration Page
     * Executing If available or Not. 
     * If false $default_config, Then It will come from 
     * get_option( 'wpt_configure_options' )
     * 
     * @since 2.4 
     */
    function wpt_selected(  $keyword, $gotten_value, $default_config = false ){
        $current_config_value = is_array( $default_config ) ? $default_config : get_option( 'wpt_configure_options' );
        echo ( isset( $current_config_value[$keyword] ) && $current_config_value[$keyword] == $gotten_value ? 'selected' : false  );
    }
}

if( ! function_exists( 'wpt_get_base64_post_meta' ) ){
    
    /**
     * Getting Post Meta Value in base64 encoded formate
     * Typically I have used it in post_metabox.php file
     * for export box.
     * 
     * In future, we can use it any another place.
     * 
     * @since 2.8.7.1
     * @by Saiful
     * @date 11.5.2021
     */
    function wpt_get_base64_post_meta( $post_id ){
        if( ! $post_id || ! is_numeric( $post_id ) ) return false;
        
        $meta = get_post_meta($post_id);
        unset($meta['_edit_lock']);
        unset($meta['_edit_last']);

        $meta = array_map('array_filter', $meta);
        $meta = array_filter($meta);

        $serialize_meta = serialize($meta);
        $base64_meta = base64_encode($serialize_meta);
        
        return $base64_meta;
    }
}


if( ! function_exists( 'wpt_ajax_get_post_meta_base64' ) ){
    
    /**
     * Getting base64 Post meta for Export box
     * It will generate and handle from admin.js using
     * ajax request
     * and we will use POST Request
     * 
     * @since 2.8.7.1
     * @by Saiful
     * @date 11.5.2021
     */
    function wpt_ajax_get_post_meta_base64(){
        if( isset( $_POST['post_id'] ) && ! empty( $_POST['post_id'] ) && isset( $_POST['action'] ) == 'wpt_set_post_meta' ){
            $post_id = sanitize_text_field( $_POST['post_id'] );
            if( ! $post_id || ! is_numeric( $post_id ) ) echo '';

            echo wpt_get_base64_post_meta( $post_id );
        }else{
            echo '';
        }
        die();
    }
}
add_action( 'wp_ajax_wpt_set_post_meta', 'wpt_ajax_get_post_meta_base64' );
add_action( 'wp_ajax_nopriv_wpt_set_post_meta', 'wpt_ajax_get_post_meta_base64' );


/**
 * @todo This function and will remove
 */
if( !function_exists( 'wpt_admin_responsive_tab' ) ){
    function wpt_admin_responsive_tab( $tab_array ){
        unset($tab_array['mobile']);
        $tab_array['responsive'] = __( 'Responsive <small>New</small>', 'wpt_pro' );
        $tab_array['mobile'] = __( 'Mobile', 'wpt_pro' ); // <span>will remvoed</span>
        return $tab_array;
    }
}
//add_filter( 'wpto_admin_tab_array', 'wpt_admin_responsive_tab' );

if( !function_exists( 'wpt_admin_responsive_tab_save' ) ){
    function wpt_admin_responsive_tab_save( $save_tab_array ){
        $save_tab_array['responsive'] = 'responsive';
        return $save_tab_array;
    }
}
add_filter( 'wpto_save_tab_array', 'wpt_admin_responsive_tab_save' );

if( !function_exists( 'wpt_admin_responsive_tab_file' ) ){
    function wpt_admin_responsive_tab_file(){
        /**
         * you have return your new file, if u want it on Responsive Tab
         */
        //return 'my_new_location_will_be_here';
    }
}

//add_filter( 'wpto_admin_tab_file_loc_responsive', 'wpt_admin_responsive_tab_file' );


if( !function_exists( 'wpt_column_style_for_all' ) ){
    
    /**
     * Used:
     * do_action( 'wpto_column_setting_form', $keyword, $column_settings, $columns_array, $updated_columns_array, $post, $additional_data );
     * 
     * @param type $keyword
     * @param type $column_settings
     * @param type $columns_array
     */
    function wpt_column_style_for_all( $keyword, $_device_name, $column_settings, $columns_array, $updated_columns_array, $post, $additional_data ){
        
        $style_property = isset( $additional_data['css_property'] ) && is_array( $additional_data['css_property'] ) ? $additional_data['css_property'] : array(); 
        $class_name = "style_str{$_device_name}_{$keyword}";
        
        $item_name_style_str = "column_settings{$_device_name}[$keyword][style_str]";
        $style_str = isset( $column_settings[$keyword]['style_str'] ) ? $column_settings[$keyword]['style_str'] : false;

        $style_str_arr = explode( ";", $style_str );
        $style_str_arr = array_filter( $style_str_arr );
        $style = array();
        foreach( $style_str_arr as $each_style ){
            $each_style_property = explode( ": ", $each_style );
            $str_str_key_01 = !empty( $each_style_property[0] ) ? $each_style_property[0] : ' ';
            $str_str_key_02 = !empty( $each_style_property[1] ) ? $each_style_property[1] : ' ';
            $style[$str_str_key_01] = $str_str_key_02;
        }

        ?>
        
        <div 
            data-target_value_wrapper="<?php echo esc_attr( $class_name ); ?>"
            class="style_str_wrapper wpt-style-wrapper <?php echo esc_attr( $class_name ); ?> style-wrapper-<?php echo esc_attr( $keyword ); ?>">
            <input 
                type="hidden" 
                class="str_str_value_string"
                value="<?php echo esc_attr( $style_str ); ?>" name="<?php echo esc_attr( $item_name_style_str ); ?>">
            <h3 class="style-heading"><?php echo esc_html( 'Style Area', 'wpt_pro' ); ?></h3>
            <div class="wpt-style-body">
                <table class="ultraaddons-table <?php echo esc_attr( $class_name ); ?>_value_wrapper" style_str_value_wrapper>    
                <?php
                
                foreach( $style_property as $style_key => $label ){
                    $value = isset( $style[ $style_key ] ) ? $style[ $style_key ] : false;
                    ?>

                    <tr class="each-style each-style-<?php echo esc_attr( $style_key ); ?>">
                        <th><label><?php echo esc_html($label); ?></label></th>
                        <td>
                            <input 
                                class="ua_input wpt-<?php echo esc_attr( $style_key ); ?> str_str_each_value"
                                data-proerty_name="<?php echo esc_attr( $style_key ); ?>"
                                value="<?php echo esc_attr( $value ); ?>" 
                                placeholder="<?php echo esc_attr($label); ?>">   
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </table>  
                    <a href="javascript:void(0)" class="wpt-reset-style"><?php echo esc_html( 'Reset Style', 'wpt' ); ?></a>
            </div>
        </div>    
        
        <?php
    }
}

add_action( 'wpto_column_setting_form', 'wpt_column_style_for_all', 11, 7 );

if( !function_exists( 'wpt_convert_style_from_arr' ) ){
    function wpt_convert_style_from_arr( $style_arr = false ){
        $style_string = '';
        if( !empty( $style_arr ) && is_array( $style_arr ) ){
            $style_arr = array_filter( $style_arr );
            if( !is_array( $style_arr ) ){
                return '';
            }
            foreach($style_arr as $key => $stl){
                $style_string .= $key . ': ' . $stl . ';';
            }
        }
        
        return $style_string;
    }
}

if( !function_exists( 'wpt_data_manipulation_on_save' ) ){
    
    /**
     * Args Manipulation from Basic Tab
     * Used Filter:
     * $tab_data = apply_filters( 'wpto_tab_data_on_save', $tab_data, $tab, $post_id, $save_tab_array );
     * 
     * @param type $data
     * @return type
     */
    function wpt_data_manipulation_on_save( $tab_data, $tab, $post_id, $save_tab_array ){
        
        if( 'basics' == $tab && is_array( $tab_data ) ){
            
            /**
             * Query Relation for Taxonomy added
             * @version 2.8.3.5
             */
            $query_relation = ! isset( $tab_data['query_relation'] ) ? 'IN' : $tab_data['query_relation'];

            $data = isset( $tab_data['data'] ) ? $tab_data['data'] : false;
            $terms_string = 'terms';
            $terms = isset( $data[$terms_string] ) ? $data[$terms_string] : false;
            if( is_array( $terms ) ){
               foreach( $terms as $term_key => $term_ids ){
                   $term_key_IN = $term_key . '_' . $query_relation;//IN
                   $tab_data['args']['tax_query'][$term_key_IN] = array(
                            'taxonomy'      => $term_key,
                            'field'         => 'id',
                            'terms'         => $term_ids, //Array of Term's IDs
                            'operator'      => $query_relation,//'IN'
                   );
               } 
            }
            
        } 
//        if( 'column_settings' == $tab && is_array( $tab_data ) ){
//            foreach( $tab_data as $per_key => $per_data ){
//                if( !empty( $per_key ) && is_array( $per_data ) ){
//                    $tab_data[$per_key]['style_str'] = isset( $per_data['style'] ) && is_array( $per_data['style'] ) ? wpt_convert_style_from_arr( $per_data['style'] ) : '';
//                }
//            }
//        }
        
        return $tab_data;
    }
}
add_filter( 'wpto_tab_data_on_save', 'wpt_data_manipulation_on_save', 10, 4 );
