var jobcircle_geoloc_curr_request;

jQuery('.jobcircle-nav-ntogler ul.navigation').find('>li>a').on('click', function(ev) {
	var this_an = jQuery(this);
	if (this_an.parent('li').find('ul').length > 0) {
		ev.preventDefault();
		this_an.parent('li').find('ul').toggleClass('show');
	}
});

// Home 14 main menu
// MobileNav init
jQuery('.nav-opener-clal').on('click', function (e) {
	e.preventDefault();

	jQuery('body').toggleClass('nav-active');
});

jQuery('.nav-close').on('click', function (e) {
	e.preventDefault();
	if(jQuery('body').hasClass('nav-active')) {
		jQuery('body').removeClass('nav-active');
	}
});

// Resize Effect function
function initResizeEffect() {
	jQuery(window).resize(function () {
		if(jQuery(window).width() > 991) {
			jQuery('body').removeClass('nav-active');
		}
	});
}

// reCaptcha
function jobcircle_multicap_all_functions() {
    var all_elements = jQuery(".g-recaptcha");
    for (var i = 0; i < all_elements.length; i++) {
        var id = all_elements[i].getAttribute('id');
        var site_key = all_elements[i].getAttribute('data-sitekey');
        if (null != id) {
            grecaptcha.render(id, {
                'sitekey': site_key
            });
        }
    }
}

function jobcircle_captcha_reload(admin_url, captcha_id) {
    "use strict";
    jQuery("#" + captcha_id + "_div").append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
    var dataString = '&action=jobcircle_captcha_reload&captcha_id=' + captcha_id;
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        dataType: 'html',
        success: function (data) {
            jQuery("#" + captcha_id + "_div").html(data);
            jQuery("#" + captcha_id + "_div").find('.jobcircle-loder-con').remove();
        },
        error: function() {
            jQuery("#" + captcha_id + "_div").find('.jobcircle-loder-con').remove();
        }
    });
}

jQuery(document).ready(function () {

    if (jQuery('.jobcircle-user-form').find('.form-security-fields').length > 0) {
        var request = jQuery.ajax({
            url: jobcircle_cscript_vars.ajax_url,
            method: "POST",
            data: {
                adding: 'reg_referrer_field',
                action: 'jobcircle_add_form_referrer_field_call'
            },
            dataType: "json"
        });
        request.done(function (response) {
            jQuery('.jobcircle-user-form').find('.form-security-fields').html(response.html);
        });
    }
});

function jobcircle_submit_msg_alert(msg, alert_class = 'jobcircle-alert-info') {
    var id = Math.floor(Math.random() * 1000000) + 1;
    jQuery('body').find('.jobcircle-alert-msg').remove();
    jQuery('body').append('<div id="alert-' + id + '" class="jobcircle-alert-msg ' + alert_class + '">' + msg + '</div>');
    setTimeout(function () {
        jQuery('#alert-' + id).remove();
    }, 8000);
}


jQuery(document).on('submit', '.jobcircle-user-form', function (ev) {
    ev.preventDefault();
    var this_form = jQuery(this);

    let action  = this_form.find("input[name=action]").val();

    if( action == 'jobcircle_user_register_action'){
        if (this_form.find('.jobcircle-terms-checkbox').length > 0){
            if (!this_form.find('.jobcircle-terms-checkbox').is(':checked')) {
                jobcircle_submit_msg_alert(jobcircle_cscript_vars.terms_cond_checked, 'jobcircle-alert-info');
                return false;
            }
        }
    }

    var this_btn = this_form.find('button[type=submit]');
    var button_html = this_btn.html();
    var from_element = this_form[0];
    var form_data = new FormData(from_element);

    if (!this_form.hasClass('ajax-processing')) {
        if (this_form.hasClass('loding-onall-con')) {
            this_form.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
            var elem_to_got = this_form.find('.jobcircle-loder-con');
            jQuery('html, body').animate({scrollTop: elem_to_got.offset().top - 100}, 1000);
        }
        this_btn.html(jobcircle_cscript_vars.submiting);

        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: jobcircle_cscript_vars.ajax_url,
            processData: false,
            contentType: false,
            data: form_data,
            success: function (data) {
                if (data.error == '0') {
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
                } else if (data.error == '2') {
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-info');
                } else {
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
                }
                if (typeof data.redirect !== undefined && data.redirect != undefined && data.redirect != '') {
                    if (data.redirect == 'same') {
                        window.location.reload();
                    } else {
                        window.location.replace(data.redirect);
                    }
                    return false;
                }
                this_btn.html(button_html);
                this_form.removeClass('ajax-processing');
                if (this_form.hasClass('loding-onall-con')) {
                    this_form.find('.jobcircle-loder-con').remove();
                }
            },
            error: function () {
                this_btn.html(button_html);
                this_form.removeClass('ajax-processing');
                if (this_form.hasClass('loding-onall-con')) {
                    this_form.find('.jobcircle-loder-con').remove();
                }
            }
        });
    }

    this_form.addClass('ajax-processing');
});
//
jQuery(document).on('click', '.login-to-regconv', function (ev) {
    ev.preventDefault();
    var reg_con_holder = jQuery('.popup-signupsec-con');
    var log_con_holder = jQuery('.popup-loginsec-con');
    if(jQuery('.popup-pass-reset-form').length > 0) {
        var resetpass_con_holder = jQuery('.popup-pass-reset-form');
        resetpass_con_holder.hide();
    }
    log_con_holder.hide();
    reg_con_holder.slideDown();
});

