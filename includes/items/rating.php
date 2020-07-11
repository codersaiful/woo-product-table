<?php
$wpt_average = $data['average_rating'];
$wpt_product_rating = '<div class="star-rating" title="' . sprintf(__('Rated %s out of 5', 'woocommerce'), $wpt_average) . '"><span style="width:' . ( ( $wpt_average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">' . $wpt_average . '</strong> ' . __('out of 5', 'woocommerce') . '</span></div>';
echo "<p class='wpt_rating_p'>" . $wpt_product_rating . "</p>";
