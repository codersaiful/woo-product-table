<?php 
namespace CA_Framework\Form\Inc;

class From_Control
{
    private static $types = array();

    private static function add_types_return( $input_name = 'text' )
    {
        if( ! is_string( $input_name ) ) return 'text';
         
        self::$types[ $input_name ] = $input_name;
        return $input_name;
    }
    
    public static function input()
    {
        return self::add_types_return('input');
    }
    
    public static function number()
    {
        return self::add_types_return('number');
    }
    
    
    public static function textarea()
    {
        return self::add_types_return('textarea');
    }
    
    public static function checkbox()
    {
        return self::add_types_return('checkbox');
    }
    
    public static function radio()
    {
        return self::add_types_return('radio');
    }

}