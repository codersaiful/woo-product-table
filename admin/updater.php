<?php

include 'updater_class.php';
$option_name = WPT_Product_Table::$options_name;
$purchase_code = get_option( $option_name );
$updtr = new WOO_WPT_Plugin_updater($purchase_code,WPT_Product_Table::$item_id);
$updtr->current_version = WPT_Product_Table::getVersion();
$updtr->plugin_folder = 'woo-product-table-pro';
$updtr->plugin_file = 'woo-product-table-pro';
$updtr->setUpdateMessage('<br>Please <a style="color: #d00;" href="' . admin_url('edit.php?post_type=wpt_product_table&page=wpt-activate-purchase-code') . '">Active your license</a> by your Purchase Code.');
$updtr->start();
//$updtr->deleteTransient();
/*
add_action( 'load-plugins.php', 'wpt_plugin_updater_loader' );
add_action( 'load-edit.php', 'wpt_plugin_updater_loader' );
add_action( 'load-index.php', 'wpt_plugin_updater_loader' );
add_action( 'load-plugin-install.php', 'wpt_plugin_updater_loader' );
add_action( 'load-plugin-editor.php', 'wpt_plugin_updater_loader' );
function wpt_plugin_updater_loader() {
    $option_name = WPT_Product_Table::$options_name;
    $purchase_code = get_option( $option_name );
    $updtr = new WOO_WPT_Plugin_updater($purchase_code,WPT_Product_Table::$item_id);
    $updtr->current_version = WPT_Product_Table::getVersion();
    $updtr->plugin_folder = 'woo-product-table-pro';
    $updtr->plugin_file = 'woo-product-table-pro';
    $updtr->setUpdateMessage('<br>Please <a style="color: #d00;" href="' . admin_url('edit.php?post_type=wpt_product_table&page=wpt-activate-purchase-code') . '">Active your license</a> by your Purchase Code.');
    $updtr->start();
    //$updtr->deleteTransient();
}

*/

function wpt_updater_admin_menu() {
    add_submenu_page( 'edit.php?post_type=wpt_product_table', esc_html__( 'Activate Purchase Code', 'wpt_pro' ),  esc_html__( 'Activate', 'wpt_pro' ), 'edit_theme_options', 'wpt-activate-purchase-code', 'wpt_activate_purchase_code_page' );  
}
add_action( 'admin_menu', 'wpt_updater_admin_menu' );

function wpt_activate_purchase_code_page(){
    $option_name = WPT_Product_Table::$options_name;//'wpt_codecanyon_purchase_code';
    if( isset( $_POST['purchase_code'] ) && !empty( $_POST['purchase_code'] ) ){
        $inserted_purchase_code = $_POST['purchase_code'];
        update_option( $option_name, $inserted_purchase_code );
        $submit = new WOO_WPT_Plugin_updater( $inserted_purchase_code,WPT_Product_Table::$item_id);
        $submit->updateTransient();
    }
    $status = "<span class='purchase_code_inactive'>Inactive</span>";
    $purchase_code = get_option( $option_name );
    $updtr = new WOO_WPT_Plugin_updater($purchase_code,WPT_Product_Table::$item_id);
    $saved_transient = get_transient($updtr->getTransientName() . '_response');
    if($saved_transient){
        $response = $saved_transient;
    }else{
        $updtr->updateJSONTransient();
        $response = $updtr->getResponse();
    }
    
    $today = time();
    $supported_until = $response_item_id = $support_end_msg = false;
    $item_id = WPT_Product_Table::$item_id;
    if( isset( $response['supported_until'] ) && isset( $response['item']['id'] ) ){
        $supported_until = strtotime($response['supported_until']);
        $response_item_id = $response['item']['id'];
    }
    //var_dump($supported_until,$varification->getErrors());
    
    if( $supported_until && $supported_until > $today && $response_item_id == $item_id ){
        $status = "<span class='purchase_code_active'>Active</span>";
        
        $support_end_msg .= '<p class="updated notice notice-success">';
        $support_end_msg .= "You able to get Automatic update from Plugin page.";
        $support_end_msg .= '<br><img class="rate_us_image" src="' . WPT_Product_Table::getPath( 'BASE_URL' ) . 'images/updater.png">';
        
        $support_end_msg .= '</p>';
    }elseif( $supported_until && $supported_until < $today && $response_item_id == $item_id ){
        $support_end_msg .= '<p class="updated notice notice-warning updater_warning_message">';
        $support_end_msg .= "Your Support has Expired. To get Auto Update. You need to extend your support for our Proudct.";
        $support_end_msg .= "<br>Otherwise, Please login to your codecanyon account. Download Plugin. And Install Manually.";
        $support_end_msg .= "<br><b>Manually Install:</b><br> First deactivate plugin, then delete, then install, then activate.";
        
        $support_end_msg .= '</p>';
    }elseif( empty( $purchase_code ) ){
        $support_end_msg .= "<h1 class='updated notice notice-warning' style='color: #abc;'>No Purchase Code</h1>";
    }else{
        $support_end_msg .= "<h1 class='updated notice notice-warning' style='color: #e00;'>Invalid Purchase Code</h1>";
    }
    
    
    
    //$updtr->deleteTransient();
    
    //$stats = $updtr->getResponse();

    
?>

<div class="wrap">
    <h2></h2>
    <div class="purchase_code_wrapper">
        <h3>Plugin Activate here:</h3>
        <form action="" method="POST">
            <input name="purchase_code" type="text" value="<?php echo $purchase_code; ?>" style="width: 500px;max-width: 80%;padding: 5px;margin-bottom: 10px;font-size: 19px;color: #b9b9b9;" placeholder="Input your Purchase code"> <?php echo $status; ?><br>
            <button class="button button-primary button-large" type="submit">Submit</button>
        </form>
        <hr>
        <h3>Status</h3>
        <div class="purchase_status">
            <?php echo $support_end_msg; ?>
        </div>
        <div>
            
            <?php 
            if( isset($response) && is_array( $response ) && count( $response ) > 0 ){
                echo '<b>Other Info</b>';
                echo '<ol>';
                foreach($response as $key=>$value){
                    echo !is_array($value) ? "<li><b>{$key}:</b> {$value}</li>" : false;
                }
                echo '</ol>';
                
                echo '<div style="width: 100%;background: white;display: block;padding: 10px;margin-top: 20px;">';
                if( isset($response['item']) && is_array( $response['item'] ) && count( $response['item'] ) > 0 ){
                    unset($response['item']['description']);
                    unset($response['item']['summary']);
                    echo "Additinal Info";
                    echo '<ol>';
                    foreach( $response['item'] as $ky=>$itm ){
                        echo !is_array($itm) ? "<li><u>{$ky}:</u> {$itm}</li>" : false;
                    }
                    echo '</ol>';
                }
                echo '</div>';
                
            }
            ?>
        </div>
    </div>
</div>    
<?php
//$updtr->deleteTransient();
}
