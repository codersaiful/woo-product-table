<?php
if ($product_type != 'variation') {
    woocommerce_template_single_add_to_cart();
}else{
    woocommerce_template_loop_add_to_cart();
}