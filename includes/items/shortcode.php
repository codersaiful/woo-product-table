<?php
$content = isset( $column_settings['shortcode']['content'] ) ? $column_settings['shortcode']['content'] : false;

//var_dump($column_settings['shortcode']);
$supported_kyes = array(
    '%id%' => get_the_ID(),
    '%ID%' => get_the_ID(),
    '%product_id%' => $id,
    '%name%' => get_the_title(),
    '%product_name%' => get_the_title(),
    '%title%' => get_the_title(),
    '%product_title%' => get_the_title(),
    '%sku%' => isset( $data['sku'] ) ? $data['sku'] : false,//$product->get_sku(),
    '%author%' => get_the_author(),
    '%slug%' => $data['slug'],
    '%short_description%' => $data['short_description'],
    '%price%' => $data['price'],
    '%regular_price%' => $data['regular_price'],
    '%menu_order%' => $data['menu_order'],
    '%image_id%' => $data['image_id'],
    '%thumb_id%' => $data['image_id'],
    '%stock_status%' => $data['stock_status'],
    '%stock_quantity%' => $data['stock_quantity'],
    '%backorders%' => $data['backorders'],
    '%average_rating%' => $data['average_rating'],
    '%review_count%' => $data['review_count'],
    '%user_login%' => get_the_author_meta('user_login'),
    '%user_nicename%' => get_the_author_meta('user_nicename'),
    '%user_email%' => get_the_author_meta('user_email'),
);

$replcae_keys = array_keys( $supported_kyes );
$replcae_values = array_values( $supported_kyes );

$content = str_replace( $replcae_keys, $replcae_values, $content );

echo do_shortcode($content);