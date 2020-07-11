<?php
/**
 * CSS or Style file add for Admin Section. 
 * 
 * @since 1.0.0
 * @update 1.0.3
 */
function wpt_style_js_adding_admin(){
    
    wp_enqueue_style( 'wpt-admin-css', WOO_Product_Table::getPath( 'BASE_URL' ) . 'css/admin.css', array(), '1.0.0', 'all' );
    
    /**
     * Including UltraAddons CSS form Style
     */
    wp_enqueue_style( 'ultraaddons-css', WOO_Product_Table::getPath( 'BASE_URL' ) . 'css/admin-common.css', array(), '1.0.0', 'all' );
    wp_enqueue_style('ultraaddons-css');
    
    /**
     * Select2 CSS file including. 
     * 
     * @since 1.0.3
     */    
    wp_enqueue_style( 'select2', WOO_Product_Table::getPath( 'BASE_URL' ) . 'css/select2.min.css', array(), '1.8.2', 'all' );
    
    //jQuery file including. jQuery is a already registerd to WordPress
    wp_enqueue_script( 'jquery' );
    
    //Includeing jQuery UI Core
    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-sortable' );
    
    /**
     * Select2 jQuery Plugin file including. 
     * Here added min version. But also available regular version in same directory
     * 
     * @since 1.0.3
     */
    wp_enqueue_script( 'select2', WOO_Product_Table::getPath( 'BASE_URL' ) . 'js/select2.min.js', array( 'jquery' ), '4.0.5', true );
    
    //Includeing Color Picker js and css at version 4.4
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_style( 'wp-color-picker' );
     
    //WordPress Default Media Added only for addmin
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'wpt_style_js_adding_admin', 99 );

/**
 * For first load, It's specially loaded
 */
function wpt_admin_js_fast_load(){
    wp_enqueue_script( 'wpt-admin-js', WOO_Product_Table::getPath( 'BASE_URL' ) . 'js/admin.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'wpt_admin_js_fast_load', 1 );

/**
 * For removing Yoast SEO conflict
 */
function wpt_remove_wpseo_meta(){
    remove_meta_box('wpseo_meta', 'wpt_product_table', 'normal');
}
add_action('add_meta_boxes','wpt_remove_wpseo_meta',100);