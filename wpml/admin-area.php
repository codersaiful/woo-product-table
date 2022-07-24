<?php 


if( ! function_exists( 'wpt_wpml_column_title' ) ){

    /**
     * <input type="radio" id="link<?php echo esc_attr( $_device_name ); ?>" name="column_settings<?php echo esc_attr( $_device_name ); ?>[title_variation]" value="link" <?php echo !$title_variation || $title_variation == 'link' ? 'checked' : ''; ?>>
     */
    
    function wpt_wpml_column_title( $keyword, $_device_name, $current_colum_settings, $column_settings ){

        if( $keyword == 'check' ) return;

        // $lang = apply_filters( 'wpml_current_language', NULL );
        $lang = apply_filters('wpml_default_language', NULL );
        $active_langs = apply_filters( 'wpml_active_languages', array(), 'orderby=id&order=desc' );

        // $active_langs = $sitepress->get_active_languages();

        if(isset( $active_langs[$lang] )){
            unset($active_langs[$lang]);
        }

        if( ! is_array( $active_langs ) ) return;
        
       ?>
        <div class="language-area">
            <p class="lang-area-title"><?php echo esc_html__( 'WPML Translate Area', 'wpt_pro' ); ?></p>
            <div class="wpml-lang-input-area">
                <?php foreach( $active_langs as $active_lang ){
                    
                    $code = $active_lang['code'];
                    $english_name = $active_lang['translated_name'];
                    $native_name = $active_lang['native_name'];
                    $lang_name = $english_name . "({$native_name})";
                    $value = $current_colum_settings[$code] ?? "";
                    $flag = $active_lang['country_flag_url'];
                ?>
                <p class="wpt-each-input">
                    <lable><img src="<?php echo esc_url( $flag ); ?>" class="wpt-wpml-admin-flag"> <?php echo esc_html( $lang_name ); ?></lable>
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


if( ! function_exists( 'wpt_wpml_basic_tab' ) ){

    /**
     * <input type="radio" id="link<?php echo esc_attr( $_device_name ); ?>" name="column_settings<?php echo esc_attr( $_device_name ); ?>[title_variation]" value="link" <?php echo !$title_variation || $title_variation == 'link' ? 'checked' : ''; ?>>
     */
    
    function wpt_wpml_basic_tab( $meta_basics ){

        $lang = apply_filters( 'wpml_current_language', NULL );
        $default_lang = apply_filters('wpml_default_language', NULL );
        $lang_ex = $lang == $default_lang ? '': '_' . $lang;

        $default_lang_bool = $lang == $default_lang ? true : false;

        $active_langs = apply_filters( 'wpml_active_languages', array(), 'orderby=id&order=desc' );

        // $active_langs = $sitepress->get_active_languages();

        if(isset( $active_langs[$lang] )){
            unset($active_langs[$lang]);
        }

        if( ! is_array( $active_langs ) ) return;
        
        $trns_fields = array(
            'add_to_cart_selected_text',
            'add_to_cart_text',
            'check_uncheck_text',
        );
       ?>
        <div class="language-area">
            <p class="lang-area-title"><?php echo esc_html__( 'WPML Translate Area', 'wpt_pro' ); ?></p>
            <div class="wpml-lang-input-area basic-tab-wpml-area">
                <?php foreach( $active_langs as $active_lang ){
                    
                    $code = $active_lang['code'];
                    $english_name = $active_lang['translated_name'];
                    $native_name = $active_lang['native_name'];
                    $lang_name = $english_name . "({$native_name})";
                    
                    $flag = $active_lang['country_flag_url'];
                ?>
                <div class="wpt-each-input">
                    <lable><img src="<?php echo esc_url( $flag ); ?>" class="wpt-wpml-admin-flag"> <?php echo esc_html( $lang_name ); ?></lable>
                <div class="wpml-inside-fields">

                <?php
                foreach( $trns_fields as $field ){
                    $input_name = $field . '_' . $code;
                    $value = $meta_basics[$input_name] ?? '';
                ?>
                <p>
                    <label><code><?php echo esc_html( $field ); ?></code></label>
                    <input 
                        class="wpml-col-title"
                        name="basics[<?php echo esc_attr( $input_name ); ?>]"
                        type="text" 
                        value="<?php echo wp_kses_post( $value ); ?>">
                </p>
                <?php 
                }
                ?>
                </div>
                </div>
                <?php } ?>
                
            </div>
            
        </div>
               

       <?php
   }
}
add_action( 'wpto_admin_basic_tab_bottom', 'wpt_wpml_basic_tab', 999 );

if( ! function_exists( 'wpt_wpml_config_switch_notc' ) ){

    /**
     * <input type="radio" id="link<?php echo esc_attr( $_device_name ); ?>" name="column_settings<?php echo esc_attr( $_device_name ); ?>[title_variation]" value="link" <?php echo !$title_variation || $title_variation == 'link' ? 'checked' : ''; ?>>
     */
    
    function wpt_wpml_config_switch_notc( ){

        ?>
        <div class="fieldwrap ultraaddons-head wpml-config-page-notce-switch">
            <div class="ultraaddons-panel">
            <?php echo esc_html__( 'TIPS for WPML USER: to change Message\'s value based on your language, First change language from admin bar and then change your message.', 'wpt_pro' ); ?>
            </div>
        </div>
       <?php
   }
}
add_action( 'wpto_admin_configuration_head', 'wpt_wpml_config_switch_notc', PHP_INT_MAX );
