<?php 
namespace CA_Framework\App\Base;

if( ! class_exists( 'CA_Framework\App\Base\Notice_Base' ) ){

    class Notice_Base
    {
        public function __construct()
        {
            //Check, If only Admin User
            //if( ! is_admin() ) return;
    
            add_action("admin_enqueue_scripts", [$this, "enqueue"]);
            add_action("wp_ajax_update_notice_status", [$this, "update_notice_status"]);
        }

        /**
         * Enqueue Scripts
         */
        public function enqueue(){
            wp_enqueue_style(
                "ca-notice-css",
                $this->plugin_path() . "assets/css/ca-notification.css",
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                "ca-notice-update-js",
                $this->plugin_path() . "assets/js/ajax-update.js",
                "",
                '1.0.0',
                false
            );
    
            wp_localize_script("ca-notice-update-js", "ajaxobj", [
                "ajaxurl" => admin_url("admin-ajax.php"),
                'nonce'   => wp_create_nonce('ajax-nonce'),
            ]);
        }
        

        /**
         * plugin path
         */
         public function plugin_path(){
            $assets_path = CA_FRAMEWORK_URL;
            return $assets_path;
         }

        /**
         * Update Option by Ajax
         */
        public function update_notice_status(){

            $nonce = sanitize_text_field(wp_unslash($_POST['nonce'] ?? ''));
            if ( empty($nonce) || ! wp_verify_nonce( $nonce, plugin_basename(__FILE__) ) ) {
                echo '';
                wp_die();
            }

            $fonded_notc_id = absint( wp_unslash( $_POST['notice_id'] ?? 0 ) );
            if( $fonded_notc_id ){
                update_option( sanitize_key( $fonded_notc_id ) .'_notice_close_date', current_time( 'timestamp' ) );
                wp_die();
            }
            wp_die();
        }

    }

    
}
