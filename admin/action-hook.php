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
            <li><a target="_blank" href="https://www.wcproducttable.xyz/demo-list/">Demo</a></li>
            <li><a target="_blank" href="https://www.wcproducttable.xyz/docs/">Basic Helps</a></li>
            <li><a target="_blank" href="https://docs.codeastrology.com/woo-product-table-pro/#intro">Documentation</a></li>
            <li><a target="_blank" href="https://codeastrology.com/support/">Get Support</a></li> 
            <li><a target="_blank" href="https://codeastrology.com/support/forums/forum/woo-product-table-pro-making-quick-order-table/">Forum</a></li>

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
        ?>  
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
    function wpt_configuration_page_version_data(){
        ?>
        <input name="data[plugin_version]" type="hidden" value="<?php echo WPT_Product_Table::getVersion(); ?>">
        <input name="data[plugin_name]" type="hidden" value="<?php echo WPT_Product_Table::getName(); ?>"> 
            
         <?php
    }
}
add_action( 'wpto_admin_configuration_form_version_data', 'wpt_configuration_page_version_data' );

