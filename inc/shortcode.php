<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WOO_PRODUCT_TABLE\Inc\Handle\Message as Msg;
use WOO_PRODUCT_TABLE\Inc\Handle\Args;
use WOO_PRODUCT_TABLE\Inc\Handle\Pagination;
use WOO_PRODUCT_TABLE\Inc\Handle\Search_Box;
use WOO_PRODUCT_TABLE\Inc\Handle\Table_Attr;
use WOO_PRODUCT_TABLE\Inc\Handle\Enqueue;
use WOO_PRODUCT_TABLE\Inc\Table\Row;
use WOO_PRODUCT_TABLE\Inc\Features\Basics;

class Shortcode extends Shortcode_Base{

    public $_root = __CLASS__;
    
    private $assing_property = false;

    /**
     * If not passed over filter hook 
     * the args Attribute.
     *
     * @var bool|null
     */
    public $args_organized;
    public $args_ajax_called;
    public $atts;
    public $table_id;
    public $status;
    public $post_type;
    public $req_post_type = 'wpt_product_table';
    public $posts_per_page = 20;
    public $table_type = 'normal_table';

    public $is_table;
    public $page_number = 1;


    /**
     * Check column available or not, if empty array of _enable_cols, it will return false.
     *
     * @var boolean
     */
    public $is_table_head = true;
    public $is_table_column = true;
    public $_device;
    public $args;

    public $_enable_cols;
    public $col_count;
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

    /**
     * For enequeue name, we will use this
     *
     * @var string|null
     */
    public $template_name;
    // /whole_search/search_box/hide_input

    public $search_box;

    /**
     * Search Area selected from whole site or on selected category
     *
     * @var [type]
     */
    public $whole_search;

    /**
     * Actually Hide Inputbox from Search Box Area
     * Advance Search Box area.
     *
     * @var string|bool
     */
    public $hide_input;


    public $filter_box;
    public $filter;

    public $orderby;
    public $order;
    public $meta_value_sort;

    public $table_style;
    public $_config;
    public $wrapper_class;
    public $table_class;
    public $is_column_label = false;


    public function run(){

        add_shortcode( $this->shortcde_text, [$this, 'shortcode'] );

        /**
         * All lf our Ajax for our Table/Shortcode will handle from
         * Shortcode_Ajax().
         * 
         * We have extended here Our this Class/Shortcode Class
         * 
         * @since 3.2.5.0
         */
        new Shortcode_Ajax();
                
        $basics = new Basics();
        $basics->run();

        $enequeue = new Enqueue();
        $enequeue->run();
    }
    public function shortcode($atts){
        
        $this->atts = $atts;

        $pairs = array( 'exclude' => false );
        extract( shortcode_atts( $pairs, $atts ) );
        
        $this->assing_property($atts);
        $this->startup_loader($atts);
        
        // var_dump($this);
        ob_start();

        ?>
        <div data-checkout_url="<?php echo esc_url( wc_get_checkout_url() ); ?>" 
        data-temp_number="<?php echo esc_attr( $this->table_id ); ?>" 
        data-add_to_cart="<?php echo esc_attr( $this->add_to_cart_text ); ?>" 
        data-site_url="<?php echo esc_url( site_url() ); ?>" 
        id="table_id_<?php echo esc_attr( $this->table_id ); ?>" 
        class="<?php echo esc_attr( Table_Attr::wrapper_class( $this ) ); ?>">
            <?php
            $this->search_box_render();
        
            //do_action( 'wpto_after_advance_search_box', $this->table_id, $this->args, $this->column_settings, $this->_enable_cols, $this->_config, $this->atts );
    
    
            do_action( 'wpto_action_before_table', $this->table_id, $this->args, $this->column_settings, $this->_enable_cols, $this->_config, $this->atts );
            ?>
            <div class="wpt_table_tag_wrapper">
                
                <table 
                data-page_number="<?php echo esc_attr( $this->page_number + 1 ); ?>"
                data-temp_number="<?php echo esc_attr( $this->table_id ); ?>"
                data-config_json=""
                data-data_json=""
                data-data_json_backup=""
                id="wpt_table"
                class="<?php echo esc_attr( Table_Attr::table_class( $this ) ); ?>">

                <?php $this->table_head(); ?>
                <?php $this->table_body(); ?>
                </table>



            </div> <!-- /.wpt_table_tag_wrapper -->
            <?php 
            do_action( 'wpto_action_after_table', $this->table_id, $this->args, $this->column_settings, $this->_enable_cols, $this->_config, $this->atts );
            $this->do_action( 'wpt_after_table' );
            ?>

            <?php 
            if( $this->pagination ){
                Pagination::render( $this );
            }



            do_action( 'wpto_table_wrapper_bottom', $this->table_id, $this->args, $this->column_settings, $this->_enable_cols, $this->_config, $this->atts );
            $this->do_action( 'wpt_table_wrapper_bottom' );
             ?>

        </div><!-- /.main wrapper -->
        
        <?php 
        // do_action( 'wpt_loaded', $this->table_id );

        return ob_get_clean();
    }

