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


if( !function_exists( 'wpt_table_td_class' ) ){
    /**
     * Add TD Class
     * using Following Filter:
     * apply_filters( 'wpto_td_class_arr', $td_class_arr, $keyword, $table_ID, $args, $column_settings, $table_column_keywords, $product )
     * 
     * @since 7.0.25
     * @param type $td_class_arr
     * @return Array
     */
    function wpt_table_td_class( $td_class_arr, $keyword, $table_ID ){
        $not_acpt = array(
            'action',
            'product_title',
            'check'
        );
        if( in_array( $keyword, $not_acpt ) ){
            return $td_class_arr;
        }
        
        //var_dump($td_class_arr, $args, $table_ID);
        $mobile = get_post_meta( $table_ID, 'mobile', true );
        if( isset( $mobile['mobile_responsive'] ) && $mobile['mobile_responsive'] == 'mobile_responsive' ){
            $td_class_arr[] = 'wpt_for_product_desc';
        }
        //var_dump($td_class_arr);
       return $td_class_arr;
   }
}
add_filter( 'wpto_td_class_arr', 'wpt_table_td_class',10,3 );


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
        $items = apply_filters( 'wpto_inside_checked_item_arr', $items, $keyword, $column_settings, $columns_array );
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
        if( !empty( $config ) && is_array( $config ) && is_array( $config_value ) ){
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
                        $pr_id = apply_filters( 'wpto_id_of_item', $pr_id, $perItem );
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

/**
 * Displays or retrieves the HTML dropdown list of categories.
 *
 * The 'hierarchical' argument, which is disabled by default, will override the
 * depth argument, unless it is true. When the argument is false, it will
 * display all of the categories. When it is enabled it will use the value in
 * the 'depth' argument.
 *
 * @since 2.1.0
 * @since 4.2.0 Introduced the `value_field` argument.
 * @since 4.6.0 Introduced the `required` argument.
 *
 * @param array|string $args {
 *     Optional. Array or string of arguments to generate a categories drop-down element. See WP_Term_Query::__construct()
 *     for information on additional accepted arguments.
 *
 *     @type string       $show_option_all   Text to display for showing all categories. Default empty.
 *     @type string       $show_option_none  Text to display for showing no categories. Default empty.
 *     @type string       $option_none_value Value to use when no category is selected. Default empty.
 *     @type string       $orderby           Which column to use for ordering categories. See get_terms() for a list
 *                                           of accepted values. Default 'id' (term_id).
 *     @type bool         $pad_counts        See get_terms() for an argument description. Default false.
 *     @type bool|int     $show_count        Whether to include post counts. Accepts 0, 1, or their bool equivalents.
 *                                           Default 0.
 *     @type bool|int     $echo              Whether to echo or return the generated markup. Accepts 0, 1, or their
 *                                           bool equivalents. Default 1.
 *     @type bool|int     $hierarchical      Whether to traverse the taxonomy hierarchy. Accepts 0, 1, or their bool
 *                                           equivalents. Default 0.
 *     @type int          $depth             Maximum depth. Default 0.
 *     @type int          $tab_index         Tab index for the select element. Default 0 (no tabindex).
 *     @type string       $name              Value for the 'name' attribute of the select element. Default 'cat'.
 *     @type string       $id                Value for the 'id' attribute of the select element. Defaults to the value
 *                                           of `$name`.
 *     @type string       $class             Value for the 'class' attribute of the select element. Default 'postform'.
 *     @type int|string   $selected          Value of the option that should be selected. Default 0.
 *     @type string       $value_field       Term field that should be used to populate the 'value' attribute
 *                                           of the option elements. Accepts any valid term field: 'term_id', 'name',
 *                                           'slug', 'term_group', 'term_taxonomy_id', 'taxonomy', 'description',
 *                                           'parent', 'count'. Default 'term_id'.
 *     @type string|array $taxonomy          Name of the taxonomy or taxonomies to retrieve. Default 'category'.
 *     @type bool         $hide_if_empty     True to skip generating markup if no categories are found.
 *                                           Default false (create select element even if no categories are found).
 *     @type bool         $multiple          Whether the `<select>` element should have the HTML5 'required' attribute.
 *                                           Default false.
 * }
 * @return string HTML dropdown list of categories.
 */
function wpt_wp_dropdown_categories( $args = '', $get_taxonomy = false ) {
	$defaults = array(
		'show_option_all'   => '',
		'show_option_none'  => '',
		'orderby'           => 'id',
		'order'             => 'ASC',
		'show_count'        => 0,
		'hide_empty'        => 1,
		'child_of'          => 0,
		'exclude'           => '',
		'echo'              => 1,
		'selected'          => 0,
		'hierarchical'      => 0,
		'name'              => 'cat',
		'id'                => '',
		'class'             => 'postform',
		'depth'             => 0,
		'tab_index'         => 0,
		'taxonomy'          => 'category',
		'hide_if_empty'     => false,
		'option_none_value' => -1,
		'value_field'       => 'term_id',
		'multiple'          => false,
                'data-key'          => false,
	);
        
	$defaults['selected'] = ( is_category() ) ? get_query_var( 'cat' ) : 0;

	// Back compat.
	if ( isset( $args['type'] ) && 'link' === $args['type'] ) {
		_deprecated_argument(
			__FUNCTION__,
			'3.0.0',
			sprintf(
				/* translators: 1: "type => link", 2: "taxonomy => link_category" */
				__( '%1$s is deprecated. Use %2$s instead.' ),
				'<code>type => link</code>',
				'<code>taxonomy => link_category</code>'
			)
		);
		$args['taxonomy'] = 'link_category';
	}

	// Parse incoming $args into an array and merge it with $defaults.
	$parsed_args = wp_parse_args( $args, $defaults );

	$option_none_value = $parsed_args['option_none_value'];

	if ( ! isset( $parsed_args['pad_counts'] ) && $parsed_args['show_count'] && $parsed_args['hierarchical'] ) {
		$parsed_args['pad_counts'] = true;
	}

	$tab_index = $parsed_args['tab_index'];

	$tab_index_attribute = '';
	if ( (int) $tab_index > 0 ) {
		$tab_index_attribute = " tabindex=\"$tab_index\"";
	}

	// Avoid clashes with the 'name' param of get_terms().
	$get_terms_args = $parsed_args;
	unset( $get_terms_args['name'] );
	$categories = get_terms( $get_terms_args );

        if( is_array( $get_taxonomy ) && ! empty( $get_taxonomy ) ){
            $categories = $get_taxonomy;
        }

	$name     = esc_attr( $parsed_args['name'] );
	$class    = esc_attr( $parsed_args['class'] );
	$id       = $parsed_args['id'] ? esc_attr( $parsed_args['id'] ) : $name;
	$multiple = $parsed_args['multiple'] ? 'multiple' : '';

	$data_key = $parsed_args['data-key'] ? esc_attr( $parsed_args['data-key'] ) : '';

	if ( ! $parsed_args['hide_if_empty'] || ! empty( $categories ) ) {
		$output = "<select  data-key='$data_key' $multiple name='$name' id='$id' class='$class' $tab_index_attribute>\n";
	} else {
		$output = '';
	}
	if ( empty( $categories ) && ! $parsed_args['hide_if_empty'] && ! empty( $parsed_args['show_option_none'] ) ) {

		/**
		 * Filters a taxonomy drop-down display element.
		 *
		 * A variety of taxonomy drop-down display elements can be modified
		 * just prior to display via this filter. Filterable arguments include
		 * 'show_option_none', 'show_option_all', and various forms of the
		 * term name.
		 *
		 * @since 1.2.0
		 *
		 * @see wp_dropdown_categories()
		 *
		 * @param string       $element  Category name.
		 * @param WP_Term|null $category The category object, or null if there's no corresponding category.
		 */
		$show_option_none = apply_filters( 'list_cats', $parsed_args['show_option_none'], null );
		$output          .= "\t<option value='" . esc_attr( $option_none_value ) . "' selected='selected'>$show_option_none</option>\n";
	}

	if ( ! empty( $categories ) ) {

		if ( $parsed_args['show_option_all'] ) {

			/** This filter is documented in wp-includes/category-template.php */
			$show_option_all = apply_filters( 'list_cats', $parsed_args['show_option_all'], null );
			$selected        = ( '0' === (string) $parsed_args['selected'] ) ? " selected='selected'" : '';
			$output         .= "\t<option value=''$selected>$show_option_all</option>\n";
		}

		if ( $parsed_args['show_option_none'] ) {

			/** This filter is documented in wp-includes/category-template.php */
			$show_option_none = apply_filters( 'list_cats', $parsed_args['show_option_none'], null );
			$selected         = selected( $option_none_value, $parsed_args['selected'], false );
			$output          .= "\t<option value='" . esc_attr( $option_none_value ) . "'$selected>$show_option_none</option>\n";
		}

		if ( $parsed_args['hierarchical'] ) {
			$depth = $parsed_args['depth'];  // Walk the full depth.
		} else {
			$depth = -1; // Flat.
		}
                //var_dump($categories, $depth, $parsed_args);
		$output .= walk_category_dropdown_tree( $categories, $depth, $parsed_args );
	}

	if ( ! $parsed_args['hide_if_empty'] || ! empty( $categories ) ) {
		$output .= "</select>\n";
	}

	/**
	 * Filters the taxonomy drop-down output.
	 *
	 * @since 2.1.0
	 *
	 * @param string $output      HTML output.
	 * @param array  $parsed_args Arguments used to build the drop-down.
	 */
	$output = apply_filters( 'wp_dropdown_cats', $output, $parsed_args );

	if ( $parsed_args['echo'] ) {
		echo $output;
	}

	return $output;
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
     * This is deprecated now. We have used new file for this part
     * new file is: includes/variation_html.php 
     * 
     * For Variable product, Variation's attribute will generate to select tag
     * 
     * @deprecated since 2.7.8 2.7.8.0
     * 
     * @param   Array   $attributes
     * @param   Int     $product_id
     * @param   Int     $temp_number
     * @return  string  HTML Select tag will generate from Attribute
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


if( !function_exists( 'wpt_table_edit_link' ) ){
    
    /**
     * Adding Edit Table link at the bottom of Table
     * Using Action:
     * do_action( 'wpto_table_wrapper_bottom', $table_ID, $args, $config_value, $atts )
     * 
     * @global type $post
     * @global type $shortCodeText
     * @param type $table_ID
     * @return string
     */
    function wpt_table_edit_link( $table_ID ) {
        if( !current_user_can( WPT_CAPABILITY ) ) return null;
        $table_ID = (int) $table_ID;
        ?>
        <div class="wpt_edit_table">
            <a href="<?php echo esc_attr( admin_url( 'post.php?post=' . $table_ID . '&action=edit&classic-editor' ) ); ?>" 
                            target="_blank"
                            title="<?php echo esc_attr( 'Edit your table. It will open on new tab.', 'wpt_pro' ); ?>"
                            >
            <?php echo esc_html__( 'Edit Table - ', 'wpt_pro' ); ?>
            <?php echo esc_html( get_the_title( $table_ID ) ); ?>
            </a>   
        </div> 
        <?php
    }
}
add_action( 'wpto_table_wrapper_bottom', 'wpt_table_edit_link', 99 );


if( !function_exists( 'wpt_args_manipulation_frontend' ) ){
    /**
     * IN FREE
     * Args Manipulation for FrontEnd
     * By Useing following Filter
     * $args = apply_filters( 'wpto_table_query_args', $args, $table_ID, $atts, $column_settings, $enabled_column_array, $column_array );
     * 
     * @param type $args
     * @param type $table_ID
     * @param type $atts
     * @param type $column_settings
     * @param type $enabled_column_array
     * @param type $column_array
     * @return type
     */
    function wpt_args_manipulation_frontend( $args ){

        if( is_page() || is_single() ){
            return $args;
        }
        //MainTain for Archives Page
        global $wpdb;
        $query_vars = isset( $GLOBALS['wp_query']->query_vars ) ? $GLOBALS['wp_query']->query_vars : false;
        //var_dump($query_vars);
        $page_query = isset( $GLOBALS['wp_query'] ) ? $GLOBALS['wp_query']->query_vars : null;
        $args_product_in = false;
        if( ( isset( $query_vars['post_type'] ) && !empty( $query_vars['post_type'] ) && $query_vars['post_type'] == 'product' ) 
                || ( isset( $page_query['wc_query'] ) && $page_query['wc_query'] == 'product_query' ) 
            ){
            
            if( isset( $args['post__in'] ) && is_array( $args['post__in'] ) && count( $args['post__in'] ) > 0 ){
                return $args;
            }
            
        //if( isset( $page_query['wc_query'] ) && $page_query['wc_query'] == 'product_query' ){
            $gen_args = array_merge( $args,$GLOBALS['wp_query']->query_vars );
            $gen_args['post_type'] = isset( $args['post_type'] ) && !empty( $args['post_type'] ) ? $args['post_type'] : 'product';
            $args = $gen_args;

            $sql = $GLOBALS['wp_query']->request;
            $results = $wpdb->get_results( $sql, ARRAY_A );
            $args_product_in = array();
            foreach( $results as $result ){
                $args_product_in[] = $result['ID'];
            }
            $args['post__in'] = $args_product_in;
            $args['paged'] = 0;
            unset( $args['tax_query'] );
            unset( $args['term'] );
            unset( $args['meta_query'] );
        }
        //var_dump($args);
        return $args;
    }
}
add_filter( 'wpto_table_query_args', 'wpt_args_manipulation_frontend' );

if( !function_exists( 'wpt_freeze_column_maintain' ) ){

    /**
     * Freeze Column Maintain using following Action Hook
     * do_action( 'wpto_table_wrapper_bottom', $table_ID, $args, $column_settings, $enabled_column_array, $config_value, $atts );
     * 
     * @param type $table_ID
     * @param type $args
     * @param type $column_settings
     * @param type $enabled_column_array
     */
    function wpt_freeze_column_maintain( $table_ID, $args, $column_settings, $enabled_column_array ){
        $style = false;
        if( isset( $enabled_column_array['freeze'] ) && $column_settings['freeze'] ){
            $style = isset( $column_settings['freeze']['style'] ) ? $column_settings['freeze']['style'] : false;
        }
        if( $style ){
            $default_width = apply_filters( 'wpto_default_width_freeze_col', '120px', $table_ID );
            $width = isset( $style['width'] ) && !empty( $style['width'] ) ? $style['width'] : $default_width;
            $selector = '#table_id_' . $table_ID . ' .wpt_table_tag_wrapper';
            
            /*
            $css_code = <<<EOF
<style>
$selector th.wpt_freeze,$selector td.wpt_freeze {
    position: absolute;
    left: 0;
    top: auto;
    width: $width;
}

$selector td.td_or_cell.wpt_freeze .item_inside_cell{display: inline-block;}
$selector, $selector table, $selector tr{position: static;}
$selector{margin-left: $width;}  
</style>
EOF;
    */        
            
ob_start();
?>
<style>
 <?php echo $selector; ?> th.wpt_freeze,<?php echo $selector; ?> td.wpt_freeze {
    position: absolute;
    left: 0;
    top: auto;
    width: <?php echo $width; ?>;
}
<?php echo $selector; ?> th.wpt_freeze{}
<?php echo $selector; ?> td.td_or_cell.wpt_freeze .item_inside_cell{display: inline-block;}
<?php echo $selector; ?>, <?php echo $selector; ?> table, <?php echo $selector; ?> tr{position: static;}
<?php echo $selector; ?>{margin-left: <?php echo $width; ?>;}  
</style>
<script>
    (function($) {
    'use strict';
        $(document).ready(function($){
            var height = $('<?php echo $selector; ?> table tr').not('.wpt_freeze').height();
            console.log(height);
            //height = 100;
            $('th.wpt_freeze').css('height', height);
        });
    })(jQuery);
    
</script>                    
                    
                    
                    
                    
                    
                    
                    
                    
<?php
$css_code = ob_get_clean();            
            echo $css_code;
        }
    }
}
add_action( 'wpto_table_wrapper_bottom', 'wpt_freeze_column_maintain',9910,4 );

if( !function_exists( 'wpt_add_div_at_top' ) ){

    /**
     * Add a new div at the top of the table, To add a Wrapper wrapper at the Top
     * 
     * @param Int $table_ID
     * @since 2.7.5.2
     * @date 11 Oct, 2020
     */
    function wpt_add_div_at_top( $table_ID ){
    ?>
<div data-product_id="<?php echo esc_attr( $table_ID ); ?>" class="wpt_second_wrapper wpt_second_wrapper_<?php echo esc_attr( $table_ID ); ?>">
    <div class="wpt_second_content">
    </div>
</div>    
    <?php
    }
}
add_action( 'wpto_action_before_table', 'wpt_add_div_at_top' );

if( !function_exists( 'wpt_item_manage_from_theme' ) ){

    /**
     * Managing Final File Location 
     * Actually if a user keep his Item Template file at His theme,
     * That will get First Priority 
     * Then template file will come from user defined template location
     * We have used following Filter
     * apply_filters( 'wpto_item_final_loc', $file, $file_name, $items_directory_2, $keyword, $table_ID, $settings, $items_permanent_dir );
     * 
     * To get Item's Template From Active Theme, Use following Directory
     * [YourTheme]/woo-product-table/items/[YourItemFileName].php
     * 
     * Suppose, Item name is price, than location/directory from theme will be:
     * [YourTheme]/woo-product-table/items/price.php
     * 
     * @param type $file
     * @param type $items_directory_2
     * @param type $file_name
     * 
     * @return type $file This Function will return $file Location of Items
     */
    function wpt_item_manage_from_theme( $file, $file_name ){
        $file_frm_theme = get_stylesheet_directory() . '/woo-product-table/items/' . $file_name . '.php';
        if( file_exists( $file_frm_theme ) ){
            return $file_frm_theme;
        }
        return $file;
    }
}
add_filter( 'wpto_item_final_loc', 'wpt_item_manage_from_theme', 1, 2 );

if( !function_exists( 'wpt_add_td_class' ) ){
    
    /**
     * Add Class on Td for Table
     * 
     * @param type $class_arr
     * @return Array
     */
    function wpt_add_td_class( $class_arr, $keyword, $table_ID, $args, $column_settings ){
        if( isset( $column_settings[$keyword] ) && is_array( $column_settings[$keyword] ) ){
            foreach( $column_settings[$keyword] as $key=>$eachClass ){
                $class_arr[] = is_string( $eachClass ) && $key !== 'tag_class' && $key !== 'style_str' ? str_replace(' ','-', $key . '_' . $eachClass) : false;
            }
        }
        $class_arr = array_filter( $class_arr );
        return $class_arr;
    }
}
add_filter('wpto_td_class_arr', 'wpt_add_td_class', 10, 5);



if( ! function_exists( 'wpt_search_box_validation_on_off' ) ){
    
    /**
     * Primarily I have set Search page off on shop page, wc Arcive page
     * 
     * 
     * 
     * @since 2.7.8.2
     * 
     * @return Bool
     */
    function wpt_search_box_validation_on_off(){
        
        if( is_product_taxonomy() || is_shop() ){
            return false;
        }
        return true;
    }
}
add_filter( 'wpto_searchbox_show', 'wpt_search_box_validation_on_off' );


if( ! function_exists( 'wpt_table_preview_template_manager' ) ){
    /**
     * Not Activated Yet. Will Enable Asap
     * 
     * Normally Content show from page.php file of theme.
     * We have set Custom Template File for our Table.
     * If anybody click on Preview for Table
     * 
     * @param type $template_file Default Template , provided by WordPress Script
     * 
     * @since 2.7.8.1
     * 
     * @return type Manage Template Function
     */
    function wpt_table_preview_template_manager( $template_file ){
        if( ! is_singular() ){
            return $template_file;
        }
        $type = get_post_type();
        if( $type == 'wpt_product_table' ){
            $template = WPT_BASE_DIR . 'includes/preview_table.php';
            var_dump($template);
            return is_file( $template ) ? $template : $template_file;
        }

        return $template_file;
    }
}
//add_filter( 'template_include', 'wpt_table_preview_template_manager' );

if( ! function_exists( 'wpt_user_roles_by_id' ) ){
    
    /**
     * Get user roles by user ID.
     * 
     * https://wordpress.stackexchange.com/questions/58916/how-to-get-role-of-user
     * @param  int $id
     * @return array
     */
    function wpt_user_roles_by_id( $id )
    {
        $user = new WP_User( $id );

        if ( empty ( $user->roles ) or ! is_array( $user->roles ) )
            return array ();

        return $user->roles;
    }
}

if( !function_exists( 'wpt_shop_archive_sorting_args' ) ){
    
    /**
     * This function has fixed shop archive default sorting issue.
     * 
     * @param type $args
     * @return array $args
     */
    function wpt_shop_archive_sorting_args( $args ){
        if( is_shop() || is_product_taxonomy() ){
            $_orderby = isset( $_GET['orderby'] ) && !empty( $_GET['orderby'] ) ? $_GET['orderby'] : '';
            $args['paged'] = 1;
            $args['post_type'] = ['product'];
            switch( $_orderby ){
                case 'price':
                        $args['orderby'] = 'meta_value_num';
                        $args['order'] = 'asc';
                        $args['meta_key'] = '_price';
                    break;
                case 'price-desc':
                        $args['orderby'] = 'meta_value_num';
                        $args['order'] = 'desc';
                        $args['meta_key'] = '_price';
                    break;
                case 'rating':
                        $args['orderby'] = 'meta_value_num';
                        $args['order'] = 'desc';
                        $args['meta_key'] = '_wc_average_rating';
                   break;
                case 'popularity':
                        $args['orderby'] = 'meta_value_num';
                        $args['order'] = 'desc';
                        $args['meta_key'] = 'total_sales';
                    break;
                case 'date':
                        $args['order'] = 'desc';
                    break;
            }
        }
        return $args;
    }
}
add_filter( 'wpto_table_query_args_in_row', 'wpt_shop_archive_sorting_args', 10 );

/**
 * Astra Theme Compatibility
 * 
 * Quantity Plus Minus Button issue solved by removed from Theme
 * Only for Astra Theme
 * 
 * TIPS: At this situation, Need https://wordpress.org/plugins/wc-quantity-plus-minus-button/ Plugin
 * 
 * @since 2.8.3.2
 * 
 * @date 3.2.2021
 * @by Saiful
 */
add_filter( 'astra_add_to_cart_quantity_btn_enabled', '__return_false' ); 



if( !function_exists( 'wpt_ajax_on_first_load' ) ){
    /**
     * Compability Code for WavePlayer
     * 
     * We actually added this code for
     * WavePlayer
     * 
     * Because,
     * If u want to enable this code, u have to use following ACTION HOOK to your theme/plugin
     * Also can use CodeSnipet Plugin.
     * 
     * Hook is: 
     * add_action( 'wp_footer', 'wpt_ajax_on_first_load', 100 );
     * 
     * CodeSnippet Plugin URL: https://wordpress.org/plugins/code-snippets/
     * 
     * @since 2.8.3.5
     * @date 8.2.2021 d.m.y
     * @by Saiful
     * @helped Mukul and Bari
     */
    function wpt_ajax_on_first_load(){

$output = <<<EOT
<script id='by-woo-product-table'>
jQuery(document).ready(function($){
    $("button.wpt_search_button").trigger("click");
});
</script>
EOT;
        echo $output;
    }
}
//add_action( 'wp_footer', 'wpt_ajax_on_first_load', 100 );