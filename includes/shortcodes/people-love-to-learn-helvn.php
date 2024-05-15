<?php
function jobcircle_people_learn_helevn()
{
	vc_map(
		array(
			'name' => __('People Learn H Eleven'),
			'base' => 'jc_people_learn_helevn',
			'category' => __('Job Circle'),
			'params' => array(
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
					'heading' => __('Description'),
					'param_name' => 'desc',
				),
				//group
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'img_multi',
					'params' => array(
						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Upload Image'),
							'param_name' => 'emp_img',
						),

					),
				),

				//GROUP 2
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'second_multi',
					'params' => array(


						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Title'),
							'param_name' => 'titl',
						),
						array(
							'type' => 'textarea',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Description'),
							'param_name' => 'disce',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Name'),
							'param_name' => 'name',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Designation'),
							'param_name' => 'ceo',
						),


					),
				)
			)


		)
	);
}
add_action('vc_before_init', 'jobcircle_people_learn_helevn');
// Frontend Coding 
function jobcircle_people_learn_helevn_front($atts, $content)
{
	$atts = shortcode_atts(
		array(

			'title' => '',
			'desc' => '',
			//For Multi
			'img_multi' => '',
			'second_multi' => '',

		), $atts, 'jobcircle_people_learn_helevn'
	);

	$title = isset($atts['title']) ? $atts['title'] : '';
	$desc = isset($atts['desc']) ? $atts['desc'] : '';

	ob_start();
	?>
	<section
		class="section section-theme-6 learning-block pt-30 pt-md-50 pt-lg-75 pt-xxl-120 pb-10 pb-md-50 pb-lg-40 pb-xxl-60">
		<div class="container">
			<div class="row mb-10 mb-lg-60">
				<div class="col-12 col-md-8">
					<?php if (!empty($title)) { ?>
						<h2>
							<?php echo esc_html($title) ?>
						</h2>
					<?php } ?>
					<?php if (!empty($desc)) { ?>
						<p>
							<?php echo esc_textarea($desc) ?>
						</p>
					<?php } ?>
				</div>
				<div class="col-12 col-md-4 d-flex justify-content-md-end align-items-start">
					<a href="#" class="reviews-link">
						<div class="ratings-info">
							<i class="jobcircle-icon-star"></i>
							<span>
								<?php esc_html_e('4.9', 'jobcircle-frame') ?>
							</span>
						</div>
						<span class="txt">
							<?php esc_html_e('494 Reviews', 'jobcircle-frame') ?>
						</span>
					</a>

				</div>
			</div>
			<div class="row">
				<div class="col-12 learning-sliders">
					<div class="thumbs-list">
						<?php
						$lm_team_list = vc_param_group_parse_atts($atts['img_multi']);
						foreach ($lm_team_list as $key => $value) {
							$emp_img = isset($value['emp_img']) ? $value['emp_img'] : '';

							?>
							<?php if (!empty($emp_img)) { ?>
								<div class="thumbnail"><img src="<?php echo esc_url_raw($emp_img) ?>" alt="image"></div>
							<?php } ?>
							<?php
						}
						?>

					</div>
					<div class="text-info-slider">
						<?php
						$lm_team_list = vc_param_group_parse_atts($atts['second_multi']);
						if (!empty($lm_team_list)) {
							foreach ($lm_team_list as $key => $value) {

								$titl = isset($value["titl"]) ? $value["titl"] : '';
								$disce = isset($value["disce"]) ? $value["disce"] : '';
								$name = isset($value['name']) ? $value['name'] : '';
								$ceo = isset($value['ceo']) ? $value['ceo'] : '';

								?>

								<div class="slick-box">
									<blockquote class="text-info-frm">
										<?php if (!empty($titl)) { ?>
											<h3>
												<?php echo esc_html($titl) ?>
											</h3>
										<?php } ?>
										<?php if (!empty($disce)) { ?>
											<p>
												<?php echo esc_textarea($disce) ?>
											</p>
										<?php } ?>
										<cite class="d-flex align-items-center">
											<?php if (!empty($name)) { ?>
												<strong class="title">
													<?php echo esc_html($name) ?>
												</strong>
											<?php } ?>
											<?php if (!empty($ceo)) { ?>
												<span class="designation">
													<?php echo esc_html($ceo) ?>
												</span>
											<?php } ?>
										</cite>
									</blockquote>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode('jc_people_learn_helevn', 'jobcircle_people_learn_helevn_front');