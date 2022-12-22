<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<link rel="profile" href="https://gmpg.org/xfn/11">
        <style id="wpt-wpt-page">
            body.wpt-table-preview-body div#page {
                padding: 20px;
            }
            .wpt-preview-title h2.wpt-preview-heading {
                font-size: 38px;
                
            }            
            .wpt-preview-title{
                border-bottom: 2px solid #ddd;
                padding-bottom: 15px;
                margin-bottom: 17px;
            }
            .wpt-preview-shortcode-input{
                width: 500px;
                max-width: 100%;
            }
        </style>
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'wpt-table-preview-body' ); ?>>
<?php wp_body_open(); ?>

    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'woo-product-table' ); ?></a>
<div id="page" class="hfeed site wpt-fullwidth">
<?php
    if ( have_posts() ) : while ( have_posts() ) : the_post();
    $id = get_the_ID();
    $title = get_the_title();


    ?>
    <div class="wpt-preview-title">
        <h2 class="wpt-preview-heading"><?php the_title(); ?></h2>

        <?php if( is_user_logged_in() ){ ?>
            <b><?php echo esc_html__( 'Shortcode', 'woo-product-table' ); ?></b><br>
            <input 
            class="wpt-preview-shortcode-input" 
            type="text" 
            value="<?php echo esc_attr( "[Product_Table id='{$id}'  name='{$title}']" ); ?>"
            readonly="readonly"
            >    
            
        <?php } ?>
        <span class="preview_info">
            <?php echo esc_html__('For perfect view paste shortcode on a page.', 'woo-product-table');?>
        </span>
        </div>  

    <?php


    echo do_shortcode("[Product_Table id='{$id}']");
    endwhile;
    endif;

wp_footer(); 
?>
    </div><!-- #page -->
</body>
</html>
