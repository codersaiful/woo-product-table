<?php
$meta_conditions =  get_post_meta( $post->ID, 'conditions', true );
?>
<div class="section ultraaddons-panel">
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_shorting"><?php esc_html_e( 'Sorting/Order', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <select name="conditions[sort]" data-name='sort' id="wpt_table_shorting" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="ASC" <?php echo isset( $meta_conditions['sort'] ) && $meta_conditions['sort'] == 'ASC' ? 'selected' : ''; ?>><?php esc_html_e( 'ASCENDING (Default)', 'wpt_pro' ); ?></option>
                        <option value="DESC" <?php echo isset( $meta_conditions['sort'] ) && $meta_conditions['sort'] == 'DESC' ? 'selected' : ''; ?>><?php esc_html_e( 'DESCENDING', 'wpt_pro' ); ?></option>
                        <option value="random" <?php echo isset( $meta_conditions['sort'] ) && $meta_conditions['sort'] == 'random' ? 'selected' : ''; ?>><?php esc_html_e( 'Random', 'wpt_pro' ); ?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>


    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_sort_order_by"><?php esc_html_e( 'Order By', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <select name="conditions[sort_order_by]" data-name='sort_order_by' id="wpt_table_sort_order_by" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="name" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'name' ? 'selected' : ''; ?>><?php esc_html_e( 'Name (Default)', 'wpt_pro' ); ?></option>
                        <option value="menu_order" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'menu_order' ? 'selected' : ''; ?>><?php esc_html_e( 'Menu Order', 'wpt_pro' ); ?></option> <!-- default menu_order -->

                        <option value="meta_value" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'meta_value' ? 'selected' : ''; ?>><?php esc_html_e( 'Custom Meta Value', 'wpt_pro' ); ?></option>
                        <option value="meta_value_num" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'meta_value_num' ? 'selected' : ''; ?>><?php esc_html_e( 'Custom Meta Number (if numeric data)', 'wpt_pro' ); ?></option>
                        <option value="date" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'date' ? 'selected' : ''; ?>><?php esc_html_e( 'Date', 'wpt_pro' ); ?></option>

                        <option value="ID" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'ID' ? 'selected' : ''; ?>><?php esc_html_e( 'ID', 'wpt_pro' ); ?></option>
                        <option value="author" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'author' ? 'selected' : ''; ?>><?php esc_html_e( 'Author', 'wpt_pro' ); ?></option>
                        <option value="title" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'title' ? 'selected' : ''; ?>><?php esc_html_e( 'Product Title', 'wpt_pro' ); ?></option>

                        <option value="type" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'type' ? 'selected' : ''; ?>><?php esc_html_e( 'Type', 'wpt_pro' ); ?></option>

                        <option value="modified" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'modified' ? 'selected' : ''; ?>><?php esc_html_e( 'Modified', 'wpt_pro' ); ?></option>
                        <option value="parent" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'parent' ? 'selected' : ''; ?>><?php esc_html_e( 'Parent', 'wpt_pro' ); ?></option>
                        <option value="rand" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'rand' ? 'selected' : ''; ?>><?php esc_html_e( 'Rand', 'wpt_pro' ); ?></option>
                        <option value="comment_count" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'comment_count' ? 'selected' : ''; ?>><?php esc_html_e( 'Reviews/Comment Count', 'wpt_pro' ); ?></option>
                        <option value="relevance" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'relevance' ? 'selected' : ''; ?>><?php esc_html_e( 'Relevance', 'wpt_pro' ); ?></option> 
                        <option value="none" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'none' ? 'selected' : ''; ?>><?php esc_html_e( 'None', 'wpt_pro' ); ?></option>
                    </select>
                    <p>Chose 'Custom_meta or custom_meta_value' - if you want to sort by price, model, sku, color itc. <b>For price or any number, Please chose <span>Custom Meta value(if number)</span></b></p>
                </td>
            </tr>
        </table>
    </div>
    <div style="display: none;" class="wpt_column" id="wpt_meta_value_wrapper">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_product_meta_value_sort"><?php echo sprintf( esc_html__( 'Meta Value for [Custom Meta Value] of %s Custom Meta Value %s', 'wpt_pro' ),'<b>','</b>' ); ?></label>
                </th>
                <td>
                    <input name="conditions[meta_value_sort]" value="<?php echo isset( $meta_conditions['meta_value_sort'] ) ? $meta_conditions['meta_value_sort'] : ''; ?>" data-name='meta_value_sort' id="wpt_product_meta_value_sort" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="text">
                    <p style="color: #00aef0;"><?php esc_html_e( 'Type your Right meta value here. EG: "_sku,_price,_customNumber" - use any one only, there should no any space or comma', 'wpt_pro' ); ?></p>
                </td>
            </tr>
        </table>
    </div>

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_product_min_price"><?php esc_html_e( 'Set Minimum Price', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <input name="conditions[min_price]" data-name='min_price' value="<?php echo isset( $meta_conditions['min_price'] ) ?$meta_conditions['min_price'] : ''; ?>" id="wpt_product_min_price" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="number" pattern="[0-9]*">
                </td>
            </tr>
        </table>
    </div>
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_product_max_price"><?php esc_html_e( 'Set Maximum Price', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <input name="conditions[max_price]" data-name='max_price' value="<?php echo isset( $meta_conditions['max_price'] ) ?$meta_conditions['max_price'] : ''; ?>" id="wpt_product_max_price" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="number" pattern="[0-9]*">
                </td>
            </tr>
        </table>
    </div>
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_description_type"><?php esc_html_e( 'Description Type', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <select name="conditions[description_type]" data-name='description_type' id="wpt_table_description_type" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="short_description" <?php echo isset( $meta_conditions['description_type'] ) && $meta_conditions['description_type'] == 'short_description' ? 'selected' : ''; ?>><?php esc_html_e( 'Short Description', 'wpt_pro' ); ?></option><!-- Default Value -->
                        <option value="description" <?php echo isset( $meta_conditions['description_type'] ) && $meta_conditions['description_type'] == 'description' ? 'selected' : ''; ?>><?php esc_html_e( 'Long Description', 'wpt_pro' ); ?></option>
                    </select>
                    <p style="color: #0087be;"><?php echo sprintf( esc_html__( 'Here was %sdescription_lenght%s, But from 3.6, We have removed %sdescription_lenght%s', 'wpt_pro' ),'<b>','</b>','<b>','</b>' ); ?>.</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_only_stock"><?php esc_html_e( 'Only Stock Product', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <select name="conditions[only_stock]" data-name='only_stock' id="wpt_table_only_stock" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="" <?php echo isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == '' ? 'selected' : ''; ?>><?php esc_html_e( 'All Product', 'wpt_pro' ); ?></option>
                        <option value="instock" <?php echo isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == 'instock' ? 'selected' : ''; ?>><?php esc_html_e( 'instock', 'wpt_pro' ); ?></option>
                        <option value="onbackorder" <?php echo isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == 'onbackorder' ? 'selected' : ''; ?>><?php esc_html_e( 'onbackorder', 'wpt_pro' ); ?></option>
                        <option value="outofstock" <?php echo isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == 'outofstock' ? 'selected' : ''; ?>><?php esc_html_e( 'outofstock', 'wpt_pro' ); ?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_only_sale"><?php esc_html_e( 'Only Sale Products', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <select name="conditions[only_sale]" data-name='only_sale' id="wpt_table_only_sale" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="no" <?php echo isset( $meta_conditions['only_sale'] ) && $meta_conditions['only_sale'] == 'no' ? 'selected' : ''; ?>><?php esc_html_e( 'All Product', 'wpt_pro' ); ?></option>
                        <option value="yes" <?php echo isset( $meta_conditions['only_sale'] ) && $meta_conditions['only_sale'] == 'yes' ? 'selected' : ''; ?>><?php esc_html_e( 'Yes (Only Sale)', 'wpt_pro' ); ?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>


    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_posts_per_page"><?php esc_html_e( 'Post Limit/Per Load Limit', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <input name="conditions[posts_per_page]" data-name='posts_per_page' value="<?php echo isset( $meta_conditions['posts_per_page'] ) ?$meta_conditions['posts_per_page'] : '20'; ?>" id="wpt_posts_per_page" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="number" pattern="[0-9]*" placeholder="<?php esc_attr_e( 'Eg: 50 (for display 20 products', 'wpt_pro' ); ?>" value="20">
                </td>
            </tr>
        </table>
    </div>

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_table_type"><?php esc_html_e( 'Third Party Addons Supporting ', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <select name="conditions[table_type]" data-name='table_type' id="wpt_table_table_type" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="normal_table" <?php echo isset( $meta_conditions['table_type'] ) && $meta_conditions['table_type'] == 'normal_table' ? 'selected' : ''; ?>><?php esc_html_e( 'No', 'wpt_pro' ); ?></option>
                        <option value="advance_table" <?php echo isset( $meta_conditions['table_type'] ) && $meta_conditions['table_type'] == 'advance_table' ? 'selected' : ''; ?>><?php esc_html_e( 'Yes', 'wpt_pro' ); ?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
</div>