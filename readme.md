![Product Table for WooCommerce](https://raw.githubusercontent.com/codersaiful/woo-product-table/master/assets/images/wpt-logo.png)

# Product Table for WooCommerce - A WooCommerce Product Table Plugin
Product Table for WooCommerce has Tiny Shortcode. Easy to use and No need programming knowledge to use. Easily able to handle by Graphical User Interface. Just like following:
```[Product_Table id='123']```

## Features
- Withing a minute, User able to make a table and using shortcode, able to display anywhere
- Most popular and Fastest
- Developer Friendly - Available lots of Filter and Action Hook
- Support all theme and plugin
- Displaying product list as table within a minute.
- So many lots of features [Read More](https://wooproducttable.com/)

## Plugin in WordPress.org
https://wordpress.org/plugins/woo-product-table/

### Available Filter and Action Hooks List
https://docs.google.com/spreadsheets/d/1RwnzuupIYC-ao2R3_P3hZU__R-8nA3p7o2XoWWntNig/edit?usp=sharing

# Making a sample Addons
Here I will show, how a user can make a addon for **Product Table for WooCommerce** using our Hook. As example, I will show, how to add new column in our table.

### Using hooks
There are variety of ways to add your custom code to manipulate code by hooks:
- To a custom child theme’s functions.php file.
- Using a plugin such as [Code Snippets](https://wordpress.org/plugins/code-snippets/)

### Using action hooks
To execute your own code, you hook in by using the action hook ```do_action('action_name');```. Here is where to place your code:
```php
add_action( 'action_name', 'your_function_name' );

function your_function_name() {
// Your code
}
```
## Start Procedure of adding new Collumn
First we have to our custom column in default column array using ```wpto_default_column_arr``` filter.
```php
<?php
if( !function_exists( 'new_shortcode_column' ) ){
   function new_shortcode_column( $column_array ) {
       $column_array['new_shortcode'] = 'New Shortcode';
       return $column_array;
   }
}
add_filter( 'wpto_default_column_arr', 'new_shortcode_column' );
```
We have added our new shortcode column to default column array. Now we need a file where we can add the content for that custom shortcode.

Below we have used ```wpto_template_loc_item_ . $keyword``` filter.
```php
<?php
if( !function_exists( 'temp_file_for_new_shortcode' ) ){
    function temp_file_for_new_shortcode( $file ){
        //$file = __DIR__ . '/../file/my_shortcode.php';
        $file = $your_file_location;
        return $file;
    }
}
add_filter( 'wpto_template_loc_item_new_shortcode', 'temp_file_for_new_shortcode', 10 );
```

Now we need to add a input field for get the custom shortcode from user. here we have used ```wpto_column_setting_form_ . $keyword``` action to add the input field inside column area in column tab.
```php
<?php
function input_for_new_shortcode($_device_name, $column_settings){
    $text = isset( $column_settings['new_shortcode']['text'] ) ? $column_settings['new_shortcode']['text'] : false;
    ?>
<input class="ua_input" name="column_settings<?php echo esc_attr( $_device_name ); ?>[new_shortcode]" value="<?php echo esc_attr( $text ); ?>">
<?php 
}
add_action( 'wpto_column_setting_form_new_shortcode', 'input_for_new_shortcode', 10, 2 );
```
Now we have to show the shortcode content using our custom file. Here we create a file ```my_shortcode.php``` with following code.
```php
<?php
$my_shortcode = isset( $settings['text'] ) ? $settings['text'] : '';
 
echo do_shortcode( $settings['text'] );
```

How to Change Label text for URL Field and File Type Field of ACF. Use following Filter.
```php
<?php

function wpt_custom_extra_label_change( $label, $id ){
    $label = get_post_meta($id, 'my_custom_label', true);
    return $label;
}
add_filter( 'wpt_extra_label_text', 'wpt_custom_extra_label_change', 10, 2 );
```