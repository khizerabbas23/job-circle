<?php

add_filter('jobcircle_dashboard_candidate_change_password_html', 'jobcircle_dashboard_change_password_html');
add_filter('jobcircle_dashboard_employer_change_password_html', 'jobcircle_dashboard_change_password_html');
add_filter('jobcircle_dashboard_change_password_html', 'jobcircle_dashboard_change_password_html');

function jobcircle_dashboard_change_password_html() {
    ob_start();
    ?>
    <div class="profile-form">
        <div class="heading"><?php esc_html_e('Change Password', 'jobcircle-frame');?></div>

        <form method="post" class="jobcircle-dashb-form account-detail-form">
            <div class="row">
                <div class="col-xl-8 col-lg-9 col-md-12 col-sm-12">
                    <div class="jobcircle-form-fieldhldr jc-mrgns">
                        <label class="jc-lbl text-dark ft-medium"><?php esc_html_e('Old Password', 'jobcircle-frame');?></label>
                        <input type="password" name="old_pass" class="jobcircle-form-field jobcircle-passwordfield" required placeholder="<?php esc_attr_e('Old Password', 'jobcircle-frame');?>">
                        <span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>  
                    </div>
                </div>
                <div class="col-xl-8 col-lg-9 col-md-12 col-sm-12">
                    <div class="jobcircle-form-fieldhldr jc-mrgns">
                        <label class="jc-lbl text-dark ft-medium"><?php esc_html_e('New Password', 'jobcircle-frame');?></label>
                        <input type="password" name="new_pass" class="jobcircle-form-field jobcircle-passwordfield" required placeholder="<?php esc_attr_e('New Password', 'jobcircle-frame');?>">
                        <span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>  
                    </div>
                </div>
                <div class="col-xl-8 col-lg-9 col-md-12 col-sm-12">
                    <div class="jobcircle-form-fieldhldr jc-mrgns">
                        <label class="jc-lbl text-dark ft-medium"><?php esc_html_e('Confirm Password', 'jobcircle-frame');?></label>
                        <input type="password" name="conf_pass" class="jobcircle-form-field jobcircle-passwordfield" required placeholder="<?php esc_attr_e('Confirm Password', 'jobcircle-frame');?>">
                        <span class="jobcirlce-pass-show jobcircle-togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>  
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 contact-info-fields">
                    <div class="jobcircle-form-fieldhldr btn-submit">
                        <input type="hidden" name="action" value="jobcircle_user_dashb_change_pass_call">
                        <input type="submit" value="<?php esc_html_e('Save Changes', 'jobcircle-frame') ?>">
                    </div>
                </div>
            </div>
        </form>

    </div>
    <div class="space-top-footer"></div>
    <?php
    $html = ob_get_clean();
    return $html;
}
