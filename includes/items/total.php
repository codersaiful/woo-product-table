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
echo "<div data-number_of_decimal='" . esc_attr( $number_of_decimal ) . "' "
        . "data-thousand_separator='" . esc_attr( $thousand_separator ) . "' "
        . "data-price_decimal_separator='" . esc_attr( $price_decimal_separator ) . "' "
        //. "data-price='" . $data['price'] . "' "
        . "data-price='" . $product->get_price() . "' "
        . "data-currency='" . esc_attr( get_woocommerce_currency_symbol() ) . "' "
        . "data-price_format='". esc_attr($priceFormat) ."' "
        . "class='wpt_total_item wpt_total " . ( $variable_for_total || !$data['price'] ? 'total_variaion' : 'total_general' ) . "'>"
        . "<strong>" . ( !$variable_for_total ? $newPrice : '' ) . "</strong></div>";
