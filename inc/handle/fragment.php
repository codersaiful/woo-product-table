<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Fragment{
    public $table_id;
    public  $cart_stats;// = ! WC()->cart->is_empty() ;

    public function run(){

        add_filter( 'woocommerce_add_to_cart_fragments',[$this, 'render'] );
        // add_filter('woocommerce_quantity_input_args',[$this,'testing']);
    }
    public function my_footer_cart(){

    }
    public function testing( $args ){
        var_dump($args);
        return $args;
    }

    /**
     * We will use this method inside 
     * woocommerce fragments, that's why, we will not 
     * arrange html margup based on tab actually
     * here wccommerce return also space.
     *
     * @return void
     */
    public function getFooterCart(){
        $this->cart_stats = ! WC()->cart->is_empty()  ? 'yes' : 'no';
        ob_start();
        ?>
<div class="wpt-new-footer-cart wpt-foooter-cart-stats-<?php echo esc_attr( $this->cart_stats ); ?>">
<div class="wpt-new-footer-cart-inside">
<?php
if ( $this->cart_stats == 'yes' ) { 
?> 
<div class="wpt-cart-contents">
    <?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?> 
    <span class="count">
        <?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'storefront' ), WC()->cart->get_cart_contents_count() ) ); ?>
    </span>
</div>
<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="wpt-view-n"><?php echo esc_html__( 'View cart', 'woocommerce' ); ?></a>
<?php }else{ ?>
<p class="wpt-product-notfound-cart"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>
<?php } ?>
</div>
</div>


        <?php 
        $output = ob_get_clean();
        return $output;
    }
    public function render( $fragments ){

        $output = $this->getFooterCart();
    $fragments['.wpt-new-footer-cart'] = $output;
    return $fragments;
    // wp_send_json( $output );
    }
}