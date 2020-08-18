<?php
$wpt_single_thumbnails = false;
$thumb_variation = isset( $column_settings['thumb_variation'] ) ? $column_settings['thumb_variation'] : 'popup';

$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full', false );   
$img_attr = $img_src ? " data-url='{$img_src[0]}' data-width='{$img_src[1]}' data-height='{$img_src[2]}' " : '';

$thumbs_size = apply_filters( 'wpto_thumbs_size', array( $config_value['thumbs_image_size'], $config_value['thumbs_image_size'] ), $settings, $column_settings, $table_ID, $product );
$thumbs_img = woocommerce_get_product_thumbnail( $thumbs_size );
$tag_start = "<div data-product_id='{$id}' class='wpt_thumbnails_{$thumb_variation} ' {$img_attr}>";
$tag_end = "</div>";
if($thumb_variation == 'quick_view'){
    $thumb_variation = 'quick_view yith-wcqv-button';
    $tag_start = "<div data-product_id='{$id}' class=' {$thumb_variation} '>";
    $tag_end = "</div>";
    
}elseif($thumb_variation == 'url'){
    $thumbs_img = "<a href='" . esc_url(get_the_permalink()) . "' target='{$config_value['product_link_target']}'>" . $thumbs_img . '</a>';
}

//$wpt_single_thumbnails .= "<td valign='middle' class='wpt_for_thumbs_desc wpt_thumbnails wpt_thumbnails_" . esc_attr( $thumb_variation ) . "' data-product_id=" . $data['id'] . " {$img_attr}>";
$wpt_single_thumbnails .= $tag_start.$thumbs_img.$tag_end;
//$wpt_single_thumbnails .= "</td>";

echo $wpt_single_thumbnails;
