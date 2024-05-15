<?php

add_filter('jobcircle_dashboard_candidate_my_resume_html', 'jobcircle_dashboard_candidate_my_resume_html');

function jobcircle_dashboard_candidate_my_resume_html() {
    global $current_user;
    
    $page_permissions = jobcircle_check_page_permissions('candidate','my-resume');    
    if($page_permissions === 0){
        $home_page_url = home_url('/');  
        echo '<script>window.location.href="'.$home_page_url.'"</script>';
        exit;      
    }

    wp_enqueue_script('jquery-ui-sortable');

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);

    $all_itms = get_post_meta($candidate_id, 'education_record_list', true);
    
    ob_start();
    ?>
    
    <div class="profile-form">

        <div class="jobcircle-dashb-multilist jobcircle-dashbcand-edulist">
            <?php
            if (!empty($all_itms)) {
                foreach ($all_itms as $itm_id => $itm_record) {
                    echo jobcircle_dashresm_add_eduitm_html($itm_record, $itm_id);
                }
            }
            ?>
        </div>
        <div class="heading"><?php esc_html_e('Education Details', 'jobcircle-frame') ?></div>
        <form method="post" class="jobcircle-dashb-form candidate-addedu-form account-detail-form">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="jobcircle-form-fieldhldr">
                        <label class="text-dark ft-medium"><?php esc_html_e('Institute Name', 'jobcircle-frame') ?></label>
                        <input type="text" name="schoolname" class="jobcircle-form-field" required placeholder="Institute Name">
                    </div>
                    <div class="jobcircle-form-fieldhldr">
                        <label class="text-dark ft-medium"><?php esc_html_e('Qualification', 'jobcircle-frame') ?></label>
                        <input type="text" name="qualification" class="jobcircle-form-field" required placeholder="Qualification Title">
                    </div>
                    <div class="form-row row">
                        <div class="col-6">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Start Date', 'jobcircle-frame') ?></label>
                                <input type="text" name="startdate" class="jobcircle-form-field jobcircle-datepicker" required placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('End Date', 'jobcircle-frame') ?></label>
                                <input type="text" name="enddate" class="jobcircle-form-field jobcircle-datepicker" required placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                    </div>
                    <div class="jobcircle-form-fieldhldr">
                        <label class="text-dark ft-medium"><?php esc_html_e('Note', 'jobcircle-frame') ?></label>
                        <textarea name="note" type="text" class="form-control ht-80" placeholder="Note Optional"></textarea>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 contact-info-fields">
                    <div class="jobcircle-form-fieldhldr btn-submit">
                        <input type="hidden" name="action" value="jobcircle_resume_add_education_call">
                        <input type="submit" value="<?php esc_html_e('Add Education +', 'jobcircle-frame') ?>">
                    </div>
                </div>
            </div>
        </form>

        <hr>

        <?php
        $all_itms = get_post_meta($candidate_id, 'experience_record_list', true);
        ?>
        <div class="jobcircle-dashb-multilist jobcircle-dashbcand-experiencelist">
            <?php
            if (!empty($all_itms)) {
                foreach ($all_itms as $itm_id => $itm_record) {
                    echo jobcircle_dashresm_experience_itm_html($itm_record, $itm_id);
                }
            }
            ?>
        </div>
        <div class="heading"><?php esc_html_e('Experience Details', 'jobcircle-frame') ?></div>
        <form method="post" class="jobcircle-dashb-form candidate-addexperience-form account-detail-form">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="jobcircle-form-fieldhldr">
                        <label class="text-dark ft-medium"><?php esc_html_e('Employer/Company Name', 'jobcircle-frame') ?></label>
                        <input type="text" name="company" class="jobcircle-form-field" required placeholder="ABC Textile">
                    </div>
                    <div class="jobcircle-form-fieldhldr">
                        <label class="text-dark ft-medium"><?php esc_html_e('Job Title', 'jobcircle-frame') ?></label>
                        <input type="text" name="job_title" class="jobcircle-form-field" required placeholder="Graphic Designer">
                    </div>
                    <div class="form-row row candash-form-centrow">
                        <div class="col-4">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Start Date', 'jobcircle-frame') ?></label>
                                <input type="text" name="startdate" class="jobcircle-form-field jobcircle-datepicker" required placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('End Date', 'jobcircle-frame') ?></label>
                                <input type="text" name="enddate" class="jobcircle-form-field jobcircle-datepicker" placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="jobcircle-form-fieldhldr candash-form-chkbutncon">
                                <input id="experience-still-work" type="checkbox" name="still_working" value="on">
                                <label for="experience-still-work" class="text-dark ft-medium"><?php esc_html_e('Still working here', 'jobcircle-frame') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="jobcircle-form-fieldhldr">
                        <label class="text-dark ft-medium"><?php esc_html_e('Note', 'jobcircle-frame') ?></label>
                        <textarea name="note" type="text" class="form-control ht-80" placeholder="Note Optional"></textarea>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 contact-info-fields">
                    <div class="jobcircle-form-fieldhldr btn-submit">
                        <input type="hidden" name="action" value="jobcircle_resume_add_experience_call">
                        <input type="submit" value="<?php esc_html_e('Add Experience +', 'jobcircle-frame') ?>">
                    </div>
                </div>
            </div>
        </form>
        
        <hr>
        
        <?php
        $all_itms = get_post_meta($candidate_id, 'expertise_record_list', true);
        ?>
        <div class="jobcircle-dashb-multilist jobcircle-dashbcand-expertiselist">
            <?php
            if (!empty($all_itms)) {
                foreach ($all_itms as $itm_id => $itm_record) {
                    echo jobcircle_dashresm_expertise_itm_html($itm_record, $itm_id);
                }
            }
            ?>
        </div>
        <div class="heading"><?php esc_html_e('Expertise', 'jobcircle-frame') ?></div>
        <form method="post" class="jobcircle-dashb-form candidate-addexpertise-form account-detail-form">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    
                    <div class="form-row row candash-form-centrow">

                        <div class="col-6">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Title', 'jobcircle-frame') ?></label>
                                <input type="text" name="skill_name" class="jobcircle-form-field" required placeholder="<?php esc_html_e('Skill name', 'jobcircle-frame') ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Percentage', 'jobcircle-frame') ?></label>
                                <input type="text" name="skill_percentage" class="jobcircle-form-field" required placeholder="85">
                            </div>
                        </div>
                    
                    </div>
                   
                </div>
                <div class="col-xl-12 col-lg-12 contact-info-fields">
                    <div class="jobcircle-form-fieldhldr btn-submit">
                        <input type="hidden" name="action" value="jobcircle_resume_add_expertise_call">
                        <input type="submit" value="<?php esc_html_e('Add Expertise +', 'jobcircle-frame') ?>">
                    </div>
                </div>
          
            </div>
        </form>
    </div>
    </div>
 
        
    
    <div class="space-top-footer"></div>
    <?php
    $html = ob_get_clean();
    return $html;
}

