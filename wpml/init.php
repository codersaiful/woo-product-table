<?php 
define( 'WPT_WPML_PATH', plugin_dir_path( __FILE__ ) );

$wpt_current_lang = apply_filters( 'wpml_current_language', NULL );
// var_dump($wpt_current_lang);
global $sitepress;
// var_dump($sitepress->get_active_languages());
include_once WPT_WPML_PATH . 'admin-area.php';
