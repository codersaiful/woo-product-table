<div style="border: 1px solid #dd000024;margin: 10px 0px;padding: 10px;background: #dd000005;max-width: 600px;">
<h1>VAR_DUMP INFO</h1><p>Available Variable inside your Item Template</p><hr>

<h2>$items</h2>
<p>ARRAY of All items of user selected. such as: price, action,shortcode etc</p>
<code>var_dump( $items );</code>
<?php var_dump( $items ); ?>

<h2>$item</h2>
<p>Individual Item inside TD such as: price, action,shortcode etc </p>
<code>var_dump( $item );</code>
<?php var_dump( $item ); ?>

<h2>$settings</h2>
<p>settings of each Item inside of TD/Cell</p>
<code>var_dump( $settings );</code>
<?php var_dump( $settings ); ?>

<h2>$POST_ID</h2>
<p>Table ID, Custom Post ID for this Product Table</p>
<code>var_dump( $POST_ID );</code>
<?php var_dump( $POST_ID ); ?>

<h2>$validation</h2>
<p>Validation of Item, such: price, action, thumbnail etc</p>
<code>var_dump( $validation );</code>
<?php var_dump( $validation ); ?>

<h2>$tr_key</h2>
<p>Column Number</p>
<code>var_dump( $tr_key );</code>
<?php var_dump( $tr_key ); ?>

<h2>$product_id</h2>
<p>Product ID for Each Row</p>
<code>var_dump( $product_id );</code>
<?php var_dump( $product_id ); ?>

<h2>$product_type</h2>
<p>Product ID for Each Row</p>
<code>var_dump( $product_type );</code>
<?php var_dump( $product_type ); ?>

<h2>$rowtype</h2>
<p>Product ID for Each Row</p>
<code>var_dump( $rowtype );</code>
<?php var_dump( $rowtype ); ?>

<h2>$wc_product_data</h2>
<p>Getting data by $product->get_data() </p>
<code>var_dump( $wc_product_data );</code>
<?php var_dump( $wc_product_data ); ?>

<h2>$product</h2>
<p>Product Array - Global $product</p>
<code>var_dump( $product );</code>
<?php var_dump( $product ); ?>



</div>
<!--  $item_keyword => $item -->