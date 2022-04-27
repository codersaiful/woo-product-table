<?php 

use CA_Framework\App\Notice as Notice;
use CA_Framework\App\Require_Control as Require_Control;

include_once __DIR__ . '/ca-framework/framework.php';

if( ! class_exists( 'WPT_Required' ) ){

    class WPT_Required
    {
        public static $stop_next = 0;
        public function __construct()
        {
            
        }
        public static function fail()
        {

            /**
             * Getting help from configure
             * $config = get_option( 'wpt_configure_options' );
        $disable_plugin_noti = !isset( $config['disable_plugin_noti'] ) ? true : false;
             */

            $r_slug = 'woocommerce/woocommerce.php';
            $t_slug = WPT_PLUGIN_BASE_FILE; //'woo-product-table/woo-product-table.php';
            $req_wc = new Require_Control($r_slug,$t_slug);
            $req_wc->set_args(['Name'=>'WooCommerce'])
            ->set_download_link('https://wordpress.org/plugins/woocommerce/')
            ->set_this_download_link('https://wordpress.org/plugins/woo-product-table/')
            // ->set_message("this sis is  sdisd sdodso")
            ->set_required()
            ->run();
            $req_wc_next = $req_wc->stop_next();
            self::$stop_next += $req_wc_next;

            if ( did_action( 'elementor/loaded' ) && ! $req_wc_next ) {
                
                $notc_ua = new Notice('ultraaddons');
                $notc_ua->set_message( sprintf( __( 'There is a special Widget for Product Table at %s. You can try it.', 'wpt_pro' ), "<a href='https://wordpress.org/plugins/ultraaddons-elementor-lite/'>UltraAddons</a>" ) )
                // ->add_button([
                //     'type' => 'warning',
                //     'text' => __( 'Download UltraAddons Elementor', 'wpt_pro' ),
                //     'link' => 'https://wordpress.org/plugins/ultraaddons-elementor-lite/'
                // ])
                ->show();    

            }

            return self::$stop_next;
        }
    }
}

