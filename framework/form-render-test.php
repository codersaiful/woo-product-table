<?php 
include_once __DIR__ . '/ca-framework/framework.php';

use CA_Framework\Form\Form;

class CA_Test_From
{
    public function __construct()
    {
        add_action("admin_menu", [$this, "menu_page"] );
        
    }
    public function menu_page()
    {
        add_menu_page('CA Fram', 'CA Frame', 'manage_options', 'ca-test-form',[$this, 'my_form'], 'dashicons-admin-settings', 10);
    }
    public function my_form()
    {
        ?>
        <h1>Form Testing</h1>
        <form>
            <?php
            
            $fields_args = [
                [
                    'id'    => 'my-age1',
                    'type'=>'input',
                    'data_type'=>'range',
                    'label'=> 'Your Age',
                    'desc'=> 'Insert your full Age.'
                ],
                [
                    'id'    => 'my-age2',
                    'type'=>'input',
                    'data_type'=>'range',
                    'label'=> 'Your Age',
                    'desc'=> 'Insert your full Age.'
                ],
                [
                    'id'    => 'my-age3',
                    'type'=>'input',
                    'data_type'=>'range',
                    'label'=> 'Your Age',
                    'desc'=> 'Insert your full Age.'
                ],
                [
                    'id'    => 'my-age4',
                    'type'=>'input',
                    'data_type'=>'range',
                    'label'=> 'Your Age',
                    'desc'=> 'Insert your full Age.'
                ]
            ];
            
            $forrm = new Form('saiful');
            $forrm->addField([
                'id'    => 'my-age44',
                'type'=>'input',
                'data_type'=>'range',
                'label'=> 'Your Age',
                'desc'=> 'Insert your full Age.'
            ]);
            $forrm->addFields( $fields_args );
            $forrm->render();
            
            
            ?>


        </form>
        
        <?php 

        

        
    }
}

new CA_Test_From();