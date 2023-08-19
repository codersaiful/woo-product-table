<?php 
namespace WOO_PRODUCT_TABLE\Admin\Handle;

use CA_Framework\App\Notice as Notice;
/**
 * Only for Pro user, where need version update.
 * This is only a notice.
 * If installed pro version, and need update
 * then it will show a notice.
 * 
 * @since 3.3.1.1
 * @author Saiful Islam <codersaiful@gmail.com>
 */
class Pro_Version_Update{
    protected $request_min_pro = '8.2.4';
    public function run(){
        if( ! defined( 'WPT_PRO_DEV_VERSION' ) ) return;

        
        if ( version_compare( WPT_PRO_DEV_VERSION, $this->request_min_pro, '<' ) ) {

            $framwork_file = WPT_BASE_DIR . 'framework' . '/ca-framework/framework.php';

            if(! is_file($framwork_file) ) return;
            include_once $framwork_file;

            $pro_upd_notice = new Notice( WPT_DEV_VERSION );

            $title = sprintf( __( 'RECOMMED UPDATE: Woo Product table Pro - CodeAstrology', 'woo-product-table' ), "" );
            $message = sprintf( __( "Your pro version need to update. Minimum Request version: <code>v%s</code> and your current pro version is: <code>v%s</code>. To get all perfect result, Please update your pro version.", 'woo-product-table' ), $this->request_min_pro, WPT_PRO_DEV_VERSION );
            $pro_upd_notice->set_title( $title );
            $pro_upd_notice->set_message( $message );
            $pro_upd_notice->set_diff_limit(5)->set_type('offer');
            
            $pro_upd_notice->show();
            return;
    }

    }
}