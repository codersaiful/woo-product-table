<?php
$wpt_single_product_title = false;

$title_variation = isset( $column_settings['title_variation'] ) ? $column_settings['title_variation'] : 'link';
$description_on = isset( $column_settings['description_off'] ) ? 'no' : 'yes';
$title_variation = isset( $column_settings['title_variation'] ) ? $column_settings['title_variation'] : 'link';

if($title_variation == 'link'){
    $wpt_single_product_title .= "<a class='wpt_product_title_in_td' target='{$config_value['product_link_target']}' href='" . esc_url(get_the_permalink()) . "'>" . $product->get_title() . "</a>";
} elseif($title_variation == 'nolink'){
    $wpt_single_product_title .= "<span class='wpt_product_title_in_td'>" . $product->get_title() . "</span>";
} elseif($title_variation == 'yith'){
    $wpt_single_product_title .= "<a class='wpt_product_title_in_td yith-wcqv-button' data-product_id=" . $data['id'] . " href='#'>" . $product->get_title() . "</a>";
}elseif($title_variation == 'ca_quick_view'){ //Quick View by Code Astrology //https://wordpress.org/plugins/ca-quick-view/
    $wpt_single_product_title .= "<a class='wpt_product_title_in_td caqv-open-modal' data-id=" . $data['id'] . " >" . $product->get_title() . "</a>";
}else{
    $wpt_single_product_title .= "<span class='wpt_product_title_in_td'>" . $product->get_title() . "</span>";
}


$desc = $data[$description_type];

//$desc_attr = strip_tags($desc);
$wpt_single_product_title .= $description_on && $description_on == 'yes' && $desc ? "<div class='product_description'>" .  do_shortcode( $desc ) . "</div>" : '';


echo wp_kses_post( $wpt_single_product_title );

do_action('wpt_title_col_bottom', $table_ID, $settings, $column_settings, $config_value, $product); // Gallery hook new added 3.1.0.1
