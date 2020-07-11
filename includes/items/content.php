<?php
$content = isset( $column_settings['content']['content'] ) ? $column_settings['content']['content'] : false;
echo do_shortcode( $content );