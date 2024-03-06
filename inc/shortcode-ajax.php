<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WC_AJAX;
use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Handle\Args;
use WOO_PRODUCT_TABLE\Inc\Handle\Element;
use WOO_PRODUCT_TABLE\Inc\Handle\Pagination;

class Shortcode_Ajax extends Shortcode{
    public $_root = __CLASS__;
    public static $get_args;
    public function __construct()
    {

        $this->ajax_action('wpt_load_both');
        $this->ajax_action('wpt_remove_from_cart');
        $this->ajax_action('wpt_wc_fragments');

    }

    public function wpt_load_both(){
        $atts = $this->set_atts();

        $args = $_POST['args'] ?? [];
        $others = $_POST['others'] ?? [];
        $args = $this->arrayFilter( $args );
        $temp_args = $args;
        unset($temp_args['base_link']);
        $this->args_ajax_called = true;

        /**
         * we need to track reset button click of search box.
         * 
         * That's why, we have create new event from javascript
         * 
         * @author Saiful Islam <codersaiful@gmail.com>
         * @since 3.4.1.0
         */
        $this->reset_search_clicked = ! empty( $others['reset_search_clicked'] ) && $others['reset_search_clicked'] == 'yes' ? true : false;//reset_search_clicked

        //It's need to the beginning of this process.
        $this->assing_property($atts); 
        

        /**
         * Actually if enable "Order By field" from 
         * backend Search & Filer table,
         * Then it's need to fix.
         * Need to unset from $temp_args
         * Otherwise, It's searching from full website product.
         * 
         * Obviously need under $this->assing_property($atts); 
         * wehere we set $this->args property
         * 
         * @since 3.3.2.1
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        if( ! empty( $temp_args['orderby'] ) ){
            $this->args['orderby'] = $temp_args['orderby'];
            unset($temp_args['orderby']);
        }

        /**
         * Actually if enable "On Sale" from 
         * backend Search & Filer table,
         * Then it's need to fix.
         * Need to unset from $temp_args
         * Otherwise, It's searching from full website product.
         * 
         * Obviously need under $this->assing_property($atts); 
         * wehere we set $this->args property
         * 
         * @since 3.3.2.1
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        if( ! empty( $temp_args['on_sale'] ) ){
            $this->args['on_sale'] = $temp_args['on_sale'];
            unset($temp_args['on_sale']);
        }


        if( is_array( $temp_args ) && ! empty( $temp_args ) ){
            if( $this->whole_search ){

                unset($this->args['post__in']);
                unset($this->args['post__not_in']);

                unset($this->args['tax_query']);
                unset($this->args['meta_query']);
            }else if( ! empty( $this->args['tax_query'] ) && ! empty( $temp_args['tax_query'] ) ){
                $merge_tax_query = array_merge( $this->args['tax_query'], $temp_args['tax_query'] );
                $temp_args['tax_query'] = $merge_tax_query;
            }
            
            $this->args = array_merge($this->args, $temp_args);
        }

        $page_number = $others['page_number'] ?? $this->page_number;
        
        /**
         * Actually base link is not part of Args. but we take it
         * using args when call ajax
         * to set right link
         * on pagination. otherwise, it was shown link
         * like: example.com/wp-admin/wp-ajax.php?page=2
         * 
         * but now it wll show page linke: example.com/page/2 
         * @since 3.2.5.2
         */
        $this->pagination_base_url = $_POST['args']['base_link'] ?? null;

        $this->args['paged'] = $this->page_number = $page_number;

        /**
         * Ajax wise and current screensize wise,
         * is mobile device checked
         * 
         * if actually mobile and screensize like mobile.
         * We actually detect it as scren size.
         * Even on detected mobile
         * 
         * @since 3.2.5.4.final7
         */
        $isMob = $others['isMob'] ?? false;
        if($this->auto_responsive && $isMob == 'true'){
            $this->generated_row = true;
        }
        if($this->auto_responsive && $isMob == 'false'){
            $this->generated_row = false;
        }

        /**
         * Why make this propety.
         * Actualy any any user need do something on $args after called ajax
         * user can check using $this->args_ajax_called
         * 
         * @since 3.2.5.1
         */
        $this->args_ajax_called = true;

        /**
         * Why make this
         * --------------
         * Actually when query will help over Ajax, We will transfer a value for 
         * Ajax through our args
         * 
         * @since 3.2.6.0
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        $this->args['wpt_query_type'] = 'ajax';

        $ajax_type = $others['type'] ?? '';

        /**
         * Paginated_load will be true, when user will call over the 
         * load_more button or using inifinite_scroll
         */
        if( $ajax_type ==  'load_more' || $ajax_type ==  'infinite_scroll'  ){
            $this->paginated_load = true;
        }


        /**
         * Orgnized $q['suppress_filters'] When args will come 
         * throw Ajax
         * Otherwise posts_join,posts_where filter will not work.
         * 
         * mone rakhte hobe, $this->args['suppress_filters'] eta unset kore diye
         * amra search er kaj korechi. tachara eta kaj korbe na.
         * 
         * @author Saiful Islam <codersaiful@gmail.com>
         * 
         * @since 3.2.6.0
         * @link https://developer.wordpress.org/reference/classes/wp_query/#source 
         * @link https://github.com/WordPress/wordpress-develop/blob/6.0.2/src/wp-includes/class-wp-query.php#L2617 This link can help
         */
        if( isset( $this->args['s'] ) ){

            $this->args['wpt_query_type'] = 'search';

            /**
             * Very important, beased on this, 
             * most relavant will show at the begining.
             * 
             * @since 3.4.6.0
             * @author Saiful Islam <codersaiful@gmail.com>
             * line: $this->args['orderby'] = 'relevance';
             */
            $this->args['orderby'] = 'relevance';
            unset( $this->args['suppress_filters'] );
        }
        
        if( ! $this->reset_search_clicked && $this->args['post_type'] == 'product_variation' ){
            /**
             * When user will use only_variation
             * mean $this->args['post_type'] == 'product_variation'
             * We will re-generate Args::manage() based on new search
             * 
             * @author Saiful Islam <codersaiful@gmail.com>
             * @since 3.4.1.0
             */
            
            Args::setOverrideArgs($this->args);
            Args::manage($this);
        }
        
        /**
         * wpt_load action hook 
         * added for ajax shortcode part
         * 
         * Based on this action hook, we have also called a functin on pro version 
         * at @version 8.3.0.0 at includes/functions.php file
         * 
         * @since 3.4.3.0
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        $this->do_action('wpt_load');

        /**
         * set_product_loop() is importants obviously
         * for ajax also
         */
        $this->set_product_loop();

        /**
         * Why i have added this $ob_get_clean = ob_get_clean();
         * Actually for product ajax load, we have used 
         * wp_send_json() 
         * and if found vardum or any worning, this function will not work
         * and table will frezz, So I have clean here
         * and now all other things will work.
         * And assign $output['.wpt-ob_get_clean'] = $ob_get_clean; 
         * into a class which is markuped inside table wrapper tag.
         * file: inc/shortcode.php 
         * 
         * @since 3.3.1.0
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        $ob_get_clean = ob_get_clean();
        $output = [];
        $output['.wpt-ob_get_clean'] = $ob_get_clean;

        //Whole Table Body part here
        ob_start();
        $this->argsOrganize()->table_body();
        $output['table.wpt-tbl>tbody'] = ob_get_clean();

        //Table stats mean: Showing 0 - 0 out of 0 Page 0 out of 0
        ob_start();
        $this->argsOrganize()->stats_render();
        $output['.wpt-stats-report'] = ob_get_clean();
        
        /**
         * The $max_page Defining should here after call $this->argsOrganize()->table_body();
         * Otherwise, Real page number and Max page number will not be ouptput actually
         * 
         * So I called here.
         */
        $max_page = (int) $this->max_num_pages;
        $page_number = (int) $page_number;
        
        /**
         * $this->pagination = 'on' mean: number pagination,
         * otherwise, for load more, it's value
         * 'load_more'
         * for inifinite, it's value 'infinite_scrool'
         */
        //We are not agable to set condition page on pagination on.
        //karon: jodi condition ekhane dei, ar search onusare pagination na thake, seta faka hoya dorokar, kintu ta hobe na.
        $output['.wpt_my_pagination.wpt_table_pagination'] = Pagination::get_paginate_links( $this );
        
        if( $this->pagination !== 'on' ){
            ob_start();
            Element::loadMoreButton( $this );
            $output['.wpt_load_more_wrapper'] = ob_get_clean();
        }
        
        if( ( $this->pagination !== 'on' && $max_page == $page_number ) || $max_page == 0){
            $output['.wpt_load_more_wrapper'] = $output['.wpt_my_pagination.wpt_table_pagination'] = '';
        }


        /**
         * Added a new Variable: $ob_get_clean = ob_get_clean();
         * which is fixed many issue and now no need this development part.
         * No need to comment on off actually.
         * We have shown our development part on ajax,
         * location class is: wpt-ob_get_clean and html <div class="wpt-ob_get_clean"></div>
         * which is inside inc/sortcode.php inside table wrpatter tag.
         * 
         * **************************
         * Only for Development Perpose,
         * When user would like to debug of
         * Table content OR inside Table table content.
         * Actually if u var_dump any thing, which will show inside table->body 
         * it will not display, because, in wpt-control.js file and inside ajaxTableLoad() 
         * function, we have replaced only 
         * So other tag/content will not show
         * *****************************************
         * IMPORTANT
         * *****************************************
         * In that time, I will go to wpt-control.js file and enable: $('table tbody').html(result); return;
         * AND In this php file, I will enable this part.
         * 
         *************COMMENT ENABLE/DISALE HERE ********
        $this->argsOrganize()->table_body();
        die();
        //***************************/
        $output['div>.other_output'] = ob_get_clean(); //Something some theme/plugin use enqueue on wc filter/action hook, that to publish on another selector.
        wp_send_json( $output );
        
        die();
    }