add_action('wp_head', function() {
    if (isset($_GET['account_tab']) && $_GET['account_tab'] == 'my-resume') {
        ?>
        <style>
            .jobcircle-dashb-multilist {
                position: relative;
                display: inline-block;
                width: 100%;
                margin: 20px 0 0;
            }
            .jobcircle-dashb-multilitm {
                display: inline-block;
                width: 100%;
                border-radius: 8px;
                margin-bottom: 20px;
            }
            .jobcircle-dashb-multilitm .multilitm-hder {
                display: flex;
                width: 100%;
                background-color: #e9f8ef;
                justify-content: space-between;
            }
            .multilitm-hder .hder-inititle-con {
                display: flex;
                flex: 0 0 calc(100% - 150px);
                gap: 15px;
                align-items: center;
            }
            .hder-inititle-con .multili-sorter {
                display: flex;
                margin: 0px 0 0 15px;
                padding: 3px 4px;
                background-color: #17b67c;
                color: #fff;
                border-radius: 4px;
                cursor: move;
            }
            .hder-inititle-con .multili-sorter img {
                max-height: 20px;
            }
            .hder-inititle-con .multili-sorter i {
                font-size: 18px;
                line-height: 20px;
            }
            .hder-inititle-con .multili-titltxt {
                display: inline-block;
                flex: 0 0 100%;
                padding: 15px 0;
                cursor: pointer;
            }
            .hder-inititle-con .multili-titltxt strong {
                color: #172228;
            }
            .multilitm-hder .hder-iniactions-con {
                display: flex;
                flex: 0 0 85px;
                justify-content: end;
                align-items: center;
                gap: 10px;
            }
            .multilitm-hder .hder-iniactions-con a {
                display: flex;
                flex: 0 0 25px;
                height: 25px;
                align-items: center;
                justify-content: center;
                color: #fff;
                border-radius: 4px;
            }
            .hder-iniactions-con a.multili-act-remove {
                background-color: #f02727;
                margin: 0 15px 0 0;
            }
            .hder-iniactions-con a.multili-act-edit {
                background-color: #17b67c;
            }
            .hder-iniactions-con a.multili-act-remove img {
                max-height: 18px;
            }
            .hder-iniactions-con a.multili-act-edit img {
                max-height: 20px;
            }
            .jobcircle-dashb-multilist .ui-state-highlight {
                display: inline-block;
                width: 100%;
                height: 50px;
                background-color: #fffff0;
                border-radius: 8px;
                margin-bottom: 20px;
            }
            .candash-form-centrow {
                align-items: center;
            }
            .candash-form-centrow .candash-form-chkbutncon {
                display: flex;
                align-items: center;
                gap: 4px;
                margin-top: 25px;
            }
            .candash-form-centrow .candash-form-chkbutncon label {
                line-height: 20px;
                margin: 0;
                cursor: pointer;
            }
            .candash-form-centrow .candash-form-chkbutncon input {
                width: auto !important;
                margin: 0 !important;
            }
        </style>
        <?php
    }
}, 25);