jQuery(document).on('click', '.reg-to-loginconv', function (ev) {
    ev.preventDefault();
    var reg_con_holder = jQuery('.popup-signupsec-con');
    var log_con_holder = jQuery('.popup-loginsec-con');
    var frgtpass_con_holder = jQuery('.popup-frgt-pass');

    if(jQuery('.popup-pass-reset-form').length > 0) {
        var resetpass_con_holder = jQuery('.popup-pass-reset-form');
        resetpass_con_holder.hide();
    }
    reg_con_holder.hide();
    frgtpass_con_holder.hide();
    log_con_holder.slideDown();
});

jQuery(document).on('click', '.jobcircle-frgtpass-btn', function (ev) {
    ev.preventDefault();
    var reg_con_holder = jQuery('.popup-signupsec-con');
    var log_con_holder = jQuery('.popup-loginsec-con');
    var frgtpass_con_holder = jQuery('.popup-frgt-pass');
    if(jQuery('.popup-pass-reset-form').length > 0) {
        var resetpass_con_holder = jQuery('.popup-pass-reset-form');
        resetpass_con_holder.hide();
    }
    reg_con_holder.hide();
    log_con_holder.hide();
    frgtpass_con_holder.slideDown();
});

jQuery('.jobcircle-user-pkg-buybtn').on('click', function (ev) {
    ev.preventDefault();
    var _this = jQuery(this);
    var this_parent = _this.parents('.pricing_wrap');

    var pkg_id = _this.data('id');

    this_parent.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
    var elem_to_got = this_parent.find('.jobcircle-loder-con');
    jQuery('html, body').animate({scrollTop: elem_to_got.offset().top - 100}, 1000);

    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: jobcircle_cscript_vars.ajax_url,
        data: {
            pkg_id: pkg_id,
            action: 'jobcircle_member_pckgbuy_call'
        },
        success: function (data) {
            if (data.error == '0') {
                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
            } else if (data.error == '2') {
                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-info');
            } else {
                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
            }
            if (typeof data.redirect !== undefined && data.redirect != undefined && data.redirect != '') {
                window.location.href = data.redirect;
                return false;
            }
            this_parent.find('.jobcircle-loder-con').remove();
        },
        error: function () {
            this_parent.find('.jobcircle-loder-con').remove();
        }
    });
});


jQuery('.jobdet-applybtn-act').on('click', function () {
    var _this = jQuery(this);
    var job_id = _this.data('id');
    var apply_form = jQuery('#jobcircle-apply-job-popup').find('form');
    var apply_input = apply_form.find('input[name="apply_job_id"]');
    if (apply_input.length > 0) {
        apply_input.remove();
    }
    apply_form.append('<input type="hidden" name="apply_job_id" value="' + job_id + '">');
});

