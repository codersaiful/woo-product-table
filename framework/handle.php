<?php 

use CA_Framework\App\Notice as Notice;
use CA_Framework\App\Require_Control as Require_Control;

include_once __DIR__ . '/ca-framework/framework.php';

if( ! class_exists( 'WPT_Required' ) ){

    class WPT_Required
    {

        public static $coupon_Code;

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
                // add_action('wpt_loaded', function(){
                //     if( ! is_admin() ) return;

                //     global $current_screen;
                //     $s_id = isset( $current_screen->id ) ? $current_screen->id : '';
                //     // self::Notice( 5 );
                //     if( strpos( $s_id, 'product_table') === false ){
                //         self::Notice( 5, $s_id . ' - ');
                //         return;
                //     }
                // }, 10);


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
            if( ! is_admin() ) return;

            $return_true = apply_filters( 'wpt_offer_show', true );
            if( !$return_true ) return;

            $last_date = '31 Dec 2024'; //Last date string to show offer
            $last_date_timestamp = strtotime( $last_date );
            
            if( time() > $last_date_timestamp ) return;


            //Only when in product table page, So it will show always
            $s_id = $_SERVER['REQUEST_URI'] ?? '';
            if( strpos( $s_id, 'product_table') !== false ){
                if( defined( 'WPT_PRO_DEV_VERSION' ) ){
                    self::OtherOffer();
                }else{
                    self::Notice( 5);
                }

                return;
            }
            
            /**
             * eTa muloto seisob kustomer er jonno
             * jara oofer message dekhe khub birokto hoyeche, eTa tader jonno. 
             * 
             * add_filter('wpt_offer_show', '__return_false'); 
             * taholei offer showing off hoye jabe.
             */
            $temp_numb = rand(4,5);
            if( defined( 'WPT_PRO_DEV_VERSION' ) ){
                self::OtherOffer( $temp_numb);
                return;
            }
            


            self::Notice( $temp_numb);
            
            
                

        }

        protected static function OtherOffer( $probability = 5 )
        {
            if( $probability !== 5 ) return;
            $fullArgs = [
                [
                    'title' => 'BLACKFRIDAY - Sync master sheet',
                    'coupon_code' => 'BLACKFRIDAY2024',
                    'target_url' => 'https://codeastrology.com/downloads/product-sync-master-sheet-premium/?discount=BLACKFRIDAY2024&campaign=BLACKFRIDAY2024&ref=1&utm_source=Default_Offer_LINK',
                    'img_url' => WPT_BASE_URL. 'assets/images/products/product-sync-master-sheet.png',
                    'message' => 'Seamlessly connect your WooCommerce store with Google Sheets via the Google Sheets API. Also sync with multiple website.', 
                    'button_text' => 'Start to Sync with Google Sheets',
                ],
                
                [
                    'title' => 'Offer - Min Max Control (PRO)',
                    'coupon_code' => 'BLACKFRIDAY2024',
                    'target_url' => 'https://wooproducttable.com/pricing/?discount=BLACKFRIDAY2024&campaign=BLACKFRIDAY2024&ref=1&utm_source=Default_Offer_LINK',
                    'img_url' => WPT_BASE_URL. 'assets/images/products/woo-min-max-quantity-step-control-single.png',
                    'message' => 'Toffers to display specific products with minimum, maximum quantity.', 
                    'button_text' => 'Ok, Start Now!',
                ],
                [
                    'title' => 'BLACKFRIDAY - CodeAstrology all plugins',
                    'coupon_code' => 'BLACKFRIDAY2024',
                    'target_url' => 'https://codeastrology.com/downloads/category/premium/?discount=BLACKFRIDAY2024&campaign=BLACKFRIDAY2024&ref=1&utm_source=Default_Offer_LINK',
                    'img_url' => WPT_BASE_URL. 'assets/images/brand/header-logo.png',
                    'message' => 'Control WooCommerce products to Show as Table, To Sync with Google Sheet, to control quantity with minimum, maximum quantity.', 
                    'button_text' => 'Checkout our Plugins',
                ],
                [
                    'title' => 'Get all Free Plugins for WooCommrce',
                    'coupon_code' => 'BLACKFRIDAY2024',
                    'target_url' => 'https://codeastrology.com/downloads/category/free-products/?discount=BLACKFRIDAY2024&campaign=BLACKFRIDAY2024&ref=1&utm_source=Default_Offer_LINK',
                    'img_url' => WPT_BASE_URL. 'assets/images/brand/header-logo.png',
                    'message' => 'Control WooCommerce products to Show as Table, To Sync with Google Sheet, to control quantity with minimum, maximum quantity.', 
                    'button_text' => 'Get it Now',
                ],

            ];
            
            $rand_args = $fullArgs[rand(0, count($fullArgs) - 1)];
            self::GetCustomOffer( $rand_args );

            
        }

        protected static function GetCustomOffer( $args = ['title' => '', 'coupon_code' => 'BLACKFRIDAY2024', 'target_url' => '', 'img_url' => '', 'message' => '', 'button_text' => ''  ] )
        {

            $coupon_code = $args['coupon_code'] ?? 'BLACKFRIDAY2024';
            $target = $args['target_url'] ?? 'https://wooproducttable.com/pricing/?discount=' . $coupon_code . '&campaign=' . $coupon_code . '&ref=1&utm_source=Default_Offer_LINK';
            $img_url = $args['img_url'] ?? WPT_BASE_URL. 'assets/images/round-logo.png';
            $message = $args['message'] ?? ''; 
            $message .= '<br>Coupon Code: ' . $coupon_code;
            $button_text = $args['button_text'] ?? 'Claim Discount';
            $title = $args['title'] ?? 'BLACKFRIDAY2024 for Woo Product Table';

            $offerNc = new Notice('wpt_'.$coupon_code.'_offer');
            $offerNc->set_title( $title )
            ->set_diff_limit(1)
            ->set_type('offer')
            ->set_img( $img_url)
            ->set_img_target( $target )
            ->set_message( $message )
            ->add_button([
                'text' => $button_text,
                'type' => 'offer',
                'link' => $target,
            ]);

            $offerNc->show();
        }
        protected static function Notice( $temp_numb)
        {
            $coupon_Code = 'BLACKFRIDAY2024';
            $target = 'https://wooproducttable.com/pricing/?discount=' . $coupon_Code . '&campaign=' . $coupon_Code . '&ref=1&utm_source=Default_Offer_LINK';
            $my_message = 'Product Table Primium version on COUPON <b>(Woo Product Table Pro)</b> Plugin. Offer Upto 30 Sept. 2024'; 
            $offerNc = new Notice('wpt_'.$coupon_Code.'_offer');
            $offerNc->set_title( 'BLACKFRIDAY2024 for Woo Product Table' )
            ->set_diff_limit(2)
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
                'text'  => 'Helpful WooCommerce Plugins',
                'link'  => 'https://codeastrology.com/downloads/category/premium/?discount=' . $coupon_Code,
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
            $offerNc->set_title( 'SPECIAL OFFER' )
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

