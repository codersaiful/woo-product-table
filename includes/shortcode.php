<?php


if( ! function_exists( 'wpt_price_formatter' ) ){
    /**
     * Price Formater, Getting data from Woocommerce Default Formatter
     * 
     * @return string
     */
    function wpt_price_formatter(){

        $price_format = get_woocommerce_price_format();
        $curr_pos = '';
        switch($price_format){
            case '%1$s%2$s':
                $curr_pos = 'left';
                break;
            case '%2$s%1$s':
                $curr_pos = 'right';
                break;
            case '%1$s&nbsp;%2$s':
                $curr_pos = 'left-space';
                break;
            case '%2$s&nbsp;%1$s':
                $curr_pos = 'right-space';
                break;
        }
        return $curr_pos;
    }
}



if( ! function_exists( 'wpt_texonomy_search_generator' ) ){

    /**
     * Texonomy select box for Texonomy.
     * 
     * @param type $texonomy_keyword
     * @param type $temp_number
     * @param type $current_select_texonomies
     * @return string|boolean
     */
    function wpt_texonomy_search_generator( $texonomy_keyword, $temp_number , $search_n_filter = false){

        $selected_taxs = isset( $search_n_filter[$texonomy_keyword] ) ? $search_n_filter[$texonomy_keyword] : false;
        //Added at 3.1 date: 10.9.2018
        //$config_value = get_option('wpt_configure_options');
        $config_value = wpt_get_config_value( $temp_number ); //V5.0 temp number is post_ID , $table_ID
        $html = false;
        if( !$texonomy_keyword || is_array( $texonomy_keyword )){
            return false;
        }

        /**
         * Need for get_texonomy and get_terms
         */
        $texonomy_sarch_args = array('hide_empty' => true,'orderby' => 'count','order' => 'ASC');

        $taxonomy_details = get_taxonomy( $texonomy_keyword );

        if( !$taxonomy_details ){
            return false;
        }
        $label = apply_filters( 'wpto_searchbox_taxonomy_name', $taxonomy_details->labels->menu_name, $taxonomy_details, $temp_number );//label;
        $label = __( $label, 'woo-product-table' );
        $label_all_items = $taxonomy_details->labels->all_items;
        $html .= "<div class='search_single search_single_texonomy search_single_{$texonomy_keyword}'>";
        $html .= "<label class='search_keyword_label {$texonomy_keyword}' for='{$texonomy_keyword}_{$temp_number}'>{$label}</label>";

        $multiple_selectable = apply_filters( 'wpto_is_multiple_selectable', false, $texonomy_keyword, $temp_number ) ? 'multiple' : '';

        // $taxonomy_sorting = $config_value['sort_searchbox_filter'] ?? '0';
        // if($taxonomy_sorting == '0'){
            // $defaults['orderby'] = '';
            // $defaults['order'] = '';
        // }
        $tx_order = $config_value['sort_searchbox_filter'] ?? 'ASC';
        $defaults = array(
		'show_option_all'   => '',
		'show_option_none'  => '',
		'orderby'           => 'name',
		'order'             => $tx_order,//'ASC', //$config_value['sort_searchbox_filter'],//
		'show_count'        => 0,
		'hide_empty'        => 1,
		'child_of'          => 0,
		'exclude'           => '',
		'echo'              => 0,//1,
		'selected'          => 0,
		'hierarchical'      => 1,//0, // 1 for Tree format, and 0 for plane format
		'name'              => $texonomy_keyword,//'cat',
		'id'                => $texonomy_keyword . '_' . $temp_number,//'',
		'class'             => "search_select query search_select_" . $texonomy_keyword,//'postform',
		'depth'             => 0,
		'tab_index'         => 0,
		'taxonomy'          => $texonomy_keyword,//'category',
		'hide_if_empty'     => false,
		'option_none_value' => -1,
		'value_field'       => 'term_id',
		'multiple'          => $multiple_selectable,
        'data-key'          => $texonomy_keyword,
	);
        if( ! $multiple_selectable ){
            $defaults['show_option_all'] = __( $label_all_items, 'woo-product-table' );
        }
        
        /**
         * we have removed this filter for new version.
         * 
         * @deprecated since version 2.8.3.5
         */
        $defaults = apply_filters( 'wpto_dropdown_categories_default', $defaults, $texonomy_keyword,$taxonomy_details, $temp_number );
        
        /**
         * Replaced a filter wpt_seachbox_tax_args instead of wpto_dropdown_taxonomy_default_args
         * wpt_seachbox_tax_args
         * wpto_dropdown_taxonomy_default_args
         * 
         * Actually name was to long, I have just changed it to short
         * 
         * @since 3.3.9.0
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        $defaults = apply_filters( 'wpt_seachbox_tax_args', $defaults, $texonomy_keyword,$taxonomy_details, $temp_number );
        
        if( $selected_taxs && is_array( $selected_taxs ) && count( $selected_taxs ) > 0 ){
            $customized_texonomy_boj = array();
            foreach( $selected_taxs as $termID ){
                $singleTerm = get_term( $termID );
                $name = $singleTerm->name;
                $customized_texonomy_boj[] = $singleTerm;

            }
        }else{
            $customized_texonomy_boj = false;
        }

        
        if( is_array( $customized_texonomy_boj ) && ! empty( $tx_order ) && $tx_order !== '0' ){

            usort( $customized_texonomy_boj,function($prev,$next){
                $tx_order = wpt_get_config('sort_searchbox_filter');
                if( $tx_order == 'ASC' ) return $prev->name > $next->name ? 1 : -1;
                if( $tx_order == 'DESC' ) return $prev->name > $next->name ? -1 : 1;
                
             
                // if($prev->name == $next->name) return 0;
                // var_dump($prev->name,$next->name);
                return 0;
            });
        }
       
        $html .= wpt_wp_dropdown_categories( $defaults, $customized_texonomy_boj );

        $html .= "</div>"; //End of .search_single

        return $html;
    }
}

if( ! function_exists( 'wpt_sorting_array' ) ){

    /**
     * Sorting Associative array based on ASC,DESC or None.
     * 
     * @param array $array Associative Array
     * @param string $sorting_type Available type ASC,DESC,None
     * @return Array
     */
    function wpt_sorting_array( $array, $sorting_type ){

        if( $sorting_type == 'ASC' ){
            ksort( $array );
        }else if( $sorting_type == 'DESC' ){
            krsort( $array );
        }

        return $array;
    }
}

if( ! function_exists( 'wpt_texonomy_filter_generator' ) ){

    /**
     * Texonomy select for Filter -- Texonomy.
     * 
     * @param type $texonomy_keyword
     * @param type $temp_number
     * @param type $current_select_texonomies
     * @return string|boolean
     */
    function wpt_texonomy_filter_generator( $texonomy_keyword, $temp_number ){

        $config_value = wpt_get_config_value( $temp_number ); //V5.0 temp number is post_ID , $table_ID
        $html = false;
        if( !$texonomy_keyword || is_array( $texonomy_keyword )){
            return false;
        }

        /**
         * Need for get_texonomy and get_terms
         */
        $texonomy_sarch_args = array('hide_empty' => true,'orderby' => 'count','order' => 'DESC');

            $taxonomy_details = get_taxonomy( $texonomy_keyword );
            if( !$taxonomy_details ){
                return false;
            }

            $label = $taxonomy_details->labels->singular_name;
            $html .= "<select data-temp_number='{$temp_number}' data-key='{$texonomy_keyword}' data-label='{$label}' class='filter_select select2 filter filter_select_{$texonomy_keyword}' id='{$texonomy_keyword}_{$temp_number}'>";

                $texonomy_boj = get_terms( $texonomy_keyword, $texonomy_sarch_args );
                
            $html .= "</select>";
        return $html;
    }
}

if( !function_exists( 'wpt_search_box' ) ){
    /**
     * ##########################
     * THIS WILL REMOVED
     * ##########################
     * 
     * Total Search box Generator
     * 
     * @param type $temp_number It's a Temporay Number for each Table,
     * @param type $search_box_texonomiy_keyword Obviously should be a Array, for product_cat tag etc
     * @param int $search_n_filter getting search and fileter meta
     * @return string
     */
    function wpt_search_box($temp_number, $search_box_texonomiy_keyword = array( 'product_cat', 'product_tag' ), $order_by = false, $order = false, $search_n_filter = false,$table_ID = false ){
        
        $config_value = wpt_get_config_value( $temp_number ); //V5.0 temp number is post_ID , $table_ID
        $html = false;
        $html .= "<div id='search_box_{$temp_number}' class='wpt_search_box search_box_{$temp_number}'>";
        $html .= '<div class="search_box_fixer">'; //Search_box inside fixer
        $html .= '<h3 class="search_box_label">' . $config_value['search_box_title'] . '</h3>';
        $html .= "<div class='search_box_wrapper'>";

        /**
         * Search Input Box
         * At Version 3.3, we have changed few features
         */
        $html .= "<div class='search_single search_single_direct'>";
        
        $search_keyword = isset( $_GET['search_key'] ) ? sanitize_text_field( $_GET['search_key'] ) : '';
        

        $single_keyword = $config_value['search_keyword_text'];//__( 'Search keyword', 'woo-product-table' );
        $search_order_placeholder = $config_value['search_box_searchkeyword'];//__( 'Search keyword', 'woo-product-table' );
        $html .= "<div class='search_single_column'>";
        $html .= '<label class="search_keyword_label single_keyword" for="single_keyword_' . $temp_number . '">' . $single_keyword . '</label>';
        $html .= '<input data-key="s" value="' . $search_keyword . '" class="query_box_direct_value" id="single_keyword_' . $temp_number . '" value="" placeholder="' . $search_order_placeholder . '"/>';
        $html .= "</div>";// End of .search_single_column

        ob_start();
        /**
         * Used following hook to insert two insert other field
         * such:
         * Order By, Order and On sale
         * 
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        do_action( 'wpto_search_box_basics', $temp_number, $config_value, $order_by, $order );
        $html .= ob_get_clean();

        $html .= "</div>"; //end of .search_single
        
        if( is_string( $search_box_texonomiy_keyword ) && ! empty( $search_box_texonomiy_keyword ) ){
            $search_box_texonomiy_keyword = wpt_explode_string_to_array( $search_box_texonomiy_keyword );
        }

        /**
         * Texonomies Handle based on $search_box_texonomiy_keyword
         * Default cat and tag for product
         * 
         * @since 1.9
         * @date 10.6.2018 d.m.y
         */
        if( is_array( $search_box_texonomiy_keyword ) && count( $search_box_texonomiy_keyword ) > 0 ){
            foreach( $search_box_texonomiy_keyword as $texonomy_name ){
               $html .= wpt_texonomy_search_generator( $texonomy_name,$temp_number, $search_n_filter ); 
            }
        }

        $html .=  apply_filters('end_part_advance_search_box','',$table_ID);
        
        /**
         * Query by URL
         */
        if( isset( $config_value['query_by_url'] ) && $config_value['query_by_url'] ){
            
            $cutnt_link = get_page_link();
            $style = isset( $_GET['table_ID'] ) ? "display:inline;": '';
            $html .= '<a href="' . $cutnt_link . '" data-type="close-button" data-table_ID="' . $temp_number . '" id="wpt_query_reset_button_' . $temp_number . '" class="search_box_reset search_box_reset_' . $temp_number . '" style="' . $style . '">x</a>';
        }
        
        $html .= '</div>'; //End of .search_box_singles

        
        $html .= '<button data-type="query" data-temp_number="' . $temp_number . '" id="wpt_query_search_button_' . $temp_number . '" class="button wpt_search_button query_button wpt_query_search_button wpt_query_search_button_' . $temp_number . '">' . $config_value['search_button_text'] . '</button>';
        $html .= '</div>';//End of .search_box_fixer
        $html .= '</div>';//End of .wpt_search_box
        return $html;
    }
}

if( ! function_exists( 'wpt_filter_box' ) ){

    /**
     * Total Search box Generator
     * 
     * @param type $temp_number It's a Temporary Number for each Table,
     * @param type $search_box_texonomiy_keyword Obviously should be a Array, for product_cat tag etc
     * @return string
     */
    function wpt_filter_box($temp_number, $filter_keywords = false ){

        $html = $html_select = false;
        
        
        if( is_string( $filter_keywords ) && ! empty( $filter_keywords ) ){
            $filter_keywords = wpt_explode_string_to_array( $filter_keywords );
        }
        
        $config_value = wpt_get_config_value( $temp_number ); //V5.0 temp number is post_ID , $table_ID
        
        /**
         * Texonomies Handle based on $search_box_texonomiy_keyword
         * Default cat and tag for product
         * 
         * @since 20
         * @date 11.6.2018 d.m.y
         */
        if( is_array( $filter_keywords ) && count( $filter_keywords ) > 0 ){
            foreach( $filter_keywords as $texonomy_name ){
               $html_select .= wpt_texonomy_filter_generator( $texonomy_name,$temp_number ); 
            }
        }
        if( $html_select ){
            $html .= "<label>" . __( $config_value['filter_text'], 'woo-product-table' ) . "</label>" . $html_select;
            $html .= '<a href="#" data-type="reset " data-temp_number="' . $temp_number . '" id="wpt_filter_reset_' . $temp_number . '" class="wpt_filter_reset wpt_filter_reset_' . $temp_number . '">' . __( $config_value['filter_reset_button'], 'woo-product-table' ) . '</a>';
        }
        return $html;
    }
}