<?php

if ( ! function_exists('wpt_product_table_post') ) {

/**
 * Create Custom post type for Product Table. From now, we will store our shortcode or shortcode's value in this post as meta value
 * 
 * @since 4.1
 * @link https://codex.wordpress.org/Post_Types See details at WordPress.org about Custom Post Type
 */
function wpt_product_table_post() {

        $icon = WPT_Product_Table::getPath( 'BASE_URL' ) . 'assets/images/table_icon.png';
	$labels = array(
		'name'                  => _x( 'Product Table', 'Product Table', 'woo-product-table' ),
		'singular_name'         => _x( 'PRODUCT TABLE', 'PRODUCT TABLE', 'woo-product-table' ),
		'menu_name'             => __( 'Woo Product Table', 'woo-product-table' ),
		'name_admin_bar'        => __( 'Product Table', 'woo-product-table' ),
		'archives'              => __( 'Product Table Archives', 'woo-product-table' ),
		'attributes'            => __( 'Product Table Attributes', 'woo-product-table' ),
		'parent_item_colon'     => __( 'Parent Shortcode:', 'woo-product-table' ),
		'all_items'             => __( 'Product Table', 'woo-product-table' ),
		'add_new_item'          => __( 'Add New', 'woo-product-table' ),
		'add_new'               => __( 'Add New', 'woo-product-table' ),
		'new_item'              => __( 'New Product Table', 'woo-product-table' ),
		'edit_item'             => __( 'Edit Product Table', 'woo-product-table' ),
		'update_item'           => __( 'Update Product Table', 'woo-product-table' ),
		'view_item'             => __( 'View Product Table', 'woo-product-table' ),
		'view_items'            => __( 'View Product Tables', 'woo-product-table' ),
		'search_items'          => __( 'Search Product Table', 'woo-product-table' ),
		'not_found'             => __( 'Not found', 'woo-product-table' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'woo-product-table' ),
		'featured_image'        => __( 'Featured Image', 'woo-product-table' ),
		'set_featured_image'    => __( 'Set featured image', 'woo-product-table' ),
		'remove_featured_image' => __( 'Remove featured image', 'woo-product-table' ),
		'use_featured_image'    => __( 'Use as featured image', 'woo-product-table' ),
		'insert_into_item'      => __( 'Insert into Product Table', 'woo-product-table' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Product Table', 'woo-product-table' ),
		'items_list'            => __( 'Product Table list', 'woo-product-table' ),
		'items_list_navigation' => __( 'Product Table list navigation', 'woo-product-table' ),
		'filter_items_list'     => __( 'Filter Product Table list', 'woo-product-table' ),
	);
	$args = array(
		'label'                 => __( 'PRODUCT TABLE', 'woo-product-table' ),
		'description'           => __( 'Generate your shortcode for Product Table.', 'woo-product-table' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 40,
                'menu_icon'             => $icon,//'dashicons-list-view',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'capabilities' => array(
                    'edit_post' => 'edit_wpt_product_table',
                    'edit_posts' => 'edit_wpt_product_tables',
                    'edit_others_posts' => 'edit_others_wpt_product_tables',
                    'publish_posts' => 'publish_wpt_product_tables',
                    'read_post' => 'read_wpt_product_table',
                    'read_private_posts' => 'read_private_wpt_product_tables',
                    'delete_post' => 'delete_wpt_product_table',
                ),
                "rewrite" => [ "slug" => "wpt_product_table", "with_front" => true ],
                'map_meta_cap' => true,
                'register_meta_box_cb'  => 'wpt_shortcode_metabox',
	);
	register_post_type( 'wpt_product_table', $args );

}
add_action( 'init', 'wpt_product_table_post', 0 );

}

if( ! function_exists( 'wpt_shortcode_column_head' ) ){

    //Showing shortcode in All Shortcode page
    function wpt_shortcode_column_head($default){

        if ( 'wpt_product_table' == get_post_type() ){
        $default['wpt_shortcode'] = "Shortcode";
        }
        return $default;
    }
}
add_filter('manage_posts_columns', 'wpt_shortcode_column_head');

if( ! function_exists( 'wpt_shortcode_column_content' ) ){

    function wpt_shortcode_column_content($column_name, $post_id){

        if ($column_name == 'wpt_shortcode') {
            $post_title = get_the_title( $post_id );
            $post_title = preg_replace( '/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/',"$1", $post_title );
            echo "<input style='display: inline-block;width:300px;' class='wpt_auto_select_n_copy' type='text' value=\"[Product_Table id='{$post_id}' name='{$post_title}']\" id='wpt_shotcode_content_{$post_id}' readonly>";
            echo '<a style="font-size: 12px !important;padding: 4px 13px !important" class="button button-primary wpt_copy_button_metabox" data-target_id="wpt_shotcode_content_' . $post_id . '">'. esc_html__( 'Copy','woo-product-table' ).'</a>';
            echo '<p style="color: green;font-weight:bold;display:none; padding-left: 12px;" class="wpt_shotcode_content_' . $post_id . '"></p>';
        }  
    }
}
add_action('manage_posts_custom_column', 'wpt_shortcode_column_content', 2, 2);


//Permalink Hiding Option
//add_filter( 'get_sample_permalink_html', 'wpt_permalink_hiding' );
if( ! function_exists( 'wpt_permalink_hiding' ) ){

    function wpt_permalink_hiding( $return ) {

        if ( 'wpt_product_table' == get_post_type() ){
            $return = '';
        }
        return $return;
    }
}


//Hiding Preview Button from all shortcode page
//add_filter( 'page_row_actions', 'wpt_preview_button_hiding', 10, 2 );
if( ! function_exists( 'wpt_preview_button_hiding' ) ){
	
    function wpt_preview_button_hiding( $actions, $post ) {

        if ( 'wpt_product_table' == get_post_type() ){
            unset( $actions['inline hide-if-no-js'] );
            unset( $actions['view'] );
        }
        return $actions;
    }
}
