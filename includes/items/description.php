<?php
$prod_desc = apply_filters( 'wpto_product_description', $product->get_description(), $id );
echo do_shortcode( $prod_desc, true );