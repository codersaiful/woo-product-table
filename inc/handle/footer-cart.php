<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Footer_Cart{

    public function setFrag(){
        add_action( 'woocommerce_add_to_cart_fragments',[$this, 'my_footer_cart'] );
    }
    public function my_footer_cart(){

    }
    public static function render_footer_cart(){
        ?>
        <div class="saiful-footer-cart">
    <?php if ( ! WC()->cart->is_empty() ) { ?>

	
<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'storefront' ); ?>">
        <?php /* translators: %d: number of items in cart */ ?>
        <?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?> <span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'storefront' ), WC()->cart->get_cart_contents_count() ) ); ?></span>
</a>

<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button wc-forward"><?php echo esc_html__( 'View cart', 'woocommerce' ); ?></a>

<?php }else{ ?>
<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>
<?php } ?>
    </div> <!-- ./saiful-footer-cart -->
        <?php 
    }
}