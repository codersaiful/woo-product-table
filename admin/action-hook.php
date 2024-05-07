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
// add_action( 'wpto_form_top', 'wpt_admin_form_top');


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

<div class="wpt-section-panel basic-settings basic <?php echo esc_attr( $page ); ?>" id="wpt-basic-settings">
    <table class="wpt-my-table basic-setting-table">
        <thead>
            <tr>
                <th class="wpt-inside">
                    <div class="wpt-table-header-inside">
                        <h3><?php echo esc_html__( 'Basic', 'woo-product-table' ); ?></h3>
                    </div>
                    
                </th>
                <th>
                <div class="wpt-table-header-right-side"></div>
                </th>
            </tr>
        </thead>

        <tbody>
            <!-- <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            LabelTagHere
                        </div>
                        <div class="form-field col-lg-6">
                            InputFieldOrAnyOtherField
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        DescriptionOfField_and_docLink
                    </div> 
                </td>
            </tr> -->



            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_custom_add_to_cart"><?php esc_html_e( 'Add to Cart Icon', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[custom_add_to_cart]" id="wpt_table_custom_add_to_cart" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="add_cart_no_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_no_icon', $current_config_value ); ?>><?php esc_html_e( 'No Icon', 'woo-product-table' ); ?></option>
                                <option value="add_cart_only_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_only_icon', $current_config_value ); ?>><?php esc_html_e( 'Only Icon', 'woo-product-table' ); ?></option>
                                <option value="add_cart_left_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_left_icon', $current_config_value ); ?>><?php esc_html_e( 'Left Icon and Text', 'woo-product-table' ); ?></option>
                                <option value="add_cart_right_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_right_icon', $current_config_value ); ?>><?php esc_html_e( 'Text and Right Icon', 'woo-product-table' ); ?></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/customize-add-to-card-icon/') ?>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_thumbs_image_size"><?php echo sprintf(esc_html__( 'Thumbs Image Size', 'woo-product-table' ), '<small>', '</small>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[thumbs_image_size]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['thumbs_image_size'] ); ?>" id="wpt_table_thumbs_image_size" type="text" placeholder="<?php esc_attr_e( 'Thumbnail size. eg: 56', 'woo-product-table' ); ?>" min="16" max="" pattern="[0-9]*" inputmode="numeric">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/change-thumbnail-image-size/') ?>
                        <p><?php esc_html_e( 'You can use number like 150 or use as text version like full, medium, large', 'woo-product-table' ); ?></p>
                    </div> 
                </td>
            </tr>
            <tr class="divider-row">
                <td>
                    <div class="wqpmb-form-control">
                        <div class="form-label col-lg-6">
                            <h4 class="section-divider-title"><?php echo esc_html__('Floating Cart', 'woo-product-table'); ?></h4>
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

            <tr class="<?php echo esc_attr( $user_can_edit ); ?> ">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_footer_cart"><?php esc_html_e( 'Floating Cart Option', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[footer_cart]" id="wpt_table_footer_cart" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="always_hide" <?php wpt_selected( 'footer_cart', 'always_hide', $current_config_value ); ?>><?php esc_html_e( 'Always Hide', 'woo-product-table' ); ?></option>
                                <option value="hide_for_zerro" <?php wpt_selected( 'footer_cart', 'hide_for_zerro', $current_config_value ); ?>><?php esc_html_e( 'Hide for Zero', 'woo-product-table' ); ?></option>
                                <option value="always_show" <?php wpt_selected( 'footer_cart', 'always_show', $current_config_value ); ?>><?php esc_html_e( 'Always Show', 'woo-product-table' ); ?></option>
                                
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/'); ?>
                    </div> 
                </td>
            </tr>

            <tr class="<?php echo esc_attr( $user_can_edit ); ?> ">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_footer_bg_color" class="wpt_label"><?php esc_html_e( 'Floating Cart BG Color', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[footer_bg_color]" class="wpt_data_filed_atts wpt_color_picker" value="<?php echo esc_attr( $current_config_value['footer_bg_color'] ); ?>" id="wpt_table_footer_bg_colort" type="text" placeholder="<?php esc_attr_e( 'BG Color', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/') ?>
                    </div> 
                </td>
            </tr>
            <tr class="<?php echo esc_attr( $user_can_edit ); ?> ">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_footer_possition"><?php esc_html_e( 'Floating Cart Position', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[footer_possition]" id="wpt_table_footer_possition" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="bottom_right" <?php wpt_selected( 'footer_possition', 'bottom_right', $current_config_value ); ?>><?php esc_html_e( 'Bottom Right', 'woo-product-table' ); ?></option>
                                <option value="bottom_left" <?php wpt_selected( 'footer_possition', 'bottom_left', $current_config_value ); ?>><?php esc_html_e( 'Bottom Left', 'woo-product-table' ); ?></option>
                                <option value="top_right" <?php wpt_selected( 'footer_possition', 'top_right', $current_config_value ); ?>><?php esc_html_e( 'Top Right', 'woo-product-table' ); ?></option>
                                <option value="top_left" <?php wpt_selected( 'footer_possition', 'top_left', $current_config_value ); ?>><?php esc_html_e( 'Top Left', 'woo-product-table' ); ?></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/'); ?>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_footer_cart_size"><?php echo sprintf(esc_html__( 'Floating Cart Size %s[Only Int]%s', 'woo-product-table' ), '<small>', '</small>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[footer_cart_size]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['footer_cart_size'] ); ?>" id="wpt_table_footer_cart_size" type="number" placeholder="<?php esc_attr_e( 'Default Size. eg: 70', 'woo-product-table' ); ?>" min="50" max="" pattern="[0-9]*" inputmode="numeric">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/'); ?>
                    </div> 
                </td>
            </tr>


            <tr class="divider-row">
                <td>
                    <div class="wqpmb-form-control">
                        <div class="form-label col-lg-6">
                            <h4 class="section-divider-title"><?php echo esc_html__('Search & Filter Options', 'woo-product-table'); ?></h4>
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
                            <label class="wpt_label" for="wpt_table_sort_mini_filter"><?php esc_html_e( 'Mini Filter Sorting', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[sort_mini_filter]" id="wpt_table_sort_mini_filter" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="0" <?php wpt_selected( 'sort_mini_filter', '0', $current_config_value ); ?>><?php esc_html_e( 'None', 'woo-product-table' ); ?></option>
                                <option value="ASC" <?php wpt_selected( 'sort_mini_filter', 'ASC', $current_config_value ); ?>><?php esc_html_e( 'Ascending', 'woo-product-table' ); ?></option>
                                <option value="DESC" <?php wpt_selected( 'sort_mini_filter', 'DESC', $current_config_value ); ?>><?php esc_html_e( 'Descending', 'woo-product-table' ); ?></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/mini-filter-search-box-taxonomy-sorting/') ?>
                        <p>You can sort mini filter's option by assending or descending. It's a minimal feature. When user showing all product in a table and there is no pagination. Then user can use <b>Mini Filter</b>.</p>
                    </div> 
                </td>
            </tr>

            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_sort_searchbox_filter"><?php esc_html_e( 'Advance Search drop-down Sorting', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[sort_searchbox_filter]" id="wpt_table_sort_searchbox_filter" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="0" <?php wpt_selected( 'sort_searchbox_filter', '0', $current_config_value ); ?>><?php esc_html_e( 'Default Sorting', 'woo-product-table' ); ?></option>
                                <option value="ASC" <?php wpt_selected( 'sort_searchbox_filter', 'ASC', $current_config_value ); ?>><?php esc_html_e( 'Ascending', 'woo-product-table' ); ?></option>
                                <option value="DESC" <?php wpt_selected( 'sort_searchbox_filter', 'DESC', $current_config_value ); ?>><?php esc_html_e( 'Descending', 'woo-product-table' ); ?></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/mini-filter-search-box-taxonomy-sorting/') ?>
                        <p>It's for Advance Search Drop-Down sorting. Advance Search box is important, when you created your table with pagination. or when you want that, search will execute from whole site.</p>
                        <p class="warning">If set Default Sorting, Taxonomy (Category/Tag) sorting will be like Default Taxonomy list.</p>
                    </div> 
                </td>
            </tr>

            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_instant_search_filter"><?php esc_html_e( 'Instance Search Filter', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[instant_search_filter]" id="wpt_table_instant_search_filter" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="1" <?php wpt_selected( 'instant_search_filter', '1', $current_config_value ); ?>><?php esc_html_e( 'Show', 'woo-product-table' ); ?></option>
                                <option value="0" <?php wpt_selected( 'instant_search_filter', '0', $current_config_value ); ?>><?php esc_html_e( 'Hide', 'woo-product-table' ); ?></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/use-instant-search-filter/') ?>
                        <p>It's a minimal feature. When user showing all product in a table and there is no pagination. Then user can use <b>Instance Search</b> input box.</p>
                    </div> 
                </td>
            </tr>  
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_instant_search_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Instance Search]%s - Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[instant_search_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['instant_search_text'] ); ?>" id="wpt_table_instant_search_text" type="text" placeholder="<?php esc_attr_e( 'attr', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>For Instance search box, you can change placeholder text.</p>  
                    </div> 
                </td>
            </tr>

            <tr class="divider-row">
                <td>
                    <div class="wqpmb-form-control">
                        <div class="form-label col-lg-6">
                            <h4 class="section-divider-title"><?php echo esc_html__('Linking', 'woo-product-table'); ?></h4>
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
                            <label class="wpt_label" for="wpt_table_product_link_target"><?php esc_html_e( 'Product Link Open Type', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[product_link_target]" id="wpt_table_product_link_target" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="_blank" <?php wpt_selected( 'product_link_target', '_blank', $current_config_value ); ?>><?php esc_html_e( 'New Tab', 'woo-product-table' ); ?></option>
                                <option value="_self" <?php wpt_selected( 'product_link_target', '_self', $current_config_value ); ?>><?php esc_html_e( 'Self Tab', 'woo-product-table' ); ?></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/show-product-in-new-same-tab/'); ?>
                    </div> 
                </td>
            </tr>
            
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_disable_cat_tag_link"><?php echo sprintf(esc_html__( '%sCategories, Tags%s Link', 'woo-product-table' ), '<strong>', '</strong>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[disable_cat_tag_link]" id="wpt_table_disable_cat_tag_link" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="1" <?php wpt_selected( 'disable_cat_tag_link', '1', $current_config_value ); ?>><?php esc_html_e( 'Disable', 'woo-product-table' ); ?></option>
                                <option value="0" <?php wpt_selected( 'disable_cat_tag_link', '0', $current_config_value ); ?>><?php esc_html_e( 'Enable', 'woo-product-table' ); ?></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/disable-categories-tag-link/'); ?>
                    </div> 
                </td>
            </tr>
                  

            
            <!-- ----------Cart------------------ -->
            <tr class="divider-row">
                <td>
                    <div class="wqpmb-form-control">
                        <div class="form-label col-lg-6">
                            <h4 class="section-divider-title"><?php echo esc_html__('Cart', 'woo-product-table') ?></h4>
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
                            <label class="wpt_label" for="wpt_table_popup_notice"><?php esc_html_e( 'Popup Notice', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[popup_notice]" id="wpt_table_popup_notice" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="1" <?php wpt_selected( 'popup_notice', '1', $current_config_value ); ?>><?php esc_html_e( 'Show', 'woo-product-table' ); ?></option>
                                <option value="no" <?php wpt_selected( 'popup_notice', 'no', $current_config_value ); ?>><?php esc_html_e( 'Hide', 'woo-product-table' ); ?></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/disable-enable-add-to-cart-popup-notice/'); ?>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_product_direct_checkout"><?php esc_html_e( 'Quick Buy', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
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
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/redirect-checkout-page-after-add-to-cart/') ?>
                        <p><?php esc_html_e( 'Enable Quick Buy Button [Direct Checkout Page for each product]. Direct going to Checkout Page just after Added to cart for each product', 'woo-product-table' ); ?></p>
                    </div> 
                </td>
            </tr>
                 
            <tr class="<?php echo esc_attr( $user_can_edit ); ?> ">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_all_selected_direct_checkout"><?php esc_html_e( 'Bundle Quick Buy ', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[all_selected_direct_checkout]" id="wpt_table_all_selected_direct_checkout" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="no" <?php wpt_selected( 'all_selected_direct_checkout', 'no', $current_config_value ); ?>><?php esc_html_e( 'Disable', 'woo-product-table' ); ?></option>
                                <option value="cart" <?php wpt_selected( 'all_selected_direct_checkout', 'cart', $current_config_value ); ?>><?php esc_html_e( 'Cart Page', 'woo-product-table' ); ?></option>
                                <option value="yes" <?php wpt_selected( 'all_selected_direct_checkout', 'yes', $current_config_value ); ?>><?php esc_html_e( 'Checkout Page', 'woo-product-table' ); ?></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                    <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/redirect-checkout-page-after-add-to-cart/') ?>
                            <p>Direct Checkout Page[for Add to cart Selected]</p>
                    </div> 
                </td>
            </tr>
            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_query_by_url"><?php esc_html_e( 'Query by URL', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[query_by_url]" id="wpt_table_instant_search_filter" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="0" <?php wpt_selected( 'query_by_url', '0', $current_config_value ); ?>><?php esc_html_e( 'Off', 'woo-product-table' ); ?></option>
                                <option value="1" <?php wpt_selected( 'query_by_url', '1', $current_config_value ); ?>><?php esc_html_e( 'On', 'woo-product-table' ); ?></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/how-to-show-hide-query-url/'); ?>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label class="wpt_label" for="wpt_table_product_count"><?php esc_html_e( 'Item/Products Count system [New]', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <select name="<?php echo esc_attr( $field_name ); ?>[item_count]" id="wpt_table_product_count" class="wpt_fullwidth ua_input" >
                                <?php wpt_default_option( $page ) ?>
                                <option value="" <?php wpt_selected( 'item_count', '' ); ?>><?php esc_html_e( 'Products Wise', 'woo-product-table' ); ?></option>
                                <option value="all" <?php wpt_selected( 'item_count', 'all' ); ?>><?php esc_html_e( 'All Items', 'woo-product-table' ); ?></option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        
                    </div> 
                </td>
            </tr>

        </tbody>
    </table>
    <?php do_action( 'wpto_admin_configuration_panel_bottom',$settings,$current_config_value ); ?>
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

<div class="wpt-section-panel basic-settings label <?php echo esc_attr( $page ); ?>" id="wpt-label-settings">
    <table class="wpt-my-table basic-setting-table">
        <thead>
            <tr>
                <th class="wpt-inside">
                    <div class="wpt-table-header-inside">
                        <h3><?php esc_html_e( 'Label Text', 'woo-product-table' );?></h3>
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
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_product_not_founded" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Products not found!]%s - Message Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[product_not_founded]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['product_not_founded'] ); ?>" id="wpt_table_product_not_founded" type="text" placeholder="<?php esc_attr_e( 'No products found in this query.', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>When products not found in table based on your query.</p>
                    </div> 
                </td>
            </tr>

            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_type_your_message" class="wpt_label"><?php esc_html_e( '[Type your Message.] Placeholder', 'woo-product-table' );?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[type_your_message]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['type_your_message'] ); ?>" id="wpt_table_type_your_message" type="text" placeholder="<?php esc_attr_e( 'Type your Message.', 'woo-product-table' );?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>Specially for <b>Short Message</b> column. It's a placeholder text of Short Message Input box. To enable <b>Short Message</b> - Please enable this collumn from Table Edit page.</p>
                    </div> 
                </td>
            </tr>

            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_load_more_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Load More]%s - Button Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[load_more_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['load_more_text'] ); ?>" id="wpt_table_load_more_text" type="text" placeholder="<?php esc_attr_e( 'Load More text write here', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>
                            <?php echo esc_html__( 'At the end of the table, when enable [Load More] from Option tab.', 'woo-product-table' ); ?>
                            <?php echo esc_html__( 'Not for Archive page.', 'woo-product-table' ); ?>
                        </p>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_loading_more_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Loading..]%s - Button Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[loading_more_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['loading_more_text'] ); ?>" id="wpt_table_loading_more_text" type="text" placeholder="<?php esc_attr_e( 'Loading.. text write here', 'woo-product-table' ); ?>"> 
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>When select infinite scrol for pagination option, there will show a Loading button. Change text from here.</p>
                    </div> 
                </td>
            </tr>

            <tr style="display: none;">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_search_button_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Search]%s - Button Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_button_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_button_text'] ); ?>" id="wpt_table_search_button_textt" type="text" placeholder="<?php esc_attr_e( 'Search text write here', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>It's not visible to table. Hidden by css.</p>
                    </div> 
                </td>
            </tr>

            

            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_empty_cart_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Empty Cart]%s - Text of Empty Cart', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[empty_cart_text]" class="wpt_data_filed_atts ua_input" value="<?php echo isset( $current_config_value['empty_cart_text'] ) ? esc_attr( $current_config_value['empty_cart_text'] ) : ''; ?>" id="wpt_table_filter_text" type="text" placeholder="<?php esc_attr_e( 'eg: Empty Cart', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>Empty cart button text change for Woo Product Table's mini cart. Min Cart can show/hide from Options table from Product Table Edit page.</p>
                    </div> 
                </td>
            </tr>
            

            <!-- ----add to cart selected---- -->
            <tr class="divider-row">
                <td>
                    <div class="wqpmb-form-control">
                        <div class="form-label col-lg-6">
                            <h4 class="section-divider-title"><?php echo esc_html__( 'Checbox & Selected button', 'woo-product-table' ); ?></h4>
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
                            <label for="wpt_table_item_add_selct_all" class="wpt_label"><?php esc_html_e( 'Add to Cart all selected [Added] Text', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[add2cart_all_added_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['add2cart_all_added_text'] ); ?>" id="wpt_table_item_add_selct_all" type="text" placeholder="<?php esc_attr_e( 'Added text for [Add to cart Selected]', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>If user enable checkbox for a table, then a Add To Cart Selected button at the top of table.</p>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_item" class="wpt_label"><?php esc_html_e( 'Item [for Singular]', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[item]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['item'] ); ?>" id="wpt_table_item" type="text" placeholder="<?php esc_attr_e( 'Item | for All selected Button', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>It's for Add to cart Selected button. If user enable checkbox for a table, then a Add To Cart Selected button at the top of table.</p>
                    </div> 
                </td>
            </tr>

            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_items" class="wpt_label"><?php esc_html_e( 'Item [for Plural]', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[items]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['items'] ); ?>" id="wpt_table_items" type="text" placeholder="<?php esc_attr_e( 'Item | for All selected Button', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>It's for Add to cart Selected button. If user enable checkbox for a table, then a Add To Cart Selected button at the top of table.</p>
                    </div> 
                </td>
            </tr>

            
            <tr class="divider-row">
                <td>
                    <div class="wqpmb-form-control">
                        <div class="form-label col-lg-6">
                            <h4 class="section-divider-title"><?php echo esc_html__( 'Advance Search Box', 'woo-product-table' ); ?></h4>
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
                            <label for="wpt_table_search_box_title" class="wpt_label"><?php esc_html_e( 'Searchbox Area title', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_title]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_box_title'] ); ?>" id="wpt_table_search_box_title" type="text" placeholder="<?php esc_attr_e( 'Search Box title', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>Advance Search Box area title. Showing at the top of main search box.</p>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_search_keyword_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Search Input Label]%s - Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_keyword_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_keyword_text'] ); ?>" id="wpt_table_search_keyword_text" type="text" placeholder="<?php esc_attr_e( 'Search Keyword', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>Label/Title text of Search Input box of Advance Search area. Not a placeholder of inpux. It's label.</p>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_search_box_searchkeyword" class="wpt_label"><?php esc_html_e( 'Search Keyword Placeholder', 'woo-product-table' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_searchkeyword]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_box_searchkeyword'] ); ?>" id="wpt_table_search_box_searchkeyword" type="text" placeholder="<?php esc_attr_e( 'Search Keyword text', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>Advance search box - Placeholder of input box.</p>
                    </div> 
                </td>
            </tr>

            <?php if( defined( 'WPT_PRO_DEV_VERSION' ) ){ ?>

                <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_search_box_sale" class="wpt_label"><?php esc_html_e( 'SearchBox Sale text', 'woo-product-table' ); ?></label></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_sale]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_box_sale'] ?? '' ); ?>" id="wpt_table_search_box_sale" type="text" placeholder="<?php esc_attr_e( 'Sale', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>SearchBox Sale text</p>
                    </div> 
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_search_box_orderby" class="wpt_label"><?php esc_html_e( 'SearchBox Order By text', 'woo-product-table' ); ?></label></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_orderby]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_box_orderby'] ); ?>" id="wpt_table_search_box_orderby" type="text" placeholder="<?php esc_attr_e( 'Order By text', 'woo-product-table' ); ?>">
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
                            <label for="wpt_table_search_eee" class="wpt_label"><?php esc_html_e( 'SearchBox Order text', 'woo-product-table' ); ?></label></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_order]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_box_order'] ); ?>" id="wpt_table_search_eee" type="text" placeholder="<?php esc_attr_e( 'Order text', 'woo-product-table' ); ?>">
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
                            <label for="wpt_table_search_eee" class="wpt_label"><?php esc_html_e( 'Search Dropdown Placeholder text', 'woo-product-table' ); ?></label></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_order_placeholder]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['search_order_placeholder'] ?? '' ); ?>" id="wpt_table_search_eee" type="text" placeholder="<?php esc_attr_e( 'Select Innet Items', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        
                    </div> 
                </td>
            </tr>

            <tr class="divider-row">
                <td>
                    <div class="wqpmb-form-control">
                        <div class="form-label col-lg-6">
                            <h4 class="section-divider-title"><?php echo esc_html__( 'Mini Filter', 'woo-product-table' ); ?></h4>
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
                            <label for="wpt_table_filter_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Filter]%s - Text of Filter', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                        <input name="<?php echo esc_attr( $field_name ); ?>[filter_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['filter_text'] ); ?>" id="wpt_table_filter_text" type="text" placeholder="<?php esc_attr_e( 'eg: Filter', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>Mini Filter - label text. Remember: Mini Filter only for Visible product. It's a minmal feature.</p>
                    </div> 
                </td>
            </tr>
            
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_filter_reset_button" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Reset]%s - Button Text of Filter', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[filter_reset_button]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['filter_reset_button'] ); ?>" id="wpt_table_filter_reset_button" type="text" placeholder="<?php esc_attr_e( 'eg: Reset', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>Reset button text of Mini-Filter. Remember: Mini Filter only for Visible product. It's a minmal feature.</p>
                    </div> 
                </td>
            </tr>

        </tbody>
    </table>
    <?php do_action( 'wpto_admin_configuration_panel_bottom',$settings,$current_config_value ); ?>
</div>

         <?php
         
    }
}
add_action( 'wpto_admin_configuration_form', 'wpt_configure_label_part',10, 3 );


