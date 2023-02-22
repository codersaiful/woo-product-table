<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Mini_Filter{
    public static $keywords;
    public static $table_id;
    public static $filter_text;
    public static $filter_reset_button;
    public static function render( Shortcode $shortcode ){
        self::$table_id = $shortcode->table_id;
        self::$filter_text = $shortcode->_config['filter_text'] ?? '';
        self::$filter_reset_button = $shortcode->_config['filter_reset_button'] ?? '';
        self::$keywords = $shortcode->search_n_filter['filter'] ?? [];
        ?>
        <div class="wpt-mini-filter-wrapper">
            <div class="wpt-mini-filter">
                <?php echo self::filter_box(); ?>
            </div>
        </div>
        <?php 
    }

    public static function filter_box(){
        $html = $html_select = false;
        
        
        if( is_string( self::$keywords ) && ! empty( self::$keywords ) ){
            self::$keywords = wpt_explode_string_to_array( self::$keywords );
        }
        

        /**
         * Texonomies Handle based on $search_box_texonomiy_keyword
         * Default cat and tag for product
         * 
         * @since 20
         * @date 11.6.2018 d.m.y
         */
        if( is_array( self::$keywords ) && count( self::$keywords ) > 0 ){
            foreach( self::$keywords as $texonomy_name ){
                $html_select .= self::select_generate($texonomy_name);
            }
        }
        if( $html_select ){
            $html .= "<label>" . self::$filter_text . "</label>" . $html_select;
            $html .= '<a href="#" data-type="reset " data-temp_number="' . self::$table_id . '" id="wpt_filter_reset_' . self::$table_id . '" class="wpt_filter_reset wpt_filter_reset_' . self::$table_id . '">' . self::$filter_reset_button . '</a>';
        }
        return $html;
    }

    protected static function select_generate( $texonomy_name ){
        if( ! is_string( $texonomy_name ) ) return;
        
        $taxonomy_details = get_taxonomy( $texonomy_name );
        if( $taxonomy_details ){
            $label = $taxonomy_details->labels->singular_name;
        }else{
            $label = $texonomy_name;
        }
        
        $html = '';
        $label = apply_filters( 'wpt_minifilter_taxonomy_name', $label, $texonomy_name );
        $table_id = self::$table_id;
        $html .= "<select data-temp_number='{$table_id}' data-key='{$texonomy_name}' data-label='{$label}' class='filter_select filter filter_select_{$texonomy_name}' id='{$texonomy_name}_{$table_id}'>";
            
        $html .= "</select>";

        return $html;
    }
}