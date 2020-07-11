<?php

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
        $config_value = $config;
    }
    $config_value['footer_cart'] = $temp_config_value['footer_cart'];
    $config_value['footer_cart_size'] = $temp_config_value['footer_cart_size'];
    $config_value['footer_possition'] = $temp_config_value['footer_possition'];
    $config_value['footer_bg_color'] = $temp_config_value['footer_bg_color'];
    $config_value['thumbs_lightbox'] = $temp_config_value['thumbs_lightbox'];
    $config_value['disable_cat_tag_link'] = $temp_config_value['disable_cat_tag_link'];
    return $config_value;
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
                        //$fragments["span.wpt_ccount.wpt_ccount_$pr_id"] = "<span class='wpt_ccount wpt_ccount_$pr_id'>$pr_value</span>";
                    }
                }
                //$fragments["span.wpt_ccount"] = "";
                if( is_array( $product_response ) && count( $product_response ) > 0 ){
                    foreach( $product_response as $key=>$value ){
                        //var_dump($perItem);
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
            'format' => '?paged=%#%',
            'mid_size'  =>  3,
            'prev_next' =>  false,
            'current' => max( 1, $args['paged'] ),
            'total' => $product_loop->max_num_pages
        ));
        $html .= $paginate; 
    }
    return $html;
}

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

/**
 * We used this function to get default keywords array from default columns array
 * 
 * @return Array Only Keys of Column Array
 * @since 3.6
 */
function wpt_default_columns_keys_array(){
    return array_keys( wpt_default_columns_array() );
}

/**
 * We used this function to get default values array from default columns array
 * 
 * @return Array Only values of Column Array
 * @since 3.6
 */
function wpt_default_columns_values_array(){
    return array_values( wpt_default_columns_array() );
}

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
        $class[] = 'wpt_pro_table_body';
        $class[] = 'wpt_pro_table';
        $class[] = 'woocommerce';
    }
    return $class;
}
add_filter( 'body_class', 'wpt_adding_body_class' );


