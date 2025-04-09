<?php
$wpt_wishlist = do_shortcode( '[yith_wcwl_add_to_wishlist]');
echo wp_kses_post( $wpt_wishlist );
