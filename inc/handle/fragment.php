<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Fragment{
    public $table_id;
    public  $cart_stats;// = ! WC()->cart->is_empty() ;
    public $cart_lists = true;
    /**
     * There are lot's of template ob background available for
     * footer template. If set no template,
     * there will apply table template wise color
     * otherwise, if set any template, then it will show
     * background color based on template
     * 
     * PLAN:
     * --------
     * I will set color at dashboard
     * and it will come from setting
     * and I will set anywhere. not planed yet
     *
     * @var string
     */
    public $cart_template = 'footer-cart-temp-none';// = 'footer-cart-temp-1';

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
        $this->cart_stats = ! WC()->cart->is_empty()  ? true : false;
        ob_start();
        ?>
<div class="wpt-new-footer-cart <?php echo esc_attr( $this->cart_template ); ?> wpt-foooter-cart-stats-<?php echo esc_attr( $this->cart_stats ); ?>">
<?php
if( $this->cart_lists && $this->cart_stats ){
    $this->render_cart_list();
    ?>
    <span class="wpt-fcart-coll-expand"><i class="wpt-dot-3"></i></span>
    <?php
}
?>
<div class="wpt-new-footer-cart-inside">

<div class="wpt-cart-contents">
    <?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?> 
    <span class="count">
        <?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'wpt-pro' ), WC()->cart->get_cart_contents_count() ) ); ?>
    </span>
<?php if( $this->cart_stats ){ ?>
    <span title="<?php echo esc_attr__( 'Empty Cart.', 'wpt-pro' ); ?>" class="wpt_empty_cart_btn">
        <i class="wpt-trash-empty"></i>
    </span>
<?php } ?>
    

</div>
<a target="_blank" href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="wpt-view-n"><?php echo esc_html__( 'View cart', 'wpt-pro' ); ?> <i class="wpt-bag"></i></a>

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


    public function render_cart_list(){
        ?>
        <div class="wpt-lister">
            <div class="lister-ins">
                <ul>
            <?php
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                    $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                    $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                    
                    // var_dump($product_name);
                ?>
                <li>
                <i data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>" class="wpt-cart-remove wpt-trash-empty"></i>
                    <?php 
                    // echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					// 	'woocommerce_cart_item_remove_link',
					// 	sprintf(
					// 		'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
					// 		esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
					// 		esc_attr__( 'Remove this item', 'woocommerce' ),
					// 		esc_attr( $product_id ),
					// 		esc_attr( $cart_item_key ),
					// 		esc_attr( $_product->get_sku() )
					// 	),
					// 	$cart_item_key
					// );
                    echo wp_kses_post( $product_name );
                    echo wc_get_formatted_cart_item_data( $cart_item );
                    echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key );
                     ?>
                </li>
                <?php 
                }

            }
            ?>
                </ul>
            </div>
            
        </div>

        
        <?php 
    }
}