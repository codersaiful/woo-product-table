<?php
echo "<div data-temp_number='{$temp_number}' class='{$row_class} wpt_variations wpt_variation_" . $data['id'] . "' data-quantity='1' data-product_id='" . $data['id'] . "' data-product_variations = '" . esc_attr( $data_product_variations ) . "'> ";
echo $variation_html;
echo "</div>";