<?php
defined( 'ABSPATH' ) || exit;
if( !class_exists( 'WPT_ARGS_Manager' ) ){
    
    
    /**
     * Working on this File, Will cmplete later
     */
    class WPT_ARGS_Manager{
        public static function sanitize( $datas ) {
            
            
            
            
            if( isset( $datas['class'] ) && is_string( $datas['class'] ) ){
                $datas['class'] = self::stringToArray( $datas['class'] );
            }
            $datas['id'] = !isset( $datas['id'] ) ? 'wpt_product_table' : $datas['id'];
            $datas['head'] = !isset( $datas['head'] ) ? 'on' : $datas['head'];
            
            
            //Desktop Device is always Activate
            $datas['device']['desktop']['status'] = 'on';
            
            $suppoeted_device = array('desktop','tablet','mobile');
            $suppoeted_device = apply_filters( 'wpt_supported_device_arr', $suppoeted_device, $datas );
            
            
            //var_dump($datas['device']);
            if( is_array( $suppoeted_device ) && count( $suppoeted_device ) > 0 ){
                foreach( $suppoeted_device as $device_type ){
                    if( isset( $datas['device'][$device_type]['status'] )
                            && $datas['device'][$device_type]['status'] != 'on'){
                        unset( $datas['device'][$device_type] );
                    }
                    
                    if( isset( $datas['device'][$device_type]['columns'] ) ){
                        $temps = $datas['device'][$device_type]['columns'];
                        $temps = array_filter( $temps, function( $ins ){
                            return (isset($ins['status']) && $ins['status'] == 'on' );
                        } );
                        
                        $datas['device'][$device_type]['columns'] = $temps;
                    }
                    //For Fullwidth
                    if( isset( $datas['device'][$device_type]['fullwidth']['status'] )
                            && $datas['device'][$device_type]['fullwidth']['status'] != 'on'){
                        unset( $datas['device'][$device_type]['fullwidth'] );
                    }
                }
            }

            return $datas;
        }
        
        public static function stringToArray( String $sting) {
            $string = str_replace( ' ', '', $sting);
            return explode( ',', $string);
        }
        
        
    }
    
    
}