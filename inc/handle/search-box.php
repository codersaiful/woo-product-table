<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Search_Box{
    public static $reset_button;
    public static $cf_search_box;
    public static $taxonomy_keywords;

    /**
     * Extra Field on Search box
     * Such: 
     * 1. On Sale 
     * 2. Order By
     *
     * @var [type]
     */
    public static $fields;
    public static function render( Shortcode $shortcode ){
        $behavior = $shortcode->atts['behavior'] ?? '';
        // if( $behavior !== 'normal' && ( is_shop() || is_product_taxonomy() || is_product_category() ) ) return;
        self::$reset_button = "<button class='wpt-query-reset-button' title='" . __('Reset','woo-product-table') . "'> <i class='wpt-spin3'></i></button>"; //end of .search_single
        self::$cf_search_box = $shortcode->search_n_filter['cf_search_box'] ?? '';
        self::$taxonomy_keywords = $shortcode->search_n_filter['taxonomy_keywords'] ?? [];
        self::$fields = $shortcode->search_n_filter['fields'] ?? [];
        
        $config_value = $shortcode->_config;
        // var_dump($config_value);
        $search_box_title = $config_value['search_box_title'];
        $html = false;
        $html .= "<div id='search_box_{$shortcode->table_id}' class='wpt_search_box search_box_{$shortcode->table_id}'>";
        $html .= '<div class="search_box_fixer">'; //Search_box inside fixer
        $html .= '<h3 class="search_box_label">' . sprintf( $search_box_title, '<small>','</small>' ) . '</h3>';
        $html .= "<div class='search_box_wrapper'>";

        
        if( $shortcode->hide_input ){
            $html_inputBox = false;
        }else{
            $html_inputBox = '';
            $search_keyword = isset( $_GET['search_key'] ) ? sanitize_text_field( $_GET['search_key'] ) : '';
            $single_keyword = $config_value['search_keyword_text'];//__( 'Search keyword', 'woo-product-table' );
            $search_order_placeholder = $config_value['search_box_searchkeyword'];//__( 'Search keyword', 'woo-product-table' );
            $html_inputBox .= '<div class="search_single_search_by_keyword">';// /.search_single_column 
            $html_inputBox .= '<label class="search_keyword_label single_keyword" for="single_keyword_' . $shortcode->table_id . '">' . $single_keyword . '</label>';
            $html_inputBox .= '<input data-key="s" value="' . $search_keyword . '" class="query-keyword-input-box query_box_direct_value" id="single_keyword_' . $shortcode->table_id . '" value="" placeholder="' . $search_order_placeholder . '"/>';
            $html_inputBox .= '</div>';// /.search_single_column  
        }
        
        ob_start();
        /**
         * Used following hook to insert two insert other field
         * such:
         * Order By, Order and On sale
         * 
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        $shortcode->do_action('wpt_search_box');
        $extra_html = ob_get_clean();

        if( self::$cf_search_box !== 'yes' && empty( self::$fields ) && empty( self::$taxonomy_keywords ) ){
            self::$reset_button = '';
        }
        if( ! empty( $extra_html ) || $html_inputBox){

            $html .= "<div class='search_single search_single_direct keyword-s-wrapper'>";
            $html .= $html_inputBox;
            $html .= $extra_html;
            $html .= self::$reset_button;
            $html .= "</div>"; //end of .search_single
            
        }
        

        if( is_string( self::$taxonomy_keywords ) && ! empty( self::$taxonomy_keywords ) ){
            self::$taxonomy_keywords = wpt_explode_string_to_array( self::$taxonomy_keywords );
        }

        /**
         * Texonomies Handle based on $taxonomy_keywords
         * Default cat and tag for product
         * 
         * @since 1.9
         * @date 10.6.2018 d.m.y
         */
        if( is_array( self::$taxonomy_keywords ) && count( self::$taxonomy_keywords ) > 0 ){
            foreach( self::$taxonomy_keywords as $texonomy_name ){
               $html .= wpt_texonomy_search_generator( $texonomy_name,$shortcode->table_id, $shortcode->search_n_filter ); 
            }
        }

        $html .=  apply_filters('end_part_advance_search_box','',$shortcode->table_id);
        
        /**
         * Query by URL
         */
        if( isset( $config_value['query_by_url'] ) && $config_value['query_by_url'] ){
            
            $cutnt_link = get_page_link();
            $style = isset( $_GET['table_ID'] ) ? "display:inline;": '';
            $html .= '<a href="' . $cutnt_link . '" data-type="close-button" data-table_ID="' . $shortcode->table_id . '" id="wpt_query_reset_button_' . $shortcode->table_id . '" class="search_box_reset search_box_reset_' . $shortcode->table_id . '" style="' . $style . '">x</a>';
        }
        
        $html .= '</div>'; //End of .search_box_singles

        
        // $html .= '<button data-type="query" data-temp_number="' . $shortcode->table_id . '" id="wpt_query_search_button_' . $shortcode->table_id . '" class="button wpt_search_button query_button wpt_query_search_button wpt_query_search_button_' . $shortcode->table_id . '">' . $config_value['search_button_text'] . '</button>';
        
        //New and Testing
        $html .= '<button data-table_id="' . $shortcode->table_id . '" id="wpt_query_search_button_' . $shortcode->table_id . '" class="button wpt-search-products wpt_query_search_button_' . $shortcode->table_id . '">' . $config_value['search_button_text'] . '</button>';
        
        
        $html .= '</div>';//End of .search_box_fixer
        $html .= '</div>';//End of .wpt_search_box
        echo $html;
    }
}