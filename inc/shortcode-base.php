<?php 
namespace WOO_PRODUCT_TABLE\Inc;

class Shortcode_Base{
    public $_root = __CLASS__;

    
    protected function unsetArrayItem( Array $arr, $unset_item ){
        if( ! isset( $arr[$unset_item] ) ) return $arr;

        unset($arr[$unset_item]);
        return $arr;
    }

    /**
     * Remove Empty Array from Array
     * If found any value Empty, It will remove that item of that array
     *
     * @param Array $arr Required Item.
     * @return Array
     */
    protected function arrayFilter( Array $arr ){
        if( is_array( $arr ) ){
            $args = array_filter( $arr, function( $item ){
                return ! empty( $item );
            });
        }else{
            $arr = [];
        }
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

    /**
     * Declear Do_Action for inside shortcode Table
     * Here we will take only one Variable, that is 
     * this Class Object as param
     *
     * @param string $action_hook action hook keyword
     * @param boolean $default_ouptput for do_action, normally we will not return anything, if need we can add it.
     * @return void
     */
    public function do_action( string $action_hook ){
        ob_start();
        /**
         * To Insert Content at Top of the Table, Just inside of Wrapper tag of Table
         * Available Args $table_ID, $args, $config_value, $atts;
         */
        do_action( $action_hook, $this ); //$default_ouptput,
        return ob_get_clean();
    }

    /**
     * Our Filter Hook define, Only for this Object/Class 
     * It will not use any other place actually.
     * It will call only here inside Shortcode Class
     *
     * @param string $filter_hook filter hook keyword
     * @param boolean|array|string|null|object $ouptput It's can be any type of data. which we want to store as filter hook
     * @return boolean|array|string|null|object 
     */
    public function apply_filter( string $filter_hook, $ouptput = false ){
        return apply_filters( $filter_hook, $ouptput, $this );
    }
}