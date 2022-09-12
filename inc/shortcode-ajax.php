<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WC_AJAX;
use WOO_PRODUCT_TABLE\Inc\Shortcode;
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
        $args = $this->arrayFilter( $args );

        //It's need to the beginning of this process.
        $this->assing_property($atts); 
        
        if( is_array( $args ) && ! empty( $args ) ){

            if( $this->whole_search ){

                unset($this->args['post__in']);
                unset($this->args['post__not_in']);

                unset($this->args['tax_query']);
                unset($this->args['meta_query']);
            }
            
            $this->args = array_merge( $this->args, $args );
        }




        $page_number = $_POST['page_number'] ?? $this->page_number;
        
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
         * Why make this propety.
         * Actualy any any user need do something on $args after called ajax
         * user can check using $this->args_ajax_called
         * 
         * @since 3.2.5.1
         */
        $this->args_ajax_called = true;

        /**
         * set_product_loop() is importants obviously
         * for ajax also
         */
        $this->set_product_loop();
        $output = [];
        
        ob_start();
        $this->argsOrganize()->table_body();
        $output['table tbody'] = ob_get_clean();

        ob_start();
        $this->argsOrganize()->stats_render();
        $output['.wpt-stats-report'] = ob_get_clean();

        
        $output['.wpt_my_pagination.wpt_table_pagination'] = Pagination::get_paginate_links($this);
        wp_send_json( $output );
        
        die();
    }

    public function wpt_wc_fragments(){
        
        $output = [];
        $per_items = [];
        $Cart = WC()->cart->cart_contents;
        if( is_array( $Cart ) && count( $Cart ) > 0 ){
            foreach($Cart as $cart_item_key => $perItem){
                // var_dump($cart_item_key,$perItem);
                $pr_id = $perItem['product_id'];

                $pqt_value = $perItem['quantity'];
                $qtys[$pr_id] = isset( $qtys[$pr_id] ) ? $qtys[$pr_id] + $pqt_value : $pqt_value;

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

        var_dump($output);
        // wp_send_json( $output );
        
        die();

        die();
    }

    public function wpt_remove_from_cart(){
        $product_id = $_POST['product_id'] ?? 0;
        /**
         * Founded $cart_item_key 
         * called $req_cart_item_key
         */
        $req_cart_item_key = $_POST['cart_item_key'] ?? false;
        if( $req_cart_item_key ){
            $product_id = 0;
        }
        var_dump($product_id,$req_cart_item_key);
        global $wpdb, $woocommerce;
        $removed = false;
        $contents = $woocommerce->cart->get_cart();
        foreach ( $contents as $cart_item_key => $cart_item_data ){
            
            if($cart_item_key === $req_cart_item_key){
                WC()->cart->set_quantity( $cart_item_key, 0, true );
                $removed = true;
            }else if( $product_id && ! $req_cart_item_key && ( $cart_item_data['product_id'] == $product_id || $cart_item_data['variation_id'] == $product_id ) ){

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