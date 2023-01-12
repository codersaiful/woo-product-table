<?php
namespace WOO_PRODUCT_TABLE\Admin\Handle;

/**
 * All feature handle/control will from here
 * 
 * 
 * Such: 
 * action-feature
 * other 
 * 
 * Even we will transfer other feature which currently available in functions.php file
 * 
 * @since 3.3.6.0
 * @author Saiful Islam <codersaiful@gmail.com>
 */
class Feature_Loader
{
    public function run()
    {
        $action = new Action_Feature();
        $action->run();
    }
}