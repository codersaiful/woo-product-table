<?php
$wpt_single_tags = false;
$wpt_tag_col = wc_get_product_tag_list( $data['id'] );
$wpt_single_tags .= $wpt_tag_col;
echo wp_kses_post( $wpt_single_tags );
