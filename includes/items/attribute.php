<?php
// if( $product_type !== 'variable' && $product_type !== 'simple' ) return;

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

$_variable = new WC_Product_Variable( $product_id );

$_wpt_attributes = $_variable->get_attributes();
echo wpt_additions_data_attribute( $_wpt_attributes );
