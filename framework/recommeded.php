<?php 
namespace WOO_PRODUCT_TABLE\Framework;;

use CA_Framework\App\Notice as Notice;
use CA_Framework\App\Require_Control as Require_Control;

include_once __DIR__ . '/ca-framework/framework.php';

class Recommeded
{
    public static function check()
    {
        
        $qv_req_slug = 'ca-quick-view/init.php';
        $qv_tar_slug = WPT_PLUGIN_BASE_FILE;
        $req_qv = new Require_Control($qv_req_slug,$qv_tar_slug);
        $req_qv->set_args( ['Name' => 'Quick View vy CodeAstrology'] )
        ->set_download_link('https://wordpress.org/plugins/ca-quick-view/')
        ->set_this_download_link('https://wordpress.org/plugins/woo-product-table/')
        ->set_required();
        if( method_exists($req_qv, 'set_location') ){
            $req_qv->set_location('wpto_column_setting_form_quick_view'); //wpt_premium_image_bottom
            // $req_qv->set_location('wpto_column_setting_form_inside_quick_view'); //wpt_premium_image_bottom
            $req_qv->run();
        }
        
    }
}