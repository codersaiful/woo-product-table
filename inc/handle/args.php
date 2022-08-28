<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Args{

    public static function manage( Shortcode $shortcode ){
        $args = [
            'posts_per_page' => $shortcode->posts_per_page ?? -1,
            'post_type' => array('product'), //, 'product_variation','product'
            'post_status'   =>  'publish',
            'meta_query' => array(),
            'wpt_query_type' => 'default',
            'pagination'    => $shortcode->pagination['start'] ?? 0,
        ];
        return $args;
    }



}