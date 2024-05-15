<?php
function jobcircle_employer_team_members_frontend($atts, $content)
{
    ob_start();
    if (isset($_SESSION['jobcircle_employer_team_member_id'])) {
        return '';
    }
    ?>
    <h2 class="heading">
        <?php echo esc_html__('Team Members', 'jobcircle-frame'); ?>
    </h2>
    <div class="add-new-team-member-button">
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addTeamMember">
            <?php echo esc_html__('Add New Team Member', 'jobcircle-frame'); ?>
        </button>
    </div>

    <div class="modal add-team-member jobcircle-userlogin-popup fade" id="addTeamMember" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog login-pop-form" role="document">
            <div class="modal-content" id="loginmodal">
                <div class="modal-headers">
                    <a href="javascript:;" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa fa-times"></i></a>
                </div>
                <div class="modal-body p-5 popup-signupsec-con" style="">
                    <div class="text-center mb-4">
                        <h4 class="m-0 ft-regular">
                            <?php echo esc_html__('Add New Team Member', 'jobcircle-frame'); ?>
                        </h4>
                    </div>
                    <?php global $jobcircle_framework_options;
                    $employer_post_new_job = 'enabled';
                    $employer_manage_jobs = 'enabled';
                    $employer_manage_applicants = 'enabled';
                    $employer_bookmark_resumes = 'enabled';
                    $employer_packages = 'enabled';

                    if (isset($jobcircle_framework_options['employer_profile_package']) && ($jobcircle_framework_options['employer_profile_package'] == "on")) {

                        $current_login_user_id = get_current_user_id();
                        $user_employer_id = jobcircle_user_employer_id($current_login_user_id);
                        $employer_post_new_job = 'disabled';
                        $employer_manage_jobs = 'disabled';
                        $employer_manage_applicants = 'disabled';
                        $employer_bookmark_resumes = 'disabled';
                        $employer_packages = 'disabled';

                        if (($user_employer_id) && ($user_employer_id > 0)) {
                            $employer_purchased_packages = get_post_meta($user_employer_id, 'employer_purchased_packages', true);

                            if ($employer_purchased_packages) {
                                $explode_emp_purchased_packages = explode(",", $employer_purchased_packages);
                                if ($explode_emp_purchased_packages) {
                                    foreach ($explode_emp_purchased_packages as $emp_purchased_package) {
                                        $purchased_package_id = $emp_purchased_package;

                                        $emp_post_new_job = get_post_meta($purchased_package_id, 'order_emp_post_new_job', true);
                                        $emp_manage_jobs = get_post_meta($purchased_package_id, 'order_emp_manage_jobs', true);
                                        $emp_manage_applicants = get_post_meta($purchased_package_id, 'order_emp_manage_applicants', true);
                                        $emp_bookmark_resumes = get_post_meta($purchased_package_id, 'order_emp_bookmark_resumes', true);
                                        $emp_packages = get_post_meta($purchased_package_id, 'order_emp_packages', true);

                                        if (($emp_post_new_job === 1) || ($emp_post_new_job == "on")) {
                                            $employer_post_new_job = 'enabled';
                                        }
                                        if (($emp_manage_jobs === 1) || ($emp_manage_jobs == "on")) {
                                            $employer_manage_jobs = 'enabled';
                                        }
                                        if (($emp_manage_applicants === 1) || ($emp_manage_applicants == "on")) {
                                            $employer_manage_applicants = 'enabled';
                                        }
                                        if (($emp_bookmark_resumes === 1) || ($emp_bookmark_resumes == "on")) {
                                            $employer_bookmark_resumes = 'enabled';
                                        }
                                        if (($emp_packages === 1) || ($emp_packages == "on")) {
                                            $employer_packages = 'enabled';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    <form method="post" class="jobcircle-user-form">
                        <div class="form-fields-group">
                            <div class="form-group">
                                <label>
                                    <?php echo esc_html__('First Name', 'jobcircle-frame'); ?>
                                </label>
                                <input type="text" name="first_name" class="form-control" placeholder="<?php esc_html_e('First Name', 'jobcircle-frame') ?>*"
                                    required="">
                            </div>
                            <div class="form-group">
                                <label>
                                    <?php echo esc_html__('Last Name', 'jobcircle-frame'); ?>
                                </label>
                                <input type="text" name="last_name" class="form-control" placeholder="<?php esc_html_e('Last Name', 'jobcircle-frame') ?>*"
                                    required="">
                            </div>
                        </div>
                        <div class="form-fields-group">
                            <div class="form-group">
                                <label>
                                    <?php echo esc_html__('Username', 'jobcircle-frame'); ?>
                                </label>
                                <input type="text" name="username" class="form-control" placeholder="<?php esc_html_e('Username', 'jobcircle-frame') ?>*" required="">
                            </div>
                            <div class="form-group">
                                <label>
                                    <?php echo esc_html__('Email', 'jobcircle-frame'); ?>
                                </label>
                                <input type="email" name="user_email" class="form-control" placeholder="<?php esc_html_e('Email', 'jobcircle-frame') ?>*" required="">
                            </div>
                        </div>
                        <div class="form-fields-group">
                            <div class="form-group">
                                <label>
                                    <?php echo esc_html__('Password', 'jobcircle-frame'); ?>
                                </label>
                                <input type="password" name="user_pass" class="form-control jobcircle-passwordfield" placeholder="<?php esc_html_e('Password', 'jobcircle-frame') ?>*"
                                    required="">
                                    <span class="jobcirlce-pass-show jobcircle-togglePassword jc-brng"><i class="fa fa-eye" aria-hidden="true"></i></span>  
                            </div>
                            <div class="form-group">
                                <label>
                                    <?php echo esc_html__('Confirm Password', 'jobcircle-frame'); ?>
                                </label>
                                <input type="password" name="confirm_pass" class="form-control jobcircle-passwordfield"
                                    placeholder="<?php esc_html_e('Confirm Password', 'jobcircle-frame') ?>*" required="">
                                    <span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <?php echo esc_html__('Team Member have access of: ', 'jobcircle-frame'); ?>
                            </label>
                        </div>
                        <div class="form-fields-group">
                            <div class="form-group form-check form-check-inline">
                                <?php if ($employer_post_new_job == "enabled"): ?>
                                    <input class="form-check-input" type="checkbox" name="member_access[]" value="post_new_job">
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Post New Job', 'jobcircle-frame'); ?>
                                    </label>
                                <?php else: ?>
                                    <span class="form-check-input fa fa-lock"></span>
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Post New Job', 'jobcircle-frame'); ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                            <div class="form-group form-check form-check-inline second-opt">
                                <?php if (trim($employer_manage_jobs) == "enabled"): ?>
                                    <input class="form-check-input" type="checkbox" name="member_access[]" value="manage_jobs">
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Manage Jobs', 'jobcircle-frame'); ?>
                                    </label>
                                <?php else: ?>
                                    <span class="form-check-input fa fa-lock"></span>
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Manage Jobs', 'jobcircle-frame'); ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-fields-group">
                            <div class="form-group form-check form-check-inline">
                                <?php if (trim($employer_manage_applicants) == "enabled"): ?>
                                    <input class="form-check-input" type="checkbox" name="member_access[]"
                                        value="manage_applicants">
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Manage Applicants', 'jobcircle-frame'); ?>
                                    </label>
                                <?php else: ?>
                                    <span class="form-check-input fa fa-lock"></span>
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Manage Applicants', 'jobcircle-frame'); ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                            <div class="form-group form-check form-check-inline second-opt-2">
                                <?php if (trim($employer_bookmark_resumes) == "enabled"): ?>
                                    <input class="form-check-input" type="checkbox" name="member_access[]"
                                        value="bookmark_resumes">
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Bookmark Resumes', 'jobcircle-frame'); ?>
                                    </label>
                                <?php else: ?>
                                    <span class="form-check-input fa fa-lock"></span>
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Bookmark Resumes', 'jobcircle-frame'); ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-fields-group">
                            <div class="form-group form-check form-check-inline">
                                <?php if (trim($employer_packages) == "enabled"): ?>
                                    <input class="form-check-input" type="checkbox" name="member_access[]" value="packages">
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Packages', 'jobcircle-frame'); ?>
                                    </label>
                                <?php else: ?>
                                    <span class="form-check-input fa fa-lock"></span>
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Packages', 'jobcircle-frame'); ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="form-security-fields" style="display: none;">
                                <input type="hidden" id="_nonce" name="_nonce"
                                    value="<?php echo wp_create_nonce('save_new_teammember'); ?>">
                                <input type="hidden" name="_wp_http_referer" value="/wp-admin/admin-ajax.php">
                            </div>
                            <input type="hidden" name="action" value="jobcircle_add_new_team_member">

                            <button type="submit" class="jobcircle-formsubmit-btn">
                                <?php echo esc_html__('Add Member', 'jobcircle-frame'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal add-team-member jobcircle-userlogin-popup fade" id="updateTeamMember" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog login-pop-form" role="document">
            <div class="modal-content" id="loginmodal">
                <div class="modal-headers">
                    <a href="javascript:;" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa fa-times"></i></a>
                </div>
                <div class="modal-body p-5 popup-signupsec-con" style="">
                    <div class="text-center mb-4">
                        <h4 class="m-0 ft-regular">
                            <?php echo esc_html__('Update Team Member', 'jobcircle-frame'); ?>
                        </h4>
                    </div>                    
                    <?php global $jobcircle_framework_options;
                    $employer_post_new_job = 'enabled';
                    $employer_manage_jobs = 'enabled';
                    $employer_manage_applicants = 'enabled';
                    $employer_bookmark_resumes = 'enabled';
                    $employer_packages = 'enabled';

                    if (isset($jobcircle_framework_options['employer_profile_package']) && ($jobcircle_framework_options['employer_profile_package'] == "on")) {

                        $current_login_user_id = get_current_user_id();
                        $user_employer_id = jobcircle_user_employer_id($current_login_user_id);
                        $employer_post_new_job = 'disabled';
                        $employer_manage_jobs = 'disabled';
                        $employer_manage_applicants = 'disabled';
                        $employer_bookmark_resumes = 'disabled';
                        $employer_packages = 'disabled';

                        if (($user_employer_id) && ($user_employer_id > 0)) {
                            $employer_purchased_packages = get_post_meta($user_employer_id, 'employer_purchased_packages', true);

                            if ($employer_purchased_packages) {
                                $explode_emp_purchased_packages = explode(",", $employer_purchased_packages);
                                if ($explode_emp_purchased_packages) {
                                    foreach ($explode_emp_purchased_packages as $emp_purchased_package) {
                                        $purchased_package_id = $emp_purchased_package;

                                        $emp_post_new_job = get_post_meta($purchased_package_id, 'order_emp_post_new_job', true);
                                        $emp_manage_jobs = get_post_meta($purchased_package_id, 'order_emp_manage_jobs', true);
                                        $emp_manage_applicants = get_post_meta($purchased_package_id, 'order_emp_manage_applicants', true);
                                        $emp_bookmark_resumes = get_post_meta($purchased_package_id, 'order_emp_bookmark_resumes', true);
                                        $emp_packages = get_post_meta($purchased_package_id, 'order_emp_packages', true);

                                        if (($emp_post_new_job === 1) || ($emp_post_new_job == "on")) {
                                            $employer_post_new_job = 'enabled';
                                        }
                                        if (($emp_manage_jobs === 1) || ($emp_manage_jobs == "on")) {
                                            $employer_manage_jobs = 'enabled';
                                        }
                                        if (($emp_manage_applicants === 1) || ($emp_manage_applicants == "on")) {
                                            $employer_manage_applicants = 'enabled';
                                        }
                                        if (($emp_bookmark_resumes === 1) || ($emp_bookmark_resumes == "on")) {
                                            $employer_bookmark_resumes = 'enabled';
                                        }
                                        if (($emp_packages === 1) || ($emp_packages == "on")) {
                                            $employer_packages = 'enabled';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    <form method="post" class="jobcircle-user-form">
                        <div class="form-fields-group">
                            <div class="form-group">
                                <label>
                                    <?php echo esc_html__('First Name', 'jobcircle-frame'); ?>
                                </label>
                                <input type="text" name="first_name" class="form-control" placeholder="<?php esc_html_e('First Name', 'jobcircle-frame') ?>*"
                                    required="">
                            </div>
                            <div class="form-group">
                                <label>
                                    <?php echo esc_html__('Last Name', 'jobcircle-frame'); ?>
                                </label>
                                <input type="text" name="last_name" class="form-control" placeholder="<?php esc_html_e('Last Name', 'jobcircle-frame') ?>*"
                                    required="">
                            </div>
                        </div>
                        <div class="form-fields-group">
                            <div class="form-group">
                                <label>
                                    <?php echo esc_html__('Username', 'jobcircle-frame'); ?>
                                </label>
                                <input type="text" name="username" class="form-control" placeholder="<?php esc_html_e('Username', 'jobcircle-frame') ?>*" required=""
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label>
                                    <?php echo esc_html__('Email', 'jobcircle-frame'); ?>
                                </label>
                                <input type="email" name="user_email" class="form-control" placeholder="<?php esc_html_e('Email', 'jobcircle-frame') ?>*" required=""
                                    disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <?php echo esc_html__('Team Member have access of: ', 'jobcircle-frame'); ?>
                            </label>
                        </div>
                        <div class="form-fields-group">
                            <div class="form-group form-check form-check-inline">
                                <?php if ($employer_post_new_job == "enabled"): ?>
                                    <input class="form-check-input" type="checkbox" name="member_access[]" value="post_new_job">
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Post New Job', 'jobcircle-frame'); ?>
                                    </label>
                                <?php else: ?>
                                    <span class="form-check-input fa fa-lock"></span>
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Post New Job', 'jobcircle-frame'); ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                            <div class="form-group form-check form-check-inline second-opt">
                                <?php if (trim($employer_manage_jobs) == "enabled"): ?>
                                    <input class="form-check-input" type="checkbox" name="member_access[]" value="manage_jobs">
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Manage Jobs', 'jobcircle-frame'); ?>
                                    </label>
                                <?php else: ?>
                                    <span class="form-check-input fa fa-lock"></span>
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Manage Jobs', 'jobcircle-frame'); ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-fields-group">
                            <div class="form-group form-check form-check-inline jobcircle-team-user-access">
                                <?php if (trim($employer_manage_applicants) == "enabled"): ?>
                                    <input class="form-check-input" type="checkbox" name="member_access[]"
                                        value="manage_applicants">
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Manage Applicants', 'jobcircle-frame'); ?>
                                    </label>
                                <?php else: ?>
                                    <span class="form-check-input fa fa-lock"></span>
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Manage Applicants', 'jobcircle-frame'); ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                            <div class="form-group form-check form-check-inline second-opt-2">
                                <?php if (trim($employer_bookmark_resumes) == "enabled"): ?>
                                    <input class="form-check-input" type="checkbox" name="member_access[]"
                                        value="bookmark_resumes">
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Bookmark Resumes', 'jobcircle-frame'); ?>
                                    </label>
                                <?php else: ?>
                                    <span class="form-check-input fa fa-lock"></span>
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Bookmark Resumes', 'jobcircle-frame'); ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-fields-group">
                            <div class="form-group form-check form-check-inline">
                                <?php if (trim($employer_packages) == "enabled"): ?>
                                    <input class="form-check-input" type="checkbox" name="member_access[]" value="packages">
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Packages', 'jobcircle-frame'); ?>
                                    </label>
                                <?php else: ?>
                                    <span class="form-check-input fa fa-lock"></span>
                                    <label class="form-check-label">
                                        <?php echo esc_html__('Packages', 'jobcircle-frame'); ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="form-security-fields" style="display: none;">
                                <input type="hidden" id="_nonce" name="_nonce"
                                    value="<?php echo wp_create_nonce('update_teammember'); ?>">
                                <input type="hidden" name="_wp_http_referer" value="/wp-admin/admin-ajax.php">
                            </div>
                            <input type="hidden" name="hdn_member_id" value="">
                            <input type="hidden" name="action" value="jobcircle_update_team_member">
                            <button type="submit" class="jobcircle-formsubmit-btn">
                                <?php echo esc_html__('Update Member', 'jobcircle-frame'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $current_login_user_id = get_current_user_id();
    $user_employer_id = jobcircle_user_employer_id($current_login_user_id);
    $args = array(
        'meta_query' => array(
            array(
                'key' => 'team_member_parent_emp_id',
                'value' => $user_employer_id,
                'compare' => '=',
            ),
        )
    );
    $team_members = get_users($args);
    ?>
    <?php if ($team_members): ?>
        <div class="package-table table-block">
            <div class="team-member-server-error"></div>
            <div class="table-wrapper">
                <table>
                    <tr>
                        <th>
                            <?php echo esc_html__('Member User Name', 'jobcircle-frame'); ?>
                        </th>
                        <th>
                            <?php echo esc_html__('Member Email Address', 'jobcircle-frame'); ?>
                        </th>
                        <th>
                            <?php echo esc_html__('Member Access Points', 'jobcircle-frame'); ?>
                        </th>
                        <th>
                            <?php echo esc_html__('Action', 'jobcircle-frame'); ?>
                        </th>
                    </tr>
                    <?php foreach ($team_members as $member): ?>
                        <tr class="team-member-<?php echo intval($member->ID); ?>">
                            <td>
                                <?php echo jobcircle_esc_the_html($member->display_name); ?>
                            </td>
                            <td>
                                <?php echo jobcircle_esc_the_html($member->user_email); ?>
                            </td>
                            <td>
                                <?php $access_points = get_user_meta($member->ID, 'team_member_access', true);
                                if ($access_points) {
                                    $access_points_explode = explode(",", $access_points);
                                    if ($access_points_explode) {
                                        echo '<ul class="user-access-points">';
                                        foreach ($access_points_explode as $access_point) {

                                            $access_point_value = $access_point;

                                            if ($access_point === "post_new_job") {
                                                $access_point_value = 'Post New Job';

                                            } elseif ($access_point === "manage_jobs") {
                                                $access_point_value = 'Manage Jobs';

                                            } elseif ($access_point === "manage_applicants") {
                                                $access_point_value = 'Manage Applicants';

                                            } elseif ($access_point === "bookmark_resumes") {
                                                $access_point_value = 'Bookmark Resumes';

                                            } elseif ($access_point === "packages") {
                                                $access_point_value = 'Packages';
                                            }

                                            echo '<li>' . $access_point_value . '</li>';
                                        }
                                        echo '</ul>';
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <div class="actions-icons">
                                    <?php
                                    if (!empty($member)) {
                                        ?>
                                        <span class="icon-middle-span edit-member jobcircle-edit-member" data-id="<?php echo intval($member->ID) ?>"><img
                                                src="<?php echo Jobcircle_Plugin::root_url(); ?>/images/edit-icon.png" alt=""></span>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($member)) {
                                        ?>
                                        <div class="icon-holder delete-member jobcircle-delete-member" data-id="<?php echo intval($member->ID) ?>"><img
                                                src="<?php echo Jobcircle_Plugin::root_url(); ?>/images/delete-basket-icon.png" />
                                            <?php
                                    }
                                    ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    <?php endif; ?>
    <?php
    return ob_get_clean();
}
add_shortcode('job_circle_employer_team_members', 'jobcircle_employer_team_members_frontend');