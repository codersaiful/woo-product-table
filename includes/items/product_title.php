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
// the_content();
//$desc_attr = strip_tags($desc);
$wpt_single_product_title .= $description_on && $description_on == 'yes' && $desc ? "<div class='product_description'>" .  do_shortcode( $desc ) . "</div>" : '';


echo $wpt_single_product_title;
echo wp_kses_post_deep( $wpt_single_product_title );

do_action('wpt_title_col_bottom', $table_ID, $settings, $column_settings, $config_value, $product); // Gallery hook new added 3.1.0.1
?>
<div id="mep_0" class="mejs-container wp-audio-shortcode mejs-audio" tabindex="0" role="application" aria-label="Audio Player" style="width: 300px; height: 40px; min-width: 241px;"><div class="mejs-inner"><div class="mejs-mediaelement"><mediaelementwrapper id="audio-1353-1"><audio class="wp-audio-shortcode" id="audio-1353-1_html5" preload="none" style="width: 100%; height: 100%;" src="http://wpp.cm/wp-content/uploads/2021/06/Beyonce-Single-Ladies-Put-a-Ring-on-It.mp3?_=1"><source type="audio/mpeg" src="http://wpp.cm/wp-content/uploads/2021/06/Beyonce-Single-Ladies-Put-a-Ring-on-It.mp3?_=1"><a href="http://wpp.cm/wp-content/uploads/2021/06/Beyonce-Single-Ladies-Put-a-Ring-on-It.mp3">http://wpp.cm/wp-content/uploads/2021/06/Beyonce-Single-Ladies-Put-a-Ring-on-It.mp3</a></audio></mediaelementwrapper></div><div class="mejs-layers"><div class="mejs-poster mejs-layer" style="display: none; width: 100%; height: 100%;"></div></div><div class="mejs-controls"><div class="mejs-button mejs-playpause-button mejs-play"><button type="button" aria-controls="mep_0" title="Play" aria-label="Play" tabindex="0"></button></div><div class="mejs-time mejs-currenttime-container" role="timer" aria-live="off"><span class="mejs-currenttime">00:01</span></div><div class="mejs-time-rail"><span class="mejs-time-total mejs-time-slider" role="slider" tabindex="0" aria-label="Time Slider" aria-valuemin="0" aria-valuemax="198.768" aria-valuenow="1.252493" aria-valuetext="00:01"><span class="mejs-time-buffering" style="display: none;"></span><span class="mejs-time-loaded" style="transform: scaleX(0.989108);"></span><span class="mejs-time-current" style="transform: scaleX(0);"></span><span class="mejs-time-hovered no-hover"></span><span class="mejs-time-handle" style="transform: translateX(0px);"><span class="mejs-time-handle-content"></span></span><span class="mejs-time-float"><span class="mejs-time-float-current">00:00</span><span class="mejs-time-float-corner"></span></span></span></div><div class="mejs-time mejs-duration-container"><span class="mejs-duration">03:18</span></div><div class="mejs-button mejs-volume-button mejs-mute"><button type="button" aria-controls="mep_0" title="Mute" aria-label="Mute" tabindex="0"></button></div><a class="mejs-horizontal-volume-slider" href="javascript:void(0);" aria-label="Volume Slider" aria-valuemin="0" aria-valuemax="100" aria-valuenow="80" role="slider" aria-valuetext="80%"><span class="mejs-offscreen">Use Up/Down Arrow keys to increase or decrease volume.</span><div class="mejs-horizontal-volume-total"><div class="mejs-horizontal-volume-current" style="left: 0px; width: 80%;"></div><div class="mejs-horizontal-volume-handle" style="left: 80%;"></div></div></a></div></div></div>


