<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WOO_PRODUCT_TABLE\Inc\Handle\Message as Msg;
use WOO_PRODUCT_TABLE\Inc\Handle\Args;
use WOO_PRODUCT_TABLE\Inc\Handle\Pagination;
use WOO_PRODUCT_TABLE\Inc\Handle\Search_Box;
use WOO_PRODUCT_TABLE\Inc\Handle\Checkbox_Box;
use WOO_PRODUCT_TABLE\Inc\Handle\Table_Attr;
use WOO_PRODUCT_TABLE\Inc\Handle\Enqueue;
use WOO_PRODUCT_TABLE\Inc\Handle\Fragment;
use WOO_PRODUCT_TABLE\Inc\Handle\Add_To_Cart;

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
    /**
     * Its for requested product type
     * such: product, product_variation
     *
     * @var string
     */
    public $req_product_type;

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
    public $css_dependency;

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

    public $max_num_pages;
    public $product_count;
    public $found_products;
    public $product_loop;

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

        $fragment = new Fragment();
        $fragment->run();

        // $add_to_cart = new Add_To_Cart();
        // $add_to_cart->run();

    }
    public function shortcode($atts){
        
        $this->atts = $atts;

        $pairs = array( 'exclude' => false );
        extract( shortcode_atts( $pairs, $atts ) );
        
        $this->assing_property($atts);

        //Obviously should load on after starup. Even already checked on overr there
        $this->startup_loader($atts);
        
        
        // var_dump($this->product_loop);
        //wpto_action_table_wrapper_top
        ob_start();

        ?>
        <div data-checkout_url="<?php echo esc_url( wc_get_checkout_url() ); ?>" 
        data-temp_number="<?php echo esc_attr( $this->table_id ); ?>" 
        data-add_to_cart="<?php echo esc_attr( $this->add_to_cart_text ); ?>" 
        data-site_url="<?php echo esc_url( site_url() ); ?>" 
        id="table_id_<?php echo esc_attr( $this->table_id ); ?>" 
        class="<?php echo esc_attr( Table_Attr::wrapper_class( $this ) ); ?>">
            <?php

            if( 'top' == $this->minicart_position ){
                $this->minicart_render();
            }

            $this->search_box_render();
            //Actually this action hook is no need here, because it should called $this->search_box_render() but still we didnt' call over there.
            //we made new for our new table
            //do_action( 'wpto_after_advance_search_box', $this->table_id, $this->args, $this->column_settings, $this->_enable_cols, $this->_config, $this->atts );
    
    
            do_action( 'wpto_action_before_table', $this->table_id, $this->args, $this->column_settings, $this->_enable_cols, $this->_config, $this->atts );
            
            if($this->checkbox_validation){
                Checkbox_Box::render($this);
            }
            
            ?>
            <div class="wpt-stats-report">
                <?php $this->stats_render(); ?>
            </div>
            <div class="wpt_table_tag_wrapper">
                
                <table 
                data-page_number="<?php echo esc_attr( $this->page_number + 1 ); ?>"
                data-temp_number="<?php echo esc_attr( $this->table_id ); ?>"
                data-config_json="<?php echo esc_attr( wp_json_encode( $this->_config ) ); ?>"
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
                $big = 99999999;
                $this->pagination_base_url = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
        
                Pagination::render( $this );
            }


            if( 'bottom' == $this->minicart_position ){
                $this->minicart_render();
            }

            do_action( 'wpto_table_wrapper_bottom', $this->table_id, $this->args, $this->column_settings, $this->_enable_cols, $this->_config, $this->atts );
            $this->do_action( 'wpt_bottom' );
             ?>

        </div><!-- /.main wrapper -->
        
        <?php 
        // do_action( 'wpt_loaded', $this->table_id );

        /**
         * It's important to make new table always
         * Actually we have created it based on already created condition actually
         * 
         * All checked property should make defatul here
         */
        $this->product_loop = null;
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

        $this->checkbox_validation = apply_filters( 'wpto_checkbox_validation', false, $this->column_array,$this->column_settings, $this->table_id );

        $this->hide_input = $this->search_n_filter['hide_input'] ?? false;
        $this->set_product_loop();
           
        $this->enqueue();

    }
    protected function set_product_loop(){
        $this->product_loop = $this->get_product_loop();

        //Some property value re-organized based on product loop
        $this->product_count = (int) $this->product_loop->post_count;
        $this->found_posts = (int) $this->product_loop->found_posts;
        $this->max_num_pages = (int) $this->product_loop->max_num_pages;
        if( $this->product_loop->max_num_pages < 2 ){
            $this->pagination = false;
        }
             
    }

    /**
     * Different type stats. Like: total product quantity,
     * how much post founded, max number of pages etc.
     * Some Example:
     * $this->product_count = (int) $this->product_loop->post_count;
        $this->found_posts = (int) $this->product_loop->found_posts;
        $this->max_num_pages = (int) $this->product_loop->max_num_pages;
     * 
     *
     * @return void
     */
    public function stats_render(){
        
        if( ! $this->product_loop ){
            $this->set_product_loop();
        };
        $this->product_count = (int) $this->product_loop->post_count;
        $this->found_posts = (int) $this->product_loop->found_posts;
        $this->max_num_pages = (int) $this->product_loop->max_num_pages;
        $page_number = $this->max_num_pages > 0 ? $this->page_number : 0; 
        ?>
        <p class="wpt-stats-post-count">
            <?php printf( esc_html__( "%s out of %s", "wpt_pro" ), $this->product_count, $this->found_posts  ); ?>
        </p>
        <p class="wpt-stats-page-count">
        <?php printf( esc_html__( "Page %s out of %s" ), $page_number, $this->max_num_pages  ); ?>
        </p>
        <?php 

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
        $this->req_product_type = $this->basics['product_type'] ?? 'product';
        
        
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

        $this->items_permanent_dir = WPT_DIR_BASE . 'includes/items/';
        $this->items_permanent_dir = apply_filters('wpto_item_permanent_dir', $this->items_permanent_dir, $this->table_id, null );
        $this->items_directory = apply_filters('wpto_item_dir', $this->items_permanent_dir, $this->table_id, null );
        $this->items_directory = $this->apply_filter( 'wpt_item_dir', $this->items_directory );

        $this->is_column_label = $this->table_style['tr.wpt_table_head th']['auto-responsive-column-label'] ?? false;

        $this->assing_property = true;
    }

    public function enqueue(){
        $this->assets_element_url = $this->assets_url . 'css/elements/';

        //Need to add feature at dashboard
        $this->footer_cart_template = true;

        $this->css_dependency = [
            'wpt-universal',
        ];

        if('none' !== $this->template){
            $this->load_css_base_template();
        }

        if( 'none' !== $this->minicart_position){

            $this->load_css_element( 'minicart' );
        }
        if( $this->footer_cart ){
            $this->load_css_element( 'footer-cart' );
        }
        
        if( $this->checkbox_validation ){
            $this->load_css_element( 'checkbox-box' );
        }
        
        /**
         * Template Control is here.
         */
        $this->template_name = 'wpt-template-' . $this->template;
        $template_file_name = apply_filters( 'wpto_table_template', $this->template, $this->table_id );
        $this->template_dir = $this->base_dir . 'assets/css/templates/'. $template_file_name . '.css';
        $this->is_template_dir = is_file( $this->template_dir );
        $this->template_url = $this->base_url . 'assets/css/templates/'. $template_file_name . '.css';
        $this->template_url = $this->apply_filter( 'wpt_template_url', $this->template_url );
        var_dump($this->template_name, $this->template_url, $this->css_dependency);
        wp_register_style($this->template_name, $this->template_url, $this->css_dependency, $this->dev_version, 'all');
        wp_enqueue_style($this->template_name);
        $this->load_css_override_root( $this->template_name );


        //Actually it's should be at the end of template loading,because, we want more power here.
        if( $this->footer_cart_template !== 'none' ){
            $this->load_css_element( 'footer-cart-templates' );
        }
    }

    private function load_css_element( string $elements_file_name ){
        
        $style_name = 'wpt-' . $elements_file_name;
        $css_url = $this->assets_element_url . $elements_file_name . '.css';
        wp_register_style($style_name, $css_url, $this->css_dependency, $this->dev_version, 'all');
        wp_enqueue_style($style_name);
    }

    /**
     * It's Actually Base Template file.
     * ROOT OF ALL TEMPLATE
     * --------------------
     * All template's base style and property will stay here and
     * specific template file load after this file load
     * 
     * Actually in specific template file: there will stay only color change style/property 
     *
     * @return void
     */
    private function load_css_base_template(){
        //wp_enqueue_style( 'wpt-template-table', WPT_Product_Table::getPath('BASE_URL') . 'assets/css/template.css', array('wpt-universal'), WPT_DEV_VERSION, 'all' );
        $style_name = 'wpt-template';
        $css_url = $this->assets_url . 'css/base-template.css';
        wp_register_style($style_name, $css_url, $this->css_dependency, $this->dev_version, 'all');
        wp_enqueue_style($style_name);
    }

    private function load_css_override_root( string $base_template_name){
        $style_name = 'wpt-override-template';
        $css_dependency = array_push( $this->css_dependency, $base_template_name );
        $css_url = $this->assets_url . 'css/override-root.css';
        wp_register_style($style_name, $css_url, $css_dependency, $this->dev_version, 'all');
        wp_enqueue_style($style_name);
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

    protected function get_product_loop(){
        if( $this->product_loop ) return $this->product_loop;
        if( ! $this->args_organized ){
            $this->argsOrganize();
        }
        
        return new \WP_Query( $this->args );
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
        if( ! $this->assing_property ){
            echo "Error: on assing_property on the table_body!!";
            return;
        }

        $product_loop = $this->get_product_loop();
        if ($this->orderby == 'random') {
            shuffle( $product_loop->posts );
        }
        // var_dump($this->product_loop);
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
            <th class="wpt_<?php echo esc_attr( $key ); ?>">
                <?php echo $col_content; ?>
            </th>
            <?php
            }
            ?>
            </tr>
        </thead>
        <?php
        
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

    /**
     * RENDER MINICART MARKUP:
     * Our personal Minicart where product will add after added to cart actually
     * At previous day, here was All other things. but now I will add different things
     * 
     * No need any functionality, just added to div element, one is wrapper,
     * and another is main minicart. in this part
     * IT'S FUNCTIONALITY, autoloading will handle from Fragements Class
     * see at inc/handle/fragment 
     *
     * @return void
     * @author Saiful Islam <codersaiful@gmail.com>
     */
    public function minicart_render(){
        ?>
        <div class='tables_cart_message_box tables_cart_message_box_<?php echo esc_attr( $this->table_id ); ?>' data-type='load'>
            <div class="widget_shopping_cart_content"></div>
        </div>
        <?php   
    }

    public function __destruct()
    {
        $this->product_loop = null;
    }
}