function jobcircle_dashresm_add_eduitm_html($atts, $rand_id) {
    
    $schoolname = isset($atts['schoolname']) ? $atts['schoolname'] : '';
    $qualification = isset($atts['qualification']) ? $atts['qualification'] : '';
    $startdate = isset($atts['startdate']) ? $atts['startdate'] : '';
    $enddate = isset($atts['enddate']) ? $atts['enddate'] : '';
    $note = isset($atts['note']) ? $atts['note'] : '';

    $dates_str = date_i18n(get_option('date_format'), strtotime($startdate)) . ' - ' . date_i18n(get_option('date_format'), strtotime($enddate));

    ob_start();
    ?>
    <div class="jobcircle-dashb-multilitm" data-id="<?php echo ($rand_id) ?>">
        <div class="multilitm-hder">
            <div class="hder-inititle-con">
                <div class="multili-sorter"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAXklEQVR4nO3WwQnAMAzF0IzXdP+zA8V7qCv4YkhTvQ0+xqAxJEk6CXADi/0sYFYGPOwrfzFgAsF+ArjKvyBJ0idhzLXKygWMuSZhzEmSzocx1yorFzDmmoQxJ0k6zgvAJW2MOMwZhgAAAABJRU5ErkJggg==" alt=""></div>
                <div class="multili-titltxt"><strong><?php echo ($qualification) ?></strong> <span>(<?php echo ($dates_str) ?>)</span></div>
            </div>
            <div class="hder-iniactions-con">
                <a href="javascript:;" class="multili-act-edit"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAABDElEQVR4nO3WMUrEQBiG4WltFCG3EdTr6AUsd6tlL+Ax1iNoa2HrHfQUjwxkYZEkaIqdf+B/y2QC7/fPzEdKSZIkDNhiXzqWP7LvWb6vEKbl+wmBp4UAGeJs6GUnlqpS9BB/qUrLITbnt15RlaZDhJP/T4iw8ke2C99OvoskH6tlVsrHCrFSPmRVrmGT8mvIybciJ9+KnHwrZM83Qs+Tr+AStziskG/3SzwFXrqVr+C+W/kKhvBnvoIdrsoEuMDNzJ2IMXl84X0uxMm6Q0T54URqMcTYTnHkK7j7dSxmQ9TnoeQreJw42x+4Lj2A55l26SME3mYCfNd2KtHBJ17HnXgY78TQ2itJkqSE4gepjrj/1tuJ/AAAAABJRU5ErkJggg==" alt=""></a>
                <a href="javascript:;" class="multili-act-remove"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAhklEQVR4nO2SywmAMBAF14t1WII2qU3pSexESxCPI4HNxQ+Jxh+SuSUvvGHDijgAMqABJtZMmmUSiha5qEMlCTBqWb6RF5qZN8mR4o7raPcktyCviR6Hpybh9yJZ3LvOligifp0lLgNxGb6/DGcRD9FAOL2PqLpAVPqIUpWdmaw3EtOxLJ4B5pmXbKDLiX8AAAAASUVORK5CYII=" alt=""></a>
            </div>
        </div>
        <div class="inner-fields-formcon" style="display: none;">
            <div class="updte-fields-forminer">
                <form method="post" class="jobcircle-dashb-form candidate-updtedu-form account-detail-form">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Institute Name', 'jobcircle-frame') ?></label>
                                <input type="text" name="schoolname" class="jobcircle-form-field" value="<?php echo ($schoolname) ?>" required placeholder="Institute Name">
                            </div>
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Qualification', 'jobcircle-frame') ?></label>
                                <input type="text" name="qualification" class="jobcircle-form-field" value="<?php echo ($qualification) ?>" required placeholder="Qualification Title">
                            </div>
                            <div class="form-row row">
                                <div class="col-6">
                                    <div class="jobcircle-form-fieldhldr">
                                        <label class="text-dark ft-medium"><?php esc_html_e('Start Date', 'jobcircle-frame') ?></label>
                                        <input type="text" name="startdate" class="jobcircle-form-field jobcircle-datepicker" value="<?php echo ($startdate) ?>" required placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="jobcircle-form-fieldhldr">
                                        <label class="text-dark ft-medium"><?php esc_html_e('End Date', 'jobcircle-frame') ?></label>
                                        <input type="text" name="enddate" class="jobcircle-form-field jobcircle-datepicker" value="<?php echo ($enddate) ?>" required placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                            </div>
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Note', 'jobcircle-frame') ?></label>
                                <textarea name="note" type="text" class="form-control ht-80" placeholder="Note Optional"><?php echo ($note) ?></textarea>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 contact-info-fields">
                            <div class="jobcircle-form-fieldhldr btn-submit">
                                <input type="hidden" name="id" value="<?php echo ($rand_id) ?>">
                                <input type="hidden" name="action" value="jobcircle_resume_updte_education_call">
                                <input type="submit" value="<?php esc_html_e('Update', 'jobcircle-frame') ?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_clean();

    return $html;
}

