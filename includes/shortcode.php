<?php

global $shortCodeText;
add_shortcode( $shortCodeText, 'wpt_shortcode_generator' );

if( !function_exists( 'wpt_shortcode_generator' ) ){
    /**
     * Shortcode Generator for WPT Plugin
     * 
     * @param array $atts
     * @return string
     * 
     * @since 1.0
     */
    function wpt_shortcode_generator( $atts = false ) {
        //Getting WooProductTable Pro
        $table_show = apply_filters('wpt_table_show_top', true, $atts );
        if( !$table_show ){
            return;
        }
        $config_value = get_option( 'wpt_configure_options' );
        $html = '';
        $GLOBALS['wpt_product_table'] = "Yes";
        /**
         * Set Variable $html to return
         * 
         * @since 1.1
         */

        $pairs = array( 'exclude' => false );
        extract( shortcode_atts( $pairs, $atts ) );

        if( isset( $atts['id'] ) && !empty( $atts['id'] ) && is_numeric( $atts['id'] ) && get_post_type( (int) $atts['id'] ) == 'wpt_product_table' ){
            $ID = $table_ID = (int) $atts['id']; //Table ID added at V5.0. And as this part is already encapsule with if and return is false, so no need previous declearation
            $GLOBALS['wpt_product_table'] = $ID;

            //Used meta_key column_array, enabled_column_array, basics, conditions, mobile, search_n_filter, 
            $column_array = get_post_meta( $ID, 'column_array', true );
            $enabled_column_array = get_post_meta( $ID, 'enabled_column_array', true );
            if( empty( $enabled_column_array ) ){
                return sprintf( '<p>' . esc_html( 'Table{ID: %s} column setting is not founded properly!', 'wpt_pro' ) . '</p>', $ID );
            }
            /*
            if( !isset( $enabled_column_array['product_title'] ) ){
                $temp_product_title['product_title'] = $column_array['product_title'];
                $enabled_column_array = array_merge($temp_product_title,$enabled_column_array);
            }
            */
            //unset($enabled_column_array['description']); //Description column has been removed V5.2 //Again Description column Start V6.0.25

            $column_settings = get_post_meta( $ID, 'column_settings', true);

            $basics = get_post_meta( $ID, 'basics', true );
//            $query_relation = ! isset( $basics['query_relation'] ) ? 'OR' : $basics['query_relation'];
            $basics_args = isset( $basics['args'] ) && is_array( $basics['args'] ) ? $basics['args'] : array();

            $table_style = get_post_meta( $ID, 'table_style', true );

            $conditions = get_post_meta( $ID, 'conditions', true );
            $mobile = get_post_meta( $ID, 'mobile', true );
            $search_n_filter = get_post_meta( $ID, 'search_n_filter', true );
            $pagination = get_post_meta( $ID, 'pagination', true );
            $config_value = wpt_get_config_value( $table_ID ); //Added at V5.0
            if( is_array( $config_value ) ){
                array_unshift( $config_value, get_the_title( $ID ) ); //Added at V5.0
            }


            /**
             * Filter of common Array
             * @Hook Filter: wpto_column_array
             */
            $column_array = apply_filters( 'wpto_column_arr', $column_array, $table_ID, $atts, $column_settings, $enabled_column_array ); //Added at 6.0.25
            $enabled_column_array = apply_filters( 'wpto_enabled_column_array', $enabled_column_array, $table_ID, $atts, $column_settings, $column_array ); //Added at 6.0.25
            $column_settings = apply_filters( 'wpto_column_settings', $column_settings, $table_ID, $enabled_column_array ); //Added at 6.0.25

            /**
             * Product Type featue added for provide Variation Product table 
             * 
             * @since 5.7.7
             */
            $product_type = isset( $basics['product_type'] ) && !empty( $basics['product_type'] ) ? $basics['product_type'] : false;
            if( $product_type ){
                unset( $enabled_column_array['category'] );
                unset( $enabled_column_array['tags'] );
                unset( $enabled_column_array['weight'] );
                unset( $enabled_column_array['length'] );
                unset( $enabled_column_array['width'] );
                unset( $enabled_column_array['height'] );
                unset( $enabled_column_array['rating'] );
                unset( $enabled_column_array['attribute'] );
                unset( $enabled_column_array['variations'] );
            }


            //For Advance and normal Version
            $table_type = isset( $conditions['table_type'] ) ? $conditions['table_type'] : 'normal_table';//"advance_table"; //table_type
            if($table_type != 'normal_table'){
                //unset( $enabled_column_array['price'] );
                unset( $enabled_column_array['variations'] );
                unset( $enabled_column_array['total'] );
                unset( $enabled_column_array['quantity'] );
            }
            
            /**
             * Only for Message
             */
            if( isset( $enabled_column_array['message'] ) && $table_type != 'normal_table' ){
                /**
                 * For ThirdParty Plugin Support, We have
                 * Disable shortMesage from Column
                 * and added it into Single Product.
                 */
                unset( $enabled_column_array['message'] );
                add_action( 'woocommerce_before_add_to_cart_quantity', 'wpt_add_custom_message_field' );
            }
            
            //Collumn Setting part
            $table_head = !isset( $column_settings['table_head'] ) ? true : false; //Table head availabe or not

            $table_column_keywords = $enabled_column_array;//array_keys( $enabled_column_array );
            //$table_column_keywords = array_keys( $enabled_column_array );

            //Basics Part
            $product_cat_id_single = ( isset($atts['product_cat_ids']) && !empty( $atts['product_cat_ids'] ) ? $atts['product_cat_ids'] : false );
            $product_cat_ids = isset( $basics['product_cat_ids'] ) ? $basics['product_cat_ids'] : $product_cat_id_single;
            $post_include = isset( $basics['post_include'] ) ? $basics['post_include'] : false; //wpt_explode_string_to_array($basics['post_include']);
            $post_exclude = isset( $basics['post_exclude'] ) ? $basics['post_exclude'] : false; //wpt_explode_string_to_array($basics['post_exclude']);
            $cat_explude = isset( $basics['cat_explude'] ) ? $basics['cat_explude'] : false;
            $product_tag_ids = isset( $basics['product_tag_ids'] ) ? $basics['product_tag_ids'] : false;
            $ajax_action = $basics['ajax_action'];//isset( $basics['ajax_action'] ) ? $basics['ajax_action'] : false;
            $pagination_ajax = isset( $basics['pagination_ajax'] ) ? $basics['pagination_ajax'] : 'pagination_ajax';
            $minicart_position = $basics['minicart_position'];//isset( $basics['ajax_action'] ) ? $basics['ajax_action'] : false;
            $table_class = $basics['table_class'];//isset( $basics['ajax_action'] ) ? $basics['ajax_action'] : false;
            $temp_number = $ID;//Temp Number Has REmoved Totally $basics['temp_number'];// + $ID; //$ID has removed from temp_number
            $add_to_cart_text = $basics['add_to_cart_text'];



            $add_to_cart_selected_text = isset( $basics['add_to_cart_selected_text'] ) ? $basics['add_to_cart_selected_text'] : __( 'Add to cart selected', 'wpt_pro' );
            $check_uncheck_text = isset( $basics['check_uncheck_text'] ) ? $basics['check_uncheck_text'] : __( 'Check/Uncheck', 'wpt_pro' );//$basics['check_uncheck_text'];
            $author = !empty( $basics['author'] ) ? $basics['author'] : false;
            $author_name = !empty( $basics['author_name'] ) ? $basics['author_name'] : false;

            //Auto checkbox checked for on load in basic tab - This will generate calss only
            $checkbox = isset( $basics['checkbox'] ) && !empty( $basics['checkbox'] ) ? $basics['checkbox'] : 'wpt_no_checked_table';
            //Design Tab part and generat CSS in html as <style> tag
            $template = isset( $table_style['template'] ) ? $table_style['template'] : 'custom'; //Default value for old version is 'default'

            $custom_css_code = false;
            $custom_table = 'no_custom_style';
            if( is_array($table_style) && $template != 'none' ){
                $custom_table = 'custom';
                $custom_style = $table_style;
                unset($custom_style['template']);
                $custom_css_code .= '<style>';
                foreach($custom_style as $selector=>$properties){
                    $selector = str_replace('{', '[', $selector); //third bracket is not supported in array key
                    $selector = str_replace('}', ']', $selector);  //third bracket is not supported in array key
                    $selector = str_replace('%', '+', $selector);  //third bracket is not supported in array key
                    $full_selector = '#table_id_'.$temp_number . ' ' . $selector .'{';
                    $full_selector = str_replace( ',', ',#table_id_'.$temp_number . ' ', $full_selector );
                    $custom_css_code .= $full_selector;
                    foreach( $properties as $property=>$value ){
                        $custom_css_code .= !empty( $value ) ? $property . ': ' . $value . ' !important;' : '';
                    }
                    $custom_css_code .= '} ';
                }
                $custom_css_code .= '</style>';
            }

            //Conditions Tab Part
            $sort = $conditions['sort'];
            $sort_order_by = $conditions['sort_order_by'];
            $meta_value_sort = $conditions['meta_value_sort'];
            $min_price = $conditions['min_price'];
            $max_price = $conditions['max_price'];
            $description_type = $conditions['description_type'];
            $only_stock = !empty( $conditions['only_stock'] ) && $conditions['only_stock'] !== 'no' ? $conditions['only_stock'] : false;
            $only_sale = isset( $conditions['only_sale'] ) && $conditions['only_sale'] == 'yes' ? true : false;
            $posts_per_page = (int) $conditions['posts_per_page'];



            //Mobile tab part
            $mobile_responsive = $mobile['mobile_responsive'];
            $table_mobileHide_keywords = isset( $mobile['disable'] ) ? $mobile['disable'] : false;

            //Search and Filter
            $search_box = $search_n_filter['search_box'] == 'no' ? false : true;
            $texonomiy_keywords = wpt_explode_string_to_array( $search_n_filter['taxonomy_keywords'] ); 

            $filter_box = $search_n_filter['filter_box'] == 'no' ? false : true;
            $filter_keywords = wpt_explode_string_to_array( $search_n_filter['filter'] );

            //Pagination Start
            $pagination_start = isset( $pagination['start'] ) ? $pagination['start'] : '1'; //1 FOR ENABLE, AND 0 FOR DISABLE //Default value 1 - Enable

        }else{
            return false;
        }
        /***************This will be out of If condition of ID's************************/ 

        $taxonomy_column_keywords = array_filter( $table_column_keywords,'wpt_taxonomy_column_generator' );
        $customfileds_column_keywords = array_filter( $table_column_keywords,'wpt_customfileds_column_generator' );

        /**
         * Define permitted TD inside of Table, Not for Table head
         * Only for Table Body
         * Generate Array by wpt_define_permitted_td_array() which is available in functions.php file of Plugin
         * @since 1.0.4
         */
        $wpt_permitted_td = wpt_define_permitted_td_array( $table_column_keywords );


        /**
         * Args for wp_query()
         */
        $args = array(
            'posts_per_page' => $posts_per_page,
            'post_type' => array('product'), //, 'product_variation','product'
            'post_status'   =>  'publish',
            'meta_query' => array(),
            'wpt_query_type' => 'default',
        );

        /**
         * Issue of Query for Load More Button
         */
        if( isset( $_GET['s'] ) && !empty( $_GET['s'] ) ){
            $args['s'] = $_GET['s'];
        }else{
            unset( $args['s'] );
        }
        //Final Sku Start
        if($meta_value_sort && ( $sort_order_by == 'meta_value' || $sort_order_by == 'meta_value_num' ) ){
            $args['meta_query'][] = array(
                    'key'     => $meta_value_sort, //Default value is _sku : '_sku'
                    'compare' => 'EXISTS',
                );
        }
        //Final Sku end
        //Author or Vendor with Condition added 3.4
        if( $author ){
            $args['author'] = $author;
        }
        if( $author_name ){
            $args['author_name'] = $author_name;
        }
        //Author info with Condition added 3.4  - End Here

        if( $only_stock ){
            $args['meta_query'][] = array(//For Available product online
                    'key' => '_stock_status',
                    'value' => $only_stock
                );
        }
        /**
         * Modernize Shorting Option
         * Actually Default Value  will be RANDOM, So If not set ASC or DESC, Than Sorting 
         * will be Random by default. Although Just after WP_Query
         * 
         * @since 1.0.0 -9
         */
        if ($sort) {
            $args['orderby'] = $sort_order_by;//'post_title';
            $args['order'] = $sort;
        }


        /**
         * Set Minimum Price for
         */
        if ($min_price) {
            $args['meta_query'][] = array(
                'key' => '_price',
                'value' => $min_price,
                'compare' => '>=',
                'type' => 'NUMERIC'
            );
        }

        /**
         * Set Maximum Price for
         */
        if ($max_price) {
            $args['meta_query'][] = array(
                'key' => '_price',
                'value' => $max_price,
                'compare' => '<=',
                'type' => 'NUMERIC'
            );
        }

        /**
         * Args Set for tax_query if available $product_cat_ids
         * 
         * @since 1.0
         */
        if ($product_cat_ids) {
            $args['tax_query']['product_cat_IN'] = array(  //product_cat_IN Added at 5.7 for javascript help work
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $product_cat_ids,
                    'operator' => 'IN'
                );

        }

        /**
         * Args Set for tax_query if available $product_tag_ids
         * 
         * @since 1.9
         */
        if ($product_tag_ids) {
            $args['tax_query']['product_tag_IN'] = array( //product_tag_IN Added at 5.7 for javascript help work
                    'taxonomy' => 'product_tag',
                    'field' => 'id',
                    'terms' => $product_tag_ids,
                    'operator' => 'IN'
                );

        }
        //$args['tax_query']['relation'] = 'AND';

        /**
         * Category Excluding System
         * 
         * @since 1.0.4
         * @date 27/04/2018
         */
        if($cat_explude){
            $args['tax_query'][] = array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $cat_explude,
                    'operator' => 'NOT IN'
                );
        }

        /**
         * Post Include
         * 
         * @since 4.9
         * @date 22/06/2019
         */
        if($post_include){
            $args['post__in'] = $post_include;//
            $args['orderby'] = 'post__in';
        }

        //For Only Stock Product and Added at Version 6.0.6 at 15.6.2020
        if($only_sale){
            $sale_products = wc_get_product_ids_on_sale();
            $sale_products = $sale_products && is_array( $sale_products ) && $post_include && is_array( $post_include ) ? array_intersect( $post_include, $sale_products ) : $sale_products;
            $args['post__in'] = $sale_products;//var_dump(wc_get_product_ids_on_sale());
        }

        /**
         * Post Exlucde
         * 
         * @since 1.0.4
         * @date 28/04/2018
         */
        if($post_exclude){
            $args['post__not_in'] = $post_exclude;
        }

        //Table ID added to Args 
        $args['table_ID'] = $table_ID; //Added at V5.0

        /******************************************************************************/


        if( $product_type ){
            $product_loop = new WP_Query($args);
            $product_includes = array();
            if ($product_loop->have_posts()) : while ($product_loop->have_posts()): $product_loop->the_post();
                //$_ID = $product_loop->get_the_ID();

                global $product;

                $data = $product->get_data();
                (Int) $_ID = $data['id']; 

                if( wc_get_product($_ID)->get_type() == 'variable'){
                    $this_post_variable = new WC_Product_Variable( $_ID );
                    $available_post_includes = $this_post_variable->get_children();

                     if( isset( $available_post_includes ) && is_array($available_post_includes) && count( $available_post_includes ) > 0 ){
                        foreach ($available_post_includes as $pperItem){
                            $product_includes[$pperItem] = $pperItem;
                        }
                    }


                }
            endwhile;
                //Moved reset query from here to end of table at version 4.3
            else:
                $product_includes = array();
            endif;

            wp_reset_query(); 
            //Unset some default here 
            unset($args['tax_query']);
            unset($args['tax_query']);
            unset($wpt_permitted_td['attribute']);
            unset($wpt_permitted_td['category']);
            unset($wpt_permitted_td['tags']);


            $args['post_type'] = array('product_variation'); //'product'
            $args['post__in'] = $product_includes;
            $args['orderby'] = 'post__in';

            //Set few default value for product variation
            $search_box = false;

        }
        /****************************************************************************/
        ob_start();
        /**
         * To Insert Content at Top of the Table, Just inside of Wrapper tag of Table
         * Available Args $table_ID, $args, $config_value, $atts;
         */
        do_action( 'wpto_action_start_table', $table_ID, $args, $column_settings, $enabled_column_array, $config_value, $atts );
        $html .= ob_get_clean();

        /**
         * To Show or Hide Table
         * Use following Filter
         */
        $table_show = apply_filters( 'wpto_table_show', true,  $table_ID, $args, $config_value, $atts );
        if( !$table_show ){
            return $html;
        }

        /**
         * Initialize Page Number
         */
        $page_number = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;

        /**
         * Do Detect Page number, When Table will be display.
         * 
         */
        $page_number = apply_filters( 'wpto_page_number', $page_number, $table_ID, $args, $column_settings, $enabled_column_array, $column_array );
        $args['paged'] =( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : $page_number;

        
        $args = array_merge( $args, $basics_args );
        $args['tax_query']['relation'] = 'AND';//$query_relation;
        /**
         * @Hook wpto_table_query_args to customize Query Args from any plugin.
         * Available Data/VAriable are: $args, $atts, $table_ID
         */
        $args = apply_filters( 'wpto_table_query_args', $args, $table_ID, $atts, $column_settings, $enabled_column_array, $column_array );
        /**
         * Add to cart Check Select /check/un-check Section
         * 
         * @version V1.0.4 
         * @date 2/5/2018
         */
        
        $html_check = $html_check_footer = false; $filter_identy_class = 'fullter_full';
        $checkbox_validation = apply_filters( 'wpto_checkbox_validation', false, $enabled_column_array,$column_settings, $table_ID, $atts );
        if( $checkbox_validation ){
            $filter_identy_class = 'fulter_half';
            //
            $add_to_cart_selected_text = $add_to_cart_selected_text;//'Add to Cart [Selected]';

            $html_check .= "<div class='all_check_header_footer all_check_header check_header_{$temp_number}'>";
            $html_check_footer .= "<div class='all_check_header_footer all_check_footer check_footer_{$temp_number}'>";

            $html_check .= "<span><input data-type='universal_checkbox' data-temp_number='{$temp_number}' class='wpt_check_universal wpt_check_universal_header' id='wpt_check_uncheck_button_{$temp_number}' type='checkbox'><label for='wpt_check_uncheck_button_{$temp_number}'>{$check_uncheck_text}</lable></span>";

            $html_check .= "<a data-add_to_cart='{$add_to_cart_text}' data-temp_number='{$temp_number}' class='button add_to_cart_all_selected add2c_selected'>$add_to_cart_selected_text</a>";
            $html_check_footer .= "<a data-add_to_cart='{$add_to_cart_text}' data-temp_number='{$temp_number}' class='button add_to_cart_all_selected add2c_selected'>$add_to_cart_selected_text</a>";

            $html_check .= "</div>";
            $html_check_footer .= "</div>";
        }

        /**
         * Maintenance Filter
         * Mainly Mini Filter
         */
        $filter_html = false;
        if( $filter_box ){
            $filter_html .= "<div class='wpt_filter {$filter_identy_class}'>";
            $filter_html .= "<div class='wpt_filter_wrapper'>";
            $filter_html .= wpt_filter_box($temp_number, $filter_keywords);
            $filter_html .= "</div>";
            $filter_html .= "</div>"; //End of ./wpt_filter
        }
        /**
         * Tables Minicart Message div tag
         * By this feature, we able to display minicart at top or bottom of Table
         * 
         * @since 1.9
         */
        $table_minicart_message_box = "<div class='tables_cart_message_box tables_cart_message_box_{$temp_number}' data-type='load'></div>";

        $html .= apply_filters('wpt_before_table_wrapper', ''); //Apply Filter Just Before Table Wrapper div tag

        $wrapper_class_arr = array(
                $table_type . "_wrapper",
                " wpt_temporary_wrapper_" . $temp_number,
                " wpt_id_" . $temp_number,
                "wpt_product_table_wrapper",
                $template . "_wrapper woocommerce",
                $checkbox,
                "wpt_" . $pagination_ajax,
            );
        $wrapper_class_arr = apply_filters( 'wpto_wrapper_tag_class_arr', $wrapper_class_arr, $table_ID, $args, $column_settings, $enabled_column_array, $column_array );
        $wrapper_class_arr = implode( " ", $wrapper_class_arr );

        $html .= "<div "
                . "data-checkout_url='" . esc_attr( wc_get_checkout_url() ) . "' "
                . "data-temp_number='" . esc_attr( $temp_number ) . "' "
                . "data-add_to_cart='" . esc_attr( $add_to_cart_text ) . "' "
                . "data-add_to_cart='" . esc_attr( $add_to_cart_text ) . "' "
                . "data-site_url='" . site_url() . "' "
                . "id='table_id_" . esc_attr( $temp_number ) . "' "
                . "class='" . esc_attr( $wrapper_class_arr ) . "' "
                . ">"; //Table Wrapper Div start here with class. //Added woocommerce class at wrapper div in V1.0.4

        ob_start();
        /**
         * To Insert Content at Top of the Table, Just inside of Wrapper tag of Table
         * Available Args $table_ID, $args, $config_value, $atts;
         */
        do_action( 'wpto_action_table_wrapper_top', $table_ID, $args, $column_settings, $enabled_column_array, $config_value, $atts );
        $html .= ob_get_clean();

        $html .= ($minicart_position == 'top' ? $table_minicart_message_box : false);//$minicart_position //"<div class='tables_cart_message_box_{$temp_number}'></div>";

        /**
         * Searchbox Validation Filter added.
         * By default: we set that
         * Table will show only at Page
         */
        $search_box_validation = apply_filters( 'wpto_searchbox_show', true, $table_ID, $args, $column_settings, $enabled_column_array, $config_value, $atts );
        //Search Box Hander Here
        if( $search_box && $search_box_validation ){
            /**
             * Search Box Added here, Just before of Table 
             * 
             * @since 1.9
             * @date 9.6.2018 d.m.y
             */
            $html .= wpt_search_box( $temp_number, $texonomiy_keywords, $sort_order_by, $sort, $search_n_filter,$table_ID );
        }else{
            $html .= '<button data-type="query" data-temp_number="' . $temp_number . '" id="wpt_query_search_button_' . $temp_number . '" class="button wpt_search_button query_button wpt_query_search_button wpt_query_search_button_' . $temp_number . '" style="visibility: hidden;height:1px;"></button>';
        }
        $html .= apply_filters('end_part_advance_search_box_abc','',$table_ID,$temp_number);
        /**
         * Instant Sarch Box
         */
        $instance_search = false;
        if( $config_value['instant_search_filter'] == 1 ){
            $instance_search .= "<div class='instance_search_wrapper'>";
            $instance_search .= "<input data-temp_number='" . esc_attr( $temp_number ) . "' placeholder='{$config_value['instant_search_text']}' class='instance_search_input'>";
            $instance_search .= "</div>";
        }

        $html .= $instance_search; //For Instance Search Result
        $html .= $filter_html; //Its actually for Mini Filter Box
        $html .= $html_check; //Added at @Version 1.0.4
        $html .= '<br class="wpt_clear">'; //Added @Version 2.0
        $html .= apply_filters('wpt_before_table', ''); //Apply Filter Jese Before Table Tag

        /**
         * Why this array here, Actually we will send this data as dataAttribute of table 's tag.
         * although function has called at bellow where this array need.
         */
        $table_row_generator_array = array(
            'args'                      => $args,
            'wpt_table_column_keywords' => $table_column_keywords,
            'wpt_product_short'         => $sort,
            'wpt_permitted_td'          => $wpt_permitted_td,
            'wpt_add_to_cart_text'      => $add_to_cart_text,
            'temp_number'               => $temp_number,
            'texonomy_key'              => $taxonomy_column_keywords,
            'customfield_key'           => $customfileds_column_keywords,
            'filter_key'                => $filter_keywords,
            'filter_box'                => $filter_box,
            'description_type'          => $description_type,
            'ajax_action'               => $ajax_action,
            'table_type'               => $table_type,
            'checkbox'               => $checkbox,
        );

        ob_start();
        /**
         * Action for before Table
         * @since 2.7.5.2
         */
        do_action( 'wpto_action_before_table', $table_ID, $args, $column_settings, $enabled_column_array, $config_value, $atts );
        $html .= ob_get_clean();
        
        $html .= '<div class="wpt_table_tag_wrapper">'; //Table tag wrapper start

        $page_number_1plugs = $args['paged'] + 1;

        $table_class_arr = array(
                $mobile_responsive,
                $table_type,
                'wpt_temporary_table_' . $temp_number,
                'wpt_product_table',
                $template. '_table',
                "{$custom_table}_table",
                $table_class,
                isset( $config_value['custom_add_to_cart'] ) ? $config_value['custom_add_to_cart'] : 'no_set_custom_addtocart',
            );
        $table_class_arr = apply_filters( 'wpto_table_tag_class_arr', $table_class_arr, $table_ID, $args, $column_settings, $enabled_column_array, $column_array);
        $table_class_arr = implode( " ", $table_class_arr );

        
        $html .= "<table "
                . "data-page_number='" . esc_attr( $page_number_1plugs ) . "' "
                . "data-temp_number='" . esc_attr( $temp_number ) . "' "
                . "data-config_json='" . esc_attr( wp_json_encode( $config_value ) ) . "' "
                . "data-data_json='" . esc_attr( wp_json_encode( $table_row_generator_array ) ) . "' "
                . "data-data_json_backup='" . esc_attr( wp_json_encode( $table_row_generator_array ) ) . "' "
                . "id='" . apply_filters('wpt_change_table_id', 'wpt_table') . "' "
                . "class='{$table_class_arr}' "
                //. "class='{$mobile_responsive} {$table_type} wpt_temporary_table_" . $temp_number . " wpt_product_table " . $template . "_table {$custom_table}_table $table_class " . $config_value['custom_add_to_cart'] . "' "
                . ">"; //Table Tag start here.

        /**
         * this $responsive_table will use for responsive table css Selector.
         * I have used this table selector at the end of table
         * See at bellow inside of <<<EOF EOF;
         * 
         * @since 1.5
         */
        $responsive_table = "table#wpt_table.mobile_responsive.wpt_temporary_table_{$temp_number}.wpt_product_table";

        /**
         * Table Column Field Tilte Define here
         * 
         * @since 1.0.04
         */
        $column_title_html = false;
        if ( $table_head && $enabled_column_array && is_array( $enabled_column_array ) && count( $enabled_column_array ) >= 1) {
            $column_title_html .= '<thead><tr data-temp_number="' . $temp_number . '" class="wpt_table_header_row wpt_table_head">';
            foreach ( $enabled_column_array as $key => $colunt_title ) {
                $updated_title = isset( $column_array[$key] ) ? $column_array[$key] : $colunt_title;
                $column_class = $key;

                /**
                 * Modified Table colum, Mainly for CheckBox Button's column.
                 * From this 1.9 version, We will only show All check - checkbox here.
                 * 
                 * @since 1.9
                 * @date: 10.6.2018 d.m.y
                 */
                $colunt_title = ( $column_class != 'check' ? $updated_title : "<input data-type='universal_checkbox' data-temp_number='{$temp_number}' class='wpt_check_universal' id='wpt_check_uncheck_column_{$temp_number}' type='checkbox'><label for=wpt_check_uncheck_column_{$temp_number}></label>" );

                $column_title_html .= "<th class='wpt_{$column_class}'>{$colunt_title}</th>";

            }
            $column_title_html .= '</tr></thead>';
        }
        $html .= $column_title_html;

        $html .= '<tbody>'; //Starting TBody here

        $html .= wpt_table_row_generator( $table_row_generator_array );

        $html .= '</tbody>'; //Tbody End here
        $html .= "</table>"; //Table tag wrapper End
        $html .= "</div>"; //End of .wpt-table-tag-wrapper
        ob_start();
        /**
         * Action for After Table
         * @since 2.7.5.2
         */
        do_action( 'wpto_action_after_table', $table_ID, $args, $column_settings, $enabled_column_array, $config_value, $atts );
        $html .= ob_get_clean();
        
        $Load_More_Text = $config_value['load_more_text'];

        //pagination
        if( $pagination_start && $pagination_start == '1' ){
            $html .= wpt_pagination_by_args( $args , $temp_number);
        }
        $Load_More = '<div id="wpt_load_more_wrapper_' . $temp_number . '" class="wpt_load_more_wrapper ' . $config_value['disable_loading_more'] . '"><button data-temp_number="' . $temp_number . '" data-load_type="current_page" data-type="load_more" class="button wpt_load_more">' . $Load_More_Text . '</button></div>';
        $html .= ( $posts_per_page != -1 ? $Load_More : '' );//$Load_More;

        $html .= $html_check_footer;
        $html .= apply_filters('wpt_after_table', '', $temp_number ); //Apply Filter Just Before Table Wrapper div tag

        /**
         * Table Minicart for Footer.
         * Only will show, if select bottom minicart
         * 
         * @since 1.9
         */
        $html .= ($minicart_position == 'bottom' ? $table_minicart_message_box : false);

        ob_start();
        /**
         * To Insert Content at Bottom of the Table, Just inside of Wrapper tag of Table
         * Available Args $table_ID, $args, $config_value, $atts;
         */
        do_action( 'wpto_table_wrapper_bottom', $table_ID, $args, $column_settings, $enabled_column_array, $config_value, $atts );
        $html .= ob_get_clean();

        $html .= "</div>"; //End of Table wrapper.
        //$html .= apply_filters('wpt_after_table_wrapper', ''); //Apply Filter Just After Table Wrapper div tag
        $html .= isset( $custom_css_code ) ? $custom_css_code : '';

        /**
         * Extra content for Mobile Hide content Issue
         */
        $mobile_hide_css_code = false;
        if( $table_mobileHide_keywords && count( $table_mobileHide_keywords ) > 0 ){
            foreach( $table_mobileHide_keywords as $selector ){
                $mobile_hide_css_code .= "table#wpt_table.wpt_temporary_table_{$temp_number}.wpt_product_table th.wpt_" . $selector . ',';
                $mobile_hide_css_code .= "table#wpt_table.wpt_temporary_table_{$temp_number}.wpt_product_table .wpt_" . $selector . ',';
            }
        }
        $mobile_hide_css_code .= '.hide_column_for_mobile_only_for_selected{ display: none!important;}';

        $padding_left = 8;
        $text_align = 'left';
        $table_css_n_js_array = array(
            'mobile_hide_css_code'      =>  $mobile_hide_css_code,
            'responsive_table'          =>  $responsive_table,
            'temp_number'               =>  $temp_number,
            'padding_left'              =>  $padding_left,
            'text_align'                =>  $text_align,
        );
        $html .= wpt_table_css_n_js_generator( $table_css_n_js_array );

        return $html;
    }
}

