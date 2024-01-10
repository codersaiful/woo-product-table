<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Table\Row;
class Table_Attr{

    public static function wrapper_class( Shortcode $shortcode ){

        $shortcode->wrapper_class = [
            $shortcode->table_type . "_wrapper",
            "detected_device_" . $shortcode->_device . '_wrapper',
            " wpt_temporary_wrapper_" . $shortcode->table_id,
            " wpt_id_" . $shortcode->table_id,
            " wpt_column_sort",
            "wpt_product_table_wrapper",
            "wpt-wrap",
            $shortcode->template . "_wrapper woocommerce",
            $shortcode->checkbox,
            "wpt_" . $shortcode->pagination_ajax,
        ];
        if($shortcode->auto_responsive){
            $shortcode->wrapper_class[] = 'wpt-auto-responsive';
        }

        //In Future Update version, this filter will removed
        $shortcode->wrapper_class = apply_filters( 'wpto_wrapper_tag_class_arr', $shortcode->wrapper_class, $shortcode->table_id, $shortcode->args, $shortcode->column_settings, $shortcode->_enable_cols, $shortcode->column_array );
        $shortcode->wrapper_class = $shortcode->apply_filter( 'wpt_wrapper_class', $shortcode->wrapper_class );
        
        if( ! is_array( $shortcode->wrapper_class ) ){
            $shortcode->wrapper_class = [];
        }

        return implode( " ", $shortcode->wrapper_class );
    }
    public static function table_class( Shortcode $shortcode ){

        $responsive = $shortcode->basics['responsive'] ?? 'no_responsive';
        $table_class = $shortcode->basics['table_class'] ?? '';
        $custom_add_to_cart = $shortcode->_config['custom_add_to_cart'] ?? 'no_set_custom_addtocart';
        $shortcode->table_class = [
            $responsive,
            $shortcode->table_type,
            'device_for_colum' . $shortcode->_device,
            'wpt_temporary_table_' . $shortcode->table_id,
            'wpt_product_table',
            'wpt-tbl',
            $shortcode->template. '_table',
            // "{$custom_table}_table",
            $table_class,
            $custom_add_to_cart,
        ];

        //In Future Update version, this filter will removed
        $shortcode->table_class = apply_filters( 'wpto_table_tag_class_arr', $shortcode->table_class, $shortcode->table_id, $shortcode->args, $shortcode->column_settings, $shortcode->_enable_cols, $shortcode->column_array );
        $shortcode->table_class = $shortcode->apply_filter( 'wpt_table_class', $shortcode->table_class );
        
        if( ! is_array( $shortcode->table_class ) ){
            $shortcode->table_class = [];
        }

        return implode( " ", $shortcode->table_class );
    }

    public static function tr_class( Row $row  ){
        $stock_amount = $row->product_data['stock_quantity'] ?? '';
        $stock_status = $row->product_data['stock_status'];
        if( is_numeric( $stock_amount ) && $stock_amount > 0 && $stock_amount < 1 ){
            $stock_status = 'instock';
        }
        
        $row->tr_class = [
            "visible_row",
            "wpt_row",
            "wpt-row",
            "wpt_row_" . $row->table_id,
            "wpt_row_serial_",
            "wpt_row_product_id_" . get_the_ID(),
            "product_id_" . get_the_ID(),
            $row->taxonomy_class,
            $row->product_type,
            "product_type_" . $row->product_type,
            "stock_status_" . $stock_status,
            "backorders_" . $row->product_data['backorders'],
            "sku_" . $row->product_data['sku'],
            "status_" . $row->product_data['status'],
            $row->individual,
                    
        ];

        //In Future Update version, this filter will removed
        $row->tr_class = apply_filters( 'wpto_tr_class_arr', $row->tr_class, $row->args, $row->table_id, $row->column_settings, $row->_enable_cols, $row->product_data );
        $row->tr_class = $row->apply_filter( 'wpt_tr_class', $row->tr_class );
        
        if( ! is_array( $row->tr_class ) ){
            $row->tr_class = [];
        }

        $row->tr_class_string = implode( " ", $row->tr_class );
        return $row->tr_class_string;
    }

    /**
     * Class generate for table TD
     * Available also 
     * 
     * 
     * ***********************
     *  IMPORTANT NOTICE:
     * ***********************
     * as td_or_cell class is must and it's should not be customizeable, thats why,
     * I have transferred it to row
     * 
     * @author Saiful Islam <codersaiful@gmail.com>
     * 
     * @return string
     */
    public static function td_class( string $keyword, Row $row ){
        
        $td_class_arr = array(
            "wpt_" . $keyword,
            "wpt_temp_" . $row->table_id,
        );
        
        /**
         * Adding Class using Filter Hook
         * 
         * @Hooked: wpt_add_td_class -10 at includes/functions.php 
         */
        $td_class_arr = apply_filters( 'wpto_td_class_arr', $td_class_arr, $keyword, $row->table_id, $row->args, $row->column_settings, null, null );
        $td_class_arr = $row->apply_filter( 'wpt_td_class', $td_class_arr );
        if( is_array( $td_class_arr ) ){
            $td_class = implode( " ", $td_class_arr );
        }else{
            $td_class = 'wpt_table_td wpt_' . $keyword;
        }
        return $td_class;
    }
}