jQuery(document).ready(function () {
	if (jQuery('.jobcircle-datepicker').length > 0) {
		var todayDate = new Date().getDate();
		jQuery('.jobcircle-datepicker').datetimepicker({
			maxDate: new Date(new Date().setDate(todayDate)),
			timepicker: false,
			format: 'd-m-Y',
			scrollMonth: false,
			scrollInput: false
		});
	}
	if (jQuery('.jobcircle-datepicker-min').length > 0) {
		jQuery('.jobcircle-datepicker-min').datetimepicker({
			minDate: new Date(new Date().setDate(todayDate)),
			timepicker: false,
			format: 'd-m-Y',
			scrollMonth: false,
			scrollInput: false
		});
	}
	if (jQuery('.jobcircle-dashb-multilist').length > 0) {
		jQuery(".jobcircle-dashb-multilist").sortable({
			items: '.jobcircle-dashb-multilitm',
			placeholder: "ui-state-highlight",
			handle: ".multili-sorter",
			start: function (e, ui) {
				var this_item = ui.item;
				var items_holder = this_item.parents('.jobcircle-dashb-multilist');
				items_holder.find('.jobcircle-dashb-multilitm .inner-fields-formcon').hide();
			},
			update: function (e, ui) {
				var this_item = ui.item;
				var items_holder = this_item.parents('.jobcircle-dashb-multilist');
				jobcircle_update_items_record_sorting(items_holder);
			}
		}).disableSelection();
	}

	/* 
	* Phone Number Check
	* Starts Here
	* */


	const input = document.querySelector("#phone");
	if(input !== null && input.value.length > 0){
		const button = document.querySelector("#btn");
		const errorMsg = document.querySelector("#error-msg");
		const validMsg = document.querySelector("#valid-msg");
	
		// here, the index maps to the error code returned from getValidationError - see readme
		const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
	
		// initialise plugin
		const iti = window.intlTelInput(input, {
			utilsScript: "https://intl-tel-input.com/intl-tel-input/js/utils.js?1695806485509"
		});
	
		const reset = () => {
			input.classList.remove("error");
			errorMsg.innerHTML = "";
			errorMsg.classList.add("hide");
			validMsg.classList.add("hide");
		};
	
		// on click button: validate
		input.addEventListener('keyup', () => {
			reset();
			if (input.value.trim()) {
				if (iti.isPossibleNumber()) {
					validMsg.classList.remove("hide");
				} else {
					input.classList.add("error");
					const errorCode = iti.getValidationError();
					errorMsg.innerHTML = errorMap[errorCode];
					errorMsg.classList.remove("hide");
				}
			}
		});
		// on keyup / change flag: reset
		input.addEventListener('change', reset);
		// input.addEventListener('keyup', reset);
	}


	/*
	* Phone Number Check
	* Ends Here
	* */

});

function jobcircle_update_items_record_sorting(items_holder) {
	var keys_list = [];
	items_holder.find('.jobcircle-dashb-multilitm').each(function () {
		keys_list.push(jQuery(this).attr('data-id'));
	});
	if (items_holder.hasClass('jobcircle-dashbcand-edulist')) {
		var action_str = 'jobcircle_account_education_record_sorting';
	} else if (items_holder.hasClass('jobcircle-dashbcand-experiencelist')) {
		var action_str = 'jobcircle_account_experience_record_sorting';
	} else if (items_holder.hasClass('jobcircle-dashbcand-expertiselist')) {
		var action_str = 'jobcircle_account_expertise_record_sorting';
	}
	items_holder.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
	jQuery.ajax({
		type: "POST",
		dataType: "json",
		url: jobcircle_dashb_vars.ajax_url,
		data: {
			keys_list: keys_list,
			action: action_str
		},
		success: function () {
			items_holder.find('.jobcircle-loder-con').remove();
		},
		error: function () {
			items_holder.find('.jobcircle-loder-con').remove();
		}
	});
}

