<?php

defined('ABSPATH') || exit;

class Jobcircle_Candidate_Profile_Score_Functions {
    
    public function __construct() {
        
        add_filter('jobcircle_dashboard_header_candprofile_score', array($this, 'dashboard_header_score_html'));
        add_filter('jobcircle_candidate_profile_score_setting_fields', array($this, 'settings_fields'));
        add_action('wp_ajax_jobcircle_get_profile_score', array($this, 'jobcircle_get_profile_score'));
    }

    public function jobcircle_get_profile_score(){
        global $jobcircle_framework_options;
        
        $candidate_profile_scoring = isset($jobcircle_framework_options['candidate_profile_scoring']) ? $jobcircle_framework_options['candidate_profile_scoring'] : '';

        $user_id = get_current_user_id();
        $candidate_id = jobcircle_user_candidate_id($user_id);

        if ($candidate_id && $candidate_profile_scoring != 'off') {
            $total_score = $this->candidate_skill_percent_count($user_id);
            $score_msgs = $this->candidate_skill_percent_count($user_id, 'msgs');

            $complete_profile_color = isset($jobcircle_framework_options['skill_ahigh_set_color']) && $jobcircle_framework_options['skill_ahigh_set_color'] != '' ? $jobcircle_framework_options['skill_ahigh_set_color'] : '#40d184';
            $professional_profile_color = isset($jobcircle_framework_options['skill_high_set_color']) && $jobcircle_framework_options['skill_high_set_color'] != '' ? $jobcircle_framework_options['skill_high_set_color'] : '#13b5ea';
            $basic_profile_color = isset($jobcircle_framework_options['skill_med_set_color']) && $jobcircle_framework_options['skill_med_set_color'] != '' ? $jobcircle_framework_options['skill_med_set_color'] : '#ffbb00';
            $low_profile_color = isset($jobcircle_framework_options['skill_low_set_color']) && $jobcircle_framework_options['skill_low_set_color'] != '' ? $jobcircle_framework_options['skill_low_set_color'] : '#ff5b5b';
            if ($total_score > 75) {
                $profile_score_color = $complete_profile_color;
            } else if ($total_score > 50 && $total_score < 76) {
                $profile_score_color = $professional_profile_color;
            } else if ($total_score > 25 && $total_score < 51) {
                $profile_score_color = $basic_profile_color;
            } else {
                $profile_score_color = $low_profile_color;
            }

            ob_start();
                ?>
                <span class="score-labl"><?php printf(__('Profile Completed: <strong style="color:%s;">%s</strong>', 'jobcircle-frame'), $profile_score_color, $total_score . '%') ?></span>
                <?php
            $jobcircle_profile_score_html = ob_get_clean();

            ob_start();
            if (!empty($score_msgs)) {
                foreach ($score_msgs as $msg_itm) {
                    echo '<div>' . $msg_itm . '</div>';
                }
            }
            $jobcircle_profile_score_msgs_html = ob_get_clean();
        }
        
        $jobcircle_ret_data = array(
            'error' => '0', 
            'profile_score' => $jobcircle_profile_score_html,
            'profile_score_msgs' => $jobcircle_profile_score_msgs_html,
            'msg' => ''
        );
        wp_send_json($jobcircle_ret_data);
    }
    public function candidate_skills_set_array() {

        $skills_array = array(
            'jobcircle_display_name' => array(
                'name' => esc_html__('Full Name', 'jobcircle-frame'),
            ),
            'jobcircle_user_img' => array(
                'name' => esc_html__('Profile Image', 'jobcircle-frame'),
            ),
            'jobcircle_post_title' => array(
                'name' => esc_html__('Job Title', 'jobcircle-frame'),
            ),
            'jobcircle_salary' => array(
                'name' => esc_html__('Salary', 'jobcircle-frame'),
            ),
            'jobcircle_sectors' => array(
                'name' => esc_html__('Sector/Category', 'jobcircle-frame'),
            ),
            'jobcircle_description' => array(
                'name' => esc_html__('Description', 'jobcircle-frame'),
            ),
            'jobcircle_candidate_cv' => array(
                'name' => esc_html__('CV File', 'jobcircle-frame'),
            ),
            'jobcircle_social_network' => array(
                'name' => esc_html__('Social Network', 'jobcircle-frame'),
                'list' => array(
                    'jobcircle_facebook' => array(
                        'name' => esc_html__('Facebook', 'jobcircle-frame'),
                    ),
                    'jobcircle_twitter' => array(
                        'name' => esc_html__('Twitter', 'jobcircle-frame'),
                    ),
                    'jobcircle_linkedin' => array(
                        'name' => esc_html__('Linkedin', 'jobcircle-frame'),
                    ),
                ),
            ),
            'contact_info' => array(
                'name' => esc_html__('Contact Information', 'jobcircle-frame'),
                'list' => array(
                    'jobcircle_user_phone' => array(
                        'name' => esc_html__('Phone Number', 'jobcircle-frame'),
                    ),
                    'jobcircle_user_email' => array(
                        'name' => esc_html__('Email', 'jobcircle-frame'),
                    ),
                    'jobcircle_location_address' => array(
                        'name' => esc_html__('Complete Address', 'jobcircle-frame'),
                    ),
                ),
            ),
            'resume' => array(
                'name' => esc_html__('Resume', 'jobcircle-frame'),
                'list' => array(
                    'jobcircle_education_record_list' => array(
                        'name' => esc_html__('Education', 'jobcircle-frame'),
                    ),
                    'jobcircle_experience_record_list' => array(
                        'name' => esc_html__('Experience', 'jobcircle-frame'),
                    ),
                    'jobcircle_expertise_record_list' => array(
                        'name' => esc_html__('Skills/Expertise', 'jobcircle-frame'),
                    ),
                ),
            ),
        );
        $skills_array = apply_filters('jobcircle_custom_fields_load_precentage_array', $skills_array);
        return $skills_array;
    }
    
