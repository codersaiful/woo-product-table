<?php 
$product_id      = $product->get_id();
$qv_button_label = get_option( 'qv_button_label', __( 'Qiuck View', 'woo-product-table' ) );
$qv_button_label = __( $qv_button_label, 'woo-product-table' );

$class_name = class_exists('CAWQV_PLUGIN_LITE') ? 'caqv-open-modal' : 'caqv-open-modal-notfound';
?>
<button type="button" class="<?php echo esc_attr( $class_name ); ?>" 
data-id="<?php echo esc_attr($product_id); ?>" >
    <i class="btn-icon <?php echo esc_attr(get_option('cawqv_general_section', 'cawqv-icon-search')); ?>"></i>
    <span><?php echo esc_html($qv_button_label, 'woo-product-table') ?> </span>
</button>