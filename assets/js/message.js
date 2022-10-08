jQuery(function($) {
    'use strict';
    $(document).ready(function() {
        var base_data = WPT_DEACTIVE_DATA;



        let prefix = base_data.prefix;
        let wrapper_id = '#' + prefix + '-survey-form-wrap';
        let deactive_btn_id = '#deactivate-' + base_data.plugin_slug;

        var wrapperElement = $(wrapper_id);
        var FormElementWrapper = wrapperElement.find('ca-survey-form');
        var deactiveBtn = $(deactive_btn_id);

        $(document.body).on('click',function(){
            
        });

        console.log(base_data,"Something");
        
    });
});
