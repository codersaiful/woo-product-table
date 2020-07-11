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
        ?>
        <h3 style="margin: 0">
            <a target="_blank" href="https://doc.codeastrology.com/woo-product-table-pro/#intro">Documentation</a> | 
            <a target="_blank" href="https://codeastrology.com/support/">Get Support</a> | 
            <a target="_blank" href="https://codeastrology.com/support/forums/forum/woo-product-table-pro-making-quick-order-table/">Forum</a> | 
            <a target="_blank" href="https://codeastrology.com/blog/">CodeAstrology Blog</a>

        </h3>    
        <?php
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
