<?php
if( isset( $_GET['debug'] ) ){
?>
<b>Filter for Locate File:</b>
<pre>
Filter in Code: 'wpto_template_loc_item_' . $keyword
Filter: wpto_template_loc_item_<?php echo $keyword; ?><br>
Available Args: $file, $table_ID, $product

using:
add_filter('wpto_template_loc_item_<?php echo $keyword; ?>','your_prefix_your_function');
</pre>
<?php
}
?>

<?php 

if( isset( $_GET['var_dump'] ) && !empty( $_GET['var_dump'] ) ){
    $var_dump = $_GET['var_dump'];
    $otput = isset( $$var_dump ) ? $$var_dump : 'undefined';
    var_dump($otput);
}if( isset( $_GET['var_dump'] ) && empty( $_GET['var_dump'] ) ){

}else{
    return;
}
$settings = isset( $column_settings[$keyword] ) ? $column_settings[$keyword] : false;
var_dump($keyword, $settings);

if( $in_extra_manager ){
    $wrap_info = 'Items inside TD';
}else{
    $wrap_info = 'Cell of TD';
}

?>
<code><?php echo $wrap_info; ?>::<?php echo $keyword; ?></code>
<pre>
File Not Founded.
Looking file at <?php echo $requested_file; ?><br>
For More Details: your_page_url.com?debug=wpt
</pre>
