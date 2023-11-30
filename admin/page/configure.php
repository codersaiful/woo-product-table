<?php
$settings = array(
    'page' => 'configuration_page',
    'module' => 'free',
);
$lang = apply_filters('wpml_current_language', NULL);
$default_lang = apply_filters('wpml_default_language', NULL);
$lang_ex = $lang == $default_lang ? '' : '_' . $lang;

$default_lang_bool = $lang == $default_lang ? true : false;

$root_option_key = WPT_OPTION_KEY;
$option_key =  $root_option_key . $lang_ex;
$settings = apply_filters('wpto_configuration_settings', $settings);
if (isset($_POST['data']) && isset($_POST['reset_button'])) {
    //Reset 
    $value = WPT_Product_Table::$default;
    update_option($option_key,  $value);
} else if (isset($_POST['data']) && isset($_POST['configure_submit'])) {
    //configure_submit
    $value = false;
    if (is_array($_POST['data'])) {
        $value = array_map(
            function ($field) {
                //All post value is santized here using array_map
                return is_array($field) ? $field : sanitize_text_field($field);
            },
            $_POST['data']
        );
    }
    // $value 's all key_value is sanitized before update on database
    update_option($option_key,  $value);
}
$current_config_value = get_option($option_key);

if (empty($current_config_value)) {
    $current_config_value = get_option($root_option_key);
}

$lang = apply_filters('wpml_current_language', NULL);
$default_lang = apply_filters('wpml_default_language', NULL);


$wrapper_class = isset($settings['module']) ? $settings['module'] : '';

?>
<div class="wrap wpt_wrap wpt-content <?php echo esc_attr($wrapper_class); ?>">

    <h1 class="wp-heading "></h1>
    <div class="fieldwrap">
        <form action="" method="POST"  id="wpt-main-configuration-form">

            <div class="wpt-configure-tab-wrapper wpt-section-panel no-background"></div>
            <!-- <div class="wpt-section-panel no-background wpt-full-form-submit-wrapper">
                <button name="configure_submit" type="submit" class="wpt-btn wpt-has-icon configure_submit">
                    <span><i class="wpt-floppy"></i></span>
                    <strong class="form-submit-text">
                        <?php echo esc_html__('Save Change', 'wpt'); ?>
                    </strong>
                </button>
            </div> -->

            <?php
            /**
             * Here wil will include two input Like bellow:
             * <input name="config[plugin_version]" type="hidden" value="<?php echo WOO_Product_Table::getVersion(); ?>">
            <input name="config[plugin_name]" type="hidden" value="<?php echo WOO_Product_Table::getName(); ?>">
             */
            do_action('wpto_admin_configuration_form_version_data', $settings, $current_config_value);

            if ($default_lang_bool) {
            ?>

                <div class="wpt-section-panel supported-terms configuration_page" id="wpt-configurate-main-section">
                    <table class="wpt-my-table universal-setting">
                        <thead>
                            <tr>
                                <th class="wpt-inside">
                                    <div class="wpt-table-header-inside">
                                        <h3><?php echo esc_html__('Settings', 'wpt'); ?></h3>
                                    </div>

                                </th>
                                <th>
                                    <div class="wpt-table-header-right-side"></div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>

                    
                    <?php
                    /**
                     * To add something and Anything at the top of Form Of Configuratin Page
                     */
                    do_action('wpto_admin_configuration_form_top', $settings, $current_config_value, $this);

                    ?>
                </div> <!-- ./wpt-section-panel supported-terms configuration_page -->

            <?php
            }

            do_action('wpto_admin_configuration_form', $settings, $current_config_value, 'data'); //'data' It's Forms Field Name Such: <input name='data[search_box]'>

            do_action('wpto_admin_configuration_form_bottom', $settings, $current_config_value);
            ?>

            <div class="wpt-section-panel no-background wpt-full-form-submit-wrapper">

                <button name="configure_submit" type="submit" class="wpt-btn wpt-has-icon configure_submit">
                    <span><i class="wpt-floppy"></i></span>
                    <strong class="form-submit-text">
                        <?php esc_html_e('Save Change', 'woo-product-table'); ?>
                    </strong>
                </button>
                <button name="reset_button" class="wpt-btn reset wpt-has-icon reset_button" onclick="return confirm('If you continue with this action, you will reset all options in this page.\nAre you sure?');">
                    <span><i class="wpt-arrows-cw "></i></span>
                    <?php esc_html_e('Reset Settings', 'woo-product-table'); ?>
                </button>

            </div>

        </form>

        <div class="wpt-section-panel supported-terms wpt-recomendation-area" id="wpt-recomendation-area">
            <table class="wpt-my-table universal-setting">
                <thead>
                    <tr>
                        <th class="wpt-inside">
                            <div class="wpt-table-header-inside">
                                <h3><?php echo esc_html__('Recommendation Area', 'wpt'); ?> <small class="wpt-small-title">To increase Sale</small></h3>
                            </div>

                        </th>
                        <th>
                            <div class="wpt-table-header-right-side"></div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                <tr>
                    <td>
                        <div class="wqpmb-form-control">
                            <div class="form-label col-lg-12">
                            <?php do_action( 'wpt_plugin_recommend_here' ); ?>
                            </div>
                            <div class="form-label col-lg-12">
                                <?php wpt_submit_issue_link(); ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wqpmb-form-info">
                            
                            <?php wpt_social_links(); ?>
                            <p>Highly Recommeded these plugin. Which will help you to increase your WooCommerce sale.</p>
                        </div> 
                    </td>
                </tr>
                </tbody>
            </table>

        </div> <!--/.wpt-recomendation-area -->
        <?php
        do_action('wpt_addon_license_area');
        ?>
    </div>

</div> <!-- ./wrap wpt_wrap wpt-content -->