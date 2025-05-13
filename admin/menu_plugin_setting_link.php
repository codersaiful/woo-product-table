<?php

add_filter('plugin_action_links_' . WPT_Product_Table::getPath('PLUGIN_BASE_FILE'), 'wpt_add_action_links');

if( !function_exists( 'wpt_add_action_links' ) ){
    /**
     * For showing configure or add new link on plugin page
     * It was actually an individual file, now combine at 4.1.1
     * @param type $links
     * @return type
     */
    function wpt_add_action_links($links) {

        if( ! class_exists( 'WOO_Product_Table' ) ){
            $wpt_links[] = '<a class="wpt-wp-plugin-list-link" href="https://wooproducttable.com/pricing/?utm_source=Product+Table+Dashboard&utm_medium=Free+Version&utm_content=Get+Pro" title="' . esc_attr__( 'Many awesome features is waiting for you', 'woo-product-table' ) . '" target="_blank">'.esc_html__( 'Get Premium','woo-product-table' ).'</a>';
        }
        $wpt_links[] = '<a href="' . admin_url( 'post-new.php?post_type=wpt_product_table' ) . '" title="' . esc_attr__( 'Add Table', 'woo-product-table' ) . '">' . esc_html__( 'Create Table', 'woo-product-table' ).'</a>';
        $wpt_links[] = '<a href="' . admin_url( 'edit.php?post_type=wpt_product_table&page=woo-product-table-config' ) . '" title="' . esc_attr__( 'Table Settings', 'woo-product-table' ) . '">' . esc_html__( 'Table Settings', 'woo-product-table' ) . '</a>';
        $wpt_links[] = '<a href="https://codeastrology.com/my-support/?utm_source=Product+Table+Dashboard&utm_medium=Free+Version" title="' . esc_attr__( 'CodeAstrology Support', 'woo-product-table' ) . '" target="_blank">'.esc_html__( 'Support','woo-product-table' ).'</a>';
        // $wpt_links[] = '<a href="https://github.com/codersaiful/woo-product-table" title="' . esc_attr__( 'Github Repo Link', 'woo-product-table' ) . '" target="_blank">'.esc_html__( 'Github Repository','woo-product-table' ).'</a>';

        return array_merge( $wpt_links, $links );
    }                                       
}
