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

                    
                    <div class="wpt_faq_support_link_collection">
                        <a href="https://codecanyon.net/user/codeastrology/portfolio" target="_blank"><?php esc_html_e( 'CodeAstrology Portfolios', 'wpt_pro' );?></a>
                        <a href="https://codecanyon.net/user/codeastrology" target="_blank"><?php esc_html_e( 'CodeAstrology Profile', 'wpt_pro' );?></a>
                        <a href="https://codeastrology.com/support/" target="_blank"><?php esc_html_e( 'CodeAstrology Support', 'wpt_pro' );?></a>
                        <a href="https://codeastrology.com" target="_blank"><?php esc_html_e( 'CodeAstrology.com', 'wpt_pro' );?></a>

                    </div>
                    <a href="mailto:codersaiful@gmail.com"><?php esc_html_e( 'We are Freelancer', 'wpt_pro' );?></a>
                    <br style="clear: both;">

                    <br style="clear: both;">
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