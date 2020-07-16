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
        $settings = apply_filters( 'wpto_configuration_settings', $settings );
        if( isset( $_POST['data'] ) && isset( $_POST['reset_button'] ) ){
            //Reset 
            $value = WPT_Product_Table::$default;
            update_option( 'wpt_configure_options',  $value  );

        }else if( isset( $_POST['data'] ) && isset( $_POST['configure_submit'] ) ){
            //configure_submit
            $value = ( is_array( $_POST['data'] ) ? $_POST['data'] : false  );
            update_option( 'wpt_configure_options',  $value );
        }
        $current_config_value = get_option( 'wpt_configure_options' );
        
        $wrapper_class = isset( $settings['module'] ) ? $settings['module'] : '';
        
        ?>
        <div class="wrap wpt_wrap wpt_configure_page ultraaddons <?php echo esc_attr( $wrapper_class ); ?>">
            <h1 class="wp-heading-inline plugin_name"></h1>
            <div class="clear"></div>
            <div id="wpt_configuration_form" class="wpt_leftside ">
                <?php do_action( 'wpto_admin_configuration_head' ); ?>
                <div class="fieldwrap">
                    <form action="" method="POST">
                        <?php 
                    /**
                     * Here wil will include two input Like bellow:
                     * <input name="config[plugin_version]" type="hidden" value="<?php echo WOO_Product_Table::getVersion(); ?>">
                        <input name="config[plugin_name]" type="hidden" value="<?php echo WOO_Product_Table::getName(); ?>">
                     */
                    do_action( 'wpto_admin_configuration_form_version_data', $settings,$current_config_value );
                    
                    /**
                     * To add something and Anything at the top of Form Of Configuratin Page
                     */
                    do_action( 'wpto_admin_configuration_form_top', $settings,$current_config_value ); 
                    
                    
                    do_action( 'wpto_admin_configuration_form', $settings,$current_config_value,'data' ); //'data' It's Forms Field Name Such: <input name='data[search_box]'>
                    
                    do_action( 'wpto_admin_configuration_form_bottom', $settings,$current_config_value ); 
                    ?>
                        
                        <div class="section ultraaddons-button-wrapper ultraaddons-panel no-background">
                            <button type="submit" name="configure_submit" class="button-primary button-primary primary button"><?php esc_html_e( 'Save Change', 'wpt_pro' );?></button>
                            <button type="submit" name="reset_button" 
                                    class="button button-default" 
                                    onclick="return confirm( 'If you continue with this action, you will reset all options in this page.\nAre you sure?' );"
                                    ><?php esc_html_e( 'Reset Settings', 'wpt_pro' );?></button>
                        </div>
                    </form>
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
