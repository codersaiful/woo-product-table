
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
                            
                            <p>Such as Taxonomy, Custom Field, ACF Custom Field etc.</p>
                        </td>

                </tr>

            </tbody>
        </table>
        <div class="ultraaddons-button-wrapper">
            <button class="button-primary button-primary primary button add_new_column_button"><?php esc_html_e( 'Add New Column', 'wpt_pro' );?></button>
        </div>
    </div>
</div>