<?php
$templates_default = array(
    'default'           =>  __('Default Style', 'woo-product-table'),
    'none'              =>  __('Template None', 'woo-product-table'),
    'beautiful_blacky'  =>  __('Beautiful Blacky', 'woo-product-table'),
    'greeny'            =>  __('Greeny', 'woo-product-table'),
    'redy'              =>  __('Redy', 'woo-product-table'),
    // 'argentina'         =>  __( 'Argentina', 'woo-product-table' ),
    // 'brazil'            =>  __( 'Brazil', 'woo-product-table' ),
);
$pro_templates = array(
    'smart'             =>  __('Smart Thin', 'woo-product-table'),
    'green'             =>  __('Green Style', 'woo-product-table'),
    'blue'              =>  __('Blue Style', 'woo-product-table'),
    'dark'              =>  __('Dark Style', 'woo-product-table'),
    'smart_light'       =>  __('Smart Light', 'woo-product-table'),
    'classic'           =>  __('Classic', 'woo-product-table'),
    'blue_border'       =>  __('Blue Border', 'woo-product-table'),
    'smart_border'      =>  __('Smart Border', 'woo-product-table'),
    'pink'              =>  __('Pink Style', 'woo-product-table'),
    // 'modern'            =>  __( 'Modern Style', 'woo-product-table' ),  
    'orange'            =>  __('Orange Style', 'woo-product-table'),
    'lightseagreen'     =>  __('Light Sea Green Style', 'woo-product-table'),
    'red'               =>  __('Red Style', 'woo-product-table'),
    'golden'            =>  __('Golden  Style', 'woo-product-table'),
    'yellow'            =>  __('Yellow  Style', 'woo-product-table'),
    'black'            =>  __('Black Style', 'woo-product-table'),

);

$additional_templates = apply_filters('wpto_table_template_arr', $pro_templates);

$pro_templates = array_merge($pro_templates, $additional_templates);

$table_templates = array();

foreach ($templates_default as $temp_key => $tempplate_name) {
    $table_templates[$temp_key] = array(
        'type' => 'free',
        'value' => $tempplate_name
    );
}

