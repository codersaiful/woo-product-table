<?php 
namespace WOO_PRODUCT_TABLE\Admin;

use WOO_PRODUCT_TABLE\Admin\Page_Loader;
use WOO_PRODUCT_TABLE\Core\Base;
use WOO_PRODUCT_TABLE\Admin\Handle\Tracker;
use WOO_PRODUCT_TABLE\Admin\Handle\Feature_Loader;
use WOO_PRODUCT_TABLE\Admin\Handle\Pro_Version_Update;
use WOO_PRODUCT_TABLE\Admin\Handle\Deactive_Form as Old_Deactive_Form;
use WOO_PRODUCT_TABLE\Admin\Handle\Plugin_Deactive\Deactive_Form;
class Admin_Loader extends Base{
    public function __construct(){

        $main_page = new Page_Loader();
        $main_page->run();



        $deactive_form = new Deactive_Form();
        $deactive_form->run();

        /**
         * This is only for Notice for pro user,
         * Actually on free version and pro version combination
         * need min request pro for latest free version,
         * that's why, we have added this notice.
         */
        $pro_update_ntc = new Pro_Version_Update();
        $pro_update_ntc->run();

        $features = new Feature_Loader();
        $features->run();


        // add_action('admin_init', [$this, 'admin_init']);
    }

    public function admin_init(){

        // $tracker = new Tracker();
        // $tracker->run();
        
    }
}