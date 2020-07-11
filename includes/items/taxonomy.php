<?php

$settings = isset( $column_settings[$keyword] ) ? $column_settings[$keyword] : false;

$generated_keyword = isset( $settings['older'] ) && $settings['older'] == true ? substr( $keyword, 4 ) : $keyword;
if(is_string( get_the_term_list($data['id'],$generated_keyword) ) ){
    echo get_the_term_list($data['id'],$generated_keyword,'',', ');
}

 
 /**
* Texonomy Handaler
* 
* @since 1.9 
* @date: 10.6.2016 d.m.y
*
if(is_array( $texonomy_key ) && count( $texonomy_key ) > 0 ){
   foreach( $texonomy_key as $keyword ){
      $generated_keyword = substr( $keyword, 4 );
       $texonomy_content = '';
       if(is_string( get_the_term_list($data['id'],$generated_keyword) ) ){
           $texonomy_content = get_the_term_list($data['id'],$generated_keyword,'',', ');
       }
      $wpt_each_row[$keyword] = "<td data-keyword='wpt_{$keyword}' class='wpt_custom_cf_tax wpt_custom_tax wpt_{$keyword}'>" . $texonomy_content . "</td>";  
   }
}
//*****************************/