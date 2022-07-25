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
     * get_option( WPT_OPTION_KEY )
     * 
     * @since 2.4 
     */
    function wpt_selected(  $keyword, $gotten_value, $default_config = false ){
        $current_config_value = is_array( $default_config ) ? $default_config : get_option( WPT_OPTION_KEY );
        echo ( isset( $current_config_value[$keyword] ) && $current_config_value[$keyword] == $gotten_value ? 'selected' : false  );
    }
}
if( !function_exists( 'wpt_default_option' ) ){
    
    /**
     * Getting default option tag
     * for Configuration tab on Product edit
     * 
     * Actually we need a blank default option tag for select tab
     * when inside configuration tab
     * 
     * @param String $page
     */
    function wpt_default_option( $page ){
        $html = "";
        if( $page == 'wpt_configuration_tab' ){
            $default = esc_html__( "Default", 'wpt_pro' );
            $html .= "<option value=''>$default</option>";
        }
        echo $html;
    }
}

/**
 * Remove empty Array value from an Multi-dimensional Array
 * I have taken help from a stackoverflow tips.
 *
 * @param Array $array Obviously should be an Array
 * @return Array
 * 
 * @link https://stackoverflow.com/questions/9895130/recursively-remove-empty-elements-and-subarrays-from-a-multi-dimensional-array
 * 
 */
function wpt_remove_empty_value_from_array( $array ){


    if( ! is_array( $array ) ) return $array;
    // foreach($array as $key=>&$arr){
    //     if( empty( $arr ) ){
    //         unset( $array[$key] );
    //     }
    //     if( is_array($arr) ){
    //         wpt_remove_empty_value_from_array( $arr );
    //     }
    // }
    // return $array;

    // $array = array_filter($array,function($val){
    //     if( is_array( $val ) ){
    //         return wpt_remove_empty_value_from_array( $val );
    //     }
    //     return ! empty($val);
    // });

    // $array = array_filter(array_map('array_filter', $array));
    // return $array;

    foreach ($array as $key => &$value) {
        if ( ! is_bool( $value ) && empty($value)) {
           unset($array[$key]);
        }
        else {
           if (is_array($value)) {
              $value = wpt_remove_empty_value_from_array($value);
              if (! is_bool( $value ) && empty($value)) {
                 unset($array[$key]);
              }
           }
        }
     }
  
     return $array;
}



/**
 * User wise limit function,
 * we will detect new user
 * based on date 12 Oct, 2021
 * 
 * if have post on product table before that date,
 * we will consider as old user
 * 
 * @since 3.0.1.0
 */
function wpt_datewise_validation(){
    //If pro available, directly return true
    if( defined( 'WPT_PRO_DEV_VERSION' ) ) return true;
    
    $prev_args = array(
        'post_type' => 'wpt_product_table',
        'date_query' => array(
            'before' => '2022-3-15' 
          ),
    );
    
    $prev_query = new WP_Query( $prev_args );
    $prev_total = $prev_query->found_posts;
    if($prev_total>0) return true;
    
    $args = array(
        'post_type' => 'wpt_product_table',
        'post_status' => 'publish',
    );
    
    $query = new WP_Query( $args );
    $total = $query->found_posts;

     return $total <= 2; //Limitation upto 4 //limitation has changed upto 2
}

/**
 * Alias function of wpt_datewise_validation()
 * to validation check for old and new user
 * 
 * @since 3.0.1.0 
 * @return bool true|false
 */
function wpt_user_can_edit(){
    return wpt_datewise_validation();
}

function wpt_get_pro_discount_message(){
    return;

}


/**
 * check pro available or not
 * 
 * @since 3.0.1
 * @by Saiful
 * 
 * @return boolean true|false
 */
function wpt_is_pro(){
    if( defined( 'WPT_PRO_DEV_VERSION' ) ) return true;
    
    return false;
}


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

