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
        //add_meta_box( 'wpt_column_panel_metabox_id', __( 'Available Columns', 'wpt' ), 'wpt_column_panel_metabox_render', 'wpt_product_table', 'side', 'low' ); //Added at 4.1.4
        /**
         * Added new feature for Product Table
         * 
         * @since 2.8.5.1
         * @by Saiful 
         */
        add_meta_box( 'wpt_export_import_metabox_id', __( 'Export/Import', 'wpt_pro' ), 'wpt_export_import_metabox_render', 'wpt_product_table', 'normal' );
    }
}

if( !function_exists( 'wpt_column_panel_metabox_render' ) ){
    /**
     * This function showing column panel 
     * 
     * @since 2.7.8.1
     */
    function wpt_column_panel_metabox_render(){
        global $post;
        /**
         * Filter Hook was not working from theme's function file, so need this filter inside function
         */
        WPT_Product_Table::$columns_array = apply_filters( 'wpto_default_column_arr', WPT_Product_Table::$columns_array );
        WPT_Product_Table::$default_enable_columns_array = apply_filters( 'wpto_default_enable_column_arr', WPT_Product_Table::$default_enable_columns_array );
        
        $default_enable_array = WPT_Product_Table::$default_enable_columns_array;
        $columns_array = WPT_Product_Table::$columns_array;
        $for_add =  $meta_column_array = $updated_columns_array = get_post_meta( $post->ID, 'column_array', true );
        if( !$meta_column_array && empty( $meta_column_array ) ){
            $for_add = $updated_columns_array = WPT_Product_Table::$columns_array;
        }
        if( $updated_columns_array && !empty( $updated_columns_array ) && !empty( $columns_array ) ){
            $columns_array = array_merge( $columns_array, $updated_columns_array );
        }
        ksort($columns_array);
//        $meta_enable_column_array = get_post_meta( $post->ID, 'enabled_column_array', true );
//        if( $meta_enable_column_array && !empty( $meta_enable_column_array ) && !empty( $columns_array ) ){
//            $columns_array = array_merge($meta_enable_column_array,$columns_array);
//        }
//
//        $column_settings = get_post_meta( $post->ID, 'column_settings', true ); 
//        if( empty( $column_settings ) ){
//            $column_settings = array();
//        }
//        $additional_collumn = array_diff(array_keys($for_add), array_keys( WPT_Product_Table::$columns_array ));

        ?>
        <div class="section">
            <p><?php echo esc_html__( 'Available columns for WOO Product Table. Add them in your table to enable column.', 'wpt' ); ?></p>
            <ul id="wpt_column_sortable">
                <?php foreach( $columns_array as $keyword => $title ){ ?>
                <li data-column_key = "<?php echo esc_attr( $keyword ); ?>"><?php echo esc_html( $title ); ?></li>
                <?php } ?>
            </ul>
        </div>
        <?php
    }
    
}

if( !function_exists( 'wpt_shortcode_metabox_render' ) ){
    function wpt_shortcode_metabox_render(){
        global $post;
        $curent_post_id = $post->ID;
        $post_title = preg_replace( '/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/',"$1", $post->post_title );
        echo '<div class="wpt-shortcode-box-inside">';
        echo '<input type="text" value="[Product_Table id=\'' . $curent_post_id . '\' name=\'' . $post_title . '\']" class="wpt_auto_select_n_copy wpt_meta_box_shortcode mb-text-input mb-field" id="wpt_metabox_copy_content" readonly>'; // class='wpt_auto_select_n_copy'
        echo '<a style="display:none;"  class="button button-primary wpt_copy_button_metabox" data-target_id="wpt_metabox_copy_content">Copy</a>';
        echo '<p style="color: #007692;font-weight:bold;display:none; padding-left: 12px;" class="wpt_metabox_copy_content"></p>';
        echo '</div>';
        ?>
<div class="wpt-tips-github">
    <p>
        <b><?php echo esc_html__( 'Tips:', 'wpt_pro' ); ?></b>
        <span>
            <?php echo esc_html__( 'If you want to be a Contributor, Go to ', 'wpt_pro' ); ?>
            <a target="_blank" href="https://github.com/codersaiful/woo-product-table"><?php echo esc_html__( 'Github Repo', 'wpt_pro' ); ?></a>.
            | 
            <?php echo esc_html__( 'Any Ideas? Please ', 'wpt_pro' ); ?>
            <a target="_blank" href="https://github.com/codersaiful/woo-product-table/discussions/new"><?php echo esc_html__( 'Send your Suggestion or Idea', 'wpt_pro' ); ?></a>
            
        </span>
    </p>
</div>
        <?php
    }
}

