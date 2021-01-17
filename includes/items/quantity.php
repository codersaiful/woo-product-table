<?php

woocommerce_quantity_input( array( 
    'input_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
    'max_value'   => apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
    'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
    'step'        => apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
) , $product, true );