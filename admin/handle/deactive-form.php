<?php

namespace WOO_PRODUCT_TABLE\Admin\Handle;

use WOO_PRODUCT_TABLE\Core\Base;

class Deactive_Form extends Base
{
    protected $js_file;
    protected $css_file;
    protected $assignScreen = false;
    protected $screen;
    protected $screenID;
    protected $plugin_slug = 'woo-product-table';
    protected $prefix = 'wpt';

    /**
     * Change also it to message.js file.
     * Otherwise, It will not work.
     *
     * @var string
     */
    protected $localize_name = 'WPT_DEACTIVE_DATA';
    

    /**
     * Verymuch Important. It's screen name. It will be always plugins obviously.
     *
     * @var string
     */
    protected $required_screen_id = 'edit-wpt_product_table'; // 'plugins';

    protected $support_url = 'https://codeastrology.com/support/submit-ticket/';

    public function run()
    {
        /**
         * If you don't habe Base Class where available assets_url,
         * Fix at bellow.
         */
        $this->js_file = $this->assets_url . 'js/message.js';
        $this->css_file = $this->assets_url . 'css/message.css';


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
        $token = 'Saiful';
        $site_url = get_site_url();
        $blog_name = get_bloginfo( 'name' );
?>
        <div id="<?php echo esc_attr( $this->prefix ); ?>-survey-form-wrap" class="ca-survey-form-wrap">
            <div id="<?php echo esc_attr( $this->prefix ); ?>-survey-form" class="ca-survey-form">
                <p class="motivational-speek">
                    If you have a moment, please let us know why you are deactivating.
                     <!-- All submissions are anonymous and we only use this feedback for improving our plugin. -->
                    </p>
                <form method="POST">
                    <input name="Plugin" type="hidden" placeholder="Plugin" value="<?php echo esc_attr( $token ); ?>" required>
                    <input name="Version" type="hidden" placeholder="Version" value="<?php echo esc_attr( $this->dev_version ); ?>" required>
                    <input name="Date" type="hidden" placeholder="Date" value="<?php echo esc_attr( $date ); ?>" required>
                    <input name="Website" type="hidden" placeholder="Website" value="<?php echo esc_attr( $site_url ); ?>" required>
                    <input name="Title" type="hidden" placeholder="Title" value="<?php echo esc_attr( $blog_name ); ?>" required>
                    <div class="ca-msg-field-wrapper">
                        <div class="ca-each-field">
                            <input type="radio" id="ca_temporarily" name="Reason" value="I'm only deactivating temporarily">
                            <label for="ca_temporarily">I'm only deactivating temporarily</label>
                        </div>
                        <div class="ca-each-field">
                            <input type="radio" id="ca_notneeded" name="Reason" value="I no longer need the plugin">
                            <label for="ca_notneeded">I no longer need the plugin</label>
                        </div>
                        <div class="ca-each-field">
                            <input type="radio" id="ca_short" name="Reason" value="I only needed the plugin for a short period">
                            <label for="ca_short">I only needed the plugin for a short period</label>
                        </div>
                        <div class="ca-each-field">
                            <input type="radio" id="ca_better" name="Reason" value="I found a better plugin">
                            <label for="ca_better">I found a better plugin</label>
                        </div>
                        <div class="ca-each-field">
                            <input type="radio" id="ca_upgrade" name="Reason" value="Upgrading to PRO version">
                            <label for="ca_upgrade">Upgrading to PRO version</label>
                        </div>
                        <div class="ca-each-field">
                            <input type="radio" id="ca_requirement" name="Reason" value="Plugin doesn\'t meets my requirement">
                            <label for="ca_requirement">Plugin doesn't meets my requirement</label>
                        </div>
                        <div class="ca-each-field">
                            <input type="radio" id="ca_broke" name="Reason" value="Plugin broke my site">
                            <label for="ca_broke">Plugin broke my site</label>
                        </div>
                        <div class="ca-each-field">
                            <input type="radio" id="ca_stopped" name="Reason" value="Plugin suddenly stopped working">
                            <label for="ca_stopped">Plugin suddenly stopped working</label>
                        </div>
                        <div class="ca-each-field">
                            <input type="radio" id="ca_bug" name="Reason" value="I found a bug">
                            <label for="ca_bug">I found a bug</label>
                        </div>
                        <div class="ca-each-field">
                            <input type="radio" id="ca_other" name="Reason" value="Other">
                            <label for="ca_other">Other</label>
                        </div>
                    </div>
                    <p id="ca-error"></p>
                    <div class="ca-comments" style="display:nones;">
                        <textarea type="text" name="Comments" placeholder="Please describe (If possible)" rows="2"></textarea>
                        <p>For support queries <a href="<?php echo esc_url( $this->support_url ); ?>" target="_blank">Submit Ticket</a></p>
                    </div>
                    <div class="ca-msg-button-wrapper">
                        <button type="submit" class="ca_button ca-deactive" id="ca_deactivate">Submit & Deactivate</button>
                        <a href="#" class="ca_button" id="ca_cancel">Keep</a>
                        <a href="#" class="ca_button" id="ca_skip">Skip & Deactivate</a>
                    </div>
                </form>
            </div>
        </div>
        <style>
            
        </style>
<?php

    }
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
        ];
        
        wp_localize_script( $enq_name, $this->localize_name, $data );
        wp_enqueue_style( $enq_name, $this->css_file, array('wpt-admin'), $this->dev_version, 'all' );
    }

    /**
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
