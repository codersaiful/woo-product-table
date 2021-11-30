<?php
// update_option('wpt_user_rating_notice',0);//get_option( 'wpt_user_rating_notice' );
add_action( 'admin_notices', 'wpt_admin_notice_user_rating_rq' );
function wpt_admin_notice_user_rating_rq(){

    if( ! wpt_admin_notice_display() ){
        return;
    }
    $config = get_option( 'wpt_configure_options' );//disable_rating_notice
    if( isset( $config['disable_rating_notice'] ) && $config['disable_rating_notice'] == 'on' ){
        return;
    }
    
    echo wpt_admin_notice_html_markup();
}


/**
 * WPT User rating notice update using PHP Get supper global variable
 * 
 * @since 3.0.7.0
 * @author Saiful Islam <codersaiful@gmail.com>
 *
 * @return void
 */
function wpt_admin_notice_control_update(){
    if( ! isset( $_GET['wpt_user_rating_option'] ) ) return;
    $u_r_o = $_GET['wpt_user_rating_option'];
    if( empty( $u_r_o ) ) return;
    

    $time_limit = "20 days";
    if( $u_r_o  === 'rating-already' ){
        $time_limit = "60 days";
    }
    $option_key = 'wpt_user_rating_notice';
    $final_value = strtotime($time_limit);
    update_option( $option_key, $final_value );
}
add_action( 'admin_head', 'wpt_admin_notice_control_update' );

/**
 * we will return false, it fail time limite 
 * currently we will set 10 days limitation
 * for displaying this user rating notice board
 * 
 * @since 3.0.2.0
 * @by Saiful Islam
 */
function wpt_admin_notice_display( $day = 40){
    $bool = true;
    $limit_time_sec = $day * 24 * 60 * 60;
    
    $today = time();
    $last_close_day = get_option( 'wpt_user_rating_notice' );
    if( empty( $last_close_day )  ){
        $bool = true;
    }
    if( ! is_numeric( $last_close_day ) ){
        $last_close_day = 2*24*60*60;
    }

    $diff = $today - $last_close_day;
//    var_dump($limit_time_sec,$diff);
    if( $diff < $limit_time_sec){
        $bool = false;
    }
    return apply_filters( 'wpto_user_rating_notice', $bool, $last_close_day );
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
 * @by Saiful Islam
 */
function wpt_admin_update_notice_option(){
    
    $option_key = isset( $_POST['option_key'] ) && ! empty( $_POST['option_key'] ) ? $_POST['option_key'] : false;
    $option_value = isset( $_POST['option_value'] ) ? $_POST['option_value'] : false;
    $perpose = isset( $_POST['perpose'] ) && $_POST['perpose'] == 'get' ? 'get' : 'update';
    $callback = isset( $_POST['callback'] ) && ! empty( $_POST['callback'] ) && is_string( $_POST['callback'] ) ? $_POST['callback'] : false;
   
    if( ! $option_key ){
        return;die();
    }

    if( $perpose == 'update' ){

        /**
         * Value will executive using callback function or diirect value
         */
        if( !empty( $option_value ) ){
            $final_value = $callback && function_exists( $callback ) ? $callback( $option_value ) : $option_value;
        }else{
            $final_value = $callback && function_exists( $callback ) ? $callback() : $option_value;
        }

        update_option( $option_key, $final_value );
        echo 'updated';
    }elseif( $perpose == 'get' ){
        $output = get_option( $option_key );

        if( ! empty( $output ) ){
            $final_output = $callback && function_exists( $callback ) ? $callback( $output ) : $output;
        }else{
            $final_output = $callback && function_exists( $callback ) ? $callback() : $output;
        }
        
        echo $final_output;
    }
    die();
    
}
add_action( 'wp_ajax_nopriv_wpt_admin_update_notice_option', 'wpt_admin_update_notice_option' );
add_action( 'wp_ajax_wpt_admin_update_notice_option', 'wpt_admin_update_notice_option' );