<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Pagination{
    public static function render( Shortcode $shortcode ){
        
        ?>
        <div class='wpt_table_pagination' data-temp_number='<?php echo $shortcode->table_id; ?>'>
        <?php 
        echo self::paginate_links( $shortcode );
        ?>
        </div>
        
        <?php
        
    }

    public static function paginate_links( Shortcode $shortcode ){
        $args = $shortcode->args;
        $product_loop = new \WP_Query($args);
        $big = 99999999;
        $paginate = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => apply_filters( 'wpto_pagination_format', '?paged=%#%', $args ),
            'mid_size'  =>  3,
            'prev_next' =>  false,
            'current' => max( 1, $args['paged'] ),
            'total' => $product_loop->max_num_pages
        ));
        return $paginate;
    }
}