function jobcircle_form_image_file_change(e) {
    var img_test = '';
    var allow_file_types = ['image/jpg', 'image/jpeg', 'image/png'];
    var allow_file_size = 10400;
    if (e.target.files.length > 0) {
        var dropd_file = e.target.files[0];
        var file_type = dropd_file.type;
        var file_size = dropd_file.size;
        file_size = parseFloat(file_size / 1024).toFixed(2);
        if (!(allow_file_types.indexOf(file_type) >= 0)) {
            jobcircle_submit_msg_alert('Error: Only image with .png or .jpg extension is allowed to upload.', 'jobcircle-alert-danger');
            img_test = 'fail';
        }
        if (file_size > allow_file_size && img_test != 'fail') {
            jobcircle_submit_msg_alert('Error: Image size is too big to upload. Please use optimized image only.', 'jobcircle-alert-danger');
            img_test = 'fail';
        }
    } else {
        img_test = 'fail';
    }

    if (img_test != 'fail') {
        if (e.target.files.length > 0) {

            var logo_img_con = jQuery('#logofile-name-container').find('.logo-img-con');
            //
            var img_reader = new FileReader();
            img_reader.addEventListener("load", function () {
                var img_src = img_reader.result;
                logo_img_con.find('img').attr('src', img_src);
                logo_img_con.find('i').hide();
                logo_img_con.find('img').removeAttr('style');
            }, false);
            img_reader.readAsDataURL(dropd_file);
        }
    }
}

jQuery('.jobcircle-favcandidate-btn').on('click', function () {
    var _this = jQuery(this);
    var this_icon = _this.find('i');
    var post_id = _this.data('id');
    this_icon.attr('class', 'jobcircle-fa jobcircle-faicon-circle-notch jobcircle-faicon-spin');

    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: jobcircle_cscript_vars.ajax_url,
        data: {
            post_id: post_id,
            action: 'jobcircle_candidate_like_favourite_ajax'
        },
        success: function (data) {
            var totalFavorites = data.total_favorites;
            this_icon.attr('class', 'lni lni-heart-filled position-absolute');
            updateTotalFavorites(totalFavorites); // Call a function to update the total favorites count on the page
        },
        error: function () {
            this_icon.attr('class', 'lni lni-heart position-absolute');
        }
    });
});


function updateTotalFavorites(count) {
    // Assuming you have a DOM element with the ID 'totalFavoritesCount' to display the count
    var totalFavoritesCountElement = jQuery('#totalFavoritesCount');
    if (totalFavoritesCountElement.length > 0) {
        totalFavoritesCountElement.text(count);
    }
}


//Member update
jQuery(document).on('click', '.jobcircle-edit-member', function () {
    var _this = jQuery(this);
    var post_id = _this.data('id');
    var _this_html = _this.html();
    _this.html('<small class="loading-icon fa fa-spinner fa-spin"></small>');

    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: jobcircle_cscript_vars.ajax_url,
        data: {
            id: post_id,
            action: 'jobcircle_get_team_member'
        },
        success: function (data) {
            if (data.error == '0') {
                let _member_data = data.member_data;
                let jobcircle_update_team = jQuery('#updateTeamMember');
                jobcircle_update_team.find("input[name=hdn_member_id]").val(_member_data.id);
                jobcircle_update_team.find("input[name=first_name]").val(_member_data.first_name);
                jobcircle_update_team.find("input[name=last_name]").val(_member_data.last_name);
                jobcircle_update_team.find("input[name=username]").val(_member_data.user_login);
                jobcircle_update_team.find("input[name=user_email]").val(_member_data.user_email);
                let _user_access = _member_data.user_access;
                var checkboxArray = _user_access.split(',');
                jobcircle_update_team.find('input[name="member_access[]"]').each(function() {
                    var checkbox = jQuery(this);
                    var checkboxValue = checkbox.val();

                    if (jQuery.inArray(checkboxValue, checkboxArray) !== -1) {
                        checkbox.prop('checked', true);
                    }
                });
                jobcircle_update_team.modal('show');
                _this.html(_this_html);
            } else {
                _this.html(_this_html)
                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
            }
        },
        error: function (jqXHR, exception) {
            _this.html(_this_html);
            // Handle error if necessary
            jobcircle_submit_msg_alert(jqXHR.responseText, 'jobcircle-alert-danger');
        }

    });
});
//Member Delete
jQuery(document).on('click', '.jobcircle-delete-member', function () {
    var _this = jQuery(this);
    var post_id = _this.data('id');
    var _this_html = _this.html();
    _this.html('<small class="loading-icon fa fa-spinner fa-spin"></small>');

    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: jobcircle_cscript_vars.ajax_url,
        data: {
            id: post_id,
            action: 'jobcircle_remove_team_member'
        },
        success: function (data) {
            if (data.error == '0') {
                _this.closest('tr').remove();
                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
            } else if (data.error == '2') {
                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-info');
            } else {
                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
            }
            _this.html(_this_html);
        },
        error: function (jqXHR, exception) {
            _this.html(_this_html);
            // Handle error if necessary
            jobcircle_submit_msg_alert(jqXHR.responseText, 'jobcircle-alert-danger');
        }
    });
});


