<?php 
namespace WOO_PRODUCT_TABLE\Inc;

class Shortcode{

    public $atts;
    public $table_id;
    public $status;
    public $post_type;

    public $is_table;

    public $_device;

    public $cols;
    

    public function run(){
        add_shortcode( 'SAIFUL_TABLE', [$this, 'shortcode'] );
    }
    public function shortcode($atts){
        $this->atts = $atts;

        $pairs = array( 'exclude' => false );
        extract( shortcode_atts( $pairs, $atts ) );


        $this->table_id = isset( $atts['id'] ) && !empty( $atts['id'] ) ? (int) $atts['id'] : 0; 
        $this->table_id = apply_filters( 'wpml_object_id', $this->table_id, 'wpt_product_table', TRUE  );
        $this->status = get_post_status( $this->table_id );
        $this->post_type = get_post_type( $this->table_id );

        set_query_var( 'woo_product_table', $this->table_id );

        $this->is_table = $this->table_id && $this->post_type == 'wpt_product_table' && $this->status == 'publish';
        if( $this->is_table ){

        }


        $this->_device = wpt_col_settingwise_device( $this->table_id );

        
    }
}