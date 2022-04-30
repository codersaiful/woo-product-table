<?php 
namespace CA_Framework\Form\Fields;

use CA_Framework\Form\Inc\Field_Base;

class Select extends Field_Base
{
    private $multiple;
    public function __construct( $args )
    {
        parent::__construct( $args );

        $this->multiple = isset( $this->args['multiple'] ) && $this->args['multiple'] ? true : false;
    }
    public function render()
    {
        $name = $this->multiple ? $this->name . '[]' : $this->name;
        $multiple = $this->multiple ? 'multiple' : '';
        $value = $this->value;
        
        ?>
        <select
        value="<?php echo esc_attr( $this->value ); ?>"
        class="ca-field-single <?php echo esc_attr( $this->class_name ); ?>"
        name="<?php echo esc_attr( $name ); ?>"
        <?php echo esc_attr( $multiple ); ?>

        >
        <?php
        foreach( $this->options as $key=>$option ){
            $option_value = is_string( $option ) ? $option : __( 'Undefined', 'ca-framework' );
            if($this->multiple){
                $select = is_array( $value ) && in_array( $key, $value ) ? 'selected' : '';
            }else{
                $select = is_string( $value ) && $key == $value ? 'selected' : '';
            }
            
        ?>
            <option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $select ); ?>><?php echo esc_html( $option_value ); ?></option>
        <?php 
        }
        ?>
        </select>
        
        <?php 
    }

}