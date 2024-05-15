<?php
function jobcircle_explore_a_faster()
{

	vc_map(

		array(
			'name' => __('Explore A Faster'),
			'base' => 'jc_explore_a_faster',
			'category' => __('Job Circle'),
			'params' => array(
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Background Image'),
					'param_name' => 'bg_img',
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
					'heading' => __('Span Title'),
					'param_name' => 'spn_title',
				),
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Image'),
					'param_name' => 'img',
				),


				//group
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'frst_multi',
					'params' => array(


						array(
							'type' => 'jobcircle_browse_img',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Image'),
							'param_name' => 'mlti_img',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Title'),
							'param_name' => 'multi_title',
						),
						array(
							'type' => 'textarea',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Description'),
							'param_name' => 'description',
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
							'heading' => __('Count Numbers'),
							'param_name' => 'number',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Extra Number'),
							'param_name' => 'extra_number',
						),

						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Title'),
							'param_name' => 'malti_titles',
						),


					),
				)
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_explore_a_faster');


// Frontend Coding 

function jobcircle_explore_a_faster_front($atts, $content)
{

	$atts = shortcode_atts(
		array(

			'bg_img' => '',
			'title' => '',
			'spn_title' => '',
			'img' => '',

			'frst_multi' => '',
			'second_multi' => '',

		),
		$atts,
		'jobcircle_explore_a_faster'
	);

	$bg_img = isset($atts['bg_img']) ? $atts['bg_img'] : '';
	$title = isset($atts['title']) ? $atts['title'] : '';
	$spn_title = isset($atts['spn_title']) ? $atts['spn_title'] : '';
	$img = isset($atts['img']) ? $atts['img'] : '';

	ob_start();

	?>
	<section
		class="section section-theme-8 explore-jobs-block bg-light-sky pt-45 pt-md-50 pt-lg-75 pt-xl-100 pt-xxl-135 pb-0 mb-md-80 mb-lg-120 mb-xl-150 mb-xxxl-190"
		style="background-image: url(<?php echo esc_url_raw($bg_img) ?>);">
		<div class="container">
			<div class="row pb-35 pb-md-50 pb-lg-75 pb-xl-100">
				<div class="col-12 col-lg-6 mb-15 mb-md-30 mb-lg-0">
					<!-- Section header -->
					<header class="section-header text-center text-lg-start mb-40 mb-md-45">
						<?php
						if (!empty($title) || !empty($spn_title)) {
							?>
							<h2>
								<?php echo esc_html($title) ?> <span class="text-outlined">
									<?php echo esc_html($spn_title) ?>
								</span>
							</h2>
							<?php
						} ?>
					</header>
					<ul class="explore-list">
						<?php

						$lm_team_list = vc_param_group_parse_atts($atts['frst_multi']);

						foreach ($lm_team_list as $key => $value) {

							$mlti_img = isset($value["mlti_img"]) ? $value["mlti_img"] : '';
							$multi_title = isset($value["multi_title"]) ? $value["multi_title"] : '';
							$description = isset($value["description"]) ? $value["description"] : '';

							?>
							<li>
								<div class="box">
									<div class="icon-box">
										<?php
										if (!empty($mlti_img)) {
											?>
											<img src="<?php echo esc_url_raw($mlti_img) ?>" width="43" height="46"
												alt="Create your resume">
											<?php
										} ?>
									</div>
									<div class="textbox">
										<?php
										if (!empty($multi_title)) {
											?>
											<strong class="h5">
												<?php echo esc_html($multi_title) ?>
											</strong>
											<?php
										} ?>
										<?php
										if (!empty($description)) {
											?>
											<p>
												<?php echo esc_textarea($description) ?>
											</p>
											<?php
										} ?>
									</div>
								</div>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
				<div class="col-12 col-lg-6 mb-15 mb-md-30 mb-lg-0">
					<div class="image-holder">
						<?php
						if (!empty($img)) {
							?>
							<img src="<?php echo esc_url_raw($img) ?>" alt="Image Description">
							<?php
						} ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="counters-block d-flex flex-wrap justify-content-center justify-content-md-between">
					<?php


					$lm_team_list = vc_param_group_parse_atts($atts['second_multi']);
					if (!empty($lm_team_list)) {
						foreach ($lm_team_list as $key => $value) {

							$number = isset($value["number"]) ? $value["number"] : '';
							$malti_titles = isset($value["malti_titles"]) ? $value["malti_titles"] : '';
							$extra_number = isset($value["extra_number"]) ? $value["extra_number"] : '';

							?>
							<div class="counter-box">
								<div class="counter-stats">
									<strong class="numbers h2">
										<?php if (!empty($number)) {
											?>
											<span data-purecounter-duration="1" data-purecounter-start="0"
												data-purecounter-end="<?php echo esc_html($number) ?>"<?php	} ?> 
												<?php if (!empty($extra_number)) { ?>data-purecounter-once="true" class="purecounter"><?php esc_html_e('0', 'jobcircle-frame') ?>
											</span><?php echo esc_html($extra_number); ?>
											<?php } ?>
									</strong>
									<?php if (!empty($malti_titles)) {
										?>
										<span class="subtext">
											<?php echo esc_html($malti_titles) ?>
										</span>
										<?php
									} ?>
								</div>
							</div>
							<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</section>
	<?php

	return ob_get_clean();
}
add_shortcode('jc_explore_a_faster', 'jobcircle_explore_a_faster_front');