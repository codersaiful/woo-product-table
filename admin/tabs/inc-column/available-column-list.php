
<!-- Enable Active Collumn -->
<div class="add_switch_col_wrapper">
    <div class="section ultraaddons-panel add_new_column">
        <?php
        
        
        //ksort($columns_array);
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
            <h2><?php echo esc_html__( 'Click from Following list to add as Column.', 'wpt_pro' ); ?></h2>
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
