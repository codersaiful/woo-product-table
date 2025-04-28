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
                foreach( $term_lists as $trm_key => $trm_object ){
                    if( $trm_object->labels->singular_name == 'Tag' && $trm_key !== 'product_tag' ){
                        $ourTermList[$trm_key] = $trm_key;
                    }else{
                        $ourTermList[$trm_key] = $trm_object->labels->singular_name;
                    }
                }
                $supported_terms_labels = array_merge( $supported_terms_labels, $ourTermList );
            }
            

                    $my_srl = 1;
                    foreach( $supported_terms_labels as $key => $each ){

                        $args = array(
                            'hide_empty'    => false, 
                            'orderby'       => 'count',
                            'order'         => 'DESC',
                        );
                        
                        $term_obj = get_terms( $key, $args );
                        if( ! is_array( $term_obj ) || ( is_array($term_obj) && count($term_obj) < 1 ) ){
                            continue;
                        }

                        

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
        // dd($supported_terms);
        foreach( $supported_terms as $key => $each ){
            // dd($key, $each);
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
//                            //if( 'product_cat' == $term_key ){
//                            
//                            $parents = get_term_parents_list($terms->term_id,$term_key, array(
//                                'link' => false,
//                                'separator'=> '/',
//                                'inclusive'=> false,
//                            ));
//                            $parents = rtrim( $parents, '/' );
//
//                            if( ! empty( $parents ) ){
//                                $parents_exp = explode('/',$parents);
//                                $count = count( $parents_exp );
//                                //var_dump( str_repeat( '-', $count ) );
//                                $taxo_tree_sepa = apply_filters( 'wpto_taxonomy_tree_separator', '- ', $terms );
//                                $extra_message = str_repeat( $taxo_tree_sepa, $count );
//                            }
//                                
//                            //}
                            $selected = is_array( $selected_term_ids ) && in_array( $terms->term_id,$selected_term_ids ) ? 'selected' : false;
                            $options_item .= "<option value='{$terms->term_id}' {$selected}>{$extra_message} {$terms->name} ({$terms->count})</option>";
                        }
                    }

                    if( !empty( $options_item ) ){
                        
/*****************************************                        
                        
                        
                        $defaults = array(
		'show_option_all'   => '',
		'show_option_none'  => '',
		'orderby'           => 'name',
		'order'             => 'ASC',
		'show_count'        => 0,
		'hide_empty'        => 1,
		'child_of'          => 0,
		'exclude'           => '',
		'echo'              => 1,
		'selected'          => $selecteds,
		'hierarchical'      => 1,//0, // 1 for Tree format, and 0 for plane format
		'name'              => "basics[data][terms][$term_key]",//'cat',
		'id'                => 'wpt_term_' . $term_key,//'',
		'class'             => "wpt_select2 ua_select wpt_query_terms ua_query_terms_" . $term_key,//'postform',
		'depth'             => 0,
		'tab_index'         => 0,
		'taxonomy'          => $term_key,//'category',
		'hide_if_empty'     => false,
		'option_none_value' => -1,
		'value_field'       => 'term_id',
		'multiple'          => true,
                'data-key'          => $term_key,
	);
        //Helping from https://wordpress.stackexchange.com/questions/216070/wp-dropdown-categories-with-multiple-select/253403
         wpt_wp_dropdown_categories( $defaults );
         
//***************************************/  
                    ?>
                    <select name="basics[data][terms][<?php echo esc_attr( $term_key ); ?>][]" class="wpt_select2 wpt_query_terms ua_query_terms_<?php echo esc_attr( $term_key ); ?> ua_select" id="wpt_term_<?php echo esc_attr( $term_key ); ?>" multiple="multiple">
                        <?php
                        $allowed_atts = array(
                            'selected'      => array(),
                            'value'      => array(),
                            
//                            'align'      => array(),
//                            'class'      => array(),
//                            'type'       => array(),
//                            'id'         => array(),
//                            'dir'        => array(),
//                            'lang'       => array(),
//                            'style'      => array(),
//                            'xml:lang'   => array(),
//                            'src'        => array(),
//                            'alt'        => array(),
//                            'href'       => array(),
//                            'rel'        => array(),
//                            'rev'        => array(),
//                            'target'     => array(),
//                            'novalidate' => array(),
//                            'type'       => array(),
//                            'value'      => array(),
//                            'name'       => array(),
//                            'tabindex'   => array(),
//                            'action'     => array(),
//                            'method'     => array(),
//                            'for'        => array(),
//                            'width'      => array(),
//                            'height'     => array(),
//                            'data'       => array(),
//                            'title'      => array(),
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
// do_action( 'wpo_pro_feature_message', 'under_taxonomy_includes' );
/**
 * To add something 
 */
do_action( 'wpto_admin_basic_tab',$meta_basics, $tab, $post, $tab_array ); 
?>



    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_product_cat_excludes"><?php echo esc_html__( 'Category Exclude', 'woo-product-table' );?></label><?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/hide-specific-categories-products/');?>
                </th>
                <td>
                    <select name="basics[cat_explude][]" data-name="cat_explude" id="wpt_product_cat_excludes" class="wpt_fullwidth wpt_data_filed_atts ua_select wpt_select2" multiple>
                        <?php
                        foreach ( $wpt_product_cat_object as $category ) {
                            echo "<option value='{$category->term_id}' " . ( isset( $meta_basics['cat_explude'] ) && is_array( $meta_basics['cat_explude'] ) && in_array( $category->term_id, $meta_basics['cat_explude'] ) ? 'selected' : false ) . ">{$category->name} - {$category->slug} ({$category->count})</option>";
                        }
                        ?>
                    </select>
                    <p><?php echo esc_html__( 'Click to choose. Selected Categories products will be exclude from your table.', 'woo-product-table') ?></p>
                </td>
            </tr>
        </table>
    </div>



<?php
    do_action( 'wpo_pro_feature_message', 'pf_product_includes_by_id' );
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
        //New added @since 3.2.3.1
        //'featured_products' => __( 'Sort by Featured Products', 'woo-product-table' ),
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
                    <select name="conditions[sort]" data-name='sort' id="wpt_table_shorting" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="ASC" <?php echo isset( $meta_conditions['sort'] ) && $meta_conditions['sort'] == 'ASC' ? 'selected' : ''; ?>><?php esc_html_e( 'ASCENDING (Default)', 'woo-product-table' ); ?></option>
                        <option value="DESC" <?php echo isset( $meta_conditions['sort'] ) && $meta_conditions['sort'] == 'DESC' ? 'selected' : ''; ?>><?php esc_html_e( 'DESCENDING', 'woo-product-table' ); ?></option>
                        <option value="random" <?php echo isset( $meta_conditions['sort'] ) && $meta_conditions['sort'] == 'random' ? 'selected' : ''; ?>><?php esc_html_e( 'Random', 'woo-product-table' ); ?></option>
                    </select>
                </td>
            </tr>


            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_sort_order_by"><?php esc_html_e( 'Order By', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <select name="conditions[sort_order_by]" data-name='sort_order_by' id="wpt_table_sort_order_by" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="menu_order" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'menu_order' ? 'selected' : ''; ?>><?php esc_html_e( $menu_order ); ?></option>
                        <option value="name" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'name' ? 'selected' : ''; ?>><?php esc_html_e( 'Name', 'woo-product-table' ); ?></option>
                        
                        <option value="title" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'title' ? 'selected' : ''; ?>><?php esc_html_e( 'Product Title', 'woo-product-table' ); ?></option>

                        <option value="publish-date" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'publish-date' ? 'selected' : ''; ?>><?php esc_html_e( 'Date', 'woo-product-table' ); ?></option>
                        <option value="meta_value" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'meta_value' ? 'selected' : ''; ?>><?php esc_html_e( 'Custom Meta Value', 'woo-product-table' ); ?></option>
                        
                        
                        <?php  
                        if( $access ){
                        ?>
                        <option value="meta_value_num" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'meta_value_num' ? 'selected' : ''; ?>><?php esc_html_e( 'Custom Meta Number (if numeric data)', 'woo-product-table' ); ?></option>
                        <?php
                        foreach ( $catalog_orderby_options as $id => $name ) :
                        
                        $val = $meta_conditions['sort_order_by'] ?? '';
                        $selected = $val == $id ? 'selected' : '';
                        ?>
                            <option value="<?php echo esc_attr( $id ); ?>" 
                                <?php echo esc_attr( $selected ); ?>>
                                <?php esc_html_e( $name ); ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="author" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'author' ? 'selected' : ''; ?>><?php esc_html_e( 'Author', 'woo-product-table' ); ?></option>
                        
                        <option value="type" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'type' ? 'selected' : ''; ?>><?php esc_html_e( 'Type', 'woo-product-table' ); ?></option>

                        <option value="modified" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'modified' ? 'selected' : ''; ?>><?php esc_html_e( 'Modified', 'woo-product-table' ); ?></option>
                        
                        <option value="rand" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'rand' ? 'selected' : ''; ?>><?php esc_html_e( 'Rand', 'woo-product-table' ); ?></option>
                        
                        <?php }else{ 
                                foreach ( $catalog_orderby_options as $id => $name ) : ?>
                                    <option disabled><?php echo esc_html( $name ); ?>  (<?php echo esc_html__( 'Pro', 'woo-product-table' ); ?>)</option>
                                <?php endforeach; ?>
                                <option disabled><?php echo esc_html__( 'Custom Meta Number(Pro)', 'woo-product-table' ); ?></option>
                                <option disabled><?php echo esc_html__( 'Author(Pro)', 'woo-product-table' ); ?></option>
                                <option disabled><?php echo esc_html__( 'Type(Pro)', 'woo-product-table' ); ?></option>
                                <option disabled><?php echo esc_html__( 'Modified(Pro)', 'woo-product-table' ); ?></option>
                                <option disabled><?php echo esc_html__( 'Rand(Pro)', 'woo-product-table' ); ?></option>
                        <?php } ?>
                        <option value="parent" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'parent' ? 'selected' : ''; ?>><?php esc_html_e( 'Parent', 'woo-product-table' ); ?></option>
                        <option value="comment_count" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'comment_count' ? 'selected' : ''; ?>><?php esc_html_e( 'Reviews/Comment Count', 'woo-product-table' ); ?></option>
                        <option value="relevance" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'relevance' ? 'selected' : ''; ?>><?php esc_html_e( 'Relevance', 'woo-product-table' ); ?></option> 
                        <option value="ID" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'ID' ? 'selected' : ''; ?>><?php esc_html_e( 'ID', 'woo-product-table' ); ?></option>
                        <option value="none" <?php echo isset( $meta_conditions['sort_order_by'] ) && $meta_conditions['sort_order_by'] == 'none' ? 'selected' : ''; ?>><?php esc_html_e( 'None', 'woo-product-table' ); ?></option>
                    </select>
                    <p><?php echo esc_html__( 'Chose [custom_meta or custom_meta_value] - if you want to sort by price, model, sku, color itc. For price or any number, Please chose Custom Meta value(if number)', 'woo-product-table' ); ?></p>
                </td>
            </tr>
        
            <tr id="wpt_meta_value_wrapper">
                <th>
                    <label class="wpt_label" for="wpt_product_meta_value_sort"><?php echo sprintf( esc_html__( 'Meta Value for [Custom Meta Value] of %s Custom Meta Value %s', 'woo-product-table' ),'<b>','</b>' ); ?></label>
                </th>
                <td>
                    <input name="conditions[meta_value_sort]" value="<?php echo isset( $meta_conditions['meta_value_sort'] ) ? $meta_conditions['meta_value_sort'] : ''; ?>" data-name='meta_value_sort' id="wpt_product_meta_value_sort" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="text">
                    <p style="color: #00aef0;"><?php esc_html_e( 'Type your Right meta value here. EG: "_sku,_price,_customNumber" - use any one only, there should no any space or comma', 'woo-product-table' ); ?></p>
                </td>
            </tr>
 
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_product_min_price"><?php esc_html_e( 'Minimum Price', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <input name="conditions[min_price]" data-name='min_price' value="<?php echo isset( $meta_conditions['min_price'] ) ?$meta_conditions['min_price'] : ''; ?>" id="wpt_product_min_price" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="number" step="0.001" pattern="[0-9]+([\.,][0-9]+)?">
                    <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/set-minimum-maximum-price/'); ?>
                </td>
            </tr>

            <tr>
                <th>
                    <label class="wpt_label" for="wpt_product_max_price"><?php esc_html_e( 'Maximum Price', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <input name="conditions[max_price]" data-name='max_price' value="<?php echo isset( $meta_conditions['max_price'] ) ?$meta_conditions['max_price'] : ''; ?>" id="wpt_product_max_price" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="number" step="0.001" pattern="[0-9]+([\.,][0-9]+)?">
                    <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-options/set-minimum-maximum-price/'); ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="wpt_column">
        <table class="ultraaddons-table wpt-table-separator">
            <tr class="">
                <th>
                    <label class="wpt_label" for="wpt_table_only_stock"><?php esc_html_e( 'Stock Status', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <select name="conditions[only_stock]" data-name='only_stock' id="wpt_table_only_stock" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="" <?php echo isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == '' ? 'selected' : ''; ?>><?php esc_html_e( 'Default', 'woo-product-table' ); ?></option>
                        <option value="instock" <?php echo isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == 'instock' ? 'selected' : ''; ?>><?php esc_html_e( 'instock', 'woo-product-table' ); ?></option>
                        <option value="onbackorder" <?php echo isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == 'onbackorder' ? 'selected' : ''; ?>><?php esc_html_e( 'onbackorder', 'woo-product-table' ); ?></option>
                        <option value="outofstock" <?php echo isset( $meta_conditions['only_stock'] ) && $meta_conditions['only_stock'] == 'outofstock' ? 'selected' : ''; ?>><?php esc_html_e( 'outofstock', 'woo-product-table' ); ?></option>
                    </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/show-stock-products-by-stock-status/'); ?>
                </td>
            </tr>

            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_only_sale"><?php esc_html_e( 'Sale Products', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <select name="conditions[only_sale]" data-name='only_sale' id="wpt_table_only_sale" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="no" <?php echo isset( $meta_conditions['only_sale'] ) && $meta_conditions['only_sale'] == 'no' ? 'selected' : ''; ?>><?php esc_html_e( 'Default', 'woo-product-table' ); ?></option>
                        <option value="yes" <?php echo isset( $meta_conditions['only_sale'] ) && $meta_conditions['only_sale'] == 'yes' ? 'selected' : ''; ?>><?php esc_html_e( 'Only Sale', 'woo-product-table' ); ?></option>
                    </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/show-only-sale-products/'); ?>
                </td>
            </tr>

            <tr>
                <th>
                    <label class="wpt_label" for="wpt_posts_per_page"><?php esc_html_e( 'Posts per page', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <input name="conditions[posts_per_page]" data-name='posts_per_page' value="<?php echo isset( $meta_conditions['posts_per_page'] ) ?$meta_conditions['posts_per_page'] : '20'; ?>" id="wpt_posts_per_page" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="number" pattern="[0-9]*" placeholder="<?php esc_attr_e( 'Eg: 50 (for display 50 products', 'woo-product-table' ); ?>" value="20">
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

    
    <?php do_action( 'wpto_admin_basic_tab_bottom', $meta_basics, $tab, $post, $tab_array ); ?>
</div>
