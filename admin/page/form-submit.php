<?php
dd($_POST['reset_button'] ?? null );
if (isset($_POST['data']) && isset($_POST['reset_button'])) {
    //Reset 
    $value = WPT_Product_Table::$default;
    update_option($option_key,  $value);
} else if (isset($_POST['data']) && isset($_POST['configure_submit'])) {
    //configure_submit
    $value = false;
    if (is_array($_POST['data'])) {
        $value = array_map(
            function ($field) {
                //All post value is santized here using array_map
                return is_array($field) ? $field : sanitize_text_field($field);
            },
            $_POST['data']
        );
    }
    // $value 's all key_value is sanitized before update on database
    update_option($option_key,  $value);
}