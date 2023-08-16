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
             * $config = get_option( WPT_OPTION_KEY );
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
            
            if( ! $req_wc_next ){
                self::display_notice();
                self::display_common_notice();
            }

            return self::$stop_next;
        }

        /**
         * Normal Notice for Only Free version
         *
         * @return void
         */
        public static function display_notice()
        {
                if(time() > 1692167603 + 864000) return;
                if( defined( 'WPT_PRO_DEV_VERSION' ) ) return;
                
                $temp_numb = rand(1,10);
                // var_dump($temp_numb);
                /**
                 * small notice for pro plugin,
                 * charect:
                 * 10 din por por
                 * 
                 */

                // $small_notc = new Notice('WP20-notice');
                // $small_notc->set_message(sprintf( __( "Are you enjoying <b>%s</b>? <b>COUPON CODE: <i>WP20</i> - up to 60%% OFF</b> %s.", 'woo-product-table' ),"<a href='https://wordpress.org/plugins/woo-product-table/' target='_blank'>Woo Product Table (Product Table for Woocommerce)</a>", "<a href='https://codeastrology.com/coupons/?campaign=WP20&ref=1&utm_source=Default_Offer_LINK' target='_blank'>Click Here</a>" ));
                // $small_notc->set_diff_limit(10);
                // if( method_exists($small_notc, 'set_location') ){
                //     $small_notc->set_location('wpt_premium_image_top'); //wpt_premium_image_bottom
                // }
                // if($temp_numb == 3) $small_notc->show();
                


                $target = 'https://codeastrology.com/coupons/?campaign=SPECIAL60F10DAYS&ref=1&utm_source=Default_Offer_LINK';
                $my_message = '<b><i>COUPON CODE: SPECIAL60F10DAYS - up to 60% OFF</i></b> A coupon code for you for <b>Woo Product Table Pro)</b> Plugin';
                $offerNc = new Notice('wpt_SPECIAL60F10DAYS_offer');
                $offerNc->set_title( 'SPECIAL OFFER for 10 days' )
                ->set_diff_limit(35)
                ->set_type('offer')
                ->set_img( WPT_BASE_URL. 'assets/images/wpt-logo-sk.png')
                ->set_img_target( $target )
                ->set_message( $my_message )
                ->add_button([
                    'text' => 'Claim Discount',
                    'type' => 'error',
                    'link' => $target,
                ]);
                // if( method_exists($offerNc, 'set_location') ){
                //     $offerNc->set_location('wpt_offer_here'); //wpt_premium_image_bottom
                // }
                if($temp_numb == 5) $offerNc->show();
                
                

        }

        /**
         * Common Notice for Product table, where no need Pro version.
         *
         * @return void
         */
        private static function display_common_notice()
        {
            return;

            /**
             * Notice for UltraAddons
             */
            if ( did_action( 'elementor/loaded' ) ) {
            
                $notc_ua = new Notice('ultraaddons');
                $notc_ua->set_message( sprintf( __( 'There is a special Widget for Product Table at %s. You can try it.', 'woo-product-table' ), "<a href='https://wordpress.org/plugins/ultraaddons-elementor-lite/'>UltraAddons</a>" ) );
                // ->add_button([
                //     'type' => 'warning',
                //     'text' => __( 'Download UltraAddons Elementor', 'woo-product-table' ),
                //     'link' => 'https://wordpress.org/plugins/ultraaddons-elementor-lite/'
                // ])
                // $notc_ua->show();    

            }
        }
    }
}

