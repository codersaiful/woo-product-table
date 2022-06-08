<?php


if( !function_exists( 'wpt_configuration_page' ) ){
    /**
     * For Configuration Page
     * 
     * @since 2.4
     */
    function wpt_configuration_page(){
        $settings = array(
            'page' => 'configuration_page',
            'module' => 'free',
        );
        $lang = apply_filters( 'wpml_current_language', NULL );
        $default_lang = apply_filters('wpml_default_language', NULL );
        $lang_ex = $lang == $default_lang ? '': '_' . $lang;

        $default_lang_bool = $lang == $default_lang ? true : false;

        $root_option_key = WPT_OPTION_KEY;
        $option_key =  $root_option_key . $lang_ex;
        $settings = apply_filters( 'wpto_configuration_settings', $settings );
        if( isset( $_POST['data'] ) && isset( $_POST['reset_button'] ) ){
            //Reset 
            $value = WPT_Product_Table::$default;
            update_option( $option_key,  $value  );

        }else if( isset( $_POST['data'] ) && isset( $_POST['configure_submit'] ) ){
            //configure_submit
            $value = false;
            if( is_array( $_POST['data'] ) ){
                $value = array_map(
                    function ($field){
                        //All post value is santized here using array_map
                        return is_array( $field ) ? $field :sanitize_text_field( $field );
                    },$_POST['data']
                );
            }
            // $value 's all key_value is sanitized before update on database
            update_option( $option_key,  $value );
        }
        $current_config_value = get_option( $option_key );
        
        if( empty( $current_config_value ) ){
            $current_config_value = get_option( $root_option_key );
        }
        
        $lang = apply_filters( 'wpml_current_language', NULL );
        $default_lang = apply_filters('wpml_default_language', NULL );
    
        
        $wrapper_class = isset( $settings['module'] ) ? $settings['module'] : '';
        
        ?>
        <div class="wrap wpt_wrap wpt_configure_page ultraaddons <?php echo esc_attr( $wrapper_class ); ?>">
            <h1 class="wp-heading-inline plugin_name"></h1>
            <div class="clear"></div>
            <?php wpt_get_pro_discount_message(); ?>
            <div id="wpt_configuration_form" class="wpt_leftside ">
                <?php do_action( 'wpto_admin_configuration_head' ); ?>
                
                <div class="fieldwrap">
                <?php 
                // do_action( 'wpt_offer_here' );
                 ?>
                    <form action="" method="POST">
                    <?php do_action( 'wpo_pro_feature_message', 'configuration_page_top' ); ?>
                        <?php 
                    /**
                     * Here wil will include two input Like bellow:
                     * <input name="config[plugin_version]" type="hidden" value="<?php echo WOO_Product_Table::getVersion(); ?>">
                        <input name="config[plugin_name]" type="hidden" value="<?php echo WOO_Product_Table::getName(); ?>">
                     */
                    do_action( 'wpto_admin_configuration_form_version_data', $settings,$current_config_value );
                    
                    if( $default_lang_bool ){
                        /**
                         * To add something and Anything at the top of Form Of Configuratin Page
                         */
                        do_action( 'wpto_admin_configuration_form_top', $settings,$current_config_value ); 
                    }
                    
                    do_action( 'wpto_admin_configuration_form', $settings,$current_config_value,'data' ); //'data' It's Forms Field Name Such: <input name='data[search_box]'>
                    
                    do_action( 'wpto_admin_configuration_form_bottom', $settings,$current_config_value ); 
                    ?>
                        
                        <div class="section ultraaddons-button-wrapper ultraaddons-panel no-background">
                            <button type="submit" name="configure_submit" class="button-primary button-primary primary button stick_on_scroll"><?php esc_html_e( 'Save Change', 'wpt_pro' );?></button>
                            <button type="submit" name="reset_button" 
                                    class="button button-default" 
                                    onclick="return confirm( 'If you continue with this action, you will reset all options in this page.\nAre you sure?' );"
                                    ><?php esc_html_e( 'Reset Settings', 'wpt_pro' );?></button>
                        </div>
                    </form>
                    
                    <?php do_action( 'wpt_offer_here' ); ?>
                </div>

            </div>
            <!-- Right Side start here -->
            <?php include __DIR__ . '/includes/right_side.php'; ?> 
            <div class="clear"></div>
        </div>  

        <style>
            .tab-content{display: none;}
            .tab-content.tab-content-active{display: block;}
            .wpt_leftside,.wpt_rightside{float: left;}
            .wpt_leftside{
                width: 75%;overflow:hidden;
            }
            .break_space_large{display: block;visibility: hidden;height: 25px;background: transparent;}
            .break_space,.break_space_medium{display: block;visibility: hidden;height: 15px;background: transparent;}
            .break_space_small{display: block;visibility: hidden;height: 5px;background: transparent;}
            .wpt_rightside{width: 25%;}
            @media only screen and (max-width: 800px){
                .wpt_leftside{width: 100%;}
                .wpt_rightside{display: none !important;}
            }


        </style>
        <?php
    }
}
