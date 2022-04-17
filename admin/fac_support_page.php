<?php
if( !function_exists( 'wpt_fac_support_page' ) ){
    /**
     * Faq and contact us page
     * 
     * @since 4.25
     */
    function wpt_fac_support_page(){
    ?>
    <div class="wrap wpt_wrap wpt_configure_page">
            <h2 class="plugin_name"><?php esc_html_e( 'Contact & Support', 'wpt_pro' );?></h2>
            <div id="wpt_configuration_form" class="wpt_leftside">


                <div style="text-align:center;" class="fieldwrap wpt_result_footer">

                    
                <div class="ca-wrap">
    <div class="ca-inner">
        <div class="ca-infobox">
            <div class="ca-header">
                 <h1 class="ca-infobox-tilte"><?php echo esc_html( 'CA WOOCOMMERCE QUICK VIEW', 'cawqv' ); ?></h1>
                 <small> <?php echo esc_html( 'A Perfect WooCommerce Quick View Plugin With Perfect Options.', 'cawqv' ); ?></small>
            </div>

            <div class="row">
                <div class="column-2"> 
                <div class="cawqv-logo">
                    <img src="<?php echo plugins_url("/", __FILE__) .
                        "/img/cawqv.jpg"; ?>" >
                </div>
                <?php 
                $message = __( '<strong>Quick View by Code Astrology</strong> (WooCommerce Quick View) allows users to get a quick look at products without opening the product page. Users can navigate the product gallery from one to another using the next and previous slider buttons.
                 <p>Users can live style quick view. Please go to the settings button to live customize.</p> ', 'cawqv' );
 
                printf( '<div class="%1$s"><p>%2$s</p></div>', '', wp_kses_post( $message ) );
                ?>
                
                <a href="<?php echo admin_url( "/customize.php?autofocus[panel]=cawqv_customizer_panel");?>" class="btn ca-btn"> <?php echo __("Go to Settings", "cawqv"); ?></a>
                </div>
            </div>
        </div>
    </div>
</div><!-- .wrap -->


                </div>
                <!-- </form> -->

                <br style="clear: both;">
            </div>
            <!-- Right Side start here -->
            <?php include __DIR__ . '/includes/right_side.php'; ?> 

    </div>
    <style>
    .wpt_leftside,.wpt_rightside{float: left;min-height: 500px;}
    .wpt_leftside{
        width: 65%;
    }
    .wpt_rightside{width: 32%; margin-top: -42px;}
    .wpt_faq_support_link_collection a {
            text-decoration: none;
        background: #2a3950;
        padding: 55px;
        cursor: pointer;
        display: inline-block;
        color: #a3d5e0;
        border-radius: 5px;
        transition: all 1s;
        margin: 1px;
        font-size: 2em;
    }
    .wpt_faq_support_link_collection a:hover {
        background: #a3d5e0;
        color: #2a3950;
        border-radius: 8px;
    }
    @media only screen and (max-width: 800px){
        .wpt_leftside.wpt_rightside{float: none !important;width: 100%;}
    }


        </style>
    <?php
    }
}