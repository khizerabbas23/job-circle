<?php
function jobcircle_postings_here_for_you()
{
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
			'name' => __('Banner 14'),
			'base' => 'postings_here_for_you',
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
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Main Bg Image'),
					'param_name' => 'main_bg_img',
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
					'heading' => __('Span title'),
					'param_name' => 'span_title',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Discription'),
					'param_name' => 'disc',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Search Placeholder'),
					'param_name' => 'search_place',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Location placeholder'),
					'param_name' => 'location_place',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Search Button'),
					'param_name' => 'search_button',
				),

				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Upload Your CV'),
					'param_name' => 'upload_cv',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Hiring'),
					'param_name' => 'hiring',
				),
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Image'),
					'param_name' => 'img',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Candidates'),
					'param_name' => 'candidates',
				),
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Avatar Image'),
					'param_name' => 'avatar_img_one',
				),
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Avatar Image'),
					'param_name' => 'avatar_img_two',
				),
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Avatar Image'),
					'param_name' => 'avatar_img_three',
				),
				array(
					'type' => 'iconpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Plus Icon'),
					'param_name' => 'plus_icon',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Upload CV Button Link'),
					'param_name' => 'upload_button_link',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Button Hiring Link'),
					'param_name' => 'hiring_button_link',
				),

			)
		)
	);

}
add_action('vc_before_init', 'jobcircle_postings_here_for_you');

