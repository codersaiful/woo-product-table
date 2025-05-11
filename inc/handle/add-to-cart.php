<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Shortcode_Ajax;

class Add_To_Cart extends Shortcode_Ajax{

    public function run(){

        $this->ajax_action('wpt_add_to_cart');
    }

    public function wpt_add_to_cart(){

        //Nonce verification
        $nonce = sanitize_text_field(   wp_unslash( $_GET['cart_nonce'] ?? ''));
        if ( empty($nonce) || ! wp_verify_nonce( $nonce, WPT_PLUGIN_FOLDER_NAME ) ) {
            return;
        }

        $product_id = absint(   wp_unslash( $_POST['product_id'] ?? ''));
        $quantity = sanitize_text_field(   wp_unslash( $_POST['quantity'] ?? 1 ));
        $variation_id = absint(   wp_unslash( $_POST['variation_id'] ?? ''));

        WC()->cart->add_to_cart($product_id,$quantity,$variation_id);
        echo 'Added';
        die();
    }

    public function add_to_cart(){

    }
}