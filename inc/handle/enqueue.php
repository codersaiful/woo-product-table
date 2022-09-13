<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode_Base;
use WOO_PRODUCT_TABLE\Core\Base;

/**
 * Main Enqueue,
 * It's before table load actually.
 * 
 * Here we will Control All Basic 
 */
class Enqueue extends Shortcode_Base{
    public $_root = __CLASS__;
    public $_js_plugin_name = 'wpt-js-plugin';

    public $_js_plugin_url;
    

    public $_is_table;

    public function run(){
        
        $this->_js_plugin_url = $this->assets_url . 'js/wpt-control.js';
        
        $this->action('wp_enqueue_scripts');

    }
    public function wp_enqueue_scripts(){
        if(!$this->get_is_table()) return;
        wp_enqueue_script( $this->_js_plugin_name, $this->_js_plugin_url, array( 'jquery' ), $this->dev_version, true );
        
    }

    
}