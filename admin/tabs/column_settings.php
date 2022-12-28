<?php
$default_enable_array = WPT_Product_Table::$default_enable_columns_array;

$columns_array = WPT_Product_Table::$columns_array;
//asort($columns_array);
//var_dump(WPT_Product_Table::$columns_array);
$for_add =  $meta_column_array = $updated_columns_array = get_post_meta( $post->ID, 'column_array', true );

if( !$meta_column_array && empty( $meta_column_array ) ){
    $for_add = $updated_columns_array = WPT_Product_Table::$columns_array;
}
if( $updated_columns_array && !empty( $updated_columns_array ) && !empty( $columns_array ) ){
    $columns_array = $columns_array + $updated_columns_array;
    // $columns_array = array_merge( $columns_array, $updated_columns_array );
}

//var_dump(array_merge( $columns_array,$updated_columns_array ));
//unset($columns_array['description']); //Again Start Description Column From V6.0.25
$meta_enable_column_array = get_post_meta( $post->ID, 'enabled_column_array', true );
if( $meta_enable_column_array && !empty( $meta_enable_column_array ) && !empty( $columns_array ) ){
    $columns_array = $meta_enable_column_array + $columns_array;
    // $columns_array = array_merge($meta_enable_column_array,$columns_array);
    
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
$_device_name = '';
?>

<div class="inside-column-settings-wrapper">
    <div class="inside-column-setting-header">
        <h2><?php echo esc_html__( 'Device Wise Column Setting', 'woo-product-table' ); ?></h2>
        
        <div class="auto-responsive-area-wrapper">
            <b for="responsive_switch-switcher">Auto Responsive</b>
            <label class="switch switch-reverse"><!-- switch-big #2ab934a6 #2ab934a6 -->
                <?php

                /**
                 * ********************
                 * Managed at inc/shortcode.php file
                 * like:
                 * $responsive_switch = $this->basics['responsive_switch'] ?? false;
                 * 
                 * *****************************
                 * @author Saiful Islam <codersaiful@gmail.com>
                 * 
                 * Newly Added (V 3.2.5.6) in Column Setting tab at BackEnd/Admin Panel. 
                 * Why added this?
                 * Actually: some thime, User don't want Auto Responsive and dont' want to add column for Mobile or Table,
                 * Then we can handle by this feature.
                 * 
                 * Option added at column_settings.php file.
                 * 
                 * It's actually Manual Swtich for Auto Responsive Detect. If handle by this, than auto responsive device detect option
                 * will not work.
                 */

                $meta_basics = get_post_meta( $post->ID, 'basics', true );
                $responsive_switch = isset( $meta_basics['responsive_switch'] ) ? 'checked="checked"' : '';
                // var_dump($responsive_switch);
                ?>
                <input name="basics[responsive_switch]" type="checkbox" id="responsive_switch-switcher" <?php echo esc_attr( $responsive_switch ); ?>>
                <div class="slider round"><!--ADDED HTML -->
                    <span class="on">Off</span><span class="off">On</span><!--END-->
                </div>
            </label>
            <p class="warning">
                <b>Tips:</b>
                <span>If not set any column for mobile and tablet, our Plugin will generate a mobile responsive Table automatically. Turn off 'Auto Responsive' If you don't want an auto-responsive table.</span>
            </p>
        </div>
        <br>
        <br>
    </div>
    <nav class="inside-nav-tab-wrapper">
        <a data-target="inside-desktop" data-device="desktop" class="wpt_inside_nav_tab nav-tab nav-tab-active"><?php echo esc_html__( 'Desktop','woo-product-table' ); ?></a>
        <a data-target="inside-tablet" data-device="tablet" class="wpt_inside_nav_tab nav-tab"><?php echo esc_html__( 'Tablet','woo-product-table' ); ?></a>
        <a data-target="inside-mobile" data-device="mobile" class="wpt_inside_nav_tab nav-tab"><?php echo esc_html__( 'Mobile','woo-product-table' ); ?></a>
    </nav>
    
    
    <div id="inside-desktop" class="inside_tab_content tab-content tab-content-active">
<?php 
$enabled_column_array = $enabled_column_array_name;

$availe_column_list_file = __DIR__ . '/inc-column/available-column-list.php';
include $availe_column_list_file;


$column_list_file = __DIR__ . '/inc-column/column-list.php';
include $column_list_file;


?>
    </div>
    
    
    
    <div id="inside-tablet" class="inside_tab_content tab-content">
    
<?php 




$_device_name = '_tablet';

$tablet_header_file = __DIR__ . '/inc-column/tablet-header.php';
include $tablet_header_file;
?>
<p class="device_wise_col_message"><?php echo esc_html__( 'Set columns for tablet, otherwise desktop columns will be shown on tablet.', 'woo-product-table' ); ?></p>
<?php
$availe_column_list_file = __DIR__ . '/inc-column/available-column-list.php';
include $availe_column_list_file;

$column_list_file = __DIR__ . '/inc-column/column-list.php';
include $column_list_file;


?>
    </div>
    
    
    
    
    
    <div id="inside-mobile" class="inside_tab_content tab-content">
<?php 
$_device_name = '_mobile';

$tablet_header_file = __DIR__ . '/inc-column/mobile-header.php';
include $tablet_header_file;
?>
<p class="device_wise_col_message"><?php echo esc_html__( 'Set columns for mobile, otherwise tablet columns will be shown on mobile.', 'woo-product-table' ); ?></p>
<?php
$availe_column_list_file = __DIR__ . '/inc-column/available-column-list.php';
include $availe_column_list_file;

$column_list_file = __DIR__ . '/inc-column/column-list.php';
include $column_list_file;


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