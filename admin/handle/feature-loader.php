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
        /**
         * It's Admin panel Table's Action column feature
         * Actually adding third-party plugin supported feature
         * checkbox added by this Class/Object. 
         * 
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        $action = new Action_Feature();
        $action->run();

        /**
         * I have added new Column Doc Link
         * now added for column: my_extream_adio
         * in next time, we will add more one by one
         * 
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        $doc_link = new Column_Doc_Link();
        $doc_link->run();
    }
}