    /**
     * Here wi will assaign, which will no load for load 
     * Table row.
     * Only will be load on first startup. 
     *
     * @param [type] $atts
     * @return void
     */
    public function startup_loader( $atts ){
        
        if( ! $this->assing_property ){
            $this->assing_property( $atts );
        }

        $this->hide_input = $this->search_n_filter['hide_input'] ?? false;
                
        $this->enqueue();

    }

    public function assing_property( $atts ){
        
        if( ! $this->atts ){
            $this->atts = $atts;
        }

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



        if( empty( $this->_enable_cols ) || ! is_array( $this->_enable_cols ) ){
            $this->is_table_head = false;
            $this->is_table_column = false;
            $this->_enable_cols = [];
            return Msg::not_found_cols($this);
        }

        $this->col_count = count( $this->_enable_cols );


        $this->basics = $this->get_meta( 'basics' );
        
        $this->basics_args = $this->basics['args'] ?? [];
        
        $this->conditions = $this->get_meta( 'conditions' );
        $this->table_style = $this->get_meta( 'table_style' );
        
        $this->search_n_filter = $this->get_meta( 'search_n_filter' );
        $pagi_data = $this->get_meta( 'pagination' );
        $this->pagination = isset( $pagi_data['start'] ) && $pagi_data['start']==1;
        

        $this->posts_per_page = $this->conditions['posts_per_page'] ?? $this->posts_per_page;
        $this->table_type = $this->conditions['table_type'] ?? $this->table_type;

        //Some Basic Meta Values | All other query related available in Args Class
        $this->table_head = ! isset( $this->basics['table_head'] ) ? true : false;
        $this->minicart_position = $this->basics['minicart_position'] ?? '';
        $this->ajax_action = $this->basics['ajax_action'] ?? '';
        $this->add_to_cart_text = $this->basics['add_to_cart_text'] ?? '';//$basics['add_to_cart_text'] ?? ''
        $this->pagination_ajax = $this->basics['pagination_ajax'] ?? '';
        $this->checkbox = $this->basics['checkbox'] ?? 'wpt_no_checked_table'; //$checkbox = isset( $basics['checkbox'] ) && !empty( $basics['checkbox'] ) ? $basics['checkbox'] : 'wpt_no_checked_table';

        //Some others from other meta
        $this->template = $this->table_style['template'] ?? '';
        $filter_box = $this->search_n_filter['filter_box'] ?? '';
        $this->filter_box = $filter_box == 'yes' ? true : false;
        
        $search_box = $this->search_n_filter['search_box'] ?? '';
        $this->search_box = $search_box == 'yes' ? true : false;
        
        $this->whole_search = $this->search_n_filter['whole_search'] ?? false;

        if( $this->filter_box ){
            $this->filter = $this->search_n_filter['filter'] ?? [];
        }
        
        $this->args = Args::manage($this);

        //This Filter will be deleted in future update
        // $this->args = apply_filters( 'wpto_table_query_args', $this->args, $this->table_id, $this->atts, $this->column_settings, $this->_enable_cols, $this->column_array );

        


        $this->assing_property = true;

        $this->items_permanent_dir = WPT_DIR_BASE . 'includes/items/';
        $this->items_permanent_dir = apply_filters('wpto_item_permanent_dir', $this->items_permanent_dir, $this->table_id, null );
        $this->items_directory = apply_filters('wpto_item_dir', $this->items_permanent_dir, $this->table_id, null );
        $this->items_directory = $this->apply_filter( 'wpt_item_dir', $this->items_directory );

        $this->is_column_label = $this->table_style['tr.wpt_table_head th']['auto-responsive-column-label'] ?? false;
    }

    public function enqueue(){

        /**
         * Template Control is here.
         */
        $this->template_name = 'wpt-template-' . $this->template;
        $template_file_name = apply_filters( 'wpto_table_template', $this->template, $this->table_id );
        $template_dir = WPT_BASE_URL . 'assets/css/templates/'. $template_file_name . '.css';
        $template_dir = $this->apply_filter( 'wpt_template_url', $template_dir );
        
        wp_register_style($this->template_name, $template_dir, array(), $this->dev_version, 'all');
        wp_enqueue_style($this->template_name);
    }