add_action('wp_ajax_jobcircle_resume_add_education_call', function () {
    global $current_user;

    $rand_id = rand(10000000, 99999999);
    $schoolname = jobcircle_esc_html($_POST['schoolname']);
    $qualification = jobcircle_esc_html($_POST['qualification']);
    $startdate = jobcircle_esc_html($_POST['startdate']);
    $enddate = jobcircle_esc_html($_POST['enddate']);
    $note = jobcircle_esc_html($_POST['note']);

    if ($schoolname == '' || $qualification == '' || $startdate == '' || $enddate == '') {
        $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all mandatory fields.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $atts = array(
        'schoolname' => $schoolname,
        'qualification' => $qualification,
        'startdate' => $startdate,
        'enddate' => $enddate,
        'note' => $note,
    );

    $html = jobcircle_dashresm_add_eduitm_html($atts, $rand_id);

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'education_record_list', true);
        $all_itms = !empty($all_itms) ? $all_itms : array();

        $all_itms[$rand_id] = $atts;
        update_post_meta($candidate_id, 'education_record_list', $all_itms);
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'id' => $rand_id, 'html' => $html, 'msg' => esc_html__('New record added successfully.', 'jobcircle-frame'));
    wp_send_json($ret_data);
});

add_action('wp_ajax_jobcircle_resume_updte_education_call', function () {
    global $current_user;

    $rand_id = $_POST['id'];
    $schoolname = jobcircle_esc_html($_POST['schoolname']);
    $qualification = jobcircle_esc_html($_POST['qualification']);
    $startdate = jobcircle_esc_html($_POST['startdate']);
    $enddate = jobcircle_esc_html($_POST['enddate']);
    $note = jobcircle_esc_html($_POST['note']);

    if ($schoolname == '' || $qualification == '' || $startdate == '' || $enddate == '') {
        $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all mandatory fields.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $atts = array(
        'schoolname' => $schoolname,
        'qualification' => $qualification,
        'startdate' => $startdate,
        'enddate' => $enddate,
        'note' => $note,
    );

    $html = jobcircle_dashresm_add_eduitm_html($atts, $rand_id);

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'education_record_list', true);
        $all_itms = !empty($all_itms) ? $all_itms : array();

        if (isset($all_itms[$rand_id])) {
            $all_itms[$rand_id] = $atts;
            update_post_meta($candidate_id, 'education_record_list', $all_itms);
        }
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'id' => $rand_id, 'html' => $html, 'msg' => esc_html__('Record updated successfully.', 'jobcircle-frame'));
    wp_send_json($ret_data);
});

add_action('wp_ajax_jobcircle_dashcand_eduitm_remove_call', function() {
    global $current_user;

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'education_record_list', true);
        
        $itm_id = $_POST['id'];
        if (isset($all_itms[$itm_id])) {
            unset($all_itms[$itm_id]);
            update_post_meta($candidate_id, 'education_record_list', $all_itms);
        }
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'msg' => esc_html__('Record removed successfully.', 'jobcircle-frame'));
    wp_send_json($ret_data);
});

