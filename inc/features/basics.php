<?php 
namespace WOO_PRODUCT_TABLE\Inc\Features;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Shortcode_Base;

/**
 * Most of the basic option for Fronend actually
 * will call here. 
 * Specially for Frontend
 * 
 * @author Saiful Islam <codersaiful@gmail.com>
 * @package WooProductTable
 */
class Basics extends Shortcode_Base{
    
    public $_config;

    public $empty_cart_text;

    public function run(){
        $this->filter('body_class');
        $this->action('wpt_bottom', 1, 10, 'edit_button');
        $this->action('wpt_bottom', 1, 10, 'add_new_button');
        $this->action('woocommerce_widget_shopping_cart_buttons', 1, 10, 'empty_cart_button');
    }

    
    public function body_class( $class ){
        if( $this->get_is_table() ){
            $class[] = 'wpt_table_body';
            // $class[] = 'woo-product-table';
            $class[] = 'wpt-body-' . $this->shortcde_text;
        }

        return $class;
    }

    public function edit_button( Shortcode $shortcode ){
        if( $shortcode->fake_property ) return;
        if( ! current_user_can( WPT_CAPABILITY ) ) return;

        ?>
        <div title="<?php echo esc_attr( 'ONLY FOR ADMIN USER', 'woo-product-table' ); ?>" class="wpt_edit_table">
            <a href="<?php echo esc_attr( admin_url( 'post.php?post=' . $shortcode->table_id . '&action=edit&classic-editor' ) ); ?>" 
                            target="_blank"
                            title="<?php echo esc_attr( '[ONLY FOR ADMIN USER]Edit your table. It will open on new tab.', 'woo-product-table' ); ?>"
                            >
            <?php echo esc_html__( 'Edit Table - ', 'woo-product-table' ); ?>
            <?php echo esc_html( get_the_title( $shortcode->table_id ) ); ?>
            </a>   
        </div>

        <?php
    }
    public function add_new_button( Shortcode $shortcode ){
        if( ! $shortcode->fake_property ) return;
        if( ! current_user_can( WPT_CAPABILITY ) ) return;

        ?>
        <div title="<?php echo esc_attr( 'ONLY FOR ADMIN USER', 'woo-product-table' ); ?>" class="wpt_edit_table">
            <a href="<?php echo esc_attr( admin_url( 'post-new.php?post_type=wpt_product_table' ) ); ?>" 
                            target="_blank"
                            title="<?php echo esc_attr( '[ONLY FOR ADMIN USER] You have to create new table, If not.', 'woo-product-table' ); ?>"
                            >
            <?php echo esc_html__( 'Add a Product Table', 'woo-product-table' ); ?>

            </a>   
            <div class="wpt-if-already">
                To get More feature, Please create a table by following button. <a href="https://wooproducttable.com/docs/doc/gating-start/how-to-create-woocommerce-product-table/" target="_blank">How to create a Product Table</a>
            </div>
        </div>

        <?php
    }

    public function empty_cart_button(){
        
        $this->empty_cart_text = $this->base_config['empty_cart_text'] ?? '';
        ?>
        <a title="<?php echo esc_attr__( 'Empty Cart', 'woo-product-table' ); ?>" class="wpt_empty_cart_btn button"><i class="wpt-trash-empty"></i><?php echo esc_html__( $this->empty_cart_text, 'woo-product-table' ); ?></a>
        <?php
    }
}