if( ! function_exists( 'wpt_add_tabs' ) ){
    /**
     * Help Screens Message added
     * Mainly this feature added by Mukul, but this comment added by Saiful
     * 
     * @since 3.0.0.0
     *
     * @return void
     */
    function wpt_add_tabs(){
        $screen = get_current_screen();
        $is_wpt_page = strpos($screen->id, 'wpt_product_table');
        
		if ( ! $screen || !( false !== $is_wpt_page ) ) {
            return;
		}
        // var_dump($is_wpt_page,false !== $is_wpt_page,$screen);

        $screen->add_help_tab(
			array(
				'id'      => 'wpt_support_tab',
				'title'   => __( 'Help &amp; Support', 'wpt_pro' ),
				'content' =>
					'<h2>' . __( 'Help &amp; Support', 'wpt_pro' ) . '</h2>' .
					'<p>' . sprintf(
						/* translators: %s: Documentation URL */
						__( 'Should you need help understanding, using, or extending Product Table for WooCommerce, <a href="%s">please read our documentation</a>. You will find all kinds of resources including snippets, tutorials and much more.', 'wpt_pro' ),
						'https://wooproducttable.com/documentation/?utm_source=helptab&utm_content=docs&utm_campaign=wptplugin'
					) . '</p>' .
					'<p>' . sprintf(
						/* translators: %s: Forum URL */
						__( 'For further assistance with Product Table for WooCommerce, use the <a href="%1$s">community forum</a>. For help with premium support, <a href="%2$s">open a support request at CodeAstrology.com</a>.', 'wpt_pro' ),
						'https://wordpress.org/support/plugin/woo-product-table/',
						'https://codeastrology.com/support/submit-ticket/?utm_source=helptab&utm_content=tickets&utm_campaign=wptplugin'
					) . '</p>' .
					'<p><a href="https://wordpress.org/support/plugin/woo-product-table/" class="button">' . __( 'Community forum', 'wpt_pro' ) . '</a> <a href="https://codeastrology.com/support/submit-ticket/?utm_source=helptab&utm_content=tickets&utm_campaign=wptplugin" class="button">' . __( 'CodeAstrology.com support', 'wpt_pro' ) . '</a></p>',
			)
		);

        $screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'wpt_pro' ) . '</strong></p>' .
			'<p><a href="https://wooproducttable.com/?utm_source=helptab&utm_content=about&utm_campaign=wptplugin" target="_blank">' . __( 'About Product Table', 'wpt_pro' ) . '</a></p>' .
			'<p><a href="https://wordpress.org/support/plugin/woo-product-table/" target="_blank">' . __( 'WordPress.org', 'wpt_pro' ) . '</a></p>' .
			'<p><a href="https://wooproducttable.com/pricing" target="_blank">' . __( 'Premium Plugin ', 'wpt_pro' ) . '</a></p>' .
			'<p><a href="https://github.com/codersaiful/woo-product-table/" target="_blank">' . __( 'Github project', 'wpt_pro' ) . '</a></p>' .
			'<p><a href="https://wordpress.org/themes/astha/" target="_blank">' . __( 'Official theme', 'wpt_pro' ) . '</a></p>' .
			'<p><a href="https://codecanyon.net/user/codeastrology/?utm_source=helptab&utm_content=wptotherplugins&utm_campaign=wptplugin" target="_blank">' . __( 'Other Premium Plugins', 'wpt_pro' ) . '</a></p>'
		);

    }
}
add_action( 'current_screen', 'wpt_add_tabs', 50 );


function wpt_get_free_templates(){
    $templates_default = array(
        'none'              =>  __( 'Select None', 'wpt_pro' ),
        'default'           =>  __( 'Default Style', 'wpt_pro' ),
        'beautiful_blacky'  =>  __( 'Beautiful Blacky', 'wpt_pro' ),
        'classic'           =>  __( 'Classic', 'wpt_pro' ),    
        'blue_border'       =>  __( 'Blue Border', 'wpt_pro' ),
        'smart_border'      =>  __( 'Smart Border', 'wpt_pro' ), 
        'pink'              =>  __( 'Pink Style', 'wpt_pro' ),  
        'modern'            =>  __( 'Modern Style', 'wpt_pro' ),  
        'orange'            =>  __( 'Orange Style', 'wpt_pro' ),   
    );

    return $templates_default;
}
if( ! function_exists( 'wpt_get_pro_templates' ) ){
    function wpt_get_pro_templates(){
        $pro_templates = array(
            'smart'         =>  __( 'Smart Thin', 'wpt_pro' ),
            'green'         =>  __( 'Green Style', 'wpt_pro' ),
            'blue'          =>  __( 'Blue Style', 'wpt_pro' ),
            'dark'          =>  __( 'Dark Style', 'wpt_pro' ),
            'smart_light'   =>  __( 'Smart Light', 'wpt_pro' ),
            'custom'       =>  __( 'Customized Design', 'wpt_pro' ),
        );
        return $pro_templates;
    }
}