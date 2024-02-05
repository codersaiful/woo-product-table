/* 
 * Only for Fronend Section
 * @since 1.0.0
 */


jQuery(function($) {
    'use strict';
    $(document).ready(function() {

        var notice_timeout = 2000; //In mili second
        if(WPT_DATA.notice_timeout){
            notice_timeout = WPT_DATA.notice_timeout;
        }
        

        //Select2
        if(typeof $('.wpt-wrap .search_select').select2 === 'function' && $('.wpt-wrap .search_select').length > 0 && WPT_DATA.select2 !== 'disable' ){
            var select2Object = {};
            var multiple = $('.wpt-wrap .search_select').attr('multiple');
            if( WPT_DATA.search_select_placeholder !== '' && multiple == 'multiple' ){
                select2Object = {
                    placeholder: WPT_DATA.search_select_placeholder,
                    allowClear: true,
                };
            }
            
            $('.wpt-wrap .search_select.query').select2(select2Object);

            // $('select.filter_select').select2();
            $('.keyword-s-wrapper select').select2();

        }
        var windowWidth = $(window).width();

        $(window).resize(function() {
            
          //to disable Reload based on Screenshize use filter wpto_localize_data
          if( windowWidth != $(window).width()  && WPT_DATA.resize_loader) {
            location.reload();
            return;
          }
        });
        
        $('.item_inside_cell').each(function(){
            var style = $(this).attr('style');
            $(this).children('a').attr('style',style);
            $(this).attr('style','');
        });
        
        /**
         * Checking wpt_pro_table_body class available in body tag
         * 
         * @since 4.3 we have added this condition. 
         */
        if(!$('div.wpt-wrap table').hasClass('wpt_product_table')){ //div wpt-wrap 
            return false; 
        }        
        
            
        var plugin_url = WPT_DATA.plugin_url;
        var include_url = WPT_DATA.include_url;
        var content_url = WPT_DATA.content_url;
        
        var ajax_url = WPT_DATA.ajax_url;
        var site_url = WPT_DATA.site_url;
        
        //console.log(WPT_DATA);//Only for Developer
        if( ajax_url === 'undefined'  ){
            //console.log( 'WOO PRODUCT TABLE is not Available to this page \nOR:::SORRY!!!!: woocommerce_params is Undefine also ajax_url also undefined. So ajax will not work not. Contact with codersaiful@gmail.com' );
            return false;
        }

        /**
         * Pagination
         * @type Objectt
         */
        // changeSpanToAPagi();
        function changeSpanToAPagi(){
            return;
            $('div.wpt_table_pagination span.page-numbers.current').each(function(){
                var _number = $(this).html();
                $('div.wpt_table_pagination span.page-numbers.current').replaceWith('<a class="page-numbers current">' + _number + '</a>');
            });

            $('div.wpt_table_pagination a.page-numbers').each(function(){
                var _number = $(this).html();
                $(this).attr('data-page_number',_number);
            });
        }
        
        $('body').on('click','.wpt_table_pagination.pagination_loading a',function(e){
            e.preventDefault();
            return false;
        });
        
        

        //New Pagination
        $(document.body).on('click','dddd.wpt_pagination_ajax .wpt_my_pagination a',function(e){
            
            e.preventDefault();
            var thisButton = $(this);
            var thisPagination = thisButton.closest('.wpt_my_pagination');
            var page_number = $(thisButton).text();

            var table_id = thisPagination.data('table_id');
            
            var data = {
                action: 'wpt_pagination',
                table_id: table_id,
                page_number: page_number,
            };
            $.ajax({
                type: 'POST',
                url: ajax_url,// + get_data,
                data: data,
                success:function(result){
                    $('header.entry-header').html(result);
                    thisPagination.html(result);
                }
            });
        });
        /**
         * Pagination
         */
        $(document.body).on('click','.wpt_pagination_ajax .wpt_table_pagination:not(.wpt_my_pagination) a',function(e){
            e.preventDefault();
            var thisButton = $(this);

            var page_number = $(thisButton).data('page_number');
            
            var temp_number = $(thisButton).closest('.wpt_table_pagination').data('temp_number');
            
            
            var targetTable = $('#table_id_' + temp_number + ' table#wpt_table');
            var targetTableArgs = targetTable.attr( 'data-data_json' );
                targetTableArgs = JSON.parse(targetTableArgs);

                
           
            var targetTableBody = $('#table_id_' + temp_number + ' table#wpt_table tbody');
            var thisPagiWrappers = $('#table_id_' + temp_number + ' .wpt_table_pagination');
            var thisPagiLinks = $('#table_id_' + temp_number + ' .wpt_table_pagination a.page-numbers');
            thisPagiLinks.removeClass('current');
            
            var load_type = 'current_page';
            var pageNumber = page_number;
            targetTableBody.css('opacity','0.2');
            thisPagiWrappers.addClass('pagination_loading');

            var data;
            // var data = {
            //     action:         'wpt_query_table_load_by_args',
            //     temp_number:    temp_number,
            //     targetTableArgs:targetTableArgs,
            //     pageNumber:     pageNumber,
            //     load_type:     load_type,
            // };
            var whole_data = $('#table_id_' + temp_number + ' .wpt_table_pagination').attr('data-whole_data');
            if( typeof whole_data !== 'undefined' && typeof whole_data === 'string' ){
                data = JSON.parse(whole_data);
                
                data.load_type = load_type;
                data.targetTableArgs = targetTableArgs;
                data.pageNumber = pageNumber;
                data.temp_number = temp_number;
                data.action = 'wpt_query_table_load_by_args';

                
            }else{
                return;
            }
            

            $.ajax({
                type: 'POST',
                url: ajax_url,// + get_data,
                data: data,
                complete: function(){
                    $( document ).trigger( 'wc_fragments_refreshed' );
                    arrangingTDContentForMobile(); //@Since 5.2
                    loadMiniFilter(); //@Since 4.8
                    
                    fixAfterAjaxLoad();
                    
                    var current_link = window.location.href;
                    window.history.pushState('data', null, current_link.replace(/(paged=\d)+/, "paged=" + (pageNumber-1)));


                    /**
                     * Scrolling to Table Top
                     * 
                     * @type window.$|$
                     */
                    var body = $('html, body');
                    var thisTableTop = $('#table_id_' + temp_number).offset();
                    body.animate({scrollTop:thisTableTop.top}, 500, 'swing');

                    $(document.body).trigger('wpt_paginate_done', temp_number);

                },
                success: function(data) {
                    targetTableBody.html(data);
                    targetTableBody.css('opacity','1');
                    
                    var $data = {
                                action:         'wpt_ajax_paginate_links_load',
                                temp_number:    temp_number,
                                targetTableArgs:targetTableArgs, 
                                pageNumber:     pageNumber,
                                load_type:     load_type,
                            };
                    
                    loadPaginationLinks($data,temp_number);

                    removeCatTagLings();//Removing Cat,tag link, if eanabled from configure page
                    updateCheckBoxCount(temp_number); //Selection reArrange 
                    uncheckAllCheck(temp_number);//Uncheck All CheckBox after getting New pagination
                    emptyInstanceSearchBox(temp_number);//CleanUp or do empty Instant Search
                    
                    
                    if($('#table_id_' + temp_number + ' table.wpt_product_table').attr('data-queried') !== 'true'){
                        generate_url_by_search_query(temp_number);
                        $('#table_id_' + temp_number + ' table.wpt_product_table').attr('data-queried','true');
                    }
                    
                    
                    

                    pageNumber++; //Page Number Increasing 1 Plus
                    targetTable.attr('data-page_number',pageNumber);
                },
                error: function() {
                    console.log("Error On Ajax Query Load. Please check console.");
                },
            });
            
            
        });
        //End of Pagination
        
        setTimeout(function(){
			$('table.wpt_product_table td select').trigger('change');
		}, 4000);
        function fixAfterAjaxLoad() {
            $('table.wpt_product_table td select').trigger('change');
            //$.getScript(include_url + "/js/mediaelement/mediaelement-and-player.min.js");
            $.getScript(include_url + "/js/mediaelement/wp-mediaelement.min.js");
            $.getScript(plugin_url + "/woocommerce/assets/js/frontend/add-to-cart.js");
            $.getScript(plugin_url + "/woocommerce/assets/js/frontend/woocommerce.js");
            $.getScript(plugin_url + "/woocommerce/assets/js/frontend/add-to-cart-variation.min.js");
        }
        
        $(document.body).on('wpt_ajax_loaded',function(){
            var variableProducts,musicProducts;
            setTimeout(function(){
                variableProducts = $('tr.product_type_variable').length;
                musicProducts = $('audio,.wp-audio-shortcode').length;
                if(variableProducts > 0){
                    // $.getScript(include_url + "/js/mediaelement/wp-mediaelement.min.js");
                    // $.getScript(plugin_url + "/woocommerce/assets/js/frontend/add-to-cart.js");
                    // $.getScript(plugin_url + "/woocommerce/assets/js/frontend/woocommerce.js");
                    $.getScript(plugin_url + "/woocommerce/assets/js/frontend/add-to-cart-variation.min.js");
                }
                if(musicProducts > 0){
                    
                    $.getScript(include_url + "/js/mediaelement/wp-mediaelement.min.js");
                    $( window.wp.mediaelement.initialize );
                }
            },100);

        });
    
    
        /**
         * Getting object for config_json from #wpt_table table.
         * Can be any table. because all table will be same config json data
         * 
         * @returns {Objectt}
         */        
        var config_json = $('#wpt_table').data('config_json');
        if ( typeof config_json === 'undefined' ){
            return false;
        }
        /**
         * Config Generate part
         * Mainly getting config_json value based on table id. To get new value if available in inside any function, Use like following
         * config_json = getConfig_json( temp_number );
         * 
         * @param {type} temp_number Table ID
         * @returns {Objectt} Json Object, Mainly getting config_json value based on table id.
         */
        function getConfig_json( temp_number ){
           var temp_cjson = $('div#table_id_' + temp_number + ' #wpt_table').data('config_json');
           if ( typeof temp_cjson === 'undefined' ){
                temp_cjson = config_json;
            }
            return temp_cjson;
        }

        var footer_cart = config_json.footer_cart;
        var footer_cart_size = config_json.footer_cart_size;
        var footer_possition = config_json.footer_possition;
        var footer_bg_color = config_json.footer_bg_color;
        //Adding Noticeboard and Footer CartBox Div tag at the bottom of page
        $('body').append("<div class='wpt_notice_board'></div>");
        $('body').append('<div style="height: ' + footer_cart_size + 'px;width: ' + footer_cart_size + 'px;" class="wpt-footer-cart-wrapper '+ footer_possition +' '+ footer_cart +'"><a target="_blank" href="#" class="wpt-footer-cart-wrapper-sssss"></a></div>');
        
        /**
         * NoticeBoard Notice
         * To get/collect Notice after click on add to cart button 
         * or after click on 
         * 
         * @returns {undefined}
         */
        function WPT_NoticeBoard(){
            
            var noticeBoard = $('div.wpt_notice_board');
            $.ajax({
                type: 'POST',
                url: ajax_url,
                data: {
                    action: 'wpt_print_notice'
                },
                success: function(response){
                    if( config_json.popup_notice !== '1' ) return;
                    var eachNoticeInnter = $(response);
                    eachNoticeInnter.css('display','none');
                    if(response !== ''){
                        noticeBoard.append(eachNoticeInnter);
                        eachNoticeInnter.fadeIn();  
                        setTimeout(function(){
                            eachNoticeInnter.fadeOut('medium');
                            eachNoticeInnter.remove(); 
                        },notice_timeout); //Detault 3000
                    }
                },
                error: function(){
                    console.log("Unable to load Notice");
                    return false;
                }
            });
            
        }
        
        $('body').on('click','div.wpt_notice_board>div',function(){
            $(this).fadeOut('medium');
        });
        
        /**
         * Auto Checked checkbox Trigger 
         */
        $('div.wpt_checked_table').each(function(){
            var temp_number = $(this).data('temp_number');
            $('div.wpt_checked_table .all_check_header input.wpt_check_universal.wpt_check_universal_header').trigger('click');
            $('div.wpt_checked_table th input.wpt_check_universal').trigger('click');
            $('body.wpt_table_body .wpt-wrap input.enabled.wpt_tabel_checkbox.wpt_td_checkbox').trigger('click');
            updateCheckBoxCount(temp_number);//

        });
        function WPT_MiniCart(){

        }
        
        
        //wc_fragments_refreshed,wc_fragments_refresh,wc_fragment_refresh,removed_from_cart
        $( document.body ).trigger( 'updated_cart_totals' );
        $( document.body ).trigger( 'wc_fragments_refreshed' );
        $( document.body ).trigger( 'wc_fragments_refresh' );
        $( document.body ).trigger( 'wc_fragment_refresh' );
        // $( document.body ).trigger( 'removed_from_cart' );
        WPT_MiniCart();
        
        //if(config_json.thumbs_lightbox === '1' || config_json.thumbs_lightbox === 1){
        /**
         * Popup Image 
         */
        $('body').on('click', '.wpt-wrap .wpt_thumbnails_popup img', function() {
            
            // return;
            var thisImg = $(this);
            var image_width, final_image_url, variation_id,imgSize;
            //For vatiation management
            variation_id = $(this).attr('data-variation_id');

            if('undefined' !== typeof variation_id){

                var data_objec = $(this).closest('tr.wpt-row').data('product_variations');
                var finalImgObject,fullObject;
                
                $.each(data_objec,function(index,eachObj){
                    if( variation_id == eachObj['variation_id'] ){
                        fullObject = eachObj;
                        finalImgObject = eachObj['image'];
                    }
                    
                });

                if('undefined' !== typeof finalImgObject){
                    final_image_url = finalImgObject.full_src;
                    image_width = finalImgObject.full_src_w;
                    IMG_Generator(thisImg,final_image_url, image_width);
                }

            }else{
                image_width = $(this).parent().data('width');
                final_image_url = $(this).parent().data('url');
                IMG_Generator(thisImg,final_image_url, image_width);
            }


        });

        /**
         * Image Generator for Variation product based on Variation ID
         * Variation Wise Image Generator
         * Added at 4.0.20
         * 
         * @param {type} thisImg Getting Current Image Event
         * @param {type} final_image_url 
         * @param {type} image_width
         * @returns {undefined}
         */
        function IMG_Generator(thisImg,final_image_url, image_width){

            var image_height, product_title,placeholder_image,wrapper_style;

            image_height = 'auto';

            if('undefined' === typeof final_image_url){
                placeholder_image = $(thisImg).attr('src');
                console.log("No Thumbnail Image found");
                final_image_url = placeholder_image;//Set final image size to place holder image when not found
                wrapper_style = '';//Default blank value for style of wrapper, when not found any image
            }else{
                //Setting style of height width
                wrapper_style = "style='width: " + image_width + "px; height:" + image_height + "px'";
            }
            product_title = $(thisImg).closest('tr.wpt-row').find('.wpt_product_title_in_td').text();
            if(!product_title){
                product_title = '';
            }
            var html = '<div id="wpt_thumbs_popup" class="wpt_thumbs_popup"><div class="wpt_popup_image_wrapper" ' + wrapper_style + '><span title="Close" id="wpt_popup_close">&times;</span><h2 class="wpt_wrapper_title">' + product_title + '</h2><div class="wpt_thums_inside">';
            html += '<img class="wpt_popup_image" src="' + final_image_url + '">';

            html += '</div></div></div>';
            if ($('body').append(html)) {
                var PopUp = $('.wpt_thumbs_popup, #wpt_thumbs_popup');
                PopUp.fadeIn('slow');
                var Wrapper = $('div.wpt_popup_image_wrapper');
                Wrapper.fadeIn();
            }
        }

        $('body').on('click', '.wpt_popup_image_wrapper', function() {
            return false;

        });
        $('body').on('click', '#wpt_thumbs_popup span#wpt_popup_close, #wpt_thumbs_popup', function() {
            $('#wpt_thumbs_popup').fadeOut(function(){
                $(this).remove();
            });

        });
        //}

        $('body').on('click','a.button.wpt_woo_add_cart_button.outofstock_add_to_cart_button.disabled',function(e){
            e.preventDefault();
            var temp_number = $(this).closest( '.wpt_action' ).data('temp_number');
            config_json = getConfig_json( temp_number );
            showAlert(config_json.sorry_out_of_stock);
            return false;
        });
        
        /**
         * Click Action/Event on No ajax product in Add to cart button
         * No Ajax Add to cart product button Action
         *
        $('body').on('click','a.no_ajax_action.wpt_woo_add_cart_button',function(e){
            e.preventDefault();
            var quantity = $(this).attr('data-quantity');
            var uri = $(this).attr('href') + '&quantity=' + quantity;
            uri = encodeURI(uri);
            window.location = uri;
        });
        /**
         * Click Action/Event on No ajax product in Add to cart button
         * for Grouped and External Product
         *
        $('body').on('click','tr.product_type_grouped.grouped a.no_ajax_action.wpt_woo_add_cart_button,tr.product_type_external.external a.no_ajax_action.wpt_woo_add_cart_button',function(e){
            e.preventDefault();
            //var quantity = $(this).attr('data-quantity');
            var uri = $(this).attr('href');
            uri = encodeURI(uri);
            window.location = uri;
        });
        //***********************************/
        
        function footerCartAnimation(){
            $('a.wpt-view-n .wpt-bag').addClass('wpt-spin4 animate-spin');
            $('.wpt-new-footer-cart').addClass('wpt-fcart-anim');
            $('.wpt-fcart-coll-expand').addClass('animated');
        }
        function footerCartAnimationStop(){
            $('a.wpt-view-n .wpt-bag').removeClass('wpt-spin4 animate-spin');
            $('.wpt-new-footer-cart').removeClass('wpt-fcart-anim');
            $('.wpt-fcart-coll-expand').removeClass('animated');
        }

        /**
         * Add to cart button Action 
         * for Ajax add to cart
         * for Variation product
         */
        $(document.body).on('click', 'a.ajax_active.wpt_variation_product.single_add_to_cart_button.button.enabled, a.add_to_cart_button.ajax_add_to_cart, a.ajax_active.add_to_cart_button.wpt_woo_add_cart_button', function(e) {
            
            e.preventDefault();
            
            var thisButton = $(this);
            //Adding disable and Loading class
            thisButton.addClass('disabled');
            // thisButton.addClass('loading');
            
            var data = {};
            $.each( thisButton.data(), function( key, value ) {
                    data[ key ] = value;
            });

            // Trigger event.
            $( document ).trigger( 'adding_to_cart', [ thisButton, data ] );
            
            
            var thisRow = $(this).closest('.wpt_row');
            var messageBox = thisRow.find('.wpt_custom_message');
            var product_id = thisRow.data('product_id');

            var temp_number = $(this).closest('#product_id_' + product_id).data('temp_number');
            config_json = getConfig_json( temp_number ); //Added at V5.0
            var qtyElement = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' input.input-text.qty.text');
            var min_quantity = qtyElement.attr('min');//.val();
            
            if( typeof min_quantity === 'undefined' && !WPT_DATA.return_zero ){
                min_quantity = 1;
            }
            if(WPT_DATA.return_zero === '1'){
                min_quantity = 0;
            }
            //For Direct Checkout page and Quick Button Features
            var checkoutURL = WPT_DATA.checkout_url;//$('#table_id_' + temp_number).data('checkout_url');

            //For Direct cart page and Quick Button Features
            var cartURL = WPT_DATA.cart_url;//$('#table_id_' + temp_number).data('cart_url');

            //Changed at2.9
            var quantity = $(this).attr('data-quantity');
            var wpt_custom_message = $('#table_id_' + temp_number + ' table#wpt_table .wpt_row_product_id_' + product_id + ' .wpt_message .message').val();
            var variation_id = $(this).attr('data-variation_id');
            var variation = $(this).attr('data-variation');
            if(variation){
                variation = JSON.parse(variation);
            }
            if(! quantity || quantity === '0'){
                thisButton.removeClass('disabled');
                alert("Sorry! 0 Quantity");
                
                return;
            }
            footerCartAnimation();
            var Bubble = thisRow.find('.wpt_ccount');
            if(Bubble.length == 0){
                thisRow.find('a.add_to_cart_button').append('<span class="wpt_ccount wpt_ccount_' + product_id + '"><i class="wpt-spin5 animate-spin"></span>');
            }else{
                Bubble.html('<i class="wpt-spin5 animate-spin">');
            }
            var get_data = $(this).attr('href') + '&quantity=' + quantity;
            
            var additional_json = $('#table_id_' + temp_number + ' table#wpt_table tr.wpt_row_product_id_' + product_id).attr('additional_json');

            var data = {
                action:     'wpt_ajax_add_to_cart',
                variation:  variation, 
                variation_id:   variation_id,
                product_id: product_id,
                quantity:   quantity,
                wpt_custom_message: wpt_custom_message,
                additional_json: additional_json,
            };

            $.ajax({
                type: 'POST',
                url: ajax_url,// + get_data,
                data: data,
                complete: function(){
                    $( document ).trigger( 'wc_fragment_refresh' );
                    $( document ).trigger( 'cart_page_refreshed' );
                    $( document ).trigger( 'cart_totals_refreshed' );
                    $( document ).trigger( 'wc_fragments_refreshed' );
                    $('.wpt_row_product_id_' + product_id + ' .input-text').trigger('change');

                    //It's need to update checkout page Since 3.3.3.1
                    $( document.body ).trigger( 'update_checkout' );
                },
                success: function(response) {
                    // $('.wpt_edit_table').html(response); return;
                    thisButton.removeClass('disabled');
                    
                    thisButton.addClass('added');
                    messageBox.val('');
                    /**
                     * Adding Trigger for WPT
                     * At the Beggining of Success Adding to cart
                     * 
                     * Already Added to cart Successfully. It's just for front-end Version
                     * 
                     * @type type
                     */
                    var argStats = {};
                    argStats['status'] = true;
                    argStats['product_id'] = product_id;
                    argStats['variation_id'] = variation_id;
                    argStats['variation'] = variation;
                    argStats['temp_number'] = temp_number;
                    argStats['table_id'] = temp_number;
                    $(document.body).trigger('wpt_adding_to_cart',argStats);


                    $( document.body ).trigger( 'updated_cart_totals' );
                    $( document.body ).trigger( 'wc_fragments_refreshed' );
                    $( document.body ).trigger( 'wc_fragments_refresh' );
                    $( document.body ).trigger( 'wc_fragment_refresh' );
                    $( document.body ).trigger( 'added_to_cart' ); //Trigger and sent added_to_cart event
                    
                    /**
                     * If anyone want that Quantity will not return to min qty,
                     * Then use following filter
                     * add_filter( 'wpto_qty_return_quanity', '__return_false' );
                     */
                    if(WPT_DATA.return_quanity){
                        qtyElement.val(min_quantity);
                        thisButton.attr('data-quantity',min_quantity);
                    }
                    
                    WPT_NoticeBoard();

                    //Quick Button Active here and it will go Directly to checkout Page
                    if(config_json.product_direct_checkout === 'yes'){
                        window.location.href = checkoutURL;
                    }
                    //Quick cart Button Active here and it will go Directly to cart Page
                    if(config_json.product_direct_checkout === 'cart'){
                        window.location.href = cartURL;
                    }
                    
                    /**
                     * After Completely added to cart and after change of front-end change
                     * 
                     * User able to do anything by using following even
                     */
                    var argStats = {};
                    argStats['status'] = true;
                    argStats['product_id'] = product_id;
                    argStats['variation_id'] = variation_id;
                    argStats['variation'] = variation;
                    argStats['temp_number'] = temp_number;
                    argStats['table_id'] = temp_number;
                    $(document.body).trigger('wpt_added_to_cart',argStats);
                },
                error: function() {
                    alert('Failed - Unable to add by ajax');
                },
            });
        });

        function showAlert(alertMessage){
            if(typeof alertMessage == 'string'){
                var tempMsg = alertMessage.trim();
                if(tempMsg.length !== 0){
                    alert(alertMessage);
                }
            }else{
                console.log("You have inserted " + typeof alertMessage + " Variable. But should be a String.");
            }
        }
        $('body').on('click', 'a.wpt_variation_product.single_add_to_cart_button.button.disabled,a.disabled.yith_add_to_quote_request.button', function(e) {
            e.preventDefault();
            var temp_number = $(this).closest( '.wpt_action' ).data('temp_number');
            config_json = getConfig_json( temp_number );
            showAlert(config_json.no_right_combination);
            return false;
            
        });
        //Alert of out of stock 

        $('body').on('click', 'a.wpt_woo_add_cart_button.button.disabled.loading,a.disabled.yith_add_to_quote_request.button.loading', function(e) {
            e.preventDefault();
            var temp_number = $(this).closest( '.wpt_action' ).data('temp_number');
            config_json = getConfig_json( temp_number ); //Added vat V5.0
            showAlert(config_json.adding_in_progress);
            return false;

        });
        
        /**
         * On change Product Variation
         * Vairation Change
         */
        $(document.body).on('change','.wpt_varition_section',function() {
            
            var product_id = $(this).data('product_id');
            var temp_number = $(this).data('temp_number');
            config_json = getConfig_json( temp_number ); //Added vat V5.0
            var target_class = '#product_id_' + product_id;
            
            //Added at Version2.6 for Quote Request Button
            var quoted_target = 'yith_request_temp_' + temp_number + '_id_' + product_id;
            //Please choose right combination.//Message
            var targetRightCombinationMsg = config_json.right_combination_message;
            var selectAllItemMessage = config_json.select_all_items_message;
            var outOfStockMessage = config_json.out_of_stock_message;
            

            /**
             * Finally targetPriceSelectorTd has removed becuase we have creaed a new function
             * for targetting any TD of selected Table.
             * This function is targetTD(td_name)
             * @type @call;$
             */
            var targetThumbs = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' .wpt_thumbnails img'); //wpt_thumbnail_common will add after get
            var targetThumbsTd = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' .wpt_thumbnails'); //wpt_thumbnail_common will add after get
            
            var htmlStored = targetThumbsTd.attr('data-html_stored');
            var targetThumbsText,targetThumbsTextSRCSET;
            if(htmlStored !== 'added'){
               targetThumbsText = targetThumbs.attr('src'); //Added at 4.0.21 
               targetThumbsTextSRCSET = targetThumbs.attr('srcset'); //Added at 4.0.21 
               targetThumbsTd.attr('data-html',targetThumbsText);
               targetThumbsTd.attr('data-html_srcset',targetThumbsTextSRCSET);
            }
            targetThumbsTd.attr('data-html_stored','added');
            var targetThumbsSRC = targetThumbsTd.attr('data-html');
            var targetThumbsSRCSET = targetThumbsTd.attr('data-html_srcset');
            
            var variations_data = $(this).closest(target_class).data('product_variations');
            var messageSelector = $(this).children('div.wpt_message');
            var addToCartSelector = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' a.wpt_variation_product.single_add_to_cart_button');
            
            var rowSelector = $('#table_id_' + temp_number + ' #product_id_' + product_id);
            var addToQuoteSelector = $('.' + quoted_target);
            
            //Checkbox Selector
            var checkBoxSelector = $('.wpt_check_temp_' + temp_number + '_pr_' + product_id); 
            var autoCheckBoxObj = $('div.wpt_checked_table input.wpt_check_temp_' + temp_number + '_pr_' + product_id );
            
            /**
             * Targetting Indivisual TD Element from Targeted Table. Our Targeted Table will come by temp_number
             * As we have used temp_number and product_id in inside function, So this function obvisoulsy shoud
             * declear after to these variable.
             * 
             * @param {String} td_name Actually it will be column names keyword. Suppose, we want to rarget .wpt_price td, than we will use only price as perameter.
             * @returns {$}
             */
            function targetTD(td_name) {
                var targetElement = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' .wpt_' + td_name);
                return targetElement;
            }
            
            /**
             * Set Variations value to the targetted column's td
             * 
             * @param {type} target_td_name suppose: weight,description,serial_number,thumbnails etc
             * @param {type} gotten_value Suppose: variations description from targatted Object
             * @returns {undefined}
             */
            function setValueToTargetTD_IfAvailable(target_td_name, gotten_value){
                if (gotten_value !== "") {
                    targetTD(target_td_name).html(gotten_value);
                }
            }
            
            /**
             * set value for without condition
             * 
             * @param {type} target_td_name for any td
             * @param {type} gotten_value Any valy
             * @returns {undefined}
             */
            function setValueToTargetTD(target_td_name, gotten_value){
                targetTD(target_td_name).html(gotten_value);
            }
            /**
             * 
             * @param {type} target_td_name suppose: weight,description,serial_number,thumbnails etc
             * @param {type} datas_name getting data value from data-something attribute. example: <td data-product_description='This is sample'> s</td>
             * @returns {undefined}
             */
            function getValueFromOldTD(target_td_name, datas_name){
                //Getting back Old Product Description from data-product_description attribute, which is set 
                var product_descrition_old = targetTD(target_td_name).data(datas_name);
                targetTD(target_td_name).html(product_descrition_old);
            }

            var current = {};
            var additionalAddToCartUrl = '';
            //Defining No Ajax Action for when put href to variation product's add to cart button
            

            var quote_data = '';
            $(this).find('select').each(function() {
                var attribute_name = $(this).data('attribute_name');
                var attribute_value = $(this).val();
                current[attribute_name] = attribute_value;
                additionalAddToCartUrl += '&' + attribute_name + '=' + attribute_value;
            });
            
            //If not found variations Data, if not set properly
            if($.isEmptyObject(variations_data)){
                targetRightCombinationMsg = config_json.right_combination_message_alt;//"Product variations is not set Properly. May be: price is not inputted. may be: Out of Stock.";
            }

            var targetVariationIndex = 'not_found';
            var selectAllItem = true;
            try{
                variations_data.forEach(function(attributesObject, objectNumber) {
                    $.each(current,function(key,value){
                        if(value === "0"){
                            selectAllItem = false;
                        }
                    });
                    var total_right_combination=0, total_combinationable=0;
                    if(selectAllItem){
                        $.each(attributesObject.attributes,function(key,value){
                            if(value === "" || value === current[key]){
                                total_right_combination++;
                            }
                            total_combinationable++;
                        });
                        if(total_right_combination === total_combinationable){
                            targetVariationIndex = parseInt(objectNumber);

                        }

                    }else{
                        targetRightCombinationMsg = selectAllItemMessage; //"Please select all Items.";
                    }

                });

                
            }catch(e){
                //e.getMessage();
            }
            
            var price_markup_backup = targetTD('price').attr('data-price_markup');
            if( ! price_markup_backup ){
                var targetPriceHTML = targetTD('price').find('span').prop('innerHTML');
                targetTD('price').attr('data-price_markup', targetPriceHTML);
            }

            var wptMessageText = false;
            if (targetVariationIndex !== 'not_found') {
                var targetAttributeObject = variations_data[targetVariationIndex];
                additionalAddToCartUrl += '&variation_id=' + targetAttributeObject.variation_id;
                quote_data = additionalAddToCartUrl;
                //Link Adding
                additionalAddToCartUrl = addToCartSelector.data('add_to_cart_url') + additionalAddToCartUrl;
                addToCartSelector.attr('href', additionalAddToCartUrl);

                //Class adding/Removing to add to cart button
                if (targetAttributeObject.is_in_stock) {
                    disbale_enable_class();
                } else {
                    targetRightCombinationMsg = outOfStockMessage; //"Out of Stock";
                    enable_disable_class();
                }

                //Set variation Array to addToCart Button
                addToCartSelector.attr('data-variation', JSON.stringify(current)); //current_object //targetAttributeObject.attributes //It was before 2.8 now we will use 'current' object whic will come based on current_selection of variations
                addToCartSelector.attr('data-variation_id', targetAttributeObject.variation_id);
                

                rowSelector.attr('data-variation', JSON.stringify(current)); //current_object //targetAttributeObject.attributes //It was before 2.8 now we will use 'current' object whic will come based on current_selection of variations
                rowSelector.attr('data-variation_id', targetAttributeObject.variation_id);
                
                /**
                 * For add to Queto Button
                 * @since 2.6
                 * @date 20.7.2018
                 */
                addToQuoteSelector.attr('data-variation', JSON.stringify(current)); //targetAttributeObject.attributes //It was before 2.8 now we will use 'current' object whic will come based on current_selection of variations
                addToQuoteSelector.attr('data-variation_id', targetAttributeObject.variation_id);
                addToQuoteSelector.attr('data-quote_data', quote_data);
                
                /*
                //Set stock Message
                if (targetAttributeObject.availability_html === "") {
                    wptMessageText = '<p class="stock in-stock">' + config_json.table_in_stock + '</p>';
                } else {
                    wptMessageText = targetAttributeObject.availability_html;
                }
                */
                wptMessageText = targetAttributeObject.availability_html;
                //Setup Price Live
                setValueToTargetTD_IfAvailable('price', targetAttributeObject.price_html);
                
                //Set Image Live for Thumbs
                targetThumbs.attr('src', targetAttributeObject.image.gallery_thumbnail_src);
                if(targetAttributeObject.image.srcset && 'false' !== targetAttributeObject.image.srcset) {
                    targetThumbs.attr('srcset', targetAttributeObject.image.srcset);
                };

                //Set SKU live based on Variations
                setValueToTargetTD_IfAvailable('sku', targetAttributeObject.sku);
                
                // Set live stock status based onChange variation
                setValueToTargetTD_IfAvailable('stock', targetAttributeObject.availability_html);
                
                //Set Total Price display_price
                var targetQty = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' input.input-text.qty.text').val();
                if(!targetQty){
                    targetQty = 1;
                }
                var targetCurrency = targetTD('total_item').data('currency');
                var targetPriceDecimalSeparator = targetTD('total_item').data('price_decimal_separator');
                var targetPriceThousandlSeparator = targetTD('total_item').data('thousand_separator');
                var targetNumbersPoint = targetTD('total_item').data('number_of_decimal');
                var totalPrice = parseFloat(targetQty) * parseFloat(targetAttributeObject.display_price);
                totalPrice = totalPrice.toFixed(targetNumbersPoint);

                var priceFormat = WPT_DATA.priceFormat;
                
                var newPrice;

                switch (priceFormat) {
                    case 'left': // left
                        //newPrice = targetCurrency + totalPrice.replace(".",targetPriceDecimalSeparator);
                        newPrice = targetCurrency+ (totalPrice + '').replace(/\B(?=(?:\d{3})+\b)/g, targetPriceThousandlSeparator);
                        break;
                    case 'right': // right
                        //newPrice = totalPrice.replace(".",targetPriceDecimalSeparator) + targetCurrency;
                        newPrice = (totalPrice + '').replace(/\B(?=(?:\d{3})+\b)/g, targetPriceThousandlSeparator) + targetCurrency;
                        break;
                    case 'left-space': // left with space
                        //newPrice = targetCurrency + ' ' + totalPrice.replace(".",targetPriceDecimalSeparator);
                        newPrice = targetCurrency + ' ' +  (totalPrice + '').replace(/\B(?=(?:\d{3})+\b)/g, targetPriceThousandlSeparator);
                        break;
                    case 'right-space': // right with space
                        //newPrice = totalPrice.replace(".",targetPriceDecimalSeparator) + ' ' + targetCurrency;
                        newPrice =  (totalPrice + '').replace(/\B(?=(?:\d{3})+\b)/g, targetPriceThousandlSeparator) + ' ' + targetCurrency;
                        break;
                }

                var totalPriceHtml = '<strong>' + newPrice + '</strong>';

                setValueToTargetTD_IfAvailable('total_item',totalPriceHtml);
                targetTD('total').attr('data-price', targetAttributeObject.display_price);
                targetTD('total').addClass('total_general');
                
                //Set Description live based on Varitions's Description
                
                setValueToTargetTD_IfAvailable('description', targetAttributeObject.variation_description);

                var finalWeightVal = targetAttributeObject.weight * targetQty;
                finalWeightVal = finalWeightVal.toFixed(2);
                if(finalWeightVal === 'NaN'){
                    finalWeightVal = '';
                }
               targetTD('weight').attr('data-weight',targetAttributeObject.weight);
                //Set Weight,Height,Lenght,Width
                setValueToTargetTD_IfAvailable('weight', finalWeightVal);
                setValueToTargetTD_IfAvailable('height', targetAttributeObject.dimensions.height);
                setValueToTargetTD_IfAvailable('length', targetAttributeObject.dimensions.length);
                setValueToTargetTD_IfAvailable('width', targetAttributeObject.dimensions.width);
                
                //Set Variation ID at Thumbs's td   //Added at 4.0.20
                targetThumbs.attr('data-variation_id', targetAttributeObject.variation_id);
                
                
                if(!autoCheckBoxObj.is(":checked")){
                    autoCheckBoxObj.trigger('click');
                }
                updateCheckBoxCount(temp_number);
                
                //$(window).trigger('wpt_changed_variations');
                targetAttributeObject['status'] = true;
                targetAttributeObject['product_id'] = product_id;
                targetAttributeObject['temp_number'] = temp_number;
                targetAttributeObject['table_id'] = temp_number;
                try{
                    console.log(targetAttributeObject);
                    $(document.body).trigger('wpt_changed_variations',targetAttributeObject);
                }catch(error){
                    console.log("Variation ID not founded. To see error, Please console.log(error) here.");
                }
            } else {
                //Return to Previous HTML Image

                targetThumbs.attr('src', targetThumbsSRC);
                targetThumbs.attr('srcset', targetThumbsSRCSET);
                //Unset variation ID data //Added at 4.0.20
                targetThumbs.removeAttr('data-variation_id');
                
                
                
                
                addToCartSelector.attr('data-variation', false);
                addToCartSelector.attr('data-variation_id', false);

                //New add variation data at row
                
                rowSelector.attr('data-variation', false);
                rowSelector.attr('data-variation_id', false);
                
                addToQuoteSelector.attr('data-variation', false);
                addToQuoteSelector.attr('data-variation_id', false);
                addToQuoteSelector.attr('data-quote_data', false);
                
                
                wptMessageText = '<p class="wpt_warning warning">' + targetRightCombinationMsg + '</p>'; //Please choose right combination. //Message will come from targatted tables data attribute //Mainly for WPML issues


                //Class adding/Removing to add to cart button
                enable_disable_class();

                //Reset Price Data from old Price, what was First time
                targetPriceHTML = targetTD('price').attr('data-price_markup');
                targetTD('price').html(targetPriceHTML);

                getValueFromOldTD('sku', 'sku');
                setValueToTargetTD('total_item', '');
                targetTD('total_item').attr('data-price', '');
                targetTD('total_item').removeClass('total_general');

                //Getting back Old Product Description from data-product_description attribute, which is set 
                getValueFromOldTD('description', 'product_description');

                var oldBackupWeight = targetTD('weight').attr('data-weight_backup');
                targetTD('weight').attr('data-weight',oldBackupWeight);
                var oldWeightVal = oldBackupWeight * targetQty;
                //Getting Back Old Weight,Lenght,Width,Height
                setValueToTargetTD_IfAvailable('weight', oldWeightVal);
                getValueFromOldTD('length', 'length');
                getValueFromOldTD('width', 'width');
                getValueFromOldTD('height', 'height');
                
                if(autoCheckBoxObj.is(":checked")){
                    autoCheckBoxObj.prop("checked", false);;
                }
                updateCheckBoxCount(temp_number);
                
                var argStats= {};
                argStats['status'] = false;
                argStats['product_id'] = product_id;
                argStats['temp_number'] = temp_number;
                argStats['table_id'] = temp_number;
                $(document.body).trigger('wpt_changed_variations',argStats);
            }
            //Set HTML Message to define div/box
            messageSelector.html(wptMessageText);
            
            function enable_disable_class() {
                addToCartSelector.removeClass('enabled');
                addToCartSelector.addClass('disabled');
                
                rowSelector.removeClass('enabled');
                rowSelector.addClass('disabled');
                
                /**
                 * For Add to Quote
                 */
                addToQuoteSelector.removeClass('enabled');
                addToQuoteSelector.addClass('disabled');
                
                checkBoxSelector.removeClass('enabled');
                checkBoxSelector.addClass('disabled');

            }
            function disbale_enable_class() {
                addToCartSelector.removeClass('disabled');
                addToCartSelector.addClass('enabled');
                
                rowSelector.removeClass('disabled');
                rowSelector.addClass('enabled');
                
                /**
                 * For Add To Quote
                 */
                addToQuoteSelector.removeClass('disabled');
                addToQuoteSelector.addClass('enabled');

                checkBoxSelector.removeClass('disabled');
                checkBoxSelector.addClass('enabled');
            }
            
        });
        
        $('.wpt_varition_section').each(function(){
            var current_value = $(this).children('select').val();
            if(current_value !== '0'){
                $(this).trigger('change');
            }
        });

        /**
         * Working for Checkbox of our Table
         */
        $('body').on('click', 'input.wpt_tabel_checkbox.wpt_td_checkbox.disabled', function(e) {
            e.preventDefault();
            var temp_number = $(this).data('temp_number');
            config_json = getConfig_json( temp_number ); //Added vat V5.0
            showAlert(config_json.sorry_plz_right_combination);
            return false;
        });

        /**
         * Add to cart All selected
         * all selected product add to cart from here
         */
        $('div.normal_table_wrapper a.button.add_to_cart_all_selected').click(function() {
            footerCartAnimation();
            var temp_number = $(this).data('temp_number');
            var allMessageBox = $('#table_id_' + temp_number + ' .wpt_custom_message');
            config_json = getConfig_json( temp_number ); 
            var checkoutURL = WPT_DATA.checkout_url;
            var cartURL = WPT_DATA.cart_url;
            //Add Looading and Disable class 
            var currentAllSelectedButtonSelector = $('#table_id_' + temp_number + ' a.button.add_to_cart_all_selected');
            var tableWrapperTag = $('#table_id_' + temp_number + ' .wpt_table_tag_wrapper');
            
            currentAllSelectedButtonSelector.addClass('disabled');
            currentAllSelectedButtonSelector.addClass('loading');
            tableWrapperTag.addClass('wpt-ajax-loading');

            var add_cart_text = $('#table_id_' + temp_number).data('basic_settings').add_to_cart;

            //Getting Data from all selected checkbox
            var products_data = {};
            var itemAmount = 0;
            
            $('#table_id_' + temp_number + ' input.enabled.wpt_tabel_checkbox.wpt_td_checkbox:checked').each(function() {
                var thisRow = $(this).closest('tr.wpt-row');
                var product_id = $(this).data('product_id');
                var thisButton = $('tr.wpt_row_product_id_' + product_id + ' wpt_action a.button.wpt_woo_add_cart_button');
                thisButton.removeClass('added');
                thisButton.addClass( 'disabled' );
                thisButton.addClass( 'loading' );
                
                //added at 4
                var qtyElement = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' input.input-text.qty.text');
                var min_quantity = qtyElement.attr('min');
                if(min_quantity === '0' || typeof min_quantity === 'undefined'){
                    min_quantity = 1;
                }
                
                var currentAddToCartSelector = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' .wpt_action a.wpt_woo_add_cart_button');
                var currentCustomMessage = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' .wpt_message .message').val();
                var additional_json = thisRow.attr('additional_json');
                var currentVariaionId = thisRow.attr('data-variation_id');//currentAddToCartSelector.data('variation_id');

                var currentVariaion;
                try{
                        currentVariaion = $.parseJSON(thisRow.attr('data-variation'));
                }catch(e){
                        //Get error message
                }


                var currentQantity = $('#table_id_' + temp_number + ' table#wpt_table .product_id_' + product_id ).attr('data-quantity');
                currentQantity = parseFloat(currentQantity);
                if( currentQantity <= 0 ){
                    return;
                }
                //var currentQantity = $('#table_id_' + temp_number + ' table#wpt_table .wpt_row_product_id_' + product_id + ' .wpt_quantity .quantity input.input-text.qty.text').val();
                products_data[product_id] = {
                    product_id: product_id, 
                    quantity: currentQantity, 
                    variation_id: currentVariaionId, 
                    variation: currentVariaion,
                    wpt_custom_message: currentCustomMessage,
                    additional_json:additional_json
                };
                var items = $('#table_id_' + temp_number + ' tr#product_id_' + product_id).attr('data-quantity');
                items = parseFloat(items);
                if(items <= 0){
                    return;
                }
                
                var itemCountSystem = config_json.item_count;
                if(typeof itemCountSystem !== 'undefined' && itemCountSystem === 'all'){
                    

                    
                    itemAmount += items;
                }else{
                    itemAmount++;//To get Item Amount
                } 

            });

            //Return false for if no data
            if (itemAmount < 1) {
                currentAllSelectedButtonSelector.removeClass('disabled');
                currentAllSelectedButtonSelector.removeClass('loading');
                tableWrapperTag.removeClass('wpt-ajax-loading');
                footerCartAnimationStop();
                showAlert(config_json.please_choose_items);
                return false;
            }

            uncheckAllCheck(temp_number);
            currentAllSelectedButtonSelector.html(add_cart_text + ' [ ' + config_json.loading_more_text + ' ]');
            $.ajax({
                type: 'POST',
                url: ajax_url,
                data: {
                    action: 'wpt_ajax_mulitple_add_to_cart',
                    products: products_data,
                },
                complete: function(){
                    $( document ).trigger( 'wc_fragments_refreshed' );

                    //It's need to update checkout page Since 3.3.3.1
                    $( document.body ).trigger( 'update_checkout' );
                },
                success: function( response ) {
                    $( document.body ).trigger( 'updated_cart_totals' );
                    $( document.body ).trigger( 'wc_fragments_refreshed' );
                    $( document.body ).trigger( 'wc_fragments_refresh' );
                    $( document.body ).trigger( 'wc_fragment_refresh' );
                    currentAllSelectedButtonSelector.html(add_cart_text + ' [ ' + itemAmount + ' ' + config_json.add2cart_all_added_text + ' ]');
                    if(config_json.all_selected_direct_checkout === 'yes'){
                        window.location.href = checkoutURL;
                        return;
                    }else if(config_json.all_selected_direct_checkout === 'cart'){
                        window.location.href = cartURL;
                        return;                       
                    }
                    
                    currentAllSelectedButtonSelector.removeClass('disabled');
                    currentAllSelectedButtonSelector.removeClass('loading');
                    tableWrapperTag.removeClass('wpt-ajax-loading');
                    
                    WPT_NoticeBoard();
                     
                    //Added at v4.0.11
                    $('#table_id_' + temp_number + ' input.enabled.wpt_tabel_checkbox.wpt_td_checkbox:checked').each(function() {
                        var product_id = $(this).data('product_id');

                        var qtyElement,min_quantity;
                        qtyElement = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' input.input-text.qty.text');
                        min_quantity = qtyElement.attr('min');
                        if(min_quantity === '0' || typeof min_quantity === 'undefined'){
                            min_quantity = 1;
                        }
                        qtyElement.val(min_quantity);//Added at v4
                        var messageBox = $(this).closest('.wpt-row').find('.wpt_custom_message');
                        messageBox.val('');
                    });
                    
                    
                    // allMessageBox.val('');
                    
                },
                error: function() {
                    alert('Failed');
                },
            });
        });
        

        $('body').append('<style>div.wpt-footer-cart-wrapper>a:after,div.wpt-footer-cart-wrapper>a{background-color: ' + footer_bg_color + ';}</style>');
        
        /**
         * set Fragments Refresh
         * @param {type} response
         * @returns {undefined}
         */
        function setFragmentsRefresh( response ){
            var FooterCart = $('div.wpt-footer-cart-wrapper');
            
            $('span.wpt-cart-remove').remove();
            $('span.wpt_ccount').html('');
            $( '.wpt_action>a.wpt_woo_add_cart_button' ).removeClass( 'added' );
            if(typeof response !== 'undefined'){
                    var fragments = response.fragments;
                    /******IF NOT WORK CART UPDATE, JUST ADD A RIGHT SLASH AT THE BEGINING OF THIS LINE AND ACTIVATE BELLOW CODE***********/
                    if ( fragments ) {
                        $.each( fragments, function( key, value ) {
                            if('string' === typeof key && typeof $( key ) === 'object'){
                                $( "div.wpt-wrap " + key ).replaceWith( value );

                            }
                        });
                    }
                    //******************/
                    if(typeof fragments.wpt_per_product !== 'string' && typeof fragments.wpt_per_product === 'undefined'){
                        return false;
                    }
                    
                    var wpt_per_product = fragments.wpt_per_product;
                    try{
                            wpt_per_product = $.parseJSON(wpt_per_product);
                    }catch(e){
                        wpt_per_product = false;
                            //Get error message
                    }

                    if( wpt_per_product && typeof wpt_per_product  === 'object'){
                        
                    if(footer_cart !== 'always_hide'){
                            FooterCart.fadeIn('slow');
                        }
                        
                        $.each( wpt_per_product, function( key, value ) {
                            $( '.wpt_row_product_id_' + key + ' .wpt_action button.single_add_to_cart_button>.wpt_ccount.wpt_ccount_' + key ).remove();
                            $( '.wpt_row_product_id_' + key + ' .wpt_action .wpt_woo_add_cart_button' ).addClass( 'added' );
                            if(!$('.wpt_ccount.wpt_ccount_' + key ).length){
                                $( '.wpt_row_product_id_' + key + ' .wpt_action .wpt_woo_add_cart_button' ).append( '<span class="wpt_ccount wpt_ccount_' + key + '">' + value + '</span>' );
                                $( '.wpt_row_product_id_' + key + ' .single_add_to_cart_button' ).append( '<span class="wpt_ccount wpt_ccount_' + key + '">' + value + '</span>' );
                            }
                            if( $('.wpt-cart-remove.wpt-cart-remove-' + key ).length < 1){

                                $( '.wpt_row_product_id_' + key + ' .wpt_action .wpt_woo_add_cart_button' ).after( '<span data-product_id="' + key + '" class="wpt-cart-remove wpt-cart-remove-' + key + '"></span>' );
                                $( '.wpt_row_product_id_' + key + ' .single_add_to_cart_button' ).after( '<span data-product_id="' + key + '" class="wpt-cart-remove wpt-cart-remove-' + key + '"></span>' );
                            }
                        });
                    }else{
                        if(footer_cart === 'hide_for_zerro'){
                            FooterCart.fadeOut('slow');
                        }
                        
                    }
                    $('div.wpt-footer-cart-wrapper>a').css('background-color',footer_bg_color);
                }
                return false;
        }
        
        /**
         * Delay One Second Delay
         * To cal after some time, need this function
         * Althou its name onesecond delay, but default is 500ms delay
         * 
         * @param {type} f
         * @param {type} delay
         * @returns {Function} 
         */
        function oneSecondDelay(f, delay){
            var timer = null;
            return function(){
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = window.setTimeout(function(){
                    f.apply(context, args);
                },
                delay || 500);
            };
        }
        //Neeeeeeeeeeeeeed Configuration 
        $('.query_box_direct_value').keyup(oneSecondDelay(function(){
            var thisID = $(this).attr('id');
            var temp_number = thisID.replace('single_keyword_','');
            $('#wpt_query_search_button_' + temp_number).trigger('click');
        }));
        $('body').on('change','.search_select',function(){
            var thisID = $(this).parents('.wpt-wrap').attr('id');
            var temp_number = thisID.replace('table_id_','');
           $('#wpt_query_search_button_' + temp_number).trigger('click');
        });
        $('body').on('change,focus','.query_box_direct_value',function(){
            var thisID = $(this).parents('.wpt-wrap').attr('id');
            var temp_number = thisID.replace('table_id_','');
           $('#wpt_query_search_button_' + temp_number).trigger('click');
        });
        
        $('body').on('change','select.query_box_direct_value',function(){
            var thisID = $(this).parents('.wpt-wrap').attr('id');
            var temp_number = thisID.replace('table_id_','');
           $('#wpt_query_search_button_' + temp_number).trigger('click');
        });
        

        
        /**
         * Search Box Query and Scripting Here
         * @since 1.9
         * @date 9.6.2018 d.m.y
         */
        
        $( 'body' ).on('click','button.wpt_query_search_button,button.wpt_load_mores', function(){
            
            var temp_number = $(this).data('temp_number');
            config_json = getConfig_json( temp_number ); //Added vat V5.0
            //Added at 2.7

            var loadingText = config_json.loading_more_text;// 'Loading...';
            
            var searchText = config_json.search_button_text;
            var loadMoreText = config_json.load_more_text;//'Load More';
            var thisButton = $(this);
            var actionType = $(this).data('type');
            var load_type = $(this).data('load_type');
            
            thisButton.html(loadingText);

            
            var targetTable = $('#table_id_' + temp_number + ' table#wpt_table');
            var targetTableArgs = targetTable.attr( 'data-data_json' );
             targetTableArgs = JSON.parse(targetTableArgs);
            var targetTableArgsBackup = targetTable.data( 'data_json' );

            var targetTableBody = $('#table_id_' + temp_number + ' table#wpt_table>tbody');
            var pageNumber = targetTable.attr( 'data-page_number' );
            if( actionType === 'query' ){
                pageNumber = 1;
            }
            
            
            
            var key,value;
            var directkey = {};
            $('#search_box_' + temp_number + ' .search_single_direct .query_box_direct_value').each(function(){
                
                key = $(this).data('key');
                value = $(this).val();
                //if(value != "" && value != null){
                    directkey[key] = value;
                //}
            });
            
            var texonomies = {};
            value = false;
            $('#search_box_' + temp_number + ' .search_select.query').each(function(){
                
                key = $(this).data('key');
                var value = $(this).val();//[];var tempSerial = 0;
                if(value != ""){
                    texonomies[key] = value;
                }
            });
            var custom_field = {};
            var multiple_attr = {};
            value = false;

            $('#search_box_' + temp_number + ' .search_select.cf_query').each(function(){
                var attr = $(this).attr('multiple');
                
                key = $(this).data('key');
                var value = $(this).val();//[];var tempSerial = 0;
                if(value != ""){
                    custom_field[key] = value;
                    multiple_attr[key] = attr;
                }
            });
            

            //Generating Taxonomy for Query Args inside wp_query
            var tax_query = {};
            Object.keys(texonomies).forEach(function(aaa,bbb){
                var key = aaa + '_IN';
                if(texonomies[aaa] !== null && Object.keys(texonomies[aaa]).length > 0){
                    tax_query[key] = {
                        taxonomy: aaa,
                        field:  'id',  
                        terms:  texonomies[aaa],
                        operator:   'IN'
                    };
                }else{
                    targetTableArgs.args.tax_query[key] =targetTableArgsBackup.args.tax_query[key];
                } 
            });
            if(Object.keys(texonomies).length > 0){
                Object.assign(targetTableArgs.args.tax_query,tax_query);
            }else{
                targetTableArgs.args.tax_query = targetTableArgsBackup.args.tax_query;
            }

            //Generating Custom Field/Meqa Query for Query Args inside wp_query
            var final_custom_field = {};
            Object.keys(custom_field).forEach(function(key,bbb){

                if(Object.keys(custom_field[key]).length > 0){ //custom_field[key] !== null && 
                    var compare = multiple_attr[key];
                    
                    if(! compare){
                            final_custom_field[key] = {
                                    key: key,  
                                    value:  custom_field[key],
                                    compare: 'LIKE'
                            };   
                    }else{
                            final_custom_field[key] = {
                                    key: key,  
                                    value:  custom_field[key]
                            }; 
                    }
                }else{
                    targetTableArgs.args.meta_query[key] =targetTableArgsBackup.args.meta_query[key];
                } 
            });
            if(Object.keys(custom_field).length > 0){
                var backupMetaQuery = targetTableArgsBackup.args.meta_query;
                Object.keys(backupMetaQuery).forEach(function(key,index){
                    final_custom_field[key] = backupMetaQuery[key];
                });
                targetTableArgs.args.meta_query = final_custom_field;
            }else{
                targetTableArgs.args.meta_query = targetTableArgsBackup.args.meta_query;
            }

            //Display Loading on before load
            targetTableBody.prepend("<div class='wpt_loader_text'>" + config_json.loading_more_text + "</div>"); //Laoding..
            var data = {
                action:         'wpt_query_table_load_by_args',
                temp_number:    temp_number,
                directkey:      directkey,
                targetTableArgs:targetTableArgs, 
                texonomies:     texonomies,
                pageNumber:     pageNumber,
                load_type:     load_type,
                custom_field:    custom_field,
            };
            var whold_data = JSON.stringify(data);
            $('#table_id_' + temp_number + ' .wpt_table_pagination').attr('data-whole_data', whold_data);
            $(document.body).trigger('wpt_query_progress',targetTableArgs, data);
            $.ajax({
                type: 'POST',
                url: ajax_url,// + get_data,
                data: data,
                complete: function(){
                    $( document ).trigger( 'wc_fragments_refreshed' );
                    arrangingTDContentForMobile(); //@Since 5.2
                    loadMiniFilter(); //@Since 4.8
                    fixAfterAjaxLoad();
                    $('div.wpt_loader_text').remove();
                    
                    /**
                     * Link Generating here, based on Query
                     * 
                     * @type String
                     * @since 2.8.9
                     */
                    var extra_link_tax_cf = "";
                    if( !$.isEmptyObject(texonomies)){
                        extra_link_tax_cf = "tax=" + JSON.stringify(targetTableArgs.args.tax_query)
                    }
                    if( !$.isEmptyObject(custom_field)){
                        extra_link_tax_cf = "meta=" + JSON.stringify(targetTableArgs.args.meta_query)
                    }
                    
                    //Set a Attr value in table tag, If already queried
                    $('#table_id_' + temp_number + ' table.wpt_product_table').attr('data-queried','true');
                    /**
                     * Generate here where query
                     */
                    generate_url_by_search_query(temp_number, extra_link_tax_cf);
                    $('#wpt_query_reset_button_' + temp_number).fadeIn('medium');
                    /**
                     * Trigger on this event, when search will be completed
                     * 
                     * @since 2.8.9
                     */
                    $(document.body).trigger('wpt_query_done',targetTableArgs);
                },
                success: function(data) {
                    
                    $('.table_row_loader').remove();
                    
                    if( actionType === 'query' ){
                        $('#wpt_load_more_wrapper_' + temp_number).remove();
                        targetTableBody.html( data );

                        
                        $('#table_id_' + temp_number + ' .wpt_table_tag_wrapper .wpt_product_not_found').remove();
                        if(data.match('wpt_product_not_found')){
                            targetTableBody.html("");
                            $('#table_id_' + temp_number + ' .wpt_table_tag_wrapper').append(data);
                        }
                        
                        var $data = {
                                action:         'wpt_ajax_paginate_links_load',
                                temp_number:    temp_number,
                                directkey:      directkey,
                                targetTableArgs:targetTableArgs, 
                                texonomies:     texonomies,
                                pageNumber:     pageNumber,
                                load_type:     load_type,
                            };
                        loadPaginationLinks($data,temp_number);
                        
                        targetTable.after('<div id="wpt_load_more_wrapper_' + temp_number + '" class="wpt_load_more_wrapper ' + config_json.disable_loading_more + '"><button data-temp_number="' + temp_number + '" data-type="load_more" class="button wpt_load_more">' + loadMoreText + '</button></div>');
                        targetTable.addClass('wpt_overflow_hiddent');
                        thisButton.html(searchText);
                    }
                    if( actionType === 'load_more' ){
                        if(!data.match('wpt_product_not_found')){ //'Product not found' //Products not found!
                            targetTableBody.append( data );
                            thisButton.html(loadMoreText);
                            
                            //Actually If you Already Filter, Than table will load with Filtered.
                            filterTableRow(temp_number);
                            
                        }else{
                            $('#wpt_load_more_wrapper_' + temp_number).remove();
                            targetTable.removeClass('wpt_overflow_hiddent');
                            showAlert(config_json.no_more_query_message);//"There is no more products based on current Query."
                        }
                        
                    }
                    removeCatTagLings();//Removing Cat,tag link, if eanabled from configure page
                    pageNumber++; //Page Number Increasing 1 Plus
                    targetTable.attr('data-page_number',pageNumber);
                },
                error: function() {
                    $(document.body).trigger('wpt_query_failed',targetTableArgs);
                    console.log("Error On Ajax Query Load. Please check console. - wpt_query_search_button");
                },
            });
            
            emptyInstanceSearchBox(temp_number);//When query finished, Instant search box will empty
            
        });
        
        
        /**
         * Link Generator Based On Query String
         * 
         * @since 2.8.9
         * @param {type} table_id
         * @returns {undefined}
         */
        function generate_url_by_search_query( table_id = 0, extra = '' ){
            config_json = getConfig_json( table_id ); //Added vat v2.9.3.0
            
            if(config_json.query_by_url !== '1'){
                return;
            }
            
            var key,value;
            var link = window.location.origin + window.location.pathname + "?table_ID=" + table_id + "&";
            $('.query_box_direct_value').each(function(){
                key = $(this).attr('data-key');
                if(key === 's'){
                    key = 'search_key';
                }
                value = $(this).val();
                if(value !== ''){
                    link += key + "=" + value + "&";
                }
                
            });
            var page_number = $('#table_id_' + table_id + ' table').attr('data-page_number');
            page_number = parseInt( page_number ) - 1;
            link += "paged=" + page_number;
            $('a.search_box_reset').show();
            link += extra;
            //window.location.href = link;
            window.history.pushState('data', null, link.replace(/(^&)|(&$)/g, ""));
        }
        
        // var extra_link_tax_cf = "";
        // if( !$.isEmptyObject(texonomies)){
        //     extra_link_tax_cf = "tax=" + JSON.stringify(targetTableArgs.args.tax_query)
        // }
        // if( !$.isEmptyObject(custom_field)){
        //     extra_link_tax_cf = "meta=" + JSON.stringify(targetTableArgs.args.meta_query)
        // }
        
        //Set a Attr value in table tag, If already queried
        // $('#table_id_' + temp_number + ' table.wpt_product_table').attr('data-queried','true');
        /**
         * Generate here where query
         */
        // generate_url_by_search_query(temp_number, extra_link_tax_cf);

        $(document.body).on('wpt_ajax_load_data',function(Event,data){
            var table_id = data.table_id;

            var page_number = data.others.page_number;
            var extra_link_tax_cf = "";
            if( typeof data.args.tax_query === 'object' && !$.isEmptyObject(data.args.tax_query)){
                extra_link_tax_cf = "&tax=" + JSON.stringify(data.args.tax_query)
            }
            if( typeof data.args.meta_query === 'object'  && !$.isEmptyObject(data.args.meta_query)){
                extra_link_tax_cf = "&meta=" + JSON.stringify(data.args.meta_query)
            }
            generate_url_by_search_query(table_id, extra_link_tax_cf);

            
        });

        
        function loadPaginationLinks($data,temp_number){
            var targetTable = $('#table_id_' + temp_number + ' table#wpt_table');
            $.ajax({
                    type: 'POST',
                    url: ajax_url,// + get_data,
                    data: $data,
                    success: function(paginate_data){
                        var thisPagiWrappers = $('#table_id_' + temp_number + ' .wpt_table_pagination');
                        
                        thisPagiWrappers.html(paginate_data);
                        changeSpanToAPagi();
                        var newjsonData = $('#table_id_' + temp_number + ' mypagi').attr('myjson');
                        // var thisNewPagiWrappers = $('#table_id_' + temp_number + ' .wpt_table_pagination').attr('data-whole_data');
                        
                        // thisNewPagiWrappers = JSON.parse(thisNewPagiWrappers);
                        // thisNewPagiWrappers = thisNewPagiWrappers.targetTableArgs;
                        
                        targetTable.attr( 'data-data_json', newjsonData );
                        thisPagiWrappers.removeClass('pagination_loading');
                    }
                });
        }
        
        /**
         * Handleling Filter Features
         */
        $('body').on('change','select.filter_select',function(){
            var temp_number = $(this).data('temp_number');

            /**
             * I did it for specially Variable page's variation table.
             * If found .wpt-variable-product-options then then we will remove auto current page filter
             * because, this time we will load from page reload.
             */
            var paginatedMiniFilter = $('.wpt-variable-product-options').length;
            if( paginatedMiniFilter > 0 ){
                return;
            }
            filterTableRow(temp_number);
            
        });
        
        $('body').on('click','a.wpt_filter_reset',function(e){
            e.preventDefault();
            var temp_number = $(this).data('temp_number');
            $('#table_id_' + temp_number + ' select.filter_select').each(function(){
                $(this).prop('selectedIndex', 0);
                //$(this).children().first().attr('selected','selected');
            });
            $('#table_id_' + temp_number + ' select.filter_select').trigger('change');

            $('.wpt-my-pagination-' + temp_number).show();//wpt_filter_reset
        });
        
        
        function filterTableRow(temp_number){
            emptyInstanceSearchBox(temp_number);
            //Uncheck All for each Change of Filter
            uncheckAllCheck(temp_number);
            
            //Checking FilterBox
            var filterBoxYesNo = $('#table_id_' + temp_number + ' .wpt-mini-filter').html();

            /**
             * Uncheck All, If any change on filter button
             * @version 2.0
             */
            let tableBodyobj = $('#table_id_' + temp_number + ' table#wpt_table tbody');
            
            var ClassArray =[];
            var serial = 0;
            $('#table_id_' + temp_number + ' .wpt-mini-filter select.filter_select').each(function(){
                var currentClass = $(this).val();

                if(currentClass !==''){
                    ClassArray[serial] = '.' + currentClass;
                    serial++;
                }
            });
            var finalClassSelctor = '.filter_row' + ClassArray.join(''); //Test will keep
            var hideAbleClass = '#table_id_' + temp_number + ' table tr.wpt_row';
        
            let foundRow = $(finalClassSelctor);
            let foundFirstRow = foundRow.first();
            let colSpanCount = tableBodyobj.find('tr').first().find('td.td_or_cell').length;
            let foundRowCount = foundRow.length;
            let notFundMsg = config_json.product_not_founded;
            
            if(foundRowCount > 0){
                $('.wpt-my-pagination-' + temp_number).hide();//wpt_filter_reset
            }
            //if not found available from before, we will remove it first.
            $('#table_id_' + temp_number + ' table#wpt_table tbody tr.product-not-found-tr').remove();
            if(foundRowCount < 1){
                let newRotHtml = "<tr class='product-not-found-tr'><td colspan='" + colSpanCount + "'><div class='wpt_product_not_found'>" + notFundMsg + "</div></td></tr>";
                $('#table_id_' + temp_number + ' table#wpt_table tbody').append(newRotHtml)
            }
            //here was remove notFound on else. we remove it becuase, we have added at the begining always
           

           if( filterBoxYesNo ){
                $(hideAbleClass + ' wpt_check input.enabled.wpt_tabel_checkbox').removeClass('wpt_td_checkbox');
                $(hideAbleClass).css('display','none');
                $(hideAbleClass).removeClass('visible_row');

                $(finalClassSelctor).fadeIn();
                $(finalClassSelctor).addClass('visible_row');
                $(finalClassSelctor + ' wpt_check input.enabled.wpt_tabel_checkbox').addClass('wpt_td_checkbox');
            }
            
            /**
             * Updating Check Founting Here
             */
            updateCheckBoxCount(temp_number);
        }
        
        /**
         * Mainly for shortmessage field
         */
        $('body').on('change', '.wpt_row .message', function() {
                var temp_number = $(this).parents('tr.wpt_row').data('temp_number');
                var msg = $(this).val();
                var product_id = $(this).parents('tr').data('product_id');
            
                var thisRow = '#table_id_' + temp_number + ' tr.product_id_' + product_id;
                $( thisRow + ' .message').val(msg);
        });
        
        /**
         * keyup is actually for total price live changing 
         * When someone type quantity then total price will change live 
         * if($('#table_id_' + table_id + ' .wpt_total').length > 0){
                inputBoxChangeHandle();
            }
         */
        // $(document).on('keyup','.wpt_row input.input-text.qty.text', inputBoxChangeHandle);
        $(document).on('keyup','.wpt_row input.input-text.qty.text', oneSecondDelay(inputBoxChangeHandle,1500));
 
        $(document.body).on('change', '.wpt_row input.input-text.qty.text', inputBoxChangeHandle);
        function inputBoxChangeHandle() {

            var temp_number = $(this).parents('tr.wpt_row').data('temp_number');
            var Qty_Val = $(this).val();
            var product_id = $(this).parents('tr').data('product_id');
        
            var thisRow = '#table_id_' + temp_number + ' tr.product_id_' + product_id;
            var outofstockVal = $(thisRow).hasClass("stock_status_outofstock");
            if(outofstockVal){
                Qty_Val = 0;
            }

            // $( thisRow + ' input.input-text.qty.text').val(Qty_Val); // input.input-text.qty.text
            $( thisRow ).attr('data-quantity', Qty_Val);
            $( thisRow + ' .wpt_action a.wpt_woo_add_cart_button').attr('data-quantity', Qty_Val);
            $( thisRow + ' .wpt_action a.add_to_cart_button').attr('data-quantity', Qty_Val);
            $( thisRow + ' .wpt_buy_link a.add_to_cart_button').attr('data-quantity', Qty_Val);
            var Item_URL = '?add-to-cart=' + product_id + '&quantity=' + Qty_Val;
            $( thisRow + ' .wpt_action a.add_to_cart_button').attr('href', Item_URL);
            var targetTotalSelector = $('#table_id_' + temp_number + ' .product_id_' + product_id + ' .wpt_total_item.total_general');
             
        
            var targetWeightSelector = $('#table_id_' + temp_number + ' .product_id_' + product_id + ' .weight-box');
            var targetWeightAttr = $('#table_id_' + temp_number + ' .product_id_' + product_id + ' .weight-box').attr('data-weight');
            
            var totalWeight =  parseFloat(targetWeightAttr) * parseFloat(Qty_Val);
          
            totalWeight = totalWeight.toFixed(2);
            if(totalWeight === 'NaN'){
            totalWeight = '';
            }
            targetWeightSelector.html(totalWeight);
            
            var targetTotalStrongSelector = $('#table_id_' + temp_number + ' .product_id_' + product_id + ' .wpt_total_item.total_general strong');
            var targetPrice = targetTotalSelector.attr('data-price');
            var targetCurrency = targetTotalSelector.data('currency');
            var targetPriceDecimalSeparator = targetTotalSelector.data('price_decimal_separator');
            var targetPriceThousandlSeparator = targetTotalSelector.data('thousand_separator');

            var targetNumbersPoint = targetTotalSelector.data('number_of_decimal');
            
            var totalPrice = parseFloat(targetPrice) * parseFloat(Qty_Val);
            
            totalPrice = totalPrice.toFixed(targetNumbersPoint);
            var priceFormat = WPT_DATA.priceFormat;
           
           totalPrice = totalPrice.replace('.', targetPriceDecimalSeparator);
            var newPrice;
            switch (priceFormat) {
            case 'left': // left
                //newPrice = targetCurrency + totalPrice.replace(".",targetPriceDecimalSeparator);
                newPrice = targetCurrency+ (totalPrice + '').replace(/\B(?=(?:\d{3})+\b)/g, targetPriceThousandlSeparator);
                break;
            case 'right': // right
                //newPrice = totalPrice.replace(".",targetPriceDecimalSeparator) + targetCurrency;
                newPrice = (totalPrice + '').replace(/\B(?=(?:\d{3})+\b)/g, targetPriceThousandlSeparator) + targetCurrency;
                break;
            case 'left-space': // left with space
                //newPrice = targetCurrency + ' ' + totalPrice.replace(".",targetPriceDecimalSeparator);
                newPrice = targetCurrency + ' ' +  (totalPrice + '').replace(/\B(?=(?:\d{3})+\b)/g, targetPriceThousandlSeparator);
                break;
            case 'right-space': // right with space
                //newPrice = totalPrice.replace(".",targetPriceDecimalSeparator) + ' ' + targetCurrency;
                newPrice =  (totalPrice + '').replace(/\B(?=(?:\d{3})+\b)/g, targetPriceThousandlSeparator) + ' ' + targetCurrency;
                break;
            }

            $('.yith_request_temp_' + temp_number + '_id_' + product_id).attr('data-quantity', Qty_Val);
            $('#table_id_' + temp_number + ' .product_id_' + product_id + ' .wpt_total_item.total_general strong').html(newPrice);
            // $('tr.stock_status_outofstock .wpt_total_item.total_general strong').html("00");
            //$(target_row_id + ' a.add_to_cart_button').attr('data-quantity', Qty_Val); //wpt_total_item total_general
            
            updateCheckBoxCount(temp_number);
        }

        upateGlobalCheckboxCount();
        function upateGlobalCheckboxCount(){
            
            var add_cart_text = $('.wpt-wrap').data('basic_settings').add_to_cart;
            var currentAllSelectedButtonSelector = $('body a.wpt-global-added-to-cart>span');
            var itemAmount = 0;
            var itemCountSystem = config_json.item_count;
            
            
            $('.wpt-wrap input.enabled.wpt_tabel_checkbox:checked').each(function() { //wpt_td_checkbox
                var product_id = $(this).data('product_id');
                var items = $('tr#product_id_' + product_id).attr('data-quantity');
                items = parseFloat(items);
                if(items <= 0){
                    return;
                }
                if(typeof itemCountSystem !== 'undefined' && itemCountSystem === 'all'){
                    

                    
                    itemAmount += items;
                }else{
                    itemAmount++;//To get Item Amount
                }
                
            });
            var checkBoxWrapper = $('a.wpt-global-added-to-cart');
            if(itemAmount > 0){
                checkBoxWrapper.fadeIn();
                checkBoxWrapper.removeClass('wpt-added-to-cart-empty');
            }else{
                checkBoxWrapper.fadeOut();
                checkBoxWrapper.addClass('wpt-added-to-cart-empty');
            }
            var itemText = config_json.items;//'Items';

            if (itemAmount === 1 || itemAmount === 0) {
                itemText = config_json.item;//'Item';
            }
            if ( itemAmount > 0 || currentAllSelectedButtonSelector.hasClass('already_counted') ) {
                currentAllSelectedButtonSelector.addClass('already_counted');
                currentAllSelectedButtonSelector.html( add_cart_text + ' [ ' + itemAmount + ' ' + itemText + ' ]');
            }

        }
        function updateCheckBoxCount(temp_number){
            upateGlobalCheckboxCount();
            config_json = getConfig_json( temp_number ); //Added vat V5.0
            var add_cart_text = $('#table_id_' + temp_number).data('basic_settings').add_to_cart;
            var currentAllSelectedButtonSelector = $('#table_id_' + temp_number + ' a.button.add_to_cart_all_selected');
            var itemAmount = 0;
            var itemCountSystem = config_json.item_count;
            
            $('table.wpt_temporary_table_' + temp_number + ' tr.wpt_row').removeClass('wpt_selected_tr');
            
            $('#table_id_' + temp_number + ' input.enabled.wpt_tabel_checkbox:checked').each(function() { //wpt_td_checkbox
                var product_id = $(this).data('product_id');
                $('table.wpt_temporary_table_' + temp_number + ' tr.wpt_row#product_id_' + product_id).addClass('wpt_selected_tr');
                var items = $('#table_id_' + temp_number + ' tr#product_id_' + product_id).attr('data-quantity');
                items = parseFloat(items);
                if(items <= 0){
                    //$('#table_id_' + temp_number + ' tr#product_id_' + product_id + ' input:checkbox').attr('checked',false);
                    return;
                }
                if(typeof itemCountSystem !== 'undefined' && itemCountSystem === 'all'){
                    

                    
                    itemAmount += items;
                }else{
                    itemAmount++;//To get Item Amount
                }
                
            });
            var checkBoxWrapper = $('#table_id_' + temp_number + ' .all_check_header_footer');
            if(itemAmount > 0){
                checkBoxWrapper.addClass('product-selected');
            }else{
                checkBoxWrapper.removeClass('product-selected');
            }
            var itemText = config_json.items;//'Items';

            if (itemAmount === 1 || itemAmount === 0) {
                itemText = config_json.item;//'Item';
            }
            if ( itemAmount > 0 || currentAllSelectedButtonSelector.hasClass('already_counted') ) {
                currentAllSelectedButtonSelector.addClass('already_counted');
                currentAllSelectedButtonSelector.html( add_cart_text + ' [ ' + itemAmount + ' ' + itemText + ' ]');
            }
            
            var argStats = {};
            argStats['temp_number'] = temp_number;
            argStats['table_id'] = temp_number;
            argStats['itemAmount'] = itemAmount;
            argStats['itemText'] = itemText;
            argStats['button_text'] = add_cart_text;
            argStats['button_object'] = currentAllSelectedButtonSelector;
            $(document.body).trigger('wpt_count_updated',argStats);
        }
        
        $(document.body).on('updateCheckBoxCount',function(temp_number){
            
            updateCheckBoxCount(temp_number);
        });
        
        
        $('body').on('click', 'input.wpt_check_universal,input.enabled.wpt_tabel_checkbox.wpt_td_checkbox', function() { //wpt_td_checkbox
            var temp_number = $(this).data('temp_number');
            var checkbox_type = $(this).data('type'); //universal_checkbox
            if (checkbox_type === 'universal_checkbox') {
                $('#table_id_' + temp_number + ' input.enabled.wpt_tabel_checkbox.wpt_td_checkbox:visible').prop('checked', this.checked); //.wpt_td_checkbox
                $('input#wpt_check_uncheck_column_' + temp_number).prop('checked', this.checked);
                $('input#wpt_check_uncheck_button_' + temp_number).prop('checked', this.checked);
            }
            var temp_number = $(this).data('temp_number');
            updateCheckBoxCount(temp_number);
        });
        
        function uncheckAllCheck(temp_number){
            var selectedCheckBox = $('#table_id_' + temp_number + ' input[type=checkbox]');
            selectedCheckBox.each(function(){
                if($(this).is(':checked')){
                    $(this).trigger('click');
                }
            });
            updateCheckBoxCount(temp_number);
        }
        
        /**
         * For Instance Search
         * @since 2.5
         */
        $('.instance_search_input').keyup(function(){
            var text,value_size,serial;
            var temp = $(this).data('temp_number');
            var value = $(this).val();
            value = value.trim();
            
            value = value.split(' ');
            value = value.filter(function(eachItem){
                return eachItem !== '';
            });
            value_size = value.length;

            
            var target_table = '#table_id_' + temp + ' #wpt_table';
            $(target_table + ' tr.visible_row').each(function(){
                text = $(this).html();
                text = text.toLowerCase();
                serial = 0;
                value.forEach(function(eachItem){
                    if(text.match(eachItem.toLowerCase(),'i')){
                        serial++;
                    }
                });
                
                if(value_size === serial){ //serial > 0 ||
                    $(this).fadeIn();
                    $(this).addClass('instance_search_applied');
                }else{
                    $(this).fadeOut();
                    $(this).removeClass('instance_search_applied');
                }
                
            });
            
        });
        
        function emptyInstanceSearchBox(temp_number){
            $('#table_id_' + temp_number + ' .instance_search_input').val('');
        }
        
        /**
         * Quote Button Revert on Change Variation
         */
        $(window).on('wpt_changed_variations',function(e,Attrs){
            if( Attrs.status ){
                var product_id = Attrs.product_id;
                var quoteElm = $('tr.product_id_'+product_id + ' td.wpt_quoterequest a.wpt_yith_add_to_quote_request');
                try{
                    var response_msg = quoteElm.data('msg');
                    quoteElm.html(response_msg.text);
                    quoteElm.closest('div.quoterequest').find('.yith_ywraq_add_item_response_message').remove();
                    quoteElm.closest('div.quoterequest').find('.yith_browse_link').remove();
                }catch(e){
                    // nothing needed to print
                }
            }
        });
        /**
         * For Add to Quote Plugin
         * YITH add to Quote Request plugin
         * @since 2.6 
         * @date 20.7.2018
         */
        //ywraq_frontend
        $('body').on('click','a.wpt_yith_add_to_quote_request.enabled',function(e){
            e.preventDefault();
            var thisButton = $(this); //New added at 4.0.19 
            if ( typeof ywraq_frontend === 'undefined' ){
                alert("Quote Request plugin is not installed.");
                return false;
            }
            var msg = $(this).data('msg');
            var response_msg = $(this).attr('data-response_msg');
            var type = $(this).closest('tr.wpt_row').data('type')
            
            if(type !== 'variable' && response_msg !== ''){
                showAlert(response_msg);
                $('.' + selector).html(msg.added);
                return false;
            }
            var selector = $(this).data('selector');
            $('.' + selector).html(msg.adding);
            var add_to_cart_info;
            var wp_nonce = $(this).data('wp_nonce');
            var product_id = $(this).data('product_id');
            var parent_id = $(this).closest('tr.wpt_row').data('parent_id');

            var quantity = $(this).attr('data-quantity');
            var quote_data = $(this).attr('data-quote_data');
            var yith_browse_list = $(this).data('yith_browse_list');
            
            
            var temp_number = $(this).closest('tr.wpt_row').data('temp_number');
            var addToCartSelector = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' a.wpt_product_title_in_td');
            var tableRow = $('#table_id_' + temp_number + ' #product_id_' + product_id );
            
            var url_params = tableRow.attr('data-href');
            var split_params = url_params.split('?');
            if( typeof split_params[1] !== 'undefined' && type === 'variation' ){
                quote_data = '&' + split_params[1];
            }
            add_to_cart_info = 'action=yith_ywraq_action&ywraq_action=add_item&quantity=' + quantity + '&product_id='+ product_id +'&_wpnonce='+ywraq_frontend.yith_ywraq_action_nonce;
            add_to_cart_info += quote_data;
            /**
             * When Table will show "Only Variation" as row
             * Then Product ID will get from Parent ID
             * And variation id will be product ID
             * 
             * @since 2.7.7
             */
            if( type === 'variation' ){
               var variation_id = product_id;
               product_id = parent_id;
                add_to_cart_info += '&variation_id=' + variation_id;
            }
            
            var yith_ajax_url;// = ywraq_frontend.ajaxurl;
            yith_ajax_url = ywraq_frontend.ajaxurl.toString().replace( '%%endpoint%%', 'yith_ywraq_action' );
            
            $.ajax({
            type   : 'POST',
            url    : ywraq_frontend.ajaxurl,//yith_ajax_url,
            dataType: 'json',
            data   : add_to_cart_info,
            beforeSend: function(){

            },
            complete: function(){
            },
            success: function (response) {
                if( response && ( response.result === 'true' || response.result === 'exists' ) ){
                    $('.' + selector).html(msg.added);
                    //if(response.result === 'exists'){
                        //$('.' + selector).attr('data-response_msg',response.message);
                    //}
                    $('.' + selector).attr('data-response_msg',response.message);
                    var html;
                    
                    html = '<div class="yith_ywraq_add_item_response_message">' + response.message + '</div>';
                    html += '<a class="yith_browse_link" href="'+response.rqa_url+'" target="_blank">' + yith_browse_list + '</a>';
                    
                    $('.' + selector).parent().append( html ).show(); //response.label_browse
                }else{
                    $('.' + selector).html(msg.added);
                }
                
            }
        });
        });
        
        loadMiniFilter();
        $(document.body).on('wpt_ajax_loaded',function(){
            loadMiniFilter();
        });
        /**
         * Loading MiniFilter 's option based on loaded products
         * @since 4.8
         * 
         * @returns {void}
         */
        function loadMiniFilter(){
            $('.wpt-wrap .wpt-mini-filter select.filter_select').each(function(){

                var id = $(this).attr('id');
                var temp_number = $(this).data('temp_number');
                var config_json = getConfig_json( temp_number );
                var key =  $(this).data('key');

                var label =  $(this).data('label');
                var taxArray = new Array();
                var taxValArray = new Array();
                taxArray.sort();
                $('#table_id_' + temp_number + ' tbody tr').each(function(){
                    var tax = $(this).data(key);
                    if(tax && tax !== ''){
                        tax = tax.replace(/,\s*$/, "");
                        tax = tax.replace(/\s/g, ' ');

                        tax = tax.split(',');
                        tax.forEach(function(item){
                            item = item.trimStart(" ");
                            var taxDetails = item.split(':');
                            var taxID = taxDetails[0];
                            var taxValue = taxDetails[1];
                            taxArray[taxID] = taxValue;
                            taxValArray[taxValue] = taxID;
                        });
                    }
                });

                
                if(config_json.sort_mini_filter === 'ASC'){
                    taxArray.sort();
                    
                }else if(config_json.sort_mini_filter === 'DESC'){
                    taxArray.sort();
                    taxArray.reverse();
                }
                
                var html = '<option value="">' + label + '</option>';
                taxArray.forEach(function(value,number){
                    html += '<option value="' + key + '_' + temp_number + '_' + taxValArray[value] + '">' + value + '</option>';
                });
                $(this).html(html);
            });
        }

        /**
         * We will grab number/inter from Sting. such from 1st,3rd,5th to 1,3,4 as well 
         * as from price $23.45 to 23.45
         * 
         * I have used it into soring perpose code
         * 
         * @param {string} text 
         * @param {string|int|number} product_id 
         * @returns int
         */
        function textToIntForSorting(text){
            text = text.replace(/[^0-9.]/g,'');
            if(text == ''){
                text = 0;
            }
            text = parseInt(text);
            return text;
        }

        /**
         * Colunm Sorting Option
         * js base column sorting.
         * N.B: you have to enable it from Configuration page.
         * 
         * @since 2.8
         * @date 26.7.2018
         */
        $(document.body).on('click','div.wpt_column_sort table.wpt_product_table thead tr th',function(){

            var unq_id = $(this).closest('div.wpt-wrap').data('unique_id');

            var class_for_sorted = 'this_column_sorted';
            var temp_number = $(this).parent().data('temp_number');
            var target_class = '.' + $(this).attr('class').split(' ').join('.');
            // var target_table_wrapper_id = '#table_id_' + temp_number;
            var target_table_wrapper_id = "div#table_id_" + temp_number + "[data-unique_id='" + unq_id + "']";
            var thisColObject = $(this);
            var status = false;
            var disableClass = [
                '.wpt_quantity',
                '.wpt_check',
            ];
            var number_class = $('td'+target_class + '>.text_with_number');//.find('.text_with_number');
            var content_type = 'normal';
            if(number_class.length > 0 || target_class.search('.wpt_serial_number') != -1 || target_class.search('.wpt_product_id') != -1 || target_class.search('.wpt_total') != -1 ){
                content_type = 'number';
            }else if(target_class.search('.wpt_price') != -1){
                content_type = 'price';
            }
                        
            var sort_type = $(this).attr('data-sort_type');
                
            if(!sort_type || sort_type === 'ASC'){
                sort_type = 'ASC';
                $(this).attr('data-sort_type','DESC');
            }else{

                $(this).attr('data-sort_type','ASC');
            }

            /**
             * Actually when Audio item in table, then we will not 
             * support column sorting.
             * 
             * @since 3.3.2.2
             */
            var audioItems = $(target_table_wrapper_id).find('.mejs-container');
            if(audioItems.length > 0){
                return;
            }
            
            //for check box collumn //wpt_thumbnails //wpt_product_id
            if($.inArray(target_class,disableClass) == -1){
            
                $(target_table_wrapper_id + ' .' +class_for_sorted).removeClass(class_for_sorted);
                
                //Again Class Reform after remove class
                target_class = '.' + $(this).attr('class').split(' ').join('.');

                var contentHTMLArray = [];
                var currentColumnObject = $(target_table_wrapper_id + ' table tbody td' + target_class);

                currentColumnObject.each(function(index){
                    
                    
                    var text,
                    html = '', 
                    product_id = $(this).parent('tr').data('product_id');
                    text = $(this).text();
                    text = $.trim(text);
                    if(content_type == 'price'){
                        text = $(this).find('span.woocommerce-Price-amount.amount').last().text();
                        text = textToIntForSorting(text);

                    }else if(content_type == 'number'){
                        
                        text = textToIntForSorting(text);

                    }else{
                        text = $.trim(text.substring(0,80));
                        
                        text = text + "_" + product_id;
                    }
                    var thisRowObject = $('#table_id_'+ temp_number +' #product_id_' + product_id);
                    html = thisRowObject.prop('outerHTML');
                    //get_val is actually generated value
                    contentHTMLArray[index] = {
                        product_id: product_id,
                        gen_val: text,
                        html: html
                    };
                });
                
                function sortingData(prevData,nextData){
                    var a = prevData['gen_val'];
                    var b = nextData['gen_val'];
                    var return_data;
                    if(sort_type === 'ASC'){
                        return_data = ((a < b) ? -1 : ((a > b) ? 1 : 0));
                    }else{
                        return_data = ((b < a) ? -1 : ((b > a) ? 1 : 0));
                    }
                    return return_data;
                  }
                  contentHTMLArray.sort(sortingData);

                  var finalHTMLData = '';
                  $.each(contentHTMLArray,function(index,value){

                        finalHTMLData += value.html;
                  });

                //Backed HTML Data
                $(target_table_wrapper_id + ' table>tbody').html(finalHTMLData);

                $(target_table_wrapper_id + ' ' +target_class).addClass(class_for_sorted);
                
                //Cliecked on 
                status = true;
            }
            
            var argStats = {};
            argStats['status'] = status;
            argStats['temp_number'] = temp_number;
            argStats['table_id'] = temp_number;
            argStats['this_object'] = thisColObject;
            $(document.body).trigger('wpt_column_sorted',argStats);
            $(document.body).trigger('wpt_ajax_loaded');
            
            
        });
        
        
        //* Removeing link for cat and tag texonomy
        removeCatTagLings();
        $(document.body).on('wpt_ajax_loaded',removeCatTagLings);
        /**
         * Removing Linkg for Categories link and from Tag's link.
         * We will remove link by JavaScript I mean: jQuery
         * 
         * @since 3.1
         * @date: 13 sept, 2018
         */
        function removeCatTagLings(){
           if(config_json.disable_cat_tag_link === '1'){
                // $('.wpt_category a,.wpt_tags a,.wpt_custom_tax a').contents().unwrap();
                $('.wpt_category a,.wpt_tags a,.wpt_custom_tax a').removeAttr("href");
            } 
        }
        // Removing link feature End here  */

    /*
     * Start code for Advance Version
     * Version: 5.3
     */
    function Advance_NoticeBoard(response){

        var noticeBoard = $('div.wpt_notice_board');
        var eachNoticeInnter = $(response);
        eachNoticeInnter.css('display','none');
        if(response !== ''){
            noticeBoard.prepend(eachNoticeInnter);
            eachNoticeInnter.fadeIn();  
            setTimeout(function(){
                eachNoticeInnter.fadeOut();
                eachNoticeInnter.remove(); 
            },notice_timeout);//Default 3000
        }
    }
    function WPT_BlankNotice(){
        var noticeBoard = $('div.wpt_notice_board');
        noticeBoard.html('');
    }
   
    $(document).on('submit','div.advance_table_wrapper table.advance_table.wpt_product_table form',function(e){
            footerCartAnimation();
            WPT_BlankNotice();
            var product_id = $(this).parents('tr').data('product_id');
            var thisButton = $('tr#product_id_' + product_id + ' .wpt_action button.single_add_to_cart_button');
            var thisTable = $(this).parents('div.wpt-wrap');
            var table_id = $(this).parents('div.wpt-wrap').attr('id');
            
            var data_json = $(this).closest('.wpt-wrap').data('basic_settings');
            var ajax_action = data_json.ajax_action;

            var thisRow = $(this).closest('tr.wpt-row');
            var messageBox = thisRow.find('input.wpt_custom_message');
            var Bubble = thisRow.find('.wpt_ccount');
            if(Bubble.length == 0){
                thisRow.find('.single_add_to_cart_button').append('<span class="wpt_ccount wpt_ccount_' + product_id + '"><i class="wpt-spin5 animate-spin"></span>');
            }else{
                Bubble.html('<i class="wpt-spin5 animate-spin">');
            }

            // thisButton.addClass( 'loading' );
            thisButton.removeClass('added');
            thisButton.addClass( 'disabled' );
            var form = $(this);
            var url = form.attr('action');//ajax_url;//

            var method = form.attr('method');
            if( 'post' === method && ajax_action === 'ajax_active'){
                e.preventDefault();
            }else{
                return;
            }
            
            var checkoutURL = WPT_DATA.checkout_url;
            var cartURL = WPT_DATA.cart_url;
            
            $.post(url, form.serialize() + '&add-to-cart=' + product_id + '&_wp_http_referer=' + url, function(data,status,xh){ //form.serialize() + '&_wp_http_referer=' + url
                thisTable.removeClass('loading');
                var notice = $('.woocommerce-message,.woocommerce-error', data); //.woocommerce-error

                if(config_json.popup_notice === '1'){
                    Advance_NoticeBoard(notice);//Gettince Notice
                }
                    
                    thisButton.removeClass('disabled');
                    // thisButton.removeClass('loading');
                    thisButton.addClass('added');
            }).done(function(){
                messageBox.val('');
                // $( document.body ).trigger( 'added_to_cart' );
                $( document.body ).trigger( 'updated_cart_totals' );
                $( document.body ).trigger( 'wc_fragments_refreshed' );
                $( document.body ).trigger( 'wc_fragments_refresh' );
                $( document.body ).trigger( 'wc_fragment_refresh' );
                
                //Quick Button Active here and it will go Directly to checkout Page
                if(config_json.product_direct_checkout === 'yes'){
                    window.location.href = checkoutURL;
                    return;
                }
                //Quick Cart Button Active here and it will go Directly to Cart Page
                if(config_json.product_direct_checkout === 'cart'){
                    window.location.href = cartURL;
                    return;
                }
                //$( '.wpt_row_product_id_' + product_id + ' .wpt_action button.single_add_to_cart_button' ).addClass( 'added' );
                //$( '.wpt_row_product_id_' + product_id + ' .wpt_action button.single_add_to_cart_button' ).removeClass( 'disabled loading' );
                
                var argStats = {};
                argStats['status'] = true;
                argStats['product_id'] = product_id;
                argStats['form'] = form;
                argStats['url'] = url;
                argStats['temp_number'] = table_id;
                argStats['table_id'] = table_id;
                $(document.body).trigger('wpt_added_to_cart_advance',argStats);
            });
        });
        
        //div.normal_table_wrapper table.normal_table
        $('div.advance_table_wrapper a.button.add_to_cart_all_selected').click(function() {
            WPT_BlankNotice();
            var temp_number = $(this).data('temp_number');
            var allMessageBox = $('#table_id_' + temp_number + ' .wpt_custom_message');
            
            var checkoutURL = WPT_DATA.checkout_url;//$('#table_id_' + temp_number).data('checkout_url');
            var cartURL = WPT_DATA.cart_url;//$('#table_id_' + temp_number).data('cart_url');
            var tableWrapperTag = $('#table_id_' + temp_number + ' .wpt_table_tag_wrapper');
            tableWrapperTag.addClass('wpt-ajax-loading');
            //Add Looading and Disable class 
            var currentAllSelectedButtonSelector = $('#table_id_' + temp_number + ' a.button.add_to_cart_all_selected');
            currentAllSelectedButtonSelector.addClass('disabled');
            currentAllSelectedButtonSelector.addClass('loading');


            
            var add_cart_text = $('#table_id_' + temp_number).data('basic_settings').add_to_cart;
            
            var itemAmount = 0;

            var products_data = {};

            $('#table_id_' + temp_number + ' input.enabled.wpt_tabel_checkbox.wpt_td_checkbox:checked').each(function() {
                WPT_BlankNotice();
                var product_id = $(this).data('product_id');
                var fullSelcetor = '#table_id_' + temp_number + ' #product_id_' + product_id + ' .wpt_action form';
                var thisButton = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' .wpt_action form button.single_add_to_cart_button');
                

                // thisButton.removeClass('added');
                // thisButton.addClass( 'disabled' );
                // thisButton.addClass( 'loading' );
                
                var form = $(fullSelcetor);
                var title = $(this).parents('tr').data('title');
                var additional_json = $(this).parents('tr').attr('additional_json');
                var url = form.attr('action');//ajax_url;//

                let eachProductData = 'product_id=' + product_id + '&' + form.serialize();

                var obj = {};
                console.log(eachProductData);
                eachProductData.replace(/([^=&]+)=([^&]*)/g, function(m, key, value) {
                    obj[decodeURIComponent(key)] = decodeURIComponent(value);
                });
                if(additional_json !== ''){
                    obj['additional_json'] = additional_json;
                }
                

                products_data[product_id] = obj;

                
                var items = $('#table_id_' + temp_number + ' tr#product_id_' + product_id).attr('data-quantity');
                items = parseFloat(items);
                if(items <= 0){
                    return;
                }
                
                var itemCountSystem = config_json.item_count;
                if(typeof itemCountSystem !== 'undefined' && itemCountSystem === 'all'){
                    

                    
                    itemAmount += items;
                }else{
                    itemAmount++;//To get Item Amount
                } 
            });

            //Return false for if no data
            if (itemAmount < 1) {
                currentAllSelectedButtonSelector.removeClass('disabled');
                currentAllSelectedButtonSelector.removeClass('loading');
                showAlert(config_json.please_choose_items);
                return false;
            }
            uncheckAllCheck(temp_number);
            currentAllSelectedButtonSelector.html(add_cart_text + ' [ ' + config_json.loading_more_text + ' ]');

            $.ajax({
                type: 'POST',
                url: ajax_url,
                data: {
                    action: 'wpt_ajax_mulitple_add_to_cart',
                    products: products_data,
                },
                complete: function(){
                    $( document ).trigger( 'wc_fragments_refreshed' );
                },
                success: function( response ) {

                    $( document.body ).trigger( 'added_to_cart' ); //Trigger and sent added_to_cart event
                    $( document.body ).trigger( 'updated_cart_totals' );
                    $( document.body ).trigger( 'wc_fragments_refreshed' );
                    $( document.body ).trigger( 'wc_fragments_refresh' );
                    $( document.body ).trigger( 'wc_fragment_refresh' );
                    
                    currentAllSelectedButtonSelector.html(add_cart_text + ' [ ' + itemAmount + ' ' + config_json.add2cart_all_added_text + ' ]');
                    
                    WPT_NoticeBoard();
                    if(config_json.all_selected_direct_checkout === 'yes'){
                        window.location.href = checkoutURL;
                        return;
                    }else if(config_json.all_selected_direct_checkout === 'cart'){
                        window.location.href = cartURL;
                        return;
                    }
                    currentAllSelectedButtonSelector.removeClass('disabled');
                    currentAllSelectedButtonSelector.removeClass('loading');
                    allMessageBox.val('');//3.2.5.5.final10
                    tableWrapperTag.removeClass('wpt-ajax-loading');
                    
                    
                    
                },
                error: function() {
                    alert('Failed');
                },
            });


            
            currentAllSelectedButtonSelector.removeClass('disabled');
            currentAllSelectedButtonSelector.removeClass('loading');
            $( document ).trigger( 'wc_fragments_refreshed' );
            if(config_json.all_selected_direct_checkout === 'yes'){
                window.location.href = checkoutURL;
                return;
            }
            //Quick Cart Button Active here and it will go Directly to Cart Page
            if(config_json.product_direct_checkout === 'cart'){
                window.location.href = cartURL;
                return;
            }

        });
        
        $(document.body).on('wpt_ajax_load_data',function(e,data){
            var temp_number = data.table_id;
            uncheckAllCheck(temp_number);
        });
        $(document).on( 'reset_data', 'div.advance_table_wrapper table.advance_table.wpt_product_table form.cart', function() {
            var thisRow = $(this).parents('tr.wpt_row');

            var temp_number = thisRow.data('temp_number');
            var product_id = thisRow.data('product_id');
            var quoted_target = 'yith_request_temp_' + temp_number + '_id_' + product_id;
            var addToQuoteSelector = $('.' + quoted_target);
            var checkBoxSelector = $('.wpt_check_temp_' + temp_number + '_pr_' + product_id);
            
            thisRow.attr('data-variation_id', '' );
            
            function enable_disable_class() {
                addToQuoteSelector.removeClass('enabled');
                addToQuoteSelector.addClass('disabled');
                
                checkBoxSelector.removeClass('enabled');
                checkBoxSelector.addClass('disabled');
            }
            enable_disable_class();

            var skuTDobj = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' .td_or_cell.wpt_sku');
            var sku = skuTDobj.data('sku');
            skuTDobj.find('div.wpt_sku').html(sku);
            
        });
        $(document).on( 'found_variation', 'div.advance_table_wrapper table.advance_table.wpt_product_table form.cart', function( event, variation ) {
            var thisRow = $(this).parents('tr.wpt_row');

            var temp_number = thisRow.data('temp_number');
            var product_id = thisRow.data('product_id');
            var my_product_id = $(event.currentTarget).parents('tr.wpt_row').data('product_id');
            
            var targetThumbs = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' wpt_thumbnails img');
            var quoted_target = 'yith_request_temp_' + temp_number + '_id_' + product_id;
            var addToQuoteSelector = $('.' + quoted_target);
            var checkBoxSelector = $('.wpt_check_temp_' + temp_number + '_pr_' + product_id);
            function targetTD(td_name) {
                var targetElement = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' wpt_' + td_name);
                return targetElement;
            }
            var sku = variation.sku;
            var skuTDobj = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' div.wpt_sku');
            skuTDobj.html(sku);

            //Adding selected variation ID adding at row
            thisRow.attr('data-variation_id', variation.variation_id );

            /**
             * Set Variations value to the targetted column's td
             * 
             * @param {type} target_td_name suppose: weight,description,serial_number,thumbnails etc
             * @param {type} gotten_value Suppose: variations description from targatted Object
             * @returns {undefined}
             */
            function setValueToTargetTD_IfAvailable(target_td_name, gotten_value){
                if (gotten_value !== "") {
                    targetTD(target_td_name).html(gotten_value);
                }
            }
            
            /**
             * set value for without condition
             * 
             * @param {type} target_td_name for any td
             * @param {type} gotten_value Any valy
             * @returns {undefined}
             */
            function setValueToTargetTD(target_td_name, gotten_value){
                targetTD(target_td_name).html(gotten_value);
            }
            
            
            
            targetThumbs.attr('src', variation.image.gallery_thumbnail_src);
            if(variation.image.srcset && 'false' !== variation.image.srcset) {
                targetThumbs.attr('srcset', variation.image.srcset);
            };
            
            function disbale_enable_class() {
                
                /**
                 * For Add To Quote
                 */
                addToQuoteSelector.removeClass('disabled');
                addToQuoteSelector.addClass('enabled');

                checkBoxSelector.removeClass('disabled');
                checkBoxSelector.addClass('enabled');
            }
            disbale_enable_class();
            
            
            targetThumbs.attr('data-variation_id', variation.variation_id);

        });
  
        
        
        $('.wpt-wrap').each(function(){
            var table_id = $(this).data('temp_number');
            var tableEl = $(this).find('table.wpt_product_table');
            var width = tableEl.width();
            $('.wpt_second_wrapper.wpt_second_wrapper_' + table_id + ' div.wpt_second_content').css('width',width);
        });
                
        $(".wpt_table_tag_wrapper").scroll(function () {
            $(".wpt_second_wrapper").scrollLeft($(".wpt_table_tag_wrapper").scrollLeft());
        });
        $(".wpt_second_wrapper").scroll(function () {
            $(".wpt_table_tag_wrapper").scrollLeft($(".wpt_second_wrapper").scrollLeft());
        });
        
        // arrangingTDContentForMobile();
        function arrangingTDContentForMobile(){
            return;
            $('table.mobile_responsive tr.wpt_row').each(function(){
                return;
                var already_updated = $(this).attr('already');
                if((typeof already_updated === 'undefined')){
                    $(this).attr('already','yes');

                    var htmlDesc,htmlAction,htmlImg,htmlCfTax;
                    var actionElement = $(this).children('td.wpt_action');
                    var productDescElement = $(this).children('td.wpt_product_title');
                    if(!productDescElement.length){
                        productDescElement = $(this).children('td').first();
                        productDescElement.css('display','block');
                    }
                    
                    htmlDesc = "";

                    htmlDesc += "<div class='wpt_mobile_desc_part'>";
                    $(this).children('td.wpt_for_product_desc').each(function(){
                        var attr = "";
                        $.each(this.attributes, function() {
                            if(this.specified) {
                                attr += ' ' + this.name + '="' + this.value + '"';
                            }
                        });
                        htmlDesc += "<div " + attr + ">" + $(this).html() + "</div>";//"<div class='" + td_class + "'>" + $(this).html() + "</div>";

                    });
                    htmlDesc += "</div>"


                    htmlImg = ""; //wpt_for_thumbs_desc

                    $(this).children('td.wpt_for_thumbs_desc').each(function(){
                        var attr = "";
                        $.each(this.attributes, function() {
                            if(this.specified) {
                                attr += ' ' + this.name + '="' + this.value + '"';
                            }
                        });
                        htmlImg += "<div " + attr + ">" + $(this).html() + "</div>";//"<div class='" + td_class + "'>" + $(this).html() + "</div>";

                    });
                    //htmlDesc += "</div>"



                    htmlCfTax = "";
                    $(this).children('td.wpt_custom_cf_tax').each(function(){
                        var cf_tax_keyword = $(this).data('keyword');
                        var cf_tax_columnName = $('th.' + cf_tax_keyword).html(); //undefined
                        if(typeof cf_tax_columnName !== 'undefined'){
                            cf_tax_columnName = "<span>" + cf_tax_columnName + ": </span>";
                        }else{
                            cf_tax_columnName = "";
                        }
                        
                        var attr = "";
                        $.each(this.attributes, function() {
                            if(this.specified) {
                                attr += ' ' + this.name + '="' + this.value + '"';
                            }
                        });
                        htmlCfTax += "<div " + attr + ">" + cf_tax_columnName + $(this).html() + "</div>";//"<div class='" + td_class + "'>" + $(this).html() + "</div>";

                    });
                    if(htmlCfTax !== ""){
                        htmlDesc += "<div class='wpt_custom_cf_tax_wrapper'>";
                        htmlDesc += htmlCfTax;
                        htmlDesc += "</div>";
                    }
                    
                    htmlAction = "";
                    $(this).children('td.wpt_for_product_action').each(function(){
                        var attr = "";
                        $.each(this.attributes, function() {
                            if(this.specified && this.name !== 'data-price_html') {
                                attr += ' ' + this.name + '="' + this.value + '"';
                            }
                        });
                        htmlAction += "<div " + attr + ">" + $(this).html() + "</div>";//"<div class='" + td_class + "'>" + $(this).html() + "</div>";

                    });

                    if(actionElement.length > 0){
                        actionElement.prepend(htmlAction);
                    }else{
                        htmlDesc += "<div class='wpt_conditon_desc_load'>";
                        htmlDesc += htmlAction;
                        htmlDesc += "<div>";
                    }
                    productDescElement.prepend(htmlImg);
                    productDescElement.append(htmlDesc);
                }

            });

            //Fix checkbox issue for .wpt_for_product_desc.wpt_check
            $('table td div.wpt_for_product_desc.wpt_check').each(function(){
                var id = $(this).children('input.wpt_tabel_checkbox').attr('id') + "_mob";
                $(this).children('input.wpt_tabel_checkbox').attr('id',id);
                $(this).children('label').attr('for',id);

            });
        }     
        
        
        /**
         * Mainly for Total column
         * I just Insert Trigger
         * 
         * @since 2.7.7
         * @date 28.10.2020
         */
        $('.wpt_product_table input.input-text.qty.text').trigger('change');
        
         $('.yith-ywraq-add-to-quote').each(function(){
             let qty = $(this).closest('tr').data('quantity');
            $(this).append('<input type="hidden" class="input-text qty text" value="' + qty + '">');
        });
        
        
    });
});
