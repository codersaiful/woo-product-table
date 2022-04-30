<?php 
namespace CA_Framework\Form\Fields;

use CA_Framework\Form\Inc\Field_Base;

/**
 * Switch or One Off 
 * Button
 */
class Switch_Control extends Field_Base
{

    private $on_label;
    private $off_label;
    private $return_value;

    
    public function __construct( $args )
    {

        parent::__construct( $args );

        
    }
    public function render()
    {
        // var_dump($this);
        ?>


        <?php 
    }

}