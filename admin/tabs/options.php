<?php

$meta_basics = get_post_meta( $post->ID, 'basics', true );
$data = isset( $meta_basics['data'] ) ? $meta_basics['data'] : false;

?>



<div class="section ultraaddons-panel">

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label wpt_table_ajax_action" for='wpt_table_ajax_enable'><?php esc_html_e('Ajax Action (Enable/Disable)','wpt_pro');?></label>
                </th>
                <td>
                    <select name="basics[ajax_action]" data-name='ajax_action' id="wpt_table_ajax_enable" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="ajax_active" <?php echo isset( $meta_basics['ajax_action'] ) && $meta_basics['ajax_action'] == 'ajax_active' ? 'selected' : false; ?>><?php esc_html_e('Active Ajax (Default)','wpt_pro');?></option>
                        <option value="no_ajax_action" <?php echo isset( $meta_basics['ajax_action'] ) && $meta_basics['ajax_action'] == 'no_ajax_action' ? 'selected' : false; ?>><?php esc_html_e('Disable Ajax Action','wpt_pro');?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label wpt_table_ajax_action" for='wpt_table_ajax_pagination'><?php esc_html_e('Ajax for Pagination (Enable/Disable)','wpt_pro');?></label>
                </th>
                <td>
                    <select name="basics[pagination_ajax]" data-name='pagination_ajax' id="wpt_table_ajax_pagination" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="pagination_ajax" <?php echo isset( $meta_basics['pagination_ajax'] ) && $meta_basics['pagination_ajax'] == 'pagination_ajax' ? 'selected' : false; ?>><?php esc_html_e('Ajax Pagination (Default)','wpt_pro');?></option>
                        <option value="no_pagination_ajax" <?php echo isset( $meta_basics['pagination_ajax'] ) && $meta_basics['pagination_ajax'] == 'no_pagination_ajax' ? 'selected' : false; ?>><?php esc_html_e('Disable Ajax Pagination','wpt_pro');?></option>
                    </select>                   
                </td>
            </tr>
        </table>
    </div>

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for='wpt_table_minicart_position'><?php esc_html_e( 'Mini Cart Position', 'wpt_pro' );?></label>
                </th>
                <td>
                    <select name="basics[minicart_position]" data-name='minicart_position' id="wpt_table_minicart_position" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="top" <?php echo isset( $meta_basics['minicart_position'] ) && $meta_basics['minicart_position'] == 'top' ? 'selected' : false; ?>><?php esc_html_e( 'Top (Default)', 'wpt_pro' );?></option>
                        <option value="bottom" <?php echo isset( $meta_basics['minicart_position'] ) && $meta_basics['minicart_position'] == 'bottom' ? 'selected' : false; ?>><?php esc_html_e( 'Bottom', 'wpt_pro');?></option>
                        <option value="none" <?php echo isset( $meta_basics['minicart_position'] ) && $meta_basics['minicart_position'] == 'none' ? 'selected' : false; ?>><?php esc_html_e( 'None', 'wpt_pro' );?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- **************COMES FROM COLUMN SETTING TAB, NAME HAS NOT CHANGED YET****************** -->
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label style="display: inline;width: inherit;" class="wpt_label wpt_column_hide_unhide_tab" for="wpt_table_head_enable"><?php esc_html_e( 'Table Head', 'wpt_pro' );?></label>
                </th>
                <td>
                    <label class="switch">
                        <input  name="basics[table_head]" type="checkbox" id="wpt_table_head_enable" <?php echo isset( $meta_basics['table_head'] ) ? 'checked="checked"' : ''; ?>>
                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">Hide</span><span class="off">Show</span><!--END-->
                        </div>
                    </label>
                    
                                    
                </td>
            </tr>
        </table>
    </div>
    <!-- **************COMES FROM COLUMN SETTING TAB, NAME HAS NOT CHANGED YET****************** -->
    
    
    <!-- **************COMES FROM PAGINATION TAB, NAME HAS NOT CHANGED YET****************** -->
    <?php
    $pagination =  get_post_meta( $post->ID, 'pagination', true );
    ?>
        <div class="wpt_column">
            <table class="ultraaddons-table">
                <tr>
                    <th>
                        <label class="wpt_label" for="wpt_table_pagination_enable"><?php esc_html_e( 'Pagination', 'wpt_pro' ); ?></label>
                    </th>
                    <td>
                        <select name="pagination[start]" data-name='sort' id="wpt_table_pagination_enable" class="wpt_fullwidth wpt_data_filed_atts ua_input" >

                            <option value="1" <?php echo isset( $pagination['start'] ) && $pagination['start'] == '1' ? 'selected' : ''; ?>><?php esc_html_e( 'Enable (Default)', 'wpt_pro' ); ?></option>
                            <option value="off" <?php echo isset( $pagination['start'] ) && $pagination['start'] == 'off' ? 'selected' : ''; ?>><?php esc_html_e( 'Disable', 'wpt_pro' ); ?></option>
                        </select>
                        <p><?php esc_html_e( 'To change style, go to Design tab', 'wpt_pro' ); ?></p>
                        <p class="warning"><?php echo sprintf(esc_html__( '%1$sPagination will not work%2$s on WooCommerce shop, archive page or created shop archive page by any page builder. %1$sThis feature will only work on table page where table shortcode pasted.%2$s', 'wpt_pro' ), '<b>', '</b>'); ?></p>
                        <p class="wpt-tips"><?php echo sprintf(esc_html__( '%1$sThis pagination will replaced on WooCommerce shop archive page%2$s by your theme\'s default pagination.', 'wpt_pro' ), '<b>', '</b>'); ?></p>
                    </td>
                </tr>
            </table>
        </div>

    <!-- **************COMES FROM PAGINATION TAB, NAME HAS NOT CHANGED YET****************** -->
    
    
    
    

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for='wpt_table_table_class'><?php esc_html_e( 'Set a Class name for Table', 'wpt_pro' );?></label>
                </th>
                <td>
                    <input name="basics[table_class]" value="<?php echo isset( $meta_basics['table_class'] ) ? $meta_basics['table_class'] : ''; ?>" class="wpt_data_filed_atts ua_input" data-name="table_class" type="text" placeholder="<?php esc_attr_e( 'Product Table Class Name (Optional)', 'wpt_pro' ); ?>" id='wpt_table_table_class'>
                </td>
            </tr>
        </table>
    </div>


    <!-- Convert as Hidden Number the Temporary number -->
    <input name="basics[temp_number]" data-name="temp_number" type="hidden" placeholder="123" id='wpt_table_temp_number' value="<?php echo isset( $meta_basics['temp_number'] ) ? $meta_basics['temp_number'] : random_int( 10, 600 ); ?>" readonly="readonly">

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_add_to_cart_text"><?php esc_html_e( '(Add to cart) Text', 'wpt_pro' );?></label>
                </th>
                <td>
                    <input name="basics[add_to_cart_text]" class="wpt_data_filed_atts ua_input" data-name="add_to_cart_text" type="text" value="<?php echo isset( $meta_basics['add_to_cart_text'] ) ? $meta_basics['add_to_cart_text'] : __( 'Add to cart', 'wpt_pro' ); ?>" placeholder="<?php esc_attr_e( 'Example: Buy', 'wpt_pro' ); ?>" id="wpt_table_add_to_cart_text">
                    <p><?php echo sprintf( esc_html__( 'Put a Space (" ") for getting default %s Add to Cart Text %s', 'wpt_pro' ), '<b>', '</b>' );?></p>
                </td>
            </tr>
        </table>
    </div>
    <?php do_action( 'wpo_pro_feature_message', 'pf_bulk_add_to_cart' ); ?>
    <?php do_action( 'wpto_admin_option_tab_bottom', $meta_basics, $tab, $post, $tab_array ); ?>
