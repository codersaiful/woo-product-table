<?php

/**************
 * FRONTEND *********FRONTEND ENQUEUE****************FRONTEND
 * WPT MODULE
 *  MAIN MODULE 
 */

if( !function_exists( 'wpt_enqueue' ) ){
    /**
     * CSS or Style file add for FrontEnd Section. 
     * 
     * @since 1.0.0
     */
   function wpt_enqueue(){
       //Custom CSS Style for Woo Product Table's Table (Universal-for all table) and (template-for defien-table)
       wp_enqueue_style( 'wpt-universal', WPT_Product_Table::getPath('BASE_URL') . 'assets/css/universal.css', array(), WPT_Product_Table::getVersion(), 'all' );
       wp_enqueue_style( 'wpt-template-table', WPT_Product_Table::getPath('BASE_URL') . 'assets/css/template.css', array(), WPT_Product_Table::getVersion(), 'all' );


       //jQuery file including. jQuery is a already registerd to WordPress
       wp_enqueue_script( 'jquery' );

       ///custom JavaScript for Woo Product Table pro plugin
       wp_enqueue_script( 'wpt-custom-js', WPT_Product_Table::getPath('BASE_URL') . 'assets/js/custom.js', array( 'jquery' ), WPT_Product_Table::getVersion(), true );


       /**
        * Select2 CSS file including. 
        * 
        * @since 1.0.3
        */    
       wp_enqueue_style( 'select2', WPT_Product_Table::getPath('BASE_URL') . 'assets/css/select2.min.css', array( 'jquery' ), '1.8.2' );

       /**
        * Select2 jQuery Plugin file including. 
        * Here added min version. But also available regular version in same directory
        * 
        * @since 1.9
        */
       wp_enqueue_script( 'select2', WPT_Product_Table::getPath('BASE_URL') . 'assets/js/select2.min.js', array( 'jquery' ), '4.0.5', true );

       /**
        * jQuery floatThead
        * for making sticky head of table
        * 
        * @since 5.7.8
        */
       //wp_enqueue_script( 'floatThead', WPT_Product_Table::getPath('BASE_URL') . 'assets/js/jquery.floatThead.min.js', array( 'jquery' ), '2.1.4', true );
       $ajax_url = admin_url( 'admin-ajax.php' );
       $version = class_exists( 'WOO_Product_Table' ) && WOO_Product_Table::getVersion() ? __( 'WTP Pro: ', 'wpt_pro' ) . WOO_Product_Table::getVersion() : WPT_Product_Table::getVersion();
       $WPT_DATA = array( 
           'ajaxurl' => $ajax_url,
           'ajax_url' => $ajax_url,
           'site_url' => site_url(),
           'plugin_url' => plugins_url(),
           'content_url' => content_url(),
           'include_url' => includes_url(),
           'checkout_url' => wc_get_checkout_url(),
           'cart_url' => wc_get_cart_url(),
           'priceFormat' => wpt_price_formatter(),
           'version' => $version,
           'resize_loader' => apply_filters( 'wpto_resize_reloader', false ),
           'return_zero'   => apply_filters( 'wpto_qty_return_zero', false ),
           'return_quanity'   => apply_filters( 'wpto_qty_return_quanity', true ),
           'search_select_placeholder' => esc_html( 'Select inner Item.', 'wpt_pro' ),
           );
       $WPT_DATA = apply_filters( 'wpto_localize_data', $WPT_DATA );
       wp_localize_script( 'wpt-custom-js', 'WPT_DATA', $WPT_DATA );
   }
}
add_action( 'wp_enqueue_scripts', 'wpt_enqueue', 99 );
