<?php 
namespace WOO_PRODUCT_TABLE\Inc\Handle;

use WOO_PRODUCT_TABLE\Inc\Shortcode;

class Message{

    /**
     * Only for Table not found Message
     * Even for Not Publish Table Type Post
     *
     * @param Shortcode $shortcode
     * @return void
     */
    public static function not_found( Shortcode $shortcode ){
            $error_html = "<div class='wpt-post-not-publish'><p>";
            $error_html .= __( 'Your Product Table post is not published properly. ' );
            if( $shortcode->table_id && get_post_type( $shortcode->table_id ) == $shortcode->req_post_type ){
                
                $admin_action_url = admin_url("post.php?post=$shortcode->table_id&action=edit");
                $error_html .= "<a href='$admin_action_url' target='_blank'>";
                $error_html .= __( 'Go here to publish your post' );
                $error_html .= "<a>";
            }else{
                $admin_action_url = admin_url('edit.php?post_type=' . $shortcode->req_post_type );
                
                $error_html .= "<a href='$admin_action_url' target='_blank'>";
                $error_html .= __( 'Click here to create a new Product Table' );
                $error_html .= "<a>";
            }
            
            $error_html .= "</p></div>";
            return $error_html;
    }

    public static function not_found_cols( Shortcode $shortcode ){
        $error_html = "<div class='wpt-post-not-publish'><p>";
        $error_html .= __( "Column's not found. Not set propertly. It's also override by filter hook." );
            $admin_action_url = admin_url("post.php?post=$shortcode->table_id&action=edit");
            $error_html .= "<a href='$admin_action_url' target='_blank'>";
            $error_html .= __( 'Edit your Table Post' );
            $error_html .= "<a>"; 
        $error_html .= "</p></div>";
        return $error_html;
    }




}