<?php
/**
 * File for Managing Item of Each element.
 * We have used it inside a foreach
 * included  at includes/table-row.php
 */

$tag = isset( $item['tag'] ) && !empty( $item['tag'] ) ? $item['tag'] : 'div';
$item_default = 'pre_defined_item'; //Only for Class when Available and Default for not available

//For using inside Item Template
$settings = isset( $item['settings'] ) && !empty( $item['settings'] ) ? $item['settings'] : false;

$validation = apply_filters( "wpt_" . $item_keyword . "_validation", true, $product, $POST_ID );

$template_directory = apply_filters('wpt_template_directory', $WPT_DIR_LINK . '/item-template/', $item_keyword, $product, $POST_ID );

$file = $template_directory . $item_keyword . '.php';

/**
 * Filter For Common Template Location
 * User able to change Any Template Location
 */
$file = apply_filters( 'wpt_' . $item_keyword . '_template_file', $file, $item_keyword, $product, $POST_ID );

if( !is_file( $file ) ){
    $item_default = 'default_item'; //Only for Class when Available and Default for not available
    $file = $template_directory . 'default.php';

    /**
     * Template Location For Default Template, I mean, When a column keyword will not found a file
     */
    $file = apply_filters( 'wpt_' . $item_keyword . '_template_file', $file, $item_keyword, $product, $POST_ID );
}

if( is_bool( $validation ) && $validation){

    $item_id = isset( $item['id'] ) ? $item['id'] : 'item_' . $item_keyword . '_pr_' . $product_id;
    $item_class = isset( $item['class'] ) ? $item['class'] : 'item_' . $item_keyword;
    $itm_class_arr = array(
        'item',     
        'collumn_no_' . $tr_key,
        'item_' . $item_keyword,
        'item_' . $item_keyword . '_' . $POST_ID,
        'item_' . $tr_key,
        'item_' . $POST_ID,
        'item_pr_' . $product_id . '_' . $item_keyword,
        'item_' . $product_id,
        $item_default,
        $item_class,
    );

    /**
     * Class Filter For EAch Item
     */
    $itm_class_arr = apply_filters( 'wpt_' . $item_keyword . '_classes', $itm_class_arr, $product, $POST_ID );

    $item_class = implode(" ", $itm_class_arr);
?>
<!-- Item Start -->
<<?php echo $tag; ?> 
data-product_id="<?php echo esc_attr( $product_id ); ?>" 
data-post_id="<?php echo esc_attr( $POST_ID ); ?>" 
class="<?php echo esc_attr( $item_class ); ?>" 
data-col_no='<?php echo esc_attr( $tr_key ); ?>'
id="item_<?php echo esc_attr( $item_id ); ?>" >
<?php
    //Action for Add content After Selected Keyword
    do_action( 'wpt_' . $item_keyword . '_before', $product, $POST_ID );

    if( is_file( $file ) ){
        include $file;
    }else{
        $file_not_founded_msg = esc_html( sprintf( 'Your desired file(%s) is not founded!', $file ), 'wpt' );
        echo apply_filters( 'wpt_file_not_founded_msg', $file_not_founded_msg, $POST_ID );
    }


    //Action for Add content After Selected Keyword
    do_action( 'wpt_' . $item_keyword . '_after', $product, $POST_ID );
?>
</<?php echo $tag; ?>>
<!-- Item End -->
<?php
}
                