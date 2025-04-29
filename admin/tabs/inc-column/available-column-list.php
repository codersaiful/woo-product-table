<?php 
$columns_array = apply_filters( 'wpto_final_column_arr', $columns_array );
// dd($columns_array);
?>
<!-- Enable Active Collumn -->
<div class="add_switch_col_wrapper">
    <div class="section ultraaddons-panel add_new_column">
        <?php
        
        

        ?>

        <div class="section-header">
            <button id="wpt-add-preset-column" class="wpt-btn wpt-btn-small wpt-has-icon wpt-add-preset-column">
                <span><i class="wpt-plus"></i></span>
                <strong class="form-submit-text">Preset Column</strong>
            </button>
            <div id="wpt-dropdown-container" class="wpt-dropdown-container" style="display:none;">
                <div class="wpt-dropdown-container-insider">
                    <input type="text" id="wpt-search" placeholder="Search..." class="wpt-search-box" />
                    <ul id="wpt-dropdown-list" class="wpt-dropdown-list">
                    <?php 
                    /*********************
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
                <?php }
                *****************/
                ?>
                    </ul>
                </div>
            </div>
        </div>
        <br style="clear: both;">
        <div class="section enable-available-cols switch-enable-available" id="wpt-switch-wrapper">
            <ul id="wpt-switch-list">
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
