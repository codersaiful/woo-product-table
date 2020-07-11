<?php 

//var_dump($product->get_the_title());
if( !$current_tr ){
    return;
}


$tr_class_arr = array(
    'wpt_row',
    'tr_post_id_' . $POST_ID,
    'tr_product_id_' . $product_id,
    'tr_id_' . $product_id,
    'product_type_' . $product_type,
    $product_type,
    'col-' . $rowtype,
);
$tr_class = implode(" ", $tr_class_arr);

?>
<tr class="<?php echo esc_attr( $tr_class );?>" 
    id="product_id_<?php echo esc_attr( $product_id ); ?>" 
    data-product_id="<?php echo esc_attr( $product_id ); ?>" 
    data-post_id="<?php echo esc_attr( $POST_ID ); ?>" 
    title="<?php echo esc_attr( $tr_title ); ?>"
    >
    <?php
    foreach( $current_tr as $tr_key => $row ){
    $td_class = isset( $row['wrapper']['class'] ) ? $row['wrapper']['class'] : 'wpt_per_td';
    $td_class_arr = array(
        'wpt_td',
        'column_' . $POST_ID . '_' . $tr_key,
        'td_pr_' . $product_id . '_col_' . $tr_key,
        'collumn_no_' . $tr_key,
        $td_class,
        $rowtype . '_td',
        'td-' . $rowtype,
    );
    $td_class = implode(" ", $td_class_arr);
    

    ?>
    <td data-product_id="<?php echo esc_attr( $product_id ); ?>" 
        data-post_id="<?php echo esc_attr( $POST_ID ); ?>" 
        colspan="<?php echo esc_attr( $collspan ); ?>" 
        class="<?php echo esc_attr( $td_class );?>" 
        data-col_no='<?php echo esc_attr( $tr_key ); ?>'
        id="<?php echo esc_attr( 'td_pr_' . $product_id . '_col_' . $tr_key ); ?>" 
        >
        <?php
        $items = isset( $row['items'] ) ? $row['items'] : false;
        if( is_array( $items ) ){
            foreach( $items as $item_keyword => $item ){
                
                //Item Manager, where from items file will handle
                include $WPT_DIR_LINK . '/includes/item-manager.php';
                
            }
        }
        ?>
    </td>
    <?php
    }
    ?>
</tr>