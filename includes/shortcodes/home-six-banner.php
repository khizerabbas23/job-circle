<?php
function jobcircle_banner_h_six()
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
            'name' => __('Home Six Banner'),
            'base' => 'jc_banner_h_six',
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
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Discription'),
                    'param_name' => 'disc',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Before Image'),
                    'param_name' => 'before_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('After Image'),
                    'param_name' => 'after_img',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Banner Image Left'),
                    'param_name' => 'ban_img_left',
                ),
                array(
                    'type' => 'jobcircle_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Banner Image Right'),
                    'param_name' => 'ban_img_right',
                ),
                                array(
                    'type' => 'checkbox',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Checkbox Options'),
                    'param_name' => 'checkbox_param',
                    'value' => $job_types,
                ),
            )
        )
    );
}
add_action('vc_before_init', 'jobcircle_banner_h_six');
//welcome Massage frontend
function jobcircle_banner_h_six_frontend($atts, $content)
{
    	global $jobcircle_framework_options;
    $atts = shortcode_atts(
        array(

            'heading' => '',
            'disc' => '',
            'ban_img_left' => '',
            'ban_img_right' => '',
            'before_img' => '',
            'after_img' => '',
            'jobcircle_page' => '',
            'papular_searche' => '',
            'checkbox_param' => '',
        ),
        $atts, 'jobcircle_banner_h_six');

    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $disc = isset($atts['disc']) ? $atts['disc'] : '';
    $ban_img_left = isset($atts['ban_img_left']) ? $atts['ban_img_left'] : '';
    $ban_img_right = isset($atts['ban_img_right']) ? $atts['ban_img_right'] : '';
    $before_img = isset($atts['before_img']) ? $atts['before_img'] : '';
    $after_img = isset($atts['after_img']) ? $atts['after_img'] : '';
    $jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
     $checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
    $job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
    $output = '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    ob_start(); ?>

    <div class="visual-block visual-theme-3 banner_sixm pt-40 pt-md-65 pb-40 pb-md-55 pb-xl-70">
        <div class="container position-relative">
            <div class="row justify-content-between">
                <div class="col-12 position-relative">
                    <!-- visual textbox -->
                    <div class="visual-textbox">
                        <?php
                        if (!empty($heading)) { ?>
                            <h1>
                                <?php echo esc_html($heading) ?>
                            </h1>
                        <?php } ?>
                        <?php
                        if (!empty($disc)) { ?>
                            <p>
                                <?php echo esc_textarea($disc) ?>
                            </p>
                        <?php }
                        $job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
						?>
                        <!-- search form -->
                        <form class="form-search" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
                            <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                               <div class="form-group">
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php esc_html_e('Search Job Title', 'jobcircle-frame') ?>">
								</div>
                                <div class="form-group">
                  	<span class="icon mt-10"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "20" alt ="category icon"></span>
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
                            <button class="btn btn-brown btn-sm" type="submit"><span class="btn-text">
                                    <?php echo esc_html_e('Find Job', 'jobcircle-frame') ?>
                                </span></button>
                        </form>
                        <div class="popular-searches">
                            <strong class="subtitle">
                                <?php esc_html_e('Popular Searches:', 'jobcircle-frame') ?>
                            </strong>
                            <ul>
                                <?php
                                 $include_category_ids = $job_type_arr;
                                $terms = get_terms(array(
                                    'taxonomy' => 'job_category',
                                    'post_type' => 'jobs',
                                    'hide_empty' => true,
                                    'include' => $include_category_ids,
                                )
                                );
                                $counter = 0;
                                foreach ($terms as $term) {

                                    if ($counter < 12) {
                                        $args = array(
                                            'post_type' => 'jobs',
                                            'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'job_category',
                                                    'field' => 'term_id',
                                                    'terms' => $term->term_id,
                                                    'include' => $include_category_ids,
                                                ),
                                            ),
                                        );
                                        $term_id = $term->term_id;
                                        $category_link = get_category_link($term_id);
                                        $jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);
                                        $jobcircle_page_url = home_url('/');
                                        if ($jobcircle_page_id > 0) {
                                            $jobcircle_page_url = get_permalink($jobcircle_page_id);
                                        }
                                        if (!empty($jobcircle_page_url || $term)) {
                                            ?>
                                            <li><a
                                                    href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                                                    <?php echo esc_html($term->name); ?>
                                                </a></li>
                                        <?php
                                        }
                                        $counter++;
                                    } else {
                                        break;
                                    }
                                } ?>
                            </ul>
                        </div>
                        <div class="visual-avatars left">
                            <?php
                            if (!empty($ban_img_left)) { ?>
                                <img src="<?php echo esc_url_raw($ban_img_left) ?>" width="255" height="328"
                                    alt="Image Description">
                            <?php } ?>
                        </div>
                        <div class="visual-avatars right">
                            <?php
                            if (!empty($ban_img_right)) { ?>
                                <img src="<?php echo esc_url_raw($ban_img_right) ?>" width="520" height="428"
                                    alt="Image Description">
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('jc_banner_h_six', 'jobcircle_banner_h_six_frontend');