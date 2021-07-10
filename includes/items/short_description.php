<?php

$desc = $data['short_description'];

//XSS pass inside woocommerce get_data method
echo do_shortcode( $desc );