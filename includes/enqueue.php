<?php

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
       $WPT_DATA = array( 
           'ajaxurl' => admin_url( 'admin-ajax.php' ),
           'checkout_url' => 'ddd',
           'priceFormat' => wpt_price_formatter(),
           );
       wp_localize_script( 'wpt-custom-js', 'WPT_DATA', $WPT_DATA );
       //wp_localize_script($handle, $object_name, $l10n);
   }
}
add_action( 'wp_enqueue_scripts', 'wpt_enqueue', 99 );
