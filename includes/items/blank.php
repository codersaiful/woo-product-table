<?php
/**
 * Blank Type Column
 */

/**
 * @Hook Actin: wpto_blank_type_column
 * Add content to Blank Type Column, Remember, It's Not Blank Column, It's Blank Type new Added Column
 * Able to add any content to All Blank Type Column Data
 */
do_action( 'wpto_blank_type_column', $settings, $product, $keyword, $table_ID, $column_settings );

/**
 * @Hook Actin: wpto_blank_type_column_($keyword)
 * Add content to Blank Type Column, Remember, It's Not Blank Column, It's Blank Type new Added Column
 * Able to add any content to Specific Column based on 
 */
do_action( 'wpto_blank_type_column_' . $keyword, $settings, $product, $table_ID, $column_settings );
//Nothing for Display