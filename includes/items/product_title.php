<?php
$wpt_single_product_title = false;
$title_variation = isset( $column_settings[$keyword]['title_variation'] ) ? $column_settings[$keyword]['title_variation'] : 'link';
$link_target = isset( $column_settings[$keyword]['link_target'] ) ? $column_settings[$keyword]['link_target'] : '_self';
$description =  isset( $column_settings[$keyword]['description'] ) ? $column_settings[$keyword]['description'] : false;

if($title_variation == 'link'){
    $wpt_single_product_title .= "<a class='wpt_product_title_in_td' target='{$config_value['product_link_target']}' href='" . esc_url(get_the_permalink()) . "'>" . get_the_title() . "</a>";
} elseif($title_variation == 'nolink'){
    $wpt_single_product_title .= "<span class='wpt_product_title_in_td'>" . get_the_title() . "</span>";
} elseif($title_variation == 'yith'){
    $wpt_single_product_title .= "<a class='wpt_product_title_in_td yith-wcqv-button' data-product_id=" . $data['id'] . " href='#'>" . get_the_title() . "</a>";
}else{
    $wpt_single_product_title .= "<span class='wpt_product_title_in_td'>" . get_the_title() . "</span>";
}


$desc = isset( $data[$description_type] ) ? $data[$description_type] : false;

//$desc_attr = strip_tags($desc);
$wpt_single_product_title .= $description && $desc ? "<div class='product_description'>" .  do_shortcode( $desc ) . "</div>" : '';



echo $wpt_single_product_title;
