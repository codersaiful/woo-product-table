/* 
 * Only for Fronend Section
 * @since 1.0.0
 */


(function($) {
    $(document).ready(function() {
        $('.wpt_product_table_wrapper .search_select').select2();
        /**
         * Checking wpt_pro_table_body class available in body tag
         * 
         * @since 4.3 we have added this condition. 
         */
        if(!$('div.wpt_product_table_wrapper table').hasClass('wpt_product_table')){ //div wpt_product_table_wrapper 
            return false; 
        }        
        
        var ajax_url,ajax_url_additional = '/wp-admin/admin-ajax.php';

        if ( typeof woocommerce_params === 'undefined' ){
            var site_url = $('div.wpt_product_table_wrapper').data('site_url');
            ajax_url = site_url + ajax_url_additional;
            //woocommerce_params //wc_add_to_cart_params
        }else{
            ajax_url = woocommerce_params.ajax_url;
        }
        console.log(ajax_url);//Only for Developer
        if( ajax_url === 'undefined' + ajax_url_additional  ){
            console.log( 'WOO PRODUCT TABLE is not Available to this page \nOR:::SORRY!!!!: woocommerce_params is Undefine also ajax_url also undefined. So ajax will not work not. Contact with codersaiful@gmail.com' );
            return false;
        }
        
        /**
         * Pagination
         * @type Objectt
         */
        changeSpanToAPagi();
        function changeSpanToAPagi(){
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
        $('body').on('click','.wpt_table_pagination a',function(e){
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
            $.ajax({
                type: 'POST',
                url: ajax_url,// + get_data,
                data: {
                    action:         'wpt_query_table_load_by_args',
                    temp_number:    temp_number,
                    targetTableArgs:targetTableArgs,
                    pageNumber:     pageNumber,
                    load_type:     load_type,
                },
                complete: function(){
                    $( document ).trigger( 'wc_fragments_refreshed' );
                    loadMiniFilter();
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

                    pageNumber++; //Page Number Increasing 1 Plus
                    targetTable.attr('data-page_number',pageNumber);
                },
                error: function() {
                    alert("Error On Ajax Query Load. Please check console.");
                    console.log('Error Here');
                },
            });
            
            
        });
        //End of Pagination
        
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
        var footer_cart = config_json.footer_cart;
        console.log(config_json);
        var footer_cart = config_json.footer_cart;
        var footer_cart_size = config_json.footer_cart_size;
        var footer_possition = config_json.footer_possition;
        var footer_bg_color = config_json.footer_bg_color;
        //Adding Noticeboard and Footer CartBox Div tag at the bottom of page
        $('body').append("<div class='wpt_notice_board'></div>");
        $('body').append('<div style="height: ' + footer_cart_size + 'px;width: ' + footer_cart_size + 'px;" class="wpt-footer-cart-wrapper '+ footer_possition +' '+ footer_cart +'"><a target="_blank" href="#"></a></div>');
        
        /**
         * To get/collect Notice after click on add to cart button 
         * or after click on add_to_cart_selected
         * Changed on 4.6.4
         * 
         * @returns {undefined}
         * 
         */
        function WPT_NoticeBoard(notice){
            var noticeBoard = $('div.wpt_notice_board');
             if(notice !== ''){
                noticeBoard.append(notice);
                var boardHeight = noticeBoard.height();
                var boardWidth = noticeBoard.width();
                var windowHeight = $(window).height();
                var windowWidth = $(window).width();
                var topCal = (windowHeight - (boardHeight + 20))/2;
                var leftCal = (windowWidth - (boardWidth + 20))/2;
                noticeBoard.css({
                    top: topCal + 'px',
                    left: leftCal + 'px',
                });                        
                noticeBoard.fadeIn('slow');
            }
            var myTimeOut = setTimeout(function(){
                noticeBoard.fadeOut('medium');
                clearTimeout(myTimeOut);
            },2000);
        }
        function WPT_BlankNotice(){
            var noticeBoard = $('div.wpt_notice_board');
            noticeBoard.html('');
        }
        $('body').on('click','div.wpt_notice_board',function(){
            $(this).fadeOut('fast');
        });
        
        /**
         * Loading our plugin's minicart
         * 
         * @since 3.7.11
         * @Added a new added function.
         * @returns {Boolean}
         */
        function WPT_MiniCart(){
            var minicart_type = $('div.tables_cart_message_box').attr('data-type');
                        
            $.ajax({
                type: 'POST',
                url: ajax_url,
                data: {
                    action: 'wpt_fragment_refresh'
                },
                success: function(response){
                    //console.log(response);
                    setFragmentsRefresh( response );
                    var cart_hash = response.cart_hash;
                    var fragments = response.fragments;
                    var html = '';
                    var supportedElement = ['div.widget_shopping_cart_content','a.cart-contents','a.footer-cart-contents'];
                    if ( fragments && cart_hash !== '' ) {
                        if(minicart_type === 'load'){
                            $.each( fragments, function( key, value ) {
                                if($.inArray(key, supportedElement) != -1) {
                                    html += value;
                                }
                                
                            });
                            $('div.tables_cart_message_box').attr('data-type','refresh');//Set
                            $('div.tables_cart_message_box').html(html);
                        }else{
                            $.each( fragments, function( key, value ) {
                                if($.inArray(key, supportedElement) != -1) {
                                    $( key ).replaceWith( value );
                                }
                                
                            });
                        }
                        
                    }
                },
                error: function(){
                    alert("Unable to Load Minicart");
                    return false;
                }
            });
        }

        
        WPT_MiniCart();

        if(config_json.thumbs_lightbox === '1' || config_json.thumbs_lightbox === 1){
            $('body').on('click', '.wpt_product_table_wrapper .wpt_thumbnails img', function() {
                var thisImg = $(this);
                var image_width, final_image_url, variation_id,imgSize;
                //For vatiation management
                variation_id = $(this).attr('data-variation_id');
                
                if('undefined' !== typeof variation_id){
                    $.ajax({
                        type: 'POST',
                        url: ajax_url,
                        data: {
                            action: 'wpt_variation_image_load',
                            variation_id: variation_id,
                        },
                        success: function(result){
                            imgSize = result.split(" ");
                            final_image_url = imgSize[0];
                            image_width = imgSize[1];
                            IMG_Generator(thisImg,final_image_url, image_width);
                        }
                    });
                    
                }else{
                    image_width = $(this).parent().data('width');
                    final_image_url = $(this).parent().data('url');
                    IMG_Generator(thisImg,final_image_url, image_width);
                }
                
                
            });
            
            /**
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
                    console.log("No Thumbnail Image founded");
                    final_image_url = placeholder_image;//Set final image size to place holder image when not found
                    wrapper_style = '';//Default blank value for style of wrapper, when not found any image
                }else{
                    //Setting style of height width
                    wrapper_style = "style='width: " + image_width + "px; height:" + image_height + "px'";
                }
                product_title = $(thisImg).closest('tr').data('title');
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
        }
        
        $('body').on('click','a.button.wpt_woo_add_cart_button.outofstock_add_to_cart_button.disabled',function(e){
            e.preventDefault();
            alert(config_json.sorry_out_of_stock);
            return false;
        });
        //Add to cart
        $('body').on('click', 'a.ajax_active.wpt_variation_product.single_add_to_cart_button.button.enabled, a.ajax_active.add_to_cart_button.wpt_woo_add_cart_button', function(e) {
            e.preventDefault();
            var thisButton = $(this);
            //Adding disable and Loading class
            thisButton.addClass('disabled');
            thisButton.addClass('loading');

            var product_id = $(this).data('product_id');
            
            var temp_number = $(this).closest('.wpt_variation_' + product_id).data('temp_number');
            var qtyElement = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' input.input-text.qty.text');
            var min_quantity = qtyElement.attr('min');//.val();
            if(min_quantity === '0' || typeof min_quantity === 'undefined'){
                min_quantity = 1;
            }
            //For Direct Checkout page and Quick Button Features
            var checkoutURL = $('#table_id_' + temp_number).data('checkout_url');

            //Changed at2.9
            var quantity = $(this).attr('data-quantity');
            var custom_message = $('#table_id_' + temp_number + ' table#wpt_table .wpt_row_product_id_' + product_id + ' .wpt_Message input.message').val();
            var variation_id = $(this).attr('data-variation_id');
            var variation = $(this).attr('data-variation');
            if(variation){
                variation = JSON.parse(variation);
            }
            if(!quantity || quantity === '0'){
                
                thisButton.removeClass('disabled');
                thisButton.removeClass('loading');
                alert("Sorry! 0 Quantity");
                return false;
                quantity = 1;
            }
            
            var get_data = $(this).attr('href') + '&quantity=' + quantity;
            
            $.ajax({
                type: 'POST',
                url: ajax_url,// + get_data,
                data: {
                    action:     'wpt_ajax_add_to_cart',
                    variation:  variation, 
                    variation_id:   variation_id,
                    product_id: product_id,
                    quantity:   quantity,
                    custom_message: custom_message,
                },
                complete: function(){
                    $( document ).trigger( 'wc_fragments_refreshed' );
                },
                success: function(response) {

                    
                    //WPT_MiniCart();
                    $( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, thisButton ] ); //Trigger and sent added_to_cart event
                    thisButton.removeClass('disabled');
                    thisButton.removeClass('loading');
                    thisButton.addClass('added');
                    qtyElement.val(min_quantity);
                    thisButton.attr('data-quantity',min_quantity);

                    if(config_json.popup_notice === '1'){
                        WPT_NoticeBoard();//Gettince Notice
                    }
                    //Quick Button Active here and it will go Directly to checkout Page
                    if(config_json.product_direct_checkout === 'yes'){
                        window.location.href = checkoutURL;
                    }
                    
                    //******************/
                },
                error: function() {
                    alert('Failed - Unable to add by ajax');
                },
            });
        });

        $('body').on('click', 'a.wpt_variation_product.single_add_to_cart_button.button.disabled,a.disabled.yith_add_to_quote_request.button', function(e) {
            e.preventDefault();
            alert(config_json.no_right_combination);
            return false;
            
        });
        //Alert of out of stock 

        $('body').on('click', 'a.wpt_woo_add_cart_button.button.disabled.loading,a.disabled.yith_add_to_quote_request.button.loading', function(e) {
            e.preventDefault();
            alert(config_json.adding_in_progress);
            return false;

        });
        
        

        /**
         * Working for Checkbox of our Table
         */
        $('body').on('click', 'input.wpt_tabel_checkbox.wpt_td_checkbox.disabled', function(e) {
            e.preventDefault();
            alert(config_json.sorry_plz_right_combination);
            return false;
        });

        
        
        //,wc_fragments_refresh,wc_fragment_refresh,removed_from_cart
        $(document).on('wc_fragments_refreshed',function(){
            WPT_MiniCart();
        });
        $(document).on('wc_fragments_refresh',function(){
            WPT_MiniCart();
        });
        
        $(document).on('wc_fragment_refresh',function(){
            WPT_MiniCart();
        });
        
        $(document).on('removed_from_cart',function(){
            WPT_MiniCart();
        });
        
        $('div.wpt-footer-cart-wrapper>a').css('background-color',footer_bg_color);
        $('body').append('<style>div.wpt-footer-cart-wrapper>a:after{background-color: ' + footer_bg_color + ';}</style>');
        /**
         * @param {type} response
         * @returns {undefined}
         */
        function setFragmentsRefresh( response ){
            var FooterCart = $('div.wpt-footer-cart-wrapper');
            
            $('span.wpt_ccount').html('');
            $( '.wpt_action>a.wpt_woo_add_cart_button' ).removeClass( 'added' );
            if(response !== 'undefined'){
                    var fragments = response.fragments;
                    if ( fragments ) {
                        $.each( fragments, function( key, value ) {
                            //console.log(key);
                            $( key ).replaceWith( value );
                        });
                    }
                    
                    var wpt_per_product = fragments.wpt_per_product;
                    wpt_per_product = $.parseJSON(wpt_per_product)
                    if( wpt_per_product && wpt_per_product  !== 'false'){
                        if(footer_cart !== 'always_hide'){
                            FooterCart.fadeIn('slow');
                        }
                        
                        $.each( wpt_per_product, function( key, value ) {
                            $( '.wpt_row_product_id_' + key + ' .wpt_action button.single_add_to_cart_button>.wpt_ccount.wpt_ccount_' + key ).remove();
                            $( '.wpt_row_product_id_' + key + ' .wpt_action>a.wpt_woo_add_cart_button' ).addClass( 'added' );
                            $( '.wpt_row_product_id_' + key + ' .wpt_action>a.wpt_woo_add_cart_button' ).append( '<span class="wpt_ccount wpt_ccount_' + key + '">' + value + '</span>' );
                        });
                    }else{
                        if(footer_cart === 'hide_for_zerro'){
                            FooterCart.fadeOut('slow');
                        }
                        
                    }
                    $('div.wpt-footer-cart-wrapper>a').css('background-color',footer_bg_color);
                }
        }
        
        
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
        $('body').on('change','.search_select,.query_box_direct_value',function(){
            var thisID = $(this).parents('.wpt_product_table_wrapper').attr('id');
            var temp_number = thisID.replace('table_id_','');
           $('#wpt_query_search_button_' + temp_number).trigger('click');
        });
        /**
         * Search Box Query and Scripting Here
         * @since 1.9
         * @date 9.6.2018 d.m.y
         */
        
        $( 'body' ).on('click','button.wpt_query_search_button,button.wpt_load_more', function(){
            
            var temp_number = $(this).data('temp_number');
            //Added at 2.7

            var loadingText = config_json.loading_more_text;// 'Loading...';
            
            var searchText = config_json.search_button_text;
            var loadMoreText = config_json.load_more_text;//'Load More';
            var thisButton = $(this);
            var actionType = $(this).data('type');
            var load_type = $(this).data('load_type');
            
            thisButton.html(loadingText);

            
            var targetTable = $('#table_id_' + temp_number + ' table#wpt_table');
            var targetTableArgs = targetTable.data( 'data_json' );
            var targetTableBody = $('#table_id_' + temp_number + ' table#wpt_table tbody');
            var pageNumber = targetTable.attr( 'data-page_number' );
            if( actionType === 'query' ){
                pageNumber = 1;
            }
            
            
            
            var key,value;
            var directkey = {};
            $('#search_box_' + temp_number + ' .search_single_direct .query_box_direct_value').each(function(){
                
                key = $(this).data('key');
                value = $(this).val();
                directkey[key] = value;
            });

            var texonomies = {};
            value = false;
            //console.log($('#search_box_' + temp_number + ' .search_select.query').val());
            $('#search_box_' + temp_number + ' .search_select.query').each(function(){
                
                key = $(this).data('key');
                var value = $(this).val();//[];var tempSerial = 0;
                texonomies[key] = value;
            });

            //Display Loading on before load
            targetTableBody.prepend("<div class='table_row_loader'>" + config_json.loading_more_text + "</div>"); //Laoding..
            $.ajax({
                type: 'POST',
                url: ajax_url,// + get_data,
                data: {
                    action:         'wpt_query_table_load_by_args',
                    temp_number:    temp_number,
                    directkey:      directkey,
                    targetTableArgs:targetTableArgs, 
                    texonomies:     texonomies,
                    pageNumber:     pageNumber,
                    load_type:     load_type,
                },
                complete: function(){
                    $( document ).trigger( 'wc_fragments_refreshed' );
                    loadMiniFilter();
                },
                success: function(data) {
                    
                    $('.table_row_loader').remove();
                    if( actionType === 'query' ){
                        $('#wpt_load_more_wrapper_' + temp_number).remove();
                        targetTableBody.html( data );
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
                        
                        targetTable.after('<div id="wpt_load_more_wrapper_' + temp_number + '" class="wpt_load_more_wrapper"><button data-temp_number="' + temp_number + '" data-type="load_more" class="button wpt_load_more">' + loadMoreText + '</button></div>');
                        thisButton.html(searchText);
                    }
                    if( actionType === 'load_more' ){
                        if(data !== config_json.product_not_founded){ //'Product Not found' //Products Not founded!
                            targetTableBody.append( data );
                            thisButton.html(loadMoreText);
                            
                            //Actually If you Already Filter, Than table will load with Filtered.
                            filterTableRow(temp_number);
                        }else{
                            $('#wpt_load_more_wrapper_' + temp_number).remove();
                            alert(config_json.no_more_query_message);//"There is no more products based on current Query."
                        }
                        
                    }
                    removeCatTagLings();//Removing Cat,tag link, if eanabled from configure page
                    pageNumber++; //Page Number Increasing 1 Plus
                    targetTable.attr('data-page_number',pageNumber);
                },
                error: function() {
                    alert("Error On Ajax Query Load. Please check console.");
                    console.log('Error Here');
                },
            });
            
            emptyInstanceSearchBox(temp_number);//When query finished, Instant search box will empty
            
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
                        var newjsonData = $('mypagi').attr('myjson');
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
            filterTableRow(temp_number);
            
        });
        
        $('body').on('click','a.wpt_filter_reset',function(e){
            e.preventDefault();
            var temp_number = $(this).data('temp_number');
            $('#table_id_' + temp_number + ' select.filter_select').each(function(){
                $(this).children().first().attr('selected','selected');
            });
            filterTableRow(temp_number);
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
        
        function filterTableRow(temp_number){
            emptyInstanceSearchBox(temp_number);
            //Uncheck All for each Change of Filter
            uncheckAllCheck(temp_number);
            
            //Checking FilterBox
            var filterBoxYesNo = $('#table_id_' + temp_number + ' .wpt_filter_wrapper').html();

            /**
             * Uncheck All, If any change on filter button
             * @version 2.0
             */
            
            var ClassArray =[];
            var serial = 0;
            $('#table_id_' + temp_number + ' .wpt_filter_wrapper select.filter_select').each(function(){
                var currentClass = $(this).val();
                
                if(currentClass !==''){
                    ClassArray[serial] = '.' + currentClass;
                    serial++;
                }
            });
            var finalClassSelctor = '.filter_row' + ClassArray.join(''); //Test will keep
            console.log(finalClassSelctor);
            var hideAbleClass = '#table_id_' + temp_number + ' table tr.wpt_row';
            
           
           if( filterBoxYesNo ){
                $(hideAbleClass + ' td.wpt_check input.enabled.wpt_tabel_checkbox').removeClass('wpt_td_checkbox');
                $(hideAbleClass).css('display','none');
                $(hideAbleClass).removeClass('visible_row');

                $(finalClassSelctor).fadeIn();
                $(finalClassSelctor).addClass('visible_row');
                $(finalClassSelctor + ' td.wpt_check input.enabled.wpt_tabel_checkbox').addClass('wpt_td_checkbox');
            }
            
            /**
             * Updating Check Founting Here
             */
            updateCheckBoxCount(temp_number);
        }
        
        function updateCheckBoxCount(temp_number){
            
            var add_cart_text = $('#table_id_' + temp_number).data('add_to_cart');
            var currentAllSelectedButtonSelector = $('#table_id_' + temp_number + ' a.button.add_to_cart_all_selected');
            var itemAmount = 0;
            $('#table_id_' + temp_number + ' input.enabled.wpt_tabel_checkbox:checked').each(function() { //wpt_td_checkbox
                itemAmount++;//To get Item Amount
            });
            var itemText = config_json.items;//'Items';
            if (itemAmount === 1 || itemAmount === 0) {
                itemText = config_json.item;//'Item';
            }
            currentAllSelectedButtonSelector.html( add_cart_text + ' [ ' + itemAmount + ' ' + itemText + ' ]');
        }
        function uncheckAllCheck(temp_number){
            $('#table_id_' + temp_number + ' input.wpt_check_universal:checkbox,#table_id_' + temp_number + ' table input:checkbox').attr('checked',false);
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
                
                if(serial > 0 || value_size === 0){
                    $(this).fadeIn();
                }else{
                    $(this).fadeOut();
                }
                
            });
            
        });
        
        function emptyInstanceSearchBox(temp_number){
            $('#table_id_' + temp_number + ' .instance_search_input').val('');
        }
        
        /**
         * For Add to Quote Plugin
         * YITH add to Quote Request plugin
         * @since 2.6 
         * @date 20.7.2018
         */
        //ywraq_frontend
        $('body').on('click','a.yith_add_to_quote_request.enabled',function(e){
            e.preventDefault();
            var thisButton = $(this); //New added at 4.0.19 
            if ( typeof ywraq_frontend === 'undefined' ){
                alert("Quote Request plugin is not installed.");
                return false;
            }
            var msg = $(this).data('msg');
            var response_msg = $(this).attr('data-response_msg');
            if(response_msg !== ''){
                alert(response_msg);
                $('.' + selector).html(msg.added);
                return false;
            }
            var selector = $(this).data('selector');
            $('.' + selector).html(msg.adding);
            var add_to_cart_info;
            var wp_nonce = $(this).data('wp_nonce');
            var product_id = $(this).data('product_id');
            
            var quantity = $(this).attr('data-quantity');
            var quote_data = $(this).attr('data-quote_data');
            var yith_browse_list = $(this).data('yith_browse_list');
            
            
            add_to_cart_info = 'action=yith_ywraq_action&ywraq_action=add_item';
            add_to_cart_info += quote_data;
            add_to_cart_info += '&quantity=' + quantity;
            add_to_cart_info += '&product_id=' + product_id;
            add_to_cart_info += '&wp_nonce=' + wp_nonce;
            add_to_cart_info += '&yith-add-to-cart=' + product_id;
            var yith_ajax_url;// = ywraq_frontend.ajaxurl;
            yith_ajax_url = ywraq_frontend.ajaxurl.toString().replace( '%%endpoint%%', 'yith_ywraq_action' );
            
            $.ajax({
            type   : 'POST',
            url    : yith_ajax_url,
            dataType: 'json',
            data   : add_to_cart_info,
            beforeSend: function(){

            },
            complete: function(){
            },
            success: function (response) {
                console.log(response);
                if( response && ( response.result === 'true' || response.result === 'exists' ) ){
                    $('.' + selector).html(msg.added);
                    if(response.result === 'exists'){
                        
                        $('.' + selector).attr('data-response_msg',response.message);
                        //alert(response.message);
                    }
                    var html;
                    //$('.wpt_quoterequest img').remove();
                    //$('.' + selector + '+.yith_ywraq_add_item_browse_message').remove();
                    //$('.' + selector + '+.yith_ywraq_add_item_response_message').remove();
                    html = '<div class="yith_ywraq_add_item_response_message">' + response.message + '</div>';
                    html += '<a href="'+response.rqa_url+'" target="_blank">' + yith_browse_list + '</a>';
                    
                    $('td.' + selector + '_td').html( html ); //response.label_browse
                    //$('.' + selector).hide();
                   
                }else{
                    $('.' + selector).html(msg.added);
                }
                //thisButton.parent().show();  //New added at 4.0.19 
            }
        });
        });
        
        loadMiniFilter();
        /**
         * Loading MiniFilter 's option based on loaded products
         * @since 4.8
         * 
         * @returns {void}
         */
        function loadMiniFilter(){
            $('.wpt_product_table_wrapper .wpt_filter_wrapper select.filter_select').each(function(){
                var id = $(this).attr('id');
                var temp_number = $(this).data('temp_number');
                var key =  $(this).data('key');
                var label =  $(this).data('label');

                var taxArray = new Array();
                $('#table_id_' + temp_number + ' tbody tr').each(function(){
                    var tax = $(this).data(key);
                    if(tax && tax !== ''){
                        tax = tax.replace(/,\s*$/, "");
                        tax = tax.replace(/\s/g, '');

                        tax = tax.split(',');

                        tax.forEach(function(item){
                            var taxDetails = item.split(':');
                            var taxID = taxDetails[0];
                            var taxValue = taxDetails[1];
                            taxArray[taxID] = taxValue;
                        });
                    }
                });
                //console.log(taxArray);
                /*
                if(config_json.sort_mini_filter === 'ASC'){
                    taxArray.sort(function(a,b){return a-b});
                }else if(config_json.sort_mini_filter === 'DESC'){
                    taxArray.sort(function(a,b){return b-a});
                }
                */
               var html = '<option value="">' + label + '</option>';
                taxArray.forEach(function(value,number){
                    html += '<option value="' + key + '_' + temp_number + '_' + number + '">' + value + '</option>';
                });
                $(this).html(html);
            });
        }
        /**
         * Colunm Sorting Option
         * 
         * @since 2.8
         * @date 26.7.2018
         */
        $('body').on('click','table.wpt_product_table thead tr th',function(){
            var inactivated_column = ['wpt_check','wpt_action','wpt_quantity'];
            var class_for_sorted = 'this_column_sorted';
            var temp_number = $(this).parent().data('temp_number');
            var target_class = '.' + $(this).attr('class').split(' ').join('.');
            var target_table_wrapper_id = '#table_id_' + temp_number;
            
            console.log(target_class);
            //for check box collumn //wpt_thumbnails //wpt_product_id
            if(target_class !== '.wpt_product_id' && target_class !== '.wpt_thumbnails' && target_class !== '.wpt_quick' && target_class !== '.wpt_Message' && target_class !== '.wpt_serial_number' && target_class !== '.wpt_quoterequest' && target_class !== '.wpt_check' && target_class !== '.wpt_quantity' && target_class !== '.wpt_action'){
            
                $(target_table_wrapper_id + ' .' +class_for_sorted).removeClass(class_for_sorted);
                
                //Again Class Reform after remove class
                target_class = '.' + $(this).attr('class').split(' ').join('.');

                var sort_type = $(this).attr('data-sort_type');
                
                if(!sort_type || sort_type === 'ASC'){
                    sort_type = 'ASC';
                    $(this).attr('data-sort_type','DESC');
                }else{

                    $(this).attr('data-sort_type','ASC');
                }
                var contentArray = [];
                var contentHTMLArray = [];
                var currentColumnObject = $(target_table_wrapper_id + ' table tbody td' + target_class);
                currentColumnObject.each(function(index){
                    var text,html = '';
                    text = $(this).text();
                    var product_id = $(this).parent('tr').data('product_id');

                    //Refine text
                    text = text + '_' + product_id;
                    var rowInsideHTMLData = $(this).parent('tr').html();

                    var thisRowObject = $('#table_id_'+ temp_number +' #product_id_' + product_id);
                    var thisRowAttributes = thisRowObject[0].attributes;
                    var thisRowAttributesHTML = '';
                    $.each(thisRowAttributes,function(i,item){

                        if(this.specified) {
                            thisRowAttributesHTML += this.name + '="' + this.value + '" ';
                        }

                    });
                    html += '<tr ' + thisRowAttributesHTML + '>';
                    html += rowInsideHTMLData;
                    html += '</tr>';
                    contentArray[index] = text;
                    contentHTMLArray[text] = html;
                });
                function sortingData(a, b){
                    
                    //Added at 3.4

                    if(target_class === '.wpt_price' || target_class === '.wpt_price.this_column_sorted') { //.wpt_price.this_column_sorted
                        a = ( a.match(/\d+\.\d+|\d+\b|\d+(?=\w)/g) || [] ).map(function (v) {return +v;});
                        a = a[0];

                        b = ( b.match(/\d+\.\d+|\d+\b|\d+(?=\w)/g) || [] ).map(function (v) {return +v;});
                        b = b[0];
                    }
                    var return_data;
                    if(sort_type === 'ASC'){
                        return_data = ((a < b) ? -1 : ((a > b) ? 1 : 0));
                    }else{
                        return_data = ((b < a) ? -1 : ((b > a) ? 1 : 0));
                    }
                    return return_data;
                  }
                  
                  var sortedArray = contentArray.sort(sortingData);
                  console.log(sortedArray);
                  var finalHTMLData = '';
                  $.each(sortedArray,function(index,value){
                      finalHTMLData += contentHTMLArray[value];
                  });

                //Backed HTML Data
                $(target_table_wrapper_id + ' table>tbody').html(finalHTMLData);

                $(target_table_wrapper_id + ' ' +target_class).addClass(class_for_sorted);
            }

        });
        
        
        //* Removeing link for cat and tag texonomy
        removeCatTagLings();
        /**
         * Removing Linkg for Categories link and from Tag's link.
         * We will remove link by JavaScript I mean: jQuery
         * 
         * @since 3.1
         * @date: 13 sept, 2018
         */
        function removeCatTagLings(){
           if(config_json.disable_cat_tag_link === '1'){
                $('.wpt_category a,.wpt_tags a').contents().unwrap();
            } 
        }
        // Removing link feature End here  */
        
        $(document).on('submit','form',function(e){
            WPT_BlankNotice();
            var product_id = $(this).parents('tr').data('product_id');
            var thisButton = $('tr.wpt_row_product_id_' + product_id + ' td.wpt_action button.single_add_to_cart_button');
            var thisTable = $(this).parents('div.wpt_product_table_wrapper');
            var table_id = $(this).parents('div.wpt_product_table_wrapper').attr('id');

            thisTable.addClass('loading');
            thisButton.removeClass('added');
            thisButton.addClass( 'disabled' );
            thisButton.addClass( 'loading' );
            var form = $(this);
            var url = form.attr('action');//ajax_url;//

            var method = form.attr('method');
            if( 'post' === method){
                e.preventDefault();
            }else{
                return;
            }
            
            $.post(url, form.serialize() + '&add-to-cart=' + product_id + '&_wp_http_referer=' + url, function(data,status,xh){ //form.serialize() + '&_wp_http_referer=' + url
                thisTable.removeClass('loading');
                var notice = $('.woocommerce-message,.woocommerce-error', data); //.woocommerce-error
                if(config_json.popup_notice === '1'){
                    WPT_NoticeBoard(notice);//Gettince Notice
                }
                    $( document.body ).trigger( 'added_to_cart' ); //Trigger and sent added_to_cart event
                    $( document ).trigger( 'wc_fragments_refreshed' );
                    thisButton.removeClass('disabled');
                    thisButton.removeClass('loading');
                    thisButton.addClass('added');
                //WPT_MiniCart();
            }).done(function(){
                
                //Quick Button Active here and it will go Directly to checkout Page
                if(config_json.product_direct_checkout === 'yes'){
                    window.location.href = checkoutURL;
                }
                //$( '.wpt_row_product_id_' + product_id + ' .wpt_action button.single_add_to_cart_button' ).addClass( 'added' );
                //$( '.wpt_row_product_id_' + product_id + ' .wpt_action button.single_add_to_cart_button' ).removeClass( 'disabled loading' );
                
            });
        });
        
        $('a.button.add_to_cart_all_selected').click(function() {
            WPT_BlankNotice();
            var temp_number = $(this).data('temp_number');
            var checkoutURL = $('#table_id_' + temp_number).data('checkout_url');
            //Add Looading and Disable class 
            var currentAllSelectedButtonSelector = $('#table_id_' + temp_number + ' a.button.add_to_cart_all_selected');
            currentAllSelectedButtonSelector.addClass('disabled');
            currentAllSelectedButtonSelector.addClass('loading');


            
            var add_cart_text = $('#table_id_' + temp_number).data('add_to_cart');
            
            var itemAmount = 0;
            
            $('#table_id_' + temp_number + ' input.enabled.wpt_tabel_checkbox.wpt_td_checkbox:checked').each(function() {
                WPT_BlankNotice();
                var product_id = $(this).data('product_id');
                var fullSelcetor = '#table_id_' + temp_number + ' #product_id_' + product_id + ' .wpt_action form';
                var thisButton = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' .wpt_action form button.single_add_to_cart_button');
                

                thisButton.removeClass('added');
                thisButton.addClass( 'disabled' );
                thisButton.addClass( 'loading' );
                
                var form = $(fullSelcetor);
                var url = form.attr('action');//ajax_url;//

                var method = form.attr('method');
                if( 'post' === method){
                    $.post(url, form.serialize() + '&add-to-cart=' + product_id + '&_wp_http_referer=' + url, function(data,status,xh){
                        var notice = $('.woocommerce-message,.woocommerce-error', data); //.woocommerce-error
                        if(config_json.popup_notice === '1'){
                            WPT_NoticeBoard(notice);//Gettince Notice
                        }
                        $( document.body ).trigger( 'added_to_cart' ); //Trigger and sent added_to_cart event
                        
                        thisButton.removeClass('disabled');
                        thisButton.removeClass('loading');
                        thisButton.addClass('added');
                    });
                }
                
                /*
                //added at 4
                var qtyElement = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' input.input-text.qty.text');
                var min_quantity = qtyElement.attr('min');
                if(min_quantity === '0' || typeof min_quantity === 'undefined'){
                    min_quantity = 1;
                }
                
                var currentAddToCartSelector = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' .wpt_action a.wpt_woo_add_cart_button');
                var currentCustomMessage = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' .wpt_Message input.message').val();
                var currentVariaionId = currentAddToCartSelector.data('variation_id');
                var currentVariaion = currentAddToCartSelector.data('variation');
                var currentQantity = $('#table_id_' + temp_number + ' table#wpt_table .wpt_row_product_id_' + product_id + ' .wpt_quantity .quantity input.input-text.qty.text').val();
                products_data[product_id] = {
                    product_id: product_id, 
                    quantity: currentQantity, 
                    variation_id: currentVariaionId, 
                    variation: currentVariaion,
                    custom_message: currentCustomMessage,
                };
                itemAmount++;
                */
               itemAmount++;
            });

            //Return false for if no data
            if (itemAmount < 1) {
                currentAllSelectedButtonSelector.removeClass('disabled');
                currentAllSelectedButtonSelector.removeClass('loading');
                alert('Please Choose items.');
                return false;
            }
            currentAllSelectedButtonSelector.removeClass('disabled');
            currentAllSelectedButtonSelector.removeClass('loading');
            $( document ).trigger( 'wc_fragments_refreshed' );
            if(config_json.all_selected_direct_checkout === 'yes'){
                window.location.href = checkoutURL;
            }
            currentAllSelectedButtonSelector.html(add_cart_text + ' [ ' + itemAmount + ' ' + config_json.add2cart_all_added_text + ' ]');
            uncheckAllCheck(temp_number);
            /*
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
                    //setFragmentsRefresh( response );                    
                    //WPT_MiniCart();
                    $( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $('added_to_cart') ] );
                    
                    currentAllSelectedButtonSelector.html(add_cart_text + ' [ ' + itemAmount + ' ' + config_json.add2cart_all_added_text + ' ]');
                    if(config_json.popup_notice === '1'){
                        WPT_NoticeBoard();//Loading Notice Board
                    } 
                    if(config_json.all_selected_direct_checkout === 'yes'){
                        window.location.href = checkoutURL;
                    }else{
                        currentAllSelectedButtonSelector.removeClass('disabled');
                        currentAllSelectedButtonSelector.removeClass('loading');
                    }
                     
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
                    });
                    uncheckAllCheck(temp_number);
                    
                },
                error: function() {
                    alert('Failed');
                },
            });
            */
        });
        
       
        $(document).on( 'reset_data', 'form.cart', function() {
            var temp_number = $(this).parents('td').data('temp_number');
            var product_id = $(this).parents('td').data('product_id');
            var quoted_target = 'yith_request_temp_' + temp_number + '_id_' + product_id;
            var addToQuoteSelector = $('.' + quoted_target);
            var checkBoxSelector = $('.wpt_check_temp_' + temp_number + '_pr_' + product_id);
            function enable_disable_class() {
                addToQuoteSelector.removeClass('enabled');
                addToQuoteSelector.addClass('disabled');
                
                checkBoxSelector.removeClass('enabled');
                checkBoxSelector.addClass('disabled');
            }
            enable_disable_class();
            
        });
        $(document).on( 'found_variation', 'form.cart', function( event, variation ) {
            var temp_number = $(this).parents('td').data('temp_number');
            var product_id = $(this).parents('td').data('product_id');
            
            var targetThumbs = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' td.wpt_thumbnails img');
            var quoted_target = 'yith_request_temp_' + temp_number + '_id_' + product_id;
            var addToQuoteSelector = $('.' + quoted_target);
            var checkBoxSelector = $('.wpt_check_temp_' + temp_number + '_pr_' + product_id);
            function targetTD(td_name) {
                var targetElement = $('#table_id_' + temp_number + ' #product_id_' + product_id + ' td.wpt_' + td_name);
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
            console.log(product_id,temp_number);
            //console.log(event);
            console.log(variation);
            //$(this).hide();
        });
        
        
        
        
        
        
        
        
        
    });
})(jQuery);