jQuery(document).on('click', '.jobcircle-dashb-multilitm .multilitm-hder .multili-titltxt,.jobcircle-dashb-multilitm .multilitm-hder .multili-act-edit', function () {
	var this_btn = jQuery(this);
	this_btn.parents('.jobcircle-dashb-multilitm').find('.inner-fields-formcon').slideToggle();
});

jQuery('.choos-acctype-maincon .acctype-box-itm').on('click', function () {
	var this_itm = jQuery(this);
	if (this_itm.hasClass('employer-box-item')) {
		var acc_type = 'employer';
	} else {
		var acc_type = 'candidate';
	}
	this_itm.find('i').attr('class', 'jobcircle-fa jobcircle-faicon-circle-notch jobcircle-faicon-spin');
	jQuery.ajax({
		type: "POST",
		dataType: "json",
		url: jobcircle_dashb_vars.ajax_url,
		data: {
			acc_type: acc_type,
			action: 'jobcircle_user_account_type_selection_call'
		},
		success: function (data) {
			window.location.replace(data.url);
		}
	});
});

jQuery('.candidate-addexperience-form').on('click', '.candash-form-chkbutncon input[name="still_working"]', function () {
	var this_chk = jQuery(this);
	var par_con = this_chk.parents('.candash-form-centrow');
	var endate_holdr = par_con.find('input[name="enddate"]').parents('.col-4');
	if (this_chk.is(":checked")) {
		endate_holdr.hide();
	} else {
		endate_holdr.removeAttr('style');
	}
});

jQuery('.jobcircle-dashb-multilist').on('click', '.multili-act-remove', function () {
	var this_btn = jQuery(this);
	var itm_con = this_btn.parents('.jobcircle-dashb-multilitm');
	var itm_id = itm_con.attr('data-id');
	var this_par = this_btn.parents('.jobcircle-dashb-multilist');
	if (this_par.hasClass('jobcircle-dashbcand-experiencelist')) {
		var action_str = 'jobcircle_dashcand_experienceitm_remove_call';
	} else if (this_par.hasClass('jobcircle-dashbcand-expertiselist')) {
		var action_str = 'jobcircle_dashcand_expertiseitm_remove_call';
	} else {
		var action_str = 'jobcircle_dashcand_eduitm_remove_call';
	}
	this_par.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');

	jQuery.ajax({
		type: "POST",
		dataType: "json",
		url: jobcircle_dashb_vars.ajax_url,
		data: {
			id: itm_id,
			action: action_str
		},
		success: function (data) {
			if (data.error == '0') {
				jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
				itm_con.remove();

				if(this_par.find('.jobcircle-dashb-multilitm').length < 1){
					jobcircle_update_profile_score();
				}
			} else {
				jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
			}
			this_par.find('.jobcircle-loder-con').remove();
		},
		error: function () {
			this_par.find('.jobcircle-loder-con').remove();
		}
	});
});

function jobcircle_dashform_after_succ_call(this_form, data) {
	if (this_form.hasClass('candidate-addedu-form')) {
		var items_holder = jQuery('.jobcircle-dashbcand-edulist');
		items_holder.append(data.html);
		var last_itm = items_holder.find('.jobcircle-dashb-multilitm:last-child');
		last_itm.find('.multilitm-hder').css({ 'background-color': '#fffff0' });
		setTimeout(function () {
			last_itm.find('.multilitm-hder').removeAttr('style');
		}, 4000);
		jQuery('html, body').animate({ scrollTop: last_itm.offset().top - 100 }, 1000);
		this_form.find('input[type="text"]').val('').attr('value', '');
		this_form.find('textarea[type="text"]').val('').attr('value', '');
	}
	if (this_form.hasClass('candidate-addexperience-form')) {
		var items_holder = jQuery('.jobcircle-dashbcand-experiencelist');
		items_holder.append(data.html);
		var last_itm = items_holder.find('.jobcircle-dashb-multilitm:last-child');
		last_itm.find('.multilitm-hder').css({ 'background-color': '#fffff0' });
		setTimeout(function () {
			last_itm.find('.multilitm-hder').removeAttr('style');
		}, 4000);
		jQuery('html, body').animate({ scrollTop: last_itm.offset().top - 100 }, 1000);
		this_form.find('input[type="text"]').val('').attr('value', '');
		this_form.find('textarea[type="text"]').val('').attr('value', '');
	}
	if (this_form.hasClass('candidate-addexpertise-form')) {
		var items_holder = jQuery('.jobcircle-dashbcand-expertiselist');
		items_holder.append(data.html);
		var last_itm = items_holder.find('.jobcircle-dashb-multilitm:last-child');
		last_itm.find('.multilitm-hder').css({ 'background-color': '#fffff0' });
		setTimeout(function () {
			last_itm.find('.multilitm-hder').removeAttr('style');
		}, 4000);
		jQuery('html, body').animate({ scrollTop: last_itm.offset().top - 100 }, 1000);
		this_form.find('input[type="text"]').val('').attr('value', '');
		this_form.find('textarea[type="text"]').val('').attr('value', '');
	}
}

