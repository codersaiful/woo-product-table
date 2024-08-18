<?php 
namespace WOO_PRODUCT_TABLE\Inc;

use WOO_PRODUCT_TABLE\Inc\Handle\Args;
use WOO_PRODUCT_TABLE\Inc\Handle\Enable_Column;
use WOO_PRODUCT_TABLE\Inc\Handle\Message as Msg;
use WOO_PRODUCT_TABLE\Inc\Handle\Element;
use WOO_PRODUCT_TABLE\Inc\Handle\Pagination;
use WOO_PRODUCT_TABLE\Inc\Handle\Search_Box;
use WOO_PRODUCT_TABLE\Inc\Handle\Checkbox_Box;
use WOO_PRODUCT_TABLE\Inc\Handle\Table_Attr;
use WOO_PRODUCT_TABLE\Inc\Handle\Enqueue;
use WOO_PRODUCT_TABLE\Inc\Handle\Fragment;
use WOO_PRODUCT_TABLE\Inc\Handle\Add_To_Cart;

use WOO_PRODUCT_TABLE\Inc\Table\Row;
use WOO_PRODUCT_TABLE\Inc\Features\Basics;
use WOO_PRODUCT_TABLE\Inc\Handle\Mini_Filter;

class Shortcode extends Shortcode_Base{

    public $_root = __CLASS__;
    
    private $assing_property = false;

    /**
     * If not passed over filter hook 
     * the args Attribute.
     * 
     * Default value obviusly need null.
     * Remember it.
     *
     * @var bool|null
     */
    public $args_organized;
    public $args_ajax_called;
    public $atts;
    /**
     * It's actually not a unique number.
     * It's a Unique POST_ID of woo_product_table
     * 
     * But If a user paste shortcode in a page two time, it's not a unique,
     * So wee need another attribute for wrapper table.
     * Which will store at public $unique_id;
     *
     * @var int
     */
    public $table_id;

    /**
     * Absulate Unique ID/String for each table. Shuffle of CodeAstrology Saiful
     * *******************
     * IMPORTANT:
     * It's a random string, Each time, it will change.
     *
     * @var string
     */
    public $unique_id;
    public $status;

    /**
     * Temp and Post Type for 'woo-product-type' post. If found, we will continue, otherwise. we return null.
     *
     * @var null|string for Product table Post Type
     */
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
     * Load More/Infinite_Scroll paginated Actually
     * 
     * Mainly used for handle Table Statsbar primarily at Shortcode_Ajax class.
     * getting data from $others variable inside this class and we made it true when get load_more or infinite_scroll
     * 
     * Specially for Paginaion using Ajax from Frontend
     * We need to calculate paginated_stats to show TableStats
     *
     * @var boolean true|false Default value is false, if paginated with Load More or Initinte Scroll, that it will true.
     */
    public $paginated_load = false;

    /**
     * Based on $error_name property, We will handle Display Message before Table Display
     * Suppost: column not found, Befor Table,
     * It will display Table Not found Error Message
     * 
     * If not found Table, than it will show another error of table not found
     * 
     * IMPORTANT:
     * --------------
     * WE will not return before the table load when assining property
     * 
     *
     * @var null|bool|string
     */
    public $error_name;

    /**
     * Check column available or not, if empty array of _enable_cols, it will return false.
     *
     * @var boolean
     */
    public $is_table_head = true;
    public $is_table_column = true;

    /**
     * It has used on column name array 
     * It's not the output of Device actually
     * It's column based
     *
     * @var [type]
     */
    public $_device; 

    /**
     * It will return current device name.
    * such: mobile,tablet,desktop.
     *
     * @var string
     */
    public $device;

    /**
     * What is Generated row:
     * Actually when Mobile responsive and and current device is mobile,
     * that time, we will input all td inside a single td and 
     * current td will convert to div tag.
     * 
     * for Desktop or tablet, it will not show generated td. in
     * this class inside assigin_property() method,
     * I have findout the value of generated_row. 
     *
     * @var boolean
     */
    public $generated_row = false;
    public $args;

