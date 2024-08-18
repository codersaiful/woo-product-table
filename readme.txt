=== Product Table for WooCommerce by CodeAstrology (wooproducttable.com) ===
Contributors: codersaiful,mdibrahimk48,ultraaddons,unikforce,rafiul17,fazlebari
Donate link: https://donate.stripe.com/4gw2bB2Pzdjd8mYfYZ
Tags: wc product table, woo table, woo product table,woocommerce product table, product table
Requires at least: 4.0.0
Tested up to: 6.5.5
Stable tag: 3.5.0
Requires PHP: 5.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Helps you to display your products in a searchable table layout with filters.

== Description ==
(**Woo Product Table**) Product Table plugin helps you to display your WooCommerce products in a searchable table layout with filters.  Add a table on any page or post via a shortcode. You can create tables as many as you want.
Create a table for restaurant order systems, Online music sell, product Wholesale, Course Booking, or Selling books any many more.

**Have a looks in short for WooCommerce Product Table**

https://www.youtube.com/watch?v=jZ9bx4VqB08

**How to Create a WooCommerce Product Table**

https://www.youtube.com/watch?v=yPjFmCHn36Y

**Shortcode Example**

`[Product_Table ID='123' name='Table Name']`

*ID* - will be post's ID(required).It will generate automatically when you create your table. 
*name* - only for identifying your table's shortcode.(Optional)

