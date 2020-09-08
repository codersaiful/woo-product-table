<?php

$table_row_loc = WPT_BASE_DIR . 'includes/table_row.php';
$table_row_loc = apply_filters( 'wpo_table_row_loc', $table_row_loc, $column_settings,$table_column_keywords, $args, $table_ID, $product );
if( file_exists( $table_row_loc ) ){
    include $table_row_loc;
}
