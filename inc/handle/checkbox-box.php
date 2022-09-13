<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Checkbox_Box{
    public static function render( Shortcode $shortcode, string $position = 'header' ){
        $text = $shortcode->add_to_cart_text;
        $selected_text = $shortcode->basics['add_to_cart_selected_text'] ?? '';
        $check_uncheck_text = $shortcode->basics['check_uncheck_text'] ?? '';
        ?>
        <div class='all_check_header_footer all_check_<?php echo esc_attr( $position ); ?> check_<?php echo esc_attr( $position ); ?>_<?php echo esc_attr( $shortcode->table_id ); ?>'>

        <span>
            <input data-type='universal_checkbox' 
            data-temp_number='<?php echo esc_attr( $shortcode->table_id ); ?>' 
            class='wpt_check_universal wpt_check_universal_header' 
            id='wpt_check_uncheck_button_<?php echo esc_attr( $shortcode->table_id ); ?>' type='checkbox'>
            <label for='wpt_check_uncheck_button_<?php echo esc_attr( $shortcode->table_id ); ?>'>
            <?php echo wp_kses_post( $check_uncheck_text ) ?>
            </lable>
        </span>
            <a data-add_to_cart='<?php echo esc_attr( $text ); ?>' 
            data-temp_number='<?php echo esc_attr( $shortcode->table_id ); ?>' 
            class='button add_to_cart_all_selected add2c_selected'>
                <?php echo wp_kses_post( $selected_text ) ?>
            </a>
        </div>
        <?php
    }
}