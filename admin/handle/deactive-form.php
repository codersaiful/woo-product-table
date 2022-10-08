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
    protected $data = [
        'plugin-slug' => 'woo-product-table',
        'prefix' => 'wpt',
    ];

    protected $required_screen_id = 'edit-wpt_product_table'; // 'plugins';
    public function run()
    {
        add_action('admin_footer', array($this, 'form'));
        add_action('admin_enqueue_scripts', [$this, 'enqueue']);
    }

    public function form()
    {
        if (!$this->assignScreen) $this->assignScreen();
        if ($this->screenID !== $this->required_screen_id) return;
        $date = date(" m/d/Y");
        $token = 'Saiful';
        $site_url = get_site_url();
        $blog_name = get_bloginfo( 'name' );
?>
        <div id="wpt-survey-form-wrap">
            <div id="wpt-survey-form">
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
                    <div class="wpt-msg-field-wrapper">
                        <div class="wpt-each-field">
                            <input type="radio" id="wpt_temporarily" name="Reason" value="I'm only deactivating temporarily">
                            <label for="wpt_temporarily">I'm only deactivating temporarily</label>
                        </div>
                        <div class="wpt-each-field">
                            <input type="radio" id="wpt_notneeded" name="Reason" value="I no longer need the plugin">
                            <label for="wpt_notneeded">I no longer need the plugin</label>
                        </div>
                        <div class="wpt-each-field">
                            <input type="radio" id="wpt_short" name="Reason" value="I only needed the plugin for a short period">
                            <label for="wpt_short">I only needed the plugin for a short period</label>
                        </div>
                        <div class="wpt-each-field">
                            <input type="radio" id="wpt_better" name="Reason" value="I found a better plugin">
                            <label for="wpt_better">I found a better plugin</label>
                        </div>
                        <div class="wpt-each-field">
                            <input type="radio" id="wpt_upgrade" name="Reason" value="Upgrading to PRO version">
                            <label for="wpt_upgrade">Upgrading to PRO version</label>
                        </div>
                        <div class="wpt-each-field">
                            <input type="radio" id="wpt_requirement" name="Reason" value="Plugin doesn\'t meets my requirement">
                            <label for="wpt_requirement">Plugin doesn't meets my requirement</label>
                        </div>
                        <div class="wpt-each-field">
                            <input type="radio" id="wpt_broke" name="Reason" value="Plugin broke my site">
                            <label for="wpt_broke">Plugin broke my site</label>
                        </div>
                        <div class="wpt-each-field">
                            <input type="radio" id="wpt_stopped" name="Reason" value="Plugin suddenly stopped working">
                            <label for="wpt_stopped">Plugin suddenly stopped working</label>
                        </div>
                        <div class="wpt-each-field">
                            <input type="radio" id="wpt_bug" name="Reason" value="I found a bug">
                            <label for="wpt_bug">I found a bug</label>
                        </div>
                        <div class="wpt-each-field">
                            <input type="radio" id="wpt_other" name="Reason" value="Other">
                            <label for="wpt_other">Other</label>
                        </div>
                    </div>
                    <p id="wpt-error"></p>
                    <div class="wpt-comments" style="display:nones;">
                        <textarea type="text" name="Comments" placeholder="Please describe (If possible)" rows="2"></textarea>
                        <p>For support queries <a href="https://codeastrology.com/support/submit-ticket/" target="_blank">Submit Ticket</a></p>
                    </div>
                    <div class="wpt-msg-button-wrapper">
                        <button type="submit" class="wpt_button wpt-deactive" id="wpt_deactivate">Submit & Deactivate</button>
                        <a href="#" class="wpt_button" id="wpt_cancel">Keep</a>
                        <a href="#" class="wpt_button" id="wpt_skip">Skip & Deactivate</a>
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

        $this->js_file = $this->assets_url . 'js/message.js';
        $this->css_file = $this->assets_url . 'css/message.css';

        wp_enqueue_script('jquery');

        $WPT_DATA = array( 
            'ajaxurl' => 'sss',
 
            );
        wp_localize_script( 'wpt-deactive-message', 'WPT_DATA_ADMIN', $WPT_DATA );

        wp_enqueue_script('wpt-deactive-message', $this->js_file, array('jquery'), $this->dev_version, true);
        wp_enqueue_style( 'wpt-deactive-message', $this->css_file, array('wpt-admin'), $this->dev_version, 'all' );
    }

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
