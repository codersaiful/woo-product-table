<?php
/**
 * Blank Type Column
 */

/**
 * @Hook Actin: wpto_blank_type_column
 * Add content to Blank Type Column, Remember, It's Not Blank Column, It's Blank Type new Added Column
 * Able to add any content to All Blank Type Column Data
 */
do_action( 'wpto_blank_type_column', $keyword, $table_ID, $product, $column_settings );

/**
 * @Hook Actin: wpto_blank_type_column_($keyword)
 * Add content to Blank Type Column, Remember, It's Not Blank Column, It's Blank Type new Added Column
 * Able to add any content to Specific Column based on 
 */
do_action( 'wpto_blank_type_column_' . $keyword, $table_ID, $product, $column_settings );
//Nothing for Display