foreach ($pro_templates as $temp_key => $tempplate_name) {
    $table_templates[$temp_key] = array(
        'type' => class_exists('WOO_Product_Table') ? 'approved' : 'limited',
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
                <td colspan="2" class="wpt_table_style">
                    <h1>Select Template</h1>


                    <div id="wpt-template-selector" class="wpt-template-selector-wrapper">
                        <?php foreach ($table_templates as $key => $template) :
                            $template_img_folder_url = WPT_ASSETS_URL . 'images/templates-image/';
                            $template_img_folder_url = apply_filters('wpt_template_img_url', $template_img_folder_url, $key, $template);

                            $type = $template['type'] ?? '';
                            $img_file_name = $key;
                            $img_base_file_dir = WPT_BASE_DIR . "assets/images/templates-image/$key.png";
                            if (! is_file($img_base_file_dir)) {
                                $img_file_name = 'beautiful_blacky';
                            }
                            $img_url = $template_img_folder_url . $img_file_name . '.png';
                            // $img_url = $template_img_folder_url . $img_file_name . '.png';
                            $is_active = ($key === $current_template) ? 'active' : '';
                        ?>
                            <div class="wpt-template-item <?php echo $is_active; ?> wpt-temp-type-<?php echo $type; ?>" data-type="<?php echo esc_attr($type); ?>" data-template="<?php echo esc_attr($key); ?>">
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($template['value']); ?>">
                                <span class="wpt-template-name"><?php echo esc_html($template['value']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>



                    <input type="hidden" name="table_style[template]" data-name="template" id="selected_template" value="<?php echo esc_attr($current_template); ?>">
                    <?php wpt_doc_link('https://wooproducttable.com/docs/doc/table-design/change-table-design-using-template/'); ?>

                </td>
            </tr>

        </table>
    </div>
</div>
<?php
if (!wpt_is_pro()) {
?>
    <div class="wpt-design-tab-area-wrapper">
        <div class="section ultraaddons-panel">
            <h1 class="with-background dark-background wpt-design-expand title-table_header">Table Header<span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h1>
            <table class="ultraaddons-table ultraaddons-table-table_header">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label>Background-Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tr.wpt_table_head th][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Border-Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[table thead][border-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Text-Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tr.wpt_table_head th][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Border Width </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[table thead][border-width]" placeholder="eg: 1px solid black" value="">


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Padding </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[tr.wpt_table_head th][padding]" placeholder="eg: 10px" value="">


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Text Alignment </label>
                        </th>
                        <td>
                            <select class="ua-select " name="table_style[tr.wpt_table_head th][text-align]">
                                <option value="" selected="">Blank (Default)</option>
                                <option value="initial">Initial</option>
                                <option value="center">Center</option>
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                            </select>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Sorted Column BG </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tr th.this_column_sorted][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Font Size </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[tr th][font-size]" placeholder="eg: 10px" value="">


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Font Weight </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[tr th][font-weight]" placeholder="eg: bold" value="">


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Column Label in Auto Responsive </label>
                        </th>
                        <td>
                            <select class="ua-select " name="table_style[tr.wpt_table_head th][auto-responsive-column-label]">
                                <option value="show">Show</option>
                                <option value="hide">Hide</option>
                            </select>

                            <p class="description">Show or hide table column label in mobile or tablet device only when there is no column selected for tablet or mobile device.</p>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section ultraaddons-panel">
            <h1 class="with-background dark-background wpt-design-expand title-body">Table Body<span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h1>
            <table class="ultraaddons-table ultraaddons-table-body">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label>Background Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tbody tr td][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Background Row Hover Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tbody tr:hover td][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Border Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tbody tr td][border-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Text Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tbody tr td][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Text Alignment </label>
                        </th>
                        <td>
                            <select class="ua-select " name="table_style[.wpt_product_table *, .wpt_product_table tr>td, .wpt_product_table td][text-align]">
                                <option value="" selected="">Blank (Default)</option>
                                <option value="initial">Initial</option>
                                <option value="center">Center</option>
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                            </select>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Link Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tbody tr td a][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Link Hover Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tbody tr td a:hover][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>TD Padding </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[tbody tr td][padding]" placeholder="eg: 5px" value="">


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Sorted Column BG </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tbody tr td.this_column_sorted][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Font Size </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[.wpt_product_table *, .wpt_product_table tr>td, .wpt_product_table td][font-size]" placeholder="eg: 17px" value="">


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Font Weight </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[.wpt_product_table *, .wpt_product_table tr>td, .wpt_product_table td][font-weight]" placeholder="eg: bold" value="">


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section ultraaddons-panel">
            <h1 class="with-background dark-background wpt-design-expand title-checkbox">Checkbox Style<span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h1>
            <table class="ultraaddons-table ultraaddons-table-checkbox">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label>Checkbox Background Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[input{type=checkbox}:checked%label:before][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Checkbox Border Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[input{type=checkbox}:checked%label:before][border-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Checkbox Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[input{type=checkbox}:checked%label:after][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section ultraaddons-panel">
            <h1 class="with-background dark-background wpt-design-expand title-button_style">Button Style<span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h1>
            <table class="ultraaddons-table ultraaddons-table-button_style">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label>Background Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.button][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Hover Background Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.button:hover][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Text Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.button][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Text Hover Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.button:hover][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Background Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.button][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section ultraaddons-panel">
            <h1 class="with-background dark-background wpt-design-expand title-add_to_cart">Add to cart Button<span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h1>
            <table class="ultraaddons-table ultraaddons-table-add_to_cart">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label>Background Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.wpt_woo_add_cart_button][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Hover Background Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.wpt_woo_add_cart_button:hover][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Text Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.wpt_woo_add_cart_button][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Font Size </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[a.wpt_woo_add_cart_button][font-size]" placeholder="eg: 17px" value="">


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Text Hover Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.wpt_woo_add_cart_button:hover][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Padding </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[a.wpt_woo_add_cart_button][padding]" placeholder="eg: 10px" value="">


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Button Alignment </label>
                        </th>
                        <td>
                            <select class="ua-select " name="table_style[tr.product_type_simple .item_inside_cell.wpt_action, tr.product_type_simple .td_or_cell.wpt_action>div][justify-content]">
                                <option value="" selected="">Left (Default)</option>
                                <option value="center">Center</option>
                                <option value="end">Right</option>
                            </select>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section ultraaddons-panel">
            <h1 class="with-background dark-background wpt-design-expand title-pagination">Pagination<span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h1>
            <table class="ultraaddons-table ultraaddons-table-pagination">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label>Active Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.wpt_table_pagination a.page-numbers.current][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Hover Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.wpt_table_pagination a:hover][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Border Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.wpt_tspan.page-numbers.current, a.page-numbers.current][border-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Text Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.page-numbers, span.page-numbers][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Active Text Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.wpt_tspan.page-numbers.current, a.page-numbers.current][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Alignment </label>
                        </th>
                        <td>
                            <select class="ua-select " name="table_style[.wpt_table_pagination][text-align]">
                                <option value="" selected="">Blank (Default)</option>
                                <option value="center">Center</option>
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                            </select>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section ultraaddons-panel">
            <h1 class="with-background dark-background wpt-design-expand title-advance_search">Advance Search<span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h1>
            <table class="ultraaddons-table ultraaddons-table-advance_search">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label>Keywords Field Width </label>
                        </th>
                        <td>
                            <select class="ua-select " name="table_style[.wpt_search_box .search_single .search_single_column][width]">
                                <option value="">Blank (Default)</option>
                                <option value="33.33%">33.33%</option>
                                <option value="50%">50%</option>
                                <option value="100%" selected="">100%</option>
                            </select>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Keywords Field Alignment </label>
                        </th>
                        <td>
                            <select class="ua-select " name="table_style[.wpt_search_box .search_single .search_single_column][width]">
                                <option value="" selected="">Blank (Default)</option>
                                <option value="left">Left</option>
                                <option value="none">None</option>
                                <option value="right">Light</option>
                            </select>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section ultraaddons-panel">
            <h1 class="with-background dark-background wpt-design-expand title-selected_element">Special Elements<span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h1>
            <table class="ultraaddons-table ultraaddons-table-selected_element">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label>Product Title Font Size </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[a.wpt_product_title_in_td][font-size]" placeholder="" value="">


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Product Title Text Align </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[a.wpt_product_title_in_td][text-align]" placeholder="" value="">


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Product Title Font weight </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[a.wpt_product_title_in_td][font-weight]" placeholder="" value="">


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Product Title Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.wpt_product_title_in_td][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Product Title Hover Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.wpt_product_title_in_td:hover][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Price Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[td.td_or_cell .amount][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Price Hover Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[td.td_or_cell .amount:hover][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Price Currency Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[td.td_or_cell .amount .woocommerce-Price-currencySymbol][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Price Font weight </label>
                        </th>
                        <td>

                            <input class="regular-text " type="text" name="table_style[td.td_or_cell .amount][font-weight]" placeholder="" value="">


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section ultraaddons-panel">
            <h1 class="with-background dark-background wpt-design-expand title-others">Others<span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h1>
            <table class="ultraaddons-table ultraaddons-table-others">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label>Footer Background Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.all_check_footer][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Pouup Background Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[div.wpt_notice_board div.woocommerce-message][background-color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label>Pouup Text Color </label>
                        </th>
                        <td>

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[div.wpt_notice_board div.woocommerce-message][color]" placeholder="" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div>
                                            </div>
                                        </div>
                                        <div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div>
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>
<?php
}
// do_action( 'wpo_pro_feature_message', 'pf_style_tab' );
?>