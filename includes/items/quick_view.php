<?php 

$product_id      = $product->get_id();
$qv_button_label = get_option('qv_button_label', 'Qiuck View') ;
?>
<button type="button" class="caqv-open-modal" 
data-id="<?php echo esc_attr($product_id); ?>" >
    <i class="btn-icon <?php echo esc_attr(get_option('cawqv_general_section', 'cawqv-icon-search')); ?>"></i>
    <span><?php echo esc_html($qv_button_label, 'cawqv') ?> </span>
</button>