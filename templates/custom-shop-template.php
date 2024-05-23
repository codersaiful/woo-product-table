<?php
/**
 * Custom WooCommerce Shop Template
 */

get_header();

// Start the WooCommerce Shop Loop
if ( have_posts() ) {
    echo '<div class="woocommerce-shop">';
    while ( have_posts() ) {
        the_post();
        wc_get_template_part( 'content', 'product' );
    }
    echo '</div>';
} else {
    echo '<p>No products found</p>';
}

get_footer();