    public $_enable_cols;
    public $col_count;
    public $column_array;
    public $column_settings;

    public $basics;
    public $auto_responsive;
    public $basics_args;

    public $search_n_filter;
    public $conditions;

    /**
     * It's not a bool only, Actually we take here pagination type.
     * Such: Pagination 
     * on
     * off
     * load_more
     * infinite_scroll
     *
     * @var string|bool|mixed
     */
    public $pagination;


    public $post_include;
    public $post_exclude;
    public $cat_explude;
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
    public $instance_search;
    public $filter;

    public $orderby;
    public $order;
    public $meta_value_sort;

    public $table_style;

    /**
     * It's also a base setting but it's diffrent based on Table ID
     * Otherwise Other all will depend on base_config
     * 
     * You can check also $this->base_config
     * both are almost same
     *
     * @var array
     */
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
        

        $this->do_action('wpt_load');

        if( $this->error_name ) Msg::handle($this);
        if( ! $this->table_display ) return;
        // var_dump($this->product_loop);
        //wpto_action_table_wrapper_top
        ob_start();
        
        ?>
        <div id="table_id_<?php echo esc_attr( $this->table_id ); ?>" 
        class="<?php echo esc_attr( Table_Attr::wrapper_class( $this ) ); ?>"
        data-unique_id="<?php echo esc_attr( $this->unique_id ); ?>"
        data-temp_number="<?php echo esc_attr( $this->table_id ); ?>" 
        data-basic_settings="<?php echo esc_attr( wp_json_encode( $this->basic_settings ) ); ?>" >
            <?php


            //Render Top Minicart here, Condition applied inside method/function
            $this->minicart_render( 'top' );

            $this->search_box_render();
            //Actually this action hook is no need here, because it should called $this->search_box_render() but still we didnt' call over there.
            //we made new for our new table
            //do_action( 'wpto_after_advance_search_box', $this->table_id, $this->args, $this->column_settings, $this->_enable_cols, $this->_config, $this->atts );
    
    
            do_action( 'wpto_action_before_table', $this->table_id, $this->args, $this->column_settings, $this->_enable_cols, $this->_config, $this->atts );
            $this->instance_search_render();
            $this->mini_filter_render();
            if($this->checkbox_validation){
                Checkbox_Box::render($this);
            }
            
            ?>
            <div class="wpt-stats-report">
                <?php $this->stats_render(); ?>
            </div>
            <div class="wpt_table_tag_wrapper">
                <div class="wpt-ob_get_clean"></div>
                <!-- data-config_json attr is important for custom.js-->
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

            if($this->checkbox_validation){
                Checkbox_Box::render($this, 'footer');
            }
            
            /**
             * Pagination's this part/method, only need when pagination will number.
             * and in our plugin, pagination value 'on' means number. for other,
             * value will be different. like: load_more, infinite_scroll etc.
             * 
             * We will call Pagination::render() Only when pagination is number
             * mean: pagination value is 'on'
             */
            
            switch($this->pagination){
                case 'on':
                    $big = 99999999;
                    $this->pagination_base_url = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
        
                    Pagination::render( $this );
                    break;
                case 'off':
                    break;
                case 'load_more':
                case 'infinite_scroll':
                    Element::loadMore( $this );
                    break;
            }

            //Render Bottom Minicart here, Condition applied inside method/function
            $this->minicart_render( 'bottom' );

            do_action( 'wpto_table_wrapper_bottom', $this->table_id, $this->args, $this->column_settings, $this->_enable_cols, $this->_config, $this->atts );
            $this->do_action( 'wpt_bottom' );
             ?>

        </div><!-- /.main wrapper -->
        
        <?php 

        /**
         * Dev version for Get Vardump to get Object Details Var Dump
         * Only avialble visible Object Details.
         */
        $this->get_var_for_Dev();
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

