<?php
$date_modified = $data['date_modified'];
echo wp_kses_post( $date_modified->date( get_option( 'date_format' ) ) );
