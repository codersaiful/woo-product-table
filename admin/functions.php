<?php
if( !function_exists( 'wpt_admin_body_class' ) ){
    /**
     * set class for Admin Body tag
     * 
     * @param type $classes
     * @return String
     */
    function wpt_admin_body_class(){
        global $current_screen;
        $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
        if( strpos( $s_id, 'wpt_product_table') !== false ){
            return ' wpt_admin_body ';
        }
        return;
    }
}
add_filter( 'admin_body_class', 'wpt_admin_body_class' );

if( !function_exists( 'wpt_selected' ) ){
    
    /**
     * actually for Select Option
     * Inside Config Tab or Inside Configuration Page
     * Executing If available or Not. 
     * If false $default_config, Then It will come from 
     * get_option( 'wpt_configure_options' )
     * 
     * @since 2.4 
     */
    function wpt_selected(  $keyword, $gotten_value, $default_config = false ){
        $current_config_value = is_array( $default_config ) ? $default_config : get_option( 'wpt_configure_options' );
        echo ( isset( $current_config_value[$keyword] ) && $current_config_value[$keyword] == $gotten_value ? 'selected' : false  );
    }
}



if( !function_exists( 'wpt_admin_responsive_tab' ) ){
    function wpt_admin_responsive_tab( $tab_array ){
        unset($tab_array['mobile']);
        $tab_array['responsive'] = __( 'Responsive <small>New</small>', 'wpt_pro' );
        $tab_array['mobile'] = __( 'Mobile <span>will remvoed</span>', 'wpt_pro' );
        return $tab_array;
    }
}
add_filter( 'wpto_admin_tab_array', 'wpt_admin_responsive_tab' );

if( !function_exists( 'wpt_admin_responsive_tab_save' ) ){
    function wpt_admin_responsive_tab_save( $save_tab_array ){
        $save_tab_array['responsive'] = 'responsive';
        return $save_tab_array;
    }
}
add_filter( 'wpto_save_tab_array', 'wpt_admin_responsive_tab_save' );

if( !function_exists( 'wpt_admin_responsive_tab_file' ) ){
    function wpt_admin_responsive_tab_file(){
        /**
         * you have return your new file, if u want it on Responsive Tab
         */
        //return 'my_new_location_will_be_here';
    }
}

//add_filter( 'wpto_admin_tab_file_loc_responsive', 'wpt_admin_responsive_tab_file' );

if( !function_exists( 'wpt_product_includes_select_option' ) ){
    function wpt_product_includes_select_option( $args ){
        
        $html = '';
        $p_query_posts = query_posts($args);
        if( is_array( $p_query_posts ) && count( $p_query_posts ) > 0 ){
            foreach( $p_query_posts as $p_post ){
                $p_product = wc_get_product($p_post->ID);
                $data = $p_product->get_data();
                $stock_status = isset( $data['stock_status'] ) ? $data['stock_status'] : '';
                $price =  isset( $data['price'] ) ? get_woocommerce_currency_symbol(). '' . $data['price'] : '';
                $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $p_post->ID ), array(50,50), false );
                $image = isset( $img_src[0] ) ? $img_src[0] : '';
                $text = $image . "|" . $price . "|" . $stock_status;
                $title = ( mb_strlen( $p_post->post_title ) > 50 ) ? mb_substr( $p_post->post_title, 0, 49 ) . '...' : $p_post->post_title;
                $html .= "<option title=" . esc_attr( $text ) . " value=". $p_post->ID ." selected>$title</option>";
            }
        }
        wp_reset_postdata();   wp_reset_query();
        return $html;
    }
}
