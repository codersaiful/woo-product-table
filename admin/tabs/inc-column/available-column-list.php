<?php 
$columns_array = apply_filters( 'wpto_final_column_arr', $columns_array );
$premium_column = [];

if( ! wpt_is_pro() ){
    $premium_column = [
        'category' => __('Category', 'woo-product-table'),
        'stock' => __('Stock', 'woo-product-table'),
        'total' => __('Total', 'woo-product-table'),
        'sku' => __('SKU', 'woo-product-table'),
        'message' => __('Short Message', 'woo-product-table'),
        'short_description' => __('Short Description', 'woo-product-table'),
        'shortcode' => __('Shortcode', 'woo-product-table'),
        'content' => __('Content', 'woo-product-table'),
        'audio_player' => __('Audio', 'woo-product-table'),
        'quick_qty' => __('Quick Qty', 'woo-product-table'), //Added at V7.0.9.0
        'variation_name' => __('Variation Name', 'woo-product-table'), //Added at V8.0.3.1
        'viewed' => __('Viewed', 'woo-product-table'), //Added at V8.0.1.0
        'toggle_description' => __('Toggle Description', 'woo-product-table'),
    ];
    $available_column_array = array_merge( $columns_array, $premium_column );
}else{
    $available_column_array = $columns_array;
}

$enabledd_column_array = is_array($meta_enable_column_array) && ! empty($meta_enable_column_array) ? $meta_enable_column_array : $default_enable_array;

asort($available_column_array);
$available_column_array = array_merge( $enabledd_column_array, $available_column_array );
$extra_character = [
    'action' => 'add to cart, added, cart, checkout, buy now, purchase, order',
    'audio_player' => 'audio, mp3, ogg, wav, music, song',
    'quick_qty' => 'quantity, amount, count',
    'variation_name' => 'variation, type, model',
    'viewed' => 'view, seen, observed, watched',
    'category' => 'category, categories, product category',
    'toggle_description' => 'toggle, show, hide, description, details',
    'stock' => 'stock, availability, in stock, out of stock, backorder, pre-order',
    'total' => 'total, total sales, sold, sold out',
    'sku' => 'sku, stock keeping unit, product code',
    'message' => 'message, note, comment',
    'short_description' => 'short description, product details, overview',
    'quantity' => 'quantity, amount, count, qty, minimum, maximum, min, max',
];
?>
<!-- Enable Active Column -->
<div class="add_switch_col_wrapper">
    <div class="section ultraaddons-panel add_new_column add_new_column_main_wrapper" data-device="<?php echo esc_attr( $_device_name ); ?>">

        <div class="section-header">
            <button id="wpt-add-preset-column" class="wpt-btn wpt-btn-small wpt-has-icon wpt-add-preset-column">
                <span><i class="wpt-plus"></i></span>
                <strong class="form-submit-text">Preset Column</strong>
            </button>
            <button id="wpt-add-new-custom-column-btn" class="wpt-btn wpt-btn-small wpt-has-icon wpt-add-new-custom-column-btn">
                <span><i class="wpt-plus-circle"></i></span>
                <strong class="form-submit-text">Custom Column</strong>
            </button>
            <div id="wpt-dropdown-container" class="wpt-dropdown-container" style="display:none;">
                <div class="wpt-dropdown-container-insider">
                    <input type="text" id="wpt-search" placeholder="Search column..." class="wpt-column-search-box" />
                    <ul id="wpt-dropdown-list" class="wpt-dropdown-list">
                <?php 

                foreach( $available_column_array as $keyword => $title ){ 

                    $updated_title = isset( $updated_columns_array[$keyword] ) ? $updated_columns_array[$keyword] : $title;

                    $enabled_class = '';
                    if( in_array( $keyword, array_keys( $enabledd_column_array ) ) ){
                        $enabled_class = 'item-enabled';
                    }

                    //eta specially pro badge dekhanor jonno ebong eta js er maddhome off kore dite hobe, jodi disabled thake
                    $premium = in_array( $keyword, array_keys( $premium_column ) ) ? 'premium' : '';
                    
                ?>
                <li class="switch-enable-item switch-enable-item-<?php echo esc_attr( $keyword . ' ' . $enabled_class . ' ' . $premium ); ?>" 
                    data-character ="<?php echo esc_attr( $extra_character[$keyword] ?? '' ); ?>"
                    title="<?php echo esc_html( "key: $keyword & title: $updated_title" ); ?>"
                    data-column_keyword="<?php echo esc_attr( $keyword ); ?>">
                        <?php echo esc_html( $updated_title ); ?><i>[<?php echo esc_html( $keyword ); ?>]</i>
                </li>
                <?php }

                ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
