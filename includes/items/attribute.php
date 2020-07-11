<?php
$variable = new WC_Product_Variable($id);
$attributes = $variable->get_attributes();
echo wpt_additions_data_attribute( $attributes );
