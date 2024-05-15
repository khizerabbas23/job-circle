<?php

defined('ABSPATH') || exit;

class Jobcircle_Meta_Boxes
{

    public function __construct()
    {
        add_action('save_post', array($this, 'save_meta_fields'), 5);
        add_action('add_meta_boxes', array($this, 'post_layout_meta_boxes'));
    }

    public function save_meta_fields($post_id = '')
    {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        foreach ($_POST as $key => $value) {
            if (strstr($key, 'jobcircle_field_')) {
                update_post_meta($post_id, $key, $value);
            }
        }
    }

    public function post_layout_meta_boxes()
    {
        add_meta_box('jobcircle-post-layout', esc_html__('Post Layout', 'jobcircle-frame'), array($this, 'post_layout_meta'), 'post', 'side');
        add_meta_box('jobcircle-post-layout', esc_html__('Job Layout', 'jobcircle-frame'), array($this, 'post_layout_meta'), 'jobs', 'side');
        add_meta_box('jobcircle-page-layout', esc_html__('Page Layout', 'jobcircle-frame'), array($this, 'post_layout_meta'), 'page', 'side');
        add_meta_box('jobcircle-page-menu', esc_html__('Select Page Menu', 'jobcircle-frame'), array($this, 'post_navigatin_meta'), 'page', 'side');
        add_meta_box('jobcircle-page-subheader', esc_html__('Select Subheader', 'jobcircle-frame'), array($this, 'sub_header'), 'page', 'side');
        add_meta_box('jobcircle-post-subheader', esc_html__('Select Subheader', 'jobcircle-frame'), array($this, 'post_sub_header'), 'jobs', 'side');

        add_meta_box('jobcircle-page-column-size', esc_html__('Column Size Sidebar', 'jobcircle-frame'), array($this, 'column_size'), 'page', 'side');
        add_meta_box('jobcircle-page-column-size', esc_html__('Column Size Sidebar', 'jobcircle-frame'), array($this, 'column_size'), 'post', 'side');
        add_meta_box('jobcircle-page-headerstyle', esc_html__('Select Header Style', 'jobcircle-frame'), array($this, 'header_style'), 'page', 'side');
        add_meta_box('jobcircle-page-footerstyle', esc_html__('Select Footer Style', 'jobcircle-frame'), array($this, 'footer_style'), 'page', 'side');
        add_meta_box('jobcircle-list-famous-job', esc_html__('Job Settings', 'jobcircle-frame'), array($this, 'list_framing_jobs'), 'jobs');
        add_meta_box('jobcircle-list-famous-job', esc_html__('Candidate Settings', 'jobcircle-frame'), array($this, 'list_candidate_meta'), 'candidates');
        add_meta_box('jobcircle-list-famous-job', esc_html__('Top Category Jobs', 'jobcircle-frame'), array($this, 'employe_jobs'), 'employer');
        add_meta_box('jobcircle-employ-posts', esc_html__('Select Banner', 'jobcircle-frame'), array($this, 'employ_post'), 'employer', 'side');
        add_meta_box('jobcircle-employ-posts', esc_html__('Select Banner', 'jobcircle-frame'), array($this, 'employ_post'), 'jobs', 'side');
        add_meta_box('jobcircle-employ-posts', esc_html__('Select Banner', 'jobcircle-frame'), array($this, 'employ_post'), 'candidates', 'side');

        add_meta_box('jobcircle-post', esc_html__('Post', 'jobcircle-frame'), array($this, 'post_field'), 'post');
        add_meta_box('jobcircle-candidate-purchased-packages', esc_html__('Purchased Packages', 'jobcircle-frame'), array($this, 'jobcircle_list_candidate_purchased_packages'), 'candidates', 'side');
        add_meta_box('jobcircle-employer-purchased-packages', esc_html__('Purchased Packages', 'jobcircle-frame'), array($this, 'jobcircle_list_employer_purchased_packages'), 'employer', 'side');
    }

