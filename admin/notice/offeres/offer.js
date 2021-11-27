(function($) {
    'use strict';
    $(document).ready(function() {
        if(! $('body').hasClass('wpt_admin_body')){
            return false;
        }
        
        $(document.body).on('click','h1.wp-heading-inline',function(){
            loadOfferContent();
        });
        loadOfferContent();

        function loadOfferContent(){
            let url = "https://raw.githubusercontent.com/codersaiful/woo-product-table/3.0.4.2/admin/notice/offeres/offer.json";
            $.ajax({
                url: url,
                method: "GET",
                dataType: 'json',
                success:function(result){
                    jsonToHtmlMarkup(result);
                    
                    
                    console.log(result);
                },
                fail:function(){
                    alert(2323);
                }
            });
        }

        function jsonToHtmlMarkup(result){
            let wrapper_class = '.wpt-special-offer',
            offer = result.offer,
            image_url = offer.image_url,
            target_link = offer.target_link,
            target_html = offer.target_html,
            wrapper_css = offer.wrapper_css,
            image_css = offer.image_css;

            let location_selector = offer.display_wrapper + " " + offer.display_to;

            $(wrapper_class).remove();

            let image_link_html = "";
            if( image_url && target_link ){
                image_link_html = `<a class="offer_image_link" href="`+ target_link +`" target="_blank">
                    <img class="offer_image" src="` + image_url + `">
                </a>`;
            }

            if(!target_html){
                target_html=""
            }

            let html = `<div class="wpt-special-offer">` + image_link_html + target_html + `</div>`;
            if(image_css){
                $(wrapper_class).find("img.offer_image").css(image_css);
            }
            $(location_selector).prepend(html);
            $(wrapper_class).css(wrapper_css);
        }

    });    
})(jQuery);