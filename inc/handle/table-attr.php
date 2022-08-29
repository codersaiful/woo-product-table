<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
class Table_Attr{

    public static function wrapper_class( Shortcode $shortcode ){
        $shortcode->wrapper_class = [
            $shortcode->table_type . "_wrapper",
            "detected_device_" . $shortcode->_device . '_wrapper',
            " wpt_temporary_wrapper_" . $shortcode->table_id,
            " wpt_id_" . $shortcode->table_id,
            "wpt_product_table_wrapper",
            $shortcode->template . "_wrapper woocommerce",
            $shortcode->checkbox,
            "wpt_" . $shortcode->pagination_ajax,
        ];

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
}