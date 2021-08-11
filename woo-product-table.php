<?php
/**
 * Plugin Name: Product Table for WooCommerce - (wooproducttable)
 * Plugin URI: https://codecanyon.net/item/woo-product-table-pro/20676867?ref=CodeAstrology&utm_source=WPT_Installed_Plugin
 * Description: WooCommerce all products display as a table in one page by shortcode. Fully responsive and mobile friendly. Easily customizable - color,background,title,text color etc.
 * Author: Saiful Islam
 * Author URI: https://profiles.wordpress.org/codersaiful/
 * Tags: woocommerce product list,woocommerce product table, wc product table, product grid view, inventory, shop product table
 * 
 * Version: 2.9.7
 * Requires at least:    4.0.0
 * Tested up to:         5.8
 * WC requires at least: 3.0.0
 * WC tested up to: 	 5.5.2
 * 
 * Text Domain: wpt_pro
 * Domain Path: /languages/
 */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Defining constant
 */
if( !defined( 'WPT_PLUGIN_BASE_FOLDER' ) ){
    define( 'WPT_PLUGIN_BASE_FOLDER', plugin_basename( dirname( __FILE__ ) ) );
}

if( !defined( 'WPT_DEV_VERSION' ) ){
    define( 'WPT_DEV_VERSION', '2.9.7.0' );
}

if( !defined( 'WPT_CAPABILITY' ) ){
    $wpt_capability = apply_filters( 'wpt_menu_capability', 'manage_wpt_product_table' );
    define( 'WPT_CAPABILITY', $wpt_capability );
}

if( !defined( 'WPT_PLUGIN' ) ){
    define( 'WPT_PLUGIN', 'woo-product-table/woo-product-table.php' );
}


if( !defined( 'WPT_PLUGIN_BASE_FILE' ) ){
    define( 'WPT_PLUGIN_BASE_FILE', plugin_basename( __FILE__ ) );
}

if( !defined( 'WPT_BASE_URL' ) ){
    define( "WPT_BASE_URL", plugins_url() . '/'. plugin_basename( dirname( __FILE__ ) ) . '/' );
}

if( !defined( 'WPT_DIR_BASE' ) ){
    define( "WPT_DIR_BASE", dirname( __FILE__ ) . '/' );
}
if( !defined( 'WPT_BASE_DIR' ) ){
    define( "WPT_BASE_DIR", str_replace( '\\', '/', WPT_DIR_BASE ) );
}

if( !defined( 'WPT_PLUGIN_FOLDER_NAME' ) ){
    define( "WPT_PLUGIN_FOLDER_NAME",plugin_basename( dirname( __FILE__ ) ) ); //aDDED TO NEW VERSION
}

