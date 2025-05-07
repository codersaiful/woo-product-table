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
            $wpt_links[] = '<a href="https://wooproducttable.com/pricing/?utm_source=Product+Table+Dashboard&utm_medium=Free+Version&utm_content=Get+Pro" title="' . esc_attr__( 'Many awesome features is waiting for you', 'woo-product-table' ) . '" target="_blank">'.esc_html__( 'GET PRO VERSION','woo-product-table' ).'</a>';
        }
        $wpt_links[] = '<a href="' . admin_url( 'post-new.php?post_type=wpt_product_table' ) . '" title="' . esc_attr__( 'Add new Shortcode', 'woo-product-table' ) . '">' . esc_html__( 'Create Table', 'woo-product-table' ).'</a>';
        $wpt_links[] = '<a href="' . admin_url( 'edit.php?post_type=wpt_product_table&page=woo-product-table-config' ) . '" title="' . esc_attr__( 'Configure for Universal', 'woo-product-table' ) . '">' . esc_html__( 'Configure', 'woo-product-table' ) . '</a>';
        $wpt_links[] = '<a href="https://codeastrology.com/my-support/?utm_source=Product+Table+Dashboard&utm_medium=Free+Version" title="' . esc_attr__( 'CodeAstrology Support', 'woo-product-table' ) . '" target="_blank">'.esc_html__( 'Support','woo-product-table' ).'</a>';
        $wpt_links[] = '<a href="https://github.com/codersaiful/woo-product-table" title="' . esc_attr__( 'Github Repo Link', 'woo-product-table' ) . '" target="_blank">'.esc_html__( 'Github Repository','woo-product-table' ).'</a>';

        return array_merge( $wpt_links, $links );
    }                                       
}




if( !function_exists( 'wpt_getting_start' ) ){
    
    /**
     * Displaying/Present Pro Features
     * in HTML file
     */
    function wpt_getting_start(){

        ?>
        <h2>Getting Start</h2>
        <h2>CodeAstrology</h2>
        
        <?php 
    }
}

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
