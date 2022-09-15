<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;
use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Element{
    public static function loadMore( Shortcode $shortcode ){
        $config = $shortcode->_config;
        $text_btn = $config['load_more_text'] ?? '';
        $text_loading = $config['loading_more_text'] ?? '';
        ?>
    <div id="wpt_load_more_wrapper_'<?php echo esc_attr( $shortcode->table_id ); ?>" 
    class="wpt_load_more_wrapper">

        <button data-temp_number="<?php echo esc_attr( $shortcode->table_id ); ?>" 
        data-load_type="current_page" data-type="load_more" 
        class="button wpt_load_more">
            <?php echo esc_html( $text_btn ); ?>
        </button>
    </div>
        <?php
    }
}