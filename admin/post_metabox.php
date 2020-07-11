<?php
/**
 * All metabox will control from here
 * This page added at 4.1.1 date: 19.1.2019
 * 
 * @since 4.1.1
 * @author Saiful Islam<codersaiful@gmail.com>
 */

if( !function_exists( 'wpt_shortcode_metabox' ) ){
    /**
     * Our total metabox or register_meta_box_cb will controll from here. 
     * 
     * @since 4.1.1
     */
    function wpt_shortcode_metabox(){
        add_meta_box( 'wpt_shortcode_metabox_id', 'Shortcode', 'wpt_shortcode_metabox_render', 'wpt_product_table', 'normal' );
        add_meta_box( 'wpt_shortcode_configuration_metabox_id', 'Table Configuration', 'wpt_shortcode_configuration_metabox_render', 'wpt_product_table', 'normal' ); //Added at 4.1.4

    }
}

if( !function_exists( 'wpt_shortcode_metabox_render' ) ){
    function wpt_shortcode_metabox_render(){
        global $post;
        $curent_post_id = $post->ID;
        $post_title = preg_replace( '/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/',"$1", $post->post_title );
        echo '<input type="text" value="[Product_Table id=\'' . $curent_post_id . '\' name=\'' . $post_title . '\']" class="wpt_auto_select_n_copy wpt_meta_box_shortcode mb-text-input mb-field" id="wpt_metabox_copy_content" readonly>'; // class='wpt_auto_select_n_copy'
        echo '<a style="display:none;"  class="button button-primary wpt_copy_button_metabox" data-target_id="wpt_metabox_copy_content">Copy</a>';
        echo '<p style="color: #007692;font-weight:bold;display:none; padding-left: 12px;" class="wpt_metabox_copy_content"></p>';

    }
}

if( !function_exists( 'wpt_shortcode_configuration_metabox_render' ) ){
    //Now start metabox for shortcode Generator
    function wpt_shortcode_configuration_metabox_render(){
        global $post;
        echo '<input type="hidden" name="wpt_shortcode_nonce_value" value="' . wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />'; //We have to remove it later
        include __DIR__ . '/post_metabox_form.php';
        ?> 
        <br style="clear: both;">
        <?php
    }
}

if( !function_exists( 'wpt_shortcode_configuration_metabox_save_meta' ) ){
    function wpt_shortcode_configuration_metabox_save_meta( $post_id, $post ) { // save the data
        /*
         * We need to verify this came from our screen and with proper authorization,
         * because the save_post action can be triggered at other times.
         */

        if ( ! isset( $_POST['wpt_shortcode_nonce_value'] ) ) { // Check if our nonce is set.
                return;
        }

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if( !wp_verify_nonce( $_POST['wpt_shortcode_nonce_value'], plugin_basename(__FILE__) ) ) {
                return;
        }
        /**
         * @Hook Filter: wpto_on_save_global_post
         * To change/Modify $_POST
         * Before Save Data on Database by update_post_meta() func
         * @since 6.1.0.5
         * @Hook_Version: 6.1.0.5
         */
        //$_POST = add_filters( 'wpto_on_save_global_post', $_POST, $post_id, $post );

        $save_tab_array = array(
            'column_array' => 'column_array',
            'enabled_column_array' => 'enabled_column_array',
            'column_settings' => 'column_settings',
            'basics' => 'basics',
            'table_style' => 'table_style',
            'conditions' => 'conditions',
            'mobile' => 'mobile',
            'search_n_filter' => 'search_n_filter',
            'pagination' => 'pagination',
            'config' => 'config',
        );

        $save_tab_array = apply_filters( 'wpto_save_tab_array', $save_tab_array, $post_id, $post );

        if( !is_array( $save_tab_array ) || ( is_array( $save_tab_array ) && count( $save_tab_array ) < 1 )){
            return;
        }

        /**
         * @Hook Action: wpto_on_save_post_before_update_meta
         * To change data Just before update_post_meta() of our Product Table Form Data
         * @since 6.1.0.5
         * @Hook_Version: 6.1.0.5
         */
        add_action( 'wpto_on_save_post_before_update_meta', $post_id, $post, $save_tab_array );

        foreach( $save_tab_array as $tab ){
            $tab_data = isset( $_POST[$tab] ) ? $_POST[$tab] : false;
            update_post_meta( $post_id, $tab, $tab_data );
        }

        /**
         * @Hook Action: wpto_on_save_post
         * To change data when Form will save.
         * @since 6.1.0.5
         * @Hook_Version: 6.1.0.5
         */
        add_action( 'wpto_on_save_post', $post_id, $post );

    }
}
add_action( 'save_post', 'wpt_shortcode_configuration_metabox_save_meta', 10, 2 ); // 