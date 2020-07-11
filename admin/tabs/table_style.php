<?php
//Set Default Value
$meta_table_style['template'] = 'custom';
//Table Header
$meta_table_style['tr.wpt_table_head th']['background-color'] = '';
$meta_table_style['table thead']['border-color'] = '';
$meta_table_style['tr.wpt_table_head th']['color'] = '';
$meta_table_style['table thead']['border-width'] = '';
$meta_table_style['tr.wpt_table_head th']['padding'] = '';
$meta_table_style['tr.wpt_table_head th']['text-align'] = '';
$meta_table_style['tr th.this_column_sorted']['background-color'] = '';

//Table Body
$meta_table_style['tbody tr td']['background-color'] = '';
$meta_table_style['tbody tr td:hover']['background-color'] =  '';
$meta_table_style['tbody tr td']['border-color'] = '';

$meta_table_style['tbody tr td']['color'] = '';
$meta_table_style['tbody tr td a']['color'] = '';
$meta_table_style['tbody tr td a:hover']['color'] = '';

$meta_table_style['tbody tr td']['padding'] = '';
$meta_table_style['tbody tr td.this_column_sorted']['background-color'] = '';

//Checkbox
$meta_table_style['input{type=checkbox}:checked%label:before']['background-color'] = '';
$meta_table_style['input{type=checkbox}:checked%label:before']['border-color'] = '';
$meta_table_style['input{type=checkbox}:checked%label:after']['color'] = '';
#Plus sign has changed to %

//Button Style
$meta_table_style['.button']['background-color'] = '';
$meta_table_style['.button:hover']['background-color'] = '';
$meta_table_style['.button']['color'] = '';
$meta_table_style['.button:hover']['color'] = '';
$meta_table_style['.button']['padding'] =  '';

//Add to Cart Button
$meta_table_style['a.wpt_woo_add_cart_button']['background-color'] = '';
$meta_table_style['a.wpt_woo_add_cart_button:hover']['background-color'] = '';
$meta_table_style['a.wpt_woo_add_cart_button']['color'] = '';
$meta_table_style['a.wpt_woo_add_cart_button:hover']['color'] = '';
$meta_table_style['a.wpt_woo_add_cart_button']['padding'] = '';

//Paginationn
$meta_table_style['.wpt_table_pagination a.page-numbers.current']['background-color'] = '';
$meta_table_style['.wpt_table_pagination a:hover']['background-color'] = '';
$meta_table_style['.wpt_tspan.page-numbers.current, a.page-numbers.current']['border-color'] = '';
$meta_table_style['a.page-numbers, span.page-numbers']['color'] = '';
$meta_table_style['.wpt_tspan.page-numbers.current, a.page-numbers.current']['color'] = '';
$meta_table_style['.wpt_table_pagination']['text-align'] = '';

