<?php
$enable_disable = ( ( $table_type == 'normal_table' && $product_type == 'grouped' ) || $product_type == 'variable' || $product_type == 'external' || ( $data['stock_status'] != 'instock' && $data['stock_status'] != 'onbackorder' ) ? 'disabled' : 'enabled' );
$check_class_arr = array(
    $enable_disable,
    'wpt_tabel_checkbox',
    'wpt_td_checkbox',
    "wpt_check_temp_{$temp_number}_pr_" . $data['id'],
    "wpt_check_{$temp_number}",
    "wpt_inside_check_{$temp_number}",
);
$check_class = implode(" ", $check_class_arr);
            
            
$wpt_single_check = false;
$wpt_single_check .= "<input "
    . "data-product_type='" . $product->get_type() . "' "
    . "id='check_id_{$temp_number}_" . $data['id'] . "' "
    . "data-temp_number='{$temp_number}' "
    . "data-product_id='" . $data['id'] . "' "
    . "class='" . esc_attr( $check_class ) . "'"
    . "type='checkbox' "
    . "value='0'"
    . ( $checkbox == 'wpt_checked_table' && $enable_disable == 'enabled' ? " checked='checked'" : "" )
    . ">"
    . "<label for='check_id_{$temp_number}_" . $data['id'] . "'></label>";
    
$allowed_atts = array(
        'value'      => array(),
        'type'      => array(),
        'class'      => array(),
        'data-product_id'      => array(),
        'data-temp_number'      => array(),
        'id'      => array(),
        'data-product_type'      => array(),
        'for'      => array(),
);

$allowed_tags['input']     = $allowed_atts;
$allowed_tags['label']     = $allowed_atts;
$allowed_tags['div']     = $allowed_atts;
//var_dump($allowed_tags);
echo $wpt_single_check;//wp_kses( $wpt_single_check, $allowed_tags ); ?>    
    

              