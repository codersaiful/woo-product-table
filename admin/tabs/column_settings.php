<?php
$default_enable_array = WPT_Product_Table::$default_enable_columns_array;

$columns_array = WPT_Product_Table::$columns_array;
//var_dump(WPT_Product_Table::$columns_array);
$for_add =  $meta_column_array = $updated_columns_array = get_post_meta( $post->ID, 'column_array', true );

if( !$meta_column_array && empty( $meta_column_array ) ){
    $for_add = $updated_columns_array = WPT_Product_Table::$columns_array;
}
if( $updated_columns_array && !empty( $updated_columns_array ) && !empty( $columns_array ) ){
    $columns_array = array_merge( $columns_array, $updated_columns_array );
}

//var_dump(array_merge( $columns_array,$updated_columns_array ));
//unset($columns_array['description']); //Again Start Description Column From V6.0.25
$meta_enable_column_array = get_post_meta( $post->ID, 'enabled_column_array', true );
if( $meta_enable_column_array && !empty( $meta_enable_column_array ) && !empty( $columns_array ) ){
    $columns_array = array_merge($meta_enable_column_array,$columns_array);
}

$column_settings = get_post_meta( $post->ID, 'column_settings', true ); 
if( empty( $column_settings ) ){
    $column_settings = array();
}

$additional_collumn = array_diff(array_keys($for_add), array_keys( WPT_Product_Table::$columns_array ));

//var_dump($meta_enable_column_array,array_merge($meta_enable_column_array,$columns_array));

//var_dump( $meta_enable_column_array, $columns_array );
if( is_array( $meta_enable_column_array ) && !empty( $meta_enable_column_array ) ){
    //$columns_array = array_merge( $meta_enable_column_array, array_diff( $columns_array, $meta_enable_column_array ));
    $final_cols_arr = $meta_enable_column_array;
}else{
   $final_cols_arr = $default_enable_array; 
}

if( !is_array( $final_cols_arr ) ){
    return;
}
//$columns_array = array_merge($meta_enable_column_array,array_diff($columns_array,$meta_enable_column_array));
//var_dump($columns_array,$meta_enable_column_array);


//var_dump($updated_columns_array,$meta_enable_column_array);

/**
 * Some input name keyword as variable
 */
$enabled_column_array_name = 'enabled_column_array';
?>

<div class="inside-column-settings-wrapper">
    <div class="inside-column-setting-header">
        <h2><?php echo esc_html__( 'Devicewise Column Setting', 'wpt_pro' ); ?></h2>
        <p><?php echo esc_html__( 'Desktop is default, if not set any column for tablet and mobile.', 'wpt_pro' ); ?></p>
    </div>
    <nav class="inside-nav-tab-wrapper">
        <a data-target="inside-desktop" class="wpt_inside_nav_tab nav-tab nav-tab-active">Desktop</a>
        <a data-target="inside-tablet" class="wpt_inside_nav_tab nav-tab">Tablet</a>
        <a data-target="inside-mobile" class="wpt_inside_nav_tab nav-tab">Mobile</a>
    </nav>
    
    
    <div id="inside-desktop" class="inside_tab_content tab-content tab-content-active">
<?php 
$enabled_column_array = $enabled_column_array_name;

$column_list_file = __DIR__ . '/inc-column/column-list.php';
include $column_list_file;

$availe_column_list_file = __DIR__ . '/inc-column/available-column-list.php';
include $availe_column_list_file;
?>
    </div>
    
    
    
    <div id="inside-tablet" class="inside_tab_content tab-content">
<?php 




$enabled_column_array = $enabled_column_array_name . '_tablet';

$tablet_header_file = __DIR__ . '/inc-column/tablet-header.php';
include $tablet_header_file;

$availe_column_list_file = __DIR__ . '/inc-column/available-column-list.php';
include $availe_column_list_file;
?>
    </div>
    
    
    
    
    
    <div id="inside-mobile" class="inside_tab_content tab-content">
<?php 
$enabled_column_array = $enabled_column_array_name . '_mobile';
$column_list_file = __DIR__ . '/inc-column/column-list.php';
include $column_list_file;

$availe_column_list_file = __DIR__ . '/inc-column/available-column-list.php';
include $availe_column_list_file;
?>
    </div>
    
</div>


<?php 

/**
 * Add new column part
 * Basically at the bottom of this column tab
 * 
 * Now we will add column based on Device
 * Such as Desktop, Tablet and Mobile
 * 
 * @since 2.8.4.1
 * @by Saiful
 * @date 27.4.2021
 */
$add_new_col_file = __DIR__ . '/inc-column/add-new-column.php';

include $add_new_col_file;
?>