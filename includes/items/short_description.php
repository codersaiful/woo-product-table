<?php

$desc = isset( $data['short_description'] ) ? sanitize_post( $data['short_description'] ) : '';
if( ! empty( $desc ) ){
    echo do_shortcode( $desc );
}
