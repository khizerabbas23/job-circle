<?php
function jobcircle_get_over_expert()
{

	vc_map(
		array(
			'name' => __('Need Somthing Done H16'),
			'base' => 'jobcircle_get_over_expert',
			'category' => __('Job Circle'),
			'params' => array(
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('First Image'),
					'param_name' => 'f_image',
				),
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Second Image'),
					'param_name' => 's_image',
				),
				array(
					'type' => 'jobcircle_browse_img',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Third Image'),
					'param_name' => 'th_image',
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
					'heading' => __('Sub Title'),
					'param_name' => 'sub_title',
				),
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Description'),
					'param_name' => 'desc',
				),
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Url'),
					'param_name' => 'url',
				),
				//GROUP 1
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'multi_portion',
					'params' => array(
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Points'),
							'param_name' => 'points',
						),

					),
				)
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_get_over_expert');

// Frontend Coding 

function jobcircle_get_over_expert_front($atts, $content)
{

	$atts = shortcode_atts(
		array(

			'title' => '',
			'sub_title' => '',
			'desc' => '',
			'url' => '',
			'f_image' => '',
			's_image' => '',
			'th_image' => '',

			'multi_portion' => '',

		),
		$atts,
		'jobcircle_get_over_expert'
	);

	$title = isset($atts['title']) ? $atts['title'] : '';
	$sub_title = isset($atts['sub_title']) ? $atts['sub_title'] : '';
	$desc = isset($atts['desc']) ? $atts['desc'] : '';
	$f_image = isset($atts['f_image']) ? $atts['f_image'] : '';
	$s_image = isset($atts['s_image']) ? $atts['s_image'] : '';
	$th_image = isset($atts['th_image']) ? $atts['th_image'] : '';
	$url = isset($atts['url']) ? $atts['url'] : '';

	ob_start();

	?>
	<section class="section section-theme-16 info_area theme_seven_sec theme_sevenb page-theme-16 remote_jobt">
		<div class="container">
			<div class="get_over">
				<div class="left_align">
					<div class="image-holder first">
						<?php
						if (!empty($f_image)) {
							?>
							<img src="<?php echo esc_url_raw($f_image) ?>" alt="img">
							<?php
						}
						?>
					</div>
					<div class="image-holder second">
						<?php
						if (!empty($s_image)) {
							?>
							<img src="<?php echo esc_url_raw($s_image) ?>" alt="img">
							<?php
						}
						?>
					</div>
				</div>
				<div class="right_align">
					<div class="section-header">
						<?php
						if (!empty($title)) {
							?>
							<p>
								<?php echo esc_html($title) ?>
							</p>
							<?php
						}
						if (!empty($sub_title)) {
							?>
							<h2 class="th-font">
								<?php echo esc_html($sub_title) ?>
							</h2>
							<?php
						}
						?>
					</div>
					<div class="wrap-holder">
						<div class="image-holder third">
							<?php
							if (!empty($th_image)) {
								?>
								<img src="<?php echo esc_url_raw($th_image) ?>" alt="img">
								<?php
							}
							?>
						</div>
						<div class="detail">
							<?php
							if (!empty($desc)) {
								?>
								<p>
									<?php echo esc_html($desc) ?>
								</p>
								<?php
							}
							?>
							<ul class="checklist">
								<?php
								$lm_team_list = vc_param_group_parse_atts($atts['multi_portion']);

								foreach ($lm_team_list as $key => $value) {

									$points = isset($value["points"]) ? $value["points"] : '';

									?>
									<?php
									if (!empty($points)) {
										?>
										<li>
											<?php echo esc_html($points) ?>
										</li>
										<?php
									}
									?>
									<?php
								}
								?>
							</ul>
							<?php
							if (!empty($url)) {
								?>
								<a class="btn btn-pink btn-sm" href="<?php echo jobcircle_esc_the_html($url) ?>"><span class="btn-text">
										<?php echo esc_html_e('Post a Job', 'jobcircle-frame') ?>
									</span></a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php

	return ob_get_clean();
}
add_shortcode('jobcircle_get_over_expert', 'jobcircle_get_over_expert_front');