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
        global $post;
        $pass = is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'Product_Table') || is_woocommerce();
        if( ! $pass ) return;

        wpt_enqueue_common();
       //Custom CSS Style for Woo Product Table's Table (Universal-for all table) and (template-for defien-table)
       wp_enqueue_style( 'wpt-universal', WPT_Product_Table::getPath('BASE_URL') . 'assets/css/universal.css', array(), WPT_DEV_VERSION, 'all' );
       
       //jQuery file including. jQuery is a already registerd to WordPress
       wp_enqueue_script( 'jquery' );

       ///custom JavaScript for Woo Product Table pro plugin
       wp_enqueue_script( 'wpt-custom-js', WPT_Product_Table::getPath('BASE_URL') . 'assets/js/custom.js', array( 'jquery','wc-cart-fragments','wc-add-to-cart-variation' ), WPT_DEV_VERSION, true );

       /**
        * Select2 CSS file including. 
        * 
        * @since 1.0.3
        */    
       wp_enqueue_style( 'select2', WPT_Product_Table::getPath('BASE_URL') . 'assets/select2/css/select2.min.css', array( 'jquery' ), '1.8.2' );

       /**
        * Select2 jQuery Plugin file including. 
        * Here added min version. But also available regular version in same directory
        * 
        * @since 1.9
        */
       wp_enqueue_script( 'select2', WPT_Product_Table::getPath('BASE_URL') . 'assets/select2/js/select2.min.js', array( 'jquery' ), '4.0.5', true );
       
       wp_enqueue_script( 'wp-mediaelement' );
       wp_enqueue_style( 'wp-mediaelement' );
       /**
        * jQuery floatThead
        * for making sticky head of table
        * 
        * @since 5.7.8
        */
       //wp_enqueue_script( 'floatThead', WPT_Product_Table::getPath('BASE_URL') . 'assets/js/jquery.floatThead.min.js', array( 'jquery' ), '2.1.4', true );
       $ajax_url = admin_url( 'admin-ajax.php' );
       $version = class_exists( 'WOO_Product_Table' ) && WOO_Product_Table::getVersion() ? __( 'WTP Pro: ', 'woo-product-table' ) . WOO_Product_Table::getVersion() : WPT_DEV_VERSION;
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
           'search_select_placeholder' => wpt_get_config( 'search_order_placeholder' ),//esc_html__( 'Select inner Item.', 'woo-product-table' ),
           'notice_timeout' => 3000,
           'nonce'          => wp_create_nonce( WPT_PLUGIN_FOLDER_NAME )
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
add_action( 'wp_enqueue_scripts', 'wpt_enqueue', 99 ); //wp_enqueue_scripts


if( ! function_exists( 'wpt_non_table_enqueue' ) ){

    /**
     * CSS or Style file add for FrontEnd Section. 
     * 
     * @since 1.0.0
     */
   function wpt_non_table_enqueue(){
    
       if( ! is_woocommerce() ) return;
       wpt_enqueue_common();
   }
}
add_action( 'wp_enqueue_scripts', 'wpt_non_table_enqueue', 99 );

function wpt_enqueue_common(){

    /**
    * Customized fontello file
    * And animate css file added
    * @since 3.1.8.2
    */
    wp_enqueue_style( 'wpt-fontello', WPT_Product_Table::getPath('BASE_URL') . 'assets/fontello/css/wptfontelo.css', array(), WPT_DEV_VERSION, 'all' );
    wp_enqueue_style( 'animate', WPT_Product_Table::getPath('BASE_URL') . 'assets/fontello/css/animation.css', array(), WPT_DEV_VERSION, 'all' );
}


if( ! function_exists( 'wpt_datatables_enqueue' ) ){
    
    /**
     * DataTable enable disable function using enqueue
     * Used hook wpt_after_table
     * 
     * @since 3.1.9.0
     * @author Saiful Islam <codersaiful@gmail.com>
     *
     * @param Int $table_ID It also can string actually
     * @return void
     */
   function wpt_datatables_enqueue( $table_ID ){ 
    
        $condtion = get_post_meta( $table_ID, 'conditions', true );
        $datatable = $condtion['datatable'] ?? false;
        $datatable = apply_filters( 'wpto_datatable_load', $datatable, $table_ID );
        if( ! $datatable ) return;

        //wpto_table_query_args
        //Args changed for pagination when Called/Enable DataTable
        
        

        wp_register_style('datatables', WPT_ASSETS_URL . 'DataTables/datatables.min.css', array(), '1.12.1');
        wp_enqueue_style('datatables');
        wp_register_script( 'datatables', WPT_ASSETS_URL . 'DataTables/datatables.min.js', array( 'jquery' ), '1.12.1', true );
        wp_enqueue_script( 'datatables' );

        wp_register_script( 'wpt-datatables', WPT_ASSETS_URL . 'js/datatables-handle.js', array( 'jquery' ), '1.12.1', true );
        wp_enqueue_script( 'wpt-datatables' );

        $DATATABLE = array( 
            'table_id'        => $table_ID,
            'nonce'          => wp_create_nonce( WPT_PLUGIN_FOLDER_NAME )
        );

        /**
         * Filter for datatable Options/Object 
         * @Hook filter wpto_localize_datatable To change or add/delete something
         * 
         * @since 3.1.9.0
         */
        $DATATABLE = apply_filters( 'wpto_localize_datatable', $DATATABLE, $table_ID );
        wp_localize_script( 'wpt-datatables', 'WPT_DATATABLE', $DATATABLE );

   }
}
add_action( 'wpt_after_table', 'wpt_datatables_enqueue', 99 ); //wp_enqueue_scripts

function wpt_datatable_wise_arg_manage( $args, $table_ID ){
    $condtion = get_post_meta( $table_ID, 'conditions', true );
    $datatable = $condtion['datatable'] ?? false;
    $datatable = apply_filters( 'wpto_datatable_load', $datatable, $table_ID );
    if( ! $datatable ) return $args;
    
    $args['posts_per_page' ] = apply_filters( 'wpto_datatable_posts_limit', 300, $args, $table_ID );
    $args['pagination' ] = 0;
    $args['wrapper_class' ] = 'wpt-datatable';

    return $args;
}
add_filter( 'wpto_table_query_args', 'wpt_datatable_wise_arg_manage', PHP_INT_MAX, 2 );