//welcome Massage frontend
function jobcircle_postings_here_for_you_frontend($atts, $content)
{
	global $jobcircle_framework_options;
	$atts = shortcode_atts(
		array(

			'title' => '',
			'span_title' => '',
			'disc' => '',
			'search_place' => '',
			'location_place' => '',
			'search_button' => '',

			'upload_cv' => '',
			'hiring' => '',
			'main_bg_img' => '',
			'img' => '',
			'candidates' => '',
			'avatar_img_one' => '',
			'avatar_img_two' => '',
			'avatar_img_three' => '',
			'plus_icon' => '',
			'upload_button_link' => '',
			'hiring_button_link' => '',
			'jobcircle_page' => '',
		), $atts, 'jobcircle_postings_here_for_you'
	);

	$title = isset($atts['title']) ? $atts['title'] : '';
	$span_title = isset($atts['span_title']) ? $atts['span_title'] : '';
	$disc = isset($atts['disc']) ? $atts['disc'] : '';
	$search_place = isset($atts['search_place']) ? $atts['search_place'] : '';
	$location_place = isset($atts['location_place']) ? $atts['location_place'] : '';
	$search_button = isset($atts['search_button']) ? $atts['search_button'] : '';

	$upload_cv = isset($atts['upload_cv']) ? $atts['upload_cv'] : '';
	$hiring = isset($atts['hiring']) ? $atts['hiring'] : '';

	$main_bg_img = isset($atts['main_bg_img']) ? $atts['main_bg_img'] : '';
	$img = isset($atts['img']) ? $atts['img'] : '';
	$candidates = isset($atts['candidates']) ? $atts['candidates'] : '';
	$avatar_img_one = isset($atts['avatar_img_one']) ? $atts['avatar_img_one'] : '';
	$avatar_img_two = isset($atts['avatar_img_two']) ? $atts['avatar_img_two'] : '';
	$avatar_img_three = isset($atts['avatar_img_three']) ? $atts['avatar_img_three'] : '';

	$plus_icon = isset($atts['plus_icon']) ? $atts['plus_icon'] : '';
	$upload_button_link = isset($atts['upload_button_link']) ? $atts['upload_button_link'] : '';
	$hiring_button_link = isset($atts['hiring_button_link']) ? $atts['hiring_button_link'] : '';

	$jobcircle_page = isset($atts['jobcircle_page']) ? $atts['jobcircle_page'] : '';

	$custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
	ob_start()
		?>
	<style>
		.visual-theme-14 {
			font-family: "DM Sans", sans-serif;
			background-image: url(<?php echo jobcircle_esc_the_html($main_bg_img) ?>);
		}
	</style>
	<div class="visual-block visual-theme-14 bg-dark-blue pt-70 pt-md-110 pt-xl-150 pb-lg-55 text-white">
		<div class="container position-relative">
			<div class="row justify-content-between">
				<div class="col-12 col-lg-7 col-xl-6 position-relative">
					<!-- visual textbox -->
					<div class="visual-textbox">
						<?php
						if (!empty($title) || !empty($span_title)) {
							?>
							<h1><span class="text-green">
									<?php echo jobcircle_esc_the_html($title) ?>
								</span> <br>
								<?php echo jobcircle_esc_the_html($span_title) ?>
							</h1>
							<?php
						}
						?>
						<?php
						if (!empty($disc)) {
							?>
							<p>
								<?php echo jobcircle_esc_the_html($disc) ?>
							</p>
							
							<?php
						}
						$job_select_page = isset($jobcircle_framework_options['job_select_page']) ? $jobcircle_framework_options['job_select_page'] : '';
						$job_select_page_id = jobcircle_get_page_id_from_name($job_select_page);
						$job_select_page_url = get_permalink($job_select_page_id);
						?>
						<!-- search form -->
						<form class="form-search" action="<?php echo esc_url($job_select_page_url); ?>" method="get">
							<div class="fields-holder text-white d-flex flex-wrap flex-md-nowrap">
								<div class="form-group">
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php echo esc_html_e('Job Title, Keyword.....', 'jobcircle-frame') ?>">

								</div>
								<div class="form-group">
									<span class="icon mt-10"><img class="y4white" src="<?php echo Jobcircle_Plugin::root_url()?>/images/bars.png" width = "20" alt ="category icon"></span>
									<svg class="whitecolor"><filter id="colorize"><feColorMatrix type="matrix" values="1 0 0 0 1  0 1 0 0 1  0 0 1 0 1  0 0 0 1 0"/></filter></svg>
									<select class="select2" name="job_category"
										data-placeholder="<?php echo esc_html_e('Choose Category', 'jobcircle-frame') ?>">
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
												<option value="<?php echo jobcircle_esc_the_html($cat_term->slug) ?>"
													id="cat-<?php echo jobcircle_esc_the_html($cat_term->term_id) ?>">
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
							<?php
							if (!empty($search_button)) {
								?>
								<button class="btn btn-green btn-sm" type="submit"><span class="btn-text">
										<?php echo jobcircle_esc_the_html($search_button) ?>
									</span></button>
								<?php
							}
							?>
						</form>

						<span class="search_result">
							<strong>
								<?php echo esc_html_e('Searches :', 'jobcircle-frame') ?>
							</strong>
							
						<?php
//$include_category_ids = array(72, 103, 74);

// Fetch the terms for the custom taxonomy 'job_featured'
$terms = get_terms(
    array(
        'taxonomy' => 'job_category',
        'post_type' => 'jobs',
        'hide_empty' => false,
        'parent' => 0,
        //'include' => $include_category_ids,
    )
);
$counter = 0;
foreach ($terms as $key => $term) {
    // Check if it's not the last category
    if ($counter < 3) {
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
        if (!empty($jobcircle_page_url) || !empty($term)) {
            ?>
            <a class="cat-color-theme-14"
                href="<?php echo esc_url($jobcircle_page_url); ?>?job_category=<?php echo jobcircle_esc_the_html($term->slug) ?>">
                <?php
                echo $term->name;
                // If it's the last category, add ' after the category name
                echo ($counter == 2) ? "" : ', ';
                ?>
            </a>
            <?php
        }
    }

    // Increment the counter
    $counter++;
}
?>

						</span>

						<div class="searches_holder">
							<?php
							if (!empty($upload_button_link)) {
								?>
								<a class="btn_upload" href="<?php echo jobcircle_esc_the_html($upload_button_link) ?>">
									<?php
							}

							if (!empty($upload_cv)) {
								?>
									<i class="jobcircle-icon-upload-cloud icon"></i>
									<span class="text">
										<?php echo jobcircle_esc_the_html($upload_cv) ?>
									</span>
									<?php
							}
							?>
							</a>
							<?php
							if (!empty($hiring_button_link) || !empty($hiring)) {
								?>
								<a class="btn_hire" href="<?php echo jobcircle_esc_the_html($hiring_button_link) ?>">
									<?php echo jobcircle_esc_the_html($hiring) ?>
								</a>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="visual-image">
			<?php
			if (!empty($img)) {
				?>
				<img src="<?php echo esc_url_raw($img) ?>" alt="img">
				<?php
			}
			?>
			<div class="users-box">
				<?php
				if (!empty($candidates)) {
					?>
					<strong class="title">
						<?php echo jobcircle_esc_the_html($candidates) ?>
					</strong>
					<?php
				}
				?>
				<ul class="users-list">
					<?php
					if (!empty($avatar_img_one)) {
						?>
						<li><img src="<?php echo esc_url_raw($avatar_img_one) ?>" width="60" height="60" alt="User"></li>
						<?php
					}
					?>
					<?php
					if (!empty($avatar_img_two)) {
						?>
						<li><img src="<?php echo esc_url_raw($avatar_img_two) ?>" width="60" height="60" alt="User"></li>
						<?php
					}
					?>
					<?php
					if (!empty($avatar_img_three)) {
						?>
						<li><img src="<?php echo esc_url_raw($avatar_img_three) ?>" width="60" height="60" alt="User"></li>
						<?php
					}
					?>
					<?php
					if (!empty($plus_icon)) {
						?>
						<li><i class="<?php echo jobcircle_esc_the_html($plus_icon) ?>"></i></li>
						<?php
					}
					?>
				</ul>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('postings_here_for_you', 'jobcircle_postings_here_for_you_frontend');