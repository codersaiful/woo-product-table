<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WOO_PRODUCT_TABLE\Core\Base;
class Shortcode_Base extends Base{
    public $_root = __CLASS__;
    public $shortcde_text = 'Product_Table';

    public $base_config;
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

    public $footer_cart_selected;

    
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
        $this->table_on_variable = ! empty( $table_on_variable );
        
<<<<<<< HEAD
        $this->footer_cart_template = $this->base_config['footer_template'] ?? 'none';

=======
        $this->footer_cart_template = $this->base_config['footer_cart_template'] ?? 'none';
        
>>>>>>> 44595c61fd7718a814f2afbe45f2710a3d6021bd
        // $footer_cart_selected = $this->base_config['footer_cart_selected'] ?? __( 'Carting' );
        // $this->footer_cart_selected = ! empty( $footer_cart_selected );
        $this->footer_cart = $this->base_config['footer_cart_on_of'] ?? false;
        //$this->footer_cart = true;
        
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
        global $post;
        $this->has_shortcode = isset($post->post_content) && has_shortcode( $post->post_content, $this->shortcde_text );

        if( $this->has_shortcode ) return true;
        if( $this->table_on_archive && ( is_shop() || is_product_taxonomy() ) ) return true;
        
        if( is_product() && $this->table_on_variable ){
            $product = wc_get_product($post->ID);
            return $product->get_type() == 'variable';  //It's actually boolean return.
        }

        $id = get_queried_object_id();
        $taxo_table_id = get_term_meta( $id, 'table_id', true );
        if( is_product_taxonomy() && ! empty( $taxo_table_id ) ) return true;

        

        return;
    }

}