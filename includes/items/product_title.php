<?php
$wpt_single_product_title = false;


$the_title = $product->get_title();

if( $product_type == 'variation' && ! isset($settings['variation_title_hide']) ){
    $the_title = get_the_title();
    $the_title .= wpt_extra_variation_title( $product_type, $data );
}

$title_variation = isset( $column_settings['title_variation'] ) ? $column_settings['title_variation'] : 'link';
$description_on = isset( $column_settings['description_off'] ) ? 'no' : 'yes';
$title_variation = isset( $column_settings['title_variation'] ) ? $column_settings['title_variation'] : 'link';

if($title_variation == 'link'){
    $link_target = $config_value['product_link_target'] ?? '_blank';
    $wpt_single_product_title .= "<a class='wpt_product_title_in_td' target='{$link_target}' href='" . esc_url(get_the_permalink()) . "'>" . $the_title . "</a>";
} elseif($title_variation == 'nolink'){
    $wpt_single_product_title .= "<span class='wpt_product_title_in_td'>" . $the_title . "</span>";
} elseif($title_variation == 'yith'){
    $wpt_single_product_title .= "<a class='wpt_product_title_in_td yith-wcqv-button' data-product_id=" . $data['id'] . " href='#'>" . $the_title . "</a>";
}elseif($title_variation == 'ca_quick_view'){ //Quick View by Code Astrology //https://wordpress.org/plugins/ca-quick-view/
    $class_name = class_exists('CAWQV_PLUGIN_LITE') ? 'caqv-open-modal' : 'caqv-open-modal-notfound';
    $wpt_single_product_title .= "<a class='wpt_product_title_in_td {$class_name}' data-id=" . $data['id'] . " >" . $the_title . "</a>";
}else{
    $wpt_single_product_title .= "<span class='wpt_product_title_in_td'>" . $the_title . "</span>";
}


$desc = $data[$description_type] ?? '';

//$desc_attr = strip_tags($desc);
$wpt_single_product_title .= $description_on && $description_on == 'yes' && $desc ? "<div class='product_description'>" .  do_shortcode( $desc ) . "</div>" : '';

// global $allowedposttags;
echo do_shortcode( $wpt_single_product_title );

do_action('wpt_title_col_bottom', $table_ID, $settings, $column_settings, $config_value, $product); // Gallery hook new added 3.1.0.1