function jobcircle_dashresm_experience_itm_html($atts, $rand_id) {
    
    $company = isset($atts['company']) ? $atts['company'] : '';
    $job_title = isset($atts['job_title']) ? $atts['job_title'] : '';
    $startdate = isset($atts['startdate']) ? $atts['startdate'] : '';
    $enddate = isset($atts['enddate']) ? $atts['enddate'] : '';
    $still_working = isset($atts['still_working']) ? $atts['still_working'] : '';
    $note = isset($atts['note']) ? $atts['note'] : '';

    $enddate_str = esc_html__('Still Working', 'jobcircle-frame');
    if ($still_working != 'on' && $enddate != '') {
        $enddate_str = date_i18n(get_option('date_format'), strtotime($enddate));
    }
    $dates_str = date_i18n(get_option('date_format'), strtotime($startdate)) . ' - ' . $enddate_str;

    ob_start();
    ?>
    <div class="jobcircle-dashb-multilitm" data-id="<?php echo ($rand_id) ?>">
        <div class="multilitm-hder">
            <div class="hder-inititle-con">
                <div class="multili-sorter"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAXklEQVR4nO3WwQnAMAzF0IzXdP+zA8V7qCv4YkhTvQ0+xqAxJEk6CXADi/0sYFYGPOwrfzFgAsF+ArjKvyBJ0idhzLXKygWMuSZhzEmSzocx1yorFzDmmoQxJ0k6zgvAJW2MOMwZhgAAAABJRU5ErkJggg==" alt=""></div>
                <div class="multili-titltxt"><strong><?php echo ($job_title) ?></strong> <span>(<?php echo ($dates_str) ?>)</span></div>
            </div>
            <div class="hder-iniactions-con">
                <a href="javascript:;" class="multili-act-edit"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAABDElEQVR4nO3WMUrEQBiG4WltFCG3EdTr6AUsd6tlL+Ax1iNoa2HrHfQUjwxkYZEkaIqdf+B/y2QC7/fPzEdKSZIkDNhiXzqWP7LvWb6vEKbl+wmBp4UAGeJs6GUnlqpS9BB/qUrLITbnt15RlaZDhJP/T4iw8ke2C99OvoskH6tlVsrHCrFSPmRVrmGT8mvIybciJ9+KnHwrZM83Qs+Tr+AStziskG/3SzwFXrqVr+C+W/kKhvBnvoIdrsoEuMDNzJ2IMXl84X0uxMm6Q0T54URqMcTYTnHkK7j7dSxmQ9TnoeQreJw42x+4Lj2A55l26SME3mYCfNd2KtHBJ17HnXgY78TQ2itJkqSE4gepjrj/1tuJ/AAAAABJRU5ErkJggg==" alt=""></a>
                <a href="javascript:;" class="multili-act-remove"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAhklEQVR4nO2SywmAMBAF14t1WII2qU3pSexESxCPI4HNxQ+Jxh+SuSUvvGHDijgAMqABJtZMmmUSiha5qEMlCTBqWb6RF5qZN8mR4o7raPcktyCviR6Hpybh9yJZ3LvOligifp0lLgNxGb6/DGcRD9FAOL2PqLpAVPqIUpWdmaw3EtOxLJ4B5pmXbKDLiX8AAAAASUVORK5CYII=" alt=""></a>
            </div>
        </div>
        <div class="inner-fields-formcon" style="display: none;">
            <div class="updte-fields-forminer">
                <form method="post" class="jobcircle-dashb-form candidate-updtexperience-form account-detail-form">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Employer/Company Name', 'jobcircle-frame') ?></label>
                                <input type="text" name="company" class="jobcircle-form-field" value="<?php echo ($company) ?>" required placeholder="ABC Textile">
                            </div>
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Job Title', 'jobcircle-frame') ?></label>
                                <input type="text" name="job_title" class="jobcircle-form-field" value="<?php echo ($job_title) ?>" required placeholder="Graphic Designer">
                            </div>
                            <div class="form-row row candash-form-centrow">
                                <div class="col-4">
                                    <div class="jobcircle-form-fieldhldr">
                                        <label class="text-dark ft-medium"><?php esc_html_e('Start Date', 'jobcircle-frame') ?></label>
                                        <input type="text" name="startdate" class="jobcircle-form-field jobcircle-datepicker" value="<?php echo ($startdate) ?>" required placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-4"<?php echo ($still_working ? ' style="display:none;"' : '') ?>>
                                    <div class="jobcircle-form-fieldhldr">
                                        <label class="text-dark ft-medium"><?php esc_html_e('End Date', 'jobcircle-frame') ?></label>
                                        <input type="text" name="enddate" class="jobcircle-form-field jobcircle-datepicker" value="<?php echo ($enddate) ?>" placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="jobcircle-form-fieldhldr candash-form-chkbutncon">
                                        <input id="experience-still-work" type="checkbox" name="still_working" value="on"<?php echo ($still_working ? ' checked' : '') ?>>
                                        <label for="experience-still-work" class="text-dark ft-medium"><?php esc_html_e('Still working here', 'jobcircle-frame') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="jobcircle-form-fieldhldr">
                                <label class="text-dark ft-medium"><?php esc_html_e('Note', 'jobcircle-frame') ?></label>
                                <textarea name="note" type="text" class="form-control ht-80" placeholder="Note Optional"><?php echo ($note) ?></textarea>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 contact-info-fields">
                            <div class="jobcircle-form-fieldhldr btn-submit">
                                <input type="hidden" name="id" value="<?php echo ($rand_id) ?>">
                                <input type="hidden" name="action" value="jobcircle_resume_updte_experience_call">
                                <input type="submit" value="<?php esc_html_e('Update', 'jobcircle-frame') ?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_clean();

    return $html;
}