    /**
     * This is for add data to WooCommerce Fragments
     * Actually we have shown quantity at each add to cart button
     * by this fragment, we have shown data to each add to art btton.
     *
     * And crossed check by me(Saiful) that for quantity buble of Add To Cart Button
     * @return void
     */
    public function wpt_wc_fragments(){
        
        $output = [];
        $per_items = [];
        $Cart = WC()->cart->cart_contents;
        if( is_array( $Cart ) && count( $Cart ) > 0 ){
            foreach($Cart as $cart_item_key => $perItem){
                // var_dump($cart_item_key,$perItem);
                $pr_id = $perItem['product_id'];

                $pqt_value = $perItem['quantity'];
                $total_qty = isset( $qtys[$pr_id] ) ? $qtys[$pr_id] + $pqt_value : $pqt_value;
                $qtys[$pr_id] =  round($total_qty, 5);
                // $qtys[$pr_id] = $total_qty;

                $per_items[$pr_id]['cart_item_key'] = $cart_item_key;
                $per_items[$pr_id]['quantity'] = $qtys[$pr_id];
                $per_items[$pr_id]['type'] = 'normal';

                $vr_id = $perItem['variation_id'];
                if( $vr_id ){
                    $per_items[$vr_id]['cart_item_key'] = $cart_item_key;
                    $per_items[$vr_id]['quantity'] = $pqt_value;
                    $per_items[$vr_id]['type'] = 'variation';
                }

            }
        }
        $output['per_items'] = $per_items;

        // var_dump($output);
        wp_send_json( $output );
        
        die();
    }

