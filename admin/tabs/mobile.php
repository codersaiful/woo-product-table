<?php
$meta_mobile =  get_post_meta( $post->ID, 'mobile', true );
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
                    <option value="no_responsive" <?php echo isset( $meta_mobile['mobile_responsive'] ) && $meta_mobile['mobile_responsive'] == 'no_responsive' ? 'selected' : ''; ?>><?php esc_html_e( 'No Responsive', 'wpt_pro' ); ?></option>
                </select>
                <p>
                    If you want to work with <strong>Responsive</strong> Tab, Please select <strong>No Responsive</strong>.
                </p>
            </td>
        </tr>
    </table>
    
</div>

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
<ul id="wpt_keyword_hide_mobile">
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
