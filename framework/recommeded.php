<?php 
namespace WOO_PRODUCT_TABLE\Framework;;

use CA_Framework\App\Notice as Notice;
use CA_Framework\App\Require_Control as Require_Control;

include_once __DIR__ . '/ca-framework/framework.php';

class Recommeded
{
    public static function check()
    {
        // $blackf22ID = 'black-friday-22-y';
        // $blackf22 = new Notice($blackf22ID);
        // $blackf22->set_message("");
        // $blackf22->set_img( 'https://codeastrology.com/wp-content/uploads/2022/11/black-friday-notice.png');
        // $blackf22->set_img_target('https://codeastrology.com/coupons/?coupons=BLACKFRIDAY22');
        // $blackf22->set_diff_limit(55);
        // $blackf22->add_button([
        //     'text' => 'Claim Discount',
        //     'type' => '',
        //     'link' => '_blank',
        // ]);
        // if( method_exists($blackf22, 'set_location') ){
        //     $blackf22->set_location('wpt_plugin_recommend_here'); //wpt_premium_image_bottom
        // }
        // $blackf22->set_type('offer');
        // $blackf22->set_title('Woo Product Table.');
        // $blacf_count = get_option($blackf22ID, 0);
        // if($blacf_count < 2 ){
        //     $blacf_count++;
        //     update_option($blackf22ID, $blacf_count);
        //     $blackf22->show();
        // }
        

        $this_plugin = __( 'It\'s', 'wpt_pro' );
        $this_plugin2 = __( 'Woo Product Table', 'wpt_pro' );

        $qv_req_slug = 'ca-quick-view/init.php';
        $qv_tar_slug = WPT_PLUGIN_BASE_FILE;
        $req_qv = new Require_Control($qv_req_slug,$qv_tar_slug);
        $req_qv->set_args( ['Name' => 'Quick View vy CodeAstrology'] )
        ->set_download_link('https://wordpress.org/plugins/ca-quick-view/')
        ->set_this_download_link('https://wordpress.org/plugins/woo-product-table/');
        $req_qv->set_required();
        $req_qv->get_full_this_plugin_name($this_plugin);
        if( method_exists($req_qv, 'set_location') ){
            $req_qv->set_location('wpto_column_setting_form_quick_view'); //wpt_premium_image_bottom
            $req_qv->run();
        }
        
        

        $mmp_req_slug = 'woo-min-max-quantity-step-control-single/wcmmq.php';
        $mmp_tar_slug = WPT_PLUGIN_BASE_FILE;
        $req_mmp = new Require_Control($mmp_req_slug,$mmp_tar_slug);
        $req_mmp->set_args( ['Name' => 'Min Max Quantity & Step Control for WooCommerce'] )
        ->set_download_link('https://wordpress.org/plugins/woo-min-max-quantity-step-control-single/')
        ->set_this_download_link('https://wordpress.org/plugins/woo-product-table/');
        $mmp_message = __('If you want to set CONDITION for minimum and maximum limit and want to control step, then you can install it. Otherwise ignore it.','wpt_pro');
        $req_mmp->set_message($mmp_message);
        $req_mmp->get_full_this_plugin_name($this_plugin);
        // var_dump(method_exists($req_mmp, 'set_location'),$req_mmp);
        // ->set_required();
        if( method_exists($req_mmp, 'set_location') ){
            $req_mmp->set_location('wpto_column_setting_form_quantity'); //wpt_premium_image_bottom
            // $req_mmp->set_location('wpto_column_setting_form_inside_quantity'); //wpt_premium_image_bottom
            $req_mmp->run();

            $req_mmp->get_full_this_plugin_name($this_plugin2);
            $req_mmp->set_location('wpt_plugin_recommend_here');
            $req_mmp->run();
        }


        $pmb_req_slug = 'wc-quantity-plus-minus-button/init.php';
        $pmb_tar_slug = WPT_PLUGIN_BASE_FILE;
        $req_pmb = new Require_Control($pmb_req_slug,$pmb_tar_slug);
        $req_pmb->set_args( ['Name' => 'Quantity Plus Minus Button for WooCommerce'] )
        ->set_download_link('https://wordpress.org/plugins/wc-quantity-plus-minus-button/')
        ->set_this_download_link('https://wordpress.org/plugins/woo-product-table/');
        $pmb_message = __('If you want to set plus minus button for your Quantity Box, you can Install this plugin. If already by your theme, ignore it.','wpt_pro');
        $req_pmb->set_message($pmb_message);
        $req_pmb->get_full_this_plugin_name($this_plugin);
        // ->set_required();
        if( method_exists($req_pmb, 'set_location') ){
            // $req_pmb->set_location('wpto_column_setting_form_quantity'); //wpt_premium_image_bottom
            $req_pmb->set_location('wpto_column_setting_form_inside_quantity'); //wpt_premium_image_bottom
            $req_pmb->run();
            
            $req_pmb->get_full_this_plugin_name($this_plugin2);
            $req_pmb->set_location('wpt_plugin_recommend_here'); //wpt_premium_image_bottom
            $req_pmb->run();
        }

        $pmb_req_slug = 'ultraaddons-elementor-lite/init.php';
        $pmb_tar_slug = WPT_PLUGIN_BASE_FILE;
        $req_pmb = new Require_Control($pmb_req_slug,$pmb_tar_slug);
        $req_pmb->set_args( ['Name' => 'UltraAddons - Elementor Addons'] )
        ->set_download_link('https://wordpress.org/plugins/ultraaddons-elementor-lite/')
        ->set_this_download_link('https://wordpress.org/plugins/woo-product-table/');
        $pmb_message = __('There are many WooCommerce Widget available at UltraAddons. You can Try it. Just Recommended','wpt_pro');
        $req_pmb->set_message($pmb_message);
        $req_pmb->get_full_this_plugin_name($this_plugin);
        // ->set_required();
        if( method_exists($req_pmb, 'set_location') && did_action( 'elementor/loaded' ) ){

            $req_pmb->get_full_this_plugin_name($this_plugin2);
            $req_pmb->set_location('wpt_plugin_recommend_here'); //wpt_premium_image_bottom
            $req_pmb->run();
        }



        //Quick View Recommended
        if( method_exists($req_qv, 'set_location') ){
            $req_qv->set_location('wpto_column_setting_form_inside_quick_view'); //wpt_premium_image_bottom
            $req_qv->required = false;
            $req_message = __('To Display Quick View at Shop Page or Anywhere. There are many customizing option to this plugin.','wpt_pro');
            $req_qv->set_message($req_message);
            $req_qv->get_full_this_plugin_name($this_plugin2);
            $req_qv->set_location('wpt_plugin_recommend_here');
            $req_qv->run();
        }


    }
}