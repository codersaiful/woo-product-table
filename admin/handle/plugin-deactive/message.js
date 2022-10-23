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
        let ourServer = 'http://edm.ultraaddons.com';//'http://wptheme.cm';//noslush


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

        $(document.body).on('change',wrapper_id_selector + " .ca-msg-field-wrapper input[type='radio']",function(){

            var target = $(this).data('target_display');
            wrapperElement.find('.common-target').hide();
            if(typeof target !== 'undefined' && target !== ''){
                wrapperElement.find('.' + target).fadeIn();
            }else{
                console.log("Nothing");
                wrapperElement.find('.common-target').fadeOut();
            }
            
        });

        function formSubmitValidation(){

            return true;
        }

        function formReset(){
            var form = $(wrapper_id_selector + ' .ca-survey-form form.ca-deactive-form');
            form[0].reset();
            form.find('button.ca-submit-form').html('Submit & Deactivate');
            wrapperElement.find('.common-target').fadeOut();
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
