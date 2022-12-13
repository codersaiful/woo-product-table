<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Shortcode_Base;

/**
 * All type fragment of our plguin.
 * Such as:
 * Footer Cart, product remove button and all other things will be handle from here
 * 
 * @since 3.2.5.3
 * @author Saiful Islam <codersaiful@gmail.com>
 * @class Fragment
 * 
 * No use of WOO_PRODUCT_TABLE\Inc\Shortcode;
 */
class Fragment extends Shortcode_Base{

    /**
     * Temporary propety to store Table ID,
     * If need anywhere actually.
     * 
     * Maybe, it will not be need
     *
     * @var [type]
     */
    public $table_id;

    /**
     * Temporary property to store
     * WC Cart status Empty or not
     * 
     * ***************************
     * If empty, return false, for not empty, iit will return true
     *
     * @var boolean If empty, return false, for not empty, iit will return true
     */
    public  $cart_stats;

    /**
     * Actually this will be handle from Table Setting
     * or Configure Setting Page
     * 
     * We have to handle it from Backend
     * If enable, then we will enable it.
     *
     * @var boolean
     */
    public $cart_lists = true;



    /**
     * As like contracture method,
     * it will enable our Fragment's alll Feature
     * 
     * @author Saiful Islam <codersaiful@gmail.com>
     *
     * @return void
     */
    public function run(){

        if( $this->footer_cart ){
            add_filter( 'woocommerce_add_to_cart_fragments',[$this, 'fragments'] );
        }else{
            add_filter( 'woocommerce_add_to_cart_fragments',[$this, 'fragment_floating_cart'] );
        }
        
    }


    /**
     * HANDLE ALL ADDITIONAL FRAGMENTS
     * -------------------------------
     * * Handle Footer cart fragments
     * * Table Minicart Fragment Handle
     * 
     * Specially for Footer AND Table minicart
     * 
     * 1* Floating Cart / Circle Footer Cart added Here
     * 2* Most Importang/ Our Real Floating Cart.
     * 
     * @author Saiful Islam <codersaiful@gmail.com>
     *
     * @param array $fragments
     * @return array
     */
    public function fragments( $fragments ){
        
        $output = $this->getFooterCart();
        $fragments['.wpt-new-footer-cart'] = $output;

        $float_cart = $this->getFloatingCart();
        $fragments['.wpt-footer-cart-wrapper > a'] = $float_cart;

        return $fragments;
    }
    
    public function fragment_floating_cart( $fragments ){
        $float_cart = $this->getFloatingCart();
        $fragments['.wpt-footer-cart-wrapper > a'] = $float_cart;

        return $fragments;
    }

    protected function getFloatingCart(){
        ob_start();
        ?>
        <a target="_blank" href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="wpt-floating-cart-link">
        <?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?> 
        </a>
        
        <?php
        return ob_get_clean();
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
        $template = 'footer-cart-temp-' . $this->footer_cart_template;
        $this->cart_stats = ! WC()->cart->is_empty()  ? true : false;
        $class_status = $this->cart_stats ? 'on' : 'empty';
        ob_start();
        ?>
<div class="wpt-new-footer-cart <?php echo esc_attr( $template ); ?> wpt-foooter-cart-stats-<?php echo esc_attr( $class_status ); ?>">
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
        <?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'wpt_pro' ), WC()->cart->get_cart_contents_count() ) ); ?>
    </span>
<?php if( $this->cart_stats ){ ?>
    <span title="<?php echo esc_attr__( 'Empty Cart.', 'wpt_pro' ); ?>" class="wpt_empty_cart_btn">
        <i class="wpt-trash-empty"></i>
    </span>
<?php } ?>
</div>
<?php
    $view_cart_text = __('View Cart', 'wpt_pro');
    $view_cart_text = apply_filters('wpt_view_cart_text', $view_cart_text, $this->table_id );
    $view_cart_target = '_blank';
    $view_cart_target =  apply_filters('wpt_view_cart_target', $view_cart_target);
?>
<a target="<?= $view_cart_target ?>" href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="wpt-view-n"><?php echo esc_html( $view_cart_text ); ?> <i class="wpt-bag"></i></a>

</div>
</div>
        <?php 
        $output = ob_get_clean();
        return $output;
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