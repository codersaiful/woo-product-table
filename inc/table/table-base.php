<?php 
namespace WOO_PRODUCT_TABLE\Inc\Table;

use WOO_PRODUCT_TABLE\Inc\Shortcode_Base;

class Table_Base extends Shortcode_Base{
    
    /**
     * String with comma to Array, 
     * I will use explode function and will convert to Array.
     * 
     * ******
     * Specially maked for Old user, who has created his table many time ago.
     *
     * @param string $string_txt Required string but if anyone set any other content, it will fix.
     * @return array
     */
    protected function string_to_array( $string_txt ){
        if( empty( $string_txt ) ) return [];
        if( is_array( $string_txt ) ) return $string_txt;
        if( ! is_string( $string_txt ) ) return [];
        $string_txt = rtrim( $string_txt, ', ' );
        $string_txt = ltrim( $string_txt, ', ' );
        return explode( ',', $string_txt );
    }
    
}