<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Shortcode_Ajax;

class Add_To_Cart extends Shortcode_Ajax{

    public function run(){

        $this->ajax_action('wpt_add_to_cart');
    }

    public function wpt_add_to_cart(){
        // $atts = ['id' => 19674];
        // $this->assing_property($atts);
        // var_dump($this);

        $product_id = $_POST['product_id'] ?? 0;
        $quantity = $_POST['quantity'] ?? 1;
        $variation_id = $_POST['variation_id'] ?? 0;

        WC()->cart->add_to_cart($product_id,$quantity,$variation_id);
        echo 'Added';
        die();
    }

    public function add_to_cart(){
        // WC()->cart->add_to_cart()
    }
}