<?php 
namespace WOO_PRODUCT_TABLE\Inc\Table;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Handle\Table_Attr;

class Row extends Table_Base{
    
    
    
    
    public $product_id;
    public $product_parent_id;
    public $product_type;
    public $product_sku;
    public $data_tax = null;
    
    public $attributes = [];
    public $available_variations = [];

    public $args;
    public $_enable_cols;
    public $column_array;
    public $column_settings;

    public $taxonomy_class;
    public $row_class;
    public $wp_force;
    public $checkbox;
    public $default_quantity;
    public $add_to_cart_text;
    public $ajax_action;
    public $product_permalink;
    public $product_stock_status;
    public $product_stock_status_class;

    public $table_id;
    public $table_type;

    public $protduct;
    public $product_data;
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
        $this->product_permalink = get_the_permalink();
        $this->product_stock_status = $this->product_data['stock_status'] ?? '';
        $this->product_sku = $this->product_data['sku'] ?? '';
        $this->product_stock_status_class = ( $this->product_stock_status == 'onbackorder' || $this->product_stock_status == 'instock' ? 'add_to_cart_button' : $this->product_stock_status . '_add_to_cart_button disabled' );
        $this->default_quantity = apply_filters( 'woocommerce_quantity_input_min', 1, $product );

        $this->wp_force = $shortcode->conditions['wp_force'] ?? false;

        // var_dump($shortcode);
        
        // $this->base = $shortcode;
        // $this->protduct = $product;

        $this->table_style = $shortcode->table_style;
        
        $this->items_directory = $shortcode->items_directory;
        


    }

    public function render(){
        global $product;
        
        extract($this->data_for_extract());

        $row_class = Table_Attr::row_class( $this );

        

        //New Added
        $row = $table_row = $this;
        
        // var_dump($this);
        $this->data_tax = apply_filters( 'wpto_table_row_attr', $this->data_tax, $product, false, $this->column_settings, $this->table_id );
        $this->data_tax = $this->apply_filter( 'wpt_table_row_attr', $this->data_tax );
        ?>
        <tr
        class="<?php echo esc_attr( $row_class ); ?>"
        
        id="product_id_<?php echo esc_attr( $this->product_id ); ?>"
        data-product_id="<?php echo esc_attr( $this->product_id ); ?>"
        data-temp_number="<?php echo esc_attr( $this->table_id ); ?>"
        data-type="<?php echo esc_attr( $this->product_type ); ?>"
        data-parent_id="<?php echo esc_attr( $this->product_parent_id ); ?>"
        data-quantity="<?php echo esc_attr( $this->default_quantity ); ?>"
        data-href="<?php echo esc_url( $this->product_permalink ); ?>"
        data-product_variations="<?php echo esc_attr( htmlspecialchars( wp_json_encode( $this->available_variations ) ) ); ?>"
        additional_json=""
        <?php echo esc_attr( $this->data_tax ); ?>
        role="row">
        <?php


        foreach( $this->_enable_cols as $keyword => $col ){
            
            $settings = $this->column_settings[$keyword] ?? false;
            
            $type = isset( $settings['type'] ) && !empty( $settings['type'] ) ? $settings['type'] : 'default';
            $file_name = $type !== 'default' ? $type : $keyword;

            //This will be removed in future update actually
            $this->items_directory = apply_filters('wpto_template_folder', $this->items_directory,$keyword, $type, $this->table_id, $product, $settings, $this->column_settings );
            
            $this->items_directory = $this->apply_filter( 'wpt_template_folder', $this->items_directory );

            $file = $this->items_directory. $file_name . '.php';

            $file = apply_filters( 'wpto_template_loc', $file, $keyword, $type, $this->table_id, $product, $file_name, $this->column_settings, $settings ); //@Filter Added 
            $file = $this->apply_filter( 'wpt_template_loc', $file );
            if( ! file_exists( $file ) ){
                $file = $this->items_directory. 'default.php';
            }


            $style_str = $this->column_settings[$keyword]['style_str'] ?? '';
            $style_str = ! empty( $style_str ) ? preg_replace('/(;|!important;)/i',' !important;',$style_str) : '';
        


            ?>
            <td class="<?php echo esc_attr( Table_Attr::td_class($keyword, $this) ); ?>"
            data-keyword="<?php echo esc_attr( $keyword ); ?>" 
            data-temp_number="<?php echo esc_attr( $this->table_id ); ?>" 
            data-sku="<?php echo esc_attr( $this->product_sku ); ?>"
            style="<?php echo esc_attr( $style_str ); ?>"
            >
            <?php

            /**
             * Adding Content at the top of Each Table
             * 
             * @Hooked: wpt_pro_add_toggle_content -10, at includes/functions.php file of Pro Version
             * 
             * This wpto_ hook will be removed in future update
             */
            do_action( 'wpto_column_top', $keyword, $this->table_id, $settings, $this->column_settings, $product );
            do_action( 'wpt_column_top', $keyword, $this );
            
            include $file;



            /**
             * Adding Content at the Bottom of Each TableTD
             * 
             * 
             * This wpto_ hook will be removed in future update
             */
            do_action( 'wpto_column_bottom', $keyword, $this->table_id, $settings, $this->column_settings, $product );
            do_action( 'wpt_column_bottom', $keyword, $this );
            ?>
            </td>
            <?php
        }
        ?>
        </tr>
        <?php

        // var_dump($this);
    }

    public function render_item( string $keyword ){
        global $product;
        
        extract($this->data_for_extract());



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

    /**
     * All Variation which will be need inside item,
     * I have used in this Method,
     * 
     * Here also will stay a filter, where user will able to 
     * insert new Variable for inner item 
     * and for any td of table
     * 
     * @since 3.2.4.2
     * 
     * @author Saiful Islam <codersaiful@gmail.com>
     * @return Array a set of collection for Inner Item or for any TD. I need to extract it actually
     */
    private function data_for_extract(){
        return [
        'id' => $this->product_id,
        'table_type' => $this->table_type,
        'product_type' => $this->product_type,
        'temp_number' => $this->table_id,
        'table_ID' => $this->table_id,
        'data' => $this->product_data,
        'config_value' => $this->table_config,
        'column_settings' => $this->column_settings,
        'checkbox' =>  $this->checkbox,
        'table_column_keywords' => $this->_enable_cols,
        'ajax_action' => $this->ajax_action,
        'add_to_cart_text' => $this->add_to_cart_text,
        'default_quantity' => $this->default_quantity,
        'stock_status' => $this->product_stock_status,
        'stock_status_class' => $this->product_stock_status_class,

        'description_type' => $this->description_type,
        //For Variable Product
        'attributes' => $this->attributes,
        'available_variations' => $this->available_variations,


        'row_class' => Table_Attr::row_class( $this ),
        ];
    }
}