if( !function_exists( 'wpt_price_formatter' ) ){
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

if( !function_exists( 'wpt_table_css_n_js_generator' ) ){
    /**
     * CSS and JS code generator, Its under Table
     * 
     * @param type $table_css_n_js_array
     * @return string CSS and CSS code for bellow of Table
     */
    function wpt_table_css_n_js_generator( $table_css_n_js_array  ){

        $mobile_hide_css_code = $table_css_n_js_array['mobile_hide_css_code'];
        $responsive_table = $table_css_n_js_array['responsive_table'];
        $temp_number = $table_css_n_js_array['temp_number'];
        $padding_left = $table_css_n_js_array['padding_left'];
        $text_align = $table_css_n_js_array['text_align'];
        $html = <<<EOF
    <style>
    @media 
    only screen and (max-width: 767px) {
        $mobile_hide_css_code        


        $responsive_table tr { border: 1px solid #ddd; margin-bottom: 5px;}

        $responsive_table td { 
            border-bottom: 1px solid;
            position: relative;
            text-align: $text_align;
            padding-left: {$padding_left}px !important;
            height: 100%;
            border: none;
            border-bottom: 1px solid #ddd;    
        }
        /*
        $responsive_table td,$responsive_table td.wpt_check,$responsive_table td.wpt_quantity{
         width: 100%;       
        }
        */
        $responsive_table td.wpt_quantity { 
           min-height: 57px;
        }

        $responsive_table td.wpt_thumbnails { 
           height: 100%;
           padding: 7px;
        }

        $responsive_table td.wpt_description { 
           min-height: 55px;
           height: 100%;
           padding: 7px;
        }

        $responsive_table td.wpt_action{ 
           min-height: 62px;
           height: auto;
        }        
        $responsive_table td.data_product_variations.woocommerce-variation-add-to-cart.variations_button.woocommerce-variation-add-to-cart-disabled.wpt_action{ 
                height: 100%;
                padding: 7px 0;
        }

        $responsive_table td:before { 
            width: 88px;
            white-space: normal;
            background: #b7b7b736;
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            text-align: right;
            padding-right: 10px;
        }
        /*VARresponsiveTableLabelData*/
    } 
    table tr.wpt_row td.wpt_quoterequest.addedd{
        display: block !important;
    }
    </style>
EOF;
                    return $html;
    }
}

if( !function_exists( 'wpt_table_row_generator' ) ){
    /**
     * Generate Table 's Root html based on Query args
     * 
     * @param type $args Query 's args
     * @param type $table_column_keywords table 's column
     * @param type $sort Its actually for Product Sorting
     * @param type $wpt_permitted_td Permission or each td
     * @param type $add_to_cart_text add_to_cart text
     * @return String 
     */
    function wpt_table_row_generator( $table_row_generator_array ){
        ob_start();
        $html = false;
        //Getting WooProductTable Pro

        $table_ID = $table_row_generator_array['args']['table_ID'];
        $config_value = wpt_get_config_value( $table_ID );

        $args                   = $table_row_generator_array['args'];
        $table_column_keywords = $table_row_generator_array['wpt_table_column_keywords'];
        $sort      = $table_row_generator_array['wpt_product_short'];
        $wpt_permitted_td       = $table_row_generator_array['wpt_permitted_td'];
        $add_to_cart_text   = $table_row_generator_array['wpt_add_to_cart_text'];
        $temp_number            = $table_row_generator_array['temp_number'];
        $texonomy_key           = $table_row_generator_array['texonomy_key'];//texonomy_key
        $customfield_key        = $table_row_generator_array['customfield_key'];//texonomy_key
        $filter_key             = $table_row_generator_array['filter_key'];//texonomy_key
        $filter_box             = $table_row_generator_array['filter_box'];//Taxonomy Yes, or No
        $description_type = $table_row_generator_array['description_type'];
        $ajax_action            = $table_row_generator_array['ajax_action'];

        $checkbox        = $table_row_generator_array['checkbox'];

        $table_type           = $table_row_generator_array['table_type'];

        if( $args == false || $table_column_keywords == false ){
            return false;
        }

        //WILL BE USE FOR EVERY WHERE INSIDE ITEM
        $column_settings = get_post_meta( $table_ID, 'column_settings', true);
        /**
         * @Hook Filter: 
         * Here $table_column_keywords and $enabled_column_array are same Array Actually
         */
        $column_settings = apply_filters( 'wpto_column_settings', $column_settings, $table_ID, $table_column_keywords ); //Added at 6.0.25 

        /**
         * Adding Filter for Args inside Row Generator
         */
        $args = apply_filters( 'wpto_table_query_args_in_row', $args, $table_ID, false, $column_settings, false, false );

        $product_loop = new WP_Query($args);
        $product_loop = apply_filters( 'wpto_product_loop', $product_loop, $table_ID, $args );
        /**
         * If not set any Shorting (ASC/DESC) than Post loop will Random by Shuffle()
         * @since 1.0.0 -9
         */
        if ($sort == 'random') {
            shuffle($product_loop->posts);
        }
        $wpt_table_row_serial = (( $args['paged'] - 1) * $args['posts_per_page']) + 1; //For giving class id for each Row as well
        if ( ( $product_loop->query['post_type'][0] == 'product_variation' && !empty( $product_loop->query['post__in']) && $product_loop->have_posts()) || ( $product_loop->query['post_type'][0] == 'product' && $product_loop->have_posts()) ) : while ($product_loop->have_posts()): $product_loop->the_post();
                global $product;

                $data = $product->get_data();
                $product_type = $product->get_type();
                $parent_id = $product->get_parent_id(); // Version 2.7.7
                
                (Int) $id = $data['id'];     

                $taxonomy_class = 'filter_row ';
                $data_tax = false;
                if( $filter_box && is_array( $filter_key ) && count( $filter_key ) > 0 ){
                    foreach( $filter_key as $tax_keyword){
                        $terms = wp_get_post_terms( $data['id'], $tax_keyword  );

                        $attr = "data-{$tax_keyword}=";

                        $attr_value = false;
                        if( is_array( $terms ) && count( $terms ) > 0 ){
                            foreach( $terms as $term ){
                                $taxonomy_class .= $tax_keyword . '_' . $temp_number . '_' . $term->term_id . ' ';
                                $attr_value .= $term->term_id . ':' . $term->name . ', ';
                            }
                        }
                        $data_tax .= $attr . '"' . $attr_value . '" ';
                    }
                }else{
                   $taxonomy_class = 'no_filter'; 
                }





                $default_quantity = apply_filters( 'woocommerce_quantity_input_min', 1, $product );



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


                //Out_of_stock class Variable
                $stock_status = $data['stock_status'];
                $stock_status_class = ( $stock_status == 'onbackorder' || $stock_status == 'instock' ? 'add_to_cart_button' : $stock_status . '_add_to_cart_button disabled' );







                $tr_class_arr = array(
                    "visible_row",
                    "wpt_row",
                    "wpt_row_" . $temp_number,
                    "wpt_row_serial_$wpt_table_row_serial",
                    "wpt_row_product_id_" . get_the_ID(),
                    "product_id_" . get_the_ID(),
                    $taxonomy_class,
                    $product_type,
                    "product_type_" . $product_type,
                    "stock_status_" . $data['stock_status'],
                    "backorders_" . $data['backorders'],
                    "sku_" . $data['sku'],
                    "status_" . $data['status'],

                );
                $tr_class_arr = apply_filters( 'wpto_tr_class_arr', $tr_class_arr, $args, $table_ID, $column_settings, $table_column_keywords, $product );
                $tr_class = implode( " ", $tr_class_arr );
                /**
                 * Table Row and
                 * And Table Data filed here will display
                 * Based on Query
                 */
                $wpt_each_row = false;

                do_action( 'wpto_before_row', $column_settings, $table_ID, $product, $temp_number );
                $row_manager_loc = WPT_BASE_DIR . 'includes/row_manager.php';
                $row_manager_loc = apply_filters( 'wpo_row_manager_loc',$row_manager_loc, $column_settings,$table_column_keywords, $args, $table_ID, $product );
                if( file_exists( $row_manager_loc ) ){
                    include $row_manager_loc;
                }
                do_action( 'wpto_after_row', $column_settings, $table_ID, $product, $temp_number );

                $wpt_table_row_serial++; //Increasing Serial Number.

            endwhile;
            //Moved reset query from here to end of table at version 4.3
        else:
            //$html .= "<div class='wpt_loader_text wpt_product_not_found'>" . $config_value['product_not_founded'] . "</div>";
            ?>
                        <div class='wpt_loader_text wpt_product_not_found'><?php echo $config_value['product_not_founded']; ?></div>
            <?php
        endif;

        wp_reset_query(); //Added reset query before end Table just at Version 4.3

        $html = ob_get_clean();
        return $html;
    }
}

if( !function_exists( 'wpt_texonomy_search_generator' ) ){
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
        $label = apply_filters( 'wpto_searchbox_taxonomy_name', $taxonomy_details->labels->menu_name, $texonomy_keyword, $temp_number );//label;
        $label_all_items = $taxonomy_details->labels->all_items;
        $html .= "<div class='search_single search_single_texonomy search_single_{$texonomy_keyword}'>";
        $html .= "<label class='search_keyword_label {$texonomy_keyword}' for='{$texonomy_keyword}_{$temp_number}'>{$label}</label>";

        $multiple_selectable = apply_filters( 'wpto_is_multiple_selectable', true, $texonomy_keyword, $temp_number ) ? 'multiple' : '';

        $defaults = array(
		'show_option_all'   => '',
		'show_option_none'  => '',
		'orderby'           => 'name',
		'order'             => $config_value['sort_searchbox_filter'],//'ASC', //$config_value['sort_searchbox_filter'],//
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
            $defaults['show_option_all'] = esc_html__( 'Choose ', 'wpt_pro' )  . $label_all_items;
        }
        
        /**
         * we have removed this filter for new version.
         * 
         * @deprecated since version 2.8.3.5
         */
        $defaults = apply_filters( 'wpto_dropdown_categories_default', $defaults, $texonomy_keyword,$taxonomy_details, $temp_number );
        
        /**
         * New Added for Taxonomy Args
         * on Search Box
         * Advance Search Box
         * 
         * @since 2.8.3.5
         */
        $defaults = apply_filters( 'wpto_dropdown_taxonomy_default_args', $defaults, $texonomy_keyword,$taxonomy_details, $temp_number );
        
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
        
        
        $html .= wpt_wp_dropdown_categories( $defaults, $customized_texonomy_boj );
        
        
//        #### $html .= "<select data-key='{$texonomy_keyword}' class='search_select query search_select_{$texonomy_keyword}' id='{$texonomy_keyword}_{$temp_number}' $multiple_selectable>";
//        //$html .= "<option value=''>{$label_all_items}</option>";
//        $texonomy_boj = get_terms( $texonomy_keyword, $texonomy_sarch_args );
//        
//        if( count( $texonomy_boj ) > 0 ){
//            //Search box's Filter Sorting Added at Version 3.1
//            $customized_texonomy_boj = false;
//
//            if( $selected_taxs && is_array( $selected_taxs ) && count( $selected_taxs ) > 0 ){
//                foreach( $selected_taxs as $termID ){
//                    $singleTerm = get_term( $termID );
//                    $name = $singleTerm->name;
//                    $customized_texonomy_boj[$name] = $singleTerm;
//                    
//                    foreach( $customized_texonomy_boj as $item ){
//                        #### $html .= "<option value='{$item->term_id}'>{$item->name}</option>"; // ({$item->count})
//                    }
//                    #### $html .= "</select>";
//                }
//                
//                $html .= wpt_wp_dropdown_categories( $defaults );
//            }else{
//                foreach( $texonomy_boj as $item ){
//                    $name = $item->name;
//                    $customized_texonomy_boj[$name] = $item;
//
//                }
//                $customized_texonomy_boj = wpt_sorting_array( $customized_texonomy_boj, $config_value['sort_searchbox_filter'] );
//                foreach( $customized_texonomy_boj as $item ){
//                    #### $html .= "<option value='{$item->term_id}'>{$item->name}</option>"; // ({$item->count})
//                }
//                #### $html .= "</select>";
//       
//                //multiple $multiple_selectable
//        
//                $html .= wpt_wp_dropdown_categories( $defaults );
//            }
//
//
//            
//        }
//        






        $html .= "</div>"; //End of .search_single


        return $html;
    }
}

if( !function_exists( 'wpt_sorting_array' ) ){
    /**
     * Sorting Associative array based on ASC,DESC or None.
     * 
     * @param type $array Associative Array
     * @param type $sorting_type Available type ASC,DESC,None
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

if( !function_exists( 'wpt_texonomy_filter_generator' ) ){
    /**
     * Texonomy select for Filter -- Texonomy.
     * 
     * @param type $texonomy_keyword
     * @param type $temp_number
     * @param type $current_select_texonomies
     * @return string|boolean
     */
    function wpt_texonomy_filter_generator( $texonomy_keyword, $temp_number ){
        //Getting data from options
        //$config_value = get_option('wpt_configure_options');
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
                /*
                if( count( $texonomy_boj ) > 0 ){

                    $customized_texonomy_boj = false;
                    foreach( $texonomy_boj as $item ){
                        $name = $item->name;
                        $customized_texonomy_boj[$name] = $item;

                    }
                    $customized_texonomy_boj = wpt_sorting_array( $customized_texonomy_boj, $config_value['sort_mini_filter'] );
                    foreach( $customized_texonomy_boj as $item ){  
                        $html .= "<option value='{$texonomy_keyword}_{$temp_number}_{$item->term_id}'>{$item->name}</option>";
                        //$html .= "<option value='{$item->term_id}' " . ( is_array($current_select_texonomies) && in_array($item->term_id, $current_select_texonomies) ? 'selected' : false ) . ">{$item->name} ({$item->count}) </option>";
                    }
                }
                */
            $html .= "</select>";
        return $html;
    }
}

if( !function_exists( 'wpt_search_box' ) ){
    /**
     * Total Search box Generator
     * 
     * @param type $temp_number It's a Temporay Number for each Table,
     * @param type $search_box_texonomiy_keyword Obviously should be a Array, for product_cat tag etc
     * @param int $search_n_filter getting search and fileter meta
     * @return string
     */
    function wpt_search_box($temp_number, $search_box_texonomiy_keyword = array( 'product_cat', 'product_tag' ), $order_by = false, $order = false, $search_n_filter = false,$table_ID = false ){
        //$config_value = get_option('wpt_configure_options');
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

            $single_keyword = $config_value['search_box_searchkeyword'];//__( 'Search keyword', 'wpt_pro' );
            $html .= "<div class='search_single_column'>";
            $html .= '<label class="search_keyword_label single_keyword" for="single_keyword_' . $temp_number . '">' . $single_keyword . '</label>';
            $html .= '<input data-key="s" class="query_box_direct_value" id="single_keyword_' . $temp_number . '" value="" placeholder="' . $single_keyword . '"/>';
            $html .= "</div>";// End of .search_single_column

            $order_by_validation = apply_filters( 'wpto_searchbox_order_show', false,$temp_number, $config_value, $search_box_texonomiy_keyword );
            if( $order_by_validation ):
            $single_keyword = $config_value['search_box_orderby'];//__( 'Order By', 'wpt_pro' ); //search_box_orderby
            $html .= "<div class='search_single_column search_single_sort search_single_order_by'>";
            $html .= '<label class="search_keyword_label single_keyword" for="order_by' . $temp_number . '">' . $single_keyword . '</label>';

            $html .= '<select data-key="orderby" id="order_by_' . $temp_number . '" class="query_box_direct_value select2" >';
            $html .= '<option value="name" '. wpt_check_sortOrder( $order_by, 'name' ) .'>'.esc_html__( 'Name','wpt_pro' ).'</option>';
            $html .= '<option value="menu_order" '. wpt_check_sortOrder( $order_by, 'menu_order' ) .'>'.esc_html__( 'Menu Order','wpt_pro' ).'</option>';
            $html .= '<option value="type" '. wpt_check_sortOrder( $order_by, 'type' ) .'>'.esc_html__( 'Type','wpt_pro' ).'</option>';
            $html .= '<option value="comment_count" '. wpt_check_sortOrder( $order_by, 'comment_count' ) .'>'.esc_html__( 'Reviews','wpt_pro' ).'</option>';
            $html .= '</select>';

            $html .= "</div>";// End of .search_single_column

            $single_keyword = $config_value['search_box_order']; //__( 'Order', 'wpt_pro' );
            $html .= "<div class='search_single_column search_single_order'>";
            $html .= '<label class="search_keyword_label single_keyword" for="order_' . $temp_number . '">' . $single_keyword . '</label>';
            $html .= '<select data-key="order" id="order_' . $temp_number . '" class="query_box_direct_value select2" >  ';
            $html .= '<option value="ASC" '. wpt_check_sortOrder( $order, 'ASC' ) .'>'.esc_html__( 'ASCENDING','wpt_pro' ).'</option>';
            $html .= '<option value="DESC" '. wpt_check_sortOrder( $order, 'DESC' ) .'>'.esc_html__( 'DESCENDING','wpt_pro' ).'</option>';
            $html .= '<option value="random" '. wpt_check_sortOrder( $order, 'random' ) .'>'.esc_html__( 'Random','wpt_pro' ).'</option>';
            $html .= '</select>';

            $html .= "</div>";// End of .search_single_column
            endif;


        $html .= "</div>"; //end of .search_single

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
        $html .= '</div>'; //End of .search_box_singles

        $html .= '<button data-type="query" data-temp_number="' . $temp_number . '" id="wpt_query_search_button_' . $temp_number . '" class="button wpt_search_button query_button wpt_query_search_button wpt_query_search_button_' . $temp_number . '">' . $config_value['search_button_text'] . '</button>';
        $html .= '</div>';//End of .search_box_fixer
        $html .= '</div>';//End of .wpt_search_box
        return $html;
    }
}

if( !function_exists( 'wpt_filter_box' ) ){
    /**
     * Total Search box Generator
     * 
     * @param type $temp_number It's a Temporay Number for each Table,
     * @param type $search_box_texonomiy_keyword Obviously should be a Array, for product_cat tag etc
     * @return string
     */
    function wpt_filter_box($temp_number, $filter_keywords = false ){
        $html = $html_select = false;
        //$config_value = get_option('wpt_configure_options');
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
            $html .= "<label>" . __( $config_value['filter_text'], 'wpt_pro' ) . "</label>" . $html_select;
            $html .= '<a href="#" data-type="reset " data-temp_number="' . $temp_number . '" id="wpt_filter_reset_' . $temp_number . '" class="wpt_filter_reset wpt_filter_reset_' . $temp_number . '">' . __( $config_value['filter_reset_button'], 'wpt_pro' ) . '</a>';
        }
        return $html;
    }
}