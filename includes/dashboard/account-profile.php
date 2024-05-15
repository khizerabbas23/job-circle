<?php
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/data-submit.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/job-submit.php';

include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/job-apply-functions.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/profile-score-functions.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/zoom-meetings-functions.php';

include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/change-password.php';

include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/candidate/dashboard.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/candidate/applied-jobs.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/candidate/my-resume.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/candidate/resume-manager.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/candidate/saved-jobs.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/candidate/job-alerts.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/candidate/packages.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/employer/dashboard.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/employer/post-new-job.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/employer/manage-jobs.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/employer/manage-applicants.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/employer/saved-resumes.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/employer/packages.php';
include_once JOBCIRCLE_ABSPATH . 'includes/dashboard/transactions.php';

function jobcircle_add_async_attribute($tag, $handle, $src) {
    // Add async attribute only to specific scripts
    if ('jobcircle-job-map-api' === $handle) {
        // Add async attribute
        $tag = '<script type="text/javascript" src="' . esc_url($src) . '" async></script>';
    }
    return $tag;
}

// Hook into 'script_loader_tag' filter
add_filter('script_loader_tag', 'jobcircle_add_async_attribute', 10, 3);

add_action('wp_ajax_jobcircle_user_account_type_selection_call', 'jobcircle_user_account_type_selection_call');

function jobcircle_user_account_type_selection_call() {
    global $jobcircle_framework_options, $current_user;

    $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

    $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

    $account_page_url = home_url('/');
    if ($account_page_id > 0) {
        $account_page_url = get_permalink($account_page_id);
    }

    $user_id = $current_user->ID;

    $display_name = $current_user->display_name;

    $user_type = $_POST['acc_type'];
    if ($user_type == 'employer') {
        $acc_type = 'employer';
    } else {
        $acc_type = 'candidate';
    }

    update_user_meta($user_id, 'user_account_post_type', $acc_type);

    if ($user_type == 'employer') {
        $employer_id = jobcircle_user_employer_id($user_id);
        if (!$employer_id) {
            $my_post = array(
                'post_title' => $display_name,
                'post_type' => 'employer',
                'post_status' => 'publish',
                'post_author' => $user_id,
            );
            wp_insert_post($my_post);
        }
    } else {
        $candidate_id = jobcircle_user_candidate_id($user_id);
        if (!$candidate_id) {
            $my_post = array(
                'post_title' => $display_name,
                'post_type' => 'candidates',
                'post_status' => 'publish',
                'post_author' => $user_id,
            );
            wp_insert_post($my_post);
        }
    }
    wp_send_json(array('url' => $account_page_url));
}

add_filter('jobcircle_dashboard_candidate_profile_html', 'jobcircle_dashb_general_profile');
add_filter('jobcircle_dashboard_employer_profile_html', 'jobcircle_dashb_general_profile');

