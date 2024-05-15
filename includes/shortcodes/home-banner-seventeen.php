<?php
function home_banner_14()
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
			'name' => __('Banner 17'),
			'base' => 'home_banner_14',
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
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Discription'),
					'param_name' => 'disc',
				),
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Main Image'),
					'param_name' => 'main_image',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Title'),
					'param_name' => 'title',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Url'),
					'param_name' => 'url',
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
add_action('vc_before_init', 'home_banner_14');

//welcome Massage frontend
function home_banner_14_frontend($atts, $content)
{
global $jobcircle_framework_options;
	$atts = shortcode_atts(
		array(

			'heading' => '',
			'disc' => '',
			'main_image' => '',
			'title' => '',
			'url' => '',
			'checkbox_param' => '',
			'jobcircle_page' => '',

		), $atts, 'home_banner_14'
	);

	$heading = isset($atts['heading']) ? $atts['heading'] : '';
	$disc = isset($atts['disc']) ? $atts['disc'] : '';
	$main_image = isset($atts['main_image']) ? $atts['main_image'] : '';
	$title = isset($atts['title']) ? $atts['title'] : '';
	$url = isset($atts['url']) ? $atts['url'] : '';
	$jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';
	$custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
	$checkbox_param = isset($atts['checkbox_param']) ? $atts['checkbox_param'] : '';
	$job_type_arr = !empty($checkbox_param) ? explode(',', $checkbox_param) : '';
	ob_start()
		?>
<div class="visual-block visual-theme-17 pt-80 pt-md-100 pt-lg-120 pt-xl-210 pb-50 pb-md-80 pb-lg-165 text-white">
    <div class="container position-relative">
        <div class="row justify-content-between">
            <div class="col-12 col-lg-7 col-xl-7 position-relative">
                <!-- visual textbox -->
                <div class="visual-textbox">
                    <?php if (!empty($heading)) {
							?>
                    <h1>
                        <?php echo esc_html($heading) ?>
                    </h1>
                    <?php }
						if (!empty($disc)) { ?>
                    <p>
                        <?php echo esc_html($disc) ?>
                    </p>
                    <?php }
                    	$job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);?>
                    <!-- search form -->
                    <form class="form-search" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
                        <div class="fields-holder bg-white text-black d-flex flex-wrap flex-md-nowrap">
                            	<div class="form-group">
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php esc_html_e('Job Title, Keyword.....', 'jobcircle-frame') ?>">

								</div>
                            <div class="form-group bar-icon">
								<div class="icon pb-0 "><i class="forms-jin"><img src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "20" alt ="category icon"></i></div>
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
                        <button class="btn btn-orange btn-sm" type="submit"><span class="btn-text">
                                <?php echo esc_html_e('Find Job', 'jobcircle-frame') ?>
                            </span></button>
                    </form>
                    <div class="searches_holder">
                        <span class="search_result"><strong>
                                <?php echo esc_html_e('Searches :', 'jobcircle-frame') ?>
                            </strong>
                            <?php
								$include_category_ids = $job_type_arr;
								// Fetch the terms for the custom taxonomy 'job_featured'
								$terms = get_terms(
									array(
										'taxonomy' => 'job_category',
										'post_type' => 'jobs',
										'hide_empty' => false,
										'parent' => 0,
										'include' => $include_category_ids,
									)
								);
								$counter = 0;
								foreach ($terms as $term) {
									if ($counter <=3) {
										// Query to get the post count for each term
										$args = array(
											'post_type' => 'jobs',
											'tax_query' => array(
												array(
													'taxonomy' => 'job_category',
													'field' => 'term_id',
													'terms' => $term->term_id,
												),
											),
										);
										$jobcircle_page_id = jobcircle_get_page_id_from_name($jobcircle_page);

										$jobcircle_page_url = home_url('/');
										if ($jobcircle_page_id > 0) {
											$jobcircle_page_url = get_permalink($jobcircle_page_id);
										}
										?>
                            <?php if (!empty($jobcircle_page_url) || !empty($term)) {
											?>
                            <a class="cat-color-theme-14"
                                href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>  ">
                                <?php } ?>
                                <?php echo esc_html($term->name);
                                 echo ($counter <=1) ? ', ' : ''; ?>
                            </a>
                            <?php
										$counter++;
									} else {
										break;
									}
								}
								?>
                        </span>
                        <a class="btn_upload" href="<?php echo esc_html($url) ?>">
                            <i class="jobcircle-icon-upload-cloud icon"></i>
                            <span class="text">
                                <?php echo esc_html($title) ?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 col-xl-5 d-flex justify-content-center justify-content-center">
                <!-- visual Image -->
                <div class="visual-image position-relative">
                    <?php if (!empty($main_image)) {
							?>
                    <img src="<?php echo esc_html($main_image) ?>" alt="img">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
	return ob_get_clean();
}
add_shortcode('home_banner_14', 'home_banner_14_frontend');