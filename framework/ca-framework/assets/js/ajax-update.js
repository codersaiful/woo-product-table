jQuery( document ).ready( function() {
	jQuery( document ).on( 'click', '.ca-notice-dismiss', function(event) {
        let parentWrap = jQuery(this).closest('.notice.ca-notice');
        let notice_id = parentWrap.data('notice_id');
        parentWrap.fadeOut();
        var data = {
            action: 'update_notice_status',
            notice_id: notice_id
        };

		jQuery.post( ajaxobj.ajaxurl, data, function(res) {
            
		});
    });
});

