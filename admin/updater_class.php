<?php

class WOO_WPT_Plugin_updater{
    public $plugin_folder;
    public $plugin_file;
    public $item_code;
    public $json_root_url = 'https://codeastrology.com/Envato/plugin_info.php?';
    public $response_root_url = 'https://codeastrology.com/Envato/response.php?';
    public $purchase_Code;
    public $final_json_url;
    public $final_response_url;
    public $current_version;
    public $custom_update_message = "Need Security Code. Please Add Security Code. Then you will able to automaitcally update.";
    public $transient_limit_sec = 86400; //In Second
    private $transient_name;
    private $transient;
    public $remote_timeout = 10;



    public function __construct($purchase_Code = false,$item_code = false) {
        //$this->item_code = WOO_Product_Table::$item_id;
        $this->purchase_Code = $purchase_Code && !empty( $purchase_Code ) ? $purchase_Code : $this->purchase_Code;
        $this->item_code = $item_code && !empty( $item_code ) ? $item_code : $this->item_code;
        $this->final_json_url = $this->json_root_url . 'item_id=' . $this->item_code . '&license_key=' . $this->purchase_Code;
        $this->final_response_url = $this->response_root_url . 'license_key=' . $this->purchase_Code;
        $this->transient_name = md5(__DIR__);
        $this->transient = get_transient($this->transient_name);
    }
    
    public function setRootURL($url = false ) {
        $this->json_root_url = $url ? $url : $this->json_root_url;
    }
    
    public function seResponseURL($url = false ) {
        $this->response_root_url = $url ? $url : $this->response_root_url;
    }
    
    public function setUpdateMessage($msg = false) {
        $this->custom_update_message = $msg;
    }
    
    public function update_message( $plugin_info_array, $plugin_info_object ) {
        if( empty( $plugin_info_array['package'] ) ) {
		echo $this->custom_update_message;
	}
    }
    public function push_update($transient) {
        $remote['body'] = false;
        if($this->transient){
            $remote = $this->transient;
        }else{
            $remote = wp_remote_get( $this->final_json_url, array(
                'timeout' => $this->remote_timeout,//10,
                'headers' => array(
                        'Accept' => 'application/json'
                ) )
            );
        }
        
        
        if ( !is_wp_error( $remote ) && is_array($remote) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
            if(!$this->transient)
                set_transient( $this->transient_name,$remote, $this->transient_limit_sec );
            $remote = json_decode( $remote['body'] );
 
            // your installed plugin version should be on the line below! You can obtain it dynamically of course 
            if( $remote && version_compare( $this->current_version, $remote->version, '<' ) && version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {
                    $res = new stdClass();
                    $res->slug = $this->plugin_folder;//'woo-product-table-pro';
                    $res->plugin = $this->plugin_folder . '/' . $this->plugin_folder . '.php'; // it could be just woo-product-table-pro.php if your plugin doesn't have its own directory
                    $res->new_version = $remote->version;
                    $res->tested = $remote->tested;
                    $res->package = $remote->download_url;
                    $transient->response[$res->plugin] = $res;
                    $transient->checked[$res->plugin] = $remote->version;
            }
        }
        return $transient;
    }
    
    /**
     * Updating JSON data Transient, which will use for plugin update
     * 
     * @return Void Just will update json for plugin Update
     */
    public function updateJSONTransient() {
        $remote = false;
        $remote = wp_remote_get( $this->final_json_url, array(
            'timeout' => $this->remote_timeout,//10,$this->remote_timeout,//10,
            'headers' => array(
                    'Accept' => 'application/json'
            ) )
        );
        if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
            set_transient( $this->transient_name,$remote, $this->transient_limit_sec );
        }else{
            delete_transient( $this->transient_name );
        }
    }
    
    /**
     * Updating Transient for Response data, which will show in Avticate page
     * 
     * @return Void Nothing will return. Just will update Response Transient
     */
    public function updateResponseTransient() {
        $remote = false;
        $transient = get_transient($this->transient_name . '_response');
        $transient_limit = $this->transient_limit_sec;
        $remote = wp_remote_get( $this->final_response_url, array(
            'timeout' => $this->remote_timeout,//10,
            'headers' => array(
                    'Accept' => 'application/json'
            ) )
        );
        if ( !is_wp_error( $remote ) && is_array($remote) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
            $remote = json_decode( $remote['body'], true );
            set_transient( $this->transient_name . '_response',$remote, $transient_limit );
        }else{
            delete_transient( $this->transient_name . '_response' );
        }
    }
    /**
     * Both Transient update
     * Required: final_json_url,final_response_url
     * 
     * @return type
     */
    public function updateTransient() {
        $remote = false;
        $remote = wp_remote_get( $this->final_json_url, array(
            'timeout' => $this->remote_timeout,//10,$this->remote_timeout,//10,
            'headers' => array(
                    'Accept' => 'application/json'
            ) )
        );
        if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
            set_transient( $this->transient_name,$remote, $this->transient_limit_sec );
        }else{
            delete_transient( $this->transient_name );
        }
        
