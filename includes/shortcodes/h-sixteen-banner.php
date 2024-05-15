<?php
function jobcircle_home_sixteen()
{
	vc_map(
		array(
			'name' => __('Home Banner 16'),
			'base' => 'jobcircle_home_sixteen',
			'category' => __('Job Circle'),
			'params' => array(
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
					'heading' => __('Paragraph'),
					'param_name' => 'para',
				),

				//Group
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'multi_section',
					'params' => array(
						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Image'),
							'param_name' => 'image',
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
							'heading' => __('Description'),
							'param_name' => 'desc',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Url'),
							'param_name' => 'url',
						),

					),
				),
			),
		)
	);
}
add_action('vc_before_init', 'jobcircle_home_sixteen');
// Frontend Coding 
function jobcircle_home_sixteen_frontend($atts, $content)
{
	global $jobcircle_framework_options;
	$atts = shortcode_atts(
		array(
			'title' => '',
			'para' => '',
			'main_bg_img' => '',

			'multi_section' => '',
		),
		$atts, 'jobcircle_home_sixteen'
	);

	$title = isset($atts['title']) ? $atts['title'] : '';
	$para = isset($atts['para']) ? $atts['para'] : '';
	$main_bg_img = isset($atts['main_bg_img']) ? $atts['main_bg_img'] : '';

	ob_start();
	?>
	<div class="visual-block pb-45 pb-md-55 visal-theme-16 page-theme-16"
		style="background-image: url('<?php echo jobcircle_esc_the_html($main_bg_img) ?>');">
		<div class="container position-relative">
			<div class="row justify-content-between align-items-center">
				<div class="col-12 pb-xl-30">
					<!-- visual textbox -->
					<div class="visual-textbox text-black">
						<?php
						if (!empty($title)) {
							?>
							<h1 class="">
								<?php echo esc_html($title) ?>
							</h1>
							<?php
						}
						if (!empty($para)) {
							?>
							<p>
								<?php echo esc_html($para) ?>
							</p>
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
									<i class="jobcircle-icon-search icon"></i>
									<input class="form-control" type="search" name="keyword"
										placeholder="<?php esc_html_e('Job Title, Keyword.....', 'jobcircle-frame') ?>">

								</div>
				            <div class="form-group">
                                    <i class="jobcircle-icon-map-pin icon"></i>
                                    <input class="form-control" name="location"
										placeholder="<?php esc_html_e('City and Postal Code', 'jobcircle-frame') ?>">
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
							<button class="btn btn-pink btn-sm " type="submit">
								<span class="btn-text">
									<?php echo esc_html_e('Find Jobs', 'jobcircle-frame') ?>
								</span>
							</button>
						</form>
						<ul class="quick_links">
							<?php
							$lm_team_list = vc_param_group_parse_atts($atts['multi_section']);

							foreach ($lm_team_list as $key => $value) {
								$image = isset($value['image']) ? $value['image'] : '';
								$heading = isset($value['heading']) ? $value['heading'] : '';
								$desc = isset($value['desc']) ? $value['desc'] : '';
								$url = isset($value['url']) ? $value['url'] : '';
								?>
								<li>
									<a href="<?php echo esc_html($url) ?>">
										<div class="icon-holder">
											<?php
											if (!empty($image)) {
												?>
												<img src="<?php echo esc_url_raw($image) ?>" alt="img">
												<?php
											}
											?>
										</div>
										<div class="text-holder">
											<?php
											if (!empty($heading)) {
												?>
												<strong class="h5">
													<?php echo esc_html($heading) ?>
												</strong>
												<?php
											}
											if (!empty($desc)) {
												?>
												<p>
													<?php echo esc_html($desc) ?>
												</p>
												<?php
											}
											?>
										</div>
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
	$html = ob_get_clean();
	return $html;
}
add_shortcode('jobcircle_home_sixteen', 'jobcircle_home_sixteen_frontend');