<?php 
define( 'WPT_WPML_PATH', plugin_dir_path( __FILE__ ) );

$wpt_current_lang = apply_filters( 'wpml_current_language', NULL );

/**
 * condition Added, If enabled wpml, then following bellow code will
 * be activate, otherwise, no need execution
 * 
 * @since 3.3.9.0
 */
if( empty( $wpt_current_lang ) ) return null;

global $sitepress;
// var_dump($sitepress->get_active_languages());
if(is_admin()){
    include_once WPT_WPML_PATH . 'admin-area.php';
}

include_once WPT_WPML_PATH . 'frontend-area.php';
