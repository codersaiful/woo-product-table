<?php 
function change_enable_col_by_wpml($column_array, $table_ID, $atts, $column_settings){
    // var_dump($enabled_column_array, $table_ID);
    $lang = apply_filters( 'wpml_current_language', NULL );
    $default_lang = apply_filters('wpml_default_language', NULL );

    if( $lang == $default_lang ) return $column_array;

    // var_dump($column_array);
    // var_dump($lang,$column_settings,$column_array);
    
    foreach( $column_array as $key_col => $col ){
        $n_val = $column_settings[$key_col][$lang] ?? '';
        if( ! empty( $n_val ) ){
            $column_array[$key_col] = $n_val;
        }
        // $temp_col_arr[$key_col] = $column_settings[$key_col][$lang] ?? $col;
    }
    var_dump($column_array);

    return $column_array;
}
add_filter('wpto_column_arr','change_enable_col_by_wpml', 10, 4);
// add_filter('wpto_enabled_column_array','change_enable_col_by_wpml', 10, 2);


if( ! function_exists( 'wpt_wpml_column_title' ) ){

    /**
     * <input type="radio" id="link<?php echo esc_attr( $_device_name ); ?>" name="column_settings<?php echo esc_attr( $_device_name ); ?>[title_variation]" value="link" <?php echo !$title_variation || $title_variation == 'link' ? 'checked' : ''; ?>>
     */
    
    function wpt_wpml_column_title( $keyword, $_device_name, $current_colum_settings, $column_settings ){

        if( $keyword == 'check' ) return;
        // var_dump($column_settings);
        global $sitepress;

        // var_dump($current_colum_settings);

        // $lang = apply_filters( 'wpml_current_language', NULL );
        $lang = apply_filters('wpml_default_language', NULL );
        // var_dump($lang);
        $active_langs = $sitepress->get_active_languages();
        if(isset( $active_langs[$lang] )){
            unset($active_langs[$lang]);
        }
        // var_dump($sitepress->get_active_languages());
        // var_dump($active_langs);

        if( ! is_array( $active_langs ) ) return;
        
       ?>
        <div class="language-area">
            <p class="lang-area-title"><?php echo esc_html__( 'WPML Translate Area', 'wpt_pro' ); ?></p>
            <div class="wpml-lang-input-area">
                <?php foreach( $active_langs as $active_lang ){
                    
                    $code = $active_lang['code'];
                    $english_name = $active_lang['english_name'];
                    $native_name = $active_lang['native_name'];
                    $lang_name = $english_name . "({$native_name})";
                    $value = $current_colum_settings[$code] ?? "";
                ?>
                <p class="wpt-each-input">
                    <lable><?php echo esc_html( $lang_name ); ?></lable>
                    <input 
                    class="wpml-col-title"
                    name="column_settings<?php echo esc_attr( $_device_name ); ?>[<?php echo esc_attr( $keyword ); ?>][<?php echo esc_attr( $code ); ?>]" 
                    type="text" 
                    value="<?php echo wp_kses_post( $value ); ?>">
                </p>
                <?php } ?>
                
            </div>
            
        </div>
               

       <?php
   }
}
add_action( 'wpto_column_basic_form', 'wpt_wpml_column_title', 10, 4 );