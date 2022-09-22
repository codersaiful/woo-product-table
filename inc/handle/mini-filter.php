<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Mini_Filter{
    public static $keywords;
    public static function render( Shortcode $shortcode ){
        return;
        self::$keywords = $shortcode->search_n_filter['filter'] ?? [];
        var_dump( $shortcode->table_id,self::$keywords );
        ?>
        <div class="wpt-mini-filter-wrapper">
            <div class="wpt-mini-filter">
                <?php echo wpt_filter_box( $shortcode->table_id, self::$keywords ); ?>
            </div>
        </div>
        <?php 
    }
}