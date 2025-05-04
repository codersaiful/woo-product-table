<?php 
$columns_array = apply_filters( 'wpto_final_column_arr', $columns_array );
$premium_column = [
    'category' => __('Category', 'woo-product-table'),
    'stock' => __('Stock', 'woo-product-table'),
    'total' => __('Total', 'woo-product-table'),
    'sku' => __('SKU', 'woo-product-table'),
    'message' => __('Short Message', 'woo-product-table'),
    'short_description' => __('Short Description', 'woo-product-table'),
    'shortcode' => __('Shortcode', 'woo-product-table'),
    'content' => __('Content', 'woo-product-table'),
    'audio_player' => __('Audio', 'woo-product-table'),
    'quick_qty' => __('Quick Qty', 'woo-product-table'), //Added at V7.0.9.0
    'variation_name' => __('Variation Name', 'woo-product-table'), //Added at V8.0.3.1
    'viewed' => __('Viewed', 'woo-product-table'), //Added at V8.0.1.0
    'toggle_description' => __('Toggle Description', 'woo-product-table'),
];
$available_column_array = array_merge( $premium_column, $columns_array );
asort($available_column_array);

?>
<!-- Enable Active Collumn -->
<div class="add_switch_col_wrapper">
    <div class="section ultraaddons-panel add_new_column add_new_column_main_wrapper" data-device="<?php echo esc_attr( $_device_name ); ?>">
        <?php
        
        

        ?>

        <div class="section-header">
            <button id="wpt-add-preset-column" class="wpt-btn wpt-btn-small wpt-has-icon wpt-add-preset-column">
                <span><i class="wpt-plus"></i></span>
                <strong class="form-submit-text">Preset Column</strong>
            </button>
            <button id="wpt-add-new-custom-column-btn" class="wpt-btn wpt-btn-small wpt-has-icon wpt-add-new-custom-column-btn">
                <span><i class="wpt-plus-circle"></i></span>
                <strong class="form-submit-text">Custom Column</strong>
            </button>
            <div id="wpt-dropdown-container" class="wpt-dropdown-container" style="display:none;">
                <div class="wpt-dropdown-container-insider">
                    <input type="text" id="wpt-search" placeholder="Search column..." class="wpt-column-search-box" />
                    <ul id="wpt-dropdown-list" class="wpt-dropdown-list">
                    <?php 
                    /*********************/
                // $available_column_array = $columns_array;

                // sort columns array by title
                // rsort($available_column_array);
                


                // asort($available_column_array);
                foreach( $available_column_array as $keyword => $title ){ 
                    // dd($keyword);
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

                    //eta specially pro badge dekhanor jonno ebong eta js er maddhome off kore dite hobe, jodi disabled thake
                    $premium = in_array( $keyword, array_keys( $premium_column ) ) ? 'premium' : '';
                    
                ?>
                <li class="switch-enable-item switch-enable-item-<?php echo esc_attr( $keyword . ' ' . $enabled_class . ' ' . $premium ); ?>" 
                    title="<?php echo esc_html( "key: $keyword & title: $updated_title" ); ?>"
                    data-column_keyword="<?php echo esc_attr( $keyword ); ?>">
                        <?php echo esc_html( $updated_title ); ?><i>[<?php echo esc_html( $keyword ); ?>]</i>
                </li>
                <?php }
                //*****************/
                ?>
                    </ul>
                </div>
            </div>
        </div>
        <br style="clear: both;">
        <div class="section enable-available-cols switch-enable-available" id="wpt-switch-wrapper">
            <ul id="wpt-switch-list" class="wpt-switch-list">
                <?php 
                $available_column_array = $columns_array;
                // asort($available_column_array);
                foreach( $available_column_array as $keyword => $title ){ 
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
                    title="<?php echo esc_html( "key: $keyword & title: $updated_title" ); ?>"
                    data-column_keyword="<?php echo esc_attr( $keyword ); ?>">
                        <?php echo esc_html( $updated_title ); ?><i>[<?php echo esc_html( $keyword ); ?>]</i>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
