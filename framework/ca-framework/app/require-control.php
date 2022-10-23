<?php 
namespace CA_Framework\App;

use CA_Framework\App\Base\Notice_Base as Notice_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( ! class_exists( 'CA_Framework\Require_Control' ) ){


    class Require_Control extends Notice_Base
    {
        private $plugin_slug;
        private $plugin_slug_pure;
        private $this_slug;
        private $plugins = array();
        private $plugin = array();
        private $this_plugin = array();
        private $plugin_name;
        private $this_plugin_name;
        private $args = array();

        private $status;

        public $download_link;
        public $this_download_link;

        public $required = false;

        public $notice_id;
        public $diff_limit = 5;

        private $message;

        /**
         * Declear your Action Hook, where you want to show
         * your Notice/Message/Offer
         *
         * @var String|Null 
         */
        private $location;


        private $sample_plugin = array(
            'Name' =>   'Requrie Plugin',
            'PluginURI' => 'https://profiles.wordpress.org/codersaiful/#content-plugins',
        );

        private $stop_next = 0;
        private $file = __FILE__;

        /**
         * Controller of Manage required/recommended plugin.
         * This controller will work only for wp repo. it will not work for github repo.
         * 
         *
         * @param String $req_plugin_slug Plugin's slug with file directory. such: woocommerce/woocommerce.php
         * @param String $this_slug Own plugin slug, where you want to set condition
         * @param array $args All other data, we will collect over here. Such: Plugin name, and location.
         */
        public function __construct( $req_plugin_slug,$this_slug, $args = array() )
        {
            parent::__construct();

            $this->plugin_slug = $req_plugin_slug;

            // Check required plugin active or not at the beginign Pase Perperty generating, If already our required plugin is installed.
            if( is_plugin_active( $this->plugin_slug ) ) return;

            $this->plugin_slug_pure = strtok( $this->plugin_slug, '/' );
            $this->this_slug = $this_slug;
            $this->args = is_array( $args ) ? array_merge( $this->sample_plugin, $args ) : $this->sample_plugin;

            $this->plugins = get_plugins();
            $this->plugin = $this->get_plugin();
            $this->this_plugin = $this->get_this_plugin();
            // if( empty( $this->plugin ) ){
            //     $this->plugin = $this->args;
            // }
            $this->plugin_name = $this->get_plugin_name();
            $this->this_plugin_name = $this->get_this_plugin_name();
            
            $this->status = $this->check_status();

            $this->notice_id = $this->plugin_slug_pure;

        }
        
        public function stop_next()
        {
            return $this->stop_next;
        }

        public function run()
        {
            // Return null, If already our required plugin is installed.
            if( is_plugin_active( $this->plugin_slug ) ){ 
                return;
            }

            if( $this->required && ! is_plugin_active( $this->plugin_slug ) ){
                $this->stop_next = 1;
            };

            //Check Admin User
            if( ! is_admin() ){ 
                return;
            }
            
            //Return Null Controll;
            if( isset( $_GET['action'] ) && ( $_GET['action'] == 'install-plugin' || $_GET['action'] == 'activate' ) ){
                $this->stop_next = 1;
                return;
            }

            //Check Aganin installation prosibility when reconneded and Date over. by default we set diff_limit = 5 days.
            if( ! $this->required && $this->repeat_display() ) return;

            if( $this->location ){
                add_action( $this->location , [$this, "display_notice"]);
            }else{
                add_action( 'admin_notices', [ $this, 'display_notice' ] );
            }
            
            return;
        }

        public function set_location( $location )
        {
            $this->location = $location;
            return $this;
        }
        /**
         * Get File information, from where class is calling.
         * It's required for debugging.
         *
         * @return String Get File information, from where class is calling.
         */
        public function get_file(){
            return $this->file;
        }
        
        /**
         * Display Notice Again after close using close button
         * I have taken help for this part of Notice's Object js part
         * 
         * as ID, I have use target plugin's pure slug
         * 
         * *****************
         * IMPORTANT
         * *****************
         * When Notice is not required, then this repeat_display() method will impact
         *
         * @return boolean
         */
        public function repeat_display()
        {
            $close_date   = get_option( $this->notice_id . "_notice_close_date");
            
            if( ! empty($close_date) && is_numeric( $close_date )){
                $close_date		        = date("Y-m-d", $close_date);
    
                $date				    = new \DateTime($close_date);
                $now 				    = new \DateTime();
                $date_diff = $date->diff($now)->format("%d");
            }else{
                $date_diff = 99999;
            }
                            
            
            
            if( $date_diff >= $this->diff_limit ){
                return false;
            }
            return true;
        }
        public function return_null()
        {
            if( isset( $_GET['action'] ) && ( $_GET['action'] == 'install-plugin' || $_GET['action'] == 'activate' ) ) return;
        }

        /**
         * It's Very important, If already not set over third argument of this class constructor
         *
         * @param array $args
         * @return object
         */
        public function set_args( $args )
        {
            $this->args = is_array( $args ) ? array_merge( $this->sample_plugin, $args ) : $this->sample_plugin;
            return $this;
        }

        /**
         * Its an additional message.
         *
         * @param String $message
         * @return object
         */
        public function set_message($message)
        {
           $this->message = $message;
           return $this;
        }

        public function set_download_link( $download_link )
        {
            $this->download_link = $download_link;
            return $this;
        }
        public function set_required()
        {
            $this->required = true;
            return $this;
        }
        public function set_this_download_link( $this_download_link )
        {
            $this->this_download_link = $this_download_link;
            return $this;
        }

        

        public function get_plugins()
        {
            return $this->plugins;
        }

        /**
         * If originally Plugin in get_plugins() list, then it will return a array list of this
         * existing plugin. Otherwise, it will return an empty array.
         * 
         * I will use $this->get_plugin bcz I set a default array for this property.
         *
         * @return array
         */
        private function get_plugin()
        {
            return $this->plugins[$this->plugin_slug] ?? array();
        }

        private function get_this_plugin()
        {
            return $this->plugins[$this->this_slug] ?? array();
        }


        
        /**
         * It will return a name of Plugin.
         * If plugin already available in plugin list, then it will return Original name,
         * otherwise, it will come from $args
         *
         * @return String|null
         */
        private function get_plugin_name()
        {
            return $this->plugin['Name'] ?? null;
        }


        private function get_this_plugin_name()
        {
            return $this->this_plugin['Name'] ?? null;
        }


        private function check_status(){
            if( ! $this->plugin_name ) return 'install';
            if( ! is_plugin_active( $this->plugin_slug ) ) return 'activate';
        }

        public function gen_link()
        {
            $url = '';
            if($this->status == 'install'){
                $url = wp_nonce_url( self_admin_url( 'update.php?action=' . $this->status . '-plugin&plugin=' . $this->plugin_slug_pure ), $this->status . '-plugin_' . $this->plugin_slug_pure );
            }
            if($this->status == 'activate'){
                $url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $this->plugin_slug . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $this->plugin_slug );
            }

            return $url;
        }

        public function get_final_plugin_name()
        {
            return $this->plugin_name ? $this->plugin_name : $this->args['Name'];
        }

        /**
         * Get required plugin name with link or strong, if not found download link
         *
         * @return String
         */
        public function get_full_plugin_name()
        {
            $p_name = $this->get_final_plugin_name();
            if( $this->download_link ){
                $plugin_link = "<a href='{$this->download_link}' target='_blank'>{$p_name}</a>";
            }else{
                $plugin_link = "<strong>{$p_name}</strong>";
            }
            return $plugin_link;
        }

        /**
         * Get This plugin name with link or strong, if not found download link
         *
         * @return String
         */
        public function get_full_this_plugin_name( $custom_name = false )
        {
            if(!empty( $custom_name )){
                $this->this_plugin_name = $custom_name;
            }
            $p_name = $this->this_plugin_name;
            if( $this->this_download_link ){
                $plugin_link = "<a href='{$this->this_download_link}' target='_blank'>{$p_name}</a>";
            }else{
                $plugin_link = "<strong>{$p_name}</strong>";
            }
            return $plugin_link;
        }

        public function get_order_message()
        {
            if( $this->status == 'install' ) return __( 'to be Install and Activated.', 'ca-framework' );
            if( $this->status == 'activate' ) return __( 'to be Activated.', 'ca-framework' );
            if( $this->status == 'upgrade' ) return __( 'to be Upgrade Version.', 'ca-framework' );
        }




        /**
         * Display notice method
         * If found everything ok, then this method will execute under admin_notice hook
         * this method was call on run() method.
         * 
         * @since 1.0.0.12
         * @author Saiful Islam <codersaiful@gmail.com>
         *
         * @return void
         */
        public function display_notice(){

            //Check required plugin active or not at the beginign
            if( is_plugin_active( $this->plugin_slug ) ) return;

            //Check User Permission 
            if ( ! current_user_can( 'activate_plugins' ) ) return;

            $recommend = $this->required ? __( 'Requires', 'ca-framework' ) : __( 'Recommends', 'ca-framework' );
            $order_message = $this->get_order_message();
        
            $p_name = $this->get_full_plugin_name(); //Requried plugin full name, with strong or download link
            $this_p_name = $this->get_full_this_plugin_name(); //This onw plugin full name, with strong or download link
            
            $message = "$this_p_name $recommend $p_name $order_message";
            if($this->message){
                $message .= "<span class='ca-notice-custom-msg'>" . $this->message . "</span>";
            }
            $notice_class = 'notice notice-error';
            if($this->location){
                $notice_class = 'anwwhere-notice anywhere-required-plugin';
            }

            $required = $this->required;
            ?>
            <div data-notice_id="<?php echo esc_attr( $this->notice_id ); ?>" class="<?php echo esc_attr( $this->status ); ?> ca-notice ca-reuire-plugin-notice <?php echo esc_attr( $notice_class ); ?>">
                <p class="ca-require-plugin-msg" ><?php echo wp_kses_post( $message ); ?></p>
                <p class="ca-button-collection">
                    <a href="<?php echo esc_url( $this->gen_link() ); ?>" class="ca-button"><?php echo esc_attr( $this->status ); ?></a>
                </p>
                
                <?php
                if( ! $required ){
                ?>
                <button class="ca-notice-dismiss"></button>
                <?php
                }
                ?>
            </div>
            <?php 
        }
    }
}
