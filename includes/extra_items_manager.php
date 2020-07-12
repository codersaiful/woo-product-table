<?php
$in_extra_manager = true;
$extra_items = $column_settings[$keyword]['items'];
if( !is_array( $extra_items ) || ( is_array( $extra_items ) && count( $extra_items ) < 1 ) ){
    return;
}

foreach( $extra_items as $keyword ){
    
    /**
     * New Feature, Mainly for detect File Name. 
     * Such: for custom_field type, Scrip will load custom_field.php file inside Items Directory
     * Default value: default or empty
     */
   $type = isset( $column_settings[$keyword]['type'] ) && !empty( $column_settings[$keyword]['type'] ) ? $column_settings[$keyword]['type'] : 'default';
   
   /**
    * Type: It's a Type of column, Normally all type default, but can be different. such: custom_file, taxonomy, acf etc
    * @Hook Filter: wpto_column_type
    * When sole same type colum will open from one file, than use Type.
    * Such: For custom field, use one file named: custom_field.php
    * Same for Taxonomy.\
    * Like this, we can add new type: acf, when file will open from acf.php from items
    */
   $type = apply_filters( 'wpto_column_type', $type, $keyword, $table_ID, $product, $column_settings ); //@Filter Added 
   
   /**
     * @Hook Filter: wpto_template_folder
     * Items Template folder location for Each Keyword,
     * such: product_title, product_id, content,shortcode etc
     * 
     * Abble to change Template Root Directory Based on $keyword, $column_type, $table_ID, Global $product
     * 
     */
   $items_directory_1 = apply_filters('wpto_template_folder', $items_directory,$keyword, $type, $table_ID, $product );
   
   /**
    * @Hook Filter: wpto_item_dir_type_($type) change directory based on Column type
    * Items folder Directory based on Colum Type.
    * Such: For all default type column, request file available in includes/items folder
    * but for other type, such: acf, custom_field,taxonomy, we can set another Directory location from Addons or fro Pro version
    */
   $items_directory_2 = apply_filters('wpto_item_dir_type_' . $type, $items_directory_1, $table_ID, $product, $column_settings ); //@Filter Added 
   
   $file_name = $type !== 'default' ? $type : $keyword;
    $file = $items_directory_2 . $file_name . '.php';
    $file = apply_filters( 'wpto_template_loc', $file, $keyword, $type, $table_ID, $product, $file_name, $column_settings ); //@Filter Added 
    $file = apply_filters( 'wpto_template_loc_type_' . $type, $file, $keyword, $table_ID, $product, $file_name, $column_settings ); //@Filter Added
    $file = $requested_file = apply_filters( 'wpto_template_loc_item_' . $keyword, $file,$type, $product, $table_ID, $file_name );
    if( !file_exists( $file ) ){
        $file = $items_permanent_dir . 'default.php';
        $file = apply_filters( 'wpto_defult_file_loc', $file, $keyword, $product, $table_ID );
    }
    $tag = isset( $column_settings[$keyword]['tag'] ) && !empty( $column_settings[$keyword]['tag'] ) ? $column_settings[$keyword]['tag'] : 'div';
    echo $tag ? "<$tag "
            . "class='item_inside_cell wpt_" . esc_attr( $keyword ) . "' "
            . "data-keyword='" . esc_attr( $keyword ) . "' "
            . "data-sku='" . esc_attr( $product->get_sku() ) . "' "
            . ">" : '';
    include $file;
    echo $tag ? "</$tag>" : '';
}
