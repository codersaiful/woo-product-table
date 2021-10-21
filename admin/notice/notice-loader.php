<?php

add_action( 'admin_notices', 'wpt_admin_notice_user_rating_rq' );
function wpt_admin_notice_user_rating_rq(){
?>
<div class="notice notice-success is-dismissible wpt-notice wpt-user-rating-notice">
    <p>
        Hey, we noticed you've been using <strong>Product Table for WooCommerce(wooproducttable)</strong> for many days - that's awesome.<br>
        Could you please do us a <strong>BIG Favor</strong> and give it a rating on WordPress.org to help us spread the word and boost our motivation?
    </p>
    <p>
        <strong>Saiful Islam</strong><br>
        Author of Woo Product Table<br>
        <strong>CEO</strong> of CodeAstrology
    </p>
    <p class="do-rating-area">
        <a class="" data-response='rating' href="https://wordpress.org/support/plugin/woo-product-table/reviews/#new-post" target="_blank"><strong>Yes, you deserve it</strong></a><br>
        <a data-response='rating-later'>No, May be later</a><br>
        <a data-response='rating-already'>I already did</a>
        
    </p>
</div>    
<?php
}

function wpt_admin_update_option(){
    
}