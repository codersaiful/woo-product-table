<?php
$settings = array(
    'page' => 'configuration_page',
    'module' => 'free',
);

$settings = apply_filters('wpto_configuration_settings', $settings);

$wrapper_class = isset($settings['module']) ? $settings['module'] : '';

?>
<div class="wrap wpt_wrap wpt-content <?php echo esc_attr($wrapper_class); ?>">

    <h1 class="wp-heading "></h1>
    <div class="fieldwrap">


        <?php
        if (! class_exists('PSSGP_Init')) {
        ?>
            <a href="https://codeastrology.com/downloads/product-sync-master-sheet-premium/" target="_blank" style="margin-bottom: -30px;display:block;color: #d00;">Get <i>Sync Master Sheet Premium</i></a>
        <?php
        }
        if (class_exists('\PSSG_Sync_Sheet\App\Handle\Quick_Table')) {

            $quckTable = new \PSSG_Sync_Sheet\App\Handle\Quick_Table();
            $quckTable->display_table_full();
        } else {


        ?>

            <div class="wpt-section-panel supported-terms wpt-recomendation-area" id="wpt-recomendation-area">
                <table class="wpt-my-table universal-setting">
                    <thead>
                        <tr>
                            <th class="wpt-inside">
                                <div class="wpt-table-header-inside">
                                    <h3><?php echo esc_html__('Quick and Bulk Edit', 'wpt'); ?> <small class="wpt-small-title">Need to intall and activate following</small></h3>
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

                                        <p>
                                            <h3>Features of <strong>Sync Master Sheet</strong> Plugin:</h3>
                                            ✅ <strong>Google Sheets Integration</strong> Live syncronize with Google Sheets<br>
                                            🔥 <strong>Stock Synchronize for Multiple </strong> at a time, User able to syncronize multiple website from a Google Sheet<br>
                                            ✅ <strong>Two-Way Product Synchronize</strong> Site to Google sheet and Google Sheet to site syncronize.<br>
                                            ✅ <strong>Edit Product Details</strong> directly from Google Sheets, including Name/Title, Price, Regular Price, SKU, and Custom Fields<br>
                                            ✅ <strong>Add Unlimited New Products</strong> from Google Sheets<br>
                                            ✅ <strong>Bulk Edit Products</strong> using Google Sheets<br>
                                            ✅ <strong>Manage WooCommerce Custom Fields</strong> (Meta Data) with seamless sync<br>
                                            ✅ <strong>Integration with Secure Custom Fields</strong> Columns (previously known as ACF Plugin)<br>
                                            ✅ <strong>Update Product Status</strong> easily via Google Sheets<br>
                                            ✅ <strong>Quick Edit Options</strong> available directly in the plugin settings (including Table Title)<br>
                                            ✅ <strong>Show/Hide Columns</strong> in Google Sheets for a customized view<br>
                                            ✅ <strong>Export Unlimited Products</strong> to Google Sheets<br>
                                            ✅ <strong>Full Support for Variable Products</strong> in Google Sheets<br>
                                            ✅ <strong>Filter by Category</strong> (multiple filters supported) in Google Sheets<br>
                                            ✅ <strong>Column Sorting</strong> for better data management in Google Sheets<br>
                                            ✅ <strong>Display Product URLs</strong> in Google Sheets<br>
                                            ✅ <strong>View Product Edit Links</strong> directly from Google Sheets<br>
                                            
                                            <strong><em><span style="text-decoration: underline;">Upcoming Features:</span></em></strong><br>
                                            🌟 Synchronize and Edit <strong>Product Image</strong><br>
                                            🌟 Synchronize and Edit Long and <strong>Short Descriptions</strong><br>
                                            🌟 Synchronize and Edit <strong>Product Attributes</strong><br>
                                            🌟 Synchronize and Edit <strong>Product Categories</strong><br>
                                            🌟 Synchronize and Edit <strong>Product Tags</strong><br><br>
                                            <strong>----------------------------------------------------</strong><br>
                                            Easily manage and synchronize your WooCommerce product stock with the power of Google Sheets using our plugin – Product Stock Sync with Google Sheets for WooCommerce. This intuitive solution empowers you to streamline your inventory management effortlessly.
                                        </p>
                                        <?php

                                        do_action('wpt_sync_plugin_recommendation'); ?>
                                    </div>

                                </div>
                            </td>
                            <td>
                                <div class="wqpmb-form-info">

                                    <p>Highly Recommeded this plugin. Which will help you to bulk edit of your all product.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div> <!--/.wpt-recomendation-area -->
        <?php
        }
        ?>
    </div>

</div> <!-- ./wrap wpt_wrap wpt-content -->