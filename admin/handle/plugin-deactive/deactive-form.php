<?php
namespace WOO_PRODUCT_TABLE\Admin\Handle\Plugin_Deactive;

/**
 * Plugin Deactivation form
 * 
 * UPDATE SOME PROPERTY:
 * ---------------------
 * 1. plugin_slug
 * 2. prefix
 * 3. text_domain
 * 4. localize_name VERY IMPORTANT AND NEED TO CHANGE FROM message.js file inside same folder
 * 
 * **UPDATE**
 * ----------------------
 * Now no need Base Class, I have all created to this class
 * 
 * 
 * REMEMBER:
 * ----------------------
 * 1. JS/CSS file stored at assets/cssOrjs folder
 * so, jodiKopi korteChai, tahole taSei folder a kopiKore rakhoteHobe
 * and moneRakhte hobeJe: localizeNameTo be obviously replaceWith WPT_DEACTIVE_DATA
 * etaHobe PluginOnu SareDifferent.
 * 
 * It's called version 1.0.0 of DeactivationForm
 * 
 * @author Saiful Islam <codersaiful@gmail.com>
 */
class Deactive_Form
{
    

    /**
     * Need to detected Target Plugin's Deactive Button.
     * Obviously should match with plugin's slug,
     * Otherwise it will not work.
     *
     * @var string
     */
    protected $plugin_slug = 'woo-product-table';

    /**
     * It's should be different with all our plugin.
     * Actually need to detect different all of our plugin.
     *
     * @var string
     */
    protected $prefix = 'wpt';
    protected $text_domain = 'woo-product-table';

    /**
     * Change also it to message.js file.
     * Otherwise, It will not work.
     *
     * @var string
     */
    protected $localize_name = 'WPT_DEACTIVE_DATA';
    protected $data = [
        'name' => 'Product Table', //It's Plugin name actually
        'tax'   => [
            'plugin_name' => [12, 'product-table'],
            // 'reason' => ['min-max'],
        ]
    ];
    

    /**
     * Verymuch Important. It's screen name. It will be always plugins obviously.
     *
     * @var string
     */
    protected $required_screen_id = 'plugins'; // 'plugins';

    protected $support_url = 'https://codeastrology.com/my-support/';

    protected $common_target_msg = "Contact with our support email: support@codeastrology.com";

    /**
     * Available target class
     * .ca-comments .ca-email .ca-display-message
     *
     * @var array
     */
    protected $radio_buttons = [];
    public $base_url;
    protected $js_file;
    protected $css_file;
    protected $assignScreen = false;
    protected $screen;
    protected $screenID;
    public $dev_version = WPT_DEV_VERSION;

    protected $form_top_message;

    /**
     * To set any Property Value, We can use this method.
     * It's public. 
     * Currnetly it's not used Yet. But if want to use it, he can use.
     *
     * 
     * @param string $property_name It will be property name. Because, All property has set private, So user will not be able to use directly.
     * @param mixed $proverty_value It's can be any type. such: string, bool, array etc. Actually able to set any type actually
     * @return void
     */
    public function set( $property_name, $proverty_value ){
        $this->$property_name = $proverty_value;
    }

