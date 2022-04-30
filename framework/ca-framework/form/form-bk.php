<?php 
namespace CA_Framework\Form;

use CA_Framework\Form\Inc;
use CA_Framework\Form\Inc\Field;
use CA_Framework\Form\Inc\Form_Base;

class Form extends Form_Base
{
    public static $fields;
    public static $menus;


    public function __construct( $args = array() )
    {
        // $this->$args = $args;
    }

    public static function createField( $args = array() )
    {   

        $filed_id = $args['id'] ?? 'field_id';
        
        $field = new Field( $args );

        self::$fields[$filed_id]=$field->args;
        $field->render();
    }

    public static function addField( $args = array() )
    {   

        $filed_id = $args['id'] ?? 'field_id';
        
        $field = new Field( $args );

        self::$fields[$filed_id]=$field->args;
    }

    public static function render()
    {
        
    }
}