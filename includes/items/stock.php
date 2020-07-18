<?php
echo wc_get_stock_html($product);
/*
$stock_status_message = $stock_status_message = $config_value['table_out_of_stock'];
if( $data['stock_status'] == 'instock' ){
    $stock_status_message =  $data['stock_quantity'] . ' ' . $config_value['table_in_stock']; 
}elseif( $data['stock_status'] == 'onbackorder' ){
    $stock_status_message = $config_value['table_on_back_order'];//'On Back Order';
}
 * //stock old style change and added wc_get_sthock
echo "<span class='{$data['stock_status']}'>" . $stock_status_message . " </span>";
*/
