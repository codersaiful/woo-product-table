<?php 
namespace WOO_PRODUCT_TABLE\Admin;

use WOO_PRODUCT_TABLE\Core\Base;
use WOO_PRODUCT_TABLE\Admin\Handle\Feature_Loader;
use WOO_PRODUCT_TABLE\Admin\Handle\Pro_Version_Update;
use WOO_PRODUCT_TABLE\Admin\Handle\Deactive_Form as Old_Deactive_Form;
use WOO_PRODUCT_TABLE\Admin\Handle\Plugin_Deactive\Deactive_Form;
class Admin_Loader extends Base{
    public function __construct(){
        
        $deactive_form = new Deactive_Form();
        $deactive_form->run();

        $pro_update_ntc = new Pro_Version_Update();
        $pro_update_ntc->run();

        $features = new Feature_Loader();
        $features->run();

    }
}