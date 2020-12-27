<?php
$meta_mobile =  get_post_meta( $post->ID, 'mobile', true );
if( empty( $meta_mobile ) && ! is_array( $meta_mobile ) && ! isset( $meta_mobile['mobile_responsive'] ) ){
    $meta_mobile = array();
    $meta_mobile['mobile_responsive'] = 'mobile_responsive';
}
?>
<div class="ultraaddons-panel">
    <table class="ultraaddons-table">
        <tr>
            <th>
                <label class="wpt_label" for="wpt_table_mobile_responsive"><?php esc_html_e( 'Mobile Responsive', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <select name="mobile[mobile_responsive]" data-name='mobile_responsive' id="wpt_table_mobile_responsive" class="wpt_fullwidth wpt_data_filed_atts ua_select" >
                    <option value="mobile_responsive" <?php echo isset( $meta_mobile['mobile_responsive'] ) && $meta_mobile['mobile_responsive'] == 'mobile_responsive' ? 'selected' : ''; ?>><?php esc_html_e( 'Auto Responsive (Not Recommended)', 'wpt_pro' ); ?></option>
                    <option value="no_responsive" <?php echo isset( $meta_mobile['mobile_responsive'] ) && $meta_mobile['mobile_responsive'] == 'no_responsive' ? 'selected' : ''; ?>><?php esc_html_e( 'Manual Responsive', 'wpt_pro' ); ?></option>
                </select>
            </td>
        </tr>
    </table>
    
</div>

<script>
    jQuery(document).ready(function($){
        $("select#wpt_table_mobile_responsive").click(function(){
            let sel_value = $(this).val();
            $('.responsive-part').css('display','none');
            $('.responsive-part.' + sel_value).css('display','block');
        });
    });
</script>

<?php

$colums_disable_array = array();//WPT_Product_Table::$colums_disable_array;
$colums_disable_array = array_map(function($value){
    $minus_from_disabledArray = array(
        'quick',
        'wishlist',
        'quoterequest',
        'Message',
       'attribute',
       'variations',
       'wishlist',
       'quoterequest',
        //'ssss',
    );
    return !in_array( $value, $minus_from_disabledArray ) ? $value : false;
}, $colums_disable_array);
$colums_disable_array = array_filter( $colums_disable_array );
//$colums_disable_array[] = 'thumbnails';

if( isset( $meta_mobile['disable'] ) && is_array( $meta_mobile['disable'] ) ){
    $colums_disable_array = $meta_mobile['disable'];
}elseif( isset( $meta_mobile['mobile_responsive'] ) && !isset( $meta_mobile['disable'] ) ){
    $colums_disable_array = array();
}

$meta_column_array = $columns_array = get_post_meta( $post->ID, 'column_array', true ); //Getting value from updated column tab
if( !$meta_column_array && empty( $meta_column_array ) ){
    $columns_array = WPT_Product_Table::$columns_array;
}
unset( $columns_array['product_title'] );
unset( $columns_array['price'] );

unset( $columns_array['action'] );
unset( $columns_array['check'] );


?>
<ul id="wpt_keyword_hide_mobile" class="responsive-part mobile_responsive"
    style="display: <?php echo $meta_mobile['mobile_responsive'] == 'mobile_responsive' ? '' : 'none';  ?>"
    >
    <h1 style="color: #D01040;"><?php esc_html_e( 'Hide On Mobile', 'wpt_pro' ); ?></h1>
    <p style="padding: 0;margin: 0;"><?php esc_html_e( 'Pleach check you column to hide from Mobile. For all type Table(Responsive or Non-Responsive).', 'wpt_pro' ); ?></p>
    <hr>
        <?php
    foreach( $columns_array as $keyword => $title ){
        $enabled_class = 'enabled';
        $checked_attribute = ' checked="checked"';
        if( !in_array( $keyword, $colums_disable_array ) ){
            $enabled_class = $checked_attribute = '';
        }
    ?>
    <li class="hide_on_mobile_permits <?php echo $enabled_class; ?> column_keyword_<?php echo esc_attr( $keyword ); ?>">
        
        <div class="wpt_mobile_hide_keyword">
            <b  data-column_title="<?php echo esc_attr( $title ); ?>" data-keyword="<?php echo esc_attr( $keyword ); ?>" class="mobile_issue_field <?php echo esc_attr( $keyword ); ?>" type="text" ><?php echo $title; ?></b>
        </div>
        <span title="<?php echo esc_attr( $keyword ); ?>"  title="<?php esc_attr_e( 'Move Handle', 'wpt_pro' ); ?>" class="handle checkbox_handle">
            <input  name="mobile[disable][]" value="<?php echo esc_attr( $keyword ); ?>"  title="<?php esc_attr_e( 'Active Inactive Column', 'wpt_pro' ); ?>" class="checkbox_handle_input <?php echo $enabled_class; ?>" type="checkbox" data-column_keyword="<?php echo esc_attr( $keyword ); ?>" <?php echo $checked_attribute; ?>>
        </span>
    </li>
    <?php

    }
    ?>

</ul>

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
<div class="section ultraaddons responsive-part no_responsive" id="manual-responsive-wrapper"
     style="display: <?php echo $meta_mobile['mobile_responsive'] == 'mobile_responsive' ? 'none' : '';  ?>"
     >
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
