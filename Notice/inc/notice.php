<?php
namespace NTTC;
if ( ! class_exists( 'NTTC\Notice' ) ) {
    
    class Notice{
        private static $_instance;
        private $prefix = 'nttc_';
        private $option_name;
        public $types = array(
            'error',
            'warning',
            'info',
            'success'
        );
        public $type = 'info';
        public $title;
        public $message;
        private $notice_url,$template_dir;
        private $notices;
        private $show_notice = true;
        private $time_limit = 60*60*24*7;
        private $transient;
        private $transient_name;


        public function __construct($prefix = false) {
            if($prefix || empty( $prefix )) $this->prefix = $prefix;
            $this->option_name = $this->prefix . 'notice_dismiss_';
            //Transient name/keyword define
            $this->transient_name = $this->prefix . 'notice_transient_';
            $this->notice_url = plugins_url() . '/'. plugin_basename( dirname( __FILE__ ) ) . '/';
            $this->template_dir = __DIR__ . '/../templates/';
            
            //$notice_url //admin_enqueue_scripts
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
            
            add_action( 'wp_ajax_nopriv_dismission', array( $this, 'dismiss_notice_update' ) );
            add_action( 'wp_ajax_dismission', array( $this, 'dismiss_notice_update' ) );
        }
        
        public function add( $type,$notice_array = array(),$unique_id = false ) {
            if($type && is_string($type) && is_array( $notice_array ) && isset( $notice_array['message'] )){
                if($unique_id && !empty( $unique_id )){
                    $id = $unique_id;
                    $this->notices[$id] = array(
                        'type'      =>   $type,
                        'title'     => isset( $notice_array['title'] ) ? $notice_array['title'] : false,
                        'message'     =>   $notice_array['message'],
                        'unique_id' => $id,
                        'time_limit'=> isset( $notice_array['time_limit'] ) ? $notice_array['time_limit'] : $this->time_limit,
                        'buttons'   =>  isset( $notice_array['buttons'] ) && is_array( $notice_array['buttons'] ) ? $notice_array['buttons'] : false,
                    );
                }else{
                    $this->notices[] = array(
                        'type'      =>   $type,
                        'title'     => isset( $notice_array['title'] ) ? $notice_array['title'] : false,
                        'message'     =>   $notice_array['message'],
                        'time_limit'=> isset( $notice_array['time_limit'] ) ? $notice_array['time_limit'] : $this->time_limit,
                        'buttons'   =>  isset( $notice_array['buttons'] ) && is_array( $notice_array['buttons'] ) ? $notice_array['buttons'] : false,
                    );
                }
            }
            return;
        }
        
        public function addRemote($type = 'info',$uri = false, $time_limit = false) {
            if( empty($uri) || !filter_var($uri, FILTER_VALIDATE_URL)) return;
            
            //Getting Transient
            $this->transient = get_transient($this->transient_name);

            //Check existing Transient
            if($this->transient){
                $request = $this->transient;
            }else{
                $request  = wp_remote_get( $uri ,array(
                    'timeout' => 2,
                    'headers' => array(
                        'Accept' => 'application/json'
                    ),
                ));
                
                //If Error found, Return False
                if( is_wp_error( $request ) ) return;
                //Set Trans //Transient for half time of total time limit
                set_transient( $this->transient_name,$request, round( ($this->time_limit/2) ) );
            }

            $response = isset( $request['response'] ) ? $request['response'] : false;
            if( isset( $response['code'] ) && $response['code'] == 200 ){
                $this->notices[] = array(
                        'type'      =>   $type,
                        'message'     => isset( $request['body'] ) ? $request['body'] : false,
                        'time_limit'=> isset( $time_limit ) ? $time_limit : $this->time_limit,
                    );

            }
            
        }
        
        public function add_html($type,$file_name = false,$unique_id = false, $time_limit = false) {
            $template_file = $this->template_dir . $file_name . '.php';
            //var_dump(is_file( $template_file ));
            if($type && is_string($type) && $file_name && is_string( $file_name ) && is_file( $template_file ) ){
                ob_start();
                include $template_file;
                $message = ob_get_clean();
                
                if($unique_id && !empty( $unique_id )){
                    $id = $unique_id;
                    $this->notices[$id] = array(
                        'type'      =>   $type,
                        'message'   =>   $message,
                        'unique_id' => $id,
                        'time_limit'=> !empty( $time_limit ) ? $time_limit : $this->time_limit,
                    );
                }else{
                    $this->notices[] = array(
                        'type'      =>   $type,
                        'message'     =>   $message,
                        'time_limit'=> !empty( $time_limit ) ? $time_limit : $this->time_limit,
                    );
                }
                
                
            }
            return;
        }
        
        public function setTimeLimit( $seconds ) {
            if(is_int( $seconds )) $this->time_limit = $seconds;
        }
        
        public function setTimeLimitDay( $day_acmount ) {
            if( is_int( $seconds ) && $day_acmount > 0) $this->time_limit = 60*60*24*$day_acmount;
        }
        
        
        public function show_notice() {
            add_action( 'admin_notices', array( &$this,'show_admin_notice' ) );
        }
        public function hide_notice() {
            $this->show_notice = false;
        }
        
        //Currently disabled
        public function __destruct() {
            if($this->show_notice)
            add_action( 'admin_notices', array( &$this,'show_admin_notice' ) );
        }

        public function show_admin_notice() {
            $ajax_url = admin_url( 'admin-ajax.php' );//add_query_arg( array( 'myplugin_dismiss' => 'dissssmissssss' ), admin_url() );

            if(!is_array($this->notices)) return;
            foreach($this->notices as $notice){
                //var_dump($notice['buttons']);
                $type = isset( $notice['type'] ) ? $notice['type'] : 'info';
                $unique_id = isset( $notice['unique_id'] ) ? $notice['unique_id'] . '_' : false;
                $option_name = $this->option_name. $unique_id . $type;
                $timestamp = get_option( $option_name );
                $time_limit = $this->time_limit;
                
                //Setting time limit
                if( isset( $notice['time_limit'] ) && is_string( $notice['time_limit'] ) ){
                    //Six month in second 15552000 == 86400 * 30 * 6
                    $time_limit = 15552000;
                }elseif( isset( $notice['time_limit'] ) && is_numeric( $notice['time_limit'] ) ){
                    $time_limit = $notice['time_limit'];
                }

                if(!$timestamp || ( $timestamp + $time_limit ) < time() ){
                    
                    //Button in bottom Saite
                    $buttons = isset( $notice['buttons'] ) ? $notice['buttons'] : false;
                    
                    $title = isset( $notice['title'] ) ? $notice['title'] : false;
                    $message = isset( $notice['message'] ) ? $notice['message'] : false;
                    ?>
                    <div data-name="<?php echo esc_attr( $option_name );?>" class="notice is-dismissible nttc-notice <?php echo esc_attr( $this->prefix ); ?>-notice notice-<?php echo esc_attr( $type );?>" data-ajax-url="<?php echo esc_url( $ajax_url ); ?>">
                        <?php if( !empty( $title ) ){ ?>
                        <h2><?php echo $title; ?></h2>
                        <?php } ?>
                        <div class="notice_box">
                            <?php echo $message; ?>
                        </div>   
                        <?php
                        //Renderd Button
                        echo $this->renderButtons($buttons);
                        ?>
                    </div>
                    <?php
                }
            }
            
        }
        
        public function renderButtons($buttonsArray = false) {
            
            if(!$buttonsArray || !is_array( $buttonsArray ) || empty( $buttonsArray ) || is_array( $buttonsArray ) && count($buttonsArray) < 1) return;
            $html = "<div class='nttc_button_wrapper'>";
            foreach($buttonsArray as $button){
                $url = isset( $button['url'] ) ? $button['url'] : false;
                $text = isset( $button['text'] ) ? $button['text'] : false;
                $button_class = isset( $button['button_class'] ) ? $button['button_class'] : false;
                $html .= "<a href='{$url}' class='nttc_button {$button_class}' target='_blank'>$text</a>";
            }
            $html .= "</div>";
            return $html;
        }
        
        /**
         * Notice update with last time, so that can handle based on time
         * or can hide, if found time
         */
        public function dismiss_notice_update() {
            $option_name = isset( $_POST['name'] ) && !empty( $_POST['name'] ) && is_string( $_POST['name'] ) ? $_POST['name'] : false;
            if( update_option(  $option_name, time() ) ){
                echo $option_name;
            }else{
                echo "0";
            }
            die();
        }
        
        
        /**
         * Render main class by instance if need. Now it's still not used
         * 
         * @return Object
         */
        public static function get_instance(){
            if ( ! ( self::$_instance instanceof self ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        /**
         * enqueue file render
         * 
         * @return void adding css and javascript file
         */
        public function admin_enqueue_scripts() {
            $css = $this->notice_url . 'style.css'; //Getting CSS Style file URL
            $js = $this->notice_url . 'script.js'; //Getting Javascript script file URL
            wp_enqueue_style( $this->prefix . 'style', $css, array(), '1.0.0', 'all' );
            wp_enqueue_script( $this->prefix . 'js', $js, array( 'jquery' ), '1.0.0', true );
        }
    }

}