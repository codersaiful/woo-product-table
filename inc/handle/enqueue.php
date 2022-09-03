<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode_Base;
use WOO_PRODUCT_TABLE\Core\Base;

class Enqueue extends Base{
    public $_root = __CLASS__;
    public $_js_plugin_name = 'wpt-js-plugin';
    public $_js_plugin_url;

    public function run(){
        $this->_js_plugin_url = $this->assets_url . 'js/wpt-control.js';
        $this->action('wp_enqueue_scripts',1,1);
    }
    public function wp_enqueue_scripts(){
        wp_enqueue_script( $this->_js_plugin_name, $this->_js_plugin_url, array( 'jquery' ), $this->dev_version, true );
    }
}