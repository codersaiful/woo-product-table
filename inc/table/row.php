<?php 
namespace WOO_PRODUCT_TABLE\Inc\Table;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Handle\Table_Attr;

class Row extends Table_Base{
    
    
    public $serial_number;
    public $page_number;
    public $posts_per_page;
    
    public $product_id;
    public $product_title;
    public $product_parent_id;
    public $product_type;
    public $product_sku;
    public $row_attr = null;

    /**
     * Td colum keyword pass
     * when use some following filter
     * wpt_column_top
     * wpt_column_bottom
     * 
     * Why I have used this property
     * actually we created new action hook like our based/default action hook
     *
     * @var string
     */
    public $td_keyword;
    public $_device;

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
    public $td_tag = 'td';
    public $generated_td_start;
    public $generated_td_end;
    public $wp_force;
    public $checkbox;
    public $default_quantity;
    public $add_to_cart_text;
    public $ajax_action;
    public $product_permalink;
    public $product_stock_status;
    public $product_stock_status_class;

    public $table_id;
    public $table_atts;
    public $table_type;
    public $is_column_label;

    public $protduct;
    public $product_data;
    public $base;
    public $display = true;


    public function __construct( Shortcode $shortcode ){
        global $product;
        $shortcode->row_serial = $shortcode->row_serial+1;
        $this->serial_number = $shortcode->row_serial;
        $this->page_number = $shortcode->page_number;
        $this->posts_per_page = $shortcode->posts_per_page;

        $this->table_id = $shortcode->table_id;
        $this->table_atts = $shortcode->atts;
        $this->table_type = $shortcode->table_type;
        $this->product_id = $product->get_id();
        
        $this->product_type = $product->get_type();
        $this->product_parent_id = $product->get_parent_id();//$parent_id = $product->get_parent_id();
        $this->individual = $product->is_sold_individually() ? "individually-sold" : "not-individually-sold";
        $this->product_data = $product->get_data();
        $this->product_title = $this->product_data['name'] ?? '';
        $this->filter = $shortcode->filter;

        if($shortcode->generated_row){
            $this->td_tag = 'div';

            $this->is_column_label = $shortcode->is_column_label;

            // Wiil add 'wpt-mobile-label-show' claas which will help to display column label in mobile @by Fazle Bari  
            if( $this->is_column_label =='show' ){
                $this->generated_td_start = '<td class="wpt-replace-td-in-tr wpt-mobile-label-show">';
            }else{
                $this->generated_td_start = '<td class="wpt-replace-td-in-tr">';
            }
            
            $this->generated_td_end = '</td>';
        }

        if($this->filter){
            $this->generate_taxo_n_row_attr( $this->filter );
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

    /**
     * This method is for Mini filter. Wich only work on Visible product.
     * 
     * Nothing Else
     *
     * @param Array $filter
     * @return void
     */
    protected function generate_taxo_n_row_attr( $filter ){
        if( empty( $filter ) ) return;
        if( is_string( $filter ) ){
            $filter = $this->string_to_array( $filter );
        }
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
            $this->row_attr .= $attr . '"' . $attr_value . '" ';
        }

    }

    
    public function render(){
        /**
         * Row class assing at the before of 
         * @Hook wpt_table_row
         * 
         * because, we can be need assinging something on class.
         */
        $this->tr_class = Table_Attr::tr_class( $this );

        global $product;
        $this->row_attr = apply_filters('wpt_table_row_attr', $this->row_attr, $this);
        
        /**
         * Total Row Handle from Here
         * Using action hook.
         * 
         * @since 3.3.2.0
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        $this->do_action('wpt_table_row');

        if( ! $this->display ) return;
        
        if($this->wp_force){
            wp('p=' . $this->product_id . '&post_type=product');
        }
        extract($this->data_for_extract());

        ?>
        <tr
        class="<?php echo esc_attr( $this->tr_class ); ?>"
        data-title="<?php echo esc_attr( $this->product_title ); ?>"
        id="product_id_<?php echo esc_attr( $this->product_id ); ?>"
        data-product_id="<?php echo esc_attr( $this->product_id ); ?>"
        data-temp_number="<?php echo esc_attr( $this->table_id ); ?>"
        data-type="<?php echo esc_attr( $this->product_type ); ?>"
        data-parent_id="<?php echo esc_attr( $this->product_parent_id ); ?>"
        data-quantity="<?php echo esc_attr( $this->default_quantity ); ?>"
        data-href="<?php echo esc_url( $this->product_permalink ); ?>"
        data-product_variations="<?php echo esc_attr( htmlspecialchars( wp_json_encode( $this->available_variations ) ) ); ?>"
        additional_json=""
        <?php echo $this->row_attr; ?>
        role="row">
        <?php

        echo $this->generated_td_start;

        foreach( $this->_enable_cols as $keyword => $col ){

            /**
             * Additional data added
             * specially for each td
             * where we will keep td keyword data inside row object
             * 
             * @since 3.4.1.0
             */
            $this->td_keyword = $keyword;
            
            $settings = $this->column_settings[$keyword] ?? false;
            $items = $settings['items'] ?? false;
            $class_iner_avail = ! empty( $items ) ? 'inner-available' : 'no-inner';
            
            $type = isset( $settings['type'] ) && !empty( $settings['type'] ) ? $settings['type'] : 'default';
            $file_name = $type !== 'default' ? $type : $keyword;
            
            $items_directory = $this->apply_filter( 'wpt_template_folder', $this->items_directory );

            //This will be removed in future update actually
            $items_directory = apply_filters('wpto_template_folder', $items_directory,$keyword, $type, $this->table_id, $product, $settings, $this->column_settings );
            
            

            $file = $items_directory. $file_name . '.php';

            $file = apply_filters( 'wpto_template_loc', $file, $keyword, $type, $this->table_id, $product, $file_name, $this->column_settings, $settings ); 
            $file = apply_filters( 'wpto_template_loc_type_' . $type, $file, $keyword, $this->table_id, $product, $file_name, $this->column_settings, $settings ); 
            $file = apply_filters( 'wpto_template_loc_item_' . $keyword, $file, $this->table_id, $product, $file_name, $this->column_settings, $settings ); 


            /**
             * Only @Hook wpt_template_loc Added for new 
             * Organized Plugin.
             * 
             * Why we keept old filter hook
             * Actually we did lot of custom work for many user,
             * So we need to kept it. But in future, We will delete old filter hook
             */
            $file = $this->apply_filter( 'wpt_template_loc', $file );

            /**
             * File Template Final Filter 
             * We have created this to make a new features, Where user will able to load template from Theme's Directory
             * 
             * To Load a new template of item from Theme, Use following location
             * [YourTheme]/woo-product-table/items/[YourItemFileName].php
             * 
             * Functionality Added at includes/functions.php file.
             */
            $file = apply_filters( 'wpto_item_final_loc', $file, $file_name, $items_directory, $keyword, $this->table_id, $settings, $this->items_permanent_dir );


            $style_str = $this->column_settings[$keyword]['style_str'] ?? '';
            $style_str = ! empty( $style_str ) ? preg_replace('/(;|!important;)/i',' !important;',$style_str) : '';
        
            $column_title = $this->column_array[$keyword] ?? '';
            if( $keyword == 'check' ){
                $column_title = '';
            }

            /**
             * ***********************
             *  IMPORTANT NOTICE:
             * ***********************
             * Remembered: in class name, 
             * obvously need td_or_cell class at the beggining of class list
             * because we have managed responsive mater using javascript and 
             * we repalce it with '<td class="td_or_cell'
             * So we unable to change, need td_or_cell at the beggining
             * 
             * @author Saiful Islam <codersaiful@gmail.com>
             */
            $td_class = Table_Attr::td_class($keyword, $this);
            ?>
            <<?php echo $this->td_tag; ?> class="td_or_cell <?php echo esc_attr($class_iner_avail . ' ' .$td_class ); ?>"
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
            
            //I have removed prev style, where was $keyword as first parametter.
            do_action( 'wpt_column_top', $this );
            
            $tag = ! empty( $settings['tag'] ) ? $settings['tag'] : 'div';
            $tag_class = $settings['tag_class'] ?? '';
            if( $this->is_column_label ){
                $tag_class .= ' item_inside_cell wpt_' . $keyword;
                $tag_class .= ' autoresponsive-label-show';
            }

            ?>
            <<?php echo esc_html( $tag ); ?> 
            data-keyword="<?php echo esc_attr( $keyword ) ; ?>"
            data-title="<?php echo esc_attr( $column_title ); ?>"
            data-sku="<?php echo esc_attr( $this->product_sku ); ?>"
            class="<?php echo esc_attr( $tag_class ); ?>">
                <?php 
                ob_start();
                if( is_file( $file ) ){
                    include $file;
                }
                $td_content = ob_get_clean();
                /**
                 * By this filter hook `wpt_td_content` 
                 * user able to change Whole content of TD Content of Each Row.
                 * 
                 * Usase:
                 * 
                 add_filter('wpt_td_content', function($content, $Row, $column_key){
                    //$product_id = $Row->product_id;
                    //$product_id = $Row->td_keyword;
                    //vard_dump($Row); //Checkout to get all others property of this $Row object.
                    if($column_key == '_price'){
                        $content = "BDT $content" . ' taka';
                    }
                    return $content;
                 }, 10, 3);
                 * 
                 * @Hook `wpt_td_content`
                 * @since 3.4.7.2 
                 * @author Saiful Islam <codersaiful@gmail.com>
                 */
                echo apply_filters( 'wpt_td_content', $td_content, $this, $keyword );
                ?>
            </<?php echo esc_html( $tag ); ?>>
            
            <?php

            
            $this->handle_inner_items( $keyword, $items );

            /**
             * Adding Content at the Bottom of Each TableTD
             * 
             * 
             * This wpto_ hook will be removed in future update
             */
            do_action( 'wpto_column_bottom', $keyword, $this->table_id, $settings, $this->column_settings, $product );
            //I have removed prev style, where was $keyword as first parametter.
            //Old code: do_action( 'wpt_column_bottom', $keyword, $this );
            do_action( 'wpt_column_bottom', $this );
            ?>
            </<?php echo $this->td_tag; ?>><!--EndTd-->
            <?php
            
        }
        echo $this->generated_td_end;
        ?>
        </tr>
        <?php

        // var_dump($this);
    }

