/* 
 * Only for Fronend Section
 * @since 1.0.0
 */


jQuery(function($) {
    'use strict';
    $(document).ready(function(){
        $(document.body).on('click', 'a.ajax_active.button.wpt_woo_add_cart_button.add_to_cart_button', function(e) {
            // alert(2222);
            e.preventDefault();
            let newAajaxURL = wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'add_to_cart' );
            console.log(newAajaxURL);

            let myDataWCTypes = {
                product_id: "1357",
                product_sku: "",
                quantity: "50"
            };
            var $thisbutton = $(this);
            $.ajax({
                type: 'POST',
                url: newAajaxURL,// + get_data,
                data: myDataWCTypes,
                dataType: 'json',
                success: (response) => {
                    $thisbutton.html("Added");
                    console.log(response);
                    $( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash ] );
                    // $( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $thisbutton ] );
                    // $( document ).trigger( 'wc_fragment_refresh' );
                    // $( document ).trigger( 'cart_page_refreshed' );
                    // $( document ).trigger( 'cart_totals_refreshed', [ response.fragments, response.cart_hash ] );
                    // $( document ).trigger( 'cart_totals_refreshed' );
                    // // $( document ).trigger( 'wc_fragments_refreshed' ); //This is effective
                    // $( document.body ).trigger( 'update_checkout' );
                }
            });
            return;
        });
    });
});
