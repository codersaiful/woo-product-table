<?php
/***
 * WPT MODULE + ADMIN ACTION HOOK
 * WPT Module and In Admin
 */


if( !function_exists( 'wpt_admin_form_top' ) ){
    /**
     * Docs and Support Link to Our Form Top
     */
    function wpt_admin_form_top(){
        global $post;
        /**
         * @Hook Filter: wpt_admin_form_top_links
         * To Disable Top Links of Get pro, Documentation at the top of our Forms
         * @return Boolean True to displa link, false to hide links from the top of our Admin Post Edit form
         */
        $validation = apply_filters( 'wpt_admin_form_top_links', true, $post );
        if( $validation ){
        ?>
        <ul class="wpt_admin_form_links" style="margin: 0">
            <li><a class="wpt_get_pro_form_top_link" target="_blank" title="Awesome Pro features is Waiting for you!" href="https://wooproducttable.com/pricing/"><?php echo esc_html__( 'Get Pro', 'woo-product-table' ); ?></a></li>
            <li>
                <a class="Header-link " href="https://github.com/codersaiful/woo-product-table" target="_blank">
  <svg class="octicon octicon-mark-github v-align-middle" height="16" 
       viewBox="0 0 16 16" version="1.1" width="16" aria-hidden="true">
  <path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"></path>
  </svg>

            <?php echo esc_html__( 'GitHub Repo', 'woo-product-table' ); ?></a></li>
            <li><a target="_blank" href="https://demo.wooproducttable.com/?utm_source=Product+Table+EditPage&utm_medium=Free+Version"><?php echo esc_html__( 'Demo', 'woo-product-table' ); ?></a></li>
            <li><a target="_blank" href="https://github.com/codersaiful/woo-product-table/discussions"><?php echo esc_html__( 'Forum on Repo', 'woo-product-table' ); ?></a></li>
            <li><a target="_blank" href="https://wooproducttable.com/documentation/?utm_source=Product+Table+EditPage&utm_medium=Free+Version"><?php echo esc_html__( 'Documentation', 'woo-product-table' ); ?></a></li>
            <li><a target="_blank" href="https://codeastrology.com/my-support/?utm_source=Product+Table+EditPage&utm_medium=Free+Version"><?php echo esc_html__( 'Get Support', 'woo-product-table' ); ?></a></li>
            

        </ul>    
        <?php
        }
    }
}
add_action( 'wpto_form_top', 'wpt_admin_form_top');


if( !function_exists( 'wpt_ctrl_s_text_at_top' ) ){
    /**
     * CTRL + S link at the top of the Form
     */
    function wpt_ctrl_s_text_at_top(){
        $dev = '';
        if( defined( 'WPT_PRO_DEV_VERSION' ) ){
            $dev .= 'PRO ' . WPT_PRO_DEV_VERSION;
        }
        
        if( defined( 'WPT_DEV_VERSION' ) ){
            $dev .= ' FREE ' . WPT_DEV_VERSION;
        }
        $ori_ver = str_replace( array( '.',' ', 'RO', 'REE' ), '', $dev );
        ?>  
        <span class="wpt_devloper_version" title="<?php echo esc_html( 'Developer Version: ' . $dev ); ?>"><?php echo esc_html( $ori_ver ); ?></span>
        <p class="wpt_ctrl_s" title="To save Data, Just Click: [Ctrl + S]">Save: <span>Ctrl + S</span></p>
        <?php
    }
}
add_action( 'wpto_form_top', 'wpt_ctrl_s_text_at_top' );

if( !function_exists( 'wpt_configuration_page_head' ) ){
    function wpt_configuration_page_head(){
        $brand_logo = WPT_ASSETS_URL . 'images/brand/social/wpt.png';
        ?>
        <div class="fieldwrap ultraaddons-head wpt-config-header-area">
            <div class="ultraaddons-panel border-with-shadow">
                <h1 class="wp-heading-inline plugin_name plugin-name">
                    <img src="<?php echo esc_url( $brand_logo ); ?>" class="wpt-brand-logo">
                    Woo Product Table 
                    
                    <span class="plugin-version">v <?php echo WPT_Product_Table::getVersion(); ?></span>
                    <?php if(method_exists('WOO_Product_Table', 'getVersion')){ ?>
                        <span class="plugin-version" title="Pro Version">v <?php echo WOO_Product_Table::getVersion(); ?></span></h1>
                    <?php } ?>
                </h1>

            </div>
        </div>    
            
         <?php
    }
}
add_action( 'wpto_admin_configuration_head', 'wpt_configuration_page_head',10 );

if( !function_exists( 'wpt_configuration_page_version_data' ) ){
    
    /**
     * To add Version Data, I mean: Version Numbewr and Plugin name as Hidden Input
     * At the top of Configuration Page and Configuration Tab
     * 
     * @since 2.7 and 7.0.0
     */
    function wpt_configuration_page_version_data(){
        ?>
        <input name="data[plugin_version]" type="hidden" value="<?php echo WPT_Product_Table::getVersion(); ?>">
        <input name="data[plugin_name]" type="hidden" value="<?php echo WPT_Product_Table::getName(); ?>"> 
            
         <?php
    }
}
add_action( 'wpto_admin_configuration_form_version_data', 'wpt_configuration_page_version_data' );



