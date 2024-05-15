<?php

add_filter('jobcircle_dashboard_candidate_resume_manager_html', 'jobcircle_dashboard_candidate_resume_manager_html');

function jobcircle_dashboard_candidate_resume_manager_html() {
    global $current_user;
    $user_id = $current_user->ID;
    
    $page_permissions = jobcircle_check_page_permissions('candidate','resume-manager');    
    if($page_permissions === 0){
        $home_page_url = home_url('/');  
        echo '<script>window.location.href="'.$home_page_url.'"</script>';
        exit;      
    }

    $cand_files_types = array(
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/pdf',
    );

    $candidate_id = jobcircle_user_candidate_id($user_id);
    $uploded_files = get_post_meta($candidate_id, 'candidate_cv_files', true);
    // echo '<pre>';
    // var_dump($uploded_files);
    // echo '</pre>';

    if (!empty($uploded_files)) {
        ?>
        <div class="candidate-allcvs-listcon">
            <?php
            foreach ($uploded_files as $file_key => $file_info) {

                $file_path = isset($file_info['cred']['path']) ? $file_info['cred']['path'] : '';
                $file_url = isset($file_info['cred']['url']) ? $file_info['cred']['url'] : '';
                $file_mimetype = isset($file_info['cred']['mime']['type']) ? $file_info['cred']['mime']['type'] : '';

                //if ($file_path != '' && file_exists($file_path)) {
                    $attach_name = basename($file_path);
                    if ($file_mimetype == 'application/pdf') {
                        $file_icon = 'fa fa-file-pdf-o';
                    } else {
                        $file_icon = 'fa fa-file-word-o';
                    }

                    $upload_time = isset($file_info['time']) ? $file_info['time'] : '';
                    ?>
                    <div class="cvlist-itm">
                        <div class="cvname-icon">
                            <i class="<?php echo ($file_icon) ?>"></i>
                            <span class="cv-label"><?php echo ($attach_name) ?></span>
                        </div>
                        <div class="cvitm-rightcon">
                            <div class="uploadcv-time"><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $upload_time) ?></div>
                            <div class="cvacts-con">
                                <a href="<?php echo apply_filters('jobcircle_candidate_cv_download_url', $candidate_id, $file_key) ?>" download="<?php echo ($attach_name) ?>" title="<?php esc_html_e('Download', 'jobcircle-frame') ?>"><i class="fa fa-download"></i></a>
                                <a href="javascript:;" class="jobcircle-remove-candcvitm" data-key="<?php echo ($file_key) ?>" title="<?php esc_html_e('Remove', 'jobcircle-frame') ?>"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php
                //}
            }
            ?>
        </div>
        <?php
    }
    
    ob_start();
    ?>
    <div class="candidate-uplodfile-maincon">
        <div class="apljob-file-upinfo"><span><?php esc_html_e('Click or drag your file here to upload resume.', 'jobcircle-frame') ?></span></div>
        <div class="apljob-file-upinfo"><span><?php esc_html_e('Suitable file types are .doc, .docx or .pdf', 'jobcircle-frame') ?></span></div>
        <div><i class="fa fa-upload"></i></div>
        <input type="file" name="upload_cv_file" accept="<?php echo implode(',', $cand_files_types) ?>">
    </div>

    <div class="space-top-footer"></div>
    <?php
    $html = ob_get_clean();
    return $html;
}

add_action('wp_ajax_jobcircle_dashboard_uploading_candidate_cv_file', function() {
    global $current_user;
    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $cv_file_cred = jobcircle_upload_candidate_cv('candidate_cv_file', $candidate_id);
        if (isset($cv_file_cred['url'])) {
            $rand_id = rand(10000000, 99999999);
            $uploded_files = get_post_meta($candidate_id, 'candidate_cv_files', true);
            $uploded_files = empty($uploded_files) ? array() : $uploded_files;

            $uploded_files[$rand_id] = array(
                'cred' => $cv_file_cred,
                'time' => current_time('timestamp')
            );

            update_post_meta($candidate_id, 'candidate_cv_files', $uploded_files);

            wp_send_json(array('error' => '0', 'msg' => esc_html__('File uploaded successfully.', 'jobcircle-frame')));
        }
    }

    wp_send_json(array('error' => '1', 'msg' => esc_html__('You cannot upload cv.', 'jobcircle-frame')));
});

add_action('wp_ajax_jobcircle_remove_candidate_saved_cv_item', function() {
    global $current_user;
    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $cvitm_key = $_POST['key'];
        $cv_files = get_post_meta($candidate_id, 'candidate_cv_files', true);
        if (isset($cv_files[$cvitm_key])) {
            
            unset($cv_files[$cvitm_key]);

            update_post_meta($candidate_id, 'candidate_cv_files', $cv_files);

            wp_send_json(array('error' => '0', 'msg' => esc_html__('File deleted successfully.', 'jobcircle-frame')));
        }
    }

    wp_send_json(array('error' => '1', 'msg' => esc_html__('You cannot remove this file.', 'jobcircle-frame')));
});