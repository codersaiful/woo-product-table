<?php

namespace WOO_PRODUCT_TABLE\Admin\Handle;

use WOO_PRODUCT_TABLE\Core\Base;

class Deactive_Form extends Base
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

    protected $support_url = 'https://codeastrology.com/support/submit-ticket/';

    protected $commont_target_msg = "Contact with our support email: support@codeastrology.com";

    /**
     * Available target class
     * .ca-comments .ca-email .ca-display-message
     *
     * @var array
     */
    protected $radio_buttons = [];
    protected $js_file;
    protected $css_file;
    protected $assignScreen = false;
    protected $screen;
    protected $screenID;

    public function run()
    {
        /**
         * If you don't habe Base Class where available assets_url,
         * Fix at bellow.
         */
        $this->js_file = $this->assets_url . 'js/message.js';
        $this->css_file = $this->assets_url . 'css/message.css';

        $this->radio_buttons = [
            [
                'id'        =>  'temporarily',
                'value'     =>  "I'm only deactivating temporarily",
                'target_display'=> false,
            ],
            
            [
                'id'        =>  'notneeded',
                'value'     =>  "I no longer need the plugin",
                'target_display'=> false,
            ],
            [
                'id'        =>  'contact-me',
                'value'     =>  "Please contact with me",
                'target_display'=> 'ca-email',
            ],
            [
                'id'        =>  'shorttime',
                'value'     =>  "I only needed the plugin for a short period",
                'target_display'=> false,
            ],
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
                'value'     =>  "Plugin doesn't meets my requirement",
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
                'id'        =>  'others',
                'value'     =>  "Other",
                'target_display'=> 'ca-comments',
            ],
        ];

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
?>
        <div id="<?php echo esc_attr( $this->prefix ); ?>-survey-form-wrap" class="ca-survey-form-wrap">
            <div id="<?php echo esc_attr( $this->prefix ); ?>-survey-form" class="ca-survey-form">
                <p class="motivational-speek">
                    If you have a moment, please let us know why you are deactivating.
                     <!-- All submissions are anonymous and we only use this feedback for improving our plugin. -->
                    </p>
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
                        <textarea type="text" name="Comments" placeholder="Please describe (If possible)" rows="2"></textarea>
                        <p>For support queries <a href="<?php echo esc_url( $this->support_url ); ?>" target="_blank">Submit Ticket</a></p>
                    </div>
                    <div class="ca-email common-target" style="display:none;">
                        <input type="email" id="ca_email" name="Email" value="" placeholder="Please write your email, We will contact with you.">
                    </div>
                    <div class="ca-display-message common-target" style="display:none;" data-target_msg="<?php echo esc_attr( $this->commont_target_msg ); ?>">
                        <?php echo wp_kses_post( $this->commont_target_msg ); ?>
                    </div>
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
           (string) $id = $radio['id'] ?? '';
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
        wp_enqueue_style( $enq_name, $this->css_file, array('wpt-admin'), $this->dev_version, 'all' );
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

        if (!empty($this->screenID)) {
            $this->assignScreen = true;
        }
    }
}
