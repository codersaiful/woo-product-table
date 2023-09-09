<div class="tag_or_div">
    <div class="welcome-to-all">
    <?php
        /**
         * Checking if is_sold_individually
         * then wc will not show qty box
         * that's why, I return default template
         * 
         * rest will handle from WooCommerce
         * 
         * @since 1.0.8
         */
        
        if( $product->is_sold_individually() ) return false;

        $t_args = array( 
            'input_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_stock_quantity(), $product ),
            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
            'step'        => apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
        );

        /**
         * if "Stock management" is checked, backorders is allowed and quantity is one then quantity type is checnge to 'hidden'. 
         * Therefor quantity box is not showing.
         * with this hook we are changing back to 'number'
         */
        add_filter('woocommerce_quantity_input_type', function($type){
            $type = 'number';
            return $type;
        });

        woocommerce_quantity_input( $t_args , $product, true );
        ?>
    </div>
</div>