function jobcircle_update_profile_score(){
	if(jQuery('.cand-profilescor-btn').length > 0){
		jQuery.ajax({
			url: jobcircle_dashb_vars.ajax_url, // WordPress AJAX URL
			type: 'post',
			data: {
				action: 'jobcircle_get_profile_score',
			},
			success: function(response) {
				if(response.profile_score){
					jQuery('.cand-profilescor-btn').html(response.profile_score);
				}
				
				if(jQuery('#candidate-profilescor-modal .score-details-holder').length > 0){
					if(response.profile_score_msgs){
						jQuery('#candidate-profilescor-modal .score-details-holder').html(response.profile_score_msgs);
					}
				}		
			}
		});
	}
}

jQuery(document).on('submit', '.jobcircle-dashb-form', function (ev) {

	ev.preventDefault();

	var this_form = jQuery(this);
	var from_element = this_form[0];
	var form_data = new FormData(from_element);

	if (!this_form.hasClass('ajax-processing')) {

		if(this_form.find('#jobcircle_verfied_account').length > 0){
			let  verified_accnt = jQuery("#jobcircle_verfied_account").val();

			if(verified_accnt != 'yes'){
				jobcircle_submit_msg_alert(jobcircle_cscript_vars.account_verfied, 'jobcircle-alert-danger');
				return false;
			}
		}
		this_form.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
		var elem_to_got = this_form.find('.jobcircle-loder-con .jobcircle-loader');
		jQuery('html, body').animate({ scrollTop: elem_to_got.offset().top - 100 }, 1000);
		form_data.append('_nonce', jobcircle_cscript_vars.jobcircle_nonce);
		jQuery.ajax({
			type: "POST",
			dataType: "json",
			url: jobcircle_cscript_vars.ajax_url,
			processData: false,
			contentType: false,
			data: form_data,
			success: function (data) {
				if (data.error == '0') {
					jobcircle_update_profile_score();
					jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
				} else if (data.error == '2') {
					jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-info');
				} else {
					jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
				}
				jobcircle_dashform_after_succ_call(this_form, data);
				if (typeof data.redirect !== undefined && data.redirect != undefined && data.redirect != '') {
					if (data.redirect == 'same') {
						window.location.reload();
					} else {
						window.location.replace(data.redirect);
					}
					return false;
				}
				jQuery('body').find('.jobcircle-loder-con').remove();
				this_form.removeClass('ajax-processing');
			},
			error: function () {
				jQuery('body').find('.jobcircle-loder-con').remove();
				this_form.removeClass('ajax-processing');
			}
		});
	}

	this_form.addClass('ajax-processing');
});

