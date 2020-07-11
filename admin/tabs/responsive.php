<?php
$meta_responsive = get_post_meta( $post->ID, 'responsive', true );

$column_array = $meta_column_array = get_post_meta( $post->ID, 'column_array', true );
 
if( !$meta_column_array && empty( $meta_column_array ) ){
    $column_array = WPT_Product_Table::$columns_array;
}

$supported_device = array(
    'mobile'    => 'Mobile Columns', 
    'tablet'    => 'Tablet Column'
);
/**
 * @Hook Filter: wpto_responsive_device_arr
 * to add change Supported Device List to your Admin Post Edit of Product Table
 * ****Only for Admin Area, not for Front data change
 */
$supported_device = apply_filters( 'wpto_responsive_device_arr', $supported_device, $post, $column_array, $meta_responsive );
if( !is_array( $supported_device ) || ( is_array( $supported_device ) && count( $supported_device ) < 1 ) || !is_array( $column_array ) || ( is_array( $column_array ) && count( $column_array ) < 1 ) ){
    return;
}?>
<div class="section ultraaddons">
    <table class="ultraaddons-table">
        <tr>

    <?php foreach( $supported_device as $devc_key => $devc_name ){
    ?>
            <td class="responsive td_<?php echo esc_attr( $devc_key ); ?>">
                <div class="wpt_responsive_wraper">
                    <div class="wpt_res_wrapper_inside ultraaddons-panel">
                        <h1 class="with-background dark-background"><?php echo $devc_name; ?></h1>
                        <div class="wpt_responsive_each_wraper responsive_wrapper_<?php echo esc_attr( $devc_key ); ?>">
                            <?php
                                $r_selected_column = isset( $meta_responsive[$devc_key] ) && is_array( $meta_responsive[$devc_key] ) ? $meta_responsive[$devc_key] : false;
                                /**
                                 * @Hook Filter: wpto_responsive_col_arr
                                 * To set Default Column Array Key for All device, About to set Condition using $post, $devc_key (mobile,tablet) etc
                                 * $post: mean, This Product Table Post, where available all setting
                                 * 
                                 * ** Only for Admin Area, not for Front data change
                                 */
                                $r_selected_column = apply_filters( 'wpto_responsive_col_arr', $r_selected_column, $post, $devc_key );
                                
                                /**
                                 * $Hook Filter: wpto_responsive_col_arr_$devc_key | Here: $devc_key mean, index of Supported Device array. such: array('mobile'=>"Mobile Device")
                                 * About to set Condition using $post, $devc_key (mobile,tablet) etc
                                 * $post: mean, This Product Table Post, where available all setting
                                 */
                                $r_selected_column = apply_filters( 'wpto_responsive_col_arr_' . $devc_key, $r_selected_column, $post );
                                
                                $r_columns = $column_array;
                                if( $r_selected_column ){
                                    $r_columns = array_merge( $r_selected_column, $column_array );
                                }
                                //$sss = ;
                            foreach( $r_columns as $key => $value ){
                            $selected = isset( $meta_responsive[$devc_key][$key] ) && $meta_responsive[$devc_key][$key] == $key ? 'checked' : false;
                            $id = $devc_key . '_' . $key;
                            ?>
                            <div class="responsive_each">
                                <input type="checkbox" 
                                       id="<?php echo esc_attr( $id ); ?>"
                                       name="responsive[<?php echo esc_attr( $devc_key ); ?>][<?php echo esc_attr( $key ); ?>]" 
                                       value="<?php echo esc_attr( $key ); ?>"
                                       <?php echo $selected; ?>>
                                <label for="<?php echo esc_attr( $id ); ?>"><?php echo $value; ?> - <small>(<?php echo $key; ?>)</small></label>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </td>
        
<?php
}
?>
        </tr>
    </table>
</div>