if( !defined( 'WPT_PLUGIN_FILE_NAME' ) ){
    define( "WPT_PLUGIN_FILE_NAME", __FILE__ ); //aDDED TO NEW VERSION
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
    'quick'         => __( 'Quick View', 'wpt_pro' ),
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
    'freeze' => __( 'Freeze Colum', 'wpt_pro' ),
);
$column_array = apply_filters( 'wpto_default_column_arr', $column_array );
WPT_Product_Table::$columns_array =  $column_array;
$default_enabled_col_array = array(
    'check'         => 'check',  
    'thumbnails'    => 'thumbnails',  
    'product_title' => 'product_title',  
//    'category'      => 'category',  
//    'sku'           => 'sku',  
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

//Set Style Selection Options.
WPT_Product_Table::$style_form_options = array(
    'custom'        =>  __( 'Customized Design', 'wpt_pro' ),
    'default'       =>  __( 'Default Style', 'wpt_pro' ),
    'blacky'        =>  __( 'Beautifull Blacky', 'wpt_pro' ),
    'smart'         =>  __( 'Smart Thin', 'wpt_pro' ),
    'none'          =>  __( 'Select None', 'wpt_pro' ),
    'green'         =>  __( 'Green Style', 'wpt_pro' ),
    'blue'          =>  __( 'Blue Style', 'wpt_pro' ),
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
    'item_count'            =>  'all',//products,all,''
    'sort_mini_filter'      =>  'ASC',
    'sort_searchbox_filter' =>  'ASC',
    'custom_add_to_cart'    =>  'add_cart_left_icon',
    'thumbs_image_size'     =>  60,
    'thumbs_lightbox'       => '1',
    'popup_notice'          => '1',
    //'disable_product_link'  =>  '0',
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
    'search_box_orderby'    => __( 'Order By', 'wpt_pro' ),
    'search_box_order'      => __( 'Order', 'wpt_pro' ),
    //For Default Table's Content
    /**
    'table_in_stock'        =>  __( 'In Stock', 'wpt_pro' ),//'In Stock',
    'table_out_of_stock'    =>  __( 'Out of Stock', 'wpt_pro' ),//'Out of Stock',
    'table_on_back_order'   =>  __( 'On Back Order', 'wpt_pro' ),//'On Back Order',
    
     */
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
     * Static Property
     * Used for Maintenance of Admin Notice for Require Plugin
     * With Our Plogin Woo Product Table Pro and Woo Product Table
     *
     * @var Array
     */
    public static $own = array(
        'plugin'  => 'woo-product-table/woo-product-table.php',
        'plugin_slug'  => 'woo-product-table',
        'type'  => 'error',
        'message' => 'Install To working',
        'btn_text' => 'Install Now',
        'name' => 'Woo Product Table',
        'perpose' => 'install', //install,upgrade,activation
    );
    /**
     * Basic information for UltraAddons
     *
     * acceptable data is
     * $plugin_url = 'https://wordpress.org/plugins/ultraaddons-elementor-lite/';
       $plugin_slug = 'ultraaddons-elementor-lite';
       $perpose = 'install';
       $type = 'warning';
     * @var type 
     */
    public static $ultraaddons_args = array(
        'plugin_url'    =>  'https://wordpress.org/plugins/ultraaddons-elementor-lite/',
        'plugin_slug'   => 'ultraaddons-elementor-lite',
        'perpose'       =>  'install',     
    );

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
     */
    const MINIMUM_WPT_PRO_VERSION = '7.0.6';
    
    
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
        * Getting All Install plugin Details Here
        * To check required plugin Availability, Version etc.
        * @since 6.1.0.15
        */
       $installed_plugins = get_plugins();
//       var_dump($installed_plugins);
       //Condition and check php verion and WooCommerce activation
       if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }
        
        /**
         * Checking Pro Version Compatibility If
         * Installed
         */
        $pro_v_loc = 'woo-product-table-pro/woo-product-table-pro.php';
        $pro_installed = isset( $installed_plugins[$pro_v_loc] );
        $pro_activated = is_plugin_active( $pro_v_loc );
        $pro_version = isset( $installed_plugins[$pro_v_loc]['Version'] ) ? $installed_plugins[$pro_v_loc]['Version'] : false;
        if( $pro_installed && $pro_activated && version_compare( $pro_version, self::MINIMUM_WPT_PRO_VERSION, '<' )  ){
            add_action( 'admin_notices', [ $this, 'admin_notice_pro_version_need_update' ] );
//            return;
        }
        
        //Qty Plus/Minus Button Plugin Compulsory for Our Product Table Plugin
        $plugin = 'wc-quantity-plus-minus-button/init.php';
        $link_text = '<strong><a href="' . esc_url( 'https://wordpress.org/plugins/wc-quantity-plus-minus-button/' ) . '" target="_blank">' . esc_html__( 'Quantity Plus/Minus Button for WooCommerce', 'wpt_pro' ) . '</a></strong>';
        //Check Installation of Quantity Plus Minus Button Plugin
        if( !isset( $installed_plugins[$plugin] ) ) {
            self::$own['plugin']        = $plugin;
            self::$own['plugin_slug']   = 'wc-quantity-plus-minus-button';
            self::$own['type']          = 'warning';
            self::$own['btn_text']      = 'Install Now';
            $message = sprintf(
                   esc_html__( '"%1$s" requires "%2$s" to be Installed and Activated.', 'wpt_pro' ),
                   '<strong>' . esc_html__( 'Woo Product Table', 'wpt_pro' ) . '</strong>',
                    $link_text                   
        );
        self::$own['message']           = $message;//'You to activate your Plugin';
        add_action( 'admin_notices', [ $this, 'admin_notice' ] );
        }
       
            
        //Check Activation Of that Plugin
        if( isset( $installed_plugins[$plugin] ) && !is_plugin_active( $plugin ) ) {
            self::$own['type']      = 'warning';
            self::$own['perpose']   = 'activation';
            self::$own['plugin']    = 'wc-quantity-plus-minus-button/init.php';
            self::$own['btn_text']  = 'Activate Now';
            $configuration_page = '<a target="_blank" href="' . esc_url( admin_url( 'edit.php?post_type=wpt_product_table&page=woo-product-table-config' ) ) . '">' . esc_html__( 'Configuration Page', 'wpt_pro' ) . '</a>';
            $message = sprintf(
                   /* translators: 1: Plugin name 2: WooPrdouct Table */
                   esc_html__( '"%1$s" recomends "%2$s" to be activated. To [hide this warning], Go to %3$s and Disable Plugin Recomendation.', 'wpt_pro' ),
                   '<strong>' . esc_html__( 'Woo Product Table', 'wpt_pro' ) . '</strong>',
                    $link_text,
                    $configuration_page
                );
            self::$own['message']   = $message;//'You to activate your Plugin';
            add_action( 'admin_notices', [ $this, 'admin_notice' ] );
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
        $wpt_ultraaddons_notice = false;
        //UltraAddons Plugin Recommendation
        $plugin = 'ultraaddons-elementor-lite/init.php';
        $link_text = '<strong><a href="' . esc_url( 'https://wordpress.org/plugins/ultraaddons-elementor-lite/' ) . '" target="_blank">' . esc_html__( 'Quantity Plus/Minus Button for WooCommerce', 'wpt_pro' ) . '</a></strong>';
        
        if( ! isset( $installed_plugins[$plugin] ) ) {
            $wpt_ultraaddons_notice = true;
            
        }else if( isset( $installed_plugins[$plugin] ) && ! is_plugin_active( $plugin ) ){
            self::$ultraaddons_args['perpose'] = 'activate';
            $wpt_ultraaddons_notice = true;
        }
        
        if( $wpt_ultraaddons_notice ){
            add_action( 'admin_notices', [ $this, 'ultraaddons_notice' ] );
        }

        include_once $this->path('BASE_DIR','modules/elementor.php'); //Elementor Widget for Table using Elementor
    }   
        
    if( !class_exists( 'Mobile_Detect' ) ){
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
       
   }
   
   public function ultraaddons_notice() {
        $config = get_option( 'wpt_configure_options' );
        $disable_plugin_noti = !isset( $config['disable_plugin_noti'] ) ? true : false;
        $disable_plugin_noti = apply_filters( 'wpto_disable_recommend_noti', $disable_plugin_noti );
        if ( $disable_plugin_noti || ! current_user_can( 'activate_plugins' ) ) {
                return;
        }
       
       $plugin_url = 'https://wordpress.org/plugins/ultraaddons-elementor-lite/';
       $plugin_file = 'ultraaddons-elementor-lite/init.php';
       $plugin_slug = 'ultraaddons-elementor-lite';
       $perpose = isset( self::$ultraaddons_args['perpose'] ) ? self::$ultraaddons_args['perpose'] : 'install';
       $url = wp_nonce_url( self_admin_url( 'update.php?action=' . $perpose . '-plugin&plugin=' . $plugin_slug ), $perpose . '-plugin_' . $plugin_slug );
       $msg_title = __( "Essential for Woo Product Table", 'wpt_pro' );
       $msg = __( "You are using Elementor, So <b>Woo Product Table</b> require <a href='{$plugin_url}' target='_blank'>UltraAddons</a>. You have to install and activate to get full features of Woo Product Table. " );
       $btn_text = __( 'Install Now', 'wpt_pro' );
       
       if( 'activate' == $perpose ){
           $btn_text = __( 'Activate', 'wpt_pro' );
           $url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin_file . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin_file );
       }

       ?>
        <div class="wpt-ultraaddons-notice notice wpt-notice-warning is-dismissible wpt-ua-<?php echo esc_attr( $perpose ); ?>">
            <div class="wpt-ua-notice-wrapper">
                <div class="wpt-ua-logo-area">
                    <img src="<?php echo esc_url( WPT_BASE_URL ); ?>assets/images/svg/ultraaddons-logo.svg">
                </div>
                <div class="wpt-ua-message-area">
                    <h2><?php echo esc_html( $msg_title ); ?></h2>
                    <p><?php echo wp_kses_post( $msg ); ?></p>
                    <a class="button" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $btn_text ); ?></a>
                </div>
            </div>
        </div>
        <?php
   }
   
    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice() {
        $config = get_option( 'wpt_configure_options' );
        $disable_plugin_noti = !isset( $config['disable_plugin_noti'] ) ? true : false;
        $disable_plugin_noti = apply_filters( 'wpto_disable_recommend_noti', $disable_plugin_noti );
        if ( $disable_plugin_noti || ! current_user_can( 'activate_plugins' ) ) {
                return;
        }

        $plugin         = isset( self::$own['plugin'] ) ? self::$own['plugin'] : '';
        $type           = isset( self::$own['type'] ) ? self::$own['type'] : false;
        $plugin_slug    = isset( self::$own['plugin_slug'] ) ? self::$own['plugin_slug'] : '';
        $message        = isset( self::$own['message'] ) ? self::$own['message'] : '';
        $btn_text       = isset( self::$own['btn_text'] ) ? self::$own['btn_text'] : '';
        $name           = isset( self::$own['name'] ) ? self::$own['name'] : false; //Mainly providing OUr pLugin Name
        $perpose        = isset( self::$own['perpose'] ) ? self::$own['perpose'] : 'install';
        if( $perpose == 'activation' ){
            $url = $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
        }elseif( $perpose == 'upgrade' ){
            $url = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $plugin, 'upgrade-plugin_' . $plugin );
        }elseif( $perpose == 'install' ){
            //IF PERPOSE install or Upgrade Actually || $perpose == install only supported Here
            $url = wp_nonce_url( self_admin_url( 'update.php?action=' . $perpose . '-plugin&plugin=' . $plugin_slug ), $perpose . '-plugin_' . $plugin_slug ); //$install_url = 
        }else{
            $url = false;
        }
        
        
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = '<p>' . $message . '</p>';
        if( $url ){
            $style = isset( $type ) && $type == 'error' ? 'style="background: #ff584c;border-color: #E91E63;"' : 'style="background: #ffb900;border-color: #c37400;"';
            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary" %s>%s</a>', $url,$style, $btn_text ) . '</p>';
        }
        printf( '<div class="notice notice-' . $type . ' is-dismissible"><p>%1$s</p></div>', $message );

    }
    
    /**
     * Admin notice
     *
     * Warning when the site doesn't have WooCommerce installed or activated.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_missing_main_plugin() {

           if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

           $message = sprintf(
                   esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'wpt_pro' ),
                   '<strong>' . esc_html__( 'Woo Product Table', 'wpt_pro' ) . '</strong>',
                   '<strong><a href="' . esc_url( 'https://wordpress.org/plugins/woocommerce/' ) . '" target="_blank">' . esc_html__( 'WooCommerce', 'wpt_pro' ) . '</a></strong>'
           );

           printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );

    }
    
    /**
     * Pro version need to be update to latest version
     * 
     * @since 2.8.5.4
     * @by Saiful
     * @Date 28.4.2021
     */
    public function admin_notice_pro_version_need_update() {

           $message = sprintf(
                   esc_html__( '"%1$s" recommend "%2$s" to be update to minimum version:("%3$s"). Please update your [Woo Product Table Pro] version', 'wpt_pro' ),
                   '<strong>' . esc_html__( 'Woo Product Table', 'wpt_pro' ) . '</strong>',
                   '<strong>' . esc_html__( 'Pro Version of Woo Product Table Pro', 'wpt_pro' ) . '</strong>',
                   '<strong>' . self::MINIMUM_WPT_PRO_VERSION . '</strong>'
           );

           printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

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
       $current_value = get_option('wpt_configure_options');
       $current_value = $current_value ? $current_value : get_option('wptf_configure_options');
       $default_value = self::$default;
       $default_value['plugin_name'] = self::getName();
       $default_value['plugin_version'] =  self::getVersion();
       $changed_value = false;
       //Set default value in Options
       if($current_value){
           foreach( $default_value as $key=>$value ){
              if( isset($current_value[$key]) && $key != 'plugin_version' ){
                 $changed_value[$key] = $current_value[$key];
              }else{
                  $changed_value[$key] = $value;
              }
           }
           update_option( 'wpt_configure_options', $changed_value );
       }else{
           update_option( 'wpt_configure_options', $default_value );
       }
       
    $role = get_role( 'administrator' );

    $role->add_cap( 'edit_wpt_product_table' );
    $role->add_cap( 'edit_wpt_product_tables' );
    $role->add_cap( 'edit_others_wpt_product_tables' );
    $role->add_cap( 'publish_wpt_product_tables' );
    $role->add_cap( 'read_wpt_product_table' );
    $role->add_cap( 'read_private_wpt_product_tables' );
    $role->add_cap( 'delete_wpt_product_table' );
    $role->add_cap( 'manage_wpt_product_table' );
       
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
register_activation_hook(__FILE__, array( 'WPT_Product_Table','install' ) );
register_deactivation_hook( __FILE__, array( 'WPT_Product_Table','uninstall' ) );
