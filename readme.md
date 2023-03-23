![Product Table for WooCommerce](https://raw.githubusercontent.com/codersaiful/woo-product-table/master/assets/images/wpt-logo.png)

# Product Table for WooCommerce by [CodeAstrology](https://codeastrology.com/)
Product Table for WooCommerce has Tiny Shortcode. Easy to use and No need programming knowledge to use. Easily able to handle by Graphical User Interface. Just like following:
```[Product_Table id='123']```
Download from [Plugin in WordPress.org](https://wordpress.org/plugins/woo-product-table/)


## Features
- Within a minute, User able to make a table and using shortcode, able to display anywhere
- Most popular and Fastest
- Developer Friendly - Available lots of Filter and Action Hook
- Support all theme and plugin
- Displaying product list as table within a minute.
- So many lots of features [Read More](https://wooproducttable.com/)

# How to Contribute?
As **[Woo Product Table](https://wordpress.org/plugins/woo-product-table/)**(Product Table for WooCommerce by CodeAstrology) Plugin is a WooCommerce Plugin of WordPress. So Need first WordPress then WooCommerce. 
And there are lot's of Action and Filter hooks available in our Plugin by these hooks, Use able to make Addon of **Woo Product Table**. You also can create custom Hooks, when you will contribute to our plugin.  Now I will explain step, how can contribute to our plugin. 

Check following steps:
- Install WordPress to your localhost. It can be [WAMP](https://www.wampserver.com/en/), [XAMP](https://www.apachefriends.org/) etc. Although I prefer **XAMP**. You can use any one.
- Install [WooCommerce](https://wordpress.org/plugins/woocommerce/) Plugin to your WordPress Site.
- Activate WooCommerce Plugin and import some product. Sample Product available in "WooCommerce" Plugins folder. sample directory `C:\wamp64\www\{wordpress-site}\wp-content\plugins\woocommerce\sample-data\sample_products.csv`. Check [How to import](https://woocommerce.com/document/product-csv-importer-exporter/).
- Clone `woo-product-table` repository to your Plugins directory. Repository [Clone Tutorial](https://docs.github.com/en/repositories/creating-and-managing-repositories/cloning-a-repository).
  - Go to `plugins` like `C:\wamp64\www\{wordpress-site}\wp-content\plugins` 
  - open comand tool. such as Git Bash. A screenshot:<br>
  ![image](https://user-images.githubusercontent.com/6463919/197454363-660a92ee-d9f1-45f3-8869-21546fd30084.png)
  - write `git clone https://github.com/codersaiful/woo-product-table.git` And press ENTER.
  - I recommend you to pull latest branch but you can pull master branch also AND *Obviously create new branch from this branch with your name/username etc*.
  - After fix, push. We will check and merge.
  - RECOMMENDED: Everytime pull latest version.
- Now open your Localhost WordPress site's code via any code Editor. like [VS Code](https://code.visualstudio.com/), [Netbeans](https://netbeans.apache.org/) etc.
- I strongly recommend to open your main WordPress CMS folder via CODE EDITOR. Your site's probable directory is: `C:\wamp64\www\{wordpress-site}`.
- **Woo Product Table** plugin directory is: `C:\wamp64\www\{wordpress-site}\wp-content\plugins\woo-product-table`
- Go to Dashboard -> Plugins and Activate **Product Table Plugin for WooCommerce by CodeAstrology*
- Check all functionality and Findout issue. Or Making a new **Features** for Product Table Plugins.
- Creating a table: Dashboard -> Product Table -> Add New -> put name, set some columns and **Publish** Post. Then copy that shortcode and Paste to your desired page.
- Create a new issue on this ripository and add Label `hacktoberfest`, `good first issue`, `hacktobarfest2022` and `codeastrology`

- Finally You will get a Product table. Like following screenshot:<br>
![image](https://user-images.githubusercontent.com/6463919/197455840-0e78c4f2-ad2e-4e48-aba7-a9ae76f231fc.png)


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

### Available Variable in item file. 
such: woo-product-table/includes/items/xxxx.php
see a method of `\WOO_PRODUCT_TABLE\Inc\Table\Row` class.

```php
private function data_for_extract(){
        $serial = ( ($this->page_number - 1) * $this->posts_per_page ) + $this->serial_number;
        
        $this->avialable_variables = [
            'id' => $this->product_id,
            'args' => $this->args,
            'table_type' => $this->table_type,
            'product_type' => $this->product_type,
            'temp_number' => $this->table_id,
            'table_ID' => $this->table_id,
            'data' => $this->product_data,
            'config_value' => $this->table_config,
            'column_settings' => $this->column_settings,
            'column_array' => $this->column_array,
            'checkbox' =>  $this->checkbox,
            'table_column_keywords' => $this->_enable_cols,
            'ajax_action' => $this->ajax_action,
            'add_to_cart_text' => $this->add_to_cart_text,
            'default_quantity' => $this->default_quantity,
            'stock_status' => $this->product_stock_status,
            'stock_status_class' => $this->product_stock_status_class,
    
            'description_type' => $this->description_type,
            '_device' => $this->_device,
            //For Variable Product
            'attributes' => $this->attributes,
            'available_variations' => $this->available_variations,
            'variable_for_total' => $this->variable_for_total,
    
    
            'row_class' => $this->row_class,
            'wpt_table_row_serial' => $serial,
        ];

        return $this->apply_filter( 'wpt_avialable_variables', $this->avialable_variables );
    }
```
actually we have extract($this->avialable_variables). means: you will get all these array key as variable inside items file.
suppose:
```php
echo $id;
```

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
add_filter( 'wpto_template_loc_item_{new_shortcode}', 'temp_file_for_new_shortcode', 10 );
```
Here {new_shortcode} is column's keyword. it's dynamic and changeable based on your column name/keyword.

## Example File code(my_shortcode.php)
```php
/**
 * //Some Available Variation over there:
 * $keyword, 
 * $table_ID, 
 * $settings, 
 * $column_settings, 
 * $product
 * $id (here id is product id)
 */  

//Such: an example
$product_id = $id;

echo get_post_meta( $product_id, 'discount_custom_field', true );

//Do here, what u want

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