add_action('wp_ajax_jobcircle_resume_add_experience_call', function () {
    global $current_user;

    $rand_id = rand(10000000, 99999999);
    $company = jobcircle_esc_html($_POST['company']);
    $job_title = jobcircle_esc_html($_POST['job_title']);
    $startdate = jobcircle_esc_html($_POST['startdate']);
    $enddate = jobcircle_esc_html($_POST['enddate']);
    $note = jobcircle_esc_html($_POST['note']);

    if ($company == '' || $job_title == '' || $startdate == '') {
        $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all mandatory fields.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $still_working = '';
    if (isset($_POST['still_working']) && $_POST['still_working'] == 'on') {
        $still_working = 'on';
    }

    $atts = array(
        'company' => $company,
        'job_title' => $job_title,
        'startdate' => $startdate,
        'enddate' => $enddate,
        'still_working' => $still_working,
        'note' => $note,
    );

    $html = jobcircle_dashresm_experience_itm_html($atts, $rand_id);

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'experience_record_list', true);
        $all_itms = !empty($all_itms) ? $all_itms : array();

        $all_itms[$rand_id] = $atts;
        update_post_meta($candidate_id, 'experience_record_list', $all_itms);
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'id' => $rand_id, 'html' => $html, 'msg' => esc_html__('New record added successfully.', 'jobcircle-frame'));
    wp_send_json($ret_data);
});

add_action('wp_ajax_jobcircle_resume_updte_experience_call', function () {
    global $current_user;

    $rand_id = $_POST['id'];
    $company = jobcircle_esc_html($_POST['company']);
    $job_title = jobcircle_esc_html($_POST['job_title']);
    $startdate = jobcircle_esc_html($_POST['startdate']);
    $enddate = jobcircle_esc_html($_POST['enddate']);
    $note = jobcircle_esc_html($_POST['note']);

    if ($company == '' || $job_title == '' || $startdate == '') {
        $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all mandatory fields.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $still_working = '';
    if (isset($_POST['still_working']) && $_POST['still_working'] == 'on') {
        $still_working = 'on';
    }

    $atts = array(
        'company' => $company,
        'job_title' => $job_title,
        'startdate' => $startdate,
        'enddate' => $enddate,
        'still_working' => $still_working,
        'note' => $note,
    );

    $html = jobcircle_dashresm_experience_itm_html($atts, $rand_id);

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'experience_record_list', true);
        $all_itms = !empty($all_itms) ? $all_itms : array();

        if (isset($all_itms[$rand_id])) {
            $all_itms[$rand_id] = $atts;
            update_post_meta($candidate_id, 'experience_record_list', $all_itms);
        }
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'id' => $rand_id, 'html' => $html, 'msg' => esc_html__('New record added successfully.', 'jobcircle-frame'));
    wp_send_json($ret_data);
});