// Job Category

// when click on any category then show there jobs 
//put first form class here
jQuery('.jobcircle-jobfilter-form').find('input[type="radio"]').on('change', function () {
    jQuery(this).parents('form').submit();
});


jQuery(document).ready(function (jQuery) {

    //Show/Hide Password
    jQuery(document).on('click', '.jobcircle-togglePassword', function (ev) {
        var _this = jQuery(this); 
        ev.preventDefault();
        var passwordField = _this.parent().find('.jobcircle-passwordfield');
        var fieldType = passwordField.attr('type');

        console.log(fieldType,passwordField);
        
        if (fieldType === 'password') {
            passwordField.attr('type', 'text');
            _this.find('i').removeClass('fa-eye').addClass('fa-times');
        } else {
            passwordField.attr('type', 'password');
            _this.find('i').removeClass('fa-times').addClass('fa-eye');
        }
    });

    jQuery(document).on('click', '.jobcircle-favjab-btn', function (ev) {
        var _this = jQuery(this);
        ev.preventDefault();

        if (_this.hasClass('no-user-follower-btn')) {
            jobcircle_submit_msg_alert(jobcircle_cscript_vars.loggedin_saved, 'jobcircle-alert-warning');
            return false;
        }
        if (_this.hasClass('no-member-follower-btn')) {
            jobcircle_submit_msg_alert(jobcircle_cscript_vars.candidate_job_saved, 'jobcircle-alert-warning');
            return false;
        }
        var this_icon = _this.find('i');

        var post_id = _this.data('id');

        //this_icon.attr('class', 'jobcircle-fa jobcircle-faicon-circle-notch jobcircle-faicon-spin');
        this_icon.attr('class', 'fa fa-spinner fa-spin');

        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: jobcircle_cscript_vars.ajax_url,
            data: {
                post_id: post_id,
                action: 'jobcircle_job_like_favourite_ajax'
            },
            success: function (data) {
                console.log('data', data.status);
                if(data.status == 1){
                    var totalFavorites = data.total_favorites;
                    _this.removeClass('jobcircle-favjab-btn');
                    _this.addClass('jobcircle-alrdy-favjab');
                    //_this.addHtml('Follow');
                    this_icon.attr('class', 'profile-btn position-absolute fa fa-heart');

                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
                } else {
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-info');
                }
            },
            error: function (xhr, status, error) {
                this_icon.attr('class', 'lni lni-heart position-absolute');

                jobcircle_submit_msg_alert(xhr.responseText, 'jobcircle-alert-info');
            }
        });
    });

    jQuery(document).on('click', '.jobcircle-alrdy-favjab', function (ev) {
        var _this = jQuery(this);
        ev.preventDefault();

        var _this = jQuery(this);
        if (_this.hasClass('no-user-follower-btn')) {
            jobcircle_submit_msg_alert(jobcircle_cscript_vars.loggedin_saved, 'jobcircle-alert-warning');
            return false;
        }
        if (_this.hasClass('no-member-follower-btn')) {
            jobcircle_submit_msg_alert(jobcircle_cscript_vars.candidate_job_saved, 'jobcircle-alert-warning');
            return false;
        }
        var this_icon = _this.find('i');
        var post_id = _this.data('id');
        //this_icon.attr('class', 'jobcircle-fa jobcircle-faicon-circle-notch jobcircle-faicon-spin');
        this_icon.attr('class', 'fa fa-spinner fa-spin');
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: jobcircle_cscript_vars.ajax_url,
            data: {
                post_id: post_id,
                action: 'jobcircle_remove_fav_job'
            },
            success: function (data) {
                if(data.status == 1){
                    var totalFavorites = data.total_favorites;
                    _this.addClass('jobcircle-favjab-btn');
                    _this.removeClass('jobcircle-alrdy-favjab');
                    //_this.addHtml('Follow');
                    this_icon.attr('class', 'profile-btn position-absolute fa fa-heart-o');
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
                } else {
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-info');
                }
            },
            error: function (xhr, status, error) {
                this_icon.attr('class', 'lni lni-heart position-absolute');
                jobcircle_submit_msg_alert(xhr.responseText, 'jobcircle-alert-info');
            }
        });
    });

    jQuery(document).on('click', '.jobcircle-delete-post-btn', function (e) {
        e.preventDefault();
        var postId = jQuery(this).data('id');
        var _this = jQuery(this);

        //fas fa-spinner fa-spin

        var this_icon = _this.find('i');

        this_icon.attr('class', 'fa fa-spinner fa-spin');

        //return false;

        //Perform an AJAX request to unlike the post
        jQuery.ajax({
            url: jobcircle_cscript_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'jobcircle_remove_fav_job',
                post_id: postId,
            },
            success: function (data) {
                if(data.status == 1){
                    _this.parents('tr').remove();
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
                } else {
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-info');
                }
            },
            error: function (xhr, status, error) {
                jobcircle_submit_msg_alert(xhr.responseText, 'jobcircle-alert-info');
                this_icon.attr('class', 'fa fa-trash');
            }
        });
    });
    jQuery(document).on('click', '.jobcircle-delete-follower-btn', function (e) {
        e.preventDefault();
        var postId = jQuery(this).data('id');
        var _this = jQuery(this);

        //fas fa-spinner fa-spin

        var this_icon = _this.find('i');

        this_icon.attr('class', 'fa fa-spinner fa-spin');

        //return false;

        //Perform an AJAX request to unlike the post
        jQuery.ajax({
            url: jobcircle_cscript_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'jobcircle_remove_fav_follower',
                post_id: postId,
            },
            success: function (data) {
                if(data.status == 1){
                    _this.parents('tr').remove();
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
                } else {
                    jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-info');
                }
            },
            error: function (xhr, status, error) {
                jobcircle_submit_msg_alert(xhr.responseText, 'jobcircle-alert-info');
                this_icon.attr('class', 'fa fa-trash');
            }
        });
    });

    jQuery(document).on('click', '.basetth-follower-btn', function () {
        var _this = jQuery(this);
        if (_this.hasClass('no-user-follower-btn')) {
            jobcircle_submit_msg_alert(jobcircle_cscript_vars.loggedin_saved, 'jobcircle-alert-warning');
            return false;
        }
        if (_this.hasClass('no-member-follower-btn')) {
            jobcircle_submit_msg_alert(jobcircle_cscript_vars.candidate_job_saved, 'jobcircle-alert-warning');
            return false;
        }
        
        var this_icon = _this.find('i');
        var post_id = _this.data('id');
        this_icon.attr('class', 'fa fa-heart-shake');
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: jobcircle_cscript_vars.ajax_url,
            data: {
                post_id: post_id,
                action: 'basetth_candidate_fav_job_jobcircle_job_grid'
            },
            success: function (data) {
                var totalFavorites = data.total_favorites;
                _this.removeClass('basetth-follower-btn');
                _this.addClass('basetth-alrdy-favjab');
                _this.addClass('fa fa-heart');
            },
            error: function () {
                this_icon.attr('class', 'profile-btn position-absolute');
            }
        });
    });
    jQuery(document).on('click', '.basetth-alrdy-favjab', function () {
        var _this = jQuery(this);
        if (_this.hasClass('no-user-follower-btn')) {
            jobcircle_submit_msg_alert(jobcircle_cscript_vars.loggedin_saved, 'jobcircle-alert-warning');
            return false;
        }
        if (_this.hasClass('no-member-follower-btn')) {
            jobcircle_submit_msg_alert(jobcircle_cscript_vars.candidate_job_saved, 'jobcircle-alert-warning');
            return false;
        }
        var this_icon = _this.find('i');
        var post_id = _this.data('id');
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: jobcircle_cscript_vars.ajax_url,
            data: {
                post_id: post_id,
                action: 'basetth_candidate_remove_jobcircle_job_grid'
            },
            success: function (data) {
                var totalFavorites = data.total_favorites;
                _this.removeClass('basetth-alrdy-favjab');
                _this.addClass('basetth-follower-btn');
                _this.addClass('fa fa-heart-o');
            },
            error: function () {
                this_icon.attr('class', 'profile-btn position-absolute');
            }
        });
    });

});

