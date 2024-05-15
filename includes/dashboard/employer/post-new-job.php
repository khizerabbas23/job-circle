<?php

add_filter('jobcircle_dashboard_employer_post_job_html', 'jobcircle_dashboard_employer_post_job_html');

function jobcircle_dashboard_employer_post_job_html() {
    $page_permissions = jobcircle_check_page_permissions('employer','post-job');
    if($page_permissions === 0){
        $home_page_url = home_url('/');  
        echo '<script>window.location.href="'.$home_page_url.'"</script>';
        exit;            
    }
    
    ob_start();
    jobcircle_employer_job_form();
    $html = ob_get_clean();
    return $html;
}

function jobcircle_employer_job_form() {

    global $current_user, $jobcircle_countries_list, $jobcircle_countries_states_list, $jobcircle_framework_options;

    wp_enqueue_script('jobcircle-job-map-api');
    wp_enqueue_script('jobcircle-location');

    $rand_num = rand(1000000, 9999999);

    $job_id = 0;
    $user_id = 0;
    $employer_id = 0;
    $user_logedin = false;
    $is_emp_job = false;

    $job_form_hding = 'Post Job';

    $display_name = '';
    $job_title = '';
    $desc = '';
    $job_img_url = '';
    $job_type = '';
    $application_deadline = '';
    $min_salary = '';
    $max_salary = '';
    $salary_unit = '';
    $country = '';
    $state = '';
    $loc_zipcode = '';
    $loc_city = '';
    $loc_address = '';
    $loc_latitude = '';
    $loc_longitude = '';
    $job_upd = false;

    if (is_user_logged_in()) {
        
        $user_id = $current_user->ID;
        $display_name = $current_user->display_name;

        $user_logedin = true;
        
        $employer_id = jobcircle_user_employer_id($user_id);
        if ($employer_id) {
            $display_name = get_the_title($employer_id);

            $job_id = isset($_GET['id']) ? $_GET['id'] : '';
            if ($job_id > 0 && get_post_type($job_id) == 'jobs') {
                $job_upd = true;
            }

            if (isset($job_upd)) {
                $is_emp_job = jobcircle_is_employer_job($job_id, $user_id);
            }

            //
            if ($is_emp_job) {
                $job_type = get_post_meta($job_id, 'jobcircle_field_job_type', true);
                $application_deadline = get_post_meta($job_id, 'jobcircle_field_job_deadline', true);
                $min_salary = get_post_meta($job_id, 'jobcircle_field_min_salary', true);
                $max_salary = get_post_meta($job_id, 'jobcircle_field_max_salary', true);
                $salary_unit = get_post_meta($job_id, 'jobcircle_field_salary_unit', true);
                $country = get_post_meta($job_id, 'jobcircle_field_loc_country', true);
                $state = get_post_meta($job_id, 'jobcircle_field_loc_state', true);
                $loc_city = get_post_meta($job_id, 'jobcircle_field_loc_city', true);
                $loc_zipcode = get_post_meta($job_id, 'jobcircle_field_loc_zipcode', true);
                $loc_address = get_post_meta($job_id, 'jobcircle_field_loc_address', true);
                $loc_latitude = get_post_meta($job_id, 'jobcircle_field_loc_latitude', true);
                $loc_longitude = get_post_meta($job_id, 'jobcircle_field_loc_longitude', true);

                $job_obj = get_post($job_id);
                $job_title = isset($job_obj->post_title) ? $job_obj->post_title : '';
                $desc = isset($job_obj->post_content) ? $job_obj->post_content : '';
                $desc = trim(apply_filters('the_content', $desc));

                $img_thumb_id = get_post_thumbnail_id($job_id);
                $job_img_url = wp_get_attachment_image_url($img_thumb_id, 'medium');
                
                $job_form_hding = sprintf(esc_html__('Update job "%s"', 'jobcircle-frame'), $job_title);
            }
        }
    }

    $job_types_list = jobcircle_job_types_list();
    $salary_units_list = jobcircle_salary_units_list();

    $openai_api_key = isset($jobcircle_framework_options['openai_api_key']) ? $jobcircle_framework_options['openai_api_key'] : '';
    ?>
    <div class="profile-form">
        <div class="heading"><?php echo ($job_form_hding) ?></h4></div>
        <form method="post" class="jobcircle-dashb-form account-detail-form">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="row">
                    
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Job Title', 'jobcircle-frame');?></label>
                                <input type="text" name="job_title" required class="jobcircle-form-field" placeholder="<?php esc_attr_e('Title', 'jobcircle-frame');?>" value="<?php echo jobcircle_esc_html($job_title) ?>">
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="jobcircle-form-fieldhldr form-fieldhldr-parntcon">
                                <label class="text-dark ft-medium"><?php esc_html_e('Job Description', 'jobcircle-frame');?></label>
                                <?php
                                if ($openai_api_key != '') {
                                    ?>
                                    <a href="javascript:;" class="jobcreate-content-with-ai create-with-ai-btn"><?php esc_html_e('Create description with AI') ?></a>
                                    <?php
                                }
                                $settings = array(
                                    'media_buttons' => false,
                                    'editor_class' => 'jobcircle-editor-field',
                                    'textarea_name' => 'job_content',
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
                        <?php
                        if (!$user_logedin) {
                            ?>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('Email Address', 'jobcircle-frame');?></label>
                                    <input type="text" name="user_email" class="jobcircle-form-field" placeholder="<?php esc_attr_e('Email', 'jobcircle-frame');?>">
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="jobcircle-form-fieldhldr">
                                    <label class="text-dark ft-medium"><?php esc_html_e('', 'jobcircle-frame');?></label>
                                    <input type="text" name="username" class="jobcircle-form-field" placeholder="User<?php esc_attr_e('Username', 'jobcircle-frame');?>">
                                </div>
                            </div>
                            <?php
                        }
                        //
                        $saved_cats = wp_get_post_terms($job_id, 'job_category', array('fields' => 'ids'));
                        $job_cat = isset($saved_cats[0]) ? $saved_cats[0] : '';
                        $get_cats = get_terms(array(
                            'taxonomy' => 'job_category',
                            'fields' => 'id=>name',
                            'parent' => 0,
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => false,
                        ));
                        ?>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Industry', 'jobcircle-frame');?></label>
                                <select name="job_cat" class="form-select">
                                    <option value=""><?php esc_html_e('Choose Industry', 'jobcircle-frame');?></option>
                                    <?php
                                    if (!empty($get_cats)) {
                                        foreach ($get_cats as $cat_id => $cat_label) {
                                            ?>
                                            <option value="<?php echo ($cat_id) ?>"<?php echo ($cat_id == $job_cat ? ' selected' : '') ?>><?php echo ($cat_label) ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Job Type', 'jobcircle-frame');?></label>
                                <select name="jobcircle_field_job_type" class="jobcircle-form-field">
                                    <?php
                                    foreach ($job_types_list as $job_type_key => $job_type_ar) {
                                        ?>
                                        <option value="<?php echo ($job_type_key) ?>"<?php echo ($job_type_key == $job_type ? ' selected' : '') ?>><?php echo ($job_type_ar['title']) ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Application Deadline', 'jobcircle-frame');?></label>
                                <input type="text" name="jobcircle_field_job_deadline" class="jobcircle-form-field jobcircle-datepicker-min" value="<?php echo jobcircle_esc_html($application_deadline) ?>" placeholder="<?php esc_attr_e('dd-mm-yyyy', 'jobcircle-frame');?>">
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <div class="jobcircle-form-fieldhldr">
                                        <label class="text-dark ft-medium"><?php esc_html_e('Minimum Salary*', 'jobcircle-frame');?></label>
                                        <input type="text" name="jobcircle_field_min_salary" required class="jobcircle-form-field" value="<?php echo jobcircle_esc_html($min_salary) ?>" placeholder="<?php esc_attr_e('Enter Min salary', 'jobcircle-frame');?>">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <div class="jobcircle-form-fieldhldr">
                                        <label class="text-dark ft-medium"><?php esc_html_e('Maximum Salary*', 'jobcircle-frame');?></label>
                                        <input type="text" name="jobcircle_field_max_salary" required class="jobcircle-form-field" value="<?php echo jobcircle_esc_html($max_salary) ?>" placeholder="<?php esc_attr_e('Enter Max salary', 'jobcircle-frame');?>">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <div class="jobcircle-form-fieldhldr">
                                        <label class="text-dark ft-medium"><?php esc_html_e('Salary Unit', 'jobcircle-frame');?></label>
                                        <select name="jobcircle_field_salary_unit" class="form-select">
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
                        $saved_skills = wp_get_post_terms($job_id, 'job_skill', array('fields' => 'names'));
                        $saved_skills_str = '';
                        if (!empty($saved_skills)) {
                            $saved_skills_str = implode(', ', $saved_skills);
                        }
                        ?>
                        <div class="col-xl-12 col-lg-12">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Skills Required (Comma Separated)', 'jobcircle-frame');?></label>
                                <input type="text" name="job_skills" class="jobcircle-form-field" placeholder="<?php esc_attr_e('Enter Comma Separated Skills e.x PHP, SEO, Marketing', 'jobcircle-frame');?>" value="<?php echo ($saved_skills_str) ?>">
                            </div>
                        </div>

                        <?php echo apply_filters('jobcircle_dash_post_job_fields_extra', '', $job_id) ?>

                        <?php
                        $job_attachments_switch = isset($jobcircle_framework_options['job_attachments']) ? $jobcircle_framework_options['job_attachments'] : '';
                        if ($job_attachments_switch != 'off') { ?>
                            <div class="col-xl-12 col-lg-12">
                                <div class="jobcircle-profile-box-section jobcircle-job-attachs-box">
                                    <div class="jobcircle-profile-title">
                                        <h2><?php esc_html_e('File Attachments', 'jobcircle-frame') ?></h2>
                                    </div>
                                    <?php
                                    $files_types = array(
                                        'image/jpeg',
                                        'image/jpg',
                                        'image/png',
                                        'text/plain',
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                        'application/pdf',
                                    );
                                    ob_start();
                                    ?>
                                    <div class="jobcircle-fileUpload">
                                        <div class="upload-btn-holder">
                                            <span><i class="fa fa-upload"></i> <?php esc_html_e('Upload Files', 'jobcircle-frame') ?></span>
                                            <input id="job_attach_files" name="job_attach_files[]" type="file"
                                                class="upload jobcircle-upload" multiple="multiple" accept="<?php echo implode(',', $files_types) ?>"
                                                onchange="jobcircle_job_attach_files_url(event)"/>
                                        </div>
                                    </div>
                                    <div id="attach-files-holder" class="gallery-imgs-holder jobcircle-company-gallery">
                                        <?php
                                        $all_attach_files = get_post_meta($job_id, 'jobcircle_field_job_attachment_files', true);
                                        if (!empty($all_attach_files)) {
                                            ?>
                                            <ul>
                                                <?php
                                                foreach ($all_attach_files as $_attach_file) {
                                                    $_attach_id = jobcircle_get_attachment_id_from_url($_attach_file);
                                                    $_attach_post = get_post($_attach_id);
                                                    $_attach_mime = isset($_attach_post->post_mime_type) ? $_attach_post->post_mime_type : '';
                                                    $_attach_guide = isset($_attach_post->guid) ? $_attach_post->guid : '';
                                                    $attach_name = basename($_attach_guide);
                                                    $file_icon = 'fa fa-file-text-o';
                                                    if ($_attach_mime == 'image/png' || $_attach_mime == 'image/jpeg') {
                                                        $file_icon = 'fa fa-file-image-o';
                                                    } else if ($_attach_mime == 'application/msword' || $_attach_mime == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                                                        $file_icon = 'fa fa-file-word-o';
                                                    } else if ($_attach_mime == 'application/vnd.ms-excel' || $_attach_mime == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                                                        $file_icon = 'fa fa-file-excel-o';
                                                    } else if ($_attach_mime == 'application/pdf') {
                                                        $file_icon = 'fa fa-file-pdf-o';
                                                    }
                                                    ?>
                                                    <li class="jobcircle-column-3">
                                                        <a href="javascript:void(0);" class="fa fa-remove el-remove"></a>
                                                        <div class="file-container">
                                                            <a href="<?php echo($_attach_file) ?>"
                                                            oncontextmenu="javascript: return false;"
                                                            onclick="javascript: if ((event.button == 0 && event.ctrlKey)) {return false};"
                                                            download="<?php echo($attach_name) ?>"><i class="<?php echo($file_icon) ?>"></i> <?php echo($attach_name) ?>
                                                            </a>
                                                        </div>
                                                        <input type="hidden" name="jobcircle_field_job_attachment_files[]" value="<?php echo($_attach_file) ?>">
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    $uplod_html = ob_get_clean();
                                    echo apply_filters('jobcircle_dash_postjob_attchuplods_html', $uplod_html, $job_id);
                                    ?>
                                </div>
                            </div>
                            <?php
                        }

                        $job_video_switch = isset($jobcircle_framework_options['job_video']) ? $jobcircle_framework_options['job_video'] : '';
                        if ($job_video_switch != 'off') { ?>
                            <div class="col-xl-12 col-lg-12">
                                <div class="jobcircle-profile-box-section jobcircle-job-attachs-box">
                                    <div class="jobcircle-profile-title">
                                        <h2><?php esc_html_e('Video', 'jobcircle-frame') ?></h2>
                                    </div>
                                    <?php
                                    $files_types = array(
                                        'video/mp4', //.mp4
                                        'video/x-m4v', //.m4v
                                        'video/quicktime', //.mov
                                        'video/x-ms-asf, video/x-ms-wmv', //.wmv
                                        'application/x-troff-msvideo, video/avi, video/msvideo, video/x-msvideo', //.avi
                                    );
                                    ob_start();
                                    ?>
                                    <div class="jobcircle-fileUpload job-uploadvideo-con">
                                        <div class="upload-btn-holder">
                                            <span><i class="fa fa-upload"></i> <?php esc_html_e('Upload Video', 'jobcircle-frame') ?></span>
                                            <input id="job_attach_files" name="job_attach_video" type="file"
                                                class="upload jobcircle-upload" accept="<?php echo implode(',', $files_types) ?>"
                                                onchange="jobcircle_job_attach_video_url(event)"/>
                                        </div>
                                    </div>
                                    <div id="attach-video-holder" class="jobcircle-company-video">
                                        <div class="video-uplodr-name"></div>
                                        <?php
                                        $video_attach_file = get_post_meta($job_id, 'jobcircle_field_job_video_url', true);
                                        ?>
                                        <div><small><em><?php esc_html_e('OR add video URL i.e. https://youtube.com/watch?v=4UmWf1gFqMk', 'jobcircle-frame') ?></em></small></div>
                                        <input type="text" name="jobcircle_field_job_video_url" value="<?php echo ($video_attach_file) ?>">
                                        
                                    </div>
                                    <?php
                                    $uplod_html = ob_get_clean();
                                    echo apply_filters('jobcircle_dash_postjob_videouplod_html', $uplod_html, $job_id);
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Country*', 'jobcircle-frame');?></label>
                                <select name="jobcircle_field_loc_country" id="jobcircle-country" class="form-select" required>
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
                                <input type="text" class="jobcircle-form-field" id="jobcircle-address" name="jobcircle_field_loc_address" value="<?php echo jobcircle_esc_html($loc_address) ?>" placeholder="<?php esc_attr_e('H#10 Marke Juger, SBI Road', 'jobcircle-frame');?>" required>
                            </div>
                        </div>
                        <input type="hidden" id="jobcircle-latitude" name="jobcircle_field_loc_latitude" value="<?php echo jobcircle_esc_html($loc_latitude) ?>">
                        <input type="hidden" id="jobcircle-longitude" name="jobcircle_field_loc_longitude" value="<?php echo jobcircle_esc_html($loc_longitude) ?>">
                        

                        <?php
                        if (!$job_upd) {
                            $free_job_post = isset($jobcircle_framework_options['free_job_post']) ? $jobcircle_framework_options['free_job_post'] : '';
                            if ($free_job_post == 'off') {

                                if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

                                    $jobcircle_packages_list   = apply_filters('jobcircle_employer_job_packages', array());
                                    $jobcircle_args = array(
                                        //'post_type' => 'shop_order',
                                        'limit' => -1,
                                        'post_status' => array('wc-completed'),
                                        'order' => 'DESC',
                                        'customer_id' => $user_id,
                                        
                                        'orderby' => 'ID',
                                        'meta_query' => array(
                                            array(
                                                'key' => 'order_attach_with_pkg',
                                                'value' => 'yes',
                                                'compare' => '=',
                                            ),
                                            array(
                                                'key' => 'order_pkg_type',
                                                'value' => array_keys( $jobcircle_packages_list ),
                                                'compare' => 'IN',
                                            ),
                                            array(
                                                'key' => 'order_user_id',
                                                'value' => $user_id,
                                                'compare' => '=',
                                            ),
                                        ),
                                    );
                                    
                                    $jobcircle_query = new WC_Order_Query($jobcircle_args);
                                    $jobcircle_orders = $jobcircle_query->get_orders();
                                    ?>
                                    <div class="col-12 contact-info-fields">
                                        <?php
                                        if (!empty($jobcircle_orders)) {
                                            ?>
                                            <div class="postjob-pakges-main">
                                                <div class="pakges-list-hding"><h2><?php esc_html_e('Choose Package', 'jobcircle-frame') ?></h2></div>
                                                <div class="postjob-pakges-list">
                                                    <?php
                                                    $jobcircle_pkg_countr = 1;
                                                    foreach ($jobcircle_orders as $jobcircle_order) {
                                                        if (is_a($jobcircle_order, 'WC_Order')) {
                                                            $order_id = $jobcircle_order->get_id();
                                                            $order_expired = jobcircle_employer_jobs_pkg_expired($order_id);
                                                            $status_str = esc_html__('Active', 'jobcircle-frame');
                                                            $status_class = 'pkg-active';
                                                            if ($order_expired) {
                                                                $status_str = esc_html__('Expire', 'jobcircle-frame');
                                                                $status_class = 'pkg-expired';
                                                            }
                                                            $job_type   = '';
                                                            $total_credits = 0;
                                                            $trans_order_name = $jobcircle_order->get_meta('order_pkg_name');
                                                            $order_type = $jobcircle_order->get_meta('order_pkg_type');
                                                            if($order_type == 'emp_featured_jobs'){
                                                                $job_type = esc_html__('Featured Job: ', 'jobcircle-frame');
                                                                $total_credits = (int)$jobcircle_order->get_meta('order_numof_featured_jobs');
                                                            } else {
                                                                $job_type = esc_html__('Normal Job: ', 'jobcircle-frame');
                                                                $total_credits = (int)$jobcircle_order->get_meta('order_numof_jobs');
                                                            }
                                                            $remaining_credits = jobcircle_employer_jobs_pkg_remainin_credits($order_id);
                                                            $used_credits = jobcircle_employer_jobs_pkg_used_credits($order_id);
                                                            ?>
                                                            <div class="postjob-pakg-itm">
                                                                <label for="pkg-<?php echo ($order_id) ?>">
                                                                    <input type="radio" id="pkg-<?php echo ($order_id) ?>" name="job_pckg"<?php echo ($jobcircle_pkg_countr == 1 ? ' checked' : '') ?> value="<?php echo ($order_id) ?>">
                                                                    <span><?php echo ($trans_order_name) ?></span>
                                                                    <strong class="all-credits-con">
                                                                        <span><?php printf(wp_kses(__('Total Credits: <span>%s</span>', 'jobcircle-frame'), array('span' => array())), $job_type.''.$total_credits) ?></span>
                                                                        <span><?php printf(wp_kses(__('Used Credits: <span>%s</span>', 'jobcircle-frame'), array('span' => array())), $used_credits) ?></span>
                                                                        <span><?php printf(wp_kses(__('Remaining Credits: <span>%s</span>', 'jobcircle-frame'), array('span' => array())), $remaining_credits) ?></span>
                                                                    </strong>
                                                                    <strong class="pkg-status-con <?php echo ($status_class) ?>">
                                                                        <?php printf(wp_kses(__('Status: <span>%s</span>', 'jobcircle-frame'), array('span' => array())), $status_str) ?>
                                                                    </strong>
                                                                </label>
                                                            </div>
                                                            <?php
                                                            $jobcircle_pkg_countr++;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        } else {                                            
                                            ?>
                                            <div class="postjob-pakges-nofound">
                                                <span><?php esc_html_e('You don\'t have any package. Please buy a package first to post a job.', 'jobcircle-frame') ?></span>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                } else{
                                    ?>
                                    <div class="postjob-pakges-nofound">
                                        <span><?php esc_html_e('You can\'t buy package. Please contact to the administrator.', 'jobcircle-frame') ?></span>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>                        
                        <div class="col-12 contact-info-fields">
                            <div class="jobcircle-form-fieldhldr btn-submit">
                                <input type="hidden" name="action" value="jobcircle_dash_job_post_call">
                                <?php
                                if ($is_emp_job) {
                                    ?>
                                    <input type="hidden" name="job_id" value="<?php echo ($job_id) ?>">
                                    <input type="submit" value="<?php esc_attr_e('Update Job', 'jobcircle-frame');?>">
                                    <?php
                                } else {
                                    ?>
                                    <input type="submit" value="<?php esc_attr_e('Publish Job', 'jobcircle-frame');?>">
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="space-top-footer"></div>
    <?php
}
