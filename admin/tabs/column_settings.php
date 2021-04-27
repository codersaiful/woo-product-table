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
    //$column_settings['product_title']['items'] = array( 'sku', 'rating','stock', 'price', 'quantity' );
    //Price - will be add h4 tag
    //Sku will add special something
    //Mobile Version er jonno Blank niye sekhane action,title,sku,qunatity,price add korte hobe.
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
?>
<ul id="wpt_column_sortable">
    <?php
    /**
     * Here was $columns_array
     * I have added new $meta_enable_column_array
     * 
     * Because: In new version, We will show only Enabled Col here
     * 
     * 
     */
    foreach( $columns_array as $keyword => $title ){  //Here was $columns_array in new: $meta_enable_column_array
        $updated_title = isset( $updated_columns_array[$keyword] ) ? $updated_columns_array[$keyword] : $title;
        if( $meta_enable_column_array && !empty( $meta_enable_column_array ) && is_array( $meta_enable_column_array ) ){
            $enabled_class = $checked_attribute = '';
            if( in_array( $keyword, array_keys( $meta_enable_column_array ) ) ){
                $enabled_class = 'enabled';
                $checked_attribute = ' checked="checked"';
            }
        }else{
            $enabled_class = 'enabled';
            $checked_attribute = ' checked="checked"';
            if( !in_array( $keyword, $default_enable_array ) ){
                $enabled_class = $checked_attribute = '';
            }
        }
        $readOnly = ( $keyword == 'check' ? 'readonly' : false );
    ?>
    <li class="wpt_sortable_peritem <?php echo esc_attr( $enabled_class ); ?> column_keyword_<?php echo esc_attr( $keyword ); ?>">
        <span title="<?php esc_attr_e( 'Move Handle', 'wpt_pro' );?>" class="handle"></span>
        <div class="wpt_shortable_data">
            <input placeholder="<?php echo $keyword; ?>" 
                   name="column_array[<?php echo $keyword; ?>]"  
                   data-column_title="<?php echo esc_attr__( $updated_title,'wpt_pro' ); ?>" 
                   data-keyword="<?php echo esc_attr( $keyword ); ?>" 
                   class="colum_data_input <?php echo esc_attr( $keyword ); ?>" 
                   type="text" 
                   value="<?php echo htmlentities( $updated_title ); ?>" <?php echo $readOnly; ?>>
            
            <?php
            //Type Maintenance
            $type = isset( $column_settings[$keyword]['type'] ) && !empty( $column_settings[$keyword]['type'] ) ? $column_settings[$keyword]['type'] : 'default';
            $type_name = isset( $column_settings[$keyword]['type_name'] ) && !empty( $column_settings[$keyword]['type_name'] ) ? $column_settings[$keyword]['type_name'] : __( 'Default', 'wpt_pro' );
            ?>
            <input type="hidden" name="column_settings[<?php echo esc_attr( $keyword ); ?>][type]" value="<?php echo esc_attr( $type ); ?>">
            <input type="hidden" name="column_settings[<?php echo esc_attr( $keyword ); ?>][type_name]" value="<?php echo esc_attr( $type_name ); ?>">
            
            <span class="wpt_colunm_type">
            <?php if( !empty( $type ) &&  $type !== 'default'){ ?>
                <i><?php echo esc_html__( $type_name); ?> </i>: 
            <?php } echo esc_html__( $keyword ); ?>
            </span>
            <?php 
            
            if( in_array($keyword,$additional_collumn) ){
            ?>
                <span title='Remove this Column' onclick="return confirm('Deleting this Column\nAre you sure?');" class='wpt_column_cross'>X</span>
            <?php
            }
            ?>
            
            
            <div class="wpt_column_setting_single_extra">
                <?php do_action( 'wpto_column_setting_form_' . $keyword, $column_settings, $columns_array, $updated_columns_array, $post, $additional_data ); ?>
            </div>
            <span data-key="<?php echo esc_attr( $keyword ); ?>" class="extra_all_on_off on_now"><i class="on_off_icon"></i>Expand</span>
            <div class="wpt_column_setting_extra for_all extra_all_<?php echo esc_attr( $keyword ); ?>">
                <?php do_action( 'wpto_column_setting_form_inside_' . $keyword, $column_settings, $columns_array, $updated_columns_array, $post, $additional_data ); ?>
                <?php do_action( 'wpto_column_setting_form', $keyword, $column_settings, $columns_array, $updated_columns_array, $post, $additional_data ); ?>
                
            </div>
            <div class="wpt_column_setting_extra for_all profeatures-message">
                <?php do_action( 'wpo_pro_feature_message', 'column_extra' ); ?>
            </div>
            

        </div>
        <span class="wpt_column_arrow wpt_arrow_top" data-target="prev" data-keyword="<?php echo esc_attr( $keyword ); ?>">&uArr;</span>
        <span class="wpt_column_arrow wpt_arrow_down" data-target="next" data-keyword="<?php echo esc_attr( $keyword ); ?>">&dArr;</span>
        <span title="<?php esc_attr_e( 'Move Handle', 'wpt_pro' );?>" class="handle checkbox_handle">
            <input name="enabled_column_array[<?php echo $keyword; ?>]" 
                   value="<?php echo $keyword; ?>" 
                   title="<?php echo esc_html__( 'Active Inactive Column', 'wpt_pro' );?>" 
                   class="checkbox_handle_input <?php echo esc_attr( $enabled_class ); ?>" 
                   type="checkbox" 
                   data-column_keyword="<?php echo esc_attr( $keyword ); ?>" <?php echo $checked_attribute; ?>>
        </span>
    </li>
    <?php
    
    }
    ?>

</ul>



<?php 

//var_dump($meta_enable_column_array);
/**
 * Column list, where available all columns part
 * 
 * @since 2.8.4.1
 * @by Saiful
 * @date 27.4.2021
 */
$column_list_file = __DIR__ . '/inc-column/column-list.php';

include $column_list_file;


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
