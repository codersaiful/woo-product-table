<?php

$data= $product->get_data();
$stock = $data['stock_status'];

if ( ! $product->managing_stock() && 'instock' == $stock){
    echo "<p class='stock in-stock wpt_instock'>In Stock</p>";
}else{
    echo wc_get_stock_html( $product );
}