        //Assigning value for basics setting. it's used at shortcode($atts) method. It's actually need for thirdparty supported Add to cart button. there need ajax_action data before trigger.
        $this->basic_settings = [
            'checkout_url'  => wc_get_checkout_url(),
            'add_to_cart'   => $this->add_to_cart_text,
            'site_url'      => site_url(),
            'ajax_action'   => $this->basics['ajax_action'] ?? '',

        ];

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
        $min_one = $this->found_posts < 1 ? 0 : 1;
        $page_number = $this->max_num_pages > 0 ? $this->page_number : 0; 
        $display_count = "$min_one - $this->product_count";

        // var_dump($this->found_posts);
        $display_pagN = $page_number;
        if( $this->paginated_load && $page_number > 1 ){
            $prev_ttl_post = ( $page_number - 1 ) * $this->posts_per_page;
            $display_count = $this->product_count + $prev_ttl_post;
            $display_count = "$min_one - $display_count";
            
            $display_pagN = "($min_one - $page_number)";
        }else if( $page_number > 1 ){
            $prev_post = ( ($page_number-1) * $this->posts_per_page );
            $current_total_post = $prev_post + $this->product_count;
            $display_count = ( $prev_post + 1 ) . " - $current_total_post";
        }

        $stats_post_count = $this->basics['stats_post_count'] ?? '';//__( "Showing %s out of %s", "woo-product-table" );
        $stats_page_count = $this->basics['stats_page_count'] ?? '';//__( "Page %s out of %s", "woo-product-table" );
        
        ?>
        <p class="wpt-stats-post-count">
            <?php printf( esc_html__( $stats_post_count, "woo-product-table" ), $display_count, $this->found_posts  ); ?>
        </p>
        <p class="wpt-stats-page-count">
        <?php printf( esc_html__( $stats_page_count, "woo-product-table" ), $display_pagN, $this->max_num_pages  ); ?>
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
        $this->unique_id = str_shuffle("CodeAstrologySaifulIslam");
        // set_query_var( 'woo_product_table', $this->table_id );
        set_query_var( $this->req_post_type, $this->table_id );

        $this->is_table = $this->table_id && $this->post_type == $this->req_post_type && $this->status == 'publish';
        if( ! $this->is_table && ! empty( $this->atts ) ){
            return Msg::not_found($this);
        }

          


        $this->_config = wpt_get_config_value( $this->table_id );
        //Here need detected current device actually.
        $this->_device = wpt_col_settingwise_device( $this->table_id );//wpt_detect_current_device();//
        
        $this->basics = $this->get_meta( 'basics' );
        $product_type = $this->basics['product_type'] ?? null;
        $this->req_product_type = ! empty( $product_type ) ? $product_type : 'product';
        $enabled_column_array = get_post_meta( $this->table_id, 'enabled_column_array' . $this->_device, true );
        $column_array = get_post_meta( $this->table_id, 'column_array' . $this->_device, true );
        $column_settings = get_post_meta( $this->table_id, 'column_settings' . $this->_device, true);

        
        
        $responsive = $this->basics['responsive'] ?? false;

        /**
         * ******************
         * MANUAL RESPONSIVE SWITCH
         * ******************
         * If Dissable off Off from Admin panel,
         * then Auto Responsive Device detect will not work.
         * Option will be then that, Auto REsponsive off
         * ******************
         * Newly Added (V 3.2.5.6) in Column Setting tab at BackEnd/Admin Panel. 
         * Why added this?
         * Actually: some thime, User don't want Auto Responsive and dont' want to add column for Mobile or Table,
         * Then we can handle by this feature.
         * 
         * Option added at column_settings.php file.
         * 
         * It's actually Manual Swtich for Auto Responsive Detect. If handle by this, than auto responsive device detect option
         * will not work.
         */
        $responsive_switch = $this->basics['responsive_switch'] ?? false;
        if( $responsive_switch ){ //If vvalue, meant: switch off from admin panel
            $responsive = 'no_responsive';
        }
        
