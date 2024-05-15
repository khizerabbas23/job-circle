jQuery(document).on('click', '.jobcircle-delete-user-job-alert', function () {
    var _this = jQuery(this);
    var alertID = _this.attr('data-id');
    if (alertID > 0) {
        var confirmBox = confirm('Are you sure!');
        if (confirmBox) {
            _this.find('i').attr('class', 'fa fa-refresh fa-spin');
            var request = jQuery.ajax({
                url: jobcircle_cscript_vars.ajax_url,
                method: "POST",
                data: {
                    'alert_id': alertID,
                    'action': 'jobcircle_user_job_alert_delete',
                },
                dataType: "json"
            });

            request.done(function (response) {
                _this.parents('tr').fadeOut();
            });

            request.fail(function (jqXHR, textStatus) {
                _this.parents('tr').fadeOut();
            });
        }
    }
});

jQuery(document).on('click', '.jobcircle-savejobalrts-btn', function (ev) {

    var _this = jQuery(this), _formData = new FormData(jQuery(`#jobcircle-job-alerts-form`)[0]);
    _this.text("Loading...");
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        data: _formData,
        contentType: false,
        cache: false,
        processData: false,
        url: jobcircle_cscript_vars.ajax_url,
        success: function (data) {
            _this.text("Create Alert");
            if(data.success == true) {
                jobcircle_submit_msg_alert(data.message, 'jobcircle-alert-success');
                jQuery("#JobCircleJobAlertsModal").modal("toggle");
                location.reload(true)
            } else {
                jobcircle_submit_msg_alert(data.message, 'jobcircle-alert-danger');
            }
        },
        error: function () {
            console.info("error")
        }
    })
});

jQuery(document).on('click', '.jobcircle-alertfilter-btn', function (ev) {
    ev.preventDefault();
    var _this = jQuery(this),_alertsName = jQuery("input[name=alerts_name]"), _alertEmail = jQuery("input[name=alerts_email]"),
        _jobFrequency = jQuery("input[name=job_frequency]:checked"), _modalSelector = jQuery("#JobCircleJobAlertsModal");
    if ("" == _alertsName.val()) {
        _alertsName.addClass("error");
        return;
    } else {
        _alertsName.removeClass("error")
    }

    if ("" == _alertEmail.val()) {
        _alertEmail.addClass("error")
        return;
    } else {
        _alertEmail.removeClass("error")
    }
    _this.text("Loading...")
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: jobcircle_cscript_vars.ajax_url,
        data: {
            alerts_name: _alertsName.val(),
            alerts_email: _alertEmail.val(),
            alerts_frequency: _jobFrequency.val(),
            action: "create_job_alert",
        },
        success: function (data) {
            _modalSelector.find(".modal-body").html("");
            _modalSelector.find(".modal-body").append(data.html);
            jQuery("#JobCircleJobAlertsModal").modal("toggle");
            _this.text("Create Alert")
        },
        error: function () {
            console.info("error")
        }
    });
});

jQuery('.jobcircle-dash-jobalert-update-btn').on('click', function (e) {
    e.preventDefault();

    var _this = jQuery(this), _modalSelector = jQuery("#JobCircleJobAlertsModal"),
        _alertId = _this.attr('data-id');

    _this.html('<i class="fa fa-refresh fa-spin"></i>');

    var request = jQuery.ajax({
        type: "POST",
        url: jobcircle_cscript_vars.ajax_url,
        data: {
            alert_id: _alertId,
            action: 'jobcircle_alrtmodal_popup_show',
        },
        dataType: "json",
    });
    request.done(function (response) {
        _modalSelector.find(".modal-body").html("");
        _modalSelector.find(".modal-body").append(response.html);
        jQuery("#JobCircleJobAlertsModal").modal("toggle");
        _this.html('<i class="fa fa-pencil"></i>');
    });
    request.fail(function () {
        console.info("asdasdasd")
    });
});