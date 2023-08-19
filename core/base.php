<?php 
namespace WOO_PRODUCT_TABLE\Core;

class Base{
    public $_root = __CLASS__;
    public $plugin_prefix = 'wpt';
    public $dev_version = WPT_DEV_VERSION;
    public $base_url = WPT_BASE_URL;
    public $base_dir = WPT_BASE_DIR;
    public $assets_url = WPT_ASSETS_URL;

    public $data_packed;

    /**
     * Collection of add action
     *
     * @var array
     */
    public $add_action = [];
    /**
     * Collection of do action
     *
     * @var array
     */
    public $do_action = [];

    /**
     * Collection of Filter Hook
     *
     * @var array
     */
    public $add_filter = [];
    /**
     * Collection of Apply Filter Hook
     *
     * @var array
     */
    public $apply_filter = [];

    /**
     * Remove Empty Array from Array
     * If found any value Empty, It will remove that item of that array
     *
     * @param Array $arr Required Item.
     * @return Array
     */
    protected function arrayFilter( Array $arr ){
        if( is_array( $arr ) ){
            $arr = array_filter( $arr, function( $item ){
                return ! empty( $item );
            });
        }else{
            $arr = [];
        }
        return $arr;
    }

    /**
     * Add new array inside an existing array to the specific poistion.
     * Bydeautl, for not found, new array will at the bottom.
     * although It's possible to add at the first, for that
     * $bottom value to be false.
     * 
     * *********************
     * I have taken help from Dokan plugin of wedev to create this method.
     * in Dokan, there is a function like: dokan_array_insert_after()
     * I have taken idea from this function.
     * **********************
     *
     * @author Saiful Islam <codersaiful@gmail.com>
     * @package Woo_Product_Table
     * @since 3.2.5.5
     * 
     * @param array $existing_array
     * @param array $new_array
     * @param string $target_array_key
     * @param bool true|false Default value true, if false, it will at the beginign of, if not found existing key.
     * @return array It will return final array with adding new element.
     */
    public function array_insert_before( array $existing_array, array $new_array, string $target_array_key, bool $bottom = true ) {
        $keys   = array_keys( $existing_array );
        $index  = array_search( $target_array_key, $keys, true );
        // $pos    = false === $index ? 0 : $index; //if not found target index of array, this will add array at the begining.
        //$pos    = false === $index ? count($keys) : $index; //If not found, array will at the last 
        
        /**
         * uporer duita condition ke notun param er jayajje korechi, jate dutoi kora jay.
         * asole bottom true hole, not found key er khetre laste add korobe
         * ar false hole total array'r surute add korobe.
         */
        $count = $bottom ? count($keys) : 0;        
        $pos    = false === $index ? $count: $index; //If not found, array will at the last 
    
        return array_slice( $existing_array, 0, $pos, true ) + $new_array + array_slice( $existing_array, $pos, count( $existing_array ), true );
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
        
        $this->do_action[] = $action_hook;
        
        /**
         * To Insert Content at Top of the Table, Just inside of Wrapper tag of Table
         * Available Args $table_ID, $args, $config_value, $atts;
         */
        do_action( $action_hook, $this ); //$default_ouptput,

    }

    /**
     * Our Filter Hook define, Only for this Object/Class 
     * It will not use any other place actually.
     * It will call only here inside Shortcode Class
     *
     * @param string $filter_hook filter hook keyword
     * @param boolean|array|string|null|object $ouptput It's can be any type of data. which we want to store as filter hook
     * @return string|null|boolean|bool|object|int|float|this|null 
     */
    public function apply_filter( string $filter_hook, $ouptput = false ){
        $this->apply_filter[] = $filter_hook;
        return apply_filters( $filter_hook, $ouptput, $this );
    }

    /**
     * Calling Action Hook
     *
     * @param string $action_hook_name [Required] and make a method by this name
     * @param integer $accepted_args [Optional]
     * @param integer $priority [Optional]
     * @param string $method_name [Optional] Actually Default method as same as hook name
     * @return void
     */
    protected function action( string $action_hook_name, int $accepted_args = 1, int $priority = 10,  string $method_name = '' ){
        $this->hook('add_action', $action_hook_name, $accepted_args, $priority, $method_name);
    }

    /**
     * Calling Filter Hook. Call like $this->filter('hook_name') and create a method with the name 
     * 'hook_name', but if you want method name will different,
     * than set 2nd,3rd and 4th param. 4th param will be method name param. 
     *
     * @param string $filter_hook_name [Required] and make a method by this name
     * @param integer $accepted_args [Optional]
     * @param integer $priority [Optional]
     * @param string $method_name [Optional] Actually Default method as same as hook name
     * @return string|null|boolean|bool|object|int|float|this|null
     */
    protected function filter( string $filter_hook_name, int $accepted_args = 1, int $priority = 10,  string $method_name = '' ){
        $this->hook('add_filter', $filter_hook_name, $accepted_args, $priority, $method_name);
    }
    
    protected function hook( string $hook_type, string $action_hook_name, int $accepted_args = 1, int $priority = 10,  string $method_name = '' ){
        if( empty( $method_name ) ){
            $method_name = $action_hook_name;
        }

        if( ! method_exists($this,$method_name) ) return;
        $this->$hook_type[] = $action_hook_name;
        $hook_type( $action_hook_name, [$this, $method_name], $priority, $accepted_args );
    }

    /**
     * For non-exist property
     *
     * @param string $name
     * @return [any]|string|null|boolean|bool|object|int|float|this|null
     */
    public function __get( $name ){
        return $this->data_packed[$name] ?? null;
    }

    /**
     * For non exist property
     *
     * @param string $name
     * @param [any]|string|null|boolean|bool|object|int|float|this|null $value
     */
    public function __set($name, $value){
        $this->data_packed[$name] = $value;
    }

    /**
     * If call and undefiend property 
     * and check by isset, then if found, it will show output, oherwise it will return null.
     * 
     * Actually It's very important for big project
     * 
     * @author Saiful Islam <codersaiful@gmail.com>
     *
     * @param string $name
     * @return mixed|null
     */
    public function __isset($name)
    {
        return $this->data_packed[$name] ?? null;
    }
}