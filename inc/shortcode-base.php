<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WOO_PRODUCT_TABLE\Core\Base;
class Shortcode_Base extends Base{
    public $_root = __CLASS__;
    public $shortcde_text = 'Product_Table';

    /**
     * actually public $table_id is not available here
     * it will override at extened class
     *
     * @var null|int It's actually int number ot post id for woo_product_table post_type
     */
    public $table_id = 0;
    
    /**
     * Very important Property, 
     * Default is true, But somethime, we need to disable table. 
     * Then we can set property value false,
     * Table will be hide.
     *
     * @var boolean
     */
    public $table_display = true;

    public $product_notfound = false;

    /**
     * For Table's basics Settings such as:
     * ajax_action,checkout_url, site_url
     * Actually in custom.js file, 
     * ajax_action data need on Add to cart botton when third party plugin support enabled.
     * 
     * It has shown as attribute on main div tag of table. 
     * Available at inc/shortcode.php file.
     * 
     * Value assing at shartup loader of Shortcode Class/Object 
     *
     * @var array
     */
    public $basic_settings;

    /**
     * Configuration Page Setting, It's not based on Each Table Setting.
     * It's come from Configuration page
     * 
     * Same as $this->_config 
     * Actually $this->base_config this will come from configuration page and
     * $this->_config will come configuration based on Table ID. Speciall from Configuration tab.
     *
     * @var array
     */
    public $base_config;

    public $wpml_bool;
    public $wpml_lang;
    public $wpml_default_lang;

    public $table_on_archive;
    public $table_on_variable;

    /**
     * For checking shortcode available or not
     *
     * @var [type]
     */
    public $has_shortcode;

    public $items_directory;
    public $items_permanent_dir;


    /**
     * There are lot's of template ob background available for
     * footer template. If set no template,
     * there will apply table template wise color
     * otherwise, if set any template, then it will show
     * background color based on template
     * 
     * PLAN:
     * --------
     * I will set color at dashboard
     * and it will come from setting
     * and I will set anywhere. not planed yet
     * 
     * DONE
     * ---------
     * Plan executed
     *
     * @var string
     */
    public $footer_cart;
    public $footer_cart_template;

    /**
     * Website used and activated theme.
     * Actually sometime, we need to check compatblitity with theme
     *
     * @var string
     */
    public $site_theme;

    public $is_pro = false;


    
    protected function unsetArrayItem( Array $arr, $unset_item ){
        if( ! isset( $arr[$unset_item] ) ) return $arr;

        unset($arr[$unset_item]);
        return $arr;
    }

    public function __construct()
    {
        $this->base_config = wpt_get_config_value();
        $table_on_archive = $this->base_config['table_on_archive'] ?? false;
        $this->table_on_archive = ! empty( $table_on_archive );
        $table_on_variable = $this->base_config['variation_table_id'] ?? false;

        /**
         * Variation table on of  now easy using filter.
         * If enable from filter and return a ID of Table, that will show in Variable Product. 
         */
        $table_on_variable = apply_filters( 'wpt_variation_table_id', $table_on_variable );
        
        $this->table_on_variable = ! empty( $table_on_variable ) ? $table_on_variable : false;

        $footer_cart_template = $this->base_config['footer_cart_template'] ?? 'none';
        $this->footer_cart_template = $this->apply_filter( 'wpt_footer_cart_template', $footer_cart_template );


        $this->footer_cart = isset($this->base_config['footer_cart_on_of']) ? false : true ;
        
        
        $this->site_theme =  get_template();

        $this->wpml_lang = apply_filters( 'wpml_current_language', NULL );
        $this->wpml_default_lang = apply_filters('wpml_default_language', NULL );
        $this->wpml_bool = $this->wpml_lang == $this->wpml_default_lang ? false : true;

        $this->is_pro = class_exists( 'WOO_Product_Table' );
    }
    

    /**
     * Getting meta value,
     * which need as array actually
     * 
     * use:
     * $this->basic = $this->get_meta('basics');
     * 
     * used for:
     * $basics = get_post_meta( $ID, 'basics', true );
     * get_post_meta( $ID, 'table_style', true );
     * 
     * @since 3.2.4.1
     *
     * @param string $meta_key it to be meta key. It will retrive data from our table post
     * @return array
     */
    public function get_meta( string $meta_key ){
        $data = get_post_meta( $this->table_id, $meta_key, true );
        return is_array( $data ) ? $data : [];
    }

    /**
     * Checking product table available or not. 
     * Actually we have checked using post content search and 
     * basic features of configuration page.
     * 
     * Now we have to check, If it available on variation page of variable product
     * 
     * 
     *
     * @return void
     */
    protected function get_is_table(){
        return has_filter('wpt_bottom');
        // global $post;
        // $this->has_shortcode = isset($post->post_content) && has_shortcode( $post->post_content, $this->shortcde_text );

        // if( $this->has_shortcode ) return true;
        // if( $this->table_on_archive && ( is_shop() || is_product_taxonomy() ) ) return true;
        
        // if( is_product() && $this->table_on_variable ){
        //     $product = wc_get_product($post->ID);
        //     return $product->get_type() == 'variable';  //It's actually boolean return.
        // }

        // $id = get_queried_object_id();
        // $taxo_table_id = get_term_meta( $id, 'table_id', true );
        // if( is_product_taxonomy() && ! empty( $taxo_table_id ) ) return true;

        

        // return;
    }

    /**
     * To check Table's Object VAR dump
     * with Security key 
     * keyWill = var_dump_table
     * and value will be sAiFul-CoDeAsTrOlOGy
     *
     * @return void
     */
    protected function get_var_for_Dev(){
        if( ! isset( $_GET['var_dump_table'] ) ) return;
        $var = $_GET['var_dump_table'] ?? '';
        if( 'sAiFul-CoDeAsTrOlOGy' !== $var ) return;
        
        $property = $_GET['property'] ?? '';
        $method = $_GET['method'] ?? '';
        echo '<pre>';
        if( ! empty( $property ) ){
            print_r( $this->$property );
        }
        if( ! empty( $method ) && method_exists($this, $method) ){
            print_r( $this->$method() );
        }

        var_dump($this);


        echo '</pre>';
    }

    
}