<?php

add_action( 'admin_notices', 'wpt_admin_notice_user_rating_rq' );
function wpt_admin_notice_user_rating_rq(){
    
    //return false;
?>
<div class="notice notice-success is-dismissible wpt-notice wpt-user-rating-notice">
    <p>
        <?php
        var_dump(get_option( 'tesing_saiful' ));
        ?>
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

/**
 * we are handaling notice update option 
 * using ajax
 * 
 * ######## action data ########
 * option_key: (string)
 * option_value: any type date can get using option value
 * callback: (string) here, final return output will pass as params
 * perpose: (string) get|option - update or getting data from wp optiion table
 * 
 * 
 * @since 3.0.2.0
 */
function wpt_admin_update_notice_option(){

//    echo 'Saiful Update';die();
//
//    $option_key = isset( $_POST['option_key'] ) && ! empty( $_POST['option_key'] ) ? $_POST['option_key'] : false;
//    $option_value = isset( $_POST['option_value'] ) ? $_POST['option_value'] : false;
//    $perpose = isset( $_POST['perpose'] ) && $_POST['perpose'] == 'get' ? 'get' : 'update';
//    $callback = isset( $_POST['callback'] ) && ! empty( $_POST['callback'] ) ? $_POST['callback'] : false;
//    
//    //echo 'Saiful';
//    //return;
//    
//    if( ! $option_key ){
//        return;
//    }
//    
//    
//    
//    if( $perpose == 'update' ){
//        
//        /**
//         * Value will executive using callback function or diirect value
//         */
//        $final_value = $callback && is_string( $callback ) ? $callback( $option_value ) : $option_value;
//
//        update_option( $option_key, $option_value );
//        echo 'updated';
//    }elseif( $perpose == 'get' ){
//        $output = get_option( $option_key );
//        $final_output = $callback && is_string( $callback ) ? $callback( $output ) : $output;
//        echo $final_output;
//    }
//    die();
    
}
add_action( 'wp_ajax_nopriv_wpt_admin_update_notice_option', 'wpt_admin_update_notice_option' );
