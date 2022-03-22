<?php

$desc = $data['short_description'];
if( ! empty( $desc ) ){
    echo do_shortcode( $desc );
}