        /**
         * Authoresponsive value is come from database inside $this->basics
         * Actually in basics meta data, anyhow saved data when saving product table. 
         * Actually if not set any column for Tablet and Mobile device,
         * then it will come 'mobile_responsive' which actually 'autoresponsive'
         * 
         * ***************
         * Auto Responsive detect has done from admin.js file
         * ***************
         * 
         * In backend, there is a problem.
         * problem: If set any column for mobile/tablet then if remove, It's not work. I mean: it's not back to auto Responsive.
         * @todo Need to solve this issue.
         * Auto Responsive issue, what was a critical error, Has been solved
         * 
         * @todo We have to add new feature for on/off Auto Responsive 
         * @author Saiful Islam <codersaiful@gmail.com>
         *    
         */
        $this->auto_responsive =  $responsive == 'mobile_responsive';

        /**
         * It will return current device name.
         * such: mobile,tablet,desktop.
         */
        $this->device = wpt_detect_current_device();
        $this->generated_row = $this->auto_responsive && $this->device == 'mobile';
        
        $this->basics_args = $this->basics['args'] ?? [];
        
        
        
        $this->conditions = $this->get_meta( 'conditions' );
        $this->table_style = $this->get_meta( 'table_style' );
        
        $this->search_n_filter = $this->get_meta( 'search_n_filter' );
        

        $this->posts_per_page = $this->conditions['posts_per_page'] ?? $this->posts_per_page;
        

        //Some Basic Meta Values | All other query related available in Args Class
        $this->table_head = ! isset( $this->basics['table_head'] ) ? true : false;
        $this->minicart_position = $this->basics['minicart_position'] ?? '';
        $this->ajax_action = $this->basics['ajax_action'] ?? '';
        $this->add_to_cart_text = $this->basics['add_to_cart_text'] ?? '';//$basics['add_to_cart_text'] ?? ''
        $this->pagination = $this->basics['pagination'] ?? 'on';
        $this->pagination_ajax = $this->basics['pagination_ajax'] ?? '';
        $this->checkbox = $this->basics['checkbox'] ?? 'wpt_no_checked_table'; //$checkbox = isset( $basics['checkbox'] ) && !empty( $basics['checkbox'] ) ? $basics['checkbox'] : 'wpt_no_checked_table';

        if($this->wpml_bool){
            $lang = '_'. $this->wpml_lang;
            $this->add_to_cart_text = $this->basics['add_to_cart_text' . $lang] ?? '';
        }

        $this->add_to_cart_text = ! empty( $this->add_to_cart_text ) ? __( $this->add_to_cart_text, 'woo-product-table' ) : __( 'Add to cart', 'woo-product-table' );

        //Some others from other meta

        /**
         * By default, we should found default template.
         * 
         * @since 3.2.8.0
         */
        $this->template = $this->table_style['template'] ?? 'default';

        $filter_box = $this->search_n_filter['filter_box'] ?? '';
        $this->filter_box = $filter_box == 'yes' ? true : false;
        $instance_search =$this->_config['instant_search_filter'] ?? false;
        $this->instance_search = $instance_search == '1' ? true : false;

        $search_box = $this->search_n_filter['search_box'] ?? '';
        $this->search_box = $search_box == 'yes' ? true : false;
        
        $this->whole_search = $this->search_n_filter['whole_search'] ?? false;

        if( $this->filter_box ){
            $this->filter = $this->search_n_filter['filter'] ?? [];
        }
        

        $this->column_array = apply_filters( 'wpto_column_arr', $column_array, $this->table_id, $atts, $column_settings, $enabled_column_array );
        //we will removed this filter after few version. Not really, there are some old user available.
        $this->_enable_cols = apply_filters( 'wpto_enabled_column_array', $enabled_column_array, $this->table_id, $this->atts, $column_settings, $this->column_array );
        /**
         * @Hook Filter wpto_enabled_column_array to change or modify column amount, we can use it.
         */
        $this->_enable_cols = apply_filters('wpt_enabled_column', $this->_enable_cols, $this);

