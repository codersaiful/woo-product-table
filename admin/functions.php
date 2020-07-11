<?php
if( !function_exists( 'wpt_admin_body_class' ) ){
    /**
     * set class for Admin Body tag
     * 
     * @param type $classes
     * @return String
     */
    function wpt_admin_body_class(){
        global $current_screen;
        $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
        if( strpos( $s_id, 'wpt_product_table') !== false ){
            return ' wpt_admin_body ';
        }
        return;
    }
}
add_filter( 'admin_body_class', 'wpt_admin_body_class' );

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
add_action( 'wpto_form_top', 'wpt_admin_form_top' );

if( !function_exists( 'wpt_ctrl_s_text_at_top' ) ){
    /**
     * Docs and Support Link to Our Form Top
     */
    function wpt_ctrl_s_text_at_top(){
        ?>  
<p class="wpt_ctrl_s" title="To save Data, Just Click: [Ctrl + S]">Save: <span>Ctrl + S</span></p>
        <?php
    }
}
add_action( 'wpto_form_top', 'wpt_ctrl_s_text_at_top' );

if( !function_exists( 'wpt_admin_responsive_tab' ) ){
    function wpt_admin_responsive_tab( $tab_array ){
        unset($tab_array['mobile']);
        $tab_array['responsive'] = __( 'Responsive <small>New</small>', 'wpt_pro' );
        $tab_array['mobile'] = __( 'Mobile <span>will remvoed</span>', 'wpt_pro' );
        return $tab_array;
    }
}
add_filter( 'wpto_admin_tab_array', 'wpt_admin_responsive_tab' );

if( !function_exists( 'wpt_admin_responsive_tab_save' ) ){
    function wpt_admin_responsive_tab_save( $save_tab_array ){
        $save_tab_array['responsive'] = 'responsive';
        return $save_tab_array;
    }
}
add_filter( 'wpto_save_tab_array', 'wpt_admin_responsive_tab_save' );

if( !function_exists( 'wpt_admin_responsive_tab_file' ) ){
    function wpt_admin_responsive_tab_file(){
        /**
         * you have return your new file, if u want it on Responsive Tab
         */
        //return 'my_new_location_will_be_here';
    }
}

//add_filter( 'wpto_admin_tab_file_loc_responsive', 'wpt_admin_responsive_tab_file' );