add_action('wp_ajax_jobcircle_dashcand_experienceitm_remove_call', function() {
    global $current_user;

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'experience_record_list', true);
        
        $itm_id = $_POST['id'];
        if (isset($all_itms[$itm_id])) {
            unset($all_itms[$itm_id]);
            update_post_meta($candidate_id, 'experience_record_list', $all_itms);
        }
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'msg' => esc_html__('Record removed successfully.', 'jobcircle-frame'));
    wp_send_json($ret_data);
});

/**
 * Expertise Functions
 */
function jobcircle_dashresm_expertise_itm_html($atts, $rand_id) {
    
    $skill_name = isset($atts['skill_name']) ? $atts['skill_name'] : '';
    $skill_percentage = isset($atts['skill_percentage']) ? $atts['skill_percentage'] : '';

    ob_start();
    ?>
    <div class="jobcircle-dashb-multilitm" data-id="<?php echo ($rand_id) ?>">
        <div class="multilitm-hder">
            <div class="hder-inititle-con">
                <div class="multili-sorter"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAXklEQVR4nO3WwQnAMAzF0IzXdP+zA8V7qCv4YkhTvQ0+xqAxJEk6CXADi/0sYFYGPOwrfzFgAsF+ArjKvyBJ0idhzLXKygWMuSZhzEmSzocx1yorFzDmmoQxJ0k6zgvAJW2MOMwZhgAAAABJRU5ErkJggg==" alt=""></div>
                <div class="multili-titltxt"><strong><?php echo ($skill_name) ?></strong> <span>(<?php echo ($skill_percentage) ?>)</span></div>
            </div>
            <div class="hder-iniactions-con">
                <a href="javascript:;" class="multili-act-edit"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAABDElEQVR4nO3WMUrEQBiG4WltFCG3EdTr6AUsd6tlL+Ax1iNoa2HrHfQUjwxkYZEkaIqdf+B/y2QC7/fPzEdKSZIkDNhiXzqWP7LvWb6vEKbl+wmBp4UAGeJs6GUnlqpS9BB/qUrLITbnt15RlaZDhJP/T4iw8ke2C99OvoskH6tlVsrHCrFSPmRVrmGT8mvIybciJ9+KnHwrZM83Qs+Tr+AStziskG/3SzwFXrqVr+C+W/kKhvBnvoIdrsoEuMDNzJ2IMXl84X0uxMm6Q0T54URqMcTYTnHkK7j7dSxmQ9TnoeQreJw42x+4Lj2A55l26SME3mYCfNd2KtHBJ17HnXgY78TQ2itJkqSE4gepjrj/1tuJ/AAAAABJRU5ErkJggg==" alt=""></a>
                <a href="javascript:;" class="multili-act-remove"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAhklEQVR4nO2SywmAMBAF14t1WII2qU3pSexESxCPI4HNxQ+Jxh+SuSUvvGHDijgAMqABJtZMmmUSiha5qEMlCTBqWb6RF5qZN8mR4o7raPcktyCviR6Hpybh9yJZ3LvOligifp0lLgNxGb6/DGcRD9FAOL2PqLpAVPqIUpWdmaw3EtOxLJ4B5pmXbKDLiX8AAAAASUVORK5CYII=" alt=""></a>
            </div>
        </div>
        <div class="inner-fields-formcon" style="display: none;">
            <div class="updte-fields-forminer">
                <form method="post" class="jobcircle-dashb-form candidate-updtexpertise-form account-detail-form">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="form-row row candash-form-centrow">
                                <div class="col-6">
                                    <div class="jobcircle-form-fieldhldr">
                                        <label class="text-dark ft-medium"><?php esc_html_e('Title', 'jobcircle-frame') ?></label>
                                        <input type="text" name="skill_name" class="jobcircle-form-field" value="<?php echo ($skill_name) ?>" required placeholder="<?php esc_html_e('Skill name', 'jobcircle-frame') ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="jobcircle-form-fieldhldr">
                                        <label class="text-dark ft-medium"><?php esc_html_e('Percentage', 'jobcircle-frame') ?></label>
                                        <input type="text" name="skill_percentage" class="jobcircle-form-field" value="<?php echo ($skill_percentage) ?>" required placeholder="85">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 contact-info-fields">
                            <div class="jobcircle-form-fieldhldr btn-submit">
                                <input type="hidden" name="id" value="<?php echo ($rand_id) ?>">
                                <input type="hidden" name="action" value="jobcircle_resume_updte_expertise_call">
                                <input type="submit" value="<?php esc_html_e('Update', 'jobcircle-frame') ?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_clean();

    return $html;
}

