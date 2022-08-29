<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WOO_PRODUCT_TABLE\Inc\Handle\Message as Msg;
use WOO_PRODUCT_TABLE\Inc\Handle\Args;
use WOO_PRODUCT_TABLE\Inc\Handle\Table_Attr;

class Shortcode{

    public $shortcde_text = 'SAIFUL_TABLE';
    public $atts;
    public $table_id;
    public $status;
    public $post_type;
    public $req_post_type = 'wpt_product_table';
    public $posts_per_page = 20;
    public $table_type = 'normal_table';

    public $is_table;
    public $_device;
    public $_config;
    public $args;

    public $_enable_cols;
    public $column_array;
    public $column_settings;

    public $basics;
    public $basics_args;

    public $search_n_filter;
    public $conditions;
    public $pagination;


    public $post_include;
    public $post_exclude;
    public $min_price;
    public $max_price;
    public $minicart_position;
    public $add_to_cart_text;
    public $pagination_ajax;
    public $checkbox;
    public $template;

    public $wrapper_class;

    

    public function run(){
        add_shortcode( $this->shortcde_text, [$this, 'shortcode'] );
    }
    public function shortcode($atts){
        $this->atts = $atts;

        $pairs = array( 'exclude' => false );
        extract( shortcode_atts( $pairs, $atts ) );
        
        $this->assing_property($atts);
        // var_dump($this);
        ob_start();

        

        ?>
        <div data-checkout_url="<?php echo esc_url( wc_get_checkout_url() ); ?>" 
        data-temp_number="<?php echo esc_attr( $this->table_id ); ?>" 
        data-add_to_cart="<?php echo esc_attr( $this->add_to_cart_text ); ?>" 
        data-site_url="<?php echo esc_url( site_url() ); ?>" 
        id="table_id_<?php echo esc_attr( $this->table_id ); ?>" 
        class="<?php echo esc_attr( Table_Attr::wrapper_class( $this ) ); ?>">
            <h1 class="test_title">Test Titlte</h1>
            <div class="wpt_table_tag_wrapper">
                <table 
                data-page_number=""
                data-temp_number=""
                data-config_json=""
                data-data_json=""
                data-data_json_backup=""
                id="wpt_table"
                class="<?php echo esc_attr( Table_Attr::table_class( $this ) ); ?>">

                </table>
            </div>

        </div>
        
        <?php 
        

        return ob_get_clean();
    }

    public function assing_property( $atts ){
        

        $this->table_id = isset( $atts['id'] ) && !empty( $atts['id'] ) ? (int) $atts['id'] : 0; 
        $this->table_id = apply_filters( 'wpml_object_id', $this->table_id, $this->req_post_type, TRUE  );
        $this->status = get_post_status( $this->table_id );
        $this->post_type = get_post_type( $this->table_id );

        // set_query_var( 'woo_product_table', $this->table_id );
        set_query_var( $this->req_post_type, $this->table_id );

        $this->is_table = $this->table_id && $this->post_type == $this->req_post_type && $this->status == 'publish';
        if( ! $this->is_table ){
            return Msg::not_found($this);
        }

          


        $this->_config = wpt_get_config_value( $this->table_id );
        $this->_device = wpt_col_settingwise_device( $this->table_id );
        $this->_enable_cols = get_post_meta( $this->table_id, 'enabled_column_array' . $this->_device, true );
        $this->column_array = get_post_meta( $this->table_id, 'column_array' . $this->_device, true );
        $this->column_settings = get_post_meta( $this->table_id, 'column_settings' . $this->_device, true);
        

        //we will removed this filter after few version. 
        $this->_enable_cols = apply_filters( 'wpto_enabled_column_array', $this->_enable_cols, $this->table_id, $this->atts, $this->column_settings, $this->column_array );
        /**
         * @Hook Filter wpto_enabled_column_array to change or modify column amount, we can use it.
         */
        $this->_enable_cols = apply_filters('wpt_enabled_column', $this->_enable_cols, $this);



        if( empty( $this->_enable_cols ) ){
            return Msg::not_found_cols($this);
        }


        $this->basics = $this->get_meta( 'basics' );
        $this->basics_args = $this->get_meta( 'args' );
        $this->conditions = $this->get_meta( 'conditions' );
        $this->table_style = $this->get_meta( 'table_style' );
        
        $this->search_n_filter = $this->get_meta( 'search_n_filter' );
        $this->pagination = $this->get_meta( 'pagination' );

        $this->posts_per_page = $this->conditions['posts_per_page'] ?? $this->posts_per_page;
        $this->table_type = $this->conditions['table_type'] ?? $this->table_type;


        //Some Basic Meta Values | All other query related available in Args Class
        $this->minicart_position = $this->basics['minicart_position'] ?? '';
        $this->add_to_cart_text = $this->basics['add_to_cart_text'] ?? '';//$basics['add_to_cart_text'] ?? ''
        $this->pagination_ajax = $this->basics['pagination_ajax'] ?? '';
        $this->checkbox = $this->basics['checkbox'] ?? 'wpt_no_checked_table'; //$checkbox = isset( $basics['checkbox'] ) && !empty( $basics['checkbox'] ) ? $basics['checkbox'] : 'wpt_no_checked_table';

        //Some others from other meta
        $this->template = $this->table_style['template'] ?? '';

        
        $this->args = Args::manage($this);

        //This Filter will be deleted in future update
        $this->args = apply_filters( 'wpto_table_query_args', $this->args, $this->table_id, $this->atts, $this->column_settings, $this->_enable_cols, $this->column_array );

        /**
         * @Hook filter wpt_query_args manage wpt table query args using filter hook
         */
        $this->args = $this->apply_filter( 'wpt_query_args', $this->args );
    }

    public function set_shortcde_text( string $shortcde_text ){
        $this->shortcde_text = $shortcde_text;
        return $this;
    }
    public function get_shortcde_text(){
        return $this->shortcde_text;
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
    private function get_meta( string $meta_key ){
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
    public function do_action( string $action_hook, $default_ouptput = false ){
        ob_start();
        /**
         * To Insert Content at Top of the Table, Just inside of Wrapper tag of Table
         * Available Args $table_ID, $args, $config_value, $atts;
         */
        do_action( $action_hook, $default_ouptput, $this );
        return ob_get_clean();
    }

    /**
     * Our Filter Hook define, Only for this Object/Class 
     * It will not use any other place actually.
     * It will call only here inside Shortcode Class
     *
     * @param string $filter_hook filter hook keyword
     * @param boolean|array|string|null $ouptput It's can be any type of data. which we want to store as filter hook
     * @return boolean|array|string|null 
     */
    public function apply_filter( string $filter_hook, $ouptput = false ){
        return apply_filters( $filter_hook, $ouptput, $this );
    }
}