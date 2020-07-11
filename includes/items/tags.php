<?php
$wpt_single_tags = false;
$wpt_tag_col = wc_get_product_tag_list( $data['id'] );
$wpt_single_tags .= $wpt_tag_col;
echo $wpt_single_tags;
