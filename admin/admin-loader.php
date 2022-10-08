<?php 
namespace WOO_PRODUCT_TABLE\Admin;

use WOO_PRODUCT_TABLE\Core\Base;
use WOO_PRODUCT_TABLE\Admin\Handle\Deactive_Form;
class Admin_Loader extends Base{
    public function __construct(){
        $deactive_form = new Deactive_Form();
        $deactive_form->run();
    }
}