        $this->column_settings = apply_filters( 'wpto_column_settings', $column_settings, $this->table_id, $this->_enable_cols );
        
        /**
         * Actually this option has come from condition tab 
         * in old version,
         * Now I have changed it and transfer to Action column.
         * 
         * ---------------
         * This was from options tab
         * now come from 
         * admin/handle/feature-loader.php
         * admin/handle/action-feature.php
         * 
         * @since 3.3.6
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        $third_table_type = $this->conditions['table_type'] ?? $this->table_type;
        $this->table_type = $this->column_settings['action']['third_party_plugin'] ?? $third_table_type;

        /**
         * Column Management Here
         */
        Enable_Column::manage($this);
        

        if( empty( $this->_enable_cols ) || ! is_array( $this->_enable_cols ) ){
            $this->is_table_head = false;
            $this->is_table_column = false;
            $this->_enable_cols = [];
            $this->error_name = 'not_found_cols';
            
        }

        $this->col_count = count( $this->_enable_cols );

        
        // $this->args = Args::manage($this); //It was previs
        /**
         * $this->args is handle by Args::manage($this)
         * Actually there was return self::$args inside that Class
         * But I(Saiful)  has removed that return and Assign args value inside that Class
         * at manage method at the bottom 
         * 
         * NO NEED ASSAIGN HERE AGAINN
         * -----------------
         * 
         * @since 3.2.5.5.final8
         * @date 29.9.2022
         */
        Args::manage($this); 

        $this->items_permanent_dir = WPT_DIR_BASE . 'includes/items/';
        $this->items_permanent_dir = apply_filters('wpto_item_permanent_dir', $this->items_permanent_dir, $this->table_id, null );
        $this->items_directory = apply_filters('wpto_item_dir', $this->items_permanent_dir, $this->table_id, null );
        $this->items_directory = $this->apply_filter( 'wpt_item_dir', $this->items_directory );

        $this->is_column_label = $this->table_style['tr.wpt_table_head th']['auto-responsive-column-label'] ?? false;

