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

        /**
         * Pagination's this part/method, only need when pagination will number.
         * and in our plugin, pagination value 'on' means number. for other,
         * value will be different. like: load_more, infinite_scroll etc.
         */

         //At this moment, I just disable it. but I think, I can enable it without any issue. 
         //Actually I have to check.
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

        global $wp_query;
        // var_dump($wp_query->query);
        // var_dump($wp_query->query_vars);

        $total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
        $current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
        $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
        $format  = isset( $format ) ? $format : '';

        // var_dump($shortcode->pagination_base_url,$total,$current,$base);

        if ( $total <= 1 ) {
            return;
        }
        $args = $shortcode->args;
        return paginate_links(
            apply_filters(
                'woocommerce_pagination_args',
                array( // WPCS: XSS ok.
                    'base'      => $base,//$shortcode->pagination_base_url,
                    'format'    => '?paged=%#%',//apply_filters( 'wpto_pagination_format', '?paged=%#%', $args ),
                    'add_args'  => false,
                    'current'   => max( 1, $current ),
                    'total'     => $total,
                    'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
                    'next_text' => is_rtl() ? '&larr;' : '&rarr;',
                    // 'type'      => 'list',
                    'end_size'  => 3,
                    'mid_size'  => 3,
                )
            )
        );
        return;

        /**
         * Pagination's this part/method, only need when pagination will number.
         * and in our plugin, pagination value 'on' means number. for other,
         * value will be different. like: load_more, infinite_scroll etc.
         */

        // if( 'on' !== $shortcode->pagination ) return;
        $args = $shortcode->args;
        echo 'HELLO';
        /**
         * @Hook Filter (wpt_paginate_args) for pagination 
         * as a param, I added args
         * Because no need more or full object here.
         * If need, we able to add or assign
         */
        $paginate_args = apply_filters('wpt_paginate_args', array(
            'base' => $shortcode->pagination_base_url,
            'format' => apply_filters( 'wpto_pagination_format', '?paged=%#%', $args ),
            'mid_size'  =>  3,
            'prev_next' =>  false, //We can enable next prev but before enable, I have to work more in js. because, we taken page number from html of number
            'current' => max( 1, $args['paged'] ),
            'total' => $shortcode->max_num_pages,
        ), $args);
        $paginate = paginate_links( $paginate_args );
        return $paginate;
    }
}