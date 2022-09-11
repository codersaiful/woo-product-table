<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Args{

    public static function manage( Shortcode $shortcode ){
        $shortcode->post_include = $shortcode->basics['post_include'] ?? [];
        $shortcode->post_exclude = $shortcode->basics['post_exclude'] ?? [];
        $shortcode->min_price = $shortcode->conditions['min_price'] ?? '';
        $shortcode->max_price = $shortcode->conditions['max_price'] ?? '';
        var_dump($shortcode->req_product_type);
        $args = [
            'posts_per_page' => $shortcode->posts_per_page ?? -1,
            'post_type' => $shortcode->req_product_type, //, 'product_variation','product'
            'post_status'   =>  'publish',
            'meta_query' => array(),
            'wpt_query_type' => 'default',
            'pagination'    => $shortcode->pagination['start'] ?? 0,
        ];

        if( isset( $_GET['s'] ) && !empty( $_GET['s'] ) ){
            $args['s'] = sanitize_text_field( $_GET['s'] );
        }else{
            $args['suppress_filters'] = 1;
            unset( $args['s'] );
        }

        $shortcode->meta_value_sort = $shortcode->conditions['meta_value_sort'] ?? '';
        $shortcode->orderby = $shortcode->conditions['sort_order_by'] ?? '';
        $shortcode->order = $shortcode->conditions['sort'] ?? '';

        if ( $shortcode->order ) { //$sort
            $args['orderby'] = $shortcode->orderby;
            $args['order'] = $shortcode->order;
        }

        if( $shortcode->meta_value_sort && ( $shortcode->orderby == 'meta_value' || $shortcode->orderby == 'meta_value_num' ) ){
            $args['meta_query'][] = [
                'key'     => $shortcode->meta_value_sort,
                'compare' => 'EXISTS',
            ];
        }


        $only_stock = $shortcode->conditions['only_stock'] ?? false;
        $shortcode->only_stock = $only_stock !== 'no' ? $only_stock : false;
        if( $shortcode->only_stock ){
            $args['meta_query'][] = [
                'key' => '_stock_status',
                'value' => $shortcode->only_stock
            ];
        }
        
        if($shortcode->post_include){
            $args['post__in'] = $shortcode->post_include;
            $shortcode->orderby = 'post__in';
            $args['orderby'] = $shortcode->orderby;
        }


        $only_sale = $shortcode->conditions['only_sale'] ?? false;
        $shortcode->only_sale = $only_sale == 'yes' ?? false;
        if( $shortcode->only_sale ){
            $sale_products = wc_get_product_ids_on_sale();
            $sale_products = $sale_products && is_array( $sale_products ) && $shortcode->post_include && is_array( $shortcode->post_include ) ? array_intersect( $shortcode->post_include, $sale_products ) : $sale_products;
            $args['post__in'] = $sale_products;
        }

        if ( $shortcode->min_price ) {
            $args['meta_query'][] = array(
                'key' => '_price',
                'value' => $shortcode->min_price,
                'compare' => '>=',
                'type' => 'NUMERIC'
            );
        }
        if ( $shortcode->max_price ) {
            $args['meta_query'][] = array(
                'key' => '_price',
                'value' => $shortcode->max_price,
                'compare' => '<=',
                'type' => 'NUMERIC'
            );
        }

        $page_number = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
        $shortcode->page_number = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : $page_number;
        $args['paged'] = (int) $shortcode->page_number;

        /**
         * What is Basics Args:
         * Actually in database by query tab filed of different taxonomy
         * we store like query and stored it in basics tab
         * and I made a property by following code at Class Shortcode:inc/shortcode.php
         * $this->basics_args = $this->basics['args'] ?? [];
         */
        return array_merge( $args, $shortcode->basics_args );
    }



}