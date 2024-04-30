jQuery.fn.extend({
    renameAttr: function( name, newName, removeData ) {
      var val;
      return this.each(function() {
        val = jQuery.attr( this, name );
        jQuery.attr( this, newName, val );
        jQuery.removeAttr( this, name );
        // remove original data
        if (removeData !== false){
          jQuery.removeData( this, name.replace('data-','') );
        }
      });
    }
});

(function($) {
    'use strict';
    $(document).ready(function() {
        if(! $('body').hasClass('wpt_admin_body')){
            return false;
        }
       
        $('body').on('keyup','.str_str_each_value',function(){

            wptUpdateStyleData(this);
        });
        
        $('span.wpt-help-icon').click(function(){
            // $('span.wpt-help-icon').removeClass('wpt-help-focused');
            $(this).toggleClass('wpt-help-focused');
        });

        //For select, used select2 addons of jquery
        //$('.wpt_wrap select,.wpt_shortcode_gen_panel select, select#wpt_product_ids,select#product_tag_ids').select2();
        
        function wptSelectItem(target, id) { // refactored this a bit, don't pay attention to this being a function
            var option = $(target).children('[value='+id+']');
            option.detach();
            $(target).append(option).change();
        }
        $('select#wpt_product_ids,select#product_tag_ids,select.wpt_select2').select2({
            placeholder: "Select Option",
            allowClear: true
        });

        
        /**
         * Hellping need link 
         * @link https://stackoverflow.com/questions/15636302/attach-click-event-to-element-in-select2-result
         * @link http://jsfiddle.net/6jaodjzq/
         * @link http://jsfiddle.net/sc147a1L/4/ (Worked)
         * @link 
         */
        $('select.internal_select').select2({
            placeholder: "Select mulitple inner Items.",
            allowClear: true,
            // escapeMarkup: function(m) { return m; },
            // templateResult:customizedItem,
            templateSelection:selectionWithEditLink,
            // templateSelection:customizedItem,


        });
        
        function selectionWithEditLink(state, container){
            if(undefined == state || undefined == container) return null;
            container.append($('<span class="selected-state"></span>').text(state.text));
            $('<a class="edit-my-column-easily" data-keyword="' + state.id + '"> Edit</i>')
                .appendTo(container)
                .mousedown(function(e) {
                    e.stopPropagation();            
                })
                .click(function(e) {
                    e.preventDefault();
                    var target = state.id;
                    var thisObject = $(this);
                    openTargetInsideItem( target, thisObject );
                });
        }

        /**
         * Unused function, I tried to use it for select2 element 
         * edit
         * 
         * @param {objec} item 
         * @returns 
         */

        function customizedItem(item){
            
            if (!item.id) { return item.text; }

            var output = '<span> ' + item.text + ' <a class="edit-my-column-easily" href="#' + item.id + '">Edit</a></span>';
            return $(output);
        }
        

        function openTargetInsideItem( target, thisObject ){
            
            let myTargetClass = 'inside-column-enabled';
            var parentUL = thisObject.closest('ul.wpt_column_sortable');
            var sameElement = parentUL.find('.wpt_sortable_peritem');
            sameElement.removeClass(myTargetClass);
            var targetElement = parentUL.find('.wpt_sortable_peritem.column_keyword_' + target);
            targetElement.find('.colum_data_input').trigger('click');
            targetElement.addClass('expanded_li');
            targetElement.addClass(myTargetClass);
            OptimizeColumnWithName();
            $('a.my-inslide-close-button.button').remove();
            var myCloseButton = '<a class="my-inslide-close-button button">Close</a>';
            targetElement.find('.wpt_shortable_data').append(myCloseButton);
        }

        $('select.internal_select').on('select2:select', function( e ){
            var data = e.params.data;
            var target = data.id; //It's keyword name actually such: product_id,product_title etc
            var thisObject = $(this);
            openTargetInsideItem( target, thisObject );            
        });
        

        
        $(document.body).on('click','a.my-inslide-close-button.button',function(){
            $('.inside-column-enabled').fadeOut().removeClass('inside-column-enabled');
        });
        $(document.body).on('click',function(event){
            var inside_item = $('.inside-column-enabled').length;
            if (inside_item > 0 && $(event.target).closest(".wpt_shortable_data").length === 0) {
                $('.inside-column-enabled').fadeOut().removeClass('inside-column-enabled');
              }
        });

        /**
         * Product Exclude Include Feature Added Here,
         * Which is normally in Pro Actually
         * 
         * But after update WordPress version to latest 5.6 that was not working.
         * Actually after update to latest, wpt_admin_body class was not working properly.
         * That's why, we have added here
         */
        $('.product_includes_excludes,select#product_id_includes,select#product_id_cludes').select2({
            //templateSelection //templateResult
            templateSelection: function(option,ccc){
                
                /**
                 * Inside selected item, there was showing as thml tag format
                 * tai, apatoto name show kore rekheche.
                 * @since 2.9.4.0
                 * 
                 * I will fix it later. but for now, I have to return
                 * only text
                 * 
                 * ::processResults er vitoreo emon kora hoyeche.
                 */
                return option.text;
                
                if (!option.id) { return option.text; }
                if(typeof option.title === 'undefined'){
                    return option.text;
                }
                var content = option.title.split('|');
                var display = '';
                display += '<div class="wpt_select2_item_wrap">';
                if(option.title){
                    display += '<div class="image wpt_item wpt_item_left">';
                    display += '<img height="50" width="50" src="' + content[0] + '">';
                    display += '</div>';
                }
                display += '<div class="details wpt_item wpt_item_right">';
                display += '<h4>' + option.text + '</h4>';
                display += '<p>' + content[1] + '</p>';
                display += '<b>' + content[2] + '</b>';
                display += '</div>';
                display += '</div>';
                return display;
            },
            
            escapeMarkup: function (m) {
                                    return m;
                            },
            ajax: {
                url: WPT_DATA_ADMIN.ajax_url,
                dataType: 'json',
                data: function (params) {
                                    return {
                                            q: params.term, // search query
                                            action: 'wpt_pro_admin_product_list' // AJAX action for admin-ajax.php
                                    };
                            },
                processResults: function( data ) {
                            var options = [];
                            if ( data ) {

                                    // data is the array of arrays, and each of them contains ID and the Label of the option
                                    $.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
                                        //var r_text = text['image'] + '<span>' +  + '</span>';
                                        var display = '';
                                        display += '<div class="wpt_select2_item_wrap">';
                                        display += '<div class="image wpt_item wpt_item_left">';
                                        display += text['image'];
                                        display += '</div>';
                                        display += '<div class="details wpt_item wpt_item_right">';
                                        display += '<h4>' + text['title'] + '</h4>';
                                        display += '<p>' + text['price'] + '</p>';
                                        display += '<b>' + text['stock_status'] + '</b>';
                                        display += '</div>';
                                        display += '</div>';

                                            //options.push( { id: text['id'], text: display  } );
                                            /**
                                             * Uporer ongsho tuku age chilo
                                             * admin panel a kaj korchilo na, tai apatoto seta
                                             * off rekhechi ebong ekhon sudhu nam dekhanor bebostha korechi.
                                             * 
                                             * ::templateSelection er vitoreo emon kora hoyeche.
                                             * @since 2.9.4.0
                                             */
                                            options.push( { id: text['id'], text: text['title']  } );
                                    });

                            }
                            return {
                                    results: options
                            };
                    },
                    cache: true
              // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            minimumInputLength: 1

      });
      
        $('select#wpt_product_ids,select#product_tag_ids,select.wpt_select2,select.internal_select,select.ua_select product_includes_excludes').on('select2:select', function(e){
          wptSelectItem(e.target, e.params.data.id);
        });

        var removeAjax = function(aaa,bb){
                $('.button,button').removeClass('wpt_ajax_update');
            };
        //code for Sortable
        $( ".wpt_column_sortable" ).sortable({
            handle:'.handle',
            stop: removeAjax,
        });
        $( ".checkbox_parent" ).sortable({
            handle:this,
            stop: removeAjax,
        });
        $( ".wpt_responsive_each_wraper" ).sortable({handle:this});
        
        
        $(document).on('click','.colum_data_input, .wpt-expand',function(){
            var parents = $(this).parents('.wpt_shortable_data');
            var onOff = parents.children('.extra_all_on_off');
            var extras = parents.children('.wpt_column_setting_extra');
            extras.toggle('medium',function(){
                var status = $(this).attr('data-status');
                if(status == 'expanded'){
                    onOff.removeClass('off_now');
                    onOff.addClass('on_now');
                    onOff.html("Expand");
                    onOff.attr('data-status','expanded');
                    extras.parents('li').removeClass('expanded_li');
                    $(this).attr('data-status','collapsed');
                }else{
                    
                    onOff.removeClass('on_now');
                    onOff.addClass('off_now');
                    onOff.html("Collapse");
                    onOff.attr('data-status','collapsed');
                    extras.parents('li').addClass('expanded_li');
                    $(this).attr('data-status','expanded');
                }
                
            });
        });
        
        OptimizeColumnWithName();
        /**
         * When column will hide, or in display none, than we will change his attribute (name) to (backup-name)
         * and when it will come on .enabled class
         * we will change it's name to again attribute (name)
         * 
         * @since 3.2.2.0
         */
        function OptimizeColumnWithName(){
            setTimeout(function(){
                $('.wpt_column_sortable .wpt_sortable_peritem').not('.enabled').find('input,select').renameAttr('name', 'backup-name' );
                $('.wpt_column_sortable .wpt_sortable_peritem.enabled').find('input,select').renameAttr('backup-name', 'name' );


                var saiful = {};
                $('select.internal_select').each(function(){
                    var data = $(this).val();
                    var parent = $(this).closest('ul.wpt_column_sortable');
                    if( typeof data == 'object' && data.length > 0){
                        $(data).each(function(index,value){
                            // saiful[value] = value;
                            // console.log('.wpt_sortable_peritem.column_keyword_' + value);
                            // parent.find('.wpt_sortable_peritem.column_keyword_' + value).addClass('saiful-islam-hello');
                            parent.find('.wpt_sortable_peritem.column_keyword_' + value).find('input,select').renameAttr('backup-name', 'name' );
                        });
                    }
                    
                });

                
            },1000);
            
        }
        $(document).on('click','span.extra_all_on_off',function(){
            var key = $(this).data('key');
            var thisExpand = $(this);
            $('.wpt_column_setting_extra.extra_all_' + key).toggle('medium',function(){
                var status = thisExpand.attr('data-status');
                if(status == 'expanded'){
                    thisExpand.removeClass('off_now');
                    thisExpand.addClass('on_now');
                    thisExpand.parents('li').removeClass('expanded_li');
                    thisExpand.html("Expand");
                    thisExpand.attr('data-status','collapsed');
                }else{
                    thisExpand.removeClass('on_now');
                    thisExpand.addClass('off_now');
                    thisExpand.parents('li').addClass('expanded_li');
                    thisExpand.html("Collapse");
                    thisExpand.attr('data-status','expanded');
                }
                
                
                
            });
            
        });
        $(document).on('click','ul#wpt_column_sortable>li.wpt_sortable_peritem.enabled .wpt_column_arrow',function(){
            var target = $(this).attr('data-target');
            var keyword = $(this).attr('data-keyword');
            var thisElement = $(this).closest('li.wpt_sortable_peritem.enabled');
            var prev = thisElement.prev();
            var prevClass = prev.attr('class');
            var next = thisElement.next();
            var nextClass = next.attr('class');

            //console.log(typeof prev, typeof next, typeof thisElement);
            if( target == 'next' && typeof next.html() !== 'undefined'){
                thisElement.before('<li class="' + nextClass + '">'+next.html()+'</li>');
                next.remove();
            }
            if( target == 'prev' && typeof prev.html() !== 'undefined'){
                thisElement.after('<li class="' + prevClass + '">'+prev.html()+'</li>');
                prev.remove();
            }
        });
        
        $('.wpt_copy_button_metabox').click(function(){
            var ID_SELECTOR = $(this).data('target_id');
            copyMySelectedITem(ID_SELECTOR);
        });
        //wpt_metabox_copy_content
        function copyMySelectedITem(ID_SELECTOR) {
          var copyText = document.getElementById(ID_SELECTOR);
          copyText.select();
          document.execCommand("copy");
          $('.' + ID_SELECTOR).html("Copied");
          $('.' + ID_SELECTOR).fadeIn();
          
          var myInterVal = setInterval(function(){
              $('.' + ID_SELECTOR).html("");
              $('.' + ID_SELECTOR).fadeOut();
              clearInterval(myInterVal);
          },1000);
        }
        
        /**
         * Inside Tab of Column
         * 
         * @type String
         */
        $('body').on('click','#wpt_configuration_form .inside-column-settings-wrapper .inside-nav-tab-wrapper a', function(){
            $('.inside-nav-tab-wrapper a.nav-tab-active').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            var target_tab = $(this).data('target');
            $('.inside-column-settings-wrapper .inside_tab_content.tab-content-active').removeClass('tab-content-active');
            $('.inside-column-settings-wrapper .inside_tab_content#'+target_tab).addClass('tab-content-active');
        });
        /**************Admin Panel's Setting Tab Start Here For Tab****************/
        var selectLinkTabSelector = "body.wpt_admin_body #wpt_configuration_form a.wpt_nav_tab";
        var selectTabContentSelector = "body.wpt_admin_body #wpt_configuration_form .wpt_tab_content";
        var selectLinkTab = $(selectLinkTabSelector);
        var selectTabContent = $(selectTabContentSelector);
        var tabName = window.location.hash.substr(1);
        if (tabName) {
            setLastActiveTab(tabName);
            removingActiveClass();
            $('body.wpt_admin_body #wpt_configuration_form #' + tabName).addClass('tab-content-active');
            $('body.wpt_admin_body #wpt_configuration_form .nav-tab-wrapper a.wpt_nav_tab.wpt_nav_for_' + tabName).addClass('nav-tab-active');
        }
        
        $('body.wpt_admin_body').on('click','#wpt_configuration_form a.wpt_nav_tab',function(e){
            e.preventDefault(); //Than prevent for click action of hash keyword
            var targetTabContent = $(this).data('tab');//getting data value from data-tab attribute
            setLastActiveTab(targetTabContent);
            // Detect if pushState is available
            if(history.pushState) {
            //   history.pushState(null, null, $(this).attr('href'));
            }
            
            removingActiveClass();
            $(this).addClass('nav-tab-active');
            $('body.wpt_admin_body  #wpt_configuration_form #' + targetTabContent).addClass('tab-content-active');
            return false;
        });

        /**
         * Sets the value of the input element with the ID 'wpt-last-active-tab' to the provided tabName.
         * 
         * related code: 
         * 1. post_metabox.php
         * 2. post_metabox_form.php
         * 
         * Hooked: add_filter('redirect_post_location', 'wpt_redirect_after_save', 10, 2);
         *
         * @param {string} tabName - The name of the tab to set as the last active tab.
         * @return {void} This function does not return anything.
         */
        function setLastActiveTab(tabName) {

            $('input#wpt-last-active-tab').attr('value',tabName);
            //and
            if( tabName == '' ){
                return;
            }
            // Get the current URL
            var currentUrl = window.location.href;
            
            // Replace the value of 'wpt_active_tab'
            var newUrl = currentUrl.replace(/(wpt_active_tab=)[^\&]+/, '$1' + tabName);

            // Replace the current URL with the new URL
            // Change the URL without reloading the page
            history.replaceState(null, null, newUrl);
        }


        /**
         * Removing current active nav_tab and tab_content element
         * 
         * @returns {nothing}
         */
        function removingActiveClass() {
            selectLinkTab.removeClass('nav-tab-active');
            selectTabContent.removeClass('tab-content-active');
            return false;
        }
        
        /**************Admin Panel's Setting Tab End Here****************/
        
        /*********Columns , meta sorting orders and mobile checkbox controlling start here************/
       /**
         * If chose Custom Meta value than
         * Custom meta value's input field will be visible
         * Otherise, By default, It stay hidden
         */
        $("#wpt_meta_value_wrapper").hide();
        $('body.wpt_admin_body').on('change','#wpt_table_sort_order_by',function(){
            var current_val = $(this).val();
            if(current_val === 'meta_value' || current_val === 'meta_value_num'){
                $("#wpt_meta_value_wrapper").css('background','#f0f0f1');
                $("#wpt_meta_value_wrapper").show('slow');

            }else{
                $("#wpt_meta_value_wrapper").hide('slow');
            }
        });
        
        var wpt_table_sort_order_by = $('#wpt_table_sort_order_by').val();
        if(wpt_table_sort_order_by === 'meta_value' || wpt_table_sort_order_by === 'meta_value_num'){
            $("#wpt_meta_value_wrapper").fadeIn();
        }
        
        
        /**
         * Footer cart switcher template show/hide
         * 
         * @author Saiful
         */
         var $fc_on_off = $('#wpt_footer_cart_on_of').is(':checked');
         
         if($fc_on_off){
            $('#wpt_footer_cart_template').hide();
         }
         
         $(document.body).on('change','#wpt_footer_cart_on_of',function(){
            var $fc_on_off = $(this).is(':checked');
            if($fc_on_off){
                $('#wpt_footer_cart_template').fadeOut();
             }else{
                $('#wpt_footer_cart_template').fadeIn();
             }
        });

        /**
         * On of Element based on Selected Value for Select Tag
         * Add an Attribute  data-on="yes|.wpt_snf_on_off" or
         * data-off="desired_value|.desired_class"
         * Available data-on and data-off
         * data-on means: element will display based on your desired value for desired element.
         * Supposse: your 
         * REMEMEBER: select tag's class would be '.wpt_toggle' to activate this part
         */
        $('select.wpt_toggle').each(function(){
            changeOnOffElement(this)
        });
        $(document).on('change','select.wpt_toggle',function(){
            changeOnOffElement(this);
        });
        function changeOnOffElement(ElObject){
            var target_val,target_calss,Temp,TempElmnt;
            var val = $(ElObject).val();
            var dataON = $(ElObject).data('on');
            var dataOFF = $(ElObject).data('off');
            if(dataON){
                Temp = dataON.split("|");
                target_val = Temp[0];
                target_calss = Temp[1];
                TempElmnt = $(target_calss);
                if(val === target_val){
                    TempElmnt.fadeIn();
                }else{
                    TempElmnt.fadeOut();
                }
            }
            if(dataOFF){
                Temp = dataON.split("|");
                target_val = Temp[0];
                target_calss = Temp[1];
                TempElmnt = $(target_calss);
                if(val === target_val){
                    TempElmnt.fadeOut();
                }else{
                    TempElmnt.fadeIn();
                }
            }
        }
        
        /**
         * Managing Column from Activation Column List
         * 
         * @since We have added this featre at Version 2.7.8.2
         */
        $( 'body.wpt_admin_body' ).on('click', '.add_switch_col_wrapper .switch-enable-available li.switch-enable-item', function(){
            var keyword = $(this).data('column_keyword');
            $(this).toggleClass('item-enabled');
            //Detect and set Responsive Stats
            ///detect_responsive_stats();
            $(this).closest('.tab-content').find('.wpt_column_sortable li.wpt_sortable_peritem input.checkbox_handle_input[data-column_keyword="' + keyword + '"]').trigger('click');
            setTimeout(function(){
                detect_responsive_stats();
            }, 1000);
        });
        /**
         * Column Section Managing
         */
        $('body.wpt_admin_body').on('click','.wpt_column_sortable li.wpt_sortable_peritem input.checkbox_handle_input',function(){
            var keyword = $(this).data('column_keyword');
            var thisWPTSortAble = $(this).closest('.wpt_column_sortable');
            var targetLiSelector = thisWPTSortAble.find(' li.wpt_sortable_peritem.column_keyword_' + keyword);
            
            if ($(this).prop('checked')) {
                //$(this).addClass('enabled');
                $(this).fadeIn('fast',function(){
                    $(this).addClass('enabled')
                }).css("display", "flex");
                //targetLiSelector.addClass('enabled');
                targetLiSelector.fadeIn('fast',function(){
                    targetLiSelector.addClass('enabled')
                }).css("display", "flex");
            } else {
                //Counting Column//
                var column_keyword;
                column_keyword = [];
                $('#inside-desktop .wpt_column_sortable li.wpt_sortable_peritem.enabled .wpt_shortable_data input.colum_data_input').each(function(Index) {
                    column_keyword[Index] = $(this).data('keyword');
                });
                if (column_keyword.length < 2 && $(this).closest('.inside_tab_content').attr('id') === 'inside-desktop') {
                    alert('Minimum 1 column is required!');
                    return false;
                }
                //Counting colum End here
                
                
                
                //$(this).removeClass('enabled');
                $(this).fadeOut(function(){
                    $(this).removeClass('enabled');
                });
                $('.switch-enable-item-' + keyword).removeClass('item-enabled');
                //targetLiSelector.removeClass('enabled');
                targetLiSelector.fadeOut(function(){
                    targetLiSelector.removeClass('enabled');
                });
            }
            OptimizeColumnWithName();
//            
//            targetLiSelector.fadeIn(function(){
//                $(this).css('opacity','0.3');
//            });
        });
        
        detect_responsive_stats();
        function detect_responsive_stats(){
            var detect_responsive;
            detect_responsive = [];
            $('body.wpt_admin_body #inside-tablet li.wpt_sortable_peritem.enabled .wpt_shortable_data input.colum_data_input,body.wpt_admin_body #inside-mobile li.wpt_sortable_peritem.enabled .wpt_shortable_data input.colum_data_input').each(function(Index) {
                detect_responsive[Index] = 1;
            });
            // console.log(detect_responsive.length);
            var hid_respn_field = $('#hidden_responsive_data');
            if( detect_responsive.length > 0 ){
                hid_respn_field.val('no_responsive');
            }else{
                hid_respn_field.val('mobile_responsive');
            }
        }
        /**
         * For Hide on Mobile
         * 
         * @param {type} param
         */
        $('body.wpt_admin_body').on('click','#wpt_keyword_hide_mobile li.hide_on_mobile_permits input.checkbox_handle_input',function(){
            var keyword = $(this).data('column_keyword');
            var targetLiSelector = $('#wpt_keyword_hide_mobile li.hide_on_mobile_permits.column_keyword_' + keyword);
            if ($(this).prop('checked')) {
                $(this).addClass('enabled');
                targetLiSelector.addClass('enabled');
            } else {
                $(this).removeClass('enabled');
                targetLiSelector.removeClass('enabled');
            }
            OptimizeColumnWithName();
        });

        /*********Columns , meta sorting orders and mobile checkbox controlling end here************/
        
        //Adding Texonomy or Custom Field Button
        $('body.wpt_admin_body').on('click','#tax_cf_adding_button',function(){
            var taxt_cf_type,taxt_cf_input,taxt_cf_title,keyword,html;
            taxt_cf_type = $('.taxt_cf_type').val();
            taxt_cf_input = $('.taxt_cf_input').val();
            taxt_cf_title = $('.taxt_cf_title').val();
            
            if(taxt_cf_input === '' || taxt_cf_title === ''){
                alert("Keyword or Column Name can't be empty");
                return false;
            }
            keyword = taxt_cf_type + taxt_cf_input;
            
            html = '<li class="wpt_sortable_peritem  column_keyword_' + keyword + ' enabled">';
                html += '<span title="Move Handle" class="handle ui-sortable-handle"></span>';
                html += '<div class="wpt_shortable_data">';
                    html += '<input name="column_array[' + keyword + ']" data-column_title="' + taxt_cf_title + '" data-keyword="' + keyword + '" class="colum_data_input product_id" type="text" value="' + taxt_cf_title + '">';
                    html += "<span class='wpt_column_cross'>X</span>";
                html += '</div>';
                html += '<span title="Move Handle" class="handle checkbox_handle ui-sortable-handle">';
                    html += '<input name="enabled_column_array[' + keyword + ']" value="' + taxt_cf_title + '" title="Active Inactive Column" class="checkbox_handle_input  enabled" type="checkbox" data-column_keyword="' + keyword + '" checked="checked">';
                html += '</span>';
            html += '</li>';
            $('.wpt_column_sortable').append(html);
            
        });
        
        //Design Style part JS
        $('.wpt_color_picker').wpColorPicker();

        $('select#wpt_style_file_selection,select#wpt_table_mobile_responsive').trigger('change');
        
        
        //span.wpt_column_cross
        $('body.wpt_admin_body').on('click','span.wpt_column_cross',function(){
            $(this).parents('.wpt_sortable_peritem').hide('medium',function(){
                $(this).remove();
            });
        });
        
        /**
         * Add new Column
         * 
         */
        $(document).on('click','.add_new_column_button',function(e){
            e.preventDefault();
            var keyword = $('.and_new_column_key').val();
            var label = $('.and_new_column_label').val();
            var type = $('.add_new_column_type_select').val();
            var type_name = $('.add_new_column_type_select option[value='+ type +']').text();
            var type_name_show = '<i>' + type_name + '</i>: ';
            if(type === 'default'){
                type_name_show = '';
            }
            var device_name = $('.inside-column-settings-wrapper nav.inside-nav-tab-wrapper a.wpt_inside_nav_tab.nav-tab-active').data('device');
            var device = '_' + device_name;
            if(device_name === 'desktop'){
                device = '';
            }
            
            var html = '';
            html = '<li class="wpt_sortable_peritem  column_keyword_' + keyword + ' enabled">';
                html += '<span title="Move Handle" class="handle ui-sortable-handle"></span>';
                html += '<input type="hidden" name="column_settings' + device + '[' + keyword + '][type]" value="' + type + '">';
                html += '<input type="hidden" name="column_settings' + device + '[' + keyword + '][type_name]" value="' + type_name + '">';
                html += '<div class="wpt_shortable_data">';
                    html += '<input name="column_array' + device + '[' + keyword + ']" data-column_title="' + label + '" data-keyword="' + keyword + '" class="colum_data_input ' + keyword + '" type="text" value="' + label + '">';
                    html += '<span class="wpt_colunm_type">' + type_name_show + keyword + '</span>';
                    html += "<span class='wpt_column_cross'>X</span>";
                html += '</div>';
                html += '<span title="Move Handle" class="handle checkbox_handle ui-sortable-handle">';
                    html += '<input name="enabled_column_array' + device + '[' + keyword + ']" value="' + keyword + '" title="Active Inactive Column" class="checkbox_handle_input  enabled" type="checkbox" data-column_keyword="' + keyword + '" checked="checked">';
                html += '</span>';
            html += '</li>';
            
            //Check Empty Field
            if(keyword === '' || label === ''){
               alert("No empty field suported.");
               return;
            }
            //Check if already same keyword is Available
            if($('#inside-' + device_name + ' .wpt_column_sortable li.wpt_sortable_peritem').hasClass('column_keyword_' + keyword)){
                alert('Same keyword already in list');
                return;
            }
            
            if(keyword !== '' || label !== ''){
                //Remove Ajax Save
                $('.button,button').removeClass('wpt_ajax_update');
                
                
                
                $('#inside-' + device_name + ' .wpt_column_sortable').append(html);
                $('.and_new_column_key').val('');
                $('.and_new_column_label').val('');
                $('.add_new_column_type_select').val('');
                
                $('body.wpt_admin_body input#publish[name=save]').trigger('click');
            }
            return;
            
            
            
            
        });
        /**
         * Data Save by Ctrl + S
         */
        $(window).bind('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                if($('.form_bottom.form_bottom_submit_button').hasClass('wrapper_wpt_ajax_update') && String.fromCharCode(event.which).toLowerCase() === 's' ){
                    //Detect and set Responsive Stats
                    ///detect_responsive_stats();
                    
                    event.preventDefault();
                    $('body.wpt_admin_body input#publish[name=save]').trigger('click');
                }
            }
        });


        $(document).on('change','li.wpt_sortable_peritem.column_keyword_content',function(){
            $('.button,button').removeClass('wpt_ajax_update');
        });
        
        $(document).on('click,change,focus','#wpt-import-textarea',function(){
            $('.button,button').removeClass('wpt_ajax_update');
        });
        

        //*********************** AJAX Save - AJAX data save
        $('body').append("<div class='wpt_notify'><h1>Saving...</h1></div>");
        
        $(document).on('click','.checkbox_handle_input',function(){
            $('.button,button').removeClass('wpt_ajax_update');
        });
        
        //I will remove ajax save button for now.
        // $(document).on('click','body.wpt_admin_body .form_bottom.form_bottom_submit_button button.button.wpt_ajax_update, body.wpt_admin_body input#publish[name=save]',function(e){
        $(document).on('click','body.wpt_admin_body .form_bottom.form_bottom_submit_button button.button.wpt_ajax_update',function(e){
            //Detect and set Responsive Stats
            detect_responsive_stats();
            
            $('.wpt_notify').css('display','block');
            
            var 
            old_title   = $('button.button.wpt_ajax_update').attr('data-title'), 
            new_title       = $('#title').val();
            
            if( old_title === new_title ){
                e.preventDefault();
            }else{
                return;
            }
            
            
            var postURL = 'post.php';
            
            
            //Collate all post form data
            var data = $('form#post').serializeArray();
            //Set a trigger for our save_post action
            data.push({wpt_ajax_save: true});


            //The XHR Goodness
            $.post(postURL, data, function(response){}).done(function(){
                $('.wpt_notify h1').html('Saved Product Table');
                $('.wpt_notify').fadeOut();
            }).fail(function(){
                $('.wpt_notify h1').html('Unable to Save, Please try again.');
                $('.wpt_notify').fadeOut();
            });
            return false;

        });
        
        var myOptions = {
            // you can declare a default color here,
            // or in the data-default-color attribute on the input
            defaultColor: false,
            // a callback to fire whenever the color changes to a valid color
            change: function(event, ui){
                wptUpdateStyleData(this);
            },
            // a callback to fire when the input is emptied or an invalid color
            clear: function() {
                //alert('Empty/invalid color');
                wptUpdateStyleData(this);
            },
            // hide the color picker controls on load
            hide: true,
            // show a group of common colors beneath the square
            // or, supply an array of colors to customize further
            palettes: false,
            // palettes:['#000000','#ffffff','#aabbcc','#0a7f9c','#B02B2C','#edae44','#eeee22','#83a846','#7bb0e7','#745f7e','#5f8789','#d65799','#4ecac2'],
        };
        $('.wpt-color, .wpt-background-color').wpColorPicker(myOptions);
        
        $('body .wpt_tab_content textarea').on('change',function(){
            //alert(4545454);
            $('.form_bottom.form_bottom_submit_button').removeClass('wrapper_wpt_ajax_update');
        });
        
        //console.log(tinymce.Editor);