    /**
     * Handle Innter item based on current keyword and items array.
     *
     * @param string $parent_keyword
     * @param array $items
     * @return void
     */
    public function handle_inner_items( string $parent_keyword, $items = [] ){
        if( empty($parent_keyword ) ) return;

        if( empty( $items ) || ! is_array( $items ) ) return;
        foreach( $items as $item_key ){
            $this->inner_each_item( $item_key, $parent_keyword );
        }
    }
    public function inner_each_item( string $keyword, string $parent_keyword ){
        global $product;
        extract($this->data_for_extract());



        $settings = $this->column_settings[$keyword] ?? false;
            
        $type = isset( $settings['type'] ) && !empty( $settings['type'] ) ? $settings['type'] : 'default';


        $file_name = $type !== 'default' ? $type : $keyword;
            
        $items_directory = $this->apply_filter( 'wpt_template_folder', $this->items_directory );

        //This will be removed in future update actually
        $items_directory = apply_filters('wpto_template_folder', $items_directory,$keyword, $type, $this->table_id, $product, $settings, $this->column_settings );
        
        

        $file = $items_directory. $file_name . '.php';
        $file = apply_filters( 'wpto_template_loc', $file, $keyword, $type, $this->table_id, $product, $file_name, $this->column_settings, $settings ); 
        $file = apply_filters( 'wpto_template_loc_type_' . $type, $file, $keyword, $this->table_id, $product, $file_name, $this->column_settings, $settings ); 
        $file = apply_filters( 'wpto_template_loc_item_' . $keyword, $file, $this->table_id, $product, $file_name, $this->column_settings, $settings ); 


        /**
         * Only @Hook wpt_template_loc Added for new 
         * Organized Plugin.
         * 
         * Why we keept old filter hook
         * Actually we did lot of custom work for many user,
         * So we need to kept it. But in future, We will delete old filter hook
         */
        $file = $this->apply_filter( 'wpt_template_loc', $file );

        /**
         * File Template Final Filter 
         * We have created this to make a new features, Where user will able to load template from Theme's Directory
         * 
         * To Load a new template of item from Theme, Use following location
         * [YourTheme]/woo-product-table/items/[YourItemFileName].php
         * 
         * Functionality Added at includes/functions.php file.
         */
        $file = apply_filters( 'wpto_item_final_loc', $file, $file_name, $items_directory, $keyword, $this->table_id, $settings, $this->items_permanent_dir );


        $tag = ! empty( $settings['tag'] ) ? $settings['tag'] : 'div';;
        $tag_class = $settings['tag_class'] ?? '';
        // $tag_class .= Table_Attr::td_class($keyword, $this);
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
        
        $parent_column_settings = $column_settings[$parent_keyword];

        do_action( 'wpto_item_top', $keyword, $table_ID, $settings, $column_settings, $parent_column_settings, $product );
                
        ob_start();
        if( is_file( $file ) ){
            include $file;
        }

        $td_content = ob_get_clean();

        /**
         * By this filter hook `wpt_item_content` 
         * user able to change Whole content of TD Content of Each Row.
         * 
         * Usase:
         * 
         add_filter('wpt_item_content', function($content, $Row, $item_key){
            //$product_id = $Row->product_id;
            //$product_id = $Row->td_keyword;
            //vard_dump($Row); //Checkout to get all others property of this $Row object.
            if($item_key == '_price'){
                $content = "BDT $content" . ' taka';
            }
            return $content;
            }, 10, 3);
        * 
        * @Hook `wpt_item_content`
        * @since 3.4.7.2 
        * @author Saiful Islam <codersaiful@gmail.com>
        */
        $td_content = apply_filters( 'wpt_item_content', $td_content, $this, $keyword, $parent_keyword );

        /**
         * By this filter hook `wpt_td_content` 
         * user able to change Whole content of TD Content of Each Row.
         * 
         * Usase:
         * 
         add_filter('wpt_td_content', function($content, $Row, $column_key){
            //$product_id = $Row->product_id;
            //$product_id = $Row->td_keyword;
            //vard_dump($Row); //Checkout to get all others property of this $Row object.
            if($column_key == '_price'){
                $content = "BDT $content" . ' taka';
            }
            return $content;
            }, 10, 3);
        * 
        * @Hook `wpt_td_content`
        * @since 3.4.7.2 
        * @author Saiful Islam <codersaiful@gmail.com>
        */
        echo apply_filters( 'wpt_td_content', $td_content, $this, $keyword );

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
        $serial = ( ($this->page_number - 1) * $this->posts_per_page ) + $this->serial_number;
        
        $this->avialable_variables = [
            'id' => $this->product_id,
            'args' => $this->args,
            'table_type' => $this->table_type,
            'product_type' => $this->product_type,
            'temp_number' => $this->table_id,
            'table_ID' => $this->table_id,
            'data' => $this->product_data,
            'config_value' => $this->table_config,
            'column_settings' => $this->column_settings,
            'column_array' => $this->column_array,
            'checkbox' =>  $this->checkbox,
            'table_column_keywords' => $this->_enable_cols,
            'ajax_action' => $this->ajax_action,
            'add_to_cart_text' => $this->add_to_cart_text,
            'default_quantity' => $this->default_quantity,
            'stock_status' => $this->product_stock_status,
            'stock_status_class' => $this->product_stock_status_class,
    
            'description_type' => $this->description_type,
            '_device' => $this->_device,
            //For Variable Product
            'attributes' => $this->attributes,
            'available_variations' => $this->available_variations,
            'variable_for_total' => $this->variable_for_total,
    
    
            'row_class' => $this->row_class,
            'wpt_table_row_serial' => $serial,
        ];

        return $this->apply_filter( 'wpt_avialable_variables', $this->avialable_variables );
    }
}