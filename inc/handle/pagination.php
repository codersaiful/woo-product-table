<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Pagination{

    /**
     * I didn't check yet here.
     * Actually I called this method inside checking
     * 
     * Otherwise, need indivisual check on both method.
     *
     * @param Shortcode $shortcode
     * @return void
     */
    public static function render( Shortcode $shortcode ){

        // if( 'on' !== $shortcode->pagination ) return;
        ?>
        <div data-base_link="<?php echo esc_attr( $shortcode->pagination_base_url ); ?>" class='wpt_my_pagination wpt-my-pagination-<?php echo $shortcode->table_id; ?> wpt_table_pagination' data-table_id='<?php echo $shortcode->table_id; ?>'>
        <?php 
        echo self::get_paginate_links( $shortcode );
        ?>
        </div>
        <?php
    }


    /**
     * Generate Page link inside pagination's wrapper
     * It will not echo directly. It will return an String, You have to Echo.
     *
     * @param Shortcode $shortcode
     * @return void
     */
    public static function get_paginate_links( Shortcode $shortcode ){
        // if( 'on' !== $shortcode->pagination ) return;
        $args = $shortcode->args;
        $product_loop = new \WP_Query($args);

        /**
         * @Hook Filter for pagination 
         */
        $paginate_args = apply_filters('wpt_paginate_args', array(
            'base' => $shortcode->pagination_base_url,
            'format' => apply_filters( 'wpto_pagination_format', '?paged=%#%', $args ),
            'mid_size'  =>  3,
            'prev_next' =>  false,
            'current' => max( 1, $args['paged'] ),
            'total' => $product_loop->max_num_pages
        ), $shortcode);
        $paginate = paginate_links( $paginate_args );
        return $paginate;
    }
}