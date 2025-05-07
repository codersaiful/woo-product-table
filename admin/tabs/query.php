<?php

$meta_basics = get_post_meta( $post->ID, 'basics', true );
$data = isset( $meta_basics['data'] ) ? $meta_basics['data'] : false;

?>

<?php
    /**
     * To Get Category List of WooCommerce
     * @since 1.0.0 -10
     */
    $args = array(
        'hide_empty'    => false, 
        'orderby'       => 'count',
        'order'         => 'DESC',
    );

    //WooCommerce Product Category Object as Array
    $wpt_product_cat_object = get_terms('product_cat', $args);
?>

<!-- HIDDEN INPUT START HERE  -->
<input id="hidden_responsive_data" type="hidden" name="basics[responsive]" value="no_responsive">
<!-- hidden input #hidden_responsive_data value can be mobile_responsive and no_responsive (Manual Responsive). Default is: no_responsive -->
<!-- HIDDEN INPUT END HERE  -->

<div class="section ultraaddons-panel">
    <div class="wpt_column">
        <table class="ultraaddons-table wpt_query_terms_table">

        <tr class="wpt_query_terms_selection">
            <th colspan="2">
                <label class="wpt_label" for="wpt_query_terms_selection"><?php esc_html_e( 'Terms', 'woo-product-table' ); ?></label>
                <div class="wpt-query-terms-selection">
                    <?php
                    $supported_terms_labels = $supported_terms;
                    $extra_class = '';
            if(count($supported_terms) < 3 ){
                $extra_class = 'premium';
                $term_lists = get_object_taxonomies('product','objects');
                $ourTermList = [];
                // foreach( $term_lists as $trm_key => $trm_object ){
                //     if( $trm_object->labels->singular_name == 'Tag' && $trm_key !== 'product_tag' ){
                //         $ourTermList[$trm_key] = $trm_key;
                //     }else{
                //         $ourTermList[$trm_key] = $trm_object->labels->singular_name;
                //     }
                // }
                $ourTermList['test'] = 'Custom Attribute';
                $ourTermList['pa_color'] = 'Example Color';
                $ourTermList['pa_size'] = 'Size';
                $ourTermList['pa_brand'] = 'Brand';
                $ourTermList['pa_model'] = 'Model';
                $supported_terms_labels = array_merge( $supported_terms_labels, $ourTermList );
            }
            

                    $my_srl = 1;
                    foreach( $supported_terms_labels as $key => $each ){

                        $args = array(
                            'hide_empty'    => false, 
                            'orderby'       => 'count',
                            'order'         => 'DESC',
                        );
                        

                        $title = $each;
                        $my_extr_class = 'ok';
                        if($extra_class == 'premium' && $my_srl > 2 ){
                            $my_extr_class = 'premium';
                            $title = __( 'Premium Feature', 'woo-product-table' );
                            $status = 'hide';
                        }

                        
                    ?>
                    <span title="<?php echo esc_attr( $title ); ?>" data-status='hide' class="wpt-query-selection-handle type-pf-<?php echo esc_attr( $my_extr_class ); ?> wpt-qs-handle-<?php echo esc_attr( $key ); ?>" data-key="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $each ); ?></span>
                    
                    <?php
                        $my_srl++;
                    }
                    ?>
                </div>
            </th>
        </tr>

            <?php
        

        $args = array(
            'hide_empty'    => false, 
            'orderby'       => 'count',
            'order'         => 'DESC',
        );

        foreach( $supported_terms as $key => $each ){

            $term_key = $key;
            $term_name = $each;
            $term_obj = get_terms( $term_key, $args );
            if( ! is_array( $term_obj ) || ( is_array($term_obj) && count($term_obj) < 1 ) ){
                continue;
            }
            
            $selected_term_ids = isset( $data['terms'][$term_key] ) && !empty( $data['terms'][$term_key] ) ? $data['terms'][$term_key] : false;
            ?>
            <tr class="wpt_query_terms_each_tr <?php echo esc_attr( $term_key ); ?>" data-key="<?php echo esc_attr( $term_key ); ?>">
                
                <th><label for="wpt_term_<?php echo esc_attr( $term_key ); ?>"><?php echo esc_html( $term_name ); ?></label></th>
                <td class="">

                    <?php
                    $options_item = esc_html( 'None ', 'woo-product-table' ) . $term_name;
                    $options_item = "<option value=''>{$options_item}</option>";
                    $options_item = ""; //REmoved Default None Value
                    $selecteds = isset( $data['terms'][$term_key] ) ? $data['terms'][$term_key] : false;
                    if( is_array( $term_obj ) && count( $term_obj ) > 0 ){
                        $selected_term_ids = isset( $data['terms'][$term_key] ) ? $data['terms'][$term_key] : false;
                        //ONly for old user, where cat data was stored as product_cat_ids
                        if( empty( $selected_term_ids ) && 'product_cat' ==  $term_key){
                            $selected_term_ids = isset( $meta_basics['product_cat_ids'] ) ? $meta_basics['product_cat_ids'] : array();
                        }
                        foreach ( $term_obj as $terms ) {
                            $extra_message = '';

                            $selected = is_array( $selected_term_ids ) && in_array( $terms->term_id,$selected_term_ids ) ? 'selected' : false;
                            $options_item .= "<option value='{$terms->term_id}' {$selected}>{$extra_message} {$terms->name} ({$terms->count})</option>";
                        }
                    }

                    if( !empty( $options_item ) ){
                        

                    ?>
                    <select name="basics[data][terms][<?php echo esc_attr( $term_key ); ?>][]" class="wpt_select2 wpt_query_terms ua_query_terms_<?php echo esc_attr( $term_key ); ?> ua_select" id="wpt_term_<?php echo esc_attr( $term_key ); ?>" multiple="multiple">
                        <?php
                        $allowed_atts = array(
                            'selected'      => array(),
                            'value'      => array(),
                    );
                    
                    $allowed_tags['option']     = $allowed_atts;
                        echo wp_kses( $options_item, $allowed_tags ); ?>
                    </select>
                    
                    <?php    
                    }else{
                        echo esc_html( "No item for {$term_name}", 'woo-product-table' );
                    }
                    
                    
                    ?>

                </td>
            </tr>    
            <?php
        }
        ?>
        </table>
    </div>

