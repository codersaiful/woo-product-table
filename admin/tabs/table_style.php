<?php
$templates_default = array(
    'default'           =>  __( 'Default Style', 'woo-product-table' ),
    'none'              =>  __( 'Template None', 'woo-product-table' ),
    'beautiful_blacky'  =>  __( 'Beautiful Blacky', 'woo-product-table' ),
    'greeny'            =>  __( 'Greeny', 'woo-product-table' ),
    'redy'              =>  __( 'Redy', 'woo-product-table' ),
    // 'argentina'         =>  __( 'Argentina', 'woo-product-table' ),
    // 'brazil'            =>  __( 'Brazil', 'woo-product-table' ),
);
$pro_templates = array(
    'smart'             =>  __( 'Smart Thin', 'woo-product-table' ),
    'green'             =>  __( 'Green Style', 'woo-product-table' ),
    'blue'              =>  __( 'Blue Style', 'woo-product-table' ),
    'dark'              =>  __( 'Dark Style', 'woo-product-table' ),
    'smart_light'       =>  __( 'Smart Light', 'woo-product-table' ),
    'classic'           =>  __( 'Classic', 'woo-product-table' ),    
    'blue_border'       =>  __( 'Blue Border', 'woo-product-table' ),
    'smart_border'      =>  __( 'Smart Border', 'woo-product-table' ), 
    'pink'              =>  __( 'Pink Style', 'woo-product-table' ),  
    // 'modern'            =>  __( 'Modern Style', 'woo-product-table' ),  
    'orange'            =>  __( 'Orange Style', 'woo-product-table' ), 
    'lightseagreen'     =>  __( 'Light Sea Green Style', 'woo-product-table' ), 
    'red'               =>  __( 'Red Style', 'woo-product-table' ),  
    'golden'            =>  __( 'Golden  Style', 'woo-product-table' ),
    'yellow'            =>  __( 'Yellow  Style', 'woo-product-table' ), 
    'black'            =>  __( 'Black Style', 'woo-product-table' ), 
    
);

$additional_templates = apply_filters( 'wpto_table_template_arr', $pro_templates );

$pro_templates = array_merge($pro_templates,$additional_templates);

$table_templates = array();

foreach( $templates_default as $temp_key => $tempplate_name ){
    $table_templates[$temp_key] = array(
        'type' => 'free',
        'value' => $tempplate_name
    );
}

foreach( $pro_templates as $temp_key => $tempplate_name ){
    $table_templates[$temp_key] = array(
        'type' => class_exists( 'WOO_Product_Table' ) ? 'approved' : 'limited',
        'value' => $tempplate_name
    );
}

$meta_table_style_inPost = get_post_meta($post->ID, 'table_style', true);
$current_template = $meta_table_style_inPost['template'] ?? '';
?>
<div class="section ultraaddons-panel">
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_style_file_selection"><?php esc_html_e( 'Select Template', 'woo-product-table' ); ?></label>
                </th>
                <td>
                    <select name="table_style[template]" data-name="template" id="wpt_style_file_selection"  class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <?php
                        foreach ( $table_templates as $key => $template ) {
                            $type = $template['type'];
                            $value = $template['value'];
                            $read_only = '';
                            
                            if( $type == 'limited' ){
                                
                                $read_only = 'disabled';
                            }
                            
                            if( $type !== 'free' ){
                                $value .= " " . __( '(Premium)', 'woo-product-table' );
                            }

                            
                            $selected = $current_template == $key ? 'selected' : '';
                        ?>
                        <option
                        value="<?php echo esc_attr( $key ); ?>"
                        <?php echo esc_attr( $selected ); ?>
                        <?php echo esc_attr( $read_only ); ?>
                        >
                            <?php echo esc_html( $value ); ?>
                        </option>
                        <?php 
                        }
                        ?>
                    </select> <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-design/change-table-design-using-template/'); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php do_action( 'wpo_pro_feature_message', 'pf_style_tab' ); ?>
