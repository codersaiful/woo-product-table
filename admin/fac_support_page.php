<?php

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
                
                <img style="margin: 13px auto;max-width: 100%;" src="<?php echo WPT_BASE_URL; ?>images/cover_image.jpg">
                <hr>
                <div class="wpt_faq_support_link_collection">
                    <a href="https://codecanyon.net/user/codeastrology/portfolio" target="_blank"><?php esc_html_e( 'CodeAstrology Portfolios', 'wpt_pro' );?></a>
                    <a href="https://codecanyon.net/user/codeastrology" target="_blank"><?php esc_html_e( 'CodeAstrology Profile', 'wpt_pro' );?></a>
                    <a href="https://codeastrology.com/support/" target="_blank"><?php esc_html_e( 'CodeAstrology Support', 'wpt_pro' );?></a>
                    <a href="https://codeastrology.com" target="_blank"><?php esc_html_e( 'CodeAstrology.com', 'wpt_pro' );?></a>

                </div>
                <a href="mailto:codersaiful@gmail.com"><?php esc_html_e( 'We are Freelancer', 'wpt_pro' );?></a>
                <br style="clear: both;">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/ZloiY3NRmW8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></iframe>
                <div>
                    <h3><?php esc_html_e( 'More Video Tutorial', 'wpt_pro' );?></h3>
                    <a href="https://youtu.be/Jl3gTcOOhRQ"><?php esc_html_e( 'Custom Design Of Woo Product Table Pro', 'wpt_pro' );?></a><br>
                    <a href="https://youtu.be/aOzzYBr2Rug"><?php esc_html_e( 'Custom Field Support In WooCommerce Product Table', 'wpt_pro' );?></a><br>
                    <a href="https://youtu.be/w2vZSIzAJFo"><?php esc_html_e( 'Custom Taxnomoy Support In WooCommerce Product Table Pro', 'wpt_pro' );?></a><br>
                    <a href="https://youtu.be/D_hl2UtVTCw"><?php esc_html_e( 'How to use Woo Product Table Pro - Basic to Advance', 'wpt_pro' );?></a><br><br>
                </div>
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
    padding: 3px 6px;
    cursor: pointer;
    display: inline-block;
    color: #a3d5e0;
    border-radius: 5px;
    transition: all 1s;
    margin: 1px;
}
.wpt_faq_support_link_collection a:hover {
    background: #a3d5e0;
    padding: 3px 8px;
    color: #2a3950;
    border-radius: 8px;
}
@media only screen and (max-width: 800px){
    .wpt_leftside.wpt_rightside{float: none !important;width: 100%;}
}


    </style>
<?php
}