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

?>    
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
    

              