<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Core\Base;
use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Enable_Column extends Base{

    // public static $shortcode;
    // public static $args;
    // public static $table_id;
    // public static $cols;
    public static $inner_items = [];
    public static $message_col = false;


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


        /**
         * Handling Message Column or as Innter Item
         * If found any where and Enable Advance Table/ Third party plugin support,
         * 
         * then I will add it by action hook inside action column. Otherwise, it will not work
         * 
         * @author Saiful Islam <codersaiful@gmail.com>
         * @since 3.2.5.5.final8
         */
        if( $shortcode->table_type == 'advance_table' ){
            self::$message_col = isset( $shortcode->_enable_cols['message'] ); //If available, value will be true
            
            self::$inner_items = array_column( $shortcode->column_settings, 'items' );

            foreach( $shortcode->column_settings as $key=>$items){
                if( ! isset( $items['items'] ) ) continue;

                $m_index = array_search( 'message', $items['items'] );
                
                if( is_int( $m_index ) ){
                    
                    unset($shortcode->column_settings[$key]['items'][$m_index]);
                    self::$message_col = true;
                    break;
                }
                
            }

            if( self::$message_col ){
                unset($shortcode->_enable_cols['message']);
                add_action( 'woocommerce_before_add_to_cart_quantity', 'wpt_add_custom_message_field' );
            }
        }
        //If set Only Product Variation
        if( $shortcode->req_product_type == 'product_variation' ){
            /**
             * We have remove @version 3.3.8.1 because, in category item
             * we have taken parent product it when it variation product.
             */
            // unset( $shortcode->_enable_cols['category'] );

            /**
             * We have remove @version 3.3.8.1 because, in tag item
             * we have taken parent product it when it variation product.
             */
            // unset( $shortcode->_enable_cols['tags'] );
            unset( $shortcode->_enable_cols['weight'] );
            unset( $shortcode->_enable_cols['length'] );
            unset( $shortcode->_enable_cols['width'] );
            unset( $shortcode->_enable_cols['height'] );
            unset( $shortcode->_enable_cols['rating'] );
            //removed@version 3.3.8.1
            // unset( $shortcode->_enable_cols['attribute'] );
            // unset( $shortcode->_enable_cols['variations'] );
        }



    }
}