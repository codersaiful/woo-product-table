<?php
//woocommerce_template_single_add_to_cart();

global $product;
//var_dump($product);

$add_to_cart_url = $product->add_to_cart_url();
$row_class = $ajax_action_final = $stock_status_class = 'rwo_class';
$add_to_cart_text_final = 'Add to cart';
$wpt_single_action = apply_filters('woocommerce_loop_add_to_cart_link', 
        sprintf('<a rel="nofollow" data-add_to_cart_url="%s" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>', 
                esc_attr( $add_to_cart_url ),
                esc_url( $add_to_cart_url ), 
                esc_attr( 1 ),
                esc_attr($product->get_id()), 
                esc_attr($product->get_sku()), 
                esc_attr('button'),
                esc_html( $add_to_cart_text_final )
        ), $product,false,false);
echo $add_to_cart_url = $wpt_single_action;