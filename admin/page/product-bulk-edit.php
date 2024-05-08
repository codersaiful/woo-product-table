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
        if( ! class_exists( 'PSSGP_Init' ) ){
        ?>
        <a href="https://codeastrology.com/downloads/product-sync-master-sheet-premium/" target="_blank" style="margin-bottom: -30px;display:block;color: #d00;">Get <i>Sync Master Sheet Premium</i></a>
        <?php    
        }
        if( class_exists( '\PSSG_Sync_Sheet\App\Handle\Quick_Table' ) ){

            $quckTable = new \PSSG_Sync_Sheet\App\Handle\Quick_Table();
            $quckTable->display_table_full();
            
        }else{

        
        ?>

        <div class="wpt-section-panel supported-terms wpt-recomendation-area" id="wpt-recomendation-area">
            <table class="wpt-my-table universal-setting">
                <thead>
                    <tr>
                        <th class="wpt-inside">
                            <div class="wpt-table-header-inside">
                                <h3><?php echo esc_html__('Quick and Bulk Edit', 'wpt'); ?> <small class="wpt-small-title">Need to intall and activate following</small></h3>
                            </div>

                        </th>
                        <th>
                            <div class="wpt-table-header-right-side"></div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                <tr>
                    <td>
                        <div class="wqpmb-form-control">
                            <div class="form-label col-lg-12">
                            <?php 
                            
                            do_action( 'wpt_sync_plugin_recommendation' ); ?>
                            </div>

                        </div>
                    </td>
                    <td>
                        <div class="wqpmb-form-info">
                            
                            <p>Highly Recommeded this plugin. Which will help you to bulk edit of your all product.</p>
                        </div> 
                    </td>
                </tr>
                </tbody>
            </table>

        </div> <!--/.wpt-recomendation-area -->
        <?php
        }
        ?>
    </div>

</div> <!-- ./wrap wpt_wrap wpt-content -->