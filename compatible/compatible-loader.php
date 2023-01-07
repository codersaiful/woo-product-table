<?php
namespace WOO_PRODUCT_TABLE\Compatible;

class Compatible_Loader{
    public $plugins = [];
    public $folder_dir = __DIR__ . '/plugins/';


    public function run()
    {
        $plugin_list = [
            'waitlist-woocommerce' => [
                'file'  => 'waitlist-woocommerce/xoo-wl-main.php',
                'exits_func' => '',
                'folder_dir'      => $this->folder_dir,
            ],
            // 'loco-translate' => [
            //     'file'  => 'loco.php',
            //     'exits_func' => '',
            //     'folder_dir'      => $this->folder_dir,
            // ],
        ];
        $this->plugins = apply_filters( 'wpt_compatible_plugins', $plugin_list );

        foreach( $this->plugins as $plugin_slug=>$plugin_data ){
            if( ! is_array( $plugin_data ) ) continue;
            // $plugin_file = $plugin_slug . '/' . $plugin_data['file'] ?? '';
            $plugin_file = $plugin_data['file'] ?? '';
             
            if( is_plugin_active( $plugin_file ) ){
                $this->loadFile( $plugin_slug, $plugin_data );
            }
            
        }

    }

    public function loadFile( $plugin_slug, $plugin_data = [] )
    {
        if( ! is_array( $plugin_data ) ) return;
        $loader = $plugin_data['folder_dir'] ?? '';
        $loader = $loader . '/' . $plugin_slug . '/' . $plugin_slug . '.php';
        
        if( ! is_readable( $loader ) ) return;

        include $loader;
        
    }
}