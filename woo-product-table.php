<?php
/**
 * Plugin Name: Product Table for WooCommerce by codeAstrology (WooproductTable)
 * Plugin URI: https://wooproducttable.com/pricing/?utm_source=WPT+Plugin+Dashboard&utm_medium=Free+Version
 * Description: (WooproductTable) WooCommerce product table plugin helps you to display your products in a searchable table layout with filters. Boost conversions & sales. Woo Product Table is best for Wholesale.
 * Author: CodeAstrology.com
 * Author URI: https://wooproducttable.com/?utm_source=WPT+Plugin+Dashboard&utm_medium=Free+Version
 * Tags: woocommerce product list,woocommerce product table, wc product table, product grid view, inventory, shop product table
 * 
 * Version: 3.2.3
 * Requires at least:    4.0.0
 * Tested up to:         6.0.1
 * WC requires at least: 3.0.0
 * WC tested up to: 	 6.6.1
 * 
 * 
 * Text Domain: wpt_pro
 * Domain Path: /languages/
 */

use CA_Framework\WPT_Required_Plugin_Control;

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Defining constant
 */
if( ! defined( 'WPT_PLUGIN_BASE_FOLDER' ) ){
    define( 'WPT_PLUGIN_BASE_FOLDER', plugin_basename( dirname( __FILE__ ) ) );
}

if( ! defined( 'WPT_DEV_VERSION' ) ){
    define( 'WPT_DEV_VERSION', '3.2.3.1' );
}

if( ! defined( 'WPT_CAPABILITY' ) ){
    $wpt_capability = apply_filters( 'wpt_menu_capability', 'manage_wpt_product_table' );
    define( 'WPT_CAPABILITY', $wpt_capability );
}

if( ! defined( 'WPT_PLUGIN' ) ){
    define( 'WPT_PLUGIN', plugin_basename( __FILE__ ) ); 
}


if( ! defined( 'WPT_PLUGIN_BASE_FILE' ) ){
    define( 'WPT_PLUGIN_BASE_FILE', plugin_basename( __FILE__ ) );
}

if( ! defined( 'WPT_BASE_URL' ) ){
    define( "WPT_BASE_URL", plugins_url() . '/'. plugin_basename( dirname( __FILE__ ) ) . '/' );
}

if( ! defined( 'WPT_ASSETS_URL' ) ){
    define( "WPT_ASSETS_URL", WPT_BASE_URL . 'assets/' );
}

if( ! defined( 'WPT_DIR_BASE' ) ){
    define( "WPT_DIR_BASE", dirname( __FILE__ ) . '/' );
}
if( ! defined( 'WPT_BASE_DIR' ) ){
    define( "WPT_BASE_DIR", str_replace( '\\', '/', WPT_DIR_BASE ) );
}

if( ! defined( 'WPT_PLUGIN_FOLDER_NAME' ) ){
    define( "WPT_PLUGIN_FOLDER_NAME",plugin_basename( dirname( __FILE__ ) ) ); //aDDED TO NEW VERSION
}

if( ! defined( 'WPT_PLUGIN_FILE_NAME' ) ){
    define( "WPT_PLUGIN_FILE_NAME", __FILE__ ); //aDDED TO NEW VERSION
}
if( ! defined( 'WPT_OPTION_KEY' ) ){
    define( "WPT_OPTION_KEY", 'wpt_configure_options' ); //aDDED TO NEW VERSION
}

/**
 * Default Configuration for WOO Product Table Pro
 * 
 * @since 1.0.0 -5
 */
$shortCodeText = 'Product_Table';
/**
* Including Plugin file for security
* Include_once
* 
* @since 1.0.0
*/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
WPT_Product_Table::getInstance();

