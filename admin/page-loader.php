<?php
namespace WOO_PRODUCT_TABLE\Admin;

use WOO_PRODUCT_TABLE\Core\Base;

class Page_Loader extends Base
{
    public $main_slug = 'edit.php?post_type=wpt_product_table';
    public $page_folder_dir;
    public $topbar_file;
    public $topbar_sub_title;

    public $is_pro; //I tried to load inside hook, then make it public
    protected $pro_version;
    protected $license;
    protected $direct;

    public function __construct()
    {
        $this->is_pro = defined( 'WPT_PRO_DEV_VERSION' );
        if($this->is_pro && class_exists( '\WOO_Product_Table' ) ){
            $this->pro_version = WPT_PRO_DEV_VERSION;
            $this->handle_license_n_update();
        }
        $this->page_folder_dir = $this->base_dir . 'admin/page/';
        $this->topbar_file = $this->page_folder_dir . 'topbar.php';
        $this->topbar_sub_title = __("Manage and Settings", "woo-product-table");
    }

    public function run()
    {
        
        //has come from admin/menu_plugin_settings_link.php file
        add_action( 'admin_menu', [$this, 'admin_menu'] );
        add_filter('admin_body_class', [$this, 'body_class']);
        add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_scripts'] );
        
    }

    public function configure_page_render()
    {
        include $this->topbar_file;
        if( ! $this->is_pro ){
            include $this->page_folder_dir . 'premium-link-header.php';
        }
        include $this->page_folder_dir . 'configure.php';
    }
    public function admin_menu()
    {
        $proString = $this->is_pro ? esc_html__( ' Pro', 'woo-product-table' ) : '';
        add_submenu_page( $this->main_slug, esc_html__( 'Configuration ', 'woo-product-table' ) . $proString,  esc_html__( 'Configure', 'woo-product-table' ), WPT_CAPABILITY, 'woo-product-table-config', [$this, 'configure_page_render'] );
        add_submenu_page( $this->main_slug, esc_html__( 'Temp Pro Demo', 'woo-product-table' ),  esc_html__( 'Temp Pro Demo', 'woo-product-table' ), 'read', 'https://codeastro.live/?site=wpt&utm=PluginDashboard' );
        add_submenu_page( $this->main_slug, esc_html__( 'Tutorials', 'woo-product-table' ). $proString,  __( 'Tutorial', 'woo-product-table' ), 'read', 'wpt-live-support', [$this, 'html_tutorial_page'] );

        
        add_submenu_page( $this->main_slug, esc_html__( 'Browse Plugins', 'woo-product-table' ). $proString,  __( 'Browse Plugins', 'woo-product-table' ), 'read', 'wpt-browse-plugins',[$this, 'browse_plugins_html'] );
        add_submenu_page( $this->main_slug, esc_html__( 'Addons', 'woo-product-table' ). $proString,  __( 'Addons', 'woo-product-table' ), 'read', 'wpt-addons-list',[$this, 'addons_list_html'] );
        add_submenu_page( $this->main_slug, esc_html__( 'Issue Submit', 'woo-product-table' ). $proString,  __( 'Issue Submit', 'woo-product-table' ), 'read', 'https://github.com/codersaiful/woo-product-table/issues/new' );
        if( ! $this->is_pro ){
            add_submenu_page( $this->main_slug, esc_html__( 'GET PRO VERSION', 'woo-product-table' ),  __( 'Get <strong>Pro</strong>', 'woo-product-table' ), 'read', 'https://wooproducttable.com/pricing/' );
        }
        add_submenu_page( $this->main_slug, esc_html__( 'Product Bulk Edit', 'woo-product-table' ) . $proString,  __( 'Bulk Edit', 'woo-product-table' ), WPT_CAPABILITY, 'wpt-product-quick-edit', [$this, 'product_quick_edit'] );

    }

    public function body_class( $classes )
    {
        global $current_screen;

        
        $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
        
        if( $s_id == 'edit-wpt_product_table' || $s_id == 'wpt_product_table' ){
            // $classes .= ' wp-default-content-wrapper ';
        }else if( strpos( $s_id, $this->plugin_prefix ) !== false ){
            $classes .= ' wpt-zero-body ';
        }
        
        
        return $classes;

    }
    public function admin_enqueue_scripts()
    {
        global $current_screen;

        $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
        if( strpos( $s_id, $this->plugin_prefix ) === false ) return;

        add_filter('admin_footer_text',[$this, 'admin_footer_text']);




        wp_register_style( $this->plugin_prefix . '-new-admin', $this->base_url . 'assets/css/new-admin.css', false, $this->dev_version );
        wp_enqueue_style( $this->plugin_prefix . '-new-admin' );
    }

    public function admin_footer_text($text)
    {
        $rev_link = 'https://wordpress.org/support/plugin/woo-product-table/reviews/#new-post';
        $text = sprintf(
			__( 'Thank you for using Woo Product Table. <a href="%s" target="_blank">%sPlease review us</a>.' ),
			$rev_link,
            '<i class="wpt-star-filled"></i><i class="wpt-star-filled"></i><i class="wpt-star-filled"></i><i class="wpt-star-filled"></i><i class="wpt-star-filled"></i>'
		);
        return '<span id="footer-thankyou" class="wpt-footer-thankyou">' . $text . '</span>';
    }
    public function browse_plugins_html()
    {
        //In future, I will make it like min max plugin - which I already did
        // add_filter( 'plugins_api_result', [$this, 'plugins_api_result'], 1, 3 );
        $this->topbar_sub_title = __( 'Browse our Plugins','woo-product-table' );
        include $this->topbar_file;
        if( ! $this->is_pro ){
            include $this->page_folder_dir . 'premium-link-header.php';
        }
        include $this->page_folder_dir . 'browse-plugins.php';
    }
    public function addons_list_html()
    {
        $this->topbar_sub_title = __( 'Addons','woo-product-table' );
        include $this->topbar_file;
        if( ! $this->is_pro ){
            include $this->page_folder_dir . 'premium-link-header.php';
        }
        include $this->page_folder_dir . 'addons-list.php';
    }
    public function html_tutorial_page()
    {
        //In future, I will make it like min max plugin - which I already did
        // add_filter( 'plugins_api_result', [$this, 'plugins_api_result'], 1, 3 );
        $this->topbar_sub_title = __( 'Tutorial','woo-product-table' );
        include $this->topbar_file;
        if( ! $this->is_pro ){
            include $this->page_folder_dir . 'premium-link-header.php';
        }
        include $this->page_folder_dir . 'tutorials.php';
    }

