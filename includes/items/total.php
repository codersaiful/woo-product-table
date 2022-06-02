<?php

$price_decimal_separator = wc_get_price_decimal_separator(); //For Decimal Deparator
$thousand_separator = wc_get_price_thousand_separator();
$number_of_decimal = wc_get_price_decimals();
$founded_price = !empty($data['price'] ) && is_numeric($data['price']) ? $data['price'] : 0;
$wpt_display_total = $founded_price * $default_quantity;

//$wpt_each_row['total'] = "<td data-number_of_decimal='" . esc_attr( $number_of_decimal ) . "' data-thousand_separator='" . esc_attr( $thousand_separator ) . "' data-price_decimal_separator='" . esc_attr( $price_decimal_separator ) . "' data-price='" . $data['price'] . "' data-currency='" . esc_attr( get_woocommerce_currency_symbol() ) . "' class='wpt_total " . ( $variable_for_total || !$data['price'] ? 'total_variaion' : 'total_general' ) . "'><strong>" . ( !$variable_for_total ? get_woocommerce_currency_symbol() . number_format( $wpt_display_total, $number_of_decimal, $price_decimal_separator, $thousand_separator ) : false ) . "</strong></td>";
$priceFormat = wpt_price_formatter();
$newPrice = '';
switch($priceFormat){
    case 'left':
        $newPrice = get_woocommerce_currency_symbol() . number_format( $wpt_display_total, $number_of_decimal, $price_decimal_separator, $thousand_separator);
        break;
    case 'left-space':
        $newPrice = get_woocommerce_currency_symbol() . ' ' . number_format( $wpt_display_total, $number_of_decimal, $price_decimal_separator, $thousand_separator);
        break;
    case 'right':
        $newPrice = number_format( $wpt_display_total, $number_of_decimal, $price_decimal_separator, $thousand_separator) . get_woocommerce_currency_symbol();
        break;
    case 'right-space':
        $newPrice = number_format( $wpt_display_total, $number_of_decimal, $price_decimal_separator, $thousand_separator) . ' ' . get_woocommerce_currency_symbol();
        break;

}

$user_role = wpt_user_roles_by_id( get_current_user_id() );
$wholesale_meta_key = ! empty( $user_role[0] ) ?  $user_role[0] . '_wholesale_price' : '_wholesale_price'; //It's only for Wholesale plugin
$total_price = !empty( get_post_meta($product->get_id(), $wholesale_meta_key, true) ) ? get_post_meta($product->get_id(), $wholesale_meta_key, true) : $product->get_price();

/**
 * Filter for Getting original Flat price to calculate Total
 * 
 * Basically If any user use any Wholesale type plugin, then can need this filter
 * 
 * @since 2.8.3.2
 * @Date 31.1.2021
 * @by Saiful
 */
$total_price = apply_filters( 'wpto_flat_product_price', $total_price, $product->get_id(), get_current_user_id(), $user_role, $product );

$cart = WC()->cart->get_cart();

$product_cart_id = WC()->cart->generate_cart_id( $product->get_id() );

if( WC()->cart->find_product_in_cart( $product_cart_id )) {
    $quantity = $cart[$product_cart_id]['quantity'];
}

//$product_price = (int) $product->get_price();
$product_price = !empty( get_post_meta($product->get_id(), $wholesale_meta_key, true) ) ? get_post_meta($product->get_id(), $wholesale_meta_key, true) : $product->get_price();

// Get the quantity if targeted product is in cart
if( isset( $quantity ) && $quantity > 0 ) {
    $total_price = ( $quantity * $product_price );
}


//var_dump( $quantity );

echo "<div data-number_of_decimal='" . esc_attr( $number_of_decimal ) . "' "
        . "data-thousand_separator='" . esc_attr( $thousand_separator ) . "' "
        . "data-price_decimal_separator='" . esc_attr( $price_decimal_separator ) . "' "
        . "data-price='" . esc_attr( $total_price ) . "' "
        . "data-currency='" . esc_attr( get_woocommerce_currency_symbol() ) . "' "
        . "data-price_format='". esc_attr( $priceFormat ) ."' "
        . "class='wpt_total_item wpt_total " . ( $variable_for_total || !$total_price ? 'total_variaion' : 'total_general' ) . "'>"
        . "<strong>" . ( !$variable_for_total ? wp_kses_post( $newPrice ) : '' ) . "</strong></div>";


$quantity = '';