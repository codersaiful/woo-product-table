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
    
    public function run(){
        $this->filter('body_class');
        $this->action('wpt_bottom', 1, 10, 'edit_button');
    }
    public function body_class( $class ){
        global $post;
        
        if( isset($post->post_content) && has_shortcode( $post->post_content, $this->shortcde_text ) ) {
            $class[] = 'wpt_table_body';
            $class[] = 'woocommerce';
            $class[] = 'wpt-body-' . $this->shortcde_text;
        }
        return $class;
    }

    public function edit_button( Shortcode $shortcode ){

        if( !current_user_can( WPT_CAPABILITY ) ) return null;

        ?>
        <div class="wpt_edit_table">
            <a href="<?php echo esc_attr( admin_url( 'post.php?post=' . $shortcode->table_id . '&action=edit&classic-editor' ) ); ?>" 
                            target="_blank"
                            title="<?php echo esc_attr( 'Edit your table. It will open on new tab.', 'wpt_pro' ); ?>"
                            >
            <?php echo esc_html__( 'Edit Table - ', 'wpt_pro' ); ?>
            <?php echo esc_html( get_the_title( $shortcode->table_id ) ); ?>
            </a>   
        </div>

        <?php
    }
}