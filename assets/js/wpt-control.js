(function( $ ) {
    // var ajax_url = WPT_DATA.ajax_url;
    $.wptAjax = function(table_id,args,page_number,ajax_url) {
        console.log(table_id,args,page_number,ajax_url);
        
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
                console.log("Error on: loadTablePagi. Error on Ajax load!");
            }
        });
    };
 
}( jQuery ));