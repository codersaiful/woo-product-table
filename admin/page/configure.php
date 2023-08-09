<?php
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
<div class="wrap wpt_wrap wpt-content">

    <h1 class="wp-heading "></h1>
    <div class="fieldwrap">
        <form action="" method="POST">

        <div class="wpt-section-panel no-background wpt-full-form-submit-wrapper">
            <button name="configure_submit" type="submit"
                class="wpt-btn wpt-has-icon configure_submit">
                <span><i class="wpt-floppy"></i></span>
                <strong class="form-submit-text">
                <?php echo esc_html__('Save Change','wpt');?>
                </strong>
            </button>
        </div>
        
    <?php 
        /**
         * Here wil will include two input Like bellow:
         * <input name="config[plugin_version]" type="hidden" value="<?php echo WOO_Product_Table::getVersion(); ?>">
            <input name="config[plugin_name]" type="hidden" value="<?php echo WOO_Product_Table::getName(); ?>">
         */
        do_action( 'wpto_admin_configuration_form_version_data', $settings,$current_config_value );

        if( $default_lang_bool ){
    ?>
        <!-- <div class="wpt-section-panel supported-terms configuration_page" id="wpt-configurate-main-section"> -->
    <?php
    /**
     * To add something and Anything at the top of Form Of Configuratin Page
     */
    do_action( 'wpto_admin_configuration_form_top', $settings,$current_config_value ); 

    ?>
        <!-- </div> -->
        
    <?php
        }
        
        do_action( 'wpto_admin_configuration_form', $settings,$current_config_value,'data' ); //'data' It's Forms Field Name Such: <input name='data[search_box]'>
        
        do_action( 'wpto_admin_configuration_form_bottom', $settings,$current_config_value ); 
        ?>
            
            <div class="wpt-section-panel no-background wpt-full-form-submit-wrapper">
                
                <button name="configure_submit" type="submit"
                    class="wpt-btn wpt-has-icon configure_submit">
                    <span><i class="wpt-floppy"></i></span>
                    <strong class="form-submit-text">
                    <?php esc_html_e( 'Save Change', 'woo-product-table' );?>
                    </strong>
                </button>
                <button name="reset_button" 
                    class="wpt-btn reset wpt-has-icon reset_button"
                    onclick="return confirm('If you continue with this action, you will reset all options in this page.\nAre you sure?');">
                    <span><i class="wpt-arrows-cw "></i></span>
                    <?php esc_html_e( 'Reset Settings', 'woo-product-table' );?>
                </button>
                
            </div>

        </form>
    </div>

</div> <!-- ./wrap wpt_wrap wpt-content -->
<div class="wrap wpt_wrap wpt_configure_page ultraaddons <?php echo esc_attr( $wrapper_class ); ?>">

</div>  