    public function wpt_remove_from_cart(){
        $product_id = $_POST['product_id'] ?? 0;
        /**
         * Founded $cart_item_key 
         * called $req_cart_item_key
         */
        $req_cart_item_key = $_POST['cart_item_key'] ?? false;
        // if( $req_cart_item_key ){
        //     $product_id = 0;
        // }
        
        global $wpdb, $woocommerce;
        $removed = false;
        $contents = $woocommerce->cart->get_cart();
        foreach ( $contents as $cart_item_key => $cart_item_data ){
            
            if($cart_item_key === $req_cart_item_key){
                WC()->cart->set_quantity( $cart_item_key, 0, true );
                $removed = true;
                // break;
            }
            if( $product_id && ( $cart_item_data['product_id'] == $product_id || $cart_item_data['variation_id'] == $product_id ) ){

                WC()->cart->set_quantity( $cart_item_key, 0, true );
                $removed = true;
                // break;

            }
            
        }
        echo $removed ? "removed" : "not-founded";
        die();
    }

    /**
     * Woo Product Table
     * setting ATTS for Ajax Request
     * to work by this method,
     * need to send $_POST method
     * Where NEED Available $_POST['table_id']
     * 
     * 
     * @param string $method To be $_POST['table_id'] 
     * @return void
     */
    public function set_atts(){
        $table_id = $_POST['table_id'] ?? 0;
        $table_id = (int) $table_id;
        $atts = ['id'=> $table_id];
        return $atts;
    }

    public function ajax_action( string $ajax_action_name, string $method_name = '' ){
        if( empty( $method_name ) ){
            $method_name = $ajax_action_name;
        }
        $this->action('wp_ajax_' . $ajax_action_name, 1, 10, $method_name );
        $this->action('wp_ajax_nopriv_' . $ajax_action_name, 1, 10, $method_name );
    }
}