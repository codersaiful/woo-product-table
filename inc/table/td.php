<?php 
namespace WOO_PRODUCT_TABLE\Inc\Table;

use WOO_PRODUCT_TABLE\Inc\Shortcode;
use WOO_PRODUCT_TABLE\Inc\Handle\Table_Attr;

class Td extends Row{
    public $keyword;
    public $row_base;
    public function __construct( Shortcode $shortcode, string $keyword )
    {
        parent::__construct( $shortcode );
        global $product;
        // $this->row_base = $row;
        $this->keyword = $keyword;
        // var_dump($row->column_settings);
        var_dump($this->base);
        // $this->items_permanent_dir = WPT_DIR_BASE . 'includes/items/';
        // $this->items_permanent_dir = apply_filters('wpto_item_permanent_dir', $this->items_permanent_dir, $this->table_id, $product );
        // $this->items_directory = apply_filters('wpto_item_dir', $this->items_permanent_dir, $this->table_id, $product );
        
    }

    public function render(){

    }
}