//        tinymce.init({
//  selector: 'textarea',
//  init_instance_callback: function (editor) {
//    editor.on('Change', function (e) {
//      alert('Editor contents was changed.');
//    });
//  }
//});
        function wptUpdateStyleData(element){
            //style_str_value_wrapper
            var wrapper = $(element).closest('.style_str_wrapper');
            var targetWrapper = wrapper.data('target_value_wrapper');
            // console.log(targetWrapper,"#" + targetWrapper + " .str_str_each_value");
            var property_name, property_value;
            var str_str = "";
            $("." + targetWrapper + " .str_str_each_value").each(function() {
                property_name = $(this).data('proerty_name');
                property_value = $(this).val();
                if( property_value ){
                    str_str += property_name + ": " + property_value + ";";
                }
            });
            //str_str_value_string
            $("." + targetWrapper + " .str_str_value_string").val(str_str);
        }
        $('body').on('click', '.wpt-reset-style', function(e){
            e.preventDefault;
            var wrapper = $(this).closest('.wpt_column_setting_extra');
            var targetWrapper = wrapper.data('wpt_column_setting_extra');
            $("." + targetWrapper + " .style_str_wrapper .str_str_value_string").val("");
            $("." + targetWrapper + " .style_str_wrapper .wpt-style-body input").val("");
            $("." + targetWrapper + " .style_str_wrapper .wp-picker-clear").trigger('click');
            $(this).closest('.wpt-style-body').append("<p>All style cleared. Now click on <strong>Update</strong> button or press <strong>Ctrl+S</strong> on Windows or <strong>Cmd+S</strong> on Mac to save the changes.</p>")
            
        });

        
    });

    /**
     * onChange table type 
     * fire this function
     */
     $(document).on('change', '#wpt_table_product_type', function(){
        only_variation_table($(this));
    });
    
    /**
     * onLoad website get the value of table type
     * and act as per value.
     */
     $(document).ready( function(){
        only_variation_table();
    });

    function only_variation_table(element){
        var element = element;
        if( element == undefined ){
            element = $('#wpt_table_product_type');
        }
        var product_type = $(element).val();

        if( product_type == 'product_variation' ){
            $('.notice-for-variations').show();
            $('#wpt_product_cat_excludes').attr('disabled', 'disabled');
            $('#product_id_cludes').attr('disabled', 'disabled');
        }else{
            $('.notice-for-variations').hide();
            $('#wpt_product_cat_excludes').removeAttr('disabled');
            $('#product_id_cludes').removeAttr('disabled');
        }
    }


    $(document.body).on('click,change','tr.user_can_not_edit input,tr.user_can_not_edit select',function(e){
        e.preventDefault();
        alert("Sorry");
    });
    

    $(document.body).on('submit', 'form#wpt-main-configuration-form', function (e){

        let submitBtn = $(this).find('button.configure_submit');
        let submitBtnInForm = submitBtn.not('.float-btn');
        let submitBtnIcon = submitBtn.find('span i');
        submitBtn.find('strong.form-submit-text').text('Saving...');
        submitBtnIcon.attr('class', 'wpt-spin5 animate-spin');
        // submitBtnIcon.attr('class', 'wpt-floppy');
        
        
    });

    

    /**
     * This is for Product Table Configure page Floating button.
     * actually for configure page and post edit page,
     * we did it separately.
     * Here for configure, and for post edit, we did it at the bottom of this following section.
     * 
     * @since 3.4.2.1
     */
    
    var colSetsLen = $('form#wpt-main-configuration-form').length;

    if( colSetsLen > 0 ){

        var saveChangeText = 'Save';
        var btnHtml = '<div class="">';
        btnHtml += '<button type="submit" name="configure_submit" class="float-btn wpt-btn wpt-has-icon configure_submit"><span><i class="wpt-floppy"></i></span><strong>' + saveChangeText + '</strong></button>';
        btnHtml += '</div>';

        $('#wpt-main-configuration-form').append(btnHtml);

        $(window).on('scroll',function(){

            let targetElement = $('.float-btn');
            let topbarElement = $('div.wpt-header.wpt-clearfix');
            // if(targetElement.length < 1) return;
            
            let bodyHeight = $('#wpbody').height();
            let scrollTop = $(this).scrollTop();
            let screenHeight = $(this).height();
    
            let configFormElement = $('form#wpt-main-configuration-form');
            if(configFormElement.length < 1) return;
    
            let conPass = bodyHeight - screenHeight - 100 - targetElement.height();
            let leftWill = configFormElement.width() - targetElement.width() - 20;
            
    
            // targetElement.css({
            //     left: leftWill,
            //     right: 'unset'
            // });
            if(scrollTop < conPass){
                targetElement.addClass('stick_on_scroll-on');
            }else{
                targetElement.removeClass('stick_on_scroll-on');
            }
            if(scrollTop > 90){
                configFormElement.addClass('topbar-fixed-on-scroll-main-element');
                topbarElement.addClass('topbar-fixed-on-scroll');
            }else{
                configFormElement.removeClass('topbar-fixed-on-scroll-main-element');
                topbarElement.removeClass('topbar-fixed-on-scroll');
            }
            if(scrollTop > 100 && colSetsLen > 0){
                targetElement.attr('id','stick_on_scroll-on');
            }else if(colSetsLen > 0){
                targetElement.removeAttr('id');
            }
            
    
        });

    } 
    

    var postColSetsLen = $('#column_settings').length;

    /**
     * This is for Product Table post Edit and Add new page.
     * actually for configure page and post edit page,
     * we did it separately.
     * Here for Product Table edit, and for configure page, we did it at the up of this comment.
     */
    
    var status = $('#original_post_status').val();

    if( postColSetsLen > 0 && status === 'publish'){
        var saveChangeText = $('button.button[name="wpt_post_submit"]').text(); //Save Change
        var myHtml = '<div class="wrapper_wpt_ajax_update ultraaddons-button-wrapper">';
        myHtml += '<button type="submit" name="wpt_post_submit" data-title="hello" class="stick_on_scroll button-primary button-primary primary button wpt_ajax_update">'+ saveChangeText +'</button>';
        myHtml += '</div>';
        $('#wpt_configuration_form').append(myHtml);
        $(window).on('scroll',function(){

            let targetElement = $('.stick_on_scroll');
            if(targetElement.length < 1) return;
            
            
            let bodyHeight = $('#wpbody').height();
            let scrollTop = $(this).scrollTop();
            let screenHeight = $(this).height();
    
            let configFormElement = $('#wpt_configuration_form');
            if(configFormElement.length < 1) return;
    
            let conPass = bodyHeight - screenHeight - 300 - targetElement.height();
            let leftWill = configFormElement.width() - targetElement.width() - 20;
            
    
            targetElement.css({
                left: leftWill,
                right: 'unset'
            });
            if(scrollTop < conPass){
                targetElement.attr('id','stick_on_scroll-on');
            }else{
                targetElement.removeAttr('id');
            }

            if(scrollTop > 100 && postColSetsLen > 0){
                targetElement.attr('id','stick_on_scroll-on');
            }else if(postColSetsLen > 0){
                targetElement.removeAttr('id');
            }
            
    
        });


    }
    


    /**
     * Tab Area Handle
     */
    configureTabAreaAdded('#wpt-main-configuration-form'); //Specially for Configure Page
    configureTabAreaAdded('.fieldwrap.wpt_result_footer.ultraaddons.pro_version'); //From inside on Edit Table
    function configureTabAreaAdded( mainSelector = '#wpt-main-configuration-form' ){
        var tabSerial = 0;
        var tabArray = new Array();
        var tabHtml = ""
        var tabArea = $(mainSelector + ' .wpt-configure-tab-wrapper');
        if(tabArea.length < 1){
            $(mainSelector).prepend('<div class="wpt-configure-tab-wrapper wpt-section-panel no-background"></div>');
            tabArea = $(mainSelector + ' .wpt-configure-tab-wrapper');
        }
        var sectionPanel = $(mainSelector + ' div.wpt-section-panel');
        sectionPanel.each(function(index, content){
            
            let table = $(this).find('table');
            let tableCount = table.length;
            if(tableCount > 0){
                
                let firstTable = table.first();
                let tableId = $(this).attr('id');
                let tableTitle = firstTable.find('thead tr th:first-child h3').text();
                tabArray[tableId] = tableTitle;

                if(tabSerial !== 0){
                    $(this).hide();
                    tabHtml += "<a href='#" + tableId + "' class='tab-button wpt-button link-" + tableId + "'>" + tableTitle + "</a>"
                }else{
                    $(this).addClass('active');
                    tabHtml += "<a href='#" + tableId + "' class='tab-button wpt-button link-" + tableId + " active'>" + tableTitle + "</a>"
                }

                tabSerial++;

            }
            
        });
        if(tabSerial > 1){
            tabHtml += "<a href='#show-all' class='tab-button wpt-button'>Show All</a>";
            tabArea.html(tabHtml);
        }
        
        $(document.body).on('click','.wpt-configure-tab-wrapper a.tab-button',function(e){
            e.preventDefault();
            $('.wpt-configure-tab-wrapper a').removeClass('active');
            $(this).addClass('active');
            $(mainSelector + ' div.wpt-section-panel.active').hide();
            let target = $(this).attr('href');
            if(target == '#show-all'){
                sectionPanel.fadeIn();
                return;
            }
            $(mainSelector + ' ' + target).fadeIn().addClass('active');
            
        });
    }


})(jQuery);

/**
 * Fazle did it in pro, which was wrong decision.
 * I Saiful Islam transferred it to free version.
 * 
 * 
 * Collapsible design tab
 * @author Fazle Bari 
 * @since 8.1.9.1
 */

var coll = document.getElementsByClassName("wpt-design-expand");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    var content = this.nextElementSibling;
    // if (content.style.display === "block") {
    //   content.style.display = "none";
    // } else {
    //   content.style.display = "block";
    // }

    if (content.style.display === "none") {
        content.style.display = "block";
      } else {
        content.style.display = "none";
      }
  

  });
}