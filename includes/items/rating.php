<?php
$wpt_average = $data['average_rating'];
// var_dump($wpt_average);
$wpt_product_rating = '<div class="star-rating" title="' . sprintf(__('Rated %s out of 5', 'woo-product-table'), $wpt_average) . '"><span style="width:' . ( ( $wpt_average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">' . $wpt_average . '</strong> ' . __('out of 5', 'woo-product-table') . '</span></div>';
echo "<p class='wpt_rating_p'>" . wp_kses_post( $wpt_product_rating ) . "</p>";
