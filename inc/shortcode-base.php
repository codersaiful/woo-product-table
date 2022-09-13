<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WOO_PRODUCT_TABLE\Core\Base;
class Shortcode_Base extends Base{
    public $_root = __CLASS__;
    public $shortcde_text = 'Product_Table';

    public $base_config;
    public $table_on_archive;

    public $items_directory;
    public $items_permanent_dir;


    public $footer_cart_template;

    
    protected function unsetArrayItem( Array $arr, $unset_item ){
        if( ! isset( $arr[$unset_item] ) ) return $arr;

        unset($arr[$unset_item]);
        return $arr;
    }

    public function __construct()
    {
        $this->base_config = wpt_get_config_value();
        $this->table_on_archive = $this->base_config['table_on_archive'] ?? false;
        $this->footer_cart_template = $this->base_config['footer_template'] ?? 'none';
        
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

}