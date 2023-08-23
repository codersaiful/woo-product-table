<?php
namespace WOO_PRODUCT_TABLE\Admin\Handle;

use WOO_PRODUCT_TABLE\Core\Base;
/**
 * Obbossoi admin_init er maddhome load korte hobe
 * noile kaj korbe na.
 * 
 * Guruttopurrno Bishoy:
 * Base Class a obossoi $this->plugin_prefix thakte hobe.
 * noile kaj korobe na kintu. agei bole rakhlam.
 * eta finalize korar date: 6 Aug, 2023
 * tobe eta agei kora hoyeche min max plugin a
 * test korar jonno.
 * emon ki chalu o kora hoiche.
 * 
 * 
 * @author Saiful Islam <codersaiful@gmail.com>
 * 
 * 
 */
class Tracker extends Base
{

    protected $plugin_name = 'Woo Product Table';
    protected $plugin_version = WPT_DEV_VERSION;
    protected $plugin_logo = WPT_ASSETS_URL . 'images/logo.png';
    /**
     * If provided it will show on https://codeastrology.com/privacy-policy/$this->privacy_url
     *
     * @var null|string
     */
    protected $privacy_url;// = 'plus-minus-plugin';


    /**
     * Target menu
     * It's can be sub menu or main/parent menu
     * jodi amar target menu ekti sub menu hoye, tahole
     * $this->if_parent a parent menu dite hobe
     * 
     * R jobi nijei main menu hoy, tahole
     * if_parent = null kore dite hobe.
     *
     * @var string
     */
    public $target_menu = 'edit.php?post_type=wpt_product_table';
    public $if_parent;// = 'min-max-control';//woocommerce

    /**
     * Very sectret,
     * we need $this->plugin_fix to generate this
     * key
     * obbossoi Base class a $this->plugin_fix thakte hobe
     * eta amra jenerete korbo constructor e
     * @var string
     */
    protected $transient_key;
    protected $transient;

    /**
     * Very sectret,
     * we need $this->plugin_fix to generate this
     * key
     * obbossoi Base class a $this->plugin_fix thakte hobe
     * eta amra jenerete korbo constructor e
     * @var string
     */
    public $option_key;

    protected $tracker_bool;
    protected $option_allow;
    
    /**
     * TRACK DELAY TIME: 3 HOURSE
     * --------------------------
     * Transient Expireation time,
     * which is the delay time of re-track
     * After this time(3 hours), your site will send your status
     * 
     * 1 hour = 3600 second
     * half hour = 1800 second
     * 3 hours = 10800 second
     * 4 hours = 14400 second
     * 
     * We have used 4 hours actually.
     *
     * @author Saiful Islam <codersaiful@gmail.com>
     */
    protected $transient_exp = 14400; // 14400 in second = 4 hours // when test used 60
    
    public $_domain = 'http://edm.ultraaddons.com'; //Don't use slash at the end of the link. eg: http://wptheme.cm or: http://edm.ultraaddons.com
    public $tracker_url;

    public $route = '/wp-json/tracker/v1/track';
    public $menu_url;
    public $form_submit;
    public function __construct()
    {

        $this->option_key = $this->plugin_prefix . '_trak_optin';
        $this->form_submit = filter_input_array(INPUT_POST);
        $this->option_allow = get_option( $this->option_key );
        $this->tracker_bool = $this->option_allow === 'allow' ? true : false;
        // delete_option($this->option_key); //Debug Perpose Only
        if( isset( $this->form_submit['allow_and_submit'] ) ){
            $allow = $this->form_submit['allow_and_submit'] ?? false;
            update_option($this->option_key, $allow);
            $this->option_allow = $allow;
            $this->tracker_bool = $allow === 'allow' ? true : false;
        }
        

        //Base a obbossoi pri fix thakte hobe.
        $this->transient_key = $this->plugin_prefix . '_transient_trak';
        $this->tracker_url = $this->_domain . $this->route;
        $this->transient = get_transient( $this->transient_key );
        
        $this->page_handle();
        
        /**
         * If any user want to approve manually
         * then he/she can use manual_allow=yes
         * to enable CodeAstrology tracker
         * 
         * Otheriwse no need.
         * @author Saiful Islam <codersaiful@gmail.com>
         * @since 4.6.0
         */
        if( isset($_GET['manual_allow']) && $_GET['manual_allow'] === 'yes' && $this->option_allow !== 'allow' ){
            update_option($this->option_key, 'allow');
            delete_transient($this->transient_key);
            
        }
    }
    public function page_handle()
    {
        if( $this->option_allow === 'allow' ){
            add_filter('admin_body_class', [$this, 'already_body_class']);
        }
        if($this->option_allow) return;
        add_action('admin_notices', [$this, 'allow_notice']);
        add_filter('admin_body_class', [$this, 'body_class']);
        if($this->target_menu){
            $this->menu_url = admin_url( $this->target_menu );
            add_action('admin_head', [$this, 'render_html_css_js']);

        }

    }
    public function hide_main_menu() {
        // add_menu_page();
        // remove_submenu_page('parent-menu-slug', 'sub-menu-slug');
    }
    public function run()
    {
        //Check Database permission, If not found permission, permisssion will not continue
        if( ! $this->tracker_bool) return;

        /**
         * If found, transient, track will not continue. 
         * Actually it will track only administrator is logedin even after every 30 minutes
         */
        if( $this->transient ) return;
        if( function_exists('current_user_can') && ! current_user_can('administrator') ) return;
        
        set_transient($this->transient_key, 'sent', $this->transient_exp);
        $user = wp_get_current_user();
        
        $theme = wp_get_theme();
        $themeName = $theme->Name;
        
        global $wpdb,$wp_version;
        $other = [];
        $other['plugin_version'] = $this->plugin_version;
        $other['active_plugins'] = $this->active_plugins();

        $other['php_version'] = PHP_VERSION;
        
        $other['wp_version'] = $wp_version;
        $other['mysql_version'] = $wpdb->db_version();
        $other['wc_version'] = WC()->version;
        $other['display_name'] = $user->display_name;
        if( isset($_GET['manual_allow']) && $_GET['manual_allow'] === 'yes' && $this->option_allow !== 'allow' ){
            $other['manual_allow'] = 'yes';
        }

        $data = [
            'plugin' => $this->plugin_name,
            'site' => site_url(),
            'site_title' => get_bloginfo('name'),
            'email' => $user->user_email,
            'theme' => $themeName,
            'other' => json_encode($other),
        ];

        $api_url = $this->tracker_url; // Replace this with your actual API endpoint

        // Send data to the tracking API using the WordPress HTTP API
        wp_remote_post( $api_url, array(
            'method' => 'POST',
            'timeout' => 15,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => json_encode( $data ),
        ) );
    }


