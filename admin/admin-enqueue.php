<?php
if( !function_exists( 'wpt_admin_enqueue' ) ){
    /**
     * CSS or Style file add for Admin Section. 
     * 
     * @since 1.0.0
     * @update 1.0.3
     */
    function wpt_admin_enqueue(){
        global $current_screen;
        $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
        
        if( strpos( $s_id, 'wpt') === false ){
            //Actually Admin css file need, when there is no wpt on screen
            wp_enqueue_style( 'wpt-admin-notice', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/css/notice.css', array(), WPT_DEV_VERSION, 'all' );
            return;
        }

        /**
        * Customized fontello file
        * @since 3.1.8.2
        */
       wp_enqueue_style( 'wpt-fontello', WPT_Product_Table::getPath('BASE_URL') . 'assets/fontello/css/wptfontelo.css', array(), WPT_Product_Table::getVersion(), 'all' );
       wp_enqueue_style( 'wpt-fontello-animate', WPT_Product_Table::getPath('BASE_URL') . 'assets/fontello/css/animation.css', array(), WPT_Product_Table::getVersion(), 'all' );


        /**
         * Select2 CSS file including. 
         * 
         * @since 1.0.3
         */    
        wp_enqueue_style( 'select2', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/select2/css/select2.min.css', array(), '4.0.13', 'all' );

        /**
         * Including UltraAddons CSS form Style
         */
        wp_enqueue_style( 'ultraaddons-css', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/css/admin-common.css', array(), WPT_DEV_VERSION, 'all' );
        
        
        wp_enqueue_style( 'wpt-admin', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/css/admin.css', array('select2'), WPT_DEV_VERSION, 'all' );



        //jQuery file including. jQuery is a already registerd to WordPress
        wp_enqueue_script( 'jquery' );

        //Includeing jQuery UI Core
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-sortable' );

        /**
         * Select2 js file has been updated to 4.1.0 at 13.12.2020
         * 
         * Select2 jQuery Plugin file including. 
         * Here added min version. But also available regular version in same directory
         * 
         * @since 1.0.3
         */
        wp_enqueue_script( 'select2', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/select2/js/select2.min.js', array( 'jquery' ), '4.0.13', true );

        //Includeing Color Picker js and css at version 4.4
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style( 'wp-color-picker' );

        //WordPress Default Media Added only for addmin
        wp_enqueue_media();

    }
}
add_action( 'admin_enqueue_scripts', 'wpt_admin_enqueue', 99 );


if( !function_exists( 'wpt_admin_js_fast_load' ) ){
    /**
     * For first load, It's specially loaded
     */
    function wpt_admin_js_fast_load(){
        wp_register_script( 'select2-wpt', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/select2/js/select2.min.js', array( 'jquery' ), '4.0.13', true );
        if( 'wpt_product_table' == get_current_screen()->post_type ){
            wp_enqueue_script( 'select2-wpt' );
        }
        //wp_enqueue_script( 'select2-wpt' );

        wp_enqueue_script( 'wpt-admin', WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/js/admin.js', array( 'jquery','select2' ), '1.0.0', true );
        
        $ajax_url = admin_url( 'admin-ajax.php' );
        $version = class_exists( 'WOO_Product_Table' ) && WOO_Product_Table::getVersion() ? __( 'WTP Pro: ', 'woo-product-table' ) . WOO_Product_Table::getVersion() : WPT_Product_Table::getVersion();
        $is_pro = class_exists( 'WOO_Product_Table' ) ? 'yes' : 'no';
        $WPT_DATA = array( 
           'ajaxurl' => $ajax_url,
           'ajax_url' => $ajax_url,
           'site_url' => site_url(),
           'checkout_url' => wc_get_checkout_url(),
           'cart_url' => wc_get_cart_url(),
           'priceFormat' => wpt_price_formatter(),
           'version' => $version,
            'is_pro' => $is_pro,

           );
        $WPT_DATA = apply_filters( 'wpto_localize_data', $WPT_DATA );
       wp_localize_script( 'wpt-admin', 'WPT_DATA_ADMIN', $WPT_DATA );
    }
}
add_action( 'admin_enqueue_scripts', 'wpt_admin_js_fast_load', 1 );

if( !function_exists( 'wpt_remove_wpseo_meta' ) ){
    /**
     * For removing Yoast SEO conflict
     */
    function wpt_remove_wpseo_meta(){
        remove_meta_box('wpseo_meta', 'wpt_product_table', 'normal');
    }
}
add_action('add_meta_boxes','wpt_remove_wpseo_meta',100);