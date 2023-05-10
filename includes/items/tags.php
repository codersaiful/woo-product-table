<?php
$wpt_single_tags = false;
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
 
$wpt_tag_col = wc_get_product_tag_list( $product_id );
$wpt_single_tags .= $wpt_tag_col;
echo wp_kses_post( $wpt_single_tags );
