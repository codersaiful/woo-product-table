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


<!-- Enable Active Collumn -->
<div class="add_switch_col_wrapper">
    <div class="section ultraaddons-panel add_new_column">
        <h3 class="with-background dark-background slim-title"><?php echo esc_html__( 'Column Activation', 'wpt_pro' ); ?> <small style="color: orange; font-size: 12px;"></small></h3>

        <?php
        
        
        ksort($columns_array);
//        $meta_enable_column_array = get_post_meta( $post->ID, 'enabled_column_array', true );
//        if( $meta_enable_column_array && !empty( $meta_enable_column_array ) && !empty( $columns_array ) ){
//            $columns_array = array_merge($meta_enable_column_array,$columns_array);
//        }
//
//        $column_settings = get_post_meta( $post->ID, 'column_settings', true ); 
//        if( empty( $column_settings ) ){
//            $column_settings = array();
//        }
//        $additional_collumn = array_diff(array_keys($for_add), array_keys( WPT_Product_Table::$columns_array ));

        ?>
        <div class="section enable-available-cols switch-enable-available">
            <p><?php echo esc_html__( 'Activate your Preferred Column.', 'wpt_pro' ); ?></p>
            <ul id="wpt-switch-list">
                <?php 
                foreach( $columns_array as $keyword => $title ){ 
                    $updated_title = isset( $updated_columns_array[$keyword] ) ? $updated_columns_array[$keyword] : $title;
                    if( $meta_enable_column_array && !empty( $meta_enable_column_array ) && is_array( $meta_enable_column_array ) ){
                        $enabled_class = 'item-disabled';
                        $enabled_class = '';
                        if( in_array( $keyword, array_keys( $meta_enable_column_array ) ) ){
                            $enabled_class = 'item-enabled';
                        }
                    }else{
                        $enabled_class = 'item-enabled';
                        if( !in_array( $keyword, $default_enable_array ) ){
                            $enabled_class = 'item-disabled';
                            $enabled_class = '';
                        }
                    }
                    
                ?>
                <li class="switch-enable-item switch-enable-item-<?php echo esc_attr( $keyword ); ?> <?php echo esc_attr( $enabled_class ); ?>" 
                    data-column_keyword="<?php echo esc_attr( $keyword ); ?>">
                        <?php echo esc_html( $updated_title ); ?>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>



<!-- Add new Custom Collumn -->
<div class="add_new_col_wrapper">
    <div class="section ultraaddons-panel add_new_column">
        <h3 class="with-background dark-background slim-title">ADD NEW COLUMN <small style="color: orange; font-size: 12px;"></small></h3>

        <table class="ultraaddons-table">
            <tbody>
                <tr>
                    <th><label class="">COLUMN KEYWORD</label></th>
                        <td>
                           <input class="and_new_column_key wpt_data_filed_atts ua_input" type="text" placeholder="Column Keyword">
                        </td>

                </tr>
                <tr>
                    <th><label>COLUMN LABEL</label></th>
                        <td>
                            <input class="and_new_column_label wpt_data_filed_atts ua_input" type="text" placeholder="Column Label">
                        </td>

                </tr>

                <tr>
                    <th><label>Column Type</label></th>
                        <td>


        <?php
            $add_new_col_type = array(
                'default' => "Default/No Type",
                'custom_field' => 'Custom Field',
                'taxonomy' => 'Taxonomy',
            );
            $add_new_col_type = apply_filters( 'wpto_addnew_col_arr', $add_new_col_type, $columns_array, $column_settings, $post );
            if( is_array( $add_new_col_type ) && count( $add_new_col_type ) > 1 ){
            echo '<select class="add_new_column_type_select ua_select">';
            foreach($add_new_col_type as $an_key => $an_val){
                echo "<option value='{$an_key}'>$an_val</option>";
            }
            echo '</select>';
            }
        ?>
                            
                            <p>Such as Taxnomy, Custom Field, ACF Custom Field etc.</p>
                        </td>

                </tr>

            </tbody>
        </table>
        <div class="ultraaddons-button-wrapper">
            <button class="button-primary button-primary primary button add_new_column_button"><?php esc_html_e( 'Add New Column', 'wpt_pro' );?></button>
        </div>
    </div>
</div>

<!--
<div class="tax_cf_handle_wrapper">
    <p class="tax_cf_message"><?php echo sprintf( esc_html__( 'To add %sTaxonomy%s or %sCustom_Field%s as Table Column for your Table, try from following bottom section before [Publish/Update] your post.', 'wpt_pro' ), '<strong>', '</strong>', '<strong>', '</strong>' );?></p>
    <div id="tax_cf_manager">
        <div class="tax_cf_manager_column tax_cf_manager_choose_column">
            <label class="wpt_label"><?php esc_html_e( 'Choose Type', 'wpt_pro' );?></label>
            <select class="taxt_cf_type">
                <option value="cf_"><?php esc_html_e( 'Custom Field', 'wpt_pro' );?></option>
                <option value="tax_"><?php esc_html_e( 'Custom Taxonomy', 'wpt_pro' );?></option>
            </select>
        </div>
        <div class="tax_cf_manager_column tax_cf_manager_keyword_column">
            <label class="wpt_label"><?php esc_html_e( 'Keyword (only keyword of you Taxonomy or CustomField', 'wpt_pro' );?></label>
            <input type="text" class="taxt_cf_input" placeholder="<?php esc_attr_e( 'eg: color', 'wpt_pro' );?>">
        </div>
        
        <div class="tax_cf_manager_column tax_cf_manager_title_column">
            <label class="wpt_label"><?php esc_html_e( 'Table Column Title/Name', 'wpt_pro' );?></label>
            <input type="text" class="taxt_cf_title" placeholder="<?php esc_attr_e( 'eg: Product Color', 'wpt_pro' );?>">
        </div>
    </div>
    <div>
        <a id="tax_cf_adding_button" class="button button-primary tax_cf_add_button"><?php esc_html_e( 'Add as Column)', 'wpt_pro' );?></a>
    </div>
    <p class="tax_cf_suggesstion">
        <?php 
        echo sprintf(
                esc_html__( 'For custom field, you can use %sAdvanced Custom Fields%s plugin AND for Taxonomy, you can use %sCustom Post Types and Custom Fields creator – WCK%s plugin.%sBesides there are lot of plugin available at %s, Just search on WordPress archives.', 'wpt_pro' ),
               '<a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank">',
               '</a>',
               '<a href="https://wordpress.org/plugins/wck-custom-fields-and-custom-post-types-creator/" target="_blank">',
               '</a>',
               '<br>',
               '<a href="https://wordpress.org/" target="_blank">wordpress.org</a>' 
                );
        ?>
    </p>
    <br style="clear: both;">
</div>
<br>
-->
