<?php

defined('ABSPATH') || exit;

class Jobcircle_Job_Applications_Functions {
    
    public function __construct() {
        add_action('wp_footer', array($this, 'apply_job_popup'), 15);
        add_action('wp_head', array($this, 'apply_job_styling'), 15);
        add_action('admin_head', array($this, 'apply_job_meta_styling'), 15);

        add_action('init', array($this, 'register_applications_post_type'), 15);

        add_action('wp_ajax_jobcircle_user_applyjob_action', array($this, 'user_applyjob_ajax'));
        add_action('wp_ajax_nopriv_jobcircle_user_applyjob_action', array($this, 'user_applyjob_ajax'));

        add_action('add_meta_boxes', array($this, 'applicant_meta_boxes'));
    }

    public function apply_job_styling() {
        ?>
        <style>
            #jobcircle-apply-job-popup .login-pop-form {
                max-width: 650px;
            }
            #jobcircle-apply-job-popup .custom-file.avater_uploads {
                display: inline-block;
                height: 120px;
                width: 100%;
                text-align: center;
                margin: 20px 0 0;
            }
            #jobcircle-apply-job-popup .custom-file.avater_uploads > div {
                position: relative;
                min-width: 100px;
            }
            #jobcircle-apply-job-popup .custom-file.avater_uploads input[type="file"] {
                display: none;
            }
            #jobcircle-apply-job-popup .custom-file.avater_uploads label.custom-file-label {
                height: 100px;
                width: 100px;
                border: 2px solid #999;
                border-radius: 5px;
                padding: 10px;
                cursor: pointer;
            }
            #jobcircle-apply-job-popup .custom-file.avater_uploads label.custom-file-label img {
                max-width: 98%;
                max-height: 98%;
            }
            #jobcircle-apply-job-popup .custom-file.avater_uploads label.custom-file-label i {
                font-size: 80px;
                color: #999;
            }
            #jobcircle-apply-job-popup .form-middle-field {
                display: flex;
                justify-content: center;
                width: 100%;
            }
            #jobcircle-apply-job-popup .applyjob-form-cvfield {
                display: inline-block;
                position: relative;
                width: 100%;
                border: 2px dashed #c2c2c2;
                border-radius: 10px;
                padding: 25px;
                margin: 0 0 15px;
            }
            #jobcircle-apply-job-popup .applyjob-form-cvfield input[type="file"] {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                opacity: 0;
                cursor: pointer;
                z-index: 99;
            }
            #jobcircle-apply-job-popup .applyjob-form-cvfield > div {
                display: inline-block;
                width: 100%;
                text-align: center;
            }
            #jobcircle-apply-job-popup .applyjob-form-cvfield > div span {
                color: #333;
                line-height: 28px;
            }
            #jobcircle-apply-job-popup .applyjob-form-cvfield > div > i {
                font-size: 30px !important;
                margin-top: 15px;
            }
        </style>
        <?php
    }

    public function register_applications_post_type() {
        $labels = array(
            'name'                  => _x( 'Job Applications', 'Applications General Name', 'jobcircle-frame' ),
            'singular_name'         => _x( 'Job Application', 'Applications Singular Name', 'jobcircle-frame' ),
            'menu_name'             => __( 'Job Applications', 'jobcircle-frame' ),
            'name_admin_bar'        => __( 'Job Applications', 'jobcircle-frame' ),
            'archives'              => __( 'Item Archives', 'jobcircle-frame' ),
            'attributes'            => __( 'Item Attributes', 'jobcircle-frame' ),
            'parent_item_colon'     => __( 'Parent Item:', 'jobcircle-frame' ),
            'all_items'             => __( 'Job Applications', 'jobcircle-frame' ),
            'add_new_item'          => __( 'Add New Item', 'jobcircle-frame' ),
            'add_new'               => __( 'Add New', 'jobcircle-frame' ),
            'new_item'              => __( 'New Item', 'jobcircle-frame' ),
            'edit_item'             => __( 'Job Applicant', 'jobcircle-frame' ),
            'update_item'           => __( 'Job Applicant', 'jobcircle-frame' ),
            'view_item'             => __( 'View Item', 'jobcircle-frame' ),
            'view_items'            => __( 'View Items', 'jobcircle-frame' ),
            'search_items'          => __( 'Search Item', 'jobcircle-frame' ),
            'not_found'             => __( 'Not found', 'jobcircle-frame' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'jobcircle-frame' ),
            'featured_image'        => __( 'Featured Image', 'jobcircle-frame' ),
            'set_featured_image'    => __( 'Set featured image', 'jobcircle-frame' ),
            'remove_featured_image' => __( 'Remove featured image', 'jobcircle-frame' ),
            'use_featured_image'    => __( 'Use as featured image', 'jobcircle-frame' ),
            'insert_into_item'      => __( 'Insert into item', 'jobcircle-frame' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'jobcircle-frame' ),
            'items_list'            => __( 'Items list', 'jobcircle-frame' ),
            'items_list_navigation' => __( 'Items list navigation', 'jobcircle-frame' ),
            'filter_items_list'     => __( 'Sectors items list', 'jobcircle-frame' ),
        );
        $args = array(
            'label'                 => __( 'Job Applications', 'jobcircle-frame' ),
            'description'           => __( 'Applications Description', 'jobcircle-frame' ),
            'labels'                => $labels,
            'supports'              => array( 'title' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => 'edit.php?post_type=jobs',
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type' => 'post',
            'capabilities' => array(
                'create_posts' => false, 
            ),
            'map_meta_cap' => true, 
        );
        register_post_type( 'job_applic', $args );
    }

    public function applicant_meta_boxes() {
        add_meta_box('jobcircle-applicant-data', esc_html__('Applicant Data', 'jobcircle-frame'), array($this, 'applicant_meta_data'), 'job_applic', 'normal', 'high');
    }

    public function applicant_meta_data() {
        global $post;

        $application_id = $post->ID;
        $applic_post = get_post($application_id);
        ?>
        <div class="aplic-metadata-con">
            <?php
            $job_id = get_post_meta($application_id, 'applic_job_id', true);
            $job_title = get_post_meta($application_id, 'applic_job_title', true);
            $user_email = get_post_meta($application_id, 'applic_user_email', true);
            $social_platform = get_post_meta($application_id, 'apply_with_social', true);
            $pic_data = get_post_meta($application_id, 'applic_user_pic_urls', true);

            $job_post_title = 'No Title';
            if (get_post_type($job_id)) {
                $job_post_title = get_the_title($job_id);
            }

            if ($job_title == '') {
                $job_title = 'N/A';
            }

            $user_notes = 'N/A';
            if (isset($applic_post->post_content) && $applic_post->post_content != '') {
                $user_notes = $applic_post->post_content;
            }

            if (isset($pic_data['crop']) && $pic_data['crop'] != '') {
                ?>
                <div class="appic-img-holder">
                    <img src="<?php echo ($pic_data['crop']) ?>" alt="">
                </div>
                <?php
            }
            ?>
            <div class="appic-data-item">
                <strong><?php esc_html_e('Job Applied', 'jobcircle-frame') ?>:</strong> <span><a href="<?php echo admin_url('post.php?post=' . $job_id . '&action=edit') ?>"><?php echo ($job_post_title) ?></a></span>
            </div>
            <div class="appic-data-item">
                <strong><?php esc_html_e('User Job title', 'jobcircle-frame') ?>:</strong> <span><?php echo ($job_title) ?></span>
            </div>
            <div class="appic-data-item">
                <strong><?php esc_html_e('Email Address', 'jobcircle-frame') ?>:</strong> <span><a href="mailto:<?php echo ($user_email) ?>"><?php echo ($user_email) ?></a></span>
            </div>
            <div class="appic-data-item">
                <strong><?php esc_html_e('User Notes', 'jobcircle-frame') ?>:</strong> <span><?php echo ($user_notes) ?></span>
            </div>
        </div>
        <?php
    }

    public function apply_job_meta_styling() {
        ?>
        <style>
            .post-type-job_applic #submitdiv {
                display: none;
            }
            .aplic-metadata-con {
                display: inline-block;
                max-width: 500px;
            }
            .aplic-metadata-con .appic-data-item {
                display: inline-block;
                width: 100%;
                margin-bottom: 20px;
                padding: 20px;
                border-bottom: 1px solid #dfdfdf;
            }
            .aplic-metadata-con .appic-data-item strong {
                display: inline-block;
                width: 200px;
            }
            .aplic-metadata-con .appic-img-holder {
                display: flex;
                width: 100%;
                padding: 0 20px;
                margin-bottom: 20px;
            }
        </style>
        <?php
    }

    public function apply_job_popup() {
        global $current_user;
        global $post;

        $application_id = $post->ID;
        $post_title = get_the_title($application_id);

        $user_id = $current_user->ID;

        $user_name = '';
        $user_email = '';
        $job_title = '';

        $candidate_id = jobcircle_user_candidate_id($user_id);
        if (is_user_logged_in() && $candidate_id) {
            $user_obj = get_user_by('id', $user_id);
            $user_name = get_the_title($candidate_id);
            $user_email = isset($user_obj->user_email) ? $user_obj->user_email : '';
            $job_title = get_post_meta($candidate_id, 'jobcircle_field_job_title', true);
        }
        ?>
        <div class="modal fade" id="jobcircle-apply-job-popup" tabindex="-1" role="dialog" aria-labelledby="apply-job-modal" aria-hidden="true">
            <div class="modal-dialog login-pop-form" role="document">
                <div class="modal-content">
                    <div class="modal-headers">
                        <a href="javascript:;" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></a>
                    </div>
                
                    <div class="modal-body p-5 popup-loginsec-con">
                        <div class="text-center mb-4">
                            <h4 class="m-0 ft-regular"><?php esc_html_e('Apply Job', 'jobcircle-frame');?></h4>
                        </div>
                        
                        <form method="post" class="jobcircle-user-form loding-onall-con">
                            <div id="logofile-name-container" class="custom-file avater_uploads">
                                <div>
                                    <input id="applypic-custom-input" type="file" name="job_apply_pic" onchange="jobcircle_form_image_file_change(event)" accept="image/png, image/jpg, image/jpeg" class="custom-file-input">
                                    <label class="custom-file-label logo-img-con" for="applypic-custom-input">
                                        <img class="logo-img-con" src="" alt="" style="display: none;">
                                        <i class="fa fa-user"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="form-fields-group">
                                <div class="form-group">
                                    <label><?php esc_html_e('Name', 'jobcircle-frame');?></label>
                                    <input type="text" name="user_name" class="form-control" value="<?php echo ($user_name) ?>" placeholder="<?php esc_attr_e('John Doe', 'jobcircle-frame');?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?php esc_html_e('Email Address', 'jobcircle-frame');?></label>
                                    <input type="email" name="user_email" class="form-control" value="<?php echo ($user_email) ?>" placeholder="<?php esc_attr_e('example@abc.com', 'jobcircle-frame');?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e('Job Title', 'jobcircle-frame');?></label>
                                <input type="text" name="job_title" class="form-control" value="<?php echo ($post_title) ?>" placeholder="<?php esc_attr_e('Graphic Designer', 'jobcircle-frame');?>" required>
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e('Note', 'jobcircle-frame');?></label>
                                <textarea name="aplic_notes" class="form-control" placeholder="<?php esc_attr_e('Type any message here', 'jobcircle-frame');?>"></textarea>
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e('Upload Resume', 'jobcircle-frame');?></label>
                                <div class="form-middle-field">
                                    <div class="applyjob-form-cvfield">
                                        <input type="file" name="apply_job_resume" accept="image/png, image/jpg, image/jpeg, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf">
                                        <div class="apljob-file-namecon" style="display: none;"><span></span></div>
                                        <div class="apljob-file-upinfo"><span><?php esc_html_e('Click or drag your file here to upload resume.', 'jobcircle-frame');?></span></div>
                                        <div class="apljob-file-upinfo"><span><?php esc_html_e('Suitable file types are .docx, .pdf, .jpg or .png', 'jobcircle-frame');?></span></div>
                                        <div><i class="lni lni-upload me-1"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-security-fields" style="display: none;"></div>
                                <input type="hidden" name="action" value="jobcircle_user_applyjob_action">
                                <button type="submit" class="jobcircle-formsubmit-btn"><?php esc_html_e('Submit to Apply', 'jobcircle-frame');?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            jQuery('#jobcircle-apply-job-popup input[name="apply_job_resume"]').on('change', function() {
                var this_file = jQuery(this);
                var parnt_con = this_file.parents('.applyjob-form-cvfield');
                parnt_con.find('.apljob-file-namecon').html(this_file.val().split('\\').pop()).removeAttr('style');
                parnt_con.find('.apljob-file-upinfo').hide();
            });
        </script>
        <?php
    }

    public function user_applyjob_ajax() {

        global $wpdb;

        $job_id = $_POST['apply_job_id'];
        $aplicant_name = $_POST['user_name'];
        $aplicant_email = $_POST['user_email'];
        $aplicant_job_title = $_POST['job_title'];
        $aplicant_notes = $_POST['aplic_notes'];

        $aplicant_name = jobcircle_esc_html($aplicant_name);
        $aplicant_email = jobcircle_esc_html($aplicant_email);
        $aplicant_job_title = jobcircle_esc_html($aplicant_job_title);
        $aplicant_notes = jobcircle_esc_wp_editor($aplicant_notes);

        if ($aplicant_name == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill your name field.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }
        if ($aplicant_email == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Email field cannot be blank.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
        $post_query .= " LEFT JOIN $wpdb->postmeta AS postmeta ON (posts.ID = postmeta.post_id)";
        $post_query .= " LEFT JOIN $wpdb->postmeta AS mt1 ON (posts.ID = mt1.post_id)";
        $post_query .= " WHERE posts.post_type='job_applic'";
        $post_query .= " AND postmeta.meta_key='applic_user_email' AND postmeta.meta_value='$aplicant_email'";
        $post_query .= " AND mt1.meta_key='applic_job_id' AND mt1.meta_value='$job_id'";
        $get_db_res = $wpdb->get_col($post_query);
        
        if (isset($get_db_res[0])) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('You have already applied this job.', 'jobcircle-frame'));
            wp_send_json($ret_data);
        }

        $my_post = array(
            'post_title' => $aplicant_name,
            'post_content' => $aplicant_notes,
            'post_type' => 'job_applic',
            'post_status' => 'publish',
        );
        if (is_user_logged_in()) {
            global $current_user;
            $user_id = $current_user->ID;
            $my_post['post_author'] = $user_id;
        }
        $application_id = wp_insert_post($my_post);

        update_post_meta($application_id, 'applic_job_id', $job_id);
        update_post_meta($application_id, 'applic_job_title', $aplicant_job_title);
        update_post_meta($application_id, 'applic_user_email', $aplicant_email);

        //
        $img_urls = self::candupload_img_attach('job_apply_pic');
        update_post_meta($application_id, 'applic_user_pic_urls', $img_urls);

        if (isset($user_id)) {
            //
            $candidate_id = jobcircle_user_candidate_id($user_id);
            if ($candidate_id) {
                update_post_meta($application_id, 'user_cand_id', $candidate_id);
            }
        }
        
        $ret_data = array('error' => '0', 'redirect' => 'same', 'msg' => esc_html__('Job applied successfully.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    public static function candupload_img_attach($fieldname = 'file') {

        if (isset($_FILES[$fieldname]) && $_FILES[$fieldname] != '') {
    
            $upload_file = $_FILES[$fieldname];

            global $jobcircle__upload_files_extpath;
            $jobcircle__upload_files_extpath = 'job-application-files';
    
            add_filter('upload_dir', 'jobcircle__public_upload_files_path');
            
            $wp_upload_dir = wp_upload_dir();

            $rand_num = rand(1000000, 9999999);

            $file_name = $upload_file['name'];
            $file_mext_all = explode('.', $file_name);
            $file_ext = end($file_mext_all);

            $upload_file['name'] = 'user-' . $rand_num . '-' . sanitize_title($file_name);
    
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
    
            $allowed_image_types = array(
                'jpg|jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            );
    
            $status_upload = wp_handle_upload($upload_file, array('test_form' => false, 'mimes' => $allowed_image_types));
    
            if (empty($status_upload['error'])) {
    
                $file_url = isset($status_upload['url']) ? $status_upload['url'] : '';

                $upload_file_path = $wp_upload_dir['path'] . '/' . basename($file_url);
    
                $folder_path = $wp_upload_dir['path'];
    
                $image = wp_get_image_editor($upload_file_path);
    
                if (!is_wp_error($image)) {
                    
                    $image->resize(150, 150, true);

                    $crop_file_name = $folder_path . '/user-' . $rand_num . '-150-' . sanitize_title($file_name);
                    $image->save($crop_file_name);

                    $crop_file_url = $wp_upload_dir['url'] . '/user-' . $rand_num . '-150-' . sanitize_title($file_name);

                    $file_urls = array(
                        'path' => $folder_path,
                        'orig' => $file_url,
                        'crop' => $crop_file_url,
                    );
    
                    return $file_urls;
                }
            }
    
            remove_filter('upload_dir', 'jobcircle__public_upload_files_path');
        }
    
        return false;
    }

}
new Jobcircle_Job_Applications_Functions;