<?php
$wpt_logo = WPT_ASSETS_URL . 'images/logo.png';

/**
 * This following part actually
 * for our both version
 * 
 * ekta en vato nd arekta amader mull site laisens er jonno.
 * code vato hole to WC_MMQ_PRO::$direct er value null thakbe
 * tokhon amra License menu ta ekhane dekhabo na.
 * 
 * ********************
 * arekta prosno jagte pare.
 * ei lai sense er jonno to ekta property achei amade Page_Loader class e
 * tarpor o keno amra ekhane notun kore check korchi.
 * 
 * asoel ei tobbar.php file ta onno class diye o , jemon \WC_MMQ_PRO\Admin\License\Init class eo 
 * load kora hoyeche. tokhon to $this->license pabe na.
 * tai notun kore check korechi.
 */
$license_direct = $pro = $license_page_slug = false;
if( class_exists( '\WOO_Product_Table' ) ){
    $pro = true;
    $license_direct = property_exists( '\WOO_Product_Table','direct' ) ? \WOO_Product_Table::$direct : false;
    $license_page_slug = defined('WPT_EDD_LICENSE_PAGE') ? WPT_EDD_LICENSE_PAGE : false;
}
$current_page = $_GET['page'] ?? '';

$topbar_sub_title = __( 'Manage and Settings', 'wpt' );
if( isset( $this->topbar_sub_title ) && ! empty( $this->topbar_sub_title ) ){
    $topbar_sub_title = $this->topbar_sub_title;
}
?>
<div class="wpt-header wpt-clearfix">
    <div class="container-flued">
        <div class="col-lg-7">
            <div class="wpt-logo-wrapper-area">
                <div class="wpt-logo-area">
                    <img src="<?php echo esc_url( $wpt_logo ); ?>" class="wpt-brand-logo">
                </div>
                <div class="wpt-main-title">
                    <h2 class="wpt-ntitle"><?php _e("Woo Product Table", "wpt");?></h2>
                </div>
                
                <div class="wpt-main-title wpt-main-title-secondary">
                    <h2 class="wpt-ntitle"><?php echo esc_html( $topbar_sub_title );?></h2>
                </div>

            </div>
        </div>
        <div class="col-lg-5">
            <div class="header-button-wrapper">
                <?php if( ! $pro){ ?>
                    <a class="wpt-button reverse" 
                        href="https://wooproducttable.com/pricing/" 
                        target="_blank">
                        <i class="wpt-heart-filled"></i>
                        Get Premium Offer
                    </a>
                <?php }else if( $license_direct && $license_page_slug !== $current_page ){ ?>
                    <a class="wpt-btn wpt-has-icon" 
                        href="<?php echo esc_attr( admin_url( 'edit.php?post_type=wpt_product_table&page=' . $license_page_slug ) ) ?>">
                        <span><i class=" wpt-heart-1"></i></span>
                        License
                    </a>
                <?php } ?>
                
                <a class="wpt-button reset" 
                    href="https://wooproducttable.com/documentation/" 
                    target="_blank">
                    <i class="wpt-note"></i>Documentation
                </a>
                
                <!-- <button class="wpt-btn"><span><i class="wpt-cart"></i></span> Save Chabnge</button> -->
            </div>
        </div>
    </div>
</div>