<?php 
namespace WOO_PRODUCT_TABLE\Gutt;
use WOO_PRODUCT_TABLE\Core\Base;
class Block_Control extends Base
{
    public $ver_option_name = 'wpt_gut_ver';
    public $handle_name = 'wpt_block';
    public $version = 0;
    public function run()
    {       

        $this->version = get_option($this->ver_option_name, 1);
        $this->version++;
        update_option($this->ver_option_name, $this->version);
        add_action('enqueue_block_editor_assets', [$this,'enqueue_scripts']);
        // var_dump($this);
    }
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->handle_name,
            plugins_url('js/wpt-block.js', __FILE__),
            array('wp-blocks', 'wp-editor', 'wp-components', 'wp-i18n'),
            $this->dev_version . '.' .$this->version
        );
    }
}