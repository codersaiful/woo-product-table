<?php

$desc = isset( $data['short_description'] ) ? sanitize_post( $data['short_description'] ) : '';

$description_length = isset( $settings['short_description_length'] ) ? $settings['short_description_length'] : '';

if( !empty( $description_length ) ){
    $desc = substr($desc, 0, $description_length );
}

if( ! empty( $desc ) ){
    echo do_shortcode( $desc );
}
