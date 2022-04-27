<?php 
namespace CA_Framework;

use CA_Framework\App\Notice as Notice;
use CA_Framework\App\Require_Control as Require_Control;

include_once __DIR__ . '/ca-framework/framework.php';

$r_slug = 'woocommerce/woocommerce.php';
$t_slug = WPT_PLUGIN_BASE_FILE; //'woo-product-table/woo-product-table.php';
$req = new Require_Control($r_slug,$t_slug);
$req->set_args(['Name'=>'WooCommerce'])
->set_download_link('https://wordpress.org/plugins/woocommerce/')
->set_this_download_link('https://wordpress.org/plugins/woo-product-table/')
// ->set_
// ->set_message("this sis is  sdisd sdodso")
->set_required()
->run();

var_dump($req);