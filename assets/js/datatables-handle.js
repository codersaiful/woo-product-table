(function($) {
    'use strict';
    $(document).ready(function() {

        let table_selector = '.wpt-datatable table.wpt_product_table';

        var myTable = $(table_selector).DataTable(WPT_DATATABLE);

        //wpt_query_done
        //wpt_query_progress
        $(document.body).on('wpt_query_done',function(){
            // $(table_selector).off();
            // console.log(myTable);
            // myTable.clear().draw();
        });

        $(document.body).on('click','input.wpt-preview-shortcode-input', function(){
            // alert(3333);
            // $(table_selector).DataTable(WPT_DATATABLE);
        });
    });
})(jQuery);