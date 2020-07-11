<?php
global $product;
$content = isset( $item['content'] ) && !empty( $item['content'] ) ? $item['content'] : false;
$content = is_string( $content ) ? $content : '';
$content = apply_filters( 'wpt_shortcode_content', $content, $product, $POST_ID );

if( !$content && empty( $content ) ){
    return;
}

$supported_kyes = array(
    '%id%' => get_the_ID(),
    '%ID%' => get_the_ID(),
    '%product_id%' => $product_id,
    '%name%' => get_the_title(),
    '%product_name%' => get_the_title(),
    '%title%' => get_the_title(),
    '%product_title%' => get_the_title(),
    '%sku%' => isset( $wc_product_data['_sku'] ) ? $wc_product_data['_sku'] : false,//$product->get_sku(),
    '%author%' => get_the_author(),
    '%slug%' => $wc_product_data['slug'],
    '%short_description%' => $wc_product_data['short_description'],
    '%price%' => $wc_product_data['price'],
    '%regular_price%' => $wc_product_data['regular_price'],
    '%menu_order%' => $wc_product_data['menu_order'],
    '%image_id%' => $wc_product_data['image_id'],
    '%thumb_id%' => $wc_product_data['image_id'],
    '%stock_status%' => $wc_product_data['stock_status'],
    '%stock_quantity%' => $wc_product_data['stock_quantity'],
    '%backorders%' => $wc_product_data['backorders'],
    '%average_rating%' => $wc_product_data['average_rating'],
    '%review_count%' => $wc_product_data['review_count'],
    '%user_login%' => get_the_author_meta('user_login'),
    '%user_nicename%' => get_the_author_meta('user_nicename'),
    '%user_email%' => get_the_author_meta('user_email'),
);

$supported_kyes = apply_filters( 'wpt_supported_replace_keys_arra', $supported_kyes, $product, $POST_ID );

if( !is_array( $supported_kyes ) && count( $supported_kyes ) < 1 ){
    return;
}

$replcae_keys = array_keys( $supported_kyes );
$replcae_values = array_values( $supported_kyes );

$content = str_replace( $replcae_keys, $replcae_values, $content );


echo $content;
?>

