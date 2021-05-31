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
var_dump($checkbox);        
            
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
        'value'      => true,
        'type'      => true,
        'class'      => true,
        'data-product_id'      => true,
        'data-temp_number'      => true,
        'id'      => true,
        'data-product_type'      => true,
        'for'      => true,
);

$allowed_tags['input']     = $allowed_atts;
//$allowed_tags['label']     = $allowed_atts;
//$allowed_tags['div']     = $allowed_atts;
//var_dump($allowed_tags);
//echo $wpt_single_check;//
//
//$allowed_html = array(
//  'a' => array(
//    'href' => array(),
//  ),
//  'br' => array(),
//);
//var_dump($wpt_single_check);
//echo wp_kses( $wpt_single_check, $allowed_tags );
//echo wp_kses( $wpt_single_check, $allowed_tags );
//var_dump(wp_kses_allowed_html()); ?>    
<input 
    data-product_type='<?php echo esc_attr( $product->get_type() ); ?>' 
    id='<?php echo esc_attr( "check_id_{$temp_number}_{$data['id']}" ); ?>' 
    data-temp_number='<?php echo esc_attr( $temp_number ); ?>' 
    data-product_id='<?php echo esc_attr( $data['id'] ); ?>' 
    class='<?php echo esc_attr( $check_class ); ?>' 
    type='checkbox' value='0'
    <?php 
    $this_checkbox = ( $checkbox == 'wpt_checked_table' && $enable_disable == 'enabled' ? " checked='checked'" : "" );
    echo esc_attr( $this_checkbox );
    ?>
    >
    <label for='<?php echo esc_attr( "check_id_{$temp_number}_{$data['id']}" ); ?>'></label>
    

              