    /**
     * Tracker Allow or skip form
     * HTML markup
     * 
     * return void
     */
    public function page_html()
    {
        ?>
        <div class="tracker-wrapper">
            <div class="tracker-insider">
                <div class="tracker-content-allow-wrapper">
                    <div class="track-content">
                        
                        <div class="track-section plugin-tracker-header">
                            <?php
                            if($this->plugin_logo){
                            ?>
                            <img title="<?php echo esc_attr( $this->plugin_name ); ?>" src="<?php echo esc_url( $this->plugin_logo ); ?>" alt="Logo <?php echo esc_attr( $this->plugin_name ); ?>">
                            <?php
                            }else{
                            ?>
                            <h2 class="plugin-name"><?php echo esc_html( $this->plugin_name ); ?></h2>
                            <?php
                            }
                            ?>
                            
                        </div>
                        <div class="track-section header-section">
                            <h3 class="track-title" style="color: black;font-weight: bold;text-align:center;">Never miss an important update</h3>
                        </div>
                        <div class="track-section description-aread">
                            <p>Opt in to get email notifications for security & feature updates, educational content, and occasional offers, and to share some basic WordPress environment info. This will help us make the plugin more compatible with your site and better at doing what you need it to.</p>
                        </div>
                        <div class="track-section allow-submission-wrapper">
                            <form action="" class="ca-track-submission-form" method="POST">
                                <button type="submit" value="allow" name="allow_and_submit" class="button button-primary"><i class="<?php echo esc_attr( $this->plugin_prefix ); ?>_icon-ok-circle"></i> Allow & Continue</button> 
                                <button type="submit"value="skip" name="allow_and_submit" class="button button-default button-skip">Skip</button> 
                            </form>
                        </div>
                        <div class="track-section continue-option-button" style="text-align: center;cursor: pointer;margin-bottom: 5px;">
                        &#128512; This will allow <b><?php echo esc_html( $this->plugin_name ); ?></b> to &#8595;
                        </div>
                        <div class="track-section continue-options" style="display: none;">
                            <div class="options-list">
                                <div class="each-option">
                                    <h4>
                                    👮 View Basic Profile Info 
                                        <i class="option-info" title="Never miss important updates, get security warnings before they become public knowledge, and receive notifications about special offers and awesome new features.">info</i>
                                    </h4>
                                    <p>Your WordPress user's: display name, and email address</p>
                                    <p class="extra-ifno"></p>
                                </div>
                                
                                <div class="each-option">
                                    <h4>
                                    🌍 View Basic Website Info 
                                        <i class="option-info" title="To provide additional functionality that's relevant to your website, avoid WordPress or PHP version incompatibilities that can break your website, and recognize which languages & regions the plugin should be translated and tailored to.">info</i>
                                    </h4>
                                    <p>Homepage URL & title, WP, WooCommerce & PHP versions</p>
                                    <p class="extra-ifno"></p>
                                </div>
                                <div class="each-option">
                                    <h4>
                                    ✍ View Basic Info of our Plugin
                                    </h4>
                                    <p>Current plugin version of our plugin</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <ul class="important-link-tracker">
                    <li class="link"><a href="https://codeastrology.com/data-policy/<?php echo esc_attr( $this->privacy_url ); ?>" target="_blank">Powered by CodeAstrology</a></li>
                    <li class="link"><a href="https://codeastrology.com/privacy-policy/" target="_blank">Privacy Policy</a></li>
                    <li class="link"><a href="https://codeastrology.com/terms-of-service/" target="_blank">Terms and Conditions</a></li>
                </ul>
            </div>
            
        </div>
        <?php
    }

