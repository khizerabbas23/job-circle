<?php
function home_twlve_banner()
{
      $terms = get_terms(
		array(
			'taxonomy' => 'job_category',
			'hide_empty' => true,
		)
	);
	$job_types = array();
	foreach ($terms as $term) {
		$job_types[$term->name] = $term->term_id;
	}
	;
    $all_page = array(__('Select Page', 'jobcircle-frame'), '');
    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'meta_key' => '',
        'meta_value' => '',
        'authors' => '',
        'child_of' => 0,
        'parent' => -1,
        'exclude_tree' => '',
        'number' => '',
        'offset' => 0,
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $pages = get_pages($args);
    if (!empty($pages)) {
        foreach ($pages as $page) {
            $all_page[$page->post_title] = $page->post_name;
        }
    }
    vc_map(
        array(
            'name' => __('Home 12 Banner'),
            'base' => 'home_twlve_banner',
            'category' => __('Job Circle'),
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Jobcircle Page', 'jobcircle-frame'),
                    'param_name' => 'jobcircle_page',
                    'description' => __('Select Jobcircle Page', 'jobcircle-frame'),
                    'value' => $all_page,
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Background Image'),
                    'param_name' => 'bg_image',
                ),
                     array(
		  'type' => 'checkbox',
		  'holder' => 'div',
		  'class' => '',
		  'heading' => __('Checkbox Options'),
		  'param_name' => 'checkbox_param',
		  'value' => $job_types,
		  ),
                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'home_twlve_banner_multi',
                    'params' => array(
                        array(
                            'type' => 'jobcircle_browse_img',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Social Image'),
                            'param_name' => 'social_image',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Social Url'),
                            'param_name' => 'social_url',
                        ),

                    )
                )
            ),
        )
    );
}
add_action('vc_before_init', 'home_twlve_banner');

//welcome Massage frontend
function home_twlve_banner_frontend($atts, $content)
{
    global $jobcircle_framework_options;
    $atts = shortcode_atts(
        array(

            'title' => '',
            'heading' => '',
            'bg_image' => '',
            'checkbox_param' => '',
            'jobcircle_page' => '',
            'home_twlve_banner_multi' => '',

        ), $atts, 'home_twlve_banner'
    );

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $bg_image = isset($atts['bg_image']) ? $atts['bg_image'] : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
     $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
     $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';

    ob_start();
    if (!empty($bg_image)) {
        ?>
        <div class="visual-block pb-45 pb-md-140 visal-theme-11"
            style="background-image: url('<?php echo esc_url_raw($bg_image) ?>');">
            <?php
    } ?>
        <div class="container position-relative">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 pb-30 mb-lg-0">
                    <!-- visual textbox -->
                    <div class="visual-textbox text-black">
                        <?php
                        if (!empty($title)) {
                            ?>
                            <p>
                                <?php echo esc_html($title) ?>
                            </p>
                            <?php
                        }
                        if (!empty($heading)) {
                            ?>
                            <h1>
                                <?php echo ($heading) ?>
                            </h1>
                            <?php
                        }
                        $job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
                        ?>
                        <!-- search form -->
                        <form class="form-search d-flex flex-column flex-lg-row justify-content-between" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                                <div class="form-group">
									<i class="jobcircle-icon-search icon pbt26"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php esc_html_e('Search Job Title', 'jobcircle-frame') ?>">
								</div>
                                <div class="form-group">
                                    <i class="jobcircle-icon-map-pin icon pbt26"></i>
                                    <input class="form-control" name="location"
										placeholder="<?php esc_html_e('City and Postal Code', 'jobcircle-frame') ?>">
                                </div>
                                	<div class="form-group">
						<span class="icon mt-10"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "23" alt ="category icon"></span>
									<select class="select2" name="job_category"
										data-placeholder="<?php esc_html_e('Choose Category', 'jobcircle-frame') ?>">
										<option label="Placeholder"></option>
										<?php
										$cat_terms = get_terms(
											array(
												'taxonomy' => 'job_category',
											)
										);
										if (!empty($cat_terms)) {
											foreach ($cat_terms as $cat_term) {
												?>
												<option value="<?php echo esc_html($cat_term->slug) ?>"
													id="cat-<?php echo esc_html($cat_term->term_id) ?>">
													<?php echo esc_attr($cat_term->name) ?>
												</option>
												<?php
											}
											;
										}
										?>
									</select>
								</div>
                            </div>
                            <button class="btn btn-sm" type="submit">
                                <span class="btn-text">
                                    <?php echo esc_html_e('Find Jobs', 'jobcircle-frame') ?>
                                </span>
                            </button>
                        </form>
                        <p class="mb-0"><strong>
                                <?php echo esc_html_e('Searches : ', 'jobcircle-frame') ?>
                            </strong>
                            <?php
                             $include_category_ids = $job_type_arr;
                             $shahzaib = count($include_category_ids);
                            // Fetch the terms for the custom taxonomy 'job_featured'
                            $terms = get_terms(
                                array(
                                    'taxonomy' => 'job_category',
                                    'post_type' => 'jobs',
                                    'hide_empty' => false,
                                    'parent' => 0,
                                    'include' => $include_category_ids,
                                    'orderby' => 'term_id',
                                )
                            );

                            $counter = 0;
                            foreach ($terms as $term) {
                                    $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                                    $jobcircle_page_url = home_url('/');
                                    if ($jobcircle_page_id > 0) {
                                        $jobcircle_page_url = get_permalink($jobcircle_page_id);
                                    }
                                    if (!empty($jobcircle_page_url) || !empty($term)) {
                                        ?>
                                        <a class="cat-color-theme-12"
                                            href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                            <?php echo esc_html($term->name) ?><?php echo ($counter < $shahzaib) ? ',': ''; ?> 
                                        </a>
                                        <?php
                                    }
                                    $counter++;
                            }
                            ?>
                        <ul class="social-icons">
                            <?php
                            $lm_team_list = vc_param_group_parse_atts($atts['home_twlve_banner_multi']);
                            foreach ($lm_team_list as $key => $value) {
                              
                                $social_image = isset($value['social_image']) ? $value['social_image'] : '';
                                $social_url = isset($value['social_url']) ? $value['social_url'] : '';
                                
                                ?>
                                <li>
                                    <a href="<?php echo esc_html($social_url) ?>">
                                        <img src="<?php echo esc_url_raw($social_image) ?>" alt="slack">
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="circle-image"></div>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('home_twlve_banner', 'home_twlve_banner_frontend');