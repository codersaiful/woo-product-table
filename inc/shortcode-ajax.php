<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Shortcode_Ajax extends Shortcode{
    public $_root = __CLASS__;
    public function __construct()
    {
        
        add_action( 'wp_ajax_wpt_query', [$this,'ajax_row_load'] );
        add_action( 'wp_ajax_nopriv_wpt_query', [$this,'ajax_row_load'] );
    }



    public function ajax_row_load(){

        $table_id = $_POST['table_id'] ?? 0;
        $table_id = (int) $table_id;
        $atts = ['id'=> $table_id];
        
        
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
        
        $this->argsOrganize()->table_body();

        die();
    }
}