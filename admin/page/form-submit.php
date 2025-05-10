<?php
$nonce = sanitize_text_field( wp_unslash($_POST['wpt_configure_nonce'] ?? '' ));
if ( empty($nonce) || ! wp_verify_nonce( $nonce, plugin_basename( __DIR__ ) ) ) return;

$data =  ! empty($_POST['data']) ? wp_unslash($_POST['data']) : [];
if( empty($data) ) return;

if ( isset($_POST['reset_button'])) {
    //Reset 
    $value = WPT_Product_Table::$default;
    update_option($option_key,  $value);
} else if ( isset($_POST['configure_submit']) && is_array( $data ) ) {
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