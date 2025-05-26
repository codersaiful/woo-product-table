<?php 

$_device_name = '_tablet';

$tablet_header_file = __DIR__ . '/../inc-column/tablet-header.php';
include $tablet_header_file;
?>
<p class="device_wise_col_message"><?php echo esc_html__( 'Set columns for tablet, otherwise desktop columns will be shown on tablet.', 'woo-product-table' ); ?></p>
<?php
$availe_column_list_file = __DIR__ . '/../inc-column/available-column-list.php';
include $availe_column_list_file;

$column_list_file = __DIR__ . '/../inc-column/column-list.php';
include $column_list_file;