        $remote = false;
        $transient = get_transient($this->transient_name . '_response');
        $transient_limit = $this->transient_limit_sec;
        $remote = wp_remote_get( $this->final_response_url, array(
            'timeout' => $this->remote_timeout,//10,
            'headers' => array(
                    'Accept' => 'application/json'
            ) )
        );
        if ( !is_wp_error( $remote ) && is_array($remote) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
            $remote = json_decode( $remote['body'], true );
            set_transient( $this->transient_name . '_response',$remote, $transient_limit );
        }else{
            delete_transient( $this->transient_name . '_response' );
        }
    }
    
    public function getResponse() {
        
        $transient = get_transient($this->transient_name . '_response');
        $transient_limit = $this->transient_limit_sec;
        if($transient){
            return $transient;
        }else{
            $remote = wp_remote_get( $this->final_response_url, array(
                    'timeout' => $this->remote_timeout,//10,
                    'headers' => array(
                            'Accept' => 'application/json'
                    ) )
                );
            if ( !is_wp_error( $remote ) && is_array($remote) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
                $remote = json_decode( $remote['body'], true );
                set_transient( $this->transient_name . '_response',$remote, $transient_limit );
                return $remote;
            }else{
                delete_transient( $this->transient_name . '_response' );
            }
        }
        return false;
    }
    
    public function plugin_info($res, $action, $args ) {

        $remote['body'] = false;
        if($this->transient){
            $remote = $this->transient;
        }elseif($action == 'plugin_information' && $this->plugin_folder == $args->slug){ //'woo-product-table-pro'
            $remote = wp_remote_get( $this->final_json_url, array(
                'timeout' => $this->remote_timeout,//10,$this->remote_timeout,//10,
                'headers' => array(
                        'Accept' => 'application/json'
                ) )
            );
            set_transient( $this->transient_name,$remote, $this->transient_limit_sec );
        }
        if ( $action == 'plugin_information' && $this->plugin_folder == $args->slug && !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
            //if(!$this->transient)
                //set_transient( $this->transient_name,$remote, $this->transient_limit_sec );
            $remote = json_decode( $remote['body'] );
            $res = new stdClass();
            $res->name = $remote->name;
            $res->slug = $this->plugin_folder;// 'woo-product-table-pro';
            $res->version = $remote->version;
            $res->tested = $remote->tested;
            $res->requires = $remote->requires;
            $res->author = '<a href="' . $remote->author_homepage . '">' . $remote->author . '</a>';//'<a href="https://rudrastyh.com">Misha Rudrastyh</a>';
            $res->author_profile = $remote->author_homepage;//'https://profiles.wordpress.org/rudrastyh';

            $res->homepage = $remote->homepage;
            $res->download_link = $remote->download_url;
            $res->trunk = $remote->download_url;
            $res->last_updated = $remote->last_updated;

            $default_sections = [
                    "description" => "Add description section content to your controller",
                    "installation" => "(Recommended) Sample content",
                    "changelog" => "(Recommended) Sample content Changelog. <p>This section will be opened by default when the user clicks 'View version XYZ details'.</p>",
                    "custom_section" => "Sample content This is a custom section labeled 'Custom Section'." 
            ];

            $remote_sections = isset( $remote->sections ) && is_object( $remote->sections ) ? (array) $remote->sections : $default_sections;

            if( is_array( $remote_sections ) && count( $remote_sections ) > 0 ){
                foreach( $remote_sections as $per_key => $per_sec ){
                    $res->sections[$per_key] = is_string( $per_sec ) ? $per_sec : false;
                }
            }

            if( !empty( $remote->sections->screenshots ) ) {
                    $res->sections['screenshots'] = $remote->sections->screenshots;
            }


            $res->banners = array(
                    'low' => $remote->banners->low,//'http://localhost/plugin_update/another/banner-772x250.jpg',
                    'high' => $remote->banners->high,//'http://localhost/plugin_update/another/banner-1544x500.jpg'
            );
            $oneX = '1x';
            $twoX = '2x';
            $res->icons = array(
                    '1x' => $remote->icons->$oneX,//'http://localhost/plugin_update/another/banner-772x250.jpg',
                    '2x' => $remote->icons->$twoX,//'http://localhost/plugin_update/another/banner-1544x500.jpg'
            );

            //Rating
            $res->rating = $remote->rating;
            $res->num_ratings = $remote->num_ratings;
            $res->downloaded = $remote->downloaded;
            $res->active_installs = $remote->active_installs;


            $res->donate_link = $remote->donate_link;
            return $res;  
            
            
            
        }else{
            $remote = false;
        }
        return false;
        
        
    }
    
    public function getTransientName() {
        return $this->transient_name;
    }
    
    public function deleteTransient(){
        delete_transient( $this->transient_name );
        delete_transient( $this->transient_name . '_response' );
    }
    public function refresh_after_update( $upgrader_object, $options ) {
        if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
            $this->deleteTransient();
        }
    }

    public function start() {
        add_filter('plugins_api', array($this,'plugin_info'), 20, 3);
        add_filter('site_transient_update_plugins', array($this,'push_update'));
        add_action( 'in_plugin_update_message-' . $this->plugin_folder . '/' . $this->plugin_file . '.php', array( $this, 'update_message' ), 10, 2 );
        add_action( 'upgrader_process_complete', array( $this, 'refresh_after_update' ), 10, 2 );
    }
}