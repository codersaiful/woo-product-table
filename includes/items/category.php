<?php
$wpt_single_category = false;

$wpt_cotegory_col = wc_get_product_category_list( $data['id'] );
$wpt_single_category .= $wpt_cotegory_col;

echo $wpt_single_category;