    public function set_shortcde_text( string $shortcde_text ){
        $this->shortcde_text = $shortcde_text;
        return $this;
    }
    public function get_shortcde_text(){
        return $this->shortcde_text;
    }

    /**
     * Args Organize means,
     * Args will be pass using @Fillter Hook.
     * I have made two hook primarily
     * * wpto_table_query_args which is old, I will remove it in future update
     * * wpt_query_args It's final hook, where User will get Own Object as second Params.
     *
     * @return this|object|Shortcode
     */
    protected function argsOrganize(){
        
        $this->args = apply_filters( 'wpto_table_query_args', $this->args, $this->table_id, $this->atts, $this->column_settings, $this->_enable_cols, $this->column_array );
        /**
         * @Hook filter wpt_query_args manage wpt table query args using filter hook
         */
        $this->args = $this->apply_filter( 'wpt_query_args', $this->args );
        $this->args_organized = true;
        return $this;
    }

    /**
     * Content of Table Body,
     * Actually it's all Table Row
     * This method will generate all table row based on args
     *
     * @param boolean $id Optional, It will not be need, If we dont' age our full Object and Assign_Propery method
     * @return void
     */
    protected function table_body( $id = false ){
        if( ! $this->assing_property && ! $id ){
            $atts = [
                'id' => $id
            ];
            $this->assing_property( $atts );
        }
        if( ! $this->args_organized ){
            $this->argsOrganize();
        }

        $product_loop = new \WP_Query( $this->args );
        if ($this->orderby == 'random') {
            shuffle( $product_loop->posts );
        }
        
        /**
         * @deprecated 3.2.4.2 wpto_product_loop filter will removed in next version
         */
        $product_loop = apply_filters( 'wpto_product_loop', $product_loop, $this->table_id, $this->args );
        $product_loop = $this->apply_filter( 'wpt_product_loop', $product_loop );
        if (  $product_loop->have_posts() ) : while ($product_loop->have_posts()): $product_loop->the_post();
            global $product;
            $row = new Row($this);
            $row->render();


        endwhile;
        else:
        Msg::not_found_product_tr($this);
        endif;


    }
    protected function table_head(){
        if( ! $this->table_head ) return;
        if( ! $this->is_table_head ) return; //Check column available or not, if empty array of _enable_cols, it will return false.
        
        ?>
        <thead>
            <tr data-temp_number="<?php echo esc_attr( $this->table_id ); ?>" class="wpt_table_header_row wpt_table_head">
            <?php 
            foreach( $this->_enable_cols as $key => $col ){
            $col_content = $this->column_array[$key] ?? $col;
            if( $key == 'check' ){
                $col_content = "<input data-type='universal_checkbox' data-temp_number='{$this->table_id}' class='wpt_check_universal' id='wpt_check_uncheck_column_{$this->table_id}' type='checkbox'><label for=wpt_check_uncheck_column_{$this->table_id}></label>";
            }
            ?>
            <th class="<?php echo esc_attr( $key ); ?>">
                <?php echo $col_content; ?>
            </th>
            <?php
            }
            ?>
            </tr>
        </thead>
        <?php
        
    }

    public function pagination_render(){
       echo wpt_pagination_by_args( $this->args , $this->table_id, ['args' => $this->args]);
    }
     
    /**
     * Basically for main search box and Meta field wise search box.
     * Actually first time, there was only search box without meta field search.
     * 
     * Specially for Alvaro, I added a new feature,where user will able to search by meta field.
     * 
     * at the bottom of this method, I added a action_hook: wpt_after_searchbox
     * where I added meta field wise search option at at Pro/Inc/Search_Extra()
     * find there about all things.
     *
     * @return void
     * @author Saiful Islam <codersaiful@gmail.com>
     */
    public function search_box_render(){
        
        if( $this->search_box ){
            Search_Box::render($this);
        }else{
        ?>
        <button data-type="query" data-temp_number="<?php echo esc_attr( $this->table_id ); ?>" id="wpt_query_search_button_<?php echo esc_attr( $this->table_id ); ?>" class="button wpt_search_button query_button wpt_query_search_button wpt_query_search_button_<?php echo esc_attr( $this->table_id ); ?>" style="visibility: hidden;height:1px;"></button>
        <?php
        }

        /**
         * We have used this Action hook for adding Meta Field wise serch
         * at Pro/Inc/Search_Extra()
         * 
         * @since 3.2.5.0
         * @since 8.0.9.1 of Pro version
         * 
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        $this->do_action( 'wpt_after_searchbox' );
    }

}