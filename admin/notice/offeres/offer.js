(function($) {
    'use strict';
    $(document).ready(function() {
        if(! $('body').hasClass('wpt_admin_body')){
            return false;
        }
        
        $(document.body).on('click','h1.wp-heading-inline',function(){
            loadOfferContent();
        });

        function loadOfferContent(){
            let url = "https://raw.githubusercontent.com/codersaiful/woo-product-table/3.0.4.2/admin/notice/offeres/offer.json";
            $.ajax({
                url: url,
                method: "GET",
                dataType: 'json',
                success:function(result){
                    let offer = result.offer;
                    let image_url = offer.image_url;
                    let target_link = offer.target_link;
                    let target_html = offer.target_html;
                    let selector = offer.display_wrapper + " " + offer.display_to;
                    let html = `
                    <div class="wpt-special-offer">
                        <a href="`+ target_link +`" target="_blank">
                            <img src="` + image_url + `">
                        </a>
                    </div>
                    `;
                    $(selector).prepend(html);
                    console.log(result,selector);
                },
                fail:function(){
                    alert(2323);
                }
            });
        }
    });    
})(jQuery);