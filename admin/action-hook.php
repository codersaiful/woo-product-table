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
            <li><a class="wpt_get_pro_form_top_link" target="_blank" title="Awesome Pro features is Waiting for you!" href="https://codecanyon.net/item/woo-product-table-pro/20676867">Get Pro</a></li>  
            <li>
                <a class="Header-link " href="https://github.com/codersaiful/woo-product-table" target="_blank">
  <svg class="octicon octicon-mark-github v-align-middle" height="16" 
       viewBox="0 0 16 16" version="1.1" width="16" aria-hidden="true">
  <path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"></path>
  </svg>

                 GitHub Ropo</a></li>  
            <li><a target="_blank" href="https://demo.wooproducttable.com/">Demo</a></li>
            <li><a target="_blank" href="https://github.com/codersaiful/woo-product-table/discussions">Forum on Repo</a></li>
            <li><a target="_blank" href="https://wooproducttable.com/docs/">Basic Helps</a></li>
            <li><a target="_blank" href="https://docs.codeastrology.com/woo-product-table-pro/#intro">Documentation</a></li>
            <li><a target="_blank" href="https://codeastrology.com/support/">Get Support</a></li> 
            

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
        ?>
        <div class="fieldwrap ultraaddons-head">
            <div class="ultraaddons-panel">
                <h1 class="wp-heading-inline plugin_name plugin-name"><?php echo WPT_Product_Table::getName(); ?> <span class="plugin-version">v <?php echo WPT_Product_Table::getVersion(); ?></span></h1>
                
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
        //$current_config_value = get_option( 'wpt_configure_options' );
        ?>
        <div class="section ultraaddons-panel basic <?php echo esc_attr( $page ); ?>">
            <h3 class="with-background dark-background"><?php esc_html_e( 'Basic Settings', 'wpt_pro' );?></h3>
            <table class="ultraaddons-table">
                <tbody>
                    <tr class="table_disable_plugin_noti">
                        <th>
                            <label class="wpt_label wpt_disable_plugin_noti" for="wpt_disable_plugin_noti"><?php esc_html_e( 'Plugin Recomendation', 'wpt_pro' );?></label>
                        </th>
                        <td>
                            <label class="switch">
                                <input  name="<?php echo esc_attr( $field_name ); ?>[disable_plugin_noti]" type="checkbox" id="wpt_disable_plugin_noti" <?php echo isset( $current_config_value['disable_plugin_noti'] ) ? 'checked="checked"' : ''; ?>>
                                <div class="slider round"><!--ADDED HTML -->
                                    <span class="on">Enable</span><span class="off">Disable</span><!--END-->
                                </div>
                            </label>
                            <p><?php echo esc_html( 'To enable or disable our plugin Notification for our Product Table', 'wpt_pro' ); ?></p>

                        </td>
                    </tr>

                    <tr>
                        <th><label class="wpt_label" for="wpt_table_custom_add_to_cart"><?php esc_html_e( 'Add to Cart Icon', 'wpt_pro' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[custom_add_to_cart]" id="wpt_table_custom_add_to_cart" class="wpt_fullwidth ua_input" >
                                <option value="add_cart_no_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_no_icon', $current_config_value ); ?>><?php esc_html_e( 'No Icon', 'wpt_pro' ); ?></option>
                                <option value="add_cart_only_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_only_icon', $current_config_value ); ?>><?php esc_html_e( 'Only Icon', 'wpt_pro' ); ?></option>
                                <option value="add_cart_left_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_left_icon', $current_config_value ); ?>><?php esc_html_e( 'Left Icon and Text', 'wpt_pro' ); ?></option>
                                <option value="add_cart_right_icon" <?php wpt_selected( 'custom_add_to_cart', 'add_cart_right_icon', $current_config_value ); ?>><?php esc_html_e( 'Text and Right Icon', 'wpt_pro' ); ?></option>
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <th><label class="wpt_label" for="wpt_table_footer_cart"><?php esc_html_e( 'Footer Cart Option', 'wpt_pro' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[footer_cart]" id="wpt_table_footer_cart" class="wpt_fullwidth ua_input" >
                                <option value="hide_for_zerro" <?php wpt_selected( 'footer_cart', 'hide_for_zerro', $current_config_value ); ?>><?php esc_html_e( 'Hide for Zero', 'wpt_pro' ); ?></option>
                                <option value="always_show" <?php wpt_selected( 'footer_cart', 'always_show', $current_config_value ); ?>><?php esc_html_e( 'Always Show', 'wpt_pro' ); ?></option>
                                <option value="always_hide" <?php wpt_selected( 'footer_cart', 'always_hide', $current_config_value ); ?>><?php esc_html_e( 'Always Hide', 'wpt_pro' ); ?></option>
                            </select>

                        </td>
                    </tr>
                    <tr> 
                        <th> <label for="wpt_table_footer_bg_color" class="wpt_label"><?php esc_html_e( 'Footer Cart BG Color', 'wpt_pro' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[footer_bg_color]" class="wpt_data_filed_atts wpt_color_picker" value="<?php echo $current_config_value['footer_bg_color']; ?>" id="wpt_table_footer_bg_colort" type="text" placeholder="<?php esc_attr_e( 'BG Color', 'wpt_pro' ); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label class="wpt_label" for="wpt_table_footer_possition"><?php esc_html_e( 'Footer Cart Position', 'wpt_pro' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[footer_possition]" id="wpt_table_footer_possition" class="wpt_fullwidth ua_input" >
                                <option value="bottom_right" <?php wpt_selected( 'footer_possition', 'bottom_right', $current_config_value ); ?>><?php esc_html_e( 'Bottom Right', 'wpt_pro' ); ?></option>
                                <option value="bottom_left" <?php wpt_selected( 'footer_possition', 'bottom_left', $current_config_value ); ?>><?php esc_html_e( 'Bottom Left', 'wpt_pro' ); ?></option>
                                <option value="top_right" <?php wpt_selected( 'footer_possition', 'top_right', $current_config_value ); ?>><?php esc_html_e( 'Top Right', 'wpt_pro' ); ?></option>
                                <option value="top_left" <?php wpt_selected( 'footer_possition', 'top_left', $current_config_value ); ?>><?php esc_html_e( 'Top Left', 'wpt_pro' ); ?></option>
                            </select>

                        </td>
                    </tr>


                    <tr>
                        <th><label class="wpt_label" for="wpt_table_footer_cart_size"><?php echo sprintf(esc_html__( 'Footer Cart Size %s[Only Int]%s', 'wpt_pro' ), '<small>', '</small>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[footer_cart_size]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['footer_cart_size']; ?>" id="wpt_table_footer_cart_size" type="number" placeholder="<?php esc_attr_e( 'Default Size. eg: 70', 'wpt_pro' ); ?>" min="50" max="" pattern="[0-9]*" inputmode="numeric">
                        </td>
                    </tr>
                    <tr>
                        <th><label class="wpt_label" for="wpt_table_sort_mini_filter"><?php esc_html_e( 'Mini Filter Sorting', 'wpt_pro' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[sort_mini_filter]" id="wpt_table_sort_mini_filter" class="wpt_fullwidth ua_input" >
                                <option value="0" <?php wpt_selected( 'sort_mini_filter', '0', $current_config_value ); ?>><?php esc_html_e( 'None', 'wpt_pro' ); ?></option>
                                <option value="ASC" <?php wpt_selected( 'sort_mini_filter', 'ASC', $current_config_value ); ?>><?php esc_html_e( 'Ascending', 'wpt_pro' ); ?></option>
                                <option value="DESC" <?php wpt_selected( 'sort_mini_filter', 'DESC', $current_config_value ); ?>><?php esc_html_e( 'Descending', 'wpt_pro' ); ?></option>
                            </select>

                        </td>
                    </tr>

                    <tr>
                        <th><label class="wpt_label" for="wpt_table_sort_searchbox_filter"><?php esc_html_e( 'Search Box Taxonomy Sorting', 'wpt_pro' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[sort_searchbox_filter]" id="wpt_table_sort_searchbox_filter" class="wpt_fullwidth ua_input" >
                                <option value="0" <?php wpt_selected( 'sort_searchbox_filter', '0', $current_config_value ); ?>><?php esc_html_e( 'None', 'wpt_pro' ); ?></option>
                                <option value="ASC" <?php wpt_selected( 'sort_searchbox_filter', 'ASC', $current_config_value ); ?>><?php esc_html_e( 'Ascending', 'wpt_pro' ); ?></option>
                                <option value="DESC" <?php wpt_selected( 'sort_searchbox_filter', 'DESC', $current_config_value ); ?>><?php esc_html_e( 'Descending', 'wpt_pro' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label class="wpt_label" for="wpt_table_thumbs_image_size"><?php echo sprintf(esc_html__( 'Thumbs Image Size %s[Only Int]%s', 'wpt_pro' ), '<small>', '</small>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[thumbs_image_size]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['thumbs_image_size']; ?>" id="wpt_table_thumbs_image_size" type="number" placeholder="<?php esc_attr_e( 'Thumbnail size. eg: 56', 'wpt_pro' ); ?>" min="16" max="" pattern="[0-9]*" inputmode="numeric">
                        </td>
                    </tr>

                    <tr> 
                        <th><label class="wpt_label" for="wpt_table_popup_notice"><?php esc_html_e( 'Popup Notice [New]', 'wpt_pro' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[popup_notice]" id="wpt_table_popup_notice" class="wpt_fullwidth ua_input" >
                                <option value="1" <?php wpt_selected( 'popup_notice', '1', $current_config_value ); ?>><?php esc_html_e( 'Enable', 'wpt_pro' ); ?></option>
                                <option value="0" <?php wpt_selected( 'popup_notice', '0', $current_config_value ); ?>><?php esc_html_e( 'Disable', 'wpt_pro' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr> 
                        <th>  <label class="wpt_label" for="wpt_table_product_link_target"><?php esc_html_e( 'Product Link Open Type', 'wpt_pro' ); ?></label>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[product_link_target]" id="wpt_table_product_link_target" class="wpt_fullwidth ua_input" >
                                <option value="_blank" <?php wpt_selected( 'product_link_target', '_blank', $current_config_value ); ?>><?php esc_html_e( 'New Tab', 'wpt_pro' ); ?></option>
                                <option value="_self" <?php wpt_selected( 'product_link_target', '_self', $current_config_value ); ?>><?php esc_html_e( 'Self Tab', 'wpt_pro' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr> 
                        <th><label class="wpt_label" for="wpt_table_all_selected_direct_checkout"><?php esc_html_e( 'Direct Checkout Page[for Add to cart Selected]', 'wpt_pro' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[all_selected_direct_checkout]" id="wpt_table_all_selected_direct_checkout" class="wpt_fullwidth ua_input" >
                                <option value="no" <?php wpt_selected( 'all_selected_direct_checkout', 'no', $current_config_value ); ?>><?php esc_html_e( 'No', 'wpt_pro' ); ?></option>
                                <option value="yes" <?php wpt_selected( 'all_selected_direct_checkout', 'yes', $current_config_value ); ?>><?php esc_html_e( 'Yes', 'wpt_pro' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr> 
                        <th> <label class="wpt_label" for="wpt_table_product_direct_checkout"><?php esc_html_e( 'Enable Quick Buy Button [Direct Checkout Page for each product]', 'wpt_pro' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[product_direct_checkout]" id="wpt_table_product_direct_checkout" class="wpt_fullwidth ua_input" >
                                <option value="no" <?php wpt_selected( 'product_direct_checkout', 'no', $current_config_value ); ?>><?php esc_html_e( 'No', 'wpt_pro' ); ?></option>
                                <option value="yes" <?php wpt_selected( 'product_direct_checkout', 'yes', $current_config_value ); ?>><?php esc_html_e( 'Yes', 'wpt_pro' ); ?></option>
                            </select>
                            <p style="color: #0071a1;padding: 0;margin: 0;"><?php esc_html_e( 'Direct going to Checkout Page just after Added to cart for each product', 'wpt_pro' ); ?></p>
                        </td>
                    </tr>
                    <tr> 
                        <th><label class="wpt_label" for="wpt_table_disable_cat_tag_link"><?php echo sprintf(esc_html__( 'Disable %s[Categories and Tags]%s Link', 'wpt_pro' ), '<strong>', '</strong>' ); ?></label> </th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[disable_cat_tag_link]" id="wpt_table_disable_cat_tag_link" class="wpt_fullwidth ua_input" >
                                <option value="1" <?php wpt_selected( 'disable_cat_tag_link', '1', $current_config_value ); ?>><?php esc_html_e( 'Yes', 'wpt_pro' ); ?></option>
                                <option value="0" <?php wpt_selected( 'disable_cat_tag_link', '0', $current_config_value ); ?>><?php esc_html_e( 'No', 'wpt_pro' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr> 
                        <th> <label class="wpt_label" for="wpt_table_disable_loading_more"><?php echo sprintf(esc_html__( 'Disable %s[Load More]%s Button', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[disable_loading_more]" id="wpt_table_disable_loading_more" class="wpt_fullwidth ua_input" >
                                <option value="load_more_hidden" <?php wpt_selected( 'disable_loading_more', 'load_more_hidden', $current_config_value ); ?>><?php esc_html_e( 'Yes', 'wpt_pro' ); ?></option>
                                <option value="normal" <?php wpt_selected( 'disable_loading_more', 'normal', $current_config_value ); ?>><?php esc_html_e( 'No', 'wpt_pro' ); ?></option>
                            </select>
                        </td>
                    </tr>

                    <tr> 
                        <th> <label class="wpt_label" for="wpt_table_instant_search_filter"><?php esc_html_e( 'Instant Search Filter', 'wpt_pro' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[instant_search_filter]" id="wpt_table_instant_search_filter" class="wpt_fullwidth ua_input" >
                                <option value="1" <?php wpt_selected( 'instant_search_filter', '1', $current_config_value ); ?>><?php esc_html_e( 'Yes', 'wpt_pro' ); ?></option>
                                <option value="0" <?php wpt_selected( 'instant_search_filter', '0', $current_config_value ); ?>><?php esc_html_e( 'No', 'wpt_pro' ); ?></option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table><?php do_action( 'wpto_admin_configuration_panel_bottom',$settings,$current_config_value ); ?>
        </div>
         <?php
         
    }
}
add_action( 'wpto_admin_configuration_form', 'wpt_configure_basic_part', 5, 3 );

if( !function_exists( 'wpt_configure_label_part' ) ){
    
    function wpt_configure_label_part($settings, $current_config_value,$field_name){
        $page = isset( $settings['page'] ) ? $settings['page'] : 'not_set_page';
        //$current_config_value = get_option( 'wpt_configure_options' );
        ?>
        <div class="section ultraaddons-panel label <?php echo esc_attr( $page ); ?>">
            <h3 class="with-background dark-background"><?php esc_html_e( 'Label Text', 'wpt_pro' );?></h3>
            <table class="ultraaddons-table">
                <tbody>
                    <tr> 
                        <th> <label for="wpt_table_product_not_founded" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Products Not founded!]%s - Message Text', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[product_not_founded]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['product_not_founded']; ?>" id="wpt_table_product_not_founded" type="text" placeholder="<?php esc_attr_e( 'Not founded any products in this query.', 'wpt_pro' ); ?>">
                        </td>
                    </tr>

                    <tr> 
                        <th> <label for="wpt_table_load_more_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Load More]%s - Button Text', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[load_more_text]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['load_more_text']; ?>" id="wpt_table_load_more_text" type="text" placeholder="<?php esc_attr_e( 'Load More text write here', 'wpt_pro' ); ?>">
                        </td>
                    </tr>

                    <tr> 
                        <th>   <label for="wpt_table_search_button_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Search]%s - Button Text', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_button_text]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['search_button_text']; ?>" id="wpt_table_search_button_textt" type="text" placeholder="<?php esc_attr_e( 'Search text write here', 'wpt_pro' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th><label for="wpt_table_search_keyword_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Search Keyword]%s - Text', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_keyword_text]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['search_keyword_text']; ?>" id="wpt_table_search_keyword_text" type="text" placeholder="<?php esc_attr_e( 'Search Keyword', 'wpt_pro' ); ?>">
                        </td>
                    </tr>

                    <tr> 
                        <th><label for="wpt_table_loading_more_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Loading..]%s - Button Text', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[loading_more_text]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['loading_more_text']; ?>" id="wpt_table_loading_more_text" type="text" placeholder="<?php esc_attr_e( 'Loading.. text write here', 'wpt_pro' ); ?>"> 
                        </td>
                    </tr>
                    <tr> 
                        <th> <label for="wpt_table_instant_search_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Instance Search]%s - Text', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[instant_search_text]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['instant_search_text']; ?>" id="wpt_table_instant_search_text" type="text" placeholder="<?php esc_attr_e( 'attr', 'wpt_pro' ); ?>"> 
                        </td>
                    </tr>
                    <tr> 
                        <th> <label for="wpt_table_filter_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Filter]%s - Text of Filter', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[filter_text]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['filter_text']; ?>" id="wpt_table_filter_text" type="text" placeholder="<?php esc_attr_e( 'eg: Filter', 'wpt_pro' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th><label for="wpt_table_filter_reset_button" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Reset]%s - Button Text of Filter', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[filter_reset_button]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['filter_reset_button']; ?>" id="wpt_table_filter_reset_button" type="text" placeholder="<?php esc_attr_e( 'eg: Reset', 'wpt_pro' ); ?>">
                        </td>
                    </tr>

                    <tr> 
                        <th><label for="wpt_table_item" class="wpt_label"><?php esc_html_e( 'Item [for Singular]', 'wpt_pro' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[item]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['item']; ?>" id="wpt_table_item" type="text" placeholder="<?php esc_attr_e( 'Item | for All selected Button', 'wpt_pro' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th> <label for="wpt_table_items" class="wpt_label"><?php esc_html_e( 'Item [for Plural]', 'wpt_pro' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[items]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['items']; ?>" id="wpt_table_items" type="text" placeholder="<?php esc_attr_e( 'Item | for All selected Button', 'wpt_pro' ); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label class="wpt_label" for="wpt_table_product_count"><?php esc_html_e( 'Item/Products Count system [New]', 'wpt_pro' ); ?></label></th>
                        <td>
                            <select name="<?php echo esc_attr( $field_name ); ?>[item_count]" id="wpt_table_product_count" class="wpt_fullwidth ua_input" >
                                <option value="" <?php wpt_selected( 'item_count', '' ); ?>><?php esc_html_e( 'Products Wise', 'wpt_pro' ); ?></option>
                                <option value="all" <?php wpt_selected( 'item_count', 'all' ); ?>><?php esc_html_e( 'All Items', 'wpt_pro' ); ?></option>
                            </select>

                        </td>
                    </tr>
                    <tr> 
                        <th> <label for="wpt_table_item_add_selct_all" class="wpt_label"><?php esc_html_e( 'Add to Cart all selected [Added] Text', 'wpt_pro' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[add2cart_all_added_text]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['add2cart_all_added_text']; ?>" id="wpt_table_item_add_selct_all" type="text" placeholder="<?php esc_attr_e( 'Added text for [Add to cart Selected]', 'wpt_pro' ); ?>">
                        </td>

                    </tr>

                    <tr> 
                        <th><label for="wpt_table_search_box_title" class="wpt_label"><?php esc_html_e( 'Search Box title', 'wpt_pro' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_title]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['search_box_title']; ?>" id="wpt_table_search_box_title" type="text" placeholder="<?php esc_attr_e( 'Search Box title', 'wpt_pro' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th><label for="wpt_table_search_box_searchkeyword" class="wpt_label"><?php esc_html_e( 'Search Keyword text', 'wpt_pro' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_searchkeyword]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['search_box_searchkeyword']; ?>" id="wpt_table_search_box_searchkeyword" type="text" placeholder="<?php esc_attr_e( 'Search Keyword text', 'wpt_pro' ); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_search_box_orderby" class="wpt_label"><?php esc_html_e( 'SearchBox Order By text', 'wpt_pro' ); ?></label></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_orderby]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['search_box_orderby']; ?>" id="wpt_table_search_box_orderby" type="text" placeholder="<?php esc_attr_e( 'Order By text', 'wpt_pro' ); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_search_eee" class="wpt_label"><?php esc_html_e( 'SearchBox Order text', 'wpt_pro' ); ?></label></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[search_box_order]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['search_box_order']; ?>" id="wpt_table_search_eee" type="text" placeholder="<?php esc_attr_e( 'Order text', 'wpt_pro' ); ?>">
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
        //$current_config_value = get_option( 'wpt_configure_options' );
        ?>
        <div class="section ultraaddons-panel label <?php echo esc_attr( $page ); ?>">
            <h3 class="with-background dark-background"><?php echo sprintf( esc_html__( 'External Plugin\'s %s[YITH]%s ', 'wpt_pro' ),'<span style="color: orange; font-size: 18px;">', '</span>' );?></h3>
            <table class="ultraaddons-table external_plugin">
                <tbody>
                    <tr> 
                        <th><label for="wpt_table_quick_view_btn_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Quick View]%s - Button Text', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[quick_view_btn_text]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['quick_view_btn_text']; ?>" id="wpt_table_quick_view_btn_text" type="text" placeholder="<?php esc_attr_e( 'eg: Quick View', 'wpt_pro' ); ?>">
                            <p style="color: #005082;padding: 0;margin: 0;"><?php echo sprintf(esc_html__( 'Only for %s YITH WooCommerce Quick View%s Plugin', 'wpt_pro' ), '<a target="_blank" href="https://wordpress.org/plugins/yith-woocommerce-quick-view/">', '</a>' ); ?></p>
                        </td>
                    </tr>

                    <tr> 
                        <th> <label for="wpt_table_yith_browse_list" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Browse Quote list]%s - text ', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_browse_list]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['yith_browse_list']; ?>" id="wpt_table_yith_browse_list" type="text" placeholder="<?php esc_attr_e( 'Browse the list - text write here', 'wpt_pro' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th><label for="wpt_table_yith_add_to_quote_text" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Add to Quote]%s - button text', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_add_to_quote_text]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['yith_add_to_quote_text']; ?>" id="wpt_table_yith_add_to_quote_text" type="text" placeholder="<?php esc_attr_e( 'Add to Quote text write here', 'wpt_pro' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th> <label for="wpt_table_yith_add_to_quote_adding" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Quote Adding]%s - text', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_add_to_quote_adding]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['yith_add_to_quote_adding']; ?>" id="wpt_table_yith_add_to_quote_adding" type="text" placeholder="<?php esc_attr_e( 'Adding text write here', 'wpt_pro' ); ?>">
                        </td>
                    </tr>
                    <tr> 
                        <th> <label for="wpt_table_yith_add_to_quote_added" class="wpt_label"><?php echo sprintf(esc_html__( '%s[Quote Added]%s - text ', 'wpt_pro' ), '<b>', '</b>' ); ?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[yith_add_to_quote_added]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['yith_add_to_quote_added']; ?>" id="wpt_table_yith_add_to_quote_added" type="text" placeholder="<?php esc_attr_e( 'Quote Added text write here', 'wpt_pro' ); ?>">
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
        //$current_config_value = get_option( 'wpt_configure_options' );
        // label <?php echo esc_attr( $page ); "
        ?>
        <div class="section ultraaddons-panel default_content <?php echo esc_attr( $page );?>">
            <h3 class="with-background dark-background"><?php echo sprintf( esc_html__( 'Table\'s Default Content %sSince 3.3%s', 'wpt_pro' ), '<small style="color: orange; font-size: 12px;">', '</small>' );?></h3>
            <table class="ultraaddons-table">
                <tbody>
                    <tr>
                        <th><label for="wpt_table_table_in_stock" class="wpt_label"><?php esc_html_e( '[In Stock] for Table Column', 'wpt_pro' );?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[table_in_stock]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['table_in_stock']; ?>" id="wpt_table_table_in_stock" type="text" placeholder="<?php esc_attr_e( 'In Stock', 'wpt_pro' );?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_table_out_of_stock" class="wpt_label"><?php esc_html_e( '[Out of Stock] for Table Column', 'wpt_pro' );?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[table_out_of_stock]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['table_out_of_stock']; ?>" id="wpt_table_table_out_of_stock" type="text" placeholder="<?php esc_attr_e( 'Out of Stock', 'wpt_pro' );?>">
                        </td>
                    </tr>

                    <tr>
                        <th><label for="wpt_table_table_on_back_order" class="wpt_label"><?php esc_html_e( '[On Back Order] for Table Column', 'wpt_pro' );?></label></th>
                        <td>
                            <input name="<?php echo esc_attr( $field_name ); ?>[table_on_back_order]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['table_on_back_order']; ?>" id="wpt_table_table_on_back_order" type="text" placeholder="<?php esc_attr_e( 'On Back Order', 'wpt_pro' );?>">
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
        //$current_config_value = get_option( 'wpt_configure_options' );
        // label <?php echo esc_attr( $page ); "
        ?>
        <div class="section ultraaddons-panel all_message <?php echo esc_attr( $page ); ?>">
            <h3 class="with-background dark-background"><?php esc_html_e( 'All Messages', 'wpt_pro' );?></h3>
            <table class="ultraaddons-table wpt_all_messages">
                <tbody>
                    <tr>
                        <th><label for="wpt_table_right_combination_message" class="wpt_label"><?php esc_html_e( 'Variations [Not available] Message', 'wpt_pro' );?></label></th>
                        <td> 
                            <input name="<?php echo esc_attr( $field_name ); ?>[right_combination_message]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['right_combination_message']; ?>" id="wpt_table_right_combination_message" type="text" placeholder="<?php esc_attr_e( 'Not Available', 'wpt_pro' );?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_right_combination_message_alt" class="wpt_label"><?php esc_html_e( '[Product variations is not set Properly. May be: price is not inputted. may be: Out of Stock.] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[right_combination_message_alt]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['right_combination_message_alt']; ?>" id="wpt_table_right_combination_message_alt" type="text" placeholder="<?php esc_attr_e( 'Product variations is not set Properly. May be: price is not inputted. may be: Out of Stock.', 'wpt_pro' );?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_select_all_items_message" class="wpt_label"><?php esc_html_e( '[Please select all items.] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[select_all_items_message]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['select_all_items_message']; ?>" id="wpt_table_select_all_items_message" type="text" placeholder="<?php esc_attr_e( 'Please select all items.', 'wpt_pro' );?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_out_of_stock_message" class="wpt_label"><?php esc_html_e( '[Out of Stock] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[out_of_stock_message]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['out_of_stock_message']; ?>" id="wpt_table_out_of_stock_message" type="text" placeholder="<?php esc_attr_e( 'Out of Stock', 'wpt_pro' );?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_no_more_query_message" class="wpt_label"><?php esc_html_e( '[There is no more products based on current Query.] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[no_more_query_message]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['no_more_query_message']; ?>" id="wpt_table_no_more_query_message" type="text" placeholder="<?php esc_attr_e( 'There is no more products based on current Query.', 'wpt_pro' );?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_out_adding_progress" class="wpt_label"><?php esc_html_e( '[ Adding in Progress ] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[adding_in_progress]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['adding_in_progress']; ?>" id="wpt_table_out_adding_progress" type="text" placeholder="<?php esc_attr_e( 'Adding in Progress', 'wpt_pro' );?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_no_right_comb" class="wpt_label"><?php esc_html_e( '[ No Right Combination ] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[no_right_combination]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['no_right_combination']; ?>" id="wpt_table_no_right_comb" type="text" placeholder="<?php esc_attr_e( 'No Right Combination', 'wpt_pro' );?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_sorry_plz_right_combination" class="wpt_label"><?php esc_html_e( '[ Sorry, Please choose right combination. ] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[sorry_plz_right_combination]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['sorry_plz_right_combination']; ?>" id="wpt_table_sorry_plz_right_combination" type="text" placeholder="<?php esc_attr_e( 'Sorry, Please choose right combination.', 'wpt_pro' );?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_sorry_out_stock" class="wpt_label"><?php esc_html_e( '[ Sorry! Out of Stock! ] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[sorry_out_of_stock]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['sorry_out_of_stock']; ?>" id="wpt_table_sorry_out_stock" type="text" placeholder="<?php esc_attr_e( 'Sorry! Out of Stock!', 'wpt_pro' );?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wpt_table_type_your_message" class="wpt_label"><?php esc_html_e( '[Type your Message.] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="<?php echo esc_attr( $field_name ); ?>[type_your_message]" class="wpt_data_filed_atts ua_input" value="<?php echo $current_config_value['type_your_message']; ?>" id="wpt_table_type_your_message" type="text" placeholder="<?php esc_attr_e( 'Type your Message.', 'wpt_pro' );?>">
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
            <button name="configure_submit" class="button-primary primary button">Save All</button>
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
        <div class="wpt-pro-only-featues <?php echo esc_attr( $value ); ?>">
            
            <img src="<?php echo esc_attr( $img_url . $value . '.png' ); ?>">
        </div>
         <?php
    }
}
add_action( 'wpo_pro_feature_message', 'wpt_profeatures_message_box' );