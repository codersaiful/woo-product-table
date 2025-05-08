<?php 
if( !function_exists( 'wpt_duplicate_as_draft' ) ){
    function wpt_duplicate_as_draft(){
            global $wpdb;

            //Nonce verification
            $nonce = sanitize_text_field(   wp_unslash( $_GET['duplicate_nonce'] ?? ''));
            if ( empty($nonce) || ! wp_verify_nonce( $nonce, basename( __FILE__ ) ) ) {
                return;
            }

            if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'wpt_duplicate_as_draft' == $_REQUEST['action'] ) ) ) {
                    wp_die( esc_html__( 'No product for duplicating!', 'woo-product-table' ) );
            }


            


            /*
             * get the original post id
             */
            $post_id = ( isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
            /*
             * and all the original post data then
             */
            $post = get_post( $post_id );

            /*
             * if you don't want current user to be the new post author,
             * then change next couple of lines to this: $new_post_author = $post->post_author;
             */
            $current_user = wp_get_current_user();
            $new_post_author = $current_user->ID;

            /*
             * if post data exists, create the post duplicate
             */
            if (isset( $post ) && $post != null) {

                    /*
                     * new post data array
                     */
                    $args = array(
                            //'comment_status' => $post->comment_status,
                            //'ping_status'    => $post->ping_status,
                            'post_author'    => $new_post_author,
                            //'post_content'   => $post->post_content,
                            //'post_excerpt'   => $post->post_excerpt,
                            'post_name'      => $post->post_name,
                            //'post_parent'    => $post->post_parent,
                            //'post_password'  => $post->post_password,
                            'post_status'    => 'publish',
                            'post_title'     => $post->post_title . " " . $post_id,
                            'post_type'      => $post->post_type,
                            //'to_ping'        => $post->to_ping,
                            //'menu_order'     => $post->menu_order
                    );

                    /*
                     * insert the post by wp_insert_post() function
                     */
                    $new_post_id = wp_insert_post( $args );


                    /*
                     * duplicate all post meta just in two SQL queries
                     */
                    $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");

                    if (count($post_meta_infos)!=0) {
                        foreach ($post_meta_infos as $meta_info) {

                                $meta_key = $meta_info->meta_key;
                                $meta_value = $meta_info->meta_value;
                                if( $meta_key == '_wp_old_slug' ) continue;
                                if( is_serialized( $meta_value ) ){
                                        $meta_value = unserialize( $meta_value );
                                        update_post_meta($new_post_id, $meta_key, $meta_value);
                                }
                        }
                    }
                    wp_redirect( admin_url( 'post.php?post='. $new_post_id . '&action=edit&classic-editor' ) );
                    exit;
                    /*
                     * finally, redirect to the edit post screen for the new draft
                     */

                    $all_post_types = get_post_types([],'names');

                    foreach ($all_post_types as $key=>$value) {
                            $names[] = $key;
                    }

                    $current_post_type=  get_post_type($post_id);

                    if (is_array($names) && in_array($current_post_type, $names)) {
                            //wp_redirect( admin_url( 'edit.php?post_type='.$current_post_type) );
                    }

                    exit;
            } else {
                    wp_die( esc_html__( 'Failed', 'woo-product-table' ) );
            }
    }
}
add_action( 'admin_action_wpt_duplicate_as_draft', 'wpt_duplicate_as_draft' );
 
if( !function_exists( 'wpt_duplicate_link' ) ){
    /*
     * Add the duplicate link to action list for post_row_actions
     */
    function wpt_duplicate_link( $actions, $post ) {
            if (current_user_can('edit_posts') && get_post_type($post->ID) == 'wpt_product_table') {
                    $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=wpt_duplicate_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this Product Table" rel="permalink">Duplicate Product Table</a>';
            }
            return $actions;
    }
}
add_filter( 'post_row_actions', 'wpt_duplicate_link', 10, 2 );