if( ! function_exists( 'wpt_export_import_metabox_render' ) ){
    
    function wpt_export_import_metabox_render(){
        global $post;
        $post_id = $post->ID;
//        The following code has Transferred to admin/functions.php
//        $meta = get_post_meta($post_id);
//        unset($meta['_edit_lock']);
//        unset($meta['_edit_last']);
//
//        $meta = array_map('array_filter', $meta);
//        $meta = array_filter($meta);
//
//        $serialize_meta = serialize($meta);
//        $base64_meta = base64_encode($serialize_meta);
        
        $base64_meta = wpt_get_base64_post_meta( $post_id );

        $post_title = preg_replace( '/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/',"$1", $post->post_title );
        ?>
<form class="wpt-export-import" action="" method="post">
    <div class="wpt-export-import-wrapper">
        <div class="wpt-export-area"> 
            <label for="wpt-export-textarea">Export Box</label>
            <textarea 
                id="wpt-export-textarea" 
                class="wpt-export-textarea ua-input" 
                onclick="this.focus();this.select()" 
                readonly="readonly"
                ><?php echo esc_html( $base64_meta ); ?></textarea>
        </div>
        <div class="wpt-import-area"> 
            
            <label for="wpt-import-textarea">Import Box</label>
            <textarea 
                name="wpt-import-data"
                id="wpt-import-textarea" 
                class="wpt-import-textarea ua-input" 
                ></textarea>
            <div class="wpt-export-button-wrapper">
                <button type="submit" name="wpt_import_button" class="button-primary button-primary primary button wpt-import-button">Import Table Data</button>
            </div>
        </div>
    </div>
    
    
    
    
</form>
        <?php
    }
}


