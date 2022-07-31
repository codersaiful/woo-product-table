<?php
$templates_default = array(
    'default'           =>  __( 'Default Style', 'wpt_pro' ),
    'none'              =>  __( 'Template None', 'wpt_pro' ),
    'beautiful_blacky'  =>  __( 'Beautiful Blacky', 'wpt_pro' ),
);
$pro_templates = array(
    'smart'             =>  __( 'Smart Thin', 'wpt_pro' ),
    'green'             =>  __( 'Green Style', 'wpt_pro' ),
    'blue'              =>  __( 'Blue Style', 'wpt_pro' ),
    'dark'              =>  __( 'Dark Style', 'wpt_pro' ),
    'smart_light'       =>  __( 'Smart Light', 'wpt_pro' ),
    'classic'           =>  __( 'Classic', 'wpt_pro' ),    
    'blue_border'       =>  __( 'Blue Border', 'wpt_pro' ),
    'smart_border'      =>  __( 'Smart Border', 'wpt_pro' ), 
    'pink'              =>  __( 'Pink Style', 'wpt_pro' ),  
    // 'modern'            =>  __( 'Modern Style', 'wpt_pro' ),  
    'orange'            =>  __( 'Orange Style', 'wpt_pro' ), 
    'lightseagreen'     =>  __( 'Lightseagreen Style', 'wpt_pro' ), 
    'red'               =>  __( 'Red Style', 'wpt_pro' ),  
    'golden'            =>  __( 'Golden  Style', 'wpt_pro' ),
    'yellow'            =>  __( 'Yellow  Style', 'wpt_pro' ), 
    'black'            =>  __( 'Black Style', 'wpt_pro' ), 
    
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
                    <label class="wpt_label" for="wpt_style_file_selection"><?php esc_html_e( 'Select Template', 'wpt_pro' ); ?></label>
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
                                $value .= " " . __( '(Premium)', 'wpt_pro' );
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
                    </select>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php do_action( 'wpo_pro_feature_message', 'pf_style_tab' ); ?>
