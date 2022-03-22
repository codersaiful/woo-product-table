
<!-- Add new Custom Collumn -->
<div class="add_new_col_wrapper">
    <div class="section ultraaddons-panel add_new_column">
        <h3 class="with-background dark-background slim-title"><?php echo esc_html__( 'Add New Column','wpt_pro' ); ?> <small style="color: orange; font-size: 12px;"></small></h3>

        <table class="ultraaddons-table">
            <tbody>
                <tr>
                    <th><label class=""><?php echo esc_html__( 'Column Keyword','wpt_pro' ); ?></label></th>
                        <td>
                           <input class="and_new_column_key wpt_data_filed_atts ua_input" type="text" placeholder="Column Keyword">
                        </td>

                </tr>
                <tr>
                    <th><label><?php echo esc_html__( 'Column Label','wpt_pro' ); ?></label></th>
                        <td>
                            <input class="and_new_column_label wpt_data_filed_atts ua_input" type="text" placeholder="Column Label">
                        </td>

                </tr>

                <tr>
                    <th><label><?php echo esc_html__( 'Column Type','wpt_pro' ); ?></label></th>
                        <td>


        <?php
            $add_new_col_type = array(
                'default' => __( 'Default/No Type', 'wpt_pro' ),
                'custom_field' => __( 'Custom Field', 'wpt_pro' ),
                'taxonomy' => __( 'Taxonomy', 'wpt_pro' ),
            );
            
            if( ! wpt_is_pro() ){
                $add_new_col_type[] = __( 'Blank', 'wpt_pro' );
                $add_new_col_type[] = __( 'Advance Custom Field', 'wpt_pro' );
                $add_new_col_type[] = __( 'Action Hooks', 'wpt_pro' );
                $add_new_col_type[] = __( 'Array type Custom Field', 'wpt_pro' );
                $add_new_col_type[] = __( 'Audio File Type', 'wpt_pro' );
                $add_new_col_type[] = __( 'All Type Content', 'wpt_pro' );
            }
            
            $add_new_col_type = apply_filters( 'wpto_addnew_col_arr', $add_new_col_type, $columns_array, $column_settings, $post );
            if( is_array( $add_new_col_type ) && count( $add_new_col_type ) > 1 ){
            echo '<select class="add_new_column_type_select ua_select">';
            foreach($add_new_col_type as $an_key => $an_val){
                $disable = is_numeric($an_key) ? 'disabled' : '';
                $pro = is_numeric($an_key) ? __( '(Pro)' ) : '';
                echo "<option value='{$an_key}' {$disable}>$an_val $pro</option>";
            }
            echo '</select>';
            }
        ?>
                            
                            <p><?php echo esc_html__( 'Such as Taxonomy, Custom Field, ACF Custom Field etc.','wpt_pro' ); ?></p>
                        </td>

                </tr>

            </tbody>
        </table>
        <div class="ultraaddons-button-wrapper">
            <button class="button-primary button-primary primary button add_new_column_button"><?php esc_html_e( 'Add New Column', 'wpt_pro' );?></button>
        </div>
    </div>
</div>