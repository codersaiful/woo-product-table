<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Search_Box{
    public static function render( Shortcode $shortcode ){
        
        $taxonomy_keywords = $shortcode->search_n_filter['taxonomy_keywords'] ?? [];
        
        $config_value = $shortcode->_config;
        $html = false;
        $html .= "<div id='search_box_{$shortcode->table_id}' class='wpt_search_box search_box_{$shortcode->table_id}'>";
        $html .= '<div class="search_box_fixer">'; //Search_box inside fixer
        $html .= '<h3 class="search_box_label">' . $config_value['search_box_title'] . '</h3>';
        $html .= "<div class='search_box_wrapper'>";

        /**
         * Search Input Box
         * At Version 3.3, we have changed few features
         */
        $html .= "<div class='search_single search_single_direct'>";
        
        $search_keyword = isset( $_GET['search_key'] ) ? sanitize_text_field( $_GET['search_key'] ) : '';
        

        $single_keyword = $config_value['search_keyword_text'];//__( 'Search keyword', 'wpt_pro' );
        $search_order_placeholder = $config_value['search_box_searchkeyword'];//__( 'Search keyword', 'wpt_pro' );
        $html .= "<div class='search_single_column'>";
        $html .= '<label class="search_keyword_label single_keyword" for="single_keyword_' . $shortcode->table_id . '">' . $single_keyword . '</label>';
        $html .= '<input data-key="s" value="' . $search_keyword . '" class="query_box_direct_value" id="single_keyword_' . $shortcode->table_id . '" value="" placeholder="' . $search_order_placeholder . '"/>';
        $html .= "</div>";// End of .search_single_column

        ob_start();
        /**
         * Used following hook to insert two insert other field
         * such:
         * Order By, Order and On sale
         * 
         * @author Saiful Islam <codersaiful@gmail.com>
         */
        
        do_action( 'wpto_search_box_basics', $shortcode->table_id, $config_value, $shortcode->orderby, $shortcode->order );
        $html .= ob_get_clean();

        $html .= "</div>"; //end of .search_single
        
        if( is_string( $taxonomy_keywords ) && ! empty( $taxonomy_keywords ) ){
            $taxonomy_keywords = wpt_explode_string_to_array( $taxonomy_keywords );
        }

        /**
         * Texonomies Handle based on $taxonomy_keywords
         * Default cat and tag for product
         * 
         * @since 1.9
         * @date 10.6.2018 d.m.y
         */
        if( is_array( $taxonomy_keywords ) && count( $taxonomy_keywords ) > 0 ){
            foreach( $taxonomy_keywords as $texonomy_name ){
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