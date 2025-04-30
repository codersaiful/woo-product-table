<?php if (!wpt_is_pro()) {  ?>
<div title="Premium Feature" style="padding-top: 20px;;" class="fieldwrap wpt_result_footer ultraaddons pro_version wpt-premium-feature-in-free-version">
    <div class="wpt-configure-tab-wrapper wpt-section-panel no-background"><a href="#wpt-basic-settings" class="tab-button wpt-button link-wpt-basic-settings active">Basic</a><a href="#wpt-configurate-main-section" class="tab-button wpt-button link-wpt-configurate-main-section">Special Features</a></div>

    <input saiful="data[plugin_version]" type="hidden" value="9.0.2">
    <input saiful="data[plugin_name]" type="hidden" value="Woo Product Table Pro - (Product Table by CodeAstrology)">


    <div class="wpt-section-panel basic-settings basic wpt_configuration_tab active" id="wpt-basic-settings" style="">
        <table class="wpt-my-table basic-setting-table">
            <thead>
                <tr>
                    <th class="wpt-inside">
                        <div class="wpt-table-header-inside">
                            <h3>Basic</h3>
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
                                <label class="wpt_label" for="wpt_table_custom_add_to_cart">Add to Cart Icon</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[custom_add_to_cart]" id="wpt_table_custom_add_to_cart" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="add_cart_no_icon">No Icon</option>
                                    <option value="add_cart_only_icon">Only Icon</option>
                                    <option value="add_cart_left_icon">Left Icon and Text</option>
                                    <option value="add_cart_right_icon">Text and Right Icon</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/customize-add-to-card-icon/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label" for="wpt_table_thumbs_image_size">Thumbs Image Size</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <input saiful="config[thumbs_image_size]" class="wpt_data_filed_atts ua_input" value="" id="wpt_table_thumbs_image_size" type="text" placeholder="Thumbnail size. eg: 56" min="16" max="" pattern="[0-9]*" inputmode="numeric">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/change-thumbnail-image-size/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>You can use number like 150 or use as text version like full, medium, large</p>
                        </div>
                    </td>
                </tr>
                <tr class="divider-row">
                    <td>
                        <div class="wqpmb-form-control">
                            <div class="form-label col-lg-6">
                                <h4 class="section-divider-title">Floating Cart</h4>
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

                <tr class="user_can_edit ">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label" for="wpt_table_footer_cart">Floating Cart Option</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[footer_cart]" id="wpt_table_footer_cart" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="always_hide">Always Hide</option>
                                    <option value="hide_for_zerro">Hide for Zero</option>
                                    <option value="always_show">Always Show</option>

                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                        </div>
                    </td>
                </tr>

                <tr class="user_can_edit ">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label for="wpt_table_footer_bg_color" class="wpt_label">Floating Cart BG Color</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input saiful="config[footer_bg_color]" class="wpt_data_filed_atts wpt_color_picker wp-color-picker" value="" id="wpt_table_footer_bg_colort" type="text" placeholder="BG Color"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                    <div class="wp-picker-holder">
                                        <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                            <div class="iris-picker-inner">
                                                <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                    <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                    <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                                </div>
                                                <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                    <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                                </div>
                                            </div>
                                            <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                        </div>
                    </td>
                </tr>
                <tr class="user_can_edit ">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label" for="wpt_table_footer_possition">Floating Cart Position</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[footer_possition]" id="wpt_table_footer_possition" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="bottom_right">Bottom Right</option>
                                    <option value="bottom_left">Bottom Left</option>
                                    <option value="top_right">Top Right</option>
                                    <option value="top_left">Top Left</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label" for="wpt_table_footer_cart_size">Floating Cart Size <small>[Only Int]</small></label>
                            </div>
                            <div class="form-field col-lg-6">
                                <input saiful="config[footer_cart_size]" class="wpt_data_filed_atts ua_input" value="" id="wpt_table_footer_cart_size" type="number" placeholder="Default Size. eg: 70" min="50" max="" pattern="[0-9]*" inputmode="numeric">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/advance-uses/floating-cart-options/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                        </div>
                    </td>
                </tr>


                <tr class="divider-row">
                    <td>
                        <div class="wqpmb-form-control">
                            <div class="form-label col-lg-6">
                                <h4 class="section-divider-title">Search &amp; Filter Options</h4>
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
                                <label class="wpt_label" for="wpt_table_sort_mini_filter">Mini Filter Sorting</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[sort_mini_filter]" id="wpt_table_sort_mini_filter" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="0">None</option>
                                    <option value="ASC">Ascending</option>
                                    <option value="DESC">Descending</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/mini-filter-search-box-taxonomy-sorting/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>You can sort mini filter's option by assending or descending. It's a minimal feature. When user showing all product in a table and there is no pagination. Then user can use <b>Mini Filter</b>.</p>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label" for="wpt_table_sort_searchbox_filter">Advance Search drop-down Sorting</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[sort_searchbox_filter]" id="wpt_table_sort_searchbox_filter" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="0">Default Sorting</option>
                                    <option value="ASC">Ascending</option>
                                    <option value="DESC">Descending</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/mini-filter-search-box-taxonomy-sorting/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>It's for Advance Search Drop-Down sorting. Advance Search box is important, when you created your table with pagination. or when you want that, search will execute from whole site.</p>
                            <p class="warning">If set Default Sorting, Taxonomy (Category/Tag) sorting will be like Default Taxonomy list.</p>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label" for="wpt_table_instant_search_filter">Instance Search Filter</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[instant_search_filter]" id="wpt_table_instant_search_filter" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="1">Show</option>
                                    <option value="0">Hide</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/advance-uses/use-instant-search-filter/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>It's a minimal feature. When user showing all product in a table and there is no pagination. Then user can use <b>Instance Search</b> input box.</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label for="wpt_table_instant_search_text" class="wpt_label"><b>[Instance Search]</b> - Text</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <input saiful="config[instant_search_text]" class="wpt_data_filed_atts ua_input" value="" id="wpt_table_instant_search_text" type="text" placeholder="attr">
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
                                <h4 class="section-divider-title">Linking</h4>
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
                                <label class="wpt_label" for="wpt_table_product_link_target">Product Link Open Type</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[product_link_target]" id="wpt_table_product_link_target" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="_blank">New Tab</option>
                                    <option value="_self">Self Tab</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/advance-uses/show-product-in-new-same-tab/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label" for="wpt_table_disable_cat_tag_link"><strong>Categories, Tags</strong> Link</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[disable_cat_tag_link]" id="wpt_table_disable_cat_tag_link" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="1">Disable</option>
                                    <option value="0">Enable</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/disable-categories-tag-link/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                        </div>
                    </td>
                </tr>



                <!-- ----------Cart------------------ -->
                <tr class="divider-row">
                    <td>
                        <div class="wqpmb-form-control">
                            <div class="form-label col-lg-6">
                                <h4 class="section-divider-title">Cart</h4>
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
                                <label class="wpt_label" for="wpt_table_popup_notice">Popup Notice</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[popup_notice]" id="wpt_table_popup_notice" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="1">Show</option>
                                    <option value="no">Hide</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/disable-enable-add-to-cart-popup-notice/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label" for="wpt_table_product_direct_checkout">Quick Buy</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[product_direct_checkout]" id="wpt_table_product_direct_checkout" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="no">Disable</option>
                                    <option value="cart">Cart Page</option>
                                    <option value="yes">Checkout Page</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/redirect-checkout-page-after-add-to-cart/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>Enable Quick Buy Button [Direct Checkout Page for each product]. Direct going to Checkout Page just after Added to cart for each product</p>
                        </div>
                    </td>
                </tr>

                <tr class="user_can_edit ">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label" for="wpt_table_all_selected_direct_checkout">Bundle Quick Buy </label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[all_selected_direct_checkout]" id="wpt_table_all_selected_direct_checkout" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="no">Disable</option>
                                    <option value="cart">Cart Page</option>
                                    <option value="yes">Checkout Page</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/redirect-checkout-page-after-add-to-cart/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>Direct Checkout Page[for Add to cart Selected]</p>
                        </div>
                    </td>
                </tr>
                <tr class="user_can_edit">
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label" for="wpt_table_query_by_url">Query by URL</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[query_by_url]" id="wpt_table_instant_search_filter" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="0">Off</option>
                                    <option value="1">On</option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/how-to-show-hide-query-url/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label class="wpt_label" for="wpt_table_product_count">Item/Products Count system [New]</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <select saiful="config[item_count]" id="wpt_table_product_count" class="wpt_fullwidth ua_input">
                                    <option value="">Default</option>
                                    <option value="">Products Wise</option>
                                    <option value="all" selected="">All Items</option>
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
    </div>




    <div class="wpt-section-panel supported-terms configuration_page active" id="wpt-configurate-main-section" style="display: none;">
        <table class="wpt-my-table universal-setting">
            <thead>
                <tr>
                    <th class="wpt-inside">
                        <div class="wpt-table-header-inside">
                            <h3>Special Features</h3>
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
                                <label for="wpt_show_variation_label">Show Variation Label?</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <label class="switch">
                                    <input saiful="config[wpt_show_variation_label]" type="checkbox" id="wpto_show_variation_label">
                                    <div class="slider round">
                                        <span class="on">On</span><span class="off">Off</span><!--END-->
                                    </div>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <a href="https://wooproducttable.com/docs/doc/table-options/show-product-variation-label/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                            <p>If you want to show variation label before on each variation, enable this switch</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="wpt-form-control">
                            <div class="form-label col-lg-6">
                                <label for="wpt_show_variation_label">Show Badge?</label>
                            </div>
                            <div class="form-field col-lg-6">
                                <label class="switch">
                                    <input saiful="config[wpt_show_badge]" type="checkbox" id="wpto_wpt_show_badge">
                                    <div class="slider round">
                                        <span class="on">On</span><span class="off">Off</span><!--END-->
                                    </div>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wpt-form-info">
                            <p>If you want to show percentage, enable this switch.</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>




</div>
<?php } ?>