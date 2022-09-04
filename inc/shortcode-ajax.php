<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Handle\Pagination;

class Shortcode_Ajax extends Shortcode{
    public $_root = __CLASS__;
    public static $get_args;
    public function __construct()
    {
        
        $this->ajax_action('wpt_query', 'ajax_row_load');
        $this->ajax_action('wpt_pagination');
        $this->ajax_action('wpt_load_both');
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
        $this->args['paged'] = $this->page_number = $page_number;
        
        /**
         * Why make this propety.
         * Actualy any any user need do something on $args after called ajax
         * user can check using $this->args_ajax_called
         * 
         * @since 3.2.5.1
         */
        $this->args_ajax_called = true;

        $output = [];
        ob_start();
        $this->argsOrganize()->table_body();
        $output['table tbody'] = ob_get_clean();
        
        $output['.wpt_my_pagination.wpt_table_pagination'] = Pagination::get_paginate_links($this);
        wp_send_json( $output );
        // var_dump($this->page_number,$this->args);
        die();
    }

    public function wpt_pagination(){
        $atts = $this->set_atts();
        $this->assing_property( $atts ); 
        $page_number = $_POST['page_number'] ?? 1;
        
        $this->args['paged'] = $page_number;
        $this->args = $this->apply_filter('wpt_args_on_ajax_pagination', $this->args );
        echo Pagination::get_paginate_links($this);
        die();

    }
    public function ajax_row_load(){

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
        
        /**
         * Why make this propety.
         * Actualy any any user need do something on $args after called ajax
         * user can check using $this->args_ajax_called
         * 
         * @since 3.2.5.1
         */
        $this->args_ajax_called = true;

        $this->argsOrganize()->table_body();

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