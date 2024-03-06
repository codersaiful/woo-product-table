<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Checkbox_Box{
    
    public static function render( Shortcode $shortcode, string $position = 'header' ){
        
        // $text = $shortcode->add_to_cart_text ?? false;
        $selected_text = $shortcode->basics['add_to_cart_selected_text'] ?? false;
        $check_uncheck_text = $shortcode->basics['check_uncheck_text'] ?? false;
        if( $shortcode->wpml_bool ){
            $lang = '_'. $shortcode->wpml_lang;
            $selected_text = $shortcode->basics['add_to_cart_selected_text' . $lang] ?? $selected_text;
            $check_uncheck_text = $shortcode->basics['check_uncheck_text' . $lang] ?? $check_uncheck_text;
        }
        
        // $text = ! empty( $text ) ? __( $text, 'woo-product-table' ) : __( 'Add to cart', 'woo-product-table' );
        $selected_text = ! empty( $selected_text ) ? __( $selected_text, 'woo-product-table' ) : __( 'Add to Cart (Selected)','woo-product-table' );
        $check_uncheck_text = ! empty( $check_uncheck_text ) ? __( $check_uncheck_text, 'woo-product-table' ) : __( 'Select All','woo-product-table' );

        /**
         * Some site can be slow, then we will
         * use filter hook 'wpt_multi_cart_faster'
         * for adding fast in cart but without checkout all other
         * 
         * Just doing it faster.
         */
        $faster_carting = apply_filters( 'wpt_multi_cart_faster', '', $shortcode->table_id );
        $faster_carting = is_string( $faster_carting ) && ! empty( $faster_carting ) ? $faster_carting : '';
        ?>
        <div class='all_check_header_footer all_check_<?php echo esc_attr( $position ); ?> check_<?php echo esc_attr( $position ); ?>_<?php echo esc_attr( $shortcode->table_id ); ?>'>

        <span>
            <?php if( 'header' == $position ){ ?>
            <input data-type='universal_checkbox' 
            data-temp_number='<?php echo esc_attr( $shortcode->table_id ); ?>' 
            class='wpt_check_universal wpt_check_universal_header' 
            id='wpt_check_uncheck_button_<?php echo esc_attr( $shortcode->table_id ); ?>' type='checkbox'>
            <label for='wpt_check_uncheck_button_<?php echo esc_attr( $shortcode->table_id ); ?>'>
            <?php echo wp_kses_post( $check_uncheck_text ) ?>
            </lable>
            <?php } ?>
        </span>
            <?php
            //This bellow line was in a tag as attr
            //data-add_to_cart=echo esc_attr( $text ); 
            ?>
            <a
            data-temp_number='<?php echo esc_attr( $shortcode->table_id ); ?>' 
            class='button add_to_cart_all_selected add2c_selected'>
                <?php echo wp_kses_post( $selected_text ) ?>
            </a>
        </div>
        <?php
    }
}