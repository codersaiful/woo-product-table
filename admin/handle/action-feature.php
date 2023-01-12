<?php
namespace WOO_PRODUCT_TABLE\Admin\Handle;

use WOO_PRODUCT_TABLE\Core\Base;

/**
 * Adding new Feature for Admin Action Column
 * 
 * 
 */
class Action_Feature extends Base 
{
    public function run()
    {
        //Any one can use
        // $this->action('wpto_column_setting_form_action',2, 10, 'third_party_switch' );
        add_action( 'wpto_column_setting_form_action', [$this, 'third_party_switch'], 10, 5 );

    }

    public function third_party_switch( $_device_name, $column_settings, $columns_array, $updated_columns_array, $post )
    {
        $post_id = $post->ID;
        $conditions = get_post_meta($post_id,'conditions',true);
        $table_type = $conditions['table_type'] ?? '';
        
        $third_party_plugin =  $column_settings['action']['third_party_plugin'] ?? '';
        if( empty($third_party_plugin) && $table_type === 'advance_table'){
            $third_party_plugin = 'advance_table';
        }

        $third_party_plugin_checkbox = $third_party_plugin == 'advance_table' ? 'checked="checked"' : '';

        ?>
        <label 
        title="<?php echo esc_attr__( 'Actually this will override the same option from Option tab.', 'woo-product-table' ); ?>"
        for="third_party_plugin<?php echo esc_attr( $_device_name ); ?>">
            <input id="third_party_plugin<?php echo esc_attr( $_device_name ); ?>" 
             
            name="column_settings<?php echo esc_attr( $_device_name ); ?>[action][third_party_plugin]" 
            id="third_party_plugin" 
            class="third_party_plugin" 
            value="advance_table"
            type="checkbox" <?php echo esc_attr( $third_party_plugin_checkbox ); ?>> 
            
            <?php echo esc_html__( 'Third Party Plugin Supporting', 'woo-product-table' ); ?>
        </label>
        <?php
        wpt_help_icon_render( __('If any feature do not work for Add To Cart Button, Enable this feature.', 'woo-product-table') );
        ?>
        <?php 
    }
}