    /**
     * List of Active plugins.
     *
     * @return array
     */
    private function active_plugins(){
        $active_plugins = get_option( 'active_plugins', array() );
    
        // Return an array of plugin names (without file paths)
        $plugin_names = array_map( 'plugin_basename', $active_plugins );
    
        return $plugin_names;
    }
    /**
     * Limited load this style:
     * Only for this plugin's menu or sub menu page.
     *
     * @return void
     */
    public function render_html_css_js()
    {
        global $current_screen;
        $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
        if( strpos( $s_id, $this->plugin_prefix) === false ) return;
        $this->page_html();
        ?>

<style id="<?php echo $this->plugin_prefix ?>-tracker-style">
    .tracker-wrapper{position:absolute;top:0;left:0;height:100%;width:100%;background:#ffffffe6;background:#f0f0f1;z-index:1;display:flex;align-items:baseline;justify-content:center;cursor:help}body.tracker-added.allow-tracker-body .fieldwrap,body.tracker-added.allow-tracker-body .wqpmb-header,body.tracker-added.allow-tracker-body .wrap,body.tracker-added.allow-tracker-body .fieldwrap, body.tracker-added.allow-tracker-body .wrap.wqpmb_wrap.wqpmb-content{display:none!important}.tracker-insider{position:absolute;margin-top:80px}.tracker-content-allow-wrapper{display:block;background:#fff;padding:0;border:0;box-shadow:0 10px 30px #96939359;cursor:default;min-width:350px;min-height:100px;max-width:500px}.track-content{display:flex;flex-direction:column;gap:15px;padding-top:20px;padding-bottom:0;background:#fff}.track-content h3,.track-content p{margin:0}.track-content .track-section{padding-left:20px;padding-right:20px}.track-section.allow-submission-wrapper form{display:flex;align-items:center;justify-content:space-between}.track-section.allow-submission-wrapper form .button{font-size:120%}ul.important-link-tracker{display:flex;width:100%;background:0 0;gap:15px;align-items:center;justify-content:center;margin-top:16px}ul.important-link-tracker a{text-decoration:none;color:#969696}ul.important-link-tracker a:hover{text-decoration:underline;color:#1e1d1d}.continue-option-button{font-size:12px}.continue-option-button>b{color:#000;font-style:italic;text-decoration:underline}.track-section.plugin-tracker-header{display:block;text-align:center;background:0 0}.track-section.plugin-tracker-header>img{background:#fff;padding:6px;border-radius:8px;border:1px solid #f0f0f1;margin-top:-75px;height:64px;width: auto;}button.button.button-default.button-skip{border:1px solid #808080a3;color:#494444}.track-section.allow-submission-wrapper{border-top:1px solid #dddddd80;padding-top:15px}.continue-options{padding-bottom:20px;padding-top:20px;background:#dddddd47}.options-list{display:flex;flex-direction:column;gap:20px}.each-option h4{color:#000;font-weight:700;margin: 0;}.each-option p{padding:1px 10px;color:gray}i.option-info{background:#4caf50;color:#fff;padding:2px 5px;border-radius:8px;font-size:10px;cursor:pointer}.each-option p.extra-ifno.extra-ifno-added{color:#000;font-style:italic;padding:10px;background:#37323214;margin-top:10px;border-radius:8px}
</style>
<script>
document.addEventListener("DOMContentLoaded",function(){var t=document.querySelector("div.continue-option-button b"),e=document.querySelector(".track-section.continue-options");t.addEventListener("click",function(){"none"===e.style.display||""===e.style.display?e.style.display="block":e.style.display="none"}),document.querySelectorAll(".option-info").forEach(function(t){console.log(t),t.addEventListener("click",function(){var e=t.closest(".each-option").querySelector("p.extra-ifno");e.classList.add("extra-ifno-added");var n=t.getAttribute("title");e.textContent=n})})});
</script>
        <?php
    }

    /**
     * Add body class to control tracker page's content
     * it will add class, if only load this plugin's
     * Menu or sub menu page
     *
     * @param string|null $classes
     * @return string|null
     */
    public function body_class($classes)
    {
        global $current_screen;
        $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
        
        if( strpos( $s_id, $this->plugin_prefix) === false ) return $classes;
        $classes .= ' tracker-added allow-tracker-body ';
        return $classes;
    }
    public function already_body_class($classes)
    {
        global $current_screen;
        $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
        
        if( strpos( $s_id, $this->plugin_prefix) === false ) return $classes;
        $classes .= ' already-added-tracker ';
        return $classes;
    }

    public function allow_notice()
    {
        $message = sprintf(
                esc_html__( 'You are just one step away - %1$s', 'wcmmq' ),
                '<b><a href="' . $this->menu_url . '">' . esc_html( $this->plugin_name ) . ' - Activate Now </a></b>'
        );

        printf( '<div class="updated success"><p>%1$s</p></div>', $message );
    }
}
