<?php

include(plugin_dir_path(__FILE__) . 'facebook/facebook-apply-job.php');
include(plugin_dir_path(__FILE__) . 'google/google-apply-job.php');
include(plugin_dir_path(__FILE__) . 'linkedin/linkedin-apply-job.php');

function jobcircle_attach_aplieduser_img_by_extrnal_url($image_url) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    global $wp_filesystem;
    $image_data = $wp_filesystem->get_contents($image_url);
    if (!$image_data && function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $image_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $image_data = curl_exec($ch);
        curl_close($ch);
    }

    if ($image_data) {
        $finfo = finfo_open();
        $mime_type = finfo_buffer($finfo, $image_data, FILEINFO_MIME_TYPE);
        finfo_close($finfo);

        if (strpos($mime_type, 'image') !== false) {
            $ext = str_replace('image/', '', $mime_type);
            //$ext = str_replace('jpeg', 'jpg', $mime_type);
        } else {
            $ext = 'jpg';
        }

        $rand_num = rand(1000000, 9999999);

        $file_name = 'user-' . $rand_num . '-img.' . $ext;

        global $jobcircle__upload_files_extpath;
        $jobcircle__upload_files_extpath = 'job-application-files';

        add_filter('upload_dir', 'jobcircle__public_upload_files_path');
        
        $wp_upload_dir = wp_upload_dir();

        $folder_path = $wp_upload_dir['path'];

        $upload_img_path = $folder_path . '/' . $file_name;

        $wp_filesystem->put_contents($upload_img_path, $image_data);

        $orig_file_url = $wp_upload_dir['url'] . '/' . $file_name;

        $image = wp_get_image_editor($upload_img_path);

        if (!is_wp_error($image)) {
            
            $image->resize(150, 150, true);

            $crop_file_name = $folder_path . '/user-' . $rand_num . '-150-img.' . $ext;
            $image->save($crop_file_name);

            $crop_file_url = $wp_upload_dir['url'] . '/user-' . $rand_num . '-150-img.' . $ext;

            $file_urls = array(
                'path' => $folder_path,
                'orig' => $orig_file_url,
                'crop' => $crop_file_url,
            );

            return $file_urls;
        }

        return $file_urls;

        remove_filter('upload_dir', 'jobcircle__public_upload_files_path');
    }
}

function jobcircle_job_applied_with_email($aplicant_email, $job_id) {
    global $wpdb;

    $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
    $post_query .= " LEFT JOIN $wpdb->postmeta AS postmeta ON (posts.ID = postmeta.post_id)";
    $post_query .= " LEFT JOIN $wpdb->postmeta AS mt1 ON (posts.ID = mt1.post_id)";
    $post_query .= " WHERE posts.post_type='job_applic'";
    $post_query .= " AND postmeta.meta_key='applic_user_email' AND postmeta.meta_value='$aplicant_email'";
    $post_query .= " AND mt1.meta_key='applic_job_id' AND mt1.meta_value='$job_id'";
    $get_db_res = $wpdb->get_col($post_query);

    if (isset($get_db_res[0])) {
        return true;
    }
}

add_action('wp_footer', function() {
    if (is_singular(array('jobs')) && isset($_GET['apply_with']) && $_GET['apply_with'] == 'social') {
        if (isset($_COOKIE['jobcircle_social_apply_jobid']) && $_COOKIE['jobcircle_social_apply_jobid'] > 0 && get_post_type($_COOKIE['jobcircle_social_apply_jobid']) == 'jobs') {
            $job_id = get_the_id();
            $coki_job_id = $_COOKIE['jobcircle_social_apply_jobid'];

            if ($coki_job_id == $job_id) {
                ?>
                <div class="modal fade" id="applyjobmsg" tabindex="-1" role="dialog" aria-labelledby="applyjobmsg-modal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p><?php esc_html_e('Applied Successfully', 'jobcircle-frame') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    jQuery(document).ready(function() {
                        jQuery('#applyjobmsg').modal('show');
                    });
                </script>
                <?php
                unset($_COOKIE['jobcircle_social_apply_jobid']);
            }
        }
    }
}, 20);