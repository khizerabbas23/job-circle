<?php
function helpfull_question()
{
	vc_map(
		array(
			'name' => __('Helpful Question 14'),
			'base' => 'helpfull_question',
			'category' => __('theme14'),
			'params' => array(
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
					'heading' => __('Title'),
					'param_name' => 'title',
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
					'heading' => __('Get your Matched'),
					'param_name' => 'get_matched',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Find your dream '),
					'param_name' => 'find_dream',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Upload Button Link'),
					'param_name' => 'upload_button_link',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Upload Button'),
					'param_name' => 'upload_button',
				),
				//group
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'helpfull_question_multi',
					'params' => array(
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Heading'),
							'param_name' => 'head',
						),
						array(
							'type' => 'textarea',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Paragraph'),
							'param_name' => 'para',
						),
					)
				)
			),
		)
	);
}
add_action('vc_before_init', 'helpfull_question');

//welcome Massage frontend
function helpfull_question_frontend($atts, $content)
{
	$atts = shortcode_atts(
		array(
			'disc' => '',
			'title' => '',
			'img' => '',
			'get_matched' => '',
			'find_dream' => '',
			'upload_button_link' => '',
			'upload_button' => '',
			'helpfull_question_multi' => '',

		), $atts, 'helpfull_question'
	);

	$disc = isset($atts['disc']) ? $atts['disc'] : '';
	$title = isset($atts['title']) ? $atts['title'] : '';
	$img = isset($atts['img']) ? $atts['img'] : '';
	$get_matched = isset($atts['get_matched']) ? $atts['get_matched'] : '';
	$find_dream = isset($atts['find_dream']) ? $atts['find_dream'] : '';
	$upload_button_link = isset($atts['upload_button_link']) ? $atts['upload_button_link'] : '';
	$upload_button = isset($atts['upload_button']) ? $atts['upload_button'] : '';
	$section_discription = isset($atts['section_discription']) ? $atts['section_discription'] : '';
	$custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

	ob_start()
		?>
	<section class="section section-theme-14 faq_block featured_jobp">
		<div class="container">
			<div class="row mb-50 mb-lg-115 d-flex align-items-center">
				<div class="col-12 col-md-7 col-lg-8">
					<!-- Section header -->
					<header class="section-header d-flex flex-column mb-15 mb-md-30 mb-xl-40">
						<?php
						if (!empty($disc)) {
							?>
							<p>
								<?php echo esc_html($disc) ?>
							</p>
							<?php
						}
						?>
						<?php
						if (!empty($title)) {
							?>
							<h2 class="help_question_heading">
								<?php echo esc_html($title) ?>
							</h2>
							<?php
						}
						?>
					</header>
					<div class="accordion_holder" id="accordionExample">
						<ul class="accordion_list">
							<?php
							$lm_team_list = vc_param_group_parse_atts($atts['helpfull_question_multi']);
							$counter = 1;
							if (!empty($lm_team_list)) {
								foreach ($lm_team_list as $key => $value) {
									$head = isset($value["head"]) ? $value["head"] : '';
									$para = isset($value["para"]) ? $value["para"] : '';
									if ($counter == 1) {
										$active = '';
										$collapse = 'collapseOne';
										$myclass = 'collapsed';
									} elseif ($counter == 2) {
										$active = 'show';
										$collapse = 'collapseTwo';
										$myclass = '';
									} elseif ($counter == 3) {
										$active = '';
										$collapse = 'collapseThree';
										$myclass = 'collapsed';
									} elseif ($counter == 4) {
										$active = '';
										$collapse = 'collapseFour';
										$myclass = 'collapsed';

									} elseif ($counter == 5) {
										$active = '';
										$collapse = 'collapseFive';
										$myclass = 'collapsed';

									}
									?>
									<li id="headingOne">
										<button type="button" class="<?php echo jobcircle_esc_the_html($myclass) ?> align-items-start"
											data-bs-toggle="collapse" data-bs-target="#<?php echo jobcircle_esc_the_html($collapse) ?>" aria-expanded="true"
											aria-controls="collapseOne">
											<i class="icon"></i>
											<?php
											if (!empty($head)) {
												?>
												<strong class="title">
													<?php echo esc_html($head) ?>
												</strong>
												<?php
											}
											?>
										</button>
										<div id="<?php echo jobcircle_esc_the_html($collapse) ?>" class="accordion-collapse collapse <?php echo jobcircle_esc_the_html($active) ?>"
											aria-labelledby="headingOne" data-bs-parent="#accordionExample">
											<div class="acc-slide">
												<?php
												if (!empty($para)) {
													?>
													<p>
														<?php echo esc_textarea($para) ?>
													</p>
													<?php
												}
												?>
											</div>
										</div>
									</li>
									<?php
									$counter++;
								}
								?>
							</ul>
						</div>
					</div>
					<div class="col-12 col-md-5 col-lg-4">
						<div class="image-wrap">
							<?php
							if (!empty($img)) {
								?>
								<img src=" <?php echo esc_url_raw($img) ?>" alt="img">
								<?php
							}
							?>
						</div>
						<div class="finder">
							<?php
							if (!empty($get_matched)) {
								?>
								<strong class="title">
									<?php echo esc_html($get_matched) ?>
								</strong>
								<?php
							}
							?>
							<?php
							if (!empty($find_dream)) {
								?>
								<p>
									<?php echo esc_html($find_dream) ?>
								</p>
								<?php
							}
							?>
							<?php
							if (!empty($upload_button_link)) {
								?>
								<a class="btn_upload" href="<?php echo esc_html($upload_button_link) ?>">
									<?php
							}
							?>
									<i class="jobcircle-icon-upload-cloud icon"></i>
								<?php
								if (!empty($upload_button)) {
									?>
									<span class="text">
										<?php echo esc_html($upload_button) ?>
									</span>
									<?php
								}
								?>
							</a>
						</div>
					</div>
				</div>
			</div>
			</div>
		</section>
		<?php
		return ob_get_clean();
							}
}
add_shortcode('helpfull_question', 'helpfull_question_frontend');