add_action('wp_ajax_jobcircle_resume_add_expertise_call', function () {
    global $current_user;

    $rand_id = rand(10000000, 99999999);
    $skill_name = jobcircle_esc_html($_POST['skill_name']);
    $skill_percentage = jobcircle_esc_html($_POST['skill_percentage']);

    if ($skill_name == '' || $skill_percentage == '') {
        $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all mandatory fields.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $atts = array(
        'skill_name' => $skill_name,
        'skill_percentage' => $skill_percentage,
    );

    $html = jobcircle_dashresm_expertise_itm_html($atts, $rand_id);

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'expertise_record_list', true);
        $all_itms = !empty($all_itms) ? $all_itms : array();

        $all_itms[$rand_id] = $atts;
        update_post_meta($candidate_id, 'expertise_record_list', $all_itms);
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'id' => $rand_id, 'html' => $html, 'msg' => esc_html__('New record added successfully.', 'jobcircle-frame'));
    wp_send_json($ret_data);
});

add_action('wp_ajax_jobcircle_resume_updte_expertise_call', function () {
    global $current_user;

    $rand_id = $_POST['id'];
    $skill_name = jobcircle_esc_html($_POST['skill_name']);
    $skill_percentage = jobcircle_esc_html($_POST['skill_percentage']);

    if ($skill_name == '' || $skill_percentage == '') {
        $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all mandatory fields.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $atts = array(
        'skill_name' => $skill_name,
        'skill_percentage' => $skill_percentage,
    );

    $html = jobcircle_dashresm_expertise_itm_html($atts, $rand_id);

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'expertise_record_list', true);
        $all_itms = !empty($all_itms) ? $all_itms : array();

        if (isset($all_itms[$rand_id])) {
            $all_itms[$rand_id] = $atts;
            update_post_meta($candidate_id, 'expertise_record_list', $all_itms);
        }
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'id' => $rand_id, 'html' => $html, 'msg' => esc_html__('Record updated successfully.', 'jobcircle-frame'));
    wp_send_json($ret_data);
});

add_action('wp_ajax_jobcircle_dashcand_expertiseitm_remove_call', function() {
    global $current_user;

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'expertise_record_list', true);
        
        $itm_id = $_POST['id'];
        if (isset($all_itms[$itm_id])) {
            unset($all_itms[$itm_id]);
            update_post_meta($candidate_id, 'expertise_record_list', $all_itms);
        }
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'jobcircle-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'msg' => esc_html__('Record removed successfully.', 'jobcircle-frame'));
    wp_send_json($ret_data);
});

/**
 * Sorting Call
 */
add_action('wp_ajax_jobcircle_account_experience_record_sorting', function() {
    global $current_user;

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $keys_list = $_POST['keys_list'];

        $all_itms = get_post_meta($candidate_id, 'experience_record_list', true);

        $new_rec = [];

        foreach ($keys_list as $itm_key) {
            if (isset($all_itms[$itm_key])) {
                $new_rec[$itm_key] = $all_itms[$itm_key];
            }
        }

        if (!empty($new_rec) && count($new_rec) == count($all_itms)) {
            update_post_meta($candidate_id, 'experience_record_list', $new_rec);
        }
    }
    die;
});

add_action('wp_ajax_jobcircle_account_education_record_sorting', function() {
    global $current_user;

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $keys_list = $_POST['keys_list'];

        $all_itms = get_post_meta($candidate_id, 'education_record_list', true);

        $new_rec = [];

        foreach ($keys_list as $itm_key) {
            if (isset($all_itms[$itm_key])) {
                $new_rec[$itm_key] = $all_itms[$itm_key];
            }
        }

        if (!empty($new_rec) && count($new_rec) == count($all_itms)) {
            update_post_meta($candidate_id, 'education_record_list', $new_rec);
        }
    }
    die;
});

add_action('wp_ajax_jobcircle_account_expertise_record_sorting', function() {
    global $current_user;

    $user_id = $current_user->ID;
    $candidate_id = jobcircle_user_candidate_id($user_id);
    if ($candidate_id) {
        $keys_list = $_POST['keys_list'];

        $all_itms = get_post_meta($candidate_id, 'expertise_record_list', true);

        $new_rec = [];

        foreach ($keys_list as $itm_key) {
            if (isset($all_itms[$itm_key])) {
                $new_rec[$itm_key] = $all_itms[$itm_key];
            }
        }

        if (!empty($new_rec) && count($new_rec) == count($all_itms)) {
            update_post_meta($candidate_id, 'expertise_record_list', $new_rec);
        }
    }
    die;
});
