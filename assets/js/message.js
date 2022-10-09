jQuery(function($) {
    'use strict';
    $(document).ready(function() {
        var base_data = WPT_DEACTIVE_DATA;


        var validation;
        let prefix = base_data.prefix;
        let wrapper_id = prefix + '-survey-form-wrap';
        let wrapper_id_selector = '#' + wrapper_id;
        var deactive_btn_selector = '#deactivate-' + base_data.plugin_slug;

        var wrapperElement = $(wrapper_id_selector);
        var FormElementWrapper = wrapperElement.find('ca-survey-form');
        var deactiveBtn = $(deactive_btn_selector);
        var deactiveURL = deactiveBtn.attr('href');
        let ourServer = 'http://edm.ultraaddons.com';//'http://wpp.cm';//noslush


        $(document.body).on('submit',wrapper_id_selector + ' .ca-survey-form form.ca-deactive-form',function(e){
            e.preventDefault();
            validation = formSubmitValidation();
            if(validation){
                $(this).find('button.ca_button.ca-submit-form').html('Submitting...');
                var formData = $(this).serializeArray();
                var token_number = $(this).find('input.token_number').val();

                var ajax_url = ourServer + '/wp-admin/admin-ajax.php';
                var data = {
                    action: 'ca-plugin-user-data-collection',
                    datas: formData,
                    token_number: token_number,
                    base_data: base_data,
                };
                $.ajax({
                    type: 'POST',
                    url: ajax_url,
                    data: data,
                    success:function(result){
                        deactiveNow();
                    },
                    complete:function(){
                        deactiveNow();

                    },
                    error:function(){
                        deactiveNow();
                    }
                });
            }
        });

        function formSubmitValidation(){

            return true;
        }

        function formReset(){
            $(wrapper_id_selector + ' .ca-survey-form form.ca-deactive-form')[0].reset();
        }
        /**Form Open on deactive button click */
        $(document.body).on('click', deactive_btn_selector,function(e){
            e.preventDefault();
            wrapperElement.fadeIn();
        });
        //Skip and Deactive
        $(document.body).on('click', wrapper_id_selector + ' a.ca_skip',function(){
            deactiveNow();
        });
        /**Dont deactive. Keep it */
        $(document.body).on('click', 'a.ca_cancel',function(e){
            e.preventDefault();
            formHide();
        });

        $(document.body).on('click',function(e){
            
            if(e.target.id == wrapper_id){
                e.preventDefault();
                formHide();
            }
        });



        function formHide(){
            wrapperElement.fadeOut();
            formReset();
        }
        function deactiveNow(){
            formHide();
            window.location = deactiveURL;
        }
        
    });
});
