<?php

if( !function_exists( 'wpt_configuration_page_head' ) ){
    function wpt_configuration_page_head(){
        ?>
        <div class="fieldwrap ultraaddons-head">
            <div class="ultraaddons-panel">
                <h1 class="wp-heading-inline plugin_name plugin-name"><?php echo WPT_Product_Table::getName(); ?> <span class="plugin-version">v <?php echo WPT_Product_Table::getVersion(); ?></span></h1>
                <h1 class="plugin-settings with-background no-top slim-title"><?php esc_html_e( 'Common Configuration', 'wpt_pro' );?></h1>
                <p><?php esc_html_e( 'Remember: Each product table has indivisual configuration, wheich is First Importance. But to This Configuration has no "First importance".', 'wpt_pro' );?></p>
            </div>
        </div>    
            
         <?php
    }
}
add_action( 'wpto_admin_configuration_head', 'wpt_configuration_page_head',10 );