if( !function_exists( 'wpt_configure_external_part' ) ){
    
    /**
     * specially for YITH Quick View Plugin
     *
     * @param mixed $settings
     * @param mixed $current_config_value
     * @param string $field_name
     * @return void
     */
    function wpt_configure_external_part( $settings,$current_config_value,$field_name ){
        $display = '';
        if( ! defined( 'YITH_YWRAQ_VERSION' ) ){
            $display = 'display:none';
        }

        $page = isset( $settings['page'] ) ? $settings['page'] : 'not_set_page';
        
        ?>
<div class="wpt-section-panel basic-settings yith <?php echo esc_attr( $page ); ?>" id="wpt-yith-settings" style="<?php echo esc_attr( $display ); ?>">
    <table class="wpt-my-table basic-setting-table">
        <thead>
            <tr>
                <th class="wpt-inside">
                    <div class="wpt-table-header-inside">
                        <h3><?php echo sprintf( esc_html__( 'External Plugin\'s %s[YITH]%s ', 'woo-product-table' ),'<span style="color: orange; font-size: 18px;">', '</span>' );?></h3>
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
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_quick_view_btn_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Quick View]%s - Button Text', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[quick_view_btn_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['quick_view_btn_text'] ?? __( 'Quick View', 'woo-product-table' ) ); ?>" id="wpt_table_quick_view_btn_text" type="text" placeholder="<?php esc_attr_e( 'eg: Quick View', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p><?php echo sprintf(esc_html__( 'Only for %s YITH WooCommerce Quick View%s Plugin', 'woo-product-table' ), '<a target="_blank" href="https://wordpress.org/plugins/yith-woocommerce-quick-view/">', '</a>' ); ?></p>
                    </div> 
                </td>
            </tr>
            
            <tr>
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_yith_browse_list" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Browse Quote list]%s - text ', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_browse_list]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['yith_browse_list'] ?? __( 'Browse the list', 'woo-product-table' ) ); ?>" id="wpt_table_yith_browse_list" type="text" placeholder="<?php esc_attr_e( 'Browse the list - text write here', 'woo-product-table' ); ?>">
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
                            <label for="wpt_table_yith_add_to_quote_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Add to Quote]%s - button text', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_add_to_quote_text]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['yith_add_to_quote_text'] ?? __( 'Add to Quote', 'woo-product-table' ) ); ?>" id="wpt_table_yith_add_to_quote_text" type="text" placeholder="<?php esc_attr_e( 'Add to Quote text write here', 'woo-product-table' ); ?>">
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
                            <label for="wpt_table_yith_add_to_quote_adding" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Quote Adding]%s - text', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_add_to_quote_adding]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['yith_add_to_quote_adding'] ?? __( 'Adding', 'woo-product-table' ) ); ?>" id="wpt_table_yith_add_to_quote_adding" type="text" placeholder="<?php esc_attr_e( 'Adding text write here', 'woo-product-table' ); ?>">
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
                            <label for="wpt_table_yith_add_to_quote_added" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Quote Added]%s - text ', 'woo-product-table' ), '<b>', '</b>' ); ?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_add_to_quote_added]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['yith_add_to_quote_added'] ?? __( 'Quote Added', 'woo-product-table' ) ); ?>" id="wpt_table_yith_add_to_quote_added" type="text" placeholder="<?php esc_attr_e( 'Quote Added text write here', 'woo-product-table' ); ?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        
                    </div> 
                </td>
            </tr>
        </tbody>
    </table>
