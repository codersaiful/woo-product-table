(function($) {
    'use strict';
    $(document).ready(function() {

        
        var myTable = $('#table_id_19566 table').DataTable();

        //wpt_query_done
        //wpt_query_progress
        $(document.body).on('wpt_query_done',function(){
            console.log(myTable);
            myTable.clear().draw();
        });

    });
})(jQuery);