(function($) {
    'use strict';
    $(document).ready(function() {
        //alert(1212121221);
        $('body').on('click','.notice.is-dismissible.nttc-notice button.notice-dismiss',function(){
            var ajax_url = $(this).parent().data('ajax-url');
            var name = $(this).parent().data('name');
            console.log(ajax_url);
            $.ajax({
                type: 'POST',
                url: ajax_url,
                data:{
                    action: 'dismission',
                    name: name,
                },
                success: function(response){
                    console.log(response);
                },
                error: function() {
                    console.log("Ajax Error");
                },
            });
        });
        $('.notice.is-dismissible.nttc-notice a').attr('target','_blank');
        $('.notice.is-dismissible.nttc-notice a').css({border: 'none'});
    });
})(jQuery);