</div>

<?php
$meta_conditions =  get_post_meta( $post->ID, 'conditions', true );
?>
<div class="section ultraaddons-panel wpt-table-separator">
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

            

            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_table_type"><?php esc_html_e( 'Third Party Plugin Supporting ', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <select name="conditions[table_type]" data-name='table_type' id="wpt_table_table_type" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="normal_table" <?php echo isset( $meta_conditions['table_type'] ) && $meta_conditions['table_type'] == 'normal_table' ? 'selected' : ''; ?>><?php esc_html_e( 'Default', 'wpt_pro' ); ?></option>
                        <option value="advance_table" <?php echo isset( $meta_conditions['table_type'] ) && $meta_conditions['table_type'] == 'advance_table' ? 'selected' : ''; ?>><?php esc_html_e( 'Enable', 'wpt_pro' ); ?></option>
                    </select>
                </td>
            </tr>

            <tr>
                <th>
                    <label style="display: inline;width: inherit;" class="wpt_label wpt_column_hide_unhide_tab" for="wpt_wp_force"><?php esc_html_e( 'DataTable', 'wpt_pro' );?></label>
                </th>
                <td>
                    <label class="switch">
                        <?php
                        $datatable = $meta_conditions['datatable'] ?? '';
                        $datatable_chk = ! empty( $datatable ) ? 'checked="checked"' : '';
                        ?>
                        <input  name="conditions[datatable]" type="checkbox" id="wpt_datatable" <?php echo esc_attr( $datatable_chk ); ?>>
                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">Enabled</span><span class="off">Disabled</span><!--END-->
                        </div>
                    </label>
                    <p class="warning">
                        <b>Tips:</b>
                        <span>If you enable DataTable, Your table will show 300 products with DataTable's pagination and it will disable our plugin's default pagination too.</span>
                    </p>
                                    
                </td>
            </tr>
            <tr>
                <th>
                    <label style="display: inline;width: inherit;" class="wpt_label wpt_column_hide_unhide_tab" for="wpt_wp_force"><?php esc_html_e( 'WP Force', 'wpt_pro' );?></label>
                </th>
                <td>
                    <label class="switch">
                        <?php
                        $wp_force = $meta_conditions['wp_force'] ?? '';
                        $wp_force_chk = ! empty( $wp_force ) ? 'checked="checked"' : '';
                        ?>
                        <input  name="conditions[wp_force]" type="checkbox" id="wpt_wp_force" <?php echo esc_attr( $wp_force_chk ); ?>>
                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">On</span><span class="off">Off</span><!--END-->
                        </div>
                    </label>
                    <p class="warning">
                        <b>Developer Option:</b>
                        <span>
                            <i>This is only for Developer!!</i><br>
                            This option enable <code>wp()</code> in loop in product table. 
                            <a href="https://github.com/codersaiful/woo-product-table/search?q=$wp_force" target="_blank">Check</a>
                            where we have used wp() function. And what is 
                            <a href="https://developer.wordpress.org/reference/functions/wp/" target="_blank">wp() in WordPress</a>
                        </span>
                    </p>
                    
                                    
                </td>
            </tr>
        </table>
    </div>
</div>