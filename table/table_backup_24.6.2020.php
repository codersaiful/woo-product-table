<?php
defined( 'ABSPATH' ) || exit;

add_shortcode('TABLE', 'wpt_table_generate');

function wpt_table_generate(){
    $WPT_DIR_LINK = __DIR__;
    $datas = array(
        'POST_ID'  => 123, //Set Table POST ID is here
        'name' => 'Home Product Tables',
        'title' => 'Choose your Fafourite Table',
        'id' => 'wpt_product_table',
        'class' => array('wpt_product_table','table_tag'), //Class data for table table
        'device' => array(
            'desktop' => array(
                'status' => 'on',
                'columns' => array(
                    array(
                        'status'    => 'on',
                        'head'      => array(
                            'tag'       => false,
                            'content'   => '<img src="http://wpp.cm/wp-content/uploads/2020/01/hoodie-blue-1-100x100.jpg" draggable="false">', //Checking for Empty Content
                            'class'     => 'product_thumbs',
                            'style'     => array(
                                //'display'       => 'none',
                            ),
                        ),
                        'wrapper'   => array(
                            'id'        => 'prouct_thubns',
                            'class'     => 'thumbs_id',
                        ),
                        'items'     => array(
                            'product-image'        => array(
                                'tag'   => 'section',
                                'class' => 'prodd_thumbsss',
                                'setting'=> false,
                            ),
                        ),
                    ),
                    array( //This is A Collumn 
                        'status' => 'on', //Probale Value on and off
                        'head' => array( // This will be TH , imean column Head.
                            //'id' => 'col-1-skdlsld',
                            
                            'tag'   => false,
                            'content' => 'Products', //Data/Content will be come from wpEditor
                            'class' =>  'products_column',
                            'style' => array(
                                'color' => 'white',
                                'font-size'=> '18px',
                                'background' => 'red'
                            ),
                            'attribute' => array(
                                'something' => 'nothing', //These will go to as Att of this Head or TH tag
                                'another'   => 'other',
                            ),
                        ),
                        'wrapper' => array( //Wrapper of All Items, it will be TD actually
                            'id' => 'td_id',
                            'class' => 'tr_class',
                            'attribute'=> array(
                                'td_some' => 'tr nothing',
                                'td_attr' => 'tr attr value',
                            ),
                        ),
                        'items' => array(
                            'quantityssss' => array('tag'=>'section'),
                            'product-title' => array(
                                'tag'   => 'h1',
                                'class' => 'product title class',
                                'id'    => 'product title',
                                'style' => array( 'color' => 'black' ),
                                'attribute' => array('some' => 'nothing'),
                                'settings'  => array(
                                    'link'  => 'link', //probal values link, no_link, new tab, quick_view
                                    'open'  => 'new_tab',
                                ),
                            ),
                            'price' => array(
                                'tag'   => 'div',
                                'class' => 'item_price_class',
                                'id'    => 'item price id',
                                'style' => array( 'color' => 'black' ),
                                'attribute' => array('some' => 'nothing'),
                                'settings'  => false,
                            ),
                            //'quantity' => array('tag'=>'section'),
                            'description' => array(
                                'tag'       =>'section',
                                'class'     => 'product_description',
                                'id'        => 'descriptIDOfProduct',
                                'style'     => false,
                                'settings'  => array(
                                    'data'      =>  'test',
                                    'other'     =>  'nothings',
                                ),
                            ),
                            'content' => array('tag'=>'section','class'=> 'my_content'),
                            
                        ),
                    ),
                    array( //This is actually a Column
                        'status' => 'on', //Probale Value on and off
                        'head' => array( // This will be TH , imean column Head.
                            'tag'   => false,
                            'content' => 'Actions Product',
                            'class' =>  'another_class name',
                            'style' => array(
                                'color' => 'white',
                                'font-size'=> '18px',
                                'background' => 'red'
                            ),
                            'attribute' => array(
                                'something' => 'nothing', //These will go to as Att of this Head or TH tag
                                'another'   => 'other',
                            ),
                        ),
                        'wrapper' => array( //Wrapper of All Items, it will be TD actually
                            'id' => 'td_id',
                            'class' => 'tr_class',
                            'attribute'=> array(
                                'td_some' => 'tr nothing',
                                'td_attr' => 'tr attr value',
                            ),
                        ),
                        'items' => array(
                            'quantity' => array(
                                'tag'   => 'div',
                                'class' => 'wpt_quantity',
                            ),
                            'action' => array( //Action Item, Where available Add to cart Button Actually
                                'tag'   => 'div',
                                'class' => 'wpt_action',
                                'id'    => 'action_unique_id',
                                'style' => array( 'color' => 'black' ),
                                'attribute' => array('some' => 'nothing'),
                                'settings'  => array(
                                    'type' => 'advance', //Can be two types: simple and advance. in single: custom code addToCart | default_wooCommerce add to cart
                                ),
                            ),

                        ),
                    ),
                ),
                'fullwidth' => array( //This is a Full Width Column Where there is no Head
                        'status' => 'on', //Probale Value on and off
                        'wrapper' => array( //Wrapper of All Items, it will be TD actually
                            'id' => 'full_width',
                            'class' => 'full width Items',
                            'attribute'=> array(
                                'td_some' => 'tr nothing',
                                'td_attr' => 'tr attr value',
                            ),
                        ),
                        'items' => array(
                            'description' => array(
                                'tag'   => 'section',
                                'class' => 'my description',
                            ),
                            'action' => array( //Action Item, Where available Add to cart Button Actually
                                'tag'   => 'div',
                                'class' => 'wpt_action',
                                'id'    => 'action_unique_id',
                                'style' => array( 'color' => 'black' ),
                                'attribute' => array('some' => 'nothing'),
                                'settings'  => array(
                                    'type' => 'advance', //Can be two types: simple and advance. in single: custom code addToCart | default_wooCommerce add to cart
                                ),
                            ),

                        ),
                    ),
            ),
            
            
            
            'mobile' => array(
                'status' => 'on',
                'columns' => array(
                    array( //This is A Collumn | In Mobile, Now set Only One Column Actually
                        'status' => 'on', //Probale Value on and off
                        'head' => array( // This will be TH , imean column Head.
                            'content' => 'Products Details',
                            'class' =>  'products_column',
                            'style' => array(
                                'color' => 'white',
                                'font-size'=> '18px',
                                'background' => 'red'
                            ),
                            'attribute' => array(
                                'something' => 'nothing', //These will go to as Att of this Head or TH tag
                                'another'   => 'other',
                            ),
                        ),
                        'wrapper' => array( //Wrapper of All Items, it will be TD actually
                            'id' => 'td_id',
                            'class' => 'tr_class',
                            'attribute'=> array(
                                'td_some' => 'tr nothing',
                                'td_attr' => 'tr attr value',
                            ),
                        ),
                        'items' => array(
                            'price' => array(
                                'class' => 'item_price_class',
                                'id'    => 'item price id',
                                'style' => array( 'color' => 'black' ),
                                'attribute' => array('some' => 'nothing'),
                                'settings'  => false,
                            ),
                            'product-title' => array(
                                'class' => 'product title class',
                                'id'    => 'product title',
                                'style' => array( 'color' => 'black' ),
                                'attribute' => array('some' => 'nothing'),
                                'settings'  => array(
                                    'link'  => 'link', //probal values link, no_link, new tab, quick_view
                                    'open'  => 'new_tab',
                                ),
                            ),
                            'action' => array( //Action Item, Where available Add to cart Button Actually
                                'class' => 'wpt_action',
                                'id'    => 'action_unique_id',
                                'style' => array( 'color' => 'black' ),
                                'attribute' => array('some' => 'nothing'),
                                'settings'  => array(
                                    'type' => 'advance', //Can be two types: simple and advance. in single: custom code addToCart | default_wooCommerce add to cart
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            
            
        ),
        'head' => 'on' //To Show or Hide Table Head
        
    );
    ob_start();
    
    $args = array(
        'posts_per_page' => 8,
        'post_type' => array('product'), //, 'product_variation','product'
        'post_status'   =>  'publish',
        'meta_query' => array(),
        'wpt_table' => 'default',
    );

    
    WPT_TABLE::init( $datas );
    
    $POST_ID = $datas['POST_ID'];
    $name = $datas['name'];
    $title = $datas['title'];
    $class = $datas['class'];
    $notfound = false;
    
    $class = isset( $datas['class'] ) ? $datas['class'] : array( 'wpt_product_table' );
    $class[] = 'wpt_table_' . $POST_ID;
    $wrapper_class = implode(" ", $class);
    $wrapper_header_class = implode(" header_", $class);
    $wrapper_div_class = implode(" div_", $class);
    $wrapper_table_class = implode(" table_", $class);
    $wrapper_footer_class = implode(" footer_", $class);
    ?>
<div class="wpt_main_wrapper <?php echo esc_attr( $wrapper_class ); ?>">
    <div class="wpt_header <?php echo esc_attr( $wrapper_header_class ); ?>">
        <?php
        //Universal Action for 
        do_action( 'wtp_header', $POST_ID );
        //Indivisual Action for Specific Table
        do_action( 'wtp_header_' . $POST_ID );
        ?>
    </div>
    <div class="wpt_table_div <?php echo esc_attr( $wrapper_div_class ); ?>">
        <table class="wpt_table <?php echo esc_attr( $wrapper_table_class ); ?>">
            <?php
            //Include and Generate Table Head Tr here.
            if( WPT_TABLE::is_table_head() && WPT_TABLE::get_head() ){
            include 'includes/table-head.php';
            } ?>
            
            
            <tbody>
                <?php
                $product_loop = new WP_Query($args);
                
                //Getting Columns Info Based on Defice, Currently getting Desktop Column Only
                $table_row = WPT_TABLE::getCollumns();
                $fullwidth = WPT_TABLE::getFullwidth();
                $collcount = WPT_TABLE::columnCount();

                if ($product_loop->have_posts()) : while ($product_loop->have_posts()): $product_loop->the_post();
                global $product;
                
                $product_id = $product->get_id();
                $product_type = $product->get_type();

                $wc_product = wc_get_product( $product_id );
                $wc_product_data = $product->get_data();
                $tr_title = get_the_title();

                
                $current_tr = $table_row;
                $rowtype = 'normal-row';
                $collspan = 1;
                include 'includes/table-row.php';
                
                if( $fullwidth ){
                   $rowtype = 'fullwidth'; 
                   $collspan = $collcount;
                   $current_tr = array( 'fullwidth' => $fullwidth );
                   include 'includes/table-row.php';
                }
                
                endwhile;
                else:
                $notfound = __( 'Not founded', 'wpt' );    
                endif;
                wp_reset_query(); //Added reset query before end Table just at Version 4.3
                wp_reset_postdata();
                ?>
            </tbody>
            
        </table>
    </div>
    <div class="wpt_footer <?php echo esc_attr( $wrapper_footer_class ); ?>">
        <?php
        $notfound = apply_filters( 'wpt_notfound_msg', $notfound );
        if( $notfound ){
            include_once 'includes/notfound.php';
        }
        ?>
        
        <?php
        //Universal Action for 
        do_action( 'wtp_footer', $POST_ID );
        //Indivisual Action for Specific Table
        do_action( 'wtp_footer_' . $POST_ID );
        ?>
    </div>
</div>
    <?php
    
    echo '<pre>';
    print_r($datas);
    echo '</pre>';
    
    return ob_get_clean();;
}