<?php

if( 'variable' !== $product_type ) return;
wp_enqueue_script( 'wc-add-to-cart-variation' );
global $product;
$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
?>

<form class="variations_form cart" action="" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
        <p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
<?php else : ?>
        
        <div class="wpt_varition_section variations" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" data-temp_number="<?php echo esc_attr( $temp_number ); ?>">
        <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                
                <?php
                        wc_dropdown_variation_attribute_options(
                                array(
                                        'options'   => $options,
                                        'attribute' => $attribute_name,
                                        'product'   => $product,
                                        'show_option_none' => wc_attribute_label( $attribute_name ), // WPCS: XSS ok.
                                )
                        );
                        echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
                ?>
                
        <?php endforeach; ?>
        </div>
<?php endif; ?>
</form>
<?php
do_action( 'wpt_action_variation', $product ); //Sepcially for Min Max Plugin