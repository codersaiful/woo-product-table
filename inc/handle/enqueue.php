<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode_Base;
use WOO_PRODUCT_TABLE\Core\Base;

class Enqueue extends Base{
    public $_root = __CLASS__;
    public $_js_plugin_name = 'wpt-js-plugin';
    public $WPT_DATAS_NAME = 'WPT_DATAS';

    public $_js_plugin_url;
    public $datas;

    public function run(){
        $this->_js_plugin_url = $this->assets_url . 'js/wpt-control.js';
        $ajax_url = admin_url( 'admin-ajax.php' );
        $this->datas = [
            'ajaxurl'        => $ajax_url,
            'ajax_url'       => $ajax_url,
            'site_url'       => site_url(),
            'plugin_url'     => plugins_url(),
            'content_url'    => content_url(),
            'include_url'    => includes_url(),
            'version'        => $this->dev_version,
            'select2'        => 'enable',
        ];
        $this->datas = $this->apply_filter( 'wpt_datas', $this->datas );

        $this->action('wp_enqueue_scripts');
    }
    public function wp_enqueue_scripts(){
        wp_enqueue_script( $this->_js_plugin_name, $this->_js_plugin_url, array( 'jquery' ), $this->dev_version, true );

        wp_localize_script( $this->_js_plugin_name, $this->WPT_DATAS_NAME, $this->datas );
    }
}