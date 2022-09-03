<?php 
namespace WOO_PRODUCT_TABLE\Inc\Features;

use WOO_PRODUCT_TABLE\Inc\Shortcode_Base;
class Basics extends Shortcode_Base{
    
    public function run(){
        $this->filter('body_class');
    }
    public function body_class( $class ){
        global $post;
        
        if( isset($post->post_content) && has_shortcode( $post->post_content, $this->shortcde_text ) ) {
            $class[] = 'wpt_table_body';
            $class[] = 'woocommerce';
        }
        return $class;
    }
}