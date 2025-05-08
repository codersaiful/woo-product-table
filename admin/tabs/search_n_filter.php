<?php
global $post;
$meta_search_n_filter =  get_post_meta( $post->ID, 'search_n_filter', true );

$post_status = $post->post_status;
$default_tax = array();
if($post_status == 'auto-draft'){
    $default_tax = array('product_cat','product_tag');
}

$terms = get_terms();
$allTerms = array();
foreach($terms as $term){
    $tax = $term->taxonomy;
    if( $tax == 'category' || $tax == 'nav_menu' || $tax == 'post_format' || $tax == 'product_type' || $tax == 'wp_theme' ) continue;
    if( $tax == 'translation_priority' || $tax == 'elementor_font_type' || $tax == 'elementor_library_type' || $tax == 'product_type' || $tax == 'wp_theme' ) continue;
    $allTerms[$term->taxonomy]=$term->taxonomy;
}

?>
<div class="section ultraaddons-panel">
    
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_search_box"><?php esc_html_e( 'Advance Search Box', 'woo-product-table' ); ?></label>
                </th>
                <td>
                <div class="custom-select-box-wrapper sfl-auto-gen-box">
                    <?php
                    $name = 'search_n_filter[search_box]';
                    $id = 'wpt_search_box';
                    $current_val = $meta_search_n_filter['search_box'] ?? 'no';
                    $options = [
                        'yes' => esc_html__( 'Show', 'woo-product-table' ),
                        'no' => esc_html__( 'Hide', 'woo-product-table' ),
                    ];
                    ?>

                    <input type="hidden" name="<?php echo esc_attr( $name ); ?>"
                    data-on="yes|.wpt_snf_on_off"
                     value="<?php echo esc_attr( $current_val ); ?>"
                     class="custom-select-box-input wpt_toggle" id="<?php echo esc_attr( $id ); ?>">
                    <div class="wpt-custom-select-boxes">

                        <?php foreach ($options as $value => $label): ?>
                            <div class="wpt-custom-select-box <?php echo esc_attr( $current_val === $value ? 'active' : '' ); ?>" data-value="<?php echo esc_attr($value); ?>">
                                <?php echo esc_html( $label ); ?>
                            </div>
                        <?php endforeach; $current_val = null; $options = []; ?>
                    </div>
                    <p class="warning">
                        <b><?php echo esc_html__( 'Tips:', 'woo-product-table' ); ?></b>
                        <span><?php echo esc_html__( 'Not for WooCommerce Archive page. Such: shop page, product category page.','woo-product-table' ); ?></span>
                    </p>
                </div>