jQuery('.jobcircle-sort-name').find('select').on('change', function () {
    jQuery(this).parents('form').submit();
});

function submitForm() {
    // Get the selected value from the dropdown
    const selectedOption = document.querySelector(".form-control").value;

    // You can perform any action here with the selected value, such as sending it to a server or processing it locally
    console.log("Selected option:", selectedOption);
    document.getElementById("jobForm").submit();
}

// //when you click on show button then submit the form
// //put first, form class here
jQuery('.jobcircle-jobfilter-form').find('input[type="radio"]').on('change', function () {
    jQuery(this).parents('form').submit();
});

jQuery(document).on('submit', '.jobcircle-jobfilter-form', function (ev) {

    ev.preventDefault();

    var this_form = jQuery(this);
    // add a div above row to contain all row for loading by ajax class="jobcircle-all-job-listing-con"
    var this_par = this_form.parents('.jobcircle-all-listing-con');
    var from_element = this_form[0];
    var form_data = new FormData(from_element);

    if (!this_form.hasClass('ajax-processing')) {
        // add a div above on posts (where shown jobs with class like class="jobcircle-alljobs-list")
        this_par.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
        var elem_to_got = this_par.find('.jobcircle-loder-con .jobcircle-loader');
        jQuery('html, body').animate({scrollTop: elem_to_got.offset().top - 100}, 1000);

        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: jobcircle_cscript_vars.ajax_url,
            processData: false,
            contentType: false,
            data: form_data,
            success: function (data) {

                this_par.find('.jobcircle-alljobs-list').html(data.html);

                this_par.find('.jobcircle-loder-con').remove();
                this_form.removeClass('ajax-processing');
                //
                var data_query = jQuery(this_form[0].elements).not(':input[name="action"],:input[name="numposts"],:input[name="orderby"]').serialize();
                var current_url = location.protocol + "//" + location.host + location.pathname + "?" + data_query; //window.location.href;
                window.history.pushState(null, null, decodeURIComponent(current_url));
            },
            error: function () {
                this_par.find('.jobcircle-loder-con').remove();
                this_form.removeClass('ajax-processing');
            }
        });
    }

    this_form.addClass('ajax-processing');
});

