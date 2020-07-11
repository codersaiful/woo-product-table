<?php
$wpt_wishlist = false;
$wpt_wishlist .= do_shortcode( '[yith_wcwl_add_to_wishlist product_id='. $data['id'] .' icon="'. (get_option( 'yith_wcwl_add_to_wishlist_icon' ) != '' && get_option( 'yith_wcwl_use_button' ) == 'yes' ? get_option( 'yith_wcwl_add_to_wishlist_icon' ) : 'fa-heart') .'"]' );

echo $wpt_wishlist;