    public function run()
    {
        $this->base_url = plugins_url() . '/'. plugin_basename( dirname( __FILE__ ) ) . '/';
        
        
        

        $this->radio_buttons = [
            [
                'id'        =>  'something-else',
                'value'     =>  "I was looking for something else",
                'target_display'=> false,
            ],
            
            [
                'id'        =>  'conflict-other',
                'value'     =>  "This plugin conflict with another plugin",
                'target_display'=> 'ca-comments',
            ],
            
            [
                'id'        =>  'temporarily',
                'value'     =>  "I m only deactivating temporarily",
                'target_display'=> false,
            ],
            
            [
                'id'        =>  'notneeded',
                'value'     =>  "I no longer need the plugin",
                'target_display'=> false,
            ],
            // [
            //     'id'        =>  'shorttime',
            //     'value'     =>  "I only needed the plugin for a short period",
            //     'target_display'=> false,
            // ],
            [
                'id'        =>  'founded-bug',
                'value'     =>  "I found a bug",
                'target_display'=> 'ca-comments',
            ],
            [
                'id'        =>  'founded-better',
                'value'     =>  "I found a better plugin",
                'target_display'=> false,
            ],
            [
                'id'        =>  'unable-meet-requirement',
                'value'     =>  "Plugin doesn't meet my requirement",
                'target_display'=> 'ca-comments',
            ],
            [
                'id'        =>  'brok-site',
                'value'     =>  "Plugin broke my site",
                'target_display'=> 'ca-comments',
            ],
            [
                'id'        =>  'stopped-working',
                'value'     =>  "Plugin suddenly stopped working",
                'target_display'=> 'ca-comments',
            ],
            [
                'id'        =>  'contact-me',
                'value'     =>  "Please contact with me",
                'target_display'=> 'ca-email',
            ],
            [
                'id'        =>  'others',
                'value'     =>  "Other",
                'target_display'=> 'ca-comments',
            ],
        ];


        $this->form_top_message = __('Please let us know why you are deactivating. (All Optional)', $this->text_domain);
        add_action('admin_footer', array($this, 'form'));
        add_action('admin_enqueue_scripts', [$this, 'enqueue']);
    }

    /**
     * Display Main form, When user will try to Deactivate Plugin
     * 
     * SOME CLUE
     * -----------
     * <div id="<?php echo esc_attr( $this->prefix ); ?>-survey-form-wrap">
     * Why I used prefix at the id name.
     * ********************************
     * Actually we have to use this class different plugin, when every plugin's element should different,
     * so to define different element of different plugin,
     * I have used prefix actually.
     * 
     * @author Saiful Islam <codersaiful@gmail.com>
     *
     * @return void
     */
    public function form()
    {
        if (!$this->assignScreen) $this->assignScreen();
        if ($this->screenID !== $this->required_screen_id) return;
        $date = date(" m/d/Y");
        $token = 'sKSdls)kdKd_-s-dls(Sld)';
        $site_url = get_site_url();
        $blog_name = get_bloginfo( 'name' );
        $plugin_name = $this->data['name'] ?? 'CA Plugin';
        $email = '';
        if(function_exists('wp_get_current_user')){
            $current_user = wp_get_current_user();
            // $email = $current_user->user_email; //Has been removed
        }
?>
        <div id="<?php echo esc_attr( $this->prefix ); ?>-survey-form-wrap" class="ca-survey-form-wrap">
            <div id="<?php echo esc_attr( $this->prefix ); ?>-survey-form" class="ca-survey-form">
                <p class="motivational-speek"><?php echo esc_html( $this->form_top_message ); ?></p>
                <form method="POST" class="ca-deactive-form">
                    <input name="Plugin" type="hidden" class="plugin_name" placeholder="Plugin" value="<?php echo esc_attr( $plugin_name ); ?>" required>
                    <input name="Token" type="hidden" class="token_number" placeholder="Plugin" value="<?php echo esc_attr( $token ); ?>" required>
                    <input name="Version" type="hidden" placeholder="Version" value="<?php echo esc_attr( $this->dev_version ); ?>" required>
                    <input name="Date" type="hidden" placeholder="Date" value="<?php echo esc_attr( $date ); ?>" required>
                    <input name="Website" type="hidden" placeholder="Website" value="<?php echo esc_attr( $site_url ); ?>" required>
                    <input name="Title" type="hidden" placeholder="Title" value="<?php echo esc_attr( $blog_name ); ?>" required>
                    <div class="ca-msg-field-wrapper">
                        <?php $this->render_radio(); ?>
                    </div>
                    <p id="ca-error"></p>
                    <div class="ca-comments common-target" style="display:none;">
                        <textarea type="text" name="Comments" placeholder="(Optional) Please describe" rows="2"></textarea>
                        <p>For support queries <a href="<?php echo esc_url( $this->support_url ); ?>" target="_blank">Submit Ticket</a></p>
                    </div>
                    <div class="ca-email common-target" style="display:none;">
                        <input type="email" id="ca_email" name="Email" value="<?php echo esc_attr( $email ); ?>" placeholder="(Optional) Please write your email, We will contact with you.">
                    </div>
                    <div class="ca-display-message common-target" style="display:none;" data-target_msg="<?php echo esc_attr( $this->common_target_msg ); ?>">
                        <?php echo wp_kses_post( $this->common_target_msg ); ?>
                    </div>
                    <p style="color: #5c5c5c;padding:0;margin: 0 0 8px 0;font-size: 13px;">
                        Submission will send some basic data to Plugin Author as a servey. 
                        Such: <b>your site url, site title, this plugin version</b> etc. <i>You can <b>Skip & Deactivate</b> by click skip button.</i>
                    </p>
                    <div class="ca-msg-button-wrapper">
                        <button type="submit" class="ca_button ca-deactive ca-submit-form" id="ca_deactivate">Submit & Deactivate</button>
                        <a href="#" class="ca_button ca_cancel" id="ca_cancel">Keep</a>
                        <a href="#" class="ca_button ca_skip" id="ca_skip">Skip & Deactivate</a>
                    </div>
                </form>
            </div>
        </div>
    <?php

    }

