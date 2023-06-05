<?php 

/**
 * Actually when table will execute, then need column title value
 * based on translated language,
 * So we need to use following hook of filter hook
 * 
 * actually we saved translated column name with a sufix
 * such, colom keyword product_title, it's translated keyword is: product_title_lang
 * imean: product_title_bn or product_title_en 
 * here bn or en is wpml langs suffix
 *
 * @param array $column_array
 * @param int|string $table_ID
 * @param array $atts
 * @param array $column_settings
 * @return array
 */
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

/**
 * It's a major and critical update,
 * which was need at the begining of compatible on wpml
 * 
 * but there was a mistake.
 * Actually, if we want result, based on wpml then it's need
 * 
 * 
 * Remember: when query based on lanage, obviously need $args['suppress_filters'] = false;
 *
 * @param array $args
 * @return array
 */
function wpt_wmml_args_manipulation( $args ){

    $lang = apply_filters( 'wpml_current_language', NULL );
    if( $lang ){
        $args['lang'] = $lang;
        $args['suppress_filters'] = false;
    }

    return $args;
}
add_filter( 'wpt_query_args', 'wpt_wmml_args_manipulation' );
