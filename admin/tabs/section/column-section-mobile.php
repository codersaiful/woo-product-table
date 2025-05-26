<?php 
$_device_name = '_mobile';

$tablet_header_file = __DIR__ . '/../inc-column/mobile-header.php';
include $tablet_header_file;
?>
<p class="device_wise_col_message"><?php echo esc_html__( 'Set columns for mobile, otherwise tablet columns will be shown on mobile.', 'woo-product-table' ); ?></p>
<?php
$availe_column_list_file = __DIR__ . '/../inc-column/available-column-list.php';
include $availe_column_list_file;

$column_list_file = __DIR__ . '/../inc-column/column-list.php';
include $column_list_file;

