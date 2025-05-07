<?php
$settings = array(
    'page' => 'configuration_page',
    'module' => 'free',
);

$settings = apply_filters('wpto_configuration_settings', $settings);

$wrapper_class = isset($settings['module']) ? $settings['module'] : '';

?>
<div class="wrap wpt_wrap wpt-content <?php echo esc_attr($wrapper_class); ?>">

    <h1 class="wp-heading "></h1>
    <div class="fieldwrap">


        <?php
        
        if (class_exists('\PSSG_Sync_Sheet\App\Handle\Quick_Table')) {

            $quckTable = new \PSSG_Sync_Sheet\App\Handle\Quick_Table();
            $quckTable->display_table_full();
        }
        ?>
    </div>

</div> <!-- ./wrap wpt_wrap wpt-content -->