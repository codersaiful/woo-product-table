(function($) {
    'use strict';
    $(document).ready(function() {
        if(! $('body').hasClass('wpt_admin_body')){
            return false;
        }

        let wrapper_class = '.wpt-special-offer';
        loadOfferContent();
        
        function loadOfferContent(){
            let offer_json = getCookie('wpt_offer_latest');
            if( offer_json !== '' ){
                
                offer_json = JSON.parse(offer_json);
                console.log(offer_json);
                jsonToHtmlMarkup(offer_json);

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
                        jsonToHtmlMarkup(result);
                    }
                    
                },
                error:function(e){
                    console.log("Something went wrong.");
                }
            });
        }

        function jsonToHtmlMarkup(result){
            if(! result.offer.status){
                return;
            }
            let offer = result.offer,
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
            
            
            $(location_selector).prepend(html);
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