**[Visit Official Site](https://wooproducttable.com/#discount)**

👣 [List of Woo Product Table Plugin Features](https://wooproducttable.com/doc/gating-start/woo-product-table-plugin-features/)
🔅 [How to create a WooCommerce Product Table?](https://wooproducttable.com/doc/gating-start/how-to-create-woocommerce-product-table/)
🔅 [How to show product attributes in a different column and search box?](https://wooproducttable.com/doc/search-and-filter/show-product-attributes-in-different-column-and-search-box/)
🔅 [How to sort products using tags or custom taxonomy?](https://wooproducttable.com/doc/search-and-filter/how-to-sort-products-using-tags-or-custom-taxonomy/)
🔅 [How to display Table On Specific Archive page](https://wooproducttable.com/doc/table-options/display-table-on-specific-archive-page-category-tag-attribute-page/)
🔅 [How to create an Online Book Store using Woo Product Table?](https://wooproducttable.com/doc/tutorials/create-an-online-book-store-using-woo-product-table/)
🔅 [How to Add Custom Column Using Action and Filter Hooks?](https://wooproducttable.com/doc/advance-uses/how-to-add-custom-column-using-action-and-filter-hooks/)

**Demo table list** 

* [Advanced Search Table](https://demo.wooproducttable.com/demo-list/clean-blue-table-with-advanced-search/) <br>Our most valuable feature is search & filter. Customers can filter products by any taxonomy or attribute like products categories, tags, color, or size. Also can filter by any custom field data. Have an option to search from specific areas.

* [A table on Single Variable Product Page](https://demo.wooproducttable.com/product/samsung-galaxy/) <br>If you select a table and enable 'Variation Table' then it will replace the default variation dropdown select options and will display that table on every variable product page.

* [A table on an archive page.](https://demo.wooproducttable.com/shop/) <br>You can override the default archive page and display our table.  (Please note Product table will display products according to the WooCommerce default query and the Advance Search box is not available on the Archive page.)

* [Product Variant In Separate Row](https://demo.wooproducttable.com/product-variant-in-separate-row/) <br>If you have variable products and you want to show every variation as a single product, this table is like that. 


* [Filter By Custom Field](https://demo.wooproducttable.com/filter-by-custom-field/) <br>Here you can filter products by custom filed. This will give you the freedom to filter products by any keyword.

* [Quick Order Table](https://demo.wooproducttable.com/quick-cart-update-quick-order-table/) <br>This is a special table. If you want to add a product to the cart just increase the quantity. The product will automatically add to the cart.

* [User Conditional Table](https://demo.wooproducttable.com/demo-list/user-conditional-table/) <br>Hide any column for Guest users. Users only can see some columns if they are logged in. 

* [Attributes in Different Column](https://demo.wooproducttable.com/demo-list/product-attributes-in-different-column-and-search-box/) <br>You can show product Attributes in a different column as well as in the Search Box.

* [Redirect to checkout/cart page](Redirect to checkout/cart page) <br>On this table, if a customer adds a product to the cart then will atomically redirect to the cart/check out page.

* [Restaurant Table](https://demo.wooproducttable.com/restaurant-table-two/) <br>This table is made for a restaurant. Users will easily order products from the table.

* [Mobile Wholesale](https://demo.wooproducttable.com/mobile-wholesale/) <br>Create a table to sell mobile. Show products specifications using our description column.

* [Audio Player Table](https://demo.wooproducttable.com/demo-list/audio-player-table/) <br>This is an audio table. User paly audio from the table.

* [Online Music Sale](https://demo.wooproducttable.com/demo-list/online-music-sale/) <br>Create a table to sell your music. Users also can listen to demo audio.  

* [Books Table](https://demo.wooproducttable.com/books-table-with-custom-link/) <br>Sell your books with the help of a table and increase user engagement.

* [Course Booking Table](https://demo.wooproducttable.com/course/) <br>Create a table for selling online courses. Users can book any course to learn about their interests. 

* [Quotation Table](https://demo.wooproducttable.com/demo-list/send-your-quotation/) <br>Users can send quotations using our plugin. Here is the demo table for that.


Please Visit our demo site to see all our demo tables. [All Demo](https://demo.wooproducttable.com/) 

**Customization of Table Data**
Using filter hook, User able to change any TD data, using filter hook.<br>
Example Code:<br>

`add_filter('wpt_td_content', function($content, $Row, $column_key){
  //$product_id = $Row->product_id;
  //$product_id = $Row->td_keyword;
  //var_dump($Row); //Checkout to get all others property of this $Row object.
  if($column_key == '_price'){
      $content = "BDT $content" . ' taka';
  }
  return $content;
}, 10, 3);`

[Filter and Action Hook list](https://wooproducttable.com/plugin-api/) 

** 🏆Product Table Has Received 5 (⭐⭐⭐⭐⭐ ) Reviews. Let's See What Our Users Said:**

🎉 Easy to Install and Configure – Great Support.<br>
🎉 Best Product Table is a great plugin for WooCommerce.<br>
🎉 Excellent plugin for wholesale stores.<br>
🎉 Great Plugin with Loads of features<br>
🎉 It is simple to use and has a lot of future for free.<br>

**🥇🥇🥇 Success Stories of People We Are Proud to Know :**<br>
👨 I just want to thank Code Astrology for helping me,set up the table and everything for the website. It looks really good. They've actually done some custom coding for me as well. And just all throughout the process of getting it sorted,it was easy. I could contact them with the tickets,and yeah,it worked really well. So thank you very much.<br>
  — Alex K. O., Founder of KO Welding Pty Ltd.

https://www.youtube.com/shorts/Qq8Ck8yqQ5U

<h2>Our Main Features</h2>

**WPML/Loco Translate/Multi Language**<br>
Totally supported with WPML or any other Local language supported. here can use any plugin of multi language.

**Drag and Drop**<br>
We have a rich column list. Such as product Title, Attributes, thumbnails, quantity, short message, variation, and many more. Users can show or hide multiple columns with one click. Also easily can Change position by drag and drop. 

**Design Customizable**<br>
We have some pre-built design templates. You can switch between design templates to change table design. On the other hand, you can design pretty much table’s every section as you want. For example table header, footer, body. You can design each column individually also. 

**Advance Filter (Taxonomy/cf/title)**<br>
Our most valuable feature is search & filter. Customers can filter products by any taxonomy or attribute like products categories, tags, color, or size. Also can filter by any custom field data. Have an option to search from specific areas. ( Only from SKU or price ).  Also, you can use a mini-filter that filters only current page products.

**Override Archive page**<br>
This is an awesome feature of our plugin. you can display your table on your archive pages.
You can display a table on every archive page or you can choose some specific archive pages to display specific tables. All you have to do is, select and turn on the table for archive pages. 

**Variation Table for Variable Product**<br>
Automatically or Manually show all variation as a table for Variable product. See: [Example 1](https://demo.wooproducttable.com/product/samsung-galaxy/), [Example 2](https://demo.wooproducttable.com/product-variation-table-with-product-details/), [Example 3](https://demo.wooproducttable.com/show-variation-name-in-a-single-column/)

**Quick Cart Update**<br>
Add a product to the cart, you don’t have to click any button anymore. You just need to update the quantity and that product will automatically add to the cart. The cart will auto-update by Increasing or decreasing quantity.

**Dozens of Integration**<br>
We have integrated our plugin with the necessary plugins. By default, it supports most of the plugins. On the other hand, you can turn on our third-party plugin support feature to make them work with our plugin.  

**Export & Import**<br>
This is an important feature of our table. You can easily create a table as it is shown on our demo site by importing that table’s encoded code. Also can export your table data as well. 

**Export & Import**<br>
Graphical Stock Status showing. Enable by on off button easily.

**Developer Friendly**<br>
We provide our plugin’s complete control to the developers. You can pass query arguments by shortcode attributes. We have tons of action and filter hooks, so you have the power to customize any of our plugin functionality.


*Get help from our [documentation](https://wooproducttable.com/documentation/).*

👉 [See Our Official GitHub Page Here](https://github.com/codersaiful/woo-product-table)

Our [YouTube Playlist](https://www.youtube.com/channel/UCnrFzReNAohkHglbF91ZEYA/playlists).

**Important feature ( Pro and Free )**

* WPML/Loco Translate/Multi Languag
* Product Table to any page and where using shortcode.
* Advance Search and filter option - Search from whole site
* Multi-level Query to show product as table. such as: Category, taxonomy, tag, menu-order, price limit. Anything.
* No need code edit knowledge
* Table template feature 
* Variation Table for Variable Product
* Show custom field in table
* Filter with custom field
* Product search by sku 
* Product filter by sku 
* WooCommerce Product Table
* Quick Order Table
* WooCommerce Shop page as Table
* WooCommerce Archive as Table
* WooCommerce Cateogry as Table
* WooCommerce Tag as Table
* WooCommerce Taxonomy as Table
* Any type customization possible by Existing [Filter and Action hook](https://wooproducttable.com/plugin-api/).
* Add custom column
* Design columns individually 
* Columns only for login user
* Show multiple inner items
* Create A Variation Product Table
* Table On Variation Product Page 
* Show Variation Label
* Include/Exclude  Products
* Include/Exclude Categories
* Show or Hide Mini Cart
* Customizable floating cart
* Instant Search Filter
* Display Limited Products
* Load More Button
* Enable /Disable Pagination 
* Customizable Add To Cart Button
* Pre-Select Product Option
* Product Sorting by values 
* Showing Popup Notices
* Redirect to Checkout Page
* WC Product Table Lite
* woo product table

💥💥💥 [Checkout Which Features Are Free And Which Are Not.](https://wooproducttable.com/pricing/)

**🚩🚩🚩 list of Integration plugin**

* Addons - UltraAddons Elementor Lite
* Quantity Plus Minus Button for WooCommerce
* WooCommerce Min Max Quantity & Step Control
* WooCommerce Product Filter by WooBeWoo
* Elementor
* Advanced Custom Fields 
* YITH WOOCOMMERCE REQUEST A QUOTE
* Loco Translate
* YITH WooCommerce Quick View
* WOOF – Products Filter for WooCommerce
* YITH WooCommerce Wishlist

**Columns/Item Load from Theme/ChildTheme**
To get Item's Template From Active Theme, Use following Directory.
* `[YourTheme]/woo-product-table/items/[YourItemFileName].php`
Suppose: Item name is price, than location/directory from theme will be:
* `[YourTheme]/woo-product-table/items/price.php`

**MORE OPTIONS AND FLEXIBILITY IN CUSTOMIZING**<br>
When accompanied by a product table , you can design every section and every column as you want. You can design each column individually too. Not only that, you can display multiple inner items inside one column, like price, quantity, category, and many more.<br>
Columns can be easily changed by dragging and dropping. You can show or hide multiple columns with one click.<br>
Actions and filter hooks allow developers to change or add code without editing core files. They are used extensively throughout WordPress and WooCommerce and are very useful to you.<br>
👉 [Learn More](https://wooproducttable.com/doc/advance-uses/woo-product-table-hooks-actions-and-filters)  👈

**YOU HAVE THE POWER**<br>
With 31 predefined columns , you can use the Product Table in a way to control everything in your e-commerce. Shop Archive Override, Product Exclude/Include, Column Customization, Mini Cart, and controlling who can see your specific products on specific pages are just a few examples.<br>

**PRE BUILD TEMPLATE**<br>
There are over 16 different pre-made Product Table templates available, each of which gives a unique front-end experience. From that viewpoint, they have complete command and visibility. To make sure that customers can get the benefits of being in the product table, we have made sure that all of our templates are compatible with the front end.<br>
 
**FAST, SECURE AND EASY**<br>
With a Product Table Plugin, you can feel confident that your business processes will go quickly and easily. User-friendly and adaptable to all popular themes.<br>

**Translation**<br>

* French (Français) - fr_FR
* Bengali (বাংলা) - bn_BD
* German (Deutsch) - de_DE
* German formal ( Deutsch (Sie) ) - de_DE_formal
* Russian (Русский) - ru_RU
* Ukrainian(Українська) - uk
* Spanish(Español) - es_ES

**👷 HONORABLE CONTRIBUTOR - [GitHub](https://github.com/codersaiful/woo-product-table/graphs/contributors) 👷**<br>

* [codersaiful](https://github.com/codersaiful) (1600+ commits And Pro: 1000+ commits)
* [fazlebarisn](https://github.com/fazlebarisn) (100+ commits And Pro: 70+ commits)
* [unikforceit](https://github.com/unikforceit) (42 commits )
* [fatimakhatungit](https://github.com/fatimakhatungit) (38 commits )
* [rafiul](https://github.com/rafiul) (29 commits )
* [mdibrahimk48](https://github.com/mdibrahimk48) (10 commits )
* [tanyabouman](https://github.com/tanyabouman) (4 commits )
* [zbandhan](https://github.com/zbandhan) (1 commits )
* 👉 [You can join here](https://github.com/codersaiful/woo-product-table/fork)

**🥇 CONTRIBUTE 🥇**<br>
You are welcome to contribute  to this project. Join with us [Fork Github repository](https://github.com/codersaiful/woo-product-table/fork).


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/woo-product-table` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to Dashboard -> Product Table -> Add New -> Publsih Post 
4. Copy the shortcode from Publsihed post and Paste to your desired Page or any where. AND Enjoy Woo Product Table.
5. From Dashboard -> Product Table -> Edit Table - You will get lot's of setting. Such: Column setting, Query setting, Search Box Setting etc.
6. Use the PRODUCT TABLE -> Configure screen to configure the plugin's default setting. There are lot's of feature and Setting available over there.


== Frequently Asked Questions ==

= Menu Location =

Dashboard -> Product Table -> Add New (Product Table or Shortcode). And paste your shortcode to desired page.

= Why Product Table for WooCommerce? =

To see your all products as a table in a page by shortcode.User friendly interface with easy options.If you want to increase user engagement in your site then it's the best solution.

= What is default Shortcode? =

Default Shortcode is [Product_Table id='123' name='Home Table'] as well as also able to change. Go to Product Table page from dashboard.

= Can I set product limitation to show in one table? =

Yes. You can set the product limit to show in you able. Eg. You have 100 products in your site then you can easily show 50 of them.

= How to use? =

Install and activate. Then go to ( Dashboard -> Product Table-> Add New ). Give a suitable name of your table. Configure your table according to your need and click publish. Finally, copy the shortcode and paste it to your desired page or post.
That's it. So easy, Right !!!

= How to show specific Category products ? =

You can easily show specific category products. While creating new table click on the basic tab. You will find an option to select your category. You can also choose multiple categories.


= Is it suitable for any theme ? =
 Yes. *Product Table for WooCommerce* will adapt with your theme design.

= Configuration data is not saving for old table. How can I fix it. =
 Please follow the link https://stackoverflow.com/questions/10303714/php-max-input-vars#answer-14166562


== Screenshots ==

1. Enabled table columns by checking the boxes
2. Show/Hide columns on mobile and tablet devices
3. Drag-n-drop ordering system for column's inners items
4. WooCommerce Product Table with inner column items
5. Restaurant menu with inner column items
6. WooCommerce Product Table with top mini cart
7. Enable/Disable columns by checking the boxes
8. Basic query on table
9. Set different types of conditions here
10. Advanced search box with search from
11. Add new custom taxonomy column 
12. WooCommerce Product Table with pagination
13. Clean WooCommerce Product Table
14. Duplicate product table
15. Popup notification
16. Lots of popup notification
17. WooCommerce product table with instant search
18. WooCommerce default product image popup
19. WooCommerce default product image popup
20. Popup notification
21. WooCommerce product table with Mini Filter
22. Advanced Search Box
23. WooCommerce product table with Mini Cart
24. Auto Selected Checked Table – Automatically All Item Selected
25. Manually responsive for mobile devices

== Changelog ==

= 3.5.0 =
* Fixed: Quote Request premium version issue fixed.
* Fixed: variation title issue fixed.
* Bug fixed 
* Code Optimized

= 3.4.9 =
* Fixed: YITH qutoe request button quantity issue solved.
* Variation List showing on Shop Page for Variable product issue has been fixed
* Fixed: last-active-tab issue has been fixed.
* Fixed: variation default image issue has been fixed.
* Bug fixed 
* Code Optimized

= 3.4.8 =
* Bug fixed 
* Code Optimized

= 3.4.7 =
* Fixed: added to cart block notice text color issue fixed.
* Fixed: pagination issue for some specific theme has been fixed. 
* Added: New filter hook added for Table Row and inner Item. hook: `wpt_td_content`.
* Added: New filter hook added for Inner Item. hook: `wpt_item_content`.
* Fixed: Search Result has been fixed based on 'relevance'.
* Fixed: Sorting Icon fixed and updated to latest icon.
* Added: Displaying table without atts - feature added. It's actually for sample table.
* Bug fixed 
* Code Optimized

= 3.4.6 =
* Fixed: Asc/Desc icon fixed (Table Title)
* Fixed: additional_json issue on all selected item add has been fixed.
* Admin area organized and Optimized.
* Removed: Black Friday offer notice has been removed.

= 3.4.5 =
* Added: new filter hook for description colun has been added. `wpto_product_description` filter added. [Code Example](https://gist.github.com/codersaiful/6053bf6b2160b90144fef9748ef28e5c)
* Fixed: JavaScript confliction issue fixed.
* Bug fixed 
* Code Optimized

= 3.4.4 =
* Added: new column/item added name: Buy Link.
* Compatibility: Compabile with HPOS.
* Bug Fixed.

= 3.4.3 =
* Speed optimized for product table using shortcode.
* Plugin init loaded on 'plugins_loaded' hook
* Fixed: sku search issue fixed for variable and variation product.
* Fixed: conditional checkbox and conditional Add to cart button - issue fix for All to cart all selected.
* Bug fixed 
* Code Optimized

= 3.4.2 =
* Added: new filter hook `wpt_subtotal_text` added for Subtotal text of footer cart.
* Added: Footer added sub total and line total with class markup, so that user can easily handle.
* Added: Live Chatbox Disable button/Option added 
* Improved: Dashboard/Backend Design improvement.
* Fixed: SKU changed for variation product when selected 3rd Party plugin supported - issue fixed.
* Fixed: variation default price issue solve
* Fixed: on mini filter trigger, hide pagination.
* Fixed: on mini filter trigger, added not found message, if not found any product. 
* optimize custom css loading

= 3.4.1 =
* Notice removed 
* Code Optimized

= 3.4.0 =
* Fixed: wpml issue fixed when not select any taxonomy on query. 
* Bug Fixed 
* Code Optimized

= 3.3.9 =
* Bug Fixed 
* Code Optimized

= 3.3.8 =
* Fixed the issue: 'Deprecated: Required parameter $parent_keyword follows optional parameter $items'
* `wpt_fragents_loaded` js trigger added when fragment will be load.
* query_by_url issue has been solved.
* variation,tag,category,taxonomy column is available for variation column. (Some Pro Feature)
* Fixed: Table Head sorting issue on variable product - has been solved
* Fixed: Total column issue on Variable product has been solved.
* Code Optimized

= 3.3.7 =
* select2 issue has been solved
* Code Optimized
* Bug fixed
* New feature (Variable Product Exclude include) - Pro feature
* Audio issue has been solved - Pro Feature

= 3.3.6 =
* Added: Now free version is compatible with [WeDevs_Dokan](https://wooproducttable.com/combability-list/) plugin.
* New language added - Croatian
* Diaplay column label in mobile issue solved
* Added: Polish Translated file added for frontend. Piotr helped us to translate Polish Language.
* remove trigger - removed_from_cart
* Add Collapse/Expand option on Design and configure page
* Added: Ukrainian(Українська) translated file added for frontend.
* Added: Spanish(Español) translated file added for frontend helped by *Lucas*.

= 3.3.5 =
* Fixed: Spelling issue solved. Helped by [tanyabouman](https://github.com/tanyabouman) - his pull request [#254](https://github.com/codersaiful/woo-product-table/issues/254)
* Added: French (Français) Translated file added for frontend. Helped us [ozapp.app](https://ozapp.app/) to translate French Language.
* Added: Russian (Русский) Translated file added for frontend. Helped us [Vasiliy Kotov](https://www.linkedin.com/in/vasiliy-kotov-10542b47/) to translate Russian Language.
* Added: Bangla (বাংলা) translated file added for frontend.
* Added: German(Deutsch) translated file added for frontend.
* Added: German formal ( Deutsch (Sie) ) translated file added for frontend.
* Bug Fixed 
* Code Optimized 
* Language File Upload


= 3.3.4 =
* Fixed: Only custom field search box issue solved
* New Filter Hook Added for footer cart.
* Added: Checkout page auto update
* Added: javascript event trigger: `update_checkout` of WooCommerce Added.
* Bug Fixed 
* Code Optimized 
* Language File Upload

= 3.3.2 and 3.3.3 =
* Load More disable not working - issue fixed.
* Advance Whole Search and normal search issue fixed.
* Infinite Scroll Added in Pro and Fixed issue.
* Action/Add to cart column flex wrap issue fixed when action column as inside item.
* Column Sorting issue when Audio player has been fixed.
* Input Box min quantity was 0, currently set 1 by default.
* Bug Fixed 
* shortcode-ajax.php optimized and organized

= 3.3.1 =
* Speed optimized.
* Bug Fixed 
* Search issue fixed.

= 3.3.0 =
* Fixed: Minicart image's issue solved.
* Fixed: Instance Search Issue fixed on new version.
* Bug Fixed.

= 3.3.0 =
* Fixed: All selected checkbox issue on pagination - has been solved.
* Fixed: Error: `Uncaught Error: Call to a member function get_id() on null` issue has been fixed. Help us [signosis](https://github.com/signosis) to findout that issue by creating a Github issue [#254](https://github.com/codersaiful/woo-product-table/issues/254).
* Fixed: Resave issue fixed.
* Fixed: Mini-filter issue 

= 3.2.7 =
* Ajax Save option fixed.
* Ajax add to cart event trigger fix

= 3.2.6 =
* Fixed: Product Exlude not working issue has solved.

= 3.2.5 =
* Added: Auto Responsive Handle/switch added from Edit Product Table -> Column Setting -> On/Off Switch
* Added: Table Statsbar message customizeable/Translateable from Option Tab.
* Fixed: Variable Table showing poistion issue has been fixed.
* Bug Fixed: tag or markup display on table issue fixed
* Column Sorting for each column
* Atractive and Modern responsive
* `New Minicart` added for Table.
* `text_with_number` sorting issue has been solved
* Added: Search from whole site option added for Advance Search Box.
* Added: Hide input of Advance search box option added.
* Fixed: Description column added using shortcode of wp.

= 3.2.4 =
* Bug Fixed: Icon/Font-Icon confliction issue has been solved.
* Bug Fixed: Pagination saving issue fixed
* Bug Fixed: Instance Search updated
* Changed: WPML area for Tab's String has transferred to Option Tab.
* Added: Live support service from plugin setting page.
* Added: Inside Item handle feature/ edit feature added like a modal.
* Added: Auto Responsive Label Issue has been solved
* Added: Quick Quantity enable on keyup
* Added: Total Price change on quick quantity Change on keyup.

= 3.2.3 =
  * Big Data not saving issue fixed
  * Data Form Saving Optimized
  * Bug Fix

= 3.2.2 =
  * Undefine post_status issue fixed of Table Preview page.
  * Class name issue fixed on Table preview page
  * Import Issue fixed
  * Big Data/Saving Optimized
  * Bug Fixed

= 3.2.1 =
  * Fixed: Soring issue solved for any number type content
  * Added: convert a column for numerical sorting. need to add class `text_with_number` for column 
  * Bug Fixed
  * Code Optimized

= 3.1.9 =
  * Fixed: Pagination on Advance Search issue has been solved.
  * Added: DataTable added as new features.
  * Changed: Dashboard Table Edit -> tab has been changed.
  * Fixed: pagination sorting issue fixed.
  * Added: wp force added for supporting other thirdparty plugin.
  * Fixed: checkbox issue for thirdparty Plugin support.
  * Fixed: Search Issue
  * Changed: By default Advance search enabled in Pro version.

= 3.1.8 =
  * New filter Added `wpto_search_box_basics` for search box of Advance
  * Search and Filter bug fixed andded advance features.
  * Empty Cart buttin fixed.
  * Fontello added. Some cutom icon added to our table.
  * Added Action_Hook wpt_load for staring product table anywhere.
  * Added Action_Hook wpt_after_table at the end product table anywhere.

= 3.1.7 =
  * Audio file issue fixed in table.

= 3.1.6 =
  * WPML Full Support
  * Advance Search's Dropdown Placeholder content change feature added from Configuration Page or Tab.
  * Bug Fix
  * More Theme Compatible fix.

= 3.1.5 =
  * Spelling fixed on some place.
  * Bug Fix

= 3.1.4 =
  * Spelling fixed on some place.
  * Bug Fix

= 3.1.3 =
  * Bug Fix

= 3.1.2 =
  * Fix: Save Change button issue fixed
  * Bug Fix

= 3.1.1 =
  * Fixed: thub variation and title variation not saving issue fixed
  * Fixed: Not showing product count on add to cart button for variation

= 3.1.0 =
 * Fixed: Data not saving issue fixed.
 * Fixed: PHP Notice - Undefined property: WC_Order_Item_Product::$legacy_values
 * New Feature: Advanced Action column Added
 * New Feature: Quantity Show on third party plugin support
 * New Feature: Total column works on third party plugin support
 * and many other small issue fixed based on customer feedback and suggestions.

= 3.0.9 =
 * Variation table position controller
 * Bug Fix

= 3.0.8 =
 * CSS issue solved
 * Bug Fix

= 3.0.7 =
 * Fixed: YITH Quote Request Premium button issue has been solved.
 * Fixed: Auto Responsive - column label show hide issue solved.
 * Fixed: Rating Notice issue solved.
 * CSS issue solved
 * Bug Fix

= 3.0.6 =
 * Fixed: Fullwidth table issue has been fixed.

= 3.0.5 =
 * New filter added for user rating option  `add_filter('wpto_user_rating_notice','__return_false');`
 * User Rating notice disable option in Configure Page. [Dashboard->Product Table -> Configure -> Disable Rating Notice]

= 3.0.4 =
 * custom field display issue for variable product

= 3.0.3 =
 * Fixed: Mini Filter issue (not showing all tag/taxonomy) has been fixed.

= 3.0.2 =
  * Variation Product include issue fix
  * Variable product query fix. based on terms. such: Product Category, Tag, Color, Size

= 3.0.1 =
  * Bug fix
  * Spelling fix

= 3.0.1 =
 * product_cat_ids confliction error solved for new user

= 3.0.0 =
 * array filter issue has solved
 * Elementor Minicart CSS issue has fixed
 * Variation's Change issue has solved

= 2.9.9 =
 * Variation's Change issue has solved

= 2.9.9 =
 * Bug fix (Undefined Array issue) in array_filter
 * recommended message updated

= 2.9.8 =
 * Advance Search for Variable Product
 * Integrate with sold indivisual 
 * UI Design Update for Admin panel

= 2.9.7 =
 * Search issue for Advance Search has been fixed

= 2.9.6 =
 * Fixed: YITH qutoe request premium button quantity issue solved.

= 2.9.5 =
 * Added: short description column as individual column.
 * Added: logn description column as individual column.
 * Fixed: Quote Request (premium version) has been fixed.

= 2.9.4 =
 * Fixed: Load Button on archvie page issue has been fixed.

= 2.9.3 =
 * Fixed: Shop page quantity issue
 * Fixed: After add to cart quantity issue
 * Fixed: Quote button issue
 * Fixed: YITH Quote button issue
 * Fixed: Short Message not sending issue
 * Fixed: Advance Search on latest verion
 * Added: Query by URL - on off from Configuraton page and tab
 * Bug Fix

= 2.9.1 =
 * escapping issue fixed

= 2.8.9 =
 * Name change to Product Table for WooCommerce

= 2.8.8 =
 * move icon and checkbox position at topside always
 * Priority Added PHP_INT_MAX Version: 2.8.8.0 date 12.5.2021
 * first-time-enabled class added for first time load element
 * Variation's stock message showing issue fixed
 * Documentation menu added in submenu
 * import box issue fixed
 * Description Hide on product column issue fixed
 * Ajax Save change issue fixed

= 2.8.7 =
 * Product Table Preview added
 * Export/Import Features Added

= 2.8.6 =
 * Illegal Offset issue fixed

= 2.8.5 =
 * Device wise column setting feature added

= 2.8.4 =
 * Fixed: Product not found issue solved
 * Fixed: ShortMessage send issue has fixe. To see short message field in single product. Use: `add_action( 'woocommerce_before_add_to_cart_quantity', 'wpt_add_custom_message_field' );`
 * Added: Taxonomy Relation Operation Added. eg: IN, AND

= 2.8.3 =
 * Fixed: Taxonomy hierarchy added.
 * Fixed: Short Message showing in order issue has fixed.
 * Fixed: add new column hook issue fixed.
 * Fixed: Bug Fix.

= 2.8.2 =
 * Fixed: Responsive Tab Issue fixed.

= 2.8.1 =
 * Fixed: Illegal offset issue, When creating new Table.

= 2.8.0 =
 * Updated: Quantity value return to min issue has fixed.
 * Added: Filter Added [wpto_qty_return_zero] support: true,false
 * Added: Filter Added [wpto_qty_return_quanity] support: true,false
 * Bug Fixed

= 2.7.9 =
 * Fixed: Responsive/Mobile Tab issue fixed
 * Fixed: admin body class issue fixed
 * Bug Fixed

= 2.7.8 =
 * Added: Column Tab - Update User Experience 
 * Fixed: Variation Issue for sorting
 * Fixed: return to min Quantity after Add to cart issue has fixed
 * Added: few message added for user experience on Backend.
 * Bug Fixed

= 2.7.7 =
 * Fixed: Checkbox click and scroll issue fixed 
 * Fixed: JavaScript Console Error issue fixed for 'variation_data.forEach is not a function'
 * Added: Add Class for TD tag based on Array Key and Value, When String value
 * Bug Fixed and some few new feature added.

= 2.7.6 =
* Fixed: Product Weight calculation issue fixed.
* Added: Elementor Widget Features Added.
* Fixed: Table on Product Page (Not showing product issue) has solved

= 2.7.5 =
* Fixed: Chrome Scrollbar Issue fixed.
* Added: Overflow Scrollbar Added at the top of the Table.
* Added: Action Hook 'wpto_action_before_table' added for just before table
* Added: Action Hook 'wpto_action_after_table' added for just after table

= 2.7.4 =
* New: a attribute on tr tag added for more customize feature from javascript
* New: js Trigger Event added on custom.js to control plugin from different addons plugin.

= 2.7.3 =
* New: Columns/Item's Template file load from Theme. Location: [YourTheme]/woo-product-table/items/[YourItemFileName].php
* New: A new Filter `wpto_item_final_loc` Added
* Doc's link Updated

= 2.7.2 =
* Fixed: Guest Purchase Issue Fixed

= 2.7.1 =
* Fixed: Plugin Permission Issue Fixed

= 2.7 =
* Fixed: Export Import Issue Fix
* Added: Lots of Filter Hooks
* Added: Lots of Action Hooks
* Added: Changable user permission
* Added: Freeze column start of table
* Added: Lots of new features
* Added: Manually enable/disable column for mobile and tablet
* Added: Plugin Recommendation on/off feature
* Added: Device Wise Different Column Feature
* Fixed: Jetpack Conflict/ Tab Conflict Issue
* Fixed: JavaScript Bug Fix
* Fixed: PHP Bug Fix


= 2.0 =
* Auto Responsive for Mobile
* Auto Responsive for Tab
* More Clean Design
* Bug Fix

= 1.9 =
* Fixed - javascript conflict issue of other cart plugin 
* custom field supported
* custom taxonomy supported
* Undefine index issue fixed for free version
* Pagination is free now
* Column Move added in Free

= 1.8 =
* YITH Quick View Added at Free
* Attribute Collumn Added at Free

= 1.7 =
* Many pro feature in free now.
* Translation issue fixed
* Different Configuration available for different table shortcode
* Bug Fix
* SSL issue fix for style and js file

= 1.6 =
* Bug Fix
* Supported with latest WooCommerce
* Supported with latest WordPress

= 1.6 =
* Removed old Shortcode
* Awesome Footer Cart Added
* Per product cart count and will update globally
* Cart quantity will display with per [Add to cart] button - for added item
* YITH Quote request Supported
* YITH Wishlist Supported
* YITH Quick View Supported
* Adding spin for loading - add to cart.
* Quote Request issue fix,
* js issue fixed,
* All text - Translateable 
* Old shortcode's feature has totally removed
* Added and Adding text removed from basic tab

= 1.5 =
* Easy shortcode System
* Table Manage by only one ID.
* Bug Fix

= 1.4 =
* Bug Fix
* Mobile Responsive
* Configure Page
* Column Move
* Ajax Add to cart
* So many pro feature in Free Version

= 1.3 =
* Shortcode Supporting in Custom Field.
* Default value issue fixed for Variation of product.
* Variations/Attribute in different column issue fixed.
* Now able to add Attributes as Individual Column.
* Popup Notice Enable/Disable Feature added.
* Cart Validation Message
* Compatible with all Min Max Plugin
* Removed default quantity from configuration page
* Code Optimized for better performance and speed.
* Load More button show/hide option
* Speed fast
* Advance search box's added default search order and order_by based on shortcode
* date and modied_date collumn added at Table
* Configure Page's design changed - So smart/so cool
* "On Back Order" available now in Table
* Mini cart update
* Advance Cart Update
* send 'add_to_cart','added_to_cart' event
* Configuration's value Reset option fix when plugin update
* Filter Text change option  of Filter
* Reset Button Text change option of Filter
* Thumbs image size issue fix
* Mini-cart Update automatically
* Fix Responsive Issue for TD's height
* Fix Responsive Issue for TD's width

= 1.2 =
* Bug Fix
* Stable with latest WooCommerce
* Stable with latest WordPress
* Ajax Add to cart
* Template for Table
* Quantity Bug fix

= 1.1 =
* Fix issue for no_woocommerce_fact.

= 1.0 =
* Just Start First version.