</div>
         <?php
         
    }
}
add_action( 'wpto_admin_configuration_form', 'wpt_configure_external_part',15, 3 );



if( !function_exists( 'wpt_configure_all_message_part' ) ){
    
    function wpt_configure_all_message_part( $settings,$current_config_value,$field_name ){
        $page = isset( $settings['page'] ) ? $settings['page'] : 'not_set_page';
        $user_can_edit = wpt_user_can_edit() ? 'user_can_edit' : 'user_can_not_edit';

        // label <?php echo esc_attr( $page ); "
        ?>
<div class="wpt-section-panel basic-settings yith <?php echo esc_attr( $page ); ?>" id="wpt-yith-settings">
    <table class="wpt-my-table basic-setting-table">
        <thead>
            <tr>
                <th class="wpt-inside">
                    <div class="wpt-table-header-inside">
                        <h3><?php esc_html_e( 'All Messages', 'woo-product-table' );?></h3>
                    </div>
                    
                </th>
                <th>
                <div class="wpt-table-header-right-side"></div>
                </th>
            </tr>
        </thead>
        <tbody>

            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_right_combination_message" class="wpt_label"><?php esc_html_e( 'Variations [Not available] Message', 'woo-product-table' );?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[right_combination_message]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['right_combination_message'] ); ?>" id="wpt_table_right_combination_message" type="text" placeholder="<?php esc_attr_e( 'Not Available', 'woo-product-table' );?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>For vairable product, If you change drop-down of Variation and Not available variation. Then this message will show.</p>
                    </div> 
                </td>
            </tr>

            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_right_combination_message_alt" class="wpt_label"><?php esc_html_e( '[Product variations is not set Properly.] Message', 'woo-product-table' );?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[right_combination_message_alt]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['right_combination_message_alt'] ); ?>" id="wpt_table_right_combination_message_alt" type="text" placeholder="<?php esc_attr_e( 'Product variations is not set Properly. May be: price is not inputted. may be: Out of Stock.', 'woo-product-table' );?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        For variable product, if not set properly variation. May be: price is not inputted. may be: Out of Stock.
                    </div> 
                </td>
            </tr>
            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_select_all_items_message" class="wpt_label"><?php esc_html_e( '[Please select all items.] Message', 'woo-product-table' );?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[select_all_items_message]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['select_all_items_message'] ); ?>" id="wpt_table_select_all_items_message" type="text" placeholder="<?php esc_attr_e( 'Please select all items.', 'woo-product-table' );?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        
                    </div> 
                </td>
            </tr>

            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_please_choose_items" class="wpt_label"><?php esc_html_e( '[Please Choose items] Alert!', 'woo-product-table' );?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[please_choose_items]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['please_choose_items'] ); ?>" id="wpt_table_please_choose_items" type="text" placeholder="<?php esc_attr_e( 'Please select all items.', 'woo-product-table' );?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        For vairable product, If user click on Add to cart button without select any variation. Then this message will show.
                    </div> 
                </td>
            </tr>

            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_out_of_stock_message" class="wpt_label"><?php esc_html_e( '[Out of Stock] Message', 'woo-product-table' );?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[out_of_stock_message]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['out_of_stock_message'] ); ?>" id="wpt_table_out_of_stock_message" type="text" placeholder="<?php esc_attr_e( 'Out of Stock', 'woo-product-table' );?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        
                    </div> 
                </td>
            </tr>

            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_no_more_query_message" class="wpt_label"><?php esc_html_e( '[There is no more products based on current Query.] Message', 'woo-product-table' );?></label>
                        </div>
                        <div class="form-field col-lg-6">
                        <input name="<?php echo esc_attr( $field_name ); ?>[no_more_query_message]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['no_more_query_message'] ); ?>" id="wpt_table_no_more_query_message" type="text" placeholder="<?php esc_attr_e( 'There is no more products based on current Query.', 'woo-product-table' );?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>Actually it's for pagination. When select Load More button or infinite scroll. If not found product on nect load more clik.</p>
                    </div> 
                </td>
            </tr>

            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_out_adding_progress" class="wpt_label"><?php esc_html_e( '[ Adding in Progress ] Message', 'woo-product-table' );?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[adding_in_progress]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['adding_in_progress'] ); ?>" id="wpt_table_out_adding_progress" type="text" placeholder="<?php esc_attr_e( 'Adding in Progress', 'woo-product-table' );?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>If user click again same add to cart button before complete added.</p>
                    </div> 
                </td>
            </tr>

            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_no_right_comb" class="wpt_label"><?php esc_html_e( '[ No Right Combination ] Message', 'woo-product-table' );?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[no_right_combination]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['no_right_combination'] ); ?>" id="wpt_table_no_right_comb" type="text" placeholder="<?php esc_attr_e( 'No Right Combination', 'woo-product-table' );?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>It's for variable product. If not match variation, of if not found variation. </p>
                    </div> 
                </td>
            </tr>

            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_sorry_plz_right_combination" class="wpt_label"><?php esc_html_e( '[ Sorry, Please choose right combination. ] Message', 'woo-product-table' );?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[sorry_plz_right_combination]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['sorry_plz_right_combination'] ); ?>" id="wpt_table_sorry_plz_right_combination" type="text" placeholder="<?php esc_attr_e( 'Sorry, Please choose right combination.', 'woo-product-table' );?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        <p>It's actually for variable product. If product has one more type variation, and if not match on available. this message will show.</p>
                    </div> 
                </td>
            </tr>

            <tr class="<?php echo esc_attr( $user_can_edit ); ?>">
                <td>
                    <div class="wpt-form-control">
                        <div class="form-label col-lg-6">
                            <label for="wpt_table_sorry_out_stock" class="wpt_label"><?php esc_html_e( '[ Sorry! Out of Stock! ] Message', 'woo-product-table' );?></label>
                        </div>
                        <div class="form-field col-lg-6">
                            <input name="<?php echo esc_attr( $field_name ); ?>[sorry_out_of_stock]" class="wpt_data_filed_atts ua_input" value="<?php echo esc_attr( $current_config_value['sorry_out_of_stock'] ); ?>" id="wpt_table_sorry_out_stock" type="text" placeholder="<?php esc_attr_e( 'Sorry! Out of Stock!', 'woo-product-table' );?>">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="wpt-form-info">
                        
                    </div> 
                </td>
            </tr>

            
        </tbody>
    </table>
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
// add_action( 'wpto_admin_configuration_panel_bottom', 'wpt_configure_all_part_save_btn' );


if( !function_exists( 'wpt_profeatures_message_box' ) ){
    
    function wpt_profeatures_message_box( $value ){
        if(defined('WPT_PRO_DEV_VERSION')) return;
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
     * tawk.to Chatbox Added and 
     * condition applied
     * 
     * @return String
     */
    function wpt_tawkto_code_header(){
        global $current_screen;
        $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
        if( strpos( $s_id, 'wpt') === false ) return;
        $temp_permission = false;
        $submitted = filter_input_array(INPUT_POST);
        if( isset( $submitted['data'] ) ){
            if(isset( $submitted['data']['disable_live_support'] )) return;
            $temp_permission = true;
        }
        $disable_live_support = $temp_permission ? false : wpt_get_config('disable_live_support');
        if( $disable_live_support ) return;
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
add_filter( 'admin_head', 'wpt_tawkto_code_header', 999 );

/**
 * "Table Column Sorting" option was in pro version, we move that into free version
 * @since 3.2.5.4
 * @author Fazle Bari 
 * 
 * Added a new Param: $Page_Loader
 * which is represent Page_Loader Class
 * @since 3.4.2.0.new_admin3 
 * @author Saiful Islam <codersaiful@gmail.com>
 */
if( !function_exists( 'wpto_admin_configuration_form_top_free' ) ){
    function wpto_admin_configuration_form_top_free($settings,$current_config_value){
        if( !isset( $settings['page'] ) || isset( $settings['page'] ) && $settings['page'] != 'configuration_page' ){
            return;
        }
        $user_can_edit = wpt_user_can_edit() ? 'user_can_edit' : 'user_can_not_edit';
        $is_pro = ! empty( $settings['module'] ) && $settings['module'] == 'pro_version' ? true : false;
        /**
         * Now Here Available is:
         * $Page_Loader
         * which is represent Page_Loader classes's Object.
         * we used $Page_Loader->is_pro
         * in this function specially to show or hide divider-row
         */

        ?>
    <table class="wpt-my-table universal-setting">
        <tbody>
        <?php if( $is_pro ){ ?>
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
        <?php } ?>
        <tr>
            <td>
                <div class="wpt-form-control">
                    <div class="form-label col-lg-6">
                        <label class="wpt_label wpt_column_sorting_on_off" for="wpt_column_sorting_on_off"><?php esc_html_e( 'Table Column Sortings', 'woo-product-table' );?></label>
                    </div>
                    <div class="form-field col-lg-6">
                        <p><?php echo esc_html( 'Column sorting for visible product Column.', 'woo-product-table' ); ?></p>
                        <p class="warning">
                            <b>Tips:</b>
                            <span>If you want to sort any column like number where text like: 1st,2nd,3rd,4th. To this situation, add a custom tag className <code>text_with_number</code> for column.</span>
                        </p>
                    </div>
                </div>
            </td>
            <td>
                <div class="wpt-form-info">
                    <?php wpt_doc_link('https://wooproducttable.com/doc/advance-uses/sort-table-column/') ?>
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

        <tr class="<?php echo esc_attr( $user_can_edit ); ?>" id="wpt_footer_cart_template">
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

        <tr class="divider-row">
            <td>
                <div class="wqpmb-form-control">
                    <div class="form-label col-lg-6">
                        <h4 class="section-divider-title">Chat Area (Optional)</h4>
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
        <?php $live_support = isset( $current_config_value['disable_live_support' ] ) && $current_config_value['disable_live_support' ] == '1' ? 'checked' : false; ?>
        <tr>
            <td>
                <div class="wpt-form-control">
                    <div class="form-label col-lg-6">
                        <label for="_disable_live_support"><?php echo esc_html__('Chatbox Live Support','woo-product-table');?></label>
                    </div>
                    <div class="form-field col-lg-6">
                        <label class="switch reverse">
                            <input value="1" name="data[disable_live_support]"
                                <?php echo $live_support; /* finding checked or null */ ?> type="checkbox" id="_disable_live_support">
                            <div class="slider round"><!--ADDED HTML -->
                                <span class="on"><?php echo esc_html__('ON','woo-product-table');?></span><span class="off"> <?php echo esc_html__('OFF','woo-product-table');?></span><!--END-->
                            </div>
                        </label>
                    </div>
                </div>
            </td>
            <td>
                <div class="wpt-form-info">
                    <?php wpt_doc_link('https://codeastrology.com/my-support', 'Customer Support'); ?>
                    <p>You can Disable/Off Chatbox. Live Support chatbox are showing in your dashboard at right bottom corner. If you need any help, Just knock over there.</p>
                </div> 
            </td>
        </tr>
        </tbody>
    </table>
    <?php if( ! $is_pro ){ ?>
        <table class="wpt-my-table universal-setting">
            <tbody>
                <tr class="user_can_not_edit">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label wpt_advance_search_on_of" for="wpt_table_on_archive">Table on Shop/Archives/Taxonomy</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select name="data[archive_table_id]" class="wpt_fullwidth ua_input wpt_table_on_archive">
                                    <option value="">Select a Table</option>
                                    
                                </select>
                                <br>
                                <label class="switch">
                                    <input type="checkbox" id="wpt_table_on_archive">
                                    <div class="slider round">
                                        <!--ADDED HTML -->
                                        <span class="on">On</span><span class="off">Off</span><!--END-->
                                    </div>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/product-table-woocommerce-archive-category-tag-attribute-page/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>Enable Table on Shop/Archive/Taxonomy Page. Such as: Archive Page, Tag Page, Taxonomy Page. First Select a table and check [On] to show in shop/archive page.</p>
                            <p class="wpt-tips">
                                <b>Notice:</b>
                                <span>Product table will display products according to WooCommerce default query and Advance Search box is not available on Archive page.</span>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr class="user_can_not_edit">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="table_view_switcher_on_of" for="wpt_advance_cascade_filter_on_of">Table View Switcher On Shop Page</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <label class="switch">
                                    <input type="checkbox" id="table_view_switcher_on_of">
                                    <div class="slider round">
                                        <!--ADDED HTML -->
                                        <span class="on">On</span><span class="off">Off</span><!--END-->
                                    </div>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/product-table-woocommerce-archive-category-tag-attribute-page/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>You Can turn on/off table view switcher on shop page</p>
                        </div>
                    </td>
                </tr>
                <tr class="divider-row">
                    <td>
                        <div class="wqpmb-form-control">
                            <div class="form-label col-lg-6">
                                <h4 class="section-divider-title">For Variable Products</h4>
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
                <tr class="user_can_not_edit">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label wpt_variation_table_on_off" for="wpt_table__for_variation">Variation Table</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select class="wpt_fullwidth ua_input wpt_table__for_variation">
                                    <option value="">Select a Table</option>
                                   
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/advance-uses/show-product-variation-inside-table-on-a-single-variable-product-page/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>Select a table and enable above the button to show a variation table on every variable product page which will replace the default variation dropdown select options.</p>
                        </div>
                    </td>
                </tr>
                <tr class="user_can_not_edit">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label wpt_variation_table_position" for="wpt_table_position_for_variation">Variation Table Position</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select class="wpt_fullwidth ua_input wpt_table_position_for_variation">
                                    <option value="woocommerce_single_product_summary" selected="">After Title</option>
                                    <option value="woocommerce_product_meta_start">Before Meta</option>
                                    <option value="woocommerce_product_meta_end">After Meta</option>
                                    <option value="woocommerce_after_single_product_summary">After summary</option>
                                    <option value="woocommerce_product_after_tabs">After Tab</option>
                                    <option value="woocommerce_before_add_to_cart_form">Before Add to cart - Additional</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/advance-uses/show-product-variation-inside-table-on-a-single-variable-product-page/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>Select a table position to show the table to your desire place!</p>
                        </div>
                    </td>
                </tr>
                <tr class="user_can_not_edit">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label wpt_vt_prod_inc_exc" for="wpt_table_product_inc_exc_variation">Variation Product Include/Exclude</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select class="wpt_fullwidth ua_input wpt_table_product_inc_exc_variation">
                                    <option value="" selected="">Variation Table to Everywhere</option>
                                    <option value="vt_product_inc">Include Products</option>
                                    <option value="vt_product_exc">Exclude Products</option>
                                </select>
                                <br>
                                <br>
                                <input value="" type="text" placeholder="123,234,2345" class="wpt_var_table_product_exc_inc_ids ua_input" style="display:none;">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <p>Input product ids. If you have more then one products, sepetare them with coma(,).</p>
                        </div>
                    </td>
                </tr>
                <tr class="divider-row">
                    <td>
                        <div class="wqpmb-form-control">
                            <div class="form-label col-lg-6">
                                <h4 class="section-divider-title">Advance</h4>
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
                <tr class="user_can_not_edit">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label wpt_advance_search_issue" for="wpt_advance_search_issue">Advance Search PROBLEM FIX</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <label class="switch">
                                    <input type="checkbox" id="wpt_advance_search_issue">
                                    <div class="slider round">
                                        <!--ADDED HTML -->
                                        <span class="on">On</span><span class="off">Off</span><!--END-->
                                    </div>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <p>Only if found issue on Advance Search, Check it</p>
                        </div>
                    </td>
                </tr>
                <!--
                    Advance search cascade filter on ajax
                    @Since 8.0.2.1
                    -->
                <tr class="user_can_not_edit">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label wpt_advance_cascade_filter_on_of" for="wpt_advance_cascade_filter_on_of">Advance Cascade Filter</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <label class="switch">
                                    <input type="checkbox" id="wpt_advance_cascade_filter_on_of">
                                    <div class="slider round">
                                        <!--ADDED HTML -->
                                        <span class="on">On</span><span class="off">Off</span><!--END-->
                                    </div>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/how-to-use-advance-cascade-filter/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>Cascade filter will be added to product search filter</p>
                        </div>
                    </td>
                </tr>
                <tr class="user_can_not_edit">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label wpt_column_hide_for_guest" for="wpt_column_hide_for_guest">Show/Hide Column for Guest</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <label class="switch">
                                    <input type="checkbox" id="wpt_column_hide_for_guest">
                                    <div class="slider round">
                                        <!--ADDED HTML -->
                                        <span class="on">Show</span><span class="off">Hide</span><!--END-->
                                    </div>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/advance-uses/show-column-only-for-login-user/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>Show or hide the restricted column for guest user.</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
       
    <?php } ?>
         <?php
    }
}
add_action('wpto_admin_configuration_form_top', 'wpto_admin_configuration_form_top_free',60,2);