<!--                     
                    <select name="search_n_filter[search_box]" data-name='search_box' id="wpt_search_box" class="wpt_fullwidth wpt_data_filed_atts ua_input wpt_toggle" data-on="yes|.wpt_snf_on_off" >
                        <option value="yes" <?php echo isset( $meta_search_n_filter['search_box'] ) && $meta_search_n_filter['search_box'] == 'yes' ? 'selected' : ''; ?>><?php esc_html_e( 'Show Search Box', 'woo-product-table' ); ?></option>
                        <option value="no" <?php echo isset( $meta_search_n_filter['search_box'] ) && $meta_search_n_filter['search_box'] == 'no' ? 'selected' : ''; ?>><?php esc_html_e( 'Hide Search Box', 'woo-product-table' ); ?></option>
                    </select><?php wpt_doc_link('https://wooproducttable.com/docs/doc/search-and-filter/create-an-advanced-search-box-table/') ?>
                    <p class="warning">
                        <b><?php echo esc_html__( 'Tips:', 'woo-product-table' ); ?></b>
                        <span><?php echo esc_html__( 'Not for WooCommerce Archive page. Such: shop page, product category page.','woo-product-table' ); ?></span>
                    </p> -->
                </td>
            </tr>
        </table>
    </div>
    <?php if (!wpt_is_pro()) { ?>
<div title="Premium Feature" class="wpt-premium-feature-in-free-version">
    <table class="ultraaddons-table wpt_snf_on_off wpt-table-separator-light">
        <tbody>
            <tr>
                <th>
                    <label class="wpt_label">Search From</label>
                </th>
                <td>
                    <label class="wpt_label">Search From COMPARE</label>
                    <label class="switch">
                        <input saiful="search_n_filter[search_form_compare]" id="wpt-search-form-order" type="checkbox" value="on">

                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">==</span><span class="off">LIKE</span><!--END-->
                        </div>
                    </label> <a href="https://wooproducttable.com/docs/doc/search-and-filter/create-an-advanced-search-box-table/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                    <p>Compare: only for custom field chosen option, such: _sku, _price etc.</p>
                    <hr>

                    <ul class="wpt-tag-list">

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt_ID_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][ID]" id="search_from_ID" value="posts">
                            <label for="search_from_ID">ID</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt_post_title_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][post_title]" id="search_from_post_title" value="posts">
                            <label for="search_from_post_title">post_title</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt_post_content_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][post_content]" id="search_from_post_content" value="posts">
                            <label for="search_from_post_content">post_content</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt_menu_order_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][menu_order]" id="search_from_menu_order" value="posts">
                            <label for="search_from_menu_order">menu_order</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt_post_author_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][post_author]" id="search_from_post_author" value="posts">
                            <label for="search_from_post_author">post_author</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt_post_excerpt_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][post_excerpt]" id="search_from_post_excerpt" value="posts">
                            <label for="search_from_post_excerpt">post_excerpt</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt_post_parent_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][post_parent]" id="search_from_post_parent" value="posts">
                            <label for="search_from_post_parent">post_parent</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt_post_name_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][post_name]" id="search_from_post_name" value="posts">
                            <label for="search_from_post_name">post_name</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt_post_date_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][post_date]" id="search_from_post_date" value="posts">
                            <label for="search_from_post_date">post_date</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt__sku_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][_sku]" id="search_from__sku" value="postmeta">
                            <label for="search_from__sku">_sku</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt__price_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][_price]" id="search_from__price" value="postmeta">
                            <label for="search_from__price">_price</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt__regular_price_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][_regular_price]" id="search_from__regular_price" value="postmeta">
                            <label for="search_from__regular_price">_regular_price</label>
                        </li>

                        <li class="wpt_checkbox wpt_search_form_checkbox wpt__sale_price_checkbox">
                            <input type="checkbox" saiful="search_n_filter[search_from][_sale_price]" id="search_from__sale_price" value="postmeta">
                            <label for="search_from__sale_price">_sale_price</label>
                        </li>

                    </ul>

                    <p>
                        <label class="wpt_label" for="search_from_cf">Additional Custom Meta Field with Comma</label><br>
                        <input saiful="search_n_filter[search_from_add_cf]" class="search_from_cf ua_input" data-saiful="stats_post_count" type="text" value="" placeholder="eg: custom_field,_device,_model,_my_field" id="search_from_cf">
                    </p>
                    <p class="message">
                        <b>Tips:</b>
                        <span>After adding custom_field with comma, Check/uncheck from the <b>Search Form</b> list and finally Save your Product Table.</span>
                    </p>
                    <p></p>
                </td>
            </tr>



            <tr>
                <th>
                    <label for="wpt-search-form-order" class="wpt_label">On Sale</label>
                </th>
                <td>


                    <label class="switch">
                        <input saiful="search_n_filter[fields][on_sale]" id="wpt-search-form-order" type="checkbox" value="on">

                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">On</span><span class="off">Off</span><!--END-->
                        </div>
                    </label>


                </td>
            </tr>

            <tr>
                <th>
                    <label for="wpt-search-form-order" class="wpt_label">Order By field</label>
                </th>
                <td>
                    <label class="switch">
                        <input saiful="search_n_filter[fields][orderby]" id="wpt-search-form-order" type="checkbox" value="on">

                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">On</span><span class="off">Off</span><!--END-->
                        </div>
                    </label>


                </td>
            </tr>


            <tr>
                <th>
                    <label for="wpt-search-form-order" class="wpt_label">Hide Search Input Box</label>
                </th>
                <td>
                                        <label class="switch">
                    <input saiful="search_n_filter[hide_input]" id="wpt-search-form-order" type="checkbox" value="on">
                        
                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">On</span><span class="off">Off</span><!--END-->
                        </div>
                    </label>
                    <p class="message">
                        <b>Tips:</b>
                        <span>Hide Input Box of Search Area.</span>
                    </p>
                </td>
            </tr>

            <tr>
                <th>
                    <label for="wpt-search-form-order" class="wpt_label">Search on Whole Site</label>
                </th>
                <td>
                                        <label class="switch">
                    <input saiful="search_n_filter[whole_search]" id="wpt-search-form-order" type="checkbox" value="on">
                        
                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">On</span><span class="off">Off</span><!--END-->
                        </div>
                    </label>
                    <p class="message">
                        <b>Tips:</b>
                        <span>Normally search will held based on your selected query. But to search from whole site, Enable it.</span>
                    </p>
                </td>
            </tr>


        </tbody>
    </table>
