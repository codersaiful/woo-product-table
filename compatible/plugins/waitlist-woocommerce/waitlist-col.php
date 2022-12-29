<?php

if( function_exists('xoo_wl_frontend') ){
    $data= $product->get_data();
    $stock = $data['stock_status'];
    if( 'outofstock' == $stock  ){
        xoo_wl_frontend()->get_waitlist_markup_for_product_page();
    }else{
        woocommerce_template_loop_add_to_cart();
    }
}
