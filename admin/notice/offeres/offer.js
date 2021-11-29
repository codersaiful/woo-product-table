(function($) {
    'use strict';
    $(document).ready(function() {
        if(! $('body').hasClass('wpt_admin_body')){
            return false;
        }

        
        
        loadOfferContent();

        $(document.body).on('click','h1.wp-heading-inline',function(){
            console.log("Trigger for new json");
            loadContentByAjax();
        });
        
        function loadOfferContent(){
            let offer_json = getCookie('wpt_offer_latest');
            if( offer_json !== '' ){
                
                offer_json = JSON.parse(offer_json);
                jsonOfferToHtmlMarkup(offer_json);
                jsonNoticeToHtmlMarkup(offer_json)

            }else if(navigator.onLine){
                loadContentByAjax();
            }
            
        }

        function loadContentByAjax(){
            let url = "https://raw.githubusercontent.com/codersaiful/woo-product-table/master/admin/notice/offeres/offer.json";
            $.ajax({
                url: url,
                method: "GET",
                dataType: 'json',
                success:function(result){
                    if(result && result !== ''){
                        setCookie('wpt_offer_latest',JSON.stringify(result),2);//For Two days
                        jsonOfferToHtmlMarkup(result);
                        
                        jsonNoticeToHtmlMarkup(result);
                    }
                    
                },
                error:function(e){
                    console.log("Something went wrong.");
                }
            });
        }
        function jsonNoticeToHtmlMarkup(result){

            if( ! result.hasOwnProperty('notice') ){
                return;
            }

            if(! result.notice.status ){
                return;
            }
            let notice = result.notice;
            
            jsonToHtml(notice, 'notice-wrapper');

        }
        function jsonOfferToHtmlMarkup(result){
            
            if( ! result.hasOwnProperty('offer') ){
                return;
            }

            if( typeof WPT_DATA_ADMIN.is_pro === 'string' && WPT_DATA_ADMIN.is_pro === 'yes' ){
                return;
            }
            if(! result.offer.status ){
                return;
            }
            let offer = result.offer;
            jsonToHtml(offer, 'offer-wrapper');

        }

        function jsonToHtml(offer,custom_wrapper_class){
            
            let target_function = offer.target_function,
            image_url = offer.image_url,
            target_link = offer.target_link,
            target_html = offer.target_html,
            wrapper_css = offer.wrapper_css,
            image_css = offer.image_css;

            let wrapper_class = '.wpt-unique-' + custom_wrapper_class;
            

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

            let html = `<div class="wpt-special-offer wpt-unique-` + custom_wrapper_class + `">` + image_link_html + target_html + `</div>`;
            
            if( !target_function ){
                target_function = 'prepend'
            }

            
            if( target_function === 'prepend' ){
                $(location_selector).prepend(html);
            }else if(target_function === 'append'){
                $(location_selector).append(html);
            }else if(target_function === 'html'){
                $(location_selector).html(html);
            }else{
                $(location_selector).prepend(html);
            }
            
            $(wrapper_class).css(wrapper_css);

            if(image_css){
                $(wrapper_class).find("img.offer_image").css(image_css);
            }
        }

        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for(let i = 0; i <ca.length; i++) {
              let c = ca[i];
              while (c.charAt(0) == ' ') {
                c = c.substring(1);
              }
              if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
              }
            }
            return "";
        }

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000)); //(exdays*24*60*60*1000)
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

    });    
})(jQuery);