    public function skill_add_to_link($dashbord_page_url, $skill_key, $tab = 'profile') {
        $quer_args = [];
        if ($tab != '') {
            $quer_args['account_tab'] = $tab;
        }
        if (!empty($quer_args)) {
            $url = add_query_arg($quer_args, $dashbord_page_url);
        } else {
            $url = $dashbord_page_url;
        }
        $skill_key = str_replace(array('jobcircle_'), array(''), $skill_key);
        //$url .= '#' . $skill_key . '_skillid';
        
        return $url;
    }

    public function candidate_skill_percent_count($user_id, $return_type = 'return') {
        global $jobcircle_framework_options;
        $skills_perc = 0;
        
        $account_page_name = isset($jobcircle_framework_options['user_dashboard_page']) ? $jobcircle_framework_options['user_dashboard_page'] : '';

        $account_page_id = jobcircle_get_page_id_from_name($account_page_name);

        $dashbord_page_url = home_url('/');
        if ($account_page_id > 0) {
            $dashbord_page_url = get_permalink($account_page_id);
        }

        $msgs_array = array();

        $candidate_id = jobcircle_user_candidate_id($user_id);
        if ($candidate_id) {
            $skills_array = $this->candidate_skills_set_array();
            foreach ($skills_array as $skill_key => $skill_val) {
                if ($skill_key == 'jobcircle_display_name') {
                    $this_opt_id = str_replace('jobcircle_', '', $skill_key) . '_profile_score';
                    $def_percentage = isset($jobcircle_framework_options[$this_opt_id]) ? $jobcircle_framework_options[$this_opt_id] : '';
                    $candidate_name_title = get_the_title($candidate_id);
                    if ($candidate_name_title != '') {
                        $skills_perc += ($def_percentage > 0 ? $def_percentage : 0);
                    } else {
                        if ($def_percentage > 0) {
                            $msgs_array[] = sprintf(__('<a href="%s"><small> %s </small> Increase profile score by Full Name.</a>', 'jobcircle-frame'), $this->skill_add_to_link($dashbord_page_url, $skill_key), $def_percentage . '%');
                        }
                    }
                }
                if ($skill_key == 'jobcircle_user_img') {
                    $this_opt_id = str_replace('jobcircle_', '', $skill_key) . '_profile_score';
                    $def_percentage = isset($jobcircle_framework_options[$this_opt_id]) ? $jobcircle_framework_options[$this_opt_id] : '';

                    $cand_thumbnail_id = get_post_thumbnail_id($candidate_id);

                    if ($cand_thumbnail_id > 0) {
                        $skills_perc += ($def_percentage > 0 ? $def_percentage : 0);
                    } else {
                        if ($def_percentage > 0) {
                            $msgs_array[] = sprintf(__('<a href="%s"><small> %s </small> Increase profile score by Profile Image.</a>', 'jobcircle-frame'), $this->skill_add_to_link($dashbord_page_url, $skill_key), $def_percentage . '%');
                        }
                    }
                }
                if ($skill_key == 'jobcircle_post_title') {
                    $this_opt_id = str_replace('jobcircle_', '', $skill_key) . '_profile_score';
                    $def_percentage = isset($jobcircle_framework_options[$this_opt_id]) ? $jobcircle_framework_options[$this_opt_id] : '';
                    $candidate_post_title = get_post_meta($candidate_id, 'jobcircle_field_job_title', true);
                    if ($candidate_post_title != '') {
                        $skills_perc += ($def_percentage > 0 ? $def_percentage : 0);
                    } else {
                        if ($def_percentage > 0) {
                            $msgs_array[] = sprintf(__('<a href="%s"><small> %s </small> Increase profile score by Job Title.</a>', 'jobcircle-frame'), $this->skill_add_to_link($dashbord_page_url, $skill_key), $def_percentage . '%');
                        }
                    }
                }
                if ($skill_key == 'jobcircle_salary') {
                    $this_opt_id = str_replace('jobcircle_', '', $skill_key) . '_profile_score';
                    $def_percentage = isset($jobcircle_framework_options[$this_opt_id]) ? $jobcircle_framework_options[$this_opt_id] : '';
                    $candidate_salary = get_post_meta($candidate_id, 'jobcircle_field_salary', true);
                    if ($candidate_salary != '') {
                        $skills_perc += ($def_percentage > 0 ? $def_percentage : 0);
                    } else {
                        if ($def_percentage > 0) {
                            $msgs_array[] = sprintf(__('<a href="%s"><small> %s </small> Increase profile score by Salary.</a>', 'jobcircle-frame'), $this->skill_add_to_link($dashbord_page_url, $skill_key), $def_percentage . '%');
                        }
                    }
                }
                if ($skill_key == 'jobcircle_sectors') {
                    $this_opt_id = str_replace('jobcircle_', '', $skill_key) . '_profile_score';
                    $def_percentage = isset($jobcircle_framework_options[$this_opt_id]) ? $jobcircle_framework_options[$this_opt_id] : '';
                    $candidate_sectors = wp_get_post_terms($candidate_id, 'candidate_cat');
                    if (!empty($candidate_sectors)) {
                        $skills_perc += ($def_percentage > 0 ? $def_percentage : 0);
                    } else {
                        if ($def_percentage > 0) {
                            $msgs_array[] = sprintf(__('<a href="%s"><small> %s </small> Increase profile score by Sector.</a>', 'jobcircle-frame'), $this->skill_add_to_link($dashbord_page_url, $skill_key), $def_percentage . '%');
                        }
                    }
                }
                if ($skill_key == 'jobcircle_description') {
                    $this_opt_id = str_replace('jobcircle_', '', $skill_key) . '_profile_score';
                    $def_percentage = isset($jobcircle_framework_options[$this_opt_id]) ? $jobcircle_framework_options[$this_opt_id] : '';
                    $candidate_obj = get_post($candidate_id);
                    $candidate_desc = isset($candidate_obj->post_content) ? $candidate_obj->post_content : '';
                    if ($candidate_desc != '') {
                        $skills_perc += ($def_percentage > 0 ? $def_percentage : 0);
                    } else {
                        if ($def_percentage > 0) {
                            $msgs_array[] = sprintf(__('<a href="%s"><small> %s </small> Increase profile score by Description.</a>', 'jobcircle-frame'), $this->skill_add_to_link($dashbord_page_url, $skill_key), $def_percentage . '%');
                        }
                    }
                }
                if ($skill_key == 'jobcircle_social_network') {
                    if (isset($skill_val['list'])) {
                        foreach ($skill_val['list'] as $skill_social_key => $skill_social_val) {
                            $this_opt_id = str_replace('jobcircle_', '', $skill_social_key) . '_profile_score';
                            $def_percentage = isset($jobcircle_framework_options[$this_opt_id]) ? $jobcircle_framework_options[$this_opt_id] : '';
                            //
                            $this_meta_id = 'jobcircle_field_' . str_replace('jobcircle_', '', $skill_social_key) . '_url';
                            $candidate_social_val = get_post_meta($candidate_id, $this_meta_id, true);
                            if ($candidate_social_val != '') {
                                $skills_perc += ($def_percentage > 0 ? $def_percentage : 0);
                            } else {
                                if ($def_percentage > 0) {
                                    $msgs_array[] = sprintf(__('<a href="%s"><small> %s </small> Increase profile score by %s.</a>', 'jobcircle-frame'), $this->skill_add_to_link($dashbord_page_url, $skill_key), $def_percentage . '%', $skill_social_val['name']);
                                }
                            }
                        }
                    }
                }
                if ($skill_key == 'contact_info') {
                    if (isset($skill_val['list'])) {
                        foreach ($skill_val['list'] as $skill_contact_key => $skill_contact_val) {
                            $this_opt_id = str_replace('jobcircle_', '', $skill_contact_key) . '_profile_score';
                            $def_percentage = isset($jobcircle_framework_options[$this_opt_id]) ? $jobcircle_framework_options[$this_opt_id] : '';
                            //
                            if ($skill_contact_key != 'jobcircle_user_email') {
                                if ($skill_contact_key == 'jobcircle_location_address') {
                                    $this_meta_id = 'jobcircle_field_loc_address';
                                } else {
                                    $this_meta_id = str_replace('jobcircle_', 'jobcircle_field_', $skill_contact_key);
                                }
                                $candidate_contact_val = get_post_meta($candidate_id, $this_meta_id, true);
                                if ($candidate_contact_val != '') {
                                    $skills_perc += ($def_percentage > 0 ? $def_percentage : 0);
                                } else {
                                    if ($def_percentage > 0) {
                                        $msgs_array[] = sprintf(__('<a href="%s"><small> %s </small> Increase profile score by %s.</a>', 'jobcircle-frame'), $this->skill_add_to_link($dashbord_page_url, $skill_contact_key), $def_percentage . '%', $skill_contact_val['name']);
                                    }
                                }
                            } else {
                                $user_obj = get_user_by('ID', $user_id);
                                if ($skill_contact_key == 'jobcircle_user_email' && isset($user_obj->user_email) && $user_obj->user_email != '') {
                                    $skills_perc += ($def_percentage > 0 ? $def_percentage : 0);
                                } else {
                                    if ($def_percentage > 0) {
                                        $msgs_array[] = sprintf(__('<a href="%s"><small> %s </small> Increase profile score by %s.</a>', 'jobcircle-frame'), $this->skill_add_to_link($dashbord_page_url, $skill_contact_key), $def_percentage . '%', $skill_contact_val['name']);
                                    }
                                }
                            }
                        }
                    }
                }
                if ($skill_key == 'resume') {
                    if (isset($skill_val['list'])) {
                        foreach ($skill_val['list'] as $skill_resume_key => $skill_resume_val) {
                            $this_opt_id = str_replace('jobcircle_', '', $skill_resume_key) . '_profile_score';
                            $def_percentage = isset($jobcircle_framework_options[$this_opt_id]) ? $jobcircle_framework_options[$this_opt_id] : '';
                            //
                            $this_meta_id = str_replace('jobcircle_', '', $skill_resume_key);
                            $candidate_resume_val = get_post_meta($candidate_id, $this_meta_id, true);
                            if (!empty($candidate_resume_val)) {
                                $skills_perc += ($def_percentage > 0 ? $def_percentage : 0);
                            } else {
                                if ($def_percentage > 0) {
                                    $msgs_array[] = sprintf(__('<a href="%s"><small> %s </small> Increase profile score by %s.</a>', 'jobcircle-frame'), $this->skill_add_to_link($dashbord_page_url, $skill_resume_key, 'my-resume'), $def_percentage . '%', $skill_resume_val['name']);
                                }
                            }
                        }
                    }
                }
                if ($skill_key == 'jobcircle_candidate_cv') {
                    $candidate_cv_file = get_post_meta($candidate_id, 'candidate_cv_files', true);
                    if (!empty($candidate_cv_file)) {
                        $skills_perc += ($def_percentage > 0 ? $def_percentage : 0);
                    } else {
                        if ($def_percentage > 0) {
                            $msgs_array[] = sprintf(__('<a href="%s"><small> %s </small> Increase profile score by upload CV.</a>', 'jobcircle-frame'), $this->skill_add_to_link($dashbord_page_url, $skill_key, 'resume-manager'), $def_percentage . '%');
                        }
                    }
                }
            }
            
            $msgs_array = apply_filters('jobcircle_cand_overall_skills_msgs', $msgs_array, $candidate_id);
            $skills_perc = apply_filters('jobcircle_cand_overall_skills_percentage', $skills_perc, $candidate_id);

            if ($skills_perc > 100) {
                $skills_perc = 100;
            }
            
            update_post_meta($candidate_id, 'overall_skills_percentage', $skills_perc);
        }

        if ($return_type == 'return') {
            return $skills_perc;
        }
        if ($return_type == 'msgs') {
            return $msgs_array;
        }
    }

