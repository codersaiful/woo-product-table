<?php 
namespace WOO_PRODUCT_TABLE\Inc\Table;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Handle\Table_Attr;

class Row extends Table_Base{
    
    
    
    
    public $product_id;
    public $product_parent_id;
    public $product_type;
    public $product_data;
    public $attributes = [];
    public $available_variations = [];


    public $items_directory;
    public $items_permanent_dir;


    public $args;
    public $_enable_cols;
    public $column_array;
    public $column_settings;

    public $taxonomy_class;
    public $row_class;
    public $wp_force;
    public $checkbox;

    public $table_id;
    public $table_type;

    public $protduct;
    public $base;


    public function __construct( Shortcode $shortcode ){
        global $product;
        $this->table_id = $shortcode->table_id;
        $this->table_type = $shortcode->table_type;
        $this->product_id = $product->get_id();
        $this->product_type = $product->get_type();
        $this->product_parent_id = $product->get_parent_id();//$parent_id = $product->get_parent_id();
        $this->individual = $product->is_sold_individually() ? "individually-sold" : "not-individually-sold";
        $this->product_data = $product->get_data();

        if( $this->product_type == 'variable' ){
            $variable = new \WC_Product_Variable( $this->product_id );
            $this->available_variations = $variable->get_available_variations();
            $this->attributes = $variable->get_variation_attributes();
        }
        //$description_type = $conditions['description_type'] ?? '';
        $this->description_type = $shortcode->conditions['description_type'] ?? '';

        $this->args = $shortcode->args;
        $this->table_config = $shortcode->_config;
        $this->_enable_cols = $shortcode->_enable_cols;
        $this->column_array = $shortcode->column_array;
        $this->column_settings = $shortcode->column_settings;

        $this->ajax_action = $shortcode->ajax_action;
        $this->add_to_cart_text = $shortcode->add_to_cart_text;
        $this->default_quantity = apply_filters( 'woocommerce_quantity_input_min', 1, $product );

        $this->wp_force = $shortcode->conditions['wp_force'] ?? false;

        
        // $this->base = $shortcode;
        // $this->protduct = $product;

        $this->items_permanent_dir = WPT_DIR_BASE . 'includes/items/';
        $this->items_permanent_dir = apply_filters('wpto_item_permanent_dir', $this->items_permanent_dir, $this->table_id, $product );
        $this->items_directory = apply_filters('wpto_item_dir', $this->items_permanent_dir, $this->table_id, $product );
        


    }

    public function render(){
        global $product;
        /**
         * Some usefull Variable for editing from 
         */
        (Int) $id = $this->product_data['id'] ?? 0;
        $table_type = $this->table_type;
        $product_type = $this->product_type;
        $temp_number  = $this->table_id;
        $table_ID = $this->table_id;
        $data  = $this->product_data;
        $config_value  = $this->table_config;
        $column_settings  = $this->column_settings;
        $checkbox   = $this->checkbox;
        $table_column_keywords = $this->_enable_cols;
        $ajax_action = $this->ajax_action;
        $add_to_cart_text = $this->add_to_cart_text;
        $default_quantity = $this->default_quantity;
        $stock_status = $this->product_data['stock_status'];
        $stock_status_class = ( $stock_status == 'onbackorder' || $stock_status == 'instock' ? 'add_to_cart_button' : $stock_status . '_add_to_cart_button disabled' );

        $description_type = $this->description_type;
        //For Variable Product
        $attributes = $this->attributes;
        $available_variations = $this->available_variations;


        $row_class = '';//It will need to be fix


        //New Added
        $row = $table_row = $this;
        
        
        ?>
        <tr class="<?php echo esc_attr( Table_Attr::row_class( $this ) ); ?>">
        <?php


        foreach( $this->_enable_cols as $keyword => $col ){
            $settings = $this->column_settings[$keyword] ?? false;

            $type = isset( $settings['type'] ) && !empty( $settings['type'] ) ? $settings['type'] : 'default';
            $file_name = $type !== 'default' ? $type : $keyword;
            $file = $this->items_directory. $file_name . '.php';
            if( !file_exists( $file ) ){
                $file = $this->items_directory. 'default.php';
            }
            ?>
            <td>
            <?php
            include $file;
            ?>
            </td>
            <?php
        }
        ?>
        </tr>
        <?php

        // var_dump($this);
    }
}