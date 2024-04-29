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
                /**
                 * eTa muloto seisob kustomer er jonno
                 * jara oofer message dekhe khub birokto hoyeche, eTa tader jonno. 
                 * 
                 * add_filter('wpt_offer_show', '__return_false'); 
                 * taholei offer showing off hoye jabe.
                 */
                $return_true = apply_filters( 'wpt_offer_show', true );
                if( !$return_true ) return;
                if( defined( 'WPT_PRO_DEV_VERSION' ) ) return;
                if( ! is_admin() ) return;

                $temp_numb =  rand(2,5);

                $coupon_Code = 'FLASH_SALE_2024';
                $target = 'https://wooproducttable.com/pricing/?discount=' . $coupon_Code . '&campaign=' . $coupon_Code . '&ref=1&utm_source=Default_Offer_LINK';
                $my_message = 'Product Table Primium version on Sale <b>(Woo Product Table Pro)</b> Plugin. Take it First!'; 
                $offerNc = new Notice('wpt_'.$coupon_Code.'_offer');
                $offerNc->set_title( 'FLASH SALE UPTO 70%' )
                ->set_diff_limit(5)
                ->set_type('offer')
                ->set_img( WPT_BASE_URL. 'assets/images/round-logo.png')
                ->set_img_target( $target )
                ->set_message( $my_message )
                ->add_button([
                    'text' => 'Claim Discount',
                    'type' => 'offer',
                    'link' => 'https://wooproducttable.com/pricing/?discount=' . $coupon_Code,
                ]);
                
                $offerNc->add_button([
                    'text'  => 'Stock Sync',
                    'link'  => 'https://codeastrology.com/downloads/category/premium/'
                ]);

                if($temp_numb == 5) $offerNc->show();
                
                

        }

        private static function display_notice_on_pro()
        {

            $temp_numb = rand(1, 35);
            $coupon_Code = 'SPECIAL_OFFER_' . date('M_Y');
            $target = 'https://codeastrology.com/downloads/?discount=' . $coupon_Code . '&campaign=' . $coupon_Code . '&ref=1&utm_source=Default_Offer_LINK';
            $my_message = 'Speciall Discount on All CodeAstrology Products'; 
            $offerNc = new Notice('wpt_'.$coupon_Code.'_offer');
            $offerNc->set_title( 'SPECIAL OFFER 🍌' )
            ->set_diff_limit(10)
            ->set_type('offer')
            ->set_img( WPT_BASE_URL. 'assets/images/brand/social/web.png')
            ->set_img_target( $target )
            ->set_message( $my_message )
            ->add_button([
                'text' => 'Get WooCommerce Product with Discount',
                'type' => 'success',
                'link' => $target,
            ]);

            if($temp_numb == 35) $offerNc->show();
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

