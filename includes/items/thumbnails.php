<?php
$wpt_single_thumbnails = false;
$thumb_variation = isset($column_settings['thumb_variation']) ? $column_settings['thumb_variation'] : 'popup';
$thumb_gallery = isset( $column_settings['thumbnails']['thumb_gallery']) ? true : false;
$has_gallery = !empty($product->get_gallery_image_ids()) ? true : false;

$img_src = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full', false);
$img_attr = $img_src ? " data-url='{$img_src[0]}' data-width='{$img_src[1]}' data-height='{$img_src[2]}' " : '';

$config_img_size = $config_value['thumbs_image_size'] ?? 100;
$thumbs_size = is_numeric( $config_img_size ) ? [$config_img_size,$config_img_size] : $config_img_size;
$thumbs_size = apply_filters('wpto_thumbs_size', $thumbs_size, $settings, $column_settings, $table_ID, $product);
$thumbs_img = woocommerce_get_product_thumbnail($thumbs_size);
$tag_start = "<div data-product_id='{$id}' class='wpt_thumbnails_{$thumb_variation} ' {$img_attr}>";
$tag_end = "</div>";
if ($thumb_variation == 'quick_view') {
    $thumb_variation = 'quick_view yith-wcqv-button';
    $tag_start = "<div data-product_id='{$id}' class=' {$thumb_variation} '>";
    $tag_end = "</div>";

}elseif($thumb_variation == 'ca_quick_view') {
    $class_name = class_exists('CAWQV_PLUGIN_LITE') ? 'caqv-open-modal' : 'caqv-open-modal-notfound';
    $tag_start = "<div data-id='{$id}' class='{$class_name}'>";
    $tag_end = "</div>";

}elseif ($thumb_variation == 'url') {
    $thumbs_img = "<a href='" . esc_url(get_the_permalink()) . "' target='{$config_value['product_link_target']}'>" . $thumbs_img . '</a>';
}

//$wpt_single_thumbnails .= "<td valign='middle' class='wpt_for_thumbs_desc wpt_thumbnails wpt_thumbnails_" . esc_attr( $thumb_variation ) . "' data-product_id=" . $data['id'] . " {$img_attr}>";
$wpt_single_thumbnails .= $tag_start . $thumbs_img . $tag_end;
//$wpt_single_thumbnails .= "</td>";
if (!$has_gallery || !$thumb_gallery) {
    echo wp_kses_post($wpt_single_thumbnails);
}

do_action('wpt_thumbnail_col_bottom', $table_ID, $settings, $column_settings, $config_value, $product); // Gallery hook new added 3.1.0.1
