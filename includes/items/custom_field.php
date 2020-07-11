<?php

$settings = isset( $column_settings[$keyword] ) ? $column_settings[$keyword] : false;

$generated_keyword = isset( $settings['older'] ) && $settings['older'] == true ? substr( $keyword, 3 ) : $keyword;
 //var_dump($generated_keyword);
 $customfield_content = false;
 $custom_meta = get_post_meta( $data['id'],$generated_keyword,true);

 if( function_exists( 'get_field' ) ){
     $acf_content = get_field( $generated_keyword );
     $customfield_content = !$acf_content ? false : $acf_content;
 }

 if( is_string( $customfield_content ) ){
     $customfield_content == do_shortcode( $customfield_content );
 }else{
     $customfield_content = "";
 }
 echo $customfield_content;
 
