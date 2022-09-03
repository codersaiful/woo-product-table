<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WOO_PRODUCT_TABLE\Core\Base;
class Shortcode_Base extends Base{
    public $_root = __CLASS__;
    public $shortcde_text = 'SAIFUL_TABLE';

    public $items_directory;
    public $items_permanent_dir;

    
    protected function unsetArrayItem( Array $arr, $unset_item ){
        if( ! isset( $arr[$unset_item] ) ) return $arr;

        unset($arr[$unset_item]);
        return $arr;
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
    protected function get_meta( string $meta_key ){
        $data = get_post_meta( $this->table_id, $meta_key, true );
        return is_array( $data ) ? $data : [];
    }

    
}