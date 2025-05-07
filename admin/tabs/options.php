<?php

$meta_basics = get_post_meta( $post->ID, 'basics', true );
$data = isset( $meta_basics['data'] ) ? $meta_basics['data'] : false;

?>
<?php
    $cond_class = $readonly = '';
    if(! wpt_is_pro()){
        $cond_class = 'wpt-premium-feature-in-free-version';
    }
 
?>
<div class="section ultraaddons-panel">

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label wpt_table_ajax_action" for='wpt_table_ajax_enable'><?php esc_html_e('Ajax Action','woo-product-table');?></label>
                </th>
                <td>

                <div class="custom-select-box-wrapper sfl-auto-gen-box">

                    <?php
                    $name = 'basics[ajax_action]';
                    $id = 'wpt_table_ajax_enable';
                    $current_val = $meta_basics['ajax_action'] ?? 'ajax_active';
                    $options = [
                        'ajax_active' => esc_html__( 'Active', 'woo-product-table' ),
                        'no_ajax_action' => esc_html__( 'Disable', 'woo-product-table' ),
                    ];
                    ?>

                    <input type="hidden" name="<?php echo esc_attr( $name ); ?>"
                     value="<?php echo esc_attr( $current_val ); ?>"
                     class="custom-select-box-input" id="<?php echo esc_attr( $id ); ?>">
                    <div class="wpt-custom-select-boxes">

                        <?php foreach ($options as $value => $label): ?>
                            <div class="wpt-custom-select-box <?php echo esc_attr( $current_val === $value ? 'active' : '' ); ?>" data-value="<?php echo esc_attr($value); ?>">
                                <?php echo esc_html( $label ); ?>
                            </div>
                        <?php endforeach; $current_val = null; $options = []; ?>
                    </div>
                    <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/enable-disable-ajax-action/');?>
                </div>

                </td>
            </tr>
        </table>
    </div>
    
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label wpt_table_ajax_action" for='wpt_table_ajax_pagination'><?php esc_html_e('Pagination','woo-product-table');?></label>
                </th>
                <td>
                    
                <div class="custom-select-box-wrapper sfl-auto-gen-box">
                    <input type="hidden" name="basics[pagination]"
                     value="<?php echo esc_attr( $meta_basics['pagination'] ?? 'on' ); ?>"
                     class="custom-select-box-input" id="wpt_table_ajax_pagination">
                    <div class="wpt-custom-select-boxes">
                        <div class="wpt-custom-select-box <?php echo isset( $meta_basics['pagination'] ) && $meta_basics['pagination'] == 'on' ? 'active' : ''; ?>"
                        data-value="on">
                            <?php esc_html_e('Number/Paging','woo-product-table');?>
                        </div>
                        <div class="wpt-custom-select-box <?php echo isset( $meta_basics['pagination'] ) && $meta_basics['pagination'] == 'off' ? 'active' : ''; ?>" 
                        data-value="off">
                            <?php esc_html_e('Disable','woo-product-table');?>
                        </div>
                        <?php
                        $disabled = ! defined('WPT_PRO_DEV_VERSION') ? 'disabled' : '';
                        ?>
                        <div class="wpt-custom-select-box <?php echo esc_attr( $disabled ); ?> <?php echo isset( $meta_basics['pagination'] ) && $meta_basics['pagination'] == 'load_more' ? 'active' : ''; ?>"
                        data-value="load_more">
                            <?php esc_html_e('Load More','woo-product-table');?>
                        </div>
                        <div class="wpt-custom-select-box <?php echo esc_attr( $disabled ); ?> <?php echo isset( $meta_basics['pagination'] ) && $meta_basics['pagination'] == 'infinite_scroll' ? 'active' : ''; ?>" 
                        data-value="infinite_scroll">
                            <?php esc_html_e('Infinite Scroll','woo-product-table');?>
                        </div>

                    </div>
                    <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/pagination-on-of/'); ?>   
                    
                </div>


                    
                    <p><?php esc_html_e( 'To change style, go to Design tab', 'woo-product-table' ); ?></p>
                    <p class="warning"><?php echo sprintf(esc_html__( '%1$sPagination will not work%2$s on WooCommerce shop, archive page or created shop archive page by any page builder. %1$sThis feature will only work on table page where table shortcode pasted.%2$s', 'woo-product-table' ), '<b>', '</b>'); ?></p>
                    <p class="wpt-tips"><?php echo sprintf(esc_html__( '%1$sThis pagination will replaced on WooCommerce shop archive page%2$s by your theme\'s default pagination.', 'woo-product-table' ), '<b>', '</b>'); ?></p>
                </td>
            </tr>
            <tr>
                <th>
                    <label class="wpt_label wpt_table_ajax_action" for='wpt_table_ajax_pagination'><?php esc_html_e('Ajax for Pagination','woo-product-table');?></label>
                </th>
                <td>

                <div class="custom-select-box-wrapper sfl-auto-gen-box">

                    <?php
                    $name = 'basics[pagination_ajax]';
                    $id = 'wpt_table_ajax_pagination';
                    $current_val = $meta_basics['pagination_ajax'] ?? 'pagination_ajax';
                    $options = [
                        'pagination_ajax' => esc_html__( 'Enable', 'woo-product-table' ),
                        'no_pagination_ajax' => esc_html__( 'Disable', 'woo-product-table' ),
                    ];
                    ?>

                    <input type="hidden" name="<?php echo esc_attr( $name ); ?>"
                    value="<?php echo esc_attr( $current_val ); ?>"
                    class="custom-select-box-input" id="<?php echo esc_attr( $id ); ?>">
                    <div class="wpt-custom-select-boxes">

                        <?php foreach ($options as $value => $label): ?>
                            <div class="wpt-custom-select-box <?php echo esc_attr( $current_val === $value ? 'active' : '' ); ?>" data-value="<?php echo esc_attr($value); ?>">
                                <?php echo esc_html( $label ); ?>
                            </div>
                        <?php endforeach; $current_val = null; $options = []; ?>
                    </div>
                    <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/pagination-on-of/'); ?>
                    </div>                    
                </td>
            </tr>
        </table>
    </div>

    <div class="wpt_column <?php echo esc_attr( $cond_class ); ?>">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for='wpt_table_minicart_position'><?php esc_html_e( 'Mini Cart Position', 'woo-product-table' );?></label>
                </th>
                <td>
                    <select name="basics[minicart_position]" data-name='minicart_position' id="wpt_table_minicart_position" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="top" <?php echo isset( $meta_basics['minicart_position'] ) && $meta_basics['minicart_position'] == 'top' ? 'selected' : false; ?>><?php esc_html_e( 'Top (Default)', 'woo-product-table' );?></option>
                        <option value="bottom" <?php echo isset( $meta_basics['minicart_position'] ) && $meta_basics['minicart_position'] == 'bottom' ? 'selected' : false; ?>><?php esc_html_e( 'Bottom', 'woo-product-table');?></option>
                        <option value="none" <?php echo isset( $meta_basics['minicart_position'] ) && $meta_basics['minicart_position'] == 'none' ? 'selected' : false; ?>><?php esc_html_e( 'None', 'woo-product-table' );?></option>
                        <option value="both" <?php echo isset( $meta_basics['minicart_position'] ) && $meta_basics['minicart_position'] == 'both' ? 'selected' : false; ?>><?php esc_html_e( 'Both', 'woo-product-table' );?></option>
                    </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/mini-cart-options/'); ?> 
                </td>
            </tr>
        </table>
    </div>
    
    <!-- **************COMES FROM COLUMN SETTING TAB, NAME HAS NOT CHANGED YET****************** -->
    <div class="wpt_column  <?php echo esc_attr( $cond_class ); ?>">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label style="display: inline;width: inherit;" class="wpt_label wpt_column_hide_unhide_tab" for="wpt_table_head_enable"><?php esc_html_e( 'Table Head', 'woo-product-table' );?></label>
                </th>
                <td>
                    <label class="switch switch-reverse">
                        <input  name="basics[table_head]" type="checkbox" id="wpt_table_head_enable" <?php echo isset( $meta_basics['table_head'] ) ? 'checked="checked"' : ''; ?>>
                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">Hide</span><span class="off">Show</span><!--END-->
                        </div>
                    </label><?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/hide-show-table-heading/');?>
                    
                                    
                </td>
            </tr>
        </table>
    </div>
    <!-- **************COMES FROM COLUMN SETTING TAB, NAME HAS NOT CHANGED YET****************** -->
    
    
    <!-- **************COMES FROM PAGINATION TAB, NAME HAS NOT CHANGED YET****************** -->
    <?php
    $pagination =  get_post_meta( $post->ID, 'pagination', true );
    ?>

    
    

    <div class="wpt_column wpt-table-separator">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for='wpt_table_table_class'><?php esc_html_e( 'Set a Class name for Table', 'woo-product-table' );?></label>
                </th>
                <td>
                    <input name="basics[table_class]" value="<?php echo esc_attr( $meta_basics['table_class'] ?? '' ); ?>" class="wpt_data_filed_atts ua_input" data-name="table_class" type="text" placeholder="<?php esc_attr_e( 'Product Table Class Name (Optional)', 'woo-product-table' ); ?>" id='wpt_table_table_class'>
                </td>
            </tr>
        </table>
    </div>


    <!-- Convert as Hidden Number the Temporary number -->
    <input name="basics[temp_number]" data-name="temp_number" type="hidden" placeholder="123" id='wpt_table_temp_number' value="<?php echo esc_attr( $meta_basics['temp_number'] ?? $post->ID ); ?>" readonly="readonly">

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_add_to_cart_text"><?php esc_html_e( '(Add to cart) Text', 'woo-product-table' );?></label>
                    <?php wpt_help_icon_render(); ?>
                </th>
                <td>
                    <?php
                    $add_to_cart_text = $meta_basics['add_to_cart_text'] ?? '';
                    $add_to_cart_text_placeholder = __( 'Add to cart', 'woo-product-table' );
                    ?>
                    <input name="basics[add_to_cart_text]" 
                    class="wpt_data_filed_atts ua_input" 
                    data-name="add_to_cart_text" 
                    type="text" 
                    value="<?php echo esc_attr( $add_to_cart_text ); ?>" 
                    placeholder="<?php echo esc_attr( $add_to_cart_text_placeholder ); ?>" 
                    id="wpt_table_add_to_cart_text">
                    <p><?php echo sprintf( esc_html__( 'Put a Space (" ") for getting default %s Add to Cart Text %s', 'woo-product-table' ), '<b>', '</b>' );?></p>
                </td>
            </tr>
        </table>
    </div>

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_stats_post_count"><?php esc_html_e( 'Stats Post Count Text', 'woo-product-table' );?></label>
                    <?php wpt_help_icon_render(); ?>
                </th>
                <td>
                    <?php
                    
                    $stats_post_count_text = $meta_basics['stats_post_count'] ?? '';
                    if(property_exists($post, 'post_status') && $post->post_status == 'auto-draft'){
                        $stats_post_count_text = __( 'Showing %s out of %s', 'woo-product-table' );
                        $stats_post_count_text = __( 'Showing %s out of %s' );
                    }
                    $stats_post_count_placeholder = __( 'Example: Showing %s out of %s', 'woo-product-table' );
                    ?>
                    <input name="basics[stats_post_count]" 
                    class="wpt_stats_post_count ua_input" 
                    data-name="stats_post_count" 
                    type="text" 
                    value="<?php echo esc_attr( $stats_post_count_text ); ?>" 
                    placeholder="<?php echo esc_attr( $stats_post_count_placeholder ); ?>" 
                    id="wpt_table_stats_post_count">
                    <p><?php echo esc_html__( 'First %s will replace by showing number and second % will replace by total product number. To hide, leave as empty', 'woo-product-table' );?></p>
                </td>
            </tr>
        </table>
    </div>

    <div class="wpt_column ">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_stats_page_count"><?php esc_html_e( 'Stats Page Count Text', 'woo-product-table' );?></label>
                    <?php wpt_help_icon_render( __( 'Leave as empty to hide Stats.' ) ); ?>
                </th>
                <td>
                    <?php
                    // var_dump($meta_basics);
                    $stats_page_count_text = $meta_basics['stats_page_count'] ?? '';// __( 'Page %s out of %s', 'woo-product-table' );
                    if(property_exists($post, 'post_status') && $post->post_status == 'auto-draft'){
                        $stats_page_count_text = __( 'Page %s out of %s', 'woo-product-table' );
                        $stats_page_count_text = __( 'Page %s out of %s' );
                    }
                    $stats_page_count_placeholder = __( 'Example: Page %s out of %s', 'woo-product-table' );
                    ?>
                    <input name="basics[stats_page_count]" 
                    class="wpt_stats_page_count ua_input" 
                    data-name="stats_page_count" 
                    type="text" 
                    value="<?php echo esc_attr( $stats_page_count_text ); ?>" 
                    placeholder="<?php echo esc_attr( $stats_page_count_placeholder ); ?>" 
                    id="wpt_table_stats_page_count">
                    <p><?php echo esc_html__( 'First %s will replace by current page number and second % will replace by total page count.  To hide, leave as empty', 'woo-product-table' );?></p>
                </td>
            </tr>
        </table>
    </div>

    <table class="ultraaddons-table wpt-table-separator <?php echo esc_attr( $cond_class ); ?>">
                <tr>
                    <th>
                        <label class="wpt_label" for="wpt_table_add_to_cart_selected_text"><?php esc_html_e( '(Add to cart[Selected]) Text', 'woo-product-table' );?></label>
                        <?php wpt_help_icon_render(); ?>
                    </th>
                    <td>
                        <?php
                        $add_to_cart_selected_text = $meta_basics['add_to_cart_selected_text'] ?? '';
                        $add_to_cart_selected_placeholder = __( 'Add to Cart (Selected)', 'woo-product-table' );
                        ?>
                        <input name="basics[add_to_cart_selected_text]"  
                        class="wpt_data_filed_atts ua_input" 
                        data-name="add_to_cart_selected_text" 
                        type="text" 
                        value="<?php echo esc_attr( $add_to_cart_selected_text );  ?>" 
                        placeholder="<?php echo esc_attr( $add_to_cart_selected_placeholder ); ?>" 
                        id="wpt_table_add_to_cart_selected_text">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label class="wpt_label" for="wpt_table_check_uncheck_text"><?php esc_html_e( '(Select All) Text', 'woo-product-table' );?></label>
                        <?php wpt_help_icon_render(); ?>
                    </th>
                    <td>
                        <?php
                        $check_uncheck_text = $meta_basics['check_uncheck_text'] ?? '';
                        $check_uncheck_placeholder = __( 'Select All','woo-product-table' );
                        ?>
                        <input name="basics[check_uncheck_text]"  
                        class="wpt_data_filed_atts ua_input" 
                        data-name="check_uncheck_text" type="text" 
                        value="<?php echo esc_attr( $check_uncheck_text ); ?>" 
                        placeholder="<?php echo esc_attr( $check_uncheck_placeholder );?>" 
                        id="wpt_table_check_uncheck_text">
                    </td>
                </tr>
    </table>
    <?php if( ! wpt_is_pro() ){ ?>
        <div title="Premium Feature" class="wpt_column wpt-premium-feature-in-free-version">
            <table class="ultraaddons-table wpt-table-separator">
                <tbody><tr>
                    <th>
                        <label class="wpt_label wpt_table_ajax_action" for="wpt_table_checkbox">Checkbox Auto Check on Table Load (Enable/Disable)</label>
                    </th>
                    <td>
                        <select name="basics[checkbox]" data-name="checkbox" id="wpt_table_checkbox" class="wpt_fullwidth wpt_data_filed_atts ua_input">
                            <option value="wpt_no_checked_table" selected="">Default</option>
                            <option value="wpt_checked_table">Automatically All Check</option>
                        </select>            <a href="https://wooproducttable.com/docs/doc/table-options/check-column-options/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                          
                    </td>
                </tr>
            </tbody></table>
        </div>    
    <?php } ?>
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
                    <label class="wpt_label" for="wpt_table_description_type"><?php esc_html_e( 'Description Type', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <select name="conditions[description_type]" data-name='description_type' id="wpt_table_description_type" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="short_description" <?php echo isset( $meta_conditions['description_type'] ) && $meta_conditions['description_type'] == 'short_description' ? 'selected' : ''; ?>><?php esc_html_e( 'Short Description', 'woo-product-table' ); ?></option><!-- Default Value -->
                        <option value="description" <?php echo isset( $meta_conditions['description_type'] ) && $meta_conditions['description_type'] == 'description' ? 'selected' : ''; ?>><?php esc_html_e( 'Long Description', 'woo-product-table' ); ?></option>
                    </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/set-description-type/');?>
                    <p style="color: #0087be;"><?php echo sprintf( esc_html__( 'Here was %sdescription_lenght%s, But from 3.6, We have removed %sdescription_lenght%s', 'woo-product-table' ),'<b>','</b>','<b>','</b>' ); ?>.</p>
                </td>
            </tr>

            
            <!-- 
                actually ei option ta mai action column a niye gechi.
                location: admin/handle/feature-loader.php
                location: admin/handle/action-feature.php
            -->

            <!-- <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_table_type"><?php esc_html_e( 'Third Party Plugin Supporting ', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <select name="conditions[table_type]" data-name='table_type' id="wpt_table_table_type" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        
                    <option value="normal_table" <?php echo isset( $meta_conditions['table_type'] ) && $meta_conditions['table_type'] == 'normal_table' ? 'selected' : ''; ?>><?php esc_html_e( 'Default', 'woo-product-table' ); ?></option>
                    <option value="advance_table" <?php echo isset( $meta_conditions['table_type'] ) && $meta_conditions['table_type'] == 'advance_table' ? 'selected' : ''; ?>><?php esc_html_e( 'Enable', 'woo-product-table' ); ?></option>
                        
                        
                    </select>
                </td>
            </tr> -->

            <tr>
                <th>
                    <label style="display: inline;width: inherit;" class="wpt_label wpt_column_hide_unhide_tab" for="wpt_wp_force"><?php esc_html_e( 'DataTable', 'woo-product-table' );?></label>
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
                    <label style="display: inline;width: inherit;" class="wpt_label wpt_column_hide_unhide_tab" for="wpt_wp_force"><?php esc_html_e( 'WP Force', 'woo-product-table' );?></label>
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