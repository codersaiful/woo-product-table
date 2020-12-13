<?php
/**
 * Quick View Column Default validation.
 * User able to show/hide default quick view
 * 
 * @since 2.7.8.2 
 * @Date 13.12.2020
 */
$wpt_qv_validation = apply_filters( 'wpto_quick_view_validation', true );
if( $wpt_qv_validation && ! empty( $data['id'] ) && ! empty( $config_value['quick_view_btn_text'] ) ){
    echo wp_kses_post( '<a href="#" class="button yith-wcqv-button" data-product_id="' . $data['id'] . '">' . $config_value['quick_view_btn_text'] . '</a>' );
}

/**
 * Adding any content at the bottom of Quick View Column
 * 
 * @since 2.7.8.2 
 * @Date 13.12.2020
 */
do_action( 'wpto_quick_view_bottom', $table_ID, $product, $settings, $column_settings );