function jobcircle_dashb_general_profile($html = '') {
    global $current_user, $jobcircle_countries_list, $jobcircle_countries_states_list, $jobcircle_framework_options;
    $jobcircle_user_account_approval    = !empty($jobcircle_framework_options['user_account_approval']) ? $jobcircle_framework_options['user_account_approval'] : '';
    //user_account_approval

    $rand_num = rand(1000000, 9999999);

    $user_id = $current_user->ID;
    $display_name = $current_user->display_name;
    
    $member_id = 0;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    $employer_id = jobcircle_user_employer_id($user_id);
    if ($candidate_id) {
        $member_id = $candidate_id;
        $display_name = get_the_title($candidate_id);
    } else if ($employer_id) {
        $member_id = $employer_id;
        $display_name = get_the_title($employer_id);
    }

    wp_enqueue_script('jobcircle-job-map-api');
    wp_enqueue_script('jobcircle-location');

    ob_start();

    $jobcircle_user_verified    = '';

    if (!$candidate_id && !$employer_id) {
        $jobcircle_user_verified    = get_user_meta( $user_id, 'jobcircle_user_verified', true );

        ?>
        <div class="dashboard-widg-bar d-block">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="_dashboard_content bg-white rounded mb-4">
                        <div class="_dashboard_content_header br-bottom py-3 px-3">
                            <div class="choos-acctype-maincon">
                                <div class="acctype-hding-con"><strong><?php esc_html_e('Choose your account type', 'jobcircle-frame');?></strong></div>
                                <div class="acctype-boxes-con">
                                    <?php
                                    if($jobcircle_user_verified == 'yes'){
                                        ?>
                                        <div class="acctype-box-itm candidate-box-item">
                                            <div><i class="jobcircle-fa jobcircle-faicon-user"></i></div>
                                            <div>
                                                <strong><?php esc_html_e('Candidate', 'jobcircle-frame');?></strong>
                                                <span><?php esc_html_e('(Browse Jobs)', 'jobcircle-frame');?></span>
                                            </div>
                                        </div>
                                        <div class="acctype-box-itm employer-box-item">
                                            <div><i class="jobcircle-fa jobcircle-faicon-briefcase"></i></div>
                                            <div>
                                                <strong><?php esc_html_e('Employer', 'jobcircle-frame');?></strong>
                                                <span><?php esc_html_e('(Hire Talent)', 'jobcircle-frame');?></span>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="jobcircle-unverified-account alert alert-warning" role="alert">
                                            <?php 
                                            if($jobcircle_user_account_approval == 'email_verify'){
                                                ?>
                                                <?php esc_html_e('Your Account is not verified. Please check your email for verfication link.', 'jobcircle-frame');?>
                                                <span><a href="javascript:void(0)" class="jobcircle-link jobcircle-resend-verification"><?php esc_html_e('Click Here', 'jobcircle-frame');?></a> <?php esc_html_e('To resend verification email.', 'jobcircle-frame');?></span>
                                                <?php
                                            } elseif($jobcircle_user_account_approval == 'admin_verify'){
                                                ?>
                                                <?php esc_html_e('Your Account is not verified. Your account must be verified.', 'jobcircle-frame');?>
                                                <span><?php esc_html_e('Your account will undergo review by the administration, which may take up to 24 hours.', 'jobcircle-frame');?></span>
                                                <?php
                                            } else {
                                                if($jobcircle_user_verified == 'no'){
                                                    ?>
                                                    <span><?php esc_html_e('Your account has been declined by the administrator.', 'jobcircle-frame');?></span>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="profile-form">
        <div class="heading"><?php esc_html_e('My Account', 'jobcircle-frame');?></div>
    <?php 
    $jobcircle_user_verified    = get_user_meta( $user_id, 'jobcircle_user_verified', true );
    ?>
    
        <form method="post" class="jobcircle-dashb-form account-detail-form">
            <input type="hidden" id="jobcircle_verfied_account" name="jobcircle_verfied" value="<?php echo esc_attr($jobcircle_user_verified);?>"/>
            <?php
            if ($employer_id) {
                $desc = '';
                $profile_img_url = '';
                if ($employer_id) {
                    $employer_obj = get_post($employer_id);
                    $desc = isset($employer_obj->post_content) ? $employer_obj->post_content : '';
                    if (!empty($desc)) {
                        $desc = trim(apply_filters('the_content', $desc));
                    }

                    $img_thumb_id = get_post_thumbnail_id($employer_id);
                    $profile_img_url = wp_get_attachment_image_url($img_thumb_id, 'medium');
                }
                $job_title = get_post_meta($employer_id, 'jobcircle_field_job_title', true);
                $phone_number = get_post_meta($employer_id, 'jobcircle_field_user_phone', true);
                $found_date = get_post_meta($employer_id, 'jobcircle_field_founded_date', true);
                $public_info = get_post_meta($employer_id, 'jobcircle_field_public_info', true);
                ?>
                
                <div class="input-image-row">
                    <div class="input-feilds">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Company Name*', 'jobcircle-frame');?></label>
                                    <input type="text" name="company_name" class="jobcircle-form-field" placeholder="Company Name" value="<?php echo jobcircle_esc_html($display_name) ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Email*', 'jobcircle-frame');?></label>
                                    <input type="email" class="jobcircle-form-field" readonly value="<?php echo jobcircle_esc_html($current_user->user_email) ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Phone*', 'jobcircle-frame');?></label>
                                    <input type="text" name="jobcircle_field_user_phone" class="jobcircle-form-field" value="<?php echo jobcircle_esc_html($phone_number) ?>">
                                </div>
                            </div>
                            <?php
                            $saved_cats = wp_get_post_terms($employer_id, 'employer_cat', array('fields' => 'ids'));
                            $employer_cat = isset($saved_cats[0]) ? $saved_cats[0] : '';
                            $get_cats = get_terms(array(
                                'taxonomy' => 'employer_cat',
                                'fields' => 'id=>name',
                                'parent' => 0,
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'hide_empty' => false,
                            ));
                            ?>
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Category*', 'jobcircle-frame');?></label>
                                    <select name="employer_cat" class="jobcircle-form-field">
                                        <option value=""><?php esc_html_e('Choose Category', 'jobcircle-frame');?></option>
                                        <?php
                                        if (!empty($get_cats)) {
                                            foreach ($get_cats as $cat_id => $cat_label) {
                                                ?>
                                                <option value="<?php echo ($cat_id) ?>"<?php echo ($cat_id == $employer_cat ? ' selected' : '') ?>><?php echo ($cat_label) ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Founded Date', 'jobcircle-frame');?></label>
                                    <input type="text" name="jobcircle_field_founded_date" class="jobcircle-form-field jobcircle-datepicker" placeholder="18-06-1989" value="<?php echo jobcircle_esc_html($found_date) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="image-holder">
                        <div id="logofile-name-container" class="custom-file avater_uploads">
                            <input id="logofile-custom-input" type="file" name="user_profile_pic" onchange="jobcircle_dashb_image_file_change(event)" accept="image/png, image/jpg, image/jpeg" class="custom-file-input">
                            <label class="custom-file-label logo-img-con" for="logofile-custom-input">
                                <img src="<?php echo esc_url($profile_img_url) ?>" alt=""<?php echo ($profile_img_url != '' ? '' : ' style="display: none;"') ?>>
                                <i class="jobcircle-fa jobcircle-faicon-user"<?php echo ($profile_img_url != '' ? ' style="display: none;"' : '') ?>></i>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="other-fields">
                    <div class="row">
                        <div class="col-xl-6 col-lg-12">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Website URL', 'jobcircle-frame');?></label>
                                <input type="url" name="web_url" class="jobcircle-form-field" placeholder="https://my-site.com/" value="<?php echo ($current_user->user_url) ?>">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Contact info view (for public)', 'jobcircle-frame');?></label>
                                <select name="jobcircle_field_public_info" class="jobcircle-form-field">
                                    <option value="yes"><?php esc_html_e('Yes', 'jobcircle-frame');?></option>
                                    <option value="no"<?php echo ($public_info == 'no' ? ' selected' : '') ?>><?php esc_html_e('No', 'jobcircle-frame');?></option>
                                </select>
                            </div>
                        </div>
                        <?php
                        $zoom_meets = isset($jobcircle_framework_options['employer_zoom_meetings']) ? $jobcircle_framework_options['employer_zoom_meetings'] : '';
                        if ($zoom_meets == 'on') {
                            $zoom_client_id = get_post_meta($employer_id, 'jobcircle_field_zoom_client_id', true);
                            $zoom_client_secret = get_post_meta($employer_id, 'jobcircle_field_zoom_client_secret', true);
                            ?>
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Zoom Client ID', 'jobcircle-frame') ?></label>
                                    <input type="text" name="jobcircle_field_zoom_client_id" class="jobcircle-form-field" placeholder="1ZdEvQoFddICqD7n16wNPF0" value="<?php echo ($zoom_client_id) ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Zoom Client Secret', 'jobcircle-frame') ?></label>
                                    <input type="text" name="jobcircle_field_zoom_client_secret" class="jobcircle-form-field" placeholder="1ZdEvQoFddICqD0dEvQoFddICqD7n14w" value="<?php echo ($zoom_client_secret) ?>">
                                </div>
                            </div>
                            <?php
                            echo apply_filters('jobcircle_dashboard_zoom_get_auth_btn', '', $employer_id);
                        }
                        echo apply_filters('jobcircle_dash_employer_profile_fields_extra', '', $member_id);
                        ?>
                        <div class="col-xl-12 col-lg-12">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Company Info*', 'jobcircle-frame');?></label>
                                <?php
                                $settings = array(
                                    'media_buttons' => false,
                                    'editor_class' => 'jobcircle-editor-field',
                                    'textarea_name' => 'info_content',
                                    'quicktags' => false,
                                    'textarea_rows' => 10,
                                    'tinymce' => array(
                                        'toolbar1' => 'bold,bullist,numlist,italic,underline,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
                                        'toolbar2' => '',
                                        'toolbar3' => '',
                                    ),
                                );
                                $desc = jobcircle_esc_wp_editor($desc);
                                wp_editor($desc, 'short-desc-' . $rand_num, $settings);
                                ?>
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 contact-info-fields">
                            <div class="jobcircle-form-fieldhldr btn-submit">
                                <input type="hidden" name="action" value="jobcircle_employer_dashboard_profile_save_call">
                                <input type="submit" value="<?php esc_html_e('Save Changes', 'jobcircle-frame') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                $desc = '';
                $profile_img_url = '';
                if ($candidate_id) {
                    $candidate_obj = get_post($candidate_id);
                    $desc = isset($candidate_obj->post_content) ? $candidate_obj->post_content : '';
                    if (!empty($desc)) {
                        $desc = trim(apply_filters('the_content', $desc));
                    }

                    $img_thumb_id = get_post_thumbnail_id($candidate_id);
                    $profile_img_url = wp_get_attachment_image_url($img_thumb_id, 'medium');
                }
                $job_title = get_post_meta($candidate_id, 'jobcircle_field_job_title', true);
                $phone_number = get_post_meta($candidate_id, 'jobcircle_field_user_phone', true);
                $dob = get_post_meta($candidate_id, 'jobcircle_field_dob', true);
                $public_info = get_post_meta($candidate_id, 'jobcircle_field_public_info', true);
                $salary = get_post_meta($candidate_id, 'jobcircle_field_salary', true);
                $salary_unit = get_post_meta($candidate_id, 'jobcircle_field_salary_unit', true);
                ?>
                <div class="input-image-row">
                    <div class="input-feilds">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Full Name*', 'jobcircle-frame');?></label>
                                    <input type="text" name="user_full_name" class="jobcircle-form-field" placeholder="<?php esc_attr_e('Enter Full Name*', 'jobcircle-frame');?>" value="<?php echo jobcircle_esc_html($display_name) ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Job Title*', 'jobcircle-frame');?></label>
                                    <input type="text" name="jobcircle_field_job_title" class="jobcircle-form-field" value="<?php echo jobcircle_esc_html($job_title) ?>" placeholder="<?php esc_attr_e('Enter Job Title i.e Graphic Designer', 'jobcircle-frame');?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Email*', 'jobcircle-frame');?></label>
                                    <input type="email" class="jobcircle-form-field" readonly value="<?php echo ($current_user->user_email) ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Phone*', 'jobcircle-frame');?></label>
                                    <input type="text" name="jobcircle_field_user_phone" class="jobcircle-form-field" value="<?php echo jobcircle_esc_html($phone_number) ?>" placeholder="<?php esc_attr_e('Enter Phone*', 'jobcircle-frame');?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Date of Birth', 'jobcircle-frame');?></label>
                                    <input type="text" name="jobcircle_field_dob" class="jobcircle-form-field jobcircle-datepicker" placeholder="<?php esc_attr_e('Enter Date of Birth', 'jobcircle-frame');?>" value="<?php echo jobcircle_esc_html($dob) ?>">
                                </div>
                            </div>
                            <?php
                            $saved_cats = wp_get_post_terms($candidate_id, 'candidate_cat', array('fields' => 'ids'));
                            $candidate_cat = isset($saved_cats[0]) ? $saved_cats[0] : '';
                            $get_cats = get_terms(array(
                                'taxonomy' => 'candidate_cat',
                                'fields' => 'id=>name',
                                'parent' => 0,
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'hide_empty' => false,
                            ));
                            ?>
                            <div class="col-xl-6 col-lg-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Category*', 'jobcircle-frame');?></label>
                                    <select name="sec_category" class="jobcircle-form-field">
                                        <option value=""><?php esc_html_e('Choose Category', 'jobcircle-frame');?></option>
                                        <?php
                                        if (!empty($get_cats)) {
                                            foreach ($get_cats as $cat_id => $cat_label) {
                                                ?>
                                                <option value="<?php echo ($cat_id) ?>"<?php echo ($cat_id == $candidate_cat ? ' selected' : '') ?>><?php echo ($cat_label) ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="image-holder">
                        <div id="logofile-name-container" class="custom-file avater_uploads">
                            <input id="logofile-custom-input" type="file" name="user_profile_pic" onchange="jobcircle_dashb_image_file_change(event)" accept="image/png, image/jpg, image/jpeg" class="custom-file-input">
                            <label class="custom-file-label logo-img-con" for="logofile-custom-input">
                                <img src="<?php echo esc_url($profile_img_url) ?>" alt=""<?php echo ($profile_img_url != '' ? '' : ' style="display: none;"') ?>>
                                <i class="jobcircle-fa jobcircle-faicon-user"<?php echo ($profile_img_url != '' ? ' style="display: none;"' : '') ?>></i>
                            </label>
                        </div>
                    </div>

                </div>
                <div class="other-fields">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Contact info view (for public)', 'jobcircle-frame');?></label>
                                <select name="jobcircle_field_public_info" class="jobcircle-form-field">
                                    <option value="yes"><?php esc_html_e('Yes', 'jobcircle-frame');?></option>
                                    <option value="no"<?php echo ($public_info == 'no' ? ' selected' : '') ?>><?php esc_html_e('No', 'jobcircle-frame');?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="jobcircle-form-fieldhldr">
                                        <label class="text-dark ft-medium"><?php esc_html_e('Current Salary*', 'jobcircle-frame');?></label>
                                        <input type="number" name="jobcircle_field_salary" min="1" class="jobcircle-form-field" placeholder="<?php esc_attr_e('Enter Current Salary', 'jobcircle-frame');?>" value="<?php echo jobcircle_esc_html($salary) ?>">
                                    </div>
                                </div>
                                <?php
                                $salary_units_list = jobcircle_salary_units_list();
                                ?>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="jobcircle-form-fieldhldr">
                                        <label class="text-dark ft-medium"><?php esc_html_e('Salary Unit*', 'jobcircle-frame');?></label>
                                        <select name="jobcircle_field_salary_unit" class="jobcircle-form-field">
                                            <?php
                                            foreach ($salary_units_list as $salary_unit_key => $salary_unit_label) {
                                                ?>
                                                <option value="<?php echo ($salary_unit_key) ?>"<?php echo ($salary_unit == $salary_unit_key ? ' selected' : '') ?>><?php echo ($salary_unit_label) ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $saved_skills = wp_get_post_terms($candidate_id, 'candidate_skill', array('fields' => 'names'));
                        $saved_skills_str = '';
                        if (!empty($saved_skills)) {
                            $saved_skills_str = implode(', ', $saved_skills);
                        }
                        ?>
                        <div class="col-xl-12 col-lg-12">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Skills (Comma Separated)', 'jobcircle-frame');?></label>
                                <input type="text" name="user_skills" class="jobcircle-form-field" placeholder="<?php esc_attr_e('Enter Comma Separated Skills e.x PHP, SEO, Marketing', 'jobcircle-frame');?>" value="<?php echo ($saved_skills_str) ?>">
                            </div>
                        </div>
                        <?php echo apply_filters('jobcircle_dash_candidate_profile_fields_extra', '', $member_id) ?>
                        <div class="col-xl-12 col-lg-12">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('About Info', 'jobcircle-frame');?></label>
                                <?php
                                $settings = array(
                                    'media_buttons' => false,
                                    'editor_class' => 'jobcircle-editor-field',
                                    'textarea_name' => 'info_content',
                                    'quicktags' => false,
                                    'textarea_rows' => 5,
                                    'tinymce' => array(
                                        'toolbar1' => 'bold,bullist,numlist,italic,underline,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
                                        'toolbar2' => '',
                                        'toolbar3' => '',
                                    ),
                                );
                                $desc = jobcircle_esc_wp_editor($desc);
                                wp_editor($desc, 'short-desc-' . $rand_num, $settings);
                                ?>
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 contact-info-fields">
                            <div class="jobcircle-form-fieldhldr btn-submit">
                                <input type="hidden" name="action" value="jobcircle_user_dashboard_profile_save_call">
                                <input type="submit" value="<?php esc_html_e('Save Changes', 'jobcircle-frame') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </form>
        
        <?php
        if ($candidate_id || $employer_id) {
            $facebook_url = get_post_meta($member_id, 'jobcircle_field_facebook_url', true);
            $twitter_url = get_post_meta($member_id, 'jobcircle_field_twitter_url', true);
            $linkedin_url = get_post_meta($member_id, 'jobcircle_field_linkedin_url', true);
            $google_url = get_post_meta($member_id, 'jobcircle_field_google_url', true);
            ?>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="heading"><?php esc_html_e('Social Accounts', 'jobcircle-frame');?></div>
                    <form method="post" class="jobcircle-dashb-form account-detail-form">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Facebook', 'jobcircle-frame');?></label>
                                    <input type="text" name="jobcircle_field_facebook_url" value="<?php echo jobcircle_esc_html($facebook_url) ?>" class="jobcircle-form-field" placeholder="<?php esc_attr_e('https://www.facebook.com/', 'jobcircle-frame');?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Twitter', 'jobcircle-frame');?></label>
                                    <input type="text" name="jobcircle_field_twitter_url" value="<?php echo jobcircle_esc_html($twitter_url) ?>" class="jobcircle-form-field" placeholder="<?php esc_attr_e('https://www.twitter.com/', 'jobcircle-frame');?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('LinkedIn', 'jobcircle-frame');?></label>
                                    <input type="text" name="jobcircle_field_linkedin_url" value="<?php echo jobcircle_esc_html($linkedin_url) ?>" class="jobcircle-form-field" placeholder="<?php esc_attr_e('https://www.linkedin.com/', 'jobcircle-frame');?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('GooglePlus', 'jobcircle-frame');?></label>
                                    <input type="text" name="jobcircle_field_google_url" value="<?php echo jobcircle_esc_html($google_url) ?>" class="jobcircle-form-field" placeholder="<?php esc_attr_e('https://www.gplus.com/', 'jobcircle-frame');?>">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 contact-info-fields">
                                <div class="jobcircle-form-fieldhldr btn-submit">
                                    <input type="hidden" name="action" value="jobcircle_user_dashboard_social_save_call">
                                    <input type="submit" value="<?php esc_html_e('Save Changes', 'jobcircle-frame') ?>">
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
                
                <div class="col-lg-12 col-md-12">
                    <div class="heading"><?php esc_html_e('Contact Information', 'jobcircle-frame');?></div>
                    <?php
                    $country = get_post_meta($member_id, 'jobcircle_field_loc_country', true);
                    $state = get_post_meta($member_id, 'jobcircle_field_loc_state', true);
                    $loc_city = get_post_meta($member_id, 'jobcircle_field_loc_city', true);
                    $loc_address = get_post_meta($member_id, 'jobcircle_field_loc_address', true);
                    $loc_zipcode = get_post_meta($member_id, 'jobcircle_field_loc_zipcode', true);
                    $loc_latitude = get_post_meta($member_id, 'jobcircle_field_loc_latitude', true);
                    $loc_longitude = get_post_meta($member_id, 'jobcircle_field_loc_longitude', true);
                    ?>
                    <form method="post" class="jobcircle-dashb-form account-detail-form">
                        <div class="row">	
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Country*', 'jobcircle-frame');?></label>
                                    <select name="jobcircle_field_loc_country" id="jobcircle-country" class="jobcircle-form-field" required>
                                        <option value=""><?php esc_html_e('Select Country', 'jobcircle-frame');?></option>
                                        <?php
                                        $jobcirlce_selected_state = '';
                                        $jobcirlce_selected_country_code = '';
                                        foreach ($jobcircle_countries_list as $country_code => $contry_name) {
                                            $jobcircle_selected = '';
                                            if($country == $contry_name){
                                                $jobcirlce_selected_country_code    = $country_code;
                                                $jobcircle_selected = ' selected="selected"';
                                            }
                                            ?>
                                            <option value="<?php echo esc_attr($contry_name) ?>" data-country_code="<?php echo esc_attr($country_code);?>"<?php echo do_shortcode($jobcircle_selected); ?>><?php echo esc_html($contry_name) ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('State', 'jobcircle-frame');?></label>
                                    <select name="jobcircle_field_loc_state" id="jobcircle-state" class="jobcircle-form-field">
                                        <option value=""><?php esc_html_e('Select State', 'jobcircle-frame');?></option>
                                        <?php
                                        if(!empty($jobcircle_countries_states_list[$jobcirlce_selected_country_code]))
                                            foreach ($jobcircle_countries_states_list[$jobcirlce_selected_country_code] as $state_code => $state_name) {
                                                $jobcircle_selected = '';
                                                if($state == $state_name){
                                                    $jobcircle_selected = ' selected="selected"';
                                                }
                                                ?>
                                                <option value="<?php echo esc_attr($state_name) ?>" data-state_code="<?php echo esc_attr($state_code);?>"<?php echo do_shortcode($jobcircle_selected); ?>><?php echo esc_html($state_name) ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('City*', 'jobcircle-frame');?></label>
                                    <input type="text" class="jobcircle-form-field" id="jobcircle-city" name="jobcircle_field_loc_city" value="<?php echo jobcircle_esc_html($loc_city) ?>" placeholder="<?php esc_attr_e('Enter City Name', 'jobcircle-frame');?>" required>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Zip Code*', 'jobcircle-frame');?></label>
                                    <input type="text" class="jobcircle-form-field" id="jobcircle-zipcode" name="jobcircle_field_loc_zipcode" value="<?php echo jobcircle_esc_html($loc_zipcode) ?>" placeholder="<?php esc_attr_e('Enter zipcode', 'jobcircle-frame');?>" required>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Full Address*', 'jobcircle-frame');?></label>
                                    <input type="text" class="jobcircle-form-field" id="jobcircle-address" name="jobcircle_field_loc_address" value="<?php echo jobcircle_esc_html($loc_address) ?>" placeholder="<?php esc_attr_e(' H#10 Marke Juger, SBI Road', 'jobcircle-frame');?>"  required>
                                    
                                </div>
                            </div>                           
                            <div class="col-xl-12 col-lg-12 contact-info-fields">
                                <div class="jobcircle-form-fieldhldr btn-submit">
                                    <input type="hidden" id="jobcircle-latitude" name="jobcircle_field_loc_latitude" value="<?php echo jobcircle_esc_html($loc_latitude) ?>">
                                    <input type="hidden" id="jobcircle-longitude" name="jobcircle_field_loc_longitude" value="<?php echo jobcircle_esc_html($loc_longitude) ?>">
                                    <input type="hidden" name="action" value="jobcircle_user_dashboard_location_save_call">
                                    <input type="submit" value="<?php esc_html_e('Save Changes', 'jobcircle-frame') ?>">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>	
            </div>	
            <?php
        }
        ?>
    </div>
    <div class="space-top-footer"></div>
    <?php
    $html = ob_get_clean();
    return $html;
}