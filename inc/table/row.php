<?php 
namespace WOO_PRODUCT_TABLE\Inc\Table;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Handle\Table_Attr;

class Row extends Table_Base{
    
    
    
    
    public $product_id;
    public $product_parent_id;
    public $product_type;
    public $product_data;


    public $args;
    public $_enable_cols;
    public $column_array;
    public $column_settings;

    public $taxonomy_class;
    public $row_class;

    public $table_id;

    public $protduct;
    public $base;


    public function __construct( Shortcode $shortcode ){
        global $product;
        $this->table_id = $shortcode->table_id;
        $this->product_id = $product->get_id();
        $this->product_type = $product->get_type();
        $this->product_parent_id = $product->get_parent_id();//$parent_id = $product->get_parent_id();
        $this->individual = $product->is_sold_individually() ? "individually-sold" : "not-individually-sold";
        $this->product_data = $product->get_data();

        $this->args = $shortcode->args;
        $this->_enable_cols = $shortcode->_enable_cols;
        $this->column_array = $shortcode->column_array;
        $this->column_settings = $shortcode->column_settings;

        
        // $this->base = $shortcode;
        // $this->protduct = $product;


    }

    public function render(){
        /**
         * Some usefull Variable for editing from 
         */
        (Int) $id = $this->product_data['id'] ?? 0;
        var_dump($this);
        ?>
        <tr class="<?php echo esc_attr( Table_Attr::row_class( $this ) ); ?>">

        </tr>
        <?php

        // var_dump($this);
    }
}