function jobcircle_dashb_image_file_change(e) {
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

jQuery(document).on('click', '.jobcircle-mangjob-delbtn', function (ev) {

	ev.preventDefault();

	var this_btn = jQuery(this);
	var id = this_btn.attr('data-id');
	var this_par = this_btn.parents('.jobcircle-mangjobs-con');

	if (!this_btn.hasClass('ajax-processing')) {
		this_par.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
		var elem_to_got = this_par.find('.jobcircle-loder-con .jobcircle-loader');
		jQuery('html, body').animate({ scrollTop: elem_to_got.offset().top - 100 }, 1000);

		jQuery.ajax({
			type: "POST",
			dataType: "json",
			url: jobcircle_cscript_vars.ajax_url,
			data: {
				id: id,
				action: 'jobcircle_dash_empjob_remove_call'
			},
			success: function (data) {
				if (data.error == '0') {
					jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
				} else if (data.error == '2') {
					jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-info');
				} else {
					jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
				}

				this_par.find('.jobcircle-loder-con').remove();
				this_btn.removeClass('ajax-processing');
			},
			error: function () {
				this_par.find('.jobcircle-loder-con').remove();
				this_btn.removeClass('ajax-processing');
			}
		});
	}

	this_btn.addClass('ajax-processing');
});

jQuery('.jobcircle-resend-verification').on('click', function () {
	var this_btn = jQuery(this);
	var itm_con = this_btn.parents('.choos-acctype-maincon');
	itm_con.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
	jQuery.ajax({
		type: "POST",
		dataType: "json",
		url: jobcircle_dashb_vars.ajax_url,
		data: {
			_nonce: jobcircle_cscript_vars.jobcircle_nonce,
			action: 'jobcircle_dash_user_send_email_verification'
		},
		success: function (data) {
			if (data.error == '0') {
				jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
				//window.location.reload();
			} else {
				jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
			}
			itm_con.find('.jobcircle-loder-con').remove();
		},
		error: function () {
			itm_con.find('.jobcircle-loder-con').remove();
		}
	});
});
jQuery('.jobcircle-user-switchaccount').on('click', function () {
	var this_btn = jQuery(this);
	var itm_con = this_btn.parents('.jobcircle-dashb-barcon');
	var itm_id = itm_con.attr('data-id');
	var this_par = this_btn.parents('.sidebar_nav');

	var confirmDelete = confirm(jobcircle_dashb_vars.account_switch_confirm);
    if (!confirmDelete) {
        return false; // If user clicks "Cancel", do nothing
    }	
	this_par.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
	jQuery.ajax({
		type: "POST",
		dataType: "json",
		url: jobcircle_dashb_vars.ajax_url,
		data: {
			id: itm_id,
			_nonce: jobcircle_cscript_vars.jobcircle_nonce,
			action: 'jobcircle_dash_user_switch_account'
		},
		success: function (data) {
			if (data.error == '0') {
				jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
				window.location.reload();
			} else {
				jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
			}
			this_par.find('.jobcircle-loder-con').remove();
		},
		error: function () {
			this_par.find('.jobcircle-loder-con').remove();
		}
	});
});

jQuery('.jobcircle-user-delaccount').on('click', function () {
	var this_btn = jQuery(this);
	var itm_con = this_btn.parents('.jobcircle-dashb-barcon');
	var itm_id = itm_con.attr('data-id');
	var this_par = this_btn.parents('.sidebar_nav');

	var confirmDelete = confirm(jobcircle_dashb_vars.account_delete_confirm);
    if (!confirmDelete) {
        return false; // If user clicks "Cancel", do nothing
    }
	
	this_par.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');

	jQuery.ajax({
		type: "POST",
		dataType: "json",
		url: jobcircle_dashb_vars.ajax_url,
		data: {
			id: itm_id,
			_nonce: jobcircle_cscript_vars.jobcircle_nonce,
			action: 'jobcircle_dash_user_account_del'
		},
		success: function (data) {
			if (data.error == '0') {
				jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
				window.location.reload();
			} else {
				jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
			}
			this_par.find('.jobcircle-loder-con').remove();
		},
		error: function () {
			this_par.find('.jobcircle-loder-con').remove();
		}
	});
});

document.addEventListener("DOMContentLoaded", function () {
	const openCalendarButton = document.getElementById('openCalendarButton');
	const selectedDateElement = document.getElementById('selectedDate');

	if (openCalendarButton !== null) {
		openCalendarButton.addEventListener('click', function () {
			// Initialize Flatpickr on the selectedDate element
			flatpickr(selectedDateElement, {
				dateFormat: "M d, Y", // Format of the selected date
				defaultDate: "Oct 9, 2023", // Default selected date
				onClose: function (selectedDates, dateStr) {
					// Update the displayed date when a date is selected
					selectedDateElement.textContent = dateStr;
				}
			});

			// Open the calendar when the button is clicked
			selectedDateElement._flatpickr.open();
		});
	}
});

jQuery(document).on('change', 'input[name="upload_cv_file"]', function () {
	var this_input = jQuery(this);
	jobcircle_dashboard_cv_upload_call(this, this_input);
});

function jobcircle_dashboard_cv_upload_call(input, this_input) {

	if (input.files && input.files[0]) {

		var cv_file = input.files[0];
		var file_size = cv_file.size;
		var file_type = cv_file.type;
		var file_name = cv_file.name;

		var allowed_types = jobcircle_cscript_vars.resume_file_types;

		file_size = parseFloat(file_size / 1024).toFixed(2);
		var filesize_allow = jobcircle_cscript_vars.cvfile_size_allow;
		filesize_allow = parseInt(filesize_allow);

		if (allowed_types.indexOf(file_type) >= 0) {
			if (file_size > filesize_allow) {
				jobcircle_submit_msg_alert(jobcircle_cscript_vars.cvfile_size_err, 'jobcircle-alert-danger');
				return false;
			}
			var this_par = this_input.parents('.candidate-uplodfile-maincon');
			this_par.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
			var elem_to_got = this_par.find('.jobcircle-loder-con .jobcircle-loader');
			jQuery('html, body').animate({ scrollTop: elem_to_got.offset().top - 100 }, 1000);

			var formData = new FormData();
			formData.append('candidate_cv_file', cv_file);
			formData.append('action', 'jobcircle_dashboard_uploading_candidate_cv_file');
			jQuery.ajax({
				url: jobcircle_cscript_vars.ajax_url,
				method: "POST",
				data: formData,
				processData: false,
				contentType: false,
				dataType: "json",
				success: function (response) {
					if (response.error == '1') {
						jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-danger');
					} else {
						jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-success');
						window.location.reload();
					}
					this_par.find('.jobcircle-loder-con').remove();
				},
				error: function () {
					this_par.find('.jobcircle-loder-con').remove();
				}
			});
		} else {
			jobcircle_submit_msg_alert(jobcircle_cscript_vars.resume_types_msg, 'jobcircle-alert-danger');
		}
	}
}

jQuery('.jobcreate-content-with-ai').on('click', function() {
	var this_btn = jQuery(this);
	var title_str = this_btn.parents('form').find('input[name="job_title"]').val();
	var this_par = this_btn.parents('.form-fieldhldr-parntcon');
	this_par.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
	
	jQuery.ajax({
		url: jobcircle_cscript_vars.ajax_url,
		method: "POST",
		data: {
			title: title_str,
			action: 'jobcircle_job_content_with_ai_call'
		},
		dataType: "json",
		success: function (response) {
			if (response.error == '1') {
				jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-danger');
			} else {
				tinymce.activeEditor.setContent(response.content);
				jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-success');
			}

			this_par.find('.jobcircle-loder-con').remove();
		},
		error: function () {
			this_par.find('.jobcircle-loder-con').remove();
		}
	});
});

jQuery('.jobcircle-remove-candcvitm').on('click', function() {
	var this_btn = jQuery(this);
	var this_key = this_btn.attr('data-key');
	var this_par = this_btn.parents('.candidate-allcvs-listcon');
	this_par.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
	jQuery.ajax({
		url: jobcircle_cscript_vars.ajax_url,
		method: "POST",
		data: {
			key: this_key,
			action: 'jobcircle_remove_candidate_saved_cv_item'
		},
		dataType: "json",
		success: function (response) {
			if (response.error == '1') {
				jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-danger');
			} else {
				jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-success');
				this_btn.parents('.cvlist-itm').remove();
			}
			this_par.find('.jobcircle-loder-con').remove();
		},
		error: function () {
			this_par.find('.jobcircle-loder-con').remove();
		}
	});
});

function jobcircle_job_attach_files_url(event) {

    if (window.File && window.FileList && window.FileReader) {

        var file_types_str = jobcircle_dashb_vars.job_files_mime_types;
        if (file_types_str != '') {
            var file_types_array = file_types_str.split('|');
        } else {
            var file_types_array = [];
        }
        var file_allow_size = jobcircle_dashb_vars.job_files_max_size;
        var num_files_allow = jobcircle_dashb_vars.job_num_files_allow;

        num_files_allow = parseInt(num_files_allow);
        file_allow_size = parseInt(file_allow_size);

        jQuery('#attach-files-holder').find('.adding-file').remove();
        var files = event.target.files;
        for (var i = 0; i < files.length; i++) {

            var _file = files[i];
            var file_type = _file.type;
            var file_size = _file.size;
            var file_name = _file.name;

            file_size = parseFloat(file_size / 1024).toFixed(2);

            if (file_size <= file_allow_size) {
                if (file_types_array.indexOf(file_type) >= 0) {
                    var file_icon = 'fa fa-file-text-o';
                    if (file_type == 'image/png' || file_type == 'image/jpeg') {
                        file_icon = 'fa fa-file-image-o';
                    } else if (file_type == 'application/msword' || file_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                        file_icon = 'fa fa-file-word-o';
                    } else if (file_type == 'application/vnd.ms-excel' || file_type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                        file_icon = 'fa fa-file-excel-o';
                    } else if (file_type == 'application/pdf') {
                        file_icon = 'fa fa-file-pdf-o';
                    }

                    var rand_number = Math.floor((Math.random() * 99999999) + 1);
                    var ihtml = '\
                    <div class="jobcircle-column-3 adding-file">\
                        <div class="file-container">\
                            <a><i class="' + file_icon + '"></i> ' + file_name + '</a>\
                        </div>\
                    </div>';
                    jQuery('#attach-files-holder').append(ihtml);

                } else {
                    jobcircle_submit_msg_alert(jobcircle_dashb_vars.file_type_error, 'jobcircle-alert-danger');
                    return false;
                }
            } else {
                jobcircle_submit_msg_alert(jobcircle_dashb_vars.file_size_error, 'jobcircle-alert-danger');
                return false;
            }

            if (i >= num_files_allow) {
                break;
            }
        }
    }
}

jQuery(document).on('click', '.jobcircle-company-gallery .el-remove', function () {
    var e_target = jQuery(this).parent('li');
    e_target.fadeOut('slow', function () {
        e_target.remove();
    });
});

function jobcircle_job_attach_video_url(event) {

    if (window.File && window.FileList && window.FileReader) {

        var file_types_str = jobcircle_dashb_vars.job_video_mime_types;
        if (file_types_str != '') {
            var file_types_array = file_types_str.split('|');
        } else {
            var file_types_array = [];
        }
        var file_allow_size = jobcircle_dashb_vars.job_video_max_size;

        file_allow_size = parseInt(file_allow_size);

        jQuery('#attach-video-holder .video-uplodr-name').find('.adding-file').remove();
        var files = event.target.files;
        
		var _file = files[0];

		var file_type = _file.type;
		var file_size = _file.size;
		var file_name = _file.name;

		file_size = parseFloat(file_size / 1024).toFixed(2);

		if (file_size <= file_allow_size) {
			if (file_types_array.indexOf(file_type) >= 0) {
				var file_icon = 'fa fa-file-video-o';

				var ihtml = '\
				<div class="jobcircle-video-itm adding-file">\
					<div class="file-container">\
						<a><i class="' + file_icon + '"></i> ' + file_name + '</a>\
					</div>\
				</div>';
				jQuery('#attach-video-holder .video-uplodr-name').append(ihtml);

			} else {
				jobcircle_submit_msg_alert(jobcircle_dashb_vars.file_type_error, 'jobcircle-alert-danger');
				return false;
			}
		} else {
			jobcircle_submit_msg_alert(jobcircle_dashb_vars.videofile_size_error, 'jobcircle-alert-danger');
			return false;
		}

    }
}