/**
 * Extend WordPress search to include custom fields
 *
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function wpt_custom_search_join( $join ) {
    global $wpdb;
    if(!is_product_taxonomy() && !is_search()){
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function wpt_custom_search_where( $where ) {
        global $pagenow, $wpdb;
        $myPreg = "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1";
        /*****************
        $myPreg .= " AND (";
        $myPreg .= $wpdb->postmeta.".meta_key='test'";


        $myPreg .= " OR ";
        $myPreg .= $wpdb->postmeta.".meta_key='_sku'";

        $myPreg .= ")";
        //***********************/
        $myPreg .= ")";
        if(!is_product_taxonomy() && !is_search())
        $where = preg_replace("/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",$myPreg, $where );
        

    return $where;
}

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function wpt_custom_search_distinct( $where ) {
        global $wpdb;
        return "DISTINCT";
        return $where;
    
}



 function etc_abc_test(){

        add_filter('posts_join', 'wpt_custom_search_join' );
        add_filter( 'posts_where', 'wpt_custom_search_where' );
        add_filter( 'posts_distinct', 'wpt_custom_search_distinct' );
 }
 add_filter('init','etc_abc_test');
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
/**
 * Extend WordPress search to include custom fields
 *
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function wpt_custom_search_join( $join ) {
    global $wpdb;
    if(!is_product_taxonomy() && !is_search()){
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function wpt_custom_search_where( $where ) {
        global $pagenow, $wpdb;
        $myPreg = "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1";
        /*****************
        $myPreg .= " AND (";
        $myPreg .= $wpdb->postmeta.".meta_key='test'";


        $myPreg .= " OR ";
        $myPreg .= $wpdb->postmeta.".meta_key='_sku'";

        $myPreg .= ")";
        //***********************/
        $myPreg .= ")";
        if(!is_product_taxonomy() && !is_search())
        $where = preg_replace("/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",$myPreg, $where );
        

    return $where;
}

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function wpt_custom_search_distinct( $where ) {
        global $wpdb;
        return "DISTINCT";
        return $where;
    
}



 function etc_abc_test(){
     $config_value = get_option( 'wpt_configure_options' );

        add_filter('posts_join', 'wpt_custom_search_join' );
        add_filter( 'posts_where', 'wpt_custom_search_where' );
        add_filter( 'posts_distinct', 'wpt_custom_search_distinct' );

 }
 add_filter('init','etc_abc_test');
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 /**
  * Customize Search When want to search from Title, Post Content, id, sku or any custom field value
  * Getting help from 
  * https://wordpress.stackexchange.com/questions/18703/wp-query-with-post-title-like-something/18715
  * https://wordpress.stackexchange.com/questions/289399/woocommerce-product-search-based-only-title
  * 
  * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
  * 
  * @global type $wpdb
  * @param string $where
  * @param type $wp_query
  * @return string
  */
 function wpt_custom_search( $where, $wp_query )
{
    global $wpdb;
    $search_term = $wp_query->get( 'wpt_custom_search' );

    if( !is_string( $search_term ) ){
        return $where;
    }
    $search_term = ltrim($search_term);
    $search_term = rtrim( $search_term );
    if( empty($search_term) ){
        return $where;
    }
    $table_ID = $wp_query->get( 'table_ID' );
    
    $search_from = get_post_meta( $table_ID, 'search_n_filter', true );
    $search_from = isset($search_from['search_from']) && is_array( $search_from['search_from'] ) && count( $search_from['search_from'] ) > 0 ? $search_from['search_from'] : false;
    
    if ( $search_from && !empty( $search_term ) ) {
        $where .= ' AND (';
        $inter_sql = array();
        foreach( $search_from as $search_item => $table_name ){
            $numeric = is_numeric( $search_item );
            $percent = !$numeric ? "%" : "";

            if( $table_name == 'posts' ){
                $inter_sql[] =  $wpdb->posts . ".". $search_item . ' LIKE \'' . $percent . esc_sql( like_escape( $search_term ) ) . $percent . '\'';
                //$where .=  $wpdb->posts . ".". $search_item . ' LIKE \'' . $percent . esc_sql( like_escape( $search_term ) ) . $percent . '\'';
            }elseif( $table_name == 'postmeta' ){
                $inter_sql[] = "(" . $wpdb->postmeta.".meta_key='{$search_item}' AND " . $wpdb->postmeta . ".meta_value='" . esc_sql( $search_term ) . "')";
                //$where .= " (" . $wpdb->postmeta.".meta_key='_sku' AND " . $wpdb->postmeta . ".meta_value='{$search_term}')";
            }elseif( $table_name == 'any_custom_filed' ){
                $inter_sql[] = $wpdb->postmeta.'.meta_value LIKE \'' . $percent . esc_sql( like_escape( $search_term ) ) . $percent . '\'';
                //$inter_sql[] = $wpdb->postmeta.".meta_value LIKE $1";
            }
        }
        $where .= implode( ' OR ', $inter_sql );
        //$where .= ' ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $search_term ) ) . '%\'';
        //$where .= ' OR ' . $wpdb->posts . '.post_content LIKE \'%' . esc_sql( like_escape( $search_term ) ) . '%\'';
        $where .= ')';
    }
    return $where;
}
add_filter( 'posts_where', 'wpt_custom_search', 10, 2 );

/**
 * Left Join is need for Search Product based on Custom Field like _sku, _price etc any other custom field of Product
 * 
 * @global type $wpdb
 * @param string $join
 * @param type $wp_query
 * @return string
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join Details in WordPress
 */
function wpt_custom_search_join($join,$wp_query){
    global $wpdb;
    $validation = $wp_query->get( 'wpt_query_type' );
    if(!empty( $validation ) && $validation == 'search'){
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}
add_filter('posts_join', 'wpt_custom_search_join',10,2 );

function wpt_custom_search_distinct( $where, $wp_query ) {
        $validation = $wp_query->get( 'wpt_query_type' );
        if(!empty( $validation ) && $validation == 'search'){
        //return "DISTINCT";
        }
        return $where;
    
}
add_filter( 'posts_distinct', 'wpt_custom_search_distinct', 10, 2 );