<?php 
/**
 * To add something 
 */
do_action( 'wpto_admin_basic_tab',$meta_basics, $tab, $post, $tab_array ); 
?>



    <div class="wpt_column <?php echo esc_attr( wpt_get_conditional_class() ); ?>">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_product_cat_excludes"><?php echo esc_html__( 'Category Exclude', 'woo-product-table' );?></label><?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/hide-specific-categories-products/');?>
                </th>
                <td>
                    <select name="basics[cat_explude][]" data-name="cat_explude" id="wpt_product_cat_excludes" class="wpt_fullwidth wpt_data_filed_atts ua_select wpt_select2" multiple>
                    <?php
                        foreach ( $wpt_product_cat_object as $category ) {
                            $cat_explude = $meta_basics['cat_explude'] ?? [];
                            ?>
                            <option value='<?php echo esc_attr( $category->term_id ); ?>'
                            <?php echo esc_attr( is_array( $cat_explude ) && in_array( $category->term_id, $cat_explude ) ? 'selected' : '' ); ?>
                            >
                                <?php echo esc_html( $category->name ); ?> (<?php echo esc_html( $category->count ); ?>)
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <p><?php echo esc_html__( 'Click to choose. Selected Categories products will be exclude from your table.', 'woo-product-table') ?></p>
                </td>
            </tr>
        </table>
    </div>


    <?php if (!wpt_is_pro()) { ?>
    <div class="wpt-premium-feature-in-free-version">
        <table class="ultraaddons-table wpt-table-separator">
            <tbody>
                <tr id="wpt_row_product_id_includes">
                    <th>
                        <label class="wpt_label">Product Includes</label>
                    </th>
                    <td>
                        <select class="ua_select product_includes_excludes select2-hidden-accessible" id="product_id_includes" saiful="basics[post_include][]" data-name="post_include" multiple="" data-select2-id="product_id_includes" tabindex="-1" aria-hidden="true">
                        </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="104" style="width: 1px;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false"><ul class="select2-selection__rendered"><li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span><span class="select2 select2-container select2-container--default select2-container--focus select2-container--open select2-container--above" dir="ltr" data-select2-id="122" style="width: auto;"><span class="selection"></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                        <p class="notice-for-variations" style="display: none;">Please select only variable products</p>
                        <p>Choose your selected product to make a table with selected product from your while store. To select multiple products at a time, Please press [CTRL + S]</p>
                    </td>
                </tr>
                <tr id="wpt_row_product_id_cludes">
                    <th>
                        <label class="wpt_label">Product Exclude</label> <a href="https://wooproducttable.com/docs/doc/table-options/hide-specific-products/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                    </th>
                    <td>
                        <select class="ua_select product_includes_excludes select2-hidden-accessible" id="product_id_cludes" saiful="basics[post_exclude][]" data-name="post_exclude" multiple="" data-select2-id="product_id_cludes" tabindex="-1" aria-hidden="true">
                        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="123" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
                                    <ul class="select2-selection__rendered">
                                        <li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li>
                                    </ul>
                                </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php } ?>
<?php

    $wpt_product_ids_tag = false;
    /**
     * To Get Category List of WooCommerce
     * @since 1.0.0 -10
     */
    $args = array(
        'hide_empty' => true,
        'orderby' => 'count',
        'order' => 'DESC',
    );

    //WooCommerce Product Category Object as Array
    $wpt_product_tag_object = get_terms('product_tag', $args);
?>


    <div class="wpt_column">
        <table class="ultraaddons-table wpt-table-separator">
            <tr>
                <th>
                    <label class="wpt_label wpt_table_operation" for='wpt_table_operation'><?php esc_html_e('Taxonomy Query Operation','woo-product-table');?></label>
                </th>
                <td>
                    <select name="basics[query_relation]" data-name='ajax_action' id="wpt_table_operation" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="IN" <?php echo isset( $meta_basics['query_relation'] ) && $meta_basics['query_relation'] == 'IN' ? 'selected' : false; ?>><?php esc_html_e('IN/OR Operation','woo-product-table');?></option>
                        <option value="AND" <?php echo isset( $meta_basics['query_relation'] ) && $meta_basics['query_relation'] == 'AND' ? 'selected' : false; ?>><?php esc_html_e('AND Operation','woo-product-table');?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    

<?php
$meta_conditions =  get_post_meta( $post->ID, 'conditions', true );
$access = defined( 'WPT_PRO_DEV_VERSION' );
$catalog_orderby_options = apply_filters(
    'woocommerce_catalog_orderby',
    array(
        'menu_order' => __( 'Default sorting (Menu Order)', 'woo-product-table' ),
        'popularity' => __( 'Sort by popularity', 'woo-product-table' ),
        'rating'     => __( 'Sort by average rating', 'woo-product-table' ),
        'date'       => __( 'Sort by latest', 'woo-product-table' ),
        'price'      => __( 'Sort by price: low to high', 'woo-product-table' ),
        'price-desc' => __( 'Sort by price: high to low', 'woo-product-table' ),
    )
);

$menu_order = $catalog_orderby_options['menu_order'] ?? '';
unset($catalog_orderby_options['menu_order']);
?>
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_shorting"><?php esc_html_e( 'Sorting/Order', 'woo-product-table' ); ?></label>
                </th>
                <td>
                <div class="custom-select-box-wrapper sfl-auto-gen-box">

                    <?php
                    $name = 'conditions[sort]';
                    $id = 'wpt_table_shorting';
                    $current_val = $meta_conditions['sort'] ?? 'ASC';
                    $options = [
                        'ASC' => esc_html__( 'ASCENDING (Default)', 'woo-product-table' ),
                        'DESC' => esc_html__( 'DESCENDING', 'woo-product-table' ),
                        'random' => esc_html__( 'Random', 'woo-product-table' ),
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
                    <p>Order your products for table.</p>
                </div>

                </td>
            </tr>


            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_sort_order_by"><?php esc_html_e( 'Order By', 'woo-product-table' ); ?></label>
                </th>
                <td>

                <div class="custom-select-box-wrapper">

                    <?php
                    $name = 'conditions[sort_order_by]';
                    $id = 'wpt_table_sort_order_by';
                    $current_val = $meta_conditions['sort_order_by'] ?? 'title';

                    $options = [
                        'title' => esc_html__( 'Product Title', 'woo-product-table' ),
                        'name' => esc_html__( 'Name', 'woo-product-table' ),
                        'rand' => esc_html__( 'Random', 'woo-product-table' ),
                        'ID' => esc_html__( 'ID', 'woo-product-table' ),
                        
                        
                        'menu_order' => esc_html__( 'Menu Order', 'woo-product-table' ),
                        'popularity' => esc_html__( 'Sort by popularity', 'woo-product-table' ),
                        'rating'     => esc_html__( 'Sort by average rating', 'woo-product-table' ),
                        'date'       => esc_html__( 'Sort by latest', 'woo-product-table' ),
                        'price'      => esc_html__( 'Sort by price: low to high', 'woo-product-table' ),
                        'price-desc' => esc_html__( 'Sort by price: high to low', 'woo-product-table' ),
                        'featured_products' => esc_html__( 'Sort by Featured Products', 'woo-product-table' ),
                        

                        'publish-date' => esc_html__( 'Date', 'woo-product-table' ),
                        'meta_value' => esc_html__( 'Custom Meta Value', 'woo-product-table' ),
                        'meta_value_num' => esc_html__( 'Custom Meta Number', 'woo-product-table' ),

                        'author' => esc_html__( 'Author', 'woo-product-table' ),
                        'type' => esc_html__( 'Type', 'woo-product-table' ),
                        'modified' => esc_html__( 'Modified', 'woo-product-table' ),

                        'parent' => esc_html__( 'Parent', 'woo-product-table' ),
                        'comment_count' => esc_html__( 'Reviews Count', 'woo-product-table' ),
                        'relevance' => esc_html__( 'Relevance', 'woo-product-table' ),
                        
                        


                        
                        'none' => esc_html__( 'None', 'woo-product-table' ),
                        
                    ];
                    //If some premium feature, 
                    // $free_option_keys = ['menu_order', 'name', 'title', 'ID', 'rand', 'publish-date', 'meta_value', 'meta_value_num', 'author', 'type', 'modified', 'parent', 'comment_count', 'relevance'];
                    $only_free_keys = ['rand', 'name', 'title', 'ID', 'publish-date'];
                    if( wpt_is_pro() ){
                        $only_free_keys = [];
                    }
                    ?>

                    <input type="hidden" name="<?php echo esc_attr( $name ); ?>"
                     value="<?php echo esc_attr( $current_val ); ?>"
                     class="custom-select-box-input" id="<?php echo esc_attr( $id ); ?>">
                    <div class="wpt-custom-select-boxes">

                        <?php foreach ($options as $value => $label): ?>
                            <?php
                            $disabled_class = ! empty($only_free_keys ) && ! in_array( $value, $only_free_keys ) ? 'disabled' : '';    
                            $active_class = $current_val === $value ? 'active' : '';
                            $ext_class = $disabled_class . ' ' . $active_class;
                            ?>
                            <div class="wpt-custom-select-box <?php echo esc_attr( $ext_class ); ?>" data-value="<?php echo esc_attr($value); ?>">
                                <?php echo esc_html( $label ); ?>
                            </div>
                        <?php endforeach; $current_val = null; $options = []; ?>
                    </div>
                    <p><?php echo esc_html__( 'Chose [custom_meta or custom_meta_value] - if you want to sort by price, model, sku, color itc. For price or any number, Please chose Custom Meta value(if number)', 'woo-product-table' ); ?></p>
                </div>


                    
                </td>
            </tr>
        
            <tr id="wpt_meta_value_wrapper">
                <th>
                    <label class="wpt_label" for="wpt_product_meta_value_sort"><?php echo sprintf( esc_html__( 'Meta Value for [Custom Meta Value] of %s Custom Meta Value %s', 'woo-product-table' ),'<b>','</b>' ); ?></label>
                </th>
                <td>
                    <input name="conditions[meta_value_sort]" value="<?php echo esc_attr( $meta_conditions['meta_value_sort'] ?? '' ); ?>" data-name='meta_value_sort' id="wpt_product_meta_value_sort" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="text">
                    <p style="color: #00aef0;"><?php esc_html_e( 'Type your Right meta value here. EG: "_sku,_price,_customNumber" - use any one only, there should no any space or comma', 'woo-product-table' ); ?></p>
                </td>
            </tr>
 
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_product_min_price"><?php esc_html_e( 'Minimum Price', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <input name="conditions[min_price]" data-name='min_price' value="<?php echo esc_attr($meta_conditions['min_price'] ?? ''); ?>" id="wpt_product_min_price" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="number" step="0.001" pattern="[0-9]+([\.,][0-9]+)?">
                    <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/set-minimum-maximum-price/'); ?>
                </td>
            </tr>

            <tr>
                <th>
                    <label class="wpt_label" for="wpt_product_max_price"><?php esc_html_e( 'Maximum Price', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <input name="conditions[max_price]" data-name='max_price' value="<?php echo esc_attr($meta_conditions['max_price'] ?? ''); ?>" id="wpt_product_max_price" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="number" step="0.001" pattern="[0-9]+([\.,][0-9]+)?">
                    <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/set-minimum-maximum-price/'); ?>
                </td>
            </tr>
        </table>
    </div>
    <?php
    $cond_class = $readonly = '';
    if(! wpt_is_pro()){
        $cond_class = 'wpt-premium-feature-in-free-version';
    }
    ?>
    <div class="wpt_column">
        <table class="ultraaddons-table wpt-table-separator">
            
            <tr class="<?php echo esc_attr( $cond_class ); ?>">
                <th>
                    <label class="wpt_label" for="wpt_table_only_stock"><?php esc_html_e( 'Stock Status', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <select name="conditions[only_stock]" data-name='only_stock' id="wpt_table_only_stock" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="" <?php echo esc_attr( isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == '' ? 'selected' : '' ); ?>><?php esc_html_e( 'Default', 'woo-product-table' ); ?></option>
                        <option value="instock" <?php echo esc_attr(isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == 'instock' ? 'selected' : ''); ?>><?php esc_html_e( 'instock', 'woo-product-table' ); ?></option>
                        <option value="onbackorder" <?php echo esc_attr(  isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == 'onbackorder' ? 'selected' : ''); ?>><?php esc_html_e( 'onbackorder', 'woo-product-table' ); ?></option>
                        <option value="outofstock" <?php echo esc_attr( isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == 'outofstock' ? 'selected' : ''); ?>><?php esc_html_e( 'outofstock', 'woo-product-table' ); ?></option>
                    </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/show-stock-products-by-stock-status/'); ?>
                </td>
            </tr>

            <tr class="<?php echo esc_attr( $cond_class ); ?>">
                <th>
                    <label class="wpt_label" for="wpt_table_only_sale"><?php esc_html_e( 'Sale Products', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <select name="conditions[only_sale]" data-name='only_sale' id="wpt_table_only_sale" class="wpt_fullwidth wpt_data_filed_atts ua_input"  >
                        <option value="no" <?php echo esc_attr( isset( $meta_conditions['only_sale'] ) && $meta_conditions['only_sale'] == 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'Default', 'woo-product-table' ); ?></option>
                        <option value="yes" <?php echo esc_attr( isset( $meta_conditions['only_sale'] ) && $meta_conditions['only_sale'] == 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Only Sale', 'woo-product-table' ); ?></option>
                    </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/show-only-sale-products/'); ?>
                </td>
            </tr>

            <tr>
                <th>
                    <label class="wpt_label" for="wpt_posts_per_page"><?php esc_html_e( 'Posts per page', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <input name="conditions[posts_per_page]" data-name='posts_per_page' value="<?php echo esc_attr( $meta_conditions['posts_per_page'] ?? 20 ); ?>" id="wpt_posts_per_page" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="number" pattern="[0-9]*" placeholder="<?php esc_attr_e( 'Eg: 50 (for display 50 products', 'woo-product-table' ); ?>" value="20">
                    <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/display-limited-quantity-of-products/'); ?>
                    <p>Posts limit on each load.</p>
                    <p class="warning">
                        <b>Tips:</b>
                        <span>Maximum should <code>200</code> and recommended maximum limit: 100.</span>
                    </p>
                </td>
            </tr>

        </table>
    </div>



    <?php if(!wpt_is_pro()){?>
<div class="wpt-premium-feature-in-free-version">

<div class="wpt_column">
            <table class="ultraaddons-table">
                <tbody><tr>
                    <th>
                        <label class="wpt_label" for="wpt_table_author">AuthorID/UserID/VendorID (Optional)</label>
                    </th>
                    <td>
                        <input saiful="basics[author]" class="wpt_data_filed_atts ua_input" data-name="author" type="number" value="" placeholder="Author ID/Vendor ID" id="wpt_table_author">
                        <p style="color: #006394;">Only AuthorID or AuthorName field for both [AuthorID/UserID/VendorID] or [author_name/username/VendorUserName]. Don't use both.</p>
                    </td>
                </tr>
            </tbody></table>
        </div>

        <div class="wpt_column">
            <table class="ultraaddons-table wpt-table-separator-light">
                <tbody><tr>
                    <th>
                        <label class="wpt_label wpt_table_ajax_action" for="wpt_table_product_type">Product Type</label>
                    </th>
                    <td>
                        <select saiful="basics[product_type]" data-name="product_type" id="wpt_table_product_type" class="wpt_fullwidth wpt_data_filed_atts ua_input">
                                                                    <option value="">Product</option>
                                                                            <option value="product_variation">Only Variation Product</option>
                                                     
                        </select>            <a href="https://wooproducttable.com/docs/doc/table-options/show-product-variations-as-table/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                    <a href="https://demo.wooproducttable.com/product-variant-in-separate-row/" target="_blank" class="wpt-doc-lick">See demo</a>
                                <p>
                            If select Variation product, you have to confirm, your all Variation is configured properly. Such: there will not support "any attribute" option for variation. eg: no support "Any Size" type variation.                            <br>And if enable Variation product, Some column and feature will be disable. such: Advernce Search box.                        </p>
                    </td>
                </tr>
            </tbody></table>
        </div>

</div>
    
<?php } 
do_action( 'wpto_admin_basic_tab_bottom', $meta_basics, $tab, $post, $tab_array ); ?>
</div>