function jobcircle_check_location_latlng() {
    "use strict";
    var request = jQuery.ajax({
        url: "https://ipinfo.io/json",
        dataType: "json"
    });
    request.done(function (result) {
        if (result != null && typeof result.loc !== undefined && result.loc != '') {
            var address = result.city + ' ' + result.country;
            document.querySelector('.jobcircle-location-input-field').value = address;
        } else {
            jobcircle_geoloc_ipinfo_fallback();
        }
    });
    request.fail(function () {
        jobcircle_geoloc_ipinfo_fallback();
    });
}

function jobcircle_geoloc_ipinfo_fallback() {
    "use strict";
    var request = jQuery.ajax({
        url: "//ip-api.com/json",
        dataType: "json"
    });
    request.done(function (result) {
        if (typeof result.lat !== undefined && result.lat != '') {
            var address = result.city + ' ' + result.country;
            document.querySelector('.jobcircle-location-input-field').value = address;
        }
    });
}

function jobcircle_get_user_geo_location() {
    "use strict";

    if (jQuery('.jobcircle-location-input-field').length > 0) {
        if (navigator.geolocation) {
            const options = {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 1
            };
            function jobcircle_geolocation_access_err(error) {
                console.warn('ERROR(' + error.code + '): ' + error.message);
                jobcircle_check_location_latlng();
            }
            navigator.geolocation.getCurrentPosition(jobcircle_set_user_current_locate, jobcircle_geolocation_access_err, options);
        } else {
            console.log("Geolocation is not supported.");
            jobcircle_check_location_latlng();
        }
    }
}

function jobcircle_set_user_current_locate(position) {
    "use strict";
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    
    if (typeof jobcircle_geoloc_curr_request == 'undefined') {
        
        var addres_field = jQuery('.jobcircle-location-input-field');

        jobcircle_geoloc_curr_request = jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: jobcircle_cscript_vars.ajax_url,
            data: {
                lat: lat,
                lng: lng,
                action: 'jobcircle_get_user_address_from_lat_lng'
            },
        });
        jobcircle_geoloc_curr_request.done(function (response) {
            addres_field.val(response.address).attr('value', response.address);
        });
    }
}