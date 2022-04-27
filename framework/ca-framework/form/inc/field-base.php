<?php 
namespace CA_Framework\Form\Inc;

use CA_Framework\Form\Fields as Fields;

class Field_Base
{
    
    public $args;
    public $id;
    public $type;
    public $name;
    public $label;
    public $wrapper_class;
    public $class_name;
    public $desc;
    public $value;
    public $options;


    public function __construct( $args )
    {

        if( ! is_array( $args ) ) return;
        $this->args = $args;
        
        $this->id = $this->args['id'] = $args['id'] ?? 'id';
        $this->name = $this->args['name']  = $args['name'] ?? 'ca-field[' . $this->id . ']';
        $this->type = $this->args['type'] = $args['type'] ?? 'input';
        $this->label = $this->args['label'] = $args['label'] ?? __( 'Form Label' );
        $this->wrapper_class = $this->args['wrapper_class'] = $args['wrapper_class'] ?? '';
        $this->class_name = $this->args['class_name'] = $args['class_name'] ?? '';
        $this->desc = $this->args['desc'] = $args['desc'] ?? '';
        $this->value = $this->args['value'] = $args['value'] ?? '';
        $this->options = $this->args['options'] = isset( $args['options'] ) && is_array( $args['options'] ) ? $args['options'] : array();
        
        
    }

    
}