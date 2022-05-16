<?php

add_filter('plugin_action_links_' . WPT_Product_Table::getPath('PLUGIN_BASE_FILE'), 'wpt_add_action_links');

if( !function_exists( 'wpt_add_action_links' ) ){
    /**
     * For showing configure or add new link on plugin page
     * It was actually an individual file, now combine at 4.1.1
     * @param type $links
     * @return type
     */
    function wpt_add_action_links($links) {

        if( ! class_exists( 'WOO_Product_Table' ) ){
            $wpt_links[] = '<a href="https://wooproducttable.com/pricing/?utm_source=Product+Table+Dashboard&utm_medium=Free+Version&utm_content=Get+Pro" title="' . esc_attr__( 'Many awesome features is waiting for you', 'wpt_pro' ) . '" target="_blank">'.esc_html__( 'GET PRO VERSION','wpt_pro' ).'</a>';
        }
        $wpt_links[] = '<a href="' . admin_url( 'post-new.php?post_type=wpt_product_table' ) . '" title="' . esc_attr__( 'Add new Shortcode', 'wpt_pro' ) . '">' . esc_html__( 'Create Table', 'wpt_pro' ).'</a>';
        $wpt_links[] = '<a href="' . admin_url( 'edit.php?post_type=wpt_product_table&page=woo-product-table-config' ) . '" title="' . esc_attr__( 'Configure for Universal', 'wpt_pro' ) . '">' . esc_html__( 'Configure', 'wpt_pro' ) . '</a>';
        $wpt_links[] = '<a href="https://codeastrology.com/support/?utm_source=Product+Table+Dashboard&utm_medium=Free+Version" title="' . esc_attr__( 'CodeAstrology Support', 'wpt_pro' ) . '" target="_blank">'.esc_html__( 'Support','wpt_pro' ).'</a>';
        $wpt_links[] = '<a href="https://github.com/codersaiful/woo-product-table" title="' . esc_attr__( 'Github Repo Link', 'wpt_pro' ) . '" target="_blank">'.esc_html__( 'Github Repository','wpt_pro' ).'</a>';

        return array_merge( $wpt_links, $links );
    }                                       
}


if( !function_exists( 'wpt_admin_menu' ) ){
    /**
     * Set Menu for WPT (Woo Product Table) Plugin
     * It was actually an individual file, now combine  at 4.1.1
     * 
     * @since 1.0
     * 
     * @package Woo Product Table
     */
    function wpt_admin_menu() {
        
        
        add_submenu_page( 'edit.php?post_type=wpt_product_table', esc_html__( 'Configuration WPTpro', 'wpt_pro' ),  esc_html__( 'Configure', 'wpt_pro' ), WPT_CAPABILITY, 'woo-product-table-config', 'wpt_configuration_page' );
        add_submenu_page( 'edit.php?post_type=wpt_product_table', esc_html__( 'Woo Product Table Documentaion', 'wpt_pro' ), esc_html__( 'Documentation', 'wpt_pro' ), WPT_CAPABILITY, 'https://wooproducttable.com/documentation/' );
        add_submenu_page( 'edit.php?post_type=wpt_product_table', esc_html__( 'Contribute to our Github Repository', 'wpt_pro' ), sprintf( esc_html__( 'Github %s Repo%s', 'wpt_pro' ), '<span style="color:#ffff21;">', '</span>'), WPT_CAPABILITY, 'https://github.com/codersaiful/woo-product-table' );
        //add_submenu_page( 'edit.php?post_type=wpt_product_table', esc_html__( 'FAQ & Support page - Contact With US', 'wpt_pro' ), sprintf( esc_html__( 'FAQ %s& Contact%s', 'wpt_pro' ), '<span style="color:#ff8921;">', '</span>'), WPT_CAPABILITY, 'wpt_fac_contact_page', 'wpt_fac_support_page' );
        if( ! defined( 'WPT_PRO_DEV_VERSION' ) ){
            add_submenu_page( 'edit.php?post_type=wpt_product_table', esc_html__( 'GET PRO VERSION', 'wpt_pro' ),  __( '<i>Get <strong>Pro</strong></i>', 'wpt_pro' ), WPT_CAPABILITY, 'https://wooproducttable.com/pricing/' );
        }
        
        add_submenu_page( 'edit.php?post_type=wpt_product_table', esc_html__( 'Pro Features', 'wpt_pro' ),  __( 'Pro Features', 'wpt_pro' ), 'manage_options', 'wpt-pro-features', 'wpt_pro_features_content' );
        add_submenu_page( 'edit.php?post_type=wpt_product_table', esc_html__( 'Browse Plugins', 'wpt_pro' ),  __( 'Browse Plugins', 'wpt_pro' ), WPT_CAPABILITY, 'wpt-browse-plugins', 'wpt_browse_all_plugin_list' );
    }
}
add_action( 'admin_menu', 'wpt_admin_menu' );

