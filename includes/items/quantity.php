<?php

$wpt_single_quantity = false;

$wpt_single_quantity .= woocommerce_quantity_input( array( 
                                                    'input_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
                                                    'max_value'   => apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
                                                    'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
                                                    'step'        => apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
                                                ) , $product, false ); //Here was only woocommerce_quantity_input() at version 1.0

echo $wpt_single_quantity;

