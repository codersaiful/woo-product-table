
<!-- Add new Custom Collumn -->
<div class="add_new_col_wrapper">
    <div class="section ultraaddons-panel add_new_column">
        <h3 class="with-background dark-background slim-title"><?php echo esc_html__( 'Add New Column','woo-product-table' ); ?> <small style="color: orange; font-size: 12px;"></small></h3>

        <table class="ultraaddons-table">
            <tbody>
                <tr>
                    <th><label class=""><?php echo esc_html__( 'Column Keyword','woo-product-table' ); ?></label></th>
                        <td>
                           <input class="and_new_column_key wpt_data_filed_atts ua_input" type="text" placeholder="Column Keyword">
                        </td>
                </tr>
                <tr>
                    <th><label><?php echo esc_html__( 'Column Label','woo-product-table' ); ?></label></th>
                        <td>
                            <input class="and_new_column_label wpt_data_filed_atts ua_input" type="text" placeholder="Column Label">
                        </td>
                </tr>
                <tr>
                    <th><label><?php echo esc_html__( 'Column Type','woo-product-table' ); ?></label></th>
                        <td>
                            <?php
                                $add_new_col_type = array(
                                    'default' => __( 'Default/No Type', 'woo-product-table' ),
                                    'custom_field' => __( 'Custom Field', 'woo-product-table' ),
                                    'taxonomy' => __( 'Taxonomy', 'woo-product-table' ),
                                );
                                
                                if( ! wpt_is_pro() ){
                                    $add_new_col_type[] = __( 'Blank', 'woo-product-table' );
                                    $add_new_col_type[] = __( 'Advance Custom Field', 'woo-product-table' );
                                    $add_new_col_type[] = __( 'Action Hooks', 'woo-product-table' );
                                    $add_new_col_type[] = __( 'Array type Custom Field', 'woo-product-table' );
                                    $add_new_col_type[] = __( 'Audio File Type', 'woo-product-table' );
                                    $add_new_col_type[] = __( 'All Type Content', 'woo-product-table' );
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
                            <p><?php echo esc_html__( 'Such as Taxonomy, Custom Field, ACF Custom Field etc.','woo-product-table' ); ?></p>
                        </td>
                </tr>
                <tr>
                    <th><label><?php echo esc_html__( 'Tutorials','woo-product-table' ); ?></label></th>
                        <td class="add-new-column-doc">
                            <?php 
                                wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/add-new-column-using-custom-field/', 'Custom Field');
                                wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/add-custom-taxonomy-as-table-column/', 'Taxonomy'); 
                                wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/how-to-download-file-in-column-using-acf/', 'Advance Custom Field (ACF)');
                                wpt_doc_link('#', 'Action Hooks');
                                wpt_doc_link('#', 'Array Type Custom Field'); 
                                wpt_doc_link('https://wooproducttable.com/docs/doc/tutorials/how-to-create-a-audio-table-using-woo-product-table/', 'Audio File Type'); 
                                wpt_doc_link('#', 'All Type Content'); 
                                wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/show-variation-name-in-a-single-column/', 'Single Variation'); 
                             ?>
                        </td>
                </tr>
            </tbody>
        </table>
        <button class="wpt-btn wpt-btn-small wpt-has-icon add_new_column_button">
            <span><i class="wpt-plus"></i></span>
            <strong class="form-submit-text">
                <?php esc_html_e( 'Add New Column', 'woo-product-table' );?>
            </strong>
        </button>
    </div>
</div>