    public function settings_fields($jobcircle_setting_options) {
        $skills_array = $this->candidate_skills_set_array();
        if (is_array($skills_array) && sizeof($skills_array) > 0) {

            foreach ($skills_array as $skills_array_key => $skills_array_set) {

                if (array_key_exists('list', $skills_array_set) && is_array($skills_array_set['list'])) {

                    $skill_sec_name = isset($skills_array_set['name']) ? $skills_array_set['name'] : '';
                    if ($skill_sec_name != '' && $skills_array_key != '') {
                        $jobcircle_setting_options[] = array(
                            'id' => "tab-settings-$skills_array_key-skill",
                            'type' => 'section',
                            'title' => $skill_sec_name,
                            'subtitle' => '',
                            'indent' => true,
                        );
                    }
                    foreach ($skills_array_set['list'] as $skill_list_key => $skill_list_set) {
                        $skill_name = isset($skill_list_set['name']) ? $skill_list_set['name'] : '';
                        if ($skill_list_key != '' && $skill_name != '') {

                            $this_opt_id = str_replace('jobcircle_', '', $skill_list_key) . '_profile_score';

                            $jobcircle_setting_options[] = array(
                                'id' => $this_opt_id,
                                'type' => 'text',
                                'title' => sprintf(esc_html__('%s Score', 'jobcircle-frame'), $skill_name),
                                'desc' => '',
                                'default' => '5',
                            );
                        }
                    }
                    $jobcircle_setting_options[] = array(
                        'id' => "tab-settings-$skills_array_key-skill-secend",
                        'type' => 'section',
                        'title' => '',
                        'subtitle' => '',
                        'indent' => false,
                    );
                } else {
                    $skill_name = isset($skills_array_set['name']) ? $skills_array_set['name'] : '';
                    if ($skills_array_key != '' && $skill_name != '') {
                        $this_opt_id = str_replace('jobcircle_', '', $skills_array_key) . '_profile_score';
                        $jobcircle_setting_options[] = array(
                            'id' => $this_opt_id,
                            'type' => 'text',
                            'title' => sprintf(esc_html__('%s Score', 'jobcircle-frame'), $skill_name),
                            'desc' => '',
                            'default' => '5',
                        );
                    }
                }
            }
        }
        
        return $jobcircle_setting_options;
    }