    public function post_layout_meta()
    {
        global $jobcircle_framework_options, $post;
        $post_layout = get_post_meta($post->ID, 'jobcircle_field_post_layout', true);
        $post_sidebar = get_post_meta($post->ID, 'jobcircle_field_post_sidebar', true);
        $sidebars_array = array();
        $jobcircle_sidebars = isset($jobcircle_framework_options['jobcircle-themes-sidebars']) ? $jobcircle_framework_options['jobcircle-themes-sidebars'] : '';

        if (is_array($jobcircle_sidebars) && sizeof($jobcircle_sidebars) > 0) {
            foreach ($jobcircle_sidebars as $sidebar) {
                $sadbar_id = sanitize_title($sidebar);
                $sidebars_array[$sadbar_id] = $sidebar;
            }
        }
        ?>
        <div class="jobcircle-post-layout">
            <div class="jobcircle-element-field">

                <div class="elem-label">
                    <label><?php esc_html_e('Select Layout', 'jobcircle-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="jobcircle_field_post_layout">
                        <option value="full" <?php echo ($post_layout == 'full' ? ' selected' : '') ?>><?php esc_html_e('Full', 'jobcircle-frame') ?></option>
                        <option value="right" <?php echo ($post_layout == 'right' ? ' selected' : '') ?>><?php esc_html_e('Right Sidebar', 'jobcircle-frame') ?></option>
                        <option value="left" <?php echo ($post_layout == 'left' ? ' selected' : '') ?>><?php esc_html_e('Left Sidebar', 'jobcircle-frame') ?></option>
                    </select>
                </div>
            </div>
            <div class="jobcircle-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('Select Sidebar', 'jobcircle-frame') ?></label>
                </div>

                <div class="elem-field">
                    <select name="jobcircle_field_post_sidebar">
                        <option value="" <?php echo ($post_sidebar == '' ? ' selected' : '') ?>><?php esc_html_e('Select Sidebar', 'jobcircle-frame') ?></option>
                        <?php
                        if (!empty($sidebars_array)) {
                            foreach ($sidebars_array as $sidebar_id => $sidebar_title) {
                                ?>
                                <option value="<?php echo ($sidebar_id) ?>" <?php echo ($post_sidebar == $sidebar_id ? ' selected' : '') ?>><?php echo ($sidebar_title) ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    <?php
    }

    public function post_navigatin_meta()
    {
        global $post;

        $menu_style = get_post_meta($post->ID, 'jobcircle_field_sub_menu', true);
    ?>
        <div class="jobcircle-frame-post-layout">
            <div class="jobcircle-frame-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('Select Menu', 'jobcircle-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="jobcircle_field_sub_menu">
                        <option value=""><?php esc_html_e('Select Menu', 'jobcircle-frame') ?></option>
                        <?php
                        $menus = wp_get_nav_menus();
                        foreach ($menus as $menu) {
                        ?>
                            <option value="<?php echo $menu->slug ?>" <?php echo ($menu_style == $menu->slug ? 'selected' : '') ?>><?php echo $menu->name ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    <?php
    }


    public function list_framing_jobs()
    {

        global $jobcircle_countries_list, $jobcircle_countries_states_list, $post;

        //
        $job_id = $post->ID;

        $job_style_view = get_post_meta($job_id, 'jobcircle_field_job_detail_view', true);
        $jobcircle_featured_job = get_post_meta($job_id, 'jobcircle_field_featured_job', true);

        $job_type = get_post_meta($job_id, 'jobcircle_field_job_type', true);

        $application_deadline = get_post_meta($job_id, 'jobcircle_field_job_deadline', true);
        $min_salary = get_post_meta($job_id, 'jobcircle_field_min_salary', true);
        $max_salary = get_post_meta($job_id, 'jobcircle_field_max_salary', true);
        $expertiess = get_post_meta($job_id, 'jobcircle_field_expertiexs', true);
        $experiance = get_post_meta($job_id, 'jobcircle_field_experiance', true);

        $salary_unit = get_post_meta($job_id, 'jobcircle_field_salary_unit', true);
        $country = get_post_meta($job_id, 'jobcircle_field_loc_country', true);
        $state = get_post_meta($job_id, 'jobcircle_field_loc_state', true);

        $loc_city = get_post_meta($job_id, 'jobcircle_field_loc_city', true);
        $bgcolors = get_post_meta($job_id, 'jobcircle_field_bg_colors', true);

        $loc_zipcode = get_post_meta($job_id, 'jobcircle_field_loc_zipcode', true);
        $loc_address = get_post_meta($job_id, 'jobcircle_field_loc_address', true);
        $loc_latitude = get_post_meta($job_id, 'jobcircle_field_loc_latitude', true);
        $loc_longitude = get_post_meta($job_id, 'jobcircle_field_loc_longitude', true);
        $member = get_post_meta($job_id, 'jobcircle_field_member', true);
        $Site = get_post_meta($job_id, 'jobcircle_field_visit_site', true);
        $siteurl = get_post_meta($job_id, 'jobcircle_field_visit_site_url', true);
        $social_media = get_post_meta($job_id, 'jobcircle_field_social_media', true);
        $vacancies = get_post_meta($job_id, 'jobcircle_field_vacancies', true);
        $company_name = get_post_meta($job_id, 'jobcircle_field_company_name', true);

        $job_types_list = jobcircle_job_types_list($job_type);
        $salary_units_list = jobcircle_salary_units_list();

        wp_enqueue_script('jobcircle-job-map-api');
        wp_enqueue_script('jobcircle-location');

        //
        wp_enqueue_style('jobcircle-datetimepicker');
        wp_enqueue_script('jobcircle-datetimepicker-full');
    ?>
        <script>
            jQuery(document).ready(function() {
                if (jQuery('.jobcircle-datepicker').length > 0) {
                    var todayDate = new Date().getDate();
                    jQuery('.jobcircle-datepicker').datetimepicker({
                        maxDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
                if (jQuery('.jobcircle-datepicker-min').length > 0) {
                    jQuery('.jobcircle-datepicker-min').datetimepicker({
                        minDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
            });
        </script>
        <div class="jobcircle-list-famous-job">
            <div class="jobcircle-post-layout">
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Featured Job', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_featured_job">
                            <option value="normal" <?php echo ($jobcircle_featured_job == 'normal' ? ' selected' : '') ?>><?php esc_html_e('Normal', 'jobcircle-frame') ?></option>
                            <option value="featured" <?php echo ($jobcircle_featured_job == 'featured' ? ' selected' : '') ?>><?php esc_html_e('Featured', 'jobcircle-frame') ?></option>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Job Style', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_job_detail_view">
                            <option value=""><?php esc_html_e('Default View', 'jobcircle-frame') ?></option>
                            <option value="style1" <?php echo ($job_style_view == 'style1' ? ' selected' : '') ?>><?php esc_html_e('Style 1', 'jobcircle-frame') ?></option>
                            <option value="style2" <?php echo ($job_style_view == 'style2' ? ' selected' : '') ?>><?php esc_html_e('Style 2', 'jobcircle-frame') ?></option>
                            <option value="style3" <?php echo ($job_style_view == 'style3' ? ' selected' : '') ?>><?php esc_html_e('Style 3', 'jobcircle-frame') ?></option>
                            <option value="style4" <?php echo ($job_style_view == 'style4' ? ' selected' : '') ?>><?php esc_html_e('Style 4', 'jobcircle-frame') ?></option>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Job Type', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_job_type">
                            <?php
                            foreach ($job_types_list as $job_type_key => $job_type_ar) {
                            ?>
                                <option value="<?php echo ($job_type_key) ?>" <?php echo ($job_type_key == $job_type ? ' selected' : '') ?>><?php echo ($job_type_ar['title']) ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Application Deadline', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_job_deadline" class="jobcircle-datepicker-min" value="<?php echo ($application_deadline) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Member', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_member" value="<?php echo ($member) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Site', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_visit_site" value="<?php echo ($Site) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Site Url', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_visit_site_url" value="<?php echo ($siteurl) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Minimum Salary', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_min_salary" value="<?php echo ($min_salary) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Maximum Salary', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_max_salary" value="<?php echo ($max_salary) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Experties', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_expertiexs" value="<?php echo ($expertiess) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Experience', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_experiance" value="<?php echo ($experiance) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Salary Unit', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_salary_unit">
                            <?php
                            foreach ($salary_units_list as $salary_unit_key => $salary_unit_label) {
                                ?>
                                <option value="<?php echo ($salary_unit_key) ?>" <?php echo ($salary_unit == $salary_unit_key ? ' selected' : '') ?>><?php echo ($salary_unit_label) ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Country', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_loc_country" id="jobcircle-country" class="jobcircle-form-field">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('State', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('City', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" class="jobcircle-form-field" id="jobcircle-city" name="jobcircle_field_loc_city" value="<?php echo ($loc_city) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Zip Code*', 'jobcircle-frame');?></label>
                    <div class="input-detail">
                    <input type="text" class="jobcircle-form-field" id="jobcircle-zipcode" name="jobcircle_field_loc_zipcode" value="<?php echo jobcircle_esc_html($loc_zipcode) ?>" placeholder="<?php esc_attr_e('Enter zipcode', 'jobcircle-frame');?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Full Address', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" class="jobcircle-form-field" id="jobcircle-address" name="jobcircle_field_loc_address" value="<?php echo ($loc_address) ?>">
                        <input type="hidden" id="jobcircle-latitude" name="jobcircle_field_loc_latitude" value="<?php echo jobcircle_esc_html($loc_latitude) ?>">
                        <input type="hidden" id="jobcircle-longitude" name="jobcircle_field_loc_longitude" value="<?php echo jobcircle_esc_html($loc_longitude) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Social Media', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_social_media" value="<?php echo ($social_media) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Vacancies', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_vacancies" value="<?php echo ($vacancies) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Company name', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_company_name" value="<?php echo ($company_name) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Image url', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_image" value="">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Price', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_price" value="">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Background Color', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_bg_colors" value="<?php echo ($bgcolors) ?>" placeholder="Background-color ">
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    public function list_candidate_meta()
    {

        global $jobcircle_countries_list, $jobcircle_countries_states_list, $post;
        //
        $candidate_id = $post->ID;
        $job_style_view = get_post_meta($candidate_id, 'jobcircle_field_candidate_detail_view', true);
        $job_title = get_post_meta($candidate_id, 'jobcircle_field_job_title', true);
        $phone_number = get_post_meta($candidate_id, 'jobcircle_field_user_phone', true);
        $email = get_post_meta($candidate_id, 'jobcircle_field_user_email', true);
        $dob = get_post_meta($candidate_id, 'jobcircle_field_dob', true);
        $play_image = get_post_meta($candidate_id, 'jobcircle_field_play_image', true);
        $experience = get_post_meta($candidate_id, 'jobcircle_field_experience', true);
        $public_info = get_post_meta($candidate_id, 'jobcircle_field_public_info', true);
        $salary = get_post_meta($candidate_id, 'jobcircle_field_salary', true);
        $maxsalary = get_post_meta($candidate_id, 'jobcircle_field_max_salary', true);
        $salary_unit = get_post_meta($candidate_id, 'jobcircle_field_salary_unit', true);
        $facebook_url = get_post_meta($candidate_id, 'jobcircle_field_facebook_url', true);
        $twitter_url = get_post_meta($candidate_id, 'jobcircle_field_twitter_url', true);
        $linkedin_url = get_post_meta($candidate_id, 'jobcircle_field_linkedin_url', true);
        $google_url = get_post_meta($candidate_id, 'jobcircle_field_google_url', true);
        $country = get_post_meta($candidate_id, 'jobcircle_field_loc_country', true);
        $state = get_post_meta($candidate_id, 'jobcircle_field_loc_state', true);
        $loc_city = get_post_meta($candidate_id, 'jobcircle_field_loc_city', true);
        $loc_zipcode = get_post_meta($candidate_id, 'jobcircle_field_loc_zipcode', true);
        $loc_address = get_post_meta($candidate_id, 'jobcircle_field_loc_address', true);
        $loc_latitude = get_post_meta($candidate_id, 'jobcircle_field_loc_latitude', true);
        $loc_longitude = get_post_meta($candidate_id, 'jobcircle_field_loc_longitude', true);

        $salary_units_list = jobcircle_salary_units_list();

        wp_enqueue_script('jobcircle-job-map-api');
        wp_enqueue_script('jobcircle-location');
        //
        wp_enqueue_style('jobcircle-datetimepicker');
        wp_enqueue_script('jobcircle-datetimepicker-full');
    ?>
        <script>
            jQuery(document).ready(function() {
                if (jQuery('.jobcircle-datepicker').length > 0) {
                    var todayDate = new Date().getDate();
                    jQuery('.jobcircle-datepicker').datetimepicker({
                        maxDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
                if (jQuery('.jobcircle-datepicker-min').length > 0) {
                    jQuery('.jobcircle-datepicker-min').datetimepicker({
                        minDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
            });
        </script>
        <div class="jobcircle-list-famous-job">
            <div class="jobcircle-post-layout">


                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Job Style', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_candidate_detail_view">
                            <option value=""><?php esc_html_e('Default View', 'jobcircle-frame');?></option>
                            <option value="style1" <?php echo ($job_style_view == 'style1' ? ' selected' : '') ?>><?php esc_html_e('Style 1', 'jobcircle-frame');?></option>
                            <option value="style2" <?php echo ($job_style_view == 'style2' ? ' selected' : '') ?>><?php esc_html_e('Style 2', 'jobcircle-frame');?></option>
                            <option value="style3" <?php echo ($job_style_view == 'style3' ? ' selected' : '') ?>><?php esc_html_e('Style 3', 'jobcircle-frame');?></option>
                            <option value="style4" <?php echo ($job_style_view == 'style4' ? ' selected' : '') ?>><?php esc_html_e('Style 4', 'jobcircle-frame');?></option>
                        </select>
                    </div>
                </div>

                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Job Title', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_job_title" value="<?php echo ($job_title) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Phone', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_user_phone" value="<?php echo ($phone_number) ?>">
                    </div>
                </div>
                  <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Email', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_user_email" value="<?php echo ($email) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Date of Birth', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_dob" class="jobcircle-datepicker" value="<?php echo ($dob) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Contact info view (for public)', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_public_info">
                            <option value="yes" <?php echo ($public_info == 'yes' ? ' selected' : '') ?>><?php esc_html_e('Yes', 'jobcircle-frame') ?></option>
                            <option value="no" <?php echo ($public_info == 'no' ? ' selected' : '') ?>><?php esc_html_e('No', 'jobcircle-frame') ?></option>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Ico image', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_play_image" value="<?php echo ($play_image) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Experience', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_experience" value="<?php echo ($experience) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Min Salary', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_salary" value="<?php echo ($salary) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Max Salary', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_max_salary" value="<?php echo ($maxsalary) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Salary Unit', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_salary_unit">
                            <?php
                            foreach ($salary_units_list as $salary_unit_key => $salary_unit_label) {
                            ?>
                                <option value="<?php echo ($salary_unit_key) ?>" <?php echo ($salary_unit == $salary_unit_key ? ' selected' : '') ?>><?php echo ($salary_unit_label) ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Facebook', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_facebook_url" value="<?php echo ($facebook_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Twitter', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_twitter_url" value="<?php echo ($twitter_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('LinkedIn', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_linkedin_url" value="<?php echo ($linkedin_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('GooglePlus', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_google_url" value="<?php echo ($google_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Country', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_loc_country" id="jobcircle-country" class="jobcircle-form-field">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('State', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('City', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" class="jobcircle-form-field" id="jobcircle-city" name="jobcircle_field_loc_city" value="<?php echo ($loc_city) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Zip Code*', 'jobcircle-frame');?></label>
                    <div class="input-detail">
                    <input type="text" class="jobcircle-form-field" id="jobcircle-zipcode" name="jobcircle_field_loc_zipcode" value="<?php echo jobcircle_esc_html($loc_zipcode) ?>" placeholder="<?php esc_attr_e('Enter zipcode', 'jobcircle-frame');?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Full Address', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" class="jobcircle-form-field" id="jobcircle-address" name="jobcircle_field_loc_address" value="<?php echo ($loc_address) ?>">
                        <input type="hidden" id="jobcircle-latitude" name="jobcircle_field_loc_latitude" value="<?php echo jobcircle_esc_html($loc_latitude) ?>">
                        <input type="hidden" id="jobcircle-longitude" name="jobcircle_field_loc_longitude" value="<?php echo jobcircle_esc_html($loc_longitude) ?>">
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    public function jobcircle_list_candidate_purchased_packages()
    {
        global $post;
        $candidate_id = $post->ID;
        $candidate_purchased_packages = get_post_meta($candidate_id, 'candidate_purchased_packages', true);

        if ($candidate_purchased_packages) {
            $explode_candidate_purchased_packages = explode(",", $candidate_purchased_packages);
            if ($explode_candidate_purchased_packages) {
                echo '<div class="jobcircle-element-field">
                        <div class="elem-label">
                            <label>' . esc_html_e('Purchased Order IDs', 'jobcircle-frame') . '</label>
                        </div>';
                foreach ($explode_candidate_purchased_packages as $purchased_packages) {
                    echo '<div class="form-check">
                           <input class="form-check-input" type="checkbox" checked disabled>
                           <label class="form-check-label">' . $purchased_packages . '</label>
                          </div>';
                }
                echo '</div>';
            }
        } else {
            echo '<div class="jobcircle-element-field">
                        <div class="elem-label">
                            <label>' . esc_html_e('No Package Found', 'jobcircle-frame') . '</label>
                        </div>
                      </div>';
        }
    }

    public function jobcircle_list_employer_purchased_packages()
    {
        global $post;
        $employer_id = $post->ID;
        $employer_purchased_packages = get_post_meta($employer_id, 'employer_purchased_packages', true);

        if ($employer_purchased_packages) {
            $explode_employer_purchased_packages = explode(",", $employer_purchased_packages);
            if ($explode_employer_purchased_packages) {
                echo '<div class="jobcircle-element-field">
                        <div class="elem-label">
                            <label>' . esc_html_e('Purchased Order IDs', 'jobcircle-frame') . '</label>
                        </div>';
                foreach ($explode_employer_purchased_packages as $purchased_packages) {
                    echo '<div class="form-check">
                           <input class="form-check-input" type="checkbox" checked disabled>
                           <label class="form-check-label">' . $purchased_packages . '</label>
                          </div>';
                }
                echo '</div>';
            }
        } else {
            echo '<div class="jobcircle-element-field">
                        <div class="elem-label">
                            <label>' . esc_html_e('No Package Found', 'jobcircle-frame') . '</label>
                        </div>
                      </div>';
        }
    }

    public function sub_header()
    {
        global $jobcircle_framework_options, $post;

        $post_layout = get_post_meta($post->ID, 'jobcircle_field_sub_header', true);
    ?>
        <div class="jobcircle-frame-post-layout">
            <div class="jobcircle-frame-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('subheader ON & OFF', 'jobcircle-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="jobcircle_field_sub_header">

                        <option value="on" <?php echo ($post_layout == 'on' ? ' selected' : '') ?>><?php esc_html_e('ON', 'jobcircle-frame') ?></option>
                        <option value="off" <?php echo ($post_layout == 'off' ? ' selected' : '') ?>><?php esc_html_e('OFF', 'jobcircle-frame') ?></option>
                    </select>
                </div>
            </div>
        </div>
    <?php
    }

    public function post_sub_header()
    {
        global $jobcircle_framework_options, $post;
        $post_layout = get_post_meta($post->ID, 'jobcircle_field_sub_header', true);
        ?>
        <div class="jobcircle-frame-post-layout">
            <div class="jobcircle-frame-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('subheader ON & OFF', 'jobcircle-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="jobcircle_field_sub_header">
                        <option value="on" <?php echo ($post_layout == 'on' ? ' selected' : '') ?>><?php esc_html_e('ON', 'jobcircle-frame') ?></option>
                        <option value="off" <?php echo ($post_layout == 'off' ? ' selected' : '') ?>><?php esc_html_e('OFF', 'jobcircle-frame') ?></option>
                    </select>
                </div>
            </div>
        </div>
    <?php
    }

    public function column_size()
    {
        global $jobcircle_framework_options, $post;
        $post_layout = get_post_meta($post->ID, 'jobcircle_field_column_size', true);
        ?>
        <div class="jobcircle-frame-post-layout">
            <div class="jobcircle-frame-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('Column size for sidebar', 'jobcircle-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="jobcircle_field_column_size">

                        <option value="columnnine" <?php echo ($post_layout == 'columnnine' ? ' selected' : '') ?>><?php esc_html_e('Column 9 / 3', 'jobcircle-frame') ?></option>
                        <option value="columneight" <?php echo ($post_layout == 'columneight' ? ' selected' : '') ?>><?php esc_html_e('Column 8 / 4', 'jobcircle-frame') ?></option>
                    </select>
                </div>
            </div>
        </div>
    <?php
    }

    public function header_style()
    {
        global $jobcircle_framework_options, $post;

        $header_style = get_post_meta($post->ID, 'jobcircle_field_header_style', true);

    ?>
        <div class="jobcircle-frame-post-layout">
            <div class="jobcircle-frame-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('Select Header Style', 'jobcircle-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="jobcircle_field_header_style">
                        <option value=""><?php esc_html_e('Default', 'jobcircle-frame') ?></option>
                        <option value="style1" <?php echo ($header_style == 'style1' ? ' selected' : '') ?>><?php esc_html_e('Style 1', 'jobcircle-frame') ?></option>
                        <option value="style2" <?php echo ($header_style == 'style2' ? ' selected' : '') ?>><?php esc_html_e('Style 2', 'jobcircle-frame') ?></option>
                        <option value="style3" <?php echo ($header_style == 'style3' ? ' selected' : '') ?>><?php esc_html_e('Style 3', 'jobcircle-frame') ?></option>
                        <option value="style4" <?php echo ($header_style == 'style4' ? ' selected' : '') ?>><?php esc_html_e('Style 4', 'jobcircle-frame') ?></option>
                        <option value="style5" <?php echo ($header_style == 'style5' ? ' selected' : '') ?>><?php esc_html_e('Style 5', 'jobcircle-frame') ?></option>
                        <option value="style6" <?php echo ($header_style == 'style6' ? ' selected' : '') ?>><?php esc_html_e('Style 6', 'jobcircle-frame') ?></option>
                        <option value="style7" <?php echo ($header_style == 'style7' ? ' selected' : '') ?>><?php esc_html_e('Style 7', 'jobcircle-frame') ?></option>
                        <option value="style8" <?php echo ($header_style == 'style8' ? ' selected' : '') ?>><?php esc_html_e('Style 8', 'jobcircle-frame') ?></option>
                        <option value="style9" <?php echo ($header_style == 'style9' ? ' selected' : '') ?>><?php esc_html_e('Style 9', 'jobcircle-frame') ?></option>
                        <option value="style10" <?php echo ($header_style == 'style10' ? ' selected' : '') ?>><?php esc_html_e('Style 10', 'jobcircle-frame') ?></option>
                        <option value="style11" <?php echo ($header_style == 'style11' ? ' selected' : '') ?>><?php esc_html_e('Style 11', 'jobcircle-frame') ?></option>
                        <option value="style12" <?php echo ($header_style == 'style12' ? ' selected' : '') ?>><?php esc_html_e('Style 12', 'jobcircle-frame') ?></option>
                        <option value="style13" <?php echo ($header_style == 'style13' ? ' selected' : '') ?>><?php esc_html_e('Style 13', 'jobcircle-frame') ?></option>
                        <option value="style14" <?php echo ($header_style == 'style14' ? ' selected' : '') ?>><?php esc_html_e('Style 14', 'jobcircle-frame') ?></option>
                        <option value="style15" <?php echo ($header_style == 'style15' ? ' selected' : '') ?>><?php esc_html_e('Style 15', 'jobcircle-frame') ?></option>
                        <option value="style16" <?php echo ($header_style == 'style16' ? ' selected' : '') ?>><?php esc_html_e('Style 16', 'jobcircle-frame') ?></option>
                        <option value="style17" <?php echo ($header_style == 'style17' ? ' selected' : '') ?>><?php esc_html_e('Style 17', 'jobcircle-frame') ?></option>
                        <option value="style60" <?php echo ($header_style == 'style60' ? ' selected' : '') ?>><?php esc_html_e('Style 60', 'jobcircle-frame') ?></option>
                    </select>
                </div>
            </div>
        </div>
    <?php
    }

    public function footer_style()
    {
        global $jobcircle_framework_options, $post;

        $footer_style = get_post_meta($post->ID, 'jobcircle_field_footer_style', true);

    ?>
        <div class="jobcircle-frame-post-layout">
            <div class="jobcircle-frame-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('Select Footer Style', 'jobcircle-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="jobcircle_field_footer_style">
                        <option value=""><?php esc_html_e('Default', 'jobcircle-frame') ?></option>
                        <option value="style1" <?php echo ($footer_style == 'style1' ? ' selected' : '') ?>><?php esc_html_e('Style 1', 'jobcircle-frame') ?></option>
                        <option value="style2" <?php echo ($footer_style == 'style2' ? ' selected' : '') ?>><?php esc_html_e('Style 2', 'jobcircle-frame') ?></option>
                        <option value="style3" <?php echo ($footer_style == 'style3' ? ' selected' : '') ?>><?php esc_html_e('Style 3', 'jobcircle-frame') ?></option>
                        <option value="style4" <?php echo ($footer_style == 'style4' ? ' selected' : '') ?>><?php esc_html_e('Style 4', 'jobcircle-frame') ?></option>
                        <option value="style5" <?php echo ($footer_style == 'style5' ? ' selected' : '') ?>><?php esc_html_e('Style 5', 'jobcircle-frame') ?></option>
                        <option value="style6" <?php echo ($footer_style == 'style6' ? ' selected' : '') ?>><?php esc_html_e('Style 6', 'jobcircle-frame') ?></option>
                        <option value="style7" <?php echo ($footer_style == 'style7' ? ' selected' : '') ?>><?php esc_html_e('Style 7', 'jobcircle-frame') ?></option>
                        <option value="style8" <?php echo ($footer_style == 'style8' ? ' selected' : '') ?>><?php esc_html_e('Style 8', 'jobcircle-frame') ?></option>
                        <option value="style9" <?php echo ($footer_style == 'style9' ? ' selected' : '') ?>><?php esc_html_e('Style 9', 'jobcircle-frame') ?></option>
                        <option value="style10" <?php echo ($footer_style == 'style10' ? ' selected' : '') ?>><?php esc_html_e('Style 10', 'jobcircle-frame') ?></option>
                        <option value="style11" <?php echo ($footer_style == 'style11' ? ' selected' : '') ?>><?php esc_html_e('Style 11', 'jobcircle-frame') ?></option>
                        <option value="style12" <?php echo ($footer_style == 'style12' ? ' selected' : '') ?>><?php esc_html_e('Style 12', 'jobcircle-frame') ?></option>
                        <option value="style13" <?php echo ($footer_style == 'style13' ? ' selected' : '') ?>><?php esc_html_e('Style 13', 'jobcircle-frame') ?></option>
                        <option value="style14" <?php echo ($footer_style == 'style14' ? ' selected' : '') ?>><?php esc_html_e('Style 14', 'jobcircle-frame') ?></option>
                        <option value="style15" <?php echo ($footer_style == 'style15' ? ' selected' : '') ?>><?php esc_html_e('Style 15', 'jobcircle-frame') ?></option>
                        <option value="style16" <?php echo ($footer_style == 'style16' ? ' selected' : '') ?>><?php esc_html_e('Style 16', 'jobcircle-frame') ?></option>
                        <option value="style17" <?php echo ($footer_style == 'style17' ? ' selected' : '') ?>><?php esc_html_e('Style 17', 'jobcircle-frame') ?></option>
                        <option value="style60" <?php echo ($footer_style == 'style60' ? ' selected' : '') ?>><?php esc_html_e('Style 60', 'jobcircle-frame') ?></option>
                    </select>
                </div>
            </div>
        </div>
    <?php
    }


    public function employe_jobs()
    {
        global $jobcircle_countries_list, $jobcircle_countries_states_list, $post;

        $employer_id = $post->ID;

        $company_style_view = get_post_meta($employer_id, 'jobcircle_field_company_detail_view', true);

        $phone_number = get_post_meta($employer_id, 'jobcircle_field_user_phone', true);
        $email = get_post_meta($employer_id, 'jobcircle_field_user_email', true);
        $open_job = get_post_meta($employer_id, 'jobcircle_field_user_open_job', true);
        $availiablejobs = get_post_meta($employer_id, 'jobcircle_field_available_job_for_users', true);
        $pric = get_post_meta($employer_id, 'jobcircle_field_user_pric', true);
        $icon_image = get_post_meta($employer_id, 'jobcircle_field_user_icon_image', true);
        $imageurlll = get_post_meta($employer_id, 'jobcircle_field_user_image_url', true);
        $Designation = get_post_meta($employer_id, 'jobcircle_field_Designation', true);
        $dob = get_post_meta($employer_id, 'jobcircle_field_founded_date', true);
        $public_info = get_post_meta($employer_id, 'jobcircle_field_public_info', true);
        $facebook_url = get_post_meta($employer_id, 'jobcircle_field_facebook_url', true);
        $twitter_url = get_post_meta($employer_id, 'jobcircle_field_twitter_url', true);
        $linkedin_url = get_post_meta($employer_id, 'jobcircle_field_linkedin_url', true);
        $google_url = get_post_meta($employer_id, 'jobcircle_field_google_url', true);
        $country = get_post_meta($employer_id, 'jobcircle_field_loc_country', true);
        $state = get_post_meta($employer_id, 'jobcircle_field_loc_state', true);
        $loc_zipcode = get_post_meta($employer_id, 'jobcircle_field_loc_zipcode', true);
        $loc_city = get_post_meta($employer_id, 'jobcircle_field_loc_city', true);
        $loc_address = get_post_meta($employer_id, 'jobcircle_field_loc_address', true);
        $loc_latitude = get_post_meta($employer_id, 'jobcircle_field_loc_latitude', true);
        $loc_longitude = get_post_meta($employer_id, 'jobcircle_field_loc_longitude', true);
        $vacancies = get_post_meta($employer_id, 'jobcircle_field_vacancies', true);

        wp_enqueue_script('jobcircle-job-map-api');
        wp_enqueue_script('jobcircle-location');
        //
        wp_enqueue_style('jobcircle-datetimepicker');
        wp_enqueue_script('jobcircle-datetimepicker-full');
    ?>
        <script>
            jQuery(document).ready(function() {
                if (jQuery('.jobcircle-datepicker').length > 0) {
                    var todayDate = new Date().getDate();
                    jQuery('.jobcircle-datepicker').datetimepicker({
                        maxDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
                if (jQuery('.jobcircle-datepicker-min').length > 0) {
                    jQuery('.jobcircle-datepicker-min').datetimepicker({
                        minDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
            });
        </script>
        <div class="jobcircle-list-famous-job">
            <div class="jobcircle-post-layout">
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Job Style', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_company_detail_view">
                            <option value="">Default View</option>
                            <option value="style1" <?php echo ($company_style_view == 'style1' ? ' selected' : '') ?>>Style 1</option>
                            <option value="style2" <?php echo ($company_style_view == 'style2' ? ' selected' : '') ?>>Style 2</option>
                            <option value="style3" <?php echo ($company_style_view == 'style3' ? ' selected' : '') ?>>Style 3</option>
                            <option value="style4" <?php echo ($company_style_view == 'style4' ? ' selected' : '') ?>>Style 4</option>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Phone', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_user_phone" value="<?php echo ($phone_number) ?>">
                    </div>
                </div>
                 <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Email', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_user_email" value="<?php echo ($email) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Designation', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_Designation" value="<?php echo ($Designation) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Founded Date', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_founded_date" class="jobcircle-datepicker" value="<?php echo ($dob) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Contact info view (for public)', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_public_info">
                            <option value="yes" <?php echo ($public_info == 'yes' ? ' selected' : '') ?>><?php esc_html_e('Yes', 'jobcircle-frame') ?></option>
                            <option value="no" <?php echo ($public_info == 'no' ? ' selected' : '') ?>><?php esc_html_e('No', 'jobcircle-frame') ?></option>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Totall Open Jobs', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_user_open_job" value="<?php echo ($open_job) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Totall Available Jobs', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_available_job_for_users" value="<?php echo ($availiablejobs) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Price', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_user_pric" value="<?php echo ($pric) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Icon Image ', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_user_icon_image" value="<?php echo ($icon_image) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Image Url', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_user_image_url" value="<?php echo ($imageurlll) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Facebook', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_facebook_url" value="<?php echo ($facebook_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Twitter', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_twitter_url" value="<?php echo ($twitter_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('LinkedIn', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_linkedin_url" value="<?php echo ($linkedin_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('GooglePlus', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_google_url" value="<?php echo ($google_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Country', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_loc_country" id="jobcircle-country" class="jobcircle-form-field">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('State', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('City', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" class="jobcircle-form-field" id="jobcircle-city" name="jobcircle_field_loc_city" value="<?php echo ($loc_city) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Zip Code*', 'jobcircle-frame');?></label>
                    <div class="input-detail">
                    <input type="text" class="jobcircle-form-field" id="jobcircle-zipcode" name="jobcircle_field_loc_zipcode" value="<?php echo jobcircle_esc_html($loc_zipcode) ?>" placeholder="<?php esc_attr_e('Enter zipcode', 'jobcircle-frame');?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Full Address', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" class="jobcircle-form-field" id="jobcircle-address" name="jobcircle_field_loc_address" value="<?php echo ($loc_address) ?>">
                        <input type="hidden" id="jobcircle-latitude" name="jobcircle_field_loc_latitude" value="<?php echo jobcircle_esc_html($loc_latitude) ?>">
                        <input type="hidden" id="jobcircle-longitude" name="jobcircle_field_loc_longitude" value="<?php echo jobcircle_esc_html($loc_longitude) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Vacancies', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <input type="text" name="jobcircle_field_vacancies" value="<?php echo ($vacancies) ?>">
                    </div>
                </div>

            </div>
        </div>
    <?php
    }
    public function top_cate_jobs()
    {
        global $jobcircle_framework_options, $post;


        $time_tag = get_post_meta($post->ID, 'jobcircle_field_time_tag', true);

    ?>
        <div class="jobcircle-list-famous-job">
            <div class="jobcircle-post-layout">

                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Image', 'jobcircle-frame') ?></label>
                    <input class="input-detail" type="file" name="jobcircle_field_time_tag" value="<?php echo $time_tag ?>">
                </div>

            </div>
        </div>

    <?php
    }

    public function post_field()
    {
        global $jobcircle_framework_options, $post;


        $designation_post = get_post_meta($post->ID, 'jobcircle_field_designation_post', true);
        $post_style_view = get_post_meta($post->ID, 'jobcircle_field_post_detail_view', true);
    ?>
        <div class="jobcircle-list-famous-job">
            <div class="jobcircle-post-layout">

                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Job Style', 'jobcircle-frame') ?></label>
                    <div class="input-detail">
                        <select name="jobcircle_field_post_detail_view">
                            <option value=""><?php esc_html_e('Default View', 'jobcircle-frame'); ?></option>
                            <option value="style1" <?php echo ($post_style_view == 'style1' ? ' selected' : '') ?>>Style 1</option>
                            <option value="style2" <?php echo ($post_style_view == 'style2' ? ' selected' : '') ?>>Style 2</option>
                            <option value="style3" <?php echo ($post_style_view == 'style3' ? ' selected' : '') ?>>Style 3</option>
                            <option value="style4" <?php echo ($post_style_view == 'style4' ? ' selected' : '') ?>>Style 4</option>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Designation Post', 'jobcircle-frame') ?></label>
                    <input class="input-detail" type="text" name="jobcircle_field_designation_post" value="<?php echo $designation_post ?>">
                </div>
            </div>
        </div>

    <?php
    }
    public function employ_post()
    {
        global $jobcircle_framework_options, $post;
        $banner_img = get_post_meta($post->ID, 'jobcircle_field_banner_img', true);
        ?>
        <div class="jobcircle-list-famous-job">
            <div class="jobcircle-post-layout">

                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Banner Image', 'jobcircle-frame') ?></label>
                    <input class="input-detail" type="media" name="jobcircle_field_banner_img" value="<?php echo $banner_img ?>">
                </div>
            </div>
        </div>
        <?php
    }
}

new Jobcircle_Meta_Boxes;
