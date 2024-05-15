jQuery(document).ready(function () {
    "use strict"

    jQuery('.submit-filters-button').on('click', function() {
        jQuery(this).parents('form').submit();
    });

    jQuery(document).on('change', 'select[name="sortby"]', function(ev) {
        ev.preventDefault();
        jQuery(this).closest('form#jobForm').submit();
        
    });
    
    jQuery('.jobcircle-jobfilter-form').find('input[type="checkbox"]').on('change', function() {
        jQuery(this).parents('form').submit();
    });

    jQuery('.jobcircle-jobfilter-form').on('submit', function(ev) {
        ev.preventDefault();
        var this_form = jQuery(this);
        var this_par = this_form.parents('.jobcircle-all-listing-con');
        var from_element = this_form[0];
        var form_data = new FormData(from_element);
        if (!this_form.hasClass('ajax-processing')) { 
            this_par.append(
                '<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>'
            );
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: jobcircle_job_vars.ajax_url,
                processData: false,
                contentType: false,
                data: form_data,
                success: function(data) {
                    this_par.find('.jobcircle-alljobs-list').html(data.html);
                    this_par.find('.jobcircle-loder-con').remove();
                    this_form.removeClass('ajax-processing');
                    var data_query = jQuery(this_form[0].elements).not(':input[name="action"],:input[name="numposts"],:input[name="orderby"]').serialize();
                    var current_url = location.protocol + "//" + location.host + location.pathname + "?" + data_query; //window.location.href;
                    window.history.pushState(null, null, decodeURIComponent(current_url));
                },
                error: function() {
                    this_par.find('.jobcircle-loder-con').remove();
                    this_form.removeClass('ajax-processing');
                }
            });
        }
        this_form.addClass('ajax-processing');
    });
});