    public function dashboard_header_score_html($html) {
        global $jobcircle_framework_options;
        
        $candidate_profile_scoring = isset($jobcircle_framework_options['candidate_profile_scoring']) ? $jobcircle_framework_options['candidate_profile_scoring'] : '';

        $user_id = get_current_user_id();
        $candidate_id = jobcircle_user_candidate_id($user_id);

        if ($candidate_id && $candidate_profile_scoring != 'off') {
            $total_score = $this->candidate_skill_percent_count($user_id);
            $score_msgs = $this->candidate_skill_percent_count($user_id, 'msgs');

            $complete_profile_color = isset($jobcircle_framework_options['skill_ahigh_set_color']) && $jobcircle_framework_options['skill_ahigh_set_color'] != '' ? $jobcircle_framework_options['skill_ahigh_set_color'] : '#40d184';
            $professional_profile_color = isset($jobcircle_framework_options['skill_high_set_color']) && $jobcircle_framework_options['skill_high_set_color'] != '' ? $jobcircle_framework_options['skill_high_set_color'] : '#13b5ea';
            $basic_profile_color = isset($jobcircle_framework_options['skill_med_set_color']) && $jobcircle_framework_options['skill_med_set_color'] != '' ? $jobcircle_framework_options['skill_med_set_color'] : '#ffbb00';
            $low_profile_color = isset($jobcircle_framework_options['skill_low_set_color']) && $jobcircle_framework_options['skill_low_set_color'] != '' ? $jobcircle_framework_options['skill_low_set_color'] : '#ff5b5b';
            if ($total_score > 75) {
                $profile_score_color = $complete_profile_color;
            } else if ($total_score > 50 && $total_score < 76) {
                $profile_score_color = $professional_profile_color;
            } else if ($total_score > 25 && $total_score < 51) {
                $profile_score_color = $basic_profile_color;
            } else {
                $profile_score_color = $low_profile_color;
            }

            ob_start();
            $anchor_atts = 'href="javascript:;"';
            if (!empty($score_msgs)) {
                $anchor_atts = 'href="#" data-bs-toggle="modal" data-bs-target="#candidate-profilescor-modal"';
            }
            ?>
            <a <?php echo ($anchor_atts) ?> class="cand-profilescor-btn"><span class="score-labl"><?php printf(__('Profile Completed: <strong style="color:%s;">%s</strong>', 'jobcircle-frame'), $profile_score_color, $total_score . '%') ?></span></a>
            <?php
            $html .= ob_get_clean();

            if (!empty($score_msgs)) {
                add_action('wp_footer', function() use($score_msgs) {
                    ?>
                    <div class="modal fade" id="candidate-profilescor-modal" tabindex="-1" role="dialog" aria-labelledby="apply-job-modal" aria-hidden="true">
                        <div class="modal-dialog login-pop-form" role="document">
                            <div class="modal-content">
                                <div class="modal-headers">
                                    <a href="javascript:;" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></a>
                                </div>
                            
                                <div class="score-details-holder">
                                    <?php
                                    foreach ($score_msgs as $msg_itm) {
                                        echo '<div>' . $msg_itm . '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }, 45);
            }
        }

        return $html;
    }

}

global $jobcircle_candidate_profilescre;

$jobcircle_candidate_profilescre = new Jobcircle_Candidate_Profile_Score_Functions;