$column_array = array(
    'check'         => __( 'Check', 'wpt_pro' ),
    'thumbnails'    => __( 'Thumbnails', 'wpt_pro' ),
    'product_title' => __( 'Products', 'wpt_pro' ),
    'category'      => __( 'Category', 'wpt_pro' ),
    'tags'          => __( 'Tags', 'wpt_pro' ),
    'sku'           => __( 'SKU', 'wpt_pro' ),
    'weight'        => __( 'Weight(kg)', 'wpt_pro' ),
    'length'        => __( 'Length(cm)', 'wpt_pro' ),
    'width'         => __( 'Width(cm)', 'wpt_pro' ),
    'height'        => __( 'Height(cm)', 'wpt_pro' ),
    'rating'        => __( 'Rating', 'wpt_pro' ),
    'stock'         => __( 'Stock', 'wpt_pro' ),
    'price'         => __( 'Price', 'wpt_pro' ),
    'wishlist'      => __( 'Wish List', 'wpt_pro' ),
    'quantity'      => __( 'Quantity', 'wpt_pro' ),
    'total'         => __( 'Total Price', 'wpt_pro' ),
    'message'       => __( 'Short Message', 'wpt_pro' ),
    'quick_view'    => __( 'Quick View', 'wpt_pro' ),
    'date'          =>  __( 'Date', 'wpt_pro' ),
    'modified_date' =>  __( 'Modified Date', 'wpt_pro' ),
    'attribute'     =>  __( 'Attributes', 'wpt_pro' ),
    'variations'    =>  __( 'Variations', 'wpt_pro' ),
    'quoterequest'  => __( 'Quote Request', 'wpt_pro' ),
    'description'   =>  __( 'Description', 'wpt_pro' ), //has been removed at V5.2 //Again start at 6.0.25 //Again added
    'short_description'   =>  __( 'Short Description', 'wpt_pro' ), //Added at v2.9.4
    'blank'         => __( 'Blank', 'wpt_pro' ),
    'product_id'    => __( 'ID', 'wpt_pro' ),
    'serial_number' => __( 'SL', 'wpt_pro' ),
    'action'        => __( 'Action', 'wpt_pro' ),
);

$column_array = apply_filters( 'wpto_default_column_arr', $column_array );
WPT_Product_Table::$columns_array =  $column_array;
$default_enabled_col_array = array(
    'check'         => 'check',  
    'thumbnails'    => 'thumbnails',  
    'product_title' => 'product_title',  
    'quantity'      => 'quantity',  
    'price'         => 'price',  
    'action'        => 'action',  
);

/**
 * Filter for Default Enabled Column
 * Available Args $default_enabled_col_array, $column_array
 */
$default_enabled_col_array = apply_filters( 'wpto_default_enable_column_arr', $default_enabled_col_array, $column_array );
WPT_Product_Table::$default_enable_columns_array =  $default_enabled_col_array;
/**
 * @since 1.7
 */
WPT_Product_Table::$colums_disable_array = array(
    'product_id',
    'serial_number',
    'description',  //has been removed at V5.2
    'tags',
    'weight',
    'length',
    'width',
    'height',
    'total',
    'quick',
    'date',
    'modified_date',
    'wishlist',
    'quoterequest',
    'attribute',
    'variations',
    'Message',
    'shortcode',
    'content',
    'blank',
);


/**
 * Set ShortCode text as Static Properties
 * 
 * @since 1.0.0 -5
 */
$shortCodeText = apply_filters( 'wpto_shortcode_text', $shortCodeText );
WPT_Product_Table::$shortCode = $shortCodeText;

/**
 * Set Default Value For Every where, 
 * 
 * @since 1.9
 */
