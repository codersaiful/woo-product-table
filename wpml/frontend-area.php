<?php 
function change_enable_col_by_wpml($column_array, $table_ID, $atts, $column_settings){
    
    $lang = apply_filters( 'wpml_current_language', NULL );
    $default_lang = apply_filters('wpml_default_language', NULL );

    if( $lang == $default_lang ) return $column_array;

    
    foreach( $column_array as $key_col => $col ){
        $n_val = $column_settings[$key_col][$lang] ?? '';
        if( ! empty( $n_val ) ){
            $column_array[$key_col] = $n_val;
        }
    }

    return $column_array;
}
add_filter('wpto_column_arr','change_enable_col_by_wpml', 10, 4);

