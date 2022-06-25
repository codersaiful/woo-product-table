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
                    <label class="wpt_label" for="wpt_search_box"><?php esc_html_e( 'Advance Search Box', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <select name="search_n_filter[search_box]" data-name='search_box' id="wpt_search_box" class="wpt_fullwidth wpt_data_filed_atts ua_input wpt_toggle" data-on="yes|.wpt_snf_on_off" >
                        <option value="no" <?php echo isset( $meta_search_n_filter['search_box'] ) && $meta_search_n_filter['search_box'] == 'no' ? 'selected' : ''; ?>><?php esc_html_e( 'Hide Search Box', 'wpt_pro' ); ?></option>
                        <option value="yes" <?php echo isset( $meta_search_n_filter['search_box'] ) && $meta_search_n_filter['search_box'] == 'yes' ? 'selected' : ''; ?>><?php esc_html_e( 'Show Search Box', 'wpt_pro' ); ?></option>
                    </select>
                    <p class="warning">
                        <b><?php echo esc_html__( 'Tips:', 'wpt_pro' ); ?></b>
                        <span><?php echo esc_html__( 'Not for WooCommerce Archive page. Such: shop page, product category page.','wpt_pro' ); ?></span>
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <?php do_action( 'wpo_pro_feature_message', 'pf_search_using_custom_field' ); ?>
    <?php do_action( 'wpto_admin_search_n_filter_tab', $meta_search_n_filter, $post ); ?>


        <table class="ultraaddons-table wpt_snf_on_off wpt-table-separator-light">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_taxonomy_keywords"><?php esc_html_e( 'Taxonomy Keywords for Advance Search Box (Separate with comma[,])', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <?php
                    
                    $taxonomy_keywords = $meta_search_n_filter['taxonomy_keywords'] ?? $default_tax;
                    if( is_string( $taxonomy_keywords ) && ! empty( $taxonomy_keywords ) ){
                        $taxonomy_keywords = wpt_explode_string_to_array( $taxonomy_keywords );
                    }
                    
                    
                    ?>
                    <select name="search_n_filter[taxonomy_keywords][]" class="wpt_fullwidth wpt_data_filed_atts wpt_select2 ua_input" multiple>
                        <?php
                        foreach($allTerms as $eTerms){
                            $taxonomy_details = get_taxonomy( $eTerms );
                            $label = $taxonomy_details->labels->menu_name ?? '';
                            if(empty($label)) continue;
                            $selected = is_array( $taxonomy_keywords ) && in_array($eTerms, $taxonomy_keywords) ? 'selected' : '';
                            echo "<option value='$eTerms' $selected>$label</option>";
                        }
                        ?>
                    </select>
                    <!-- <input name="search_n_filter[taxonomy_keywords]" data-name='taxonomy_keywords' id="wpt_taxonomy_keywords" value="<?php echo isset( $meta_search_n_filter['taxonomy_keywords'] ) ?$meta_search_n_filter['taxonomy_keywords'] : 'product_cat,product_tag'; ?>" class="wpt_fullwidth wpt_data_filed_atts ua_input" type="text" placeholder="<?php esc_attr_e( 'eg: product_cat,product_tag,color,size', 'wpt_pro' ); ?>"> -->
                    
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

                //WooCommerce Product Category Object as Array
                $tax_object = get_terms( $per_keyword, $args );
                if( !isset( $tax_object->errors ) ){
    ?>
        <table class="ultraaddons-table wpt_snf_on_off ">
            <tr>
                <th>
                    <label class="wpt_label" for="filter_for_<?php echo esc_attr( $per_keyword ); ?>"><?php echo sprintf( esc_html__('Choose [%s] %s (For Advanced Searchbox Filter) %s','wpt_pro'),$per_keyword,'<small>','</small>');?></label>
                </th>
                <td>
                    <select name="search_n_filter[<?php echo esc_attr( $per_keyword ); ?>][]" data-name="<?php echo esc_attr( $per_keyword ); ?>" id="filter_for_<?php echo esc_attr( $per_keyword ); ?>" class="wpt_fullwidth wpt_data_filed_atts wpt_select2 ua_input" multiple>
                        <?php
                        foreach ( $tax_object as $tax_item ) {
                            $tax_array_key = $per_keyword;
                            echo "<option value='{$tax_item->term_id}' " . ( isset( $meta_search_n_filter[$tax_array_key] ) &&  is_array( $meta_search_n_filter[$tax_array_key] ) && in_array( $tax_item->term_id, $meta_search_n_filter[$tax_array_key] ) ? 'selected' : false ) . ">{$tax_item->name} - {$tax_item->slug} ({$tax_item->count})</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
    <?php               
                }
            }
        }else{
    ?>
    <p class=" wpt_snf_on_off " style="background-color: #dd9933;padding: 8px;"><?php esc_html_e( 'To get Taxonomy customization, Please save/update this shortcode.', 'wpt_pro' ); ?></p>
    <?php
        }
    ?>
    <?php
        /**
         * To Get Category List of WooCommerce
         * @since 1.0.0 -10
         */

    ?>




    <div class="wpt_column">
        <table class="ultraaddons-table wpt-table-separator">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_filter_box"><?php esc_html_e( 'Mini Filter', 'wpt_pro' ); ?></label>
                </th>
                <td>
                    <select name="search_n_filter[filter_box]" data-name='filter_box' id="wpt_filter_box" class="wpt_fullwidth wpt_data_filed_atts ua_input wpt_toggle"  data-on="yes|.wpt_filtr_on_off">
                        <option value="no" <?php echo isset( $meta_search_n_filter['filter_box'] ) && $meta_search_n_filter['filter_box'] == 'no' ? 'selected' : ''; ?>><?php esc_html_e( 'Hide Filter', 'wpt_pro' ); ?></option>
                        <option value="yes" <?php echo isset( $meta_search_n_filter['filter_box'] ) && $meta_search_n_filter['filter_box'] == 'yes' ? 'selected' : ''; ?>><?php esc_html_e( 'Show Filter', 'wpt_pro' ); ?></option>
                    </select>
                    <p><?php echo esc_html__( 'Only for Visible products of current table.', 'wpt_pro' ) ?></p>
                </td>
            </tr>
        </table>
    </div>
    <div class="wpt_column">
        <table class="ultraaddons-table wpt_filtr_on_off ">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_filter"><?php esc_html_e( 'Taxonomy Keywords for Filter (Separate with comma[,])', 'wpt_pro' ); ?></label>
                </th>
                <td>
                <?php
                    
                    $mini_filter_keywords = $meta_search_n_filter['filter'] ?? $default_tax;
                    
                    ?>
                    <select name="search_n_filter[filter][]" multiple class="wpt_fullwidth wpt_data_filed_atts wpt_select2 ua_input">
                        <?php
                        foreach($allTerms as $eTerms){
                            $taxonomy_details = get_taxonomy( $eTerms );
                            $label = $taxonomy_details->labels->menu_name ?? '';
                            if(empty($label)) continue;
                            $selected = is_array($mini_filter_keywords) && in_array($eTerms, $mini_filter_keywords) ? 'selected' : '';
                            echo "<option value='$eTerms' $selected>$label</option>";
                        }
                        ?>
                    </select>

                    
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <?php do_action( 'wpo_pro_feature_message', 'pf_custom_field_filter' ); ?>
    <?php do_action( 'wpto_admin_search_n_filter_tab_bottom', $meta_search_n_filter, $post ); ?>
</div>
