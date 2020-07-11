<?php
defined( 'ABSPATH' ) || exit;
if( !class_exists( 'WPT_TABLE' ) ){

    /**
     * This Class is now Inactive
     * Main Class has removed to Classes folder in this Director
     * Main Class of Advance Product Table
     * 
     * @package UltraTAble 1.0.0
     */
    class WPT_TABLE {
        private static $datas = array();
        public static $detect = false;
        private static $pr_detect = 'desktop';
        public static $device = false;
        private static $pr_device = false;

        private static $columns = false;
        private static $head = false;

        public static function init($datas) {
            self::$datas = $datas;
            self::$pr_detect = self::getDevice();
            self::$pr_device = isset( self::$datas['device'][self::$pr_detect] ) && is_array(  self::$datas['device'][self::$pr_detect] ) ? self::$datas['device'][self::$pr_detect] : false;
            self::setProperty();
        }

        public static function setProperty(){
            /**
             * $device means, not browsers device. It's from
             * Array where included device
             */
            $device = self::$pr_device;

            $d_status = isset( $device['status'] ) && $device['status'] == 'on' ? true : false;
            $d_columns = isset( $device['columns'] ) ? $device['columns'] : false;

            if( $d_status && is_array( $d_columns ) && count( $d_columns ) > 0 ){
                self::$detect = self::$pr_detect;
                self::$device = self::$datas['device'][self::$pr_detect];
                self::$columns = self::getActiveColumns( $d_columns );
                self::$head = self::getActiveColumns( $d_columns, 'head' );
                return true;
            }
            $desktop_clumns = isset( self::$datas['device']['desktop']['columns'] ) ? self::$datas['device']['desktop']['columns'] : false;


            if( is_array( $desktop_clumns ) && count( $desktop_clumns ) > 0  ){
                self::$detect = 'desktop';
                self::$device = self::$datas['device'][self::$detect];
                self::$columns = self::getActiveColumns( $desktop_clumns );
                self::$head = self::getActiveColumns( $desktop_clumns, 'head' );
                return true;
            }
            return;
        }

        public static function getActiveColumns( $fullColumns = false , $return = 'columns') {
            $columns = $head = false;

            if( !is_array( $fullColumns ) && count( $fullColumns ) < 1 ){
                return false;
            }

            foreach( $fullColumns as $item ){
                if( isset( $item['status'] ) &&  $item['status'] == 'on' && isset( $item['head'] )){
                    $columns[] = $item;
                    $head[] = $item['head'];
                }  
            }
            if( $return == 'head' ){
                return $head;
            }
            return $columns;
        }

        /**
         * Getting Columns based on Founded Device and Founded column from Array ($datas).
         * Suppose: device tablet but tablet args is not available in self::$datas, then it will return
         * desktop 's value.
         * Mainly for final selected column, we will use getCollumn() method
         * 
         * @hook wpt_get_column_datas FILTER
         * 
         * @return type ARRAY | false For Success: Array, for fail: false/null;
         */
        public static function getCollumns() {
            $columns = self::$columns;
            return apply_filters( 'wpt_get_column_datas', $columns );
        }

        public static function getFullwidth() {
            $fullwidth_items = false;
            if( !isset( self::$device['fullwidth'] ) )
                return;

            $fullwidth = self::$device['fullwidth'];
            $fullwidth = apply_filters( 'wpt_get_fullwidth_datas', $fullwidth );

            if( isset( $fullwidth['status'] ) 
                    && $fullwidth['status'] == 'on' && isset( $fullwidth['items'] ) ){
                $fullwidth_items = $fullwidth['items'];
            }


            if( is_array( $fullwidth_items ) && count( $fullwidth_items ) > 0 ){
                return $fullwidth;
            }
            return;

        }

        public static function desktopCollumns() {
            $desktop = false;
            if( !isset( self::$datas['device']['desktop'] ) )
                return;

            $desktop = self::$datas['device']['desktop'];

            if( isset( $desktop['status'] ) && $desktop['status'] == 'on' ){
                $desktop = $desktop['columns'];
            }

            return $desktop;
        }

        /**
         * Getting Status of Table Head, thead enable or disable status. Getting status from 
         * Main Array, $datas['head'] = 'on' OR $datas['head'] = 'off'
         * 
         * @hook wpt_is_table_head FILTER
         * 
         * @return Bool TRUE | FALSE table header on or off
         */
        public static function is_table_head(){
            $is_tbl_head = isset( self::$datas['head'] ) && self::$datas['head'] == 'on' ? true : false;
            return apply_filters( 'wpt_is_table_head', $is_tbl_head );
        }

        /**
         * Getting Table Head datas for generating Table head and TH of table head
         * User able to change Table Head array by using filter @hooks <b>wpt_head_datas</b>
         * Although User able to change table head datas from filter hook <b>wpt_get_column_datas</b>
         * 
         * @hook wpt_head_datas FILTER
         * 
         * @return ARRAY array of Table Head . Array of data for TH
         */
        public static function get_head(){
            $head = self::$head;
            return apply_filters( 'wpt_head_datas', $head );
        }

        public static function columnCount() {
            if( is_array( self::get_head() ) ){
                return count( self::get_head() );
            }
            return;
        }

        /**
         * Getting Device Object Info by Using Mobile_Detect Class
         * 
         * @hook for More: https://github.com/serbanghita/Mobile-Detect
         * 
         * @param type $userAgent
         * 
         * @return \Mobile_Detect Object
         * 
         * @link https://github.com/serbanghita/Mobile-Detect Getting Help for <b>Mobile_Detect</b>
         */
       public static function detectDevice( $userAgent = null ){
           $mobile_detect = new Mobile_Detect( null, $userAgent );
           return apply_filters( 'wpt_change_mobile_detect_object', $mobile_detect );
       }

       /**
        * Getting Device Info Here
        * this will return three value based on device in. Device info are getting from 
        * Mobile_Detect() Class / Object.
        * 
        * @hook wpt_chnage_device_data passing Mobile_Detect() through 2nd parameter. 
        * 
        * @hook_help for Mobile_Detect(), u can use some following method: isMobile(),isMobile() for more: https://github.com/serbanghita/Mobile-Detect
        * 
        * @return string Getting Device Name, Such: Mobile, Table or Desktop
        */
       public static function getDevice() {
           $device = 'desktop';
           $detect = self::detectDevice();

           if($detect->isTablet()){
               $device = "tablet";
           }elseif($detect->isMobile()){
               $device = "mobile";
           }
           $device = apply_filters( 'wpt_chnage_device_data', $device, self::detectDevice() );
           return $device;
       }
    }

}