//Advance Searchbox Options 
$meta_table_style['.search_single_order_by']['display'] = 'none';
$meta_table_style['.search_single_order']['display'] = 'none';
$meta_table_style['.wpt_search_box .search_single .search_single_column']['width'] = '100%';
$meta_table_style['.wpt_search_box .search_single .search_single_column']['float'] = '';
//Others part
$meta_table_style['.all_check_footer']['background-color'] = '';
$meta_table_style_inPost = get_post_meta($post->ID, 'table_style', true);
$wpt_table_style_reset = false;
/**********************/
if( is_array( $meta_table_style_inPost ) && !isset( $_GET['reset'] ) ){
    foreach( $meta_table_style as $key=>$styles ){
        if( is_array( $styles ) ){
            foreach( $styles as $style_key=>$style_value ){
                $generated_meta_style[$key][$style_key] = isset( $meta_table_style_inPost[$key][$style_key] ) ? $meta_table_style_inPost[$key][$style_key] : $meta_table_style[$key][$style_key];
            }
        }else{
           $generated_meta_style[$key] = isset( $meta_table_style_inPost[$key] ) ? $meta_table_style_inPost[$key] : $meta_table_style[$key];
        }
    }
    $meta_table_style = $generated_meta_style;
    $wpt_table_style_reset = true;
}
//*********************/
$wpt_style_file_selection_options = WPT_Product_Table::$style_form_options;
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
                        foreach ( $wpt_style_file_selection_options as $key => $value ) {
                            echo "<option value='" . esc_attr( $key ) . "' ";
                            echo isset( $meta_table_style['template'] ) && $meta_table_style['template'] == $key ? 'selected' : '' ;
                            echo ">" . esc_html( $value ) . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
    </div>
</div>
<!--    <div class="wpt_customized_style_box_wrapper">
        <div class="wpt_table_preview_box">

        </div>-->
<div class="section ultraaddons-panel">
    <h1 class="with-background dark-background"><?php esc_html_e( 'Table Header', 'wpt_pro' ); ?></h1>
    <table class="ultraaddons-table">
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Background-Color', 'wpt_pro' ); ?> </label>
            </th>
            <td>
                <input class="regular-text wpt_color_picker" type="text" id="" name="table_style[tr.wpt_table_head th][background-color]" value="<?php echo $meta_table_style['tr.wpt_table_head th']['background-color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Border-Color', 'wpt_pro' ); ?> </label>
            </th>
            <td>
                <input class="regular-text wpt_color_picker" type="text" id="" name="table_style[table thead][border-color]" value="<?php echo $meta_table_style['table thead']['border-color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Text-Color', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text wpt_color_picker" type="text" id="" name="table_style[tr.wpt_table_head th][color]" value="<?php echo $meta_table_style['tr.wpt_table_head th']['color']; ?>">
            </td>            
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Border Width', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text ua_input" type="text" id="" name="table_style[table thead][border-width]" value="<?php echo $meta_table_style['table thead']['border-width']; ?>">
            </td>     
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Padding', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text wpt_slider ua_input" type="text" id="" name="table_style[tr.wpt_table_head th][padding]" value="<?php echo $meta_table_style['tr.wpt_table_head th']['padding']; ?>" placeholder="eg: 10px">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Text Alignment', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <?php $wpt_thead_alignment = $meta_table_style['tr.wpt_table_head th']['text-align']; ?>
                <select name="table_style[tr.wpt_table_head th][text-align]" class="ua_input">
                    <option value="" <?php echo $wpt_thead_alignment == '' ? 'selected' : ''; ?>><?php esc_html_e( 'Blank (Default)', 'wpt_pro' ); ?></option>
                    <option value="initial" <?php echo $wpt_thead_alignment == 'initial' ? 'selected' : ''; ?>><?php esc_html_e( 'Initial', 'wpt_pro' ); ?></option>
                    <option value="center" <?php echo $wpt_thead_alignment == 'center' ? 'selected' : ''; ?>><?php esc_html_e( 'Center', 'wpt_pro' ); ?></option>
                    <option value="left" <?php echo $wpt_thead_alignment == 'left' ? 'selected' : ''; ?>><?php esc_html_e( 'Left', 'wpt_pro' ); ?></option>
                    <option value="right" <?php echo $wpt_thead_alignment == 'right' ? 'selected' : ''; ?>><?php esc_html_e( 'Right', 'wpt_pro' ); ?></option>
                </select>
            </td>  
        </tr>

        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Sorted Column BG', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text wpt_color_picker" type="text" id="" name="table_style[tr th.this_column_sorted][background-color]" value="<?php echo $meta_table_style['tr th.this_column_sorted']['background-color']; ?>">
            </td>        
        </tr>
    </table>
</div>
<div class="section ultraaddons-panel">
    <h1 class="with-background dark-background"><?php esc_html_e( 'Table Body', 'wpt_pro' ); ?></h1>
    <table class="ultraaddons-table">
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Background Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[tbody tr td][background-color]" value="<?php echo $meta_table_style['tbody tr td']['background-color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Background Hover Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[tbody tr td:hover][background-color]" value="<?php echo $meta_table_style['tbody tr td:hover']['background-color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Border Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[tbody tr td][border-color]" value="<?php echo $meta_table_style['tbody tr td']['border-color']; ?>">
            </td>     
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Text Color', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[tbody tr td][color]" value="<?php echo $meta_table_style['tbody tr td']['color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Link Color', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[tbody tr td a][color]" value="<?php echo $meta_table_style['tbody tr td a']['color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Link Hover Color', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[tbody tr td a:hover][color]" value="<?php echo $meta_table_style['tbody tr td a:hover']['color']; ?>">
            </td>     
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'TD Padding', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text wpt_slider ua_input" type="text" id="" name="table_style[tbody tr td][padding]" value="<?php echo $meta_table_style['tbody tr td']['padding']; ?>" placeholder="eg: 10px">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Sorted Column BG', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text wpt_color_picker" type="text" id="" name="table_style[tbody tr td.this_column_sorted][background-color]" value="<?php echo $meta_table_style['tbody tr td.this_column_sorted']['background-color']; ?>">
            </td>        
        </tr>
    </table>
</div>
<div class="section ultraaddons-panel">
    <h1 class="with-background dark-background"><?php esc_html_e( 'Checkbox Style', 'wpt_pro' ); ?></h1>
    <table class="ultraaddons-table">
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Checkbox Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[input{type=checkbox}:checked%label:before][background-color]" value="<?php echo $meta_table_style['input{type=checkbox}:checked%label:before']['background-color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Checkbox Border Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[input{type=checkbox}:checked%label:before][border-color]" value="<?php echo $meta_table_style['input{type=checkbox}:checked%label:before']['border-color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Checkbox Sign Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[input{type=checkbox}:checked%label:after][color]" value="<?php echo $meta_table_style['input{type=checkbox}:checked%label:after']['color']; ?>">
            </td>
        </tr>
    </table>
</div>
<div class="section ultraaddons-panel">
    <h1 class="with-background dark-background"><?php esc_html_e( 'Button Style', 'wpt_pro' ); ?></h1>
    <table class="ultraaddons-table">
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Background Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[.button][background-color]" value="<?php echo $meta_table_style['.button']['background-color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Hover Background Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[.button:hover][background-color]" value="<?php echo $meta_table_style['.button:hover']['background-color']; ?>">
            </td>
        </tr>
        
        <tr>

            <th scope="row">
                <label><?php esc_html_e( 'Text Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[.button][color]" value="<?php echo $meta_table_style['.button']['color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Text Hover Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[.button:hover][color]" value="<?php echo $meta_table_style['.button:hover']['color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Padding', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text wpt_slider ua_input" type="text" id="" name="table_style[.button][padding]" value="<?php echo $meta_table_style['.button']['padding']; ?>" placeholder="eg: 10px">
            </td> 
        </tr>
    </table>
</div>
<div class="section ultraaddons-panel">
    <h1 class="with-background dark-background"><?php esc_html_e( 'Add To Cart Button', 'wpt_pro' ); ?></h1>
    <table class="ultraaddons-table">
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Background Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[a.wpt_woo_add_cart_button][background-color]" value="<?php echo $meta_table_style['a.wpt_woo_add_cart_button']['background-color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Hover Background Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[a.wpt_woo_add_cart_button:hover][background-color]" value="<?php echo $meta_table_style['a.wpt_woo_add_cart_button:hover']['background-color']; ?>">
            </td>
        </tr>
        
        <tr>

            <th scope="row">
                <label><?php esc_html_e( 'Text Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[a.wpt_woo_add_cart_button][color]" value="<?php echo $meta_table_style['a.wpt_woo_add_cart_button']['color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Text Hover Color', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[a.wpt_woo_add_cart_button:hover][color]" value="<?php echo $meta_table_style['a.wpt_woo_add_cart_button:hover']['color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Padding', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <input class="regular-text wpt_slider ua_input" type="text" id="" name="table_style[a.wpt_woo_add_cart_button][padding]" value="<?php echo $meta_table_style['a.wpt_woo_add_cart_button']['padding']; ?>" placeholder="eg: 10px">
            </td> 
        </tr>
    </table>
</div>
<div class="section ultraaddons-panel">
    <h1 class="with-background dark-background"><?php esc_html_e( 'Pagination', 'wpt_pro' ); ?></h1>
    <table class="ultraaddons-table">
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Active Color', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[.wpt_table_pagination a.page-numbers.current][background-color]" value="<?php echo $meta_table_style['.wpt_table_pagination a.page-numbers.current']['background-color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Hover Color', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[.wpt_table_pagination a:hover][background-color]" value="<?php echo $meta_table_style['.wpt_table_pagination a:hover']['background-color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Border Color', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[.wpt_tspan.page-numbers.current, a.page-numbers.current][border-color]" value="<?php echo $meta_table_style['.wpt_tspan.page-numbers.current, a.page-numbers.current']['border-color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Text Color', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[a.page-numbers, span.page-numbers][color]" value="<?php echo $meta_table_style['a.page-numbers, span.page-numbers']['color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Active Text Color', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[.wpt_tspan.page-numbers.current, a.page-numbers.current][color]" value="<?php echo $meta_table_style['.wpt_tspan.page-numbers.current, a.page-numbers.current']['color']; ?>">
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Alignment', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <?php $wpt_pagi_alignment = $meta_table_style['.wpt_table_pagination']['text-align']; ?>
                <select class="wpt_pagination_alignment ua_input" name="table_style[.wpt_table_pagination][text-align]">
                    <option value="" <?php echo $wpt_pagi_alignment == '' ? 'selected' : ''; ?>><?php esc_html_e( 'Blank (Default)', 'wpt_pro' ); ?></option>
                    <option value="center" <?php echo $wpt_pagi_alignment == 'center' ? 'selected': '' ?>><?php esc_html_e( 'Center', 'wpt_pro' ); ?></option>
                    <option value="left" <?php echo $wpt_pagi_alignment == 'left' ? 'selected': '' ?>><?php esc_html_e( 'Left', 'wpt_pro' ); ?></option>
                    <option value="right" <?php echo $wpt_pagi_alignment == 'right' ? 'selected': '' ?>><?php esc_html_e( 'Right', 'wpt_pro' ); ?></option>
                </select>
            </td>
        </tr>
    </table>
</div>
<div class="section ultraaddons-panel">
    <h1 class="with-background dark-background"><?php esc_html_e( 'Advance Searchbox Field Control', 'wpt_pro' ); ?></h1>
    <table class="ultraaddons-table">
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Keywords Field Width', 'wpt_pro' ); ?></label>
            </th>
            <td>
                <?php
                $wpt_advanced_sbox_control = $meta_table_style['.wpt_search_box .search_single .search_single_column']['width'];
                ?>
                <select class="wpt_advanced_sbox_opt_control ua_input" name="table_style[.wpt_search_box .search_single .search_single_column][width]">
                    <option value="" <?php echo $wpt_advanced_sbox_control == '' ? 'selected' : ''; ?>><?php esc_html_e( 'Blank (Default)', 'wpt_pro' ); ?></option>
                    <option value="33.33%" <?php echo $wpt_advanced_sbox_control == '33.33%' ? 'selected' : '' ?>><?php esc_html_e( '33.33%', 'wpt_pro' ); ?></option>
                    <option value="50%" <?php echo $wpt_advanced_sbox_control == '50%' ? 'selected' : '' ?>><?php esc_html_e( '50%', 'wpt_pro' ); ?></option>
                    <option value="100%" <?php echo $wpt_advanced_sbox_control == '100%' ? 'selected' : '' ?>><?php esc_html_e( '100%', 'wpt_pro' ); ?></option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Keywords Field Alignment', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <?php
                $wpt_advanced_sbox_control = $meta_table_style['.wpt_search_box .search_single .search_single_column']['float'];
                ?>
                <select class="wpt_advanced_sbox_opt_control ua_input" name="table_style[.wpt_search_box .search_single .search_single_column][float]">
                    <option value="" <?php echo $wpt_advanced_sbox_control == '' ? 'selected' : ''; ?>><?php esc_html_e( 'Blank (Default)', 'wpt_pro' ); ?></option>
                    <option value="left" <?php echo $wpt_advanced_sbox_control == 'left' ? 'selected' : '' ?>><?php esc_html_e( 'Default (Left)', 'wpt_pro' ); ?></option>
                    <option value="none" <?php echo $wpt_advanced_sbox_control == 'none' ? 'selected' : '' ?>><?php esc_html_e( 'None (Center)', 'wpt_pro' ); ?></option>
                    <option value="right" <?php echo $wpt_advanced_sbox_control == 'right' ? 'selected' : '' ?>><?php esc_html_e( 'Right', 'wpt_pro' ); ?></option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Order By Field Display/Hide', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <?php
                $wpt_advanced_sbox_control = $meta_table_style['.search_single_order_by']['display'];
                ?>
                <select class="wpt_advanced_sbox_opt_control ua_input" name="table_style[.search_single_order_by][display]">
                    <option value="" <?php echo $wpt_advanced_sbox_control == '' ? 'selected' : ''; ?>><?php esc_html_e( 'Blank (Default)', 'wpt_pro' ); ?></option>
                    <option value="initial" <?php echo $wpt_advanced_sbox_control == 'initial' ? 'selected' : '' ?>><?php esc_html_e( 'Show', 'wpt_pro' ); ?></option>
                    <option value="none" <?php echo $wpt_advanced_sbox_control == 'none' ? 'selected' : '' ?>><?php esc_html_e( 'Hide', 'wpt_pro' ); ?></option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Order Field Display/Hide', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <?php $wpt_advanced_sbox_control_order = $meta_table_style['.search_single_order']['display']; ?>
                <select class="wpt_advanced_sbox_opt_control ua_input" name="table_style[.search_single_order][display]">
                    <option value="" <?php echo $wpt_advanced_sbox_control == '' ? 'selected' : ''; ?>><?php esc_html_e( 'Blank (Default)', 'wpt_pro' ); ?></option>
                    <option value="initial" <?php echo $wpt_advanced_sbox_control_order == 'initial' ? 'selected' : '' ?>><?php esc_html_e( 'Show', 'wpt_pro' ); ?></option>
                    <option value="none" <?php echo $wpt_advanced_sbox_control_order == 'none' ? 'selected' : '' ?>><?php esc_html_e( 'Hide', 'wpt_pro' ); ?></option>
                </select>
            </td>
        </tr>
    </table>
</div>
<div class="section ultraaddons-panel">
    <h1 class="with-background dark-background"><?php esc_html_e( 'Others', 'wpt_pro' ); ?></h1>
    <table class="ultraaddons-table">
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Footer Background Color', 'wpt_pro' ); ?></label> 
            </th>
            <td>
                <input class="regular-text  wpt_color_picker" type="text" id="" name="table_style[.all_check_footer][background-color]" value="<?php echo $meta_table_style['.all_check_footer']['background-color']; ?>">
            </td>
        </tr>
    </table>
</div>
        <?php if( $wpt_table_style_reset ){?>
        <div class="wpt_table_style_reset_wrapper">
            <?php
            if (isset($_SERVER['HTTPS']) &&
                ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
                isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
                $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
                $protocol = 'https://';
            } else {
                $protocol = 'http://';
            }
            $wpt_current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $wpt_reset_url = $wpt_current_url . '&reset=yes#table_style';
            ?>
            <p><?php esc_html_e( 'Remember: Reset will not store other tab\'s change. So First Update, If you changed others tab. such: Column,Basics etc', 'wpt_pro' ); ?></p>
            <a class="button wpt_style_reset_button" href="<?php echo $wpt_reset_url; ?>"><?php esc_html_e( 'Reset Style to Default', 'wpt_pro' ); ?></a>
        </div>
        <?php } ?>