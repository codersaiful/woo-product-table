# CA_Framework is a Code Astrology framework to handle basic control of WordPress
CA_Framework
Version: 1.0.0

CA Framework is a primary version of Code Astrology Frameword

## Code Example for Required Plugin Handle:
````php
<?php 
include __DIR__ . '/ca-framework/loader.php';

//RequireControl Part Start Here
// $req = new CA_Framework\Require_Control( 'woo-product-table/woo-product-table.php' );
$req = new CA_Framework\Require_Control( 'woo-product-table/woo-product-table.php', 'ca-quick-view/init.php' );
$args = array(
    'Name' => 'Product Table Plugin for WooCommerce',
    'PluginURI' => 'https://profiles.wordpress.org/codersaiful/#content-plugins',
);
$req->set_args($args)

->run();
````

## Code Example for Notice Control
````php
<?php
include __DIR__ . '/ca-framework/loader.php';

//Notice Control
$my_notice = new CA_Framework\Notice('aSsa');
// $my_notice->start_date = '4/21/2022 18:48:24';
$my_notice->notice_type = 'warning';
$my_notice->set_message("Notice Message description text here.")
->set_start_date('4/21/2022 11:05:00')
// ->set_end_date('10/21/2022 11:05:00')
->set_title( 'Product Table for WooCommerce(Plus):<br> UPTO 70% discount!' )
->add_button(array(
    'type' => 'primary',
    'text' => 'Go and Click',
    'target'=> '_blank',
    'link' => 'https://google.com'
))
// ->add_button(array('text'=>"Hello"))
// ->add_button(array('text'=>"It's call",'type'=>'warning'))
->add_button(array('text'=>"Error",'type'=>'error'))
// ->add_button(array('text'=>"Nothing To Show",'link'=>'https://gogle.com'))

->set_img('http://wpp.cm/wp-content/plugins/ca-quick-view/includes/admin//img/notice-img.jpg')
->show();
$another_notice = new CA_Framework\Notice('dssd');
$another_notice->set_message("Nothing to do for it.<a href='#'>Go Premium</a>")
// ->set_img('https://img.freepik.com/free-vector/black-banner-with-yellow-geometric-shapes_1017-32327.jpg')
->show();

````