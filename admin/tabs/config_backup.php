<?php
$config = $wpt_post_config =  get_post_meta( $post->ID, 'config', true );

if( !is_array( $config ) ){
    $config = get_option( 'wpt_configure_options' );
}

function wpt_selected_data(  $wpt_post_config, $keyword, $gotten_value ){
    $config = isset( $wpt_post_config ) && is_array( $wpt_post_config ) && count( $wpt_post_config ) > 0 ? $wpt_post_config : get_option( 'wpt_configure_options' );
    
    
    //echo ( isset( $config[$keyword] ) && $config[$keyword] == $gotten_value ? 'selected' : false  );
}
?>


<input name="config[plugin_version]" type="hidden" value="<?php echo WOO_Product_Table::getVersion(); ?>" style="">
<input name="config[plugin_name]" type="hidden" value="<?php echo WOO_Product_Table::getName(); ?>" style="">
<div style="padding-top: 15px;padding-bottom: 15px;" class="fieldwrap wpt_result_footer">
        <span class="configure_section_title"><?php esc_html_e( 'Basic Settings', 'wpt_pro' );?></span><?php wpt_selected_data(  $wpt_post_config, 'custom_add_to_cart',  'add_cart_no_icon' );?>
        <table class="wpt_config_form">
            <tbody>
                <tr>
                    <div class="wpt_column">
                        <th><label class="wpt_label" for="wpt_table_custom_add_to_cart"><?php esc_html_e( 'Add to Cart Icon', 'wpt_pro' );?></label></th>
                        <td>
                            <select name="config[custom_add_to_cart]" id="wpt_table_custom_add_to_cart" class="wpt_fullwidth" >
                                <option value="add_cart_no_icon" <?php wpt_selected_data(  $wpt_post_config, 'custom_add_to_cart',  'add_cart_no_icon' );?>><?php esc_html_e( 'No Icon', 'wpt_pro' );?></option>
                                <option value="add_cart_only_icon" <?php wpt_selected_data(  $wpt_post_config, 'custom_add_to_cart',  'add_cart_only_icon' );?>><?php esc_html_e( 'Only Icon', 'wpt_pro' );?></option>
                                <option value="add_cart_left_icon" <?php wpt_selected_data(  $wpt_post_config, 'custom_add_to_cart',  'add_cart_left_icon' );?>><?php esc_html_e( 'Left Icon and Text', 'wpt_pro' );?></option>
                                <option value="add_cart_right_icon" <?php wpt_selected_data(  $wpt_post_config, 'custom_add_to_cart',  'add_cart_right_icon' );?>><?php esc_html_e( 'Text and Right Icon', 'wpt_pro' );?></option>
                            </select>

                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label class="wpt_label" for="wpt_table_footer_cart"><?php esc_html_e( 'Footer Cart Option', 'wpt_pro' );?></label></th>
                        <td>
                            <select name="config[footer_cart]" id="wpt_table_footer_cart" class="wpt_fullwidth" >
                                <option value="hide_for_zerro" <?php wpt_selected_data(  $wpt_post_config, 'footer_cart',  'hide_for_zerro' );?>><?php esc_html_e( 'Hide for Zero', 'wpt_pro' );?></option>
                                <option value="always_show" <?php wpt_selected_data(  $wpt_post_config, 'footer_cart',  'always_show' );?>><?php esc_html_e( 'Always Show', 'wpt_pro' );?></option>
                                <option value="always_hide" <?php wpt_selected_data(  $wpt_post_config, 'footer_cart',  'always_hide' );?>><?php esc_html_e( 'Always Hide', 'wpt_pro' );?></option>
                            </select>

                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th> <label for="wpt_table_footer_bg_color" class="wpt_label"><?php esc_html_e( 'Footer Cart BG Color', 'wpt_pro' );?></label></th>
                        <td>
                          <input name="config[footer_bg_color]" class="wpt_data_filed_atts wpt_color_picker" value="<?php echo $config['footer_bg_color']; ?>" id="wpt_table_footer_bg_colort" type="text" placeholder="<?php esc_attr_e( 'BG Color', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label class="wpt_label" for="wpt_table_footer_possition"><?php esc_html_e( 'Footer Cart Position', 'wpt_pro' );?></label></th>
                        <td>
                            <select name="config[footer_possition]" id="wpt_table_footer_possition" class="wpt_fullwidth" >
                                <option value="bottom_right" <?php wpt_selected_data(  $wpt_post_config, 'footer_possition',  'bottom_right' );?>><?php esc_html_e( 'Bottom Right', 'wpt_pro' );?></option>
                                <option value="bottom_left" <?php wpt_selected_data(  $wpt_post_config, 'footer_possition',  'bottom_left' );?>><?php esc_html_e( 'Bottom Left', 'wpt_pro' );?></option>
                                <option value="top_right" <?php wpt_selected_data(  $wpt_post_config, 'footer_possition',  'top_right' );?>><?php esc_html_e( 'Top Right', 'wpt_pro' );?></option>
                                <option value="top_left" <?php wpt_selected_data(  $wpt_post_config, 'footer_possition',  'top_left' );?>><?php esc_html_e( 'Top Left', 'wpt_pro' );?></option>
                            </select>

                        </td>
                     </div>
                </tr>

                <tr>
                    <div class="wpt_column">
                        <th><label class="wpt_label" for="wpt_table_footer_cart_size"><?php echo sprintf( esc_html__('Footer Cart Size %s[Only Int]%s', 'wpt_pro'),'<small>', '</small>' );?></label></th>
                        <td>
                            <input name="config[footer_cart_size]" class="wpt_data_filed_atts" value="<?php echo $config['footer_cart_size']; ?>" id="wpt_table_thumbs_image_size" type="number" placeholder="<?php esc_attr_e( 'Default Size. eg: 70', 'wpt_pro' );?>" min="50" max="" pattern="[0-9]*" inputmode="numeric">
                        </td>
                     </div>
                </tr>


                <tr>
                    <div class="wpt_column">
                        <th><label class="wpt_label" for="wpt_table_sort_mini_filter"><?php esc_html_e( 'Mini Filter Sorting', 'wpt_pro' );?></label></th>
                        <td>
                            <select name="config[sort_mini_filter]" id="wpt_table_sort_mini_filter" class="wpt_fullwidth" >
                                <option value="0" <?php wpt_selected_data(  $wpt_post_config, 'sort_mini_filter',  '0' );?>><?php esc_html_e( 'None', 'wpt_pro' );?></option>
                                <option value="ASC" <?php wpt_selected_data(  $wpt_post_config, 'sort_mini_filter',  'ASC' );?>><?php esc_html_e( 'Ascending', 'wpt_pro' );?></option>
                                <option value="DESC" <?php wpt_selected_data(  $wpt_post_config, 'sort_mini_filter',  'DESC' );?>><?php esc_html_e( 'Descending', 'wpt_pro' );?></option>
                            </select>

                        </td>
                     </div>
                </tr>

                <tr>
                    <div class="wpt_column">
                        <th><label class="wpt_label" for="wpt_table_sort_searchbox_filter"><?php esc_html_e( 'Search Box Taxonomy Sorting', 'wpt_pro' );?></label></th>
                        <td>
                            <select name="config[sort_searchbox_filter]" id="wpt_table_sort_mini_filter" class="wpt_fullwidth" >
                                <option value="0" <?php wpt_selected_data(  $wpt_post_config, 'sort_searchbox_filter',  '0' );?>><?php esc_html_e( 'None', 'wpt_pro' );?></option>
                                <option value="ASC" <?php wpt_selected_data(  $wpt_post_config, 'sort_searchbox_filter',  'ASC' );?>><?php esc_html_e( 'Ascending', 'wpt_pro' );?></option>
                                <option value="DESC" <?php wpt_selected_data(  $wpt_post_config, 'sort_searchbox_filter',  'DESC' );?>><?php esc_html_e( 'Descending', 'wpt_pro' );?></option>
                            </select>
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label class="wpt_label" for="wpt_table_thumbs_image_size"><?php echo sprintf( esc_html__('Thumbs Image Size %s[Only Int]%s', 'wpt_pro'),'<small>', '</small>' );?></label></th>
                        <td>
                            <input name="config[thumbs_image_size]" class="wpt_data_filed_atts" value="<?php echo $config['thumbs_image_size']; ?>" id="wpt_table_thumbs_image_size" type="number" placeholder="<?php esc_attr_e( 'Thumbnail size. eg: 56', 'wpt_pro' );?>" min="16" max="" pattern="[0-9]*" inputmode="numeric">
                        </td>
                     </div>
                </tr>

                <tr> 
                    <!-- New at Version: 3.9 -->
                    <div class="wpt_column">
                        <th><label class="wpt_label" for="wpt_table_popup_notice"><?php esc_html_e( 'Popup Notice [New]', 'wpt_pro' );?></label></th>
                        <td>
                           <select name="config[popup_notice]" id="wpt_table_popup_notice" class="wpt_fullwidth" >
                                <option value="1" <?php wpt_selected_data(  $wpt_post_config, 'popup_notice',  '1' );?>><?php esc_html_e( 'Enable', 'wpt_pro' );?></option>
                                <option value="0" <?php wpt_selected_data(  $wpt_post_config, 'popup_notice',  '0' );?>><?php esc_html_e( 'Disable', 'wpt_pro' );?></option>
                            </select>
                        </td>
                     </div>
                </tr>


                <tr> 
                    <!-- New at Version: 3.1 -->
                    <div class="wpt_column">
                        <th><label class="wpt_label" for="wpt_table_thumbs_lightbox"><?php esc_html_e( 'Thumbs Image LightBox', 'wpt_pro' );?></label></th>
                        <td>
                           <select name="config[thumbs_lightbox]" id="wpt_table_thumbs_lightbox" class="wpt_fullwidth" >
                                <option value="1" <?php wpt_selected_data(  $wpt_post_config, 'thumbs_lightbox',  '1' );?>><?php esc_html_e( 'Enable', 'wpt_pro' );?></option>
                                <option value="0" <?php wpt_selected_data(  $wpt_post_config, 'thumbs_lightbox',  '0' );?>><?php esc_html_e( 'Disable', 'wpt_pro' );?></option>
                            </select>
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th> <label class="wpt_label" for="wpt_table_disable_product_link"><?php esc_html_e( 'Disable Product Link', 'wpt_pro' );?></label></th>
                        <td>
                            <select name="config[disable_product_link]" id="wpt_table_disable_product_link" class="wpt_fullwidth" >
                                <option value="1" <?php wpt_selected_data(  $wpt_post_config, 'disable_product_link',  '1' );?>><?php esc_html_e( 'Yes', 'wpt_pro' );?></option>
                                <option value="0" <?php wpt_selected_data(  $wpt_post_config, 'disable_product_link',  '0' );?>><?php esc_html_e( 'No', 'wpt_pro' );?></option>
                            </select>
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th>  <label class="wpt_label" for="wpt_table_product_link_target"><?php esc_html_e( 'Product Link Open Type', 'wpt_pro' );?></label>
                        <td>
                            <select name="config[product_link_target]" id="wpt_table_disable_product_link" class="wpt_fullwidth" >
                                <option value="_blank" <?php wpt_selected_data(  $wpt_post_config, 'product_link_target',  '_blank' );?>><?php esc_html_e( 'New Tab', 'wpt_pro' );?></option>
                                <option value="_self" <?php wpt_selected_data(  $wpt_post_config, 'product_link_target',  '_self' );?>><?php esc_html_e( 'Self Tab', 'wpt_pro' );?></option>
                            </select>
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th><label class="wpt_label" for="wpt_table_all_selected_direct_checkout"><?php esc_html_e( 'Direct Checkout Page[for Add to cart Selected]', 'wpt_pro' );?></label></th>
                        <td>
                            <select name="config[all_selected_direct_checkout]" id="wpt_table_all_selected_direct_checkout" class="wpt_fullwidth" >
                                <option value="no" <?php wpt_selected_data(  $wpt_post_config, 'all_selected_direct_checkout',  'no' );?>><?php esc_html_e( 'No', 'wpt_pro' );?></option>
                                <option value="yes" <?php wpt_selected_data(  $wpt_post_config, 'all_selected_direct_checkout',  'yes' );?>><?php esc_html_e( 'Yes', 'wpt_pro' );?></option>
                            </select>
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th> <label class="wpt_label" for="wpt_table_product_direct_checkout"><?php esc_html_e( 'Enable Quick Buy Button [Direct Checkout Page for each product]', 'wpt_pro' );?></label></th>
                        <td>
                            <select name="config[product_direct_checkout]" id="wpt_table_product_direct_checkout" class="wpt_fullwidth" >
                                <option value="no" <?php wpt_selected_data(  $wpt_post_config, 'product_direct_checkout',  'no' );?>><?php esc_html_e( 'No', 'wpt_pro' );?></option>
                                <option value="yes" <?php wpt_selected_data(  $wpt_post_config, 'product_direct_checkout',  'yes' );?>><?php esc_html_e( 'Yes', 'wpt_pro' );?></option>
                            </select>
                            <p style="color: #0071a1;padding: 0;margin: 0;"><?php esc_html_e( 'Direct going to Checkout Page just after Added to cart for each product', 'wpt_pro' );?></p>
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th><label class="wpt_label" for="wpt_table_disable_cat_tag_link"><?php echo sprintf( esc_html__('Disable %s[Categories and Tags]%s Link', 'wpt_pro'),'<strong>', '</strong>' );?></label> </th>
                        <td>
                            <select name="config[disable_cat_tag_link]" id="wpt_table_disable_product_link" class="wpt_fullwidth" >
                                <option value="1" <?php wpt_selected_data(  $wpt_post_config, 'disable_cat_tag_link',  '1' );?>><?php esc_html_e( 'Yes', 'wpt_pro' );?></option>
                                <option value="0" <?php wpt_selected_data(  $wpt_post_config, 'disable_cat_tag_link',  '0' );?>><?php esc_html_e( 'No', 'wpt_pro' );?></option>
                            </select>
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th> <label class="wpt_label" for="wpt_table_disable_loading_more"><?php echo sprintf( esc_html__('Disable %s[Load More]%s Button', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                            <select name="config[disable_loading_more]" id="wpt_table_disable_loading_more" class="wpt_fullwidth" >
                                <option value="load_more_hidden" <?php wpt_selected_data(  $wpt_post_config, 'disable_loading_more',  'load_more_hidden' );?>><?php esc_html_e( 'Yes', 'wpt_pro' );?></option>
                                <option value="normal" <?php wpt_selected_data(  $wpt_post_config, 'disable_loading_more',  'normal' );?>><?php esc_html_e( 'No', 'wpt_pro' );?></option>
                            </select>
                        </td>
                     </div>
                </tr>

                <tr> 
                    <div class="wpt_column">
                        <th> <label class="wpt_label" for="wpt_table_instant_search_filter"><?php esc_html_e( 'Instant Search Filter', 'wpt_pro' );?></label></th>
                        <td>
                           <select name="config[instant_search_filter]" id="wpt_table_instant_search_filter" class="wpt_fullwidth" >
                                <option value="1" <?php wpt_selected_data(  $wpt_post_config, 'instant_search_filter',  '1' );?>><?php esc_html_e( 'Yes', 'wpt_pro' );?></option>
                                <option value="0" <?php wpt_selected_data(  $wpt_post_config, 'instant_search_filter',  '0' );?>><?php esc_html_e( 'No', 'wpt_pro' );?></option>
                            </select>
                        </td>
                     </div>
                </tr>
            </tbody>
        </table>
        <span class="configure_section_title"><?php esc_html_e( 'Label Text', 'wpt_pro' );?></span>
        <table class="wpt_config_form">
            <tbody>
                <tr> 
                    <div class="wpt_column">
                        <th> <label for="wpt_table_product_not_founded" class="wpt_label"><?php echo sprintf( esc_html__('%s[Products Not founded!]%s - Message Text', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                          <input name="config[product_not_founded]" class="wpt_data_filed_atts" value="<?php echo $config['product_not_founded']; ?>" id="wpt_table_product_not_founded" type="text" placeholder="<?php esc_attr_e( 'Not founded any products in this query.', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>

                <tr> 
                    <div class="wpt_column">
                        <th> <label for="wpt_table_load_more_text" class="wpt_label"><?php echo sprintf( esc_html__('%s[Load More]%s - Button Text', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                          <input name="config[load_more_text]" class="wpt_data_filed_atts" value="<?php echo $config['load_more_text']; ?>" id="wpt_table_load_more_text" type="text" placeholder="<?php esc_attr_e( 'Load More text write here', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>

                <tr> 
                    <div class="wpt_column">
                        <th>   <label for="wpt_table_search_button_text" class="wpt_label"><?php echo sprintf( esc_html__('%s[Search]%s - Button Text', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                           <input name="config[search_button_text]" class="wpt_data_filed_atts" value="<?php echo $config['search_button_text']; ?>" id="wpt_table_search_button_textt" type="text" placeholder="<?php esc_attr_e( 'Search text write here', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th><label for="wpt_table_search_keyword_text" class="wpt_label"><?php echo sprintf( esc_html__( '%s[Search Keyword]%s - Text',  'wpt_pro' ), '<b>',  '</b>'  );?></label></th>
                        <td>
                            <input name="config[search_keyword_text]" class="wpt_data_filed_atts" value="<?php echo $config['search_keyword_text']; ?>" id="wpt_table_search_button_textt" type="text" placeholder="<?php esc_attr_e( 'Search Keyword', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>

                <tr> 
                    <div class="wpt_column">
                        <th><label for="wpt_table_loading_more_text" class="wpt_label"><?php  echo sprintf( esc_html__('%s[Loading..]%s - Button Text', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                          <input name="config[loading_more_text]" class="wpt_data_filed_atts" value="<?php echo $config['loading_more_text']; ?>" id="wpt_table_loading_more_text" type="text" placeholder="<?php esc_attr_e( 'Loading.. text write here', 'wpt_pro' );?>"> 
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th> <label for="wpt_table_instant_search_textt" class="wpt_label"><?php echo sprintf( esc_html__('%s[Instance Search]%s - Text', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                          <input name="config[instant_search_text]" class="wpt_data_filed_atts" value="<?php echo $config['instant_search_text']; ?>" id="wpt_table_instant_search_text" type="text" placeholder="<?php esc_attr_e( 'attr', 'wpt_pro' );?>"> 
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th> <label for="wpt_table_filter_text" class="wpt_label"><?php  echo sprintf( esc_html__('%s[Filter]%s - Text of Filter', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                            <input name="config[filter_text]" class="wpt_data_filed_atts" value="<?php echo $config['filter_text']; ?>" id="wpt_table_filter_text" type="text" placeholder="<?php esc_attr_e( 'eg: Filter', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th><label for="wpt_table_filter_reset_button" class="wpt_label"><?php  echo sprintf( esc_html__('%s[Reset]%s - Button Text of Filter', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                           <input name="config[filter_reset_button]" class="wpt_data_filed_atts" value="<?php echo $config['filter_reset_button']; ?>" id="wpt_table_filter_reset_button" type="text" placeholder="<?php esc_attr_e( 'eg: Reset', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>

                <tr> 
                    <div class="wpt_column">
                        <th><label for="wpt_table_item" class="wpt_label"><?php esc_html_e( 'Item [for Singular]', 'wpt_pro' );?></label></th>
                        <td>
                         <input name="config[item]" class="wpt_data_filed_atts" value="<?php echo $config['item']; ?>" id="wpt_table_item" type="text" placeholder="<?php esc_attr_e( 'Item | for All selected Button', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th> <label for="wpt_table_item" class="wpt_label"><?php esc_html_e( 'Item [for Plural]', 'wpt_pro' );?></label></th>
                        <td>
                         <input name="config[items]" class="wpt_data_filed_atts" value="<?php echo $config['items']; ?>" id="wpt_table_item" type="text" placeholder="<?php esc_attr_e( 'Item | for All selected Button', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>

                <tr> 
                    <div class="wpt_column">
                        <th> <label for="wpt_table_item" class="wpt_label"><?php esc_html_e( 'Add to Cart all selected [Added] Text', 'wpt_pro' );?></label></th>
                        <td>
                            <input name="config[add2cart_all_added_text]" class="wpt_data_filed_atts" value="<?php echo $config['add2cart_all_added_text']; ?>" id="wpt_table_item" type="text" placeholder="<?php esc_attr_e( 'Added text for [Add to cart Selected]', 'wpt_pro' );?>">
                        </td>
                    </div>

                </tr>

                <tr> 
                    <div class="wpt_column">
                        <th><label for="wpt_table_search_box_title" class="wpt_label"><?php esc_html_e( 'Search Box title', 'wpt_pro' );?></label></th>
                        <td>
                         <input name="config[search_box_title]" class="wpt_data_filed_atts" value="<?php echo $config['search_box_title']; ?>" id="wpt_table_search_box_title" type="text" placeholder="<?php esc_attr_e( 'Search Box title', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th><label for="wpt_table_search_box_searchkeyword" class="wpt_label"><?php esc_html_e( 'Search Keyword text', 'wpt_pro' );?></label></th>
                        <td>
                         <input name="config[search_box_searchkeyword]" class="wpt_data_filed_atts" value="<?php echo $config['search_box_searchkeyword']; ?>" id="wpt_table_search_box_searchkeyword" type="text" placeholder="<?php esc_attr_e( 'Search Keyword text', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_search_box_orderby" class="wpt_label"><?php esc_html_e( 'SearchBox Order By text', 'wpt_pro' );?></label></label></th>
                        <td>
                            <input name="config[search_box_orderby]" class="wpt_data_filed_atts" value="<?php echo $config['search_box_orderby']; ?>" id="wpt_table_search_box_orderby" type="text" placeholder="<?php esc_attr_e( 'Order By text', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_search_box_order" class="wpt_label"><?php esc_html_e( 'SearchBox Order text', 'wpt_pro' );?></label></label></th>
                        <td>
                            <input name="config[search_box_order]" class="wpt_data_filed_atts" value="<?php echo $config['search_box_order']; ?>" id="wpt_table_search_box_title" type="text" placeholder="<?php esc_attr_e( 'Order text', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
            </tbody>
        </table>
        <span class="configure_section_title"><?php echo sprintf( esc_html__('External Plugin\'s %s[YITH]%s ', 'wpt_pro'),'<span style="color: orange; font-size: 18px;">', '</span>' );?></span>
        <table class="wpt_config_form external_plugin">
            <tbody>
                 <tr> 
                    <!-- Quick View Button Text -->
                    <div class="wpt_column">
                        <th><label for="wpt_table_quick_view_btn_text" class="wpt_label"><?php echo sprintf( esc_html__('%s[Quick View]%s - Button Text', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                          <input name="config[quick_view_btn_text]" class="wpt_data_filed_atts" value="<?php echo $config['quick_view_btn_text']; ?>" id="wpt_table_quick_view_btn_text" type="text" placeholder="<?php esc_attr_e( 'eg: Quick View', 'wpt_pro' );?>">
                          <p style="color: #005082;padding: 0;margin: 0;"><?php echo sprintf( esc_html__('Only for %s YITH WooCommerce Quick View%s Plugin', 'wpt_pro'),'<a target="_blank" href="https://wordpress.org/plugins/yith-woocommerce-quick-view/">', '</a>' );?></p>
                        </td>
                     </div>
                </tr>

                 <tr> 
                    <div class="wpt_column">
                        <th> <label for="wpt_table_yith_browse_list" class="wpt_label"><?php echo sprintf( esc_html__('%s[Browse Quote list]%s - text ', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                          <input name="config[yith_browse_list]" class="wpt_data_filed_atts" value="<?php echo $config['yith_browse_list']; ?>" id="wpt_table_yith_add_to_quote_text" type="text" placeholder="<?php esc_attr_e( 'Browse the list - text write here', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th><label for="wpt_table_yith_add_to_quote_text" class="wpt_label"><?php echo sprintf( esc_html__('%s[Add to Quote]%s - button text', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                           <input name="config[yith_add_to_quote_text]" class="wpt_data_filed_atts" value="<?php echo $config['yith_add_to_quote_text']; ?>" id="wpt_table_yith_add_to_quote_text" type="text" placeholder="<?php esc_attr_e( 'Add to Quote text write here', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th> <label for="wpt_table_yith_add_to_quote_adding" class="wpt_label"><?php echo sprintf( esc_html__('%s[Quote Adding]%s - text', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                          <input name="config[yith_add_to_quote_adding]" class="wpt_data_filed_atts" value="<?php echo $config['yith_add_to_quote_adding']; ?>" id="wpt_table_yith_add_to_quote_adding" type="text" placeholder="<?php esc_attr_e( 'Adding text write here', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr> 
                    <div class="wpt_column">
                        <th> <label for="wpt_table_yith_add_to_quote_added" class="wpt_label"><?php echo sprintf( esc_html__('%s[Quote Added]%s - text ', 'wpt_pro'),'<b>', '</b>' );?></label></th>
                        <td>
                         <input name="config[yith_add_to_quote_added]" class="wpt_data_filed_atts" value="<?php echo $config['yith_add_to_quote_added']; ?>" id="wpt_table_yith_add_to_quote_added" type="text" placeholder="<?php esc_attr_e( 'Quote Added text write here', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
            </tbody>
        </table>

        <span class="configure_section_title"><?php echo sprintf( esc_html__('Table\'s Default Content %sSince 3.3%s', 'wpt_pro'), '<small style="color: orange; font-size: 12px;">', '</small>' );?></span>
        <table class="wpt_config_form">
            <tbody>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_table_in_stock" class="wpt_label"><?php esc_html_e( '[In Stock] for Table Column', 'wpt_pro' );?></label></th>
                        <td>
                            <input name="config[table_in_stock]" class="wpt_data_filed_atts" value="<?php echo $config['table_in_stock']; ?>" id="wpt_table_table_in_stock" type="text" placeholder="<?php esc_attr_e( 'In Stock', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_table_out_of_stock" class="wpt_label"><?php esc_html_e( '[Out of Stock] for Table Column', 'wpt_pro' );?></label></th>
                        <td>
                            <input name="config[table_out_of_stock]" class="wpt_data_filed_atts" value="<?php echo $config['table_out_of_stock']; ?>" id="wpt_table_table_out_of_stock" type="text" placeholder="<?php esc_attr_e( 'Out of Stock', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>

                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_table_on_back_order" class="wpt_label"><?php esc_html_e( '[On Back Order] for Table Column', 'wpt_pro' );?></label></th>
                        <td>
                            <input name="config[table_on_back_order]" class="wpt_data_filed_atts" value="<?php echo $config['table_on_back_order']; ?>" id="wpt_table_table_on_back_order" type="text" placeholder="<?php esc_attr_e( 'On Back Order', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>

            </tbody>
        </table>

        <!-- Here was Table of MiniCart's default content. We have keep backup to backup_configuration.php -->

        <span class="configure_section_title"><?php esc_html_e( 'All Messages', 'wpt_pro' );?></span>
        <table class="wpt_config_form wpt_all_messages">
            <tbody>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_right_combination_message" class="wpt_label"><?php esc_html_e( 'Variations [Not available] Message', 'wpt_pro' );?></label></th>
                        <td> 
                            <input name="config[right_combination_message]" class="wpt_data_filed_atts" value="<?php echo $config['right_combination_message']; ?>" id="wpt_table_right_combination_message" type="text" placeholder="<?php esc_attr_e( 'Not Available', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_right_combination_message_alt" class="wpt_label"><?php esc_html_e( '[Product variations is not set Properly. May be: price is not inputted. may be: Out of Stock.] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="config[right_combination_message_alt]" class="wpt_data_filed_atts" value="<?php echo $config['right_combination_message_alt']; ?>" id="wpt_table_right_combination_message_alt" type="text" placeholder="<?php esc_attr_e( 'Product variations is not set Properly. May be: price is not inputted. may be: Out of Stock.', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_select_all_items_message" class="wpt_label"><?php esc_html_e( '[Please select all items.] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="config[select_all_items_message]" class="wpt_data_filed_atts" value="<?php echo $config['select_all_items_message']; ?>" id="wpt_table_select_all_items_message" type="text" placeholder="<?php esc_attr_e( 'Please select all items.', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_out_of_stock_message" class="wpt_label"><?php esc_html_e( '[Out of Stock] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="config[out_of_stock_message]" class="wpt_data_filed_atts" value="<?php echo $config['out_of_stock_message']; ?>" id="wpt_table_out_of_stock_message" type="text" placeholder="<?php esc_attr_e( 'Out of Stock', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_no_more_query_message" class="wpt_label"><?php esc_html_e( '[There is no more products based on current Query.] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="config[no_more_query_message]" class="wpt_data_filed_atts" value="<?php echo $config['no_more_query_message']; ?>" id="wpt_table_out_of_stock_message" type="text" placeholder="<?php esc_attr_e( 'There is no more products based on current Query.', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_out_of_stock_message" class="wpt_label"><?php esc_html_e( '[ Adding in Progress ] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="config[adding_in_progress]" class="wpt_data_filed_atts" value="<?php echo $config['adding_in_progress']; ?>" id="wpt_table_out_of_stock_message" type="text" placeholder="<?php esc_attr_e( 'Adding in Progress', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_out_of_stock_message" class="wpt_label"><?php esc_html_e( '[ No Right Combination ] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="config[no_right_combination]" class="wpt_data_filed_atts" value="<?php echo $config['no_right_combination']; ?>" id="wpt_table_out_of_stock_message" type="text" placeholder="<?php esc_attr_e( 'No Right Combination', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_sorry_plz_right_combination" class="wpt_label"><?php esc_html_e( '[ Sorry, Please choose right combination. ] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="config[sorry_plz_right_combination]" class="wpt_data_filed_atts" value="<?php echo $config['sorry_plz_right_combination']; ?>" id="wpt_table_sorry_plz_right_combination" type="text" placeholder="<?php esc_attr_e( 'Sorry, Please choose right combination.', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                    <div class="wpt_column">
                        <th><label for="wpt_table_out_of_stock_message" class="wpt_label"><?php esc_html_e( '[ Sorry! Out of Stock! ] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="config[sorry_out_of_stock]" class="wpt_data_filed_atts" value="<?php echo $config['sorry_out_of_stock']; ?>" id="wpt_table_out_of_stock_message" type="text" placeholder="<?php esc_attr_e( 'Sorry! Out of Stock!', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
                <tr>
                     <!-- New Added at Version 3.1 -->
                    <div class="wpt_column">
                        <th><label for="wpt_table_type_your_message" class="wpt_label"><?php esc_html_e( '[Type your Message.] Message', 'wpt_pro' );?></label></th>
                        <td>    
                            <input name="config[type_your_message]" class="wpt_data_filed_atts" value="<?php echo $config['type_your_message']; ?>" id="wpt_table_type_your_message" type="text" placeholder="<?php esc_attr_e( 'Type your Message.', 'wpt_pro' );?>">
                        </td>
                     </div>
                </tr>
            </tbody>
        </table>

</div>
