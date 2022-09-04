jQuery(function($) {
    'use strict';
    $(document).ready(function() {
        
        var plugin_url = WPT_DATA.plugin_url;
        var include_url = WPT_DATA.include_url;
        var content_url = WPT_DATA.content_url;
        
        var ajax_url = WPT_DATA.ajax_url;
        var site_url = WPT_DATA.site_url;
        
        
        var ajaxTableLoad = function(table_id,args,page_number){
            console.clear();
            var thisTable = $('#table_id_' + table_id);
            if( thisTable.length < 1 ){
                console.log("Error on: ajaxTableLoad. Table not founded!");
                return;
            }
            
            var data = {
                action: 'wpt_load_both',
                table_id: table_id,
                page_number: page_number,
                args: args,
            };
            
            thisTable.addClass('wpt-ajax-loading'); //.wpt_product_table_wrapper.wpt-ajax-loading
            $.ajax({
                type: 'POST',
                url: ajax_url,
                data: data,
                success:function(result){
                    // $('.wpt_edit_table').html(result);
                    if ( result ) {
                        $.each( result, function( key, value ) {
                            if('string' === typeof key){
                                let selectedElement = $('#table_id_' + table_id + ' ' + key);
                                if(typeof selectedElement === 'object'){
                                    selectedElement.html( value );
                                }
                            }
                        });
                    }

                    thisTable.removeClass('wpt-ajax-loading');

                },
                complete:function(){
                    thisTable.removeClass('wpt-ajax-loading');
                },
                error:function(){
                    thisTable.removeClass('wpt-ajax-loading');
                    console.log("Error on: ajaxTableLoad. Error on Ajax load!");
                }
            });
        };

        $(document.body).on('click','.wpt_pagination_ajax .wpt_my_pagination a',function(e){
            e.preventDefault();
            var thisButton = $(this);
            var thisPagination = thisButton.closest('.wpt_my_pagination');
            var page_number = $(thisButton).text();
            
            var table_id = thisPagination.data('table_id');
            var args = getSearchQueriedArgs( table_id );
            console.log(args);
            
            ajaxTableLoad(table_id, args, page_number );
            
        });

        $(document.body).on('click','.wpt-search-products',function(){
            
            let table_id = $(this).data('table_id');
            var args = getSearchQueriedArgs( table_id );
            
            var page_number = 1;
            
            ajaxTableLoad(table_id, args, page_number );
            
        });

        function getSearchQueriedArgs( table_id ){
            let value,key;
            var texonomies = {};
            value = false;
            $('#search_box_' + table_id + ' .search_select.query').each(function(){
                
                key = $(this).data('key');
                value = $(this).val();
                if(value != ""){
                    texonomies[key] = value;
                }
            });

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
                }
            });

            var custom_field = {},meta_query  = {}, multiple_attr = {};

            $('#search_box_' + table_id + ' .search_select.cf_query').each(function(){
                var attr = $(this).attr('multiple');
                
                key = $(this).data('key');
                value = $(this).val();
                if(value != ""){
                    custom_field[key] = value;
                    multiple_attr[key] = attr;
                }
            });
            Object.keys(custom_field).forEach(function(key,bbb){
                 if(Object.keys(custom_field[key]).length > 0){ //custom_field[key] !== null && 
                    var compare = multiple_attr[key];
                    
                    if(! compare){
                        meta_query[key] = {
                                    key: key,  
                                    value:  custom_field[key],
                                    compare: 'LIKE'
                            };   
                    }else{
                        meta_query[key] = {
                                    key: key,  
                                    value:  custom_field[key]
                            }; 
                    }
                } 
            });
            

            var s= $('#search_box_' + table_id + ' .search_single_direct .query-keyword-input-box').val();
            
            
            var args = {
                s: s,
                tax_query: tax_query,
                meta_query: meta_query,
            };
            return args;
        }

    });
});
(function( $ ) {

    

    var ajax_url = WPT_DATAS.ajax_url;

    $.TableLoadAjax = function(table_id,args,page_number,ajax_url) {
        console.log(table_id,args,page_number);
        
        var thisTable = $('#table_id_' + table_id);
        if( thisTable.length < 1 ){
            console.log("Error on: loadTablePagi. Table not founded!");
            return;
        }
        var data = {
            action: 'wpt_load_both',
            table_id: table_id,
            page_number: page_number,
            args: args,
        };
        thisTable.addClass('wpt-ajax-loading'); //.wpt_product_table_wrapper.wpt-ajax-loading
        $.ajax({
            type: 'POST',
            url: ajax_url,
            data: data,
            success:function(result){
                $('.wpt_edit_table').html(result);
                // if ( result === 5) {
                //     $.each( result, function( key, value ) {
                //         if('string' === typeof key){
                //             let selectedElement = $('#table_id_' + table_id + ' ' + key);
                //             if(typeof selectedElement === 'object'){
                //                 selectedElement.html( value );
                //             }
                //         }
                //     });
                // }

                thisTable.removeClass('wpt-ajax-loading');

            },
            complete:function(){
                thisTable.removeClass('wpt-ajax-loading');
            },
            error:function(){
                thisTable.removeClass('wpt-ajax-loading');
                console.log("Error on: loadTablePagi. Error on Ajax load!");
            }
        });
    };
 
}( jQuery ));