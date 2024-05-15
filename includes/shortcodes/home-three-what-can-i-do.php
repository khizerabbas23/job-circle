<?php
function jobcircle_what_can_i_do()
{

	vc_map(
		array(
			'name' => __('What Can I Do'),
			'base' => 'what_can_i_do',
			'category' => __('Job Circle'),
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Title'),
					'param_name' => 'main_title',
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Span Title'),
					'param_name' => 'spn_title',
				),
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Description'),
					'param_name' => 'desc',
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
					'param_name' => 'subject_multi',
					'params' => array(
						array(
							'type' => 'iconpicker',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Icon'),
							'param_name' => 'frst_icn',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Title'),
							'param_name' => 'frst_title',
						),
						array(
							'type' => 'textarea',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Description'),
							'param_name' => 'frst_description',
						),
					),
				),
				//GROUP 2
				array(
					'type' => 'param_group',
					'value' => '',
					'param_name' => 'graph_multi',
					'params' => array(
						array(
							'type' => 'iconpicker',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Icon'),
							'param_name' => 'scnd_icn',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Count Number'),
							'param_name' => 'cnt_number',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('K or M Number'),
							'param_name' => 'k_or_m_num',
						),
						array(
							'type' => 'textfield',
							'holder' => 'div',
							'class' => '',
							'heading' => __('Title'),
							'param_name' => 'scnd_title',
						),

					),
				)
			)
		)
	);
}
add_action('vc_before_init', 'jobcircle_what_can_i_do');
// Frontend Coding 

function jobcircle_what_can_i_do_front($atts, $content)
{

	$atts = shortcode_atts(
		array(

			'main_title' => '',
			'spn_title' => '',
			'desc' => '',
			'img' => '',
			'subject_multi' => '',
			'graph_multi' => '',

		),
		$atts,
		'jobcircle_what_can_i_do'
	);

	$main_title = isset($atts['main_title']) ? $atts['main_title'] : '';
	$spn_title = isset($atts['spn_title']) ? $atts['spn_title'] : '';
	$desc = isset($atts['desc']) ? $atts['desc'] : '';
	$img = isset($atts['img']) ? $atts['img'] : '';

	ob_start();
	?>
	<section class="section section-theme-2 featured-joblix-block pt-35 pt-md-50 pt-lg-75 pb-35 pb-md-50 pb-lg-65">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-6 mb-15 mb-md-30 mb-lg-0">
					<!-- Section header -->
					<header class="section-header text-center text-lg-start mb-40 mb-md-45">
						<?php if (!empty($main_title) || !empty($spn_title)) {
							?>
							<h2>
								<?php echo esc_html($main_title, 'jobcircle-frame'); ?> <span class="text-outlined">
									<?php echo esc_html($spn_title, 'jobcircle-frame'); ?>
								</span>
							</h2>
							<?php
						} ?>
						<?php if (!empty($desc)) {
							?>
							<p>
								<?php echo esc_textarea($desc); ?>
							</p>
							<?php
						} ?>
					</header>
					<div class="video-box-wrap mb-20 mb-lg-0">
						<div class="video-box ratio ratio-16x9">
							<?php if (!empty($img)) {
								?>
								<img src="<?php echo esc_url_raw($img); ?>" alt="Video Image">
								<?php
							} ?>
							<a href="#" class="button-play"></a>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 mb-15 mb-md-30 mb-lg-0">
					<ul class="joblix-list">
						<?php
						$lm_team_list = vc_param_group_parse_atts($atts['subject_multi']);

						foreach ($lm_team_list as $key => $value) {

							$frst_icn = isset($value["frst_icn"]) ? $value["frst_icn"] : '';
							$frst_title = isset($value["frst_title"]) ? $value["frst_title"] : '';
							$frst_description = isset($value["frst_description"]) ? $value["frst_description"] : '';

							?>
							<li>
								<div class="box">
									<div class="icon-box">
										<?php if (!empty($frst_icn)) {
											?>
											<i class="<?php echo esc_html($frst_icn) ?>"></i>
											<?php
										} ?>
									</div>
									<div class="textbox">
										<?php if (!empty($frst_title)) {
											?>
											<strong class="h5">
												<?php echo esc_html($frst_title); ?>
											</strong>
											<?php
										} ?>
										<?php if (!empty($frst_description)) {
											?>
											<p>
												<?php echo esc_textarea($frst_description); ?>
											</p>
											<?php
										} ?>
									</div>
								</div>
							</li>
							<?php
						} ?>
					</ul>
				</div>
			</div>
			<div class="row">
				<div
					class="counters-block d-flex flex-wrap justify-content-center justify-content-md-between mt-lg-35 pt-35 pt-lg-60 pt-xl-85 mb-0 pb-lg-20 pb-xl-40">
					<?php

					$lm_team_list = vc_param_group_parse_atts($atts['graph_multi']);
					if (!empty($lm_team_list)) {
						foreach ($lm_team_list as $key => $value) {

							$scnd_icn = isset($value["scnd_icn"]) ? $value["scnd_icn"] : '';
							$cnt_number = isset($value["cnt_number"]) ? $value["cnt_number"] : '';
							$k_or_m_num = isset($value["k_or_m_num"]) ? $value["k_or_m_num"] : '';

							$scnd_title = isset($value["scnd_title"]) ? $value["scnd_title"] : '';

							?>
							<div class="counter-box">
								<div class="icon">
									<?php if (!empty($scnd_icn)) {
										?>
										<i class="<?php echo esc_html($scnd_icn) ?>"></i>
										<?php
									} ?>
								</div>
								<div class="counter-stats">
									<strong class="numbers h2">
										<span data-purecounter-duration="0" data-purecounter-start="0"
											data-purecounter-end="<?php echo esc_html($cnt_number) ?>" data-purecounter-once="true"
											class="purecounter"><?php echo esc_html($cnt_number) ?></span><?php echo esc_html($k_or_m_num) ?>
									</strong>
									<?php if (!empty($scnd_title)) {
										?>
										<span class="subtext">
											<?php echo esc_html($scnd_title) ?>
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

	$html = ob_get_clean();
	return $html;
}
add_shortcode('what_can_i_do', 'jobcircle_what_can_i_do_front');