$default = array(
    'custom_message_on_single_page'=>  true, //Set true to get form in Single Product page for Custom Message
    'disable_plugin_noti'=>  'on',
    'footer_cart'           =>  'always_show', //hide_for_zerro
    'footer_cart_size'      =>  '74',
    'footer_bg_color'       =>  '#0a7f9c',
    'footer_possition'      =>  'footer_possition',
    'item_count'            =>  'all',
    'sort_mini_filter'      =>  'ASC',
    'sort_searchbox_filter' =>  'ASC',
    'custom_add_to_cart'    =>  'add_cart_left_icon',
    'thumbs_image_size'     =>  60,
    'thumbs_lightbox'       => '1',
    'popup_notice'          => '1',
    'disable_cat_tag_link'  =>  '0',
    'product_link_target'   =>  '_blank',
    'product_not_founded'   =>  __( 'Products Not founded!', 'wpt_pro' ),
    'load_more_text'        =>  __( 'Load more', 'wpt_pro' ),
    'quick_view_btn_text'   =>  __( 'Quick View', 'wpt_pro' ), 
    'loading_more_text'     =>  __( 'Loading..', 'wpt_pro' ),
    'search_button_text'    =>  __( 'Search', 'wpt_pro' ),
    'search_keyword_text'   =>  __( 'Search Keyword', 'wpt_pro' ),
    'disable_loading_more'  =>  'load_more_hidden',//'normal',//Load More
    'instant_search_filter' =>  '0',
    //Message Config
    'empty_cart_text'       => __( 'Empty Cart', 'wpt_pro' ), //Added at 3.0.1.0
    'filter_text'           =>  __( 'Filter:', 'wpt_pro' ),
    'filter_reset_button'   =>  __( 'Reset', 'wpt_pro' ),
    'instant_search_text'   =>  __( 'Instant Search..', 'wpt_pro' ),
    'yith_browse_list'      =>  __( 'Browse the list', 'wpt_pro' ),
    'yith_add_to_quote_text'=>  __( 'Add to Quote', 'wpt_pro' ),
    'yith_add_to_quote_adding'=>  __( 'Adding..', 'wpt_pro' ),
    'yith_add_to_quote_added' =>  __( 'Quoted', 'wpt_pro' ),
    'item'                  =>  __( 'Item', 'wpt_pro' ), //It will use at custom.js file for Chinging
    'items'                 =>  __( 'Items', 'wpt_pro' ), //It will use at custom.js file for Chinging
    'add2cart_all_added_text'=>  __( 'Added', 'wpt_pro' ), //It will use at custom.js file for Chinging
    'right_combination_message' => __( 'Not available', 'wpt_pro' ),
    'right_combination_message_alt' => __( 'Product variations is not set Properly. May be: price is not inputted. may be: Out of Stock.', 'wpt_pro' ),
    'no_more_query_message' => __( 'There is no more products based on current Query.', 'wpt_pro' ),
    'select_all_items_message' => __( 'Please select all items.', 'wpt_pro' ),
    'please_choose_items' => __( 'Please select some items.', 'wpt_pro' ),
    'out_of_stock_message'  => __( 'Out of Stock', 'wpt_pro' ),
    'adding_in_progress'    =>  __( 'Adding in Progress', 'wpt_pro' ),
    'no_right_combination'  =>  __( 'No Right Combination', 'wpt_pro' ),
    'sorry_out_of_stock'    =>  __( 'Sorry! Out of Stock!', 'wpt_pro' ),
    'type_your_message'     =>  __( 'Type your Message.', 'wpt_pro' ),
    'sorry_plz_right_combination' =>    __( 'Sorry, Please choose right combination.', 'wpt_pro' ),
    
    'all_selected_direct_checkout' => 'no',
    'product_direct_checkout' => 'no',
    
    //Added Search Box Features @Since 3.3
    'search_box_title' => sprintf( __( 'Search Box (%sAll Fields Optional%s)', 'wpt_pro' ),'<small>', '</small>'),
    'search_box_searchkeyword' => __( 'Search Keyword', 'wpt_pro' ),
    'search_box_orderby'    => __( 'Sort By', 'wpt_pro' ),
    'search_box_order'      => __( 'Order', 'wpt_pro' ),
    'search_order_placeholder'      => __( 'Select inner Item.', 'wpt_pro' ),
);
$default = apply_filters( 'wpto_default_configure', $default );
WPT_Product_Table::$default = $default;

/**
 * Main Manager Class for WOO Product Table Plugin.
 * All Important file included here.
 * Set Path and Constant also set WPT_Product_Table Class
 * Already set $_instance, So no need again call
 */
class WPT_Product_Table{
    
    
    /**
     * To set Default Value for Woo Product Table, So that, we can set Default Value in Plugin Start and 
     * can get Any were
     *
     * @var Array 
     */
    public static $default = array();
    
    /*
     * List of Path
     * 
     * @since 1.0.0
     * @var array
     */
    protected $paths = array();
    
    /**
     * Set like Constant static array
     * Get this by getPath() method
     * Set this by setConstant() method
     *  
     * @var type array
     */
    private static $constant = array();
    
    /**
     * Property for Shortcode Storing
     *
     * @var String 
     */
    public static $shortCode;
    
    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     *
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '5.6';
    
    /**
     * check minimum Woo Product Table Pro Version
     * 
     * @Since 2.8.5.4
     * @by Saiful
     * @date 28.4.2021
     * 
     * @last_modified_date: September 5, 2021
     */
    const MINIMUM_WPT_PRO_VERSION = '7.0.7';
    
    
    /**
     * Only for Admin Section, Collumn Array
     * 
     * @since 1.7
     * @var Array
     */
    public static $columns_array = array();

    
    /**
     * Only for Admin Section, Disable Collumn Array
     * 
     * @since 1.7
     * @var Array
     */
    public static $colums_disable_array = array();
    
