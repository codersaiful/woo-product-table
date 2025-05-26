<?php


if (!function_exists('wpt_admin_body_class')) {
    /**
     * set class for Admin Body tag
     * 
     * @param type $classes
     * @return String
     */
    function wpt_admin_body_class($class_string)
    {
        global $current_screen;
        $s_id = isset($current_screen->id) ? $current_screen->id : '';
        if (strpos($s_id, 'wpt_product_table') !== false) {
            return $class_string . ' wpt_admin_body ';
        }
        return $class_string;
    }
}
add_filter('admin_body_class', 'wpt_admin_body_class', 999);

if (!function_exists('wpt_selected')) {

    /**
     * actually for Select Option
     * Inside Config Tab or Inside Configuration Page
     * Executing If available or Not. 
     * If false $default_config, Then It will come from 
     * get_option( WPT_OPTION_KEY )
     * 
     * @since 2.4 
     */
    function wpt_selected($keyword, $gotten_value, $default_config = false)
    {
        $current_config_value = is_array($default_config) ? $default_config : get_option(WPT_OPTION_KEY);
        $output = (isset($current_config_value[$keyword]) && $current_config_value[$keyword] == $gotten_value ? 'selected' : false);
        echo esc_attr( $output );
    }
}
if (!function_exists('wpt_default_option')) {

    /**
     * Getting default option tag
     * for Configuration tab on Product edit
     * 
     * Actually we need a blank default option tag for select tab
     * when inside configuration tab
     * 
     * @param String $page
     */
    function wpt_default_option($page)
    {
        if ($page == 'wpt_configuration_tab') {
            ?>
            <option value=""><?php echo esc_html__("Default", 'woo-product-table'); ?></option>
            <?php
        }
    }
}

/**
 * Remove empty Array value from an Multi-dimensional Array
 * I have taken help from a stackoverflow tips.
 *
 * @param Array $array Obviously should be an Array
 * @return Array
 * 
 * @link https://stackoverflow.com/questions/9895130/recursively-remove-empty-elements-and-subarrays-from-a-multi-dimensional-array
 * 
 */
function wpt_remove_empty_value_from_array($array)
{


    if (! is_array($array)) return $array;

    foreach ($array as $key => &$value) {
        if (! is_bool($value) && empty($value)) {
            unset($array[$key]);
        } else {
            if (is_array($value)) {
                $value = wpt_remove_empty_value_from_array($value);
                if (! is_bool($value) && empty($value)) {
                    unset($array[$key]);
                }
            }
        }
    }

    return $array;
}



/**
 * User wise limit function,
 * we will detect new user
 * based on date 12 Oct, 2021
 * 
 * if have post on product table before that date,
 * we will consider as old user
 * 
 * @since 3.0.1.0
 */
function wpt_datewise_validation()
{
    //If pro available, directly return true
    if (defined('WPT_PRO_DEV_VERSION')) return true;
    return;
}

/**
 * Alias function of wpt_datewise_validation()
 * to validation check for old and new user
 * 
 * @since 3.0.1.0 
 * @return bool true|false
 */
function wpt_user_can_edit()
{
    return wpt_datewise_validation();
}

function wpt_get_pro_discount_message()
{
    return;
}


/**
 * check pro available or not
 * 
 * @since 3.0.1
 * @by Saiful
 * 
 * @return boolean true|false
 */
function wpt_is_pro()
{
    if (defined('WPT_PRO_DEV_VERSION')) return true;

    return false;
}

/**
 * Check if the user is a new user or not
 * asole premium install ache ki na check korar jonno
 * 
 * @since 4.0.3.4
 * @return string Conditional class name
 */
function wpt_get_conditional_class()
{
    $cond_class = '';
    if (! wpt_is_pro()) {
        $cond_class = 'wpt-premium-feature-in-free-version';
    }
    return $cond_class;
}

/**
 * @todo This function and will remove
 */
if (!function_exists('wpt_admin_responsive_tab')) {
    function wpt_admin_responsive_tab($tab_array)
    {
        unset($tab_array['mobile']);
        $tab_array['responsive'] = __('Responsive <small>New</small>', 'woo-product-table');
        $tab_array['mobile'] = __('Mobile', 'woo-product-table'); // <span>will remvoed</span>
        return $tab_array;
    }
}
//add_filter( 'wpto_admin_tab_array', 'wpt_admin_responsive_tab' );

if (!function_exists('wpt_admin_responsive_tab_save')) {
    function wpt_admin_responsive_tab_save($save_tab_array)
    {
        $save_tab_array['responsive'] = 'responsive';
        return $save_tab_array;
    }
}
add_filter('wpto_save_tab_array', 'wpt_admin_responsive_tab_save');