    /**
     * Some Options Need to Generate using 
     * foreach, which will be easily handle able
     * 
     * That's why, I added this method
     * 
     * If need any Item to add, Just add at the Array.
     *
     * @return void
     */
    private function render_radio(){
        if( ! is_array( $this->radio_buttons ) ) return;
        foreach($this->radio_buttons as $radio){
           (string) $id = $this->prefix . '-'. $radio['id'] ?? '';
           (string) $value = $radio['value'] ?? '';
           (string) $target_display = $radio['target_display'] ?? '';
        ?>
        <div class="ca-each-field">
            <input type="radio" id="ca_<?php echo esc_attr( $id ); ?>" name="Reason" value="<?php echo esc_attr( $value ); ?>"  data-target_display="<?php echo esc_attr( $target_display ); ?>">
            <label for="ca_<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $value ); ?></label>
        </div>
        <?php 
        }
    }

    /**
     * Related CSS and JS file, Only will load,
     * When founded ScreenID. 
     * Otherwise, we will not add any file.
     *
     * @return void
     */
    public function enqueue()
    {
        if (!$this->assignScreen) $this->assignScreen();
        if ($this->screenID !== $this->required_screen_id) return;

        wp_enqueue_script('jquery');
        $enq_name = $this->plugin_slug . '-msg';
        

        wp_enqueue_script( $enq_name, $this->js_file, array('jquery'), $this->dev_version, true);
        $data = [
            'plugin_slug' => $this->plugin_slug,
            'prefix' => $this->prefix,
            'data'   => $this->data,
        ];
        
        wp_localize_script( $enq_name, $this->localize_name, $data );
        wp_enqueue_style( $enq_name, $this->css_file, [], $this->dev_version, 'all' );
    }

    /**
     * Actually We call two action hook, where need a security.
     * To reduce load time, We have create/assign it once time only.
     * So I made a property like: $this->assignScreen = true;
     * 
     * By this, We able to load it once time only.
     * 
     * I have assignScreen Once time only
     * And by this, I able to check Screen.
     *
     * @return void
     */
    private function assignScreen()
    {
        if (!function_exists('get_current_screen')) return;
        $this->screen = get_current_screen();
        $this->screenID = $this->screen->id;

        if ( ! empty($this->screenID ) ) {

            $this->js_file = $this->base_url . 'message.js';
            $this->css_file = $this->base_url . 'message.css';

            $this->assignScreen = true;
        }
    }

    /**
     * For non-exist property
     *
     * @param string $name
     * @return [any]|string|null|boolean|bool|object|int|float|this|null
     */
    public function __get( $name ){
        return $this->data_packed[$name] ?? null;
    }

    /**
     * For non exist property
     *
     * @param string $name
     * @param [any]|string|null|boolean|bool|object|int|float|this|null $value
     */
    public function __set($name, $value){
        $this->data_packed[$name] = $value;
    }
}