    public function product_quick_edit()
    {
        $this->topbar_sub_title = __( 'Product Bulk Edit','woo-product-table' );
        include $this->topbar_file;
        include $this->page_folder_dir . 'product-bulk-edit.php';
        
    }

    /**
     * If will work, when only found pro version
     * 
     * @since 3.4.3.0
     * @author Saiful Islam <codersaiful@gmail.com>
     *
     * @return void
     */
    public function handle_license_n_update()
    {
        $this->license_key = get_option( 'wpt_pro_license_key' );
        if(empty($this->license_key)) return;
        $this->license_data_key = 'wpt_license_data';
        $this->license_status_key = 'wpt_pro_license_status';
        $this->license_status = get_option( $this->license_status_key );
        $this->license_data = get_option($this->license_data_key);

        
        add_action( 'admin_notices', [$this, 'license_activation_message'] );

        /**
         * Actually if not found lisen data, we will return null here
         * 
         * @since 3.4.3.0
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        if( empty( $this->license_status ) || empty( $this->license_data ) ) return;
        
        $expires = isset($this->license_data->expires) ? $this->license_data->expires : '';
        $this->item_id = isset($this->license_data->item_id) ? $this->license_data->item_id : '';
        if('lifetime' == $expires) return;
        $exp_timestamp = strtotime($expires);
        /**
         * keno ami ei timestamp niyechi.
         * asole expire a zodi faka ase, tahole ta 1 jan, 1970 as strtotime er output.
         * 
         * ar jehetu amora 2010 er por kaj suru korechi. tai sei expire date ba ager date asar kOnO karonoi nai.
         * tai zodi 2012 er kom timestamp ase amora return null kore debo.
         * za already diyechi: if( $exp_timestamp < $year2010_timestamp ) return; by this line. niche follow korun.
         */
        $year2010_timestamp = strtotime('2023-09-08 23:59:59');
        if( $exp_timestamp < $year2010_timestamp ) return;

        //ekhon amora bortoman date er sathe tulona korbo
        if($exp_timestamp < time()){

            $this->exp_timestamp = $exp_timestamp;
            // var_dump($this->license_data);
            if($this->license_status == 'valid'){
                $this->invalid_status = 'invalid';
                $this->license_data->license = $this->invalid_status;
                update_option( $this->license_status_key, $this->invalid_status );
                update_option( $this->license_data_key, $this->license_data );

                
            }
            add_action( 'admin_notices', [$this, 'renew_license_notice'] );
        }
        
    }

    public function license_activation_message()
    {
        
        if( ! empty( $_GET['page'] ) && $_GET['page'] === 'woo-product-table-license' ) return;
        if(empty($this->item_id)) return;
        $wpt_logo = WPT_ASSETS_URL . 'images/logo.png';

        if( empty( $this->license_status ) || $this->license_status === 'invalid' || $this->license_status === 'site_inactive' || $this->license_status === 'inactive' ){
            $wpt_logo = WPT_ASSETS_URL . 'images/logo.png';
            
            $link_label = __( 'Activate License', 'wpt_pro' );
            $link = admin_url('edit.php?post_type=wpt_product_table&page=woo-product-table-license');
            $message = esc_html__( ' Please Activate License to get Pro Feature', 'wpt_pro' );
            ob_start();
            ?>
            <div class="error wpt-renew-license-notice">
                <div class="wpt-license-notice-inside">
                <img src="<?php echo esc_url( $wpt_logo ); ?>" class="wpt-license-brand-logo">
                    Your License of <strong>Woo Product Table pro</strong> is <span style="color: #d00;font-weight:bold;">Invalid/Inactive</span>
                    %1$s <a href="%2$s">%3$s</a>
                </div>
            </div>
            <?php
            $full_message = ob_get_clean();
            printf( $full_message, $message, $link, $link_label );      
        }
    }
    public function renew_license_notice()
    {

        if(empty($this->item_id)) return;
        $wpt_logo = WPT_ASSETS_URL . 'images/logo.png';
        $expired_date = date( 'd M, Y', $this->exp_timestamp );
        $link_label = __( 'Renew License', 'wpt_pro' );
        $link = "https://codeastrology.com/checkout/?edd_license_key={$this->license_key}&download_id={$this->item_id}";
		$message = esc_html__( ' Renew it to enable pro features.', 'wpt_pro' ) . '</strong>';
        ob_start();
        ?>
        <div class="error wpt-renew-license-notice">
            <div class="wpt-license-notice-inside">
            <img src="<?php echo esc_url( $wpt_logo ); ?>" class="wpt-license-brand-logo">
                Your License of <strong>Woo Product Table pro</strong> has been expired at <span style="color: #d00;font-weight:bold;"><?php echo esc_html( $expired_date ); ?></span>
                %1$s <a href="%2$s" target="_blank">%3$s</a>
            </div>
        </div>
        <?php
        $full_message = ob_get_clean();
        printf( $full_message, $message, $link, $link_label );
    }
}