if (!function_exists('wpt_admin_responsive_tab_file')) {
    function wpt_admin_responsive_tab_file()
    {
        /**
         * you have return your new file, if u want it on Responsive Tab
         */
        //return 'my_new_location_will_be_here';
    }
}

//add_filter( 'wpto_admin_tab_file_loc_responsive', 'wpt_admin_responsive_tab_file' );



if (!function_exists('wpt_column_style_for_all')) {

    /**
     * Used:
     * do_action( 'wpto_column_setting_form', $keyword, $column_settings, $columns_array, $updated_columns_array, $post, $additional_data );
     * 
     * @param type $keyword
     * @param type $column_settings
     * @param type $columns_array
     */
    function wpt_column_style_for_all($keyword, $_device_name, $column_settings, $columns_array, $updated_columns_array, $post, $additional_data)
    {
        switch( $keyword ){
            case 'check':
            case 'tick':
            case 'serial_number':
            case 'total':
            case 'product_id': return;

        }
        $style_property = isset($additional_data['css_property']) && is_array($additional_data['css_property']) ? $additional_data['css_property'] : array();
        $class_name = "style_str{$_device_name}_{$keyword}";

        $item_name_style_str = "column_settings{$_device_name}[$keyword][style_str]";
        $style_str = isset($column_settings[$keyword]['style_str']) ? $column_settings[$keyword]['style_str'] : false;

        $style_str_arr = explode(";", $style_str);
        $style_str_arr = array_filter($style_str_arr);
        $style = array();
        foreach ($style_str_arr as $each_style) {
            $each_style_property = explode(": ", $each_style);
            $str_str_key_01 = !empty($each_style_property[0]) ? $each_style_property[0] : ' ';
            $str_str_key_02 = !empty($each_style_property[1]) ? $each_style_property[1] : ' ';
            $style[$str_str_key_01] = $str_str_key_02;
        }

?>

        <div
            data-target_value_wrapper="<?php echo esc_attr($class_name); ?>"
            class=" <?php echo esc_attr(wpt_get_conditional_class()); ?> style_str_wrapper wpt-style-wrapper <?php echo esc_attr($class_name); ?> style-wrapper-<?php echo esc_attr($keyword); ?>">
            <input
                type="hidden"
                class="str_str_value_string"
                value="<?php echo esc_attr($style_str); ?>" name="<?php echo esc_attr($item_name_style_str); ?>">
            <h3 class="style-heading"><i class="wpt-brush"></i><?php echo esc_html('Style', 'woo-product-table'); ?></h3>
            <h3 class="other-feature-on-off"><i class="wpt-cog-alt"></i><?php echo esc_html('Others', 'woo-product-table'); ?></h3>
            <div class="wpt-style-body">
                <table class="ultraaddons-table <?php echo esc_attr($class_name); ?>_value_wrapper" style_str_value_wrapper>
                    <?php

                    foreach ($style_property as $style_key => $label) {
                        $value = isset($style[$style_key]) ? $style[$style_key] : false;
                    ?>

                        <tr class="each-style each-style-<?php echo esc_attr($style_key); ?>">
                            <th><label><?php echo esc_html($label); ?></label></th>
                            <td>
                                <input
                                    class="ua_input wpt-<?php echo esc_attr($style_key); ?> str_str_each_value"
                                    data-proerty_name="<?php echo esc_attr($style_key); ?>"
                                    value="<?php echo esc_attr($value); ?>"
                                    placeholder="<?php echo esc_attr($label); ?>">
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
                <a href="javascript:void(0)" class="wpt-reset-style"><?php echo esc_html('Reset Style', 'woo-product-table'); ?></a>
            </div>

            <?php if (!wpt_is_pro()) { ?>
                <div class="column_label_showing">
                    <label>Inside Item Label </label>
                    <input type="checkbox" class="" name="column_settings[check][inside_label]">
                    <p>To show Label of Item before Inside Item.</p>
                </div>
                <div class="auto_responsive_column_label_show">
                    <label for="column_settings[thumbnails][auto_responsive_column_label_show]">Hide column label for Mobile/Tablet</label>
                    <input type="checkbox" class="" id="column_settings[thumbnails][auto_responsive_column_label_show]" name="column_settings[thumbnails][auto_responsive_column_label_show]" checked="">
                    <p>Hide column label for Mobile/Tablet before each item. Importance: Only for Auto Responsive Mode.</p>
                </div>
                <div class="column_only_login_user">
                    <label>Only Login user</label>
                    <input type="checkbox" class="" name="column_settings[check][only_login_user]">
                    <a href="https://wooproducttable.com/docs/doc/advance-uses/show-column-only-for-login-user/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                    <p>To show Hide Column or as Item inside Column, Check it.</p>
                </div>
                <div class="column_only_login_user">
                    <label>Toggle Show Hide</label>
                    <input type="checkbox" class="" name="column_settings[check][toggle]">
                    <a href="https://wooproducttable.com/docs/doc/table-options/show-hide-inner-items-by-clicking/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                    <br><label>Toggle Text</label>
                    <input style="display: inline;" type="text" class="" name="column_settings[check][toggle_label]" value="">
                    <p>To show Hide Column or as Item inside Column, Check it.</p>
                </div>
            <?php } ?>
        </div>

    <?php
    }
}

add_action('wpto_column_setting_form', 'wpt_column_style_for_all', 11, 7);

if (!function_exists('wpt_convert_style_from_arr')) {
    function wpt_convert_style_from_arr($style_arr = false)
    {
        $style_string = '';
        if (!empty($style_arr) && is_array($style_arr)) {
            $style_arr = array_filter($style_arr);
            if (!is_array($style_arr)) {
                return '';
            }
            foreach ($style_arr as $key => $stl) {
                $style_string .= $key . ': ' . $stl . ';';
            }
        }

        return $style_string;
    }
}

if (!function_exists('wpt_data_manipulation_on_save')) {

    /**
     * Args Manipulation from Basic Tab
     * Used Filter:
     * $tab_data = apply_filters( 'wpto_tab_data_on_save', $tab_data, $tab, $post_id, $save_tab_array );
     * 
     * @param type $data
     * @return type
     */
    function wpt_data_manipulation_on_save($tab_data, $tab, $post_id, $save_tab_array)
    {

        if ('basics' == $tab && is_array($tab_data)) {

            /**
             * Query Relation for Taxonomy added
             * @version 2.8.3.5
             */
            $query_relation = ! isset($tab_data['query_relation']) ? 'IN' : $tab_data['query_relation'];
            $query_relation = $tab_data['query_relation'] ?? 'IN';

            $data = isset($tab_data['data']) ? $tab_data['data'] : false;
            $terms_string = 'terms';
            $terms = isset($data[$terms_string]) ? $data[$terms_string] : false;
            if (is_array($terms)) {
                foreach ($terms as $term_key => $term_ids) {
                    $term_key_IN = $term_key . '_' . $query_relation; //IN
                    $tab_data['args']['tax_query'][$term_key_IN] = array(
                        'taxonomy'      => $term_key,
                        'field'         => 'id',
                        'terms'         => $term_ids, //Array of Term's IDs
                        'operator'      => 'IN' //$query_relation,//
                    );
                }
            }
        }
        //        if( 'column_settings' == $tab && is_array( $tab_data ) ){
        //            foreach( $tab_data as $per_key => $per_data ){
        //                if( !empty( $per_key ) && is_array( $per_data ) ){
        //                    $tab_data[$per_key]['style_str'] = isset( $per_data['style'] ) && is_array( $per_data['style'] ) ? wpt_convert_style_from_arr( $per_data['style'] ) : '';
        //                }
        //            }
        //        }

        return $tab_data;
    }
}
add_filter('wpto_tab_data_on_save', 'wpt_data_manipulation_on_save', 10, 4);

if (! function_exists('wpt_add_tabs')) {
    /**
     * Help Screens Message added
     * Mainly this feature added by Mukul, but this comment added by Saiful
     * 
     * @since 3.0.0.0
     *
     * @return void
     */
    function wpt_add_tabs()
    {
        $screen = get_current_screen();
        $is_wpt_page = strpos($screen->id, 'wpt_product_table');

        if (! $screen || !(false !== $is_wpt_page)) {
            return;
        }

        $screen->add_help_tab(
            array(
                'id'      => 'wpt_support_tab',
                'title'   => __('Help &amp; Support', 'woo-product-table'),
                'content' =>
                '<h2>' . __('Help &amp; Support', 'woo-product-table') . '</h2>' .
                    '<p>' . sprintf(
                        /* translators: %s: Documentation URL */
                        __('Should you need help understanding, using, or extending Product Table for WooCommerce, <a href="%s">please read our documentation</a>. You will find all kinds of resources including snippets, tutorials and much more.', 'woo-product-table'),
                        'https://wooproducttable.com/documentation/?utm_source=helptab&utm_content=docs&utm_campaign=wptplugin'
                    ) . '</p>' .
                    '<p>' . sprintf(
                        /* translators: %s: Forum URL */
                        __('For further assistance with Product Table for WooCommerce, use the <a href="%1$s">community forum</a>. For help with premium support, <a href="%2$s">open a support request at CodeAstrology.com</a>.', 'woo-product-table'),
                        'https://wordpress.org/support/plugin/woo-product-table/',
                        'https://codeastrology.com/my-support/?utm_source=helptab&utm_content=tickets&utm_campaign=wptplugin'
                    ) . '</p>' .
                    '<p><a href="https://wordpress.org/support/plugin/woo-product-table/" class="button">' . __('Community forum', 'woo-product-table') . '</a> <a href="https://codeastrology.com/my-support/?utm_source=helptab&utm_content=tickets&utm_campaign=wptplugin" class="button">' . __('CodeAstrology.com support', 'woo-product-table') . '</a></p>',
            )
        );

        $screen->set_help_sidebar(
            '<p><strong>' . __('For more information:', 'woo-product-table') . '</strong></p>' .
                '<p><a href="https://wooproducttable.com/?utm_source=helptab&utm_content=about&utm_campaign=wptplugin" target="_blank">' . __('About Product Table', 'woo-product-table') . '</a></p>' .
                '<p><a href="https://wordpress.org/support/plugin/woo-product-table/" target="_blank">' . __('WordPress.org', 'woo-product-table') . '</a></p>' .
                '<p><a href="https://wooproducttable.com/pricing" target="_blank">' . __('Premium Plugin ', 'woo-product-table') . '</a></p>' .
                '<p><a href="https://github.com/codersaiful/woo-product-table/" target="_blank">' . __('Github project', 'woo-product-table') . '</a></p>' .
                '<p><a href="https://wordpress.org/themes/astha/" target="_blank">' . __('Official theme', 'woo-product-table') . '</a></p>' .
                '<p><a href="https://codecanyon.net/user/codeastrology/?utm_source=helptab&utm_content=wptotherplugins&utm_campaign=wptplugin" target="_blank">' . __('Other Premium Plugins', 'woo-product-table') . '</a></p>'
        );
    }
}
// add_action( 'current_screen', 'wpt_add_tabs', 50 );

function wpt_social_links()
{
    ?>
    <div class="codeastrogy-social-area-wrapper">
        <?php
        $img_folder = WPT_BASE_URL . 'assets/images/brand/social/';
        $codeastrology = [
            'ticket'   => ['url' => 'https://codeastrology.com/my-support/?utm=Plugin_Social', 'title' => 'Create Ticket'],
            'doc'   => ['url' => 'https://wooproducttable.com/documentation/?utm=Plugin_Social', 'title' => 'Online Doc'],
            'web'   => ['url' => 'https://codeastrology.com/downloads?utm=Plugin_Social', 'title' => 'CodeAstrology Plugins'],
            'wpt'   => ['url' => 'https://wooproducttable.com/?utm=Plugin_Social', 'title' => 'Woo Product Table'],
            'min-max'   => ['url' => 'https://codeastrology.com/min-max-quantity/?utm=Plugin_Social', 'title' => 'CodeAstrology Min Max Step'],
            'linkedin'   => ['url' => 'https://www.linkedin.com/company/codeastrology'],
            'youtube'   => ['url' => 'https://www.youtube.com/c/codeastrology'],
            'facebook'   => ['url' => 'https://www.facebook.com/codeAstrology'],
            'twitter'   => ['url' => 'https://www.twitter.com/codeAstrology'],
        ];
        foreach ($codeastrology as $key => $cLogy) {
            $image_name = $key . '.png';
            $image_file = $img_folder . $image_name;
            $url = $cLogy['url'] ?? '#';
            $title = $cLogy['title'] ?? false;
            $alt = ! empty($title) ? $title : $key;
            $title_available = ! empty($title) ? 'title-available' : '';

        ?>
            <a class="ca-social-link ca-social-<?php echo esc_attr($key); ?> ca-<?php echo esc_attr($title_available); ?>" href="<?php echo esc_url($url); ?>" target="_blank">
                <img src="<?php echo esc_url($image_file); ?>" alt="<?php echo esc_attr($alt); ?>">
                <span><?php echo esc_html($title); ?></span>
            </a>
        <?php


        }
        ?>

    </div>

<?php
}
function wpt_submit_issue_link()
{
?>
    <p class="wpt-issue-submit">
        <?php
        $content_of_mail = __('I have found an issue with your WooProductTable plugin. I will explain here with screenshot.Issues And Screenshots:', 'woo-product-table');
        ?>
        <b>ISSUE SUBMIT:</b> If you found any issues, please inform us.
        <a href="https://github.com/codersaiful/woo-product-table/issues/new" target="_blank">SUBMIT ISSUE</a> or
        <a href="mailto:support@codeastrology.com">support@codeastrology.com</a> or
        <a href="https://mail.google.com/mail/u/0/?view=cm&fs=1&su=<?php echo urlencode("Found issue on your Woo Product Table, see screenshot of issue"); ?>&body=<?php echo esc_attr($content_of_mail); ?>&ui=2&tf=1&to=codersaiful@gmail.com,contact@codeastrology.com" target="_blank">Gmail Me</a> or
        <a href="https://www.facebook.com/groups/wphelps" target="_blank">Facebook Group</a>
        <a href="https://codeastrology.com/my-support/?utm_source=plugin-backend&&utm_medium=Free+Version" target="_blank" class="wpt-create-ticket">Create Ticket</a>
    </p>
    <?php
}
if (! function_exists('wpt_doc_link')) {
    /**
     * This function will add helper doc
     * @since 3.3.6.1
     * @author Fazle Bari
     */
    function wpt_doc_link($url, $title = 'Helper doc')
    {
    ?>
        <a href="<?php echo esc_url( $url ) ?>" target="_blank" class="wpt-doc-lick"><?php echo esc_html( $title ); ?></a>
    <?php
    }
}
/**
 * To display help icon with title attribute.
 * It will show by default
 * ----------
 * Don't change for auto translate.
 * 
 * ----------
 * Specially for Translate
 * 
 *
 * @param boolean $msg
 * @return void
 */
function wpt_help_icon_render($msg = false, $extra_msg = false)
{
    $title = $msg;
    if (empty($msg)) {
        $title = __("Don't change for auto translate. Leave empty to get translated text.", 'woo-product-table');
    }
    $extra_msg_text = $extra_msg ? "\n" . __('Write with default or English language.', 'woo-product-table') : '';
    ?>
    <span class="wpt-help-icon" title="<?php echo esc_attr($title .  $extra_msg_text); ?>">?</span>
<?php
}

function wpt_get_free_templates()
{
    $templates_default = array(
        'none'              =>  __('Select None', 'woo-product-table'),
        'default'           =>  __('Default Style', 'woo-product-table'),
        'beautiful_blacky'  =>  __('Beautiful Blacky', 'woo-product-table'),
        'classic'           =>  __('Classic', 'woo-product-table'),
        'blue_border'       =>  __('Blue Border', 'woo-product-table'),
        'smart_border'      =>  __('Smart Border', 'woo-product-table'),
        'pink'              =>  __('Pink Style', 'woo-product-table'),
        'modern'            =>  __('Modern Style', 'woo-product-table'),
        'orange'            =>  __('Orange Style', 'woo-product-table'),
    );

    return $templates_default;
}
if (! function_exists('wpt_get_pro_templates')) {
    function wpt_get_pro_templates()
    {
        $pro_templates = array(
            'smart'         =>  __('Smart Thin', 'woo-product-table'),
            'green'         =>  __('Green Style', 'woo-product-table'),
            'blue'          =>  __('Blue Style', 'woo-product-table'),
            'dark'          =>  __('Dark Style', 'woo-product-table'),
            'smart_light'   =>  __('Smart Light', 'woo-product-table'),
            'custom'       =>  __('Customized Design', 'woo-product-table'),
        );
        return $pro_templates;
    }
}

function wpt_get_pro_verstion_translate_string()
{
    $string_array = array(
        __('Categories', 'woo-product-table'),
        __('Tags', 'woo-product-table'),
        __('Product Color', 'woo-product-table'),
        __('Product Size', 'woo-product-table'),
        __('Color', 'woo-product-table'),
        __('Size', 'woo-product-table'),
        __('Choose', 'woo-product-table'),
        __('All categories', 'woo-product-table'),
        __('All tags', 'woo-product-table'),
        __('All Color', 'woo-product-table'),
        __('All Size', 'woo-product-table'),
        __('sss', 'woo-product-table'),
    );

    return $string_array;
}

function wpt_donate_button($only_free = false)
{
    if ($only_free && defined('WPT_PRO_DEV_VERSION')) return;
?>
    <script async
        src="https://js.stripe.com/v3/buy-button.js">
    </script>

    <stripe-buy-button
        buy-button-id="buy_btn_1Mh4DgD2lfqrjhAGr5oI4uQw"
        publishable-key="pk_live_51Mg2ndD2lfqrjhAG866UldpkG61JxUK5boTxSFo5hahsnMqyWhAOrqNpCOuj67AaalPgamISySLbl4s4BCDWo7mH00vrDu4ba6">
    </stripe-buy-button>
<?php
}
