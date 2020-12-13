<?php
$_variable = new WC_Product_Variable( $id );
$_wpt_attributes = $_variable->get_attributes();
echo wpt_additions_data_attribute( $_wpt_attributes );