if( !function_exists( 'wpt_pro_features_content' ) ){
    
    /**
     * Displaying/Present Pro Features
     * in HTML file
     */
    function wpt_pro_features_content(){

        if( !current_user_can( WPT_CAPABILITY ) ){
            WPT_Product_Table::install();
        }

        include __DIR__ . '/pro-features-html.php';
    }
}

if( !function_exists( 'wpt_browse_all_plugin_list' ) ){
    
    /**
     * Making Browse page of Plugin
     * 
     */
    function wpt_browse_all_plugin_list() {
        wp_enqueue_script( 'plugin-install' );
			wp_enqueue_script( 'updates' );
			add_thickbox();
        echo '<h1>' . esc_html__( 'Browse our Plugins', 'wpt_pro' ) . '</h1>';
        
        $wp_list_table = _get_list_table( 'WP_Plugin_Install_List_Table' );
        
        $wp_list_table->prepare_items();

        echo '<form id="plugin-filter" method="post">';
        $wp_list_table->display();
        echo '</form>';
    }
}
add_filter( 'plugins_api_result', 'wpt_browse_plugin_result', 1, 3 );
function wpt_browse_plugin_result( $res, $action, $args ){
    
    if ( $action !== 'query_plugins' ) {
            return $res;
    }
    
    if( isset( $_GET['page'] ) && $_GET['page'] == 'wpt-browse-plugins' ){
        //Will Continue
    }else{
        return $res;
    }
    $browse_plugins = get_transient( 'codersaiful_browse_plugins' );
    
    $my_plugs = array(
        'name' => "Saiful Islam",
        'slug'=> 'slugssss',
        'version'=> '1.0.0',
        'author' => '<a href="https://profiles.wordpress.org/codersaiful">Saiful Islam</a>',
        'author_profile'    => 'https://profiles.wordpress.org/codersaiful/',

        'last_updated' => '2021-08-05 8:17am GMT',
        'rating' => 100,
        'ratings'=> array(
            5 => 100,
            4=>0,
            3=>0,
            2=>0,
            1=>0
        ),
        'num_ratings'=>100,

        'active_installs'=>3500,
        


        'homepage' => 'https://codeastrology.com',
        'short_description'=> 'Test Description. it will be updated asap. Thanks a lot.',

        'icons' => array(
            '1x' => 'https://ps.w.org/woo-add-to-cart-text-change/assets/icon-128x128.jpg',
            '2x' => 'https://ps.w.org/woo-add-to-cart-text-change/assets/icon-256x256.jpg',
        ),
    );

    if( $browse_plugins ){
        return $browse_plugins;//As $res
    }
    
    
    
    $wp_version = get_bloginfo( 'version', 'display' );
    $action = 'query_plugins';
    $args = array(
        'page' => 1,
        'wp_version' => $wp_version
    );
    $args['author']          = 'codersaiful';
    $url = 'http://api.wordpress.org/plugins/info/1.2/';
    $url = add_query_arg(
            array(
                    'action'  => $action,
                    'request' => $args,
            ),
            $url
    );

    $http_url = $url;
    $ssl      = wp_http_supports( array( 'ssl' ) );
    if ( $ssl ) {
            $url = set_url_scheme( $url, 'https' );
    }

    $http_args = array(
            'timeout'    => 15,
            'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url( '/' ),
    );
    $request   = wp_remote_get( $url, $http_args );

    if ( $ssl && is_wp_error( $request ) ) {
            if ( ! wp_is_json_request() ) {
                    trigger_error(
                            sprintf(
                                    /* translators: %s: Support forums URL. */
                                    __( 'An unexpected error occurred. Something may be wrong with WordPress.org or this server&#8217;s configuration. If you continue to have problems, please try the <a href="%s">support forums</a>.' ),
                                    __( 'https://wordpress.org/support/forums/' )
                            ) . ' ' . __( '(WordPress could not establish a secure connection to WordPress.org. Please contact your server administrator.)' ),
                            headers_sent() || WP_DEBUG ? E_USER_WARNING : E_USER_NOTICE
                    );
            }

            $request = wp_remote_get( $http_url, $http_args );
    }


    $res = json_decode( wp_remote_retrieve_body( $request ), true );
    if ( is_array( $res ) ) {
            // Object casting is required in order to match the info/1.0 format.
            $res = (object) $res;
            set_transient( 'codersaiful_browse_plugins' , $res, 32000);
    }
    
    return $res;
}