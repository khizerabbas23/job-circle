<?php

add_filter('jobcircle_dashboard_employer_manage_applicants_html', 'jobcircle_dashboard_employer_manage_applicants_html');

function jobcircle_dashboard_employer_manage_applicants_html() {

    global $wpdb, $current_user, $jobcircle_framework_options;

    $user_id = $current_user->ID;

    $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

    $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

    $account_page_url = home_url('/');
    if ($account_page_id > 0) {
        $account_page_url = get_permalink($account_page_id);
    }

    $no_res_found = true;

    ob_start();

    $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='jobs' AND post_author='$user_id'";
    $get_db_res = $wpdb->get_col($post_query);
    ?>
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">

                <?php
                if (isset($get_db_res[0])) {
                    $args = array(
                        'post_type' => 'job_applic',
                        'posts_per_page' => '50',
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => 'applic_job_id',
                                'value' => $get_db_res,
                                'compare' => 'IN'
                            )
                        ),
                        'order' => 'DESC',
                        'orderby' => 'ID',
                    );
            
                    $posts_query = new WP_Query($args);
            
                    if ($posts_query->have_posts()) {
                        ?>
                        <div class="jobcircle-dashb-section-upper">
                            <div class="dashb-hding-con">
                                <h3><?php printf(esc_html__('%s Applicants Found', 'jobcircle-frame'), $posts_query->found_posts) ?></h3>
                            </div>
                            
                            <div class="dashb-section-filter-drop">
                                <div class="single-fitres-dashb">
                                    <select class="form-select simple" name="sort_by">
                                        <option value="">Default Sorting</option>
                                        <option value="name">Short By Name</option>
                                        <option value="recent">Shot By Recent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="jobcircle-dashb-section">
                            <div class="table-block">
                                <div class="alert-job-table-container">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col"><?php esc_html_e('Job Title', 'jobcircle-frame') ?></th>
                                                <th scope="col"><?php esc_html_e('Job Position', 'jobcircle-frame') ?></th>
                                                <th scope="col"><?php esc_html_e('Applied Date', 'jobcircle-frame') ?></th>
                                                <th scope="col">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($posts_query->have_posts()) : $posts_query->the_post();
                                                $applic_id = get_the_id();
                                                $applic_obj = get_post($applic_id);
                                                $applic_post_date = $applic_obj->post_date;
                                                $applic_notes = $applic_obj->post_content;
                                                
                                                $job_id = get_post_meta($applic_id, 'applic_job_id', true);
                                                $aplicant_job_title = get_post_meta($applic_id, 'applic_job_title', true);
                                                

                                                $aplicant_resp_status = get_post_meta($applic_id, 'applic_response_status', true);

                                                //
                                                $is_candidate = false;
                                               $candidate_id = get_post_meta($applic_id, 'user_cand_id', true);
                                                if ($candidate_id > 0 && get_post_type($candidate_id) == 'candidates') {
                                                    $is_candidate = true;
                                                    $cand_cv_files = get_post_meta($candidate_id, 'candidate_cv_files', true);

                                                    if(!empty($cand_cv_files)){
                                                        $file_key = end(array_keys($cand_cv_files));    
                                                        // Get the value corresponding to the last index
                                                        $_cand_cv_files_lastValue = $cand_cv_files[$file_key];
                                                        if (isset($_cand_cv_files_lastValue['cred']['url']) && !empty($_cand_cv_files_lastValue['cred']['url'])) {
                                                            $cv_download_url = $_cand_cv_files_lastValue['cred']['url'];
                                                        }
                                                    }
                                                }

                                                $img_url = Jobcircle_Plugin::root_url() . 'images/user.png';
                                                $img_urls = get_post_meta($applic_id, 'applic_user_pic_urls', true);
                                                if (isset($img_urls['crop']) && $img_urls['crop'] != '') {
                                                    $img_url = $img_urls['crop'];
                                                }
                                                ?>
                                                <tr>
                                                    <td class="row-first-column">
                                                        <div class="image-holder"><img src="<?php echo ($img_url) ?>"></div>
                                                        <div class="textbox">
                                                            <?php
                                                            $applic_status_str = '';
                                                            if ($aplicant_resp_status != '') {
                                                                $applic_status_str = $aplicant_resp_status == 'shortlisted' ? esc_html__('Shortlisted', 'jobcircle-frame') : esc_html__('Rejected', 'jobcircle-frame');
                                                                $applic_status_color = $aplicant_resp_status == 'shortlisted' ? '#01b16f' : '#ff0000';
                                                            }
                                                            ?>
                                                            <div><?php echo get_the_title($applic_id) ?> <?php echo ($applic_status_str != '' ? '<span style="color:' . $applic_status_color . ';">(' . $applic_status_str . ')</span>' : '') ?></div>
                                                            <div><span class="job-status"><?php echo ($aplicant_job_title) ?></span></div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo get_the_title($job_id) ?></td>
                                                    <td><?php echo date_i18n(get_option('date_format'), strtotime($applic_post_date)) ?></td>
                                                    <td>
                                                        <div class="applic-actions-list">
                                                            <span><?php esc_html_e('Actions', 'jobcircle-frame') ?></span>
                                                            <ul>
                                                                <?php
                                                                if ($applic_notes != '') {
                                                                    ?>
                                                                    <li>
                                                                        <a href="#" class="jobcircle-aplicnote-btn" data-bs-toggle="modal" data-bs-target="#applic-note"><?php esc_html_e('Read Note', 'jobcircle-frame') ?></a>
                                                                        <div style="display:none;"><?php echo ($applic_notes) ?></div>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                if (isset($cv_download_url)) {
                                                                    ?>
                                                                    
                                                                    <li><a href="<?php echo apply_filters('jobcircle_candidate_cv_download_url', $candidate_id, $file_key) ?>"><?php esc_html_e('Download CV', 'jobcircle-frame') ?></a></li>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <li><a href="javascript:;" class="jobcircle-applic-sndmsg-btn" data-id="<?php echo ($applic_id) ?>" data-bs-toggle="modal" data-bs-target="#applic-send-msg"><?php esc_html_e('Send Message', 'jobcircle-frame') ?></a></li>
                                                                <?php
                                                                if ($aplicant_resp_status == '') {
                                                                    ?>
                                                                    <li><a href="javascript:;" class="jobcircle-applic-shotlist-btn" data-id="<?php echo ($applic_id) ?>"><?php esc_html_e('Shortlist', 'jobcircle-frame') ?></a></li>
                                                                    <li><a href="javascript:;" class="jobcircle-applic-reject-btn" data-id="<?php echo ($applic_id) ?>"><?php esc_html_e('Reject', 'jobcircle-frame') ?></a></li>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                    
                                            endwhile;
                                            wp_reset_postdata();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php
                        $no_res_found = false;
                        add_action('wp_footer', function() {
                            ?>
                            <div class="modal jobcircle-applic-note fade" id="applic-note" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog login-pop-form" role="document">
                                    <div class="modal-content"></div>
                                </div>
                            </div>
                            <div class="modal jobcircle-applic-message fade" id="applic-send-msg" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog login-pop-form" role="document">
                                    <div class="modal-content">
                                        <div class="modal-headers">
                                            <a href="javascript:;" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></a>
                                        </div>
                                        <form method="post" class="jobcircle-dashb-form account-detail-form">				
                                            <div class="form-group">
                                                <label><?php esc_html_e('Message', 'jobcircle-frame') ?></label>
                                                <textarea name="applicant_message" class="form-control" placeholder="<?php esc_html_e('Type your message for applicant', 'jobcircle-frame') ?>" required></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="form-security-fields" style="display: none;"></div>
                                                <input type="hidden" name="applic_id" value="0">
                                                <input type="hidden" name="action" value="jobcircle_job_applic_message_action">
                                                <button type="submit" class="jobcircle-formsubmit-btn"><?php esc_html_e('Send Message', 'jobcircle-frame') ?></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <script>
                                jQuery(document).on('click', '.jobcircle-aplicnote-btn', function() {
                                    var this_btn = jQuery(this);
                                    var notes_html = this_btn.parents('li').find('>div').html();
                                    jQuery('#applic-note').find('.modal-content').html(notes_html);
                                });
                                jQuery(document).on('click', '.applic-actions-list > span', function() {
                                    var this_btn = jQuery(this);
                                    this_btn.parent('.applic-actions-list').toggleClass('open-list');
                                });
                                jQuery(document).on('click', '.jobcircle-applic-sndmsg-btn', function() {
                                    var this_btn = jQuery(this);
                                    var id = this_btn.attr('data-id');
                                    jQuery('#applic-send-msg').find('input[name="applic_id"]').val(id);
                                });
                                jQuery(document).on('click', '.jobcircle-applic-shotlist-btn', function() {
                                    var this_btn = jQuery(this);
                                    var id = this_btn.attr('data-id');
                                    var this_parent = this_btn.parents('.applic-actions-list');
                                    this_parent.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
                                    jQuery.ajax({
                                        type: "POST",
                                        dataType: "json",
                                        url: jobcircle_cscript_vars.ajax_url,
                                        data: {
                                            id: id,
                                            action: 'jobcircle_dash_applic_shortlist_call'
                                        },
                                        success: function (data) {
                                            if (data.error == '0') {
                                                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
                                            } else if (data.error == '2') {
                                                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-info');
                                            } else {
                                                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
                                            }
                                            this_parent.find('.jobcircle-loder-con').remove();
                                        },
                                        error: function () {
                                            this_parent.find('.jobcircle-loder-con').remove();
                                        }
                                    });
                                });
                                jQuery(document).on('click', '.jobcircle-applic-reject-btn', function() {
                                    var this_btn = jQuery(this);
                                    var id = this_btn.attr('data-id');
                                    var this_parent = this_btn.parents('.applic-actions-list');
                                    this_parent.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
                                    jQuery.ajax({
                                        type: "POST",
                                        dataType: "json",
                                        url: jobcircle_cscript_vars.ajax_url,
                                        data: {
                                            id: id,
                                            action: 'jobcircle_dash_applic_reject_call'
                                        },
                                        success: function (data) {
                                            if (data.error == '0') {
                                                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-success');
                                            } else if (data.error == '2') {
                                                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-info');
                                            } else {
                                                jobcircle_submit_msg_alert(data.msg, 'jobcircle-alert-danger');
                                            }
                                            this_parent.find('.jobcircle-loder-con').remove();
                                        },
                                        error: function () {
                                            this_parent.find('.jobcircle-loder-con').remove();
                                        }
                                    });
                                });
                            </script>
                            <?php
                        }, 80);
                    }
                }
                if ($no_res_found) {
                    echo '<div class="dashboard-norecord-message">';
                    echo '<div class="norec-msg-holdr"><p>' . esc_html__('No record found.', 'jobcircle-frame') . '</p></div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
            
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}

add_action('wp_ajax_jobcircle_dash_applic_shortlist_call', 'jobcircle_dashb_applic_shortlist_call');

function jobcircle_dashb_applic_shortlist_call() {
    $applic_id = $_POST['id'];
    $user_id = get_current_user_id();
    $job_id = get_post_meta($applic_id, 'applic_job_id', true);
    $job_post = get_post($job_id);
    if (isset($job_post->post_author) && $job_post->post_author == $user_id) {
        update_post_meta($applic_id, 'applic_response_status', 'shortlisted');
        do_action('jobcircle_job_applicant_shortlisted_after', $applic_id);
        wp_send_json(array('error' => '0', 'msg' => esc_html__('Successfully Shortlisted.', 'jobcircle-frame')));
    }
    wp_send_json(array('error' => '2', 'msg' => esc_html__('You are not allowed to do this.', 'jobcircle-frame')));
}

add_action('wp_ajax_jobcircle_dash_applic_reject_call', 'jobcircle_dashb_applic_reject_call');

function jobcircle_dashb_applic_reject_call() {
    $applic_id = $_POST['id'];
    $user_id = get_current_user_id();
    $job_id = get_post_meta($applic_id, 'applic_job_id', true);
    $job_post = get_post($job_id);
    if (isset($job_post->post_author) && $job_post->post_author == $user_id) {
        update_post_meta($applic_id, 'applic_response_status', 'rejected');
        do_action('jobcircle_job_applicant_rejected_after', $applic_id);
        wp_send_json(array('error' => '0', 'msg' => esc_html__('Successfully Rejected.', 'jobcircle-frame')));
    }
    wp_send_json(array('error' => '2', 'msg' => esc_html__('You are not allowed to do this.', 'jobcircle-frame')));
}
add_action('wp_ajax_jobcircle_job_applic_message_action', 'jobcircle_job_applic_message_action');

function jobcircle_job_applic_message_action() {
    $jobcircle_applic_id = !empty($_POST['applic_id']) ? intval($_POST['applic_id']) : '';
    $jobcircle_applicant_message = !empty($_POST['applicant_message']) ? sanitize_textarea_field($_POST['applicant_message']) : '';
    $jobcircle_user_id = get_current_user_id();

    if(empty($jobcircle_applicant_message)){
        wp_send_json(array('error' => '2', 'msg' => esc_html__('Please enter message.', 'jobcircle-frame')));
    }

    if(empty($jobcircle_applic_id) || empty($jobcircle_user_id)){
        wp_send_json(array('error' => '2', 'msg' => esc_html__('Somthing went wrong. Please try again after page refresh.', 'jobcircle-frame')));
    }
    $jobcircle_job_title = get_post_meta($jobcircle_applic_id, 'applic_job_title', true);
    $jobcircle_job_id = get_post_meta($jobcircle_applic_id, 'applic_job_id', true);
    $jobcircle_candidate_id = get_post_meta($jobcircle_applic_id, 'user_cand_id', true);

    if(empty($jobcircle_candidate_id)){
        wp_send_json(array('error' => '2', 'msg' => esc_html__('Somthing went wrong. Please try again after page refresh.', 'jobcircle-frame')));
    }
    $jobcircle_candidate_user_id = jobcircle_candidate_user_id($jobcircle_candidate_id);

    if(!empty($jobcircle_candidate_user_id)){
        $jobcircle_user = get_user_by('id', $jobcircle_candidate_user_id);

        if ( ! is_wp_error( $jobcircle_user ) ) {
            $jobcircle_args = array(
                'jobcircle_user' => $jobcircle_user,
                'jobcircle_employer_id' => $jobcircle_user_id,
                'jobcircle_job_id' => $jobcircle_job_id,
                'jobcircle_job_title' => $jobcircle_job_title,
                'jobcircle_applicant_message' => $jobcircle_applicant_message,
            );
            do_action('jobcircle_employer_applicant_message_email', $jobcircle_user, $jobcircle_args);
            $jobcircle_args = array(
                'jobcircle_sender_id' => $jobcircle_user_id,
                'jobcircle_receiver_id' => $jobcircle_user->ID,
                'jobcircle_message' => $jobcircle_applicant_message,
            );
            do_action('jobcircle_employer_applicant_message', $jobcircle_args);
            wp_send_json(array('error' => '0', 'redirect' => 'same', 'msg' => esc_html__('Message has been sent to Applicant.', 'jobcircle-frame')));
        }
    }
    wp_send_json(array('error' => '2', 'msg' => esc_html__('Somthing went wrong. Please try again after page refresh.', 'jobcircle-frame')));   
}