jQuery(document).ready(function($) {
    "use strict"

    jQuery(document).on('click', '.jobcricle-edit-review', function(e) {
        e.preventDefault();
        let parent_update_form  = jQuery(this).parents('.jobcircle-reviews-section').find('.jobcircle-reviews-update');       
        var rating = parent_update_form.find('input[name="rating"]').val();
        // Remove 'active' class from all stars
        parent_update_form.find('.jobcircle-star-rating .rating i').removeClass('active');       
        parent_update_form.find('.jobcircle-star-rating .rating i').each(function() {
            if (jQuery(this).data('rating') <= rating) {
                jQuery(this).addClass('active');
            }
        });
        parent_update_form.slideDown();        
    });   

    jQuery(document).on('click', '.jobcircle-star-rating .rating i', function(e) {
        e.preventDefault();
        var rating = parseInt($(this).data('rating'));
        jQuery(this).parents('.jobcircle-star-rating').find('input[name="rating"]').val(rating);
        jQuery('.jobcircle-star-rating .rating i').removeClass('active');
        jQuery(this).prevAll().addBack().addClass('active');
    });

    jQuery(document).on('click', '.jobcircle-review-update-cancel-btn', function(e) {
        e.preventDefault();
        let _this = jQuery(this);
        let parent_update_form  = _this.parents('.jobcircle-reviews-section');
        parent_update_form.find('.jobcircle-reviews-update').slideUp();
    });

    jQuery(document).on('click', '.jobcircle-review-reply-cancel-btn', function(e) {
        e.preventDefault();
        let _this = jQuery(this);
        let parent_reply_form  = _this.parents('.jobcircle-reviews-section');
        parent_reply_form.find('.review-reply-form').find('input[name="jobcircle_comment_id"]').val('');
        parent_reply_form.find('.review-reply-form').find('input[name="jobcircle_reply_comment_id"]').val('');
        parent_reply_form.find('.review-reply-form').find('textarea[name="reply_content"]').val('');
        parent_reply_form.find('.review-reply-form').slideUp();
    });

    jQuery(document).on('click', '.jobcricle-review-reply-btn', function(e) {
        e.preventDefault();
        let _this = jQuery(this);
        let review_id = _this.data('review_id');
        let review_reply_id = _this.data('review_reply_id');
        let reply_content = _this.data('reply_content');
        let reply_form  = _this.parents('.jobcircle-reviews-section').find('.review-reply-form');
        let review_item  = _this.parents('.jobcircle-reviews-section').find('.jobcircle-review-item-'+review_id);
        review_item.append(reply_form);
        review_item.find('.review-reply-form').find('input[name="jobcircle_comment_id"]').val(review_id);
        review_item.find('.review-reply-form').find('input[name="jobcircle_reply_comment_id"]').val(review_reply_id);
        review_item.find('.review-reply-form').find('textarea[name="reply_content"]').val(reply_content);
        review_item.find('.review-reply-form').slideDown();  
    });

    jQuery(document).on('submit', 'form#jobcircle-review-reply-form', function(e) {
        e.preventDefault();
        var _this = jQuery(this);
        let _this_html  = _this.find('.jobcircle-submitreply-btn').html();
        let comment_id = _this.find('input[name="jobcircle_comment_id"]').val();
        //_this.find('.jobcircle-submitreply-btn').html('Loading............');
        _this.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
        // Send AJAX request
        jQuery.ajax({
            type: 'POST',
            url: jobcricle_reviews_obj.ajaxUrl,
            data: _this.serialize(),
            dataType: 'json', // Expect JSON response
            success: function(response) {
                let parent_update_form  = _this.parents('.jobcircle-reviews-section');
                let list_item =  parent_update_form.find('.jobcircle-reviews-listing .row .jobcircle-review-item-'+comment_id);
                if(response.status == 'success'){
                    if(response.html){
                        let jobcircle_reply_comment_id  = response.jobcircle_reply_comment_id;
                        
                        if(list_item.find('.jobcircle-reply-comment-'+jobcircle_reply_comment_id).length){
                            var _html = jQuery(response.html);
                            var targetElement = _html.filter('.jobcircle-reply-comment-'+jobcircle_reply_comment_id);
                            var targetHtml = targetElement.html();
                            list_item.find('.jobcircle-reply-comment-'+jobcircle_reply_comment_id).html(targetHtml);
                        } else {
                            list_item.find('.jobcricle-reply-btn').slideUp();
                            list_item.find('.card-body').append(response.html);
                        }
                    }
                    list_item.find('.review-reply-form').find('input[name="jobcircle_comment_id"]').val('');
                    list_item.find('.review-reply-form').find('input[name="jobcircle_reply_comment_id"]').val('');
                    list_item.find('.review-reply-form').find('textarea[name="reply_content"]').val('');
                    list_item.find('.review-reply-form').slideUp();
                    jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-success');
                } else {
                    jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-info');
                }
                jQuery('body').find('.jobcircle-loder-con').remove();
            },
            error: function(xhr, textStatus, errorThrown) {
                jQuery('body').find('.jobcircle-loder-con').remove();
                // Handle error response
                console.error('Error submitting comment:', errorThrown);
                jobcircle_submit_msg_alert(xhr.responseText, 'jobcircle-alert-danger');
            }
        });
    });

    jQuery(document).on('submit', 'form#jobcircle-reviewupdate-form', function(e) {
        e.preventDefault();
        var _this = jQuery(this);
        let _this_html  = _this.find('.jobcircle-review-update-btn').html();
        let comment_id = _this.find('input[name="jobcircle_comment_id"]').val();
        _this.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
        //_this.find('.jobcircle-review-update-btn').html('Loading............');
        // Send AJAX request
        jQuery.ajax({
            type: 'POST',
            url: jobcricle_reviews_obj.ajaxUrl,
            data: _this.serialize(),
            dataType: 'json', // Expect JSON response
            success: function(response) {
                if(response.status == 'success'){
                    if(response.html){                        
                        let parent_update_form  = _this.parents('.jobcircle-reviews-section');
                        let list_item =  parent_update_form.find('.jobcircle-reviews-listing .jobcircle-review-item-'+comment_id);

                        if(list_item.length){
                            var _html = jQuery(response.html);
                            var targetElement = _html.filter('.jobcircle-review-item-'+comment_id);
                            var targetHtml = targetElement.html();
                            list_item.html(targetHtml);
                        } else {
                            parent_update_form.find('.jobcircle-reviews-listing .row').prepend(response.html);
                        }
                        parent_update_form.find('.jobcircle-reviews-update').slideUp();
                    }
                    jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-success');
                } else {
                    jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-info');
                }
                jQuery('body').find('.jobcircle-loder-con').remove();
            },
            error: function(xhr, textStatus, errorThrown) {
                jQuery('body').find('.jobcircle-loder-con').remove();
                // Handle error response
                console.error('Error submitting comment:', errorThrown);
                jobcircle_submit_msg_alert(xhr.responseText, 'jobcircle-alert-danger');
            }
        });
    });

    jQuery(document).on('submit', 'form#jobcircle-review-form', function(e) {
        e.preventDefault();
        var _this = jQuery(this);
        let _this_html  = _this.find('.jobcircle-review-submit-btn').html();
        _this.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
        // Send AJAX request
        jQuery.ajax({
            type: 'POST',
            url: jobcricle_reviews_obj.ajaxUrl,
            data: _this.serialize(),
            dataType: 'json', // Expect JSON response
            success: function(response) {
                if(response.status == 'success'){
                    if(response.html){
                        _this.parents('.jobcircle-reviews-section').find('.jobcircle-reviews-listing .row').prepend(response.html);
                        _this.find('textarea[name="review"]').val('');
                    }
                    jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-success');
                } else {
                    jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-info');
                }
                //_this.find('.jobcircle-review-submit-btn').html(_this_html);
                jQuery('body').find('.jobcircle-loder-con').remove();
            },
            error: function(xhr, textStatus, errorThrown) {
                jQuery('body').find('.jobcircle-loder-con').remove();
                //_this.find('.jobcircle-review-submit-btn').html(_this_html)
                // Handle error response
                console.error('Error submitting comment:', errorThrown);
                jobcircle_submit_msg_alert(xhr.responseText, 'jobcircle-alert-danger');
            }
        });
    });

    jQuery(document).on('click', '.jobcircle-load-more-comments', function(e) {
        e.preventDefault();
        var _this = jQuery(this);
        var page_number = _this.data('page_number');
        let total_pages = _this.data('total_pages');
        let screen_type = _this.data('screen_type');
        let post_id = _this.data('post_id');
        let _this_html  = _this.html();
        _this.html('Loading............');
        // Send AJAX request
        jQuery.ajax({
            type: 'POST',
            url: jobcricle_reviews_obj.ajaxUrl,
            data: {
                action: 'jobcircle_load_more_comments',
                reviews_security: jobcricle_reviews_obj.security,
                page_number: page_number,
                total_pages: total_pages,
                screen_type: screen_type,
                post_id: post_id,
            },
            dataType: 'json', // Expect JSON response
            success: function(response) {
                if(response.status == 'success'){
                    if(response.html){
                        _this.parents('.jobcircle-reviews-section').find('.jobcircle-reviews-listing .row').append(response.html);
                    }
                    _this.html(_this_html);
                    if(response.hide_loader){
                        _this.parent().hide();
                    }                 
                    page_number++;
                    _this.data('page_number', page_number);
                } else {
                    _this.html(_this_html);
                    jobcircle_submit_msg_alert(response.msg, 'jobcircle-alert-info');
                }                
            },
            error: function(xhr, textStatus, errorThrown) {
                _this.html(_this_html)
                // Handle error response
                console.error('Error submitting comment:', errorThrown);
                //jobcircle_submit_msg_alert(xhr.responseText, 'jobcircle-alert-danger');
            }
        });
    });
});