if( !function_exists( 'wpt_shortcode_configuration_metabox_render' ) ){
    //Now start metabox for shortcode Generator
    function wpt_shortcode_configuration_metabox_render(){
        global $post;
        /**
         * Filter Hook was not working from theme's function file, so need this filter inside function
         */
        WPT_Product_Table::$columns_array = apply_filters( 'wpto_default_column_arr', WPT_Product_Table::$columns_array );
        WPT_Product_Table::$default_enable_columns_array = apply_filters( 'wpto_default_enable_column_arr', WPT_Product_Table::$default_enable_columns_array );
        
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
        if( ! wp_verify_nonce( $_POST['wpt_shortcode_nonce_value'], plugin_basename(__FILE__) ) ) {
            return;
        }
        
        /**
         * Importing Data Here
         * 
         * @since 2.8.7.1
         * @by Saiful
         * @date 10.5.2021
         */
        
        if( isset( $_POST['wpt-import-data'] ) && ! empty( $_POST['wpt-import-data'] ) ){
            $wpt_import_data = sanitize_text_field( $_POST['wpt-import-data'] );

            /**
             * Do something, when something importing on Import Box
             * 
             * @Hooked wpt_importing_data admin/action-hook.php 10 (top side of this file)
             * 
             * @since 2.8.7.1
             * @by Saiful Islam
             * @Date 10.5.2021
             */
            do_action( 'wpto_import_data', $wpt_import_data, $post_id );
            return;
        }

        /**
         * @Hook Filter: wpto_on_save_global_post
         * To change/Modify $_POST
         * Before Save Data on Database by update_post_meta() func
         * @since 6.1.0.5
         * @Hook_Version: 6.1.0.5
         */

        $save_tab_array = array(
            'column_array' => 'column_array',
            'column_array_tablet' => 'column_array_tablet',
            'column_array_mobile' => 'column_array_mobile',
            
            'enabled_column_array' => 'enabled_column_array',
            'enabled_column_array_tablet' => 'enabled_column_array_tablet',
            'enabled_column_array_mobile' => 'enabled_column_array_mobile',
            
            'column_settings' => 'column_settings',
            'column_settings_tablet' => 'column_settings_tablet',
            'column_settings_mobile' => 'column_settings_mobile',
            
            'basics' => 'basics',
            'table_style' => 'table_style',
            'conditions' => 'conditions',
            'mobile' => 'mobile',
            'search_n_filter' => 'search_n_filter',
            'pagination' => 'pagination',
            'config' => 'config',
        );

        $save_tab_array = apply_filters( 'wpto_save_tab_array', $save_tab_array, $post_id, $post );

        if( ! is_array( $save_tab_array ) || ( is_array( $save_tab_array ) && count( $save_tab_array ) < 1 )){
            return;
        }

        /**
         * @Hook Action: wpto_on_save_post_before_update_meta
         * To change data Just before update_post_meta() of our Product Table Form Data
         * @since 6.1.0.5
         * @Hook_Version: 6.1.0.5
         */
        add_action( 'wpto_on_save_post_before_update_meta', $post_id );
        
        /**
         * In Filter, Availabe Tabs:
         * tabs: column_array,column_array_tablet,column_array_mobile,enabled_column_array,
         * enabled_column_array_tablet,enabled_column_array_mobile,
         * column_settings,column_settings_tablet,column_settings_mobile,
         * basics,table_style,conditions,mobile,search_n_filter,pagination,config
         * 
         * @since 2.9.1
         */
        $filtar_args = array(
            'column_array' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'column_array_tablet' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'column_array_mobile' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'enabled_column_array' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'enabled_column_array_tablet' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'enabled_column_array_mobile' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'column_settings' => array(
                'filter' => FILTER_CALLBACK,
                'flags' => FILTER_REQUIRE_ARRAY,
                'options' => 'wp_kses_post'
            ),
            'column_settings_tablet' => array(
                'filter' => FILTER_CALLBACK,
                'flags' => FILTER_REQUIRE_ARRAY,
                'options' => 'wp_kses_post'
            ),
            'column_settings_mobile' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'basics' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'table_style' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'conditions' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'mobile' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'search_n_filter' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'pagination' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
            'config' => array(
                'filter' => FILTER_SANITIZE_STRING,
                'flags' => FILTER_REQUIRE_ARRAY,
            ),
        );
        
        $submitte_data = filter_input_array( INPUT_POST, $filtar_args );
        $submitte_data = array_filter( $submitte_data );
        
        foreach( $save_tab_array as $tab ){
            
            /**
             * Already Filtered using filter_input_arry/filter_var_array
             * 
             * @since 2.9.1
             */
            $tab_data = isset( $submitte_data[$tab] ) ? $submitte_data[$tab] : false; //XSS OK
            
            /**
             * Hook before save tab data
             * @Hooked: wpt_data_manipulation_on_save at admin/functions.php
             */
            $tab_data = apply_filters( 'wpto_tab_data_on_save', $tab_data, $tab, $post_id, $save_tab_array );
            
            /**
             * Hook for Individual Tab data save.
             * 
             * Only for customer use at this moment.
             */
            $tab_data = apply_filters( 'wpto_tab_data_on_save_' . $tab, $tab_data, $post_id, $save_tab_array );
            update_post_meta( $post_id, $tab, $tab_data );
        }

        /**
         * @Hook Action: wpto_on_save_post
         * To change data when Form will save.
         * @since 6.1.0.5
         * @Hook_Version: 6.1.0.5
         */
        add_action( 'wpto_on_save_post', $post_id );

    }
}
add_action( 'save_post', 'wpt_shortcode_configuration_metabox_save_meta', 10, 2 ); // 