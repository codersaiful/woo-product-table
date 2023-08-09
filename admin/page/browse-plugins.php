<div class="wrap wpt_wrap wpt-content">
    <h1 class="wp-heading "></h1>
    <div class="fieldwrap">

        <div class="wpt-section-panel no-background wpt-clearfix">
            <?php 
            
            $wp_list_table = _get_list_table( 'WP_Plugin_Install_List_Table' );
            
            $wp_list_table->prepare_items();

            echo '<form id="plugin-filter" method="post">';
            $wp_list_table->display();
            echo '</form>';
            ?>
        </div>
    </div>

</div>