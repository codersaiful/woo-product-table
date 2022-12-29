<?php
namespace WOO_PRODUCT_TABLE\Compatible\Plgins\Waitlist_Woocommerce;

class Loader{
    public function __construct()
    {
        add_filter( 'wpto_default_column_arr', [$this, 'waitlistColumn'] );
        add_filter( 'wpto_template_loc', [$this, 'waitlistColumnFile'], 10, 2 );
    }

    /**
     * Add a new column for Waitlist
     * @return $column_array
     * @author Fazle Bari
     * @since   3.3.5.0
     */
    public function waitlistColumn( $column_array ){
        $column_array['waitlist'] = 'Waitlist';
        return $column_array;
    }

    /**
     * Add file for the Waitlist column 
     * @return $file
     * @author Fazle Bari
     * @since   3.3.5.0
     */
    public function waitlistColumnFile( $file, $keyword ){
        if( 'waitlist' == $keyword ){
            $file = __DIR__ . '/waitlist-col.php';
        }
        return $file;
    }
    
}
new Loader();
