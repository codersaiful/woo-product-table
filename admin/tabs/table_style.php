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
<div title="Premium Feature" class="wpt-design-tab-area-wrapper wpt-design-tab-area-wrapper-pro-in-free">
    <div class="section ultraaddons-panel">
        <h1 class="with-background dark-background wpt-design-expand title-table_header">Table Header<span title="Collapse/Expand" class="wpt-design-collaps"> <i class="wpt-expand-collapse"></i></span></h1>
        <table class="ultraaddons-table ultraaddons-table-table_header">
            <tbody>
                <tr>
                    <th scope="row">
                        <label>Background-Color </label>
                    </th>
                    <td>

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(221, 51, 51);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tr.wpt_table_head th][background-color]" placeholder="" value="#dd3333"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 23.6762px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 56, 56), rgb(255, 156, 56), rgb(255, 255, 56), rgb(156, 255, 56), rgb(56, 255, 56), rgb(56, 255, 156), rgb(56, 255, 255), rgb(56, 156, 255), rgb(56, 56, 255), rgb(156, 56, 255), rgb(255, 56, 255), rgb(255, 56, 156), rgb(255, 56, 56));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(219, 0, 0), rgb(222, 222, 222));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 77%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(238, 238, 34);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tr.wpt_table_head th][color]" placeholder="" value="#eeee22"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 30.3542px; top: 12.7487px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 36, 36), rgb(255, 145, 36), rgb(255, 255, 36), rgb(145, 255, 36), rgb(36, 255, 36), rgb(36, 255, 145), rgb(36, 255, 255), rgb(36, 145, 255), rgb(36, 36, 255), rgb(145, 36, 255), rgb(255, 36, 255), rgb(255, 36, 145), rgb(255, 36, 36));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(235, 235, 0), rgb(237, 237, 237));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 86%;"></span></div>
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
                            <option value="show" selected="">Show</option>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(129, 215, 66);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tbody tr td][background-color]" placeholder="" value="#81d742"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 48.0608px; top: 29.14px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 77, 77), rgb(255, 166, 77), rgb(255, 255, 77), rgb(166, 255, 77), rgb(77, 255, 77), rgb(77, 255, 166), rgb(77, 255, 255), rgb(77, 166, 255), rgb(77, 77, 255), rgb(166, 77, 255), rgb(255, 77, 255), rgb(255, 77, 166), rgb(255, 77, 77));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(89, 214, 0), rgb(214, 214, 214));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 69%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(130, 36, 227);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tbody tr:hover td][background-color]" placeholder="" value="#8224e3"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 136.594px; top: 20.0337px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 41, 41), rgb(255, 148, 41), rgb(255, 255, 41), rgb(148, 255, 41), rgb(41, 255, 41), rgb(41, 255, 148), rgb(41, 255, 255), rgb(41, 148, 255), rgb(41, 41, 255), rgb(148, 41, 255), rgb(255, 41, 255), rgb(255, 41, 148), rgb(255, 41, 41));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(112, 0, 224), rgb(227, 227, 227));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 84%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(130, 36, 227);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[tbody tr td][border-color]" placeholder="" value="#8224e3"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 136.594px; top: 20.0337px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 41, 41), rgb(255, 148, 41), rgb(255, 255, 41), rgb(148, 255, 41), rgb(41, 255, 41), rgb(41, 255, 148), rgb(41, 255, 255), rgb(41, 148, 255), rgb(41, 41, 255), rgb(148, 41, 255), rgb(255, 41, 255), rgb(255, 41, 148), rgb(255, 41, 41));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(112, 0, 224), rgb(227, 227, 227));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 84%;"></span></div>
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
                            <option value="">Blank (Default)</option>
                            <option value="initial">Initial</option>
                            <option value="center" selected="">Center</option>
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

                        <input class="regular-text " type="text" name="table_style[.wpt_product_table *, .wpt_product_table tr>td, .wpt_product_table td][font-size]" placeholder="eg: 17px" value="12px">


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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(221, 153, 51);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[input{type=checkbox}:checked%label:before][background-color]" placeholder="" value="#dd9933"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 18.2125px; top: 23.6762px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 56, 56), rgb(255, 156, 56), rgb(255, 255, 56), rgb(156, 255, 56), rgb(56, 255, 56), rgb(56, 255, 156), rgb(56, 255, 255), rgb(56, 156, 255), rgb(56, 56, 255), rgb(156, 56, 255), rgb(255, 56, 255), rgb(255, 56, 156), rgb(255, 56, 56));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(219, 132, 0), rgb(222, 222, 222));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 77%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(186, 53, 142);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[input{type=checkbox}:checked%label:before][border-color]" placeholder="" value="#ba358e"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 161.889px; top: 49.1737px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 71, 71), rgb(255, 163, 71), rgb(255, 255, 71), rgb(163, 255, 71), rgb(71, 255, 71), rgb(71, 255, 163), rgb(71, 255, 255), rgb(71, 163, 255), rgb(71, 71, 255), rgb(163, 71, 255), rgb(255, 71, 255), rgb(255, 71, 163), rgb(255, 71, 71));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(184, 0, 122), rgb(186, 186, 186));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 72%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(30, 115, 190);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[input{type=checkbox}:checked%label:after][color]" placeholder="" value="#1e73be"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 105.228px; top: 45.5312px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 41, 41), rgb(255, 148, 41), rgb(255, 255, 41), rgb(148, 255, 41), rgb(41, 255, 41), rgb(41, 255, 148), rgb(41, 255, 255), rgb(41, 148, 255), rgb(41, 41, 255), rgb(148, 41, 255), rgb(255, 41, 255), rgb(255, 41, 148), rgb(255, 41, 41));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 101, 189), rgb(191, 191, 191));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 84%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(130, 36, 227);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.button][background-color]" placeholder="" value="#8224e3"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 136.594px; top: 20.0337px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 41, 41), rgb(255, 148, 41), rgb(255, 255, 41), rgb(148, 255, 41), rgb(41, 255, 41), rgb(41, 255, 148), rgb(41, 255, 255), rgb(41, 148, 255), rgb(41, 41, 255), rgb(148, 41, 255), rgb(255, 41, 255), rgb(255, 41, 148), rgb(255, 41, 41));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(112, 0, 224), rgb(227, 227, 227));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 84%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(30, 115, 190);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.button:hover][background-color]" placeholder="" value="#1e73be"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 105.228px; top: 45.5312px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 41, 41), rgb(255, 148, 41), rgb(255, 255, 41), rgb(148, 255, 41), rgb(41, 255, 41), rgb(41, 255, 148), rgb(41, 255, 255), rgb(41, 148, 255), rgb(41, 41, 255), rgb(148, 41, 255), rgb(255, 41, 255), rgb(255, 41, 148), rgb(255, 41, 41));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 101, 189), rgb(191, 191, 191));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 84%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(238, 238, 34);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.button][color]" placeholder="" value="#eeee22"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 30.3542px; top: 12.7487px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 36, 36), rgb(255, 145, 36), rgb(255, 255, 36), rgb(145, 255, 36), rgb(36, 255, 36), rgb(36, 255, 145), rgb(36, 255, 255), rgb(36, 145, 255), rgb(36, 36, 255), rgb(145, 36, 255), rgb(255, 36, 255), rgb(255, 36, 145), rgb(255, 36, 36));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(235, 235, 0), rgb(237, 237, 237));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 86%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(30, 115, 190);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.button:hover][color]" placeholder="" value="#1e73be"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 105.228px; top: 45.5312px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 41, 41), rgb(255, 148, 41), rgb(255, 255, 41), rgb(148, 255, 41), rgb(41, 255, 41), rgb(41, 255, 148), rgb(41, 255, 255), rgb(41, 148, 255), rgb(41, 41, 255), rgb(148, 41, 255), rgb(255, 41, 255), rgb(255, 41, 148), rgb(255, 41, 41));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 101, 189), rgb(191, 191, 191));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 84%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(130, 36, 227);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.button][background-color]" placeholder="" value="#8224e3"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 136.594px; top: 20.0337px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 41, 41), rgb(255, 148, 41), rgb(255, 255, 41), rgb(148, 255, 41), rgb(41, 255, 41), rgb(41, 255, 148), rgb(41, 255, 255), rgb(41, 148, 255), rgb(41, 41, 255), rgb(148, 41, 255), rgb(255, 41, 255), rgb(255, 41, 148), rgb(255, 41, 41));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(112, 0, 224), rgb(227, 227, 227));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 84%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(221, 51, 51);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.wpt_woo_add_cart_button][background-color]" placeholder="" value="#dd3333"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 23.6762px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 56, 56), rgb(255, 156, 56), rgb(255, 255, 56), rgb(156, 255, 56), rgb(56, 255, 56), rgb(56, 255, 156), rgb(56, 255, 255), rgb(56, 156, 255), rgb(56, 56, 255), rgb(156, 56, 255), rgb(255, 56, 255), rgb(255, 56, 156), rgb(255, 56, 56));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(219, 0, 0), rgb(222, 222, 222));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 77%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(129, 215, 66);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.wpt_woo_add_cart_button:hover][background-color]" placeholder="" value="#81d742"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 48.0608px; top: 29.14px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 77, 77), rgb(255, 166, 77), rgb(255, 255, 77), rgb(166, 255, 77), rgb(77, 255, 77), rgb(77, 255, 166), rgb(77, 255, 255), rgb(77, 166, 255), rgb(77, 77, 255), rgb(166, 77, 255), rgb(255, 77, 255), rgb(255, 77, 166), rgb(255, 77, 77));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(89, 214, 0), rgb(214, 214, 214));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 69%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(30, 115, 190);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.wpt_woo_add_cart_button][color]" placeholder="" value="#1e73be"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 105.228px; top: 45.5312px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 41, 41), rgb(255, 148, 41), rgb(255, 255, 41), rgb(148, 255, 41), rgb(41, 255, 41), rgb(41, 255, 148), rgb(41, 255, 255), rgb(41, 148, 255), rgb(41, 41, 255), rgb(148, 41, 255), rgb(255, 41, 255), rgb(255, 41, 148), rgb(255, 41, 41));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 101, 189), rgb(191, 191, 191));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 84%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(129, 215, 66);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.wpt_table_pagination a.page-numbers.current][background-color]" placeholder="" value="#81d742"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 48.0608px; top: 29.14px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 77, 77), rgb(255, 166, 77), rgb(255, 255, 77), rgb(166, 255, 77), rgb(77, 255, 77), rgb(77, 255, 166), rgb(77, 255, 255), rgb(77, 166, 255), rgb(77, 77, 255), rgb(166, 77, 255), rgb(255, 77, 255), rgb(255, 77, 166), rgb(255, 77, 77));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(89, 214, 0), rgb(214, 214, 214));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 69%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(30, 115, 190);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.wpt_table_pagination a:hover][background-color]" placeholder="" value="#1e73be"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 105.228px; top: 45.5312px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 41, 41), rgb(255, 148, 41), rgb(255, 255, 41), rgb(148, 255, 41), rgb(41, 255, 41), rgb(41, 255, 148), rgb(41, 255, 255), rgb(41, 148, 255), rgb(41, 41, 255), rgb(148, 41, 255), rgb(255, 41, 255), rgb(255, 41, 148), rgb(255, 41, 41));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 101, 189), rgb(191, 191, 191));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 84%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(130, 36, 227);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.wpt_tspan.page-numbers.current, a.page-numbers.current][border-color]" placeholder="" value="#8224e3"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 136.594px; top: 20.0337px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 41, 41), rgb(255, 148, 41), rgb(255, 255, 41), rgb(148, 255, 41), rgb(41, 255, 41), rgb(41, 255, 148), rgb(41, 255, 255), rgb(41, 148, 255), rgb(41, 41, 255), rgb(148, 41, 255), rgb(255, 41, 255), rgb(255, 41, 148), rgb(255, 41, 41));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(112, 0, 224), rgb(227, 227, 227));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 84%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(221, 51, 51);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.page-numbers, span.page-numbers][color]" placeholder="" value="#dd3333"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 23.6762px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 56, 56), rgb(255, 156, 56), rgb(255, 255, 56), rgb(156, 255, 56), rgb(56, 255, 56), rgb(56, 255, 156), rgb(56, 255, 255), rgb(56, 156, 255), rgb(56, 56, 255), rgb(156, 56, 255), rgb(255, 56, 255), rgb(255, 56, 156), rgb(255, 56, 56));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(219, 0, 0), rgb(222, 222, 222));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 77%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(26, 69, 147);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.wpt_tspan.page-numbers.current, a.page-numbers.current][color]" placeholder="" value="#1a4593"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 110.793px; top: 76.4925px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 46, 46), rgb(255, 150, 46), rgb(255, 255, 46), rgb(150, 255, 46), rgb(46, 255, 46), rgb(46, 255, 150), rgb(46, 255, 255), rgb(46, 150, 255), rgb(46, 46, 255), rgb(150, 46, 255), rgb(255, 46, 255), rgb(255, 46, 150), rgb(255, 46, 46));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 52, 148), rgb(148, 148, 148));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 82%;"></span></div>
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
                            <option value="100%">100%</option>
                        </select>


                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label>Keywords Field Alignment </label>
                    </th>
                    <td>
                        <select class="ua-select " name="table_style[.wpt_search_box .search_single .search_single_column][width]">
                            <option value="">Blank (Default)</option>
                            <option value="left">Left</option>
                            <option value="none" selected="">None</option>
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

                        <input class="regular-text " type="text" name="table_style[a.wpt_product_title_in_td][font-size]" placeholder="" value="15px">


                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label>Product Title Text Align </label>
                    </th>
                    <td>

                        <input class="regular-text " type="text" name="table_style[a.wpt_product_title_in_td][text-align]" placeholder="" value="right">


                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label>Product Title Font weight </label>
                    </th>
                    <td>

                        <input class="regular-text " type="text" name="table_style[a.wpt_product_title_in_td][font-weight]" placeholder="" value="bold">


                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label>Product Title Color </label>
                    </th>
                    <td>

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(129, 215, 66);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.wpt_product_title_in_td][color]" placeholder="" value="#81d742"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 48.0608px; top: 29.14px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 77, 77), rgb(255, 166, 77), rgb(255, 255, 77), rgb(166, 255, 77), rgb(77, 255, 77), rgb(77, 255, 166), rgb(77, 255, 255), rgb(77, 166, 255), rgb(77, 77, 255), rgb(166, 77, 255), rgb(255, 77, 255), rgb(255, 77, 166), rgb(255, 77, 77));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(89, 214, 0), rgb(214, 214, 214));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 69%;"></span></div>
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

                        <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(221, 153, 51);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[a.wpt_product_title_in_td:hover][color]" placeholder="" value="#dd9933"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                            <div class="wp-picker-holder">
                                <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                    <div class="iris-picker-inner">
                                        <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 18.2125px; top: 23.6762px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                            <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 56, 56), rgb(255, 156, 56), rgb(255, 255, 56), rgb(156, 255, 56), rgb(56, 255, 56), rgb(56, 255, 156), rgb(56, 255, 255), rgb(56, 156, 255), rgb(56, 56, 255), rgb(156, 56, 255), rgb(255, 56, 255), rgb(255, 56, 156), rgb(255, 56, 56));"></div>
                                            <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                        </div>
                                        <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(219, 132, 0), rgb(222, 222, 222));">
                                            <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 77%;"></span></div>
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

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(99, 99, 99);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[td.td_or_cell .amount][color]" placeholder="" value="#636363"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 111.096px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(97, 0, 0), rgb(99, 99, 99));">
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

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(234, 22, 249);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[td.td_or_cell .amount:hover][color]" placeholder="" value="#ea16f9"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 149.747px; top: 3.6425px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 20, 20), rgb(255, 138, 20), rgb(255, 255, 20), rgb(138, 255, 20), rgb(20, 255, 20), rgb(20, 255, 138), rgb(20, 255, 255), rgb(20, 138, 255), rgb(20, 20, 255), rgb(138, 20, 255), rgb(255, 20, 255), rgb(255, 20, 138), rgb(255, 20, 20));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(233, 0, 250), rgb(250, 250, 250));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 91%;"></span></div>
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

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(221, 51, 51);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[td.td_or_cell .amount .woocommerce-Price-currencySymbol][color]" placeholder="" value="#dd3333"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 23.6762px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 56, 56), rgb(255, 156, 56), rgb(255, 255, 56), rgb(156, 255, 56), rgb(56, 255, 56), rgb(56, 255, 156), rgb(56, 255, 255), rgb(56, 156, 255), rgb(56, 56, 255), rgb(156, 56, 255), rgb(255, 56, 255), rgb(255, 56, 156), rgb(255, 56, 56));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(219, 0, 0), rgb(222, 222, 222));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 77%;"></span></div>
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

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(178, 178, 178);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[.all_check_footer][background-color]" placeholder="" value="#b2b2b2"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 54.6375px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(179, 0, 0), rgb(179, 179, 179));">
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

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(129, 215, 66);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[div.wpt_notice_board div.woocommerce-message][background-color]" placeholder="" value="#81d742"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 48.0608px; top: 29.14px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 77, 77), rgb(255, 166, 77), rgb(255, 255, 77), rgb(166, 255, 77), rgb(77, 255, 77), rgb(77, 255, 166), rgb(77, 255, 255), rgb(77, 166, 255), rgb(77, 77, 255), rgb(166, 77, 255), rgb(255, 77, 255), rgb(255, 77, 166), rgb(255, 77, 77));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(89, 214, 0), rgb(214, 214, 214));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 69%;"></span></div>
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

                            <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(255, 17, 81);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input class="regular-text wpt_color_picker wp-color-picker" type="text" name="table_style[div.wpt_notice_board div.woocommerce-message][color]" placeholder="" value="#ff1151"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span>
                                <div class="wp-picker-holder">
                                    <div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
                                        <div class="iris-picker-inner">
                                            <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 174.031px; top: 0px;"><span class="iris-square-handle ui-slider-handle"></span></a>
                                                <div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 15, 15), rgb(255, 135, 15), rgb(255, 255, 15), rgb(135, 255, 15), rgb(15, 255, 15), rgb(15, 255, 135), rgb(15, 255, 255), rgb(15, 135, 255), rgb(15, 15, 255), rgb(135, 15, 255), rgb(255, 15, 255), rgb(255, 15, 135), rgb(255, 15, 15));"></div>
                                                <div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div>
                                            </div>
                                            <div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(255, 0, 68), rgb(255, 255, 255));">
                                                <div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 93%;"></span></div>
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