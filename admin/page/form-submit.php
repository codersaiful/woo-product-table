<?php
$nonce = sanitize_text_field( wp_unslash($_POST['wpt_configure_nonce'] ?? '' ));
if ( empty($nonce) || ! wp_verify_nonce( $nonce, plugin_basename( __DIR__ ) ) ) return;

$full_data = filter_input_array(INPUT_POST);

if ( isset($_POST['reset_button'])) {
    //Reset 
    $value = WPT_Product_Table::$default;
    update_option($option_key,  $value);
} else if ( isset($_POST['configure_submit']) && is_array( $full_data ) ) {
    $data = $full_data['data'] ?? [];
    if( ! is_array( $data ) ) return;
    //configure_submit
    $value = array_map(
        function ($field) {
            //All post value is santized here using array_map
            return is_string($field) ? sanitize_text_field($field) : '';
        },
        $data
    );
    // $value 's all key_value is sanitized before update on database
    update_option($option_key,  $value);
}