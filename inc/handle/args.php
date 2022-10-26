<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Args{

    public static $shortcode;
    public static $args;
    public static $tax_query;
    public static $tax_query_stats;
    public static $post_include;
    public static $table_id;

    /**
     * Args Management Method, args related any type customizaion/ handling will happen here
     * 
     * ARGS Manipulation
     * -----------------
     * 
     * First time, This method was a return value and I assinged that to shortcode.php file
     * but now I have removed return, I assign $shortcode->args which will add to the main object.
     *
     * @param Shortcode $shortcode It's our main Class of Product Table, where all are indicated.
     * @return void
     * 
     * @package WooProductTable
     * @author Saiful Islam <codersaiful@gmail.com>
     */
    public static function manage( Shortcode $shortcode ){
        $shortcode->post_include = $shortcode->basics['post_include'] ?? [];
        $shortcode->post_exclude = $shortcode->basics['post_exclude'] ?? [];
        $shortcode->min_price = $shortcode->conditions['min_price'] ?? '';
        $shortcode->max_price = $shortcode->conditions['max_price'] ?? '';
        
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
        
        if( $shortcode->post_include ){
            $args['post__in'] = $shortcode->post_include;
            $shortcode->orderby = 'post__in';
            $args['orderby'] = $shortcode->orderby;
        }
        if( ! empty( $shortcode->post_exclude ) ){
            $args['post__not_in'] = $shortcode->post_exclude;
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
        self::$args = array_merge( $args, $shortcode->basics_args );
        
        if( $shortcode->req_product_type == 'product_variation' ){

            self::$tax_query = self::$args['tax_query'] ?? [];
            self::$tax_query_stats =  is_array( self::$tax_query ) && ! empty( self::$tax_query );
            self::$post_include = $shortcode->post_include;

            self::args_for_variable();
        }

        $shortcode->args = self::$args;
        // return self::$args;
    }

    /**
     * Manimpulation and generate args
     * if found product type 'product_variation' on Dashboard -> Edit Table -> Query -> product_type
     * 
     * there is no return,
     * I have manipulate $self::args here
     * 
     * Prev used: wpt_get_agrs_for_variable( $args, $post_include = false ) at functions.php
     * 
     * Old explanation:
     * Getting args with generated when customer will choose product
     * from category, taxonomy or any other Attribute 
     * 
     * we have set $args['post_parent__in']
     *
     * @return void
     */
    public static function args_for_variable(){

        self::$args['post_parent__in'] = [];

        if( self::$tax_query_stats ){
            self::$args['post_parent__in'] = self::get_parent_ids_by_term();

        }

        if( ! empty( self::$post_include ) ){
            $post_parent__in = self::$args['post_parent__in'];
            $post_parent__in = array_merge( $post_parent__in, self::$post_include );
            self::$args['post_parent__in'] = array_unique( $post_parent__in );
        }

        if( ! empty( self::$args['post_parent__in'] ) ){
            unset(self::$args['post__in']);
            unset(self::$args['tax_query']);
        }
    }

    /**
     * Getting parent's product ids based on product variation.
     * 
     * Prev used: wpt_get_variation_parent_ids_from_term( $args_tax_query ) at functions.php
     *
     * @return array
     */
    public static function get_parent_ids_by_term(){
        global $wpdb;
        $type = 'term_id';
        $prepare = array();
        $results = $terms = [];
        foreach( self::$tax_query as $tax_details){
            if( !is_array($tax_details) ) continue;

            $terms = is_array( $tax_details['terms'] ) ? $tax_details['terms'] : array();
            $taxonomy = $tax_details['taxonomy'];
            foreach($terms as $term){
                $s_result = $wpdb->get_col( "
                SELECT DISTINCT p.ID
                FROM {$wpdb->prefix}posts as p
                INNER JOIN {$wpdb->prefix}posts as p2 ON p2.post_parent = p.ID
                INNER JOIN {$wpdb->prefix}term_relationships as tr ON p.ID = tr.object_id
                INNER JOIN {$wpdb->prefix}term_taxonomy as tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                INNER JOIN {$wpdb->prefix}terms as t ON tt.term_id = t.term_id
                WHERE p.post_type = 'product'
                AND p.post_status = 'publish'
                AND p2.post_status = 'publish'
                AND tt.taxonomy = '$taxonomy'
                AND t.$type = '$term'
                " );
                if( !is_array($s_result) ) continue;
                $results = array_merge($results, $s_result );
            }
            
        }

        return $results;
    }





}