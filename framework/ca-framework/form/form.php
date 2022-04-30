<?php 
namespace CA_Framework\Form;

use CA_Framework\Form\Inc;
use CA_Framework\Form\Inc\Field;
use CA_Framework\Form\Inc\Form_Base;
use CA_Framework\Form\Inc\Form_Settings;

class Form extends Form_Base
{
    public $input_fields;
    public $options;
    public $menus;

    public $keyword;

    public $settings = [];


    public function __construct( $keyword, $args = array() )
    {
        if( ! is_string( $keyword ) ) return;
        $this->keyword = ! empty( $keyword ) ? $keyword : 'caf';
    }

    public function setSettings( $settings = array() )
    {
        if( ! is_array( $settings ) ) return $this;
        if( empty( $settings ) ) return $this;

        $this->settings = $settings;
    }

    public function createField( $args = array() )
    {   
        $field = $this->setFieldsSingle( $args );
        $field->render();
    }

    public function addField( $args = array() )
    {   
        $this->setFieldsSingle( $args );
        
    }

    public function addFields( $fields_args = array() )
    {   
        if( ! is_array( $fields_args ) ) return $this;;
        foreach( $fields_args as $args ){
            $this->setFieldsSingle( $args );
        }
    }

    private function setFieldsSingle( $args = array() )
    {
        if( ! isset( $args['id'] ) ) return new Field( [] );

        $filed_id = ! empty( $args['id'] ) ? $args['id'] : 'field_id';
        
        $field = new Field( $args );

        $this->input_fields[$filed_id]=$field->args;
        $this->options[$filed_id]=$field->args['value'] ?? '';
        return $field;

    }

    /**
     * Only Field render
     *
     * @return void
     */
    public function fieldRender()
    {
        foreach( $this->input_fields as $input_field ){
            $field = new Field( $input_field );
            $field->render();
        }
    }

    public function render()
    {
        
        if( empty( $this->settings ) ){
            $this->fieldRender();
        }
        //$this->controlSetting();
    }

    private function controlSetting()
    {
        new Form_Settings();
    }
}