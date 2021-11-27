(function($) {
    'use strict';
    $(document).ready(function() {
        if(! $('body').hasClass('wpt_admin_body')){
            return false;
        }
        let url = "https://raw.githubusercontent.com/codersaiful/woo-product-table/3.0.4.2/admin/notice/offeres/offer.json";
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'json',
            success:function(result){
                console.log(result);
            },
            fail:function(){
                alert(2323);
            }
        });
    });    
})(jQuery);