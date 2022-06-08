<?php

/**************
 * FRONTEND *********FRONTEND ENQUEUE****************FRONTEND
 * WPT MODULE
 *  MAIN MODULE 
 */

if( !function_exists( 'wpt_enqueue' ) ){
    /**
     * CSS or Style file add for FrontEnd Section. 
     * ONLY WHEN TABLE LOADED, MEANS: When call the action hook wpt_load
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
           'ajaxurl'        => $ajax_url,
           'ajax_url'       => $ajax_url,
           'site_url'       => site_url(),
           'plugin_url'     => plugins_url(),
           'content_url'    => content_url(),
           'include_url'    => includes_url(),
           'checkout_url'   => wc_get_checkout_url(),
           'cart_url'       => wc_get_cart_url(),
           'priceFormat'    => wpt_price_formatter(),
           'version'        => $version,
           'select2'        => 'enable',
           'resize_loader'  => apply_filters( 'wpto_resize_reloader', false ),
           'add_to_cart_view'=> apply_filters( 'wpto_add_to_cart_view', true ),
           'return_zero'    => apply_filters( 'wpto_qty_return_zero', false ),
           'return_quanity' => apply_filters( 'wpto_qty_return_quanity', true ),
           'search_select_placeholder' => wpt_get_config( 'search_order_placeholder' ),//esc_html__( 'Select inner Item.', 'wpt_pro' ),
           'notice_timeout' => 3000,
           );
       $WPT_DATA = apply_filters( 'wpto_localize_data', $WPT_DATA );
       wp_localize_script( 'wpt-custom-js', 'WPT_DATA', $WPT_DATA );

       /**
        * Compatible with other plugin
        * Start here
        * I will add functionality one by one
        */

        //Specially for woocommerce product addons @link https://woocommerce.com/products/product-add-ons/
        if( defined( 'WC_PRODUCT_ADDONS_VERSION' ) ){
            $wc_product_addons = WP_PLUGIN_URL . '/woocommerce-product-addons';
            wp_enqueue_style( 'woocommerce-addons-css', $wc_product_addons . '/assets/css/frontend.css', array( 'dashicons' ), WC_PRODUCT_ADDONS_VERSION );
            wp_enqueue_script( 'jquery-tiptip', WC()->plugin_url() . '/assets/js/jquery-tiptip/jquery.tipTip.min.js', array( 'jquery' ), WC_VERSION, true );
        }
   }
}
add_action( 'wpt_load', 'wpt_enqueue', 99 );


if( !function_exists( 'wpt_allways_enqueue' ) ){

    /**
     * CSS or Style file add for FrontEnd Section. 
     * 
     * @since 1.0.0
     */
   function wpt_allways_enqueue(){
    
       if( ! is_woocommerce() ) return;
       /**
        * Customized fontello file
        * And animate css file added
        * @since 3.1.8.2
        */
       wp_enqueue_style( 'wpt-fontello', WPT_Product_Table::getPath('BASE_URL') . 'assets/fontello/css/fontello.css', array(), WPT_Product_Table::getVersion(), 'all' );
       wp_enqueue_style( 'animate', WPT_Product_Table::getPath('BASE_URL') . 'assets/fontello/css/animation.css', array(), WPT_Product_Table::getVersion(), 'all' );

       
   }
}
add_action( 'wp_enqueue_scripts', 'wpt_allways_enqueue', 99 );