<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WOO_PRODUCT_TABLE\Inc\Handle\Message as Msg;
use WOO_PRODUCT_TABLE\Inc\Handle\Args;
use WOO_PRODUCT_TABLE\Inc\Handle\Search_Box;
use WOO_PRODUCT_TABLE\Inc\Handle\Table_Attr;
use WOO_PRODUCT_TABLE\Inc\Table\Row;
use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Shortcode_Ajax extends Shortcode{
    public $test = "Test";
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
        if( is_array( $args ) ){
            $args = array_filter( $args, function( $item ){
                return ! empty( $item );
            });
        }

        //It's need to the beginning of this process.
        $this->assing_property($atts); 
        
        


        if( is_array( $args ) && ! empty( $args ) ){

            if( $this->whole_search ){
                unset($this->args['tax_query']);
                unset($this->args['meta_query']);
            }
            $this->args = array_merge( $args,$this->args );
        }
        
        $this->table_body();

        die();
    }
}