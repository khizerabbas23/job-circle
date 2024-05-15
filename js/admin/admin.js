function jobcircle_submit_msg_alert(msg, alert_class = 'jobcircle-alert-info') {
    var id = Math.floor(Math.random() * 1000000) + 1;
    jQuery('body').find('.jobcircle-alert-msg').remove();
    jQuery('body').append('<div id="alert-' + id + '" class="jobcircle-alert-msg ' + alert_class + '">' + msg + '</div>');
    setTimeout(function () {
        jQuery('#alert-' + id).remove();
    }, 8000);
}
jQuery(document).on("click", ".jobcircle-upload-media", function () {
    var id = jQuery(this).attr("data-id");
    var custom_uploader = wp.media({
        title: 'Select Image',
        button: {
            text: 'Add Image'
        },
        library: {
            type: [ 'image' ]
        },
        multiple: false
    })
        .on('select', function () {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('#' + id).val(attachment.url);
            jQuery('#' + id + '-img').attr('src', attachment.url);
            jQuery('#' + id + '-box').show();
        }).open();
});
jQuery(document).on("click", ".jobcircle-rem-media-b", function () {
    var id = jQuery(this).data('id');
    jQuery('#' + id).val('');
    jQuery('#' + id + '-img').attr('src', '');
    jQuery('#' + id + '-box').hide();
});

jQuery(".jobcircle-frequency-val").on('change', function () {
    var _this = jQuery(this), _frequencyVal = _this.attr('data-name');
    if(_this.val() == "on") {
        _this.val("off")
        jQuery(`input[name=${_frequencyVal}]`).val("off")
    } else {
        _this.val("on")
        jQuery(`input[name=${_frequencyVal}]`).val("on")
    }
});

jQuery(document).ready(function($) {
    // Show modal dialog
    $(document).on('click', '.jobcircle-user-verify', function(e) {
        e.preventDefault();        
        var _this   = jQuery(this);
        // Get the data-id attribute value
        var dataId = $(this).data('user_id');        
        var verify_type = $(this).data('verify_type');  

        // Show modal dialog
        $('#jobcircle-confirmation-modal').show().data({user_id: dataId, verify_type:verify_type});
    });

    // Hide modal dialog and handle user response
    $('#jobcircle-confirm-yes').on('click', function() {
        // Get the data-id attribute value from the modal
        var dataId = $('#jobcircle-confirmation-modal').data('user_id');
        var verify_type = $('#jobcircle-confirmation-modal').data('verify_type');

        var nonce = jobcircle_admin_object.jobcircle_admin_nonce;
        // Make AJAX request
        $.ajax({
            url: jobcircle_admin_object.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
                action: 'jobcircle_user_verify_request',
                user_id: dataId,
                verify_type: verify_type,
                jobcircle_admin_nonce: nonce
            },
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-WP-Nonce', nonce);
            },
            success: function(data) {
                // Handle success response
                if (data.error == '0') {
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
                    $('#jobcircle-confirmation-modal').hide();
                    $('.jobcircle-useritem-' + dataId +'-'+verify_type).html(data.status);
                    if(verify_type == 'reject'){         
                        $('.jobcircle-useritem-' + dataId +'-reject').removeClass('jobcircle-user-verify');
                        $('.jobcircle-useritem-' + dataId +'-verify').addClass('jobcircle-user-verify');
                        $('.jobcircle-useritem-' + dataId +'-verify').html(data.veify_title);               
                    } else if(verify_type == 'verify'){
                        $('.jobcircle-useritem-' + dataId +'-verify').removeClass('jobcircle-user-verify');
                        $('.jobcircle-useritem-' + dataId +'-reject').addClass('jobcircle-user-verify');
                        $('.jobcircle-useritem-' + dataId +'-reject').html(data.reject_title);
                    }                    
                } else {
                    $('#jobcircle-confirmation-modal').hide();
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
                }
            },
            error: function(xhr, status, error) {
                $('#jobcircle-confirmation-modal').hide();
                jobcircle_submit_msg_alert(xhr.responseText, 'jobcircle-alert-danger');
            }
        });
       
    });

    $('#jobcircle-confirm-no').on('click', function() {
        // Hide modal dialog
        $('#jobcircle-confirmation-modal').hide();
    });
});