    /**
     * Only for Admin when create a new Post for Product Table
     * 
     * 
     * @since 7.0.0
     * @var Array
     */
    public static $default_enable_columns_array = array();

    /**
     * Set Array for Style Form Section Options
     *
     * @var type 
     */
    public static $style_form_options = array();
    
    /**
    * Core singleton class
    * @var self - pattern realization
    */
   private static $_instance;
   
   /**
    * Set Plugin Mode as 1 for Giving Data to UPdate Options
    *
    * @var type Int
    */
   protected static $mode = 1;
   
    /**
    * Get the instane of WPT_Product_Table
    *
    * @return self
    */
   public static function getInstance() {
        if ( ! ( self::$_instance instanceof self ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
   }
   
   
   public function __construct() {

        /**
         * Including CA_Framework
         * 
         * @since 3.1.3.1
         * @author Saiful <codersaiful@gmail.com>
         */
        require_once WPT_DIR_BASE . '/framework/handle.php';

        if( WPT_Required::fail() ){
            return;
        }
     
        
        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
                add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
                return;
        }

       $dir = dirname( __FILE__ ); //dirname( __FILE__ )

       /**
        * See $path_args for Set Path and set Constant
        * 
        * @since 1.0.0
        */
       $path_args = array(
           'PLUGIN_BASE_FOLDER'     =>  plugin_basename( $dir ),
           'PLUGIN_BASE_FILE'       =>  plugin_basename( __FILE__ ),
           'BASE_URL'               => trailingslashit( plugins_url( '',__FILE__) ),
           'BASE_DIR'               =>  str_replace( '\\', '/', $dir . '/' ),
       );
       /**
        * Set Path Full with Constant as Array
        * 
        * @since 1.0.0
        */
       $this->setPath($path_args);

       /**
        * Set Constant
        * 
        * @since 1.0.0
        */
       $this->setConstant($path_args);
       //Load File
       include_once $this->path('BASE_DIR','admin/wpt_product_table_post.php');
       if( is_admin() ){
           
            include_once $this->path('BASE_DIR','admin/post_metabox.php');
            include_once $this->path('BASE_DIR','admin/duplicate.php');
            include_once $this->path('BASE_DIR','admin/functions.php'); //Added at V7.0.0 @date 
            
            include_once $this->path('BASE_DIR','admin/menu_plugin_setting_link.php');
            include_once $this->path('BASE_DIR','admin/admin-enqueue.php');
            include_once $this->path('BASE_DIR','admin/fac_support_page.php');
            include_once $this->path('BASE_DIR','admin/configuration_page.php');
            //Admin Section Action Hook, which we can Control from Addon
            include_once $this->path('BASE_DIR','admin/action-hook.php');
       }
    //Coll elementor Module, If installed Elementor
    if ( did_action( 'elementor/loaded' ) ) {

        include_once $this->path('BASE_DIR','modules/elementor.php'); //Elementor Widget for Table using Elementor
    }   
        
    if( ! class_exists( 'Mobile_Detect' ) ){
        include_once $this->path('BASE_DIR','modules/Mobile_Detect.php'); //MObile or Table Defice Detector
    }
    
    /**
     * Not activated this, Even file still not added to this directory
     * 
     * Comment for include_once $this->path('BASE_DIR','includes/wpt_product_table_post.php');
     * Has transferred to include from admin folder
     * 
     * Because, We would like to show preview table
     * from plugin by using wp templating feature
     * 
     * Functioned at includes/functions.php
     * @since 2.7.8.2
     * 
     */
    //include_once $this->path('BASE_DIR','includes/wpt_product_table_post.php');
    include_once $this->path('BASE_DIR','includes/enqueue.php');
    include_once $this->path('BASE_DIR','includes/functions.php');
    include_once $this->path('BASE_DIR','includes/helper-functions.php'); 
    include_once $this->path('BASE_DIR','includes/shortcode.php');
       
    /**
     * Include WPML Integration
     * 
     * Maximum task will handle from this folder.
     * Otherwise all other task will in particular position
     * 
     * @since 3.1.5.0
     * @author Saiful Islam <codersaiful@gmail.com>
     * @link https://wpml.org/documentation/
     */
    if( has_filter( 'wpml_current_language' ) ){
        include_once $this->path('BASE_DIR','wpml/init.php');
    }
   }
   
        
        
    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_php_version() {

           if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

           $message = sprintf(
                   /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
                   esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wpt_pro' ),
                   '<strong>' . esc_html__( 'Woo Product Table', 'wpt_pro' ) . '</strong>',
                   '<strong>' . esc_html__( 'PHP', 'wpt_pro' ) . '</strong>',
                    self::MINIMUM_PHP_VERSION
           );

           printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );

    }
    