        $this->assing_property = true;
        if( empty( $this->atts ) ){
            $this->fake_assing_property();//Msg::not_found($this);
        }
        return $this;
    }

    /**
     * Sometime user just page shortcode [Product_Table]
     * without atts,
     * then we will use this actually
     *
     * @return void
     */
    public function fake_assing_property(){
        $this->fake_property = true;
        
        $this->args = [
            'post_type' => 'product',
            'posts_per_page'    => 30,
            'wpt_query_type'    => 'default',
            'pagination'    => '1',
            'suppress_filters'    => '1',
            'orderby'    => 'menu_order',
            'order'    => 'DESC',
            'paged'    => $this->args['paged'] ?? 1,
        ];
        $this->_enable_cols = [
            // '_price'    => '_price',
            'product_title'    => 'product_title',
            'stock'    => 'stock',
            'price'    => 'price',
            'category'    => 'category',
            'short_description'    => 'short_description',
            // 'quantity'    => 'quantity',
            // 'action'    => 'action',
        ];
        foreach($this->_enable_cols as $en_col_key => $en_col){
            $this->column_settings[$en_col_key] = [
                'type' => 'default',
                'type_name' => 'Default',
                'tag_class' => "auto_item_$en_col_key item_$en_col_key",
            ];
        }

        $this->is_table_head = true;
    }

    public function enqueue(){
        $this->assets_element_url = $this->assets_url . 'css/elements/';

        //Need to add feature at dashboard
        $this->footer_cart_template = true;

        $this->css_dependency = [
            'wpt-universal',
        ];
        //Already checked baded on none template.
        $this->load_css_base_template();

        if( 'none' !== $this->minicart_position){

            $this->load_css_element( 'minicart' );
        }
        if( $this->footer_cart ){
            $this->load_css_element( 'footer-cart' );
        }
        
        if( $this->search_box ){
            $this->load_css_element( 'searchbox' );
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
        
        wp_register_style($this->template_name, $this->template_url, $this->css_dependency, $this->dev_version, 'all');
        wp_enqueue_style($this->template_name);
        $this->load_css_override_root( $this->template_name );


        //Actually it's should be at the end of template loading,because, we want more power here.
        if( $this->footer_cart_template !== 'none' ){
            $this->load_css_element( 'footer-cart-templates' );
        }

        $this->theme_compatible();
    }

    /**
     * It's Universal Theme compatibility with our plugin
     * If some custom css file need here. 
     * We have to add a CSS file to the directory (css/compatible/theme_name.css) based on theme name 
     * 
     *  
     * @author Saiful Islam <codersaiful@gmail.com>
     * @return void
     */
    private function theme_compatible(){
        $comp_file  = $this->base_dir . "assets/css/compatible/{$this->site_theme}.css";
        if( ! is_file( $comp_file ) ) return;

        $style_name =  'wpt-compt-' . $this->site_theme;
        $css_url = $this->assets_url . 'css/compatible/' . $this->site_theme . '.css';
        wp_register_style($style_name, $css_url, $this->css_dependency, $this->dev_version, 'all');
        wp_enqueue_style($style_name);
    }

    private function load_css_element( string $elements_file_name ){
        
        $style_name = 'wpt-' . $elements_file_name;
        $css_url = $this->assets_element_url . $elements_file_name . '.css';
        wp_register_style($style_name, $css_url, $this->css_dependency, $this->dev_version, 'all');
        wp_enqueue_style($style_name);
    }

    /**
     * It's Actually Base Template file. it should work only if a template 
     * chosen. Otherwise, we should not call this file.
     * 
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
        if('none' == $this->template) return;
        //wp_enqueue_style( 'wpt-template-table', WPT_Product_Table::getPath('BASE_URL') . 'assets/css/template.css', array('wpt-universal'), WPT_DEV_VERSION, 'all' );
        $style_name = 'wpt-template';
        $css_url = $this->assets_url . 'css/base-template.css';
        wp_register_style($style_name, $css_url, $this->css_dependency, $this->dev_version, 'all');
        wp_enqueue_style($style_name);
    }

    /**
     * Calling css root color over there.
     * Actually all color root will stau at specific template, and that will override here.
     * 
     * Override CSS color
     * -----------------
     * 
     * Free and pro, alwasy overrride fiel is same
     *
     * @param string $base_template_name Which template is selected, that to be in dependency.
     * @return void
     */
    private function load_css_override_root( string $base_template_name){
        if('none' == $this->template) return;
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
     * ADDITIONAL:
     * ***********************
     * Condition has added to make more faster 
     * not only fuster, It not add this, args value is changing inside ajax request.
     * new added line is: 
     * if( $this->args_organized ) return $this;
     * at the begining of this method.
     *
     * @return null|object|Shortcode
     */
    protected function argsOrganize(){
        /**
         * No need checking of $this->args_organized
         * Because we are curenly in organize part
         * We can use it in other place.
         * 
         * ****************
         * Important
         * ****************
         * Actually first time, why I  have used it.
         * to reduce query excution time. But we already used 
         * $this->product_loop checking to reduce query execution time.
         */
        //if( $this->args_organized ) return $this;
        

        $this->args = apply_filters( 'wpto_table_query_args', $this->args, $this->table_id, $this->atts, $this->column_settings, $this->_enable_cols, $this->column_array );
        /**
         * @Hook filter wpt_query_args manage wpt table query args using filter hook
         * 
         * Example: 
         * $this->args = apply_filters( 'wpto_table_query_args', $this->args, $this );
         */
        $this->args = $this->apply_filter( 'wpt_query_args', $this->args );
        $this->args_organized = true;
        return $this;
    }

    /**
     * Getting product loop inside our main Shortcode Object/Class becuase 
     * we need it before display table. 
     * such: based on products count, we will show pagination or not show etc mater
     * 
     * 
     *
     * @return object|null|array return Query object and we can do anything based on this object. 
     */
    protected function get_product_loop(){
        if( $this->product_loop ) return $this->product_loop;

        /**
         * There was a condition like:
         * if( ! $this->args_organized )
         * But I have remove it, because, Now I checked condition
         * inside argsOrganize() method
         * 
         * @since 3.3.1.0
         */
        $this->argsOrganize();
        // if( ! $this->args_organized ){
            
        // }
        // dd($this->args);
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
            
            ?>
            <p class="wpt-error-wrapper">
                <span class="wpt-error wpt-error-assing_property"><?php echo esc_html__( "Error: on assing_property on the table_body!!", 'woo-product-table' ); ?></span>
                <a href="https://wordpress.org/support/topic/error-on-assing_property-on-the-table_body-2/" class="wpt-get-tutorial" target="_blank"><?php echo esc_html__( "Get Tutorial for this issue from wpOrg", 'woo-product-table' ); ?>.</a>
                OR
                <a href="https://wooproducttable.com/doc/troubleshoots/error-on-assing_property-on-the-table_body/" class="wpt-get-tutorial" target="_blank"><?php echo esc_html__( "Tutorial from website with Screenshot", 'woo-product-table' ); ?>.</a>
            </p>
            <?php
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
        $this->error_name = 'not_found_product_tr';
        Msg::not_found_product_tr($this);
        endif;

        wp_reset_query();
        wp_reset_postdata();
    }
    protected function table_head(){
        if( ! $this->table_head ) return;
        if( ! $this->is_table_head ) return; //Check column available or not, if empty array of _enable_cols, it will return false.
        $show_stats = $this->generated_row ? 'display: none;' : '';
        ?>
        <thead style="<?php echo esc_attr( $show_stats ); ?>">
            <tr data-temp_number="<?php echo esc_attr( $this->table_id ); ?>" class="wpt_table_header_row wpt_table_head">
            <?php 
            foreach( $this->_enable_cols as $key => $col ){
            $col_content = $this->column_array[$key] ?? $col;
            if( $key == 'check' ){
                $col_content = "<input data-type='universal_checkbox' data-temp_number='{$this->table_id}' class='wpt_check_universal' id='wpt_check_uncheck_column_{$this->table_id}' type='checkbox'><label for=wpt_check_uncheck_column_{$this->table_id}></label>";
            }
            ?>
            <th class="wpt_<?php echo esc_attr( $key ); ?>">
                <?php echo __( $col_content, 'woo-product-table' ); ?>
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
        ?>
        <div class="wpt-search-full-wrapper">
        <?php
        if( $this->search_box ){
            Search_Box::render($this);
        }else{
        ?>
        <button data-table_id="<?php echo esc_attr( $this->table_id ); ?>" 
        id="wpt_query_search_button_<?php echo esc_attr( $this->table_id ); ?>" 
        class="button wpt-search-products wpt_query_search_button_<?php echo esc_attr( $this->table_id ); ?>"
        style="visibility: hidden;height:0px;">Search</button>
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
        
        ?>
        </div>
        <?php
        
    }

    public function mini_filter_render(){
        if( ! $this->filter_box ) return;
        Mini_Filter::render($this);
    }
    public function instance_search_render(){
        if( ! $this->instance_search ) return;
        Element::instance_search($this);
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
     * @param string $position Required, It's can be top,bottom. it will depend on databased set value
     * @return void
     * @author Saiful Islam <codersaiful@gmail.com>
     */
    public function minicart_render( $position ){
        if( 'none' == $this->minicart_position ) return;
        if( $position == $this->minicart_position || 'both' == $this->minicart_position ){
            ?>
            <div class='tables_cart_message_box tables_cart_message_box_<?php echo esc_attr( $this->table_id ); ?>' data-type='load'>
                <div class="widget_shopping_cart_content"></div>
            </div>
            <?php  
        }
         
    }

    public function __destruct()
    {
        $this->product_loop = null;
    }
}