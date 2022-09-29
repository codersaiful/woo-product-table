<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Core\Base;
use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Enable_Column extends Base{

    public static $shortcode;
    public static $args;
    public static $table_id;
    public static $cols;



    /**
     * Table Column handlaling based on different type of condition. 
     * Such: if advance table enable, we would like to hide message column from row.
     * 
     * Table Column Manipulation
     * -----------------
     * 
     *
     * @param Shortcode $shortcode It's our main Class of Product Table, where all are indicated.
     * @return void
     * 
     * @package WooProductTable
     * @author Saiful Islam <codersaiful@gmail.com>
     */
    public static function manage( Shortcode $shortcode ){
        self::$table_id = $shortcode->table_id;
        self::$cols = $shortcode->_enable_cols;
        // var_dump($shortcode->req_product_type);
        // var_dump($shortcode->table_type);
        //var_dump( $shortcode->table_type == 'advance', $shortcode->table_type,$shortcode->_enable_cols['message'] );
        if( isset( $shortcode->_enable_cols['message'] ) && $shortcode->table_type == 'advance_table' ){
            unset($shortcode->_enable_cols['message']);
            add_action( 'woocommerce_before_add_to_cart_quantity', 'wpt_add_custom_message_field' );
        }

        if( $shortcode->req_product_type == 'product_variation' ){
            unset( $shortcode->_enable_cols['category'] );
            unset( $shortcode->_enable_cols['tags'] );
            unset( $shortcode->_enable_cols['weight'] );
            unset( $shortcode->_enable_cols['length'] );
            unset( $shortcode->_enable_cols['width'] );
            unset( $shortcode->_enable_cols['height'] );
            unset( $shortcode->_enable_cols['rating'] );
            unset( $shortcode->_enable_cols['attribute'] );
            unset( $shortcode->_enable_cols['variations'] );
        }



    }
}