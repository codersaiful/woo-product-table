<?php
$wpt_style_file_selection_options = WPT_Product_Table::$style_form_options;

?>
<div class="section ultraaddons-panel">
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_style_file_selection"><?php esc_html_e( 'Select Template', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <select name="table_style[template]" data-name="template" id="wpt_style_file_selection"  class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <?php
                        foreach ( $wpt_style_file_selection_options as $key => $value ) {
                            echo "<option value='" . esc_attr( $key ) . "' ";
                            echo isset( $meta_table_style['template'] ) && $meta_table_style['template'] == $key ? 'selected' : '' ;
                            echo ">" . esc_html( $value ) . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
    </div>
</div>