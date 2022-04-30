<?php 
namespace CA_Framework\Form\Inc;

use CA_Framework\Form\Fields as Fields;


class Field extends Field_Base
{
    public $errors = [];
    public function __construct( $args = [] )
    {
        
        if( ! is_array( $args ) ){
            $this->errors[] = __( 'Fields args Should be an array!' );
        };
        parent::__construct( $args );
    }

    public function render()
    {
        $this->check_error( true );
        ?>
        <div class="ca-field ca-field-<?php echo esc_attr( $this->id ); ?> <?php echo esc_attr( $this->wrapper_class ); ?>">
            <div class="ca-field-inside">
                <label class="ca-field-tag ca-field-label"><?php echo esc_html( $this->label ); ?></label>
                <div class="ca-field-tag ca-field-input">
                    

        <?php
        
        switch( $this->type ){
            case 'input':
            $this->renderTextField();    
            break;
            case 'select':
                $this->renderSelectField();    
                break;    
            case 'switch':
                $this->renderSwitchField();    
                break;    

        }
        ?>
                    <?php if( ! empty( $this->desc ) ): ?>
                    <p class="ca-field-desc"><?php echo wp_kses_post( $this->desc ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>        
        <?php
    }

    public function renderTextField()
    {

        $fff = new Fields\Input($this->args);
        $fff->render();
    }
    public function renderSelectField()
    {

        $fff = new Fields\Select($this->args);
        $fff->render();
    }
    
    public function renderSwitchField()
    {

        $fff = new Fields\Switch_Control($this->args);
        $fff->render();
    }


    public function check_error( $bool )
    {
        if( $bool && $this->errors ){
            foreach( $this->errors as $error ){
                var_dump($error);
            }
            return;
        }
    }
}