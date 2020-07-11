<?php
// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

include __DIR__ . '/inc/notice.php';

$notice = new \NTTC\Notice('wpt_');
$notice->setTimeLimit(20);


$notice->add('error',array(
    'title' =>  "4444 Saiful Islam Warning",
    'message'=> "This is also a message for user",
    'time_limit' => 'No',
    'buttons'   => array(
        array(
            'url'   => 'https://google.com',
            'text'  =>  'Get pro',
            'button_class'   => 'red'
        ),
        
        array(
            'url'   => 'https://google.com',
            'text'  =>  'Getdd pro',
            'button_class'   => 'red'
        ),
        
        array(
            'url'   => 'https://google.com',
            'text'  =>  'ssGet pro',
            'button_class'   => 'red'
        ),
        
    ),
),'testindg');

$notice->add('error',array(
    'title' =>  "111 Saiful Islam Warning",
    'message'=> "This is also a message for user",
    'time_limit' => 'No',
),4545);

$notice->add('error',array(
    'title' =>  "2222 Saiful Islam Warning",
    'message'=> "This is also a message for user",
    //'time_limit' => 'No',
),'testing');
$notice->add('error',array(
    'title' =>  "3333 Saiful Islam Warning",
    'message'=> "This is also a message for user",
    //'time_limit' => 'No',
),'testings');

$notice->add('success',array(
    'title' =>  "Another Success",
    'message'=> "This is also a message for user"
),'anothre_notice');

$notice->addRemote('success','https://codeastrology.com/envato_image_collection/offer/');
//$notice->add_html('success','my_message');


$notice->show_notice();
//var_dump($notice);
