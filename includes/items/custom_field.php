<?php

$settings = isset( $column_settings[$keyword] ) ? $column_settings[$keyword] : false;

$generated_keyword = isset( $settings['older'] ) && $settings['older'] == true ? substr( $keyword, 3 ) : $keyword;

$product_id = $id;
 $variation_wise_id = apply_filters( 'wpto_product_real_id', false, $product, $temp_number, $keyword, $column_settings );
 if( $product->get_type() == 'variation' && !$variation_wise_id ){ // && !$variation_wise_id
     $product_id = $product->get_parent_id();
 }
 $customfield_content = false;
 $custom_meta = get_post_meta( $product_id, $generated_keyword, true);

 
 if( function_exists( 'get_field' ) ){
     $acf_content = get_field( $generated_keyword );
     $customfield_content = !$acf_content ? false : $acf_content;
 }

 if( is_string( $customfield_content ) ){
     $customfield_content == do_shortcode( $customfield_content );
 }else{
     $customfield_content = $custom_meta;
 }
 echo $customfield_content;
 