   /**
    * Getting Device Object Info by Using Mobile_Detect Class
    * 
    * @param type $userAgent
    * @return \Mobile_Detect Object
    */
   public static function detectDevice( $userAgent = null ) {
       return new Mobile_Detect( null, $userAgent );
   }
   
   /**
    * Set Path
    * 
    * @param type $path_array
    * 
    * @since 1.0.0
    */
   public function setPath( $path_array ) {
       $this->paths = $path_array;
   }
   
   private function setConstant( $contanst_array ) {
       self::$constant = $this->paths;
   }
   /**
    * Set Path as like Constant Will Return Full Path
    * Name should like Constant and full Capitalize
    * 
    * @param type $name
    * @return string
    */
   public function path( $name, $_complete_full_file_path = false ) {
       $path = $this->paths[$name] . $_complete_full_file_path;
       return $path;
   }
   
   /**
    * To Get Full path to Anywhere based on Constant
    * 
    * @param type $constant_name
    * @return type String
    */
   public static function getPath( $constant_name = false ) {
       $path = self::$constant[$constant_name];
       return $path;
   }
   /**
    * Update Options when Installing
    * This method has update at Version 3.6
    * 
    * @since 1.0.0
    * @updated since 3.6_29.10.2018 d/m/y
    */
   public static function install() {
        ob_start();
        //check current value

        $role = get_role( 'administrator' );

        $role->add_cap( 'edit_wpt_product_table' );
        $role->add_cap( 'edit_wpt_product_tables' );
        $role->add_cap( 'edit_others_wpt_product_tables' );
        $role->add_cap( 'publish_wpt_product_tables' );
        $role->add_cap( 'read_wpt_product_table' );
        $role->add_cap( 'read_private_wpt_product_tables' );
        $role->add_cap( 'delete_wpt_product_table' );
        $role->add_cap( 'manage_wpt_product_table' );


        //Configuration Data Update
        $current_value = get_option( WPT_OPTION_KEY );
        $default_value = self::$default;
        if( empty( $current_value ) ){
            update_option( WPT_OPTION_KEY, $default_value );
            return;
        }
        
        if( is_array( $current_value ) && is_array( $default_value ) ){
            $updated = array_merge( $default_value, $current_value );
            update_option( WPT_OPTION_KEY, $updated );
            return;
        }
   }
   
    /**
     * Plugin Uninsall Activation Hook 
     * Static Method
     * 
     * @since 1.0.0
     */
   public static function uninstall() {
       //Nothing for now
   }
   
    /**
     * Getting full Plugin data. We have used __FILE__ for the main plugin file.
     * 
     * @since V 1.5
     * @return Array Returnning Array of full Plugin's data for This Woo Product Table plugin
     */
    public static function getPluginData(){
       return get_plugin_data( __FILE__ );
    }
   
    /**
     * Getting Version by this Function/Method
     * 
     * @return type static String
     */
    public static function getVersion() {
        $data = self::getPluginData();
        return $data['Version'];
    }
   
    /**
     * Getting Version by this Function/Method
     * 
     * @return type static String
     */
    public static function getName() {
        $data = self::getPluginData();
        return $data['Name'];
    }

    /**
     * Getting Plugin Default Data
     * 
     * @param type $indexKey
     * @return variable
     */
    public static function getDefault( $indexKey = false ){
        $default = self::$default;
        if( $indexKey && isset( $default[$indexKey] ) ){
            return $default[$indexKey];
        }
        return $default;
    }

}

/**
* Plugin Install and Uninstall
*/
register_activation_hook( __FILE__, array( 'WPT_Product_Table','install' ) );
register_deactivation_hook( __FILE__, array( 'WPT_Product_Table','uninstall' ) );
