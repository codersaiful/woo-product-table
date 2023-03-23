<?php

$settings = isset( $column_settings[$keyword] ) ? $column_settings[$keyword] : false;

/**
 * New update, 
 * if we found variation, we will take $product->get_parent_id() as product id
 * so that we can get product's category.
 * 
 * 
 * @since 3.3.8.1
 * @author Saiful Islam <codersaiful@gmail.com>
 */

 $wpt_single_category = false;
 $product_id = $id;
 if( 'variation' === $product_type ){
     $product_id = $product->get_parent_id();
 }


$generated_keyword = isset( $settings['older'] ) && $settings['older'] == true ? substr( $keyword, 4 ) : $keyword;
if(is_string( get_the_term_list($product_id,$generated_keyword) ) ){
    echo get_the_term_list($product_id,$generated_keyword,'',', ');
}
