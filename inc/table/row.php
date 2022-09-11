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

    /**
     * We have some Variable Available inside 
     * Item page or Inside TD file
     * which will store here.
     * 
     * Even we also can customize this value using filter hook
     * @Hook filter wpt_avialable_variables
     *
     * @var array
     */
    public $avialable_variables = [];
    
    public $attributes = [];
    public $available_variations = [];
    public $variable_for_total = false;

    public $args;
    public $_enable_cols;
    public $column_array;
    public $column_settings;

    //Actually it's for mini filter
    public $taxonomy_class = 'no_filter';
    public $filter;

    /**
     * Tr Class for this table row mean, tr's class
     * I will generate it using Table_Attr::tr_class() and it will return an array
     *
     * @var Array
     */
    public $tr_class;
    //for table tr class which will return a string.
    public $tr_class_strings;

    /**
     * Actually in action column, we have used a class $row_class, which is manage product type
     * if variable product, row class will go 'data_product_variations woocommerce-variation-add-to-cart variations_button woocommerce-variation-add-to-cart-disabled'
     * 
     * and I will send it  over there using our method data_for_extract();
     *
     * @var string
     */
    public $row_class = '';
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
    public $is_column_label;

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
        $this->filter = $shortcode->filter;


        if($this->filter){
            $this->generate_taxo_n_data_tax( $this->filter );
        }
        

        if( $this->product_type == 'variable' ){
            $this->variable_for_total = true;
            $variable = new \WC_Product_Variable( $this->product_id );
            $this->available_variations = $variable->get_available_variations();
            
            $this->attributes = $variable->get_variation_attributes();
            $this->row_class = 'data_product_variations woocommerce-variation-add-to-cart variations_button woocommerce-variation-add-to-cart-disabled';
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
        $this->product_sku = $this->product_data['sku'] ?? '';
        $this->product_stock_status_class = ( $this->product_stock_status == 'onbackorder' || $this->product_stock_status == 'instock' ? 'add_to_cart_button' : $this->product_stock_status . '_add_to_cart_button disabled' );
        $this->default_quantity = apply_filters( 'woocommerce_quantity_input_min', 1, $product );

        $this->wp_force = $shortcode->conditions['wp_force'] ?? false;


        $this->is_column_label = $shortcode->is_column_label;
        
        $this->items_directory = $shortcode->items_directory;

    }

    protected function generate_taxo_n_data_tax( $filter ){
        $this->taxonomy_class = 'filter_row ';
        foreach( $filter as $tax_keyword){
            $terms = wp_get_post_terms( $this->product_id, $tax_keyword  );
            if( ! is_array( $terms ) ) continue;

            $attr = "data-{$tax_keyword}=";

            $attr_value = false;
            foreach( $terms as $term ){
                $this->taxonomy_class .= $tax_keyword . '_' . $this->table_id . '_' . $term->term_id . ' ';
                $attr_value .= $term->term_id . ':' . $term->name . ', ';
            }
            $this->data_tax .= $attr . '"' . $attr_value . '" ';
        }

    }
    public function render(){
        global $product;
        
        extract($this->data_for_extract());

        $tr_classs = Table_Attr::tr_class( $this );


        $this->data_tax = apply_filters( 'wpto_table_row_attr', $this->data_tax, $product, false, $this->column_settings, $this->table_id );
        $this->data_tax = $this->apply_filter( 'wpt_table_row_attr', $this->data_tax );
        ?>
        <tr
        class="<?php echo esc_attr( $tr_classs ); ?>"
        
        id="product_id_<?php echo esc_attr( $this->product_id ); ?>"
        data-product_id="<?php echo esc_attr( $this->product_id ); ?>"
        data-temp_number="<?php echo esc_attr( $this->table_id ); ?>"
        data-type="<?php echo esc_attr( $this->product_type ); ?>"
        data-parent_id="<?php echo esc_attr( $this->product_parent_id ); ?>"
        data-quantity="<?php echo esc_attr( $this->default_quantity ); ?>"
        data-href="<?php echo esc_url( $this->product_permalink ); ?>"
        data-product_variations="<?php echo esc_attr( htmlspecialchars( wp_json_encode( $this->available_variations ) ) ); ?>"
        additional_json=""
        <?php echo $this->data_tax; ?>
        role="row">
        <?php


        foreach( $this->_enable_cols as $keyword => $col ){
            
            
            $settings = $this->column_settings[$keyword] ?? false;
            
            $type = isset( $settings['type'] ) && !empty( $settings['type'] ) ? $settings['type'] : 'default';
            $file_name = $type !== 'default' ? $type : $keyword;
            
            $items_directory = $this->apply_filter( 'wpt_template_folder', $this->items_directory );

            //This will be removed in future update actually
            $items_directory = apply_filters('wpto_template_folder', $items_directory,$keyword, $type, $this->table_id, $product, $settings, $this->column_settings );
            
            

            $file = $items_directory. $file_name . '.php';
            $file = apply_filters( 'wpto_item_final_loc', $file, $file_name, $items_directory, $keyword, $this->table_id, $settings, $this->items_permanent_dir );


            $style_str = $this->column_settings[$keyword]['style_str'] ?? '';
            $style_str = ! empty( $style_str ) ? preg_replace('/(;|!important;)/i',' !important;',$style_str) : '';
        
            $column_title = $this->column_array[$keyword] ?? '';
            if( $keyword == 'check' ){
                $column_title = '';
            }
            $td_class = Table_Attr::td_class($keyword, $this);
            ?>
            <td class="<?php echo esc_attr( $td_class ); ?>"
            data-keyword="<?php echo esc_attr( $keyword ); ?>" 
            data-temp_number="<?php echo esc_attr( $this->table_id ); ?>" 
            data-sku="<?php echo esc_attr( $this->product_sku ); ?>"
            data-title="<?php echo esc_attr( $column_title ); ?>"
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
            
            $tag = $settings['tag'] ?? 'div';
            $tag_class = $settings['tag_class'] ?? '';
            if( $this->is_column_label ){
                $tag_class .= ' autoresponsive-label-show';
            }

            ?>
            <<?php echo esc_html( $tag ); ?> 
            data-keyword="<?php echo esc_attr( $keyword ) ; ?>"
            data-title="<?php echo esc_attr( $column_title ); ?>"
            data-sku="<?php echo esc_attr( $this->product_sku ); ?>"
            class="<?php echo esc_attr( $tag_class ); ?>">
                <?php 
                if( is_file( $file ) ){
                    include $file;
                }
                ?>
            </<?php echo esc_html( $tag ); ?>>
            
            <?php

            $items = $settings['items'] ?? false;
            $this->handle_items( $items );

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

    public function handle_items( $items = false ){
        if( empty( $items ) || ! is_array( $items ) ) return;
        foreach( $items as $item_key ){
            $this->render_item( $item_key );
        }
    }
    public function render_item( string $keyword ){
        global $product;
        
        extract($this->data_for_extract());



        $settings = $this->column_settings[$keyword] ?? false;
            
        $type = isset( $settings['type'] ) && !empty( $settings['type'] ) ? $settings['type'] : 'default';


        $file_name = $type !== 'default' ? $type : $keyword;
            
        $items_directory = $this->apply_filter( 'wpt_template_folder', $this->items_directory );

        //This will be removed in future update actually
        $items_directory = apply_filters('wpto_template_folder', $items_directory,$keyword, $type, $this->table_id, $product, $settings, $this->column_settings );
        
        

        $file = $items_directory. $file_name . '.php';
        $file = apply_filters( 'wpto_item_final_loc', $file, $file_name, $items_directory, $keyword, $this->table_id, $settings, $this->items_permanent_dir );


        $tag = $settings['tag'] ?? 'div';;
        $tag_class = $settings['tag_class'] ?? '';
        $style_str = $this->column_settings[$keyword]['style_str'] ?? '';
        $style_str = ! empty( $style_str ) ? preg_replace('/(;|!important;)/i',' !important;',$style_str) : '';
            
        echo $tag ? "<" . esc_html( $tag ) . " "
                . "class='item_inside_cell wpt_" . esc_attr( $keyword ) . " " . esc_attr( $tag_class ) . "' "
                . "data-keyword='" . esc_attr( $keyword ) . "' "
                . "data-sku='" . esc_attr( $product->get_sku() ) . "' "
                . "style='" . esc_attr( $style_str ) . "' "
                . ">" : '';
        
        
        /**
         * Adding Content at the top of Each Table
         * 
         * @Hooked: wpt_pro_add_toggle_content -10, at includes/functions.php file of Pro Version
         * 
         * This wpto_ hook will be removed in future update
         */
        do_action( 'wpto_column_top', $keyword, $this->table_id, $settings, $this->column_settings, $product );
        do_action( 'wpt_column_top', $keyword, $this );
                

        if( is_file( $file ) ){
            include $file;
        }

        do_action( 'wpto_column_top', $keyword, $this->table_id, $settings, $this->column_settings, $product );
        do_action( 'wpt_column_top', $keyword, $this );
        
        echo $tag ? "</" . esc_html( $tag ) . ">" : '';

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
        $this->avialable_variables = [
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
            'variable_for_total' => $this->variable_for_total,
    
    
            'row_class' => $this->row_class,
        ];

        return $this->apply_filter( 'wpt_avialable_variables', $this->avialable_variables );
    }
}