if( !function_exists( 'wpt_configure_basic_part' ) ){
    
    function wpt_configure_basic_part( $settings,$current_config_value,$field_name ){
        $page = isset( $settings['page'] ) ? $settings['page'] : 'not_set_page'; //configuration_page
        $user_can_edit = wpt_user_can_edit() ? 'user_can_edit' : 'user_can_not_edit';

        $lang = apply_filters( 'wpml_current_language', NULL );
        $default_lang = apply_filters('wpml_default_language', NULL );
        
        if( $lang !== $default_lang && $page == 'configuration_page' ) return;

        // var_dump($page);
        ?>
        <div class="section ultraaddons-panel basic <?php echo esc_attr( $page ); ?>">
            <h3 class="with-background dark-background wpt-design-expand"><?php esc_html_e( 'Basic Settings', 'woo-product-table' );?><span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h3>
            <table class="ultraaddons-table">
                <tbody>
                    <tr class="table_disable_plugin_noti" style="display:none;">
                        <th>
                            <label class="wpt_label wpt_disable_plugin_noti" for="wpt_disable_plugin_noti"><?php esc_html_e( 'Plugin Recommendation', 'woo-product-table' );?></label>
                        </th>
                        <td>
                            <label class="switch">
                                <input  name="<?php echo esc_attr( $field_name ); ?>[disable_plugin_noti]" type="checkbox" id="wpt_disable_plugin_noti" <?php echo isset( $current_config_value['disable_plugin_noti'] ) ? 'checked="checked"' : ''; ?>>
                                <div class="slider round"><!--ADDED HTML -->
                                    <span class="on"><?php echo esc_html__( 'Enable', 'woo-product-table' ); ?></span><span class="off"><?php echo esc_html__( 'Disable', 'woo-product-table' ); ?></span><!--END-->
                                </div>
                            </label>
                            <p><?php echo esc_html( 'To enable or disable our plugin Notification for our Product Table', 'woo-product-table' ); ?></p>

                        </td>
                    </tr>


                    <tr>
                        <th><label class="wpt_label" for="wpt_table_custom_add_to_cart"><?php esc_html_e( 'Add to Cart Icon', 'woo-product-table' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[custom_add_to_cart]" id="wpt_table_custom_add_to_cart" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="add_cart_no_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_no_icon', $current_config_value ); ?>><?php esc_html_e( 'No Icon', 'woo-product-table' ); ?></option>
                                <option value="add_cart_only_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_only_icon', $current_config_value ); ?>><?php esc_html_e( 'Only Icon', 'woo-product-table' ); ?></option>
                                <option value="add_cart_left_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_left_icon', $current_config_value ); ?>><?php esc_html_e( 'Left Icon and Text', 'woo-product-table' ); ?></option>
                                <option value="add_cart_right_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_right_icon', $current_config_value ); ?>><?php esc_html_e( 'Text and Right Icon', 'woo-product-table' ); ?></option>
                            </select> <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/customize-add-to-card-icon/') ?>

                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?> ">
                        <th><label class="wpt_label" for="wpt_table_footer_cart"><?php esc_html_e( 'Floating Cart Option', 'woo-product-table' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[footer_cart]" id="wpt_table_footer_cart" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="always_hide" <?php wpt_selected( 'footer_cart', 'always_hide', $current_config_value ); ?>><?php esc_html_e( 'Always Hide', 'woo-product-table' ); ?></option>
                                <option value="hide_for_zerro" <?php wpt_selected( 'footer_cart', 'hide_for_zerro', $current_config_value ); ?>><?php esc_html_e( 'Hide for Zero', 'woo-product-table' ); ?></option>
                                <option value="always_show" <?php wpt_selected( 'footer_cart', 'always_show', $current_config_value ); ?>><?php esc_html_e( 'Always Show', 'woo-product-table' ); ?></option>
                                
                            </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/') ?>

                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>" > 
                        <th> <label for="wpt_table_footer_bg_color" class="wpt_label"><?php esc_html_e( 'Floating Cart BG Color', 'woo-product-table' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[footer_bg_color]" class="wpt_data_filed_atts wpt_color_picker" value="<?php echo esc_attr( $current_config_value['footer_bg_color'] ); ?>" id="wpt_table_footer_bg_colort" type="text" placeholder="<?php esc_attr_e( 'BG Color', 'woo-product-table' ); ?>">
                            <?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/') ?>
                        </td>
                    </tr>
                    <tr>
                        <th><label class="wpt_label" for="wpt_table_footer_possition"><?php esc_html_e( 'Floating Cart Position', 'woo-product-table' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[footer_possition]" id="wpt_table_footer_possition" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="bottom_right" <?php wpt_selected( 'footer_possition', 'bottom_right', $current_config_value ); ?>><?php esc_html_e( 'Bottom Right', 'woo-product-table' ); ?></option>
                                <option value="bottom_left" <?php wpt_selected( 'footer_possition', 'bottom_left', $current_config_value ); ?>><?php esc_html_e( 'Bottom Left', 'woo-product-table' ); ?></option>
                                <option value="top_right" <?php wpt_selected( 'footer_possition', 'top_right', $current_config_value ); ?>><?php esc_html_e( 'Top Right', 'woo-product-table' ); ?></option>
                                <option value="top_left" <?php wpt_selected( 'footer_possition', 'top_left', $current_config_value ); ?>><?php esc_html_e( 'Top Left', 'woo-product-table' ); ?></option>
                            </select>
                            <?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/') ?>
                        </td>
                    </tr>


                    <tr>
                        <th><label class="wpt_label" for="wpt_table_footer_cart_size"><?php echo sprintf(esc_html__( 'Floating Cart Size %s[Only Int]%s', 'woo-product-table' ), '<small>', '</small>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[footer_cart_size]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['footer_cart_size'] ); ?>" id="wpt_table_footer_cart_size" type="number" placeholder="<?php esc_attr_e( 'Default Size. eg: 70', 'woo-product-table' ); ?>" min="50" max="" pattern="[0-9]*" inputmode="numeric">
                            <?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/') ?>
                        </td>
                    </tr>
                    <tr>
                        <th><label class="wpt_label" for="wpt_table_sort_mini_filter"><?php esc_html_e( 'Mini Filter Sorting', 'woo-product-table' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[sort_mini_filter]" id="wpt_table_sort_mini_filter" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="0" <?php wpt_selected( 'sort_mini_filter', '0', $current_config_value ); ?>><?php esc_html_e( 'None', 'woo-product-table' ); ?></option>
                                <option value="ASC" <?php wpt_selected( 'sort_mini_filter', 'ASC', $current_config_value ); ?>><?php esc_html_e( 'Ascending', 'woo-product-table' ); ?></option>
                                <option value="DESC" <?php wpt_selected( 'sort_mini_filter', 'DESC', $current_config_value ); ?>><?php esc_html_e( 'Descending', 'woo-product-table' ); ?></option>
                            </select>
                            <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/mini-filter-search-box-taxonomy-sorting/') ?>
                        </td>
                    </tr>

                    <tr>
                        <th><label class="wpt_label" for="wpt_table_sort_searchbox_filter"><?php esc_html_e( 'Search Box Taxonomy Sorting', 'woo-product-table' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[sort_searchbox_filter]" id="wpt_table_sort_searchbox_filter" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="0" <?php wpt_selected( 'sort_searchbox_filter', '0', $current_config_value ); ?>><?php esc_html_e( 'Default Sorting', 'woo-product-table' ); ?></option>
                                <option value="ASC" <?php wpt_selected( 'sort_searchbox_filter', 'ASC', $current_config_value ); ?>><?php esc_html_e( 'Ascending', 'woo-product-table' ); ?></option>
                                <option value="DESC" <?php wpt_selected( 'sort_searchbox_filter', 'DESC', $current_config_value ); ?>><?php esc_html_e( 'Descending', 'woo-product-table' ); ?></option>
                            </select> <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/mini-filter-search-box-taxonomy-sorting/') ?>
                            <p class="warning">
                                <b>Tips:</b>
                                <span>If set Default Sorting, Taxonomy (Category/Tag) sorting will be like Default Taxonomy list.</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th><label class="wpt_label" for="wpt_table_thumbs_image_size"><?php echo sprintf(esc_html__( 'Thumbs Image Size', 'woo-product-table' ), '<small>', '</small>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[thumbs_image_size]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['thumbs_image_size'] ); ?>" id="wpt_table_thumbs_image_size" type="text" placeholder="<?php esc_attr_e( 'Thumbnail size. eg: 56', 'woo-product-table' ); ?>" min="16" max="" pattern="[0-9]*" inputmode="numeric">
                            <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/change-thumbnail-image-size/') ?>
                            <p><?php esc_html_e( 'You can use number like 150 or use as text version like full, medium, large', 'woo-product-table' ); ?></p>
                        </td>
                    </tr>

                    <tr> 
                        <th><label class="wpt_label" for="wpt_table_popup_notice"><?php esc_html_e( 'Popup Notice', 'woo-product-table' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[popup_notice]" id="wpt_table_popup_notice" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="1" <?php wpt_selected( 'popup_notice', '1', $current_config_value ); ?>><?php esc_html_e( 'Show', 'woo-product-table' ); ?></option>
                                <option value="0" <?php wpt_selected( 'popup_notice', '0', $current_config_value ); ?>><?php esc_html_e( 'Hide', 'woo-product-table' ); ?></option>
                            </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/disable-enable-add-to-cart-popup-notice/') ?>
                        </td>
                    </tr>
                    <tr> 
                        <th>  <label class="wpt_label" for="wpt_table_product_link_target"><?php esc_html_e( 'Product Link Open Type', 'woo-product-table' ); ?></label>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[product_link_target]" id="wpt_table_product_link_target" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="_blank" <?php wpt_selected( 'product_link_target', '_blank', $current_config_value ); ?>><?php esc_html_e( 'New Tab', 'woo-product-table' ); ?></option>
                                <option value="_self" <?php wpt_selected( 'product_link_target', '_self', $current_config_value ); ?>><?php esc_html_e( 'Self Tab', 'woo-product-table' ); ?></option>
                            </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/show-product-in-new-same-tab/') ?>
                        </td>
                    </tr>
                    
                    <tr> 
                        <th> <label class="wpt_label" for="wpt_table_product_direct_checkout"><?php esc_html_e( 'Quick Buy', 'woo-product-table' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[product_direct_checkout]" id="wpt_table_product_direct_checkout" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="no" <?php wpt_selected( 'product_direct_checkout', 'no', $current_config_value ); ?>><?php esc_html_e( 'Disable', 'woo-product-table' ); ?></option>
                                <option 
                                    <?php 
                                    echo wpt_user_can_edit() ? '' : 'disabled'; 
                                    $wpt_cart_page_redirect = wpt_user_can_edit() ? '' : esc_html__( ' (Pro)' );
                                    ?>
                                    value="cart" <?php wpt_selected( 'product_direct_checkout', 'cart', $current_config_value ); ?>><?php echo esc_html__( 'Cart Page', 'woo-product-table' ) . $wpt_cart_page_redirect; ?></option>
                                <option value="yes" <?php wpt_selected( 'product_direct_checkout', 'yes', $current_config_value ); ?>><?php esc_html_e( 'Checkout Page', 'woo-product-table' ); ?></option>
                            </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/redirect-checkout-page-after-add-to-cart/') ?>
                            <p><?php esc_html_e( 'Enable Quick Buy Button [Direct Checkout Page for each product]. Direct going to Checkout Page just after Added to cart for each product', 'woo-product-table' ); ?></p>
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?> "> 
                        <th><label class="wpt_label" for="wpt_table_all_selected_direct_checkout"><?php esc_html_e( 'Bundle Quick Buy ', 'woo-product-table' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[all_selected_direct_checkout]" id="wpt_table_all_selected_direct_checkout" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="no" <?php wpt_selected( 'all_selected_direct_checkout', 'no', $current_config_value ); ?>><?php esc_html_e( 'Disable', 'woo-product-table' ); ?></option>
                                <option value="cart" <?php wpt_selected( 'all_selected_direct_checkout', 'cart', $current_config_value ); ?>><?php esc_html_e( 'Cart Page', 'woo-product-table' ); ?></option>
                                <option value="yes" <?php wpt_selected( 'all_selected_direct_checkout', 'yes', $current_config_value ); ?>><?php esc_html_e( 'Checkout Page', 'woo-product-table' ); ?></option>
                            </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/redirect-checkout-page-after-add-to-cart/') ?>
                            <p>Direct Checkout Page[for Add to cart Selected]</p>
                        </td>
                    </tr>
                    
                    <tr> 
                        <th><label class="wpt_label" for="wpt_table_disable_cat_tag_link"><?php echo sprintf(esc_html__( '%sCategories, Tags%s Link', 'woo-product-table' ), '<strong>', '</strong>' ); ?></label> </th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[disable_cat_tag_link]" id="wpt_table_disable_cat_tag_link" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="1" <?php wpt_selected( 'disable_cat_tag_link', '1', $current_config_value ); ?>><?php esc_html_e( 'Disable', 'woo-product-table' ); ?></option>
                                <option value="0" <?php wpt_selected( 'disable_cat_tag_link', '0', $current_config_value ); ?>><?php esc_html_e( 'Enable', 'woo-product-table' ); ?></option>
                            </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/disable-categories-tag-link/') ?>
                        </td>
                    </tr>

                    <tr> 
                        <th> <label class="wpt_label" for="wpt_table_instant_search_filter"><?php esc_html_e( 'Instance Search Filter', 'woo-product-table' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[instant_search_filter]" id="wpt_table_instant_search_filter" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="1" <?php wpt_selected( 'instant_search_filter', '1', $current_config_value ); ?>><?php esc_html_e( 'Show', 'woo-product-table' ); ?></option>
                                <option value="0" <?php wpt_selected( 'instant_search_filter', '0', $current_config_value ); ?>><?php esc_html_e( 'Hide', 'woo-product-table' ); ?></option>
                            </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/use-instant-search-filter/') ?>
                            <p class="warning"><?php echo esc_html__( 'Only for viewable products of current table.', 'woo-product-table' ) ?></p>
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>" > 
                        <th> <label class="wpt_label" for="wpt_table_query_by_url"><?php esc_html_e( 'Query by URL', 'woo-product-table' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[query_by_url]" id="wpt_table_instant_search_filter" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="0" <?php wpt_selected( 'query_by_url', '0', $current_config_value ); ?>><?php esc_html_e( 'Off', 'woo-product-table' ); ?></option>
                                <option value="1" <?php wpt_selected( 'query_by_url', '1', $current_config_value ); ?>><?php esc_html_e( 'On', 'woo-product-table' ); ?></option>
                            </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/how-to-show-hide-query-url/') ?>
                        </td>
                    </tr>

                    <tr>
                        <th><label class="wpt_label" for="wpt_table_product_count"><?php esc_html_e( 'Item/Products Count system [New]', 'woo-product-table' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[item_count]" id="wpt_table_product_count" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="" <?php wpt_selected( 'item_count', '' ); ?>><?php esc_html_e( 'Products Wise', 'woo-product-table' ); ?></option>
                                <option value="all" <?php wpt_selected( 'item_count', 'all' ); ?>><?php esc_html_e( 'All Items', 'woo-product-table' ); ?></option>
                            </select>

                        </td>
                    </tr>

                </tbody>
            </table><?php do_action( 'wpto_admin_configuration_panel_bottom',$settings,$current_config_value ); ?>
            <?php do_action( 'wpt_offer_here' );  ?>
        </div>
         <?php
         
    }
}
add_action( 'wpto_admin_configuration_form', 'wpt_configure_basic_part', 5, 3 );

if( !function_exists( 'wpt_configure_label_part' ) ){
    
    function wpt_configure_label_part($settings, $current_config_value,$field_name){
        $page = isset( $settings['page'] ) ? $settings['page'] : 'not_set_page';
        $user_can_edit = wpt_user_can_edit() ? 'user_can_edit' : 'user_can_not_edit';
        
        ?>
        <div class="section ultraaddons-panel label <?php echo esc_attr( $page ); ?>">
            <h3 class="with-background dark-background wpt-design-expand"><?php esc_html_e( 'Label Text', 'woo-product-table' );?><span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h3>
            <table class="ultraaddons-table">
                <tbody>
                    <tr> 
                        <th> <label for="wpt_table_product_not_founded" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Products not found!]%s - Message Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[product_not_founded]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['product_not_founded'] ); ?>" id="wpt_table_product_not_founded" type="text" placeholder="<?php esc_attr_e( 'No products found in this query.', 'woo-product-table' ); ?>">
                        </td>
                    </tr>

                    <tr> 
                        <th> <label for="wpt_table_load_more_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Load More]%s - Button Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[load_more_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['load_more_text'] ); ?>" id="wpt_table_load_more_text" type="text" placeholder="<?php esc_attr_e( 'Load More text write here', 'woo-product-table' ); ?>">
                            <p><?php echo esc_html__( 'Not for Archive page.', 'woo-product-table' ); ?></p>
                        </td>
                    </tr>

                    <tr> 
                        <th>   <label for="wpt_table_search_button_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Search]%s - Button Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_button_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_button_text'] ); ?>" id="wpt_table_search_button_textt" type="text" placeholder="<?php esc_attr_e( 'Search text write here', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th><label for="wpt_table_search_keyword_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Search Keyword Title]%s - Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_keyword_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_keyword_text'] ); ?>" id="wpt_table_search_keyword_text" type="text" placeholder="<?php esc_attr_e( 'Search Keyword', 'woo-product-table' ); ?>">
                        </td>
                    </tr>

                    <tr> 
                        <th><label for="wpt_table_loading_more_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Loading..]%s - Button Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[loading_more_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['loading_more_text'] ); ?>" id="wpt_table_loading_more_text" type="text" placeholder="<?php esc_attr_e( 'Loading.. text write here', 'woo-product-table' ); ?>"> 
                        </td>
                    </tr>
                    <tr> 
                        <th> <label for="wpt_table_instant_search_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Instance Search]%s - Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[instant_search_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['instant_search_text'] ); ?>" id="wpt_table_instant_search_text" type="text" placeholder="<?php esc_attr_e( 'attr', 'woo-product-table' ); ?>"> 
                        </td>
                    </tr>
                    
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>"> 
                        <th> <label for="wpt_table_empty_cart_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Empty Cart]%s - Text of Empty Cart', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[empty_cart_text]" class="wpt_data_filed_atts ua_input" value="<?php echo isset( $current_config_value['empty_cart_text'] ) ? esc_attr( $current_config_value['empty_cart_text'] ) : ''; ?>" id="wpt_table_filter_text" type="text" placeholder="<?php esc_attr_e( 'eg: Empty Cart', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    
                    <tr> 
                        <th> <label for="wpt_table_filter_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Filter]%s - Text of Filter', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[filter_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['filter_text'] ); ?>" id="wpt_table_filter_text" type="text" placeholder="<?php esc_attr_e( 'eg: Filter', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    
                    <tr> 
                        <th><label for="wpt_table_filter_reset_button" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Reset]%s - Button Text of Filter', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[filter_reset_button]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['filter_reset_button'] ); ?>" id="wpt_table_filter_reset_button" type="text" placeholder="<?php esc_attr_e( 'eg: Reset', 'woo-product-table' ); ?>">
                        </td>
                    </tr>

                    <tr> 
                        <th><label for="wpt_table_item" class="wpt_label"><?php esc_html_e( 'Item [for Singular]', 'woo-product-table' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[item]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['item'] ); ?>" id="wpt_table_item" type="text" placeholder="<?php esc_attr_e( 'Item | for All selected Button', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th> <label for="wpt_table_items" class="wpt_label"><?php esc_html_e( 'Item [for Plural]', 'woo-product-table' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[items]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['items'] ); ?>" id="wpt_table_items" type="text" placeholder="<?php esc_attr_e( 'Item | for All selected Button', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    
                    <tr> 
                        <th> <label for="wpt_table_item_add_selct_all" class="wpt_label"><?php esc_html_e( 'Add to Cart all selected [Added] Text', 'woo-product-table' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[add2cart_all_added_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['add2cart_all_added_text'] ); ?>" id="wpt_table_item_add_selct_all" type="text" placeholder="<?php esc_attr_e( 'Added text for [Add to cart Selected]', 'woo-product-table' ); ?>">
                        </td>

                    </tr>

                    <tr> 
                        <th><label for="wpt_table_search_box_title" class="wpt_label"><?php esc_html_e( 'Search Box title', 'woo-product-table' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_title]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_box_title'] ); ?>" id="wpt_table_search_box_title" type="text" placeholder="<?php esc_attr_e( 'Search Box title', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th><label for="wpt_table_search_box_searchkeyword" class="wpt_label"><?php esc_html_e( 'Search Keyword Placeholder', 'woo-product-table' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_searchkeyword]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_box_searchkeyword'] ); ?>" id="wpt_table_search_box_searchkeyword" type="text" placeholder="<?php esc_attr_e( 'Search Keyword text', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    <?php if( defined( 'WPT_PRO_DEV_VERSION' ) ){ ?>
                    <tr>
                        <th><label for="wpt_table_search_box_sale" class="wpt_label"><?php esc_html_e( 'SearchBox Sale text', 'woo-product-table' ); ?></label></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_sale]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_box_sale'] ?? '' ); ?>" id="wpt_table_search_box_sale" type="text" placeholder="<?php esc_attr_e( 'Sale', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th><label for="wpt_table_search_box_orderby" class="wpt_label"><?php esc_html_e( 'SearchBox Order By text', 'woo-product-table' ); ?></label></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_orderby]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_box_orderby'] ); ?>" id="wpt_table_search_box_orderby" type="text" placeholder="<?php esc_attr_e( 'Order By text', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_search_eee" class="wpt_label"><?php esc_html_e( 'SearchBox Order text', 'woo-product-table' ); ?></label></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_order]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_box_order'] ); ?>" id="wpt_table_search_eee" type="text" placeholder="<?php esc_attr_e( 'Order text', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_search_eee" class="wpt_label"><?php esc_html_e( 'Search Dropdown Placeholder text', 'woo-product-table' ); ?></label></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_order_placeholder]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_order_placeholder'] ?? '' ); ?>" id="wpt_table_search_eee" type="text" placeholder="<?php esc_attr_e( 'Select Innet Items', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                </tbody>
            </table><?php do_action( 'wpto_admin_configuration_panel_bottom',$settings,$current_config_value ); ?>
        </div>
         <?php
         
    }
}
add_action( 'wpto_admin_configuration_form', 'wpt_configure_label_part',10, 3 );


if( !function_exists( 'wpt_configure_external_part' ) ){
    
    function wpt_configure_external_part( $settings,$current_config_value,$field_name ){
        $page = isset( $settings['page'] ) ? $settings['page'] : 'not_set_page';
        
        ?>
        <div class="section ultraaddons-panel label <?php echo esc_attr( $page ); ?>">
            <h3 class="with-background dark-background wpt-design-expand"><?php echo sprintf( esc_html__( 'External Plugin\'s %s[YITH]%s ', 'woo-product-table' ),'<span style="color: orange; font-size: 18px;">', '</span>' );?><span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h3>
            <table class="ultraaddons-table external_plugin">
                <tbody>
                    <tr> 
                        <th><label for="wpt_table_quick_view_btn_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Quick View]%s - Button Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[quick_view_btn_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['quick_view_btn_text'] ); ?>" id="wpt_table_quick_view_btn_text" type="text" placeholder="<?php esc_attr_e( 'eg: Quick View', 'woo-product-table' ); ?>">
                            <p style="color: #005082;padding: 0;margin: 0;"><?php echo sprintf(esc_html__( 'Only for %s YITH WooCommerce Quick View%s Plugin', 'woo-product-table' ), '<a target="_blank" href="https://wordpress.org/plugins/yith-woocommerce-quick-view/">', '</a>' ); ?></p>
                        </td>
                    </tr>

                    <tr> 
                        <th> <label for="wpt_table_yith_browse_list" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Browse Quote list]%s - text ', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_browse_list]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['yith_browse_list'] ); ?>" id="wpt_table_yith_browse_list" type="text" placeholder="<?php esc_attr_e( 'Browse the list - text write here', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th><label for="wpt_table_yith_add_to_quote_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Add to Quote]%s - button text', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_add_to_quote_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['yith_add_to_quote_text'] ); ?>" id="wpt_table_yith_add_to_quote_text" type="text" placeholder="<?php esc_attr_e( 'Add to Quote text write here', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th> <label for="wpt_table_yith_add_to_quote_adding" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Quote Adding]%s - text', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_add_to_quote_adding]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['yith_add_to_quote_adding'] ); ?>" id="wpt_table_yith_add_to_quote_adding" type="text" placeholder="<?php esc_attr_e( 'Adding text write here', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th> <label for="wpt_table_yith_add_to_quote_added" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Quote Added]%s - text ', 'woo-product-table' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_add_to_quote_added]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['yith_add_to_quote_added'] ); ?>" id="wpt_table_yith_add_to_quote_added" type="text" placeholder="<?php esc_attr_e( 'Quote Added text write here', 'woo-product-table' ); ?>">
                        </td>
                    </tr>
                </tbody>
            </table><?php do_action( 'wpto_admin_configuration_panel_bottom',$settings,$current_config_value ); ?>
        </div>
         <?php
         
    }
}
add_action( 'wpto_admin_configuration_form', 'wpt_configure_external_part',15, 3 );


if( !function_exists( 'wpt_configure_default_content_part' ) ){
    
    function wpt_configure_default_content_part( $settings,$current_config_value,$field_name ){
        $page = isset( $settings['page'] ) ? $settings['page'] : 'not_set_page';
        
        // label <?php echo esc_attr( $page ); "
        ?>
        <div class="section ultraaddons-panel default_content <?php echo esc_attr( $page );?>">
            <h3 class="with-background dark-background wpt-design-expand"><?php echo sprintf( esc_html__( 'Table\'s Default Content %sSince 3.3%s', 'woo-product-table' ), '<small style="color: orange; font-size: 12px;">', '</small>' );?><span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h3>
            <table class="ultraaddons-table">
                <tbody>
                    <tr>
                        <th><label for="wpt_table_table_in_stock" class="wpt_label"><?php esc_html_e( '[In Stock] for Table Column', 'woo-product-table' );?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[table_in_stock]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['table_in_stock'] ); ?>" id="wpt_table_table_in_stock" type="text" placeholder="<?php esc_attr_e( 'In Stock', 'woo-product-table' );?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_table_out_of_stock" class="wpt_label"><?php esc_html_e( '[Out of Stock] for Table Column', 'woo-product-table' );?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[table_out_of_stock]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['table_out_of_stock'] ); ?>" id="wpt_table_table_out_of_stock" type="text" placeholder="<?php esc_attr_e( 'Out of Stock', 'woo-product-table' );?>">
                        </td>
                    </tr>

                    <tr>
                        <th><label for="wpt_table_table_on_back_order" class="wpt_label"><?php esc_html_e( '[On Back Order] for Table Column', 'woo-product-table' );?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[table_on_back_order]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['table_on_back_order'] ); ?>" id="wpt_table_table_on_back_order" type="text" placeholder="<?php esc_attr_e( 'On Back Order', 'woo-product-table' );?>">
                        </td>
                    </tr>

                </tbody>
            </table><?php do_action( 'wpto_admin_configuration_panel_bottom',$settings,$current_config_value ); ?>
        </div>
         <?php
         
    }
}
/**
 * Stock Message or BackOrder Message or All about stock will manage from WooCommerce
 */
//add_action( 'wpto_admin_configuration_form', 'wpt_configure_default_content_part',20, 3 );


if( !function_exists( 'wpt_configure_all_message_part' ) ){
    
    function wpt_configure_all_message_part( $settings,$current_config_value,$field_name ){
        $page = isset( $settings['page'] ) ? $settings['page'] : 'not_set_page';
        $user_can_edit = wpt_user_can_edit() ? 'user_can_edit' : 'user_can_not_edit';

        // label <?php echo esc_attr( $page ); "
        ?>
        <div class="section ultraaddons-panel all_message <?php echo esc_attr( $page ); ?>">
            <h3 class="with-background dark-background wpt-design-expand"><?php esc_html_e( 'All Messages', 'woo-product-table' );?><span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h3>
            <table class="ultraaddons-table wpt_all_messages">
                <tbody>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                        <th><label for="wpt_table_right_combination_message" class="wpt_label"><?php esc_html_e( 'Variations [Not available] Message', 'woo-product-table' );?></label></th>
                        <td> 
                            <input name="<?php echo esc_attr( $field_name ); ?>[right_combination_message]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['right_combination_message'] ); ?>" id="wpt_table_right_combination_message" type="text" placeholder="<?php esc_attr_e( 'Not Available', 'woo-product-table' );?>">
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                        <th><label for="wpt_table_right_combination_message_alt" class="wpt_label"><?php esc_html_e( '[Product variations is not set Properly. May be: price is not inputted. may be: Out of Stock.] Message', 'woo-product-table' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[right_combination_message_alt]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['right_combination_message_alt'] ); ?>" id="wpt_table_right_combination_message_alt" type="text" placeholder="<?php esc_attr_e( 'Product variations is not set Properly. May be: price is not inputted. may be: Out of Stock.', 'woo-product-table' );?>">
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                        <th><label for="wpt_table_select_all_items_message" class="wpt_label"><?php esc_html_e( '[Please select all items.] Message', 'woo-product-table' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[select_all_items_message]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['select_all_items_message'] ); ?>" id="wpt_table_select_all_items_message" type="text" placeholder="<?php esc_attr_e( 'Please select all items.', 'woo-product-table' );?>">
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                        <th><label for="wpt_table_please_choose_items" class="wpt_label"><?php esc_html_e( '[Please Choose items] Alert!', 'woo-product-table' );?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[please_choose_items]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['please_choose_items'] ); ?>" id="wpt_table_please_choose_items" type="text" placeholder="<?php esc_attr_e( 'Please select all items.', 'woo-product-table' );?>">
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                        <th><label for="wpt_table_out_of_stock_message" class="wpt_label"><?php esc_html_e( '[Out of Stock] Message', 'woo-product-table' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[out_of_stock_message]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['out_of_stock_message'] ); ?>" id="wpt_table_out_of_stock_message" type="text" placeholder="<?php esc_attr_e( 'Out of Stock', 'woo-product-table' );?>">
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                        <th><label for="wpt_table_no_more_query_message" class="wpt_label"><?php esc_html_e( '[There is no more products based on current Query.] Message', 'woo-product-table' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[no_more_query_message]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['no_more_query_message'] ); ?>" id="wpt_table_no_more_query_message" type="text" placeholder="<?php esc_attr_e( 'There is no more products based on current Query.', 'woo-product-table' );?>">
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                        <th><label for="wpt_table_out_adding_progress" class="wpt_label"><?php esc_html_e( '[ Adding in Progress ] Message', 'woo-product-table' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[adding_in_progress]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['adding_in_progress'] ); ?>" id="wpt_table_out_adding_progress" type="text" placeholder="<?php esc_attr_e( 'Adding in Progress', 'woo-product-table' );?>">
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                        <th><label for="wpt_table_no_right_comb" class="wpt_label"><?php esc_html_e( '[ No Right Combination ] Message', 'woo-product-table' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[no_right_combination]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['no_right_combination'] ); ?>" id="wpt_table_no_right_comb" type="text" placeholder="<?php esc_attr_e( 'No Right Combination', 'woo-product-table' );?>">
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                        <th><label for="wpt_table_sorry_plz_right_combination" class="wpt_label"><?php esc_html_e( '[ Sorry, Please choose right combination. ] Message', 'woo-product-table' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[sorry_plz_right_combination]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['sorry_plz_right_combination'] ); ?>" id="wpt_table_sorry_plz_right_combination" type="text" placeholder="<?php esc_attr_e( 'Sorry, Please choose right combination.', 'woo-product-table' );?>">
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                        <th><label for="wpt_table_sorry_out_stock" class="wpt_label"><?php esc_html_e( '[ Sorry! Out of Stock! ] Message', 'woo-product-table' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[sorry_out_of_stock]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['sorry_out_of_stock'] ); ?>" id="wpt_table_sorry_out_stock" type="text" placeholder="<?php esc_attr_e( 'Sorry! Out of Stock!', 'woo-product-table' );?>">
                        </td>
                    </tr>
                    <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                        <th><label for="wpt_table_type_your_message" class="wpt_label"><?php esc_html_e( '[Type your Message.] Message', 'woo-product-table' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[type_your_message]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['type_your_message'] ); ?>" id="wpt_table_type_your_message" type="text" placeholder="<?php esc_attr_e( 'Type your Message.', 'woo-product-table' );?>">
                        </td>
                    </tr>
                </tbody>
            </table><?php do_action( 'wpto_admin_configuration_panel_bottom',$settings,$current_config_value ); ?>
        </div>
         <?php
         
    }
}
add_action( 'wpto_admin_configuration_form', 'wpt_configure_all_message_part',25, 3 );


if( !function_exists( 'wpt_configure_all_part_save_btn' ) ){
    
    function wpt_configure_all_part_save_btn($settings){
        $page = isset( $settings['page'] ) ? $settings['page'] : 'not_set_page';
        if( $page == 'configuration_page' ){
        ?>
        <div class="ultraaddons-button-wrapper">
            <button name="configure_submit" class="button-primary primary button"><?php echo esc_html__( 'Save All', 'woo-product-table' ); ?></button>
        </div>
         <?php
        }
    }
}
add_action( 'wpto_admin_configuration_panel_bottom', 'wpt_configure_all_part_save_btn' );


if( !function_exists( 'wpt_profeatures_message_box' ) ){
    
    function wpt_profeatures_message_box( $value ){
        $img_url = WPT_BASE_URL . 'assets/images/pro-features/';
        ?>
        <?php do_action( 'wpt_premium_image_top' ); ?>
        <div class="wpt-pro-only-featues <?php echo esc_attr( $value ); ?>">
            
            <img src="<?php echo esc_attr( $img_url . $value . '.png' ); ?>">
        </div>
        <?php do_action( 'wpt_premium_image_bottom' ); ?>
         <?php
    }
}
add_action( 'wpo_pro_feature_message', 'wpt_profeatures_message_box' );

/**
 * This will add a new input box inside short description column
 * we can add description limit 
 */
if( !function_exists( 'wpt_extra_field_for_disc_limit' ) ){
    
    function wpt_extra_field_for_disc_limit( $_device_name, $column_settings ){

        $short_description = isset( $column_settings['short_description'] ) ? $column_settings['short_description'] : false;
        $short_description_length = isset( $short_description['short_description_length'] ) ? $short_description['short_description_length'] : '';

          ?>
              <label><?php echo esc_html__( 'Description Length :', 'woo-product-table' ); ?></label>
              <input type="text" class="ua_input" name="column_settings<?php echo esc_attr( $_device_name ); ?>[short_description][short_description_length]" value="<?php echo esc_attr( $short_description_length ); ?>">
              
          <?php
  
    }
    
 }
 add_action( 'wpto_column_setting_form_inside_short_description', 'wpt_extra_field_for_disc_limit', 10, 2 );

 if( !function_exists( 'wpt_tawkto_code_header' ) ){
    /**
     * set class for Admin Body tag
     * 
     * @param type $classes
     * @return String
     */
    function wpt_tawkto_code_header( $class_string ){
        global $current_screen;
        $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
        if( strpos( $s_id, 'wpt') !== false ){
        ?>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/628f5d4f7b967b1179915ad7/1g4009033';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->      
        <?php
        }
        
    }
}
add_filter( 'admin_head', 'wpt_tawkto_code_header', 999 );

/**
 * "Table Column Sorting" option was in pro version, we move that into free version
 * @since 3.2.5.4
 * @author Fazle Bari 
 */
if( !function_exists( 'wpto_admin_configuration_form_top_free' ) ){
    function wpto_admin_configuration_form_top_free($settings,$current_config_value){
        if( !isset( $settings['page'] ) || isset( $settings['page'] ) && $settings['page'] != 'configuration_page' ){
            return;
        }
        
        ?>
    <table class="wpt-my-table universal-setting">
        <tbody>
        <tr class="divider-row">
            <td>
                <div class="wqpmb-form-control">
                    <div class="form-label col-lg-6">
                        <h4 class="section-divider-title">Sort and Footer Cart</h4>
                    </div>
                    <div class="form-field col-lg-6">
                        
                    </div>
                </div>
            </td>
            <td>
                <div class="wqpmb-form-info">
                    
                </div> 
            </td>
        </tr>
        <tr>
            <td>
                <div class="wpt-form-control">
                    <div class="form-label col-lg-6">
                        <label class="wpt_label wpt_column_sorting_on_off" for="wpt_column_sorting_on_off"><?php esc_html_e( 'Table Column Sorting', 'woo-product-table' );?></label>
                    </div>
                    <div class="form-field col-lg-6">
                        <p><?php echo esc_html( 'Column sorting for visible product Column.', 'woo-product-table' ); ?></p>
                        <p class="warning">
                            <b>Tips:</b>
                            <span>If you want to sort any column like number where text like: 1st,2nd,3rd,4th. To this situation, add a custom tag className <code>text_with_number</code> for column. <a href="https://wooproducttable.com/doc/advance-uses/sort-table-column/" target="_blank">Helper doc</a> </span>
                        </p>
                    </div>
                </div>
            </td>
            <td>
                <div class="wpt-form-info">
                    
                </div> 
            </td>
        </tr>
        <tr>
            <td>
                <div class="wpt-form-control">
                    <div class="form-label col-lg-6">
                        <label class="wpt_label wpt_footer_cart_on_of" for="wpt_footer_cart_on_of"><?php esc_html_e( 'Footer Cart', 'woo-product-table' );?></label>
                    </div>
                    <div class="form-field col-lg-6">
                        <label class="switch reverse">
                            <input name="data[footer_cart_on_of]" type="checkbox" id="wpt_footer_cart_on_of" <?php echo isset( $current_config_value['footer_cart_on_of'] ) ? 'checked="checked"' : ''; ?>>
                            <div class="slider round"><!--ADDED HTML -->
                                <span class="on">Show</span><span class="off">Hide</span><!--END-->
                            </div>
                        </label>
                    </div>
                </div>
            </td>
            <td>
                <div class="wpt-form-info">
                    <p><?php echo esc_html( 'Turn on or off footer cart', 'woo-product-table' ); ?></p>
                </div> 
            </td>
        </tr>

        <tr id="wpt_footer_cart_template">
            <td>
                <div class="wpt-form-control">
                    <div class="form-label col-lg-6">
                        <label class="wpt_label wpt_footer_template " for="wpt_table_footer_cart_template"><?php esc_html_e( 'Footer Cart Template', 'woo-product-table' );?></label>
                    </div>
                    <div class="form-field col-lg-6">
                        <select name="data[footer_cart_template]" class="wpt_fullwidth ua_input wpt_table_footer_cart_template">
                            <option value="none">Default Template</option>
                            <?php 
                                $footer_cart_templates = [1,2,3,4,5,6,7,7,9,10,11,12,13,14,15,16,17,18,19,20,21,22];
                                foreach($footer_cart_templates as $template){
                                    $selected = isset( $current_config_value['footer_cart_template'] ) && $current_config_value['footer_cart_template'] == $template? 'selected' : '';
                                    echo '<option value="'. $template .'" ' . $selected . '>'."Template No " . $template . '</option>'; 
                                } 
                            ?>
                        </select>
                    </div>
                </div>
            </td>
            <td>
                <div class="wpt-form-info">
                    <p><?php echo esc_html__( 'Select a template to change footer cart design', 'woo-product-table' ); ?></p>
                </div> 
            </td>
        </tr>
        </tbody>
                            </table>
         

         <?php
    }
}
add_action('wpto_admin_configuration_form_top', 'wpto_admin_configuration_form_top_free',60,2);