</div>
<?php } ?>
    <?php do_action( 'wpto_admin_search_n_filter_tab', $meta_search_n_filter, $post ); ?>


        <table class="ultraaddons-table wpt_snf_on_off wpt-table-separator-light">
           <?php if( wpt_is_pro() ): ?> 
            <tr>
                <th>
                    <label for="wpt-search-form-order" class="wpt_label"><?php esc_html_e( 'Hide Search Input Box', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <?php
                    $hide_input = $meta_search_n_filter['hide_input'] ?? null;
                    $hide_input_checked = $hide_input == 'on' ? 'checked' : '';
                    
                    ?>
                    <label class="switch">
                    <input
                    name="search_n_filter[hide_input]"
                    id="wpt-search-form-order" type="checkbox" 
                    value="on" <?php echo esc_attr( $hide_input_checked ); ?>>
                        
                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">On</span><span class="off">Off</span><!--END-->
                        </div>
                    </label>
                    <p class="message">
                        <b>Tips:</b>
                        <span>Hide Input Box of Search Area.</span>
                    </p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="wpt-search-form-order" class="wpt_label"><?php esc_html_e( 'Search on Whole Site', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <?php
                    $whole_search = $meta_search_n_filter['whole_search'] ?? null;
                    $whole_search_checked = $whole_search == 'on' ? 'checked' : '';
                    
                    ?>
                    <label class="switch">
                    <input
                    name="search_n_filter[whole_search]"
                    id="wpt-search-form-order" type="checkbox" 
                    value="on" <?php echo esc_attr( $whole_search_checked ); ?>>
                        
                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">On</span><span class="off">Off</span><!--END-->
                        </div>
                    </label>
                    <p class="message">
                        <b>Tips:</b>
                        <span>Normally search will held based on your selected query. But to search from whole site, Enable it.</span>
                    </p>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_taxonomy_keywords"><?php esc_html_e( 'Choose Taxonomy', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <?php
                    
                    $taxonomy_keywords = $meta_search_n_filter['taxonomy_keywords'] ?? $default_tax;
                    if( is_string( $taxonomy_keywords ) && ! empty( $taxonomy_keywords ) ){
                        $taxonomy_keywords = wpt_explode_string_to_array( $taxonomy_keywords );
                    }

                    $newArrs = [];
                    if( is_array( $taxonomy_keywords ) && is_array( $allTerms ) ){
                        foreach( $taxonomy_keywords as $ky ){
                            if( ! isset( $allTerms[$ky] ) ) continue;
                            $newArrs[$ky] = $allTerms[$ky];
                        }
                        $newArrs = array_merge($newArrs, $allTerms);
                    }
                    
                    
                    ?>
                    <select name="search_n_filter[taxonomy_keywords][]" id="wpt_advance_search_taxonomy_choose" class="wpt_fullwidth wpt_data_filed_atts wpt_select2 ua_input" multiple>
                        <?php
                        foreach($newArrs as $eTerms){
                            $taxonomy_details = get_taxonomy( $eTerms );
                            $label = $taxonomy_details->labels->menu_name ?? '';
                            if(empty($label)) continue;
                            $selected = is_array( $taxonomy_keywords ) && in_array($eTerms, $taxonomy_keywords) ? 'selected' : '';
                        ?>
                            <option value="<?php echo esc_attr( $eTerms ) ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_html( $label ); ?></option>
                        <?php    
                        }
                        ?>
                    </select>
                    
                    <h4 style="margin:5px 0 0 0;" class="wpt_astaxonomy_choose_notice">After change, Please submit and relaod the page.</h4>
                    
                </td>
            </tr>
        </table>

    <?php
        if( is_array( $taxonomy_keywords ) ){
            // $snf_keywords = $meta_search_n_filter['taxonomy_keywords'];
            $snf_keywords = $taxonomy_keywords;//explode( ',', $snf_keywords );

            
            foreach( $snf_keywords as $per_keyword ){

                $args = array(
                    'hide_empty'    => false, 
                    'orderby'       => 'count',
                    'order'         => 'DESC',
                );

                $taxonomy = get_taxonomy( $per_keyword );
                $t_name = $taxonomy->labels->singular_name ?? '';
                //WooCommerce Product Category Object as Array
                $tax_object = get_terms( $per_keyword, $args );
                // dd($tax_object);
                if( !isset( $tax_object->errors ) ){
                    $my_tax_obj = [];
                    foreach($tax_object as $key => $value){
                        $my_tax_obj[$value->term_id] = $value;
                    }
                    $tax_object = $my_tax_obj;
                    $selected = $meta_search_n_filter[$per_keyword] ?? false;
                    $newArrs = [];
                    if( is_array( $selected ) && is_array( $tax_object ) ){
                        foreach( $selected as $ky ){
                            if( ! isset( $tax_object[$ky] ) ) continue;
                            $newArrs[$ky] = $tax_object[$ky];
                        }
                        
                        $tax_object = $newArrs + $tax_object;
                    }
    ?>
        <table class="ultraaddons-table wpt_snf_on_off ">
            <tr>
                <th>
                    <label class="wpt_label" for="filter_for_<?php echo esc_attr( $per_keyword ); ?>"><?php echo esc_html__('Selected','woo-product-table');?> <?php echo esc_html( $t_name );?></label>
                </th>
                <td>
                    <select name="search_n_filter[<?php echo esc_attr( $per_keyword ); ?>][]" data-name="<?php echo esc_attr( $per_keyword ); ?>" id="filter_for_<?php echo esc_attr( $per_keyword ); ?>" class="wpt_fullwidth wpt_data_filed_atts wpt_select2 ua_input" multiple>
                        <?php
                        foreach ( $tax_object as $tax_item ) {
                            $tax_array_key = $per_keyword;
                            $selected = ( isset( $meta_search_n_filter[$tax_array_key] ) &&  is_array( $meta_search_n_filter[$tax_array_key] ) && in_array( $tax_item->term_id, $meta_search_n_filter[$tax_array_key] ) ? 'selected' : false );//
                        ?>
                            <option value="<?php echo esc_attr( $tax_item->term_id ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_html( $tax_item->name ); ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <p>To show selected items for <?php echo esc_attr( $t_name ); ?>.</p>
                </td>
            </tr>
        </table>
    <?php               
                }
            }
        }else{
    ?>
    <p class=" wpt_snf_on_off " style="background-color: #dd9933;padding: 8px;"><?php esc_html_e( 'To get Taxonomy customization, Please save/update this shortcode.', 'woo-product-table' ); ?></p>
    <?php
        }
    ?>



    <div class="wpt_column">
        <table class="ultraaddons-table wpt-table-separator">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_filter_box"><?php esc_html_e( 'Mini Filter', 'woo-product-table' ); ?></label>
                </th>
                <td>

                <div class="custom-select-box-wrapper sfl-auto-gen-box">
                    <?php
                    $name = 'search_n_filter[filter_box]';
                    $id = 'wpt_filter_box';
                    $current_val = $meta_search_n_filter['filter_box'] ?? 'no';
                    $options = [
                        
                        'yes' => esc_html__( 'Show', 'woo-product-table' ),
                        'no' => esc_html__( 'Hide', 'woo-product-table' ),
                    ];
                    ?>

                    <input type="hidden" name="<?php echo esc_attr( $name ); ?>"
                    data-on="yes|.wpt_filtr_on_off"
                     value="<?php echo esc_attr( $current_val ); ?>"
                     class="custom-select-box-input wpt_toggle" id="<?php echo esc_attr( $id ); ?>">
                    <div class="wpt-custom-select-boxes">

                        <?php foreach ($options as $value => $label): ?>
                            <div class="wpt-custom-select-box <?php echo esc_attr( $current_val === $value ? 'active' : '' ); ?>" data-value="<?php echo esc_attr($value); ?>">
                                <?php echo esc_html( $label ); ?>
                            </div>
                        <?php endforeach; $current_val = null; $options = []; ?>
                    </div>
                    <?php wpt_doc_link('https://wooproducttable.com/docs/doc/advance-uses/use-mini-filter/');?>
                    <p><?php echo esc_html__( 'Only for Visible products of current table.', 'woo-product-table' ) ?></p>
                </div>



                    
                </td>
            </tr>
        </table>
    </div>
    <div class="wpt_column">
        <table class="ultraaddons-table wpt_filtr_on_off ">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_filter"><?php esc_html_e( 'Choose Taxonomy', 'woo-product-table' ); ?></label>
                </th>
                <td>
                <?php
                    
                    $mini_filter_keywords = $meta_search_n_filter['filter'] ?? $default_tax;
                    
                    if( is_string( $mini_filter_keywords ) && ! empty( $mini_filter_keywords ) ){
                        $mini_filter_keywords = wpt_explode_string_to_array( $mini_filter_keywords );
                    }

                    $newArrs = [];
                    if( is_array( $mini_filter_keywords ) && is_array( $allTerms ) ){
                        foreach( $mini_filter_keywords as $ky ){
                            if( ! isset( $allTerms[$ky] ) ) continue;
                            $newArrs[$ky] = $allTerms[$ky];
                        }
                        $newArrs = array_merge($newArrs, $allTerms);
                    }
                    ?>
                    <select name="search_n_filter[filter][]" multiple class="wpt_fullwidth wpt_data_filed_atts wpt_select2 ua_input">
                        <?php
                        foreach($newArrs as $eTerms){
                            $taxonomy_details = get_taxonomy( $eTerms );
                            $label = $taxonomy_details->labels->menu_name ?? '';
                            if(empty($label)) continue;
                            $selected = is_array($mini_filter_keywords) && in_array($eTerms, $mini_filter_keywords) ? 'selected' : '';
                        ?>
                        <option value="<?php echo esc_attr( $eTerms ) ?>" <?php echo esc_attr( $selected ) ?>><?php echo esc_html( $label ) ?></option>
                        <?php    
                        }
                        ?>
                    </select>

                    
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <?php if (!wpt_is_pro()) { ?>
    <div class="wpt-premium-feature-in-free-version">
        <table class="ultraaddons-table wpt-table-separator">
            <tbody>
                <tr>
                    <th>
                        <label class="wpt_label" for="wpt_cf_search_box">Custom Field Filter</label>
                    </th>
                    <td>
                        <select saiful="search_n_filter[cf_search_box]" data-name="cf_search_box" id="wpt_cf_search_box" class="wpt_fullwidth wpt_data_filed_atts ua_input wpt_toggle" data-on="yes|.wpt_custom_field_on_off">
                            <option value="yes" selected="">Show</option>
                            <option value="no" selected>Hide</option>
                            
                        </select> <a href="https://wooproducttable.com/docs/doc/search-and-filter/filter-product-by-custom-fields/" target="_blank" class="wpt-doc-lick">Helper doc</a>
                        <p class="warning">
                            <b>Tips:</b>
                            <span>Not for WooCommerce Archive page. Such: shop page, product category page.</span>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="ultraaddons-table wpt_custom_field_on_off">
            <tbody>
                <tr>
                    <th>
                        <label class="wpt_label">Options</label>
                    </th>
                    <td>

                        <div class="wpt_cf__wrap">
                            <h3 class="wpt_header_title">Change Label - <small>custom text</small></h3>
                            <label for="wpt_key_cf_name_choose">Choose Text</label>
                            <input id="wpt_key_cf_name_choose" value="Choose" type="text" saiful="text_data[choose_text]" placeholder="Choose">
                            <p class="wpt-tips">
                                <b>Tips:</b>
                                <span>Leave as empty for Multiple Selection.</span>
                            </p>

                            <h3 class="wpt_header_title">Add Custom Field - <small>Key and Label</small></h3>
                            <input class="wpt_key_cf" type="text" placeholder="Key. eg: _size">
                            <input class="wpt_key_cf_name" type="text" placeholder="Names. eg: Size">
                            <span class="wpt_key_add button button-primary"> <i class=" dashicons dashicons-plus-alt"></i> Add New Field</span>
                            <span class="wpt_added_message" style="display: none;">Added to list</span>

                            <h3 class="wpt_header_title">Add Value For Filter - <small>Based on cf</small></h3>
                            <div class="wpt_fields">
                                <select class="wpt_select_key">

                                    <option value="_model">Model</option>
                                    <option value="_size">Size</option>
                                </select>
                                <input class="wpt_field_adding_input" type="text" placeholder="Value">

                            </div>

                            <span class="wpt_add_field button button-primary" title="Click here to add new custom fields "><i class="dashicons dashicons-plus-alt"></i> Add Value</span>
                        </div>


                        <h3 class="wpt_filt_value_wrapper_head wpt_header_title">Added Values: <smal>(bellow)</smal>
                        </h3>
                        <div id="wpt_cf__form_field_wrapper">
                            <div class="wpt_each_row_wrapper">
                                <div class="wpt_fld_header">Label: <b>Model</b> | Key: <i>_model</i></div>
                                <div class="wpt_each_row wpt_each_row__model"><input type="hidden" saiful="_cf_filter[_model][label]" value="Model"><input type="text" saiful="_cf_filter[_model][values][]" value="1101" class="wpt_field_value"><input type="text" saiful="_cf_filter[_model][values][]" value="XT00" class="wpt_field_value"><input type="text" saiful="_cf_filter[_model][values][]" value="4500" class="wpt_field_value"></div><i class="wpt_cross_button">x</i>
                            </div>
                            <div class="wpt_each_row_wrapper">
                                <div class="wpt_fld_header">Label: <b>Size</b> | Key: <i>_size</i></div>
                                <div class="wpt_each_row wpt_each_row__size"><input type="hidden" saiful="_cf_filter[_size][label]" value="Size"><input type="text" saiful="_cf_filter[_size][values][]" value="small" class="wpt_field_value"><input type="text" saiful="_cf_filter[_size][values][]" value="medium" class="wpt_field_value"><input type="text" saiful="_cf_filter[_size][values][]" value="large" class="wpt_field_value"></div><i class="wpt_cross_button">x</i>
                            </div>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>

    </div>
<?php } ?>
    <?php do_action( 'wpto_admin_search_n_filter_tab_bottom', $meta_search_n_filter, $post ); ?>
</div>
